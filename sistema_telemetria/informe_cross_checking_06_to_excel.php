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
//obtengo los datos de la empresa
$rowEmpresa = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema='.$_GET['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');

/**********************************************************/
//Variable de busqueda
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado_cuarteles.idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_programacion BETWEEN '".$_GET['f_programacion_desde']."' AND '".$_GET['f_programacion_hasta']."'";
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_ejecucion BETWEEN '".$_GET['f_ejecucion_desde']."' AND '".$_GET['f_ejecucion_hasta']."'";
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_termino BETWEEN '".$_GET['f_termino_desde']."' AND '".$_GET['f_termino_hasta']."'";
}

// Se trae un listado con todos los elementos
$SIS_query = '
sistema_variedades_categorias.Nombre AS EspecieNombre,
variedades_listado.Nombre AS VariedadNombre,
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_predios_listado.Nombre AS PredioNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
cross_solicitud_aplicacion_listado.f_termino,
cross_solicitud_aplicacion_listado.f_termino_fin,
cross_predios_listado_zonas.Plantas AS CuartelPlantas,
cross_checking_estado_fenologico.Nombre AS EstadoFenologico,
core_estado_solicitud.Nombre AS EstadoSolicitud,
core_estado_ejecucion.Nombre AS EstadoEjecucion,

cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
cross_solicitud_aplicacion_listado_cuarteles.idCuarteles AS ID_1,
cross_solicitud_aplicacion_listado_cuarteles.VelTractor,
(SELECT SUM(GeoDistance)                                          FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS GeoDistance,
(SELECT AVG(NULLIF(IF(GeoVelocidadProm!=0,GeoVelocidadProm,0),0)) FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS VelPromedio,
(SELECT AVG(NULLIF(IF(Sensor_1_Prom!=0,Sensor_1_Prom,0),0))       FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS CaudalDerecho,
(SELECT AVG(NULLIF(IF(Sensor_2_Prom!=0,Sensor_2_Prom,0),0))       FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS CaudalIzquierdo,
(SELECT SUM(Diferencia)                                           FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS LitrosAplicados,
(SELECT AVG(NULLIF(IF(Sensor_4_Prom!=0,Sensor_4_Prom,0),0))       FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS PH';
$SIS_join  = '
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `usuarios_listado`                               ON usuarios_listado.idUsuario                                 = cross_solicitud_aplicacion_listado.idUsuario
LEFT JOIN `core_estado_solicitud`                          ON core_estado_solicitud.idEstado                             = cross_solicitud_aplicacion_listado.idEstado
LEFT JOIN `cross_checking_estado_fenologico`               ON cross_checking_estado_fenologico.idEstadoFen               = cross_solicitud_aplicacion_listado.idEstadoFen
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `trabajadores_listado`     dosificador           ON dosificador.idTrabajador                                   = cross_solicitud_aplicacion_listado.idDosificador
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `core_estado_ejecucion`                          ON core_estado_ejecucion.idEjecucion                          = cross_solicitud_aplicacion_listado_cuarteles.idEjecucion';
$SIS_order = 'cross_solicitud_aplicacion_listado.NSolicitud ASC';
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOTS');

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

//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Agro Checking - Exportar Datos');

//variables
$nn=2;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Predio')
            ->setCellValue('B'.$nn, 'Especie')
            ->setCellValue('C'.$nn, 'Variedad')
            ->setCellValue('D'.$nn, '# Solicitud')
            ->setCellValue('E'.$nn, 'Cuartel')
            ->setCellValue('F'.$nn, 'Hectáreas')
            ->setCellValue('G'.$nn, 'Plantas cuartel')
            ->setCellValue('H'.$nn, 'Estado Fenologico')
            ->setCellValue('I'.$nn, 'Estado Solicitud')
            ->setCellValue('J'.$nn, 'Estado Ejecucion')
            ->setCellValue('K'.$nn, 'Fecha Programacion Inicio')
            ->setCellValue('L'.$nn, 'Fin Aplicación')
            ->setCellValue('M'.$nn, 'Veloc. Recomendada')
            ->setCellValue('N'.$nn, 'Veloc. Promedio')
            ->setCellValue('O'.$nn, 'Caudal Izquierdo')
            ->setCellValue('P'.$nn, 'Caudal Derecho')
            ->setCellValue('Q'.$nn, 'lts. Aplicados')
			->setCellValue('R'.$nn, 'Lts. Hectarias')
            ->setCellValue('S'.$nn, 'PH');
            

//variables
$nn=3;
foreach ($arrOTS as $temp) {
	//se verifica plantas faltantes
	if(isset($temp['GeoDistance'])&&$temp['GeoDistance']!=0&&isset($temp['CuartelDistanciaPlant'])&&$temp['CuartelDistanciaPlant']!=''&&$temp['CuartelDistanciaPlant']!=0){
		$aplicadas = (($temp['GeoDistance']*1000)/$temp['CuartelDistanciaPlant']);
		if($aplicadas<0){
			$aplicadas = 0;
		}
	}else{
		$aplicadas = 0;
	}
	//calculo de los litros por hectarea
	if(isset($temp['CuartelHectareas'])&&$temp['CuartelHectareas']!=''&&$temp['CuartelHectareas']!=0){
		$litrosxhectarea = $temp['LitrosAplicados'] / $temp['CuartelHectareas'];
	}else{
		$litrosxhectarea = 0;
	}

	//subfiltro
	if(isset($temp['EspecieNombre'])&&$temp['EspecieNombre']!=''){  $EspecieNombre  = $temp['EspecieNombre'];  }else{$EspecieNombre  = 'Todas las Especies';} 
	if(isset($temp['VariedadNombre'])&&$temp['VariedadNombre']!=''){$VariedadNombre = $temp['VariedadNombre'];}else{$VariedadNombre = 'Todas las Variedades';}
																			
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($temp['PredioNombre']))
				->setCellValue('B'.$nn, DeSanitizar($EspecieNombre))
				->setCellValue('C'.$nn, DeSanitizar($VariedadNombre))
				->setCellValue('D'.$nn, DeSanitizar($temp['NSolicitud']))
				->setCellValue('E'.$nn, DeSanitizar($temp['CuartelNombre']))
				->setCellValue('F'.$nn, DeSanitizar($temp['CuartelHectareas']))
				->setCellValue('G'.$nn, DeSanitizar($temp['CuartelPlantas']))
				->setCellValue('H'.$nn, DeSanitizar($temp['EstadoFenologico']))
				->setCellValue('I'.$nn, DeSanitizar($temp['EstadoSolicitud']))
				->setCellValue('J'.$nn, DeSanitizar($temp['EstadoEjecucion']))
				->setCellValue('K'.$nn, $temp['f_termino'])
				->setCellValue('L'.$nn, $temp['f_termino_fin'])
				->setCellValue('M'.$nn, cantidades_excel(Cantidades($temp['VelTractor'],1)))
				->setCellValue('N'.$nn, cantidades_excel(Cantidades($temp['VelPromedio'],1)))
				->setCellValue('O'.$nn, cantidades_excel(Cantidades($temp['CaudalDerecho'],1)))
				->setCellValue('P'.$nn, cantidades_excel(Cantidades($temp['CaudalIzquierdo'],1)))
				->setCellValue('Q'.$nn, cantidades_excel(Cantidades($temp['LitrosAplicados'],1)))
				->setCellValue('R'.$nn, cantidades_excel(Cantidades($litrosxhectarea,1)))
				->setCellValue('S'.$nn, cantidades_excel(Cantidades($temp['PH'],1)));

	//Se suma 1
	$nn++;
}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Exportacion');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Resumen Aplicación por estado de solicitud';
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
