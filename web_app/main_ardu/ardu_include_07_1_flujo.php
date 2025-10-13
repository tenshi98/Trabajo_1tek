<?php
/*******************************************************************************************************************/
/*                                              Bloque de Funciones                                                */
/*******************************************************************************************************************/
//crea la cadena para actualizar el valor en la BD
function returnMedActual($switchVar, $Iteracion, $SensorValor,$SensorValorActual ){

	//Variables
	$Medicion = ",SensoresMedActual_".$Iteracion."='0'";

	//Compruebo
	switch ($switchVar) {
		/******************************************************/
		//Si ignoro los errores y guardo el valor anterior
		case 1:
			//validacion segun el tipo de error
			switch ($SensorValor) {
				case 99900: $Medicion = ",SensoresMedActual_".$Iteracion."='".$SensorValorActual."'"; break; //
				case 99901: $Medicion = ",SensoresMedActual_".$Iteracion."='".$SensorValorActual."'"; break; //
				default:    $Medicion = ",SensoresMedActual_".$Iteracion."='".$SensorValor."'";              //valores ok
			}
			break;
		/******************************************************/
		//si guardo el error
		case 2:
			//validacion segun el tipo de error
			switch ($SensorValor) {
				case 99901: $Medicion = ",SensoresMedActual_".$Iteracion."='".$SensorValorActual."'"; break; //
				default:    $Medicion = ",SensoresMedActual_".$Iteracion."='".$SensorValor."'";              //valores ok
			}
			break;
	}

	//Devuelvo
	return $Medicion;
}
/*******************************************************************************************************************/
/*                                              Bloque de Consultas                                                */
/*******************************************************************************************************************/
/*********************** Revisiones ***********************/
//Se traen los grupos de revision
$arrGruposRev = array();
$arrGruposRev = db_select_array (false, 'idGrupo, Valor, idSupervisado', 'telemetria_listado_grupos_uso', '', 'idSupervisado=1', 'idGrupo ASC', $dbConn, 'ardu_include_revision_uso', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposRev');

//Se consultal los datos existentes
$SIS_query = 'idUso, Horas_Sensor_activo';
for ($i = 1; $i <= $Var_Counter; $i++) {
	$SIS_query .= ',Horas_'.$i;
}
$SIS_join  = '';
$SIS_where = 'idTelemetria='.$idTelemetria.' AND Fecha="'.$FechaSistema.'" ORDER BY idUso DESC';
$rowUsoRev = db_select_data (false, $SIS_query, 'telemetria_listado_historial_uso', $SIS_join, $SIS_where, $dbConn, 'ardu_include_updates_1', basename($_SERVER["REQUEST_URI"], ".php"), 'rowUsoRev');


/*******************************************************************************************************************/
/*                                              Bloque de Variables                                                */
/*******************************************************************************************************************/
/*********************** Revisiones ***********************/
//variables
$rev_counter       = 0;
$rev_insert_column = 'idTelemetria, Fecha';
$rev_insert_data   = "'".$idTelemetria."','".$FechaSistema."'";
$rev_update_data   = "Fecha='".$FechaSistema."'";
//Obtengo el tiempo transcurrido
$segundosRev = $SegTrans;
//Si existio revision anterior
if($rowUsoRev!=false){$UsoRevdata = 1;}else{$UsoRevdata = 0;}
/*********************** Verificacion Encendido ***********************/
//variables
$arrDatoX = array();

/******************************************************************************************************/
/*                                        EJECUCION CODIGO                                            */
/******************************************************************************************************/
//Armo arreglo para guardar los datos
for ($i = 1; $i <= $Var_Counter; $i++) {
	//Verifico si el sensor esta activo para guardar el dato
	if(isset($rowData['SensoresActivo_'.$i])&&$rowData['SensoresActivo_'.$i]==1){

		/****************************************************************************/
		/*                    Actualizacion Mediciones Actuales                     */
		/****************************************************************************/
		//Si existe el valor
		if(isset($Sensor[$i]['valor'])&&$Sensor[$i]['valor']!=''){
			//Verificacion de guardados de datos (desde global_config)
			$chainxMedActual .= returnMedActual($dis_999, $i, $Sensor[$i]['valor'],$rowData['SensoresMedActual_'.$i] );
		}
		/****************************************************************************/
		/*                       Actualizacion Uso de sensores                      */
		/****************************************************************************/
		//Reviso si el sensor esta siendo supervisado
		if(isset($rowData['SensoresUso_'.$i])&&$rowData['SensoresUso_'.$i]==1){
			//verifico que el dato exista
			if(isset($Sensor[$i]['valor'])&&$Sensor[$i]['valor']!=''&&$Sensor[$i]['valor']!=0){
				/***************************************************************/
				//Verifico el cambio de estado del sensor actual
				if($rowData['SensoresMedActual_'.$i]!=$Sensor[$i]['valor']){
					$cuenta = $rowData['SensoresAccionMedC_'.$i] + 1;
					//Actualizo
					$chainxMedC .= ",SensoresAccionMedC_".$i."='".$cuenta."'";
				}
				/***************************************************************/
				//Verifico que el tiempo final siempre sea superior al inicio
				if($HoraSistema>$rowData['LastUpdateHora']){
					//Sumo el tiempo transcurrido
					$Segs = restahoras($rowData['LastUpdateHora'],$HoraSistema);
					$Segs = horas2segundos($Segs);
					$Segs = $rowData['SensoresAccionMedT_'.$i] + $Segs;
					//Actualizo
					$chainxMedT  .= ",SensoresAccionMedT_".$i."='".$Segs."'";
				}
			}
		}
		/****************************************************************************/
		/*                                 Revision Uso                             */
		/****************************************************************************/
		//recorro los grupos
		foreach ($arrGruposRev as $sen) {
			//variable de conteo
			$rev_count = 0;
			//Reviso si el sensor esta siendo supervisado
			//verifico que pertenezca al grupo actual
			//verifico que el valor sea igual o superior al establecido
			//Verifico que el tiempo final siempre sea superior al inicio
			if(isset($rowData['SensoresRevision_'.$i])&&$rowData['SensoresRevision_'.$i]==1 && $rowData['SensoresRevisionGrupo_'.$i]==$sen['idGrupo'] && $Sensor[$i]['valor']>=$sen['Valor'] && $HoraSistema>$rowData['LastUpdateHora']){
				//guardo o actualizo datos
				switch ($UsoRevdata) {
					//si no existe dato del dia inserto
					case 0:
						$rev_insert_column .= ",Horas_".$i;
						$rev_insert_data   .= ",'".$segundosRev."'";
						break;
					//Si existe dato del dia actualizo
					default:
						$rev_upd          = $rowUsoRev['Horas_'.$i] + $segundosRev;
						$rev_update_data .= ",Horas_".$i."='".$rev_upd."'";
				}
				//dato para guardar
				$rev_counter++;
			}
		}
		/****************************************************************************/
		/*                                Alertas 999xx                             */
		/****************************************************************************/
		//En caso de que el valor sea 999xx
		if(isset($Sensor[$i]['valor']) && $Sensor[$i]['valor'] != '' && $Sensor[$i]['valor'] >= 99900){
			//Se guardan los errores en la tabla de errores
			if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
			if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}
			if(isset($FechaSistema) && $FechaSistema!=''){   $SIS_data .= ",'".$FechaSistema."'";   }else{$SIS_data .= ",''";}
			if(isset($HoraSistema) && $HoraSistema!=''){     $SIS_data .= ",'".$HoraSistema."'";    }else{$SIS_data .= ",''";}
			$SIS_data .= ",'".$i."'";//Sensor
			//Se verifica si tiene la funcion de geolocalizacion activa
			//si esta activa se guardan los ultimos datos
			if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''){
				//guardo o actualizo datos
				switch ($rowData['id_Geo']) {
					case 1:
						if(isset($GeoLatitud) && $GeoLatitud!=''){      $SIS_data .= ",'".$GeoLatitud."'";   }else{$SIS_data .= ",''";}
						if(isset($GeoLongitud) && $GeoLongitud!=''){    $SIS_data .= ",'".$GeoLongitud."'";  }else{$SIS_data .= ",''";}
						break;
					case 2:
						if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){     $SIS_data .= ",'".$rowData['GeoLatitud']."'";    }else{$SIS_data .= ",''";}
						if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){   $SIS_data .= ",'".$rowData['GeoLongitud']."'";   }else{$SIS_data .= ",''";}
						break;
				}
			}
			$SIS_data .= ",'El sensor ".DeSanitizar($rowData['SensoresNombre_'.$i])." esta fuera de parametros'";
			$SIS_data .= ",'".$Sensor[$i]['valor']."'";
			//El timestamp
			if(isset($FechaSistema,$HoraSistema) && $FechaSistema != '' && $HoraSistema!=''){
				$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
			}else{
				$SIS_data .= ",''";
			}
			//Se guarda unidad de medida
			if(isset($rowData['SensoresUniMed_'.$i]) && $rowData['SensoresUniMed_'.$i]!=''){      $SIS_data .= ",'".$rowData['SensoresUniMed_'.$i]."'";   }else{$SIS_data .= ",''";}

			/*******************************************************/
			// inserto los datos de registro en la db
			$SIS_columns = 'idSistema, idTelemetria, Fecha, Hora, Sensor, GeoLatitud, GeoLongitud, Descripcion, Valor, TimeStamp,idUniMed';
			$insertAlert999x = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores_999', $dbConn, 'insertAlert999x', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlert999x');

		}
		/****************************************************************************/
		/*                           Verificacion Encendido                         */
		/****************************************************************************/
		//Verifico solo si tiene configurado el tema del encendido
		//Verifico si el sensor esta dentro de los parametros y es un sensor de temperatura
		if(isset($rowData['CrossCMinHorno'],$Sensor[$i]['valor'],$rowData['SensoresUniMed_'.$i])&&$rowData['CrossCMinHorno']!=0&&$Sensor[$i]['valor']!=''&&$Sensor[$i]['valor']<999&&$rowData['SensoresUniMed_'.$i]==3){
			/*****************************/
			//verifico si existe
			if(isset($arrDatoX['Valor'])&&$arrDatoX['Valor']!=''){
				$arrDatoX['Valor'] = $arrDatoX['Valor'] + $Sensor[$i]['valor'];
				$arrDatoX['Cuenta']++;
			//si no lo crea
			}else{
				$arrDatoX['Valor']  = $Sensor[$i]['valor'];
				$arrDatoX['Cuenta'] = 1;
			}
		}
		/****************************************************************************/

	}
}
/****************************************************************************/
/*                                Post Ejecucion                            */
/****************************************************************************/
//si el sensor de activacion esta activo y es superior al valor establecido
if(isset($Sensor[$rowData['SensorActivacionID']]['valor'],$rowData['SensorActivacionValor'])){

	//declaracion variables
	$TempActVal_1 = '';
	$TempActVal_2 = '';

	//comparaciones
	if($Sensor[$rowData['SensorActivacionID']]['valor']>=$rowData['SensorActivacionValor']){
		/*********************** Revision Uso ***********************/
		//variable de update
		$rev_upd          = $rowUsoRev['Horas_Sensor_activo'] + $segundosRev;
		$rev_update_data .= ",Horas_Sensor_activo='".$rev_upd."'";

		//variable de insert
		$rev_insert_column .= ",Horas_Sensor_activo" ;
		$rev_insert_data   .= ",'".$segundosRev."'";

		//guardo o actualizo datos
		switch ($UsoRevdata) {
			case 0:  $insertHistorial = db_insert_data (false, $rev_insert_column, $rev_insert_data, 'telemetria_listado_historial_uso', $dbConn, 'insertHistorial', basename($_SERVER["REQUEST_URI"], ".php"), 'insertHistorial'); break;                    //si no existe dato del dia inserto
			default: $resultado       = db_update_data (false, $rev_update_data, 'telemetria_listado_historial_uso', 'idUso = "'.$rowUsoRev['idUso'].'"', $dbConn, 'ardu_include_revision_uso', basename($_SERVER["REQUEST_URI"], ".php"), 'db_update_data'); //Si existe dato del dia actualizo
		}

		/*********************** Activaciones ***********************/
		//valor de activacion
		$ActivationVal = 1;
		/***********************/
		//creacion variables
		if(isset($HoraSistema) && $HoraSistema!=''){                                       $TempActVal_1 = $HoraSistema;}
		if(isset($FechaSistema,$HoraSistema) && $FechaSistema != '' && $HoraSistema!=''){  $TempActVal_2 = $FechaSistema.' '.$HoraSistema;}

	}elseif($Sensor[$rowData['SensorActivacionID']]['valor']<$rowData['SensorActivacionValor']){
		/*********************** Activaciones ***********************/
		//valor de activacion
		$ActivationVal = 0;
		/***********************/
		//creacion variables
		if(isset($rowData['LastUpdateHora']) && $rowData['LastUpdateHora']!=''){                                       $TempActVal_1 = $rowData['LastUpdateHora'];}
		if(isset($FechaSistema,$rowData['LastUpdateHora']) && $FechaSistema != '' && $rowData['LastUpdateHora']!=''){  $TempActVal_2 = $FechaSistema.' '.$rowData['LastUpdateHora'];}
	}else{
		/*********************** Activaciones ***********************/
		//valor de activacion
		$ActivationVal = 0;
		/***********************/
		//creacion variables
		if(isset($rowData['LastUpdateHora']) && $rowData['LastUpdateHora']!=''){                                       $TempActVal_1 = $rowData['LastUpdateHora'];}
		if(isset($FechaSistema,$rowData['LastUpdateHora']) && $FechaSistema != '' && $rowData['LastUpdateHora']!=''){  $TempActVal_2 = $FechaSistema.' '.$rowData['LastUpdateHora'];}
	}

	/*********************** Activaciones ***********************/
	//verifico y guardo el cambio de estado solo en el caso de que este cambie
	if($rowData['Estado']!=$ActivationVal){

		//guardo el estado de encendido
		$chainxMain .= ",Estado='".$ActivationVal."'";

		/******************************************************************************/
		//guardo los datos
		if(isset($idTelemetria) && $idTelemetria!=''){    $SIS_data  = "'".$idTelemetria."'";    }else{$SIS_data  = "''";}
		if(isset($FechaSistema) && $FechaSistema!=''){    $SIS_data .= ",'".$FechaSistema."'";   }else{$SIS_data .= ",''";}
		if(isset($TempActVal_1) && $TempActVal_1!=''){    $SIS_data .= ",'".$TempActVal_1."'";   }else{$SIS_data .= ",''";}
		if(isset($TempActVal_2) && $TempActVal_2!=''){    $SIS_data .= ",'".$TempActVal_2."'";   }else{$SIS_data .= ",''";}
		//Guardo los sensores de activacion o desactivacion
		if(isset($rowData['SensorActivacionID']) && $rowData['SensorActivacionID']!=''){       $SIS_data .= ",'".$rowData['SensorActivacionID']."'";     }else{$SIS_data .= ",''";}
		if(isset($rowData['SensorActivacionValor']) && $rowData['SensorActivacionValor']!=''){ $SIS_data .= ",'".$rowData['SensorActivacionValor']."'";  }else{$SIS_data .= ",''";}
		//si el sensor es de activacion tiene un valor superior al establecido, se guarda 1, sino 0
		$SIS_data .= ",'".$ActivationVal."'";
		$SIS_data .= ",'1'";  //idEstado

		/*******************************************************/
		// inserto los datos de registro en la db
		$SIS_columns = 'idTelemetria, Fecha, Hora, TimeStamp, SensorActivacionID, SensorActivacionValor, Valor, idEstado';
		$insertActiv = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_historial_activaciones', $dbConn, 'insertActiv', basename($_SERVER["REQUEST_URI"], ".php"), 'insertActiv');


	}

}
/****************************************************************************/
/*                           Verificacion Encendido                         */
/****************************************************************************/
//Verifico solo si tiene configurado el tema del encendido
if(isset($rowData['CrossCMinHorno'],$arrDatoX['Cuenta'],$rowData['MedicionTiempo'],$rowData['LastUpdateHora'],$HoraSistema)&&$rowData['CrossCMinHorno']!=0&&$arrDatoX['Cuenta']!=0){
	//calculo el promedio
	$PROM_X = $arrDatoX['Valor'] / $arrDatoX['Cuenta'];
	//verifico si esta encendido
	if($PROM_X>=$rowData['CrossCMinHorno']){
		//Sumo el tiempo transcurrido
		$Segs = restahoras($rowData['LastUpdateHora'],$HoraSistema);
		$Segs = horas2segundos($Segs);
		$Segs = $rowData['MedicionTiempo'] + $Segs;
		//Actualizo
		$chainxMain .= ",MedicionTiempo='".$Segs."'";


		/*********************** Revision Uso solo en el caso de que sea superior al minimo ***********************/
		if($rev_counter!=0){
			//variable de update
			$rev_upd          = $rowUsoRev['Horas_Sensor_activo'] + $segundosRev;
			$rev_update_data .= ",Horas_Sensor_activo='".$rev_upd."'";

			//variable de insert
			$rev_insert_column .= ",Horas_Sensor_activo" ;
			$rev_insert_data   .= ",'".$segundosRev."'";

			//guardo o actualizo datos
			switch ($UsoRevdata) {
				case 0:  $insertHistorial = db_insert_data (false, $rev_insert_column, $rev_insert_data, 'telemetria_listado_historial_uso', $dbConn, 'insertHistorial', basename($_SERVER["REQUEST_URI"], ".php"), 'insertHistorial'); break;                    //si no existe dato del dia inserto
				default: $resultado       = db_update_data (false, $rev_update_data, 'telemetria_listado_historial_uso', 'idUso = "'.$rowUsoRev['idUso'].'"', $dbConn, 'ardu_include_revision_uso', basename($_SERVER["REQUEST_URI"], ".php"), 'db_update_data'); //Si existe dato del dia actualizo
			}
		}
	}
}




?>
