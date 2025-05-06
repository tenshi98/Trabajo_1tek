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
//Calculo del limit
$set_lim = (5000*$_GET['num'])-4999;
/*******************************************************************************/
//Variables
$xx = 1;
$arrData = array();
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
/*******************************************************************************/
// Se trae un listado con todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');
$arrGrupo = array();
$arrGrupo = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

//Creo un arreglo con los datos
$arrUni = array();
foreach ($arrUnimed as $uni) {
	$arrUni[$uni['idUniMed']] = $uni['Nombre'];
}
//Creo un arreglo con los datos
$arrGru = array();
foreach ($arrGrupo as $uni) {
	$arrGru[$uni['idGrupo']] = $uni['Nombre'];
}
/*******************************************************************************/
//Funcion para escribir datos
function crear_data($limite, $idTelemetria, $f_inicio, $f_termino, $dbConn ) {

	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensorUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensorGrupo_'.$i;
		$subquery .= ',telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.' AS SensorValue_'.$i;
	}
	//Se traen todos los registros
	$SIS_query = '
	telemetria_listado.Nombre AS NombreEquipo,
	telemetria_listado.GeoLatitud AS GeoLatitudEquipo,
	telemetria_listado.GeoLongitud AS GeoLongitudEquipo,
	telemetria_listado.GeoVelocidad AS GeoVelocidadEquipo,
	telemetria_listado.GeoDireccion AS GeoDireccionEquipo,
	telemetria_listado.GeoMovimiento AS GeoMovimientoEquipo,
	telemetria_listado.cantSensores,
	telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTabla,
	telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema,
	telemetria_listado_tablarelacionada_'.$idTelemetria.'.HoraSistema'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado`                  ON telemetria_listado.idTelemetria                   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria';
	$SIS_where = '(telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema BETWEEN "'.$f_inicio.'" AND "'.$f_termino.'")';
	$SIS_order = 'telemetria_listado.Nombre ASC LIMIT '.$limite.', 5000';
	$arrRutas = array();
	$arrRutas = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRutas');

	return $arrRutas;

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

/*********************************************************************************/
//Verifico si se selecciono el equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	//Variable temporal
	$arrTemporal = array();
	//Llamo a la funcion
	$arrTemporal = crear_data($set_lim, $_GET['idTelemetria'], $_GET['f_inicio'], $_GET['f_termino'] , $dbConn);

	/***********************************************************/
	//Grupos de los sensores
	for ($i = 6; $i <= $arrTemporal[0]['cantSensores']; $i++) {
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue($arrData[$i].'1', DeSanitizar($arrGru[$arrTemporal[0]['SensorGrupo_'.$i]]));
	}

	/***********************************************************/
	//Titulo columnas
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A2', 'Equipo')
				->setCellValue('B2', 'Fecha')
				->setCellValue('C2', 'Hora')
				->setCellValue('D2', 'Latitud')
				->setCellValue('E2', 'Longitud')
				->setCellValue('F2', 'Velocidad')
				->setCellValue('G2', 'Dirección')
				->setCellValue('H2', 'Movimiento');

	for ($i = 6; $i <= $arrTemporal[0]['cantSensores']; $i++) {
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue($arrData[$i].'2', DeSanitizar($arrTemporal[0]['SensorNombre_'.$i]).' ('.DeSanitizar($arrUni[$arrTemporal[0]['SensorUniMed_'.$i]]).')');
	}

	/***********************************************************/
	//Datos
	$nn=3;
	foreach ($arrTemporal as $rutas) {

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, $rutas['idTabla'].' - '.DeSanitizar($rutas['NombreEquipo']))
					->setCellValue('B'.$nn, fecha_estandar($rutas['FechaSistema']))
					->setCellValue('C'.$nn, $rutas['HoraSistema'])
					->setCellValue('D'.$nn, $rutas['GeoLatitudEquipo'])
					->setCellValue('E'.$nn, $rutas['GeoLongitudEquipo'])
					->setCellValue('F'.$nn, $rutas['GeoVelocidadEquipo'])
					->setCellValue('G'.$nn, $rutas['GeoDireccionEquipo'])
					->setCellValue('H'.$nn, $rutas['GeoMovimientoEquipo']);

		for ($i = 6; $i <= $arrTemporal[0]['cantSensores']; $i++) {
			$xdata = Cantidades_decimales_justos($rutas['SensorValue_'.$i]);
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue($arrData[$i].$nn, $xdata);
		}

		$nn++;

	}
	/***********************************************************/
	// Rename worksheet
	$super_titulo = 'Hoja 1';
	if(isset($arrTemporal[0]['NombreEquipo'])&&$arrTemporal[0]['NombreEquipo']!=''){
		$super_titulo = cortar(DeSanitizar($arrTemporal[0]['NombreEquipo']), 25);
	}
	$spreadsheet->getActiveSheet(0)->setTitle($super_titulo);

