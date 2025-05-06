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
$original = "informe_ocompra_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){

             
  

$z  = "WHERE Cantidad > cant_ingresada";
$z1 = "";
$z2 = "";
$z3 = "";
$z4 = "";
/**************************************************************/
if(isset($_GET['idOcompra']) && $_GET['idOcompra']!=''){$z .= " AND ocompra_listado.idOcompra=".$_GET['idOcompra'];}
if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){   $z .= " AND ocompra_listado.idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){$z .= " AND ocompra_listado.idSistema=".$_GET['idSistema'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){$z .= " AND ocompra_listado.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){  $z .= " AND ocompra_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['Creacion_fecha_ini'], $_GET['Creacion_fecha_fin']) && $_GET['Creacion_fecha_ini'] != '' && $_GET['Creacion_fecha_fin']!=''){   
	$z .= " AND ocompra_listado.Creacion_fecha BETWEEN '".$_GET['Creacion_fecha_ini']."' AND '".$_GET['Creacion_fecha_fin']."'";
}
/**************************************************************/
if(isset($_GET['idServicio']) && $_GET['idServicio']!=''){ $z1 .= " AND ocompra_listado_existencias_servicios.idServicio=".$_GET['idServicio'];}
if(isset($_GET['idEquipo']) && $_GET['idEquipo']!=''){     $z2 .= " AND ocompra_listado_existencias_arriendos.idEquipo=".$_GET['idEquipo'];}
if(isset($_GET['idInsumo']) && $_GET['idInsumo']!=''){     $z3 .= " AND ocompra_listado_existencias_insumos.idProducto=".$_GET['idInsumo'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){ $z4 .= " AND ocompra_listado_existencias_productos.idProducto=".$_GET['idProducto'];}
			
/**************************************************************/
// Se trae un listado con todos los productos
$arrServicios = array();
$query = "SELECT 
ocompra_listado.idOcompra,
ocompra_listado.Creacion_fecha,
servicios_listado.Nombre AS Producto,
ocompra_listado_existencias_servicios.Cantidad,
ocompra_listado_existencias_servicios.cant_ingresada

FROM `ocompra_listado_existencias_servicios`
LEFT JOIN `ocompra_listado`     ON ocompra_listado.idOcompra       = ocompra_listado_existencias_servicios.idOcompra
LEFT JOIN `servicios_listado`   ON servicios_listado.idServicio    = ocompra_listado_existencias_servicios.idServicio

".$z.$z1."
ORDER BY ocompra_listado.Creacion_fecha DESC";
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
/**************************************************************/
// Se trae un listado con todos los productos
$arrArriendos = array();
$query = "SELECT 
ocompra_listado.idOcompra,
ocompra_listado.Creacion_fecha,
equipos_arriendo_listado.Nombre AS Producto,
ocompra_listado_existencias_arriendos.Cantidad,
ocompra_listado_existencias_arriendos.cant_ingresada

FROM `ocompra_listado_existencias_arriendos`
LEFT JOIN `ocompra_listado`            ON ocompra_listado.idOcompra           = ocompra_listado_existencias_arriendos.idOcompra
LEFT JOIN `equipos_arriendo_listado`   ON equipos_arriendo_listado.idEquipo   = ocompra_listado_existencias_arriendos.idEquipo

".$z.$z2."
ORDER BY ocompra_listado.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrArriendos,$row );
}
/**************************************************************/
// Se trae un listado con todos los productos
$arrInsumos = array();
$query = "SELECT 
ocompra_listado.idOcompra,
ocompra_listado.Creacion_fecha,
insumos_listado.Nombre AS Producto,
ocompra_listado_existencias_insumos.Cantidad,
ocompra_listado_existencias_insumos.cant_ingresada

FROM `ocompra_listado_existencias_insumos`
LEFT JOIN `ocompra_listado`     ON ocompra_listado.idOcompra       = ocompra_listado_existencias_insumos.idOcompra
LEFT JOIN `insumos_listado`     ON insumos_listado.idProducto      = ocompra_listado_existencias_insumos.idProducto

".$z.$z3."
ORDER BY ocompra_listado.Creacion_fecha DESC";
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
/**************************************************************/
// Se trae un listado con todos los productos
$arrProductos = array();
$query = "SELECT 
ocompra_listado.idOcompra,
ocompra_listado.Creacion_fecha,
productos_listado.Nombre AS Producto,
ocompra_listado_existencias_productos.Cantidad,
ocompra_listado_existencias_productos.cant_ingresada

FROM `ocompra_listado_existencias_productos`
LEFT JOIN `ocompra_listado`     ON ocompra_listado.idOcompra       = ocompra_listado_existencias_productos.idOcompra
LEFT JOIN `productos_listado`   ON productos_listado.idProducto    = ocompra_listado_existencias_productos.idProducto

