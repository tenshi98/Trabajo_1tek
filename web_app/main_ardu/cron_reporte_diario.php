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
//Envia informes cada 1 dia
/**********************************************************************************************************************************/
/*                                       VARIABLES GLOBALES DE CONFIGURACION                                                      */
/**********************************************************************************************************************************/
//archivo de configuracion
include '1_global_config.php';

/***********************************************/
//Arreglos vacios
/*********************/
$MedicionesActuales_Correo    = array();
$MedicionesActuales_Whatsapp  = array();

/******************************************************/
//Se definen las variables de tiempo
$FechaSistema  = fecha_actual();
$HoraSistema   = hora_actual();

/***********************************************/
//Categorias de los correos
$Report_diario_NC   = $Global_reporte_diario_NC_MedicionesActuales;
$Report_diario_NW   = $Global_reporte_diario_NW_MedicionesActuales;
$TextFile_User      = $Global_reporte_diario_TextFile_User;
$N_Maximo_Sensores  = 40;

/**********************************************************************************************************************************/
/*                                                  Includes                                                                      */
/**********************************************************************************************************************************/
include 'cron_reporte_diario_consultas.php';      //Consulta a la BD
include 'cron_reporte_diario_armado.php';         //Se arman los datos de los equipos
include 'cron_reporte_diario_usuario.php';	      //Envio notificaciones a los usuarios
include 'cron_reporte_diario_test.php';	          //Envio testeos







?>
