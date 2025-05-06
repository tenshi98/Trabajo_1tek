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
//Variable de busqueda
$SIS_where = "clientes_listado.idCliente!=0";
//Filtros
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){     $SIS_where.=" AND clientes_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['Nombre'])&&$_GET['Nombre']!=''){     $SIS_where.=" AND clientes_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['Rut'])&&$_GET['Rut']!=''){           $SIS_where.=" AND clientes_listado.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
if(isset($_GET['fNacimiento'])&&$_GET['fNacimiento']!=''){  $SIS_where.=" AND clientes_listado.fNacimiento='".$_GET['fNacimiento']."'";}
if(isset($_GET['idCiudad'])&&$_GET['idCiudad']!=''){ $SIS_where.=" AND clientes_listado.idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna'])&&$_GET['idComuna']!=''){ $SIS_where.=" AND clientes_listado.idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion'])&&$_GET['Direccion']!=''){      $SIS_where.=" AND clientes_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}
if(isset($_GET['Giro'])&&$_GET['Giro']!=''){         $SIS_where.=" AND clientes_listado.Giro LIKE '%".EstandarizarInput($_GET['Giro'])."%'";}

/**********************************************************************/             
// Se trae un listado con todos los elementos
$SIS_query = '
clientes_listado.email, 
clientes_listado.Nombre,
clientes_listado.Rut, 
clientes_listado.RazonSocial, 
clientes_listado.fNacimiento, 
clientes_listado.Direccion, 
clientes_listado.Fono1, 
clientes_listado.Fono2, 
clientes_listado.Fax,
clientes_listado.PersonaContacto,
clientes_listado.PersonaContacto_Fono,
clientes_listado.PersonaContacto_email,
clientes_listado.Web,
clientes_listado.Giro,
clientes_listado.idTipo,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
clientes_tipos.Nombre AS tipoCliente,
core_rubros.Nombre AS Rubro';
$SIS_join  = '
LEFT JOIN `core_estados`              ON core_estados.idEstado                    = clientes_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`     ON core_ubicacion_ciudad.idCiudad           = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`    ON core_ubicacion_comunas.idComuna          = clientes_listado.idComuna
LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema                  = clientes_listado.idSistema
LEFT JOIN `clientes_tipos`            ON clientes_tipos.idTipo                    = clientes_listado.idTipo
LEFT JOIN `core_rubros`               ON core_rubros.idRubro                      = clientes_listado.idRubro';
$SIS_order = 0;
$arrClientes = array();
$arrClientes = db_select_array (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrClientes');

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
            ->setCellValue('A1', 'Tipo de Cliente')
            ->setCellValue('B1', 'Nombre')
            ->setCellValue('C1', 'Razón Social')
            ->setCellValue('D1', 'Rut')
            ->setCellValue('E1', 'Fecha de Ingreso Sistema')
            ->setCellValue('F1', 'Región')
            ->setCellValue('G1', 'Comuna')
            ->setCellValue('H1', 'Dirección')
            ->setCellValue('I1', 'Sistema Relacionado')
            ->setCellValue('J1', 'Estado')
            ->setCellValue('K1', 'Giro de la empresa')
            ->setCellValue('L1', 'Rubro')
            ->setCellValue('M1', 'Telefono Fijo')
            ->setCellValue('N1', 'Telefono Movil')
            ->setCellValue('O1', 'Fax')
            ->setCellValue('P1', 'Email')
            ->setCellValue('Q1', 'Web')
            ->setCellValue('R1', 'Persona de Contacto')
            ->setCellValue('S1', 'Telefono de Contacto')
            ->setCellValue('T1', 'Email de Contacto');

$nn=2;
foreach ($arrClientes as $productos) { 

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($productos['tipoCliente']))
				->setCellValue('B'.$nn, DeSanitizar($productos['Nombre']))
				->setCellValue('C'.$nn, DeSanitizar($productos['RazonSocial']))
				->setCellValue('D'.$nn, $productos['Rut'])
				->setCellValue('E'.$nn, fecha_estandar($productos['fNacimiento']))
				->setCellValue('F'.$nn, DeSanitizar($productos['nombre_region']))
				->setCellValue('G'.$nn, DeSanitizar($productos['nombre_comuna']))
				->setCellValue('H'.$nn, DeSanitizar($productos['Direccion']))
				->setCellValue('I'.$nn, DeSanitizar($productos['sistema']))
				->setCellValue('J'.$nn, DeSanitizar($productos['estado']))
				->setCellValue('K'.$nn, DeSanitizar($productos['Giro']))
				->setCellValue('L'.$nn, DeSanitizar($productos['Rubro']))
				->setCellValue('M'.$nn, formatPhone($productos['Fono1']))
				->setCellValue('N'.$nn, formatPhone($productos['Fono2']))
				->setCellValue('O'.$nn, $productos['Fax'])
				->setCellValue('P'.$nn, DeSanitizar($productos['email']))
				->setCellValue('Q'.$nn, DeSanitizar($productos['Web']))
				->setCellValue('R'.$nn, DeSanitizar($productos['PersonaContacto']))
				->setCellValue('S'.$nn, formatPhone($productos['PersonaContacto_Fono']))
				->setCellValue('T'.$nn, DeSanitizar($productos['PersonaContacto_email']));
	$nn++;

}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Datos Clientes');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Datos Clientes';
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
