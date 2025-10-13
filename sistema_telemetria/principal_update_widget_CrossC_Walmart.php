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
/*                                                      Consulta                                                                  */
/**********************************************************************************************************************************/
//Obtengo datos configuracion

if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$idTelemetria = $_GET['idTelemetria'];
	$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'] = $_GET['idTelemetria'];
}else{
	$idTelemetria = $_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'];
}
if(isset($_GET['cantSensores'])&&$_GET['cantSensores']!=''){
	$cantSensores = $_GET['cantSensores'];
	$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'] = $_GET['cantSensores'];
}else{
	$cantSensores = $_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'];
}

$timeBack      = $_SESSION['usuario']['widget_CrossC_Walmart']['timeBack'];
$seguimiento   = $_SESSION['usuario']['widget_CrossC_Walmart']['seguimiento'];
$idSistema     = $_SESSION['usuario']['widget_CrossC_Walmart']['idSistema'];
$idTipoUsuario = $_SESSION['usuario']['widget_CrossC_Walmart']['idTipoUsuario'];
$idUsuario     = $_SESSION['usuario']['widget_CrossC_Walmart']['idUsuario'];

//variables
$HoraInicio     = restahoras($timeBack,hora_actual());
$FechaInicio    = fecha_actual();
$HoraTermino    = hora_actual();
$FechaTermino   = fecha_actual();
if($HoraTermino<$timeBack){
	$FechaInicio = restarDias($FechaTermino,1);
}

	/*************************************************************/
	//Se consulta
	//numero sensores equipo
	$N_Maximo_Sensores = $cantSensores;
	$SIS_query = '
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.TiempoFueraLinea';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria           = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria  = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria      = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria          = telemetria_listado.idTelemetria';
	$SIS_where = 'telemetria_listado.idTelemetria='.$idTelemetria;
	$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	//busco los grupos disponibles
	$arrSubgrupo          = array();
	$arrSubgrupoUso       = array();
	$SIS_whereSubgrupo    = 'idGrupo=0';
	$SIS_whereSubgrupoUso = 'idGrupo=0';
	//creo arreglo
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$arrSubgrupo[$rowEquipo['SensoresGrupo_'.$i]]['idGrupo']            = $rowEquipo['SensoresGrupo_'.$i];
		$arrSubgrupoUso[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
	}
	//se crea cadena
	foreach($arrSubgrupo as $categoria=>$sub){
		$SIS_whereSubgrupo .= ' OR idGrupo='.$sub['idGrupo'];
	}
	foreach($arrSubgrupoUso as $categoria=>$sub){
		$SIS_whereSubgrupoUso .= ' OR idGrupo='.$sub['idGrupo'];
	}

	/*************************************************************/
	//Se consulta
	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$consql .= ',Sensor_'.$i.' AS SensorValue_'.$i;
	}
	/*****************************/
	$SIS_query = 'FechaSistema,HoraSistema'.$consql;
	$SIS_join  = '';
	$SIS_where = '(TimeStamp BETWEEN "'.$FechaInicio.' '.$HoraInicio.'" AND "'.$FechaTermino.' '.$HoraTermino.'")';
	$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
	$arrMediciones = array();
	$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

	/*************************************************************/
	//Se consulta
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
	//se recorre
	$arrGruposTemp = array();
	foreach ($arrGrupos as $gru) {
		$arrGruposTemp[$gru['idGrupo']] = $gru['Nombre'];
	}

	/*************************************************************/
	//Se consulta
	$T_idGrupo    = 0;
	$arrGruposUso = array();
	$arrGruposUso = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', $SIS_whereSubgrupoUso, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposUso');
	//se recorre
	$arrGruposUsoTemp = array();
	foreach ($arrGruposUso as $gruUso) {
		$arrGruposUsoTemp[$gruUso['idGrupo']] = $gruUso['Nombre'];
		//guardo el primer grupo
		if($T_idGrupo==0){
			$T_idGrupo = $gruUso['idGrupo'];
		}
	}

	/*************************************************************/
	//Variables
	$arrTempGrupos = array();
	$arrTempSensor = array();
	$arrTempMed    = array();
	$Temp_1        = '';
	$arrData       = array();
	$arrDatax      = array();

	//Se recorren las mediciones
	foreach($arrMediciones as $cli) {

		/******************************/
		//reseteo
		$arrTemporal = array();

		/******************************/
		//recorro los sensores
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
				//Valido valores
				if(isset($cli['SensorValue_'.$i])&&$cli['SensorValue_'.$i]<999){
					/********************************/
					//datos
					//Sumo los sensores
					if(isset($arrTempMed[$i]['Suma'])&&$arrTempMed[$i]['Suma']!=''){
						$arrTempMed[$i]['Suma'] = $arrTempMed[$i]['Suma'] + $cli['SensorValue_'.$i];
					}else{
						$arrTempMed[$i]['Suma'] = $cli['SensorValue_'.$i];
					}
					//Cuento los sensores
					if(isset($arrTempMed[$i]['Cuenta'])&&$arrTempMed[$i]['Cuenta']!=''){
						$arrTempMed[$i]['Cuenta']++;
					}else{
						$arrTempMed[$i]['Cuenta'] = 1;
					}
					//Min de los sensores
					if(isset($arrTempMed[$i]['Min'])&&$arrTempMed[$i]['Min']!=''){
						//verifico si es menor
						if($arrTempMed[$i]['Min']>$cli['SensorValue_'.$i]){
							$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
						}
					}else{
						$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
					}
					//Max de los sensores
					if(isset($arrTempMed[$i]['Max'])&&$arrTempMed[$i]['Max']!=''){
						//verifico si es mayor
						if($arrTempMed[$i]['Max']<$cli['SensorValue_'.$i]){
							$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
						}
					}else{
						$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
					}

					/********************************/
					//Grafico
					//Si es temperatura
					//if($rowEquipo['SensoresUniMed_'.$i]==3&&$rowEquipo['SensoresRevisionGrupo_'.$i]==$arrGruposUso[0]['idGrupo']){
					if($rowEquipo['SensoresUniMed_'.$i]==3){
						//verifico si existe
						if(isset($arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'])&&$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']!=''){
							$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] = $arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] + $cli['SensorValue_'.$i];
							$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta']++;
						//si no lo crea
						}else{
							$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']  = $cli['SensorValue_'.$i];
							$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta'] = 1;
						}
					}
				}
			}
		}

		//Guardo la fecha
		$Temp_1 .= "'".Fecha_estandar($cli['FechaSistema'])." - ".$cli['HoraSistema']."',";

		/********************************/
		//Grafico
		//recorro grupo de uso
		foreach ($arrGruposUso as $gruUso) {
			//verifico que sea el primer grupo
			if($T_idGrupo==$gruUso['idGrupo']){
				//recorro los grupos
				foreach ($arrGrupos as $gru) {

					/***********************************************/
					//verifico si hay datos
					if(isset($arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'])&&$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta']!=0){
						//realizo los calculos
						$New_Dato = $arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Valor']/$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'];
						$arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'] = $New_Dato;
					//si no hay datos utilizo el anterior
					}else{
						$New_Dato = $arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'];
					}

					/***********************************************/
					//verifico si existe
					if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
						$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] .= ", ".$New_Dato;
					//si no lo crea
					}else{
						$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] = $New_Dato;
					}
				}
			}
		}
	}

	//variables
	$x_graph_count        = 0;
	$Graphics_xData       = 'var xData = [';
	$Graphics_yData       = 'var yData = [';
	$Graphics_names       = 'var names = [';
	$Graphics_types       = 'var types = [';
	$Graphics_texts       = 'var texts = [';
	$Graphics_lineColors  = 'var lineColors = [';
	$Graphics_lineDash    = 'var lineDash = [';
	$Graphics_lineWidth   = 'var lineWidth = [';
	//Se crean los datos
	foreach ($arrGruposUso as $gruUso) {
		foreach ($arrGrupos as $gru) {
			if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
				//las fechas
				$Graphics_xData      .='['.$Temp_1.'],';
				//los valores
				$Graphics_yData      .='['.$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'].'],';
				//los nombres
				$Graphics_names      .= '"'.DeSanitizar(TituloMenu($gruUso['Nombre']).' - '.TituloMenu($gru['Nombre'])).'",';
				//los tipos
				$Graphics_types      .= "'',";
				//si lleva texto en las burbujas
				$Graphics_texts      .= "[],";
				//los colores de linea
				$Graphics_lineColors .= "'',";
				//los tipos de linea
				$Graphics_lineDash   .= "'',";
				//los anchos de la linea
				$Graphics_lineWidth  .= "'',";
				//contador
				$x_graph_count++;
			}
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

	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		//Verifico si el sensor esta activo para guardar el dato
		if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
			/*****************************************/
			//Grupo Uso
			$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['Nombre']  = $arrGruposUsoTemp[$rowEquipo['SensoresRevisionGrupo_'.$i]];
			$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
			/*****************************************/
			//Grupo
			//Si es temperatura
			if($rowEquipo['SensoresUniMed_'.$i]==3){
				//Nombre y grupo
				$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Nombre']  = $arrGruposTemp[$rowEquipo['SensoresGrupo_'.$i]];
				$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresGrupo_'.$i];
				//Temperatura Minima
				if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']!=''){
					//verifico si es menor
					if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']>$arrTempMed[$i]['Min']){
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
					}
				}else{
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
				}
				//Temperatura Maxima
				if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']!=''){
					//verifico si es mayor
					if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']<$arrTempMed[$i]['Max']){
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
					}
				}else{
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
				}
				//valido que este dentro del rango deseado
				if($rowEquipo['SensoresMedActual_'.$i]<999){
					//Temperatura Actual
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual']!=''){
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] + $rowEquipo['SensoresMedActual_'.$i];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual']++;
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $rowEquipo['SensoresMedActual_'.$i];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual'] = 1;
					}
				}
				//promedio
				if(isset($arrTempMed[$i]['Suma'])){
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']!=''){
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'] + $arrTempMed[$i]['Suma'];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] + $arrTempMed[$i]['Cuenta'];
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempMed[$i]['Suma'];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempMed[$i]['Cuenta'];
					}
				}else{
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = 0;
				}

				//estado (siempre pasa)
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
				$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;

			//si es humedad
			}elseif($rowEquipo['SensoresUniMed_'.$i]==2){
				//valido que este dentro del rango deseado
				if($rowEquipo['SensoresMedActual_'.$i]<999){
					//Humedad
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] + $rowEquipo['SensoresMedActual_'.$i];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum']++;
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $rowEquipo['SensoresMedActual_'.$i];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum'] = 1;
					}
				}
				//estado (siempre pasa)
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
				$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;

			/**********************/
			//si es boolean
			}elseif($rowEquipo['SensoresUniMed_'.$i]==12){
				//valido que este dentro del rango deseado
				if($rowEquipo['SensoresMedActual_'.$i]<999){
					//Humedad
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool']!=''){
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] + $rowEquipo['SensoresMedActual_'.$i];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool']++;
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $rowEquipo['SensoresMedActual_'.$i];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool'] = 1;
					}
				}
				//estado (siempre pasa)
				/*$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
				$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
				*/
			}
		}
	}

