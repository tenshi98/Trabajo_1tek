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
// Se trae un listado con todos los productos
$SIS_where = "bodegas_arriendos_facturacion_existencias.idExistencia!=0";
if(isset($_GET['idBodegaOrigen']) && $_GET['idBodegaOrigen']!=''){  $SIS_where .= " AND bodegas_arriendos_facturacion.idBodegaOrigen=".$_GET['idBodegaOrigen'];}
if(isset($_GET['idBodegaDestino']) && $_GET['idBodegaDestino']!=''){$SIS_where .= " AND bodegas_arriendos_facturacion.idBodegaDestino=".$_GET['idBodegaDestino'];}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){            $SIS_where .= " AND bodegas_arriendos_facturacion.idSistema=".$_GET['idSistema'];}
if(isset($_GET['idSistemaDestino']) && $_GET['idSistemaDestino']!=''){     $SIS_where .= " AND bodegas_arriendos_facturacion.idSistemaDestino=".$_GET['idSistemaDestino'];}
if(isset($_GET['idDocumentos']) && $_GET['idDocumentos']!=''){      $SIS_where .= " AND bodegas_arriendos_facturacion.idDocumentos=".$_GET['idDocumentos'];}
if(isset($_GET['N_Doc']) && $_GET['N_Doc']!=''){                    $SIS_where .= " AND bodegas_arriendos_facturacion.N_Doc LIKE '%".EstandarizarInput($_GET['N_Doc'])."%'"; }
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                  $SIS_where .= " AND bodegas_arriendos_facturacion.idTipo=".$_GET['idTipo'];}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){      $SIS_where .= " AND bodegas_arriendos_facturacion.idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){        $SIS_where .= " AND bodegas_arriendos_facturacion.idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){            $SIS_where .= " AND bodegas_arriendos_facturacion.idCliente=".$_GET['idCliente'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){              $SIS_where .= " AND bodegas_arriendos_facturacion.idEstado=".$_GET['idEstado'];}
if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){            $SIS_where .= " AND bodegas_arriendos_facturacion.idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){            $SIS_where .= " AND bodegas_arriendos_facturacion.N_DocPago LIKE '%".EstandarizarInput($_GET['N_DocPago'])."%'"; }
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){          $SIS_where .= " AND bodegas_arriendos_facturacion_existencias.idProducto=".$_GET['idProducto'];}
if(isset($_GET['idEstadoDevolucion']) && $_GET['idEstadoDevolucion']!=''){ $SIS_where .= " AND bodegas_arriendos_facturacion.idEstadoDevolucion=".$_GET['idEstadoDevolucion'];}

if(isset($_GET['Creacion_fecha_ini'], $_GET['Creacion_fecha_fin']) && $_GET['Creacion_fecha_ini'] != '' && $_GET['Creacion_fecha_fin']!=''){   
	$SIS_where .= " AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['Creacion_fecha_ini']."' AND '".$_GET['Creacion_fecha_fin']."'";
}
if(isset($_GET['Pago_fecha_ini'], $_GET['Pago_fecha_fin']) && $_GET['Pago_fecha_ini'] != '' && $_GET['Pago_fecha_fin']!=''){   
	$SIS_where .= " AND bodegas_arriendos_facturacion.Pago_fecha BETWEEN '".$_GET['Pago_fecha_ini']."' AND '".$_GET['Pago_fecha_fin']."'";
}
if(isset($_GET['F_Pago_ini'], $_GET['F_Pago_fin']) && $_GET['F_Pago_ini'] != '' && $_GET['F_Pago_fin']!=''){   
	$SIS_where .= " AND bodegas_arriendos_facturacion.F_Pago BETWEEN '".$_GET['F_Pago_ini']."' AND '".$_GET['F_Pago_fin']."'";
}
if(isset($_GET['F_Devolucion_ini'], $_GET['F_Devolucion_fin']) && $_GET['F_Devolucion_ini'] != '' && $_GET['F_Devolucion_fin']!=''){   
	$SIS_where .= " AND bodegas_arriendos_facturacion.F_Pago BETWEEN '".$_GET['F_Devolucion_ini']."' AND '".$_GET['F_Devolucion_fin']."'";
}

