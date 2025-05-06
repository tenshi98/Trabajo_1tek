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
$X_idTelemetria = simpleDecode($_GET['idTelemetria'], fecha_actual());
$X_idSolicitud  = simpleDecode($_GET['idSolicitud'], fecha_actual());
/**************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = '
vehiculos_listado.Nombre AS VehiculoNombreBack,
telemetria_listado.Nombre AS VehiculoNombre,
telemetria_listado.cantSensores';
$SIS_join  = '
LEFT JOIN `telemetria_listado`   ON telemetria_listado.idTelemetria    = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`    ON vehiculos_listado.idVehiculo       = cross_solicitud_aplicacion_listado_tractores.idVehiculo';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idTelemetria ='.$X_idTelemetria;
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
//Se traen las rutas
$SIS_query = '
cross_predios_listado_zonas.idZona,
cross_predios_listado_zonas.Nombre,
cross_predios_listado_zonas_ubicaciones.Latitud,
cross_predios_listado_zonas_ubicaciones.Longitud';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas`               ON cross_predios_listado_zonas.idPredio             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `cross_predios_listado_zonas_ubicaciones`   ON cross_predios_listado_zonas_ubicaciones.idZona   = cross_predios_listado_zonas.idZona';
$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud ='.$X_idSolicitud;
$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
$arrZonas = array();
$arrZonas = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

/*****************************************/
//Variable para almacenar los recorridos
$rec_x           = '';
$marker_loc      = '';
$arrMedTractores = array();
/***************************************/
$aa = '';
$aa .= ',FechaSistema';
$aa .= ',HoraSistema';
$aa .= ',GeoLatitud';
$aa .= ',GeoLongitud';
$aa .= ',GeoVelocidad';
//se recorre deacuerdo a la cantidad de sensores
for ($i = 1; $i <= 4; $i++) {
	$aa .= ',Sensor_'.$i;
}
/*****************************************/
$SIS_query = 'idTabla, idTelemetria'.$aa;
$SIS_join  = '';
$SIS_where = 'idSolicitud ='.$X_idSolicitud.' AND idZona!=0';
$SIS_order = 'FechaSistema ASC, HoraSistema ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$X_idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

//recorro los resultados
foreach ($arrMediciones as $med) {
	$pres = 0;
	//if(isset($med['GeoLatitud'])&&$med['GeoLatitud']!=0&&isset($med['GeoLongitud'])&&$med['GeoLongitud']!=0&&($med['Sensor_1']>1 OR $med['Sensor_2']>1)){
	if(isset($med['GeoLatitud'])&&$med['GeoLatitud']!=0&&isset($med['GeoLongitud'])&&$med['GeoLongitud']!=0){
		$pres = $med['Sensor_1'] + $med['Sensor_2'];
		$rec_x .= "{location: new google.maps.LatLng(".$med['GeoLatitud'].", ".$med['GeoLongitud']."), weight: ".$pres."},
		";
		//burbuja
		$explanation  = '<div class="iw-subTitle">Caudales Equipo</div>';
		$explanation .= '<p>';
		$explanation .= 'Tractor: '.$rowData['VehiculoNombreBack'].'<br/>';
		$explanation .= 'Equipo: '.$rowData['VehiculoNombre'];
		$explanation .= '</p>';
		$explanation .= '<p>';
		$explanation .= 'Hora: '.$med['HoraSistema'].'<br/>';
		$explanation .= 'Caudal Derecho: '.cantidades($med['Sensor_1'], 2).'<br/>';
		$explanation .= 'Caudal Izquierdo: '.cantidades($med['Sensor_2'], 2).'<br/>';
		$explanation .= 'Nivel Estanque: '.cantidades($med['Sensor_3'], 1).' %<br/>';
		$explanation .= 'Velocidad: '.cantidades($med['GeoVelocidad'], 0).' K/M<br/>';
		$explanation .= '</p>';
		//se arma dato
		$marker_loc .= "[";
			$marker_loc .= $med['GeoLatitud'];
			$marker_loc .= ", ".$med['GeoLongitud'];
			$marker_loc .= ", '".$explanation."'";
			//cambio de iconos
			$marker_loc .= ", ".$med['idTelemetria'];
		$marker_loc .= "], ";
						
				
	}
}	


