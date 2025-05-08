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

//variables
$SIS_idSistema            = 1;
$SIS_idUsuario            = 3;
$SIS_Fecha                = fecha_actual();
$SIS_Observaciones        = 'Facturacion Automatica';
$SIS_fCreacion            = fecha_actual();

/*******************************************************/
//traigo solo los apoderados con plan y cobro mensual
$SIS_query = '
apoderados_listado.idApoderado,
apoderados_listado.idPlan,
apoderados_listado.email,
apoderados_listado.Nombre,
apoderados_listado.ApellidoPat,
apoderados_listado.ApellidoMat,
sistema_planes_transporte.Nombre AS NombrePlan,
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
										
/************************************************************************************************************************/
//Se insertan los datos principales
if(isset($SIS_idSistema) && $SIS_idSistema!=''){    $a  = "'".$SIS_idSistema."'";    }else{$a  ="''";}
if(isset($SIS_idUsuario) && $SIS_idUsuario!=''){    $a .= ",'".$SIS_idUsuario."'";   }else{$a .=",''";}
if(isset($SIS_Fecha) && $SIS_Fecha!= ''){  
	$a .= ",'".$SIS_Fecha."'";  
	$a .= ",'".fecha2NMes($SIS_Fecha)."'";
	$a .= ",'".fecha2Ano($SIS_Fecha)."'";
}else{
	$a .= ",''";
	$a .= ",''";
	$a .= ",''";
}
if(isset($SIS_Observaciones) && $SIS_Observaciones!=''){    $a .= ",'".$SIS_Observaciones."'";   }else{$a .=",''";}
if(isset($SIS_fCreacion) && $SIS_fCreacion!=''){            $a .= ",'".$SIS_fCreacion."'";       }else{$a .=",''";}

// inserto los datos de registro en la db
$query  = "INSERT INTO `vehiculos_facturacion_apoderados_listado` (idSistema, idUsuario, Fecha, idMes, Ano, Observaciones, fCreacion) 
VALUES (".$a.")";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log('Cron', $Transaccion, 'cron', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
							
}else{
//recibo el último id generado por mi sesion
	$ultimo_id = mysqli_insert_id($dbConn);
					
	/*********************************************************************/
	//Se guardan los datos de los productos	
	foreach ($arrApoderado as $apo) {
		//Genero la consulta
		if(isset($ultimo_id) && $ultimo_id!=''){            $a  = "'".$ultimo_id."'";        }else{$a  ="''";}
		if(isset($SIS_idSistema) && $SIS_idSistema!=''){    $a .= ",'".$SIS_idSistema."'";   }else{$a .=",''";}
		if(isset($SIS_idUsuario) && $SIS_idUsuario!=''){    $a .= ",'".$SIS_idUsuario."'";   }else{$a .=",''";}
		if(isset($SIS_Fecha) && $SIS_Fecha!= ''){  
			$a .= ",'".$SIS_Fecha."'";  
			$a .= ",'".fecha2NMes($SIS_Fecha)."'";
			$a .= ",'".fecha2Ano($SIS_Fecha)."'";
		}else{
			$a .= ",''";
			$a .= ",''";
			$a .= ",''";
		}
		if(isset($SIS_fCreacion) && $SIS_fCreacion!=''){              $a .= ",'".$SIS_fCreacion."'";        }else{$a .=",''";}
		if(isset($apo['idApoderado']) && $apo['idApoderado']!=''){    $a .= ",'".$apo['idApoderado']."'";   }else{$a .=",''";}
		if(isset($apo['idPlan']) && $apo['idPlan']!=''){       $a .= ",'".$apo['idPlan']."'";        }else{$a .=",''";}
		if(isset($apo['MontoPactado']) && $apo['MontoPactado']!=''){  $a .= ",'".$apo['MontoPactado']."'";  }else{$a .=",''";}
		$a .= ",'1'";//Estado No Pagado
						
		//Guardo los datos
		$query  = "INSERT INTO `vehiculos_facturacion_apoderados_listado_detalle` (idFacturacion, idSistema, idUsuario, Fecha, idMes, Ano, fCreacion,
		idApoderado, idPlan, MontoPactado, idEstadoPago) 
		VALUES (".$a.")";
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		//Si ejecuto correctamente la consulta
		if(!$resultado){
			//variables
			$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

			//generar log
			php_error_log('Cron', $Transaccion, 'cron', mysqli_errno($dbConn), mysqli_error($dbConn), $query );

		}

		/***********************************************/
		//Cuerpo del correo
		$BodyMail  = '<p>';
		$BodyMail .= 'Estimado '.$apo['Nombre'].' '.$apo['ApellidoPat'].' '.$apo['ApellidoMat'].'<br/>';
		$BodyMail .= '<br/>';
		$BodyMail .= 'Su cuenta para el mes de '.fecha2NombreMes($SIS_Fecha).' de '.fecha2Ano($SIS_Fecha).', correspondiente al plan '.$apo['NombrePlan'].' por la cantidad de '.valores($apo['MontoPactado'], 0).', ya se encuentra disponible para pago, favor cancelar antes de la fecha limite 15-'.fecha2NombreMes($SIS_Fecha).'-'.fecha2Ano($SIS_Fecha).'.<br/>';
		$BodyMail .= '<br/>';
		$BodyMail .= 'Cualquier duda que tengas, comuncarse al correo contacto@busafe.cl<br/>';
		$BodyMail .= 'Sin otro particular, muchas gracias.<br/>';
		$BodyMail .= 'Se despide<br/>';
		$BodyMail .= 'Equipo Busafe<br/>';
		$BodyMail .= '</p>';

		//Se verifica que existan datos
		if(isset($apo['EmpresaEmail'])&&$apo['EmpresaEmail']!=''&&isset($apo['email'])&&$apo['email']!=''&&isset($BodyMail)&&$BodyMail!=''){
			$rmail = tareas_envio_correo($apo['EmpresaEmail'], $apo['EmpresaNombre'], 
										$apo['email'], 'Receptor', 
										'', '', 
										'Facturacion '.fecha2NMes($SIS_Fecha).'/'.fecha2Ano($SIS_Fecha).'', 
										$BodyMail,'', 
										'', 
										1, 
										$apo['Gmail_Usuario'], 
										$apo['Gmail_Password']);
			//se guarda el log
			log_response(1, $rmail, $apo['email'].'(Asunto:Facturacion '.fecha2NMes($SIS_Fecha).'/'.fecha2Ano($SIS_Fecha).')');
		}
		
								 
	}
					
}
	
	
	
?>
