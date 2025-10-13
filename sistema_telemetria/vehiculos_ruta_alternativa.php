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
$original = "vehiculos_ruta_alternativa.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idRuta']) && $_GET['idRuta']!=''){ $location .= "&idRuta=".$_GET['idRuta'];        $search .= "&idRuta=".$_GET['idRuta'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){  $location .= "&idTipo=".$_GET['idTipo'];  $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){ $location .= "&Fecha=".$_GET['Fecha'];        $search .= "&Fecha=".$_GET['Fecha'];}
if(isset($_GET['idDia']) && $_GET['idDia']!=''){  $location .= "&idDia=".$_GET['idDia'];  $search .= "&idDia=".$_GET['idDia'];}
if(isset($_GET['HoraInicio']) && $_GET['HoraInicio']!=''){ $location .= "&HoraInicio=".$_GET['HoraInicio'];        $search .= "&HoraInicio=".$_GET['HoraInicio'];}
if(isset($_GET['HoraTermino']) && $_GET['HoraTermino']!=''){  $location .= "&HoraTermino=".$_GET['HoraTermino'];  $search .= "&HoraTermino=".$_GET['HoraTermino'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){ $location .= "&Nombre=".$_GET['Nombre'];        $search .= "&Nombre=".$_GET['Nombre'];}
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
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_ruta_alternativa.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_ruta_alternativa.php';
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
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$query = "SELECT Nombre,idRuta
FROM `vehiculos_ruta_alternativa`
WHERE idRutaAlt = ".$_GET['id'];
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
WHERE idRuta = ".$rowData['idRuta']."
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
}

