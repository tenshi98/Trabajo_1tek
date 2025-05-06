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
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.FormInputs.Extended.php'; //carga formularios de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Inputs.Extended.php';     //carga inputs de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma
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

		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_1.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/directionalButtons/dist/bootstrap-directional-buttons.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/bttn/dist/bttn.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/elegant_font/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/css/bootstrap-material-datetimepicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker-plus.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/css/fileinput.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/css/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/chosen/chosen.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/tooltipster/css/tooltipster.bundle.min.css">

		<!-- Javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/form_functions.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/rut_validate/jquery.rut.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/autosize/dist/autosize.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/plugins/sortable.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/fileinput.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/locales/es.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly-locale-es-ar.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/validator/validator.min.js"></script>

		<!-- Favicons-->
		<?php
		//Favicon Personalizado
		$nombre_fichero = 'img/mifavicon.png';
		if (file_exists($nombre_fichero)){ ?>
			<link rel="icon"             type="image/png"                    href="img/mifavicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="img/mifavicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="img/mifavicon-57x57.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="img/mifavicon-72x72.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/mifavicon-114x114.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/mifavicon-144x144.png">
		<?php
		//Favicon predefinido
		}else{ ?>
			<link rel="icon"             type="image/png"                    href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-57x57-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-72x72-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-114x114-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-144x144-precomposed.png">
		<?php } ?>

		<!-- Correcciones CSS -->
		<style>
			.login {background-image: none !important;background-color: #1A1A1A !important;}
			.bx_shad{-webkit-box-shadow: 0px 0px 31px 6px rgba(0,0,0,1);-moz-box-shadow: 0px 0px 31px 6px rgba(0,0,0,1);box-shadow: 0px 0px 31px 6px rgba(0,0,0,1);}
		</style>

		<!-- Burbuja de ayuda -->
		<?php widget_tooltipster(); ?>
	</head>

	<body class="login">
		<canvas id="canv" style="width: 100%;height: 100%;position: fixed;top: 0px;left: 0px;"></canvas>

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo DB_SOFT_NAME; ?></h5>
			</header>
			<div class="table-responsive">

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="usercard usercard-widget widget-user">
						<div class="widget-user-header text-white" style="background: url('<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/photo1.jpg') center center;">
							<h3 class="widget-user-username text-right">Bienvenido</h3>
							<h5 class="widget-user-desc text-right"><?php echo $_SESSION['usuario']['basic_data']['Nombre']; ?></h5>
						</div>
						<div class="widget-user-image">
							<?php if ($_SESSION['usuario']['basic_data']['Direccion_img']=='') { ?>
							<img class="img-circle" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
							<?php }else{  ?>
								<img class="img-circle" alt="Imagen Referencia" src="upload/<?php echo $_SESSION['usuario']['basic_data']['Direccion_img']; ?>">
							<?php } ?>
						</div>
						<div class="usercard-footer">
							<div class="row">
								<br><br>
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="box">
						<header>
							<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Sistemas Autorizados</h5>
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
		</div>

	</div>

</div>

	<script id="rendered-js" >
		window.requestAnimFrame = function () {
		  return window.requestAnimationFrame ||
		  window.webkitRequestAnimationFrame ||
		  window.mozRequestAnimationFrame ||
		  window.oRequestAnimationFrame ||
		  window.msRequestAnimationFrame ||
		  function (callback) {
			window.setTimeout(callback, 1000 / 60);
		  };
		}();

		var c = document.getElementById('canv'),
		$ = c.getContext('2d'),
		w = c.width = window.innerWidth,
		h = c.height = window.innerHeight,
		arr = [],
		u = 0;
		o = 0,

		$.fillStyle = '#1A1A1A';
		$.fillRect(0, 0, w, h);
		$.globalCompositeOperation = "source-over";

		var inv = function () {
		  $.restore();
		  $.fillStyle = "#" + (o ? "FEFAE6" : "1A1A1A");
		  $.fillRect(0, 0, w, h);
		  $.fillStyle = "#" + (o ? "1A1A1A" : "FEFAE6");
		  $.save();
		};

		window.addEventListener('resize', function () {
		  c.width = window.innerWidth;
		  c.height = window.innerHeight;
		}, false);

		var ready = function () {
		  arr = [];
		  for (let i = 0; i < 20; i++) {
			set();
		  }
		};

		var set = function () {
		  arr.push({
			x1: w,
			y1: h,
			_x1: w - Math.random() * w,
			_y1: h - Math.random() * h,
			_x2: w - Math.random() * w,
			_y2: h - Math.random() * h,
			x2: -w + Math.random() * w,
			y2: -h + Math.random() * h,
			rot: Math.random() * 180,
			a1: Math.random() * 10,
			a2: Math.random() * 10,
			a3: Math.random() * 10});

		};

		var pretty = function () {
		  //u -= .2;
		  u = 190;
		  for (var i in arr) {
			var b = arr[i];
			b._x1 *= Math.sin(b.a1 -= 0.001);
			b._y1 *= Math.sin(b.a1);
			b._x2 -= Math.sin(b.a2 += 0.001);
			b._y1 += Math.sin(b.a2);
			b.x1 -= Math.sin(b.a3 += 0.001);
			b.y1 += Math.sin(b.a3);
			b.x2 -= Math.sin(b.a3 -= 0.001);
			b.y2 += Math.sin(b.a3);
			$.save();
			$.globalAlpha = 0.03;
			$.beginPath();
			$.strokeStyle = 'hsla(' + u + ', 85%, 60%, .7)';
			$.moveTo(b.x1, b.y1);
			$.bezierCurveTo(b._x1, b._y1, b._x2, b._y2, b.x2, b.y2);
			$.stroke();
			$.restore();
		  }
		  window.requestAnimFrame(pretty);
		};
		ready();
		pretty();

    </script>

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
