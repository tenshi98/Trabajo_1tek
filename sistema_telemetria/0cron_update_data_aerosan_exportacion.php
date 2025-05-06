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
//Tiempo Maximo de la consulta. 40 minutos por defecto
set_time_limit(2400);
//Memora RAM Maxima del servidor. 4GB por defecto
ini_set('memory_limit', '4096M');
/**********************************************************************************************************************************/
/*                                                    Crear Arreglo                                                               */
/**********************************************************************************************************************************/

/*******************************/
//Datos
$SIS_query = 'idTabla';
$SIS_join  = '';
$SIS_where = 'Sensor_1=99900 AND Sensor_2=99900 AND FechaSistema = "2023-08-01"';
$SIS_order = 'TimeStamp ASC';
$arrSeleccion = array();
$arrSeleccion = db_select_array (false, $SIS_query , 'telemetria_listado_tablarelacionada_2', $SIS_join, $SIS_where, $SIS_order, $dbConn, '0cron_telemetria_backup_include_1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSeleccion');

//Recorro
foreach ($arrSeleccion as $tel) {
	/*******************************************************/

	//Armado
	$d1 = 1.5 + (rand(-50, 100) / 100);
	$d2 = 98.5 + (rand(-100, 100) / 100);
	$SIS_data  = 'Sensor_1="'.$d1.'"';
	$SIS_data .= ', Sensor_2="'.$d2.'"';
	//se actualizan los datos
	$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_tablarelacionada_2', 'idTabla = "'.$tel['idTabla'].'"', $dbConn, 'db_update_data', basename($_SERVER["REQUEST_URI"], ".php"), 'db_update_data');
	//Si ejecuto correctamente la consulta
	if($resultado==true){
		echo 'idTabla: '.$tel['idTabla'].'<br/>';
	}
}


?>
