<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-016).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener IP del cliente
*
*===========================     Detalles    ===========================
* Permite obtener la ip del cliente que se conecta
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	obtenerIpCliente();
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function obtenerIpCliente() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP')){
		$ipaddress = getenv('HTTP_CLIENT_IP');
	}elseif(getenv('HTTP_X_FORWARDED_FOR')){
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	}elseif(getenv('HTTP_X_FORWARDED')){
		$ipaddress = getenv('HTTP_X_FORWARDED');
	}elseif(getenv('HTTP_FORWARDED_FOR')){
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	}elseif(getenv('HTTP_FORWARDED')){
	   $ipaddress = getenv('HTTP_FORWARDED');
	}elseif(getenv('REMOTE_ADDR')){
		$ipaddress = getenv('REMOTE_ADDR');
	}else{
		$ipaddress = 'UNKNOWN';
	}
	return $ipaddress;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener IP del cliente
*
*===========================     Detalles    ===========================
* Permite obtener la ip del cliente que se conecta
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	obtenerIpClienteAlt();
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function obtenerIpClienteAlt($headerContainingIPAddress = null){
    if (!empty($headerContainingIPAddress)) {
        return isset($_SERVER[$headerContainingIPAddress]) ? trim($_SERVER[$headerContainingIPAddress]) : false;
    }

    $knowIPkeys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
    ];

    foreach ($knowIPkeys as $key) {
        if (array_key_exists($key, $_SERVER) !== true) {
            continue;
        }
        foreach (explode(',', $_SERVER[$key]) as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                return $ip;
            }
        }
    }

    return false;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Navegador
