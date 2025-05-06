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
$original = "informe_bodega_arriendos_04.php";
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
/*******************************************************/
//Variables
$ano_pasado = ano_actual()-1;
/*******************************************************/
// consulto los datos
$SIS_query = 'Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor';
$SIS_join  = 'INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion_existencias.idBodega';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where.= ' AND Creacion_ano >= '.$ano_pasado;
$SIS_where.= ' AND bodegas_arriendos_facturacion_existencias.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where.= ' AND usuarios_bodegas_arriendos.idUsuario ='.$_SESSION['usuario']['basic_data']['idUsuario'];
$SIS_where.= ' GROUP BY Creacion_ano,Creacion_mes,idTipo';
$SIS_order = 'Creacion_ano ASC, Creacion_mes ASC';
$arrExistencias = array();
$arrExistencias = db_select_array (false, $SIS_query, 'bodegas_arriendos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrExistencias');

/*******************************************************/
$mes = array();
foreach ($arrExistencias as $existencias) {
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = 0;}
	switch ($existencias['idTipo']) {
		//Compra de Productos a bodega
		case 1:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			break;
		//Venta de Productos de bodega
		case 2:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] + $existencias['Valor'];
			break;
	}
}

$xmes = mes_actual();
$xaño = ano_actual();
$grafico = array();
for ($xcontador = 12; $xcontador > 0; $xcontador--) {
	if($xmes>0){
		$grafico[$xcontador]['mes'] = $xmes;
		$grafico[$xcontador]['año'] = $xaño;
		if(isset($mes[$xaño][$xmes]['tipo1'])){ $grafico[$xcontador]['tipo1'] = $mes[$xaño][$xmes]['tipo1'];}else{$grafico[$xcontador]['tipo1'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo2'])){ $grafico[$xcontador]['tipo2'] = $mes[$xaño][$xmes]['tipo2'];}else{$grafico[$xcontador]['tipo2'] = 0;};

	}else{
		$xmes = 12;
		$xaño = $xaño-1;
		$grafico[$xcontador]['mes'] = $xmes;
		$grafico[$xcontador]['año'] = $xaño;

		if(isset($mes[$xaño][$xmes]['tipo1'])){ $grafico[$xcontador]['tipo1'] = $mes[$xaño][$xmes]['tipo1'];}else{$grafico[$xcontador]['tipo1'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo2'])){ $grafico[$xcontador]['tipo2'] = $mes[$xaño][$xmes]['tipo2'];}else{$grafico[$xcontador]['tipo2'] = 0;};

	}
	$xmes = $xmes-1;
}

//Configuro lo que quiero ver
$s_Ventas              = 'true';
//Se crea la cadena para generar los graficos
$s_data = 'tipo1';
if($s_Ventas=='true'){            $s_data .= ',tipo2';}

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table']});</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Bodega de Arriendos</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tab_arr_1" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="#tab_arr_2" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Compras</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if($s_Ventas=='true'){ ?>            <li class=""><a href="#tab_arr_3" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ventas</a></li><?php } ?>
					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="tab_arr_1">
				<div class="wmd-panel">
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
							<?php
							//Se dibujan los graficos, los widget y las tablas
							$trans_1='';
							echo widget_bodega('Bodega de Arriendos',
												'bodegas_arriendos_listado', 'bodegas_arriendos_facturacion_existencias', 'bodegas_arriendos_facturacion_tipo', 
												'equipos_arriendo_listado', 0, $s_data,3,
												$trans_1,$dbConn, 'usuarios_bodegas_arriendos', $_SESSION['usuario']['basic_data']['idSistema']);
						   ?>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="tab_arr_2">
				<div class="wmd-panel">
					<div class="table-responsive">

						<script>
							google.charts.setOnLoadCallback(drawChart_arr_1);

							function drawChart_arr_1() {
								var data_arr_1 = new google.visualization.DataTable();
								data_arr_1.addColumn('string', 'Fecha');
								data_arr_1.addColumn('number', 'Valor');
								data_arr_1.addColumn({type: 'string', role: 'annotation'});

								data_arr_1.addRows([
									["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo1']) ?>, '<?php echo valores_enteros($grafico[1]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo1']) ?>, '<?php echo valores_enteros($grafico[2]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo1']) ?>, '<?php echo valores_enteros($grafico[3]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo1']) ?>, '<?php echo valores_enteros($grafico[4]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo1']) ?>, '<?php echo valores_enteros($grafico[5]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo1']) ?>, '<?php echo valores_enteros($grafico[6]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo1']) ?>, '<?php echo valores_enteros($grafico[7]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo1']) ?>, '<?php echo valores_enteros($grafico[8]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo1']) ?>, '<?php echo valores_enteros($grafico[9]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo1']) ?>, '<?php echo valores_enteros($grafico[10]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo1']) ?>, '<?php echo valores_enteros($grafico[11]['tipo1']) ?>'],
									["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo1']) ?>, '<?php echo valores_enteros($grafico[12]['tipo1']) ?>']

								]);

								var options = {
									title: 'Grafico <?php echo widget_nombre('tipo1'); ?>',
									hAxis: {title: 'Fechas'},
									vAxis: { title: 'Valor' },
									width: $(window).width()*0.75,
									height: 500,
									curveType: 'function',
									series: {0: {pointsVisible: true},},
									annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
									colors: ['#FFB347']
								};
								var chart1 = new google.visualization.LineChart(document.getElementById('chart_arr_1'));
								chart1.draw(data_arr_1, options);
							}
						</script>
						<div id="chart_arr_1" style="height: 500px; width: 100%;"></div>
					</div>
				</div>
			</div>

			<?php if($s_Ventas=='true'){ ?>
				<div class="tab-pane fade" id="tab_arr_3">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart_arr_2);

								function drawChart_arr_2() {
									var data_arr_2 = new google.visualization.DataTable();
									data_arr_2.addColumn('string', 'Fecha');
									data_arr_2.addColumn('number', 'Valor');
									data_arr_2.addColumn({type: 'string', role: 'annotation'});

									data_arr_2.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo2']) ?>, '<?php echo valores_enteros($grafico[1]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo2']) ?>, '<?php echo valores_enteros($grafico[2]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo2']) ?>, '<?php echo valores_enteros($grafico[3]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo2']) ?>, '<?php echo valores_enteros($grafico[4]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo2']) ?>, '<?php echo valores_enteros($grafico[5]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo2']) ?>, '<?php echo valores_enteros($grafico[6]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo2']) ?>, '<?php echo valores_enteros($grafico[7]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo2']) ?>, '<?php echo valores_enteros($grafico[8]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo2']) ?>, '<?php echo valores_enteros($grafico[9]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo2']) ?>, '<?php echo valores_enteros($grafico[10]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo2']) ?>, '<?php echo valores_enteros($grafico[11]['tipo2']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo2']) ?>, '<?php echo valores_enteros($grafico[12]['tipo2']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo2'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_arr_2'));
									chart1.draw(data_arr_2, options);
								}
							</script>
							<div id="chart_arr_2" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>

        </div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
