<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                  MODIFICACION MANUAL A LOS DATOS RECIBIDOS                         */
/*                                                                                                    */
/******************************************************************************************************/
switch ($Identificador) {
	/**************************************/
	//AEROSAN
	case '184':
		//Corrijo offset sensor camara Camara 2 sensor 6 4 grados
		$s6c2f = $Sensor[11]['valor']*0.86;
		//$Sensor[11]['valor'] = $s6c2f;
		//$Sensor[11]['valor'] = floatval(number_format($s6c2f, 1, '.', ''));
		$s3c4p = $Sensor[5]['valor'] + 1.5;
		if($Sensor[7]['valor']>$s3c4p){
			$s3c4p * 1.0878;
			$Sensor[7]['valor'] = floatval(number_format($s3c4p, 1, '.', ''));
		}

		break;
	/**************************************/
	case 'asd':
		//Modificacion para todos
		$Sensor[2]['valor'] = $Sensor[1]['valor'];
		break;

}



?>
