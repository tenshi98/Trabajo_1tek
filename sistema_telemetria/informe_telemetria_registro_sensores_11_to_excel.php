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
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = '';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo,cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$consql .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
		$consql .= ',telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$i.' AS SensorValue_'.$i;
	}
	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = '
	telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema,
	telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado`                  ON telemetria_listado.idTelemetria                  = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
	$SIS_order = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	//Se trae el dato del grupo
	$rowGrupo = db_select_data (false, 'Nombre', 'telemetria_listado_grupos', '', 'idGrupo='.$_GET['idGrupo'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowGrupo');

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

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A1', 'Fecha')
				->setCellValue('B1', 'Hora')
				->setCellValue('C1', 'Temperatura')
				->setCellValue('D1', 'Humedad');

	$nn=2;
	foreach ($arrEquipos as $fac) {
		//numero sensores equipo
		$Temperatura    = 0;
		$Temperatura_N  = 0;
		$Humedad        = 0;
		$Humedad_N      = 0;

		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			if($fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($fac['SensoresActivo_'.$x])&&$fac['SensoresActivo_'.$x]==1){
					//Que el valor medido sea distinto de 999
					if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
						//Si es humedad
						if($fac['SensoresUniMed_'.$x]==2){$Humedad = $Humedad + $fac['SensorValue_'.$x];$Humedad_N++;}
						//Si es temperatura
						if($fac['SensoresUniMed_'.$x]==3){$Temperatura = $Temperatura + $fac['SensorValue_'.$x];$Temperatura_N++;}
					}
				}
			}
		}

		if($Temperatura_N!=0){  $New_Temperatura = $Temperatura/$Temperatura_N; }else{$New_Temperatura = 0;}
		if($Humedad_N!=0){      $New_Humedad     = $Humedad/$Humedad_N;         }else{$New_Humedad = 0;}

		//omite la linea mientras alguna de las variables contenga datos
		if($Temperatura_N!=0 OR $Humedad_N!=0){
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A'.$nn, $fac['FechaSistema'])
						->setCellValue('B'.$nn, $fac['HoraSistema'])
						->setCellValue('C'.$nn, $New_Temperatura)
						->setCellValue('D'.$nn, $New_Humedad);
			$nn++;
		}
	}



	// Rename worksheet
	$spreadsheet->getActiveSheet()->setTitle('Informe Trazabilidad');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$spreadsheet->setActiveSheetIndex(0);

	/**************************************************************************/
	//Nombre del archivo
	$filename = 'Informe Trazabilidad del equipo '.$rowEquipo['NombreEquipo'];
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
}
