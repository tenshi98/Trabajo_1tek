<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Excel.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Si existe se elimina
if(isset($_SESSION['pagos_boletas_empresas'][$_GET['idFacturacion']]['idFacturacion'])&&$_SESSION['pagos_boletas_empresas'][$_GET['idFacturacion']]['idFacturacion']!=''&&$_SESSION['pagos_boletas_empresas'][$_GET['idFacturacion']]['idFacturacion']==$_GET['idFacturacion']){
	unset($_SESSION['pagos_boletas_empresas'][$_GET['idFacturacion']]);
//Si no existe se crea
}else{
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	boleta_honorarios_facturacion.idFacturacion,
	boleta_honorarios_facturacion.N_Doc,
	boleta_honorarios_facturacion.ValorTotal,
	boleta_honorarios_facturacion.idSistema,
	boleta_honorarios_facturacion.idProveedor,
	proveedor_listado.Nombre AS ProveedorNombre,
	(SELECT SUM(MontoPagado) FROM `pagos_boletas_empresas` WHERE idFacturacion= boleta_honorarios_facturacion.idFacturacion LIMIT 1) AS MontoPagado';
	$SIS_join  = 'LEFT JOIN `proveedor_listado` ON proveedor_listado.idProveedor = boleta_honorarios_facturacion.idProveedor';
	$SIS_where = 'boleta_honorarios_facturacion.idFacturacion='.$_GET['idFacturacion'];
	$rowData = db_select_data (false, $SIS_query, 'boleta_honorarios_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/******************************************************************/
	//Se traspasan los valores a variables de sesion
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['idFacturacion']      = $rowData['idFacturacion'];
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['N_Doc']              = $rowData['N_Doc'];
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['Proveedor']          = $rowData['ProveedorNombre'];
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['ValorTotal']         = $rowData['ValorTotal'];
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['MontoPagado']        = $rowData['MontoPagado'];
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['idSistema']          = $rowData['idSistema'];
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['idProveedor']        = $rowData['idProveedor'];
	$_SESSION['pagos_boletas_empresas'][$rowData['idFacturacion']]['ValorReal']          = '';

}

?>
