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
$arrData = array();
$arrData[1] = "B";
$arrData[2] = "C";
$arrData[3] = "D";
$arrData[4] = "E";
$arrData[5] = "F";
$arrData[6] = "G";
$arrData[7] = "H";
$arrData[8] = "I";
$arrData[9] = "J";
$arrData[10] = "K";
$arrData[11] = "L";
$arrData[12] = "M";
$arrData[13] = "N";
$arrData[14] = "O";
$arrData[15] = "P";
$arrData[16] = "Q";
$arrData[17] = "R";
$arrData[18] = "S";
$arrData[19] = "T";
$arrData[20] = "U";
$arrData[21] = "V";
$arrData[22] = "W";
$arrData[23] = "X";
$arrData[24] = "Y";
$arrData[25] = "Z";
$arrData[26] = "AA";
$arrData[27] = "AB";
$arrData[28] = "AC";
$arrData[29] = "AD";
$arrData[30] = "AE";
$arrData[31] = "AF";
$arrData[32] = "AG";
$arrData[33] = "AH";
$arrData[34] = "AI";
$arrData[35] = "AJ";
$arrData[36] = "AK";
$arrData[37] = "AL";
$arrData[38] = "AM";
$arrData[39] = "AN";
$arrData[40] = "AO";
$arrData[41] = "AP";
$arrData[42] = "AQ";
$arrData[43] = "AR";
$arrData[44] = "AS";
$arrData[45] = "AT";
$arrData[46] = "AU";
$arrData[47] = "AV";
$arrData[48] = "AW";
$arrData[49] = "AX";
$arrData[50] = "AY";
$arrData[51] = "AZ";
$arrData[52] = "BA";
$arrData[53] = "BB";
$arrData[54] = "BC";
$arrData[55] = "BD";
$arrData[56] = "BE";
$arrData[57] = "BF";
$arrData[58] = "BG";
$arrData[59] = "BH";
$arrData[60] = "BI";

//Se consultan datos
$arrGruposRev = array();
$arrGruposRev = db_select_array (false, 'idGrupo, Valor, idSupervisado', 'telemetria_listado_grupos_uso', '', 'idSupervisado=1', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposRev');

/*******************************************************/
//Se arma la query con los datos justos recibidos
//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
$arrNombres = array();
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision.SensoresRevision_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
}
//Consultas
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision`        ON telemetria_listado_sensores_revision.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['idTelemetria'];
//Se traen todos los datos de la maquina
$rowMaquina = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), $form_trabajo);

//Armo la consulta
$subquery = '';
for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
	//recorro los grupos de los sensores que estan siendo supervisados
	foreach ($arrGruposRev as $sen) {
		//verifico que esten activos
		if(isset($rowMaquina['SensoresActivo_'.$i])&&$rowMaquina['SensoresActivo_'.$i]==1){
			//Reviso si el sensor esta siendo supervisado
			if(isset($rowMaquina['SensoresRevision_'.$i])&&$rowMaquina['SensoresRevision_'.$i]==1){
				//verifico que pertenezca al grupo actual
				if($rowMaquina['SensoresRevisionGrupo_'.$i]==$sen['idGrupo']){
					//guardo el nombre
					$arrNombres[$i]['SensorNombre'] = $rowMaquina['SensoresNombre_'.$i];

					//verifico que el valor sea igual o superior al establecido
					if(isset($_GET['Amp'])&&$_GET['Amp']!=''&&$_GET['Amp']!=0){$valor_amp=$_GET['Amp'];}else{$valor_amp=$sen['Valor'];}
					//Consulto el nombre del sensor

					//Consulto el valor minimo
					$subquery .= ',(SELECT Sensor_'.$i.'
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema ASC
					LIMIT 1) AS ValorMinimo_'.$i.'';
					$subquery .= ',(SELECT HoraSistema
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema ASC
					LIMIT 1) AS HoraMinimo_'.$i.'';

					//Consulto el valor maximo
					$subquery .= ',(SELECT Sensor_'.$i.'
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema DESC
					LIMIT 1) AS ValorMaximo_'.$i.'';
					$subquery .= ',(SELECT HoraSistema
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema DESC
					LIMIT 1) AS HoraMaximo_'.$i.'';

				}
			}
		}
	}
}
/**********************************************************/
//Se traen todos los registros entre las fechas
$arrMediciones = array();
$arrMediciones = db_select_array (false, 'Fecha AS FechaConsultada'.$subquery, 'telemetria_listado_historial_activaciones', '', 'idTelemetria='.$_GET['idTelemetria'].' AND Fecha BETWEEN "'.$_GET['F_inicio'].'" AND "'.$_GET['F_termino'].'" GROUP BY Fecha',  'Fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

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

//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Fecha');

$x = 1;
//Titulos de los sensores
for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
	if(isset($arrNombres[$i]['SensorNombre'])&&$arrNombres[$i]['SensorNombre']!=''){
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue($arrData[$x].'1', '');
					$x++;
	}
}

$nn=2;
foreach ($arrMediciones as $med) {
	//verifico si existen datos
	$exd = 0;
	for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
		if(isset($med['ValorMinimo_'.$i])){
			$exd++;
		}
	}
	if($exd>0){

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, fecha_estandar($med['FechaConsultada']));

        for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
			if(isset($med['ValorMinimo_'.$i])){
				$x = $i-1;
				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue($arrData[$x].$nn, DeSanitizar($arrNombres[$i]['SensorNombre']).' '.
							Cantidades_decimales_justos($med['ValorMinimo_'.$i]).' a las '.$med['HoraMinimo_'.$i].' '.
							Cantidades_decimales_justos($med['ValorMaximo_'.$i]).' a las '.$med['HoraMaximo_'.$i]
							);
			}
		}

		$nn++;
	}
}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Resumen');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Resumen Activaciones Sensores';
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


