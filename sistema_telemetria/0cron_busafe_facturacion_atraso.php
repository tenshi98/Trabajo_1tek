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

/*******************************************************/
//Consulto las facturaciones pendientes de pago
$SIS_query = '
COUNT(vehiculos_facturacion_apoderados_listado_detalle.idFacturacionDetalle) AS NAtrasos,
apoderados_listado.email,
apoderados_listado.Nombre,
apoderados_listado.ApellidoPat,
apoderados_listado.ApellidoMat,
sistema_planes_transporte.Nombre AS NombrePlan,
sistema_planes_transporte.Valor_Mensual AS MontoPactado,
core_sistemas.Nombre AS EmpresaNombre,
core_sistemas.email_principal AS EmpresaEmail, 
core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
core_sistemas.Config_Gmail_Password AS Gmail_Password';
$SIS_join  = '
LEFT JOIN `apoderados_listado`         ON apoderados_listado.idApoderado    = vehiculos_facturacion_apoderados_listado_detalle.idApoderado
LEFT JOIN `sistema_planes_transporte`  ON sistema_planes_transporte.idPlan  = apoderados_listado.idPlan
LEFT JOIN `core_sistemas`              ON core_sistemas.idSistema           = apoderados_listado.idSistema';
$SIS_where = 'vehiculos_facturacion_apoderados_listado_detalle.idEstadoPago = 1
GROUP BY vehiculos_facturacion_apoderados_listado_detalle.idApoderado';
$SIS_order = 0;
$arrFactPendientes = array();
$arrFactPendientes = db_select_array (false, $SIS_query, 'vehiculos_facturacion_apoderados_listado_detalle', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

//Recorro los datos	
foreach ($arrFactPendientes as $pend) {
		
	//Defino el cuerpo por el numero de atrasos
	switch ($pend['NAtrasos']) {
		case 1:
			//Cuerpo del correo
			$BodyMail  = '<p>';
			$BodyMail .= 'Estimado '.$pend['Nombre'].' '.$pend['ApellidoPat'].' '.$pend['ApellidoMat'].'<br/>';
			$BodyMail .= '<br/>';
			$BodyMail .= 'Junto con saludar, nos dirigimos a usted para entregar la siguiente información. Al día de hoy, presenta un pago pendiente de la mensualidad correspondiente al mes de '.fecha2NMes($SIS_Fecha).'/'.fecha2Ano($SIS_Fecha).'.<br/>';
			$BodyMail .= '<br/>';
			$BodyMail .= 'Detalle:<br/>';
			$BodyMail .= '<strong>Plan:</strong>'.$pend['NombrePlan'].'<br/>';
			$BodyMail .= '<strong>Monto:</strong>'.valores($pend['MontoPactado'], 0).'<br/>';
			$BodyMail .= '<br/>';
			$BodyMail .= 'Favor realizar el pago a traves de la pagina principal.<br/>';
			$BodyMail .= 'En caso de ya haber actualizado su pago, haga caso omiso a este correo, o bien contáctese con nosotros al correo contacto@busafe.cl <br/>';
			$BodyMail .= '<br/>';
			$BodyMail .= 'Sin otro particular, muchas gracias.<br/>';
			$BodyMail .= 'Se despide<br/>';
			$BodyMail .= 'Equipo Busafe<br/>';
			$BodyMail .= '</p>';

			//envio el correo	
			if(isset($pend['EmpresaEmail'])&&$pend['EmpresaEmail']!=''&&isset($pend['email'])&&$pend['email']!=''&&isset($BodyMail)&&$BodyMail!=''){
				$rmail = tareas_envio_correo($pend['EmpresaEmail'], $pend['EmpresaNombre'], 
											$pend['email'], 'Receptor', 
											'', '', 
											'Pago pendiente servicio Busafe – Monitoreo transporte escolar', 
											$BodyMail,'', 
											'', 
											1, 
											$pend['Gmail_Usuario'], 
											$pend['Gmail_Password']);
				//se guarda el log
				log_response(1, $rmail, $pend['email'].'(Asunto:Pago pendiente servicio Busafe – Monitoreo transporte escolar)');
			}
			break;

	}
	
		
}
	
	
		
	
?>
