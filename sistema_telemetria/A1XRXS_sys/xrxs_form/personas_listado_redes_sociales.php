<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-094).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idRedes']))         $idRedes         = $_POST['idRedes'];
	if (!empty($_POST['idPersona']))       $idPersona       = $_POST['idPersona'];
	if (!empty($_POST['URL']))             $URL             = $_POST['URL'];
	if (!empty($_POST['Comentario']))      $Comentario      = $_POST['Comentario'];

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
			case 'idRedes':         if(empty($idRedes)){       $error['idRedes']       = 'error/No ha ingresado el id';}break;
			case 'idPersona':       if(empty($idPersona)){     $error['idPersona']     = 'error/No ha seleccionado la persona relacionada';}break;
			case 'URL':             if(empty($URL)){           $error['URL']           = 'error/No ha ingresado el URL';}break;
			case 'Comentario':      if(empty($Comentario)){    $error['Comentario']    = 'error/No ha ingresado el Comentario';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Comentario) && $Comentario!=''){      $Comentario   = EstandarizarInput($Comentario);}
	if(isset($URL) && $URL!=''){                    $URL          = EstandarizarInput($URL);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($Comentario)&&contar_palabras_censuradas($Comentario)!=0){  $error['Comentario']   = 'error/Edita Comentario, contiene palabras no permitidas';}
	if(isset($URL)&&contar_palabras_censuradas($URL)!=0){                $error['URL']          = 'error/Edita URL, contiene palabras no permitidas';}

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
			if(isset($URL)&&isset($idPersona)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'personas_listado_redes_sociales', '', "URL='".$URL."' AND idPersona='".$idPersona."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El URL que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idPersona) && $idPersona!=''){    $SIS_data  = "'".$idPersona."'";    }else{$SIS_data  = "''";}
				if(isset($URL) && $URL!=''){                $SIS_data .= ",'".$URL."'";         }else{$SIS_data .= ",''";}
				if(isset($Comentario) && $Comentario!=''){  $SIS_data .= ",'".$Comentario."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idPersona, URL,Comentario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'personas_listado_redes_sociales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($URL)&&isset($idPersona)&&isset($idRedes)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'personas_listado_redes_sociales', '', "URL='".$URL."' AND idPersona='".$idPersona."' AND idRedes!='".$idRedes."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El URL que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idRedes='".$idRedes."'";
				if(isset($idPersona) && $idPersona!=''){     $SIS_data .= ",idPersona='".$idPersona."'";}
				if(isset($URL) && $URL!=''){                 $SIS_data .= ",URL='".$URL."'";}
				if(isset($Comentario) && $Comentario!=''){   $SIS_data .= ",Comentario='".$Comentario."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'personas_listado_redes_sociales', 'idRedes = "'.$idRedes.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'personas_listado_redes_sociales', 'idRedes = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
