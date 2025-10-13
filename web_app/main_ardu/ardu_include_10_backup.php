<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                  GUARDADO DE LOS DATOS EN UN ARCHIVO TXT                           */
/*                                                                                                    */
/******************************************************************************************************/
switch ($Control_Type) {
    /***********************************************/
    //Escribir en el archivo contador
    case 1:
		$Count = trim (file_get_contents($ardu_file_log_1));
		settype($Count, "integer");
		$Count++;
		//se guarda en el archivo
		EscribirLog($ardu_file_log_1, $Count, 3);

        break;
    /***********************************************/
    //Log de los datos
    case 2:
		//Se verifica si hay identificador
		if(isset($Identificador)&&$Identificador!=''){
			//Si el dato enviado corresponde a un equipo
			if(isset($rowData['idTelemetria'])&&$rowData['idTelemetria']!=''&&$rowData['idTelemetria']!=0){
				$ardu_file_log_2 = $ardu_file_log_2.$rowData['idTelemetria'].'.txt';
			//si no existe equipo
			}else{
				$ardu_file_log_2 = $ardu_file_log_2.'0.txt';
			}
		//si no hay identificador
		}else{
			$ardu_file_log_2 = $ardu_file_log_2.'999999.txt';
		}
		//se guarda en el archivo
		EscribirLog($ardu_file_log_2, $dir, 5);

        break;
	/***********************************************/
    //log con la captura de la dirección completa, con o sin variables predefinidas
    case 3:
        //captura
        $actual_link = $FechaSistema." ".$HoraSistema." - http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]\n";
       //Se verifica si hay identificador
		if(isset($Identificador)&&$Identificador!=''){
			//Si el dato enviado corresponde a un equipo
			if(isset($rowData['idTelemetria'])&&$rowData['idTelemetria']!=''&&$rowData['idTelemetria']!=0){
				$ardu_file_log_3 = $ardu_file_log_3.$rowData['idTelemetria'].'.txt';
			//si no existe equipo
			}else{
				$ardu_file_log_3 = $ardu_file_log_3.'0.txt';
			}
		//si no hay identificador
		}else{
			$ardu_file_log_3 = $ardu_file_log_3.'999999.txt';
		}
		//se guarda en el archivo
		EscribirLog($ardu_file_log_3, $actual_link, 5);

        break;
}

?>
