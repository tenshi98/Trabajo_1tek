<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1002-003).');
}
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Previsualiza el PDF
*
*===========================     Detalles    ===========================
* Permite previsualizar un archivo PDF
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	preview_pdf('Pdf_viewer', 'upload/archivo.pdf');
*
*===========================    Parametros   ===========================
* String   $idDiv     Identificador del div
* String   $Route     Ruta de acceso del archivo
* @return  html
************************************************************************/
//Funcion
function preview_pdf($idDiv, $Route){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){  return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($Route) OR $Route==''){  return alert_post_data(4,1,1,0,'No ha ingresado la Ruta de acceso del archivo.');}

	/**********************/
	//Si todo esta ok
	$input = '
	<div id="'.$idDiv.'"></div>
	<script src="'.DB_SITE_REPO.'/LIBS_js/PDFObject/pdfobject.js"></script>
	<script>PDFObject.embed("'.$Route.'", "#'.$idDiv.'");</script>
	<style>
		.pdfobject-container { height: 500px;}
		.pdfobject { border: 1px solid #666; }
	</style>';

	/**********************/
	//devuelvo
	return $input;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Descargar archivos
*
*===========================     Detalles    ===========================
* permite descargar los documentos
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	download_docs($file_path, $file, $extensions, $mainSite, $EmpPath);
*
*===========================    Parametros   ===========================
* String   $file_path    Carpeta contenedora
* String   $file         Nombre del archivo
* String   $extensions   Extension del archivo
* String   $mainSite     Direccion root de la pagina
* String   $EmpPath      Ruta hasta la carpeta contenedora
* @return  html
************************************************************************/
//Funcion
//
function download_docs($file_path, $file, $extensions, $mainSite, $EmpPath){

	/**********************/
	//Validaciones
	if(!isset($file_path) OR $file_path==''){    return alert_post_data(4,1,1,0,'No ha ingresado la Carpeta contenedora.');}
	if(!isset($file) OR $file==''){              return alert_post_data(4,1,1,0,'No ha ingresado el Nombre del archivo.');}
	if(!isset($extensions) OR $extensions==''){  return alert_post_data(4,1,1,0,'No ha ingresado la Extension del archivo.');}
	if(!isset($mainSite) OR $mainSite==''){      return alert_post_data(4,1,1,0,'No ha ingresado la Direccion root de la pagina.');}
	if(!isset($EmpPath) OR $EmpPath==''){        return alert_post_data(4,1,1,0,'No ha ingresado la Ruta hasta la carpeta contenedora.');}

	/**********************/
	//Si todo esta ok
	/****************************************/
	//Definicion de directorio y carpeta contenedora
	$destination_path = '';
	if($mainSite!=''){  $destination_path  = $mainSite; }  //directorio raiz
	if($EmpPath!=''){   $destination_path .= $EmpPath;  }  //carpeta contenedora

	/****************************************/
	//se verifican las extensiones admitidas
	if($extensions!=''){
		$exten = $extensions;
	}else{
		$exten  = 'JPG,jpg,jpeg,gif,png,bmp';       //Imagenes
		$exten .= ',doc,docx,xls,xlsx,ppt,pptx';    //archivos microsoft office
		$exten .= ',odt,odp,ods';                   //archivos libre office
		$exten .= ',pdf';                           //pdf
		$exten .= ',mp3,oga';                       //Audio
		$exten .= ',mp4,webm,ogv';                  //Video
		$exten .= ',txt';                           //texto plano
	}

	/****************************************/
	//Se verifica si el archivo dado esta dentro de los permitidos
	$path       = $destination_path.$file_path.'/'.$file;
	$ext        = pathinfo($path, PATHINFO_EXTENSION);
	$num_files  = glob($path.".{".$exten."}", GLOB_BRACE);
	//$Filesize   = filesize($path);

	/****************************************/
	//Si existen archivos
	if($num_files > 0){
		//selecciono el tipo mime a partir de la extension
		switch ($ext) {
			case 'JPG':  $aplication = 'image/jpeg'; break;
			case 'jpg':  $aplication = 'image/jpeg'; break;
			case 'jpeg': $aplication = 'image/jpeg'; break;
			case 'gif':  $aplication = 'image/gif'; break;
			case 'png':  $aplication = 'image/png'; break;
			case 'bmp':  $aplication = 'image/bmp'; break;
			case 'doc':  $aplication = 'application/vnd.ms-word'; break;
			case 'docx': $aplication = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'; break;
			case 'xls':  $aplication = 'application/vnd.ms-excel'; break;
			case 'xlsx': $aplication = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'; break;
			case 'ppt':  $aplication = 'application/vnd.ms-powerpoint'; break;
			case 'pptx': $aplication = 'application/vnd.openxmlformats-officedocument.presentationml.presentation'; break;
			case 'odt':  $aplication = 'application/vnd.oasis.opendocument.text'; break;
			case 'odp':  $aplication = 'application/vnd.oasis.opendocument.presentation'; break;
			case 'ods':  $aplication = 'application/vnd.oasis.opendocument.spreadsheet'; break;
			case 'pdf':  $aplication = 'application/pdf'; break;
			case 'mp3':  $aplication = 'audio/mpeg'; break;
			case 'webm': $aplication = 'video/webm'; break;
			case 'oga':  $aplication = 'audio/ogg'; break;
			case 'ogv':  $aplication = 'video/ogg'; break;
			case 'txt':  $aplication = 'text/plain'; break;

			default:   $aplication = 'application/octet-stream';

		}

		//header ("Content-Disposition: attachment; filename=".$file." ");
		//header ("Content-Type: ".$aplication." ");
		//header ("Content-Length: ".$Filesize);
		//readfile($path);

		//echo $file.'<br/>';
		//echo $aplication.'<br/>';

		header ("Content-Disposition: attachment; filename=".$file." ");
		header ("Content-Type: application/octet-stream");
		header ("Content-Length: ".filesize($path));
		readfile($path);


	}else{
		$Alert_Text  = 'Tipo de archivo no soportado';
		alert_post_data(4,2,2,0, $Alert_Text);
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Previsualizacion de archivos
*
*===========================     Detalles    ===========================
* Permite ver un preview de los documentos
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $Root       Ruta a la carpeta contenedora
* String   $File       Nombre del archivo
* String   $ExtraData  Informacion extra para los archivos kmz
* @return  html
************************************************************************/
//Funcion
//
function preview_docs($Root, $File, $ExtraData){

	/**********************/
	//Validaciones
	if(!isset($Root) OR $Root==''){             return alert_post_data(4,1,1,0,'No ha ingresado la Ruta a la carpeta contenedora.');}
	if(!isset($File) OR $File==''){             return alert_post_data(4,1,1,0,'No ha ingresado el Nombre del archivo.');}
	//if(!isset($ExtraData) OR $ExtraData==''){   return alert_post_data(4,1,1,0,'No ha ingresado la Informacion extra para los archivos kmz.');}

	/**********************/
	//Si todo esta ok
	/****************************************/
	//se verifican las extensiones
	$exten  = 'JPG,jpg,jpeg,gif,png,bmp';           //Imagenes
	$exten .= ',doc,docx,xls,xlsx,ppt,pptx';        //archivos microsoft office
	$exten .= ',odt,odp,ods';                       //archivos libre office
	$exten .= ',pdf';                               //pdf
	$exten .= ',mp3,oga,wav';                       //Audio
	$exten .= ',mp4,webm,ogv,mp2,mpeg,mpg,mov,avi'; //Video
	$exten .= ',txt,rtf';                           //texto plano
	$exten .= ',gz,gzip,7Z,zip,rar';                //Archivos Comprimidos
	$exten .= ',kml,kmz';                           //Archivos de mapas

	/****************************************/
	//Se verifica si el archivo dado esta dentro de los permitidos
	$Extension  = pathinfo($File, PATHINFO_EXTENSION);
	$num_files  = glob($File.".{".$exten."}", GLOB_BRACE);

	/****************************************/
	//Se genera ruta del archivo
	$RutaCompleta = '';
	if(isset($Root)&&$Root!=''){ $RutaCompleta .= $Root.'/';}
	if(isset($File)&&$File!=''){ $RutaCompleta .= $File;}

	/****************************************/
	//Se agrega estilo
	$input = '
	<style>
		img {width: 100%;height: auto;padding: 0;margin: 0;}
		iframe {width: 100%;height: 100%;padding: 0;margin: 0;}
		iframe{float:right;height: 600px;}
	</style>';

	//Si existen archivos
	if($num_files > 0){

		switch($Extension){
			/**************************************************/
			//Si son imagenes
			case 'JPG'; case 'jpg'; case 'jpeg'; case 'gif'; case 'png'; case 'bmp';
				$input .= '<img src="'.$RutaCompleta.'" />';
			break;
			/**************************************************/
			//Si son archivos microsoft office
			case 'doc'; case 'docx'; case 'xls'; case 'xlsx'; case 'ppt'; case 'pptx';
				$input .= '
				<iframe src="https://view.officeapps.live.com/op/embed.aspx?src='.$RutaCompleta.'" frameborder="0">
					<a target="_blank" rel="noopener noreferrer" href="'.$RutaCompleta.'">Descargar Documento</a>
				</iframe>';
			break;
			/**************************************************/
			//Si son archivos open office y pdf
			case 'odt'; case 'odp'; case 'ods'; case 'pdf';
				$input .= '<iframe src = "'.DB_SITE_REPO.'/LIBS_js/ViewerJS/#../..'.DB_SITE_MAIN_PATH.'/'.$File.'" allowfullscreen webkitallowfullscreen></iframe>';
			break;
			/**************************************************/
			//Si son archivos de audio
			case 'mp3';
				$input .= '
				<link rel="stylesheet" type="text/css" href="'.DB_SITE_REPO.'/LIBS_js/audio_player/css/style.css">
				<div class="audio green-audio-player">
					<div class="loading">
						<div class="spinner"></div>
					</div>
					<div class="play-pause-btn">
						<svg xmlns="https://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24">
							<path fill="#566574" fill-rule="evenodd" d="M18 12L0 24V0" class="play-pause-icon" id="playPause"/>
						</svg>
					</div>

					<div class="controls">
						<span class="current-time">0:00</span>
						<div class="slider" data-direction="horizontal">
							<div class="progress">
								<div class="pin" id="progress-pin" data-method="rewind"></div>
							</div>
						</div>
						<span class="total-time">0:00</span>
					</div>

					<div class="volume">
						<div class="volume-btn">
							<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<path fill="#566574" fill-rule="evenodd" d="M14.667 0v2.747c3.853 1.146 6.666 4.72 6.666 8.946 0 4.227-2.813 7.787-6.666 8.934v2.76C20 22.173 24 17.4 24 11.693 24 5.987 20 1.213 14.667 0zM18 11.693c0-2.36-1.333-4.386-3.333-5.373v10.707c2-.947 3.333-2.987 3.333-5.334zm-18-4v8h5.333L12 22.36V1.027L5.333 7.693H0z" id="speaker"/>
							</svg>
						</div>
						<div class="volume-controls hidden">
							<div class="slider" data-direction="vertical">
								<div class="progress">
									<div class="pin" id="volume-pin" data-method="changeVolume"></div>
								</div>
							</div>
						</div>
					</div>

					<audio crossorigin>
						<source src="'.$RutaCompleta.'">
					</audio>
				</div>
				<script src="'.DB_SITE_REPO.'/LIBS_js/audio_player/js/index.js"></script>';
			break;
			/**************************************************/
			//Si son archivos de video
			case 'mp4'; case 'webm'; case 'ogv';
				$input .= '
				<link href="'.DB_SITE_REPO.'/LIBS_js/video_player/video-js.min.css" rel="stylesheet">
				<script src="'.DB_SITE_REPO.'/LIBS_js/video_player/ie8/videojs-ie8.min.js"></script>
				<script src="'.DB_SITE_REPO.'/LIBS_js/video_player/video.min.js"></script>
				<style>
					.video-js .vjs-big-play-button {
						visibility: hidden !important;
					}
				</style>
				<video id="video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264" poster="'.DB_SITE_REPO.'/LIBS_js/video_player/img/video-thumbnail.png" data-setup="{}">';
					switch ($Extension) {
						case 'mp4':
							$input .= '<source src="'.$RutaCompleta.'" type="video/mp4">';
							break;
						case 'webm':
							$input .= '<source src="'.$RutaCompleta.'" type="video/webm">';
							break;
						case 'ogv':
							$input .= '<source src="'.$RutaCompleta.'" type="video/ogg">';
							break;
					}
					$input .= '<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank" rel="noopener noreferrer">supports HTML5 video</a></p>
				</video>';
			break;
			/**************************************************/
			//Si son archivos de texto plano
			case 'txt'; case 'rtf';
				$archivo = file_get_contents($RutaCompleta); //Guardamos archivo.txt en $archivo
				$archivo = ucfirst($archivo);                //Le damos un poco de formato
				$archivo = nl2br($archivo);                  //Transforma todos los saltos de linea en tag <br/>
				$input = $archivo;
			break;
			/**************************************************/
			//Si son archivos comprimidos
			case 'gz'; case 'gzip'; case '7Z'; case 'zip'; case 'rar';
				$input = alert_post_data(4,1,1,0, 'No se pueden previsualizar los archivos comprimidos '.$Extension.', descarguelos presionando <a href="'.$RutaCompleta.'" class="">aqui</a>');
			break;
			/**************************************************/
			//Si son archivos no reproducibles por los reproductores
			case 'mp2'; case 'mpeg'; case 'mpg'; case 'mov'; case 'avi'; case 'oga'; case 'wav';
				$input = alert_post_data(4,1,1,0, 'No se pueden previsualizar los archivos multimedia '.$Extension.', descarguelos presionando <a href="'.$RutaCompleta.'" class="">aqui</a>');
			break;
			/**************************************************/
			//Si son mapas
			case 'kml'; case 'kmz';

				/**************************************/
				if($Extension=='kmz'){
					//Nombre del archivo
					$file_in = $File;

					//Ruta dentro del servidor
					$path = pathinfo(realpath($File), PATHINFO_DIRNAME);

					chmod($path.'/doc.kml', 0755);

					//Eliminar archivo antes de descomprimir
					try {
						/*if(!is_writable($path.'/doc.kml')){
							//throw new Exception('File not writable');
						}else{*/
							unlink($path.'/doc.kml');
						//}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}

					//Descomprimir
					$zip = new ZipArchive;
					$res = $zip->open($file_in);
					if ($res === TRUE) {
						// extract it to the path we determined above
						$zip->extractTo($path);
						$zip->close();
					} else {
						//nada
					}

					//indico el nombre del archivo a abrir
					$FileUbic = DB_SITE_MAIN.'/upload/doc.kml';

				/**************************************/
				}elseif($Extension=='kml'){
					//indico el nombre del archivo a abrir
					$FileUbic = $RutaCompleta;
				}

				$input = '
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-data.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>

				<link rel="stylesheet" type="text/css"  href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />

				<div style="width: 100%; height: 500px" id="mapContainer"></div>

				<script>
					function renderKML(map) {
						//URL
						var URL = "'.$FileUbic.'?dummy="+(new Date()).getTime();
						// Create a reader object passing in the URL of our KML file
						var reader = new H.data.kml.Reader(URL);
						reader.addEventListener("statechange", function(evt){
							if (evt.state === H.data.AbstractReader.State.READY) {
								// Get KML layer from the reader object and add it to the map
								map.addLayer(reader.getLayer());
								reader.getLayer().getProvider().addEventListener("tap", (ev) => {
									openBubble(ev.target.getGeometry(), ev.target.getData().name);
								});
							}
							if (evt.state === H.data.AbstractReader.State.ERROR) {

							}
						});

						// Parse the document
						reader.parse();
					}

					// Initialize the platform object
					var platform = new H.service.Platform({
					\'apikey\': \'kAgcV1Pjxt64ufyybbLaGHuCmIHwzxZXTNoitOiAC0I\'
					});

					// Obtain the default map types from the platform object
					var defaultLayers = platform.createDefaultLayers();

					// Instantiate (and display) the map
					var map = new H.Map(
					document.getElementById(\'mapContainer\'),
					defaultLayers.raster.satellite.map,{
						zoom: 14,
						pixelRatio: window.devicePixelRatio || 1
					});

					//Datos
					window.addEventListener(\'resize\', () => map.getViewPort().resize());
					var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
					var ui = H.ui.UI.createDefault(map, defaultLayers, \'es-ES\');

					renderKML(map);


					function geocode(platform) {
						var geocoder = platform.getSearchService(),
							geocodingParameters = {
								q: "'.$ExtraData.'"
							};

						geocoder.geocode(
							geocodingParameters,
							onSuccess,
							onError
						);
					}
					function onSuccess(result) {
						var locations = result.items;
						addLocationsToMap(locations);
					}
					function onError(error) {
						alert(\'Can t reach the remote server\');
					}

					var bubble;

					function openBubble(position, text){
						if(!bubble){
							bubble =  new H.ui.InfoBubble(
							position,
							{content: text});
							ui.addBubble(bubble);
						} else {
							bubble.setPosition(position);
							bubble.setContent(text);
							bubble.open();
						}
					}

					function addLocationsToMap(locations){
					var group = new  H.map.Group(),
						position,
						i;

					// Add a marker for each location found
					for (i = 0;  i < locations.length; i += 1) {
						let location = locations[i];
						marker = new H.map.Marker(location.position);
						marker.label = location.address.label;
						group.addObject(marker);
					}

					group.addEventListener(\'tap\', function (evt) {
						map.setCenter(evt.target.getGeometry());
						openBubble(evt.target.getGeometry(), evt.target.label);
					}, false);

					// Add the locations group to the map
					//map.addObject(group);
					map.setCenter(group.getBoundingBox().getCenter());

					}

					// Now use the map as required...
					geocode(platform);

				</script>';

			break;
			/**************************************************/
			//excepcion
			default;
				$input = alert_post_data(4,1,1,0, 'No esta soportada la previsualizacion para los archivos '.$Extension.', para descargar el archivo presione <a href="'.$RutaCompleta.'" class="">aqui</a>');
			break;
		}

	}else{
		if(isset($RutaCompleta)&&$RutaCompleta!=''){
			$input = alert_post_data(4,1,1,0, 'No esta soportada la previsualizacion, para descargar el archivo presione <a href="'.$RutaCompleta.'" class="">aqui</a>');
		}else{
			$input = alert_post_data(4,1,1,0, 'El Archivo a previsualizar no existe');
		}
	}

	/**********************/
	//devuelvo
	return $input;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Previsualizacion de archivos
*
*===========================     Detalles    ===========================
* Permite ver un preview de los documentos
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $Root         Ruta a la carpeta contenedora
* String   $File         Nombre del archivo
* String   $ExtraData    Informacion extra para los archivos kmz
* String   $file_path    Carpeta contenedora
* String   $extensions   Extension del archivo
* String   $mainSite     Direccion root de la pagina
* String   $EmpPath      Ruta hasta la carpeta contenedora
* @return  html
************************************************************************/
//Funcion
//permite ver un preview de los documentos
function preview_docs2($Root, $File, $ExtraData, $file_path, $extensions, $mainSite, $EmpPath){

	/**********************/
	//Validaciones
	if(!isset($Root) OR $Root==''){               return alert_post_data(4,1,1,0,'No ha ingresado la Ruta a la carpeta contenedora.');}
	if(!isset($File) OR $File==''){               return alert_post_data(4,1,1,0,'No ha ingresado el Nombre del archivo.');}
	//if(!isset($ExtraData) OR $ExtraData==''){     return alert_post_data(4,1,1,0,'No ha ingresado la Informacion extra para los archivos kmz.');}
	if(!isset($file_path) OR $file_path==''){     return alert_post_data(4,1,1,0,'No ha ingresado la Carpeta contenedora.');}
	//if(!isset($extensions) OR $extensions==''){   return alert_post_data(4,1,1,0,'No ha ingresado la Extension del archivo.');}
	//if(!isset($mainSite) OR $mainSite==''){       return alert_post_data(4,1,1,0,'No ha ingresado la Direccion root de la pagina.');}
	if(!isset($EmpPath) OR $EmpPath==''){         return alert_post_data(4,1,1,0,'No ha ingresado la Ruta hasta la carpeta contenedora.');}

	/**********************/
	//Si todo esta ok
	/****************************************/
	//se verifican las extensiones
	$exten  = 'JPG,jpg,jpeg,gif,png,bmp';           //Imagenes
	$exten .= ',doc,docx,xls,xlsx,ppt,pptx';        //archivos microsoft office
	$exten .= ',odt,odp,ods';                       //archivos libre office
	$exten .= ',pdf';                               //pdf
	$exten .= ',mp3,oga,wav';                       //Audio
	$exten .= ',mp4,webm,ogv,mp2,mpeg,mpg,mov,avi'; //Video
	$exten .= ',txt,rtf';                           //texto plano
	$exten .= ',gz,gzip,7Z,zip,rar';                //Archivos Comprimidos

	/****************************************/
	//Definicion de directorio y carpeta contenedora
	if($mainSite!=''){  $site     = $mainSite; }else{ $site     = DB_SITE_REPO; }    //directorio raiz
	if($EmpPath!=''){   $emp_path = $EmpPath;  }else{ $emp_path = DB_SITE_MAIN_PATH; } //carpeta contenedora

	/****************************************/
	//Se verifica si el archivo dado esta dentro de los permitidos
	$path       = $file_path.'/'.$File;
	$ext        = pathinfo($path, PATHINFO_EXTENSION);
	$num_files  = glob($path.".{".$exten."}", GLOB_BRACE);

	$input = '
	<style>
		img {width: 100%;height: auto;padding: 0;margin: 0;}
		iframe {width: 100%;height: 100%;padding: 0;margin: 0;}
		iframe{float:right;height: 600px;}
	</style>';

	//Si existen archivos
	if($num_files > 0){

		switch($ext){
			/**************************************************/
			//Si son imagenes
			case 'JPG'; case 'jpg'; case 'jpeg'; case 'gif'; case 'png'; case 'bmp';
				$input .= '<img src="'.$site.'/'.$emp_path.'/'.$path.'" />';
			break;
			/**************************************************/
			//Si son archivos microsoft office
			case 'doc'; case 'docx'; case 'xls'; case 'xlsx'; case 'ppt'; case 'pptx';
				$input .= '
				<iframe src="https://view.officeapps.live.com/op/embed.aspx?src='.$site.'/'.$emp_path.'/'.$path.'" frameborder="0">
					<a target="_blank" rel="noopener noreferrer" href="'.$site.'/'.$emp_path.'/'.$path.'">Descargar Documento</a>
				</iframe>';
			break;
			/**************************************************/
			//Si son archivos open office y pdf
			case 'odt'; case 'odp'; case 'ods'; case 'pdf';
				$input .= '<iframe src = "'.DB_SITE_REPO.'/LIBS_js/ViewerJS/#../../'.$emp_path.'/'.$path.'" allowfullscreen webkitallowfullscreen></iframe>';
			break;
			/**************************************************/
			//Si son archivos de audio
			case 'mp3';
				$input .= '
				<link rel="stylesheet" type="text/css" href="'.DB_SITE_REPO.'/LIBS_js/audio_player/css/style.css">
				<div class="audio green-audio-player">
					<div class="loading">
						<div class="spinner"></div>
					</div>
					<div class="play-pause-btn">
						<svg xmlns="https://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24">
							<path fill="#566574" fill-rule="evenodd" d="M18 12L0 24V0" class="play-pause-icon" id="playPause"/>
						</svg>
					</div>

					<div class="controls">
						<span class="current-time">0:00</span>
						<div class="slider" data-direction="horizontal">
							<div class="progress">
								<div class="pin" id="progress-pin" data-method="rewind"></div>
							</div>
						</div>
						<span class="total-time">0:00</span>
					</div>

					<div class="volume">
						<div class="volume-btn">
							<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
								<path fill="#566574" fill-rule="evenodd" d="M14.667 0v2.747c3.853 1.146 6.666 4.72 6.666 8.946 0 4.227-2.813 7.787-6.666 8.934v2.76C20 22.173 24 17.4 24 11.693 24 5.987 20 1.213 14.667 0zM18 11.693c0-2.36-1.333-4.386-3.333-5.373v10.707c2-.947 3.333-2.987 3.333-5.334zm-18-4v8h5.333L12 22.36V1.027L5.333 7.693H0z" id="speaker"/>
							</svg>
						</div>
						<div class="volume-controls hidden">
							<div class="slider" data-direction="vertical">
								<div class="progress">
									<div class="pin" id="volume-pin" data-method="changeVolume"></div>
								</div>
							</div>
						</div>
					</div>

					<audio crossorigin>
						<source src="'.$site.'/'.$emp_path.'/'.$path.'">
					</audio>
				</div>
				<script src="'.DB_SITE_REPO.'/LIBS_js/audio_player/js/index.js"></script>';
			break;
			/**************************************************/
			//Si son archivos de video
			case 'mp4'; case 'webm'; case 'ogv';
				$input .= '
				<link href="'.DB_SITE_REPO.'/LIBS_js/video_player/video-js.min.css" rel="stylesheet">
				<script src="'.DB_SITE_REPO.'/LIBS_js/video_player/ie8/videojs-ie8.min.js"></script>
				<script src="'.DB_SITE_REPO.'/LIBS_js/video_player/video.min.js"></script>
				<style>
				.video-js .vjs-big-play-button {
					visibility: hidden !important;
				}
				</style>

				<video id="video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264" poster="'.DB_SITE_REPO.'/LIBS_js/video_player/img/video-thumbnail.png" data-setup="{}">';
					switch ($ext) {
						case 'mp4':
							$input .= '<source src="'.$site.'/'.$emp_path.'/'.$path.'" type="video/mp4">';
							break;
						case 'webm':
							$input .= '<source src="'.$site.'/'.$emp_path.'/'.$path.'" type="video/webm">';
							break;
						case 'ogv':
							$input .= '<source src="'.$site.'/'.$emp_path.'/'.$path.'" type="video/ogg">';
							break;
					}
					$input .= '<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank" rel="noopener noreferrer">supports HTML5 video</a></p>
				</video>';
			break;
			/**************************************************/
			//Si son archivos de texto plano
			case 'txt'; case 'rtf';
				$input = alert_post_data(4,1,1,0, 'No se pueden previsualizar los archivos de texto '.$ext.', descarguelos presionando  <a href="'.$site.'/'.$emp_path.'/'.$path.'" class="">aqui</a>');
			break;
			/**************************************************/
			//Si son archivos comprimidos
			case 'gz'; case 'gzip'; case '7Z'; case 'zip'; case 'rar';
				$input = alert_post_data(4,1,1,0, 'No se pueden previsualizar los archivos comprimidos '.$ext.', descarguelos presionando <a href="'.$site.'/'.$emp_path.'/'.$path.'" class="">aqui</a>');
			break;
			/**************************************************/
			//Si son archivos no reproducibles por los reproductores
			case 'mp2'; case 'mpeg'; case 'mpg'; case 'mov'; case 'avi'; case 'oga'; case 'wav';
				$input = alert_post_data(4,1,1,0, 'No se pueden previsualizar los archivos multimedia '.$ext.', descarguelos presionando <a href="'.$site.'/'.$emp_path.'/'.$path.'" class="">aqui</a>');
			break;
			/**************************************************/
			//Si son mapas
			case 'kml'; case 'kmz';

				// assuming file.zip is in the same directory as the executing script.
				$file = $path;

				// get the absolute path to $file
				$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

				$zip = new ZipArchive;
				$res = $zip->open($file);
				if ($res === TRUE) {
					// extract it to the path we determined above
					$zip->extractTo($path);
					$zip->close();
					//echo "WOOT! $file extracted to $path";
				} else {
					//echo "Doh! I couldn't open $file";
				}

				$input = '
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-data.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
				<script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>

				<link rel="stylesheet" type="text/css"  href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />

				<div style="width: 100%; height: 500px" id="mapContainer"></div>

				<script>

				// Initialize the platform object
				var platform = new H.service.Platform({
				\'apikey\': \'kAgcV1Pjxt64ufyybbLaGHuCmIHwzxZXTNoitOiAC0I\'
				});

				// Obtain the default map types from the platform object
				var maptypes = platform.createDefaultLayers();

				// Instantiate (and display) the map
				var map = new H.Map(
				document.getElementById(\'mapContainer\'),
				maptypes.raster.satellite.map,
				{
				zoom: 1,
				pixelRatio: window.devicePixelRatio || 1
				});

				// Create reader object initializing it with a document:
				var reader = new H.data.kml.Reader(\'upload/doc.kml\');

				// Parse the document:
				reader.parse();

				// Get KML layer from the reader object and add it to the map:
				layer = reader.getLayer();
				map.addLayer(layer);


				reader.addEventListener(\'statechange\', function () {
					// Wait till the KML document is fully loaded and parsed
					if (this.getState() === H.data.AbstractReader.State.READY) {
						// So lets zoom to them by default
						//alert("listo");

						var parsedObjects = reader.getParsedObjects();
						console.log("object: " + parsedObjects[0]);

						var output = \'\';
						for (var property in parsedObjects[0]) {
						output += property + \': \' + parsedObjects[0][property]+\'; \';
						}
						console.log(output);

						str = JSON.stringify(parsedObjects, null, 4); // (Optional) beautiful indented output.
						console.log(str); // Logs output to dev tools console.

						map.setViewBounds(parsedObjects[0].getBounds());
						alert("zoom");
						map.setCenter(parsedObjects[0].getBounds().getCenter());
						alert("centrar");
						console.log(parsedObjects[0].getBounds().getCenter());
						alert("consola");

					}
				});


				// KML objects receive regular map events, so add an event listener to the
				// KML layer:
				layer.getProvider().addEventListener(\'tap\', function(ev) {
					// Log map object data. They contain name, description (if present in
					// KML) and the KML node itself.
					//console.log("target:" + ev.target.getData());
					alert(ev.target.getData()["name"]);
				});

				// add a resize listener to make sure that the map occupies the whole container
				window.addEventListener(\'resize\', () => map.getViewPort().resize());


				// Get the default map types from the Platform object:
				var defaultLayers = platform.createDefaultLayers();

				var ui = H.ui.UI.createDefault(map, defaultLayers, \'es-ES\');

				var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));


				//map.setCenter(LocationOfMarker);

			</script>';

			break;
			/**************************************************/
			//excepcion
			default;
				$input = alert_post_data(4,1,1,0, 'No esta soportada la previsualizacion para los archivos '.$ext.', para descargar el archivo presione <a href="'.$site.'/'.$emp_path.'/'.$path.'" class="">aqui</a>');
			break;
		}

	}else{
		if(isset($file_path, $file)&&$file_path!=''&&$file!=''){
			$input = alert_post_data(4,1,1,0, 'No esta soportada la previsualizacion, para descargar el archivo presione <a href="'.$site.'/'.$emp_path.'/'.$path.'" class="">aqui</a>');
		}else{
			$input = alert_post_data(4,1,1,0, 'El Archivo a previsualizar no existe');
		}
	}

	/**********************/
	//devuelvo
	return $input;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Imagenes animadas
*
*===========================     Detalles    ===========================
* Muestra las imagenes animadas
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $tipoImagen     Tipo de imagen a mostrar
* String   $site           Direccion raiz del sitio
* String   $path           Ruta de la ubicacion de la carpeta contenedora
* String   $content_folder Ruta de la ubicacion de la carpeta contenedora
* String   $direccion      Nombre del archivo
* @return  html
************************************************************************/
//Funcion
function widget_TipoImagen($tipoImagen, $site, $path, $content_folder, $direccion){

	/**********************/
	//Validaciones
	if(!isset($tipoImagen) OR $tipoImagen==''){          return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($site) OR $site==''){                      return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($path) OR $path==''){                      return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($content_folder) OR $content_folder==''){  return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($direccion) OR $direccion==''){            return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}

	/**********************/
	//Si todo esta ok
	//cadena
	$widget = '';
	//se identifica el tipo de imagen
	switch ($tipoImagen) {
		//Si no esta configurada
		case 0:
			$widget .= '<img src="'.$content_folder.'/'.$direccion.'" style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia"  >';
			break;
		//Normal
		case 1:
			$widget .= '<img src="'.$content_folder.'/'.$direccion.'" style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia"  >';
			break;
		//Tambor
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
		case 10:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/prefixfree/prefixfree.min.js"></script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/drum.js"></script>';
			$widget .= '<script>
					var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";
					document.getElementById("cover_prod").appendChild(createBarrel(textura));
				</script>';
			$widget .= '<style>#cover_prod {position: relative;perspective: 600px;perspective: 600px;text-align:center;width:100%;height:300px;}#cover_prod .threedee {position: absolute;left: 50%;top: 50%;transform-style: preserve-3d;transform-origin: 50% 50% 50%;backface-visibility: hidden;}#cover_prod .assembly {animation: spincover 30s linear infinite;}@keyframes spincover {to {transform: rotateY(360deg);}}</style>';
			break;
		//Cubo Carton 1x1x1
		case 11:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 10;</script>';
			$widget .= '<script>var med_largo = 10;</script>';
			$widget .= '<script>var med_ancho = 10;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:300px;}</style>';
			break;
		//Cubo Carton 2x1x1
		case 12:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 30;</script>';
			$widget .= '<script>var med_largo = 5;</script>';
			$widget .= '<script>var med_ancho = 5;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:600px;}</style>';
			break;
		//Cubo Carton 1x2x1
		case 13:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 5;</script>';
			$widget .= '<script>var med_largo = 10;</script>';
			$widget .= '<script>var med_ancho = 5;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:300px;}</style>';
			break;
		//Cubo Carton 2x2x1
		case 14:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 10;</script>';
			$widget .= '<script>var med_largo = 10;</script>';
			$widget .= '<script>var med_ancho = 5;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:600px;}</style>';
			break;
		//Cubo Madera 1x1x1
		case 15:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 10;</script>';
			$widget .= '<script>var med_largo = 10;</script>';
			$widget .= '<script>var med_ancho = 10;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:300px;}</style>';
			break;
		//Cubo Madera 2x1x1
		case 16:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 30;</script>';
			$widget .= '<script>var med_largo = 5;</script>';
			$widget .= '<script>var med_ancho = 5;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:600px;}</style>';
			break;
		//Cubo Madera 1x2x1
		case 17:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 5;</script>';
			$widget .= '<script>var med_largo = 10;</script>';
			$widget .= '<script>var med_ancho = 5;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:300px;}</style>';
			break;
		//Cubo Madera 2x2x1
		case 18:
			$widget .= '<div class="fcenter" id="cover_prod"></div>';
			$widget .= '<script src="'.$site.'/LIBS_js/three_js/three.min.js"></script>';
			$widget .= '<script>var textura = "'.$site.$path.'/'.$content_folder.'/'.$direccion.'";</script>';
			$widget .= '<script>var med_alto  = 10;</script>';
			$widget .= '<script>var med_largo = 10;</script>';
			$widget .= '<script>var med_ancho = 5;</script>';
			$widget .= '<script src="'.$site.'/LIBS_js/3d_cover/cube_normal.js"></script>';
			$widget .= '<style>#cover_prod canvas{margin-top: 10px;background-color: #eeeeee;}#cover_prod{height:600px;}</style>';
			break;
	}

	/**********************/
	//devuelvo
	return $widget;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Ventana Popup emergente
*
*===========================     Detalles    ===========================
* Permite mostrar una ventana emergente
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	widget_avgrund();
*
*===========================    Parametros   ===========================
* @return  html
************************************************************************/
//Funcion
//Muestra el cuadro de dialogo
function widget_avgrund(){
	require_once '../LIBS_js/avgrund/avgrund.php';
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Explorador de archivos
*
*===========================     Detalles    ===========================
* Muestra un explorador de archivos personalizado
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $type       Tipo de herramientas a mostrar
* String   $conector   Configuracion interna de la libreria
* String   $emp_path   Ruta a la carpeta contenedora
* String   $id_emp     ID de la empresa
* String   $prm        Nivel de permisos de acceso a los archivos
* @return  html
************************************************************************/
//Funcion
function file_explorer($type, $conector, $emp_path, $id_emp, $prm){

	/**********************/
	//Validaciones
	if(!isset($type) OR $type==''){         return alert_post_data(4,1,1,0,'No ha ingresado el Tipo de herramientas a mostrar.');}
	if(!isset($conector) OR $conector==''){ return alert_post_data(4,1,1,0,'No ha ingresado la Configuracion interna de la libreria.');}
	if(!isset($emp_path) OR $emp_path==''){ return alert_post_data(4,1,1,0,'No ha ingresado la Ruta a la carpeta contenedora.');}
	if(!isset($id_emp) OR $id_emp==''){     return alert_post_data(4,1,1,0,'No ha ingresado el ID de la empresa.');}
	if(!isset($prm) OR $prm==''){           return alert_post_data(4,1,1,0,'No ha ingresado el Nivel de permisos de acceso a los archivos.');}

	/**********************/
	//Si todo esta ok
	//generacion del input
	$input = '
	<style>
		.iframe_elfinder{height: 700px;}
		iframe{float:right;width: 100%;height: 100%;padding: 0;margin: 0;border:none;}
	</style>

	<div class="iframe_elfinder">
		<iframe class="embed-responsive-item" src="'.DB_SITE_REPO.'/LIBS_js/elFinder/index.php?type='.$type.'&conector='.$conector.'&emp_path='.$emp_path.'&id_emp='.$id_emp.'&prm='.$prm.'" allowfullscreen></iframe>
	</div>';

	/**********************/
	//devuelvo
	return $input;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Mostrar la ventana modal
*
*===========================     Detalles    ===========================
* Muestra la ventana modal
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $width     El ancho de la ventana
* String   $height    El alto de la ventana
* @return  html
************************************************************************/
//Funcion
//
function widget_modal($width, $height){

	/**********************/
	//Variables
	$Count = 0;
	//Validaciones
	if(!isset($width) OR $width==''){   $Count++;  echo alert_post_data(4,1,1,0,'No ha ingresado el ancho de la ventana.');}
	if(!isset($height) OR $height==''){ $Count++;  echo alert_post_data(4,1,1,0,'No ha ingresado el alto de la ventana.');}

	/**********************/
	//Si todo esta ok
	if($Count==0){
		$input = "
		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(\".iframe\").colorbox({iframe:true, width:\"".$width."%\", height:\"".$height."%\"});
				$(\".callbacks\").colorbox({
					onOpen:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onOpen: colorbox is about to open.'});},
					onLoad:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onLoad: colorbox has started to load the targeted content.'});},
					onComplete:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onComplete: colorbox has displayed the loaded content.'});},
					onCleanup:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onCleanup: colorbox has begun the close process.'});},
					onClosed:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onClosed: colorbox has completely closed.'});}
				});

				//Example of preserving a JavaScript event for inline calls.
				$(\"#click\").click(function(){
					$('#click').css({\"background-color\":\"#f00\", \"color\":\"#fff\", \"cursor\":\"inherit\"}).text(\"Open this window again and this message will still be here.\");
					return false;
				});
			});
		</script>";

		/**********************/
		//devuelvo
		echo $input;
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Muestra la Burbuja de ayuda
*
*===========================     Detalles    ===========================
* Muestra la Burbuja de ayuda
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	widget_tooltipster();
*
*===========================    Parametros   ===========================
* @return  html
************************************************************************/
//Funcion
function widget_tooltipster(){
	require_once '../LIBS_js/tooltipster/tooltipster.php';
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Ejecuta el validador de formularios
*
*===========================     Detalles    ===========================
* Ejecuta el validador de formularios
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	widget_validator();
*
*===========================    Parametros   ===========================
* @return  html
************************************************************************/
//Funcion
//Ejecuta el validador de formularios
function widget_validator(){
	require_once '../LIBS_js/validator/form_validator.php';
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* se muestra información como planilla excel
*
*===========================     Detalles    ===========================
* se muestra información como planilla excel
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $identificador     Identificador
* String   $tabla             Los valores a desplegar
* String   $extraconfig       Opciones extras
* @return  html
************************************************************************/
//Funcion
function widget_excel($identificador, $tabla, $extraconfig){

	/**********************/
	//Validaciones
	if(!isset($identificador) OR $identificador==''){  return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($tabla) OR $tabla==''){                  return alert_post_data(4,1,1,0,'No ha ingresado los valores a desplegar.');}

	/**********************/
	//Si todo esta ok

	//generacion del widget
	$widget = '
	<link href="'.DB_SITE_REPO.'/LIBS_js/webdatarocks/webdatarocks.min.css" rel="stylesheet" />
	<script src="'.DB_SITE_REPO.'/LIBS_js/webdatarocks/webdatarocks.toolbar.min.js"></script>
	<script src="'.DB_SITE_REPO.'/LIBS_js/webdatarocks/webdatarocks.js"></script>

	<div id="'.$identificador.'"></div>

	<script>
		var tipsData = ['.$tabla.'];
		var pivot = new WebDataRocks({
			container: "#'.$identificador.'",
			toolbar: true,
			report: {
				dataSource: {
					data: tipsData
				},
				'.$extraconfig.'
			},
			global: {
				// replace this path with the path to your own translated file
				localization: "https://cdn.webdatarocks.com/loc/es.json"
			}
		});
	</script>';

	/**********************/
	//devuelvo
	return $widget;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* se muestra el buscador dentro de una tabla
*
*===========================     Detalles    ===========================
* se muestra el buscador dentro de una tabla
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $type      Tipo de elemento html
* String   $colspan   Columnas a abarcar
* String   $idTable   Identificador de la tabla
* @return  html
************************************************************************/
//Funcion
//
function widget_sherlock($type, $colspan, $idTable){

	/**********************/
	//Validaciones
	if(!isset($type) OR $type==''){         return alert_post_data(4,1,1,0,'No ha ingresado el Tipo de elemento html.');}
	if(!isset($colspan) OR $colspan==''){   return alert_post_data(4,1,1,0,'No ha ingresado las Columnas a abarcar.');}
	if(!isset($idTable) OR $idTable==''){   return alert_post_data(4,1,1,0,'No ha ingresado el Identificador de la tabla.');}

	/**********************/
	//Si todo esta ok
	//indica que tipo es
	switch ($type) {
		case 1: $html_obj = 'th'; break;
		case 2: $html_obj = 'td'; break;
	}

	//variables internas
	$InputName  = 'InputTableFilter_'. rand(1, 999);

	//generacion del widget
	$widget = '
	<tr role="row">
		<'.$html_obj.' colspan="'.$colspan.'"><input class="form-control" id="'.$InputName.'" type="text" placeholder="Filtrar Datos.."></'.$html_obj.'>
	</tr>
	<script>
		$(document).ready(function(){
			$("#'.$InputName.'").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#'.$idTable.' tr").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
	</script>';

	/**********************/
	//devuelvo
	return $widget;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* se muestra el buscador dentro de una tabla
*
*===========================     Detalles    ===========================
* se muestra el buscador dentro de una tabla
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $id_table     Identificador de la tabla
* @return  html
************************************************************************/
//Funcion
function widget_table_filter($id_table){

	/**********************/
	//Validaciones
	if(!isset($id_table) OR $id_table==''){  return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}

	/**********************/
	//Si todo esta ok
	//generacion del widget
	$widget = '
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="'.DB_SITE_REPO.'/LIBS_js/Dropdown_Table_Filter/ddtf.js"></script>
	<script>jQuery(\'#'.$id_table.'\').ddTableFilter();</script>
	';

	/**********************/
	//devuelvo
	return $widget;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* se muestra el visualizador de codigo fuente
*
*===========================     Detalles    ===========================
* se muestra el visualizador de codigo fuente
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $type     Tipo de elemento
* String   $code     Codigo a mostrar
* @return  html
************************************************************************/
//Funcion
function widget_code_block($type, $code){

	/**********************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$tipos = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13);
	//Validaciones
	if(!isset($type) OR $type==''){  return alert_post_data(4,1,1,0,'No ha ingresado el Tipo de elemento.');}
	if(!isset($code) OR $code==''){  return alert_post_data(4,1,1,0,'No ha ingresado el Codigo a mostrar.');}
	if (!in_array($type, $tipos)) {  return alert_post_data(4,1,1,0,'La configuracion $type entregada en el codeblock no esta dentro de las opciones');}

	/**********************/
	//Si todo esta ok
	switch ($type) {
		case 1:  $tittle = 'Codigo HTML';       $class  = 'language-markup';     break;//HTML Code Example
		case 2:  $tittle = 'Codigo CSS';        $class  = 'language-css';        break;//CSS Code Example
		case 3:  $tittle = 'Codigo JavaScript'; $class  = 'language-javascript'; break;//JavaScript Code Example
		case 4:  $tittle = 'Codigo Python';     $class  = 'language-python';     break;//Python Code Example
		case 5:  $tittle = 'Codigo PHP';        $class  = 'language-php';        break;//PHP Code Example
		case 6:  $tittle = 'Codigo Handlebars'; $class  = 'language-handlebars'; break;//Handlebars Code Example
		case 7:  $tittle = 'Codigo Git';        $class  = 'language-git';        break;//Git Code Example
		case 8:  $tittle = 'Codigo Java';       $class  = 'language-java';       break;//JAVA Code Example
		case 9:  $tittle = 'Codigo C Like';     $class  = 'language-clike';      break;//C Like Code Example
		case 10: $tittle = 'Codigo C';          $class  = 'language-c';          break;//C Code Example
		case 11: $tittle = 'Codigo CSharp';     $class  = 'language-csharp';     break;//CSharp Code Example
		case 12: $tittle = 'Codigo SQL';        $class  = 'language-sql';        break;//SQL Code Example
		case 13: $tittle = 'Codigo PLSQL';      $class  = 'language-plsql';      break;//PLSQL Code Example
	}
	//Limpieza
	$code = str_replace('<','&lt;',$code);
	$code = str_replace('>','&gt;',$code);
	$code = str_replace('"','&quot;',$code);
	$widget = '
	<div class="code-block">
		<h6>'.$tittle.'</h6>
		<pre style="padding-top: 0px;"><code class="'.$class.'">'.$code.'</code></pre>
	</div>';

	/**********************/
	//devuelvo
	return $widget;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Muestra un explorador de archivos personalizado
*
*===========================     Detalles    ===========================
* Muestra un explorador de archivos personalizado
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $URL          URL con el Feed de noticias
* int      $MaxCount     Maximo de noticias a mostrar
* int      $height       Altura del widget
* bolean   $ShowDesc     Mostrar descripcion
* bolean   $ShowPubDate  Mostrar fecha de publicacion
* @return  html
************************************************************************/
//Funcion
function widget_feed($URL, $MaxCount, $height, $ShowDesc, $ShowPubDate){

	/**********************/
	//Validaciones
	if(!isset($URL) OR $URL==''){                  return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($MaxCount) OR $MaxCount==''){        return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($height) OR $height==''){            return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($ShowDesc) OR $ShowDesc==''){        return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($ShowPubDate) OR $ShowPubDate==''){  return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!validarNumero($MaxCount)){                 return alert_post_data(4,1,1,0,'El dato $MaxCount ingresado no es un numero');}
	if(!validarNumero($height)){                   return alert_post_data(4,1,1,0,'El dato $height ingresado no es un numero');}

	/**********************/
	//Si todo esta ok
	$input = '
	<link href="'.DB_SITE_REPO.'/LIBS_js/atom_feed/css/FeedEk.css" rel="stylesheet" type="text/css" />
	<div id="divRss" style="height:'.$height.'px;overflow:auto;"></div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="'.DB_SITE_REPO.'/LIBS_js/atom_feed/js/FeedEk.js?v2"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$(\'#divRss\').FeedEk({';
				$input .= 'FeedUrl: \''.$URL.'\'';                                        //URL de los datos
				$input .= ',MaxCount: '.$MaxCount;                                        //cantidad de post a mostrar
				$input .= ',ShowDesc: '.$ShowDesc;                                        //Mostrar descripcion (true-false)
				$input .= ',ShowPubDate: '.$ShowPubDate;                                  //Mostrar fecha de publicacion (true-false)
				$input .= ',imgDirection: "'.DB_SITE_REPO.'/LIB_assets/img/loader.gif"';  //Dirección del loader
				$input.= '
			});
		});
	</script>';

	/**********************/
	//devuelvo
	return $input;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Muestra los ultimos temblores
*
*===========================     Detalles    ===========================
* Muestra los ultimos temblores
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	widget_sismologia();
*
*===========================    Parametros   ===========================
* @return  html
************************************************************************/
//Funcion
function widget_sismologia(){

	/**********************/
	//Si todo esta ok
	//Se da permiso para el acceso remoto
	ini_set("allow_url_fopen", 1);
	//se verifica si el permiso fue concedido
	if( ini_get('allow_url_fopen')){

		try {
			//Obtengo los datos
			$sismologia = file_get_contents('http://www.sismologia.cl/ultimos_sismos.html');

			//modifico el html obtenido
			$sismologia = str_replace('<!DOCTYPE html>','', $sismologia);
			$sismologia = str_replace('<html>','', $sismologia);
			$sismologia = str_replace('</html>','', $sismologia);
			$sismologia = str_replace('<head>','', $sismologia);
			$sismologia = str_replace('</head>','', $sismologia);
			$sismologia = str_replace('<body>','', $sismologia);
			$sismologia = str_replace('</body>','', $sismologia);
			$sismologia = str_replace('<meta charset="utf-8">','', $sismologia);
			$sismologia = str_replace('<link rel="stylesheet" type="text/css" href="/css/style.css">','', $sismologia);
			$sismologia = str_replace('<title>Centro Sismológico Nacional, Universidad de Chile</title>','', $sismologia);
			$sismologia = str_replace('<div id="header-container">','', $sismologia);
			$sismologia = str_replace('</div><!--id="header-container"-->','', $sismologia);
			$sismologia = str_replace('<div class="header wrapper clearfix">','', $sismologia);
			$sismologia = str_replace('</div><!--class="header wrapper clearfix"-->','', $sismologia);
			$sismologia = str_replace('<div id="title">','', $sismologia);
			$sismologia = str_replace('</div><!--id="title"-->','', $sismologia);
			$sismologia = str_replace('<div class="nav">','', $sismologia);
			$sismologia = str_replace('</div><!--class="nav"-->','', $sismologia);
			$sismologia = str_replace('<a href="/index.html"><img class="logo-a" src="/img/ssuch.png" alt="logo csn"></a>','', $sismologia);
			$sismologia = str_replace('<ul>','', $sismologia);
			$sismologia = str_replace('</ul>','', $sismologia);
			$sismologia = str_replace('<li><a href="/ultimos_sismos.html" style="background:#4E7172 url(/img/boton_menu1.png);">Sismicidad</a></li>','', $sismologia);
			$sismologia = str_replace('<li><a href="/aprende.html" style="background:#4288B7 url(/img/boton_menu2.png);">Educación</a></li>','', $sismologia);
			$sismologia = str_replace('<li><a href="http://www.csn.uchile.cl" style="background:#4FA85A url(/img/boton_menu3.png);">Novedades</a></li>','', $sismologia);
			$sismologia = str_replace('<div class="submenu" style="background:#587f80 url(/img/boton_menu1.png) top;">','', $sismologia);
			$sismologia = str_replace('<ul class="informate wrapper">','', $sismologia);
			$sismologia = str_replace('<li><a href="/index.html" class="boton-inicio" style="background:#272727; float:left; margin:0;"><img src="/img/home.png" alt="home-icon"></a></li>','', $sismologia);
			$sismologia = str_replace('<li><a href="/ultimos_sismos.html">Últimos Sismos</a></li>','', $sismologia);
			$sismologia = str_replace('<li><a id="menu-catalogo" href="/catalogo.html">Sismos por día</a></li>','', $sismologia);
			$sismologia = str_replace('<!--li><a href="/perfiles/index.html">Perfiles  Sísmicos</a></li-->','', $sismologia);
			$sismologia = str_replace('<li><a href="http://www.csn.uchile.cl/sismologia/grandes-terremotos-en-chile/">Terremotos</a></li>','', $sismologia);
			$sismologia = str_replace('<li><a href="http://www.csn.uchile.cl/archivo/informes-tecnicos/">Informes</a></li>','', $sismologia);
			$sismologia = str_replace('<!--li><a href="/sismicidad.html" >Actividad Sísmica</a></li-->','', $sismologia);
			$sismologia = str_replace('<div id="main-container">','', $sismologia);
			$sismologia = str_replace('<div id="main" class="wrapper clearfix">','', $sismologia);
			$sismologia = str_replace('<h1>Últimos sismos</h1>','', $sismologia);
			$sismologia = str_replace('<!--<h2>con magnitud igual o superior a 3.0 (1)</h2>-->','', $sismologia);
			$sismologia = str_replace('<!--<aside class="col-med" style="width:100%; margin:10px 0 10px 0; float:left;">-->','', $sismologia);
			$sismologia = str_replace('<!--</aside>-->','', $sismologia);
			$sismologia = str_replace('<p style="float:left;" class="cushycms"><strong>GUC</strong>','', $sismologia);
			$sismologia = str_replace('(Geofísica Universidad de Chile): Sigla con la cual es conocido','', $sismologia);
			$sismologia = str_replace('el Centro Sismológico Nacional de la Universidad de Chile en la Red','', $sismologia);
			$sismologia = str_replace('Sismológica Mundial.<br />','', $sismologia);
			$sismologia = str_replace('<strong>(1)</strong> En caso de Sismos','', $sismologia);
			$sismologia = str_replace('Sensibles serán publicados cualquiera sea su magnitud.<br />','', $sismologia);
			$sismologia = str_replace('<strong>(2)</strong> Sólo los sismos sensibles (reportados),','', $sismologia);
			$sismologia = str_replace('tienen informe de intensidades.<br />','', $sismologia);
			$sismologia = str_replace('<strong>(3)</strong> Sólo los sismos sensibles se muestran en negrita.','', $sismologia);
			$sismologia = str_replace('</div><!--id="main" class="wrapper clearfix">-->','', $sismologia);
			$sismologia = str_replace('</div><!--id="main-container"-->','', $sismologia);
			$sismologia = str_replace('<div id="footer-container">','', $sismologia);
			$sismologia = str_replace('<div class="footer">','', $sismologia);
			$sismologia = str_replace('<p class="datos">','', $sismologia);
			$sismologia = str_replace('<strong>Centro Sismológico Nacional, Universidad de Chile. </strong>','', $sismologia);
			$sismologia = str_replace('Blanco Encalada 2002 - Casilla #2777 Santiago, Chile. Email: ','', $sismologia);
			$sismologia = str_replace('<a href="mailto:contacto@csn.uchile.cl">contacto@csn.uchile.cl</a>','', $sismologia);
			$sismologia = str_replace('</p><!--class="datos"-->','', $sismologia);
			$sismologia = str_replace('<p class="rs">Síguenos en:','', $sismologia);
			$sismologia = str_replace('<a href="http://www.twitter.com/sismos_csn" target="_blank" rel="noopener noreferrer"><span class="tt" id="none"></span></a>','', $sismologia);
			$sismologia = str_replace('<a href="https://www.facebook.com/pages/Centro-Sismol%C3%B3gico-Nacional-Universidad-de-Chile/195079254010666"><span class="fb" id="none"></span></a>','', $sismologia);
			$sismologia = str_replace('</div><!--class="footer"-->','', $sismologia);
			$sismologia = str_replace('</div><!--id="footer-container"-->','', $sismologia);
			$sismologia = str_replace('<script type="text/javascript" src="/js/catalog.js"></script>','', $sismologia);
			$sismologia = str_replace('</ul>','', $sismologia);
			$sismologia = str_replace('</div>','', $sismologia);
			$sismologia = str_replace('<br />','', $sismologia);
			$sismologia = str_replace('</p>','', $sismologia);
			$sismologia = str_replace('<a href="/', '<a target="_blank" rel="noopener noreferrer" href="http://www.sismologia.cl/', $sismologia);

			//genero cuerpo
			$s_body = '
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-map-o" aria-hidden="true"></i></div><h5>Últimos Sismos</h5>
				</header>
				<div class="external_page">
					'.$sismologia.'
				</div>
			</div>';

			/**********************/
			//devuelvo
			return $s_body;

		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			return alert_post_data(4,1,1,0, 'No se obtuvieron datos');
		}

	//si no fue concedido
	} else {
		return alert_post_data(4,1,1,0, 'La funcion allow_url_fopen no esta activa');
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Muestra los dias feriados del año
*
*===========================     Detalles    ===========================
* Muestra los dias feriados del año
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	widget_feriados();
*
*===========================    Parametros   ===========================
* @return  html
************************************************************************/
//Funcion
function widget_feriados(){

	/**********************/
	//Si todo esta ok
	//Se da permiso para el acceso remoto
	ini_set("allow_url_fopen", 1);
	//se verifica si el permiso fue concedido
	if( ini_get('allow_url_fopen')){

		try {
			//Obtengo los datos
			$feriado = file_get_contents('https://www.feriados.cl/');

			//modifico el html obtenido
			$feriado = str_replace('<!DOCTYPE html>','', $feriado);
			$feriado = str_replace('<html lang="es">','', $feriado);
			$feriado = str_replace('</html>','', $feriado);
			$feriado = str_replace('<head>','', $feriado);
			$feriado = str_replace('</head>','', $feriado);
			$feriado = str_replace('<!-- Global site tag (gtag.js) - Google Analytics -->','', $feriado);
			$feriado = str_replace('<script async src="https://www.googletagmanager.com/gtag/js?id=UA-11741389-1"></script>','', $feriado);
			$feriado = str_replace('<script>','', $feriado);
			$feriado = str_replace('</script>','', $feriado);
			$feriado = str_replace('window.dataLayer = window.dataLayer || [];','', $feriado);
			$feriado = str_replace('function gtag(){dataLayer.push(arguments);}','', $feriado);
			$feriado = str_replace("gtag('js', new Date());",'', $feriado);
			$feriado = str_replace("gtag('config', 'UA-11741389-1');",'', $feriado);
			$feriado = str_replace('<meta charset = "UTF-8" >','', $feriado);
			$feriado = str_replace('<meta name="description"','', $feriado);
			$feriado = str_replace('content="Sitio con la información de los días feriados de Chile y las leyes que los rigen.">','', $feriado);
			$feriado = str_replace('<link rel="shortcut icon" href="favicon.ico">','', $feriado);
			$feriado = str_replace('<link rel="stylesheet" type="text/css" href="style18-4.css">','', $feriado);
			$feriado = str_replace('<meta name="keywords"','', $feriado);
			$feriado = str_replace('content="Feriados de Chile, Feriados, 2022, Año Nuevo, Viernes Santo, Sábado Santo, Día Nacional de Trabajo, San Pedro y San Pablo, Día de la Virgen del Carmen, Asunsión de la Virgen, Independencia Nacional, Día de la Glorias del Ejército, Encuentro de Dos Mundos, Día de las Iglesias Evangélicas y Protestantes, Día de Todos los Santos, Inmaculada Concepción, Navidad, Elecciones Municipales, Plebiscito, Asamblea Constituyente, Constitución">','', $feriado);
			$feriado = str_replace('<title>Feriados de Chile - Año 2022</title>','', $feriado);
			$feriado = str_replace('<link rel="canonical" href="https://www.feriados.cl/index.php">','', $feriado);
			$feriado = str_replace('<meta name="viewport" content="width=device-width, initial-scale=1">','', $feriado);
			$feriado = str_replace('<!-- Anuncio Automatico -->','', $feriado);
			$feriado = str_replace('<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>','', $feriado);
			$feriado = str_replace('(adsbygoogle = window.adsbygoogle || []).push({','', $feriado);
			$feriado = str_replace('google_ad_client: "pub-1764294017474123",','', $feriado);
			$feriado = str_replace('enable_page_level_ads: true','', $feriado);
			$feriado = str_replace('});','', $feriado);
			$feriado = str_replace('<body style="background-color: #ffffff; margin-top: 1%; margin-left: 2%; margin-right: 2%; margin-bottom: 1%;">','', $feriado);
			$feriado = str_replace('</body>','', $feriado);
			$feriado = str_replace('<header>','', $feriado);
			$feriado = str_replace('</header>','', $feriado);
			$feriado = str_replace('<div class="logo"><a href="#sobre">','', $feriado);
			$feriado = str_replace('<img src="logoferiados.png" alt="Logo" style="width:75%; margin-left: auto; margin-right: auto; display: block;"></a></div>','', $feriado);
			$feriado = str_replace('<div class="titulo"><h1 style="text-align:center;  color: #ffffff;">Feriados de Chile Año 2022','', $feriado);
			$feriado = str_replace('<a href="#menutarget" style="text-decoration: none;"><span class="menulink"></span></a></h1></div>','', $feriado);
			$feriado = str_replace('<main>','', $feriado);
			$feriado = str_replace('</main>','', $feriado);
			$feriado = str_replace('<aside>','', $feriado);
			$feriado = str_replace('</aside>','', $feriado);
			$feriado = str_replace('<nav id="menu">','', $feriado);
			$feriado = str_replace('</nav>','', $feriado);
			$feriado = str_replace('<span  class="menuitemcur">Feriados Año 2022</span>','', $feriado);
			$feriado = str_replace('<a class="navwhite" href="2023.htm">Feriados Año 2023</a>','', $feriado);
			$feriado = str_replace('<a class="navwhite" href="leyes.htm">Leyes</a>','', $feriado);
			$feriado = str_replace('<a class="navwhite" href="faq.htm">Preguntas Frecuentes</a>','', $feriado);
			$feriado = str_replace('<table class="menutable" id="menutarget">','<table>', $feriado);
			$feriado = str_replace('<div class="share">','', $feriado);
			$feriado = str_replace('<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://feriados.cl/" data-via="feriados"','', $feriado);
			$feriado = str_replace('data-size="large" data-count="none" data-hashtags="Feriados" style="vertical-align: text-bottom;" >Tweet</a>','', $feriado);
			$feriado = str_replace('<a href="whatsapp://send?text=Hola! Te recomiendo Feriados de Chile https://feriados.cl/"','', $feriado);
			$feriado = str_replace('data-action="share/whatsapp/share"><img src="ws.png" alt="WhatsApp" height="28"></a>','', $feriado);
			$feriado = str_replace('<div>','', $feriado);
			$feriado = str_replace('</div>','', $feriado);
			$feriado = str_replace('<!-- BloqueResponsivo -->','', $feriado);
			$feriado = str_replace('<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>','', $feriado);
			$feriado = str_replace('<ins class="adsbygoogle"','', $feriado);
			$feriado = str_replace('style="display:block"','', $feriado);
			$feriado = str_replace('data-ad-client="ca-pub-1764294017474123"','', $feriado);
			$feriado = str_replace('data-ad-slot="5711300468"','', $feriado);
			$feriado = str_replace('data-ad-format="auto"></ins>','', $feriado);
			$feriado = str_replace('<script>','', $feriado);
			$feriado = str_replace('</script>','', $feriado);
			$feriado = str_replace('(adsbygoogle = window.adsbygoogle || []).push({});','', $feriado);
			$feriado = str_replace('<div style="display:block; margin:auto; ">','', $feriado);
			$feriado = str_replace('<p><span style=" color: #004080; font-weight: bold;">Actualizaciones Twitter</span></p>','', $feriado);
			$feriado = str_replace('<a class="twitter-timeline"  data-tweet-limit="5" data-chrome="noheader;nofooter" data-width="100%"  data-height="auto"','', $feriado);
			$feriado = str_replace('href="https://twitter.com/feriados">Twitter @Feriados</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>','', $feriado);
			$feriado = str_replace('<p><span style="color: #004080; font-weight: bold;">Licencia</span></p>','', $feriado);
			$feriado = str_replace('<p style="font-size:smaller;"><a class="navblack" rel="license" href="https://creativecommons.org/licenses/by-nc-sa/4.0/">','', $feriado);
			$feriado = str_replace('<img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a>','', $feriado);
			$feriado = str_replace('<br />Esta obra está bajo una <a class="navblack" style="font-weight:normal;"','', $feriado);
			$feriado = str_replace('rel="license" href="https://creativecommons.org/licenses/by-nc-sa/4.0/">','', $feriado);
			$feriado = str_replace('Licencia Creative Commons Atribución-NoComercial-CompartirIgual 4.0 Internacional</a>.</p>','', $feriado);
			$feriado = str_replace('<p><span style=" color: #004080; font-weight: bold;">Sobre el sitio</span></p>','', $feriado);
			$feriado = str_replace('<p style="padding: 0px 6px 0px 6px;">En Feriados de Chile creemos que la familia y comunidad son la base de la sociedad,','', $feriado);
			$feriado = str_replace('y que cada momento que pasan juntas, contribuye a una sociedad más fuerte. Nosotros te contamos cuándo es feriado, para que','', $feriado);
			$feriado = str_replace('disfrutes junto a los tuyos. Fuente de información:','', $feriado);
			$feriado = str_replace('<a class="navblack" style="font-weight: normal;" href="https://www.bcn.cl/" target="_blank" rel="noopener noreferrer">Biblioteca Congreso Nacional</a>.</p>','', $feriado);
			$feriado = str_replace('<p><span style=" color: #004080; font-weight: bold;">Otros sitios </span></p>','', $feriado);
			$feriado = str_replace('<p>','', $feriado);
			$feriado = str_replace('</p>','', $feriado);
			$feriado = str_replace('<a href="https://www.preparados.cl/"','', $feriado);
			$feriado = str_replace('target=_blank><img class="logott" alt="Estar Preparados" src="preparadostt.png" ></a>','', $feriado);
			$feriado = str_replace('<a href="https://www.datoutil.cl/"','', $feriado);
			$feriado = str_replace('target=_blank><img class="logott" alt="Dato Util" src="datoutiltt.png" ></a>','', $feriado);
			$feriado = str_replace('<a href="https://www.efemerides.cl/"','', $feriado);
			$feriado = str_replace('target=_blank><img class="logott" alt="Efemérides Chile" src="efemeridestt.png" ></a>','', $feriado);
			$feriado = str_replace('<div class="ads"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">','', $feriado);
			$feriado = str_replace('<script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">','', $feriado);
			$feriado = str_replace('<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">','', $feriado);
			$feriado = str_replace('href="https://twitter.com/feriados">Twitter @Feriados</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8">','', $feriado);
			$feriado = str_replace('<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">','', $feriado);
			$feriado = str_replace('<div id="sobre">','', $feriado);
			$feriado = str_replace('<br>','', $feriado);
			$feriado = str_replace('<tr style="background-color:#004080;">','<tr style="background-color:#cbced0;">', $feriado);

			//genero cuerpo
			$s_body = '
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-birthday-cake" aria-hidden="true"></i></div><h5>Feriados de Chile</h5>
				</header>
				<div class="external_page">
					'.$feriado.'
				</div>
			</div>';

			/**********************/
			//devuelvo
			return $s_body;
		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			return alert_post_data(4,1,1,0, 'No se obtuvieron datos');
		}

	//si no fue concedido
	} else {
		return alert_post_data(4,1,1,0, 'La funcion allow_url_fopen no esta activa');
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Muestra los dias feriados del año
*
*===========================     Detalles    ===========================
* Muestra los dias feriados del año
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	widget_radio_player();
*
*===========================    Parametros   ===========================
* @return  html
************************************************************************/
//Funcion
function widget_radio_player(){
	//radios
	$arr = array();
	$arr[] = array('https://redirector.dps.live/biobiosantiago/aac/icecast.audio',                                               '2939.v10.png',         'Radio Bio Bio');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/CORAZONAAC.aac?dist=onlineradiobox',       '2940.v12.png',         'Radio Corazón');
	$arr[] = array('https://mdstrm.com/audio/5c8d6406f98fbf269f57c82c/live.m3u8',                                                '3545.v8.png',          'Play FM');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/ADN.mp3?dist=onlineradiobox',              '334.v17.png',          'ADN Radio');
	$arr[] = array('https://redirector.dps.live/cooperativafm/mp3/icecast.audio',                                                '2990.v21.png',         'Radio Cooperativa');
	$arr[] = array('https://unlimited4-us.dps.live/p7concepcion/mp3/icecast.audio',                                              '62835.v15.png',        'Radio Punto 7 Concepción');
	$arr[] = array('https://sp.tvcontrolcp.com:10905/;',                                                                         '63733.v12.png',        'Radio Kpop Star');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/FUTURO_SC?dist=onlineradiobox',            '2895.v8.png',          'Radio Futuro');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/ROCK_AND_POPAAC.aac?dist=onlineradiobox',  '2920.v8.png',          'Rock & Pop');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/IMAGINA_SC?dist=onlineradiobox',           '322.v8.png',           'Radio Imagina');
	$arr[] = array('https://onlineradiobox.com/json/cl/paloma/play?platform=web',                                                '3434.v16.png',         'Radio Paloma');
	$arr[] = array('https://unlimited1-us.dps.live/carolinatv/carolinatv.smil/playlist.m3u8',                                    '358.v20.png',          'Radio Carolina');
	$arr[] = array('https://stream.edelweiss.fm/radio/8040/radio.mp3',                                                           '3266.v19.png',         'Radio Mirador');
	$arr[] = array('https://onlineradiobox.com/json/cl/delosrecuerdos/play?platform=web',                                        '63830.v9.png',         'FM de los Recuerdos');
	$arr[] = array('https://mdstrm.com/audio/5c915497c6fd7c085b29169d/live.m3u8',                                                '2943.v6.png',          'Radio Oasis');
	$arr[] = array('https://stream.edelweiss.fm/radio/8000/radio.mp3',                                                           '63821.v15.png',        'Radio Edelweiss');
	$arr[] = array('https://onlineradiobox.com/json/cl/carabineros/play?platform=web',                                           '75629.v8.png',         'Radio Carabineros');
	$arr[] = array('https://audio1.tustreaming.cl/9020/stream',                                                                  '3655.v7.png',          'Mi Radio');
	$arr[] = array('https://mdstrm.com/audio/5c915724519bce27671c4d15/icecast.audio?property=radiobox',                          '2988.v8.png',          'Sonar 105.3 FM');
	$arr[] = array('https://unlimited4-us.dps.live/romantica/aac/icecast.audio',                                                 '307.v19.png',          'Radio Romantica');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/ACTIVA.mp3?dist=onlineradiobox',           '3124.v11.png',         'RadioActiva');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/FMDOS_SC?dist=onlineradiobox',             '2938.v8.png',          'FM Dos');
	$arr[] = array('https://onlineradiobox.com/json/cl/carnavalantofagasta/play?platform=web',                                   '3070.v10.png',         'Radio Carnaval');
	$arr[] = array('https://unlimited4-us.dps.live/universo/aac/icecast.audio',                                                  '306.v7.png',           'Universo');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/PUDAHUEL.mp3?dist=onlineradiobox',         '309.v9.png',           'Radio Pudahuel');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/CONCIERTOAAC.aac?dist=onlineradiobox',     '2894.v5.png',          'Concierto 88.5 FM');
	$arr[] = array('https://radio.trix.hosting:18094/;',                                                                         '63045.v13.png',        'Retroclásicos Radio');
	$arr[] = array('https://unlimited4-us.dps.live/agricultura/gotardis/audio/now/livestream1.m3u8',                             '318.v12.png',          'Radio Agricultura');
	$arr[] = array('https://stream10.usastreams.com:10998/;',                                                                    '2898.v16.png',         'El Conquistador');
	$arr[] = array('https://unlimited4-us.dps.live/disney/mp364k/icecast.audio',                                                 '62400.v11.png',        'Radio Disney');
	$arr[] = array('https://mdstrm.com/audio/5c915613519bce27671c4caa/live.m3u8',                                                '63666.v9.png',         'Tele 13 Radio');
	$arr[] = array('https://stream.festival.cl/1',                                                                               '313.v13.png',          'Radio Festival');
	$arr[] = array('https://playerservices.streamtheworld.com/api/livestream-redirect/LOS40_CHILEAAC.aac?dist=onlineradiobox',   '2941.v13.png',         'Los 40');
	$arr[] = array('https://centova.neonetwork.cl:9154/stream',                                                                  '63848.v9.png',         'Radio Lola');
	$arr[] = array('https://unlimited4-us.dps.live/digitalfm/aac/icecast.audio',                                                 '329.v13.png',          'Digital FM');
	$arr[] = array('https://xradiopanel.com/8004/stream',                                                                        '63092.v10.png',        'Radio 80s');
	$arr[] = array('https://onlineradiobox.com/json/cl/estacion247/play?platform=web',                                           '73087.v11.png',        'Radio Estación 24/7');
	$arr[] = array('https://streaming.conectaapp.cl/fmplus',                                                                     '3085.v6.png',          'Radio Plus FM');
	$arr[] = array('https://onlineradiobox.com/json/cl/scuraexitos8090s/play?platform=web',                                      '63095.v14.png',        'Radioscura Éxitos 80/90&amp;#39;s');
	$arr[] = array('https://kpopreplay.radioca.st//stream',                                                                      '63655.v8.png',         'Kpop Replay');
	$arr[] = array('https://sonic.portalfoxmix.club:7157/;',                                                                     '80313.v24.png',        'Radio Raol Retro');
	$arr[] = array('https://unlimited11-cl.dps.live/infinita/aac/icecast.audio',                                                 '321.v9.png',           'Infinita Radio');
	$arr[] = array('https://unlimited3-cl.dps.live/beethovenfm/gotardis/audio/now/livestream1.m3u8',                             '332.v10.png',          'Beethoven');
	$arr[] = array('https://onlineradiobox.com/json/cl/araucana/play?platform=web',                                              '3293.v10.png',         'Radio Araucana');
	$arr[] = array('https://onlineradiobox.com/json/cl/ritoque/play?platform=web',                                               '3570.v6.png',          'Radio Ritoque');
	$arr[] = array('https://sonic.portalfoxmix.cl:7045/;',                                                                       '3401.v9.png',          'Picarona Panguipulli');
	$arr[] = array('https://vintage.ice.infomaniak.ch/vintage.mp3',                                                              '63368.v7.png',         'Radio Vintage');
	$arr[] = array('https://stream.zenolive.com/p0ar2tuq98quv',                                                                  '80442.v4.png',         'Radio K-pop Music');
	$arr[] = array('https://unlimited4-us.dps.live/nostalgica/aac/icecast.audio',                                                '3111.v9.png',          'Radio Nostalgica');
	$arr[] = array('https://audio1.tustreaming.cl:10973/stream',                                                                 '3147.v12.png',         'Radio Corporacion');
	$arr[] = array('https://aac.noot.live/laclavebb.aac',                                                                        '63522.v12.png',        'Radio La Clave');
	$arr[] = array('https://sonic.portalfoxmix.cl:7034/live',                                                                    '3553.v6.png',          'FM Dance');
	$arr[] = array('https://onlineradiobox.com/json/cl/maxima/play?platform=web',                                                '62964.v13.png',        'Radio Máxima');
	$arr[] = array('https://unlimited3-cl.dps.live/duna/gotardis/audio/now/livestream1.m3u8',                                    '328.v12.png',          'Duna');
	$arr[] = array('https://streamuchile.teslati.com/liveruch',                                                                  '3081.v11.png',         'Radio Universidad de Chile');
	$arr[] = array('https://unlimited1-us.dps.live/fmtiempotv/fmtiempotv.smil/playlist.m3u8',                                    '324.v8.png',           'FM Tiempo');
	$arr[] = array('https://onlineradiobox.com/json/cl/mirasol/play?platform=web',                                               '63863.v8.png',         'Radio Mirasol');
	$arr[] = array('https://audio4.tustreaming.cl/8160/stream',                                                                  '63010.v13.png',        'Viña del Mar Classic');
	$arr[] = array('https://sonic.portalfoxmix.cl/8226/stream',                                                                  '80534.v7.png',         'Recuerdos Retro');
	$arr[] = array('https://us9.maindigitalstream.com/ssl/7389',                                                                 '1840.v10.png',         'Radio Sol');
	$arr[] = array('https://broadcast.radio247.net/radio/8100/stream',                                                           '3012.v11.png',         'Desierto FM');
	$arr[] = array('https://onlineradiobox.com/json/cl/rtl/play?platform=web',                                                   '3432.v17.png',         'Radio RTL Curicó');
	$arr[] = array('https://unlimited11-cl.dps.live/elcarbon/aac/icecast.audio',                                                 '63826.v10.png',        'Radio El Carbon');
	$arr[] = array('https://mdstrm.com/audio/5de7fdb07e2fde0798203821/live.m3u8',                                                '63379.v26.png',        'Rockaxis');
	$arr[] = array('https://rusach.janus.cl/playlist/stream.m3u8',                                                               '3543.v15.png',         'Radio USACH');
	$arr[] = array('https://onlineradiobox.com/json/cl/nahuel/play?platform=web',                                                '3324.v9.png',          'Radio Nahuel');
	$arr[] = array('https://onlineradiobox.com/json/cl/vln/play?platform=web',                                                   '69682.v11.png',        'VLN Radio');
	$arr[] = array('https://archi-us.digitalproserver.com/osorno-fm.aac',                                                        '3322.v6.png',          'Radio Sago');
	$arr[] = array('https://unlimited4-us.dps.live/positiva/aac/icecast.audio',                                                  '68190.v15.png',        'Radio Positiva');
	$arr[] = array('https://onlineradiobox.com/json/cl/powerplaydiscotheque/play?platform=web',                                  '63328.v9.png',         'Power Play Discotheque');
	$arr[] = array('https://sonando-us.digitalproserver.com/ucvradio',                                                           '62979.v9.png',         'UCV Radio');
	$arr[] = array('https://sonic.portalfoxmix.cl:7026/stream',                                                                  '63196.v10.png',        'Radio Fiesta Mix');
	$arr[] = array('https://onlineradiobox.com/json/cl/lavozdelacosta/play?platform=web',                                        '63841.v9.png',         'Radio La Voz de la Costa');
	$arr[] = array('https://streaming.conectaapp.cl/fmquiero',                                                                   '71461.v9.png',         'FM Quiero');
	$arr[] = array('https://onlineradiobox.com/json/cl/libra/play?platform=web',                                                 '62980.v9.png',         'Radio Libra');
	$arr[] = array('https://onlineradiobox.com/json/cl/codigometal/play?platform=web',                                           '58095.v9.png',         'Código Metal Radio');
	$arr[] = array('https://archi-us.digitalproserver.com/austral.aac',                                                          '3406.v6.png',          'Radio Austral');
	$arr[] = array('https://streaming.conectaapp.cl/canal95',                                                                    '3008.v6.png',          'Radio Canal 95');
	$arr[] = array('https://onlineradiobox.com/json/cl/dulce/play?platform=web',                                                 '3564.v7.png',          'Radio Dulce');
	$arr[] = array('https://portales.tustreamings1.cl/stream',                                                                   '3552.v7.png',          'Radio Portales');
	$arr[] = array('https://radiostreaming.cloudserverlatam.com/8088/stream',                                                    '74515.v5.png',         'Radio Beat 98.7 FM');
	$arr[] = array('https://onlineradiobox.com/json/cl/punto9/play?platform=web',                                                '62871.v14.png',        'Radio Punto 9');
	$arr[] = array('https://onlineradiobox.com/json/cl/azukar1079/play?platform=web',                                            '74095.v3.png',         'Radio Azukar 107.9 FM');
	$arr[] = array('https://onlineradiobox.com/json/cl/caramelo/play?platform=web',                                              '3230.v15.png',         'Radio Caramelo-Malleco');
	$arr[] = array('https://sonic-us.streaming-chile.com:7037/;',                                                                '63866.v25.png',        'Dossil Radio Chile');
	$arr[] = array('https://onlineradiobox.com/json/cl/sinfoniaonline/play?platform=web',                                        '63067.v16.png',        'Radio Sinfonia Online');
	$arr[] = array('https://onlineradiobox.com/json/cl/lagosdelsur/play?platform=web',                                           '79342.v7.png',         'FM Lagos del Sur');
	$arr[] = array('https://stream.zeno.fm/cpvysp4m4ceuv',                                                                       '76736.v21.png',        'World Hits Radio (Radio Hits Chile)');
	$arr[] = array('https://archi-us.digitalproserver.com/definitiva.aac',                                                       '314.v7.png',           'Radio Definitiva');
	$arr[] = array('https://audio4.tustreaming.cl/8130/stream',                                                                  '3551.v13.png',         'Radio Santiago');
	$arr[] = array('https://onlineradiobox.com/json/cl/contemporanea/play?platform=web',                                         '62974.v9.png',         'Radio Contemporánea');
	$arr[] = array('https://onlineradiobox.com/json/cl/toromondo/play?platform=web',                                             '63060.v10.png',        'ToroMondo');
	$arr[] = array('https://unlimited3-cl.dps.live/radiopaula/gotardis/audio/now/livestream1.m3u8',                              '2991.v8.png',          'Paula FM');
	$arr[] = array('https://radiox.tustreamings5.cl/stream',                                                                     '63636.v12.png',        'Radio X FM');
	$arr[] = array('https://radio.tvstream.cl/8008/stream',                                                                      '68735.v34.png',        'Radio Zona Activa');
	$arr[] = array('https://onlineradiobox.com/json/cl/folclordechile/play?platform=web',                                        '63373.v8.png',         'Radio Folclor De Chile');
	$arr[] = array('https://radio.saopaulo01.com.br/8188/stream',                                                                '62832.v11.png',        '94.1 FM Patagonia Radio');
	$arr[] = array('https://onlineradiobox.com/json/cl/sanbartolome/play?platform=web',                                          '3249.v8.png',          'Radio San Bartolome');
	$arr[] = array('https://onlineradiobox.com/json/cl/classica1063/play?platform=web',                                          '3352.v10.png',         'Radio Classica');
	$arr[] = array('https://centova.neonetwork.cl:9172/stream',                                                                  '3354.v8.png',          'Radio Reloncavi');
	$arr[] = array('https://onlineradiobox.com/json/cl/chileno/play?platform=web',                                               '63413.v7.png',         'Rock Chileno');
	$arr[] = array('https://stream.zeno.fm/ktmru7k741zuv',                                                                       '75973.v9.png',         'Radio Modelo');
	$arr[] = array('https://stream.zeno.fm/c16qw0esehruv',                                                                       '82795.v10.png',        'Radio Retrocadas');
	$arr[] = array('https://onlineradiobox.com/json/cl/congreso/play?platform=web',                                              '62981.v9.png',         'Radio Congreso');
	$arr[] = array('https://cp.streamchileno.cl/radio/8040/radio.mp3',                                                           '3252.v19.png',         'Radio Riquelme');
	$arr[] = array('https://onlineradiobox.com/json/cl/supersol/play?platform=web',                                              '3656.v6.png',          'Radio SuperSol');
	$arr[] = array('https://audio.streaminghd.cl:2000/stream/RadioPulso',                                                        '80554.v20.png',        'Radio Pulso');
	$arr[] = array('https://sonic.portalfoxmix.cl:7012/;',                                                                       '3335.v9.png',          'Radio La Palabra');
	$arr[] = array('https://onlineradiobox.com/json/cl/magiztral/play?platform=web',                                             '63528.v11.png',        'Radio Magiztral');
	$arr[] = array('https://onlineradiobox.com/json/cl/gabrielaonline/play?platform=web',                                        '63349.v11.png',        'Radio Gabriela On Line');
	$arr[] = array('https://onlineradiobox.com/json/cl/galaxia/play?platform=web',                                               '63512.v7.png',         'Radio Galaxia');
	$arr[] = array('https://onlineradiobox.com/json/cl/fiessta/play?platform=web',                                               '3465.v8.png',          'Radio Fiessta');
	$arr[] = array('https://archi-us.digitalproserver.com/portales-fm-valparaiso-vina-del-mar.aac',                              '72051.v5.png',         'Radio Portales de Valparaiso');
	$arr[] = array('https://onlineradiobox.com/json/cl/macarena997/play?platform=web',                                           '320.v10.png',          'Macarena');
	$arr[] = array('https://onlineradiobox.com/json/cl/dimension/play?platform=web',                                             '70347.v14.png',        'Dimensión Primavera FM');
	$arr[] = array('https://archi-us.digitalproserver.com/santa-maria-am.aac',                                                   '3194.v6.png',          'Radio Santa Maria');
	$arr[] = array('https://onlineradiobox.com/json/cl/futura/play?platform=web',                                                '62773.v9.png',         'Futura 100.7 FM');
	$arr[] = array('https://audio3.tustreaming.cl:10964/caramelosvicente',                                                       '62926.v13.png',        'Radio Caramelo 104.5 FM');
	$arr[] = array('https://onlineradiobox.com/json/cl/pauta/play?platform=web',                                                 '75624.v8.png',         'Pauta FM');
	$arr[] = array('https://estilofm.tustreamings2.cl/stream',                                                                   '3417.v9.png',          'Estilo FM');
	$arr[] = array('https://onlineradiobox.com/json/cl/azul/play?platform=web',                                                  '3571.v7.png',          'Radio Azul');
	$arr[] = array('https://mdstrm.com/audio/5d013e4bc8a64d0da420ced6/live.m3u8',                                                '63579.v10.png',        'Súbela Radio');
	$arr[] = array('https://cp.streamchileno.cl/radio/8130/radio.mp3',                                                           '3251.v6.png',          'Radio Pinamar');


	//Hoja de estilo
	$input ='<link rel="stylesheet prefetch" href="'.DB_SITE_REPO.'/LIBS_js/mejs-player-master/build/mediaelementplayer.css">';

	//se crea widget
	$input .='
	<div id="main-wrapper">
		<div class="player-wrapper">
			<audio id="audio" class="mejs__player" controls="controls" src="">
				Your browser does not support the audio format.
			</audio>
			<ul class="playlist custom-counter" id="list">';
				foreach ($arr as $prod) {
					$input .='
					<li>
					   <div class="track-info" >
							<img class="station__title__logo" src="'.DB_SITE_REPO.'/LIBS_js/mejs-player-master/emisoras/'.$prod[1].'" alt="'.$prod[2].'" title="'.$prod[2].'">
							<a href="#" data-value="'.$prod[0].'">'.$prod[2].'</a>
						</div>
					</li>';
				}
			$input .='
			</ul>
		</div>
	</div>';

	//script
	$input .='
	<script src="'.DB_SITE_REPO.'/LIBS_js/mejs-player-master/build/mediaelement-and-player.js"></script>
	<script >
		// Dynamic URL change
		list.onclick = function(e) {
		  e.preventDefault();

		  var elm = e.target;
		  var audio = document.getElementById("audio");

		  var source = document.getElementById("audio");
		  source.src = elm.getAttribute("data-value");

		  audio.load(); //call this to just preload the audio without playing
		  audio.play(); //call this to play the song right away
		};
	 </script>
	 <style>
		/* Radio Player */
		#main-wrapper{padding:30px 0;}
		#main-wrapper .player-wrapper{border-radius: 5px;box-shadow: 0 0 8px -1px rgba(0, 0, 0, 0.25);background-image: -webkit-linear-gradient(315deg, #FF5572, #FF7555);background-image: linear-gradient(135deg, #FF5572, #FF7555);overflow: hidden;margin: 0 auto;max-width:100%;width: 100%;padding: 0;border-radius:0;}
		#main-wrapper .player-wrapper .playlist {margin:0;padding:15px 15px 0 15px;height: 400px;overflow-x: auto;color:#fff;}
		#main-wrapper .player-wrapper .playlist li{ overflow: hidden;line-height: 20px;display: flex;padding: 10px 0;border-bottom: 1px solid rgba(230, 211, 211, 0.31);}
		#main-wrapper .player-wrapper .playlist li .track-info {display: inline-block;position: relative;line-height: 1.3em;width: 100%;font-weight:500;}
		#main-wrapper .player-wrapper .playlist li .track-info img { margin-right: 10px;border-radius: 3px;width: 90px;}
		#main-wrapper .player-wrapper .playlist li .track-info a{color: #fff;text-decoration:none;}
		.mejs__controls{height:60px;}
		.mejs__button.mejs__playpause-button.mejs__replay,.mejs__button.mejs__playpause-button.mejs__pause{background: #FFB00E;width: 40px;padding: 0 5px;border-radius: 50%;}
		.mejs__button.mejs__playpause-button.mejs__replay{background: #29cf54;}
		.mejs__button.mejs__playpause-button.mejs__play {background: #29cf54;width: 40px;padding: 0 5px;border-radius: 50%;}
		.mejs__time {box-sizing: content-box;color: #444;font-size: 15px;font-weight: bold;height: 24px;overflow: hidden;width: 50px;padding:16px 0;}
		.mejs__button > button  {display: block;padding: 0;border: 0;font-family: FontAwesome;font-size: 20px;color: #444;background: transparent!important;}
		.mejs__button.mejs__playpause-button.mejs__play button:before {content: "\f04b";color:#fff;}
		.mejs__button.mejs__playpause-button.mejs__pause button:before {content: "\f04c";color:#fff;}
		.mejs__button.mejs__playpause-button.mejs__replay button:before {content: "\f01e";color:#fff;}
		.mejs__button.mejs__volume-button.mejs__mute button:before {content: "\f028";}
		.mejs__button.mejs__volume-button.mejs__unmute button:before {content: "\f026";}
		.mejs__container {font-family: Segui Ui,Arial,serif;background-size: cover;position: relative;background:#fff;text-align: left;text-indent: 0;vertical-align: top;height: 80px!important;width: 100%!important;}
		.mejs__controls:not([style*="display: none"]) {background: none;}
		.mejs__time-total {background: rgb(212, 245, 221);margin: 5px 0 0;width: 100%;}
		span.mejs__time-current {background: #dedede;}
		span.mejs__time-loaded {background: #29cf54;}
		.mejs__time-handle-content {border: 4px solid rgba(255, 255, 255, 0.9);border-radius: 0;height: 10px;left: -5px;top: -4px;-webkit-transform: scale(0);-ms-transform: scale(0);transform: scale(0);width: 1px;}
		.mejs__horizontal-volume-total {background: rgb(41, 207, 84);height: 10px;top:14px;border-radius:0;}
	</style>';

	/**********************/
	//devuelvo
	return $input;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Muestra los dias feriados del año
*
*===========================     Detalles    ===========================
* Muestra los dias feriados del año
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	widget_youtube_player('https://www.youtube.com/watch?v=BRTG2XRpFZ8');
*
*===========================    Parametros   ===========================
* String   $link     URL con el video
* @return  html
************************************************************************/
//Funcion
function widget_youtube_player($link){

	/**********************/
	//Validaciones
	if(!isset($link) OR $link==''){  return alert_post_data(4,1,1,0,'No ha ingresado la URL con el video.');}

	/**********************/
	//Si todo esta ok
	//Se genera recurso
	$order   = 'https://www.youtube.com/watch?v=';
	$replace = 'https://www.youtube.com/embed/';
	$newstr  = str_replace($order, $replace, $link);

	//Genero el cuerpo
	$input = '
	<style>
		.yt_container {position: relative; width: 100%;height: 0;padding-bottom:56.25%; margin-bottom: 15px;}
		.yt_container .video {position: absolute;top: 0;left: 0;width: 100%;height: 100%;}
	</style>
	<div class="yt_container">
		<iframe class="video" src="'.$newstr.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>';

	/**********************/
	//devuelvo
	return $input;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Estrellas
*
*===========================     Detalles    ===========================
* Muestra estrellas de evaluacion
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta
* 	obtenerExtensionArchivo('nombre del archivo');
*
*===========================    Parametros   ===========================
* String   $max      Numero maximo de estrellas
* String   $value    Valor actual
* String   $text     Texto a mostrar en las estrellas
* @return  html
************************************************************************/
//Funcion
function widget_star_rating($max, $value, $text){

	/**********************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$requerido = array(0, 1, 2, 3, 4, 5);
	//Validaciones
	if(!isset($max) OR $max==''){        return alert_post_data(4,1,1,0,'No ha ingresado el Numero maximo de estrellas.');}
	if(!isset($value) OR $value==''){    return alert_post_data(4,1,1,0,'No ha ingresado el Valor actual.');}
	if(!isset($text) OR $text==''){      return alert_post_data(4,1,1,0,'No ha ingresado el Texto a mostrar en las estrellas.');}
	if(!validarNumero($max)){            return alert_post_data(4,1,1,0,'El dato $max ingresado no es un numero');}
	if(!validarNumero($value)){          return alert_post_data(4,1,1,0,'El dato $value ingresado no es un numero');}
	if (!in_array($value, $requerido)) { return alert_post_data(4,1,1,0, 'La configuracion $value ('.$value.') entregada en <strong>widget_star_rating</strong> no esta dentro de las opciones');}

	/**********************/
	//Si todo esta ok
	//Genero el cuerpo
	$input = '
	<div class="d-flex justify-content-between align-items-center widget_star_rating">
		<div class="ratings">';
			//recorro las estrellas
			for ($i = 1; $i <= $max; $i++) {
				//verifico si esta marcado
				if($i<=$value){
					$input.= '<i class="fa fa-star rating-color"></i>';
				}else{
					$input.= '<i class="fa fa-star"></i>';
				}
			}
			$input.= '
		</div>
		<h5 class="review-count">'.$text.'</h5>
	</div>';

	/**********************/
	//devuelvo
	return $input;

}

?>
