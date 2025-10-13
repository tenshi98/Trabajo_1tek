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
//Variable de busqueda
$SIS_where = "backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idTabla!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){   $SIS_where .= " AND cross_predios_listado_zonas.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){$SIS_where .= " AND backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idZona=".$_GET['idZona'];}
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$SIS_where.=" AND backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['fecha_desde']."' AND '".$_GET['fecha_hasta']."'";
}
$SIS_where .=" GROUP BY cross_predios_listado_zonas.idPredio, backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idZona, backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idTelemetria";

/****************************************/
//Numero del sensor
$NSensor = 1;
//consulto
$SIS_query = '
telemetria_listado.Nombre AS EquipoNombre,
cross_predios_listado.Nombre AS PredioNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.GeoLatitud,
backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.GeoLongitud,
backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.' AS CantidadMuestra';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona     = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idZona
LEFT JOIN `cross_predios_listado`         ON cross_predios_listado.idPredio         = cross_predios_listado_zonas.idPredio
LEFT JOIN `telemetria_listado`            ON telemetria_listado.idTelemetria        = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
$SIS_order = 'cross_predios_listado_zonas.idPredio ASC, backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idZona ASC, backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria ASC LIMIT 10000';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');

/*******************************************************/
//consulto
$arrPuntos = array();
$arrPuntos = db_select_array (false, 'idUbicaciones, Latitud, Longitud', 'cross_predios_listado_zonas_ubicaciones', '', 'idZona ='.$_GET['idZona'], 'idUbicaciones ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPuntos');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Resumen Mediciones.
			</h2>
		</div>
	</div>

	<div class="row invoice-info">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Identificación</strong>
			<address>
				Equipo: <?php echo $arrMediciones[0]['EquipoNombre']; ?><br/>
				Predio: <?php echo$arrMediciones[0]['PredioNombre']; ?><br/>
				Cuartel: <?php echo$arrMediciones[0]['CuartelNombre']; ?><br/>
			</address>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
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

					async function initMap() {
						const { Map } = await google.maps.importLibrary("maps");

						var myLatlng = new google.maps.LatLng(<?php echo $arrPuntos[0]['Latitud']; ?>, <?php echo $arrPuntos[0]['Longitud']; ?>);

						var myOptions = {
							zoom: 15,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.SATELLITE
						};

						map = new Map(document.getElementById("map_canvas"), myOptions);
						/* Data points defined as a mixture of WeightedLocation and LatLng objects */
						var heatMapData = [
							<?php
							//recorro los resultados
							foreach ($arrMediciones as $med) {
								$pres = $med['CantidadMuestra'];
								echo '{location: new google.maps.LatLng('.$med['GeoLatitud'].', '.$med['GeoLongitud'].'), weight: '.$pres.'},';
							} ?>
						];

						var heatmap = new google.maps.visualization.HeatmapLayer({
						data: heatMapData
						});
						heatmap.setMap(map);
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
							fillOpacity: 0
						});
						bermudaTriangle.setMap(map);

					}

				</script>
			<?php } ?>
		</div>
	</div>

</section>

<?php if(isset($_GET['return'])&&$_GET['return']!=''){ ?>
	<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
		<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
