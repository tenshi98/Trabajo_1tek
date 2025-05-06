<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1001-003).');
}
/*******************************************************************************************************************/
/*                                          Conexion de la Base de datos                                           */
/*******************************************************************************************************************/
// Se verifica que sea un administrador el que esta ingresando a la transaccion
if (isset($_SESSION['usuario']['basic_data']['tipo'])&&$_SESSION['usuario']['basic_data']['tipo']!=''&&$_SESSION['usuario']['basic_data']['tipo']!=1) {
	//Si el usuario no posee los permisos redirijo
	header( 'Location: principal.php' );
	die;
}

?>
