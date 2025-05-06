<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-064).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idUbicaciones']))   $idUbicaciones    = $_POST['idUbicaciones'];
	if (!empty($_POST['idPredio']))        $idPredio         = $_POST['idPredio'];
	if (!empty($_POST['idZona']))          $idZona           = $_POST['idZona'];
	if (!empty($_POST['Latitud']))         $Latitud          = $_POST['Latitud'];
	if (!empty($_POST['Longitud']))        $Longitud         = $_POST['Longitud'];

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
			case 'idUbicaciones':   if(empty($idUbicaciones)){   $error['idUbicaciones']   = 'error/No ha ingresado el id';}break;
			case 'idPredio':        if(empty($idPredio)){        $error['idPredio']        = 'error/No ha seleccionado el predio';}break;
			case 'idZona':          if(empty($idZona)){          $error['idZona']          = 'error/No ha seleccionado el cuartel';}break;
			case 'Latitud':         if(empty($Latitud)){         $error['Latitud']         = 'error/No ha ingresado la Latitud';}break;
			case 'Longitud':        if(empty($Longitud)){        $error['Longitud']        = 'error/No ha ingresado la Longitud';}break;

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
				if(isset($idPredio) && $idPredio!=''){      $SIS_data  = "'".$idPredio."'";     }else{$SIS_data  = "''";}
				if(isset($idZona) && $idZona!=''){          $SIS_data .= ",'".$idZona."'";      }else{$SIS_data .= ",''";}
				if(isset($Latitud) && $Latitud!=''){        $SIS_data .= ",'".$Latitud."'";     }else{$SIS_data .= ",''";}
				if(isset($Longitud) && $Longitud!=''){      $SIS_data .= ",'".$Longitud."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idPredio, idZona, Latitud, Longitud';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_predios_listado_zonas_ubicaciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$SIS_data = "idUbicaciones='".$idUbicaciones."'";
				if(isset($idPredio) && $idPredio!=''){ $SIS_data .= ",idPredio='".$idPredio."'";}
				if(isset($idZona) && $idZona!=''){     $SIS_data .= ",idZona='".$idZona."'";}
				if(isset($Latitud) && $Latitud!=''){   $SIS_data .= ",Latitud='".$Latitud."'";}
				if(isset($Longitud) && $Longitud!=''){ $SIS_data .= ",Longitud='".$Longitud."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_predios_listado_zonas_ubicaciones', 'idUbicaciones = "'.$idUbicaciones.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_punto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_punto']) OR !validaEntero($_GET['del_punto']))&&$_GET['del_punto']!=''){
				$indice = simpleDecode($_GET['del_punto'], fecha_actual());
			}else{
				$indice = $_GET['del_punto'];
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
				$resultado = db_delete_data (false, 'cross_predios_listado_zonas_ubicaciones', 'idUbicaciones = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
