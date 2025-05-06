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
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$SIS_where.= " AND ".$x_table.".Fecha BETWEEN '".$_GET['fecha_desde']."' AND '".$_GET['fecha_hasta']."'";
}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND ".$x_table.".idTelemetria='".$_GET['idTelemetria']."'";
}
/**********************************************************/
// Se trae un listado con todos los datos
$SIS_query = 
$x_table.'.Fecha,
'.$x_table.'.Hora,
'.$x_table.'.TimeStamp,
'.$x_table.'.Temperatura,
'.$x_table.'.PuntoRocio,
'.$x_table.'.PresionAtmos,
'.$x_table.'.HorasBajoGrados,
'.$x_table.'.Tiempo_Helada,
'.$x_table.'.Dias_acumulado,
'.$x_table.'.UnidadesFrio';
$SIS_join  = '';
$SIS_order = $x_table.'.Fecha ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, $x_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

//Variables
$arrMed  = array();
$counter = 0;
//recorro los datos
foreach ($arrMediciones as $med) {
	//verifico que exista fecha
	if(isset($med['Fecha'])&&$med['Fecha']!='0000-00-00'){
		//verifico cambio de dia
		if((isset($arrMed[$counter]['Fecha'])&&$arrMed[$counter]['Fecha']!=$med['Fecha']) OR $counter==0){
			$counter++;
		}

		//creo las variables si estas no existen
		if(!isset($arrMed[$counter]['Tiempo_Helada'])){  $arrMed[$counter]['Tiempo_Helada']  = 0;}
		if(!isset($arrMed[$counter]['Temp_Min'])){       $arrMed[$counter]['Temp_Min']       = 1000;}
		if(!isset($arrMed[$counter]['Temp_Max'])){       $arrMed[$counter]['Temp_Max']       = -1000;}

		//Guardo los datos
		$arrMed[$counter]['Fecha']        = $med['Fecha'];
		$arrMed[$counter]['UnidadesFrio'] = $med['UnidadesFrio'];
		$arrMed[$counter]['DiasAcum']     = $med['Dias_acumulado'];

		//verifico si hubo helada
		if(isset($med['Tiempo_Helada'])&&$med['Tiempo_Helada']!=''&&$med['Tiempo_Helada']!=0){
			//guardo el tiempo de helada
			$arrMed[$counter]['Tiempo_Helada'] = $arrMed[$counter]['Tiempo_Helada'] + $med['Tiempo_Helada']; 
		}
		//Guardo la temperatura Minima
		if(isset($med['Temperatura'])&&$med['Temperatura']<$arrMed[$counter]['Temp_Min']){
			$arrMed[$counter]['Temp_Min'] = $med['Temperatura'];
		}
		//Guardo la temperatura Maxima
		if(isset($med['Temperatura'])&&$med['Temperatura']>$arrMed[$counter]['Temp_Max']){
			$arrMed[$counter]['Temp_Max'] = $med['Temperatura'];
		}
	}
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
            ->setCellValue('A1', 'Mes')
            ->setCellValue('B1', 'Dia')
            ->setCellValue('C1', 'Helada')
            ->setCellValue('D1', 'Temperatura Minima')
            ->setCellValue('E1', 'Temperatura Maxima')
            ->setCellValue('F1', 'Duracion Helada')
            ->setCellValue('G1', 'Unidades Frio Acumuladas')
            ->setCellValue('H1', 'Unidades Frio Acumuladas')
            ->setCellValue('I1', 'Dias Grado Acumuladas')
            ->setCellValue('J1', 'Dias Grado Acumuladas');

 
$nn       = 2;
$unifrio  = 0;
$diasAcum = 0;
foreach ($arrMed as $key => $med){
	//verifico helada
	if(isset($med['Tiempo_Helada'])&&$med['Tiempo_Helada']!=0){$helada = 'Si';}else{$helada = 'No';}
	if($unifrio==0){
		$unfrio=$med['UnidadesFrio'];
		$unifrio=$med['UnidadesFrio'];
	}else{
		$unfrio=$med['UnidadesFrio']-$unifrio;
		$unifrio=$med['UnidadesFrio'];
	}
	if($diasAcum==0){
		$diaAcum=$med['DiasAcum'];
		$diasAcum=$med['DiasAcum'];
	}else{
		$diaAcum=$med['DiasAcum']-$diasAcum;
		$diasAcum=$med['DiasAcum'];
	}
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, numero_a_mes(fecha2NMes($med['Fecha'])))
				->setCellValue('B'.$nn, fecha2NdiaMes($med['Fecha']))
				->setCellValue('C'.$nn, $helada)
				->setCellValue('D'.$nn, $med['Temp_Min'])
				->setCellValue('E'.$nn, $med['Temp_Max'])
				->setCellValue('F'.$nn, minutos2horas($med['Tiempo_Helada']*60))
				->setCellValue('G'.$nn, cantidades($unfrio, 0))
				->setCellValue('H'.$nn, cantidades($med['UnidadesFrio'], 0))
				->setCellValue('I'.$nn, cantidades($diaAcum, 0))
				->setCellValue('J'.$nn, cantidades($med['DiasAcum'], 0)); 					
							
	$nn++;
					
}




// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Informe Ejecutivo');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Informe Ejecutivo';
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
