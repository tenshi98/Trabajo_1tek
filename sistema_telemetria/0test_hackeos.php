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

$sesion_usuario          = 'Ninguno';
$sesion_fecha            = fecha_actual();
$sesion_hora             = hora_actual();
$sesion_IP_Client        = obtenerIpCliente();
$sesion_Agent_Transp     = obtenerSistOperativo().' - '.obtenerNavegador();
$sesion_email_principal  = DB_EMPRESA_MAIL;
$sesion_error_email      = DB_ERROR_MAIL;
$sesion_RazonSocial      = DB_EMPRESA_NAME;		
$sesion_Empresa          = DB_SOFT_NAME;
$sesion_Gmail_User       = DB_GMAIL_USER;
$sesion_Gmail_Password   = DB_GMAIL_PASSWORD;
$sesion_N_Hacks          = 5;
$sesion_archivo          = 'Ninguno';
$sesion_tarea            = 'Ninguna';

$n_hackeos = db_select_nrows (false, 'idHacking', 'sistema_seguridad_hacking', '', "IP_Client='".$sesion_IP_Client."' OR usuario='".$sesion_usuario."'", $dbConn, 'Test', basename($_SERVER["REQUEST_URI"], ".php"), 'test');


	
echo 'sesion_usuario:'.$sesion_usuario .'<br/>';
echo 'sesion_IP_Client:'.$sesion_IP_Client .'<br/>';
echo 'n_hackeos:'.$n_hackeos .'<br/>';
echo 'sesion_N_Hacks:'.$sesion_N_Hacks .'<br/>';

//si ya hay demasiados intentos de hackeo
	if($n_hackeos>=$sesion_N_Hacks){
		echo 'Si';
	//verifico el numero de intentos de hackeo y guardo el dato
	}elseif($n_hackeos<$sesion_N_Hacks){
		//filtros
		if(isset($sesion_fecha) && $sesion_fecha!=''){                $a  = "'".$sesion_fecha."'";           }else{$a  = "''";}
		if(isset($sesion_hora) && $sesion_hora!=''){                  $a .= ",'".$sesion_hora."'";           }else{$a .= ",''";}
		if(isset($sesion_IP_Client) && $sesion_IP_Client!=''){        $a .= ",'".$sesion_IP_Client."'";      }else{$a .= ",''";}
		if(isset($sesion_Agent_Transp) && $sesion_Agent_Transp!=''){  $a .= ",'".$sesion_Agent_Transp."'";   }else{$a .= ",''";}
		if(isset($sesion_usuario) && $sesion_usuario!=''){            $a .= ",'".$sesion_usuario."'";        }else{$a .= ",''";}
						
		// inserto los datos de registro en la db
		$query  = "INSERT INTO `sistema_seguridad_hacking` (Fecha, Hora, IP_Client, Agent_Transp, usuario) 
		VALUES (".$a.")";
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		
		echo 'No';
	}	
	
?>
