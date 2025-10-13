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
$original = "informe_gerencial_13.php";
$location = $original;
//Se agregan ubicaciones
$location .='?submit_filter=Filtrar';			
       
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
if(!empty($_GET['details_mensual'])){
//Solo compras pagadas totalmente
$z1 = "WHERE bodegas_arriendos_facturacion.idTipo=2"; //solo ventas
$z2 = "WHERE bodegas_insumos_facturacion.idTipo=2";   //solo ventas
$z3 = "WHERE bodegas_productos_facturacion.idTipo=2"; //solo ventas
$z4 = "WHERE bodegas_servicios_facturacion.idTipo=2"; //solo ventas
//sololas del mismo sistema
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//variable 
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];

if(isset($_GET['details_mensual'])&&$_GET['details_mensual']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idCliente=".$_GET['details_mensual'];
	$z2.=" AND bodegas_insumos_facturacion.idCliente=".$_GET['details_mensual'];
	$z3.=" AND bodegas_productos_facturacion.idCliente=".$_GET['details_mensual'];
	$z4.=" AND bodegas_servicios_facturacion.idCliente=".$_GET['details_mensual'];
	$search .="&idCliente=".$_GET['details_mensual'];
}
if(isset($Ano)&&$Ano!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_ano=".$Ano;
	$z2.=" AND bodegas_insumos_facturacion.Creacion_ano=".$Ano;
	$z3.=" AND bodegas_productos_facturacion.Creacion_ano=".$Ano;
	$z4.=" AND bodegas_servicios_facturacion.Creacion_ano=".$Ano;
	$location .="&Creacion_ano=".$Ano;
	$search .="&Creacion_ano=".$Ano;
}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$location .="&idCliente=".$_GET['idCliente'];
	$search .="&idCliente=".$_GET['idCliente'];
}

/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idCliente,
bodegas_arriendos_facturacion.Creacion_mes,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_arriendos_facturacion.idCliente
".$z1."
GROUP BY bodegas_arriendos_facturacion.idCliente, bodegas_arriendos_facturacion.Creacion_mes
ORDER BY bodegas_arriendos_facturacion.Creacion_mes DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_1,$row );
}

/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal_2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idCliente,
bodegas_insumos_facturacion.Creacion_mes,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_insumos_facturacion.idCliente
".$z2."
GROUP BY bodegas_insumos_facturacion.idCliente, bodegas_insumos_facturacion.Creacion_mes
ORDER BY bodegas_insumos_facturacion.Creacion_mes DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_2,$row );
}

/*************************************************************************************************/
//Bodega de Productos
$arrTemporal_3 = array();
$query = "SELECT 
bodegas_productos_facturacion.idCliente,
bodegas_productos_facturacion.Creacion_mes,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_productos_facturacion.idCliente
".$z3."
GROUP BY bodegas_productos_facturacion.idCliente, bodegas_productos_facturacion.Creacion_mes
ORDER BY bodegas_productos_facturacion.Creacion_mes DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_3,$row );
}

/*************************************************************************************************/
//Bodega de Servicios
$arrTemporal_4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idCliente,
bodegas_servicios_facturacion.Creacion_mes,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_servicios_facturacion.idCliente
".$z4."
GROUP BY bodegas_servicios_facturacion.idCliente, bodegas_servicios_facturacion.Creacion_mes
ORDER BY bodegas_servicios_facturacion.Creacion_mes DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_4,$row );
}
//Dejarlo, sin esto no se ejecuta codigo
echo '<span style="display:none">'.$query.'</span>';
/*************************************************************************************************/
//Se crea arreglo
$arrCreativo = array();
foreach ($arrTemporal_1 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                             = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                             = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                             = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                             = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_mes']]['Total_4']         = $temp['ValorTotal'];
}
/*************************************************************************************************/

//Variables
$Neto_1 = 0;
$Neto_2 = 0;
$Neto_3 = 0;
$Neto_4 = 0;

