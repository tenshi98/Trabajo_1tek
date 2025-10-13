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
//numero sensores equipo
$N_Maximo_Sensores = 20;
$subquery_1 = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores,
telemetria_listado.FechaInsGen,
telemetria_listado.SensorActivacionID,
telemetria_listado.idGrupoDespliegue,
telemetria_listado.idGrupoVmonofasico,
telemetria_listado.idGrupoVTrifasico,
telemetria_listado.idGrupoPotencia,
telemetria_listado.idGrupoEstanque';

for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery_1 .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery_1 .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`     ON telemetria_listado_sensores_nombre.idTelemetria     = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`      ON telemetria_listado_sensores_grupo.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual` ON telemetria_listado_sensores_med_actual.idTelemetria = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`     ON telemetria_listado_sensores_activo.idTelemetria     = telemetria_listado.idTelemetria';
//Obtengo los datos
$rowData  = db_select_data (false, $subquery_1, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria ='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**************************************************************/
//Grupo Sensores
if(isset($rowData['idGrupoVmonofasico'])&&$rowData['idGrupoVmonofasico']!=''&&$rowData['idGrupoVmonofasico']!=0){$idGrupoVmonofasico = $rowData['idGrupoVmonofasico'];}else{$idGrupoVmonofasico  = 87;}
if(isset($rowData['idGrupoVTrifasico'])&&$rowData['idGrupoVTrifasico']!=''&&$rowData['idGrupoVTrifasico']!=0){$idGrupoVTrifasico  = $rowData['idGrupoVTrifasico'];  }else{$idGrupoVTrifasico   = 106;}
if(isset($rowData['idGrupoPotencia'])&&$rowData['idGrupoPotencia']!=''&&$rowData['idGrupoPotencia']!=0){      $idGrupoPotencia    = $rowData['idGrupoPotencia'];    }else{$idGrupoPotencia     = 99;}
if(isset($rowData['idGrupoDespliegue'])&&$rowData['idGrupoDespliegue']!=''&&$rowData['idGrupoDespliegue']!=0){$idGrupoDespliegue  = $rowData['idGrupoDespliegue'];  }else{$idGrupoDespliegue   = 99;}
if(isset($rowData['idGrupoEstanque'])&&$rowData['idGrupoEstanque']!=''&&$rowData['idGrupoEstanque']!=0){      $idGrupoEstanque    = $rowData['idGrupoEstanque'];    }else{$idGrupoEstanque     = 99;}
$idVista             = 1; //1 = Vmonofasico - 2 = VTrifasico

//Para el grafico
$Grafico_FechaInicio    = fecha_actual();
$Grafico_HoraInicio     = restahoras('03:00:00', hora_actual());
$Grafico_FechaTermino   = fecha_actual();
$Grafico_HoraTermino    = hora_actual();
//en caso de ser la hora del dia anterior
if($Grafico_HoraInicio>$Grafico_HoraTermino){
	$Grafico_FechaInicio = restarDias(fecha_actual(),1);
}

/**************************************************************/
$Uso_FechaInicio   = $rowData['FechaInsGen'];
$Uso_FechaTermino  = fecha_actual();

/**************************************************************/
//Temporales
$TempValue_1 = 0;
$TempValue_2 = 0;
$TempValue_3 = 0;
$TempValue_4 = 0;

$TempCount_1 = 0;
$TempCount_2 = 0;
$TempCount_3 = 0;
$TempCount_4 = 0;

$Subquery_1    = '';
$Subquery_2    = '';
$Subquery_3    = '';
$Subquery_4    = '';

$arrSensores_1 = array();
$arrSensores_2 = array();
$arrSensores_3 = array();
$arrSensores_4 = array();
$CountSub_1    = 1;
$CountSub_2    = 1;
$CountSub_3    = 1;
$CountSub_4    = 1;

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
		if($rowData['SensoresGrupo_'.$i]==$idGrupoEstanque){
			$TempValue_4 = $TempValue_4 + $rowData['SensoresMedActual_'.$i];
			$TempCount_4++;
		}

		//para la subconsulta
		if($rowData['SensoresGrupo_'.$i]==$idGrupoVmonofasico){
			$Subquery_1 .= ',Sensor_'.$i.' AS SVmonofasico_'.$CountSub_1;
			$arrSensores_1[$CountSub_1]['Nombre'] = $rowData['SensoresNombre_'.$i];
			$CountSub_1++;
		}
		if($rowData['SensoresGrupo_'.$i]==$idGrupoVTrifasico){
			$Subquery_2 .= ',Sensor_'.$i.' AS SVTrifasico_'.$CountSub_2;
			$arrSensores_2[$CountSub_2]['Nombre'] = $rowData['SensoresNombre_'.$i];
			$CountSub_2++;
		}
		if($rowData['SensoresGrupo_'.$i]==$idGrupoDespliegue){
			$Subquery_3 .= ',Sensor_'.$i.' AS SAmperaje_'.$CountSub_3;
			$arrSensores_3[$CountSub_3]['Nombre'] = $rowData['SensoresNombre_'.$i];
			$CountSub_3++;
		}
		if($rowData['SensoresGrupo_'.$i]==$idGrupoEstanque){
			$Subquery_4 .= ',Sensor_'.$i.' AS SEstanque_'.$CountSub_4;
			$arrSensores_4[$CountSub_4]['Nombre'] = $rowData['SensoresNombre_'.$i];
			$CountSub_4++;
		}
	}
}
/****************************************************************/
//Saco promedios
if($TempCount_1!=0){  $Vmonofasico = $TempValue_1/$TempCount_1;}else{$Vmonofasico  = 0;}
if($TempCount_2!=0){  $VTrifasico  = $TempValue_2/$TempCount_2;}else{$VTrifasico   = 0;}
if($TempCount_3!=0){  $Potencia    = $TempValue_3/$TempCount_3;}else{$Potencia     = 0;}
if($TempCount_4!=0){  $Estanque    = $TempValue_4/$TempCount_4;}else{$Estanque     = 0;}
/****************************************************************/
//Consulto mediciones
if($idVista==1){
	$SIS_query = 'HoraSistema'.$Subquery_1.$Subquery_3.$Subquery_4;
}elseif($idVista==2){
	$SIS_query = 'HoraSistema'.$Subquery_2.$Subquery_3.$Subquery_4;
}
$SIS_join  = '';
$SIS_where = '(TimeStamp BETWEEN "'.$Grafico_FechaInicio.' '.$Grafico_HoraInicio .'" AND "'.$Grafico_FechaTermino.' '.$Grafico_HoraTermino.'")';
$SIS_order = 'FechaSistema ASC, HoraSistema ASC';
$arrGraficos = array();
$arrGraficos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$X_Puntero, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGraficos');

