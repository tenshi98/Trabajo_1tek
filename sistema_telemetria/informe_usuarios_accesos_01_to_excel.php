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
$SIS_where = "usuarios_accesos.idAcceso>0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND usuarios_accesos.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['Rango_Inicio']) && $_GET['Rango_Inicio'] != ''&&isset($_GET['Rango_Termino']) && $_GET['Rango_Termino']!=''){  
	$SIS_where .= " AND usuarios_accesos.Fecha BETWEEN '".$_GET['Rango_Inicio']."' AND '".$_GET['Rango_Termino']."'";
}

/*******************************************************/
// consulto los datos
$SIS_query = '
usuarios_accesos.Fecha,
usuarios_accesos.Hora,
usuarios_accesos.IP_Client,
usuarios_accesos.Agent_Transp,
usuarios_listado.Nombre AS Usuario,
core_sistemas.Nombre AS Sistema';
$SIS_join  = '
LEFT JOIN `usuarios_listado`   ON usuarios_listado.idUsuario   = usuarios_accesos.idUsuario 
LEFT JOIN `core_sistemas`      ON core_sistemas.idSistema      = usuarios_accesos.idSistema';
$SIS_order = 'usuarios_accesos.Fecha DESC';
$arrAccesos = array();
$arrAccesos = db_select_array (false, $SIS_query, 'usuarios_accesos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAccesos');

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
            ->setCellValue('A1', 'Sistema')
            ->setCellValue('B1', 'Usuario')
            ->setCellValue('C1', 'Fecha')
            ->setCellValue('D1', 'Hora')
            ->setCellValue('E1', 'IP Cliente')
            ->setCellValue('F1', 'Agent Transp');       					                              
         
$nn=2;
foreach ($arrAccesos as $acceso) { 
						
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($acceso['Sistema']))
				->setCellValue('B'.$nn, DeSanitizar($acceso['Usuario']))
				->setCellValue('C'.$nn, fecha_estandar($acceso['Fecha']))
				->setCellValue('D'.$nn, $acceso['Hora'])
				->setCellValue('E'.$nn, $acceso['IP_Client'])
				->setCellValue('F'.$nn, DeSanitizar($acceso['Agent_Transp']));
	$nn++;

}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Informe Accesos');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Informe Accesos Usuarios';
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
