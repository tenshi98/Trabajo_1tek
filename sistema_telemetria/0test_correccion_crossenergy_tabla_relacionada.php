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
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}

//config
$DB_table  = 'telemetria_listado_tablarelacionada_199';
$DB_INI    = 929716;
$DB_FIN    = 939716;

echo $DB_table.'<br/>';
echo $DB_INI.'<br/>';
echo $DB_FIN.'<br/>';

//Selecciono los datos desde la bd
$SIS_query = 'idTabla, Sensor_1, Sensor_2, Sensor_3, Sensor_4, Sensor_5, Sensor_6, Sensor_7';
$SIS_join  = '';
$SIS_where = '(idTabla BETWEEN '.$DB_INI.' AND '.$DB_FIN.')';
$SIS_order = 'idTabla ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, $DB_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, 'arrMediciones', basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

  
//Recorro		
foreach ($arrMediciones as $med) {

	$suma_1 = $med['Sensor_1']*$med['Sensor_7'];
	$suma_2 = $med['Sensor_2']*$med['Sensor_7'];
	$suma_3 = $med['Sensor_3']*$med['Sensor_7'];
	$suma_4 = $med['Sensor_4']*$med['Sensor_7'];
	$suma_5 = $med['Sensor_5']*$med['Sensor_7'];
	$suma_6 = $med['Sensor_6']*$med['Sensor_7'];

	$consumo  = ($suma_1+$suma_2+$suma_3+$suma_4+$suma_5+$suma_6)/1000;
	$Sensor_9 = floatval(number_format($consumo, 2, '.', ''));

	//datos
	$SIS_data = "Sensor_9='".$Sensor_9."'";

	/*******************************************************/
	//se actualizan los datos
	$resultado = db_update_data (false, $SIS_data, $DB_table, 'idTabla = "'.$med['idTabla'].'"', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');
				
	echo 'UPDATE `'.$DB_table.'` SET `Sensor_9`="'.$Sensor_9.'" WHERE (`idTabla`='.$med['idTabla'].');<br/>';
				
}	
	
	
	
	
?>
