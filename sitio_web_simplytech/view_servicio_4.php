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
			<h2>SimTrack</h2>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Gestión de flota GPS</h4>
					<p>
						<strong>SimTrack</strong> es más que un servicio de monitoreo GPS.
						Monitorea todo tipo de vehículos no sólo con su ubicación en tiempo
						real, si no que también con una serie de informes como trayectos,
						kilómetros recorridos, gastos, tiempos de detención y velocidad.

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
						Hacemos inteligente cualquier vehículo, implementando tecnología IoT,
						de esta forma tu equipamiento lo llevamos al siguiente nivel,
						conectándolo a internet para que a través de nuestra plataforma
						web, puedas ver y tomar decisiones en cosa de minutos.
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_4_1.png" alt="" class="img-fluid">
			</div>
		</div>

	</div>
</section>

<section id="services" class="services section-bg ">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>¿Qué puedes hacer con SimTrack?</h2>
		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="100">
					<i class="bi bi-pc-display-horizontal"></i>
					<h4><a href="#">Monitorear</a></h4>
					<p>Ubicación en línea, recorridos y detalles de cada
					uno de los vehículos/máquinas de la empresa.</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="200">
					<i class="bi bi-file-text"></i>
					<h4><a href="#">Informes</a></h4>
					<p>Selecciona intervalo de fechas para consultar información
					de comportamiento del vehículo ¡Hay más de 15 tipos de informes!</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="300">
					<i class="bi bi-bell"></i>
					<h4><a href="#">Alertas</a></h4>
					<p>Configura parámetros: exceso de velocidad, salida de ruta,
					exceso tiempo de detención ¡Y más! </p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="400">
					<i class="bi bi-puzzle"></i>
					<h4><a href="#">Adicional</a></h4>
					<p>Integra servicio SimC y/o sensor de apertura de puertas,
					para asegurar la carga </p>
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
					<h4>Tu flota, en una sóla pantalla</h4>
					<p>
						asd
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_4_2.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Kilómetros recorridos</h4>
					<p>
						Mediante un filtro, puedes seleccionar el vehículo, fecha y hora
						que requieras para consultar el total de km recorridos.
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Velocidad del vehículo</h4>
					<p>
						Registra la velocidad de cada vehículo monitoreado que se hayan
						cumplido los parámetros dispuestos por la empresa.
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Ruta del vehículo</h4>
					<p>
						Mira el recorrido total de un vehículo en particular esté donde
						esté y en un intervalo de fecha asigando por ti.
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
