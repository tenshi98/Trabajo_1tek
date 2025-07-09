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
/*                                                      Consultas                                                                 */
/**********************************************************************************************************************************/



?>

<!DOCTYPE html>
<html lang="en">
	<?php require_once 'core/Web.Header.Main.php'; ?>
	<body>

<section id="features" class="features">
	<div class="container" data-aos="fade-up">
		<div class="section-title">
			<h2>SimChecking</h2>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Monitoreo de aplicaciones fitosanitarias en tiempo real</h4>
					<p>
						SimChecking es un sistema de monitoreo en <strong>tiempo real</strong>,
						de tu maquinaria agrícola. SimChecking es capaz de monitorear <strong>trayecto
						con GPS del tractor, velocidad, kilómetros recorridos y tiempo de uso</strong>.
						Además, se conectan sensores al pulverizador, donde podrás ver  <strong>nivel
						de flujo de rameles y nivel de estanque</strong>. Con SimChecking entrega
						una completa <strong>trazabilidad</strong> de las aplicaciones fitosanitarias.

						¡Se puede instalar este sistema en cualquier tractor y pulverizador!

					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>IoT - Internet de las cosas</h4>
					<p>
						Hacemos <strong>inteligente tus propios equipos pulverizadores</strong>,
						implementando tecnología IoT, de esta forma tu equipamiento agrícola lo
						llevamos al siguiente nivel, conectándolo a internet para que a través
						de nuestra plataforma web, puedas monitorear el trabajo de cada uno
						<strong>¡Desde donde quiera que estés!</strong>
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_1_1.png" alt="" class="img-fluid">
			</div>
		</div>

	</div>
</section>

<section id="services" class="services section-bg ">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>¿Qué puedes hacer con SimChecking?</h2>
		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="100">
					<i class="bi bi-pc-display-horizontal"></i>
					<h4><a href="#">Crear y Monitorear</a></h4>
					<p>Crea solicitudes de aplicaciones para luego ver la ubicación
					en tiempo real del tractor, nivel de estanque, caudal de los ramales
					y generar el cuaderno de campo automáticamente</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="200">
					<i class="bi bi-pencil-square"></i>
					<h4><a href="#">Revisar KPI's</a></h4>
					<p>Revisa en tiempo real si se están cumpliendo los parámetros exigidos
					por el encargado de aplicaciones fitosanitarias</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="300">
					<i class="bi bi-bell"></i>
					<h4><a href="#">Alertas</a></h4>
					<p>En caso que no se estén cumpliendo los parámetros exigidos para la
					aplicación, te envíamos una alerta para corregir la actividad en el minuto</p>
				</div>
			</div>

		</div>

	</div>
</section>

<section id="features" class="features">
	<div class="container" data-aos="fade-up">

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Analiza el recorrido de tu equipamiento</h4>
					<p>
						Con SimChecking podrás ver la ruta de cada <strong>tractor y
						nebulizador</strong>, para saber la trayectoria y ver si aplicó
						o no dentro del cuartel
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_1_2.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_1_3.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Gestiona las aplicaciones fitosanitarias</h4>
					<p>
						Rápidamente, podrás <strong>crear</strong> tu calendario fitosanitario
						-el cual puedes editar- para luego <strong>monitorear los KPI’s</strong>.
						Se incluyen todas la variables que comprenden una solicitud tipo. Deberás
						<strong>crear, ejecutar y cerrar las solicitudes</strong>
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Revisa KPI's en tiempo real</h4>
					<p>
						En un sólo click puedes revisar qué está haciendo el tractor y nebulizador
						según una solicitud creada anteriormente. (solicitud en ejecución)
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_1_4.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_1_5.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Revisa el resultado total de los tractores en una misma solicitud</h4>
					<p>
						Sabemos que existe la posibilidad que para una <strong>misma</strong>
						solicitud de aplicación fitosanitaria, pueden comprender <strong>más
						de un tractor</strong> para un mismo cuartel, es por eso que puedes
						revisar el resultado consolidado de la aplicación. (solicitud cerrada)
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>¿Pasó el pulverizador aplicando?</h4>
					<p>
						Consistentemente con el recorrido, podrás ver cada medición del equipo
						de IoT cuando detectó que estuvo aplicando el pulverizador. Así, podrás
						dar cuenta la distribución de la aplicación.
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_1_6.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_1_7.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Genera automáticamente el cuaderno de campo</h4>
					<p>
						SimChecking, finalmente, generará el cuaderno de campo con respecto a
						todas las solicitudes de aplicaciones de agroquímicos realizadas y cerradas
					</p>
				</div>
			</div>
		</div>

	</div>
</section>

		<!-- Vendor JS Files -->
		<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
		<script src="assets/vendor/aos/aos.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
		<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
		<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
		<script src="assets/vendor/php-email-form/validate.js"></script>

		<!-- Template Main JS File -->
		<script src="assets/js/main.js"></script>
	</body>

</html>
