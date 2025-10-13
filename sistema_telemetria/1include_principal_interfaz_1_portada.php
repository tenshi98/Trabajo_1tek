<?php

echo '<div class="wrapper">';
	//Variables
	$currentTime  = strtotime(hora_actual());
	$startTime    = strtotime('21:00:00');
	$endTime      = strtotime('07:00:00');

	/******************************* Animacion *******************************/
	//identifico la hora actual y defino si esta dentro del rango deseado
	if (
		($startTime < $endTime && $currentTime >= $startTime && $currentTime <= $endTime) ||
		($startTime > $endTime && ( $currentTime >= $startTime || $currentTime <= $endTime))
		) {
		//animacion para la noche
		echo '
		<div class="image fb_animation_back_night">
			<div class="fb_animation_night" >
				<div class="londonScene"></div>
				<div class="train"></div>
				<div class="crane">
					<div class="logo"></div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div id="card_weather">
					</div>
				</div>
			</div>
		</div>';
	} else {
		echo '
		<div class="image fb_animation_back">
			<div class="fb_animation" >
				<div class="londonScene"></div>
				<div class="train"></div>
				<div class="crane">
					<div class="logo"></div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div id="card_weather">
					</div>
				</div>
				<div class="wolf"></div>
				<div class="sam"></div>
				<div class="ari-uzi"></div>
				<div class="royal"></div>
				<div class="darjeeling"></div>
				<div class="car1"></div>
				<div class="car2"></div>
				<div class="car3"></div>
				<div class="car4"></div>
				<div class="car5"></div>
				<div class="car6"></div>
			</div>
		</div>';
	}

	/******************************* Meteo *******************************/		
	//se llama a la libreria			
	echo '
	<script src="'.DB_SITE_REPO.'/Legacy/1tek_public/lib/weather/jquery.simpleWeather.js"></script>
	<script src="'.DB_SITE_REPO.'/Legacy/1tek_public/lib/skycons/skycons.js"></script>';

	//defino la comuna
	if(isset($subconsulta['Comuna'])&&$subconsulta['Comuna']!=''){$comuna = $subconsulta['Comuna'];}else{$comuna = 'Santiago';}
					
	echo '
	<script>
		$(document).ready(function() {
			
			$.simpleWeather({
				location: \''.$comuna.', Chile\',
				woeid: \'\',
				unit: \'c\',
				success: function(weather) {
								
					let meteo  = "";
					let back_g = "";
					switch (weather.code) {
						case \'1\':
						case \'2\':
						case \'3\':
						case \'4\':
						case \'37\':
						case \'38\':
						case \'39\':
						case \'45\':
						case \'47\':
							meteo = "rain";
							back_g = "wheater_rain";
							break;
										
						case \'5\':
						case \'6\':
						case \'7\':
						case \'8\':
						case \'10\':
						case \'15\':
						case \'17\':
						case \'18\':
						case \'35\':
						case \'40\':
						case \'42\':
						case \'43\':
						case \'46\':
							meteo = "sleet";
							back_g = "wheater_snow";
							break;
									
									
						case \'9\':
						case \'11\':
						case \'12\':
						case \'13\':
						case \'14\':
						case \'16\':
						case \'42\':
							meteo = "snow";
							back_g = "wheater_snow";
							break;
										
						case \'19\':
						case \'20\':
						case \'21\':
						case \'22\':
						case \'23\':
							meteo = "fog";
							back_g = "wheater_cloudy";
							break;
										
						case \'19\':
						case \'20\':
						case \'21\':
						case \'22\':
						case \'23\':
							meteo = "fog";
							back_g = "wheater_cloudy";
							break;
										
						case \'24\':
						case \'25\':
							meteo = "wind";
							back_g = "wheater_wind";
							break;    
											
						case \'27\':
						case \'29\':
						case \'44\':
							meteo = "partly-cloudy-night";
							back_g = "wheater_cloudy";
							break; 
										
						case \'28\':
						case \'30\':
							meteo = "wind";
							back_g = "wheater_wind";
							break;
										
						case \'31\':
						case \'33\':
							meteo = "clear-night";
							back_g = "wheater_sunny2";
							break;    
											
						case \'32\':
						case \'34\':
						case \'36\':
							meteo = "clear-day";
							back_g = "wheater_sunny";
							break;
										
						case \'26\':
							meteo = "cloudy";
							back_g = "wheater_cloudy";
							break;
													 
					}
								
					html  = \'<div class="card_weather" style="background-image: url('.DB_SITE_REPO.'/Legacy/1tek_public/img/\'+back_g+\'.jpg);">\';
					html += \'	<ul class="list-inline">\';
					html += \'		<li><canvas id="\'+meteo+\'" width="30" height="30"></canvas></li>\';
					html += \'		<li>\'+weather.currently+\'</li>\';
					html += \'	</ul>\';
					html += \'	<h1>\'+weather.temp+\'&deg;\'+weather.units.temp+\'</h1>\';
					html += \'	<div class="date">\';
					html += \'		<h3 id="hora_actual"></h3>\';
					html += \'	</div>\';
					html += \'	<a target="_blank" rel="noopener noreferrer" href="'.$subconsulta['Wheater'].'" class="city">'.$comuna.', Chile</a>\';
					html += \'</div>\';
								
						
					$("#card_weather").html(html);
					setInterval("actualiza_hora()", 1000);
							  
					//agrego los icono animados
					var icons = new Skycons({"color": "white"}),
								list  = [
									"clear-day", "clear-night", "partly-cloudy-day",
									"partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
									"fog"
								],
								i;

					for(i = list.length; i--; )
						icons.set(list[i], list[i]);
						icons.play();
							  
				},
				error: function(error) {
					$("#card_weather").html(\'<p>\'+error+\'</p>\');
				}
			});
						  
												  
						  
		});
						
		function actualiza_hora() {

			marcacion = new Date()
			Hora = marcacion.getHours()
			Minutos = marcacion.getMinutes()
			Segundos = marcacion.getSeconds()

			/* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
			if (Hora <= 9) Hora = "0" + Hora
			if (Minutos <= 9) Minutos = "0" + Minutos
			if (Segundos <= 9) Segundos = "0" + Segundos

			/* Capturamos una celda para mostrar el Reloj */
			document.getElementById("hora_actual").innerHTML = Hora + ":" + Minutos + ":" + Segundos;

		}
	</script>';
			
			
echo '</div>';


?>
