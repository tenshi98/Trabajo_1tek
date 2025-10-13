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
$original = "informe_gerencial_09.php";
$location = $original;
//Se agregan ubicaciones
$location .='?filtro=true';			
       
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
//Se definen las variables
if(isset($_GET['Ano'])){   $Ano = $_GET['Ano'];   } else { $Ano  = ano_actual();}


/**********************************************************/
//Solo compras pagadas totalmente
$z      = "idPago!=0";
$y      = "idExistencia!=0";
$w      = "idHistorial!=0";
$v      = "idHistorial!=0";
$search = '';
//filtro el año
if(isset($Ano)&&$Ano!=''){
	$z.=" AND F_Pago_ano=".$Ano;
	$y.=" AND contab_caja_gastos.Creacion_ano=".$Ano;
	$w.=" AND pagos_leyes_fiscales.Pago_ano=".$Ano;
	$v.=" AND pagos_leyes_sociales.Pago_ano=".$Ano;
	$search .= '&Ano='.simpleEncode($Ano, fecha_actual());
}
//Si se elije sistema
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){
	$z.=" AND idSistema=".$_GET['idSistema'];
	$y.=" AND contab_caja_gastos.idSistema=".$_GET['idSistema'];
	$w.=" AND pagos_leyes_fiscales.idSistema=".$_GET['idSistema'];
	$v.=" AND pagos_leyes_sociales.idSistema=".$_GET['idSistema'];
	$search .= '&idSistema='.simpleEncode($_GET['idSistema'], fecha_actual());
}
//agrupacion
$z.=" GROUP BY F_Pago_ano, F_Pago_mes, idDocPago ";
$y.=" GROUP BY contab_caja_gastos.Creacion_ano, contab_caja_gastos.Creacion_mes, contab_caja_gastos_existencias.idDocPago ";
$w.=" GROUP BY pagos_leyes_fiscales.Pago_ano, pagos_leyes_fiscales.Pago_mes, pagos_leyes_fiscales_formas_pago.idDocPago ";
$v.=" GROUP BY pagos_leyes_sociales.Pago_ano, pagos_leyes_sociales.Pago_mes, pagos_leyes_sociales_formas_pago.idDocPago ";
/*************************************************************************************************/
//filtro
$SIS_query = 'idDocPago,F_Pago_ano,F_Pago_mes,SUM(MontoPagado) AS Pagado';
//Pagos a Proveedores
$arrTemporal_1 = array();
$arrTemporal_1 = db_select_array (false, $SIS_query, 'pagos_facturas_proveedores', '', $z, 'idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_1');
//Pagos a Clientes
$arrTemporal_2 = array();
$arrTemporal_2 = db_select_array (false, $SIS_query, 'pagos_facturas_clientes', '', $z, 'idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_2');
//Pagos a trabajadores
$arrTemporal_3 = array();
$arrTemporal_3 = db_select_array (false, $SIS_query, 'pagos_rrhh_liquidaciones', '', $z, 'idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_3');
//Pagos boletas a trabajadores
$arrTemporal_4 = array();
$arrTemporal_4 = db_select_array (false, $SIS_query, 'pagos_boletas_trabajadores', '', $z, 'idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');
//Rendiciones
$SIS_query = 'contab_caja_gastos_existencias.idDocPago,contab_caja_gastos.Creacion_ano AS F_Pago_ano,contab_caja_gastos.Creacion_mes AS F_Pago_mes,SUM(contab_caja_gastos_existencias.Valor) AS Pagado';
$arrTemporal_5 = array();
$arrTemporal_5 = db_select_array (false, $SIS_query, 'contab_caja_gastos_existencias', 'LEFT JOIN contab_caja_gastos ON contab_caja_gastos.idFacturacion = contab_caja_gastos_existencias.idFacturacion', $y, 'contab_caja_gastos_existencias.idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_5');
//Pagos de impuestos
$SIS_query = 'pagos_leyes_fiscales_formas_pago.idDocPago,pagos_leyes_fiscales.Pago_ano AS F_Pago_ano,pagos_leyes_fiscales.Pago_mes AS F_Pago_mes,SUM(pagos_leyes_fiscales_formas_pago.Monto) AS Pagado';
$arrTemporal_6 = array();
$arrTemporal_6 = db_select_array (false, $SIS_query, 'pagos_leyes_fiscales_formas_pago', 'LEFT JOIN pagos_leyes_fiscales ON pagos_leyes_fiscales.idFactFiscal = pagos_leyes_fiscales_formas_pago.idFactFiscal', $w, 'pagos_leyes_fiscales_formas_pago.idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_6');
//Pagos de previred
$SIS_query = 'pagos_leyes_sociales_formas_pago.idDocPago,pagos_leyes_sociales.Pago_ano AS F_Pago_ano,pagos_leyes_sociales.Pago_mes AS F_Pago_mes,SUM(pagos_leyes_sociales_formas_pago.Monto) AS Pagado';
$arrTemporal_7 = array();
$arrTemporal_7 = db_select_array (false, $SIS_query, 'pagos_leyes_sociales_formas_pago', 'LEFT JOIN pagos_leyes_sociales ON pagos_leyes_sociales.idFactSocial = pagos_leyes_sociales_formas_pago.idFactSocial', $v, 'pagos_leyes_sociales_formas_pago.idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_7');



