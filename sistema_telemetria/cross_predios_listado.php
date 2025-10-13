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
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){        $location .= "&Nombre=".$_GET['Nombre'];        $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){    $location .= "&idEstado=".$_GET['idEstado'];    $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['idPais']) && $_GET['idPais']!=''){        $location .= "&idPais=".$_GET['idPais'];        $search .= "&idPais=".$_GET['idPais'];}
if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){    $location .= "&idCiudad=".$_GET['idCiudad'];    $search .= "&idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){    $location .= "&idComuna=".$_GET['idComuna'];    $search .= "&idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){  $location .= "&Direccion=".$_GET['Direccion'];  $search .= "&Direccion=".$_GET['Direccion'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_plant'])){
	//Llamamos al formulario
	$form_trabajo= 'insert_plant';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_predios_listado.php';
}

//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/cross_predios_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Predio Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Predio Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Predio Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['new_plantilla'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//cuadro para descargar
	$Alert_Text  = 'Descargar Plantilla';
	$Alert_Text .= '<a href="1download.php?dir='.simpleEncode('templates', fecha_actual()).'&file='.simpleEncode('plantilla_predios.xlsx', fecha_actual()).'" title="Descargar Plantilla" class="btn btn-primary btn-sm pull-right" ><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>';
	alert_post_data(2,1,2,0, $Alert_Text);

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Predio con Plantilla</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

					<?php
					//Se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_multiple_upload('Seleccionar archivo','FilePredio', 1, '"xlsx"');

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_plant">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	// consulto los datos
	$SIS_query = '
	cross_predios_listado.Nombre,
	cross_predios_listado.Direccion,
	core_ubicacion_ciudad.Nombre AS Ciudad,
	core_ubicacion_comunas.Nombre AS Comuna';
	$SIS_join  = '
	LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad   = cross_predios_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna  = cross_predios_listado.idComuna';
	$SIS_where = 'cross_predios_listado.idPredio ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Se traen las zonas
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
	$SIS_where = 'cross_predios_listado_zonas.idPredio ='.$_GET['id'];
	$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
	$arrZonas = array();
	$arrZonas = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrZonas');

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

	//Se limpian los nombres
	$Ubicacion = str_replace('Nº', '', $Ubicacion);
	$Ubicacion = str_replace('nº', '', $Ubicacion);
	$Ubicacion = str_replace(' n ', '', $Ubicacion);

	$Ubicacion = str_replace("'", '', $Ubicacion);

	$Ubicacion = str_replace("Av.", 'Avenida', $Ubicacion);
	$Ubicacion = str_replace("av.", 'Avenida', $Ubicacion);

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Predio', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'cross_predios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'cross_predios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'cross_predios_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
					<li class=""><a href="<?php echo 'cross_predios_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Editar Cuarteles</a></li>
				</ul>
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

							<style>
								.my_marker {color: white;background-color: black;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
								.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
							</style>

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
									$Latitud_z        = 0;
									$Longitud_z       = 0;
									$Latitud_z_prom   = 0;
									$Longitud_z_prom  = 0;
									$zcounter         = 0;
									$zcounter2        = 0;

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
										//se cierra la figura
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

										/*if(isset($Latitud_x)&&$Latitud_x!=''&&isset($Longitud_x)&&$Longitud_x!=''){
											echo 'myLatlng = new google.maps.LatLng('.$Latitud_x.', '.$Longitud_x.');
													map.setCenter(myLatlng);';
										}else{
											echo 'codeAddress();';
										}*/

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

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Predio</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){          $x1  = $Nombre;           }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre del Predio', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
	//paginador de resultados
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	/**********************************************************/
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'nombre_asc':    $order_by = 'cross_predios_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
			case 'nombre_desc':   $order_by = 'cross_predios_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'estado_asc':    $order_by = 'core_estados.Nombre ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':   $order_by = 'core_estados.Nombre DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

			default: $order_by = 'cross_predios_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
		}
	}else{
		$order_by = 'cross_predios_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "cross_predios_listado.idPredio!=0";
	$SIS_where.= " AND cross_predios_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//Verifico el tipo de usuario que esta ingresando

	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){    $SIS_where .= " AND cross_predios_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){$SIS_where .= " AND cross_predios_listado.idEstado=".$_GET['idPais'];}
	if(isset($_GET['idPais']) && $_GET['idPais']!=''){    $SIS_where .= " AND cross_predios_listado.idPais=".$_GET['idPais'];}
	if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){$SIS_where .= " AND cross_predios_listado.idCiudad=".$_GET['idCiudad'];}
	if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){$SIS_where .= " AND cross_predios_listado.idComuna=".$_GET['idComuna'];}
	if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){     $SIS_where .= " AND cross_predios_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idPredio', 'cross_predios_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	cross_predios_listado.idPredio,
	cross_predios_listado.Nombre,
	core_sistemas.Nombre AS sistema,
	core_estados.Nombre AS estado,
	cross_predios_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`    ON core_sistemas.idSistema   = cross_predios_listado.idSistema
	LEFT JOIN `core_estados`     ON core_estados.idEstado     = cross_predios_listado.idEstado';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrUsers = array();
	$arrUsers = db_select_array (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Predio</a><?php } ?>
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new_plantilla=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear con Plantilla</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){          $x1  = $Nombre;       }else{$x1  = '';}
					if(isset($idEstado)){        $x2  = $idEstado;     }else{$x2  = '';}
					if(isset($idPais)){          $x3  = $idPais;       }else{$x3  = '';}
					if(isset($idCiudad)){        $x4  = $idCiudad;     }else{$x4  = '';}
					if(isset($idComuna)){        $x5  = $idComuna;     }else{$x5  = '';}
					if(isset($Direccion)){       $x6  = $Direccion;    }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre del Predio', 'Nombre', $x1, 1);
					$Form_Inputs->form_select('Estado','idEstado', $x2, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
					$Form_Inputs->form_select_country('Pais','idPais', $x3, 1, $dbConn);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x4, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x5, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x6, 1,'fa fa-map');

					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
						<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Predios</h5>
				<div class="toolbar">
					<?php
					//Se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrUsers as $usuarios){ ?>
						<tr class="odd">
							<td><?php echo $usuarios['Nombre']; ?></td>
							<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_predio.php?view='.simpleEncode($usuarios['idPredio'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idPredio']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										//se verifica que el usuario no sea uno mismo
										$ubicacion = $location.'&del='.simpleEncode($usuarios['idPredio'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el Predio '.$usuarios['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pagrow">
				<?php
				//se llama al paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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
