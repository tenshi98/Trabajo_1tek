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
$original = "informe_gerencial_16.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']!=''){ $search .="&idTipoMov=".$_GET['idTipoMov'];}
if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){    $search .="&idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){ $search .="&idCliente=".$_GET['idCliente'];}
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){       $search .="&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){ $search .="&idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago'])&&$_GET['N_DocPago']!=''){ $search .="&N_DocPago=".$_GET['N_DocPago'];}
if(isset($_GET['f_inicio_p'], $_GET['f_termino_p'])&&$_GET['f_inicio_p']!=''&&$_GET['f_termino_p']!=''){
	$search .="&f_inicio_p=".$_GET['f_inicio_p'];
	$search .="&f_termino_p=".$_GET['f_termino_p'];
}
	

							
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
/**********************************************************/
switch ($_GET['idTipoProd']) {
   			
    
    /**********************************************************/
	//Arriendos
    case 1:
        /**********************************************************/
		//Variable de busqueda
		$z    = "WHERE bodegas_arriendos_facturacion_existencias.idExistencia!=0";
		if(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']!=''){      $z.=" AND bodegas_arriendos_facturacion.idTipo=".$_GET['idTipoMov'];}
		if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  $z.=" AND bodegas_arriendos_facturacion.idProveedor=".$_GET['idProveedor'];}
		if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $z.=" AND bodegas_arriendos_facturacion.idCliente=".$_GET['idCliente'];}
		if(isset($_GET['idEquipo'])&&$_GET['idEquipo']!=''){ $z.=" AND bodegas_arriendos_facturacion_existencias.idEquipo=".$_GET['idEquipo'];}
		if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
			$z.=" AND bodegas_arriendos_facturacion_existencias.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
		}
		/**********************************************************/
		$arrTipo = array();
		$query = "SELECT 
		bodegas_arriendos_facturacion_existencias.idFacturacion,
		proveedor_listado.Nombre AS Proveedor,
		clientes_listado.Nombre AS Cliente,
		equipos_arriendo_listado.Nombre AS Producto,
		core_documentos_mercantiles.Nombre AS Documento,
		bodegas_arriendos_facturacion_existencias.Valor,
		bodegas_arriendos_facturacion_existencias.Creacion_fecha,
		bodegas_arriendos_facturacion_existencias.N_Doc
		
		FROM `bodegas_arriendos_facturacion_existencias`
		LEFT JOIN `bodegas_arriendos_facturacion`   ON bodegas_arriendos_facturacion.idFacturacion  = bodegas_arriendos_facturacion_existencias.idFacturacion
		LEFT JOIN `proveedor_listado`               ON proveedor_listado.idProveedor                = bodegas_arriendos_facturacion.idProveedor
		LEFT JOIN `clientes_listado`                ON clientes_listado.idCliente                   = bodegas_arriendos_facturacion.idCliente
		LEFT JOIN `equipos_arriendo_listado`        ON equipos_arriendo_listado.idEquipo            = bodegas_arriendos_facturacion_existencias.idEquipo
		LEFT JOIN `core_documentos_mercantiles`     ON core_documentos_mercantiles.idDocumentos     = bodegas_arriendos_facturacion.idDocumentos
		".$z;
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		//Si ejecuto correctamente la consulta
		if(!$resultado){
			//Genero numero aleatorio
			$vardata = genera_password(8,'alfanumerico');
							
			//Guardo el error en una variable temporal
			
			
			
							
		}
		while ( $row = mysqli_fetch_assoc ($resultado)){
		array_push( $arrTipo,$row );
		}
        break;
    /**********************************************************/
	//Insumos
    case 2:
		/**********************************************************/
		//Variable de busqueda
		$z    = "WHERE bodegas_insumos_facturacion_existencias.idExistencia!=0";
		if(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']!=''){      $z.=" AND bodegas_insumos_facturacion.idTipo=".$_GET['idTipoMov'];}
		if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  $z.=" AND bodegas_insumos_facturacion.idProveedor=".$_GET['idProveedor'];}
		if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $z.=" AND bodegas_insumos_facturacion.idCliente=".$_GET['idCliente'];}
		if(isset($_GET['idInsumo'])&&$_GET['idInsumo']!=''){ $z.=" AND bodegas_insumos_facturacion_existencias.idProducto=".$_GET['idInsumo'];}
		if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
			$z.=" AND bodegas_insumos_facturacion_existencias.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
		}
		/**********************************************************/
		$arrTipo = array();
		$query = "SELECT
		bodegas_insumos_facturacion_existencias.idFacturacion, 
		proveedor_listado.Nombre AS Proveedor,
		clientes_listado.Nombre AS Cliente,
		insumos_listado.Nombre AS Producto,
		core_documentos_mercantiles.Nombre AS Documento,
		bodegas_insumos_facturacion_existencias.Valor,
		bodegas_insumos_facturacion_existencias.Creacion_fecha,
		bodegas_insumos_facturacion_existencias.N_Doc
		
		FROM `bodegas_insumos_facturacion_existencias`
		LEFT JOIN `bodegas_insumos_facturacion`     ON bodegas_insumos_facturacion.idFacturacion    = bodegas_insumos_facturacion_existencias.idFacturacion
		LEFT JOIN `proveedor_listado`               ON proveedor_listado.idProveedor                = bodegas_insumos_facturacion.idProveedor
		LEFT JOIN `clientes_listado`                ON clientes_listado.idCliente                   = bodegas_insumos_facturacion.idCliente
		LEFT JOIN `insumos_listado`                 ON insumos_listado.idProducto                   = bodegas_insumos_facturacion_existencias.idProducto
		LEFT JOIN `core_documentos_mercantiles`     ON core_documentos_mercantiles.idDocumentos     = bodegas_insumos_facturacion.idDocumentos
		".$z;
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		//Si ejecuto correctamente la consulta
		if(!$resultado){
			//Genero numero aleatorio
			$vardata = genera_password(8,'alfanumerico');
							
			//Guardo el error en una variable temporal
			
			
			
							
		}
		while ( $row = mysqli_fetch_assoc ($resultado)){
		array_push( $arrTipo,$row );
		}
        break;
    /**********************************************************/
	//Productos
    case 3:
		/**********************************************************/
		//Variable de busqueda
		$z    = "WHERE bodegas_productos_facturacion_existencias.idExistencia!=0";
		if(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']!=''){      $z.=" AND bodegas_productos_facturacion.idTipo=".$_GET['idTipoMov'];}
		if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  $z.=" AND bodegas_productos_facturacion.idProveedor=".$_GET['idProveedor'];}
		if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $z.=" AND bodegas_productos_facturacion.idCliente=".$_GET['idCliente'];}
		if(isset($_GET['idProducto'])&&$_GET['idProducto']!=''){    $z.=" AND bodegas_productos_facturacion_existencias.idProducto=".$_GET['idProducto'];}
		if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
			$z.=" AND bodegas_productos_facturacion_existencias.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
		}
		/**********************************************************/
		$arrTipo = array();
		$query = "SELECT 
		bodegas_productos_facturacion_existencias.idFacturacion,
		proveedor_listado.Nombre AS Proveedor,
		clientes_listado.Nombre AS Cliente,
		productos_listado.Nombre AS Producto,
		core_documentos_mercantiles.Nombre AS Documento,
		bodegas_productos_facturacion_existencias.Valor,
		bodegas_productos_facturacion_existencias.Creacion_fecha,
		bodegas_productos_facturacion_existencias.N_Doc
		
		FROM `bodegas_productos_facturacion_existencias`
		LEFT JOIN `bodegas_productos_facturacion`     ON bodegas_productos_facturacion.idFacturacion    = bodegas_productos_facturacion_existencias.idFacturacion
		LEFT JOIN `proveedor_listado`                 ON proveedor_listado.idProveedor                  = bodegas_productos_facturacion.idProveedor
		LEFT JOIN `clientes_listado`                  ON clientes_listado.idCliente                     = bodegas_productos_facturacion.idCliente
		LEFT JOIN `productos_listado`                 ON productos_listado.idProducto                   = bodegas_productos_facturacion_existencias.idProducto
		LEFT JOIN `core_documentos_mercantiles`       ON core_documentos_mercantiles.idDocumentos       = bodegas_productos_facturacion.idDocumentos
		".$z;
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		//Si ejecuto correctamente la consulta
		if(!$resultado){
			//Genero numero aleatorio
			$vardata = genera_password(8,'alfanumerico');
							
			//Guardo el error en una variable temporal
			
			
			
							
		}
		while ( $row = mysqli_fetch_assoc ($resultado)){
		array_push( $arrTipo,$row );
		}
        break;
    /**********************************************************/
	//Servicios
    case 4:
		/**********************************************************/
		//Variable de busqueda
		$z    = "WHERE bodegas_servicios_facturacion_existencias.idExistencia!=0";
		if(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']!=''){      $z.=" AND bodegas_servicios_facturacion.idTipo=".$_GET['idTipoMov'];}
		if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  $z.=" AND bodegas_servicios_facturacion.idProveedor=".$_GET['idProveedor'];}
		if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $z.=" AND bodegas_servicios_facturacion.idCliente=".$_GET['idCliente'];}
		if(isset($_GET['idServicio'])&&$_GET['idServicio']!=''){    $z.=" AND bodegas_servicios_facturacion_existencias.idServicio=".$_GET['idServicio'];}
		if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
			$z.=" AND bodegas_servicios_facturacion_existencias.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
		}
		/**********************************************************/
		$arrTipo = array();
		$query = "SELECT 
		bodegas_servicios_facturacion_existencias.idFacturacion,
		proveedor_listado.Nombre AS Proveedor,
		clientes_listado.Nombre AS Cliente,
		servicios_listado.Nombre AS Producto,
		core_documentos_mercantiles.Nombre AS Documento,
		bodegas_servicios_facturacion_existencias.Valor,
		bodegas_servicios_facturacion_existencias.Creacion_fecha,
		bodegas_servicios_facturacion_existencias.N_Doc
		
		FROM `bodegas_servicios_facturacion_existencias`
		LEFT JOIN `bodegas_servicios_facturacion`     ON bodegas_servicios_facturacion.idFacturacion    = bodegas_servicios_facturacion_existencias.idFacturacion
		LEFT JOIN `proveedor_listado`                 ON proveedor_listado.idProveedor                  = bodegas_servicios_facturacion.idProveedor
		LEFT JOIN `clientes_listado`                  ON clientes_listado.idCliente                     = bodegas_servicios_facturacion.idCliente
		LEFT JOIN `servicios_listado`                 ON servicios_listado.idServicio                   = bodegas_servicios_facturacion_existencias.idServicio
		LEFT JOIN `core_documentos_mercantiles`       ON core_documentos_mercantiles.idDocumentos       = bodegas_servicios_facturacion.idDocumentos
		".$z;
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		//Si ejecuto correctamente la consulta
		if(!$resultado){
			//Genero numero aleatorio
			$vardata = genera_password(8,'alfanumerico');
							
			//Guardo el error en una variable temporal
			
			
			
							
		}
		while ( $row = mysqli_fetch_assoc ($resultado)){
		array_push( $arrTipo,$row );
		}
        break;
}


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Productos</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<?php
								if(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']==1){
									echo 'Proveedor';
								}elseif(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']==2){
									echo 'Cliente';
								}
							?>
						</th>
						<th>Documento</th>
						<th>Fecha Doc</th>
						<th>Producto</th>
						<th>Valor</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrTipo as $prod) { ?>
					<tr class="odd">
						<td>
							<?php
								if(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']==1){
									echo $prod['Proveedor'];
								}elseif(isset($_GET['idTipoMov'])&&$_GET['idTipoMov']==2){
									echo $prod['Cliente'];
								}
							?>
						</td>
						<td><?php echo $prod['Documento'].' '.$prod['N_Doc']; ?></td>
						<td><?php echo fecha_estandar($prod['Creacion_fecha']); ?></td>
						<td><?php echo $prod['Producto']; ?></td>
						<td align="right"><?php echo valores($prod['Valor'], 0); ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php
								switch ($_GET['idTipoProd']) {
									case 1://Arriendos
										echo '<a href="view_mov_arriendos.php?view='.simpleEncode($prod['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
									case 2://Insumos
										echo '<a href="view_mov_insumos.php?view='.simpleEncode($prod['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
									case 3://Productos
										echo '<a href="view_mov_productos.php?view='.simpleEncode($prod['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
									case 4://Servicios
										echo '<a href="view_mov_servicios.php?view='.simpleEncode($prod['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
								}
								?>
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
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

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
				if(isset($idTipoMov)){      $x1  = $idTipoMov;     }else{$x1  = '';}
				if(isset($idProveedor)){    $x2  = $idProveedor;   }else{$x2  = '';}
				if(isset($idCliente)){      $x3  = $idCliente;     }else{$x3  = '';}
				if(isset($idTipoProd)){     $x4  = $idTipoProd;    }else{$x4  = '';}
				if(isset($idEquipo)){       $x5  = $idEquipo;      }else{$x5  = '';}
				if(isset($idInsumo)){       $x6  = $idInsumo;      }else{$x6  = '';}
				if(isset($idProducto)){     $x7  = $idProducto;    }else{$x7  = '';}
				if(isset($idServicio)){     $x8  = $idServicio;    }else{$x8  = '';}
				if(isset($f_inicio)){       $x9  = $f_inicio;      }else{$x9  = '';}
				if(isset($f_termino)){      $x10 = $f_termino;     }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo Movimiento','idTipoMov', $x1, 2, 'idTipoMov', 'Nombre', 'core_bodega_tipomov', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x2, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Cliente','idCliente', $x3, 1, 'idCliente', 'Nombre', 'clientes_listado', $z, '', $dbConn);

				$Form_Inputs->form_select('Tipo Producto','idTipoProd', $x4, 2, 'idTipoProd', 'Nombre', 'core_bodega_tipoprod', 0, '', $dbConn);
				$Form_Inputs->form_select('Equipos','idEquipo', $x5, 1, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 'idEstado=1', '', $dbConn);
				$Form_Inputs->form_select('Insumo','idInsumo', $x6, 1, 'idProducto', 'Nombre', 'insumos_listado', $zx2, '', $dbConn);
				$Form_Inputs->form_select('Producto','idProducto', $x7, 1, 'idProducto', 'Nombre', 'productos_listado', $zx1, '', $dbConn);
				$Form_Inputs->form_select('Servicio','idServicio', $x8, 1, 'idServicio', 'Nombre', 'servicios_listado', 'idEstado=1', '', $dbConn);

				$Form_Inputs->form_date('Fecha Mov Desde','f_inicio', $x9, 1);
				$Form_Inputs->form_date('Fecha Mov Hasta','f_termino', $x10, 1);

				?>

				<script>
					document.getElementById('div_idProveedor').style.display = 'none';
					document.getElementById('div_idCliente').style.display = 'none';
					document.getElementById('div_idEquipo').style.display = 'none';
					document.getElementById('div_idInsumo').style.display = 'none';
					document.getElementById('div_idProducto').style.display = 'none';
					document.getElementById('div_idServicio').style.display = 'none';

					$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)
						
						$("#idTipoMov").on("change", function(){ //se ejecuta al cambiar valor del select
							let tipo_val = $("#idTipoMov").val();//Asignamos el valor seleccionado
								
							//Proveedores
							if(tipo_val == 1){
								document.getElementById('div_idProveedor').style.display = '';
								document.getElementById('div_idCliente').style.display = 'none';
							//Clientes	
							} else if(tipo_val == 2){
								document.getElementById('div_idProveedor').style.display = 'none';
								document.getElementById('div_idCliente').style.display = '';
							} else {
								document.getElementById('div_idProveedor').style.display = 'none';
								document.getElementById('div_idCliente').style.display = 'none';
							}

						});

						$("#idTipoProd").on("change", function(){ //se ejecuta al cambiar valor del select
							tipo_val= $("#idTipoProd").val();//Asignamos el valor seleccionado
								
							//Arriendos
							if(tipo_val == 1){
								document.getElementById('div_idEquipo').style.display = '';
								document.getElementById('div_idInsumo').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_idServicio').style.display = 'none';
								
								document.getElementById('idEquipo').required = 'true';
								document.getElementById('idInsumo').required = 'false';
								document.getElementById('idProducto').required = 'false';
								document.getElementById('idServicio').required = 'false';
							//Insumos	
							} else if(tipo_val == 2){
								document.getElementById('div_idEquipo').style.display = 'none';
								document.getElementById('div_idInsumo').style.display = '';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_idServicio').style.display = 'none';
								
								document.getElementById('idEquipo').required = 'false';
								document.getElementById('idInsumo').required = 'true';
								document.getElementById('idProducto').required = 'false';
								document.getElementById('idServicio').required = 'false';
							//Productos	
							} else if(tipo_val == 3){
								document.getElementById('div_idEquipo').style.display = 'none';
								document.getElementById('div_idInsumo').style.display = 'none';
								document.getElementById('div_idProducto').style.display = '';
								document.getElementById('div_idServicio').style.display = 'none';
								
								document.getElementById('idEquipo').required = 'false';
								document.getElementById('idInsumo').required = 'false';
								document.getElementById('idProducto').required = 'true';
								document.getElementById('idServicio').required = 'false';
							//Servicios	
							} else if(tipo_val == 4){
								document.getElementById('div_idEquipo').style.display = 'none';
								document.getElementById('div_idInsumo').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_idServicio').style.display = '';
								
								document.getElementById('idEquipo').required = 'false';
								document.getElementById('idInsumo').required = 'false';
								document.getElementById('idProducto').required = 'false';
								document.getElementById('idServicio').required = 'true';
							//Otros
							} else {
								document.getElementById('div_idEquipo').style.display = 'none';
								document.getElementById('div_idInsumo').style.display = 'none';
								document.getElementById('div_idProducto').style.display = 'none';
								document.getElementById('div_idServicio').style.display = 'none';
								
								document.getElementById('idEquipo').required = 'false';
								document.getElementById('idInsumo').required = 'false';
								document.getElementById('idProducto').required = 'false';
								document.getElementById('idServicio').required = 'false';
							}

						});
					});
						
				</script>

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
