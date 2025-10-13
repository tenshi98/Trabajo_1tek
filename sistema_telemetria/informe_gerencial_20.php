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
$original = "informe_gerencial_20.php";
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
//Consulto el nombre del cliente
$query = "SELECT Nombre,RazonSocial
FROM `clientes_listado`
WHERE idCliente=".$_GET['idCliente'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowCliente = mysqli_fetch_assoc ($resultado);

//Filtros
$z= "WHERE orden_trabajo_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z.= " AND orden_trabajo_listado.f_creacion BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$z.= " AND orden_trabajo_listado.idCliente=".$_GET['idCliente'];
}
// Se cuentan las OT por estado
$arrCountOT = array();
$query = "SELECT
COUNT(orden_trabajo_listado.idEstado) AS Cuenta,
core_estado_ot.Nombre AS Estado
FROM `orden_trabajo_listado`
LEFT JOIN `core_estado_ot`     ON core_estado_ot.idEstado    = orden_trabajo_listado.idEstado
".$z."
GROUP BY orden_trabajo_listado.idEstado";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCountOT,$row );
}

//Se verifica que las ot esten terminadas
$z.= " AND orden_trabajo_listado.idEstado=2";
// Se cuentan las ot por estado y tipo
$arrCountType = array();
$query = "SELECT
COUNT(orden_trabajo_listado.idEstado) AS Cuenta,
core_estado_ot.Nombre AS Estado,
core_ot_tipos.Nombre AS Tipo
FROM `orden_trabajo_listado`
LEFT JOIN `core_estado_ot`   ON core_estado_ot.idEstado    = orden_trabajo_listado.idEstado
LEFT JOIN `core_ot_tipos`    ON core_ot_tipos.idTipo       = orden_trabajo_listado.idTipo
".$z."
GROUP BY orden_trabajo_listado.idEstado, core_ot_tipos.Nombre";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCountType,$row );
}

// Se cuentan las ot generadas por maquina
$arrCountMaq = array();
$query = "SELECT
COUNT(orden_trabajo_listado.idEstado) AS Cuenta,
core_estado_ot.Nombre AS Estado,
maquinas_listado.Nombre AS Maquina
FROM `orden_trabajo_listado`
LEFT JOIN `core_estado_ot`    ON core_estado_ot.idEstado    = orden_trabajo_listado.idEstado
LEFT JOIN `maquinas_listado`  ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
".$z."
GROUP BY orden_trabajo_listado.idEstado, maquinas_listado.Nombre";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCountMaq,$row );
}

//filtros 
$z= "WHERE orden_trabajo_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']."  AND orden_trabajo_listado_trabajos.idEstado=2";
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z.= " AND orden_trabajo_listado_trabajos.f_termino BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$z.= " AND orden_trabajo_listado.idCliente=".$_GET['idCliente'];
}

// Se trae un listado con todas las OT
$arrOT = array();
$query = "SELECT
SUM(orden_trabajo_listado_trabajos.Grasa_inicial) AS Grasa_inicial ,
SUM(orden_trabajo_listado_trabajos.Grasa_relubricacion) AS Grasa_relubricacion,
SUM(orden_trabajo_listado_trabajos.Aceite) AS Aceite,
SUM(orden_trabajo_listado_trabajos.Cantidad) AS Cantidad,
sistema_productos_uml.Nombre AS Uml,
orden_trabajo_listado_trabajos.idProducto,
productos_listado.Nombre AS Producto,
productos_listado.ValorIngreso

FROM `orden_trabajo_listado_trabajos`
LEFT JOIN `sistema_productos_uml`     ON sistema_productos_uml.idUml      = orden_trabajo_listado_trabajos.idUml
LEFT JOIN `productos_listado`         ON productos_listado.idProducto     = orden_trabajo_listado_trabajos.idProducto
LEFT JOIN `orden_trabajo_listado`     ON orden_trabajo_listado.idOT       = orden_trabajo_listado_trabajos.idOT

