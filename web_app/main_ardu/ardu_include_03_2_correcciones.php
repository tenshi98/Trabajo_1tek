<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                       CORRECCIONES DE DATOS GUARDADOS                              */
/*                                                                                                    */
/******************************************************************************************************/

//recorro los sensores
for ($i = 1; $i <= 72; $i++) {

	/*******************************/
	//Variables
	$Min = 99999;
	$Max = 99999;

	/*******************************/
	//si el dato existe
	if(isset($rowData['SensoresTipo_'.$i])&&$rowData['SensoresTipo_'.$i]!=''){
		//Valido segun tipo de sensor
		switch ($rowData['SensoresTipo_'.$i]) {
			/*******************************/
			//DS18B20
			case 6:
				switch ($rowData['SensoresUniMed_'.$i]) {
					// °C - Temperatura
					case 3:
						//Variables
						$Min = -50;
						$Max = 125;
						break;
				}
				break;
			/*******************************/
			//DHT22
			case 7:
				switch ($rowData['SensoresUniMed_'.$i]) {
					// % - Humedad
					case 2:
						//Variables
						$Min = 0;
						$Max = 100;
						break;
					// °C - Temperatura
					case 3:
						//Variables
						$Min = -40;
						$Max = 80;
						break;
				}
				break;
			/*******************************/
			//BME280
			case 9:
				switch ($rowData['SensoresUniMed_'.$i]) {
					// % - Humedad
					case 2:
						//Variables
						$Min = 0;
						$Max = 100;
						break;
					// °C - Temperatura
					case 3:
						//Variables
						$Min = 0;
						$Max = 65;
						break;
					// hPa - Presion
					case 7:
						//Variables
						$Min = 300;
						$Max = 1100;
						break;
				}
				break;
			/*******************************/
			//SHT20
			case 10:
				switch ($rowData['SensoresUniMed_'.$i]) {
					// % - Humedad
					case 2:
						//Variables
						$Min = 0;
						$Max = 100;
						break;
					// °C - Temperatura
					case 3:
						//Variables
						$Min = -40;
						$Max = 125;
						break;
				}
				break;
			/*******************************/
			//AM2301
			case 16:
				switch ($rowData['SensoresUniMed_'.$i]) {
					// % - Humedad
					case 2:
						//Variables
						$Min = 0;
						$Max = 100;
						break;
					// °C - Temperatura
					case 3:
						//Variables
						$Min = -40;
						$Max = 80;
						break;
				}
				break;
			/*******************************/
			//AM2302
			case 17:
				switch ($rowData['SensoresUniMed_'.$i]) {
					// % - Humedad
					case 2:
						//Variables
						$Min = 0;
						$Max = 100;
						break;
					// °C - Temperatura
					case 3:
						//Variables
						$Min = -40;
						$Max = 80;
						break;
				}
				break;

		}
	}

	/*********************************************/
	//solo si se asignaron valores
	if($Min!=99999&&$Max!=99999){
		//si estan fuera de los parametros
		if(isset($Sensor[$i]['valor'])&&$Sensor[$i]['valor']!=99901&&($Sensor[$i]['valor']>$Max OR $Sensor[$i]['valor']<$Min)){
			$Sensor[$i]['valor'] = 99900;
		}
	}


}


?>
