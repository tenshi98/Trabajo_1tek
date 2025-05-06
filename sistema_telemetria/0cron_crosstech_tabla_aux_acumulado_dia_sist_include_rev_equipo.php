<?php
/************************************************************/
//Verifico si esta configurado para que revise los equipos
if(isset($Rev_Equipo)&&$Rev_Equipo==1){
	//se verifica la existencia de sistema
	if(isset($idSistema)&&$idSistema!=0){
		$filter = ' AND core_sistemas.idSistema ='.$idSistema;
	}else{
		$filter = '';
	}

	//Se listan todos los sistemas activos
	$SIS_query = '
	core_sistemas.idSistema,
	core_sistemas.idSistema AS ID,
	telemetria_listado.idTelemetria,
	telemetria_listado.idTelemetria AS EQUIP,
	core_sistemas.CrossTech_DiasTempMin,
	core_sistemas.CrossTech_DiasTempMin AS TempMin,
	core_sistemas.CrossTech_TempMin,
	core_sistemas.CrossTech_TempMax,
	core_sistemas.CrossTech_FechaDiasTempMin,
	core_sistemas.CrossTech_FechaTempMin,
	core_sistemas.CrossTech_FechaTempMax,
	core_sistemas.CrossTech_FechaUnidadFrio,
	core_sistemas.CrossTech_FechaDiasTempMin AS FechaD,
	(SELECT SUM(Tiempo_Transcurrido) FROM `telemetria_listado_aux_equipo` WHERE idSistema=ID AND idTelemetria=EQUIP AND Fecha>= FechaD AND Temperatura>TempMin) AS Acumulado,
	(SELECT SUM(Tiempo_Transcurrido) FROM `telemetria_listado_aux_equipo` WHERE idSistema=ID AND idTelemetria=EQUIP AND Fecha= "'.$DiaAnterior.'" AND Temperatura>TempMin) AS DiaAnterior';
	$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idSistema = core_sistemas.idSistema';
	$SIS_where = 'core_sistemas.idEstado = 1 AND telemetria_listado.idEstado = 1 AND telemetria_listado.id_Geo = 2 AND telemetria_listado.idTab = 4 '.$filter;
	$SIS_order = 0;
	$arrSistemas = array();
	$arrSistemas = db_select_array (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

	//se recorren los datos
	foreach ($arrSistemas as $data) {

		//se trae el ultimo registro
		$rowAuxEquip = db_select_data (false, 'idAuxiliar', 'telemetria_listado_aux_equipo', '', 'idSistema = "'.$data["idSistema"].'" AND idTelemetria = "'.$data["idTelemetria"].'" ORDER BY idAuxiliar DESC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

		//Condiciono dato Dia anterior
		$X_DiaAnterior = $data['DiaAnterior'] - 10;
		if($X_DiaAnterior<0){$X_DiaAnterior = 0;}

		//se actualizaen caso de existir un ultimo registro
		if(isset($rowAuxEquip['idAuxiliar'])&&$rowAuxEquip['idAuxiliar']!=''){

			$a = "idAuxiliar='".$rowAuxEquip['idAuxiliar']."'";
			if(isset($data['Acumulado']) && $data['Acumulado']!=''){  $a .= ",Dias_acumulado='".$data['Acumulado']."'";}
			if(isset($X_DiaAnterior) && $X_DiaAnterior!=''){          $a .= ",Dias_anterior='".$X_DiaAnterior."'";}

			$resultado = db_update_data (false, $a, 'telemetria_listado_aux_equipo', 'idAuxiliar = "'.$rowAuxEquip['idAuxiliar'].'"', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

		//se crea el dato en caso de no existir
		}else{
			//verifico que al menos existan datos a insertar
			if(isset($data["CrossTech_DiasTempMin"]) && $data["CrossTech_DiasTempMin"]!=''){
				//filtros
				$a  = "'".$data["idTelemetria"]."'";
				$a .= ",'".$data["idSistema"]."'";
				$a .= ",'".$FechaSistema."'";
				$a .= ",'".$HoraSistema."'";
				$a .= ",'".$TimeStamp."'";
				if(isset($data["CrossTech_DiasTempMin"]) && $data["CrossTech_DiasTempMin"]!=''){              $a .= ",'".$data["CrossTech_DiasTempMin"]."'";            }else{$a .= ",''";}
				if(isset($data["CrossTech_TempMin"]) && $data["CrossTech_TempMin"]!=''){                      $a .= ",'".$data["CrossTech_TempMin"]."'";                }else{$a .= ",''";}
				if(isset($data["CrossTech_TempMax"]) && $data["CrossTech_TempMax"]!=''){                      $a .= ",'".$data["CrossTech_TempMax"]."'";                }else{$a .= ",''";}
				if(isset($data["CrossTech_FechaDiasTempMin"]) && $data["CrossTech_FechaDiasTempMin"]!=''){    $a .= ",'".$data["CrossTech_FechaDiasTempMin"]."'";       }else{$a .= ",''";}
				if(isset($data["CrossTech_FechaTempMin"]) && $data["CrossTech_FechaTempMin"]!=''){            $a .= ",'".$data["CrossTech_FechaTempMin"]."'";           }else{$a .= ",''";}
				if(isset($data["CrossTech_FechaTempMax"]) && $data["CrossTech_FechaTempMax"]!=''){            $a .= ",'".$data["CrossTech_FechaTempMax"]."'";           }else{$a .= ",''";}
				if(isset($data["CrossTech_FechaUnidadFrio"]) && $data["CrossTech_FechaUnidadFrio"]!=''){      $a .= ",'".$data["CrossTech_FechaUnidadFrio"]."'";        }else{$a .= ",''";}
				if(isset($data["Acumulado"]) && $data["Acumulado"]!=''){                                      $a .= ",'".$data["Acumulado"]."'";                        }else{$a .= ",''";}
				if(isset($X_DiaAnterior) && $X_DiaAnterior!=''){                                              $a .= ",'".$X_DiaAnterior."'";                            }else{$a .= ",''";}

				// inserto los datos de registro en la db
				$query  = "INSERT INTO `telemetria_listado_aux_equipo` (idTelemetria, idSistema, Fecha, Hora, TimeStamp,
				CrossTech_DiasTempMin, CrossTech_TempMin, CrossTech_TempMax, CrossTech_FechaDiasTempMin,
				CrossTech_FechaTempMin, CrossTech_FechaTempMax, CrossTech_FechaUnidadFrio, Dias_acumulado,
				Dias_anterior)
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
			}
		}
	}
}

?>
