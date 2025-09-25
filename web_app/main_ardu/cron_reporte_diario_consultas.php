<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                        CONSULTAS A LAS TABLAS PARA EL DESPLIEGUE DE ERRORES                        */
/*                                                                                                    */
/******************************************************************************************************/

/***********************************************************************/
// Se trae un listado con todos los equipos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.Nombre,
telemetria_listado.cantSensores,
core_sistemas.idSistema AS SistemaID,
core_sistemas.Nombre AS SistemaNombre';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
    $SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
    $SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
    $SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
    $SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
    $SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}
$SIS_join  = '
LEFT JOIN `core_sistemas`                              ON core_sistemas.idSistema                                 = telemetria_listado.idSistema
LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision_grupo` ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria!=0';   //que exista dato
$SIS_where.= ' AND telemetria_listado.idEstado = 1'; //Solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1';      //Solo sistemas activos
//Filtro de los tab
$SIS_where .= " AND telemetria_listado.idTab = 2";//1tek C
$SIS_where .= " AND telemetria_listado.Nombre LIKE 'Cloro%'";//Comienza por Cloro
$SIS_order = 'telemetria_listado.idSistema ASC, telemetria_listado.idTelemetria ASC';
$arrTelemetria = array();
$arrTelemetria = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrTelemetria');

/*************************************************************/
//Se consulta
$arrGrupos = array();
$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', 'idGrupo!=0', 'Nombre ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
//se recorre
$arrGruposTemp = array();
foreach ($arrGrupos as $gru) {
    $arrGruposTemp[$gru['idGrupo']] = $gru['Nombre'];
}

/*************************************************************/
//Se consulta
$arrGruposUso = array();
$arrGruposUso = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', 'idGrupo!=0', 'Nombre ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposUso');
//se recorre
$arrGruposUsoTemp = array();
foreach ($arrGruposUso as $gruUso) {
    $arrGruposUsoTemp[$gruUso['idGrupo']] = $gruUso['Nombre'];
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
usuarios_listado.Fono AS UsuarioFono,

core_sistemas.Nombre AS SistemaNombre,
core_sistemas.email_principal AS SistemaEmail,

core_sistemas.Config_WhatsappToken AS SistemaWhatsappToken,
core_sistemas.Config_WhatsappInstanceId AS SistemaWhatsappInstanceId';
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
$SIS_where.= ' AND (telemetria_mnt_correos_list.idCorreosCat = 63 OR telemetria_mnt_correos_list.idCorreosCat = 64)';
$SIS_where.= ' GROUP BY telemetria_mnt_correos_list.idUsuario,telemetria_listado.idSistema,usuarios_equipos_telemetria.idTelemetria,telemetria_mnt_correos_list.idCorreosCat';
$SIS_order = 'telemetria_mnt_correos_list.idUsuario ASC,telemetria_listado.idSistema ASC,usuarios_equipos_telemetria.idTelemetria ASC,telemetria_mnt_correos_list.idCorreosCat ASC';
$arrCorreos = array();
$arrCorreos = db_select_array (false, $SIS_query, 'telemetria_mnt_correos_list', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCorreos');

?>
