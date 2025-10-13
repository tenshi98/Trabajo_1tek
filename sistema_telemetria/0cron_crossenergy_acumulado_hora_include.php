<?php
//Verifico que dato exista
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){

	//Obtengo todos los equipos de telemetria activos
	$z = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$z .= " AND telemetria_listado.idTab = 9"; //Power-Energy
	//Filtro el sistema al cual pertenece
	$z .= " AND telemetria_listado.idSistema = ".$idSistema;

	//Listar los equipos
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, 'idTelemetria, cantSensores ', 'telemetria_listado', '', $z, 'telemetria_listado.idTelemetria ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	//recorro los equipos
	foreach ($arrEquipo as $data) {

		/*********************************************************/
		//genero filtros
		$SIS_query = 'Segundos';
		for ($i = 1; $i <= $data['cantSensores']; $i++) {
			$SIS_query .= ',Sensor_'.$i;
		}
		$SIS_where = " (TimeStamp BETWEEN '".$FechaInicio." ".$HoraInicio ."' AND '".$FechaTermino." ".$HoraTermino."')";

		//consulto
		$arrPromedio = array();
		$arrPromedio = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$data['idTelemetria'], '', $SIS_where, 'TimeStamp ASC', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrPromedio');

		/*********************************************************/
		//Variables
		$SumaSensor = array();
		//recorro
		foreach ($arrPromedio as $prom) {
			//verifico que existan segundos
			if(isset($prom['Segundos'])&&$prom['Segundos']!=0){
				//recorro sensores
				for ($i = 1; $i <= $data['cantSensores']; $i++) {
					//Operacion
					$Total = ($prom['Sensor_'.$i]*$prom['Segundos'])/3600;
					//verifico si existe variable
					if(isset($SumaSensor[$i])&&$SumaSensor[$i]!=''){
						$SumaSensor[$i] = $SumaSensor[$i] + $Total;
					}else{
						$SumaSensor[$i] = $Total;
					}
				}
			}
		}
		/*********************************************************/
		//Genero la cadena
		$chain_in = '';
		//cadena
		$SIS_data  = "'".$data['idTelemetria']."'";
		$SIS_data .= ",'".$FechaTermino."'";
		$SIS_data .= ",'".fecha2NdiaMes($FechaTermino)."'";
		$SIS_data .= ",'".fecha2NMes($FechaTermino)."'";
		$SIS_data .= ",'".fecha2Ano($FechaTermino)."'";
		$SIS_data .= ",'".$HoraTermino."'";
		$SIS_data .= ",'".$FechaTermino." ".$HoraTermino."'";
		//recorro sensores
		for ($i = 1; $i <= $data['cantSensores']; $i++) {
			//verifico que exista
			if(isset($SumaSensor[$i])&&$SumaSensor[$i]!=''){
				$SIS_data .= ",'".$SumaSensor[$i]."'";
				$chain_in .= ',Sensor_'.$i;
			}
		}

		/*********************************************************/
		// inserto los datos de registro en la db
		$SIS_columns = 'idTelemetria, FechaSistema, FechaSistema_dia, FechaSistema_mes,
		FechaSistema_ano, HoraSistema, TimeStamp'.$chain_in;
		$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_crossenergy_hora', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

	}

}


?>
