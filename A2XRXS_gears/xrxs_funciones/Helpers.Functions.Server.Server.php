<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-018).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Fecha Actual
*
*===========================     Detalles    ===========================
* Permite obtener la fecha actual de chile
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	fecha_actual(); //devuelve la fecha actual con formato 2024-07-01
*
*===========================    Parametros   ===========================
* @return  Date
************************************************************************/
//Funcion
function fecha_actual(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos la fecha actual dandole un formato
	return date("Y-m-d");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Fecha Actual sin separadores
*
*===========================     Detalles    ===========================
* Permite obtener la fecha actual de chile sin los separadores
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	fecha_actual_val(); //devuelve la fecha actual con formato 20240701
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function fecha_actual_val(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos la fecha actual dandole un formato
	return date("Ymd");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Hora Actual
*
*===========================     Detalles    ===========================
* Permite obtener la hora actual de chile en formato estandar
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	hora_actual(); //devuelve la hora actual con formato 18:28:58
*
*===========================    Parametros   ===========================
* @return  Time
************************************************************************/
//Funcion
function hora_actual(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos la hora actual dandole un formato
	return date("H:i:s");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Hora Actual (alternativa)
*
*===========================     Detalles    ===========================
* Permite obtener la hora actual de chile utilizando guiones como
* separadores
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	hora_actual_val(); //devuelve la hora actual con formato 18-28-58
*
*===========================    Parametros   ===========================
* @return  Time
************************************************************************/
//Funcion
function hora_actual_val(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos la hora actual dandole un formato
	return date("H-i-s");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Numero del Dia Actual
*
*===========================     Detalles    ===========================
* Permite obtener el dia actual de chile, de 1 a 31 sin ceros
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	dia_actual(); //devuelve 1 (para la fecha 2024-07-01)
*
*===========================    Parametros   ===========================
* @return  Integer
************************************************************************/
//Funcion
function dia_actual(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos el dia actual dandole un formato
	return date("j");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Numero de la Semana Actual
*
*===========================     Detalles    ===========================
* Permite obtener la semana actual de chile, de 1 a 56?
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	semana_actual(); //devuelve 27 (para la fecha 2024-07-01)
*
*===========================    Parametros   ===========================
* @return  Integer
************************************************************************/
//Funcion
function semana_actual(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos la semana actual dandole un formato
	return date("W");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Numero del Mes Actual
*
*===========================     Detalles    ===========================
* Permite obtener el mes actual de chile, de 1 a 12
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	mes_actual(); //devuelve 7 (para la fecha 2024-07-01)
*
*===========================    Parametros   ===========================
* @return  Integer
************************************************************************/
//Funcion
function mes_actual(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos el mes actual dandole un formato
	return date("n");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Numero del Año Actual
*
*===========================     Detalles    ===========================
* Permite obtener el año actual de chile
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	ano_actual(); //devuelve 2024 (para la fecha 2024-07-01)
*
*===========================    Parametros   ===========================
* @return  Integer
************************************************************************/
//Funcion
function ano_actual(){
	// Establecer la zona horaria predeterminada a usar.
	date_default_timezone_set('America/Santiago');
	//Devolvemos el año actual dandole un formato
	return date("Y");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Directorio
*
*===========================     Detalles    ===========================
* Nombre de la funcion: MeDir
* Version de la funcion:  1.0.0.11
* Fecha de la funcion (Creacion):  01/06/2006
* Fecha de la funcion (revision 1.0.0.4):  19/08/2006
* Fecha de la funcion (ultima revision):  16/09/2006
*
* Autor: SERBice(r)
*
* Descripcion de la funcion: Recorre un directorio midiendo todos los
*                            archivos que contiene (incluso en sus
*                            subdirectorios, hasta el ultimo).
*
* Parametros de la funcion: El parametro $dir, establece el directorio sobre el
*                           cual actuara la funcion, es decir, que establece
*                           el directorio del cual se obtendra información de
*                           su tamaño.
*                           Si $dir no se establece se utilizara el directorio
*                           donde se encuentra el archivo que llamo a la
*                           funcion $subdirs es el parametro que establece si vamos
*                           o no a medir en subdirectorios o no. Si $subdirs
*                           no se establece su valor por defaul sera 1 y
*                           medira los subdirectorios
*
* Este Software se distribuye bajo Licencia GPL, por lo cual se solicita que
* se utilice con fines no lucrativos, es decir, que sea de uso Personal y No
* Comercial. Que se conserven los derechos de autor y que cualquier
* modificacion le sea notifiacda al autor, para saber y estar al tanto de
* los avances del software en cuestion; y de esta manera enriquezer aun mas
* esta peque?a herramienta
*
* Atentamente: SERBice(r)
*
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	MeDir('./backups', 1);
*
*===========================    Parametros   ===========================
* @return  Decimal
************************************************************************/
//Funcion
function MeDir($dir,$subdirs){
    /* Creamos un array con todos los nombres de directorios y  archivos contenidos dentro del directorio inicial */
    $arr = scandir($dir);

    /* establecemos que la variable $sizedir es igual a cero */
    $sizedir = 0;

    /* YA NO Recorremos el array saltando los directorios . y .. */
    for ($i=0; $i<count($arr); $i++){
        /* Comprobamos que el archivo/directorio actual no sea "." ni ".." */
        if ($arr[$i]!="." && $arr[$i]!=".."){
	        /* Si es un directorio hacer..... */
	        if (is_dir($dir ."/". $arr[$i])){
	            /* Establecemos que la variable $sizedir es igual a ella misma m?s el valor devuelto por MeDir */
	            if (isset($subdirs)&&$subdirs==1) $sizedir += MeDir($dir . "/" . $arr[$i],1);
	        /* Si es un archivo hacer ... */
			}else{
	            /* Establecemos que la variable $sizedir es igual a ella misma m?s el tama?o del fichero $dir ."/". $arr[$i] */
	            $sizedir += filesize($dir ."/". $arr[$i]);
	        }
        }
    }
    /* Devolvemos el valor total de $sizedir */
    return $sizedir;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener Uso Memoria Servidor
*
*===========================     Detalles    ===========================
* Permite obtener el uso de la memoria en el servidor,calculando la
* carga de trabajo en el servidor
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	obtenerUsoMemoriaServidor(true);
* 	obtenerUsoMemoriaServidor(false);
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function obtenerUsoMemoriaServidor($getPercentage=true){
	//Variables
    $memoryTotal = null;
    $memoryFree  = null;

    if (stristr(PHP_OS, "win")) {
        // Get total physical memory (this is in bytes)
        $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
        @exec($cmd, $outputTotalPhysicalMemory);

        // Get free physical memory (this is in kibibytes!)
        $cmd = "wmic OS get FreePhysicalMemory";
        @exec($cmd, $outputFreePhysicalMemory);

        if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
            // Find total value
            foreach ($outputTotalPhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryTotal = $line;
                    break;
                }
            }

            // Find free value
            foreach ($outputFreePhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryFree = $line;
                    $memoryFree *= 1024;  // convert from kibibytes to bytes
                    break;
                }
            }
        }
    }else{
        if (is_readable("/proc/meminfo")){
            $stats = @file_get_contents("/proc/meminfo");

            if ($stats !== false) {
                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find correct lines for total and free mem
                foreach ($stats as $statLine) {
                    $statLineData = explode(":", trim($statLine));

                    // Total memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                        $memoryTotal = trim($statLineData[1]);
                        $memoryTotal = explode(" ", $memoryTotal);
                        $memoryTotal = $memoryTotal[0];
                        $memoryTotal *= 1024;  // convert from kibibytes to bytes
                    }

                    // Free memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                        $memoryFree = trim($statLineData[1]);
                        $memoryFree = explode(" ", $memoryFree);
                        $memoryFree = $memoryFree[0];
                        $memoryFree *= 1024;  // convert from kibibytes to bytes
                    }
                }
            }
        }
    }

    if (is_null($memoryTotal) || is_null($memoryFree)) {
        return null;
    } else {
        if ($getPercentage) {
            return (100 - ($memoryFree * 100 / $memoryTotal));
        } else {
            return array(
                "total" => $memoryTotal,
                "free" => $memoryFree,
            );
        }
    }
}

function getNiceFileSize($bytes, $binaryPrefix) {
    if ($binaryPrefix==true) {
        $unit=array('B','KiB','MiB','GiB','TiB','PiB');
        if ($bytes==0) return '0 ' . $unit[0];
        return @round($bytes/pow(1024,($i=floor(log($bytes,1024)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
    } else {
        $unit=array('B','KB','MB','GB','TB','PB');
        if ($bytes==0) return '0 ' . $unit[0];
        return @round($bytes/pow(1000,($i=floor(log($bytes,1000)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener URL Raiz
*
*===========================     Detalles    ===========================
* Permite obtener la URL Raiz del sitio
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	getRootURL(); //devuelve 'https://www.php.net' (para la direccion 'https://www.php.net/manual/es/function.file-get-contents.php')
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function getRootURL(){
    $urls = 'http://';
    if (validarHttps()) {
        $urls = 'https://';
    }

    $url = $_SERVER['REQUEST_URI']; //returns the current URL
	$parts = explode('/',$url);
	$dir = $_SERVER['SERVER_NAME'];
	for ($i = 0; $i < count($parts) - 1; $i++) {
	 $dir .= $parts[$i] . "/";
	}
	return $urls.$dir;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtener URL Actual
*
*===========================     Detalles    ===========================
* Permite obtener la URL Actual
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	getCurrentURL(); //devuelve 'https://www.php.net/manual/es/function.file-get-contents.php' (para la direccion 'https://www.php.net/manual/es/function.file-get-contents.php')
*
*===========================    Parametros   ===========================
* @return  String
************************************************************************/
//Funcion
function getCurrentURL(){
    $url = 'http://';
    if (validarHttps()) {
        $url = 'https://';
    }

    if (isset($_SERVER['PHP_AUTH_USER'])) {
        $url .= $_SERVER['PHP_AUTH_USER'];
        if (isset($_SERVER['PHP_AUTH_PW'])) {
            $url .= ':'.$_SERVER['PHP_AUTH_PW'];
        }
        $url .= '@';
    }
    if (isset($_SERVER['HTTP_HOST'])) {
        $url .= $_SERVER['HTTP_HOST'];
    }
    if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80) {
        $url .= ':'.$_SERVER['SERVER_PORT'];
    }
    if (!isset($_SERVER['REQUEST_URI'])) {
        $url .= substr($_SERVER['PHP_SELF'], 1);
        if (isset($_SERVER['QUERY_STRING'])) {
            $url .= '?'.$_SERVER['QUERY_STRING'];
        }

        return $url;
    }

    $url .= $_SERVER['REQUEST_URI'];

    return $url;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Entregar tarea al servidor
*
*===========================     Detalles    ===========================
* Permite entregar una tarea al servidor para que la ejecute de forma
* separada a los tiempos de ejecucion de el programa desde donde
* se llama
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	tareasServer(https://www.ejemplo.com?param1=1&param2=2&param3=3);
*
*===========================    Parametros   ===========================
* String    $tarea    Dirección web con lo que se tiene que ejecutar
*                     en el servidor, entregar URL completas
************************************************************************/
//Funcion
function tareasServer($tarea){

	//Ejecutamos comando dentro del servidor
	$command = "/usr/bin/wget -N -q '".$tarea."' &";
	$fp = shell_exec($command);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve los errores de subida de archivos
*
*===========================     Detalles    ===========================
* Permite obtener el error exacto que da el servidor al subir archivos
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	uploadPHPError($_FILES["Archivo"]["error"]); //obtener el error al
*   subir el fichero con el nombre Archivo
*
*===========================    Parametros   ===========================
* int      $error   Tipo de error (0-8)
* @return  String
************************************************************************/
//Funcion
function uploadPHPError($error) {
	$PHPError = '';
	switch ($error) {
		case 0: $PHPError = "No hay error, el archivo se cargó con éxito"; break;
		case 1: $PHPError = "El archivo cargado supera la directiva upload_max_filesize en php.ini"; break;
		case 2: $PHPError = "El archivo cargado excede la directiva MAX_FILE_SIZE que se especificó en el formulario HTML"; break;
		case 3: $PHPError = "El archivo cargado solo se cargó parcialmente"; break;
		case 4: $PHPError = "No se cargó ningún archivo"; break;
		case 6: $PHPError = "Falta una carpeta temporal"; break;
		case 7: $PHPError = "Error al escribir el archivo en el disco"; break;
		case 8: $PHPError = "Una extensión PHP detuvo la carga del archivo"; break;
	}
	return $PHPError;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Guardar log
*
*===========================     Detalles    ===========================
* Permite guardar el log en un archivo especificado en la configuracion
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	log_response(1,$response, 'malvarez@mail.com' ); //Email log
* 	log_response(2,'', 'Error SQL' );                //Error SQL
* 	log_response(3,'', 'Error PHP' );                //Log de Error log PHP
* 	log_response(4,'', 'IP de hackeo' );             //Log de Hacking
*
*===========================    Parametros   ===========================
* int     $TipoLog             Tipo de log (1-4)
* String  $RespuestaServidor   Texto plano con formato html
* String  $Data                Texto plano
************************************************************************/
//Funcion
function log_response($TipoLog, $RespuestaServidor, $Data){

	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$tipos = array(1, 2, 3, 4);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($TipoLog, $tipos)) {
		alert_post_data(4,1,1,0, 'La configuracion $TipoLog ('.$TipoLog.') entregada no esta dentro de las opciones');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){
		//variable
		$noti = "";

		///////////////////////////////////////////////////////////////////////////
		switch ($TipoLog) {
			/**************************************************************/
			//Email log
			case 1:
				//archivo de respaldo
				$Archivo = '1_logs_send_mail.txt';
				//se verifica respuesta del servidor
				if ($RespuestaServidor!=1) {
					$noti = "\n";
					$noti.= "Envio Fallido: (".fecha_actual()."-".hora_actual().") - ".$Data." \n";
					$noti.= "Error: ".$RespuestaServidor." \n";
					$noti.= "\n";
				} else {
					$noti = "Envio Correcto: (".fecha_actual()."-".hora_actual().") - ".$Data." \n";
				}
				break;
			/**************************************************************/
			//Error SQL
			case 2:
				//archivo de respaldo
				$Archivo = '1_logs_sql_error.txt';
				$noti = $Data." \n";
				break;
			/**************************************************************/
			//Log de Error log PHP
			case 3:
				//archivo de respaldo
				$Archivo = '1_logs_error_log_php.txt';
				$noti = $Data." \n";
				break;
			/**************************************************************/
			//Log de Hackeos
			case 4:
				//archivo de respaldo
				$Archivo = '1_logs_hacking.txt';
				$noti = $Data." \n";
				break;
		}

		///////////////////////////////////////////////////////////////////////////
		//solo si existe
		if (file_exists($Archivo)) {
			//se trata de guardar el archivo
			try {
				//Se guarda el registro de los correos enviados
				if ($FP = fopen ($Archivo, "a")){
					fwrite ($FP, $noti);
					fclose ($FP);
				}
			} catch (Exception $e) {
				error_log("Ha ocurrido un error (".$e->getMessage().")", 0);
			}
		}else{
			error_log("No existe el archivo (".$Archivo.")", 0);
		}

	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Guardar log
*
*===========================     Detalles    ===========================
* Permite guardar el log de los errores de ejecucion de php
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	php_error_log('Usuario', 'Transaccion', 'Tarea', 'ErrorCode', 'ErrorDescription', 'ErrorQuery');
*
*===========================    Parametros   ===========================
* String  $Usuario             Usuario quien genero el error
* String  $Transaccion         Transaccion donde se genero el error
* String  $Tarea               Tarea donde se ejecuto el error
* String  $ErrorCode           Codigo del error devuelta por la consulta
* String  $ErrorDescription    Descripcion del error generado
* String  $ErrorQuery          Consulta con el error
************************************************************************/
//Funcion
function php_error_log($Usuario, $Transaccion, $Tarea, $ErrorCode, $ErrorDescription, $ErrorQuery ){

	/***************************************/
	//Se escribe el log estandar
	error_log("========================================================================================================================================", 0);
	if(isset($Usuario)&&$Usuario!=''){                    error_log("Usuario: ". $Usuario, 0);}
	if(isset($Transaccion)&&$Transaccion!=''){            error_log("Transaccion: ". $Transaccion, 0);}
	if(isset($Tarea)&&$Tarea!=''){                        error_log("Tarea: ". $Tarea, 0);}
	if(isset($ErrorCode)&&$ErrorCode!=''){                error_log("Error code: ". $ErrorCode, 0);}
	if(isset($ErrorDescription)&&$ErrorDescription!=''){  error_log("Error description: ". $ErrorDescription, 0);}
	if(isset($ErrorQuery)&&$ErrorQuery!=''){              error_log("Error query: ". $ErrorQuery, 0);}

	/***************************************/
	//se limpia la cadena antes de guardarla
	$ErrorQuery = preg_replace("/[\r\n|\n|\r]+/", " ", $ErrorQuery);

	//Se respalda en el archivo designado
	$rmail         = '';
	$sesion_texto  = '';
	$sesion_texto .= fecha_estandar(fecha_actual());
	$sesion_texto .= ' /\ '.hora_actual();
	if(isset($Usuario)&&$Usuario!=''){                     $sesion_texto .= ' /\ '.$Usuario;           }else{$sesion_texto .= ' /\ Ninguno';}
	if(isset($Transaccion)&&$Transaccion!=''){             $sesion_texto .= ' /\ '.$Transaccion;       }else{$sesion_texto .= ' /\ Ninguna';}
	if(isset($Tarea)&&$Tarea!=''){	                       $sesion_texto .= ' /\ '.$Tarea;             }else{$sesion_texto .= ' /\ Ninguna';}
	if(isset($ErrorCode)&&$ErrorCode!=''){	               $sesion_texto .= ' /\ '.$ErrorCode;         }else{$sesion_texto .= ' /\ Ninguna';}
	if(isset($ErrorDescription)&&$ErrorDescription!=''){   $sesion_texto .= ' /\ '.$ErrorDescription;  }else{$sesion_texto .= ' /\ Ninguna';}
	if(isset($ErrorQuery)&&$ErrorQuery!=''){	           $sesion_texto .= ' /\ '.$ErrorQuery;        }else{$sesion_texto .= ' /\ Ninguna';}

	//se guarda el log
	log_response(3, $rmail, $sesion_texto);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Devuelve info del servidor
*
*===========================     Detalles    ===========================
* Devuelve toda la info del servidor
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	echo indicesServer()->PHP_SELF;
* 	echo indicesServer()->GATEWAY_INTERFACE;
* 	echo indicesServer()->SERVER_NAME;
* 	echo indicesServer()->SERVER_PROTOCOL;
* 	echo indicesServer()->REQUEST_TIME;
*
*===========================    Parametros   ===========================
* String  $response         Arreglo con la respuesta del correo (0-1)
* String  $email            Email a utilizar
************************************************************************/
//Funcion
function indicesServer(){

	$object = (object) [
		'PHP_SELF' => $_SERVER['PHP_SELF'],
		'argv' => $_SERVER['argv'],
		'argc' => $_SERVER['argc'],
		'GATEWAY_INTERFACE' => $_SERVER['GATEWAY_INTERFACE'],
		'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
		'SERVER_NAME' => $_SERVER['SERVER_NAME'],
		'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE'],
		'SERVER_PROTOCOL' => $_SERVER['SERVER_PROTOCOL'],
		'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
		'REQUEST_TIME' => $_SERVER['REQUEST_TIME'],
		'REQUEST_TIME_FLOAT' => $_SERVER['REQUEST_TIME_FLOAT'],
		'QUERY_STRING' => $_SERVER['QUERY_STRING'],
		'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'],
		'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'],
		'HTTP_ACCEPT_CHARSET' => $_SERVER['HTTP_ACCEPT_CHARSET'],
		'HTTP_ACCEPT_ENCODING' => $_SERVER['HTTP_ACCEPT_ENCODING'],
		'HTTP_ACCEPT_LANGUAGE' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
		'HTTP_CONNECTION' => $_SERVER['HTTP_CONNECTION'],
		'HTTP_HOST' => $_SERVER['HTTP_HOST'],
		'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
		'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
		'HTTPS' => $_SERVER['HTTPS'],
		'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
		'REMOTE_HOST' => $_SERVER['REMOTE_HOST'],
		'REMOTE_PORT' => $_SERVER['REMOTE_PORT'],
		'REMOTE_USER' => $_SERVER['REMOTE_USER'],
		'REDIRECT_REMOTE_USER' => $_SERVER['REDIRECT_REMOTE_USER'],
		'SCRIPT_FILENAME' => $_SERVER['SCRIPT_FILENAME'],
		'SERVER_ADMIN' => $_SERVER['SERVER_ADMIN'],
		'SERVER_PORT' => $_SERVER['SERVER_PORT'],
		'SERVER_SIGNATURE' => $_SERVER['SERVER_SIGNATURE'],
		'PATH_TRANSLATED' => $_SERVER['PATH_TRANSLATED'],
		'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'],
		'REQUEST_URI' => $_SERVER['REQUEST_URI'],
		'PHP_AUTH_DIGEST' => $_SERVER['PHP_AUTH_DIGEST'],
		'PHP_AUTH_USER' => $_SERVER['PHP_AUTH_USER'],
		'PHP_AUTH_PW' => $_SERVER['PHP_AUTH_PW'],
		'AUTH_TYPE' => $_SERVER['AUTH_TYPE'],
		'PATH_INFO' => $_SERVER['PATH_INFO'],
		'ORIG_PATH_INFO' => $_SERVER['ORIG_PATH_INFO'],
	];

	return $object;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Permite eliminar la carpeta
*
*===========================     Detalles    ===========================
* Permite eliminar una carpeta en especifico dentro del servidor
*===========================    Modo de uso  ===========================
* 	//elimino la carpeta en caso de existir
* 	$structure = '/client_folder/client/tutor'; //carpeta
* 	rrmdir($structure);
*
*===========================    Parametros   ===========================
* String  $src         ruta de la carpeta
************************************************************************/
function rrmdir($src) {
	//pruebo si se puede hacer
	try {
		//se abre carpeta
		$dir = opendir($src);
		//se recorren los archivos al interior y se borran
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				$full = $src . '/' . $file;
				if ( is_dir($full) ) {
					//se agrega recursividad
					rrmdir($full);
				}
				else {
					unlink($full);
				}
			}
		}
		//se cierra carpeta
		closedir($dir);
		//se borra carpeta
		rmdir($src);
	} catch (Exception $e) {
		//nada
	}
}

?>
