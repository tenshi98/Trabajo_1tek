<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridLaboratorioad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-086).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idLaboratorio']))    $idLaboratorio      = $_POST['idLaboratorio'];
	if (!empty($_POST['idSistema']))        $idSistema          = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))         $idEstado           = $_POST['idEstado'];
	if (!empty($_POST['idTipo']))           $idTipo             = $_POST['idTipo'];
	if (!empty($_POST['email']))            $email              = $_POST['email'];
	if (!empty($_POST['Nombre']))           $Nombre 	        = $_POST['Nombre'];
	if (!empty($_POST['Rut']))              $Rut 	            = $_POST['Rut'];
	if (!empty($_POST['fNacimiento']))      $fNacimiento 	    = $_POST['fNacimiento'];
	if (!empty($_POST['Direccion']))        $Direccion 	        = $_POST['Direccion'];
	if (!empty($_POST['Fono1']))            $Fono1 	            = $_POST['Fono1'];
	if (!empty($_POST['Fono2']))            $Fono2 	            = $_POST['Fono2'];
	if (!empty($_POST['idCiudad']))         $idCiudad           = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))         $idComuna           = $_POST['idComuna'];
	if (!empty($_POST['Fax']))              $Fax                = $_POST['Fax'];
	if (!empty($_POST['PersonaContacto']))  $PersonaContacto    = $_POST['PersonaContacto'];
	if (!empty($_POST['Web']))              $Web                = $_POST['Web'];
	if (!empty($_POST['idPais']))           $idPais             = $_POST['idPais'];
	if ( isset($_POST['Giro']))             $Giro               = $_POST['Giro'];

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
			case 'idLaboratorio':     if(empty($idLaboratorio)){     $error['idLaboratorio']      = 'error/No ha ingresado el id';}break;
			case 'idSistema':         if(empty($idSistema)){         $error['idSistema']          = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':          if(empty($idEstado)){          $error['idEstado']           = 'error/No ha seleccionado el Estado';}break;
			case 'idTipo':            if(empty($idTipo)){            $error['idTipo']             = 'error/No ha seleccionado el ripo de proveedor';}break;
			case 'email':             if(empty($email)){             $error['email']              = 'error/No ha ingresado la email';}break;
			case 'Nombre':            if(empty($Nombre)){            $error['Nombre']             = 'error/No ha ingresado el Nombre';}break;
			case 'Rut':               if(empty($Rut)){               $error['Rut']                = 'error/No ha ingresado el Rut';}break;
			case 'fNacimiento':       if(empty($fNacimiento)){       $error['fNacimiento']        = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':         if(empty($Direccion)){         $error['Direccion']          = 'error/No ha ingresado la dirección';}break;
			case 'Fono1':             if(empty($Fono1)){             $error['Fono1']              = 'error/No ha ingresado el numero telefonico';}break;
			case 'Fono2':             if(empty($Fono2)){             $error['Fono2']              = 'error/No ha ingresado el numero telefonico';}break;
			case 'idCiudad':          if(empty($idCiudad)){          $error['idCiudad']           = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':          if(empty($idComuna)){          $error['idComuna']           = 'error/No ha seleccionado la comuna';}break;
			case 'Fax':               if(empty($Fax)){               $error['Fax']                = 'error/No ha ingresado el fax';}break;
			case 'PersonaContacto':   if(empty($PersonaContacto)){   $error['PersonaContacto']    = 'error/No ha ingresado el nombre de la persona de contato';}break;
			case 'Web':               if(empty($Web)){               $error['Web']                = 'error/No ha ingresado la pagina web';}break;
			case 'idPais':            if(empty($idPais)){            $error['idPais']             = 'error/No ha seleccionado el pais';}break;
			case 'Giro':              if(empty($Giro)){              $error['Giro']               = 'error/No ha ingresado el Giro de la empresa';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	//if(isset($email) && $email!=''){                     $email           = EstandarizarInput($email);}
	if(isset($Nombre) && $Nombre!=''){                   $Nombre          = EstandarizarInput($Nombre);}
	if(isset($Direccion) && $Direccion!=''){             $Direccion       = EstandarizarInput($Direccion);}
	if(isset($PersonaContacto) && $PersonaContacto!=''){ $PersonaContacto = EstandarizarInput($PersonaContacto);}
	if(isset($Web) && $Web!=''){                         $Web             = EstandarizarInput($Web);}
	if(isset($Giro) && $Giro!=''){                       $Giro            = EstandarizarInput($Giro);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){        $error['email']   = 'error/El Email ingresado no es valido';}
	if(isset($Fono1)&&!validarNumero($Fono1)){       $error['Fono1']   = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono2)&&!validarNumero($Fono2)){       $error['Fono2']   = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono1)&&palabra_corto($Fono1, 9)!=1){  $error['Fono1']   = 'error/'.palabra_corto($Fono1, 9);}
	if(isset($Fono2)&&palabra_corto($Fono2, 9)!=1){  $error['Fono2']   = 'error/'.palabra_corto($Fono2, 9);}
	if(isset($Rut)&&!validarRut($Rut)){              $error['Rut']     = 'error/El Rut ingresado no es valido';}
	if(isset($Fax)&&!validarNumero($Fax)){           $error['Fax']     = 'error/Ingrese un numero de fax valido';}
	if(isset($Fax)&&palabra_corto($Fax, 9)!=1){      $error['Fax']     = 'error/'.palabra_corto($Fax, 9);}

	if(isset($email)&&contar_palabras_censuradas($email)!=0){                      $error['email']           = 'error/Edita email, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                    $error['Nombre']          = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){              $error['Direccion']       = 'error/Edita Direccion, contiene palabras no permitidas';}
	if(isset($PersonaContacto)&&contar_palabras_censuradas($PersonaContacto)!=0){  $error['PersonaContacto'] = 'error/Edita la Persona de Contacto, contiene palabras no permitidas';}
	if(isset($Web)&&contar_palabras_censuradas($Web)!=0){                          $error['Web']             = 'error/Edita la Web, contiene palabras no permitidas';}
	if(isset($Giro)&&contar_palabras_censuradas($Giro)!=0){                        $error['Giro']            = 'error/Edita Giro, contiene palabras no permitidas';}

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
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'laboratorio_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'laboratorio_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email, $idSistema)){
				$ndata_3 = db_select_nrows (false, 'email', 'laboratorio_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ingresado ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                 $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                   $SIS_data .= ",'".$idEstado."'";          }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                       $SIS_data .= ",'".$idTipo."'";            }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                         $SIS_data .= ",'".$email."'";             }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                       $SIS_data .= ",'".$Nombre."'";            }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                             $SIS_data .= ",'".$Rut."'";               }else{$SIS_data .= ",''";}
				if(isset($fNacimiento) && $fNacimiento!=''){             $SIS_data .= ",'".$fNacimiento."'";       }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){                 $SIS_data .= ",'".$Direccion."'";         }else{$SIS_data .= ",''";}
				if(isset($Fono1) && $Fono1!=''){                         $SIS_data .= ",'".$Fono1."'";             }else{$SIS_data .= ",''";}
				if(isset($Fono2) && $Fono2!=''){                         $SIS_data .= ",'".$Fono2."'";             }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                   $SIS_data .= ",'".$idCiudad."'";          }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                   $SIS_data .= ",'".$idComuna."'";          }else{$SIS_data .= ",''";}
				if(isset($Fax) && $Fax!=''){                             $SIS_data .= ",'".$Fax."'";               }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto) && $PersonaContacto!=''){     $SIS_data .= ",'".$PersonaContacto."'";   }else{$SIS_data .= ",''";}
				if(isset($Web) && $Web!=''){                             $SIS_data .= ",'".$Web."'";               }else{$SIS_data .= ",''";}
				if(isset($idPais) && $idPais!=''){                       $SIS_data .= ",'".$idPais."'";            }else{$SIS_data .= ",''";}
				if(isset($Giro) && $Giro!=''){                           $SIS_data .= ",'".$Giro."'";              }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, idTipo, email, Nombre,
				Rut, fNacimiento, Direccion, Fono1, Fono2, idCiudad, idComuna, Fax, PersonaContacto,
				Web, idPais, Giro';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'laboratorio_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idLaboratorio)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'laboratorio_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idLaboratorio!='".$idLaboratorio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idLaboratorio)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'laboratorio_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idLaboratorio!='".$idLaboratorio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idLaboratorio)){
				$ndata_3 = db_select_nrows (false, 'email', 'laboratorio_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idLaboratorio!='".$idLaboratorio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ingresado ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idLaboratorio='".$idLaboratorio."'";
				if(isset($idSistema) && $idSistema!=''){                   $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                     $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idTipo) && $idTipo!=''){                         $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($email) && $email!=''){                           $SIS_data .= ",email='".$email."'";}
				if(isset($Nombre) && $Nombre!=''){                         $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Rut) && $Rut!=''){                               $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($fNacimiento) && $fNacimiento!=''){               $SIS_data .= ",fNacimiento='".$fNacimiento."'";}
				if(isset($Direccion) && $Direccion!=''){                   $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Fono1) && $Fono1!=''){                           $SIS_data .= ",Fono1='".$Fono1."'";}
				if(isset($Fono2) && $Fono2!=''){                           $SIS_data .= ",Fono2='".$Fono2."'";}
				if(isset($idCiudad) && $idCiudad!= ''){                    $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!= ''){                    $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Fax) && $Fax!= ''){                              $SIS_data .= ",Fax='".$Fax."'";}
				if(isset($PersonaContacto) && $PersonaContacto!= ''){      $SIS_data .= ",PersonaContacto='".$PersonaContacto."'";}
				if(isset($Web) && $Web!= ''){                              $SIS_data .= ",Web='".$Web."'";}
				if(isset($idPais) && $idPais!= ''){                        $SIS_data .= ",idPais='".$idPais."'";}
				if(isset($Giro) && $Giro!= ''){                            $SIS_data .= ",Giro='".$Giro."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'laboratorio_listado', 'idLaboratorio = "'.$idLaboratorio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'laboratorio_listado', 'idLaboratorio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idLaboratorio  = $_GET['id'];
			$idEstado       = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'laboratorio_listado', 'idLaboratorio = "'.$idLaboratorio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
