<?php
/**********************************************************************************************************************************/
/*                                          SEGUNDA VUELTA DE LIMPIEZA                                                            */
/**********************************************************************************************************************************/
/*******************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado_historial_activaciones.idH_Activacion,
telemetria_listado_historial_activaciones.idTelemetria,
telemetria_listado_historial_activaciones.Hora,
telemetria_listado_historial_activaciones.Valor,
telemetria_listado.Microparada';
$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_historial_activaciones.idTelemetria';
$SIS_where = 'telemetria_listado_historial_activaciones.Fecha="'.$fecha_real.'"';
$SIS_where.= ' AND telemetria_listado_historial_activaciones.idEstado=1';
$SIS_order = 'telemetria_listado_historial_activaciones.idTelemetria ASC';
$SIS_order.= ', telemetria_listado_historial_activaciones.Fecha ASC';
$SIS_order.= ', telemetria_listado_historial_activaciones.Hora ASC';
$arrErrores = array();
$arrErrores = db_select_array (false, $SIS_query, 'telemetria_listado_historial_activaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrErrores');

/*********************************/
//Variables
$idAntiguo    = 0;
$HoraAntiguo  = '';
$idTelemetria = 0;
$ValorAntiguo = 0;

foreach ($arrErrores as $errn) {

	//Verifico si es la primera vuelta
	if($idAntiguo==0&&$HoraAntiguo==''){
		$idAntiguo     = $errn['idH_Activacion'];
		$HoraAntiguo   = $errn['Hora'];
		$idTelemetria  = $errn['idTelemetria'];
		$ValorAntiguo  = valores_truncados($errn['Valor']);
	//Si es la segunda o mas ejecuto
	}else{
		//Verifico que sea la misma grua
		if($idTelemetria==$errn['idTelemetria']){
			/********************************************************************************/
			//Si el dato anterior era una desactivacion y el actual una activacion
			if($ValorAntiguo==0&&valores_truncados($errn['Valor'])==1){
				//realizo resta de horas
				$Tiempo = restahoras($HoraAntiguo, $errn['Hora']);
				//Se dejan fuera todas las microparadas
				if($Tiempo<$errn['Microparada']){

					//se saca de la seleccion la activacion
					$query  = "UPDATE `telemetria_listado_historial_activaciones` SET idEstado=2 WHERE idH_Activacion = '".$idAntiguo."'";
					$resultado = mysqli_query ($dbConn, $query);

					//se saca de la seleccion la desactivacion
					$query  = "UPDATE `telemetria_listado_historial_activaciones` SET idEstado=2 WHERE idH_Activacion = '".$errn['idH_Activacion']."'";
					$resultado = mysqli_query ($dbConn, $query);

				}
			}
			/********************************************************************************/
			//Si el dato anterior era una desactivacion y el actual una desactivacion
			if($ValorAntiguo==0&&valores_truncados($errn['Valor'])==0){

				//se saca de la seleccion la desactivacion
				$query  = "UPDATE `telemetria_listado_historial_activaciones` SET idEstado=2 WHERE idH_Activacion = '".$errn['idH_Activacion']."'";
				$resultado = mysqli_query ($dbConn, $query);

			}
			/********************************************************************************/
			//Si el dato anterior era una activacion y el actual una activacion
			if($ValorAntiguo==1&&valores_truncados($errn['Valor'])==1){

				//se saca de la seleccion la desactivacion
				$query  = "UPDATE `telemetria_listado_historial_activaciones` SET idEstado=2 WHERE idH_Activacion = '".$idAntiguo."'";
				$resultado = mysqli_query ($dbConn, $query);

			}
		}

		//Actualizo datos
		$idAntiguo     = $errn['idH_Activacion'];
		$HoraAntiguo   = $errn['Hora'];
		$idTelemetria  = $errn['idTelemetria'];
		$ValorAntiguo  = valores_truncados($errn['Valor']);
	}

}

?>
