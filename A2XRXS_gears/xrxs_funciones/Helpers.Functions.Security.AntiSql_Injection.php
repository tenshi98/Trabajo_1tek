<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-013).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* verifica si el dato ingresado es un intento de hackeo
*
*===========================     Detalles    ===========================
* Verifica si el dato ingresado es un intento de hackeo
*===========================    Modo de uso  ===========================
*
* 	//se verifica
* 	secure("datos'DATA ATACK'");
*
*===========================    Parametros   ===========================
* String   $string   Texto a verificar
* @return  String
************************************************************************/
function secure($Data) {

	//Si el dato no es un numero
	if (!is_numeric($Data)) {

		//se definen las letras a reemplazar
		$originales   = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿª';
		$modificadas  = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybya';
		$cadena       = mb_convert_encoding($Data, 'ISO-8859-1', 'UTF-8');
		$cadena       = strtr($cadena, mb_convert_encoding($originales, 'ISO-8859-1', 'UTF-8'), $modificadas);
		$Data         = mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
		//se cambian todas las letras a minusculas
		$Data         = strtolower($Data);

		//%20 = espacio
		//%22 = "
		//%25 = %
		//%27 = '
		//%2B = +
		//%2D = -
		//%2F = /
		//%3B = ;
		//%3C = <
		//%3D = =
		//%3E = >
		//%3F = ?

		//Lista de palabras censuradas en ingles
		$inject = array('drop','table','insert','update','select','like', 'union', 'truncate', 'shutdown', 'show',
						'"', '""',"'", "''",
						'";', "';", ';',
						'"OR"', "'OR'",
						'char(',
						'%20', '%22', '%25', '%27', '%2B', '%2D', '%2F', '%3B', '%3C', '%3D', '%3E', '%3F'

		);

		//
		$contador = 0;
		//se revisa una a una
		for ($i=0; $i < count($inject); $i++) {
			if( strpos($Data,$inject[$i]) !== false ){

				//Cuenta las prohibidas
				$contador++;
			}
		}

		//si no hay ninguna
		if($contador==0){
			return $Data;
		}else{
			return $contador;
		}

		//$Data = mysqli_real_escape_string($dbConn, $Data);
	}elseif(is_numeric($Data) && abs($Data) == $Data){
		$Data = $Data;
		return $Data;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Sanitizar los datos
*
*===========================     Detalles    ===========================
* Sanitiza los datos de acuerdo a los estandares de PHP
*===========================    Modo de uso  ===========================
*
* 	//se Sanitiza
* 	SanitizarDatos("datos'DATA ATACK'");
*
*===========================    Parametros   ===========================
* String   $string   Texto a Sanitizar
* @return  String
************************************************************************/
function SanitizarDatos($Data) {
	// Loop through POST variables
	foreach($Data as $input => $value) {
		$Data[$input] = secure($value);
	}
	return $Data;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Impide la injeccion
*
*===========================     Detalles    ===========================
* Impide la injeccion de datos
*===========================    Modo de uso  ===========================
*
* 	//se verifica
* 	anti_injection("from|select");
*
*===========================    Parametros   ===========================
* String   $string   Texto a verificar
* @return  String
************************************************************************/
function anti_injection($sql){
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "" ,$sql);
    $sql = trim($sql);
    $sql = strip_tags($sql);
    $sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
    return $sql;
}


?>
