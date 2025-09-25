<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                       Armado de las notificaciones                                 */
/*                                                                                                    */
/******************************************************************************************************/

//Listado de fuera de linea actuales
foreach ($arrTelemetria as $tel) {
	/**************************************************/
	//Se verifica si existe
	if(!isset($MedicionesActuales_Correo[$tel['idTelemetria']]) OR $MedicionesActuales_Correo[$tel['idTelemetria']]==''){      $MedicionesActuales_Correo[$tel['idTelemetria']]   = '';}
	if(!isset($MedicionesActuales_Whatsapp[$tel['idTelemetria']]) OR $MedicionesActuales_Whatsapp[$tel['idTelemetria']]==''){  $MedicionesActuales_Whatsapp[$tel['idTelemetria']] = '';}

	/*****************************************************************************/
	//variables
    $arrTempGrupos = array();
    $arrTempSensor = array();
	/*****************************************************************************/
	//Se recorren sensores
    for ($i = 1; $i <= $tel['cantSensores']; $i++) {
        //Verifico si el sensor esta activo para guardar el dato
        if(isset($tel['SensoresActivo_'.$i])&&$tel['SensoresActivo_'.$i]==1){
            /*****************************************/
            //Grupo Uso
            $arrTempGrupos[$tel['SensoresRevisionGrupo_'.$i]]['Nombre']  = $arrGruposUsoTemp[$tel['SensoresRevisionGrupo_'.$i]];
            $arrTempGrupos[$tel['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $tel['SensoresRevisionGrupo_'.$i];
            /*****************************************/
            //Grupo
            switch ($tel['SensoresUniMed_'.$i]) {
                /**********************/
                //Si es partes por millón
                case 15:
                    //Nombre y grupo
                    $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Nombre']  = $arrGruposTemp[$tel['SensoresGrupo_'.$i]];
                    $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['idGrupo'] = $tel['SensoresGrupo_'.$i];
                    //valido que este dentro del rango deseado
                    if($tel['SensoresMedActual_'.$i]<999){
                        //Temperatura Minima
                        if(isset($arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmin'])&&$arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmin']!=''){
                            //verifico si es menor
                            if($arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmin']>$tel['SensoresMedActual_'.$i]){
                                $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmin'] = $tel['SensoresMedActual_'.$i];
                            }
                        }else{
                            $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmin'] = $tel['SensoresMedActual_'.$i];
                        }
                        //Temperatura Maxima
                        if(isset($arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmax'])&&$arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmax']!=''){
                            //verifico si es mayor
                            if($arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmax']<$tel['SensoresMedActual_'.$i]){
                                $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmax'] = $tel['SensoresMedActual_'.$i];
                            }
                        }else{
                            $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['Tmax'] = $tel['SensoresMedActual_'.$i];
                        }
                        //Temperatura Actual
                        if(isset($arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['TActual'])&&$arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['TActual']!=''){
                            $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['TActual'] = $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['TActual'] + $tel['SensoresMedActual_'.$i];
                            $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['CountTActual']++;
                        }else{
                            $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['TActual']      = $tel['SensoresMedActual_'.$i];
                            $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['CountTActual'] = 1;
                        }
                    }
                    //estado (siempre pasa)
                    $arrTempGrupos[$tel['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
                    $arrTempSensor[$tel['SensoresRevisionGrupo_'.$i]][$tel['SensoresGrupo_'.$i]]['NErrores'] = 0;
                    break;
            }
        }
    }

	/*************************************************************/
    //Se arma cuerpo
	$MedicionesActuales_Correo[$tel['idTelemetria']]   .= '<tr style="background: #fff;"><th colspan="4" style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;text-align: left;">'.DeSanitizar($tel['Nombre']).' (Ultima Medición: '.fecha_estandar($tel['LastUpdateFecha']).' a las '.$tel['LastUpdateHora'].' hrs)</th></tr>';
	$MedicionesActuales_Whatsapp[$tel['idTelemetria']] .= 'Equipo <strong>'.DeSanitizar($tel['Nombre']).' (Ultima Medición: '.fecha_estandar($tel['LastUpdateFecha']).' a las '.$tel['LastUpdateHora'].' hrs)</strong><br/>';

    /*************************************************************/
    //Ordeno
    sort($arrTempGrupos);
    //recorro
    foreach ($arrTempGrupos as $gruUso) {
        //verificar errores
        $danger_icon = (isset($gruUso['NErrores']) && $gruUso['NErrores'] != 0) ? 'Con Alertas' : 'Sin Problemas';
        $MedicionesActuales_Correo[$tel['idTelemetria']]   .= '<tr style="background: #fff;"><th colspan="4" style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;text-align: left;">'.$gruUso['Nombre'].' ('.$danger_icon.')</th></tr>';
		$MedicionesActuales_Whatsapp[$tel['idTelemetria']] .= 'Grupo <strong>'.$gruUso['Nombre'].'</strong> ('.$danger_icon.')<br/>';
        //se ordena el arreglo
        sort($arrTempSensor[$gruUso['idGrupo']]);
        //recorro el arreglo
        foreach ($arrTempSensor[$gruUso['idGrupo']] as $gru) {
            //verificar errores
            $danger_icon = (isset($gru['NErrores']) && $gru['NErrores'] != 0) ? 'Con Alertas' : 'Sin Problemas';
            //variables
            $Tmin    = Cantidades($gru['Tmin'], 2);
            $Tmax    = Cantidades($gru['Tmax'], 2);
            $TActual = (isset($gru['CountTActual']) && $gru['CountTActual'] != 0) ? Cantidades($gru['TActual'] / $gru['CountTActual'], 2) : 0;
            $Hum     = (isset($gru['CountHum']) && $gru['CountHum'] != 0) ? Cantidades($gru['Hum'] / $gru['CountHum'], 2) : 0;

            if(isset($gru['CountBool'])&&$gru['CountBool']!=0){
                $tempv  = $gru['Bool']/$gru['CountBool'];
                $danger_icon .= (isset($tempv) && $tempv != 0) ? ' - Puertas Abiertas' : ' - Puertas Cerradas';
            }
			//Se generan datos
            $MedicionesActuales_Correo[$tel['idTelemetria']] .= '
            <tr style="background: #fff;">
                <td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$gru['Nombre'].' ('.$danger_icon.')</td>
                <td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$TActual.' ppm</td>
                <td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$Tmax.' ppm</td>
                <td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$Tmin.' ppm</td>
            </tr>';
			//Se generan datos
			$MedicionesActuales_Whatsapp[$tel['idTelemetria']] .= 'Subgrupo <strong>'.$danger_icon.'</strong><br/>';
			$MedicionesActuales_Whatsapp[$tel['idTelemetria']] .= 'ppm Actual <strong>'.$TActual.' ppm</strong><br/>';
			$MedicionesActuales_Whatsapp[$tel['idTelemetria']] .= 'ppm Max <strong>'.$Tmax.' ppm</strong><br/>';
			$MedicionesActuales_Whatsapp[$tel['idTelemetria']] .= 'ppm Min <strong>'.$Tmin.' ppm</strong><br/><br/><br/>';

        }
    }

}


?>