//Variables
$Cent_zonaLatitud   = $arrZonas[0]['Latitud'];
$Cent_zonaLongitud  = $arrZonas[0]['Longitud'];	

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ver Mapas</h5>
		</header>
		<div class="tab-content">
			<?php
			//Si no existe una ID se utiliza una por defecto
			if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
				$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
				alert_post_data(4,2,2,0, $Alert_Text);
			}else{
				$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>

				<style>
					.my_marker {color: white;background-color: black;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
					.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
				</style>

				<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>

				<div id="map_canvas_y" style="width: 100%; height: 550px;"></div>
				<br/><br/>
				<div id="map_canvas_z" style="width: 100%; height: 550px;"></div>
				<script>
					let map_1, map_2;
					var marker;
					var markersCam = [];

					async function initMap() {
						const { Map } = await google.maps.importLibrary("maps");

						var myLatlng = new google.maps.LatLng(<?php echo $Cent_zonaLatitud.','.$Cent_zonaLongitud; ?>);

						var myOptions1 = {
							zoom: 15,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.SATELLITE
						};
						var myOptions2 = {
							zoom: 15,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.SATELLITE
						};

						map_1 = new Map(document.getElementById("map_canvas_y"), myOptions1);
						map_2 = new Map(document.getElementById("map_canvas_z"), myOptions2);
						//Se dibujan los puntos en base a los niveles de riego
						/* Data points defined as a mixture of WeightedLocation and LatLng objects */
						var heatMapData = [<?php echo $rec_x; ?>];

						var heatmap = new google.maps.visualization.HeatmapLayer({
							data: heatMapData,
							map: map_2
						});
						heatmap.setMap(map_2);

						//Ubicación de los distintos dispositivos
						var locations = [<?php echo $marker_loc; ?>];

						//marcadores
						setMarkers(map_1, locations);

						dibuja_zona();

					}

					/* ************************************************************************** */
					function dibuja_zona() {

						var polygons1 = [];
						var polygons2 = [];
						<?php
						//variables
						$Latitud_z       = 0;
						$Longitud_z      = 0;
						$Latitud_z_prom  = 0;
						$Longitud_z_prom = 0;
						$zcounter        = 0;
						$zcounter2       = 0;

						//Se filtra por zona
						filtrar($arrZonas, 'idZona');
						//se recorre
						foreach ($arrZonas as $todaszonas=>$zonas) {

							$Latitud_z_2       = 0;
							$Longitud_z_2      = 0;
							$Latitud_z_prom_2  = 0;
							$Longitud_z_prom_2 = 0;
							$zcounter3         = 0;
							echo 'var path'.$todaszonas.' = [';

							//Variables con la primera posicion
							$Latitud_x = '';
							$Longitud_x = '';

							foreach ($zonas as $puntos) {
								if(isset($puntos['Latitud'])&&$puntos['Latitud']!=''&&isset($puntos['Longitud'])&&$puntos['Longitud']!=''){
									echo '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},
									';
									if(isset($puntos['Latitud'])&&$puntos['Latitud']!='0'&&isset($puntos['Longitud'])&&$puntos['Longitud']!='0'){
										$Latitud_x  = $puntos['Latitud'];
										$Longitud_x = $puntos['Longitud'];
										//Calculos para centrar mapa
										$Latitud_z    = $Latitud_z+$puntos['Latitud'];
										$Longitud_z   = $Longitud_z+$puntos['Longitud'];
										$Latitud_z_2  = $Latitud_z_2+$puntos['Latitud'];
										$Longitud_z_2 = $Longitud_z_2+$puntos['Longitud'];
										$zcounter++;
										$zcounter3++;
									}
								}
							}

							if(isset($Longitud_x)&&$Longitud_x!=''){
								echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
							}

							echo '];';

							echo '
							polygons1.push(new google.maps.Polygon({
								paths: path'.$todaszonas.',
								strokeColor: \'#FF0000\',
								strokeOpacity: 0.8,
								strokeWeight: 2,
								fillColor: \'#FF0000\',
								fillOpacity: 0.35
							}));
							polygons2.push(new google.maps.Polygon({
								paths: path'.$todaszonas.',
								strokeColor: \'#FF0000\',
								strokeOpacity: 0.8,
								strokeWeight: 2,
								fillColor: \'#FF0000\',
								fillOpacity: 0
							}));
							polygons1[polygons1.length-1].setMap(map_1);
							polygons2[polygons2.length-1].setMap(map_2);
							';

							/*if($zcounter3!=0){
								$Latitud_z_prom_2  = $Latitud_z_2/$zcounter3;
								$Longitud_z_prom_2 = $Longitud_z_2/$zcounter3;
							}*/
							// The label that pops up when the mouse moves within each polygon.
							echo '
							/*myLatlng = new google.maps.LatLng('.$Latitud_z_prom_2.', '.$Longitud_z_prom_2.');

							var marker1 = new MyMarker({
								position: myLatlng,
								label: "'.$zonas[0]['Nombre'].'"
							});
							var marker2 = new MyMarker({
								position: myLatlng,
								label: "'.$zonas[0]['Nombre'].'"
							});
							marker1.setMap(map_1);
							marker2.setMap(map_2);*/

							// When the mouse moves within the polygon, display the label and change the BG color.
							google.maps.event.addListener(polygons1['.$zcounter2.'], "mousemove", function(event) {
								polygons1['.$zcounter2.'].setOptions({
									fillColor: "#00FF00"
								});
							});

							// WHen the mouse moves out of the polygon, hide the label and change the BG color.
							google.maps.event.addListener(polygons1['.$zcounter2.'], "mouseout", function(event) {
								polygons1['.$zcounter2.'].setOptions({
									fillColor: "#FF0000"
								});
							});
							';

									$zcounter2++;
						}

						//Centralizado del mapa
						if($zcounter!=0){
							$Latitud_z_prom  = $Latitud_z/$zcounter;
							$Longitud_z_prom = $Longitud_z/$zcounter;

							if(isset($Latitud_z_prom)&&$Latitud_z_prom!=0&&isset($Longitud_z_prom)&&$Longitud_z_prom!=0){
									echo 'myLatlng = new google.maps.LatLng('.$Latitud_z_prom.', '.$Longitud_z_prom.');';
									echo 'map_1.setCenter(myLatlng);';
									echo 'map_2.setCenter(myLatlng);';
							}
						}
						?>
					}
					/* ************************************************************************** */
					function setMarkers(map_1, locations) {

						var marker, i, last_latitude, last_longitude;

						for (i = 0; i < locations.length; i++) {

							//defino ubicacion y datos
							var latitude   = locations[i][0];
							var longitude  = locations[i][1];
							var data       = locations[i][2];
							var icon       = locations[i][3];
							var marcador   = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/3_comun_" + icon + ".png";
							var title      = "Información";

							//guardo las ultimas ubicaciones
							last_latitude   = locations[i][0];
							last_longitude  = locations[i][1];

							//ubicacion mapa
							latlngset = new google.maps.LatLng(latitude, longitude);

							//se crea marcador
							var marker = new google.maps.Marker({
								map         : map_1,
								position    : latlngset,
								icon      	: marcador
							});
							markersCam.push(marker);

							//se define contenido
							var content = 	"<div id='iw-container'>" +
											"<div class='iw-title'>" + title + "</div>" +
											"<div class='iw-content'>" +
											data +
											"</div>" +
											"<div class='iw-bottom-gradient'></div>" +
											"</div>";

							//se crea infowindow
							var infowindow = new google.maps.InfoWindow();

							//se agrega funcion de click a infowindow
							google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
								return function() {
									infowindow.setContent(content);
									infowindow.open(map_1,marker);
								};
							})(marker,content,infowindow));

						}
						latlon = new google.maps.LatLng(last_latitude, last_longitude);
						map_1.panTo(latlon);
					}
					/* ************************************************************************** */
					// Sets the map on all markers in the array.
					function setMapOnAll(map_1) {
						for (let i = 0; i < markersCam.length; i++) {
							markersCam[i].setMap(map_1);
						}
					}
					/* ************************************************************************** */
					// Removes the markers from the map, but keeps them in the array.
					function clearMarkers() {
						setMapOnAll(null);
					}
					/* ************************************************************************** */
					// Shows any markers currently in the array.
					function showMarkers() {
						setMapOnAll(map_1);
					}
					/* ************************************************************************** */
					// Deletes all markers in the array by removing references to them.
					function deleteMarkers() {
						clearMarkers();
						markersCam = [];
					}

				</script>
			<?php } ?>
		</div>
	</div>
</div>

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
