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
/**********************************************************************************************************************************/
/*                                   Se filtran las entradas para evitar ataques                                                  */
/**********************************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_seguridad/AntiXSS.php';
require_once '../A2XRXS_gears/xrxs_seguridad/Bootup.php';
require_once '../A2XRXS_gears/xrxs_seguridad/UTF8.php';
//Inicializo funcion
$security = new AntiXSS();
//Se limpian datos recibidos
$_POST = $security->xss_clean($_POST);
$_GET  = $security->xss_clean($_GET);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                               //Configuracion de la plataforma
require_once '../Legacy/1tek_public/funciones/Helpers.Functions.Propias.php';      //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
set_time_limit(2400);
//Memora RAM Maxima del servidor, 4GB por defecto
ini_set('memory_limit', '4096M');

//variables
$idSistema     = 1;
$FechaSistema  = fecha_actual();
$Fecha_01      = sumarDias($FechaSistema,1);
$Fecha_10      = sumarDias($FechaSistema,10);
$Fecha_30      = sumarDias($FechaSistema,30);
$SIS_query     = 'clientes_listado.Nombre AS ClienteNombre,
clientes_listado.PersonaContacto_email AS ClienteEmail,
clientes_listado.Contrato_Nombre AS ClienteContrato_Nombre,
clientes_listado.Contrato_Fecha_Term AS ClienteContrato_Fecha_Term,
clientes_listado.idTab_1,
clientes_listado.idTab_2,
clientes_listado.idTab_3,
clientes_listado.idTab_4,
clientes_listado.idTab_5,
clientes_listado.idTab_6,
clientes_listado.idTab_7,
clientes_listado.idTab_8,
clientes_listado.idTab_9,
clientes_listado.idTab_10,
clientes_listado.idTab_11,
clientes_listado.idTab_12,
clientes_listado.idTab_13,
Negocio_1.Nombre AS ClienteTab_1,
Negocio_2.Nombre AS ClienteTab_2,
Negocio_3.Nombre AS ClienteTab_3,
Negocio_4.Nombre AS ClienteTab_4,
Negocio_5.Nombre AS ClienteTab_5,
Negocio_6.Nombre AS ClienteTab_6,
Negocio_7.Nombre AS ClienteTab_7,
Negocio_8.Nombre AS ClienteTab_8,
Negocio_9.Nombre AS ClienteTab_9,
Negocio_10.Nombre AS ClienteTab_10,
Negocio_11.Nombre AS ClienteTab_11,
Negocio_12.Nombre AS ClienteTab_12,
Negocio_13.Nombre AS ClienteTab_13,
core_sistemas.Nombre AS SistemaNombre,
core_sistemas.email_principal AS SistemaEmail, 
core_sistemas.Config_Gmail_Usuario AS SistemaGmail_Usuario, 
core_sistemas.Config_Gmail_Password AS SistemaGmail_Password';
$SIS_join     = '
LEFT JOIN core_sistemas                   ON core_sistemas.idSistema    = clientes_listado.idSistema
LEFT JOIN core_telemetria_tabs Negocio_1  ON Negocio_1.idTab            = clientes_listado.idTab_1
LEFT JOIN core_telemetria_tabs Negocio_2  ON Negocio_2.idTab            = clientes_listado.idTab_2
LEFT JOIN core_telemetria_tabs Negocio_3  ON Negocio_3.idTab            = clientes_listado.idTab_3
LEFT JOIN core_telemetria_tabs Negocio_4  ON Negocio_4.idTab            = clientes_listado.idTab_4
LEFT JOIN core_telemetria_tabs Negocio_5  ON Negocio_5.idTab            = clientes_listado.idTab_5
LEFT JOIN core_telemetria_tabs Negocio_6  ON Negocio_6.idTab            = clientes_listado.idTab_6
LEFT JOIN core_telemetria_tabs Negocio_7  ON Negocio_7.idTab            = clientes_listado.idTab_7
LEFT JOIN core_telemetria_tabs Negocio_8  ON Negocio_8.idTab            = clientes_listado.idTab_8
LEFT JOIN core_telemetria_tabs Negocio_9  ON Negocio_9.idTab            = clientes_listado.idTab_9
LEFT JOIN core_telemetria_tabs Negocio_10 ON Negocio_10.idTab           = clientes_listado.idTab_10
LEFT JOIN core_telemetria_tabs Negocio_11 ON Negocio_11.idTab           = clientes_listado.idTab_11
LEFT JOIN core_telemetria_tabs Negocio_12 ON Negocio_12.idTab           = clientes_listado.idTab_12
LEFT JOIN core_telemetria_tabs Negocio_13 ON Negocio_13.idTab           = clientes_listado.idTab_13';

/***********************************************************/
//configuracion de correos
$arrMail = array('hbarzelatto@1tek.cl');
//Empresas por vencer a 1 dia	
$arrCliente_01 = array();
$arrCliente_01 = db_select_array (false, $SIS_query, 'clientes_listado', $SIS_join, 'clientes_listado.Contrato_Fecha_Term ="'.$Fecha_01.'"', 'clientes_listado.Nombre ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCliente_01');
//Empresas por vencer a 10 dias
$arrCliente_10 = array();
$arrCliente_10 = db_select_array (false, $SIS_query, 'clientes_listado', $SIS_join, 'clientes_listado.Contrato_Fecha_Term ="'.$Fecha_10.'"', 'clientes_listado.Nombre ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCliente_10');
//Empresas por vencer a 30 dias
$arrCliente_30 = array();
$arrCliente_30 = db_select_array (false, $SIS_query, 'clientes_listado', $SIS_join, 'clientes_listado.Contrato_Fecha_Term ="'.$Fecha_30.'"', 'clientes_listado.Nombre ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCliente_30');

