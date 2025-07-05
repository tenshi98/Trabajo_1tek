<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                           GUARDADO DE LAS DETENCIONES EN UN MISMO PUNTO                            */
/*                                                                                                    */
/******************************************************************************************************/
//Si esta asignado un tiempo de detencion
if($rowData['TiempoDetencion']!='00:00:00'){
	//Verifico si esta dentro del radio (1 es igual a 1 kilometro), en este caso si esta dentro de un radio de 10 metros
	if( $GeoMovimiento < 0.002 ) {
		//si no hay tiempo asignado guardo la hora actual
		if($rowData['GeoTiempoDetencion']=='00:00:00'){
			$chainxMain .= ",GeoTiempoDetencion='".$HoraSistema."'";
		//si existe tiempo actual voy guardando la cantidad de veces para desplegar en pantalla principal
		}elseif($rowData['GeoTiempoDetencion']!='00:00:00'){
			$dentro = $rowData['NDetenciones'] + 1;
			$chainxMain .= ",NDetenciones='".$dentro."'";
		}

	//Si esta en movimiento
	}else{
		//si al salir registra una hora de inicio de la detencion
		if($rowData['GeoTiempoDetencion']!='00:00:00'){

			//Verifico la resta de la hora de la ulima actualizacion contra  la hora actual
			$diaInicio   = $rowData['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $rowData['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($rowData['TiempoDetencion']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				//Guardo la detencion en la base de datos
				if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
				if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}
				if(isset($FechaSistema) && $FechaSistema!=''){   $SIS_data .= ",'".$FechaSistema."'";   }else{$SIS_data .= ",''";}
				if(isset($HoraSistema) && $HoraSistema!=''){     $SIS_data .= ",'".$HoraSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($GeoLatitud) && $GeoLatitud!=''){       $SIS_data .= ",'".$GeoLatitud."'";     }else{$SIS_data .= ",''";}
				if(isset($GeoLongitud) && $GeoLongitud!=''){     $SIS_data .= ",'".$GeoLongitud."'";    }else{$SIS_data .= ",''";}
				if(isset($Tiempo) && $Tiempo!=''){               $SIS_data .= ",'".$Tiempo."'";         }else{$SIS_data .= ",''";}
				if(isset($ultimo_id) && $ultimo_id!=''){         $SIS_data .= ",'".$ultimo_id."'";      }else{$SIS_data .= ",''";}
				if(isset($nx_UsoPredio) && $nx_UsoPredio!=''){   $SIS_data .= ",'".$nx_UsoPredio."'";   }else{$SIS_data .= ",''";}

				/*******************************************************/
				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idTelemetria, Fecha, Hora, GeoLatitud, GeoLongitud, Tiempo, idTabla, idZona';
				$insertDet   = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_error_detenciones', $dbConn, 'insertDet', basename($_SERVER["REQUEST_URI"], ".php"), 'insertDet');

				if(isset($insertDet)&&$insertDet!=0){
					//Agrego el dato de la alerta temprana para los GPS en 0
					$Vehi_Detenido .= 'El equipo '.DeSanitizar($rowData['Nombre']).' estuvo detenido '.$Tiempo.' en su misma ubicacion<br/>';

					//actualizo la hora de inicio de la detencion
					$chainxMain .= ",GeoTiempoDetencion='00:00:00'";
				}
			}
		}
		//Reseteo el numero de detenciones a 0
		$chainxMain .= ",NDetenciones='0'";
	}
}


?>