".$z."
GROUP BY orden_trabajo_listado_trabajos.idProducto";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrOT,$row );
} 

$arrOT2 = array();
$query = "SELECT
maquinas_listado.idUbicacion,
ubicacion_listado.Nombre AS Area,
SUM(orden_trabajo_listado_trabajos.Grasa_inicial) AS Grasa_inicial ,
SUM(orden_trabajo_listado_trabajos.Grasa_relubricacion) AS Grasa_relubricacion,
SUM(orden_trabajo_listado_trabajos.Aceite) AS Aceite,
SUM(orden_trabajo_listado_trabajos.Cantidad) AS Cantidad,
sistema_productos_uml.Nombre AS Uml,
orden_trabajo_listado_trabajos.idProducto,
productos_listado.Nombre AS Producto,
productos_listado.ValorIngreso

FROM `orden_trabajo_listado_trabajos`
LEFT JOIN `maquinas_listado`            ON maquinas_listado.idMaquina            = orden_trabajo_listado_trabajos.idMaquina
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = maquinas_listado.idUbicacion
LEFT JOIN `sistema_productos_uml`       ON sistema_productos_uml.idUml           = orden_trabajo_listado_trabajos.idUml
LEFT JOIN `productos_listado`           ON productos_listado.idProducto          = orden_trabajo_listado_trabajos.idProducto
LEFT JOIN `orden_trabajo_listado`       ON orden_trabajo_listado.idOT            = orden_trabajo_listado_trabajos.idOT
".$z."
GROUP BY maquinas_listado.idUbicacion, orden_trabajo_listado_trabajos.idProducto";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrOT2,$row );
}

//filtros
$z= "WHERE orden_trabajo_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND orden_trabajo_listado.idEstado=2";
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z.= " AND orden_trabajo_listado.f_termino BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$z.= " AND orden_trabajo_listado.idCliente=".$_GET['idCliente'];
}
// Se trae un listado con todos los elementos
$arrInsumos = array();
$query = "SELECT
SUM(orden_trabajo_listado_insumos.Cantidad) AS Cantidad,
insumos_listado.Nombre AS NombreInsumo,
sistema_productos_uml.Nombre AS Unidad,
insumos_listado.ValorIngreso
FROM `orden_trabajo_listado`
INNER JOIN `orden_trabajo_listado_insumos`   ON orden_trabajo_listado_insumos.idOT    = orden_trabajo_listado.idOT
LEFT JOIN `insumos_listado`                  ON insumos_listado.idProducto            = orden_trabajo_listado_insumos.idProducto
LEFT JOIN `sistema_productos_uml`            ON sistema_productos_uml.idUml           = insumos_listado.idUml
".$z."
GROUP BY orden_trabajo_listado_insumos.idProducto";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrInsumos,$row );
}

// Se trae un listado con todos los elementos
$arrInsumos2 = array();
$query = "SELECT
maquinas_listado.idUbicacion,
ubicacion_listado.Nombre AS Area,
SUM(orden_trabajo_listado_insumos.Cantidad) AS Cantidad,
insumos_listado.Nombre AS NombreInsumo,
sistema_productos_uml.Nombre AS Unidad,
maquinas_listado.Nombre AS Maquina,
insumos_listado.ValorIngreso
FROM `orden_trabajo_listado`
INNER JOIN `orden_trabajo_listado_insumos`   ON orden_trabajo_listado_insumos.idOT    = orden_trabajo_listado.idOT
LEFT JOIN `insumos_listado`                  ON insumos_listado.idProducto            = orden_trabajo_listado_insumos.idProducto
LEFT JOIN `sistema_productos_uml`            ON sistema_productos_uml.idUml           = insumos_listado.idUml
LEFT JOIN `maquinas_listado`                 ON maquinas_listado.idMaquina            = orden_trabajo_listado.idMaquina
LEFT JOIN `ubicacion_listado`                ON ubicacion_listado.idUbicacion         = maquinas_listado.idUbicacion
".$z."
GROUP BY orden_trabajo_listado.idMaquina, orden_trabajo_listado_insumos.idProducto";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrInsumos2,$row );
}

