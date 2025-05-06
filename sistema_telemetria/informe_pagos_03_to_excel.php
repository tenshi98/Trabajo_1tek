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
//Variable de busqueda
$SIS_where_1 = "bodegas_arriendos_facturacion.idEstado=1";
$SIS_where_2 = "bodegas_insumos_facturacion.idEstado=1";
$SIS_where_3 = "bodegas_productos_facturacion.idEstado=1";
$SIS_where_4 = "bodegas_servicios_facturacion.idEstado=1";
//Verifico el tipo de usuario que esta ingresando
$SIS_where_1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico que sean solo compras
$SIS_where_1.=" AND (bodegas_arriendos_facturacion.idTipo=2 OR bodegas_arriendos_facturacion.idTipo=12)";
$SIS_where_2.=" AND (bodegas_insumos_facturacion.idTipo=2   OR bodegas_insumos_facturacion.idTipo=12)";
$SIS_where_3.=" AND (bodegas_productos_facturacion.idTipo=2 OR bodegas_productos_facturacion.idTipo=12)";
$SIS_where_4.=" AND (bodegas_servicios_facturacion.idTipo=2 OR bodegas_servicios_facturacion.idTipo=12)";

if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$SIS_where_1.=" AND bodegas_arriendos_facturacion.idCliente=".$_GET['idCliente'];
	$SIS_where_2.=" AND bodegas_insumos_facturacion.idCliente=".$_GET['idCliente'];
	$SIS_where_3.=" AND bodegas_productos_facturacion.idCliente=".$_GET['idCliente'];
	$SIS_where_4.=" AND bodegas_servicios_facturacion.idCliente=".$_GET['idCliente'];
}
if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){
	$SIS_where_1.=" AND bodegas_arriendos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$SIS_where_2.=" AND bodegas_insumos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$SIS_where_3.=" AND bodegas_productos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$SIS_where_4.=" AND bodegas_servicios_facturacion.idDocumentos=".$_GET['idDocumentos'];
}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){
	$SIS_where_1.=" AND bodegas_arriendos_facturacion.N_Doc=".$_GET['N_Doc'];
	$SIS_where_2.=" AND bodegas_insumos_facturacion.N_Doc=".$_GET['N_Doc'];
	$SIS_where_3.=" AND bodegas_productos_facturacion.N_Doc=".$_GET['N_Doc'];
	$SIS_where_4.=" AND bodegas_servicios_facturacion.N_Doc=".$_GET['N_Doc'];
}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$SIS_where_1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$SIS_where_2.=" AND bodegas_insumos_facturacion.Creacion_fecha   BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$SIS_where_3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$SIS_where_4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
}

$table_1 = 'bodegas_arriendos_facturacion';
$table_2 = 'bodegas_insumos_facturacion';
$table_3 = 'bodegas_productos_facturacion';
$table_4 = 'bodegas_servicios_facturacion';

$arrTipo1 = array();
$arrTipo2 = array();
$arrTipo3 = array();
$arrTipo4 = array();

