<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                             CREACION Y ENVIO DE CORREOS A LOS ADMINISTRADORES                      */
/*                                                                                                    */
/******************************************************************************************************/
//Tivo de envio
switch ($TipoEnvio) {
    /*********************************/
    //Solo Email
    case 1:
        //Reseteo de variable
		$dir = "\n
		################################################################################
		Fecha de envio : ".$FechaSistema."
		Hora Actual : ".$HoraSistema."
		Usuarios :\n";
		/*********************************************************************************************/
		/*                       SE ENVIA CORREO Y SE DEJA REGISTRO DEL ENVIO                        */
		/*********************************************************************************************/
		//Se verifica si existe algo que enviar
		//envio de correo
		try {

			/*********************************************************/
			//Se configura el titulo del correo
			$EmailTitulo = 'Correo de Alarmas';

			//Se crea el cuerpo
			$EmailCuerpo  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$EmailCuerpo .= '<h3 style="text-align: center;font-size: 30px;">';
			$EmailCuerpo .= 'Informe alertas por equipo<br/>';
			$EmailCuerpo .= '</h3>';
			$EmailCuerpo .= '<p style="text-align: center;font-size: 20px;">';
			$EmailCuerpo .= 'Para descargar el informe presiona el boton descargar';
			$EmailCuerpo .= '</p>';
			$EmailCuerpo .= '<a href="https://clientes.simplytech.cl/informe_administrador_07_to_excel.php?f_inicio='.$FechaInicio.'&h_inicio='.$HoraInicio.'&f_termino='.$FechaTermino.'&h_termino='.$HoraTermino.'&idSistema=1&idTipoUsuario=1&submit_filter=Filtrar" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Descargar &#8594;</strong></a>';
			$EmailCuerpo .= '</div>';

			foreach ($arrMail as $e_mail) {
				//Se verifica que correo exista
				if(isset($e_mail)&&$e_mail!=''&&isset($rowSistema['email_principal'])&&$rowSistema['email_principal']!=''){
					/*********************************************************************/
					//Envio de correo
					$rmail = tareas_envio_correo($rowSistema['email_principal'], $rowSistema['RazonSocial'],
												 $e_mail, 'Correo de Alarmas',
												 '', '',
												 $EmailTitulo,
												 $EmailCuerpo,'',
												 '',
												 2,
												 $rowSistema['Gmail_Usuario'],
												 $rowSistema['Gmail_Password']);

					//Envio del mensaje
					if ($rmail!=1) {
						$dir .= "	- ".$e_mail." / (Envio Fallido->".$rmail.")\n";
					} else {
						$dir .= "	- ".$e_mail." / (Envio Correcto)\n";
					}
				}
			}
			/*********************************************************************/
			//Se guarda el registro de los correos enviados
			if ($FP = fopen ($TextFile, "a")){
				fwrite ($FP, $dir);
				fclose ($FP);
			}


		} catch (Exception $e) {
			php_error_log('Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron', '', 'error de registro:'.$e->getMessage(), '' );

		}
        break;
	/*********************************/
    //Solo Whatsapp (Full text)
    case 2:

		//Variables
		$WhatsappToken       = $rowSistema['SistemaWhatsappToken'];
		$WhatsappInstanceId  = $rowSistema['SistemaWhatsappInstanceId'];
		$WhatsappChat_id     = $WhatsappIdAdmin;


		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos con error 99900:<br/>';
		foreach ($arrEquipos1 as $equip) {
			if(isset($equip['Valor'])&&$equip['Valor']==99900){
				$Message_Whatsapp .= 'Sistema/Equipo/Id Telemetria/Tab/Grupo/Numero Sensor/Nombre Sensor/Numero Alertas/Descripcion<br/>';
				$Message_Whatsapp .= $equip['Sistema'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['EquipoNombre']);
				$Message_Whatsapp .= '/'.$equip['EquipoId'];
				$Message_Whatsapp .= '/'.$equip['EquipoTab'];
				$Message_Whatsapp .= '/'.$arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]];
				$Message_Whatsapp .= '/'.$equip['EquipoNSensor'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['SensoresNombre_'.$equip['EquipoNSensor']]);
				$Message_Whatsapp .= '/'.$equip['Cuenta'];
				$Message_Whatsapp .= '/'.$equip['Descripcion'];
				$Message_Whatsapp .= '<br/>';
			}
		}
		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos con error 99901:<br/>';
		foreach ($arrEquipos1 as $equip) {
			if(isset($equip['Valor'])&&$equip['Valor']==99901){
				$Message_Whatsapp .= 'Sistema/Equipo/Id Telemetria/Tab/Grupo/Numero Sensor/Nombre Sensor/Numero Alertas/Descripcion<br/>';
				$Message_Whatsapp .= $equip['Sistema'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['EquipoNombre']);
				$Message_Whatsapp .= '/'.$equip['EquipoId'];
				$Message_Whatsapp .= '/'.$equip['EquipoTab'];
				$Message_Whatsapp .= '/'.$arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]];
				$Message_Whatsapp .= '/'.$equip['EquipoNSensor'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['SensoresNombre_'.$equip['EquipoNSensor']]);
				$Message_Whatsapp .= '/'.$equip['Cuenta'];
				$Message_Whatsapp .= '/'.$equip['Descripcion'];
				$Message_Whatsapp .= '<br/>';
			}
		}
		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos Fuera de Linea:<br/>';
		foreach ($arrErrores as $error) {
			$Message_Whatsapp .= 'Sistema/Equipo/Tab/Fecha Inicio/Hora Inicio/Fecha Termino/Hora Termino/Tiempo<br/>';
			$Message_Whatsapp .= $error['Sistema'];
			$Message_Whatsapp .= '/'.DeSanitizar($error['EquipoNombre']);
			$Message_Whatsapp .= '/'.$error['EquipoTab'];
			$Message_Whatsapp .= '/'.$error['Fecha_inicio'];
			$Message_Whatsapp .= '/'.$error['Hora_inicio'];
			$Message_Whatsapp .= '/'.$error['Fecha_termino'];
			$Message_Whatsapp .= '/'.$error['Hora_termino'];
			$Message_Whatsapp .= '/'.$error['Tiempo'];
			$Message_Whatsapp .= '<br/>';
		}
		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos Fuera de Linea Actual:<br/>';
		foreach ($arrTelemetria as $tel) {
			//Verifico la resta de la hora de la ulima actualizacion contra  la hora actual
			$diaInicio   = $tel['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $tel['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($tel['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$Message_Whatsapp .= 'Sistema/Equipo/Tab/Fecha Inicio/Hora Inicio/Tiempo Actual<br/>';
				$Message_Whatsapp .= $tel['Sistema'];
				$Message_Whatsapp .= '/'.DeSanitizar($tel['EquipoNombre']);
				$Message_Whatsapp .= '/'.$tel['EquipoTab'];
				$Message_Whatsapp .= '/'.$tel['LastUpdateFecha'];
				$Message_Whatsapp .= '/'.$tel['LastUpdateHora'];
				$Message_Whatsapp .= '/'.$Tiempo;
				$Message_Whatsapp .= '<br/>';
			}
		}

		/*****************************************************************************/
		//envio notificacion
		foreach ($arrPhone as $phone) {
			if(isset($phone)&&$phone!=''){
				//Se genera cuerpo
				$Body['Phone']  = $phone;
				$Body['Cuerpo'] = $Message_Whatsapp;
				//Se envia whatsapp
				$whatsappResult = WhatsappSendTemplate($WhatsappToken, $WhatsappInstanceId, 1, $Body);
				//transformo a objeto
				$whatsappRes = json_decode($whatsappResult);
				//Si es el resultado esperado
				if($whatsappRes->sent === true){
					//Se guarda el log
					//error_log("Alertas Administrativas: ".$phone." / (Envio Correcto)", 0);
				}else{
					//Se guarda el log
					error_log("Alertas Administrativas: ".$phone." / (Envio Fallido->".$whatsappResult.")", 0);
				}
			}
		}

        break;
    /*********************************/
    //Ambos  (Whatsapp Full text)
    case 3:
        //Reseteo de variable
		$dir = "\n
		################################################################################
		Fecha de envio : ".$FechaSistema."
		Hora Actual : ".$HoraSistema."
		Usuarios :\n";
		/*********************************************************************************************/
		/*                       SE ENVIA CORREO Y SE DEJA REGISTRO DEL ENVIO                        */
		/*********************************************************************************************/
		//Se verifica si existe algo que enviar
		//envio de correo
		try {

			/*********************************************************/
			//Se configura el titulo del correo
			$EmailTitulo = 'Correo de Alarmas';

			//Se crea el cuerpo
			$EmailCuerpo  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$EmailCuerpo .= '<h3 style="text-align: center;font-size: 30px;">';
			$EmailCuerpo .= 'Informe alertas por equipo<br/>';
			$EmailCuerpo .= '</h3>';
			$EmailCuerpo .= '<p style="text-align: center;font-size: 20px;">';
			$EmailCuerpo .= 'Para descargar el informe presiona el boton descargar';
			$EmailCuerpo .= '</p>';
			$EmailCuerpo .= '<a href="https://clientes.simplytech.cl/informe_administrador_07_to_excel.php?f_inicio='.$FechaInicio.'&h_inicio='.$HoraInicio.'&f_termino='.$FechaTermino.'&h_termino='.$HoraTermino.'&idSistema=1&idTipoUsuario=1&submit_filter=Filtrar" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Descargar &#8594;</strong></a>';
			$EmailCuerpo .= '</div>';

			foreach ($arrMail as $e_mail) {
				//Se verifica que correo exista
				if(isset($e_mail)&&$e_mail!=''&&isset($rowSistema['email_principal'])&&$rowSistema['email_principal']!=''){
					/*********************************************************************/
					//Envio de correo
					$rmail = tareas_envio_correo($rowSistema['email_principal'], $rowSistema['RazonSocial'],
												 $e_mail, 'Correo de Alarmas',
												 '', '',
												 $EmailTitulo,
												 $EmailCuerpo,'',
												 '',
												 2,
												 $rowSistema['Gmail_Usuario'],
												 $rowSistema['Gmail_Password']);

					//Envio del mensaje
					if ($rmail!=1) {
						$dir .= "	- ".$e_mail." / (Envio Fallido->".$rmail.")\n";
					} else {
						$dir .= "	- ".$e_mail." / (Envio Correcto)\n";
					}
				}
			}
			/*********************************************************************/
			//Se guarda el registro de los correos enviados
			if ($FP = fopen ($TextFile, "a")){
				fwrite ($FP, $dir);
				fclose ($FP);
			}


		} catch (Exception $e) {
			php_error_log('Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron', '', 'error de registro:'.$e->getMessage(), '' );

		}

		//Variables
		$WhatsappToken       = $rowSistema['SistemaWhatsappToken'];
		$WhatsappInstanceId  = $rowSistema['SistemaWhatsappInstanceId'];
		$WhatsappChat_id     = $WhatsappIdAdmin;

		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos con error 99900:<br/>';
		foreach ($arrEquipos1 as $equip) {
			if(isset($equip['Valor'])&&$equip['Valor']==99900){
				$Message_Whatsapp .= 'Sistema/Equipo/Id Telemetria/Tab/Grupo/Numero Sensor/Nombre Sensor/Numero Alertas/Descripcion<br/>';
				$Message_Whatsapp .= $equip['Sistema'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['EquipoNombre']);
				$Message_Whatsapp .= '/'.$equip['EquipoId'];
				$Message_Whatsapp .= '/'.$equip['EquipoTab'];
				$Message_Whatsapp .= '/'.$arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]];
				$Message_Whatsapp .= '/'.$equip['EquipoNSensor'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['SensoresNombre_'.$equip['EquipoNSensor']]);
				$Message_Whatsapp .= '/'.$equip['Cuenta'];
				$Message_Whatsapp .= '/'.$equip['Descripcion'];
				$Message_Whatsapp .= '<br/>';
			}
		}
		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos con error 99901:<br/>';
		foreach ($arrEquipos1 as $equip) {
			if(isset($equip['Valor'])&&$equip['Valor']==99901){
				$Message_Whatsapp .= 'Sistema/Equipo/Id Telemetria/Tab/Grupo/Numero Sensor/Nombre Sensor/Numero Alertas/Descripcion<br/>';
				$Message_Whatsapp .= $equip['Sistema'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['EquipoNombre']);
				$Message_Whatsapp .= '/'.$equip['EquipoId'];
				$Message_Whatsapp .= '/'.$equip['EquipoTab'];
				$Message_Whatsapp .= '/'.$arrFinalGrupos[$equip['SensoresGrupo_'.$equip['EquipoNSensor']]];
				$Message_Whatsapp .= '/'.$equip['EquipoNSensor'];
				$Message_Whatsapp .= '/'.DeSanitizar($equip['SensoresNombre_'.$equip['EquipoNSensor']]);
				$Message_Whatsapp .= '/'.$equip['Cuenta'];
				$Message_Whatsapp .= '/'.$equip['Descripcion'];
				$Message_Whatsapp .= '<br/>';
			}
		}
		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos Fuera de Linea:<br/>';
		foreach ($arrErrores as $error) {
			$Message_Whatsapp .= 'Sistema/Equipo/Tab/Fecha Inicio/Hora Inicio/Fecha Termino/Hora Termino/Tiempo<br/>';
			$Message_Whatsapp .= $error['Sistema'];
			$Message_Whatsapp .= '/'.DeSanitizar($error['EquipoNombre']);
			$Message_Whatsapp .= '/'.$error['EquipoTab'];
			$Message_Whatsapp .= '/'.$error['Fecha_inicio'];
			$Message_Whatsapp .= '/'.$error['Hora_inicio'];
			$Message_Whatsapp .= '/'.$error['Fecha_termino'];
			$Message_Whatsapp .= '/'.$error['Hora_termino'];
			$Message_Whatsapp .= '/'.$error['Tiempo'];
			$Message_Whatsapp .= '<br/>';
		}
		/*****************************************************************************/
		$Message_Whatsapp .= 'Equipos Fuera de Linea Actual:<br/>';
		foreach ($arrTelemetria as $tel) {
			//Verifico la resta de la hora de la ulima actualizacion contra  la hora actual
			$diaInicio   = $tel['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $tel['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($tel['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$Message_Whatsapp .= 'Sistema/Equipo/Tab/Fecha Inicio/Hora Inicio/Tiempo Actual<br/>';
				$Message_Whatsapp .= $tel['Sistema'];
				$Message_Whatsapp .= '/'.DeSanitizar($tel['EquipoNombre']);
				$Message_Whatsapp .= '/'.$tel['EquipoTab'];
				$Message_Whatsapp .= '/'.$tel['LastUpdateFecha'];
				$Message_Whatsapp .= '/'.$tel['LastUpdateHora'];
				$Message_Whatsapp .= '/'.$Tiempo;
				$Message_Whatsapp .= '<br/>';
			}
		}

		/*****************************************************************************/
		//envio notificacion
		foreach ($arrPhone as $phone) {
			if(isset($phone)&&$phone!=''){
				//Se genera cuerpo
				$Body['Phone']  = $phone;
				$Body['Cuerpo'] = $Message_Whatsapp;
				//Se envia whatsapp
				$whatsappResult = WhatsappSendTemplate($WhatsappToken, $WhatsappInstanceId, 1, $Body);
				//transformo a objeto
				$whatsappRes = json_decode($whatsappResult);
				//Si es el resultado esperado
				if($whatsappRes->sent === true){
					//Se guarda el log
					//error_log("Alertas Administrativas: ".$phone." / (Envio Correcto)", 0);
				}else{
					//Se guarda el log
					error_log("Alertas Administrativas: ".$phone." / (Envio Fallido->".$whatsappResult.")", 0);
				}
			}
		}

        break;
	/*********************************/
    //Solo Whatsapp (Enlace Archivo)
    case 4:

		//Variables
		$WhatsappToken       = $rowSistema['SistemaWhatsappToken'];
		$WhatsappInstanceId  = $rowSistema['SistemaWhatsappInstanceId'];
		$WhatsappChat_id     = $WhatsappIdAdmin;

		//Definicion del cuerpo
		$Message_Whatsapp .= '<br/>';
		$Message_Whatsapp .= 'https://clientes.simplytech.cl/informe_administrador_07_to_excel.php?f_inicio='.$FechaInicio.'&h_inicio='.$HoraInicio.'&f_termino='.$FechaTermino.'&h_termino='.$HoraTermino.'&idSistema=1&idTipoUsuario=1&submit_filter=Filtrar';

		/*****************************************************************************/
		//envio notificacion
		foreach ($arrPhone as $phone) {
			if(isset($phone)&&$phone!=''){
				//Se genera cuerpo
				$Body['Phone']  = $phone;
				$Body['Cuerpo'] = $Message_Whatsapp;
				//Se envia whatsapp
				$whatsappResult = WhatsappSendTemplate($WhatsappToken, $WhatsappInstanceId, 1, $Body);
				//transformo a objeto
				$whatsappRes = json_decode($whatsappResult);
				//Si es el resultado esperado
				if($whatsappRes->sent === true){
					//Se guarda el log
					//error_log("Alertas Administrativas: ".$phone." / (Envio Correcto)", 0);
				}else{
					//Se guarda el log
					error_log("Alertas Administrativas: ".$phone." / (Envio Fallido->".$whatsappResult.")", 0);
				}
			}
		}

        break;
    /*********************************/
    //Ambos  (Whatsapp Full text)
    case 5:
        //Reseteo de variable
		$dir = "\n
		################################################################################
		Fecha de envio : ".$FechaSistema."
		Hora Actual : ".$HoraSistema."
		Usuarios :\n";
		/*********************************************************************************************/
		/*                       SE ENVIA CORREO Y SE DEJA REGISTRO DEL ENVIO                        */
		/*********************************************************************************************/
		//Se verifica si existe algo que enviar
		//envio de correo
		try {

			/*********************************************************/
			//Se configura el titulo del correo
			$EmailTitulo = 'Correo de Alarmas';

			//Se crea el cuerpo
			$EmailCuerpo  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$EmailCuerpo .= '<h3 style="text-align: center;font-size: 30px;">';
			$EmailCuerpo .= 'Informe alertas por equipo<br/>';
			$EmailCuerpo .= '</h3>';
			$EmailCuerpo .= '<p style="text-align: center;font-size: 20px;">';
			$EmailCuerpo .= 'Para descargar el informe presiona el boton descargar';
			$EmailCuerpo .= '</p>';
			$EmailCuerpo .= '<a href="https://clientes.simplytech.cl/informe_administrador_07_to_excel.php?f_inicio='.$FechaInicio.'&h_inicio='.$HoraInicio.'&f_termino='.$FechaTermino.'&h_termino='.$HoraTermino.'&idSistema=1&idTipoUsuario=1&submit_filter=Filtrar" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Descargar &#8594;</strong></a>';
			$EmailCuerpo .= '</div>';

			foreach ($arrMail as $e_mail) {
				//Se verifica que correo exista
				if(isset($e_mail)&&$e_mail!=''&&isset($rowSistema['email_principal'])&&$rowSistema['email_principal']!=''){
					/*********************************************************************/
					//Envio de correo
					$rmail = tareas_envio_correo($rowSistema['email_principal'], $rowSistema['RazonSocial'],
												 $e_mail, 'Correo de Alarmas',
												 '', '',
												 $EmailTitulo,
												 $EmailCuerpo,'',
												 '',
												 2,
												 $rowSistema['Gmail_Usuario'],
												 $rowSistema['Gmail_Password']);

					//Envio del mensaje
					if ($rmail!=1) {
						$dir .= "	- ".$e_mail." / (Envio Fallido->".$rmail.")\n";
					} else {
						$dir .= "	- ".$e_mail." / (Envio Correcto)\n";
					}
				}
			}
			/*********************************************************************/
			//Se guarda el registro de los correos enviados
			if ($FP = fopen ($TextFile, "a")){
				fwrite ($FP, $dir);
				fclose ($FP);
			}


		} catch (Exception $e) {
			php_error_log('Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron', '', 'error de registro:'.$e->getMessage(), '' );

		}

		//Variables
		$WhatsappToken       = $rowSistema['SistemaWhatsappToken'];
		$WhatsappInstanceId  = $rowSistema['SistemaWhatsappInstanceId'];
		$WhatsappChat_id     = $WhatsappIdAdmin;

		//Definicion del cuerpo
		$Message_Whatsapp .= '<br/>';
		$Message_Whatsapp .= 'https://clientes.simplytech.cl/informe_administrador_07_to_excel.php?f_inicio='.$FechaInicio.'&h_inicio='.$HoraInicio.'&f_termino='.$FechaTermino.'&h_termino='.$HoraTermino.'&idSistema=1&idTipoUsuario=1&submit_filter=Filtrar';

		/*****************************************************************************/
		//envio notificacion
		foreach ($arrPhone as $phone) {
			if(isset($phone)&&$phone!=''){
				//Se genera cuerpo
				$Body['Phone']  = $phone;
				$Body['Cuerpo'] = $Message_Whatsapp;
				//Se envia whatsapp
				$whatsappResult = WhatsappSendTemplate($WhatsappToken, $WhatsappInstanceId, 1, $Body);
				//transformo a objeto
				$whatsappRes = json_decode($whatsappResult);
				//Si es el resultado esperado
				if($whatsappRes->sent === true){
					//Se guarda el log
					//error_log("Alertas Administrativas: ".$phone." / (Envio Correcto)", 0);
				}else{
					//Se guarda el log
					error_log("Alertas Administrativas: ".$phone." / (Envio Fallido->".$whatsappResult.")", 0);
				}
			}
		}

        break;

}





?>
