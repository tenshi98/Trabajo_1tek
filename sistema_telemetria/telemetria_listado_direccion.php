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
$original = "telemetria_listado.php";
$location = $original;
$new_location = "telemetria_listado_direccion.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Dirección Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Dirección Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Dirección Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$rowData = db_select_data (false, 'Nombre,idCiudad,idComuna,Direccion,GeoLatitud,GeoLongitud,id_Geo, id_Sensores, idZona', 'telemetria_listado', '', 'idTelemetria ='.$_GET['id'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Nombre'], 'Editar Datos Dirección'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'telemetria_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'telemetria_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'telemetria_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'telemetria_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<?php if($rowData['id_Sensores']==1){ ?>
							<li class=""><a href="<?php echo 'telemetria_listado_alarmas_perso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bullhorn" aria-hidden="true"></i> Alarmas Personalizadas</a></li>
						<?php } ?>
						<?php if($rowData['id_Geo']==1){ ?>
							<li class=""><a href="<?php echo 'telemetria_listado_gps.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Datos GPS</a></li>
						<?php }elseif($rowData['id_Geo']==2){ ?>
							<li class="active"><a href="<?php echo 'telemetria_listado_direccion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-signs" aria-hidden="true"></i> Dirección</a></li>
						<?php } ?>
						<?php if($rowData['id_Sensores']==1){ ?>
							<li class=""><a href="<?php echo 'telemetria_listado_parametros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Sensores</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_sensor_operaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Definicion Operacional</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'telemetria_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_trabajo.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-clock-o" aria-hidden="true"></i> Jornada Trabajo</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_otros_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-archive" aria-hidden="true"></i> Otros Datos</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class=""><a href="<?php echo 'telemetria_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>

					</ul>
                </li>
			</ul>
		</header>
		<div class="table-responsive">

			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="row">
					<?php
					//Si no existe una ID se utiliza una por defecto
					if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
						$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
						alert_post_data(4,2,2,0, $Alert_Text);
					}else{
						$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle'];

						if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!='' && $rowData['GeoLatitud']!=0){
							$nlat = $rowData['GeoLatitud'];
						}else{
							$nlat = '-33.4372';
						}

						if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!='' && $rowData['GeoLongitud']!=0){
							$nlong = $rowData['GeoLongitud'];
						}else{
							$nlong = '-70.6506';
						} ?>
						<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>

						<input id="pac-input" class="pac-controls" type="text" placeholder="Buscar Dirección">
						<div id="map_canvas" style="width: 100%; height: 550px;"></div>
						<script>
							let map;
							var marker;

							async function initMap() {
								const { Map } = await google.maps.importLibrary("maps");

								var myLatlng = new google.maps.LatLng(<?php echo $nlat; ?>, <?php echo $nlong; ?>);

								var myOptions = {
									zoom: 12,
									center: myLatlng,
									mapTypeId: google.maps.MapTypeId.ROADMAP
								};

								map = new Map(document.getElementById("map_canvas"), myOptions);

								marker = new google.maps.Marker({
									draggable	: true,
									position	: myLatlng,
									map			: map,
									title		: "Tu Ubicación",
									animation 	: google.maps.Animation.DROP,
									icon      	: "<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
								});

								google.maps.event.addListener(marker, 'dragend', function (event) {

									document.getElementById("GeoLatitud").value = event.latLng.lat();
									document.getElementById("GeoLongitud").value = event.latLng.lng();
									codeLatLng(event.latLng.lat(),event.latLng.lng(),'Direccion');

									document.getElementById("Latitud_fake").value = event.latLng.lat();
									document.getElementById("Longitud_fake").value = event.latLng.lng();

								});

								//Se define el cuadro de busqueda
								var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));
								map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('pac-input'));
								google.maps.event.addListener(searchBox, 'places_changed', function() {
									searchBox.set('map', null);

									var places = searchBox.getPlaces();

									var bounds = new google.maps.LatLngBounds();
									var i, place;
									for (i = 0; place = places[i]; i++) {
										(function(place) {

											var myLatlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
											marker.setPosition(myLatlng);

											bounds.extend(place.geometry.location);

											document.getElementById("GeoLatitud").value = place.geometry.location.lat();
											document.getElementById("GeoLongitud").value = place.geometry.location.lng();
											codeLatLng(place.geometry.location.lat(),place.geometry.location.lng(),'Direccion');
											document.getElementById("Latitud_fake").value = place.geometry.location.lat();
											document.getElementById("Longitud_fake").value = place.geometry.location.lng();

										}(place));

									}

									map.fitBounds(bounds);
									searchBox.set('map', map);
									map.setZoom(Math.min(map.getZoom(),12));

								});

							}


							/* ************************************************************************** */
							function codeLatLng(lat,lng, div) {
								geocoder = new google.maps.Geocoder();
								var latlng = new google.maps.LatLng(lat, lng);
								geocoder.geocode({'latLng': latlng}, function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {
										if (results[0]) {
											document.getElementById(div).value = results[0].formatted_address;
										}else {
											Swal.fire({icon: 'error',title: 'Oops...',text: 'Sin resultados encontrados.'});
										}
									}else {
										Swal.fire({icon: 'error',title: 'Oops...',text: 'Geocoder ha fallado por: ' + status});
									}
								});
							}

						</script>
					<?php } ?>
				</div>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div style="margin-top:20px;">
					<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

						<?php
						if(isset($idZona)){      $x0  = $idZona;      }else{$x0  = $rowData['idZona'];}
						if(isset($idCiudad)){    $x1  = $idCiudad;    }else{$x1  = $rowData['idCiudad'];}
						if(isset($idComuna)){    $x2  = $idComuna;    }else{$x2  = $rowData['idComuna'];}

						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_select('Zona','idZona', $x0, 1, 'idZona', 'Nombre', 'telemetria_zonas', 0, '', $dbConn);
						$Form_Inputs->form_select_depend1('Región','idCiudad', $x1, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
												'Comuna','idComuna', $x2, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
												 $dbConn, 'form1');

						$Form_Inputs->form_input_icon('Dirección', 'Direccion', $rowData['Direccion'], 1,'fa fa-map');
						$Form_Inputs->form_input_disabled('Latitud', 'Latitud_fake', $rowData['GeoLatitud']);
						$Form_Inputs->form_input_disabled('Longitud', 'Longitud_fake', $rowData['GeoLongitud']);

						$Form_Inputs->form_input_hidden('GeoLatitud', $rowData['GeoLatitud'], 2);
						$Form_Inputs->form_input_hidden('GeoLongitud', $rowData['GeoLongitud'], 2);
						$Form_Inputs->form_input_hidden('idTelemetria', $_GET['id'], 2);
						?>

						<div class="form-group">
							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_edit">
						</div>

					</form>
					<?php widget_validator(); ?>

				</div>
			</div>

		</div>

	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
