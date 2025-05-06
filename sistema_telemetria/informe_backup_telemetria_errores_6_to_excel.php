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
//Inicia variable
$SIS_where = "backup_telemetria_listado_errores.idErrores>0";
$SIS_where.= " AND backup_telemetria_listado_errores.idTipo!='999'";
$SIS_where.= " AND backup_telemetria_listado_errores.Valor<'99900'";
$SIS_where.= " AND telemetria_listado.id_Geo='2'";
$SIS_where.= " AND backup_telemetria_listado_errores.idSistema=".$_GET['idSistema'];
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$SIS_where .= " AND telemetria_listado.idTab=6";//Power-Crane
}
//verifico si existen los parametros de fecha
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where.= " AND backup_telemetria_listado_errores.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
//verifico si se selecciono un equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND backup_telemetria_listado_errores.idTelemetria='".$_GET['idTelemetria']."'";
}
//verifico el tipo de error
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){
	$SIS_where.= " AND backup_telemetria_listado_errores.idTipo='".$_GET['idTipo']."'";
}
//verifico si esta leido
if(isset($_GET['idLeido'])&&$_GET['idLeido']!=''){
	$SIS_where.= " AND backup_telemetria_listado_errores.idLeido='".$_GET['idLeido']."'";
}
//Verifico el tipo de usuario que esta ingresando
$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = backup_telemetria_listado_errores.idTelemetria';
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_join .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = backup_telemetria_listado_errores.idTelemetria ';
	$SIS_where.= ' AND usuarios_equipos_telemetria.idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
}

//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
// Se trae un listado con todos los elementos
$SIS_query = '
backup_telemetria_listado_errores.idErrores,
backup_telemetria_listado_errores.Descripcion,
backup_telemetria_listado_errores.Fecha,
backup_telemetria_listado_errores.Hora,
backup_telemetria_listado_errores.Sensor,
backup_telemetria_listado_errores.Valor,
backup_telemetria_listado_errores.Valor_min,
backup_telemetria_listado_errores.Valor_max,
backup_telemetria_listado_errores.idTelemetria,
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado.id_Geo'.$subquery;
$SIS_join .= ' LEFT JOIN telemetria_listado_sensores_unimed ON telemetria_listado_sensores_unimed.idTelemetria = backup_telemetria_listado_errores.idTelemetria ';
$SIS_order = 'backup_telemetria_listado_errores.idErrores DESC';
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'backup_telemetria_listado_errores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrErrores');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

$arrUnimedX = array();
foreach ($arrUnimed as $sen) {
	$arrUnimedX[$sen['idUniMed']] = $sen['Nombre'];
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

//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nombre Equipo')
            ->setCellValue('B1', 'Descripcion')
            ->setCellValue('C1', 'Fecha')
            ->setCellValue('D1', 'Hora')
            ->setCellValue('E1', 'Medicion Actual')
            ->setCellValue('F1', 'Min')
            ->setCellValue('G1', 'Max')
            ->setCellValue('H1', 'Unidad Medida');

$nn=2;
foreach ($arrErrores as $error) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($error['NombreEquipo']))
				->setCellValue('B'.$nn, DeSanitizar($error['Descripcion']))
				->setCellValue('C'.$nn, $error['Fecha'])
				->setCellValue('D'.$nn, $error['Hora'])
				->setCellValue('E'.$nn, $error['Valor'])
				->setCellValue('F'.$nn, $error['Valor_min'])
				->setCellValue('G'.$nn, $error['Valor_max'])
				->setCellValue('H'.$nn, DeSanitizar($arrUnimedX[$error['SensoresUniMed_'.$error['Sensor']]]));
	$nn++;

}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Resumen de Alertas');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Informe de Alertas';
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
