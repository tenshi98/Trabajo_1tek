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
$original = "principal_solicitud_finalizada.php";
$location = $original;
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
if(!empty($_GET['idSolicitud'])){
	// consulto los datos
	$SIS_query = '
	cross_solicitud_aplicacion_listado.NSolicitud,
	cross_solicitud_aplicacion_listado.idSolicitud,
	cross_solicitud_aplicacion_listado.Mojamiento,
	cross_predios_listado.Nombre AS PredioNombre';
	$SIS_join  = 'LEFT JOIN `cross_predios_listado` ON cross_predios_listado.idPredio = cross_solicitud_aplicacion_listado.idPredio';
	$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud ='.$_GET['idSolicitud'];
	$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
		WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD ) AS CuartelHectareas,
		(SELECT SUM(cross_predios_listado_zonas.Plantas)
		FROM `cross_solicitud_aplicacion_listado_cuarteles`
		LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
		WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD ) AS CuartelCantPlantas,
		(SELECT AVG(cross_predios_listado_zonas.DistanciaPlant)
		FROM `cross_solicitud_aplicacion_listado_cuarteles`
		LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
		WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD ) AS CuartelDistanciaPlant,
		AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm!=0,cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,0),0)) AS GeoVelocidadProm,
		SUM(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoDistance!=0,cross_solicitud_aplicacion_listado_tractores.GeoDistance,0),0)) AS GeoDistance,
		SUM(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Diferencia!=0,cross_solicitud_aplicacion_listado_tractores.Diferencia,0),0)) AS Litros,
		AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom,0),0)) AS Sensor_1_Prom,
		AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom,0),0)) AS Sensor_2_Prom';
		$SIS_join  = '
		LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
		LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles';
		$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud = '.$rowData['idSolicitud'].' GROUP BY cross_solicitud_aplicacion_listado.idSolicitud ORDER BY cross_solicitud_aplicacion_listado.idSolicitud DESC';
		$rowSolicitud = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowSolicitud');

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
		$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTractores');

		/*****************************************/
		//Variable para almacenar los recorridos
		//$rec_x           = '';
		$marker_loc      = '';
		$arrMedTractores = array();

		//Recorro las mediciones
		foreach ($arrTractores as $trac) {
			//Se crean variables vacias
			$arrMedTractores[$trac['idTelemetria']]['caudales']     = '';
			$arrMedTractores[$trac['idTelemetria']]['niveles']      = '';
			$arrMedTractores[$trac['idTelemetria']]['velocidades']  = '';
			//$arrMedTractores[$trac['idTelemetria']]['heatMapData']  = '';

			/***************************************/
			$subquery = '';
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
			$SIS_query = 'idTabla, idTelemetria'.$subquery;
			$SIS_join  = '';
			$SIS_where = 'idSolicitud = '.$rowData['idSolicitud'].' AND idZona!=0';
			$SIS_order = 'FechaSistema ASC, HoraSistema ASC';
			$arrMediciones = array();
			$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');

			//recorro los resultados
			foreach ($arrMediciones as $med) {
				$pres = 0;
				//if(isset($med['GeoLatitud'])&&$med['GeoLatitud']!=0&&isset($med['GeoLongitud'])&&$med['GeoLongitud']!=0&&($med['Sensor_1']>1 OR $med['Sensor_2']>1)){
				if(isset($med['GeoLatitud'])&&$med['GeoLatitud']!=0&&isset($med['GeoLongitud'])&&$med['GeoLongitud']!=0){
					$pres = $med['Sensor_1'] + $med['Sensor_2'];
					//$rec_x .= "{location: new google.maps.LatLng(".$med['GeoLatitud'].", ".$med['GeoLongitud']."), weight: ".$pres."},";
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
						$marker_loc .= ", ".$med['Sensor_1'];
						$marker_loc .= ", ".$med['Sensor_2'];
						//$marker_loc .= ", '".$explanation."'";
						//cambio de iconos
						//$marker_loc .= ", ".$med['idTelemetria'];
						/*if(($med['Sensor_1']+$med['Sensor_2'])<1){
							$marker_loc .= ", 0";
						}else{
							$marker_loc .= ", 1";
						}*/
					$marker_loc .= "], ";

					//$arrMedTractores[$trac['idTelemetria']]['heatMapData']  .= "{location: new google.maps.LatLng(".$med['GeoLatitud'].", ".$med['GeoLongitud']."), weight: ".$pres."},";
					//$arrMedTractores[$trac['idTelemetria']]['MarkerData']  .= $marker_loc;
					//Guardo los datos temporales
					$arrMedTractores[$trac['idTelemetria']]['caudales']     .= '["'.$med['FechaSistema'].' '.$med['HoraSistema'].'",'.Cantidades_decimales_justos($med['Sensor_1']).','.Cantidades_decimales_justos($med['Sensor_2']).'],';
					$arrMedTractores[$trac['idTelemetria']]['niveles']      .= '["'.$med['FechaSistema'].' '.$med['HoraSistema'].'",'.Cantidades_decimales_justos($med['Sensor_3']).',],';
					$arrMedTractores[$trac['idTelemetria']]['velocidades']  .= '["'.$med['FechaSistema'].' '.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['GeoVelocidad']).'],';

				}
			}
		}

		//Se traen las rutas
		$SIS_query = '
		cross_predios_listado_zonas.idZona,
		cross_predios_listado_zonas.Nombre,
		cross_predios_listado_zonas_ubicaciones.Latitud,
		cross_predios_listado_zonas_ubicaciones.Longitud';
		$SIS_join  = '
		LEFT JOIN `cross_predios_listado_zonas`               ON cross_predios_listado_zonas.idPredio             = cross_solicitud_aplicacion_listado.idPredio
		LEFT JOIN `cross_predios_listado_zonas_ubicaciones`   ON cross_predios_listado_zonas_ubicaciones.idZona   = cross_predios_listado_zonas.idZona';
		$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud ='.$rowData['idSolicitud'];
		$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
		$arrZonas = array();
		$arrZonas = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrZonas');

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
		$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud ='.$rowData['idSolicitud'];
		$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
		$arrTractoresData = array();
		$arrTractoresData = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTractoresData');


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
		.t_search_button {padding: 6px 12px !important;font-size: 14px !important;font-weight: 400 !important;line-height: 1 !important;color: #555 !important;text-align: center !important;background-color: #eee !important;border: 1px solid #ccc !important;border-left-color: rgb(204, 204, 204);border-left-style: solid;border-left-width: 1px;border-bottom-right-radius: 4px !important;border-top-right-radius: 4px !important;width: 50px !important;height: 34px !important;border-left: 0 !important;white-space: nowrap;}
		#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
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
				<style>
					.my_marker {color: white;background-color: black;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
					.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
				</style>
				<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
			<?php } ?>

			<?php
			//Variables
			$Cent_zonaLatitud   = $arrZonas[0]['Latitud'];
			$Cent_zonaLongitud  = $arrZonas[0]['Longitud'];

			?>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
				<script>
					<!--
						function soloNumerosNaturales_NSolicitud(evt){
							var charCode = (evt.which) ? evt.which : event.keyCode
							if (charCode > 31 && (charCode < 48 || charCode > 57)){
								//verifico si presiono el punto
								if (charCode == 46) {
									return true;
								//valor negativo
								}else if(charCode == 45){
									return true;
								}else{
									return false;
								}
							}else{
								return true;
							}
						}
					//-->
				</script>

				<div class="container">
					<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
						<div class="field">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="N° Solicitud" name="NSolicitud" id="NSolicitud" required="" onkeydown="return soloNumerosNaturales_NSolicitud(event)" value="<?php echo $rowData['NSolicitud']; ?>">
								<input type="hidden" name="idEstado" id="idEstado" value="3" required="">
								<span class="input-group-btn">
									<div class="btn-group" style="width: 140px;" >
										<button type="submit" class="btn btn-primary" name="submit_filter" value="Filtrar"><i class="fa fa-search" aria-hidden="true"></i></button>                
										<a rel="noopener noreferrer" href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($rowData['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary tooltip" style="padding-top: 7px;padding-bottom: 8px;"><i class="fa fa-list" aria-hidden="true"></i></a>
										<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_cross_checking_05.php?idSolicitud='.$rowData['idSolicitud'].'&submit_filter=Filtrar'; ?>" title="Resumen ejecutivo " class="btn btn-primary tooltip" style="padding-top: 7px;padding-bottom: 8px;"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</span>
							</div>
						</div>
					</form>
					<?php widget_validator(); ?>
				</div>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="box noborderbox">

					<div id="loading"></div>

					<header class="header">
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
											let map_1;
											var marker;
											var markersCam = [];

											async function initMap() {
												const { Map } = await google.maps.importLibrary("maps");

												var myLatlng = new google.maps.LatLng(<?php echo $Cent_zonaLatitud.','.$Cent_zonaLongitud; ?>);

												var myOptions = {
													zoom: 15,
													center: myLatlng,
													mapTypeId: google.maps.MapTypeId.SATELLITE
												};

												map_1 = new Map(document.getElementById("map_canvas_x1"), myOptions);

												//Ubicación de los distintos dispositivos
												var locations = [<?php echo $marker_loc; ?>];

												//se dibujan las zonas
												dibuja_zona();
												//Se llama a la ruta
												RutasRealizadas(map_1, locations);

											}


											/* ************************************************************************** */
											function dibuja_zona() {

												var polygons1 = [];
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

													polygons1[polygons1.length-1].setMap(map_1);
													';

													// The label that pops up when the mouse moves within each polygon.
													echo '
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

													}else {
														Swal.fire({icon: 'error',title: 'Oops...',text: 'Geocode was not successful for the following reason: ' + status});
													}
												});
											}
											/* ************************************************************************** */
											function RutasRealizadas(map, locations) {

												var color    = '';
												var color_1  = '#1E90FF'; //azul
												var color_2  = '#FFE200'; //amarillo
												var in_lat   = 0;
												var in_long  = 0;

												for(var i in locations){
													//toma desde la segunda medicion
													if(in_lat!=0 && in_long!=0){

														//posicion anterior y actual
														var pos1 = new google.maps.LatLng(in_lat, in_long);
														var pos2 = new google.maps.LatLng(locations[i][0], locations[i][1]);

														//verifico que este regando
														if(locations[i][2]!=0 || locations[i][3]!=0){
															color = color_1;
														}else{
															color = color_2;
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
													in_lat  = locations[i][0];
													in_long = locations[i][1];
												}
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
													<td colspan="2" style="text-align: center;">Caudales</td>
													<td colspan="2" style="text-align: center;">Aplicacion</td>
													<td colspan="1" style="text-align: center;" width="10"></td>
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
																		<a href="<?php echo 'view_solicitud_aplicacion_detenciones.php?view='.simpleEncode($rowData['idSolicitud'], fecha_actual()).'&idTelemetria='.simpleEncode($trac['idTelemetria'], fecha_actual()).'&idZona='.simpleEncode($tractda['idZona'], fecha_actual()); ?>" title="Ver Detenciones" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																		<a href="<?php echo 'view_solicitud_aplicacion_fuera_linea.php?view='.simpleEncode($rowData['idSolicitud'], fecha_actual()).'&idTelemetria='.simpleEncode($trac['idTelemetria'], fecha_actual()).'&idZona='.simpleEncode($tractda['idZona'], fecha_actual()); ?>" title="Ver Fuera de Linea" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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
									$Alert_Text = '<a onclick="topFunction()" href="principal_solicitud_finalizada_view_mapa.php?idTelemetria='.simpleEncode($trac['idTelemetria'], fecha_actual()).'&idSolicitud='.simpleEncode($_GET['idSolicitud'], fecha_actual()).'" class="iframe btn btn-primary pull-right margin_form_btn"><i class="fa fa-map-o" aria-hidden="true"></i> Ver mapas</a>';
									alert_post_data(4,2,2,0, $Alert_Text);
									?>
									<script>
									// When the user clicks on the button, scroll to the top of the document
									function topFunction() {
										var offsettop =  120;
										window.parent.postMessage({"setAnchor": offsettop}, "*");
									}
									</script>
								</div>

							</div>
						<?php } ?>
					</div>
				</div>
			</div>


			<script>
			//oculto el loader
			document.getElementById("loading").style.display = "none";

			</script>

		</div>

	<?php }else{ ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
			<?php
				$Alert_Text = 'La solicitud '.n_doc($_GET['NSolicitud'],7).' no existe';
				alert_post_data(4,2,2,0, $Alert_Text);
			?>
		</div>
	<?php } ?>

	<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>"  class="btn btn-danger pull-right" style="margin-top:20px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['submit_filter'])){
	//Se verifica si hay datos
	$ndata_1 = db_select_nrows (false, 'idSolicitud', 'cross_solicitud_aplicacion_listado', '', "NSolicitud = '".$_GET['NSolicitud']."' AND idEstado = '".$_GET['idEstado']."' AND idSistema ='".$_SESSION['usuario']['basic_data']['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'submit_filter');

	//si no hay datos
	if($ndata_1==0) {
		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">';
			$Alert_Text = 'La solicitud '.n_doc($_GET['NSolicitud'],7).' no existe';
			alert_post_data(4,2,2,0, $Alert_Text);
		echo '</div>';

		echo '
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="'.$original.'" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
		</div>';

	//si existe al menos un dato
	}elseif($ndata_1==1) {
		$rowData = db_select_data (false, 'idSolicitud', 'cross_solicitud_aplicacion_listado', '', "NSolicitud = '".$_GET['NSolicitud']."' AND idEstado = '".$_GET['idEstado']."' AND idSistema ='".$_SESSION['usuario']['basic_data']['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'submit_filter');
		//redirijo
		echo '<script type="text/javascript">
			window.location = "'.$location.'?idSolicitud='.$rowData['idSolicitud'].'"
		</script>';

	//si hay mas de un dato se listan
	}elseif($ndata_1>1) {
		//Variable de busqueda
		$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
		$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

		//Se aplican los filtros
		if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
		if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){$SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstado=".$_GET['idEstado'];}

		//Realizo una consulta para saber el total de elementos existentes
		$SIS_query = '
		cross_solicitud_aplicacion_listado.idSolicitud,
		cross_solicitud_aplicacion_listado.NSolicitud,
		cross_solicitud_aplicacion_listado.f_programacion,
		cross_solicitud_aplicacion_listado.f_ejecucion,
		cross_solicitud_aplicacion_listado.f_termino,
		cross_predios_listado.Nombre AS NombrePredio,
		core_cross_prioridad.Nombre AS Prioridad,
		sistema_variedades_categorias.Nombre AS Especie,
		variedades_listado.Nombre AS Variedad';
		$SIS_join  = '
		LEFT JOIN `cross_predios_listado`           ON cross_predios_listado.idPredio             = cross_solicitud_aplicacion_listado.idPredio
		LEFT JOIN `core_cross_prioridad`            ON core_cross_prioridad.idPrioridad           = cross_solicitud_aplicacion_listado.idPrioridad
		LEFT JOIN `sistema_variedades_categorias`   ON sistema_variedades_categorias.idCategoria  = cross_solicitud_aplicacion_listado.idCategoria
		LEFT JOIN `variedades_listado`              ON variedades_listado.idProducto              = cross_solicitud_aplicacion_listado.idProducto';
		$SIS_order = 0;
		$arrOTS = array();
		$arrOTS = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');

		?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Solicitudes de Aplicacion</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th width="100">#</th>
								<th width="120">Prioridad</th>
								<th width="140">F Solicitud</th>
								<th width="140">F Prog</th>
								<th width="140">F Cierre</th>
								<th>Predio</th>
								<th>Especie/Variedad</th>
								<th width="10">Acciones</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrOTS as $ot) { ?>
								<tr class="odd">
									<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
									<td><?php echo $ot['Prioridad']; ?></td>
									<td><?php echo Fecha_estandar($ot['f_programacion']); ?></td>
									<td><?php echo Fecha_estandar($ot['f_ejecucion']); ?></td>
									<td><?php echo Fecha_estandar($ot['f_termino']); ?></td>
									<td><?php echo $ot['NombrePredio']; ?></td>
									<td><?php if(isset($ot['Especie'])&&$ot['Especie']!=''){echo $ot['Especie'].' '.$ot['Variedad'];}else{echo 'Todas las Especies - Variedades';} ?></td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<a href="<?php echo $location.'?idSolicitud='.$ot['idSolicitud']; ?>" title="Ver Solicitud" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="pagrow">
					<?php
					//Se llama al paginador
					echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</div>
		</div>

		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
		</div>

	<?php } ?>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Filtro de Búsqueda</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($NSolicitud)){             $x1  = $NSolicitud;             }else{$x1  = '';}
					/*if(isset($idPredio)){               $x2  = $idPredio;               }else{$x2  = '';}
					if(isset($idZona)){                 $x3  = $idZona;                 }else{$x3  = '';}
					if(isset($idTemporada)){            $x4  = $idTemporada;            }else{$x4  = '';}
					if(isset($idEstadoFen)){            $x5  = $idEstadoFen;            }else{$x5  = '';}
					if(isset($idCategoria)){            $x6  = $idCategoria;            }else{$x6  = '';}
					if(isset($idProducto)){             $x7  = $idProducto;             }else{$x7  = '';}
					if(isset($f_programacion_desde)){   $x8  = $f_programacion_desde;   }else{$x8  = '';}
					if(isset($f_programacion_hasta)){   $x9  = $f_programacion_hasta;   }else{$x9  = '';}
					if(isset($f_ejecucion_desde)){      $x10 = $f_ejecucion_desde;      }else{$x10 = '';}
					if(isset($f_ejecucion_hasta)){      $x11 = $f_ejecucion_hasta;      }else{$x11 = '';}
					if(isset($f_termino_desde)){        $x12 = $f_termino_desde;        }else{$x12 = '';}
					if(isset($f_termino_hasta)){        $x13 = $f_termino_hasta;        }else{$x13 = '';}
					if(isset($idUsuario)){              $x14 = $idUsuario;              }else{$x14 = '';}
					if(isset($idEstado)){               $x15 = $idEstado;               }else{$x15 = '';}*/

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_number('N° Solicitud','NSolicitud', $x1, 2);
					/*$Form_Inputs->form_select_depend1('Predio','idPredio', $x2, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $x, 0,
											'Cuarteles','idZona', $x3, 1, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_select_filter('Temporada','idTemporada', $x4, 1, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
					$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x5, 1, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
					$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
											'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_date('Fecha Programada Desde','f_programacion_desde', $x8, 1);
					$Form_Inputs->form_date('Fecha Programada Hasta','f_programacion_hasta', $x9, 1);
					$Form_Inputs->form_date('Fecha Ejecutada Desde','f_ejecucion_desde', $x10, 1);
					$Form_Inputs->form_date('Fecha Ejecutada Hasta','f_ejecucion_hasta', $x11, 1);
					$Form_Inputs->form_date('Fecha Terminada Desde','f_termino_desde', $x12, 1);
					$Form_Inputs->form_date('Fecha Terminada Hasta','f_termino_hasta', $x13, 1);
					$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x14, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
					$Form_Inputs->form_select('Estado','idEstado', $x15, 1, 'idEstado', 'Nombre', 'core_estado_solicitud', 0, '', $dbConn);*/

					$Form_Inputs->form_input_hidden('idEstado', 3, 2);

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
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
