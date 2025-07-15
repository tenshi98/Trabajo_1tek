<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                                  MODIFICACION MANUAL A LOS DATOS RECIBIDOS                         */
/*                                                                                                    */
/******************************************************************************************************/

/*********************************************************************/
/*                     Cambio del Identificador                      */
/*********************************************************************/
//se definen los equipos a revisar
$Equipos_Ex = array('175', '197', '155', '234');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	/******************************************/
	//cambio de valores
	switch ($Identificador) {
		case 175:
		case 197:
			//se crea sensor inexistente de voltaje
			if(isset($Sensor[7]['valor'])&&$Sensor[7]['valor']==99900){ $Sensor[7]['valor'] = 0;}
			$Sensor[37]['valor'] = $Sensor[7]['valor'];
			//asigno el total de sensores
			$Var_Counter = 37;
			break;
	}

	/******************************************/
	//se cambia el nombre del identificador
	switch ($Identificador) {
		case 175:$Identificador = 'gen_175';break;
		case 197:$Identificador = 'gen_197';break;
		case 155:$Identificador = 'elv-5';break;
                case 234:$Identificador = '236';break;

	}

}

/*********************************************************************/
/*                               CrossWeather                          */
/*********************************************************************/
//se definen los equipos a revisar
$Equipos_Ex = array('CrossWhether','az1','cw3','az2');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	//si el sensor tiene un valor superior a 100 le asigna el valor 100
	if(isset($Sensor[2]['valor'])&&$Sensor[2]['valor']>100&&$Sensor[2]['valor']!=99900){
		$Sensor[2]['valor']=100;
	}
}

/*********************************************************************/
/*                               Del Monte                           */
/*********************************************************************/
//se definen los equipos a revisar
$Equipos_Ex = array('dm1-LPC');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {

	if(isset($Sensor[1]['valor'])&&$Sensor[1]['valor']==25){   $Sensor[1]['valor']  = 99900;}
	if(isset($Sensor[2]['valor'])&&$Sensor[2]['valor']==25){   $Sensor[2]['valor']  = 99900;}
	if(isset($Sensor[3]['valor'])&&$Sensor[3]['valor']==25){   $Sensor[3]['valor']  = 99900;}
	if(isset($Sensor[4]['valor'])&&$Sensor[4]['valor']==25){   $Sensor[4]['valor']  = 99900;}
	if(isset($Sensor[5]['valor'])&&$Sensor[5]['valor']==25){   $Sensor[5]['valor']  = 99900;}
	if(isset($Sensor[6]['valor'])&&$Sensor[6]['valor']==25){   $Sensor[6]['valor']  = 99900;}
	if(isset($Sensor[11]['valor'])&&$Sensor[11]['valor']==25){ $Sensor[11]['valor'] = 99900;}
	if(isset($Sensor[12]['valor'])&&$Sensor[12]['valor']==25){ $Sensor[12]['valor'] = 99900;}

	if(isset($Sensor[4]['valor'])&&$Sensor[4]['valor']==999){   $Sensor[4]['valor']  = 99901;}
	if(isset($Sensor[5]['valor'])&&$Sensor[5]['valor']==999){   $Sensor[5]['valor']  = 99901;}
	if(isset($Sensor[6]['valor'])&&$Sensor[6]['valor']==999){   $Sensor[6]['valor']  = 99901;}
	if(isset($Sensor[12]['valor'])&&$Sensor[12]['valor']==999){ $Sensor[12]['valor'] = 99901;}

}

/*********************************************************************/
/*                                HD                                 /*
/*********************************************************************/
//se definen los equipos a revisar
$Equipos_Ex = array('gr1','gr2','gr3','gr4','gr5','gr6','gr7','gr8','gr9','gr10','gr11','gr12','gr13','gr14','gr15','gr16','gr17','gr18','gr19','gr20','gr21','gr22','gr23','gr24','gr25','gr26','gr27','gr28','gr29','gr30','gr31','gr32','gr33','gr34','gr35','gr36','gr37','gr38','gr39','gr40','gr41','gr42','gr43','gr44','gr20');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	//Modificacion para todos
	if(isset($Sensor[37]['valor'])&&$Sensor[37]['valor']<100){$Sensor[37]['valor']=99900;}
}

/*********************************************************************/
/*                                 MEREX                             */
/*********************************************************************/
//Linea de Proceso
$Equipos_Ex = array('167');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	if(isset($Sensor[21]['valor'])&&$Sensor[21]['valor']==25){      $Sensor[21]['valor']=99900;}
	if(isset($Sensor[22]['valor'])&&$Sensor[22]['valor']==25){      $Sensor[24]['valor']=99900;}
	if(isset($Sensor[24]['valor'])&&$Sensor[24]['valor']==25){      $Sensor[23]['valor']=99900;}
	if(isset($Sensor[25]['valor'])&&$Sensor[25]['valor']==25){      $Sensor[25]['valor']=99900;}
	if(isset($Sensor[26]['valor'])&&$Sensor[26]['valor']==25){      $Sensor[26]['valor']=99900;}

	//Control Equipo escloavos y fuera de linea
	if(isset($Sensor[71]['valor'])&&$Sensor[71]['valor']==2){
		$Sensor[25]['valor'] = 99901;
		$Sensor[26]['valor'] = 99901;
	}
}

