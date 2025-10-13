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
//Envia informes cada 7 dias
/**********************************************************************************************************************************/
/*                                       VARIABLES GLOBALES DE CONFIGURACION                                                      */
/**********************************************************************************************************************************/
//archivo de configuracion
include '1_global_config.php';

//Titulos de las notificaciones
$Tittle_Mail      = 'Resumen Estado Equipos';
$Tittle_Body_Mail = 'Alertas Informe Semanal';
$Tittle_App       = 'Alerta Telemetria';
$Tittle_Whatsapp  = 'Alerta Telemetria';
$Message_App      = 'Se notifica que algunos equipos presentan alertas';
$Message_Whatsapp = 'Se notifica que algunos equipos presentan alertas<br/>';

/***********************************************/
//Arreglos vacios
/*********************/
$AlertasNormales                 = array();
$AlertasCatastroficas            = array();
$AlertasVelocidad                = array();
$FueraGeocerca                   = array();
$FueraLinea                      = array();
$FueraLineaActual                = array();
/*********************/
$AlertasNormales_Whatsapp        = array();
$AlertasCatastroficas_Whatsapp   = array();
$AlertasVelocidad_Whatsapp       = array();
$FueraGeocerca_Whatsapp          = array();
$FueraLinea_Whatsapp             = array();
$FueraLineaActual_Whatsapp       = array();

/***********************************************/
//Categorias de los correos
$SubAlert_NC_AlertasCatastrofica     = $Global_inf_semanal_SA_NC_AlertasCatastrofica;     //Alertas Catastroficas
$SubAlert_NC_AlertasNormales         = $Global_inf_semanal_SA_NC_AlertasNormales;         //Alertas Normales
$SubAlert_NC_ExcesoVelocidad         = $Global_inf_semanal_SA_NC_ExcesoVelocidad;         //Exceso Limite Velocidad
$SubAlert_NC_FueraGeocerca           = $Global_inf_semanal_SA_NC_FueraGeocerca;           //Equipo Fuera de Geocerca
$SubAlert_NC_FueraLinea              = $Global_inf_semanal_SA_NC_FueraLinea;              //Fuera de Linea
$SubAlert_NC_FueraLineaActual        = $Global_inf_semanal_SA_NC_FueraLineaActual;        //Fuera de Linea Actual
$SubAlert_NW_AlertasCatastrofica     = $Global_inf_semanal_SA_NW_AlertasCatastrofica;     //Alertas Catastroficas
$SubAlert_NW_AlertasNormales         = $Global_inf_semanal_SA_NW_AlertasPersonalizadas;   //Alertas Normales
$SubAlert_NW_ExcesoVelocidad         = $Global_inf_semanal_SA_NW_ExcesoVelocidad;         //Exceso Limite Velocidad
$SubAlert_NW_FueraGeocerca           = $Global_inf_semanal_SA_NW_FueraGeocerca;           //Equipo Fuera de Geocerca
$SubAlert_NW_FueraLinea              = $Global_inf_semanal_SA_NW_FueraLinea;              //Fuera de Linea
$SubAlert_NW_FueraLineaActual        = $Global_inf_semanal_SA_NW_FueraLineaActual;        //Fuera de Linea Actual
$TextFile_User                       = $Global_inf_semanal_TextFile_User;                 //Archivo a escribir

/******************************************************/
//Se definen las variables de tiempo
$FechaSistema  = fecha_actual();
$HoraSistema   = hora_actual();

//Se calcula lapso de tiempo condicionando dias
$Hora_real   = $HoraSistema;
$Fecha_real  = restarDias($FechaSistema,$Global_inf_semanal_dias);

//Calculo para notificaciones criticas
$FechaInicio_Critical    = $FechaSistema;
$HoraInicio_Critical     = restahoras($TimeAlertMail_Critical, $HoraSistema);
//en caso de que sean las 00:00 y se le reste la hora quedando 23:00, se resta un dia
if($HoraSistema<$HoraInicio_Critical){
	$FechaInicio_Critical = restarDias($FechaInicio_Critical,1);
}

//Calculo para notificaciones normales
$FechaInicio_Normal    = $FechaSistema;
$HoraInicio_Normal     = restahoras($TimeAlertMail_Normal, $HoraSistema);
//en caso de que sean las 00:00 y se le reste la hora quedando 23:00, se resta un dia
if($HoraSistema<$HoraInicio_Normal){
	$FechaInicio_Normal = restarDias($FechaInicio_Normal,1);
}

/**********************************************************************************************************************************/
/*                                                  Includes                                                                      */
/**********************************************************************************************************************************/
include 'cron_inf_include_correcciones.php';   //correcciones en las mediciones
include 'cron_inf_include_consultas.php';      //Consulta a la BD
include 'cron_inf_include_armado.php';         //Se arman los datos de los equipos
include 'cron_inf_include_usuario.php';	       //Envio notificaciones a los usuarios



?>
