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
/*                                                     Ejecucion codigo                                                           */
/**********************************************************************************************************************************/
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                  //Configuracion de la plataforma
require_once '../Legacy/1tek_public/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/1tek_public/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Session.php';                  //verificacion sesion usuario



echo '<span class="panel-title"  style="color: #1E90FF;font-weight: 700 !important;">Hora Refresco: '.hora_actual().'</span>';
		
//Tiempo de actualizacion interna de los widget
$x_seg = $_GET['x_seg'];

//recorro
switch ($_GET['idOpcionesTel']) {
	/*****************************************************/
	//Si no esta configurado
	case 0:
		echo widget_GPS_equipos('Equipos Telemetria','Equipos', 2, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $_GET['trans_8'], 
				$_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Detalle por GPS
	case 1:
		echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_Resumen_GPS_equipos('Vehiculos', 1, $_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'],$dbConn);
	break;
	/*****************************************************/
	//Lista Equipos
	case 2:
		echo widget_GPS_equipos('Equipos Fijos','Fijos', 2, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $_GET['trans_8'], 
				$_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Detalle por Equipos
	case 3:
		echo widget_Equipos('Equipos Telemetria', 2, 0,$_GET['trans_9'], $_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'], $dbConn);
		echo widget_Resumen_equipo('Ultimas Mediciones', 2, 0, 0, 
			$_GET['idSistema'],
			$_GET['idTipoUsuario'],
			$_GET['idUsuario'], $dbConn);
	break;	
	/*****************************************************/
	//Lista GPS
	case 4:
		echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_GPS_lista('Ultimas Mediciones', 1, 0, $_GET['trans_8'], 
				  $_GET['idSistema'],
				  $_GET['idTipoUsuario'],
				  $_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Detalle por GPS y Detalle por Equipos
	case 5:
		//Detalle por GPS
		echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_Resumen_GPS_equipos('Vehiculos', 1, $_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'],$dbConn);
		//Detalle por Equipos
		echo widget_Equipos('Equipos Telemetria', 2, 0,$_GET['trans_9'], $_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'], $dbConn);
		echo widget_Resumen_equipo('Ultimas Mediciones', 2, 0, 0, 
			$_GET['idSistema'],
			$_GET['idTipoUsuario'],
			$_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Detalle por GPS y Lista Equipos
	case 6:
		//Detalle por GPS
		echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_Resumen_GPS_equipos('Vehiculos', 1, $_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'],$dbConn);
		//Lista Equipos
		echo widget_GPS_equipos('Equipos Fijos','Fijos', 2, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $_GET['trans_8'], 
				$_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Lista GPS y Detalle por Equipos
	case 7:
		//Lista GPS
		echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_GPS_lista('Ultimas Mediciones', 1, 0, $_GET['trans_8'], 
				  $_GET['idSistema'],
				  $_GET['idTipoUsuario'],
				  $_GET['idUsuario'], $dbConn);
		//Detalle por Equipos
		echo widget_Equipos('Equipos Telemetria', 2, 0,$_GET['trans_9'], $_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'], $dbConn);
		echo widget_Resumen_equipo('Ultimas Mediciones', 2, 0, 0, 
			$_GET['idSistema'],
			$_GET['idTipoUsuario'],
			$_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Lista GPS y Lista Equipos
	case 8:
		//Lista GPS
		echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_GPS_lista('Ultimas Mediciones', 1, 0, $_GET['trans_8'], 
				  $_GET['idSistema'],
				  $_GET['idTipoUsuario'],
				  $_GET['idUsuario'], $dbConn);
		//Lista Equipos
		echo widget_GPS_equipos('Equipos Fijos','Fijos', 2, 2, $_GET['idSistema'], 
					$_GET['Config_IDGoogle'],
					$_GET['idTipoUsuario'],
					$_GET['idUsuario'],$dbConn);
		echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $_GET['trans_8'], 
				$_GET['idSistema'],
				$_GET['idTipoUsuario'],
				$_GET['idUsuario'], $dbConn);	  
	break;
	/*****************************************************/
	//Detalle por Equipos
	case 9:
		echo widget_Equipos('Equipos Telemetria', 2, 0,$_GET['trans_9'], $_GET['idSistema'],
							$_GET['idTipoUsuario'],
							$_GET['idUsuario'], $dbConn);
		echo widget_Promedios_equipo('Mediciones Promedios Actuales', 2, 0, 0, 
									$_GET['idSistema'],
									$_GET['idTipoUsuario'],
									$_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Detalle por Equipos grupos
	case 10:
		echo widget_Equipos('Equipos Telemetria', 2, 0,$_GET['trans_9'], $_GET['idSistema'],
							$_GET['idTipoUsuario'],
							$_GET['idUsuario'], $dbConn);
		echo widget_Promedios_equipo_grupos('Mediciones Promedios Actuales', 2, 0, 0, 
											$_GET['idSistema'],
											$_GET['idTipoUsuario'],
											$_GET['idUsuario'], $dbConn);
	break;
	/*****************************************************/
	//Gestion de Flota
	case 11:
		echo widget_Gestion_Flota('Gestion de Flota',
								$_GET['idSistema'], 
								$_GET['Config_IDGoogle'],
								$_GET['idTipoUsuario'],
								$_GET['idUsuario'],
								$x_seg,
								$dbConn);	
	break;
	/*****************************************************/
	//Gestion de Equipos
	case 12:
		echo widget_Gestion_Equipos('Gestion de Equipos',
									$_GET['idSistema'], 
									$_GET['Config_IDGoogle'],
									$_GET['idTipoUsuario'],
									$_GET['idUsuario'],
									$x_seg,
									$dbConn);	
	break;
	
	
	
	
	
}
			

		
?>
