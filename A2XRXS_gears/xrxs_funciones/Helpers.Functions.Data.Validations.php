<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-010).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validador de RUT con digito verificador
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es un rut chileno
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validarRut('10.569.874-5');
*
*===========================    Parametros   ===========================
* String   $Data    Dato a validar
* @return  Bolean
************************************************************************/
//Funcion
function validarRut($Data) {
    /**********************/
	//Validaciones
	if($Data=='' OR $Data=='0'){ return true;}

	/**********************/
	//Si todo esta ok
	//elimino el punto
	$rut = str_replace('.', '', $Data);

	// Verifica que no esté vacio y que el string sea de tamaño mayor a 3 carácteres(1-9)
	if ((empty($rut)) || strlen($rut) < 3) {
		return false; //RUT vacío o con menos de 3 caracteres.
	}

	// Quitar los últimos 2 valores (el guión y el dígito verificador) y luego verificar que sólo sea
	// numérico
	$parteNumerica = str_replace(substr($rut, -2, 2), '', $rut);

	if (!preg_match("/^[0-9]*$/", $parteNumerica)) {
		return false; //La parte numérica del RUT sólo debe contener números.
	}

	$guionYVerificador = substr($rut, -2, 2);
	// Verifica que el guion y dígito verificador tengan un largo de 2.
	if (strlen($guionYVerificador) != 2) {
		return false; //Error en el largo del dígito verificador.
	}

	// obliga a que el dígito verificador tenga la forma -[0-9] o -[kK]
	if (!preg_match('/(^[-]{1}+[0-9kK]).{0}$/', $guionYVerificador)) {
		return false; //El dígito verificador no cuenta con el patrón requerido
	}

	// Valida que sólo sean números, excepto el último dígito que pueda ser k
	if (!preg_match("/^[0-9.]+[-]?+[0-9kK]{1}/", $rut)) {
		return false; //Error al digitar el RUT
	}

	$rutV   = preg_replace('/[\.\-]/i', '', $rut);
	$dv     = substr($rutV, -1);
	$numero = substr($rutV, 0, strlen($rutV) - 1);
	$i      = 2;
	$suma   = 0;
	foreach (array_reverse(str_split($numero)) as $v) {
		if ($i == 8) {
			$i = 2;
		}
		$suma += $v * $i;
		++$i;
	}
	$dvr = 11 - ($suma % 11);
	if ($dvr == 11) {$dvr = 0;}
	if ($dvr == 10) {$dvr = 'K';}
	if ($dvr == strtoupper($dv)) {
		return true; //RUT ingresado correctamente.
	} else {
		return false; //El RUT ingresado no es válido.
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar correo
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es un correo
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validarEmail('asd@asd.cl'); //Devuelve true
* 	validarEmail('asd@asd');    //Devuelve false
*
*===========================    Parametros   ===========================
* String   $Data    Dato a validar
* @return  Bolean
************************************************************************/
//Funcion
function validarEmail($Data, $tempEmailAllowed = false){
	if(filter_var($Data,FILTER_VALIDATE_EMAIL)){
		return true; //Valido
    }else{
        return false; //Invalido
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar numero
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es un numero (negativos y decimales)
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validarNumero(25);   //Devuelve true
* 	validarNumero('25'); //Devuelve false
*
*===========================    Parametros   ===========================
* Decimal  $Data    Dato a validar
* @return  Bolean
************************************************************************/
//Funcion
function validarNumero($Data){
	/**********************/
	//Validaciones
	if($Data=='' OR $Data=='0'){ return true;}

	/**********************/
	//Si todo esta ok
	//cambio la coma por puntos para evitar problemas con los decimales
	$number = str_replace(',', '.', $Data);
	//Verfica si es un numero
	if(is_numeric($number)) {
		return true; //Valido
	}else{
		return false; //Invalido
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar Patente
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es una patente chilena
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	ValidarPatente('AU1825');  //Devuelve true
* 	ValidarPatente('512369');  //Devuelve false
*
*===========================    Parametros   ===========================
* String   $Data    Dato a validar
* @return  Bolean
************************************************************************/
//Funcion
function ValidarPatente($Data){
	/**********************/
	//Validaciones
	if($Data=='' OR $Data=='0'){ return true;}

	/**********************/
	//Si todo esta ok
	//elimino los posibles guones
	$patente = str_replace("-","",$Data);
 	//caracteres admitidos
 	$regex = '/^[a-z]{2}[\.\- ]?[0-9]{2}[\.\- ]?[0-9]{2}|[b-d,f-h,j-l,p,r-t,v-z]{2}[\-\. ]?[b-d,f-h,j-l,p,r-t,v-z]{2}[\.\- ]?[0-9]{2}$/i';
	//valida formato
	if (preg_match($regex, $patente)){
		return true; //Valido
	}else{
		return false; //Invalido
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar URL
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es una URL
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validarURL(https://www.google.cl');  //Devuelve true
* 	validarURL(https://www.  SSS  ');    //Devuelve false
*
*===========================    Parametros   ===========================
* String   $Data    Dato a validar
* @return  Bolean
************************************************************************/
//Funcion
function validarURL($Data){
    return (bool) filter_var($Data, FILTER_VALIDATE_URL);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar Hora
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es una hora, con un tope maximo de 99 horas
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validaHora('16:24:00'); //Devuelve true
* 	validaHora(16);         //Devuelve false
*
*===========================    Parametros   ===========================
* Time     $Data     Dato a validar
* @return  Bolean
************************************************************************/
//Funcion
function validaHora($Data) {
	//Valido el formato
	$bits = explode(':', $Data);
	//Si es un texto largo o el formato tiene mas de dos :
	if (count($bits)==1 || count($bits) > 3){
		return false; //Invalido
	}else{
		return true; //Valido
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar Fecha
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es una fecha
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validaFecha('1900-01-01');          //Devuelve true
* 	validaFecha('1900-01-01', 'Y-m-d'); //Devuelve true
* 	validaFecha(1900-01-01);            //Devuelve false
*
*===========================    Parametros   ===========================
* Date     $Data     Dato a validar
* String   $format   (Opcional) formato a validar
* @return  Bolean
************************************************************************/
//Funcion
function validaFecha($Data, $format = 'Y-m-d'){
	//valido que exista dato
	if(isset($Data)&&$Data!=''&&$Data!='0000-00-00'){
		$d = DateTime::createFromFormat($format, $Data);
		return $d && $d->format($format) == $Data;
	}else{
		return 'Sin Fecha';
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar entero
*
*===========================     Detalles    ===========================
* Valida si el dato ingresado es un numero entero
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validaEntero(16);   //Devuelve true
* 	validaEntero('16'); //Devuelve false
*
*===========================    Parametros   ===========================
* int      $Data    Dato a validar
* @return  Bolean
************************************************************************/
//Funcion
function validaEntero($Data){
    //se verifica si es un numero lo que se recibe
	if (is_numeric($Data)){
		return(ctype_digit(strval($Data)));
	}else{
		return 'El dato ingresado no es un numero';
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar Dispositivo Movil
*
*===========================     Detalles    ===========================
* Valida si el dispositivo es un dispositivo movil
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validaDispositivoMovil();
*
*===========================    Parametros   ===========================
* @return  Bolean
************************************************************************/
//Funcion
function validaDispositivoMovil(){
    $useragent=$_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
		return true; //Valido
	}else{
		return false; //Invalido
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Validar permiso
*
*===========================     Detalles    ===========================
* Permite validar el nivel del permiso otorgado al usuario
*===========================    Modo de uso  ===========================
*
* 	//se valida dato
* 	validaPermisoUser($nivel_usuario, $nivel_requerido, $dbConn);
*
*===========================    Parametros   ===========================
* int      $nivel_usuario    Nivel actual del usuario
* int      $nivel_requerido  Nivel requerido para ver la transaccion
* Objeto   $dbConn           Conexion a la base de datos
************************************************************************/
//Funcion
function validaPermisoUser($nivel_usuario, $nivel_requerido, $dbConn){
	//si el nivel de permiso del usuario es inferior al requerido
	if($nivel_usuario<$nivel_requerido){

		/****************************************************************/
		//variables
		$sesion_usuario          = 'Ninguno';
		$sesion_fecha            = fecha_actual();
		$sesion_hora             = hora_actual();
		$sesion_IP_Client        = obtenerIpCliente();
		$sesion_Agent_Transp     = obtenerSistOperativo().' - '.obtenerNavegador();
		$sesion_email_principal  = DB_EMPRESA_MAIL;
		$sesion_error_email      = DB_ERROR_MAIL;
		$sesion_RazonSocial      = DB_EMPRESA_NAME;
		$sesion_Empresa          = DB_SOFT_NAME;
		$sesion_Gmail_User       = DB_GMAIL_USER;
		$sesion_Gmail_Password   = DB_GMAIL_PASSWORD;
		$sesion_N_Hacks          = 5;
		$sesion_archivo          = 'Ninguno';
		$sesion_tarea            = 'Ninguna';
		//verifico si tiene sesion activa
		if(isset($_SESSION['usuario']['basic_data']['usuario'])&&$_SESSION['usuario']['basic_data']['usuario']!=''){
			$sesion_usuario = $_SESSION['usuario']['basic_data']['usuario'];
		}
		//Verifico desde donde viene si es que existe
		if(isset($original)&&$original!=''){         $sesion_archivo  = $original;}
		//verifico la tarea si es que existe
		if(isset($form_trabajo)&&$form_trabajo!=''){ $sesion_tarea    = $form_trabajo;}

		/****************************************************************/
		//Cuerpo del correo
		$sesion_texto  = '<h3>Intento de hackeo</h3><br/>';
		$sesion_texto .= '<strong>Desde:</strong>'.$sesion_Empresa.'<br/>';
		$sesion_texto .= '<strong>Fecha:</strong>'.fecha_estandar($sesion_fecha).'<br/>';
		$sesion_texto .= '<strong>Hora:</strong>'.$sesion_hora.'<br/>';
		$sesion_texto .= '<strong>IP Client:</strong>'.$sesion_IP_Client.'<br/>';
		$sesion_texto .= '<strong>Agent Transp:</strong>'.$sesion_Agent_Transp.'<br/>';
		$sesion_texto .= '<strong>Usuario:</strong>'.$sesion_usuario.'<br/>';
		$sesion_texto .= '<strong>Archivo Comprometido:</strong>'.$sesion_archivo.'<br/>';
		$sesion_texto .= '<strong>Tarea:</strong>'.$sesion_tarea.'<br/>';

		/****************************************************************/
		//se envia correo de alerta
		tareas_envio_correo($sesion_email_principal, $sesion_RazonSocial,
							$sesion_error_email, 'Receptor',
							'', '',
							'Intento de hackeo',
							$sesion_texto,'',
							'',
							1,
							$sesion_Gmail_User,
							$sesion_Gmail_Password);

		/****************************************************************/
		//se guarda log
		error_log("=========================================================", 0);
		error_log($sesion_texto, 0);
		error_log("=========================================================", 0);

		/****************************************************************/
		//se guarda en una tabla de datos
		$n_hackeos = db_select_nrows (false, 'idHacking', 'sistema_seguridad_hacking', '', "IP_Client='".$sesion_IP_Client."' OR usuario='".$sesion_usuario."'", $dbConn, $sesion_usuario, basename($_SERVER["REQUEST_URI"], ".php"), 'n_hackeos');
		//si ya hay demasiados intentos de hackeo
		if($n_hackeos>=$sesion_N_Hacks){
			//Se borra todos los datos relacionados a las sesiones
			session_unset();
			session_destroy();
			//redirijo a la pagina index
			header( 'Location: index.php' );
			die;
		//verifico el numero de intentos de hackeo y guardo el dato
		}elseif($n_hackeos<$sesion_N_Hacks){
			//filtros
			if(isset($sesion_fecha) && $sesion_fecha!=''){                $SIS_data  = "'".$sesion_fecha."'";           }else{$SIS_data  = "''";}
			if(isset($sesion_hora) && $sesion_hora!=''){                  $SIS_data .= ",'".$sesion_hora."'";           }else{$SIS_data .= ",''";}
			if(isset($sesion_IP_Client) && $sesion_IP_Client!=''){        $SIS_data .= ",'".$sesion_IP_Client."'";      }else{$SIS_data .= ",''";}
			if(isset($sesion_Agent_Transp) && $sesion_Agent_Transp!=''){  $SIS_data .= ",'".$sesion_Agent_Transp."'";   }else{$SIS_data .= ",''";}
			if(isset($sesion_usuario) && $sesion_usuario!=''){            $SIS_data .= ",'".$sesion_usuario."'";        }else{$SIS_data .= ",''";}

			// inserto los datos de registro en la db
			$SIS_columns = 'Fecha, Hora, IP_Client, Agent_Transp, usuario';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_seguridad_hacking', $dbConn, $sesion_usuario, basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//redirijo a la pagina principal
				header( 'Location: principal.php' );
				die;
			}
		//se redirige al principal
		}else{
			//redirijo a la pagina principal
			header( 'Location: principal.php' );
		}
	}
}

?>
