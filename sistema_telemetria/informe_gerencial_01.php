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
$original = "informe_gerencial_01.php";
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
$x1 = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//se verifica el tipo de usuario
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$x2 = "idUsuario>=0";
}else{
	$x2 = "idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Variables
$join_1  = "INNER JOIN usuarios_bodegas_productos ON usuarios_bodegas_productos.idBodega = bodegas_productos_facturacion_existencias.idBodega";
$join_2  = "INNER JOIN usuarios_bodegas_insumos ON usuarios_bodegas_insumos.idBodega = bodegas_insumos_facturacion_existencias.idBodega";
$join_3  = "INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion_existencias.idBodega";
$where_1 = " AND bodegas_productos_facturacion_existencias.".$x1." AND usuarios_bodegas_productos.".$x2;
$where_2 = " AND bodegas_insumos_facturacion_existencias.".$x1." AND usuarios_bodegas_insumos.".$x2;
$where_3 = " AND bodegas_arriendos_facturacion_existencias.".$x1." AND usuarios_bodegas_arriendos.".$x2;
/**********************************************************/
// Se trae un listado con los valores de las existencias actuales
$ano_pasado = ano_actual()-1;
$z = "WHERE idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."'";
$z.= " AND Creacion_ano >= ".$ano_pasado;
//se consulta
$arrExistencias = array();
$query = "SELECT Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor
FROM `bodegas_productos_facturacion_existencias`
".$join_1."
".$z."
".$where_1."
GROUP BY Creacion_ano,Creacion_mes,idTipo
ORDER BY Creacion_ano ASC, Creacion_mes ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrExistencias,$row );
}
	

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