$Total_1 = 0;
$Total_2 = 0;
$Total_3 = 0;
$Total_4 = 0;


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_gerencial_13_to_excel_4.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#netos" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Netos</a></li>
				<li class=""><a href="#totales" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Totales</a></li>
			</ul>
		</header>
        <div class="tab-content">
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart']});</script>

			<div class="tab-pane fade active in" id="netos" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Mes');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $datais) { 
								foreach ($datais as $prod) {
									if(isset($prod['Creacion_mes'])&&$prod['Creacion_mes']!=''&&$prod['Creacion_mes']!=0){
										// subtotales
										$sub = 0;
										if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
										if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
										if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
										if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
								?>
								["<?php echo numero_a_mes($prod['Creacion_mes']); ?>", <?php echo valores_enteros($sub) ?>],
							<?php }}} ?>
						]);

						var options = {
							title: 'Grafico Compras Netos',
							legend: { position: 'none' },
							hAxis: { title: 'Mes', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_1'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_1" style="height: 500px; width: 100%;"></div>

			</div>
			<div class="tab-pane fade" id="totales" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Mes');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $datais) { 
								foreach ($datais as $prod) {
									if(isset($prod['Creacion_mes'])&&$prod['Creacion_mes']!=''&&$prod['Creacion_mes']!=0){
										// subtotales
										$sub = 0;
										if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
										if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
										if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
										if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
								?>
								["<?php echo numero_a_mes($prod['Creacion_mes']); ?>", <?php echo valores_enteros($sub) ?>],
							<?php }}} ?>
						]);

						var options = {
							title: 'Grafico Compras Totales',
							legend: { position: 'none' },
							hAxis: { title: 'Mes', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_2'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_2" style="height: 500px; width: 100%;"></div>

			</div>
			
        </div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ventas Clientes por mes</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th></th>
						<th></th>
						<th colspan="5" style="text-align: center;">Netos</th>
						<th colspan="5" style="text-align: center;">Totales</th>
					</tr>
					<tr role="row">
						<th>Cliente</th>
						<th>Mes</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCreativo as $datais) { ?>
						<tr class="odd"><td align="left" colspan="12" style="background-color: #BFBFBF;"><strong><?php echo $datais[0]['Cliente']; ?></strong></td></tr>
						<?php foreach ($datais as $prod) { ?>
							<?php if(isset($prod['Creacion_mes'])&&$prod['Creacion_mes']!=''&&$prod['Creacion_mes']!=0){ ?>
							<tr class="odd">
								<td align="left"></td>
								<td align="left"><?php echo numero_a_mes($prod['Creacion_mes']); ?></td>

								<td align="right"><?php if(isset($prod['Neto_1'])){echo valores($prod['Neto_1'],0);$Neto_1 = $Neto_1 + $prod['Neto_1'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_2'])){echo valores($prod['Neto_2'],0);$Neto_2 = $Neto_2 + $prod['Neto_2'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_3'])){echo valores($prod['Neto_3'],0);$Neto_3 = $Neto_3 + $prod['Neto_3'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_4'])){echo valores($prod['Neto_4'],0);$Neto_4 = $Neto_4 + $prod['Neto_4'];} ?></td>
								<td align="right">
									<?php
									// subtotales
									$sub = 0;
									if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
									if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
									if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
									if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
									echo valores($sub,0); 
									?>
								</td>

								<td align="right"><?php if(isset($prod['Total_1'])){echo valores($prod['Total_1'],0);$Total_1 = $Total_1 + $prod['Total_1'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_2'])){echo valores($prod['Total_2'],0);$Total_2 = $Total_2 + $prod['Total_2'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_3'])){echo valores($prod['Total_3'],0);$Total_3 = $Total_3 + $prod['Total_3'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_4'])){echo valores($prod['Total_4'],0);$Total_4 = $Total_4 + $prod['Total_4'];} ?></td>
								<td align="right">
									<?php
									// subtotales
									$sub = 0;
									if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
									if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
									if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
									if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
									echo valores($sub,0); 
									?>
								</td>

							</tr>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					
				  
					
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right" colspan="2"><strong>Totales</strong></td>    
						
						<td align="right"><strong><?php echo Valores($Neto_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>

						<td align="right"><strong><?php echo Valores($Total_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>

					</tr>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right" colspan="2"><strong>Totales Generales</strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>
					</tr>
			                   
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
}elseif(!empty($_GET['details_diario'])){
//Solo compras pagadas totalmente
$z1 = "WHERE bodegas_arriendos_facturacion.idTipo=2"; //solo ventas
$z2 = "WHERE bodegas_insumos_facturacion.idTipo=2";   //solo ventas
$z3 = "WHERE bodegas_productos_facturacion.idTipo=2"; //solo ventas
$z4 = "WHERE bodegas_servicios_facturacion.idTipo=2"; //solo ventas
//sololas del mismo sistema
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//variable 
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];

if(isset($_GET['details_diario'])&&$_GET['details_diario']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idCliente=".$_GET['details_diario'];
	$z2.=" AND bodegas_insumos_facturacion.idCliente=".$_GET['details_diario'];
	$z3.=" AND bodegas_productos_facturacion.idCliente=".$_GET['details_diario'];
	$z4.=" AND bodegas_servicios_facturacion.idCliente=".$_GET['details_diario'];
	$search .="&idCliente=".$_GET['details_diario'];
}
if(isset($Ano)&&$Ano!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_ano=".$Ano;
	$z2.=" AND bodegas_insumos_facturacion.Creacion_ano=".$Ano;
	$z3.=" AND bodegas_productos_facturacion.Creacion_ano=".$Ano;
	$z4.=" AND bodegas_servicios_facturacion.Creacion_ano=".$Ano;
	$location .="&Creacion_ano=".$Ano;
	$search .="&Creacion_ano=".$Ano;
}

if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$location .="&idCliente=".$_GET['idCliente'];
	$search .="&idCliente=".$_GET['idCliente'];
}
		

			
		
				
/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idCliente,
bodegas_arriendos_facturacion.Creacion_fecha,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_arriendos_facturacion.idCliente
".$z1."
GROUP BY bodegas_arriendos_facturacion.idCliente, bodegas_arriendos_facturacion.Creacion_fecha
ORDER BY bodegas_arriendos_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_1,$row );
}
/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal_2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idCliente,
bodegas_insumos_facturacion.Creacion_fecha,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_insumos_facturacion.idCliente
".$z2."
GROUP BY bodegas_insumos_facturacion.idCliente, bodegas_insumos_facturacion.Creacion_fecha
ORDER BY bodegas_insumos_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_2,$row );
}
/*************************************************************************************************/
//Bodega de Productos
$arrTemporal_3 = array();
$query = "SELECT 
bodegas_productos_facturacion.idCliente,
bodegas_productos_facturacion.Creacion_fecha,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_productos_facturacion.idCliente
".$z3."
GROUP BY bodegas_productos_facturacion.idCliente, bodegas_productos_facturacion.Creacion_fecha
ORDER BY bodegas_productos_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_3,$row );
}
/*************************************************************************************************/
//Bodega de Servicios
$arrTemporal_4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idCliente,
bodegas_servicios_facturacion.Creacion_fecha,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_servicios_facturacion.idCliente
".$z4."
GROUP BY bodegas_servicios_facturacion.idCliente, bodegas_servicios_facturacion.Creacion_fecha
ORDER BY bodegas_servicios_facturacion.Creacion_fecha DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_4,$row );
}
/*************************************************************************************************/
//Se crea arreglo
$arrCreativo = array();
foreach ($arrTemporal_1 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                               = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                               = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Neto_2']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Total_2']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                               = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                               = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_fecha']]['Total_4']         = $temp['ValorTotal'];
}
/*************************************************************************************************/

