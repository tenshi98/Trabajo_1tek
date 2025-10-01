<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-272).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['email']))            $email             = $_POST['email'];
	if (!empty($_POST['texto']))            $texto             = $_POST['texto'];
	if (!empty($_POST['email_principal']))  $email_principal   = $_POST['email_principal'];
	if (!empty($_POST['GmailUsuario']))     $GmailUsuario      = $_POST['GmailUsuario'];
	if (!empty($_POST['GmailPassword']))    $GmailPassword     = $_POST['GmailPassword'];
	if (!empty($_POST['Token']))            $Token             = $_POST['Token'];
	if (!empty($_POST['InstanceId']))       $InstanceId        = $_POST['InstanceId'];
	if (!empty($_POST['fono']))             $fono              = $_POST['fono'];
	if (!empty($_POST['grupo']))            $grupo             = $_POST['grupo'];
	if (!empty($_POST['mensaje']))          $mensaje           = $_POST['mensaje'];

/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $_SESSION['form_require']);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'email':            if(empty($email)){             $error['email']              = 'error/No ha ingresado el email';}break;
			case 'texto':            if(empty($texto)){             $error['texto']              = 'error/No ha ingresado el texto de prueba';}break;
			case 'email_principal':  if(empty($email_principal)){   $error['email_principal']    = 'error/No ha ingresado el email_principal';}break;
			case 'GmailUsuario':     if(empty($GmailUsuario)){      $error['GmailUsuario']       = 'error/No ha ingresado el GmailUsuario';}break;
			case 'GmailPassword':    if(empty($GmailPassword)){     $error['GmailPassword']      = 'error/No ha ingresado el GmailPassword';}break;
			case 'Token':            if(empty($Token)){             $error['Token']              = 'error/No ha ingresado el Token';}break;
			case 'InstanceId':       if(empty($InstanceId)){        $error['InstanceId']         = 'error/No ha ingresado el InstanceId';}break;
			case 'fono':             if(empty($fono)){              $error['fono']               = 'error/No ha ingresado el fono';}break;
			case 'grupo':            if(empty($grupo)){             $error['grupo']              = 'error/No ha ingresado el grupo';}break;
			case 'mensaje':          if(empty($mensaje)){           $error['mensaje']            = 'error/No ha ingresado el mensaje';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	//if(isset($email) && $email!=''){                     $email           = EstandarizarInput($email);}
	if(isset($texto) && $texto!=''){                     $texto           = EstandarizarInput($texto);}
	//if(isset($email_principal) && $email_principal!=''){ $email_principal = EstandarizarInput($email_principal);}
	if(isset($GmailUsuario) && $GmailUsuario!=''){       $GmailUsuario    = EstandarizarInput($GmailUsuario);}
	if(isset($GmailPassword) && $GmailPassword!=''){     $GmailPassword   = EstandarizarInput($GmailPassword);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($email)&&contar_palabras_censuradas($email)!=0){                      $error['email']           = 'error/Edita email, contiene palabras no permitidas';}
	if(isset($texto)&&contar_palabras_censuradas($texto)!=0){                      $error['texto']           = 'error/Edita texto, contiene palabras no permitidas';}
	if(isset($email_principal)&&contar_palabras_censuradas($email_principal)!=0){  $error['email_principal'] = 'error/Edita email principal, contiene palabras no permitidas';}
	if(isset($GmailUsuario)&&contar_palabras_censuradas($GmailUsuario)!=0){        $error['GmailUsuario']    = 'error/Edita Gmail Usuario, contiene palabras no permitidas';}
	if(isset($GmailPassword)&&contar_palabras_censuradas($GmailPassword)!=0){      $error['GmailPassword']   = 'error/Edita Gmail Password, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Pago Normal                                                    */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'send_mail':
			//Envio de correo
			$rmail = tareas_envio_correo($email_principal, DB_EMPRESA_NAME,
                                         $email, 'Receptor',
                                         '', '',
                                         'Notificacion',
                                         $texto,'',
                                         '',
                                         1,
										 $GmailUsuario,
										 $GmailPassword);
            //se guarda el log
			log_response(1, $rmail, $email.' (Asunto:Notificacion)');

            //Envio del mensaje
			if ($rmail!=1) {
				echo '<pre>';
					var_dump($rmail);
					//echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
				echo '</pre>';
				//header( 'Location: '.$location.'?error='.$rmail );
				//die;
			} else {
				$error['texto']    = 'sucess/Email enviado correctamente';
				header( 'Location: '.$location.'?send=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'send_mail_img':

			//Se agrega el header
			$Body  = '<img src="https://ci5.googleusercontent.com/proxy/uvRum7CA9Vi7WvNJjqf_y54g4AUlv-IhOZjDs6FB7pxptaprx772Cvql1rIGozXC3JOgoRZm3uleuzyFN1KnFodh6PtcRSeJJGW-pgR6DBg=s0-d-e1-ft#https://parquedelrecuerdo.cl/app/images/portal-email_head.jpg" class="CToWUd a6T" tabindex="0" width="800">';
			$Body .= '<br/><br/><br/>';
			$Body .= $texto;

			//Envio de correo
			$rmail = tareas_envio_correo($email_principal, 'Exilon360',
                                         $email, 'Receptor',
                                         '', '',
                                         'Notificacion',
                                         $Body,'',
                                         '',
                                         1,
										 '',
										 '');
            //se guarda el log
			log_response(1, $rmail, $email.' (Asunto:Notificacion)');

            //Envio del mensaje
			if ($rmail!=1) {
				header( 'Location: '.$location.'?error='.$rmail );
				die;
			} else {
				$error['texto']    = 'sucess/Email enviado correctamente';
				header( 'Location: '.$location.'?send=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_error':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_error']) OR !validaEntero($_GET['del_error']))&&$_GET['del_error']!=''){
				$indice = simpleDecode($_GET['del_error'], fecha_actual());
			}else{
				$indice = $_GET['del_error'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice)&&$indice!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice)&&$indice!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			if($errorn==0){
				//se borran los datos
				$resultado = db_delete_data (false, 'error_log', 'idErrorLog = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'send_mail_google':

			//Envio de correo
			$rmail = tareas_envio_correo_google($GmailUsuario, $GmailPassword, 'Exilon360',
												$email, 'Receptor',
												'', '',
												'Notificacion',
												$texto,'',
												'',
												1);

            //se guarda el log
			log_response(1, $rmail, $email.' (Asunto:Notificacion)');

            //Envio del mensaje
			if ($rmail!=1) {
				echo '<pre>';
					var_dump($rmail);
					echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
				echo '</pre>';

				//header( 'Location: '.$location.'?error='.$rmail );
				//die;
			} else {
				$error['texto']    = 'sucess/Email enviado correctamente';
				header( 'Location: '.$location.'?send=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'send_whatsapp':

			//envio mensaje
			if(isset($fono)&&$fono!=''){
				//Se arma
				$Body['Phone']   = $fono;
				$Body['Cuerpo']  = $mensaje;
				//envio notificacion
				$whatsappResult = WhatsappSendTemplate($Token, $InstanceId, 1, $Body);
				//transformo a objeto
				$whatsappRes = json_decode($whatsappResult);
				//Si es el resultado esperado
				if($whatsappRes->sent === true){
					//imprimo respuesta
					echo '<pre>';
						var_dump($whatsappRes);
					echo '</pre>';
				}else{
					//imprimo respuesta
					echo '<pre>';
						var_dump($whatsappRes);
					echo '</pre>';
				}
			}else{
				echo '<pre>nada</pre>';
			}

		break;
/*******************************************************************************************************************/
		case 'send_mail_format':
			//logo de la compañia
			$login_logo  = DB_SITE_MAIN.'/img/round_logo.png';
			//Se crea el cuerpo
			$BodyMail  = '
			<div style="background-color: #eef2f5;">
				<div style="background-color:transparent">
					<div style="margin:0 auto;min-width:320px;max-width:600px;height:50px;"></div>
				</div>
				<div style="background-color:transparent">
					<div style="margin:0 auto;min-width:320px;max-width:600px;background-color: #1649e4;border-top-left-radius: 5px;border-top-right-radius: 5px;">
						<div style="width:70%;float: left;">
							<p style="font-size: 30px;color:#ffe31d;margin:50px;font-family: Arial, sans-serif;">Bienvenidos</p>
						</div>
						<div style="width:30%;float: left;" align="center">
							<div style="padding:24px;">
								<img src="'.$login_logo.'" alt="" style="width: 100%; max-width: 200px; height: auto; margin: auto; display: block;">
							</div>
						</div>
						<div style="clear: both;"></div>
					</div>
				</div>
				<div style="background-color:transparent">
					<div style="margin:0 auto;min-width:320px;max-width:600px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;background-color:#ffffff;">
						<div style="padding:24px;">
							<p style="font-size: 12px;color:#1649e4;font-family: Arial, sans-serif;">'.$texto.'</p>
							<div style="clear: both;"></div>
						</div>
					</div>
				</div>
				<div style="background-color:transparent">
					<div style="margin:0 auto;min-width:320px;max-width:600px;height:50px;"></div>
				</div>
			</div>';

			//Envio de correo
			$rmail = tareas_envio_correo($email_principal, DB_EMPRESA_NAME,
                                         $email, 'Receptor',
                                         '', '',
                                         'Notificacion',
                                         $BodyMail,'',
                                         '',
                                         1,
										 '','');
            //se guarda el log
			log_response(1, $rmail, $email.' (Asunto:Notificacion)');

            //Envio del mensaje
			if ($rmail!=1) {
				echo '<pre>';
					var_dump($rmail);
					//echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
				echo '</pre>';
				//header( 'Location: '.$location.'?error='.$rmail );
				//die;
			} else {
				$error['texto']    = 'sucess/Email enviado correctamente';
				header( 'Location: '.$location.'?send=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
	}

?>
