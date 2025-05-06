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
//Variables
$titulo_cuadro  = 'Ultimas Mediciones';
$seguimiento    = 2;
$HoraSistema    = hora_actual();
$FechaSistema   = fecha_actual();

//Variable
$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
//solo los equipos que tengan el seguimiento activado
if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
	$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
}
//Filtro el sistema al cual pertenece
$SIS_where .= " AND telemetria_listado.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];

//Verifico el tipo de usuario que esta ingresando y el id
$SIS_join = "LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = telemetria_listado.idSistema";	
if(isset($_SESSION['usuario']['basic_data']['idTipoUsuario'])&&$_SESSION['usuario']['basic_data']['idTipoUsuario']!=1&&isset($_SESSION['usuario']['basic_data']['idUsuario'])&&$_SESSION['usuario']['basic_data']['idUsuario']!=0){
	$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
	$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}

//Se consultan datos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
telemetria_listado.LastUpdateHora,
telemetria_listado.LastUpdateFecha,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.NErrores';
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

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
            ->setCellValue('A1', $titulo_cuadro)
            ->setCellValue('A3', 'Noti')
            ->setCellValue('B3', 'Equipo')
            ->setCellValue('C3', 'Ultima Conexion')
            ->setCellValue('D3', 'Estado');					
        
$nn=4;
foreach($arrEquipo as $equip) {	
	
	/**********************************************/
	//Se resetean
	$in_eq_alertas     = 0;
	$in_eq_fueralinea  = 0;
																	
	/**********************************************/
	//Fuera de linea
	$diaInicio   = $equip['LastUpdateFecha'];
	$diaTermino  = $FechaSistema;
	$tiempo1     = $equip['LastUpdateHora'];
	$tiempo2     = $HoraSistema;
	$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

	//Comparaciones de tiempo
	$Time_Tiempo     = horas2segundos($Tiempo);
	$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
	$Time_Tiempo_Max = horas2segundos('48:00:00');
	$Time_Fake_Ini   = horas2segundos('23:59:50');
	$Time_Fake_Fin   = horas2segundos('24:00:00');
	//comparacion
	if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
		$in_eq_fueralinea++;
	}
								
	/**********************************************/
	//NErrores
	if(isset($equip['NErrores'])&&$equip['NErrores']>0){ $in_eq_alertas++; }
										
	/*******************************************************/
	//rearmo
	if($in_eq_alertas>0){    
		$danger = 'Alerta';
		$eq_ok  = ' Con Alertas';
	}elseif($in_eq_fueralinea>0){
		$danger = 'Peligro';
		$eq_ok  = ' Fuera de Linea';
	}else{
		$danger = 'Normal';
		$eq_ok  = ' Sin Problemas';
	}
					
	/*******************************************************/
	//imprimo
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, $danger)
				->setCellValue('B'.$nn, $equip['Nombre'])
				->setCellValue('C'.$nn, fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].' hrs')
				->setCellValue('D'.$nn, $eq_ok);		
	
	$nn++;

}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle($titulo_cuadro);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = $titulo_cuadro;
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
