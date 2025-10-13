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
$original = "cross_predios_listado.php";
$location = $original;
$new_location = "cross_predios_listado_configuracion.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_zona'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado_zonas.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_zona'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado_zonas.php';
}
//se borra un dato
if (!empty($_GET['del_zona'])){
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_zona';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado_zonas.php';
}
/****************************************************/
//formulario para crear
if (!empty($_POST['submit_punto'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location .='&edit_puntos='.$_GET['edit_puntos'];
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado_zonas_ubicaciones.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_punto'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location .='&edit_puntos='.$_GET['edit_puntos'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado_zonas_ubicaciones.php';
}
//se borra un dato
if (!empty($_GET['del_punto'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location .='&edit_puntos='.$_GET['edit_puntos'];
	//Llamamos al formulario
	$form_trabajo= 'del_punto';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado_zonas_ubicaciones.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Cuartel Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Cuartel Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Cuartel Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['mod'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cross_predios_listado_zonas.Nombre,
	cross_predios_listado.Direccion,
	core_ubicacion_ciudad.Nombre AS Ciudad,
	core_ubicacion_comunas.Nombre AS Comuna';
	$SIS_join  = '
	LEFT JOIN `cross_predios_listado`    ON cross_predios_listado.idPredio    = cross_predios_listado_zonas.idPredio
	LEFT JOIN `core_ubicacion_ciudad`    ON core_ubicacion_ciudad.idCiudad    = cross_predios_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`   ON core_ubicacion_comunas.idComuna   = cross_predios_listado.idComuna';
	$SIS_where = 'cross_predios_listado_zonas.idZona ='.$_GET['edit_puntos'];
	$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Latitud, Longitud';
	$SIS_join  = '';
	$SIS_where = 'idUbicaciones = '.$_GET['mod'];
	$rowUbicacion = db_select_data (false, $SIS_query, 'cross_predios_listado_zonas_ubicaciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowUbicacion');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUbicaciones, Latitud, Longitud';
	$SIS_join  = '';
	$SIS_where = 'idZona = '.$_GET['edit_puntos'];
	$SIS_order = 'idUbicaciones ASC';
	$arrPuntos = array();
	$arrPuntos = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas_ubicaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPuntos');

	/*******************************************************/
	//Se obtiene la ubicacion
	$Ubicacion = $rowData['Direccion'];
	if(isset($rowData['Comuna'])&&$rowData['Comuna']!=''){$Ubicacion.=', '.$rowData['Comuna'];}
	if(isset($rowData['Ciudad'])&&$rowData['Ciudad']!=''){$Ubicacion.=', '.$rowData['Ciudad'];}

	//Se limpian los nombres
	$Ubicacion = str_replace('Nº', '', $Ubicacion);
	$Ubicacion = str_replace('nº', '', $Ubicacion);
	$Ubicacion = str_replace(' n ', '', $Ubicacion);

	$Ubicacion = str_replace("'", '', $Ubicacion);

	$Ubicacion = str_replace("Av.", 'Avenida', $Ubicacion);
	$Ubicacion = str_replace("av.", 'Avenida', $Ubicacion);

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Puntos del Cuartel <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="table-responsive">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
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
								var geocoder = new google.maps.Geocoder();

								async function initMap() {
									const { Map } = await google.maps.importLibrary("maps");

									var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

									var myOptions = {
										zoom: 18,
										center: myLatlng,
										mapTypeId: google.maps.MapTypeId.SATELLITE
									};

									map = new Map(document.getElementById("map_canvas"), myOptions);
									map.setTilt(0);

									marker = new google.maps.Marker({
										draggable	: true,
										position	: myLatlng,
										map			: map,
										title		: "Tu Ubicación",
										animation 	:google.maps.Animation.DROP,
										icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
									});

									google.maps.event.addListener(marker, 'dragend', function (event) {

										document.getElementById("Latitud").value = event.latLng.lat();
										document.getElementById("Longitud").value = event.latLng.lng();

										document.getElementById("Latitud_fake").value = event.latLng.lat();
										document.getElementById("Longitud_fake").value = event.latLng.lng();

									});

									dibuja_zona();

								}

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
											fillOpacity: 0.35
										});
										bermudaTriangle.setMap(map);

									<?php

									if(isset($rowUbicacion['Latitud'])&&$rowUbicacion['Latitud']!=''&&isset($rowUbicacion['Longitud'])&&$rowUbicacion['Longitud']!=''){
										echo 'myLatlng = new google.maps.LatLng('.$rowUbicacion['Latitud'].', '.$rowUbicacion['Longitud'].');
											marker.setPosition(myLatlng);
											map.setCenter(myLatlng);
											map.panTo(marker.position);';
									}else{ ?>
										codeAddress();
									<?php } ?>

								}
								/* ************************************************************************** */
								function codeAddress() {

									geocoder.geocode( { address: '<?php echo $Ubicacion ?>'}, function(results, status) {
										if (status == google.maps.GeocoderStatus.OK) {

											// marker position
											myLatlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

											map.setCenter(myLatlng);

										}else {
											Swal.fire({icon: 'error',title: 'Oops...',text: 'Geocode was not successful for the following reason: ' + status});
										}
									});
								}


							</script>
						<?php } ?>
					</div>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div style="margin-top:20px;">
						<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

							<?php
							//Se dibujan los inputs
							$Form_Inputs = new Form_Inputs();
							$Form_Inputs->form_input_disabled( 'Latitud', 'Latitud_fake', $rowUbicacion['Latitud']);
							$Form_Inputs->form_input_disabled( 'Longitud', 'Longitud_fake', $rowUbicacion['Longitud']);

							$Form_Inputs->form_input_hidden('Latitud', $rowUbicacion['Latitud'], 2);
							$Form_Inputs->form_input_hidden('Longitud', $rowUbicacion['Longitud'], 2);
							$Form_Inputs->form_input_hidden('idPredio', $_GET['id'], 2);
							$Form_Inputs->form_input_hidden('idZona', $_GET['edit_puntos'], 2);
							$Form_Inputs->form_input_hidden('idUbicaciones', $_GET['mod'], 2);

							?>

							<div class="form-group">
								<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Actualizar Punto" name="submit_edit_punto">
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
		<a href="<?php echo $new_location.'&edit_puntos='.$_GET['edit_puntos'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_puntos'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cross_predios_listado_zonas.Nombre,
	cross_predios_listado.Direccion,
	core_ubicacion_ciudad.Nombre AS Ciudad,
	core_ubicacion_comunas.Nombre AS Comuna';
	$SIS_join  = '
	LEFT JOIN `cross_predios_listado`    ON cross_predios_listado.idPredio    = cross_predios_listado_zonas.idPredio
	LEFT JOIN `core_ubicacion_ciudad`    ON core_ubicacion_ciudad.idCiudad    = cross_predios_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`   ON core_ubicacion_comunas.idComuna   = cross_predios_listado.idComuna';
	$SIS_where = 'cross_predios_listado_zonas.idZona = '.$_GET['edit_puntos'];
	$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUbicaciones, Latitud, Longitud';
	$SIS_join  = '';
	$SIS_where = 'idZona = '.$_GET['edit_puntos'];
	$SIS_order = 'idUbicaciones ASC';
	$arrPuntos = array();
	$arrPuntos = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas_ubicaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPuntos');

	/*******************************************************/
	// consulto los datos
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
	$SIS_where = 'cross_predios_listado_zonas.idPredio = '.$_GET['id'];
	$SIS_where.= ' AND cross_predios_listado_zonas_ubicaciones.idZona!='.$_GET['edit_puntos'];
	$SIS_order = 'cross_predios_listado_zonas.idZona ASC';
	$SIS_order.= ', cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
	$arrZonas = array();
	$arrZonas = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrZonas');

	/*******************************************************/
	//Se limpian los nombres
	$Ubicacion = $rowData['Direccion'].', '.$rowData['Comuna'].', '.$rowData['Ciudad'];

	$Ubicacion = str_replace('Nº', '', $Ubicacion);
	$Ubicacion = str_replace('nº', '', $Ubicacion);
	$Ubicacion = str_replace(' n ', '', $Ubicacion);

	$Ubicacion = str_replace("'", '', $Ubicacion);

	$Ubicacion = str_replace("Av.", 'Avenida', $Ubicacion);
	$Ubicacion = str_replace("av.", 'Avenida', $Ubicacion);

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Puntos del Cuartel <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="table-responsive">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
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
								var geocoder = new google.maps.Geocoder();

								async function initMap() {
									const { Map } = await google.maps.importLibrary("maps");

									var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

									var myOptions = {
										zoom: 18,
										center: myLatlng,
										mapTypeId: google.maps.MapTypeId.SATELLITE
									};

									map = new Map(document.getElementById("map_canvas"), myOptions);
									map.setTilt(0);

									marker = new google.maps.Marker({
										draggable	: true,
										position	: myLatlng,
										map			: map,
										title		: "Tu Ubicación",
										animation 	:google.maps.Animation.DROP,
										icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
									});

									google.maps.event.addListener(marker, 'dragend', function (event) {

										document.getElementById("Latitud").value = event.latLng.lat();
										document.getElementById("Longitud").value = event.latLng.lng();

										document.getElementById("Latitud_fake").value = event.latLng.lat();
										document.getElementById("Longitud_fake").value = event.latLng.lng();

									});

									dibuja_zona();

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
									//Se filtra por zona
									filtrar($arrZonas, 'idZona');
									//se recorre
									foreach ($arrZonas as $todaszonas=>$zonas) {

										echo 'var path'.$todaszonas.' = [';

										//Variables con la primera posicion
										$Latitud_x = '';
										$Longitud_x = '';

										foreach ($zonas as $puntos) {
											if(isset($puntos['Latitud'])&&$puntos['Latitud']!=''&&isset($puntos['Longitud'])&&$puntos['Longitud']!=''){
												echo '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},
												';
												if(isset($puntos['Latitud'])&&$puntos['Latitud']!='0'&&isset($puntos['Longitud'])&&$puntos['Longitud']!='0'){
													$Latitud_x = $puntos['Latitud'];
													$Longitud_x = $puntos['Longitud'];
													//Calculos para centrar mapa
													$Latitud_z  = $Latitud_z+$puntos['Latitud'];
													$Longitud_z = $Longitud_z+$puntos['Longitud'];
													$zcounter++;
												}
											}
										}
										//se cierra la figura
										if(isset($Longitud_x)&&$Longitud_x!=''){
											echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
										}
										echo '];';

										echo '
										polygons.push(new google.maps.Polygon({
											paths: path'.$todaszonas.',
											strokeColor: \'#1E90FF\',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: \'#1E90FF\',
											fillOpacity: 0.35
										}));
										polygons[polygons.length-1].setMap(map);
										';
									}

									/*********************************************************/
									//Variables con la primera posicion
									$Latitud_x = '';
									$Longitud_x = '';
									?>

									var triangleCoords = [
										<?php //recorrer
										foreach ($arrPuntos as $puntos) {
											echo '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},
											';
											if(isset($puntos['Latitud'])&&$puntos['Latitud']!='0'){
												$Latitud_x = $puntos['Latitud'];
												$Longitud_x = $puntos['Longitud'];
											}
										}
										if(isset($Longitud_x)&&$Longitud_x!=''){
											echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
										} ?>
									];

									// Construct the polygon.
									var bermudaTriangle = new google.maps.Polygon({
										paths: triangleCoords,
										strokeColor: '#FF0000',
										strokeOpacity: 0.8,
										strokeWeight: 2,
										fillColor: '#FF0000',
										fillOpacity: 0.35
									});
									bermudaTriangle.setMap(map);

									<?php
									if(isset($Latitud_x)&&$Latitud_x!=''&&isset($Longitud_x)&&$Longitud_x!=''){
										echo 'marker.setPosition(new google.maps.LatLng('.$Latitud_x.', '.$Longitud_x.'));
											map.panTo(marker.position);';
									}else{ ?>
										codeAddress();
									<?php } ?>

								}
								/* ************************************************************************** */
								function codeAddress() {

									geocoder.geocode( { address: '<?php echo $Ubicacion ?>'}, function(results, status) {
										if (status == google.maps.GeocoderStatus.OK) {

											// marker position
											myLatlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

											map.setCenter(myLatlng);
											marker.setPosition(myLatlng);

										}else {
											Swal.fire({icon: 'error',title: 'Oops...',text: 'Geocode was not successful for the following reason: ' + status});
										}
									});
								}


							</script>
						<?php } ?>
					</div>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div style="margin-top:20px;">
						<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

							<?php
							//Se dibujan los inputs
							$Form_Inputs = new Form_Inputs();
							$Form_Inputs->form_input_disabled( 'Latitud', 'Latitud_fake', '');
							$Form_Inputs->form_input_disabled( 'Longitud', 'Longitud_fake', '');

							$Form_Inputs->form_input_hidden('Latitud', 0, 2);
							$Form_Inputs->form_input_hidden('Longitud', 0, 2);
							$Form_Inputs->form_input_hidden('idPredio', $_GET['id'], 2);
							$Form_Inputs->form_input_hidden('idZona', $_GET['edit_puntos'], 2);

							?>

							<div class="form-group">
								<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Punto" name="submit_punto">
							</div>

						</form>
						<?php widget_validator(); ?>
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
							<tr role="row">
								<th>Orden</th>
								<th>Ubicación</th>
								<th width="10">Acciones</th>
							</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php
								$nx=1;
								foreach ($arrPuntos as $pos) { ?>
									<tr class="odd">
										<td><?php echo $nx; ?></td>
										<td><?php echo 'lat: '.$pos['Latitud'].'<br/>lng: '.$pos['Longitud']; ?></td>
										<td>
											<div class="btn-group" style="width: 70px;" >
												<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&edit_puntos='.$_GET['edit_puntos'].'&mod='.$pos['idUbicaciones']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=2){
													$ubicacion = $new_location.'&edit_puntos='.$_GET['edit_puntos'].'&del_punto='.simpleEncode($pos['idUbicaciones'], fecha_actual());
													$dialogo   = '¿Realmente deseas eliminar el dato?'; ?>
													<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php } ?>
											</div>
										</td>
									</tr>
								<?php
								$nx++;
								} ?>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $new_location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_zona'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre,Codigo,idCategoria,idProducto,AnoPlantacion,Hectareas,Hileras,Plantas,
	idEstadoProd,DistanciaPlant,DistanciaHileras,idEstado';
	$SIS_join  = '';
	$SIS_where = 'idZona = '.$_GET['edit_zona'];
	$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Cuartel</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){           $x1  = $Nombre;            }else{$x1  = $rowData['Nombre'];}
					if(isset($Codigo)){           $x2  = $Codigo;            }else{$x2  = $rowData['Codigo'];}
					if(isset($idCategoria)){      $x3  = $idCategoria;       }else{$x3  = $rowData['idCategoria'];}
					if(isset($idProducto)){       $x4  = $idProducto;        }else{$x4  = $rowData['idProducto'];}
					if(isset($AnoPlantacion)){    $x5  = $AnoPlantacion;     }else{$x5  = $rowData['AnoPlantacion'];}
					if(isset($Hectareas)){        $x6  = $Hectareas;         }else{$x6  = $rowData['Hectareas'];}
					if(isset($Hileras)){          $x7  = $Hileras;           }else{$x7  = $rowData['Hileras'];}
					if(isset($Plantas)){          $x8  = $Plantas;           }else{$x8  = $rowData['Plantas'];}
					if(isset($idEstadoProd)){     $x9  = $idEstadoProd;      }else{$x9  = $rowData['idEstadoProd'];}
					if(isset($DistanciaPlant)){   $x10 = $DistanciaPlant;    }else{$x10 = $rowData['DistanciaPlant'];}
					if(isset($DistanciaHileras)){ $x11 = $DistanciaHileras;  }else{$x11 = $rowData['DistanciaHileras'];}
					if(isset($idEstado)){         $x12 = $idEstado;          }else{$x12 = $rowData['idEstado'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre del Cuartel', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Codigo del Cuartel', 'Codigo', $x2, 2);
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x3, 2, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
											'Variedad','idProducto', $x4, 2, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select_n_auto('Año plantación','AnoPlantacion', $x5, 2, 1975, ano_actual());
					$Form_Inputs->form_input_number_spinner('N° Hectáreas','Hectareas', $x6, 0, 500, '0.01', 2, 2);
					$Form_Inputs->form_input_number_spinner('N° Hileras','Hileras', $x7, 0, 2000, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('N° Plantas','Plantas', $x8, 0, 200000, 1, 0, 2);
					$Form_Inputs->form_select('Estado productivo','idEstadoProd', $x9, 2, 'idEstadoProd', 'Nombre', 'core_cross_estados_productivos', 0, '', $dbConn);
					$Form_Inputs->form_input_number_spinner('Distancia de plantación','DistanciaPlant', $x10, 0, 100, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Distancia Hileras','DistanciaHileras', $x11, 0, 100, '0.1', 1, 2);
					$Form_Inputs->form_select('Estado','idEstado', $x12, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('idPredio', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idZona', $_GET['edit_zona'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_zona">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Cuartel</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){           $x1  = $Nombre;            }else{$x1  = '';}
					if(isset($Codigo)){           $x2  = $Codigo;            }else{$x2  = '';}
					if(isset($idCategoria)){      $x3  = $idCategoria;       }else{$x3  = '';}
					if(isset($idProducto)){       $x4  = $idProducto;        }else{$x4  = '';}
					if(isset($AnoPlantacion)){    $x5  = $AnoPlantacion;     }else{$x5  = '';}
					if(isset($Hectareas)){        $x6  = $Hectareas;         }else{$x6  = '';}
					if(isset($Hileras)){          $x7  = $Hileras;           }else{$x7  = '';}
					if(isset($Plantas)){          $x8  = $Plantas;           }else{$x8  = '';}
					if(isset($idEstadoProd)){     $x9  = $idEstadoProd;      }else{$x9  = '';}
					if(isset($DistanciaPlant)){   $x10 = $DistanciaPlant;    }else{$x10 = '';}
					if(isset($DistanciaHileras)){ $x11 = $DistanciaHileras;  }else{$x11 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre del Cuartel', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Codigo del Cuartel', 'Codigo', $x2, 2);
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x3, 2, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
											'Variedad','idProducto', $x4, 2, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select_n_auto('Año plantación','AnoPlantacion', $x5, 2, 1975, ano_actual());
					$Form_Inputs->form_input_number_spinner('N° Hectáreas','Hectareas', $x6, 0, 500, '0.01', 2, 2);
					$Form_Inputs->form_input_number_spinner('N° Hileras','Hileras', $x7, 0, 2000, 1, 0, 2);
					$Form_Inputs->form_input_number_spinner('N° Plantas','Plantas', $x8, 0, 200000, 1, 0, 2);
					$Form_Inputs->form_select('Estado productivo','idEstadoProd', $x9, 2, 'idEstadoProd', 'Nombre', 'core_cross_estados_productivos', 0, '', $dbConn);
					$Form_Inputs->form_input_number_spinner('Distancia de plantación','DistanciaPlant', $x10, 0, 100, '0.1', 1, 2);
					$Form_Inputs->form_input_number_spinner('Distancia Hileras','DistanciaHileras', $x11, 0, 100, '0.1', 1, 2);

					$Form_Inputs->form_input_hidden('idPredio', $_GET['id'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_zona">
						<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	$SIS_join  = '';
	$SIS_where = 'idPredio = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cross_predios_listado_zonas.idZona,
	cross_predios_listado_zonas.Nombre AS CuartelNombre,
	cross_predios_listado_zonas.AnoPlantacion AS CuartelAnoPlantacion,
	cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
	cross_predios_listado_zonas.Hileras AS CuartelHileras,
	cross_predios_listado_zonas.Plantas AS CuartelPlantas,
	cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
	cross_predios_listado_zonas.DistanciaHileras AS CuartelDistanciaHileras,
	sistema_variedades_categorias.Nombre AS CuartelEspecie,
	variedades_listado.Nombre AS CuartelVariedad,
	core_cross_estados_productivos.Nombre AS CuartelEstadoProd';
	$SIS_join  = '
	LEFT JOIN `sistema_variedades_categorias`    ON sistema_variedades_categorias.idCategoria     = cross_predios_listado_zonas.idCategoria
	LEFT JOIN `variedades_listado`               ON variedades_listado.idProducto                 = cross_predios_listado_zonas.idProducto
	LEFT JOIN `core_cross_estados_productivos`   ON core_cross_estados_productivos.idEstadoProd   = cross_predios_listado_zonas.idEstadoProd';
	$SIS_where = 'cross_predios_listado_zonas.idPredio ='.$_GET['id'];
	$SIS_order = 'sistema_variedades_categorias.Nombre ASC';
	$SIS_order.= ', variedades_listado.Nombre ASC';
	$SIS_order.= ', cross_predios_listado_zonas.Nombre ASC';
	$arrZonas = array();
	$arrZonas = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrZonas');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Predio', $rowData['Nombre'], 'Editar Cuarteles'); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
			<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Cuartel</a><?php } ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class=""><a href="<?php echo 'cross_predios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'cross_predios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'cross_predios_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
					<li class="active"><a href="<?php echo 'cross_predios_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Editar Cuarteles</a></li>
				</ul>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Especie</th>
							<th>Variedad</th>
							<th>Nombre <br/>Cuartel</th>
							<th>Estado <br/>Productivo</th>
							<th>Año <br/>Plantacion</th>
							<th>N° Hectareas</th>
							<th>Cantidad <br/>Plantas</th>
							<th>Cantidad <br/>Hileras</th>
							<th>Distancia <br/>Plantacion</th>
							<th>Distancia <br/>Hileras</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrZonas as $zona) { ?>
						<tr class="odd">
							<td><?php echo $zona['CuartelEspecie']; ?></td>
							<td><?php echo $zona['CuartelVariedad']; ?></td>
							<td><?php echo $zona['CuartelNombre']; ?></td>
							<td><?php echo $zona['CuartelEstadoProd']; ?></td>
							<td><?php echo $zona['CuartelAnoPlantacion']; ?></td>
							<td><?php echo $zona['CuartelHectareas']; ?></td>
							<td><?php echo $zona['CuartelPlantas']; ?></td>
							<td><?php echo $zona['CuartelHileras']; ?></td>
							<td><?php echo $zona['CuartelDistanciaPlant']; ?></td>
							<td><?php echo $zona['CuartelDistanciaHileras']; ?></td>
							<td>
								<div class="btn-group" style="width: 140px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_zona.php?view='.simpleEncode($zona['idZona'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&edit_puntos='.$zona['idZona']; ?>" title="Editar Puntos" class="btn btn-success btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&edit_zona='.$zona['idZona']; ?>" title="Editar Información Basica" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										//se verifica que el usuario no sea uno mismo
										$ubicacion = $new_location.'&del_zona='.simpleEncode($zona['idZona'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el cuartel '.$zona['CuartelNombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
