<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
if(isset($_GET['idFacturacion'])&&$_GET['idFacturacion']!=''){

	$_SESSION['pagos_boletas_trabajadores'][$_GET['idFacturacion']]['ValorReal']    = $_GET['pago'];

}

?>
