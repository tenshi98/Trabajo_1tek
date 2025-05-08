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

//arreglo para los equipos
$arrEquipos = array();

//se listan los equipos
$arrEquipos[1]['Carpeta']    = 'camara2';
$arrEquipos[1]['Subcarpeta'] = '/192.168.0.50';// poner separador al principio
$arrEquipos[1]['Fecha']      = fecha_actual(); //Formato cambia segun configuracion equipo
$arrEquipos[1]['pos1']       = 13; //posicion de inicio de la fecha desde
$arrEquipos[1]['pos2']       = 28; //posicion de inicio de la fecha hasta

//Total de equipos a recorrer
$N_Equipos = 1;

//se recorren los equipos
for ($i = 1; $i <= $N_Equipos; $i++) {

	//Ubicación de la carpeta
	$Ubication    = '/home/crosstech/public_html/power_engine/sistema_intranet_crosstech/ClientFiles/_data/'.$arrEquipos[$i]['Carpeta'].$arrEquipos[$i]['Subcarpeta'].'/'.$arrEquipos[$i]['Fecha'].'/';

	//se abre y se recorren los archivos
	$thefolder = $Ubication;
	if ($handler = opendir($thefolder)){
		
		while (false !== ($file = readdir($handler))){
			if (!in_array($file,array(".",".."))){ 
				
				//verifico que la extension sea dav
				$extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
				if($extension=='dav'){
					//desde
					$data1  = substr($file, $arrEquipos[$i]['pos1'], 14);
					$fecha1 = substr($data1, 0, 8);
					$hora1  = substr($data1, 8, 4);
					//hasta
					$data2  = substr($file, $arrEquipos[$i]['pos2'], 14);
					$fecha2 = substr($data2, 0, 8);
					$hora2  = substr($data2, 8, 4);

					//ubicaciones de los archivos
					$FileOriginal = $Ubication.$file;

					//Nombre de salida del archivo
					$FileFinal    = $Ubication.$fecha1.'_'.$hora1.'-'.$fecha2.'_'.$hora2.'.mp4';

					//se transforma y se crea archivo
					/*$cmd = 'ffmpeg -y -i '.$FileOriginal.' -vcodec libx264 -crf 24 '.$FileFinal;
					shell_exec($cmd);

					//se elimina archivo
					try {
						if(!is_writable($FileOriginal)){
							//throw new Exception('File not writable');
						}else{
							unlink($FileOriginal);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}*/
					
					echo 'Archivo '.$file.' / '.$fecha1.'_'.$hora1.'-'.$fecha2.'_'.$hora2.'<br/>';
				}
			}   
		}
		//se cierra directorio
		closedir($handler);
	}
   
}

	
?>
