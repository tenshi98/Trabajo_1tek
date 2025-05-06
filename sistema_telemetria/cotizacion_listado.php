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
$original = "cotizacion_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){            $location .= "&idCliente=".$_GET['idCliente'];            $search .= "&idCliente=".$_GET['idCliente'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];  $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
/********************************************************************/
if(isset($_GET['soli']) && $_GET['soli']!=''){   $location .= "&soli=".$_GET['soli']; 	}
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//se borran todas las variables
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'new_prod_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_prod_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'del_prod_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'new_ins_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_ins_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'del_ins_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'new_arriendo_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_arriendo_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'del_arriendo_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'new_servicio_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_servicio_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'del_servicio_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_impuesto'])){
	//Llamamos al formulario
	$form_trabajo= 'new_impuesto';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del_impuesto'])){
	//Llamamos al formulario
	$form_trabajo= 'del_impuesto';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************/
//se realiza el ingreso de la Cotizacion
if (!empty($_GET['ing_cotizacion'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_cotizacion';
	require_once 'A1XRXS_sys/xrxs_form/z_cotizacion_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Documento Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Documento Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Documento Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['addFile'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Subir Archivo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

					<?php
					//Se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 1, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editServicios'])){  ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Servicio</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idServicio)){     $x1  = $idServicio;    }else{$x1  = $_SESSION['cotizacion_servicios'][$_GET['editServicios']]['idServicio'];}
					if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($_SESSION['cotizacion_servicios'][$_GET['editServicios']]['Cantidad']);}
					if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['cotizacion_servicios'][$_GET['editServicios']]['idFrecuencia'];}
					if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($_SESSION['cotizacion_servicios'][$_GET['editServicios']]['vTotal']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
					$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['cotizacion_servicios'][$_GET['editServicios']]['idServicio'], 2);

					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['cotizacion_servicios'][$_GET['editServicios']]['vUnitario']));
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
					$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['cotizacion_servicios'][$_GET['editServicios']]['vUnitario']), 2);

					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_servicio">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addServicios'])){  ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Servicio</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idServicio)){     $x1  = $idServicio;    }else{$x1  = '';}
					if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = '';}
					if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = '';}
					if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
					$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
					$Form_Inputs->form_input_hidden('vUnitario', '', 2);

					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_servicio">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editArriendo'])){  ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Equipo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idEquipo)){       $x1  = $idEquipo;      }else{$x1  = $_SESSION['cotizacion_arriendos'][$_GET['editArriendo']]['idEquipo'];}
					if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = Cantidades_decimales_justos($_SESSION['cotizacion_arriendos'][$_GET['editArriendo']]['Cantidad']);}
					if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['cotizacion_arriendos'][$_GET['editArriendo']]['idFrecuencia'];}
					if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = Cantidades_decimales_justos($_SESSION['cotizacion_arriendos'][$_GET['editArriendo']]['vTotal']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Equipos','idEquipo', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
					$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['cotizacion_arriendos'][$_GET['editArriendo']]['idEquipo'], 2);

					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['cotizacion_arriendos'][$_GET['editArriendo']]['vUnitario']));
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
					$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['cotizacion_arriendos'][$_GET['editArriendo']]['vUnitario']), 2);

					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_arriendo">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addArriendo'])){  ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Equipo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idEquipo)){       $x1  = $idEquipo;      }else{$x1  = '';}
					if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = '';}
					if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = '';}
					if(isset($vTotal)){         $x4  = $vTotal;        }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Equipos','idEquipo', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
					$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x4, 2);
					$Form_Inputs->form_input_hidden('vUnitario', '', 2);

					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_arriendo">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editIns'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	insumos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml = insumos_listado.idUml';
	$SIS_where = 'insumos_listado.idProducto='.$_SESSION['cotizacion_insumos'][$_GET['editIns']]['idProducto'];
	$rowData = db_select_data (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	//filtro
	$zx2 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx2 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar solicitud de Insumo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $_SESSION['cotizacion_insumos'][$_GET['editIns']]['idProducto'];}
					if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = Cantidades_decimales_justos($_SESSION['cotizacion_insumos'][$_GET['editIns']]['Cantidad']);}
					if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = Cantidades_decimales_justos($_SESSION['cotizacion_insumos'][$_GET['editIns']]['vTotal']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
					$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['cotizacion_insumos'][$_GET['editIns']]['idProducto'], 2);

					if(isset($rowData['Cliente'])&&$rowData['Cliente']!=''){$prov=$rowData['Cliente'];}else{$prov='Sin Cliente';}
					$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', $rowData['Unimed']);
					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['cotizacion_insumos'][$_GET['editIns']]['vUnitario']));
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
					$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['cotizacion_insumos'][$_GET['editIns']]['vUnitario']), 2);

					echo venta_print_value('insumos_listado', 'idProducto', 'unimed', $dbConn);
					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_ins">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addIns'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	//filtro
	$zx2 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx2 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Insumos</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = '';}
					if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = '';}
					if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

					$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', '');
					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
					$Form_Inputs->form_input_hidden('vUnitario', '', 2);

					echo venta_print_value('insumos_listado', 'idProducto', 'unimed', $dbConn);
					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_ins">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editProd'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	productos_listado.idProducto,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'productos_listado.idProducto='.$_SESSION['cotizacion_productos'][$_GET['editProd']]['idProducto'];
	$rowData = db_select_data (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	//filtro
	$zx1 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar solicitud de Productos</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $_SESSION['cotizacion_productos'][$_GET['editProd']]['idProducto'];}
					if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = Cantidades_decimales_justos($_SESSION['cotizacion_productos'][$_GET['editProd']]['Cantidad']);}
					if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = Cantidades_decimales_justos($_SESSION['cotizacion_productos'][$_GET['editProd']]['vTotal']);}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
					$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['cotizacion_productos'][$_GET['editProd']]['idProducto'], 2);

					if(isset($rowData['Cliente'])&&$rowData['Cliente']!=''){$prov=$rowData['Cliente'];}else{$prov='Sin Cliente';}
					$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', $rowData['Unimed']);
					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', Cantidades_decimales_justos($_SESSION['cotizacion_productos'][$_GET['editProd']]['vUnitario']));
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
					$Form_Inputs->form_input_hidden('vUnitario', Cantidades_decimales_justos($_SESSION['cotizacion_productos'][$_GET['editProd']]['vUnitario']), 2);

					echo venta_print_value('productos_listado', 'idProducto', 'unimed', $dbConn);
					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_prod">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addProd'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 0;
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	/*******************************************************/
	//filtro
	$zx1 = "idProducto=0";
	foreach ($arrPermisos as $prod) {
		$zx1 .= " OR (idEstado=1 AND idProducto=".$prod['idProducto'].")";
	}
	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Productos</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = '';}
					if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = '';}
					if(isset($vTotal)){           $x3  = $vTotal;          }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
					$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

					$Form_Inputs->form_input_disabled('Unidad de Medida','unimed', '');
					$Form_Inputs->form_input_disabled('Valor Unitario Neto','Unitario', '');
					$Form_Inputs->form_input_number('Valor Total Neto', 'vTotal', $x3, 2);
					$Form_Inputs->form_input_hidden('vUnitario', '', 2);

					echo venta_print_value('productos_listado', 'idProducto', 'unimed', $dbConn);
					echo operacion_input('Cantidad', 'vTotal', 'Unitario', 'vUnitario', 4);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_prod">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addImpuesto'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Impuestos</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idImpuesto )){       $x1  = $idImpuesto ;      }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Impuestos','idImpuesto', $x1, 2, 'idImpuesto', 'Nombre', 'sistema_impuestos', 0, '', $dbConn);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_impuesto">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar Cotizacion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idCliente)){        $x1  = $idCliente;      }else{$x1  = $_SESSION['cotizacion_basicos']['idCliente'];}
					if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = $_SESSION['cotizacion_basicos']['Creacion_fecha'];}
					if(isset($Observaciones)){    $x3  = $Observaciones;  }else{$x3  = $_SESSION['cotizacion_basicos']['Observaciones'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 2, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha de Cotizacion','Creacion_fecha', $x2, 2);
					$Form_Inputs->form_ckeditor('Condiciones Comerciales','Observaciones', $x3, 1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Modificar Documento" name="submit_modBase">
						<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
	//Variable para sacar el total
	$vtotal_neto  = 0;
	$vtotal_iva   = 0;

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<div class="btn-group pull-right" role="group" aria-label="...">

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

			<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

			<?php
			$ubicacion = $location.'&view=true&ing_cotizacion=true';
			$dialogo   = '¿Realmente desea ingresar el documento?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i>  Ingresar Documento</a>

		</div>
		<div class="clearfix"></div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<div id="page-wrap">
			<div id="header"> Cotizacion</div>

			<div id="customer">

				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary pull-right tooltip" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>
						<tr>
							<td class="meta-head">Cliente</td>
							<td><?php echo $_SESSION['cotizacion_basicos']['Cliente']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Vendedor</td>
							<td><?php echo $_SESSION['cotizacion_basicos']['Usuario']; ?></td>
						</tr>
					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>
						<tr>
							<td class="meta-head">Fecha Creacion</td>
							<td><?php echo Fecha_estandar($_SESSION['cotizacion_basicos']['Creacion_fecha']); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<table id="items">
				<tbody>

					<tr>
						<th colspan="5">Detalle</th>
						<th width="160">Acciones</th>
					</tr>

					<tr class="item-row fact_tittle">
						<td colspan="5">Productos Cotizados</td>
						<td>
							<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
								<a href="<?php echo $location.'&addProd=true' ?>" title="Agregar Producto" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a>
							<?php } ?>
						</td>
					</tr>
					<?php
					if (isset($_SESSION['cotizacion_productos'])){
						//recorro el lsiatdo entregado por la base de datos
						foreach ($_SESSION['cotizacion_productos'] as $key => $producto){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2">
									<?php echo $producto['Nombre']; ?>
								</td>
								<td class="item-name">
									<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Unimed']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo valores($producto['vUnitario'], 0).' x '.$producto['Unimed']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo 'Total '.valores($producto['vTotal'], 0);$vtotal_neto = $vtotal_neto + $producto['vTotal']; ?>
								</td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo $location.'&editProd='.$producto['idProducto']; ?>" title="Editar Producto" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
											<?php
											$ubicacion = $location.'&del_prod='.$producto['idProducto'];
											$dialogo   = '¿Realmente deseas eliminar el producto '.$producto['Nombre'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										<?php } ?>
									</div>
								</td>
							</tr>
					<?php }
					} ?>

					<tr class="item-row fact_tittle">
						<td colspan="5">Insumos Cotizados</td>
						<td>
							<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
								<a href="<?php echo $location.'&addIns=true' ?>" title="Agregar Insumo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumos</a>
							<?php } ?>
						</td>
					</tr>
					<?php
					if (isset($_SESSION['cotizacion_insumos'])){
						//recorro el lsiatdo entregado por la base de datos
						foreach ($_SESSION['cotizacion_insumos'] as $key => $producto){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2">
									<?php echo $producto['Nombre']; ?>
								</td>
								<td class="item-name">
									<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Unimed']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo valores($producto['vUnitario'], 0).' x '.$producto['Unimed']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo 'Total '.valores($producto['vTotal'], 0);$vtotal_neto = $vtotal_neto + $producto['vTotal']; ?>
								</td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo $location.'&editIns='.$producto['idProducto']; ?>" title="Editar Insumo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
											<?php
											$ubicacion = $location.'&del_ins='.$producto['idProducto'];
											$dialogo   = '¿Realmente deseas eliminar el producto '.$producto['Nombre'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Insumo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										<?php } ?>
									</div>
								</td>
							</tr>
					<?php }
					} ?>

					<tr class="item-row fact_tittle">
						<td colspan="5">Arriendo de equipos Cotizados</td>
						<td>
							<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
								<a href="<?php echo $location.'&addArriendo=true' ?>" title="Agregar Arriendo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Arriendos</a>
							<?php } ?>
						</td>
					</tr>
					<?php
					if (isset($_SESSION['cotizacion_arriendos'])){
						//recorro el lsiatdo entregado por la base de datos
						foreach ($_SESSION['cotizacion_arriendos'] as $key => $producto){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2">
									<?php echo $producto['Nombre']; ?>
								</td>
								<td class="item-name">
									<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo valores($producto['vUnitario'], 0).' x '.$producto['Frecuencia']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo 'Total '.valores($producto['vTotal'], 0);$vtotal_neto = $vtotal_neto + $producto['vTotal']; ?>
								</td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo $location.'&editArriendo='.$producto['idEquipo']; ?>" title="Editar Arriendo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
											<?php
											$ubicacion = $location.'&del_arriendo='.$producto['idEquipo'];
											$dialogo   = '¿Realmente deseas eliminar el arriendo '.$producto['Nombre'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Arriendo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
					} ?>

					<tr class="item-row fact_tittle">
						<td colspan="5">Servicios Cotizados</td>
						<td>
							<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
								<a href="<?php echo $location.'&addServicios=true' ?>" title="Agregar Servicio" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Servicios</a>
							<?php } ?>
						</td>
					</tr>
					<?php
					if (isset($_SESSION['cotizacion_servicios'])){
						//recorro el lsiatdo entregado por la base de datos
						foreach ($_SESSION['cotizacion_servicios'] as $key => $producto){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2">
									<?php echo $producto['Nombre']; ?>
								</td>
								<td class="item-name">
									<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo valores($producto['vUnitario'], 0).' x '.$producto['Frecuencia']; ?>
								</td>
								<td class="item-name" align="right">
									<?php echo 'Total '.valores($producto['vTotal'], 0);$vtotal_neto = $vtotal_neto + $producto['vTotal']; ?>
								</td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo $location.'&editServicios='.$producto['idServicio']; ?>" title="Editar Servicio" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php if(!isset($_GET['soli']) OR $_GET['soli']==''){ ?>
											<?php
											$ubicacion = $location.'&del_servicio='.$producto['idServicio'];
											$dialogo   = '¿Realmente deseas eliminar el servicio '.$producto['Nombre'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Servicio" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
					} ?>

					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="4" align="right"><strong>Neto Imponible</strong></td>
						<td align="right"><?php echo Valores($vtotal_neto, 0); ?></td>
						<td></td>
					</tr>

					<tr class="item-row linea_punteada">
						<td class="item-name" colspan="5"><strong>Impuestos</strong></td>
						<td><a href="<?php echo $location.'&addImpuesto=true' ?>" title="Agregar Impuesto" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Impuestos</a></td>
					</tr>
							<?php
							if (isset($_SESSION['cotizacion_impuestos'])){
							//recorro el lsiatdo entregado por la base de datos
								foreach ($_SESSION['cotizacion_impuestos'] as $key => $producto){
									//se hacen los calculos matematicos
									$iva = ($vtotal_neto / 100) * $producto['Porcentaje'];
									$vtotal_iva = $vtotal_iva + $iva;
									//se guardan los valores en variables de sesion
									$_SESSION['cotizacion_impuestos'][$producto['idImpuesto']]['valor'] = $iva; ?>
									<tr class="invoice-total" bgcolor="#f1f1f1">
										<td colspan="4" align="right"><strong><?php echo $producto['Nombre'].' ('.Cantidades_decimales_justos($producto['Porcentaje']).'%)'; ?></strong></td>      
										<td align="right">
											<?php echo Valores($iva, 0); ?>
										</td>
										<td>
											<div class="btn-group" style="width: 35px;" >
												<?php
												$ubicacion = $location.'&del_impuesto='.$producto['idImpuesto'];
												$dialogo   = '¿Realmente deseas eliminar el impuesto '.$producto['Nombre'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Impuesto" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>
							<?php }
							}

							$_SESSION['cotizacion_basicos']['vtotal_neto']   = $vtotal_neto;
							$_SESSION['cotizacion_basicos']['vtotal_total']  = $vtotal_neto + $vtotal_iva;

						?>

						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"> <strong>Total</strong></td>
							<td align="right"><?php echo Valores($vtotal_neto + $vtotal_iva, 0); ?></td>
							<td></td>
						</tr>

				</tbody>
			</table>

		</div>

		<div class="col-xs-12">
			<div class="row">
				<p class="lead"><a name="Ancla_obs"></a>Condiciones Comerciales:</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['cotizacion_basicos']['Observaciones']; ?></p>
			</div>
		</div>

		<table id="items" style="margin-bottom: 20px;">
			<tbody>

				<tr>
					<th colspan="5">Archivos Adjuntos</th>
					<th width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></th>
				</tr>

				<?php
				if (isset($_SESSION['cotizacion_archivos'])){
					//recorro el lsiatdo entregado por la base de datos
					$numeral = 1;
					foreach ($_SESSION['cotizacion_archivos'] as $key => $producto){ ?>
						<tr class="item-row">
							<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del_file='.$producto['idFile'];
									$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$producto['Nombre']).'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

					<?php
					$numeral++;
					}
				} ?>

			</tbody>
		</table>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//se crea filtro
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Cotizacion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idCliente)){        $x1  = $idCliente;      }else{$x1  = '';}
					if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = '';}
					if(isset($Observaciones)){    $x3  = $Observaciones;  }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 2, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha de Cotizacion','Creacion_fecha', $x2, 2);
					$Form_Inputs->form_ckeditor('Condiciones Comerciales','Observaciones', $x3, 1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Crear Documento" name="submit">
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
			case 'ndoc_asc':          $order_by = 'cotizacion_listado.idCotizacion ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Doc Ascendente';break;
			case 'ndoc_desc':         $order_by = 'cotizacion_listado.idCotizacion DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Doc Descendente';break;
			case 'Cliente_asc':       $order_by = 'clientes_listado.Nombre ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cliente Ascendente';break;
			case 'Cliente_desc':      $order_by = 'clientes_listado.Nombre DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Cliente Descendente';break;
			case 'fecha_asc':         $order_by = 'cotizacion_listado.Creacion_fecha ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':        $order_by = 'cotizacion_listado.Creacion_fecha DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;

			default: $order_by = 'cotizacion_listado.idCotizacion DESC, cotizacion_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Doc, Fecha Descendente';
		}
	}else{
		$order_by = 'cotizacion_listado.idCotizacion DESC, cotizacion_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Doc, Fecha Descendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "cotizacion_listado.idCotizacion>0";
	$SIS_where.= " AND cotizacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//verifico que sea un administrador
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$SIS_where.=" AND cotizacion_listado.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){            $SIS_where .= " AND cotizacion_listado.idCliente=".$_GET['idCliente'];}
	if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND cotizacion_listado.Creacion_fecha='".$_GET['Creacion_fecha']."'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idCotizacion', 'cotizacion_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	cotizacion_listado.idCotizacion,
	cotizacion_listado.Creacion_fecha,
	clientes_listado.Nombre AS Cliente';
	$SIS_join  = 'LEFT JOIN `clientes_listado` ON clientes_listado.idCliente = cotizacion_listado.idCliente';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrCotizaciones = array();
	$arrCotizaciones = db_select_array (false, $SIS_query, 'cotizacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCotizaciones');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>
		<?php if ($rowlevel['level']>=3){ ?>
			<?php if(isset($_SESSION['cotizacion_basicos']['idCliente'])&&$_SESSION['cotizacion_basicos']['idCliente']!=''){ ?>

				<?php
				$ubicacion = $location.'&clear_all=true';
				$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
				<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

				<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-arrow-right" aria-hidden="true"></i>  Continuar Cotizacion</a>
			<?php }else{ ?>
				<a href="<?php echo $location.'&new=true'; ?>" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Cotizacion</a>
			<?php } ?>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idCliente)){        $x1  = $idCliente;      }else{$x1  = '';}
					if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 1, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);
					$Form_Inputs->form_date('Fecha de Cotizacion','Creacion_fecha', $x2, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Cotizaciones</h5>
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
							<th width="120">
								<div class="pull-left">N° Doc</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ndoc_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ndoc_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Cliente</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=Cliente_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=Cliente_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrCotizaciones as $sol) { ?>
							<tr class="odd">
								<td><?php echo 'Cotizacion N°'.n_doc($sol['idCotizacion'], 5); ?></td>
								<td><?php echo $sol['Cliente']; ?></td>
								<td><?php echo Fecha_estandar($sol['Creacion_fecha']); ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_cotizacion.php?view='.simpleEncode($sol['idCotizacion'], fecha_actual()); ?>" title="Ver Cotizacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($sol['idCotizacion'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la Cotizacion N° '.$sol['idCotizacion'].'?'; ?>
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
