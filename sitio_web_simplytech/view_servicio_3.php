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
	<div class="container">
		<div class="section-title">
			<h2>SimC</h2>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Monitoreo de temperatura en tiempo real</h4>
					<p>
						SimC es un sistema de monitoreo basado en tecnología IoT
						(internet de las cosas) que permite monitorear y obtener
						<strong>trazabilidad</strong> de las variables críticas
						de ambientes controlados, tales como <strong>cámaras de
						frigoríficos y líneas de proceso</strong>. Optimiza los
						recursos para dar mayor vida útil al equipamiento de frío
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
						Hacemos <strong>inteligente</strong> tu equipamiento de frío.
						Conectándolo a internet podrás monitorear desde cualquier lugar
						la <strong>temperatura y humedad en tiempo real</strong>. Adicionalmente,
						te entregamos un equipo de telemetría extra para medir el <strong>consumo
						eléctrico</strong> en tiempo real de una cámara de frío.
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_3_1.png" alt="" class="img-fluid">
			</div>
		</div>

	</div>
</section>

<section id="services" class="services section-bg ">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>¿Qué puedes hacer con SimC?</h2>
		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="100">
					<i class="bi bi-pc-display-horizontal"></i>
					<h4><a href="#">Monitorear</a></h4>
					<p>Desde cualquier lugar podrás saber en TIEMPO REAL qué
					cámara está en condiciones óptimas y cuáles no.</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="200">
					<i class="bi bi-bar-chart"></i>
					<h4><a href="#">Trazabilidad</a></h4>
					<p>Esencial para dar un respaldo frente a auditorías internas
					o solicitudes de clientes sobre T° de almacenaje</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="300">
					<i class="bi bi-broadcast-pin"></i>
					<h4><a href="#">Sensores</a></h4>
					<p>Utilizamos sensores digitales con calibración única al vacío.
					Miden temperatura desde -40°C a +80°C</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="400">
					<i class="bi bi-bell"></i>
					<h4><a href="#">Alertas</a></h4>
					<p>Te alertamos directamente al correo y/o al Whatsapp para mejorar la gestión</p>
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
					<h4>La información que quieras a tu alcance</h4>
					<p>
						Monitorea interactivamente desde donde quiera que estés.
						¡Descarga gráficos y datos cuándo lo necesites!
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_3_2.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_3_3.jpg" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Las alertas cuando más lo necesites</h4>
					<p>
						SimC, puede generar alertas cuando se detecten temperaturas
						fuera del rango permitido. Te enviamos un Whatsapp directamente
						a tu telefono
					</p>
				</div>
			</div>
		</div>

	</div>
</section>

<section id="tabs" class="tabs">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>Usa SimC a tu medida</h2>
		</div>

        <ul class="nav nav-tabs row d-flex">

			<li class="nav-item col-3">
				<a class="nav-link">
					<i class="ri-gps-line"></i>
					<h4 class="d-none d-lg-block">Líneas de proceso</h4>
				</a>
			</li>
			<li class="nav-item col-3">
				<a class="nav-link">
					<i class="ri-gps-line"></i>
					<h4 class="d-none d-lg-block">Cámaras de frío</h4>
				</a>
			</li>
			<li class="nav-item col-3">
				<a class="nav-link">
					<i class="ri-gps-line"></i>
					<h4 class="d-none d-lg-block">Túneles prefríos</h4>
				</a>
			</li>
			<li class="nav-item col-3">
				<a class="nav-link">
					<i class="ri-gps-line"></i>
					<h4 class="d-none d-lg-block">Camión de frío</h4>
				</a>
			</li>

        </ul>
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
