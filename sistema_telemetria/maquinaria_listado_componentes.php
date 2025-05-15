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
$original = "maquinaria_listado.php";
$location = $original;
$new_location = "maquinaria_listado_componentes.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_addTrabajo'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'add_trabajo';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se borra un dato
if (!empty($_GET['del_idLevel'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_item';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//se borra un dato
if (!empty($_GET['clone_compo'])){
	//Agregamos nuevas direcciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'clone_component';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/***********************************************************/
//formulario para editar
if (!empty($_POST['submit_edit_img'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'submit_img_comp';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['del_img'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_img_comp';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){    $error['created']    = 'sucess/Dato Creado correctamente';}
if (isset($_GET['edited'])){     $error['edited']     = 'sucess/Dato Modificado correctamente';}
if (isset($_GET['deleted'])){    $error['deleted']    = 'sucess/Dato Borrado correctamente';}
if (isset($_GET['clone_comp'])){ $error['clone_comp'] = 'sucess/Componente clonado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idUtilizable';
	$SIS_join  = '';
	$SIS_where = 'idLevel_'.$_GET['lvl'].' = '.$_GET['edit'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_level_'.$_GET['lvl'], $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar Componente</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = $rowData['Nombre'];}
					if(isset($idUtilizable)){         $x4  = $idUtilizable;           }else{$x4  = $rowData['idUtilizable'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$s_data = '<strong>Componente: </strong> permite identificar el tipo de componente de la maquina, estos se dividen en:';
					$s_data.= '<ul>';
						$s_data.= '<li><strong>Componente: </strong>indica que este nodo puede ser dividido en mas nodos, hasta llegar al subcomponente deseado</li>';
						$s_data.= '<li><strong>Subcomponente: </strong>nodo final en donde se definen las tareas a realizar</li>';
						$s_data.= '<li><strong>No utilizable: </strong>nodo que no puede ser dividido en otros nodos, tampoco se le puede asignar tareas ni trabajos</li>';
					$s_data.= '</ul>';
					$Form_Inputs->form_post_data(1,1,1, $s_data);
					$Form_Inputs->form_select('Componente','idUtilizable', $x4, 2, 'idUtilizable', 'Nombre', 'core_maquinas_tipo_componente', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', simpleDecode($_GET['id'], fecha_actual()), 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

					?>

					<div class="form-group">

						<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){   $Form_Inputs->form_input_hidden('idLevel_1',  $_GET['lv_1'], 2);} ?>
						<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){   $Form_Inputs->form_input_hidden('idLevel_2',  $_GET['lv_2'], 2);} ?>
						<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){   $Form_Inputs->form_input_hidden('idLevel_3',  $_GET['lv_3'], 2);} ?>
						<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){   $Form_Inputs->form_input_hidden('idLevel_4',  $_GET['lv_4'], 2);} ?>
						<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){   $Form_Inputs->form_input_hidden('idLevel_5',  $_GET['lv_5'], 2);} ?>
						<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){   $Form_Inputs->form_input_hidden('idLevel_6',  $_GET['lv_6'], 2);} ?>
						<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){   $Form_Inputs->form_input_hidden('idLevel_7',  $_GET['lv_7'], 2);} ?>
						<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){   $Form_Inputs->form_input_hidden('idLevel_8',  $_GET['lv_8'], 2);} ?>
						<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){   $Form_Inputs->form_input_hidden('idLevel_9',  $_GET['lv_9'], 2);} ?>
						<?php if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){ $Form_Inputs->form_input_hidden('idLevel_10', $_GET['lv_10'], 2);} ?>
						<?php if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){ $Form_Inputs->form_input_hidden('idLevel_11', $_GET['lv_11'], 2);} ?>
						<?php if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){ $Form_Inputs->form_input_hidden('idLevel_12', $_GET['lv_12'], 2);} ?>
						<?php if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){ $Form_Inputs->form_input_hidden('idLevel_13', $_GET['lv_13'], 2);} ?>
						<?php if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){ $Form_Inputs->form_input_hidden('idLevel_14', $_GET['lv_14'], 2);} ?>
						<?php if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){ $Form_Inputs->form_input_hidden('idLevel_15', $_GET['lv_15'], 2);} ?>
						<?php if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){ $Form_Inputs->form_input_hidden('idLevel_16', $_GET['lv_16'], 2);} ?>
						<?php if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){ $Form_Inputs->form_input_hidden('idLevel_17', $_GET['lv_17'], 2);} ?>
						<?php if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){ $Form_Inputs->form_input_hidden('idLevel_18', $_GET['lv_18'], 2);} ?>
						<?php if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){ $Form_Inputs->form_input_hidden('idLevel_19', $_GET['lv_19'], 2);} ?>
						<?php if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){ $Form_Inputs->form_input_hidden('idLevel_20', $_GET['lv_20'], 2);} ?>
						<?php if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){ $Form_Inputs->form_input_hidden('idLevel_21', $_GET['lv_21'], 2);} ?>
						<?php if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){ $Form_Inputs->form_input_hidden('idLevel_22', $_GET['lv_22'], 2);} ?>
						<?php if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){ $Form_Inputs->form_input_hidden('idLevel_23', $_GET['lv_23'], 2);} ?>
						<?php if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){ $Form_Inputs->form_input_hidden('idLevel_24', $_GET['lv_24'], 2);} ?>
						<?php if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){ $Form_Inputs->form_input_hidden('idLevel_25', $_GET['lv_25'], 2);} ?>

						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editimg'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	maquinas_listado_level_'.$_GET['lvl'].'.Nombre,
	maquinas_listado_level_'.$_GET['lvl'].'.Direccion_img';
	$SIS_join  = '';
	$SIS_where = 'maquinas_listado_level_'.$_GET['lvl'].'.idLevel_'.$_GET['lvl'].' = '.$_GET['editimg'];
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_level_'.$_GET['lvl'], $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar imagen de <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="body">

				<?php if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){ ?>

					<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
						<img src="upload/<?php echo $rowData['Direccion_img']; ?>" width="100%" >
					</div>

					<div class="form-group">
						<a href="<?php echo $new_location.'&id='.$_GET['id'].'&lvl='.$_GET['lvl'].'&del_img='.$_GET['editimg']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
					<div class="clearfix"></div>

				<?php }else{ ?>

					<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

						<?php
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_multiple_upload('Seleccionar archivo','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');

						$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
						$Form_Inputs->form_input_hidden('idMaquina', simpleDecode($_GET['id'], fecha_actual()), 2);
						$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

						?>

						<div class="form-group">

							<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){   $Form_Inputs->form_input_hidden('idLevel_1',  $_GET['lv_1'], 2);} ?>
							<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){   $Form_Inputs->form_input_hidden('idLevel_2',  $_GET['lv_2'], 2);} ?>
							<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){   $Form_Inputs->form_input_hidden('idLevel_3',  $_GET['lv_3'], 2);} ?>
							<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){   $Form_Inputs->form_input_hidden('idLevel_4',  $_GET['lv_4'], 2);} ?>
							<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){   $Form_Inputs->form_input_hidden('idLevel_5',  $_GET['lv_5'], 2);} ?>
							<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){   $Form_Inputs->form_input_hidden('idLevel_6',  $_GET['lv_6'], 2);} ?>
							<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){   $Form_Inputs->form_input_hidden('idLevel_7',  $_GET['lv_7'], 2);} ?>
							<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){   $Form_Inputs->form_input_hidden('idLevel_8',  $_GET['lv_8'], 2);} ?>
							<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){   $Form_Inputs->form_input_hidden('idLevel_9',  $_GET['lv_9'], 2);} ?>
							<?php if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){ $Form_Inputs->form_input_hidden('idLevel_10', $_GET['lv_10'], 2);} ?>
							<?php if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){ $Form_Inputs->form_input_hidden('idLevel_11', $_GET['lv_11'], 2);} ?>
							<?php if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){ $Form_Inputs->form_input_hidden('idLevel_12', $_GET['lv_12'], 2);} ?>
							<?php if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){ $Form_Inputs->form_input_hidden('idLevel_13', $_GET['lv_13'], 2);} ?>
							<?php if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){ $Form_Inputs->form_input_hidden('idLevel_14', $_GET['lv_14'], 2);} ?>
							<?php if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){ $Form_Inputs->form_input_hidden('idLevel_15', $_GET['lv_15'], 2);} ?>
							<?php if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){ $Form_Inputs->form_input_hidden('idLevel_16', $_GET['lv_16'], 2);} ?>
							<?php if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){ $Form_Inputs->form_input_hidden('idLevel_17', $_GET['lv_17'], 2);} ?>
							<?php if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){ $Form_Inputs->form_input_hidden('idLevel_18', $_GET['lv_18'], 2);} ?>
							<?php if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){ $Form_Inputs->form_input_hidden('idLevel_19', $_GET['lv_19'], 2);} ?>
							<?php if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){ $Form_Inputs->form_input_hidden('idLevel_20', $_GET['lv_20'], 2);} ?>
							<?php if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){ $Form_Inputs->form_input_hidden('idLevel_21', $_GET['lv_21'], 2);} ?>
							<?php if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){ $Form_Inputs->form_input_hidden('idLevel_22', $_GET['lv_22'], 2);} ?>
							<?php if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){ $Form_Inputs->form_input_hidden('idLevel_23', $_GET['lv_23'], 2);} ?>
							<?php if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){ $Form_Inputs->form_input_hidden('idLevel_24', $_GET['lv_24'], 2);} ?>
							<?php if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){ $Form_Inputs->form_input_hidden('idLevel_25', $_GET['lv_25'], 2);} ?>

							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit_img">
							<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
						</div>

					</form>
					<?php widget_validator(); ?>
				<?php } ?>

			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Componente</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){               $x1  = $Nombre;                 }else{$x1  = '';}
					if(isset($idUtilizable)){         $x4  = $idUtilizable;           }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$s_data = '<strong>Componente: </strong> permite identificar el tipo de componente de la maquina, estos se dividen en:';
					$s_data.= '<ul>';
						$s_data.= '<li><strong>Componente: </strong>indica que este nodo puede ser dividido en mas nodos, hasta llegar al subcomponente deseado</li>';
						$s_data.= '<li><strong>Subcomponente: </strong>nodo final en donde se definen las tareas a realizar</li>';
						$s_data.= '<li><strong>No utilizable: </strong>nodo que no puede ser dividido en otros nodos, tampoco se le puede asignar tareas ni trabajos</li>';
					$s_data.= '</ul>';
					$Form_Inputs->form_post_data(1,1,1, $s_data);
					$Form_Inputs->form_select('Componente','idUtilizable', $x4, 2, 'idUtilizable', 'Nombre', 'core_maquinas_tipo_componente', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idSistema', $_GET['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMaquina', simpleDecode($_GET['id'], fecha_actual()), 2);
					$Form_Inputs->form_input_hidden('lvl', $_GET['lvl'], 2);

					?>

					<div class="form-group">

						<?php if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){   $Form_Inputs->form_input_hidden('idLevel_1',  $_GET['lv_1'], 2);} ?>
						<?php if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){   $Form_Inputs->form_input_hidden('idLevel_2',  $_GET['lv_2'], 2);} ?>
						<?php if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){   $Form_Inputs->form_input_hidden('idLevel_3',  $_GET['lv_3'], 2);} ?>
						<?php if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){   $Form_Inputs->form_input_hidden('idLevel_4',  $_GET['lv_4'], 2);} ?>
						<?php if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){   $Form_Inputs->form_input_hidden('idLevel_5',  $_GET['lv_5'], 2);} ?>
						<?php if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){   $Form_Inputs->form_input_hidden('idLevel_6',  $_GET['lv_6'], 2);} ?>
						<?php if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){   $Form_Inputs->form_input_hidden('idLevel_7',  $_GET['lv_7'], 2);} ?>
						<?php if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){   $Form_Inputs->form_input_hidden('idLevel_8',  $_GET['lv_8'], 2);} ?>
						<?php if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){   $Form_Inputs->form_input_hidden('idLevel_9',  $_GET['lv_9'], 2);} ?>
						<?php if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){ $Form_Inputs->form_input_hidden('idLevel_10', $_GET['lv_10'], 2);} ?>
						<?php if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){ $Form_Inputs->form_input_hidden('idLevel_11', $_GET['lv_11'], 2);} ?>
						<?php if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){ $Form_Inputs->form_input_hidden('idLevel_12', $_GET['lv_12'], 2);} ?>
						<?php if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){ $Form_Inputs->form_input_hidden('idLevel_13', $_GET['lv_13'], 2);} ?>
						<?php if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){ $Form_Inputs->form_input_hidden('idLevel_14', $_GET['lv_14'], 2);} ?>
						<?php if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){ $Form_Inputs->form_input_hidden('idLevel_15', $_GET['lv_15'], 2);} ?>
						<?php if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){ $Form_Inputs->form_input_hidden('idLevel_16', $_GET['lv_16'], 2);} ?>
						<?php if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){ $Form_Inputs->form_input_hidden('idLevel_17', $_GET['lv_17'], 2);} ?>
						<?php if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){ $Form_Inputs->form_input_hidden('idLevel_18', $_GET['lv_18'], 2);} ?>
						<?php if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){ $Form_Inputs->form_input_hidden('idLevel_19', $_GET['lv_19'], 2);} ?>
						<?php if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){ $Form_Inputs->form_input_hidden('idLevel_20', $_GET['lv_20'], 2);} ?>
						<?php if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){ $Form_Inputs->form_input_hidden('idLevel_21', $_GET['lv_21'], 2);} ?>
						<?php if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){ $Form_Inputs->form_input_hidden('idLevel_22', $_GET['lv_22'], 2);} ?>
						<?php if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){ $Form_Inputs->form_input_hidden('idLevel_23', $_GET['lv_23'], 2);} ?>
						<?php if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){ $Form_Inputs->form_input_hidden('idLevel_24', $_GET['lv_24'], 2);} ?>
						<?php if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){ $Form_Inputs->form_input_hidden('idLevel_25', $_GET['lv_25'], 2);} ?>

						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_idLevel">
						<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,idSistema, idConfig_1, idConfig_2';
	$SIS_join  = '';
	$SIS_where = 'idMaquina ='.simpleDecode($_GET['id'], fecha_actual());
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Se crean las variables
	$nmax = 15;
	$z = '';
	$leftjoin = '';
	$orderby = '';
	for ($i = 1; $i <= $nmax; $i++) {
		//consulta
		$z .= ',maquinas_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
		$z .= ',maquinas_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
		$z .= ',maquinas_listado_level_'.$i.'.idUtilizable AS LVL_'.$i.'_idUtilizable';
		$z .= ',maquinas_listado_level_'.$i.'.tabla AS LVL_'.$i.'_table';
		$z .= ',maquinas_listado_level_'.$i.'.table_value AS LVL_'.$i.'_table_value';
		$z .= ',maquinas_listado_level_'.$i.'.Direccion_img AS LVL_'.$i.'_imagen ';
		//Joins
		$xx = $i + 1;
		if($xx<=$nmax){
			$leftjoin .= ' LEFT JOIN `maquinas_listado_level_'.$xx.'`   ON maquinas_listado_level_'.$xx.'.idLevel_'.$i.'    = maquinas_listado_level_'.$i.'.idLevel_'.$i;
		}
		//ORDER BY
		$orderby .= ', maquinas_listado_level_'.$i.'.Nombre ASC';
	}

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'maquinas_listado_level_1.idLevel_1 AS bla'.$z;
	$SIS_join  = $leftjoin;
	$SIS_where = 'maquinas_listado_level_1.idMaquina='.simpleDecode($_GET['id'], fecha_actual());
	$SIS_order = 'maquinas_listado_level_1.Nombre ASC'.$orderby;
	$arrItemizado = array();
	$arrItemizado = db_select_array (false, $SIS_query, 'maquinas_listado_level_1', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrItemizado');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUtilizable, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idUtilizable ASC';
	$arrTipos = array();
	$arrTipos = db_select_array (false, $SIS_query, 'core_maquinas_tipo_componente', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');

	//Se crea el arreglo
	$TipoMaq = array();
	foreach($arrTipos as $tipo) {
		$TipoMaq[$tipo['idUtilizable']]['idUtilizable']  = $tipo['idUtilizable'];
		$TipoMaq[$tipo['idUtilizable']]['Nombre']        = $tipo['Nombre'];
	}

	/*********************************************************************/
	$array3d = array();
	foreach($arrItemizado as $key) {

		//Creo Variables para la rejilla
		for ($i = 1; $i <= $nmax; $i++) {

			//creo la variable vacia
			$d[$i]  = '';
			$n[$i]  = '';
			$u[$i]  = '';
			$y[$i]  = '';
			$m[$i]  = '';
			$t[$i]  = '';

			//si el dato solicitado tiene valores sobreescribe la variable
			if(isset($key['LVL_'.$i.'_id'])&&$key['LVL_'.$i.'_id']!=''){                     $d[$i]  = $key['LVL_'.$i.'_id'];}
			if(isset($key['LVL_'.$i.'_Nombre'])&&$key['LVL_'.$i.'_Nombre']!=''){             $n[$i]  = $key['LVL_'.$i.'_Nombre'];}
			if(isset($key['LVL_'.$i.'_idUtilizable'])&&$key['LVL_'.$i.'_idUtilizable']!=''){ $u[$i]  = $key['LVL_'.$i.'_idUtilizable'];}
			if(isset($key['LVL_'.$i.'_table'])&&$key['LVL_'.$i.'_table']!=''){               $y[$i]  = $key['LVL_'.$i.'_table'];}
			if(isset($key['LVL_'.$i.'_table_value'])&&$key['LVL_'.$i.'_table_value']!=''){   $m[$i]  = $key['LVL_'.$i.'_table_value'];}
			if(isset($key['LVL_'.$i.'_imagen'])&&$key['LVL_'.$i.'_imagen']!=''){             $t[$i]  = $key['LVL_'.$i.'_imagen'];}

		}

		if( $d['1']!=''){
			$array3d[$d['1']]['id']         = $d['1'];
			$array3d[$d['1']]['Nombre']     = $n['1'];
			$array3d[$d['1']]['Tipo']       = $u['1'];
			$array3d[$d['1']]['Tabla']      = $y['1'];
			$array3d[$d['1']]['Valor']      = $m['1'];
			$array3d[$d['1']]['Imagen']     = $t['1'];
		}
		if( $d['2']!=''){
			$array3d[$d['1']][$d['2']]['id']         = $d['2'];
			$array3d[$d['1']][$d['2']]['Nombre']     = $n['2'];
			$array3d[$d['1']][$d['2']]['Tipo']       = $u['2'];
			$array3d[$d['1']][$d['2']]['Tabla']      = $y['2'];
			$array3d[$d['1']][$d['2']]['Valor']      = $m['2'];
			$array3d[$d['1']][$d['2']]['Imagen']     = $t['2'];
		}
		if( $d['3']!=''){
			$array3d[$d['1']][$d['2']][$d['3']]['id']         = $d['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Nombre']     = $n['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Tipo']       = $u['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Tabla']      = $y['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Valor']      = $m['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Imagen']     = $t['3'];
		}
		if( $d['4']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']         = $d['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre']     = $n['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tipo']       = $u['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tabla']      = $y['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Valor']      = $m['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Imagen']     = $t['4'];
		}
		if( $d['5']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']         = $d['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre']     = $n['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tipo']       = $u['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tabla']      = $y['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Valor']      = $m['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Imagen']     = $t['5'];
		}
		if( $d['6']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['id']         = $d['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Nombre']     = $n['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tipo']       = $u['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tabla']      = $y['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Valor']      = $m['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Imagen']     = $t['6'];
		}
		if( $d['7']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['id']         = $d['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Nombre']     = $n['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tipo']       = $u['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tabla']      = $y['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Valor']      = $m['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Imagen']     = $t['7'];
		}
		if( $d['8']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['id']         = $d['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Nombre']     = $n['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tipo']       = $u['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tabla']      = $y['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Valor']      = $m['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Imagen']     = $t['8'];
		}
		if( $d['9']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['id']         = $d['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Nombre']     = $n['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tipo']       = $u['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tabla']      = $y['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Valor']      = $m['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Imagen']     = $t['9'];
		}
		if( $d['10']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['id']         = $d['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Nombre']     = $n['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tipo']       = $u['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tabla']      = $y['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Valor']      = $m['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Imagen']     = $t['10'];
		}
		if( $d['11']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['id']         = $d['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Nombre']     = $n['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Tipo']       = $u['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Tabla']      = $y['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Valor']      = $m['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Imagen']     = $t['11'];
		}
		if( $d['12']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['id']         = $d['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Nombre']     = $n['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Tipo']       = $u['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Tabla']      = $y['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Valor']      = $m['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Imagen']     = $t['12'];
		}
		if( $d['13']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['id']         = $d['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Nombre']     = $n['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Tipo']       = $u['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Tabla']      = $y['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Valor']      = $m['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Imagen']     = $t['13'];
		}
		if( $d['14']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['id']         = $d['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Nombre']     = $n['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Tipo']       = $u['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Tabla']      = $y['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Valor']      = $m['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Imagen']     = $t['14'];
		}
		if( $d['15']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['id']         = $d['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Nombre']     = $n['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Tipo']       = $u['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Tabla']      = $y['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Valor']      = $m['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Imagen']     = $t['15'];
		}
	}

	function arrayToUL(array $array, array $TipoMaq, $lv, $rowlevel,$location, $nmax){
		$lv++;
		if($lv==1){
			echo '<ul class="tree">';
		}else{
			echo '<ul style="padding-left: 20px;">';
		}

		foreach ($array as $key => $value){
			//Rearmo la ubicacion de acuerdo a la profundidad
			if (isset($value['id'])){
				$loc = $location.'&lv_'.$lv.'='.$value['id'];
			}else{
				$loc = $location;
			}

			if (isset($value['Nombre'])){
				echo '<li><div class="blum">';
					echo '<div class="pull-left">';
						if(isset($value['Imagen'])&&$value['Imagen']!=''){echo '<div class="btn-group" style="width: 35px;" ><a href="#" title="Click Preview Imagen" class="btn btn-primary btn-sm tooltip pop" src="upload/'.$value['Imagen'].'"><i class="fa fa-picture-o" aria-hidden="true"></i></a></div>';}
						echo '<strong>'.$TipoMaq[$value['Tipo']]['Nombre'].':</strong> ';
						echo $value['Nombre'];
					echo '</div>';
					echo '<div class="btn-group pull-right" >';
						//Boton para editar
						if ($rowlevel>=2){
							echo '<a href="'.$loc.'&edit='.$value['id'].'&lvl='.$lv.'" title="Editar este Componente" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
						}
						//Boton para editar imagen
						if ($rowlevel>=2){
							echo '<a href="'.$loc.'&editimg='.$value['id'].'&lvl='.$lv.'" title="Editar imagen Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
						}
						//Boton para clonar
						if ($rowlevel>=2){
							echo '<a href="'.$loc.'&clone_compo='.$value['id'].'&lvl='.$lv.'" title="Clonar este Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a>';
						}
						//boton para eliminar
						if ($rowlevel>=3){
							$ubicacion = $loc.'&del_idLevel='.simpleEncode($value['id'], fecha_actual()).'&lvl='.$lv.'&nmax='.$nmax;
							$dialogo   = '¿Realmente deseas eliminar todos los datos relacionados a esta Rama?';
							echo '<a onClick="dialogBox(\''.$ubicacion.'\', \''.$dialogo.'\')" title="Borrar este Componente" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						}
					echo '</div>';
					//Boton para crear nueva subrama condicionado solo a componentes
					if ($value['Tipo']==2){
						echo '<div class="btn-group pull-right" style="margin-right:5px;" >';
							if ($rowlevel>=1){
								$xc = $lv + 1;
								echo '<a href="'.$loc.'&new=true&lvl='.$xc.'" title="Crear Sub-Componente" class="btn btn-primary btn-sm tooltip"><i class="fa fa-file-o" aria-hidden="true"></i></a>';
							}
						echo '</div>';
					}
					echo '<div class="clearfix"></div>';
				echo '</div>';
			}
			if (!empty($value) && is_array($value)){
				echo arrayToUL($value, $TipoMaq, $lv, $rowlevel,$loc, $nmax);
			}
			echo '</li>';
		}
		echo '</ul>';
	}



	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Maquinas', $rowData['Nombre'], 'Componentes'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'].'&new=true&lvl=1'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Componente</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'maquinaria_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'maquinaria_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'maquinaria_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha Tecnica</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
							<?php
							//Uso de componentes
							if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){ ?>
								<li class="active"><a href="<?php echo 'maquinaria_listado_componentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Componentes</a></li>
							<?php } ?>
							<?php
							//uso de matriz de analisis
							if(isset($rowData['idConfig_2'])&&$rowData['idConfig_2']==1){ ?>
								<li class=""><a href="<?php echo 'maquinaria_listado_matriz_analisis.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-microchip" aria-hidden="true"></i> Matriz Analisis</a></li>
							<?php } ?>

						</ul>
					</li>
				</ul>
			</header>
			<div class="table-responsive">

				<?php //Se imprime el arbol
				echo arrayToUL($array3d, $TipoMaq, 0, $rowlevel['level'],$new_location.'&id='.$_GET['id'].'&idSistema='.$rowData['idSistema'], $nmax);
				?>

				<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<img src="" class="imagepreview" style="width: 100%;padding: 15px;" >
							</div>
						</div>
					</div>
				</div>
				<script>
					$(function() {
						$('.pop').on('click', function() {
							$('.imagepreview').attr('src',$(this).attr('src'));
							$('#imagemodal').modal('show');
						});
					});
				</script>

			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
