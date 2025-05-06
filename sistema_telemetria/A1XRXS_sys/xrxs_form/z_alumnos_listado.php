<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridAlumnoad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-221).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idAlumno']))              $idAlumno                = $_POST['idAlumno'];
	if (!empty($_POST['idSistema']))             $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))              $idEstado                = $_POST['idEstado'];
	if (!empty($_POST['idCurso']))               $idCurso                 = $_POST['idCurso'];
	if (!empty($_POST['email']))                 $email                   = $_POST['email'];
	if (!empty($_POST['Nombre']))                $Nombre 	              = $_POST['Nombre'];
	if (!empty($_POST['ApellidoPat']))           $ApellidoPat 	          = $_POST['ApellidoPat'];
	if (!empty($_POST['ApellidoMat']))           $ApellidoMat 	          = $_POST['ApellidoMat'];
	if (!empty($_POST['Rut']))                   $Rut 	                  = $_POST['Rut'];
	if (!empty($_POST['fNacimiento']))           $fNacimiento 	          = $_POST['fNacimiento'];
	if (!empty($_POST['Direccion']))             $Direccion 	          = $_POST['Direccion'];
	if (!empty($_POST['Fono1']))                 $Fono1 	              = $_POST['Fono1'];
	if (!empty($_POST['Fono2']))                 $Fono2 	              = $_POST['Fono2'];
	if (!empty($_POST['idCiudad']))              $idCiudad                = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))              $idComuna                = $_POST['idComuna'];
	if (!empty($_POST['Fax']))                   $Fax                     = $_POST['Fax'];
	if (!empty($_POST['PersonaContacto']))       $PersonaContacto         = $_POST['PersonaContacto'];
	if (!empty($_POST['PersonaContacto_Fono']))  $PersonaContacto_Fono    = $_POST['PersonaContacto_Fono'];
	if (!empty($_POST['PersonaContacto_email'])) $PersonaContacto_email   = $_POST['PersonaContacto_email'];
	if (!empty($_POST['Web']))                   $Web                     = $_POST['Web'];
	if (!empty($_POST['password']))              $password                = $_POST['password'];

	if (!empty($_POST['repassword']))            $repassword              = $_POST['repassword'];

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
			case 'idAlumno':               if(empty($idAlumno)){               $error['idAlumno']                = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){              $error['idSistema']               = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':               if(empty($idEstado)){               $error['idEstado']                = 'error/No ha seleccionado el Estado';}break;
			case 'idCurso':                if(empty($idCurso)){                $error['idCurso']                 = 'error/No ha seleccionado el tipo de cliente';}break;
			case 'email':                  if(empty($email)){                  $error['email']                   = 'error/No ha ingresado el email';}break;
			case 'Nombre':                 if(empty($Nombre)){                 $error['Nombre']                  = 'error/No ha ingresado el Nombre';}break;
			case 'ApellidoPat':            if(empty($ApellidoPat)){            $error['ApellidoPat']             = 'error/No ha ingresado el Apellido Paterno';}break;
			case 'ApellidoMat':            if(empty($ApellidoMat)){            $error['ApellidoMat']             = 'error/No ha ingresado el Apellido Materno';}break;
			case 'Rut':                    if(empty($Rut)){                    $error['Rut']                     = 'error/No ha ingresado el Rut';}break;
			case 'fNacimiento':            if(empty($fNacimiento)){            $error['fNacimiento']             = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':              if(empty($Direccion)){              $error['Direccion']               = 'error/No ha ingresado la dirección';}break;
			case 'Fono1':                  if(empty($Fono1)){                  $error['Fono1']                   = 'error/No ha ingresado el telefono';}break;
			case 'Fono2':                  if(empty($Fono2)){                  $error['Fono2']                   = 'error/No ha ingresado el telefono';}break;
			case 'idCiudad':               if(empty($idCiudad)){               $error['idCiudad']                = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':               if(empty($idComuna)){               $error['idComuna']                = 'error/No ha seleccionado la comuna';}break;
			case 'Fax':                    if(empty($Fax)){                    $error['Fax']                     = 'error/No ha ingresado el fax';}break;
			case 'PersonaContacto':        if(empty($PersonaContacto)){        $error['PersonaContacto']         = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'PersonaContacto_Fono':   if(empty($PersonaContacto_Fono)){   $error['PersonaContacto_Fono']    = 'error/No ha ingresado el Fono de la persona de contacto';}break;
			case 'PersonaContacto_email':  if(empty($PersonaContacto_email)){  $error['PersonaContacto_email']   = 'error/No ha ingresado el Email de la persona de contacto';}break;
			case 'Web':                    if(empty($Web)){                    $error['Web']                     = 'error/No ha ingresado la pagina web';}break;
			case 'password':               if(empty($password)){               $error['password']                = 'error/No ha ingresado el password';}break;

			case 'repassword':             if(empty($repassword)){             $error['repassword']              = 'error/No ha ingresado la repeticion de la clave';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	//if(isset($email) && $email!=''){                                 $email                 = EstandarizarInput($email);}
	if(isset($Nombre) && $Nombre!=''){                               $Nombre                = EstandarizarInput($Nombre);}
	if(isset($ApellidoPat) && $ApellidoPat!=''){                     $ApellidoPat           = EstandarizarInput($ApellidoPat);}
	if(isset($ApellidoMat) && $ApellidoMat!=''){                     $ApellidoMat           = EstandarizarInput($ApellidoMat);}
	if(isset($Direccion) && $Direccion!=''){                         $Direccion             = EstandarizarInput($Direccion);}
	if(isset($PersonaContacto) && $PersonaContacto!=''){             $PersonaContacto       = EstandarizarInput($PersonaContacto);}
	if(isset($PersonaContacto_email) && $PersonaContacto_email!=''){ $PersonaContacto_email = EstandarizarInput($PersonaContacto_email);}
	if(isset($Web) && $Web!=''){                                     $Web                   = EstandarizarInput($Web);}
	if(isset($password) && $password!=''){                           $password              = EstandarizarInput($password);}
	if(isset($repassword) && $repassword!=''){                       $repassword            = EstandarizarInput($repassword);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($email)&&contar_palabras_censuradas($email)!=0){                                  $error['email']                 = 'error/Edita email, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                                $error['Nombre']                = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($ApellidoPat)&&contar_palabras_censuradas($ApellidoPat)!=0){                      $error['ApellidoPat']           = 'error/Edita Apellido Pat, contiene palabras no permitidas';}
	if(isset($ApellidoMat)&&contar_palabras_censuradas($ApellidoMat)!=0){                      $error['ApellidoMat']           = 'error/Edita Apellido Mat, contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){                          $error['Direccion']             = 'error/Edita Direccion, contiene palabras no permitidas';}
	if(isset($PersonaContacto)&&contar_palabras_censuradas($PersonaContacto)!=0){              $error['PersonaContacto']       = 'error/Edita Persona de Contacto, contiene palabras no permitidas';}
	if(isset($PersonaContacto_email)&&contar_palabras_censuradas($PersonaContacto_email)!=0){  $error['PersonaContacto_email'] = 'error/Edita Persona de Contacto email, contiene palabras no permitidas';}
	if(isset($Web)&&contar_palabras_censuradas($Web)!=0){                                      $error['Web']                   = 'error/Edita Web, contiene palabras no permitidas';}
	if(isset($password)&&contar_palabras_censuradas($password)!=0){                            $error['password']              = 'error/Edita password, contiene palabras no permitidas';}
	if(isset($repassword)&&contar_palabras_censuradas($repassword)!=0){                        $error['repassword']            = 'error/Edita repassword, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Validacion de los datos ingresados                                       */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){                                      $error['email']                = 'error/El Email ingresado no es valido';}
	if(isset($Fono1)&&!validarNumero($Fono1)){                                     $error['Fono1']                = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono2)&&!validarNumero($Fono2)){                                     $error['Fono2']                = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono1)&&palabra_corto($Fono1, 9)!=1){                                $error['Fono1']                = 'error/'.palabra_corto($Fono1, 9);}
	if(isset($Fono2)&&palabra_corto($Fono2, 9)!=1){                                $error['Fono2']                = 'error/'.palabra_corto($Fono2, 9);}
	if(isset($Rut)&&!validarRut($Rut)){                                            $error['Rut']                  = 'error/El Rut ingresado no es valido';}
	if(isset($PersonaContacto_email)&&!validarEmail($PersonaContacto_email)){      $error['email']                = 'error/El Email ingresado no es valido';}
	if(isset($PersonaContacto_Fono)&&!validarNumero($PersonaContacto_Fono)){       $error['PersonaContacto_Fono'] = 'error/Ingrese un número telefónico válido';}
	if(isset($PersonaContacto_Fono)&&palabra_corto($PersonaContacto_Fono, 9)!=1){  $error['PersonaContacto_Fono'] = 'error/'.palabra_corto($PersonaContacto_Fono, 9);}
	if(isset($password, $repassword)){
		if ( $password <> $repassword )                  $error['password']  = 'error/Las contraseñas ingresadas no coinciden';
	}
	if(isset($password)){
		if (strpos($password, " ")){                     $error['Password1'] = 'error/La contraseña contiene espacios vacios';}
	}

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
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'alumnos_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email, $idSistema)){
				$ndata_3 = db_select_nrows (false, 'email', 'alumnos_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                           $SIS_data  = "'".$idSistema."'";               }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                             $SIS_data .= ",'".$idEstado."'";               }else{$SIS_data .= ",''";}
				if(isset($idCurso) && $idCurso!=''){                               $SIS_data .= ",'".$idCurso."'";                }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                                   $SIS_data .= ",'".$email."'";                  }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                 $SIS_data .= ",'".$Nombre."'";                 }else{$SIS_data .= ",''";}
				if(isset($ApellidoPat) && $ApellidoPat!=''){                       $SIS_data .= ",'".$ApellidoPat."'";            }else{$SIS_data .= ",''";}
				if(isset($ApellidoMat) && $ApellidoMat!=''){                       $SIS_data .= ",'".$ApellidoMat."'";            }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                                       $SIS_data .= ",'".$Rut."'";                    }else{$SIS_data .= ",''";}
				if(isset($fNacimiento) && $fNacimiento!=''){                       $SIS_data .= ",'".$fNacimiento."'";            }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){                           $SIS_data .= ",'".$Direccion."'";              }else{$SIS_data .= ",''";}
				if(isset($Fono1) && $Fono1!=''){                                   $SIS_data .= ",'".$Fono1."'";                  }else{$SIS_data .= ",''";}
				if(isset($Fono2) && $Fono2!=''){                                   $SIS_data .= ",'".$Fono2."'";                  }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                             $SIS_data .= ",'".$idCiudad."'";               }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                             $SIS_data .= ",'".$idComuna."'";               }else{$SIS_data .= ",''";}
				if(isset($Fax) && $Fax!=''){                                       $SIS_data .= ",'".$Fax."'";                    }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto) && $PersonaContacto!=''){               $SIS_data .= ",'".$PersonaContacto."'";        }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono!=''){     $SIS_data .= ",'".$PersonaContacto_Fono."'";   }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto_email) && $PersonaContacto_email!=''){   $SIS_data .= ",'".$PersonaContacto_email."'";  }else{$SIS_data .= ",''";}
				if(isset($Web) && $Web!=''){                                       $SIS_data .= ",'".$Web."'";                    }else{$SIS_data .= ",''";}
				if(isset($password) && $password!=''){                             $SIS_data .= ",'".md5($password)."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, idCurso, email, Nombre,ApellidoPat, ApellidoMat, Rut,
				fNacimiento, Direccion, Fono1, Fono2, idCiudad, idComuna, Fax, PersonaContacto,
				PersonaContacto_Fono, PersonaContacto_email, Web, password';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)&&isset($idAlumno)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."' AND idAlumno!='".$idAlumno."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idAlumno)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'alumnos_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idAlumno!='".$idAlumno."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idAlumno)){
				$ndata_3 = db_select_nrows (false, 'email', 'alumnos_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idAlumno!='".$idAlumno."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idAlumno='".$idAlumno."'";
				if(isset($idSistema) && $idSistema!=''){                             $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                               $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idCurso) && $idCurso!=''){                                 $SIS_data .= ",idCurso='".$idCurso."'";}
				if(isset($email) && $email!=''){                                     $SIS_data .= ",email='".$email."'";}
				if(isset($Nombre) && $Nombre!=''){                                   $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($ApellidoPat) && $ApellidoPat!=''){                         $SIS_data .= ",ApellidoPat='".$ApellidoPat."'";}
				if(isset($ApellidoMat) && $ApellidoMat!=''){                         $SIS_data .= ",ApellidoMat='".$ApellidoMat."'";}
				if(isset($Rut) && $Rut!=''){                                         $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($fNacimiento) && $fNacimiento!=''){                         $SIS_data .= ",fNacimiento='".$fNacimiento."'";}
				if(isset($Direccion) && $Direccion!=''){                             $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Fono1) && $Fono1!=''){                                     $SIS_data .= ",Fono1='".$Fono1."'";}
				if(isset($Fono2) && $Fono2!=''){                                     $SIS_data .= ",Fono2='".$Fono2."'";}
				if(isset($idCiudad) && $idCiudad!= ''){                              $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!= ''){                              $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Fax) && $Fax!= ''){                                        $SIS_data .= ",Fax='".$Fax."'";}
				if(isset($PersonaContacto) && $PersonaContacto!= ''){                $SIS_data .= ",PersonaContacto='".$PersonaContacto."'";}
				if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono!= ''){      $SIS_data .= ",PersonaContacto_Fono='".$PersonaContacto_Fono."'";}
				if(isset($PersonaContacto_email) && $PersonaContacto_email!= ''){    $SIS_data .= ",PersonaContacto_email='".$PersonaContacto_email."'";}
				if(isset($Web) && $Web!= ''){                                        $SIS_data .= ",Web='".$Web."'";}
				if(isset($password) && $password!= ''){                              $SIS_data .= ",password='".md5($password)."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'alumnos_listado', 'idAlumno = "'.$idAlumno.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'alumnos_listado', 'idAlumno = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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

			$idAlumno  = $_GET['id'];
			$idEstado  = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'alumnos_listado', 'idAlumno = "'.$idAlumno.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}


		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["Direccion_img"]["error"] > 0){
				$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'alumno_img_'.$idAlumno.'_';

				if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						//$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
						//Muevo el archivo
						$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], "upload/xxxsxx_".$_FILES['Direccion_img']['name']);
						if ($move_result){

							//se selecciona la imagen
							switch ($_FILES['Direccion_img']['type']) {
								case 'image/jpg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/jpeg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/gif':
									$imgBase = imagecreatefromgif('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/png':
									$imgBase = imagecreatefrompng('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
							}

							//se reescala la imagen en caso de ser necesario
							$imgBase_width = imagesx( $imgBase );
							$imgBase_height = imagesy( $imgBase );

							//Se establece el tamaño maximo
							$max_width  = 640;
							$max_height = 640;

							if ($imgBase_width > $imgBase_height) {
								if($imgBase_width < $max_width){
									$newwidth = $imgBase_width;
								}else{
									$newwidth = $max_width;
								}
								$divisor = $imgBase_width / $newwidth;
								$newheight = floor( $imgBase_height / $divisor);
							}else {
								if($imgBase_height < $max_height){
									$newheight = $imgBase_height;
								}else{
									$newheight =  $max_height;
								}
								$divisor = $imgBase_height / $newheight;
								$newwidth = floor( $imgBase_width / $divisor );
							}

							$imgBase = imagescale($imgBase, $newwidth, $newheight);

							//se establece la calidad del archivo
							$quality = 75;

							//se crea la imagen
							imagejpeg($imgBase, $ruta, $quality);

							//se elimina la imagen base
							try {
								if(!is_writable('upload/xxxsxx_'.$_FILES['Direccion_img']['name'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
							//se eliminan las imagenes de la memoria
							imagedestroy($imgBase);

							//Filtro para idSistema
							$SIS_data = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'alumnos_listado', 'idAlumno = "'.$idAlumno.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['Direccion_img']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Direccion_img']     = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
					}
				} else {
					$error['Direccion_img']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre de la imagen
			$rowData = db_select_data (false, 'Direccion_img', 'alumnos_listado', '', 'idAlumno = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'alumnos_listado', 'idAlumno = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){
					try {
						if(!is_writable('upload/'.$rowData['Direccion_img'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['Direccion_img']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
