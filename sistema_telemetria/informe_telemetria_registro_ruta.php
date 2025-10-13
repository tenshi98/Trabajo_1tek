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
$original = "informe_telemetria_registro_ruta.php";
$location = $original;
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
	//se verifica si se ingreso la hora, es un dato optativo
	$SIS_where = '';
	if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
		$SIS_where.= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
	}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
		$SIS_where.= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
	}
	//verifico el numero de datos antes de hacer la consulta
	$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

	//si el dato es superior a 10.000
	if(isset($ndata_1)&&$ndata_1>=10001){
		alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
	}else{

		//obtengo la cantidad real de sensores
		$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

		//consulto
		$SIS_query = 'idTabla, GeoLatitud, GeoLongitud';
		$SIS_join  = '';
		$SIS_order = 'FechaSistema ASC LIMIT 10000';
		$arrEquipos = array();
		$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

		?>


		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ruta del equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
				</header>
				<div class="table-responsive">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
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
									var speed = 500; // km/h
									var delay = 100;
									var locations = [
										<?php foreach ( $arrEquipos as $pos ) {
											if($pos['GeoLatitud']<0&&$pos['GeoLongitud']<0){ ?>
											['<?php echo $pos['idTabla']; ?>', <?php echo $pos['GeoLatitud']; ?>, <?php echo $pos['GeoLongitud']; ?>],
										<?php }
										} ?>
									];

									async function initMap() {
										const { Map } = await google.maps.importLibrary("maps");

										var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

										var myOptions = {
											zoom: 12,
											center: new google.maps.LatLng(locations[0][1], locations[0][2]),
											zoomControl: true,
											scaleControl: false,
											scrollwheel: false,
											disableDoubleClickZoom: true,
											mapTypeId: google.maps.MapTypeId.ROADMAP
										};

										map = new Map(document.getElementById("map_canvas"), myOptions);
										//Se llama a la ruta
										RutasAlternativas();
										//Se llama al marcador y se anima
										marker = new google.maps.Marker({
											position	: new google.maps.LatLng(locations[0][1], locations[0][2]),
											map			: map,
											animation 	: google.maps.Animation.DROP,
											icon      	: "<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
										});

										google.maps.event.addListenerOnce(map, 'idle', function()
										{
											animateMarker(marker, [
												<?php foreach ( $arrEquipos as $pos ) { ?>
													[<?php echo $pos['GeoLatitud']; ?>, <?php echo $pos['GeoLongitud']; ?>],
												<?php } ?>
											], speed);
										})

									}

									/* ************************************************************************** */
									function RutasAlternativas() {

										var route=[];
										var tmp;

										for(var i in locations){
											tmp=new google.maps.LatLng(locations[i][1], locations[i][2]);
											route.push(tmp);
										}

										var drawn = new google.maps.Polyline({
											map: map,
											path: route,
											strokeColor: 'blue',
											strokeOpacity: 1,
											strokeWeight: 5
										});
									}
									/* ************************************************************************** */
									function animateMarker(marker, coords, km_h){
										var target = 0;
										var targetx = 0;
										var km_h = km_h || 50;
										coords.push([locations[0][1], locations[0][2]]);
										goToPoint();

										function goToPoint(){
											var lat = marker.position.lat();
											var lng = marker.position.lng();
											var step = (km_h * 1000 * delay) / 3600000; // in meters

											var dest = new google.maps.LatLng(
											coords[target][0], coords[target][1]);

											var distance =
											google.maps.geometry.spherical.computeDistanceBetween(
											dest, marker.position); // in meters

											var numStep = distance / step;
											let i = 0;
											var deltaLat = (coords[target][0] - lat) / numStep;
											var deltaLng = (coords[target][1] - lng) / numStep;

											function moveMarker(){
												lat += deltaLat;
												lng += deltaLng;
												i += step;

												if (i < distance){
													marker.setPosition(new google.maps.LatLng(lat, lng));
													setTimeout(moveMarker, delay);
												}else{
													if(targetx==0){
														marker.setPosition(dest);
														target++;
														if (target == coords.length){ target = 0; }
														setTimeout(goToPoint, delay);
														targetx=1;
													}
												}
											}
											//centralizo el mapa en base al ultimo dato obtenido
											map.panTo(marker.getPosition());
											//muevo el marcador
											moveMarker();

										}
									}
								</script>

							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//filtros
	$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	$z .= " AND telemetria_listado.id_Geo=1";                                                //Geolocalizacion activa
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1Tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$z .= " AND telemetria_listado.idTab=3";//CrossTrack
	}
	//Se escribe el dato
	$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
	alert_post_data(2,1,1,0, $Alert_Text);

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
					if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
					if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
					if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
					if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}
					if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
					$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
					$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
					$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
					}
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