?>

<h2 align="center">Resumen entre fechas <?php echo fecha_estandar($_GET['f_inicio']).' al '.fecha_estandar($_GET['f_termino']).' del cliente '.$rowCliente['Nombre']; ?></h2>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen por Estado</h5>
			</header>
			 <div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Estado</th>
							<th width="120">Total</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$total = 0;
						foreach ($arrCountOT as $count) {
							$total = $total + $count['Cuenta']; ?>
							<tr class="odd">
								<td><?php echo $count['Estado']; ?></td>
								<td><?php echo $count['Cuenta']; ?></td>
							</tr>
						<?php } ?>
						<tr class="odd">
							<td>Total de OT</td>
							<td><?php echo $total; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Graficos</h5>
			</header>
			 <div class="table-responsive">
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				<script type="text/javascript">
				  google.charts.load("current", {packages:["corechart"]});
				  google.charts.setOnLoadCallback(drawChart1);
				  function drawChart1() {
					var data = google.visualization.arrayToDataTable([
					  ['Ordenes', 'Total']
					  <?php foreach ($arrCountOT as $count) { ?>
						,['<?php echo $count['Estado']; ?>',     <?php echo $count['Cuenta']; ?>]
					  <?php } ?>
					]);

					var options = {
					  title: 'Grafico Resumen por Estado',
					  is3D: true,
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_1'));
					chart.draw(data, options);
				  }
				</script>
				<div id="piechart_3d_1" style="width: 100%; height: 300px;"></div>
			</div>
		</div>
	</div>
</div>	



<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen por Tipo</h5>
			</header>
			 <div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th colspan="2">Estado</th>
							<th width="120">Total</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$total = 0;
						foreach ($arrCountType as $count) {
							$total = $total + $count['Cuenta']; ?>
						<tr class="odd">
							<td><?php echo $count['Estado']; ?></td>
							<td><?php echo $count['Tipo']; ?></td>
							<td><?php echo $count['Cuenta']; ?></td>
						</tr>
						<?php } ?>
						<tr class="odd">
							<td colspan="2">Total de OT</td>
							<td><?php echo $total; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Graficos</h5>
			</header>
			<div class="table-responsive">
				<script type="text/javascript">
				  google.charts.setOnLoadCallback(drawChart2);
				  function drawChart2() {
					var data = google.visualization.arrayToDataTable([
					  ['Ordenes', 'Total']
					  <?php foreach ($arrCountType as $count) { ?>
						,['<?php echo $count['Tipo']; ?>',     <?php echo $count['Cuenta']; ?>]
					  <?php } ?>
					]);

					var options = {
					  title: 'Grafico Resumen por Tipo',
					  is3D: true,
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_2'));
					chart.draw(data, options);
				  }
				</script>
				<div id="piechart_3d_2" style="width: 100%; height: 300px;"></div>

			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen por Maquina</h5>
			</header>
			 <div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th colspan="2">Estado</th>
							<th width="120">Total</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$total = 0;
						foreach ($arrCountMaq as $count) {
							$total = $total + $count['Cuenta']; ?>
						<tr class="odd">
							<td><?php echo $count['Estado']; ?></td>
							<td><?php echo $count['Maquina']; ?></td>
							<td><?php echo $count['Cuenta']; ?></td>
						</tr>
						<?php } ?>
						<tr class="odd">
							<td colspan="2">Total de OT</td>
							<td><?php echo $total; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen</h5>
			</header>
			<div class="table-responsive">
				<script type="text/javascript">
				  google.charts.setOnLoadCallback(drawChart3);
				  function drawChart3() {
					var data = google.visualization.arrayToDataTable([
					  ['Ordenes', 'Total']
					  <?php foreach ($arrCountMaq as $count) { ?>
						,['<?php echo $count['Maquina']; ?>',     <?php echo $count['Cuenta']; ?>]
					  <?php } ?>
					]);

					var options = {
					  title: 'Grafico Resumen por Maquina',
					  is3D: true,
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_3'));
					chart.draw(data, options);
				  }
				</script>
				<div id="piechart_3d_3" style="width: 100%; height: 300px;"></div>

			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Consumo General de Productos Valorizado</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Articulo usado</th>
							<th width="200">Cantidad</th>
							<th width="200">Valor</th>
						</tr>
					</thead>
					  
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						foreach ($arrOT as $consumos) {
							$cantidad = 0;
							if(isset($consumos['Grasa_inicial'])&&$consumos['Grasa_inicial']!=0){          $cantidad = $consumos['Grasa_inicial'];}
							if(isset($consumos['Grasa_relubricacion'])&&$consumos['Grasa_relubricacion']!=0){ $cantidad = $consumos['Grasa_relubricacion'];}
							if(isset($consumos['Aceite'])&&$consumos['Aceite']!=0){                        $cantidad = $consumos['Aceite'];}
							if(isset($consumos['Cantidad'])&&$consumos['Cantidad']!=0){                    $cantidad = $consumos['Cantidad'];}
								
							if($cantidad!=0){ ?>
								<tr class="odd">
									<td><?php echo $consumos['Producto']; ?></td>
									<td><?php echo Cantidades_decimales_justos($cantidad).' '.$consumos['Uml']; ?></td>
									<td align="right"><?php echo valores($cantidad*$consumos['ValorIngreso'], 0); ?></td>
								</tr>
						<?php 
							}
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen</h5>
			</header>
			<div class="table-responsive">
				<script type="text/javascript">
				  google.charts.setOnLoadCallback(drawChart4);
				  function drawChart4() {
					var data = google.visualization.arrayToDataTable([
					  ['Ordenes', 'Valor']
					  <?php foreach ($arrOT as $consumos) {
							$cantidad = 0;
							if(isset($consumos['Grasa_inicial'])&&$consumos['Grasa_inicial']!=0){          $cantidad = $consumos['Grasa_inicial'];}
							if(isset($consumos['Grasa_relubricacion'])&&$consumos['Grasa_relubricacion']!=0){ $cantidad = $consumos['Grasa_relubricacion'];}
							if(isset($consumos['Aceite'])&&$consumos['Aceite']!=0){                        $cantidad = $consumos['Aceite'];}
							if(isset($consumos['Cantidad'])&&$consumos['Cantidad']!=0){                    $cantidad = $consumos['Cantidad'];}

							if($cantidad!=0){ ?>
							
							,['<?php echo $consumos['Producto']; ?>',     <?php echo Cantidades_decimales_justos($cantidad*$consumos['ValorIngreso']); ?>]
						  <?php } ?>
						
					  <?php } ?>
					]);

					var options = {
					  title: 'Grafico Consumo General de Productos',
					  is3D: true,
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_4'));
					chart.draw(data, options);
				  }
				</script>
				<div id="piechart_3d_4" style="width: 100%; height: 300px;"></div>

			</div>
		</div>
	</div>
</div>

<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=4){ ?>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Consumo de Productos Detallado</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Articulo usado</th>
								<th width="200">Cantidad</th>
								<th width="200">Valor Unitario</th>
								<th width="200">Valor Total</th>
							</tr>
						</thead>
						  
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php 
							filtrar($arrOT2, 'idUbicacion'); 
							foreach($arrOT2 as $ordenes=>$consumo){
								echo '<tr class="odd" ><td colspan="5"  style="background-color:#DDD">Area : '.$consumo[0]['Area'].'</td></tr>';
								foreach ($consumo as $consumos) {
									$cantidad = 0;
									if(isset($consumos['Grasa_inicial'])&&$consumos['Grasa_inicial']!=0){          $cantidad = $consumos['Grasa_inicial'];}
									if(isset($consumos['Grasa_relubricacion'])&&$consumos['Grasa_relubricacion']!=0){ $cantidad = $consumos['Grasa_relubricacion'];}
									if(isset($consumos['Aceite'])&&$consumos['Aceite']!=0){                        $cantidad = $consumos['Aceite'];}
									if(isset($consumos['Cantidad'])&&$consumos['Cantidad']!=0){                    $cantidad = $consumos['Cantidad'];}
									
									if($cantidad!=0){ ?>
										<tr class="odd">
											<td><?php echo $consumos['Producto']; ?></td>
											<td><?php echo Cantidades_decimales_justos($cantidad).' '.$consumos['Uml']; ?></td>
											<td align="right"><?php echo valores($consumos['ValorIngreso'], 0); ?></td>
											<td align="right"><?php echo valores($cantidad*$consumos['ValorIngreso'], 0); ?></td>
										</tr>
								<?php
									}
								}
							} 
							
							?>          
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Consumo General de Insumos Valorizado</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Articulo usado</th>
							<th width="200">Cantidad</th>
							<th width="200">Valor</th>
						</tr>
					</thead>
					 
					  
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						foreach ($arrInsumos as $consumos) { ?>
							<tr class="odd">
								<td><?php echo $consumos['NombreInsumo']; ?></td>
								<td><?php echo Cantidades_decimales_justos($consumos['Cantidad']).' '.$consumos['Unidad']; ?></td>
								<td align="right"><?php echo valores($consumos['Cantidad']*$consumos['ValorIngreso'], 0); ?></td>
							</tr>
						<?php }  ?>                    
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen</h5>
			</header>
			<div class="table-responsive">
				<script type="text/javascript">
				  google.charts.setOnLoadCallback(drawChart5);
				  function drawChart5() {
					var data = google.visualization.arrayToDataTable([
					  ['Ordenes', 'Valor']
					  <?php foreach ($arrInsumos as $consumos) { ?>
						,['<?php echo $consumos['NombreInsumo']; ?>', <?php echo Cantidades_decimales_justos($consumos['Cantidad']*$consumos['ValorIngreso']); ?>]
					  <?php } ?>
					]);

					var options = {
					  title: 'Grafico Consumo General de Insumos',
					  is3D: true,
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_5'));
					chart.draw(data, options);
				  }
				</script>
				<div id="piechart_3d_5" style="width: 100%; height: 300px;"></div>

			</div>
		</div>
	</div>
</div>

<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=4){ ?>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Consumo de Insumos Detallado</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Maquina</th>
								<th>Articulo usado</th>
								<th width="200">Cantidad</th>
								<th width="200">Valor Unitario</th>
								<th width="200">Valor Total</th>
							</tr>
						</thead>
						 
						  
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php 
							filtrar($arrInsumos2, 'idUbicacion'); 
							foreach($arrInsumos2 as $ordenes=>$consumo){
								echo '<tr class="odd" ><td colspan="5"  style="background-color:#DDD">Area : '.$consumo[0]['Area'].'</td></tr>';
								foreach ($consumo as $consumos) { ?>
										<tr class="odd">
											<td><?php echo $consumos['Maquina']; ?></td>
											<td><?php echo $consumos['NombreInsumo']; ?></td>
											<td><?php echo Cantidades_decimales_justos($consumos['Cantidad']).' '.$consumos['Unidad']; ?></td>
											<td align="right"><?php echo valores($consumos['ValorIngreso'], 0); ?></td>
											<td align="right"><?php echo valores($consumos['Cantidad']*$consumos['ValorIngreso'], 0); ?></td>
										</tr>
								<?php
								}
							} 
							
							?>          
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
  
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

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
				if(isset($f_inicio)){      $x1  = $f_inicio;    }else{$x1  = '';}
				if(isset($f_termino)){     $x2  = $f_termino;   }else{$x2  = '';}
				if(isset($idCliente)){     $x3  = $idCliente;   }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				$Form_Inputs->form_select_filter('Cliente','idCliente', $x3, 2, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);

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
