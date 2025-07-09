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
			<h2>SimCrane</h2>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Monitoreo de maquinaria de alto tonelaje</h4>
					<p>
						SimCrane es un sistema de monitoreo basado en tecnología IoT
						(internet de las cosas) que permite monitorear las variables
						críticas de una grúa de construcción. Además, permite visualizar
						el trabajo REAL realizado por el operario (Horario real de
						trabajo en obra). Todo esto a través de sensores que son
						conectados al equipamiento (telemetría)
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
						SimCrane es una plataforma web que procesa información
						entregada por los sensores conectados a las grúas. También
						conocido como telemetría, el IoT, consta de hacer inteligente
						una grúa de construcción conectándola a internet, monitorear
						remotamente los KPI’s en tiempo real y apagar/encender remotamente
						éstas. Finalmente, se muestra la información en un dashboard e
						informes para tomar decisiones rápidas y efectivas
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_6_1.png" alt="" class="img-fluid">
			</div>
		</div>

	</div>
</section>

<section id="services" class="services section-bg ">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>¿Qué puedes hacer con SimCrane?</h2>
		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="100">
					<i class="bi bi-pie-chart"></i>
					<h4><a href="#">Dashboard</a></h4>
					<p>Cada grúa tiene su propio panel para monitorear desde nuestra plataforma web</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="200">
					<i class="bi bi-people"></i>
					<h4><a href="#">Trabajo real</a></h4>
					<p>Podrás ver las horas trabajadas efectivas del operario, y así evitar malentendidos</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="300">
					<i class="bi bi-power"></i>
					<h4><a href="#">Apagado remoto</a></h4>
					<p>Podrás apagar y/o encender remotamente cada una</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4 mt-md-0">
				<div class="icon-box" data-aos="fade-up" data-aos-delay="400">
					<i class="bi bi-bell"></i>
					<h4><a href="#">Alertas</a></h4>
					<p>Recibe en tu correo y plataforma web todos los parámetros fuera de rango</p>
				</div>
			</div>

		</div>

	</div>
</section>

<section id="features" class="features">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>Decisiones rápidas; ahorra tiempo</h2>
		</div>

		<?php
		//variables
		$Car_id          = 'myCarousel_1';
		$Car_indicadores = '';
		$Car_items       = '';
		$Car_Count       = 0;

		//funcion
		$thefolder = 'upload/view_servicio/galery/';
		if ($handler = opendir($thefolder)){
			while (false !== ($file = readdir($handler))){
				if ($file != '.' && $file != '..'){
					if($Car_Count==0){
						$active = 'active';
					}else{
						$active = '';
					}
					$Car_indicadores .= '<li data-bs-target="#'.$Car_id.'" data-bs-slide-to="'.$Car_Count.'" class="'.$active.'"></li>';
					$Car_items       .= '<div class="carousel-item '.$active.'"><img src="'.$thefolder.$file.'" class="d-block w-100" alt="Slide '.$Car_Count.'"></div>';

					$Car_Count++;
				}
			}
			closedir($handler);
		}

		?>

		<div class="row">
			<div id="<?php echo $Car_id; ?>" class="carousel slide" data-bs-ride="carousel">
				<!-- Carousel indicators -->
				<ol class="carousel-indicators">
					<?php echo $Car_indicadores; ?>
				</ol>

				<!-- Wrapper for carousel items -->
				<div class="carousel-inner">
					<?php echo $Car_items; ?>
				</div>

				<!-- Carousel controls -->
				<a class="carousel-control-prev" href="#<?php echo $Car_id; ?>" data-bs-slide="prev">
					<span class="carousel-control-prev-icon"></span>
				</a>
				<a class="carousel-control-next" href="#<?php echo $Car_id; ?>" data-bs-slide="next">
					<span class="carousel-control-next-icon"></span>
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Obtén trazabilidad</h4>
					<p>
						Registra el comportamiento de cada motor (elevación, carro y giro)
						en sus tres fases. Además, puedes consultar por trazabilidad del voltaje
						en el tiempo.
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_6_3.png" alt="" class="img-fluid">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1" >
				<img src="upload/view_servicio/servicio_6_4.png" alt="" class="img-fluid">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Tiempo de uso</h4>
					<p>
						Registra el tiempo de uso de cada motor en un tiempo determinado que
						tú elijas. Esto se calcula en base al consumo eléctrico que leen los
						sensores que instalamos
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-1">
				<div class="icon-box mt-5 mt-lg-0">
					<i class="bx bx-receipt"></i>
					<h4>Ciclos componentes</h4>
					<p>
						En la plataforma, se registra la cantidad de horas y/o ciclos de
						cada contactor para determinar el cumplimiento de su vida útil.
						Además, se configura una alerta para prever una mantención a tiempo
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-2" >
				<img src="upload/view_servicio/servicio_6_5.png" alt="" class="img-fluid">
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
