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
/*                                   Se filtran las entradas para evitar ataques                                                  */
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
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                  //Configuracion de la plataforma
require_once '../Legacy/1tek_public/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/1tek_public/funciones/Components.UI.FormInputs.Extended.php'; //carga formularios de la plataforma
require_once '../Legacy/1tek_public/funciones/Components.UI.Inputs.Extended.php';     //carga inputs de la plataforma
require_once '../Legacy/1tek_public/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Session.php';                  //verificacion sesion usuario

/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "index_select.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para recuperar la contraseña
if (!empty($_GET['ini'])){
	$form_trabajo= 'select_sistema';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}

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
		<title>Seleccion Plataforma</title>
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

		<!-- Burbuja de ayuda -->
		<?php widget_tooltipster(); ?>
	</head>

	<body class="login">

		<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		//Si el usuario es un super usuario
		if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
			// Se trae un listado con todos los sistemas
			$arrSistemas  = array();
			$arrSistemas  = db_select_array (false,
			'core_sistemas.idSistema,
			core_sistemas.Nombre AS RazonSocial,
			core_interfaces.Nombre AS Interfaz',
			'core_sistemas',
			'LEFT JOIN `core_interfaces`  ON core_interfaces.idInterfaz  = core_sistemas.idOpcionesGen_7',
			'core_sistemas.idEstado=1',
			'core_sistemas.Nombre ASC',
			$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGraficos');

		//Si el usuario es un usuario normal
		}else{
			// Se trae un listado con todos los sistemas
			$arrSistemas  = array();
			$arrSistemas  = db_select_array (false,
			'usuarios_sistemas.idSistema,
			core_sistemas.Nombre AS RazonSocial,
			core_interfaces.Nombre AS Interfaz',
			'usuarios_sistemas',
			'LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema  = usuarios_sistemas.idSistema LEFT JOIN `core_interfaces`  ON core_interfaces.idInterfaz  = core_sistemas.idOpcionesGen_7', 
			'usuarios_sistemas.idUsuario ='.$_SESSION['usuario']['basic_data']['idUsuario'].' AND core_sistemas.idEstado=1',
			'core_sistemas.Nombre ASC',
			$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGraficos');

		}
		?>

		<div class="container">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo 'Bienvenido '.$_SESSION['usuario']['basic_data']['Nombre'].' a '.DB_SOFT_NAME; ?></h5>
					</header>
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Sistema</th>
									<th>Interfaz</th>
									<th width="10">Acciones</th>
								</tr>
								<?php echo widget_sherlock(1, 3, 'TableFiltered'); ?>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
								<?php foreach ($arrSistemas as $sis) { ?>
									<tr class="odd">
										<td><?php echo $sis['RazonSocial']; ?></td>
										<td><?php echo $sis['Interfaz']; ?></td>
										<td>
											<div class="btn-group" style="width: 35px;" >
												<?php
												$link = $location;
												$link.= '?ini='.simpleEncode($sis['idSistema'], fecha_actual());
												$link.= '&id='.simpleEncode($_SESSION['usuario']['basic_data']['idUsuario'], fecha_actual());
												?>
												<a href="<?php echo $link; ?>" title="Acceder a <?php echo $sis['RazonSocial']; ?>" class="btn btn-primary btn-sm tooltip"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>



		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/screenfull/screenfull.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-ui-1.10.3.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/tooltipster/js/tooltipster.bundle.min.js"></script>

		<script>
			$(document).ready(function(){
				//Burbuja de ayuda
				$('.tooltip').tooltipster({
					animation: 'grow',
					delay: 130,
					maxWidth: 300
				});

			});
		</script>

	</body>
</html>
