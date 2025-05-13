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
$new_location = "productos_listado_datos_receta_01.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_1'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'new_receta_1';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
/****************************************************/
//formulario para crear
if (!empty($_POST['submit_prod'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'new_prod_ing';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_prod'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'edit_prod_ing';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
//se borra un dato
if (!empty($_GET['del_prod'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_prod_ing';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
/****************************************************/
//se borra un dato
if (!empty($_GET['finalizar'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'finalizar';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
//se borra un dato
if (!empty($_GET['del_receta'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_receta';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
/****************************************************/
//formulario para crear
if (!empty($_POST['submit_newprod'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update_prod_ing_new';
	require_once 'A1XRXS_sys/xrxs_form/productos_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update_prod_ing';
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
if (isset($_GET['created'])){ $error['created'] = 'sucess/Receta Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Receta Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Receta Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['newProd'])){  
//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

//Listado de unidades
$SIS_query = '
productos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'idTipoProducto=1 AND idEstado=1';
$SIS_order = 'sistema_productos_uml.Nombre ASC';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

//filtro
$zx1 = "idProducto=0";
foreach ($arrPermisos as $prod) {
	$zx1 .= " OR (idTipoProducto=1 AND idEstado=1 AND idProducto=".$prod['idProducto'].")";
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Materia Prima</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProductoRel)){    $x1  = $idProductoRel;   }else{$x1  = '';}
				if(isset($Number)){           $x2  = $Number;          }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProductoRel', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Number', $x2, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('idProducto', $_GET['id'], 2);

				?>

				<script>
					/**********************************************************************/
					<?php
					foreach ($arrTipo as $tipo) {
						echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
					}
					?>

					/**********************************************************************/
					document.getElementById("idProductoRel").onchange = function() {LoadProducto()};

					/**********************************************************************/
					function LoadProducto(){
						let Componente = document.getElementById("idProductoRel").value;
						if (Componente != "") {
							//escribo dentro del input
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_newprod">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit'])){
//Se traen los datos
$SIS_query = '
productos_recetas.idProductoRel,
productos_recetas.Cantidad,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = '
LEFT JOIN `productos_listado`      ON productos_listado.idProducto   = productos_recetas.idProductoRel
LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml    = productos_listado.idUml';
$SIS_where = 'productos_recetas.idReceta='.$_GET['edit'];
$rowData = db_select_data (false, $SIS_query, 'productos_recetas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'idProducto ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

//Listado de unidades
$SIS_query = '
productos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'idTipoProducto=1 AND idEstado=1';
$SIS_order = 'sistema_productos_uml.Nombre ASC';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

//filtro
$zx1 = "idProducto=0";
//recorro
foreach ($arrPermisos as $prod) {
	$zx1 .= " OR (idTipoProducto=1 AND idEstado=1 AND idProducto=".$prod['idProducto'].")";
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Productos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProductoRel)){    $x1  = $idProductoRel;   }else{$x1  = $rowData['idProductoRel'];}
				if(isset($Number)){           $x2  = $Number;          }else{$x2  = Cantidades_decimales_justos($rowData['Cantidad']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProductoRel', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Number', $x2, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled value="'.$rowData['Unimed'].'">
					</div>
				</div>';

				$Form_Inputs->form_input_hidden('idReceta', $_GET['edit'], 2);
				$Form_Inputs->form_input_hidden('idProducto', $_GET['id'], 2);

				?>

				<script>
					/**********************************************************************/
					<?php
					foreach ($arrTipo as $tipo) {
						echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
					}
					?>

					/**********************************************************************/
					document.getElementById("idProductoRel").onchange = function() {LoadProducto()};

					/**********************************************************************/
					function LoadProducto(){
						let Componente = document.getElementById("idProductoRel").value;
						if (Componente != "") {
							//escribo dentro del input
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editProd'])){
//Se traen los datos
$SIS_query = 'sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'productos_listado.idProducto='.$_SESSION['receta_productos'][$_GET['editProd']]['idProducto'];
$rowData = db_select_data (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 0;
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

//Listado de unidades de medida
$SIS_query = '
productos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'idTipoProducto=1 AND idEstado=1';
$SIS_order = 'sistema_productos_uml.Nombre ASC';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

//filtro
$zx1 = "idProducto=0";
//recorro
foreach ($arrPermisos as $prod) {
	$zx1 .= " OR (idTipoProducto=1 AND idEstado=1 AND idProducto=".$prod['idProducto'].")";
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Productos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProducto)){       $x1  = $idProducto;      }else{$x1  = $_SESSION['receta_productos'][$_GET['editProd']]['idProducto'];}
				if(isset($Number)){           $x2  = $Number;          }else{$x2  = $_SESSION['receta_productos'][$_GET['editProd']]['Number'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Number', $x2, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled value="'.$rowData['Unimed'].'">
					</div>
				</div>';

				?>

				<script>
					/**********************************************************************/
					<?php
					foreach ($arrTipo as $tipo) {
						echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
					}
					?>

					/**********************************************************************/
					document.getElementById("idProducto").onchange = function() {LoadProducto()};

					/**********************************************************************/
					function LoadProducto(){
						let Componente = document.getElementById("idProducto").value;
						if (Componente != "") {
							//escribo dentro del input
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_prod">
					<a href="<?php echo $new_location.'&id='.$_GET['id'].'&new2=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addProd'])){
//Se revisan los permisos a los productos
$SIS_query = 'idProducto';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 0;
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_sistemas_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

//Listado de unidades de medida
$SIS_query = '
productos_listado.idProducto,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'idTipoProducto=1 AND idEstado=1';
$SIS_order = 'sistema_productos_uml.Nombre ASC';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

//filtro
$zx1 = "idProducto=0";
//recorro
foreach ($arrPermisos as $prod) {
	$zx1 .= " OR (idTipoProducto=1 AND idEstado=1 AND idProducto=".$prod['idProducto'].")";
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
				if(isset($Number)){           $x2  = $Number;          }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Producto','idProducto', $x1, 2, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_input_number('Cantidad', 'Number', $x2, 2);

				echo '<div class="form-group" id="div_">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_">Unidad de Medida</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<input type="text" placeholder="Unidad de Medida" class="form-control"  name="escribeme" id="escribeme" disabled >
					</div>
				</div>';

				?>

				<script>
					/**********************************************************************/
					<?php
					foreach ($arrTipo as $tipo) {
						echo 'let id_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
					}
					?>

					/**********************************************************************/
					document.getElementById("idProducto").onchange = function() {LoadProducto()};

					/**********************************************************************/
					function LoadProducto(){
						let Componente = document.getElementById("idProducto").value;
						if (Componente != "") {
							//escribo dentro del input
							document.getElementById("escribeme").value = eval("id_data_" + Componente);
						}
					}

				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_prod">
					<a href="<?php echo $new_location.'&id='.$_GET['id'].'&new2=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new2'])){
// Se traen todos los datos del producto
$SIS_query = '
productos_listado.Nombre,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'productos_listado.idProducto = '.$_SESSION['receta']['idProducto'];
$rowData = db_select_data (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

// Se trae un listado con todos los productos
$SIS_query = '
productos_listado.idProducto, 
productos_listado.Nombre,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'idTipoProducto=1 AND idEstado=1';
$SIS_order = 'sistema_productos_uml.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

?>

<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 pull-left">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Paso 2: Seleccion de Productos</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr>
							<td class="meta-head">Producto</td>
							<td><?php echo $rowData['Nombre']?></td>
						</tr>
						<tr>
							<td class="meta-head">Medida</td>
							<td><?php echo $_SESSION['receta']['medida'].' '.$rowData['Unidad']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Productos a utilizar (Calculo para 1 <?php echo $rowData['Unidad']; ?>)</h5>
				<div class="toolbar">
					<a href="<?php echo $new_location.'&id='.$_GET['id'].'&addProd=true' ?>" class="btn btn-xs btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">

						<tr>
							<th colspan="3">Detalle</th>
							<th width="10">Acciones</th>
						</tr>

						<?php
						$total = 0;
						if (isset($_SESSION['receta_productos'])){
							//recorro el lsiatdo entregado por la base de datos
							foreach ($arrProductos as $prod) {
								foreach ($_SESSION['receta_productos'] as $key => $producto){
									if($prod['idProducto']==$producto['idProducto']){
										//Sumo las cantidades
										$total = $total + $producto['Number']; ?>
										<tr class="item-row linea_punteada">
											<td class="item-name">
												<?php echo $prod['Nombre']; ?>
											</td>
											<td class="item-name"  width="120">
												<?php echo Cantidades_decimales_justos($producto['Number']).' '.$prod['Unimed']; ?>
											</td>
											<td class="item-name"  width="120">
												<?php echo Cantidades_decimales_justos($producto['Number']/$_SESSION['receta']['medida']).' '.$prod['Unimed']; ?>
											</td>
											<td>
												<div class="btn-group" style="width: 70px;" >
													<a href="<?php echo $new_location.'&id='.$_GET['id'].'&editProd='.$producto['idProducto']; ?>" title="Editar Cantidad" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
													<?php 
													$ubicacion = $new_location.'&id='.$_GET['id'].'&del_prod='.$producto['idProducto'];
													$dialogo   = '¿Realmente deseas eliminar el Producto '.str_replace('"','',$prod['Nombre']).'?'; ?>
													<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Dato" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
							  <?php }
								}
							}
						} ?>
						<tr>
							<td class="meta-head" align="right"><strong>Total</strong></td>
							<td class="meta-head"><strong><?php echo $total.' '.$rowData['Unidad']; ?></strong></td>
							<td class="meta-head"><strong><?php echo Cantidades_decimales_justos($total/$_SESSION['receta']['medida']).' '.$rowData['Unidad']; ?></strong></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">

	<?php if($_SESSION['receta']['medida']==$total){ ?>
		<?php
		$ubicacion = $new_location.'&id='.$_GET['id'].'&finalizar=true';
		$dialogo   = '¿Realmente desea ingresar el documento, una vez terminado no podra realizar cambios?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary pull-right margin_form_btn" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>			
	<?php } ?>

	<a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>"  class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Paso 1: Ingresar Medida del producto terminado</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($medida)){     $x1  = $medida;    }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('Medida','medida', $x1, 2);

				$Form_Inputs->form_input_hidden('idProducto', $_GET['id'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf178; Siguiente" name="submit_1">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
// consulto los datos
$SIS_query = '
productos_listado.Nombre,
productos_listado.idTipoProducto,
productos_listado.idTipoReceta,
sistema_productos_uml.Nombre AS UnidadMedida,
productos_listado.idOpciones_1, 
productos_listado.idOpciones_2';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'idProducto = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

// Se trae un listado con productos de la receta
$SIS_query = ' 
productos_recetas.idReceta,
productos_listado.Nombre AS NombreProd,
productos_recetas.Cantidad,
sistema_productos_uml.Nombre AS UnidadMedida';
$SIS_join  = '
LEFT JOIN `productos_listado`        ON productos_listado.idProducto     = productos_recetas.idProductoRel
LEFT JOIN `sistema_productos_uml`    ON sistema_productos_uml.idUml      = productos_listado.idUml';
$SIS_where = 'productos_recetas.idProducto = '.$_GET['id'];
$SIS_order = 'productos_listado.Nombre ASC';
$arrRecetas = array();
$arrRecetas = db_select_array (false, $SIS_query, 'productos_recetas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrRecetas');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Productos', $rowData['Nombre'], 'Editar Receta'); ?>
	<?php
	$conteoRecetas  = 0;
	$total = 0;
	foreach ($arrRecetas as $receta) {
		//Se verifica si existen productos en la receta
		$conteoRecetas++;
		//Se verifica si ya existe una cantidad predeterminada superior a 1
		$total = $total + $receta['Cantidad'];
	}
	//Se revisa si existen Productos dentro de la receta
	if($conteoRecetas==0){ ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Receta</a><?php } ?>
		</div>
	<?php }elseif($total<1){ ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&newProd=true'; ?>" class="btn btn-default pull-right margin_width" >Agregar Materia Prima</a><?php } ?>
		</div>
	<?php } ?>
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
							<li class="active"><a href="<?php echo 'productos_listado_datos_receta_01.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-align-left" aria-hidden="true"></i> Receta</a></li>
						<?php }elseif(isset($rowData['idTipoProducto'])&&$rowData['idTipoProducto']==2&&$rowData['idTipoReceta']==2){ ?>
							<li class=""><a href="<?php echo 'productos_listado_datos_receta_02.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-align-left" aria-hidden="true"></i> Receta</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'productos_listado_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'productos_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
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
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Producto</th>
						<th width="120">Cantidad</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrRecetas as $receta) { ?>
					<tr class="odd">
						<td><?php echo $receta['NombreProd']; ?></td>
						<td><?php echo Cantidades_decimales_justos($receta['Cantidad']).' '.$receta['UnidadMedida']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$receta['idReceta']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=3){
									$ubicacion = $new_location.'&id='.$_GET['id'].'&del_receta='.simpleEncode($receta['idReceta'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el producto '.$receta['NombreProd'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
				<?php } ?>

					<tr class="odd">
						<td align="right"><strong>Total</strong></td>
						<td><strong><?php echo Cantidades_decimales_justos($total).' '.$rowData['UnidadMedida']; ?></strong></td>		
						<td></td>
					</tr>
				</tbody>
			</table>
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
