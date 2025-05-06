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
$original = "core_información_base.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/

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
				<li class="active"><a href="#data0" data-toggle="tab"><i class="fa fa-server" aria-hidden="true"></i> BD</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="data0">
				<div class="wmd-panel">
					<div class="table-responsive">

						<?php
						$DB_NAME_1 = DB_NAME;

						//Variables
						$tableList_1 = array();
						$w = 0;
						//Obtengo el listado de tablas de Main
						$res = mysqli_query($dbConn,"SHOW TABLES WHERE `Tables_in_".$DB_NAME_1."` LIKE '%_listado_tablarelacionada_%'");
						$num_tables_1 = mysqli_num_rows($res);
						while($cRow = mysqli_fetch_array($res)){
							$w++;
							$tableList_1[$w] = $cRow[0];
						}
						
						
						$widget =  '
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Base Sistema</th>
										<th>N° Columnas</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">';
								
								for ($x = 1; $x < $w; $x++) {
									//Comparo ambas tablas
									$na_1 = mysqli_query($dbConn,"SHOW TABLES LIKE '".$tableList_1[$x]."'");
									$te_1 = mysqli_num_rows($na_1);
									if($te_1 > 0){ 
										$cs = mysqli_query($dbConn,"describe ".$tableList_1[$x]."");
										$nc1 = mysqli_num_rows($cs);
									}else{
										$nc1 = 0;
									}
										
									$widget .= '
									<tr class="odd">
										<td>'.$tableList_1[$x].'</td>
										<td>'.$nc1.'</td>
									</tr>';
								}
								$widget .= '
								</tbody>
							</table>';


							echo $widget;
						?>
							
					</div>
				</div>
			</div>
			
			
        </div>
	</div>
</div>

		


           
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
