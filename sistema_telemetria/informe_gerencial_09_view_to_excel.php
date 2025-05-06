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
/***********************************************************/
//Solo compras pagadas totalmente
$SIS_where_1  = "pagos_facturas_proveedores.idPago!=0";
$SIS_where_2  = "pagos_facturas_clientes.idPago!=0";
$SIS_where_3  = "pagos_rrhh_liquidaciones.idPago!=0";
$SIS_where_4  = "pagos_boletas_trabajadores.idPago!=0";
$SIS_where_5  = "contab_caja_gastos_existencias.idExistencia!=0";
$SIS_where_6  = "pagos_leyes_fiscales_formas_pago.idHistorial!=0";
$SIS_where_7  = "pagos_leyes_sociales_formas_pago.idHistorial!=0";
//filtro el año
if(isset($_GET['Ano'])&&$_GET['Ano']!=''){
	$SIS_where_1.=" AND pagos_facturas_proveedores.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$SIS_where_2.=" AND pagos_facturas_clientes.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$SIS_where_3.=" AND pagos_rrhh_liquidaciones.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$SIS_where_4.=" AND pagos_boletas_trabajadores.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$SIS_where_5.=" AND contab_caja_gastos_existencias.Creacion_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$SIS_where_6.=" AND pagos_leyes_fiscales.Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$SIS_where_7.=" AND pagos_leyes_sociales.Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
}
//filtro el mes
if(isset($_GET['mes'])&&$_GET['mes']!=''){
	$SIS_where_1.=" AND pagos_facturas_proveedores.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$SIS_where_2.=" AND pagos_facturas_clientes.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$SIS_where_3.=" AND pagos_rrhh_liquidaciones.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$SIS_where_4.=" AND pagos_boletas_trabajadores.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$SIS_where_5.=" AND contab_caja_gastos_existencias.Creacion_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$SIS_where_6.=" AND pagos_leyes_fiscales.Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$SIS_where_7.=" AND pagos_leyes_sociales.Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
}
//Si se elije sistema
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){
	$SIS_where_1.=" AND pagos_facturas_proveedores.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$SIS_where_2.=" AND pagos_facturas_clientes.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$SIS_where_3.=" AND pagos_rrhh_liquidaciones.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$SIS_where_4.=" AND pagos_boletas_trabajadores.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$SIS_where_5.=" AND contab_caja_gastos.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$SIS_where_6.=" AND pagos_leyes_fiscales.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$SIS_where_7.=" AND pagos_leyes_sociales.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
}
/*************************************************************************************************/
//filtro
$SIS_query_1 = '
pagos_facturas_proveedores.idTipo,
pagos_facturas_proveedores_tipo.Nombre AS Tipo,
sistema_documentos_pago.Nombre AS Documento,
pagos_facturas_proveedores.N_DocPago,
proveedor_listado.Nombre AS Empresa,
pagos_facturas_proveedores.idFacturacion,
pagos_facturas_proveedores.F_Pago,
pagos_facturas_proveedores.MontoPagado';

$SIS_query_2 = '
pagos_facturas_clientes.idTipo,
pagos_facturas_clientes_tipo.Nombre AS Tipo,
sistema_documentos_pago.Nombre AS Documento,
pagos_facturas_clientes.N_DocPago,
clientes_listado.Nombre AS Empresa,
pagos_facturas_clientes.idFacturacion,
pagos_facturas_clientes.F_Pago,
pagos_facturas_clientes.MontoPagado';
		
$SIS_query_3 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_rrhh_liquidaciones.N_DocPago,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
pagos_rrhh_liquidaciones.idFactTrab AS idFacturacion,
pagos_rrhh_liquidaciones.F_Pago,
pagos_rrhh_liquidaciones.MontoPagado';

$SIS_query_4 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_boletas_trabajadores.N_DocPago,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
pagos_boletas_trabajadores.idFacturacion,
pagos_boletas_trabajadores.F_Pago,
pagos_boletas_trabajadores.MontoPagado';

$SIS_query_5 = '
sistema_documentos_pago.Nombre AS Documento,
contab_caja_gastos_existencias.N_Doc AS N_DocPago,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
contab_caja_gastos_existencias.idFacturacion,
contab_caja_gastos_existencias.Creacion_fecha AS F_Pago,
contab_caja_gastos_existencias.Valor AS MontoPagado';

