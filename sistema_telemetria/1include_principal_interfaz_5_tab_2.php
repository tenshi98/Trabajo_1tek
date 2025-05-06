<?php
$idTipoUsuario  = $_SESSION['usuario']['zona']['idTipoUsuario'];
$idSistema      = $_SESSION['usuario']['zona']['idSistema'];
$idUsuario      = $_SESSION['usuario']['zona']['idUsuario'];
if(isset($_SESSION['usuario']['zona']['id_Geo'])&&$_SESSION['usuario']['zona']['id_Geo']!=''){
	$id_Geo = $_SESSION['usuario']['zona']['id_Geo'];
}else{
	$id_Geo = 1;//seguimiento activo
}

/************************************************************************/
//Variable
$SIS_where = 'telemetria_listado.idEstado = 1';//solo equipos activos
//solo los equipos que tengan el seguimiento activado
$SIS_where.= ' AND telemetria_listado.id_Geo = '.$id_Geo;
//Filtro el sistema al cual pertenece
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
	$SIS_where .= ' AND telemetria_listado.idSistema = '.$idSistema;
}
//Verifico el tipo de usuario que esta ingresando y el id
$SIS_join = '';
if(isset($idTipoUsuario)&&$idTipoUsuario!=1&&isset($idUsuario)&&$idUsuario!=0){
	$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria';
	$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
}
//filtro la zona
if(isset($idZona)&&$idZona!=''&&$idZona!=9999){
	$SIS_where .= ' AND telemetria_listado.idZona = '.$idZona;
}

/*******************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.cantSensores,
telemetria_listado.Nombre,
telemetria_listado.Identificador';
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

/***************************************/
//Variables
$timeback      = '01:00:00';

//se obtene los datos
$h_inicio    = restahoras($timeback,hora_actual());
$f_inicio    = fecha_actual();
$h_termino   = hora_actual();
$f_termino   = fecha_actual();

//Se calcula lapso de tiempo condicionando dias
if(hora_actual()<$timeback){
	$f_inicio = restarDias(fecha_actual(),1);
}

/*****************************************/
//datos extras
$aa  = '';
$aa .= ',FechaSistema';
$aa .= ',HoraSistema';
//$aa .= ',GeoLatitud';
//$aa .= ',GeoLongitud';
$aa .= ',GeoVelocidad';
//se recorre deacuerdo a la cantidad de sensores
for ($i = 1; $i <= $arrEquipo[0]['cantSensores']; $i++) {
	$aa .= ',Sensor_'.$i;
}
/*****************************************/
//Insumos
$SIS_query = 'idTabla'.$aa;
$SIS_join  = '';
$SIS_where = '(TimeStamp BETWEEN "'.$f_inicio.' '.$h_inicio .'" AND "'.$f_termino.' '.$h_termino.'")';
$SIS_order = 'FechaSistema ASC, HoraSistema ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$arrEquipo[0]['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

?>

<style>
.float_table table{margin-right: auto !important;margin-left: auto !important;float: none !important;}
#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
</style>

