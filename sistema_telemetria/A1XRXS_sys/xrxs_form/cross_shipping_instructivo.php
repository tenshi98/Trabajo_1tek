<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-069).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idInstructivo']))     $idInstructivo     = $_POST['idInstructivo'];
	if (!empty($_POST['idSistema']))         $idSistema         = $_POST['idSistema'];
	if (!empty($_POST['Nombre']))            $Nombre            = $_POST['Nombre'];
	if (!empty($_POST['Codigo']))            $Codigo            = $_POST['Codigo'];

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
			case 'idInstructivo':   if(empty($idInstructivo)){    $error['idInstructivo']     = 'error/No ha ingresado el id';}break;
			case 'idSistema':       if(empty($idSistema)){        $error['idSistema']         = 'error/No ha seleccionado el sistema';}break;
			case 'Nombre':          if(empty($Nombre)){           $error['Nombre']            = 'error/No ha ingresado el nombre';}break;
			case 'Codigo':          if(empty($Codigo)){           $error['Codigo']            = 'error/No ha ingresado el Codigo';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){ $Nombre = EstandarizarInput($Nombre);}
	if(isset($Codigo) && $Codigo!=''){ $Codigo = EstandarizarInput($Codigo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Codigo)&&contar_palabras_censuradas($Codigo)!=0){  $error['Codigo'] = 'error/Edita Codigo, contiene palabras no permitidas';}

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
			if(isset($Nombre)&&isset($Codigo)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_shipping_instructivo', '', "Nombre='".$Nombre."' AND Codigo='".$Codigo."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){        $SIS_data  = "'".$Nombre."'";     }else{$SIS_data  = "''";}
				if(isset($Codigo) && $Codigo!=''){        $SIS_data .= ",'".$Codigo."'";    }else{$SIS_data .= ",''";}
				if(isset($idSistema) && $idSistema!=''){  $SIS_data .= ",'".$idSistema."'"; }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,Codigo, idSistema';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_shipping_instructivo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($Codigo)&&isset($idSistema)&&isset($idInstructivo)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_shipping_instructivo', '', "Nombre='".$Nombre."' AND Codigo='".$Codigo."' AND idSistema='".$idSistema."' AND idInstructivo!='".$idInstructivo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idInstructivo='".$idInstructivo."'";
				if(isset($Nombre) && $Nombre!=''){        $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Codigo) && $Codigo!=''){        $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($idSistema) && $idSistema!=''){  $SIS_data .= ",idSistema='".$idSistema."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_instructivo', 'idInstructivo = "'.$idInstructivo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'cross_shipping_instructivo', 'idInstructivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
