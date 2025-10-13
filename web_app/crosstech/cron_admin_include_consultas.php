<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                        CONSULTAS A LAS TABLAS PARA EL DESPLIEGUE DE ERRORES                        */
/*                                                                                                    */
/******************************************************************************************************/
//Tivo de envio
switch ($TipoEnvio) {
    /*********************************/
    //Solo Email
    case 1:
        //Datos para enviar correos
        $SIS_query = '
        Nombre AS RazonSocial,email_principal AS email_principal,
        Config_Gmail_Usuario AS Gmail_Usuario,
        Config_Gmail_Password AS Gmail_Password';
        $rowSistema = db_select_data (false, $SIS_query, 'core_sistemas','', 'idSistema = 1', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

        break;
	/*********************************/
    //Solo Whatsapp (Full text)
    case 2:
		//Datos para enviar los whatsapp
        $SIS_query = '
        Config_WhatsappToken AS SistemaWhatsappToken,
		Config_WhatsappInstanceId AS SistemaWhatsappInstanceId';
        $rowSistema = db_select_data (false, $SIS_query, 'core_sistemas','', 'idSistema = 1', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

		/**********************************************************/
		$SIS_where_1 = "telemetria_listado_errores_999.idErrores!=0";           //siempre pasa
		$SIS_where_2 = "telemetria_listado_error_fuera_linea.idFueraLinea!=0";  //siempre pasa
		$SIS_where_3 = "telemetria_listado.idEstado = 1";                       //solo activos
		$SIS_where_1.=" AND telemetria_listado_errores_999.TimeStamp BETWEEN '".$FechaInicio." ".$HoraInicio."' AND '".$FechaTermino." ".$HoraTermino."'";
		$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.TimeStamp BETWEEN '".$FechaInicio." ".$HoraInicio."' AND '".$FechaTermino." ".$HoraTermino."'";

		$N_Maximo_Sensores = 72;
		$consql = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		}

		/*********************************************************/
		//Consulto
		$SIS_query = '
		core_sistemas.Nombre AS Sistema,
		telemetria_listado.Nombre AS EquipoNombre,
		telemetria_listado_errores_999.idTelemetria AS EquipoId,
		core_telemetria_tabs.Nombre AS EquipoTab,
		telemetria_listado_errores_999.Sensor AS EquipoNSensor,
		COUNT(telemetria_listado_errores_999.idErrores) AS Cuenta,
		telemetria_listado_errores_999.Descripcion,
		telemetria_listado_errores_999.Valor'.$consql;
		$SIS_join  = '
		LEFT JOIN telemetria_listado                     ON telemetria_listado.idTelemetria                  = telemetria_listado_errores_999.idTelemetria
		LEFT JOIN core_sistemas                          ON core_sistemas.idSistema                          = telemetria_listado_errores_999.idSistema
		LEFT JOIN core_telemetria_tabs                   ON core_telemetria_tabs.idTab                       = telemetria_listado.idTab
		LEFT JOIN `telemetria_listado_sensores_nombre`   ON telemetria_listado_sensores_nombre.idTelemetria  = telemetria_listado_errores_999.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_grupo`    ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado_errores_999.idTelemetria';
		$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_errores_999.Sensor ASC, telemetria_listado_errores_999.Descripcion ASC, telemetria_listado_errores_999.Valor ASC';	
		$SIS_where_1.= ' GROUP BY core_sistemas.Nombre,telemetria_listado.Nombre,core_telemetria_tabs.Nombre,telemetria_listado_errores_999.Sensor, telemetria_listado_errores_999.Descripcion, telemetria_listado_errores_999.Valor';
		$arrEquipos1 = array();
		$arrEquipos1 = db_select_array (false, $SIS_query, 'telemetria_listado_errores_999', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos1');

		/*********************************************************/
		//Consulto
		$SIS_query = '
		core_sistemas.Nombre AS Sistema,
		telemetria_listado.Nombre AS EquipoNombre,
		core_telemetria_tabs.Nombre AS EquipoTab,
		telemetria_listado_error_fuera_linea.Fecha_inicio,
		telemetria_listado_error_fuera_linea.Hora_inicio,
		telemetria_listado_error_fuera_linea.Fecha_termino,
		telemetria_listado_error_fuera_linea.Hora_termino,
		telemetria_listado_error_fuera_linea.Tiempo';
		$SIS_join  = '
		LEFT JOIN telemetria_listado     ON telemetria_listado.idTelemetria  = telemetria_listado_error_fuera_linea.idTelemetria
		LEFT JOIN core_sistemas          ON core_sistemas.idSistema          = telemetria_listado_error_fuera_linea.idSistema
		LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab       = telemetria_listado.idTab';
		$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_error_fuera_linea.Fecha_inicio ASC';	
		$arrErrores = array();
		$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrErrores');

		/*********************************************************/
		//Consulto
		$SIS_query = '
		core_sistemas.Nombre AS Sistema,
		telemetria_listado.Nombre AS EquipoNombre,
		core_telemetria_tabs.Nombre AS EquipoTab,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.TiempoFueraLinea';
		$SIS_join  = '
		LEFT JOIN `core_sistemas`        ON core_sistemas.idSistema      = telemetria_listado.idSistema
		LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab   = telemetria_listado.idTab';
		$SIS_order = 'telemetria_listado.idSistema ASC';
		$arrTelemetria = array();
		$arrTelemetria = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where_3, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrTelemetria');

		/*********************************************************/
		//Se consultan datos
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

		$arrFinalGrupos = array();
		foreach ($arrGrupos as $sen) {
			$arrFinalGrupos[$sen['idGrupo']] = DeSanitizar($sen['Nombre']);
		}

        break;
    /*********************************/
    //Ambos  (Whatsapp Full text)
    case 3:
        //Datos para enviar correos
        $SIS_query = '
        Nombre AS RazonSocial,
        email_principal AS email_principal,
        Config_Gmail_Usuario AS Gmail_Usuario,
        Config_Gmail_Password AS Gmail_Password,
        Config_WhatsappToken AS SistemaWhatsappToken,
		Config_WhatsappInstanceId AS SistemaWhatsappInstanceId';
        $rowSistema = db_select_data (false, $SIS_query, 'core_sistemas','', 'idSistema = 1', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

		/**********************************************************/
		$SIS_where_1 = "telemetria_listado_errores_999.idErrores!=0";           //siempre pasa
		$SIS_where_2 = "telemetria_listado_error_fuera_linea.idFueraLinea!=0";  //siempre pasa
		$SIS_where_3 = "telemetria_listado.idEstado = 1";                       //solo activos
		$SIS_where_1.=" AND telemetria_listado_errores_999.TimeStamp BETWEEN '".$FechaInicio." ".$HoraInicio."' AND '".$FechaTermino." ".$HoraTermino."'";
		$SIS_where_2.=" AND telemetria_listado_error_fuera_linea.TimeStamp BETWEEN '".$FechaInicio." ".$HoraInicio."' AND '".$FechaTermino." ".$HoraTermino."'";

		$N_Maximo_Sensores = 72;
		$consql = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		}

		/*********************************************************/
		//Consulto
		$SIS_query = '
		core_sistemas.Nombre AS Sistema,
		telemetria_listado.Nombre AS EquipoNombre,
		telemetria_listado_errores_999.idTelemetria AS EquipoId,
		core_telemetria_tabs.Nombre AS EquipoTab,
		telemetria_listado_errores_999.Sensor AS EquipoNSensor,
		COUNT(telemetria_listado_errores_999.idErrores) AS Cuenta,
		telemetria_listado_errores_999.Descripcion,
		telemetria_listado_errores_999.Valor'.$consql;
		$SIS_join  = '
		LEFT JOIN telemetria_listado                    ON telemetria_listado.idTelemetria                 = telemetria_listado_errores_999.idTelemetria
		LEFT JOIN core_sistemas                         ON core_sistemas.idSistema                         = telemetria_listado_errores_999.idSistema
		LEFT JOIN core_telemetria_tabs                  ON core_telemetria_tabs.idTab                      = telemetria_listado.idTab
		LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria = telemetria_listado_errores_999.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria  = telemetria_listado_errores_999.idTelemetria';
		$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_errores_999.Sensor ASC, telemetria_listado_errores_999.Descripcion ASC, telemetria_listado_errores_999.Valor ASC';	
		$SIS_where_1.= ' GROUP BY core_sistemas.Nombre,telemetria_listado.Nombre,core_telemetria_tabs.Nombre,telemetria_listado_errores_999.Sensor, telemetria_listado_errores_999.Descripcion, telemetria_listado_errores_999.Valor';
		$arrEquipos1 = array();
		$arrEquipos1 = db_select_array (false, $SIS_query, 'telemetria_listado_errores_999', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos1');

		/*********************************************************/
		//Consulto
		$SIS_query = '
		core_sistemas.Nombre AS Sistema,
		telemetria_listado.Nombre AS EquipoNombre,
		core_telemetria_tabs.Nombre AS EquipoTab,
		telemetria_listado_error_fuera_linea.Fecha_inicio,
		telemetria_listado_error_fuera_linea.Hora_inicio,
		telemetria_listado_error_fuera_linea.Fecha_termino,
		telemetria_listado_error_fuera_linea.Hora_termino,
		telemetria_listado_error_fuera_linea.Tiempo';
		$SIS_join  = '
		LEFT JOIN telemetria_listado     ON telemetria_listado.idTelemetria  = telemetria_listado_error_fuera_linea.idTelemetria
		LEFT JOIN core_sistemas          ON core_sistemas.idSistema          = telemetria_listado_error_fuera_linea.idSistema
		LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab       = telemetria_listado.idTab';
		$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC, core_telemetria_tabs.Nombre ASC, telemetria_listado_error_fuera_linea.Fecha_inicio ASC';	
		$arrErrores = array();
		$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrErrores');

		/*********************************************************/
		//Consulto
		$SIS_query = '
		core_sistemas.Nombre AS Sistema,
		telemetria_listado.Nombre AS EquipoNombre,
		core_telemetria_tabs.Nombre AS EquipoTab,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.TiempoFueraLinea';
		$SIS_join  = '
		LEFT JOIN `core_sistemas`        ON core_sistemas.idSistema      = telemetria_listado.idSistema
		LEFT JOIN core_telemetria_tabs   ON core_telemetria_tabs.idTab   = telemetria_listado.idTab';
		$SIS_order = 'telemetria_listado.idSistema ASC';
		$arrTelemetria = array();
		$arrTelemetria = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where_3, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrTelemetria');

		/*********************************************************/
		//Se consultan datos
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

		$arrFinalGrupos = array();
		foreach ($arrGrupos as $sen) {
			$arrFinalGrupos[$sen['idGrupo']] = DeSanitizar($sen['Nombre']);
		}

        break;
    /*********************************/
    //Solo Whatsapp (Enlace Archivo)
    case 4:
        //Datos para enviar los whatsapp
        $SIS_query = '
        Config_WhatsappToken AS SistemaWhatsappToken,
		Config_WhatsappInstanceId AS SistemaWhatsappInstanceId';
        $rowSistema = db_select_data (false, $SIS_query, 'core_sistemas','', 'idSistema = 1', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

        break;
    /*********************************/
    //Ambos  (Whatsapp Enlace Archivo)
    case 5:

        //Datos para enviar correos
        $SIS_query = '
        Nombre AS RazonSocial,
        email_principal AS email_principal,
        Config_Gmail_Usuario AS Gmail_Usuario,
        Config_Gmail_Password AS Gmail_Password,
        Config_WhatsappToken AS SistemaWhatsappToken,
		Config_WhatsappInstanceId AS SistemaWhatsappInstanceId';
        $rowSistema = db_select_data (false, $SIS_query, 'core_sistemas','', 'idSistema = 1', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSistema');

		break;

}


?>
