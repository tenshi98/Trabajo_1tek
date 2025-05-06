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
$Message_Whatsapp  = 'Se notifica que algunos equipos presentan alertas:';
$FechaSistema      = fecha_actual(); //Fecha del servidor
$HoraSistema       = hora_actual(); //Hora del servidor

//ejecuto dependiendo del tipo de reporte
switch ($TipoReporte) {
	/********************************************/
	//Cada Media Hora
    case 1:
		//variables
		$timeBack = '00:30:00';
		$TextFile = "logs_cron_informe_media_hora_admin.txt";

		//Se calcula lapso de tiempo condicionando dias

		$HoraInicio   = restahoras($timeBack,$HoraSistema );
		$FechaInicio  = $FechaSistema;
		$HoraTermino  = $HoraSistema ;
		$FechaTermino = $FechaSistema;
		if($HoraSistema <$timeBack){
			$FechaInicio = restarDias($FechaSistema,1);
		}

        break;
    /********************************************/
	//Cada Hora
    case 2:
        //variables
		$timeBack = '01:00:00';
		$TextFile = "logs_cron_informe_1_hora_admin.txt";

		//Se calcula lapso de tiempo condicionando dias
		$HoraInicio   = restahoras($timeBack,$HoraSistema );
		$FechaInicio  = $FechaSistema;
		$HoraTermino  = $HoraSistema ;
		$FechaTermino = $FechaSistema;
		if($HoraSistema <$timeBack){
			$FechaInicio = restarDias($FechaSistema,1);
		}

        break;
    /********************************************/
	//Cada 3 Horas
    case 3:
        //variables
		$timeBack = '03:00:00';
		$TextFile = "logs_cron_informe_3_hora_admin.txt";

		//Se calcula lapso de tiempo condicionando dias
		$HoraInicio   = restahoras($timeBack,$HoraSistema );
		$FechaInicio  = $FechaSistema;
		$HoraTermino  = $HoraSistema ;
		$FechaTermino = $FechaSistema;
		if($HoraSistema <$timeBack){
			$FechaInicio = restarDias($FechaSistema,1);
		}

        break;
    /********************************************/
	//Cada 6 Horas
    case 4:
        //variables
		$timeBack = '06:00:00';
		$TextFile = "logs_cron_informe_6_hora_admin.txt";

		//Se calcula lapso de tiempo condicionando dias
		$HoraInicio   = restahoras($timeBack,$HoraSistema );
		$FechaInicio  = $FechaSistema;
		$HoraTermino  = $HoraSistema ;
		$FechaTermino = $FechaSistema;
		if($HoraSistema <$timeBack){
			$FechaInicio = restarDias($FechaSistema,1);
		}

        break;
    /********************************************/
	//Cada 12 Horas
    case 5:
        //variables
		$timeBack = '12:00:00';
		$TextFile = "logs_cron_informe_12_hora_admin.txt";

		//Se calcula lapso de tiempo condicionando dias
		$HoraInicio   = restahoras($timeBack,$HoraSistema );
		$FechaInicio  = $FechaSistema;
		$HoraTermino  = $HoraSistema ;
		$FechaTermino = $FechaSistema;
		if($HoraSistema <$timeBack){
			$FechaInicio = restarDias($FechaSistema,1);
		}

        break;
    /********************************************/
	//Diario
    case 6:
        //variables
		$timeBack = 1;
		$TextFile = "logs_cron_informe_diario_admin.txt";

		//Se calcula lapso de tiempo condicionando dias
		$HoraInicio   = $HoraSistema ;
		$FechaInicio  = restarDias($FechaSistema,$timeBack);
		$HoraTermino  = $HoraSistema ;
		$FechaTermino = $FechaSistema;

        break;
    /********************************************/
	//Semanal
    case 7:
        //variables
		$timeBack = 7;
		$TextFile = "logs_cron_informe_semanal_admin.txt";

		//Se calcula lapso de tiempo condicionando dias
		$HoraInicio   = $HoraSistema ;
		$FechaInicio  = restarDias($FechaSistema,$timeBack);
		$HoraTermino  = $HoraSistema ;
		$FechaTermino = $FechaSistema;

        break;
}

/******************************************************/


/**********************************************************************************************************************************/
/*                                                  Includes                                                                      */
/**********************************************************************************************************************************/
include 'cron_admin_include_consultas.php';    //Consulta a la BD
include 'cron_admin_include_admin.php';        //Envio de notificaciones a los administradores


?>
