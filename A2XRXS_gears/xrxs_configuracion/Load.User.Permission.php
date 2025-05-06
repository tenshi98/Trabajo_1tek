<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1001-001).');
}
/*******************************************************************************************************************/
/*                                          Conexion de la Base de datos                                           */
/*******************************************************************************************************************/

/*******************************************************/
//variables
$sesion_Activa = 0;

//verifico si tiene sesion activa
if(isset($_SESSION['usuario']['basic_data']['usuario'], $_SESSION['usuario']['basic_data']['password'])&&$_SESSION['usuario']['basic_data']['usuario']!=''&&$_SESSION['usuario']['basic_data']['password']!=''){
	$sesion_usuario  = $_SESSION['usuario']['basic_data']['usuario'];
	$sesion_password = $_SESSION['usuario']['basic_data']['password'];
	$sesion_Activa++;
}

if($sesion_Activa!=0){
	//se consulta la base de datos
	$rowUserId = db_select_nrows (false, 'idUsuario','usuarios_listado', '', 'usuario = "'.$sesion_usuario.'" AND password = "'.$sesion_password.'"', $dbConn, 'Ninguno', basename($_SERVER["REQUEST_URI"], ".php"), 'rowUserId');
	//Se verifca si los datos ingresados son de un usuario registrado
	if (isset($rowUserId)&&$rowUserId!=''&&$rowUserId!=0) {
		//Si existe no se hace nada
	//Si no existe es una entrada forzada
	}else{
		//Se borra todos los datos relacionados a las sesiones
		session_unset();
		session_destroy();
		//Se redirije al inicio del sitio
		header( 'Location: index.php' );
		die;
	}
//Si no hay sesion activa
}else{
	//Se borra todos los datos relacionados a las sesiones
	session_unset();
	session_destroy();
	//Se redirije al inicio del sitio
	header( 'Location: index.php' );
	die;
}

/*******************************************************/
//Verifico si existe la variable
if(isset($_SESSION['usuario']['Permisos'][$original]['level']) && $_SESSION['usuario']['Permisos'][$original]['level']!=''){
	//Si no tiene el nivel necesario para ver la transaccion
	if($_SESSION['usuario']['Permisos'][$original]['level'] <= 0) {
		//redirijo a la pagina principal
		header( 'Location: principal.php' );
		die;
	//Si lo tiene traspaso el nivel de permiso a una variable
	}else{
		$rowlevel['level'] = $_SESSION['usuario']['Permisos'][$original]['level'];
	}
//Si el permiso no existe
}else{
	//redirijo a la pagina principal
	header( 'Location: principal.php' );
	die;
}

?>