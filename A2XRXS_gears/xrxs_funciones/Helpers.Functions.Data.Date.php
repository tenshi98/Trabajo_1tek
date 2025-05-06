<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-005).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_completa('2024-01-01'); //Devuelve enero 01 del 2024
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function Fecha_completa($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$options = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	$mes_c   = new DateTime($Fecha);
	$dia     = $mes_c->format('d');
	$me      = $mes_c->format('m');
	$ano     = $mes_c->format('Y');
	$mes     = $options[$me-1];

	return $mes.' '.$dia.' del '.$ano;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_completa_alt('2024-01-01'); //Devuelve 01 de enero de 2024
*
*===========================    Parametros   ===========================
* Date     $Fecha    Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function Fecha_completa_alt($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$options = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	$mes_c   = new DateTime($Fecha);
	$dia     = $mes_c->format('d');
	$me      = $mes_c->format('m');
	$ano     = $mes_c->format('Y');
	$mes     = $options[$me-1];

	return $dia.' de '.$mes.' de '.$ano;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Dia_Mes('2024-01-01'); //Devuelve 01 Enero
*
*===========================    Parametros   ===========================
* Date     $Fecha    Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function Dia_Mes($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$options = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	$mes_c   = new DateTime($Fecha);
	$dia     = $mes_c->format('d');
	$me      = $mes_c->format('m');
	$mes     = $options[$me-1];

	return $dia.' '.$mes;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_estandar('2024-01-01'); //Devuelve 01-01-2024
*
*===========================    Parametros   ===========================
* Date     $Fecha    Fecha a Formatear
* @return  Date
************************************************************************/
//Funcion
function Fecha_estandar($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	return date_format(date_create($Fecha), 'd-m-Y');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_estandar_c('2024-01-01'); //Devuelve 01-01-24
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Date
************************************************************************/
//Funcion
function Fecha_estandar_c($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	return date_format(date_create($Fecha), 'd-m-y');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_normalizada('2024-01-01'); //Devuelve 2024-01-01
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Date
************************************************************************/
//Funcion
function Fecha_normalizada($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR ($Fecha=='0000-00-00' OR $Fecha=='00-00-0000')){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){                                         return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	return date_format(date_create(str_replace('/', '-', $Fecha)), 'Y-m-d');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_archivos('2024-01-01'); //Devuelve 20240101
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Date
************************************************************************/
//Funcion
function Fecha_archivos($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR ($Fecha=='0000-00-00' OR $Fecha=='00-00-0000')){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){                                         return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	return date_format(date_create(str_replace('/', '-', $Fecha)), 'Ymd');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Cambia el formato de fecha por uno mas utilizado
*
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_mes_ano('2024-01-01'); //Devuelve Enero del 2024
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function Fecha_mes_ano($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$options = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	$mes_c   = new DateTime($Fecha);
	$me      = $mes_c->format('m');
	$ano     = $mes_c->format('Y');
	$mes     = $options[$me-1];

	return $mes.' del '.$ano;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transformar fecha a numero de dia en el mes
*
*===========================     Detalles    ===========================
* Permite obtener el numero del dia en el mes a partir de la fecha
* ingresada, 2 dígitos sin ceros iniciales (1 al 31)
*===========================    Modo de uso  ===========================
*
* 	//se obtiene el numero del dia
* 	fecha2NdiaMes('2024-01-02'); //Devuelve 2
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Integer
************************************************************************/
//Funcion
function fecha2NdiaMes($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$subdato = new DateTime($Fecha);
	return $subdato->format("j");

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transformar fecha a numero de dia en el mes
*
*===========================     Detalles    ===========================
* Permite obtener el numero del dia en el mes a partir de la fecha
* ingresada, 2 dígitos con ceros iniciales (1 al 31)
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	fecha2NdiaMesCon0('2024-01-01'); //Devuelve 01
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Integer
************************************************************************/
//Funcion
function fecha2NdiaMesCon0($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$dia = new DateTime($Fecha);
	return $dia->format('d');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Numero del dia en la semana
*
*===========================     Detalles    ===========================
* Muestra el numero del dia dentro de la semana, siendo 1 (para lunes)
* hasta 7 (para domingo)
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	fecha2NDiaSemana('2024-01-01'); //Devuelve 1
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Integer
************************************************************************/
//Funcion
function fecha2NDiaSemana($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$dias = new DateTime($Fecha);
	return $dias->format('N');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve el nombre del dia
*
*===========================     Detalles    ===========================
* Devuelve el nombre del dia en base a la fecha ingresada (lunes a domingo)
*===========================    Modo de uso  ===========================
*
* 	//se transforma los datos
* 	fecha2NombreDia('2024-01-02'); //Devuelve Martes
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function fecha2NombreDia($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$options = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
	$me      = fecha2NDiaSemana($Fecha);
	$dia     = $options[$me-1];
	return $dia;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Se obtiene el numero de la semana en base a la fecha entregada
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	fecha2NSemana('2024-01-01'); //Devuelve 01
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Integer
************************************************************************/
//Funcion
function fecha2NSemana($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$subdato = new DateTime($Fecha);
	return $subdato->format("W");

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Se obtiene el numero del mes en base a la fecha entregada (1 a 12)
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	fecha2NMes('2024-01-01'); //Devuelve 1
*
*===========================    Parametros   ===========================
* Date     $Fecha  Fecha a Formatear
* @return  Integer
************************************************************************/
//Funcion
function fecha2NMes($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$subdato = new DateTime($Fecha);
	return $subdato->format("n");

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Se obtiene el nombre del mes en base a una fecha ingresada
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	fecha2NombreMes('2024-01-01'); //Devuelve Enero
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function fecha2NombreMes($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$options = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	$me      = fecha2NMes($Fecha);
	$mes     = $options[$me-1];
	return $mes;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Se obtiene el nombre abreviado (3 primeras letras) del mes en base
* a una fecha ingresada
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	fecha2NombreMesCorto('2024-01-01'); //Devuelve Ene
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function fecha2NombreMesCorto($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$options = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
	$me      = fecha2NMes($Fecha);
	$mes     = $options[$me-1];
	return $mes;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Obtiene el Año en base a la fecha ingresada
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	fecha2Ano('2024-01-01'); //Devuelve 2024
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  Integer
************************************************************************/
//Funcion
function fecha2Ano($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	$dia = new DateTime($Fecha);
	return $dia->format('Y');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Formatea la fecha entregada
*
*===========================     Detalles    ===========================
* Se obtiene la descripcion de la fecha en ingles, una representación
* textual completa de un mes, como January o March, el numero del dia
* y el año
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_gringa('2024-01-01'); //Devuelve January 01 2024
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a Formatear
* @return  String
************************************************************************/
//Funcion
function Fecha_gringa($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	return date_format(date_create($Fecha), 'F d Y');

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Entrega el ultimo dia del mes
*
*===========================     Detalles    ===========================
* Se obtiene el ultimo dia del mes de la fecha entregada
*===========================    Modo de uso  ===========================
*
* 	//se formatea fecha
* 	Fecha_ultimo_dia_mes('2024-01-01'); //Devuelve '2024-01-31'
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha a usar
* @return  String
************************************************************************/
//Funcion
function Fecha_ultimo_dia_mes($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	return date("Y-m-t", strtotime($Fecha));

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve la fecha formateada
*
*===========================     Detalles    ===========================
* Devuelve la fecha formateada: Diciembre 12 del 2023 13:17:59
*===========================    Modo de uso  ===========================
*
* 	//se convierten los datos
* 	fullDate('2023-12-12 13:17:59');
*
*===========================    Parametros   ===========================
* int       $Fecha   Fecha a transformar
* @return   String
************************************************************************/
//Funcion
function fullDate($Fecha){

	/**********************/
	//Validaciones
	if($Fecha=='' OR $Fecha=='0000-00-00'){ return 'Sin Fecha';}
	if(!validaFecha($Fecha)){               return 'El dato ingresado no es una fecha ('.$Fecha.')';}

	/**********************/
	//Si todo esta ok
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Se formatea
	$options = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	$dia     = date("d", $Fecha);
	$me      = date("m", $Fecha);
	$ano     = date("Y", $Fecha);
	$hora    = date("H:i:s", $Fecha);
	$mes     = $options[$me-1];

	return $mes.' '.$dia.' del '.$ano.' '.$hora;

}




?>
