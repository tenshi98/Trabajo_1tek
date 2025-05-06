<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-198).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idBono']))         $idBono        = $_POST['idBono'];
	if (!empty($_POST['idTrabajador']))   $idTrabajador  = $_POST['idTrabajador'];
	if (!empty($_POST['idBonoFijo']))     $idBonoFijo    = $_POST['idBonoFijo'];
	if (!empty($_POST['Monto']))          $Monto         = $_POST['Monto'];

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
			case 'idBono':         if(empty($idBono)){        $error['idBono']         = 'error/No ha ingresado el id';}break;
			case 'idTrabajador':   if(empty($idTrabajador)){  $error['idTrabajador']   = 'error/No ha seleccionado el trabajador';}break;
			case 'idBonoFijo':     if(empty($idBonoFijo)){    $error['idBonoFijo']     = 'error/No ha seleccionado el bono';}break;
			case 'Monto':          if(empty($Monto)){         $error['Monto']          = 'error/No ha ingresado el monto';}break;

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
			if(isset($idBonoFijo)&&isset($idTrabajador)){
				$ndata_1 = db_select_nrows (false, 'idBonoFijo', 'trabajadores_listado_bonos_fijos', '', "idBonoFijo='".$idBonoFijo."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Bono ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idTrabajador) && $idTrabajador!=''){  $SIS_data  = "'".$idTrabajador."'";   }else{$SIS_data  = "''";}
				if(isset($idBonoFijo) && $idBonoFijo!=''){      $SIS_data .= ",'".$idBonoFijo."'";    }else{$SIS_data .= ",''";}
				if(isset($Monto) && $Monto!=''){                $SIS_data .= ",'".$Monto."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTrabajador, idBonoFijo, Monto';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_listado_bonos_fijos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($idBonoFijo)&&isset($idTrabajador)&&isset($idBono)){
				$ndata_1 = db_select_nrows (false, 'idBonoFijo', 'trabajadores_listado_bonos_fijos', '', "idBonoFijo='".$idBonoFijo."' AND idTrabajador='".$idTrabajador."' AND idBono!='".$idBono."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Bono ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idBono='".$idBono."'";
				if(isset($idTrabajador) && $idTrabajador!=''){    $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
				if(isset($idBonoFijo) && $idBonoFijo!=''){        $SIS_data .= ",idBonoFijo='".$idBonoFijo."'";}
				if(isset($Monto) && $Monto!=''){                  $SIS_data .= ",Monto='".$Monto."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado_bonos_fijos', 'idBono = "'.$idBono.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'trabajadores_listado_bonos_fijos', 'idBono = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
