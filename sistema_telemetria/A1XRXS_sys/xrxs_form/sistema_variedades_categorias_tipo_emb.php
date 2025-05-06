<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-158).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idEmbalaje']))     $idEmbalaje       = $_POST['idEmbalaje'];
	if (!empty($_POST['idCategoria']))    $idCategoria      = $_POST['idCategoria'];
	if (!empty($_POST['idTipo']))         $idTipo           = $_POST['idTipo'];
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
			case 'idEmbalaje':     if(empty($idEmbalaje)){   $error['idEmbalaje']    = 'error/No ha ingresado el id';}break;
			case 'idCategoria':    if(empty($idCategoria)){  $error['idCategoria']   = 'error/No ha seleccionado la categoria';}break;
			case 'idTipo':         if(empty($idTipo)){       $error['idTipo']        = 'error/No ha seleccionado el tipo';}break;
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
		case 'insert_embalaje':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCategoria)&&isset($idProceso)&&isset($idTipo)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'idEmbalaje', 'sistema_variedades_categorias_tipo_emb', '', "idCategoria='".$idCategoria."' AND idTipo='".$idTipo."' AND idProceso='".$idProceso."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El embalaje ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idCategoria) && $idCategoria!=''){  $SIS_data  = "'".$idCategoria."'"; }else{$SIS_data  = "''";}
				if(isset($idTipo) && $idTipo!=''){            $SIS_data .= ",'".$idTipo."'";     }else{$SIS_data .= ",''";}
				if(isset($idProceso) && $idProceso!=''){      $SIS_data .= ",'".$idProceso."'";  }else{$SIS_data .= ",''";}
				if(isset($idSistema) && $idSistema!=''){      $SIS_data .= ",'".$idSistema."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCategoria, idTipo, idProceso, idSistema';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_variedades_categorias_tipo_emb', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_embalaje':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCategoria)&&isset($idProceso)&&isset($idTipo)&&isset($idSistema)&&isset($idEmbalaje)){
				$ndata_1 = db_select_nrows (false, 'idEmbalaje', 'sistema_variedades_categorias_tipo_emb', '', "idCategoria='".$idCategoria."' AND idTipo='".$idTipo."' AND idProceso='".$idProceso."' AND idSistema='".$idSistema."' AND idEmbalaje!='".$idEmbalaje."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El embalaje ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEmbalaje='".$idEmbalaje."'";
				if(isset($idCategoria) && $idCategoria!=''){   $SIS_data .= ",idCategoria='".$idCategoria."'";}
				if(isset($idTipo) && $idTipo!=''){             $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($idProceso) && $idProceso!=''){       $SIS_data .= ",idProceso='".$idProceso."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_variedades_categorias_tipo_emb', 'idEmbalaje = "'.$idEmbalaje.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_embalaje':

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
				$resultado = db_delete_data (false, 'sistema_variedades_categorias_tipo_emb', 'idEmbalaje = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
