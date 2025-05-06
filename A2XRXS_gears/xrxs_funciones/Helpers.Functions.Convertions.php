<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-004).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                              Funciones  Horas                                                   */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma numeros (decimales) a horas
*
*===========================     Detalles    ===========================
* Permite ingresar un numero (decimales, representando las horas) y
* transformarlo en formato hora
*===========================    Modo de uso  ===========================
*
* 	//transformar minutos
* 	numero2horas(1.5); //Devuelve 01:30:00
*
*===========================    Parametros   ===========================
* int        $mins   Numero de minutos a transformar
* @return    Time
************************************************************************/
//Funcion
function numero2horas($mins) {

	/**********************/
	//Validaciones
	if (!validarNumero($mins)){ return 'El dato ingresado no es un numero';}

	/**********************/
	//Si todo esta ok
	$h = intval($mins);
	$m = round((((($mins - $h) / 100.0) * 60.0) * 100), 0);
	if ($m == 60){$h++;$m = 0;}
	$retval = sprintf("%02d:%02d:%02d", $h, $m, '00');
	return $retval;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma minutos a horas
*
*===========================     Detalles    ===========================
* Permite ingresar un numero entero (minutos) y transformarlo en formato hora
*===========================    Modo de uso  ===========================
*
* 	//transformar minutos
* 	minutos2horas(65); //Devuelve 01:05:00
*
*===========================    Parametros   ===========================
* int        $mins   Numero de minutos a transformar
* @return    Time
************************************************************************/
//Funcion
function minutos2horas($mins) {

	/**********************/
	//Validaciones
	if (!validarNumero($mins)){return 'El dato ingresado no es un numero';}
	//if(!validaEntero($mins)){return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	$extraIntH   = intval($mins/60);
	$extraIntHs  = ($mins/60);
	$whole       = floor($extraIntHs);
	$fraction    = $extraIntHs - $whole;
	$extraIntHss =  round($fraction*60);
	//tratamiento de los datos
	if (strlen($extraIntHss) < 2){ $extraIntHss = '0'.$extraIntHss;} //Se agrega el 0
	if (strlen($extraIntH) < 2){   $extraIntH   = '0'.$extraIntH;}   //Se agrega el 0
	return $extraIntH.':'.$extraIntHss.':00';

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma segundos a horas
*
*===========================     Detalles    ===========================
* Permite ingresar un numero entero (segundos) y transformarlo en formato hora
*===========================    Modo de uso  ===========================
*
* 	//transformar segundos
* 	segundos2horas(3600); //Devuelve 01:00:00
*
*===========================    Parametros   ===========================
* int        $segundos   Numero de segundos a transformar
* @return    Time
************************************************************************/
//Funcion
function segundos2horas($segundos) {

	/**********************/
	//Validaciones
	if (!validarNumero($segundos)){return 'El dato ingresado no es un numero';}

	/**********************/
	//Si todo esta ok
	$tiempo = round($segundos);
	return sprintf('%02d:%02d:%02d', ($tiempo/3600),($tiempo/60%60), $tiempo%60);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma horas a minutos
*
*===========================     Detalles    ===========================
* Transforma las horas a minutos, esta debe ser ingresada en formato texto
* para que la funcion la reconozca correctamente
*===========================    Modo de uso  ===========================
*
* 	//transformar hora
* 	horas2minutos('01:05:00'); //Devuelve 65
*
*===========================    Parametros   ===========================
* Time       $horas   La hora en formato texto
* @return    Integer
************************************************************************/
//Funcion
function horas2minutos($horas) {

	/**********************/
	//Validaciones
	if(!validaHora($horas)){return 'El dato ingresado no es una hora ('.$horas.')';}

	/**********************/
	//Si todo esta ok
	$t = EXPLODE(":", $horas);
	$h = $t[0];
	if (isset($t[1])) {
		$m = $t[1];
	} else {
		$m = "00";
	}
	return ($h * 60)+$m;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma a segundos una hora
*
*===========================     Detalles    ===========================
* Transforma las horas a segundos, esta debe ser ingresada en formato texto
* para que la funcion la reconozca correctamente
*===========================    Modo de uso  ===========================
*
* 	//se transforma la hora
* 	horas2segundos('00:30:00'); //Devuelve 1800
*
*===========================    Parametros   ===========================
* Time     $horas   La hora en formato texto
* @return  Integer
************************************************************************/
//Funcion
function horas2segundos($horas){

	/**********************/
	//Validaciones
	if(!validaHora($horas)){return 'El dato ingresado no es una hora ('.$horas.')';}

	/**********************/
	//Si todo esta ok
	$timeExploded = explode(':', $horas);
	if (isset($timeExploded[2])) {
		return $timeExploded[0] * 3600 + $timeExploded[1] * 60 + $timeExploded[2];
	}
	return $timeExploded[0] * 3600 + $timeExploded[1] * 60;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma a numero decimal una hora
*
*===========================     Detalles    ===========================
* Transforma las horas ingresadas a numeros con decimales
*
*===========================    Modo de uso  ===========================
*
* 	//se transforma la hora
* 	horas2decimales('01:30:00'); //Devuelve 1.5
*
*===========================    Parametros   ===========================
* Time     $horas   La hora en formato texto
* @return  Decimal
************************************************************************/
//Funcion
function horas2decimales($horas){

	/**********************/
	//Validaciones
	if(!validaHora($horas)){return 'El dato ingresado no es una hora ('.$horas.')';}

	/**********************/
	//Si todo esta ok
	$hms = explode(":", $horas);
	return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));

}




/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                              Funciones  Fechas                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Convetir mes abreviado a mes completo
*
*===========================     Detalles    ===========================
* Transforma al mes completo a partir de sus primeras 3 letras
*===========================    Modo de uso  ===========================
*
* 	//se convierten los datos
* 	Devolver_mes('Ene'); //Devuelve Enero
*
*===========================    Parametros   ===========================
* String    $mes    Mes con 3 letras
* @return   String
************************************************************************/
//Funcion
function Devolver_mes($mes){
	//Paso a minusculas los datos recibidos
	$mes = strtolower($mes);
	//se definen las opciones disponibles
	$meses = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'  );
	//verifico si el dato ingresado existe dentro de las opciones
	if (in_array($mes, $meses)) {
		//busco el dato dentro de las opciones
		switch ($mes) {
			case 'ene':  $meslargo = 'Enero'; break;
			case 'feb':  $meslargo = 'Febrero'; break;
			case 'mar':  $meslargo = 'Marzo'; break;
			case 'abr':  $meslargo = 'Abril'; break;
			case 'may':  $meslargo = 'Mayo'; break;
			case 'jun':  $meslargo = 'Junio'; break;
			case 'jul':  $meslargo = 'Julio'; break;
			case 'ago':  $meslargo = 'Agosto'; break;
			case 'sep':  $meslargo = 'Septiembre'; break;
			case 'oct':  $meslargo = 'Octubre'; break;
			case 'nov':  $meslargo = 'Noviembre'; break;
			case 'dic':  $meslargo = 'Diciembre'; break;
		};
		//devuelvo el resultado
		return $meslargo;
	}else{
		return 'Dato fuera de parametros esperados';
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma numero a texto (numero)
*
*===========================     Detalles    ===========================
* Permite transformar el numero del mes a un texto, el cual antepone
* un 0 en el caso de que el valor ingresado sea inferior a 10, los
* valores a ingresar deben de estar entre el 1 y el 12
*===========================    Modo de uso  ===========================
*
* 	//se convierten los datos
* 	numero_mes(1); //Devuelve 01
*
*===========================    Parametros   ===========================
* int        $numero   Numero a transformar (de 1 a 12)
* @return    String
************************************************************************/
//Funcion
function numero_mes($numero){

	/**********************/
	//Validaciones
	if (!validarNumero($numero)){ return 'El dato ingresado no es un numero';}
	if($numero<0 OR $numero>13){  return 'Numero fuera de parametros esperados';}

	/**********************/
	//Si todo esta ok
	$options = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
	return $options[$numero-1];

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma numero a texto (numero)
*
*===========================     Detalles    ===========================
* Permite transformar el numero del dia a un texto, el cual antepone
* un 0 en el caso de que el valor ingresado sea inferior a 10, los
* valores a ingresar deben de estar entre el 1 y el 31
*===========================    Modo de uso  ===========================
*
* 	//se convierten los datos
* 	numero_dia(1); //Devuelve 01
*
*===========================    Parametros   ===========================
* int        $numero   Numero a transformar (de 1 a 31)
* @return    String
************************************************************************/
//Funcion
function numero_dia($numero){

	/**********************/
	//Validaciones
	if (!validarNumero($numero)){ return 'El dato ingresado no es un numero';}
	if($numero<0 OR $numero>32){  return 'Numero fuera de parametros esperados';}

	/**********************/
	//Si todo esta ok
	//si es inferior a 10 se le antepone un 0
	if($numero<10){
		$nmes = '0'.$numero;
	//si no se devuelve igual
	}else{
		$nmes = $numero;
	}
	return $nmes;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma numero a mes
*
*===========================     Detalles    ===========================
* Permite transformar el numero del mes al nombre del mes que corresponde,
* los valores a ingresar deben de estar entre el 1 y el 12
*===========================    Modo de uso  ===========================
*
* 	//se convierten los datos
* 	numero_a_mes(1); //Devuelve Enero
*
*===========================    Parametros   ===========================
* int        $numero   Numero a transformar (de 1 a 12)
* @return    String
************************************************************************/
//Funcion
function numero_a_mes($numero){

	/**********************/
	//Validaciones
	if (!validarNumero($numero)){ return 'El dato ingresado no es un numero';}
	if($numero<0 OR $numero>13){  return 'Numero fuera de parametros esperados';}

	/**********************/
	//Si todo esta ok
	$options = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	return $options[$numero-1];

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma un numero a mes (solo las primeras 3 letras)
*
*===========================     Detalles    ===========================
* Permite transformar el numero del mes al nombre del mes que corresponde
* (solo las primeras 3 letras), los valores a ingresar deben de estar
* entre el 1 y el 12
*===========================    Modo de uso  ===========================
*
* 	//se convierten los datos
* 	numero_a_mes_corto(1); //Devuelve Ene
*
*===========================    Parametros   ===========================
* int        $numero   Numero a transformar (de 1 a 12)
* @return    String
************************************************************************/
//Funcion
function numero_a_mes_corto($numero){

	/**********************/
	//Validaciones
	if (!validarNumero($numero)){ return 'El dato ingresado no es un numero';}
	if($numero<0 OR $numero>13){  return 'Numero fuera de parametros esperados';}

	/**********************/
	//Si todo esta ok
	$options = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
	return $options[$numero-1];

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve el nombre del dia
*
*===========================     Detalles    ===========================
* Devuelve el nombre del dia en base a un numero (1-7 : lunes a domingo)
*===========================    Modo de uso  ===========================
*
* 	//se convierten los datos
* 	numero_nombreDia(3); //Devuelve Miercoles
*
*===========================    Parametros   ===========================
* int       $numero   Numero a transformar (de 1 a 7)
* @return   String
************************************************************************/
//Funcion
function numero_nombreDia($numero){

	/**********************/
	//Validaciones
	if (!validarNumero($numero)){ return 'El dato ingresado no es un numero';}
	if($numero<0 OR $numero>8){  return 'Numero fuera de parametros esperados';}

	/**********************/
	//Si todo esta ok
	$options = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
	return $options[$numero-1];

}







/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                              Funciones  Valores                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma valores a porcentaje
*
*===========================     Detalles    ===========================
* Permite transformar cualquier valor decimal ingresado en formato porcentaje
*===========================    Modo de uso  ===========================
*
* 	//se transforman los valores
* 	porcentaje(0.65); //Devuelve 65%
*
*===========================    Parametros   ===========================
* Decimal    $valor   Decimal a transformar
* @return    String
************************************************************************/
//Funcion
function porcentaje($valor){

	/**********************/
	//Validaciones
	if (!validarNumero($valor)){return 'El dato ingresado no es un numero';}

	/**********************/
	//Si todo esta ok
	$porcentaje = $valor *100;
	return number_format($porcentaje,0,',','.').' %';

}



/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                              Funciones  Textos                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve el monto ingresado en palabras
*
*===========================     Detalles    ===========================
* Transforma los numeros ingresados a su equivalente en palabras
*===========================    Modo de uso  ===========================
*
* 	//se transforma los datos
* 	numtoletras(1200); //Devuelve mil doscientos
*
*===========================    Parametros   ===========================
* int      $monto   Valor a transformar en palabras
* @return  String
************************************************************************/
//Funcion
function numtoletras($monto){

	/**********************/
	//Validaciones
	if (!validarNumero($monto)){return 'El dato ingresado no es un numero';}

	/**********************/
	//Si todo esta ok
	$xarray = array(
					0 => "Cero",
					1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE","DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE", "VEINTI",
					30 => "TREINTA",
					40 => "CUARENTA",
					50 => "CINCUENTA",
					60 => "SESENTA",
					70 => "SETENTA",
					80 => "OCHENTA",
					90 => "NOVENTA",
			        100 => "CIENTO",
					200 => "DOSCIENTOS",
					300 => "TRESCIENTOS",
					400 => "CUATROCIENTOS",
					500 => "QUINIENTOS",
					600 => "SEISCIENTOS",
					700 => "SETECIENTOS",
					800 => "OCHOCIENTOS",
					900 => "NOVECIENTOS"
		);

		$monto      = trim($monto);
		$xlength    = strlen($monto);
		$xpos_punto = strpos($monto, ".");
		$xaux_int   = $monto;
		$xdecimales = "00";
		if (!($xpos_punto === false)) {
			if ($xpos_punto == 0) {
				$monto      = "0" . $monto;
				$xpos_punto = strpos($monto, ".");
			}
			$xaux_int   = substr($monto, 0, $xpos_punto);            // obtengo el entero de la cifra a covertir
			$xdecimales = substr($monto . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
		}

		$XAUX    = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
		$xcadena = "";
		for ($xz = 0; $xz < 3; $xz++) {
			$xaux = substr($XAUX, $xz * 6, 6);
			$xi = 0;
			$xlimite = 6;  // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
			$xexit = true; // bandera para controlar el ciclo del While
			while ($xexit) {
				if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
					break; // termina el ciclo
				}

				$x3digitos = ($xlimite - $xi) * -1;                       // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
				$xaux      = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
				for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
					switch ($xy) {
						case 1: // checa las centenas
							if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

							} else {
								$key = (int) substr($xaux, 0, 3);
								if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
									$xseek = $xarray[$key];
									$xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
									if (substr($xaux, 0, 3) == 100)
										$xcadena = " " . $xcadena . " CIEN " . $xsub;
									else
										$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
									$xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
								}
								else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
									$key = (int) substr($xaux, 0, 1) * 100;
									$xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
									$xcadena = " " . $xcadena . " " . $xseek;
								}// ENDIF ($xseek)
							} // ENDIF (substr($xaux, 0, 3) < 100)
							break;
						case 2: // checa las decenas (con la misma lógica que las centenas)
							if (substr($xaux, 1, 2) < 10) {

							} else {
								$key = (int) substr($xaux, 1, 2);
								if (TRUE === array_key_exists($key, $xarray)) {
									$xseek = $xarray[$key];
									$xsub = subfijo($xaux);
									if (substr($xaux, 1, 2) == 20)
										$xcadena = " " . $xcadena . " VEINTE " . $xsub;
									else
										$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
									$xy = 3;
								}
								else {
									$key = (int) substr($xaux, 1, 1) * 10;
									$xseek = $xarray[$key];
									if (20 == substr($xaux, 1, 1) * 10)
										$xcadena = " " . $xcadena . " " . $xseek;
									else
										$xcadena = " " . $xcadena . " " . $xseek . " Y ";
								}// ENDIF ($xseek)
							} // ENDIF (substr($xaux, 1, 2) < 10)
							break;
						case 3: // checa las unidades
							if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

							} else {
								$key = (int) substr($xaux, 2, 1);
								$xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
								$xsub = subfijo($xaux);
								$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
							} // ENDIF (substr($xaux, 2, 1) < 1)
							break;
					} // END SWITCH
				} // END FOR
				$xi = $xi + 3;
			} // ENDDO

			if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
				$xcadena.= " DE";

			if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
				$xcadena.= " DE";

			// ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
			if (trim($xaux) != "") {
				switch ($xz) {
					case 0:
						if (trim(substr($XAUX, $xz * 6, 6)) == "1")
							$xcadena.= "UN BILLON ";
						else
							$xcadena.= " BILLONES ";
						break;
					case 1:
						if (trim(substr($XAUX, $xz * 6, 6)) == "1")
							$xcadena.= "UN MILLON ";
						else
							$xcadena.= " MILLONES ";
						break;
					case 2:
						if ($monto < 1) {
							$xcadena = "CERO PESOS ";
						}
						if ($monto >= 1 && $monto < 2) {
							$xcadena = "UN PESO  ";
						}
						if ($monto >= 2) {
							$xcadena.= " PESOS  "; //
						}
						break;
				} // endswitch ($xz)
			} // ENDIF (trim($xaux) != "")
			// ------------------      en este caso, para México se usa esta leyenda     ----------------
			$xcadena = str_replace("VEINTI ", "VEINTI", $xcadena);                   // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
			$xcadena = str_replace("  ", " ", $xcadena);                             // quito espacios dobles
			$xcadena = str_replace("UN UN", "UN", $xcadena);                         // quito la duplicidad
			$xcadena = str_replace("  ", " ", $xcadena);                             // quito espacios dobles
			$xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena);     // corrigo la leyenda
			$xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
			$xcadena = str_replace("DE UN", "UN", $xcadena);                         // corrigo la leyenda
		} // ENDFOR ($xz)
		return trim($xcadena);

}
//Sufijo del valor
function subfijo($xx){ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}





/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                              Funciones  Objetos                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Transforma un arreglo a un texto
*
*===========================     Detalles    ===========================
* Transforma un arreglo a un texto
*===========================    Modo de uso  ===========================
*
* 	//se transforman los datos
* 	$string = arrayToString($array);
*
*===========================    Parametros   ===========================
* Array     $array   Arreglo a Transformar
* @return   String
************************************************************************/
//Funcion
function arrayToString(array $array = [], $delimiter = ' '){
    $pairs = [];
    foreach ($array as $key => $value) {
        $pairs[] = "$key=\"$value\"";
    }
    return implode($delimiter, $pairs);
}






?>
