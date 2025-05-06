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
	$SIS_where .=" (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
/*******************************************************************/
//variables
$ndata_1 = 0;
$ndata_2 = 0;
$ndata_3 = 0;
$error   = '';
//Se verifica si el dato existe
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');
foreach ($_GET["idGrupo"] as $gru) { $ndata_2++;}
if(!isset($_GET['SensoresUniMed']) OR $_GET['SensoresUniMed']==''){$ndata_3++;}
//generacion de errores
if($ndata_1>=10001) { $error = 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados';}
if($ndata_2==0) {     $error = 'No ha seleccionado ningun grupo';}
if($ndata_3!=0) {     $error = 'No ha seleccionado ninguna unidad de medida';}
/*******************************************************************/

//Si no hay errores ejecuto el codigo
if(isset($error)&&$error!=''){
	alert_post_data(4,1,1,0, $error);
}else{
	/****************************************************************/
	//Numero de sensores
	$rowNSensores = db_select_data (false, 'cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	/****************************************************************/
	//obtengo la cantidad real de sensores
	$SIS_query = 'telemetria_listado.Nombre AS NombreEquipo';
	for ($i = 1; $i <= $rowNSensores['cantSensores']; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
	}
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado.idTelemetria';
	$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = 'FechaSistema,HoraSistema';
	for ($i = 1; $i <= $rowNSensores['cantSensores']; $i++) {
		$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
	}
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
	$arrMediciones = array();
	$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

	/*************************************************************/
	//busco los grupos disponibles
	$arrSubgrupo          = array();
	$SIS_whereSubgrupo    = 'idGrupo=0';
	//creo arreglo
	foreach ($_GET["idGrupo"] as $gru) {
		$SIS_whereSubgrupo .= ' OR idGrupo='.$gru;
	}

	/****************************************/
	//Se consulta
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
	//se recorre
	$arrGruposTemp = array();
	foreach ($arrGrupos as $gru) {
		$arrGruposTemp[$gru['idGrupo']]['Nombre'] = TituloMenu($gru['Nombre']);
		$arrGruposTemp[$gru['idGrupo']]['Valor']  = '';
	}

	/*******************************************************************************/
	//Variables
	$xx = 1;
	$arrData = array();
	$arrData[$xx] = "C";$xx++;
	$arrData[$xx] = "D";$xx++;
	$arrData[$xx] = "E";$xx++;
	$arrData[$xx] = "F";$xx++;
	$arrData[$xx] = "G";$xx++;
	$arrData[$xx] = "H";$xx++;
	$arrData[$xx] = "I";$xx++;
	$arrData[$xx] = "J";$xx++;
	$arrData[$xx] = "K";$xx++;
	$arrData[$xx] = "L";$xx++;
	$arrData[$xx] = "M";$xx++;
	$arrData[$xx] = "N";$xx++;
	$arrData[$xx] = "O";$xx++;
	$arrData[$xx] = "P";$xx++;
	$arrData[$xx] = "Q";$xx++;
	$arrData[$xx] = "R";$xx++;
	$arrData[$xx] = "S";$xx++;
	$arrData[$xx] = "T";$xx++;
	$arrData[$xx] = "U";$xx++;
	$arrData[$xx] = "V";$xx++;
	$arrData[$xx] = "W";$xx++;
	$arrData[$xx] = "X";$xx++;
	$arrData[$xx] = "Y";$xx++;
	$arrData[$xx] = "Z";$xx++;
	$arrData[$xx] = "AA";$xx++;
	$arrData[$xx] = "AB";$xx++;
	$arrData[$xx] = "AC";$xx++;
	$arrData[$xx] = "AD";$xx++;
	$arrData[$xx] = "AE";$xx++;
	$arrData[$xx] = "AF";$xx++;
	$arrData[$xx] = "AG";$xx++;
	$arrData[$xx] = "AH";$xx++;
	$arrData[$xx] = "AI";$xx++;
	$arrData[$xx] = "AJ";$xx++;
	$arrData[$xx] = "AK";$xx++;
	$arrData[$xx] = "AL";$xx++;
	$arrData[$xx] = "AM";$xx++;
	$arrData[$xx] = "AN";$xx++;
	$arrData[$xx] = "AO";$xx++;
	$arrData[$xx] = "AP";$xx++;
	$arrData[$xx] = "AQ";$xx++;
	$arrData[$xx] = "AR";$xx++;
	$arrData[$xx] = "AS";$xx++;
	$arrData[$xx] = "AT";$xx++;
	$arrData[$xx] = "AU";$xx++;
	$arrData[$xx] = "AV";$xx++;
	$arrData[$xx] = "AW";$xx++;
	$arrData[$xx] = "AX";$xx++;
	$arrData[$xx] = "AY";$xx++;
	$arrData[$xx] = "AZ";$xx++;
	$arrData[$xx] = "BA";$xx++;

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

	/************************************/
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A1', 'Fecha')
				->setCellValue('B1', 'Hora');

	$xx = 1;
	foreach ($_GET["idGrupo"] as $gru) {
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue($arrData[$xx].'1', $arrGruposTemp[$gru]['Nombre']);
		//SUMO
		$xx++;
	}


	/************************************/
	$nn=2;
	foreach ($arrMediciones as $fac) {
		/************************/
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, fecha_estandar($fac['FechaSistema']))
					->setCellValue('B'.$nn, $fac['HoraSistema']);

		/************************/
		//Variables
		$arrTemp = array();
		$xx = 1;
		//recorro los grupos
		foreach ($_GET["idGrupo"] as $gru) {
			/***********************************************/
			//recorro los sensores
			for ($x = 1; $x <= $rowNSensores['cantSensores']; $x++) {
				if($rowEquipo['SensoresGrupo_'.$x]==$gru){
					//Verifico si el sensor esta activo para guardar el dato
					if(isset($rowEquipo['SensoresActivo_'.$x])&&$rowEquipo['SensoresActivo_'.$x]==1){
						//Que el valor medido sea distinto de 999
						if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
							//promedio
							if($rowEquipo['SensoresUniMed_'.$x]==$_GET['SensoresUniMed']){
								$arrTemp[$gru]['Value'] = $arrTemp[$gru]['Value'] + $fac['SensorValue_'.$x];
								$arrTemp[$gru]['Count']++;
							}
						}
					}
				}
			}
			/***********************************************/
			//saco promedios
			if($arrTemp[$gru]['Count']!=0){
				$arrTemp[$gru]['Prom'] = $arrTemp[$gru]['Value']/$arrTemp[$gru]['Count'];
			}else{
				$arrTemp[$gru]['Prom'] = 0;
			}

			/***********************************************/
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue($arrData[$xx].$nn, $arrTemp[$gru]['Prom']);
			//SUMO
			$xx++;
		}

		/************************/
		//SUMO
		$nn++;
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
