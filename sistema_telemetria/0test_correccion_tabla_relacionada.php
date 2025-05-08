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
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}

//config
$DB_table  = 'telemetria_listado_tablarelacionada_199';
$DB_INI    = 6125410;
$DB_FIN    = 6128811;

echo $DB_table.'<br/>';
echo $DB_INI.'<br/>';
echo $DB_FIN.'<br/>';

//Selecciono los datos desde la bd
$SIS_query = 'idTabla, FechaSistema, HoraSistema';
$SIS_join  = '';
$SIS_where = '(idTabla BETWEEN '.$DB_INI.' AND '.$DB_FIN.')';
$SIS_order = 'idTabla ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, $DB_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, 'arrMediciones', basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

$diaInicio = '';
$horaInicio = '';

//Recorro
foreach ($arrMediciones as $med) {

	//verifico
	if($diaInicio!=''&&$horaInicio!=''){
		//variables
		$diaTermino  = $med['FechaSistema'];
		$horaTermino = $med['HoraSistema'];

		$HorasTrans  = horas_transcurridas($diaInicio, $diaTermino, $horaInicio, $horaTermino);
		$SegTrans    = horas2segundos($HorasTrans);//Obtengo el tiempo transcurrido

		//datos
		$SIS_data = "Segundos='".$SegTrans."'";

		/*******************************************************/
		//se actualizan los datos
		$resultado = db_update_data (false, $SIS_data, $DB_table, 'idTabla = "'.$med['idTabla'].'"', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

		echo 'UPDATE `'.$DB_table.'` SET `Segundos`="'.$SegTrans.'" WHERE (`idTabla`='.$med['idTabla'].');<br/>';
	}
	//variables
	$diaInicio  = $med['FechaSistema'];
	$horaInicio = $med['HoraSistema'];

}

?>
