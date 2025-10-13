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
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['f_creacion']) && $_GET['f_creacion']!=''){     $location .= "&f_creacion=".$_GET['f_creacion'];     $search .= "&f_creacion=".$_GET['f_creacion'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){      $location .= "&Nombre=".$_GET['Nombre'];             $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){   $location .= "&idPrioridad=".$_GET['idPrioridad'];   $search .= "&idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){      $location .= "&idTipo=".$_GET['idTipo'];             $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){  $location .= "&idEstado=".$_GET['idEstado'];         $search .= "&idEstado=".$_GET['idEstado'];}

/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se cera la orden
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'creacion';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se borra n los datos temporales
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se modifican los datos basicos
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'mod_base';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_responsable'])){
	//Llamamos al formulario
	$form_trabajo= 'addResponsable';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se borra un trabajo
if (!empty($_GET['del_responsable'])){
	//Llamamos al formulario
	$form_trabajo= 'del_responsable';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/*************************************************************************/
//se agrega un subcomponente
if (!empty($_POST['submit_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'submit_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se elimina un subcomponente
if (!empty($_GET['del_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'del_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
/*************************************************************************/
//se crea la ot
if (!empty($_GET['crear_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'crear_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se borra la ot
if (!empty($_GET['delete_tarea'])){
	//Llamamos al formulario
	$form_trabajo= 'delete_tarea';
	require_once 'A1XRXS_sys/xrxs_form/z_tareas_pendientes_listado.php';
}
//se clona una ot
if (!empty($_POST['submit_cancel'])){
	//Llamamos al formulario
	$form_trabajo= 'cancel_tarea';
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
if (isset($_GET['created'])){     $error['created']     = 'sucess/Tarea Creada correctamente';}
if (isset($_GET['edited'])){      $error['edited']      = 'sucess/Tarea Modificada correctamente';}
if (isset($_GET['deleted'])){     $error['deleted']     = 'sucess/Tarea Borrada correctamente';}
if (isset($_GET['canceled'])){    $error['canceled']    = 'sucess/Tarea cancelada correctamente';}
if (isset($_GET['notslectjob'])){ $error['notslectjob'] = 'error/No ha seleccionado un trabajo a realizar';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['cancel'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Cancelar Tarea</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($f_programacion)){    $x1  = $f_programacion;   }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_textarea('Motivo Cancelacion','ObservacionesCierre', $x1, 2);

				$Form_Inputs->form_input_hidden('idTareas', simpleDecode($_GET['cancel'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idUsuarioCierre', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('f_cierre', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_cancel">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $location.'&view='.$_GET['view']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
foreach ($_SESSION['tareas_responsables'] as $key => $trab){
	$responsables .= ' OR usuarios_listado.idUsuario = '.$trab['idResponsable'];
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

				<div class="form-group" style="margin-top:10px;">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_tarea">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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

				<div class="form-group" style="margin-top:10px;">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_responsable">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
}elseif(!empty($_GET['modBase'])){ ?>

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
				if(isset($idPrioridad)){    $x1 = $idPrioridad;    }else{$x1 = $_SESSION['tareas_basicos']['idPrioridad'];}
				if(isset($idTipo)){         $x2 = $idTipo;         }else{$x2 = $_SESSION['tareas_basicos']['idTipo'];}
				if(isset($Nombre)){         $x3 = $Nombre;         }else{$x3 = $_SESSION['tareas_basicos']['Nombre'];}
				if(isset($Observaciones)){  $x4 = $Observaciones;  }else{$x4 = $_SESSION['tareas_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x1, 2, 'idPrioridad', 'Nombre', 'core_tareas_pendientes_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Tarea','idTipo', $x2, 2, 'idTipo', 'Nombre', 'core_tareas_pendientes_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nombre de la tarea', 'Nombre', $x3, 2);
				$Form_Inputs->form_textarea('Descripcion de la Tarea','Observaciones', $x4, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){ ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los datos de la OT en curso?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&crear_tarea=true';
		$dialogo   = '¿Desea crear ingresar el documento, tenga en cuenta que no podra realizar mas modificaciones una vez creada?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary"><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Tarea</a>

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
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Estado</td>
						<td><?php echo $_SESSION['tareas_basicos']['Estado']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Prioridad</td>
						<td><?php echo $_SESSION['tareas_basicos']['Prioridad']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Tipo de Tarea</td>
						<td><?php echo $_SESSION['tareas_basicos']['Tipo']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Nombre de la Tarea</td>
						<td><?php echo $_SESSION['tareas_basicos']['Nombre']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha creación</td>
						<td><?php echo Fecha_estandar($_SESSION['tareas_basicos']['f_creacion']); ?></td>
					</tr>
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
					<td class="item-name" colspan="6"><?php echo $_SESSION['tareas_basicos']['Observaciones']; ?></td>
				</tr>
				<?php /**********************************************************************************/?>
				<tr class="item-row fact_tittle">
					<td colspan="5">Responsables</td>
					<td><a href="<?php echo $location.'&addResponsable=true' ?>" title="Agregar Responsables" class="btn btn-xs btn-primary tooltip"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a></td>
				</tr>
				<?php
				//recorro el lsiatdo entregado por la base de datos
				if (isset($_SESSION['tareas_responsables'])){
					foreach ($_SESSION['tareas_responsables'] as $key => $resp){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="5"><?php echo $resp['Responsables']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php
									$ubicacion = $location.'&del_responsable='.$resp['idResponsable'];
									$dialogo   = '¿Realmente deseas eliminar al responsable '.$resp['Responsables'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Responsable" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
								</div>
							</td>
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
						<?php if (isset($_SESSION['tareas_responsables'])){ ?>
							<a href="<?php echo $location.'&addtarea=true' ?>" title="Agregar Tarea" class="btn btn-xs btn-primary tooltip"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a>
						<?php } ?>
					</td>
				</tr>
				<?php
				if (isset($_SESSION['tareas_tareas'])){
					foreach ($_SESSION['tareas_tareas'] as $key => $tarea){ ?>
						<tr class="item-row linea_punteada" style="white-space: initial;">
							<td class="item-name" colspan="5"><?php echo '<strong>'.$tarea['Responsables'].': </strong>'.$tarea['Observacion']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php
									$ubicacion = $location.'&del_tarea='.$tarea['idInterno'];
									$dialogo   = '¿Realmente deseas eliminar el trabajo '.$tarea['Observacion'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Responsable" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
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
                <td><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a></td>
            </tr>

			<?php
			if (isset($_SESSION['tareas_archivos'])){
				foreach ($_SESSION['tareas_archivos'] as $key => $archivo){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $archivo['NombreArchivo']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($archivo['NombreArchivo'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del_file='.$archivo['idFile'];
								$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$archivo['NombreArchivo']).'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
					<?php
				}
			}else{
				echo '<tr class="item-row"><td colspan="6">No hay archivos cargados</td></tr>';
			} ?>
			</tbody>
		</table>
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
			<h5>Crear Nueva Tarea Pendiente</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idPrioridad)){    $x1 = $idPrioridad;    }else{$x1 = '';}
				if(isset($idTipo)){         $x2 = $idTipo;         }else{$x2 = '';}
				if(isset($Nombre)){         $x3 = $Nombre;         }else{$x3 = '';}
				if(isset($Observaciones)){  $x4 = $Observaciones;  }else{$x4 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x1, 2, 'idPrioridad', 'Nombre', 'core_tareas_pendientes_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Tarea','idTipo', $x2, 2, 'idTipo', 'Nombre', 'core_tareas_pendientes_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Nombre de la tarea', 'Nombre', $x3, 2);
				$Form_Inputs->form_textarea('Descripcion de la Tarea','Observaciones', $x4, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('f_creacion', fecha_actual(), 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Crear Tarea" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
/**********************************************************/
//paginador de resultados
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'fcreacion_asc':      $order_by = 'tareas_pendientes_listado.f_creacion ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Creacion Ascendente';break;
		case 'fcreacion_desc':     $order_by = 'tareas_pendientes_listado.f_creacion DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Creacion Descendente';break;
		case 'nombre_asc':         $order_by = 'tareas_pendientes_listado.Nombre ASC ';          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
		case 'nombre_desc':        $order_by = 'tareas_pendientes_listado.Nombre DESC ';         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'prioridad_asc':      $order_by = 'core_tareas_pendientes_prioridad.Nombre ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prioridad Ascendente';break;
		case 'prioridad_desc':     $order_by = 'core_tareas_pendientes_prioridad.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Prioridad Descendente';break;
		case 'tipotrab_asc':       $order_by = 'core_tareas_pendientes_tipos.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Tarea Ascendente'; break;
		case 'tipotrab_desc':      $order_by = 'core_tareas_pendientes_tipos.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Tarea Descendente';break;
		case 'estado_asc':         $order_by = 'core_tareas_pendientes_estados.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente'; break;
		case 'estado_desc':        $order_by = 'core_tareas_pendientes_estados.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

		default: $order_by = 'tareas_pendientes_listado.idTareas DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> OT Descendente';
	}
}else{
	$order_by = 'tareas_pendientes_listado.idTareas DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> OT Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where  = "tareas_pendientes_listado.idTareas!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where .= " AND tareas_pendientes_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['f_creacion']) && $_GET['f_creacion']!=''){   $SIS_where .= " AND tareas_pendientes_listado.f_creacion='".$_GET['f_creacion']."'";}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){    $SIS_where .= " AND tareas_pendientes_listado.Nombre='".$_GET['Nombre']."'";}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){ $SIS_where .= " AND tareas_pendientes_listado.idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){    $SIS_where .= " AND tareas_pendientes_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){$SIS_where .= " AND tareas_pendientes_listado.idEstado=".$_GET['idEstado'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idTareas', 'tareas_pendientes_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
tareas_pendientes_listado.idTareas,
tareas_pendientes_listado.f_creacion,
tareas_pendientes_listado.Nombre,
tareas_pendientes_listado.idEstado,
core_tareas_pendientes_prioridad.Nombre AS Prioridad,
core_tareas_pendientes_tipos.Nombre AS Tipo,
core_tareas_pendientes_estados.Nombre AS Estado,
core_sistemas.Nombre AS Sistema';
$SIS_join  = '
LEFT JOIN `core_tareas_pendientes_prioridad` ON core_tareas_pendientes_prioridad.idPrioridad = tareas_pendientes_listado.idPrioridad
LEFT JOIN `core_tareas_pendientes_tipos`     ON core_tareas_pendientes_tipos.idTipo          = tareas_pendientes_listado.idTipo
LEFT JOIN `core_tareas_pendientes_estados`   ON core_tareas_pendientes_estados.idEstado      = tareas_pendientes_listado.idEstado
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                      = tareas_pendientes_listado.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTareas = array();
$arrTareas = db_select_array (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTareas');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){
	if (isset($_SESSION['tareas_basicos']['idMaquina'])&&$_SESSION['tareas_basicos']['idMaquina']!=''){ ?>

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

		<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-arrow-right" aria-hidden="true"></i> Continuar Tarea Pendiente</a>
	<?php }else{ ?>
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Tarea Pendiente</a>
	<?php }
	 } ?>
</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($f_creacion)){   $x1 = $f_creacion;    }else{$x1 = '';}
				if(isset($Nombre)){       $x2 = $Nombre;        }else{$x2 = '';}
				if(isset($idPrioridad)){  $x3 = $idPrioridad;   }else{$x3 = '';}
				if(isset($idTipo)){       $x4 = $idTipo;        }else{$x4 = '';}
				if(isset($idEstado)){     $x5 = $idEstado;      }else{$x5 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Creacion','f_creacion', $x1, 1);
				$Form_Inputs->form_input_text('Nombre de la tarea', 'Nombre', $x2, 1);
				$Form_Inputs->form_select('Prioridad','idPrioridad', $x3, 1, 'idPrioridad', 'Nombre', 'core_tareas_pendientes_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Tarea','idTipo', $x4, 1, 'idTipo', 'Nombre', 'core_tareas_pendientes_tipos', 0, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x5, 1, 'idEstado', 'Nombre', 'core_tareas_pendientes_estados', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('pagina', 1, 1);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>

			</form>
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tareas Pendientes</h5>
			<div class="toolbar">
				<?php
				//se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">Fecha Creacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fcreacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fcreacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Nombre Tarea</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Prioridad</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=prioridad_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=prioridad_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo Trabajo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipotrab_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipotrab_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTareas as $ot) { ?>
					<tr class="odd">
						<td><?php echo Fecha_estandar($ot['f_creacion']); ?></td>
						<td style="white-space: initial;"><?php echo $ot['Nombre']; ?></td>
						<td><?php echo $ot['Prioridad']; ?></td>
						<td><?php echo $ot['Tipo']; ?></td>
						<td><?php echo $ot['Estado']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $ot['Sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 140px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_tarea_pendiente.php?view='.simpleEncode($ot['idTareas'], fecha_actual()); ?>" title="Ver Tarea" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if(isset($ot['idEstado'])&&$ot['idEstado'] <= 2){ ?>
									<?php if ($rowlevel['level']>=2){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'tareas_pendientes_listado_editar.php?view='.simpleEncode($ot['idTareas'], fecha_actual()); ?>" title="Editar Tarea" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location.'&cancel='.simpleEncode($ot['idTareas'], fecha_actual()); ?>" title="Cancelar Tarea" class="btn btn-danger btn-sm tooltip"><i class="fa fa-ban" aria-hidden="true"></i></a><?php } ?>
								<?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&delete_tarea='.simpleEncode($ot['idTareas'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la tarea '.$ot['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php
			//se llama al paginador
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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
