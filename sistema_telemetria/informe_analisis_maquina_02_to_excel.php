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

//filtros
$SIS_where_1 = "maquinas_listado_matriz.idMatriz>=0";
$SIS_where_2 = "maquinas_listado.idMaquina>=0";
$SIS_where_3 = "analisis_listado.idAnalisis>=0";
if(isset($_GET['idSistema']) && $_GET['idSistema'] != ''){
	$SIS_where_3 .= " AND analisis_listado.idSistema = '".$_GET['idSistema']."'";
}
if(isset($_GET['idMaquina']) && $_GET['idMaquina'] != ''){
	$SIS_where_2 .= " AND maquinas_listado.idMaquina = '".$_GET['idMaquina']."'";
	$SIS_where_3 .= " AND analisis_listado.idMaquina = '".$_GET['idMaquina']."'";
}
if(isset($_GET['idMatriz']) && $_GET['idMatriz'] != ''){
	$SIS_where_1 .= " AND idMatriz = '".$_GET['idMatriz']."'";
	$SIS_where_2 .= " AND maquinas_listado_matriz.idMatriz = '".$_GET['idMaquina']."'";
	$SIS_where_3 .= " AND analisis_listado.idMatriz = '".$_GET['idMatriz']."'";
}
if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
	$SIS_where_3 .= " AND analisis_listado.f_muestreo BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
