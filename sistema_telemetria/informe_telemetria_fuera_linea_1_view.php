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
/*                                                Carga del documento HTML                                                        */
/**********************************************************************************************************************************/
/**********************************************************************************************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado_error_fuera_linea.Fecha_inicio, 
telemetria_listado_error_fuera_linea.Hora_inicio, 
telemetria_listado_error_fuera_linea.Fecha_termino, 
telemetria_listado_error_fuera_linea.Hora_termino, 
telemetria_listado_error_fuera_linea.Tiempo,
telemetria_listado_error_fuera_linea.GeoLatitud,
telemetria_listado_error_fuera_linea.GeoLongitud,
telemetria_listado_error_fuera_linea.GeoLatitud_Last,
telemetria_listado_error_fuera_linea.GeoLongitud_Last,
telemetria_listado.Nombre AS NombreEquipo';
$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_error_fuera_linea.idTelemetria';
$SIS_where = 'telemetria_listado_error_fuera_linea.idFueraLinea ='.simpleDecode($_GET['view'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Equipo <?php echo $rowData['NombreEquipo']; ?></h5>
		</header>
		<div class="table-responsive">
			<?php
			$explanation2 .= '<strong>Tiempo: </strong>'.$rowData['Tiempo'].' hrs<br/>';

			//Si no existe una ID se utiliza una por defecto
			if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
				$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
				alert_post_data(4,2,2,0, $Alert_Text);
			}else{
				$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>
				<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
				<script>
					let map;

					async function initMap() {
						const { Map } = await google.maps.importLibrary("maps");

						var myLatlng = new google.maps.LatLng(<?php echo $rowData['GeoLatitud'] ?>, <?php echo $rowData['GeoLongitud'] ?>);
						// marker position
						var factory_1 = new google.maps.LatLng(<?php echo $rowData['GeoLatitud_Last'] ?>, <?php echo $rowData['GeoLongitud_Last'] ?>);
						var factory_2 = new google.maps.LatLng(<?php echo $rowData['GeoLatitud'] ?>, <?php echo $rowData['GeoLongitud'] ?>);

						var myOptions = {
							zoom: 15,
							scrollwheel: false,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};

						map = new Map(document.getElementById("map_canvas"), myOptions);
						// InfoWindow content
						var content_1 = '<div id="iw-container">' +
										'<div class="iw-title">Desconexion</div>' +
										'<div class="iw-content">' +
										'<div class="iw-subTitle">Fecha - Hora</div>' +
										'<p><?php echo fecha_estandar($rowData['Fecha_inicio']).' - '.$rowData['Hora_inicio']; ?></p>' +
										'</div>' +
										'<div class="iw-bottom-gradient"></div>' +
										'</div>';

						var content_2 = '<div id="iw-container">' +
										'<div class="iw-title">Conexion</div>' +
										'<div class="iw-content">' +
										'<div class="iw-subTitle">Fecha - Hora</div>' +
										'<p><?php echo fecha_estandar($rowData['Fecha_termino']).' - '.$rowData['Hora_termino']; ?></p>' +
										'<div class="iw-subTitle">Tiempo</div>' +
										'<p><?php echo $rowData['Tiempo']; ?></p>' +
										'</div>' +
										'<div class="iw-bottom-gradient"></div>' +
										'</div>';


						// A new Info Window is created and set content
						var infowindow_1 = new google.maps.InfoWindow({
							content: content_1,
							maxWidth: 350
						});
						var infowindow_2 = new google.maps.InfoWindow({
							content: content_2,
							maxWidth: 350
						});

						// marker options
						var marker_1 = new google.maps.Marker({
							position	: factory_1,
							map			: map,
							title		: "Dirección",
							animation 	: google.maps.Animation.DROP,
							icon      	: "<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_red.png"
						});
						var marker_2 = new google.maps.Marker({
							position	: factory_2,
							map			: map,
							title		: "Dirección",
							animation 	: google.maps.Animation.DROP,
							icon      	: "<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_green.png"
						});

						// This event expects a click on a marker
						// When this event is fired the Info Window is opened.
						google.maps.event.addListener(marker_1, 'click', function() {
							infowindow_1.open(map,marker_1);
						});
						google.maps.event.addListener(marker_2, 'click', function() {
							infowindow_2.open(map,marker_2);
						});

						// Event that closes the Info Window with a click on the map
						google.maps.event.addListener(map, 'click', function() {
							infowindow_1.close();
							infowindow_2.close();
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
						infowindow_1.open(map,marker_1);
						infowindow_2.open(map,marker_2);

						//centralizo el mapa en base al ultimo dato obtenido
						map.panTo(marker_1.getPosition());

					}

				</script>

				<div id="map_canvas" style="width:100%; height:500px"></div>

			<?php } ?>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
