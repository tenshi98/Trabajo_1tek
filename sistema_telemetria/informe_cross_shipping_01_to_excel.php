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

//Variable con la ubicacion
$SIS_where = "cross_shipping_consolidacion.idConsolidacion!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['CTNNombreCompañia'])&&$_GET['CTNNombreCompañia']!=''){  $SIS_where .=" AND cross_shipping_consolidacion.CTNNombreCompañia LIKE '%".EstandarizarInput($_GET['CTNNombreCompañia'])."%'";}
if(isset($_GET['NInforme'])&&$_GET['NInforme']!=''){                    $SIS_where .=" AND cross_shipping_consolidacion.NInforme LIKE '%".EstandarizarInput($_GET['NInforme'])."%'";}
if(isset($_GET['FechaInicioEmbarque'])&&$_GET['FechaInicioEmbarque']!=''){     $SIS_where .=" AND cross_shipping_consolidacion.FechaInicioEmbarque='".$_GET['FechaInicioEmbarque']."'";}
if(isset($_GET['HoraInicioCarga'])&&$_GET['HoraInicioCarga']!=''){      $SIS_where .=" AND cross_shipping_consolidacion.HoraInicioCarga='".$_GET['HoraInicioCarga']."'";}
if(isset($_GET['FechaTerminoEmbarque'])&&$_GET['FechaTerminoEmbarque']!=''){   $SIS_where .=" AND cross_shipping_consolidacion.FechaTerminoEmbarque='".$_GET['FechaTerminoEmbarque']."'";}
if(isset($_GET['HoraTerminoCarga'])&&$_GET['HoraTerminoCarga']!=''){    $SIS_where .=" AND cross_shipping_consolidacion.HoraTerminoCarga='".$_GET['HoraTerminoCarga']."'";}
if(isset($_GET['idPlantaDespacho'])&&$_GET['idPlantaDespacho']!=''){    $SIS_where .=" AND cross_shipping_consolidacion.idPlantaDespacho=".$_GET['idPlantaDespacho'];}
if(isset($_GET['idCategoria'])&&$_GET['idCategoria']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto'])&&$_GET['idProducto']!=''){                $SIS_where .=" AND cross_shipping_consolidacion.idProducto=".$_GET['idProducto'];}
if(isset($_GET['CantidadCajas'])&&$_GET['CantidadCajas']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.CantidadCajas LIKE '%".EstandarizarInput($_GET['CantidadCajas'])."%'";}
if(isset($_GET['idInstructivo'])&&$_GET['idInstructivo']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.idInstructivo=".$_GET['idInstructivo'];}
if(isset($_GET['idNaviera'])&&$_GET['idNaviera']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idNaviera=".$_GET['idNaviera'];}
if(isset($_GET['idPuertoEmbarque'])&&$_GET['idPuertoEmbarque']!=''){    $SIS_where .=" AND cross_shipping_consolidacion.idPuertoEmbarque=".$_GET['idPuertoEmbarque'];}
if(isset($_GET['idMercado'])&&$_GET['idMercado']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idMercado=".$_GET['idMercado'];}
if(isset($_GET['idPais'])&&$_GET['idPais']!=''){                        $SIS_where .=" AND cross_shipping_consolidacion.idPais=".$_GET['idPais'];}
if(isset($_GET['idEmpresaTransporte'])&&$_GET['idEmpresaTransporte']!=''){     $SIS_where .=" AND cross_shipping_consolidacion.idEmpresaTransporte=".$_GET['idEmpresaTransporte'];}
if(isset($_GET['ChoferNombreRut'])&&$_GET['ChoferNombreRut']!=''){      $SIS_where .=" AND cross_shipping_consolidacion.ChoferNombreRut LIKE '%".EstandarizarInput($_GET['ChoferNombreRut'])."%'";}
if(isset($_GET['PatenteCamion'])&&$_GET['PatenteCamion']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.PatenteCamion LIKE '%".EstandarizarInput($_GET['PatenteCamion'])."%'";}
if(isset($_GET['PatenteCarro'])&&$_GET['PatenteCarro']!=''){            $SIS_where .=" AND cross_shipping_consolidacion.PatenteCarro LIKE '%".EstandarizarInput($_GET['PatenteCarro'])."%'";}
if(isset($_GET['idCondicion'])&&$_GET['idCondicion']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.idCondicion=".$_GET['idCondicion'];}
if(isset($_GET['idSellado'])&&$_GET['idSellado']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idSellado=".$_GET['idSellado'];}
if(isset($_GET['TSetPoint'])&&$_GET['TSetPoint']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.TSetPoint=".$_GET['TSetPoint'];}
if(isset($_GET['TVentilacion'])&&$_GET['TVentilacion']!=''){            $SIS_where .=" AND cross_shipping_consolidacion.TVentilacion=".$_GET['TVentilacion'];}
if(isset($_GET['TAmbiente'])&&$_GET['TAmbiente']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.TAmbiente=".$_GET['TAmbiente'];}
if(isset($_GET['NumeroSello'])&&$_GET['NumeroSello']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.NumeroSello LIKE '%".EstandarizarInput($_GET['NumeroSello'])."%'";}
if(isset($_GET['idInspector'])&&$_GET['idInspector']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.idInspector=".$_GET['idInspector'];}
if(isset($_GET['Observaciones'])&&$_GET['Observaciones']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.Observaciones LIKE '%".EstandarizarInput($_GET['Observaciones'])."%'";}
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idSistema=".$_GET['idSistema'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){                    $SIS_where .=" AND cross_shipping_consolidacion.idEstado=".$_GET['idEstado'];}

if(isset($_GET['Creacion_fechaDesde']) && $_GET['Creacion_fechaDesde'] != ''&&isset($_GET['Creacion_fechaHasta']) && $_GET['Creacion_fechaHasta']!=''){
	$SIS_where .= " AND cross_shipping_consolidacion.Creacion_fecha BETWEEN '".$_GET['Creacion_fechaDesde']."' AND '".$_GET['Creacion_fechaHasta']."'";
}

/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
cross_shipping_consolidacion.Creacion_fecha,
cross_shipping_consolidacion.CTNNombreCompañia,
cross_shipping_consolidacion.FechaInicioEmbarque,
cross_shipping_consolidacion.HoraInicioCarga,
cross_shipping_consolidacion.FechaTerminoEmbarque,
cross_shipping_consolidacion.HoraTerminoCarga,
cross_shipping_consolidacion.CantidadCajas,
cross_shipping_consolidacion.ChoferNombreRut,
cross_shipping_consolidacion.PatenteCamion,
cross_shipping_consolidacion.PatenteCarro,
cross_shipping_consolidacion.TSetPoint,
cross_shipping_consolidacion.TVentilacion,
cross_shipping_consolidacion.TAmbiente,
cross_shipping_consolidacion.NumeroSello,
cross_shipping_consolidacion.idInspector,
cross_shipping_consolidacion.Observaciones,
cross_shipping_consolidacion.Observacion,
cross_shipping_consolidacion.Aprobacion_Fecha,
cross_shipping_consolidacion.Aprobacion_Hora,
cross_shipping_consolidacion.idEstado,
cross_shipping_consolidacion.NInforme,

core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS UsuarioCreador,
cross_shipping_plantas.Nombre AS PlantaNombre,
cross_shipping_plantas.Codigo AS PlantaCodigo,
sistema_variedades_categorias.Nombre AS Especie,
variedades_listado.Nombre AS Variedad,
cross_shipping_instructivo.Nombre AS InstructivoNombre,
cross_shipping_instructivo.Codigo AS InstructivoCodigo,
cross_shipping_naviera.Nombre AS NavieraNombre,
cross_shipping_naviera.Codigo AS NavieraCodigo,
cross_shipping_puerto_embarque.Nombre AS EmbarqueNombre,
cross_shipping_puerto_embarque.Codigo AS EmbarqueCodigo,
cross_shipping_mercado.Nombre AS MercadoNombre,
cross_shipping_mercado.Codigo AS MercadoCodigo,
core_paises.Nombre AS PaisesNombre,
cross_shipping_empresa_transporte.Nombre AS TransporteNombre,
cross_shipping_empresa_transporte.Codigo AS TransporteCodigo,
core_cross_shipping_consolidacion_condicion.Nombre AS Condicion,
core_sistemas_opciones.Nombre AS Sellado,
core_oc_estado.Nombre AS Estado,
trabajadores_listado.Nombre AS InspectorNombre,
trabajadores_listado.ApellidoPat AS InspectorApellido,

cross_shipping_consolidacion_estibas.idConsolidacion,
cross_shipping_consolidacion_estibas.idEstibaListado,
cross_shipping_consolidacion_estibas.NPallet,
cross_shipping_consolidacion_estibas.Temperatura,
cross_shipping_consolidacion_estibas.NSerieSensor,

core_estibas.Nombre AS Estiba,
core_estibas_ubicacion.Nombre AS EstibaUbicacion,
core_cross_shipping_consolidacion_posicion.Nombre AS Posicion,
cross_shipping_envase.Nombre AS Envase,
cross_shipping_termografo.Nombre AS Termografo';
$SIS_join  = '
LEFT JOIN `cross_shipping_consolidacion`                 ON cross_shipping_consolidacion.idConsolidacion              = cross_shipping_consolidacion_estibas.idConsolidacion
LEFT JOIN `core_sistemas`                                ON core_sistemas.idSistema                                   = cross_shipping_consolidacion.idSistema
LEFT JOIN `usuarios_listado`                             ON usuarios_listado.idUsuario                                = cross_shipping_consolidacion.idUsuario
LEFT JOIN `cross_shipping_plantas`                       ON cross_shipping_plantas.idPlantaDespacho                   = cross_shipping_consolidacion.idPlantaDespacho
LEFT JOIN `sistema_variedades_categorias`                ON sistema_variedades_categorias.idCategoria                 = cross_shipping_consolidacion.idCategoria
LEFT JOIN `variedades_listado`                           ON variedades_listado.idProducto                             = cross_shipping_consolidacion.idProducto
LEFT JOIN `cross_shipping_instructivo`                   ON cross_shipping_instructivo.idInstructivo                  = cross_shipping_consolidacion.idInstructivo
LEFT JOIN `cross_shipping_naviera`                       ON cross_shipping_naviera.idNaviera                          = cross_shipping_consolidacion.idNaviera
LEFT JOIN `cross_shipping_puerto_embarque`               ON cross_shipping_puerto_embarque.idPuertoEmbarque           = cross_shipping_consolidacion.idPuertoEmbarque
LEFT JOIN `cross_shipping_mercado`                       ON cross_shipping_mercado.idMercado                          = cross_shipping_consolidacion.idMercado
LEFT JOIN `core_paises`                                  ON core_paises.idPais                                        = cross_shipping_consolidacion.idPais
LEFT JOIN `cross_shipping_empresa_transporte`            ON cross_shipping_empresa_transporte.idEmpresaTransporte     = cross_shipping_consolidacion.idEmpresaTransporte
LEFT JOIN `core_cross_shipping_consolidacion_condicion`  ON core_cross_shipping_consolidacion_condicion.idCondicion   = cross_shipping_consolidacion.idCondicion
LEFT JOIN `core_sistemas_opciones`                       ON core_sistemas_opciones.idOpciones                         = cross_shipping_consolidacion.idSellado
LEFT JOIN `core_oc_estado`                               ON core_oc_estado.idEstado                                   = cross_shipping_consolidacion.idEstado
LEFT JOIN `trabajadores_listado`                         ON trabajadores_listado.idTrabajador                         = cross_shipping_consolidacion.idAprobador
LEFT JOIN `core_estibas`                                 ON core_estibas.idEstiba                                     = cross_shipping_consolidacion_estibas.idEstiba
LEFT JOIN `core_estibas_ubicacion`                       ON core_estibas_ubicacion.idEstibaUbicacion                  = cross_shipping_consolidacion_estibas.idEstibaUbicacion
LEFT JOIN `core_cross_shipping_consolidacion_posicion`   ON core_cross_shipping_consolidacion_posicion.idPosicion     = cross_shipping_consolidacion_estibas.idPosicion
LEFT JOIN `cross_shipping_envase`                        ON cross_shipping_envase.idEnvase                            = cross_shipping_consolidacion_estibas.idEnvase
LEFT JOIN `cross_shipping_termografo`                    ON cross_shipping_termografo.idTermografo                    = cross_shipping_consolidacion_estibas.idTermografo';
$SIS_order = 'cross_shipping_consolidacion.Creacion_fecha ASC';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_estibas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'],  basename($_SERVER["REQUEST_URI"], ".php"), 'arrTipo');

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
			->setCellValue('A1', 'Agro Shipping - Exportar Datos');

//variables
$nn=2;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Contenedor Nro.')
            ->setCellValue('B'.$nn, 'Nro. Del Informe')
            ->setCellValue('C'.$nn, 'Fecha del informe')
            ->setCellValue('D'.$nn, 'Fecha Inicio del Embarque')
            ->setCellValue('E'.$nn, 'Hora Inicio Carga')
            ->setCellValue('F'.$nn, 'Fecha Termino del Embarque')
            ->setCellValue('G'.$nn, 'Hora Termino Carga')
            ->setCellValue('H'.$nn, 'Planta Despachadora')
            ->setCellValue('I'.$nn, 'Especie/Variedad')
            ->setCellValue('J'.$nn, 'Cantidad de Cajas')
            ->setCellValue('K'.$nn, 'N° Instructivo')
            ->setCellValue('L'.$nn, 'Naviera')
            ->setCellValue('M'.$nn, 'Puerto Embarque')
            ->setCellValue('N'.$nn, 'Mercado')
            ->setCellValue('O'.$nn, 'Pais')
            ->setCellValue('P'.$nn, 'Empresa Transportista')
            ->setCellValue('Q'.$nn, 'Conductor')
            ->setCellValue('R'.$nn, 'Patente Camion')
            ->setCellValue('S'.$nn, 'Patente Carro')
            ->setCellValue('T'.$nn, 'Condición CTN')
            ->setCellValue('U'.$nn, 'Sellado Piso')
            ->setCellValue('V'.$nn, 'T°Set Point')
            ->setCellValue('W'.$nn, 'T° Ventilacion')
            ->setCellValue('X'.$nn, 'T° Ambiente')
            ->setCellValue('Y'.$nn, 'Numero de sello')
            ->setCellValue('Z'.$nn, 'Inspector')
            ->setCellValue('AA'.$nn, 'Estiba')
            ->setCellValue('AB'.$nn, 'Ubicación')
            ->setCellValue('AC'.$nn, 'Posicion')
            ->setCellValue('AD'.$nn, 'Envase')
            ->setCellValue('AE'.$nn, 'Nro. De Pallet')
            ->setCellValue('AF'.$nn, 'Temp. De Pulpa')
            ->setCellValue('AG'.$nn, 'Marca Modelo Sensor')
            ->setCellValue('AH'.$nn, 'Nro. Serie Sensor');

//variables
$nn=3;
foreach ($arrTipo as $tipo) {
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($tipo['CTNNombreCompañia']))
				->setCellValue('B'.$nn, DeSanitizar($tipo['NInforme']))
				->setCellValue('C'.$nn, $tipo['Creacion_fecha'])
				->setCellValue('D'.$nn, $tipo['FechaInicioEmbarque'])
				->setCellValue('E'.$nn, $tipo['HoraInicioCarga'])
				->setCellValue('F'.$nn, $tipo['FechaTerminoEmbarque'])
				->setCellValue('G'.$nn, $tipo['HoraTerminoCarga'])
				->setCellValue('H'.$nn, DeSanitizar($tipo['PlantaCodigo'].' - '.$tipo['PlantaNombre']))
				->setCellValue('I'.$nn, DeSanitizar($tipo['Especie'].' '.$tipo['Variedad']))
				->setCellValue('J'.$nn, $tipo['CantidadCajas'])
				->setCellValue('K'.$nn, DeSanitizar($tipo['InstructivoCodigo'].' - '.$tipo['InstructivoNombre']))
				->setCellValue('L'.$nn, DeSanitizar($tipo['NavieraCodigo'].' - '.$tipo['NavieraNombre']))
				->setCellValue('M'.$nn, DeSanitizar($tipo['EmbarqueCodigo'].' - '.$tipo['EmbarqueNombre']))
				->setCellValue('N'.$nn, DeSanitizar($tipo['MercadoCodigo'].' - '.$tipo['MercadoNombre']))
				->setCellValue('O'.$nn, DeSanitizar($tipo['PaisesNombre']))
				->setCellValue('P'.$nn, DeSanitizar($tipo['TransporteCodigo'].' - '.$tipo['TransporteNombre']))
				->setCellValue('Q'.$nn, DeSanitizar($tipo['ChoferNombreRut']))
				->setCellValue('R'.$nn, DeSanitizar($tipo['PatenteCamion']))
				->setCellValue('S'.$nn, DeSanitizar($tipo['PatenteCarro']))
				->setCellValue('T'.$nn, DeSanitizar($tipo['Condicion']))
				->setCellValue('U'.$nn, DeSanitizar($tipo['Sellado']))
				->setCellValue('V'.$nn, cantidades_excel($tipo['TSetPoint']))
				->setCellValue('W'.$nn, cantidades_excel($tipo['TVentilacion']))
				->setCellValue('X'.$nn, cantidades_excel($tipo['TAmbiente']))
				->setCellValue('Y'.$nn, DeSanitizar($tipo['NumeroSello']))
				->setCellValue('Z'.$nn, DeSanitizar($tipo['InspectorNombre'].' '.$tipo['InspectorApellido']))
				->setCellValue('AA'.$nn, DeSanitizar($tipo['Estiba']))
				->setCellValue('AB'.$nn, DeSanitizar($tipo['EstibaUbicacion']))
				->setCellValue('AC'.$nn, DeSanitizar($tipo['Posicion']))
				->setCellValue('AD'.$nn, DeSanitizar($tipo['Envase']))
				->setCellValue('AE'.$nn, DeSanitizar($tipo['NPallet']))
				->setCellValue('AF'.$nn, cantidades_excel($tipo['Temperatura']))
				->setCellValue('AG'.$nn, DeSanitizar($tipo['Termografo']))
				->setCellValue('AH'.$nn, DeSanitizar($tipo['NSerieSensor']));

	//Se suma 1
	$nn++;
}



// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Exportacion');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Agro Shipping - Exportar Datos';
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
