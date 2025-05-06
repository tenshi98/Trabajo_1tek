<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-007).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Divide horas
*
*===========================     Detalles    ===========================
* Permite dividir la hora en base a un numero entero, Devuelve el
* resultado en minutos, si se requiere en horas, utilizar la funcion
* correspondiente
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	divHoras('04:00:00', 4); //Devuelve 60
*
*===========================    Parametros   ===========================
* Time     $hora        Hora ingresada
* int      $divisor     Divisor de la hora
* @return  Integer
************************************************************************/
//Funcion
function divHoras($hora,$divisor) {

	/**********************/
	//Validaciones
	if(!validaHora($hora)){       return 'El dato ingresado no es una hora ('.$hora.')';}
	if(!validarNumero($divisor)){ return 'El dato ingresado no es un numero';}
	if(!validaEntero($divisor)){  return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	$minutos = horas2minutos($hora);
	$difm    = $minutos/$divisor;
	return $difm;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Multiplicar Horas
*
*===========================     Detalles    ===========================
* Permite multiplicar las horas ingresadas por un numero entero, el
* resultado es devuelto en formato hora
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	multHoras('04:00:00', 4); //Devuelve 16:00:00
*
*===========================    Parametros   ===========================
* Time     $hora            Hora ingresada
* int      $multiplicador   Multiplicador de la hora
* @return  Time
************************************************************************/
//Funcion
function multHoras($hora,$multiplicador) {

	/**********************/
	//Validaciones
	if(!validaHora($hora)){             return 'El dato ingresado no es una hora ('.$hora.')';}
	if(!validarNumero($multiplicador)){ return 'El dato ingresado no es un numero';}
	if(!validaEntero($multiplicador)){  return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	$seconds  = strtotime("1970-01-01 $hora UTC");
	$multiply = $seconds * $multiplicador;  //Aqui se multiplica
	$seconds  = $multiply;
	$zero     = new DateTime("@0");
	$offset   = new DateTime("@$seconds");
	$diff     = $zero->diff($offset);
	return sprintf("%02d:%02d:%02d", $diff->days * 24 + $diff->h, $diff->i, $diff->s);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Restar Horas
*
*===========================     Detalles    ===========================
* Permite restar una hora a otra hora, devolviendo un resultado en
* formato hora, verifica cual hora es mayor para evitar problemas
* en la resta
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	restahoras('14:00:00', '07:00:00'); //Devuelve 07:00:00
*
*===========================    Parametros   ===========================
* Time    $hora        Hora ingresada
* Time    $horaresta   Cantidad de horas a restar
* @return  Time
************************************************************************/
//Funcion
function restahoras($hora, $horaresta){

	/**********************/
	//Validaciones
	if(!validaHora($hora)){      return 'El dato ingresado no es una hora ('.$hora.')';}
	if(!validaHora($horaresta)){ return 'El dato ingresado no es una hora ('.$horaresta.')';}

	/**********************/
	//Si todo esta ok
	//Se verifica cual es el mayor
	if(strtotime($hora)>strtotime($horaresta)){
		$horaresta  = sumahoras($horaresta, '24:00:00');
	}

	//Separo la hora
	$hora      = explode(":",$hora);
	$horaresta = explode(":",$horaresta);

	//obtengo valores por separado
	$horai = $hora[0];
	$mini  = $hora[1];
	$segi  = $hora[2];

	//obtengo valores por separado
	$horaf = $horaresta[0];
	$minf  = $horaresta[1];
	$segf  = $horaresta[2];

	//transformo a segundos
	$ini   = ((($horai*60)*60)+($mini*60)+$segi);
	$fin   = ((($horaf*60)*60)+($minf*60)+$segf);

	//ejecuto operacion
	$dif   = $fin-$ini;

	//devuelvo
	return segundos2horas($dif);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Sumar Horas
*
*===========================     Detalles    ===========================
* Permite la suma de dos horas, dando como resultado otro dato con
* formato hora
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	sumahoras('14:00:00', '07:00:00'); //Devuelve 21:00:00
*
*===========================    Parametros   ===========================
* Time     $hora        Hora ingresada
* Time     $horasuma    Cantidad de horas a sumar
* @return  Time
************************************************************************/
//Funcion
function sumahoras($hora,$horasuma){

	/**********************/
	//Validaciones
	if(!validaHora($hora)){ return 'El dato ingresado no es una hora ('.$hora.')';}
	//if(!validaHora($horasuma)){ return 'El dato ingresado no es una hora ('.$horasuma.')';}

	/**********************/
	//Si todo esta ok
	//Separo la hora
	$hora     = explode(":",$hora);
	$horasuma = explode(":",$horasuma);

	//obtengo valores por separado
	$horai = $hora[0];
	$mini  = $hora[1];
	$segi  = $hora[2];

	//obtengo valores por separado
	$horaf = $horasuma[0];
	$minf  = $horasuma[1];
	$segf  = $horasuma[2];

	//transformo a segundos
	$ini   = ((($horai*60)*60)+($mini*60)+$segi);
	$fin   = ((($horaf*60)*60)+($minf*60)+$segf);

	//ejecuto operacion
	$dif   = $fin+$ini;

	//devuelvo
	return segundos2horas($dif);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Sumar dias
*
*===========================     Detalles    ===========================
* Permite sumar n cantidad de dias a una fecha entregada
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	sumarDias('2019-01-02', 5); //Devuelve 2019-01-07
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha entregada
* int      $nDias   Cantidad de dias a sumar
* @return  Date
************************************************************************/
//Funcion
function sumarDias($Fecha,$nDias){

	/**********************/
	//Validaciones
	if(!validaFecha($Fecha)){   return 'El dato ingresado no es una fecha ('.$Fecha.')';}
	if(!validarNumero($nDias)){ return 'El dato ingresado no es un numero';}
	if(!validaEntero($nDias)){  return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	$nuevafecha = strtotime ( '+'.$nDias.' day' , strtotime ( $Fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	return $nuevafecha;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Restar dias
*
*===========================     Detalles    ===========================
* Permite restar n cantidad de dias a una fecha entregada
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	restarDias('2019-01-07', 5); //Devuelve 2019-01-02
*
*===========================    Parametros   ===========================
* Date     $Fecha   Fecha entregada
* int      $nDias   Cantidad de dias a restar
* @return  Date
************************************************************************/
//Funcion
function restarDias($Fecha,$nDias){

	/**********************/
	//Validaciones
	if(!validaFecha($Fecha)){   return 'El dato ingresado no es una fecha ('.$Fecha.')';}
	if(!validarNumero($nDias)){ return 'El dato ingresado no es un numero';}
	if(!validaEntero($nDias)){  return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	$nuevafecha = strtotime ( '-'.$nDias.' day' , strtotime ( $Fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	return $nuevafecha;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Ver años transcurridos entre fechas
*
*===========================     Detalles    ===========================
* Permite ver el numero de los años y meses transcurridos a partir de una
* fecha entregada y la fecha actual
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	obtener_edad('2022-01-01'); //Devuelve 'dos años, 5 meses' (a la fecha '2024-06-01')
*
*===========================    Parametros   ===========================
* Date     $fecha_nacimiento   Fecha
* @return  Integer
************************************************************************/
//Funcion
function obtener_edad($fecha_nacimiento){

	/**********************/
	//Validaciones
	if(!validaFecha($fecha_nacimiento)){ return 'Las fechas ingresadas no tienen formato fecha';}

	/**********************/
	//Si todo esta ok
	$nacimiento = new DateTime($fecha_nacimiento);
    $ahora      = new DateTime(date("Y-m-d"));
    $diferencia = $ahora->diff($nacimiento);
    return $diferencia->format("%y").' años, '.$diferencia->format("%m").' meses';

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Muestra el numero de años entre fechas
*
*===========================     Detalles    ===========================
* Permite ver el el numero de años transcurridos entre la fecha entregada y
* la actual
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	obtener_numero_anos('2022-01-01'); //Devuelve '2' (a la fecha '2024-06-01')
*
*===========================    Parametros   ===========================
* Date     $fecha_nacimiento   Fecha
* @return  Integer
************************************************************************/
//Funcion
function obtener_numero_anos($fecha_nacimiento){

	/**********************/
	//Validaciones
	if(!validaFecha($fecha_nacimiento)){ return 'Las fechas ingresadas no tienen formato fecha';}

	/**********************/
	//Si todo esta ok
	$nacimiento = new DateTime($fecha_nacimiento);
    $ahora      = new DateTime(date("Y-m-d"));
    $diferencia = $ahora->diff($nacimiento);
    return $diferencia->format("%y");

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Ver dias transcurridos entre fechas
*
*===========================     Detalles    ===========================
* Permite ver el numero de los dias transcurridos entre dos fechas entregadas
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	dias_transcurridos('2019-01-02', '2019-02-02'); //Devuelve 31
*
*===========================    Parametros   ===========================
* Date     $fecha_i   Fecha de inicio
* Date     $fecha_f   Fecha de termino
* @return  Integer
************************************************************************/
//Funcion
function dias_transcurridos($fecha_i,$fecha_f){

	/**********************/
	//Validaciones
	if(!validaFecha($fecha_i)){ return 'Las fechas ingresadas no tienen formato fecha ('.$fecha_i.')';}
	if(!validaFecha($fecha_f)){ return 'Las fechas ingresadas no tienen formato fecha ('.$fecha_f.')';}

	/**********************/
	//Si todo esta ok
	return floor(abs((strtotime($fecha_i)-strtotime($fecha_f))/86400));

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Se calcula la diferencia de meses
*
*===========================     Detalles    ===========================
* Se calcula la diferencia de meses en base a dos fechas
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	horas_transcurridas('2019-01-02', '2019-02-02', '14:00:00', '07:00:00'); //Devuelve 737:00:00
*
*===========================    Parametros   ===========================
* Date     $diaInicio      Fecha de inicio
* Date     $diaTermino     Fecha de termino
* Time     $horaInicio     Hora de inicio
* Time     $horaTermino    Hora de termino
* @return  Time
************************************************************************/
//Funcion
function horas_transcurridas($diaInicio, $diaTermino, $horaInicio, $horaTermino){

	$n_dias     = dias_transcurridos($diaInicio,$diaTermino); //calculo diferencia de dias
	$HorasTrans = restahoras($horaInicio, $horaTermino);      //calculo del tiempo transcurrido
	//Sumo el tiempo por los dias transcurridos
	if($n_dias!=0){
		if($n_dias>=2){
			$n_dias_temp  = $n_dias-1;
			$horas_trans  = multHoras('24:00:00',$n_dias_temp);
			$HorasTrans   = sumahoras($HorasTrans,$horas_trans);
		}
		if($n_dias==1&&$horaInicio<$horaTermino){
			$horas_trans  = multHoras('24:00:00',$n_dias);
			$HorasTrans   = sumahoras($HorasTrans,$horas_trans);
		}
	}

	//devuelvo la cantidad de horas transcurridas
	return $HorasTrans;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Se calcula la diferencia de meses
*
*===========================     Detalles    ===========================
* Se calcula la diferencia de meses en base a dos fechas
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	diferencia_meses('2019-01-02', '2019-02-02'); //Devuelve 1
*
*===========================    Parametros   ===========================
* Date     $fechainicial   Fecha de inicio
* Date     $fechafinal     Fecha de termino
* @return  Integer
************************************************************************/
//Funcion
function diferencia_meses( $fechainicial, $fechafinal ) {

	/**********************/
	//Validaciones
	if(!validaFecha($fechainicial)){ return 'El dato ingresado no es una fecha ('.$fechainicial.')';}
	if(!validaFecha($fechafinal)){   return 'El dato ingresado no es una fecha ('.$fechafinal.')';}

	/**********************/
	//Si todo esta ok
	$datetime1 = new DateTime($fechainicial);
	$datetime2 = new DateTime($fechafinal);

	//operaciones
	$interval      = $datetime2->diff($datetime1); // obtenemos la diferencia entre las dos fechas
	$intervalMeses = $interval->format("%m");      // obtenemos la diferencia en meses
	$intervalAnos  = $interval->format("%y")*12;   // obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
	$meses         = $intervalMeses+$intervalAnos+1;

	return $meses;

}

?>
