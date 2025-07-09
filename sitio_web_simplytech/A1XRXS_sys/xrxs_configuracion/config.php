<?php
/**********************************/
/*       Bloque de seguridad      */
/**********************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo.');
}
/**********************************/
/* Configuracion Base de la datos */
/**********************************/

//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
////////////////////////////////////////////////////////////////////////////////
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){

	/*******************************************/
	//Servidor
	define( 'DB_SERVER', 'localhost' );
	define( 'DB_NAME', 'sitio_simplytech');
	define( 'DB_USER', 'root');
	define( 'DB_PASS', '');

	/*******************************************/
	//Repositorio
	define( 'DB_SITE_REPO', 'http://localhost/power_engine' );                        //repositorio
	//Sitio
	define( 'DB_SITE_MAIN', 'http://localhost/power_engine/sitio_web_simplytech' );    //URL del sistema
	define( 'DB_SITE_MAIN_PATH', '/sitio_web_simplytech');                             //Path de la carpeta contenedora

////////////////////////////////////////////////////////////////////////////////
//si estoy en ambiente de produccion
}else{

	/*******************************************/
	//Servidor
	define( 'DB_SERVER', 'localhost' );
	define( 'DB_NAME', 'ntekcl5_simplyt');
	define( 'DB_USER', 'ntekcl5_admin');
	define( 'DB_PASS', '4H4jyrepB3Cs');

	/*******************************************/
	//Repositorio
	define( 'DB_SITE_REPO', 'https://repositorio.simplytech.cl' ); //repositorio
	//Sitio
	define( 'DB_SITE_MAIN', 'https://www.simplytech.cl' );         //URL del sistema
	define( 'DB_SITE_MAIN_PATH', '/sitio_web_simplytech');         //Path de la carpeta contenedora//sitios externos

}
?>
