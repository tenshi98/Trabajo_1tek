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
$original = "core_info_logs.php";
$location = $original;
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

$Archivo1 = '1_logs_hacking.txt';
$Archivo2 = '1_logs_send_mail.txt';
$Archivo3 = '1_logs_error_log_php.txt';

	
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Logs de errores</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#data1" data-toggle="tab"><i class="fa fa-server" aria-hidden="true"></i> Hacking Logs</a></li>
				<li class=""><a href="#data2" data-toggle="tab"><i class="fa fa-code" aria-hidden="true"></i> Email Logs</a></li>
				<li class=""><a href="#data3" data-toggle="tab"><i class="fa fa-server" aria-hidden="true"></i> PHP Error Logs</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="data1">

				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>IP Client</th>
								<th>Fecha</th>
								<th>Hora</th>
								<th>Empresa</th>
								<th>Sistema Operativo</th>
								<th>Navegador</th>
								<th>Usuario</th>
								<th>Archivo</th>
								<th>Tarea</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							if (file_exists($Archivo1)){
								//se trata de guardar el archivo
								try {
									$myfile = fopen($Archivo1, "r") or die("Unable to open file!");
									while(!feof($myfile)){
										echo '<tr class="odd">';
										//separo lo que obtengo
										$INT_piezas = explode(" - ", fgets($myfile));
										//recorro los elementos
										foreach ($INT_piezas as $INT_valor) {
											echo '<td>'.$INT_valor.'</td>';
										}
										echo '</tr>';
									}
									fclose($myfile);
								}catch (Exception $e) {
									error_log("Ha ocurrido un error (".$e->getMessage().")", 0);
								}
							}else{
								error_log("No existe el archivo (".$Archivo1.")", 0);
							}
							?>
													  
						</tbody>
					</table>
				</div>

			</div>

			<div class="tab-pane fade" id="data2">

				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Log</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							if (file_exists($Archivo2)){
								//se trata de guardar el archivo
								try {
									$myfile = fopen($Archivo2, "r") or die("Unable to open file!");
									while(!feof($myfile)){
										echo '<tr class="odd">';
											echo '<td>'.fgets($myfile).'</td>';
										echo '</tr>';
									}
									fclose($myfile);
								}catch (Exception $e) {
									error_log("Ha ocurrido un error (".$e->getMessage().")", 0);
								}
							}else{
								error_log("No existe el archivo (".$Archivo2.")", 0);
							}
							?>
													  
						</tbody>
					</table>
				</div>

			</div>

			<div class="tab-pane fade" id="data3">

				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Fecha</th>
								<th>Hora</th>
								<th>Usuario</th>
								<th>Transaccion</th>
								<th>Tarea</th>
								<th>ErrorCode</th>
								<th>Mensaje</th>
								<th>Consulta</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							if (file_exists($Archivo3)){
								//se trata de guardar el archivo
								try {
									$myfile = fopen($Archivo3, "r") or die("Unable to open file!");
									while(!feof($myfile)){
										echo '<tr class="odd">';
										//separo lo que obtengo
										$INT_piezas = explode(" /\ ", fgets($myfile));
										//recorro los elementos
										foreach ($INT_piezas as $INT_valor) {
											echo '<td>'.$INT_valor.'</td>';
										}
										echo '</tr>';
									}
									fclose($myfile);
								}catch (Exception $e) {
									error_log("Ha ocurrido un error (".$e->getMessage().")", 0);
								}
							}else{
								error_log("No existe el archivo (".$Archivo3.")", 0);
							}
							?>
													  
						</tbody>
					</table>
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
