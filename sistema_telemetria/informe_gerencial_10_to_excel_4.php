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
//Solo compras pagadas totalmente
$SIS_where_1 = "bodegas_arriendos_facturacion.idTipo=2"; //solo ventas
$SIS_where_2 = "bodegas_insumos_facturacion.idTipo=2";   //solo ventas
$SIS_where_3 = "bodegas_productos_facturacion.idTipo=2"; //solo ventas
$SIS_where_4 = "bodegas_servicios_facturacion.idTipo=2"; //solo ventas
//sololas del mismo sistema
$SIS_where_1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){
	$SIS_where_1.=" AND bodegas_arriendos_facturacion.idTrabajador=".$_GET['idTrabajador'];
	$SIS_where_2.=" AND bodegas_insumos_facturacion.idTrabajador=".$_GET['idTrabajador'];
	$SIS_where_3.=" AND bodegas_productos_facturacion.idTrabajador=".$_GET['idTrabajador'];
	$SIS_where_4.=" AND bodegas_servicios_facturacion.idTrabajador=".$_GET['idTrabajador'];
}
if(isset($_GET['Creacion_ano'])&&$_GET['Creacion_ano']!=''){
	$SIS_where_1.=" AND bodegas_arriendos_facturacion.Creacion_ano=".$_GET['Creacion_ano'];
	$SIS_where_2.=" AND bodegas_insumos_facturacion.Creacion_ano=".$_GET['Creacion_ano'];
	$SIS_where_3.=" AND bodegas_productos_facturacion.Creacion_ano=".$_GET['Creacion_ano'];
	$SIS_where_4.=" AND bodegas_servicios_facturacion.Creacion_ano=".$_GET['Creacion_ano'];
}
//sololas del mismo sistema
$SIS_where_1.=" GROUP BY bodegas_arriendos_facturacion.idTrabajador, bodegas_arriendos_facturacion.Creacion_mes";
$SIS_where_2.=" GROUP BY bodegas_insumos_facturacion.idTrabajador, bodegas_insumos_facturacion.Creacion_mes";
$SIS_where_3.=" GROUP BY bodegas_productos_facturacion.idTrabajador, bodegas_productos_facturacion.Creacion_mes";
$SIS_where_4.=" GROUP BY bodegas_servicios_facturacion.idTrabajador, bodegas_servicios_facturacion.Creacion_mes";

/*******************************************************/
// consulto los datos
$SIS_query = '
bodegas_arriendos_facturacion.idTrabajador,
bodegas_arriendos_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal';
$SIS_join  = 'LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_arriendos_facturacion.idTrabajador';
$SIS_order = 'bodegas_arriendos_facturacion.Creacion_mes DESC';
$arrTemporal_1 = array();
$arrTemporal_1 = db_select_array (false, $SIS_query, 'bodegas_arriendos_facturacion', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_1');

/*******************************************************/
// consulto los datos
$SIS_query = '
bodegas_insumos_facturacion.idTrabajador,
bodegas_insumos_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal';
$SIS_join  = 'LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_insumos_facturacion.idTrabajador';
$SIS_order = 'bodegas_insumos_facturacion.Creacion_mes DESC';
$arrTemporal_2 = array();
$arrTemporal_2 = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_2');

/*******************************************************/
// consulto los datos
$SIS_query = '
bodegas_productos_facturacion.idTrabajador,
bodegas_productos_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal';
$SIS_join  = 'LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_productos_facturacion.idTrabajador';
$SIS_order = 'bodegas_productos_facturacion.Creacion_mes DESC';
$arrTemporal_3 = array();
$arrTemporal_3 = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion', $SIS_join, $SIS_where_3, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_3');

/*******************************************************/
// consulto los datos
$SIS_query = '
bodegas_servicios_facturacion.idTrabajador,
bodegas_servicios_facturacion.Creacion_mes,
trabajadores_listado.Nombre AS TrabNombre,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal';
$SIS_join  = 'LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador   = bodegas_servicios_facturacion.idTrabajador';
$SIS_order = 'bodegas_servicios_facturacion.Creacion_mes DESC';
$arrTemporal_4 = array();
$arrTemporal_4 = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion', $SIS_join, $SIS_where_4, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_4');

