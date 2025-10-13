<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                 GUARDADO DE LOS LIMITES DE VELOCIDAD                               */
/*                                                                                                    */
/******************************************************************************************************/
//Verifico que el limite de velocidad este configurado
//Valido que la velocidad actual sea superior a la maxima establecida
if(isset($rowData['LimiteVelocidad'], $GeoVelocidad)&&$rowData['LimiteVelocidad']!=0&&$rowData['LimiteVelocidad']!=''&&$GeoVelocidad!=''&&$rowData['LimiteVelocidad']<$GeoVelocidad){

	//Se guardan los errores en la tabla de errores
	if(isset($idSistema) && $idSistema!=''){                             $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
	if(isset($idTelemetria) && $idTelemetria!=''){                       $SIS_data .= ",'".$idTelemetria."'";  }else{$SIS_data .= ",''";}
	if(isset($FechaSistema) && $FechaSistema!=''){                       $SIS_data .= ",'".$FechaSistema."'";  }else{$SIS_data .= ",''";}
	if(isset($HoraSistema) && $HoraSistema!=''){                         $SIS_data .= ",'".$HoraSistema."'";   }else{$SIS_data .= ",''";}
	if(isset($GeoLatitud) && $GeoLatitud != ''&& $GeoLatitud != 0){      $SIS_data .= ",'".$GeoLatitud."'";    }else{$SIS_data .= ",''";}
	if(isset($GeoLongitud) && $GeoLongitud != ''&& $GeoLongitud != 0){   $SIS_data .= ",'".$GeoLongitud."'";   }else{$SIS_data .= ",''";}
	$SIS_data .= ",'2'";                                                  //Exceso Limite Velocidad
	$SIS_data .= ",'El vehiculo ha sobrepasado el limite de velocidad'";  //Mensaje de error
	$SIS_data .= ",'".$GeoVelocidad."'";                                  //Velocidad Actual
	$SIS_data .= ",'".$rowData['LimiteVelocidad']."'";                    //Maximo programado

	/*******************************************************/
	// inserto los datos de registro en la db
	$SIS_columns = 'idSistema, idTelemetria, Fecha, Hora, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, Valor_max';
	$insertVel   = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertVel', basename($_SERVER["REQUEST_URI"], ".php"), 'insertVel');

	/*******************************************************/
	// si inserta correctamente
	if(isset($insertVel)&&$insertVel!=0){
		//Agrego el dato de la alerta temprana para la velocidad
		$Velocidad .= 'El equipo '.DeSanitizar($rowData['Nombre']).' ha excedido la velocidad, su velocidad maxima es de ';
		$Velocidad .= Cantidades($rowData['LimiteVelocidad'], 0).' KM/h, actualmente se encuentra a '.Cantidades($GeoVelocidad, 0).' KM/h <br/>';
	}
}

?>
