<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                   //Configuracion de la plataforma
require_once '../../Legacy/1tek_public/funciones/Helpers.Functions.Propias.ardu.php';  //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                               FUNCION DEL CRON                                                                 */
/**********************************************************************************************************************************/
//elimina las microparadas
/**********************************************************************************************************************************/
/*                                       VARIABLES GLOBALES DE CONFIGURACION                                                      */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
set_time_limit(2400);
//Memora RAM Maxima del servidor, 4GB por defecto
ini_set('memory_limit', '6096M');
/**********************************************************************************************************************************/
/*                                       VARIABLES GLOBALES DE CONFIGURACION                                                      */
/**********************************************************************************************************************************/
$fecha_real        = fecha_actual();
$fecha_siguiente   = sumarDias(fecha_actual(), 1);
/**********************************************************************************************************************************/
/*                                                  Includes                                                                      */
/**********************************************************************************************************************************/
include 'cron_eliminacion_microparadas_1_include_cierre_gruas.php'; //
include 'cron_eliminacion_microparadas_1_include_vuelta_1.php';     //
include 'cron_eliminacion_microparadas_1_include_vuelta_2.php';     //
include 'cron_eliminacion_microparadas_1_include_vuelta_3.php';     //
/**********************************************************************************************************************************/
/*                                                     LOG                                                                        */
/**********************************************************************************************************************************/
//LOG DE EJECUCION
$TextFile = "logs_cron_eliminacion_microparadas_1_save.txt";
$dir  = "\n";
$dir .= "################################################################################\n";
$dir .= "Fecha del Log : ".fecha_actual()."\n";
$dir .= "Hora del Log : ".hora_actual()."\n";
$dir .= "Ejecucion Correcta";
if ($FP = fopen ($TextFile, "a")){
	fwrite ($FP, $dir);
	fclose ($FP);
}



?>
