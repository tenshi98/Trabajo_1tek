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
$original = "informe_bodega_insumos_07.php";
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
	/*******************************************************/
	//Variables
	$ano_pasado = ano_actual()-1;
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	$SIS_join  = '';
	$SIS_where = 'idBodega='.$_GET['idBodegaOrigen'];
	$rowBodega = db_select_data (false, $SIS_query, 'bodegas_insumos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowBodega');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idCategoria, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'Nombre ASC';
	$arrCategoria = array();
	$arrCategoria = db_select_array (false, $SIS_query, 'sistema_productos_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategoria');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idBodega, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'Nombre ASC';
	$arrBodega = array();
	$arrBodega = db_select_array (false, $SIS_query, 'bodegas_insumos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBodega');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	bodegas_insumos_facturacion_existencias.Creacion_ano,
	bodegas_insumos_facturacion_existencias.Creacion_mes,
	SUM(bodegas_insumos_facturacion_existencias.ValorTotal) AS Valor,
	insumos_listado.idCategoria';
	$SIS_join  = 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = bodegas_insumos_facturacion_existencias.idProducto';
	$SIS_where = 'bodegas_insumos_facturacion_existencias.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Creacion_ano >='.$ano_pasado;
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.idTipo = 6';
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.idBodega = '.$_GET['idBodegaOrigen'];
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_ing=0';
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_eg!=0';
	$SIS_where.= ' GROUP BY bodegas_insumos_facturacion_existencias.Creacion_ano,bodegas_insumos_facturacion_existencias.Creacion_mes,insumos_listado.idCategoria';
	$SIS_order = 'bodegas_insumos_facturacion_existencias.Creacion_ano ASC';
	$SIS_order.= ', bodegas_insumos_facturacion_existencias.Creacion_mes ASC';
	$SIS_order.= ', insumos_listado.idCategoria ASC';
	$arrExistenciasMain = array();
	$arrExistenciasMain = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrExistenciasMain');

	/****************************************************/
	$mes = array();
	foreach ($arrExistenciasMain as $existencias) {
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = 0;}
		$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] + $existencias['Valor'];									
	}

	/****************************************************/
	$xmes = mes_actual();
	$xaño = ano_actual();
	$graficoMain = array();
	for ($xcontador = 12; $xcontador > 0; $xcontador--) {
		if($xmes>0){
			$graficoMain[$xcontador]['mes'] = $xmes;
			$graficoMain[$xcontador]['año'] = $xaño;
			//recorro
			foreach ($arrCategoria as $cat) {
				if(isset($mes[$xaño][$xmes][$cat['idCategoria']])){ $graficoMain[$xcontador][$cat['idCategoria']] = $mes[$xaño][$xmes][$cat['idCategoria']];}else{$graficoMain[$xcontador][$cat['idCategoria']] = 0;};
			}
		}else{
			$xmes = 12;
			$xaño = $xaño-1;
			$graficoMain[$xcontador]['mes'] = $xmes;
			$graficoMain[$xcontador]['año'] = $xaño;
			//recorro
			foreach ($arrCategoria as $cat) {
				if(isset($mes[$xaño][$xmes][$cat['idCategoria']])){ $graficoMain[$xcontador][$cat['idCategoria']] = $mes[$xaño][$xmes][$cat['idCategoria']];}else{$graficoMain[$xcontador][$cat['idCategoria']] = 0;};
			}
		}
		$xmes = $xmes-1;
	}

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	bodegas_insumos_facturacion_existencias.Creacion_ano,
	bodegas_insumos_facturacion_existencias.Creacion_mes,
	SUM(bodegas_insumos_facturacion_existencias.ValorTotal) AS Valor,
	insumos_listado.idCategoria,
	bodegas_insumos_facturacion.idBodegaDestino AS BodegaID,
	bodegas_insumos_listado.Nombre AS BodegaNombre';
	$SIS_join  = '
	LEFT JOIN `insumos_listado`              ON insumos_listado.idProducto                 = bodegas_insumos_facturacion_existencias.idProducto
	LEFT JOIN `bodegas_insumos_facturacion`  ON bodegas_insumos_facturacion.idFacturacion  = bodegas_insumos_facturacion_existencias.idFacturacion
	LEFT JOIN `bodegas_insumos_listado`      ON bodegas_insumos_listado.idBodega           = bodegas_insumos_facturacion.idBodegaDestino';
	$SIS_where = 'bodegas_insumos_facturacion_existencias.idTipo = 6';
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Creacion_ano >='.$ano_pasado;
	$SIS_where.= ' AND bodegas_insumos_facturacion.idBodegaOrigen = '.$_GET['idBodegaOrigen'];
	$SIS_where.= ' AND bodegas_insumos_facturacion.idBodegaDestino != '.$_GET['idBodegaOrigen'];
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_ing!=0';
	$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.Cantidad_eg=0';
	$SIS_where.= ' GROUP BY bodegas_insumos_facturacion.idBodegaDestino,bodegas_insumos_facturacion_existencias.Creacion_ano,bodegas_insumos_facturacion_existencias.Creacion_mes,insumos_listado.idCategoria';
	$SIS_order = 'bodegas_insumos_facturacion.idBodegaDestino ASC';
	$SIS_order.= ', bodegas_insumos_facturacion_existencias.Creacion_ano ASC';
	$SIS_order.= ', bodegas_insumos_facturacion_existencias.Creacion_mes ASC';
	$SIS_order.= ', insumos_listado.idCategoria ASC';
	$arrExistencias = array();
	$arrExistencias = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrExistencias');


	/****************************************************/
	$mes = array();
	foreach ($arrExistencias as $existencias) {
		if(!isset($mes[$existencias['BodegaID']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']])){ $mes[$existencias['BodegaID']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = 0;}
		$mes[$existencias['BodegaID']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] = $mes[$existencias['BodegaID']][$existencias['Creacion_ano']][$existencias['Creacion_mes']][$existencias['idCategoria']] + $existencias['Valor'];									
	}

	/****************************************************/
	$grafico = array();
	foreach ($arrBodega as $bod) {
		$xmes = mes_actual();
		$xaño = ano_actual();

		for ($xcontador = 12; $xcontador > 0; $xcontador--) {

			if($xmes>0){
				$grafico[$bod['idBodega']][$xcontador]['mes'] = $xmes;
				$grafico[$bod['idBodega']][$xcontador]['año'] = $xaño;
				//recorro
				foreach ($arrCategoria as $cat) {
					if(isset($mes[$bod['idBodega']][$xaño][$xmes][$cat['idCategoria']])){ $grafico[$bod['idBodega']][$xcontador][$cat['idCategoria']] = $mes[$bod['idBodega']][$xaño][$xmes][$cat['idCategoria']];}else{$grafico[$bod['idBodega']][$xcontador][$cat['idCategoria']] = 0;};
				}
			}else{
				$xmes = 12;
				$xaño = $xaño-1;
				$grafico[$bod['idBodega']][$xcontador]['mes'] = $xmes;
				$grafico[$bod['idBodega']][$xcontador]['año'] = $xaño;
				//recorro
				foreach ($arrCategoria as $cat) {
					if(isset($mes[$bod['idBodega']][$xaño][$xmes][$cat['idCategoria']])){ $grafico[$bod['idBodega']][$xcontador][$cat['idCategoria']] = $mes[$bod['idBodega']][$xaño][$xmes][$cat['idCategoria']];}else{$grafico[$bod['idBodega']][$xcontador][$cat['idCategoria']] = 0;};
				}
			}
			$xmes = $xmes-1;
		}
	}


	?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
			<?php
			$zz  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
			$zz .= '&idBodegaOrigen='.$_GET['idBodegaOrigen'];
			?>
			<a target="new" href="<?php echo 'informe_bodega_insumos_07_to_excel.php?bla=bla'.$zz ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
		</div>
	</div>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table']});</script>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo 'Traspasos desde '.$rowBodega['Nombre']; ?></h5>

				<?php
				//llamamos a la función para filtrar los datos
				filtrar($arrExistencias, 'BodegaNombre');
				$mantit = 1;
				echo '<ul class="nav nav-tabs pull-right">';
				//Se fija la empresa con egreso
				echo '<li class="active"><a href="#tab_main" data-toggle="tab"><i class="fa fa-building" aria-hidden="true"></i> '.$rowBodega['Nombre'].'</a></li>';
				//se muestran las empresas con ingresos
				foreach($arrExistencias as $empresa=>$datos) {
					echo '<li class=""><a href="#tab_'.$datos[0]['BodegaID'].'" data-toggle="tab"><i class="fa fa-industry" aria-hidden="true"></i> '.$empresa.'</a></li>';
					if($mantit==2){echo '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';}
					$mantit++;
				}
				if($mantit>=2){echo '</ul></li>';}
				echo '</ul>';
				?>
			</header>

			<div class="tab-content">
				<div class="tab-pane fade active in" id="tab_main">
					<div class="wmd-panel">

						<script>
							google.charts.setOnLoadCallback(graficoMain);

							function graficoMain() {
								var data_main = new google.visualization.DataTable();
								data_main.addColumn("string", "Mes");
								<?php foreach ($arrCategoria as $cat) { ?>
									data_main.addColumn("number", "<?php echo $cat['Nombre'];  ?>");
								<?php } ?>
								data_main.addRows([
									['<?php echo numero_a_mes_corto($graficoMain[1]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[1][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[2]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[2][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[3]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[3][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[4]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[4][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[5]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[5][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[6]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[6][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[7]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[7][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[8]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[8][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[9]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[9][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[10]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[10][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[11]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[11][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($graficoMain[12]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($graficoMain[12][$cat['idCategoria']]);} ?>],
								]);

								var options = {
									title: 'Egresos de la bodega <?php echo $rowBodega['Nombre'] ?>',
									isStacked: true,
									hAxis: {title: 'Meses'},
									vAxis: {title: 'Valores', minValue: 0}
								};

								var chart_main = new google.visualization.ColumnChart(document.getElementById('chart_main'));
								chart_main.draw(data_main, options);
							}
						</script>
						<div id="chart_main" style="height: 500px; width: 100%;"></div>

						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Categoria</th>
									<th><?php echo numero_a_mes_corto($graficoMain[1]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[2]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[3]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[4]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[5]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[6]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[7]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[8]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[9]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[10]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[11]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($graficoMain[12]['mes']); ?></th>
									<th>SubTotal</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php
								//Variables
								$Total        = 0;
								$SubTotal_1   = 0;
								$SubTotal_2   = 0;
								$SubTotal_3   = 0;
								$SubTotal_4   = 0;
								$SubTotal_5   = 0;
								$SubTotal_6   = 0;
								$SubTotal_7   = 0;
								$SubTotal_8   = 0;
								$SubTotal_9   = 0;
								$SubTotal_10  = 0;
								$SubTotal_11  = 0;
								$SubTotal_12  = 0;
								//recorro
								foreach ($arrCategoria as $cat) {
									$SubTotalGen = 0;
									$SubTotalGen = $SubTotalGen + $graficoMain[1][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[2][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[3][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[4][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[5][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[6][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[7][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[8][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[9][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[10][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[11][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $graficoMain[12][$cat['idCategoria']];
									//sumo
									$SubTotal_1  = $SubTotal_1 + $graficoMain[1][$cat['idCategoria']];
									$SubTotal_2  = $SubTotal_2 + $graficoMain[2][$cat['idCategoria']];
									$SubTotal_3  = $SubTotal_3 + $graficoMain[3][$cat['idCategoria']];
									$SubTotal_4  = $SubTotal_4 + $graficoMain[4][$cat['idCategoria']];
									$SubTotal_5  = $SubTotal_5 + $graficoMain[5][$cat['idCategoria']];
									$SubTotal_6  = $SubTotal_6 + $graficoMain[6][$cat['idCategoria']];
									$SubTotal_7  = $SubTotal_7 + $graficoMain[7][$cat['idCategoria']];
									$SubTotal_8  = $SubTotal_8 + $graficoMain[8][$cat['idCategoria']];
									$SubTotal_9  = $SubTotal_9 + $graficoMain[9][$cat['idCategoria']];
									$SubTotal_10 = $SubTotal_10 + $graficoMain[10][$cat['idCategoria']];
									$SubTotal_11 = $SubTotal_11 + $graficoMain[11][$cat['idCategoria']];
									$SubTotal_12 = $SubTotal_12 + $graficoMain[12][$cat['idCategoria']];
									//totales
									$Total = $Total + $SubTotalGen;
									if($SubTotalGen!=0){
									?>
										<tr class="odd">
											<td><?php echo $cat['Nombre'];  ?></td>
											<td align="right"><?php echo valores($graficoMain[1][$cat['idCategoria']], 0);   ?></td>
											<td align="right"><?php echo valores($graficoMain[2][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($graficoMain[3][$cat['idCategoria']], 0);   ?></td>
											<td align="right"><?php echo valores($graficoMain[4][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($graficoMain[5][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($graficoMain[6][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($graficoMain[7][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($graficoMain[8][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($graficoMain[9][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($graficoMain[10][$cat['idCategoria']], 0); ?></td>
											<td align="right"><?php echo valores($graficoMain[11][$cat['idCategoria']], 0); ?></td>
											<td align="right"><?php echo valores($graficoMain[12][$cat['idCategoria']], 0); ?></td>
											<td align="right"><?php echo valores($SubTotalGen, 0);  ?></td>
										</tr>
								<?php } } ?>
								<tr class="active">
									<td align="right"><strong>Totales</strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_1, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_2, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_3, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_4, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_5, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_6, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_7, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_8, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_9, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_10, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_11, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_12, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($Total, 0); ?></strong></td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
			<?php
			//recorremos el array para imprimirlo con formato HTML
			foreach($arrExistencias as $empresa=>$datos) {
				echo '<div class="tab-pane fade" id="tab_'.$datos[0]['BodegaID'].'">';
					echo '<div class="wmd-panel">'; ?>

						<script>
							google.charts.setOnLoadCallback(grafico_<?php echo $datos[0]['BodegaID']; ?>);

							function grafico_<?php echo $datos[0]['BodegaID']; ?>() {
								var data_<?php echo $datos[0]['BodegaID']; ?> = new google.visualization.DataTable();
								data_<?php echo $datos[0]['BodegaID']; ?>.addColumn("string", "Mes"); 
								<?php foreach ($arrCategoria as $cat) { ?>
									data_<?php echo $datos[0]['BodegaID']; ?>.addColumn("number", "<?php echo $cat['Nombre'];  ?>");
								<?php } ?>
								data_<?php echo $datos[0]['BodegaID']; ?>.addRows([
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][1]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][1][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][2]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][2][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][3]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][3][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][4]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][4][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][5]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][5][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][6]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][6][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][7]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][7][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][8]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][8][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][9]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][9][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][10]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][10][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][11]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][11][$cat['idCategoria']]);} ?>],
									['<?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][12]['mes']); ?>'<?php foreach ($arrCategoria as $cat) {echo ','.valores_enteros($grafico[$datos[0]['BodegaID']][12][$cat['idCategoria']]);} ?>],
								]);

								var options_<?php echo $datos[0]['BodegaID']; ?> = {
									title: 'Ingresos de la bodega <?php echo $empresa ?>',
									isStacked: true,
									hAxis: {title: 'Meses'},
									vAxis: {title: 'Valores', minValue: 0}
								};

								var chart_<?php echo $datos[0]['BodegaID']; ?> = new google.visualization.ColumnChart(document.getElementById('chart_<?php echo $datos[0]['BodegaID']; ?>'));
								chart_<?php echo $datos[0]['BodegaID']; ?>.draw(data_<?php echo $datos[0]['BodegaID']; ?>, options_<?php echo $datos[0]['BodegaID']; ?>);
							}
						</script>
						<div id="chart_<?php echo $datos[0]['BodegaID']; ?>" style="height: 500px; width: 100%;"></div>

						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Categoria</th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][1]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][2]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][3]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][4]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][5]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][6]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][7]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][8]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][9]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][10]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][11]['mes']); ?></th>
									<th><?php echo numero_a_mes_corto($grafico[$datos[0]['BodegaID']][12]['mes']); ?></th>
									<th>SubTotal</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php
								//Variables
								$Total        = 0;
								$SubTotal_1   = 0;
								$SubTotal_2   = 0;
								$SubTotal_3   = 0;
								$SubTotal_4   = 0;
								$SubTotal_5   = 0;
								$SubTotal_6   = 0;
								$SubTotal_7   = 0;
								$SubTotal_8   = 0;
								$SubTotal_9   = 0;
								$SubTotal_10  = 0;
								$SubTotal_11  = 0;
								$SubTotal_12  = 0;
								foreach ($arrCategoria as $cat) {
									$SubTotalGen = 0;
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][1][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][2][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][3][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][4][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][5][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][6][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][7][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][8][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][9][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][10][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][11][$cat['idCategoria']];
									$SubTotalGen = $SubTotalGen + $grafico[$datos[0]['BodegaID']][12][$cat['idCategoria']];
									//sumo
									$SubTotal_1 = $SubTotal_1 + $grafico[$datos[0]['BodegaID']][1][$cat['idCategoria']];
									$SubTotal_2 = $SubTotal_2 + $grafico[$datos[0]['BodegaID']][2][$cat['idCategoria']];
									$SubTotal_3 = $SubTotal_3 + $grafico[$datos[0]['BodegaID']][3][$cat['idCategoria']];
									$SubTotal_4 = $SubTotal_4 + $grafico[$datos[0]['BodegaID']][4][$cat['idCategoria']];
									$SubTotal_5 = $SubTotal_5 + $grafico[$datos[0]['BodegaID']][5][$cat['idCategoria']];
									$SubTotal_6 = $SubTotal_6 + $grafico[$datos[0]['BodegaID']][6][$cat['idCategoria']];
									$SubTotal_7 = $SubTotal_7 + $grafico[$datos[0]['BodegaID']][7][$cat['idCategoria']];
									$SubTotal_8 = $SubTotal_8 + $grafico[$datos[0]['BodegaID']][8][$cat['idCategoria']];
									$SubTotal_9 = $SubTotal_9 + $grafico[$datos[0]['BodegaID']][9][$cat['idCategoria']];
									$SubTotal_10 = $SubTotal_10 + $grafico[$datos[0]['BodegaID']][10][$cat['idCategoria']];
									$SubTotal_11 = $SubTotal_11 + $grafico[$datos[0]['BodegaID']][11][$cat['idCategoria']];
									$SubTotal_12 = $SubTotal_12 + $grafico[$datos[0]['BodegaID']][12][$cat['idCategoria']];

									$Total = $Total + $SubTotalGen;
									if($SubTotalGen!=0){ ?>
										<tr class="odd">
											<td><?php echo $cat['Nombre'];  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][1][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][2][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][3][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][4][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][5][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][6][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][7][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][8][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][9][$cat['idCategoria']], 0);  ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][10][$cat['idCategoria']], 0); ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][11][$cat['idCategoria']], 0); ?></td>
											<td align="right"><?php echo valores($grafico[$datos[0]['BodegaID']][12][$cat['idCategoria']], 0); ?></td>
											<td align="right"><?php echo valores($SubTotalGen, 0);  ?></td>
										</tr>
								<?php }} ?>
								<tr class="active">
									<td align="right"><strong>Totales</strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_1, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_2, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_3, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_4, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_5, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_6, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_7, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_8, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_9, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_10, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_11, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($SubTotal_12, 0); ?></strong></td>
									<td align="right"><strong><?php echo valores($Total, 0); ?></strong></td>
								</tr>
							</tbody>
						</table>

					<?php
					echo '</div>';
				echo '</div>';
			}
			echo '</div>';

			?>

		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	$z1 = "bodegas_insumos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z1 .= " AND usuarios_bodegas_insumos.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
					if(isset($idBodegaOrigen)){       $x1  = $idBodegaOrigen;        }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Bodega Origen','idBodegaOrigen', $x1, 2, 'idBodega', 'Nombre', 'bodegas_insumos_listado', 'usuarios_bodegas_insumos', $z1, $dbConn);

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
