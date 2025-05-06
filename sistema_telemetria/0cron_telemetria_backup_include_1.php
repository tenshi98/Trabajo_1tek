<?php
/**********************************************************************************************************************************/
/*                                               Alertas de telemetria                                                            */
/**********************************************************************************************************************************/
/**************************************************/
//Obtengo los punteros para el respaldo
$SIS_query = 'idErrores';
$SIS_join  = '';
$SIS_where = 'idErrores!=0 ORDER BY idErrores DESC LIMIT 1 OFFSET '.$N_Reg_Errores;
$rowPuntero = db_select_data (false, $SIS_query, $tabla_1, $SIS_join, $SIS_where, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowPuntero');

/**************************************************/
//hago una seleccion de datos
$arrSeleccion = array();
$arrSeleccion = db_select_array (false, 'idErrores,idSistema,idTelemetria,idTipo,Fecha,Hora,Sensor,Descripcion,Valor,Valor_min,Valor_max,GeoLatitud,GeoLongitud,TimeStamp,idPersonalizado,idLeido, idTipoAlerta,idUniMed', $tabla_1, '', 'idErrores BETWEEN 1 AND '.$rowPuntero['idErrores'], 'idErrores ASC', $dbConn, '0cron_telemetria_backup_include_1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSeleccion');

/**************************************************/
//verifico si tabla de respaldo existe, si no existe se crea
$SIS_query = 'idErrores';
$SIS_join  = '';
$SIS_where = 'idErrores!=0 ORDER BY idErrores DESC';
$rowErrores = db_select_data (false, $SIS_query, $tabla_1_backup, $SIS_join, $SIS_where, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowErrores');

//verifico
if($rowErrores!=false){
	//tabla existe, no se hace nada
}else{

	try {
		// elimino la tabla si es que existe
		//$query  = "DROP TABLE IF EXISTS `".$tabla_1_backup."`";
		//$result = mysqli_query($dbConn, $query);

		// se crea la nueva tabla
		$query  = "CREATE TABLE `".$tabla_1_backup."` (
			  `idErrores` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `idSistema` int(11) unsigned NOT NULL,
			  `idTelemetria` int(11) unsigned NOT NULL,
			  `idTipo` int(11) unsigned NOT NULL,
			  `Fecha` date NOT NULL,
			  `Hora` time NOT NULL,
			  `Sensor` int(2) unsigned NOT NULL,
			  `Descripcion` text NOT NULL,
			  `Valor` decimal(11,6) NOT NULL,
			  `Valor_min` decimal(11,6) NOT NULL,
			  `Valor_max` decimal(11,6) NOT NULL,
			  `GeoLatitud` double NOT NULL,
			  `GeoLongitud` double NOT NULL,
			  `TimeStamp` datetime NOT NULL ,
			  `idPersonalizado` int(11) unsigned NOT NULL,
			  `idLeido` int(11) unsigned NOT NULL,
			  `idTipoAlerta` int(11) unsigned NOT NULL,
			  `idUniMed` int(11) unsigned NOT NULL,
			  PRIMARY KEY (`idErrores`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Respaldo Tabla';";
		$result = mysqli_query($dbConn, $query);
	} catch (Exception $e) {
		error_log($e->getMessage(), 0);
	}
}

/**************************************************/
//inserto los datos en su tabla de respaldo
foreach ($arrSeleccion as $tel) {
	//filtros
	if(isset($tel['idErrores']) && $tel['idErrores']!=''){               $SIS_data  = "'".$tel['idErrores']."'";         }else{$SIS_data  ="''";}
	if(isset($tel['idSistema']) && $tel['idSistema']!=''){               $SIS_data .= ",'".$tel['idSistema']."'";        }else{$SIS_data .=",''";}
	if(isset($tel['idTelemetria']) && $tel['idTelemetria']!=''){         $SIS_data .= ",'".$tel['idTelemetria']."'";     }else{$SIS_data .=",''";}
	if(isset($tel['idTipo']) && $tel['idTipo']!=''){                     $SIS_data .= ",'".$tel['idTipo']."'";           }else{$SIS_data .=",''";}
	if(isset($tel['Fecha']) && $tel['Fecha']!=''){                       $SIS_data .= ",'".$tel['Fecha']."'";            }else{$SIS_data .=",''";}
	if(isset($tel['Hora']) && $tel['Hora']!=''){                         $SIS_data .= ",'".$tel['Hora']."'";             }else{$SIS_data .=",''";}
	if(isset($tel['Sensor']) && $tel['Sensor']!=''){                     $SIS_data .= ",'".$tel['Sensor']."'";           }else{$SIS_data .=",''";}
	if(isset($tel['Descripcion']) && $tel['Descripcion']!=''){           $SIS_data .= ",'".$tel['Descripcion']."'";      }else{$SIS_data .=",''";}
	if(isset($tel['Valor']) && $tel['Valor']!=''){                       $SIS_data .= ",'".$tel['Valor']."'";            }else{$SIS_data .=",''";}
	if(isset($tel['Valor_min']) && $tel['Valor_min']!=''){               $SIS_data .= ",'".$tel['Valor_min']."'";        }else{$SIS_data .=",''";}
	if(isset($tel['Valor_max']) && $tel['Valor_max']!=''){               $SIS_data .= ",'".$tel['Valor_max']."'";        }else{$SIS_data .=",''";}
	if(isset($tel['GeoLatitud']) && $tel['GeoLatitud']!=''){             $SIS_data .= ",'".$tel['GeoLatitud']."'";       }else{$SIS_data .=",''";}
	if(isset($tel['GeoLongitud']) && $tel['GeoLongitud']!=''){           $SIS_data .= ",'".$tel['GeoLongitud']."'";      }else{$SIS_data .=",''";}
	if(isset($tel['TimeStamp']) && $tel['TimeStamp']!=''){               $SIS_data .= ",'".$tel['TimeStamp']."'";        }else{$SIS_data .=",''";}
	if(isset($tel['idPersonalizado']) && $tel['idPersonalizado']!=''){   $SIS_data .= ",'".$tel['idPersonalizado']."'";  }else{$SIS_data .=",''";}
	if(isset($tel['idLeido']) && $tel['idLeido']!=''){                   $SIS_data .= ",'".$tel['idLeido']."'";          }else{$SIS_data .=",''";}
	if(isset($tel['idTipoAlerta']) && $tel['idTipoAlerta']!=''){         $SIS_data .= ",'".$tel['idTipoAlerta']."'";     }else{$SIS_data .=",''";}
	if(isset($tel['idUniMed']) && $tel['idUniMed']!=''){                 $SIS_data .= ",'".$tel['idUniMed']."'";         }else{$SIS_data .=",''";}

	// inserto los datos de registro en la db
	$SIS_columns = 'idErrores, idSistema,idTelemetria,
	idTipo,Fecha, Hora,Sensor,Descripcion,Valor, Valor_min,Valor_max,GeoLatitud,
	GeoLongitud,TimeStamp,idPersonalizado,idLeido,idTipoAlerta, idUniMed';
	$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, $tabla_1_backup, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

}

/**************************************************/
//elimino los datos
$resultado = db_delete_data (false, $tabla_1, 'idErrores BETWEEN 1 AND '.$rowPuntero['idErrores'], $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_delete_data');

?>