//Variables
$Neto_1 = 0;
$Neto_2 = 0;
$Neto_3 = 0;
$Neto_4 = 0;

$Total_1 = 0;
$Total_2 = 0;
$Total_3 = 0;
$Total_4 = 0;

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_gerencial_13_to_excel_3.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#netos" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Netos</a></li>
				<li class=""><a href="#totales" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Totales</a></li>
			</ul>
		</header>
        <div class="tab-content">
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart']});</script>

			<div class="tab-pane fade active in" id="netos" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Fecha');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $datais) { 
								foreach ($datais as $prod) {
									if(isset($prod['Creacion_fecha'])&&$prod['Creacion_fecha']!='0000-00-00'){
										// subtotales
										$sub = 0;
										if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
										if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
										if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
										if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
										?>
								["<?php echo Fecha_estandar($prod['Creacion_fecha']); ?>", <?php echo valores_enteros($sub) ?>],
							<?php }}} ?>
						]);

						var options = {
							title: 'Grafico Compras Netos',
							legend: { position: 'none' },
							hAxis: { title: 'Fecha', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_1'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_1" style="height: 500px; width: 100%;"></div>

			</div>
			<div class="tab-pane fade" id="totales" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Fecha');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $datais) { 
								foreach ($datais as $prod) {
									if(isset($prod['Creacion_fecha'])&&$prod['Creacion_fecha']!='0000-00-00'){
										// subtotales
										$sub = 0;
										if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
										if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
										if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
										if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
										?>
								["<?php echo Fecha_estandar($prod['Creacion_fecha']); ?>", <?php echo valores_enteros($sub) ?>],
							<?php }}} ?>
						]);

						var options = {
							title: 'Grafico Compras Totales',
							legend: { position: 'none' },
							hAxis: { title: 'Fecha', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_2'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_2" style="height: 500px; width: 100%;"></div>

			</div>
			
        </div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ventas Clientes Por dia</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th></th>
						<th></th>
						<th colspan="5" style="text-align: center;">Netos</th>
						<th colspan="5" style="text-align: center;">Totales</th>
					</tr>
					<tr role="row">
						<th>Cliente</th>
						<th>Fecha</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCreativo as $datais) { ?>
						<tr class="odd"><td align="left" colspan="12" style="background-color: #BFBFBF;"><strong><?php echo $datais[0]['Cliente']; ?></strong></td></tr>
						<?php foreach ($datais as $prod) { ?>
							<?php if(isset($prod['Creacion_fecha'])&&$prod['Creacion_fecha']!='0000-00-00'){ ?>
							<tr class="odd">
								<td align="left"></td>
								<td align="left"><?php echo Fecha_estandar($prod['Creacion_fecha']); ?></td>

								<td align="right"><?php if(isset($prod['Neto_1'])){echo valores($prod['Neto_1'],0);$Neto_1 = $Neto_1 + $prod['Neto_1'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_2'])){echo valores($prod['Neto_2'],0);$Neto_2 = $Neto_2 + $prod['Neto_2'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_3'])){echo valores($prod['Neto_3'],0);$Neto_3 = $Neto_3 + $prod['Neto_3'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_4'])){echo valores($prod['Neto_4'],0);$Neto_4 = $Neto_4 + $prod['Neto_4'];} ?></td>
								<td align="right">
									<?php
									// subtotales
									$sub = 0;
									if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
									if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
									if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
									if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
									echo valores($sub,0); 
									?>
								</td>

								<td align="right"><?php if(isset($prod['Total_1'])){echo valores($prod['Total_1'],0);$Total_1 = $Total_1 + $prod['Total_1'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_2'])){echo valores($prod['Total_2'],0);$Total_2 = $Total_2 + $prod['Total_2'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_3'])){echo valores($prod['Total_3'],0);$Total_3 = $Total_3 + $prod['Total_3'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_4'])){echo valores($prod['Total_4'],0);$Total_4 = $Total_4 + $prod['Total_4'];} ?></td>
								<td align="right">
									<?php
									// subtotales
									$sub = 0;
									if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
									if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
									if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
									if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
									echo valores($sub,0); 
									?>
								</td>

							</tr>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					
				  
					
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right" colspan="2"><strong>Totales</strong></td>
						<td align="right"><strong><?php echo Valores($Neto_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>

						<td align="right"><strong><?php echo Valores($Total_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>

					</tr>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right" colspan="2"><strong>Totales Generales</strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>
					</tr>
			                   
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

}elseif(!empty($_GET['details_semanal'])){
//Solo compras pagadas totalmente
$z1 = "WHERE bodegas_arriendos_facturacion.idTipo=2"; //solo ventas
$z2 = "WHERE bodegas_insumos_facturacion.idTipo=2";   //solo ventas
$z3 = "WHERE bodegas_productos_facturacion.idTipo=2"; //solo ventas
$z4 = "WHERE bodegas_servicios_facturacion.idTipo=2"; //solo ventas
//sololas del mismo sistema
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//variable 
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];

if(isset($_GET['details_semanal'])&&$_GET['details_semanal']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idCliente=".$_GET['details_semanal'];
	$z2.=" AND bodegas_insumos_facturacion.idCliente=".$_GET['details_semanal'];
	$z3.=" AND bodegas_productos_facturacion.idCliente=".$_GET['details_semanal'];
	$z4.=" AND bodegas_servicios_facturacion.idCliente=".$_GET['details_semanal'];
	$search .="&idCliente=".$_GET['details_semanal'];
}
if(isset($Ano)&&$Ano!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_ano=".$Ano;
	$z2.=" AND bodegas_insumos_facturacion.Creacion_ano=".$Ano;
	$z3.=" AND bodegas_productos_facturacion.Creacion_ano=".$Ano;
	$z4.=" AND bodegas_servicios_facturacion.Creacion_ano=".$Ano;
	$location .="&Creacion_ano=".$Ano;
	$search .="&Creacion_ano=".$Ano;
}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$location .="&idCliente=".$_GET['idCliente'];
	$search .="&idCliente=".$_GET['idCliente'];
}

/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idCliente,
bodegas_arriendos_facturacion.Creacion_Semana,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_arriendos_facturacion.idCliente
".$z1."
GROUP BY bodegas_arriendos_facturacion.idCliente, bodegas_arriendos_facturacion.Creacion_Semana
ORDER BY bodegas_arriendos_facturacion.Creacion_Semana DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_1,$row );
}

/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal_2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idCliente,
bodegas_insumos_facturacion.Creacion_Semana,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_insumos_facturacion.idCliente
".$z2."
GROUP BY bodegas_insumos_facturacion.idCliente, bodegas_insumos_facturacion.Creacion_Semana
ORDER BY bodegas_insumos_facturacion.Creacion_Semana DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_2,$row );
}

/*************************************************************************************************/
//Bodega de Productos
$arrTemporal_3 = array();
$query = "SELECT 
bodegas_productos_facturacion.idCliente,
bodegas_productos_facturacion.Creacion_Semana,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_productos_facturacion.idCliente
".$z3."
GROUP BY bodegas_productos_facturacion.idCliente, bodegas_productos_facturacion.Creacion_Semana
ORDER BY bodegas_productos_facturacion.Creacion_Semana DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_3,$row );
}

