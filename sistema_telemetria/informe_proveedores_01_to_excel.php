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
$SIS_where = "proveedor_listado.idProveedor!=0";
//Filtros
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){     $SIS_where.=" AND proveedor_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['Nombre'])&&$_GET['Nombre']!=''){     $SIS_where.=" AND proveedor_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['Rut'])&&$_GET['Rut']!=''){           $SIS_where.=" AND proveedor_listado.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
if(isset($_GET['fNacimiento'])&&$_GET['fNacimiento']!=''){  $SIS_where.=" AND proveedor_listado.fNacimiento='".$_GET['fNacimiento']."'";}
if(isset($_GET['idCiudad'])&&$_GET['idCiudad']!=''){ $SIS_where.=" AND proveedor_listado.idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna'])&&$_GET['idComuna']!=''){ $SIS_where.=" AND proveedor_listado.idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion'])&&$_GET['Direccion']!=''){      $SIS_where.=" AND proveedor_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}
if(isset($_GET['Giro'])&&$_GET['Giro']!=''){         $SIS_where.=" AND proveedor_listado.Giro LIKE '%".EstandarizarInput($_GET['Giro'])."%'";}

/*******************************************************/
// consulto los datos
$SIS_query = '
proveedor_listado.email, 
proveedor_listado.Nombre,
proveedor_listado.Rut, 
proveedor_listado.RazonSocial, 
proveedor_listado.fNacimiento, 
proveedor_listado.Direccion, 
proveedor_listado.Fono1, 
proveedor_listado.Fono2, 
proveedor_listado.Fax,
proveedor_listado.PersonaContacto,
proveedor_listado.PersonaContacto_Fono,
proveedor_listado.PersonaContacto_email,
proveedor_listado.Web,
proveedor_listado.Giro,
proveedor_listado.FormaPago,
proveedor_listado.idTipo,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
proveedor_tipos.Nombre AS tipoProveedor,
core_rubros.Nombre AS Rubro,
core_paises.Nombre AS Pais,
core_paises.Flag AS Flag';
$SIS_join  = '
LEFT JOIN `core_estados`              ON core_estados.idEstado                    = proveedor_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`     ON core_ubicacion_ciudad.idCiudad           = proveedor_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`    ON core_ubicacion_comunas.idComuna          = proveedor_listado.idComuna
LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema                  = proveedor_listado.idSistema
LEFT JOIN `proveedor_tipos`           ON proveedor_tipos.idTipo                   = proveedor_listado.idTipo
LEFT JOIN `core_rubros`               ON core_rubros.idRubro                      = proveedor_listado.idRubro
LEFT JOIN `core_paises`               ON core_paises.idPais                       = proveedor_listado.idPais';
$SIS_order = 0;
$arrProveedores = array();
$arrProveedores = db_select_array (false, $SIS_query, 'proveedor_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProveedores');

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
            ->setCellValue('A1', 'Tipo de Proveedor')
            ->setCellValue('B1', 'Nombre')
            ->setCellValue('C1', 'Razón Social')
            ->setCellValue('D1', 'Rut')
            ->setCellValue('E1', 'Fecha de Ingreso Sistema')
            ->setCellValue('F1', 'Pais')
            ->setCellValue('G1', 'Región')
            ->setCellValue('H1', 'Comuna')
            ->setCellValue('I1', 'Dirección')
            ->setCellValue('J1', 'Sistema Relacionado')
            ->setCellValue('K1', 'Estado')
            ->setCellValue('L1', 'Giro de la empresa')
            ->setCellValue('M1', 'Rubro')
            ->setCellValue('N1', 'Telefono Fijo')
            ->setCellValue('O1', 'Telefono Movil')
            ->setCellValue('P1', 'Fax')
            ->setCellValue('Q1', 'Email')
            ->setCellValue('R1', 'Web')
            ->setCellValue('S1', 'Persona de Contacto')
            ->setCellValue('T1', 'Telefono de Contacto')
            ->setCellValue('U1', 'Email de Contacto')
            ->setCellValue('V1', 'Forma de Pago');

$nn=2;
foreach ($arrProveedores as $productos) { 

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, $productos['tipoProveedor'])
				->setCellValue('B'.$nn, DeSanitizar($productos['Nombre']))
				->setCellValue('C'.$nn, DeSanitizar($productos['RazonSocial']))
				->setCellValue('D'.$nn, $productos['Rut'])
				->setCellValue('E'.$nn, fecha_estandar($cli['fNacimiento']))
				->setCellValue('F'.$nn, DeSanitizar($productos['Pais']))
				->setCellValue('G'.$nn, DeSanitizar($productos['nombre_region']))
				->setCellValue('H'.$nn, DeSanitizar($productos['nombre_comuna']))
				->setCellValue('I'.$nn, DeSanitizar($productos['Direccion']))
				->setCellValue('J'.$nn, DeSanitizar($productos['sistema']))
				->setCellValue('K'.$nn, DeSanitizar($productos['estado']))
				->setCellValue('L'.$nn, DeSanitizar($productos['Giro']))
				->setCellValue('M'.$nn, DeSanitizar($productos['Rubro']))
				->setCellValue('N'.$nn, formatPhone($productos['Fono1']))
				->setCellValue('O'.$nn, formatPhone($productos['Fono2']))
				->setCellValue('P'.$nn, $productos['Fax'])
				->setCellValue('Q'.$nn, DeSanitizar($productos['email']))
				->setCellValue('R'.$nn, DeSanitizar($productos['Web']))
				->setCellValue('S'.$nn, DeSanitizar($productos['PersonaContacto']))
				->setCellValue('T'.$nn, formatPhone($productos['PersonaContacto_Fono']))
				->setCellValue('U'.$nn, DeSanitizar($productos['PersonaContacto_email']))
				->setCellValue('V'.$nn, DeSanitizar($productos['FormaPago']));
	$nn++;

}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Datos Proveedores');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Datos Proveedores';
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
