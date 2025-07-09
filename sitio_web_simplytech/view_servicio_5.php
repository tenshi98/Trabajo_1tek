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
			<h2>SimEnergy</h2>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Monitoreo consumo eléctrico</h4>
					<p>
						<strong>¿Sabes cuánto consumes al mes? ¿Te gustaría poder
						gestionar el mismo mes el consumo eléctrico de tu planta
						y en tiempo real?</strong><br/>
						SimEnergy es un sistema de <strong>monitoreo de consumo
						eléctrico en tiempo real</strong> para la planta completa
						y por cada maquinaria, pudiendo obtener el consumo por
						<strong>centro de costo</strong>. Además, el sistema
						SimEnergy entrega información valiosa para gestionar
						la <strong>eficiencia eléctrica</strong>, podrás ver
						consumo eléctrico del mes actual y mes anterior; Peaks
						de consumo eléctrico, demanda máxima de suministro del
						mes actual y 12 meses anteriores; potencia observada y
						voltaje de líneas trifásicas.
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
						Conectamos a internet el panel eléctrico general de la planta
						y el de cada maquinaria productiva. Esto, gracias a nuestro
						propios equipos de telemetría no invasivos que tienen su
						propia conexión y comunicación a internet. Lo más interesante
						es que puedes revisar los KPI’s en la plataforma web
						<strong>¡Y desde cualquier punto del país!</strong>
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_5_1.png" alt="" class="img-fluid">
			</div>
		</div>

	</div>
</section>

<section id="services" class="services section-bg ">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>¿Qué puedes hacer con SimEnergy?</h2>
		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="100">
					<i class="bi bi-pc-display-horizontal"></i>
					<h4><a href="#">Monitorear</a></h4>
					<p>Desde cualquier computador y cualquier punto del país</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="200">
					<i class="bi bi-pencil-square"></i>
					<h4><a href="#">Revisar KPI's</a></h4>
					<p>Revisa en tiempo real si se están cumpliendo los consumos y peaks.</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="300">
					<i class="bi bi-bell"></i>
					<h4><a href="#">Alertas</a></h4>
					<p>Crea alertas de parámetros fuera de rango. EJ: Consumo mes sobre X kW/h</p>
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
					<h4>Dashboard panel general o equipo en particular</h4>
					<p>
						asd
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_5_2.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_5_3.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>¿Sabes cuánto estás consumiendo en el mes?</h4>
					<p>
						asd
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>¿Demanda máxima suministrada? Aquí está</h4>
					<p>
						asd
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_5_4.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_5_5.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>También, potencia en hora punta</h4>
					<p>
						asd
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Revisa la potencia observada</h4>
					<p>
						asd
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_5_6.png" alt="" class="img-fluid">
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