$SIS_query = '
bodegas_arriendos_facturacion.Creacion_fecha,
bodegas_arriendos_facturacion.Creacion_Semana,
bodegas_arriendos_facturacion.Creacion_mes,
bodegas_arriendos_facturacion.Creacion_ano,
bodegas_arriendos_facturacion.N_Doc,
bodegas_arriendos_facturacion.idOT,
bodegas_arriendos_facturacion.Pago_fecha,
bodegas_arriendos_facturacion.Pago_dia,
bodegas_arriendos_facturacion.Pago_Semana,
bodegas_arriendos_facturacion.Pago_mes,
bodegas_arriendos_facturacion.Pago_ano,
bodegas_arriendos_facturacion.DocRel,
bodegas_arriendos_facturacion.N_DocPago,
bodegas_arriendos_facturacion.F_Pago,
bodegas_arriendos_facturacion.F_Pago_dia,
bodegas_arriendos_facturacion.F_Pago_mes,
bodegas_arriendos_facturacion.F_Pago_ano,

bodegas_arriendos_facturacion_existencias.Cantidad_ing,
bodegas_arriendos_facturacion_existencias.Cantidad_eg,
bodegas_arriendos_facturacion_existencias.Valor,
bodegas_arriendos_facturacion_existencias.ValorTotal,

equipos_arriendo_listado.Nombre AS Producto,
bod_origen.Nombre AS Bodega_origen,
sist_origen.Nombre AS Sistema_origen,
core_documentos_mercantiles.Nombre AS Documento_tipo,
bodegas_arriendos_facturacion_tipo.Nombre AS Tipo,
trabajadores_listado.Nombre AS Trab_Nombre,
trabajadores_listado.ApellidoPat AS Trab_ApellidoPat,
trabajadores_listado.ApellidoMat AS Trab_ApellidoMat,
proveedor_listado.Nombre AS Prov_Nombre,
clientes_listado.Nombre AS Cliente_Nombre,
core_estado_facturacion.Nombre AS Estado,
usuarios_listado.Nombre AS UsuarioPago,
sistema_documentos_pago.Nombre AS Documento_pago,

