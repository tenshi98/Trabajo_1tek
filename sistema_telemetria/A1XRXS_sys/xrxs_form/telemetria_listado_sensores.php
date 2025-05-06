<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-180).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idSensores']))      $idSensores      = $_POST['idSensores'];
	if (!empty($_POST['Nombre']))          $Nombre          = $_POST['Nombre'];
	if (!empty($_POST['Funcion']))         $Funcion         = $_POST['Funcion'];
	if (!empty($_POST['idSensorFuncion'])) $idSensorFuncion = $_POST['idSensorFuncion'];

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
			case 'idSensores':      if(empty($idSensores)){      $error['idSensores']      = 'error/No ha ingresado el id';}break;
			case 'Nombre':          if(empty($Nombre)){          $error['Nombre']          = 'error/No ha ingresado el nombre';}break;
			case 'Funcion':         if(empty($Funcion)){         $error['Funcion']         = 'error/No ha ingresado la funcion';}break;
			case 'idSensorFuncion': if(empty($idSensorFuncion)){ $error['idSensorFuncion'] = 'error/No ha seleccionado la funcion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){   $Nombre  = EstandarizarInput($Nombre);}
	if(isset($Funcion) && $Funcion!=''){ $Funcion = EstandarizarInput($Funcion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){    $error['Nombre']  = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Funcion)&&contar_palabras_censuradas($Funcion)!=0){  $error['Funcion'] = 'error/Edita la Funcion, contiene palabras no permitidas';}

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
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_listado_sensores', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){                    $SIS_data  = "'".$Nombre."'";             }else{$SIS_data  = "''";}
				if(isset($Funcion) && $Funcion!=''){                  $SIS_data .= ",'".$Funcion."'";           }else{$SIS_data .= ",''";}
				if(isset($idSensorFuncion) && $idSensorFuncion!=''){  $SIS_data .= ",'".$idSensorFuncion."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,Funcion, idSensorFuncion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($idSensores)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_listado_sensores', '', "Nombre='".$Nombre."' AND idSensores!='".$idSensores."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idSensores='".$idSensores."'";
				if(isset($Nombre) && $Nombre!=''){                      $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Funcion) && $Funcion!=''){                    $SIS_data .= ",Funcion='".$Funcion."'";}
				if(isset($idSensorFuncion) && $idSensorFuncion!=''){    $SIS_data .= ",idSensorFuncion='".$idSensorFuncion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_sensores', 'idSensores = "'.$idSensores.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'telemetria_listado_sensores', 'idSensores = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
