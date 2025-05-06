<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                       Armado de las notificaciones                                 */
/*                                                                                                    */
/******************************************************************************************************/
//Listado de errores
foreach ($arrErrores as $error) {

	//Se verifica si existe
	if(!isset($AlertasNormales[$error['idTelemetria']]) OR $AlertasNormales[$error['idTelemetria']]==''){             $AlertasNormales[$error['idTelemetria']]        = '';}
	if(!isset($AlertasCatastroficas[$error['idTelemetria']]) OR $AlertasCatastroficas[$error['idTelemetria']]==''){   $AlertasCatastroficas[$error['idTelemetria']]   = '';}
	if(!isset($AlertasVelocidad[$error['idTelemetria']]) OR $AlertasVelocidad[$error['idTelemetria']]==''){           $AlertasVelocidad[$error['idTelemetria']]       = '';}
	//Se verifica si existe
	if(!isset($AlertasNormales_Whatsapp[$error['idTelemetria']]) OR $AlertasNormales_Whatsapp[$error['idTelemetria']]==''){             $AlertasNormales_Whatsapp[$error['idTelemetria']]        = '';}
	if(!isset($AlertasCatastroficas_Whatsapp[$error['idTelemetria']]) OR $AlertasCatastroficas_Whatsapp[$error['idTelemetria']]==''){   $AlertasCatastroficas_Whatsapp[$error['idTelemetria']]   = '';}
	if(!isset($AlertasVelocidad_Whatsapp[$error['idTelemetria']]) OR $AlertasVelocidad_Whatsapp[$error['idTelemetria']]==''){           $AlertasVelocidad_Whatsapp[$error['idTelemetria']]       = '';}

	//Solo si los errores son distintos de 99900
	if(isset($error['Valor'])&&$error['Valor']<99900){

		/*********************************************************/
		//Verifico si pertenece a la señal digital
		$senal = array('Senal Digital','Señal Digital');
		$s_count = 0;
		//se revisa una a una
		for ($i=0; $i < count($senal); $i++) {
			if( strpos($error['Descripcion'],$senal[$i]) !== false ){
				$s_count++;
			}
		}

		/*********************************************************/
		//Filtro por tipo de error
		switch ($error['idTipo']) {
			/***************************************/
			//Fuera de Rango
			case 1:
				//Filtro por normal o personalizado
				switch ($error['idPersonalizado']) {
					/***************************************/
					//Personalizado
					case 1:
						//Filtro por normal o Catastroficas
						switch ($error['idTipoAlerta']) {
							/***************************************/
							//Normal
							case 0:
								//se crea cuerpo
								$AlertasNormales[$error['idTelemetria']] .= '<tr style="background: #fff;">';
									$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['SistemaNombre']).'</td>';
									$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['NombreEquipo']).'</td>';
									$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['Descripcion']).'</td>';
									$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.fecha_estandar($error['Fecha']).'</td>';
									$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$error['Hora'].'</td>';
									//si no es digital
									if($s_count==0){
										$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor']).'</td>';
										$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor_min']).'</td>';
										$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor_max']).'</td>';
									//si es digital
									}else{
										//Verifico el valor de activacion
										if($error['Valor']==1){$sx_men = 'Activo';}else{$sx_men = 'Inactivo';}
										//despliego la alerta
										$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$sx_men.'</td>';
										$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;"></td>';
										$AlertasNormales[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;"></td>';
									}
								$AlertasNormales[$error['idTelemetria']] .= '</tr>';
								/**************************************************/
								//se crea cuerpo de whatsapp
								$AlertasNormales_Whatsapp[$error['idTelemetria']] .= 'Equipo <strong>'.DeSanitizar($error['NombreEquipo']).'</strong>';
								$AlertasNormales_Whatsapp[$error['idTelemetria']] .= ' en el Sistema <strong>'.DeSanitizar($error['SistemaNombre']).'</strong>';
								$AlertasNormales_Whatsapp[$error['idTelemetria']] .= ' presenta '.DeSanitizar($error['Descripcion']);
								$AlertasNormales_Whatsapp[$error['idTelemetria']] .= ' desde el '.fecha_estandar($error['Fecha']);
								$AlertasNormales_Whatsapp[$error['idTelemetria']] .= ' a las '.$error['Hora'].'<br/>';

								break;
							/***************************************/
							//Catastroficas
							case 1:
								//se crea cuerpo
								$AlertasCatastroficas[$error['idTelemetria']] .= '<tr style="background: #fff;">';
									$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['SistemaNombre']).'</td>';
									$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['NombreEquipo']).'</td>';
									$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['Descripcion']).'</td>';
									$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.fecha_estandar($error['Fecha']).'</td>';
									$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$error['Hora'].'</td>';
									//si no es digital
									if($s_count==0){
										$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor']).'</td>';
										$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor_min']).'</td>';
										$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor_max']).'</td>';
									//si es digital
									}else{
										//Verifico el valor de activacion
										if($error['Valor']==1){$sx_men = 'Activo';}else{$sx_men = 'Inactivo';}
										//despliego la alerta
										$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$sx_men.'</td>';
										$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;"></td>';
										$AlertasCatastroficas[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;"></td>';
									}
								$AlertasCatastroficas[$error['idTelemetria']] .= '</tr>';
								/**************************************************/
								//se crea cuerpo de whatsapp
								$AlertasCatastroficas_Whatsapp[$error['idTelemetria']] .= 'Equipo <strong>'.DeSanitizar($error['NombreEquipo']).'</strong>';
								$AlertasCatastroficas_Whatsapp[$error['idTelemetria']] .= ' en el Sistema <strong>'.DeSanitizar($error['SistemaNombre']).'</strong>';
								$AlertasCatastroficas_Whatsapp[$error['idTelemetria']] .= ' presenta '.DeSanitizar($error['Descripcion']);
								$AlertasCatastroficas_Whatsapp[$error['idTelemetria']] .= ' desde el '.fecha_estandar($error['Fecha']);
								$AlertasCatastroficas_Whatsapp[$error['idTelemetria']] .= ' a las '.$error['Hora'].'<br/>';

								break;
						}
						break;
				}
				break;
			/***************************************/
			//Exceso Limite Velocidad
			case 2:
				//se crea cuerpo
				$AlertasVelocidad[$error['idTelemetria']] .= '<tr style="background: #fff;">';
					$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['SistemaNombre']).'</td>';
					$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['NombreEquipo']).'</td>';
					$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($error['Descripcion']).'</td>';
					$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.fecha_estandar($error['Fecha']).'</td>';
					$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$error['Hora'].'</td>';
					//si no es digital
					if($s_count==0){
						$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor']).'</td>';
						$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor_min']).'</td>';
						$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.Cantidades_decimales_justos($error['Valor_max']).'</td>';
					//si es digital
					}else{
						//Verifico el valor de activacion
						if($error['Valor']==1){$sx_men = 'Activo';}else{$sx_men = 'Inactivo';}
						//despliego la alerta
						$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$sx_men.'</td>';
						$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;"></td>';
						$AlertasVelocidad[$error['idTelemetria']] .= '<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;"></td>';
					}
				$AlertasVelocidad[$error['idTelemetria']] .= '</tr>';
				/**************************************************/
				//se crea cuerpo de whatsapp
				$AlertasVelocidad_Whatsapp[$error['idTelemetria']] .= 'Equipo <strong>'.DeSanitizar($error['NombreEquipo']).'</strong>';
				$AlertasVelocidad_Whatsapp[$error['idTelemetria']] .= ' en el Sistema <strong>'.DeSanitizar($error['SistemaNombre']).'</strong>';
				$AlertasVelocidad_Whatsapp[$error['idTelemetria']] .= ' presenta '.DeSanitizar($error['Descripcion']);
				$AlertasVelocidad_Whatsapp[$error['idTelemetria']] .= ' desde el '.fecha_estandar($error['Fecha']);
				$AlertasVelocidad_Whatsapp[$error['idTelemetria']] .= ' a las '.$error['Hora'].'<br/>';

				break;
		}
	}
}
/*************************************************************/
//Listado de fuera de geocerca
foreach ($arrFueraGeocerca as $fuera) {
	//Se verifica si existe
	if(!isset($FueraGeocerca[$fuera['idTelemetria']]) OR $FueraGeocerca[$fuera['idTelemetria']]==''){                    $FueraGeocerca[$fuera['idTelemetria']]          = '';}
	if(!isset($FueraGeocerca_Whatsapp[$fuera['idTelemetria']]) OR $FueraGeocerca_Whatsapp[$fuera['idTelemetria']]==''){  $FueraGeocerca_Whatsapp[$fuera['idTelemetria']] = '';}
	/**************************************************/
	//se crea cuerpo de la tabla
	$FueraGeocerca[$fuera['idTelemetria']] .= '
	<tr style="background: #fff;">
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($fuera['SistemaNombre']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($fuera['NombreEquipo']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($fuera['Descripcion']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.fecha_estandar($fuera['Fecha']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$fuera['Hora'].' hrs</td>
	</tr>';
	/**************************************************/
	//se crea cuerpo de whatsapp
	$FueraGeocerca_Whatsapp[$fuera['idTelemetria']] .= 'Equipo <strong>'.DeSanitizar($fuera['NombreEquipo']).'</strong>';
	$FueraGeocerca_Whatsapp[$fuera['idTelemetria']] .= ' en el Sistema <strong>'.DeSanitizar($fuera['SistemaNombre']).'</strong>';
	$FueraGeocerca_Whatsapp[$fuera['idTelemetria']] .= ' presenta '.DeSanitizar($fuera['Descripcion']);
	$FueraGeocerca_Whatsapp[$fuera['idTelemetria']] .= ' desde el '.fecha_estandar($fuera['Fecha']);
	$FueraGeocerca_Whatsapp[$fuera['idTelemetria']] .= ' a las '.$fuera['Hora'].' hrs<br/>';
}
/*************************************************************/
//Listado de fuera de linea
foreach ($arrFueraLinea as $fuera) {
	//Se verifica si existe
	if(!isset($FueraLinea[$fuera['idTelemetria']]) OR $FueraLinea[$fuera['idTelemetria']]==''){                    $FueraLinea[$fuera['idTelemetria']]          = '';}
	if(!isset($FueraLinea_Whatsapp[$fuera['idTelemetria']]) OR $FueraLinea_Whatsapp[$fuera['idTelemetria']]==''){  $FueraLinea_Whatsapp[$fuera['idTelemetria']] = '';}
	/**************************************************/
	//se crea cuerpo de la tabla
	$FueraLinea[$fuera['idTelemetria']] .= '
	<tr style="background: #fff;">
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($fuera['SistemaNombre']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($fuera['NombreEquipo']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.fecha_estandar($fuera['Fecha_inicio']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$fuera['Hora_inicio'].' hrs</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.fecha_estandar($fuera['Fecha_termino']).'</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$fuera['Hora_termino'].' hrs</td>
		<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$fuera['Tiempo'].' hrs</td>
	</tr>';
	/**************************************************/
	//se crea cuerpo de whatsapp
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= 'Equipo <strong>'.DeSanitizar($fuera['NombreEquipo']).'</strong>';
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= ' en el Sistema <strong>'.DeSanitizar($fuera['SistemaNombre']).'</strong>';
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= ' ha estado fuera de linea';
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= ' desde el '.fecha_estandar($fuera['Fecha_inicio']);
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= ' a las '.$fuera['Hora_inicio'].' hrs';
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= ' hasta el '.fecha_estandar($fuera['Fecha_termino']);
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= ' a las '.$fuera['Hora_termino'].' hrs';
	$FueraLinea_Whatsapp[$fuera['idTelemetria']] .= ' por un total de '.$fuera['Tiempo'].' hrs<br/>';
}
/*************************************************************/
//Listado de fuera de linea actuales
foreach ($arrTelemetria as $tel) {
	//Verifico la resta de la hora de la ulima actualizacion contra  la hora actual
	$diaInicio   = $tel['LastUpdateFecha'];
	$diaTermino  = $FechaSistema;
	$tiempo1     = $tel['LastUpdateHora'];
	$tiempo2     = $HoraSistema;
	$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

	//Comparaciones de tiempo
	$Time_Tiempo     = horas2segundos($Tiempo);
	$Time_Tiempo_FL  = horas2segundos($tel['TiempoFueraLinea']);
	$Time_Tiempo_Max = horas2segundos('48:00:00');
	$Time_Fake_Ini   = horas2segundos('23:59:50');
	$Time_Fake_Fin   = horas2segundos('24:00:00');
	//comparacion
	if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
		//Se verifica si existe
		if(!isset($FueraLineaActual[$tel['idTelemetria']]) OR $FueraLineaActual[$tel['idTelemetria']]==''){                    $FueraLineaActual[$tel['idTelemetria']]          = '';}
		if(!isset($FueraLineaActual_Whatsapp[$tel['idTelemetria']]) OR $FueraLineaActual_Whatsapp[$tel['idTelemetria']]==''){  $FueraLineaActual_Whatsapp[$tel['idTelemetria']] = '';}
		/**************************************************/
		//se crea cuerpo de la tabla
		$FueraLineaActual[$tel['idTelemetria']] .= '
		<tr style="background: #fff;">
			<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($tel['SistemaNombre']).'</td>
			<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.DeSanitizar($tel['Nombre']).'</td>
			<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.fecha_estandar($tel['LastUpdateFecha']).'</td>
			<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$tel['LastUpdateHora'].' hrs</td>
			<td style="padding: 12px 15px;border: 1px solid #dddddd;color:#7F7F7F;">'.$Tiempo.' hrs</td>
		</tr>';
		/**************************************************/
		//se crea cuerpo de whatsapp
		$FueraLineaActual_Whatsapp[$tel['idTelemetria']] .= 'Equipo <strong>'.DeSanitizar($tel['Nombre']).'</strong>';
		$FueraLineaActual_Whatsapp[$tel['idTelemetria']] .= ' en el Sistema <strong>'.DeSanitizar($tel['SistemaNombre']).'</strong>';
		$FueraLineaActual_Whatsapp[$tel['idTelemetria']] .= ' ha estado fuera de linea';
		$FueraLineaActual_Whatsapp[$tel['idTelemetria']] .= ' desde el '.fecha_estandar($tel['LastUpdateFecha']);
		$FueraLineaActual_Whatsapp[$tel['idTelemetria']] .= ' a las '.$tel['LastUpdateHora'].' hrs';
		$FueraLineaActual_Whatsapp[$tel['idTelemetria']] .= ' por un total de '.$Tiempo.' hrs<br/>';

	}
}


?>
