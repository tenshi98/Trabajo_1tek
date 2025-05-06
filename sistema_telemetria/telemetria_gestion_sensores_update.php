<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                                      Consulta                                                                  */
/**********************************************************************************************************************************/
//variables
$HoraSistema    = hora_actual();
$FechaSistema   = fecha_actual();

//Variable
$SIS_where  = "telemetria_listado.idEstado = 1 ";//solo equipos activos
$SIS_where .= " AND telemetria_listado.id_Geo = 2";//solo los equipos que tengan el seguimiento desactivado
//verifico que sea un administrador
$SIS_where .= " AND telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
if (isset($_GET['idCiudad'])&&$_GET['idCiudad']!=''){
	$SIS_where .= " AND telemetria_listado.idCiudad=".$_GET['idCiudad'];
}
if (isset($_GET['idComuna'])&&$_GET['idComuna']!=''){
	$SIS_where .= " AND telemetria_listado.idComuna=".$_GET['idComuna'];
}
if (isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where .= " AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];
}

//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}

//Se consultan datos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
telemetria_listado.LastUpdateHora,
telemetria_listado.LastUpdateFecha,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.NErrores'.$subquery;
$SIS_join = '
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria';
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

$arrFinalUnimed = array();
foreach ($arrUnimed as $sen) {
	$arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];
}

?>
<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
	<thead>
		<tr role="row">
			<th>Nombre</th>
			<th>Estado</th>
			<th width="160">Acciones</th>
		</tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all">
		<?php foreach ($arrEquipo as $data) {

			/**********************************************/
			//Se resetean
			$in_eq_alertas     = 0;
			$in_eq_fueralinea  = 0;

			/**********************************************/
			//Fuera de linea
			$diaInicio   = $data['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $data['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
			}

			/**********************************************/
			//NErrores
			if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

			/*******************************************************/
			//rearmo
			if($in_eq_alertas>0){
				$danger = 'warning';
				$eq_ok  = '<a href="#" title="Con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
			}elseif($in_eq_fueralinea>0){
				$danger = 'danger';
				$eq_ok  = '<a href="#" title="Fuera de Linea" class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';
			}else{
				$danger = '';
				$eq_ok  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
			}

			?>
			<tr class="odd <?php echo $danger; ?>">
				<td><?php echo $data['Nombre']; ?></td>
				<td><div class="btn-group" ><?php echo $eq_ok; ?></div></td>
				<td>
					<div class="btn-group" style="width: 35px;" >
						<a href="<?php echo 'telemetria_gestion_sensores_view_equipo.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>						
					</div>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	var marcadores_ex = [
		<?php
		$in=0;
		foreach ($arrEquipo as $data) {
			$explanation = "<div class='iw-subTitle'>Equipo: ".$data['Nombre']."</div>";
			$explanation .= '<p>'.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
			$explanation .= "<div class='iw-subTitle'>Sensores: </div><p>";
			for ($i = 1; $i <= $data['cantSensores']; $i++) {
				//Unidad medida
				$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
				//cadena
				if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades_decimales_justos($data['SensoresMedActual_'.$i]).$unimed;}else{$xdata='Sin Datos';}
				$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
			}
			$explanation .= '</p>';

			if($in==0){$in=1;}else{echo ',';} ?>
			{
				contenido: 	"<div id='iw-container'>" +
							"<div class='iw-title'>Datos</div>" +
							"<div class='iw-content'>" +
							"<?php echo $explanation; ?>" +
							"</div>" +
							"<div class='iw-bottom-gradient'></div>" +
							"</div>"
			}
		<?php } ?>
	];
</script>

<script>
	$(document).ready(function(){
		//Examples of how to assign the Colorbox event to elements
		$(".iframe").colorbox({iframe:true, width:"80%", height:"95%"});
		$(".callbacks").colorbox({
			onOpen:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onOpen: colorbox is about to open.'});},
			onLoad:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onLoad: colorbox has started to load the targeted content.'});},
			onComplete:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onComplete: colorbox has displayed the loaded content.'});},
			onCleanup:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onCleanup: colorbox has begun the close process.'});},
			onClosed:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onClosed: colorbox has completely closed.'});}
		});

		//Example of preserving a JavaScript event for inline calls.
		$("#click").click(function(){
			$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});
</script>
