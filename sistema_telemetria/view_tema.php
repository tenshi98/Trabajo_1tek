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
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
$original = '';
?>
<!doctype html>
<html class="no-js">
	<head>
		<meta charset="UTF-8">
		<title>Preview Tema</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

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
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_<?php if(isset($_GET['idTheme'])&&$_GET['idTheme']!=''){echo $_GET['idTheme'];}else{echo '1';} ?>.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
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

		<!-- Icono de la pagina -->
		<link rel="icon" type="image/png" href="img/mifavicon.png" />
	</head>

  <body>
    <div id="wrap">
      <div id="top">
        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container-fluid">
            <header class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a href="principal.php" class="navbar-brand">
			  	<?php require_once 'core/Web.Body.Nav.Logo.php'; ?>
              </a>
            </header>
            <?php require_once 'core/Web.Body.Nav.Actions.php'; ?>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
				<?php require_once 'core/Web.Body.Nav.Menu_top.php'; ?>
            </div>
          </div>
        </nav>
        <header class="head">
          <div class="main-bar">
            <h3>Preview Tema</h3>
          </div>
        </header>
      </div>
      <div id="left">
	  	<?php require_once 'core/Web.Body.Lateralmenu.Userbox.php'; ?>
		<?php require_once 'core/Web.Body.Lateralmenu.Menu.php'; ?>
      </div>
      <div id="content">
        <div class="outer">
            <div class="inner">


				<h3>Preview Formularios</h3>

				<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
					<div class="box">
						<header>
							<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
							<h5>Crear Nuevo Producto</h5>
						</header>
						<div class="body">
							<form class="form-horizontal" id="form1" name="form1" novalidate>

								<?php
								//Se verifican si existen los datos
								if(isset($Nombre)){         $x1  = $Nombre;           }else{$x1  = '';}
								if(isset($idTipo)){         $x2  = $idTipo;           }else{$x2  = '';}
								if(isset($idCategoria)){    $x3  = $idCategoria;      }else{$x3  = '';}
								if(isset($Marca)){          $x4  = $Marca;            }else{$x4  = '';}
								if(isset($idUml)){          $x5  = $idUml;            }else{$x5  = '';}
								if(isset($idTipoProducto)){ $x6  = $idTipoProducto;   }else{$x6  = '';}

								//se dibujan los inputs
								$Form_Inputs = new Form_Inputs();
								$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
								$Form_Inputs->form_select_filter('Tipo de Producto','idTipo', $x2, 2, 'idTipo', 'Nombre', 'sistema_productos_tipo', 0,  '',$dbConn);
								$Form_Inputs->form_select_filter('Categoria','idCategoria', $x3, 2, 'idCategoria', 'Nombre', 'sistema_productos_categorias', 0, '', $dbConn);
								$Form_Inputs->form_input_text('Marca', 'Marca', $x4, 2);
								$Form_Inputs->form_select_filter('Unidad de Medida','idUml', $x5, 2, 'idUml', 'Nombre', 'sistema_productos_uml', 0, '', $dbConn);
								$Form_Inputs->form_select_filter('Tipo Producto','idTipoProducto', $x6, 2, 'idTipoProducto', 'Nombre', 'core_tipo_producto', 0, '', $dbConn);

								$Form_Inputs->form_input_hidden('idEstado', 1, 2);
								?>

								<div class="form-group">
									<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" >
									<a href="#" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
								</div>

							</form>
							<?php widget_validator(); ?>
						</div>
					</div>
				</div>

				<h3>Preview Listados</h3>
				<?php
				$SIS_query = '
				core_ubicacion_comunas.idComuna,
				core_ubicacion_comunas.Nombre AS nombre_comuna,
				core_ubicacion_ciudad.Nombre AS nombre_ciudad';
				$SIS_join  = 'LEFT JOIN `core_ubicacion_ciudad` ON core_ubicacion_ciudad.idCiudad = core_ubicacion_comunas.idCiudad';
				$SIS_where = '';
				$SIS_order = 'core_ubicacion_ciudad.Nombre ASC, core_ubicacion_comunas.Nombre ASC LIMIT 30';
				$arrComunas = array();
				$arrComunas = db_select_array (false, $SIS_query, 'core_ubicacion_comunas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrComunas');

				?>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="box">
						<header>
							<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Comunas</h5>
						</header>
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th width="60">ID</th>
										<th>Nombre Región</th>
										<th>Nombre Comuna</th>
										<th width="10">Acciones</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrComunas as $comunas) { ?>
									<tr class="odd">
										<td><?php echo $comunas['idComuna']; ?></td>
										<td><?php echo $comunas['nombre_ciudad']; ?></td>
										<td><?php echo $comunas['nombre_comuna']; ?></td>
										<td>
											<div class="btn-group" style="width: 70px;" >
												<a href="#" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<?php
												$ubicacion = '';
												$dialogo   = '¿Realmente deseas eliminar la comuna de '.$comunas['nombre_comuna'].'?'; ?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>

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
    <footer id="footer">
	<p><?php echo ano_actual(); ?> &copy; <?php echo DB_EMPRESA_NAME ?> Todos los derechos reservados.</p>
</footer>

<!--Otros archivos javascript -->
<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/js/bootstrap.min.js"></script>
<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/screenfull/screenfull.js"></script>
<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-ui-1.10.3.min.js"></script>
<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/main.min.js"></script>

  </body>
</html>
