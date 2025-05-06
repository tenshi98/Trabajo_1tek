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
			if(isset($_SESSION['pago_clientes_insumos'][$_GET['value']]['MontoNC'])&&$_SESSION['pago_clientes_insumos'][$_GET['value']]['MontoNC']!=''){
				$valor_ant = $_SESSION['pago_clientes_insumos'][$_GET['value']]['MontoNC'] - $_GET['valor'];
			}else{
				$valor_ant = 0;
			}
			$_SESSION['pago_clientes_insumos'][$_GET['idFacturacion']]['idFacRelacionada']    = 0;
			$_SESSION['pago_clientes_insumos'][$_GET['idFacturacion']]['FacRelacionada']      = '';
			$_SESSION['pago_clientes_insumos'][$_GET['value']]['MontoNC']                     = $valor_ant;
					
			break;
		/*******************************************************************/
		//Productos
		case 2:
			if(isset($_SESSION['pago_clientes_productos'][$_GET['value']]['MontoNC'])&&$_SESSION['pago_clientes_productos'][$_GET['value']]['MontoNC']!=''){
				$valor_ant = $_SESSION['pago_clientes_productos'][$_GET['value']]['MontoNC'] - $_GET['valor'];
			}else{
				$valor_ant = 0;
			}
			$_SESSION['pago_clientes_productos'][$_GET['idFacturacion']]['idFacRelacionada']    = 0;
			$_SESSION['pago_clientes_productos'][$_GET['idFacturacion']]['FacRelacionada']      = '';
			$_SESSION['pago_clientes_productos'][$_GET['value']]['MontoNC']                     = $valor_ant;
				
			break;
		/*******************************************************************/
		//Arriendos
		case 3:
			if(isset($_SESSION['pago_clientes_arriendo'][$_GET['value']]['MontoNC'])&&$_SESSION['pago_clientes_arriendo'][$_GET['value']]['MontoNC']!=''){
				$valor_ant = $_SESSION['pago_clientes_arriendo'][$_GET['value']]['MontoNC'] - $_GET['valor'];
			}else{
				$valor_ant = 0;
			}
			$_SESSION['pago_clientes_arriendo'][$_GET['idFacturacion']]['idFacRelacionada']    = 0;
			$_SESSION['pago_clientes_arriendo'][$_GET['idFacturacion']]['FacRelacionada']      = '';
			$_SESSION['pago_clientes_arriendo'][$_GET['value']]['MontoNC']                     = $valor_ant;
				
			break;
		/*******************************************************************/
		//Servicios
		case 4:
			if(isset($_SESSION['pago_clientes_servicio'][$_GET['value']]['MontoNC'])&&$_SESSION['pago_clientes_servicio'][$_GET['value']]['MontoNC']!=''){
				$valor_ant = $_SESSION['pago_clientes_servicio'][$_GET['value']]['MontoNC'] - $_GET['valor'];
			}else{
				$valor_ant = 0;
			}
			$_SESSION['pago_clientes_servicio'][$_GET['idFacturacion']]['idFacRelacionada']    = 0;
			$_SESSION['pago_clientes_servicio'][$_GET['idFacturacion']]['FacRelacionada']      = '';
			$_SESSION['pago_clientes_servicio'][$_GET['value']]['MontoNC']                     = $valor_ant;
				
			break;
	}
}


?>