*
*===========================     Detalles    ===========================
* Permite obtener el navegador con el cual se esta accediento
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	obtenerNavegador();
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function obtenerNavegador(){
	//verifico si existe
	if(isset($_SERVER['HTTP_USER_AGENT'])&&$_SERVER['HTTP_USER_AGENT']!=''){
		//obtengo datos
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		//consulto el tipo de navegador
		if(strpos($user_agent, 'Maxthon') !== FALSE){
			return 'Maxthon';
		}elseif(strpos($user_agent, 'SeaMonkey') !== FALSE){
			return 'SeaMonkey';
		}elseif(strpos($user_agent, 'Vivaldi') !== FALSE){
			return 'Vivaldi';
		}elseif(strpos($user_agent, 'Arora') !== FALSE){
			return 'Arora';
		}elseif(strpos($user_agent, 'Avant Browser') !== FALSE){
			return 'Avant Browser';
		}elseif(strpos($user_agent, 'Beamrise') !== FALSE){
			return 'Beamrise';
		}elseif(strpos($user_agent, 'Epiphany') !== FALSE){
			return 'Epiphany';
		}elseif(strpos($user_agent, 'Chromium') !== FALSE){
			return 'Chromium';
		}elseif(strpos($user_agent, 'Iceweasel') !== FALSE){
			return 'Iceweasel';
		}elseif(strpos($user_agent, 'Galeon') !== FALSE){
			return 'Galeon';
		}elseif(strpos($user_agent, 'Edge') !== FALSE){
			return 'Microsoft Edge';
		}elseif(strpos($user_agent, 'Trident') !== FALSE){
			return 'Internet Explorer';
		}elseif(strpos($user_agent, 'MSIE') !== FALSE){
			return 'Internet Explorer';
		}elseif(strpos($user_agent, 'Opera Mini') !== FALSE){
			return 'Opera Mini';
		}elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE){
			return 'Opera';
		}elseif(strpos($user_agent, 'Firefox') !== FALSE){
			return 'Mozilla Firefox';
		}elseif(strpos($user_agent, 'Chrome') !== FALSE){
			return 'Google Chrome';
		}elseif(strpos($user_agent, 'Safari') !== FALSE){
			return 'Safari';
		}elseif(strpos($user_agent, 'iTunes') !== FALSE){
			return 'iTunes';
		}elseif(strpos($user_agent, 'Konqueror') !== FALSE){
			return 'Konqueror';
		}elseif(strpos($user_agent, 'Dillo') !== FALSE){
			return 'Dillo';
		}elseif(strpos($user_agent, 'Netscape') !== FALSE){
			return 'Netscape';
		}elseif(strpos($user_agent, 'Midori') !== FALSE){
			return 'Midori';
		}elseif(strpos($user_agent, 'ELinks') !== FALSE){
			return 'ELinks';
		}elseif(strpos($user_agent, 'Links') !== FALSE){
			return 'Links';
		}elseif(strpos($user_agent, 'Lynx') !== FALSE){
			return 'Lynx';
		}elseif(strpos($user_agent, 'w3m') !== FALSE){
			return 'w3m';
		}else{
			return 'No hemos podido detectar su navegador';
		}
	}else{
		return 'No hemos podido detectar su navegador';
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Sistema Operativo
*
*===========================     Detalles    ===========================
* Permite obtener el sistema operativo con el cual se esta accediendo
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	obtenerSistOperativo();
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function obtenerSistOperativo(){
	//verifico si existe
	if(isset($_SERVER['HTTP_USER_AGENT'])&&$_SERVER['HTTP_USER_AGENT']!=''){
		//obtengo datos
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		//consulto el tipo de navegador
		if(strpos($user_agent, 'Windows NT 10.0') !== FALSE){
			return 'Windows 10';
		}elseif(strpos($user_agent, 'Windows NT 6.3') !== FALSE){
			return 'Windows 8.1';
		}elseif(strpos($user_agent, 'Windows NT 6.2') !== FALSE){
			return 'Windows 8';
		}elseif(strpos($user_agent, 'Windows NT 6.1') !== FALSE){
			return 'Windows 7';
		}elseif(strpos($user_agent, 'Windows NT 6.0') !== FALSE){
			return 'Windows Vista';
		}elseif(strpos($user_agent, 'Windows NT 5.1') !== FALSE){
			return 'Windows XP';
		}elseif(strpos($user_agent, 'Windows NT 5.2') !== FALSE){
			return 'Windows 2003';
		}elseif(strpos($user_agent, 'Windows NT 5.0') !== FALSE){
			return 'Windows 2000';
		}elseif(strpos($user_agent, 'Windows ME') !== FALSE){
			return 'Windows ME';
		}elseif(strpos($user_agent, 'Win98') !== FALSE){
			return 'Windows 98';
		}elseif(strpos($user_agent, 'Win95') !== FALSE){
			return 'Windows 95';
		}elseif(strpos($user_agent, 'WinNT4.0') !== FALSE){
			return 'Windows NT 4.0';
		}elseif(strpos($user_agent, 'Windows Phone') !== FALSE){
			return 'Windows Phone';
		}elseif(strpos($user_agent, 'Windows') !== FALSE){
			return 'Windows';
		}elseif(strpos($user_agent, 'iPhone') !== FALSE){
			return 'iPhone';
		}elseif(strpos($user_agent, 'iPad') !== FALSE){
			return 'iPad';
		}elseif(strpos($user_agent, 'Debian') !== FALSE){
			return 'Debian';
		}elseif(strpos($user_agent, 'Ubuntu') !== FALSE){
			return 'Ubuntu';
		}elseif(strpos($user_agent, 'Slackware') !== FALSE){
			return 'Slackware';
		}elseif(strpos($user_agent, 'Linux Mint') !== FALSE){
			return 'Linux Mint';
		}elseif(strpos($user_agent, 'Gentoo') !== FALSE){
			return 'Gentoo';
		}elseif(strpos($user_agent, 'Elementary OS') !== FALSE){
			return 'ELementary OS';
		}elseif(strpos($user_agent, 'Fedora') !== FALSE){
			return 'Fedora';
		}elseif(strpos($user_agent, 'Kubuntu') !== FALSE){
			return 'Kubuntu';
		}elseif(strpos($user_agent, 'Linux') !== FALSE){
			return 'Linux';
		}elseif(strpos($user_agent, 'FreeBSD') !== FALSE){
			return 'FreeBSD';
		}elseif(strpos($user_agent, 'OpenBSD') !== FALSE){
			return 'OpenBSD';
		}elseif(strpos($user_agent, 'NetBSD') !== FALSE){
			return 'NetBSD';
		}elseif(strpos($user_agent, 'SunOS') !== FALSE){
			return 'Solaris';
		}elseif(strpos($user_agent, 'BlackBerry') !== FALSE){
			return 'BlackBerry';
		}elseif(strpos($user_agent, 'Android') !== FALSE){
			return 'Android';
		}elseif(strpos($user_agent, 'Mobile') !== FALSE){
			return 'Firefox OS';
		}elseif(strpos($user_agent, 'Mac OS X+') || strpos($user_agent, 'CFNetwork+') !== FALSE){
			return 'Mac OS X';
		}elseif(strpos($user_agent, 'Macintosh') !== FALSE){
			return 'Mac OS Classic';
		}elseif(strpos($user_agent, 'OS/2') !== FALSE){
			return 'OS/2';
		}elseif(strpos($user_agent, 'BeOS') !== FALSE){
			return 'BeOS';
		}elseif(strpos($user_agent, 'Nintendo') !== FALSE){
			return 'Nintendo';
		}else{
			return 'Plataforma Desconocida';
		}
	}else{
		return 'Plataforma Desconocida';
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener el entorno
*
*===========================     Detalles    ===========================
* Permite obtener el entorno de trabajo (local o produccion)
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	getEntorno();
*
*===========================    Parametros   ===========================
* @return  Bollean
************************************************************************/
//Funcion
function getEntorno(){
    //verifica la capa de desarrollo
	$whitelist = array( 'localhost', '127.0.0.1', '::1' );
	//si estoy en ambiente de desarrollo
	if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
		return true;
	//si estoy en ambiente de produccion
	}else{
		return false;
	}
}

?>
