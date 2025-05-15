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
$original = "vehiculos_rutas.php";
$location = $original;
$new_location = "vehiculos_rutas_configuracion.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_ruta'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_rutas_ubicaciones.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_ruta'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_rutas_ubicaciones.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_rutas_ubicaciones.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Ruta Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Ruta Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Ruta Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['mod'])){
// consulto los datos
$query = "SELECT Nombre
FROM `vehiculos_rutas`
WHERE idRuta = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

//Se traen las rutas
$query = "SELECT idUbicaciones, Latitud, Longitud, direccion
FROM `vehiculos_rutas_ubicaciones`
WHERE idUbicaciones = ".$_GET['mod'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowUbicacion = mysqli_fetch_assoc ($resultado);


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Ruta', $rowData['Nombre'], 'Editar Ruta'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'vehiculos_rutas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'vehiculos_rutas_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class="active"><a href="<?php echo 'vehiculos_rutas_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Editar Ruta</a></li>

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
						$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>
						<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
						<div id="map_canvas" style="width: 100%; height: 550px;"></div>
						<script>
							let map;
							var marker;

							async function initMap() {
								const { Map } = await google.maps.importLibrary("maps");

								var myLatlng = new google.maps.LatLng(<?php echo $rowUbicacion['Latitud']; ?>, <?php echo $rowUbicacion['Longitud']; ?>);

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

									document.getElementById("Latitud").value = event.latLng.lat();
									document.getElementById("Longitud").value = event.latLng.lng();
									codeLatLng(event.latLng.lat(),event.latLng.lng(),'direccion');

									document.getElementById("Latitud_fake").value = event.latLng.lat();
									document.getElementById("Longitud_fake").value = event.latLng.lng();
									codeLatLng(event.latLng.lat(),event.latLng.lng(),'direccion_fake');

								});

							}
							/* ************************************************************************** */
							//devuelve la dirección
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
						//Se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_input_disabled( 'Latitud', 'Latitud_fake', $rowUbicacion['Latitud']);
						$Form_Inputs->form_input_disabled( 'Longitud', 'Longitud_fake', $rowUbicacion['Longitud']);
						$Form_Inputs->form_input_disabled( 'Dirección', 'direccion_fake', $rowUbicacion['direccion']);

						$Form_Inputs->form_input_hidden('Latitud', $rowUbicacion['Latitud'], 2);
						$Form_Inputs->form_input_hidden('Longitud', $rowUbicacion['Longitud'], 2);
						$Form_Inputs->form_input_hidden('direccion', $rowUbicacion['direccion'], 2);
						$Form_Inputs->form_input_hidden('idUbicaciones', $_GET['mod'], 2);
						?>

						<div class="form-group">
							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Actualizar Punto" name="submit_edit_ruta">
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
	<a href="<?php echo $new_location.'&id='.$_GET['id'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{	 
// consulto los datos
$query = "SELECT Nombre
FROM `vehiculos_rutas`
WHERE idRuta = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

//Se traen las rutas
$arrRutas = array();
$query = "SELECT idUbicaciones, Latitud, Longitud, direccion
FROM `vehiculos_rutas_ubicaciones`
WHERE idRuta = ".$_GET['id']."
ORDER BY idUbicaciones ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrRutas,$row );
} ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Ruta', $rowData['Nombre'], 'Editar Ruta'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'vehiculos_rutas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'vehiculos_rutas_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class="active"><a href="<?php echo 'vehiculos_rutas_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Editar Ruta</a></li>

			</ul>
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

							async function initMap() {
								const { Map } = await google.maps.importLibrary("maps");

								var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

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
									animation 	:google.maps.Animation.DROP,
									icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
								});

								google.maps.event.addListener(marker, 'dragend', function (event) {

									document.getElementById("Latitud").value = event.latLng.lat();
									document.getElementById("Longitud").value = event.latLng.lng();
									codeLatLng(event.latLng.lat(),event.latLng.lng(),'direccion');

									document.getElementById("Latitud_fake").value = event.latLng.lat();
									document.getElementById("Longitud_fake").value = event.latLng.lng();
									codeLatLng(event.latLng.lat(),event.latLng.lng(),'direccion_fake');


								});

								RutasAlternativas();

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
							/* ************************************************************************** */
							//crea las rutas
							function RutasAlternativas() {

								var route=[];
								var tmp;

								var locations = [
								<?php foreach ( $arrRutas as $pos ) { ?>
									['<?php echo $pos['idUbicaciones']; ?>', <?php echo $pos['Latitud']; ?>, <?php echo $pos['Longitud']; ?>],
								<?php } ?>
								];

								for(var i in locations){
									tmp=new google.maps.LatLng(locations[i][1], locations[i][2]);
									route.push(tmp);
								}

								if(route){
									marker.setPosition(new google.maps.LatLng(locations[locations.length - 1][1], locations[locations.length - 1][2]));
									map.panTo(marker.position);
								}

								var drawn = new google.maps.Polyline({
									map: map,
									path: route,
									strokeColor: 'blue',
									strokeOpacity: 1,
									strokeWeight: 5
								});

								//llamo a los puntos
								Puntos();
							}
							/* ************************************************************************** */
							//pone los marcadores
							function Puntos() {
								var infowindow = new google.maps.InfoWindow({
								  content: ''
								});
								var marcadores = [
								<?php
								$in=0;
								$count_in=0;
								foreach ($arrRutas as $pos) {
									//cuento la cantidad de puntos
									$count_in++;

									//hago el resto
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
									if(i!=<?php echo $count_in-1; ?>){
										var contenido = marcadores[i].contenido;
										var marker = new google.maps.Marker({
											position: new google.maps.LatLng(marcadores[i].position.lat, marcadores[i].position.lng),
											map: map
										});

										(function(marker, contenido) {
											google.maps.event.addListener(marker, 'click', function() {
											infowindow.setContent(contenido);
											infowindow.open(map, marker);
										});
										})(marker, contenido);
									}

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

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div style="margin-top:20px;">
					<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

						<?php
						//Se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_input_disabled( 'Latitud', 'Latitud_fake', '');
						$Form_Inputs->form_input_disabled( 'Longitud', 'Longitud_fake', '');
						$Form_Inputs->form_input_disabled( 'Dirección', 'direccion_fake', '');

						$Form_Inputs->form_input_hidden('Latitud', 0, 2);
						$Form_Inputs->form_input_hidden('Longitud', 0, 2);
						$Form_Inputs->form_input_hidden('direccion', 0, 2);
						$Form_Inputs->form_input_hidden('idRuta', $_GET['id'], 2);
						?>

						<div class="form-group">
							<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Punto" name="submit_ruta">
						</div>

					</form>
					<?php widget_validator(); ?>
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
						<tr role="row">
							<th>Orden</th>
							<th>Calle</th>
							<th width="10">Acciones</th>
						</tr>
						</thead>

						<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						$nx=1;
						foreach ($arrRutas as $rutas) { ?>
							<tr class="odd">
								<td><?php echo $nx; ?></td>
								<td><?php echo $rutas['direccion']; ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&mod='.$rutas['idUbicaciones']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($rutas['idUbicaciones'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el dato '.$rutas['direccion'].'?'; ?>
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
