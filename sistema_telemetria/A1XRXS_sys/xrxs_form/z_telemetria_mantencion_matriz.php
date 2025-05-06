<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-281).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Formulario para maquinas
	if (!empty($_POST['idMatriz']))             $idMatriz              = $_POST['idMatriz'];
	if (!empty($_POST['idSistema']))            $idSistema             = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))             $idEstado              = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))               $Nombre                = $_POST['Nombre'];
	if (!empty($_POST['cantPuntos']))           $cantPuntos            = $_POST['cantPuntos'];

	if (!empty($_POST['mod']))                  $mod                   = $_POST['mod'];

	if (!empty($_POST['PuntoNombre']))          $PuntoNombre           = $_POST['PuntoNombre'];
	if (!empty($_POST['SensoresTipo']))         $SensoresTipo          = $_POST['SensoresTipo'];
	if (!empty($_POST['SensoresValor']))        $SensoresValor         = $_POST['SensoresValor'];
	if (!empty($_POST['SensoresNumero']))       $SensoresNumero        = $_POST['SensoresNumero'];

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
			case 'idMatriz':            if(empty($idMatriz)){             $error['idMatriz']              = 'error/No ha ingresado el ID';}break;
			case 'idSistema':           if(empty($idSistema)){            $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':            if(empty($idEstado)){             $error['idEstado']              = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':              if(empty($Nombre)){               $error['Nombre']                = 'error/No ha ingresado el nombre';}break;
			case 'cantPuntos':          if(empty($cantPuntos)){           $error['cantPuntos']            = 'error/No ha ingresado la cantidad de puntos';}break;

			case 'PuntoNombre':         if(empty($PuntoNombre)){          $error['PuntoNombre']           = 'error/No ha ingresado el nombre del punto';}break;
			case 'SensoresTipo':        if(empty($SensoresTipo)){         $error['SensoresTipo']          = 'error/No ha seleccionado el tipo de sensor';}break;
			case 'SensoresValor':       if(empty($SensoresValor)){        $error['SensoresValor']         = 'error/No ha ingresado el valor del sensor';}break;
			case 'SensoresNumero':      if(empty($SensoresNumero)){       $error['SensoresNumero']        = 'error/No ha seleccionado el sensor a revisar';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                $Nombre         = EstandarizarInput($Nombre);}
	if(isset($PuntoNombre) && $PuntoNombre!=''){       $PuntoNombre    = EstandarizarInput($PuntoNombre);}
	if(isset($SensoresValor) && $SensoresValor!=''){   $SensoresValor  = EstandarizarInput($SensoresValor);}
	if(isset($SensoresNumero) && $SensoresNumero!=''){ $SensoresNumero = EstandarizarInput($SensoresNumero);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                  $error['Nombre']         = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($PuntoNombre)&&contar_palabras_censuradas($PuntoNombre)!=0){        $error['PuntoNombre']    = 'error/Edita PuntoNombre,contiene palabras no permitidas';}
	if(isset($SensoresValor)&&contar_palabras_censuradas($SensoresValor)!=0){    $error['SensoresValor']  = 'error/Edita SensoresValor, contiene palabras no permitidas';}
	if(isset($SensoresNumero)&&contar_palabras_censuradas($SensoresNumero)!=0){  $error['SensoresNumero'] = 'error/Edita SensoresNumero, contiene palabras no permitidas';}

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
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_mantencion_matriz', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La matriz ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){      $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}
				if(isset($cantPuntos) && $cantPuntos!=''){    $SIS_data .= ",'".$cantPuntos."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){        $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Nombre,cantPuntos, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_mantencion_matriz', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&idMatriz='.$ultimo_id.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//Filtros
				$SIS_data = "idMatriz='".$idMatriz."'";
				if(isset($idSistema) && $idSistema!=''){             $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){               $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre) && $Nombre!=''){                   $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($cantPuntos) && $cantPuntos!=''){           $SIS_data .= ",cantPuntos='".$cantPuntos."'";}

				if(isset($PuntoNombre) && $PuntoNombre!=''){         $SIS_data .= ",PuntoNombre_".$mod."='".$PuntoNombre."'";}
				if(isset($SensoresTipo) && $SensoresTipo!=''){       $SIS_data .= ",SensoresTipo_".$mod."='".$SensoresTipo."'";}
				if(isset($SensoresValor) && $SensoresValor!=''){     $SIS_data .= ",SensoresValor_".$mod."='".$SensoresValor."'";}
				if(isset($SensoresNumero) && $SensoresNumero!=''){   $SIS_data .= ",SensoresNumero_".$mod."='".$SensoresNumero."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_mantencion_matriz', 'idMatriz = "'.$idMatriz.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location );
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
				$resultado = db_delete_data (false, 'telemetria_mantencion_matriz', 'idMatriz = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'clone_Matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_mantencion_matriz', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la matriz ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//bucle
				$SIS_query = '
				telemetria_mantencion_matriz.idSistema,
				telemetria_mantencion_matriz.idEstado,
				telemetria_mantencion_matriz.cantPuntos';
				for ($i = 1; $i <= 72; $i++) {
					$SIS_query .= ',telemetria_mantencion_matriz.PuntoNombre_'.$i;
					$SIS_query .= ',telemetria_mantencion_matriz.SensoresTipo_'.$i;
					$SIS_query .= ',telemetria_mantencion_matriz.SensoresValor_'.$i;
					$SIS_query .= ',telemetria_mantencion_matriz.SensoresNumero_'.$i;

				}

				/*******************************************************************/
				// Se traen todos los datos de la maquina
				$rowData = db_select_data (false, $SIS_query, 'telemetria_mantencion_matriz', '', 'idMatriz = '.$idMatriz, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				//filtros
				if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){     $SIS_data  = "'".$rowData['idSistema']."'";     }else{$SIS_data  = "''";}
				if(isset($rowData['idEstado']) && $rowData['idEstado']!=''){       $SIS_data .= ",'".$rowData['idEstado']."'";     }else{$SIS_data .= ",''";}
				if(isset($rowData['cantPuntos']) && $rowData['cantPuntos']!=''){   $SIS_data .= ",'".$rowData['cantPuntos']."'";   }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                 $SIS_data .= ",'".$Nombre."'";                  }else{$SIS_data .= ",''";}

				for ($i = 1; $i <= 72; $i++) {
					if(isset($rowData['PuntoNombre_'.$i]) && $rowData['PuntoNombre_'.$i]!=''){        $SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";     }else{$SIS_data .= ",''";}
					if(isset($rowData['SensoresTipo_'.$i]) && $rowData['SensoresTipo_'.$i]!=''){      $SIS_data .= ",'".$rowData['SensoresTipo_'.$i]."'";    }else{$SIS_data .= ",''";}
					if(isset($rowData['SensoresValor_'.$i]) && $rowData['SensoresValor_'.$i]!=''){    $SIS_data .= ",'".$rowData['SensoresValor_'.$i]."'";   }else{$SIS_data .= ",''";}
					if(isset($rowData['SensoresNumero_'.$i]) && $rowData['SensoresNumero_'.$i]!=''){  $SIS_data .= ",'".$rowData['SensoresNumero_'.$i]."'";  }else{$SIS_data .= ",''";}

				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idEstado,cantPuntos,Nombre '.$qry;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_mantencion_matriz', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.$ultimo_id.'&clone=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
	}

?>