/*************************************************************************************************/
//Bodega de Servicios
$arrTemporal_4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idCliente,
bodegas_servicios_facturacion.Creacion_Semana,
clientes_listado.Nombre AS ClienteNombre,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_servicios_facturacion.idCliente
".$z4."
GROUP BY bodegas_servicios_facturacion.idCliente, bodegas_servicios_facturacion.Creacion_Semana
ORDER BY bodegas_servicios_facturacion.Creacion_Semana DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_4,$row );
}
//Dejarlo, sin esto no se ejecuta codigo
echo '<span style="display:none">'.$query.'</span>';
/*************************************************************************************************/
//Se crea arreglo
$arrCreativo = array();
foreach ($arrTemporal_1 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                                = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                                = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                                = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Total_3']         = $temp['ValorTotal'];
}
//
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idCliente']][0]['Cliente']                                = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['idCliente']       = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']][$temp['Creacion_Semana']]['Total_4']         = $temp['ValorTotal'];
}
/*************************************************************************************************/

//Variables
$Neto_1 = 0;
$Neto_2 = 0;
$Neto_3 = 0;
$Neto_4 = 0;

$Total_1 = 0;
$Total_2 = 0;
$Total_3 = 0;
$Total_4 = 0;


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_gerencial_13_to_excel_2.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#netos" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Netos</a></li>
				<li class=""><a href="#totales" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Totales</a></li>
			</ul>
		</header>
        <div class="tab-content">
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart']});</script>

			<div class="tab-pane fade active in" id="netos" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Semana');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $datais) {
								foreach ($datais as $prod) {
									if(isset($prod['Creacion_Semana'])&&$prod['Creacion_Semana']!=''&&$prod['Creacion_Semana']!=0){
										// subtotales
										$sub = 0;
										if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
										if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
										if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
										if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
										?>
								["<?php echo $prod['Creacion_Semana']; ?>", <?php echo valores_enteros($sub) ?>],
							<?php }}} ?>
						]);

						var options = {
							title: 'Grafico Compras Netos',
							legend: { position: 'none' },
							hAxis: { title: 'Semana', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_1'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_1" style="height: 500px; width: 100%;"></div>

			</div>
			<div class="tab-pane fade" id="totales" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Semana');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $datais) {
								foreach ($datais as $prod) {
									if(isset($prod['Creacion_Semana'])&&$prod['Creacion_Semana']!=''&&$prod['Creacion_Semana']!=0){
										// subtotales
										$sub = 0;
										if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
										if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
										if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
										if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
										?>
								["<?php echo $prod['Creacion_Semana']; ?>", <?php echo valores_enteros($sub) ?>],
							<?php }}} ?>
						]);

						var options = {
							title: 'Grafico Compras Totales',
							legend: { position: 'none' },
							hAxis: { title: 'Semana', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_2'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_2" style="height: 500px; width: 100%;"></div>

			</div>
			
        </div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ventas Clientes por semana</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th></th>
						<th></th>
						<th colspan="5" style="text-align: center;">Netos</th>
						<th colspan="5" style="text-align: center;">Totales</th>
					</tr>
					<tr role="row">
						<th>Cliente</th>
						<th>Semana</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCreativo as $datais) { ?>
						<tr class="odd"><td align="left" colspan="12" style="background-color: #BFBFBF;"><strong><?php echo $datais[0]['Cliente']; ?></strong></td></tr>
						<?php foreach ($datais as $prod) { ?>
							<?php if(isset($prod['Creacion_Semana'])&&$prod['Creacion_Semana']!=''&&$prod['Creacion_Semana']!=0){ ?>
							<tr class="odd">
								<td align="left"></td>
								<td align="left"><?php echo $prod['Creacion_Semana']; ?></td>

								<td align="right"><?php if(isset($prod['Neto_1'])){echo valores($prod['Neto_1'],0);$Neto_1 = $Neto_1 + $prod['Neto_1'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_2'])){echo valores($prod['Neto_2'],0);$Neto_2 = $Neto_2 + $prod['Neto_2'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_3'])){echo valores($prod['Neto_3'],0);$Neto_3 = $Neto_3 + $prod['Neto_3'];} ?></td>
								<td align="right"><?php if(isset($prod['Neto_4'])){echo valores($prod['Neto_4'],0);$Neto_4 = $Neto_4 + $prod['Neto_4'];} ?></td>
								<td align="right">
									<?php
									// subtotales
									$sub = 0;
									if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
									if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
									if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
									if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
									echo valores($sub,0); 
									?>
								</td>

								<td align="right"><?php if(isset($prod['Total_1'])){echo valores($prod['Total_1'],0);$Total_1 = $Total_1 + $prod['Total_1'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_2'])){echo valores($prod['Total_2'],0);$Total_2 = $Total_2 + $prod['Total_2'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_3'])){echo valores($prod['Total_3'],0);$Total_3 = $Total_3 + $prod['Total_3'];} ?></td>
								<td align="right"><?php if(isset($prod['Total_4'])){echo valores($prod['Total_4'],0);$Total_4 = $Total_4 + $prod['Total_4'];} ?></td>
								<td align="right">
									<?php
									// subtotales
									$sub = 0;
									if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
									if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
									if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
									if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
									echo valores($sub,0); 
									?>
								</td>

							</tr>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					
				  
					
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right" colspan="2"><strong>Totales</strong></td>    
						
						<td align="right"><strong><?php echo Valores($Neto_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>

						<td align="right"><strong><?php echo Valores($Total_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>

					</tr>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right" colspan="2"><strong>Totales Generales</strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>
					</tr>
			                   
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

//Se definen las variables
if(isset($_GET['Ano'])){   $Ano = $_GET['Ano'];   } else { $Ano  = ano_actual();}

//Solo compras pagadas totalmente
$z1 = "WHERE bodegas_arriendos_facturacion.idTipo=2"; //solo ventas
$z2 = "WHERE bodegas_insumos_facturacion.idTipo=2";   //solo ventas
$z3 = "WHERE bodegas_productos_facturacion.idTipo=2"; //solo ventas
$z4 = "WHERE bodegas_servicios_facturacion.idTipo=2"; //solo ventas
//sololas del mismo sistema
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//variable 
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];

if(isset($Ano)&&$Ano!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_ano=".$Ano;
	$z2.=" AND bodegas_insumos_facturacion.Creacion_ano=".$Ano;
	$z3.=" AND bodegas_productos_facturacion.Creacion_ano=".$Ano;
	$z4.=" AND bodegas_servicios_facturacion.Creacion_ano=".$Ano;
	$location .="&Creacion_ano=".$Ano;
	$search .="&Creacion_ano=".$Ano;
}

/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idCliente,
clientes_listado.Nombre AS ClienteNombre,


SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_arriendos_facturacion.idCliente
".$z1."
GROUP BY bodegas_arriendos_facturacion.idCliente";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_1,$row );
}
/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal_2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idCliente,
clientes_listado.Nombre AS ClienteNombre,


SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_insumos_facturacion.idCliente
".$z2."
GROUP BY bodegas_insumos_facturacion.idCliente";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_2,$row );
}
/*************************************************************************************************/
//Bodega de Productos
$arrTemporal_3 = array();
$query = "SELECT 
bodegas_productos_facturacion.idCliente,
clientes_listado.Nombre AS ClienteNombre,


SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_productos_facturacion.idCliente
".$z3."
GROUP BY bodegas_productos_facturacion.idCliente";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_3,$row );
}
/*************************************************************************************************/
//Bodega de Servicios
$arrTemporal_4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idCliente,
clientes_listado.Nombre AS ClienteNombre,


SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `clientes_listado`    ON clientes_listado.idCliente   = bodegas_servicios_facturacion.idCliente
".$z4."
GROUP BY bodegas_servicios_facturacion.idCliente";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_4,$row );
}
/*************************************************************************************************/
//Se crea arreglo
$arrCreativo = array();
foreach ($arrTemporal_1 as $temp) {
	$arrCreativo[$temp['idCliente']]['idCliente']    = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']]['Cliente']      = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idCliente']]['idCliente']    = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']]['Cliente']      = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']]['Neto_2']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']]['Total_2']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idCliente']]['idCliente']    = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']]['Cliente']      = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idCliente']]['idCliente']    = $temp['idCliente'];
	$arrCreativo[$temp['idCliente']]['Cliente']      = $temp['ClienteNombre'];
	$arrCreativo[$temp['idCliente']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idCliente']]['Total_4']         = $temp['ValorTotal'];
}
/*************************************************************************************************/

//Variables
$Neto_1 = 0;
$Neto_2 = 0;
$Neto_3 = 0;
$Neto_4 = 0;

$Total_1 = 0;
$Total_2 = 0;
$Total_3 = 0;
$Total_4 = 0;

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_gerencial_13_to_excel_1.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

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
							<td class="fc-header-left"><a href="<?php echo '?Ano='.$Ano_a ?>" class="btn btn-default"><i class="fa fa-angle-left faa-horizontal animated" aria-hidden="true"></i></a></td>
							<td class="fc-header-center"><span class="fc-header-title"><h2>Ventas por cliente <?php echo $Ano?></h2></span></td>
							<td class="fc-header-right"><a href="<?php echo '?Ano='.$Ano_b ?>" class="btn btn-default"><i class="fa fa-angle-right faa-horizontal animated" aria-hidden="true"></i></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#netos" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Netos</a></li>
				<li class=""><a href="#totales" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Totales</a></li>
			</ul>
		</header>
        <div class="tab-content">
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart']});</script>

			<div class="tab-pane fade active in" id="netos" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Cliente');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $prod) {
								// subtotales
								$sub = 0;
								if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
								if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
								if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
								if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
								?>
								["<?php echo $prod['Cliente']; ?>", <?php echo valores_enteros($sub) ?>],
							<?php } ?>
						]);

						var options = {
							title: 'Grafico Compras Netos',
							legend: { position: 'none' },
							hAxis: { title: 'Empresas', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_1'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_1" style="height: 500px; width: 100%;"></div>

			</div>
			<div class="tab-pane fade" id="totales" style="padding-top:5px;">

				<script>

					google.charts.setOnLoadCallback(drawBasic);

					function drawBasic() {

						var data = new google.visualization.DataTable();
						data.addColumn('string', 'Cliente');
						data.addColumn('number', 'Valor');

						data.addRows([
							<?php foreach ($arrCreativo as $prod) {
								// subtotales
								$sub = 0;
								if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
								if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
								if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
								if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
								?>
								["<?php echo $prod['Cliente']; ?>", <?php echo valores_enteros($sub) ?>],
							<?php } ?>
						]);

						var options = {
							title: 'Grafico Compras Netos',
							legend: { position: 'none' },
							hAxis: { title: 'Empresas', },
							vAxis: { title: 'Valor $', minValue: 0 },
							width: "100%",
						};
						var chart = new google.visualization.ColumnChart(
						document.getElementById('chart_arr_2'));

						chart.draw(data, options);
					}

				</script>
				<div id="chart_arr_2" style="height: 500px; width: 100%;"></div>

			</div>
			
        </div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ventas por cliente</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th></th>
						<th colspan="5" style="text-align: center;">Netos</th>
						<th colspan="5" style="text-align: center;">Totales</th>
						<th width="10"></th>
					</tr>
					<tr role="row">
						<th>Cliente</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

						<th>Arriendos</th>
						<th>Insumos</th>
						<th>Productos</th>
						<th>Servicios</th>
						<th>Subtotal</th>

						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCreativo as $prod) { ?>
						<tr class="odd">
							<td align="left"><?php echo $prod['Cliente']; ?></td>

							<td align="right"><?php if(isset($prod['Neto_1'])){echo valores($prod['Neto_1'],0);$Neto_1 = $Neto_1 + $prod['Neto_1'];} ?></td>
							<td align="right"><?php if(isset($prod['Neto_2'])){echo valores($prod['Neto_2'],0);$Neto_2 = $Neto_2 + $prod['Neto_2'];} ?></td>
							<td align="right"><?php if(isset($prod['Neto_3'])){echo valores($prod['Neto_3'],0);$Neto_3 = $Neto_3 + $prod['Neto_3'];} ?></td>
							<td align="right"><?php if(isset($prod['Neto_4'])){echo valores($prod['Neto_4'],0);$Neto_4 = $Neto_4 + $prod['Neto_4'];} ?></td>
							<td align="right">
								<?php
								// subtotales
								$sub = 0;
								if(isset($prod['Neto_1'])){$sub = $sub + $prod['Neto_1'];}
								if(isset($prod['Neto_2'])){$sub = $sub + $prod['Neto_2'];}
								if(isset($prod['Neto_3'])){$sub = $sub + $prod['Neto_3'];}
								if(isset($prod['Neto_4'])){$sub = $sub + $prod['Neto_4'];}
								echo valores($sub,0); 
								?>
							</td>

							<td align="right"><?php if(isset($prod['Total_1'])){echo valores($prod['Total_1'],0);$Total_1 = $Total_1 + $prod['Total_1'];} ?></td>
							<td align="right"><?php if(isset($prod['Total_2'])){echo valores($prod['Total_2'],0);$Total_2 = $Total_2 + $prod['Total_2'];} ?></td>
							<td align="right"><?php if(isset($prod['Total_3'])){echo valores($prod['Total_3'],0);$Total_3 = $Total_3 + $prod['Total_3'];} ?></td>
							<td align="right"><?php if(isset($prod['Total_4'])){echo valores($prod['Total_4'],0);$Total_4 = $Total_4 + $prod['Total_4'];} ?></td>
							<td align="right">
								<?php
								// subtotales
								$sub = 0;
								if(isset($prod['Total_1'])){$sub = $sub + $prod['Total_1'];}
								if(isset($prod['Total_2'])){$sub = $sub + $prod['Total_2'];}
								if(isset($prod['Total_3'])){$sub = $sub + $prod['Total_3'];}
								if(isset($prod['Total_4'])){$sub = $sub + $prod['Total_4'];}
								echo valores($sub,0); 
								?>
							</td>

							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&details_mensual='.$prod['idCliente']; ?>" title="Ver detalle Mensual" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&details_semanal='.$prod['idCliente']; ?>" title="Ver detalle Semanal" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&details_diario='.$prod['idCliente']; ?>" title="Ver detalle Diario" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					
				  
					
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right"><strong>Totales</strong></td>
						<td align="right"><strong><?php echo Valores($Neto_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>

						<td align="right"><strong><?php echo Valores($Total_1, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_2, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_3, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_4, 0); ?></strong></td>
						<td align="right"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>

						<td></td>
					</tr>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td align="right"><strong>Totales Generales</strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Neto_1+$Neto_2+$Neto_3+$Neto_4, 0); ?></strong></td>
						<td align="right" colspan="5"><strong><?php echo Valores($Total_1+$Total_2+$Total_3+$Total_4, 0); ?></strong></td>
						<td></td>
					</tr>
			                   
				</tbody>
			</table>
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
