<?php
/*******************************************************************************************************************/
/*                                                Se ejecuta codigo                                                */
/*******************************************************************************************************************/
/***********************************************************************/
//Calculo para notificaciones criticas
$FechaInicio_Critical    = $FechaSistema;
$HoraInicio_Critical     = restahoras($TimeAlertMail_Critical, $HoraSistema);
//en caso de que sean las 00:00 y se le reste la hora quedando 23:00, se resta un dia
if($HoraSistema<$HoraInicio_Critical){
	$FechaInicio_Critical = restarDias($FechaInicio_Critical,1);
}

/***********************************************************************/
//Calculo para notificaciones normales
$FechaInicio_Normal    = $FechaSistema;
$HoraInicio_Normal     = restahoras($TimeAlertMail_Normal, $HoraSistema);
//en caso de que sean las 00:00 y se le reste la hora quedando 23:00, se resta un dia
if($HoraSistema<$HoraInicio_Normal){
	$FechaInicio_Normal = restarDias($FechaInicio_Normal,1);
}

/***********************************************************************/
//Se buscan los correos de los usuarios que tengan permiso de visualizacion de este equipo
$SIS_query = '
telemetria_mnt_correos_list.idUsuario,
telemetria_listado.idSistema,
telemetria_mnt_correos_list.idCorreosCat,

usuarios_listado.email AS UsuarioEmail,
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
(SELECT COUNT(idCorreos) FROM telemetria_mnt_correos_list_sended WHERE TimeStamp > "'.$FechaInicio_Critical.' '.$HoraInicio_Critical.'" AND idUsuario = ID1 AND idSistema = '.$idSistema.' AND idTelemetria = '.$idTelemetria.' ) AS Counter_Critical,
(SELECT COUNT(idCorreos) FROM telemetria_mnt_correos_list_sended WHERE TimeStamp > "'.$FechaInicio_Normal.' '.$HoraInicio_Normal.'"     AND idUsuario = ID1 AND idSistema = '.$idSistema.' AND idTelemetria = '.$idTelemetria.' ) AS Counter_Normal';
$SIS_join  = '
INNER JOIN `usuarios_equipos_telemetria`  ON usuarios_equipos_telemetria.idUsuario     = telemetria_mnt_correos_list.idUsuario
INNER JOIN `usuarios_listado`             ON usuarios_listado.idUsuario                = telemetria_mnt_correos_list.idUsuario
LEFT JOIN `telemetria_listado`            ON telemetria_listado.idTelemetria           = usuarios_equipos_telemetria.idTelemetria
LEFT JOIN `core_sistemas`                 ON core_sistemas.idSistema                   = telemetria_listado.idSistema
LEFT JOIN `telemetria_mnt_correos_cat`    ON telemetria_mnt_correos_cat.idCorreosCat   = telemetria_mnt_correos_list.idCorreosCat';
$SIS_where = 'telemetria_mnt_correos_list.idSistema='.$idSistema;              //Sistema
$SIS_where.= ' AND usuarios_equipos_telemetria.idTelemetria='.$idTelemetria;   //Equipo de telemetria
$SIS_where.= ' AND telemetria_mnt_correos_cat.idEstado=1';                     //Solo equipos activos
$SIS_where.= ' AND (telemetria_mnt_correos_list.TimeStamp<"'.$FechaSistema.' '.$HoraSistema.'" OR telemetria_mnt_correos_list.TimeStamp="0000-00-00 00:00:00")';
$SIS_where.= ' GROUP BY telemetria_mnt_correos_list.idUsuario, telemetria_mnt_correos_list.idCorreosCat';
$SIS_order = 'telemetria_mnt_correos_list.idUsuario ASC';
$arrCorreos = array();
$arrCorreos = db_select_array (false, $SIS_query, 'telemetria_mnt_correos_list', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'ardu_include_notificaciones', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCorreos');

?>