/*********************************************************************/
/*                                 Unifrutti                         */
/*********************************************************************/
$Equipos_Ex = array('71');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	//cambio el input del sensor
	$Sensor[17]['valor']   = LimpiarInput($_GET['S17']);
	$validacion = -10;
	//valido los valores
	if($Sensor[11]['valor']<$validacion){$Sensor[11]['valor']=99900;}
}

$Equipos_Ex = array('233');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	if(isset($Sensor[1]['valor'])&&$Sensor[1]['valor']==9990){      $Sensor[21]['valor']=99901;}
	if(isset($Sensor[2]['valor'])&&$Sensor[2]['valor']==9990){      $Sensor[24]['valor']=99901;}
	if(isset($Sensor[3]['valor'])&&$Sensor[3]['valor']==9990){      $Sensor[23]['valor']=99901;}
	if(isset($Sensor[4]['valor'])&&$Sensor[4]['valor']==9990){      $Sensor[25]['valor']=99901;}
}



/*********************************************************************/
/*                         Frigorifico Rosario                       */
/*********************************************************************/
$Equipos_Ex = array('221');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	//variables
	$validacion = -4;
	//valido los valores
	if($Sensor[45]['valor']<$validacion){$Sensor[45]['valor']=99900;}
	if($Sensor[47]['valor']<$validacion){$Sensor[47]['valor']=99900;}

	/*
	//si alguno es inferior a -4
	if(($Sensor[45]['valor']<$validacion)OR($Sensor[47]['valor']<$validacion)){
		//Verifico el mayor
		if($Sensor[45]['valor']<$Sensor[47]['valor']){
			$valorx = $Sensor[47]['valor'] - $Sensor[45]['valor'];
		}elseif($Sensor[47]['valor']<$Sensor[45]['valor']){
			$valorx = $Sensor[45]['valor'] - $Sensor[47]['valor'];
		}
		//Verifico diferencia, si es mayor a 2
		if($valorx>=2){
			//redeclaro el sensor con error
			if($Sensor[45]['valor']<$validacion){$Sensor[45]['valor']=99900;}
			if($Sensor[47]['valor']<$validacion){$Sensor[47]['valor']=99900;}
		}
	}
*/
}

/*********************************************************************/
/*                         FrigorificoSan Felipe                   */
/*********************************************************************/
$Equipos_Ex = array('217');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	//variables
	$validacion = -4;
	//valido los valores
	if($Sensor[17]['valor']<$validacion){$Sensor[17]['valor']=99900;}
	//if($Sensor[47]['valor']<$validacion){$Sensor[47]['valor']=99900;}

	/*
	//si alguno es inferior a -4
	if(($Sensor[45]['valor']<$validacion)OR($Sensor[47]['valor']<$validacion)){
		//Verifico el mayor
		if($Sensor[45]['valor']<$Sensor[47]['valor']){
			$valorx = $Sensor[47]['valor'] - $Sensor[45]['valor'];
		}elseif($Sensor[47]['valor']<$Sensor[45]['valor']){
			$valorx = $Sensor[45]['valor'] - $Sensor[47]['valor'];
		}
		//Verifico diferencia, si es mayor a 2
		if($valorx>=2){
			//redeclaro el sensor con error
			if($Sensor[45]['valor']<$validacion){$Sensor[45]['valor']=99900;}
			if($Sensor[47]['valor']<$validacion){$Sensor[47]['valor']=99900;}
		}
	}
*/
}

/*********************************************************************/
/*                     Cambio del Identificador                      */
/*********************************************************************/
//se definen los equipos a revisar
$Equipos_Ex = array('229');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	/******************************************/
	//cambio de valores
	$Sensor[2]['valor'] = rand(85,95);

}

/*********************************************************************/
/*                     Cambio del Identificador                      */
/*********************************************************************/
//se definen los equipos a revisar
$Equipos_Ex = array('245');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	/******************************************/
	//cambio de valores
	$Sensor[2]['valor'] = $Sensor[1]['valor'] * (rand(98,99)/100);

}
//se definen los equipos a revisar
$Equipos_Ex = array('247');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	/******************************************/
	//cambio de valores
	$Sensor[2]['valor'] = $Sensor[1]['valor'] * (rand(981,989)/1000);
	$Sensor[3]['valor'] = $Sensor[1]['valor'] * (rand(981,989)/1000);

}
//se definen los equipos a revisar
$Equipos_Ex = array('248');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	/******************************************/
	//cambio de valores
	$Sensor[2]['valor'] = $Sensor[1]['valor'] * (rand(95,98)/100);

}

//se definen los equipos a revisar
$Equipos_Ex = array('244');
//verifico si el dato ingresado existe dentro de las opciones
if (in_array($Identificador, $Equipos_Ex)) {
	/******************************************/
	//cambio de valores
	$Sensor[1]['valor'] = $Sensor[2]['valor'] * (rand(95,98)/100);

}


?>
