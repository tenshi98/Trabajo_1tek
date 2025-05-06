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
/**********************************************************/
//Seleccionar la tabla
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$x_table = 'telemetria_listado_aux_equipo';
}else{
	$x_table = 'telemetria_listado_aux';
}
//se verifica si se ingreso la hora, es un dato optativo
$SIS_where = $x_table.".idSistema=".$_GET['idSistema'];
//Se aplican los filtros
if(isset($_GET['fecha'])&&$_GET['fecha']!=''){

	//Se organizan los datos
	$Fecha     = $_GET['fecha'];
	$Hora      = '20:00:00';
	$FechaSig  = sumarDias($_GET['fecha'], 1);
	$HoraSig   = '09:00:00';

	//se crea query
	$SIS_where.= " AND (".$x_table.".TimeStamp BETWEEN '".$Fecha." ".$Hora ."' AND '".$FechaSig." ".$HoraSig."')";

}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND ".$x_table.".idTelemetria='".$_GET['idTelemetria']."'";
}
/**********************************************************/
// Se trae un listado con todos los datos
$SIS_query = 'Fecha, Hora, HeladaDia, HeladaHora, Temperatura, Helada, CrossTech_TempMin ,
Fecha_Anterior, Hora_Anterior, Tiempo_Helada';
$SIS_join  = '';
$SIS_order = 'idAuxiliar ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, $x_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/****************************************************************************/
$arrEvento = array();
$nevento   = 0;
//Se busca la temperatura real
foreach($arrHistorial as $hist2) {
	//verifico que exista fecha
	if(isset($hist2['Fecha'])&&$hist2['Fecha']!='0000-00-00'){
		//se obtiene la hora
		if(isset($hist2['Temperatura'])&&$hist2['Temperatura']<=$hist2['CrossTech_TempMin']){

			//se crean variables en caso de no existir
			if(!isset($arrEvento[$nevento]['TempMinima'])){  $arrEvento[$nevento]['TempMinima']  = 1000;}
			if(!isset($arrEvento[$nevento]['TempMaxima'])){  $arrEvento[$nevento]['TempMaxima']  = -1000;}
			if(!isset($arrEvento[$nevento]['TempSum'])){     $arrEvento[$nevento]['TempSum']  = 0;}
			if(!isset($arrEvento[$nevento]['TempCuenta'])){  $arrEvento[$nevento]['TempCuenta']  = 0;}
			if(!isset($arrEvento[$nevento]['Minutos'])){     $arrEvento[$nevento]['Minutos']  = 0;}
			if(!isset($arrEvento[$nevento]['FechaInicio'])){ $arrEvento[$nevento]['FechaInicio'] = $hist2['Fecha'];}
			if(!isset($arrEvento[$nevento]['HoraInicio'])){  $arrEvento[$nevento]['HoraInicio']  = $hist2['Hora'];}

			$arrEvento[$nevento]['FechaTermino'] = $hist2['Fecha'];
			$arrEvento[$nevento]['HoraTermino']  = $hist2['Hora'];
			$arrEvento[$nevento]['TempSum']      = $arrEvento[$nevento]['TempSum'] + $hist2['Temperatura'];
			$arrEvento[$nevento]['TempCuenta']   = $arrEvento[$nevento]['TempCuenta'] + 1;
			$arrEvento[$nevento]['TempProm']     = $arrEvento[$nevento]['TempSum']/$arrEvento[$nevento]['TempCuenta'];
			$arrEvento[$nevento]['Minutos']      = $arrEvento[$nevento]['Minutos'] + $hist2['Tiempo_Helada'];

			//Guardo la temperatura Minima
			if(isset($hist2['Temperatura'])&&$hist2['Temperatura']<$arrEvento[$nevento]['TempMinima']){
				$arrEvento[$nevento]['TempMinima'] = $hist2['Temperatura'];
			}
			//Guardo la temperatura Maxima
			if(isset($hist2['Temperatura'])&&$hist2['Temperatura']>$arrEvento[$nevento]['TempMaxima']){
				$arrEvento[$nevento]['TempMaxima'] = $hist2['Temperatura'];
			}

		}else{
			$nevento++;
		}
	}
}
/***********************************************************/
$arrResumen               = array();
$arrResumen['Tiempo']     = 0;
$arrResumen['TempMinima'] = 0;
foreach ($arrEvento as $key => $eve){
	//comparo temperaturas
	if($arrResumen['TempMinima']>$eve['TempMinima']){
		$arrResumen['TempMinima']      = $eve['TempMinima'];
		//guardo los otros datos
		if(!isset($arrResumen['Duracion'])OR $arrResumen['Duracion']==''){              $arrResumen['Duracion']        = $eve['Minutos'];}
		if(!isset($arrResumen['HoraTempMinima'])OR $arrResumen['HoraTempMinima']==''){  $arrResumen['HoraTempMinima']  = $eve['HoraInicio'];}
	}
	//tiempo total de la helada
	$arrResumen['Tiempo'] = $arrResumen['Tiempo'] + $eve['Minutos'];
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
            ->setCellValue('A1', 'Temperatura Minima')
            ->setCellValue('B1', 'Duracion Temp Min')
            ->setCellValue('C1', 'Hora Temp Minima')
            ->setCellValue('D1', 'Tiempo bajo '.$arrHistorial[0]['CrossTech_TempMin'].'°C');

$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A2', $arrResumen['TempMinima'].'°C')
			->setCellValue('B2', $arrResumen['Duracion'].'Horas')
			->setCellValue('C2', $arrResumen['HoraTempMinima'])
			->setCellValue('D2', Cantidades($arrResumen['Tiempo'], 0).' Horas');

$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Inicio')
            ->setCellValue('B4', 'Termino')
            ->setCellValue('C4', 'Temperatura Minima (°C)')
            ->setCellValue('D4', 'Temperatura Maxima (°C)')
            ->setCellValue('E4', 'Temperatura Promedio (°C)')
            ->setCellValue('F4', 'Duracion (horas)');

$nn       = 5;
foreach ($arrEvento as $key => $eve){
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, $eve['HoraInicio'].' - '.fecha_estandar($eve['FechaInicio']))
				->setCellValue('B'.$nn, $eve['HoraTermino'].' - '.fecha_estandar($eve['FechaTermino']))
				->setCellValue('C'.$nn, Cantidades($eve['TempMinima'], 2))
				->setCellValue('D'.$nn, Cantidades($eve['TempMaxima'], 2))
				->setCellValue('E'.$nn, Cantidades($eve['TempProm'], 2))
				->setCellValue('F'.$nn, $eve['Minutos']);

	$nn++;
}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Resumen Heladas');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Resumen Heladas';
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
