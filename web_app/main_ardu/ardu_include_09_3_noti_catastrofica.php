<?php
/*******************************************************************************************************************/
/*                                                Se ejecuta codigo                                                */
/*******************************************************************************************************************/
//recorro los correos
foreach ($arrCorreos as $correo) {

	/*************************************************************/
	//se envian correos si aun no se han enviado dentro de los tiempos
	if(isset($correo['Counter_Critical'])&&$correo['Counter_Critical']!=''&&$correo['Counter_Critical']==0){

		//se envian correos
		switch ($correo['idCorreosCat']) {
			/*********************************************************************/
			//Alerta temprana - Notificacion Correo - Alertas Catastroficas
			case $Global_AT_NC_AlertasCatastroficas:
				if(isset($Alertas_criticas)&&$Alertas_criticas!=''){
					//Envio de correo
					$rmail = tareas_envio_correo($correo['SistemaEmail'], DeSanitizar($correo['SistemaNombre']),
												$correo['UsuarioEmail'], 'Receptor',
												'', '',
												DeSanitizar($rowData['Nombre']).': Alerta Catastrofica',
												$Alertas_criticas,'',
												'',
												2,
												$correo['Gmail_Usuario'],
												$correo['Gmail_Password']);

					//Envio del mensaje
					if ($rmail!=1) {
						$LogAlertas .= "- Alerta Catastrofica: ".$correo['UsuarioEmail']." / (Envio Fallido->".$rmail.")\n";
					} else {
						$LogAlertas .= "- Alerta Catastrofica: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
						/***************************************/
						//Se guardan registro del envio del correo
						insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );

					}
				}
			break;
			/*********************************************************************/
			//Alerta temprana - Notificacion Whatsapp - Alertas Catastroficas
			case $Global_AT_NW_AlertasCatastroficas:
				if(isset($Alertas_criticas)&&$Alertas_criticas!=''){
					//Verifico existencias
					if(isset($correo['SistemaWhatsappToken'])&&$correo['SistemaWhatsappToken']!=''&&isset($correo['SistemaWhatsappInstanceId'])&&$correo['SistemaWhatsappInstanceId']!=''&&isset($correo['UsuarioFono'])&&$correo['UsuarioFono']!=''){
						//Variables
						$WhatsappToken       = $correo['SistemaWhatsappToken'];
						$WhatsappInstanceId  = $correo['SistemaWhatsappInstanceId'];
						$usuarioFono         = $correo['UsuarioFono'];

						//Definicion del cuerpo
						$Body['Phone']  = $usuarioFono;
						$Body['Cuerpo'] = "🚨 Alerta Critica ".DeSanitizar($rowData['Nombre']).":<br>";
						$Body['Cuerpo'].= $Alertas_criticas;

						//envio notificacion
						$whatsappResult = WhatsappSendTemplate($WhatsappToken, $WhatsappInstanceId, 1, $Body);
						//transformo a objeto
						$whatsappRes = json_decode($whatsappResult);
						//Si es el resultado esperado
						if($whatsappRes->sent === true){
							//Se guarda el log
							$LogAlertas .= "- Alerta temprana - Notificacion Whatsapp - Alertas Catastroficas: ".$usuarioFono." (".$correo['UsuarioEmail'].") / (Envio Correcto)\n";
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );
						}else{
							//Se guarda el log
							$LogAlertas .= "- Alerta temprana - Notificacion Whatsapp - Alertas Catastroficas: ".$usuarioFono." (".$correo['UsuarioEmail'].") / (Envio Fallido->".$whatsappResult.")\n";
						}

					}
				}
			break;
			/*********************************************************************/

		}
	}
}


?>
