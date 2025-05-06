<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                                     Se llama la libreria                                                       */
/**********************************************************************************************************************************/
require '../LIBS_php/PhpOffice/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Excel.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
/**********************************************************************************************************************************/

/**********************************************************************/
/********************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$subf='';
//Datos opcionales
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$subf.=" AND (TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$subf.=" AND (FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}

/**********************************************************************/
//Funcion para escribir datos
function crear_data($cantsens, $filtro, $idTelemetria, $f_inicio, $f_termino, $desde, $hasta, $dbConn ) {

	$consql = '';
	$subfiltro = '';
	for ($i = 1; $i <= $cantsens; $i++) {
		//$subfiltro .= ' AND telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.' != 999';
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		//$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;

		//desde y hasta activo
		if(isset($desde)&&$desde!=''&&isset($hasta)&&$hasta!=''){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedDesStan_'.$i;
		//solo desde
		}elseif(isset($desde)&&$desde!=''&&(!isset($hasta) OR $hasta=='')){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//solo hasta
		}elseif(isset($hasta)&&$hasta!=''&&(!isset($desde) OR $desde=='')){
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//ninguno
		}else{
			//$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMin_'.$i;
			//$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedProm_'.$i;
			//$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedDesStan_'.$i;
		}
	}

	/*******************************************************/
	//se consulta
	$SIS_query = 'telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria';
	$SIS_where = 'idTabla!=0 '.$filtro.$subfiltro.' GROUP BY telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema';
	$SIS_order = 'telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema ASC LIMIT 10000';
	$arrRutas = array();
	$arrRutas = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRutas');

	return $arrRutas;

}
/*******************************************************/
//Consulta por la cantidad de sensores
$SIS_query = 'cantSensores, Nombre';
$SIS_where = 'idTelemetria='.$_GET['idTelemetria'];
$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

/*******************************************************/
//se consulta
//Variable temporal
$arrTemporal = array();
//Llamo a la funcion
$arrTemporal = crear_data($rowEquipo['cantSensores'], $subf, $_GET['idTelemetria'], $_GET['f_inicio'], $_GET['f_termino'], $_GET['desde'], $_GET['hasta'] , $dbConn);

/**********************************************************************************************************************************/
/*                                                          Ejecucion                                                             */
/**********************************************************************************************************************************/
// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator("Office 2007")
							 ->setLastModifiedBy("Office 2007")
							 ->setTitle("Office 2007")
							 ->setSubject("Office 2007")
							 ->setDescription("Document for Office 2007")
							 ->setKeywords("office 2007")
							 ->setCategory("office 2007 result file");

/***********************************************************/
//Titulo columnas
if(isset($_GET['idOpciones'])&&$_GET['idOpciones']!=''&&$_GET['idOpciones']!=0){
	switch ($_GET['idOpciones']) {
		case 1:
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A1', 'Equipo')
						->setCellValue('B1', 'Fecha')
						->setCellValue('C1', 'Temperatura (°C)');
			break;
		case 2:
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A1', 'Equipo')
						->setCellValue('B1', 'Fecha')
						->setCellValue('C1', 'Humedad (%)');
			break;
	}
}else{
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A1', 'Equipo')
				->setCellValue('B1', 'Fecha')
				->setCellValue('C1', 'Temperatura (°C)')
				->setCellValue('D1', 'Humedad (%)');
}

$nn=2;
foreach ($arrTemporal as $fac) {
	//numero sensores equipo
	$Temperatura    = 0;
	$Temperatura_N  = 0;
	$Humedad        = 0;
	$Humedad_N      = 0;

	for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
		if($fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
			//Que el valor medido sea distinto de 999
			if(isset($fac['MedProm_'.$x])&&$fac['MedProm_'.$x]<99900){
				//Si es humedad
				if($fac['SensoresUniMed_'.$x]==2){$Humedad = $Humedad + $fac['MedProm_'.$x];$Humedad_N++;}
				//Si es temperatura
				if($fac['SensoresUniMed_'.$x]==3){$Temperatura = $Temperatura + $fac['MedProm_'.$x];$Temperatura_N++;}
			}
		}
	}

	if($Temperatura_N!=0){  $New_Temperatura = $Temperatura/$Temperatura_N; }else{$New_Temperatura = 0;}
	if($Humedad_N!=0){      $New_Humedad     = $Humedad/$Humedad_N;         }else{$New_Humedad = 0;}

	//omite la linea mientras alguna de las variables contenga datos
	if($Temperatura_N!=0 OR $Humedad_N!=0){
		if(isset($_GET['idOpciones'])&&$_GET['idOpciones']!=''&&$_GET['idOpciones']!=0){
			switch ($_GET['idOpciones']) {
				case 1:
					$spreadsheet->setActiveSheetIndex(0)
								->setCellValue('A'.$nn, DeSanitizar($rowEquipo['Nombre']))
								->setCellValue('B'.$nn, $fac['FechaSistema'])
								->setCellValue('C'.$nn, $New_Temperatura);
					break;
				case 2:
					$spreadsheet->setActiveSheetIndex(0)
								->setCellValue('A'.$nn, DeSanitizar($rowEquipo['Nombre']))
								->setCellValue('B'.$nn, $fac['FechaSistema'])
								->setCellValue('C'.$nn, $New_Humedad);
					break;
			}
		}else{
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A'.$nn, DeSanitizar($rowEquipo['Nombre']))
						->setCellValue('B'.$nn, $fac['FechaSistema'])
						->setCellValue('C'.$nn, $New_Temperatura)
						->setCellValue('D'.$nn, $New_Humedad);
		}

		$nn++;
	}
}

/***********************************************************/
// Rename worksheet
$spreadsheet->getActiveSheet(0)->setTitle(cortar(DeSanitizar($rowEquipo['Nombre']), 25));

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Informe Promedio Camara del equipo '.$rowEquipo['Nombre'];
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.DeSanitizar($filename).'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
