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
require_once '../../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.ardu.php';  //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/******************************************************************************************************/
/*                                                                                                    */
/*                        CONSULTAS A LAS TABLAS PARA EL DESPLIEGUE DE ERRORES                        */
/*                                                                                                    */
/******************************************************************************************************/
//archivo de configuracion
include '1_global_config.php';

/******************************************************/
//Se definen las variables de tiempo
$FechaSistema  = fecha_actual();
$HoraSistema   = hora_actual();

//Se calcula lapso de tiempo condicionando dias
$Hora_real   = restahoras($Global_inf_hora_timeBack,$HoraSistema);
$Fecha_real  = $FechaSistema;
if($HoraSistema<$Global_inf_hora_timeBack){
	$Fecha_real = restarDias($FechaSistema,1);
}

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
/***********************************************************************/
//Se buscan los correos de los usuarios que tengan permiso de visualizacion de los equipos
$SIS_query = '
usuarios_equipos_telemetria.idTelemetria,

telemetria_mnt_correos_list.idUsuario,
telemetria_listado.idSistema,
telemetria_mnt_correos_list.idCorreosCat,

usuarios_listado.email AS UsuarioEmail,
usuarios_listado.Nombre AS UsuarioNombre,
usuarios_listado.dispositivo AS UsuarioDispositivo,
usuarios_listado.GSM AS UsuarioGSM,
usuarios_listado.Fono AS UsuarioFono,

core_sistemas.Nombre AS SistemaNombre,
core_sistemas.email_principal AS SistemaEmail,
core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario,
core_sistemas.Config_Gmail_Password AS Gmail_Password,
core_sistemas.Config_FCM_Main_apiKey AS SistemaApiKey,
core_sistemas.Config_WhatsappToken AS SistemaWhatsappToken,
core_sistemas.Config_WhatsappInstanceId AS SistemaWhatsappInstanceId,
telemetria_mnt_correos_list.Chat_id AS SistemaWhatsappChat_id,

telemetria_mnt_correos_list.idUsuario AS ID1,
telemetria_listado.idSistema AS ID2,
(SELECT COUNT(idCorreos) FROM telemetria_mnt_correos_list_sended WHERE TimeStamp>"'.$FechaInicio_Critical.' '.$HoraInicio_Critical.'"  AND idUsuario = ID1 AND idSistema = ID2) AS Counter_Critical,
(SELECT COUNT(idCorreos) FROM telemetria_mnt_correos_list_sended WHERE TimeStamp>"'.$FechaInicio_Normal.' '.$HoraInicio_Normal.'"      AND idUsuario = ID1 AND idSistema = ID2) AS Counter_Normal';
$SIS_join  = '
INNER JOIN `usuarios_equipos_telemetria`   ON usuarios_equipos_telemetria.idUsuario   = telemetria_mnt_correos_list.idUsuario
INNER JOIN `usuarios_listado`              ON usuarios_listado.idUsuario              = telemetria_mnt_correos_list.idUsuario
INNER JOIN `telemetria_mnt_correos_cat`    ON telemetria_mnt_correos_cat.idCorreosCat = telemetria_mnt_correos_list.idCorreosCat
INNER JOIN `telemetria_listado`            ON telemetria_listado.idTelemetria         = usuarios_equipos_telemetria.idTelemetria
INNER JOIN `core_sistemas`                 ON core_sistemas.idSistema                 = telemetria_listado.idSistema ';
$SIS_where = '(telemetria_mnt_correos_list.TimeStamp<"'.$FechaSistema.' '.$HoraSistema.'" OR telemetria_mnt_correos_list.TimeStamp="0000-00-00 00:00:00")';
$SIS_where.= ' AND telemetria_mnt_correos_cat.idEstado=1 AND telemetria_mnt_correos_list.idSistema != "" ';
$SIS_where.= ' AND telemetria_listado.idEstado = 1'; //Solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1';      //Solo sistemas activos
$SIS_where.= ' AND usuarios_listado.idEstado = 1';   //Solo usuarios activos
$SIS_where.= ' GROUP BY telemetria_mnt_correos_list.idUsuario,telemetria_listado.idSistema,telemetria_mnt_correos_list.idCorreosCat,usuarios_equipos_telemetria.idTelemetria';
$SIS_order = 'telemetria_mnt_correos_list.idUsuario ASC,telemetria_listado.idSistema ASC,telemetria_mnt_correos_list.idCorreosCat ASC,usuarios_equipos_telemetria.idTelemetria ASC';
$arrCorreos = array();
$arrCorreos = db_select_array (true, $SIS_query, 'telemetria_mnt_correos_list', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCorreos');

?>
