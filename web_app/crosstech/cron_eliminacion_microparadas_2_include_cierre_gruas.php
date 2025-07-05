<?php
/**********************************************************************************************************************************/
/*                                        DESACTIVAR TODAS LAS GRUAS ACTIVAS                                                      */
/**********************************************************************************************************************************/
// Se trae un listado con todas las gruas activas y encendidas
//Se arma la query con los datos justos recibidos
$subquery = '';
for ($i = 1; $i <= 50; $i++) {
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
}
/*******************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.SensorActivacionID,
telemetria_listado.SensorActivacionValor,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
COUNT(telemetria_listado_historial_activaciones.idH_Activacion) AS Cuenta'.$subquery;
$SIS_join  = ' LEFT JOIN `telemetria_listado`                      ON telemetria_listado.idTelemetria                      = telemetria_listado_historial_activaciones.idTelemetria';
$SIS_join .= ' LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado_historial_activaciones.idTelemetria';
$SIS_where = 'telemetria_listado_historial_activaciones.Fecha="'.$fecha_real.'"';
//$SIS_where.= ' AND telemetria_listado_historial_activaciones.idTelemetria=79';
$SIS_where.= ' GROUP BY telemetria_listado_historial_activaciones.idTelemetria';
$SIS_order = 'telemetria_listado_historial_activaciones.idTelemetria ASC';
$arrGruas = array();
$arrGruas = db_select_array (false, $SIS_query, 'telemetria_listado_historial_activaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');

//recorro las gruas activas
foreach ($arrGruas as $grua) {
	//Verifico que grua tenga conexion dentro del dia
	if($grua['LastUpdateFecha']==$fecha_real){
		//verifico que el equipo esta encendido y que tenga datos de medicion en el dia
		if(valores_truncados($grua['SensoresMedActual_'.$grua['SensorActivacionID']])>=$grua['SensorActivacionValor']&&$grua['Cuenta']!=0){

			//si la grua indica que esta activa sobre las 23:58 no hago nada
			if($grua['LastUpdateHora']>'23:58:00' OR $grua['LastUpdateHora']<'02:00:00'){

				/****************************************************************/
				//inserto en el historial de activaciones una desactivacion
				if(isset($grua['idTelemetria']) && $grua['idTelemetria']!=''){              $SIS_data  = "'".$grua['idTelemetria']."'";            }else{$SIS_data  = "''";}
				if(isset($fecha_real) && $fecha_real!=''){                                  $SIS_data .= ",'".$fecha_real."'";                     }else{$SIS_data .= ",''";}
				if(isset($fecha_real) && $fecha_real!=''){                                  $SIS_data .= ",'".$fecha_real." 23:59:59'";            }else{$SIS_data .= ",''";}
				if(isset($grua['SensorActivacionID']) && $grua['SensorActivacionID']!=''){  $SIS_data .= ",'".$grua['SensorActivacionID']."'";     }else{$SIS_data .= ",''";}
				if(isset($grua['idContrato']) && $grua['idContrato']!=''){                  $SIS_data .= ",'".$rowData['idContrato']."'";          }else{$SIS_data .= ",''";}
				$SIS_data .= ",'23:59:59'";
				$SIS_data .= ",'1'";  //SensorActivacionValor
				$SIS_data .= ",'0'";  //Valor
				$SIS_data .= ",'1'";  //idEstado

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria,Fecha,TimeStamp,SensorActivacionID,idContrato,Hora,SensorActivacionValor,Valor,idEstado';
				$ultimo_id1 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_historial_activaciones', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data1');

				/****************************************************************/
				//inserto en el historial de activaciones una activacion
				if(isset($grua['idTelemetria']) && $grua['idTelemetria']!=''){              $SIS_data  = "'".$grua['idTelemetria']."'";            }else{$SIS_data  = "''";}
				if(isset($fecha_siguiente) && $fecha_siguiente!=''){                        $SIS_data .= ",'".$fecha_siguiente."'";                }else{$SIS_data .= ",''";}
				if(isset($fecha_siguiente) && $fecha_siguiente!=''){                        $SIS_data .= ",'".$fecha_siguiente." 00:00:01'";       }else{$SIS_data .= ",''";}
				if(isset($grua['SensorActivacionID']) && $grua['SensorActivacionID']!=''){  $SIS_data .= ",'".$grua['SensorActivacionID']."'";     }else{$SIS_data .= ",''";}
				if(isset($grua['idContrato']) && $grua['idContrato']!=''){                  $SIS_data .= ",'".$rowData['idContrato']."'";          }else{$SIS_data .= ",''";}
				$SIS_data .= ",'00:00:01'";
				$SIS_data .= ",'1'";  //SensorActivacionValor
				$SIS_data .= ",'1'";  //Valor
				$SIS_data .= ",'1'";  //idEstado

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria,Fecha,TimeStamp,SensorActivacionID,idContrato,Hora,SensorActivacionValor,Valor,idEstado';
				$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_historial_activaciones', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data1');

			//si por el contrario no esta activa a las 23:58, la dejo inactiva 1 minuto despues de la ultima activacion
			}elseif($grua['LastUpdateHora']<'23:58:00' OR $grua['LastUpdateHora']>'02:00:00'){

				//Sumo 1 minuto a la ultima hora
				$ultima_hora = sumahoras($grua['LastUpdateHora'], '00:01:00');

				/****************************************************************/
				//inserto en el historial de activaciones una desactivacion
				if(isset($grua['idTelemetria']) && $grua['idTelemetria']!=''){              $SIS_data  = "'".$grua['idTelemetria']."'";            }else{$SIS_data  = "''";}
				if(isset($fecha_real) && $fecha_real!=''){                                  $SIS_data .= ",'".$fecha_real."'";                     }else{$SIS_data .= ",''";}
				if(isset($fecha_real) && $fecha_real!=''){                                  $SIS_data .= ",'".$fecha_real." 23:59:00'";            }else{$SIS_data .= ",''";}
				if(isset($grua['SensorActivacionID']) && $grua['SensorActivacionID']!=''){  $SIS_data .= ",'".$grua['SensorActivacionID']."'";     }else{$SIS_data .= ",''";}
				if(isset($grua['idContrato']) && $grua['idContrato']!=''){                  $SIS_data .= ",'".$rowData['idContrato']."'";          }else{$SIS_data .= ",''";}
				$SIS_data .= ",'".$ultima_hora."'";
				$SIS_data .= ",'1'";  //SensorActivacionValor
				$SIS_data .= ",'0'";  //Valor
				$SIS_data .= ",'1'";  //idEstado

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria,Fecha,TimeStamp,SensorActivacionID,idContrato,Hora,SensorActivacionValor,Valor,idEstado';
				$ultimo_id1 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_historial_activaciones', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data1');

				/****************************************************************/
				//actualizo el estado de la grua, indico que esta inactiva
				$SIS_data = "SensoresMedActual_".$grua['SensorActivacionID']."='0'";
				//Consulta
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_sensores_med_actual', 'idTelemetria = "'.$grua['idTelemetria'].'"', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'update_data_SensoresMedActual');

			}
		}
	}
}

?>