/*******************************************************/
/*******************************************************/
// consulto los datos
$SIS_query = 'SUM(Horas_'.$rowData['SensorActivacionID'].') AS Sum_Horas';
$SIS_where = "idTelemetria=".$X_Puntero." AND Fecha BETWEEN '".$Uso_FechaInicio."' AND '".$Uso_FechaTermino."'";
//Obtengo los datos
$rowUso  = db_select_data (false, $SIS_query, 'telemetria_listado_historial_uso', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/****************************************************************/
//Variables
$Temp_1     = '';
$arrData_1  = array();//Voltaje
$arrData_2  = array();//Amperaje
$arrData_3  = array();//Nivel Estanque

//se arman datos
//Si existen
if(isset($arrGraficos)&&$arrGraficos!=false && !empty($arrGraficos) && $arrGraficos!=''){
	//recorro
	foreach ($arrGraficos as $data) {

		//Variables
		$Temp_1 .= "'".$data['HoraSistema']."',";

		/***************************************/
		//Verifico si es voltaje monofasico
		if($idVista==1){
			for ($x = 1; $x <= $CountSub_1; $x++) {
				//verifico si existe
				if(isset($arrData_1[$x]['Value'])&&$arrData_1[$x]['Value']!=''){
					$arrData_1[$x]['Value'] .= ", ".$data['SVmonofasico_'.$x];
				//si no lo crea
				}else{
					$arrData_1[$x]['Value'] = $data['SVmonofasico_'.$x];
				}
				//Nombre
				$arrData_1[$x]['Name'] = "'".$arrSensores_1[$x]['Nombre']."'";
			}

		//Verifico si es voltaje trifasico
		}elseif($idVista==2){
			for ($x = 1; $x <= $CountSub_2; $x++) {
				//verifico si existe
				if(isset($arrData_1[$x]['Value'])&&$arrData_1[$x]['Value']!=''){
					$arrData_1[$x]['Value'] .= ", ".$data['SVTrifasico_'.$x];
				//si no lo crea
				}else{
					$arrData_1[$x]['Value'] = $data['SVTrifasico_'.$x];
				}
				//Nombre
				$arrData_1[$x]['Name'] = "'".$arrSensores_2[$x]['Nombre']."'";
			}
		}

		/***************************************/
		for ($x = 1; $x <= $CountSub_3; $x++) {
			//verifico si existe
			if(isset($arrData_2[$x]['Value'])&&$arrData_2[$x]['Value']!=''){
				$arrData_2[$x]['Value'] .= ", ".$data['SAmperaje_'.$x];
			//si no lo crea
			}else{
				$arrData_2[$x]['Value'] = $data['SAmperaje_'.$x];
			}
			//Nombre
			$arrData_2[$x]['Name'] = "'".$arrSensores_3[$x]['Nombre']."'";
		}

		/***************************************/
		for ($x = 1; $x <= $CountSub_4; $x++) {
			//verifico si existe
			if(isset($arrData_3[$x]['Value'])&&$arrData_3[$x]['Value']!=''){
				$arrData_3[$x]['Value'] .= ", ".$data['SEstanque_'.$x];
			//si no lo crea
			}else{
				$arrData_3[$x]['Value'] = $data['SEstanque_'.$x];
			}
			//Nombre
			$arrData_3[$x]['Name'] = "'".$arrSensores_4[$x]['Nombre']."'";
		}

	}

	/*******************************************************/
	/*******************************************************/
	//variables
	$Graphics_xData_1       = 'var xData = [';
	$Graphics_yData_1       = 'var yData = [';
	$Graphics_names_1       = 'var names = [';
	$Graphics_types_1       = 'var types = [';
	$Graphics_texts_1       = 'var texts = [';
	$Graphics_lineColors_1  = 'var lineColors = [';
	$Graphics_lineDash_1    = 'var lineDash = [';
	$Graphics_lineWidth_1   = 'var lineWidth = [';
	//Se crean los datos
	//Verifico si es voltaje monofasico
	if($idVista==1){
		$CountSub = $CountSub_1;
	//Verifico si es voltaje trifasico
	}elseif($idVista==2){
		$CountSub = $CountSub_2;
	}
	for ($x = 1; $x <= $CountSub; $x++) {
		if(isset($arrData_1[$x]['Value'])&&$arrData_1[$x]['Value']!=''){
			//las fechas
			$Graphics_xData_1      .='['.$Temp_1.'],';
			//los valores
			$Graphics_yData_1      .='['.$arrData_1[$x]['Value'].'],';
			//los nombres
			$Graphics_names_1      .= $arrData_1[$x]['Name'].',';
			//los tipos
			$Graphics_types_1      .= "'lines',";
			//si lleva texto en las burbujas
			$Graphics_texts_1      .= "[],";
			//los colores de linea
			$Graphics_lineColors_1 .= "'',";
			//los tipos de linea
			$Graphics_lineDash_1   .= "'',";
			//los anchos de la linea
			$Graphics_lineWidth_1  .= "'',";
		}
	}
	$Graphics_xData_1      .= '];';
	$Graphics_yData_1      .= '];';
	$Graphics_names_1      .= '];';
	$Graphics_types_1      .= '];';
	$Graphics_texts_1      .= '];';
	$Graphics_lineColors_1 .= '];';
	$Graphics_lineDash_1   .= '];';
	$Graphics_lineWidth_1  .= '];';
	/*******************************************************/
	/*******************************************************/
	//variables
	$Graphics_xData_2       = 'var xData = [';
	$Graphics_yData_2       = 'var yData = [';
	$Graphics_names_2       = 'var names = [';
	$Graphics_types_2       = 'var types = [';
	$Graphics_texts_2       = 'var texts = [';
	$Graphics_lineColors_2  = 'var lineColors = [';
	$Graphics_lineDash_2    = 'var lineDash = [';
	$Graphics_lineWidth_2   = 'var lineWidth = [';
	//Se crean los datos
	for ($x = 1; $x <= $CountSub_3; $x++) {
		if(isset($arrData_2[$x]['Value'])&&$arrData_2[$x]['Value']!=''){
			//las fechas
			$Graphics_xData_2      .='['.$Temp_1.'],';
			//los valores
			$Graphics_yData_2      .='['.$arrData_2[$x]['Value'].'],';
			//los nombres
			$Graphics_names_2      .= $arrData_2[$x]['Name'].',';
			//los tipos
			$Graphics_types_2      .= "'lines',";
			//si lleva texto en las burbujas
			$Graphics_texts_2      .= "[],";
			//los colores de linea
			$Graphics_lineColors_2 .= "'',";
			//los tipos de linea
			$Graphics_lineDash_2   .= "'',";
			//los anchos de la linea
			$Graphics_lineWidth_2  .= "'',";
		}
	}
	$Graphics_xData_2      .= '];';
	$Graphics_yData_2      .= '];';
	$Graphics_names_2      .= '];';
	$Graphics_types_2      .= '];';
	$Graphics_texts_2      .= '];';
	$Graphics_lineColors_2 .= '];';
	$Graphics_lineDash_2   .= '];';
	$Graphics_lineWidth_2  .= '];';
	/*******************************************************/
	/*******************************************************/
	//variables
	$Graphics_xData_3       = 'var xData = [';
	$Graphics_yData_3       = 'var yData = [';
	$Graphics_names_3       = 'var names = [';
	$Graphics_types_3       = 'var types = [';
	$Graphics_texts_3       = 'var texts = [';
	$Graphics_lineColors_3  = 'var lineColors = [';
	$Graphics_lineDash_3    = 'var lineDash = [';
	$Graphics_lineWidth_3   = 'var lineWidth = [';
	//Se crean los datos
	for ($x = 1; $x <= $CountSub_3; $x++) {
		if(isset($arrData_3[$x]['Value'])&&$arrData_3[$x]['Value']!=''){
			//las fechas
			$Graphics_xData_3      .='['.$Temp_1.'],';
			//los valores
			$Graphics_yData_3      .='['.$arrData_3[$x]['Value'].'],';
			//los nombres
			$Graphics_names_3      .= $arrData_3[$x]['Name'].',';
			//los tipos
			$Graphics_types_3      .= "'lines',";
			//si lleva texto en las burbujas
			$Graphics_texts_3      .= "[],";
			//los colores de linea
			$Graphics_lineColors_3 .= "'',";
			//los tipos de linea
			$Graphics_lineDash_3   .= "'',";
			//los anchos de la linea
			$Graphics_lineWidth_3  .= "'',";
		}
	}
	$Graphics_xData_3      .= '];';
	$Graphics_yData_3      .= '];';
	$Graphics_names_3      .= '];';
	$Graphics_types_3      .= '];';
	$Graphics_texts_3      .= '];';
	$Graphics_lineColors_3 .= '];';
	$Graphics_lineDash_3   .= '];';
	$Graphics_lineWidth_3  .= '];';

//Si no hay datos
}else{
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
		alert_post_data(4,2,2,0, 'No existen datos para el grafico entre las '.$Grafico_HoraInicio.' y las '.$Grafico_HoraTermino);
	echo '</div>';
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Estado del Equipo <?php echo $rowData['Nombre']; ?></h5>
		</header>
        <div class="tab-content">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php
						//se arman datos
						//Si existen
						if(isset($arrGraficos)&&$arrGraficos!=false && !empty($arrGraficos) && $arrGraficos!=''){
							//$Titulo = 'Potencia hora punta (Periodo: '.$Grafico_FechaInicio.' al '.$Grafico_FechaTermino.')';
							$Titulo = 'Voltaje';
							echo GraphLinear_1('graphLinear_1', $Titulo, 'Fecha', 'Voltaje',  $Graphics_xData_1, $Graphics_yData_1, $Graphics_names_1, $Graphics_types_1, $Graphics_texts_1, $Graphics_lineColors_1, $Graphics_lineDash_1, $Graphics_lineWidth_1, 0);
							$Titulo = 'Amperaje';
							echo GraphLinear_1('graphLinear_2', $Titulo, 'Fecha', 'Amperaje', $Graphics_xData_2, $Graphics_yData_2, $Graphics_names_2, $Graphics_types_2, $Graphics_texts_2, $Graphics_lineColors_2, $Graphics_lineDash_2, $Graphics_lineWidth_2, 0);
							$Titulo = 'Nivel Estanque';
							echo GraphLinear_1('graphLinear_3', $Titulo, 'Fecha', 'Nivel',    $Graphics_xData_3, $Graphics_yData_3, $Graphics_names_3, $Graphics_types_3, $Graphics_texts_3, $Graphics_lineColors_3, $Graphics_lineDash_3, $Graphics_lineWidth_3, 0);
						}
						?>
					</div>
				</div>

				<div class="row">

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Potencia</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($Potencia, 2).' kW'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Voltaje</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span>
										<?php
										if($idVista==1){
											echo Cantidades($Vmonofasico, 2).' V';
										}elseif($idVista==2){
											echo Cantidades($VTrifasico, 2).' V';
										} ?>
									</span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Nivel Estanque</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo Cantidades($Estanque, 2).' '; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="box box-blue box-solid">
							<div class="box-header with-border text-center">
								<h3 class="box-title">Horas de uso entregando energía</h3>
							</div>
							<div class="box-body">
								<div class="value">
									<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
									<span><?php echo gmdate("H:i:s",$rowUso['Sum_Horas']).' Horas'; ?></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<a target="_blank" rel="noopener noreferrer" href="" class="btn btn-default width100" style="margin-bottom:10px;"><i class="fa fa-plus" aria-hidden="true"></i> Ver Mas</a>
					</div>

				</div>

			</div>
			<div class="clearfix"></div>
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
