<?php
//si se ha ingresado el isistema
if(isset($SISTEMA)&&$SISTEMA!=''){

	//Variables
	$idSistema        = $SISTEMA;
	$HoraSistema      = hora_actual();
	$FechaSistema     = fecha_actual();
	$TimeStamp        = fecha_actual().' '.hora_actual();
	$Count_Data       = 0;
	$Rev_Grupo        = 1; //1= si, 0=no
	$Rev_Equipo       = 1; //1= si, 0=no

	/**************************************************************************************/
	/*                                       CONSULTAS                                    */
	/**************************************************************************************/
	//Obtencion de datos del sistema
	$SIS_query = 'CrossTech_TempMin, CrossTech_TempMax, CrossTech_FechaTempMin,
	CrossTech_FechaTempMax, CrossTech_FechaUnidadFrio, CrossTech_DiasTempMin,
	CrossTech_FechaDiasTempMin, CrossTech_HoraPrevRev, CrossTech_HoraPrevision,
	CrossTech_HoraPrevCuenta, CrossTech_HeladaTemp, Nombre,CrossTech_HeladaMailHoraIni,
	CrossTech_HeladaMailHoraTerm';
	$rowSistema = db_select_data (false, $SIS_query, 'core_sistemas','', 'idSistema = "'.$idSistema.'"', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

	//Obtencion de datos de la medicion anterior
	$SIS_query = 'Fecha, Hora, HorasBajoGrados, HorasSobreGrados, UnidadesFrio,
	CrossTech_TempMin,CrossTech_TempMax, CrossTech_FechaTempMin, CrossTech_FechaTempMax,
	CrossTech_FechaUnidadFrio, CrossTech_DiasTempMin, CrossTech_FechaDiasTempMin,
	Dias_acumulado,Dias_anterior';
	$rowAux = db_select_data (false, $SIS_query, 'telemetria_listado_aux', '', 'idSistema = "'.$idSistema.'" ORDER BY idAuxiliar DESC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowAux');

	/**************************************************************************************/
	/*                                  OBTENCION DE DATOS                                */
	/**************************************************************************************/
	//Horas de revision de la base de datos
	if(isset($rowSistema['CrossTech_HoraPrevRev'])&&$rowSistema['CrossTech_HoraPrevRev']!='00:00:00'){
		$h_Retroceso   = $rowSistema['CrossTech_HoraPrevRev'];
	}else{
		$h_Retroceso   = '04:00:00';
	}
	//Prevision de las temperaturas
	if(isset($rowSistema['CrossTech_HoraPrevision'])&&$rowSistema['CrossTech_HoraPrevision']!='00:00:00'){
		$h_Prediccion  = $rowSistema['CrossTech_HoraPrevision'];
	}else{
		$h_Prediccion  = '03:00:00';
	}
	//Numero de Predicciones de las temperaturas (Considerar las seleccionadas en la BD)
	if(isset($rowSistema['CrossTech_HoraPrevCuenta'])&&$rowSistema['CrossTech_HoraPrevCuenta']!='0'){
		$n_Prediccion  = $rowSistema['CrossTech_HoraPrevCuenta'];
	}else{
		$n_Prediccion  = 50;
	}

	//Se calcula lapso de tiempo condicionando dias hacia atras
	$Hora_real   = restahoras($h_Retroceso,$HoraSistema);
	$Fecha_real  = $FechaSistema;
	if($HoraSistema<$h_Retroceso){
		$Fecha_real = restarDias($FechaSistema,1);
	}

	//Se calcula prediccion de tiempo condicionando dias hacia adelante
	$Hora_Prediccion   = sumahoras($h_Prediccion,$HoraSistema);
	$Fecha_Prediccion  = $FechaSistema;
	if($Hora_Prediccion>'24:00:00'){
		$Hora_Prediccion   = restahoras('24:00:00',$Hora_Prediccion);
		$Fecha_Prediccion  = sumarDias($Fecha_Prediccion,1);
	}

	/**************************************************************************************/
	/*                                       CONSULTAS                                    */
	/**************************************************************************************/
	//Obtengo todos los equipos de telemetria activos
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento desactivado
	$SIS_where .= " AND telemetria_listado.id_Geo = 2";
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 4"; //Agro-Weather

	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}

	//numero sensores equipo
	$N_Maximo_Sensores = 20;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	//Listar los equipos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.cantSensores,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.id_Sensores '.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria   = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria       = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/*************************************************************/
	//variables vacias de grupo
	$counter           = 0;
	$Helada            = 0;
	$Tiempo_Helada     = 0;
	$minutos_1         = 0;
	$minutos_2         = 0;
	$nCorreosGrupo     = 0;
	$Total_Temperatura = 0;
	$Total_Humedad     = 0;
	$Total_Rocio       = 0;
	$Total_Presion     = 0;

	//variables vacias de equipo
	$counterEquip        = 0;
	$HeladaEquip         = 0;
	$Tiempo_HeladaEquip  = 0;
	$minutos_1_Equip     = 0;
	$minutos_2_Equip     = 0;
	$nCorreosEquipo      = 0;

	//variables vacias de envio de correos
	$EmailTitulo       = '';
	$EmailCuerpo       = '';
	$EmailCuerpoGrupo  = '';
	$EmailCuerpoEquipo = '';

	/************************************************************/
	//Verifico si esta configurado para que revise los grupos
	if(isset($Rev_Grupo)&&$Rev_Grupo==1){
		/************************************************************/
		//consulta
		$arrPrevision = array();
		$arrPrevision = db_select_array (false, 'Temperatura', 'telemetria_listado_aux', '', 'idSistema='.$idSistema.' AND `TimeStamp` >="'.$Fecha_real.' '.$Hora_real.'"', 'idAuxiliar ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

		/*************************************************************/
		//Se sacan calculos
		foreach ($arrEquipo as $data) {

			/**********************************************/
			//Se resetean
			$in_eq_fueralinea  = 0;

			/**********************************************/
			//Fuera de linea
			$diaInicio   = $data['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $data['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
			}

			/*******************************************************/
			//verifico que este midiendo
			if($in_eq_fueralinea==0){

				/*************************************************************/
				//variables
				$Total_Temperatura = $Total_Temperatura + $data['SensoresMedActual_1'];
				$Total_Humedad     = $Total_Humedad + $data['SensoresMedActual_2'];
				$Total_Rocio       = $Total_Rocio + $data['SensoresMedActual_3'];
				$Total_Presion     = $Total_Presion + $data['SensoresMedActual_4'];
				$Count_Data++;
			}
		}
		/**************************************************************************************/
		/*                                       CALCULOS                                     */
		/**************************************************************************************/
		//Se insertan datos en la tabla auxiliar
		if($Count_Data!=0){

			/*************************************************************/
			//variables
			$Temperatura_Actual   = str_replace(",", ".",Cantidades(($Total_Temperatura / $Count_Data), 2));
			$Humedad_Actual       = str_replace(",", ".",Cantidades(($Total_Humedad / $Count_Data), 2));
			$Rocio_Actual         = str_replace(",", ".",Cantidades(($Total_Rocio / $Count_Data), 2));
			$Presion_Actual       = str_replace(",", ".",Cantidades(($Total_Presion / $Count_Data), 2));

			/*************************************************************/
			//Calculo de helada
			$arrContador     = array();
			$arrTemperatura  = array();

			foreach ($arrPrevision as $prev) {
				$arrContador[$counter][0]   = $counter;
				$arrTemperatura[$counter]   = cantidades_google(cantidades($prev['Temperatura'], 2));
				$counter++;
			}
			if($counter>1){
				$regression = new Phpml\Regression\LeastSquares();
				$regression->train($arrContador, $arrTemperatura);
				//se guarda dato (60 datos por 5 horas + 36 datos por 3 horas a futuro)
				$Helada = $regression->predict([$n_Prediccion]);
			}

			/*************************************************************/
			//Mientras la hora actual sea superior a la ultima hora registrada
			if(isset($rowAux['Hora'])&&$rowAux['Hora']!=''){
				if($HoraSistema>$rowAux['Hora']){
					$minutos_transcurridos = restahoras($rowAux['Hora'],$HoraSistema);
				}else{
					//sumo tiempo para hacer la resta correctamente
					$Tiempo = sumahoras($HoraSistema,'24:00:00');
					$minutos_transcurridos = restahoras($rowAux['Hora'],$Tiempo);
				}
			}else{
				$minutos_transcurridos = 0;
			}

			//conversion
			$minutos_1  = horas2minutos($minutos_transcurridos);
			$minutos_2 = $minutos_1;
			//valido que sea un numero el resultado
			if (validarNumero($minutos_1)&&$minutos_1!=''){
				$minutos_1 = $minutos_1/60;
			}else{
				$minutos_1 = 0;
			}

			//si la temperatura general esta bajo cierta temperatura
			if($Temperatura_Actual<$rowSistema['CrossTech_TempMin']){
				$HorasBajoGrados = $rowAux['HorasBajoGrados'] + $minutos_1;
				$Tiempo_Helada   = $minutos_1;
			}else{
				$HorasBajoGrados = $rowAux['HorasBajoGrados'];
			}
			//si la temperatura general esta sobre cierta temperatura
			if($Temperatura_Actual>$rowSistema['CrossTech_TempMax']){
				$HorasSobreGrados = $rowAux['HorasSobreGrados'] + $minutos_1;
			}else{
				$HorasSobreGrados = $rowAux['HorasSobreGrados'];
			}

			/*************************************************************/
			//Valor por defecto de las unidades de frio
			$UnidadesFrio = $rowAux['UnidadesFrio'];

			//calculo Unidades de frio
			if($Temperatura_Actual<1.4){
				$UnidadesFrio = $rowAux['UnidadesFrio'] + ((0 / 60) * $minutos_2);
			}elseif($Temperatura_Actual>=1.5&&$Temperatura_Actual<=2.4){
				$UnidadesFrio = $rowAux['UnidadesFrio'] + ((0.5 / 60) * $minutos_2);
			}elseif($Temperatura_Actual>=2.5&&$Temperatura_Actual<=9.1){
				$UnidadesFrio = $rowAux['UnidadesFrio'] + ((1.0 / 60) * $minutos_2);
			}elseif($Temperatura_Actual>=9.2&&$Temperatura_Actual<=12.4){
				$UnidadesFrio = $rowAux['UnidadesFrio'] + ((0.5 / 60) * $minutos_2);
			}elseif($Temperatura_Actual>=12.5&&$Temperatura_Actual<=15.9){
				$UnidadesFrio = $rowAux['UnidadesFrio'] + ((0 / 60) * $minutos_2);
			}elseif($Temperatura_Actual>=16&&$Temperatura_Actual<=18){
				$TempUnidadesFrio = $rowAux['UnidadesFrio'] - ((0.5 / 60) * $minutos_2);
				//solo si es mayor a 0
				if($TempUnidadesFrio>=0){$UnidadesFrio = $TempUnidadesFrio;}
			}elseif($Temperatura_Actual>=19){
				$TempUnidadesFrio = $rowAux['UnidadesFrio'] - ((1.0 / 60) * $minutos_2);
				//solo si es mayor a 0
				if($TempUnidadesFrio>=0){$UnidadesFrio = $TempUnidadesFrio;}
			}

			/*************************************************************/
			//se guardan datos de referencia
			if(isset($rowAux['CrossTech_DiasTempMin']) && $rowAux['CrossTech_DiasTempMin']!=''){             $CrossTech_DiasTempMin        = $rowAux['CrossTech_DiasTempMin'];         }else{$CrossTech_DiasTempMin        = $rowSistema['CrossTech_DiasTempMin'];}
			if(isset($rowAux['CrossTech_TempMin']) && $rowAux['CrossTech_TempMin']!=''){                     $CrossTech_TempMin            = $rowAux['CrossTech_TempMin'];             }else{$CrossTech_TempMin            = $rowSistema['CrossTech_TempMin'];}
			if(isset($rowAux['CrossTech_TempMax']) && $rowAux['CrossTech_TempMax']!=''){                     $CrossTech_TempMax            = $rowAux['CrossTech_TempMax'];             }else{$CrossTech_TempMax            = $rowSistema['CrossTech_TempMax'];}
			if(isset($rowAux['CrossTech_FechaDiasTempMin']) && $rowAux['CrossTech_FechaDiasTempMin']!=''){   $CrossTech_FechaDiasTempMin   = $rowAux['CrossTech_FechaDiasTempMin'];    }else{$CrossTech_FechaDiasTempMin   = $rowSistema['CrossTech_FechaDiasTempMin'];}
			if(isset($rowAux['CrossTech_FechaTempMin']) && $rowAux['CrossTech_FechaTempMin']!=''){           $CrossTech_FechaTempMin       = $rowAux['CrossTech_FechaTempMin'];        }else{$CrossTech_FechaTempMin       = $rowSistema['CrossTech_FechaTempMin'];}
			if(isset($rowAux['CrossTech_FechaTempMax']) && $rowAux['CrossTech_FechaTempMax']!=''){           $CrossTech_FechaTempMax       = $rowAux['CrossTech_FechaTempMax'];        }else{$CrossTech_FechaTempMax       = $rowSistema['CrossTech_FechaTempMax'];}
			if(isset($rowAux['CrossTech_FechaUnidadFrio']) && $rowAux['CrossTech_FechaUnidadFrio']!=''){     $CrossTech_FechaUnidadFrio    = $rowAux['CrossTech_FechaUnidadFrio'];     }else{$CrossTech_FechaUnidadFrio    = $rowSistema['CrossTech_FechaUnidadFrio'];}
			if(isset($rowAux['Dias_acumulado']) && $rowAux['Dias_acumulado']!=''){                           $Dias_acumulado               = $rowAux['Dias_acumulado'];                }else{$Dias_acumulado               = 0;}
			if(isset($rowAux['Dias_anterior']) && $rowAux['Dias_anterior']!=''){                             $Dias_anterior                = $rowAux['Dias_anterior'];                 }else{$Dias_anterior                = 0;}
			if(isset($rowAux['Fecha']) && $rowAux['Fecha']!=''){                                             $Fecha_Anterior               = $rowAux['Fecha'];                         }else{$Fecha_Anterior               = $FechaSistema;}
			if(isset($rowAux['Hora']) && $rowAux['Hora']!=''){                                               $Hora_Anterior                = $rowAux['Hora'];                          }else{$Hora_Anterior                = $HoraSistema;}

			/*************************************************************/
			//Insertar datos
			if(isset($idSistema) && $idSistema!=''){                                    $a  = "'".$idSistema."'";                    }else{$a  = "''";}
			if(isset($FechaSistema) && $FechaSistema!=''){                              $a .= ",'".$FechaSistema."'";                }else{$a .= ",''";}
			if(isset($HoraSistema) && $HoraSistema!=''){                                $a .= ",'".$HoraSistema."'";                 }else{$a .= ",''";}
			if(isset($TimeStamp) && $TimeStamp!=''){                                    $a .= ",'".$TimeStamp."'";                   }else{$a .= ",''";}
			if(isset($Temperatura_Actual) && $Temperatura_Actual!=''){                  $a .= ",'".$Temperatura_Actual."'";          }else{$a .= ",''";}
			if(isset($Humedad_Actual) && $Humedad_Actual!=''){                          $a .= ",'".$Humedad_Actual."'";              }else{$a .= ",''";}
			if(isset($Rocio_Actual) && $Rocio_Actual!=''){                              $a .= ",'".$Rocio_Actual."'";                }else{$a .= ",''";}
			if(isset($Presion_Actual) && $Presion_Actual!=''){                          $a .= ",'".$Presion_Actual."'";              }else{$a .= ",''";}
			if(isset($Helada) && $Helada!=''){                                          $a .= ",'".$Helada."'";                      }else{$a .= ",''";}
			if(isset($Hora_Prediccion) && $Hora_Prediccion!=''){                        $a .= ",'".$Hora_Prediccion."'";             }else{$a .= ",''";}
			if(isset($Fecha_Prediccion) && $Fecha_Prediccion!=''){                      $a .= ",'".$Fecha_Prediccion."'";            }else{$a .= ",''";}
			if(isset($HorasBajoGrados) && $HorasBajoGrados!=''){                        $a .= ",'".$HorasBajoGrados."'";             }else{$a .= ",''";}
			if(isset($HorasSobreGrados) && $HorasSobreGrados!=''){                      $a .= ",'".$HorasSobreGrados."'";            }else{$a .= ",''";}
			if(isset($UnidadesFrio) && $UnidadesFrio!=''){                              $a .= ",'".$UnidadesFrio."'";                }else{$a .= ",''";}
			if(isset($CrossTech_DiasTempMin) && $CrossTech_DiasTempMin!=''){            $a .= ",'".$CrossTech_DiasTempMin."'";       }else{$a .= ",''";}
			if(isset($CrossTech_TempMin) && $CrossTech_TempMin!=''){                    $a .= ",'".$CrossTech_TempMin."'";           }else{$a .= ",''";}
			if(isset($CrossTech_TempMax) && $CrossTech_TempMax!=''){                    $a .= ",'".$CrossTech_TempMax."'";           }else{$a .= ",''";}
			if(isset($CrossTech_FechaDiasTempMin) && $CrossTech_FechaDiasTempMin!=''){  $a .= ",'".$CrossTech_FechaDiasTempMin."'";  }else{$a .= ",''";}
			if(isset($CrossTech_FechaTempMin) && $CrossTech_FechaTempMin!=''){          $a .= ",'".$CrossTech_FechaTempMin."'";      }else{$a .= ",''";}
			if(isset($CrossTech_FechaTempMax) && $CrossTech_FechaTempMax!=''){          $a .= ",'".$CrossTech_FechaTempMax."'";      }else{$a .= ",''";}
			if(isset($CrossTech_FechaUnidadFrio) && $CrossTech_FechaUnidadFrio!=''){    $a .= ",'".$CrossTech_FechaUnidadFrio."'";   }else{$a .= ",''";}
			if(isset($Dias_acumulado) && $Dias_acumulado!=''){                          $a .= ",'".$Dias_acumulado."'";              }else{$a .= ",''";}
			if(isset($Dias_anterior) && $Dias_anterior!=''){                            $a .= ",'".$Dias_anterior."'";               }else{$a .= ",''";}
			if(isset($Tiempo_Helada) && $Tiempo_Helada!=''){                            $a .= ",'".$Tiempo_Helada."'";               }else{$a .= ",''";}
			if(isset($Fecha_Anterior) && $Fecha_Anterior!=''){                          $a .= ",'".$Fecha_Anterior."'";              }else{$a .= ",''";}
			if(isset($Hora_Anterior) && $Hora_Anterior!=''){                            $a .= ",'".$Hora_Anterior."'";               }else{$a .= ",''";}
			if(isset($minutos_1) && $minutos_1!=''){                                    $a .= ",'".$minutos_1."'";                   }else{$a .= ",''";}

			// inserto los datos de registro en la db
			$query  = "INSERT INTO `telemetria_listado_aux` (idSistema, Fecha, Hora, TimeStamp, Temperatura,
			Humedad, PuntoRocio, PresionAtmos, Helada, HeladaHora, HeladaDia, HorasBajoGrados, HorasSobreGrados,
			UnidadesFrio, CrossTech_DiasTempMin, CrossTech_TempMin, CrossTech_TempMax, CrossTech_FechaDiasTempMin,
			CrossTech_FechaTempMin, CrossTech_FechaTempMax, CrossTech_FechaUnidadFrio, Dias_acumulado,
			Dias_anterior, Tiempo_Helada, Fecha_Anterior, Hora_Anterior, Tiempo_Transcurrido)
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

			//se configura para que envie correos
			if(isset($Helada)&&$Helada!=''&&$Helada!=0&&isset($rowSistema['Nombre'])&&$rowSistema['CrossTech_HeladaTemp']>$Helada){
				$nCorreosGrupo++;
				/*********************************************************************/
				//variables
				$EmailCuerpoGrupo.= '<p>Agro-Weather proyecta temperatura de '.cantidades($Helada, 2).' C a las ';
				$EmailCuerpoGrupo.= ' '.$Hora_Prediccion.' el '.fecha_estandar($Fecha_Prediccion).' en '.$rowSistema['Nombre'].'.</p>';

			}
		}
	}
	/************************************************************/
	//Verifico si esta configurado para que revise los equipos
	if(isset($Rev_Equipo)&&$Rev_Equipo==1){
		/************************************************************/
		//consulta
		$arrPrevision = array();
		$arrPrevision = db_select_array (false, 'Temperatura, idTelemetria', 'telemetria_listado_aux_equipo', '', 'idSistema='.$idSistema.' AND `TimeStamp` >="'.$Fecha_real.' '.$Hora_real.'"', 'idAuxiliar ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

		/*************************************************************/
		//Se sacan calculos
		foreach ($arrEquipo as $data) {

				//Obtencion de datos de la medicion anterior
			$SIS_query = 'Fecha, Hora, HorasBajoGrados, HorasSobreGrados, UnidadesFrio,
			CrossTech_TempMin,CrossTech_TempMax, CrossTech_FechaTempMin, CrossTech_FechaTempMax,
			CrossTech_FechaUnidadFrio, CrossTech_DiasTempMin, CrossTech_FechaDiasTempMin,
			Dias_acumulado,Dias_anterior';
			$rowAuxEquip = db_select_data (false, $SIS_query, 'telemetria_listado_aux_equipo', '', 'idSistema = "'.$idSistema.'" AND idTelemetria = "'.$data['idTelemetria'].'" ORDER BY idAuxiliar DESC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

			/**********************************************/
			//Se resetean
			$in_eq_fueralinea  = 0;

			/**********************************************/
			//Fuera de linea
			$diaInicio   = $data['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $data['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
			}

			/*******************************************************/
			//verifico que este midiendo
			if($in_eq_fueralinea==0){

				/*************************************************************/
				//variables
				$Temperatura_Actual   = str_replace(",", ".",Cantidades($data['SensoresMedActual_1'], 2));
				$Humedad_Actual       = str_replace(",", ".",Cantidades($data['SensoresMedActual_2'], 2));
				$Rocio_Actual         = str_replace(",", ".",Cantidades($data['SensoresMedActual_3'], 2));
				$Presion_Actual       = str_replace(",", ".",Cantidades($data['SensoresMedActual_4'], 2));

				/*************************************************************/
				//Calculo de helada
				$arrContador     = array();
				$arrTemperatura  = array();
				$counterEquip    = 0;

				foreach ($arrPrevision as $prev) {
					//verifico que sea el equipo correcto
					if($prev['idTelemetria']==$data['idTelemetria']){
						$arrContador[$counterEquip][0]   = $counterEquip;
						$arrTemperatura[$counterEquip]   = cantidades_google(cantidades($prev['Temperatura'], 2));
						$counterEquip++;
					}
				}
				if(isset($arrTemperatura)&&isset($arrContador)&&$counterEquip>1){
					$regression = new Phpml\Regression\LeastSquares();
					$regression->train($arrContador, $arrTemperatura);
					//se guarda dato (60 datos por 5 horas + 36 datos por 3 horas a futuro)
					$HeladaEquip = $regression->predict([$n_Prediccion]);
				}

				/*************************************************************/
				//Mientras la hora actual sea superior a la ultima hora registrada
				if(isset($rowAuxEquip['Hora'])&&$rowAuxEquip['Hora']!=''){
					if($HoraSistema>$rowAuxEquip['Hora']){
						$minutos_transcurridos = restahoras($rowAuxEquip['Hora'],$HoraSistema);
					}else{
						//sumo tiempo para hacer la resta correctamente
						$Tiempo = sumahoras($HoraSistema,'24:00:00');
						$minutos_transcurridos = restahoras($rowAuxEquip['Hora'],$Tiempo);
					}
				}else{
					$minutos_transcurridos = 0;
				}

				//conversion
				$minutos_1_Equip  = horas2minutos($minutos_transcurridos);
				$minutos_2_Equip = $minutos_1_Equip;
				//valido que sea un numero el resultado
				if (validarNumero($minutos_1_Equip)&&$minutos_1_Equip!=''){
					$minutos_1_Equip = $minutos_1_Equip/60;
				}else{
					$minutos_1_Equip = 0;
				}

				//si la temperatura general esta bajo cierta temperatura
				if($Temperatura_Actual<$rowSistema['CrossTech_TempMin']){
					$HorasBajoGrados      = $rowAuxEquip['HorasBajoGrados'] + $minutos_1_Equip;
					$Tiempo_HeladaEquip   = $minutos_1_Equip;
				}else{
					$HorasBajoGrados = $rowAuxEquip['HorasBajoGrados'];
				}
				//si la temperatura general esta sobre cierta temperatura
				if($Temperatura_Actual>$rowSistema['CrossTech_TempMax']){
					$HorasSobreGrados = $rowAuxEquip['HorasSobreGrados'] + $minutos_1_Equip;
				}else{
					$HorasSobreGrados = $rowAuxEquip['HorasSobreGrados'];
				}

				/*************************************************************/
				//Valor por defecto de las unidades de frio
				$UnidadesFrio = $rowAuxEquip['UnidadesFrio'];

				//calculo Unidades de frio
				if($Temperatura_Actual<1.4){
					$UnidadesFrio = $rowAuxEquip['UnidadesFrio'] + ((0 / 60) * $minutos_2_Equip);
				}elseif($Temperatura_Actual>=1.5&&$Temperatura_Actual<=2.4){
					$UnidadesFrio = $rowAuxEquip['UnidadesFrio'] + ((0.5 / 60) * $minutos_2_Equip);
				}elseif($Temperatura_Actual>=2.5&&$Temperatura_Actual<=9.1){
					$UnidadesFrio = $rowAuxEquip['UnidadesFrio'] + ((1.0 / 60) * $minutos_2_Equip);
				}elseif($Temperatura_Actual>=9.2&&$Temperatura_Actual<=12.4){
					$UnidadesFrio = $rowAuxEquip['UnidadesFrio'] + ((0.5 / 60) * $minutos_2_Equip);
				}elseif($Temperatura_Actual>=12.5&&$Temperatura_Actual<=15.9){
					$UnidadesFrio = $rowAuxEquip['UnidadesFrio'] + ((0 / 60) * $minutos_2_Equip);
				}elseif($Temperatura_Actual>=16&&$Temperatura_Actual<=18){
					$TempUnidadesFrio = $rowAuxEquip['UnidadesFrio'] - ((0.5 / 60) * $minutos_2_Equip);
					//solo si es mayor a 0
					if($TempUnidadesFrio>=0){$UnidadesFrio = $TempUnidadesFrio;}
				}elseif($Temperatura_Actual>=19){
					$TempUnidadesFrio = $rowAuxEquip['UnidadesFrio'] - ((1.0 / 60) * $minutos_2_Equip);
					//solo si es mayor a 0
					if($TempUnidadesFrio>=0){$UnidadesFrio = $TempUnidadesFrio;}
				}

				/*************************************************************/
				//se guardan datos de referencia
				if(isset($rowAuxEquip['CrossTech_DiasTempMin']) && $rowAuxEquip['CrossTech_DiasTempMin']!=''){             $CrossTech_DiasTempMin        = $rowAuxEquip['CrossTech_DiasTempMin'];         }else{$CrossTech_DiasTempMin        = $rowSistema['CrossTech_DiasTempMin'];}
				if(isset($rowAuxEquip['CrossTech_TempMin']) && $rowAuxEquip['CrossTech_TempMin']!=''){                     $CrossTech_TempMin            = $rowAuxEquip['CrossTech_TempMin'];             }else{$CrossTech_TempMin            = $rowSistema['CrossTech_TempMin'];}
				if(isset($rowAuxEquip['CrossTech_TempMax']) && $rowAuxEquip['CrossTech_TempMax']!=''){                     $CrossTech_TempMax            = $rowAuxEquip['CrossTech_TempMax'];             }else{$CrossTech_TempMax            = $rowSistema['CrossTech_TempMax'];}
				if(isset($rowAuxEquip['CrossTech_FechaDiasTempMin']) && $rowAuxEquip['CrossTech_FechaDiasTempMin']!=''){   $CrossTech_FechaDiasTempMin   = $rowAuxEquip['CrossTech_FechaDiasTempMin'];    }else{$CrossTech_FechaDiasTempMin   = $rowSistema['CrossTech_FechaDiasTempMin'];}
				if(isset($rowAuxEquip['CrossTech_FechaTempMin']) && $rowAuxEquip['CrossTech_FechaTempMin']!=''){           $CrossTech_FechaTempMin       = $rowAuxEquip['CrossTech_FechaTempMin'];        }else{$CrossTech_FechaTempMin       = $rowSistema['CrossTech_FechaTempMin'];}
				if(isset($rowAuxEquip['CrossTech_FechaTempMax']) && $rowAuxEquip['CrossTech_FechaTempMax']!=''){           $CrossTech_FechaTempMax       = $rowAuxEquip['CrossTech_FechaTempMax'];        }else{$CrossTech_FechaTempMax       = $rowSistema['CrossTech_FechaTempMax'];}
				if(isset($rowAuxEquip['CrossTech_FechaUnidadFrio']) && $rowAuxEquip['CrossTech_FechaUnidadFrio']!=''){     $CrossTech_FechaUnidadFrio    = $rowAuxEquip['CrossTech_FechaUnidadFrio'];     }else{$CrossTech_FechaUnidadFrio    = $rowSistema['CrossTech_FechaUnidadFrio'];}
				if(isset($rowAuxEquip['Dias_acumulado']) && $rowAuxEquip['Dias_acumulado']!=''){                           $Dias_acumulado               = $rowAuxEquip['Dias_acumulado'];                }else{$Dias_acumulado               = 0;}
				if(isset($rowAuxEquip['Dias_anterior']) && $rowAuxEquip['Dias_anterior']!=''){                             $Dias_anterior                = $rowAuxEquip['Dias_anterior'];                 }else{$Dias_anterior                = 0;}
				if(isset($rowAuxEquip['Fecha']) && $rowAuxEquip['Fecha']!=''){                                             $Fecha_Anterior               = $rowAuxEquip['Fecha'];                         }else{$Fecha_Anterior               = $FechaSistema;}
				if(isset($rowAuxEquip['Hora']) && $rowAuxEquip['Hora']!=''){                                               $Hora_Anterior                = $rowAuxEquip['Hora'];                          }else{$Hora_Anterior                = $HoraSistema;}

				/*************************************************************/
				//Insertar datos
				if(isset($data['idTelemetria']) && $data['idTelemetria']!=''){              $a  = "'".$data['idTelemetria']."'";         }else{$a  = "''";}
				if(isset($idSistema) && $idSistema!=''){                                    $a .= ",'".$idSistema."'";                   }else{$a .= ",''";}
				if(isset($FechaSistema) && $FechaSistema!=''){                              $a .= ",'".$FechaSistema."'";                }else{$a .= ",''";}
				if(isset($HoraSistema) && $HoraSistema!=''){                                $a .= ",'".$HoraSistema."'";                 }else{$a .= ",''";}
				if(isset($TimeStamp) && $TimeStamp!=''){                                    $a .= ",'".$TimeStamp."'";                   }else{$a .= ",''";}
				if(isset($Temperatura_Actual) && $Temperatura_Actual!=''){                  $a .= ",'".$Temperatura_Actual."'";          }else{$a .= ",''";}
				if(isset($Humedad_Actual) && $Humedad_Actual!=''){                          $a .= ",'".$Humedad_Actual."'";              }else{$a .= ",''";}
				if(isset($Rocio_Actual) && $Rocio_Actual!=''){                              $a .= ",'".$Rocio_Actual."'";                }else{$a .= ",''";}
				if(isset($Presion_Actual) && $Presion_Actual!=''){                          $a .= ",'".$Presion_Actual."'";              }else{$a .= ",''";}
				if(isset($HeladaEquip) && $HeladaEquip!=''){                                $a .= ",'".$HeladaEquip."'";                 }else{$a .= ",''";}
				if(isset($Hora_Prediccion) && $Hora_Prediccion!=''){                        $a .= ",'".$Hora_Prediccion."'";             }else{$a .= ",''";}
				if(isset($Fecha_Prediccion) && $Fecha_Prediccion!=''){                      $a .= ",'".$Fecha_Prediccion."'";            }else{$a .= ",''";}
				if(isset($HorasBajoGrados) && $HorasBajoGrados!=''){                        $a .= ",'".$HorasBajoGrados."'";             }else{$a .= ",''";}
				if(isset($HorasSobreGrados) && $HorasSobreGrados!=''){                      $a .= ",'".$HorasSobreGrados."'";            }else{$a .= ",''";}
				if(isset($UnidadesFrio) && $UnidadesFrio!=''){                              $a .= ",'".$UnidadesFrio."'";                }else{$a .= ",''";}
				if(isset($CrossTech_DiasTempMin) && $CrossTech_DiasTempMin!=''){            $a .= ",'".$CrossTech_DiasTempMin."'";       }else{$a .= ",''";}
				if(isset($CrossTech_TempMin) && $CrossTech_TempMin!=''){                    $a .= ",'".$CrossTech_TempMin."'";           }else{$a .= ",''";}
				if(isset($CrossTech_TempMax) && $CrossTech_TempMax!=''){                    $a .= ",'".$CrossTech_TempMax."'";           }else{$a .= ",''";}
				if(isset($CrossTech_FechaDiasTempMin) && $CrossTech_FechaDiasTempMin!=''){  $a .= ",'".$CrossTech_FechaDiasTempMin."'";  }else{$a .= ",''";}
				if(isset($CrossTech_FechaTempMin) && $CrossTech_FechaTempMin!=''){          $a .= ",'".$CrossTech_FechaTempMin."'";      }else{$a .= ",''";}
				if(isset($CrossTech_FechaTempMax) && $CrossTech_FechaTempMax!=''){          $a .= ",'".$CrossTech_FechaTempMax."'";      }else{$a .= ",''";}
				if(isset($CrossTech_FechaUnidadFrio) && $CrossTech_FechaUnidadFrio!=''){    $a .= ",'".$CrossTech_FechaUnidadFrio."'";   }else{$a .= ",''";}
				if(isset($Dias_acumulado) && $Dias_acumulado!=''){                          $a .= ",'".$Dias_acumulado."'";              }else{$a .= ",''";}
				if(isset($Dias_anterior) && $Dias_anterior!=''){                            $a .= ",'".$Dias_anterior."'";               }else{$a .= ",''";}
				if(isset($Tiempo_HeladaEquip) && $Tiempo_HeladaEquip!=''){                  $a .= ",'".$Tiempo_HeladaEquip."'";          }else{$a .= ",''";}
				if(isset($Fecha_Anterior) && $Fecha_Anterior!=''){                          $a .= ",'".$Fecha_Anterior."'";              }else{$a .= ",''";}
				if(isset($Hora_Anterior) && $Hora_Anterior!=''){                            $a .= ",'".$Hora_Anterior."'";               }else{$a .= ",''";}
				if(isset($minutos_1_Equip) && $minutos_1_Equip!=''){                        $a .= ",'".$minutos_1_Equip."'";             }else{$a .= ",''";}

				// inserto los datos de registro en la db
				$query  = "INSERT INTO `telemetria_listado_aux_equipo` (idTelemetria, idSistema, Fecha, Hora, TimeStamp, Temperatura,
				Humedad, PuntoRocio, PresionAtmos, Helada, HeladaHora, HeladaDia, HorasBajoGrados, HorasSobreGrados,
				UnidadesFrio, CrossTech_DiasTempMin, CrossTech_TempMin, CrossTech_TempMax, CrossTech_FechaDiasTempMin,
				CrossTech_FechaTempMin, CrossTech_FechaTempMax, CrossTech_FechaUnidadFrio, Dias_acumulado,
				Dias_anterior, Tiempo_Helada, Fecha_Anterior, Hora_Anterior, Tiempo_Transcurrido)
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

				//se configura para que envie correos
				if(isset($HeladaEquip)&&$HeladaEquip!=''&&$HeladaEquip!=0&&isset($rowSistema['Nombre'])&&$rowSistema['CrossTech_HeladaTemp']>$HeladaEquip){
					$nCorreosEquipo++;
					/*********************************************************************/
					//variables
					$EmailCuerpoEquipo.= '<p>Agro-Weather proyecta en el equipo '.$data['Nombre'].' la temperatura de '.cantidades($HeladaEquip, 2).' C a las ';
					$EmailCuerpoEquipo.= ' '.$Hora_Prediccion.' el '.fecha_estandar($Fecha_Prediccion).' en '.$rowSistema['Nombre'].'.</p>';
				}
			}
		}
	}
	/*************************************************************/
	//se genera cuerpo del correo
	/*************************************************************/
	if(($nCorreosGrupo!=0&&$Rev_Grupo==1) OR ($nCorreosEquipo!=0&&$Rev_Equipo==1)){
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
		AND telemetria_mnt_correos_list.idCorreosCat=24
		AND (telemetria_mnt_correos_list.TimeStamp<"'.$FechaSistema.' '.$HoraSistema.'" OR telemetria_mnt_correos_list.TimeStamp="0000-00-00 00:00:00")';
		$SIS_order = 0;
		$arrCorreos = array();
		$arrCorreos = db_select_array (false, $SIS_query, 'telemetria_mnt_correos_list', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

		/*********************************************************/
		//Se configura el titulo del correo
		$EmailTitulo = 'ALERTA HELADA: '.$rowSistema['Nombre'];

		/*********************************************************/
		//Se configura el cuerpo del correo
		if($nCorreosGrupo!=0&&$Rev_Grupo==1){
			$EmailCuerpo.= $EmailCuerpoGrupo;
		}
		/*********************************************************/
		//Se configura el cuerpo del correo
		if($nCorreosEquipo!=0&&$Rev_Equipo==1){
			$EmailCuerpo.= $EmailCuerpoEquipo;
		}
		$EmailCuerpo.= '<p>Si desea desactivar temporalmente las alertas favor ingresar con sus credenciales a <a href="http://clientes.1tek.cl">Agro-Weather</a> y luego desactivarla desde cualquiera de las notificaciones</p>';
		$EmailCuerpo.= '<p>Correo enviado automatico, no responder. Si requiere información o soporte favor escribirnos a <a href="mailto:soporte@1tek.cl">soporte@1tek.cl</a> <br/>Nunca pediremos datos personales ni claves por esta via.</p>';
		$EmailCuerpo.= '<p><strong>1Tek</strong></p>';

		/*********************************************************/
		//notificacion
		$idUsuario  = 3;//el administrador
		$NotiTitulo = $EmailTitulo;
		$NotiCuerpo = '<p>Agro-Weather proyecta temperatura de '.cantidades($Helada, 2).' C a las ';
		$NotiCuerpo.= ' '.$Hora_Prediccion.' el '.fecha_estandar($Fecha_Prediccion).' en '.$rowSistema['Nombre'].'.</p>';
		$NoMolestar = 1;//Se activa para mostrar la opción

		/*************************************************************/
		//Se buscan los correos para enviar la alerta
		if(isset($idSistema) && $idSistema!=''){         $a  = "'".$idSistema."'";        }else{$a  = "''";}
		if(isset($idUsuario) && $idUsuario!=''){         $a .= ",'".$idUsuario."'";       }else{$a .= ",''";}
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

		/**********************************************************************/
		//verifico si esta configurada las horas de envio de correo
		if($rowSistema['CrossTech_HeladaMailHoraIni']!='00:00:00'&&$rowSistema['CrossTech_HeladaMailHoraTerm']!='00:00:00'){
			//verifico cual es el mas alto
			/**********************************************************************/
			//configuracion normal
			if($rowSistema['CrossTech_HeladaMailHoraIni']<$rowSistema['CrossTech_HeladaMailHoraTerm']){
				//verifico si estoy dentro de las horas de envio de correo
				if($HoraSistema > $rowSistema['CrossTech_HeladaMailHoraIni'] && $HoraSistema < $rowSistema['CrossTech_HeladaMailHoraTerm']){
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
						log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:ALERTA HELADA: '.$rowSistema['Nombre'].')');

					}
				}
			/**********************************************************************/
			//configuracion para enviar correos en la noche
			}else{
				//defino los rangos
				if(($HoraSistema > $rowSistema['CrossTech_HeladaMailHoraIni']&&$HoraSistema < '23:59:59') OR ($HoraSistema < $rowSistema['CrossTech_HeladaMailHoraTerm']&&$HoraSistema > '00:00:01')){

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
						log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:ALERTA HELADA: '.$rowSistema['Nombre'].')');

					}
				}
			}
		}
	}
}

?>

