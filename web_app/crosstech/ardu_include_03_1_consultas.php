<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                       CONSULTA DE LOS DATOS DEL EQUIPO                             */
/*                                                                                                    */
/******************************************************************************************************/
//Se arma la queri con los datos justos recibidos
$SIS_query = 'telemetria_listado.idTelemetria';
//Datos Guardados
$SIS_query .= ',telemetria_listado.LastUpdateFecha';  //Ultima fecha
$SIS_query .= ',telemetria_listado.LastUpdateHora';   //Ultima Hora
$SIS_query .= ',telemetria_listado.idEstado';         //Estado del equipo
$SIS_query .= ',telemetria_listado.Nombre';           //Nombre del equipo
$SIS_query .= ',telemetria_listado.idSistema';        //Sistema
$SIS_query .= ',telemetria_listado.Estado';           //Estado de encendido

//Configuracion
$SIS_query .= ',telemetria_listado.idUsoPredio';        //Si se utilizan los predios
$SIS_query .= ',telemetria_listado.idAlertaTemprana';   //Si el equipo envia las alertas inmediatamente una vez que ocurren
$SIS_query .= ',telemetria_listado.AlertaTemprCritica'; //Tiempo de envio entre las alertas criticas enviadas
$SIS_query .= ',telemetria_listado.AlertaTemprNormal';  //Tiempo de envio entre las alertas criticas normales
$SIS_query .= ',telemetria_listado.TiempoFueraLinea';   //Tiempo maximo fuera de linea
$SIS_query .= ',telemetria_listado.idTab';              //Tipo de plkataforma al que pertenece

//GPS
$SIS_query .= ',telemetria_listado.id_Geo';             //Activacion geolocalizacion
$SIS_query .= ',telemetria_listado.GeoLatitud';         //Ultima latitud
$SIS_query .= ',telemetria_listado.GeoLongitud';        //Ultima longitud
$SIS_query .= ',telemetria_listado.GeoTiempoDetencion'; //Suma tiempo detencion Actual
$SIS_query .= ',telemetria_listado.TiempoDetencion';    //Maximo tiempo de detencion
$SIS_query .= ',telemetria_listado.NDetenciones';       //Suma de veces dentro del radio de 10 metros
$SIS_query .= ',telemetria_listado.LimiteVelocidad';    //Limite de velocidad para los vehiculos
$SIS_query .= ',telemetria_listado.GeoErrores';         //Numero de errores de Latitud y longitud en 0

//Sensores
$SIS_query .= ',telemetria_listado.id_Sensores';           //Uso de sensores
$SIS_query .= ',telemetria_listado.SensorActivacionID';    //Sensor que indica que esta activo
$SIS_query .= ',telemetria_listado.SensorActivacionValor'; //Valor que indica que esta activo

//Alertas
$SIS_query .= ',telemetria_listado.NErrores';  //Numero de errores actuales
$SIS_query .= ',telemetria_listado.NAlertas';  //Numero de alertas sin leer

//Alertas
$SIS_query .= ',telemetria_listado.MedicionTiempo';  //Tiempo de uso del equipo
$SIS_query .= ',telemetria_listado.CrossCMinHorno';  //Temperatura Minima para los hornos

//Estado de encendido del equipo
$SIS_query .= ',telemetria_listado.idEstadoEncendido';

for ($i = 1; $i <= $Var_Counter; $i++) {
	//sensores
	$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;                 //Si el sensor esta siendo utilizado
	$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;          //Ultima medicion guardada del sensor
	//Uso de sensores
	$SIS_query .= ',telemetria_listado_sensores_uso.SensoresUso_'.$i;                       //si esta siendo supervisado
	$SIS_query .= ',telemetria_listado_sensores_accion_med_c.SensoresAccionMedC_'.$i;       //cantidad de uso
	$SIS_query .= ',telemetria_listado_sensores_accion_med_t.SensoresAccionMedT_'.$i;       //Tiempo de uso
	//revision uso grupo sensores
	$SIS_query .= ',telemetria_listado_sensores_revision.SensoresRevision_'.$i;             //Opción si-no
	$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;  //Grupo relacionado
	//alertas 999xx
	$SIS_query .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;                 //Nombre del sensor
	$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;                 //Unidad de medida del sensor

	//correccion automatica
	$SIS_query .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$i;                     //Tipo de sensor para la correccion automatica de datos

}

//Se realiza consulta por los ultimos datos guardados
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_uso`             ON telemetria_listado_sensores_uso.idTelemetria            = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_med_c`    ON telemetria_listado_sensores_accion_med_c.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_med_t`    ON telemetria_listado_sensores_accion_med_t.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision`        ON telemetria_listado_sensores_revision.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_tipo`            ON telemetria_listado_sensores_tipo.idTelemetria           = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.Identificador ="'.$Identificador.'"';
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, 'ardu_include_consultas', basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>
