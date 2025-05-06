<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-214).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idRutaAlt']))     $idRutaAlt     = $_POST['idRutaAlt'];
	if (!empty($_POST['idRuta']))        $idRuta        = $_POST['idRuta'];
	if (!empty($_POST['idSistema']))     $idSistema     = $_POST['idSistema'];
	if (!empty($_POST['idTipo']))        $idTipo        = $_POST['idTipo'];
	if (!empty($_POST['Fecha']))         $Fecha         = $_POST['Fecha'];
	if (!empty($_POST['idDia']))         $idDia         = $_POST['idDia'];
	if (!empty($_POST['HoraInicio']))    $HoraInicio    = $_POST['HoraInicio'];
	if (!empty($_POST['HoraTermino']))   $HoraTermino   = $_POST['HoraTermino'];
	if (!empty($_POST['Nombre']))        $Nombre        = $_POST['Nombre'];

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
			case 'idRutaAlt':    if(empty($idRutaAlt)){    $error['idRutaAlt']     = 'error/No ha ingresado el id';}break;
			case 'idRuta':       if(empty($idRuta)){       $error['idRuta']        = 'error/No ha seleccionado el sistema';}break;
			case 'idSistema':    if(empty($idSistema)){    $error['idSistema']     = 'error/No ha ingresado el nombre';}break;
			case 'idTipo':       if(empty($idTipo)){       $error['idTipo']        = 'error/No ha ingresado el id';}break;
			case 'Fecha':        if(empty($Fecha)){        $error['Fecha']         = 'error/No ha seleccionado el sistema';}break;
			case 'idDia':        if(empty($idDia)){        $error['idDia']         = 'error/No ha ingresado el nombre';}break;
			case 'HoraInicio':   if(empty($HoraInicio)){   $error['HoraInicio']    = 'error/No ha ingresado el id';}break;
			case 'HoraTermino':  if(empty($HoraTermino)){  $error['HoraTermino']   = 'error/No ha seleccionado el sistema';}break;
			case 'Nombre':       if(empty($Nombre)){       $error['Nombre']        = 'error/No ha ingresado el nombre';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){$Nombre = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}

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
			if(isset($Nombre)&&isset($idSistema)&&isset($idRuta)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'vehiculos_ruta_alternativa', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idRuta='".$idRuta."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idRuta) && $idRuta!=''){              $SIS_data  = "'".$idRuta."'";         }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){        $SIS_data .= ",'".$idSistema."'";     }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){              $SIS_data .= ",'".$idTipo."'";        }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                $SIS_data .= ",'".$Fecha."'";         }else{$SIS_data .= ",''";}
				if(isset($idDia) && $idDia!=''){                $SIS_data .= ",'".$idDia."'";         }else{$SIS_data .= ",''";}
				if(isset($HoraInicio) && $HoraInicio!=''){      $SIS_data .= ",'".$HoraInicio."'";    }else{$SIS_data .= ",''";}
				if(isset($HoraTermino) && $HoraTermino!=''){    $SIS_data .= ",'".$HoraTermino."'";   }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){              $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idRuta, idSistema, idTipo, Fecha, idDia, HoraInicio, HoraTermino, Nombre';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_ruta_alternativa', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
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
			if(isset($Nombre)&&isset($idSistema)&&isset($idRuta)&&isset($idRutaAlt)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'vehiculos_ruta_alternativa', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idRuta='".$idRuta."' AND idRutaAlt!='".$idRutaAlt."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idRutaAlt='".$idRutaAlt."'";
				if(isset($idRuta) && $idRuta!=''){              $SIS_data .= ",idRuta='".$idRuta."'";}
				if(isset($idSistema) && $idSistema!=''){        $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idTipo) && $idTipo!=''){              $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($Fecha) && $Fecha!=''){                $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($idDia) && $idDia!=''){                $SIS_data .= ",idDia='".$idDia."'";}
				if(isset($HoraInicio) && $HoraInicio!=''){      $SIS_data .= ",HoraInicio='".$HoraInicio."'";}
				if(isset($HoraTermino) && $HoraTermino!=''){    $SIS_data .= ",HoraTermino='".$HoraTermino."'";}
				if(isset($Nombre) && $Nombre!=''){              $SIS_data .= ",Nombre='".$Nombre."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'vehiculos_ruta_alternativa', 'idRutaAlt = "'.$idRutaAlt.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado_1 = db_delete_data (false, 'vehiculos_ruta_alternativa', 'idRutaAlt = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'vehiculos_ruta_alternativa_ubicaciones', 'idRutaAlt = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true){

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
