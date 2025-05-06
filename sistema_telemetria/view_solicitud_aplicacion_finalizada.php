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
//Version antigua de view
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
$X_idZona = simpleDecode($_GET['idZona'], fecha_actual());
/**************************************************************/
// consulto los datos
$SIS_query = '
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.Mojamiento,
cross_predios_listado.Nombre AS PredioNombre';
$SIS_join  = 'LEFT JOIN `cross_predios_listado` ON cross_predios_listado.idPredio = cross_solicitud_aplicacion_listado.idPredio';
$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud = '.$X_Puntero.' AND cross_solicitud_aplicacion_listado.idSistema ='.$_SESSION['usuario']['basic_data']['idSistema'].' GROUP BY idSolicitud';
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

//Verifico si existe
if(isset($rowData['idSolicitud'])&&$rowData['idSolicitud']!=''){

	/*****************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = '
	cross_solicitud_aplicacion_listado.idSolicitud,
	cross_solicitud_aplicacion_listado_cuarteles.idZona,
	cross_solicitud_aplicacion_listado.NSolicitud,

	cross_solicitud_aplicacion_listado.idSolicitud AS IDD,

	(SELECT SUM(cross_predios_listado_zonas.Hectareas) 
	FROM `cross_solicitud_aplicacion_listado_cuarteles` 
	LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
	WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD AND cross_solicitud_aplicacion_listado_cuarteles.idZona = '.$X_idZona.' ) AS CuartelHectareas,

	(SELECT SUM(cross_predios_listado_zonas.Plantas) 
	FROM `cross_solicitud_aplicacion_listado_cuarteles` 
	LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
	WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD AND cross_solicitud_aplicacion_listado_cuarteles.idZona = '.$X_idZona.' ) AS CuartelCantPlantas,

	(SELECT AVG(cross_predios_listado_zonas.DistanciaPlant) 
	FROM `cross_solicitud_aplicacion_listado_cuarteles` 
	LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
	WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD AND cross_solicitud_aplicacion_listado_cuarteles.idZona = '.$X_idZona.' ) AS CuartelDistanciaPlant,

	AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm!=0,cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,0),0)) AS GeoVelocidadProm,
	SUM(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoDistance!=0,cross_solicitud_aplicacion_listado_tractores.GeoDistance,0),0)) AS GeoDistance,
	SUM(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Diferencia!=0,cross_solicitud_aplicacion_listado_tractores.Diferencia,0),0)) AS Litros,
	AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom,0),0)) AS Sensor_1_Prom,
	AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom,0),0)) AS Sensor_2_Prom';
	$SIS_join  = '
	LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
	LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles';
	$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud = '.$rowData['idSolicitud'].' AND cross_solicitud_aplicacion_listado_cuarteles.idZona = '.$X_idZona.' GROUP BY cross_solicitud_aplicacion_listado.idSolicitud ORDER BY cross_solicitud_aplicacion_listado.idSolicitud DESC';
	$rowSolicitud = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowSolicitud');

	/*****************************************/
	// consulto los datos
	$SIS_query = '
	cross_solicitud_aplicacion_listado_tractores.idTelemetria,
	vehiculos_listado.Nombre AS VehiculoNombreBack,
	telemetria_listado.Nombre AS VehiculoNombre,
	telemetria_listado.cantSensores';
	$SIS_join  = '
	LEFT JOIN `telemetria_listado`   ON telemetria_listado.idTelemetria    = cross_solicitud_aplicacion_listado_tractores.idTelemetria
	LEFT JOIN `vehiculos_listado`    ON vehiculos_listado.idVehiculo       = cross_solicitud_aplicacion_listado_tractores.idVehiculo';
	$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud = '.$rowData['idSolicitud'].' GROUP BY cross_solicitud_aplicacion_listado_tractores.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrTractores = array();
	$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTractores');

						
	/*****************************************/
	//Variable para almacenar los recorridos
	$rec_x           = '';
	$marker_loc      = '';
	$arrMedTractores = array();

	//Recorro las mediciones
	foreach ($arrTractores as $trac) {
		//Se crean variables vacias
		$arrMedTractores[$trac['idTelemetria']]['caudales']     = '';
		$arrMedTractores[$trac['idTelemetria']]['niveles']      = '';
		$arrMedTractores[$trac['idTelemetria']]['velocidades']  = '';
		$arrMedTractores[$trac['idTelemetria']]['heatMapData']  = '';

		/***************************************/
		$subquery  = '';
		$subquery .= ',FechaSistema';
		$subquery .= ',HoraSistema';
		$subquery .= ',GeoLatitud';
		$subquery .= ',GeoLongitud';
		$subquery .= ',GeoMovimiento';
		$subquery .= ',GeoVelocidad';
		//se recorre deacuerdo a la cantidad de sensores
		for ($i = 1; $i <= $trac['cantSensores']; $i++) {
			$subquery .= ',Sensor_'.$i;
		}
		//consulta
		$SIS_query = 'idTabla, idTelemetria'.$subquery;
		$SIS_join  = '';
		$SIS_where = 'idSolicitud = '.$rowData['idSolicitud'].' AND idZona = '.$X_idZona;
		$SIS_order = 'FechaSistema ASC, HoraSistema ASC';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

		//recorro los resultados
		foreach ($arrMediciones as $med) {
			$pres = 0;
			//if(isset($med['GeoLatitud'])&&$med['GeoLatitud']!=0&&isset($med['GeoLongitud'])&&$med['GeoLongitud']!=0&&($med['Sensor_1']>1 OR $med['Sensor_2']>1)){
			if(isset($med['GeoLatitud'])&&$med['GeoLatitud']!=0&&isset($med['GeoLongitud'])&&$med['GeoLongitud']!=0){
				$pres = $med['Sensor_1'] + $med['Sensor_2'];
				$rec_x .= "{location: new google.maps.LatLng(".$med['GeoLatitud'].", ".$med['GeoLongitud']."), weight: ".$pres."},
				";
				//burbuja
				$explanation  = '<div class="iw-subTitle">Caudales Equipo</div>';
				$explanation .= '<p>';
				$explanation .= 'Tractor: '.$trac['VehiculoNombreBack'].'<br/>';
				$explanation .= 'Equipo: '.$trac['VehiculoNombre'];
				$explanation .= '</p>';
				$explanation .= '<p>';
				$explanation .= 'Hora: '.$med['HoraSistema'].'<br/>';
				$explanation .= 'Caudal Derecho: '.cantidades($med['Sensor_1'], 2).'<br/>';
				$explanation .= 'Caudal Izquierdo: '.cantidades($med['Sensor_2'], 2).'<br/>';
				$explanation .= 'Nivel Estanque: '.cantidades($med['Sensor_3'], 1).' %<br/>';
				$explanation .= 'Velocidad: '.cantidades($med['GeoVelocidad'], 0).' K/M<br/>';
				$explanation .= '</p>';
				//se arma dato
				$marker_loc .= "[";
					$marker_loc .= $med['GeoLatitud'];
					$marker_loc .= ", ".$med['GeoLongitud'];
					$marker_loc .= ", '".$explanation."'";
					//cambio de iconos
					$marker_loc .= ", ".$med['idTelemetria'];
					/*if(($med['Sensor_1']+$med['Sensor_2'])<1){
						$marker_loc .= ", 0";
					}else{
						$marker_loc .= ", 1";
					}*/
				$marker_loc .= "], ";
						
				$arrMedTractores[$trac['idTelemetria']]['heatMapData']  .= "{location: new google.maps.LatLng(".$med['GeoLatitud'].", ".$med['GeoLongitud']."), weight: ".$pres."},";
				//$arrMedTractores[$trac['idTelemetria']]['MarkerData']  .= $marker_loc;
				//Guardo los datos temporales
				$arrMedTractores[$trac['idTelemetria']]['caudales']     .= '["'.$med['FechaSistema'].' '.$med['HoraSistema'].'",'.Cantidades_decimales_justos($med['Sensor_1']).','.Cantidades_decimales_justos($med['Sensor_2']).'],';
				$arrMedTractores[$trac['idTelemetria']]['niveles']      .= '["'.$med['FechaSistema'].' '.$med['HoraSistema'].'",'.Cantidades_decimales_justos($med['Sensor_3']).',],';
				$arrMedTractores[$trac['idTelemetria']]['velocidades']  .= '["'.$med['FechaSistema'].' '.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['GeoVelocidad']).'],';

			}
		}
	}

	/**************************************/
	// consulto los datos
	$SIS_query = '
	cross_predios_listado_zonas.idZona,
	cross_predios_listado_zonas.Nombre,
	cross_predios_listado_zonas_ubicaciones.Latitud,
	cross_predios_listado_zonas_ubicaciones.Longitud';
	$SIS_join  = '
	LEFT JOIN `cross_predios_listado_zonas`               ON cross_predios_listado_zonas.idPredio             = cross_solicitud_aplicacion_listado.idPredio
	LEFT JOIN `cross_predios_listado_zonas_ubicaciones`   ON cross_predios_listado_zonas_ubicaciones.idZona   = cross_predios_listado_zonas.idZona';
	$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud = '.$rowData['idSolicitud'].' AND cross_predios_listado_zonas.idZona = '.$X_idZona;
	$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
	$arrZonas = array();
	$arrZonas = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

	/**************************************/
	// consulto los datos
	$SIS_query = '
	cross_solicitud_aplicacion_listado_tractores.idTelemetria,
	cross_solicitud_aplicacion_listado_cuarteles.idZona,
	cross_predios_listado_zonas.Nombre AS CuartelNombre,
	cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin AS VelocidadMin,
	cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax AS VelocidadMax,
	cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm AS VelocidadProm,
	cross_solicitud_aplicacion_listado_cuarteles.VelTractor AS VelocidadProg,
	cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom AS PromCaudalIzq,
	cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom AS PromCaudalDer,
	cross_solicitud_aplicacion_listado_tractores.Diferencia AS LitrosAplicados,
	cross_solicitud_aplicacion_listado_tractores.T_Aplicacion AS TiempoAplicacion';
	$SIS_join  = '
	LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles   = cross_solicitud_aplicacion_listado_tractores.idCuarteles
	LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona';
	$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud = '.$rowData['idSolicitud'].' AND cross_solicitud_aplicacion_listado_cuarteles.idZona = '.$X_idZona;
	$SIS_order = 'cross_predios_listado_zonas.Nombre asc';
	$arrTractoresData = array();
	$arrTractoresData = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTractoresData');

	//Se obtiene la ubicacion
	$Ubicacion = "";
	if(isset($arrZonas[0]['Direccion'])&&$arrZonas[0]['Direccion']!=''){$Ubicacion.=' '.$arrZonas[0]['Direccion'];}
	if(isset($arrZonas[0]['Comuna'])&&$arrZonas[0]['Comuna']!=''){      $Ubicacion.=', '.$arrZonas[0]['Comuna'];}
	if(isset($arrZonas[0]['Ciudad'])&&$arrZonas[0]['Ciudad']!=''){      $Ubicacion.=', '.$arrZonas[0]['Ciudad'];}


	//Se limpian los nombres
	$Ubicacion = str_replace('Nº', '', $Ubicacion);
	$Ubicacion = str_replace('nº', '', $Ubicacion);
	$Ubicacion = str_replace(' n ', '', $Ubicacion);
		
	$Ubicacion = str_replace("'", '', $Ubicacion);
		
	$Ubicacion = str_replace("Av.", 'Avenida', $Ubicacion);
	$Ubicacion = str_replace("av.", 'Avenida', $Ubicacion);

	///////////////////////////////////////////////////////////////////////////////////////
	//Calculos
	if(isset($rowSolicitud['GeoDistance'])&&$rowSolicitud['GeoDistance']!=0&&isset($rowSolicitud['CuartelDistanciaPlant'])&&$rowSolicitud['CuartelDistanciaPlant']!=''&&$rowSolicitud['CuartelDistanciaPlant']!=0){
		$PPendientes     = ((($rowSolicitud['CuartelDistanciaPlant']*$rowSolicitud['CuartelCantPlantas']) - ($rowSolicitud['GeoDistance']*1000))/$rowSolicitud['CuartelDistanciaPlant']);
	}else{
		$PPendientes = 0;
	}
	if($PPendientes<0){
		$PPendientes = 0;
	}
			
	/*******************************************************/
	$LitrosProgramados      = $rowData['Mojamiento']*$rowSolicitud['CuartelHectareas'];
	$LitrosTotales          = $rowSolicitud['Litros'];
	$MojamientoHectarea     = $LitrosTotales/$rowSolicitud['CuartelHectareas'];
	$Porcen_Mojamiento      = ($MojamientoHectarea /$rowData['Mojamiento'])*100;
	$TotalPlantasAplicadas  = $rowSolicitud['CuartelCantPlantas'] - $PPendientes;
	$TotalPlantasPendientes = $PPendientes;
	$TractorVelocidadProm   = $rowSolicitud['GeoVelocidadProm'];
	$TractorDerechoProm     = $rowSolicitud['Sensor_1_Prom'];
	$TractorIzquierdoProm   = $rowSolicitud['Sensor_2_Prom'];


	?>
	<style>
	.float_table table{margin-right: auto !important;margin-left: auto !important;float: none !important;}
	.t_search_button {
		padding: 6px 12px !important;
		font-size: 14px !important;
		font-weight: 400 !important;
		line-height: 1 !important;
		color: #555 !important;
		text-align: center !important;
		background-color: #eee !important;
		border: 1px solid #ccc !important;
			border-left-color: rgb(204, 204, 204);
			border-left-style: solid;
			border-left-width: 1px;
		border-bottom-right-radius: 4px !important;
		border-top-right-radius: 4px !important;
		width: 50px !important;
		height: 34px !important;
		border-left: 0 !important;
		white-space: nowrap;
	}

	</style>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table', 'gauge']});</script>
		<?php
		//Si no existe una ID se utiliza una por defecto
		if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
			$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
			alert_post_data(4,2,2,0, $Alert_Text);
		}else{
			$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>
			<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
		<?php } ?>
		<style>
			.my_marker {color: white;background-color: black;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
			.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
		</style>

		<?php
		//Variables
		$Cent_zonaLatitud   = $arrZonas[0]['Latitud'];
		$Cent_zonaLongitud  = $arrZonas[0]['Longitud'];

		?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box noborderbox">
				<header class="header">
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5><?php if(isset($arrTractoresData[0]['CuartelNombre'])&&$arrTractoresData[0]['CuartelNombre']!=''){echo 'Cuartel '.$arrTractoresData[0]['CuartelNombre'];} ?></h5>

					<ul class="nav nav-tabs pull-right">
						<li class="active"><a href="#resumen"   aria-controls="resumen"   role="tab" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
						<?php
						$xcounter = 1;
						foreach($arrTractores as $trac) {
							if ($arrTractoresData!=false && !empty($arrTractoresData) && $arrTractoresData!='') {
								$sum_LitrosAplicados    = 0;
								foreach ($arrTractoresData as $tractda) {
									if(isset($trac['idTelemetria'])&&isset($tractda['idTelemetria'])&&$trac['idTelemetria']==$tractda['idTelemetria']){
										$sum_LitrosAplicados    = $sum_LitrosAplicados + $tractda['LitrosAplicados'];
									}
								}
							}
							//paginador de tabs
							if($xcounter==7){ ?> <li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu"> <?php } ?>
							<li>
								<a href="#equipo_<?php echo $trac['idTelemetria']; ?>" aria-controls="equipo_<?php echo $trac['idTelemetria']; ?>" role="tab" data-toggle="tab">
									<?php
									//Reviso si tuvo participacion
									if($sum_LitrosAplicados!=0){
										echo '<span style="color: #3c763d;"><i class="fa fa-check" aria-hidden="true"></i> '.$trac['VehiculoNombre'].'</span>';
									}else{
										echo '<span style="color: #a94442;"><i class="fa fa-times" aria-hidden="true"></i> '.$trac['VehiculoNombre'].'</span>';
									} ?>
								</a>
							</li>
							<?php $xcounter++;
						}
						if($xcounter>3){ ?></ul></li><?php } ?>
					</ul>
				</header>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="resumen">

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>% Mojamiento</strong></h5>          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float_table" id="chart_mojamiento" style="height: 200px;"></div></div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Dispersión de Flujos</strong></h5>  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float_table" id="chart_gauge" style="height: 200px;"></div></div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Velocidad Promedio</strong></h5>    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float_table" id="chart_velocidades" style="height: 200px;"></div></div>			
						<div class="clearfix"></div>

						<?php //<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Porcentaje Plantas Aplicadas</strong></h5>     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"             id="chart_plantas_aplicadas" style="height: 200px;"></div></div> ?>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Litros Programados vs Aplicados</strong></h5>  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"             id="chart_litros_aplicados" style="height: 200px;"></div></div>			
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Caudales Promedios</strong></h5>               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"             id="chart_caudales" style="height: 200px;"></div></div>

						<?php
						/********************************************************************/
						//Velocidades
						echo '
						<script>
							/* ************************************************************************** */
							//Variables globales
							var chart_vel                   = "";
							var chart_litros                = "";
							var chart_caud                  = "";
							var chart_gauge                 = "";
							//var chart_aplicadas             = "";
							var chart_mojamiento            = "";

							var data_vel                    = "";
							var data_litros                 = "";
							var data_caud                   = "";
							var data_gauge                  = "";
							//var data_aplicadas              = "";
							var data_mojamiento             = "";

							var options_vel                 = "";
							var options_litros              = "";
							var options_caud                = "";
							var options_gauge               = "";
							//var options_aplicadas           = "";
							var options_mojamiento          = "";

							//carga de los graficos
							google.charts.setOnLoadCallback(Chart_velocidades);
							google.charts.setOnLoadCallback(Chart_litros_aplicados);
							google.charts.setOnLoadCallback(Chart_caudales);
							google.charts.setOnLoadCallback(Chart_correccion);
							//google.charts.setOnLoadCallback(Chart_aplicadas);
							google.charts.setOnLoadCallback(Chart_mojamiento);

							/* ************************************************************************** */
							//Graficos	al cargar datos
							function Chart_velocidades() {';
								echo 'var data_vel_rows = '.str_replace(",", ".",Cantidades($TractorVelocidadProm, 2)).';
								//se llama funcion de dibujo
								draw_velocidades(data_vel_rows);
							}
							function Chart_litros_aplicados() {';
								//variables
								echo 'var data_litros_rows = [';
								echo '["Litros Aplicados",';
								echo Cantidades_decimales_justos($LitrosProgramados).',';
								echo '"'.Cantidades($LitrosProgramados, 2).'",';
								echo Cantidades_decimales_justos($LitrosTotales).',';
								echo '"'.Cantidades($LitrosTotales, 2).'",';
								echo '],';
								echo '];
								//se llama funcion de dibujo
								draw_litros_aplicados(data_litros_rows);
							}
							function Chart_caudales() {';
								//caudales
								echo 'var data_caud_rows = [';
								echo '["Caudales",';
								echo Cantidades_decimales_justos($TractorDerechoProm).',';
								echo '"'.Cantidades($TractorDerechoProm, 2).'",';
								echo Cantidades_decimales_justos($TractorIzquierdoProm).',';
								echo '"'.Cantidades($TractorIzquierdoProm, 2).'",';
								echo '],';
								echo '];
								//se llama funcion de dibujo
								draw_caudales(data_caud_rows);
							}
							function Chart_correccion() {';
								if($TractorDerechoProm>$TractorIzquierdoProm){
									if($TractorIzquierdoProm!=0){ $correccion = (($TractorDerechoProm - $TractorIzquierdoProm)/$TractorIzquierdoProm)*100;}else{$correccion = 0;}
								}else{
									if($TractorDerechoProm!=0){   $correccion = (($TractorIzquierdoProm - $TractorDerechoProm)/$TractorDerechoProm)*100;}else{$correccion = 0;}
								}
								echo 'var data_correccion_rows = '.str_replace(",", ".",Cantidades($correccion, 2)).';
								//se llama funcion de dibujo
								draw_correccion(data_correccion_rows);
							}
							/*function Chart_aplicadas() {
								var data_aplicadas_rows = [
									["%Plantas", "Plantas"],
									["Aplicadas",     '.cantidades($TotalPlantasAplicadas,0).'],
									["No Aplicadas",  '.cantidades($TotalPlantasPendientes,0).']
								]
								//se llama funcion de dibujo
								draw_aplicadas(data_aplicadas_rows);
							}*/
							function Chart_mojamiento() {
								//se llama funcion de dibujo
								draw_mojamiento('.cantidades($Porcen_Mojamiento,0).', '.cantidades($MojamientoHectarea,0).');
							}

							/********************************************************************/
							//dibujado de los graficos
							//Velocidades
							function draw_velocidades(data) {
								//datos
								data_vel = google.visualization.arrayToDataTable([
									["Label", "Valor"],
									["K/H", data]
								]);
								//opciones
								options_vel = {
									width: 400,
									height: 200,
									greenFrom: 5,
									greenTo: 7,
									greenColor: "#109618",
									yellowFrom: 0,
									yellowTo: 4,
									yellowColor: "#DC3912",
									redFrom: 8,
									redTo: 100,
									redColor: "#DC3912",
									minorTicks: 10
								};
								//dibujo
								chart_vel = new google.visualization.Gauge(document.getElementById("chart_velocidades"));
								chart_vel.draw(data_vel, options_vel);
							}
							/********************************************************************/
							//Litros aplicados vs programados
							function draw_litros_aplicados(data) {
								//Caudales
								data_litros = new google.visualization.DataTable();
								data_litros.addColumn("string", "Litros");
								data_litros.addColumn("number", "Programado");
								data_litros.addColumn({type: "string", role: "annotation"});
								data_litros.addColumn("number", "Aplicado");
								data_litros.addColumn({type: "string", role: "annotation"});
								//datos
								data_litros.addRows(data);
								//opciones
								options_litros = {
									hAxis: {title: "Litros"},
									vAxis: { title: "Litros", minValue: 0 },
									curveType: "function",
									colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"],
									legend: { position: "none"},
									hAxis: { textPosition: "none"}
								};
								//dibujo
								chart_litros = new google.visualization.ColumnChart(document.getElementById("chart_litros_aplicados"));
								chart_litros.draw(data_litros, options_litros);

							}
							/********************************************************************/
							//Caudales
							function draw_caudales(data) {
								//Caudales
								data_caud = new google.visualization.DataTable();
								data_caud.addColumn("string", "Grupo");
								data_caud.addColumn("number", "Caudal Derecho");
								data_caud.addColumn({type: "string", role: "annotation"});
								data_caud.addColumn("number", "Caudal Izquierdo");
								data_caud.addColumn({type: "string", role: "annotation"});
								//datos
								data_caud.addRows(data);
								//opciones
								options_caud = {
									hAxis: {title: "Ramales"},
									vAxis: { title: "Litros * Minutos", minValue: 0 },
									curveType: "function",
									colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"],
									legend: { position: "none"},
									hAxis: { textPosition: "none"}
								};
								//dibujo
								chart_caud = new google.visualization.ColumnChart(document.getElementById("chart_caudales"));
								chart_caud.draw(data_caud, options_caud);

							}
							/********************************************************************/
							//Correccion
							function draw_correccion(data) {
								//datos
								data_gauge = google.visualization.arrayToDataTable([
									["Label", "Valor"],
									["%", data]
								]);
								//opciones
								options_gauge = {
									width: 400,
									height: 200,
									greenFrom: 0,
									greenTo: 10,
									yellowFrom: 11,
									yellowTo: 15,
									redFrom: 16,
									redTo: 100,
									minorTicks: 10
								};
								//dibujo
								chart_gauge = new google.visualization.Gauge(document.getElementById("chart_gauge"));
								chart_gauge.draw(data_gauge, options_gauge);
							}
							/********************************************************************/
							//Procentaje plantas aplicadas
							/*function draw_aplicadas(data) {
								//datos
								data_aplicadas = google.visualization.arrayToDataTable(data);
								//opciones
								options_aplicadas = {
									is3D: true,
									legend: { position: "none"},
								};
								//dibujo
								chart_aplicadas = new google.visualization.PieChart(document.getElementById("chart_plantas_aplicadas"));
								chart_aplicadas.draw(data_aplicadas, options_aplicadas);
							}*/
							/********************************************************************/
							//Correccion
							function draw_mojamiento(data1, data2) {

								//datos
								data_mojamiento = google.visualization.arrayToDataTable([
									["Label", "Valor"],
									[data2+" L/Ha", data1]
								]);
								//opciones
								options_mojamiento = {
									width: 400,
									height: 200,
									yellowFrom: 0,
									yellowTo: 93,
									yellowColor: "#DC3912",
									greenFrom: 94,
									greenTo: 106,
									greenColor: "#109618",
									redFrom: 107,
									redTo: 200,
									redColor: "#DC3912",
									minorTicks: 10,
									min:0,
									max:200
								};
								//dibujo
								chart_mojamiento = new google.visualization.Gauge(document.getElementById("chart_mojamiento"));
								chart_mojamiento.draw(data_mojamiento, options_mojamiento);
							}
						</script>';
						?>

						<div class="">
							<div class="col-xs-12" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
								<?php
								//Si no existe una ID se utiliza una por defecto
								if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
									$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
									alert_post_data(4,2,2,0, $Alert_Text);
								}else{ ?>
									<div id="map_canvas_x1" style="width: 100%; height: 550px;"></div>
									<script>
										let map_1,map_2;
										var marker;
										var markersCam = [];

										async function initMap() {
											const { Map } = await google.maps.importLibrary("maps");

											var myLatlng = new google.maps.LatLng(<?php echo $Cent_zonaLatitud.','.$Cent_zonaLongitud; ?>);

											var myOptions1 = {
												zoom: 18,
												center: myLatlng,
												mapTypeId: google.maps.MapTypeId.SATELLITE
											};
											/*var myOptions2 = {
												zoom: 15,
												center: myLatlng,
												mapTypeId: google.maps.MapTypeId.SATELLITE
											};*/

											map_1 = new Map(document.getElementById("map_canvas_x1"), myOptions1);
											//map_2 = new Map(document.getElementById("map_canvas_x2"), myOptions2);

											//Se dibujan los puntos en base a los niveles de riego
											/* Data points defined as a mixture of WeightedLocation and LatLng objects */
											/*var heatMapData = [<?php echo $rec_x; ?>];*/

											/*var heatmap = new google.maps.visualization.HeatmapLayer({
												data: heatMapData,
												map: map_2
											});
											heatmap.setMap(map_2);*/

											//Ubicación de los distintos dispositivos
											var locations = [<?php echo $marker_loc; ?>];

											//marcadores
											setMarkers(map_1, locations);

											dibuja_zona();

										}

										/* ************************************************************************** */
										function dibuja_zona() {

											var polygons1 = [];
											//var polygons2 = [];
											<?php
											//variables
											$Latitud_z       = 0;
											$Longitud_z      = 0;
											$Latitud_z_prom  = 0;
											$Longitud_z_prom = 0;
											$zcounter        = 0;
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

												if(isset($Longitud_x)&&$Longitud_x!=''){
													echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
												}

												echo '];';

												echo '
												polygons1.push(new google.maps.Polygon({
													paths: path'.$todaszonas.',
													strokeColor: \'#FF0000\',
													strokeOpacity: 0.8,
													strokeWeight: 2,
													fillColor: \'#FF0000\',
													fillOpacity: 0.35
												}));
												/*polygons2.push(new google.maps.Polygon({
													paths: path'.$todaszonas.',
													strokeColor: \'#FF0000\',
													strokeOpacity: 0.8,
													strokeWeight: 2,
													fillColor: \'#FF0000\',
													fillOpacity: 0
												}));*/
												polygons1[polygons1.length-1].setMap(map_1);
												//polygons2[polygons2.length-1].setMap(map_2);
												';
												/*if($zcounter3!=0){
													$Latitud_z_prom_2  = $Latitud_z_2/$zcounter3;
													$Longitud_z_prom_2 = $Longitud_z_2/$zcounter3;
												}*/
												// The label that pops up when the mouse moves within each polygon.
												echo '
												/*myLatlng = new google.maps.LatLng('.$Latitud_z_prom_2.', '.$Longitud_z_prom_2.');

												var marker = new MyMarker({
													position: myLatlng,
													label: "'.$zonas[0]['Nombre'].'"
												});
												marker.setMap(map_1);*/

												// When the mouse moves within the polygon, display the label and change the BG color.
												google.maps.event.addListener(polygons1['.$zcounter2.'], "mousemove", function(event) {
													polygons1['.$zcounter2.'].setOptions({
														fillColor: "#00FF00"
													});
												});

												// WHen the mouse moves out of the polygon, hide the label and change the BG color.
												google.maps.event.addListener(polygons1['.$zcounter2.'], "mouseout", function(event) {
													polygons1['.$zcounter2.'].setOptions({
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
														echo 'myLatlng = new google.maps.LatLng('.$Latitud_z_prom.', '.$Longitud_z_prom.');';
														echo 'map_1.setCenter(myLatlng);';
														//echo 'map_2.setCenter(myLatlng);';
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

													map_1.setCenter(myLatlng);
													map_2.setCenter(myLatlng);

												}else {
													Swal.fire({icon: 'error',title: 'Oops...',text: 'Geocode was not successful for the following reason: ' + status});
												}
											});
										}
										/* ************************************************************************** */
										function setMarkers(map_1, locations) {

											var marker, i, last_latitude, last_longitude;

											for (i = 0; i < locations.length; i++) {

												//defino ubicacion y datos
												var latitude   = locations[i][0];
												var longitude  = locations[i][1];
												var data       = locations[i][2];
												var icon       = locations[i][3];
												var marcador   = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/3_comun_" + icon + ".png";
												var title      = "Información";

												//guardo las ultimas ubicaciones
												last_latitude   = locations[i][0];
												last_longitude  = locations[i][1];

												//ubicacion mapa
												latlngset = new google.maps.LatLng(latitude, longitude);

												//defino marcador
												/*switch (icon) {
													case 0:
														marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/1_tractor_1.png";
														break;
													case 1:
														marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/1_tractor_2.png";
														break;
												}*/
												//se crea marcador
												var marker = new google.maps.Marker({
													map         : map_1,
													position    : latlngset,
													icon      	: marcador
												});
												markersCam.push(marker);

												//se define contenido
												var content = 	"<div id='iw-container'>" +
																"<div class='iw-title'>" + title + "</div>" +
																"<div class='iw-content'>" +
																data +
																"</div>" +
																"<div class='iw-bottom-gradient'></div>" +
																"</div>";

												//se crea infowindow
												var infowindow = new google.maps.InfoWindow();

												//se agrega funcion de click a infowindow
												google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
													return function() {
														infowindow.setContent(content);
														infowindow.open(map_1,marker);
													};
												})(marker,content,infowindow));

											}
											latlon = new google.maps.LatLng(last_latitude, last_longitude);
											map_1.panTo(latlon);
										}
										/* ************************************************************************** */
										// Sets the map on all markers in the array.
										function setMapOnAll(map_1) {
											for (let i = 0; i < markersCam.length; i++) {
												markersCam[i].setMap(map_1);
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
											setMapOnAll(map_1);
										}
										/* ************************************************************************** */
										// Deletes all markers in the array by removing references to them.
										function deleteMarkers() {
											clearMarkers();
											markersCam = [];
										}

									</script>
								<?php } ?>
							</div>
						</div>
					</div>

					<?php foreach($arrTractores as $trac) { ?>
						<div role="tabpanel" class="tab-pane fade" id="equipo_<?php echo $trac['idTelemetria']; ?>">

							<div class="">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<tbody>
											<tr role="row">
												<td colspan="1" style="text-align: center;"></td>
												<td colspan="4" style="text-align: center;">Velocidad Tractor (Km/hr)</td>
												<td colspan="2" style="text-align: center;">Promedio Caudales</td>
												<td colspan="2" style="text-align: center;">Aplicacion</td>
												<td colspan="1" style="text-align: center;" width="10">Aplicacion</td>
											</tr>
											<tr class="active">
												<td><strong>Cuartel</strong></td>

												<td><strong>Programada</strong></td>
												<td><strong>Minima</strong></td>
												<td><strong>Maxima</strong></td>
												<td><strong>Promedio</strong></td>

												<td><strong>Total</strong></td>
												<td><strong>Dispersión de Flujos</strong></td>

												<td><strong>Litros</strong></td>
												<td><strong>Tiempo</strong></td>

												<td width="10"><strong>Acciones</strong></td>

											</tr>
											<?php
											//recorro el lsiatdo entregado por la base de datos
											if ($arrTractoresData!=false && !empty($arrTractoresData) && $arrTractoresData!='') {
												//variables en 0
												$xcounter               = 0;
												$sum_VelocidadProg      = 0;
												$sum_VelocidadMin       = 0;
												$sum_VelocidadMax       = 0;
												$sum_VelocidadProm      = 0;
												$sum_total_caudal       = 0;
												$sum_correccion_caudal  = 0;
												$sum_LitrosAplicados    = 0;
												$sum_TiempoAplicacion   = '00:00:00';

												foreach ($arrTractoresData as $tractda) {
													if(isset($trac['idTelemetria'])&&isset($tractda['idTelemetria'])&&$trac['idTelemetria']==$tractda['idTelemetria']){
														?>

														<tr class="item-row linea_punteada">

															<td class="item-name"><?php echo $tractda['CuartelNombre']; ?></td>

															<td class="item-name"><?php echo Cantidades($tractda['VelocidadProg'], 1); ?></td>
															<td class="item-name"><?php echo Cantidades($tractda['VelocidadMin'], 1); ?></td>
															<td class="item-name"><?php echo Cantidades($tractda['VelocidadMax'], 1); ?></td>
															<td class="item-name"><?php echo Cantidades($tractda['VelocidadProm'], 1); ?></td>

															<?php
															$total_caudal = $tractda['PromCaudalIzq'] + $tractda['PromCaudalDer'];
															if($tractda['PromCaudalDer']>$tractda['PromCaudalIzq']){
																if($tractda['PromCaudalIzq']!=0){$correccion = (($tractda['PromCaudalDer'] - $tractda['PromCaudalIzq'])/$tractda['PromCaudalIzq'])*100;}else{$correccion = 0;}
															}else{
																if($tractda['PromCaudalDer']!=0){$correccion = (($tractda['PromCaudalIzq'] - $tractda['PromCaudalDer'])/$tractda['PromCaudalDer'])*100;}else{$correccion = 0;}
															}
															?>

															<td class="item-name"><?php echo Cantidades($total_caudal, 2); ?></td>
															<td class="item-name"><?php echo Cantidades($correccion, 2).' %'; ?></td>

															<td class="item-name"><?php echo Cantidades($tractda['LitrosAplicados'], 2); ?></td>
															<td class="item-name"><?php echo $tractda['TiempoAplicacion']; ?></td>

															<td>
																<div class="btn-group" style="width: 70px;" >
																	<a href="<?php echo 'view_solicitud_aplicacion_detenciones.php?view='.simpleEncode($rowData['idSolicitud'], fecha_actual()).'&idTelemetria='.simpleEncode($trac['idTelemetria'], fecha_actual()).'&idZona='.simpleEncode($tractda['idZona'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Detenciones" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																	<a href="<?php echo 'view_solicitud_aplicacion_fuera_linea.php?view='.simpleEncode($rowData['idSolicitud'], fecha_actual()).'&idTelemetria='.simpleEncode($trac['idTelemetria'], fecha_actual()).'&idZona='.simpleEncode($tractda['idZona'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Fuera de Linea" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																</div>
															</td>

														</tr>

														<?php
														//operaciones
														if($total_caudal!=0){$xcounter++;}
														$sum_VelocidadProg      = $sum_VelocidadProg + $tractda['VelocidadProg'];
														$sum_VelocidadMin       = $sum_VelocidadMin + $tractda['VelocidadMin'];
														$sum_VelocidadMax       = $sum_VelocidadMax + $tractda['VelocidadMax'];
														$sum_VelocidadProm      = $sum_VelocidadProm + $tractda['VelocidadProm'];
														$sum_total_caudal       = $sum_total_caudal + $total_caudal;
														$sum_correccion_caudal  = $sum_correccion_caudal + $correccion;
														$sum_LitrosAplicados    = $sum_LitrosAplicados + $tractda['LitrosAplicados'];
														$sum_TiempoAplicacion   = sumahoras($sum_TiempoAplicacion,$tractda['TiempoAplicacion']);

													}
												} ?>
												<tr class="item-row linea_punteada">
													<td class="item-name"><strong>Totales</strong></td>

													<td class="item-name"><strong><?php if($xcounter!=0){echo Cantidades($sum_VelocidadProg/$xcounter, 1);}else{echo '0';} ?></strong></td>
													<td class="item-name"><strong><?php if($xcounter!=0){echo Cantidades($sum_VelocidadMin/$xcounter, 1);}else{echo '0';} ?></strong></td>
													<td class="item-name"><strong><?php if($xcounter!=0){echo Cantidades($sum_VelocidadMax/$xcounter, 1);}else{echo '0';} ?></strong></td>
													<td class="item-name"><strong><?php if($xcounter!=0){echo Cantidades($sum_VelocidadProm/$xcounter, 1);}else{echo '0';} ?></strong></td>

													<td class="item-name"><strong><?php if($xcounter!=0){echo Cantidades($sum_total_caudal/$xcounter, 2);}else{echo '0';} ?></strong></td>
													<td class="item-name"><strong><?php if($xcounter!=0){echo Cantidades($sum_correccion_caudal/$xcounter, 2).' %';}else{echo '0 %';} ?></strong></td>

													<td class="item-name"><strong><?php echo Cantidades($sum_LitrosAplicados, 2); ?></strong></td>
													<td class="item-name"><strong><?php echo $sum_TiempoAplicacion; ?></strong></td>

													<td></td>

												</tr>

												<?php
											}else{
												echo '<tr class="item-row linea_punteada"><td colspan="10">No hay Cuarteles Recorridos</td></tr>';
											} ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="clearfix"></div>
							<?php
							/********************************************************************/
							//Caudales
							echo '
							<script>
								google.charts.setOnLoadCallback(drawChart_caudales_'.$trac['idTelemetria'].');

								function drawChart_caudales_'.$trac['idTelemetria'].'() {
									var data_caud_'.$trac['idTelemetria'].' = new google.visualization.DataTable();
									data_caud_'.$trac['idTelemetria'].'.addColumn("string", "Hora");
									data_caud_'.$trac['idTelemetria'].'.addColumn("number", "Caudal Derecho");
									data_caud_'.$trac['idTelemetria'].'.addColumn("number", "Caudal Izquierdo");

									data_caud_'.$trac['idTelemetria'].'.addRows(['.$arrMedTractores[$trac['idTelemetria']]['caudales'].']);

									var options1_'.$trac['idTelemetria'].' = {
										title: "Grafico Caudal / Homogeneidad de '.$trac['VehiculoNombre'].'",
										hAxis: {title: "Hora"},
										vAxis: { title: "Litros * Minutos" },
										width: $(window).width()*0.95,
										height: 300,
										curveType: "function",
										colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
									};
									var chart1_'.$trac['idTelemetria'].' = new google.visualization.LineChart(document.getElementById("chart_caudales_'.$trac['idTelemetria'].'"));
										chart1_'.$trac['idTelemetria'].'.draw(data_caud_'.$trac['idTelemetria'].', options1_'.$trac['idTelemetria'].');
								}
							</script>
							<div id="chart_caudales_'.$trac['idTelemetria'].'" style="height: 300px; width: 100%;"></div>';

							/********************************************************************/
							//Nivel Estanque
							echo '
							<script>
								google.charts.setOnLoadCallback(drawChart_niveles_'.$trac['idTelemetria'].');

								function drawChart_niveles_'.$trac['idTelemetria'].'() {
									var data_niveles_'.$trac['idTelemetria'].' = new google.visualization.DataTable();
									data_niveles_'.$trac['idTelemetria'].'.addColumn("string", "Hora");
									data_niveles_'.$trac['idTelemetria'].'.addColumn("number", "Nivel Estanque");

									data_niveles_'.$trac['idTelemetria'].'.addRows(['.$arrMedTractores[$trac['idTelemetria']]['niveles'].']);

									var options2_'.$trac['idTelemetria'].' = {
										title: "Grafico Nivel Estanque de '.$trac['VehiculoNombre'].'",
										hAxis: {title: "Hora"},
										vAxis: { title: "% de llenado" },
										width: $(window).width()*0.95,
										height: 300,
										curveType: "function",
										colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
									};
									var chart2_'.$trac['idTelemetria'].' = new google.visualization.LineChart(document.getElementById("chart_niveles_'.$trac['idTelemetria'].'"));
										chart2_'.$trac['idTelemetria'].'.draw(data_niveles_'.$trac['idTelemetria'].', options2_'.$trac['idTelemetria'].');
								}
							</script>
							<div id="chart_niveles_'.$trac['idTelemetria'].'" style="height: 300px; width: 100%;"></div>';

							/********************************************************************/
							//Velocidades
							echo '
							<script>
								google.charts.setOnLoadCallback(drawChart_velocidades_'.$trac['idTelemetria'].');

								function drawChart_velocidades_'.$trac['idTelemetria'].'() {
									var data_vel_'.$trac['idTelemetria'].' = new google.visualization.DataTable();
									data_vel_'.$trac['idTelemetria'].'.addColumn("string", "Hora");
									data_vel_'.$trac['idTelemetria'].'.addColumn("number", "Velocidad");

									data_vel_'.$trac['idTelemetria'].'.addRows(['.$arrMedTractores[$trac['idTelemetria']]['velocidades'].']);

									var options3_'.$trac['idTelemetria'].' = {
										title: "Grafico Velocidades de '.$trac['VehiculoNombre'].'",
										hAxis: {title: "Hora"},
										vAxis: { title: "Km * hr" },
										width: $(window).width()*0.95,
										height: 300,
										curveType: "function",
										colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
									};
									var chart3_'.$trac['idTelemetria'].' = new google.visualization.LineChart(document.getElementById("chart_velocidades_'.$trac['idTelemetria'].'"));
										chart3_'.$trac['idTelemetria'].'.draw(data_vel_'.$trac['idTelemetria'].', options3_'.$trac['idTelemetria'].');
								}
							</script>
							<div id="chart_velocidades_'.$trac['idTelemetria'].'" style="height: 300px; width: 100%;"></div>';

							?>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
								<?php
								$Alert_Text = '<a href="view_solicitud_aplicacion_finalizada_view_mapa.php?idTelemetria='.simpleEncode($trac['idTelemetria'], fecha_actual()).'&idSolicitud='.$_GET['view'].'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" class="btn btn-primary pull-right margin_form_btn"><i class="fa fa-map-o" aria-hidden="true"></i> Ver mapas</a>';
								alert_post_data(4,2,2,0, $Alert_Text);
								?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

	</div>

<?php }else{ ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
		<?php
			$Alert_Text = 'La solicitud no existe';
			alert_post_data(4,2,2,0, $Alert_Text);
		?>
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
