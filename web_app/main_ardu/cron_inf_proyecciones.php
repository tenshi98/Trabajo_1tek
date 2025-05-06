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
/**********************************************************************************************************************************/
/*                                               FUNCION DEL CRON                                                                 */
/**********************************************************************************************************************************/
//Envia informes cada 1 hora
/**********************************************************************************************************************************/
/*                                       VARIABLES GLOBALES DE CONFIGURACION                                                      */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
set_time_limit(2400);
//Memora RAM Maxima del servidor, 4GB por defecto
ini_set('memory_limit', '4096M');

//Libreria
require_once '../../LIBS_php/PHP_ML/vendor/autoload.php';

/***********************************************************************/
//Variables
$FechaSistema   = fecha_actual();
$HoraSistema    = hora_actual();
$HoraProyectada = sumahoras($HoraSistema, '01:00:00');

/***********************************************************************/
//Areglo con los equipos y el numero de predicciones
$arrPrevs = array(
    array(
        "EquipoID"     => 252,
        "NPrediccion"  => 40,
        "RangoInicio"  => 18,
        "RangoTermino" => 22,
        "Sensores"     => array(1, 4, 7, 13, 16, 19, 22, 25, 28, 31, 34),
    ),
);

/***********************************************************************/
//Se buscan los correos de los usuarios que tengan permiso de visualizacion de los equipos
$SIS_query = '
telemetria_mnt_correos_list.idUsuario,
telemetria_listado.idSistema,
telemetria_listado.Nombre AS EquipoNombre,
telemetria_mnt_correos_list.idCorreosCat,
usuarios_equipos_telemetria.idTelemetria,

usuarios_listado.email AS UsuarioEmail,
usuarios_listado.Nombre AS UsuarioNombre,
usuarios_listado.Fono AS UsuarioFono,

core_sistemas.Nombre AS SistemaNombre,
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
$SIS_where.= ' AND telemetria_mnt_correos_list.idCorreosCat = 62';   //Crones - Prevision temperatura
$SIS_where.= ' GROUP BY telemetria_mnt_correos_list.idUsuario,telemetria_listado.idSistema,usuarios_equipos_telemetria.idTelemetria,telemetria_mnt_correos_list.idCorreosCat';
$SIS_order = 'telemetria_mnt_correos_list.idUsuario ASC,telemetria_listado.idSistema ASC,usuarios_equipos_telemetria.idTelemetria ASC,telemetria_mnt_correos_list.idCorreosCat ASC';
$arrCorreos = array();
$arrCorreos = db_select_array (false, $SIS_query, 'telemetria_mnt_correos_list', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCorreos');

/**********************************************************************************************************************************/
/*                                                  Includes                                                                      */
/**********************************************************************************************************************************/
include 'cron_inf_proyecciones_include.php';   //correcciones en las mediciones



?>
