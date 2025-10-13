<?php
/*******************************************************************************************************************/
/*                                                Se ejecuta codigo                                                */
/*******************************************************************************************************************/
//Variable para el registro de correos enviados
$sis_body = "\n
################################################################################
Fecha de envio : ".$FechaSistema."
Hora Actual : ".$HoraSistema."
Correos enviados :\n";

/**************************************/
//se guarda log de correos enviados
if(isset($LogAlertas)&&$LogAlertas!=''){
	//Le agrego los datos al cuerpo del log
	$sis_body .= $LogAlertas;

	//Se guarda el registro de los correos enviados
	if ($FP = fopen ($ardu_file_log_4, "a")){
		fwrite ($FP, $sis_body);
		fclose ($FP);
	}
}

?>
