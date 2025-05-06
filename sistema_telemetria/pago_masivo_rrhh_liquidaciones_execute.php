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
if(isset($_SESSION['pago_rrhh_liquidaciones'][$_GET['idFactTrab']]['idFactTrab'])&&$_SESSION['pago_rrhh_liquidaciones'][$_GET['idFactTrab']]['idFactTrab']!=''&&$_SESSION['pago_rrhh_liquidaciones'][$_GET['idFactTrab']]['idFactTrab']==$_GET['idFactTrab']){
	unset($_SESSION['pago_rrhh_liquidaciones'][$_GET['idFactTrab']]);
//Si no existe se crea	
}else{
	//consulto todos los datos
	$SIS_query = 'idFactTrab AS ID,	idFactTrab, idTrabajador,TrabajadorNombre,TrabajadorRut,TotalHaberes,TotalDescuentos,TotalAPagar,	(SELECT SUM(MontoPagado) FROM `pagos_rrhh_liquidaciones` WHERE idFactTrab = ID LIMIT 1) AS MontoPagado';
	$rowData = db_select_data (false, $SIS_query, 'rrhh_sueldos_facturacion_trabajadores', '', 'idFactTrab ='.$_GET['idFactTrab'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');
			
	/******************************************************************/
	//Se traspasan los valores a variables de sesion
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['idFactTrab']        = $rowData['idFactTrab'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['idTrabajador']      = $rowData['idTrabajador'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['TrabajadorNombre']  = $rowData['TrabajadorNombre'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['TrabajadorRut']     = $rowData['TrabajadorRut'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['TotalHaberes']      = $rowData['TotalHaberes'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['TotalDescuentos']   = $rowData['TotalDescuentos'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['TotalAPagar']       = $rowData['TotalAPagar'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['MontoPagado']       = $rowData['MontoPagado'];
	$_SESSION['pago_rrhh_liquidaciones'][$rowData['idFactTrab']]['ValorPagado']       = 0;
	
			
}


?>
