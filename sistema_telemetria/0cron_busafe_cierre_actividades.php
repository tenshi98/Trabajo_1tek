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
$SIS_idSistema      = 1;
$SIS_idUsuario      = 3;
$SIS_Observaciones  = 'Cierre de Actividades';
$SIS_fCierre        = fecha_actual();

/*******************************************************/
// consulto los datos
$SIS_query = '
apoderados_listado.idApoderado,
apoderados_listado.idPlan,
apoderados_listado.email,
sistema_planes_transporte.Valor_Mensual AS MontoPactado,
core_sistemas.Nombre AS EmpresaNombre,
core_sistemas.email_principal AS EmpresaEmail, 
core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
core_sistemas.Config_Gmail_Password AS Gmail_Password';
$SIS_join  = '
LEFT JOIN `sistema_planes_transporte`  ON sistema_planes_transporte.idPlan  = apoderados_listado.idPlan
LEFT JOIN `core_sistemas`              ON core_sistemas.idSistema           = apoderados_listado.idSistema';
$SIS_where = 'apoderados_listado.idSistema = '.$SIS_idSistema.' 
AND apoderados_listado.idEstado = 1
AND apoderados_listado.idPlan != 0 
AND apoderados_listado.idCobro = 1';
$SIS_order = 0;
$arrApoderado = array();
$arrApoderado = db_select_array (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');	

foreach ($arrApoderado as $apo) {
	/***********************************************/
	//Envio de correo
	$BodyMail = '';
	//Se verifica que existan datos
	if(isset($apo['EmpresaEmail'], $apo['email'], $BodyMail)&&$apo['EmpresaEmail']!=''&&$apo['email']!=''&&$BodyMail!=''){
		$rmail = tareas_envio_correo($apo['EmpresaEmail'], $apo['EmpresaNombre'], 
									$apo['email'], 'Receptor', 
									'', '', 
									'Termino de Contrato', 
									$BodyMail,'', 
									'', 
									1, 
									$apo['Gmail_Usuario'], 
									$apo['Gmail_Password']);
		//se guarda el log
		log_response(1, $rmail, $apo['email'].'(Asunto:Termino de Contrato)');							
	}

}
/********************************************************/
//deshabilito todos los planes de todos los apoderados
$a  = "idEstado='2'";
$a .= ",fCierre='".$SIS_fCierre."'";
$a .= ",idUsuarioCierre='".$SIS_idUsuario."'";
$a .= ",Observaciones='".$SIS_Observaciones."'";
							
// inserto los datos de registro en la db
$query  = "UPDATE `apoderados_listado_planes_contratados` SET ".$a." WHERE idEstado='1'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){

	//variables
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log('Cron', $Transaccion, 'cron', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
					
}

/********************************************************/
//Elimino todos los planes de los apoderados
$a  = "idPlan=''";
$a .= ",idCobro=''";
							
// inserto los datos de registro en la db
$query  = "UPDATE `apoderados_listado` SET ".$a." 
WHERE apoderados_listado.idSistema = '".$SIS_idSistema."' 
AND apoderados_listado.idEstado = 1
AND apoderados_listado.idPlan != 0 
AND apoderados_listado.idCobro = 1";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){

	//variables
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log('Cron', $Transaccion, 'cron', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
						
}	
	
?>
