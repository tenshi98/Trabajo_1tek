<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1002-005).');
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Mostrar mapa desde latitud y longitud
*
*===========================     Detalles    ===========================
* Despliega un mapa desde una latitud y longitud entregadas, se genera un
* infowindow en el marcador centrado
*===========================    Modo de uso  ===========================
*
* 	//generar mapa
* 	mapa_from_gps('-77.5', '-33.6', 'Casa', 'mi casa', 'descripcion de la casa', 'xxKeyGooglexx', 15, 1);
*
*===========================    Parametros   ===========================
* Decimal  $Latitud      Latitud de la ubicacion
* Decimal  $Longitud     Longitud de la ubicacion
* String   $Titulo       Titulo del InfoWindow
* String   $SubTitulo    SubTitulo del InfoWindow
* String   $Contenido    Contenido del InfoWindow
* String   $IDGoogle     API de Google Maps
* int      $zoom_map     Zoom del mapa
* int      $MapTypeId    Tipo de mapa
* @return  html
************************************************************************/
//Funcion
function mapa_from_gps($Latitud, $Longitud, $Titulo, $SubTitulo, $Contenido, $IDGoogle, $zoom_map, $MapTypeId){

	/**********************/
	//Var
	$CountError = 0;
	$DataError  = 'Errores:';
	//Validaciones
	if(!isset($Latitud) OR $Latitud==''){    $CountError++; $DataError .= '<br/> - No ha ingresado la Latitud.';}
	if(!isset($Longitud) OR $Longitud==''){  $CountError++; $DataError .= '<br/> - No ha ingresado la Longitud.';}
	if(!isset($Titulo) OR $Titulo==''){      $CountError++; $DataError .= '<br/> - No ha ingresado el Titulo.';}
	if(!isset($IDGoogle) OR $IDGoogle==''){  $CountError++; $DataError .= '<br/> - No ha ingresado Una API de Google Maps.';}

	/**********************/
	//Si todo esta ok
	if($CountError!=0){
		$Error  = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
		$Error .= alert_post_data(4,1,1,0, $DataError);
		$Error .= '</div>';
		return $Error;

	}elseif($CountError==0){
		/**********************/
		//Valido
		if(!isset($Titulo) OR $Titulo==''){                     $S_titulo    = 'Sin Titulo';    }else{ $S_titulo    = $Titulo;}    //Si no existe el titulo
		if(!isset($SubTitulo) OR $SubTitulo==''){               $S_Subtitulo = 'Sin SubTitulo'; }else{ $S_Subtitulo = $SubTitulo;} //Si no existe el subtitulo
		if(!isset($Contenido) OR $Contenido==''){               $S_contenido = 'Sin Contenido'; }else{ $S_contenido = $Contenido;} //Si no existe el titulo
		if(!isset($zoom_map) OR $zoom_map=='' OR $zoom_map==0){ $int_map     = 18;              }else{ $int_map      = $zoom_map;} //Si no existe zoom de mapa
		//si no existe un tipo de mapa
		if(!isset($MapTypeId) OR $MapTypeId=='' OR $MapTypeId==0){
			$int_map_type = 'ROADMAP';
		}else{
			switch ($MapTypeId) {
				case 1: $int_map_type = 'ROADMAP';   break; //muestra la vista predeterminada del mapa de carreteras. Este es el tipo de mapa predeterminado.
				case 2: $int_map_type = 'SATELLITE'; break; //muestra imágenes de satélite de Google Earth.
				case 3: $int_map_type = 'HYBRID';    break; //muestra una mezcla de vistas normales y de satélite.
				case 4: $int_map_type = 'TERRAIN';   break; //muestra un mapa físico basado en la información del terreno.
			}
		}
		/**********************/
		$mapa = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$IDGoogle.'&callback=initMap"></script>
		<script type="text/javascript">
			let map;

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng('.$Latitud.', '.$Longitud.');

				var myOptions = {
					zoom: '.$int_map.',
					scrollwheel: false,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.'.$int_map_type.'
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);

				// marker position
				var factory = new google.maps.LatLng('.$Latitud.', '.$Longitud.');

				// InfoWindow content
				var content = 	\'<div id="iw-container">\' +
								\'<div class="iw-title">'.$S_titulo.'</div>\' +
								\'<div class="iw-content">\' +
								\'<div class="iw-subTitle">'.$S_Subtitulo.'</div>\' +
								\'<p>'.$S_contenido.'</p>\' +
								\'</div>\' +
								\'<div class="iw-bottom-gradient"></div>\' +
								\'</div>\';

				// A new Info Window is created and set content
				var infowindow = new google.maps.InfoWindow({
					content: content,
					maxWidth: 350
				});

				// marker options
				var marker = new google.maps.Marker({
					position	: factory,
					map			: map,
					title		: "Dirección",
					animation 	: google.maps.Animation.DROP,
					icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
				});

				// This event expects a click on a marker
				// When this event is fired the Info Window is opened.
				google.maps.event.addListener(marker, \'click\', function() {
					infowindow.open(map,marker);
				});

				// Event that closes the Info Window with a click on the map
				google.maps.event.addListener(map, \'click\', function() {
					infowindow.close();
				});

				// *
				// START INFOWINDOW CUSTOMIZE.
				// The google.maps.event.addListener() event expects
				// the creation of the infowindow HTML structure \'domready\'
				// and before the opening of the infowindow, defined styles are applied.
				// *
				google.maps.event.addListener(infowindow, \'domready\', function() {

					// Reference to the DIV that wraps the bottom of infowindow
					var iwOuter = $(\'.gm-style-iw\');

					/* Since this div is in a position prior to .gm-div style-iw.
					* We use jQuery and create a iwBackground variable,
					* and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
					*/
					var iwBackground = iwOuter.prev();

					// Removes background shadow DIV
					iwBackground.children(\':nth-child(2)\').css({\'display\' : \'none\'});

					// Removes white background DIV
					iwBackground.children(\':nth-child(4)\').css({\'display\' : \'none\'});

					// Moves the infowindow 25px to the right.
					//iwOuter.parent().parent().css({left: \'5px\'});

					// Moves the shadow of the arrow 76px to the left margin.
					iwBackground.children(\':nth-child(1)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

					// Moves the arrow 76px to the left margin.
					iwBackground.children(\':nth-child(3)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

					// Changes the desired tail shadow color.
					iwBackground.children(\':nth-child(3)\').find(\'div\').children().css({\'box-shadow\': \'rgba(72, 181, 233, 0.6) 0px 1px 6px\', \'z-index\' : \'1\'});

					// Reference to the div that groups the close button elements.
					var iwCloseBtn = iwOuter.next();

					// Apply the desired effect to the close button
					iwCloseBtn.css({width: \'28px\',height: \'28px\', opacity: \'1\', right: \'38px\', top: \'3px\', border: \'7px solid #48b5e9\', \'border-radius\': \'13px\', \'box-shadow\': \'0 0 5px #3990B9\'});

					// If the content of infowindow not exceed the set maximum height, then the gradient is removed.
					if($(\'.iw-content\').height() < 140){
						$(\'.iw-bottom-gradient\').css({display: \'none\'});
					}

					// The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
					iwCloseBtn.mouseout(function(){
						$(this).css({opacity: \'1\'});
					});
				});

				//muestro la infowindow al inicio
				infowindow.open(map,marker);

			}
		</script>
		<div id="map_canvas" style="width:100%; height:500px"></div>';

		/**********************/
		//devuelvo
		return $mapa;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Mostrar mapa desde una direccion
*
*===========================     Detalles    ===========================
* Despliega un mapa desde una ubicacion entregada, se genera un
* infowindow en el marcador centrado
*===========================    Modo de uso  ===========================
*
* 	//generar mapa
* 	mapa_from_direccion('mi casa 123', 'descripcion de la casa', 'xxKeyGooglexx', 15, 1);
*
*===========================    Parametros   ===========================
* String   $Ubicacion    Direccion de la ubicacion
* String   $explanation  Contenido del InfoWindow
* String   $IDGoogle     API de Google Maps
* int      $zoom_map     Zoom del mapa
* int      $MapTypeId    Tipo de mapa
* @return  html
************************************************************************/
//Funcion
function mapa_from_direccion($Ubicacion, $explanation, $IDGoogle, $zoom_map, $MapTypeId){

	/**********************/
	//Var
	$CountError = 0;
	$DataError  = 'Errores:';
	//Validaciones
	if(!isset($Ubicacion) OR $Ubicacion==''){      $CountError++; $DataError .= '<br/> - No ha ingresado la Ubicacion.';}
	if(!isset($explanation) OR $explanation==''){  $CountError++; $DataError .= '<br/> - No ha ingresado la Descripcion.';}
	if(!isset($IDGoogle) OR $IDGoogle==''){        $CountError++; $DataError .= '<br/> - No ha ingresado Una API de Google Maps.';}

	/**********************/
	//Si todo esta ok
	if($CountError!=0){
		$Error  = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
		$Error .= alert_post_data(4,1,1,0, $DataError);
		$Error .= '</div>';
		return $Error;

	}elseif($CountError==0){
		/**********************/
		//Se limpian los nombres
		$Ubicacion = str_replace('Nº', '', $Ubicacion);
		$Ubicacion = str_replace('nº', '', $Ubicacion);
		$Ubicacion = str_replace(' n ', '', $Ubicacion);
		$Ubicacion = str_replace("'", '', $Ubicacion);
		$Ubicacion = str_replace("Av.", 'Avenida', $Ubicacion);
		$Ubicacion = str_replace("av.", 'Avenida', $Ubicacion);

		//validaciones
		if(isset($explanation)&&$explanation!=''&&$explanation!=0){ $datasig = $explanation; }else{$datasig = $Ubicacion; } //Verifico si lleva datos extras
		if(!isset($zoom_map) OR $zoom_map=='' OR $zoom_map==0){     $int_map = 18;           }else{$int_map = $zoom_map;}   //Si no existe zoom de mapa
		//si no existe un tipo de mapa
		if(!isset($MapTypeId) OR $MapTypeId=='' OR $MapTypeId==0){
			$int_map_type = 'ROADMAP';
		}else{
			switch ($MapTypeId) {
				case 1: $int_map_type = 'ROADMAP';   break; //muestra la vista predeterminada del mapa de carreteras. Este es el tipo de mapa predeterminado.
				case 2: $int_map_type = 'SATELLITE'; break;//muestra imágenes de satélite de Google Earth.
				case 3: $int_map_type = 'HYBRID';    break;//muestra una mezcla de vistas normales y de satélite.
				case 4: $int_map_type = 'TERRAIN';   break;//muestra un mapa físico basado en la información del terreno.
			}
		}
		/**********************/
		$mapa = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$IDGoogle.'&callback=initMap"></script>
		<script>
			let map;
			var geocoder;
			var _infoBox;

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				geocoder = new google.maps.Geocoder();

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: '.$int_map.',
					scrollwheel: false,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.'.$int_map_type.'
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);

				codeAddress();
			}

			function codeAddress() {

				geocoder.geocode( { \'address\': \''.$Ubicacion.'\'}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {

						// marker position
						var factory = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

						// InfoWindow content
						var content = 	\'<div id="iw-container">\' +
										\'<div class="iw-title">Dirección</div>\' +
										\'<div class="iw-content">\' +
										\'<div class="iw-subTitle">Calle</div>\' +
										\'<p>'.$datasig.'</p>\' +
										\'</div>\' +
										\'<div class="iw-bottom-gradient"></div>\' +
										\'</div>\';

						// A new Info Window is created and set content
						var infowindow = new google.maps.InfoWindow({
							content: content,
							maxWidth: 350
						});

						// marker options
						var marker = new google.maps.Marker({
							position	: factory,
							map			: map,
							title		: "Dirección",
							animation 	: google.maps.Animation.DROP,
							icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
						});

						// This event expects a click on a marker
						// When this event is fired the Info Window is opened.
						google.maps.event.addListener(marker, \'click\', function() {
							infowindow.open(map,marker);
						});

						// Event that closes the Info Window with a click on the map
						google.maps.event.addListener(map, \'click\', function() {
							infowindow.close();
						});

						// *
						// START INFOWINDOW CUSTOMIZE.
						// The google.maps.event.addListener() event expects
						// the creation of the infowindow HTML structure \'domready\'
						// and before the opening of the infowindow, defined styles are applied.
						// *
						google.maps.event.addListener(infowindow, \'domready\', function() {

							// Reference to the DIV that wraps the bottom of infowindow
							var iwOuter = $(\'.gm-style-iw\');

							/* Since this div is in a position prior to .gm-div style-iw.
							* We use jQuery and create a iwBackground variable,
							* and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
							*/
							var iwBackground = iwOuter.prev();

							// Removes background shadow DIV
							iwBackground.children(\':nth-child(2)\').css({\'display\' : \'none\'});

							// Removes white background DIV
							iwBackground.children(\':nth-child(4)\').css({\'display\' : \'none\'});

							// Moves the infowindow 25px to the right.
							//iwOuter.parent().parent().css({left: \'5px\'});

							// Moves the shadow of the arrow 76px to the left margin.
							iwBackground.children(\':nth-child(1)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

							// Moves the arrow 76px to the left margin.
							iwBackground.children(\':nth-child(3)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

							// Changes the desired tail shadow color.
							iwBackground.children(\':nth-child(3)\').find(\'div\').children().css({\'box-shadow\': \'rgba(72, 181, 233, 0.6) 0px 1px 6px\', \'z-index\' : \'1\'});

							// Reference to the div that groups the close button elements.
							var iwCloseBtn = iwOuter.next();

							// Apply the desired effect to the close button
							iwCloseBtn.css({width: \'28px\',height: \'28px\', opacity: \'1\', right: \'38px\', top: \'3px\', border: \'7px solid #48b5e9\', \'border-radius\': \'13px\', \'box-shadow\': \'0 0 5px #3990B9\'});

							// If the content of infowindow not exceed the set maximum height, then the gradient is removed.
							if($(\'.iw-content\').height() < 140){
								$(\'.iw-bottom-gradient\').css({display: \'none\'});
							}

							// The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
							iwCloseBtn.mouseout(function(){
								$(this).css({opacity: \'1\'});
							});
						});

						//muestro la infowindow al inicio
						infowindow.open(map,marker);


					} else {
						alert(\'Geocode was not successful for the following reason: \' + status);
					}
				});
			}

		</script>
		<div id="map_canvas" style="width:100%; height:500px"></div>';

		/**********************/
		//devuelvo
		return $mapa;

	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Mostrar mapa desde dos ubicaciones
*
*===========================     Detalles    ===========================
* Despliega un mapa desde dos ubicaciones entregadas, se genera un
* infowindow en el marcador de ambas ubicaciones
*===========================    Modo de uso  ===========================
*
* 	//generar mapa
* 	mapa_from_ubicacion_mixta('mi casa 123', 'descripcion de la casa', 'mi casa 567', 'descripcion de la casa', 'xxKeyGooglexx', 'Div_ex');
*
*===========================    Parametros   ===========================
* String   $Ubicacion_1    Direccion de la ubicacion
* String   $explanation_1  Contenido del InfoWindow
* String   $Ubicacion_2    Direccion de la ubicacion
* String   $explanation_2  Contenido del InfoWindow
* String   $IDGoogle       API de Google Maps
* String   $identificador  ID del div donde se dibuja el html
* @return  html
************************************************************************/
//Funcion
//Despliega un mapa en base a los datos entregados
function mapa_from_ubicacion_mixta($Ubicacion_1, $explanation_1,$Ubicacion_2, $explanation_2, $IDGoogle, $identificador){

	/**********************/
	//Var
	$CountError = 0;
	$DataError  = 'Errores:';
	//Validaciones
	if(!isset($Ubicacion_1) OR $Ubicacion_1==''){      $CountError++; $DataError .= '<br/> - No ha ingresado la Ubicacion.';}
	if(!isset($explanation_1) OR $explanation_1==''){  $CountError++; $DataError .= '<br/> - No ha ingresado la Descripcion.';}
	if(!isset($Ubicacion_2) OR $Ubicacion_2==''){      $CountError++; $DataError .= '<br/> - No ha ingresado la Ubicacion.';}
	if(!isset($explanation_2) OR $explanation_2==''){  $CountError++; $DataError .= '<br/> - No ha ingresado la Descripcion.';}
	if(!isset($IDGoogle) OR $IDGoogle==''){            $CountError++; $DataError .= '<br/> - No ha ingresado Una API de Google Maps.';}
	if(!isset($identificador) OR $identificador==''){  $CountError++; $DataError .= '<br/> - No ha ingresado el identificador.';}

	/**********************/
	//Si todo esta ok
	if($CountError!=0){
		$Error  = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
		$Error .= alert_post_data(4,1,1,0, $DataError);
		$Error .= '</div>';
		return $Error;

	}elseif($CountError==0){
		/**********************/
		//Se limpian los nombres
		$Ubicacion_1 = str_replace('Nº', '', $Ubicacion_1);
		$Ubicacion_1 = str_replace('nº', '', $Ubicacion_1);
		$Ubicacion_1 = str_replace(' n ', '', $Ubicacion_1);
		$Ubicacion_1 = str_replace("'", '', $Ubicacion_1);
		$Ubicacion_1 = str_replace("Av.", 'Avenida', $Ubicacion_1);
		$Ubicacion_1 = str_replace("av.", 'Avenida', $Ubicacion_1);
		/****/
		$Ubicacion_2 = str_replace('Nº', '', $Ubicacion_2);
		$Ubicacion_2 = str_replace('nº', '', $Ubicacion_2);
		$Ubicacion_2 = str_replace(' n ', '', $Ubicacion_2);
		$Ubicacion_2 = str_replace("'", '', $Ubicacion_2);
		$Ubicacion_2 = str_replace("Av.", 'Avenida', $Ubicacion_2);
		$Ubicacion_2 = str_replace("av.", 'Avenida', $Ubicacion_2);

		//Verifico si lleva datos extras
		if(isset($explanation_1)&&$explanation_1!=''&&$explanation_1!=0){
			$datasig_1 = $explanation_1;
		}else{
			$datasig_1 = $Ubicacion_1;
		}
		/*****/
		//Verifico si lleva datos extras
		if(isset($explanation_2)&&$explanation_2!=''&&$explanation_2!=0){
			$datasig_2 = $explanation_2;
		}else{
			$datasig_2 = $Ubicacion_2;
		}
		/**********************/
		$mapa = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$IDGoogle.'&callback=initMap_'.$identificador.'"></script>
		<script>
			let map_'.$identificador.';
			var geocoder;

			async function initMap_'.$identificador.'() {
				const { Map } = await google.maps.importLibrary("maps");

				geocoder = new google.maps.Geocoder();

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 15,
					center: myLatlng
				};

				map_'.$identificador.' = new Map(document.getElementById("'.$identificador.'"), myOptions);
				codeAddress_'.$identificador.'();
			}

			function codeAddress_'.$identificador.'() {
				bounds  = new google.maps.LatLngBounds();

				geocoder.geocode( { \'address\': \''.$Ubicacion_1.'\'}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {

						// marker position
						var factory_1 = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

						// InfoWindow content
						var content = 	\'<div id="iw-container">\' +
										\'<div class="iw-title">Dirección</div>\' +
										\'<div class="iw-content">\' +
										\'<div class="iw-subTitle">Calle</div>\' +
										\'<p>'.$datasig_1.'</p>\' +
										\'</div>\' +
										\'<div class="iw-bottom-gradient"></div>\' +
										\'</div>\';

						// A new Info Window is created and set content
						var infowindow = new google.maps.InfoWindow({
							content: content,
							maxWidth: 350
						});

						// marker options
						var marker_1 = new google.maps.Marker({
							position	: factory_1,
							map			: map_'.$identificador.',
							title		: "Dirección",
							animation 	: google.maps.Animation.DROP,
							icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
						});

						// This event expects a click on a marker_1
						// When this event is fired the Info Window is opened.
						google.maps.event.addListener(marker_1, \'click\', function() {
							infowindow.open(map_'.$identificador.',marker_1);
						});

						// Event that closes the Info Window with a click on the map
						google.maps.event.addListener(map, \'click\', function() {
							infowindow.close();
						});

						// *
						// START INFOWINDOW CUSTOMIZE.
						// The google.maps.event.addListener() event expects
						// the creation of the infowindow HTML structure \'domready\'
						// and before the opening of the infowindow, defined styles are applied.
						// *
						google.maps.event.addListener(infowindow, \'domready\', function() {

							// Reference to the DIV that wraps the bottom of infowindow
							var iwOuter = $(\'.gm-style-iw\');

							/* Since this div is in a position prior to .gm-div style-iw.
							* We use jQuery and create a iwBackground variable,
							* and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
							*/
							var iwBackground = iwOuter.prev();

							// Removes background shadow DIV
							iwBackground.children(\':nth-child(2)\').css({\'display\' : \'none\'});

							// Removes white background DIV
							iwBackground.children(\':nth-child(4)\').css({\'display\' : \'none\'});

							// Moves the infowindow 25px to the right.
							//iwOuter.parent().parent().css({left: \'5px\'});

							// Moves the shadow of the arrow 76px to the left margin.
							iwBackground.children(\':nth-child(1)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

							// Moves the arrow 76px to the left margin.
							iwBackground.children(\':nth-child(3)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

							// Changes the desired tail shadow color.
							iwBackground.children(\':nth-child(3)\').find(\'div\').children().css({\'box-shadow\': \'rgba(72, 181, 233, 0.6) 0px 1px 6px\', \'z-index\' : \'1\'});

							// Reference to the div that groups the close button elements.
							var iwCloseBtn = iwOuter.next();

							// Apply the desired effect to the close button
							iwCloseBtn.css({width: \'28px\',height: \'28px\', opacity: \'1\', right: \'38px\', top: \'3px\', border: \'7px solid #48b5e9\', \'border-radius\': \'13px\', \'box-shadow\': \'0 0 5px #3990B9\'});

							// If the content of infowindow not exceed the set maximum height, then the gradient is removed.
							if($(\'.iw-content\').height() < 140){
								$(\'.iw-bottom-gradient\').css({display: \'none\'});
							}

							// The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
							iwCloseBtn.mouseout(function(){
								$(this).css({opacity: \'1\'});
							});
						});

						//muestro la infowindow al inicio
						infowindow.open(map_'.$identificador.',marker_1);

						/*var marker_1 = new google.maps.Marker({
									position:  new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()),
									map: map_'.$identificador.',
									title:"Marcador"

								});
						var infowindow = new google.maps.InfoWindow({
							content: "'.$datasig_1.'"
						});
						marker_1.addListener(\'click\', function() {
							infowindow.open(map_'.$identificador.', marker_1);
						});
						infowindow.open(map_'.$identificador.', marker_1);*/

						loc = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
						bounds.extend(loc);

					} else {
						alert(\'Geocode was not successful for the following reason: \' + status);
					}
				});

				geocoder.geocode( { \'address\': \''.$Ubicacion_2.'\'}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {

						// marker position
						var factory_2 = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

						// InfoWindow content
						var content = 	\'<div id="iw-container">\' +
										\'<div class="iw-title">Dirección</div>\' +
										\'<div class="iw-content">\' +
										\'<div class="iw-subTitle">Calle</div>\' +
										\'<p>'.$datasig_2.'</p>\' +
										\'</div>\' +
										\'<div class="iw-bottom-gradient"></div>\' +
										\'</div>\';

						// A new Info Window is created and set content
						var infowindow = new google.maps.InfoWindow({
							content: content,
							maxWidth: 350
						});

						// marker options
						var marker_2 = new google.maps.Marker({
							position	: factory_2,
							map			: map_'.$identificador.',
							title		: "Dirección",
							animation 	: google.maps.Animation.DROP,
							icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png"
						});

						// This event expects a click on a marker_2
						// When this event is fired the Info Window is opened.
						google.maps.event.addListener(marker_2, \'click\', function() {
							infowindow.open(map_'.$identificador.',marker_2);
						});

						// Event that closes the Info Window with a click on the map
						google.maps.event.addListener(map, \'click\', function() {
							infowindow.close();
						});

						// *
						// START INFOWINDOW CUSTOMIZE.
						// The google.maps.event.addListener() event expects
						// the creation of the infowindow HTML structure \'domready\'
						// and before the opening of the infowindow, defined styles are applied.
						// *
						google.maps.event.addListener(infowindow, \'domready\', function() {

							// Reference to the DIV that wraps the bottom of infowindow
							var iwOuter = $(\'.gm-style-iw\');

							/* Since this div is in a position prior to .gm-div style-iw.
							* We use jQuery and create a iwBackground variable,
							* and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
							*/
							var iwBackground = iwOuter.prev();

							// Removes background shadow DIV
							iwBackground.children(\':nth-child(2)\').css({\'display\' : \'none\'});

							// Removes white background DIV
							iwBackground.children(\':nth-child(4)\').css({\'display\' : \'none\'});

							// Moves the infowindow 25px to the right.
							//iwOuter.parent().parent().css({left: \'5px\'});

							// Moves the shadow of the arrow 76px to the left margin.
							iwBackground.children(\':nth-child(1)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

							// Moves the arrow 76px to the left margin.
							iwBackground.children(\':nth-child(3)\').attr(\'style\', function(i,s){ return s + \'left: 6px !important;\'});

							// Changes the desired tail shadow color.
							iwBackground.children(\':nth-child(3)\').find(\'div\').children().css({\'box-shadow\': \'rgba(72, 181, 233, 0.6) 0px 1px 6px\', \'z-index\' : \'1\'});

							// Reference to the div that groups the close button elements.
							var iwCloseBtn = iwOuter.next();

							// Apply the desired effect to the close button
							iwCloseBtn.css({width: \'28px\',height: \'28px\', opacity: \'1\', right: \'38px\', top: \'3px\', border: \'7px solid #48b5e9\', \'border-radius\': \'13px\', \'box-shadow\': \'0 0 5px #3990B9\'});

							// If the content of infowindow not exceed the set maximum height, then the gradient is removed.
							if($(\'.iw-content\').height() < 140){
								$(\'.iw-bottom-gradient\').css({display: \'none\'});
							}

							// The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
							iwCloseBtn.mouseout(function(){
								$(this).css({opacity: \'1\'});
							});
						});

						//muestro la infowindow al inicio
						infowindow.open(map_'.$identificador.',marker_2);

						/*var marker_2 = new google.maps.Marker({
									position:  new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()),
									map: map_'.$identificador.',
									title:"Marcador"

								});
						var infowindow = new google.maps.InfoWindow({
							content: "'.$datasig_2.'"
						});
						marker_2.addListener(\'click\', function() {
							infowindow.open(map_'.$identificador.', marker_2);
						});
						infowindow.open(map_'.$identificador.', marker_2);*/

						loc = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
						bounds.extend(loc);
						//centralizado y redimensionado del mapa
						map_'.$identificador.'.fitBounds(bounds);
						map_'.$identificador.'.panToBounds(bounds);

					} else {
						alert(\'Geocode was not successful for the following reason: \' + status);
					}
				});
			}

		</script>
		<div id="'.$identificador.'" style="width:100%; height:500px"></div>';

		/**********************/
		//devuelvo
		return $mapa;

	}

}


?>