<h3 class="supertittle text-primary">Productos</h3>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Bodega de Productos</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tab_prod_1" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="#tab_prod_2" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Compras</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if($s_Ventas=='true'){ ?>            <li class=""><a href="#tab_prod_3"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ventas</a></li><?php } ?>
						<?php if($s_Gastos=='true'){ ?>            <li class=""><a href="#tab_prod_4"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gastos</a></li><?php } ?>
						<?php if($s_Traspasos=='true'){ ?>         <li class=""><a href="#tab_prod_5"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspasos</a></li><?php } ?>
						<?php if($s_Transformacion=='true'){ ?>    <li class=""><a href="#tab_prod_6"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Transformacion</a></li><?php } ?>
						<?php if($s_Traspaso_empresa=='true'){ ?>  <li class=""><a href="#tab_prod_7"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso otra empresa</a></li><?php } ?>
						<?php if($s_Gasto_OT=='true'){ ?>          <li class=""><a href="#tab_prod_8"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gasto OT</a></li><?php } ?>
						<?php if($s_Traspaso_Manual=='true'){ ?>   <li class=""><a href="#tab_prod_9"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso manual otra empresa</a></li><?php } ?>
						<?php if($s_Ingreso_Manual=='true'){ ?>    <li class=""><a href="#tab_prod_10" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ingreso Manual</a></li><?php } ?>

					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="tab_prod_1">
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

			<div class="tab-pane fade" id="tab_prod_2">
				<div class="wmd-panel">
					<div class="table-responsive">

						<script>
							
							google.charts.setOnLoadCallback(drawChart_prod_1);

							function drawChart_prod_1() {
								var data_prod_1 = new google.visualization.DataTable();
								data_prod_1.addColumn('string', 'Fecha'); 
								data_prod_1.addColumn('number', 'Valor');
								data_prod_1.addColumn({type: 'string', role: 'annotation'});

								data_prod_1.addRows([
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
								var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_1'));
								chart1.draw(data_prod_1, options);
							}
						</script>
						<div id="chart_prod_1" style="height: 500px; width: 100%;"></div>
					</div>
				</div>
			</div>

			<?php if($s_Ventas=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_3">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_2);

								function drawChart_prod_2() {
									var data_prod_2 = new google.visualization.DataTable();
									data_prod_2.addColumn('string', 'Fecha'); 
									data_prod_2.addColumn('number', 'Valor');
									data_prod_2.addColumn({type: 'string', role: 'annotation'});

									data_prod_2.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_2'));
									chart1.draw(data_prod_2, options);
								}
							</script>
							<div id="chart_prod_2" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Gastos=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_4">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_3);

								function drawChart_prod_3() {
									var data_prod_3 = new google.visualization.DataTable();
									data_prod_3.addColumn('string', 'Fecha'); 
									data_prod_3.addColumn('number', 'Valor');
									data_prod_3.addColumn({type: 'string', role: 'annotation'});

									data_prod_3.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_3'));
									chart1.draw(data_prod_3, options);
								}
							</script>
							<div id="chart_prod_3" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspasos=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_5">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_4);

								function drawChart_prod_4() {
									var data_prod_4 = new google.visualization.DataTable();
									data_prod_4.addColumn('string', 'Fecha'); 
									data_prod_4.addColumn('number', 'Valor');
									data_prod_4.addColumn({type: 'string', role: 'annotation'});

									data_prod_4.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_4'));
									chart1.draw(data_prod_4, options);
								}
							</script>
							<div id="chart_prod_4" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Transformacion=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_6">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_5);

								function drawChart_prod_5() {
									var data_prod_5 = new google.visualization.DataTable();
									data_prod_5.addColumn('string', 'Fecha'); 
									data_prod_5.addColumn('number', 'Valor');
									data_prod_5.addColumn({type: 'string', role: 'annotation'});

									data_prod_5.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_5'));
									chart1.draw(data_prod_5, options);
								}
							</script>
							<div id="chart_prod_5" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspaso_empresa=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_7">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_6);

								function drawChart_prod_6() {
									var data_prod_6 = new google.visualization.DataTable();
									data_prod_6.addColumn('string', 'Fecha'); 
									data_prod_6.addColumn('number', 'Valor');
									data_prod_6.addColumn({type: 'string', role: 'annotation'});

									data_prod_6.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_6'));
									chart1.draw(data_prod_6, options);
								}
							</script>
							<div id="chart_prod_6" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Gasto_OT=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_8">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_7);

								function drawChart_prod_7() {
									var data_prod_7 = new google.visualization.DataTable();
									data_prod_7.addColumn('string', 'Fecha'); 
									data_prod_7.addColumn('number', 'Valor');
									data_prod_7.addColumn({type: 'string', role: 'annotation'});

									data_prod_7.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_7'));
									chart1.draw(data_prod_7, options);
								}
							</script>
							<div id="chart_prod_7" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspaso_Manual=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_9">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_8);

								function drawChart_prod_8() {
									var data_prod_8 = new google.visualization.DataTable();
									data_prod_8.addColumn('string', 'Fecha'); 
									data_prod_8.addColumn('number', 'Valor');
									data_prod_8.addColumn({type: 'string', role: 'annotation'});

									data_prod_8.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_8'));
									chart1.draw(data_prod_8, options);
								}
							</script>
							<div id="chart_prod_8" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Ingreso_Manual=='true'){ ?>
				<div class="tab-pane fade" id="tab_prod_10">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_prod_9);

								function drawChart_prod_9() {
									var data_prod_9 = new google.visualization.DataTable();
									data_prod_9.addColumn('string', 'Fecha'); 
									data_prod_9.addColumn('number', 'Valor');
									data_prod_9.addColumn({type: 'string', role: 'annotation'});

									data_prod_9.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_prod_9'));
									chart1.draw(data_prod_9, options);
								}
							</script>
							<div id="chart_prod_9" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>

        </div>
	</div>
</div>

<?php 
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
// Se trae un listado con los valores de las existencias actuales
$ano_pasado = ano_actual()-1;
$z = "WHERE idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."'";
$z.= " AND Creacion_ano >= ".$ano_pasado;
//se consulta
$arrExistencias = array();
$query = "SELECT Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor
FROM `bodegas_insumos_facturacion_existencias`
".$join_2."
".$z."
".$where_2."
GROUP BY Creacion_ano,Creacion_mes,idTipo
ORDER BY Creacion_ano ASC, Creacion_mes ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrExistencias,$row );
}


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

