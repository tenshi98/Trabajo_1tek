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

	/****************************************************************/
	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
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
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
	$SIS_order = 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');
	/*************************************************************************/
	//busco los grupos disponibles
	$arrSubgrupos = array();
	$SIS_where    = 'idGrupo=0';
	foreach ($arrEquipos as $fac) {
		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			$arrSubgrupos[$fac['SensoresGrupo_'.$x]]['idGrupo'] = $fac['SensoresGrupo_'.$x];
		}
	}
	foreach($arrSubgrupos as $categoria=>$sub){
		//verifico si existe
		if(isset($sub['idGrupo'])&&$sub['idGrupo']!=''){
			$SIS_where .= ' OR idGrupo='.$sub['idGrupo'];
		}
	}

	//consulto grupos
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_where, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
	//consulto unidad de medida
	$rowUnimed = db_select_data (false, 'idUniMed, Nombre', 'telemetria_listado_unidad_medida', '', 'idUniMed='.$_GET['idUniMed'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowUnimed');

	/*************************************************************************/
	//se arman datos
	$arrTitulo  = array();
	//se crean variables vacias
	for ($i = 1; $i <= 20; $i++) {
		$arrTitulo[$i]['Nombre'] = '';
	}
	//se buscan datos
	$n          = 1;
	foreach ($arrGrupos as $gru) {
		$arrTitulo[$n]['Nombre'] = $gru['Nombre'];
		$n++;
	}
	$arrData    = array();
	$n1         = 1;

	foreach ($arrEquipos as $fac) {
		//se crean variables vacias
		for ($i = 1; $i <= 20; $i++) {
			$arrData[$n1][$i]['Dato'] = '';
		}
		//numero sensores equipo
		$arrDato  = array();
		$Dato     = 0;
		$Dato_N   = 0;
		$n2       = 1;

		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			//Que el valor medido sea distinto de 999
			if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
				//verifico si el grupo existe
				if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){
					if($fac['SensoresUniMed_'.$x]==$_GET['idUniMed']&&$fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
						$Dato = $Dato + $fac['SensorValue_'.$x];
						$Dato_N++;
					}
				}else{
					if($fac['SensoresUniMed_'.$x]==$_GET['idUniMed']){
						//verifico que exista
						if(isset($arrDato[$fac['SensoresGrupo_'.$x]]['Valor'])&&$arrDato[$fac['SensoresGrupo_'.$x]]['Valor']!=''){
							$arrDato[$fac['SensoresGrupo_'.$x]]['Valor'] = $arrDato[$fac['SensoresGrupo_'.$x]]['Valor'] + $fac['SensorValue_'.$x];
							$arrDato[$fac['SensoresGrupo_'.$x]]['Cuenta']++;
						}else{
							$arrDato[$fac['SensoresGrupo_'.$x]]['Valor'] = $fac['SensorValue_'.$x];
							$arrDato[$fac['SensoresGrupo_'.$x]]['Cuenta'] = 1;
						}
					}
				}
			}
		}

		//verifico si el grupo existe
		if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){
			if($Dato_N!=0){  $New_Dato = $Dato/$Dato_N; }else{$New_Dato = 0;}

			$arrData[$n1]['FechaSistema']  = fecha_estandar($fac['FechaSistema']);
			$arrData[$n1]['HoraSistema']   = $fac['HoraSistema'];
			$arrData[$n1][$n2]['Dato']     = cantidades($New_Dato, 2);
			$n2++;

		}else{
			$arrData[$n1]['FechaSistema']  = fecha_estandar($fac['FechaSistema']);
			$arrData[$n1]['HoraSistema']   = $fac['HoraSistema'];
			foreach ($arrGrupos as $gru) {
				if(isset($arrDato[$gru['idGrupo']]['Cuenta'])&&$arrDato[$gru['idGrupo']]['Cuenta']!=0){
					$New_Dato = $arrDato[$gru['idGrupo']]['Valor']/$arrDato[$gru['idGrupo']]['Cuenta'];
					$arrData[$n1][$n2]['Dato'] = cantidades($New_Dato, 2);
				}else{
					$arrData[$n1][$n2]['Dato'] = 0;
				}
				$n2++;
			}
		}
		$n1++;
	}

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
				->setCellValue('C1', DeSanitizar($arrTitulo[1]['Nombre']))
				->setCellValue('D1', DeSanitizar($arrTitulo[2]['Nombre']))
				->setCellValue('E1', DeSanitizar($arrTitulo[3]['Nombre']))
				->setCellValue('F1', DeSanitizar($arrTitulo[4]['Nombre']))
				->setCellValue('G1', DeSanitizar($arrTitulo[5]['Nombre']))
				->setCellValue('H1', DeSanitizar($arrTitulo[6]['Nombre']))
				->setCellValue('I1', DeSanitizar($arrTitulo[7]['Nombre']))
				->setCellValue('J1', DeSanitizar($arrTitulo[8]['Nombre']))
				->setCellValue('K1', DeSanitizar($arrTitulo[9]['Nombre']))
				->setCellValue('L1', DeSanitizar($arrTitulo[10]['Nombre']))
				->setCellValue('M1', DeSanitizar($arrTitulo[11]['Nombre']))
				->setCellValue('N1', DeSanitizar($arrTitulo[12]['Nombre']))
				->setCellValue('O1', DeSanitizar($arrTitulo[13]['Nombre']))
				->setCellValue('P1', DeSanitizar($arrTitulo[14]['Nombre']))
				->setCellValue('Q1', DeSanitizar($arrTitulo[15]['Nombre']))
				->setCellValue('R1', DeSanitizar($arrTitulo[16]['Nombre']))
				->setCellValue('S1', DeSanitizar($arrTitulo[17]['Nombre']))
				->setCellValue('T1', DeSanitizar($arrTitulo[18]['Nombre']))
				->setCellValue('U1', DeSanitizar($arrTitulo[19]['Nombre']))
				->setCellValue('V1', DeSanitizar($arrTitulo[20]['Nombre']));

	$nn = 2;
	$nw = 1;
	foreach ($arrEquipos as $fac) {

		$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, $arrData[$nw]['FechaSistema'])
				->setCellValue('B'.$nn, $arrData[$nw]['HoraSistema'])
				->setCellValue('C'.$nn, DeSanitizar($arrData[$nw][1]['Dato']))
				->setCellValue('D'.$nn, DeSanitizar($arrData[$nw][2]['Dato']))
				->setCellValue('E'.$nn, DeSanitizar($arrData[$nw][3]['Dato']))
				->setCellValue('F'.$nn, DeSanitizar($arrData[$nw][4]['Dato']))
				->setCellValue('G'.$nn, DeSanitizar($arrData[$nw][5]['Dato']))
				->setCellValue('H'.$nn, DeSanitizar($arrData[$nw][6]['Dato']))
				->setCellValue('I'.$nn, DeSanitizar($arrData[$nw][7]['Dato']))
				->setCellValue('J'.$nn, DeSanitizar($arrData[$nw][8]['Dato']))
				->setCellValue('K'.$nn, DeSanitizar($arrData[$nw][9]['Dato']))
				->setCellValue('L'.$nn, DeSanitizar($arrData[$nw][10]['Dato']))
				->setCellValue('M'.$nn, DeSanitizar($arrData[$nw][11]['Dato']))
				->setCellValue('N'.$nn, DeSanitizar($arrData[$nw][12]['Dato']))
				->setCellValue('O'.$nn, DeSanitizar($arrData[$nw][13]['Dato']))
				->setCellValue('P'.$nn, DeSanitizar($arrData[$nw][14]['Dato']))
				->setCellValue('Q'.$nn, DeSanitizar($arrData[$nw][15]['Dato']))
				->setCellValue('R'.$nn, DeSanitizar($arrData[$nw][16]['Dato']))
				->setCellValue('S'.$nn, DeSanitizar($arrData[$nw][17]['Dato']))
				->setCellValue('T'.$nn, DeSanitizar($arrData[$nw][18]['Dato']))
				->setCellValue('U'.$nn, DeSanitizar($arrData[$nw][19]['Dato']))
				->setCellValue('V'.$nn, DeSanitizar($arrData[$nw][20]['Dato']));

		$nn++;
		$nw++;
	}


	// Rename worksheet
	$spreadsheet->getActiveSheet()->setTitle('Trazabilidad Planta');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$spreadsheet->setActiveSheetIndex(0);

	/**************************************************************************/
	//Nombre del archivo
	$filename = 'Informe Trazabilidad Planta del equipo '.$rowEquipo['NombreEquipo'];
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
