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
//Verifico si es superusuario
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Type.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_info_sistema.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se borra un dato
if (!empty($_GET['del_error'])){
	//Llamamos al formulario
	$form_trabajo= 'del_error';
	require_once 'A1XRXS_sys/xrxs_form/z_server_test.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['error'])){ $error['error'] = 'error/'.$_GET['error'];}
if (isset($_GET['send'])){  $error['send']  = 'sucess/Email enviado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}

//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){

//si estoy en ambiente de produccion
}else{
	/*    Global Variables    */
	//Tiempo Maximo de la consulta, 40 minutos por defecto
	if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
	//Memora RAM Maxima del servidor, 4GB por defecto
	if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
}



?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Servidor</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#data1" data-toggle="tab"><i class="fa fa-server" aria-hidden="true"></i> Info Servidor</a></li>
				<li class=""><a href="#data2" data-toggle="tab"><i class="fa fa-code" aria-hidden="true"></i> PHP</a></li>
				<li class=""><a href="#data3" data-toggle="tab"><i class="fa fa-server" aria-hidden="true"></i> Servidor</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="data1">
				<div class="wmd-panel">

					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th width="100">Dato</th>
									<th>Info</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd"><td>Fecha Actual</td>   <td><?php echo fecha_actual(); ?></td></tr>
								<tr class="odd"><td>Hora Actual</td>    <td><?php echo hora_actual(); ?></td></tr>
								<tr class="odd"><td>Dia Actual</td>     <td><?php echo dia_actual(); ?></td></tr>
								<tr class="odd"><td>Semana Actual</td>  <td><?php echo semana_actual(); ?></td></tr>
								<tr class="odd"><td>Mes Actual</td>     <td><?php echo mes_actual(); ?></td></tr>
								<tr class="odd"><td>Año Actual</td>     <td><?php echo ano_actual(); ?></td></tr>
								<tr class="odd"><td>Fecha Archivos</td> <td><?php echo Fecha_archivos(fecha_actual()); ?></td></tr>
								<?php
								//Datos
								$hora_ini = '15:36:58';
								$hora_fin = '16:10:00';
								?>
								<tr class="odd"><td>Prueba Resta Horas</td>     <td><?php echo $hora_ini.' - '.$hora_fin.' = '.restahoras($hora_ini, $hora_fin); ?></td></tr>
								<tr class="odd"><td>Prueba Suma Horas</td>      <td><?php echo $hora_ini.' + '.$hora_fin.' = '.sumahoras($hora_ini, $hora_fin); ?></td></tr>
								<?php
								//Fuera de linea
								$diaInicio   = '2017-09-13';
								$diaTermino  = '2017-09-14';
								$tiempo1     = '09:35:00';
								$tiempo2     = '08:45:00';
								//calculo diferencia de dias
								$n_dias = dias_transcurridos($diaInicio,$diaTermino);
								//calculo del tiempo transcurrido
								$Tiempo = restahoras($tiempo1, $tiempo2);
								//Calculo del tiempo transcurrido
								if($n_dias!=0){
									if($n_dias>=2){
										$n_dias = $n_dias-1;
										$horas_trans2 = multHoras('24:00:00',$n_dias);
										$Tiempo = sumahoras($Tiempo,$horas_trans2);
									}
									if($n_dias==1&&$tiempo1<$tiempo2){
										$horas_trans2 = multHoras('24:00:00',$n_dias);
										$Tiempo = sumahoras($Tiempo,$horas_trans2);
									}
								} ?>
								<tr class="odd"><td>Testeo horas transcurridas</td>     <td><?php echo $Tiempo; ?></td></tr>
								<tr class="odd"><td>Testeo horas a segundos</td>        <td><?php echo '02:00:00 hora = '.horas2segundos('02:00:00'); ?></td></tr>
								<tr class="odd"><td>Testeo horas a minutos</td>        <td><?php echo '02:00:00 hora = '.horas2minutos('02:00:00'); ?></td></tr>
								<tr class="odd"><td>IP Cliente</td>                     <td><?php echo obtenerIpCliente(); ?></td></tr>

								<tr class="odd"><td>Agente de Transporte</td>           <td><?php echo obtenerSistOperativo().' - '.obtenerNavegador(); ?></td></tr>
								<tr class="odd"><td>username = tenshi98</td>            <td><?php $username = 'tenshi98'; echo preg_replace("/[^a-zA-Z0-9_\-]+/","",$username); ?></td></tr>
								<tr class="odd"><td>time()</td>                         <td><?php echo time(); ?></td></tr>
								
								

									                   
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="data2">
				<div class="wmd-panel">
					<div class="table-responsive">
						<iframe class="col-xs-12 col-sm-12 col-md-12 col-lg-12" frameborder="0" height="500" src="1phpinfo.php"></iframe>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="data3">
				<div class="wmd-panel">
					<div class="table-responsive">
						<iframe class="col-xs-12 col-sm-12 col-md-12 col-lg-12" frameborder="0" height="1200" src="<?php echo DB_SITE_REPO ?>/EXTERNAL_LIBS/linfo/index.php"></iframe>
					</div>
				</div>
			</div>
			

        </div>
	</div>
</div>

		
<?php widget_validator(); ?>

           
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
