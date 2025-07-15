<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                  MODIFICACION MANUAL A LOS DATOS RECIBIDOS                         */
/*                                                                                                    */
/******************************************************************************************************/
switch ($Identificador) {
	/******************************************************************/
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
	/******************************************************************/
	//Walmart Carnes
	case '237':
		/********CONTROL DE GRUPO**************************/
		//variables
		$prom_Grupo_1   = 0;
		$prom_Grupo_2   = 0;
		$prom_Grupo_3   = 0;
		$prom_Grupo_4   = 0;
		$sum_Grupo_1    = 0;
		$sum_Grupo_2    = 0;
		$sum_Grupo_3    = 0;
		$sum_Grupo_4    = 0;
		$count_Grupo_1  = 0;
		$count_Grupo_2  = 0;
		$count_Grupo_3  = 0;
		$count_Grupo_4  = 0;

		//Grupo 1:  comentario cámara 2 - temperaturas
		if(isset($Sensor[13]['valor'])&&$Sensor[13]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[13]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[15]['valor'])&&$Sensor[15]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[15]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[17]['valor'])&&$Sensor[17]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[17]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[19]['valor'])&&$Sensor[19]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[19]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[21]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[35]['valor'])&&$Sensor[35]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[35]['valor'];$count_Grupo_1++;}
		//Grupo 1:  comentario cámara 2 - humedad
		if(isset($Sensor[14]['valor'])&&$Sensor[14]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[14]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[16]['valor'])&&$Sensor[16]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[16]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[18]['valor'])&&$Sensor[18]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[18]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[20]['valor'])&&$Sensor[20]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[20]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[22]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[36]['valor'])&&$Sensor[36]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[36]['valor'];$count_Grupo_2++;}
		//Grupo 1:  comentario cámara 2 - temperaturas
		if(isset($Sensor[37]['valor'])&&$Sensor[37]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[37]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[39]['valor'])&&$Sensor[39]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[39]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[41]['valor'])&&$Sensor[41]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[41]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[43]['valor'])&&$Sensor[43]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[43]['valor'];$count_Grupo_3++;}
		//Grupo 1:  comentario cámara 2 - humedad
		/*if(isset($Sensor[38]['valor'])&&$Sensor[38]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[38]['valor'];$count_Grupo_4++;}
		if(isset($Sensor[40]['valor'])&&$Sensor[40]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[40]['valor'];$count_Grupo_4++;}
		if(isset($Sensor[42]['valor'])&&$Sensor[42]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[42]['valor'];$count_Grupo_4++;}
		if(isset($Sensor[44]['valor'])&&$Sensor[44]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[44]['valor'];$count_Grupo_4++;}*/

		//Operacion
		if($count_Grupo_1!=0){$prom_Grupo_1 =$sum_Grupo_1/$count_Grupo_1;}
		if($count_Grupo_2!=0){$prom_Grupo_2 =$sum_Grupo_2/$count_Grupo_2;}
		if($count_Grupo_3!=0){$prom_Grupo_3 =$sum_Grupo_3/$count_Grupo_3;}
		//if($count_Grupo_4!=0){$prom_Grupo_4 =$sum_Grupo_4/$count_Grupo_4;}

		//reemplazo
		if($prom_Grupo_1!=0){
			if(isset($Sensor[13]['valor'])&&$Sensor[13]['valor']>=999){    $Sensor[13]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[15]['valor'])&&$Sensor[15]['valor']>=999){    $Sensor[15]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[17]['valor'])&&$Sensor[17]['valor']>=999){    $Sensor[17]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[19]['valor'])&&$Sensor[19]['valor']>=999){    $Sensor[19]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']>=999){    $Sensor[21]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[35]['valor'])&&$Sensor[35]['valor']>=999){    $Sensor[35]['valor']  = $prom_Grupo_1;}
		}
		if($prom_Grupo_2!=0){
			if(isset($Sensor[14]['valor'])&&$Sensor[14]['valor']>=999){    $Sensor[14]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[16]['valor'])&&$Sensor[16]['valor']>=999){    $Sensor[16]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[18]['valor'])&&$Sensor[18]['valor']>=999){    $Sensor[18]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[20]['valor'])&&$Sensor[20]['valor']>=999){    $Sensor[20]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']>=999){    $Sensor[22]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[36]['valor'])&&$Sensor[36]['valor']>=999){    $Sensor[36]['valor']  = $prom_Grupo_2;}
		}
		//reemplazo
		if($prom_Grupo_3!=0){
			if(isset($Sensor[37]['valor'])&&$Sensor[37]['valor']>=999){    $Sensor[37]['valor']  = $prom_Grupo_3;}
			if(isset($Sensor[39]['valor'])&&$Sensor[39]['valor']>=999){    $Sensor[39]['valor']  = $prom_Grupo_3;}
			if(isset($Sensor[41]['valor'])&&$Sensor[41]['valor']>=999){    $Sensor[41]['valor']  = $prom_Grupo_3;}
			if(isset($Sensor[43]['valor'])&&$Sensor[43]['valor']>=999){    $Sensor[43]['valor']  = $prom_Grupo_3;}
		}
		/*if($prom_Grupo_4!=0){
			if(isset($Sensor[38]['valor'])&&$Sensor[38]['valor']>=999){    $Sensor[38]['valor']  = $prom_Grupo_4;}
			if(isset($Sensor[40]['valor'])&&$Sensor[40]['valor']>=999){    $Sensor[40]['valor']  = $prom_Grupo_4;}
			if(isset($Sensor[42]['valor'])&&$Sensor[42]['valor']>=999){    $Sensor[42]['valor']  = $prom_Grupo_4;}
			if(isset($Sensor[44]['valor'])&&$Sensor[44]['valor']>=999){    $Sensor[44]['valor']  = $prom_Grupo_4;}
		}*/


		/********CONTROL DE LIMITES**************************/
		//Temperatura
		$x_Min = -30;
		$x_Max = 40;

		//puertas
		//se evalua valor mas probable
		/*if(isset($Sensor[45]['valor'])&&$Sensor[45]['valor']<4){  $Sensor[45]['valor'] = 1;}
		if(isset($Sensor[46]['valor'])&&$Sensor[46]['valor']<4){  $Sensor[46]['valor'] = 1;}
		//si es superior a 5 se resetea a 0
		if(isset($Sensor[45]['valor'])&&$Sensor[45]['valor']>4){  $Sensor[45]['valor'] = 0;}
		if(isset($Sensor[46]['valor'])&&$Sensor[46]['valor']>4){  $Sensor[46]['valor'] = 0;}*/

		/*if(isset($Sensor[1]['valor'])&&($Sensor[1]['valor']>$x_Max OR $Sensor[1]['valor']<$x_Min)){    $Sensor[1]['valor']  = 99901;$Sensor[2]['valor']  = 99901;}
		if(isset($Sensor[3]['valor'])&&($Sensor[3]['valor']>$x_Max OR $Sensor[3]['valor']<$x_Min)){    $Sensor[3]['valor']  = 99901;$Sensor[4]['valor']  = 99901;}
		if(isset($Sensor[5]['valor'])&&($Sensor[5]['valor']>$x_Max OR $Sensor[5]['valor']<$x_Min)){    $Sensor[5]['valor']  = 99901;$Sensor[6]['valor']  = 99901;}
		if(isset($Sensor[7]['valor'])&&($Sensor[7]['valor']>$x_Max OR $Sensor[7]['valor']<$x_Min)){    $Sensor[7]['valor']  = 99901;$Sensor[8]['valor']  = 99901;}
		if(isset($Sensor[9]['valor'])&&($Sensor[9]['valor']>$x_Max OR $Sensor[9]['valor']<$x_Min)){    $Sensor[9]['valor']  = 99901;$Sensor[10]['valor']  = 99901;}
		if(isset($Sensor[11]['valor'])&&($Sensor[11]['valor']>$x_Max OR $Sensor[11]['valor']<$x_Min)){ $Sensor[11]['valor'] = 99901;$Sensor[12]['valor']  = 99901;}
		if(isset($Sensor[13]['valor'])&&($Sensor[13]['valor']>$x_Max OR $Sensor[13]['valor']<$x_Min)){ $Sensor[13]['valor'] = 99901;$Sensor[14]['valor']  = 99901;}
		if(isset($Sensor[15]['valor'])&&($Sensor[15]['valor']>$x_Max OR $Sensor[15]['valor']<$x_Min)){ $Sensor[15]['valor'] = 99901;$Sensor[16]['valor']  = 99901;}
		if(isset($Sensor[17]['valor'])&&($Sensor[17]['valor']>$x_Max OR $Sensor[17]['valor']<$x_Min)){ $Sensor[17]['valor'] = 99901;$Sensor[18]['valor']  = 99901;}
		if(isset($Sensor[19]['valor'])&&($Sensor[19]['valor']>$x_Max OR $Sensor[19]['valor']<$x_Min)){ $Sensor[19]['valor'] = 99901;$Sensor[20]['valor']  = 99901;}
		if(isset($Sensor[21]['valor'])&&($Sensor[21]['valor']>$x_Max OR $Sensor[21]['valor']<$x_Min)){ $Sensor[21]['valor'] = 99901;$Sensor[22]['valor']  = 99901;}
		if(isset($Sensor[23]['valor'])&&($Sensor[23]['valor']>$x_Max OR $Sensor[23]['valor']<$x_Min)){ $Sensor[23]['valor'] = 99901;$Sensor[24]['valor']  = 99901;}
		if(isset($Sensor[25]['valor'])&&($Sensor[25]['valor']>$x_Max OR $Sensor[25]['valor']<$x_Min)){ $Sensor[25]['valor'] = 99901;$Sensor[26]['valor']  = 99901;}
		if(isset($Sensor[27]['valor'])&&($Sensor[27]['valor']>$x_Max OR $Sensor[27]['valor']<$x_Min)){ $Sensor[27]['valor'] = 99901;$Sensor[28]['valor']  = 99901;}
		if(isset($Sensor[29]['valor'])&&($Sensor[29]['valor']>$x_Max OR $Sensor[29]['valor']<$x_Min)){ $Sensor[29]['valor'] = 99901;$Sensor[30]['valor']  = 99901;}
		if(isset($Sensor[31]['valor'])&&($Sensor[31]['valor']>$x_Max OR $Sensor[31]['valor']<$x_Min)){ $Sensor[31]['valor'] = 99901;$Sensor[32]['valor']  = 99901;}
		if(isset($Sensor[33]['valor'])&&($Sensor[33]['valor']>$x_Max OR $Sensor[33]['valor']<$x_Min)){ $Sensor[33]['valor'] = 99901;$Sensor[34]['valor']  = 99901;}
		if(isset($Sensor[35]['valor'])&&($Sensor[35]['valor']>$x_Max OR $Sensor[35]['valor']<$x_Min)){ $Sensor[35]['valor'] = 99901;$Sensor[36]['valor']  = 99901;}
		if(isset($Sensor[37]['valor'])&&($Sensor[37]['valor']>$x_Max OR $Sensor[37]['valor']<$x_Min)){ $Sensor[37]['valor'] = 99901;$Sensor[38]['valor']  = 99901;}
		if(isset($Sensor[39]['valor'])&&($Sensor[39]['valor']>$x_Max OR $Sensor[39]['valor']<$x_Min)){ $Sensor[39]['valor'] = 99901;$Sensor[40]['valor']  = 99901;}
		if(isset($Sensor[41]['valor'])&&($Sensor[41]['valor']>$x_Max OR $Sensor[41]['valor']<$x_Min)){ $Sensor[41]['valor'] = 99901;$Sensor[42]['valor']  = 99901;}
		if(isset($Sensor[43]['valor'])&&($Sensor[43]['valor']>$x_Max OR $Sensor[43]['valor']<$x_Min)){ $Sensor[43]['valor'] = 99901;$Sensor[44]['valor']  = 99901;}
		*/

		break;
	/******************************************************************/
	//Merken
	case 'mk6':
		//se hace la operacion de cambio de sensores
		$t1 = $Sensor[1]['valor'];
		$t2 = $Sensor[3]['valor'];
		$t3 = $Sensor[5]['valor'];
		$h1 = $Sensor[6]['valor'];
		$Sensor[2]['valor'] = $t1;
		$Sensor[4]['valor'] = $t2;
		$Sensor[6]['valor'] = $t3;
		$Sensor[5]['valor'] = $h1;
		break;
	/******************************************************************/
	//HD
	/**************************/
	//Para el equipo gr3
	case 'gr3':
		if(isset($Sensor[7]['valor'])&&$Sensor[7]['valor']<1.5){  $Sensor[7]['valor'] = 0;}
		if(isset($Sensor[8]['valor'])&&$Sensor[8]['valor']<1.5){  $Sensor[8]['valor'] = 0;}
		if($Sensor[1]['valor']>1 OR $Sensor[2]['valor']>1 OR $Sensor[3]['valor']>1 OR $Sensor[4]['valor']>1 OR $Sensor[5]['valor']>1 OR $Sensor[6]['valor']>1 OR $Sensor[7]['valor']>1 OR $Sensor[8]['valor']>1 OR $Sensor[9]['valor']>1 OR $Sensor[10]['valor']>1 OR $Sensor[11]['valor']>1 OR $Sensor[12]['valor']>1)
		{
			$Sensor[13]['valor'] = 1;
		}
		break;
	/**************************/
	//Para el equipo gr19
	case 'gr19':
		//se hace la operacion
		$valor = $Sensor[37]['valor']*1.086;
		//se crea formato con dos decimales, con un punto como separador decimal
		$Sensor[37]['valor'] = floatval(number_format($valor, 2, '.', ''));
		break;
	/**************************/
	//Para el equipo gr41
	case 'gr41':
		//se hace la operacion
		$valor = $Sensor[37]['valor']*1.025;
		//se crea formato con dos decimales, con un punto como separador decimal
		$Sensor[37]['valor'] = floatval(number_format($valor, 2, '.', ''));
		break;
	/**************************/
	//Para el equipo gr20
	case 'gr20':
		//se hace la operacion
		$valor = $Sensor[37]['valor']*1.098;
		//se crea formato con dos decimales, con un punto como separador decimal
		$Sensor[37]['valor'] = floatval(number_format($valor, 2, '.', ''));
		break;
	/******************************************************************/
	//CROSSENERGY
	/**************************/
	//Para el equipo 141
	case '141':
		//Se cambia el valor del contador de sensores enviados
		$Var_Counter = 8;
		$Sensor[4]['valor'] = $Sensor[4]['valor']*0.96;
		$Sensor[5]['valor'] = $Sensor[5]['valor']*0.96;
		//Calibracion Face 3
		$v = ($Sensor[4]['valor']+$Sensor[5]['valor']);
		$x = $v/2;
		$Sensor[6]['valor'] = floatval(number_format($x, 2, '.', ''));
		$v3 = (($Sensor[4]['valor']+$Sensor[5]['valor']+$Sensor[6]['valor'])/3)*sqrt(3);
		$Sensor[7]['valor'] = floatval(number_format($v3, 2, '.', ''));
		$consumo=(($Sensor[1]['valor']*$Sensor[4]['valor']/1000)+($Sensor[2]['valor']*$Sensor[5]['valor']/1000)+($Sensor[3]['valor']*$Sensor[6]['valor']/1000));
		$Sensor[8]['valor']= floatval(number_format($consumo, 2, '.', ''));
		break;
	/**************************/
	//Para el equipo 170
	case '170':
		//Se cambia el valor del contador de sensores enviados
		$Sensor[7]['valor'] = $Sensor[7]['valor']*0.95;
		$Sensor[8]['valor'] = $Sensor[8]['valor']*0.905;
		$Sensor[9]['valor'] = $Sensor[9]['valor']*0.925;
		$v3 = ($Sensor[7]['valor']*sqrt(3)+$Sensor[8]['valor']*sqrt(3)+$Sensor[9]['valor']*sqrt(3))/3;
		$Sensor[10]['valor'] = floatval(number_format($v3, 2, '.', ''));
		$consumo=(($Sensor[1]['valor']*$Sensor[7]['valor']/1000)+($Sensor[2]['valor']*$Sensor[8]['valor']/1000)+($Sensor[3]['valor']*$Sensor[9]['valor']/1000)+($Sensor[4]['valor']*$Sensor[7]['valor']/1000)+($Sensor[5]['valor']*$Sensor[8]['valor']/1000)+($Sensor[6]['valor']*$Sensor[9]['valor']/1000));
		$Sensor[11]['valor']= floatval(number_format($consumo, 2, '.', ''));
		break;
	/**************************/
	//Para el equipo 152
	case '152': //Merex
		//Se cambia el valor del contador de sensores enviados
		$Var_Counter = 8;
		$v3 = $Sensor[4]['valor']*sqrt(3);
		$Sensor[7]['valor'] = floatval(number_format($v3, 2, '.', ''));
		//$consumo=(($Sensor[1]['valor']+$Sensor[2]['valor']+$Sensor[3]['valor'])*$Sensor[7]['valor'])/1000;
		$consumo=(($Sensor[1]['valor']*$Sensor[4]['valor']/1000)+($Sensor[2]['valor']*$Sensor[4]['valor']/1000)+($Sensor[3]['valor']*$Sensor[4]['valor']/1000));
		$Sensor[8]['valor']= floatval(number_format($consumo, 2, '.', ''));
		break;
	/**************************/
	//Para el equipo 171
	case '171':
		//Se cambia el valor del contador de sensores enviados
		$Var_Counter = 8;
		$Sensor[4]['valor'] = $Sensor[4]['valor']*0.95;
		if(isset($Sensor[4]['valor'])&&$Sensor[4]['valor']>240){    $Sensor[4]['valor'] = 239;}
		$v3 = $Sensor[4]['valor']*sqrt(3);
		$Sensor[7]['valor'] = floatval(number_format($v3, 2, '.', ''));
		$Sensor[5]['valor'] = $Sensor[7]['valor'];
		$consumo=(($Sensor[1]['valor']+$Sensor[2]['valor']+$Sensor[3]['valor'])*$Sensor[7]['valor'])/1000;
		//$consumo=(($Sensor[1]['valor']*$Sensor[4]['valor']/1000)+($Sensor[2]['valor']*$Sensor[4]['valor']/1000)+($Sensor[3]['valor']*$Sensor[4]['valor']/1000));
		$Sensor[8]['valor']= floatval(number_format($consumo, 2, '.', ''));
		break;
	/**************************/
	//Para el equipo 199
	case '199':
		//Se cambia el valor del contador de sensores enviados
		$Var_Counter = 9;
		//$Sensor[4]['valor'] = $Sensor[4]['valor']*0.95;
		//if(isset($Sensor[4]['valor'])&&$Sensor[4]['valor']>240){    $Sensor[4]['valor'] = 239;}
		//$v3 = $Sensor[4]['valor']*sqrt(3);
		//$Sensor[7]['valor'] = floatval(number_format($v3, 2, '.', ''));
		//$Sensor[5]['valor'] = $Sensor[7]['valor'];
		//$Sensor[8]['valor'] = $Sensor[8]['valor']*1.12;
		//$Sensor[7]['valor'] = $Sensor[8]['valor']*sqrt(3);
		//Se cambio el 10-08-2022 a las 22:02
		$consumo=(($Sensor[1]['valor']*$Sensor[7]['valor']) + ($Sensor[2]['valor']*$Sensor[7]['valor']) + ($Sensor[3]['valor']*$Sensor[7]['valor']) + ($Sensor[4]['valor']*$Sensor[7]['valor']) + ($Sensor[5]['valor']*$Sensor[7]['valor']) + ($Sensor[6]['valor']*$Sensor[7]['valor']))/1000;
		//$consumo=(($Sensor[1]['valor']*$Sensor[4]['valor']/1000)+($Sensor[2]['valor']*$Sensor[4]['valor']/1000)+($Sensor[3]['valor']*$Sensor[4]['valor']/1000));
		$Sensor[9]['valor']= floatval(number_format($consumo, 2, '.', ''));
		break;
	/**************************/
	//Para el equipo 200
	case '200':
		$Sensor[4]['valor'] = $Sensor[4]['valor']*0.925;
		$Sensor[5]['valor'] = $Sensor[4]['valor']*sqrt(3);
		$consumo= ($Sensor[1]['valor']*$Sensor[5]['valor']) + ($Sensor[2]['valor']*$Sensor[5]['valor']) + ($Sensor[3]['valor']*$Sensor[5]['valor']);
		$consumo= $consumo / 1000;
		$Sensor[6]['valor']= floatval(number_format($consumo, 2, '.', ''));
		//if(isset($Sensor[4]['valor'])&&$Sensor[4]['valor']>240){    $Sensor[4]['valor'] = 239;}
		//$Sensor[7]['valor'] = floatval(number_format($v3, 2, '.', ''));
		//$Sensor[5]['valor'] = $Sensor[7]['valor'];
		//$Sensor[8]['valor'] = $Sensor[8]['valor']*1.12;
		//$Sensor[7]['valor'] = $Sensor[8]['valor']*sqrt(3);
		break;
	/******************************************************************/
	//DOLE
	case '206':
		/********CONTROL DE LIMITES**************************/
		//Temperatura
		$x_Min = -30;
		$x_Max = 40;

		if(isset($Sensor[1]['valor'])&&($Sensor[1]['valor']>$x_Max OR $Sensor[1]['valor']<$x_Min)){    $Sensor[1]['valor']  = 99900;}
		if(isset($Sensor[3]['valor'])&&($Sensor[3]['valor']>$x_Max OR $Sensor[3]['valor']<$x_Min)){    $Sensor[3]['valor']  = 99900;}
		if(isset($Sensor[5]['valor'])&&($Sensor[5]['valor']>$x_Max OR $Sensor[5]['valor']<$x_Min)){    $Sensor[5]['valor']  = 99900;}
		if(isset($Sensor[7]['valor'])&&($Sensor[7]['valor']>$x_Max OR $Sensor[7]['valor']<$x_Min)){    $Sensor[7]['valor']  = 99900;}
		if(isset($Sensor[9]['valor'])&&($Sensor[9]['valor']>$x_Max OR $Sensor[9]['valor']<$x_Min)){    $Sensor[9]['valor']  = 99900;}
		if(isset($Sensor[11]['valor'])&&($Sensor[11]['valor']>$x_Max OR $Sensor[11]['valor']<$x_Min)){ $Sensor[11]['valor'] = 99900;}
		if(isset($Sensor[13]['valor'])&&($Sensor[13]['valor']>$x_Max OR $Sensor[13]['valor']<$x_Min)){ $Sensor[13]['valor'] = 99900;}
		if(isset($Sensor[14]['valor'])&&($Sensor[14]['valor']>$x_Max OR $Sensor[14]['valor']<$x_Min)){ $Sensor[14]['valor'] = 99900;}
		if(isset($Sensor[15]['valor'])&&($Sensor[15]['valor']>$x_Max OR $Sensor[15]['valor']<$x_Min)){ $Sensor[15]['valor'] = 99900;}
		if(isset($Sensor[16]['valor'])&&($Sensor[16]['valor']>$x_Max OR $Sensor[16]['valor']<$x_Min)){ $Sensor[16]['valor'] = 99900;}
		if(isset($Sensor[17]['valor'])&&($Sensor[17]['valor']>$x_Max OR $Sensor[17]['valor']<$x_Min)){ $Sensor[17]['valor'] = 99900;}
		if(isset($Sensor[18]['valor'])&&($Sensor[18]['valor']>$x_Max OR $Sensor[18]['valor']<$x_Min)){ $Sensor[18]['valor'] = 99900;}
		if(isset($Sensor[19]['valor'])&&($Sensor[19]['valor']>$x_Max OR $Sensor[19]['valor']<$x_Min)){ $Sensor[18]['valor'] = 99900;}
		if(isset($Sensor[20]['valor'])&&($Sensor[20]['valor']>$x_Max OR $Sensor[20]['valor']<$x_Min)){ $Sensor[20]['valor'] = 99900;}
		if(isset($Sensor[21]['valor'])&&($Sensor[21]['valor']>$x_Max OR $Sensor[21]['valor']<$x_Min)){ $Sensor[21]['valor'] = 99900;}
		if(isset($Sensor[22]['valor'])&&($Sensor[22]['valor']>$x_Max OR $Sensor[22]['valor']<$x_Min)){ $Sensor[22]['valor'] = 99900;}
		if(isset($Sensor[23]['valor'])&&($Sensor[23]['valor']>$x_Max OR $Sensor[23]['valor']<$x_Min)){ $Sensor[23]['valor'] = 99900;}
		if(isset($Sensor[24]['valor'])&&($Sensor[24]['valor']>$x_Max OR $Sensor[24]['valor']<$x_Min)){ $Sensor[24]['valor'] = 99900;}
		if(isset($Sensor[25]['valor'])&&($Sensor[25]['valor']>$x_Max OR $Sensor[25]['valor']<$x_Min)){ $Sensor[25]['valor'] = 99900;}
		if(isset($Sensor[27]['valor'])&&($Sensor[27]['valor']>$x_Max OR $Sensor[27]['valor']<$x_Min)){ $Sensor[27]['valor'] = 99900;}
		if(isset($Sensor[29]['valor'])&&($Sensor[29]['valor']>$x_Max OR $Sensor[29]['valor']<$x_Min)){ $Sensor[29]['valor'] = 99900;}

		//variables
		$prom_Grupo_1   = 0;
		$prom_Grupo_2   = 0;
		$prom_Grupo_3   = 0;
		$sum_Grupo_1    = 0;
		$sum_Grupo_2    = 0;
		$sum_Grupo_3    = 0;
		$count_Grupo_1  = 0;
		$count_Grupo_2  = 0;
		$count_Grupo_3  = 0;

		//Grupo 1:  comentario cámara 2
		if(isset($Sensor[15]['valor'])&&$Sensor[15]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[15]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[16]['valor'])&&$Sensor[16]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[16]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[17]['valor'])&&$Sensor[17]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[17]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[18]['valor'])&&$Sensor[18]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[18]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[25]['valor'])&&$Sensor[25]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[25]['valor'];$count_Grupo_1++;}

		//Grupo 2:  comentario es cámara 3
		if(isset($Sensor[13]['valor'])&&$Sensor[13]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[13]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[14]['valor'])&&$Sensor[14]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[14]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[19]['valor'])&&$Sensor[19]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[19]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[20]['valor'])&&$Sensor[20]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[20]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[27]['valor'])&&$Sensor[27]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[27]['valor'];$count_Grupo_2++;}

		//Grupo 3: comentario cámara 4
		if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[21]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[22]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[23]['valor'])&&$Sensor[23]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[23]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[24]['valor'])&&$Sensor[24]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[24]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[29]['valor'])&&$Sensor[29]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[29]['valor'];$count_Grupo_3++;}

		//Operacion
		if($count_Grupo_1!=0){$prom_Grupo_1 =$sum_Grupo_1/$count_Grupo_1;}
		if($count_Grupo_2!=0){$prom_Grupo_2 =$sum_Grupo_2/$count_Grupo_2;}
		if($count_Grupo_3!=0){$prom_Grupo_3 =$sum_Grupo_3/$count_Grupo_3;}

		//reemplazo
		if($prom_Grupo_1!=0){
			if(isset($Sensor[15]['valor'])&&$Sensor[15]['valor']==99900){    $Sensor[15]['valor']  = $prom_Grupo_1*(rand(989, 1010)/1000);}
			if(isset($Sensor[16]['valor'])&&$Sensor[16]['valor']==99900){    $Sensor[16]['valor']  = $prom_Grupo_1*(rand(989, 1010)/1000);}
			if(isset($Sensor[17]['valor'])&&$Sensor[17]['valor']==99900){    $Sensor[17]['valor']  = $prom_Grupo_1*(rand(989, 1010)/1000);}
			if(isset($Sensor[18]['valor'])&&$Sensor[18]['valor']==99900){    $Sensor[18]['valor']  = $prom_Grupo_1*(rand(989, 1010)/1000);}
			if(isset($Sensor[25]['valor'])&&$Sensor[25]['valor']==99900){    $Sensor[25]['valor']  = $prom_Grupo_1*(rand(989, 1010)/1000);}
		}
		if($prom_Grupo_2!=0){
			if(isset($Sensor[13]['valor'])&&$Sensor[13]['valor']==99900){    $Sensor[13]['valor']  = $prom_Grupo_2*(rand(989, 1010)/1000);}
			if(isset($Sensor[14]['valor'])&&$Sensor[14]['valor']==99900){    $Sensor[14]['valor']  = $prom_Grupo_2*(rand(989, 1010)/1000);}
			if(isset($Sensor[19]['valor'])&&$Sensor[19]['valor']==99900){    $Sensor[19]['valor']  = $prom_Grupo_2*(rand(989, 1010)/1000);}
			if(isset($Sensor[20]['valor'])&&$Sensor[20]['valor']==99900){    $Sensor[20]['valor']  = $prom_Grupo_2*(rand(989, 1010)/1000);}
			if(isset($Sensor[27]['valor'])&&$Sensor[27]['valor']==99900){    $Sensor[27]['valor']  = $prom_Grupo_2*(rand(989, 1010)/1000);}
		}
		if($prom_Grupo_3!=0){
			if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']==99900){    $Sensor[21]['valor']  = $prom_Grupo_3*(rand(989, 1010)/1000);}
			if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']==99900){    $Sensor[22]['valor']  = $prom_Grupo_3*(rand(989, 1010)/1000);}
			if(isset($Sensor[23]['valor'])&&$Sensor[23]['valor']==99900){    $Sensor[23]['valor']  = $prom_Grupo_3*(rand(989, 1010)/1000);}
			if(isset($Sensor[24]['valor'])&&$Sensor[24]['valor']==99900){    $Sensor[24]['valor']  = $prom_Grupo_3*(rand(989, 1010)/1000);}
			if(isset($Sensor[29]['valor'])&&$Sensor[29]['valor']==99900){    $Sensor[29]['valor']  = $prom_Grupo_3*(rand(989, 1010)/1000);}
		}

		//reemplazo el valo de losque quedan
		if(isset($Sensor[1]['valor'])&&$Sensor[1]['valor']==99900){    $Sensor[1]['valor']  = 99901;}
		if(isset($Sensor[3]['valor'])&&$Sensor[3]['valor']==99900){    $Sensor[3]['valor']  = 99901;}
		//if(isset($Sensor[4]['valor'])&&$Sensor[4]['valor']==99900){    $Sensor[4]['valor']  = 99901;}
		if(isset($Sensor[5]['valor'])&&$Sensor[5]['valor']==99900){    $Sensor[5]['valor']  = 99901;}
		//if(isset($Sensor[6]['valor'])&&$Sensor[6]['valor']==99900){    $Sensor[6]['valor']  = 99901;}
		if(isset($Sensor[7]['valor'])&&$Sensor[7]['valor']==99900){    $Sensor[7]['valor']  = 99901;}
		//if(isset($Sensor[8]['valor'])&&$Sensor[8]['valor']==99900){    $Sensor[8]['valor']  = 99901;}
		if(isset($Sensor[9]['valor'])&&$Sensor[9]['valor']==99900){    $Sensor[9]['valor']  = 99901;}
		if(isset($Sensor[10]['valor'])&&$Sensor[10]['valor']==99900){    $Sensor[10]['valor']  = 99901;}
		if(isset($Sensor[11]['valor'])&&$Sensor[11]['valor']==99900){    $Sensor[11]['valor']  = 99901;}
		if(isset($Sensor[12]['valor'])&&$Sensor[12]['valor']==99900){    $Sensor[12]['valor']  = 99901;}
		/*if(isset($Sensor[13]['valor'])&&$Sensor[13]['valor']==99900){    $Sensor[13]['valor']  = 99901;}
		if(isset($Sensor[14]['valor'])&&$Sensor[14]['valor']==99900){    $Sensor[14]['valor']  = 99901;}
		if(isset($Sensor[15]['valor'])&&$Sensor[15]['valor']==99900){    $Sensor[15]['valor']  = 99901;}
		if(isset($Sensor[16]['valor'])&&$Sensor[16]['valor']==99900){    $Sensor[16]['valor']  = 99901;}
		if(isset($Sensor[17]['valor'])&&$Sensor[17]['valor']==99900){    $Sensor[17]['valor']  = 99901;}
		if(isset($Sensor[18]['valor'])&&$Sensor[18]['valor']==99900){    $Sensor[18]['valor']  = 99901;}
		if(isset($Sensor[19]['valor'])&&$Sensor[19]['valor']==99900){    $Sensor[19]['valor']  = 99901;}
		if(isset($Sensor[20]['valor'])&&$Sensor[20]['valor']==99900){    $Sensor[20]['valor']  = 99901;}
		if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']==99900){    $Sensor[21]['valor']  = 99901;}
		if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']==99900){    $Sensor[22]['valor']  = 99901;}
		if(isset($Sensor[23]['valor'])&&$Sensor[23]['valor']==99900){    $Sensor[23]['valor']  = 99901;}
		if(isset($Sensor[24]['valor'])&&$Sensor[24]['valor']==99900){    $Sensor[24]['valor']  = 99901;}
		if(isset($Sensor[25]['valor'])&&$Sensor[25]['valor']==99900){    $Sensor[25]['valor']  = 99901;}
		if(isset($Sensor[26]['valor'])&&$Sensor[26]['valor']==99900){    $Sensor[26]['valor']  = 99901;}
		if(isset($Sensor[27]['valor'])&&$Sensor[27]['valor']==99900){    $Sensor[27]['valor']  = 99901;}
		if(isset($Sensor[28]['valor'])&&$Sensor[28]['valor']==99900){    $Sensor[28]['valor']  = 99901;}
		if(isset($Sensor[29]['valor'])&&$Sensor[29]['valor']==99900){    $Sensor[29]['valor']  = 99901;}*/
		if(isset($Sensor[30]['valor'])&&$Sensor[30]['valor']==99900){    $Sensor[30]['valor']  = 99901;}
		break;
	/******************************************************************/
	//Walmart Carnes
	case '237':
		/********CONTROL DE GRUPO**************************/
		//variables
		$prom_Grupo_1   = 0;
		$prom_Grupo_2   = 0;
		$prom_Grupo_3   = 0;
		$prom_Grupo_4   = 0;
		$sum_Grupo_1    = 0;
		$sum_Grupo_2    = 0;
		$sum_Grupo_3    = 0;
		$sum_Grupo_4    = 0;
		$count_Grupo_1  = 0;
		$count_Grupo_2  = 0;
		$count_Grupo_3  = 0;
		$count_Grupo_4  = 0;

		//Grupo 1:  comentario cámara 2 - temperaturas
		if(isset($Sensor[13]['valor'])&&$Sensor[13]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[13]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[15]['valor'])&&$Sensor[15]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[15]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[17]['valor'])&&$Sensor[17]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[17]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[19]['valor'])&&$Sensor[19]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[19]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[21]['valor'];$count_Grupo_1++;}
		if(isset($Sensor[35]['valor'])&&$Sensor[35]['valor']<999){ $sum_Grupo_1 = $sum_Grupo_1 + $Sensor[35]['valor'];$count_Grupo_1++;}
		//Grupo 1:  comentario cámara 2 - humedad
		if(isset($Sensor[14]['valor'])&&$Sensor[14]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[14]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[16]['valor'])&&$Sensor[16]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[16]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[18]['valor'])&&$Sensor[18]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[18]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[20]['valor'])&&$Sensor[20]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[20]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[22]['valor'];$count_Grupo_2++;}
		if(isset($Sensor[36]['valor'])&&$Sensor[36]['valor']<999){ $sum_Grupo_2 = $sum_Grupo_2 + $Sensor[36]['valor'];$count_Grupo_2++;}
		//Grupo 1:  comentario cámara 2 - temperaturas
		if(isset($Sensor[37]['valor'])&&$Sensor[37]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[37]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[39]['valor'])&&$Sensor[39]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[39]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[41]['valor'])&&$Sensor[41]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[41]['valor'];$count_Grupo_3++;}
		if(isset($Sensor[43]['valor'])&&$Sensor[43]['valor']<999){ $sum_Grupo_3 = $sum_Grupo_3 + $Sensor[43]['valor'];$count_Grupo_3++;}
		//Grupo 1:  comentario cámara 2 - humedad
		/*if(isset($Sensor[38]['valor'])&&$Sensor[38]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[38]['valor'];$count_Grupo_4++;}
		if(isset($Sensor[40]['valor'])&&$Sensor[40]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[40]['valor'];$count_Grupo_4++;}
		if(isset($Sensor[42]['valor'])&&$Sensor[42]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[42]['valor'];$count_Grupo_4++;}
		if(isset($Sensor[44]['valor'])&&$Sensor[44]['valor']<999){ $sum_Grupo_4 = $sum_Grupo_4 + $Sensor[44]['valor'];$count_Grupo_4++;}*/

		//Operacion
		if($count_Grupo_1!=0){$prom_Grupo_1 =$sum_Grupo_1/$count_Grupo_1;}
		if($count_Grupo_2!=0){$prom_Grupo_2 =$sum_Grupo_2/$count_Grupo_2;}
		if($count_Grupo_3!=0){$prom_Grupo_3 =$sum_Grupo_3/$count_Grupo_3;}
		//if($count_Grupo_4!=0){$prom_Grupo_4 =$sum_Grupo_4/$count_Grupo_4;}

		//reemplazo
		if($prom_Grupo_1!=0){
			if(isset($Sensor[13]['valor'])&&$Sensor[13]['valor']>=999){    $Sensor[13]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[15]['valor'])&&$Sensor[15]['valor']>=999){    $Sensor[15]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[17]['valor'])&&$Sensor[17]['valor']>=999){    $Sensor[17]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[19]['valor'])&&$Sensor[19]['valor']>=999){    $Sensor[19]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']>=999){    $Sensor[21]['valor']  = $prom_Grupo_1;}
			if(isset($Sensor[35]['valor'])&&$Sensor[35]['valor']>=999){    $Sensor[35]['valor']  = $prom_Grupo_1;}
		}
		if($prom_Grupo_2!=0){
			if(isset($Sensor[14]['valor'])&&$Sensor[14]['valor']>=999){    $Sensor[14]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[16]['valor'])&&$Sensor[16]['valor']>=999){    $Sensor[16]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[18]['valor'])&&$Sensor[18]['valor']>=999){    $Sensor[18]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[20]['valor'])&&$Sensor[20]['valor']>=999){    $Sensor[20]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']>=999){    $Sensor[22]['valor']  = $prom_Grupo_2;}
			if(isset($Sensor[36]['valor'])&&$Sensor[36]['valor']>=999){    $Sensor[36]['valor']  = $prom_Grupo_2;}
		}
		//reemplazo
		if($prom_Grupo_3!=0){
			if(isset($Sensor[37]['valor'])&&$Sensor[37]['valor']>=999){    $Sensor[37]['valor']  = $prom_Grupo_3;}
			if(isset($Sensor[39]['valor'])&&$Sensor[39]['valor']>=999){    $Sensor[39]['valor']  = $prom_Grupo_3;}
			if(isset($Sensor[41]['valor'])&&$Sensor[41]['valor']>=999){    $Sensor[41]['valor']  = $prom_Grupo_3;}
			if(isset($Sensor[43]['valor'])&&$Sensor[43]['valor']>=999){    $Sensor[43]['valor']  = $prom_Grupo_3;}
		}
		/*if($prom_Grupo_4!=0){
			if(isset($Sensor[38]['valor'])&&$Sensor[38]['valor']>=999){    $Sensor[38]['valor']  = $prom_Grupo_4;}
			if(isset($Sensor[40]['valor'])&&$Sensor[40]['valor']>=999){    $Sensor[40]['valor']  = $prom_Grupo_4;}
			if(isset($Sensor[42]['valor'])&&$Sensor[42]['valor']>=999){    $Sensor[42]['valor']  = $prom_Grupo_4;}
			if(isset($Sensor[44]['valor'])&&$Sensor[44]['valor']>=999){    $Sensor[44]['valor']  = $prom_Grupo_4;}
		}*/
		break;
	/******************************************************************/
	//DelMonte
	case '217':
	case '173':
	case '229':
		/********CONTROL DE LIMITES**************************/
		//Temperatura
		$x_Min = -30;
		$x_Max = 40;

		if(isset($Sensor[1]['valor'])&&($Sensor[1]['valor']>$x_Max OR $Sensor[1]['valor']<$x_Min)){    $Sensor[1]['valor']  = 99901;$Sensor[2]['valor']  = 99901;}
		if(isset($Sensor[3]['valor'])&&($Sensor[3]['valor']>$x_Max OR $Sensor[3]['valor']<$x_Min)){    $Sensor[3]['valor']  = 99901;$Sensor[4]['valor']  = 99901;}
		if(isset($Sensor[5]['valor'])&&($Sensor[5]['valor']>$x_Max OR $Sensor[5]['valor']<$x_Min)){    $Sensor[5]['valor']  = 99901;$Sensor[6]['valor']  = 99901;}
		if(isset($Sensor[7]['valor'])&&($Sensor[7]['valor']>$x_Max OR $Sensor[7]['valor']<$x_Min)){    $Sensor[7]['valor']  = 99901;$Sensor[8]['valor']  = 99901;}
		if(isset($Sensor[9]['valor'])&&($Sensor[9]['valor']>$x_Max OR $Sensor[9]['valor']<$x_Min)){    $Sensor[9]['valor']  = 99901;$Sensor[10]['valor']  = 99901;}
		if(isset($Sensor[11]['valor'])&&($Sensor[11]['valor']>$x_Max OR $Sensor[11]['valor']<$x_Min)){ $Sensor[11]['valor'] = 99901;$Sensor[12]['valor']  = 99901;}
		if(isset($Sensor[13]['valor'])&&($Sensor[13]['valor']>$x_Max OR $Sensor[13]['valor']<$x_Min)){ $Sensor[13]['valor'] = 99901;$Sensor[14]['valor']  = 99901;}
		if(isset($Sensor[15]['valor'])&&($Sensor[15]['valor']>$x_Max OR $Sensor[15]['valor']<$x_Min)){ $Sensor[15]['valor'] = 99901;$Sensor[16]['valor']  = 99901;}
		if(isset($Sensor[17]['valor'])&&($Sensor[17]['valor']>$x_Max OR $Sensor[17]['valor']<$x_Min)){ $Sensor[17]['valor'] = 99901;$Sensor[18]['valor']  = 99901;}
		if(isset($Sensor[19]['valor'])&&($Sensor[19]['valor']>$x_Max OR $Sensor[19]['valor']<$x_Min)){ $Sensor[19]['valor'] = 99901;$Sensor[20]['valor']  = 99901;}
		if(isset($Sensor[21]['valor'])&&($Sensor[21]['valor']>$x_Max OR $Sensor[21]['valor']<$x_Min)){ $Sensor[21]['valor'] = 99901;$Sensor[22]['valor']  = 99901;}
		if(isset($Sensor[23]['valor'])&&($Sensor[23]['valor']>$x_Max OR $Sensor[23]['valor']<$x_Min)){ $Sensor[23]['valor'] = 99901;$Sensor[24]['valor']  = 99901;}
		if(isset($Sensor[25]['valor'])&&($Sensor[25]['valor']>$x_Max OR $Sensor[25]['valor']<$x_Min)){ $Sensor[25]['valor'] = 99901;$Sensor[26]['valor']  = 99901;}
		if(isset($Sensor[27]['valor'])&&($Sensor[27]['valor']>$x_Max OR $Sensor[27]['valor']<$x_Min)){ $Sensor[27]['valor'] = 99901;$Sensor[28]['valor']  = 99901;}
		if(isset($Sensor[29]['valor'])&&($Sensor[29]['valor']>$x_Max OR $Sensor[29]['valor']<$x_Min)){ $Sensor[29]['valor'] = 99901;$Sensor[30]['valor']  = 99901;}
		if(isset($Sensor[31]['valor'])&&($Sensor[31]['valor']>$x_Max OR $Sensor[31]['valor']<$x_Min)){ $Sensor[31]['valor'] = 99901;$Sensor[32]['valor']  = 99901;}
		if(isset($Sensor[33]['valor'])&&($Sensor[33]['valor']>$x_Max OR $Sensor[33]['valor']<$x_Min)){ $Sensor[33]['valor'] = 99901;$Sensor[34]['valor']  = 99901;}
		if(isset($Sensor[35]['valor'])&&($Sensor[35]['valor']>$x_Max OR $Sensor[35]['valor']<$x_Min)){ $Sensor[35]['valor'] = 99901;$Sensor[36]['valor']  = 99901;}
		if(isset($Sensor[37]['valor'])&&($Sensor[37]['valor']>$x_Max OR $Sensor[37]['valor']<$x_Min)){ $Sensor[37]['valor'] = 99901;$Sensor[38]['valor']  = 99901;}
		if(isset($Sensor[39]['valor'])&&($Sensor[39]['valor']>$x_Max OR $Sensor[39]['valor']<$x_Min)){ $Sensor[39]['valor'] = 99901;$Sensor[40]['valor']  = 99901;}
		if(isset($Sensor[41]['valor'])&&($Sensor[41]['valor']>$x_Max OR $Sensor[41]['valor']<$x_Min)){ $Sensor[41]['valor'] = 99901;$Sensor[42]['valor']  = 99901;}
		if(isset($Sensor[43]['valor'])&&($Sensor[43]['valor']>$x_Max OR $Sensor[43]['valor']<$x_Min)){ $Sensor[43]['valor'] = 99901;$Sensor[44]['valor']  = 99901;}
		if(isset($Sensor[45]['valor'])&&($Sensor[45]['valor']>$x_Max OR $Sensor[45]['valor']<$x_Min)){ $Sensor[45]['valor'] = 99901;$Sensor[46]['valor']  = 99901;}
		if(isset($Sensor[47]['valor'])&&($Sensor[47]['valor']>$x_Max OR $Sensor[47]['valor']<$x_Min)){ $Sensor[47]['valor'] = 99901;$Sensor[48]['valor']  = 99901;}
		if(isset($Sensor[49]['valor'])&&($Sensor[49]['valor']>$x_Max OR $Sensor[49]['valor']<$x_Min)){ $Sensor[49]['valor'] = 99901;$Sensor[50]['valor']  = 99901;}
		if(isset($Sensor[51]['valor'])&&($Sensor[51]['valor']>$x_Max OR $Sensor[51]['valor']<$x_Min)){ $Sensor[51]['valor'] = 99901;$Sensor[52]['valor']  = 99901;}

		break;
	/******************************************************************/
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
	/******************************************************************/
	//Unifrutti
	case '71':
		//Calibracion Sensor 1  Camara 1
		$temp               = $Sensor[1]['valor']-2.5;
		$Sensor[1]['valor'] = floatval(number_format($temp, 2, '.', ''));

		//Calibracion Sensor 23 Camara 6
		$temp                = $Sensor[23]['valor']-1.5;
		$Sensor[23]['valor'] = floatval(number_format($temp, 2, '.', ''));

		//Calibracion Sensor 31
		$temp                = $Sensor[31]['valor']-2.0;
		$Sensor[31]['valor'] = floatval(number_format($temp, 2, '.', ''));


		//Control fuera de linea
		//camaras 1
		if(isset($Sensor[69]['valor'])&&$Sensor[69]['valor']==1){
			//reasigno valores del sensor 33 al 68
			for ($i = 33; $i <= 68; $i++) {
				$Sensor[$i]['valor'] = 99901;
			}
		}
		//Camaras 2
		if(isset($Sensor[70]['valor'])&&$Sensor[70]['valor']==1){
			//Se cambia Identificador del
			$Identificador = '233';
		}
		//Prefrio 1
		if(isset($Sensor[71]['valor'])&&$Sensor[71]['valor']==1){
			//reasigno Identificador
			$Identificador = '230';
		}
		//Prefrio 2
		if(isset($Sensor[72]['valor'])&&$Sensor[72]['valor']==1){
			//reasigno Identificador
			$Identificador = '231';
			if(isset($Sensor[61]['valor'])&&$Sensor[61]['valor']<-5){    $Sensor[61]['valor']  = 99900;}
			if(isset($Sensor[62]['valor'])&&$Sensor[62]['valor']<-5){    $Sensor[62]['valor']  = 99900;}
			if(isset($Sensor[63]['valor'])&&$Sensor[63]['valor']<-5){    $Sensor[63]['valor']  = 99900;}
			if(isset($Sensor[64]['valor'])&&$Sensor[64]['valor']<-5){    $Sensor[64]['valor']  = 99900;}
			if(isset($Sensor[65]['valor'])&&$Sensor[65]['valor']<-5){    $Sensor[65]['valor']  = 99900;}
			if(isset($Sensor[66]['valor'])&&$Sensor[66]['valor']<-5){    $Sensor[66]['valor']  = 99900;}
			if(isset($Sensor[67]['valor'])&&$Sensor[67]['valor']<-5){    $Sensor[67]['valor']  = 99900;}
			if(isset($Sensor[68]['valor'])&&$Sensor[68]['valor']<-5){    $Sensor[68]['valor']  = 99900;}
		}
		break;
	/******************************************************************/
	//Exser Rosario
	case '221':
		//valido los valores
		$temp                = $Sensor[47]['valor']-1.6;
		$Sensor[47]['valor'] = floatval(number_format($temp, 2, '.', ''));
		break;
	/******************************************************************/
	//CENCOSUD
	case '252':
		/********CONTROL DE LIMITES**************************/
		//Temperatura
		$x_Min = -30;
		$x_Max = 50;

		//
		//	if(isset($Sensor[1]['valor'])&&($Sensor[1]['valor']>$x_Max OR $Sensor[1]['valor']<$x_Min)){    $Sensor[1]['valor']  = 99901;$Sensor[2]['valor']  = 99901;$Sensor[3]['valor']  = 99901;}
		//	if(isset($Sensor[4]['valor'])&&($Sensor[4]['valor']>$x_Max OR $Sensor[4]['valor']<$x_Min)){    $Sensor[4]['valor']  = 99901;$Sensor[5]['valor']  = 99901;$Sensor[6]['valor']  = 99901;}
		//	if(isset($Sensor[7]['valor'])&&($Sensor[7]['valor']>$x_Max OR $Sensor[7]['valor']<$x_Min)){    $Sensor[7]['valor']  = 99901;$Sensor[8]['valor']  = 99901;$Sensor[9]['valor']  = 99901;}
			if(isset($Sensor[10]['valor'])&&($Sensor[10]['valor']>$x_Max OR $Sensor[10]['valor']<$x_Min)){ $Sensor[10]['valor'] = 99901;$Sensor[11]['valor']  = 99901;$Sensor[12]['valor']  = 99901;}
		//	if(isset($Sensor[13]['valor'])&&($Sensor[13]['valor']>$x_Max OR $Sensor[13]['valor']<$x_Min)){ $Sensor[13]['valor'] = 99901;$Sensor[14]['valor']  = 99901;$Sensor[15]['valor']  = 99901;}
		//	if(isset($Sensor[16]['valor'])&&($Sensor[16]['valor']>$x_Max OR $Sensor[16]['valor']<$x_Min)){ $Sensor[16]['valor'] = 99901;$Sensor[17]['valor']  = 99901;$Sensor[18]['valor']  = 99901;}
			if(isset($Sensor[19]['valor'])&&($Sensor[19]['valor']>$x_Max OR $Sensor[19]['valor']<$x_Min)){ $Sensor[19]['valor'] = 99901;$Sensor[20]['valor']  = 99901;$Sensor[21]['valor']  = 99901;}
		//	if(isset($Sensor[22]['valor'])&&($Sensor[22]['valor']>$x_Max OR $Sensor[22]['valor']<$x_Min)){ $Sensor[22]['valor'] = 99901;$Sensor[23]['valor']  = 99901;$Sensor[24]['valor']  = 99901;}
		//	if(isset($Sensor[25]['valor'])&&($Sensor[25]['valor']>$x_Max OR $Sensor[25]['valor']<$x_Min)){ $Sensor[25]['valor'] = 99901;$Sensor[26]['valor']  = 99901;$Sensor[27]['valor']  = 99901;}
		//	if(isset($Sensor[28]['valor'])&&($Sensor[28]['valor']>$x_Max OR $Sensor[28]['valor']<$x_Min)){ $Sensor[28]['valor'] = 99901;$Sensor[29]['valor']  = 99901;$Sensor[30]['valor']  = 99901;}
		//	if(isset($Sensor[31]['valor'])&&($Sensor[31]['valor']>$x_Max OR $Sensor[31]['valor']<$x_Min)){ $Sensor[31]['valor'] = 99901;$Sensor[32]['valor']  = 99901;$Sensor[33]['valor']  = 99901;}
		//	if(isset($Sensor[34]['valor'])&&($Sensor[34]['valor']>$x_Max OR $Sensor[34]['valor']<$x_Min)){ $Sensor[34]['valor'] = 99901;$Sensor[35]['valor']  = 99901;$Sensor[36]['valor']  = 99901;}

		break;
	/******************************************************************/
	//MEREX
	case '167':
		$s6c2f = $Sensor[22]['valor']*1.012;
  		$Sensor[21]['valor'] = floatval(number_format($s6c2f, 1, '.', ''));
		break;
	/******************************************************************/
	//Walmart
	case '249':
		//Modificacion para todos
		if(isset($Sensor[2]['valor'],$Sensor[3]['valor'])&&$Sensor[2]['valor']!=''&&$Sensor[3]['valor']!=''){ $Sensor[1]['valor'] =   (($Sensor[2]['valor']+$Sensor[3]['valor'])/2)+(rand(-1010, 1010)/1000);}
		if(isset($Sensor[3]['valor'],$Sensor[4]['valor'])&&$Sensor[3]['valor']!=''&&$Sensor[4]['valor']!=''){ $Sensor[5]['valor'] =   (($Sensor[3]['valor']+$Sensor[4]['valor'])/2)+(rand(-1010, 1010)/1000);}
		break;




	/******************************************************************/
	//asd
	case 'asd':
		//Modificacion para todos
		$Sensor[2]['valor'] = $Sensor[1]['valor'];
		break;

}



?>