//Si no se slecciono se traen todos los equipos a los cuales tiene permiso
}else{
	//Inicia variable
	$SIS_where = "telemetria_listado.idTelemetria>0";
	$SIS_where.= " AND telemetria_listado.id_Geo='1'";
	$SIS_where.= " AND telemetria_listado.idSistema=".$_GET['idSistema'];

	//Verifico el tipo de usuario que esta ingresando
	$SIS_join  = '';
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$SIS_join .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where.= " AND usuarios_equipos_telemetria.idUsuario=".$_GET['idUsuario'];
	}

	/*********************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = 'telemetria_listado.idTelemetria,telemetria_listado.Nombre';
	$SIS_order = 'idTelemetria ASC';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

	/*********************************************/
	$sheet = 0;
	foreach ($arrEquipos as $equipo) {
		//Variable temporal
		$arrTemporal = array();
		//Se crea nueva hoja
		$spreadsheet->createSheet();
		//Llamo a la funcion
		$arrTemporal = crear_data($set_lim, $equipo['idTelemetria'], $_GET['f_inicio'], $_GET['f_termino'] , $dbConn);

		/***********************************************************/
		//Grupos de los sensores
		for ($i = 6; $i <= $arrTemporal[0]['cantSensores']; $i++) {
			$spreadsheet->setActiveSheetIndex($sheet)
						->setCellValue($arrData[$i].'1', DeSanitizar($arrGru[$arrTemporal[0]['SensorGrupo_'.$i]]));
		}

		/***********************************************************/
		//Titulo columnas
		$spreadsheet->setActiveSheetIndex($sheet)
					->setCellValue('A2', 'Equipo')
					->setCellValue('B2', 'Fecha')
					->setCellValue('C2', 'Hora')
					->setCellValue('D2', 'Latitud')
					->setCellValue('E2', 'Longitud')
					->setCellValue('F2', 'Velocidad')
					->setCellValue('G2', 'Dirección')
					->setCellValue('H2', 'Movimiento');

		for ($i = 6; $i <= $arrTemporal[0]['cantSensores']; $i++) {
			$spreadsheet->setActiveSheetIndex($sheet)
						->setCellValue($arrData[$i].'2', DeSanitizar($arrTemporal[0]['SensorNombre_'.$i]).' ('.DeSanitizar($arrUni[$arrTemporal[0]['SensorUniMed_'.$i]]).')');
		}

		/***********************************************************/
		//Datos
		$nn=3;
		foreach ($arrTemporal as $rutas) {

			$spreadsheet->setActiveSheetIndex($sheet)
						->setCellValue('A'.$nn, $rutas['idTabla'].' - '.DeSanitizar($rutas['NombreEquipo']))
						->setCellValue('B'.$nn, fecha_estandar($rutas['FechaSistema']))
						->setCellValue('C'.$nn, $rutas['HoraSistema'])
						->setCellValue('D'.$nn, $rutas['GeoLatitudEquipo'])
						->setCellValue('E'.$nn, $rutas['GeoLongitudEquipo'])
						->setCellValue('F'.$nn, $rutas['GeoVelocidadEquipo'])
						->setCellValue('G'.$nn, $rutas['GeoDireccionEquipo'])
						->setCellValue('H'.$nn, $rutas['GeoMovimientoEquipo']);

			for ($i = 6; $i <= $arrTemporal[0]['cantSensores']; $i++) {
				$xdata = Cantidades_decimales_justos($rutas['SensorValue_'.$i]);
				$spreadsheet->setActiveSheetIndex($sheet)
							->setCellValue($arrData[$i].$nn, $xdata);
			}

			$nn++;

		}
		/***********************************************************/
		// Rename worksheet
		$super_titulo = 'Hoja 1';
		if(isset($arrTemporal[0]['NombreEquipo'])&&$arrTemporal[0]['NombreEquipo']!=''){
			$super_titulo = cortar(DeSanitizar($arrTemporal[0]['NombreEquipo']), 25);
		}
		$spreadsheet->getActiveSheet($sheet)->setTitle($super_titulo);

		$sheet++;
	}
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Exportar Datos archivo '.$_GET['num'];
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
