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
$original = "orden_trabajo_motivo_quejas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){                  $location .= "&idUsuario=".$_GET['idUsuario'];                  $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idOT']) && $_GET['idOT']!=''){                            $location .= "&idOT=".$_GET['idOT'];                            $search .= "&idOT=".$_GET['idOT'];}
if(isset($_GET['idUsuarioQueja']) && $_GET['idUsuarioQueja']!=''){        $location .= "&idUsuarioQueja=".$_GET['idUsuarioQueja'];        $search .= "&idUsuarioQueja=".$_GET['idUsuarioQueja'];}
if(isset($_GET['idTrabajadorQueja']) && $_GET['idTrabajadorQueja']!=''){  $location .= "&idTrabajadorQueja=".$_GET['idTrabajadorQueja'];  $search .= "&idTrabajadorQueja=".$_GET['idTrabajadorQueja'];}
if(isset($_GET['NombreQueja']) && $_GET['NombreQueja']!=''){              $location .= "&NombreQueja=".$_GET['NombreQueja'];              $search .= "&NombreQueja=".$_GET['NombreQueja'];}
if(isset($_GET['idTipoQueja']) && $_GET['idTipoQueja']!=''){              $location .= "&idTipoQueja=".$_GET['idTipoQueja'];              $search .= "&idTipoQueja=".$_GET['idTipoQueja'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/orden_trabajo_tareas_quejas.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/orden_trabajo_tareas_quejas.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/orden_trabajo_tareas_quejas.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Queja Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Queja Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Queja Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idOT, idUsuarioQueja, idTipoQueja, Observaciones, idTrabajadorQueja, NombreQueja';
	$SIS_join  = '';
	$SIS_where = 'idQueja = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_quejas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');
	/*******************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	$z2 = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación Queja</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idOT)){              $x1  = $idOT;               }else{$x1  = $rowData['idOT'];}
					if(isset($idUsuarioQueja)){    $x2  = $idUsuarioQueja;     }else{$x2  = $rowData['idUsuarioQueja'];}
					if(isset($idTrabajadorQueja)){ $x3  = $idTrabajadorQueja;  }else{$x3  = $rowData['idTrabajadorQueja'];}
					if(isset($NombreQueja)){       $x4  = $NombreQueja;        }else{$x4  = $rowData['NombreQueja'];}
					if(isset($idTipoQueja)){       $x5  = $idTipoQueja;        }else{$x5  = $rowData['idTipoQueja'];}
					if(isset($Observaciones)){     $x6  = $Observaciones;      }else{$x6  = $rowData['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_number('OT','idOT', $x1, 2);
					$Form_Inputs->form_select_join_filter('Usuario Queja','idUsuarioQueja', $x2, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Queja','idTrabajadorQueja', $x3, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z2, '', $dbConn);
					$Form_Inputs->form_input_text('Persona Queja', 'NombreQueja', $x4, 1);
					$Form_Inputs->form_select('Tipo Queja','idTipoQueja', $x5, 2, 'idTipoQueja', 'Nombre', 'core_tipo_queja', 0, '', $dbConn);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('FechaQueja', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idQueja', $_GET['id'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	$z2 = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Queja</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idOT)){              $x1  = $idOT;               }else{$x1  = '';}
					if(isset($idUsuarioQueja)){    $x2  = $idUsuarioQueja;     }else{$x2  = '';}
					if(isset($idTrabajadorQueja)){ $x3  = $idTrabajadorQueja;  }else{$x3  = '';}
					if(isset($NombreQueja)){       $x4  = $NombreQueja;        }else{$x4  = '';}
					if(isset($idTipoQueja)){       $x5  = $idTipoQueja;        }else{$x5  = '';}
					if(isset($Observaciones)){     $x6  = $Observaciones;      }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_number('OT','idOT', $x1, 2);
					$Form_Inputs->form_select_join_filter('Usuario Queja','idUsuarioQueja', $x2, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Queja','idTrabajadorQueja', $x3, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z2, '', $dbConn);
					$Form_Inputs->form_input_text('Persona Queja', 'NombreQueja', $x4, 1);
					$Form_Inputs->form_select('Tipo Queja','idTipoQueja', $x5, 2, 'idTipoQueja', 'Nombre', 'core_tipo_queja', 0, '', $dbConn);
					$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('FechaQueja', fecha_actual(), 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
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
			case 'ot_asc':        $order_by = 'orden_trabajo_tareas_quejas.idOT ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> OT Ascendente';break;
			case 'ot_desc':       $order_by = 'orden_trabajo_tareas_quejas.idOT DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> OT Descendente';break;
			case 'usuario_asc':   $order_by = 'usuarios_listado.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente';break;
			case 'usuario_desc':  $order_by = 'usuarios_listado.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
			case 'queja_asc':     $order_by = 'usuario_queja.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Queja Ascendente';break;
			case 'queja_desc':    $order_by = 'usuario_queja.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Queja Descendente';break;
			case 'tipo_asc':      $order_by = 'core_tipo_queja.Nombre ASC ';                   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Queja Ascendente';break;
			case 'tipo_desc':     $order_by = 'core_tipo_queja.Nombre DESC ';                  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Queja Descendente';break;
			case 'fecha_asc':     $order_by = 'orden_trabajo_tareas_quejas.FechaQueja ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Queja Ascendente';break;
			case 'fecha_desc':    $order_by = 'orden_trabajo_tareas_quejas.FechaQueja DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Queja Descendente';break;

			default: $order_by = 'orden_trabajo_tareas_quejas.idOT DESC'; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> OT Ascendente';
		}
	}else{
		$order_by = 'orden_trabajo_tareas_quejas.idOT DESC'; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> OT Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "orden_trabajo_tareas_quejas.idQueja!=0";
	//sistema
	$SIS_where.= " AND orden_trabajo_tareas_quejas.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){                   $SIS_where .= " AND orden_trabajo_tareas_quejas.idUsuario=".$_GET['idUsuario'];}
	if(isset($_GET['idOT']) && $_GET['idOT']!=''){                             $SIS_where .= " AND orden_trabajo_tareas_quejas.idOT='".$_GET['idOT']."'";}
	if(isset($_GET['idUsuarioQueja']) && $_GET['idUsuarioQueja']!=''){         $SIS_where .= " AND orden_trabajo_tareas_quejas.idUsuarioQueja=".$_GET['idUsuarioQueja'];}
	if(isset($_GET['idTrabajadorQueja']) && $_GET['idTrabajadorQueja']!=''){   $SIS_where .= " AND orden_trabajo_tareas_quejas.idTrabajadorQueja=".$_GET['idTrabajadorQueja'];}
	if(isset($_GET['NombreQueja']) && $_GET['NombreQueja']!=''){               $SIS_where .= " AND orden_trabajo_tareas_quejas.NombreQueja=".$_GET['NombreQueja'];}
	if(isset($_GET['idTipoQueja']) && $_GET['idTipoQueja']!=''){               $SIS_where .= " AND orden_trabajo_tareas_quejas.idTipoQueja=".$_GET['idTipoQueja'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idQueja', 'orden_trabajo_tareas_quejas', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	orden_trabajo_tareas_quejas.idQueja,
	orden_trabajo_tareas_quejas.idOT,
	core_sistemas.Nombre AS sistema,
	usuarios_listado.Nombre AS Usuario,
	trabajadores_listado.Nombre AS TrabajadorNombre,
	trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
	trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
	orden_trabajo_tareas_quejas.NombreQueja,
	usuario_queja.Nombre AS UsuarioQueja,
	core_tipo_queja.Nombre AS TipoQueja,
	orden_trabajo_tareas_quejas.FechaQueja';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                   ON core_sistemas.idSistema              = orden_trabajo_tareas_quejas.idSistema
	LEFT JOIN `usuarios_listado`                ON usuarios_listado.idUsuario           = orden_trabajo_tareas_quejas.idUsuario
	LEFT JOIN `trabajadores_listado`            ON trabajadores_listado.idTrabajador    = orden_trabajo_tareas_quejas.idTrabajadorQueja
	LEFT JOIN `usuarios_listado` usuario_queja  ON usuario_queja.idUsuario              = orden_trabajo_tareas_quejas.idUsuarioQueja
	LEFT JOIN `core_tipo_queja`                 ON core_tipo_queja.idTipoQueja          = orden_trabajo_tareas_quejas.idTipoQueja';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrUsers = array();
	$arrUsers = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_quejas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

	//Verifico el tipo de usuario que esta ingresando
	$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
	}
	$z2="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Queja</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idUsuario)){          $x1  = $idUsuario;           }else{$x1  = '';}
					if(isset($idOT)){               $x2  = $idOT;                }else{$x2  = '';}
					if(isset($idUsuarioQueja)){     $x3  = $idUsuarioQueja;      }else{$x3  = '';}
					if(isset($idTrabajadorQueja)){  $x4  = $idTrabajadorQueja;   }else{$x4  = '';}
					if(isset($NombreQueja)){        $x5  = $NombreQueja;         }else{$x5  = '';}
					if(isset($idTipoQueja)){        $x6  = $idTipoQueja;         }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x1, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_input_number('OT','idOT', $x2, 1);
					$Form_Inputs->form_select_join_filter('Usuario Queja','idUsuarioQueja', $x3, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Queja','idTrabajadorQueja', $x4, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z2, '', $dbConn);
					$Form_Inputs->form_input_text('Persona Queja', 'NombreQueja', $x5, 1);
					$Form_Inputs->form_select('Tipo Queja','idTipoQueja', $x6, 1, 'idTipoQueja', 'Nombre', 'core_tipo_queja', 0, '', $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Quejas</h5>
				<div class="toolbar">
					<?php
					//Se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">OT</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ot_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ot_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Usuario</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Usuario Queja</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=queja_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=queja_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Tipo Queja</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Fecha Queja</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrUsers as $usuarios){ ?>
							<tr class="odd">
								<td><?php echo n_doc($usuarios['idOT'], 5); ?></td>
								<td><?php echo $usuarios['Usuario']; ?></td>
								<td>
									<?php
									echo $usuarios['UsuarioQueja'];
									echo $usuarios['TrabajadorNombre'].' '.$usuarios['TrabajadorApellidoPat'].' '.$usuarios['TrabajadorApellidoMat'];
									echo $usuarios['NombreQueja'];
									?>
								</td>
								<td><?php echo $usuarios['TipoQueja']; ?></td>
								<td><?php echo fecha_estandar($usuarios['FechaQueja']); ?></td>
								<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
								<td>
									<div class="btn-group" style="width: 105px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_orden_trabajo_tareas_quejas.php?view='.simpleEncode($usuarios['idQueja'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idQueja']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($usuarios['idQueja'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la queja de la OT '.n_doc($usuarios['idOT'], 5).'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
