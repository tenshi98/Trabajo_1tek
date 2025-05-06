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
$original = "vehiculos_geocercas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){     $location .= "&Nombre=".$_GET['Nombre'];              $search .= "&Nombre=".$_GET['Nombre'];}
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_zona'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_geocercas.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_zona'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_geocercas.php';
}
//se borra un dato
if (!empty($_GET['del_zona'])){
	//Llamamos al formulario
	$form_trabajo= 'del_zona';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_geocercas.php';
}
/****************************************************/
//formulario para crear
if (!empty($_POST['submit_punto'])){
	//se agregan ubicaciones
	$location .='&edit_puntos='.$_GET['edit_puntos'];
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_geocercas_ubicaciones.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_punto'])){
	//se agregan ubicaciones
	$location .='&edit_puntos='.$_GET['edit_puntos'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_geocercas_ubicaciones.php';
}
//se borra un dato
if (!empty($_GET['del_punto'])){
	//se agregan ubicaciones
	$location .='&edit_puntos='.$_GET['edit_puntos'];
	//Llamamos al formulario
	$form_trabajo= 'del_punto';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_geocercas_ubicaciones.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Geocerca Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Geocerca Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Geocerca Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['mod'])){
// consulto los datos
$query = "SELECT Nombre
FROM `vehiculos_geocercas`
WHERE vehiculos_geocercas.idZona = ".$_GET['edit_puntos'];
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
$query = "SELECT Latitud, Longitud
FROM `vehiculos_geocercas_ubicaciones`
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

//Se traen las rutas
$arrPuntos = array();
$query = "SELECT idUbicaciones, Latitud, Longitud
FROM `vehiculos_geocercas_ubicaciones`
WHERE idZona = ".$_GET['edit_puntos']."
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
array_push( $arrPuntos,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Puntos de la geocerca <?php echo $rowData['Nombre']; ?></h5>
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

								} ?>

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
<a href="<?php echo $location.'&edit_puntos='.$_GET['edit_puntos'] ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_puntos'])){
// consulto los datos
$query = "SELECT Nombre
FROM `vehiculos_geocercas`
WHERE vehiculos_geocercas.idZona = ".$_GET['edit_puntos'];
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
$arrPuntos = array();
$query = "SELECT idUbicaciones, Latitud, Longitud
FROM `vehiculos_geocercas_ubicaciones`
WHERE idZona = ".$_GET['edit_puntos']."
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
array_push( $arrPuntos,$row );
} ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Puntos de la geocerca <?php echo $rowData['Nombre']; ?></h5>
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
								<?php
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
								} ?>

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
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_puntos='.$_GET['edit_puntos'].'&mod='.$pos['idUbicaciones']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){
											$ubicacion = $location.'&edit_puntos='.$_GET['edit_puntos'].'&del_punto='.simpleEncode($pos['idUbicaciones'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el dato?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['edit_zona'])){
// consulto los datos
$query = "SELECT Nombre,idEstado
FROM `vehiculos_geocercas`
WHERE idZona = ".$_GET['edit_zona'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');

	//Guardo el error en una variable temporal
	
	
	

}
$rowData = mysqli_fetch_assoc ($resultado);

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Geocerca</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){    $x1  = $Nombre;     }else{$x1  = $rowData['Nombre'];}
				if(isset($idEstado)){  $x2 = $idEstado;    }else{$x2 = $rowData['idEstado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_select('Estado','idEstado', $x2, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idZona', $_GET['edit_zona'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_zona">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
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
			<h5>Crear Geocerca</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){           $x1  = $Nombre;            }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);


				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_zona">
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
		case 'nombre_asc':    $order_by = 'vehiculos_geocercas.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
		case 'nombre_desc':   $order_by = 'vehiculos_geocercas.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'estado_asc':    $order_by = 'vehiculos_geocercas.idEstado ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':   $order_by = 'vehiculos_geocercas.idEstado DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

		default: $order_by = 'vehiculos_geocercas.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'vehiculos_geocercas.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "vehiculos_geocercas.idZona!=0";
//verifico que sea un administrador
$SIS_where.= " AND vehiculos_geocercas.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){  $SIS_where .= " AND vehiculos_geocercas.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idZona', 'vehiculos_geocercas', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
vehiculos_geocercas.idZona,
vehiculos_geocercas.Nombre,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
vehiculos_geocercas.idEstado';
$SIS_join  = '
LEFT JOIN `core_estados`   ON core_estados.idEstado       = vehiculos_geocercas.idEstado
LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema     = vehiculos_geocercas.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrCercas = array();
$arrCercas = db_select_array (false, $SIS_query, 'vehiculos_geocercas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCercas');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Geocerca</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){           $x1  = $Nombre;            }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombres', 'Nombre', $x1, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Geocercas</h5>
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
						<th width="120">
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
					<?php foreach ($arrCercas as $cerca) { ?>
					<tr class="odd">
						<td><?php echo $cerca['Nombre']; ?></td>
						<td><label class="label <?php if(isset($cerca['idEstado'])&&$cerca['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $cerca['estado']; ?></label></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $cerca['sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 140px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_geocerca.php?view='.simpleEncode($cerca['idZona'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_zona='.$cerca['idZona']; ?>" title="Editar Información Basica" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&edit_puntos='.$cerca['idZona']; ?>" title="Editar Puntos" class="btn btn-success btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($cerca['idZona'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la geocerca '.$cerca['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
