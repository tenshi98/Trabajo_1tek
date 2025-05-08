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

//Funcion para saber si esta o no dentro de un area
function inLocationPoint($arrINZonas, $point, $GeoLatitud, $GeoLongitud){
	//variable
	$nx = 0;
	//recorro las areas
	foreach ($arrINZonas as $todaszonas=>$zonas) {
		//arreglo para el pligono
		$polygon = array();
		//variables para cerrar el poligono
		$ini     = 0;
		$f_lat   = 0;
		$f_long  = 0;
		//recorro las zonas
		foreach ($zonas as $puntos) {
			array_push( $polygon,$puntos['Latitud'].' '.$puntos['Longitud'] );
			//si es el primer dato
			if($ini==0){
				$f_lat  = $puntos['Latitud'];
				$f_long = $puntos['Longitud'];
			}
			$ini++;
		}
		//inserto el primer dato como el ultimo para cerrar poligono
		array_push( $polygon,$f_lat.' '.$f_long );
		//verifico
		$c_chek =  $point->pointInPolygon($GeoLatitud.' '.$GeoLongitud, $polygon);
		//si esta dentro de la zona
		if($c_chek=='inside'){
			if($nx==0){
				$nx = $todaszonas;
			}
		}
	}
	//devuelvo
	return $nx;
}

//config
$DB_table  = 'telemetria_listado_tablarelacionada_64';
$DB_INI    = 50000;
$DB_FIN    = 60000;
$idSistema = 29;

echo $DB_table.'<br/>';
echo $DB_INI.'<br/>';
echo $DB_FIN.'<br/>';

//Selecciono los datos desde la bd
$SIS_query = 'idTabla, GeoLatitud, GeoLongitud';
$SIS_join  = '';
$SIS_where = '(idTabla BETWEEN '.$DB_INI.' AND '.$DB_FIN.') AND idZona = 0 AND idSolicitud=0 AND (Sensor_1!=0 OR Sensor_2!=0) AND GeoLatitud!=0 AND GeoLongitud!=0';
$SIS_order = 'idTabla ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, $DB_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, 'arrMediciones', basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

//Se traen las zonas
$arrZonas = array();
$arrZonas = db_select_array (false, 'cross_predios_listado_zonas.idZona,cross_predios_listado_zonas_ubicaciones.Latitud,cross_predios_listado_zonas_ubicaciones.Longitud', 'cross_predios_listado_zonas', 'LEFT JOIN `cross_predios_listado_zonas_ubicaciones` ON cross_predios_listado_zonas_ubicaciones.idZona = cross_predios_listado_zonas.idZona LEFT JOIN `cross_predios_listado` ON cross_predios_listado.idPredio = cross_predios_listado_zonas.idPredio', 'cross_predios_listado.idSistema ='.$idSistema, 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC', $dbConn, 'arrZonas', basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');

//se filtran las zonas
filtrar($arrZonas, 'idZona');
//se llama al modulo
$pointLocation = new subpointLocation();

  
//Recorro		
foreach ($arrMediciones as $med) {

	//variable
	$nx_UsoPredio = 0;

	//verifico si esta dentro	
	$nx_UsoPredio = inLocationPoint($arrZonas, $pointLocation, $med['GeoLatitud'], $med['GeoLongitud']);
		
	if($nx_UsoPredio!=0){
		//Filtros
		$a = "idZona='".$nx_UsoPredio."'";

		/*******************************************************/
		//se actualizan los datos
		$resultado = db_update_data (false, $a, $DB_table, 'idTabla = "'.$med['idTabla'].'"', $dbConn, 'db_update_data', basename($_SERVER["REQUEST_URI"], ".php"), 'db_update_data');

	}
}	
	
	
	
	
?>
