<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-054).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['id_pmcat']))  $id_pmcat   = $_POST['id_pmcat'];
	if (!empty($_POST['Nombre']))    $Nombre     = $_POST['Nombre'];
	if (!empty($_POST['idFont']))    $idFont     = $_POST['idFont'];
	if (!empty($_POST['IconColor'])) $IconColor  = $_POST['IconColor'];

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
			case 'id_pmcat':     if(empty($id_pmcat)){     $error['id_pmcat']     = 'error/No ha ingresado el id';}break;
			case 'Nombre':       if(empty($Nombre)){       $error['Nombre']       = 'error/No ha ingresado el Nombre';}break;
			case 'idFont':       if(empty($idFont)){       $error['idFont']       = 'error/No ha seleccionado el icono';}break;
			case 'IconColor':    if(empty($IconColor)){    $error['IconColor']    = 'error/No ha seleccionado el color del icono';}break;
		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){$Nombre  = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}

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
			if(isset($Nombre, $idFont)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'core_permisos_categorias', '', "Nombre='".$Nombre."' AND idFont='".$idFont."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Categoria de permiso ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){        $SIS_data  = "'".$Nombre."'";       }else{$SIS_data  = "''";}
				if(isset($idFont) && $idFont!=''){        $SIS_data .= ",'".$idFont."'";      }else{$SIS_data .= ",''";}
				if(isset($IconColor) && $IconColor!=''){  $SIS_data .= ",'".$IconColor."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,idFont, IconColor';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_permisos_categorias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre, $id_pmcat, $idFont)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'core_permisos_categorias', '', "Nombre='".$Nombre."' AND idFont='".$idFont."' AND id_pmcat!='".$id_pmcat."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Categoria de permiso ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "id_pmcat='".$id_pmcat."'";
				if(isset($Nombre) && $Nombre!=''){         $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($idFont) && $idFont!=''){         $SIS_data .= ",idFont='".$idFont."'";}
				if(isset($IconColor) && $IconColor!=''){   $SIS_data .= ",IconColor='".$IconColor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'core_permisos_categorias', 'id_pmcat = "'.$id_pmcat.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'core_permisos_categorias', 'id_pmcat = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Traigo un listado con todas las transacciones de la categoria
					$SIS_query = 'idAdmpm';
					$SIS_join  = '';
					$SIS_where = 'id_pmcat = '.$indice;
					$SIS_order = 0;
					$arrPermisos = array();
					$arrPermisos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//elimino los datos
					foreach ($arrPermisos as $perm) {

						//borro la transaccion
						$resultado = db_delete_data (false, 'core_permisos_listado', 'idAdmpm = "'.$perm['idAdmpm'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//elimino los permisos relacionados a los usuarios
						$resultado = db_delete_data (false, 'usuarios_permisos', 'idAdmpm = "'.$perm['idAdmpm'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					}

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
