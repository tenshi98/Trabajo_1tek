<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-156).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idVarMatriz']))    $idVarMatriz      = $_POST['idVarMatriz'];
	if (!empty($_POST['idCategoria']))    $idCategoria      = $_POST['idCategoria'];
	if (!empty($_POST['idMatriz']))       $idMatriz         = $_POST['idMatriz'];
	if (!empty($_POST['idProceso']))      $idProceso        = $_POST['idProceso'];
	if (!empty($_POST['idSistema']))      $idSistema        = $_POST['idSistema'];

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
			case 'idVarMatriz':    if(empty($idVarMatriz)){  $error['idVarMatriz']   = 'error/No ha ingresado el id';}break;
			case 'idCategoria':    if(empty($idCategoria)){  $error['idCategoria']   = 'error/No ha seleccionado la categoria';}break;
			case 'idMatriz':       if(empty($idMatriz)){     $error['idMatriz']      = 'error/No ha seleccionado el tipo';}break;
			case 'idProceso':      if(empty($idProceso)){    $error['idProceso']     = 'error/No ha seleccionado el proceso';}break;
			case 'idSistema':      if(empty($idSistema)){    $error['idSistema']     = 'error/No ha seleccionado el sistema';}break;

		}
	}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert_matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCategoria)&&isset($idProceso)&&isset($idMatriz)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'idVarMatriz', 'sistema_variedades_categorias_matriz_calidad', '', "idCategoria='".$idCategoria."' AND idMatriz='".$idMatriz."' AND idProceso='".$idProceso."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La matriz ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idCategoria) && $idCategoria!=''){  $SIS_data  = "'".$idCategoria."'"; }else{$SIS_data  = "''";}
				if(isset($idMatriz) && $idMatriz!=''){        $SIS_data .= ",'".$idMatriz."'";   }else{$SIS_data .= ",''";}
				if(isset($idProceso) && $idProceso!=''){      $SIS_data .= ",'".$idProceso."'";  }else{$SIS_data .= ",''";}
				if(isset($idSistema) && $idSistema!=''){      $SIS_data .= ",'".$idSistema."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCategoria, idMatriz, idProceso, idSistema';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_variedades_categorias_matriz_calidad', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCategoria)&&isset($idProceso)&&isset($idMatriz)&&isset($idSistema)&&isset($idVarMatriz)){
				$ndata_1 = db_select_nrows (false, 'idVarMatriz', 'sistema_variedades_categorias_matriz_calidad', '', "idCategoria='".$idCategoria."' AND idMatriz='".$idMatriz."' AND idProceso='".$idProceso."' AND idSistema='".$idSistema."' AND idVarMatriz!='".$idVarMatriz."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La matriz ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idVarMatriz='".$idVarMatriz."'";
				if(isset($idCategoria) && $idCategoria!=''){   $SIS_data .= ",idCategoria='".$idCategoria."'";}
				if(isset($idMatriz) && $idMatriz!=''){         $SIS_data .= ",idMatriz='".$idMatriz."'";}
				if(isset($idProceso) && $idProceso!=''){       $SIS_data .= ",idProceso='".$idProceso."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_variedades_categorias_matriz_calidad', 'idVarMatriz = "'.$idVarMatriz.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_matriz':

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
				$resultado = db_delete_data (false, 'sistema_variedades_categorias_matriz_calidad', 'idVarMatriz = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
