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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
// consulto los datos
$SIS_query = '
cotizacion_listado.Creacion_fecha,
cotizacion_listado.Observaciones,
cotizacion_listado.ValorNetoImp,
cotizacion_listado.Impuesto_01,
cotizacion_listado.Impuesto_02,
cotizacion_listado.Impuesto_03,
cotizacion_listado.Impuesto_04,
cotizacion_listado.Impuesto_05,
cotizacion_listado.Impuesto_06,
cotizacion_listado.Impuesto_07,
cotizacion_listado.Impuesto_08,
cotizacion_listado.Impuesto_09,
cotizacion_listado.Impuesto_10,
cotizacion_listado.ValorTotal,

usuarios_listado.Nombre AS NombreUsuario,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

clientes_listado.Nombre AS NombreProveedor,
clientes_listado.email AS EmailProveedor,
clientes_listado.Rut AS RutProveedor,
clientciudad.Nombre AS CiudadProveedor,
clientcomuna.Nombre AS ComunaProveedor,
clientes_listado.Direccion AS DireccionProveedor,
clientes_listado.Fono1 AS Fono1Proveedor,
clientes_listado.Fono2 AS Fono2Proveedor,
clientes_listado.Fax AS FaxProveedor,
clientes_listado.PersonaContacto AS PersonaContactoProveedor,
clientes_listado.Giro AS GiroProveedor,

cotizacion_listado.idSistema';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario       = cotizacion_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema         = cotizacion_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad           = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna           = sistema_origen.idComuna
LEFT JOIN `clientes_listado`                        ON clientes_listado.idCliente       = cotizacion_listado.idCliente
LEFT JOIN `core_ubicacion_ciudad`    clientciudad   ON clientciudad.idCiudad            = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   clientcomuna   ON clientcomuna.idComuna            = clientes_listado.idComuna';
$SIS_where = 'cotizacion_listado.idCotizacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cotizacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se consulta
$SIS_query = '
insumos_listado.Nombre,
cotizacion_listado_existencias_insumos.Cantidad,
cotizacion_listado_existencias_insumos.vUnitario,
cotizacion_listado_existencias_insumos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`        ON insumos_listado.idProducto    = cotizacion_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'cotizacion_listado_existencias_insumos.idCotizacion ='.$X_Puntero;
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

/*****************************************/
// Se consulta
$SIS_query = '
productos_listado.Nombre,
cotizacion_listado_existencias_productos.Cantidad,
cotizacion_listado_existencias_productos.vUnitario,
cotizacion_listado_existencias_productos.vTotal,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `productos_listado`     ON productos_listado.idProducto  = cotizacion_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml   = productos_listado.idUml';
$SIS_where = 'cotizacion_listado_existencias_productos.idCotizacion ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
// Se consulta
$SIS_query = '
equipos_arriendo_listado.Nombre,
cotizacion_listado_existencias_arriendos.Cantidad,
cotizacion_listado_existencias_arriendos.vUnitario,
cotizacion_listado_existencias_arriendos.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `equipos_arriendo_listado`    ON equipos_arriendo_listado.idEquipo     = cotizacion_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_tiempo_frecuencia`      ON core_tiempo_frecuencia.idFrecuencia   = cotizacion_listado_existencias_arriendos.idFrecuencia';
$SIS_where = 'cotizacion_listado_existencias_arriendos.idCotizacion ='.$X_Puntero;
$SIS_order = 'equipos_arriendo_listado.Nombre ASC';
$arrArriendos = array();
$arrArriendos = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_arriendos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArriendos');

/*****************************************/
// Se consulta
$SIS_query = '
servicios_listado.Nombre,
cotizacion_listado_existencias_servicios.Cantidad,
cotizacion_listado_existencias_servicios.vUnitario,
cotizacion_listado_existencias_servicios.vTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `servicios_listado`       ON servicios_listado.idServicio          = cotizacion_listado_existencias_servicios.idServicio
LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia   = cotizacion_listado_existencias_servicios.idFrecuencia';
$SIS_where = 'cotizacion_listado_existencias_servicios.idCotizacion ='.$X_Puntero;
$SIS_order = 'servicios_listado.Nombre ASC';
$arrServicios = array();
$arrServicios = db_select_array (false, $SIS_query, 'cotizacion_listado_existencias_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrServicios');

/*****************************************/
// Se consulta
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idCotizacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'cotizacion_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

/*****************************************/
// Se consulta
$SIS_query = 'Nombre,Porcentaje';
$SIS_join  = '';
$SIS_where = 'Porcentaje!=0';
$SIS_order = 'idImpuesto ASC';
$arrImpuestos = array();
$arrImpuestos = db_select_array (false, $SIS_query, 'sistema_impuestos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrImpuestos');

