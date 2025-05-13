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
$original = "productos_listado.php";
$location = $original;
$new_location = "productos_listado_datos_imagen.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'submit_img';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
//se borra un dato
if (!empty($_GET['del_img'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_img';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Archivo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Archivo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Archivo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Se traen todos los datos del producto
$SIS_query = 'Nombre,Direccion_img, idTipoProducto, idTipoReceta,idTipoImagen,idOpciones_1, idOpciones_2';
$SIS_join  = '';
$SIS_where = 'idProducto = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Productos', $rowData['Nombre'], 'Editar Imagen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'productos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'productos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'productos_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'productos_listado_datos_opciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Opciones</a></li>
						<li class=""><a href="<?php echo 'productos_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<?php if(isset($rowData['idTipoProducto'])&&$rowData['idTipoProducto']==2&&$rowData['idTipoReceta']==1){ ?>
							<li class=""><a href="<?php echo 'productos_listado_datos_receta_01.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-align-left" aria-hidden="true"></i> Receta</a></li>
						<?php }elseif(isset($rowData['idTipoProducto'])&&$rowData['idTipoProducto']==2&&$rowData['idTipoReceta']==2){ ?>
							<li class=""><a href="<?php echo 'productos_listado_datos_receta_02.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-align-left" aria-hidden="true"></i> Receta</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'productos_listado_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class="active"><a href="<?php echo 'productos_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
						<li class=""><a href="<?php echo 'productos_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha</a></li>
						<li class=""><a href="<?php echo 'productos_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>
						<?php if(isset($rowData['idOpciones_1'])&&$rowData['idOpciones_1']==1){ ?>
							<li class=""><a href="<?php echo 'productos_listado_datos_ot.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Sistema Mantenlubric</a></li>
						<?php } ?>
						<?php if(isset($rowData['idOpciones_2'])&&$rowData['idOpciones_2']==1){ ?>
							<li class=""><a href="<?php echo 'productos_listado_datos_cross.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Sistema 1tek</a></li>
						<?php } ?>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;padding-bottom:40px;">

				<?php if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){ ?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo widget_TipoImagen($rowData['idTipoImagen'], DB_SITE_REPO, DB_SITE_MAIN_PATH, 'upload', $rowData['Direccion_img']); ?>
						<br/>
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&del_img='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
					</div>
					<div class="clearfix"></div>

				<?php }else{ ?>

					<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

						<?php
						//Se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_multiple_upload('Seleccionar archivo','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');

						if(isset($idTipoImagen)){  $x1  = $idTipoImagen;  }else{$x1  = '';}

						$Form_Inputs->form_select('Tipo Imagen','idTipoImagen', $x1, 2, 'idTipoImagen', 'Nombre', 'core_tipo_producto_imagen', 0, '', $dbConn);

						$Form_Inputs->form_input_hidden('idProducto', $_GET['id'], 2);
						?>

						<div class="form-group">
							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf093; Subir Archivo" name="submit_edit">
						</div>

					</form>
					<?php widget_validator(); ?>
				<?php } ?>

			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
