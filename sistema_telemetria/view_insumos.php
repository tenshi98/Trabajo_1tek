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
insumos_listado.Nombre,
insumos_listado.Descripcion,
insumos_listado.Marca,
insumos_listado.Codigo,
insumos_listado.StockLimite,
insumos_listado.ValorIngreso,
insumos_listado.ValorEgreso,
insumos_listado.Direccion_img,
insumos_listado.idTipoImagen,
sistema_productos_categorias.Nombre AS Categoria,
sistema_productos_uml.Nombre AS Unidad,
insumos_listado.FichaTecnica,
insumos_listado.HDS,
core_estados.Nombre AS Estado,
proveedor_listado.Nombre AS ProveedorFijo';
$SIS_join  = '
LEFT JOIN `sistema_productos_categorias`     ON sistema_productos_categorias.idCategoria         = insumos_listado.idCategoria
LEFT JOIN `sistema_productos_uml`            ON sistema_productos_uml.idUml                      = insumos_listado.idUml
LEFT JOIN `core_estados`                     ON core_estados.idEstado                            = insumos_listado.idEstado
LEFT JOIN `proveedor_listado`                ON proveedor_listado.idProveedor                    = insumos_listado.idProveedorFijo';
$SIS_where = 'insumos_listado.idProducto ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'insumos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

// Se trae un listado con todos los elementos
$SIS_query = '
bodegas_insumos_facturacion_existencias.Creacion_fecha,
bodegas_insumos_facturacion_existencias.Cantidad_ing,
bodegas_insumos_facturacion_existencias.Cantidad_eg,
bodegas_insumos_facturacion_existencias.idFacturacion,
bodegas_insumos_facturacion_tipo.Nombre AS TipoMovimiento,
insumos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS UnidadMedida,
bodegas_insumos_listado.Nombre AS NombreBodega';
$SIS_join  = '
LEFT JOIN `bodegas_insumos_facturacion_tipo`    ON bodegas_insumos_facturacion_tipo.idTipo   = bodegas_insumos_facturacion_existencias.idTipo
LEFT JOIN `insumos_listado`                     ON insumos_listado.idProducto                = bodegas_insumos_facturacion_existencias.idProducto
LEFT JOIN `sistema_productos_uml`               ON sistema_productos_uml.idUml               = insumos_listado.idUml
LEFT JOIN `bodegas_insumos_listado`             ON bodegas_insumos_listado.idBodega          = bodegas_insumos_facturacion_existencias.idBodega';
$SIS_where = 'bodegas_insumos_facturacion_existencias.idProducto='.$X_Puntero.' AND bodegas_insumos_facturacion_existencias.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'bodegas_insumos_facturacion_existencias.Creacion_fecha DESC LIMIT 20';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

// Se trae un listado de los valores
$SIS_query = '
bodegas_insumos_facturacion.idTipo,
AVG(NULLIF(IF(bodegas_insumos_facturacion_existencias.Valor!=0,bodegas_insumos_facturacion_existencias.Valor,0),0)) AS Precio,
bodegas_insumos_facturacion_existencias.Creacion_mes';
$SIS_join  = 'LEFT JOIN bodegas_insumos_facturacion on bodegas_insumos_facturacion.idFacturacion = bodegas_insumos_facturacion_existencias.idFacturacion';
$SIS_where = 'bodegas_insumos_facturacion_existencias.idProducto='.$X_Puntero.' AND bodegas_insumos_facturacion_existencias.Creacion_fecha>"'.restarDias(fecha_actual(),360).'" AND (bodegas_insumos_facturacion.idTipo = 1 OR bodegas_insumos_facturacion.idTipo = 2) GROUP BY bodegas_insumos_facturacion.idTipo, bodegas_insumos_facturacion_existencias.Creacion_mes';
$SIS_order = 'bodegas_insumos_facturacion_existencias.Creacion_fecha ASC';
$arrPromedioProd = array();
$arrPromedioProd = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPromedioProd');

