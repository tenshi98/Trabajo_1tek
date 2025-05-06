<?php
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
require_once 'core/Load.Utils.NoSessions.php';
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
$rowEmpresa = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema='.$_GET['idSistema'], $dbConn, 'arrEquipos1', basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');

/**********************************************************/
$SIS_where_1 = "telemetria_listado_errores_999.idErrores!=0";           //siempre pasa
$SIS_where_2 = "telemetria_listado_error_fuera_linea.idFueraLinea!=0";  //siempre pasa
$SIS_where_3 = "telemetria_listado.idEstado = 1";                       //solo activos
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino'] != '' && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores_999.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."'";
	$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."'";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores_999.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.Fecha_inicio BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores_999.idTelemetria=".$_GET['idTelemetria'];
	$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.idTelemetria=".$_GET['idTelemetria'];
	$SIS_where_3.=" AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];
}


$N_Maximo_Sensores = 72;
$consql = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
}

/*********************************************************/
//consulto
$SIS_query = '
core_sistemas.Nombre AS Sistema,
telemetria_listado.Nombre AS EquipoNombre,
telemetria_listado_errores_999.idTelemetria AS EquipoId,
core_telemetria_tabs.Nombre AS EquipoTab,
telemetria_listado_errores_999.Sensor AS EquipoNSensor,
COUNT(telemetria_listado_errores_999.idErrores) AS Cuenta,
telemetria_listado_errores_999.Descripcion,
telemetria_listado_errores_999.Valor'.$consql;
$SIS_join  = '
LEFT JOIN telemetria_listado                    ON telemetria_listado.idTelemetria                  = telemetria_listado_errores_999.idTelemetria
LEFT JOIN core_sistemas                         ON core_sistemas.idSistema                          = telemetria_listado_errores_999.idSistema
LEFT JOIN core_telemetria_tabs                  ON core_telemetria_tabs.idTab                       = telemetria_listado.idTab
LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado_errores_999.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado_errores_999.idTelemetria';
$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_errores_999.Sensor ASC, telemetria_listado_errores_999.Descripcion ASC, telemetria_listado_errores_999.Valor ASC';
$SIS_where_1.= ' GROUP BY core_sistemas.Nombre,telemetria_listado.Nombre,core_telemetria_tabs.Nombre,telemetria_listado_errores_999.Sensor, telemetria_listado_errores_999.Descripcion, telemetria_listado_errores_999.Valor';
$arrEquipos1 = array();
$arrEquipos1 = db_select_array (false, $SIS_query, 'telemetria_listado_errores_999', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos1');

/*********************************************************/
//Consulto
$SIS_query = '
core_sistemas.Nombre AS Sistema,
telemetria_listado.Nombre AS EquipoNombre,
core_telemetria_tabs.Nombre AS EquipoTab,
telemetria_listado_error_fuera_linea.Fecha_inicio,
telemetria_listado_error_fuera_linea.Hora_inicio,
telemetria_listado_error_fuera_linea.Fecha_termino,
telemetria_listado_error_fuera_linea.Hora_termino,
telemetria_listado_error_fuera_linea.Tiempo';
$SIS_join  = '
LEFT JOIN telemetria_listado     ON telemetria_listado.idTelemetria  = telemetria_listado_error_fuera_linea.idTelemetria
LEFT JOIN core_sistemas          ON core_sistemas.idSistema          = telemetria_listado_error_fuera_linea.idSistema
LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab       = telemetria_listado.idTab';
$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_error_fuera_linea.Fecha_inicio ASC';
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrErrores');

/*********************************************************/
//Consulto
$SIS_query = '
core_sistemas.Nombre AS Sistema,
telemetria_listado.Nombre AS EquipoNombre,
core_telemetria_tabs.Nombre AS EquipoTab,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.TiempoFueraLinea';
$SIS_join  = '
LEFT JOIN `core_sistemas`        ON core_sistemas.idSistema      = telemetria_listado.idSistema
LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab   = telemetria_listado.idTab';
$SIS_order = 'telemetria_listado.idSistema ASC';
$arrTelemetria = array();
$arrTelemetria = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where_3, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrErrores');

/*********************************************************/
//Se consultan datos
$arrGrupos = array();
$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

$arrFinalGrupos = array();
foreach ($arrGrupos as $sen) {
	$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];
}

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

