<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                             CREACION Y ENVIO DE CORREOS A LOS USUARIOS                             */
/*                                                                                                    */
/******************************************************************************************************/
//Variable para el registro de correos enviados
$dir = "\n
################################################################################
Fecha de envio : ".$FechaSistema."
Hora Actual : ".$HoraSistema."
Usuarios :\n";
/*************************************************************************/
//se filtra por usuario
filtrar($arrCorreos, 'idUsuario');
//se recorren correos
foreach($arrCorreos as $usuarios=>$correos){

	//obtengo los datos del usuario
	$usuarioNombre          = DeSanitizar($correos[0]['UsuarioNombre']);   //Nombre del usuario
	$usuarioCorreo          = DeSanitizar($correos[0]['UsuarioEmail']);    //Para el envio de correos
	$usuarioFono            = $correos[0]['UsuarioFono'];                  //Para el envio de whatsapp

	//obtengo los datos del sistema
	$SistemaNombre             = DeSanitizar($correos[0]['SistemaNombre']); //Para el envio de correos
	$SistemaEmail              = $correos[0]['SistemaEmail'];               //Para el envio de correos
	$SistemaWhatsappToken      = $correos[0]['SistemaWhatsappToken'];       //Para el envio de whatsapp
	$SistemaWhatsappInstance   = $correos[0]['SistemaWhatsappInstanceId'];  //Para el envio de whatsapp

	//Datos para guardar registro del envio de la notificacion
	$sis_idSistema    = $correos[0]['idSistema'];
	$sis_idCorreosCat = $correos[0]['idCorreosCat'];
	$sis_idUsuario    = $usuarios;

	//Variables vacias
	$MSG_NC      = '';  //Crones - Reporte Dia - Notificacion Correo - Mediciones Actuales
	$MSG_NW      = '';  //Crones - Reporte Dia - Notificacion Whatsapp - Mediciones Actuales
	$CountNotiNC = 0;   //Contadores
	$CountNotiNW = 0;   //Contadores
	$CountSend   = 0;   //Contadores

	//se recorren los correos del usuario
	foreach ($correos as $correo) {
		//separo por categoria
		switch ($correo['idCorreosCat']) {
			/*********************************************************************/
			//Notificacion Correo
			case $Report_diario_NC:
				if(isset($MedicionesActuales_Correo[$correo['idTelemetria']])&&$MedicionesActuales_Correo[$correo['idTelemetria']]!=''){
					$MSG_NC .= $MedicionesActuales_Correo[$correo['idTelemetria']];
					$CountNotiNC++;
				}
				break;
			/*********************************************************************/
			//Notificacion Whatsapp
			case $Report_diario_NW:
				if(isset($MedicionesActuales_Whatsapp[$correo['idTelemetria']])&&$MedicionesActuales_Whatsapp[$correo['idTelemetria']]!=''){
					$MSG_NW .= $MedicionesActuales_Whatsapp[$correo['idTelemetria']];
					$CountNotiNW++;
				}
				break;
		}
	}

	/********************************************************************************************/
	/*                                        ENVIO DE CORREOS                                  */
	/********************************************************************************************/
	//Se verifica si existe correo
	if(isset($usuarioCorreo, $SistemaEmail)&&$usuarioCorreo!=''&&$SistemaEmail!=''&&$CountNotiNC!=0){

		/*******************************************************************/
		//Se le da una interfaz al mensaje
		$HTML_Body  = '
		<div style="background-color: #182854; padding: 10px;">
			<img src="https://clientes.1tek.cl/img/login_logo_color.png" style="width: 30%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">
			<h3 style="text-align: center;font-size: 30px;color: #ffffff;">Resumen Estado Equipos del '.fecha_estandar($FechaSistema).'</h3>
			<p style="text-align: center;font-size: 20px;color: #ffffff;">'.$usuarioNombre.'</p>';
		/**************************************/
		if($MSG_NC!=''){
			$HTML_Body .= '
			<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
				<thead>
					<tr style="background-color: #7a94cf;color: #ffffff;text-align: left;">
						<th colspan="8" style="padding: 12px 15px;text-align:center;"><strong>Resumen Estado Equipos</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background: #eee;">
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Subgrupo</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>ppm Actual</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>ppm Max</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>ppm Min</strong></td>
					</tr>';
			$HTML_Body .= $MSG_NC;
			$HTML_Body .= '</tbody></table>';
		}

		/**************************************/
		$HTML_Body .= '</div>';

		/*******************************************************************/
		//Envio de correo
		$rmail = tareas_envio_correo($SistemaEmail, $SistemaNombre,
									 $usuarioCorreo, $usuarioNombre,
									 '', '',
									 'Resumen Estado Equipos',
									 $HTML_Body,'',
									 '',
									 2,
									 '',
									 '');

		//Envio del mensaje
		if ($rmail!=1) {
			$dir .= "	- NC/".$SistemaNombre.": ".$usuarioCorreo." / (Envio Fallido->".$rmail.")\n";
		} else {
			$dir .= "	- NC/".$SistemaNombre.": ".$usuarioCorreo." / (Envio Correcto)\n";
			//contador del envio correcto
			$CountSend++;
		}
	}elseif($SistemaEmail==''){
		$dir .= "	- NC/".$SistemaNombre.": No hay correo principal configurado en la Empresa\n";
	}elseif($SubMensaje==''){
		$dir .= "	- NC/".$SistemaNombre.": No hay mensajes para el usuario ".$usuarioNombre." (".$usuarioCorreo.")\n";
	}elseif(!isset($usuarioCorreo) or $usuarioCorreo==''){
		$dir .= "	- NC/".$SistemaNombre.": No existe email relacionado al usuario ".$usuarioNombre." (".$usuarioCorreo.")\n";
	}else{
		$dir .= "	- NC/".$SistemaNombre.": Existen problemas con el usuario usuario ".$usuarioNombre." (".$usuarioCorreo.")\n";
	}

	/********************************************************************************************/
	/*                                       ENVIO DE WHATSAPP                                  */
	/********************************************************************************************/
	//Verifico existencias
	if(isset($SistemaWhatsappToken, $SistemaWhatsappInstance, $usuarioFono, $MSG_NW)&&$SistemaWhatsappToken!=''&&$SistemaWhatsappInstance!=''&&$usuarioFono!=''&&$CountNotiNW!=0&&$MSG_NW!=''){
		/*******************************************************************/
		//se intenta enviar la notificacion
		try {
			//Definicion del cuerpo
			$Body['Phone']  = $usuarioFono;
			$Body['Cuerpo'] = 'Resumen Estado Equipos<br/>';
			$Body['Cuerpo'].= $MSG_NW;
			//envio notificacion
			$whatsappResult = WhatsappSendTemplate($WhatsappToken, $WhatsappInstanceId, 1, $Body);
			//transformo a objeto
			$whatsappRes = json_decode($whatsappResult);
			//Si es el resultado esperado
			if($whatsappRes->sent === true){
				//guardo el registro de los mensajes enviados
				$dir .= "	- NW/".$SistemaNombre.": ".$usuarioFono." (".$usuarioCorreo.") / (Envio Correcto)\n";
				//contador del envio correcto
				$CountSend++;
			}else{
				//guardo el registro de los mensajes enviados
				$dir .= "	- NW/".$SistemaNombre.": ".$usuarioFono." (".$usuarioCorreo.") / (Envio Fallido->".$whatsappResult.")\n";
			}
		} catch (Exception $e) {
			$dir .= "	- NW/Excepción capturada: / (Envio Noti Whatsapp Fallido->".$e->getMessage().")\n";
		}
	}

	/********************************************************************************************/
	/*                                    REGISTRO NOTIFICACION                                 */
	/********************************************************************************************/
	//se verifica que al menos se le haya enviado algo al usuario
	if($CountSend!=0){

		//filtros
		if(isset($sis_idSistema) && $sis_idSistema!=''){       $SIS_data  = "'".$sis_idSistema."'";      }else{$SIS_data  = "''";}
		if(isset($sis_idUsuario) && $sis_idUsuario!=''){       $SIS_data .= ",'".$sis_idUsuario."'";     }else{$SIS_data .= ",''";}
		if(isset($sis_idCorreosCat) && $sis_idCorreosCat!=''){ $SIS_data .= ",'".$sis_idCorreosCat."'";  }else{$SIS_data .= ",''";}
		//El timestamp
		if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
			$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
		}else{
			$SIS_data .= ",''";
		}
		// inserto los datos de registro en la db
		$SIS_columns = 'idSistema, idUsuario, idCorreosCat, TimeStamp';
		$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_mnt_correos_list_sended', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'insertCorreoSended');

	}

}


/*********************************************************************/
//Se guarda el registro de los correos enviados
if ($FP = fopen ($TextFile_User, "a")){
	fwrite ($FP, $dir);
	fclose ($FP);
}

?>
