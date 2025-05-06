<?php
//Variables
$timeback      = '03:00:00';

//se obtene los datos
$h_inicio    = restahoras($timeback,hora_actual());
$f_inicio    = fecha_actual();
$h_termino   = hora_actual();
$f_termino   = fecha_actual();

//Se calcula lapso de tiempo condicionando dias
if(hora_actual()<$timeback){
	$f_inicio = restarDias(fecha_actual(),1);
}

//se verifica si se ingreso la hora, es un dato optativo
$z = " WHERE (TimeStamp BETWEEN '".$f_inicio." ".$h_inicio ."' AND '".$f_termino." ".$h_termino."')";

//numero sensores equipo
$N_Maximo_Sensores = 72;
$consql = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
    $consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
    $consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
    $consql .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
    $consql .= ',telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.Sensor_'.$i.' AS SensorValue_'.$i;
}
//Se traen todos los registros
$SIS_query = '
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado.cantSensores AS cantSensores,
telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.TimeStamp,
telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.FechaSistema,
telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.HoraSistema
'.$consql;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_grupo`    ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_nombre`   ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`   ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`   ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.idTelemetria';
$SIS_where = ' (TimeStamp BETWEEN "'.$f_inicio.' '.$h_inicio .'" AND "'.$f_termino.' '.$h_termino.'")';
$SIS_order = 'telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()).'.TimeStamp ASC';
$arrRutas = array();
$arrRutas = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.simpleDecode($_GET['idTelemetria'], fecha_actual()), $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRutas');

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages':['line','corechart']});</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5> Graficos de <?php echo simpleDecode($_GET['titulo'], fecha_actual()); ?></h5>

		</header>
		<div class="table-responsive">
			<script type="text/javascript">
				google.charts.setOnLoadCallback(drawChart);

				function drawChart() {

					var chartDiv = document.getElementById('chart_div');

					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Fecha - Hora');
					data.addColumn('number', "Temperatura");
					data.addColumn('number', "Humedad");
					data.addRows([
						<?php foreach ($arrRutas as $fac) {
							//numero sensores equipo
							$N_Maximo_Sensores = $fac['cantSensores'];
							$Temperatura       = 0;
							$Temperatura_N     = 0;
							$Humedad           = 0;
							$Humedad_N         = 0;

							//recorro los sensores
							for ($x = 1; $x <= $N_Maximo_Sensores; $x++) {
								if($fac['SensoresGrupo_'.$x]==simpleDecode($_GET['idGrupo'], fecha_actual())){
									//si sensor esta activo
									if(isset($fac['SensoresActivo_'.$x])&&$fac['SensoresActivo_'.$x]==1){
										//Que el valor medido sea distinto de 99900
										if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
											//Si es humedad
											if($fac['SensoresUniMed_'.$x]==2){
												$Humedad = $Humedad + $fac['SensorValue_'.$x];
												$Humedad_N++;
											}
											//Si es temperatura
											if($fac['SensoresUniMed_'.$x]==3){
												$Temperatura     = $Temperatura + $fac['SensorValue_'.$x];
												$Temperatura_N++;
											}
										}
									}
								}
							}

							//Si es temperatura
							if($Temperatura_N!=0){
								$New_Temperatura     = $Temperatura/$Temperatura_N;
							}else{
								$New_Temperatura     = 0;
							}
							//Si es humedad
							if($Humedad_N!=0){      $New_Humedad     = $Humedad/$Humedad_N;         }else{$New_Humedad = 0;}

							//Se genera la cadena
							if($New_Temperatura!=0 OR $New_Humedad!=0){
								$chain  = "'".Fecha_estandar($fac['FechaSistema'])." - ".Hora_estandar($fac['HoraSistema'])."'";
								$chain .= ", ".$New_Temperatura.", ".$New_Humedad;
								//se imprime dato
								echo '['.$chain.'],';
							}
						}  ?>
					]);

					var materialOptions = {
						chart: {
							title: 'Informe Sensores'
						},
						series: {
							// Gives each series an axis name that matches the Y-axis below.
							0: {axis: 'Temperatura'},
							1: {axis: 'Humedad'}
						},
						axes: {
							// Adds labels to each axis; they don't have to match the axis names.
							y: {
								Temps: {label: 'Temperatura (Celsius)'},
								Daylight: {label: 'Humedad (Porcentaje)'}
							}
						}
					};

					function drawMaterialChart() {
						var materialChart = new google.charts.Line(chartDiv);
						materialChart.draw(data, materialOptions);
					}

					drawMaterialChart();

				}

			</script>
			<div id='chart_div' style='width: 95%; height: 500px;'></div>

		</div>
	</div>
</div>