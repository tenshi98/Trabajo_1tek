<?php
/*******************************************************************************************************************/
/*                                                Se ejecuta codigo                                                */
/*******************************************************************************************************************/
function insertSendCorreo($idSistema, $idUsuario, $idCorreosCat, $FechaSistema, $HoraSistema, $idTelemetria, $dbConn ){

	//Se guardan registro del envio del correo
	if(isset($idSistema) && $idSistema!=''){           $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
	if(isset($idUsuario) && $idUsuario!=''){           $SIS_data .= ",'".$idUsuario."'";      }else{$SIS_data .= ",''";}
	if(isset($idCorreosCat) && $idCorreosCat!=''){     $SIS_data .= ",'".$idCorreosCat."'";   }else{$SIS_data .= ",''";}
	//El timestamp
	if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
		$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
	}else{
		$SIS_data .= ",''";
	}
	if(isset($idTelemetria) && $idTelemetria!=''){    $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}

	/*******************************************************/
	// inserto los datos de registro en la db
	$SIS_columns       = 'idSistema, idUsuario,idCorreosCat, TimeStamp, idTelemetria';
	$insertCorreosSend = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_mnt_correos_list_sended', $dbConn, 'insertCorreosSend', basename($_SERVER["REQUEST_URI"], ".php"), 'insertCorreosSend');

}


