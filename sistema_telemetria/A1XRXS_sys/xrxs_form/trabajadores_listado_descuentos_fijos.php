<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-200).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idDescuento']))      $idDescuento      = $_POST['idDescuento'];
	if (!empty($_POST['idTrabajador']))     $idTrabajador     = $_POST['idTrabajador'];
	if (!empty($_POST['idDescuentoFijo']))  $idDescuentoFijo  = $_POST['idDescuentoFijo'];
	if (!empty($_POST['idAFP']))            $idAFP            = $_POST['idAFP'];
	if (!empty($_POST['Monto']))            $Monto            = $_POST['Monto'];

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
			case 'idDescuento':     if(empty($idDescuento)){      $error['idDescuento']     = 'error/No ha ingresado el id';}break;
			case 'idTrabajador':    if(empty($idTrabajador)){     $error['idTrabajador']    = 'error/No ha seleccionado el trabajador';}break;
			case 'idDescuentoFijo': if(empty($idDescuentoFijo)){  $error['idDescuentoFijo'] = 'error/No ha seleccionado el descuento';}break;
			case 'idAFP':           if(empty($idAFP)){            $error['idAFP']           = 'error/No ha seleccionado la AFP';}break;
			case 'Monto':           if(empty($Monto)){            $error['Monto']           = 'error/No ha ingresado el monto';}break;

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
			if(isset($idDescuentoFijo)&&isset($idTrabajador)){
				$ndata_1 = db_select_nrows (false, 'idDescuentoFijo', 'trabajadores_listado_descuentos_fijos', '', "idDescuentoFijo='".$idDescuentoFijo."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El descuento ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idTrabajador) && $idTrabajador!=''){        $SIS_data  = "'".$idTrabajador."'";     }else{$SIS_data  = "''";}
				if(isset($idDescuentoFijo) && $idDescuentoFijo!=''){  $SIS_data .= ",'".$idDescuentoFijo."'"; }else{$SIS_data .= ",''";}
				if(isset($idAFP) && $idAFP!=''){                      $SIS_data .= ",'".$idAFP."'";           }else{$SIS_data .= ",''";}
				if(isset($Monto) && $Monto!=''){                      $SIS_data .= ",'".$Monto."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTrabajador, idDescuentoFijo, idAFP, Monto';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_listado_descuentos_fijos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($idDescuentoFijo)&&isset($idTrabajador)&&isset($idDescuento)){
				$ndata_1 = db_select_nrows (false, 'idDescuentoFijo', 'trabajadores_listado_descuentos_fijos', '', "idDescuentoFijo='".$idDescuentoFijo."' AND idTrabajador='".$idTrabajador."' AND idDescuento!='".$idDescuento."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Bono ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idDescuento='".$idDescuento."'";
				if(isset($idTrabajador) && $idTrabajador!=''){        $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
				if(isset($idDescuentoFijo) && $idDescuentoFijo!=''){  $SIS_data .= ",idDescuentoFijo='".$idDescuentoFijo."'";}
				if(isset($idAFP) && $idAFP!=''){                      $SIS_data .= ",idAFP='".$idAFP."'";}
				if(isset($Monto) && $Monto!=''){                      $SIS_data .= ",Monto='".$Monto."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado_descuentos_fijos', 'idDescuento = "'.$idDescuento.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'trabajadores_listado_descuentos_fijos', 'idDescuento = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
