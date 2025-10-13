<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
/*if( ! defined(DB_NAME)){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1013-010).');
}
/*******************************************************************************************************************/
/*                                                Se ejecuta codigo                                                */
/*******************************************************************************************************************/
function updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn ){

	//Datos a actualizar
	$SIS_data  = "NErroresActual='".$NErroresActual."'";
	//Actualizo
	$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_alarmas_perso', 'idAlarma = "'.$cat_idAlarma.'"', $dbConn, 'ardu_include_alertas_personalizadas', basename($_SERVER["REQUEST_URI"], ".php"), 'db_update_data');

}
/******************************************************************************************************/
/*                                                                                                    */
/*                            SE GENERAN LAS ALERTAS Y SE GUARDAN LOS ERRORES                         */
/*                                                                                                    */
/******************************************************************************************************/
//Variables
$NAlertas      = $rowData['NAlertas'];
$NErroresTempx = 0;
$NErrores      = $rowData['NErrores'];

//Se consultan datos
$SIS_query = '
telemetria_listado_alarmas_perso.idAlarma,
telemetria_listado_alarmas_perso.Nombre,
telemetria_listado_alarmas_perso.idTipo,
telemetria_listado_alarmas_perso.idTipoAlerta,
telemetria_listado_alarmas_perso.idUniMed,
telemetria_listado_alarmas_perso.NErroresMax,
telemetria_listado_alarmas_perso.NErroresActual,
telemetria_listado_alarmas_perso.valor_error,
telemetria_listado_alarmas_perso.valor_diferencia,
telemetria_listado_alarmas_perso.Rango_ini AS AlarmIni,
telemetria_listado_alarmas_perso.Rango_fin AS AlarmFin,
telemetria_listado_alarmas_perso.HoraInicio AS HoraIni,
telemetria_listado_alarmas_perso.HoraTermino AS HoraFin,
telemetria_listado_alarmas_perso_items.Sensor_N,
telemetria_listado_alarmas_perso_items.Rango_ini,
telemetria_listado_alarmas_perso_items.Rango_fin,
telemetria_listado_alarmas_perso_items.valor_especifico,
telemetria_listado_unidad_medida.Nombre AS Unimed';
$SIS_join  = '
LEFT JOIN `telemetria_listado_alarmas_perso_items` ON telemetria_listado_alarmas_perso_items.idAlarma = telemetria_listado_alarmas_perso.idAlarma
LEFT JOIN `telemetria_listado_unidad_medida`       ON telemetria_listado_unidad_medida.idUniMed       = telemetria_listado_alarmas_perso.idUniMed';
$SIS_where = 'telemetria_listado_alarmas_perso.idTelemetria ='.$idTelemetria; //Equipo
$SIS_where.= ' AND telemetria_listado_alarmas_perso.idEstado=1';              //Alarma activa
$SIS_order = 'idAlarma ASC';
$arrAlertPerso = array();
$arrAlertPerso = db_select_array (false, $SIS_query, 'telemetria_listado_alarmas_perso', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'ardu_include_alertas_personalizadas', basename($_SERVER["REQUEST_URI"], ".php"), 'arrAlertPerso');

