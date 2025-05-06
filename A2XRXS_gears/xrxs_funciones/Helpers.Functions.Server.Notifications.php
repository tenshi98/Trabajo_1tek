<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-017).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Envio Correos
*
*===========================     Detalles    ===========================
* Permite enviar correos a traves del mismo servidor
*===========================    Modo de uso  ===========================
*
* 	//Envio de correo
*	$rmail = tareas_envio_correo('jperez@mail.com', 'Juan Perez',
*                                'malvarez@mail.com', 'Marisol Alvarez',
*                                'jefatura@mail.com', 'respaldo@mail.com',
*                                'Notificacion',
*                                '<p>Cuerpo mensaje</p>','Cuerpo mensaje',
*                                'upload/archivo adjunto.jpg',
* 								 1,
* 								 '',
* 								 '');
*   //Envio del mensaje
*	if ($rmail!=1) {
*
*	} else {
*
*	}
*
*===========================    Parametros   ===========================
* String    $De_correo          Correo Emisor
* String    $De_nombre          Nombre del usuario del Correo Emisor
* String    $Hacia_correo       Correo Receptor
* String    $Hacia_nombre       Nombre del usuario del Correo Receptor
* String    $CopiaCarbon        Correo Copia
* String    $CopiaCarbonOculta  Correo Copia oculta
* String    $Asunto             Asunto del correo
* String    $CuerpoHTML         Cuerpo del correo, con tag html
* String    $CuerpoNoHTML       Cuerpo del correo, sin tag html
* String    $Adjuntos           Ruta del archivo adjunto
* String    $lvl                Nivel
* String    $GmailUsername      Usuario de gmail (reemplaza a $De_correo)
* String    $GmailPassword      Contraseña del Usuario de gmail
************************************************************************/
//Funcion
function tareas_envio_correo($De_correo, $De_nombre,
							$Hacia_correo, $Hacia_nombre,
							$CopiaCarbon, $CopiaCarbonOculta,
							$Asunto,
							$CuerpoHTML,$CuerpoNoHTML,
							$Adjuntos,
							$lvl,
							$GmailUsername,
							$GmailPassword){
	//Variables
	$error  = '';

	//valido que exista correo
	if(isset($De_correo, $Hacia_correo)&&$De_correo!=''&&$Hacia_correo!=''){
		//valido que los correos sean validos
		if(validarEmail(DeSanitizar($De_correo))&&validarEmail(DeSanitizar($Hacia_correo))){
			//verifico si los envio por gmail
			if(isset($GmailUsername, $GmailPassword)&&$GmailUsername!=''&&$GmailPassword!=''){

				tareas_envio_correo_google($GmailUsername, $GmailPassword, $De_nombre,
											$Hacia_correo, $Hacia_nombre,
											$CopiaCarbon, $CopiaCarbonOculta,
											$Asunto,
											$CuerpoHTML,$CuerpoNoHTML,
											$Adjuntos,
											$lvl);
			//si no se envian por gmail
			}else{

				/********************************************************/
				//Definicion de errores
				$errorn = 0;
				//se definen los errores
				if($De_correo==''){      $errorn++;$error = 'No ha ingresado el correo origen';}
				if($Hacia_correo==''){   $errorn++;$error = 'No ha ingresado el correo destino';}
				if($CuerpoHTML==''){     $errorn++;$error = 'No ha ingresado el mensaje';}
				//si no se sabe a quien va se modifica el nombre
				if($De_nombre==''){      $De_nombre    = 'Contacto';} //$errorn++;$error = 'No ha ingresado el nombre origen';}
				if($Hacia_nombre==''){   $Hacia_nombre = 'Contacto';} //$errorn++;$error = 'No ha ingresado el nombre destino';}

				/********************************************************/
				//Ejecucion si no hay errores
				if($errorn==0){

					//Se cargan archivos para el envio de correos
					switch ($lvl) {
						case 1:
							require_once '../LIBS_php/PHPMailer/src/PHPMailer.php';
							require_once '../LIBS_php/PHPMailer/src/SMTP.php';
							require_once '../LIBS_php/PHPMailer/src/Exception.php';
							break;
						case 2:
							require_once '../../LIBS_php/PHPMailer/src/PHPMailer.php';
							require_once '../../LIBS_php/PHPMailer/src/SMTP.php';
							require_once '../../LIBS_php/PHPMailer/src/Exception.php';
							break;
					}

					//Instanciacion
					$mail = new PHPMailer\PHPMailer\PHPMailer(true);

					try {
						//Datos de envio
						$mail->CharSet = 'UTF-8';
						$mail->setFrom(DeSanitizar($De_correo), DeSanitizar($De_nombre));               //Quien envia el correo
						$mail->addAddress(DeSanitizar($Hacia_correo), DeSanitizar($Hacia_nombre));      //Destinatario
						$mail->addReplyTo(DeSanitizar($De_correo), DeSanitizar($De_nombre));            //A quien responder el correo
						if($CopiaCarbon!=''){        $mail->addCC(DeSanitizar($CopiaCarbon));}          //Copia Carbon
						if($CopiaCarbonOculta!=''){  $mail->addBCC(DeSanitizar($CopiaCarbonOculta));}   //Copia Carbon oculta

						//Adjuntos
						if($Adjuntos!=''){
							$mail->addAttachment($Adjuntos);  // Datos Adjuntos
						}

						//Cuerpo del mensaje
						$mail->isHTML(true);                                    //Se setea para enviar html
						$mail->Subject = $Asunto;                               //Asunto
						if($CuerpoHTML!=''){  $mail->Body    = $CuerpoHTML;}    //Cuerpo HTML
						if($CuerpoNoHTML!=''){$mail->AltBody = $CuerpoNoHTML;}  //Cuerpo No HTML

						$mail->send();

						//error_log("/***************************************************************/", 0);
						//error_log("DE:".$De_correo, 0);
						//error_log("HACIA:".$Hacia_correo, 0);
						//error_log("ASUNTO:".$Asunto, 0);
						//error_log("/***************************************************************/", 0);

						return 1;
					} catch (Exception $e) {
						return $mail->ErrorInfo;
					}

				}else{
					error_log("/***************************************************************/", 0);
					error_log("Mail Error:".$error, 0);
					error_log("/***************************************************************/", 0);

					return $error;
				}
			}

		}else{
			error_log("/***************************************************************/", 0);
			if(!validarEmail($De_correo)){    $error = 'Mail Error:El Email (De: '.$De_correo.') ingresado no es valido';        error_log("Mail Error:El Email (De: ".$De_correo.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			if(!validarEmail($Hacia_correo)){ $error = 'Mail Error:El Email (Hacia: '.$Hacia_correo.') ingresado no es valido';  error_log("Mail Error:El Email (Hacia: ".$Hacia_correo.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			error_log("/***************************************************************/", 0);

			return $error;
		}
	}else{
		error_log("/***************************************************************/", 0);
		if(!isset($De_correo)){    $error = 'Mail Error:No ha ingresado Email (De)';    error_log("Mail Error:No ha ingresado Email (De), con el asunto (".$Asunto.")", 0);}
		if(!isset($Hacia_correo)){ $error = 'Mail Error:No ha ingresado Email (Hacia)'; error_log("Mail Error:No ha ingresado Email (Hacia), con el asunto (".$Asunto.")", 0);}

		error_log("/***************************************************************/", 0);

		return $error;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Envio Correos
*
*===========================     Detalles    ===========================
* Permite enviar correos a traves de un servidor SMTP externo
*===========================    Modo de uso  ===========================
*
* 	//Envio de correo
*	$rmail = tareas_envio_correo_smtp('jperez@mail.com', '12345','smtp.titan.email','465','ssl','Juan Perez',
*                                     'malvarez@mail.com', 'Marisol Alvarez',
*                                     'jefatura@mail.com', 'respaldo@mail.com',
*                                     'Notificacion',
*                                     '<p>Cuerpo mensaje</p>','Cuerpo mensaje',
*                                     'upload/archivo adjunto.jpg',
* 									  1);
*   //Envio del mensaje
*	if ($rmail!=1) {
*
*	} else {
*
*	}
*
*===========================    Parametros   ===========================
* String    $SMTP_mailUsername  Usuario SMTP
* String    $SMTP_mailPassword  Contraseña del usuario SMTP
* String    $SMTP_Host          Host del correo SMTP
* String    $SMTP_Port          Puerto del correo SMTP
* String    $SMTP_Secure        Protocolo de seguridad del correo SMTP
* String    $De_nombre          Nombre del usuario del Correo Emisor
* String    $Hacia_correo       Correo Receptor
* String    $Hacia_nombre       Nombre del usuario del Correo Receptor
* String    $CopiaCarbon        Correo Copia
* String    $CopiaCarbonOculta  Correo Copia oculta
* String    $Asunto             Asunto del correo
* String    $CuerpoHTML         Cuerpo del correo, con tag html
* String    $CuerpoNoHTML       Cuerpo del correo, sin tag html
* String    $Adjuntos           Ruta del archivo adjunto
* String    $lvl                Nivel
************************************************************************/
//Funcion
function tareas_envio_correo_smtp($SMTP_mailUsername, $SMTP_mailPassword, $SMTP_Host, $SMTP_Port, $SMTP_Secure, $De_nombre,
								$Hacia_correo, $Hacia_nombre,
								$CopiaCarbon, $CopiaCarbonOculta,
								$Asunto,
								$CuerpoHTML, $CuerpoNoHTML,
								$Adjuntos,
								$lvl){

	//Variables
	$error  = '';

	//valido que exista correo
	if(isset($SMTP_mailUsername, $Hacia_correo)&&$SMTP_mailUsername!=''&&$Hacia_correo!=''){
		//valido que los correos sean validos
		if(validarEmail(DeSanitizar($SMTP_mailUsername))&&validarEmail(DeSanitizar($Hacia_correo))){

			/********************************************************/
			//Definicion de errores
			$errorn = 0;
			//Definicion de errores
			if(!isset($SMTP_mailUsername) OR $SMTP_mailUsername==''){  $errorn++;$error = 'No ha ingresado el Usuario SMTP';}
			if(!isset($SMTP_mailPassword) OR $SMTP_mailPassword==''){  $errorn++;$error = 'No ha ingresado el Contraseña del usuario SMTP';}
			if(!isset($SMTP_Host) OR $SMTP_Host==''){                  $errorn++;$error = 'No ha ingresado el Host del correo SMTP';}
			if(!isset($SMTP_Port) OR $SMTP_Port==''){                  $errorn++;$error = 'No ha ingresado el Puerto del correo SMTP';}
			if(!isset($SMTP_Secure) OR $SMTP_Secure==''){              $errorn++;$error = 'No ha ingresado el Protocolo de seguridad del correo SMTP';}
			if(!isset($De_nombre) OR $De_nombre==''){                  $errorn++;$error = 'No ha ingresado el nombre origen';}
			if(!isset($Asunto) OR $Asunto==''){                        $errorn++;$error = 'No ha ingresado el Asunto';}
			if(!isset($CuerpoHTML) OR $CuerpoHTML==''){                $errorn++;$error = 'No ha ingresado el mensaje';}
			//si no se sabe a quien va se modifica el nombre
			if(!isset($De_correo) OR $De_correo==''){       $De_correo    = $SMTP_mailUsername;}
			if(!isset($De_nombre) OR $De_nombre==''){       $De_nombre    = 'Contacto';}
			if(!isset($Hacia_nombre) OR $Hacia_nombre==''){ $Hacia_nombre = 'Contacto';}

			/********************************************************/
			//Ejecucion si no hay errores
			if($errorn==0){

				//Se cargan archivos para el envio de correos
				switch ($lvl) {
					case 1:
						require_once '../LIBS_php/PHPMailer/src/PHPMailer.php';
						require_once '../LIBS_php/PHPMailer/src/SMTP.php';
						require_once '../LIBS_php/PHPMailer/src/Exception.php';
						break;
					case 2:
						require_once '../../LIBS_php/PHPMailer/src/PHPMailer.php';
						require_once '../../LIBS_php/PHPMailer/src/SMTP.php';
						require_once '../../LIBS_php/PHPMailer/src/Exception.php';
						break;
				}

				//Instanciacion
				$mail = new PHPMailer\PHPMailer\PHPMailer(true);

				try {
					//Configuracion SMTP
					$mail->isSMTP();
					$mail->SMTPDebug    = 0;
					$mail->Debugoutput  = 'html';
					$mail->Host         = $SMTP_Host;
					$mail->Port         = $SMTP_Port;
					$mail->SMTPSecure   = $SMTP_Secure;
					$mail->SMTPAuth     = true;
					$mail->Username     = DeSanitizar($SMTP_mailUsername);
					$mail->Password     = $SMTP_mailPassword;

					//Datos de envio
					$mail->CharSet = 'UTF-8';
					$mail->setFrom(DeSanitizar($De_correo), DeSanitizar($De_nombre));          //Quien envia el correo
					$mail->addAddress(DeSanitizar($Hacia_correo), DeSanitizar($Hacia_nombre)); //Destinatario
					$mail->addReplyTo(DeSanitizar($De_correo), DeSanitizar($De_nombre));       //A quien responder el correo
					if($CopiaCarbon!=''){       $mail->addCC($CopiaCarbon);}                   //Copia Carbon
					if($CopiaCarbonOculta!=''){ $mail->addBCC($CopiaCarbonOculta);}            //Copia Carbon oculta

					//Adjuntos
					if($Adjuntos!=''){
						$mail->addAttachment($Adjuntos);  // Datos Adjuntos
					}

					//Cuerpo del mensaje
					$mail->isHTML(true);                                    //Se setea para enviar html
					$mail->Subject = $Asunto;                               //Asunto
					if($CuerpoHTML!=''){  $mail->Body    = $CuerpoHTML;}    //Cuerpo HTML
					if($CuerpoNoHTML!=''){$mail->AltBody = $CuerpoNoHTML;}  //Cuerpo No HTML

					//envio del correo
					$mail->send();

					//error_log("/***************************************************************/", 0);
					//error_log("DE:".$De_correo, 0);
					//error_log("HACIA:".$Hacia_correo, 0);
					//error_log("ASUNTO:".$Asunto, 0);
					//error_log("/***************************************************************/", 0);

					return 1;
				} catch (Exception $e) {
					return $mail->ErrorInfo;
				}

			}else{
				error_log("/***************************************************************/", 0);
				error_log("Mail Error:".$error, 0);
				error_log("/***************************************************************/", 0);

				return $error;
			}

		}else{
			error_log("/***************************************************************/", 0);
			if(!validarEmail($SMTP_mailUsername)){    $error = 'Mail Error:El Email (De: '.$SMTP_mailUsername.') ingresado no es valido'; error_log("Mail Error:El Email (De: ".$SMTP_mailUsername.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			if(!validarEmail($Hacia_correo)){         $error = 'Mail Error:El Email (Hacia: '.$Hacia_correo.') ingresado no es valido';   error_log("Mail Error:El Email (Hacia: ".$Hacia_correo.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			error_log("/***************************************************************/", 0);

			return $error;
		}
	}else{
		error_log("/***************************************************************/", 0);
		if(!isset($SMTP_mailUsername)){    $error = 'Mail Error:No ha ingresado Email (De)';    error_log("Mail Error:No ha ingresado Email (De), con el asunto (".$Asunto.")", 0);}
		if(!isset($Hacia_correo)){         $error = 'Mail Error:No ha ingresado Email (Hacia)'; error_log("Mail Error:No ha ingresado Email (Hacia), con el asunto (".$Asunto.")", 0);}

		error_log("/***************************************************************/", 0);

		return $error;
	}

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Envio Correos
*
*===========================     Detalles    ===========================
* Permite enviar correos a traves del correo gmail
*===========================    Modo de uso  ===========================
*
* 	//Envio de correo
*	$rmail = tareas_envio_correo_google('jperez@Gmail.com', '123456', 'Juan Perez',
*                                		'malvarez@mail.com', 'Marisol Alvarez',
*                                		'jefatura@mail.com', 'respaldo@mail.com',
*                                		'Notificacion',
*                                		'<p>Cuerpo mensaje</p>','Cuerpo mensaje',
*                                		'upload/archivo adjunto.jpg',,
*                                       1);
*   //Envio del mensaje
*	if ($rmail!=1) {

*	} else {

*	}
*
*===========================    Parametros   ===========================
* String    $GmailUsername      Usuario Gmail
* String    $GmailPassword      Contraseña del usuario Gmail
* String    $De_nombre          Nombre del usuario del Correo Emisor
* String    $Hacia_correo       Correo Receptor
* String    $Hacia_nombre       Nombre del usuario del Correo Receptor
* String    $CopiaCarbon        Correo Copia
* String    $CopiaCarbonOculta  Correo Copia oculta
* String    $Asunto             Asunto del correo
* String    $CuerpoHTML         Cuerpo del correo, con tag html
* String    $CuerpoNoHTML       Cuerpo del correo, sin tag html
* String    $Adjuntos           Ruta del archivo adjunto
* String    $lvl                Nivel
************************************************************************/
//Funcion
function tareas_envio_correo_google($GmailUsername, $GmailPassword, $De_nombre,
									$Hacia_correo, $Hacia_nombre,
									$CopiaCarbon, $CopiaCarbonOculta,
									$Asunto,
									$CuerpoHTML, $CuerpoNoHTML,
									$Adjuntos,
									$lvl){

	//Variables
	$error  = '';

	//valido que exista correo
	if(isset($GmailUsername, $Hacia_correo)&&$GmailUsername!=''&&$Hacia_correo!=''){
		//valido que los correos sean validos
		if(validarEmail(DeSanitizar($GmailUsername))&&validarEmail(DeSanitizar($Hacia_correo))){

			/********************************************************/
			//Definicion de errores
			$errorn = 0;
			//se definen los errores
			if($GmailUsername==''){  $errorn++;$error = 'No ha ingresado el usuario de Gmail';}
			if($GmailPassword==''){  $errorn++;$error = 'No ha ingresado la contraseña del usuario de Gmail';}
			if($De_nombre==''){      $errorn++;$error = 'No ha ingresado el nombre origen';}
			if($Hacia_correo==''){   $errorn++;$error = 'No ha ingresado el correo destino';}
			if($Hacia_nombre==''){   $errorn++;$error = 'No ha ingresado el nombre destino';}
			if($CuerpoHTML==''){     $errorn++;$error = 'No ha ingresado el mensaje';}

			/********************************************************/
			//Ejecucion si no hay errores
			if($errorn==0){

				//Se cargan archivos para el envio de correos
				switch ($lvl) {
					case 1:
						require_once '../LIBS_php/PHPMailer/src/PHPMailer.php';
						require_once '../LIBS_php/PHPMailer/src/SMTP.php';
						require_once '../LIBS_php/PHPMailer/src/Exception.php';
						break;
					case 2:
						require_once '../../LIBS_php/PHPMailer/src/PHPMailer.php';
						require_once '../../LIBS_php/PHPMailer/src/SMTP.php';
						require_once '../../LIBS_php/PHPMailer/src/Exception.php';
						break;
				}


				//Instanciacion
				$mail = new PHPMailer\PHPMailer\PHPMailer(true);

				try {
					//Configuracion SMTP
					$mail->CharSet = 'UTF-8';
					$mail->isSMTP();
					$mail->SMTPDebug = 0;
					$mail->Debugoutput = 'html';
					$mail->Host = 'smtp.gmail.com';
					$mail->Port = 587;
					$mail->SMTPSecure = 'tls';
					$mail->SMTPAuth = true;
					$mail->Username = $GmailUsername;
					$mail->Password = $GmailPassword;

					//Datos de envio
					$mail->setFrom(DeSanitizar($GmailUsername), DeSanitizar($De_nombre));          //Quien envia el correo
					$mail->addAddress(DeSanitizar($Hacia_correo), DeSanitizar($Hacia_nombre));     //Destinatario
					$mail->addReplyTo(DeSanitizar($GmailUsername), DeSanitizar($De_nombre));       //A quien responder el correo
					if($CopiaCarbon!=''){       $mail->addCC(DeSanitizar($CopiaCarbon));}          //Copia Carbon
					if($CopiaCarbonOculta!=''){ $mail->addBCC(DeSanitizar($CopiaCarbonOculta));}   //Copia Carbon oculta

					//Adjuntos
					if($Adjuntos!=''){
						$mail->addAttachment($Adjuntos);  // Datos Adjuntos
					}

					//Cuerpo del mensaje
					$mail->isHTML(true);                                    //Se setea para enviar html
					$mail->Subject = $Asunto;                               //Asunto
					if($CuerpoHTML!=''){  $mail->Body    = $CuerpoHTML;}    //Cuerpo HTML
					if($CuerpoNoHTML!=''){$mail->AltBody = $CuerpoNoHTML;}  //Cuerpo No HTML

					$mail->send();

					//error_log("/***************************************************************/", 0);
					//error_log("DE:".$GmailUsername, 0);
					//error_log("HACIA:".$Hacia_correo, 0);
					//error_log("ASUNTO:".$Asunto, 0);
					//error_log("/***************************************************************/", 0);

					return 1;
				} catch (Exception $e) {
					error_log("/***************************************************************/", 0);
					error_log("GMail Error:".$mail->ErrorInfo, 0);
					error_log("/***************************************************************/", 0);
					return $mail->ErrorInfo;
				}

			}else{
				error_log("/***************************************************************/", 0);
				error_log("GMail Error:".$error, 0);
				error_log("/***************************************************************/", 0);

				return $error;
			}

		}else{
			error_log("/***************************************************************/", 0);
			if(!validarEmail($GmailUsername)){    $error = 'Mail Error:El Email (De: '.$GmailUsername.') ingresado no es valido';      error_log("Mail Error:El Email (De: ".$GmailUsername.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			if(!validarEmail($Hacia_correo)){     $error = 'Mail Error:El Email (Hacia: '.$Hacia_correo.') ingresado no es valido';    error_log("Mail Error:El Email (Hacia: ".$Hacia_correo.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			error_log("/***************************************************************/", 0);

			return $error;
		}
	}else{
		error_log("/***************************************************************/", 0);
		if(!isset($GmailUsername)){    $error = 'Mail Error:No ha ingresado Email (De)';    error_log("Mail Error:No ha ingresado Email (De), con el asunto (".$Asunto.")", 0);}
		if(!isset($Hacia_correo)){     $error = 'Mail Error:No ha ingresado Email (Hacia)'; error_log("Mail Error:No ha ingresado Email (Hacia), con el asunto (".$Asunto.")", 0);}

		error_log("/***************************************************************/", 0);

		return $error;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Envio Mensaje Push
*
*===========================     Detalles    ===========================
* Permite enviar mensajes o notificaciones a las aplicaciones android
*===========================    Modo de uso  ===========================
*
* 	//Envio de correo
*	$rmail = envio_mensaje_push('notificacion', 'mensaje','pantalla_push', 'xxxxxxxxxxxxxxx','xxxxxxxxxxxxxxxxxxx',
*                                 'http:www.image.com/image.jpg','pantalla_destino');
*
*   //Envio del mensaje
*	if ($rmail!=1) {

*	} else {

*	}
*
*===========================    Parametros   ===========================
* String    $title              Titulo de la notificacion
* String    $message            Mensaje de la notificacion
* String    $action             Pantalla a abrir en la app
* String    $firebase_token     Token firebase
* String    $firebase_api       Api firebase
* String    $imageUrl           Imagen a mostrar
* String    $actionDestination  Tarea a ejecutar en la app
* @return   int
************************************************************************/
//Funcion
function envio_mensaje_push($title, $message, $action, $firebase_token, $firebase_api,
							$imageUrl, $actionDestination){

	$url = 'https://fcm.googleapis.com/fcm/send';
	$fields = array (
			'to' => $firebase_token,
			'data' => array (
					"title" => $title,
					"body" => $message,
					"image" => $imageUrl,
					"action" => $action,
					"action_destination" => $actionDestination
			)
	);

	$fields = json_encode ( $fields );
	$headers = array (
			'Authorization: key='.$firebase_api,
			'Content-Type: application/json'
	);

	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_POST, true );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

	$result = curl_exec ( $ch );
	curl_close ( $ch );

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Envio Correos
*
*===========================     Detalles    ===========================
* Permite enviar correos a traves del servicio sendingblue
*===========================    Modo de uso  ===========================
*
* 	//Envio de correo
*	$rmail = envio_sendinblue('jperez@mail.com', 'Juan Perez',
*                             'malvarez@mail.com', 'Marisol Alvarez',
*                             'Notificacion', '<p>Cuerpo mensaje</p>',
* 							 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
*   //Envio del mensaje
*	if ($rmail!=1) {
*
*	} else {
*
*	}
*
*===========================    Parametros   ===========================
* String    $De_correo          Correo Emisor
* String    $De_nombre          Nombre del usuario del Correo Emisor
* String    $Hacia_correo       Correo Receptor
* String    $Hacia_nombre       Nombre del usuario del Correo Receptor
* String    $Asunto             Asunto del correo
* String    $CuerpoHTML         Cuerpo del correo, con tag html
* String    $APIKEY             Contraseña
************************************************************************/
//Funcion
function envio_sendinblue($De_correo, $De_nombre,
						  $Hacia_correo, $Hacia_nombre,
                          $Asunto, $CuerpoHTML,
						  $APIKEY){

	//valido que exista correo
	if(isset($De_correo, $Hacia_correo)&&$De_correo!=''&&$Hacia_correo!=''){
		//valido que los correos sean validos
		if(validarEmail(DeSanitizar($De_correo))&&validarEmail(DeSanitizar($Hacia_correo))){

			/********************************************************/
			//Definicion de errores
			$errorn = 0;
			//se definen los errores
			if($De_correo==''){      $errorn++;$error = 'No ha ingresado el correo de origen';}
			if($De_nombre==''){      $errorn++;$error = 'No ha ingresado el nombre de origen';}
			if($Hacia_correo==''){   $errorn++;$error = 'No ha ingresado el correo de destino';}
			if($Hacia_nombre==''){   $errorn++;$error = 'No ha ingresado el nombre de destino';}
			if($Asunto==''){         $errorn++;$error = 'No ha ingresado el asunto del mensaje';}
			if($CuerpoHTML==''){     $errorn++;$error = 'No ha ingresado el cuerpo del mensaje';}

			/********************************************************/
			//Ejecucion si no hay errores
			if($errorn==0){

				try {
					//Se crea arreglo para adjuntar datos
					$data = array(
						"sender" => array(
							"email" => DeSanitizar($De_correo),
							"name" => DeSanitizar($De_nombre)
						),
						"to" => array(
							array(
								"email" => DeSanitizar($Hacia_correo),
								"name" => DeSanitizar($Hacia_nombre)
							)
						),
						"subject" => $Asunto,
						"htmlContent" => '<html><head></head><body>'.$CuerpoHTML.'</body></html>'
					);

					//envio de los datos
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
					$headers = array();
					$headers[] = 'Accept: application/json';
					$headers[] = 'Api-Key: '.$APIKEY;
					$headers[] = 'Content-Type: application/json';
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$result = curl_exec($ch);
					curl_close($ch);

					return 1;
				} catch (Exception $e) {
					error_log("/***************************************************************/", 0);
					error_log("GMail Error:".$result, 0);
					error_log("/***************************************************************/", 0);
					return $result;
				}
			}else{
				error_log("/***************************************************************/", 0);
				error_log("GMail Error:".$error, 0);
				error_log("/***************************************************************/", 0);

				return $error;
			}
		}else{
			error_log("/***************************************************************/", 0);
			if(!validarEmail($De_correo)){        $error = 'Mail Error:El Email (De: '.$De_correo.') ingresado no es valido';          error_log("Mail Error:El Email (De: ".$De_correo.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			if(!validarEmail($Hacia_correo)){     $error = 'Mail Error:El Email (Hacia: '.$Hacia_correo.') ingresado no es valido';    error_log("Mail Error:El Email (Hacia: ".$Hacia_correo.") ingresado no es valido, con el asunto (".$Asunto.")", 0);}
			error_log("/***************************************************************/", 0);

			return $error;
		}
	}else{
		error_log("/***************************************************************/", 0);
		if(!isset($De_correo)){        $error = 'Mail Error:No ha ingresado Email (De)';    error_log("Mail Error:No ha ingresado Email (De), con el asunto (".$Asunto.")", 0);}
		if(!isset($Hacia_correo)){     $error = 'Mail Error:No ha ingresado Email (Hacia)'; error_log("Mail Error:No ha ingresado Email (Hacia), con el asunto (".$Asunto.")", 0);}
		error_log("/***************************************************************/", 0);

		return $error;
	}

}

?>
