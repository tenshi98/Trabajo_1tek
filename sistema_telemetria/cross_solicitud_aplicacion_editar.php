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
$original = "cross_solicitud_aplicacion_editar.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$_GET['view'];
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se modifican los datos basicos
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_mod_base';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_addCuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edit_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_editCuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se cierra un trabajo
if (!empty($_POST['submit_close_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_close_Cuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_cuartel'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_del_Cuartel';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_tractor'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_addtractor';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edit_tractor'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_edittractor';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_trac'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_del_trac';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_material'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_addmaterial';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_material'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_del_material';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_producto'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_addproducto';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se agrega un trabajo
if (!empty($_POST['submit_edit_producto'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_editproducto';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
//se borra un trabajo
if (!empty($_GET['del_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_del_prod';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/*************************************************************************/
//se agrega un trabajo
if (!empty($_POST['submit_add_detalle'])){
	//Llamamos al formulario
	$form_trabajo= 'updt_adddetalle';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_solicitud_aplicacion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['not_modbase'])){      $error['not_modbase']      = 'sucess/Datos basicos editados correctamente';}
if (isset($_GET['not_addcuartel'])){   $error['not_addcuartel']   = 'sucess/Cuartel agregado correctamente';}
if (isset($_GET['not_closecuartel'])){ $error['not_closecuartel'] = 'sucess/Cuartel cerrado correctamente';}
if (isset($_GET['not_delcuartel'])){   $error['not_delcuartel']   = 'sucess/Cuartel Borrado correctamente';}
if (isset($_GET['not_addtractor'])){   $error['not_addtractor']   = 'sucess/Tractor agregado correctamente';}
if (isset($_GET['not_edittrac'])){     $error['not_edittrac']     = 'sucess/Tractor Modificado correctamente';}
if (isset($_GET['not_deltractor'])){   $error['not_deltractor']   = 'sucess/Tractor Borrado correctamente';}
if (isset($_GET['not_addprod'])){      $error['not_addprod']      = 'sucess/Producto agregado correctamente';}
if (isset($_GET['not_editprod'])){     $error['not_editprod']     = 'sucess/Producto Modificado correctamente';}
if (isset($_GET['not_delprod'])){      $error['not_delprod']      = 'sucess/Producto Borrado correctamente';}
if (isset($_GET['not_adddetalle'])){   $error['not_adddetalle']   = 'sucess/Detalle agregado correctamente';}
if (isset($_GET['not_addmaterial'])){  $error['not_addmaterial']  = 'sucess/Material agregado correctamente';}
if (isset($_GET['not_delmaterial'])){  $error['not_delmaterial']  = 'sucess/Material Borrado correctamente';}

//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
if(isset($error1)&&$error1!=''){echo notifications_list($error1);};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['addDetalle'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Detalle</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Observacion)){      $x1  = $Observacion;        }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_textarea('Observacion','Observacion', $x1, 1);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					$Form_Inputs->form_input_hidden('idEstado', $_GET['idEstado'], 2);
					$Form_Inputs->form_input_hidden('Creacion_fecha', fecha_actual(), 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_add_detalle">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_prod'])){
	// consulto los datos
	$SIS_query = 'idProducto, DosisAplicar, Objetivo';
	$SIS_join  = '';
	$SIS_where = 'idProdQuim ='.$_GET['edit_prod'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado_productos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	// consulto los datos
	$SIS_query = '
	productos_listado.idProducto,
	productos_listado.DosisRecomendada,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'idProducto ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Producto Químico</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){     $x1  = $idProducto;    }else{$x1  = $rowData['idProducto'];}
					if(isset($DosisAplicar)){   $x2  = $DosisAplicar;  }else{$x2  = $rowData['DosisAplicar'];}
					if(isset($Objetivo)){       $x3  = $Objetivo;      }else{$x3  = $rowData['Objetivo'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Producto Químico a aplicar');
					$Form_Inputs->form_select_filter('Producto Químico','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_disabled( 'Dosis Recomendada', 'escribeme1', 0);
					$Form_Inputs->form_input_number_spinner('Dosis a aplicar','DosisAplicar', $x2, 0, 2000, '0.01', 2, 2);
					$Form_Inputs->form_input_disabled( 'Unidad de medida', 'escribeme2', 0);
					$Form_Inputs->form_textarea('Objetivo','Objetivo', $x3, 1);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					$Form_Inputs->form_input_hidden('idCuarteles', $_GET['cuartel_id'], 2);
					$Form_Inputs->form_input_hidden('idProdQuim', $_GET['edit_prod'], 2);
					?>

					<script>

						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['DosisRecomendada']).'";';
							echo 'let id_med_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						$(document).ready(function(){
							LoadProducto();
						});

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme1").value = eval("id_data_" + Componente);
								document.getElementById("escribeme2").value = eval("id_med_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_producto">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['add_prod'])){
	// consulto los datos
	$SIS_query = '
	productos_listado.idProducto, 
	productos_listado.DosisRecomendada,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'idProducto ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Producto Químico</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idProducto)){     $x1  = $idProducto;    }else{$x1  = '';}
					if(isset($DosisAplicar)){   $x2  = $DosisAplicar;  }else{$x2  = '';}
					if(isset($Objetivo)){       $x3  = $Objetivo;      }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Producto Químico a aplicar');
					$Form_Inputs->form_select_filter('Producto Químico','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', 'idEstado=1', '', $dbConn);
					$Form_Inputs->form_input_disabled( 'Dosis Recomendada', 'escribeme1', 0);
					$Form_Inputs->form_input_number_spinner('Dosis a aplicar','DosisAplicar', $x2, 0, 2000, '0.01', 2, 2);
					$Form_Inputs->form_input_disabled( 'Unidad de medida', 'escribeme2', 0);
					$Form_Inputs->form_textarea('Objetivo','Objetivo', $x3, 1);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					$Form_Inputs->form_input_hidden('idCuarteles', $_GET['cuartel_id'], 2);
					?>

					<script>

						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['DosisRecomendada']).'";';
							echo 'let id_med_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						$(document).ready(function(){
							LoadProducto();
						});

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme1").value = eval("id_data_" + Componente);
								document.getElementById("escribeme2").value = eval("id_med_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_producto">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_trac'])){
	// consulto los datos
	$SIS_query = 'idVehiculo, idTelemetria, idTrabajador';
	$SIS_join  = '';
	$SIS_where = 'idTractores ='.$_GET['edit_trac'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/***************************************************/
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$w .= " AND telemetria_listado.idTab=1";//Agro-Checking
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Tractor</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idVehiculo)){     $x1  = $idVehiculo;    }else{$x1  = $rowData['idVehiculo'];}
					if(isset($idTelemetria)){   $x2  = $idTelemetria;  }else{$x2  = $rowData['idTelemetria'];}
					if(isset($idTrabajador)){   $x3  = $idTrabajador;  }else{$x3  = $rowData['idTrabajador'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Tractor');
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_select_filter('Equipo Aplicacion','idVehiculo', $x1, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Asignado','idTrabajador', $x3, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $x, '', $dbConn);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					$Form_Inputs->form_input_hidden('idCuarteles', $_GET['cuartel_id'], 2);
					$Form_Inputs->form_input_hidden('idTractores', $_GET['edit_trac'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_tractor">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['add_trac'])){
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1"; 
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$w .= " AND telemetria_listado.idTab=1";//Agro-Checking		
	}
				
	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Tractor</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idVehiculo)){     $x1  = $idVehiculo;    }else{$x1  = '';}
					if(isset($idTelemetria)){   $x2  = $idTelemetria;  }else{$x2  = '';}
					if(isset($idTrabajador)){   $x3  = $idTrabajador;  }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Tractor');
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Tractor','idTelemetria', $x2, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_select_filter('Equipo Aplicacion','idVehiculo', $x1, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Asignado','idTrabajador', $x3, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $x, '', $dbConn);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					$Form_Inputs->form_input_hidden('idCuarteles', $_GET['cuartel_id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_tractor">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_Cuarteles'])){
	/***************************************************/
	// consulto los datos
	$SIS_query = 'idPredio, idCategoria, idProducto';
	$SIS_join  = '';
	$SIS_where = 'idSolicitud ='.$_GET['view'];
	$rowData_ini = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData_ini');

	/***************************************************/
	// consulto los datos
	$SIS_query = 'idZona,Mojamiento,VelTractor,VelViento,TempMin,TempMax,HumTempMax';
	$SIS_join  = '';
	$SIS_where = 'idCuarteles ='.$_GET['cuartel_id'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado_cuarteles', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/***************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$z ="idPredio=".$rowData_ini['idPredio'];
	$z.=" AND idEstado=1 ";
	if(isset($rowData_ini['idCategoria'])&&$rowData_ini['idCategoria']!=0){$z.= " AND idCategoria=".$rowData_ini['idCategoria'];}
	if(isset($rowData_ini['idProducto'])&&$rowData_ini['idProducto']!=0){$z.= " AND idProducto=".$rowData_ini['idProducto'];}
			
	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Cuartel</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idZona)){         $x1  = $idZona;        }else{$x1  = $rowData['idZona'];}
					if(isset($Mojamiento)){     $x2  = $Mojamiento;    }else{$x2  = $rowData['Mojamiento'];}
					if(isset($VelTractor)){     $x3  = $VelTractor;    }else{$x3  = $rowData['VelTractor'];}
					if(isset($VelViento)){      $x4  = $VelViento;     }else{$x4  = $rowData['VelViento'];}
					if(isset($TempMin)){        $x5  = $TempMin;       }else{$x5  = $rowData['TempMin'];}
					if(isset($TempMax)){        $x6  = $TempMax;       }else{$x6  = $rowData['TempMax'];}
					if(isset($HumTempMax)){     $x7  = $HumTempMax;    }else{$x7  = $rowData['HumTempMax'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Identificación cuartel');
					$Form_Inputs->form_select_filter('Cuartel','idZona', $x1, 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', $z, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Parámetros de Aplicación');
					$Form_Inputs->form_input_number_spinner('Mojamiento L/ha','Mojamiento', $x2, 0, 10000, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Tractor Km/hr','VelTractor', $x3, 0, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Viento Km/hr','VelViento', $x4, 0, 500, '0.001', 3, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura minima','TempMin', $x5, -20, 500, '0.01', 2, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura maxima','TempMax', $x6, -20, 500, '0.01', 2, 2);
					$Form_Inputs->form_input_number_spinner('Humedad','HumTempMax', $x7, -20, 500, '0.01', 2, 2);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					$Form_Inputs->form_input_hidden('idCuarteles', $_GET['cuartel_id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_cuartel">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addCuartel'])){
	// consulto los datos
	$SIS_query = 'idPredio, idCategoria, idProducto, Mojamiento, VelTractor, VelViento, TempMin, TempMax, HumTempMax';
	$SIS_join  = '';
	$SIS_where = 'idSolicitud ='.$_GET['view'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/**********************************************/
	//Imprimo las variables
	$SIS_query = '
	productos_listado.idProducto,
	productos_listado.DosisRecomendada,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
	$SIS_where = 'idEstado=1';
	$SIS_order = 'idProducto ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

	/**********************************************/
	//Verifico el tipo de usuario que esta ingresando
	$z = "idPredio=".$rowData['idPredio'];
	$z.= " AND idEstado=1 ";
	if(isset($rowData['idCategoria'])&&$rowData['idCategoria']!=0){$z.= " AND idCategoria=".$rowData['idCategoria'];}
	if(isset($rowData['idProducto'])&&$rowData['idProducto']!=0){$z.= " AND idProducto=".$rowData['idProducto'];}
	//otros filtros
	$x = "idEstado=1 ";
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND telemetria_listado.idEstado=1";
	$y = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$m = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$w .= " AND telemetria_listado.idTab=1";//Agro-Checking
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Cuartel</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idZona)){         $x1  = $idZona;        }else{$x1  = '';}
					if(isset($Mojamiento)){     $x2  = $Mojamiento;    }else{$x2  = $rowData['Mojamiento'];}
					if(isset($VelTractor)){     $x3  = $VelTractor;    }else{$x3  = $rowData['VelTractor'];}
					if(isset($VelViento)){      $x4  = $VelViento;     }else{$x4  = $rowData['VelViento'];}
					if(isset($TempMin)){        $x5  = $TempMin;       }else{$x5  = $rowData['TempMin'];}
					if(isset($TempMax)){        $x6  = $TempMax;       }else{$x6  = $rowData['TempMax'];}
					if(isset($HumTempMax)){     $x7  = $HumTempMax;    }else{$x7  = $rowData['HumTempMax'];}
					if(isset($idVehiculo)){     $x8  = $idVehiculo;    }else{$x8  = '';}
					if(isset($idTelemetria)){   $x9  = $idTelemetria;  }else{$x9  = '';}
					if(isset($idTrabajador)){   $x10 = $idTrabajador;  }else{$x10 = '';}
					if(isset($idProducto)){     $x11 = $idProducto;    }else{$x11 = '';}
					if(isset($DosisAplicar)){   $x12 = $DosisAplicar;  }else{$x12 = '';}
					if(isset($Objetivo)){       $x13 = $Objetivo;      }else{$x13 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Identificación cuartel');
					$Form_Inputs->form_select_filter('Cuartel','idZona', $x1, 2, 'idZona', 'Nombre', 'cross_predios_listado_zonas', $z, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Parámetros de Aplicación');
					$Form_Inputs->form_input_number_spinner('Mojamiento L/ha','Mojamiento', $x2, 0, 10000, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Tractor Km/hr','VelTractor', $x3, 0, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Velocidad Viento Km/hr','VelViento', $x4, 0, 50, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura minima','TempMin', $x5, -20, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Temperatura maxima','TempMax', $x6, -20, 50, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Humedad','HumTempMax', $x7, -20, 500, '0.1', 1, 2);

					$Form_Inputs->form_tittle(3, 'Tractor');
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Tractor','idTelemetria', $x9, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Tractor','idTelemetria', $x9, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_select_filter('Equipo Aplicacion','idVehiculo', $x8, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $y, '', $dbConn);
					$Form_Inputs->form_select_filter('Trabajador Asignado','idTrabajador', $x10, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $m, '', $dbConn);

					$Form_Inputs->form_tittle(3, 'Producto Químico a aplicar');
					$Form_Inputs->form_select_filter('Producto Químico','idProducto', $x11, 2, 'idProducto', 'Nombre', 'productos_listado', $x, '', $dbConn);
					$Form_Inputs->form_input_disabled( 'Dosis Recomendada', 'escribeme1', 0);
					$Form_Inputs->form_input_number_spinner('Dosis a aplicar','DosisAplicar', $x12, 0, 500, '0.01', 2, 2);
					$Form_Inputs->form_input_disabled( 'Unidad de medida', 'escribeme2', 0);
					$Form_Inputs->form_textarea('Objetivo','Objetivo', $x13, 1);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					?>

					<script>

						/**********************************************************************/
						<?php
						foreach ($arrTipo as $tipo) {
							echo 'let id_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['DosisRecomendada']).'";';
							echo 'let id_med_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
						}
						?>

						/**********************************************************************/
						$(document).ready(function(){
							LoadProducto();
						});

						/**********************************************************************/
						document.getElementById("idProducto").onchange = function() {LoadProducto()};

						/**********************************************************************/
						function LoadProducto(){
							let Componente = document.getElementById("idProducto").value;
							if (Componente != "") {
								//escribo dentro del input
								document.getElementById("escribeme1").value = eval("id_data_" + Componente);
								document.getElementById("escribeme2").value = eval("id_med_" + Componente);
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_cuartel">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addMaterial'])){ ?>
	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Agregar Material de Seguridad</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idMatSeguridad)){     $x1  = $idMatSeguridad;    }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Material de Seguridad','idMatSeguridad', $x1, 2, 'idMatSeguridad', 'Nombre', 'cross_checking_materiales_seguridad', 'idEstado=1', '', $dbConn);

					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_material">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
	// consulto los datos
	$SIS_query = 'idPredio, idTemporada, idEstadoFen, idCategoria, idProducto, f_programacion, horaProg, idSistema, idEstado, f_ejecucion, f_termino, horaEjecucion, horaTermino, Mojamiento, VelTractor, VelViento, TempMin, TempMax, idPrioridad, f_programacion_fin, horaProg_fin, f_ejecucion_fin, horaEjecucion_fin, f_termino_fin, horaTermino_fin, idDosificador, HumTempMax, NSolicitud';
	$SIS_join  = '';
	$SIS_where = 'idSolicitud ='.$_GET['view'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Verifico el tipo de usuario que esta ingresando
	$y = "idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$m = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificar la Solicitud de Aplicacion</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idPrioridad)){          $x0  = $idPrioridad;          }else{$x0  = $rowData['idPrioridad'];}
					if(isset($idPredio)){             $x1  = $idPredio;             }else{$x1  = $rowData['idPredio'];}
					if(isset($idTemporada)){          $x2  = $idTemporada;          }else{$x2  = $rowData['idTemporada'];}
					if(isset($idEstadoFen)){          $x3  = $idEstadoFen;          }else{$x3  = $rowData['idEstadoFen'];}
					if(isset($idCategoria)){          $x4  = $idCategoria;          }else{$x4  = $rowData['idCategoria'];}
					if(isset($idProducto)){           $x5  = $idProducto;           }else{$x5  = $rowData['idProducto'];}
					if(isset($f_programacion)){       $x6  = $f_programacion;       }else{$x6  = $rowData['f_programacion'];}
					if(isset($horaProg)){             $x7  = $horaProg;             }else{$x7  = $rowData['horaProg'];}
					if(isset($f_ejecucion)){          $x8  = $f_ejecucion;          }else{$x8  = $rowData['f_ejecucion'];}
					if(isset($horaEjecucion)){        $x9  = $horaEjecucion;        }else{$x9  = $rowData['horaEjecucion'];}
					if(isset($f_termino)){            $x10 = $f_termino;            }else{$x10 = $rowData['f_termino'];}
					if(isset($horaTermino)){          $x11 = $horaTermino;          }else{$x11 = $rowData['horaTermino'];}
					if(isset($Mojamiento)){           $x13 = $Mojamiento;           }else{$x13 = Cantidades_decimales_justos($rowData['Mojamiento']);}
					if(isset($VelTractor)){           $x14 = $VelTractor;           }else{$x14 = Cantidades_decimales_justos($rowData['VelTractor']);}
					if(isset($VelViento)){            $x15 = $VelViento;            }else{$x15 = Cantidades_decimales_justos($rowData['VelViento']);}
					if(isset($TempMin)){              $x16 = $TempMin;              }else{$x16 = Cantidades_decimales_justos($rowData['TempMin']);}
					if(isset($TempMax)){              $x17 = $TempMax;              }else{$x17 = Cantidades_decimales_justos($rowData['TempMax']);}
					if(isset($f_programacion_fin)){   $x18 = $f_programacion_fin;   }else{$x18 = $rowData['f_programacion_fin'];}
					if(isset($horaProg_fin)){         $x19 = $horaProg_fin;         }else{$x19 = $rowData['horaProg_fin'];}
					if(isset($f_ejecucion_fin)){      $x20 = $f_ejecucion_fin;      }else{$x20 = $rowData['f_ejecucion_fin'];}
					if(isset($horaEjecucion_fin)){    $x21 = $horaEjecucion_fin;    }else{$x21 = $rowData['horaEjecucion_fin'];}
					if(isset($f_termino_fin)){        $x22 = $f_termino_fin;        }else{$x22 = $rowData['f_termino_fin'];}
					if(isset($horaTermino_fin)){      $x23 = $horaTermino_fin;      }else{$x23 = $rowData['horaTermino_fin'];}
					if(isset($idDosificador)){        $x24 = $idDosificador;        }else{$x24 = $rowData['idDosificador'];}
					if(isset($HumTempMax)){           $x25 = $HumTempMax;           }else{$x25 = Cantidades_decimales_justos($rowData['HumTempMax']);}
					if(isset($NSolicitud)){           $x26 = $NSolicitud;           }else{$x26 = $rowData['NSolicitud'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					//Verifico el estado
					switch ($rowData['idEstado']) {
						//Solicitada
						case 1:
							$Form_Inputs->form_tittle(3, 'Datos Básicos');
							$Form_Inputs->form_values('Numero de solicitud','NSolicitud', $x26, 2);
							$Form_Inputs->form_select('Prioridad','idPrioridad', $x0, 2, 'idPrioridad', 'Nombre', 'core_cross_prioridad', 0, '', $dbConn);
							$Form_Inputs->form_select_filter('Predio','idPredio', $x1, 2, 'idPredio', 'Nombre', 'cross_predios_listado', $z, '', $dbConn);
							$Form_Inputs->form_select_filter('Temporada','idTemporada', $x2, 2, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
							$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x3, 2, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
							$Form_Inputs->form_select_depend1('Especie','idCategoria', $x4, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
													'Variedad','idProducto', $x5, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
													$dbConn, 'form1');
							$Form_Inputs->form_date('Fecha inicio requerido','f_programacion', $x6, 2);
							$Form_Inputs->form_time('Hora inicio requerido','horaProg', $x7, 2, 1);
							$Form_Inputs->form_date('Fecha termino requerido','f_programacion_fin', $x18, 2);
							$Form_Inputs->form_time('Hora termino requerido','horaProg_fin', $x19, 2, 1);

							$Form_Inputs->form_tittle(3, 'Parámetros de Aplicación');
							$Form_Inputs->form_input_number_spinner('Mojamiento L/ha','Mojamiento', $x13, 0, 10000, 1, 0, 2);
							$Form_Inputs->form_input_number_spinner('Velocidad Tractor Km/hr','VelTractor', $x14, 0, 50, '0.1', 1, 2);
							$Form_Inputs->form_input_number_spinner('Velocidad Viento Km/hr','VelViento', $x15, 0, 500, '0.001', 3, 2);
							$Form_Inputs->form_input_number_spinner('Temperatura minima','TempMin', $x16, -20, 500, '0.01', 2, 2);
							$Form_Inputs->form_input_number_spinner('Temperatura maxima','TempMax', $x17, -20, 500, '0.01', 2, 2);
							$Form_Inputs->form_input_number_spinner('Humedad','HumTempMax', $x25, -20, 500, '0.01', 2, 2);

							break;
						//Programada
						case 2:
							$Form_Inputs->form_tittle(3, 'Datos Básicos');
							$Form_Inputs->form_select_filter('Temporada','idTemporada', $x2, 2, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
							$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x3, 2, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
							$Form_Inputs->form_date('Fecha inicio programación','f_ejecucion', $x8, 2);
							$Form_Inputs->form_time('Hora inicio programación','horaEjecucion', $x9, 2, 1);
							$Form_Inputs->form_date('Fecha termino programación','f_ejecucion_fin', $x20, 2);
							$Form_Inputs->form_time('Hora termino programación','horaEjecucion_fin', $x21, 2, 1);
							$Form_Inputs->form_select_filter('Dosificador','idDosificador', $x24, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', $m, '', $dbConn);

							break;
						//Ejecutada
						case 3:
							$Form_Inputs->form_tittle(3, 'Datos Básicos');
							$Form_Inputs->form_date('Fecha inicio cierre','f_termino', $x10, 2);
							$Form_Inputs->form_time('Hora inicio cierre','horaTermino', $x11, 2, 1);
							$Form_Inputs->form_date('Fecha termino cierre','f_termino_fin', $x22, 2);
							$Form_Inputs->form_time('Hora termino cierre','horaTermino_fin', $x23, 2, 1);
							break;
					}

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idSolicitud', $_GET['view'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************/
	// consulto los datos
	$SIS_query = '
	cross_solicitud_aplicacion_listado.idEstado,
	cross_solicitud_aplicacion_listado.idSolicitud,
	cross_solicitud_aplicacion_listado.NSolicitud,
	cross_solicitud_aplicacion_listado.f_creacion,
	cross_solicitud_aplicacion_listado.f_programacion,
	cross_solicitud_aplicacion_listado.f_ejecucion,
	cross_solicitud_aplicacion_listado.f_termino,
	cross_solicitud_aplicacion_listado.f_programacion_fin,
	cross_solicitud_aplicacion_listado.f_ejecucion_fin,
	cross_solicitud_aplicacion_listado.f_termino_fin,
	cross_solicitud_aplicacion_listado.horaProg,
	cross_solicitud_aplicacion_listado.horaEjecucion,
	cross_solicitud_aplicacion_listado.horaTermino,
	cross_solicitud_aplicacion_listado.horaProg_fin,
	cross_solicitud_aplicacion_listado.horaEjecucion_fin,
	cross_solicitud_aplicacion_listado.horaTermino_fin,
	cross_solicitud_aplicacion_listado.Mojamiento,
	cross_solicitud_aplicacion_listado.VelTractor,
	cross_solicitud_aplicacion_listado.VelViento,
	cross_solicitud_aplicacion_listado.TempMin,
	cross_solicitud_aplicacion_listado.TempMax,
	cross_solicitud_aplicacion_listado.HumTempMax,

	usuarios_listado.Nombre AS NombreUsuario,

	sistema_origen.Nombre AS SistemaOrigen,
	sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
	sis_or_comuna.Nombre AS SistemaOrigenComuna,
	sistema_origen.Direccion AS SistemaOrigenDireccion,
	sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
	sistema_origen.email_principal AS SistemaOrigenEmail,
	sistema_origen.Rut AS SistemaOrigenRut,

	cross_predios_listado.Nombre AS NombrePredio,
	core_estado_solicitud.Nombre AS Estado,
	cross_checking_temporada.Codigo AS TemporadaCodigo,
	cross_checking_temporada.Nombre AS TemporadaNombre,
	cross_checking_estado_fenologico.Codigo AS EstadoFenCodigo,
	cross_checking_estado_fenologico.Nombre AS EstadoFenNombre,
	sistema_variedades_categorias.Nombre AS VariedadCat,
	variedades_listado.Nombre AS VariedadNombre,
	core_cross_prioridad.Nombre AS NombrePrioridad,
	cross_solicitud_aplicacion_listado.idDosificador,
	trabajadores_listado.Rut AS TrabajadorRut,
	trabajadores_listado.Nombre AS TrabajadorNombre,
	trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                     = cross_solicitud_aplicacion_listado.idUsuario
	LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema                       = cross_solicitud_aplicacion_listado.idSistema
	LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                         = sistema_origen.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                         = sistema_origen.idComuna
	LEFT JOIN `cross_predios_listado`                   ON cross_predios_listado.idPredio                 = cross_solicitud_aplicacion_listado.idPredio
	LEFT JOIN `core_estado_solicitud`                   ON core_estado_solicitud.idEstado                 = cross_solicitud_aplicacion_listado.idEstado
	LEFT JOIN `cross_checking_temporada`                ON cross_checking_temporada.idTemporada           = cross_solicitud_aplicacion_listado.idTemporada
	LEFT JOIN `cross_checking_estado_fenologico`        ON cross_checking_estado_fenologico.idEstadoFen   = cross_solicitud_aplicacion_listado.idEstadoFen
	LEFT JOIN `sistema_variedades_categorias`           ON sistema_variedades_categorias.idCategoria      = cross_solicitud_aplicacion_listado.idCategoria
	LEFT JOIN `variedades_listado`                      ON variedades_listado.idProducto                  = cross_solicitud_aplicacion_listado.idProducto
	LEFT JOIN `core_cross_prioridad`                    ON core_cross_prioridad.idPrioridad               = cross_solicitud_aplicacion_listado.idPrioridad
	LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador              = cross_solicitud_aplicacion_listado.idDosificador';
	$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud ='.$_GET['view'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************/
	//Cuarteles
	$SIS_query = '
	cross_solicitud_aplicacion_listado_cuarteles.idCuarteles,
	cross_solicitud_aplicacion_listado_cuarteles.Mojamiento,
	cross_solicitud_aplicacion_listado_cuarteles.VelTractor,
	cross_solicitud_aplicacion_listado_cuarteles.VelViento,
	cross_solicitud_aplicacion_listado_cuarteles.TempMin,
	cross_solicitud_aplicacion_listado_cuarteles.TempMax,
	cross_solicitud_aplicacion_listado_cuarteles.HumTempMax,
	cross_solicitud_aplicacion_listado_cuarteles.idEstado,
	cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
	cross_predios_listado_zonas.Nombre AS CuartelNombre,
	cross_predios_listado_zonas.Plantas AS CuartelNPlantas,
	cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
	sistema_variedades_categorias.Nombre AS CuartelEspecie,
	variedades_listado.Nombre AS CuartelVariedad';
	$SIS_join  = '
	LEFT JOIN `cross_predios_listado_zonas`    ON cross_predios_listado_zonas.idZona         = cross_solicitud_aplicacion_listado_cuarteles.idZona
	LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_solicitud_aplicacion_listado_cuarteles.idCategoria
	LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_solicitud_aplicacion_listado_cuarteles.idProducto';
	$SIS_where = 'cross_solicitud_aplicacion_listado_cuarteles.idSolicitud ='.$_GET['view'];
	$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
	$arrCuarteles = array();
	$arrCuarteles = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_cuarteles', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCuarteles');

	/*****************************************/
	//Se trae un listado con los tractores
	$SIS_query = '
	cross_solicitud_aplicacion_listado_tractores.idTractores,
	cross_solicitud_aplicacion_listado_tractores.idCuarteles,
	telemetria_listado.Nombre AS TeleNombre,
	vehiculos_listado.Nombre AS VehiculoNombre,
	trabajadores_listado.Rut,
	trabajadores_listado.Nombre,
	trabajadores_listado.ApellidoPat';
	$SIS_join  = '
	LEFT JOIN `telemetria_listado`    ON telemetria_listado.idTelemetria      = cross_solicitud_aplicacion_listado_tractores.idTelemetria
	LEFT JOIN `vehiculos_listado`     ON vehiculos_listado.idVehiculo         = cross_solicitud_aplicacion_listado_tractores.idVehiculo
	LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador    = cross_solicitud_aplicacion_listado_tractores.idTrabajador';
	$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud ='.$_GET['view'];
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrTractores = array();
	$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTractores');

	/*****************************************/
	//Se trae un listado con los productos
	$SIS_query = '
	cross_solicitud_aplicacion_listado_productos.idProdQuim,
	cross_solicitud_aplicacion_listado_productos.idCuarteles,
	cross_solicitud_aplicacion_listado_productos.DosisRecomendada,
	cross_solicitud_aplicacion_listado_productos.DosisAplicar,
	cross_solicitud_aplicacion_listado_productos.Objetivo,
	productos_listado.Nombre AS Producto,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = '
	LEFT JOIN `productos_listado`       ON productos_listado.idProducto   = cross_solicitud_aplicacion_listado_productos.idProducto
	LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = cross_solicitud_aplicacion_listado_productos.idUml';
	$SIS_where = 'cross_solicitud_aplicacion_listado_productos.idSolicitud ='.$_GET['view'];
	$SIS_order = 'productos_listado.Nombre ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

	/*****************************************/
	// Se trae un listado con el historial
	$SIS_query = '
	cross_solicitud_aplicacion_listado_historial.Creacion_fecha,
	cross_solicitud_aplicacion_listado_historial.Observacion,
	usuarios_listado.Nombre AS Usuario,
	core_estado_solicitud.Nombre AS Estado';
	$SIS_join  = '
	LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario      = cross_solicitud_aplicacion_listado_historial.idUsuario
	LEFT JOIN `core_estado_solicitud`    ON core_estado_solicitud.idEstado  = cross_solicitud_aplicacion_listado_historial.idEstado';
	$SIS_where = 'cross_solicitud_aplicacion_listado_historial.idSolicitud ='.$_GET['view'];
	$SIS_order = 'cross_solicitud_aplicacion_listado_historial.idHistorial ASC';
	$arrHistorial = array();
	$arrHistorial = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrHistorial');

	/*****************************************/
	//Se trae un listado con los productos
	$SIS_query = '
	cross_solicitud_aplicacion_listado_materiales.idMatSeg,
	cross_checking_materiales_seguridad.Nombre,
	cross_checking_materiales_seguridad.Codigo';
	$SIS_join  = 'LEFT JOIN `cross_checking_materiales_seguridad` ON cross_checking_materiales_seguridad.idMatSeguridad = cross_solicitud_aplicacion_listado_materiales.idMatSeguridad';
	$SIS_where = 'cross_solicitud_aplicacion_listado_materiales.idSolicitud ='.$_GET['view'];
	$SIS_order = 'cross_checking_materiales_seguridad.Nombre ASC';
	$arrMateriales = array();
	$arrMateriales = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_materiales', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMateriales');

	/*****************************************/
	$arrTrac = array();
	foreach ($arrTractores as $prod) {
		$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['idTractores']     = $prod['idTractores'];
		$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['Nombre']          = $prod['TeleNombre'];
		$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['VehiculoNombre']  = $prod['VehiculoNombre'];
		$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['Trabajador']      = $prod['Rut'].' - '.$prod['Nombre'].' '.$prod['ApellidoPat'];
	}

	/*****************************************/
	$arrProd = array();
	foreach ($arrProductos as $prod) {
		$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['idProdQuim']       = $prod['idProdQuim'];
		$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['DosisRecomendada'] = $prod['DosisRecomendada'];
		$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['DosisAplicar']     = $prod['DosisAplicar'];
		$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['Objetivo']         = $prod['Objetivo'];
		$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['Producto']         = $prod['Producto'];
		$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['Unimed']           = $prod['Unimed'];
	}

	?>

	<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive" style="margin-bottom:30px">

		<div id="page-wrap">
			<div id="header"> SOLICITUD DE APLICACIONES N° <?php echo n_doc($rowData['NSolicitud'], 5); ?></div>
			<div id="customer">
				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
						</tr>
						<tr>
							<td class="meta-head">Prioridad</td>
							<td><?php echo $rowData['NombrePrioridad']?></td>
						</tr>
						<tr>
							<td class="meta-head">Predio</td>
							<td><?php echo $rowData['NombrePredio']?></td>
						</tr>
						<tr>
							<td class="meta-head">Temporada</td>
							<td><?php echo $rowData['TemporadaCodigo'].' '.$rowData['TemporadaNombre']?></td>
						</tr>
						<tr>
							<td class="meta-head">Estado Fenológico</td>
							<td><?php echo $rowData['EstadoFenCodigo'].' '.$rowData['EstadoFenNombre']?></td>
						</tr>
						<?php if(isset($rowData['VariedadCat'])&&$rowData['VariedadCat']!=''){ ?>
							<tr>
								<td class="meta-head">Especie - Variedad</td>
								<td>
									<?php echo $rowData['VariedadCat'];
									if(isset($rowData['VariedadNombre'])&&$rowData['VariedadNombre']!=''){echo ' - '.$rowData['VariedadNombre'];}
									?>
								</td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td class="meta-head">Especie - Variedad</td>
								<td>Todas las Especies - Variedades</td>
							</tr>
						<?php } ?>
						<tr>
							<td class="meta-head">Estado</td>
							<td><?php echo $rowData['Estado']?></td>
						</tr>
						<tr>
							<td class="meta-head">Usuario Creador</td>
							<td><?php echo $rowData['NombreUsuario']?></td>
						</tr>
						<tr>
							<td class="meta-head"><strong>PARAMETROS APLICACION</strong></td>
							<td class="meta-head"></td>
						</tr>
						<tr>
							<td class="meta-head">Mojamiento</td>
							<td><?php echo Cantidades_decimales_justos($rowData['Mojamiento']).' L/ha'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Velocidad Tractor</td>
							<td><?php echo Cantidades_decimales_justos($rowData['VelTractor']).' Km/hr'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Velocidad Viento</td>
							<td><?php echo Cantidades_decimales_justos($rowData['VelViento']).' Km/hr'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Temperatura Min</td>
							<td><?php echo Cantidades_decimales_justos($rowData['TempMin']).' °'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Temperatura Max</td>
							<td><?php echo Cantidades_decimales_justos($rowData['TempMax']).' °'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Humedad</td>
							<td><?php echo Cantidades_decimales_justos($rowData['HumTempMax']).' %'; ?></td>
						</tr>
					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>
						<tr>
							<td class="meta-head">Creado</td>
							<td><?php echo Fecha_estandar($rowData['f_creacion']); ?></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha inicio requerido</td>
							<td><?php echo fecha_estandar($rowData['f_programacion']).' '.$rowData['horaProg']?></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha termino requerido</td>
							<td><?php echo fecha_estandar($rowData['f_programacion_fin']).' '.$rowData['horaProg_fin']?></td>
						</tr>
						<?php if(isset($rowData['f_ejecucion'])&&$rowData['f_ejecucion']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha inicio programación</td>
								<td><?php echo fecha_estandar($rowData['f_ejecucion']).' '.$rowData['horaEjecucion']?></td>
							</tr>
							<tr>
								<td class="meta-head">Fecha termino programación</td>
								<td><?php echo fecha_estandar($rowData['f_ejecucion_fin']).' '.$rowData['horaEjecucion_fin']?></td>
							</tr>
						<?php } ?>
						<?php if(isset($rowData['f_termino'])&&$rowData['f_termino']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha inicio ejecución</td>
								<td><?php echo fecha_estandar($rowData['f_termino']).' '.$rowData['horaTermino']?></td>
							</tr>
							<tr>
								<td class="meta-head">Fecha termino ejecución</td>
								<td><?php echo fecha_estandar($rowData['f_termino_fin']).' '.$rowData['horaTermino_fin']?></td>
							</tr>
						<?php } ?>
						<?php if(isset($rowData['idDosificador'])&&$rowData['idDosificador']!=0){ ?>
							<tr>
								<td class="meta-head">Dosificador</td>
								<td><?php echo $rowData['TrabajadorRut'].' '.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat']?></td>
							</tr>
						<?php } ?>

					</tbody>
				</table>
			</div>
			<table id="items">
				<tbody>

					<tr>
						<th colspan="8">Detalle</th>
						<th width="160">Acciones</th>
					</tr>
					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td colspan="6"><strong>Materiales de Seguridad</strong></td>
						<td colspan="2"><strong>Codigo</strong></td>
						<td>
							<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']!=3){ ?><a href="<?php echo $location.'&addMaterial=true' ?>" title="Agregar Materiales" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Materiales</a><?php } ?>
						</td>
					</tr>
					<?php
						//recorro el lsiatdo entregado por la base de datos
						if ($arrMateriales!=false && !empty($arrMateriales) && $arrMateriales!='') {
							foreach ($arrMateriales as $prod) { ?>
								<tr class="item-row linea_punteada">
									<td class="item-name" colspan="6"><i class="fa fa-eyedropper" aria-hidden="true"></i> <?php echo $prod['Nombre']; ?></td>
									<td class="item-name" colspan="2"><?php echo $prod['Codigo']; ?></td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']!=3&&isset($cuartel['idEstado'])&&$cuartel['idEstado']==1){ ?>
												<?php
												$ubicacion = $location.'&del_material='.simpleEncode($prod['idMatSeg'], fecha_actual());
												$dialogo   = '¿Realmente deseas eliminar el material de seguridad '.$prod['Nombre'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Cuartel" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
											<?php } ?>
										</div>
									</td>
								</tr>
						<?php } ?>
					<?php } ?>

					<?php /**********************************************************************************/?>
					<tr class="item-row fact_tittle">
						<td><strong>Cuarteles</strong></td>
						<td><strong>Variedad - Especie</strong></td>
						<td><strong>Mojamiento</strong></td>
						<td><strong>Vel. Tractor</strong></td>
						<td><strong>Vel. Viento</strong></td>
						<td><strong>Temp Min</strong></td>
						<td><strong>Temp Max</strong></td>
						<td><strong>Hum Temp Max</strong></td>
						<td>
							<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']!=3){ ?><a href="<?php echo $location.'&addCuartel=true' ?>" title="Agregar Cuartel" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Cuartel</a><?php } ?>
						</td>
					</tr>
					<?php
						//recorro el lsiatdo entregado por la base de datos
						if ($arrCuarteles!=false && !empty($arrCuarteles) && $arrCuarteles!='') {
							foreach ($arrCuarteles as $cuartel) { ?>
								<tr class="item-row linea_punteada" style="background: #eee;">
									<td class="item-name"><?php echo $cuartel['CuartelNombre'];if(isset($cuartel['idEstado'])&&$cuartel['idEstado']==2){ echo '(Cerrado el '.fecha_estandar($cuartel['f_cierre']).')';} ?></td>
									<td class="item-name"><?php echo $cuartel['CuartelEspecie'].' '.$cuartel['CuartelVariedad']; ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['Mojamiento']).' L/ha'; ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['VelTractor']).' Km/hr'; ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['VelViento']).' Km/hr'; ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['TempMin']).' °'; ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['TempMax']).' °'; ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['HumTempMax']).' %'; ?></td>
									<td>
										<div class="btn-group" style="width: 140px;">
											<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']!=3&&isset($cuartel['idEstado'])&&$cuartel['idEstado']==1){ ?>
												<a href="<?php echo $location.'&cuartel_id='.$cuartel['idCuarteles'].'&edit_Cuarteles='.$rowData['idEstado']; ?>" title="Editar Cuartel" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="<?php echo $location.'&cuartel_id='.$cuartel['idCuarteles'].'&add_trac=true'; ?>" title="Agregar Tractor" class="btn btn-primary btn-sm tooltip"><i class="fa fa-truck" aria-hidden="true"></i></a>
												<a href="<?php echo $location.'&cuartel_id='.$cuartel['idCuarteles'].'&add_prod=true'; ?>" title="Agregar Producto Químico" class="btn btn-primary btn-sm tooltip"><i class="fa fa-flask" aria-hidden="true"></i></a>
												<?php /*if(isset($rowData['idEstado'])&&$rowData['idEstado']==2){
													$distancia = $cuartel['CuartelDistanciaPlant']*$cuartel['CuartelNPlantas'];
													?>
													<a href="<?php echo $location.'&lock_cuartel='.$cuartel['idCuarteles'].'&f_ejecucion='.$rowData['f_ejecucion'].'&f_ejecucion_fin='.$rowData['f_ejecucion_fin'].'&distancia='.$distancia; ?>" title="Cerrar Cuartel" class="btn btn-danger btn-sm tooltip"><i class="fa fa-lock" aria-hidden="true"></i></a>
												<?php }*/ ?>
												<?php
												$ubicacion = $location.'&del_cuartel='.simpleEncode($cuartel['idCuarteles'], fecha_actual());
												$dialogo   = '¿Realmente deseas eliminar el cuartel '.$cuartel['CuartelNombre'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Cuartel" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
											<?php } ?>
										</div>
									</td>
								</tr>
								<?php
								if($arrTrac[$cuartel['idCuarteles']]){
									//Se recorren los tractores
									foreach ($arrTrac[$cuartel['idCuarteles']] as $tract){ ?>

										<tr class="item-row linea_punteada">
											<td class="item-name" colspan="2"><i class="fa fa-truck" aria-hidden="true"></i> <?php echo '<strong>Tractor: </strong>'.$tract['Nombre']; ?></td>
											<td class="item-name" colspan="4"><?php echo '<strong>Equipo Aplicación: </strong>'.$tract['VehiculoNombre']; ?></td>
											<td class="item-name" colspan="2"><?php echo '<strong>Trabajador: </strong>'.$tract['Trabajador']; ?></td>
											<td>
												<div class="btn-group" style="width: 70px;" >
													<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']!=3&&isset($cuartel['idEstado'])&&$cuartel['idEstado']==1){ ?>
														<a href="<?php echo $location.'&cuartel_id='.$cuartel['idCuarteles'].'&edit_trac='.$tract['idTractores']; ?>" title="Editar Tractor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
														<?php
														$ubicacion = $location.'&cuartel_id='.$cuartel['idCuarteles'].'&del_trac='.simpleEncode($tract['idTractores'], fecha_actual());
														$dialogo   = '¿Realmente deseas eliminar el tractor '.$tract['Nombre'].'?'; ?>
														<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Tractor" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
													<?php } ?>
												</div>
											</td>
										</tr>
									<?php
									}
								}
								if($arrProd[$cuartel['idCuarteles']]){
									//Se recorren los quimicos a utilizar
									foreach ($arrProd[$cuartel['idCuarteles']] as $prod){ ?>

										<tr class="item-row linea_punteada">
											<td class="item-name" colspan="5">
												<i class="fa fa-flask" aria-hidden="true"></i>
												<?php echo '<strong>Producto Químico: </strong>'.$prod['Producto']; ?><br/>
												<?php echo '<strong>Objetivo: </strong>'.$prod['Objetivo']; ?><br/>
											</td>
											<td class="item-name" colspan="3">
												<?php echo '<strong>Dosis Recomendada: </strong>'.Cantidades_decimales_justos($prod['DosisRecomendada']).' '.$prod['Unimed']; ?><br/>
												<?php echo '<strong>Dosis a aplicar: </strong>'.Cantidades_decimales_justos($prod['DosisAplicar']).' '.$prod['Unimed']; ?><br/>
											</td>
											<td>
												<div class="btn-group" style="width: 70px;" >
													<?php if(isset($rowData['idEstado'])&&$rowData['idEstado']!=3&&isset($cuartel['idEstado'])&&$cuartel['idEstado']==1){ ?>
														<a href="<?php echo $location.'&cuartel_id='.$cuartel['idCuarteles'].'&edit_prod='.$prod['idProdQuim']; ?>" title="Editar Producto Quimico" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
														<?php
														$ubicacion = $location.'&cuartel_id='.$cuartel['idCuarteles'].'&del_prod='.simpleEncode($prod['idProdQuim'], fecha_actual());
														$dialogo   = '¿Realmente deseas eliminar el producto '.$prod['Producto'].'?'; ?>
														<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
													<?php } ?>
												</div>
											</td>
									</tr>

									<?php
									}
								}
							}
						}else{
							echo '<tr class="item-row linea_punteada"><td colspan="9">No hay cuarteles asignados</td></tr>';
						} ?>

				</tbody>
			</table>
			<div class="clearfix"></div>

		</div>

		<div id="page-wrap">
			<table id="items" style="margin-bottom: 20px;">
				<tbody>

					<tr class="invoice-total" bgcolor="#f1f1f1">
						<th colspan="8">Detalles</th>
						<th width="160"><a href="<?php echo $location.'&idEstado='.$rowData['idEstado'].'&addDetalle=true' ?>" title="Agregar Detalle" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Detalle</a></th>
					</tr>
					<tr>
						<th width="160">Fecha</th>
						<th width="160">Estado</th>
						<th width="260">Usuario</th>
						<th colspan="6">Observacion</th>
					</tr>

					<?php foreach ($arrHistorial as $doc){ ?>
						<tr class="item-row">
							<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
							<td><?php echo $doc['Estado']; ?></td>
							<td><?php echo $doc['Usuario']; ?></td>
							<td colspan="6"><?php echo $doc['Observacion']; ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>

	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
