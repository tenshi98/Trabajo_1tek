<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
if(isset($_GET['type'])&&$_GET['type']!=''){
	switch ($_GET['type']) {
		/*******************************************************************/
		//Insumos
		case 1:
			$_SESSION['pago_clientes_insumos'][$_GET['idFacturacion']]['ValorPagado']    = $_GET['pago'];
					
			break;
		/*******************************************************************/
		//Productos
		case 2:
			$_SESSION['pago_clientes_productos'][$_GET['idFacturacion']]['ValorPagado']    = $_GET['pago'];
				
			break;
		/*******************************************************************/
		//Arriendos
		case 3:
			$_SESSION['pago_clientes_arriendo'][$_GET['idFacturacion']]['ValorPagado']    = $_GET['pago'];
				
			break;
		/*******************************************************************/
		//Servicios
		case 4:
			$_SESSION['pago_clientes_servicio'][$_GET['idFacturacion']]['ValorPagado']    = $_GET['pago'];
				
			break;
	}
}


?>
