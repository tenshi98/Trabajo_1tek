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
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "informe_gerencial_17.php";
$location = $original;

							
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Variables
$titulo_cuadro  = 'Ultimas Mediciones';
$seguimiento    = 2;
$HoraSistema    = hora_actual();
$FechaSistema   = fecha_actual();

//Variable
$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
//solo los equipos que tengan el seguimiento activado
if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
	$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
}
//Filtro el sistema al cual pertenece
$SIS_where .= " AND telemetria_listado.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];

//Verifico el tipo de usuario que esta ingresando y el id
$SIS_join = "LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = telemetria_listado.idSistema";	
if(isset($_SESSION['usuario']['basic_data']['idTipoUsuario'])&&$_SESSION['usuario']['basic_data']['idTipoUsuario']!=1&&isset($_SESSION['usuario']['basic_data']['idUsuario'])&&$_SESSION['usuario']['basic_data']['idUsuario']!=0){
	$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
	$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}

//Se consultan datos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
telemetria_listado.LastUpdateHora,
telemetria_listado.LastUpdateFecha,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.NErrores';
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipo');

/**********************************************************/
$GPS = '';
$GPS .= '<link rel="stylesheet" href="'.DB_SITE_REPO.'/LIBS_js/modal/colorbox.css" />';


	$GPS .= '
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
			<a target="new" href="informe_gerencial_17_to_excel.php" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo_cuadro.'</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Noti</th>
								<th>Equipo</th>
								<th>Ultima Conexion</th>
								<th>Estado</th>
								<th width="10">Acciones</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">';
						
							foreach($arrEquipo as $equip) {	
								
								/**********************************************/
								//Se resetean
								$in_eq_alertas     = 0;
								$in_eq_fueralinea  = 0;
																	
								/**********************************************/
								//Fuera de linea
								$diaInicio   = $equip['LastUpdateFecha'];
								$diaTermino  = $FechaSistema;
								$tiempo1     = $equip['LastUpdateHora'];
								$tiempo2     = $HoraSistema;
								$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

								//Comparaciones de tiempo
								$Time_Tiempo     = horas2segundos($Tiempo);
								$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
								$Time_Tiempo_Max = horas2segundos('48:00:00');
								$Time_Fake_Ini   = horas2segundos('23:59:50');
								$Time_Fake_Fin   = horas2segundos('24:00:00');
								//comparacion
								if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
									$in_eq_fueralinea++;
								}

								/**********************************************/
								//NErrores
								if(isset($equip['NErrores'])&&$equip['NErrores']>0){ $in_eq_alertas++; }
										
								/*******************************************************/
								//rearmo
								if($in_eq_alertas>0){    
									$danger = 'Alerta';
									$eq_ok  = ' Con Alertas';
								}elseif($in_eq_fueralinea>0){
									$danger = 'Peligro';
									$eq_ok  = ' Fuera de Linea';
								}else{
									$danger = 'Normal';
									$eq_ok  = ' Sin Problemas';
								}
										
								/*******************************************************/
								//imprimo
								$GPS .= '
								<tr class="odd">
									<td>'.$danger.'</td>
									<td>'.$equip['Nombre'].'</td>
									<td>'.fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].' hrs</td>
									<td><div class="btn-group" >'.$eq_ok.'</div></td>		
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="telemetria_gestion_equipos_view_equipo.php?view='.simpleEncode($equip['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
								</tr>';
							}
							$GPS .= '
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>';



$GPS .= '
<script src="'.DB_SITE_REPO.'/LIBS_js/modal/jquery.colorbox.js"></script>

<script>
	$(document).ready(function(){
		//Examples of how to assign the Colorbox event to elements
		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
		$(".callbacks").colorbox({
			onOpen:function(){ alert(\'onOpen: colorbox is about to open\');},
			onLoad:function(){ alert(\'onLoad: colorbox has started to load the targeted content\');},
			onComplete:function(){ alert(\'onComplete: colorbox has displayed the loaded content\');},
			onCleanup:function(){ alert(\'onCleanup: colorbox has begun the close process\');},
			onClosed:function(){ alert(\'onClosed: colorbox has completely closed\');}
		});

				
		//Example of preserving a JavaScript event for inline calls.
		$("#click").click(function(){
			$(\'#click\').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});
</script>
	
	';
	
	echo $GPS;

									
?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