//logo de la compañia
$login_logo  = DB_SITE_MAIN.'/img/login_logo.png';
$file_logo   = 'img/login_logo.png';
							
//solo si existe
if (file_exists($file_logo)){

	//envio de correo
	try {
	
		/****************************************************************************************/
		foreach ($arrCliente_01 as $cliente) {

			/**************************************************/
			//Variables para el titulo del correo
			$BodyAsunto = $cliente['ClienteContrato_Nombre'].' (';

			/**************************************************/
			//Se crea el cuerpo
			$BodyMail  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$BodyMail .= '<img src="'.$login_logo.'" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
			$BodyMail .= '<h3 style="text-align: center;font-size: 30px;">';
			$BodyMail .= '¡Hola <strong>'.$cliente['ClienteNombre'].'</strong>!<br/>';
			$BodyMail .= '</h3>';
			$BodyMail .= '<p style="text-align: center;font-size: 20px;">';
			$BodyMail .= 'Te informamos que el contrato '.$cliente['ClienteContrato_Nombre'];
			$BodyMail .= ' por el servicio ';
			if(isset($cliente['idTab_1'])&&$cliente['idTab_1']!=''&&$cliente['idTab_1']==2){     $BodyMail .= ' '.$cliente['ClienteTab_1'];$BodyAsunto .= ' - '.$cliente['ClienteTab_1'];}
			if(isset($cliente['idTab_2'])&&$cliente['idTab_2']!=''&&$cliente['idTab_2']==2){     $BodyMail .= ' '.$cliente['ClienteTab_2'];$BodyAsunto .= ' - '.$cliente['ClienteTab_2'];}
			if(isset($cliente['idTab_3'])&&$cliente['idTab_3']!=''&&$cliente['idTab_3']==2){     $BodyMail .= ' '.$cliente['ClienteTab_3'];$BodyAsunto .= ' - '.$cliente['ClienteTab_3'];}
			if(isset($cliente['idTab_4'])&&$cliente['idTab_4']!=''&&$cliente['idTab_4']==2){     $BodyMail .= ' '.$cliente['ClienteTab_4'];$BodyAsunto .= ' - '.$cliente['ClienteTab_4'];}
			if(isset($cliente['idTab_5'])&&$cliente['idTab_5']!=''&&$cliente['idTab_5']==2){     $BodyMail .= ' '.$cliente['ClienteTab_5'];$BodyAsunto .= ' - '.$cliente['ClienteTab_5'];}
			if(isset($cliente['idTab_6'])&&$cliente['idTab_6']!=''&&$cliente['idTab_6']==2){     $BodyMail .= ' '.$cliente['ClienteTab_6'];$BodyAsunto .= ' - '.$cliente['ClienteTab_6'];}
			if(isset($cliente['idTab_7'])&&$cliente['idTab_7']!=''&&$cliente['idTab_7']==2){     $BodyMail .= ' '.$cliente['ClienteTab_7'];$BodyAsunto .= ' - '.$cliente['ClienteTab_7'];}
			if(isset($cliente['idTab_8'])&&$cliente['idTab_8']!=''&&$cliente['idTab_8']==2){     $BodyMail .= ' '.$cliente['ClienteTab_8'];$BodyAsunto .= ' - '.$cliente['ClienteTab_8'];}
			if(isset($cliente['idTab_9'])&&$cliente['idTab_9']!=''&&$cliente['idTab_9']==2){     $BodyMail .= ' '.$cliente['ClienteTab_9'];$BodyAsunto .= ' - '.$cliente['ClienteTab_9'];}
			if(isset($cliente['idTab_10'])&&$cliente['idTab_10']!=''&&$cliente['idTab_10']==2){  $BodyMail .= ' '.$cliente['ClienteTab_10'];$BodyAsunto .= ' - '.$cliente['ClienteTab_10'];}
			if(isset($cliente['idTab_11'])&&$cliente['idTab_11']!=''&&$cliente['idTab_11']==2){  $BodyMail .= ' '.$cliente['ClienteTab_11'];$BodyAsunto .= ' - '.$cliente['ClienteTab_11'];}
			if(isset($cliente['idTab_12'])&&$cliente['idTab_12']!=''&&$cliente['idTab_12']==2){  $BodyMail .= ' '.$cliente['ClienteTab_12'];$BodyAsunto .= ' - '.$cliente['ClienteTab_12'];}
			if(isset($cliente['idTab_13'])&&$cliente['idTab_13']!=''&&$cliente['idTab_13']==2){  $BodyMail .= ' '.$cliente['ClienteTab_13'];$BodyAsunto .= ' - '.$cliente['ClienteTab_13'];}
			$BodyMail .= ', vence el '.fecha_estandar($cliente['ClienteContrato_Fecha_Term']).'.';
			$BodyMail .= '</p>';
			$BodyMail .= '</div>';

			/**************************************************/
			//Variables para el titulo del correo
			$BodyAsunto .= ') está pronto a vencer';

			/**************************************************/
			//Se verifica que correo exista
			if(isset($cliente['SistemaEmail'])&&$cliente['SistemaEmail']!=''&&isset($cliente['ClienteEmail'])&&$cliente['ClienteEmail']!=''){

				/**************************************************/
				//se envia correo al cliente
				/*$rmail = tareas_envio_correo($cliente['SistemaEmail'], $cliente['SistemaNombre'], 
											 $cliente['ClienteEmail'], $cliente['ClienteNombre'], 
											 '', '', 
											 $BodyAsunto, 
											 $BodyMail,'', 
											 '', 
											 1, 
											 $cliente['SistemaGmail_Usuario'], 
											 $cliente['SistemaGmail_Password']);
											 
				//se guarda el log
				log_response(1, $rmail, $cliente['ClienteEmail'].' (Asunto:'.$BodyAsunto.')');	
				
				/**************************************************/
				//se envia correo a encargados
				foreach ($arrMail as $e_mail) {
					if(isset($e_mail)&&$e_mail!=''){
						$rmail = tareas_envio_correo($cliente['SistemaEmail'], $cliente['SistemaNombre'],
													 $e_mail, 'Destinatario',
													 '', '',
													 $BodyAsunto,
													 $BodyMail,'',
													 '',
													 1,
													 $cliente['SistemaGmail_Usuario'],
													 $cliente['SistemaGmail_Password']);
													 
						//se guarda el log
						log_response(1, $rmail, $cliente['ClienteEmail'].' (Asunto:'.$BodyAsunto.')');
					}
				}
			}
		}
		

		/****************************************************************************************/
		foreach ($arrCliente_10 as $cliente) {
			/**************************************************/
			//Variables para el titulo del correo
			$BodyAsunto = $cliente['ClienteContrato_Nombre'].' (';

			/**************************************************/
			//Se crea el cuerpo
			$BodyMail  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$BodyMail .= '<img src="'.$login_logo.'" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
			$BodyMail .= '<h3 style="text-align: center;font-size: 30px;">';
			$BodyMail .= '¡Hola <strong>'.$cliente['ClienteNombre'].'</strong>!<br/>';
			$BodyMail .= '</h3>';
			$BodyMail .= '<p style="text-align: center;font-size: 20px;">';
			$BodyMail .= 'Te informamos que el contrato '.$cliente['ClienteContrato_Nombre'];
			$BodyMail .= ' por el servicio ';
			if(isset($cliente['idTab_1'])&&$cliente['idTab_1']!=''&&$cliente['idTab_1']==2){     $BodyMail .= ' '.$cliente['ClienteTab_1'];$BodyAsunto .= ' - '.$cliente['ClienteTab_1'];}
			if(isset($cliente['idTab_2'])&&$cliente['idTab_2']!=''&&$cliente['idTab_2']==2){     $BodyMail .= ' '.$cliente['ClienteTab_2'];$BodyAsunto .= ' - '.$cliente['ClienteTab_2'];}
			if(isset($cliente['idTab_3'])&&$cliente['idTab_3']!=''&&$cliente['idTab_3']==2){     $BodyMail .= ' '.$cliente['ClienteTab_3'];$BodyAsunto .= ' - '.$cliente['ClienteTab_3'];}
			if(isset($cliente['idTab_4'])&&$cliente['idTab_4']!=''&&$cliente['idTab_4']==2){     $BodyMail .= ' '.$cliente['ClienteTab_4'];$BodyAsunto .= ' - '.$cliente['ClienteTab_4'];}
			if(isset($cliente['idTab_5'])&&$cliente['idTab_5']!=''&&$cliente['idTab_5']==2){     $BodyMail .= ' '.$cliente['ClienteTab_5'];$BodyAsunto .= ' - '.$cliente['ClienteTab_5'];}
			if(isset($cliente['idTab_6'])&&$cliente['idTab_6']!=''&&$cliente['idTab_6']==2){     $BodyMail .= ' '.$cliente['ClienteTab_6'];$BodyAsunto .= ' - '.$cliente['ClienteTab_6'];}
			if(isset($cliente['idTab_7'])&&$cliente['idTab_7']!=''&&$cliente['idTab_7']==2){     $BodyMail .= ' '.$cliente['ClienteTab_7'];$BodyAsunto .= ' - '.$cliente['ClienteTab_7'];}
			if(isset($cliente['idTab_8'])&&$cliente['idTab_8']!=''&&$cliente['idTab_8']==2){     $BodyMail .= ' '.$cliente['ClienteTab_8'];$BodyAsunto .= ' - '.$cliente['ClienteTab_8'];}
			if(isset($cliente['idTab_9'])&&$cliente['idTab_9']!=''&&$cliente['idTab_9']==2){     $BodyMail .= ' '.$cliente['ClienteTab_9'];$BodyAsunto .= ' - '.$cliente['ClienteTab_9'];}
			if(isset($cliente['idTab_10'])&&$cliente['idTab_10']!=''&&$cliente['idTab_10']==2){  $BodyMail .= ' '.$cliente['ClienteTab_10'];$BodyAsunto .= ' - '.$cliente['ClienteTab_10'];}
			if(isset($cliente['idTab_11'])&&$cliente['idTab_11']!=''&&$cliente['idTab_11']==2){  $BodyMail .= ' '.$cliente['ClienteTab_11'];$BodyAsunto .= ' - '.$cliente['ClienteTab_11'];}
			if(isset($cliente['idTab_12'])&&$cliente['idTab_12']!=''&&$cliente['idTab_12']==2){  $BodyMail .= ' '.$cliente['ClienteTab_12'];$BodyAsunto .= ' - '.$cliente['ClienteTab_12'];}
			if(isset($cliente['idTab_13'])&&$cliente['idTab_13']!=''&&$cliente['idTab_13']==2){  $BodyMail .= ' '.$cliente['ClienteTab_13'];$BodyAsunto .= ' - '.$cliente['ClienteTab_13'];}
			$BodyMail .= ', vence el '.fecha_estandar($cliente['ClienteContrato_Fecha_Term']).'.';
			$BodyMail .= '</p>';
			$BodyMail .= '</div>';

			/**************************************************/
			//Variables para el titulo del correo
			$BodyAsunto .= ') está pronto a vencer';

			/**************************************************/
			//Se verifica que correo exista
			if(isset($cliente['SistemaEmail'])&&$cliente['SistemaEmail']!=''&&isset($cliente['ClienteEmail'])&&$cliente['ClienteEmail']!=''){

				/**************************************************/
				//se envia correo al cliente
				/*$rmail = tareas_envio_correo($cliente['SistemaEmail'], $cliente['SistemaNombre'], 
											 $cliente['ClienteEmail'], $cliente['ClienteNombre'], 
											 '', '', 
											 $BodyAsunto, 
											 $BodyMail,'', 
											 '', 
											 1, 
											 $cliente['SistemaGmail_Usuario'], 
											 $cliente['SistemaGmail_Password']);
											 
				//se guarda el log
				log_response(1, $rmail, $cliente['ClienteEmail'].' (Asunto:'.$BodyAsunto.')');	
				
				/**************************************************/
				//se envia correo a encargados
				foreach ($arrMail as $e_mail) {
					if(isset($e_mail)&&$e_mail!=''){
						$rmail = tareas_envio_correo($cliente['SistemaEmail'], $cliente['SistemaNombre'],
													 $e_mail, 'Destinatario',
													 '', '',
													 $BodyAsunto,
													 $BodyMail,'',
													 '',
													 1,
													 $cliente['SistemaGmail_Usuario'],
													 $cliente['SistemaGmail_Password']);
													 
						//se guarda el log
						log_response(1, $rmail, $cliente['ClienteEmail'].' (Asunto:'.$BodyAsunto.')');
					}
				}
			}
		}
		
		
		
		/****************************************************************************************/
		foreach ($arrCliente_30 as $cliente) {
			/**************************************************/
			//Variables para el titulo del correo
			$BodyAsunto = $cliente['ClienteContrato_Nombre'].' (';

			/**************************************************/
			//Se crea el cuerpo
			$BodyMail  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$BodyMail .= '<img src="'.$login_logo.'" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
			$BodyMail .= '<h3 style="text-align: center;font-size: 30px;">';
			$BodyMail .= '¡Hola <strong>'.$cliente['ClienteNombre'].'</strong>!<br/>';
			$BodyMail .= '</h3>';
			$BodyMail .= '<p style="text-align: center;font-size: 20px;">';
			$BodyMail .= 'Te informamos que el contrato '.$cliente['ClienteContrato_Nombre'];
			$BodyMail .= ' por el servicio ';
			if(isset($cliente['idTab_1'])&&$cliente['idTab_1']!=''&&$cliente['idTab_1']==2){     $BodyMail .= ' '.$cliente['ClienteTab_1'];$BodyAsunto .= ' - '.$cliente['ClienteTab_1'];}
			if(isset($cliente['idTab_2'])&&$cliente['idTab_2']!=''&&$cliente['idTab_2']==2){     $BodyMail .= ' '.$cliente['ClienteTab_2'];$BodyAsunto .= ' - '.$cliente['ClienteTab_2'];}
			if(isset($cliente['idTab_3'])&&$cliente['idTab_3']!=''&&$cliente['idTab_3']==2){     $BodyMail .= ' '.$cliente['ClienteTab_3'];$BodyAsunto .= ' - '.$cliente['ClienteTab_3'];}
			if(isset($cliente['idTab_4'])&&$cliente['idTab_4']!=''&&$cliente['idTab_4']==2){     $BodyMail .= ' '.$cliente['ClienteTab_4'];$BodyAsunto .= ' - '.$cliente['ClienteTab_4'];}
			if(isset($cliente['idTab_5'])&&$cliente['idTab_5']!=''&&$cliente['idTab_5']==2){     $BodyMail .= ' '.$cliente['ClienteTab_5'];$BodyAsunto .= ' - '.$cliente['ClienteTab_5'];}
			if(isset($cliente['idTab_6'])&&$cliente['idTab_6']!=''&&$cliente['idTab_6']==2){     $BodyMail .= ' '.$cliente['ClienteTab_6'];$BodyAsunto .= ' - '.$cliente['ClienteTab_6'];}
			if(isset($cliente['idTab_7'])&&$cliente['idTab_7']!=''&&$cliente['idTab_7']==2){     $BodyMail .= ' '.$cliente['ClienteTab_7'];$BodyAsunto .= ' - '.$cliente['ClienteTab_7'];}
			if(isset($cliente['idTab_8'])&&$cliente['idTab_8']!=''&&$cliente['idTab_8']==2){     $BodyMail .= ' '.$cliente['ClienteTab_8'];$BodyAsunto .= ' - '.$cliente['ClienteTab_8'];}
			if(isset($cliente['idTab_9'])&&$cliente['idTab_9']!=''&&$cliente['idTab_9']==2){     $BodyMail .= ' '.$cliente['ClienteTab_9'];$BodyAsunto .= ' - '.$cliente['ClienteTab_9'];}
			if(isset($cliente['idTab_10'])&&$cliente['idTab_10']!=''&&$cliente['idTab_10']==2){  $BodyMail .= ' '.$cliente['ClienteTab_10'];$BodyAsunto .= ' - '.$cliente['ClienteTab_10'];}
			if(isset($cliente['idTab_11'])&&$cliente['idTab_11']!=''&&$cliente['idTab_11']==2){  $BodyMail .= ' '.$cliente['ClienteTab_11'];$BodyAsunto .= ' - '.$cliente['ClienteTab_11'];}
			if(isset($cliente['idTab_12'])&&$cliente['idTab_12']!=''&&$cliente['idTab_12']==2){  $BodyMail .= ' '.$cliente['ClienteTab_12'];$BodyAsunto .= ' - '.$cliente['ClienteTab_12'];}
			if(isset($cliente['idTab_13'])&&$cliente['idTab_13']!=''&&$cliente['idTab_13']==2){  $BodyMail .= ' '.$cliente['ClienteTab_13'];$BodyAsunto .= ' - '.$cliente['ClienteTab_13'];}
			$BodyMail .= ', vence el '.fecha_estandar($cliente['ClienteContrato_Fecha_Term']).'.';
			$BodyMail .= '</p>';
			$BodyMail .= '</div>';

			/**************************************************/
			//Variables para el titulo del correo
			$BodyAsunto .= ') está pronto a vencer';

			/**************************************************/
			//Se verifica que correo exista
			if(isset($cliente['SistemaEmail'])&&$cliente['SistemaEmail']!=''&&isset($cliente['ClienteEmail'])&&$cliente['ClienteEmail']!=''){

				/**************************************************/
				//se envia correo al cliente
				/*$rmail = tareas_envio_correo($cliente['SistemaEmail'], $cliente['SistemaNombre'], 
											 $cliente['ClienteEmail'], $cliente['ClienteNombre'], 
											 '', '', 
											 $BodyAsunto, 
											 $BodyMail,'', 
											 '', 
											 1, 
											 $cliente['SistemaGmail_Usuario'], 
											 $cliente['SistemaGmail_Password']);
											 
				//se guarda el log
				log_response(1, $rmail, $cliente['ClienteEmail'].' (Asunto:'.$BodyAsunto.')');	
				
				/**************************************************/
				//se envia correo a encargados
				foreach ($arrMail as $e_mail) {
					if(isset($e_mail)&&$e_mail!=''){
						$rmail = tareas_envio_correo($cliente['SistemaEmail'], $cliente['SistemaNombre'],
													 $e_mail, 'Destinatario',
													 '', '',
													 $BodyAsunto,
													 $BodyMail,'',
													 '',
													 1,
													 $cliente['SistemaGmail_Usuario'],
													 $cliente['SistemaGmail_Password']);
													 
						//se guarda el log
						log_response(1, $rmail, $cliente['ClienteEmail'].' (Asunto:'.$BodyAsunto.')');
					}
				}
			}
		}
				
									
	} catch (Exception $e) {
		php_error_log('Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron', '', 'error de registro:'.$e->getMessage(), '' );
				
	}
}else{
	php_error_log('Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron', '', 'logo no existe ('.$login_logo.')', '' );
}

	
	
	
	
	
?>