$SIS_query_6 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_leyes_fiscales_formas_pago.N_DocPago,
pagos_leyes_fiscales_formas_pago.idFactFiscal AS idFacturacion,
pagos_leyes_fiscales.Pago_fecha AS F_Pago,
pagos_leyes_fiscales_formas_pago.Monto AS MontoPagado';

$SIS_query_7 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_leyes_sociales_formas_pago.N_DocPago,
pagos_leyes_sociales_formas_pago.idFactSocial AS idFacturacion,
pagos_leyes_sociales.Pago_fecha AS F_Pago,
pagos_leyes_sociales_formas_pago.Monto AS MontoPagado';

$SIS_join_1 = '
LEFT JOIN `sistema_documentos_pago`           ON sistema_documentos_pago.idDocPago       = pagos_facturas_proveedores.idDocPago
LEFT JOIN `pagos_facturas_proveedores_tipo`   ON pagos_facturas_proveedores_tipo.idTipo  = pagos_facturas_proveedores.idTipo
LEFT JOIN `proveedor_listado`                 ON proveedor_listado.idProveedor           = pagos_facturas_proveedores.idProveedor
';

$SIS_join_2 = '
LEFT JOIN `sistema_documentos_pago`       ON sistema_documentos_pago.idDocPago    = pagos_facturas_clientes.idDocPago
LEFT JOIN `pagos_facturas_clientes_tipo`  ON pagos_facturas_clientes_tipo.idTipo  = pagos_facturas_clientes.idTipo
LEFT JOIN `clientes_listado`              ON clientes_listado.idCliente           = pagos_facturas_clientes.idCliente
';

$SIS_join_3 = '
LEFT JOIN `sistema_documentos_pago`                 ON sistema_documentos_pago.idDocPago                  = pagos_rrhh_liquidaciones.idDocPago
LEFT JOIN `rrhh_sueldos_facturacion_trabajadores`   ON rrhh_sueldos_facturacion_trabajadores.idFactTrab   = pagos_rrhh_liquidaciones.idFactTrab
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador                  = rrhh_sueldos_facturacion_trabajadores.idTrabajador
';

$SIS_join_4 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_boletas_trabajadores.idDocPago
LEFT JOIN `trabajadores_listado`       ON trabajadores_listado.idTrabajador    = pagos_boletas_trabajadores.idTrabajador
';

$SIS_join_5 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = contab_caja_gastos_existencias.idDocPago
LEFT JOIN `contab_caja_gastos`         ON contab_caja_gastos.idFacturacion     = contab_caja_gastos_existencias.idFacturacion
LEFT JOIN `trabajadores_listado`       ON trabajadores_listado.idTrabajador    = contab_caja_gastos.idTrabajador
';

$SIS_join_6 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_leyes_fiscales_formas_pago.idDocPago
LEFT JOIN pagos_leyes_fiscales         ON pagos_leyes_fiscales.idFactFiscal    = pagos_leyes_fiscales_formas_pago.idFactFiscal
';

$SIS_join_7 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_leyes_sociales_formas_pago.idDocPago
LEFT JOIN pagos_leyes_sociales         ON pagos_leyes_sociales.idFactSocial    = pagos_leyes_sociales_formas_pago.idFactSocial
';

//variables
$arrTemporal_1 = array();
$arrTemporal_2 = array();
$arrTemporal_3 = array();
$arrTemporal_4 = array();
$arrTemporal_5 = array();
$arrTemporal_6 = array();
$arrTemporal_7 = array();