/*************************************************************/
//Se dibuja
$widget = '
<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
	<div class="row">
		<div class="table-responsive">
			<div class="table-wrapper-scroll-y my-custom-scrollbar">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th colspan="3">Grupo - Subgrupo</th>
							<th>T° Actual</th>
							<th>T° Max</th>
							<th>T° Min</th>
							<th>T° Prom</th>
							<th>Hr. Prom</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';

						/**********************************************/
						//variable
						$in_eq_fueralinea = '';
						//Fuera de linea
						$diaInicio   = $rowEquipo['LastUpdateFecha'];
						$diaTermino  = $FechaTermino;
						$tiempo1     = $rowEquipo['LastUpdateHora'];
						$tiempo2     = $HoraTermino;
						$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

						//Comparaciones de tiempo
						$Time_Tiempo     = horas2segundos($Tiempo);
						$Time_Tiempo_FL  = horas2segundos($rowEquipo['TiempoFueraLinea']);
						$Time_Tiempo_Max = horas2segundos('48:00:00');
						$Time_Fake_Ini   = horas2segundos('23:59:50');
						$Time_Fake_Fin   = horas2segundos('24:00:00');
						//comparacion
						if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
							$in_eq_fueralinea = '<i class="fa fa-exclamation-triangle faa-bounce animated" style="color: #a94442;" aria-hidden="true"></i>';
						}

						/***********************************************/
						//imprimo
						$widget .= '
							<tr class="odd">
								<th colspan="8">'.$in_eq_fueralinea.' Ultima Medicion: '.fecha_estandar($rowEquipo['LastUpdateFecha']).' a las '.$rowEquipo['LastUpdateHora'].' hrs.</th>
								<th><a href="view_alertas_personalizadas.php?view='.simpleEncode($_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'], fecha_actual()).'" class="iframe btn btn-danger btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas</a></th>
							</tr>';

						//Ordeno
						sort($arrTempGrupos);
						//recorro
						foreach ($arrTempGrupos as $gruUso) {
							//verificar errores
							if(isset($gruUso['NErrores'])&&$gruUso['NErrores']!=0){
								$danger_color = 'warning';
								$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
							}else{
								$danger_color = '';
								$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
							}
							$widget .= '
							<tr class="odd '.$danger_color.'">
								<th><div class="btn-group" style="width: 35px;" >'.$danger_icon.'</div></th>
								<th colspan="7">'.TituloMenu($gruUso['Nombre']).'</th>
								<th>
									<div class="btn-group" style="width: 35px;" >
										<button onClick="chngGroupUsoGraph('.$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'].', '.$gruUso['idGrupo'].')" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
									</div>
								</th>
							</tr>';
							//se ordena el arreglo
							sort($arrTempSensor[$gruUso['idGrupo']]);
							//recorro el arreglo
							foreach ($arrTempSensor[$gruUso['idGrupo']] as $gru) {
								//verificar errores
								if(isset($gru['NErrores'])&&$gru['NErrores']!=0){
									$danger_color = 'warning';
									$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
								}else{
									$danger_color = '';
									$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
								}
								//variables
								$Tmin    = Cantidades($gru['Tmin'], 1);
								$Tmax    = Cantidades($gru['Tmax'], 1);
								if(isset($gru['CountTActual'])&&$gru['CountTActual']!=0){  $TActual = Cantidades(($gru['TActual']/$gru['CountTActual']), 1); }else{ $TActual = 0; }
								if(isset($gru['CountProm'])&&$gru['CountProm']!=0){        $Prom    = Cantidades(($gru['Prom']/$gru['CountProm']), 1);       }else{ $Prom    = 0; }
								if(isset($gru['CountHum'])&&$gru['CountHum']!=0){          $Hum     = Cantidades(($gru['Hum']/$gru['CountHum']), 1);         }else{ $Hum     = 0; }
								if(isset($gru['CountBool'])&&$gru['CountBool']!=0){
									$tempv  = $gru['Bool']/$gru['CountBool'];
									$s_link = 'informe_telemetria_registro_sensores_20.php?f_inicio='.fecha_actual().'&f_termino='.fecha_actual().'&idTelemetria='.$idTelemetria.'&RevisionGrupo='.$gruUso['idGrupo'].'&submit_filter=Filtrar';
									//si esta abierto
									if($tempv!=0){
										$danger_color = 'warning';
										$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Abiertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-sign-out" aria-hidden="true"></i></a>';
									//si esta cerrado
									}else{
										$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Cerradas" class="btn btn-success btn-sm tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
									}
								//si no hay puertas configuradas
								}else{
									$danger_icon .= '';
								}

								$widget .= '
								<tr class="odd '.$danger_color.'">
									<td></td>
									<td><div class="btn-group" style="width: 70px;" >'.$danger_icon.'</div></td>
									<td>'.TituloMenu($gru['Nombre']).'</td>
									<td>'.$TActual.' °C</td>
									<td>'.$Tmax.' °C</td>
									<td>'.$Tmin.' °C</td>
									<td>'.$Prom.' °C</td>
									<td>'.$Hum.' %</td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<button onClick="chngGroupGraph('.$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'].', '.$gruUso['idGrupo'].', '.$gru['idGrupo'].')" title="Ver Información" class="btn btn-metis-6 btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
										</div>
									</td>
								</tr>';
							}
						}

					$widget .= '
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	<div class="row" id="update_graphics">';
		//si hay datos
		if(isset($x_graph_count)&&$x_graph_count!=0){
			$gr_tittle = 'Grafico '.DeSanitizar($arrGruposUsoTemp[$arrGruposUso[0]['idGrupo']]).' últimas '.horas2decimales($timeBack).' horas.';
			$gr_unimed = '°C';
			$widget .= GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 1);
		//si no hay datos
		}else{
			$widget .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/>';
			$widget .= '<div class="alert alert-danger alert-white rounded alert_box_correction" role="alert"><div class="icon"><i class="fa fa-info-circle faa-bounce animated" aria-hidden="true"></i></div><span id="alert_post_data">No hay datos para desplegar el grafico</span><div class="clearfix"></div></div>';
			$widget .= '</div>';
		}
		$widget .= '
	</div>
</div>';

echo $widget;

?>


