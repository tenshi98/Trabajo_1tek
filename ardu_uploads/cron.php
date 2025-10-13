<?php

/**********************************************************************************************************************************/
/*                                                    Crear Arreglo                                                               */
/**********************************************************************************************************************************/
//Ubicación de la carpeta
$thefolder    = '/home/ntekcl5/public_html/ardu_uploads/ardu_uploads/';
//$thefolder    = 'C:/laragon/www/power_engine_new/ardu_uploads/files/';
$ruta         = '/home/ntekcl5/public_html/ardu_uploads/backups/Respaldo_' . date('Ymd_His') . '/';

//Se crea la carpeta
$oldmask = umask(000);//it will set the new umask and returns the old one
mkdir($ruta, 0777);
umask($oldmask);//reset the old umask

/**********************************************************/
//Se envian los datos
//se abre y se recorren los archivos
if ($handler = opendir($thefolder)){
    while (false !== ($file = readdir($handler))){
        if (!in_array($file,array(".",".."))){
            //verifico si es un archivo
            if(is_file($thefolder.$file)){
                //Si el archivo existe se lee su contenido
                $arc = fopen($thefolder.$file,"r");
                while(! feof($arc))  {
                    $url = fgets($arc);
                    if($url!=''){
                        echo 'Linea: '.$url.'<br/>';
                        //curl_do_api($url);
                    }
                }
                fclose($arc);
                //Se mueven los archivos a la carpeta de respaldo
                rename($thefolder.$file, $ruta.$file);
            }
        }
    }
    //se cierra directorio
    closedir($handler);
}


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


?>
