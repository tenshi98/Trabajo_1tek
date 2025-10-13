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
$original = "ocompra_generacion.php";
$location = $original;
//Se agregan ubicaciones
if(isset($_GET['idSistema'])){                         $location .= "?idSistema=".$_GET['idSistema']; 	}
if(isset($_GET['submit']) && $_GET['submit']!=''){   $location .= "&submit=".$_GET['submit']; 	}

//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_Productos'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_Productos';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_Insumos'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_Insumos';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_Arriendos'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_Arriendos';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_Servicios'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_Servicios';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_Otros'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_Otros';
	require_once 'A1XRXS_sys/xrxs_form/z_solicitud_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_OC'])){
	//Llamamos al formulario
	$form_trabajo= 'crear_oc';
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
if (isset($_GET['created'])){ $error['created'] = 'sucess/Proveedor Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Proveedor Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Proveedor Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['new_oc'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Datos Nueva Orden de Compra</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){   $x2  = $Creacion_fecha; }else{$x2  = '';}
				if(isset($Observaciones)){    $x3  = $Observaciones;  }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Orden de Compra','Creacion_fecha', $x2, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x3, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idProveedor', $_GET['new_oc'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Crear Documento" name="submit_OC">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_Otros'])){
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
// Se traen todos los datos
$query = "SELECT idProveedor
FROM `solicitud_listado_existencias_otros`
WHERE idExistencia = ".$_GET['edit_Otros'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	 
	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Proveedor</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = $rowData['idProveedor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);

				$Form_Inputs->form_input_hidden('idExistencia', $_GET['edit_Otros'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_Otros">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_Productos'])){
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
// Se traen todos los datos
$query = "SELECT idProveedor, idProducto
FROM `solicitud_listado_existencias_productos`
WHERE idExistencia = ".$_GET['edit_Productos'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	 
	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Proveedor</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = $rowData['idProveedor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);

				$Form_Inputs->form_input_hidden('idProducto', $rowData['idProducto'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_Productos">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_Insumos'])){
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
// Se traen todos los datos
$query = "SELECT idProveedor, idProducto
FROM `solicitud_listado_existencias_insumos`
WHERE idExistencia = ".$_GET['edit_Insumos'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	 
	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Proveedor</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = $rowData['idProveedor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);

				$Form_Inputs->form_input_hidden('idProducto', $rowData['idProducto'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_Insumos">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_Arriendos'])){
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
// Se traen todos los datos
$query = "SELECT idProveedor, idEquipo
FROM `solicitud_listado_existencias_arriendos`
WHERE idExistencia = ".$_GET['edit_Arriendos'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	 
	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Proveedor</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = $rowData['idProveedor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);

				$Form_Inputs->form_input_hidden('idEquipo', $rowData['idEquipo'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_Arriendos">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_Servicios'])){
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
// Se traen todos los datos
$query = "SELECT idProveedor, idServicio
FROM `solicitud_listado_existencias_servicios`
WHERE idExistencia = ".$_GET['edit_Servicios'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	 
	 
?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Proveedor</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){      $x1  = $idProveedor;    }else{$x1  = $rowData['idProveedor'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $w, '', $dbConn);

				$Form_Inputs->form_input_hidden('idServicio', $rowData['idServicio'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_Servicios">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['submit'])){
//Se verifica si se creo sistema
$aa1 = '';
$aa2 = '';
$aa3 = '';
$aa4 = '';
$aa5 = '';
$aa6 = '';
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){
	$aa1 = ' AND solicitud_listado_existencias_productos.idSistema='.$_GET['idSistema'];
	$aa2 = ' AND solicitud_listado_existencias_insumos.idSistema='.$_GET['idSistema'];
	$aa3 = ' AND solicitud_listado_existencias_arriendos.idSistema='.$_GET['idSistema'];
	$aa4 = ' AND solicitud_listado_existencias_servicios.idSistema='.$_GET['idSistema'];
	$aa5 = ' AND solicitud_listado_existencias_otros.idSistema='.$_GET['idSistema'];
	$aa6 = ' AND idSistema='.$_GET['idSistema'];
}



// Se trae un listado con todos los productos
$arrProductos = array();
$query = "SELECT 
solicitud_listado_existencias_productos.idExistencia,
solicitud_listado_existencias_productos.idSolicitud, 
solicitud_listado_existencias_productos.idProducto, 
solicitud_listado_existencias_productos.idProveedor,
solicitud_listado_existencias_productos.Cantidad,
productos_listado.Nombre AS Producto,
sistema_productos_uml.Nombre AS Unimed

FROM `solicitud_listado_existencias_productos` 
LEFT JOIN `productos_listado`       ON productos_listado.idProducto   = solicitud_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = productos_listado.idUml
WHERE solicitud_listado_existencias_productos.idOcompra=0 
".$aa1."
ORDER BY solicitud_listado_existencias_productos.idProveedor ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrProductos,$row );
}
// Se trae un listado con todos los insumos
$arrInsumos = array();
$query = "SELECT 
solicitud_listado_existencias_insumos.idExistencia,
solicitud_listado_existencias_insumos.idSolicitud, 
solicitud_listado_existencias_insumos.idProducto, 
solicitud_listado_existencias_insumos.idProveedor,
solicitud_listado_existencias_insumos.Cantidad,
insumos_listado.Nombre AS Insumo,
sistema_productos_uml.Nombre AS Unimed

FROM `solicitud_listado_existencias_insumos` 
LEFT JOIN `insumos_listado`        ON insumos_listado.idProducto   = solicitud_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml  = insumos_listado.idUml
WHERE solicitud_listado_existencias_insumos.idOcompra=0  
".$aa2."
ORDER BY solicitud_listado_existencias_insumos.idProveedor ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrInsumos,$row );
}

// Se trae un listado con todos los maquinas arriendo
$arrMaquinasArriendo = array();
$query = "SELECT  
solicitud_listado_existencias_arriendos.idExistencia,
solicitud_listado_existencias_arriendos.idSolicitud, 
solicitud_listado_existencias_arriendos.idEquipo,
solicitud_listado_existencias_arriendos.idProveedor,
solicitud_listado_existencias_arriendos.Cantidad,
equipos_arriendo_listado.Nombre AS Arriendo,
core_tiempo_frecuencia.Nombre AS Fecuencia

FROM `solicitud_listado_existencias_arriendos` 
LEFT JOIN `equipos_arriendo_listado`  ON equipos_arriendo_listado.idEquipo     = solicitud_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_tiempo_frecuencia`    ON core_tiempo_frecuencia.idFrecuencia   = solicitud_listado_existencias_arriendos.idFrecuencia
WHERE solicitud_listado_existencias_arriendos.idOcompra=0  
".$aa3."
ORDER BY solicitud_listado_existencias_arriendos.idProveedor ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrMaquinasArriendo,$row );
}

// Se trae un listado con todos los servicios
$arrServicios = array();
$query = "SELECT 
solicitud_listado_existencias_servicios.idExistencia,
solicitud_listado_existencias_servicios.idSolicitud,  
solicitud_listado_existencias_servicios.idServicio, 
solicitud_listado_existencias_servicios.idProveedor,
solicitud_listado_existencias_servicios.Cantidad,
servicios_listado.Nombre AS Servicio,
core_tiempo_frecuencia.Nombre AS Fecuencia

FROM `solicitud_listado_existencias_servicios` 
LEFT JOIN `servicios_listado`         ON servicios_listado.idServicio          = solicitud_listado_existencias_servicios.idServicio
LEFT JOIN `core_tiempo_frecuencia`    ON core_tiempo_frecuencia.idFrecuencia   = solicitud_listado_existencias_servicios.idFrecuencia
WHERE solicitud_listado_existencias_servicios.idOcompra=0  
".$aa4."
ORDER BY solicitud_listado_existencias_servicios.idProveedor ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrServicios,$row );
}	 

// Se trae un listado con todos los servicios
$arrOtros = array();
$query = "SELECT 
solicitud_listado_existencias_otros.idExistencia,
solicitud_listado_existencias_otros.idSolicitud, 
solicitud_listado_existencias_otros.Cantidad,
solicitud_listado_existencias_otros.Nombre AS Otro,
solicitud_listado_existencias_otros.idProveedor,
core_tiempo_frecuencia.Nombre AS Fecuencia

FROM `solicitud_listado_existencias_otros` 
LEFT JOIN `core_tiempo_frecuencia`    ON core_tiempo_frecuencia.idFrecuencia   = solicitud_listado_existencias_otros.idFrecuencia
WHERE solicitud_listado_existencias_otros.idOcompra=0  
".$aa5."
";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrOtros,$row );
}

// Se trae un listado con todos los servicios
$arrProveedores = array();
$query = "SELECT  idProveedor, Nombre
FROM `proveedor_listado` 
WHERE idEstado=1 
".$aa6."
";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrProveedores,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Solicitudes Agrupadas por proveedor</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="120">N° Solicitud</th>
						<th>Producto</th>
						<th width="120">Cantidad</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrProveedores as $prov) {
							//Se cuenta si es que tiene productos asignados
							$contar = 0;
							foreach ($arrProductos as $prod) {
								if($prov['idProveedor']==$prod['idProveedor']){
									$contar++;
								}
							}
							foreach ($arrInsumos as $prod) {
								if($prov['idProveedor']==$prod['idProveedor']){
									$contar++;
								}
							}
							foreach ($arrMaquinasArriendo as $prod) {
								if($prov['idProveedor']==$prod['idProveedor']){
									$contar++;
								}
							}
							foreach ($arrServicios as $prod) {
								if($prov['idProveedor']==$prod['idProveedor']){
									$contar++;
								}
							}
							foreach ($arrOtros as $prod) {
								if($prov['idProveedor']==$prod['idProveedor']){
									$contar++;
								}
							}
							//Si tienen algo cargado
							if($contar!=0){	
							?>
								<tr class="info">
									<td colspan="3"><?php echo $prov['Nombre']; ?></td>
									<td><?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&new_oc='.$prov['idProveedor']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-file-o" aria-hidden="true"></i> Crear OC</a><?php } ?></td>
								</tr>
								<?php
								//Productos
								foreach ($arrProductos as $prod) {
									if($prov['idProveedor']==$prod['idProveedor']){ ?>
										<tr class="odd">
											<td><?php echo $prod['idSolicitud']; ?></td>
											<td><?php echo $prod['Producto']; ?></td>
											<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unimed']; ?></td>
											<td>
												<div class="btn-group" style="width: 105px;" >
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Productos='.$prod['idExistencia']; ?>" title="Modificar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_precios.php?type='.simpleEncode( 1, fecha_actual()).'&view='.simpleEncode($prod['idProducto'], fecha_actual()); ?>" title="Ver Variacion Precios" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a><?php } ?>
												</div>
											</td>
										</tr>
									<?php
									}
								}
								//Insumos
								foreach ($arrInsumos as $prod) {
									if($prov['idProveedor']==$prod['idProveedor']){ ?>
										<tr class="odd">
											<td><?php echo $prod['idSolicitud']; ?></td>
											<td><?php echo $prod['Insumo']; ?></td>
											<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unimed']; ?></td>
											<td>
												<div class="btn-group" style="width: 105px;" >
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Insumos='.$prod['idExistencia']; ?>" title="Modificar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_precios.php?type='.simpleEncode( 2, fecha_actual()).'&view='.simpleEncode($prod['idProducto'], fecha_actual()); ?>" title="Ver Variacion Precios" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a><?php } ?>
												</div>
											</td>
										</tr>
									<?php
									}
								}
								//Arriendos
								foreach ($arrMaquinasArriendo as $prod) {
									if($prov['idProveedor']==$prod['idProveedor']){ ?>
										<tr class="odd">
											<td><?php echo $prod['idSolicitud']; ?></td>
											<td><?php echo $prod['Arriendo']; ?></td>
											<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Fecuencia']; ?></td>
											<td>
												<div class="btn-group" style="width: 105px;" >
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Arriendos='.$prod['idExistencia']; ?>" title="Modificar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_precios.php?type='.simpleEncode( 3, fecha_actual()).'&view='.simpleEncode($prod['idEquipo'], fecha_actual()); ?>" title="Ver Variacion Precios" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a><?php } ?>
												</div>
											</td>
										</tr>
									<?php
									}
								}
								//Servicios
								foreach ($arrServicios as $prod) {
									if($prov['idProveedor']==$prod['idProveedor']){ ?>
										<tr class="odd">
											<td><?php echo $prod['idSolicitud']; ?></td>
											<td><?php echo $prod['Servicio']; ?></td>
											<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Fecuencia']; ?></td>
											<td>
												<div class="btn-group" style="width: 105px;" >
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Servicios='.$prod['idExistencia']; ?>" title="Modificar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_precios.php?type='.simpleEncode( 4, fecha_actual()).'&view='.simpleEncode($prod['idServicio'], fecha_actual()); ?>" title="Ver Variacion Precios" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a><?php } ?>
												</div>
											</td>
										</tr>
									<?php
									}
								}
								//Otros
								foreach ($arrOtros as $prod) {
									if($prov['idProveedor']==$prod['idProveedor']){ ?>
										<tr class="odd">
											<td><?php echo $prod['idSolicitud']; ?></td>
											<td><?php echo $prod['Otro']; ?></td>
											<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Fecuencia']; ?></td>
											<td>
												<div class="btn-group" style="width: 105px;" >
													<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
													<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Otros='.$prod['idExistencia']; ?>" title="Modificar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
												</div>
											</td>
										</tr>
									<?php
									}
								}
							}
						} ?>  
					                 
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Solicitudes Sin proveedor</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="120">N° Solicitud</th>
						<th>Producto</th>
						<th width="120">Cantidad</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php
							//Productos
							foreach ($arrProductos as $prod) {
								if($prod['idProveedor']==0){ ?>
									<tr class="odd">
										<td><?php echo $prod['idSolicitud']; ?></td>
										<td><?php echo $prod['Producto']; ?></td>
										<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unimed']; ?></td>
										<td>
											<div class="btn-group" style="width: 105px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Productos='.$prod['idExistencia']; ?>" title="Asignar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php
								}
							}
							//Insumos
							foreach ($arrInsumos as $prod) {
								if($prod['idProveedor']==0){ ?>
									<tr class="odd">
										<td><?php echo $prod['idSolicitud']; ?></td>
										<td><?php echo $prod['Insumo']; ?></td>
										<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unimed']; ?></td>
										<td>
											<div class="btn-group" style="width: 105px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Insumos='.$prod['idExistencia']; ?>" title="Asignar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php
								}
							}
							//Arriendos
							foreach ($arrMaquinasArriendo as $prod) {
								if($prod['idProveedor']==0){ ?>
									<tr class="odd">
										<td><?php echo $prod['idSolicitud']; ?></td>
										<td><?php echo $prod['Arriendo']; ?></td>
										<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Fecuencia']; ?></td>
										<td>
											<div class="btn-group" style="width: 105px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Arriendos='.$prod['idExistencia']; ?>" title="Asignar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php
								}
							}
							//Servicios
							foreach ($arrServicios as $prod) {
								if($prod['idProveedor']==0){ ?>
									<tr class="odd">
										<td><?php echo $prod['idSolicitud']; ?></td>
										<td><?php echo $prod['Servicio']; ?></td>
										<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Fecuencia']; ?></td>
										<td>
											<div class="btn-group" style="width: 105px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Servicios='.$prod['idExistencia']; ?>" title="Asignar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php
								}
							}
							//Otros
							foreach ($arrOtros as $prod) {
								if($prod['idProveedor']==0){ ?>
									<tr class="odd">
										<td><?php echo $prod['idSolicitud']; ?></td>
										<td><?php echo $prod['Otro']; ?></td>
										<td><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Fecuencia']; ?></td>
										<td>
											<div class="btn-group" style="width: 105px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud.php?view='.simpleEncode($prod['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_Otros='.$prod['idExistencia']; ?>" title="Modificar Proveedor" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php
								}
							}
						?>
				</tbody>
			</table>
		</div>
	</div>
</div>



	 
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="<?php echo $original ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtrar Solicitudes</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" action="<?php echo $location; ?>" id="form1" name="form1" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idSistema)){        $x1  = $idSistema;      }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Sistema','idSistema', $x1, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Filtrar" name="submit">
				</div>

			</form>
            <?php widget_validator(); ?>
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