/*************************************************************************************************/
//Se crea arreglo
$arrCreativo = array();
foreach ($arrTemporal_1 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_1']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_1']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_2 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_2']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_2']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_3 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_3']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_3']         = $temp['ValorTotal'];
}
foreach ($arrTemporal_4 as $temp) {
	$arrCreativo[$temp['idTrabajador']][0]['Trabajador']                          = $temp['TrabNombre'].' '.$temp['TrabApellidoPat'].' '.$temp['TrabApellidoMat'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['idTrabajador']    = $temp['idTrabajador'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Creacion_mes']    = $temp['Creacion_mes'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Neto_4']          = $temp['ValorNeto'];
	$arrCreativo[$temp['idTrabajador']][$temp['Creacion_mes']]['Total_4']         = $temp['ValorTotal'];
}
/*************************************************************************************************/

//Variables
$Neto_1 = 0;
$Neto_2 = 0;
$Neto_3 = 0;
$Neto_4 = 0;

$Total_1 = 0;
$Total_2 = 0;
$Total_3 = 0;
$Total_4 = 0;

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
            ->setCellValue('A1', '')
            ->setCellValue('B1', '')
            ->setCellValue('C1', 'Netos')
            ->setCellValue('H1', 'Totales')
            ->setCellValue('A2', 'Trabajador')
            ->setCellValue('B2', 'Mes')
            ->setCellValue('C2', 'Arriendos')
            ->setCellValue('D2', 'Insumos')
            ->setCellValue('E2', 'Productos')
            ->setCellValue('F2', 'Servicios')
            ->setCellValue('G2', 'Subtotal')
            ->setCellValue('H2', 'Arriendos')
            ->setCellValue('I2', 'Insumos')
            ->setCellValue('J2', 'Productos')
            ->setCellValue('K2', 'Servicios')
            ->setCellValue('L2', 'Subtotal');
          
$nn=3;
foreach ($arrCreativo as $datais) {
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$nn, DeSanitizar($datais[0]['Trabajador']));
	$nn++;

	foreach ($datais as $prod) {

		// subtotales Netos
		$sub_1 = 0;
		if(isset($prod['Neto_1'])){$sub_1 = $sub_1 + $prod['Neto_1'];}
		if(isset($prod['Neto_2'])){$sub_1 = $sub_1 + $prod['Neto_2'];}
		if(isset($prod['Neto_3'])){$sub_1 = $sub_1 + $prod['Neto_3'];}
		if(isset($prod['Neto_4'])){$sub_1 = $sub_1 + $prod['Neto_4'];}
									
		// subtotales Totales
		$sub_2 = 0;
		if(isset($prod['Total_1'])){$sub_2 = $sub_2 + $prod['Total_1'];}
		if(isset($prod['Total_2'])){$sub_2 = $sub_2 + $prod['Total_2'];}
		if(isset($prod['Total_3'])){$sub_2 = $sub_2 + $prod['Total_3'];}
		if(isset($prod['Total_4'])){$sub_2 = $sub_2 + $prod['Total_4'];}
		
		if(isset($prod['Creacion_mes'])&&$prod['Creacion_mes']!=''&&$prod['Creacion_mes']!=0){
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A'.$nn, '')
						->setCellValue('B'.$nn, numero_a_mes($prod['Creacion_mes']))
						->setCellValue('C'.$nn, cantidades_excel($prod['Neto_1']))
						->setCellValue('D'.$nn, cantidades_excel($prod['Neto_2']))
						->setCellValue('E'.$nn, cantidades_excel($prod['Neto_3']))
						->setCellValue('F'.$nn, cantidades_excel($prod['Neto_4']))
						->setCellValue('G'.$nn, cantidades_excel($sub_1))
						->setCellValue('H'.$nn, cantidades_excel($prod['Total_1']))
						->setCellValue('I'.$nn, cantidades_excel($prod['Total_2']))
						->setCellValue('J'.$nn, cantidades_excel($prod['Total_3']))
						->setCellValue('K'.$nn, cantidades_excel($prod['Total_4']))
						->setCellValue('L'.$nn, cantidades_excel($sub_2));
			$nn++;
			//Suma de variables
			$Neto_1 = $Neto_1 + $prod['Neto_1'];
			$Neto_2 = $Neto_2 + $prod['Neto_2'];
			$Neto_3 = $Neto_3 + $prod['Neto_3'];
			$Neto_4 = $Neto_4 + $prod['Neto_4'];
			$Total_1 = $Total_1 + $prod['Total_1'];
			$Total_2 = $Total_2 + $prod['Total_2'];
			$Total_3 = $Total_3 + $prod['Total_3'];
			$Total_4 = $Total_4 + $prod['Total_4']; 
		}          
	}
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, '')
			->setCellValue('B'.$nn, 'Totales')
			->setCellValue('C'.$nn, cantidades_excel($Neto_1))
			->setCellValue('D'.$nn, cantidades_excel($Neto_2))
			->setCellValue('E'.$nn, cantidades_excel($Neto_3))
			->setCellValue('F'.$nn, cantidades_excel($Neto_4))
			->setCellValue('G'.$nn, cantidades_excel($Neto_1+$Neto_2+$Neto_3+$Neto_4))
			->setCellValue('H'.$nn, cantidades_excel($Total_1))
			->setCellValue('I'.$nn, cantidades_excel($Total_2))
			->setCellValue('J'.$nn, cantidades_excel($Total_3))
			->setCellValue('K'.$nn, cantidades_excel($Total_4))
			->setCellValue('L'.$nn, cantidades_excel($Total_1+$Total_2+$Total_3+$Total_4));

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Ventas Vendedores por mes');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Ventas Vendedores por mes Resumen';
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
