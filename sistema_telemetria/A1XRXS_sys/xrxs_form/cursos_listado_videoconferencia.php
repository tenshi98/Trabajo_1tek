<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-079).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idVideoConferencia']))  $idVideoConferencia   = $_POST['idVideoConferencia'];
	if (!empty($_POST['idCurso']))             $idCurso              = $_POST['idCurso'];
	if (!empty($_POST['idUsuario']))           $idUsuario            = $_POST['idUsuario'];
	if (!empty($_POST['Nombre']))              $Nombre               = $_POST['Nombre'];
	if (!empty($_POST['HoraInicio']))          $HoraInicio           = $_POST['HoraInicio'];
	if (!empty($_POST['HoraTermino']))         $HoraTermino          = $_POST['HoraTermino'];
	if (!empty($_POST['idDia_1']))             $idDia_1              = $_POST['idDia_1'];
	if (!empty($_POST['idDia_2']))             $idDia_2              = $_POST['idDia_2'];
	if (!empty($_POST['idDia_3']))             $idDia_3              = $_POST['idDia_3'];
	if (!empty($_POST['idDia_4']))             $idDia_4              = $_POST['idDia_4'];
	if (!empty($_POST['idDia_5']))             $idDia_5              = $_POST['idDia_5'];
	if (!empty($_POST['idDia_6']))             $idDia_6              = $_POST['idDia_6'];
	if (!empty($_POST['idDia_7']))             $idDia_7              = $_POST['idDia_7'];

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
			case 'idVideoConferencia':  if(empty($idVideoConferencia)){  $error['idVideoConferencia']  = 'error/No ha ingresado el id';}break;
			case 'idCurso':             if(empty($idCurso)){             $error['idCurso']             = 'error/No ha seleccionado el curso';}break;
			case 'idUsuario':           if(empty($idUsuario)){           $error['idUsuario']           = 'error/No ha seleccionado el profesor';}break;
			case 'Nombre':              if(empty($Nombre)){              $error['Nombre']              = 'error/No ha ingresado el nombre';}break;
			case 'HoraInicio':          if(empty($HoraInicio)){          $error['HoraInicio']          = 'error/No ha ingresado la hora de inicio';}break;
			case 'HoraTermino':         if(empty($HoraTermino)){         $error['HoraTermino']         = 'error/No ha ingresado la hora de termino';}break;
			case 'idDia_1':             if(empty($idDia_1)){             $error['idDia_1']             = 'error/No ha seleccionado el dia lunes';}break;
			case 'idDia_2':             if(empty($idDia_2)){             $error['idDia_2']             = 'error/No ha seleccionado el dia martes';}break;
			case 'idDia_3':             if(empty($idDia_3)){             $error['idDia_3']             = 'error/No ha seleccionado el dia miercoles';}break;
			case 'idDia_4':             if(empty($idDia_4)){             $error['idDia_4']             = 'error/No ha seleccionado el dia jueves';}break;
			case 'idDia_5':             if(empty($idDia_5)){             $error['idDia_5']             = 'error/No ha seleccionado el dia viernes';}break;
			case 'idDia_6':             if(empty($idDia_6)){             $error['idDia_6']             = 'error/No ha seleccionado el dia sabado';}break;
			case 'idDia_7':             if(empty($idDia_7)){             $error['idDia_7']             = 'error/No ha seleccionado el dia domingo';}break;

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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idCurso) && $idCurso!=''){          $SIS_data  = "'".$idCurso."'";       }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){      $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",'".$Nombre."'";       }else{$SIS_data .= ",''";}
				if(isset($HoraInicio) && $HoraInicio!=''){    $SIS_data .= ",'".$HoraInicio."'";   }else{$SIS_data .= ",''";}
				if(isset($HoraTermino) && $HoraTermino!=''){  $SIS_data .= ",'".$HoraTermino."'";  }else{$SIS_data .= ",''";}
				if(isset($idDia_1) && $idDia_1!=''){          $SIS_data .= ",'".$idDia_1."'";      }else{$SIS_data .= ",''";}
				if(isset($idDia_2) && $idDia_2!=''){          $SIS_data .= ",'".$idDia_2."'";      }else{$SIS_data .= ",''";}
				if(isset($idDia_3) && $idDia_3!=''){          $SIS_data .= ",'".$idDia_3."'";      }else{$SIS_data .= ",''";}
				if(isset($idDia_4) && $idDia_4!=''){          $SIS_data .= ",'".$idDia_4."'";      }else{$SIS_data .= ",''";}
				if(isset($idDia_5) && $idDia_5!=''){          $SIS_data .= ",'".$idDia_5."'";      }else{$SIS_data .= ",''";}
				if(isset($idDia_6) && $idDia_6!=''){          $SIS_data .= ",'".$idDia_6."'";      }else{$SIS_data .= ",''";}
				if(isset($idDia_7) && $idDia_7!=''){          $SIS_data .= ",'".$idDia_7."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCurso, idUsuario, Nombre,HoraInicio, HoraTermino, idDia_1, idDia_2, idDia_3, idDia_4, idDia_5, idDia_6, idDia_7';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cursos_listado_videoconferencia', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$SIS_data = "idVideoConferencia='".$idVideoConferencia."'";
				if(isset($idCurso) && $idCurso!=''){          $SIS_data .= ",idCurso='".$idCurso."'";}
				if(isset($idUsuario) && $idUsuario!=''){      $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($HoraInicio) && $HoraInicio!=''){    $SIS_data .= ",HoraInicio='".$HoraInicio."'";}
				if(isset($HoraTermino) && $HoraTermino!=''){  $SIS_data .= ",HoraTermino='".$HoraTermino."'";}
				if(isset($idDia_1) && $idDia_1!=''){          $SIS_data .= ",idDia_1='".$idDia_1."'";}
				if(isset($idDia_2) && $idDia_2!=''){          $SIS_data .= ",idDia_2='".$idDia_2."'";}
				if(isset($idDia_3) && $idDia_3!=''){          $SIS_data .= ",idDia_3='".$idDia_3."'";}
				if(isset($idDia_4) && $idDia_4!=''){          $SIS_data .= ",idDia_4='".$idDia_4."'";}
				if(isset($idDia_5) && $idDia_5!=''){          $SIS_data .= ",idDia_5='".$idDia_5."'";}
				if(isset($idDia_6) && $idDia_6!=''){          $SIS_data .= ",idDia_6='".$idDia_6."'";}
				if(isset($idDia_7) && $idDia_7!=''){          $SIS_data .= ",idDia_7='".$idDia_7."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cursos_listado_videoconferencia', 'idVideoConferencia = "'.$idVideoConferencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				/*************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'cursos_listado_videoconferencia', 'idVideoConferencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