//Configuro lo que quiero ver
$s_Ventas              = 'true';
$s_Gastos              = 'true';
$s_Traspasos           = 'true';
$s_Transformacion      = 'false';
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

<div class="clearfix"></div>
<h3 class="supertittle text-primary">Insumos</h3>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Bodega de Insumos</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tab_ins_1" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="#tab_ins_2" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Compras</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if($s_Ventas=='true'){ ?>            <li class=""><a href="#tab_ins_3"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ventas</a></li><?php } ?>
						<?php if($s_Gastos=='true'){ ?>            <li class=""><a href="#tab_ins_4"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gastos</a></li><?php } ?>
						<?php if($s_Traspasos=='true'){ ?>         <li class=""><a href="#tab_ins_5"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspasos</a></li><?php } ?>
						<?php if($s_Transformacion=='true'){ ?>    <li class=""><a href="#tab_ins_6"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Transformacion</a></li><?php } ?>
						<?php if($s_Traspaso_empresa=='true'){ ?>  <li class=""><a href="#tab_ins_7"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso otra empresa</a></li><?php } ?>
						<?php if($s_Gasto_OT=='true'){ ?>          <li class=""><a href="#tab_ins_8"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gasto OT</a></li><?php } ?>
						<?php if($s_Traspaso_Manual=='true'){ ?>   <li class=""><a href="#tab_ins_9"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso manual otra empresa</a></li><?php } ?>
						<?php if($s_Ingreso_Manual=='true'){ ?>    <li class=""><a href="#tab_ins_10" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ingreso Manual</a></li><?php } ?>

					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="tab_ins_1">
				<div class="wmd-panel">
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
							<?php
							//Se dibujan los graficos, los widget y las tablas
							$trans_1='';				     
							echo widget_bodega('Bodega de Insumos',
											   'bodegas_insumos_listado', 'bodegas_insumos_facturacion_existencias', 'bodegas_insumos_facturacion_tipo', 
											   'insumos_listado', 'sistema_productos_uml', $s_data,2,
											   $trans_1,$dbConn, 'usuarios_bodegas_insumos', $_SESSION['usuario']['basic_data']['idSistema']);
						   ?>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="tab_ins_2">
				<div class="wmd-panel">
					<div class="table-responsive">

						<script>
							
							google.charts.setOnLoadCallback(drawChart_ins_1);

							function drawChart_ins_1() {
								var data_ins_1 = new google.visualization.DataTable();
								data_ins_1.addColumn('string', 'Fecha'); 
								data_ins_1.addColumn('number', 'Valor');
								data_ins_1.addColumn({type: 'string', role: 'annotation'});

								data_ins_1.addRows([
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
								var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_1'));
								chart1.draw(data_ins_1, options);
							}
						</script>
						<div id="chart_ins_1" style="height: 500px; width: 100%;"></div>
					</div>
				</div>
			</div>

			<?php if($s_Ventas=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_3">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_2);

								function drawChart_ins_2() {
									var data_ins_2 = new google.visualization.DataTable();
									data_ins_2.addColumn('string', 'Fecha'); 
									data_ins_2.addColumn('number', 'Valor');
									data_ins_2.addColumn({type: 'string', role: 'annotation'});

									data_ins_2.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_2'));
									chart1.draw(data_ins_2, options);
								}
							</script>
							<div id="chart_ins_2" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Gastos=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_4">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_3);

								function drawChart_ins_3() {
									var data_ins_3 = new google.visualization.DataTable();
									data_ins_3.addColumn('string', 'Fecha'); 
									data_ins_3.addColumn('number', 'Valor');
									data_ins_3.addColumn({type: 'string', role: 'annotation'});

									data_ins_3.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_3'));
									chart1.draw(data_ins_3, options);
								}
							</script>
							<div id="chart_ins_3" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspasos=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_5">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_4);

								function drawChart_ins_4() {
									var data_ins_4 = new google.visualization.DataTable();
									data_ins_4.addColumn('string', 'Fecha'); 
									data_ins_4.addColumn('number', 'Valor');
									data_ins_4.addColumn({type: 'string', role: 'annotation'});

									data_ins_4.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_4'));
									chart1.draw(data_ins_4, options);
								}
							</script>
							<div id="chart_ins_4" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Transformacion=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_6">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_5);

								function drawChart_ins_5() {
									var data_ins_5 = new google.visualization.DataTable();
									data_ins_5.addColumn('string', 'Fecha'); 
									data_ins_5.addColumn('number', 'Valor');
									data_ins_5.addColumn({type: 'string', role: 'annotation'});

									data_ins_5.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_5'));
									chart1.draw(data_ins_5, options);
								}
							</script>
							<div id="chart_ins_5" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspaso_empresa=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_7">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_6);

								function drawChart_ins_6() {
									var data_ins_6 = new google.visualization.DataTable();
									data_ins_6.addColumn('string', 'Fecha'); 
									data_ins_6.addColumn('number', 'Valor');
									data_ins_6.addColumn({type: 'string', role: 'annotation'});

									data_ins_6.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_6'));
									chart1.draw(data_ins_6, options);
								}
							</script>
							<div id="chart_ins_6" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Gasto_OT=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_8">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_7);

								function drawChart_ins_7() {
									var data_ins_7 = new google.visualization.DataTable();
									data_ins_7.addColumn('string', 'Fecha'); 
									data_ins_7.addColumn('number', 'Valor');
									data_ins_7.addColumn({type: 'string', role: 'annotation'});

									data_ins_7.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_7'));
									chart1.draw(data_ins_7, options);
								}
							</script>
							<div id="chart_ins_7" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Traspaso_Manual=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_9">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_8);

								function drawChart_ins_8() {
									var data_ins_8 = new google.visualization.DataTable();
									data_ins_8.addColumn('string', 'Fecha'); 
									data_ins_8.addColumn('number', 'Valor');
									data_ins_8.addColumn({type: 'string', role: 'annotation'});

									data_ins_8.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_8'));
									chart1.draw(data_ins_8, options);
								}
							</script>
							<div id="chart_ins_8" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($s_Ingreso_Manual=='true'){ ?>
				<div class="tab-pane fade" id="tab_ins_10">
					<div class="wmd-panel">
						<div class="table-responsive">
							
										
							<script>

								google.charts.setOnLoadCallback(drawChart_ins_9);

								function drawChart_ins_9() {
									var data_ins_9 = new google.visualization.DataTable();
									data_ins_9.addColumn('string', 'Fecha'); 
									data_ins_9.addColumn('number', 'Valor');
									data_ins_9.addColumn({type: 'string', role: 'annotation'});

									data_ins_9.addRows([
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
									var chart1 = new google.visualization.LineChart(document.getElementById('chart_ins_9'));
									chart1.draw(data_ins_9, options);
								}
							</script>
							<div id="chart_ins_9" style="height: 500px; width: 100%;"></div>
							
							
						</div>
					</div>
				</div>
			<?php } ?>
	
			
        </div>
	</div>
</div>         

<?php 
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
// Se trae un listado con los valores de las existencias actuales
$ano_pasado = ano_actual()-1;
$z = "WHERE idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."'";
$z.= " AND Creacion_ano >= ".$ano_pasado;
//se consulta
$arrExistencias = array();
$query = "SELECT Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor
FROM `bodegas_arriendos_facturacion_existencias`
".$join_3."
".$z."
".$where_3."
GROUP BY Creacion_ano,Creacion_mes,idTipo
ORDER BY Creacion_ano ASC, Creacion_mes ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrExistencias,$row );
}


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

<div class="clearfix"></div>
<h3 class="supertittle text-primary">Arriendos</h3>

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
