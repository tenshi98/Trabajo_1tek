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
$SIS_where = "bodegas_insumos_facturacion_existencias.idExistencia!=0";
if(isset($_GET['idBodegaOrigen']) && $_GET['idBodegaOrigen']!=''){      $SIS_where .= " AND bodegas_insumos_facturacion.idBodegaOrigen=".$_GET['idBodegaOrigen'];}
if(isset($_GET['idBodegaDestino']) && $_GET['idBodegaDestino']!=''){    $SIS_where .= " AND bodegas_insumos_facturacion.idBodegaDestino=".$_GET['idBodegaDestino'];}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){         $SIS_where .= " AND bodegas_insumos_facturacion.idSistema=".$_GET['idSistema'];}
if(isset($_GET['idSistemaDestino']) && $_GET['idSistemaDestino']!=''){  $SIS_where .= " AND bodegas_insumos_facturacion.idSistemaDestino=".$_GET['idSistemaDestino'];}
if(isset($_GET['idDocumentos']) && $_GET['idDocumentos']!=''){   $SIS_where .= " AND bodegas_insumos_facturacion.idDocumentos=".$_GET['idDocumentos'];}
if(isset($_GET['N_Doc']) && $_GET['N_Doc']!=''){                 $SIS_where .= " AND bodegas_insumos_facturacion.N_Doc LIKE '%".EstandarizarInput($_GET['N_Doc'])."%'";}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){               $SIS_where .= " AND bodegas_insumos_facturacion.idTipo=".$_GET['idTipo'];}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){   $SIS_where .= " AND bodegas_insumos_facturacion.idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){     $SIS_where .= " AND bodegas_insumos_facturacion.idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){         $SIS_where .= " AND bodegas_insumos_facturacion.idCliente=".$_GET['idCliente'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){           $SIS_where .= " AND bodegas_insumos_facturacion.idEstado=".$_GET['idEstado'];}
if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){         $SIS_where .= " AND bodegas_insumos_facturacion.idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){         $SIS_where .= " AND bodegas_insumos_facturacion.N_DocPago LIKE '%".EstandarizarInput($_GET['N_DocPago'])."%'";}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){       $SIS_where .= " AND bodegas_insumos_facturacion_existencias.idProducto=".$_GET['idProducto'];}

if(isset($_GET['Creacion_fecha_ini'], $_GET['Creacion_fecha_fin']) && $_GET['Creacion_fecha_ini'] != '' && $_GET['Creacion_fecha_fin']!=''){   
	$SIS_where .= " AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['Creacion_fecha_ini']."' AND '".$_GET['Creacion_fecha_fin']."'";
}
if(isset($_GET['Pago_fecha_ini'], $_GET['Pago_fecha_fin']) && $_GET['Pago_fecha_ini'] != '' && $_GET['Pago_fecha_fin']!=''){   
	$SIS_where .= " AND bodegas_insumos_facturacion.Pago_fecha BETWEEN '".$_GET['Pago_fecha_ini']."' AND '".$_GET['Pago_fecha_fin']."'";
}
if(isset($_GET['F_Pago_ini'], $_GET['F_Pago_fin']) && $_GET['F_Pago_ini'] != '' && $_GET['F_Pago_fin']!=''){   
	$SIS_where .= " AND bodegas_insumos_facturacion.F_Pago BETWEEN '".$_GET['F_Pago_ini']."' AND '".$_GET['F_Pago_fin']."'";
}

$SIS_query = '
bodegas_insumos_facturacion.Creacion_fecha,
bodegas_insumos_facturacion.Creacion_Semana,
bodegas_insumos_facturacion.Creacion_mes,
bodegas_insumos_facturacion.Creacion_ano,
bodegas_insumos_facturacion.N_Doc,
bodegas_insumos_facturacion.idOT,
bodegas_insumos_facturacion.Pago_fecha,
bodegas_insumos_facturacion.Pago_dia,
bodegas_insumos_facturacion.Pago_Semana,
bodegas_insumos_facturacion.Pago_mes,
bodegas_insumos_facturacion.Pago_ano,
bodegas_insumos_facturacion.DocRel,
bodegas_insumos_facturacion.N_DocPago,
bodegas_insumos_facturacion.F_Pago,
bodegas_insumos_facturacion.F_Pago_dia,
bodegas_insumos_facturacion.F_Pago_mes,
bodegas_insumos_facturacion.F_Pago_ano,

bodegas_insumos_facturacion_existencias.Cantidad_ing,
bodegas_insumos_facturacion_existencias.Cantidad_eg,
bodegas_insumos_facturacion_existencias.Valor,
bodegas_insumos_facturacion_existencias.ValorTotal,

insumos_listado.Nombre AS Producto,
bod_origen.Nombre AS Bodega_origen,
bod_destino.Nombre AS Bodega_destino,
sist_origen.Nombre AS Sistema_origen,
sist_destino.Nombre AS Sistema_destino,
core_documentos_mercantiles.Nombre AS Documento_tipo,
bodegas_insumos_facturacion_tipo.Nombre AS Tipo,
trabajadores_listado.Nombre AS Trab_Nombre,
trabajadores_listado.ApellidoPat AS Trab_ApellidoPat,
trabajadores_listado.ApellidoMat AS Trab_ApellidoMat,
proveedor_listado.Nombre AS Prov_Nombre,
clientes_listado.Nombre AS Cliente_Nombre,
core_estado_facturacion.Nombre AS Estado,
usuarios_listado.Nombre AS UsuarioPago,
sistema_documentos_pago.Nombre AS Documento_pago';
$SIS_join  = '
LEFT JOIN `bodegas_insumos_facturacion`            ON bodegas_insumos_facturacion.idFacturacion    = bodegas_insumos_facturacion_existencias.idFacturacion
LEFT JOIN `insumos_listado`                        ON insumos_listado.idProducto                   = bodegas_insumos_facturacion_existencias.idProducto
LEFT JOIN `bodegas_insumos_listado`  bod_origen    ON bod_origen.idBodega                          = bodegas_insumos_facturacion.idBodegaOrigen
LEFT JOIN `bodegas_insumos_listado`  bod_destino   ON bod_destino.idBodega                         = bodegas_insumos_facturacion.idBodegaDestino
LEFT JOIN `core_sistemas`  sist_origen             ON sist_origen.idSistema                        = bodegas_insumos_facturacion.idSistema
LEFT JOIN `core_sistemas`  sist_destino            ON sist_destino.idSistema                       = bodegas_insumos_facturacion.idSistemaDestino
LEFT JOIN `core_documentos_mercantiles`            ON core_documentos_mercantiles.idDocumentos     = bodegas_insumos_facturacion.idDocumentos
LEFT JOIN `bodegas_insumos_facturacion_tipo`       ON bodegas_insumos_facturacion_tipo.idTipo      = bodegas_insumos_facturacion.idTipo
LEFT JOIN `trabajadores_listado`                   ON trabajadores_listado.idTrabajador            = bodegas_insumos_facturacion.idTrabajador
LEFT JOIN `proveedor_listado`                      ON proveedor_listado.idProveedor                = bodegas_insumos_facturacion.idProveedor
LEFT JOIN `clientes_listado`                       ON clientes_listado.idCliente                   = bodegas_insumos_facturacion.idCliente
LEFT JOIN `core_estado_facturacion`                ON core_estado_facturacion.idEstado             = bodegas_insumos_facturacion.idEstado
LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                   = bodegas_insumos_facturacion.idUsuarioPago
LEFT JOIN `sistema_documentos_pago`                ON sistema_documentos_pago.idDocPago            = bodegas_insumos_facturacion.idDocPago';
$SIS_order = 0;
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

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
            ->setCellValue('A1', 'Bodega origen')
			->setCellValue('B1', 'Bodega destino')
			->setCellValue('C1', 'Sistema origen')
			->setCellValue('D1', 'Sistema destino')
			->setCellValue('E1', 'Creacion fecha')
			->setCellValue('F1', 'Creacion Semana')
			->setCellValue('G1', 'Creacion mes')
			->setCellValue('H1', 'Creacion año')
			->setCellValue('I1', 'Documento tipo')
			->setCellValue('J1', 'N Doc')
			->setCellValue('K1', 'Tipo')
			->setCellValue('L1', 'OT')
			->setCellValue('M1', 'Trabajador')
			->setCellValue('N1', 'Proveedor Nombre')
			->setCellValue('O1', 'Cliente Nombre')
			->setCellValue('P1', 'Vencimiento fecha')
			->setCellValue('Q1', 'Vencimiento dia')
			->setCellValue('R1', 'Vencimiento Semana')
			->setCellValue('S1', 'Vencimiento mes')
			->setCellValue('T1', 'Vencimiento ano')
			->setCellValue('U1', 'Estado')
			->setCellValue('V1', 'Documento Relacionado')
			->setCellValue('W1', 'Usuario Pago')
			->setCellValue('X1', 'Documento pago')
			->setCellValue('Y1', 'N Doc Pago')
			->setCellValue('Z1', 'F Pago')
			->setCellValue('AA1', 'F Pago dia')
			->setCellValue('AB1', 'F Pago mes')
			->setCellValue('AC1', 'F Pago ano')
			->setCellValue('AD1', 'Producto')
			->setCellValue('AE1', 'Cantidad ing')
			->setCellValue('AF1', 'Cantidad eg')
			->setCellValue('AG1', 'Valor')
			->setCellValue('AH1', 'Valor Total');

$nn=2;
foreach ($arrProductos as $productos) { 

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($productos['Bodega_origen']))
				->setCellValue('B'.$nn, DeSanitizar($productos['Bodega_destino']))
				->setCellValue('C'.$nn, DeSanitizar($productos['Sistema_origen']))
				->setCellValue('D'.$nn, DeSanitizar($productos['Sistema_destino']))
				->setCellValue('E'.$nn, $productos['Creacion_fecha'])
				->setCellValue('F'.$nn, $productos['Creacion_Semana'])
				->setCellValue('G'.$nn, $productos['Creacion_mes'])
				->setCellValue('H'.$nn, $productos['Creacion_ano'])
				->setCellValue('I'.$nn, DeSanitizar($productos['Documento_tipo']))
				->setCellValue('J'.$nn, $productos['N_Doc'])
				->setCellValue('K'.$nn, DeSanitizar($productos['Tipo']))
				->setCellValue('L'.$nn, $productos['idOT'])
				->setCellValue('M'.$nn, DeSanitizar($productos['Trab_Nombre'].' '.$productos['Trab_ApellidoPat'].' '.$productos['Trab_ApellidoMat']))
				->setCellValue('N'.$nn, DeSanitizar($productos['Prov_Nombre']))
				->setCellValue('O'.$nn, DeSanitizar($productos['Cliente_Nombre']))
				->setCellValue('P'.$nn, $productos['Pago_fecha'])
				->setCellValue('Q'.$nn, $productos['Pago_dia'])
				->setCellValue('R'.$nn, $productos['Pago_Semana'])
				->setCellValue('S'.$nn, $productos['Pago_mes'])
				->setCellValue('T'.$nn, $productos['Pago_ano'])
				->setCellValue('U'.$nn, DeSanitizar($productos['Estado']))
				->setCellValue('V'.$nn, DeSanitizar($productos['DocRel']))
				->setCellValue('W'.$nn, DeSanitizar($productos['UsuarioPago']))
				->setCellValue('X'.$nn, DeSanitizar($productos['Documento_pago']))
				->setCellValue('Y'.$nn, $productos['N_DocPago'])
				->setCellValue('Z'.$nn, $productos['F_Pago'])
				->setCellValue('AA'.$nn, $productos['F_Pago_dia'])
				->setCellValue('AB'.$nn, $productos['F_Pago_mes'])
				->setCellValue('AC'.$nn, $productos['F_Pago_ano'])
				->setCellValue('AD'.$nn, DeSanitizar($productos['Producto']))
				->setCellValue('AE'.$nn, cantidades_excel($productos['Cantidad_ing']))
				->setCellValue('AF'.$nn, cantidades_excel($productos['Cantidad_eg']))
				->setCellValue('AG'.$nn, cantidades_excel($productos['Valor']))
				->setCellValue('AH'.$nn, cantidades_excel($productos['ValorTotal']));
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
