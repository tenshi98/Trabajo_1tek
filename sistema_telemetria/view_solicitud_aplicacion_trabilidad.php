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
//se recorre deacuerdo a la cantidad de sensores
$subquery = '';
$Nsens = 6;
for ($i = 1; $i <= $Nsens; $i++) {
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Prom';
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Min';
	$subquery .= ',cross_solicitud_aplicacion_listado_tractores.Sensor_'.$i.'_Max';
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS Sensor_'.$i.'_Nombre';
}

// consulto los datos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_termino,

cross_predios_listado.Nombre AS PredioNombre,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
cross_predios_listado_zonas.Plantas AS CuartelCantPlantas,

telemetria_listado.Nombre AS NebNombre,
vehiculos_listado.Nombre AS TractorNombre,
telemetria_listado.cantSensores,
cross_solicitud_aplicacion_listado_tractores.idTractores,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,
cross_solicitud_aplicacion_listado_tractores.GeoDistance,
cross_solicitud_aplicacion_listado_tractores.idTelemetria,

cross_solicitud_aplicacion_listado_cuarteles.VelTractor,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
cross_solicitud_aplicacion_listado.f_ejecucion'.$subquery;
$SIS_join  = '
LEFT JOIN `cross_solicitud_aplicacion_listado`             ON cross_solicitud_aplicacion_listado.idSolicitud             = cross_solicitud_aplicacion_listado_tractores.idSolicitud
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles   = cross_solicitud_aplicacion_listado_tractores.idCuarteles
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                            = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                               = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `telemetria_listado_sensores_nombre`             ON telemetria_listado_sensores_nombre.idTelemetria            = cross_solicitud_aplicacion_listado_tractores.idTelemetria';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idTractores ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************/
$subquery = '';
$subquery .= ',FechaSistema';
$subquery .= ',HoraSistema';
$subquery .= ',GeoLatitud';
$subquery .= ',GeoLongitud';
$subquery .= ',GeoMovimiento';
$subquery .= ',GeoVelocidad';
//se recorre deacuerdo a la cantidad de sensores
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	$subquery .= ',Sensor_'.$i;
}

/*****************************************/
//se consulta
$SIS_query = 'idTabla'.$subquery;
$SIS_join  = '';
$SIS_where = 'idZona = 0 AND idSolicitud = '.$rowData['idSolicitud'].' AND FechaSistema ="'.$rowData['f_ejecucion'].'"';
$SIS_order = 'FechaSistema ASC, HoraSistema ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$rowData['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