//Pagos a Proveedores
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_1 = db_select_array (false, $SIS_query_1, 'pagos_facturas_proveedores', $SIS_join_1, $SIS_where_1, 'pagos_facturas_proveedores.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_1');
}
//Pagos a Clientes
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){
	$arrTemporal_2 = db_select_array (false, $SIS_query_2, 'pagos_facturas_clientes', $SIS_join_2, $SIS_where_2, 'pagos_facturas_clientes.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_2');
}
//Pagos a trabajadores
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_3 = db_select_array (false, $SIS_query_3, 'pagos_rrhh_liquidaciones', $SIS_join_3, $SIS_where_3, 'pagos_rrhh_liquidaciones.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_3');
}
//Pagos boletas a trabajadores
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_4 = db_select_array (false, $SIS_query_4, 'pagos_boletas_trabajadores', $SIS_join_4, $SIS_where_4, 'pagos_boletas_trabajadores.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_4');
}
//Rendiciones
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_5 = db_select_array (false, $SIS_query_5, 'contab_caja_gastos_existencias', $SIS_join_5 , $SIS_where_5, 'contab_caja_gastos_existencias.Creacion_fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_5');
}
//Pagos de impuestos
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_6 = db_select_array (false, $SIS_query_6, 'pagos_leyes_fiscales_formas_pago', $SIS_join_6 , $SIS_where_6, 'pagos_leyes_fiscales.Pago_fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_6');
}
//Pagos de previred
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_7 = db_select_array (false, $SIS_query_7, 'pagos_leyes_sociales_formas_pago', $SIS_join_7 , $SIS_where_7, 'pagos_leyes_sociales.Pago_fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_7');
}

//Variables
$total_ingreso = 0;
$total_egreso  = 0;

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
            ->setCellValue('A1', 'Tipo')
            ->setCellValue('B1', 'Empresa')
            ->setCellValue('C1', 'Documento')
            ->setCellValue('D1', 'Fecha Pagada');
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E1', 'Ingreso');            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F1', 'Egreso');            
}
 
$nn=3; 

/***************************************************************/
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Pagos a Proveedores');            
$nn++;
//Subtotal
$Subtotal_1 = 0;
$Subtotal_2 = 0;
//recorro
foreach ($arrTemporal_1 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($tipo['Tipo']))
				->setCellValue('B'.$nn, DeSanitizar($tipo['Empresa']))
				->setCellValue('C'.$nn, DeSanitizar($tipo['Documento'].' '.$tipo['N_DocPago']))
				->setCellValue('D'.$nn, Fecha_estandar($tipo['F_Pago']));

	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('E'.$nn, 0);            
	}           
	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('F'.$nn, $tipo['MontoPagado']);            
		$total_egreso = $total_egreso + $tipo['MontoPagado'];
		$Subtotal_2   = $Subtotal_2 + $tipo['MontoPagado'];
	}
				
	$nn++;
		           
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Subtotal Pagos a Proveedores');
				
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $Subtotal_1);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $Subtotal_2); 
}
$nn++;

/***************************************************************/
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Pagos de Clientes');            
$nn++;
//Subtotal
$Subtotal_1 = 0;
$Subtotal_2 = 0;
//recorro
foreach ($arrTemporal_2 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($tipo['Tipo']))
				->setCellValue('B'.$nn, DeSanitizar($tipo['Empresa']))
				->setCellValue('C'.$nn, DeSanitizar($tipo['Documento'].' '.$tipo['N_DocPago']))
				->setCellValue('D'.$nn, Fecha_estandar($tipo['F_Pago']));

	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('E'.$nn, $tipo['MontoPagado']);  
		$total_ingreso = $total_ingreso + $tipo['MontoPagado'];
		$Subtotal_1    = $Subtotal_1 + $tipo['MontoPagado'];			          
	}           
	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('F'.$nn, 0);  
	}
				
	$nn++;
		           
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Subtotal Pagos de Clientes');
				
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $Subtotal_1);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $Subtotal_2); 
}
$nn++;	

/***************************************************************/
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Pagos a trabajadores');            
$nn++;
//Subtotal
$Subtotal_1 = 0;
$Subtotal_2 = 0;
//recorro
foreach ($arrTemporal_3 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, 'Liquidacion Sueldo')
				->setCellValue('B'.$nn, DeSanitizar($tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat']))
				->setCellValue('C'.$nn, DeSanitizar($tipo['Documento'].' '.$tipo['N_DocPago']))
				->setCellValue('D'.$nn, Fecha_estandar($tipo['F_Pago']));

	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('E'.$nn, 0); 			          
	}           
	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('F'.$nn, $tipo['MontoPagado']);  
		$total_egreso = $total_egreso + $tipo['MontoPagado'];
		$Subtotal_2   = $Subtotal_2 + $tipo['MontoPagado'];
	}
				
	$nn++;
		           
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Subtotal Pagos a trabajadores');
				
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $Subtotal_1);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $Subtotal_2); 
}
$nn++;	

