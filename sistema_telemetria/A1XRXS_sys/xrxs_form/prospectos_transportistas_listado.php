<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridProspectoad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-107).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idProspecto']))           $idProspecto             = $_POST['idProspecto'];
	if (!empty($_POST['idSistema']))             $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['Nombre']))                $Nombre 	              = $_POST['Nombre'];
	if (!empty($_POST['Fono']))                  $Fono 	                  = $_POST['Fono'];
	if (!empty($_POST['email']))                 $email                   = $_POST['email'];
	if (!empty($_POST['email_noti']))            $email_noti              = $_POST['email_noti'];
	if (!empty($_POST['F_Ingreso']))             $F_Ingreso               = $_POST['F_Ingreso'];
	if (!empty($_POST['idEstadoFidelizacion']))  $idEstadoFidelizacion    = $_POST['idEstadoFidelizacion'];
	if (!empty($_POST['idEtapa']))               $idEtapa                 = $_POST['idEtapa'];

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
			case 'idProspecto':            if(empty($idProspecto)){            $error['idProspecto']             = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){              $error['idSistema']               = 'error/No ha seleccionado el sistema';}break;
			case 'Nombre':                 if(empty($Nombre)){                 $error['Nombre']                  = 'error/No ha ingresado el Nombre del chofer';}break;
			case 'Fono':                   if(empty($Fono)){                   $error['Fono']                    = 'error/No ha ingresado el telefono';}break;
			case 'email':                  if(empty($email)){                  $error['email']                   = 'error/No ha ingresado el email';}break;
			case 'email_noti':             if(empty($email_noti)){             $error['email_noti']              = 'error/No ha ingresado el email de notificacion';}break;
			case 'F_Ingreso':              if(empty($F_Ingreso)){              $error['F_Ingreso']               = 'error/No ha ingresado la fecha de ingreso';}break;
			case 'idEstadoFidelizacion':   if(empty($idEstadoFidelizacion)){   $error['idEstadoFidelizacion']    = 'error/No ha seleccionado el estado de la fidelizacion';}break;
			case 'idEtapa':                if(empty($idEtapa)){                $error['idEtapa']                 = 'error/No ha seleccionado la etapa de la fidelizacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){         $Nombre     = EstandarizarInput($Nombre);}
	//if(isset($email) && $email!=''){           $email      = EstandarizarInput($email);}
	//if(isset($email_noti) && $email_noti!=''){ $email_noti = EstandarizarInput($email_noti);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){          $error['Nombre']     = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($email)&&contar_palabras_censuradas($email)!=0){            $error['email']      = 'error/Edita email, contiene palabras no permitidas';}
	if(isset($email_noti)&&contar_palabras_censuradas($email_noti)!=0){  $error['email_noti'] = 'error/Edita email noti, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){           $error['email']       = 'error/El Email ingresado no es valido';}
	if(isset($email_noti)&&!validarEmail($email_noti)){ $error['email_noti']  = 'error/El Email ingresado no es valido';}
	if(isset($Fono)&&!validarNumero($Fono)){            $error['Fono']        = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono)&&palabra_corto($Fono, 9)!=1){       $error['Fono']        = 'error/'.palabra_corto($Fono, 9);}

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
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'prospectos_transportistas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'email', 'prospectos_transportistas_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                           $SIS_data  = "'".$idSistema."'";               }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){                                 $SIS_data .= ",'".$Nombre."'";                 }else{$SIS_data .= ",''";}
				if(isset($Fono) && $Fono!=''){                                     $SIS_data .= ",'".$Fono."'";                   }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                                   $SIS_data .= ",'".$email."'";                  }else{$SIS_data .= ",''";}
				if(isset($email_noti) && $email_noti!=''){                         $SIS_data .= ",'".$email_noti."'";             }else{$SIS_data .= ",''";}
				if(isset($F_Ingreso) && $F_Ingreso!=''){                           $SIS_data .= ",'".$F_Ingreso."'";              }else{$SIS_data .= ",''";}
				if(isset($idEstadoFidelizacion) && $idEstadoFidelizacion!=''){     $SIS_data .= ",'".$idEstadoFidelizacion."'";   }else{$SIS_data .= ",''";}
				if(isset($idEtapa) && $idEtapa!=''){                               $SIS_data .= ",'".$idEtapa."'";                }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Nombre,Fono, email, email_noti,
				F_Ingreso, idEstadoFidelizacion, idEtapa';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'prospectos_transportistas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idProspecto)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'prospectos_transportistas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idProspecto!='".$idProspecto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idProspecto)){
				$ndata_2 = db_select_nrows (false, 'email', 'prospectos_transportistas_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idProspecto!='".$idProspecto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idProspecto='".$idProspecto."'";
				if(isset($idSistema) && $idSistema!=''){                         $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Nombre) && $Nombre!=''){                               $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Fono) && $Fono!=''){                                   $SIS_data .= ",Fono='".$Fono."'";}
				if(isset($email) && $email!=''){                                 $SIS_data .= ",email='".$email."'";}
				if(isset($email_noti) && $email_noti!=''){                       $SIS_data .= ",email_noti='".$email_noti."'";}
				if(isset($F_Ingreso) && $F_Ingreso!= ''){                        $SIS_data .= ",F_Ingreso='".$F_Ingreso."'";}
				if(isset($idEstadoFidelizacion) && $idEstadoFidelizacion!= ''){  $SIS_data .= ",idEstadoFidelizacion='".$idEstadoFidelizacion."'";}
				if(isset($idEtapa) && $idEtapa!= ''){                            $SIS_data .= ",idEtapa='".$idEtapa."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'prospectos_transportistas_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'prospectos_transportistas_listado', 'idProspecto = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
