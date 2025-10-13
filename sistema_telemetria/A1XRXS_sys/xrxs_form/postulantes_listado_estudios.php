<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-096).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idEstudioPost']))            $idEstudioPost             = $_POST['idEstudioPost'];
	if (!empty($_POST['idPostulante']))             $idPostulante              = $_POST['idPostulante'];
	if (!empty($_POST['AnoInicio']))                $AnoInicio                 = $_POST['AnoInicio'];
	if (!empty($_POST['AnoTermino']))               $AnoTermino                = $_POST['AnoTermino'];
	if (!empty($_POST['idEstado']))                 $idEstado                  = $_POST['idEstado'];
	if (!empty($_POST['idEstudioCat']))             $idEstudioCat              = $_POST['idEstudioCat'];
	if (!empty($_POST['idEstudio']))                $idEstudio                 = $_POST['idEstudio'];
	if (!empty($_POST['Nombre']))                   $Nombre                    = $_POST['Nombre'];
	if (!empty($_POST['Descripcion']))              $Descripcion               = $_POST['Descripcion'];

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
			case 'idEstudioPost':            if(empty($idEstudioPost)){             $error['idEstudioPost']             = 'error/No ha ingresado el id';}break;
			case 'idPostulante':             if(empty($idPostulante)){              $error['idPostulante']              = 'error/No ha seleccionado el postulante';}break;
			case 'AnoInicio':                if(empty($AnoInicio)){                 $error['AnoInicio']                 = 'error/No ha ingresado el año de inicio';}break;
			case 'AnoTermino':               if(empty($AnoTermino)){                $error['AnoTermino']                = 'error/No ha ingresado el año de termino';}break;
			case 'idEstado':                 if(empty($idEstado)){                  $error['idEstado']                  = 'error/No ha seleccionado el estado';}break;
			case 'idEstudioCat':             if(empty($idEstudioCat)){              $error['idEstudioCat']              = 'error/No ha seleccionado la categoria';}break;
			case 'idEstudio':                if(empty($idEstudio)){                 $error['idEstudio']                 = 'error/No ha seleccionado el estudio';}break;
			case 'Nombre':                   if(empty($Nombre)){                    $error['Nombre']                    = 'error/No ha ingresado el nombre de la casa de estudios';}break;
			case 'Descripcion':              if(empty($Descripcion)){               $error['Descripcion']               = 'error/No ha ingresado la descripcion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){           $Nombre      = EstandarizarInput($Nombre);}
	if(isset($Descripcion) && $Descripcion!=''){ $Descripcion = EstandarizarInput($Descripcion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){            $error['Nombre']      = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){  $error['Descripcion'] = 'error/Edita la Descripcion, contiene palabras no permitidas';}

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
				if(isset($idPostulante) && $idPostulante!=''){        $SIS_data  = "'".$idPostulante."'";      }else{$SIS_data  = "''";}
				if(isset($AnoInicio) && $AnoInicio!=''){              $SIS_data .= ",'".$AnoInicio."'";        }else{$SIS_data .= ",''";}
				if(isset($AnoTermino) && $AnoTermino!=''){            $SIS_data .= ",'".$AnoTermino."'";       }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";         }else{$SIS_data .= ",''";}
				if(isset($idEstudioCat) && $idEstudioCat!=''){        $SIS_data .= ",'".$idEstudioCat."'";     }else{$SIS_data .= ",''";}
				if(isset($idEstudio) && $idEstudio!=''){              $SIS_data .= ",'".$idEstudio."'";        }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                    $SIS_data .= ",'".$Nombre."'";           }else{$SIS_data .= ",''";}
				if(isset($Descripcion) && $Descripcion!=''){          $SIS_data .= ",'".$Descripcion."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idPostulante, AnoInicio, AnoTermino, idEstado, idEstudioCat,idEstudio,Nombre,Descripcion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'postulantes_listado_estudios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEstudioPost='".$idEstudioPost."'";
				if(isset($idPostulante) && $idPostulante!=''){        $SIS_data .= ",idPostulante='".$idPostulante."'";}
				if(isset($AnoInicio) && $AnoInicio!=''){              $SIS_data .= ",AnoInicio='".$AnoInicio."'";}
				if(isset($AnoTermino) && $AnoTermino!=''){            $SIS_data .= ",AnoTermino='".$AnoTermino."'";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idEstudioCat) && $idEstudioCat!=''){        $SIS_data .= ",idEstudioCat='".$idEstudioCat."'";}
				if(isset($idEstudio) && $idEstudio!=''){              $SIS_data .= ",idEstudio='".$idEstudio."'";}
				if(isset($Nombre) && $Nombre!=''){                    $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Descripcion) && $Descripcion!=''){          $SIS_data .= ",Descripcion='".$Descripcion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'postulantes_listado_estudios', 'idEstudioPost = "'.$idEstudioPost.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'postulantes_listado_estudios', 'idEstudioPost = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
