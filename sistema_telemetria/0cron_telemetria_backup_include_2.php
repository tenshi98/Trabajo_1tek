<?php
/**********************************************************************************************************************************/
/*                                              Alertas de telemetria 999                                                         */
/**********************************************************************************************************************************/
/**************************************************/
//Obtengo los punteros para el respaldo
$SIS_query = 'idErrores';
$SIS_join  = '';
$SIS_where = 'idErrores!=0 ORDER BY idErrores DESC LIMIT 1 OFFSET '.$N_Reg_Errores999;
$rowPuntero = db_select_data (false, $SIS_query, $tabla_2, $SIS_join, $SIS_where, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowPuntero');

/**************************************************/
//hago una seleccion de datos
$arrSeleccion = array();
$arrSeleccion = db_select_array (false, 'idErrores,idSistema,idTelemetria,Fecha,Hora,Sensor,Descripcion,Valor,GeoLatitud,GeoLongitud,TimeStamp,idLeido, idUniMed', $tabla_2, '', 'idErrores BETWEEN 1 AND '.$rowPuntero['idErrores'], 'idErrores ASC', $dbConn, '0cron_telemetria_backup_include_2', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSeleccion');

/**************************************************/
//verifico si tabla de respaldo existe, si no existe se crea
$SIS_query = 'idErrores';
$SIS_join  = '';
$SIS_where = 'idErrores!=0 ORDER BY idErrores DESC';
$rowErrores = db_select_data (false, $SIS_query, $tabla_2_backup, $SIS_join, $SIS_where, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowErrores');

//verifico
if($rowErrores!=false){
	//tabla existe, no se hace nada
}else{

	try {
		// elimino la tabla si es que existe
		//$query  = "DROP TABLE IF EXISTS `".$tabla_2_backup."`";
		//$result = mysqli_query($dbConn, $query);

		// se crea la nueva tabla
		$query  = "CREATE TABLE `".$tabla_2_backup."` (
			  `idErrores` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `idSistema` int(11) unsigned NOT NULL,
			  `idTelemetria` int(11) unsigned NOT NULL,
			  `Fecha` date NOT NULL,
			  `Hora` time NOT NULL,
			  `Sensor` int(2) unsigned NOT NULL,
			  `Descripcion` text NOT NULL,
			  `Valor` decimal(11,6) NOT NULL,
			  `GeoLatitud` double NOT NULL,
			  `GeoLongitud` double NOT NULL,
			  `TimeStamp` datetime NOT NULL ,
			  `idLeido` int(11) unsigned NOT NULL,
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
	if(isset($tel['idErrores']) && $tel['idErrores']!=''){        $SIS_data  = "'".$tel['idErrores']."'";         }else{$SIS_data  ="''";}
	if(isset($tel['idSistema']) && $tel['idSistema']!=''){        $SIS_data .= ",'".$tel['idSistema']."'";        }else{$SIS_data .=",''";}
	if(isset($tel['idTelemetria']) && $tel['idTelemetria']!=''){  $SIS_data .= ",'".$tel['idTelemetria']."'";     }else{$SIS_data .=",''";}
	if(isset($tel['Fecha']) && $tel['Fecha']!=''){                $SIS_data .= ",'".$tel['Fecha']."'";            }else{$SIS_data .=",''";}
	if(isset($tel['Hora']) && $tel['Hora']!=''){                  $SIS_data .= ",'".$tel['Hora']."'";             }else{$SIS_data .=",''";}
	if(isset($tel['Sensor']) && $tel['Sensor']!=''){              $SIS_data .= ",'".$tel['Sensor']."'";           }else{$SIS_data .=",''";}
	if(isset($tel['Descripcion']) && $tel['Descripcion']!=''){    $SIS_data .= ",'".$tel['Descripcion']."'";      }else{$SIS_data .=",''";}
	if(isset($tel['Valor']) && $tel['Valor']!=''){                $SIS_data .= ",'".$tel['Valor']."'";            }else{$SIS_data .=",''";}
	if(isset($tel['GeoLatitud']) && $tel['GeoLatitud']!=''){      $SIS_data .= ",'".$tel['GeoLatitud']."'";       }else{$SIS_data .=",''";}
	if(isset($tel['GeoLongitud']) && $tel['GeoLongitud']!=''){    $SIS_data .= ",'".$tel['GeoLongitud']."'";      }else{$SIS_data .=",''";}
	if(isset($tel['TimeStamp']) && $tel['TimeStamp']!=''){        $SIS_data .= ",'".$tel['TimeStamp']."'";        }else{$SIS_data .=",''";}
	if(isset($tel['idLeido']) && $tel['idLeido']!=''){            $SIS_data .= ",'".$tel['idLeido']."'";          }else{$SIS_data .=",''";}
	if(isset($tel['idUniMed']) && $tel['idUniMed']!=''){          $SIS_data .= ",'".$tel['idUniMed']."'";         }else{$SIS_data .=",''";}

	// inserto los datos de registro en la db
	$SIS_columns = 'idErrores, idSistema,idTelemetria, Fecha, Hora,Sensor,Descripcion,Valor, GeoLatitud, GeoLongitud,TimeStamp,idLeido, idUniMed';
	$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, $tabla_2_backup, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

}

/**************************************************/
//elimino los datos
$resultado = db_delete_data (false, $tabla_2, 'idErrores BETWEEN 1 AND '.$rowPuntero['idErrores'], $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_delete_data');

?>
