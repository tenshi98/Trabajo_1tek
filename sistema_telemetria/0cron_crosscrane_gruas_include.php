<?php
//solo si existe
if (file_exists($file_logo)){

	//envio de correo
	try {
		
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){

				//Obtencion de datos del sistema
			$rowSistema = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = "'.$idSistema.'"', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');
	
			/*******************************************************/
			//Se buscan los correos para enviar la alerta
			$SIS_query = '
			telemetria_mnt_correos_list.idUsuario,
										
			usuarios_listado.email AS UsuarioEmail,
			usuarios_listado.dispositivo AS UsuarioDispositivo,
			usuarios_listado.GSM AS UsuarioGSM,

			core_sistemas.Nombre AS SistemaNombre,
			core_sistemas.email_principal AS SistemaEmail, 
			core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
			core_sistemas.Config_Gmail_Password AS Gmail_Password, 
			core_sistemas.Config_FCM_Main_apiKey AS SistemaApiKey';
			$SIS_join  = '
			INNER JOIN `usuarios_listado`    ON usuarios_listado.idUsuario   = telemetria_mnt_correos_list.idUsuario
			LEFT JOIN `core_sistemas`        ON core_sistemas.idSistema      = telemetria_mnt_correos_list.idSistema';
			$SIS_where = 'telemetria_mnt_correos_list.idSistema='.$idSistema.'
			AND telemetria_mnt_correos_list.idCorreosCat=31
			AND (telemetria_mnt_correos_list.TimeStamp<"'.$FechaSistema.' '.$HoraSistema.'" OR telemetria_mnt_correos_list.TimeStamp="0000-00-00 00:00:00")';
			$SIS_order = 0;
			$arrCorreos = array();
			$arrCorreos = db_select_array (false, $SIS_query, 'telemetria_mnt_correos_list', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

			/*********************************************************/
			//Se configura el titulo del correo
			$EmailTitulo = 'Informe alertas por equipo de '.$rowSistema['Nombre'];

			//Se crea el cuerpo
			$EmailCuerpo  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$EmailCuerpo .= '<img src="'.$login_logo.'" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
			$EmailCuerpo .= '<h3 style="text-align: center;font-size: 30px;">';
			$EmailCuerpo .= 'Informe alertas por equipo de <strong>'.$rowSistema['Nombre'].'</strong>!<br/>';
			$EmailCuerpo .= '</h3>';
			$EmailCuerpo .= '<p style="text-align: center;font-size: 20px;">';
			$EmailCuerpo .= 'Para descargar el informe presiona el boton descargar';
			$EmailCuerpo .= '</p>';
			$EmailCuerpo .= '<a href="'.DB_SITE_MAIN.'/informe_cross_crane_01_to_excel.php?bla=bla&f_inicio='.$Curso_FechaInicio.'&h_inicio='.$Curso_HoraInicio.'&f_termino='.$Curso_FechaTermino.'&h_termino='.$Curso_HoraTermino.'&idSistema='.$idSistema.'" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Descargar &#8594;</strong></a>';
			$EmailCuerpo .= '</div>';

			/*********************************************************/
			//notificacion
			$idUsuario  = 3;//el administrador
			$NotiTitulo = $EmailTitulo;
			$NotiCuerpo = '<p>Informe alertas por equipo de <strong>'.$rowSistema['Nombre'].'</p>';
			$NoMolestar = 1;//Se activa para mostrar la opción
					
			/*************************************************************/
			//Se buscan los correos para enviar la alerta
			if(isset($idSistema) && $idSistema!=''){         $a  = "'".$idSistema."'";        }else{$a  = "''";}
			if(isset($idUsuario) && $idUsuario!=''){        $a .= ",'".$idUsuario."'";       }else{$a .= ",''";}
			if(isset($NotiTitulo) && $NotiTitulo!=''){       $a .= ",'".$NotiTitulo."'";      }else{$a .= ",''";}
			if(isset($NotiCuerpo) && $NotiCuerpo!=''){       $a .= ",'".$NotiCuerpo."'";      }else{$a .= ",''";}
			if(isset($FechaSistema) && $FechaSistema!=''){   $a .= ",'".$FechaSistema."'";    }else{$a .= ",''";}
			if(isset($NoMolestar) && $NoMolestar!=''){       $a .= ",'".$NoMolestar."'";      }else{$a .= ",''";}
							
			// inserto los datos de registro en la db
			$query  = "INSERT INTO `principal_notificaciones_listado` (idSistema,idUsuario,Titulo,Notificacion,Fecha, NoMolestar) 
			VALUES (".$a.")";
			//Consulta
			$resultado = mysqli_query ($dbConn, $query);
			//Si ejecuto correctamente la consulta
			if(!$resultado){
									
				//variables
				$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

				//generar log
				php_error_log('Cron', $Transaccion, 'cron', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
								
			}
					
			//recibo el último id generado por mi sesion
			$ultimo_id = mysqli_insert_id($dbConn);

			/*********************************************************************/
			//recorro los correos
			foreach ($arrCorreos as $correo) {
				/***************************/
				//variables para armar el mensaje
				$Notificacion  = '<div class="btn-group" ><a href="view_notificacion.php?view='.simpleEncode($ultimo_id, '123333').'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div>';
				$Notificacion .= ' '.$NotiTitulo;
				$Estado        = '1';
				$idUsrReceptor = $correo['idUsuario'];
										
				if(isset($idSistema) && $idSistema!=''){            $a  = "'".$idSistema."'";          }else{$a  ="''";}
				if(isset($idUsrReceptor) && $idUsrReceptor!=''){    $a .= ",'".$idUsrReceptor."'";     }else{$a .=",''";}
				if(isset($Notificacion) && $Notificacion!=''){      $a .= ",'".$Notificacion."'";      }else{$a .=",''";}
				if(isset($FechaSistema) && $FechaSistema!=''){      $a .= ",'".$FechaSistema."'";      }else{$a .=",''";}
				if(isset($Estado) && $Estado!=''){                  $a .= ",'".$Estado."'";            }else{$a .=",''";}
				if(isset($ultimo_id) && $ultimo_id!=''){            $a .= ",'".$ultimo_id."'";         }else{$a .=",''";}
											
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `principal_notificaciones_ver` (idSistema,idUsuario,Notificacion, Fecha, idEstado, idNotificaciones) VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if(!$resultado){
												
					//variables
					$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

					//generar log
					php_error_log('Cron', $Transaccion, 'cron', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
									
				}
				/***************************/
				//Envio de correo
				$rmail = tareas_envio_correo($correo['SistemaEmail'], $correo['SistemaNombre'], 
											$correo['UsuarioEmail'], 'Receptor', 
											'', '', 
											$EmailTitulo, 
											$EmailCuerpo,'', 
											'',
											1, 
											$correo['Gmail_Usuario'], 
											$correo['Gmail_Password']);
				//se guarda el log
				log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:Informe alertas por equipo de '.$rowSistema['Nombre'].')');														
								
			}
	
		}

	} catch (Exception $e) {
		php_error_log('Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron', '', 'error de registro:'.$e->getMessage(), '' );
				
	}

}else{
	php_error_log('Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron', '', 'logo no existe ('.$login_logo.')', '' );
}



?>