/*****************************************/
//Recorro y guard el nombre de los impuestos 
$nn = 0;
$impuestos = array();
foreach ($arrImpuestos as $impto) {
	$impuestos[$nn]['nimp'] = $impto['Nombre'].' ('.Cantidades_decimales_justos($impto['Porcentaje']).'%)';
	$nn++;
}

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Cotizacion <?php echo n_doc($X_Puntero, 5); ?>.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Empresa Emisora
			<address>
				<strong><?php echo $rowData['SistemaOrigen']; ?></strong><br/>
				<?php echo $rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna']; ?><br/>
				<?php echo $rowData['SistemaOrigenDireccion']; ?><br/>
				Fono: <?php echo formatPhone($rowData['SistemaOrigenFono']); ?><br/>
				Rut: <?php echo $rowData['SistemaOrigenRut']; ?><br/>
				Email: <?php echo $rowData['SistemaOrigenEmail']; ?>
			</address>
		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Empresa Receptora
			<address>
				<strong><?php echo $rowData['NombreProveedor']; ?></strong><br/>
				<?php echo $rowData['CiudadProveedor'].', '.$rowData['ComunaProveedor']; ?><br/>
				<?php echo $rowData['DireccionProveedor']; ?><br/>
				Fono Fijo: <?php echo formatPhone($rowData['Fono1Proveedor']); ?><br/>
				Celular: <?php echo formatPhone($rowData['Fono2Proveedor']); ?><br/>
				Fax: <?php echo $rowData['FaxProveedor']; ?><br/>
				Rut: <?php echo $rowData['RutProveedor']; ?><br/>
				Email: <?php echo $rowData['EmailProveedor']; ?><br/>
				Contacto: <?php echo $rowData['PersonaContactoProveedor']; ?><br/>
				Giro de la Empresa: <?php echo $rowData['GiroProveedor']; ?>
			</address>
		</div>
			   
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Vendedor: <?php echo $rowData['NombreUsuario']; ?><br/>
		</div>

	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive"  style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Detalle</th>
						<th align="right" width="160">Cantidad</th>
						<th align="right" width="160">Valor Unitario</th>
						<th align="right" width="160">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrInsumos!=false && !empty($arrInsumos) && $arrInsumos!='') { ?>
						<tr class="active"><td colspan="4"><strong>Insumos</strong></td></tr>
						<?php foreach ($arrInsumos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') { ?>
						<tr class="active"><td colspan="4"><strong>Productos</strong></td></tr>
						<?php foreach ($arrProductos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Unidad']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrArriendos!=false && !empty($arrArriendos) && $arrArriendos!='') { ?>
						<tr class="active"><td colspan="4"><strong>Arriendos</strong></td></tr>
						<?php foreach ($arrArriendos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrServicios!=false && !empty($arrServicios) && $arrServicios!='') { ?>
						<tr class="active"><td colspan="4"><strong>Servicios</strong></td></tr>
						<?php foreach ($arrServicios as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vUnitario'], 0).' x '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo valores($prod['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
			<table class="table">
				<tbody>
					<?php if(isset($rowData['ValorNetoImp'])&&$rowData['ValorNetoImp']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Neto Imponible</strong></td>
							<td width="160" align="right"><?php echo Valores($rowData['ValorNetoImp'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_01'])&&$rowData['Impuesto_01']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[0]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_01'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_02'])&&$rowData['Impuesto_02']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[1]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_02'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_03'])&&$rowData['Impuesto_03']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[2]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_03'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_04'])&&$rowData['Impuesto_04']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[3]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_04'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_05'])&&$rowData['Impuesto_05']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[4]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_05'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_06'])&&$rowData['Impuesto_06']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[5]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_06'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_07'])&&$rowData['Impuesto_07']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[6]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_07'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_08'])&&$rowData['Impuesto_08']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[7]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_08'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_09'])&&$rowData['Impuesto_09']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[8]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_09'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_10'])&&$rowData['Impuesto_10']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[9]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_10'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['ValorTotal'])&&$rowData['ValorTotal']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Total</strong></td>
							<td align="right"><?php echo Valores($rowData['ValorTotal'], 0); ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Condiciones Comerciales:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
		</div>
	</div>

</section>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">
	
    <table id="items">
        <tbody>
			<tr><th colspan="6">Archivos Adjuntos</th></tr>		  
			<?php
			if ($arrArchivo!=false && !empty($arrArchivo) && $arrArchivo!=''){
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrArchivo as $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="1download.php?dir=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip" ><i class="fa fa-download" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				 <?php 	
				}
			} ?>
		</tbody>
    </table>
</div>

<div class="col-xs-12" style="margin-bottom:30px">
	<a target="new" href="view_cotizacion_to_print.php?view=<?php echo $_GET['view'] ?>" class="btn btn-default pull-right" style="margin-right: 5px;">
		<i class="fa fa-print" aria-hidden="true"></i> Imprimir
	</a>
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>
 

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
