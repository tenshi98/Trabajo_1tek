<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-115).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de idUsuarioes input a variables
	if (!empty($_POST['idRecepcion']))           $idRecepcion            = $_POST['idRecepcion'];
	if (!empty($_POST['idSistema']))             $idSistema              = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))             $idUsuario              = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))                 $Fecha                  = $_POST['Fecha'];
	if (!empty($_POST['Hora']))                  $Hora                   = $_POST['Hora'];
	if (!empty($_POST['idTipo']))                $idTipo                 = $_POST['idTipo'];
	if (!empty($_POST['De']))                    $De                     = $_POST['De'];
	if (!empty($_POST['Para']))                  $Para                   = $_POST['Para'];
	if (!empty($_POST['Observaciones']))         $Observaciones          = $_POST['Observaciones'];

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
			case 'idRecepcion':        if(empty($idRecepcion)){        $error['idRecepcion']        = 'error/No ha ingresado el id';}break;
			case 'idSistema':          if(empty($idSistema)){          $error['idSistema']          = 'error/No ha seleccionado el Sistema';}break;
			case 'idUsuario':          if(empty($idUsuario)){          $error['idUsuario']          = 'error/No ha seleccionado el Usuario';}break;
			case 'Fecha':              if(empty($Fecha)){              $error['Fecha']              = 'error/No ha ingresado la fecha';}break;
			case 'Hora':               if(empty($Hora)){               $error['Hora']               = 'error/No ha ingresado la hora';}break;
			case 'idTipo':             if(empty($idTipo)){             $error['idTipo']             = 'error/No ha ingresado el Tipo';}break;
			case 'De':                 if(empty($De)){                 $error['De']                 = 'error/No ha ingresado el quien envia';}break;
			case 'Para':               if(empty($Para)){               $error['Para']               = 'error/No ha ingresado el quien recibe';}break;
			case 'Observaciones':      if(empty($Observaciones)){      $error['Observaciones']      = 'error/No ha ingresado las Observaciones';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($De) && $De!=''){                       $De            = EstandarizarInput($De);}
	if(isset($Para) && $Para!=''){                   $Para          = EstandarizarInput($Para);}
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($De)&&contar_palabras_censuradas($De)!=0){                        $error['De']            = 'error/Edita De, contiene palabras no permitidas';}
	if(isset($Para)&&contar_palabras_censuradas($Para)!=0){                    $error['Para']          = 'error/Edita Para, contiene palabras no permitidas';}
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}

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
				if(isset($idSistema) && $idSistema!=''){           $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){           $SIS_data .= ",'".$idUsuario."'";      }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                   $SIS_data .= ",'".$Fecha."'";          }else{$SIS_data .= ",''";}
				if(isset($Hora) && $Hora!=''){                     $SIS_data .= ",'".$Hora."'";           }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                 $SIS_data .= ",'".$idTipo."'";         }else{$SIS_data .= ",''";}
				if(isset($De) && $De!=''){                         $SIS_data .= ",'".$De."'";             }else{$SIS_data .= ",''";}
				if(isset($Para) && $Para!=''){                     $SIS_data .= ",'".$Para."'";           }else{$SIS_data .= ",''";}
				if(isset($Observaciones) && $Observaciones!=''){   $SIS_data .= ",'".$Observaciones."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, Fecha, Hora, idTipo, De, Para, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_recepcion_documentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$SIS_data = "idRecepcion='".$idRecepcion."'";
				if(isset($idSistema) && $idSistema!=''){          $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){          $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Fecha) && $Fecha!=''){                  $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($Hora) && $Hora!=''){                    $SIS_data .= ",Hora='".$Hora."'";}
				if(isset($idTipo) && $idTipo!=''){                $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($De) && $De!=''){                        $SIS_data .= ",De='".$De."'";}
				if(isset($Para) && $Para!=''){                    $SIS_data .= ",Para='".$Para."'";}
				if(isset($Observaciones) && $Observaciones!=''){  $SIS_data .= ",Observaciones='".$Observaciones."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seguridad_recepcion_documentos', 'idRecepcion = "'.$idRecepcion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'seguridad_recepcion_documentos', 'idRecepcion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
