<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                    CONFIGURACION DEL ARCHIVO ardu.php                              */
/*                                                                                                    */
/******************************************************************************************************/
//Tipo de control de log
//	1: contador
//	2: log de los datos recibidos
//	3: URL Recibido
$Control_Type = 3;
//Listado de errores
$ErrorListing = array();
//verifico si ignoro los valores 999xx
//	1: ignorar
//	2: guardar los valores 999xx
$dis_999 = 2;

/*****************************************/
//Archivos Log
$ardu_file_alerts = "logs_ardu_alertas.txt";    //Archivo con las alertas
$ardu_file_log_1  = "logs_ardu_counter.txt";    //Contador de conecciones
$ardu_file_log_2  = "logs_ardu_log_id_";        //se guardan todos los datos que si se reciben
$ardu_file_log_3  = "logs_ardu_log_id_";        //log con la captura de la direccion completa, con o sin variables predefinidas
$ardu_file_log_4  = "logs_ardu_send_mail.txt";  //ardu_include_envio_correos
/*****************************************/
//Configuracion de tiempo entre correos de alerta
$TimeAlertMail_Critical = '00:15:00';
$TimeAlertMail_Normal   = '00:55:00'; //se deja en 55 para evitar que se pise con el cron cada 1 hora

/******************************************************************************************************/
/*                                                                                                    */
/*                                  CONFIGURACION CRON ADMIN                                          */
/*                                                                                                    */
/******************************************************************************************************/
//Correos destinatarios
//$arrMail = array('test_1@test.cl','test_2@test.cl', 'test_3@test.cl', 'test_4@test.cl');
$arrMail         = array('gonzalo@simplytech.cl', 'humberto@simplytech.cl', 'luigi@simplytech.cl');
$arrPhone        = array('+56941933222', '+56990994763');
$WhatsappIdAdmin = '120363038187629052@g.us';
/******************************************************/
/* Periodicidad                                       */
/* 1 - Cada Media Hora                                */
/* 2 - Cada Hora                                      */
/* 3 - Cada 3 Horas                                   */
/* 4 - Cada 6 Horas                                   */
/* 5 - Cada 12 Horas                                  */
/* 6 - Diario                                         */
/* 7 - Semanal                                        */
/******************************************************/
$TipoReporte = 4;
/******************************************************/
/* Tivo de envio                                      */
/* 1 - Solo Email                                     */
/* 2 - Solo Whatsapp (Full text)                      */
/* 3 - Ambos  (Whatsapp Full text)                    */
/* 4 - Solo Whatsapp (Enlace Archivo)                 */
/* 5 - Ambos  (Whatsapp Enlace Archivo)               */
/******************************************************/
$TipoEnvio = 5;

/******************************************************************************************************/
/*                                                                                                    */
/*                             CONFIGURACION GENERAL DE LOS ARDU                                      */
/*                                                                                                    */
/******************************************************************************************************/
$Global_AT_NC_AlertasCatastroficas  = 9;   //Alerta temprana - Notificacion Correo - Alertas Catastroficas OK
$Global_AT_NC_AlertasNormales       = 30;  //Alerta temprana - Notificacion Correo - Alertas Normales OK
$Global_AT_NC_EquipoFueraGeocerca   = 17;  //Alerta temprana - Notificacion Correo - Equipo Fuera de Geocerca OK
$Global_AT_NC_ExcesoVelocidad       = 6;   //Alerta temprana - Notificacion Correo - Exceso Velocidad OK
$Global_AT_NC_FueraLinea            = 4;   //Alerta temprana - Notificacion Correo - Fuera de Linea OK
$Global_AT_NW_AlertasCatastroficas  = 44;  //Alerta temprana - Notificacion Whatsapp - Alertas Catastroficas OK
$Global_AT_NW_AlertasNormales       = 8;   //Alerta temprana - Notificacion Whatsapp - Alertas Normales
$Global_AT_NW_EquipoFueraGeocerca   = 52;  //Alerta temprana - Notificacion Whatsapp - Equipo Fuera de Geocerca
$Global_AT_NW_ExcesoVelocidad       = 51;  //Alerta temprana - Notificacion Whatsapp - Exceso Velocidad
$Global_AT_NW_FueraLinea            = 53;  //Alerta temprana - Notificacion Whatsapp - Fuera de Linea