/**********************************************************************************/
/*                                    Pagina 1                                    */
/**********************************************************************************/
//variables
$nn = 1;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$nn, 'Sistema')
            ->setCellValue('B'.$nn, 'Equipo')
            ->setCellValue('C'.$nn, 'Id Telemetria')
            ->setCellValue('D'.$nn, 'Tab')
            ->setCellValue('E'.$nn, 'Grupo')
            ->setCellValue('F'.$nn, 'Numero Sensor')
            ->setCellValue('G'.$nn, 'Nombre Sensor')
            ->setCellValue('H'.$nn, 'Numero Alertas')
            ->setCellValue('I'.$nn, 'Descripcion');

//variables
$nn = 2;
//Recorro
foreach ($arrEquipos1 as $equip) {
	if(isset($equip['Valor'])&&$equip['Valor']==99900){

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, DeSanitizar($equip['Sistema']))
					->setCellValue('B'.$nn, DeSanitizar($equip['EquipoNombre']))
					->setCellValue('C'.$nn, DeSanitizar($equip['EquipoId']))
					->setCellValue('D'.$nn, DeSanitizar($equip['EquipoTab']))
					->setCellValue('E'.$nn, DeSanitizar($arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]]))
					->setCellValue('F'.$nn, DeSanitizar($equip['EquipoNSensor']))
					->setCellValue('G'.$nn, DeSanitizar($equip['SensoresNombre_'.$equip['EquipoNSensor']]))
					->setCellValue('H'.$nn, $equip['Cuenta'])
					->setCellValue('I'.$nn, DeSanitizar($equip['Descripcion']));

		//Se suma 1
		$nn++;
	}
}

//seteo el nombre de la hoja
$spreadsheet->getActiveSheet(0)->setTitle('99900');
//ancho de columnas
/*$spreadsheet->getActiveSheet(0)->getColumnDimension('A')->setWidth(50);
$spreadsheet->getActiveSheet(0)->getColumnDimension('B')->setWidth(80);
$spreadsheet->getActiveSheet(0)->getColumnDimension('C')->setWidth(12);
$spreadsheet->getActiveSheet(0)->getColumnDimension('D')->setWidth(12);
$spreadsheet->getActiveSheet(0)->getColumnDimension('E')->setWidth(20);
$spreadsheet->getActiveSheet(0)->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet(0)->getColumnDimension('G')->setWidth(20);*/
//negrita
$spreadsheet->getActiveSheet(0)->getStyle('A1:I1')->getFont()->setBold(true);
//Coloreo celdas
$spreadsheet->getActiveSheet(0)->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
//coloreo fuentes
$spreadsheet->getActiveSheet(0)->getStyle('A1:I1')->getFont()->getColor()->setRGB('FFFFFF');
//Pongo los bordes
$spreadsheet->getActiveSheet(0)->getStyle('A1:I'.$nn)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('rgb' => '333333')
            )
        )
    )
);

/**********************************************************************************/
/*                                    Pagina 2                                    */
/**********************************************************************************/
//Se crea nueva hoja
$spreadsheet->createSheet();

//variables
$nn = 1;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.$nn, 'Sistema')
            ->setCellValue('B'.$nn, 'Equipo')
            ->setCellValue('C'.$nn, 'Id Telemetria')
            ->setCellValue('D'.$nn, 'Tab')
            ->setCellValue('E'.$nn, 'Grupo')
            ->setCellValue('F'.$nn, 'Numero Sensor')
            ->setCellValue('G'.$nn, 'Nombre Sensor')
            ->setCellValue('H'.$nn, 'Numero Alertas')
            ->setCellValue('I'.$nn, 'Descripcion');