$arrTipo1 = db_select_array (false, $table_1.'.idFacturacion,'.$table_1.'.Creacion_fecha,'.$table_1.'.Pago_fecha,'.$table_1.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,clientes_listado.Nombre AS Cliente,'.$table_1.'.MontoPagado,'.$table_1.'.ValorTotal', $table_1, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_1.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_1.'.idDocumentos LEFT JOIN `clientes_listado` ON clientes_listado.idCliente = '.$table_1.'.idCliente', $SIS_where_1, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"]), 'arrTipo1');
$arrTipo2 = db_select_array (false, $table_2.'.idFacturacion,'.$table_2.'.Creacion_fecha,'.$table_2.'.Pago_fecha,'.$table_2.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,clientes_listado.Nombre AS Cliente,'.$table_2.'.MontoPagado,'.$table_2.'.ValorTotal', $table_2, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_2.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_2.'.idDocumentos LEFT JOIN `clientes_listado` ON clientes_listado.idCliente = '.$table_2.'.idCliente', $SIS_where_2, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"]), 'arrTipo2');
$arrTipo3 = db_select_array (false, $table_3.'.idFacturacion,'.$table_3.'.Creacion_fecha,'.$table_3.'.Pago_fecha,'.$table_3.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,clientes_listado.Nombre AS Cliente,'.$table_3.'.MontoPagado,'.$table_3.'.ValorTotal', $table_3, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_3.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_3.'.idDocumentos LEFT JOIN `clientes_listado` ON clientes_listado.idCliente = '.$table_3.'.idCliente', $SIS_where_3, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"]), 'arrTipo3');
$arrTipo4 = db_select_array (false, $table_4.'.idFacturacion,'.$table_4.'.Creacion_fecha,'.$table_4.'.Pago_fecha,'.$table_4.'.N_Doc,core_sistemas.Nombre AS Sistema,core_documentos_mercantiles.Nombre AS Documento,clientes_listado.Nombre AS Cliente,'.$table_4.'.MontoPagado,'.$table_4.'.ValorTotal', $table_4, 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = '.$table_4.'.idSistema LEFT JOIN `core_documentos_mercantiles` ON core_documentos_mercantiles.idDocumentos = '.$table_4.'.idDocumentos LEFT JOIN `clientes_listado` ON clientes_listado.idCliente = '.$table_4.'.idCliente', $SIS_where_4, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"]), 'arrTipo4');

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
            ->setCellValue('A1', 'Cliente')
            ->setCellValue('B1', 'Documento')
            ->setCellValue('C1', 'N° Documento')
            ->setCellValue('D1', 'Fecha de Ingreso')
            ->setCellValue('E1', 'Fecha de Pago')
            ->setCellValue('F1', 'Valor Total')
            ->setCellValue('G1', 'Monto Pagado');

$nn=2;
/********************************************************/
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$nn, 'Arriendos');
$nn++;
foreach ($arrTipo1 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($tipo['Cliente']))
				->setCellValue('B'.$nn, DeSanitizar($tipo['Documento']))
				->setCellValue('C'.$nn, $tipo['N_Doc'])
				->setCellValue('D'.$nn, Fecha_estandar($tipo['Creacion_fecha']))
				->setCellValue('E'.$nn, Fecha_estandar($tipo['Pago_fecha']))
				->setCellValue('F'.$nn, $tipo['ValorTotal'])
				->setCellValue('G'.$nn, $tipo['MontoPagado']);
	$nn++;

}
/********************************************************/
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$nn, 'Insumos');
$nn++;
foreach ($arrTipo2 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($tipo['Cliente']))
				->setCellValue('B'.$nn, DeSanitizar($tipo['Documento']))
				->setCellValue('C'.$nn, $tipo['N_Doc'])
				->setCellValue('D'.$nn, Fecha_estandar($tipo['Creacion_fecha']))
				->setCellValue('E'.$nn, Fecha_estandar($tipo['Pago_fecha']))
				->setCellValue('F'.$nn, $tipo['ValorTotal'])
				->setCellValue('G'.$nn, $tipo['MontoPagado']);
	$nn++;

}
/********************************************************/
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$nn, 'Productos');
$nn++;
foreach ($arrTipo3 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($tipo['Cliente']))
				->setCellValue('B'.$nn, DeSanitizar($tipo['Documento']))
				->setCellValue('C'.$nn, $tipo['N_Doc'])
				->setCellValue('D'.$nn, Fecha_estandar($tipo['Creacion_fecha']))
				->setCellValue('E'.$nn, Fecha_estandar($tipo['Pago_fecha']))
				->setCellValue('F'.$nn, $tipo['ValorTotal'])
				->setCellValue('G'.$nn, $tipo['MontoPagado']);
	$nn++;

}
/********************************************************/
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$nn, 'Servicios');
$nn++;
foreach ($arrTipo4 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($tipo['Cliente']))
				->setCellValue('B'.$nn, DeSanitizar($tipo['Documento']))
				->setCellValue('C'.$nn, $tipo['N_Doc'])
				->setCellValue('D'.$nn, Fecha_estandar($tipo['Creacion_fecha']))
				->setCellValue('E'.$nn, Fecha_estandar($tipo['Pago_fecha']))
				->setCellValue('F'.$nn, $tipo['ValorTotal'])
				->setCellValue('G'.$nn, $tipo['MontoPagado']);
	$nn++;

}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Listado de Documentos');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Documentos Clientes con Pagos pendientes';
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
