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

//Permiso concedido
$transaccion      = '';//Transaccion que los usuarios deben tener permiso
$CorreoInterno    = '';//Correo de la empresa
$RazonSocial      = '';//Nombre de la empresa
$Gmail_Usuario    = '';//Nombre de la empresa
$Gmail_Password   = '';//Nombre de la empresa
//Validar que exista
if(isset($transaccion)&&$transaccion!=''&&isset($CorreoInterno)&&$CorreoInterno!=''&&isset($RazonSocial)&&$RazonSocial!=''){
	/*******************************************************/
	//Verificar quienes tienen acceso a las transacciones
	$SIS_query = '
	usuarios_listado.usuario AS UsuarioNick,
	usuarios_listado.email AS UsuarioNombre,
	usuarios_listado.Nombre AS UsuarioEmail';
	$SIS_join  = '
	INNER JOIN `usuarios_permisos`  ON usuarios_permisos.idAdmpm    = core_permisos_listado.idAdmpm
	LEFT JOIN `usuarios_listado`    ON usuarios_listado.idUsuario   = usuarios_permisos.idUsuario';
	$SIS_where = 'core_permisos_listado.Direccionbase='.$transaccion;
	$SIS_order = 0;
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrPermisos');

	/*******************************************************/
	//Listado de solicitudes ejecutadas
	$SIS_query = 'idSolicitud';
	$SIS_join  = '';
	$SIS_where = 'idEstado=3';
	$SIS_order = 0;
	$arrSolicitudes = array();
	$arrSolicitudes = db_select_array (false, $SIS_query,'cross_solicitud_aplicacion_listado',$SIS_join,$SIS_where,$SIS_order,$dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

	/*******************************************************/
	//Creacion cuerpo del mensaje
	$xbody = '
	<h3>Notificación de cierre de solicitudes</h3>
	<p>Las siguientes solicitudes han sido cerradas</p>';
	foreach ($arrSolicitudes as $sol) {
		$xbody .= '<a href="'.DB_SITE_MAIN.'/informe_cross_checking_05.php?idSolicitud='.$sol['idSolicitud'].'&submit_filter=Filtrar">Solicitud '.n_doc($sol['idSolicitud'], 5).'</a>';
	}

	/*******************************************************/
	//Notificaciones a los correos
	foreach ($arrPermisos as $correo) {
		/*******************/
		//Envio de correo
		$rmail = tareas_envio_correo($CorreoInterno, $RazonSocial, 
									$correo['UsuarioEmail'], $correo['UsuarioNombre'], 
									'', '', 
									'Notificación Solicitudes', 
									$xbody,'', 
									'',
									1, 
									$Gmail_Usuario, 
									$Gmail_Password);
		//se guarda el log
		log_response(1, $rmail, $correo['UsuarioEmail'].'(Asunto:Notificación Solicitudes)');														
									 
		//Envio del mensaje
		if ($rmail!=1) {
			//echo "Mailer Error: " . $rmail;
		} else {
			//echo "Message sent!";
		}
	}
}


	
	
	
	
	
?>
