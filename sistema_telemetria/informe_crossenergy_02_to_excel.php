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
$xx = 1;
$arrData = array();
$arrData[$xx] = "A";$xx++;
$arrData[$xx] = "B";$xx++;
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
$arrData[$xx] = "BB";$xx++;
$arrData[$xx] = "BC";$xx++;
$arrData[$xx] = "BD";$xx++;
$arrData[$xx] = "BE";$xx++;
$arrData[$xx] = "BF";$xx++;
$arrData[$xx] = "BG";$xx++;
$arrData[$xx] = "BH";$xx++;
$arrData[$xx] = "BI";$xx++;
$arrData[$xx] = "BJ";$xx++;
$arrData[$xx] = "BK";$xx++;
$arrData[$xx] = "BL";$xx++;
$arrData[$xx] = "BM";$xx++;
$arrData[$xx] = "BN";$xx++;
$arrData[$xx] = "BO";$xx++;
$arrData[$xx] = "BP";$xx++;
$arrData[$xx] = "BQ";$xx++;
$arrData[$xx] = "BR";$xx++;
$arrData[$xx] = "BS";$xx++;
$arrData[$xx] = "BT";$xx++;
$arrData[$xx] = "BU";$xx++;
$arrData[$xx] = "BV";$xx++;
$arrData[$xx] = "BW";$xx++;
$arrData[$xx] = "BX";$xx++;
$arrData[$xx] = "BY";$xx++;
$arrData[$xx] = "BZ";$xx++;
$arrData[$xx] = "CA";$xx++;
$arrData[$xx] = "CB";$xx++;
$arrData[$xx] = "CC";$xx++;
$arrData[$xx] = "CD";$xx++;
$arrData[$xx] = "CE";$xx++;
$arrData[$xx] = "CF";$xx++;
$arrData[$xx] = "CG";$xx++;
$arrData[$xx] = "CH";$xx++;
$arrData[$xx] = "CI";$xx++;
$arrData[$xx] = "CJ";$xx++;
$arrData[$xx] = "CK";$xx++;
$arrData[$xx] = "CL";$xx++;
$arrData[$xx] = "CM";$xx++;
$arrData[$xx] = "CN";$xx++;
$arrData[$xx] = "CO";$xx++;
$arrData[$xx] = "CP";$xx++;
$arrData[$xx] = "CQ";$xx++;
$arrData[$xx] = "CR";$xx++;
$arrData[$xx] = "CS";$xx++;
$arrData[$xx] = "CT";$xx++;
$arrData[$xx] = "CU";$xx++;
$arrData[$xx] = "CV";$xx++;
$arrData[$xx] = "CW";$xx++;
$arrData[$xx] = "CX";$xx++;

//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = '';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where.= "(telemetria_listado_crossenergy_hora.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where.= "(telemetria_listado_crossenergy_hora.FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
$SIS_where.= " AND telemetria_listado_crossenergy_hora.idTelemetria=".$_GET['idTelemetria'];

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_crossenergy_hora', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{

	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo, cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensoresNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$consql .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
		$consql .= ',telemetria_listado_crossenergy_hora.Sensor_'.$i.' AS SensorValue_'.$i;
	}

	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = '
	telemetria_listado_crossenergy_hora.FechaSistema,
	telemetria_listado_crossenergy_hora.HoraSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_crossenergy_hora.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_crossenergy_hora.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_crossenergy_hora.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado_crossenergy_hora.idTelemetria';
	$SIS_order = 'telemetria_listado_crossenergy_hora.FechaSistema ASC, telemetria_listado_crossenergy_hora.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_crossenergy_hora', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/****************************************************************/
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
				->setCellValue('B1', 'Hora');

	$count = 0;
	foreach ($arrEquipos as $fac) {
		//columna inicial
		$yy = 3;
		//numero sensores equipo
		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			if($fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($fac['SensoresActivo_'.$x])&&$fac['SensoresActivo_'.$x]==1){
					//Que el valor medido sea distinto de 999
					if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
						//si es el primer recorrido
						if($count==0){
							$spreadsheet->setActiveSheetIndex(0)
										->setCellValue($arrData[$yy].'1', DeSanitizar($fac['SensoresNombre_'.$x]));
							//avanzo columna
							$yy++;
						}
					}
				}
			}
		}
		$count++;
	}

	$nn=2;
	foreach ($arrEquipos as $fac) {
		//columna inicial
		$yy = 3;
		//la cabecera
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, $fac['FechaSistema'])
					->setCellValue('B'.$nn, $fac['HoraSistema']);

		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			if($fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($fac['SensoresActivo_'.$x])&&$fac['SensoresActivo_'.$x]==1){
					//Que el valor medido sea distinto de 999
					if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
						$spreadsheet->setActiveSheetIndex(0)
									->setCellValue($arrData[$yy].$nn, cantidades($fac['SensorValue_'.$x], 2));
						//avanzo columna
						$yy++;
					}
				}
			}
		}

		//avanzo fila
		$nn++;
	}

	// Rename worksheet
	$spreadsheet->getActiveSheet()->setTitle('Resumen Hora');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$spreadsheet->setActiveSheetIndex(0);

	/**************************************************************************/
	//Nombre del archivo
	$filename = 'Informe Resumen Hora grupo '.$rowGrupo['Nombre'].' del equipo '.$rowEquipo['NombreEquipo'];
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
