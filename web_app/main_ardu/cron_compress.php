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
//Envia informes cada 1 dia
/**********************************************************************************************************************************/
/*                                       VARIABLES GLOBALES DE CONFIGURACION                                                      */
/**********************************************************************************************************************************/
//archivo de configuracion
include '1_global_config.php';

//Variables
$Nombre_zip = 'Respaldo_'.Fecha_archivos(fecha_actual()).'_'.Hora_archivos(hora_actual()).'.zip';
$Destino    = 'backups/'.$Nombre_zip;
//Consulta equipos de telemetria
$arrEquipos = array();
$arrEquipos = db_select_array (false, 'idTelemetria', 'telemetria_listado', '', '', 'idTelemetria ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

/**********************************************************/
//Compresion de archivos
$zip = new ZipArchive;
if ($zip->open($Nombre_zip, ZipArchive::CREATE) === TRUE){

    // Archivos TXT a comprimir
    $zip->addFile('logs_ardu_alertas.txt', 'logs_ardu_alertas.txt');
    $zip->addFile('logs_ardu_counter.txt', 'logs_ardu_counter.txt');
    $zip->addFile('logs_ardu_log.txt', 'logs_ardu_log.txt');
    $zip->addFile('logs_ardu_send_mail.txt', 'logs_ardu_send_mail.txt');
    $zip->addFile('logs_cron_eliminacion_microparadas_1_save.txt', 'logs_cron_eliminacion_microparadas_1_save.txt');
    $zip->addFile('logs_cron_eliminacion_microparadas_2_save.txt', 'logs_cron_eliminacion_microparadas_2_save.txt');
    $zip->addFile('logs_cron_informe_1_hora_admin.txt', 'logs_cron_informe_1_hora_admin.txt');
    $zip->addFile('logs_cron_informe_3_hora_admin.txt', 'logs_cron_informe_3_hora_admin.txt');
    $zip->addFile('logs_cron_informe_6_hora_admin.txt', 'logs_cron_informe_6_hora_admin.txt');
    $zip->addFile('logs_cron_informe_12_hora_admin.txt', 'logs_cron_informe_12_hora_admin.txt');
    $zip->addFile('logs_cron_informe_diario_admin.txt', 'logs_cron_informe_diario_admin.txt');
    $zip->addFile('logs_cron_informe_diario_user.txt', 'logs_cron_informe_diario_user.txt');
    $zip->addFile('logs_cron_informe_hora_admin.txt', 'logs_cron_informe_hora_admin.txt');
    $zip->addFile('logs_cron_informe_hora_user.txt', 'logs_cron_informe_hora_user.txt');
    $zip->addFile('logs_cron_informe_media_hora_admin.txt', 'logs_cron_informe_media_hora_admin.txt');
    $zip->addFile('logs_cron_informe_media_hora_user.txt', 'logs_cron_informe_media_hora_user.txt');
    $zip->addFile('logs_cron_informe_semanal_admin.txt', 'logs_cron_informe_semanal_admin.txt');
    $zip->addFile('logs_cron_informe_semanal_user.txt', 'logs_cron_informe_semanal_user.txt');

    // Archivos PHP a comprimir
    $zip->addFile('1_global_config.php', '1_global_config.php');
    $zip->addFile('ardu_include_02_1_ponderaciones.php', 'ardu_include_02_1_ponderaciones.php');
    $zip->addFile('ardu_include_02_2_calibraciones.php', 'ardu_include_02_2_calibraciones.php');

    //recorro los equipos y verifico que el archivo que exista
    foreach ($arrEquipos as $equip) {
		if (file_exists('logs_ardu_log_id_'.$equip['idTelemetria'].'.txt')){
			$zip->addFile('logs_ardu_log_id_'.$equip['idTelemetria'].'.txt', 'logs_ardu_log_id_'.$equip['idTelemetria'].'.txt');
		}
	}

    // Cerrar el archivo
    $zip->close();
}
/**********************************************************/
//Se copia el archivo comprimido
copy($Nombre_zip,$Destino);
//se elimina archivo original
unlink($Nombre_zip);

/**********************************************************/
//se vacian los archivos de texto
$fp = fopen("logs_ardu_alertas.txt", "w+"); fclose($fp);
$fp = fopen("logs_ardu_counter.txt", "w+"); fclose($fp);
$fp = fopen("logs_ardu_log.txt", "w+"); fclose($fp);
$fp = fopen("logs_ardu_send_mail.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_eliminacion_microparadas_1_save.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_eliminacion_microparadas_2_save.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_1_hora_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_3_hora_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_6_hora_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_12_hora_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_diario_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_diario_user.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_hora_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_hora_user.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_media_hora_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_media_hora_user.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_semanal_admin.txt", "w+"); fclose($fp);
$fp = fopen("logs_cron_informe_semanal_user.txt", "w+"); fclose($fp);

//recorro los equipos y verifico que el archivo que exista
foreach ($arrEquipos as $equip) {
	if (file_exists('logs_ardu_log_id_'.$equip['idTelemetria'].'.txt')){
		$fp = fopen("logs_ardu_log_id_".$equip['idTelemetria'].".txt", "w+"); fclose($fp);
	}
}

?>