//variables
$nn = 2;
//Recorro
foreach ($arrEquipos1 as $equip) {
	if(isset($equip['Valor'])&&$equip['Valor']==99901){

		$spreadsheet->setActiveSheetIndex(1)
					->setCellValue('A'.$nn, DeSanitizar($equip['Sistema']))
					->setCellValue('B'.$nn, DeSanitizar($equip['EquipoNombre']))
					->setCellValue('C'.$nn, DeSanitizar($equip['EquipoId']))
					->setCellValue('D'.$nn, DeSanitizar($equip['EquipoTab']))
					->setCellValue('E'.$nn, DeSanitizar($arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]]))
					->setCellValue('F'.$nn, DeSanitizar($equip['EquipoNSensor']))
					->setCellValue('G'.$nn, DeSanitizar($equip['SensoresNombre_'.$equip['EquipoNSensor']]))
					->setCellValue('H'.$nn, $equip['Cuenta'])
					->setCellValue('I'.$nn, DeSanitizar($equip['Descripcion']));

		//Se suma 1
		$nn++;
	}
}

//seteo el nombre de la hoja
$spreadsheet->getActiveSheet(1)->setTitle('99901');
//ancho de columnas
/*$spreadsheet->getActiveSheet(1)->getColumnDimension('A')->setWidth(50);
$spreadsheet->getActiveSheet(1)->getColumnDimension('B')->setWidth(80);
$spreadsheet->getActiveSheet(1)->getColumnDimension('C')->setWidth(12);
$spreadsheet->getActiveSheet(1)->getColumnDimension('D')->setWidth(12);
$spreadsheet->getActiveSheet(1)->getColumnDimension('E')->setWidth(20);
$spreadsheet->getActiveSheet(1)->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet(1)->getColumnDimension('G')->setWidth(20);*/
//negrita
$spreadsheet->getActiveSheet(1)->getStyle('A1:I1')->getFont()->setBold(true);
//Coloreo celdas
$spreadsheet->getActiveSheet(1)->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
//coloreo fuentes
$spreadsheet->getActiveSheet(1)->getStyle('A1:I1')->getFont()->getColor()->setRGB('FFFFFF');
//Pongo los bordes
$spreadsheet->getActiveSheet(1)->getStyle('A1:I'.$nn)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('rgb' => '333333')
            )
        )
    )
);

/**********************************************************************************/
/*                                    Pagina 3                                    */
/**********************************************************************************/
//Se crea nueva hoja
$spreadsheet->createSheet();

//variables
$nn = 1;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.$nn, 'Sistema')
            ->setCellValue('B'.$nn, 'Equipo')
            ->setCellValue('C'.$nn, 'Tab')
            ->setCellValue('D'.$nn, 'Fecha Inicio')
            ->setCellValue('E'.$nn, 'Hora Inicio')
            ->setCellValue('F'.$nn, 'Fecha Termino')
            ->setCellValue('G'.$nn, 'Hora Termino')
            ->setCellValue('H'.$nn, 'Tiempo');

//variables
$nn = 2;
//Recorro
foreach ($arrErrores as $error) {

	$spreadsheet->setActiveSheetIndex(2)
				->setCellValue('A'.$nn, DeSanitizar($error['Sistema']))
				->setCellValue('B'.$nn, DeSanitizar($error['EquipoNombre']))
				->setCellValue('C'.$nn, DeSanitizar($error['EquipoTab']))
				->setCellValue('D'.$nn, $error['Fecha_inicio'])
				->setCellValue('E'.$nn, $error['Hora_inicio'])
				->setCellValue('F'.$nn, $error['Fecha_termino'])
				->setCellValue('G'.$nn, $error['Hora_termino'])
				->setCellValue('H'.$nn, $error['Tiempo']);

	//Se suma 1
	$nn++;

}

