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
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';      //carga librerias de la plataforma

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
$SIS_idSistema   = 1;
$SIS_Fecha       = fecha_actual();

/*******************************************************/
//traigo solo los apoderados con plan y cobro mensual
$SIS_query = '
apoderados_listado.email,
apoderados_listado.Nombre,
apoderados_listado.ApellidoPat,
apoderados_listado.ApellidoMat,
core_sistemas.Nombre AS EmpresaNombre,
core_sistemas.email_principal AS EmpresaEmail, 
core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
core_sistemas.Config_Gmail_Password AS Gmail_Password';
$SIS_join  = 'LEFT JOIN `core_sistemas`   ON core_sistemas.idSistema  = apoderados_listado.idSistema';
$SIS_where = 'apoderados_listado.idSistema = '.$SIS_idSistema.' 
AND apoderados_listado.idEstado = 1
AND apoderados_listado.idPlan != 0 
AND apoderados_listado.idCobro = 1';
$SIS_order = 0;
$arrApoderado = array();
$arrApoderado = db_select_array (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

/*********************************************************************/
//Se recorren los apoderados
foreach ($arrApoderado as $apo) {

	/***********************************************/
	//Envio de correo
	$BodyMail  = '<p>';
	$BodyMail .= 'Estimado '.$apo['Nombre'].' '.$apo['ApellidoPat'].' '.$apo['ApellidoMat'].'<br/>';
	$BodyMail .= '<br/>';
	$BodyMail .= 'Junto con saludar, le recordamos que el día 05 vencerá el mes de servicio Busafe, “monitoreo de transporte escolar”. Favor realizar el pago desde la pagina principal una vez facturado.<br/>';
	$BodyMail .= 'Le recordamos que todos los 05 de cada mes, le llegará su facturación a este correo.<br/>';
	$BodyMail .= '<br/>';
	$BodyMail .= 'Muchas gracias por su atención.<br/>';
	$BodyMail .= 'Que tenga un excelente día.<br/>';
	$BodyMail .= 'Equipo Busafe.<br/>';
	$BodyMail .= '</p>';

	//Se verifica que existan datos
	if(isset($apo['EmpresaEmail'])&&$apo['EmpresaEmail']!=''&&isset($apo['email'])&&$apo['email']!=''&&isset($BodyMail)&&$BodyMail!=''){
		$rmail = tareas_envio_correo($apo['EmpresaEmail'], $apo['EmpresaNombre'], 
									$apo['email'], 'Receptor', 
									'', '', 
									'Recordatorio pago servicio Busafe '.fecha2NMes($SIS_Fecha).'/'.fecha2Ano($SIS_Fecha).'', 
									$BodyMail,'', 
									'', 
									1, 
									$apo['Gmail_Usuario'], 
									$apo['Gmail_Password']);
		//se guarda el log
		log_response(1, $rmail, $apo['email'].'(Asunto:Recordatorio pago servicio Busafe '.fecha2NMes($SIS_Fecha).'/'.fecha2Ano($SIS_Fecha).')');
	}
					
}
	
	
	
?>
