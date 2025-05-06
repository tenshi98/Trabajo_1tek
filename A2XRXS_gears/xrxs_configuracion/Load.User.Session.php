<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1001-002).');
}
/*******************************************************************************************************************/
/*                                          Conexion de la Base de datos                                           */
/*******************************************************************************************************************/
// obtengo puntero de conexion con la db
$dbConn = conectar();

//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");

/***************************************************************/
//Se revisa siel usuario cerro voluntariamente la sesion
if (!empty($_GET['salir'])){
	//Se borra todos los datos relacionados a las sesiones
	session_unset();
	session_destroy();
	//Se redirije al inicio del sitio
	header( 'Location: index.php?exit=true' );
	die;
}

/***************************************************************/
//Se verifica si el usuario esta conectado
if (!empty( $_SESSION['usuario'] )&&(isset($_SESSION['usuario']['basic_data']['password'])&&$_SESSION['usuario']['basic_data']['password']!='')){
	//nada
//en caso de que no sea ninguno de los anteriores
}else{
	//Se borra todos los datos relacionados a las sesiones
	session_unset();
	session_destroy();
	//Se redirije al inicio del sitio
	header( 'Location: index.php' );
	die;
}

/***************************************************************/
//Se verifica que la fecha de login sea la misma que la fecha actual
/*if($_SESSION['usuario']['basic_data']['FechaLogin']!=fecha_actual()){
	//Se borra todos los datos relacionados a las sesiones
	session_unset();
	session_destroy();
	//Se redirije al inicio del sitio
	header( 'Location: index.php' );
	die;
}*/

?>
