<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
set_time_limit(2400);                            //Tiempo Maximo de la consulta, 40 minutos por defecto
ini_set('memory_limit', '4096M');                //Memora RAM Maxima del servidor, 4GB por defecto
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                                          Seguridad                                                             */
/**********************************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_seguridad/AntiXSS.php';
require_once '../A2XRXS_gears/xrxs_seguridad/Bootup.php';
require_once '../A2XRXS_gears/xrxs_seguridad/UTF8.php';
$security = new AntiXSS();
$_POST = $security->xss_clean($_POST);
$_GET  = $security->xss_clean($_GET);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                //Configuracion de la plataforma
require_once '../Legacy/1tek_public/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/1tek_public/funciones/Components.UI.FormInputs.Extended.php'; //carga formularios de la plataforma
require_once '../Legacy/1tek_public/funciones/Components.UI.Inputs.Extended.php';     //carga inputs de la plataforma
require_once '../Legacy/1tek_public/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion
$original = "index.php";
/**********************************************************************************************************************************/
/*                                               Se cargan los formularios                                                        */
/**********************************************************************************************************************************/
//formulario para iniciar sesion
if (!empty($_POST['submit_login'])){
	$form_trabajo= 'login';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//formulario para recuperar la contraseña
if (!empty($_POST['submit_pass'])){
	$form_trabajo= 'getpass';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
/**********************************************************************************************************************************/
/*                                                     Armado del form                                                            */
/**********************************************************************************************************************************/
//Elimino los datos previos del form
unset($_SESSION['form_require']);
//se carga dato previo
$_SESSION['form_require'] = 'required';

?>
<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<!-- Info-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"              content="width=device-width, initial-scale=1, user-scalable=no">
		<meta http-equiv="Content-Type"    content="text/html; charset=UTF-8">

		<!-- Información del sitio-->
		<title>Login</title>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">

		<!-- WEB FONT -->
		<?php
		//verifica la capa de desarrollo
		$whitelist = array( 'localhost', '127.0.0.1', '::1' );
		////////////////////////////////////////////////////////////////////////////////
		//si estoy en ambiente de desarrollo
		if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
			echo '<link rel="stylesheet" href="'.DB_SITE_REPO.'/LIB_assets/lib/font-awesome/css/font-awesome.min.css">';
			//echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';

		////////////////////////////////////////////////////////////////////////////////
		//si estoy en ambiente de produccion
		}else{
			echo '<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">';
			echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';
		}
		?>

		<!-------- BASE -------->
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/css/theme_main.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.css">
		<!-- Javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/js/client-main.js?<?php echo time(); ?>"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/form_functions.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>

		<!-------- PLUGINS -------->
		<!-- bootstrap_touchspin -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.css">
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.js"></script>
		<!-- material_datetimepicker -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/css/bootstrap-material-datetimepicker.min.css" >
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
		<!-- bootstrap_fileinput -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/css/fileinput.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.css" media="all" >
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/plugins/sortable.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/fileinput.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/locales/es.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.js"></script>
		<!-- sweetalert2 -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/sweetalert2/sweetalert2.min.css">
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/sweetalert2/sweetalert2.min.js"></script>
		<!-- Validacion Rut -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/rut_validate/jquery.rut.min.js"></script>
		<!-- Redimensionar Cuadro texto -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/autosize/dist/autosize.min.js"></script>
		<!-- Cuadro texto avanzado -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/ckeditor/ckeditor.js"></script>
		<!-- Validacion de formularios -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/validator/validator.min.js"></script>
		<!-- select2 -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/select2/dist/css/select2.min.css">
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/select2/dist/js/select2.min.js"></script>
		<!-- Graficos -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/chart_js/Chart.min.css">
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/chart_js/Chart.min.js"></script>

		<!-------- CORRECCIONES -------->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/css/my_style.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/css/my_corrections.css?<?php echo time(); ?>">

		<!-- Favicons-->
		<link rel="icon"             type="image/png"                    href="img/favicon/mifavicon.png" >
		<link rel="shortcut icon"    type="image/x-icon"                 href="img/favicon/mifavicon.png" >
		<link rel="apple-touch-icon" type="image/x-icon"                 href="img/favicon/mifavicon-57x57.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="img/favicon/mifavicon-72x72.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/favicon/mifavicon-114x114.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/favicon/mifavicon-144x144.png">

	</head>
	<body class="login">

<?php
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Corredor Creado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
/**********************************************************************************************************************************/
/*                                                      Configuracion                                                             */
/**********************************************************************************************************************************/
//fichero del logo
$nombre_fichero = 'img/login_logo_color.png';
/**********************************************************************************************************************************/
/*                                                   Verificacion bloqueos                                                        */
/**********************************************************************************************************************************/
//calculos
$bloqueo = 0;
//reviso si se conecta desde chile
$INT_IP   = obtenerIpCliente();

//Autologin
/*if(!isset($_GET['exit']) OR $_GET['exit']==''){
	require_once 'login_auto.php';
}*/

//Obtener pais de la IP
//$INT_Pais = obtenerInfoIp($INT_IP, "countryName");

//Se consultan los datos
$ip_bloqueada = db_select_nrows (false, 'idBloqueo', 'sistema_seguridad_bloqueo_ip', '', "IP_Client='".$INT_IP."'", $dbConn, 'login', basename($_SERVER["REQUEST_URI"], ".php"), 'ip_bloqueada');

//Se crean los bloqueos
//if(isset($INT_Pais)&&$INT_Pais!=''&&$INT_Pais!='Chile'&&$INT_IP!='::1'&&$bloqueo==0){  $bloqueo = 2;}
if(isset($ip_bloqueada)&&$ip_bloqueada!=0&&$bloqueo==0){ $bloqueo = 3;}

/**********************************************************************************************************************************/
/*                                                        Despliegue                                                              */
/**********************************************************************************************************************************/
//se selecciona la pantalla a mostrar
switch ($bloqueo) {
    //pantalla normal
    case 0:
        require_once '1include_login_form.php';
		break;
	//pantalla de mantenimiento
    case 1:
        require_once '1include_login_ani.php';
        break;
    //pantalla de bloqueo pais
    case 2:
        require_once '1include_login_block.php';
        //se entregan datos
        $sesion_archivo  = 'index.php';
		$sesion_tarea    = 'login-form';
        //se valida hackeo
		require_once 'A1XRXS_sys/xrxs_form/0_hacking_1.php';
        break;
    //pantalla de baneo
    case 3:
        require_once '1include_login_banned.php';
        break;
}
//validador
widget_validator(); ?>
	</body>
</html>