/*******************************************************/
$rowpre = db_select_data (false, 'cantPuntos', 'maquinas_listado_matriz', '', $SIS_where_1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowpre');

/*******************************************************/
// consulto los datos
$SIS_query = '
maquinas_listado.Codigo AS MaquinaCodigo,
maquinas_listado.Nombre AS MaquinaNombre,
maquinas_listado.Modelo AS MaquinaModelo,
maquinas_listado.Serie AS MaquinaSerie,
maquinas_listado.Fabricante AS MaquinaFabricante,
ubicacion_listado.Nombre  AS MaquinaUbicacion,
ubicacion_listado_level_1.Nombre  AS MaquinaUbicacion_lvl_1,
ubicacion_listado_level_2.Nombre  AS MaquinaUbicacion_lvl_2,
ubicacion_listado_level_3.Nombre  AS MaquinaUbicacion_lvl_3,
ubicacion_listado_level_4.Nombre  AS MaquinaUbicacion_lvl_4,
ubicacion_listado_level_5.Nombre  AS MaquinaUbicacion_lvl_5,
core_sistemas.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
core_sistemas.Direccion AS SistemaOrigenDireccion,
core_sistemas.Contacto_Fono1 AS SistemaOrigenFono,
core_sistemas.email_principal AS SistemaOrigenEmail,
core_sistemas.Rut AS SistemaOrigenRut,
maquinas_listado_matriz.Nombre AS Analisis_Nombre';
for ($i = 1; $i <= 50; $i++) {
    $SIS_query .= ',maquinas_listado_matriz.PuntoNombre_'.$i.' AS PuntoNombre_'.$i;
    $SIS_query .= ',maquinas_listado_matriz.PuntoMedAceptable_'.$i.' AS PuntoMedAceptable_'.$i;
    $SIS_query .= ',maquinas_listado_matriz.PuntoMedAlerta_'.$i.' AS PuntoMedAlerta_'.$i;
    $SIS_query .= ',maquinas_listado_matriz.PuntoMedCondenatorio_'.$i.' AS PuntoMedCondenatorio_'.$i;
    $SIS_query .= ',maquinas_listado_matriz.PuntoUniMed_'.$i.' AS PuntoUniMed_'.$i;
    $SIS_query .= ',maquinas_listado_matriz.PuntoidTipo_'.$i.' AS PuntoidTipo_'.$i;
    $SIS_query .= ',maquinas_listado_matriz.PuntoidGrupo_'.$i.' AS PuntoidGrupo_'.$i;
}
$SIS_join  = '
LEFT JOIN `ubicacion_listado`                       ON ubicacion_listado.idUbicacion           = maquinas_listado.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`               ON ubicacion_listado_level_1.idLevel_1     = maquinas_listado.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`               ON ubicacion_listado_level_2.idLevel_2     = maquinas_listado.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`               ON ubicacion_listado_level_3.idLevel_3     = maquinas_listado.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`               ON ubicacion_listado_level_4.idLevel_4     = maquinas_listado.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`               ON ubicacion_listado_level_5.idLevel_5     = maquinas_listado.idUbicacion_lvl_5
LEFT JOIN `maquinas_listado_matriz`                 ON maquinas_listado_matriz.idMaquina       = maquinas_listado.idMaquina
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                 = maquinas_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                  = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                  = core_sistemas.idComuna';
$rowMaquina = db_select_data (false, $SIS_query, 'maquinas_listado', '', $SIS_where_2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowMaquina');

/*******************************************************/
// consulto los datos
$SIS_query = 'core_analisis_estado.Nombre AS AnalisisEstado, analisis_listado.f_muestreo';
for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
	$SIS_query .= ',analisis_listado.Medida_'.$i.' AS Analisis_Medida_'.$i;
}
$SIS_join  = 'LEFT JOIN `core_analisis_estado` ON core_analisis_estado.idEstado = analisis_listado.idEstado';
$SIS_order = 'analisis_listado.f_muestreo ASC';
$arrResultados = array();
$arrResultados = db_select_array (false, $SIS_query, 'analisis_listado', $SIS_join, $SIS_where_3, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrResultados');

/*******************************************************/
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUml,Nombre', 'sistema_analisis_uml', '', '', 'idUml ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

/*******************************************************/
$arrGrupo = array();
$arrGrupo = db_select_array (false, 'idGrupo, Nombre', 'maquinas_listado_matriz_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupo');

/*******************************************************/
$arrProducto = array();
$arrProducto = db_select_array (false, 'idProducto, Nombre', 'productos_listado', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProducto');

/*******************************************************/
$arrDispersancia = array();
$arrDispersancia = db_select_array (false, 'idDispersancia, Nombre', 'core_analisis_dispersancia', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDispersancia');

/*******************************************************/
$arrFlashpoint = array();
$arrFlashpoint = db_select_array (false, 'idFlashPoint, Nombre', 'core_analisis_flashpoint', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFlashpoint');

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
			->setCellValue('A1', $rowMaquina['Analisis_Nombre'].' '.Fecha_estandar(fecha_actual()));

//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A3', 'Maquina')
            ->setCellValue('B3', 'Empresa');
//Maquina y empresa
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A4', DeSanitizar($rowMaquina['MaquinaNombre']))
            ->setCellValue('B4', DeSanitizar($rowMaquina['SistemaOrigen']))
			->setCellValue('A5', 'Codigo: '.DeSanitizar($rowMaquina['MaquinaCodigo']))
            ->setCellValue('B5', DeSanitizar($rowMaquina['SistemaOrigenCiudad'].', '.$rowMaquina['SistemaOrigenComuna']))
			->setCellValue('A6', 'Modelo: '.DeSanitizar($rowMaquina['MaquinaModelo']))
            ->setCellValue('B6', DeSanitizar($rowMaquina['SistemaOrigenDireccion']))
			->setCellValue('A7', 'Serie: '.DeSanitizar($rowMaquina['MaquinaSerie']))
            ->setCellValue('B7', 'Fono : '.formatPhone($rowMaquina['SistemaOrigenFono']))
			->setCellValue('A8', 'Fabricante: '.DeSanitizar($rowMaquina['MaquinaFabricante']))
            ->setCellValue('B8', 'Rut: '.DeSanitizar($rowMaquina['SistemaOrigenRut']));
/*******************************/
$Ubicacion = 'Ubicación: '.DeSanitizar($rowMaquina['MaquinaUbicacion']);
if(isset($rowMaquina['MaquinaUbicacion_lvl_1'])&&$rowMaquina['MaquinaUbicacion_lvl_1']!=''){
	$Ubicacion .= ' - '.DeSanitizar($rowMaquina['MaquinaUbicacion_lvl_1']);
}
if(isset($rowMaquina['MaquinaUbicacion_lvl_2'])&&$rowMaquina['MaquinaUbicacion_lvl_2']!=''){
	$Ubicacion .= ' - '.DeSanitizar($rowMaquina['MaquinaUbicacion_lvl_2']);
}
if(isset($rowMaquina['MaquinaUbicacion_lvl_3'])&&$rowMaquina['MaquinaUbicacion_lvl_3']!=''){
	$Ubicacion .= ' - '.DeSanitizar($rowMaquina['MaquinaUbicacion_lvl_3']);
}
if(isset($rowMaquina['MaquinaUbicacion_lvl_4'])&&$rowMaquina['MaquinaUbicacion_lvl_4']!=''){
	$Ubicacion .= ' - '.DeSanitizar($rowMaquina['MaquinaUbicacion_lvl_4']);
}
if(isset($rowMaquina['MaquinaUbicacion_lvl_5'])&&$rowMaquina['MaquinaUbicacion_lvl_5']!=''){
	$Ubicacion .= ' - '.DeSanitizar($rowMaquina['MaquinaUbicacion_lvl_5']);
}

$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A9', $Ubicacion)
            ->setCellValue('B9', 'Email: '.DeSanitizar($rowMaquina['SistemaOrigenEmail']));

//variables
$nn=11;
//arreglo
foreach ($arrGrupo as $grupo) {
	//recorro los puntos
	for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
		//verifico que pertenezcan al mismo grupo
		if($grupo['idGrupo']==$rowMaquina['PuntoidGrupo_'.$i]){
			//obtengo la unidad de medida
			$uniMed = '';
			foreach ($arrUnimed as $med) {
				if($rowMaquina['PuntoUniMed_'.$i]==$med['idUml']){
					$uniMed = $med['Nombre'];
				}
			}
			//reviso el tipo de resultado
			switch ($rowMaquina['PuntoidTipo_'.$i]) {
				//Medidas
				case 1:
					//
					$spreadsheet->setActiveSheetIndex(0)
								->setCellValue('A'.$nn, 'Fecha')
								->setCellValue('B'.$nn, 'Valor')
								->setCellValue('C'.$nn, 'Aceptable')
								->setCellValue('D'.$nn, 'Alerta')
								->setCellValue('E'.$nn, 'Condenatorio')
								->setCellValue('F'.$nn, 'Unidad Medida');

					//recorro los resultados
					foreach ($arrResultados as $result) {
						$spreadsheet->setActiveSheetIndex(0)
									->setCellValue('A'.$nn, fecha_estandar($result['f_muestreo']))
									->setCellValue('B'.$nn, Cantidades_decimales_justos($result['Analisis_Medida_'.$i]))
									->setCellValue('C'.$nn, Cantidades_decimales_justos($rowMaquina['PuntoMedAceptable_'.$i]))
									->setCellValue('D'.$nn, Cantidades_decimales_justos($rowMaquina['PuntoMedAlerta_'.$i]))
									->setCellValue('E'.$nn, Cantidades_decimales_justos($rowMaquina['PuntoMedCondenatorio_'.$i]))
									->setCellValue('F'.$nn, DeSanitizar($uniMed));

						//Suma de 1
						$nn++;
					}

					//Suma de 1
					$nn++;
				break;
				//Producto
				case 2:
					//Suma de 1
					$nn++;
				break;
				//Dispersancia
				case 3:
					//Suma de 1
					$nn++;
				break;
				//Flashpoint
				case 4:
					//Suma de 1
					$nn++;
				break;
			}
		}
	}
}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Analisis');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Analisis Comparativo Maquina al '.fecha_actual();
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
