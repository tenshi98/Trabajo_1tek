<?php
//Variables
$MSGDir = '';
//recorro
foreach ($arrPrevs as $key => $value) {

	/*******************************************/
	//Se arma la consulta
	$SIS_query = 'idTabla, idTelemetria';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idTabla DESC LIMIT '.$value['NPrediccion'];
	//Recorro los sensores
    foreach ($value['Sensores'] as $sen) {
		$SIS_query .= ',Sensor_'.$sen;
    }

	//consulto
	$arrPrevision = array();
	$arrPrevision = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$value['EquipoID'], $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

	//Ordeno del mayor al menor
	sort($arrPrevision);

	//Variables
	$arrContador     = array();
	$arrTemperatura  = array();
	$counterEquip    = 0;
	$Prediccion      = 0;

	/*******************************************/
	if($arrPrevision!=false){
		/*******************************************/
		//recorro
		foreach ($arrPrevision as $prev) {
			$sSuma  = 0;
			$sCount = 0;
			$sProm  = 0;
			//recorro los sensores
			foreach ($value['Sensores'] as $sen) {
				//mientras sea inferior al error
				if(isset($prev['Sensor_'.$sen])&&$prev['Sensor_'.$sen]<999){
					$sSuma  = $sSuma + $prev['Sensor_'.$sen];
					$sCount++;
				}
			}
			//verifico si hay datos
			if($sCount!=0){
				$sProm  = $sSuma/$sCount;//obtengo promedio
			}
			//calculos
			$arrContador[$counterEquip][0]   = $counterEquip;
			$arrTemperatura[$counterEquip]   = cantidades_google(cantidades($sProm, 2));
			$counterEquip++;
		}

		/*******************************************/
		//Si hay datos
		if(isset($arrTemperatura)&&isset($arrContador)&&$counterEquip>1){
			$regression = new Phpml\Regression\LeastSquares();
			$regression->train($arrContador, $arrTemperatura);
			$Prediccion = $regression->predict([$value['NPrediccion']]);
		}

		/*******************************************/
		//cadena
		$SIS_data  = "'".$value['EquipoID']."'";
		$SIS_data .= ",'".$FechaSistema."'";
		$SIS_data .= ",'".$HoraSistema."'";
		$SIS_data .= ",'".$value['NPrediccion']."'";
		$SIS_data .= ",'".$Prediccion."'";

		// inserto los datos de registro en la db
		$SIS_columns = 'idTelemetria, FechaSistema, HoraSistema, NPrediccion, Prediccion';
		$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_prevision', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

		/*******************************************/
		//si hay alertas
		//Si es inferior al rango inicio o superior a este
		if($Prediccion<$value['RangoInicio'] OR $Prediccion>$value['RangoTermino']){
			//se filtra por usuario
			filtrar($arrCorreos, 'idUsuario');
			//se recorren correos
			foreach($arrCorreos as $usuarios=>$correos){
				//Datos para guardar registro del envio de la notificacion
				$usuario_idUsuario = $usuarios;
				//se recorren los correos del usuario
				foreach ($correos as $correo) {
					//Si el equipo pertenece
					if(isset($value['EquipoID'], $correo['idTelemetria'])&&$value['EquipoID']==$correo['idTelemetria']){
						/*******************************************/
						//obtengo los datos del usuario
						$usuarioNombre          = DeSanitizar($correo['UsuarioNombre']);   //Nombre del usuario
						$usuarioCorreo          = DeSanitizar($correo['UsuarioEmail']);    //Para el envio de correos
						$usuarioFono            = $correo['UsuarioFono'];                  //Para el envio de whatsapp

						//obtengo los datos del sistema
						$SistemaNombre             = DeSanitizar($correo['SistemaNombre']); //Para el envio de correos
						$SistemaWhatsappToken      = $correo['SistemaWhatsappToken'];       //Para el envio de whatsapp
						$SistemaWhatsappInstance   = $correo['SistemaWhatsappInstanceId'];  //Para el envio de whatsapp

						//Datos para guardar registro del envio de la notificacion
						$usuario_idSistema          = $correo['idSistema'];
						$usuario_idCorreosCat       = $correo['idCorreosCat'];

						/*******************************************/
						//se crea cuerpo de whatsapp
						$MSG_Whatsapp = 'La temperatura proyectada para '.DeSanitizar($correo['EquipoNombre']);
						$MSG_Whatsapp.= ' a las '.$HoraProyectada.' hrs esta fuera de rango (rango '.$value['RangoInicio'].' °C. - '.$value['RangoTermino'].' °C.)';
						$MSG_Whatsapp.= ' con una proyeccion de '.Cantidades($Prediccion, 2).' °C.';

						/*******************************************/
						//se intenta enviar la notificacion
						try {
							//Se arma cuerpo del mensaje
							$Body['Phone']  = $usuarioFono;
							$Body['Cuerpo'] = $MSG_Whatsapp;
							//envio notificacion
							$whatsappResult = WhatsappSendTemplate($SistemaWhatsappToken, $SistemaWhatsappInstance, 1, $Body);
							//transformo a objeto
							$whatsappRes = json_decode($whatsappResult);
							//Si es el resultado esperado
							if($whatsappRes->sent === true){
								//guardo el registro de los mensajes enviados
								$MSGDir .= "	- NW/".$SistemaNombre.": ".$usuarioFono." (".$usuarioCorreo.") / (Envio Correcto)\n";
								//envio correcto
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
							}else{
								//guardo el registro de los mensajes enviados
								$MSGDir .= "	- NW/".$SistemaNombre.": ".$usuarioFono." (".$usuarioCorreo.") / (Envio Fallido->".$whatsappResult.")\n";
							}
						} catch (Exception $e) {
							$MSGDir .= "	- NW/Excepción capturada: / (Envio Noti Whatsapp Fallido->".$e->getMessage().")\n";
						}
					}
				}
			}
		}
	}
}



if($MSGDir!=''){
//Variable para el registro de correos enviados
$dir = "\n
################################################################################
Fecha de envio : ".$FechaSistema."
Hora Actual : ".$HoraSistema."
Usuarios :\n";
$dir .= $MSGDir;

	//Se guarda el registro de los correos enviados
	if ($FP = fopen ('logs_cron_informe_proyecciones.txt', "a")){
		fwrite ($FP, $dir);
		fclose ($FP);
	}
}


?>
