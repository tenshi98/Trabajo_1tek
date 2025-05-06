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
/**************************************************************/
//variables
$HoraSistema    = hora_actual();
$FechaSistema   = fecha_actual();
$eq_fueralinea  = 0;
$idTelemetria   = simpleDecode($_GET['idTelemetria'], fecha_actual());
$google         = $_SESSION['usuario']['basic_data']['Config_IDGoogle'];

//datos temporales para los widgets
$Gen_Rocio         = 0;
$Gen_Temperatura   = 0;
$Gen_Humedad       = 0;
$Gen_Presion       = 0;
$Total_Rocio       = 0;
$Total_Temperatura = 0;
$Total_Humedad     = 0;
$Total_Presion     = 0;
$Count_Data        = 0;

//Variable
$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
//solo los equipos que tengan el seguimiento desactivado
$SIS_where .= " AND telemetria_listado.id_Geo = 2";
//Filtro de los tab
$SIS_where .= " AND telemetria_listado.idTab = 4 ";//Agro-Weather
//Filtro el equipo
if(isset($idTelemetria)&&$idTelemetria!=''&&$idTelemetria!=0){
	$SIS_where .= " AND telemetria_listado.idTelemetria = ".$idTelemetria;
}

//numero sensores equipo
$N_Maximo_Sensores = 20;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}

//Listar los datos
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.cantSensores,
telemetria_listado.id_Sensores'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';
$rowTel = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowTel');

/*************************************************************/
//se traen todas las zonas
$SIS_query = 'Helada, UnidadesFrio, CrossTech_FechaUnidadFrio, HorasSobreGrados, CrossTech_TempMax, CrossTech_FechaTempMax, Dias_acumulado, Dias_anterior, CrossTech_DiasTempMin, CrossTech_FechaDiasTempMin';
$SIS_join  = '';
$SIS_where = 'idTelemetria='.$idTelemetria.' ORDER BY idAuxiliar DESC';
$rowAux = db_select_data (false, $SIS_query, 'telemetria_listado_aux_equipo', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowAux');

/*************************************************************/
//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

//Ordeno las unidades de medida
$arrFinalUnimed = array();
foreach ($arrUnimed as $data) {
	$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
}

/**********************************************/
//Se resetean
$in_eq_fueralinea  = 0;

/**********************************************/
//Fuera de linea
$diaInicio   = $rowTel['LastUpdateFecha'];
$diaTermino  = $FechaSistema;
$tiempo1     = $rowTel['LastUpdateHora'];
$tiempo2     = $HoraSistema;
$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

//Comparaciones de tiempo
$Time_Tiempo     = horas2segundos($Tiempo);
$Time_Tiempo_FL  = horas2segundos($rowTel['TiempoFueraLinea']);
$Time_Tiempo_Max = horas2segundos('48:00:00');
$Time_Fake_Ini   = horas2segundos('23:59:50');
$Time_Fake_Fin   = horas2segundos('24:00:00');
//comparacion
if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
	$in_eq_fueralinea++;
}

/*******************************************************/
//Promedios de widgets
$Total_Temperatura = $rowTel['SensoresMedActual_1'];
$Total_Humedad     = $rowTel['SensoresMedActual_2'];
$Total_Rocio       = $rowTel['SensoresMedActual_3'];
$Total_Presion     = $rowTel['SensoresMedActual_4'];

//verifico que este midiendo
if($in_eq_fueralinea!=0){
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
		$Alert_Text  = 'Este equipo se encuentra fuera de linea, los datos mostrados no corresponden al estado actual real.';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}

?>

<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table', 'gauge']});</script>

