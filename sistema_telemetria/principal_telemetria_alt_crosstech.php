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
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Session.php';                  //verificacion sesion usuario


echo '<span class="panel-title"  style="color: #1E90FF;font-weight: 700 !important;">Hora Refresco: '.hora_actual().'</span>';

echo widget_Equipos_Crosstech('Equipos Telemetria', 2, 0,$_GET['trans_9'], $_GET['idSistema'],
								$_GET['idTipoUsuario'],
								$_GET['idUsuario'], $dbConn);
echo widget_Promedios_equipo_grupos_Crosstech('Mediciones Promedios Actuales', 2, 0, 0, 
												$_GET['idSistema'],
												$_GET['idTipoUsuario'],
												$_GET['idUsuario'], $dbConn);
	
			

		
?>
