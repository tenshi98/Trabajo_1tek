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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                      Consulta                                                                  */
/**********************************************************************************************************************************/
//defino variables
$idTipoUsuario  = $_SESSION['usuario']['zona']['idTipoUsuario'];
$idSistema      = $_SESSION['usuario']['zona']['idSistema'];
$idUsuario      = $_SESSION['usuario']['zona']['idUsuario'];
if(isset($_SESSION['usuario']['zona']['id_Geo'])&&$_SESSION['usuario']['zona']['id_Geo']!=''){
	$id_Geo = $_SESSION['usuario']['zona']['id_Geo'];
}else{
	$id_Geo = 1;//seguimiento activo
}
//condicionales
if(isset($_GET['idZona'])&&$_GET['idZona']!=''){
	//Variables
	$idZona  = $_GET['idZona'];
	//redefino la variable temporal de la zona
	$_SESSION['usuario']['zona']['idZona'] = $idZona;
}else{
	$idZona  = $_SESSION['usuario']['zona']['idZona'];
}

/************************************************/
//se traen todas las zonas
$arrZonas = array();
$arrZonas = db_select_array (false, 'idZona, Nombre', 'vehiculos_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

/************************************************/
//numero sensores equipo
$N_Maximo_Sensores = 10;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}
//Listar los equipos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.NDetenciones,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.GeoErrores,
telemetria_listado.NErrores'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idEstado = 1';                //solo equipos activos
$SIS_where.= ' AND telemetria_listado.id_Geo = '.$id_Geo;       //solo los equipos que tengan el seguimiento activado
$SIS_where.= ' AND telemetria_listado.idTab = '.$_GET['idTab']; //Filtro de los tab
//Filtro el sistema al cual pertenece
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){ $SIS_where.= ' AND telemetria_listado.idSistema = '.$idSistema;}
//Filtro la zona si existe
if(isset($idZona)&&$idZona!=''&&$idZona!=9999){       $SIS_where.= ' AND telemetria_listado.idZona = '.$idZona;}
//Filtro por el tipo de usuario
if(isset($idTipoUsuario)&&$idTipoUsuario!=1&&isset($idUsuario)&&$idUsuario!=0){
	$SIS_join .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where.= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
}
$SIS_order = 'telemetria_listado.Nombre ASC';
//Realizo la consulta
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

?>

<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
	<thead>
		<tr role="row">
			<th colspan="7">
				<div class="field">
					<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >
						<option value="9999" <?php if($idZona==9999){ echo 'selected="selected"';} ?>>Todas las Zonas</option>
						<?php foreach ( $arrZonas as $select ) {
							$selected = '';
							if($idZona==$select['idZona']){
								$selected = 'selected="selected"';
							}
							echo '<option value="'.$select['idZona'].'" '.$selected.' >'.$select['Nombre'].'</option>';
						} ?>
					</select>
				</div>
			</th>
		</tr>
		<?php echo widget_sherlock(1, 7, 'TableFiltered'); ?>
		<?php if(isset($_GET['idTab'])&&$_GET['idTab']==1){ ?>
			<tr role="row">
				<th></th>
				<th>Equipo</th>
				<th>Velocidad (km/h)</th>
				<th>Estanque (%)</th>
				<th>F. izq (l/min)</th>
				<th>F. der (l/min)</th>
				<th></th>
			</tr>
		<?php } ?>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
		<?php

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$nicon          = 0;

		foreach ($arrEquipo as $data) {

			/**********************************************/
			//Se resetean
			$in_eq_alertas     = 0;
			$in_eq_fueralinea  = 0;
			$in_eq_fueraruta   = 0;
			$in_eq_detenidos   = 0;
			$in_eq_gps_fuera   = 0;
			$in_eq_ok          = 1;

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
			//GPS con problemas
			if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){    $in_eq_gps_fuera++; }
			if(isset($data['GeoLatitud'])&&$data['GeoLatitud']==0){   $in_eq_gps_fuera++; }
			if(isset($data['GeoLongitud'])&&$data['GeoLongitud']==0){ $in_eq_gps_fuera++; }

			/**********************************************/
			//Equipos Errores
			if($data['NErrores']>0){ $in_eq_alertas++; }

			/**********************************************/
			//Equipos detenidos
			if($data['NDetenciones']>0){ $in_eq_detenidos++; }

			/*******************************************************/
			//rearmo
			if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
			if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
			if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
			if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
			if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

			/*******************************************************/
			//se guardan estados
			$danger = '';
			if($in_eq_detenidos>0){  $danger = '';    $dataex = '<a href="#" title="Equipo Detenido"           class="btn btn-success btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
			if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
			if($in_eq_fueraruta>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo fuera de ruta"      class="btn btn-warning btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
			if($in_eq_gps_fuera>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo sin cobertura GPS"  class="btn btn-info btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
			if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

			/*******************************************************/
			//traspasan los estados
			if($in_eq_ok==1){
				$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
			}else{
				$eq_ok_icon = $dataex;
			}

			/*******************************************************/
			//cadena
			if(isset($data['SensoresMedActual_1'])&&$data['SensoresMedActual_1']<99900){$xdata_1 = Cantidades($data['SensoresMedActual_1'], 2);}else{$xdata_1 = 'Sin Datos';}
			if(isset($data['SensoresMedActual_2'])&&$data['SensoresMedActual_2']<99900){$xdata_2 = Cantidades($data['SensoresMedActual_2'], 2);}else{$xdata_2 = 'Sin Datos';}
			if(isset($data['SensoresMedActual_3'])&&$data['SensoresMedActual_3']<99900){$xdata_3 = Cantidades($data['SensoresMedActual_3'], 2);}else{$xdata_3 = 'Sin Datos';}

			?>
			<tr class="odd <?php echo $danger; ?>">
				<td width="10">
					<div class="btn-group" style="width: 35px;" ><?php echo $eq_ok_icon; ?></div>
				</td>
				<?php if(isset($_GET['idTab'])&&$_GET['idTab']==1){ ?>
					<td>
						<?php echo $data['Nombre']; ?><br/>
						<?php echo fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora']; ?>
					</td>
					<td><?php echo Cantidades($data['GeoVelocidad'], 0); ?> km/h</td>
					<td><?php echo $xdata_3; ?> %</td>
					<td><?php echo $xdata_2; ?> l/min</td>
					<td><?php echo $xdata_1; ?> l/min</td>
				<?php }else{ ?>
					<td colspan="5">
						<?php echo $data['Nombre']; ?><br/>
						<?php echo fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora']; ?>
					</td>
				<?php } ?>

				<td width="10">
					<div class="btn-group" style="width: 70px;" >
						<a href="view_telemetria_registro_ruta.php?view=<?php echo simpleEncode($data['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
						<button onclick="fncCenterMap('<?php echo $data['GeoLatitud']; ?>', '<?php echo $data['GeoLongitud']; ?>', '<?php echo $nicon; ?>')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
					</div>
				</td>
			</tr>
			<?php
			//le sumo 1 al indicador del icono
			$nicon++;
		} ?>
	</tbody>
</table>

<?php widget_tooltipster(); ?>