/*****************************************/
//se consulta
$SIS_query = 'idUbicaciones, Latitud, Longitud';
$SIS_join  = '';
$SIS_where = 'idZona ='.$rowData['idZona'];
$SIS_order = 'idUbicaciones ASC';
$arrPuntos = array();
$arrPuntos = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas_ubicaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPuntos');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Detalles Solicitud de Aplicacion N°<?php echo n_doc($rowData['NSolicitud'], 7); ?>.
				<small class="pull-right">Fecha Termino: <?php echo Fecha_estandar($rowData['f_termino']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Identificación</strong>
					<address>
						Predio: '.$rowData['PredioNombre'].'<br/>
						Especie: '.$rowData['VariedadCat'].'<br/>
						Variedad: '.$rowData['VariedadNombre'].'<br/>
						Cuartel: '.$rowData['CuartelNombre'].'<br/>
						Tractor: '.$rowData['TractorNombre'].'<br/>
						Nebulizador: '.$rowData['NebNombre'].'<br/>
					</address>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Velocidad Tractores (Km/hr)</strong>
					<address>
						Minima: '.Cantidades($rowData['GeoVelocidadMin'], 2).'<br/>
						Maxima: '.Cantidades($rowData['GeoVelocidadMax'], 2).'<br/>
						Promedio: '.Cantidades($rowData['GeoVelocidadProm'], 2).'<br/>
						Programada: '.Cantidades($rowData['VelTractor'], 2).'<br/>
					</address>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Distancia Recorrida(Metros)</strong>
					<address>
						Recorrida: '.Cantidades($rowData['GeoDistance'], 2).'<br/>
						Estimada: '.Cantidades($rowData['CuartelDistanciaPlant']*$rowData['CuartelCantPlantas'], 2).'<br/>
						Faltante: '.Cantidades(($rowData['CuartelDistanciaPlant']*$rowData['CuartelCantPlantas']) - ($rowData['GeoDistance']), 2).'<br/>
				</div>';
		?>

	</div>

	<div class="row" style="margin-bottom:15px;">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Sensor</th>
						<th>Minimo</th>
						<th>Maximo</th>
						<th>Promedio</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 1; $i <= $rowData['cantSensores']; $i++) {  ?>
						<tr>
							<td><?php echo $rowData['Sensor_'.$i.'_Nombre']; ?></td>
							<td><?php echo $rowData['Sensor_'.$i.'_Min']; ?></td>
							<td><?php echo $rowData['Sensor_'.$i.'_Max']; ?></td>
							<td><?php echo $rowData['Sensor_'.$i.'_Prom']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row" style="margin-bottom:15px;">
		<div class="col-xs-12" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table']});</script>

			<?php
				/********************************************************************/
				//Caudales
				echo '
				<script>
					google.charts.setOnLoadCallback(drawChart_caudales);

					function drawChart_caudales() {
						var data_caud = new google.visualization.DataTable();
						data_caud.addColumn("string", "Hora");
						data_caud.addColumn("number", "Caudal Derecho");
						data_caud.addColumn("number", "Caudal Izquierdo");

						data_caud.addRows([';
							//recorro los resultados
							foreach ($arrMediciones as $med) {
								echo '["'.$med['HoraSistema'].'",
								'.Cantidades_decimales_justos($med['Sensor_1']).',
								'.Cantidades_decimales_justos($med['Sensor_2']).'
								],';
							}
							echo '
						]);

						var options = {
							title: "Grafico Caudales (Lt/Min)",
							hAxis: {title: "Hora"},
							vAxis: { title: "Valor" },
							width: $(window).width()*0.95,
							height: 300,
							curveType: "function",
							colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
						};
						var chart1 = new google.visualization.LineChart(document.getElementById("chart_caudales"));
							chart1.draw(data_caud, options);
					}
				</script>
				<div id="chart_caudales" style="height: 300px; width: 100%;"></div>';

				/********************************************************************/
				//Nivel Estanque
				echo '
				<script>
					google.charts.setOnLoadCallback(drawChart_caudales);

					function drawChart_caudales() {
						var data_caud = new google.visualization.DataTable();
						data_caud.addColumn("string", "Hora");
						data_caud.addColumn("number", "Nivel Estanque");

						data_caud.addRows([';
							//recorro los resultados
							foreach ($arrMediciones as $med) {
								echo '["'.$med['HoraSistema'].'",
								'.Cantidades_decimales_justos($med['Sensor_3']).',
								],';
							}
							echo '
						]);

						var options = {
							title: "Grafico Nivel Estanque",
							hAxis: {title: "Hora"},
							vAxis: { title: "Valor" },
							width: $(window).width()*0.95,
							height: 300,
							curveType: "function",
							colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
						};
						var chart1 = new google.visualization.LineChart(document.getElementById("chart_niveles"));
							chart1.draw(data_caud, options);
					}
				</script>
				<div id="chart_niveles" style="height: 300px; width: 100%;"></div>';

				/********************************************************************/
				//Velocidades
				echo '
				<script>
					google.charts.setOnLoadCallback(drawChart_velocidades);

					function drawChart_velocidades() {
						var data_vel = new google.visualization.DataTable();
						data_vel.addColumn("string", "Hora");
						data_vel.addColumn("number", "Velocidad");

						data_vel.addRows([';
							//recorro los resultados
							foreach ($arrMediciones as $med) {
								echo '["'.$med['HoraSistema'].'",
								'.Cantidades_decimales_justos($med['GeoVelocidad']).'
								],';
							}
							echo '
						]);

						var options = {
							title: "Grafico Velocidades",
							hAxis: {title: "Hora"},
							vAxis: { title: "Valor" },
							width: $(window).width()*0.95,
							height: 300,
							curveType: "function",
							colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
						};
						var chart1 = new google.visualization.LineChart(document.getElementById("chart_velocidades"));
							chart1.draw(data_vel, options);
					}
				</script>
				<div id="chart_velocidades" style="height: 300px; width: 100%;"></div>';

				/********************************************************************/
				//Distancias
				echo '
				<script>
					google.charts.setOnLoadCallback(drawChart_distancias);

					function drawChart_distancias() {
						var data_vel = new google.visualization.DataTable();
						data_vel.addColumn("string", "Hora");
						data_vel.addColumn("number", "Distancia");

						data_vel.addRows([';
							//recorro los resultados
							foreach ($arrMediciones as $med) {
								echo '["'.$med['HoraSistema'].'",
								'.Cantidades_decimales_justos($med['GeoMovimiento']).'
								],';
							}
							echo '
						]);

						var options = {
							title: "Grafico Distancias",
							hAxis: {title: "Hora"},
							vAxis: { title: "Valor" },
							width: $(window).width()*0.95,
							height: 300,
							curveType: "function",
							colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
						};
						var chart1 = new google.visualization.LineChart(document.getElementById("chart_distancias"));
							chart1.draw(data_vel, options);
					}
				</script>
				<div id="chart_distancias" style="height: 300px; width: 100%;"></div>';
			?>

		</div>
	</div>

	<div class="row">
		<div class="col-xs-12" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<?php
			//Si no existe una ID se utiliza una por defecto
			if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
				$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
				alert_post_data(4,2,2,0, $Alert_Text);
			}else{
				$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>
				<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
				<div id="map_canvas" style="width: 100%; height: 550px;"></div>
				<script>
					let map;

					async function initMap() {
						const { Map } = await google.maps.importLibrary("maps");

						var myLatlng = new google.maps.LatLng(<?php echo $arrPuntos[0]['Latitud']; ?>, <?php echo $arrPuntos[0]['Longitud']; ?>);

						var myOptions = {
							zoom: 17,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.SATELLITE
						};

						map = new Map(document.getElementById("map_canvas"), myOptions);
						/* Data points defined as a mixture of WeightedLocation and LatLng objects */
						var heatMapData = [
							<?php
							//recorro los resultados
							foreach ($arrMediciones as $med) {
								if(isset($med['GeoLatitud'])&&$med['GeoLatitud']!=0&&isset($med['GeoLongitud'])&&$med['GeoLongitud']!=0){
									$pres = $med['Sensor_1'] + $med['Sensor_2'];
									echo '{location: new google.maps.LatLng('.$med['GeoLatitud'].', '.$med['GeoLongitud'].'), weight: '.$pres.'},';
								}
							} ?>
						];

						var heatmap = new google.maps.visualization.HeatmapLayer({
						data: heatMapData
						});
						heatmap.setMap(map);
						dibuja_zona();

					}

					//Se dibujan los puntos en base a los niveles de riego
					/* ************************************************************************** */
					function dibuja_zona() {

						var triangleCoords = [
							<?php
							//Variables con la primera posicion
							$Latitud_x = '';
							$Longitud_x = '';
							//recorrer
							foreach ($arrPuntos as $puntos) {
								echo '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},
								';
								if(isset($puntos['Latitud'])&&$puntos['Latitud']!='0'){
									$Latitud_x = $puntos['Latitud'];
									$Longitud_x = $puntos['Longitud'];
								}
							}
							//se cierra la figura
							if(isset($Longitud_x)&&$Longitud_x!=''){
								echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
							}
							?>
						];

						// Construct the polygon.
						var bermudaTriangle = new google.maps.Polygon({
							paths: triangleCoords,
							strokeColor: '#FF0000',
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: '#FF0000',
							fillOpacity: 0
						});
						bermudaTriangle.setMap(map);

					}

				</script>
			<?php } ?>
		</div>
	</div>

</section>

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
