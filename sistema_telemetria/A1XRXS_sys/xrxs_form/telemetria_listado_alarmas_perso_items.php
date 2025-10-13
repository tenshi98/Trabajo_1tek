<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-171).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idItem']))             $idItem              = $_POST['idItem'];
	if (!empty($_POST['idTelemetria']))       $idTelemetria        = $_POST['idTelemetria'];
	if (!empty($_POST['idAlarma']))           $idAlarma            = $_POST['idAlarma'];
	if (!empty($_POST['Sensor_N']))           $Sensor_N            = $_POST['Sensor_N'];
	if ( isset($_POST['Rango_ini']))          $Rango_ini           = $_POST['Rango_ini'];
	if ( isset($_POST['Rango_fin']))          $Rango_fin           = $_POST['Rango_fin'];
	if ( isset($_POST['valor_especifico']))   $valor_especifico    = $_POST['valor_especifico'];

/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $_SESSION['form_require']);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'idItem':            if(empty($idItem)){              $error['idItem']             = 'error/No ha ingresado el id';}break;
			case 'idTelemetria':      if(empty($idTelemetria)){        $error['idTelemetria']       = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'idAlarma':          if(empty($idAlarma)){            $error['idAlarma']           = 'error/No ha seleccionado el tipo de alarma';}break;
			case 'Sensor_N':          if(empty($Sensor_N)){            $error['Sensor_N']           = 'error/No ha seleccionado el Sensor';}break;
			case 'Rango_ini':         if(!isset($Rango_ini)){          $error['Rango_ini']          = 'error/No ha ingresado el rango de inicio';}break;
			case 'Rango_fin':         if(!isset($Rango_fin)){          $error['Rango_fin']          = 'error/No ha ingresado el rango de termino';}break;
			case 'valor_especifico':  if(!isset($valor_especifico)){   $error['valor_especifico']   = 'error/No ha ingresado el valor especifico';}break;

		}
	}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idTelemetria) && $idTelemetria!=''){           $SIS_data  = "'".$idTelemetria."'";        }else{$SIS_data  = "''";}
				if(isset($idAlarma) && $idAlarma!=''){                   $SIS_data .= ",'".$idAlarma."'";           }else{$SIS_data .= ",''";}
				if(isset($Sensor_N) && $Sensor_N!=''){                   $SIS_data .= ",'".$Sensor_N."'";           }else{$SIS_data .= ",''";}
				if(isset($Rango_ini) && $Rango_ini!=''){                 $SIS_data .= ",'".$Rango_ini."'";          }else{$SIS_data .= ",''";}
				if(isset($Rango_fin) && $Rango_fin!=''){                 $SIS_data .= ",'".$Rango_fin."'";          }else{$SIS_data .= ",''";}
				if(isset($valor_especifico) && $valor_especifico!=''){   $SIS_data .= ",'".$valor_especifico."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria, idAlarma, Sensor_N, Rango_ini, Rango_fin, valor_especifico';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_alarmas_perso_items', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idItem='".$idItem."'";
				if(isset($idTelemetria) && $idTelemetria!=''){          $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($idAlarma) && $idAlarma!=''){                  $SIS_data .= ",idAlarma='".$idAlarma."'";}
				if(isset($Sensor_N) && $Sensor_N!=''){                  $SIS_data .= ",Sensor_N='".$Sensor_N."'";}
				if(isset($Rango_ini) && $Rango_ini!=''){                $SIS_data .= ",Rango_ini='".$Rango_ini."'";}
				if(isset($Rango_fin) && $Rango_fin!=''){                $SIS_data .= ",Rango_fin='".$Rango_fin."'";}
				if(isset($valor_especifico) && $valor_especifico!=''){  $SIS_data .= ",valor_especifico='".$valor_especifico."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_alarmas_perso_items', 'idItem = "'.$idItem.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'delAlarma_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['delAlarma_item']) OR !validaEntero($_GET['delAlarma_item']))&&$_GET['delAlarma_item']!=''){
				$indice = simpleDecode($_GET['delAlarma_item'], fecha_actual());
			}else{
				$indice = $_GET['delAlarma_item'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice)&&$indice!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice)&&$indice!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			if($errorn==0){
				//se borran los datos
				$resultado = db_delete_data (false, 'telemetria_listado_alarmas_perso_items', 'idItem = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;

/*******************************************************************************************************************/
	}

?>
