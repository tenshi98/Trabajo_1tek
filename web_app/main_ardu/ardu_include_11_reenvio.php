<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                  GUARDADO DE LOS DATOS EN UN ARCHIVO TXT                           */
/*                                                                                                    */
/******************************************************************************************************/
switch ($Identificador) {
	case 'AAA1':
	case 'AAA2':
		$Reenvio_web   = 'http://webapp.CAMBIAME.cl/main_ardu/ardu.php';
		/*************************************************/
		//Funcion para envio de datos
		function curl_do_api($url){
			if (!function_exists('curl_init')){
				//die('Sorry cURL is not installed!');
				//si no esta instalado muestra un error
				error_log("========================================================================================================================================", 0);
				error_log("cURL no esta instalado", 0);
				error_log("-------------------------------------------------------------------", 0);
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}

		/*************************************************/
		//Se crea la dirección de envio de datos
		$envio  = $Reenvio_web;
		$envio .= '?id='.$Identificador;
		if(isset($Fecha)&&$Fecha!=''){                  $envio .= '&f='.$Fecha;}
		if(isset($Hora)&&$Hora!=''){                    $envio .= '&h='.$Hora;}
		if(isset($GeoLatitud)&&$GeoLatitud!=''){        $envio .= '&lt='.$GeoLatitud;}
		if(isset($GeoLongitud)&&$GeoLongitud!=''){      $envio .= '&lg='.$GeoLongitud;}
		if(isset($GeoVelocidad)&&$GeoVelocidad!=''){    $envio .= '&v='.$GeoVelocidad;}
		if(isset($GeoDireccion)&&$GeoDireccion!=''){    $envio .= '&d='.$GeoDireccion;}
		if(isset($GeoMovimiento)&&$GeoMovimiento!=''){  $envio .= '&m='.$GeoMovimiento;}
		if(isset($lock)&&$lock!=''){                    $envio .= '&lock='.$lock;}
		//variables
		for ($i = 1; $i <= 60; $i++) {
			if(isset($Sensor[$i]['valor']) && $Sensor[$i]['valor']!=''){
				$envio .= '&s'.$i.'='.$Sensor[$i]['valor'];
			}
		}

		/*************************************************/
		//Se envian los datos
		curl_do_api($envio);
		error_log($envio, 0);
	break;


}



?>
