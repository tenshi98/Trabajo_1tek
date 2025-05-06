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
//variables
$arrData = array();
$arrData[1] = "C";
$arrData[2] = "D";
$arrData[3] = "E";
$arrData[4] = "F";
$arrData[5] = "G";
$arrData[6] = "H";
$arrData[7] = "I";
$arrData[8] = "J";
$arrData[9] = "K";
$arrData[10] = "L";
$arrData[11] = "M";
$arrData[12] = "N";
$arrData[13] = "O";
$arrData[14] = "P";
$arrData[15] = "Q";
$arrData[16] = "R";
$arrData[17] = "S";
$arrData[18] = "T";
$arrData[19] = "U";
$arrData[20] = "V";
$arrData[21] = "W";
$arrData[22] = "X";
$arrData[23] = "Y";
$arrData[24] = "Z";
$arrData[25] = "AA";
$arrData[26] = "AB";
$arrData[27] = "AC";
$arrData[28] = "AD";
$arrData[29] = "AE";
$arrData[30] = "AF";
$arrData[31] = "AG";
$arrData[32] = "AH";
$arrData[33] = "AI";
$arrData[34] = "AJ";
$arrData[35] = "AK";
$arrData[36] = "AL";
$arrData[37] = "AM";
$arrData[38] = "AN";
$arrData[39] = "AO";
$arrData[40] = "AP";
$arrData[41] = "AQ";
$arrData[42] = "AR";
$arrData[43] = "AS";
$arrData[44] = "AT";
$arrData[45] = "AU";
$arrData[46] = "AV";
$arrData[47] = "AW";
$arrData[48] = "AX";
$arrData[49] = "AY";
$arrData[50] = "AZ";
$arrData[51] = "BA";
$arrData[52] = "BB";
$arrData[53] = "BC";
$arrData[54] = "BD";
$arrData[55] = "BE";
$arrData[56] = "BF";
$arrData[57] = "BG";
$arrData[58] = "BH";
$arrData[59] = "BI";
$arrData[60] = "BJ";
$arrData[61] = "BK";
$arrData[62] = "BL";
$arrData[63] = "BM";
$arrData[64] = "BN";
$arrData[65] = "BO";
$arrData[66] = "BP";
$arrData[67] = "BQ";
$arrData[68] = "BR";
$arrData[69] = "BS";
$arrData[70] = "BT";
$arrData[71] = "BU";
$arrData[72] = "BV";
$arrData[73] = "BW";
$arrData[74] = "BX";
$arrData[75] = "BY";
$arrData[76] = "BZ";
$arrData[77] = "CA";
$arrData[78] = "CB";
$arrData[79] = "CC";
$arrData[80] = "CD";
$arrData[81] = "CE";
$arrData[82] = "CF";
$arrData[83] = "CG";
$arrData[84] = "CH";
$arrData[85] = "CI";
$arrData[86] = "CJ";
$arrData[87] = "CK";
$arrData[88] = "CL";
$arrData[89] = "CM";
$arrData[90] = "CN";
$arrData[91] = "CO";
$arrData[92] = "CP";
$arrData[93] = "CQ";
$arrData[94] = "CR";
$arrData[95] = "CS";
$arrData[96] = "CT";
$arrData[97] = "CU";
$arrData[98] = "CV";
$arrData[99] = "CW";
$arrData[100] = "CX";
$arrData[101] = "CY";
$arrData[102] = "CZ";
$arrData[103] = "DA";
$arrData[104] = "DB";
$arrData[105] = "DC";
$arrData[106] = "DD";
$arrData[107] = "DE";
$arrData[108] = "DF";
$arrData[109] = "DG";
$arrData[110] = "DH";
$arrData[111] = "DI";
$arrData[112] = "DJ";
$arrData[113] = "DK";
$arrData[114] = "DL";
$arrData[115] = "DM";
$arrData[116] = "DN";
$arrData[117] = "DO";
$arrData[118] = "DP";
$arrData[119] = "DQ";
$arrData[120] = "DR";
$arrData[121] = "DS";
$arrData[122] = "DT";
$arrData[123] = "DU";
$arrData[124] = "DV";
$arrData[125] = "DW";
$arrData[126] = "DX";
$arrData[127] = "DY";
$arrData[128] = "DZ";

//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = '';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where.= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where.= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	/****************************************/
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo,cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');
	/****************************************/
	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$consql .= ',telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$i.' AS SensorValue_'.$i;
	}
	/****************************************/
	//consulto
	$SIS_query = '
	telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema,
	telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
	$SIS_order = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/****************************************/
	//Se trae grupo
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
				->setCellValue('A1', '')
				->setCellValue('B1', '');
	$x = 1;
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		if($arrEquipos[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue($arrData[$x].'1', DeSanitizar($arrEquipos[0]['SensorNombre_'.$i]));
			$x++;
		}
	}

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A2', 'Fecha')
				->setCellValue('B2', 'Hora');
	$x = 1;
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		if($arrEquipos[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue($arrData[$x].'2', 'Medicion');
			$x++;
		}
	}

	$nn=3;

	foreach ($arrEquipos as $rutas) {
		$x = 1;
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, $rutas['FechaSistema'])
					->setCellValue('B'.$nn, $rutas['HoraSistema']);

		for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
			if($rutas['SensoresGrupo_'.$i]==$_GET['idGrupo']){
				if(isset($rutas['SensorValue_'.$i])&&$rutas['SensorValue_'.$i]<99900){
					$xdata=Cantidades_decimales_justos($rutas['SensorValue_'.$i]);
				}else{
					$xdata='Sin Datos';
				}
				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($arrData[$x].$nn, $xdata);
				$x++;
			}
		}
		$nn++;
	}


	// Rename worksheet
	$spreadsheet->getActiveSheet()->setTitle('Registro Camaras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$spreadsheet->setActiveSheetIndex(0);

	/**************************************************************************/
	//Nombre del archivo
	$filename = 'Registro Camaras del equipo '.$rowEquipo['NombreEquipo'];
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
