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
$original = "telemetria_gestion_flota.php";
$location = $original;
//Se agregan ubicaciones
$location .='?filtro=true';
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
	//Variables
	$arrRutas       = array();
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Se traen las rutas si se ingresaron
	if(isset($_GET['idRuta'])&&$_GET['idRuta']!=''){

		//Se consultan datos
		$arrRutas = array();
		$arrRutas = db_select_array (false, 'idUbicaciones, Latitud, Longitud, direccion', 'telemetria_rutas_ubicaciones', '', 'idRuta ='.$_GET['idRuta'], 'idUbicaciones ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrRutas');

	}

	//Variable
	$SIS_where  = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	$SIS_where .= " AND telemetria_listado.id_Geo = 1";//solo los equipos que tengan el seguimiento activado
	$enlace = "?dd=true";
	//verifico que sea un administrador
	$SIS_where .= " AND telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	$enlace    .= "&idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	if (isset($_GET['idRuta'])&&$_GET['idRuta']!=''){
		$SIS_where .= " AND telemetria_listado.idRuta=".$_GET['idRuta'];
		$enlace    .= "&idRuta=".$_GET['idRuta'];
	}
	if (isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];
		$enlace    .= "&idTelemetria=".$_GET['idTelemetria'];
	}

	//Se consultan datos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.GeoLatitud,
	telemetria_listado.GeoLongitud,
	telemetria_listado.NDetenciones,
	telemetria_listado.NErrores';
	$SIS_join = '';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipo');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Gestion de Flota en Tiempo Real</h5>
			</header>
			<div class="table-responsive">

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="row">
						<div id="consulta">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Nombre</th>
										<th>Estado</th>
										<th width="80">Acciones</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrEquipo as $data) {

										/**********************************************/
										//Se resetean
										$in_eq_alertas     = 0;
										$in_eq_fueralinea  = 0;
										$in_eq_detenidos   = 0;

										/**********************************************/
										//Fuera de linea
										$diaInicio   = $data['LastUpdateFecha'];
										$diaTermino  = $FechaSistema;
										$tiempo1     = $data['LastUpdateHora'];
										$tiempo2     = $HoraSistema;
										$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

										//Comparaciones de tiempo
										$Time_Tiempo     = horas2segundos($Tiempo);
										$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
										$Time_Tiempo_Max = horas2segundos('48:00:00');
										$Time_Fake_Ini   = horas2segundos('23:59:50');
										$Time_Fake_Fin   = horas2segundos('24:00:00');
										//comparacion
										if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
											$in_eq_fueralinea++;
										}

										/**********************************************/
										//NErrores
										if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

										/**********************************************/
										//Equipos detenidos
										if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

										/*******************************************************/
										//rearmo
										if($in_eq_alertas>0){
											$danger = 'warning';
											$eq_ok  = '<a href="#" title="Con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
										}elseif($in_eq_fueralinea>0){
											$danger = 'danger';
											$eq_ok  = '<a href="#" title="Fuera de Linea" class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';
										}elseif($in_eq_detenidos>0){
											$danger = 'danger';
											$eq_ok  = '<a href="#" title="Vehiculo Detenido" class="btn btn-danger btn-sm tooltip"><i class="fa fa-hand-paper-o" aria-hidden="true"></i></a>';
										}else{
											$danger = '';
											$eq_ok  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
										}
										?>

										<tr class="odd <?php echo $danger; ?>">
											<td><?php echo $data['Nombre']; ?></td>
											<td><div class="btn-group" ><?php echo $eq_ok; ?></div></td>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="<?php echo 'telemetria_gestion_flota_view_equipo.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>						
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

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
								/* ************************************************************************** */
								var icon_transMarker = {
										name: 'transMarkers',
										visible: true
								}
								var markers={}
								var introx = [
									<?php foreach ( $arrEquipo as $pos ) { ?>
										[ <?php echo $pos['GeoLatitud']; ?>, <?php echo $pos['GeoLongitud']; ?>],
									<?php } ?>
								];

								/* ************************************************************************** */
								async function initMap() {
									const { Map } = await google.maps.importLibrary("maps");

									var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

									var myOptions = {
										zoom: 12,
										//center: myLatlng,
										center: new google.maps.LatLng(introx[0][0], introx[0][1]),
										zoomControl: true,
										scaleControl: false,
										scrollwheel: false,
										disableDoubleClickZoom: true,
										mapTypeId: google.maps.MapTypeId.ROADMAP
									};

									map = new Map(document.getElementById("map_canvas"), myOptions);

									//Se cargan las posiciones de los iconos
									intro();

									//Se llama a la ruta
									<?php if(isset($_GET['idRuta'])&&$_GET['idRuta']!=''){ ?>
										RutasAlternativas();
									<?php } ?>

									//Ubicación de los distintos dispositivos
									transMarker(10000);

								}

								/* ************************************************************************** */
								function intro() {
									//Los demas buses
									hideMarkers('transMarkers');
									deleteMarkers('transMarkers');

									for(var i in introx){
										transporte = addMarker(icon_transMarker);
										transporte.show().setPosition(new google.maps.LatLng(introx[i][0], introx[i][1]));
									}
									//centralizo el mapa en base al ultimo dato obtenido
									map.panTo(transporte.getPosition());
								}
								/* ************************************************************************** */
								function RutasAlternativas() {

									var route=[];
									var tmp;

									var routex = [
									<?php foreach ( $arrRutas as $pos ) { ?>
										['<?php echo $pos['idUbicaciones']; ?>', <?php echo $pos['Latitud']; ?>, <?php echo $pos['Longitud']; ?>],
									<?php } ?>
									];

									for(var i in routex){
										tmp=new google.maps.LatLng(routex[i][1], routex[i][2]);
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
								function transMarker(time) {
									setInterval(function(){myTimer2()},time);
								}

								var mapax = 0;
								function myTimer2() {

									switch(mapax) {
										//Ejecutar formulario con el recorrido y la ruta
										case 1:
											$('#consulta').load('telemetria_gestion_flota_update_map.php<?php echo $enlace; ?>');
										break;
										//se dibujan los iconos de los buses
										case 2:
											//Los demas buses
											hideMarkers('transMarkers');
											deleteMarkers('transMarkers');

											for(var i in locations){
												transporte = addMarker(icon_transMarker);
												transporte.show().setPosition(new google.maps.LatLng(locations[i][1], locations[i][2]));
											}

										break;
									}

									mapax++;
									if(mapax==3){mapax=1}
								}

								/* ************************************************************************** */
								var foreachMarkerByName=function(name,callback){

									var toRet=false

									if (typeof name != 'object') {
										name=[name]
									}

									for (var a in name){
										var tmp=name[a];

										if (tmp==undefined||markers[tmp]==undefined) {
											continue;
										}

										toRet=true;

										for (var a in markers[tmp]) callback(markers[tmp][a]);
									}

									return toRet;
								}
								/* ************************************************************************** */
								hideMarkers=function(name){
									foreachMarkerByName(name,function(el){
										el.hide();
									});
									return this;
								}
								/* ************************************************************************** */
								deleteMarkers=function(name){
									foreachMarkerByName(name,function(el){
										el.delete();
									});
									delete markers[name];
									return this;
								}
								/* ************************************************************************** */
								addMarker=function(opt){

									if (opt == undefined) return false;

									opt.map=map;

									var tmp=new google.maps.Marker(opt);

									if (opt.pos) tmp.setPosition(opt.pos);

									if (opt.name) {
										if (markers[opt.name] == undefined) markers[opt.name]=[];

										markers[opt.name].push(tmp);

										tmp.markerFamilyName=opt.name;
										tmp.markerFamilyPos=markers[opt.name].length-1;
									}

									if (opt.events) {
										for (var a in opt.events) {
											google.maps.event.addListener(tmp,a,opt.events[a].bind(tmp));
										}
									}

									// Borrar, esconder y mostrar
									tmp.delete=function(){
										this.deleteInfo();
										this.setMap(null);

										return this;
									}.bind(tmp);

									tmp.hide=function(){
										this.setVisible(false);

										return this;
									}.bind(tmp);

									tmp.show=function(){
										google.maps.event.trigger(this, 'show');
										this.setVisible(true);

										return this;
									}.bind(tmp)

									tmp.isVisible=function(){
										return this.visible
									}.bind(tmp)

									// Agrega mensajes a los marcadores
									tmp.info=function(message,click,opt){

										opt=opt||{}

										var custom=click===true;

										click=typeof click=='function'?click:opt.click||function(){};

										var opt=$.extend({content: message},opt);

										this.infoBox=custom;

										if (custom) {
											this.infoWindow = new InfoBox(opt);
										}else {
											this.infoWindow = new google.maps.InfoWindow(opt);
										}

										this.infoWindowListener=google.maps.event.addListener(this, 'click', function () {

											if (activeInfoWindow) {
												activeInfoWindow.close();
											}
											this.infoWindow.open(map, this);
											activeInfoWindow=this.infoWindow;
											click.bind(this)();

											return this;

										}.bind(this));
									}.bind(tmp);

									tmp.deleteInfo=function(){
										if (this.infoWindow) {
											this.infoWindow.setMap(null);
											delete this.infoWindow;

											google.maps.event.removeListener(this.infoWindowListener);
											delete this.infoWindowListener;
										}
										return this;

									}.bind(tmp);

									tmp.click=function(){
										google.maps.event.trigger(this, 'click');
									}.bind(tmp);

									return tmp;

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
		<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
		$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND id_Geo=1";
	}else{
		/*******************************************************/
		// consulto los datos
		$SIS_query = 'idTelemetria';
		$SIS_join  = '';
		$SIS_where = 'idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
		$SIS_order = 0;
		$arrPermisos = array();
		$arrPermisos = db_select_array (false, $SIS_query, 'usuarios_equipos_telemetria', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');
		/*******************************************************/
		//filtro
		$z = "idTelemetria=0";
		foreach ($arrPermisos as $prod) {
			$z .= " OR (idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND id_Geo=2 AND idTelemetria=".$prod['idTelemetria'].")";
		}
		//$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND id_Geo=1";
	}
	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Filtro de Búsqueda</h5>
			</header>

			<div class="tab-content body">

					<div class="wmd-panel">
						<form class="form-horizontal" action="<?php echo $original; ?>" id="form1" name="form2" novalidate>
							<?php
							//Se verifican si existen los datos
							if(isset($idTelemetria)){   $x1  = $idTelemetria;    }else{$x1  = '';}

							//se dibujan los inputs
							$Form_Inputs = new Form_Inputs();
							$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);

							?>
							<div class="form-group">
								<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
							</div>
							<div class="clearfix"></div>
						</form>
					</div>

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
