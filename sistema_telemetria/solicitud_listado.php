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
$original = "solicitud_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){   $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];   $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){     $location .= "&Observaciones=".$_GET['Observaciones'];     $search .= "&Observaciones=".$_GET['Observaciones'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//se borran todas las variables
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'new_prod_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_prod_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//se borra un dato
if (!empty($_GET['del_prod'])){
	//Llamamos al formulario
	$form_trabajo= 'del_prod_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'new_ins_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_ins_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//se borra un dato
if (!empty($_GET['del_ins'])){
	//Llamamos al formulario
	$form_trabajo= 'del_ins_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'new_arriendo_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_arriendo_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//se borra un dato
if (!empty($_GET['del_arriendo'])){
	//Llamamos al formulario
	$form_trabajo= 'del_arriendo_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'new_servicio_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_servicio_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//se borra un dato
if (!empty($_GET['del_servicio'])){
	//Llamamos al formulario
	$form_trabajo= 'del_servicio_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_otros'])){
	//Llamamos al formulario
	$form_trabajo= 'new_otros_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit_otros'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_otros_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//se borra un dato
if (!empty($_GET['del_otros'])){
	//Llamamos al formulario
	$form_trabajo= 'del_otros_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
/**********************************************/
//se realiza el ingreso de la solicitud
if (!empty($_GET['ing_solicitud'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_solicitud';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
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
if(!empty($_GET['editOtros'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Otros</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){         $x1  = $Nombre;        }else{$x1  = $_SESSION['solicitud_otros'][$_GET['editOtros']]['Nombre'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = $_SESSION['solicitud_otros'][$_GET['editOtros']]['Cantidad'];}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['solicitud_otros'][$_GET['editOtros']]['idFrecuencia'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['solicitud_otros'][$_GET['editOtros']]['idOtros'], 2);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_otros">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addOtros'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Otros</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){         $x1  = $Nombre;        }else{$x1  = '';}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = '';}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_otros">
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
				if(isset($idServicio)){     $x1  = $idServicio;    }else{$x1  = $_SESSION['solicitud_servicios'][$_GET['editServicios']]['idServicio'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = $_SESSION['solicitud_servicios'][$_GET['editServicios']]['Cantidad'];}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['solicitud_servicios'][$_GET['editServicios']]['idFrecuencia'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['solicitud_servicios'][$_GET['editServicios']]['idServicio'], 2);
				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);
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

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);
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
				if(isset($idEquipo)){       $x1  = $idEquipo;      }else{$x1  = $_SESSION['solicitud_arriendos'][$_GET['editArriendo']]['idEquipo'];}
				if(isset($Cantidad)){       $x2  = $Cantidad;      }else{$x2  = $_SESSION['solicitud_arriendos'][$_GET['editArriendo']]['Cantidad'];}
				if(isset($idFrecuencia)){   $x3  = $idFrecuencia;  }else{$x3  = $_SESSION['solicitud_arriendos'][$_GET['editArriendo']]['idFrecuencia'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Equipos','idEquipo', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['solicitud_arriendos'][$_GET['editArriendo']]['idEquipo'], 2);
				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);
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

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Equipos','idEquipo', $x1, 2, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad de dias', 'Cantidad', $x2, 2);
				//$Form_Inputs->form_select('Frecuencia','idFrecuencia', $x3, 2, 'idFrecuencia', 'Nombre', 'core_tiempo_frecuencia', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idFrecuencia', 2, 2);
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
//filtro
$zx2 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_insumos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
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
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $_SESSION['solicitud_insumos'][$_GET['editIns']]['idProducto'];}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = $_SESSION['solicitud_insumos'][$_GET['editIns']]['Cantidad'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['solicitud_insumos'][$_GET['editIns']]['idProducto'], 2);
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
//filtro
$zx2 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_insumos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
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

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Insumo','idProducto', $x1, 2, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);
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
//filtro
$zx1 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_productos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
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
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $_SESSION['solicitud_productos'][$_GET['editProd']]['idProducto'];}
				if(isset($Cantidad)){         $x2  = $Cantidad;        }else{$x2  = $_SESSION['solicitud_productos'][$_GET['editProd']]['Cantidad'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

				$Form_Inputs->form_input_hidden('oldidProducto', $_SESSION['solicitud_productos'][$_GET['editProd']]['idProducto'], 2);
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
//filtro
$zx1 = "idProducto=0";
//Se revisan los permisos a los productos
$arrPermisos = array();
$query = "SELECT idProducto
FROM `core_sistemas_productos`
WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPermisos,$row );
}
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

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Cantidad', $x2, 2);

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
}elseif(!empty($_GET['modBase'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Solicitud</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){   $x1  = $Creacion_fecha; }else{$x1  = $_SESSION['solicitud_basicos']['Creacion_fecha'];}
				if(isset($Observaciones)){    $x2  = $Observaciones;  }else{$x2  = $_SESSION['solicitud_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Solicitud','Creacion_fecha', $x1, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x2, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Modificar Documento" name="submit_modBase">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
//Variable para sacar el total
$total = 0;		
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&ing_solicitud=true';
		$dialogo   = '¿Realmente desea ingresar el documento?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i>  Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Solicitud</div>
	   

		
		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary pull-right tooltip" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Usuario</td>
						<td><?php echo $_SESSION['solicitud_basicos']['Usuario'];  ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td><?php echo Fecha_estandar($_SESSION['solicitud_basicos']['Creacion_fecha']); ?></td>
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
					<td colspan="5">Productos a Solicitar</td>
					<td><a href="<?php echo $location.'&addProd=true' ?>" title="Agregar Producto" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a></td>
				</tr>
				<?php
				if (isset($_SESSION['solicitud_productos'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['solicitud_productos'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4">
								<?php echo $producto['Nombre']; ?>
							</td>
							<td class="item-name">
								<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Unimed']; ?>
							</td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editProd='.$producto['idProducto']; ?>" title="Editar Producto" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del_prod='.$producto['idProducto'];
									$dialogo   = '¿Realmente deseas eliminar el producto '.$producto['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Producto" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
				<?php }
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Insumos a Solicitar</td>
					<td><a href="<?php echo $location.'&addIns=true' ?>" title="Agregar Insumo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumos</a></td>
				</tr>
				<?php
				if (isset($_SESSION['solicitud_insumos'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['solicitud_insumos'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4">
								<?php echo $producto['Nombre']; ?>
							</td>
							<td class="item-name">
								<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Unimed']; ?>
							</td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editIns='.$producto['idProducto']; ?>" title="Editar Insumo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del_ins='.$producto['idProducto'];
									$dialogo   = '¿Realmente deseas eliminar el producto '.$producto['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Insumo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
				<?php }
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Arriendo de equipos a Solicitar</td>
					<td><a href="<?php echo $location.'&addArriendo=true' ?>" title="Agregar Arriendo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Arriendos</a></td>
				</tr>
				<?php
				if (isset($_SESSION['solicitud_arriendos'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['solicitud_arriendos'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4">
								<?php echo $producto['Nombre']; ?>
							</td>
							<td class="item-name">
								<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?>
							</td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editArriendo='.$producto['idEquipo']; ?>" title="Editar Arriendo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del_arriendo='.$producto['idEquipo'];
									$dialogo   = '¿Realmente deseas eliminar el arriendo '.$producto['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Arriendo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
				<?php }
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Servicios a Solicitar</td>
					<td><a href="<?php echo $location.'&addServicios=true' ?>" title="Agregar Servicio" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Servicios</a></td>
				</tr>
				<?php
				if (isset($_SESSION['solicitud_servicios'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['solicitud_servicios'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4">
								<?php echo $producto['Nombre']; ?>
							</td>
							<td class="item-name">
								<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?>
							</td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editServicios='.$producto['idServicio']; ?>" title="Editar Servicio" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del_servicio='.$producto['idServicio'];
									$dialogo   = '¿Realmente deseas eliminar el servicio '.$producto['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Servicio" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
				<?php }
				} ?>

				<tr class="item-row fact_tittle">
					<td colspan="5">Otros a Solicitar</td>
					<td><a href="<?php echo $location.'&addOtros=true' ?>" title="Agregar Otro" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Otros</a></td>
				</tr>
				<?php
				if (isset($_SESSION['solicitud_otros'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['solicitud_otros'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name" colspan="4">
								<?php echo $producto['Nombre']; ?>
							</td>
							<td class="item-name">
								<?php echo Cantidades_decimales_justos($producto['Cantidad']).' '.$producto['Frecuencia']; ?>
							</td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editOtros='.$producto['idOtros']; ?>" title="Editar Otros" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&del_otros='.$producto['idOtros'];
									$dialogo   = '¿Realmente deseas eliminar  '.$producto['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Otros" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
				<?php }
				} ?>

			</tbody>
		</table>

    </div>

    <div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['solicitud_basicos']['Observaciones']; ?></p>
		</div>
	</div>

</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Solicitud</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){   $x1  = $Creacion_fecha; }else{$x1  = '';}
				if(isset($Observaciones)){    $x2  = $Observaciones;  }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Solicitud','Creacion_fecha', $x1, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x2, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
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
		case 'sol_asc':           $order_by = 'solicitud_listado.idSolicitud ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Solicitud Ascendente'; break;
		case 'sol_desc':          $order_by = 'solicitud_listado.idSolicitud DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Solicitud Descendente';break;
		case 'fecha_asc':         $order_by = 'solicitud_listado.Creacion_fecha ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
		case 'fecha_desc':        $order_by = 'solicitud_listado.Creacion_fecha DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
		case 'creador_asc':       $order_by = 'usuarios_listado.Nombre ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Creador Ascendente';break;
		case 'creador_desc':      $order_by = 'usuarios_listado.Nombre DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Creador Descendente';break;
		case 'observacion_asc':   $order_by = 'solicitud_listado.Observaciones ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Observaciones Ascendente';break;
		case 'observacion_desc':  $order_by = 'solicitud_listado.Observaciones DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Observaciones Descendente';break;

		default: $order_by = 'solicitud_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
	}
}else{
	$order_by = 'solicitud_listado.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "solicitud_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//verifico que sea un administrador
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_where.= " AND solicitud_listado.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
}
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND solicitud_listado.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){    $SIS_where .= " AND solicitud_listado.Observaciones LIKE '%".EstandarizarInput($_GET['Observaciones'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idSolicitud', 'solicitud_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
solicitud_listado.idSolicitud,
solicitud_listado.Creacion_fecha,
solicitud_listado.Observaciones,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = solicitud_listado.idUsuario';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrSolicitudes = array();
$arrSolicitudes = db_select_array (false, $SIS_query, 'solicitud_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSolicitudes');

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
		<?php if(isset($_SESSION['solicitud_basicos']['idProveedor'])&&$_SESSION['solicitud_basicos']['idProveedor']!=''){ ?>

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

			<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-arrow-right" aria-hidden="true"></i>  Continuar Solicitud</a>
		<?php }else{ ?>
			<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Solicitud</a>
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
				if(isset($Creacion_fecha)){   $x1  = $Creacion_fecha; }else{$x1  = '';}
				if(isset($Observaciones)){    $x2  = $Observaciones;  }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Solicitud','Creacion_fecha', $x1, 1);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x2, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Solicitudes</h5>
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
							<div class="pull-left">N° Sol</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=sol_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=sol_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th><th width="120">
							<div class="pull-left">Fecha</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Creador</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=creador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=creador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Observacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=observacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=observacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrSolicitudes as $sol) { ?>
					<tr class="odd">
						<td><?php echo n_doc($sol['idSolicitud'], 5); ?></td>
						<td><?php echo Fecha_estandar($sol['Creacion_fecha']); ?></td>
						<td><?php echo $sol['Usuario']; ?></td>
						<td><?php echo $sol['Observaciones']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($sol['idSolicitud'], fecha_actual()); ?>" title="Ver Orden" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($sol['idSolicitud'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la solicitud N° '.$sol['idSolicitud'].'?'; ?>
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
