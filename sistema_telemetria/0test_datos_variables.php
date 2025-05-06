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


			
//Configuracion del sistema a correr el cron
$SISTEMA = 1;

//si se ha ingresado el isistema	
if(isset($SISTEMA)&&$SISTEMA!=''){

	//Variables
	$Max_Sensores  = 60;                                       //Maximo de sensores a revisar
	$TablaSelect   = 'telemetria_listado_tablarelacionada_1';
	$Rango_inicio  = 1;                                        //desde donde revisar
	$Rango_termino = 1000;                                     //hasta donde revisar
	$Sensor        = array();

	//los datos solicitados
	$subquery = ',FechaSistema, HoraSistema';	
	for ($i = 1; $i <= $Max_Sensores; $i++) {
		$subquery .= ',Sensor_'.$i;
	}

	/*************************************************************/
	//Obtengo los datos de la tabla
	$SIS_query = 'idTabla '.$subquery;
	$SIS_join  = '';
	$SIS_where = 'idTabla BETWEEN '.$Rango_inicio.' AND '.$Rango_termino;
	$SIS_order = 'idTabla ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, $TablaSelect, $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	//declaro los sensores en 0 solo para el primer inicio
	for ($i = 1; $i <= $Max_Sensores; $i++) {
		$Sensor[$i]['valor'] = 0;
	}

	/*************************************************************/
	//se recorren datos
	foreach ($arrEquipo as $data) {

		//variables
		$a  = "idTabla='".$data['idTabla']."'";
		$a .= ",FechaSistema='".$data['FechaSistema']."'";
		$a .= ",HoraSistema='".$data['HoraSistema']."'";

		$ncount = 0;
		/*******************************************************/
		//recorro todos los sensores configurados
		for ($i = 1; $i <= $Max_Sensores; $i++) {
			//Solo si el sensor no marca error
			if(isset($Sensor[$i]['valor'])&&$Sensor[$i]['valor']!=0&&$Sensor[$i]['valor']<99900){
				//obtengo la diferencia
				$corr_dif = $Sensor[$i]['valor'] - $data['Sensor_'.$i];
				//solo si la diferencia es positiva
				if($corr_dif>0){
					//obtengo el porcentaje
					$corr_porc            = 10;
					$corr_porc_valor      = ($data['Sensor_'.$i]/100)*$corr_porc;
					$corr_porc_comparador = $data['Sensor_'.$i] + $corr_porc_valor;
					//comparo cual es mayor
					if($Sensor[$i]['valor']>$corr_porc_comparador){
						//cambio el valor por uno predefinido
						$a .= ",Sensor_".$i."='".$corr_porc_comparador."'";
						$ncount++;
					}
				}
			}
			//actualizo el valor del sensor
			$Sensor[$i]['valor'] = $data['Sensor_'.$i];
		}

		//si hay datos que cambiar
		if(isset($ncount)&&$ncount!=0){
			//genero la consulta
			$query  = "UPDATE `".$TablaSelect."` SET ".$a." WHERE idTabla = '".$data['idTabla']."'";

			//la muestyro
			echo $query.'<br/>';

			//Consulta
			//$resultado = mysqli_query ($dbConn, $query);
		}
	}
}
	
	
	
	
	
?>
