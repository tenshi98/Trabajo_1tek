<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                        CONSULTAS A LAS TABLAS PARA EL DESPLIEGUE DE ERRORES                        */
/*                                                                                                    */
/******************************************************************************************************/
/***********************************************************************/
// Se trae un listado con todas las alertas
$SIS_query = '
telemetria_listado_errores.idTelemetria,
telemetria_listado_errores.idTipo,
telemetria_listado_errores.Descripcion,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Hora,
telemetria_listado_errores.Valor,
telemetria_listado_errores.Valor_min,
telemetria_listado_errores.Valor_max,
telemetria_listado_errores.idPersonalizado,
telemetria_listado_errores.idTipoAlerta,
telemetria_listado.Nombre AS NombreEquipo,
core_sistemas.idSistema AS SistemaID,
core_sistemas.Nombre AS SistemaNombre';
$SIS_join  = '
LEFT JOIN `telemetria_listado`  ON telemetria_listado.idTelemetria  = telemetria_listado_errores.idTelemetria
LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema          = telemetria_listado_errores.idSistema';
$SIS_where = 'telemetria_listado_errores.`TimeStamp` >="'.$Fecha_real.' '.$Hora_real.'"';
$SIS_where.= ' AND telemetria_listado.idEstado = 1'; //Solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1';      //Solo sistemas activos
$SIS_order = 'telemetria_listado_errores.idSistema ASC, telemetria_listado_errores.idTelemetria ASC';
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrErrores');

/***********************************************************************/
// Se trae un listado con todas las alertas
$SIS_query = '
telemetria_listado_error_geocerca.idTelemetria,
telemetria_listado_error_geocerca.Descripcion,
telemetria_listado_error_geocerca.Fecha,
telemetria_listado_error_geocerca.Hora,
telemetria_listado.Nombre AS NombreEquipo,
core_sistemas.idSistema AS SistemaID,
core_sistemas.Nombre AS SistemaNombre';
$SIS_join  = '
LEFT JOIN `telemetria_listado`  ON telemetria_listado.idTelemetria  = telemetria_listado_error_geocerca.idTelemetria
LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema          = telemetria_listado_error_geocerca.idSistema';
$SIS_where = 'telemetria_listado_error_geocerca.`TimeStamp` >="'.$Fecha_real.' '.$Hora_real.'"';
$SIS_where.= ' AND telemetria_listado.idEstado = 1'; //Solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1';      //Solo sistemas activos
$SIS_order = 'telemetria_listado_error_geocerca.idSistema ASC, telemetria_listado_error_geocerca.idTelemetria ASC';
$arrFueraGeocerca = array();
$arrFueraGeocerca = db_select_array (false, $SIS_query, 'telemetria_listado_error_geocerca', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrFueraGeocerca');

/***********************************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_listado_error_fuera_linea.idTelemetria,
telemetria_listado_error_fuera_linea.Fecha_inicio,
telemetria_listado_error_fuera_linea.Fecha_termino,
telemetria_listado_error_fuera_linea.Hora_inicio,
telemetria_listado_error_fuera_linea.Hora_termino,
telemetria_listado_error_fuera_linea.Tiempo,
telemetria_listado.Nombre AS NombreEquipo,
core_sistemas.idSistema AS SistemaID,
core_sistemas.Nombre AS SistemaNombre';
$SIS_join  = '
LEFT JOIN `telemetria_listado`  ON telemetria_listado.idTelemetria  = telemetria_listado_error_fuera_linea.idTelemetria
LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema          = telemetria_listado.idSistema';
$SIS_where = 'telemetria_listado_error_fuera_linea.`TimeStamp` >="'.$Fecha_real.' '.$Hora_real.'"';
$SIS_where.= ' AND telemetria_listado.idEstado = 1'; //Solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1';      //Solo sistemas activos
$SIS_order = 'telemetria_listado.idSistema ASC, telemetria_listado_error_fuera_linea.idTelemetria ASC';
$arrFueraLinea = array();
$arrFueraLinea = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

/***********************************************************************/
// Se trae un listado con todos los equipos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.Nombre,
core_sistemas.idSistema AS SistemaID,
core_sistemas.Nombre AS SistemaNombre';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = telemetria_listado.idSistema';
$SIS_where = 'telemetria_listado.idTelemetria!=0';   //que exista dato
$SIS_where.= ' AND telemetria_listado.idEstado = 1'; //Solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1';      //Solo sistemas activos
$SIS_order = 'telemetria_listado.idSistema ASC, telemetria_listado.idTelemetria ASC';
$arrTelemetria = array();
$arrTelemetria = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrTelemetria');

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
(SELECT COUNT(idCorreos) FROM telemetria_mnt_correos_list_sended WHERE TimeStamp>"'.$FechaInicio_Critical.' '.$HoraInicio_Critical.'"  AND idUsuario = ID1 AND idSistema = ID2 AND idTelemetria = 0) AS Counter_Critical,
(SELECT COUNT(idCorreos) FROM telemetria_mnt_correos_list_sended WHERE TimeStamp>"'.$FechaInicio_Normal.' '.$HoraInicio_Normal.'"      AND idUsuario = ID1 AND idSistema = ID2 AND idTelemetria = 0) AS Counter_Normal';
$SIS_join  = '
INNER JOIN `usuarios_equipos_telemetria`   ON usuarios_equipos_telemetria.idUsuario   = telemetria_mnt_correos_list.idUsuario
INNER JOIN `usuarios_listado`              ON usuarios_listado.idUsuario              = telemetria_mnt_correos_list.idUsuario
INNER JOIN `telemetria_mnt_correos_cat`    ON telemetria_mnt_correos_cat.idCorreosCat = telemetria_mnt_correos_list.idCorreosCat
INNER JOIN `telemetria_listado`            ON telemetria_listado.idTelemetria         = usuarios_equipos_telemetria.idTelemetria
INNER JOIN `core_sistemas`                 ON core_sistemas.idSistema                 = telemetria_listado.idSistema ';
$SIS_where = '(telemetria_mnt_correos_list.TimeStamp<"'.$FechaSistema.' '.$HoraSistema.'" OR telemetria_mnt_correos_list.TimeStamp="0000-00-00 00:00:00")';
$SIS_where.= ' AND telemetria_mnt_correos_cat.idEstado=1';           //Categoria activa
$SIS_where.= ' AND telemetria_mnt_correos_list.idSistema != "" ';    //pertenezca a algun sistema
$SIS_where.= ' AND telemetria_listado.idEstado = 1';                 //Solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1';                      //Solo sistemas activos
$SIS_where.= ' AND usuarios_listado.idEstado = 1';                   //Solo usuarios activos
$SIS_where.= ' AND telemetria_mnt_correos_list.idCorreosCat != 62';  //Se deja fuera Crones - Prevision temperatura
$SIS_where.= ' GROUP BY telemetria_mnt_correos_list.idUsuario,telemetria_listado.idSistema,usuarios_equipos_telemetria.idTelemetria,telemetria_mnt_correos_list.idCorreosCat';
$SIS_order = 'telemetria_mnt_correos_list.idUsuario ASC,telemetria_listado.idSistema ASC,usuarios_equipos_telemetria.idTelemetria ASC,telemetria_mnt_correos_list.idCorreosCat ASC';
$arrCorreos = array();
$arrCorreos = db_select_array (false, $SIS_query, 'telemetria_mnt_correos_list', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCorreos');

?>
