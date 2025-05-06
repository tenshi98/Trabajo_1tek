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
$original = "informe_telemetria_registro_sensores_21.php";
$location = $original;
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

//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema!="0000-00-00"';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	/****************************************************************/
	$SIS_query = '
	telemetria_listado.Nombre AS NombreEquipo,
	telemetria_listado.cantSensores';
	for ($i = 1; $i <= 72; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
	}
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria            = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria           = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria           = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria   = telemetria_listado.idTelemetria';
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	/**********************************************************************/
	//Se trae el dato del grupo
	$rowGrupo = db_select_data (false, 'Nombre', 'telemetria_listado_grupos', '', 'idGrupo='.$_GET['idGrupo'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowGrupo');

	/****************************************************************/
	//Variables
	$m_table_title  = '';
	$m_table        = '';
	$arrTableTemp   = array();
	$arrTable       = array();
	$graphData      = '';

	/****************************************************************/
	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		//Verifico la unidad de medida y si el sensor esta activo
		if(isset($rowEquipo['SensoresUniMed_'.$i],$rowEquipo['SensoresActivo_'.$i])&&($rowEquipo['SensoresUniMed_'.$i]==3 OR $rowEquipo['SensoresUniMed_'.$i]==12)&&$rowEquipo['SensoresActivo_'.$i]==1){
			//que el sensor pertenezca al grupo
			if($rowEquipo['SensoresGrupo_'.$i]==$_GET['idGrupo']){
				//para la consulta
				$consql .= ',Sensor_'.$i.' AS SensorValue_'.$i;
				//para la maquetacion
				if($rowEquipo['SensoresUniMed_'.$i]==12){
					$m_table_title   .= '<th>'.$rowGrupo['Nombre'].'</th>';
				}
				$arrTableTemp[$i] = 99999;//se resetea
			}
		}
	}
	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = 'FechaSistema, HoraSistema'.$consql;
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

	/****************************************************************/
	//variables
	$posit           = 0;
	$Ult_diaInicio   = '';
	$Ult_diaTermino  = '';
	$Ult_horaInicio  = '';
	$Ult_horaTermino = '';

	//se arman datos
	foreach ($arrEquipos as $fac) {
		//variable
		$table      = '';
		$table2     = '';
		$count      = 0;
		$GraphMed   = 0;
		$GraphCount = 0;
		$GraphColor = '';
		//recorro los sensores
		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			//Verifico la unidad de medida y si el sensor esta activo
			if(isset($rowEquipo['SensoresUniMed_'.$x],$rowEquipo['SensoresActivo_'.$x])&&($rowEquipo['SensoresUniMed_'.$x]==3 OR $rowEquipo['SensoresUniMed_'.$x]==12)&&$rowEquipo['SensoresActivo_'.$x]==1){
				//Que el valor medido sea distinto de 999
				if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
					//que el sensor pertenezca al grupo
					if($rowEquipo['SensoresGrupo_'.$x]==$_GET['idGrupo']){
						//verifico si hay cambios en el valor
						if($arrTableTemp[$x]!=$fac['SensorValue_'.$x]){
							//Temperatura
							if($rowEquipo['SensoresUniMed_'.$x]==3){
								$GraphMed = $GraphMed + $fac['SensorValue_'.$x];
								$GraphCount++;
							//Boleano
							}elseif($rowEquipo['SensoresUniMed_'.$x]==12){
								//guardo dato de la tabla
								switch ($fac['SensorValue_'.$x]) {
									case 0:
										$GraphColor = 'green';
										$table  .= '
										<td>
											<label class="label label-success">Cerrado</label>
											<div class="btn-group" style="width: 35px;" >
												<a href="informe_telemetria_registro_sensores_20_trazabilidad.php?f_inicio=STR_f_inicio&h_inicio=STR_h_inicio&f_termino=STR_f_termino&h_termino=STR_h_termino&idTelemetria='.$_GET['idTelemetria'].'&idGrupo='.$rowEquipo['SensoresGrupo_'.$x].'" title="Ver Trazabilidad" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
										</td>';
										break;
									case 1:
										$GraphColor = 'red';
										$table  .= '
										<td>
											<label class="label label-danger">Abierto</label>
											<div class="btn-group" style="width: 35px;" >
												<a href="informe_telemetria_registro_sensores_20_trazabilidad.php?f_inicio=STR_f_inicio&h_inicio=STR_h_inicio&f_termino=STR_f_termino&h_termino=STR_h_termino&idTelemetria='.$_GET['idTelemetria'].'&idGrupo='.$rowEquipo['SensoresGrupo_'.$x].'" title="Ver Trazabilidad" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
										</td>';
										break;
								}
								//guardo el valor para el proximo bucle
								$arrTableTemp[$x] = $fac['SensorValue_'.$x];
								//cuento
								$count++;
							}

						}else{
							//Temperatura
							if($rowEquipo['SensoresUniMed_'.$x]==3){
								$GraphMed = $GraphMed + $fac['SensorValue_'.$x];
								$GraphCount++;
							//Boleano
							}elseif($rowEquipo['SensoresUniMed_'.$x]==12){
								$table  .= '<td></td>';
								//guardo dato de la tabla
								switch ($fac['SensorValue_'.$x]) {
									case 0:
										$GraphColor = 'green';
										$table2  .= '
										<td>
											<label class="label label-success">Cerrado</label>
											<div class="btn-group" style="width: 35px;" >
												<a href="informe_telemetria_registro_sensores_20_trazabilidad.php?f_inicio=STR_f_inicio&h_inicio=STR_h_inicio&f_termino=STR_f_termino&h_termino=STR_h_termino&idTelemetria='.$_GET['idTelemetria'].'&idGrupo='.$rowEquipo['SensoresGrupo_'.$x].'" title="Ver Trazabilidad" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
										</td>';
										break;
									case 1:
										$GraphColor = 'red';
										$table2  .= '
										<td>
											<label class="label label-danger">Abierto</label>
											<div class="btn-group" style="width: 35px;" >
												<a href="informe_telemetria_registro_sensores_20_trazabilidad.php?f_inicio=STR_f_inicio&h_inicio=STR_h_inicio&f_termino=STR_f_termino&h_termino=STR_h_termino&idTelemetria='.$_GET['idTelemetria'].'&idGrupo='.$rowEquipo['SensoresGrupo_'.$x].'" title="Ver Trazabilidad" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
										</td>';
										break;
								}
								//guardo el valor para el proximo bucle
								$arrTableTemp[$x] = $fac['SensorValue_'.$x];
							}
						}
					}
				}
			}
		}
		//se crea la fila
		if($count!=0){
			//variables
			$anterior    = $posit - 1;
			//verifico si existe
			if(isset($arrTable[$anterior]['FechaHasta'], $arrTable[$anterior]['HoraHasta'])){
				$diaInicio   = $arrTable[$anterior]['FechaHasta'];
				$horaInicio  = $arrTable[$anterior]['HoraHasta'];
			}else{
				$diaInicio   = $fac['FechaSistema'];
				$horaInicio  = $fac['HoraSistema'];
			}

			$diaTermino  = $fac['FechaSistema'];
			$horaTermino = $fac['HoraSistema'];
			$HorasTrans  = horas_transcurridas($diaInicio, $diaTermino, $horaInicio, $horaTermino);

			$healthy   = array("STR_f_inicio", "STR_f_termino", "STR_h_inicio", "STR_h_termino");
			$yummy     = array($diaInicio, $diaTermino, $horaInicio, $horaTermino);
			$new_table = str_replace($healthy, $yummy, $table);

			//recorro
			$arrTable[$posit]['FechaDesde']  = $diaInicio;
			$arrTable[$posit]['FechaHasta']  = $diaTermino;
			$arrTable[$posit]['HoraDesde']   = $horaInicio;
			$arrTable[$posit]['HoraHasta']   = $horaTermino;
			$arrTable[$posit]['Duracion']    = $HorasTrans;
			$arrTable[$posit]['Temperatura'] = $GraphMed/$GraphCount;
			$arrTable[$posit]['Color']       = $GraphColor;
			$arrTable[$posit]['Contenido']   = $new_table;

			//cuento
			$posit++;

			//Guardo el ultimo registro
			$Ult_diaInicio   = $fac['FechaSistema'];
			$Ult_horaInicio  = $fac['HoraSistema'];

		}

		//Guardo el ultimo registro
		$Ult_diaTermino  = $fac['FechaSistema'];
		$Ult_horaTermino = $fac['HoraSistema'];

		$healthy    = array("STR_f_inicio", "STR_f_termino", "STR_h_inicio", "STR_h_termino");
		$yummy      = array($Ult_diaInicio, $Ult_diaTermino, $Ult_horaInicio, $Ult_horaTermino);
		$new_table2 = str_replace($healthy, $yummy, $table2);

	}

	//recorro los registros
	for ($x = 1; $x < $posit; $x++) {
		$m_table .= '<tr class="odd">';
			$m_table .= '<td>'.$x.'</td>';
			$m_table .= '<td>'.fecha_estandar($arrTable[$x]['FechaDesde']).' - '.$arrTable[$x]['HoraDesde'].'</td>';
			$m_table .= '<td>'.fecha_estandar($arrTable[$x]['FechaHasta']).' - '.$arrTable[$x]['HoraHasta'].'</td>';
			$m_table .= '<td>'.$arrTable[$x]['Duracion'].'</td>';
			$m_table .= '<td>'.$arrTable[$x]['Temperatura'].'</td>';
			$m_table .= $arrTable[$x]['Contenido'];
		$m_table .= '</tr>';
		//Grafico
		$point = $x;
		$graphData.= "{x: ".$point.", y: ".$arrTable[$x]['Temperatura'].", color: '".$arrTable[$x]['Color']."'},";

	}

	//Verifico si existe
	if(isset($Ult_diaInicio)&&$Ult_diaInicio!=''&&$Ult_diaInicio!='0000-00-00'){
		//Ultima linea
		$HorasTrans  = horas_transcurridas($Ult_diaInicio, $Ult_diaTermino, $Ult_horaInicio, $Ult_horaTermino);
		$m_table .= '<tr class="odd">';
			$m_table .= '<td>'.$x.'</td>';
			$m_table .= '<td>'.fecha_estandar($Ult_diaInicio).' - '.$Ult_horaInicio.'</td>';
			$m_table .= '<td>'.fecha_estandar($Ult_diaTermino).' - '.$Ult_horaTermino.'</td>';
			$m_table .= '<td>'.$HorasTrans.'</td>';
			$m_table .= '<td>'.($GraphMed/$GraphCount).'</td>';
			$m_table .= $new_table2;
		$m_table .= '</tr>';
		//Grafico
		$point = $x;
		$graphData.= "{x: ".$point.", y: ".($GraphMed/$GraphCount).", color: '".$GraphColor."'},";
	}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Apertura Puertas', $_SESSION['usuario']['basic_data']['RazonSocial'], 'Informe del equipo '.$rowEquipo['NombreEquipo']); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Informe equipo <?php echo $rowEquipo['NombreEquipo']; if(isset($rowGrupo['Nombre'])&&$rowGrupo['Nombre']!=''){echo ' del grupo '.$rowGrupo['Nombre'];} ?></h5>
			</header>
			<div class="table-responsive">
				<canvas id="myChart"></canvas>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
				<canvas id="myChart" width="10" height="6"></canvas>
				<script>

					const data   = [<?php echo $graphData; ?>];
					const colorsPer100 = ['green', 'orange', 'blue', 'red'];

					new Chart(document.getElementById("myChart"), {
						type: "scatter",
						plugins: [{
							beforeDraw: chart => {
								var ctx = chart.chart.ctx;
								var xAxis = chart.scales['x-axis-1'];
								var yAxis = chart.scales['y-axis-1'];
								chart.config.data.datasets[0].data.forEach((value, index) => {
									if (index > 0) {
										var valueFrom = data[index - 1];
										var xFrom = xAxis.getPixelForValue(valueFrom.x);
										var yFrom = yAxis.getPixelForValue(valueFrom.y);
										var xTo = xAxis.getPixelForValue(value.x);
										var yTo = yAxis.getPixelForValue(value.y);
										ctx.save();
										ctx.strokeStyle = value.color;
										ctx.lineWidth = 2;
										ctx.beginPath();
										ctx.moveTo(xFrom, yFrom);
										ctx.lineTo(xTo, yTo);
										ctx.stroke();
										ctx.restore();
									}
								});
							}
						}],
						data: {
							datasets: [{
								label: "<?php echo 'Graficos del equipo '.$rowEquipo['NombreEquipo']; if(isset($rowGrupo['Nombre'])&&$rowGrupo['Nombre']!=''){echo ' del grupo '.$rowGrupo['Nombre'];} ?>",
								data: data,
								borderColor: "black"
							}]
						},
						options: {
							animation: {
								duration: 0
							},
							legend: {
								display: true
							},
							scales: {
								xAxes: [{
									ticks: {
										stepSize: 1
									}
								}]
							}

						}
					});
				</script>
			
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
							<th width="20">Ref</th>
							<th>Inicio</th>
							<th>Termino</th>
							<th>Duracion</th>
							<th>Temperatura</th>
							<?php echo $m_table_title; ?>
						</tr>
						<?php echo $m_table; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<?php } ?>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//filtros
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=2";//1Tek C
}
//Se escribe el dato
$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
alert_post_data(2,1,1,0, $Alert_Text);

?>

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
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}
				if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group_apert('Grupos','idGrupo', 'idTelemetria', 'form1', 2, $dbConn);
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
require_once 'core/Web.Footer.Main.php';

?>
