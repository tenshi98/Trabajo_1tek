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
			<h2>SimWeather</h2>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Monitoreo máquinas de viento – control de heladas</h4>
					<p>
						SimWeather es un servicio tecnológico que permite el monitoreo en
						tiempo real de máquinas de viento para el control de heladas con el
						valor agregado de integración de datos meteorológicos

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
						Con tecnología IoT y machine learning, conectamos a internet sensores
						de medición de <strong>encendido/apagado y variables climáticas</strong>
						en la misma máquina de viento. Dentro de los datos climáticos, se puede
						visualizar temperatura, humedad, presión atmosférica, predicción de
						temperaturas “heladas”, días-grado, unidades de frío y horas sobre 30°C.<br/>

						Todos estos datos son visualizados desde un software multiusuario con
						funcionamiento 24/7. Dentro del software, se pueden descargar informes
						sobre el funcionamiento de motores de la máquina de viento, cubrimiento
						del ventilador frente a temperaturas críticas “heladas”, informes
						ejecutivos, entre otros.
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
			<h2>¿Qué puedes hacer con SimWeather?</h2>
		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="100">
					<i class="bi bi-pc-display-horizontal"></i>
					<h4><a href="#">Monitorear</a></h4>
					<p>Desde cualquier lugar podrás saber en TIEMPO REAL qué
					está pasando ocurriendo con las variables climáticas en
					el campo</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="200">
					<i class="bi bi-pencil-square"></i>
					<h4><a href="#">Revisar KPI's</a></h4>
					<p>En un panel de control intuitivo, verás la información
					necesaria de cada estación meteorológica individualmente</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="300">
					<i class="bi bi-bell"></i>
					<h4><a href="#">Alertas</a></h4>
					<p>Recibe alertas de posibles heladas con proyección de una
					hora. Además, puedes verificar el funcionamiento del aspa</p>
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
					<h4>Decisiones rápidas; ahorra tiempo</h4>
					<p>
						asd
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_2_2.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_2_3.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Proyección de temperatura</h4>
					<p>
						Gracias a la inteligencia artificial, SimWeather es capaz de
						predecir la temperatura de la próxima hora, alertando en caso
						que sean temperaturas críticas como una helada
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Informe ejecutivo</h4>
					<p>
						SimWeather entrega informes ejecutivos descargables en excel o
						pdf donde tenga toda la información en el intervalo de fechas que
						tú decidas
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_2_4.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_2_5.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Informe heladas</h4>
					<p>
						No sólo te avisamos con anticipación la presencia de heladas, si
						no que SimWeather crea un informe a la medida y específico de
						heladas
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