//seteo el nombre de la hoja
$spreadsheet->getActiveSheet(2)->setTitle('Fuera de Linea');
//ancho de columnas
/*$spreadsheet->getActiveSheet(2)->getColumnDimension('A')->setWidth(50);
$spreadsheet->getActiveSheet(2)->getColumnDimension('B')->setWidth(80);
$spreadsheet->getActiveSheet(2)->getColumnDimension('C')->setWidth(12);
$spreadsheet->getActiveSheet(2)->getColumnDimension('D')->setWidth(12);
$spreadsheet->getActiveSheet(2)->getColumnDimension('E')->setWidth(20);
$spreadsheet->getActiveSheet(2)->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet(2)->getColumnDimension('G')->setWidth(20);*/
//negrita
$spreadsheet->getActiveSheet(2)->getStyle('A1:H1')->getFont()->setBold(true);
//Coloreo celdas
$spreadsheet->getActiveSheet(2)->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
//coloreo fuentes
$spreadsheet->getActiveSheet(2)->getStyle('A1:H1')->getFont()->getColor()->setRGB('FFFFFF');
//Pongo los bordes
$spreadsheet->getActiveSheet(2)->getStyle('A1:H'.$nn)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('rgb' => '333333')
            )
        )
    )
);

/**********************************************************************************/
/*                                    Pagina 4                                    */
/**********************************************************************************/
//Se crea nueva hoja
$spreadsheet->createSheet();

//variables
$nn = 1;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.$nn, 'Sistema')
            ->setCellValue('B'.$nn, 'Equipo')
            ->setCellValue('C'.$nn, 'Tab')
            ->setCellValue('D'.$nn, 'Fecha Inicio')
            ->setCellValue('E'.$nn, 'Hora Inicio')
            ->setCellValue('F'.$nn, 'Tiempo Actual');

//variables
$nn = 2;
//Recorro
/*************************************************************/
//Listado de fuera de linea actuales
foreach ($arrTelemetria as $tel) {

	$diaInicio   = $tel['LastUpdateFecha'];
	$diaTermino  = fecha_actual();
	$tiempo1     = $tel['LastUpdateHora'];
	$tiempo2     = hora_actual();
	$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

	//Comparaciones de tiempo
	$Time_Tiempo     = horas2segundos($Tiempo);
	$Time_Tiempo_FL  = horas2segundos($tel['TiempoFueraLinea']);
	$Time_Tiempo_Max = horas2segundos('48:00:00');
	$Time_Fake_Ini   = horas2segundos('23:59:50');
	$Time_Fake_Fin   = horas2segundos('24:00:00');
	//comparacion
	if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
		$spreadsheet->setActiveSheetIndex(3)
					->setCellValue('A'.$nn, DeSanitizar($tel['Sistema']))
					->setCellValue('B'.$nn, DeSanitizar($tel['EquipoNombre']))
					->setCellValue('C'.$nn, DeSanitizar($tel['EquipoTab']))
					->setCellValue('D'.$nn, $tel['LastUpdateFecha'])
					->setCellValue('E'.$nn, $tel['LastUpdateHora'])
					->setCellValue('F'.$nn, $Tiempo);

		//Se suma 1
		$nn++;
	}

}

//seteo el nombre de la hoja
$spreadsheet->getActiveSheet(3)->setTitle('Fuera de Linea Actual');
//ancho de columnas
/*$spreadsheet->getActiveSheet(3)->getColumnDimension('A')->setWidth(50);
$spreadsheet->getActiveSheet(3)->getColumnDimension('B')->setWidth(80);
$spreadsheet->getActiveSheet(3)->getColumnDimension('C')->setWidth(12);
$spreadsheet->getActiveSheet(3)->getColumnDimension('D')->setWidth(12);
$spreadsheet->getActiveSheet(3)->getColumnDimension('E')->setWidth(20);
$spreadsheet->getActiveSheet(3)->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet(3)->getColumnDimension('G')->setWidth(20);*/
//negrita
$spreadsheet->getActiveSheet(3)->getStyle('A1:F1')->getFont()->setBold(true);
//Coloreo celdas
$spreadsheet->getActiveSheet(3)->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
//coloreo fuentes
$spreadsheet->getActiveSheet(3)->getStyle('A1:F1')->getFont()->getColor()->setRGB('FFFFFF');
//Pongo los bordes
$spreadsheet->getActiveSheet(3)->getStyle('A1:F'.$nn)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('rgb' => '333333')
            )
        )
    )
);
/**********************************************************************************/
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Administrador - Alertas 999';
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
