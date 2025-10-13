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
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{

	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'idSistema, Nombre AS NombreEquipo', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	/*************************************************************/
	//Se traen todos los registros
	$SIS_query = 'idTabla, Segundos, Diferencia, idSolicitud, idZona, GeoLatitud, GeoLongitud, GeoVelocidad, GeoMovimiento, FechaSistema, HoraSistema, Sensor_1, Sensor_2, Sensor_3';
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/*************************************************************/
	//Predios
	$SIS_query = '
	cross_predios_listado.Nombre AS Predio,
	cross_predios_listado_zonas.idZona,
	cross_predios_listado_zonas.Nombre,
	cross_predios_listado_zonas.Hectareas,
	cross_predios_listado_zonas_ubicaciones.Latitud,
	cross_predios_listado_zonas_ubicaciones.Longitud';
	$SIS_join  = '
	LEFT JOIN `cross_predios_listado_zonas_ubicaciones`  ON cross_predios_listado_zonas_ubicaciones.idZona  = cross_predios_listado_zonas.idZona
	LEFT JOIN `cross_predios_listado`                    ON cross_predios_listado.idPredio                  = cross_predios_listado_zonas.idPredio';
	$SIS_where = 'cross_predios_listado.idSistema='.$rowEquipo['idSistema'];
	$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
	$arrPredios = array();
	$arrPredios = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPredios');

	//Se filtra por zona
	filtrar($arrPredios, 'idZona');
	//se recorre
	$arrCuarteles = array();
	foreach ($arrPredios as $todaszonas=>$zonas) {
		/*foreach ($zonas as $puntos) {

		}*/
		$arrCuarteles[$todaszonas]['Predio']    = $zonas[0]['Predio'];
		$arrCuarteles[$todaszonas]['Nombre']    = $zonas[0]['Nombre'];
		$arrCuarteles[$todaszonas]['Hectareas'] = $zonas[0]['Hectareas'];
	}

	/*****************************************/
	if ($arrEquipos!=false && !empty($arrEquipos) && $arrEquipos!='') {
		/*****************************************/
		//Variable para almacenar los recorridos
		$Temp_1     = '';
		$Kilometros = 0;
		$Segundos   = 0;
		$VelSum     = 0;
		$VelCount   = 0;
		$VelProm    = 0;
		$Litros     = 0;
		$arrData    = array();
		$arrCuartel = array();
		//recorro los resultados
		foreach ($arrEquipos as $med) {
			//se obtienen los kilometros recorridos
			$Kilometros = $Kilometros + $med['GeoMovimiento'];
			//se obtienen los segundos transcurridos
			if(isset($med['GeoMovimiento'])&&$med['GeoMovimiento']!=''){
				$Segundos   = $Segundos + $med['Segundos'];
			}
			//se obtiene la velocidad
			$VelSum   = $VelSum + $med['GeoVelocidad'];
			$VelCount++;
			//se obtienen los litros
			$Litros   = $Litros + $med['Diferencia'];

			//Se obtiene la fecha
			$Temp_1 .= "'".Fecha_estandar($med['FechaSistema'])." ".$med['HoraSistema']."',";

			if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){$arrData[1]['Value'] .= ", ".$med['Sensor_1'];       }else{ $arrData[1]['Value'] = $med['Sensor_1'];}
			if(isset($arrData[2]['Value'])&&$arrData[2]['Value']!=''){$arrData[2]['Value'] .= ", ".$med['Sensor_2'];       }else{ $arrData[2]['Value'] = $med['Sensor_2'];}
			if(isset($arrData[3]['Value'])&&$arrData[3]['Value']!=''){$arrData[3]['Value'] .= ", ".$med['Sensor_3'];       }else{ $arrData[3]['Value'] = $med['Sensor_3'];}
			if(isset($arrData[4]['Value'])&&$arrData[4]['Value']!=''){$arrData[4]['Value'] .= ", ".$med['GeoVelocidad'];   }else{ $arrData[4]['Value'] = $med['GeoVelocidad'];}

			//se busca el cuartel donde esta
			$arrCuartel[$med['idZona']][$med['idSolicitud']]['Predio']     = $arrCuarteles[$med['idZona']]['Predio'];
			$arrCuartel[$med['idZona']][$med['idSolicitud']]['Cuartel']    = $arrCuarteles[$med['idZona']]['Nombre'];
			$arrCuartel[$med['idZona']][$med['idSolicitud']]['Hectarea']   = $arrCuarteles[$med['idZona']]['Hectareas'];
			$arrCuartel[$med['idZona']][$med['idSolicitud']]['Solicitud']  = $med['idSolicitud'];

			/*********************/
			if(isset($arrCuartel[$med['idZona']][$med['idSolicitud']]['Kilometros'])){
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['Kilometros'] = $arrCuartel[$med['idZona']][$med['idSolicitud']]['Kilometros'] + $med['GeoMovimiento'];
			}else{
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['Kilometros']  = $med['GeoMovimiento'];
			}
			/*********************/
			if(isset($arrCuartel[$med['idZona']][$med['idSolicitud']]['LitrosAplicados'])){
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['LitrosAplicados'] = $arrCuartel[$med['idZona']][$med['idSolicitud']]['LitrosAplicados'] + $med['Diferencia'];
			}else{
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['LitrosAplicados']  = $med['Diferencia'];
			}
			/*********************/
			if(isset($arrCuartel[$med['idZona']][$med['idSolicitud']]['VelSum'])){
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['VelSum'] = $arrCuartel[$med['idZona']][$med['idSolicitud']]['VelSum'] + $med['GeoVelocidad'];
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['VelCount']++;
			}else{
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['VelSum']  = $med['GeoVelocidad'];
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['VelCount']  = 1;
			}
			/*********************/
			if(isset($arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorDerechoProm'])){
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorDerechoProm'] = $arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorDerechoProm'] + $med['Sensor_1'];
			}else{
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorDerechoProm']  = $med['Sensor_1'];
			}
			/*********************/
			if(isset($arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorIzquierdoProm'])){
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorIzquierdoProm'] = $arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorIzquierdoProm'] + $med['Sensor_2'];
			}else{
				$arrCuartel[$med['idZona']][$med['idSolicitud']]['TractorIzquierdoProm']  = $med['Sensor_2'];
			}

		}
		//Si hay mediciones de velocidad
		if($VelCount!=0){$VelProm = $VelSum/$VelCount;}

		$arrData[1]['Name'] = "'Caudal Derecho'";
		$arrData[2]['Name'] = "'Caudal Izquierdo'";
		$arrData[3]['Name'] = "'Nivel Estanque'";
		$arrData[4]['Name'] = "'Velocidad'";

		?>

		<style>
			.my_marker {color: black;background-color:#1E90FF;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
			.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
		</style>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>
						<?php
						echo 'Ruta Equipo '.$rowEquipo['NombreEquipo'].' ';
						if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
							echo 'desde '.fecha_estandar($_GET['f_inicio']).'-'.$_GET['h_inicio'].' hasta '.fecha_estandar($_GET['f_termino']).'-'.$_GET['h_termino'];
						}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
							echo 'desde '.fecha_estandar($_GET['f_inicio']).' hasta '.fecha_estandar($_GET['f_termino']);
						}
						?>
					</h5>
				</header>
				<div class="table-responsive">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">

							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<div class="box box-blue box-solid">
									<div class="box-header with-border">
										<h3 class="box-title">Kilometros Recorridos</h3>
									</div>
									<div class="box-body">
										<div class="value">
											<span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
											<span><?php echo Cantidades($Kilometros, 2) ?></span>
											Kilometros
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<div class="box box-blue box-solid">
									<div class="box-header with-border">
										<h3 class="box-title">Tiempo de Uso Referencial</h3>
									</div>
									<div class="box-body">
										<div class="value">
											<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
											<span><?php echo segundos2horas($Segundos); ?></span>
											Horas
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<div class="box box-blue box-solid">
									<div class="box-header with-border">
										<h3 class="box-title">Velocidad Promedio en Aplicacion</h3>
									</div>
									<div class="box-body">
										<div class="value">
											<span><i class="fa fa-tachometer" aria-hidden="true"></i></span>
											<span><?php echo Cantidades($VelProm, 0); ?></span>
											Km/h
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<div class="box box-blue box-solid">
									<div class="box-header with-border">
										<h3 class="box-title">Litros Totales Aplicados</h3>
									</div>
									<div class="box-body">
										<div class="value">
											<span><i class="fa fa-tint" aria-hidden="true"></i></span>
											<span><?php echo Cantidades($Litros, 0); ?></span>
											Litros
										</div>
									</div>
								</div>
							</div>

							<div class="clearfix"></div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="box">
									<header>
										<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Detalle</h5>
									</header>
									<div class="table-responsive">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<thead>
												<tr role="row">
													<th>Predio</th>
													<th>Cuartel</th>
													<th>Hectareas</th>
													<th>Kilometros Recorridos</th>
													<th>Litros Aplicados</th>
													<th>Velocidad Promedio</th>
													<th>Dispersion de Flujo</th>
												</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all">
												<?php
												foreach ($arrCuartel as $todosCuartel=>$zonas) {
													foreach ($zonas as $med) { ?>
														<tr class="odd">
															<td><?php if(isset($med['Predio'])&&$med['Predio']!=''){echo $med['Predio'];}else{echo 'Fuera de Predio';} ?></td>
															<td><?php if(isset($med['Cuartel'])&&$med['Cuartel']!=''){echo $med['Cuartel'];}else{echo 'Fuera de Cuartel';} ?></td>
															<td><?php if(isset($med['Hectarea'])&&$med['Hectarea']!=''){echo $med['Hectarea'];}else{echo 'N/A';} ?></td>
															<td><?php echo Cantidades($med['Kilometros'], 2).' Km'; ?></td>
															<td><?php echo Cantidades($med['LitrosAplicados'], 0).' L'; ?></td>
															<td>
																<?php
																if(isset($med['VelCount'])&&$med['VelCount']!=''){
																	$VelProm = $med['VelSum']/$med['VelCount'];
																}else{
																	$VelProm = 0;
																}
																echo Cantidades($VelProm, 0).' Km/h'; ?>
															</td>
															<td>
																<?php
																if($med['TractorDerechoProm']>$med['TractorIzquierdoProm']){
																	if($med['TractorIzquierdoProm']!=0){$correccion = (($med['TractorDerechoProm'] - $med['TractorIzquierdoProm'])/$med['TractorIzquierdoProm'])*100;}else{$correccion = 0;}
																}else{
																	if($med['TractorDerechoProm']!=0){$correccion = (($med['TractorIzquierdoProm'] - $med['TractorDerechoProm'])/$med['TractorDerechoProm'])*100;}else{$correccion = 0;}
																}
																echo Cantidades($correccion, 2).' %'; ?>
															</td>

														</tr>
													<?php } ?>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>

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
									var locations = [
										<?php foreach ( $arrEquipos as $pos ) {
											if($pos['GeoLatitud']<0&&$pos['GeoLongitud']<0){
												echo "['".$pos['idTabla']."', ".$pos['GeoLatitud'].", ".$pos['GeoLongitud'].", ".$pos['Sensor_1'].", ".$pos['Sensor_2'].", ".$pos['idZona']."],"; 
											}
										} ?>
									];

									async function initMap() {
										const { Map } = await google.maps.importLibrary("maps");

										var myOptions = {
											zoom: 16,
											center: new google.maps.LatLng(locations[0][1], locations[0][2]),
											zoomControl: true,
											scaleControl: false,
											scrollwheel: false,
											disableDoubleClickZoom: true,
											mapTypeId: google.maps.MapTypeId.SATELLITE
										};

										map = new Map(document.getElementById("map_canvas"), myOptions);

										//Se llama a la ruta
										RutasRealizadas();
										//dibuja zonas
										//map.setTilt(0);
										//dibuja zonas
										dibuja_zona();

									}

									/* ************************************************************************** */
									function RutasRealizadas() {

										var color    = '';
										var color_1  = '#1E90FF'; //azul
										var color_2  = '#FFE200'; //amarillo
										var color_3  = '#FFC0CB'; //rojo
										var color_4  = '#3c763d'; //verde
										var in_lat   = 0;
										var in_long  = 0;

										for(var i in locations){
											//toma desde la segunda medicion
											if(in_lat!=0 && in_long!=0){

												//posicion anterior y actual
												var pos1 = new google.maps.LatLng(in_lat, in_long);
												var pos2 = new google.maps.LatLng(locations[i][1], locations[i][2]);

												//verifico que esta dentro de un cuartel
												if(locations[i][5]!=0){
													//verifico que este regando
													if(locations[i][3]!=0 || locations[i][4]!=0){
														color = color_4;
													}else{
														color = color_2;
													}
												}else{
													//verifico que este regando
													if(locations[i][3]!=0 || locations[i][4]!=0){
														color = color_3;
													}else{
														color = color_1;
													}
												}

												var polyline = new google.maps.Polyline({
													map: map,
													path: [pos1, pos2],
													strokeColor: color,
													strokeOpacity: 1,
													strokeWeight: 5
												});
											}

											//guardo la posicion actual
											in_lat  = locations[i][1];
											in_long = locations[i][2];
										}
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

										//se recorre
										foreach ($arrPredios as $todaszonas=>$zonas) {

											$Latitud_z_2       = 0;
											$Longitud_z_2      = 0;
											$Latitud_z_prom_2  = 0;
											$Longitud_z_prom_2 = 0;
											$zcounter3         = 0;

											?>

											var path<?php echo $todaszonas; ?> = [

												<?php
												//Variables con la primera posicion
												$Latitud_x = '';
												$Longitud_x = '';

												foreach ($zonas as $puntos) {
													if(isset($puntos['Latitud'])&&$puntos['Latitud']!=''&&isset($puntos['Longitud'])&&$puntos['Longitud']!=''){ ?>
														{lat: <?php echo $puntos['Latitud']; ?>, lng: <?php echo $puntos['Longitud']; ?>},
														<?php
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
												if(isset($Longitud_x)&&$Longitud_x!=''){ ?>
													{lat: <?php echo $Latitud_x; ?>, lng: <?php echo $Longitud_x; ?>}
												<?php } ?>
											];

											polygons.push(new google.maps.Polygon({
												paths: path<?php echo $todaszonas; ?>,
												strokeColor: '#FF0000',
												strokeOpacity: 0.8,
												strokeWeight: 1,
												fillColor: '#FF0000',
												fillOpacity: 0
											}));
											polygons[polygons.length-1].setMap(map);

											<?php
											if($zcounter3!=0){
												$Latitud_z_prom_2  = $Latitud_z_2/$zcounter3;
												$Longitud_z_prom_2 = $Longitud_z_2/$zcounter3;
											}
											?>

											myLatlng = new google.maps.LatLng(<?php echo $Latitud_z_prom_2; ?>, <?php echo $Longitud_z_prom_2; ?>);

											var marker2 = new MyMarker({
												position: myLatlng,
												label: "<?php echo $zonas[0]['Nombre']; ?>",
												zIndex:9999
											});
											marker2.setMap(map);

											// When the mouse moves within the polygon, display the label and change the BG color.
											google.maps.event.addListener(polygons[<?php echo $zcounter2; ?>], "mousemove", function(event) {
												polygons[<?php echo $zcounter2; ?>].setOptions({
													fillColor: "#00FF00"
												});
											});

											// WHen the mouse moves out of the polygon, hide the label and change the BG color.
											google.maps.event.addListener(polygons[<?php echo $zcounter2; ?>], "mouseout", function(event) {
												polygons[<?php echo $zcounter2; ?>].setOptions({
													fillColor: "#FF0000"
												});
											});

											<?php $zcounter2++; ?>

										<?php } ?>

									}

								</script>

								<?php
								//Se escribe el dato
								$Alert_Text  = '';
								$Alert_Text .= '<strong><span style="color:#3c763d;"><i class="fa fa-map-marker" aria-hidden="true"></i> Flujo activado - Dentro de cuartel</span></strong><br/>';
								$Alert_Text .= '<strong><span style="color:#FFC0CB;"><i class="fa fa-map-marker" aria-hidden="true"></i> Flujo activado - Fuera de cuartel</span></strong><br/>';
								$Alert_Text .= '<strong><span style="color:#FFE200;"><i class="fa fa-map-marker" aria-hidden="true"></i> Flujo desactivado - Dentro de cuartel</span></strong><br/>';
								$Alert_Text .= '<strong><span style="color:#1E90FF;"><i class="fa fa-map-marker" aria-hidden="true"></i> Flujo desactivado - Fuera de cuartel</span></strong><br/>';
								echo '<br/><div class="clearfix"></div>';
								echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
									alert_post_data(2,1,1,0, $Alert_Text);
								echo '</div>';
								echo '<div class="clearfix"></div>';

								/********************************************************************/
								//solo mostrar aplicaciones
								//if(isset($_GET['idOpciones'])&&$_GET['idOpciones']!=''&&$_GET['idOpciones']==1){

									/*******************************************************************************/
									//las fechas
									$Graphics_xData      ='var xData = [['.$Temp_1.'],['.$Temp_1.'],];';
									//los valores
									$Graphics_yData      ='var yData = [['.$arrData[1]['Value'].'],['.$arrData[2]['Value'].'],];';
									//los nombres
									$Graphics_names      = 'var names = ['.$arrData[1]['Name'].','.$arrData[2]['Name'].',];';
									//los tipos
									$Graphics_types      = "var types = ['','',];";
									//si lleva texto en las burbujas
									$Graphics_texts      = "var texts = [[],[],];";
									//los colores de linea
									$Graphics_lineColors = "var lineColors = ['','',];";
									//los tipos de linea
									$Graphics_lineDash   = "var lineDash = ['','',];";
									//los anchos de la linea
									$Graphics_lineWidth  = "var lineWidth = ['','',];";

									$gr_tittle = 'Grafico Caudal / Homogeneidad de '.$rowEquipo['NombreEquipo'];
									$gr_unimed = 'Litros * Minutos';
									echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Hora', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
									/*******************************************************************************/
									//las fechas
									$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
									//los valores
									$Graphics_yData      ='var yData = [['.$arrData[3]['Value'].'],];';
									//los nombres
									$Graphics_names      = 'var names = ['.$arrData[3]['Name'].',];';
									//los tipos
									$Graphics_types      = "var types = ['',];";
									//si lleva texto en las burbujas
									$Graphics_texts      = "var texts = [[],];";
									//los colores de linea
									$Graphics_lineColors = "var lineColors = ['',];";
									//los tipos de linea
									$Graphics_lineDash   = "var lineDash = ['',];";
									//los anchos de la linea
									$Graphics_lineWidth  = "var lineWidth = ['',];";

									$gr_tittle = 'Grafico Nivel Estanque de '.$rowEquipo['NombreEquipo'];
									$gr_unimed = '% de llenado';
									echo GraphLinear_1('graphLinear_2', $gr_tittle, 'Hora', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
									/*******************************************************************************/
									//las fechas
									$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
									//los valores
									$Graphics_yData      ='var yData = [['.$arrData[4]['Value'].'],];';
									//los nombres
									$Graphics_names      = 'var names = ['.$arrData[4]['Name'].',];';
									//los tipos
									$Graphics_types      = "var types = ['',];";
									//si lleva texto en las burbujas
									$Graphics_texts      = "var texts = [[],];";
									//los colores de linea
									$Graphics_lineColors = "var lineColors = ['',];";
									//los tipos de linea
									$Graphics_lineDash   = "var lineDash = ['',];";
									//los anchos de la linea
									$Graphics_lineWidth  = "var lineWidth = ['',];";

									$gr_tittle = 'Grafico Velocidades de '.$rowEquipo['NombreEquipo'];
									$gr_unimed = 'Km * hr';
									echo GraphLinear_1('graphLinear_3', $gr_tittle, 'Hora', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);

								//}
								?>

							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	<?php }else{
		$Alert_Text  = 'No hay registros relacionados al equipo seleccionado entre las fechas ingresadas';
		alert_post_data(4,2,2,0, $Alert_Text);
	} ?>
<?php } ?>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="<?php echo 'view_telemetria_registro_ruta.php?view='.simpleEncode($_GET['idTelemetria'], fecha_actual()); ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
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
	$z .= " AND telemetria_listado.idTab=1";//Agro-Checking
}

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


?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<br/>
	<?php
	//Se escribe el dato
	$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
	alert_post_data(2,1,1,0, $Alert_Text);
	?>
	<br/>
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" action="view_telemetria_registro_ruta.php" id="form1" name="form1" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);

				$Form_Inputs->form_input_hidden('idTelemetria', $X_Puntero, 2);
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