/******************************************************************************************************/
/*                                                                                                    */
/*                             CONFIGURACION GENERAL DE LOS CRONES                                    */
/*                                                                                                    */
/******************************************************************************************************/
/**************************************************************/
//  CONFIGURACION DEL ARCHIVO cron_informe_media_hora.php
$Global_inf_media_hora_timeBack                      = '00:30:00'; //Tiempo de revision de las bases de datos
$Global_inf_media_hora_TextFile_User                 = "logs_cron_informe_media_hora_user.txt";
$Global_inf_media_hora_SA_NC_AlertasCatastrofica     = 34;   //Crones - Reporte Media Hora - Notificacion Correo - Alertas Catastroficas
$Global_inf_media_hora_SA_NC_AlertasNormales         = 26;   //Crones - Reporte Media Hora - Notificacion Correo - Alertas Normales
$Global_inf_media_hora_SA_NC_FueraGeocerca           = 27;   //Crones - Reporte Media Hora - Notificacion Correo - Equipo Fuera de Geocerca
$Global_inf_media_hora_SA_NC_ExcesoVelocidad         = 28;   //Crones - Reporte Media Hora - Notificacion Correo - Exceso Limite Velocidad
$Global_inf_media_hora_SA_NC_FueraLinea              = 29;   //Crones - Reporte Media Hora - Notificacion Correo - Fuera de Linea
$Global_inf_media_hora_SA_NC_FueraLineaActual        = 58;   //Crones - Reporte Media Hora - Notificacion Correo - Fuera de Linea Actual
$Global_inf_media_hora_SA_NW_AlertasCatastrofica     = 38;   //Crones - Reporte Media Hora - Notificacion Whatsapp - Alertas Catastroficas
$Global_inf_media_hora_SA_NW_AlertasPersonalizadas   = 49;   //Crones - Reporte Media Hora - Notificacion Whatsapp - Alertas Normales
$Global_inf_media_hora_SA_NW_FueraGeocerca           = 25;   //Crones - Reporte Media Hora - Notificacion Whatsapp - Equipo Fuera de Geocerca
$Global_inf_media_hora_SA_NW_ExcesoVelocidad         = 42;   //Crones - Reporte Media Hora - Notificacion Whatsapp - Exceso Limite Velocidad
$Global_inf_media_hora_SA_NW_FueraLinea              = 45;   //Crones - Reporte Media Hora - Notificacion Whatsapp - Fuera de Linea
$Global_inf_media_hora_SA_NW_FueraLineaActual        = 59;   //Crones - Reporte Media Hora - Notificacion Whatsapp - Fuera de Linea Actual

/**************************************************************/
//  CONFIGURACION DEL ARCHIVO cron_informe_hora.php
$Global_inf_hora_timeBack                      = '01:00:00'; //Tiempo de revision de las bases de datos
$Global_inf_hora_TextFile_User                 = "logs_cron_informe_hora_user.txt";
$Global_inf_hora_SA_NC_AlertasCatastrofica     = 33;   //Crones - Reporte Hora - Notificacion Correo - Alertas Catastroficas
$Global_inf_hora_SA_NC_AlertasNormales         = 1;    //Crones - Reporte Hora - Notificacion Correo - Alertas Normales
$Global_inf_hora_SA_NC_FueraGeocerca           = 10;   //Crones - Reporte Hora - Notificacion Correo - Equipo Fuera de Geocerca
$Global_inf_hora_SA_NC_ExcesoVelocidad         = 11;   //Crones - Reporte Hora - Notificacion Correo - Exceso Limite Velocidad
$Global_inf_hora_SA_NC_FueraLinea              = 12;   //Crones - Reporte Hora - Notificacion Correo - Fuera de Linea
$Global_inf_hora_SA_NC_FueraLineaActual        = 56;   //Crones - Reporte Hora - Notificacion Correo - Fuera de Linea Actual
$Global_inf_hora_SA_NW_AlertasCatastrofica     = 41;   //Crones - Reporte Hora - Notificacion Whatsapp - Alertas Catastroficas
$Global_inf_hora_SA_NW_AlertasPersonalizadas   = 37;   //Crones - Reporte Hora - Notificacion Whatsapp - Alertas Normales
$Global_inf_hora_SA_NW_FueraGeocerca           = 48;   //Crones - Reporte Hora - Notificacion Whatsapp - Equipo Fuera de Geocerca
$Global_inf_hora_SA_NW_ExcesoVelocidad         = 3;    //Crones - Reporte Hora - Notificacion Whatsapp - Exceso Limite Velocidad
$Global_inf_hora_SA_NW_FueraLinea              = 16;   //Crones - Reporte Hora - Notificacion Whatsapp - Fuera de Linea
$Global_inf_hora_SA_NW_FueraLineaActual        = 57;   //Crones - Reporte Hora - Notificacion Whatsapp - Fuera de Linea Actual