<div role="tabpanel" class="tab-pane fade" id="online">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Equipos</h5>
				<ul class="nav nav-tabs pull-right">
					<?php
					$xcounter = 1;
					foreach($arrEquipo as $cli) {
						if($xcounter==1){$xactive = 'active';}else{$xactive = '';}
						if($xcounter==7){ ?> <li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu"> <?php } ?>
						<li class="<?php echo $xactive; ?>"><a href="" onClick="chngEquipo(<?php echo $cli['idTelemetria']; ?>, '<?php echo $cli['Nombre']; ?>', '<?php echo $cli['Identificador']; ?>', <?php echo $cli['cantSensores']; ?>)"  data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $cli['Nombre']; ?></a></li>
						<?php $xcounter++;
					}
					if($xcounter>7){ ?></ul></li><?php } ?>
				</ul>
			</header>

			<div class="tab-content">

				<div id="loading"></div>

				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table', 'gauge']});</script>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
					<h5 class="panel-title" id="txtEquipo"><?php echo "Equipo: <strong>".$arrEquipo[0]['Nombre']." - ".$arrEquipo[0]['Identificador']."</strong>"; ?></h5>
					<h5 class="panel-title" id="txtDatade"><?php echo "Datos desde <strong>".fecha_estandar($f_inicio)."-".$h_inicio ."</strong> a <strong>".fecha_estandar($f_termino)."-".$h_termino."</strong>"; ?></h5>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><h5 class="text-center"><strong>Velocidad Tractor</strong></h5>      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"             id="chart_velocidades" style="height: 200px;"></div></div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><h5 class="text-center"><strong>Vaciado Estanque</strong></h5>       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"             id="chart_niveles" style="height: 200px;"></div></div>
				<div class="clearfix"></div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Flujos Caudales</strong></h5>        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"             id="chart_caudales_flujos" style="height: 200px;"></div></div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Caudales Promedios</strong></h5>     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"             id="chart_caudales" style="height: 200px;"></div></div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><h5 class="text-center"><strong>Dispersión de Flujos</strong></h5>   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float_table" id="chart_gauge" style="height: 200px;"></div></div>

				<div id="update_content_graphics"></div>

				<?php
				/********************************************************************/
				//Velocidades
				echo '
				<script>
					/* ************************************************************************** */
					//Variables globales
					let idEquipoActual              = '.$arrEquipo[0]['idTelemetria'].';
					let NombreEquipoActual          = "'.$arrEquipo[0]['Nombre'].'";
					let IdentificadorEquipoActual   = "'.$arrEquipo[0]['Identificador'].'";
					let idSensoresActual            = '.$arrEquipo[0]['cantSensores'].';
					let Counter_x1                  = 0;
					let correccion_x                = 0;

					let chart_vel                   = "";
					let chart_tanque                = "";
					let chart_caud_flu              = "";
					let chart_caud                  = "";
					let chart_gauge                 = "";

					let data_vel                    = "";
					let data_tanque                 = "";
					let data_caud_flu               = "";
					let data_caud                   = "";
					let data_gauge                  = "";

					let options_vel                 = "";
					let options_tanque              = "";
					let options_caud_flu            = "";
					let options_caud                = "";
					let options_gauge               = "";

					//carga de los graficos
					google.charts.setOnLoadCallback(Chart_velocidades);
					google.charts.setOnLoadCallback(Chart_estanque);
					google.charts.setOnLoadCallback(Chart_caudales_flujos);
					google.charts.setOnLoadCallback(Chart_caudales);
					google.charts.setOnLoadCallback(Chart_correccion);

					//oculto el loader
					document.getElementById("loading").style.display = "none";

					//refresco de los datos
					updtGraficos('.$x_seg.');
					/* ************************************************************************** */
					function updtGraficos(time) {
						setInterval(function(){updtGraficosTimer()},(time / 2));
					}
					/* ************************************************************************** */

					function updtGraficosTimer() {

						switch(Counter_x1) {
							//Ejecutar formulario con el recorrido y la ruta
							case 1:
								$("#update_content_graphics").load("principal_update_graphics_1.php?idEquipoActual=" + idEquipoActual + "&idSensoresActual="+idSensoresActual);
								break;
							//se dibujan los iconos
							case 2:
								actualiza_graficos(data_vel_x, data_tanque_x, data_caud_flu_x, data_caud_x);
								correccion_x = data_correccion_x;
								update_correccion();
								break;
						}
						Counter_x1++;
						if(Counter_x1==3){Counter_x1=1}
					}

					/* ************************************************************************** */
					function chngEquipo(idEquipo, Nombre,Identificador, cantSensores) {

						//guardo las nuevas variables
						idEquipoActual   = idEquipo;
						idSensoresActual = cantSensores;

						//Pido actualizacion
						$("#update_content_graphics").load("principal_update_graphics_1.php?idEquipoActual=" + idEquipoActual + "&idSensoresActual="+idSensoresActual);

						//se esperan 3 segundos
						setTimeout(
							function(){
								actualiza_graficos(data_vel_x, data_tanque_x, data_caud_flu_x, data_caud_x);
								correccion_x = data_correccion_x;
								update_correccion();

								//actualizo la cabecera
								document.getElementById("txtEquipo").innerHTML="Equipo: <strong>"+Nombre+" - "+Identificador+"</strong>";

								//oculto el loader
								document.getElementById("loading").style.display = "none";
							}
						, 3000);

					}
					/* ************************************************************************** */
					//Graficos	al cargar datos
					function actualiza_graficos(data_1, data_2, data_3, data_4) {
						//actualizan los datos de los graficos
						draw_velocidades(data_1);
						draw_estanque(data_2);
						draw_caudales_flujos(data_3);
						draw_caudales(data_4);
						update_correccion();

						//actualizo la hora de actualizacion
						document.getElementById("txtDatade").innerHTML=DatosRefresco;
					}

					/* ************************************************************************** */
					//Graficos	al cargar datos
					function Chart_velocidades() {';
						//Velocidades
						echo 'var data_vel_rows = [';
						//recorro los resultados
						foreach ($arrMediciones as $med) {
							if(isset($med['GeoVelocidad'])&&$med['GeoVelocidad']>0){
								if(isset($med['Sensor_1'])&&$med['Sensor_1']>0&&isset($med['Sensor_2'])&&$med['Sensor_2']>0){
									echo '["'.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['GeoVelocidad']).'],';
								}
							}
						}
						echo '];
						//se llama funcion de dibujo
						draw_velocidades(data_vel_rows);
					}
					function Chart_estanque() {';
						//Vaciado del estanque
						echo 'var data_tanque_rows = [';
						//recorro los resultados
						foreach ($arrMediciones as $med) {
							if(isset($med['Sensor_3'])&&$med['Sensor_3']>0&&$med['Sensor_3']<99900){
								if(isset($med['Sensor_1'])&&$med['Sensor_1']>0&&isset($med['Sensor_2'])&&$med['Sensor_2']>0){
									echo '["'.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['Sensor_3']).'],';
								}
							}
						}
						echo '];
						//se llama funcion de dibujo
						draw_estanque(data_tanque_rows);
					}
					function Chart_caudales_flujos() {';
						//Vaciado del estanque
						echo 'var data_caud_flu_rows = [';
						//recorro los resultados
						foreach ($arrMediciones as $med) {
							if(isset($med['Sensor_1'])&&$med['Sensor_1']>0&&isset($med['Sensor_2'])&&$med['Sensor_2']>0&&$med['Sensor_1']<99900&&$med['Sensor_2']<99900){
								echo '["'.$med['HoraSistema'].'", '.Cantidades_decimales_justos($med['Sensor_1']).', '.Cantidades_decimales_justos($med['Sensor_2']).'],';
							}
						}
						echo '];
						//se llama funcion de dibujo
						draw_caudales_flujos(data_caud_flu_rows);
					}
					function Chart_caudales() {';
						//variables
						$total_derecho    = 0;
						$total_izquierdo  = 0;
						$cuenta_derecho   = 0;
						$cuenta_izquierdo = 0;
						//recorro los resultados
						foreach ($arrMediciones as $med) {
							//solo si el ramal derecho esta funcionando
							if(isset($med['Sensor_1'])&&$med['Sensor_1']>=1){
								$total_derecho   = $total_derecho + $med['Sensor_1'];
								$cuenta_derecho++;
							}
							//solo si el ramal izquierdo esta funcionando
							if(isset($med['Sensor_2'])&&$med['Sensor_2']>=1){
								$total_izquierdo   = $total_izquierdo + $med['Sensor_2'];
								$cuenta_izquierdo++;
							}
						}
						//Calculo
						if($cuenta_derecho!=0){    $Prom_derecho   = $total_derecho/$cuenta_derecho;      }else{$Prom_derecho   = 0;}
						if($cuenta_izquierdo!=0){  $Prom_izquierdo = $total_izquierdo/$cuenta_izquierdo;  }else{$Prom_izquierdo = 0;}

						echo 'var data_caud_rows = [';
						echo '["Caudales",';
						echo Cantidades_decimales_justos($Prom_derecho).',';
						echo '"'.Cantidades($Prom_derecho, 2).'",';
						echo Cantidades_decimales_justos($Prom_izquierdo).',';
						echo '"'.Cantidades($Prom_izquierdo, 2).'",';
						echo '],';
						echo '];
						//se llama funcion de dibujo
						draw_caudales(data_caud_rows);

					}
					function Chart_correccion() {';
						if($Prom_derecho>$Prom_izquierdo){
							if($Prom_izquierdo!=0){ $correccion = (($Prom_derecho - $Prom_izquierdo)/$Prom_izquierdo)*100;}else{$correccion = 0;}
						}else{
							if($Prom_derecho!=0){   $correccion = (($Prom_izquierdo - $Prom_derecho)/$Prom_derecho)*100;}else{$correccion = 0;}
						}

						echo 'var data_correccion_rows = '.str_replace(",", ".",Cantidades($correccion, 2)).';
						//se llama funcion de dibujo
						draw_correccion(data_correccion_rows);
					}

					/********************************************************************/
					//dibujado de los graficos
					//Velocidades
					function draw_velocidades(data) {
						//instanciacion
						data_vel = new google.visualization.DataTable();
						data_vel.addColumn("string", "Hora");
						data_vel.addColumn("number", "Velocidad");
						//datos
						data_vel.addRows(data);
						//opciones
						options_vel = {
							hAxis: {title: "Hora"},
							vAxis: { title: "Km * hr" },
							curveType: "function",
							colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"],
							legend: {position: "none"},
							hAxis: { textPosition: "none"}
						};
						//dibujo
						chart_vel = new google.visualization.LineChart(document.getElementById("chart_velocidades"));
						chart_vel.draw(data_vel, options_vel);
					}
					/********************************************************************/
					//Vaciado del estanque
					function draw_estanque(data) {
						data_tanque = new google.visualization.DataTable();
						data_tanque.addColumn("string", "Hora");
						data_tanque.addColumn("number", "Nivel Estanque");
						//datos
						data_tanque.addRows(data);
						//opciones
						options_tanque = {
							hAxis: {title: "Hora"},
							vAxis: { title: "% de llenado" },
							curveType: "function",
							colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"],
							legend: { position: "none"},
							hAxis: { textPosition: "none"}

						};
						//dibujo
						chart_tanque = new google.visualization.LineChart(document.getElementById("chart_niveles"));
						chart_tanque.draw(data_tanque, options_tanque);
					}
					/********************************************************************/
					//Vaciado del flujo de los caudales
					function draw_caudales_flujos(data) {

						data_caud_flu = new google.visualization.DataTable();
						data_caud_flu.addColumn("string", "Hora");
						data_caud_flu.addColumn("number", "Caudal Derecho");
						data_caud_flu.addColumn("number", "Caudal Izquierdo");

						//datos
						data_caud_flu.addRows(data);

						//opciones
						options_flu = {
							hAxis: {title: "Hora"},
							vAxis: { title: "Litros * Minutos" },
							curveType: "function",
							legend: { position: "none"},
							colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
						};
						chart_flu = new google.visualization.LineChart(document.getElementById("chart_caudales_flujos"));
						chart_flu.draw(data_caud_flu, options_flu);

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
							majorTicks: ["0","10","20","30","40","50", "60", "70", "80", "90", "100"],
							minorTicks: 5,
							min:0,
							max:100
						};
						//Formateo
						/*var formatCalibracion = new google.visualization.NumberFormat({
							suffix: \'%\',
							fractionDigits: 1
						});
						formatCalibracion.format(data_gauge, 1);*/
						//dibujo
						chart_gauge = new google.visualization.Gauge(document.getElementById("chart_gauge"));
						chart_gauge.draw(data_gauge, options_gauge);
					}
					function update_correccion() {
						data_gauge.setValue(0, 1, correccion_x);
						chart_gauge.draw(data_gauge, options_gauge);
					}
				</script>
				';

				?>

			</div>
		</div>
	</div>

</div>
