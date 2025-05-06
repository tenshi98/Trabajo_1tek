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
//Información basica
$SIS_query = '
trabajadores_listado.idSistema AS TrabajadoridSistema,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Rut AS TrabajadorRut,
	
trabajadores_asistencias_predios.Fecha AS PredioFecha,
trabajadores_asistencias_predios.Hora AS PredioHora,
trabajadores_asistencias_predios.IP_Client AS PredioIP,
trabajadores_asistencias_predios.Latitud AS PredioLatitud,
trabajadores_asistencias_predios.Longitud AS PredioLongitud,
	
cross_predios_listado_zonas.Nombre AS PredioCuartel,
cross_predios_listado.Nombre AS PredioNombre,
core_estado_asistencia_predio.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `trabajadores_listado`           ON trabajadores_listado.idTrabajador            = trabajadores_asistencias_predios.idTrabajador
LEFT JOIN `cross_predios_listado_zonas`    ON cross_predios_listado_zonas.idZona           = trabajadores_asistencias_predios.idZona
LEFT JOIN `cross_predios_listado`          ON cross_predios_listado.idPredio               = cross_predios_listado_zonas.idPredio
LEFT JOIN `core_estado_asistencia_predio`  ON core_estado_asistencia_predio.idEstado       = trabajadores_asistencias_predios.idEstado';
$rowData = db_select_data (false, $SIS_query, 'trabajadores_asistencias_predios', $SIS_join, 'trabajadores_asistencias_predios.idAsistencia ='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**************************************************************/
//Se traen las rutas
$SIS_query = '
cross_predios_listado_zonas.idZona,
cross_predios_listado_zonas.Nombre,
cross_predios_listado_zonas_ubicaciones.Latitud,
cross_predios_listado_zonas_ubicaciones.Longitud';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas_ubicaciones`  ON cross_predios_listado_zonas_ubicaciones.idZona  = cross_predios_listado_zonas.idZona
LEFT JOIN `cross_predios_listado`                    ON cross_predios_listado.idPredio                  = cross_predios_listado_zonas.idPredio';
$SIS_where = 'cross_predios_listado.idSistema ='.$rowData['TrabajadoridSistema'];
$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
$arrZonas = array();
$arrZonas = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Zonas del Predio <?php echo $rowData['PredioNombre']; ?></h5>
		</header>
		<div class="tab-content">
			<div class="table-responsive">

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
						<div id="map_canvas" style="width: 100%; height: 550px;"></div>
						<script>
							let map;
							var marker;

							async function initMap() {
								const { Map } = await google.maps.importLibrary("maps");

								var myLatlng = new google.maps.LatLng(<?php echo $rowData['PredioLatitud']; ?>, <?php echo $rowData['PredioLongitud']; ?>);

								var myOptions = {
									zoom: 15,
									center: myLatlng,
									mapTypeId: google.maps.MapTypeId.SATELLITE
								};

								map = new Map(document.getElementById("map_canvas"), myOptions);
								map.setTilt(0);

								// InfoWindow content
								var content_1 = '<div id="iw-container">' +
												'<div class="iw-title">Ingreso-Egreso</div>' +
												'<div class="iw-content">' +
												'<p>'+
												'<strong>Trabajador: </strong><?php echo $rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat']; ?><br/>' +
												'<strong>Rut: </strong><?php echo $rowData['TrabajadorRut']; ?><br/>' +
												'<strong>Fecha: </strong><?php echo fecha_estandar($rowData['PredioFecha']); ?><br/>' +
												'<strong>Hora: </strong><?php echo $rowData['PredioHora']; ?><br/>' +
												'<strong>IP: </strong><?php echo $rowData['PredioIP']; ?><br/>' +
												'<strong>Predio: </strong><?php echo $rowData['PredioNombre']; ?><br/>' +
												'<strong>Cuartel: </strong><?php echo $rowData['PredioCuartel']; ?><br/>' +
												'<strong>Estado: </strong><?php echo $rowData['Estado']; ?><br/>' +
												'</p>' +
												'</div>' +
												'<div class="iw-bottom-gradient"></div>' +
												'</div>';

								// A new Info Window is created and set content
								var infowindow = new google.maps.InfoWindow({
									content: content_1,
									maxWidth: 350
								});

								marker = new google.maps.Marker({
									position	: myLatlng,
									map			: map,
									title		: "Tu Ubicación",
									icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
								});

								// This event expects a click on a marker
								// When this event is fired the Info Window is opened.
								google.maps.event.addListener(marker, 'click', function() {
									infowindow.open(map,marker);
								});

								// Event that closes the Info Window with a click on the map
								google.maps.event.addListener(map, 'click', function() {
									infowindow.close();
								});

								// *
								// START INFOWINDOW CUSTOMIZE.
								// The google.maps.event.addListener() event expects
								// the creation of the infowindow HTML structure 'domready'
								// and before the opening of the infowindow, defined styles are applied.
								// *
								google.maps.event.addListener(infowindow, 'domready', function() {

									// Reference to the DIV that wraps the bottom of infowindow
									var iwOuter = $('.gm-style-iw');

									/* Since this div is in a position prior to .gm-div style-iw.
									* We use jQuery and create a iwBackground variable,
									* and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
									*/
									var iwBackground = iwOuter.prev();

									// Removes background shadow DIV
									iwBackground.children(':nth-child(2)').css({'display' : 'none'});

									// Removes white background DIV
									iwBackground.children(':nth-child(4)').css({'display' : 'none'});

									// Moves the infowindow 25px to the right.
									//iwOuter.parent().parent().css({left: '5px'});

									// Moves the shadow of the arrow 76px to the left margin.
									iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 6px !important;'});

									// Moves the arrow 76px to the left margin.
									iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 6px !important;'});

									// Changes the desired tail shadow color.
									iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

									// Reference to the div that groups the close button elements.
									var iwCloseBtn = iwOuter.next();

									// Apply the desired effect to the close button
									iwCloseBtn.css({width: '28px',height: '28px', opacity: '1', right: '38px', top: '3px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

									// If the content of infowindow not exceed the set maximum height, then the gradient is removed.
									if($('.iw-content').height() < 140){
										$('.iw-bottom-gradient').css({display: 'none'});
									}

									// The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
									iwCloseBtn.mouseout(function(){
										$(this).css({opacity: '1'});
									});
								});

								//muestro la infowindow al inicio
								infowindow.open(map,marker);

								dibuja_zona();

							}

							/* ************************************************************************** */
							class MyMarker extends google.maps.OverlayView {
								constructor(params) {
									super();
									this.position = params.position;

									const content = document.createElement('div');
									content.classList.add('my_marker');
									content.textContent = params.label;
									content.style.position = 'absolute';
									content.style.transform = 'translate(-50%, -100%)';

									const container = document.createElement('div');
									container.style.position = 'absolute';
									container.style.cursor = 'pointer';
									container.appendChild(content);

									this.container = container;
								}

								onAdd() {
									this.getPanes().floatPane.appendChild(this.container);
								}

								onRemove() {
									this.container.remove();
								}

								draw() {
									const pos = this.getProjection().fromLatLngToDivPixel(this.position);
									this.container.style.left = pos.x + 'px';
									this.container.style.top = pos.y + 'px';
								}
							}

							/* ************************************************************************** */
							function dibuja_zona() {

								var polygons = [];
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
												$Latitud_z_2  = $Latitud_z_2+$puntos['Latitud'];
												$Longitud_z_2 = $Longitud_z_2+$puntos['Longitud'];
												$zcounter3++;
											}
										}
									}

									if(isset($Longitud_x)&&$Longitud_x!=''){
										echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}'; 
									}

									echo '];';

									echo '
									polygons.push(new google.maps.Polygon({
										paths: path'.$todaszonas.',
										strokeColor: \'#FF0000\',
										strokeOpacity: 0.8,
										strokeWeight: 2,
										fillColor: \'#FF0000\',
										fillOpacity: 0.35
									}));
									polygons[polygons.length-1].setMap(map);
									';

									if($zcounter3!=0){
										$Latitud_z_prom_2  = $Latitud_z_2/$zcounter3;
										$Longitud_z_prom_2 = $Longitud_z_2/$zcounter3;
									}
									// The label that pops up when the mouse moves within each polygon.
									echo '
									myLatlng = new google.maps.LatLng('.$Latitud_z_prom_2.', '.$Longitud_z_prom_2.');

									var marker = new MyMarker({
										position: myLatlng,
										label: "'.$zonas[0]['Nombre'].'"
									});
									marker.setMap(map);

									// When the mouse moves within the polygon, display the label and change the BG color.
									google.maps.event.addListener(polygons['.$zcounter2.'], "mousemove", function(event) {
										polygons['.$zcounter2.'].setOptions({
											fillColor: "#00FF00"
										});
									});

									// WHen the mouse moves out of the polygon, hide the label and change the BG color.
									google.maps.event.addListener(polygons['.$zcounter2.'], "mouseout", function(event) {
										polygons['.$zcounter2.'].setOptions({
											fillColor: "#FF0000"
										});
									});
									';

									$zcounter2++;

								}

								echo 'myLatlng = new google.maps.LatLng('.$rowData['PredioLatitud'].', '.$rowData['PredioLongitud'].');
													map.setCenter(myLatlng);';
								?>
							}


						</script>

				<?php } ?>
			</div>
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