/*************************************************************/
//Listado de documentos
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, 'idDocPago, Nombre', 'sistema_documentos_pago', '', '', 'idDocPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDocumentos');

/*************************************************************/
//Se crea arreglo
$arrEgreso = array();
$arrIngreso = array();
for ($i = 1; $i <= 12; $i++) {
    $arrEgreso[$i]['Pagado']  = 0;
    $arrIngreso[$i]['Pagado'] = 0;
    //recorro los documentos
    foreach ($arrDocumentos as $doc) {
		$arrEgreso[$i][$doc['idDocPago']]['Pagado']  = 0;
		$arrIngreso[$i][$doc['idDocPago']]['Pagado'] = 0;
	}
}
/*************************************************************/


//recorro Pagos a Proveedores
foreach ($arrTemporal_1 as $temp) {
	$arrEgreso[$temp['F_Pago_mes']]['Pagado']                     = $arrEgreso[$temp['F_Pago_mes']]['Pagado'] + $temp['Pagado'];
	$arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] = $arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] + $temp['Pagado'];
}

//recorro Pagos a Clientes
foreach ($arrTemporal_2 as $temp) {
	$arrIngreso[$temp['F_Pago_mes']]['Pagado']                     = $arrIngreso[$temp['F_Pago_mes']]['Pagado'] + $temp['Pagado'];
	$arrIngreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] = $arrIngreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] + $temp['Pagado'];
}
//recorro Pagos a trabajadores
foreach ($arrTemporal_3 as $temp) {
	$arrEgreso[$temp['F_Pago_mes']]['Pagado']                     = $arrEgreso[$temp['F_Pago_mes']]['Pagado'] + $temp['Pagado'];
	$arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] = $arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] + $temp['Pagado'];
}
//recorro Pagos boletas a trabajadores
foreach ($arrTemporal_4 as $temp) {
	$arrEgreso[$temp['F_Pago_mes']]['Pagado']                     = $arrEgreso[$temp['F_Pago_mes']]['Pagado'] + $temp['Pagado'];
	$arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] = $arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] + $temp['Pagado'];
}
//recorro Rendiciones
foreach ($arrTemporal_5 as $temp) {
	$arrEgreso[$temp['F_Pago_mes']]['Pagado']                     = $arrEgreso[$temp['F_Pago_mes']]['Pagado'] + $temp['Pagado'];
	$arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] = $arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] + $temp['Pagado'];
}
//recorro Pagos de impuestos 
foreach ($arrTemporal_6 as $temp) {
	$arrEgreso[$temp['F_Pago_mes']]['Pagado']                     = $arrEgreso[$temp['F_Pago_mes']]['Pagado'] + $temp['Pagado'];
	$arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] = $arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] + $temp['Pagado'];
}
//recorro Pagos de previred
foreach ($arrTemporal_7 as $temp) {
	$arrEgreso[$temp['F_Pago_mes']]['Pagado']                     = $arrEgreso[$temp['F_Pago_mes']]['Pagado'] + $temp['Pagado'];
	$arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] = $arrEgreso[$temp['F_Pago_mes']][$temp['idDocPago']]['Pagado'] + $temp['Pagado'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="">
		<div id="calendar_content" class="body">
			<div id="calendar" class="fc fc-ltr">
				<table class="fc-header" style="width:100%">
					<tbody>
						<tr>
							<?php
							if(isset($_GET['Ano'])){
								$Ano_a  = $_GET['Ano'] - 1;
								$Ano_b  = $_GET['Ano'] + 1;	
							} else {
								$Ano_a  = ano_actual() - 1;
								$Ano_b  = ano_actual() + 1;
							}
							?>
							<td class="fc-header-left"><a href="<?php echo '?submit_filter=Filtrar&Ano='.$Ano_a.'&idSistema='.$_GET['idSistema'] ?>" class="btn btn-default"><i class="fa fa-angle-left faa-horizontal animated" aria-hidden="true"></i></a></td>
							<td class="fc-header-center"><span class="fc-header-title"><h2>Flujo de Caja <?php echo $Ano?></h2></span></td>
							<td class="fc-header-right"><a href="<?php echo '?submit_filter=Filtrar&Ano='.$Ano_b.'&idSistema='.$_GET['idSistema'] ?>" class="btn btn-default"><i class="fa fa-angle-right faa-horizontal animated" aria-hidden="true"></i></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table']});</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="#tab2" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Egreso</a></li>
				<li class=""><a href="#tab3" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Ingreso</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="tab1">
				<div class="wmd-panel">
					<div class="table-responsive">

						<script>
							
							google.charts.setOnLoadCallback(drawColColors);

							function drawColColors() {
								var data = new google.visualization.DataTable();
								data.addColumn('string', 'Meses');
								data.addColumn('number', 'Ingresos');
								data.addColumn('number', 'Egresos');

								data.addRows([
									['Enero',  <?php echo $arrIngreso[1]['Pagado']; ?>,  <?php echo $arrEgreso[1]['Pagado']; ?>],
									['Febrero',  <?php echo $arrIngreso[2]['Pagado']; ?>,  <?php echo $arrEgreso[2]['Pagado']; ?>],
									['Marzo',  <?php echo $arrIngreso[3]['Pagado']; ?>,  <?php echo $arrEgreso[3]['Pagado']; ?>],
									['Abril',  <?php echo $arrIngreso[4]['Pagado']; ?>,  <?php echo $arrEgreso[4]['Pagado']; ?>],
									['Mayo',  <?php echo $arrIngreso[5]['Pagado']; ?>,  <?php echo $arrEgreso[5]['Pagado']; ?>],
									['Junio',  <?php echo $arrIngreso[6]['Pagado']; ?>,  <?php echo $arrEgreso[6]['Pagado']; ?>],
									['Julio',  <?php echo $arrIngreso[7]['Pagado']; ?>,  <?php echo $arrEgreso[7]['Pagado']; ?>],
									['Agosto',  <?php echo $arrIngreso[8]['Pagado']; ?>,  <?php echo $arrEgreso[8]['Pagado']; ?>],
									['Septiembre',  <?php echo $arrIngreso[9]['Pagado']; ?>,  <?php echo $arrEgreso[9]['Pagado']; ?>],
									['Octubre',  <?php echo $arrIngreso[10]['Pagado']; ?>,  <?php echo $arrEgreso[10]['Pagado']; ?>],
									['Noviembre',  <?php echo $arrIngreso[11]['Pagado']; ?>,  <?php echo $arrEgreso[11]['Pagado']; ?>],
									['Diciembre',  <?php echo $arrIngreso[12]['Pagado']; ?>,  <?php echo $arrEgreso[12]['Pagado']; ?>],
								]);

								var options = {
									title: 'Flujo de caja',
									colors: ['#0099e5', '#ff4c4c'],
									hAxis: {
										title: 'Meses',
									},
									vAxis: {
										title: 'Pesos'
									}
								};

								var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
								chart.draw(data, options);
							}
						</script>
						<div id="chart_div" style="height: 500px; width: 100%;"></div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="box">
								<header>
									<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen General</h5>
								</header>
								<div class="table-responsive">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th>Mes</th>
												<th>Ingresos</th>
												<th>Egresos</th>
												<th>Total</th>
												<th>Acumulado</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all">
											<?php
											$Total_1  = $arrIngreso[1]['Pagado'] - $arrEgreso[1]['Pagado'];
											$Total_2  = $arrIngreso[2]['Pagado'] - $arrEgreso[2]['Pagado'];
											$Total_3  = $arrIngreso[3]['Pagado'] - $arrEgreso[3]['Pagado'];
											$Total_4  = $arrIngreso[4]['Pagado'] - $arrEgreso[4]['Pagado'];
											$Total_5  = $arrIngreso[5]['Pagado'] - $arrEgreso[5]['Pagado'];
											$Total_6  = $arrIngreso[6]['Pagado'] - $arrEgreso[6]['Pagado'];
											$Total_7  = $arrIngreso[7]['Pagado'] - $arrEgreso[7]['Pagado'];
											$Total_8  = $arrIngreso[8]['Pagado'] - $arrEgreso[8]['Pagado'];
											$Total_9  = $arrIngreso[9]['Pagado'] - $arrEgreso[9]['Pagado'];
											$Total_10 = $arrIngreso[10]['Pagado'] - $arrEgreso[10]['Pagado'];
											$Total_11 = $arrIngreso[11]['Pagado'] - $arrEgreso[11]['Pagado'];
											$Total_12 = $arrIngreso[12]['Pagado'] - $arrEgreso[12]['Pagado'];
											
											$total_gen_ing = $arrIngreso[1]['Pagado'] + $arrIngreso[2]['Pagado'] + $arrIngreso[3]['Pagado'] + $arrIngreso[4]['Pagado'] + $arrIngreso[5]['Pagado'] + $arrIngreso[6]['Pagado'] + $arrIngreso[7]['Pagado'] + $arrIngreso[8]['Pagado'] + $arrIngreso[9]['Pagado'] + $arrIngreso[10]['Pagado'] + $arrIngreso[11]['Pagado'] + $arrIngreso[12]['Pagado'];
											$total_gen_eg  = $arrEgreso[1]['Pagado'] + $arrEgreso[2]['Pagado'] + $arrEgreso[3]['Pagado'] + $arrEgreso[4]['Pagado'] + $arrEgreso[5]['Pagado'] + $arrEgreso[6]['Pagado'] + $arrEgreso[7]['Pagado'] + $arrEgreso[8]['Pagado'] + $arrEgreso[9]['Pagado'] + $arrEgreso[10]['Pagado'] + $arrEgreso[11]['Pagado'] + $arrEgreso[12]['Pagado'];
											$total_gen     = $total_gen_ing - $total_gen_eg;
											
											$Acumulado_1 = $Total_1;
											$Acumulado_2  = $Acumulado_1 + $Total_2;
											$Acumulado_3  = $Acumulado_2 + $Total_3;
											$Acumulado_4  = $Acumulado_3 + $Total_4;
											$Acumulado_5  = $Acumulado_4 + $Total_5;
											$Acumulado_6  = $Acumulado_5 + $Total_6;
											$Acumulado_7  = $Acumulado_6 + $Total_7;
											$Acumulado_8  = $Acumulado_7 + $Total_8;
											$Acumulado_9  = $Acumulado_8 + $Total_9;
											$Acumulado_10 = $Acumulado_9 + $Total_10;
											$Acumulado_11 = $Acumulado_10 + $Total_11;
											$Acumulado_12 = $Acumulado_11 + $Total_12;

											?>
										
											
											<tr class="odd"><td>Enero      <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 1, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 1, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[1]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 1, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[1]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_1>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_1>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_1, 0); ?></td>   <td align="right" <?php if($Acumulado_1>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_1>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_1, 0) ?></td></tr>
											<tr class="odd"><td>Febrero    <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 2, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 2, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[2]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 2, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[2]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_2>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_2>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_2, 0); ?></td>   <td align="right" <?php if($Acumulado_2>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_2>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_2, 0) ?></td></tr>
											<tr class="odd"><td>Marzo      <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 3, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 3, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[3]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 3, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[3]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_3>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_3>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_3, 0); ?></td>   <td align="right" <?php if($Acumulado_3>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_3>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_3, 0) ?></td></tr>
											<tr class="odd"><td>Abril      <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 4, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 4, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[4]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 4, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[4]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_4>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_4>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_4, 0); ?></td>   <td align="right" <?php if($Acumulado_4>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_4>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_4, 0) ?></td></tr>
											<tr class="odd"><td>Mayo       <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 5, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 5, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[5]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 5, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[5]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_5>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_5>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_5, 0); ?></td>   <td align="right" <?php if($Acumulado_5>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_5>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_5, 0) ?></td></tr>
											<tr class="odd"><td>Junio      <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 6, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 6, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[6]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 6, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[6]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_6>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_6>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_6, 0); ?></td>   <td align="right" <?php if($Acumulado_6>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_6>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_6, 0) ?></td></tr>
											<tr class="odd"><td>Julio      <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 7, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 7, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[7]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 7, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[7]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_7>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_7>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_7, 0); ?></td>   <td align="right" <?php if($Acumulado_7>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_7>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_7, 0) ?></td></tr>
											<tr class="odd"><td>Agosto     <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 8, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 8, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[8]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 8, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[8]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_8>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_8>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_8, 0); ?></td>   <td align="right" <?php if($Acumulado_8>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_8>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_8, 0) ?></td></tr>
											<tr class="odd"><td>Septiembre <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 9, fecha_actual()).$search; ?>"  title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 9, fecha_actual()).$search; ?>"  title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[9]['Pagado'], 0); ?></a></div></td>   <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 9, fecha_actual()).$search; ?>"  title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[9]['Pagado'], 0); ?></a></div></td>   <td align="right" <?php if($Total_9>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_9>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_9, 0); ?></td>   <td align="right" <?php if($Acumulado_9>=0){ echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_9>=0){ echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_9, 0) ?></td></tr>
											<tr class="odd"><td>Octubre    <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 10, fecha_actual()).$search; ?>" title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 10, fecha_actual()).$search; ?>" title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[10]['Pagado'], 0); ?></a></div></td>  <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 10, fecha_actual()).$search; ?>" title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[10]['Pagado'], 0); ?></a></div></td>  <td align="right" <?php if($Total_10>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_10>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_10, 0); ?></td>  <td align="right" <?php if($Acumulado_10>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_10>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_10, 0) ?></td></tr>
											<tr class="odd"><td>Noviembre  <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 11, fecha_actual()).$search; ?>" title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 11, fecha_actual()).$search; ?>" title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[11]['Pagado'], 0); ?></a></div></td>  <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 11, fecha_actual()).$search; ?>" title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[11]['Pagado'], 0); ?></a></div></td>  <td align="right" <?php if($Total_11>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_11>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_11, 0); ?></td>  <td align="right" <?php if($Acumulado_11>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_11>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_11, 0) ?></td></tr>
											<tr class="odd"><td>Diciembre  <div class="btn-group pull-right" style="width: 35px;" ><a href="<?php echo 'informe_gerencial_09_view.php?type=1&mes='.simpleEncode( 12, fecha_actual()).$search; ?>" title="Ver Detalle del Mes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div></td> <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=2&mes='.simpleEncode( 12, fecha_actual()).$search; ?>" title="Ver Detalle de los ingresos del Mes" class="iframe tooltip color-blue" style="font-size: 14px;position: initial;"><?php echo valores($arrIngreso[12]['Pagado'], 0); ?></a></div></td>  <td><div class="pull-right"><a href="<?php echo 'informe_gerencial_09_view.php?type=3&mes='.simpleEncode( 12, fecha_actual()).$search; ?>" title="Ver Detalle de los egresos del Mes" class="iframe tooltip color-red" style="font-size: 14px;position: initial;"><?php echo valores($arrEgreso[12]['Pagado'], 0); ?></a></div></td>  <td align="right" <?php if($Total_12>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Total_12>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Total_12, 0); ?></td>  <td align="right" <?php if($Acumulado_12>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><?php if($Acumulado_12>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_12, 0) ?></td></tr>
											
											<tr class="odd">
												<td><strong>Totales</strong></td>    
												<td align="right" class="color-blue"><strong><?php echo valores($total_gen_ing, 0); ?></strong></td>             
												<td align="right" class="color-red"><strong><?php echo valores($total_gen_eg, 0); ?></strong></td>            
												<td align="right" <?php if($total_gen>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><strong><?php if($total_gen>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($total_gen, 0); ?></strong></td>
												<td align="right" <?php if($Acumulado_12>=0){echo 'class="color-blue"';}else{echo 'class="color-red"';} ?>><strong><?php if($Acumulado_12>=0){echo '<i class="fa fa-arrow-up" aria-hidden="true"></i>';}else{echo '<i class="fa fa-arrow-down" aria-hidden="true"></i>';} ?> <?php echo valores($Acumulado_12, 0); ?></strong></td>
											</tr>
										</tbody>
									</table>
								</div>
		
							</div>
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
								
								
								var data = new google.visualization.DataTable();
								  data.addColumn('string', 'Meses');
								  <?php foreach ($arrDocumentos as $doc) { ?>
									data.addColumn('number', '<?php echo $doc['Nombre']; ?>');
								  <?php } ?>

								  data.addRows([
									<?php for ($i = 1; $i <= 12; $i++) { ?>
										['<?php echo numero_a_mes_corto($i); ?>'
										<?php foreach ($arrDocumentos as $doc) { ?>
											, <?php echo $arrEgreso[$i][$doc['idDocPago']]['Pagado']; ?>
										<?php } ?>
										],
									<?php } ?>
									
								  ]);

								  var options = {
									title: 'Egresos',
									isStacked: true,
									hAxis: {
									  title: '',
									},
									vAxis: {
									  title: 'Montos $', minValue: 0
									}
								  };

								  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_2'));
								  chart.draw(data, options);		
								  var table_2 = new google.visualization.Table(document.getElementById('table_div_2'));
								  table_2.draw(data, {showRowNumber: true, width: '100%', height: '100%'});	
							}
						</script>
						<div id="chart_div_2" style="height: 500px; width: 100%;"></div>
						<div id="table_div_2" ></div>		
							
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="tab3">
				<div class="wmd-panel">
					<div class="table-responsive">

						<script>
								
							google.charts.setOnLoadCallback(drawChart2);

							function drawChart2() {
								
								
								var data = new google.visualization.DataTable();
								  data.addColumn('string', 'Meses');
								  <?php foreach ($arrDocumentos as $doc) { ?>
									data.addColumn('number', '<?php echo $doc['Nombre']; ?>');
								  <?php } ?>

								  data.addRows([
									<?php for ($i = 1; $i <= 12; $i++) { ?>
										['<?php echo numero_a_mes_corto($i); ?>'
										<?php foreach ($arrDocumentos as $doc) { ?>
											, <?php echo $arrIngreso[$i][$doc['idDocPago']]['Pagado']; ?>
										<?php } ?>
										],
									<?php } ?>
									
								  ]);

								  var options = {
									title: 'Ingresos',
									isStacked: true,
									hAxis: {
									  title: '',
									},
									vAxis: {
									  title: 'Montos $', minValue: 0
									}
								  };

								  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_3'));
								  chart.draw(data, options);
								  var table_3 = new google.visualization.Table(document.getElementById('table_div_3'));
								  table_3.draw(data, {showRowNumber: true, width: '100%', height: '100%'});

							}
						</script>
						<div id="chart_div_3" style="height: 500px; width: 100%;"></div>
						<div id="table_div_3" ></div>	
							
					</div>
				</div>
			</div>
			

			
        </div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{ ?>

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
				if(isset($idSistema)){   $x1  = $idSistema;      }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Sistemas','idSistema', $x1, 2, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);
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
