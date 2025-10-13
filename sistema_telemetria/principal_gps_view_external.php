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
/*                                                Carga del documento HTML                                                        */
/**********************************************************************************************************************************/


//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
////////////////////////////////////////////////////////////////////////////////
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
	$CON_Server    = 'localhost';
	$CON_Usuario   = 'root';
	$CON_Password  = '';
	$CON_Base      = 'power_engine_main';
////////////////////////////////////////////////////////////////////////////////
//si estoy en ambiente de produccion
}else{
	$CON_Server    = 'localhost';
	$CON_Usuario   = 'crosstech_admin';
	$CON_Password  = '&-VSda,#rFvT';
	$CON_Base      = 'crosstech_pe_clientes';
}	
			
//Funcion para conectarse
function conectarDB ($servidor, $usuario, $password, $base_datos) {
	$db_con = mysqli_connect($servidor, $usuario, $password, $base_datos);
	$db_con->set_charset("utf8");
	return $db_con;
}
//verifico si existen datos
if($CON_Server!=''&&$CON_Usuario!=''&&$CON_Base!=''){
	//ejecuto conexion
	$dbConn_2 = conectarDB($CON_Server, $CON_Usuario, $CON_Password, $CON_Base);

	//variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Se consultan datos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.NDetenciones,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores,
	core_sistemas.Nombre AS Sistema';
	$SIS_join = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = telemetria_listado.idSistema';
	$SIS_where = "telemetria_listado.idEstado = 1 ";
	$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');
			
}
			

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo</h5>

		</header>
        <div class="tab-content">

			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Sistema</th>
							<th>Nombre</th>
							<th>Fecha - Hora</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">			
						<?php foreach ($arrEquipo as $data) { 
							
							//Variables
							$xx = 0;
							$xy = 0;
							$xz = 0;
							$ident = 0;

							//dependiendo del tipo de datos que quiero mostrar ajusto los datos
							switch (simpleDecode($_GET['dataType'], fecha_actual())){
								//En caso de que los sensores registren alguna alerta
								case 1:
									//Alertas
									if(isset($data['NErrores'])&&$data['NErrores']>0){
										echo '
										<tr class="odd">
											<td>'.$data['Sistema'].'</td>
											<td>'.$data['Nombre'].'</td>
											<td>'.fecha_estandar($data['LastUpdateFecha']).' a las '.$data['LastUpdateHora'].' hrs</td>
										</tr>
										';
									}
									break;

								//En caso de que el equipo este fuera de linea
								case 2:
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
										echo '
										<tr class="odd">
											<td>'.$data['Sistema'].'</td>
											<td>'.$data['Nombre'].'</td>
											<td>'.fecha_estandar($data['LastUpdateFecha']).' a las '.$data['LastUpdateHora'].' hrs</td>
										</tr>
										';
									}
									break;

								//En caso de que este fuera de ruta	
								case 3:
									
									break;

								//Equipos en buen estado	
								case 4:
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

									/**********************************************/
									//Si no hay errores nu fuera de linea
									if($in_eq_fueralinea==0&&$in_eq_alertas==0){
										//imprimo	
										echo '
										<tr class="odd">
											<td>'.$data['Sistema'].'</td>
											<td>'.$data['Nombre'].'</td>
											<td>'.fecha_estandar($data['LastUpdateFecha']).' a las '.$data['LastUpdateHora'].' hrs</td>
										</tr>';
									}
									
									break;

								//En caso de que este detenido	
								case 5:
									if($data['NDetenciones']!=0){
										//imprimo	
										echo '
										<tr class="odd">
											<td>'.$data['Sistema'].'</td>
											<td>'.$data['Nombre'].'</td>
											<td>'.fecha_estandar($data['LastUpdateFecha']).' a las '.$data['LastUpdateHora'].' hrs</td>
										</tr>
										';
									}
									break;
							}
						} ?>
					</tbody>
				</table>
			</div>
        </div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>




