<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                    GUARDADO DE LOS FUERA DE LINEA                                  */
/*                                                                                                    */
/******************************************************************************************************/
/******************************************************************************************/
//Se verifica que el tiempo de detencion es superior al establecido por sistema
//Comparaciones de tiempo
$Time_Tiempo     = $SegTrans;
$Time_Tiempo_FL  = horas2segundos($rowData['TiempoFueraLinea']);
$Time_Tiempo_Max = horas2segundos('48:00:00');
$Time_Fake_Ini   = horas2segundos('23:59:50');
$Time_Fake_Fin   = horas2segundos('24:00:00');
/**********************************************************/
//Si es una maquina que actualiza datos
if(isset($lock)&&$lock!=''&&($lock==1 OR $lock==2)){
	//nada
//Si es una maquina normal
}else{
	//comparacion
	if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
		//Consulta
		if(isset($idSistema) && $idSistema!=''){                                          $SIS_data  = "'".$idSistema."'";                    }else{$SIS_data  = "''";}
		if(isset($idTelemetria) && $idTelemetria!=''){                                    $SIS_data .= ",'".$idTelemetria."'";                }else{$SIS_data .= ",''";}
		if(isset($rowData['LastUpdateFecha']) && $rowData['LastUpdateFecha']!=''){        $SIS_data .= ",'".$rowData['LastUpdateFecha']."'";  }else{$SIS_data .= ",''";}
		if(isset($rowData['LastUpdateHora']) && $rowData['LastUpdateHora']!=''){          $SIS_data .= ",'".$rowData['LastUpdateHora']."'";   }else{$SIS_data .= ",''";}
		if(isset($FechaSistema) && $FechaSistema!=''){                                    $SIS_data .= ",'".$FechaSistema."'";                }else{$SIS_data .= ",''";}
		if(isset($HoraSistema) && $HoraSistema!=''){                                      $SIS_data .= ",'".$HoraSistema."'";                 }else{$SIS_data .= ",''";}
		if(isset($HorasTrans) && $HorasTrans!=''){                                        $SIS_data .= ",'".$HorasTrans."'";                  }else{$SIS_data .= ",''";}
		//Se verifica si tiene la funcion de geolocalizacion activa
		//si esta activa se guardan los ultimos datos
		if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''){
			//validacion segun el tipo de error
			switch ($rowData['id_Geo']) {
				case 1:
					if(isset($GeoLatitud) && $GeoLatitud!=''){    $SIS_data .= ",'".$GeoLatitud."'";  }else{$SIS_data .= ",''";}
					if(isset($GeoLongitud) && $GeoLongitud!=''){  $SIS_data .= ",'".$GeoLongitud."'"; }else{$SIS_data .= ",''";}
					break;
				case 2:
					if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){    $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
					if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){  $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
					break;
				default:
					$SIS_data .= ",''";
					$SIS_data .= ",''";
			}
		}
		if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){    $SIS_data .= ",'".$rowData['GeoLatitud']."'";   }else{$SIS_data .= ",''";}
		if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){  $SIS_data .= ",'".$rowData['GeoLongitud']."'";  }else{$SIS_data .= ",''";}
		//El timestamp
		if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
			$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
		}else{
			$SIS_data .= ",''";
		}
		if(isset($nx_UsoPredio) && $nx_UsoPredio!=''){   $SIS_data .= ",'".$nx_UsoPredio."'";  }else{$SIS_data .= ",''";}

		/*******************************************************/
		// inserto los datos de registro en la db
		$SIS_columns      = 'idSistema, idTelemetria, Fecha_inicio, Hora_inicio, Fecha_termino, Hora_termino, Tiempo, GeoLatitud, GeoLongitud, GeoLatitud_Last, GeoLongitud_Last, TimeStamp, idZona';
		$insertFueraLinea = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_error_fuera_linea', $dbConn, 'insertFueraLinea', basename($_SERVER["REQUEST_URI"], ".php"), 'insertFueraLinea');

		//Agrego el dato de la alerta temprana para a fuera de linea
		$FueraLinea .= 'El equipo '.DeSanitizar($rowData['Nombre']).' ha estado '.$HorasTrans.' hrs fuera de linea <br/>';
	}
}


?>
