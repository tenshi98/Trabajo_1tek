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
// consulto los datos
$SIS_query = 'Nombre,idRuta';
$SIS_join  = '';
$SIS_where = 'idRutaAlt ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'vehiculos_ruta_alternativa', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

//Se traen las rutas
$SIS_query = 'idUbicaciones, Latitud, Longitud, direccion';
$SIS_join  = '';
$SIS_where = 'idRuta ='.$rowData['idRuta'];
$SIS_order = 'idUbicaciones ASC';
$arrRutas = array();
$arrRutas = db_select_array (false, $SIS_query, 'vehiculos_rutas_ubicaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRutas');

//Se traen las rutas
$SIS_query = 'idUbicaciones, Latitud, Longitud, direccion';
$SIS_join  = '';
$SIS_where = 'idRutaAlt ='.$X_Puntero;
$SIS_order = 'idUbicaciones ASC';
$arrRutasAlt = array();
$arrRutasAlt = db_select_array (false, $SIS_query, 'vehiculos_ruta_alternativa_ubicaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRutasAlt');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ruta <?php echo $rowData['Nombre']; ?></h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

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
							var marker;

							async function initMap() {
								const { Map } = await google.maps.importLibrary("maps");

								var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

								var myOptions = {
									zoom: 12,
									center: myLatlng,
									mapTypeId: google.maps.MapTypeId.ROADMAP
								};

								map = new Map(document.getElementById("map_canvas"), myOptions);
								RutasAlternativas();

							}

							/* ************************************************************************** */
							function RutasAlternativas() {

								var route1=[];
								var route2=[];
								var tmp;

								var locations1 = [
								<?php foreach ( $arrRutas as $pos ) { ?>
									['<?php echo $pos['idUbicaciones']; ?>', <?php echo $pos['Latitud']; ?>, <?php echo $pos['Longitud']; ?>],
								<?php } ?>
								];

								var locations2 = [
								<?php foreach ( $arrRutasAlt as $pos ) { ?>
									['<?php echo $pos['idUbicaciones']; ?>', <?php echo $pos['Latitud']; ?>, <?php echo $pos['Longitud']; ?>],
								<?php } ?>
								];

								for(var i in locations1){
									tmp=new google.maps.LatLng(locations1[i][1], locations1[i][2]);
									route1.push(tmp);
								}

								for(var i in locations2){
									tmp=new google.maps.LatLng(locations2[i][1], locations2[i][2]);
									route2.push(tmp);
								}

								var drawn = new google.maps.Polyline({
									map: map,
									path: route1,
									strokeColor: 'blue',
									strokeOpacity: 1,
									strokeWeight: 5
								});

								var drawn = new google.maps.Polyline({
									map: map,
									path: route2,
									strokeColor: 'red',
									strokeOpacity: 1,
									strokeWeight: 5
								});

								//llamo a los puntos
								Puntos();
							}
							/* ************************************************************************** */
							function Puntos() {
								var infowindow = new google.maps.InfoWindow({
								  content: ''
								});
								var marcadores = [
								<?php
								$in=0;
								foreach ($arrRutas as $pos) {
										if($in==0){
											$in=1;
										}else{
											echo ',';
										}
									?>
								{
								  position: {
									lat: <?php echo $pos['Latitud']; ?>,
									lng: <?php echo $pos['Longitud']; ?>
								  },
								  contenido: "<?php echo $pos['direccion']; ?>"
								}
								<?php } ?>
								<?php
								$in=0;
								foreach ($arrRutasAlt as $pos) {
										if($in==0){
											echo ',';
										}else{
											echo ',';
										}
									?>
								{
								  position: {
									lat: <?php echo $pos['Latitud']; ?>,
									lng: <?php echo $pos['Longitud']; ?>
								  },
								  contenido: 	"<div id='iw-container'>" +
												"<div class='iw-title'>Dirección</div>" +
												"<div class='iw-content'>" +
												"<div class='iw-subTitle'>Calle</div>" +
												"<p><?php echo $pos['direccion']; ?></p>" +
												"</div>" +
												"<div class='iw-bottom-gradient'></div>" +
												"</div>"
								}
								<?php } ?>


								];
								for (let i = 0, j = marcadores.length; i < j; i++) {
								  var contenido = marcadores[i].contenido;
								  var marker = new google.maps.Marker({
									position	: new google.maps.LatLng(marcadores[i].position.lat, marcadores[i].position.lng),
									map			: map,
									animation 	: google.maps.Animation.DROP,
									icon      	: "<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
								  });
								  (function(marker, contenido) {
									google.maps.event.addListener(marker, 'click', function() {
									  infowindow.setContent(contenido);
									  infowindow.open(map, marker);
									});
								  })(marker, contenido);
								}

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
							}

						</script>
					<?php } ?>
				</div>
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
