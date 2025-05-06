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
require_once 'core/Load.Utils.Print.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
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
// consulto los datos
$SIS_query = '
cross_predios_listado.Nombre,
cross_predios_listado.Direccion,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna';
$SIS_join  = '
LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad   = cross_predios_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna  = cross_predios_listado.idComuna';
$SIS_where = 'cross_predios_listado.idPredio ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**************************************************************/
//Se traen las rutas
$SIS_query = '
cross_predios_listado_zonas.idZona,
cross_predios_listado_zonas.Nombre,
cross_predios_listado_zonas_ubicaciones.Latitud,
cross_predios_listado_zonas_ubicaciones.Longitud,
cross_predios_listado.Direccion,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas_ubicaciones`  ON cross_predios_listado_zonas_ubicaciones.idZona  = cross_predios_listado_zonas.idZona
LEFT JOIN `cross_predios_listado`                    ON cross_predios_listado.idPredio                  = cross_predios_listado_zonas.idPredio
LEFT JOIN `core_ubicacion_ciudad`                    ON core_ubicacion_ciudad.idCiudad                  = cross_predios_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`                   ON core_ubicacion_comunas.idComuna                 = cross_predios_listado.idComuna';
$SIS_where = 'cross_predios_listado_zonas.idPredio ='.$X_Puntero;
$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
$arrZonas = array();
$arrZonas = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

/**************************************************************/
//Se obtiene la ubicacion
$Ubicacion = "";
if(isset($arrZonas[0]['Direccion'])&&$arrZonas[0]['Direccion']!=''){$Ubicacion.=' '.$arrZonas[0]['Direccion'];}
if(isset($arrZonas[0]['Comuna'])&&$arrZonas[0]['Comuna']!=''){      $Ubicacion.=', '.$arrZonas[0]['Comuna'];}
if(isset($arrZonas[0]['Ciudad'])&&$arrZonas[0]['Ciudad']!=''){      $Ubicacion.=', '.$arrZonas[0]['Ciudad'];}
//Si los puntos no existen
if(isset($Ubicacion)&&$Ubicacion==''){
	if(isset($rowData['Direccion'])&&$rowData['Direccion']!=''){$Ubicacion.=' '.$rowData['Direccion'];}
	if(isset($rowData['Comuna'])&&$rowData['Comuna']!=''){      $Ubicacion.=', '.$rowData['Comuna'];}
	if(isset($rowData['Ciudad'])&&$rowData['Ciudad']!=''){      $Ubicacion.=', '.$rowData['Ciudad'];}

}

/**************************************************************/
//Se limpian los nombres
$Ubicacion = str_replace('Nº', '', $Ubicacion);
$Ubicacion = str_replace('nº', '', $Ubicacion);
$Ubicacion = str_replace(' n ', '', $Ubicacion);
	
$Ubicacion = str_replace("'", '', $Ubicacion);
	
$Ubicacion = str_replace("Av.", 'Avenida', $Ubicacion);
$Ubicacion = str_replace("av.", 'Avenida', $Ubicacion);

?>
<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<!-- Info-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"              content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type"    content="text/html; charset=UTF-8">

		<!-- Información del sitio-->
		<title>Imprimir</title>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">

		<!-- WEB FONT -->
		<?php
		//verifica la capa de desarrollo
		$whitelist = array( 'localhost', '127.0.0.1', '::1' );
		////////////////////////////////////////////////////////////////////////////////
		//si estoy en ambiente de desarrollo
		if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
			echo '<link rel="stylesheet" href="'.DB_SITE_REPO.'/LIB_assets/lib/font-awesome/css/font-awesome.min.css">';
			//echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';

		////////////////////////////////////////////////////////////////////////////////
		//si estoy en ambiente de produccion
		}else{
			echo '<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">';
			echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';
		}
		?>

		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_<?php if(isset($_SESSION['usuario']['basic_data']['Config_idTheme'])&&$_SESSION['usuario']['basic_data']['Config_idTheme']!=''){echo $_SESSION['usuario']['basic_data']['Config_idTheme'];}else{echo '1';} ?>.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/elegant_font/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/css/bootstrap-material-datetimepicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker-plus.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/css/fileinput.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/css/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/chosen/chosen.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/modal/colorbox.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/tooltipster/css/tooltipster.bundle.min.css">

		<!-- Javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/form_functions.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/rut_validate/jquery.rut.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/autosize/dist/autosize.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/plugins/sortable.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/fileinput.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/locales/es.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly-locale-es-ar.js"></script>

		<!-- Correcciones CSS -->
		<style>
			body {background-color: #FFF !important;}
		</style>
	</head>
	<body>
		<div id="loader-wrapper">
			<div id="loader"></div>
			<div class="loader-section section-left"></div>
			<div class="loader-section section-right"></div>
		</div>
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

								var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

								var myOptions = {
									zoom: 15,
									center: myLatlng,
									mapTypeId: google.maps.MapTypeId.SATELLITE
								};

								map = new Map(document.getElementById("map_canvas"), myOptions);
								map.setTilt(0);

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

								//Centralizado del mapa
								if($zcounter!=0){
									$Latitud_z_prom  = $Latitud_z/$zcounter;
									$Longitud_z_prom = $Longitud_z/$zcounter;

									if(isset($Latitud_z_prom)&&$Latitud_z_prom!=0&&isset($Longitud_z_prom)&&$Longitud_z_prom!=0){
											echo 'myLatlng = new google.maps.LatLng('.$Latitud_z_prom.', '.$Longitud_z_prom.');
													map.setCenter(myLatlng);';
									}else{
										echo 'codeAddress();';
									}
								}
								?>
							}
							/* ************************************************************************** */
							function codeAddress() {

								geocoder.geocode( { address: '<?php echo $Ubicacion ?>'}, function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {

										// marker position
										myLatlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

										map.setCenter(myLatlng);
										//marker.setPosition(myLatlng);

									}else {
										Swal.fire({icon: 'error',title: 'Oops...',text: 'Geocode was not successful for the following reason: ' + status});
									}
								});
							}


						</script>


				
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
<script>
setTimeout(function(){ window.print();}, 5000);
</script>
