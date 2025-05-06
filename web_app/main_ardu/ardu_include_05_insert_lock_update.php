<?php
/*******************************************************************************************************************/
/*                                                Se ejecuta codigo                                                */
/*******************************************************************************************************************/


//Busco el ultimo registro
$rowTabla = db_select_data (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$idTelemetria, '', 'idTabla!=0 ORDER BY idTabla DESC', $dbConn, 'ardu_include_5_insert_lock_update', basename($_SERVER["REQUEST_URI"], ".php"), 'rowTabla');

//Actualizo el registro en caso de existir
if(isset($rowTabla['idTabla']) && $rowTabla['idTabla']!=''){          $SIS_data  = "idTabla='".$rowTabla['idTabla']."'";      }
if(isset($idTelemetria) && $idTelemetria!=''){                        $SIS_data .= ",idTelemetria='".$idTelemetria."'";     }
if(isset($FechaSistema) && $FechaSistema!=''){                        $SIS_data .= ",FechaSistema='".$FechaSistema."'";     }
if(isset($HoraSistema) && $HoraSistema!=''){                          $SIS_data .= ",HoraSistema='".$HoraSistema."'";      }
//El timestamp
if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
	$SIS_data .= ",TimeStamp='".$FechaSistema." ".$HoraSistema."'";
}else{
	$SIS_data .= ",TimeStamp=''";
}
//Geolocalizacion
if(isset($GeoLatitud) && $GeoLatitud != '' && $GeoLatitud != 0){          $SIS_data .= ",GeoLatitud='".$GeoLatitud."'";       }else{if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){       $SIS_data .= ",GeoLatitud='".$rowData['GeoLatitud']."'";}}
if(isset($GeoLongitud) && $GeoLongitud != '' && $GeoLongitud != 0){       $SIS_data .= ",GeoLongitud='".$GeoLongitud."'";     }else{if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){     $SIS_data .= ",GeoLongitud='".$rowData['GeoLongitud']."'";}}
if(isset($GeoVelocidad) && $GeoVelocidad != '' && $GeoVelocidad != 0){    $SIS_data .= ",GeoVelocidad='".$GeoVelocidad."'";   }else{if(isset($rowData['GeoVelocidad']) && $rowData['GeoVelocidad']!=''){   $SIS_data .= ",GeoVelocidad='".$rowData['GeoVelocidad']."'";}}
if(isset($GeoDireccion) && $GeoDireccion != '' && $GeoDireccion != 0){    $SIS_data .= ",GeoDireccion='".$GeoDireccion."'";   }else{if(isset($rowData['GeoDireccion']) && $rowData['GeoDireccion']!=''){   $SIS_data .= ",GeoDireccion='".$rowData['GeoDireccion']."'";}}
if(isset($GeoMovimiento) && $GeoMovimiento != '' && $GeoMovimiento != 0){ $SIS_data .= ",GeoMovimiento='".$GeoMovimiento."'"; }else{if(isset($rowData['GeoMovimiento']) && $rowData['GeoMovimiento']!=''){ $SIS_data .= ",GeoMovimiento='".$rowData['GeoMovimiento']."'";}}
/***************************************************************************/
//Si se esta usando el predio
//verifico si se esta enviando la localizacion
if(isset($rowData['idUsoPredio'], $GeoLatitud, $GeoLongitud) && $rowData['idUsoPredio']==1&&$GeoLatitud != '' && $GeoLatitud != 0 && $GeoLongitud != '' && $GeoLongitud != 0){
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
	$SIS_data .= ",idZona='".$nx_UsoPredio."'";
}

/*********************************************************************/
//Mientras la hora actual sea superior a la ultima hora
if($HoraSistema>$rowData['LastUpdateHora']){
	//Se guarda el tiempo transcurrido
	$SIS_data .= ",Segundos='".$SegTrans."'";
}

/*********************************************************************/
//Si se utilizan los sensores
if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']!=''&&$rowData['id_Sensores']==1){
	/******************************************************/
	//Si necesita el uso de los flujos Agro-Checking
	//Si los sensores de flujo estan funcionando
	if(isset($rowData['idTab'],$Sensor[1]['valor'], $Sensor[2]['valor'])&&$rowData['idTab']==1&&$Sensor[1]['valor']!=''&&$Sensor[2]['valor']!=''&&($Sensor[1]['valor']>0 OR $Sensor[2]['valor']>0)){
		$Suma  = ($Sensor[1]['valor'] + $Sensor[2]['valor'])/60;
		if(validarNumero($Suma)==TRUE&&validarNumero($SegTrans)==TRUE){
			$flujo = $Suma * $SegTrans;
			//Se guarda el tiempo transcurrido
			$SIS_data .= ",Diferencia='".$flujo."'";
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
						case 99900: $SIS_data .= ",Sensor_".$i."='".$rowData['SensoresMedActual_'.$i]."'"; break;//
						case 99901: $SIS_data .= ",Sensor_".$i."='".$rowData['SensoresMedActual_'.$i]."'"; break;//
						default:    $SIS_data .= ",Sensor_".$i."='".$Sensor[$i]['valor']."'";                    //valores ok
					}
					break;
				/******************************************************/
				//si guardo el error
				case 2:
					//validacion segun el tipo de error
					switch ($Sensor[$i]['valor']) {
						case 99901: $SIS_data .= ",Sensor_".$i."='".$rowData['SensoresMedActual_'.$i]."'"; break;//
						default:    $SIS_data .= ",Sensor_".$i."='".$Sensor[$i]['valor']."'";                    //valores ok
					}
					break;
			}
		}
	}
}

/*********************************************************************/
//se actualizan los datos
$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_tablarelacionada_'.$idTelemetria, 'idTabla = "'.$rowTabla['idTabla'].'"', $dbConn, 'ardu_include_insert_lock_update', basename($_SERVER["REQUEST_URI"], ".php"), 'db_update_data');

//recibo el último id generado por mi sesion
$ultimo_id = $rowTabla['idTabla'];

?>
