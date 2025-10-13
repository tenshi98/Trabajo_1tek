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
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], '123333');
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], '123333');
}
//Cargamos la ubicacion original
$original = "view_notificacion.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$X_Puntero;
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se indica que no hay que molestar
if (!empty($_GET['noMolestar'])){
	//Llamamos al formulario
	$form_trabajo= 'noMolestar';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_mnt_correos_list.php';
}
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/


/**************************************************************/
// consulto los datos
$SIS_query = '
principal_notificaciones_listado.Titulo,
principal_notificaciones_listado.Notificacion,
principal_notificaciones_listado.Fecha,
principal_notificaciones_listado.NoMolestar,
usuarios_listado.Nombre,
usuarios_listado.Direccion_img';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = principal_notificaciones_listado.idUsuario';
$SIS_where = 'principal_notificaciones_listado.idNotificaciones ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'principal_notificaciones_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Notificación</h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-bottom:5px;">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Autor: </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Titulo: </strong><?php echo $rowData['Titulo']; ?><br/>
							<strong>Fecha: </strong><?php echo fecha_estandar($rowData['Fecha']); ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Mensaje</h2>
						<p class="text-muted" style="white-space: normal;"><?php echo $rowData['Notificacion']; ?></p>

						<?php
						//Si esta activo el nomolestar
						if(isset($_GET['noMol'])&&$_GET['noMol']!=''){
							//mostrar la alerta
							$Alert_Text  = 'Se han desactivado las alertas por '.simpleDecode($_GET['noMol'], fecha_actual()).' Horas.';
							alert_post_data(2,1,1,0, $Alert_Text);
						}

						//verifico que exista el no molestar
						if(isset($rowData['NoMolestar'])&&$rowData['NoMolestar']!=''&&$rowData['NoMolestar']!=0){
							switch ($rowData['NoMolestar']) {
								//No molestar de crosstech
								case 1:
									echo '
									<table id="items" style="margin-bottom: 20px;margin-top: 20px;">
										<tbody>
											<tr class="item-row">
												<td>No Molestar</td>
												<td width="10">
													<div class="btn-group" style="width: 110px;">
														<a href="'.$location.'&noMolestar=1&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].'" title="Desactivar Email por 1 Hora" class="btn btn-primary btn-sm tooltip"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
														<a href="'.$location.'&noMolestar=2&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].'" title="Desactivar Email por 2 Horas" class="btn btn-primary btn-sm tooltip"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
														<a href="'.$location.'&noMolestar=3&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].'" title="Desactivar Email por 3 Horas" class="btn btn-primary btn-sm tooltip"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>';

									break;
								//nada de momento
								case 2:
									
									break;
							}
						}
						?>

					</div>
					<div class="clearfix"></div>

				</div>
			</div>
        </div>
	</div>
</div>



	
<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
