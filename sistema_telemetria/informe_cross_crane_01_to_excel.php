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
//variables
$x = 1;
$arrData = array();
//$arrData[$x] = "B"; $x++;
//$arrData[$x] = "C"; $x++;
$arrData[$x] = "D"; $x++;
$arrData[$x] = "E"; $x++;
$arrData[$x] = "F"; $x++;
$arrData[$x] = "G"; $x++;
$arrData[$x] = "H"; $x++;
$arrData[$x] = "I"; $x++;
$arrData[$x] = "J"; $x++;
$arrData[$x] = "K"; $x++;
$arrData[$x] = "L"; $x++;
$arrData[$x] = "M"; $x++;
$arrData[$x] = "N"; $x++;
$arrData[$x] = "O"; $x++;
$arrData[$x] = "P"; $x++;
$arrData[$x] = "Q"; $x++;
$arrData[$x] = "R"; $x++;
$arrData[$x] = "S"; $x++;
$arrData[$x] = "T"; $x++;
$arrData[$x] = "U"; $x++;
$arrData[$x] = "V"; $x++;
$arrData[$x] = "W"; $x++;
$arrData[$x] = "X"; $x++;
$arrData[$x] = "Y"; $x++;
$arrData[$x] = "Z"; $x++;
$arrData[$x] = "AA"; $x++;
$arrData[$x] = "AB"; $x++;
$arrData[$x] = "AC"; $x++;
$arrData[$x] = "AD"; $x++;
$arrData[$x] = "AE"; $x++;
$arrData[$x] = "AF"; $x++;
$arrData[$x] = "AG"; $x++;
$arrData[$x] = "AH"; $x++;
$arrData[$x] = "AI"; $x++;
$arrData[$x] = "AJ"; $x++;
$arrData[$x] = "AK"; $x++;
$arrData[$x] = "AL"; $x++;
$arrData[$x] = "AM"; $x++;
$arrData[$x] = "AN"; $x++;
$arrData[$x] = "AO"; $x++;
$arrData[$x] = "AP"; $x++;
$arrData[$x] = "AQ"; $x++;
$arrData[$x] = "AR"; $x++;
$arrData[$x] = "AS"; $x++;
$arrData[$x] = "AT"; $x++;
$arrData[$x] = "AU"; $x++;
$arrData[$x] = "AV"; $x++;
$arrData[$x] = "AW"; $x++;
$arrData[$x] = "AX"; $x++;
$arrData[$x] = "AY"; $x++;
$arrData[$x] = "AZ"; $x++;
$arrData[$x] = "BA"; $x++;
$arrData[$x] = "BB"; $x++;
$arrData[$x] = "BC"; $x++;
$arrData[$x] = "BD"; $x++;
$arrData[$x] = "BE"; $x++;
$arrData[$x] = "BF"; $x++;
$arrData[$x] = "BG"; $x++;
$arrData[$x] = "BH"; $x++;
$arrData[$x] = "BI"; $x++; 

//obtengo los datos de la empresa
$rowEmpresa = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema='.$_GET['idSistema'], $dbConn, 'arrEquipos1', basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');

/**********************************************************/
$SIS_where_1 = "telemetria_listado_errores.idSistema=".$_GET['idSistema'];
$SIS_where_2 = "telemetria_listado_errores.idSistema=".$_GET['idSistema'];
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino'] != '' && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."'";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
	$SIS_where_1.=" AND telemetria_listado_errores.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  
	$SIS_where_1.= " AND telemetria_listado_errores.idTelemetria=".$_GET['idTelemetria'];
	$SIS_where_2.= " AND telemetria_listado_errores.idTelemetria=".$_GET['idTelemetria'];
}
//Filtro por unidad medida de energia electrica
$SIS_where_1.= " AND (telemetria_listado_errores.idUniMed=4 OR telemetria_listado_errores.idUniMed=5 OR telemetria_listado_errores.idUniMed=10)";
$SIS_where_2.= " AND (telemetria_listado_errores.idUniMed=4 OR telemetria_listado_errores.idUniMed=5 OR telemetria_listado_errores.idUniMed=10)";
//Agrupo
$SIS_where_1.= " GROUP BY telemetria_listado.Nombre,telemetria_listado_errores.Descripcion, telemetria_listado_errores.Fecha, telemetria_listado_errores.idUniMed";
$SIS_where_2.= " GROUP BY telemetria_listado.Nombre,telemetria_listado_errores.Fecha";

