<?php
/*******************************************************************************************************************/
/*                                                Se ejecuta codigo                                                */
/*******************************************************************************************************************/
/*********************************************************************/
//Variable carga datos en columnas
$columna  = '';

//Se guardan los datos recibidos
if(isset($idTelemetria) && $idTelemetria!=''){    $SIS_data  = "'".$idTelemetria."'";      }else{$SIS_data  = "''";}
if(isset($FechaSistema) && $FechaSistema!=''){    $SIS_data .= ",'".$FechaSistema."'";     }else{$SIS_data .= ",''";}
if(isset($HoraSistema) && $HoraSistema!=''){      $SIS_data .= ",'".$HoraSistema."'";      }else{$SIS_data .= ",''";}
//El timestamp
if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
	$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
}else{
	$SIS_data .= ",''";
}
//Geolocalizacion
if(isset($GeoLatitud) && $GeoLatitud != '' && $GeoLatitud != 0){            $SIS_data .= ",'".$GeoLatitud."'";        }else{$SIS_data .= ",''";}
if(isset($GeoLongitud) && $GeoLongitud != '' && $GeoLongitud != 0){         $SIS_data .= ",'".$GeoLongitud."'";       }else{$SIS_data .= ",''";}
if(isset($GeoVelocidad) && $GeoVelocidad != '' && $GeoVelocidad != 0){      $SIS_data .= ",'".$GeoVelocidad."'";      }else{$SIS_data .= ",''";}
if(isset($GeoDireccion) && $GeoDireccion != '' && $GeoDireccion != 0){      $SIS_data .= ",'".$GeoDireccion."'";      }else{$SIS_data .= ",''";}
if(isset($GeoMovimiento) && $GeoMovimiento != '' && $GeoMovimiento != 0){   $SIS_data .= ",'".$GeoMovimiento."'";     }else{$SIS_data .= ",''";}
/***************************************************************************/
//Si se esta usando el predio
//verifico si se esta enviando la localizacion
if(isset($rowData['idUsoPredio'], $GeoLatitud, $GeoLongitud) && $rowData['idUsoPredio']==1 && $GeoLatitud != '' && $GeoLatitud != 0 && $GeoLongitud != '' && $GeoLongitud != 0){
	//Se traen las zonas
	$arrZonas = array();
	$arrZonas = db_select_array (false, 'cross_predios_listado_zonas.idZona,cross_predios_listado_zonas_ubicaciones.Latitud,cross_predios_listado_zonas_ubicaciones.Longitud', 'cross_predios_listado_zonas', 'LEFT JOIN `cross_predios_listado_zonas_ubicaciones` ON cross_predios_listado_zonas_ubicaciones.idZona = cross_predios_listado_zonas.idZona LEFT JOIN `cross_predios_listado` ON cross_predios_listado.idPredio = cross_predios_listado_zonas.idPredio', 'cross_predios_listado.idSistema ='.$idSistema, 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC', $dbConn, 'ardu_include_insert_lock_insert', basename($_SERVER["REQUEST_URI"], ".php"), 'arrZonas');
	//se filtran las zonas
	filtrar($arrZonas, 'idZona');
	//se llama al modulo
	$pointLocation = new subpointLocation();
	//verifico si esta dentro
	$nx_UsoPredio = inLocationPoint($arrZonas, $pointLocation, $GeoLatitud, $GeoLongitud);
	//se guarda la zona
	$SIS_data .= ",'".$nx_UsoPredio."'";
	$columna  .= ',idZona';
}

/*********************************************************************/
//Mientras la hora actual sea superior a la ultima hora
if($HoraSistema>$rowData['LastUpdateHora']){
	//Se guarda el tiempo transcurrido
	$SIS_data .= ",'".$SegTrans."'";
	$columna  .= ',Segundos';
}

/*********************************************************************/
//Si se utilizan los sensores
if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']!=''&&$rowData['id_Sensores']==1){
	/******************************************************/
	//Si necesita el uso de los flujos CrossChecking
	//Si los sensores de flujo estan funcionando
	if(isset($rowData['idTab'],$Sensor[1]['valor'], $Sensor[2]['valor'])&&$rowData['idTab']==1&&$Sensor[1]['valor']!=''&&$Sensor[2]['valor']!=''&&($Sensor[1]['valor']>0 OR $Sensor[2]['valor']>0)){
		$Suma  = ($Sensor[1]['valor'] + $Sensor[2]['valor'])/60;
		if(validarNumero($Suma)==TRUE&&validarNumero($SegTrans)==TRUE){
			$flujo = $Suma * $SegTrans;
			//Se guarda el tiempo transcurrido
			$SIS_data .= ",'".$flujo."'";
			$columna  .= ',Diferencia';
		}
	}
	/******************************************************/
	//Armo arreglo para guardar los datos
	for ($i = 1; $i <= $Var_Counter; $i++) {
		//Verifico si el sensor esta activo para guardar el dato
		//Verifico si existe el valor
		if(isset($rowData['SensoresActivo_'.$i], $Sensor[$i]['valor'])&&$rowData['SensoresActivo_'.$i]==1&&$Sensor[$i]['valor']!=''&&$Sensor[$i]['valor']!=0){
			//Verificacion de guardados de datos (desde global_config)
			switch ($dis_999) {
				/******************************************************/
				//Si ignoro los errores y guardo el valor anterior
				case 1:
					//validacion segun el tipo de error
					switch ($Sensor[$i]['valor']) {
						case 99900: $SIS_data .= ",'".$rowData['SensoresMedActual_'.$i]."'"; $columna .= ',Sensor_'.$i; break;//
						case 99901: $SIS_data .= ",'".$rowData['SensoresMedActual_'.$i]."'"; $columna .= ',Sensor_'.$i; break;//
						default:    $SIS_data .= ",'".$Sensor[$i]['valor']."'";              $columna .= ',Sensor_'.$i;       //valores ok
					}
					break;
				/******************************************************/
				//si guardo el error
				case 2:
					//validacion segun el tipo de error
					switch ($Sensor[$i]['valor']) {
						case 99901: $SIS_data .= ",'".$rowData['SensoresMedActual_'.$i]."'"; $columna .= ',Sensor_'.$i; break;//
						default:    $SIS_data .= ",'".$Sensor[$i]['valor']."'";              $columna .= ',Sensor_'.$i;       //valores ok
					}
					break;
			}
		}
	}
}


/*******************************************************/
// inserto los datos de registro en la db
$SIS_columns = 'idTelemetria, FechaSistema, HoraSistema, TimeStamp, GeoLatitud, GeoLongitud, GeoVelocidad, GeoDireccion, GeoMovimiento'.$columna;
$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $dbConn, 'ultimo_id', basename($_SERVER["REQUEST_URI"], ".php"), 'ultimo_id');


?>
