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
//Tiempo Maximo de la consulta. 40 minutos por defecto
set_time_limit(2400);
//Memora RAM Maxima del servidor. 4GB por defecto
ini_set('memory_limit', '4096M');
/**********************************************************************************************************************************/
/*                                                    Crear Arreglo                                                               */
/**********************************************************************************************************************************/

/*******************************/
//Datos
$idTelemetria  = 199;
$Identificador = 199;
$FechaSistema  = fecha_actual();
$HoraSistema   = hora_actual();
$HoraAnterior1  = restahoras('00:00:10',hora_actual() );//ultimos 20 segundos
$HoraAnterior2  = restahoras('00:00:10',$HoraAnterior1 );//ultimos 20 segundos
$HoraAnterior3  = restahoras('00:00:10',$HoraAnterior2 );//ultimos 20 segundos
$HoraAnterior4  = restahoras('00:00:10',$HoraAnterior3 );//ultimos 20 segundos
$HoraAnterior5  = restahoras('00:00:10',$HoraAnterior4 );//ultimos 20 segundos
$HoraAnterior6  = restahoras('00:00:10',$HoraAnterior5 );//ultimos 20 segundos

/*******************************/
//Bloque de datos
$HoraBloque[1]['inicio'] = $HoraAnterior6;
$HoraBloque[1]['fin']    = $HoraAnterior5;
$HoraBloque[2]['inicio'] = $HoraAnterior5;
$HoraBloque[2]['fin']    = $HoraAnterior4;
$HoraBloque[3]['inicio'] = $HoraAnterior4;
$HoraBloque[3]['fin']    = $HoraAnterior3;
$HoraBloque[4]['inicio'] = $HoraAnterior3;
$HoraBloque[4]['fin']    = $HoraAnterior2;
$HoraBloque[5]['inicio'] = $HoraAnterior2;
$HoraBloque[5]['fin']    = $HoraAnterior1;
$HoraBloque[6]['inicio'] = $HoraAnterior1;
$HoraBloque[6]['fin']    = $HoraSistema;

/*************************************************/
//Funcion para envio de datos
function curl_do_api($url){
	if (!function_exists('curl_init')){
		//die('Sorry cURL is not installed!');
		//si no esta instalado muestra un error
		error_log("========================================================================================================================================", 0);
		error_log("cURL no esta instalado", 0);
		error_log("-------------------------------------------------------------------", 0);
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

/*******************************/
//Recorro 6 veces
for ($i = 1; $i <= 6; $i++) {

	/*******************************/
	//Consulto
	$SIS_query = 'idTabla, Segundos, Diferencia, Sensor_1, Sensor_2, Sensor_3, Sensor_4, Sensor_5, Sensor_6, Sensor_7, Sensor_8';
	$SIS_join  = '';
	$SIS_where = 'FechaSistema = "2023-01-02"';
	$SIS_where.= ' AND HoraSistema BETWEEN "'.$HoraBloque[$i]['inicio'].'" AND "'.$HoraBloque[$i]['fin'].'"';
	$SIS_where.= ' ORDER BY idTabla DESC';
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_tablarelacionada_199',$SIS_join, $SIS_where, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

	/*******************************/
	//Si existen datos
	if(isset($rowData['idTabla'])&&$rowData['idTabla']!=''){
		/*******************************/
		//Armo datos
		if(isset($rowData['Sensor_1'])&&$rowData['Sensor_1']!=0){ $Sensor_1 = $rowData['Sensor_1'] + (rand(-50, 100) / 10);}else{$Sensor_1 = 0;} //Fase R Corriete
		if(isset($rowData['Sensor_2'])&&$rowData['Sensor_2']!=0){ $Sensor_2 = $rowData['Sensor_2'] + (rand(-50, 100) / 10);}else{$Sensor_2 = 0;} //Fase S Corriete
		if(isset($rowData['Sensor_3'])&&$rowData['Sensor_3']!=0){ $Sensor_3 = $rowData['Sensor_3'] + (rand(-50, 100) / 10);}else{$Sensor_3 = 0;} //Fase T  Corriete
		if(isset($rowData['Sensor_4'])&&$rowData['Sensor_4']!=0){ $Sensor_4 = $rowData['Sensor_4'] + (rand(-50, 100) / 10);}else{$Sensor_4 = 0;} //Fase R Voltaje
		if(isset($rowData['Sensor_5'])&&$rowData['Sensor_5']!=0){ $Sensor_5 = $rowData['Sensor_5'] + (rand(-50, 100) / 10);}else{$Sensor_5 = 0;} //Fase S Voltaje
		if(isset($rowData['Sensor_6'])&&$rowData['Sensor_6']!=0){ $Sensor_6 = $rowData['Sensor_6'] + (rand(-50, 100) / 10);}else{$Sensor_6 = 0;} //Fase T Voltaje
		if(isset($rowData['Sensor_7'])&&$rowData['Sensor_7']!=0){ $Sensor_7 = $rowData['Sensor_7'] + (rand(-20, 20) / 10);}else{$Sensor_7 = 0;} //Voltaje Trifasico
		if(isset($rowData['Sensor_8'])&&$rowData['Sensor_8']!=0){ $Sensor_8 = $rowData['Sensor_8'] + (rand(-20, 20) / 10);}else{$Sensor_8 = 0;} //Volt
		//if(isset($rowData['Sensor_9'])&&$rowData['Sensor_9']!=0){ $Sensor_9 = $rowData['Sensor_9'] + (rand(-20, 20) / 10);}else{$Sensor_9 = 0;} //Potencia Instantanea
		/*******************************/
		//Corrijo en caso de negativo
		if($Sensor_1<0){$Sensor_1 = 0;}
		if($Sensor_2<0){$Sensor_2 = 0;}
		if($Sensor_3<0){$Sensor_3 = 0;}
		if($Sensor_4<0){$Sensor_4 = 0;}
		if($Sensor_5<0){$Sensor_5 = 0;}
		if($Sensor_6<0){$Sensor_6 = 0;}
		if($Sensor_7<0){$Sensor_7 = 0;}
		if($Sensor_8<0){$Sensor_8 = 0;}
		//if($Sensor_9<0){$Sensor_9 = 0;}
		/*******************************/
		//realizo calculo de Potencia Instantanea
		$consumo=(($Sensor_1*$Sensor_7) + ($Sensor_2*$Sensor_7) + ($Sensor_3*$Sensor_7) + ($Sensor_4*$Sensor_7) + ($Sensor_5*$Sensor_7) + ($Sensor_6*$Sensor_7))/1000;
		$Sensor_9 = floatval(number_format($consumo, 2, '.', ''));

		/*************************************************/
		//Se crea la dirección de envio de datos
		$envio  = 'http://webapp.1tek.cl/crosstech/ardu.php';
		$envio .= '?id='.$Identificador;
		$envio .= '&f='.$FechaSistema;
		$envio .= '&h='.$HoraBloque[$i]['fin'];
		$envio .= '&s1='.$Sensor_1;
		$envio .= '&s2='.$Sensor_2;
		$envio .= '&s3='.$Sensor_3;
		$envio .= '&s4='.$Sensor_4;
		$envio .= '&s5='.$Sensor_5;
		$envio .= '&s6='.$Sensor_6;
		$envio .= '&s7='.$Sensor_7;
		$envio .= '&s8='.$Sensor_8;
		$envio .= '&s9='.$Sensor_9;

		/*************************************************/
		//Se envian los datos
		curl_do_api($envio);
		//error_log($envio, 0);
		//echo $envio.'<br/>';
	}

}



?>
