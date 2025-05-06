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
/*                                          Modulo de identificacion del documento                                                */
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
//Cargamos la ubicacion original
$original = "view_crossenergy_estado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$X_Puntero;
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
//Grupo Sensores
$idGrupoVmonofasico      = 87;
$idGrupoVTrifasico       = 106;
$idGrupoPotencia         = 99;
$idGrupoConsumoMesHabil  = 99;
$idGrupoConsumoMesCurso  = 99;

//Para el mes Habil
$Habil_FechaInicio    = restarDias(fecha_actual(),30);
$Habil_HoraInicio     = hora_actual();
$Habil_FechaTermino   = fecha_actual();
$Habil_HoraTermino    = hora_actual();

//Para el mes en curso
$Curso_FechaInicio    = ano_actual().'-'.mes_actual().'-01';
$Curso_HoraInicio     = hora_actual();
$Curso_FechaTermino   = fecha_actual();
$Curso_HoraTermino    = hora_actual();

//Para el grafico trifasico
$Grafico_FechaInicio    = fecha_actual();
$Grafico_HoraInicio     = restahoras('00:30:00', hora_actual());
$Grafico_FechaTermino   = fecha_actual();
$Grafico_HoraTermino    = hora_actual();

//Para redirigir a los informes
$Informes_FechaInicio    = fecha_actual();
$Informes_HoraInicio     = restahoras('01:00:00', hora_actual());
$Informes_FechaTermino   = fecha_actual();
$Informes_HoraTermino    = hora_actual();

//Para redirigir a los informes
$Informes_2_FechaInicio    = restarDias(fecha_actual(),1);
$Informes_2_HoraInicio     = hora_actual();
$Informes_2_FechaTermino   = fecha_actual();
$Informes_2_HoraTermino    = hora_actual();

//Para Demanda
$Demanda_FechaInicio    = ano_actual().'-'.mes_actual().'-01';
$Demanda_HoraInicio     = hora_actual();
$Demanda_FechaTermino   = fecha_actual();
$Demanda_HoraTermino    = hora_actual();

//numero sensores equipo
$N_Maximo_Sensores = 20;
$subquery_1 = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores';
$subquery_2 = 'idTabla';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery_1 .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$subquery_2 .= ',SUM(Sensor_'.$i.') AS Med_'.$i;
}

