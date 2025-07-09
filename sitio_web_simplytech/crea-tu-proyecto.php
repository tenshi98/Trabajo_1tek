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
// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "index.php";
/**********************************************************************************************************************************/
/*                                                     Armado del form                                                            */
/**********************************************************************************************************************************/
//Elimino los datos previos del form
unset($_SESSION['form_require']);
//se carga dato previo
$_SESSION['form_require'] = 'required';
/**********************************************************************************************************************************/
/*                                                   Variables globales                                                           */
/**********************************************************************************************************************************/
//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){

//si estoy en ambiente de produccion
}else{
	/*    Global Variables    */
	//Tiempo Maximo de la consulta, 40 minutos por defecto
	set_time_limit(2400);
	//Memora RAM Maxima del servidor, 4GB por defecto
	ini_set('memory_limit', '4096M');
}
/**********************************************************************************************************************************/
/*                                                      Configuracion                                                             */
/**********************************************************************************************************************************/
require_once 'configuracion.php';
require_once 'load_data.php';
/**********************************************************************************************************************************/
/*                                               Ejecucion de los formularios                                                     */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'send_mail';
	require_once 'A1XRXS_sys/xrxs_form/contact_form.php';
}

?>
<!DOCTYPE html>
<html lang="en">
	<?php require_once 'core/Web.Header.Main.php'; ?>
	<body>
		<?php
		if(isset($rowData['Config_Menu'])&&$rowData['Config_Menu']==1){         require_once 'core/Web.Body.Nav.Menu.php';}?>

		<main id="main">

			<section class="breadcrumbs">
				<div class="container">
					<ol>
						<li><a href="index.php">Inicio</a></li>
						<li>Crea tu proyecto</li>
					</ol>
					<h2>Crea tu proyecto</h2>
				</div>
			</section>

			<section id="features" class="features">
				<div class="container" data-aos="fade-up">
					<div class="section-title">
						<h2>Crea tu proyecto</h2>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
							<div class="icon-box mt-5 mt-lg-0">
								<i class="bx bx-receipt"></i>
								<p>
									Si tienes un proyecto en mente y necesitas materializarlo,
									nosotros hacemos el <strong>DESARROLLO DE SISTEMAS INFORMÁTICOS</strong>,
									dando una solución que se ajuste a tu medida. Trabajamos con todo
									tipo de hardware y plataformas que facilitan las mediciones y
									visualización de big data. Nos especializamos en la creación de
									tecnología IOT (internet of the things), ERP’s, generación de
									informes en base a data y telemetría general.
								</p>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
							<img src="upload/crea-tu-proyecto/crea-tu-proyecto_1.jpg" alt="" class="img-fluid">
						</div>
					</div>

				</div>
			</section>

			<section id="contacto" class="contact">
				<div class="container" data-aos="fade-up">

					<div class="section-title">
						<h2 data-aos="fade-up">Escríbenos tu proyecto a desarrollar lo más detallada posible</h2>
					</div>

					<div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
						<div class="my-3">
							<?php
							//Alertas
							if(isset($_GET['sended'])&&$_GET['sended']!=''){
								echo '<div class="alert alert-success" role="alert">Mensaje correctamente enviado</div>';
							}
							if(isset($_GET['error'])&&$_GET['error']!=''){
								echo '<div class="alert alert-danger" role="alert">Mensaje no pudo ser enviado</div>';
							}
							if(isset($_GET['dataerror'])&&$_GET['dataerror']!=''){
								echo '<div class="alert alert-warning" role="alert">Revise los campos obligatorios</div>';
							}
							?>
						</div>

						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<form method="post" role="form" class="php-email-form">
								<div class="form-group">
									<input type="text" name="De_nombre" class="form-control" id="name" placeholder="Su Nombre" required>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" name="De_correo" id="email" placeholder="Su Email" required>
								</div>
								<div class="form-group">
									<textarea class="form-control" name="CuerpoHTML" rows="5" placeholder="Mensaje" required></textarea>
								</div>
								<div class="text-center">
									<input type="submit" value="Enviar Mensaje" name="submit">
								</div>
							</form>
						</div>

					</div>

				</div>
			</section>

		</main><!-- End #main -->

		<?php require_once 'core/Web.Footer.Main.php'; ?>
	</body>

</html>
