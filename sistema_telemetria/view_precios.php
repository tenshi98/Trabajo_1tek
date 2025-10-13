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
$X_type = simpleDecode($_GET['type'], fecha_actual());
/**************************************************************/
$arrProducto = array();

//Filtro el tipo de documento
switch ($X_type) {
    /********************************************************/
    //Producto
    case 1:
        // Se trae un listado de los valores
		$SIS_query = '
		bodegas_productos_facturacion_existencias.Valor AS Precio,
		bodegas_productos_facturacion_existencias.Creacion_fecha,
		productos_listado.Nombre AS Producto,
		proveedor_listado.Nombre AS Proveedor';
		$SIS_join  = '
		LEFT JOIN bodegas_productos_facturacion    ON bodegas_productos_facturacion.idFacturacion    = bodegas_productos_facturacion_existencias.idFacturacion
		LEFT JOIN productos_listado                ON productos_listado.idProducto                   = bodegas_productos_facturacion_existencias.idProducto
		LEFT JOIN proveedor_listado                ON proveedor_listado.idProveedor                  = bodegas_productos_facturacion_existencias.idProveedor';
		$SIS_where = 'bodegas_productos_facturacion_existencias.idProducto='.$X_Puntero.' AND bodegas_productos_facturacion.idTipo = 1';
		$SIS_order = 'bodegas_productos_facturacion_existencias.Creacion_fecha DESC LIMIT 40';
		$arrProducto = array();
		$arrProducto = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProducto');
		
    break;
    /********************************************************/
    //Insumo
    case 2:
        // Se trae un listado de los valores
		$SIS_query = '
		bodegas_insumos_facturacion_existencias.Valor AS Precio,
		bodegas_insumos_facturacion_existencias.Creacion_fecha,
		insumos_listado.Nombre AS Producto,
		proveedor_listado.Nombre AS Proveedor';
		$SIS_join  = '
		LEFT JOIN bodegas_insumos_facturacion      ON bodegas_insumos_facturacion.idFacturacion      = bodegas_insumos_facturacion_existencias.idFacturacion
		LEFT JOIN insumos_listado                  ON insumos_listado.idProducto                     = bodegas_insumos_facturacion_existencias.idProducto
		LEFT JOIN proveedor_listado                ON proveedor_listado.idProveedor                  = bodegas_insumos_facturacion_existencias.idProveedor';
		$SIS_where = 'bodegas_insumos_facturacion_existencias.idProducto='.$X_Puntero.' AND bodegas_insumos_facturacion.idTipo = 1';
		$SIS_order = 'bodegas_insumos_facturacion_existencias.Creacion_fecha DESC LIMIT 40';
		$arrProducto = array();
		$arrProducto = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProducto');
		
    break;
    /********************************************************/
    //Arriendo
    case 3:
        // Se trae un listado de los valores
		$SIS_query = '
		bodegas_arriendos_facturacion_existencias.ValorTotal AS Precio,
		bodegas_arriendos_facturacion_existencias.Creacion_fecha,
		equipos_arriendo_listado.Nombre AS Producto,
		proveedor_listado.Nombre AS Proveedor';
		$SIS_join  = '
		LEFT JOIN bodegas_arriendos_facturacion    ON bodegas_arriendos_facturacion.idFacturacion    = bodegas_arriendos_facturacion_existencias.idFacturacion
		LEFT JOIN equipos_arriendo_listado         ON equipos_arriendo_listado.idEquipo              = bodegas_arriendos_facturacion_existencias.idEquipo
		LEFT JOIN proveedor_listado                ON proveedor_listado.idProveedor                  = bodegas_arriendos_facturacion_existencias.idProveedor';
		$SIS_where = 'bodegas_arriendos_facturacion_existencias.idEquipo='.$X_Puntero.' AND bodegas_arriendos_facturacion.idTipo = 1';
		$SIS_order = 'bodegas_arriendos_facturacion_existencias.Creacion_fecha DESC LIMIT 40';
		$arrProducto = array();
		$arrProducto = db_select_array (false, $SIS_query, 'bodegas_arriendos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProducto');
		
    break;
    /********************************************************/
    //Servicios
    case 4:
        // Se trae un listado de los valores
		$SIS_query = '
		bodegas_servicios_facturacion_existencias.ValorTotal AS Precio,
		bodegas_servicios_facturacion_existencias.Creacion_fecha,
		servicios_listado.Nombre AS Producto,
		proveedor_listado.Nombre AS Proveedor';
		$SIS_join  = '
		LEFT JOIN bodegas_servicios_facturacion    ON bodegas_servicios_facturacion.idFacturacion    = bodegas_servicios_facturacion_existencias.idFacturacion
		LEFT JOIN servicios_listado                ON servicios_listado.idServicio                   = bodegas_servicios_facturacion_existencias.idServicio
		LEFT JOIN proveedor_listado                ON proveedor_listado.idProveedor                  = bodegas_servicios_facturacion_existencias.idProveedor';
		$SIS_where = 'bodegas_servicios_facturacion_existencias.idServicio='.$X_Puntero.' AND bodegas_servicios_facturacion.idTipo = 1';
		$SIS_order = 'bodegas_servicios_facturacion_existencias.Creacion_fecha DESC LIMIT 40';
		$arrProducto = array();
		$arrProducto = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProducto');
		
    break;
}
///////////////////////////////////////////////
if($arrProducto!=false && !empty($arrProducto) && $arrProducto!=''){ ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Variacion Precios de <?php echo $arrProducto[0]['Producto']; ?></h5>
			</header>
			<div class="tab-content">

					<div class="wmd-panel">
						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

						<div class="table-responsive">		
							<script>
								google.charts.load('current', {'packages':['corechart']});
								google.charts.setOnLoadCallback(drawChart);

								function drawChart() {
									var data = new google.visualization.DataTable();
									data.addColumn('string', 'Fecha'); 
									data.addColumn('number', 'Valor');
									data.addColumn({type: 'string', role: 'annotation'});
											
									data.addRows([
									<?php 
										foreach ($arrProducto as $prod) {
											$chain  = "'".Fecha_estandar($prod['Creacion_fecha'])."'";
											$chain .= ", ".$prod['Precio'];
											$chain .= ",'".valores($prod['Precio'], 0)."'";
													
											echo '['.$chain.'],';
										}
									?>
									]);

									var options = {
										title: 'Variacion de precios',
										width: 900,
										height: 500,
												
										hAxis: { 
											title: 'Fecha',
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
										colors: ['#FFB347']
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
										<th width="120">Fecha</th>
										<th>Proveedor</th>
										<th width="120">Valor</th>
									</tr>
								</thead>
			  
								<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrProducto as $prod) { ?>

									<tr class="odd">
										<td><?php echo Fecha_estandar($prod['Creacion_fecha']); ?></td>
										<td><?php echo $prod['Proveedor']; ?></td>
										<td align="right"><?php echo valores($prod['Precio'], 0); ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>

			</div>
		</div>
	</div>

<?php }else{
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">';
		$Alert_Text  = 'No existen datos';
		alert_post_data(4,1,1,0, $Alert_Text);
	echo '</div>';
} ?>
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