/*********************************************************/					
$SIS_query = '
COUNT(telemetria_listado_errores.idErrores) AS Cuenta,
telemetria_listado.Nombre AS Equipo,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Descripcion,
telemetria_listado_unidad_medida.Nombre AS Unimed,
MIN(telemetria_listado_errores.Valor) AS Valor_min,
MAX(telemetria_listado_errores.Valor) AS Valor_max';
$SIS_join  = '
LEFT JOIN telemetria_listado               ON telemetria_listado.idTelemetria             = telemetria_listado_errores.idTelemetria
LEFT JOIN telemetria_listado_unidad_medida ON telemetria_listado_unidad_medida.idUniMed   = telemetria_listado_errores.idUniMed';
$SIS_order = 'telemetria_listado.Nombre ASC, telemetria_listado_errores.Descripcion ASC, telemetria_listado_errores.Fecha ASC';
$arrEquipos1 = array();
$arrEquipos1 = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, 'arrEquipos1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos1');

/*********************************************************/
$SIS_query = '
COUNT(telemetria_listado_errores.idErrores) AS Cuenta,
telemetria_listado.Nombre AS Equipo,
telemetria_listado_errores.Fecha';
$SIS_join  = 'LEFT JOIN telemetria_listado ON telemetria_listado.idTelemetria = telemetria_listado_errores.idTelemetria';
$SIS_order = 'telemetria_listado.Nombre ASC, telemetria_listado_errores.Fecha  DESC LIMIT 10000';
$arrEquipos2 = array();
$arrEquipos2 = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, 'arrEquipos2', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos2');

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
//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Recuento Total de alertas fuera de rango');

//variables
$nn=2;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$nn, 'Equipo')
            ->setCellValue('B'.$nn, 'Descripcion')
            ->setCellValue('C'.$nn, 'Fecha')
            ->setCellValue('D'.$nn, 'N° Registros')
            ->setCellValue('E'.$nn, 'Minimo Observado')
            ->setCellValue('F'.$nn, 'Maximo Observado')
            ->setCellValue('G'.$nn, 'Unidad Medida');

//variables
$nn     = 3;

