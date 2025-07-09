<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-001).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
//require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['De_correo']))   $Post_De_correo   = $_POST['De_correo'];
	if (!empty($_POST['De_nombre']))   $Post_De_nombre   = $_POST['De_nombre'];
	if (!empty($_POST['Asunto']))      $Post_Asunto      = $_POST['Asunto'];
	if (!empty($_POST['CuerpoHTML']))  $Post_CuerpoHTML  = $_POST['CuerpoHTML'];

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}

	
/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'send_mail':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$errorn = 0;
			//Definicion de errores
			if(!isset($Post_De_correo) OR $Post_De_correo==''){         $errorn++;$error = 'No ha ingresado el correo origen';}
			if(!isset($Post_De_nombre) OR $Post_De_nombre==''){         $errorn++;$error = 'No ha ingresado el nombre origen';}
			if(!isset($Post_Asunto) OR $Post_Asunto==''){               $errorn++;$error = 'No ha ingresado el Asunto';}
			if(!isset($Post_CuerpoHTML) OR $Post_CuerpoHTML==''){       $errorn++;$error = 'No ha ingresado el mensaje';}
			//errores por falta de datos
			if(!isset($rowData['Contact_Recep_mail']) OR $rowData['Contact_Recep_mail']==''){              $errorn++;$error = 'No ha ingresado el Receptor - Asunto';}
			if(!isset($rowData['Contact_Recep_name']) OR $rowData['Contact_Recep_name']==''){              $errorn++;$error = 'No ha ingresado el Receptor - Email';}
			if(!isset($rowData['Contact_Recep_asunto']) OR $rowData['Contact_Recep_asunto']==''){          $errorn++;$error = 'No ha ingresado el Receptor - Nombre';}
			if(!isset($rowData['Config_SMTP_mailUsername']) OR $rowData['Config_SMTP_mailUsername']==''){  $errorn++;$error = 'No ha ingresado el Usuario SMTP';}
			if(!isset($rowData['Config_SMTP_mailPassword']) OR $rowData['Config_SMTP_mailPassword']==''){  $errorn++;$error = 'No ha ingresado el Contraseña del usuario SMTP';}
			if(!isset($rowData['Config_SMTP_Host']) OR $rowData['Config_SMTP_Host']==''){                  $errorn++;$error = 'No ha ingresado el Host del correo SMTP';}
			if(!isset($rowData['Config_SMTP_Port']) OR $rowData['Config_SMTP_Port']==''){                  $errorn++;$error = 'No ha ingresado el Puerto del correo SMTP';}
			if(!isset($rowData['Config_SMTP_Secure']) OR $rowData['Config_SMTP_Secure']==''){              $errorn++;$error = 'No ha ingresado el Protocolo de seguridad del correo SMTP';}

			/********************************************************/
			//Ejecucion si no hay errores
			if($errorn==0){

				//variables
				$De_correo         = $rowData['Contact_Recep_mail'];
				$De_nombre         = $rowData['Contact_Recep_name'];
				$Asunto            = $rowData['Contact_Recep_asunto'];
				$Asunto           .= $Post_Asunto;
				$CuerpoHTML        = '<strong>De: </strong>'.$Post_De_correo.' - '.$Post_De_nombre.'<br/>';
				$CuerpoHTML       .= '<strong>Mensaje: </strong>'.$Post_CuerpoHTML;
				$Hacia_correo      = $rowData['Contact_Recep_mail'];
				$Hacia_nombre      = $rowData['Contact_Recep_name'];
				$SMTP_mailUsername = $rowData['Config_SMTP_mailUsername'];
				$SMTP_mailPassword = $rowData['Config_SMTP_mailPassword'];
				$SMTP_Host         = $rowData['Config_SMTP_Host'];
				$SMTP_Port         = $rowData['Config_SMTP_Port'];
				$SMTP_Secure       = $rowData['Config_SMTP_Secure'];

				//Se cargan archivos para el envio de correos
				require_once '../LIBS_php/PHPMailer/src/PHPMailer.php';
				require_once '../LIBS_php/PHPMailer/src/SMTP.php';
				require_once '../LIBS_php/PHPMailer/src/Exception.php';

				//Instanciacion
				$mail = new PHPMailer\PHPMailer\PHPMailer(true);
							
				try {

					//Tell PHPMailer to use SMTP
					$mail->isSMTP();
					//Enable SMTP debugging
					// 0 = off (for production use)
					// 1 = client messages
					// 2 = client and server messages
					$mail->SMTPDebug = 0;
					//Ask for HTML-friendly debug output
					$mail->Debugoutput = 'html';
					//Set the hostname of the mail server
					$mail->Host = $SMTP_Host;
					// use
					// $mail->Host = gethostbyname('smtp.gmail.com');
					// if your network does not support SMTP over IPv6
					//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
					$mail->Port = $SMTP_Port;
					//Set the encryption system to use -> ssl
					$mail->SMTPSecure = $SMTP_Secure;
					//Whether to use SMTP authentication
					$mail->SMTPAuth = true;
					//Username to use for SMTP authentication - use full email address for gmail
					$mail->Username = $SMTP_mailUsername;
					//Password to use for SMTP authentication
					$mail->Password = $SMTP_mailPassword;

					//Datos de envio
					$mail->setFrom($De_correo, $De_nombre);           //Quien envia el correo
					$mail->addAddress($Hacia_correo, $Hacia_nombre);  //Destinatario
					$mail->addReplyTo($De_correo, $De_nombre);        //A quien responder el correo
							
					//Cuerpo del mensaje
					$mail->isHTML(true);           //Se setea para enviar html
					$mail->Subject = $Asunto;      //Asunto
					$mail->Body    = $CuerpoHTML;  //Cuerpo HTML
						
					//envio del correo
					$mail->send();

					//redirijo
					echo '<meta http-equiv="refresh" content="0;url='.$rowData['Domain'].'/index.php?sended=true#contacto">';
					//header( 'Location: '.$rowData['Domain'].'/index.php?sended=true#contacto' );
					//die;
					
						
				} catch (Exception $e) {
					//redirijo
					echo '<meta http-equiv="refresh" content="0;url='.$rowData['Domain'].'/index.php?error=true#contacto">';
					//header( 'Location: '.$rowData['Domain'].'/index.php?error=true#contacto' );
					//die;
				}
			}else{
				//redirijo
				echo '<meta http-equiv="refresh" content="0;url='.$rowData['Domain'].'/index.php?dataerror=true#contacto">';
				//header( 'Location: '.$rowData['Domain'].'/index.php?dataerror=true#contacto' );
				//die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
