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
$original = "principal_datos_imagen.php";
$location = $original;
$location .= '?d=d';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se borra un dato
if (!empty($_GET['del_img'])){
	//datos extra
	$location.='&id_usuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
	//Llamamos al formulario
	$form_trabajo= 'del_img';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
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
$SIS_query = 'Direccion_img';
$SIS_join  = '';
$SIS_where = 'idUsuario = '.$_SESSION['usuario']['basic_data']['idUsuario'];
$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Perfil', $_SESSION['usuario']['basic_data']['Nombre'], 'Editar Imagen Perfil'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Personales</a></li>
				<li class="active"><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Cambiar Imagen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Cambiar Contraseña</a></li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;padding-bottom:40px;">
				<?php if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){ ?>

					<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
						<img src="upload/<?php echo $rowData['Direccion_img'] ?>" width="100%" class="img-thumbnail" >
						<br/>
						<a href="<?php echo $location.'&id_usuario='.$_SESSION['usuario']['basic_data']['idUsuario'].'&del_img=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
					</div>
					<div class="clearfix"></div>

				<?php }else{ ?>

					<link rel="stylesheet" href="<?php echo DB_SITE_REPO ?>/LIBS_js/upload_and_crop_image/croppie.css">
					<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/upload_and_crop_image/croppie.js"></script>

					<div class="fileUpload btn btn-primary">
						<span><i class="fa fa-search" aria-hidden="true"></i> Seleccionar Imagen</span>
						<input name="upload_image" id="upload_image" type="file" class="upload" />
					</div>

					<div id="uploadimageModal" class="modal" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Seleccionar Zona</h4>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-center">
											  <div id="image_demo" style="width:350px; margin-top:30px"></div>
										</div>
										<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding-top:30px;">
											<br/>
											<br/>
											<br/>
											  <button class="btn btn-success crop_image">Cortar y Subir Imagen</button>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>

					<script>
						$(document).ready(function(){

							$image_crop = $('#image_demo').croppie({
								enableExif: true,
								viewport: {
									width:200,
									height:200,
									type:'square' //circle
								},
								boundary:{
									width:300,
									height:300
								}
							});

							$('#upload_image').on('change', function(){
								var reader = new FileReader();
								reader.onload = function (event) {
									$image_crop.croppie('bind', {
										url: event.target.result
									}).then(function(){
										console.log('jQuery bind complete');
									});
								}
								reader.readAsDataURL(this.files[0]);
								$('#uploadimageModal').modal('show');
							});

							$('.crop_image').click(function(event){
								$image_crop.croppie('result', {
									type: 'canvas',
									size: 'viewport'
								}).then(function(response){
									$.ajax({
										url:"principal_datos_imagen_upload.php",
										type: "POST",
										data:{"image": response},
										success:function(data){
											$('#uploadimageModal').modal('hide');
											location.reload();
										}
									});
								})
							});

						});
					</script>

				<?php } ?>
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