/***************************************************************/
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Pagos boletas a trabajadores');            
$nn++;
//Subtotal
$Subtotal_1 = 0;
$Subtotal_2 = 0;
//recorro
foreach ($arrTemporal_4 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, 'Boleta Honorario')
				->setCellValue('B'.$nn, DeSanitizar($tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat']))
				->setCellValue('C'.$nn, DeSanitizar($tipo['Documento'].' '.$tipo['N_DocPago']))
				->setCellValue('D'.$nn, Fecha_estandar($tipo['F_Pago']));

	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('E'.$nn, 0); 			          
	}           
	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('F'.$nn, $tipo['MontoPagado']);  
		$total_egreso = $total_egreso + $tipo['MontoPagado'];
		$Subtotal_2   = $Subtotal_2 + $tipo['MontoPagado'];
	}
				
	$nn++;
		           
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Subtotal Pagos boletas a trabajadores');
				
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $Subtotal_1);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $Subtotal_2); 
}
$nn++;		

/***************************************************************/
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Rendiciones');            
$nn++;
//Subtotal
$Subtotal_1 = 0;
$Subtotal_2 = 0;
//recorro
foreach ($arrTemporal_5 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, 'Rendiciones')
				->setCellValue('B'.$nn, DeSanitizar($tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat']))
				->setCellValue('C'.$nn, DeSanitizar($tipo['Documento'].' '.$tipo['N_DocPago']))
				->setCellValue('D'.$nn, Fecha_estandar($tipo['F_Pago']));

	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('E'.$nn, 0); 			          
	}           
	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('F'.$nn, $tipo['MontoPagado']);  
		$total_egreso = $total_egreso + $tipo['MontoPagado'];
		$Subtotal_2   = $Subtotal_2 + $tipo['MontoPagado'];
	}
				
	$nn++;
		           
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Subtotal Rendiciones');
				
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $Subtotal_1);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $Subtotal_2); 
}
$nn++;			

/***************************************************************/
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Formulario 29');            
$nn++;
//Subtotal
$Subtotal_1 = 0;
$Subtotal_2 = 0;
//recorro
foreach ($arrTemporal_6 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, 'Formulario 29')
				->setCellValue('B'.$nn, 'SII')
				->setCellValue('C'.$nn, DeSanitizar($tipo['Documento'].' '.$tipo['N_DocPago']))
				->setCellValue('D'.$nn, Fecha_estandar($tipo['F_Pago']));

	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('E'.$nn, 0); 			          
	}           
	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('F'.$nn, $tipo['MontoPagado']);  
		$total_egreso = $total_egreso + $tipo['MontoPagado'];
		$Subtotal_2   = $Subtotal_2 + $tipo['MontoPagado'];
	}
				
	$nn++;
		           
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Subtotal Formulario 29');
				
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $Subtotal_1);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $Subtotal_2); 
}
$nn++;			

/***************************************************************/
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Pagos de previred');            
$nn++;
//Subtotal
$Subtotal_1 = 0;
$Subtotal_2 = 0;
//recorro
foreach ($arrTemporal_7 as $tipo) {

	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, 'Previred')
				->setCellValue('B'.$nn, 'Previred')
				->setCellValue('C'.$nn, DeSanitizar($tipo['Documento'].' '.$tipo['N_DocPago']))
				->setCellValue('D'.$nn, Fecha_estandar($tipo['F_Pago']));

	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('E'.$nn, 0); 			          
	}           
	if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('F'.$nn, $tipo['MontoPagado']);  
		$total_egreso = $total_egreso + $tipo['MontoPagado'];
		$Subtotal_2   = $Subtotal_2 + $tipo['MontoPagado'];
	}
				
	$nn++;
		           
} 
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Subtotal Pagos de previred');
				
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $Subtotal_1);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $Subtotal_2); 
}
$nn++;

/***************************************************************/			
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$nn, 'Total General');
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('E'.$nn, $total_ingreso);            
}           
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){            
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('F'.$nn, $total_egreso); 
}
			
			
// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Flujo de Caja');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Flujo de Caja';
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