$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`       ON telemetria_listado_sensores_grupo.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';

//Obtengo los datos
$rowData            = db_select_data (false, $subquery_1, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria ='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');
$rowConsumoMesHabil = db_select_data (false, $subquery_2, 'telemetria_listado_crossenergy_dia', '', 'idTelemetria='.$X_Puntero.' AND (TimeStamp BETWEEN "'.$Habil_FechaInicio.' '.$Habil_HoraInicio .'" AND "'.$Habil_FechaTermino.' '.$Habil_HoraTermino.'")', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowConsumoMesHabil');
$rowConsumoMesCurso = db_select_data (false, $subquery_2, 'telemetria_listado_crossenergy_dia', '', 'idTelemetria='.$X_Puntero.' AND (TimeStamp BETWEEN "'.$Curso_FechaInicio.' '.$Curso_HoraInicio .'" AND "'.$Curso_FechaTermino.' '.$Curso_HoraTermino.'")', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowConsumoMesCurso');
$n_permisos         = db_select_data (false, 'idOpcionesGen_6', 'core_sistemas','', 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

$SIS_query = 'Nombre,CrossEnergy_PeriodoInicio, CrossEnergy_PeriodoTermino, CrossEnergy_HorarioInicio, CrossEnergy_HorarioTermino';
$SIS_join  = '';
$SIS_where = 'idSistema ='.$_SESSION['usuario']['basic_data']['idSistema'];
$rowSistema = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

//Temporales
$TempValue_1 = 0;
$TempValue_2 = 0;
$TempValue_3 = 0;
$TempValue_4 = 0;
$TempValue_5 = 0;
$TempCount_1 = 0;
$TempCount_2 = 0;
$TempCount_3 = 0;
$TempCount_4 = 0;
$TempCount_5 = 0;
$Subquery    = '';
$CountSub    = 1;
$Subquery_2  = '';
$arrSensores = array();
//recorro los sensores
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	//Si el sensor esta activo
	if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
		//Si pertenece al grupo
		if($rowData['SensoresGrupo_'.$i]==$idGrupoVmonofasico){
			$TempValue_1 = $TempValue_1 + $rowData['SensoresMedActual_'.$i];
			$TempCount_1++;
		}
		if($rowData['SensoresGrupo_'.$i]==$idGrupoVTrifasico){
			$TempValue_2 = $TempValue_2 + $rowData['SensoresMedActual_'.$i];
			$TempCount_2++;
		}
		if($rowData['SensoresGrupo_'.$i]==$idGrupoPotencia){
			$TempValue_3 = $TempValue_3 + $rowData['SensoresMedActual_'.$i];
			$TempCount_3++;
		}
		if($rowData['SensoresGrupo_'.$i]==$idGrupoConsumoMesHabil){
			$TempValue_4 = $TempValue_4 + $rowConsumoMesHabil['Med_'.$i];
			$TempCount_4++;
		}
		if($rowData['SensoresGrupo_'.$i]==$idGrupoConsumoMesCurso){
			$TempValue_5 = $TempValue_5 + $rowConsumoMesCurso['Med_'.$i];
			$TempCount_5++;
		}
		//para la subconsulta
		if($rowData['SensoresGrupo_'.$i]==$idGrupoVmonofasico){
			$Subquery .= ',Sensor_'.$i.' AS SSens_'.$CountSub;
			$arrSensores[$CountSub]['Nombre'] = $rowData['SensoresNombre_'.$i];
			$CountSub++;
		}
		//para la subconsulta
		if($rowData['SensoresGrupo_'.$i]==$idGrupoPotencia){
			//si viene vacio
			if(isset($Subquery_2)&&$Subquery_2!=''){
				$Subquery_2 .= ' + Sensor_'.$i;
			}else{
				$Subquery_2 .= ', SUM(Sensor_'.$i;
			}
		}
	}
}
//cierro subquery
$Subquery_2 .= ') AS Total';
//Se hace consulta de los graficos
//$arrGraficos = array();
//$arrGraficos = db_select_array (false, 'FechaSistema, HoraSistema'.$Subquery, 'telemetria_listado_crossenergy_hora', '', 'idTelemetria = '.$X_Puntero.' AND (FechaSistema BETWEEN "'.$rowSistema['CrossEnergy_PeriodoInicio'].'" AND "'.$rowSistema['CrossEnergy_PeriodoTermino'].'") AND HoraSistema > "'.$rowSistema['CrossEnergy_HorarioInicio'].'" AND HoraSistema < "'.$rowSistema['CrossEnergy_HorarioTermino'].'" GROUP BY TimeStamp', 'Total DESC LIMIT 52', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGraficos');
$arrGraficos  = array();
$arrGraficos  = db_select_array (false, 'HoraSistema'.$Subquery, 'telemetria_listado_tablarelacionada_'.$X_Puntero, '', '(TimeStamp BETWEEN "'.$Grafico_FechaInicio.' '.$Grafico_HoraInicio .'" AND "'.$Grafico_FechaTermino.' '.$Grafico_HoraTermino.'")', 'HoraSistema ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGraficos');
//Potencia Observada
$SIS_query    = 'COUNT(FechaSistema) AS Cuenta'.$Subquery_2;
$SIS_join     = '';
$SIS_where    = '(TimeStamp BETWEEN "'.$Grafico_FechaInicio.' '.$Grafico_HoraInicio .'" AND "'.$Grafico_FechaTermino.' '.$Grafico_HoraTermino.'")';
$rowPotencia  = db_select_data (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowPotencia');

//Ordenamiento de grafico
asort($arrGraficos);

//Temporales
$Subquery    = '';
$Subquery_2  = '';
//recorro los sensores
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	//Si el sensor esta activo
	if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){
		//para la subconsulta
		if($rowData['SensoresGrupo_'.$i]==$idGrupoPotencia){
			$Subquery .= ',Sensor_'.$i;
			//si viene vacio
			if(isset($Subquery_2)&&$Subquery_2!=''){
				$Subquery_2 .= ' + Sensor_'.$i;
			}else{
				$Subquery_2 .= ', SUM(Sensor_'.$i;
			}
		}
	}
}
//cierro subquery
$Subquery_2 .= ') AS Total';
//Se hace consulta de los graficos
$arrPotencia = array();
$arrPotencia = db_select_array (false, 'FechaSistema, HoraSistema'.$Subquery.$Subquery_2, 'telemetria_listado_crossenergy_hora', '', 'idTelemetria = '.$X_Puntero.' AND (FechaSistema BETWEEN "'.$rowSistema['CrossEnergy_PeriodoInicio'].'" AND "'.$rowSistema['CrossEnergy_PeriodoTermino'].'") AND HoraSistema > "'.$rowSistema['CrossEnergy_HorarioInicio'].'" AND HoraSistema < "'.$rowSistema['CrossEnergy_HorarioTermino'].'" GROUP BY TimeStamp', 'Total DESC LIMIT 52', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPotencia');

$arrDemanda = array();
$arrDemanda = db_select_array (false, 'FechaSistema, HoraSistema'.$Subquery.$Subquery_2, 'telemetria_listado_crossenergy_hora', '', 'idTelemetria = '.$X_Puntero.' AND (TimeStamp BETWEEN "'.$Demanda_FechaInicio.' '.$Demanda_HoraInicio .'" AND "'.$Demanda_FechaTermino.' '.$Demanda_HoraTermino.'")  GROUP BY TimeStamp', 'Total DESC LIMIT 2', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDemanda');

//Datos para los informes
$Informes_3_FechaInicio    = $rowSistema['CrossEnergy_PeriodoInicio'];
$Informes_3_HoraInicio     = $rowSistema['CrossEnergy_HorarioInicio'];
$Informes_3_FechaTermino   = $rowSistema['CrossEnergy_PeriodoTermino'];
$Informes_3_HoraTermino    = $rowSistema['CrossEnergy_HorarioTermino'];

$Informes_4_FechaInicio    = $Demanda_FechaInicio;
$Informes_4_HoraInicio     = $Demanda_HoraInicio;
$Informes_4_FechaTermino   = $Demanda_FechaTermino;
$Informes_4_HoraTermino    = $Demanda_HoraTermino;

//sumo para sacar promedios
$PotenciaSuma = 0;
$DemandaSuma  = 0;
$PotenciaProm = 0;
$DemandaProm  = 0;
foreach ($arrPotencia as $data) {
	$PotenciaSuma = $PotenciaSuma + $data['Total'];
}
foreach ($arrDemanda as $data) {
	$DemandaSuma = $DemandaSuma + $data['Total'];
}

//Saco promedios
if($TempCount_1!=0){  $Vmonofasico     = $TempValue_1/$TempCount_1;}else{$Vmonofasico     = 0;}
if($TempCount_2!=0){  $VTrifasico      = $TempValue_2/$TempCount_2;}else{$VTrifasico      = 0;}
if($TempCount_3!=0){  $Potencia        = $TempValue_3/$TempCount_3;}else{$Potencia        = 0;}
if($TempCount_4!=0){  $ConsumoMesHabil = $TempValue_4/$TempCount_4;}else{$ConsumoMesHabil = 0;}
if($TempCount_5!=0){  $ConsumoMesCurso = $TempValue_5/$TempCount_5;}else{$ConsumoMesCurso = 0;}
if($PotenciaSuma!=0){ $PotenciaProm    = $PotenciaSuma/52;         }else{$PotenciaProm    = 0;}
if($DemandaSuma!=0){  $DemandaProm     = $DemandaSuma/2;           }else{$DemandaProm     = 0;}
//potencia observada
if(isset($rowPotencia['Total'])&&$rowPotencia['Total']!=''){$PotenciaObs = $rowPotencia['Total']/$rowPotencia['Cuenta'];}else{$PotenciaObs = 0;}

if(isset($n_permisos['idOpcionesGen_6'])&&$n_permisos['idOpcionesGen_6']!=0){
	$x_seg = $n_permisos['idOpcionesGen_6'] * 1000;
}else{
	$x_seg = 300000;//5 minutos
}
$x_seg = 300000;//5 minutos


/****************************************************************/
//Variables
$Temp_1   = '';
$arrData  = array();

//se arman datos
//Si existen
if(isset($arrGraficos)&&$arrGraficos!=false && !empty($arrGraficos) && $arrGraficos!=''){
	//recorro
	foreach ($arrGraficos as $data) {

		//Variables
		$Temp_1 .= "'".$data['HoraSistema']."',";
		//recorro
		for ($x = 1; $x <= $CountSub; $x++) {
			//verifico si existe
			if(isset($arrData[$x]['Value'])&&$arrData[$x]['Value']!=''){
				$arrData[$x]['Value'] .= ", ".$data['SSens_'.$x];
			//si no lo crea
			}else{
				$arrData[$x]['Value'] = $data['SSens_'.$x];
			}
			//Nombre
			$arrData[$x]['Name'] = "'".$arrSensores[$x]['Nombre']."'";

		}
	}

	//variables
	$Graphics_xData       = 'var xData = [';
	$Graphics_yData       = 'var yData = [';
	$Graphics_names       = 'var names = [';
	$Graphics_types       = 'var types = [';
	$Graphics_texts       = 'var texts = [';
	$Graphics_lineColors  = 'var lineColors = [';
	$Graphics_lineDash    = 'var lineDash = [';
	$Graphics_lineWidth   = 'var lineWidth = [';
	//Se crean los datos
	for ($x = 1; $x <= $CountSub; $x++) {
		if(isset($arrData[$x]['Value'])&&$arrData[$x]['Value']!=''){
			//las fechas
			$Graphics_xData      .='['.$Temp_1.'],';
			//los valores
			$Graphics_yData      .='['.$arrData[$x]['Value'].'],';
			//los nombres
			$Graphics_names      .= $arrData[$x]['Name'].',';
			//los tipos
			$Graphics_types      .= "'lines',";
			//si lleva texto en las burbujas
			$Graphics_texts      .= "[],";
			//los colores de linea
			$Graphics_lineColors .= "'',";
			//los tipos de linea
			$Graphics_lineDash   .= "'',";
			//los anchos de la linea
			$Graphics_lineWidth  .= "'',";
		}
	}
	$Graphics_xData      .= '];';
	$Graphics_yData      .= '];';
	$Graphics_names      .= '];';
	$Graphics_types      .= '];';
	$Graphics_texts      .= '];';
	$Graphics_lineColors .= '];';
	$Graphics_lineDash   .= '];';
	$Graphics_lineWidth  .= '];';

?>

<script>
	window.setTimeout(function () {
	  window.location.reload();
	}, <?php echo $x_seg; ?>);
</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Estado del Equipo <?php echo $rowData['Nombre'].' (Hora Refresco: '.hora_actual().')'; ?></h5>
		</header>
        <div class="tab-content">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php
							//$Titulo = 'Potencia hora punta (Periodo: '.$Grafico_FechaInicio.' al '.$Grafico_FechaTermino.')';
							$Titulo = '';
							echo GraphLinear_1('graphLinear_1', $Titulo, 'Fecha', 'Voltaje', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
						?>
					</div>
				</div>

				<div class="row">

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Consumo mes actual</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($ConsumoMesCurso, 2).' kW/h'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_crossenergy_01.php?f_inicio='.$Curso_FechaInicio.'&f_termino='.$Curso_FechaTermino.'&h_inicio='.$Curso_HoraInicio.'&h_termino='.$Curso_HoraTermino.'&idTelemetria='.$X_Puntero.'&idGrupo='.$idGrupoConsumoMesCurso.'&idGrafico=1&submit_filter=Filtrar&inform_trans=Consumo mes actual&inform_tittle=Consumo kW/h.&inform_unimed=kW/h.'; ?>" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Consumo mes anterior</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($ConsumoMesHabil, 2).' kW/h'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_crossenergy_01.php?f_inicio='.$Habil_FechaInicio.'&f_termino='.$Habil_FechaTermino.'&h_inicio='.$Habil_HoraInicio.'&h_termino='.$Habil_HoraTermino.'&idTelemetria='.$X_Puntero.'&idGrupo='.$idGrupoConsumoMesHabil.'&idGrafico=1&submit_filter=Filtrar&inform_trans=Consumo últimos 30 días&inform_tittle=Consumo kW/h.&inform_unimed=kW/h.'; ?>" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

				</div>

				<div class="row">

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Maxima Demanda Suministrada</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($DemandaProm, 2).' kW'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_crossenergy_04.php?f_inicio='.$Informes_4_FechaInicio.'&f_termino='.$Informes_4_FechaTermino.'&h_inicio='.$Informes_4_HoraInicio.'&h_termino='.$Informes_4_HoraTermino.'&idTelemetria='.$X_Puntero.'&idGrupo='.$idGrupoPotencia.'&submit_filter=Filtrar'; ?>" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Potencia Hora Punta</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($PotenciaProm, 2).' kW'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_crossenergy_03.php?f_inicio='.$Informes_3_FechaInicio.'&f_termino='.$Informes_3_FechaTermino.'&h_inicio='.$Informes_3_HoraInicio.'&h_termino='.$Informes_3_HoraTermino.'&idTelemetria='.$X_Puntero.'&idGrupo='.$idGrupoPotencia.'&submit_filter=Filtrar'; ?>" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

				</div>

				<div class="row">

					<?php /* ?>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Voltaje Monofasico</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($Vmonofasico, 2).' V'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_sensores_19.php?f_inicio='.$Informes_FechaInicio.'&f_termino='.$Informes_FechaTermino.'&h_inicio='.$Informes_HoraInicio.'&h_termino='.$Informes_HoraTermino.'&idTelemetria='.$X_Puntero.'&idGrupo='.$idGrupoVmonofasico.'&idGrafico=1&submit_filter=Filtrar&inform_tittle=Voltaje monofásico&inform_unimed=Volt'; ?>" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>
					<?php */ ?>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Voltaje Trifasico</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($VTrifasico, 2).' V'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_sensores_19.php?f_inicio='.$Informes_FechaInicio.'&f_termino='.$Informes_FechaTermino.'&h_inicio='.$Informes_HoraInicio.'&h_termino='.$Informes_HoraTermino.'&idTelemetria='.$X_Puntero.'&idGrupo='.$idGrupoVTrifasico.'&idGrafico=1&submit_filter=Filtrar&inform_tittle=Voltaje trifásico&inform_unimed=Volt'; ?>" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Potencia observada</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($PotenciaObs, 2).' kW'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_crossenergy_02.php?f_inicio='.$Informes_2_FechaInicio.'&h_inicio='.$Informes_2_HoraInicio.'&f_termino='.$Informes_2_FechaTermino.'&h_termino='.$Informes_2_HoraTermino.'&idTelemetria='.$X_Puntero.'&idGrupo='.$idGrupoPotencia.'&idGrafico=1&submit_filter=Filtrar'; ?>" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

				</div>

			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php
//Si no hay datos
}else{
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
		alert_post_data(4,2,2,0, 'No existen datos');
	echo '</div>';
}

?>

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
