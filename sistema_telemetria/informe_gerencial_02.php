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
$original = "informe_gerencial_02.php";
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
	$z1.=" AND bodegas_arriendos_facturacion.idTrabajador=".$_GET['details_mensual'];
	$z2.=" AND bodegas_insumos_facturacion.idTrabajador=".$_GET['details_mensual'];
	$z3.=" AND bodegas_productos_facturacion.idTrabajador=".$_GET['details_mensual'];
	$z4.=" AND bodegas_servicios_facturacion.idTrabajador=".$_GET['details_mensual'];
	$search .="&idTrabajador=".$_GET['details_mensual'];
}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idEstado=".$_GET['idEstado'];
	$z2.=" AND bodegas_insumos_facturacion.idEstado=".$_GET['idEstado'];
	$z3.=" AND bodegas_productos_facturacion.idEstado=".$_GET['idEstado'];
	$z4.=" AND bodegas_servicios_facturacion.idEstado=".$_GET['idEstado'];
	$location .="&idEstado=".$_GET['idEstado'];
	$search .="&idEstado=".$_GET['idEstado'];
}
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$location .="&f_inicio=".$_GET['f_inicio'];
	$location .="&f_termino=".$_GET['f_termino'];
	$search .="&f_inicio=".$_GET['f_inicio'];
	$search .="&f_termino=".$_GET['f_termino'];
}
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$location .="&idTrabajador=".$_GET['idTrabajador'];
	$search .="&idTrabajador=".$_GET['idTrabajador'];
}
		

			
		
				
/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idTrabajador,
bodegas_arriendos_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_arriendos_facturacion.idTrabajador
".$z1."
GROUP BY bodegas_arriendos_facturacion.idTrabajador, bodegas_arriendos_facturacion.Creacion_mes
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
bodegas_insumos_facturacion.idTrabajador,
bodegas_insumos_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_insumos_facturacion.idTrabajador
".$z2."
GROUP BY bodegas_insumos_facturacion.idTrabajador, bodegas_insumos_facturacion.Creacion_mes
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
bodegas_productos_facturacion.idTrabajador,
bodegas_productos_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_productos_facturacion.idTrabajador
".$z3."
GROUP BY bodegas_productos_facturacion.idTrabajador, bodegas_productos_facturacion.Creacion_mes
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
bodegas_servicios_facturacion.idTrabajador,
bodegas_servicios_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_servicios_facturacion.idTrabajador
".$z4."
GROUP BY bodegas_servicios_facturacion.idTrabajador, bodegas_servicios_facturacion.Creacion_mes
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
/*************************************************************************************************/
//Se crea arreglo
$arrCreativo = array();
foreach ($arrTemporal_1 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_2']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_2']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_4']         = $temp['ValorTotal'];
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
	<a target="new" href="<?php echo 'informe_gerencial_02_to_excel_4.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
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
			<h5>Ventas Vendedores por mes</h5>
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
						<th>Trabajador</th>
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
						<tr class="odd"><td align="left" colspan="12" style="background-color: #BFBFBF;"><strong><?php echo $datais[0]['Trabajador']; ?></strong></td></tr>
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
	$z1.=" AND bodegas_arriendos_facturacion.idTrabajador=".$_GET['details_diario'];
	$z2.=" AND bodegas_insumos_facturacion.idTrabajador=".$_GET['details_diario'];
	$z3.=" AND bodegas_productos_facturacion.idTrabajador=".$_GET['details_diario'];
	$z4.=" AND bodegas_servicios_facturacion.idTrabajador=".$_GET['details_diario'];
	$search .="&idTrabajador=".$_GET['details_diario'];
}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idEstado=".$_GET['idEstado'];
	$z2.=" AND bodegas_insumos_facturacion.idEstado=".$_GET['idEstado'];
	$z3.=" AND bodegas_productos_facturacion.idEstado=".$_GET['idEstado'];
	$z4.=" AND bodegas_servicios_facturacion.idEstado=".$_GET['idEstado'];
	$location .="&idEstado=".$_GET['idEstado'];
	$search .="&idEstado=".$_GET['idEstado'];
}
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$location .="&f_inicio=".$_GET['f_inicio'];
	$location .="&f_termino=".$_GET['f_termino'];
	$search .="&f_inicio=".$_GET['f_inicio'];
	$search .="&f_termino=".$_GET['f_termino'];
}
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$location .="&idTrabajador=".$_GET['idTrabajador'];
	$search .="&idTrabajador=".$_GET['idTrabajador'];
}
		

			
		
				
/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idTrabajador,
bodegas_arriendos_facturacion.Creacion_fecha,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_arriendos_facturacion.idTrabajador
".$z1."
GROUP BY bodegas_arriendos_facturacion.idTrabajador, bodegas_arriendos_facturacion.Creacion_fecha
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
bodegas_insumos_facturacion.idTrabajador,
bodegas_insumos_facturacion.Creacion_fecha,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_insumos_facturacion.idTrabajador
".$z2."
GROUP BY bodegas_insumos_facturacion.idTrabajador, bodegas_insumos_facturacion.Creacion_fecha
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
bodegas_productos_facturacion.idTrabajador,
bodegas_productos_facturacion.Creacion_fecha,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_productos_facturacion.idTrabajador
".$z3."
GROUP BY bodegas_productos_facturacion.idTrabajador, bodegas_productos_facturacion.Creacion_fecha
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
bodegas_servicios_facturacion.idTrabajador,
bodegas_servicios_facturacion.Creacion_fecha,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_servicios_facturacion.idTrabajador
".$z4."
GROUP BY bodegas_servicios_facturacion.idTrabajador, bodegas_servicios_facturacion.Creacion_fecha
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
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                            = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                            = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Neto_2']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Total_2']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                            = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                            = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Creacion_fecha']  = $temp['Creacion_fecha'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_fecha']]['Total_4']         = $temp['ValorTotal'];
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
	<a target="new" href="<?php echo 'informe_gerencial_02_to_excel_3.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
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
			<h5>Ventas Vendedores Por dia</h5>
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
						<th>Trabajador</th>
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
						<tr class="odd"><td align="left" colspan="12" style="background-color: #BFBFBF;"><strong><?php echo $datais[0]['Trabajador']; ?></strong></td></tr>
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
	$z1.=" AND bodegas_arriendos_facturacion.idTrabajador=".$_GET['details_semanal'];
	$z2.=" AND bodegas_insumos_facturacion.idTrabajador=".$_GET['details_semanal'];
	$z3.=" AND bodegas_productos_facturacion.idTrabajador=".$_GET['details_semanal'];
	$z4.=" AND bodegas_servicios_facturacion.idTrabajador=".$_GET['details_semanal'];
	$search .="&idTrabajador=".$_GET['details_semanal'];
}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idEstado=".$_GET['idEstado'];
	$z2.=" AND bodegas_insumos_facturacion.idEstado=".$_GET['idEstado'];
	$z3.=" AND bodegas_productos_facturacion.idEstado=".$_GET['idEstado'];
	$z4.=" AND bodegas_servicios_facturacion.idEstado=".$_GET['idEstado'];
	$location .="&idEstado=".$_GET['idEstado'];
	$search .="&idEstado=".$_GET['idEstado'];
}
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$location .="&f_inicio=".$_GET['f_inicio'];
	$location .="&f_termino=".$_GET['f_termino'];
	$search .="&f_inicio=".$_GET['f_inicio'];
	$search .="&f_termino=".$_GET['f_termino'];
}
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$location .="&idTrabajador=".$_GET['idTrabajador'];
	$search .="&idTrabajador=".$_GET['idTrabajador'];
}
		

			
		
				
/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idTrabajador,
bodegas_arriendos_facturacion.Creacion_Semana,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_arriendos_facturacion.idTrabajador
".$z1."
GROUP BY bodegas_arriendos_facturacion.idTrabajador, bodegas_arriendos_facturacion.Creacion_Semana
ORDER BY bodegas_arriendos_facturacion.Creacion_Semana DESC";
$resultado = mysqli_query($dbConn, $query);//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_1,$row );
}
/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal_2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idTrabajador,
bodegas_insumos_facturacion.Creacion_Semana,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_insumos_facturacion.idTrabajador
".$z2."
GROUP BY bodegas_insumos_facturacion.idTrabajador, bodegas_insumos_facturacion.Creacion_Semana
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
bodegas_productos_facturacion.idTrabajador,
bodegas_productos_facturacion.Creacion_Semana,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_productos_facturacion.idTrabajador
".$z3."
GROUP BY bodegas_productos_facturacion.idTrabajador, bodegas_productos_facturacion.Creacion_Semana
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
bodegas_servicios_facturacion.idTrabajador,
bodegas_servicios_facturacion.Creacion_Semana,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_servicios_facturacion.idTrabajador
".$z4."
GROUP BY bodegas_servicios_facturacion.idTrabajador, bodegas_servicios_facturacion.Creacion_Semana
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
/*************************************************************************************************/
//Se crea arreglo
$arrCreativo = array();
foreach ($arrTemporal_1 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                             = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                             = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Neto_2']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Total_2']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                             = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                             = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Creacion_Semana'] = $temp['Creacion_Semana'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_Semana']]['Total_4']         = $temp['ValorTotal'];
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
	<a target="new" href="<?php echo 'informe_gerencial_02_to_excel_2.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
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
			<h5>Ventas Vendedores por semana</h5>
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
						<th>Trabajador</th>
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
						<tr class="odd"><td align="left" colspan="12" style="background-color: #BFBFBF;"><strong><?php echo $datais[0]['Trabajador']; ?></strong></td></tr>
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

}elseif(!empty($_GET['submit_filter'])){
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
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idTrabajador=".$_GET['idTrabajador'];
	$z2.=" AND bodegas_insumos_facturacion.idTrabajador=".$_GET['idTrabajador'];
	$z3.=" AND bodegas_productos_facturacion.idTrabajador=".$_GET['idTrabajador'];
	$z4.=" AND bodegas_servicios_facturacion.idTrabajador=".$_GET['idTrabajador'];
	$location .="&idTrabajador=".$_GET['idTrabajador'];
	$search .="&idTrabajador=".$_GET['idTrabajador'];
}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idEstado=".$_GET['idEstado'];
	$z2.=" AND bodegas_insumos_facturacion.idEstado=".$_GET['idEstado'];
	$z3.=" AND bodegas_productos_facturacion.idEstado=".$_GET['idEstado'];
	$z4.=" AND bodegas_servicios_facturacion.idEstado=".$_GET['idEstado'];
	$location .="&idEstado=".$_GET['idEstado'];
	$search .="&idEstado=".$_GET['idEstado'];
}
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$location .="&f_inicio=".$_GET['f_inicio'];
	$location .="&f_termino=".$_GET['f_termino'];
	$search .="&f_inicio=".$_GET['f_inicio'];
	$search .="&f_termino=".$_GET['f_termino'];
}


					
/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idTrabajador,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_arriendos_facturacion.idTrabajador
".$z1."
GROUP BY bodegas_arriendos_facturacion.idTrabajador";
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
bodegas_insumos_facturacion.idTrabajador,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_insumos_facturacion.idTrabajador
".$z2."
GROUP BY bodegas_insumos_facturacion.idTrabajador";
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
bodegas_productos_facturacion.idTrabajador,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_productos_facturacion.idTrabajador
".$z3."
GROUP BY bodegas_productos_facturacion.idTrabajador";
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
bodegas_servicios_facturacion.idTrabajador,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_servicios_facturacion.idTrabajador
".$z4."
GROUP BY bodegas_servicios_facturacion.idTrabajador";
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
	$arrCreativo[$temp['idTrabajador']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']]['Trabajador']      = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idTrabajador']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']]['Trabajador']      = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']]['Neto_2']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']]['Total_2']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idTrabajador']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']]['Trabajador']      = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idTrabajador']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']]['Trabajador']      = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']]['Total_4']         = $temp['ValorTotal'];
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
	<a target="new" href="<?php echo 'informe_gerencial_02_to_excel_1.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
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
						data.addColumn('string', 'Trabajador');
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
								["<?php echo $prod['Trabajador']; ?>", <?php echo valores_enteros($sub) ?>],
							<?php } ?>
						]);

						var options = {
							title: 'Grafico Compras Netos',
							legend: { position: 'none' },
							hAxis: { title: 'Trabajador', },
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
						data.addColumn('string', 'Trabajador');
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
								["<?php echo $prod['Trabajador']; ?>", <?php echo valores_enteros($sub) ?>],
							<?php } ?>
						]);

						var options = {
							title: 'Grafico Compras Netos',
							legend: { position: 'none' },
							hAxis: { title: 'Trabajador', },
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
			<h5>Ventas por vendedor</h5>
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
						<th>Trabajador</th>

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
							<td align="left"><?php echo $prod['Trabajador']; ?></td>

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
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&details_mensual='.$prod['idTrabajador']; ?>" title="Ver detalle Mensual" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&details_semanal='.$prod['idTrabajador']; ?>" title="Ver detalle Semanal" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&details_diario='.$prod['idTrabajador']; ?>" title="Ver detalle Diario" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
  
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

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
				if(isset($idTrabajador)){    $x1  = $idTrabajador;  }else{$x1  = '';}
				if(isset($idEstado)){        $x2  = $idEstado;      }else{$x2  = '';}
				if(isset($f_inicio)){        $x3  = $f_inicio;      }else{$x3  = '';}
				if(isset($f_termino)){       $x4  = $f_termino;     }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Vendedor','idTrabajador', $x1, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Estado de Pago','idEstado', $x2, 1, 'idEstado', 'Nombre', 'core_estado_facturacion', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x3, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 1);

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
