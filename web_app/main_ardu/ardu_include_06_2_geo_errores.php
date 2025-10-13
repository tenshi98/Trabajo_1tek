<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                  SENSORES DE LATITUD Y LONGITUD EN 0                               */
/*                                                                                                    */
/******************************************************************************************************/
//Verifico que latitud y longitud marquen error (0) y guardo su registro en una tabla de errores
if(isset($GeoLatitud, $GeoLongitud)&&$GeoLatitud==0&&$GeoLongitud==0){

	//actualizo la cantidad de errores
	$geoError    = $rowData['GeoErrores'] + 1;
	$chainxMain .= ",GeoErrores='".$geoError."'";

	//Guardo el dato en un registro independiente
	if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data  = "'".$idTelemetria."'";   }else{$SIS_data  = "''";}
	if(isset($FechaSistema) && $FechaSistema!=''){  $SIS_data .= ",'".$FechaSistema."'";  }else{$SIS_data .= ",''";}
	if(isset($HoraSistema) && $HoraSistema!=''){    $SIS_data .= ",'".$HoraSistema."'";   }else{$SIS_data .= ",''";}
	if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!= ''){
		$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
	}else{
		$SIS_data .= ",''";
	}
	/******************************************/
	//Guardo la diferencia de tiempo
	$SIS_data .= ",'".$HorasTrans."'";

	/*******************************************************/
	// inserto los datos de registro en la db
	$SIS_columns = 'idTelemetria, Fecha, Hora, TimeStamp, Diferencia';
	$insertErr   = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_historial_gps', $dbConn, 'insertErr', basename($_SERVER["REQUEST_URI"], ".php"), 'insertErr');

	/******************************************/
	//Guardo la diferencia de tiempo
	if(isset($insertErr)&&$insertErr!=0){
		//Agrego el dato de la alerta temprana para los GPS en 0
		$GPS_en0 .= 'El equipo '.DeSanitizar($rowData['Nombre']).' tiene los GPS enviando valor 0<br/>';
	}

/***************************************************************************************/
//Si esta ok se resetea la columna de errores
}elseif(isset($GeoLatitud, $GeoLongitud)&&$GeoLatitud!=0&&$GeoLongitud!=0){
	$chainxMain .= ",GeoErrores='0'";
}

?>
