<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1006-001).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                   Requires                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Common.Data.php';                //Funciones comunes de manejo de datos
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Common.Notifications.php';       //Funciones notificaciones por pantalla
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Convertions.php';                //Conversiones de datos
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Date.php';                  //Funciones relacionadas a las fechas
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Numbers.php';               //Funciones relacionadas a los numeros
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Operations.php';            //Funciones relacionadas a operaciones matematicas
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Text.php';                  //Funciones relacionadas a los textos
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Time.php';                  //Funciones relacionadas a las horas
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Validations.php';           //Funciones de validacion de datos
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.DataBase.php';                   //Funciones relacionadas a la base de datos
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Location.php';                   //Funciones relacionadas a la geolozalizacion
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Security.AntiSql_Injection.php'; //Funciones de seguridad para los sql injection
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Security.Codification.php';      //Funciones de seguridad para la codificacion y decodificacion de datos
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Security.Passwords.php';         //Funciones de seguridad para la generacion de password o palabras unicas
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Client.php';              //Funciones para entregar información del cliente
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Notifications.php';       //Funciones para el envio de notificaciones a traves de mail, mensajes pushup, etc
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Server.php';              //Funciones para entregar información del servidor
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Social.php';              //Funciones para el envio de mensajes a traves de redes sociales
require_once '../../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Web.php';                 //Funciones para entregar información de la web

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
//Funcion para guardar el log de errores
function EscribirLog($file, $data, $type){
    switch ($type) {
		case 1:  $tipo = 'r';  break;	//Apertura para sólo lectura; coloca el puntero al fichero al principio del fichero.
		case 2:  $tipo = 'r+'; break; 	//Apertura para lectura y escritura; coloca el puntero al fichero al principio del fichero.
		case 3:  $tipo = 'w';  break; 	//Apertura para sólo escritura; coloca el puntero al fichero al principio del fichero y trunca el fichero a longitud cero. Si el fichero no existe se intenta crear.
		case 4:  $tipo = 'w+'; break; 	//Apertura para lectura y escritura; coloca el puntero al fichero al principio del fichero y trunca el fichero a longitud cero. Si el fichero no existe se intenta crear.
		case 5:  $tipo = 'a';  break; 	//Apertura para sólo escritura; coloca el puntero del fichero al final del mismo. Si el fichero no existe, se intenta crear. En este modo, fseek() solamente afecta a la posición de lectura; las lecturas siempre son pospuestas.
		case 6:  $tipo = 'a+'; break; 	//Apertura para lectura y escritura; coloca el puntero del fichero al final del mismo. Si el fichero no existe, se intenta crear. En este modo, fseek() no tiene efecto, las escrituras siempre son pospuestas.
		case 7:  $tipo = 'x';  break; 	//Creación y apertura para sólo escritura; coloca el puntero del fichero al principio del mismo. Si el fichero ya existe, la llamada a fopen() fallará devolviendo false y generando un error de nivel E_WARNING. Si el fichero no existe se intenta crear. Esto es equivalente a especificar las banderas O_EXCL|O_CREAT para la llamada al sistema de open(2) subyacente.
		case 8:  $tipo = 'x+'; break; 	//Creación y apertura para lectura y escritura; de otro modo tiene el mismo comportamiento que 'x'.
		case 9:  $tipo = 'c';  break; 	//Abrir el fichero para sólo escritura. Si el fichero no existe, se crea. Si existe no es truncado (a diferencia de 'w'), ni la llamada a esta función falla (como en el caso con 'x'). El puntero al fichero se posiciona en el principio del fichero. Esto puede ser útil si se desea obtener un bloqueo asistido (véase flock()) antes de intentar modificar el fichero, ya que al usar 'w' se podría truncar el fichero antes de haber obtenido el bloqueo (si se desea truncar el fichero, se puede usar ftruncate() después de solicitar el bloqueo).
		case 10: $tipo = 'c+'; break; 	//Abrir el fichero para lectura y escritura; de otro modo tiene el mismo comportamiento que 'c'.
		case 11: $tipo = 'e';  break; 	//Establecer la bandera 'close-on-exec' en el descriptor de fichero abierto. Disponible solamente en PHP compilado en sistemas que se ajustan a POSIX.1-2008. 
	}
    //Se verifica si archivo existe
    if (file_exists($file)) {
        //se guarda en el archivo
		try {
			if ($FP = fopen ($file, $tipo)){
				fwrite ($FP, $data);
				fclose ($FP);
			}
		} catch (Exception $e) {
			error_log('No se ha podido abrir el archivo '.$file.', verifiqoe el siguiente error: '.$e->getMessage(), 0);
		}
    }else{
		//se crea archivo
		if ($FP = fopen ($file, $tipo)){
			fclose ($FP);
		}
		//se guarda log
		error_log('No existe el archivo '.$file, 0);
	}
}
/*******************************************************************************************************************/
//Funcion para saber si esta o no dentro de un area
function inLocationPoint($arrZonas, $pointLocation, $GeoLatitud, $GeoLongitud){
	//variable
	$nx = 0;
	//recorro las areas
	foreach ($arrZonas as $todaszonas=>$zonas) {
		//arreglo para el pligono
		$polygon = array();
		//variables para cerrar el poligono
		$ini     = 0;
		$f_lat   = 0;
		$f_long  = 0;
		//recorro las zonas
		foreach ($zonas as $puntos) {
			array_push( $polygon,$puntos['Latitud'].' '.$puntos['Longitud'] );
			//si es el primer dato
			if($ini==0){
				$f_lat  = $puntos['Latitud'];
				$f_long = $puntos['Longitud'];
			}
			$ini++;
		}
		//inserto el primer dato como el ultimo para cerrar poligono
		array_push( $polygon,$f_lat.' '.$f_long );
		//verifico
		$c_chek =  $pointLocation->pointInPolygon($GeoLatitud.' '.$GeoLongitud, $polygon);
		//si esta dentro de la zona
		if($c_chek=='inside'){
			if($nx==0){
				$nx = $todaszonas;
			}
		}
	}
	//devuelvo
	return $nx;
}
/*******************************************************************************************************************/
//Limpieza input
function LimpiarInput($Data){

	$Data = str_replace('%20', '', $Data);
	$Data = str_replace(' ', '', $Data);
	$Data = str_replace("'", '', $Data);
	$Data = str_replace('"', '', $Data);
	$Data = str_replace('[', '', $Data);
	$Data = str_replace(']', '', $Data);

	return $Data;

}





?>
