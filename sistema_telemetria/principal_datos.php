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
$original = "principal_datos.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Perfil Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Perfil Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Perfil Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = '
usuarios_listado.usuario,
usuarios_tipos.Nombre AS Usuario_Tipo,
usuarios_listado.email,
usuarios_listado.Nombre,
usuarios_listado.Rut,
usuarios_listado.fNacimiento,
usuarios_listado.Direccion,
usuarios_listado.Fono,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
usuarios_listado.Direccion_img';
$SIS_join  = '
LEFT JOIN `usuarios_tipos`           ON usuarios_tipos.idTipoUsuario      = usuarios_listado.idTipoUsuario
LEFT JOIN `core_ubicacion_ciudad`    ON core_ubicacion_ciudad.idCiudad    = usuarios_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   ON core_ubicacion_comunas.idComuna   = usuarios_listado.idComuna';
$SIS_where = 'usuarios_listado.idUsuario ='.$_SESSION['usuario']['basic_data']['idUsuario'];
$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/**********************************/
//Permisos asignados
$SIS_query = '
core_permisos_categorias.Nombre AS CategoriaNombre,
core_font_awesome.Codigo AS CategoriaIcono,
core_permisos_listado.Direccionbase AS TransaccionURLBase,
core_permisos_listado.Direccionweb AS TransaccionURL,
core_permisos_listado.Nombre AS TransaccionNombre,
usuarios_permisos.level';
$SIS_join  = '
INNER JOIN core_permisos_listado      ON core_permisos_listado.idAdmpm        = usuarios_permisos.idAdmpm
INNER JOIN core_permisos_categorias   ON core_permisos_categorias.id_pmcat    = core_permisos_listado.id_pmcat
LEFT JOIN `core_font_awesome`         ON core_font_awesome.idFont             = core_permisos_categorias.idFont';
$SIS_where = 'usuarios_permisos.idUsuario ='.$_SESSION['usuario']['basic_data']['idUsuario'];
$SIS_order = 'CategoriaNombre ASC, TransaccionNombre ASC';
$arrMenu = array();
$arrMenu = db_select_array (false, $SIS_query, 'usuarios_permisos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMenu');

/**********************************/
//Permisos a sistemas
$SIS_query = 'core_sistemas.Nombre AS Sistema';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = usuarios_sistemas.idSistema';
$SIS_where = 'usuarios_sistemas.idUsuario ='.$_SESSION['usuario']['basic_data']['idUsuario'];
$SIS_order = 'core_sistemas.Nombre ASC';
$arrSistemas = array();
$arrSistemas = db_select_array (false, $SIS_query, 'usuarios_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSistemas');

/**********************************/
//Permisos a equipos telemetria
$SIS_query = 'telemetria_listado.Nombre AS Bodega';
$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = usuarios_equipos_telemetria.idTelemetria';
$SIS_where = 'usuarios_equipos_telemetria.idUsuario ='.$_SESSION['usuario']['basic_data']['idUsuario'];
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrTelemetria = array();
$arrTelemetria = db_select_array (false, $SIS_query, 'usuarios_equipos_telemetria', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTelemetria');


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Perfil', $_SESSION['usuario']['basic_data']['Nombre'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Personales</a></li>
				<li class=""><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Cambiar Imagen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Cambiar Contraseña</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos" style="padding-top:5px;">

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<?php if ($rowData['Direccion_img']=='') { ?>
						<img class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
					<?php }else{  ?>
						<img class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
					<?php } ?>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Perfil</h2>
					<p class="text-muted">
						<strong>Usuario : </strong><?php echo $rowData['usuario']; ?><br/>
						<strong>Tipo de usuario : </strong><?php echo $rowData['Usuario_Tipo']; ?>
					</p>

					<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Personales</h2>
					<p class="text-muted">
						<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
						<strong>Fono : </strong><?php echo formatPhone($rowData['Fono']); ?><br/>
						<strong>Email : </strong><?php echo $rowData['email']; ?><br/>
						<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
						<strong>Fecha de Nacimiento : </strong><?php echo Fecha_completa($rowData['fNacimiento']); ?><br/>
						<strong>Ciudad : </strong><?php echo $rowData['Ciudad']; ?><br/>
						<strong>Comuna : </strong><?php echo $rowData['Comuna']; ?><br/>
						<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
					</p>

					<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Sistemas Asignados</h2>
					<p class="text-muted">
						<?php foreach($arrSistemas as $sis) { ?>
							<strong><?php echo ' - '.$sis['Sistema']; ?></strong><br/>
						<?php } ?>
					</p>
				</div>

				<?php if($arrMenu!=false && !empty($arrMenu) && $arrMenu!=''){ ?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Permisos Asignados</h2>

						<ul class="tree">
							<?php
							filtrar($arrMenu, 'CategoriaNombre');
							foreach($arrMenu as $menu=>$productos) {
								echo '
									<li>
										<div class="blum">
											<div class="pull-left"><i class="'.$productos[0]['CategoriaIcono'].'"></i> '.TituloMenu($menu).'</div>
											<div class="clearfix"></div>
										</div>
										<ul style="padding-left: 20px;">';
								foreach($productos as $producto) {
									echo '
										<li>
											<div class="blum">
												<div class="pull-left"><i class="'.$producto['CategoriaIcono'].'"></i> '.TituloMenu($producto['TransaccionNombre']).'</div>
												<div class="clearfix"></div>
											</div>
										</li>';
								}
								echo '</ul>
								</li>';
							}
							?>
						</ul>
					</div>
				<?php } ?>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<?php
					/***************************************************************/
					if($arrTelemetria!=false && !empty($arrTelemetria) && $arrTelemetria!=''){
						echo '<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Permisos a Equipos Telemetria</h2>';
						echo '<ul class="tree">';
						/*******************************/
						echo '
							<li>
								<div class="blum">
									<div class="pull-left"><i class="fa fa-bullseye" aria-hidden="true"></i> Equipos</div>
									<div class="clearfix"></div>
								</div>
								<ul style="padding-left: 20px;">';
									foreach($arrTelemetria as $bod) {
										echo '
										<li>
											<div class="blum">
												<div class="pull-left"><i class="fa fa-bullseye" aria-hidden="true"></i> '.$bod['Bodega'].'</div>
												<div class="clearfix"></div>
											</div>
										</li>';
									}
									echo '
								</ul>
							</li>
						</ul>';
					} ?>
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