//Se traen las rutas
$arrRutasAlt = array();
$query = "SELECT idUbicaciones, Latitud, Longitud, direccion
FROM `vehiculos_ruta_alternativa_ubicaciones`
WHERE idRutaAlt = ".$_GET['id']."
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
array_push( $arrRutasAlt,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Ruta Alternativa', $rowData['Nombre'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'vehiculos_ruta_alternativa.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'vehiculos_ruta_alternativa_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'vehiculos_ruta_alternativa_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Editar Ruta</a></li>

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
									if($in==0){$in=1;}else{echo ',';} ?>
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
									if($in==0){echo ',';}else{echo ',';} ?>
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

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//se crea filtro
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']; ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Ruta Alternativa</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idRuta)){          $x1  = $idRuta;           }else{$x1  = '';}
				if(isset($idTipo)){          $x2  = $idTipo;           }else{$x2  = '';}
				if(isset($Fecha)){ $x3  = $Fecha;            }else{$x3  = '';}
				if(isset($idDia)){           $x4  = $idDia;            }else{$x4  = '';}
				if(isset($HoraInicio)){      $x5  = $HoraInicio;       }else{$x5  = '';}
				if(isset($HoraTermino)){     $x6  = $HoraTermino;      }else{$x6  = '';}
				if(isset($Nombre)){          $x7  = $Nombre;           }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Básicos');
				$Form_Inputs->form_select('Ruta','idRuta', $x1, 2, 'idRuta', 'Nombre', 'vehiculos_rutas', $z, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Ruta','idTipo', $x2, 2, 'idTipo', 'Nombre', 'vehiculos_ruta_alternativa_tipos', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha','Fecha', $x3, 1);
				$Form_Inputs->form_select_filter('Dia','idDia', $x4, 1, 'idDia', 'Nombre', 'core_tiempo_dias', 0, 'idDia ASC', $dbConn);
				$Form_Inputs->form_time('Hora Inicio','HoraInicio', $x5, 1, 1);
				$Form_Inputs->form_time('Hora Termino','HoraTermino', $x6, 1, 1);
				$Form_Inputs->form_input_text('Nombre de la Ruta', 'Nombre', $x7, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				?>

					<script>
						document.getElementById('div_Fecha').style.display = 'none';
						document.getElementById('div_idDia').style.display = 'none';

						$("#idTipo").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected = $(this).val(); //Asignamos el valor seleccionado
					
							//si es SI
							if(modelSelected == 1){
								document.getElementById('div_Fecha').style.display = 'none';
								document.getElementById('div_idDia').style.display = '';
															
							//si es NO
							} else if(modelSelected == 2){
								document.getElementById('div_Fecha').style.display = '';
								document.getElementById('div_idDia').style.display = 'none';
							}
						});
					</script>

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
		case 'tipo_asc':      $order_by = 'vehiculos_ruta_alternativa_tipos.Nombre ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente'; break;
		case 'tipo_desc':     $order_by = 'vehiculos_ruta_alternativa_tipos.Nombre DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'ruta_asc':      $order_by = 'vehiculos_rutas.Nombre ASC ';                   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Ruta Ascendente';break;
		case 'ruta_desc':     $order_by = 'vehiculos_rutas.Nombre DESC ';                  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Ruta Descendente';break;
		case 'nombre_asc':    $order_by = 'vehiculos_ruta_alternativa.Nombre ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':   $order_by = 'vehiculos_ruta_alternativa.Nombre DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'lapso_asc':     $order_by = 'vehiculos_ruta_alternativa.Fecha ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Lapso Ascendente';break;
		case 'lapso_desc':    $order_by = 'vehiculos_ruta_alternativa.Fecha DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Lapso Descendente';break;
		case 'hinicio_asc':   $order_by = 'vehiculos_ruta_alternativa.HoraInicio ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Inicio Ascendente'; break;
		case 'hinicio_desc':  $order_by = 'vehiculos_ruta_alternativa.HoraInicio DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Inicio Descendente';break;
		case 'htermino_asc':  $order_by = 'vehiculos_ruta_alternativa.HoraTermino ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Termino Ascendente';break;
		case 'htermino_desc': $order_by = 'vehiculos_ruta_alternativa.HoraTermino DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Termino Descendente';break;

		default: $order_by = 'vehiculos_ruta_alternativa_tipos.idTipo ASC, vehiculos_ruta_alternativa.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo, Nombre Ascendente';
	}
}else{
	$order_by = 'vehiculos_ruta_alternativa_tipos.idTipo ASC, vehiculos_ruta_alternativa.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo, Nombre Ascendente';
}
/**********************************************************/
//Verifico el tipo de usuario que esta ingresando
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Variable de busqueda
$SIS_where = "vehiculos_ruta_alternativa.idRutaAlt!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND vehiculos_ruta_alternativa.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idRuta']) && $_GET['idRuta']!=''){     $SIS_where .= " AND vehiculos_ruta_alternativa.idRuta=".$_GET['idRuta'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){     $SIS_where .= " AND vehiculos_ruta_alternativa.idTipo=".$_GET['idTipo'];}
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){       $SIS_where .= " AND vehiculos_ruta_alternativa.Fecha='".$_GET['Fecha']."'";}
if(isset($_GET['idDia']) && $_GET['idDia']!=''){       $SIS_where .= " AND vehiculos_ruta_alternativa.idDia=".$_GET['idDia'];}
if(isset($_GET['HoraInicio']) && $_GET['HoraInicio']!=''){    $SIS_where .= " AND vehiculos_ruta_alternativa.HoraInicio=".$_GET['HoraInicio'];}
if(isset($_GET['HoraTermino']) && $_GET['HoraTermino']!=''){  $SIS_where .= " AND vehiculos_ruta_alternativa.HoraTermino=".$_GET['HoraTermino'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){     $SIS_where .= " AND vehiculos_ruta_alternativa.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idRutaAlt', 'vehiculos_ruta_alternativa', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
vehiculos_ruta_alternativa.idRutaAlt,
vehiculos_ruta_alternativa.Nombre,
vehiculos_ruta_alternativa.Fecha,
vehiculos_ruta_alternativa.HoraInicio,
vehiculos_ruta_alternativa.HoraTermino,
core_sistemas.Nombre AS sistema,
vehiculos_ruta_alternativa.idTipo,
vehiculos_ruta_alternativa_tipos.Nombre AS  Tipo,
vehiculos_rutas.Nombre AS Ruta,
core_tiempo_dias.Nombre AS Dia';
$SIS_join  = '
LEFT JOIN `vehiculos_ruta_alternativa_tipos`   ON vehiculos_ruta_alternativa_tipos.idTipo      = vehiculos_ruta_alternativa.idTipo
LEFT JOIN `core_tiempo_dias`                   ON core_tiempo_dias.idDia                       = vehiculos_ruta_alternativa.idDia
LEFT JOIN `vehiculos_rutas`                    ON vehiculos_rutas.idRuta                       = vehiculos_ruta_alternativa.idRuta
LEFT JOIN `core_sistemas`                      ON core_sistemas.idSistema                      = vehiculos_ruta_alternativa.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrUsers = array();
$arrUsers = db_select_array (false, $SIS_query, 'vehiculos_ruta_alternativa', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Ruta</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idRuta)){          $x1  = $idRuta;           }else{$x1  = '';}
				if(isset($idTipo)){          $x2  = $idTipo;           }else{$x2  = '';}
				if(isset($Fecha)){ $x3  = $Fecha;            }else{$x3  = '';}
				if(isset($idDia)){           $x4  = $idDia;            }else{$x4  = '';}
				if(isset($HoraInicio)){      $x5  = $HoraInicio;       }else{$x5  = '';}
				if(isset($HoraTermino)){     $x6  = $HoraTermino;      }else{$x6  = '';}
				if(isset($Nombre)){          $x7  = $Nombre;           }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Ruta','idRuta', $x1, 1, 'idRuta', 'Nombre', 'vehiculos_rutas', $w, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Ruta','idTipo', $x2, 1, 'idTipo', 'Nombre', 'vehiculos_ruta_alternativa_tipos', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha','Fecha', $x3, 1);
				$Form_Inputs->form_select_filter('Dia','idDia', $x4, 1, 'idDia', 'Nombre', 'core_tiempo_dias', 0, 'idDia ASC', $dbConn);
				$Form_Inputs->form_time('Hora Inicio','HoraInicio', $x5, 1, 1);
				$Form_Inputs->form_time('Hora Termino','HoraTermino', $x6, 1, 1);
				$Form_Inputs->form_input_text('Nombre de la Ruta', 'Nombre', $x7, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Rutas</h5>
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
							<div class="pull-left">Tipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Ruta</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=ruta_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=ruta_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Lapso</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=lapso_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=lapso_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Hora Inicio</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=hinicio_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=hinicio_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Hora Termino</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=htermino_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=htermino_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrUsers as $usuarios){ ?>
					<tr class="odd">
						<td><?php echo $usuarios['Tipo']; ?></td>
						<td><?php echo $usuarios['Ruta']; ?></td>
						<td><?php echo $usuarios['Nombre']; ?></td>
						<td>
							<?php
							if($usuarios['idTipo']){
								echo $usuarios['Dia'];
							}else{
								echo $usuarios['Fecha'];
							} ?>
						</td>
						<td><?php echo $usuarios['HoraInicio']; ?></td>
						<td><?php echo $usuarios['HoraTermino']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_vehiculos_ruta_alternativa.php?view='.simpleEncode($usuarios['idRutaAlt'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idRutaAlt']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									//se verifica que el usuario no sea uno mismo
									$ubicacion = $location.'&del='.simpleEncode($usuarios['idRutaAlt'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el equipo '.$usuarios['Nombre'].'?'; ?>
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
