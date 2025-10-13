<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-019).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Envio de mensajes whatsapp
*
*===========================     Detalles    ===========================
* Permite el envio de mensajes whatsapp a traves de chat-api
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	WhatsappSendMessage('asdertcvbtrtr', '356644', '569122345678', 'test');
*
*===========================    Parametros   ===========================
* String   $Token        Token de la plataforma
* String   $InstanceId   Instancia a utilizar
* String   $Phone        Telefono a enviar el mensaje
* String   $Body         Mensaje
* @return  String
************************************************************************/
//Funcion
function WhatsappSendMessage($Token, $InstanceId, $Phone, $Body){
	/**********************/
	//Validaciones
	if($Body=='' OR $Body=='0'){ return false;}

	/**********************/
	//Se limpian los datos
	$myPhone = clearWhatsappNumber($Phone);
	$Body    = clearWhatsappText($Body);

	/**************************************/
	//verifico la existencia de datos
	if(isset($myPhone, $InstanceId, $Token)&&$myPhone!=''&&$InstanceId!=''&&$Token!=''){

		$url = 'https://api.1msg.io/'.$InstanceId.'/sendMessage';
		$data = array('token' => $Token,'phone' => $myPhone,'body'  => $Body,);
		$data_string = json_encode($data);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;

	//guardo el log
	}else{
		error_log("===============================================", 0);
		error_log("myPhone:".$myPhone, 0);
		error_log("InstanceId:".$InstanceId, 0);
		error_log("Token:".$Token, 0);
		error_log("===============================================", 0);
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Envio de mensajes whatsapp
*
*===========================     Detalles    ===========================
* Permite el envio de mensajes whatsapp a traves de chat-api
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	WhatsappSendTemplate('asdertcvbtrtr', '356644', 1, 'test');
*
*===========================    Parametros   ===========================
* String   $Token        Token de la plataforma
* String   $InstanceId   Instancia a utilizar
* String   $Phone        Telefono a enviar el mensaje
* String   $Body         Mensaje
* @return  String
************************************************************************/
//Funcion
function WhatsappSendTemplate($Token, $InstanceId, $Type, $Body){

	/**********************/
	//Validaciones
	if(!isset($Token) OR $Token==''){           return false;}
	if(!isset($InstanceId) OR $InstanceId==''){ return false;}
	if(!isset($Type) OR $Type==''){             return false;}
	if(!is_array($Body) OR empty($Body)){       return false;}

	/**********************/
	//Se limpian los datos
	$myPhone = clearWhatsappNumber($Body['Phone']);

	/**************************************/
	//Se arma el mensaje
	switch ($Type) {
		/*********************************************************/
		//Alertas solo un dato
		case 1:
			$data = [
				"token"     => $Token,
				"namespace" => "512f752c_ac4f_45a8_b5b5_2adcfe3ed73a",
				"template"  => "1tek_alerta_1",
				"language" => [
					"policy" => "deterministic",
					"code"   => "es"
				],
				"params" => [
					[
						"type" => "body",
						"parameters" => [
							["type" => "text", "text" => clearWhatsappText($Body['Cuerpo'])],
						]
					]
				],
				"phone" => $myPhone
			];
			break;
		/*********************************************************/
		//Alertas Admin
		case 999:
			$data = [
				"token"     => $Token,
				"namespace" => "512f752c_ac4f_45a8_b5b5_2adcfe3ed73a",
				"template"  => "alerta_iot",
				"language" => [
					"policy" => "deterministic",
					"code"   => "es"
				],
				"params" => [
					[
						"type" => "body",
						"parameters" => [
							["type" => "text", "text" => clearWhatsappText($Body['Titulo'])],
							["type" => "text", "text" => clearWhatsappText($Body['Cuerpo'])],
							["type" => "text", "text" => "asd2"],
							["type" => "text", "text" => "asd3"],
							["type" => "text", "text" => "asd4"],
							["type" => "text", "text" => "asd5"]
						]
					]
				],
				"phone" => $myPhone
			];
			break;

	}
	//Se transforman a un array json
	$data_string = json_encode($data);

	/**************************************/
	//Se hace el envio
	$url = 'https://api.1msg.io/'.$InstanceId.'/sendTemplate';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;

}
function clearWhatsappNumber($Phone){

	/**************************************/
	//verifico si numero comienza con +56 o con 56
	$myNumber = $Phone;
	$findme_1 = '+';
	$findme_2 = '+56';
	$findme_3 = '56';

	$pos_1 = strpos($myNumber, $findme_1);
	$pos_2 = strpos($myNumber, $findme_2);
	$pos_3 = strpos($myNumber, $findme_3);

	//si comienza con el +
	if ($pos_1 !== false && $pos_1==0) {
		//comienza con el +56
		if ($pos_2 !== false && $pos_2==0) {
			$myPhone = $Phone;
		//no comienza con el +56, es otro numero
		} else {
			$myPhone = '';
		}
	//no comienza por el +
	} else {
		//comienza con el 56
		if ($pos_3 !== false && $pos_3==0) {
			$myPhone = '+'.$Phone;
		//no comienza con el 56, es otro numero
		} else {
			$myPhone = '+56'.$Phone;
		}
	}

	/**************************************/
	return $myPhone;
}
function clearWhatsappText($Texto){

	/**************************************/
	//Normalizo el mensaje
	$saltoLinea = ' // ';

	$vowels_1 = array('<br/>', '<br>', '</br>');
	$vowels_2 = array('<strong>', '</strong>');
	$Texto     = str_replace($vowels_1, $saltoLinea, $Texto);
	$Texto     = str_replace($vowels_2, '*', $Texto);

	/**************************************/
	return $Texto;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Obtiene el contenido de un archivo
*
*===========================     Detalles    ===========================
* Permite ver el contenido de un archivo, devuelve el fichero a un string
*===========================    Modo de uso  ===========================
*
* 	//se obtiene dato
* 	file_contents('upload/archivo.txt');
*
*===========================    Parametros   ===========================
* String   $Path       Ruta del archivo
* @return  String
************************************************************************/
//Funcion
function file_contents($Path) {
	$str = @file_get_contents($Path);
	if ($str === FALSE) {
		throw new Exception("Cannot access '$Path' to read contents.");
	} else {
		return $str;
	}
}

?>
