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
//obtengo los datos de la empresa
$rowEmpresa = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema='.$_GET['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');

$SIS_where = 'trabajadores_listado.idSistema='.$_GET['idSistema'];
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$SIS_where .=" AND trabajadores_listado.idTrabajador='".$_GET['idTrabajador']."'";
}

//se traen lo datos del equipo
$SIS_query = '
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Rut AS TrabajadorRut,
trabajadores_listado.idTrabajador AS ID,
(SELECT Hora FROM `trabajadores_asistencias_predios` WHERE idTrabajador=ID AND idEstado=1 AND Fecha= "'.$_GET['Fecha'].'" LIMIT 1) AS Ingreso,
(SELECT Hora FROM `trabajadores_asistencias_predios` WHERE idTrabajador=ID AND idEstado=2 AND Fecha= "'.$_GET['Fecha'].'" LIMIT 1) AS Egreso';
$SIS_join  = '';
$SIS_order  = 'ApellidoPat ASC, ApellidoMat ASC';
$arrAsistencias = array();
$arrAsistencias = db_select_array (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAsistencias');

/**********************************************************************************************************************************/
/*                                                          Ejecucion                                                             */
/**********************************************************************************************************************************/
// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator(DeSanitizar($rowEmpresa['Nombre']))
			->setLastModifiedBy(DeSanitizar($rowEmpresa['Nombre']))
			->setTitle("Office 2007")
			->setSubject("Office 2007")
			->setDescription("Document for Office 2007")
			->setKeywords("office 2007")
			->setCategory("office 2007 result file");
      
//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Trabajador')
            ->setCellValue('B1', 'Rut')
            ->setCellValue('C1', 'Fecha')
            ->setCellValue('D1', 'Ingreso')
            ->setCellValue('E1', 'Egreso');

$nn=2;
foreach ($arrAsistencias as $con) { 
		
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($con['TrabajadorApellidoPat'].' '.$con['TrabajadorApellidoMat'].' '.$con['TrabajadorNombre']))
				->setCellValue('B'.$nn, DeSanitizar($con['TrabajadorRut']))
				->setCellValue('C'.$nn, fecha_estandar($_GET['Fecha']))
				->setCellValue('D'.$nn, $con['Ingreso'])
				->setCellValue('E'.$nn, $con['Egreso']);
							
	$nn++;		
		
}		




// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Asistencias');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Informe Asistencias';
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