<style>
.float_table table{margin-right: auto !important;margin-left: auto !important;float: none !important;}
</style>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos de <?php echo $rowTel['Nombre']; ?></h5>
		</header>
		<div class="tab-content">

			<div class="">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><div class="float_table" id="chart_gauge_2" ></div> <div class="clearfix"></div><a href="<?php echo 'view_crosstech_historial.php?idTelemetria='.$_GET['idTelemetria'].'&Type='.simpleEncode( 1, fecha_actual()).'&return=view_crosstech_tel_data.php?idTelemetria='.$_GET['idTelemetria']; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a></div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><div class="float_table" id="chart_gauge_3" ></div> <div class="clearfix"></div><a href="<?php echo 'view_crosstech_historial.php?idTelemetria='.$_GET['idTelemetria'].'&Type='.simpleEncode( 2, fecha_actual()).'&return=view_crosstech_tel_data.php?idTelemetria='.$_GET['idTelemetria']; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a></div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><div class="float_table" id="chart_gauge_1" ></div> <div class="clearfix"></div><a href="<?php echo 'view_crosstech_historial.php?idTelemetria='.$_GET['idTelemetria'].'&Type='.simpleEncode( 3, fecha_actual()).'&return=view_crosstech_tel_data.php?idTelemetria='.$_GET['idTelemetria']; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a></div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><div class="float_table" id="chart_gauge_4" ></div> <div class="clearfix"></div><a href="<?php echo 'view_crosstech_historial.php?idTelemetria='.$_GET['idTelemetria'].'&Type='.simpleEncode( 4, fecha_actual()).'&return=view_crosstech_tel_data.php?idTelemetria='.$_GET['idTelemetria']; ?>" class="btn btn-default width100" style="margin-bottom:10px;" ><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a></div>

			</div>
			<?php
			//verifico existencia de datos
			$Helada                       = 0;
			$UnidadFrio                   = 0;
			$CrossTech_FechaUnidadFrio    = 0;
			$HoraSobre                    = 0;
			$CrossTech_TempMax            = 0;
			$CrossTech_FechaTempMax       = 0;
			$Dias_acumulado               = 0;
			$Dias_anterior                = 0;
			$CrossTech_DiasTempMin        = 0;
			$CrossTech_FechaDiasTempMin   = 0;

			//declaracion
			if(isset($rowAux['Helada'])&&$rowAux['Helada']!=''){                                         $Helada                       = $rowAux['Helada'];}
			if(isset($rowAux['UnidadesFrio'])&&$rowAux['UnidadesFrio']!=''){                             $UnidadFrio                   = $rowAux['UnidadesFrio'];}
			if(isset($rowAux['CrossTech_FechaUnidadFrio'])&&$rowAux['CrossTech_FechaUnidadFrio']!=''){   $CrossTech_FechaUnidadFrio    = $rowAux['CrossTech_FechaUnidadFrio'];}
			if(isset($rowAux['HorasSobreGrados'])&&$rowAux['HorasSobreGrados']!=''){                     $HoraSobre                    = $rowAux['HorasSobreGrados'];}
			if(isset($rowAux['CrossTech_TempMax'])&&$rowAux['CrossTech_TempMax']!=''){                   $CrossTech_TempMax            = cantidades($rowAux['CrossTech_TempMax'], 0);}
			if(isset($rowAux['CrossTech_FechaTempMax'])&&$rowAux['CrossTech_FechaTempMax']!=''){         $CrossTech_FechaTempMax       = $rowAux['CrossTech_FechaTempMax'];}
			if(isset($rowAux['Dias_acumulado'])&&$rowAux['Dias_acumulado']!=''){                         $Dias_acumulado               = cantidades($rowAux['Dias_acumulado'], 0);}
			if(isset($rowAux['Dias_anterior'])&&$rowAux['Dias_anterior']!=''){                           $Dias_anterior                = cantidades($rowAux['Dias_anterior'], 0);}
			if(isset($rowAux['CrossTech_DiasTempMin'])&&$rowAux['CrossTech_DiasTempMin']!=''){           $CrossTech_DiasTempMin        = cantidades($rowAux['CrossTech_DiasTempMin'], 0);}
			if(isset($rowAux['CrossTech_FechaDiasTempMin'])&&$rowAux['CrossTech_FechaDiasTempMin']!=''){ $CrossTech_FechaDiasTempMin   = $rowAux['CrossTech_FechaDiasTempMin'];}

			//Dependiendo del valor de la helada se cambia el icono y el color
			if($Helada>3){
				$helIcon = '<span style="color:#00a65a;"><i class="fa fa-thermometer-full" aria-hidden="true"></i></span>';
			}elseif($Helada<=2.9&&$Helada>=0.1){
				$helIcon = '<span style="color:#FFCB19;"><i class="fa fa-thermometer-half" aria-hidden="true"></i></span>';
			}elseif($Helada<0.1){
				$helIcon = '<span style="color:#d9534f;"><i class="fa fa-thermometer-empty" aria-hidden="true"></i></span>';
			}

			$GPS = '
			<div class="">
				<style>
					.tipnoabs{position: initial;}
				</style>

				<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
					<div class="box box-blue box-solid ">
						<div class="box-header with-border text-center">
							<h3 class="box-title">Temperatura Proyectada</h3>
							<div class="box-tools pull-right">
								<a target="_blank" rel="noopener noreferrer" href="view_crosstech_historial_helada.php?idTelemetria='.$_GET['idTelemetria'].'" class="btn btn-xs btn-primary btn-line cboxElement">Ver Mas</a>
							</div>
						</div>
						<div class="box-body">
							<div class="value">
								<span id="update_text_Helada_icon">'.$helIcon.'</span>
								<span id="update_text_Helada">'.cantidades($Helada, 1).'</span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
					<div title="Unidades de frio acumuladas de acuerdo a tabla de unidades de frío de la Universidad de Utah-USA (Modelo del Dr. Richardson) desde la fecha '.fecha_estandar($CrossTech_FechaUnidadFrio).'" class="box box-blue box-solid tooltip">
						<div class="box-header with-border text-center">
							<h3 class="box-title">Unidades de Frio</h3>
						</div>
						<div class="box-body">
							<div class="value">
								<span><i class="fa fa-snowflake-o" aria-hidden="true"></i></span>
								<span id="update_text_UnidadFrio">'.cantidades($UnidadFrio, 0).'</span>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="">

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div title="Horas acumuladas sobre '.$CrossTech_TempMax.'°C desde la fecha '.fecha_estandar($CrossTech_FechaTempMax).'" class="box box-blue box-solid tooltip">
						<div class="box-header with-border text-center">
							<h3 class="box-title">Horas <i class="fa fa-arrow-up" aria-hidden="true"></i> '.$CrossTech_TempMax.'°C</h3>
						</div>
						<div class="box-body">
							<div class="value">
								<span><i class="fa fa-sun-o" aria-hidden="true"></i></span>
								<span id="update_text_HoraSobre">'.cantidades($HoraSobre, 2).'</span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<div class="box box-blue box-solid">
						<div class="box-header with-border text-center">
							<h3 class="box-title">Dias - Grados C°</h3>
						</div>
						<div class="box-body">
							<div title="Horas de temperaturas sobre '.$CrossTech_DiasTempMin.'°C acumuladas desde el '.fecha_estandar($CrossTech_FechaDiasTempMin).' a la fecha." class="col-xs-12 col-sm-6 col-md-6 col-lg-6 value tooltip tipnoabs">
								<span><i class="fa fa-area-chart" aria-hidden="true"></i></span>
								<span id="update_text_Dias_acumulado">'.cantidades($Dias_acumulado, 0).'</span>
							</div>
							<div title="Horas de temperaturas sobre '.$CrossTech_DiasTempMin.'°C de las últimas 24 horas" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 value tooltip tipnoabs">
								<span><i class="fa fa-pagelines" aria-hidden="true"></i></span>
								<span id="update_text_Dias_anterior">'.cantidades($Dias_anterior, 0).'</span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

			</div>';

			echo $GPS;
			?>

			<div class="">
				<div id="map_canvas" style="width: 100%; height: 550px;"></div>
				<div id="consulta"></div>
			</div>

			<?php
			$GPS = '
			<script>

				/* ************************************************************************** */
				//Variables globales
				var chart_gauge_1                 = "";
				var chart_gauge_2                 = "";
				var chart_gauge_3                 = "";
				var chart_gauge_4                 = "";

				var data_gauge_1                  = "";
				var data_gauge_2                  = "";
				var data_gauge_3                  = "";
				var data_gauge_4                  = "";

				var options_gauge_1               = "";
				var options_gauge_2               = "";
				var options_gauge_3               = "";
				var options_gauge_4               = "";

				//carga de los graficos
				google.charts.setOnLoadCallback(Chart_correccion_1);
				google.charts.setOnLoadCallback(Chart_correccion_2);
				google.charts.setOnLoadCallback(Chart_correccion_3);
				google.charts.setOnLoadCallback(Chart_correccion_4);
				/* ************************************************************************** */
				//Punto Rocio
				function Chart_correccion_1() {
					var data_correccion_rows_1 = '.str_replace(",", ".",Cantidades($Total_Rocio, 2)).';
					//se llama funcion de dibujo
					draw_correccion_1(data_correccion_rows_1);
				}
				//Temperatura
				function Chart_correccion_2() {
					var data_correccion_rows_2 = '.str_replace(",", ".",Cantidades($Total_Temperatura, 2)).';
					//se llama funcion de dibujo
					draw_correccion_2(data_correccion_rows_2);
				}
				//Humedad
				function Chart_correccion_3() {
					var data_correccion_rows_3 = '.str_replace(",", ".",Cantidades($Total_Humedad, 2)).';
					//se llama funcion de dibujo
					draw_correccion_3(data_correccion_rows_3);
				}
				//Presion Atmos
				function Chart_correccion_4() {
					var data_correccion_rows_4 = '.str_replace(",", ".",Cantidades($Total_Presion, 2)).';
					//se llama funcion de dibujo
					draw_correccion_4(data_correccion_rows_4);
				}
				/********************************************************************/
				//Punto Rocio
				function draw_correccion_1(data) {
					//datos
					data_gauge_1 = google.visualization.arrayToDataTable([
						["Label", "Valor"],
						["Pr", data]
					]);
					//opciones
					options_gauge_1 = {
						width: 300,
						height: 150,
						majorTicks: ["0","10","20","30","40", "50"],
						minorTicks: 5,
						min:0,
						max:50
					};
					//Formateo
					var formatRocio = new google.visualization.NumberFormat({
						suffix: \'°C\',
						fractionDigits: 1
					});
					formatRocio.format(data_gauge_1, 1);
					//dibujo
					chart_gauge_1 = new google.visualization.Gauge(document.getElementById("chart_gauge_1"));
					chart_gauge_1.draw(data_gauge_1, options_gauge_1);
				}
				function update_correccion_1(data) {
					//Formateo
					var formatRocio = new google.visualization.NumberFormat({
						suffix: \'°C\',
						fractionDigits: 1
					});
					data_gauge_1.setValue(0, 1, data);
					formatRocio.format(data_gauge_1, 1);
					chart_gauge_1.draw(data_gauge_1, options_gauge_1);
				}
				/*******************************************************/
				//Temperatura
				function draw_correccion_2(data) {
					//datos
					data_gauge_2 = google.visualization.arrayToDataTable([
						["Label", "Valor"],
						["Temp", data]
					]);
					//opciones
					options_gauge_2 = {
						width: 300,
						height: 150,
						majorTicks: ["0","10","20","30","40", "50"],
						minorTicks: 10,
						min:0,
						max:50
					};
					//Formateo
					var formatTemp = new google.visualization.NumberFormat({
						suffix: \'°C\',
						fractionDigits: 1
					});
					formatTemp.format(data_gauge_2, 1);
					//dibujo
					chart_gauge_2 = new google.visualization.Gauge(document.getElementById("chart_gauge_2"));
					chart_gauge_2.draw(data_gauge_2, options_gauge_2);
				}
				function update_correccion_2(data) {
					//Formateo
					var formatTemp = new google.visualization.NumberFormat({
						suffix: \'°C\',
						fractionDigits: 1
					});
					data_gauge_2.setValue(0, 1, data);
					formatTemp.format(data_gauge_2, 1);
					chart_gauge_2.draw(data_gauge_2, options_gauge_2);
				}
				/*******************************************************/
				//Humedad
				function draw_correccion_3(data) {
					//datos
					data_gauge_3 = google.visualization.arrayToDataTable([
						["Label", "Valor"],
						["Humedad", data]
					]);
					//opciones
					options_gauge_3 = {
						width: 300,
						height: 150,
						minorTicks: 5
					};
					//Formateo
					var formatHumid = new google.visualization.NumberFormat({
						suffix: \'%\',
						fractionDigits: 1
					});
					formatHumid.format(data_gauge_3, 1);
					//dibujo
					chart_gauge_3 = new google.visualization.Gauge(document.getElementById("chart_gauge_3"));
					chart_gauge_3.draw(data_gauge_3, options_gauge_3);
				}
				function update_correccion_3(data) {
					//Formateo
					var formatHumid = new google.visualization.NumberFormat({
						suffix: \'%\',
						fractionDigits: 1
					});
					data_gauge_3.setValue(0, 1, data);
					formatHumid.format(data_gauge_3, 1);
					chart_gauge_3.draw(data_gauge_3, options_gauge_3);
				}
				/*******************************************************/
				//Presion Atmos
				function draw_correccion_4(data) {
					//datos
					data_gauge_4 = google.visualization.arrayToDataTable([
						["Label", "Valor"],
						["Pb", data]
					]);
					//opciones
					options_gauge_4 = {
						width: 300,
						height: 150,
						majorTicks: ["0","200","400","600","800", "1000", "1200", "1400"],
						minorTicks: 5,
						min:0,
						max:1400
					};
					//Formateo
					var formatPresion = new google.visualization.NumberFormat({
						suffix: \'hPa\',
						fractionDigits: 1
					});
					formatPresion.format(data_gauge_4, 1);
					//dibujo
					chart_gauge_4 = new google.visualization.Gauge(document.getElementById("chart_gauge_4"));
					chart_gauge_4.draw(data_gauge_4, options_gauge_4);
				}
				function update_correccion_4(data) {
					//Formateo
					var formatPresion = new google.visualization.NumberFormat({
						suffix: \'hPa\',
						fractionDigits: 1
					});
					data_gauge_4.setValue(0, 1, data);
					formatPresion.format(data_gauge_4, 1);
					chart_gauge_4.draw(data_gauge_4, options_gauge_4);
				}

				/* ************************************************************************** */
				/* ************************************************************************** */
				/* ************************************************************************** */

				let map;
				var markers = [];

				/* ************************************************************************** */
				function fncCenterMap(Latitud, Longitud, n_icon){
					latlon = new google.maps.LatLng(Latitud, Longitud);
					map.panTo(latlon);
					//volver todo a normal
					for (let i = 0; i < markers.length; i++) {
						markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
					}
					//colorear el seleccionado
					markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
				}

				/* ************************************************************************** */
				async function initMap() {
					const { Map } = await google.maps.importLibrary("maps");

					var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

					var myOptions = {
						zoom: 12,
						center: myLatlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};

					map = new Map(document.getElementById("map_canvas"), myOptions);
					//Ubicación de los distintos dispositivos
					var locations = [ ';

						//burbuja
						$explanation  = '<div class="iw-subTitle">Equipo: '.$rowTel['Nombre'].'</div>';
						$explanation .= 'Actualizado: '.fecha_estandar($rowTel['LastUpdateFecha']).' - '.$rowTel['LastUpdateHora'].'</p>';
						//verifico si tiene sensores configurados
						if(isset($rowTel['id_Sensores'])&&$rowTel['id_Sensores']==1){
							$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
							for ($i = 1; $i <= $rowTel['cantSensores']; $i++) {
								//verifico que sensor este activo
								if(isset($rowTel['SensoresActivo_'.$i])&&$rowTel['SensoresActivo_'.$i]==1){
									//Unidad medida
									if(isset($arrFinalUnimed[$rowTel['SensoresUniMed_'.$i]])){
										$unimed = ' '.$arrFinalUnimed[$rowTel['SensoresUniMed_'.$i]];
									}else{
										$unimed = '';
									}
									//cadena
									if(isset($rowTel['SensoresMedActual_'.$i])&&$rowTel['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($rowTel['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
									$explanation .= $rowTel['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
								}
							}
							$explanation .= '</p>';
						}
						//se arma dato
						$GPS .= "[";
							$GPS .= $rowTel['GeoLatitud'];
							$GPS .= ", ".$rowTel['GeoLongitud'];
							$GPS .= ", '".$explanation."'";
						$GPS .= "], ";

					$GPS .= '];

					//ubicacion inicial
					setMarkers(map, locations, 1);

				}

				/* ************************************************************************** */
				function setMarkers(map, locations, optc) {

					var marker, i, last_latitude, last_longitude;

					for (i = 0; i < locations.length; i++) {

						//defino ubicacion y datos
						var latitude   = locations[i][0];
						var longitude  = locations[i][1];
						var data       = locations[i][2];

						//guardo las ultimas ubicaciones
						last_latitude   = locations[i][0];
						last_longitude  = locations[i][1];

						latlngset = new google.maps.LatLng(latitude, longitude);

						//se crea marcador
						var marker = new google.maps.Marker({
							map         : map,
							position    : latlngset,
							icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
						});
						markers.push(marker);

						//se define contenido
						var content = 	"<div id=\'iw-container\'>" +
										"<div class=\'iw-title\'>Datos</div>" +
										"<div class=\'iw-content\'>" +
										data +
										"</div>" +
										"<div class=\'iw-bottom-gradient\'></div>" +
										"</div>";

						//se crea infowindow
						var infowindow = new google.maps.InfoWindow();

						//se agrega funcion de click a infowindow
						google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
							return function() {
								infowindow.setContent(content);
								infowindow.open(map,marker);
							};
						})(marker,content,infowindow));

					}
					if(optc==1){
						latlon = new google.maps.LatLng(last_latitude, last_longitude);
						map.panTo(latlon);
					}
				}

				/* ************************************************************************** */
				// Sets the map on all markers in the array.
				function setMapOnAll(map) {
					for (let i = 0; i < markers.length; i++) {
					  markers[i].setMap(map);
					}
				}
				/* ************************************************************************** */
				// Removes the markers from the map, but keeps them in the array.
				function clearMarkers() {
					setMapOnAll(null);
				}
				/* ************************************************************************** */
				// Shows any markers currently in the array.
				function showMarkers() {
					setMapOnAll(map);
				}
				/* ************************************************************************** */
				// Deletes all markers in the array by removing references to them.
				function deleteMarkers() {
					clearMarkers();
					markers = [];
				}

			</script>

			';

			echo $GPS;
			?>

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
