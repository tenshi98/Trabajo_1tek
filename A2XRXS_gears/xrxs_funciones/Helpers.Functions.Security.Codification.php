<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-014).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Codifica un texto
*
*===========================     Detalles    ===========================
* Permite codificar un texto para que quede ilegible a la lectura normal,
* con la opción de la utilizacion de una palabra clave para su codificacion
*===========================    Modo de uso  ===========================
*
* 	//se codifica texto
* 	simpleEncode("php recipe");
* 	simpleEncode("php recipe", "passkey"); //Devuelve 'lEKK57naUY4/VQ=='
*
*===========================    Parametros   ===========================
* String   $simple_string   Texto a transformar
* String   $passkey         (Opcional)Palabra clave de codificacion
* @return  String
************************************************************************/
//Funcion
function simpleEncode($simple_string, $passkey) {
    /**************************************/
    if (!$simple_string) {
        return false;
    }
    /**************************************/
    if (!isset($passkey) OR empty($passkey) OR $passkey=='') {
        $encryption_key = sha1('EnCRypT10nK#Y!RiSRNn');
    }else{
		$encryption_key = $passkey;
	}
    /**************************************/
    //variables
    $ciphering     = "AES-128-CTR";// Store the cipher method
    //$iv_length     = openssl_cipher_iv_length($ciphering);// Use OpenSSl Encryption method
    $options       = 0;
    $encryption_iv = '1234567891011121';// Non-NULL Initialization Vector for encryption
    // Use openssl_encrypt() function to encrypt the data
    $encryption    = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);
    /**************************************/
    /**************************************/
    //verifico si hay que reemplazar algo
    $vowels1 = array("+");
    $vowels2 = array("_");
    $encryption = str_replace($vowels1, $vowels2, $encryption);
    //verifico si hay que reemplazar algo
    $vowels1 = array("/");
    $vowels2 = array("k123k");
    $encryption = str_replace($vowels1, $vowels2, $encryption);
    //devuelvo
    return $encryption;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Decodifica un texto
*
*===========================     Detalles    ===========================
* Permite decodificar un texto para que quede legible a la lectura normal,
* con la opción de la utilizacion de una palabra clave para su
* decodificacion
*===========================    Modo de uso  ===========================
*
* 	//se decodifica texto
* 	simpleDecode("qcnVhqjKxpuilw==");
* 	simpleDecode("lEKK57naUY4/VQ==", "passkey"); //Devuelve 'php recipe'
*
*===========================    Parametros   ===========================
* String   $simple_string   Texto a transformar
* String   $passkey         (Opcional)Palabra clave de codificacion
* @return  String
************************************************************************/
//Funcion
function simpleDecode($string, $passkey) {
    /**************************************/
    //verifico si hay que reemplazar algo
    if (!$string) {return false;}
    /**************************************/
    //verifico si hay que reemplazar algo
    $vowels1 = array("_");
    $vowels2 = array(" ");
    $string = str_replace($vowels1, $vowels2, $string);
    //verifico si hay que reemplazar algo
    $vowels1 = array("k123k");
    $vowels2 = array("/");
    $string = str_replace($vowels1, $vowels2, $string);
    //verifico si hay que reemplazar algo
    $vowels1 = array(" ");
    $vowels2 = array("+");
    $simple_string = str_replace($vowels1, $vowels2, $string);
    /**************************************/
    //verifico la contraseña
    if (!isset($passkey) OR empty($passkey) OR $passkey=='') {
        $decryption_key = sha1('EnCRypT10nK#Y!RiSRNn');
    }else{
		$decryption_key = $passkey;
	}
    /**************************************/
    //variables
    $ciphering     = "AES-128-CTR";// Store the cipher method
    //$iv_length     = openssl_cipher_iv_length($ciphering);// Use OpenSSl Encryption method
    $options       = 0;
    $decryption_iv = '1234567891011121';// Non-NULL Initialization Vector for encryption
    // Use openssl_encrypt() function to encrypt the data
    $decryption    = openssl_decrypt ($simple_string, $ciphering, $decryption_key, $options, $decryption_iv);
    /**************************************/
    //devuelvo
    return $decryption;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Generador Hash
*
*===========================     Detalles    ===========================
* Codificacion propia por cada servidor, esto impide el copiado de
* información entre servidores
*===========================    Modo de uso  ===========================
*
* 	//se genera codigo
* 	generateServerSpecificHash(); //Devuelve '421aa90e079fa326b6494f812ad13e79'
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function generateServerSpecificHash(){
	return (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']))
            ? md5($_SERVER['SERVER_NAME'])
            : md5(pathinfo(__FILE__, PATHINFO_FILENAME));
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Decodifica un texto
*
*===========================     Detalles    ===========================
* Permite decodificar un texto para que quede legible a la lectura normal,
* con la opción de la utilizacion de una palabra clave para su
* decodificacion
*===========================    Modo de uso  ===========================
*
* 	// Encriptas id 5008
* 	$encriptar = encrypt_decrypt('encrypt',5008);
* 	echo $encriptar . '<br>';
*
* 	// Desencriptas el id para verlo de manera original
* 	$desencriptar = encrypt_decrypt('decrypt',$encriptar);
* 	echo $desencriptar;
*
* 	//salidas:
* 	bnR6UTRVTHAzYWd1dWEvWVdpMGo4QT09 (corresponde a 5008)
* 	5008
*
*===========================    Parametros   ===========================
* String   $string   Texto a transformar
* String   $passkey  (Opcional)Palabra clave de codificacion
* @return  String
************************************************************************/
function encrypt_decrypt($action, $string) :string {
	$output         = false;
	$encrypt_method = "AES-256-CBC";
	$secret_key     = 'tu_clave_secreta';
	$secret_iv      = 'salt_secreto';
	// hash
	$key = hash('sha256', $secret_key);
	// iv - encrypt method AES-256-CBC expects 16 bytes
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	if ( $action == 'encrypt' ) {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	}elseif( $action == 'decrypt' ) {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}
	return $output;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Generador Hash
*
*===========================     Detalles    ===========================
* Codificacion propia por cada servidor, esto impide el copiado de
* información entre servidores
*===========================    Modo de uso  ===========================
*
* 	//se genera codigo
* 	token_bin2hex(25); //Devuelve valores aleatoreos
*
*===========================    Parametros   ===========================
* int      $longitud  largo del codigo generado
* @return  String
************************************************************************/
//Funcion
function token_bin2hex($longitud) {
	$token = bin2hex(openssl_random_pseudo_bytes(($longitud - ($longitud % 2)) / 2));
	return $token;
}

?>
