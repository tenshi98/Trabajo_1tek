<!-- Correcciones CSS -->
<style>
	.login {background-image: none !important;background-color: #1A1A1A !important;}
	.login .form-signin {max-width: 330px;padding: 20px;margin: 0 auto;background-color: rgba(255, 255, 255, 0.7) !important;border-radius: 15px;-webkit-box-shadow: none !important;-moz-box-shadow: none !important;box-shadow: none !important;position: relative;}
	.login_logo{width:100%!important;margin-bottom: 20px;}
	.tab-content .text-muted {margin-left: 0px !important;color: #FFFFFF !important;}
	<?php
	if (file_exists($nombre_fichero)){
		echo '
			.btn-primary {color: #fff;background-color: #8b00ff !important;border-color: #8b00ff !important;}
			.btn-primary:hover {background-color: #670CB3 !important;}
			.login_text1{color: #111111 !important;text-align: center;margin-top: 0px;margin-bottom: 0px;}';
	}else{
		echo '.login_text1{color: #DB4F21 !important;text-align: center;margin-top: 0px;margin-bottom: 0px;}';
	}
	?>
</style>
<canvas id="canv" style="width: 100%;height: 100%;position: fixed;top: 0px;left: 0px;"></canvas>

<link rel="stylesheet" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/animate/animate.min.css">

<div class="form-signin">
	<div class="text-center">
		<?php
		if (file_exists($nombre_fichero)){
			echo '<img src="img/login_logo.png" alt="login_logo" class="login_logo fcenter"> ';
		} else {
			echo '
			<div class="text-center">
				<h1>'.DB_SOFT_NAME.'<br/>
					<span>'.DB_SOFT_SLOGAN.'</span>
				</h1>
				<div class="content_gearbox fcenter">
					<div class="gearbox">
						<div class="overlay"></div>
						<div class="gear one">
							<div class="gear-inner">
								<div class="bar"></div>
								<div class="bar"></div>
								<div class="bar"></div>
							</div>
						</div>
						<div class="gear two">
							<div class="gear-inner">
								<div class="bar"></div>
								<div class="bar"></div>
								<div class="bar"></div>
							</div>
						</div>
						<div class="gear four large">
							<div class="gear-inner">
								<div class="bar"></div>
								<div class="bar"></div>
								<div class="bar"></div>
								<div class="bar"></div>
								<div class="bar"></div>
								<div class="bar"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>
			';
		}

		?>

	</div>

	<div class="tab-content" style="min-height: 200px !important;">
		<div id="login" class="tab-pane active">
			<form class="" method="post"  name="form1" autocomplete="off" novalidate>
				<h1 class="login_text1">Iniciar sesión</h1>
				<p class="text-muted text-center">Ingrese su nombre de usuario y contraseña para acceder</p>
				<?php
				/******************************************/
				//Muestro los accesos erroneos
				if(isset($NAccesos)&&$NAccesos!=''){
					alert_post_data(4,1,1,0, $NAccesos.' Accesos erroneos de 5 disponibles');
				}

				/******************************************/
				//Se verifican si existen los datos
				if(isset($usuario)){    $x1  = $usuario;   }else{$x1  = '';}
				if(isset($password)){   $x2  = $password;  }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Inputs();
				$Form_Inputs->input_login_usr('Usuario', 'usuario', $x1);
				$Form_Inputs->input('password','Contraseña', 'password', $x2, 2);

				$Form_Inputs->input_hidden('fkinput1', '', 1);

				?>

				<input type="submit" name="submit_login" class="btn btn-lg btn-primary btn-block fa-input" value="&#xf007; Iniciar sesión" />
			</form>
		</div>
		<div id="forgot" class="tab-pane">
			<form class="" method="post"  name="form2" autocomplete="off" novalidate>
				<h1 class="login_text1">¿Olvidaste tu contraseña?</h1>
				<p class="text-muted text-center">Ingresa tu Email para recuperar tu contraseña.Revisa la bandeja de entrada o spam de tu correo.</p>
				<?php
				//Se verifican si existen los datos
				if(isset($email)){    $x1  = $email;   }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs->input_login_mail('mimail@midominio.cl', 'email', $x1);

				$Form_Inputs->input_hidden('fkinput2', '', 1);
				?>
				<br>

				<input type="submit" name="submit_pass" class="btn btn-lg btn-danger btn-block fa-input" value="&#xf003; Recuperar contraseña" />
			</form>
		</div>
	</div>
	<hr>
	<div class="text-center">
		<ul class="list-inline">
			<li class="active"> <a class="text-muted" href="#login"  data-toggle="tab" aria-expanded="true">Ingresar</a>  </li>
			<li class="">       <a class="text-muted" href="#forgot" data-toggle="tab" aria-expanded="false">Recuperar contraseña</a>  </li>
		</ul>
	</div>
</div>

<!--jQuery -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!--Bootstrap -->
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
(function($) {
	$(document).ready(function() {
		$('.list-inline li > a').click(function() {
			var activeForm = $(this).attr('href') + ' > form';
			//console.log(activeForm);
			$(activeForm).addClass('animated fadeIn');
			//set timer to 1 seconds, after that, unload the animate animation
			setTimeout(function() {
			$(activeForm).removeClass('animated fadeIn');
			}, 1000);
		});
	});
})(jQuery);
</script>

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
			a3: Math.random() * 10
		});
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