/*************************************************************************************************/
//Reviso las alertas
filtrar($arrAlertPerso, 'idAlarma');
//se recorre
foreach($arrAlertPerso as $cat_idAlarma=>$alarmas){

	/**************************************************************/
	//Verifico que todos los sensores revisados esten activos
	$xn_sen_revisado  = 0;
	$xn_sen_activo    = 0;
	$xn_matriz        = array();
	$xn_matrizRangos  = array();

	foreach ($alarmas as $alarma) {
		$xn_sen_revisado++;
		//recorro los sensores activos
		if(isset($rowData['SensoresActivo_'.$alarma['Sensor_N']])&&$rowData['SensoresActivo_'.$alarma['Sensor_N']]==1){
			//se cuentan los sensores activos
			$xn_sen_activo++;
			//Se agregan datos a la matriz
			array_push($xn_matriz,$Sensor[$alarma['Sensor_N']]['valor']);
			//se verifican los rangos
			$xn_matrizRangos[$xn_sen_activo]['Rango_ini']         = $alarma['Rango_ini'];
			$xn_matrizRangos[$xn_sen_activo]['Rango_fin']         = $alarma['Rango_fin'];
			$xn_matrizRangos[$xn_sen_activo]['valor_especifico']  = $alarma['valor_especifico'];
		}
	}

	/**************************************************************/
	//Si todos estan activos
	if($xn_sen_revisado==$xn_sen_activo){

		//Variable para la alerta temprana
		$NErroresMax     = $alarmas[0]['NErroresMax'];
		$NErroresActual  = $alarmas[0]['NErroresActual'];
		$idTipoAlerta    = $alarmas[0]['idTipoAlerta'];
		$idUniMed        = $alarmas[0]['idUniMed'];

		//se verifica el tipo de configuracion
		switch ($alarmas[0]['idTipo']) {

			/*********************************************************************************/
			//Errores Conjuntos
			case 1:
				//se crea variable temporal
				$xn_temp = 0;
				//se recorre el arreglo
				foreach ($xn_matriz as $mat) {
					if($alarmas[0]['valor_error'] == $mat && $mat < 99900){
						$xn_temp++;
					}
				}
				//si la cantidad de errores es igual a la cantidad de sensores
				if($xn_sen_activo==$xn_temp){

					//se validan que los errores actuales sean superiores a los errores maximo
					if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){
						//Se guardan los errores en la tabla de errores
						if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
						if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}
						if(isset($FechaSistema) && $FechaSistema!=''){   $SIS_data .= ",'".$FechaSistema."'";   }else{$SIS_data .= ",''";}
						if(isset($HoraSistema) && $HoraSistema!=''){     $SIS_data .= ",'".$HoraSistema."'";    }else{$SIS_data .= ",''";}
						$SIS_data .= ",'0'"; //Valor_min
						$SIS_data .= ",'0'"; //Valor_max
						//Se verifica si tiene la funcion de geolocalizacion activa
						//si esta activa se guardan los ultimos datos
						if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
							if(isset($GeoLatitud) && $GeoLatitud!=''){     $SIS_data .= ",'".$GeoLatitud."'";    }else{$SIS_data .= ",''";}
							if(isset($GeoLongitud) && $GeoLongitud!=''){   $SIS_data .= ",'".$GeoLongitud."'";   }else{$SIS_data .= ",''";}
						//si no esta activa se guardan los datos por defecto
						}elseif(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==2){
							if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){     $SIS_data .= ",'".$rowData['GeoLatitud']."'";    }else{$SIS_data .= ",''";}
							if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){   $SIS_data .= ",'".$rowData['GeoLongitud']."'";   }else{$SIS_data .= ",''";}
						}
						$SIS_data .= ",'1'";                                                                               //idTipo
						$SIS_data .= ",'El grupo ".DeSanitizar($alarmas[0]['Nombre'])." de Sensores estan marcando error'";//Descripcion
						$SIS_data .= ",'".$alarmas[0]['valor_error']."'";                                                  //Valor
						//El timestamp
						if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
							$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'1'";                  //indica que es personalizada
						$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
						$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

						/*******************************************************/
						// inserto los datos de registro en la db
						$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
						$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

						/******************************************************/
						//se guarda alerta para enviarla por correo
						//verifico el tipo de alerta
						if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
							//tipo de alertas
							switch ($idTipoAlerta) {
								//Normal
								case 1:
									$Alertas_perso .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta marcando error ';
									$Alertas_perso .= '(Actual:'.Cantidades($alarmas[0]['valor_error'], 2).') <br/>';
									break;
								//Catastrofica
								case 2:
									$Alertas_criticas .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta marcando error ';
									$Alertas_criticas .= '(Actual:'.Cantidades($alarmas[0]['valor_error'], 2).') <br/>';
									break;
							}
						}

						//Sumo los datos
						$NErroresTempx = $NErroresTempx + 1;
						$NAlertas      = $NAlertas + 1;

						/******************************************************/
						//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					//si son inferiores, pero marca error se suman
					}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
						//se suma 1 a los errores
						$NErroresActual  = $NErroresActual + 1;
						//se actualizasolo si el numero de errores maximo esta configurado
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
						}
					//si no reseteo a 0
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}

				}else{
					updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
				}
			break;
			/*********************************************************************************/
			//Rango Porcentaje Grupo
			case 2:
				$xn_max_value = max($arreglo);
				$xn_min_value = min($arreglo);
				$xn_min_oper = $xn_max_value-($alarmas[0]['valor_diferencia']*($xn_max_value/100));
				//se verifica si el minimo registrado es inferior al minimo por porcentaje
				if($xn_min_value<$xn_min_oper){

					//se validan que los errores actuales sean superiores a los errores maximo
					if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){

						//Se guardan los errores en la tabla de errores
						if(isset($idSistema) && $idSistema!=''){        $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
						if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}
						if(isset($FechaSistema) && $FechaSistema!=''){  $SIS_data .= ",'".$FechaSistema."'";   }else{$SIS_data .= ",''";}
						if(isset($HoraSistema) && $HoraSistema!=''){    $SIS_data .= ",'".$HoraSistema."'";    }else{$SIS_data .= ",''";}
						$SIS_data .= ",'0'"; //Valor_min
						$SIS_data .= ",'0'"; //Valor_max
						//Se verifica si tiene la funcion de geolocalizacion activa
						//si esta activa se guardan los ultimos datos
						if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
							if(isset($GeoLatitud) && $GeoLatitud!=''){    $SIS_data .= ",'".$GeoLatitud."'";  }else{$SIS_data .= ",''";}
							if(isset($GeoLongitud) && $GeoLongitud!=''){  $SIS_data .= ",'".$GeoLongitud."'"; }else{$SIS_data .= ",''";}
						//si no esta activa se guardan los datos por defecto
						}elseif(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==2){
							if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){   $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
							if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){ $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
						}
						$SIS_data .= ",'1'";                                                                                                                                        //idTipo
						$SIS_data .= ",'El grupo ".DeSanitizar($alarmas[0]['Nombre'])." de Sensores esta marcando una diferencia de mas del ".$alarmas[0]['valor_diferencia']."%'"; //Descripcion
						$SIS_data .= ",'".$alarmas[0]['valor_diferencia']."'";                                                                                                      //Valor
						//El timestamp
						if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
							$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'1'";                  //indica que es personalizada
						$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
						$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

						/*******************************************************/
						// inserto los datos de registro en la db
						$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
						$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

						/******************************************************/
						//se guarda alerta para enviarla por correo
						//verifico el tipo de alerta
						if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
							//tipo de alertas
							switch ($idTipoAlerta) {
								//Normal
								case 1:
									$Alertas_perso .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta marcando una diferencia de mas del '.$alarmas[0]['valor_diferencia'].'% <br/>';
									break;
								//Catastrofica
								case 2:
									$Alertas_criticas .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta marcando una diferencia de mas del '.$alarmas[0]['valor_diferencia'].'% <br/>';
									break;
							}
						}

						//Sumo los datos
						$NErroresTempx = $NErroresTempx + 1;
						$NAlertas      = $NAlertas + 1;

						/******************************************************/
						//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					//si son inferiores, pero marca error se suman
					}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
						//se suma 1 a los errores
						$NErroresActual  = $NErroresActual + 1;
						//se actualizasolo si el numero de errores maximo esta configurado
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
						}
					//si no reseteo a 0
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}
				}else{
					updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
				}
				break;

			/*********************************************************************************/
			//Alertas Personalizadas (al menos 1 error)
			case 3:
				//se crea variable temporal
				$xn_temp       = 0;
				$n_error_count = 0;
				$n_error_txt   = '';
				//se recorre el arreglo
				foreach ($xn_matriz as $mat) {
					$xn_temp++;
					if(($mat>$xn_matrizRangos[$xn_temp]['Rango_fin'] OR $mat<$xn_matrizRangos[$xn_temp]['Rango_ini']) && $mat < 99900){
						//cuento la cantidad de errores
						$n_error_count++;
						//se crea texto
						$n_error_txt .= '<br/>El sensor '.DeSanitizar($rowData['SensoresNombre_'.$alarmas[0]['Sensor_N']]).' esta fuera de rango ';
						$n_error_txt .= '('.$mat.')';
					}
				}

				/********************************************************/
				//si hay errores
				if($n_error_count!=0){
					//se validan que los errores actuales sean superiores a los errores maximo
					if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){

						//Se guardan los errores en la tabla de errores
						if(isset($idSistema) && $idSistema!=''){        $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
						if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'";  }else{$SIS_data .= ",''";}
						if(isset($FechaSistema) && $FechaSistema!=''){  $SIS_data .= ",'".$FechaSistema."'";  }else{$SIS_data .= ",''";}
						if(isset($HoraSistema) && $HoraSistema!=''){    $SIS_data .= ",'".$HoraSistema."'";   }else{$SIS_data .= ",''";}
						$SIS_data .= ",'0'";  //Valor_min
						$SIS_data .= ",'0'";  //Valor_max
						//Se verifica si tiene la funcion de geolocalizacion activa
						//si esta activa se guardan los ultimos datos
						if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
							if(isset($GeoLatitud) && $GeoLatitud!=''){    $SIS_data .= ",'".$GeoLatitud."'";   }else{$SIS_data .= ",''";}
							if(isset($GeoLongitud) && $GeoLongitud!=''){  $SIS_data .= ",'".$GeoLongitud."'";  }else{$SIS_data .= ",''";}
						//si no esta activa se guardan los datos por defecto
						}elseif(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==2){
							if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){   $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
							if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){ $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
						}
						$SIS_data .= ",'1'";                                                              //idTipo
						$SIS_data .= ",'Alerta ".DeSanitizar($alarmas[0]['Nombre']).":".$n_error_txt."'"; //Descripcion
						$SIS_data .= ",''";                                                               //Valor
						//El timestamp
						if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
							$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'1'";                  //indica que es personalizada
						$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
						$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

						/*******************************************************/
						// inserto los datos de registro en la db
						$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
						$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

						/******************************************************/
						//se guarda alerta para enviarla por correo
						//verifico el tipo de alerta
						if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
							//tipo de alertas
							switch ($idTipoAlerta) {
								//Normal
								case 1:
									$Alertas_perso .= ' - '.DeSanitizar($alarmas[0]['Nombre']).':'.$n_error_txt.'<br/>';
									break;
								//Catastrofica
								case 2:
									$Alertas_criticas .= ' - '.DeSanitizar($alarmas[0]['Nombre']).':'.$n_error_txt.'<br/>';
									break;
							}
						}

						//Sumo los datos
						$NErroresTempx = $NErroresTempx + 1;
						$NAlertas      = $NAlertas + 1;

						/******************************************************/
						//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					//si son inferiores, pero marca error se suman
					}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
						//se suma 1 a los errores
						$NErroresActual  = $NErroresActual + 1;
						//se actualizasolo si el numero de errores maximo esta configurado
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
						}
					//si no reseteo a 0
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}
				//si no hay errores
				}else{
					updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
				}

			break;
			/*********************************************************************************/
			//Alertas Personalizadas (todos con error)
			case 4:
				//se crea variable temporal
				$xn_temp       = 0;
				$xn_temp2      = 0;
				//se recorre el arreglo
				foreach ($xn_matriz as $mat) {
					$xn_temp++;
					if(($mat>$xn_matrizRangos[$xn_temp]['Rango_fin'] OR $mat<$xn_matrizRangos[$xn_temp]['Rango_ini']) && $mat < 99900){
						$xn_temp2++;
					}
				}
				/********************************************************/
				//si hay errores
				if($xn_sen_activo==$xn_temp2){
					//se validan que los errores actuales sean superiores a los errores maximo
					if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){

						//Se guardan los errores en la tabla de errores
						if(isset($idSistema) && $idSistema!=''){        $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
						if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'";  }else{$SIS_data .= ",''";}
						if(isset($FechaSistema) && $FechaSistema!=''){  $SIS_data .= ",'".$FechaSistema."'";  }else{$SIS_data .= ",''";}
						if(isset($HoraSistema) && $HoraSistema!=''){    $SIS_data .= ",'".$HoraSistema."'";   }else{$SIS_data .= ",''";}
						$SIS_data .= ",'0'";  //Valor_min
						$SIS_data .= ",'0'";  //Valor_max
						//Se verifica si tiene la funcion de geolocalizacion activa
						//si esta activa se guardan los ultimos datos
						if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
							if(isset($GeoLatitud) && $GeoLatitud!=''){   $SIS_data .= ",'".$GeoLatitud."'";    }else{$SIS_data .= ",''";}
							if(isset($GeoLongitud) && $GeoLongitud!=''){ $SIS_data .= ",'".$GeoLongitud."'";   }else{$SIS_data .= ",''";}
						//si no esta activa se guardan los datos por defecto
						}elseif(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==2){
							if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){   $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
							if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){ $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
						}
						$SIS_data .= ",'1'";                                             //idTipo
						$SIS_data .= ",'Alerta ".DeSanitizar($alarmas[0]['Nombre'])."'"; //Descripcion
						$SIS_data .= ",''";                                              //Valor
						//El timestamp
						if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
							$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'1'";                  //indica que es personalizada
						$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
						$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

						/*******************************************************/
						// inserto los datos de registro en la db
						$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
						$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

						/******************************************************/
						//se guarda alerta para enviarla por correo
						//verifico el tipo de alerta
						if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
							//tipo de alertas
							switch ($idTipoAlerta) {
								//Normal
								case 1:
									$Alertas_perso .= ' - <strong>'.DeSanitizar($alarmas[0]['Nombre']).'</strong><br/>';
									break;
								//Catastrofica
								case 2:
									$Alertas_criticas .= ' - <strong>'.DeSanitizar($alarmas[0]['Nombre']).'</strong><br/>';
									break;
							}
						}

						//Sumo los datos
						$NErroresTempx = $NErroresTempx + 1;
						$NAlertas      = $NAlertas + 1;

						/******************************************************/
						//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					//si son inferiores, pero marca error se suman
					}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
						//se suma 1 a los errores
						$NErroresActual  = $NErroresActual + 1;
						//se actualizasolo si el numero de errores maximo esta configurado
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
						}
					//si no reseteo a 0
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}
				//si no hay errores
				}else{
					updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
				}

			break;
			/*********************************************************************************/
			//Promedios fuera de Rangos
			case 5:
				//variables
				$int_sum_var   = 0;
				$int_sum_count = 0;
				$int_sum_prom  = 0;

				//Reviso los valores
				foreach ($alarmas as $alarma) {
					if(isset($Sensor[$alarma['Sensor_N']]['valor'])&&$Sensor[$alarma['Sensor_N']]['valor']!=''&& $Sensor[$alarma['Sensor_N']]['valor'] < 99900){
						$int_sum_var   = $int_sum_var + $Sensor[$alarma['Sensor_N']]['valor'];
						$int_sum_count++;
					}
				}

				//obtengo el promedio
				if($int_sum_count!=0){
					//obtengo el promedio
					$int_sum_prom = $int_sum_var/$int_sum_count;

					//Reviso que este fuera de rango
					if($int_sum_prom!=0&&($int_sum_prom<$alarmas[0]['AlarmIni'] OR $int_sum_prom>$alarmas[0]['AlarmFin'])){
						//se validan que los errores actuales sean superiores a los errores maximo
						if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){
							//Se guardan los errores en la tabla de errores
							if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
							if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data .= ",'".$idTelemetria."'";  }else{$SIS_data .= ",''";}
							if(isset($FechaSistema) && $FechaSistema!=''){   $SIS_data .= ",'".$FechaSistema."'";  }else{$SIS_data .= ",''";}
							if(isset($HoraSistema) && $HoraSistema!=''){     $SIS_data .= ",'".$HoraSistema."'";   }else{$SIS_data .= ",''";}
							$SIS_data .= ",'".$alarmas[0]['AlarmIni']."'";
							$SIS_data .= ",'".$alarmas[0]['AlarmFin']."'";
							//Se verifica si tiene la funcion de geolocalizacion activa
							//si esta activa se guardan los ultimos datos
							if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''){
								switch ($rowData['id_Geo']) {
									case 1:
										if(isset($GeoLatitud) && $GeoLatitud!=''){    $SIS_data .= ",'".$GeoLatitud."'";   }else{$SIS_data .= ",''";}
										if(isset($GeoLongitud) && $GeoLongitud!=''){  $SIS_data .= ",'".$GeoLongitud."'";  }else{$SIS_data .= ",''";}
										break;
									case 2:
										if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){   $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
										if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){ $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
										break;
								}
							}else{
								$SIS_data .= ",''"; //GeoLatitud
								$SIS_data .= ",''"; //GeoLongitud
							}
							$SIS_data .= ",'1'";                                                                                             //idTipo
							$SIS_data .= ",'El grupo ".DeSanitizar($alarmas[0]['Nombre'])." de Sensores esta fuera del promedio de rangos'"; //Descripcion
							$SIS_data .= ",'".$int_sum_prom."'";                                                                             //Valor
							//El timestamp
							if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
								$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
							}else{
								$SIS_data .= ",''";
							}
							$SIS_data .= ",'1'";                  //indica que es personalizada
							$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
							$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

							/*******************************************************/
							// inserto los datos de registro en la db
							$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
							$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

							/******************************************************/
							//se guarda alerta para enviarla por correo
							//verifico el tipo de alerta
							if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
								//tipo de alertas
								switch ($idTipoAlerta) {
									//Normal
									case 1:
										$Alertas_perso .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta fuera de rango: ';
										$Alertas_perso .= '<strong>'.Cantidades($int_sum_prom, 2).DeSanitizar($alarmas[0]['Unimed']).'</strong> | (Rango óptimo '.Cantidades($alarmas[0]['AlarmIni'], 2).DeSanitizar($alarmas[0]['Unimed']).' / '.Cantidades($alarmas[0]['AlarmFin'], 2).DeSanitizar($alarmas[0]['Unimed']).') <br/>';
										break;
									//Catastrofica
									case 2:
										$Alertas_criticas .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta fuera de rango: ';
										$Alertas_criticas .= '<strong>'.Cantidades($int_sum_prom, 2).DeSanitizar($alarmas[0]['Unimed']).'</strong> | (Rango óptimo '.Cantidades($alarmas[0]['AlarmIni'], 2).DeSanitizar($alarmas[0]['Unimed']).' / '.Cantidades($alarmas[0]['AlarmFin'], 2).DeSanitizar($alarmas[0]['Unimed']).') <br/>';
										break;
								}
							}

							//Sumo los datos
							$NErroresTempx = $NErroresTempx + 1;
							$NAlertas      = $NAlertas + 1;

							/******************************************************/
							//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
							if($NErroresMax!=0){
								updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
							}
						//si son inferiores, pero marca error se suman
						}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
							//se suma 1 a los errores
							$NErroresActual  = $NErroresActual + 1;
							//se actualizasolo si el numero de errores maximo esta configurado
							if($NErroresMax!=0){
								updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
							}
						//si no reseteo a 0
						}else{
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}
				}

			break;
			/*********************************************************************************/
			//Alertas Personalizadas (todos con valor especifico)
			case 6:
				//se crea variable temporal
				$xn_temp       = 0;
				$xn_temp2      = 0;
				//se recorre el arreglo
				foreach ($xn_matriz as $mat) {
					$xn_temp++;
					if($mat==$xn_matrizRangos[$xn_temp]['valor_especifico'] && $mat < 99900){
						$xn_temp2++;
					}
				}

				/********************************************************/
				//si hay errores
				if($xn_sen_activo==$xn_temp2){
					//se validan que los errores actuales sean superiores a los errores maximo
					if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){

						//Se guardan los errores en la tabla de errores
						if(isset($idSistema) && $idSistema!=''){        $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
						if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}
						if(isset($FechaSistema) && $FechaSistema!=''){  $SIS_data .= ",'".$FechaSistema."'";   }else{$SIS_data .= ",''";}
						if(isset($HoraSistema) && $HoraSistema!=''){    $SIS_data .= ",'".$HoraSistema."'";    }else{$SIS_data .= ",''";}
						$SIS_data .= ",'0'";  //Valor_min
						$SIS_data .= ",'0'";  //Valor_max
						//Se verifica si tiene la funcion de geolocalizacion activa
						//si esta activa se guardan los ultimos datos
						if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
							if(isset($GeoLatitud) && $GeoLatitud!=''){    $SIS_data .= ",'".$GeoLatitud."'";  }else{$SIS_data .= ",''";}
							if(isset($GeoLongitud) && $GeoLongitud!=''){  $SIS_data .= ",'".$GeoLongitud."'"; }else{$SIS_data .= ",''";}
						//si no esta activa se guardan los datos por defecto
						}elseif(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==2){
							if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){    $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
							if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){  $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
						}
						$SIS_data .= ",'1'";                                             //idTipo
						$SIS_data .= ",'Alerta ".DeSanitizar($alarmas[0]['Nombre'])."'"; //Descripcion
						$SIS_data .= ",''";                                              //Valor
						//El timestamp
						if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
							$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'1'";                  //indica que es personalizada
						$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
						$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

						/*******************************************************/
						// inserto los datos de registro en la db
						$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
						$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

						/******************************************************/
						//se guarda alerta para enviarla por correo
						//verifico el tipo de alerta
						if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
							//tipo de alertas
							switch ($idTipoAlerta) {
								//Normal
								case 1:
									$Alertas_perso .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' todos sus sensores con valor especifico <br/>';
									break;
								//Catastrofica
								case 2:
									$Alertas_criticas .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' todos sus sensores con valor especifico <br/>';
									break;
							}
						}

						//Sumo los datos
						$NErroresTempx = $NErroresTempx + 1;
						$NAlertas      = $NAlertas + 1;

						/******************************************************/
						//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					//si son inferiores, pero marca error se suman
					}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
						//se suma 1 a los errores
						$NErroresActual  = $NErroresActual + 1;
						//se actualizasolo si el numero de errores maximo esta configurado
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
						}
					//si no reseteo a 0
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}
				//si no hay errores
				}else{
					updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
				}

			break;
			/*********************************************************************************/
			//Sensor funcionando fuera de horario
			case 7:
				//se crea variable temporal
				$xn_temp       = 0;
				$xn_temp2      = 0;
				//se recorre el arreglo
				foreach ($xn_matriz as $mat) {
					$xn_temp++;
					if($mat==$xn_matrizRangos[$xn_temp]['valor_especifico'] && $mat < 99900){
						//Si esta correctamente configurada
						if($alarmas[0]['HoraIni']<$alarmas[0]['HoraFin']){
							//Verifico si esta dentro del horario
							if($HoraSistema>$alarmas[0]['HoraIni']&&$HoraSistema<$alarmas[0]['HoraFin']){
								//nada
							//cuento
							}else{
								$xn_temp2++;
							}
						//Si esta configurada al reves
						}else{
							//Verifico si esta dentro del horario
							if($HoraSistema>$alarmas[0]['HoraFin']&&$HoraSistema<$alarmas[0]['HoraIni']){
								//nada
							//cuento
							}else{
								$xn_temp2++;
							}
						}
					}
				}

				/********************************************************/
				//si hay errores
				if($xn_temp2!=0){
					//se validan que los errores actuales sean superiores a los errores maximo
					if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){

						//Se guardan los errores en la tabla de errores
						if(isset($idSistema) && $idSistema!=''){        $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
						if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}
						if(isset($FechaSistema) && $FechaSistema!=''){  $SIS_data .= ",'".$FechaSistema."'";   }else{$SIS_data .= ",''";}
						if(isset($HoraSistema) && $HoraSistema!=''){    $SIS_data .= ",'".$HoraSistema."'";    }else{$SIS_data .= ",''";}
						$SIS_data .= ",'0'";  //Valor_min
						$SIS_data .= ",'0'";  //Valor_max
						//Se verifica si tiene la funcion de geolocalizacion activa
						//si esta activa se guardan los ultimos datos
						if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
							if(isset($GeoLatitud) && $GeoLatitud!=''){    $SIS_data .= ",'".$GeoLatitud."'";  }else{$SIS_data .= ",''";}
							if(isset($GeoLongitud) && $GeoLongitud!=''){  $SIS_data .= ",'".$GeoLongitud."'"; }else{$SIS_data .= ",''";}
						//si no esta activa se guardan los datos por defecto
						}elseif(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==2){
							if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){    $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
							if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){  $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
						}
						$SIS_data .= ",'1'";                                             //idTipo
						$SIS_data .= ",'Alerta ".DeSanitizar($alarmas[0]['Nombre'])."'"; //Descripcion
						$SIS_data .= ",''";                                              //Valor
						//El timestamp
						if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
							$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'1'";                  //indica que es personalizada
						$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
						$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

						/*******************************************************/
						// inserto los datos de registro en la db
						$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
						$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

						/******************************************************/
						//se guarda alerta para enviarla por correo
						//verifico el tipo de alerta
						if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
							//tipo de alertas
							switch ($idTipoAlerta) {
								//Normal
								case 1:
									$Alertas_perso .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' sensor funcionando fuera de horario <br/>';
									break;
								//Catastrofica
								case 2:
									$Alertas_criticas .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' sensor funcionando fuera de horario <br/>';
									break;
							}
						}

						//Sumo los datos
						$NErroresTempx = $NErroresTempx + 1;
						$NAlertas      = $NAlertas + 1;

						/******************************************************/
						//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					//si son inferiores, pero marca error se suman
					}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
						//se suma 1 a los errores
						$NErroresActual  = $NErroresActual + 1;
						//se actualizasolo si el numero de errores maximo esta configurado
						if($NErroresMax!=0){
							updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
						}
					//si no reseteo a 0
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}
				//si no hay errores
				}else{
					updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
				}

			break;
			/*********************************************************************************/
			//Promedios dentro de Rangos
			case 8:
				//variables
				$int_sum_var   = 0;
				$int_sum_count = 0;
				$int_sum_prom  = 0;

				//Reviso los valores
				foreach ($alarmas as $alarma) {
					if(isset($Sensor[$alarma['Sensor_N']]['valor'])&&$Sensor[$alarma['Sensor_N']]['valor']!=''&& $Sensor[$alarma['Sensor_N']]['valor'] < 99900){
						$int_sum_var   = $int_sum_var + $Sensor[$alarma['Sensor_N']]['valor'];
						$int_sum_count++;
					}
				}

				//obtengo el promedio
				if($int_sum_count!=0){
					//obtengo el promedio
					$int_sum_prom = $int_sum_var/$int_sum_count;

					//Reviso que este dentro de rango
					if($int_sum_prom!=0&&($int_sum_prom>$alarmas[0]['AlarmIni'] OR $int_sum_prom<$alarmas[0]['AlarmFin'])){
						//se validan que los errores actuales sean superiores a los errores maximo
						if((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax<=$NErroresActual){
							//Se guardan los errores en la tabla de errores
							if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
							if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data .= ",'".$idTelemetria."'";  }else{$SIS_data .= ",''";}
							if(isset($FechaSistema) && $FechaSistema!=''){   $SIS_data .= ",'".$FechaSistema."'";  }else{$SIS_data .= ",''";}
							if(isset($HoraSistema) && $HoraSistema!=''){     $SIS_data .= ",'".$HoraSistema."'";   }else{$SIS_data .= ",''";}
							$SIS_data .= ",'".$alarmas[0]['AlarmIni']."'";
							$SIS_data .= ",'".$alarmas[0]['AlarmFin']."'";
							//Se verifica si tiene la funcion de geolocalizacion activa
							//si esta activa se guardan los ultimos datos
							if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''){
								switch ($rowData['id_Geo']) {
									case 1:
										if(isset($GeoLatitud) && $GeoLatitud!=''){    $SIS_data .= ",'".$GeoLatitud."'";   }else{$SIS_data .= ",''";}
										if(isset($GeoLongitud) && $GeoLongitud!=''){  $SIS_data .= ",'".$GeoLongitud."'";  }else{$SIS_data .= ",''";}
										break;
									case 2:
										if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){   $SIS_data .= ",'".$rowData['GeoLatitud']."'";  }else{$SIS_data .= ",''";}
										if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){ $SIS_data .= ",'".$rowData['GeoLongitud']."'"; }else{$SIS_data .= ",''";}
										break;
								}
							}else{
								$SIS_data .= ",''"; //GeoLatitud
								$SIS_data .= ",''"; //GeoLongitud
							}
							$SIS_data .= ",'1'";                                                                                             //idTipo
							$SIS_data .= ",'El grupo ".DeSanitizar($alarmas[0]['Nombre'])." de Sensores esta fuera del promedio de rangos'"; //Descripcion
							$SIS_data .= ",'".$int_sum_prom."'";                                                                             //Valor
							//El timestamp
							if(isset($FechaSistema) && $FechaSistema != ''&&isset($HoraSistema) && $HoraSistema!=''){
								$SIS_data .= ",'".$FechaSistema." ".$HoraSistema."'";
							}else{
								$SIS_data .= ",''";
							}
							$SIS_data .= ",'1'";                  //indica que es personalizada
							$SIS_data .= ",'".$idTipoAlerta."'";  //prioridad alerta (normal-catastrofica)
							$SIS_data .= ",'".$idUniMed."'";      //unidad de medida de la alerta

							/*******************************************************/
							// inserto los datos de registro en la db
							$SIS_columns   = 'idSistema, idTelemetria, Fecha, Hora, Valor_min, Valor_max, GeoLatitud, GeoLongitud, idTipo, Descripcion, Valor, TimeStamp, idPersonalizado, idTipoAlerta,idUniMed';
							$insertAlertas = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_errores', $dbConn, 'insertAlertas', basename($_SERVER["REQUEST_URI"], ".php"), 'insertAlertas');

							/******************************************************/
							//se guarda alerta para enviarla por correo
							//verifico el tipo de alerta
							if(isset($idTipoAlerta)&&$idTipoAlerta!=''){
								//tipo de alertas
								switch ($idTipoAlerta) {
									//Normal
									case 1:
										$Alertas_perso .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta fuera de rango: ';
										$Alertas_perso .= '<strong>'.Cantidades($int_sum_prom, 2).DeSanitizar($alarmas[0]['Unimed']).'</strong> | (Rango óptimo '.Cantidades($alarmas[0]['AlarmIni'], 2).DeSanitizar($alarmas[0]['Unimed']).' / '.Cantidades($alarmas[0]['AlarmFin'], 2).DeSanitizar($alarmas[0]['Unimed']).') <br/>';
										break;
									//Catastrofica
									case 2:
										$Alertas_criticas .= ' - '.DeSanitizar($alarmas[0]['Nombre']).' esta fuera de rango: ';
										$Alertas_criticas .= '<strong>'.Cantidades($int_sum_prom, 2).DeSanitizar($alarmas[0]['Unimed']).'</strong> | (Rango óptimo '.Cantidades($alarmas[0]['AlarmIni'], 2).DeSanitizar($alarmas[0]['Unimed']).' / '.Cantidades($alarmas[0]['AlarmFin'], 2).DeSanitizar($alarmas[0]['Unimed']).') <br/>';
										break;
								}
							}

							//Sumo los datos
							$NErroresTempx = $NErroresTempx + 1;
							$NAlertas      = $NAlertas + 1;

							/******************************************************/
							//se resetea el numero de alertas en la alarma personalizada solo si los errores maximos estan configurados
							if($NErroresMax!=0){
								updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
							}
						//si son inferiores, pero marca error se suman
						}elseif((($NErroresMax!=0&&$NErroresActual>=0) OR ($NErroresMax==0&&$NErroresActual==0))&&$NErroresMax>$NErroresActual){
							//se suma 1 a los errores
							$NErroresActual  = $NErroresActual + 1;
							//se actualizasolo si el numero de errores maximo esta configurado
							if($NErroresMax!=0){
								updateAlarmaPerso($cat_idAlarma, $NErroresActual,$dbConn );
							}
						//si no reseteo a 0
						}else{
							updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
						}
					}else{
						updateAlarmaPerso($cat_idAlarma, 0,$dbConn );
					}
				}

			break;

		}

	//Si no estan activos genero un log
	}else{

		//obtengo total sensores inactivos
		$nSensAct = $xn_sen_revisado - $xn_sen_activo;

		//genero la alerta
		$Alert  = $FechaSistema.' '.$HoraSistema;
		$Alert .= ' - Error en alertas personalizadas:';
		$Alert .= ' Hay '.$nSensAct.' sensores inactivos en el equipo ID '. $idTelemetria;
		$Alert .= ' del grupo '.DeSanitizar($alarmas[0]['Nombre']);

		//se genera error
		$Error_data = $Alert."\n";

		//se guarda en el archivo
		EscribirLog($ardu_file_alerts, $Error_data, 5);

	}

}

//se actualizael numero de alertas pendientes de ver, se resetean desde la plataforma
$chainxMain .= ",NAlertas='".$NAlertas."'";
//Numero de errores actuales, se utiliza para mostrar los equipos con errores
if($NErroresTempx!=0){
	$chainxMain .= ",NErrores='".($NErrores+$NErroresTempx)."'";
}else{
	$chainxMain .= ",NErrores='0'";
}

?>