".$z.$z4."
ORDER BY ocompra_listado.Creacion_fecha DESC";
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


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ordenes de Compra Incompletas</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="10">#</th>
						<th width="10">Fecha</th>
						<th>Producto</th>
						<th width="10">Solicitado</th>
						<th width="10">Recepcionado</th>
						<th width="10">Faltante</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrServicios as $productos) { ?>
						<tr class="odd">
							<td><?php echo 'OC N°'.n_doc($productos['idOcompra'], 5); ?></td>
							<td><?php echo Fecha_estandar($productos['Creacion_fecha']); ?></td>
							<td><?php echo $productos['Producto']; ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['cant_ingresada']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']-$productos['cant_ingresada']); ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_ocompra.php?view='.simpleEncode($productos['idOcompra'], fecha_actual()); ?>" title="Ver Orden" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_busqueda_general_01.php?idOcompra='.$productos['idOcompra'].'&type=1&submit_filter=Filtrar'; ?>" title="Ver Documentos Relacionados" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					<?php foreach ($arrArriendos as $productos) { ?>
						<tr class="odd">
							<td><?php echo 'OC N°'.n_doc($productos['idOcompra'], 5); ?></td>
							<td><?php echo Fecha_estandar($productos['Creacion_fecha']); ?></td>
							<td><?php echo $productos['Producto']; ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['cant_ingresada']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']-$productos['cant_ingresada']); ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_ocompra.php?view='.simpleEncode($productos['idOcompra'], fecha_actual()); ?>" title="Ver Orden" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_busqueda_general_01.php?idOcompra='.$productos['idOcompra'].'&type=1&submit_filter=Filtrar'; ?>" title="Ver Documentos Relacionados" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					<?php foreach ($arrInsumos as $productos) { ?>
						<tr class="odd">
							<td><?php echo 'OC N°'.n_doc($productos['idOcompra'], 5); ?></td>
							<td><?php echo Fecha_estandar($productos['Creacion_fecha']); ?></td>
							<td><?php echo $productos['Producto']; ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['cant_ingresada']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']-$productos['cant_ingresada']); ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_ocompra.php?view='.simpleEncode($productos['idOcompra'], fecha_actual()); ?>" title="Ver Orden" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_busqueda_general_01.php?idOcompra='.$productos['idOcompra'].'&type=1&submit_filter=Filtrar'; ?>" title="Ver Documentos Relacionados" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					<?php foreach ($arrProductos as $productos) { ?>
						<tr class="odd">
							<td><?php echo 'OC N°'.n_doc($productos['idOcompra'], 5); ?></td>
							<td><?php echo Fecha_estandar($productos['Creacion_fecha']); ?></td>
							<td><?php echo $productos['Producto']; ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['cant_ingresada']); ?></td>
							<td><?php echo Cantidades_decimales_justos($productos['Cantidad']-$productos['cant_ingresada']); ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_ocompra.php?view='.simpleEncode($productos['idOcompra'], fecha_actual()); ?>" title="Ver Orden" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_busqueda_general_01.php?idOcompra='.$productos['idOcompra'].'&type=1&submit_filter=Filtrar'; ?>" title="Ver Documentos Relacionados" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z="idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}

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
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idOcompra)){           $x1  = $idOcompra;           }else{$x1  = '';}
				if(isset($idProveedor)){         $x2  = $idProveedor;         }else{$x2  = '';}
				if(isset($Creacion_fecha_ini)){  $x3  = $Creacion_fecha_ini;  }else{$x3  = '';}
				if(isset($Creacion_fecha_fin)){  $x4  = $Creacion_fecha_fin;  }else{$x4  = '';}
				if(isset($idSistema)){           $x5  = $idSistema;           }else{$x5  = '';}
				if(isset($idUsuario)){           $x6  = $idUsuario;           }else{$x6  = '';}
				if(isset($idEstado)){            $x7  = $idEstado;            }else{$x7  = '';}
				if(isset($idServicio)){          $x8  = $idServicio;          }else{$x8  = '';}
				if(isset($idEquipo)){            $x9  = $idEquipo;            }else{$x9  = '';}
				if(isset($idInsumo)){            $x10 = $idInsumo;            }else{$x10 = '';}
				if(isset($idProducto)){          $x11 = $idProducto;          }else{$x11 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Básicos');
				$Form_Inputs->form_input_number('Numero OC', 'idOcompra', $x1, 1);
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x2, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $z, '', $dbConn);
				$Form_Inputs->form_date('F Creacion Ini','Creacion_fecha_ini', $x3, 1);
				$Form_Inputs->form_date('F Creacion Fin','Creacion_fecha_fin', $x4, 1);
				$Form_Inputs->form_select('Sistema Origen','idSistema', $x5, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);
				$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x6, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x7, 1, 'idEstado', 'Nombre', 'core_oc_estado', 0, '', $dbConn);

				$Form_Inputs->form_tittle(3, 'Contenido');
				$Form_Inputs->form_select_filter('Servicio','idServicio', $x8, 1, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_select_filter('Equipos','idEquipo', $x9, 1, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_select_filter('Insumo','idInsumo', $x10, 1, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
				$Form_Inputs->form_select_filter('Producto','idProducto', $x11, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);

				
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
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