/**************************************************************/
//  CONFIGURACION DEL ARCHIVO cron_informe_diario.php
$Global_inf_dia_dias                          = 1; //Dias hacia atras a revisar
$Global_inf_dia_TextFile_User                 = "logs_cron_informe_diario_user.txt";
$Global_inf_dia_SA_NC_AlertasCatastrofica     = 32;   //Crones - Reporte Dia - Notificacion Correo - Alertas Catastroficas
$Global_inf_dia_SA_NC_AlertasNormales         = 15;   //Crones - Reporte Dia - Notificacion Correo - Alertas Normales
$Global_inf_dia_SA_NC_FueraGeocerca           = 18;   //Crones - Reporte Dia - Notificacion Correo - Equipo Fuera de Geocerca
$Global_inf_dia_SA_NC_ExcesoVelocidad         = 2;    //Crones - Reporte Dia - Notificacion Correo - Exceso Limite Velocidad
$Global_inf_dia_SA_NC_FueraLinea              = 14;   //Crones - Reporte Dia - Notificacion Correo - Fuera de Linea
$Global_inf_dia_SA_NC_FueraLineaActual        = 54;   //Crones - Reporte Dia - Notificacion Correo - Fuera de Linea Actual
$Global_inf_dia_SA_NW_AlertasCatastrofica     = 13;   //Crones - Reporte Dia - Notificacion Whatsapp - Alertas Catastroficas
$Global_inf_dia_SA_NW_AlertasPersonalizadas   = 36;   //Crones - Reporte Dia - Notificacion Whatsapp - Alertas Normales
$Global_inf_dia_SA_NW_FueraGeocerca           = 5;    //Crones - Reporte Dia - Notificacion Whatsapp - Equipo Fuera de Geocerca
$Global_inf_dia_SA_NW_ExcesoVelocidad         = 47;   //Crones - Reporte Dia - Notificacion Whatsapp - Exceso Limite Velocidad
$Global_inf_dia_SA_NW_FueraLinea              = 40;   //Crones - Reporte Dia - Notificacion Whatsapp - Fuera de Linea
$Global_inf_dia_SA_NW_FueraLineaActual        = 55;   //Crones - Reporte Dia - Notificacion Whatsapp - Fuera de Linea Actual

/**************************************************************/
//  CONFIGURACION DEL ARCHIVO cron_informe_semanal.php
$Global_inf_semanal_dias                          = 7; //Dias hacia atras a revisar
$Global_inf_semanal_TextFile_User                 = "logs_cron_informe_semanal_user.txt";
$Global_inf_semanal_SA_NC_AlertasCatastrofica     = 35;   //Crones - Reporte Semana - Notificacion Correo - Alertas Catastroficas
$Global_inf_semanal_SA_NC_AlertasNormales         = 20;   //Crones - Reporte Semana - Notificacion Correo - Alertas Normales
$Global_inf_semanal_SA_NC_FueraGeocerca           = 21;   //Crones - Reporte Semana - Notificacion Correo - Equipo Fuera de Geocerca
$Global_inf_semanal_SA_NC_ExcesoVelocidad         = 22;   //Crones - Reporte Semana - Notificacion Correo - Exceso Limite Velocidad
$Global_inf_semanal_SA_NC_FueraLinea              = 23;   //Crones - Reporte Semana - Notificacion Correo - Fuera de Linea
$Global_inf_semanal_SA_NC_FueraLineaActual        = 60;   //Crones - Reporte Semana - Notificacion Correo - Fuera de Linea Actual
$Global_inf_semanal_SA_NW_AlertasCatastrofica     = 46;   //Crones - Reporte Semana - Notificacion Whatsapp - Alertas Catastroficas
$Global_inf_semanal_SA_NW_AlertasPersonalizadas   = 39;   //Crones - Reporte Semana - Notificacion Whatsapp - Alertas Normales
$Global_inf_semanal_SA_NW_FueraGeocerca           = 43;   //Crones - Reporte Semana - Notificacion Whatsapp - Equipo Fuera de Geocerca
$Global_inf_semanal_SA_NW_ExcesoVelocidad         = 50;   //Crones - Reporte Semana - Notificacion Whatsapp - Exceso Limite Velocidad
$Global_inf_semanal_SA_NW_FueraLinea              = 19;   //Crones - Reporte Semana - Notificacion Whatsapp - Fuera de Linea
$Global_inf_semanal_SA_NW_FueraLineaActual        = 61;   //Crones - Reporte Semana - Notificacion Whatsapp - Fuera de Linea Actual

?>
