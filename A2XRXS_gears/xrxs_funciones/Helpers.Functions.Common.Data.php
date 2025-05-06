<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-002).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Se encarga de generar un array multinivel
*
*===========================     Detalles    ===========================
* Al ingresar un Array, se selecciona una de las columnas, dicha columna generara un
* nuevo nivel dentro del arreglo, reordenando los datos
*===========================    Modo de uso  ===========================
*
* 	//se filtran los datos
* 	filtrar($arreglo, 'categoria' );
* 	//se recorre el nuevo arreglo
* 	foreach ($arreglo AS $categoria=>$arr1){
* 		//imprimimos la categoría
* 		echo $categoria;
* 		//se recorren los datos dentro de la categoria
* 		foreach ($arr1 AS $arr2){
* 			//imprimimos los datos dentro de la categoria
* 		}
* 	}
*
*===========================    Parametros   ===========================
* Array    $arreglo   Arreglo a reordenar
* String   categoria  Dato desde el cual se va a reordenar el arreglo
* @return  Array
************************************************************************/
//Funcion
function filtrar(&$array, $clave_orden ) {
	// inicializamos un nuevo array
	$array_filtrado = array();
	// creamos un bucle foreach para recorrer el array original y “acomodar” los datos
	foreach($array as $index=>$array_value) {
		// guardamos temporalmente el nombre de la categoría
		$value = $array_value[$clave_orden];
		// eliminamos la categoria del registro, ya no la necesitaremos
		unset($array_value[$clave_orden]);
		// creamos una clave en nuestro nuevo array, con el nombre de la categoria
		$array_filtrado[$value][] = $array_value;
	}
	// modificamos automáticamente nuestro array global $row
	$array = $array_filtrado;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtiene la extension de un archivo
*
*===========================     Detalles    ===========================
* Permite obtener la extension del archivo solicitado, hay que tener en
* cuenta el otorgar la ruta completa de acceso al archivo
*===========================    Modo de uso  ===========================
*
* 	//obtener extension
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $nombreArchivo     Nombre del archivo a revisar, incluyendo la ruta
*                             de acceso a este
* @return  String
************************************************************************/
//Funcion
function obtenerExtensionArchivo($nombreArchivo){
    return pathinfo($nombreArchivo, PATHINFO_EXTENSION);
}



?>
