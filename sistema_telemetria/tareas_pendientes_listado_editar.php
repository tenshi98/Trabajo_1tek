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
$original = "tareas_pendientes_listado.php";
$location = $original;
$new_location = "tareas_pendientes_listado_editar.php";
//Se agregan ubicaciones
if(isset($_GET['view']) && $_GET['view']!=''){ $new_location .= "?view=".$_GET['view'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se modifican los datos basicos
if (!empty($_POST['submit_modBase'])){
	//cargo ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'Edit_mod_base';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_responsable'])){
	//cargo ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'Edit_addResponsable';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/*************************************************************************/
//se agrega un subcomponente
if (!empty($_POST['submit_tarea'])){
	//cargo ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'Edit_submit_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se agrega un subcomponente
if (!empty($_POST['edit_tarea'])){
	//cargo ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'Edit_submit_edit_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//cargo ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'Edit_new_file';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_estado'])){
	//cargo ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'Edit_cambio_estado';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['edited'])){        $error['edited']       = 'sucess/Tarea Modificada correctamente';}
if (isset($_GET['createdResp'])){   $error['createdResp']  = 'sucess/Responsable Agregado correctamente';}
if (isset($_GET['createdTarea'])){  $error['createdTarea'] = 'sucess/Tarea Agregada correctamente';}
if (isset($_GET['editTarea'])){     $error['editTarea']    = 'sucess/Tarea Modificada correctamente';}
if (isset($_GET['editFiles'])){     $error['editFiles']    = 'sucess/Archivo Agregado correctamente';}
if (isset($_GET['editEstado'])){    $error['editEstado']   = 'sucess/Estado Modificada correctamente';}

//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit_cambio_estado'])){
/**************************************************************/
// Se trae un listado con todos los elementos
$SIS_query = 'idEstado';
$SIS_join  = '';
$SIS_where = 'idTareas ='.simpleDecode($_GET['view'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Filtro
switch ($_GET['edit_cambio_estado']) {
	case 1: $slc_filter = 'idEstado=2';$slc_tittle = 'Pasar a Ejecucion'; break;
	case 2: $slc_filter = 'idEstado>2';$slc_tittle = 'Cambiar Estado'; break;

}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5><?php echo $slc_tittle; ?></h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEstado)){     $x1 = $idEstado;     }else{$x1 = $rowData['idEstado'];}
				if(isset($Observacion)){  $x2 = $Observacion;  }else{$x2 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Estado','idEstado', $x1, 2, 'idEstado', 'Nombre', 'core_tareas_pendientes_estados', $slc_filter, '', $dbConn);
				$Form_Inputs->form_textarea('Observacion','Observacion', $x2, 1);

				$Form_Inputs->form_input_hidden('idTareas', simpleDecode($_GET['view'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('f_cierre', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_estado">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_trabajo_tarea'])){
/**************************************************************/
// Se trae un listado con todos los elementos
$SIS_query = 'idEstadoTarea,Observacion';
$SIS_join  = '';
$SIS_where = 'idTrabajoTareas ='.simpleDecode($_GET['edit_trabajo_tarea'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'tareas_pendientes_listado_tareas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Tarea</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEstadoTarea)){  $x1 = $idEstadoTarea;    }else{$x1 = $rowData['idEstadoTarea'];}
				if(isset($Observacion)){    $x2 = $Observacion;      }else{$x2 = $rowData['Observacion'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Estado','idEstadoTarea', $x1, 2, 'idEstadoTarea', 'Nombre', 'core_tareas_pendientes_estados_tareas', 0, '', $dbConn);
				$Form_Inputs->form_textarea('Observacion','Observacion', $x2, 2);

				$Form_Inputs->form_input_hidden('idTareas', simpleDecode($_GET['view'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idTrabajoTareas', simpleDecode($_GET['edit_trabajo_tarea'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="edit_tarea">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addFile'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Subir Archivo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idArchivoTipo)){    $x1  = $idArchivoTipo;  }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 15, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

				$Form_Inputs->form_input_hidden('idTareas', simpleDecode($_GET['view'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addtarea'])){
//se dibujan los inputs
$Form_Inputs = new Inputs();
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= ' AND usuarios_sistemas.idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'];
	$usrfil .= ' AND usuarios_listado.idTipoUsuario!=1';
}
$responsables = ' AND (usuarios_listado.idUsuario=0';
//recorro los responsables seleccionados

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = 'idUsuario';
$SIS_join  = '';
$SIS_where = 'idTareas ='.simpleDecode($_GET['view'], fecha_actual());
$SIS_order = 'idUsuario ASC';
$arrRepresentantes = array();
$arrRepresentantes = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrRepresentantes');
//Recorro
if($arrRepresentantes!=false && !empty($arrRepresentantes) && $arrRepresentantes!='') {
	foreach ($arrRepresentantes as $trab) {
		$responsables .= ' OR usuarios_listado.idUsuario = '.$trab['idUsuario'];
	}
}
$responsables .= ')';
$usrfil .= $responsables;

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Trabajos</h5>
		</header>
		<div class="body">

			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
					<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Trabajos</h3>
					<a onclick="tareas_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Trabajos</a>
				</div>
				<div class="clearfix"></div>
				<div id="insert_tarea"></div>

				<?php $Form_Inputs->input_hidden('idTareas', simpleDecode($_GET['view'], fecha_actual()), 2); ?>

				<div class="form-group" style="margin-top:10px;">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_tarea">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<div style="display: none;">

	<div id="clone_tarea" class="tarea_container">

		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 nopadding">
			<div class="form-group">
				<?php $Form_Inputs->input('text','Observacion','Observacion[]', '', 1); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
			<div class="form-group">
				<div class="input-group">
					<?php
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->select('Responsable','idResponsable[]', '',2, 'idUsuario', 'Nombre', 'usuarios_listado', $usrfil,'', $dbConn);
					}else{
						$Form_Inputs->select_bodega('Responsable','idResponsable[]', $x1, 2, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					}
					?>
					<div class="input-group-btn">
						<button class="btn btn-danger tooltip remove_tarea" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

</div>
<div class="clearfix"></div>

<script>

	let room1 = 0;

	/**********************************************************/
	//Se agrega cuartel
	function tareas_add() {
		//se incrementa en 1
		room1++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_tarea');
		let objclone = document.getElementById('clone_tarea'),
		//se clonan los div
		clone_tarea = objclone.cloneNode(true);
		clone_tarea.id = 'new_tarea_'+room1;
		//inserto dentro del div deseado
		objTo.appendChild(clone_tarea);
    }

	//se eliminan filas
	$(document).on('click', '.remove_tarea', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().parent().parent().remove();
	});

</script>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addResponsable'])){
//se dibujan los inputs
$Form_Inputs = new Inputs();
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= ' AND usuarios_sistemas.idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'];
	$usrfil .= ' AND usuarios_listado.idTipoUsuario!=1';
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Responsables</h5>
		</header>
		<div class="body">

			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-bottom:10px;">
					<h3 class="pull-left" style="margin-top: 0px;margin-bottom: 0px;">Responsables</h3>
					<a onclick="responsable_add();"  class="btn btn-default pull-right margin_width" ><i class="fa fa-plus-square-o" aria-hidden="true"></i> Agregar Responsables</a>
				</div>
				<div class="clearfix"></div>
				<div id="insert_responsable"></div>

				<?php $Form_Inputs->input_hidden('idTareas', simpleDecode($_GET['view'], fecha_actual()), 2); ?>

				<div class="form-group" style="margin-top:10px;">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_responsable">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<div style="display: none;">

	<div id="clone_responsable" class="responsable_container">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 nopadding">
			<div class="form-group">
				<div class="input-group">
					<?php
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->select('Responsable','idResponsable[]', '',2, 'idUsuario', 'Nombre', 'usuarios_listado', $usrfil,'', $dbConn);
					}else{
						$Form_Inputs->select_bodega('Responsable','idResponsable[]', $x1, 2, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					}
					?>
					<div class="input-group-btn">
						<button class="btn btn-danger tooltip remove_responsable" type="button" title="Borrar Información" > <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

</div>
<div class="clearfix"></div>

<script>

	let room1 = 0;

	/**********************************************************/
	//Se agrega cuartel
	function responsable_add() {
		//se incrementa en 1
		room1++;
		//se estancian los objetos a clonar
		let objTo    = document.getElementById('insert_responsable');
		let objclone = document.getElementById('clone_responsable'),
		//se clonan los div
		clone_responsable = objclone.cloneNode(true);
		clone_responsable.id = 'new_responsable_'+room1;
		//inserto dentro del div deseado
		objTo.appendChild(clone_responsable);
    }

	//se eliminan filas
	$(document).on('click', '.remove_responsable', function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().parent().parent().remove();
	});

</script>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
/**************************************************************/
// Se trae un listado con todos los elementos
$SIS_query = 'idPrioridad, idTipo, Nombre,Observaciones';
$SIS_join  = '';
$SIS_where = 'idTareas ='.simpleDecode($_GET['view'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar datos basicos de la Tarea</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idPrioridad)){    $x1 = $idPrioridad;    }else{$x1 = $rowData['idPrioridad'];}
				if(isset($idTipo)){         $x2 = $idTipo;         }else{$x2 = $rowData['idTipo'];}
				if(isset($Nombre)){         $x3 = $Nombre;         }else{$x3 = $rowData['Nombre'];}
				if(isset($Observaciones)){  $x4 = $Observaciones;  }else{$x4 = $rowData['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x1, 2, 'idPrioridad', 'Nombre', 'core_tareas_pendientes_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Tarea','idTipo', $x2, 2, 'idTipo', 'Nombre', 'core_tareas_pendientes_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nombre de la tarea', 'Nombre', $x3, 2);
				$Form_Inputs->form_textarea('Descripcion de la Tarea','Observaciones', $x4, 2);

				$Form_Inputs->form_input_hidden('idTareas', simpleDecode($_GET['view'], fecha_actual()), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
//Version antigua de view
$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
/**************************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
tareas_pendientes_listado.f_creacion,
tareas_pendientes_listado.Nombre,
tareas_pendientes_listado.f_termino,
tareas_pendientes_listado.Observaciones,
tareas_pendientes_listado.f_cierre,
tareas_pendientes_listado.ObservacionesCierre,
tareas_pendientes_listado.idUsuario,
tareas_pendientes_listado.idEstado,

core_sistemas.Nombre AS Sistema,
creador.Nombre AS Creador,
core_tareas_pendientes_estados.Nombre AS Estado,
core_tareas_pendientes_prioridad.Nombre AS Prioridad,
core_tareas_pendientes_tipos.Nombre AS Tipo,
cancel.Nombre AS Cancelador';
$SIS_join  = '
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                      = tareas_pendientes_listado.idSistema
LEFT JOIN `usuarios_listado`        creador  ON creador.idUsuario                            = tareas_pendientes_listado.idUsuario
LEFT JOIN `core_tareas_pendientes_estados`   ON core_tareas_pendientes_estados.idEstado      = tareas_pendientes_listado.idEstado
LEFT JOIN `core_tareas_pendientes_prioridad` ON core_tareas_pendientes_prioridad.idPrioridad = tareas_pendientes_listado.idPrioridad
LEFT JOIN `core_tareas_pendientes_tipos`     ON core_tareas_pendientes_tipos.idTipo          = tareas_pendientes_listado.idTipo
LEFT JOIN `usuarios_listado`         cancel  ON cancel.idUsuario                             = tareas_pendientes_listado.idUsuarioCierre';
$SIS_where = 'tareas_pendientes_listado.idTareas ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
tareas_pendientes_listado_responsable.idResponsable,
usuarios_listado.Nombre';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = tareas_pendientes_listado_responsable.idUsuario';
$SIS_where = 'tareas_pendientes_listado_responsable.idTareas ='.$X_Puntero;
$SIS_order = 'usuarios_listado.Nombre ASC';
$arrRepresentantes = array();
$arrRepresentantes = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrRepresentantes');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
tareas_pendientes_listado_tareas.idTrabajoTareas,
tareas_pendientes_listado_tareas.idEstadoTarea,
tareas_pendientes_listado_tareas.idUsuario,
core_tareas_pendientes_estados_tareas.Nombre AS EstadoTarea,
usuarios_listado.Nombre AS Usuario,
tareas_pendientes_listado_tareas.Observacion';
$SIS_join  = '
LEFT JOIN `core_tareas_pendientes_estados_tareas`   ON core_tareas_pendientes_estados_tareas.idEstadoTarea   = tareas_pendientes_listado_tareas.idEstadoTarea
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                            = tareas_pendientes_listado_tareas.idUsuario';
$SIS_where = 'tareas_pendientes_listado_tareas.idTareas ='.$X_Puntero;
$SIS_order = 'core_tareas_pendientes_estados_tareas.Nombre ASC, usuarios_listado.Nombre ASC, tareas_pendientes_listado_tareas.Observacion ASC';
$arrTareas = array();
$arrTareas = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_tareas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTareas');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = 'idAdjunto, NombreArchivo';
$SIS_join  = '';
$SIS_where = 'idTareas ='.$X_Puntero;
$SIS_order = 'NombreArchivo ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_tareas_adjuntos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArchivos');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
tareas_pendientes_listado_historial.Creacion_fecha,
tareas_pendientes_listado_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`  ON core_historial_tipos.idTipo = tareas_pendientes_listado_historial.idTipo
LEFT JOIN `usuarios_listado`      ON usuarios_listado.idUsuario  = tareas_pendientes_listado_historial.idUsuario';
$SIS_where = 'tareas_pendientes_listado_historial.idTareas ='.$X_Puntero;
$SIS_order = 'tareas_pendientes_listado_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrHistorial');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1&&($_SESSION['usuario']['basic_data']['idUsuario']==$rowData['idUsuario'] OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1)){  ?>
			<a href="<?php echo $new_location.'&edit_cambio_estado=1'; ?>"  class="btn btn-primary"><i class="fa fa-check-square-o" aria-hidden="true"></i> Pasar a Ejecucion</a>
		<?php } ?>
		<?php
		//Cuento las tareas
		$total_tareas    = 0;
		$tareas_cerradas = 0;
		//recorro
		if($arrTareas!=false && !empty($arrTareas) && $arrTareas!='') {
			foreach ($arrTareas as $tarea) {
				//sumo 1 a la tarea
				$total_tareas++;
				if(isset($tarea['idEstadoTarea'])&&$tarea['idEstadoTarea']!=1){
					$tareas_cerradas++;
				}
			}
		}
		//muestro el boton solo si todas las tareas estan ejecutadas
		if(isset($rowData['idEstado'])&&$rowData['idEstado']==2&&$total_tareas!=0&&$total_tareas==$tareas_cerradas&&($_SESSION['usuario']['basic_data']['idUsuario']==$rowData['idUsuario'] OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1)){  ?>
			<a href="<?php echo $new_location.'&edit_cambio_estado=2'; ?>"  class="btn btn-primary"><i class="fa fa-check-square-o" aria-hidden="true"></i> Cerrar Tarea</a>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-bottom:30px!important;">

	<div id="page-wrap">
		<div id="header"> TAREAS PENDIENTES</div>
		<div id="customer">
			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head">
							<?php
							//solo se puede agregar responsables por quien creo la tarea o es superadministrador
							if($_SESSION['usuario']['basic_data']['idUsuario']==$rowData['idUsuario'] OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?>
								<a href="<?php echo $new_location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td class="meta-head">Estado</td>
						<td><?php echo $rowData['Estado']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Prioridad</td>
						<td><?php echo $rowData['Prioridad']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Tipo de Tarea</td>
						<td><?php echo $rowData['Tipo']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Nombre de la Tarea</td>
						<td><?php echo $rowData['Nombre']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Creador</td>
						<td><?php echo $rowData['Creador']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Sistema</td>
						<td><?php echo $rowData['Sistema']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td><?php echo Fecha_estandar($rowData['f_creacion']); ?></td>
					</tr>
					<?php if(isset($rowData['f_termino'])&&$rowData['f_termino']!='0000-00-00'){ ?>
						<tr>
							<td class="meta-head">Fecha Termino</td>
							<td><?php echo Fecha_estandar($rowData['f_termino']); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<table id="items">
			<tbody>

				<tr>
					<th colspan="5">Detalle</th>
					<th width="10">Acciones</th>
				</tr>
				<?php /**********************************************************************************/?>
				<tr class="item-row fact_tittle">
					<td colspan="6">Tarea</td>
				</tr>
				<tr class="item-row linea_punteada" style="white-space: initial;">
					<td class="item-name" colspan="6"><?php echo $rowData['Observaciones']; ?></td>
				</tr>
				<?php /**********************************************************************************/?>
				<tr class="item-row fact_tittle">
					<td colspan="5">Responsables</td>
					<?php
					//solo se puede agregar responsables por quien creo la tarea o es superadministrador
					if($_SESSION['usuario']['basic_data']['idUsuario']==$rowData['idUsuario'] OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?>
						<td><a href="<?php echo $new_location.'&addResponsable=true' ?>" title="Agregar Responsables" class="btn btn-xs btn-primary tooltip"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a></td>
					<?php } ?>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				if($arrRepresentantes!=false && !empty($arrRepresentantes) && $arrRepresentantes!='') {
					foreach ($arrRepresentantes as $resp) { ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="6"><?php echo $resp['Nombre']; ?></td>
						</tr>
					 <?php
					}
				 }else{
					echo '<tr class="item-row"><td colspan="6">No hay Responsables asignados</td></tr>';
				} ?>
				<?php /**********************************************************************************/?>
				<tr class="item-row fact_tittle">
					<td colspan="5">Trabajos a Realizar</td>
					<td>
						<?php
						//solo se puede agregar responsables por quien creo la tarea o es superadministrador
						if($arrRepresentantes!=false && !empty($arrRepresentantes) && $arrRepresentantes!='' &&($_SESSION['usuario']['basic_data']['idUsuario']==$rowData['idUsuario'] OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1)){ ?>
							<a href="<?php echo $new_location.'&addtarea=true' ?>" title="Agregar Tarea" class="btn btn-xs btn-primary tooltip"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if($arrTareas!=false && !empty($arrTareas) && $arrTareas!='') {
					foreach ($arrTareas as $tarea) { ?>
						<tr class="item-row linea_punteada" style="white-space: initial;">
							<td class="item-name" colspan="4"><?php echo '<strong>'.$tarea['Usuario'].': </strong>'.$tarea['Observacion']; ?></td>
							<td class="item-name" width="160"><?php echo $tarea['EstadoTarea']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if(isset($tarea['idEstadoTarea'])&&$tarea['idEstadoTarea']==1&&($_SESSION['usuario']['basic_data']['idUsuario']==$tarea['idUsuario'] OR $_SESSION['usuario']['basic_data']['idUsuario']==$rowData['idUsuario'])){ ?>
										<a href="<?php echo $new_location.'&edit_trabajo_tarea='.simpleEncode($tarea['idTrabajoTareas'], fecha_actual()); ?>" title="Editar Trabajos" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					 <?php
					}
				}else{
					echo '<tr class="item-row"><td colspan="6">No hay trabajos asignados</td></tr>';
				} ?>
			<?php /**********************************************************************************/?>
			<tr class="item-row fact_tittle">
                <td colspan="5">Archivos Adjuntos</td>
                <td><a href="<?php echo $new_location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a></td>
            </tr>
			<?php
			if($arrArchivos!=false && !empty($arrArchivos) && $arrArchivos!='') {
				foreach ($arrArchivos as $archivo){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $archivo['NombreArchivo']; ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($archivo['NombreArchivo'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
					<?php
				}
			} ?>
			</tbody>
		</table>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">
		<div class="row">
			<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
				<table id="items">
					<tbody>
						<tr>
							<th colspan="3">Historial</th>
						</tr>
						<tr>
							<th width="120">Fecha</th>
							<th>Usuario</th>
							<th>Observacion</th>
						</tr>
						<?php foreach ($arrHistorial as $doc){ ?>
							<tr class="item-row" style="white-space: initial;">
								<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
								<td><?php echo $doc['Usuario']; ?></td>
								<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>

</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
