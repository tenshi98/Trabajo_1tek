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
$SIS_where = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema!="0000-00-00"';
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .=" AND (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{

	//variables
	$arrData = array();
	$xx = 1;
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
	$arrData[$xx] = "CY";$xx++;
	$arrData[$xx] = "CZ";$xx++;
	$arrData[$xx] = "DA";$xx++;
	$arrData[$xx] = "DB";$xx++;
	$arrData[$xx] = "DC";$xx++;
	$arrData[$xx] = "DD";$xx++;
	$arrData[$xx] = "DE";$xx++;
	$arrData[$xx] = "DF";$xx++;
	$arrData[$xx] = "DG";$xx++;
	$arrData[$xx] = "DH";$xx++;
	$arrData[$xx] = "DI";$xx++;
	$arrData[$xx] = "DJ";$xx++;
	$arrData[$xx] = "DK";$xx++;
	$arrData[$xx] = "DL";$xx++;
	$arrData[$xx] = "DM";$xx++;
	$arrData[$xx] = "DN";$xx++;
	$arrData[$xx] = "DO";$xx++;
	$arrData[$xx] = "DP";$xx++;
	$arrData[$xx] = "DQ";$xx++;
	$arrData[$xx] = "DR";$xx++;
	$arrData[$xx] = "DS";$xx++;
	$arrData[$xx] = "DT";$xx++;
	$arrData[$xx] = "DU";$xx++;
	$arrData[$xx] = "DV";$xx++;
	$arrData[$xx] = "DW";$xx++;
	$arrData[$xx] = "DX";$xx++;
	$arrData[$xx] = "DY";$xx++;
	$arrData[$xx] = "DZ";$xx++;

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
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado.idTelemetria';
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		//Verifico la unidad de medida
		if(isset($rowEquipo['SensoresUniMed_'.$i])&&$rowEquipo['SensoresUniMed_'.$i]==12){
			$consql .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
	}
	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = 'FechaSistema, HoraSistema'.$consql;
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/**********************************************************************/
	//Se traen todos los grupos
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupo');

	//guardo los grupos
	$Grupo = array();
	foreach ($arrGrupo as $sen) {
		$Grupo[$sen['idGrupo']] = $sen['Nombre'];
	}

	/****************************************************************/
	//Variables
	$m_table_title  = '';
	$m_table        = '';
	$arrTableTemp   = array();
	$arrTableTemp2  = array();
	$arrTableTemp3  = array();
	$arrTable       = array();
	$arrTable2      = array();
	$arrTable3      = array();

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

	//titulo
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A1', 'Fecha Inicio')
				->setCellValue('B1', 'Hora Inicio')
				->setCellValue('C1', 'Fecha Termino')
				->setCellValue('D1', 'Hora Termino')
				->setCellValue('E1', 'Duracion');

	//titulo de la tabla
	$x = 1;
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		//Verifico la unidad de medida
		if(isset($rowEquipo['SensoresUniMed_'.$i])&&$rowEquipo['SensoresUniMed_'.$i]==12){
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($arrData[$x].'1', $Grupo[$rowEquipo['SensoresGrupo_'.$i]]);
				$x++;
				$arrTableTemp[$i] = 99999;//se resetea
			}
		}
	}

	//variables
	$posit           = 0;
	$Ult_diaInicio   = '';
	$Ult_diaTermino  = '';
	$Ult_horaInicio  = '';
	$Ult_horaTermino = '';
	$Maincount       = 0;

	//se arman datos
	foreach ($arrEquipos as $fac) {
		//variable
		$count  = 0;
		$count2 = 0;
		//recorro los sensores
		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			//Verifico la unidad de medida
			if(isset($rowEquipo['SensoresUniMed_'.$x])&&$rowEquipo['SensoresUniMed_'.$x]==12){
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($rowEquipo['SensoresActivo_'.$x])&&$rowEquipo['SensoresActivo_'.$x]==1){
					//Que el valor medido sea distinto de 999
					if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
						//verifico si hay cambios en el valor
						if($arrTableTemp[$x]!=$fac['SensorValue_'.$x]){
							//cuento
							$count++;
							//guardo dato de la tabla
							switch ($fac['SensorValue_'.$x]) {
								case 1: $arrTableTemp2[$count] = 'Cerrado'; break;
								case 0: $arrTableTemp2[$count] = 'Abierto'; break;
							}
							//guardo el valor para el proximo bucle
							$arrTableTemp[$x] = $fac['SensorValue_'.$x];
						}else{
							//cuento
							$count2++;
							//guardo dato de la tabla
							switch ($fac['SensorValue_'.$x]) {
								case 0: $arrTableTemp3[$count2] = 'Cerrado'; break;
								case 1: $arrTableTemp3[$count2] = 'Abierto'; break;
							}
							//guardo el valor para el proximo bucle
							$arrTableTemp[$x] = $fac['SensorValue_'.$x];
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

			//recorro
			$arrTable[$posit]['FechaDesde'] = $diaInicio;
			$arrTable[$posit]['FechaHasta'] = $diaTermino;
			$arrTable[$posit]['HoraDesde']  = $horaInicio;
			$arrTable[$posit]['HoraHasta']  = $horaTermino;
			$arrTable[$posit]['Duracion']   = $HorasTrans;
			for ($x = 1; $x <= $count; $x++) {
				$arrTable2[$posit][$x]['Contenido'] = $arrTableTemp2[$x];
			}

			//cuento
			$posit++;
			$Maincount = $count;

			//Guardo el ultimo registro
			$Ult_diaInicio   = $fac['FechaSistema'];
			$Ult_horaInicio  = $fac['HoraSistema'];

		}

		//Guardo el ultimo registro
		$Ult_diaTermino  = $fac['FechaSistema'];
		$Ult_horaTermino = $fac['HoraSistema'];
		//recorrer
		for ($x = 1; $x <= $Maincount; $x++) {
			$arrTable3[$x]['Contenido']  = $arrTableTemp3[$x];
		}

	}

	/****************************************************************/
	//conteo
	$nn=2;
	//recorro los registros
	for ($y = 1; $y < $posit; $y++) {

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, $arrTable[$y]['FechaDesde'])
					->setCellValue('B'.$nn, $arrTable[$y]['HoraDesde'])
					->setCellValue('C'.$nn, $arrTable[$y]['FechaHasta'])
					->setCellValue('D'.$nn, $arrTable[$y]['HoraHasta'])
					->setCellValue('E'.$nn, $arrTable[$y]['Duracion']);

		for ($x = 1; $x <= $Maincount; $x++) {
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue($arrData[$x].$nn, DeSanitizar($arrTable2[$y][$x]['Contenido']));
		}

		$nn++;
	}

	/*****************************************************************/
	//Verifico si existe
	if(isset($Ult_diaInicio)&&$Ult_diaInicio!=''&&$Ult_diaInicio!='0000-00-00'){
		$HorasTrans  = horas_transcurridas($Ult_diaInicio, $Ult_diaTermino, $Ult_horaInicio, $Ult_horaTermino);
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, $Ult_diaInicio)
					->setCellValue('B'.$nn, $Ult_horaInicio)
					->setCellValue('C'.$nn, $Ult_diaTermino)
					->setCellValue('D'.$nn, $Ult_horaTermino)
					->setCellValue('E'.$nn, $HorasTrans);

		for ($x = 1; $x <= $Maincount; $x++) {
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue($arrData[$x].$nn, DeSanitizar($arrTable3[$x]['Contenido']));
		}
	}

	// Rename worksheet
	$spreadsheet->getActiveSheet()->setTitle(DeSanitizar($rowEquipo['NombreEquipo']));

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$spreadsheet->setActiveSheetIndex(0);

	/**************************************************************************/
	//Nombre del archivo
	$filename = 'Informe equipo '.$rowEquipo['NombreEquipo'];
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
