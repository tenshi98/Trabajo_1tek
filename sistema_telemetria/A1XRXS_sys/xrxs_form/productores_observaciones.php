<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-101).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idObservacion']))  $idObservacion   = $_POST['idObservacion'];
	if (!empty($_POST['idProductor']))    $idProductor     = $_POST['idProductor'];
	if (!empty($_POST['idUsuario']))      $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))          $Fecha           = $_POST['Fecha'];
	if (!empty($_POST['Observacion']))    $Observacion     = $_POST['Observacion'];

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
			case 'idObservacion':  if(empty($idObservacion)){   $error['idObservacion']  = 'error/No ha ingresado el id';}break;
			case 'idProductor':    if(empty($idProductor)){     $error['idProductor']    = 'error/No ha seleccionado el cliente';}break;
			case 'idUsuario':      if(empty($idUsuario)){       $error['idUsuario']      = 'error/No ha seleccionado un usuario';}break;
			case 'Fecha':          if(empty($Fecha)){           $error['Fecha']          = 'error/No ha ingresado la fecha';}break;
			case 'Observacion':    if(empty($Observacion)){     $error['Observacion']    = 'error/No ha ingresado la observacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observacion) && $Observacion!=''){ $Observacion = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){  $error['Observacion'] = 'error/Edita la Observacion, contiene palabras no permitidas';}

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
				if(isset($idProductor) && $idProductor!=''){     $SIS_data  = "'".$idProductor."'";      }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",'".$idUsuario."'";       }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                 $SIS_data .= ",'".$Fecha."'";           }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){     $SIS_data .= ",'".$Observacion."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idProductor, idUsuario, Fecha, Observacion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'productores_observaciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$SIS_data = "idObservacion='".$idObservacion."'";
				if(isset($idProductor) && $idProductor!=''){   $SIS_data .= ",idProductor='".$idProductor."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Fecha) && $Fecha!=''){               $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($Observacion) && $Observacion!=''){   $SIS_data .= ",Observacion='".$Observacion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'productores_observaciones', 'idObservacion = "'.$idObservacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'productores_observaciones', 'idObservacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
