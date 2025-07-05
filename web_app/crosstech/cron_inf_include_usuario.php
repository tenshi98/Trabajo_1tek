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

	//Datos para guardar registro del envio de la notificacion
	$usuario_idUsuario = $usuarios;

	//Variables vacias
	$MSG_NC_AlertasCatastrofica     = '';//Notificación Correo - Alertas Catastroficas
	$MSG_NC_AlertasNormales         = '';//Notificación Correo - Alertas Normales
	$MSG_NC_FueraGeocerca           = '';//Notificación Correo - Equipo Fuera de Geocerca
	$MSG_NC_ExcesoVelocidad         = '';//Notificación Correo - Exceso Limite Velocidad
	$MSG_NC_FueraLinea              = '';//Notificación Correo - Fuera de Linea
	$MSG_NC_FueraLineaActual        = '';//Notificación Correo - Fuera de Linea Actual
	$MSG_NW_AlertasCatastrofica     = '';//Notificación Whatsapp - Alertas Catastroficas
	$MSG_NW_AlertasPersonalizadas   = '';//Notificación Whatsapp - Alertas Normales
	$MSG_NW_FueraGeocerca           = '';//Notificación Whatsapp - Equipo Fuera de Geocerca
	$MSG_NW_ExcesoVelocidad         = '';//Notificación Whatsapp - Exceso Limite Velocidad
	$MSG_NW_FueraLinea              = '';//Notificación Whatsapp - Fuera de Linea
	$MSG_NW_FueraLineaActual        = '';//Notificación Whatsapp - Fuera de Linea Actual

	$MSG_Whatsapp = $Message_Whatsapp ; //Se vacia el mensaje de whatsapp

	//Contadores
	$CountNotiNC = 0;
	$CountNotiNW = 0;
	$CountSend   = 0;

	//se recorren los correos del usuario
	foreach ($correos as $correo) {
		//obtengo los datos del usuario
		$usuarioNombre          = DeSanitizar($correo['UsuarioNombre']);   //Nombre del usuario
		$usuarioCorreo          = DeSanitizar($correo['UsuarioEmail']);    //Para el envio de correos
		$usuarioDispositivo     = $correo['UsuarioDispositivo'];           //Para el envio de notificaciones
		$usuarioGSM             = $correo['UsuarioGSM'];                   //Para el envio de notificaciones
		$usuarioFono            = $correo['UsuarioFono'];                  //Para el envio de whatsapp

		//obtengo los datos del sistema
		$SistemaNombre             = DeSanitizar($correo['SistemaNombre']); //Para el envio de correos
		$SistemaEmail              = $correo['SistemaEmail'];               //Para el envio de correos
		$SistemaGmailUsuario       = $correo['Gmail_Usuario'];              //Para el envio de correos
		$SistemaGmailPassword      = $correo['Gmail_Password'];             //Para el envio de correos
		$SistemaApiKey             = $correo['SistemaApiKey'];              //Para el envio de notificaciones
		$SistemaWhatsappToken      = $correo['SistemaWhatsappToken'];       //Para el envio de whatsapp
		$SistemaWhatsappInstance   = $correo['SistemaWhatsappInstanceId'];  //Para el envio de whatsapp
		$SistemaWhatsappChat_id    = $correo['SistemaWhatsappChat_id'];     //Para el envio de whatsapp

		//Datos para guardar registro del envio de la notificacion
		$usuario_idSistema          = $correo['idSistema'];
		$usuario_idCorreosCat       = $correo['idCorreosCat'];

		//se envian correos si aun no se han enviado dentro de los tiempos
		if(isset($correo['Counter_Normal'])&&$correo['Counter_Normal']!=''&&$correo['Counter_Normal']==0){

			//separo por categoria
			switch ($correo['idCorreosCat']) {

				/*******************            Correos            *******************/
				/*********************************************************************/
				//Alertas Personalizadas
				case $SubAlert_NC_AlertasNormales:
					if(isset($AlertasNormales[$correo['idTelemetria']])&&$AlertasNormales[$correo['idTelemetria']]!=''){
						$MSG_NC_AlertasNormales .= $AlertasNormales[$correo['idTelemetria']];
						$CountNotiNC++;
					}
					break;
				/*********************************************************************/
				//Exceso Limite Velocidad
				case $SubAlert_NC_ExcesoVelocidad:
					if(isset($AlertasVelocidad[$correo['idTelemetria']])&&$AlertasVelocidad[$correo['idTelemetria']]!=''){
						$MSG_NC_ExcesoVelocidad .= $AlertasVelocidad[$correo['idTelemetria']];
						$CountNotiNC++;
					}
					break;
				/*********************************************************************/
				//Equipo Fuera de Geocerca
				case $SubAlert_NC_FueraGeocerca:
					if(isset($FueraGeocerca[$correo['idTelemetria']])&&$FueraGeocerca[$correo['idTelemetria']]!=''){
						$MSG_NC_FueraGeocerca .= $FueraGeocerca[$correo['idTelemetria']];
						$CountNotiNC++;
					}
					break;
				/*********************************************************************/
				//Fuera de Linea
				case $SubAlert_NC_FueraLinea:
					if(isset($FueraLinea[$correo['idTelemetria']])&&$FueraLinea[$correo['idTelemetria']]!=''){
						$MSG_NC_FueraLinea .= $FueraLinea[$correo['idTelemetria']];
						$CountNotiNC++;
					}
					break;
				/*********************************************************************/
				//Fuera de Linea Actual
				case $SubAlert_NC_FueraLineaActual:
					if(isset($FueraLineaActual[$correo['idTelemetria']])&&$FueraLineaActual[$correo['idTelemetria']]!=''){
						$MSG_NC_FueraLineaActual .= $FueraLineaActual[$correo['idTelemetria']];
						$CountNotiNC++;
					}
					break;

				/*******************            Whatsapp           *******************/
				/*********************************************************************/
				//Alertas Personalizadas
				case $SubAlert_NW_AlertasNormales:
					if(isset($AlertasNormales_Whatsapp[$correo['idTelemetria']])&&$AlertasNormales_Whatsapp[$correo['idTelemetria']]!=''){
						$MSG_NW_AlertasPersonalizadas .= $AlertasNormales_Whatsapp[$correo['idTelemetria']];
						$CountNotiNW++;
					}
					break;
				/*********************************************************************/
				//Exceso Limite Velocidad
				case $SubAlert_NW_ExcesoVelocidad:
					if(isset($AlertasVelocidad_Whatsapp[$correo['idTelemetria']])&&$AlertasVelocidad_Whatsapp[$correo['idTelemetria']]!=''){
						$MSG_NW_ExcesoVelocidad .= $AlertasVelocidad_Whatsapp[$correo['idTelemetria']];
						$CountNotiNW++;
					}
					break;
				/*********************************************************************/
				//Equipo Fuera de Geocerca
				case $SubAlert_NW_FueraGeocerca:
					if(isset($FueraGeocerca_Whatsapp[$correo['idTelemetria']])&&$FueraGeocerca_Whatsapp[$correo['idTelemetria']]!=''){
						$MSG_NW_FueraGeocerca .= $FueraGeocerca_Whatsapp[$correo['idTelemetria']];
						$CountNotiNW++;
					}
					break;
				/*********************************************************************/
				//Fuera de Linea
				case $SubAlert_NW_FueraLinea:
					//Fuera de linea segun base de datos
					if(isset($FueraLinea_Whatsapp[$correo['idTelemetria']])&&$FueraLinea_Whatsapp[$correo['idTelemetria']]!=''){
						$MSG_NW_FueraLinea .= $FueraLinea_Whatsapp[$correo['idTelemetria']];
						$CountNotiNW++;
					}
					break;
				/*********************************************************************/
				//Fuera de Linea Actual
				case $SubAlert_NW_FueraLineaActual:
					//fuera de linea actual
					if(isset($FueraLineaActual_Whatsapp[$correo['idTelemetria']])&&$FueraLineaActual_Whatsapp[$correo['idTelemetria']]!=''){
						$MSG_NW_FueraLineaActual .= $FueraLineaActual_Whatsapp[$correo['idTelemetria']];
						$CountNotiNW++;
					}
					break;
			}

		}elseif(isset($correo['Counter_Critical'])&&$correo['Counter_Critical']!=''&&$correo['Counter_Critical']==0){
			//separo por categoria
			switch ($correo['idCorreosCat']) {
				/*********************************************************************/
				//Alerta Catastrofica
				case $SubAlert_NC_AlertasCatastrofica:
					if(isset($AlertasCatastroficas[$correo['idTelemetria']])&&$AlertasCatastroficas[$correo['idTelemetria']]!=''){
						$MSG_NC_AlertasCatastrofica .= $AlertasCatastroficas[$correo['idTelemetria']];
						$CountNotiNC++;
					}
					break;
				/*********************************************************************/
				//Alerta Catastrofica
				case $SubAlert_NW_AlertasCatastrofica:
					if(isset($AlertasCatastroficas_Whatsapp[$correo['idTelemetria']])&&$AlertasCatastroficas_Whatsapp[$correo['idTelemetria']]!=''){
						$MSG_NW_AlertasCatastrofica .= $AlertasCatastroficas_Whatsapp[$correo['idTelemetria']];
						$CountNotiNW++;
					}
					break;

			}
		}

	}

	/********************************************************************************************/
	/*                                        ENVIO DE CORREOS                                  */
	/********************************************************************************************/
	//Se verifica si existe correo
	if(isset($usuarioCorreo)&&$usuarioCorreo!=''&&$CountNotiNC!=0&&isset($SistemaEmail)&&$SistemaEmail!=''){

		/*******************************************************************/
		//Se le da una interfaz al mensaje
		$SubMensaje  = '
		<div style="background-color: #D9D9D9; padding: 10px;">
			<img src="http://clientes.simplytech.cl/img/login_logo.png" style="width: 30%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">
			<h3 style="text-align: center;font-size: 30px;">
				'.$Tittle_Body_Mail.'<br/>
				Desde '.$Fecha_real.' - '.$Hora_real.' Hasta '.fecha_estandar($FechaSistema).' - '.$HoraSistema.'
			</h3>
			<p style="text-align: center;font-size: 20px;">'.$usuarioNombre.'</p>';
		/**************************************/
		if($MSG_NC_AlertasCatastrofica!=''){
			$SubMensaje .= '
			<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
				<thead>
					<tr style="background-color: #8B00FF;color: #ffffff;text-align: left;">
						<th colspan="8" style="padding: 12px 15px;text-align:center;"><strong>Alertas Personalizadas</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background: #eee;">
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Sistema</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Nombre Equipo</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Descripcion</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Fecha</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Hora</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Valor</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Min</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Max</strong></td>
					</tr>';
			$SubMensaje .= $MSG_NC_AlertasCatastrofica;
			$SubMensaje .= '</tbody></table>';
			$SubMensaje .= '<br/><br/>';
		}
		/**************************************/
		if($MSG_NC_AlertasNormales!=''){
			$SubMensaje .= '
			<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
				<thead>
					<tr style="background-color: #8B00FF;color: #ffffff;text-align: left;">
						<th colspan="8" style="padding: 12px 15px;text-align:center;"><strong>Alertas Personalizadas</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background: #eee;">
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Sistema</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Nombre Equipo</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Descripcion</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Fecha</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Hora</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Valor</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Min</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Max</strong></td>
					</tr>';
			$SubMensaje .= $MSG_NC_AlertasNormales;
			$SubMensaje .= '</tbody></table>';
			$SubMensaje .= '<br/><br/>';
		}
		/**************************************/
		if($MSG_NC_ExcesoVelocidad!=''){
			$SubMensaje .= '
			<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
				<thead>
					<tr style="background-color: #8B00FF;color: #ffffff;text-align: left;">
						<th colspan="8" style="padding: 12px 15px;text-align:center;"><strong>Alertas de Velocidad</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background: #eee;">
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Sistema</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Nombre Equipo</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Descripcion</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Fecha</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Hora</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Valor</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Min</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Max</strong></td>
					</tr>';
			$SubMensaje .= $MSG_NC_ExcesoVelocidad;
			$SubMensaje .= '</tbody></table>';
			$SubMensaje .= '<br/><br/>';
		}
		/**************************************/
		if($MSG_NC_FueraGeocerca!=''){
			$SubMensaje .= '
			<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
				<thead>
					<tr style="background-color: #8B00FF;color: #ffffff;text-align: left;">
						<th colspan="5" style="padding: 12px 15px;text-align:center;"><strong>Fuera de Geocerca</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background: #eee;">
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Sistema</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Nombre Equipo</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Descripcion</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Fecha</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Hora</strong></td>
					</tr>';
			$SubMensaje .= $MSG_NC_FueraGeocerca;
			$SubMensaje .= '</tbody></table>';
			$SubMensaje .= '<br/><br/>';
		}
		/**************************************/
		if($MSG_NC_FueraLinea!=''){
			$SubMensaje .= '
			<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
				<thead>
					<tr style="background-color: #8B00FF;color: #ffffff;text-align: left;">
						<th colspan="7" style="padding: 12px 15px;text-align:center;"><strong>Fuera de Linea</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background: #eee;">
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Sistema</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Nombre Equipo</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Fecha Inicio</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Hora Inicio</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Fecha Termino</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Hora Termino</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Tiempo</strong></td>
					</tr>';
			$SubMensaje .= $MSG_NC_FueraLinea;
			$SubMensaje .= '</tbody></table>';
			$SubMensaje .= '<br/><br/>';
		}
		/**************************************/
		if($MSG_NC_FueraLineaActual!=''){
			$SubMensaje .= '
			<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
				<thead>
					<tr style="background-color: #8B00FF;color: #ffffff;text-align: left;">
						<th colspan="5" style="padding: 12px 15px;text-align:center;"><strong>Fuera de Linea Actual</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background: #eee;">
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Sistema</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Nombre Equipo</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Fecha Inicio</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Hora Inicio</strong></td>
						<td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Tiempo Transcurrido</strong></td>
					</tr>';
			$SubMensaje .= $MSG_NC_FueraLineaActual;
			$SubMensaje .= '</tbody></table>';
			$SubMensaje .= '<br/><br/>';
		}
		/**************************************/
		$SubMensaje .= '</div>';

		/*******************************************************************/
		//Envio de correo
		$rmail = tareas_envio_correo($SistemaEmail, $SistemaNombre,
									 $usuarioCorreo, $usuarioNombre,
									 '', '',
									 $Tittle_Mail,
									 $SubMensaje,'',
									 '',
									 2,
									 $SistemaGmailUsuario,
									 $SistemaGmailPassword);

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
	if($CountNotiNW!=0){
		//Verifico existencias
		if(isset($SistemaWhatsappToken)&&$SistemaWhatsappToken!=''&&isset($SistemaWhatsappInstance)&&$SistemaWhatsappInstance!=''&&isset($usuarioFono)&&$usuarioFono!=''){
			/**************************************/
			if($MSG_NW_AlertasCatastrofica!=''){
				$MSG_Whatsapp .= '<strong>Alertas Personalizadas:</strong><br/>';
				$MSG_Whatsapp .= $MSG_NW_AlertasCatastrofica;
				$MSG_Whatsapp .= '<br/><br/>';
			}
			/**************************************/
			if($MSG_NW_AlertasPersonalizadas!=''){
				$MSG_Whatsapp .= '<strong>Alertas Personalizadas:</strong><br/>';
				$MSG_Whatsapp .= $MSG_NW_AlertasPersonalizadas;
				$MSG_Whatsapp .= '<br/><br/>';
			}
			/**************************************/
			if($MSG_NW_ExcesoVelocidad!=''){
				$MSG_Whatsapp .= '<strong>Alertas de Velocidad:</strong><br/>';
				$MSG_Whatsapp .= $MSG_NW_ExcesoVelocidad;
				$MSG_Whatsapp .= '<br/><br/>';
			}
			/**************************************/
			if($MSG_NW_FueraGeocerca!=''){
				$MSG_Whatsapp .= '<strong>Fuera de Geocerca:</strong><br/>';
				$MSG_Whatsapp .= $MSG_NW_FueraGeocerca;
				$MSG_Whatsapp .= '<br/><br/>';
			}
			/**************************************/
			if($MSG_NW_FueraLinea!=''){
				$MSG_Whatsapp .= '<strong>Fuera de Linea:</strong><br/>';
				$MSG_Whatsapp .= $MSG_NW_FueraLinea;
				$MSG_Whatsapp .= '<br/><br/>';
			}
			/**************************************/
			if($MSG_NW_FueraLineaActual!=''){
				$MSG_Whatsapp .= '<strong>Fuera de Linea Actual:</strong><br/>';
				$MSG_Whatsapp .= $MSG_NW_FueraLineaActual;
				$MSG_Whatsapp .= '<br/><br/>';
			}

			//se intenta enviar la notificacion
			try {
				//envio notificacion
				WhatsappSendMessage($SistemaWhatsappToken, $SistemaWhatsappInstance, $usuarioFono, $MSG_Whatsapp);
				//guardo el registro de los mensajes enviados
				$dir .= "	- NW/".$SistemaNombre.": ".$usuarioCorreo." / (Envio Correcto->".$usuarioFono.")\n";
				//contador del envio correcto
				$CountSend++;
			} catch (Exception $e) {
				$dir .= "	- NW/Excepción capturada: / (Envio Noti Whatsapp Fallido->".$e->getMessage().")\n";
			}
		}
	}

	/********************************************************************************************/
	/*                                    REGISTRO NOTIFICACION                                 */
	/********************************************************************************************/
	//se verifica que al menos se le haya enviado algo al usuario
	if($CountSend!=0){

		//filtros
		if(isset($usuario_idSistema) && $usuario_idSistema!=''){       $SIS_data  = "'".$usuario_idSistema."'";      }else{$SIS_data  = "''";}
		if(isset($usuario_idUsuario) && $usuario_idUsuario!=''){       $SIS_data .= ",'".$usuario_idUsuario."'";     }else{$SIS_data .= ",''";}
		if(isset($usuario_idCorreosCat) && $usuario_idCorreosCat!=''){ $SIS_data .= ",'".$usuario_idCorreosCat."'";  }else{$SIS_data .= ",''";}
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