//Se crea el arreglo
$arreglo = array();
for ($i = 1; $i <= 12; $i++) {
	$arreglo[$i]['compra'] = 0;
	$arreglo[$i]['venta'] = 0;
}
foreach ($arrPromedioProd as $productos) {
	//Se verifican las compras
	if(isset($productos['idTipo'])&&$productos['idTipo']==1){
		$arreglo[$productos['Creacion_mes']]['compra'] = $productos['Precio'];
	}
	//Se verifican las ventas
	if(isset($productos['idTipo'])&&$productos['idTipo']==2){
		$arreglo[$productos['Creacion_mes']]['venta']  = $productos['Precio'];
	}
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Insumo <?php echo $rowData['Nombre']; ?></h5>
			<div class="toolbar"> </div>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="#movimientos" data-toggle="tab"><i class="fa fa-exchange" aria-hidden="true"></i> Movimientos</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/productos.jpg">
						<?php }else{
							echo widget_TipoImagen($rowData['idTipoImagen'], DB_SITE_REPO, DB_SITE_MAIN_PATH, 'upload', $rowData['Direccion_img']);
						} ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Producto</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Marca : </strong><?php echo $rowData['Marca']; ?><br/>
							<strong>Codigo : </strong><?php echo $rowData['Codigo']; ?><br/>
							<strong>Categoria : </strong><?php echo $rowData['Categoria']; ?><br/>
							<strong>Unidad de medida : </strong><?php echo $rowData['Unidad']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Descripción</h2>
						<p class="text-muted"><?php echo $rowData['Descripcion']; ?></p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Comerciales</h2>
						<p class="text-muted">
							<strong>Proveedor predefinido : </strong><?php echo $rowData['ProveedorFijo']; ?><br/>
							<strong>Stock Minimo : </strong><?php echo Cantidades_decimales_justos($rowData['StockLimite']).' '.$rowData['Unidad']; ?><br/>
							<strong>Valor promedio Ingreso : </strong><?php echo Valores(Cantidades_decimales_justos($rowData['ValorIngreso']), 0); ?><br/>
							<strong>Valor promedio Egreso : </strong><?php echo Valores(Cantidades_decimales_justos($rowData['ValorEgreso']), 0); ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<p class="text-muted">
							<?php
							//Ficha Tecnica
							if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['FichaTecnica'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Ficha Tecnica</a>';
							}
							//Hoja de seguridad
							if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['HDS'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Hoja de Seguridad</a>';
							}
							?>
						</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			

			
			<div class="tab-pane fade" id="movimientos">
				<div class="wmd-panel">
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

					<div class="table-responsive">		
						<script>
							google.charts.load('current', {'packages':['corechart']});
							google.charts.setOnLoadCallback(drawChart);

							function drawChart() {
								var data = new google.visualization.DataTable();
								data.addColumn('string', 'Fecha'); 
								data.addColumn('number', 'Compra');
								data.addColumn({type: 'string', role: 'annotation'});
								data.addColumn('number', 'Venta'); 
								data.addColumn({type: 'string', role: 'annotation'});
										
								data.addRows([
								<?php 
									//obtengo el mes actual
									$xmes = mes_actual();
									//lop de 12 vueltas
									for ($xcontador = 1; $xcontador < 12; $xcontador++) {
										$chain  = "'".numero_a_mes_corto($xmes)."'";
										$chain .= ", ".$arreglo[$xmes]['compra'];
										$chain .= ",'".Cantidades_decimales_justos($arreglo[$xmes]['compra'])."'";
										$chain .= ", ".$arreglo[$xmes]['venta'];
										$chain .= ",'".Cantidades_decimales_justos($arreglo[$xmes]['venta'])."'";
												
										echo '['.$chain.'],';
												
										$xmes++;
										if($xmes==13){$xmes=1;}
									}
								?>
								]);

								var options = {
									title: 'Promedio variacion de precios',
									width: 900,
									height: 500,
											
									hAxis: { 
										title: 'Meses',
									},
									vAxis: { title: 'Valor' },
									curveType: 'function',
									//puntos dentro de las curvas
									series: {
										0: {
											pointsVisible: true
										},
												 
									},
							
									annotations: {
												  alwaysOutside: true,
												  textStyle: {
													fontSize: 14,
													color: '#000',
													auraColor: 'none'
												  }
												},
									colors: ['#FFB347','#C23B22']
								};

								var chart = new google.visualization.LineChart(document.getElementById('curve_chart1'));

								chart.draw(data, options);
							}

						</script>
						<div id="curve_chart1" style="height: 500px"></div>
											
					</div>

					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Movimiento</th>
									<th>Bodega</th>
									<th>Fecha</th>
									<th>Cant Ing</th>
									<th>Cant eg</th>
								</tr>
							</thead>
		  
							<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrProductos as $productos) { ?>

								<tr class="odd">
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="<?php echo 'view_mov_insumos.php?view='.simpleEncode($productos['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
										<?php echo $productos['TipoMovimiento']; ?>
									</td>
									<td><?php echo $productos['NombreBodega']; ?></td>
									<td><?php echo Fecha_estandar($productos['Creacion_fecha']); ?></td>
									<td><?php echo Cantidades_decimales_justos($productos['Cantidad_ing']).' '.$productos['UnidadMedida']; ?></td>
									<td><?php echo Cantidades_decimales_justos($productos['Cantidad_eg']).' '.$productos['UnidadMedida']; ?></td>
						
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			
        </div>
	</div>
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
