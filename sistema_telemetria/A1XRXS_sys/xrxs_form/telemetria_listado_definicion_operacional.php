<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-173).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idDefinicion']))   $idDefinicion   = $_POST['idDefinicion'];
	if (!empty($_POST['idTelemetria']))   $idTelemetria   = $_POST['idTelemetria'];
	if (!empty($_POST['N_Sensor']))       $N_Sensor       = $_POST['N_Sensor'];
	if ( isset($_POST['ValorActivo']))    $ValorActivo    = $_POST['ValorActivo'];
	if ( isset($_POST['RangoMinimo']))    $RangoMinimo    = $_POST['RangoMinimo'];
	if ( isset($_POST['RangoMaximo']))    $RangoMaximo    = $_POST['RangoMaximo'];
	if (!empty($_POST['idFuncion']))      $idFuncion      = $_POST['idFuncion'];

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
			case 'idDefinicion':   if(empty($idDefinicion)){   $error['idDefinicion']   = 'error/No ha ingresado el id';}break;
			case 'idTelemetria':   if(empty($idTelemetria)){   $error['idTelemetria']   = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'N_Sensor':       if(empty($N_Sensor)){       $error['N_Sensor']       = 'error/No ha ingresado el numero de sensor';}break;
			case 'ValorActivo':    if(!isset($ValorActivo)){   $error['ValorActivo']    = 'error/No ha ingresado el valor de activo';}break;
			case 'RangoMinimo':    if(!isset($RangoMinimo)){   $error['RangoMinimo']    = 'error/No ha ingresado el valor de Rango Minimo';}break;
			case 'RangoMaximo':    if(!isset($RangoMaximo)){   $error['RangoMaximo']    = 'error/No ha ingresado el valor de Rango Maximo';}break;
			case 'idFuncion':      if(empty($idFuncion)){      $error['idFuncion']      = 'error/No ha seleccionado la funcion';}break;

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

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idTelemetria)&&isset($N_Sensor)){
				$ndata_1 = db_select_nrows (false, 'idDefinicion', 'telemetria_listado_definicion_operacional', '', "idTelemetria='".$idTelemetria."' AND N_Sensor='".$N_Sensor."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data  = "'".$idTelemetria."'";   }else{$SIS_data  = "''";}
				if(isset($N_Sensor) && $N_Sensor!=''){           $SIS_data .= ",'".$N_Sensor."'";      }else{$SIS_data .= ",''";}
				if(isset($ValorActivo) && $ValorActivo!=''){     $SIS_data .= ",'".$ValorActivo."'";   }else{$SIS_data .= ",''";}
				if(isset($RangoMinimo) && $RangoMinimo!=''){     $SIS_data .= ",'".$RangoMinimo."'";   }else{$SIS_data .= ",''";}
				if(isset($RangoMaximo) && $RangoMaximo!=''){     $SIS_data .= ",'".$RangoMaximo."'";   }else{$SIS_data .= ",''";}
				if(isset($idFuncion) && $idFuncion!=''){         $SIS_data .= ",'".$idFuncion."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria, N_Sensor, ValorActivo, RangoMinimo, RangoMaximo, idFuncion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_definicion_operacional', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idTelemetria)&&isset($N_Sensor)&&isset($idDefinicion)){
				$ndata_1 = db_select_nrows (false, 'idDefinicion', 'telemetria_listado_definicion_operacional', '', "idTelemetria='".$idTelemetria."' AND N_Sensor='".$N_Sensor."' AND idDefinicion!='".$idDefinicion."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idDefinicion='".$idDefinicion."'";
				if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($N_Sensor) && $N_Sensor!=''){           $SIS_data .= ",N_Sensor='".$N_Sensor."'";}
				if(isset($ValorActivo) && $ValorActivo!=''){     $SIS_data .= ",ValorActivo='".$ValorActivo."'";}
				if(isset($RangoMinimo) && $RangoMinimo!=''){     $SIS_data .= ",RangoMinimo='".$RangoMinimo."'";}
				if(isset($RangoMaximo) && $RangoMaximo!=''){     $SIS_data .= ",RangoMaximo='".$RangoMaximo."'";}
				if(isset($idFuncion) && $idFuncion!=''){         $SIS_data .= ",idFuncion='".$idFuncion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_definicion_operacional', 'idDefinicion = "'.$idDefinicion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;

/*******************************************************************************************************************/
		case 'del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del']) OR !validaEntero($_GET['del']))&&$_GET['del']!=''){
				$indice = simpleDecode($_GET['del'], fecha_actual());
			}else{
				$indice = $_GET['del'];
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
				$resultado = db_delete_data (false, 'telemetria_listado_definicion_operacional', 'idDefinicion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
