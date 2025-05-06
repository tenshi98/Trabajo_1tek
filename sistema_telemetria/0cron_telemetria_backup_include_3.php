<?php
/**********************************************************************************************************************************/
/*                                                 Tablas relacionadas                                                            */
/**********************************************************************************************************************************/
// Se trae un listado con todos los equipos que tengan configurado la opción de backup
$arrTelemetria = array();
$arrTelemetria = db_select_array (false, 'idTelemetria, NregBackup', 'telemetria_listado', '', 'idBackup=1', 'idTelemetria ASC', $dbConn, '0cron_telemetria_backup_include_3', basename($_SERVER["REQUEST_URI"], ".php"), 'arrTelemetria');

//Recorro equipos
foreach ($arrTelemetria as $tel) {
	/**************************************************/
	//Obtengo los punteros para el respaldo
	$SIS_query = 'idTabla';
	$SIS_join  = '';
	$SIS_where = 'idTabla!=0 ORDER BY idTabla DESC LIMIT 1 OFFSET '.$tel['NregBackup'];
	$rowPuntero = db_select_data (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$tel['idTelemetria'], $SIS_join, $SIS_where, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowPuntero');

	/**************************************************/
	//si obtengo el puntero
	if(isset($rowPuntero['idTabla'])&&$rowPuntero['idTabla']!=''){

		/**************************************************/
		//hago una seleccion de datos
		$SIS_query = '
		idTabla,idTelemetria,idSolicitud,idZona,FechaSistema,HoraSistema,
		TimeStamp,GeoLatitud,GeoLongitud,GeoVelocidad,GeoDireccion,GeoMovimiento,Segundos,Diferencia,Sensor_1,Sensor_2,
		Sensor_3,Sensor_4,Sensor_5,Sensor_6,Sensor_7,Sensor_8,Sensor_9,Sensor_10,Sensor_11,Sensor_12,
		Sensor_13,Sensor_14,Sensor_15,Sensor_16,Sensor_17,Sensor_18,Sensor_19,Sensor_20,Sensor_21,Sensor_22,
		Sensor_23,Sensor_24,Sensor_25,Sensor_26,Sensor_27,Sensor_28,Sensor_29,Sensor_30,Sensor_31,Sensor_32,
		Sensor_33,Sensor_34,Sensor_35,Sensor_36,Sensor_37,Sensor_38,Sensor_39,Sensor_40,Sensor_41,Sensor_42,
		Sensor_43,Sensor_44,Sensor_45,Sensor_46,Sensor_47,Sensor_48,Sensor_49,Sensor_50,Sensor_51,Sensor_52,
		Sensor_53,Sensor_54,Sensor_55,Sensor_56,Sensor_57,Sensor_58,Sensor_59,Sensor_60,Sensor_61,Sensor_62,
		Sensor_63,Sensor_64,Sensor_65,Sensor_66,Sensor_67,Sensor_68,Sensor_69,Sensor_70,Sensor_71,Sensor_72';
		$SIS_join  = '';
		$SIS_where = 'idTabla BETWEEN 1 AND '.$rowPuntero['idTabla'];
		$SIS_order = 'idTabla ASC';
		$arrSeleccion = array();
		$arrSeleccion = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$tel['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, '0cron_telemetria_backup_include_3', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSeleccion');

		/**************************************************/
		//verifico si tabla de respaldo existe, si no existe se crea
		$SIS_query = 'idTabla';
		$SIS_join  = '';
		$SIS_where = 'idTabla!=0 ORDER BY idTabla DESC';
		$rowErrores = db_select_data (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.$tel['idTelemetria'], $SIS_join, $SIS_where, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowErrores');

		//verifico
		if($rowErrores!=false){
			//tabla existe, no se hace nada
		}else{

			try {
				// elimino la tabla si es que existe
				//$query  = "DROP TABLE IF EXISTS `backup_telemetria_listado_tablarelacionada_".$tel['idTelemetria']."`";
				//$result = mysqli_query($dbConn, $query);

				//tabla no existe, se crea nueba tabla
				$N_Maximo_Sensores = 72;
				//Variable para columnas
				$tr_column = '';
				//Recorro la configuracion de los sensores
				for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
					$tr_column .= '`Sensor_'.$i.'` decimal(20,6) NOT NULL,';
				}
				// se crea la nueva tabla
				$query  = "CREATE TABLE `backup_telemetria_listado_tablarelacionada_".$tel['idTelemetria']."` (
				`idTabla` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`idTelemetria` int(11) unsigned NOT NULL,
				`idSolicitud` int(11) unsigned NOT NULL,
				`idZona` int(11) unsigned NOT NULL,
				`FechaSistema` date NOT NULL,
				`HoraSistema` time NOT NULL,
				`TimeStamp` datetime NOT NULL ,
				`GeoLatitud` double NOT NULL,
				`GeoLongitud` double NOT NULL,
				`GeoVelocidad` decimal(20,6) NOT NULL,
				`GeoDireccion` decimal(20,6) NOT NULL,
				`GeoMovimiento` decimal(20,6) NOT NULL,
				`Segundos` int(11) unsigned NOT NULL,
				`Diferencia` decimal(20,6) NOT NULL,
				".$tr_column."
				PRIMARY KEY (`idTabla`,`FechaSistema`,`HoraSistema`)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Respaldo Tabla';";
				$result = mysqli_query($dbConn, $query);

			} catch (Exception $e) {
				error_log($e->getMessage(), 0);
			}
		}

		/**************************************************/
		//Contador
		$intCount = 0;
		//inserto los datos en su tabla de respaldo
		foreach ($arrSeleccion as $sel) {
			//filtros
			if(isset($sel['idTabla']) && $sel['idTabla']!=''){               $SIS_data  = "'".$sel['idTabla']."'";         }else{$SIS_data  ="''";}
			if(isset($sel['idTelemetria']) && $sel['idTelemetria']!=''){     $SIS_data .= ",'".$sel['idTelemetria']."'";   }else{$SIS_data .=",''";}
			if(isset($sel['idSolicitud']) && $sel['idSolicitud']!=''){       $SIS_data .= ",'".$sel['idSolicitud']."'";    }else{$SIS_data .=",''";}
			if(isset($sel['idZona']) && $sel['idZona']!=''){                 $SIS_data .= ",'".$sel['idZona']."'";         }else{$SIS_data .=",''";}
			if(isset($sel['FechaSistema']) && $sel['FechaSistema']!=''){     $SIS_data .= ",'".$sel['FechaSistema']."'";   }else{$SIS_data .=",''";}
			if(isset($sel['HoraSistema']) && $sel['HoraSistema']!=''){       $SIS_data .= ",'".$sel['HoraSistema']."'";    }else{$SIS_data .=",''";}
			if(isset($sel['TimeStamp']) && $sel['TimeStamp']!=''){           $SIS_data .= ",'".$sel['TimeStamp']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['GeoLatitud']) && $sel['GeoLatitud']!=''){         $SIS_data .= ",'".$sel['GeoLatitud']."'";     }else{$SIS_data .=",''";}
			if(isset($sel['GeoLongitud']) && $sel['GeoLongitud']!=''){       $SIS_data .= ",'".$sel['GeoLongitud']."'";    }else{$SIS_data .=",''";}
			if(isset($sel['GeoVelocidad']) && $sel['GeoVelocidad']!=''){     $SIS_data .= ",'".$sel['GeoVelocidad']."'";   }else{$SIS_data .=",''";}
			if(isset($sel['GeoDireccion']) && $sel['GeoDireccion']!=''){     $SIS_data .= ",'".$sel['GeoDireccion']."'";   }else{$SIS_data .=",''";}
			if(isset($sel['GeoMovimiento']) && $sel['GeoMovimiento']!=''){   $SIS_data .= ",'".$sel['GeoMovimiento']."'";  }else{$SIS_data .=",''";}
			if(isset($sel['Segundos']) && $sel['Segundos']!=''){             $SIS_data .= ",'".$sel['Segundos']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Diferencia']) && $sel['Diferencia']!=''){         $SIS_data .= ",'".$sel['Diferencia']."'";     }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_1']) && $sel['Sensor_1']!=''){             $SIS_data .= ",'".$sel['Sensor_1']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_2']) && $sel['Sensor_2']!=''){             $SIS_data .= ",'".$sel['Sensor_2']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_3']) && $sel['Sensor_3']!=''){             $SIS_data .= ",'".$sel['Sensor_3']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_4']) && $sel['Sensor_4']!=''){             $SIS_data .= ",'".$sel['Sensor_4']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_5']) && $sel['Sensor_5']!=''){             $SIS_data .= ",'".$sel['Sensor_5']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_6']) && $sel['Sensor_6']!=''){             $SIS_data .= ",'".$sel['Sensor_6']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_7']) && $sel['Sensor_7']!=''){             $SIS_data .= ",'".$sel['Sensor_7']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_8']) && $sel['Sensor_8']!=''){             $SIS_data .= ",'".$sel['Sensor_8']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_9']) && $sel['Sensor_9']!=''){             $SIS_data .= ",'".$sel['Sensor_9']."'";       }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_10']) && $sel['Sensor_10']!=''){           $SIS_data .= ",'".$sel['Sensor_10']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_11']) && $sel['Sensor_11']!=''){           $SIS_data .= ",'".$sel['Sensor_11']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_12']) && $sel['Sensor_12']!=''){           $SIS_data .= ",'".$sel['Sensor_12']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_13']) && $sel['Sensor_13']!=''){           $SIS_data .= ",'".$sel['Sensor_13']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_14']) && $sel['Sensor_14']!=''){           $SIS_data .= ",'".$sel['Sensor_14']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_15']) && $sel['Sensor_15']!=''){           $SIS_data .= ",'".$sel['Sensor_15']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_16']) && $sel['Sensor_16']!=''){           $SIS_data .= ",'".$sel['Sensor_16']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_17']) && $sel['Sensor_17']!=''){           $SIS_data .= ",'".$sel['Sensor_17']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_18']) && $sel['Sensor_18']!=''){           $SIS_data .= ",'".$sel['Sensor_18']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_19']) && $sel['Sensor_19']!=''){           $SIS_data .= ",'".$sel['Sensor_19']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_20']) && $sel['Sensor_20']!=''){           $SIS_data .= ",'".$sel['Sensor_20']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_21']) && $sel['Sensor_21']!=''){           $SIS_data .= ",'".$sel['Sensor_21']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_22']) && $sel['Sensor_22']!=''){           $SIS_data .= ",'".$sel['Sensor_22']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_23']) && $sel['Sensor_23']!=''){           $SIS_data .= ",'".$sel['Sensor_23']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_24']) && $sel['Sensor_24']!=''){           $SIS_data .= ",'".$sel['Sensor_24']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_25']) && $sel['Sensor_25']!=''){           $SIS_data .= ",'".$sel['Sensor_25']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_26']) && $sel['Sensor_26']!=''){           $SIS_data .= ",'".$sel['Sensor_26']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_27']) && $sel['Sensor_27']!=''){           $SIS_data .= ",'".$sel['Sensor_27']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_28']) && $sel['Sensor_28']!=''){           $SIS_data .= ",'".$sel['Sensor_28']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_29']) && $sel['Sensor_29']!=''){           $SIS_data .= ",'".$sel['Sensor_29']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_30']) && $sel['Sensor_30']!=''){           $SIS_data .= ",'".$sel['Sensor_30']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_31']) && $sel['Sensor_31']!=''){           $SIS_data .= ",'".$sel['Sensor_31']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_32']) && $sel['Sensor_32']!=''){           $SIS_data .= ",'".$sel['Sensor_32']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_33']) && $sel['Sensor_33']!=''){           $SIS_data .= ",'".$sel['Sensor_33']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_34']) && $sel['Sensor_34']!=''){           $SIS_data .= ",'".$sel['Sensor_34']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_35']) && $sel['Sensor_35']!=''){           $SIS_data .= ",'".$sel['Sensor_35']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_36']) && $sel['Sensor_36']!=''){           $SIS_data .= ",'".$sel['Sensor_36']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_37']) && $sel['Sensor_37']!=''){           $SIS_data .= ",'".$sel['Sensor_37']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_38']) && $sel['Sensor_38']!=''){           $SIS_data .= ",'".$sel['Sensor_38']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_39']) && $sel['Sensor_39']!=''){           $SIS_data .= ",'".$sel['Sensor_39']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_40']) && $sel['Sensor_40']!=''){           $SIS_data .= ",'".$sel['Sensor_40']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_41']) && $sel['Sensor_41']!=''){           $SIS_data .= ",'".$sel['Sensor_41']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_42']) && $sel['Sensor_42']!=''){           $SIS_data .= ",'".$sel['Sensor_42']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_43']) && $sel['Sensor_43']!=''){           $SIS_data .= ",'".$sel['Sensor_43']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_44']) && $sel['Sensor_44']!=''){           $SIS_data .= ",'".$sel['Sensor_44']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_45']) && $sel['Sensor_45']!=''){           $SIS_data .= ",'".$sel['Sensor_45']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_46']) && $sel['Sensor_46']!=''){           $SIS_data .= ",'".$sel['Sensor_46']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_47']) && $sel['Sensor_47']!=''){           $SIS_data .= ",'".$sel['Sensor_47']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_48']) && $sel['Sensor_48']!=''){           $SIS_data .= ",'".$sel['Sensor_48']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_49']) && $sel['Sensor_49']!=''){           $SIS_data .= ",'".$sel['Sensor_49']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_50']) && $sel['Sensor_50']!=''){           $SIS_data .= ",'".$sel['Sensor_50']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_51']) && $sel['Sensor_51']!=''){           $SIS_data .= ",'".$sel['Sensor_51']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_52']) && $sel['Sensor_52']!=''){           $SIS_data .= ",'".$sel['Sensor_52']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_53']) && $sel['Sensor_53']!=''){           $SIS_data .= ",'".$sel['Sensor_53']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_54']) && $sel['Sensor_54']!=''){           $SIS_data .= ",'".$sel['Sensor_54']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_55']) && $sel['Sensor_55']!=''){           $SIS_data .= ",'".$sel['Sensor_55']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_56']) && $sel['Sensor_56']!=''){           $SIS_data .= ",'".$sel['Sensor_56']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_57']) && $sel['Sensor_57']!=''){           $SIS_data .= ",'".$sel['Sensor_57']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_58']) && $sel['Sensor_58']!=''){           $SIS_data .= ",'".$sel['Sensor_58']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_59']) && $sel['Sensor_59']!=''){           $SIS_data .= ",'".$sel['Sensor_59']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_60']) && $sel['Sensor_60']!=''){           $SIS_data .= ",'".$sel['Sensor_60']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_61']) && $sel['Sensor_61']!=''){           $SIS_data .= ",'".$sel['Sensor_61']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_62']) && $sel['Sensor_62']!=''){           $SIS_data .= ",'".$sel['Sensor_62']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_63']) && $sel['Sensor_63']!=''){           $SIS_data .= ",'".$sel['Sensor_63']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_64']) && $sel['Sensor_64']!=''){           $SIS_data .= ",'".$sel['Sensor_64']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_65']) && $sel['Sensor_65']!=''){           $SIS_data .= ",'".$sel['Sensor_65']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_66']) && $sel['Sensor_66']!=''){           $SIS_data .= ",'".$sel['Sensor_66']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_67']) && $sel['Sensor_67']!=''){           $SIS_data .= ",'".$sel['Sensor_67']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_68']) && $sel['Sensor_68']!=''){           $SIS_data .= ",'".$sel['Sensor_68']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_69']) && $sel['Sensor_69']!=''){           $SIS_data .= ",'".$sel['Sensor_69']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_70']) && $sel['Sensor_70']!=''){           $SIS_data .= ",'".$sel['Sensor_70']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_71']) && $sel['Sensor_71']!=''){           $SIS_data .= ",'".$sel['Sensor_71']."'";      }else{$SIS_data .=",''";}
			if(isset($sel['Sensor_72']) && $sel['Sensor_72']!=''){           $SIS_data .= ",'".$sel['Sensor_72']."'";      }else{$SIS_data .=",''";}

			// inserto los datos de registro en la db
			$SIS_columns = 'idTabla,idTelemetria, idSolicitud,idZona,FechaSistema,HoraSistema,
			TimeStamp,GeoLatitud,GeoLongitud,GeoVelocidad,GeoDireccion,GeoMovimiento,Segundos, Diferencia,Sensor_1,Sensor_2,
			Sensor_3,Sensor_4,Sensor_5,Sensor_6,Sensor_7,Sensor_8,Sensor_9,Sensor_10,Sensor_11,Sensor_12,
			Sensor_13,Sensor_14,Sensor_15,Sensor_16,Sensor_17,Sensor_18,Sensor_19,Sensor_20,Sensor_21,Sensor_22,
			Sensor_23,Sensor_24,Sensor_25,Sensor_26,Sensor_27,Sensor_28,Sensor_29,Sensor_30,Sensor_31,Sensor_32,
			Sensor_33,Sensor_34,Sensor_35,Sensor_36,Sensor_37,Sensor_38,Sensor_39,Sensor_40,Sensor_41,Sensor_42,
			Sensor_43,Sensor_44,Sensor_45,Sensor_46,Sensor_47,Sensor_48,Sensor_49,Sensor_50,Sensor_51,Sensor_52,
			Sensor_53,Sensor_54,Sensor_55,Sensor_56,Sensor_57,Sensor_58,Sensor_59,Sensor_60,Sensor_61,Sensor_62,
			Sensor_63,Sensor_64,Sensor_65,Sensor_66,Sensor_67,Sensor_68,Sensor_69,Sensor_70,Sensor_71,Sensor_72';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'backup_telemetria_listado_tablarelacionada_'.$tel['idTelemetria'], $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//Cuento el registro insertado
				$intCount++;
			}

		}

		/**************************************************/
		//elimino los datos si al menos se insertyo un dato
		if($intCount!=0){
			$resultado = db_delete_data (false, 'telemetria_listado_tablarelacionada_'.$tel['idTelemetria'], 'idTabla BETWEEN 1 AND '.$rowPuntero['idTabla'], $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_delete_data');

		}
	}
}

?>