/*************************************************************/
//Se verifica que se envien notificaciones
if($rowData['idAlertaTemprana']==1){
	//recorro los correos
	foreach ($arrCorreos as $correo) {

		/*************************************************************/
		//se envian correos si aun no se han enviado dentro de los tiempos
		if(isset($correo['Counter_Normal'])&&$correo['Counter_Normal']!=''&&$correo['Counter_Normal']==0){

			//separo por categoria
			switch ($correo['idCorreosCat']) {

				/*********************************************************************/
				//Alerta temprana - Notificacion Correo - Alertas Normales
				case $Global_AT_NC_AlertasNormales:
					if(isset($Alertas_perso)&&$Alertas_perso!=''){

						//Envio de correo
						$rmail = tareas_envio_correo($correo['SistemaEmail'], DeSanitizar($correo['SistemaNombre']),
													$correo['UsuarioEmail'], 'Receptor',
													'', '',
													DeSanitizar($rowData['Nombre']).': Alerta temprana - Alertas Normales',
													$Alertas_perso,'',
													'',
													2,
													$correo['Gmail_Usuario'],
													$correo['Gmail_Password']);

						//Envio del mensaje
						if ($rmail!=1) {
							$LogAlertas .= "	- Alerta temprana - Alertas Normales: ".$correo['UsuarioEmail']." / (Envio Fallido->".$rmail.")\n";
						} else {
							$LogAlertas .= "	- Alerta temprana - Alertas Normales: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							/***************************************/
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );

						}
					}
				break;
				/*********************************************************************/
				//Alerta temprana - Notificacion Correo - Equipo Fuera de Geocerca
				case $Global_AT_NC_EquipoFueraGeocerca:
					if(isset($FueraGeoCerca)&&$FueraGeoCerca!=''){
						//Envio de correo
						$rmail = tareas_envio_correo($correo['SistemaEmail'], DeSanitizar($correo['SistemaNombre']),
													$correo['UsuarioEmail'], 'Receptor',
													'', '',
													DeSanitizar($rowData['Nombre']).': Notificacion Equipo fuera de Geocerca',
													$FueraGeoCerca,'',
													'',
													2,
													$correo['Gmail_Usuario'],
													$correo['Gmail_Password']);

						//Envio del mensaje
						if ($rmail!=1) {
							$LogAlertas .= "	- Alerta temprana - Equipo Fuera de Geocerca: ".$correo['UsuarioEmail']." / (Envio Fallido->".$rmail.")\n";
						} else {
							$LogAlertas .= "	- Alerta temprana - Equipo Fuera de Geocerca: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							/***************************************/
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );

						}
					}
				break;
				/*********************************************************************/
				//Alerta temprana - Notificacion Correo - Exceso Velocidad
				case $Global_AT_NC_ExcesoVelocidad:
					if(isset($Velocidad)&&$Velocidad!=''){
						//Envio de correo
						$rmail = tareas_envio_correo($correo['SistemaEmail'], DeSanitizar($correo['SistemaNombre']),
													$correo['UsuarioEmail'], 'Receptor',
													'', '',
													DeSanitizar($rowData['Nombre']).': Notificacion Velocidad',
													$Velocidad,'',
													'',
													2,
													$correo['Gmail_Usuario'],
													$correo['Gmail_Password']);

						//Envio del mensaje
						if ($rmail!=1) {
							$LogAlertas .= "	- Alerta temprana - Velocidad: ".$correo['UsuarioEmail']." / (Envio Fallido->".$rmail.")\n";
						} else {
							$LogAlertas .= "	- Alerta temprana - Velocidad: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							/***************************************/
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );

						}
					}
				break;
				/*********************************************************************/
				//Alerta temprana - Notificacion Correo - Fuera de Linea
				case $Global_AT_NC_FueraLinea:
					if(isset($FueraLinea)&&$FueraLinea!=''){
						//Envio de correo
						$rmail = tareas_envio_correo($correo['SistemaEmail'], DeSanitizar($correo['SistemaNombre']),
													$correo['UsuarioEmail'], 'Receptor',
													'', '',
													DeSanitizar($rowData['Nombre']).': Notificacion Equipo fuera de Linea',
													$FueraLinea,'',
													'',
													2,
													$correo['Gmail_Usuario'],
													$correo['Gmail_Password']);

						//Envio del mensaje
						if ($rmail!=1) {
							$LogAlertas .= "	- Alerta temprana - Fuera de Linea: ".$correo['UsuarioEmail']." / (Envio Fallido->".$rmail.")\n";
						} else {
							$LogAlertas .= "	- Alerta temprana - Fuera de Linea: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							/***************************************/
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );

						}
					}
				break;
				/*********************************************************************/
				//Alerta temprana - Notificacion Whatsapp - Alertas Normales
				case $Global_AT_NW_AlertasNormales:
					if(isset($Alertas_perso)&&$Alertas_perso!=''){
						//Verifico existencias
						if(isset($correo['SistemaWhatsappToken'],$correo['SistemaWhatsappInstanceId'])&&$correo['SistemaWhatsappToken']!=''&&$correo['SistemaWhatsappInstanceId']!=''&&isset($correo['UsuarioFono'])&&$correo['UsuarioFono']!=''){
							//Variables
							$WhatsappToken       = $correo['SistemaWhatsappToken'];
							$WhatsappInstanceId  = $correo['SistemaWhatsappInstanceId'];
							$usuarioFono         = $correo['UsuarioFono'];

							//Definicion del cuerpo

							$msgBody = "⚠️ Alerta estándar ".DeSanitizar($rowData['Nombre'])." :".$saltoLinea;
							//detalle de alertas
							$msgBody .= $Alertas_perso;

							//envio notificacion
							WhatsappSendMessage($WhatsappToken, $WhatsappInstanceId, $usuarioFono, $msgBody);
							//Se guarda el log
							$LogAlertas .= "	- Alerta temprana - Notificacion Whatsapp - Alertas Normales: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );

						}
					}
				break;
				/*********************************************************************/
				//Alerta temprana - Notificacion Whatsapp - Equipo Fuera de Geocerca
				case $Global_AT_NW_EquipoFueraGeocerca:
					if(isset($FueraGeoCerca)&&$FueraGeoCerca!=''){
						//Verifico existencias
						if(isset($correo['SistemaWhatsappToken'])&&$correo['SistemaWhatsappToken']!=''&&isset($correo['SistemaWhatsappInstanceId'])&&$correo['SistemaWhatsappInstanceId']!=''&&isset($correo['UsuarioFono'])&&$correo['UsuarioFono']!=''){
							//Variables
							$WhatsappToken       = $correo['SistemaWhatsappToken'];
							$WhatsappInstanceId  = $correo['SistemaWhatsappInstanceId'];
							$usuarioFono         = $correo['UsuarioFono'];

							//Definicion del cuerpo

							$msgBody = "⚠️ Alerta temprana - Fuera de Geocerca ".DeSanitizar($rowData['Nombre'])." :".$saltoLinea;
							//detalle de alertas
							$msgBody .= $FueraGeoCerca;

							//envio notificacion
							WhatsappSendMessage($WhatsappToken, $WhatsappInstanceId, $usuarioFono, $msgBody);
							//Se guarda el log
							$LogAlertas .= "	- Alerta temprana - Notificacion Whatsapp - Alertas Normales: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );
						}
					}
				break;
				/*********************************************************************/
				//Alerta temprana - Notificacion Whatsapp - Exceso Velocidad
				case $Global_AT_NW_ExcesoVelocidad:
					if(isset($Velocidad)&&$Velocidad!=''){
						//Verifico existencias
						if(isset($correo['SistemaWhatsappToken'])&&$correo['SistemaWhatsappToken']!=''&&isset($correo['SistemaWhatsappInstanceId'])&&$correo['SistemaWhatsappInstanceId']!=''&&isset($correo['SistemaWhatsappChat_id'])&&$correo['SistemaWhatsappChat_id']!=''){
							//Variables
							$WhatsappToken       = $correo['SistemaWhatsappToken'];
							$WhatsappInstanceId  = $correo['SistemaWhatsappInstanceId'];
							$WhatsappChat_id     = $correo['SistemaWhatsappChat_id'];

							//Definicion del cuerpo
							$msgBody = "⚠️ Alerta temprana - Velocidad ".DeSanitizar($rowData['Nombre'])." :".$saltoLinea;
							//detalle de alertas
							$msgBody .= $Velocidad;

							//envio notificacion
							WhatsappGroupSendMessage($WhatsappToken, $WhatsappInstanceId, $WhatsappChat_id, $msgBody);
							//Se guarda el log
							$LogAlertas .= "	- Alerta temprana - Notificacion Grupo Whatsapp - Alertas Normales: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );
						}
					}
				break;
				/*********************************************************************/
				//Alerta temprana - Notificacion Whatsapp - Fuera de Linea
				case $Global_AT_NW_FueraLinea:
					if(isset($FueraLinea)&&$FueraLinea!=''){
						//Verifico existencias
						if(isset($correo['SistemaWhatsappToken'])&&$correo['SistemaWhatsappToken']!=''&&isset($correo['SistemaWhatsappInstanceId'])&&$correo['SistemaWhatsappInstanceId']!=''&&isset($correo['UsuarioFono'])&&$correo['UsuarioFono']!=''){
							//Variables
							$WhatsappToken       = $correo['SistemaWhatsappToken'];
							$WhatsappInstanceId  = $correo['SistemaWhatsappInstanceId'];
							$usuarioFono         = $correo['UsuarioFono'];

							//Definicion del cuerpo

							$msgBody = "⚠️ Alerta temprana - Fuera de Linea ".DeSanitizar($rowData['Nombre'])." :".$saltoLinea;
							//detalle de alertas
							$msgBody .= $FueraLinea;

							//envio notificacion
							WhatsappSendMessage($WhatsappToken, $WhatsappInstanceId, $usuarioFono, $msgBody);
							//Se guarda el log
							$LogAlertas .= "	- Alerta temprana - Notificacion Whatsapp - Alertas Normales: ".$correo['UsuarioEmail']." / (Envio Correcto)\n";
							//Se guardan registro del envio del correo
							insertSendCorreo($idSistema, $correo['idUsuario'], $correo['idCorreosCat'], $FechaSistema, $HoraSistema, $idTelemetria, $dbConn );
						}
					}
				break;

			}
		}
	}
}


?>