core_estado_devolucion.Nombre AS EstadoDevolucion,
bodegas_arriendos_facturacion.Devolucion_fecha,
bodegas_arriendos_facturacion.Devolucion_dia,
bodegas_arriendos_facturacion.Devolucion_Semana,
bodegas_arriendos_facturacion.Devolucion_mes,
bodegas_arriendos_facturacion.Devolucion_ano';
$SIS_join  = '
LEFT JOIN `bodegas_arriendos_facturacion`          ON bodegas_arriendos_facturacion.idFacturacion  = bodegas_arriendos_facturacion_existencias.idFacturacion
LEFT JOIN `equipos_arriendo_listado`               ON equipos_arriendo_listado.idEquipo            = bodegas_arriendos_facturacion_existencias.idEquipo
LEFT JOIN `bodegas_arriendos_listado`  bod_origen  ON bod_origen.idBodega                          = bodegas_arriendos_facturacion.idBodega
LEFT JOIN `core_sistemas`  sist_origen             ON sist_origen.idSistema                        = bodegas_arriendos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`            ON core_documentos_mercantiles.idDocumentos     = bodegas_arriendos_facturacion.idDocumentos
LEFT JOIN `bodegas_arriendos_facturacion_tipo`     ON bodegas_arriendos_facturacion_tipo.idTipo    = bodegas_arriendos_facturacion.idTipo
LEFT JOIN `trabajadores_listado`                   ON trabajadores_listado.idTrabajador            = bodegas_arriendos_facturacion.idTrabajador
LEFT JOIN `proveedor_listado`                      ON proveedor_listado.idProveedor                = bodegas_arriendos_facturacion.idProveedor
LEFT JOIN `clientes_listado`                       ON clientes_listado.idCliente                   = bodegas_arriendos_facturacion.idCliente
LEFT JOIN `core_estado_facturacion`                ON core_estado_facturacion.idEstado             = bodegas_arriendos_facturacion.idEstado
LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                   = bodegas_arriendos_facturacion.idUsuarioPago
LEFT JOIN `sistema_documentos_pago`                ON sistema_documentos_pago.idDocPago            = bodegas_arriendos_facturacion.idDocPago
LEFT JOIN `core_estado_devolucion`                 ON core_estado_devolucion.idEstadoDevolucion    = bodegas_arriendos_facturacion.idEstadoDevolucion';
$SIS_order = 0;
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'bodegas_arriendos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

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
            ->setCellValue('A1', 'Bodega')
			->setCellValue('B1', 'Sistema')
			->setCellValue('C1', 'Creacion fecha')
			->setCellValue('D1', 'Creacion Semana')
			->setCellValue('E1', 'Creacion mes')
			->setCellValue('F1', 'Creacion año')
			->setCellValue('G1', 'Documento tipo')
			->setCellValue('H1', 'N Doc')
			->setCellValue('I1', 'Tipo')
			->setCellValue('J1', 'OT')
			->setCellValue('K1', 'Trabajador')
			->setCellValue('L1', 'Proveedor Nombre')
			->setCellValue('M1', 'Cliente Nombre')
			->setCellValue('N1', 'Vencimiento fecha')
			->setCellValue('O1', 'Vencimiento dia')
			->setCellValue('P1', 'Vencimiento Semana')
			->setCellValue('Q1', 'Vencimiento mes')
			->setCellValue('R1', 'Vencimiento ano')
			->setCellValue('S1', 'Estado')
			->setCellValue('T1', 'Devolucion fecha')
			->setCellValue('U1', 'Devolucion dia')
			->setCellValue('V1', 'Devolucion Semana')
			->setCellValue('W1', 'Devolucion mes')
			->setCellValue('X1', 'Devolucion ano')
			->setCellValue('Y1', 'Estado Devolucion')
			->setCellValue('Z1', 'Documento Relacionado')
			->setCellValue('AA1', 'Usuario Pago')
			->setCellValue('AB1', 'Documento pago')
			->setCellValue('AC1', 'N Doc Pago')
			->setCellValue('AD1', 'F Pago')
			->setCellValue('AE1', 'F Pago dia')
			->setCellValue('AF1', 'F Pago mes')
			->setCellValue('AG1', 'F Pago ano')
			->setCellValue('AH1', 'Producto')
			->setCellValue('AI1', 'Cantidad ing')
			->setCellValue('AJ1', 'Cantidad eg')
			->setCellValue('AK1', 'Valor')
			->setCellValue('AL1', 'Valor Total');

$nn=2;
foreach ($arrProductos as $productos) { 

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($productos['Bodega_origen']))
				->setCellValue('B'.$nn, DeSanitizar($productos['Sistema_origen']))
				->setCellValue('C'.$nn, $productos['Creacion_fecha'])
				->setCellValue('D'.$nn, $productos['Creacion_Semana'])
				->setCellValue('E'.$nn, $productos['Creacion_mes'])
				->setCellValue('F'.$nn, $productos['Creacion_ano'])
				->setCellValue('G'.$nn, DeSanitizar($productos['Documento_tipo']))
				->setCellValue('H'.$nn, $productos['N_Doc'])
				->setCellValue('I'.$nn, DeSanitizar($productos['Tipo']))
				->setCellValue('J'.$nn, $productos['idOT'])
				->setCellValue('K'.$nn, DeSanitizar($productos['Trab_Nombre'].' '.$productos['Trab_ApellidoPat'].' '.$productos['Trab_ApellidoMat']))
				->setCellValue('L'.$nn, DeSanitizar($productos['Prov_Nombre']))
				->setCellValue('M'.$nn, DeSanitizar($productos['Cliente_Nombre']))
				->setCellValue('N'.$nn, $productos['Pago_fecha'])
				->setCellValue('O'.$nn, $productos['Pago_dia'])
				->setCellValue('P'.$nn, $productos['Pago_Semana'])
				->setCellValue('Q'.$nn, $productos['Pago_mes'])
				->setCellValue('R'.$nn, $productos['Pago_ano'])
				->setCellValue('S'.$nn, DeSanitizar($productos['Estado']))
				->setCellValue('T'.$nn, $productos['Devolucion_fecha'])
				->setCellValue('U'.$nn, $productos['Devolucion_dia'])
				->setCellValue('V'.$nn, $productos['Devolucion_Semana'])
				->setCellValue('W'.$nn, $productos['Devolucion_mes'])
				->setCellValue('X'.$nn, $productos['Devolucion_ano'])
				->setCellValue('Y'.$nn, DeSanitizar($productos['EstadoDevolucion']))
				->setCellValue('Z'.$nn, DeSanitizar($productos['DocRel']))
				->setCellValue('AA'.$nn, DeSanitizar($productos['UsuarioPago']))
				->setCellValue('AB'.$nn, DeSanitizar($productos['Documento_pago']))
				->setCellValue('AC'.$nn, $productos['N_DocPago'])
				->setCellValue('AD'.$nn, $productos['F_Pago'])
				->setCellValue('AE'.$nn, $productos['F_Pago_dia'])
				->setCellValue('AF'.$nn, $productos['F_Pago_mes'])
				->setCellValue('AG'.$nn, $productos['F_Pago_ano'])
				->setCellValue('AH'.$nn, DeSanitizar($productos['Producto']))
				->setCellValue('AI'.$nn, cantidades_excel($productos['Cantidad_ing']))
				->setCellValue('AJ'.$nn, cantidades_excel($productos['Cantidad_eg']))
				->setCellValue('AK'.$nn, cantidades_excel($productos['Valor']))
				->setCellValue('AL'.$nn, cantidades_excel($productos['ValorTotal']));
	$nn++;

}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Datos');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Exportar Datos Bodega Insumos';
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
