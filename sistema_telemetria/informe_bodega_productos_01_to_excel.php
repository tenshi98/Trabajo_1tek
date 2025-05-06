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

/*******************************************************/
// consulto los datos
$SIS_query = '
productos_listado.StockLimite,
productos_listado.ValorIngreso,
productos_listado.Nombre AS NombreProd,
sistema_productos_uml.Nombre AS UnidadMedida,
(SELECT SUM(Cantidad_ing) FROM bodegas_productos_facturacion_existencias WHERE idProducto = productos_listado.idProducto AND idBodega='.$_GET['idBodega'].'  LIMIT 1) AS stock_entrada,
(SELECT SUM(Cantidad_eg) FROM bodegas_productos_facturacion_existencias  WHERE idProducto = productos_listado.idProducto AND idBodega='.$_GET['idBodega'].' LIMIT 1) AS stock_salida,
(SELECT Nombre FROM bodegas_productos_listado WHERE idBodega='.$_GET['idBodega'].' LIMIT 1) AS NombreBodega';
$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
$SIS_where = 'productos_listado.idProducto!=0';
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

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
            ->setCellValue('A1', 'Alertas')
            ->setCellValue('B1', 'Nombre')
            ->setCellValue('C1', 'Stock Min')
            ->setCellValue('D1', 'Stock Actual')
            ->setCellValue('E1', 'Unidad de Medida')
            ->setCellValue('F1', 'V/Unitario')
            ->setCellValue('G1', 'V/Total');

$nn=2;
foreach ($arrProductos as $productos) {
	$stock_actual = $productos['stock_entrada'] - $productos['stock_salida'];
	if ($stock_actual!=0){
		if ($productos['StockLimite']>$stock_actual){$delta = 'Stock Bajo';}else{$delta = '';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, DeSanitizar($delta))
					->setCellValue('B'.$nn, DeSanitizar($productos['NombreProd']))
					->setCellValue('C'.$nn, cantidades_excel($productos['StockLimite']))
					->setCellValue('D'.$nn, cantidades_excel($stock_actual))
					->setCellValue('E'.$nn, DeSanitizar($productos['UnidadMedida']))
					->setCellValue('F'.$nn, $productos['ValorIngreso'])
					->setCellValue('G'.$nn, $stock_actual*$productos['ValorIngreso']);
		$nn++;
	}
}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle(cortar('Bodega '.DeSanitizar($arrProductos[0]['NombreBodega']), 25));

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Stock Bodega '.$arrProductos[0]['NombreBodega'].' al '.fecha_actual();
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