foreach ($arrEquipos1 as $equip) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($equip['Equipo']))
				->setCellValue('B'.$nn, DeSanitizar($equip['Descripcion']))
				->setCellValue('C'.$nn, fecha_estandar($equip['Fecha']))
				->setCellValue('D'.$nn, DeSanitizar($equip['Cuenta']))
				->setCellValue('E'.$nn, Cantidades($equip['Valor_min'], 2))
				->setCellValue('F'.$nn, Cantidades($equip['Valor_max'], 2))
				->setCellValue('G'.$nn, DeSanitizar($equip['Unimed']));

	//Se suma 1
	$nn++;
}
//seteo el nombre de la hoja
$spreadsheet->getActiveSheet(0)->setTitle('Recuento Total');
//ancho de columnas
$spreadsheet->getActiveSheet(0)->getColumnDimension('A')->setWidth(50);
$spreadsheet->getActiveSheet(0)->getColumnDimension('B')->setWidth(80);
$spreadsheet->getActiveSheet(0)->getColumnDimension('C')->setWidth(12);
$spreadsheet->getActiveSheet(0)->getColumnDimension('D')->setWidth(12);
$spreadsheet->getActiveSheet(0)->getColumnDimension('E')->setWidth(20);
$spreadsheet->getActiveSheet(0)->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet(0)->getColumnDimension('G')->setWidth(20);
//negrita
$spreadsheet->getActiveSheet(0)->getStyle('A1:G2')->getFont()->setBold(true);
//Coloreo celdas
$spreadsheet->getActiveSheet(0)->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
$spreadsheet->getActiveSheet(0)->getStyle('A2:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
//coloreo fuentes
$spreadsheet->getActiveSheet(0)->getStyle('A2:G2')->getFont()->getColor()->setRGB('FFFFFF');
//Pongo los bordes
$spreadsheet->getActiveSheet(0)->getStyle('A1:G'.$nn)->applyFromArray(
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

//Titulo columnas
$spreadsheet->setActiveSheetIndex(1)
			->setCellValue('A1', 'Recuento Total de alertas fuera de rango por Dia');

//variables
$nn=2;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.$nn, 'Equipo');

$spreadsheet->setActiveSheetIndex(1)
				->setCellValue('B'.$nn, 'Total Registros');
			
$spreadsheet->setActiveSheetIndex(1)
				->setCellValue('C'.$nn, 'Promedio Registros');
				
//Creo las columnas            
$ndias = dias_transcurridos($_GET['f_inicio'], $_GET['f_termino']);
for ($i = 1; $i <= $ndias; $i++) {
	$nuevoDia = sumarDias($_GET['f_inicio'],$i);
	$spreadsheet->setActiveSheetIndex(1)
				->setCellValue($arrData[$i].$nn, Dia_Mes($nuevoDia));
}   

								                 
/**************************************************************/
//variables
$nn           = 3;
$ndias        = dias_transcurridos($_GET['f_inicio'], $_GET['f_termino']);
$nColumnProm  = 1;
//filtro por equipo
filtrar($arrEquipos2, 'Equipo');
//recorro los equipos 
foreach($arrEquipos2 as $equipo=>$dias){
	       
	//creo un arreglo
	$DiaActual = array();
	for ($i = 1; $i <= $ndias; $i++) {
		$nuevoDia = sumarDias($_GET['f_inicio'],$i);
		$DiaActual[$i]['fecha'] = $nuevoDia;
		$DiaActual[$i]['valor'] = 0;
	}

	//Variables
	$TotalErrores = 0;
	//recorro los dias
	foreach ($dias as $dia) {
		//recorro arreglo
		for ($i = 1; $i <= $ndias; $i++) {
			if(isset($dia['Fecha'])&&$dia['Fecha']==$DiaActual[$i]['fecha']){
				$DiaActual[$i]['valor'] = $DiaActual[$i]['valor'] + $dia['Cuenta'];
				$TotalErrores           = $TotalErrores + $dia['Cuenta'];
			}
		}
	}

	//Nombre del equipo
	$spreadsheet->setActiveSheetIndex(1)
				->setCellValue('A'.$nn, $equipo);
	//Total Errores
	$spreadsheet->setActiveSheetIndex(1)
				->setCellValue('B'.$nn, $TotalErrores);
	//Promedios
	if($ndias!=0){$ss_to = $TotalErrores/$ndias;}else{$ss_to = 0;}
	$spreadsheet->setActiveSheetIndex(1)
				->setCellValue('C'.$nn, cantidades($ss_to, 2));			
									
	//recorro los datos guardados
	for ($i = 1; $i <= $ndias; $i++) {
		$spreadsheet->setActiveSheetIndex(1)
					->setCellValue($arrData[$i].$nn, $DiaActual[$i]['valor']);
	}		

			
	//Se suma 1
	$nn++;
	//Guardo la columna donde estan los promedios
	$nColumnProm  = $i;
}	
				                       
//seteo el nombre de la hoja
$spreadsheet->getActiveSheet(1)->setTitle('Recuento Total por Dia');
//negrita
$spreadsheet->getActiveSheet(1)->getStyle('A1:'.$arrData[$i].'2')->getFont()->setBold(true);
//Coloreo celdas
$spreadsheet->getActiveSheet(1)->getStyle('A1:'.$arrData[$i].'2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
//Pongo los bordes
$spreadsheet->getActiveSheet(1)->getStyle('A1:'.$arrData[$i].$nn)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('rgb' => '333333')
            )
        )
    )
);
//ancho de columnas
$spreadsheet->getActiveSheet(1)->getColumnDimension('A')->setWidth(60);
$spreadsheet->getActiveSheet(1)->getColumnDimension('B')->setWidth(20);
$spreadsheet->getActiveSheet(1)->getColumnDimension('C')->setWidth(20);
for ($i = 1; $i <= $ndias; $i++) {
	$spreadsheet->getActiveSheet(1)->getColumnDimension($arrData[$i])->setWidth(10);
}

/**************************************************************/


/*  
//datos de origen
$categories = new PHPExcel_Chart_DataSeriesValues('String', 'Recuento Total por Dia!$A$3:$A$'.$nn);
$values     = new PHPExcel_Chart_DataSeriesValues('Number', 'Recuento Total por Dia!$D$3:$'.$arrData[$nColumnProm].'$'.$nn);

//Opciones
$series = new PHPExcel_Chart_DataSeries(
    PHPExcel_Chart_DataSeries::TYPE_AREACHART,       // plotType
    PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
    array(0),                                       // plotOrder
    array(),                                        // plotLabel
    array($categories),                             // plotCategory
    array($values)                                  // plotValues
);

//$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_VERTICAL);

$layout   = new PHPExcel_Chart_Layout();
$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
$xTitle   = new PHPExcel_Chart_Title('Equipo');
$yTitle   = new PHPExcel_Chart_Title('yAxisLabel');
$legend   = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);
$title    = new PHPExcel_Chart_Title('Test Area Chart');



$chart = new PHPExcel_Chart('sample', $title, $legend, $plotarea, true,0,$xTitle,$yTitle);

$LeftPos  = $nn + 3;
$RightPos = $nn + 15;
$chart->setTopLeftPosition('A'.$LeftPos);
$chart->setBottomRightPosition('J'.$RightPos);

$spreadsheet->getActiveSheet(1)->addChart($chart);

*/

/**********************************************************************************/
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Power-Crane - Alertas por Grua';
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
