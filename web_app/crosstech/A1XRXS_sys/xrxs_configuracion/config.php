<?php
/**********************************/
/*       Bloque de seguridad      */
/**********************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1008-001).');
}
/**********************************/
/* Configuracion Base de la datos */
/**********************************/

//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){

	/*******************************************/
	//Servidor
	define( 'DB_SERVER', 'localhost' );
	define( 'DB_NAME', 'power_engine_main');
	define( 'DB_USER', 'root');
	define( 'DB_PASS', '');
	define( 'DB_ERROR_MAIL', 'vreyes@crosstech.cl');
	define( 'DB_GMAIL_USER', 'notificaciones@crosstech.cl');
	define( 'DB_GMAIL_PASSWORD', '.W3lcome1.');

	/*******************************************/
	//Empresa
	define( 'DB_EMPRESA_NAME', 'Crosstech');

//si estoy en ambiente de produccion
}else{

	/*******************************************/
	//Servidor
	define( 'DB_SERVER', 'localhost' );
	define( 'DB_NAME', 'crosstec_pe_clientes');
	define( 'DB_USER', 'crosstech_admin');
	define( 'DB_PASS', '&-VSda,#rFvT');
	define( 'DB_ERROR_MAIL', 'vreyes@crosstech.cl');
	define( 'DB_GMAIL_USER', '');
	define( 'DB_GMAIL_PASSWORD', '');

	/*******************************************/
	//Empresa
	define( 'DB_EMPRESA_NAME', 'Crosstech');

}

?>
