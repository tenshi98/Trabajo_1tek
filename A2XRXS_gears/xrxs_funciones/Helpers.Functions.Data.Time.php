<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-009).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Hora Estandar
*
*===========================     Detalles    ===========================
* Transforma la hora ingresada al formato estandar
*===========================    Modo de uso  ===========================
*
* 	//se formatea la hora
* 	Hora_estandar('1:1'); //devuelve 01:01
*
*===========================    Parametros   ===========================
* Time     $Hora   Hora a formatear
* @return  Time
************************************************************************/
//Funcion
function Hora_estandar($Hora){

	/**********************/
	//Validaciones
	if(!validaHora($Hora)){ return 'El dato ingresado no es una hora ('.$Hora.')';}
	if($Hora=='00:00:00'){  return 'Sin Hora';}

	/**********************/
	//Si todo esta ok
	return date_format(date_create($Hora), 'H:i');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve la hora programada
*
*===========================     Detalles    ===========================
* Transforma la hora ingresada al formato de hora programada
*===========================    Modo de uso  ===========================
*
* 	//se formatea la hora
* 	Hora_prog('1:1'); //devuelve 01:01:00
*
*===========================    Parametros   ===========================
* Time     $Hora   Hora a formatear
* @return  Time
************************************************************************/
//Funcion
function Hora_prog($Hora){

	/**********************/
	//Validaciones
	//if(!validaHora($Hora)){ return 'El dato ingresado no es una hora ('.$Hora.')';}
	if($Hora=='00:00:00'){  return 'Sin Hora';}

	/**********************/
	//Si todo esta ok
	return date("H:i:s", strtotime($Hora));

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve la hora programada
*
*===========================     Detalles    ===========================
* Transforma la hora ingresada al formato de hora programada
*===========================    Modo de uso  ===========================
*
* 	//se formatea la hora
* 	Hora_archivos('1:1'); //devuelve 010100
*
*===========================    Parametros   ===========================
* Time     $Hora   Hora a formatear
* @return  Time
************************************************************************/
//Funcion
function Hora_archivos($Hora){

	/**********************/
	//Validaciones
	//if(!validaHora($Hora)){ return 'El dato ingresado no es una hora ('.$Hora.')';}
	if($Hora=='00:00:00'){  return 'Sin Hora';}

	/**********************/
	//Si todo esta ok
	return date("His", strtotime($Hora));

}

?>
