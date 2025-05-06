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
$original = "informe_bodega_productos_04.php";
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
/*******************************************************/
//variables
$ano_pasado = ano_actual()-1;
/*******************************************************/
// consulto los datos
$SIS_query = 'Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor';
$SIS_join  = 'INNER JOIN usuarios_bodegas_productos ON usuarios_bodegas_productos.idBodega = bodegas_productos_facturacion_existencias.idBodega';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where.= ' AND Creacion_ano >= '.$ano_pasado;
$SIS_where.= ' AND bodegas_productos_facturacion_existencias.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
//se verifica el tipo de usuario
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$SIS_where.= " AND usuarios_bodegas_productos.idUsuario>=0";
}else{
	$SIS_where.= " AND usuarios_bodegas_productos.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
$SIS_where.= ' GROUP BY Creacion_ano,Creacion_mes,idTipo';
$SIS_order = 'Creacion_ano ASC, Creacion_mes ASC';
$arrExistencias = array();
$arrExistencias = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrExistencias');
/*******************************************************/
$mes = array();
foreach ($arrExistencias as $existencias) {
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] = 0;}
	if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'])){ $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] = 0;}
	switch ($existencias['idTipo']) {
		//Compra de Productos a bodega
		case 1:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			break;
		//Venta de Productos de bodega
		case 2:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] + $existencias['Valor'];
			break;
		//Gasto de Productos
		case 3:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] + $existencias['Valor'];
			break;
		//Traspaso de Productos entre bodegas
		case 4:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] + $existencias['Valor'];
			break;
		//Transformacion de Productos
		case 5:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] + $existencias['Valor'];
			break;
		//Traspaso de Productos a otra Empresa
		case 6:
			if($existencias['Cantidad_ing']!=0){
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			}else{
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] + $existencias['Valor'];
			}
			break;
		//Gasto de Productos en una Orden de Trabajo
		case 7:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] + $existencias['Valor'];
			break;
		//Traspaso Manual de Productos a otra Empresa
		case 8:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] + $existencias['Valor'];
			break;
		//Ingreso Manual
		case 9:
			$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] + $existencias['Valor'];
			break;
	}
}
/*******************************************************/
$xmes = mes_actual();
$xaño = ano_actual();
$grafico = array();
for ($xcontador = 12; $xcontador > 0; $xcontador--) {
	if($xmes>0){
		$grafico[$xcontador]['mes'] = $xmes;
		$grafico[$xcontador]['año'] = $xaño;
		if(isset($mes[$xaño][$xmes]['tipo1'])){ $grafico[$xcontador]['tipo1'] = $mes[$xaño][$xmes]['tipo1'];}else{$grafico[$xcontador]['tipo1'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo2'])){ $grafico[$xcontador]['tipo2'] = $mes[$xaño][$xmes]['tipo2'];}else{$grafico[$xcontador]['tipo2'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo3'])){ $grafico[$xcontador]['tipo3'] = $mes[$xaño][$xmes]['tipo3'];}else{$grafico[$xcontador]['tipo3'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo4'])){ $grafico[$xcontador]['tipo4'] = $mes[$xaño][$xmes]['tipo4'];}else{$grafico[$xcontador]['tipo4'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo5'])){ $grafico[$xcontador]['tipo5'] = $mes[$xaño][$xmes]['tipo5'];}else{$grafico[$xcontador]['tipo5'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo6'])){ $grafico[$xcontador]['tipo6'] = $mes[$xaño][$xmes]['tipo6'];}else{$grafico[$xcontador]['tipo6'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo7'])){ $grafico[$xcontador]['tipo7'] = $mes[$xaño][$xmes]['tipo7'];}else{$grafico[$xcontador]['tipo7'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo8'])){ $grafico[$xcontador]['tipo8'] = $mes[$xaño][$xmes]['tipo8'];}else{$grafico[$xcontador]['tipo8'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo9'])){ $grafico[$xcontador]['tipo9'] = $mes[$xaño][$xmes]['tipo9'];}else{$grafico[$xcontador]['tipo9'] = 0;};

	}else{
		$xmes = 12;
		$xaño = $xaño-1;
		$grafico[$xcontador]['mes'] = $xmes;
		$grafico[$xcontador]['año'] = $xaño;

		if(isset($mes[$xaño][$xmes]['tipo1'])){ $grafico[$xcontador]['tipo1'] = $mes[$xaño][$xmes]['tipo1'];}else{$grafico[$xcontador]['tipo1'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo2'])){ $grafico[$xcontador]['tipo2'] = $mes[$xaño][$xmes]['tipo2'];}else{$grafico[$xcontador]['tipo2'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo3'])){ $grafico[$xcontador]['tipo3'] = $mes[$xaño][$xmes]['tipo3'];}else{$grafico[$xcontador]['tipo3'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo4'])){ $grafico[$xcontador]['tipo4'] = $mes[$xaño][$xmes]['tipo4'];}else{$grafico[$xcontador]['tipo4'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo5'])){ $grafico[$xcontador]['tipo5'] = $mes[$xaño][$xmes]['tipo5'];}else{$grafico[$xcontador]['tipo5'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo6'])){ $grafico[$xcontador]['tipo6'] = $mes[$xaño][$xmes]['tipo6'];}else{$grafico[$xcontador]['tipo6'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo7'])){ $grafico[$xcontador]['tipo7'] = $mes[$xaño][$xmes]['tipo7'];}else{$grafico[$xcontador]['tipo7'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo8'])){ $grafico[$xcontador]['tipo8'] = $mes[$xaño][$xmes]['tipo8'];}else{$grafico[$xcontador]['tipo8'] = 0;};
		if(isset($mes[$xaño][$xmes]['tipo9'])){ $grafico[$xcontador]['tipo9'] = $mes[$xaño][$xmes]['tipo9'];}else{$grafico[$xcontador]['tipo9'] = 0;};

	}
	$xmes = $xmes-1;
}
/*******************************************************/
//Configuro lo que quiero ver
$s_Ventas              = 'true';
$s_Gastos              = 'true';
$s_Traspasos           = 'true';
$s_Transformacion      = 'true';
$s_Traspaso_empresa    = 'true';
$s_Gasto_OT            = 'true';
$s_Traspaso_Manual     = 'true';
$s_Ingreso_Manual      = 'true';
//Se crea la cadena para generar los graficos
$s_data = 'tipo1';
if($s_Ventas=='true'){            $s_data .= ',tipo2';}
if($s_Gastos=='true'){            $s_data .= ',tipo3';}
if($s_Traspasos=='true'){         $s_data .= ',tipo4';}
if($s_Transformacion=='true'){    $s_data .= ',tipo5';}
if($s_Traspaso_empresa=='true'){  $s_data .= ',tipo6';}
if($s_Gasto_OT=='true'){          $s_data .= ',tipo7';}
if($s_Traspaso_Manual=='true'){   $s_data .= ',tipo8';}
if($s_Ingreso_Manual=='true'){    $s_data .= ',tipo9';}

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table']});</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Bodega de Productos</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="#tab2" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Compras</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if($s_Ventas=='true'){ ?>            <li class=""><a href="#tab3"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ventas</a></li><?php } ?>
						<?php if($s_Gastos=='true'){ ?>            <li class=""><a href="#tab4"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gastos</a></li><?php } ?>
						<?php if($s_Traspasos=='true'){ ?>         <li class=""><a href="#tab5"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspasos</a></li><?php } ?>
						<?php if($s_Transformacion=='true'){ ?>    <li class=""><a href="#tab6"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Transformacion</a></li><?php } ?>
						<?php if($s_Traspaso_empresa=='true'){ ?>  <li class=""><a href="#tab7"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso otra empresa</a></li><?php } ?>
						<?php if($s_Gasto_OT=='true'){ ?>          <li class=""><a href="#tab8"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gasto OT</a></li><?php } ?>
						<?php if($s_Traspaso_Manual=='true'){ ?>   <li class=""><a href="#tab9"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso manual otra empresa</a></li><?php } ?>
						<?php if($s_Ingreso_Manual=='true'){ ?>    <li class=""><a href="#tab10" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ingreso Manual</a></li><?php } ?>

					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="tab1">
				<div class="wmd-panel">
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
							<?php
							$trans_1='';
							echo widget_bodega('Bodega de Productos',
											   'bodegas_productos_listado', 'bodegas_productos_facturacion_existencias', 'bodegas_productos_facturacion_tipo', 
											   'productos_listado', 'sistema_productos_uml', $s_data,1,
											   $trans_1,$dbConn, 'usuarios_bodegas_productos', $_SESSION['usuario']['basic_data']['idSistema']);	
						   ?>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="tab2">
				<div class="wmd-panel">
					<div class="table-responsive">

						<script>

							google.charts.setOnLoadCallback(drawChart1);

							function drawChart1() {
								var data1 = new google.visualization.DataTable();
								data1.addColumn('string', 'Fecha');
								data1.addColumn('number', 'Valor');
								data1.addColumn({type: 'string', role: 'annotation'});

								data1.addRows([
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
								var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart1'));
								chart1.draw(data1, options);
							}
						</script>
						<div id="curve_chart1" style="height: 500px; width: 100%;"></div>
					</div>
				</div>
			</div>

			<?php if($s_Ventas=='true'){ ?>
				<div class="tab-pane fade" id="tab3">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart2'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart2" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Gastos=='true'){ ?>
				<div class="tab-pane fade" id="tab4">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo3']) ?>, '<?php echo valores_enteros($grafico[1]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo3']) ?>, '<?php echo valores_enteros($grafico[2]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo3']) ?>, '<?php echo valores_enteros($grafico[3]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo3']) ?>, '<?php echo valores_enteros($grafico[4]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo3']) ?>, '<?php echo valores_enteros($grafico[5]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo3']) ?>, '<?php echo valores_enteros($grafico[6]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo3']) ?>, '<?php echo valores_enteros($grafico[7]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo3']) ?>, '<?php echo valores_enteros($grafico[8]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo3']) ?>, '<?php echo valores_enteros($grafico[9]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo3']) ?>, '<?php echo valores_enteros($grafico[10]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo3']) ?>, '<?php echo valores_enteros($grafico[11]['tipo3']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo3']) ?>, '<?php echo valores_enteros($grafico[12]['tipo3']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo3'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart3'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart3" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspasos=='true'){ ?>
				<div class="tab-pane fade" id="tab5">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo4']) ?>, '<?php echo valores_enteros($grafico[1]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo4']) ?>, '<?php echo valores_enteros($grafico[2]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo4']) ?>, '<?php echo valores_enteros($grafico[3]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo4']) ?>, '<?php echo valores_enteros($grafico[4]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo4']) ?>, '<?php echo valores_enteros($grafico[5]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo4']) ?>, '<?php echo valores_enteros($grafico[6]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo4']) ?>, '<?php echo valores_enteros($grafico[7]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo4']) ?>, '<?php echo valores_enteros($grafico[8]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo4']) ?>, '<?php echo valores_enteros($grafico[9]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo4']) ?>, '<?php echo valores_enteros($grafico[10]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo4']) ?>, '<?php echo valores_enteros($grafico[11]['tipo4']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo4']) ?>, '<?php echo valores_enteros($grafico[12]['tipo4']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo4'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart4'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart4" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Transformacion=='true'){ ?>
				<div class="tab-pane fade" id="tab6">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo5']) ?>, '<?php echo valores_enteros($grafico[1]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo5']) ?>, '<?php echo valores_enteros($grafico[2]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo5']) ?>, '<?php echo valores_enteros($grafico[3]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo5']) ?>, '<?php echo valores_enteros($grafico[4]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo5']) ?>, '<?php echo valores_enteros($grafico[5]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo5']) ?>, '<?php echo valores_enteros($grafico[6]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo5']) ?>, '<?php echo valores_enteros($grafico[7]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo5']) ?>, '<?php echo valores_enteros($grafico[8]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo5']) ?>, '<?php echo valores_enteros($grafico[9]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo5']) ?>, '<?php echo valores_enteros($grafico[10]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo5']) ?>, '<?php echo valores_enteros($grafico[11]['tipo5']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo5']) ?>, '<?php echo valores_enteros($grafico[12]['tipo5']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo5'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart5'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart5" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspaso_empresa=='true'){ ?>
				<div class="tab-pane fade" id="tab7">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo6']) ?>, '<?php echo valores_enteros($grafico[1]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo6']) ?>, '<?php echo valores_enteros($grafico[2]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo6']) ?>, '<?php echo valores_enteros($grafico[3]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo6']) ?>, '<?php echo valores_enteros($grafico[4]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo6']) ?>, '<?php echo valores_enteros($grafico[5]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo6']) ?>, '<?php echo valores_enteros($grafico[6]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo6']) ?>, '<?php echo valores_enteros($grafico[7]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo6']) ?>, '<?php echo valores_enteros($grafico[8]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo6']) ?>, '<?php echo valores_enteros($grafico[9]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo6']) ?>, '<?php echo valores_enteros($grafico[10]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo6']) ?>, '<?php echo valores_enteros($grafico[11]['tipo6']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo6']) ?>, '<?php echo valores_enteros($grafico[12]['tipo6']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo6'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart6'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart6" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Gasto_OT=='true'){ ?>
				<div class="tab-pane fade" id="tab8">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo7']) ?>, '<?php echo valores_enteros($grafico[1]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo7']) ?>, '<?php echo valores_enteros($grafico[2]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo7']) ?>, '<?php echo valores_enteros($grafico[3]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo7']) ?>, '<?php echo valores_enteros($grafico[4]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo7']) ?>, '<?php echo valores_enteros($grafico[5]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo7']) ?>, '<?php echo valores_enteros($grafico[6]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo7']) ?>, '<?php echo valores_enteros($grafico[7]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo7']) ?>, '<?php echo valores_enteros($grafico[8]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo7']) ?>, '<?php echo valores_enteros($grafico[9]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo7']) ?>, '<?php echo valores_enteros($grafico[10]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo7']) ?>, '<?php echo valores_enteros($grafico[11]['tipo7']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo7']) ?>, '<?php echo valores_enteros($grafico[12]['tipo7']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo7'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart7'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart7" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspaso_Manual=='true'){ ?>
				<div class="tab-pane fade" id="tab9">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo8']) ?>, '<?php echo valores_enteros($grafico[1]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo8']) ?>, '<?php echo valores_enteros($grafico[2]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo8']) ?>, '<?php echo valores_enteros($grafico[3]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo8']) ?>, '<?php echo valores_enteros($grafico[4]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo8']) ?>, '<?php echo valores_enteros($grafico[5]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo8']) ?>, '<?php echo valores_enteros($grafico[6]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo8']) ?>, '<?php echo valores_enteros($grafico[7]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo8']) ?>, '<?php echo valores_enteros($grafico[8]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo8']) ?>, '<?php echo valores_enteros($grafico[9]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo8']) ?>, '<?php echo valores_enteros($grafico[10]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo8']) ?>, '<?php echo valores_enteros($grafico[11]['tipo8']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo8']) ?>, '<?php echo valores_enteros($grafico[12]['tipo8']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo8'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart8'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart8" style="height: 500px; width: 100%;"></div>

						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Ingreso_Manual=='true'){ ?>
				<div class="tab-pane fade" id="tab10">
					<div class="wmd-panel">
						<div class="table-responsive">

							<script>

								google.charts.setOnLoadCallback(drawChart1);

								function drawChart1() {
									var data1 = new google.visualization.DataTable();
									data1.addColumn('string', 'Fecha');
									data1.addColumn('number', 'Valor');
									data1.addColumn({type: 'string', role: 'annotation'});

									data1.addRows([
										["<?php echo numero_a_mes_corto($grafico[1]['mes']); ?>", <?php echo valores_enteros($grafico[1]['tipo9']) ?>, '<?php echo valores_enteros($grafico[1]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[2]['mes']); ?>", <?php echo valores_enteros($grafico[2]['tipo9']) ?>, '<?php echo valores_enteros($grafico[2]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[3]['mes']); ?>", <?php echo valores_enteros($grafico[3]['tipo9']) ?>, '<?php echo valores_enteros($grafico[3]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[4]['mes']); ?>", <?php echo valores_enteros($grafico[4]['tipo9']) ?>, '<?php echo valores_enteros($grafico[4]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[5]['mes']); ?>", <?php echo valores_enteros($grafico[5]['tipo9']) ?>, '<?php echo valores_enteros($grafico[5]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[6]['mes']); ?>", <?php echo valores_enteros($grafico[6]['tipo9']) ?>, '<?php echo valores_enteros($grafico[6]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[7]['mes']); ?>", <?php echo valores_enteros($grafico[7]['tipo9']) ?>, '<?php echo valores_enteros($grafico[7]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[8]['mes']); ?>", <?php echo valores_enteros($grafico[8]['tipo9']) ?>, '<?php echo valores_enteros($grafico[8]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[9]['mes']); ?>", <?php echo valores_enteros($grafico[9]['tipo9']) ?>, '<?php echo valores_enteros($grafico[9]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[10]['mes']); ?>", <?php echo valores_enteros($grafico[10]['tipo9']) ?>, '<?php echo valores_enteros($grafico[10]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[11]['mes']); ?>", <?php echo valores_enteros($grafico[11]['tipo9']) ?>, '<?php echo valores_enteros($grafico[11]['tipo9']) ?>'],
										["<?php echo numero_a_mes_corto($grafico[12]['mes']); ?>", <?php echo valores_enteros($grafico[12]['tipo9']) ?>, '<?php echo valores_enteros($grafico[12]['tipo9']) ?>']

									]);

									var options = {
										title: 'Grafico <?php echo widget_nombre('tipo9'); ?>',
										hAxis: {title: 'Fechas'},
										vAxis: { title: 'Valor' },
										width: $(window).width()*0.75,
										height: 500,
										curveType: 'function',
										series: {0: {pointsVisible: true},},
										annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
										colors: ['#FFB347']
									};
									var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart9'));
									chart1.draw(data1, options);
								}
							</script>
							<div id="curve_chart9" style="height: 500px; width: 100%;"></div>

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
