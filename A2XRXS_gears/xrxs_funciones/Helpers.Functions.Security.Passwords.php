<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-015).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Generar un password aleatorio
*
*===========================     Detalles    ===========================
* Permite generar un pasword aleatorio de dos tipos, numerico o alfanumerico,
* seleccionando el largo del password aleatorio
*===========================    Modo de uso  ===========================
* 	//Numerico:
* 	genera_password(10,'numerico'); //Devuelve valores numeros aleatoreos
*
* 	//Alfanumerico:
* 	genera_password(10,'alfanumerico'); //Devuelve valores alfanumerico aleatoreos
*
*===========================    Parametros   ===========================
* int        $longitud   Largo de la password generada
* String     $tipo       Tipo de password a generar
* @return    String
************************************************************************/
//Funcion
function genera_password($longitud,$tipo){
	//verifico si los datos estan bien entregados
	if (validarNumero($longitud)&&($tipo=="alfanumerico" OR $tipo=="numerico")){

		//selecciono el tipo de password
		if ($tipo=="alfanumerico"){
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		} elseif ($tipo=="numerico"){
			$alphabet = '1234567890';
		}

		//creo la password
		$password = substr(str_shuffle($alphabet), 0, $longitud);

		return $password;
	}else{
		return 'Datos requeridos mal ingresados';
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Generar un password unica
*
*===========================     Detalles    ===========================
* Se genera una password unica en base a la fecha y a la hora del servidor, de
* esta forma no hay probabilidades de que esta se repita, tener en cuenta su
* uso en caso de ser utilizada reiteradamente (2 veces en el mismo segundo)
*===========================    Modo de uso  ===========================
*
* 	//generar una password
* 	genera_password_unica(); //Devuelve 20241007152055 (para la fecha 2024/10/07 15:20:55)
*
*===========================    Parametros   ===========================
* @return    String
************************************************************************/
//Funcion
function genera_password_unica(){

    // Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
    //devuelvo valor
    return date("Ymd").date("His");

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera una palabra con caracteres random
*
*===========================     Detalles    ===========================
* Permite generar palabras con caracteres random, con varias opciones
* disponibles
*===========================    Modo de uso  ===========================
*
* 	//Caracteres Random
* 	caracteresRandom(16, true, false, false); //Devuelve valores aleatoreos
*
*===========================    Parametros   ===========================
* int        $longitud          Define el largo de la palabra generada
* boolean    $lecturaAmigable   Remueve los caracteres similares a otro,
*                               tales como O y 0, l y 1, etc(true - false)
* boolean    $incluirSimbolos   Permite incluir simbolos en la palabra
*                               generada, no debe estar activadasi lectura
*                               amigable esta activa(true - false)
* boolean    $sinDuplicados     Da la opción de que la palabra generada
*                               no contenga caracteres repetidos(true - false)
*
* @return    String
************************************************************************/
//Funcion
function caracteresRandom($longitud = 16, $lecturaAmigable = true, $incluirSimbolos = false, $sinDuplicados = false){

    $caracteres_legibles = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefhjkmnprstuvwxyz23456789';
    $caracteres_todos    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $simbolos            = '!@#$%^&*()~_-=+{}[]|:;<>,.?/"\'\\`';
    $cadena              = '';

    // Determine el conjunto de caracteres disponibles en función de los parámetros dados
    if ($lecturaAmigable) {
        $cola = $caracteres_legibles;
    } else {
        $cola = $caracteres_todos;
		//si se incluyen los simbolos
        if ($incluirSimbolos) {
            $cola .= $simbolos;
        }
    }

	//elimino los duplicados
    if (!$sinDuplicados) {
        return substr(str_shuffle(str_repeat($cola, $longitud)), 0, $longitud);
    }

    // No permita que se deshabiliten letras duplicadas si la longitud es mayor que los caracteres disponibles
    if ($sinDuplicados && strlen($cola) < $longitud) {
        //throw new \LengthException('$length exceeds the size of the pool and $sinDuplicados is enabled');
    }

    //Convierta el conjunto de caracteres en una matriz de caracteres y mezcle la matriz
    $cola       = str_split($cola);
    $largo_cola = count($cola);
    $rand       = mt_rand(0, $largo_cola - 1);

    //Generar nuestra cadena
    for ($i = 0; $i < $longitud; $i++) {
        $cadena .= $cola[$rand];

        // Elimine el carácter de la matriz para evitar duplicados.
        array_splice($cola, $rand, 1);

        // Generar un nuevo número
        if (($largo_cola - 2 - $i) > 0) {
            $rand = mt_rand(0, $largo_cola - 2 - $i);
        } else {
            $rand = 0;
        }
    }

    return $cadena;
}

?>
