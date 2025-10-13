<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-239).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	if (!empty($_POST['idMatriz']))             $idMatriz              = $_POST['idMatriz'];
	if (!empty($_POST['idSistema']))            $idSistema             = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))             $idEstado              = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))               $Nombre                = $_POST['Nombre'];
	if (!empty($_POST['cantPuntos']))           $cantPuntos            = $_POST['cantPuntos'];
	if (!empty($_POST['idTipo']))               $idTipo                = $_POST['idTipo'];
	if (!empty($_POST['mod']))                  $mod                   = $_POST['mod'];
	if (!empty($_POST['PuntoNombre']))          $PuntoNombre           = $_POST['PuntoNombre'];
	if (!empty($_POST['PuntoidTipo']))          $PuntoidTipo           = $_POST['PuntoidTipo'];
	if (!empty($_POST['PuntoMedAceptable']))    $PuntoMedAceptable     = $_POST['PuntoMedAceptable'];
	if (!empty($_POST['PuntoMedAlerta']))       $PuntoMedAlerta        = $_POST['PuntoMedAlerta'];
	if (!empty($_POST['PuntoMedCondenatorio'])) $PuntoMedCondenatorio  = $_POST['PuntoMedCondenatorio'];
	if (!empty($_POST['PuntoUniMed']))          $PuntoUniMed           = $_POST['PuntoUniMed'];
	if (!empty($_POST['PuntoidGrupo']))         $PuntoidGrupo          = $_POST['PuntoidGrupo'];
	if (!empty($_POST['idNota_1']))             $idNota_1              = $_POST['idNota_1'];
	if (!empty($_POST['idNota_2']))             $idNota_2              = $_POST['idNota_2'];
	if (!empty($_POST['idNota_3']))             $idNota_3              = $_POST['idNota_3'];
	if (!empty($_POST['idNotaTipo_1']))         $idNotaTipo_1          = $_POST['idNotaTipo_1'];
	if (!empty($_POST['idNotaTipo_2']))         $idNotaTipo_2          = $_POST['idNotaTipo_2'];
	if (!empty($_POST['idNotaTipo_3']))         $idNotaTipo_3          = $_POST['idNotaTipo_3'];
	if (!empty($_POST['Validar']))              $Validar               = $_POST['Validar'];
	if (!empty($_POST['Validar_1']))            $Validar_1             = $_POST['Validar_1'];
	if (!empty($_POST['Validar_2']))            $Validar_2             = $_POST['Validar_2'];
	if (!empty($_POST['Validar_3']))            $Validar_3             = $_POST['Validar_3'];

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
			case 'idMatriz':            if(empty($idMatriz)){             $error['idMatriz']              = 'error/No ha ingresado el id';}break;
			case 'idSistema':           if(empty($idSistema)){            $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':            if(empty($idEstado)){             $error['idEstado']              = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':              if(empty($Nombre)){               $error['Nombre']                = 'error/No ha ingresado el nombre';}break;
			case 'cantPuntos':          if(empty($cantPuntos)){           $error['cantPuntos']            = 'error/No ha ingresado la cantidad de puntos';}break;
			case 'idTipo':              if(empty($idTipo)){               $error['idTipo']                = 'error/No ha seleccionado de tipo de planilla';}break;
			case 'mod':                 if(empty($mod)){                  $error['mod']                   = 'error/No ha ingresado el mod';}break;
			case 'PuntoNombre':         if(empty($PuntoNombre)){          $error['PuntoNombre']           = 'error/No ha ingresado el nombre del punto';}break;
			case 'PuntoidTipo':         if(empty($PuntoidTipo)){          $error['PuntoidTipo']           = 'error/No ha seleccionado el tipo de punto';}break;
			case 'PuntoMedAceptable':   if(empty($PuntoMedAceptable)){    $error['PuntoMedAceptable']     = 'error/No ha ingresado el valor aceptable';}break;
			case 'PuntoMedAlerta':      if(empty($PuntoMedAlerta)){       $error['PuntoMedAlerta']        = 'error/No ha ingresado el valor de alerta';}break;
			case 'PuntoMedCondenatorio':if(empty($PuntoMedCondenatorio)){ $error['PuntoMedCondenatorio']  = 'error/No ha ingresado el valor condenatorio';}break;
			case 'PuntoUniMed':         if(empty($PuntoUniMed)){          $error['PuntoUniMed']           = 'error/No ha seleccionado la unidad de medida';}break;
			case 'PuntoidGrupo':        if(empty($PuntoidGrupo)){         $error['PuntoidGrupo']          = 'error/No ha seleccionado el grupo';}break;
			case 'idNota_1':            if(empty($idNota_1)){             $error['idNota_1']              = 'error/No ha seleccionado la Nota Calidad';}break;
			case 'idNota_2':            if(empty($idNota_2)){             $error['idNota_2']              = 'error/No ha seleccionado la Nota Condición';}break;
			case 'idNota_3':            if(empty($idNota_3)){             $error['idNota_3']              = 'error/No ha seleccionado la Calificacion';}break;
			case 'idNotaTipo_1':        if(empty($idNotaTipo_1)){         $error['idNotaTipo_1']          = 'error/No ha seleccionado el tipo de Nota Calidad';}break;
			case 'idNotaTipo_2':        if(empty($idNotaTipo_2)){         $error['idNotaTipo_2']          = 'error/No ha seleccionado el tipo de Nota Condición';}break;
			case 'idNotaTipo_3':        if(empty($idNotaTipo_3)){         $error['idNotaTipo_3']          = 'error/No ha seleccionado el tipo de Calificacion';}break;
			case 'Validar':             if(empty($Validar)){              $error['Validar']               = 'error/No ha ingresado los datos para validar';}break;
			case 'Validar_1':           if(empty($Validar_1)){            $error['Validar_1']             = 'error/No ha ingresado los datos para validar de Nota Calidad';}break;
			case 'Validar_2':           if(empty($Validar_2)){            $error['Validar_2']             = 'error/No ha ingresado los datos para validar de Nota Condición';}break;
			case 'Validar_3':           if(empty($Validar_3)){            $error['Validar_3']             = 'error/No ha ingresado los datos para validar de Calificacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){           $Nombre      = EstandarizarInput($Nombre);}
	if(isset($PuntoNombre) && $PuntoNombre!=''){ $PuntoNombre = EstandarizarInput($PuntoNombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){            $error['Nombre']      = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($PuntoNombre)&&contar_palabras_censuradas($PuntoNombre)!=0){  $error['PuntoNombre'] = 'error/Edita Punto Nombre,contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {

		case 'insert_matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idTipo)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_quality_calidad_matriz', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idTipo='".$idTipo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Tipo de Planilla ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){             $SIS_data  = "'".$Nombre."'";         }else{$SIS_data  = "''";}
				if(isset($cantPuntos) && $cantPuntos!=''){     $SIS_data .= ",'".$cantPuntos."'";    }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){             $SIS_data .= ",'".$idTipo."'";        }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .= ",''";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",'".$idSistema."'";     }else{$SIS_data .= ",''";}
				if(isset($idNota_1) && $idNota_1!=''){         $SIS_data .= ",'".$idNota_1."'";      }else{$SIS_data .= ",''";}
				if(isset($idNota_2) && $idNota_2!=''){         $SIS_data .= ",'".$idNota_2."'";      }else{$SIS_data .= ",''";}
				if(isset($idNota_3) && $idNota_3!=''){         $SIS_data .= ",'".$idNota_3."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,cantPuntos, idTipo, idEstado, idSistema, idNota_1, idNota_2, idNota_3';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_calidad_matriz', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idTipo)&&isset($idMatriz)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_quality_calidad_matriz', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idTipo='".$idTipo."' AND idMatriz!='".$idMatriz."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Tipo de Planilla ya existe en el sistema';}
			/*******************************************************************/

			if(empty($error)){

				//Filtros
				$SIS_data = "idMatriz='".$idMatriz."'";
				if(isset($Nombre) && $Nombre!=''){                              $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($cantPuntos) && $cantPuntos!=''){                      $SIS_data .= ",cantPuntos='".$cantPuntos."'";}
				if(isset($idTipo) && $idTipo!=''){                              $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($PuntoNombre) && $PuntoNombre!=''){                    $SIS_data .= ",PuntoNombre_".$mod."='".$PuntoNombre."'";}
				if(isset($PuntoidTipo) && $PuntoidTipo!=''){                    $SIS_data .= ",PuntoidTipo_".$mod."='".$PuntoidTipo."'";}
				if(isset($PuntoMedAceptable) && $PuntoMedAceptable!=''){        $SIS_data .= ",PuntoMedAceptable_".$mod."='".$PuntoMedAceptable."'";}
				if(isset($PuntoMedAlerta) && $PuntoMedAlerta!=''){              $SIS_data .= ",PuntoMedAlerta_".$mod."='".$PuntoMedAlerta."'";}
				if(isset($PuntoMedCondenatorio) && $PuntoMedCondenatorio!=''){  $SIS_data .= ",PuntoMedCondenatorio_".$mod."='".$PuntoMedCondenatorio."'";}
				if(isset($PuntoUniMed) && $PuntoUniMed!=''){                    $SIS_data .= ",PuntoUniMed_".$mod."='".$PuntoUniMed."'";}
				if(isset($PuntoidGrupo) && $PuntoidGrupo!=''){                  $SIS_data .= ",PuntoidGrupo_".$mod."='".$PuntoidGrupo."'";}
				if(isset($idEstado) && $idEstado!=''){                          $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idNota_1) && $idNota_1!=''){                          $SIS_data .= ",idNota_1='".$idNota_1."'";}
				if(isset($idNota_2) && $idNota_2!=''){                          $SIS_data .= ",idNota_2='".$idNota_2."'";}
				if(isset($idNota_3) && $idNota_3!=''){                          $SIS_data .= ",idNota_3='".$idNota_3."'";}
				if(isset($idNotaTipo_1) && $idNotaTipo_1!=''){                  $SIS_data .= ",idNotaTipo_1='".$idNotaTipo_1."'";}
				if(isset($idNotaTipo_2) && $idNotaTipo_2!=''){                  $SIS_data .= ",idNotaTipo_2='".$idNotaTipo_2."'";}
				if(isset($idNotaTipo_3) && $idNotaTipo_3!=''){                  $SIS_data .= ",idNotaTipo_3='".$idNotaTipo_3."'";}
				if(isset($idSistema) && $idSistema!=''){                        $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Validar) && $Validar!=''){                            $SIS_data .= ",Validacion_".$mod."='".$Validar."'";}
				if(isset($Validar_1) && $Validar_1!=''){                        $SIS_data .= ",Validar_1='".$Validar_1."'";}
				if(isset($Validar_2) && $Validar_2!=''){                        $SIS_data .= ",Validar_2='".$Validar_2."'";}
				if(isset($Validar_3) && $Validar_3!=''){                        $SIS_data .= ",Validar_3='".$Validar_3."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_quality_calidad_matriz', 'idMatriz = "'.$idMatriz.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'cross_quality_calidad_matriz', 'idMatriz = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_quality_calidad_matriz', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Tipo de Planilla ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//bucle
				$qry = '';
				for ($i = 1; $i <= 100; $i++) {
					$qry .= ',PuntoNombre_'.$i;
					$qry .= ',PuntoMedAceptable_'.$i;
					$qry .= ',PuntoMedAlerta_'.$i;
					$qry .= ',PuntoMedCondenatorio_'.$i;
					$qry .= ',PuntoUniMed_'.$i;
					$qry .= ',PuntoidTipo_'.$i;
					$qry .= ',PuntoidGrupo_'.$i;
					$qry .= ',Validacion_'.$i;
				}

				/*******************************************************************/
				// Se traen todos los datos de la maquina
				$rowData = db_select_data (false, 'cantPuntos, idEstado, idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3, idTipo, idSistema'.$qry, 'cross_quality_calidad_matriz', '', 'idMatriz = "'.$idMatriz.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);


				/*******************************************************************/
				//filtros
				if(isset($rowData['cantPuntos']) && $rowData['cantPuntos']!=''){       $SIS_data  = "'".$rowData['cantPuntos']."'";      }else{$SIS_data  = "''";}
				if(isset($rowData['idTipo']) && $rowData['idTipo']!=''){               $SIS_data .= ",'".$rowData['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){         $SIS_data .= ",'".$rowData['idSistema']."'";      }else{$SIS_data .= ",''";}
				if(isset($rowData['idEstado']) && $rowData['idEstado']!=''){           $SIS_data .= ",'".$rowData['idEstado']."'";       }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                     $SIS_data .= ",'".$Nombre."'";                    }else{$SIS_data .= ",''";}
				if(isset($rowData['idNota_1']) && $rowData['idNota_1']!=''){           $SIS_data .= ",'".$rowData['idNota_1']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowData['idNota_2']) && $rowData['idNota_2']!=''){           $SIS_data .= ",'".$rowData['idNota_2']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowData['idNota_3']) && $rowData['idNota_3']!=''){           $SIS_data .= ",'".$rowData['idNota_3']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowData['idNotaTipo_1']) && $rowData['idNotaTipo_1']!=''){   $SIS_data .= ",'".$rowData['idNotaTipo_1']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idNotaTipo_2']) && $rowData['idNotaTipo_2']!=''){   $SIS_data .= ",'".$rowData['idNotaTipo_2']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idNotaTipo_3']) && $rowData['idNotaTipo_3']!=''){   $SIS_data .= ",'".$rowData['idNotaTipo_3']."'";   }else{$SIS_data .= ",''";}

				for ($i = 1; $i <= 100; $i++) {
					if(isset($rowData['PuntoNombre_'.$i]) && $rowData['PuntoNombre_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedAceptable_'.$i]) && $rowData['PuntoMedAceptable_'.$i]!=''){        $SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";     }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedAlerta_'.$i]) && $rowData['PuntoMedAlerta_'.$i]!=''){              $SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";        }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedCondenatorio_'.$i]) && $rowData['PuntoMedCondenatorio_'.$i]!=''){  $SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";  }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoUniMed_'.$i]) && $rowData['PuntoUniMed_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoUniMed_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoidTipo_'.$i]) && $rowData['PuntoidTipo_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoidTipo_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoidGrupo_'.$i]) && $rowData['PuntoidGrupo_'.$i]!=''){                  $SIS_data .= ",'".$rowData['PuntoidGrupo_'.$i]."'";          }else{$SIS_data .= ",''";}
					if(isset($rowData['Validacion_'.$i]) && $rowData['Validacion_'.$i]!=''){                      $SIS_data .= ",'".$rowData['Validacion_'.$i]."'";            }else{$SIS_data .= ",''";}

				}

				// inserto los datos de registro en la db
				$SIS_columns = 'cantPuntos,idTipo,idSistema, idEstado, Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3 '.$qry;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_calidad_matriz', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&clone=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'clone_Matriz_sis':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_quality_calidad_matriz', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Tipo de Planilla ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//bucle
				$qry = '';
				for ($i = 1; $i <= 100; $i++) {
					$qry .= ',PuntoNombre_'.$i;
					$qry .= ',PuntoMedAceptable_'.$i;
					$qry .= ',PuntoMedAlerta_'.$i;
					$qry .= ',PuntoMedCondenatorio_'.$i;
					$qry .= ',PuntoUniMed_'.$i;
					$qry .= ',PuntoidTipo_'.$i;
					$qry .= ',PuntoidGrupo_'.$i;
					$qry .= ',Validacion_'.$i;
				}

				/*******************************************************************/
				// Se traen todos los datos de la maquina
				$rowData = db_select_data (false, 'cantPuntos, idEstado, idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3, idTipo, idSistema'.$qry, 'cross_quality_calidad_matriz', '', 'idMatriz ='.$idMatriz, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				//filtros
				if(isset($rowData['cantPuntos']) && $rowData['cantPuntos']!=''){       $SIS_data  = "'".$rowData['cantPuntos']."'";      }else{$SIS_data  = "''";}
				if(isset($rowData['idTipo']) && $rowData['idTipo']!=''){               $SIS_data .= ",'".$rowData['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($idSistema) && $idSistema!=''){                               $SIS_data .= ",'".$idSistema."'";                 }else{$SIS_data .= ",''";}
				if(isset($rowData['idEstado']) && $rowData['idEstado']!=''){           $SIS_data .= ",'".$rowData['idEstado']."'";       }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                     $SIS_data .= ",'".$Nombre."'";                    }else{$SIS_data .= ",''";}
				if(isset($rowData['idNota_1']) && $rowData['idNota_1']!=''){           $SIS_data .= ",'".$rowData['idNota_1']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowData['idNota_2']) && $rowData['idNota_2']!=''){           $SIS_data .= ",'".$rowData['idNota_2']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowData['idNota_3']) && $rowData['idNota_3']!=''){           $SIS_data .= ",'".$rowData['idNota_3']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowData['idNotaTipo_1']) && $rowData['idNotaTipo_1']!=''){   $SIS_data .= ",'".$rowData['idNotaTipo_1']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idNotaTipo_2']) && $rowData['idNotaTipo_2']!=''){   $SIS_data .= ",'".$rowData['idNotaTipo_2']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idNotaTipo_3']) && $rowData['idNotaTipo_3']!=''){   $SIS_data .= ",'".$rowData['idNotaTipo_3']."'";   }else{$SIS_data .= ",''";}

				for ($i = 1; $i <= 100; $i++) {
					if(isset($rowData['PuntoNombre_'.$i]) && $rowData['PuntoNombre_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedAceptable_'.$i]) && $rowData['PuntoMedAceptable_'.$i]!=''){        $SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";     }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedAlerta_'.$i]) && $rowData['PuntoMedAlerta_'.$i]!=''){              $SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";        }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedCondenatorio_'.$i]) && $rowData['PuntoMedCondenatorio_'.$i]!=''){  $SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";  }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoUniMed_'.$i]) && $rowData['PuntoUniMed_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoUniMed_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoidTipo_'.$i]) && $rowData['PuntoidTipo_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoidTipo_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoidGrupo_'.$i]) && $rowData['PuntoidGrupo_'.$i]!=''){                  $SIS_data .= ",'".$rowData['PuntoidGrupo_'.$i]."'";          }else{$SIS_data .= ",''";}
					if(isset($rowData['Validacion_'.$i]) && $rowData['Validacion_'.$i]!=''){                      $SIS_data .= ",'".$rowData['Validacion_'.$i]."'";            }else{$SIS_data .= ",''";}

				}

				// inserto los datos de registro en la db
				$SIS_columns = 'cantPuntos,idTipo,idSistema, idEstado, Nombre,idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3 '.$qry;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_calidad_matriz', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&clone=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
