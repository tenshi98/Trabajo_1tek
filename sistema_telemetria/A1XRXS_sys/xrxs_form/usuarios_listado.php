<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (1).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idUsuario']))      $idUsuario      = $_POST['idUsuario'];
	if (!empty($_POST['usuario']))        $usuario        = $_POST['usuario'];
	if (!empty($_POST['password']))       $password       = $_POST['password'];
	if (!empty($_POST['idTipoUsuario']))  $idTipoUsuario  = $_POST['idTipoUsuario'];
	if (!empty($_POST['idEstado']))       $idEstado       = $_POST['idEstado'];
	if (!empty($_POST['email']))          $email          = $_POST['email'];
	if (!empty($_POST['Nombre']))         $Nombre         = $_POST['Nombre'];
	if (!empty($_POST['Rut']))            $Rut 	          = $_POST['Rut'];
	if (!empty($_POST['fNacimiento']))    $fNacimiento    = $_POST['fNacimiento'];
	if (!empty($_POST['Fono']))           $Fono 	      = $_POST['Fono'];
	if (!empty($_POST['idCiudad']))       $idCiudad 	  = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))       $idComuna 	  = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))      $Direccion      = $_POST['Direccion'];
	if (!empty($_POST['Direccion_img']))  $Direccion_img  = $_POST['Direccion_img'];
	if (!empty($_POST['Ultimo_acceso']))  $Ultimo_acceso  = $_POST['Ultimo_acceso'];
	if (!empty($_POST['idSistema']))      $idSistema      = $_POST['idSistema'];

	if (!empty($_POST['repassword']))     $repassword     = $_POST['repassword'];
	if (!empty($_POST['oldpassword']))    $oldpassword    = $_POST['oldpassword'];
	if (!empty($_POST['fkinput1']))       $fkinput1       = $_POST['fkinput1'];
	if (!empty($_POST['fkinput2']))       $fkinput2       = $_POST['fkinput2'];

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
			case 'idUsuario':      if(empty($idUsuario)){                               $error['idUsuario']      = 'error/No ha ingresado el id';}break;
			case 'usuario':        if(empty($usuario)&&$form_trabajo!='getpass'){       $error['usuario']        = 'error/No ha ingresado el nombre de usuario del sistema';}break;
			case 'password':       if(empty($password)&&$form_trabajo!='getpass'){      $error['password']       = 'error/No ha ingresado una clave';}break;
			case 'idTipoUsuario':  if(empty($idTipoUsuario)){                           $error['idTipoUsuario']  = 'error/No ha seleccionado el tipo de usuario';}break;
			case 'idEstado':       if(empty($idEstado)){                                $error['idEstado']       = 'error/No ha seleccionado el estado';}break;
			case 'email':          if(empty($email)&&$form_trabajo!='login'){           $error['email']          = 'error/No ha ingresado el email';}break;
			case 'Nombre':         if(empty($Nombre)){                                  $error['Nombre']         = 'error/No ha ingresado el Nombre';}break;
			case 'Rut':            if(empty($Rut)){                                     $error['Rut']            = 'error/No ha ingresado el Rut';}break;
			case 'fNacimiento':    if(empty($fNacimiento)){                             $error['fNacimiento']    = 'error/No ha ingresado el fNacimiento';}break;
			case 'Fono':           if(empty($Fono)){                                    $error['Fono']           = 'error/No ha ingresado el Fono';}break;
			case 'idCiudad':       if(empty($idCiudad)){                                $error['idCiudad']       = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':       if(empty($idComuna)){                                $error['idComuna']       = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':      if(empty($Direccion)){                               $error['Direccion']      = 'error/No ha ingresado la Dirección';}break;
			case 'Direccion_img':  if(empty($Direccion_img)){                           $error['Direccion_img']  = 'error/No ha ingresado el nombre de la imagen de perfil';}break;
			case 'Ultimo_acceso':  if(empty($Ultimo_acceso)){                           $error['Ultimo_acceso']  = 'error/No ha ingresado el ultimo acceso al sistema';}break;

			case 'repassword':     if(empty($repassword)){                              $error['repassword']     = 'error/No ha ingresado la repeticion de la clave';}break;
			case 'oldpassword':    if(empty($oldpassword)){                             $error['oldpassword']    = 'error/No ha ingresado su clave antigua';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($usuario) && $usuario!=''){         $usuario     = EstandarizarInput($usuario);}
	if(isset($password) && $password!=''){       $password    = EstandarizarInput($password);}
	if(isset($repassword) && $repassword!=''){   $repassword  = EstandarizarInput($repassword);}
	if(isset($oldpassword) && $oldpassword!=''){ $oldpassword = EstandarizarInput($oldpassword);}
	//if(isset($email) && $email!=''){             $email       = EstandarizarInput($email);}
	if(isset($Nombre) && $Nombre!=''){           $Nombre      = EstandarizarInput($Nombre);}
	if(isset($Direccion) && $Direccion!=''){     $Direccion   = EstandarizarInput($Direccion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($usuario)&&contar_palabras_censuradas($usuario)!=0){          $error['usuario']     = 'error/Edita usuario, contiene palabras no permitidas';}
	if(isset($password)&&contar_palabras_censuradas($password)!=0){        $error['password']    = 'error/Edita password, contiene palabras no permitidas';}
	if(isset($repassword)&&contar_palabras_censuradas($repassword)!=0){    $error['repassword']  = 'error/Edita repassword, contiene palabras no permitidas';}
	if(isset($oldpassword)&&contar_palabras_censuradas($oldpassword)!=0){  $error['oldpassword'] = 'error/Edita oldpassword, contiene palabras no permitidas';}
	if(isset($email)&&contar_palabras_censuradas($email)!=0){              $error['email']       = 'error/Edita email, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){            $error['Nombre']      = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){      $error['Direccion']   = 'error/Edita la Direccion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Validacion de los datos ingresados                                       */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){     $error['email']    = 'error/El Email ingresado no es valido';}
	if(isset($Fono)&&!validarNumero($Fono)){      $error['Fono']	 = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono)&&palabra_corto($Fono, 9)!=1){ $error['Fono']     = 'error/'.palabra_corto($Fono, 9);}
	if(isset($Rut)&&!validarRut($Rut)){           $error['Rut']      = 'error/El Rut ingresado no es valido';}
	if(isset($password, $repassword)){
		if ( $password <> $repassword )           $error['password'] = 'error/Las contraseñas ingresadas no coinciden';
	}
	if(isset($usuario)){
		if (strpos($usuario, " ")){               $error['usuario1']  = 'error/El nombre de usuario contiene espacios vacios';}
		if (strtolower($usuario) != $usuario){    $error['usuario2']  = 'error/El nombre de usuario contiene mayusculas';}
	}
	if(isset($password)){
		if (strpos($password, " ")){              $error['Password1'] = 'error/La contraseña de usuario contiene espacios vacios';}
		//if (strtolower($password) != $password){  $error['Password2'] = 'error/La contraseña de usuario contiene mayusculas';}
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
			$ndata_4 = 0;
			//Se verifica si el dato existe
			if(isset($usuario)){
				$ndata_1 = db_select_nrows (false, 'usuario', 'usuarios_listado', '', "usuario='".$usuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Nombre)){
				$ndata_2 = db_select_nrows (false, 'Nombre', 'usuarios_listado', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)){
				$ndata_3 = db_select_nrows (false, 'Rut', 'usuarios_listado', '', "Rut='".$Rut."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)){
				$ndata_4 = db_select_nrows (false, 'email', 'usuarios_listado', '', "email='".$email."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de usuario ingresado ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El nombre de la persona ingresada ya existe';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El Rut ya ya existe en el sistema';}
			if($ndata_4 > 0) {$error['ndata_4'] = 'error/El email ya existe en el sistema';}
			/*******************************************************************/

			// si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($usuario) && $usuario!=''){              $SIS_data  = "'".$usuario."'";         }else{$SIS_data  = "''";}
				if(isset($password) && $password!=''){            $SIS_data .= ",'".md5($password)."'";  }else{$SIS_data .= ",''";}
				if(isset($idTipoUsuario) && $idTipoUsuario!=''){  $SIS_data .= ",'".$idTipoUsuario."'";  }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){            $SIS_data .= ",'".$idEstado."'";       }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                  $SIS_data .= ",'".$email."'";          }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                $SIS_data .= ",'".$Nombre."'";         }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                      $SIS_data .= ",'".$Rut."'";            }else{$SIS_data .= ",''";}
				if(isset($fNacimiento) && $fNacimiento!=''){      $SIS_data .= ",'".$fNacimiento."'";    }else{$SIS_data .= ",''";}
				if(isset($Fono) && $Fono!=''){                    $SIS_data .= ",'".$Fono."'";           }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){            $SIS_data .= ",'".$idCiudad."'";       }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){            $SIS_data .= ",'".$idComuna."'";       }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){          $SIS_data .= ",'".$Direccion."'";      }else{$SIS_data .= ",''";}
				if(isset($Direccion_img) && $Direccion_img!=''){  $SIS_data .= ",'".$Direccion_img."'";  }else{$SIS_data .= ",''";}
				if(isset($Ultimo_acceso) && $Ultimo_acceso!=''){  $SIS_data .= ",'".$Ultimo_acceso."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'usuario, password, idTipoUsuario, idEstado, email,
				Nombre,Rut, fNacimiento, Fono, idCiudad, idComuna, Direccion, Direccion_img, Ultimo_acceso';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					//Se genera el permiso relacionado al sistema
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";   }else{$SIS_data  = "''";}
					if(isset($idSistema) && $idSistema!=''){    $SIS_data .= ",'".$idSistema."'";  }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idUsuario, idSistema';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_sistemas',$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id2!=0){

						//Consulto el sistema que esta usando
						$rowData = db_select_data (false, 'idOpcionesGen_7', 'core_sistemas','', 'idSistema = "'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//si tiene la interfaz de crosstech
						if(isset($rowData['idOpcionesGen_7'])&&$rowData['idOpcionesGen_7']==6){
							//logo de la compañia
							$login_logo  = DB_SITE_MAIN.'/img/round_logo.png';
							$file_logo   = 'img/round_logo.png';

							//solo si existe
							if (file_exists($file_logo)){
								//envio de correo
								try {

									//se consulta el correo
									$rowusr = db_select_data (false, 'Nombre,email_principal', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Se crea el cuerpo
									$BodyMail  = '
									<div style="background-color: #eef2f5;">
										<div style="background-color:transparent">
											<div style="margin:0 auto;min-width:320px;max-width:600px;height:50px;"></div>
										</div>
										<div style="background-color:transparent">
											<div style="margin:0 auto;min-width:320px;max-width:600px;background-color: #1649e4;border-top-left-radius: 5px;border-top-right-radius: 5px;">
												<div style="width:70%;float: left;">
													<p style="font-size: 30px;color:#ffe31d;margin:50px;font-family: Arial, sans-serif;">Bienvenidos</p>
												</div>
												<div style="width:30%;float: left;" align="center">
													<div style="padding:24px;">
														<img src="'.$login_logo.'" alt="" style="width: 100%; max-width: 200px; height: auto; margin: auto; display: block;">
													</div>
												</div>
												<div style="clear: both;"></div>
											</div>
										</div>
										<div style="background-color:transparent">
											<div style="margin:0 auto;min-width:320px;max-width:600px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;background-color:#ffffff;">
												<div style="padding:24px;">
													<p style="font-size: 12px;color:#1649e4;font-family: Arial, sans-serif;">
														¡Hola '.$Nombre.'!<br/><br/>
														Es un placer darte la bienvenida a nuestro servicio. En '.$rowusr['Nombre'].', entendemos que
														cada cliente es único, y estamos emocionados de tener la oportunidad de
														personalizar su experiencia para satisfacer sus necesidades específicas.<br/><br/>
														Mediante este correo te dejamos tus datos de acceso a nuestra plataforma de
														gestión.<br/><br/>
														Acceso: <a href="'.DB_SITE_MAIN.'" style="text-decoration: none;color: #004AAD;">Ingresar</a><br/>
														Nombre Usuario: '.$usuario.'<br/>
														Password: 1234 (el sistema te pedira cambiarla una vez iniciada sesion por primera vez.)<br/><br/>
														Nuevamente te damos la bienvenida a '.$rowusr['Nombre'].'.<br/><br/>
														Saludos,<br/><br/>
														Equipo '.$rowusr['Nombre'].'
													</p>
													<div style="clear: both;"></div>
												</div>
											</div>
										</div>
										<div style="background-color:transparent">
											<div style="margin:0 auto;min-width:320px;max-width:600px;height:50px;"></div>
										</div>
									</div>';

									$rmail = tareas_envio_correo($rowusr['email_principal'], '1Tek',
																 $email, $Nombre,
																 '', '',
																 'Registro de Usuario',
																 $BodyMail,'',
																 '',
																 1,
																 '', '');
									//se guarda el log
									log_response(1, $rmail, $email.' (Asunto:Registro de Usuario)');

								}catch (Exception $e) {
									php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'error de registro:'.$e->getMessage(), '' );
								}

							}else{
								php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'logo no existe ('.$login_logo.')', '' );
							}
						}

						//redirijo
						header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
						die;
					}

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
			$ndata_4 = 0;
			$ndata_5 = 1;
			//Se verifica si el dato existe
			if(isset($usuario)){
				$ndata_1 = db_select_nrows (false, 'usuario', 'usuarios_listado', '', "usuario='".$usuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Nombre, $idUsuario)){
				$ndata_2 = db_select_nrows (false, 'Nombre', 'usuarios_listado', '', "Nombre='".$Nombre."' AND idUsuario!='".$idUsuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idUsuario)){
				$ndata_3 = db_select_nrows (false, 'Rut', 'usuarios_listado', '', "Rut='".$Rut."' AND idUsuario!='".$idUsuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email, $idUsuario)){
				$ndata_4 = db_select_nrows (false, 'email', 'usuarios_listado', '', "email='".$email."' AND idUsuario!='".$idUsuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($oldpassword, $idUsuario)){
				$ndata_5 = db_select_nrows (false, 'password', 'usuarios_listado', '', "idUsuario='".$idUsuario."' AND password='".md5($oldpassword)."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de usuario ingresado ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El nombre de la persona ingresada ya existe';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El Rut ya ya existe en el sistema';}
			if($ndata_4 > 0) {$error['ndata_4'] = 'error/El email ya existe en el sistema';}
			if($ndata_5 == 0) {$error['ndata_5'] = 'error/Las contraseñas ingresadas no coinciden';}
			/*******************************************************************/

			// si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idUsuario='".$idUsuario."'";
				if(isset($usuario) && $usuario!=''){              $SIS_data .= ",usuario='".$usuario."'";}
				if(isset($password) && $password!=''){            $SIS_data .= ",password='".md5($password)."'";}
				if(isset($idTipoUsuario) && $idTipoUsuario!=''){  $SIS_data .= ",idTipoUsuario='".$idTipoUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){            $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($email) && $email!=''){                  $SIS_data .= ",email='".$email."'";}
				if(isset($Nombre) && $Nombre!=''){                $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Rut) && $Rut!=''){                      $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($fNacimiento) && $fNacimiento!=''){      $SIS_data .= ",fNacimiento='".$fNacimiento."'";}
				if(isset($Fono) && $Fono!=''){                    $SIS_data .= ",Fono='".$Fono."'";}
				if(isset($idCiudad) && $idCiudad!=''){            $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){            $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){          $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Direccion_img) && $Direccion_img!=''){  $SIS_data .= ",Direccion_img='".$Direccion_img."'";}
				if(isset($Ultimo_acceso) && $Ultimo_acceso!=''){  $SIS_data .= ",Ultimo_acceso='".$Ultimo_acceso."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'usuarios_listado', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Si se cambia la password se actualiza el dato de session
					if(isset($password) && $password != ''&&$idUsuario==$_SESSION['usuario']['basic_data']['idUsuario']){
						$_SESSION['usuario']['basic_data']['password'] = md5($password);
					}

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
				// Se obtiene el nombre del archivo
				$rowData = db_select_data (false, 'Direccion_img', 'usuarios_listado', '', 'idUsuario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado_1 = db_delete_data (false, 'usuarios_listado', 'idUsuario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'usuarios_sistemas','idUsuario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'usuarios_permisos', 'idUsuario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

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
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idUsuario  = $_GET['id'];
			$idEstado   = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'usuarios_listado', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'prm_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$id_usuario = $_GET['id'];
			$id_permiso = $_GET['prm_add'];
			$level      = '1';

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($id_usuario, $id_permiso)&&$id_usuario!=''&&$id_permiso!=''){
				$ndata_1 = db_select_nrows (false, 'idUsuario', 'usuarios_permisos', '', "idUsuario='".$id_usuario."' AND idAdmpm='".$id_permiso."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El permiso ya fue otorgado';}
			/*******************************************************************/

			// si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($id_usuario) && $id_usuario!=''){ $SIS_data  = "'".$id_usuario."'";   }else{$SIS_data  = "''";}
				if(isset($id_permiso) && $id_permiso!=''){ $SIS_data .= ",'".$id_permiso."'";  }else{$SIS_data .= ",''";}
				if(isset($level) && $level!=''){           $SIS_data .= ",'".$level."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idUsuario, idAdmpm, level';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_permisos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'prm_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['prm_del']) OR !validaEntero($_GET['prm_del']))&&$_GET['prm_del']!=''){
				$indice = simpleDecode($_GET['prm_del'], fecha_actual());
			}else{
				$indice = $_GET['prm_del'];
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
				/**********************************************/
				//Busco la información del permiso
				$rowData = db_select_data (false, 'idUsuario, idAdmpm, level', 'usuarios_permisos', '', 'idPermisos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Datos generados
				$idUsuario        = $rowData['idUsuario'];
				$idAdmpm          = $rowData['idAdmpm'];
				$level            = $rowData['level'];
				$idUsuario_elim   = $_SESSION['usuario']['basic_data']['idUsuario'];
				$Fecha_elim       = fecha_actual();
				$Hora_elim        = hora_actual();

				//filtros
				if(isset($idUsuario) && $idUsuario!=''){            $SIS_data  = "'".$idUsuario."'";        }else{$SIS_data  = "''";}
				if(isset($idAdmpm) && $idAdmpm!=''){                $SIS_data .= ",'".$idAdmpm."'";         }else{$SIS_data .= ",''";}
				if(isset($level) && $level!=''){                    $SIS_data .= ",'".$level."'";           }else{$SIS_data .= ",''";}
				if(isset($idUsuario_elim) && $idUsuario_elim!=''){  $SIS_data .= ",'".$idUsuario_elim."'";  }else{$SIS_data .= ",''";}
				if(isset($Fecha_elim) && $Fecha_elim!=''){          $SIS_data .= ",'".$Fecha_elim."'";      }else{$SIS_data .= ",''";}
				if(isset($Hora_elim) && $Hora_elim!=''){            $SIS_data .= ",'".$Hora_elim."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idUsuario, idAdmpm, level, idUsuario_elim, Fecha_elim, Hora_elim';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_permisos_log', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/**********************************************/
					//Se elimina el permiso
					//se borran los datos
					$resultado = db_delete_data (false, 'usuarios_permisos', 'idPermisos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){

						//redirijo
						header( 'Location: '.$location.'&deleted=true' );
						die;

					}
				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}


		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'prm_cat_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verifico si se envia un entero
			if((!validarNumero($_GET['prm_cat_add']) OR !validaEntero($_GET['prm_cat_add']))&&$_GET['prm_cat_add']!=''){
				$indice = simpleDecode($_GET['prm_cat_add'], fecha_actual());
			}else{
				$indice = $_GET['prm_cat_add'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//Variable
			$errorn=0;

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

				//Variables
				$id_usuario  = $_GET['id'];
				$prm_cat     = $indice;
				$level       = '1';

				//Busco todas las transacciones relacionadas con la categoria
				$SIS_query = 'idAdmpm';
				$SIS_join  = '';
				$SIS_where = 'id_pmcat = '.$prm_cat.' AND visualizacion!=9999';
				$SIS_order = 0;
				$arrPermisos = array();
				$arrPermisos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se llaman a todos los permisos que tenga el usuario
				$SIS_query = 'idAdmpm';
				$SIS_join  = '';
				$SIS_where = 'idUsuario = '.$id_usuario;
				$SIS_order = 0;
				$arrPerUsuario = array();
				$arrPerUsuario = db_select_array (false, $SIS_query, 'usuarios_permisos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//creo variables temporales
				$BasesDatos = array();
				foreach ($arrPerUsuario as $pu) {
					$BasesDatos[$pu['idAdmpm']] = 'true';
				}

				//Inserto los permisos
				foreach ($arrPermisos as $comp) {

					//verifico si tiene el permiso
					if(isset($BasesDatos[$comp['idAdmpm']]) && $BasesDatos[$comp['idAdmpm']]=='true'){
						//nada
					//creo los permisos solo si no los tiene
					}else{
						$SIS_data  = "'".$id_usuario."'";
						$SIS_data .= ",'".$comp['idAdmpm']."'";
						$SIS_data .= ",'".$level."'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idUsuario, idAdmpm, level';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_permisos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

				}

				header( 'Location: '.$location );
				die;
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}


		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'prm_cat_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['prm_cat_del']) OR !validaEntero($_GET['prm_cat_del']))&&$_GET['prm_cat_del']!=''){
				$indice = simpleDecode($_GET['prm_cat_del'], fecha_actual());
			}else{
				$indice = $_GET['prm_cat_del'];
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
				//Variables
				$id_usuario = $_GET['id'];

				//Busco todas las transacciones relacionadas con la categoria
				$SIS_query = 'idAdmpm';
				$SIS_join  = '';
				$SIS_where = 'id_pmcat = '.$indice;
				$SIS_order = 0;
				$arrPermisos = array();
				$arrPermisos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Inserto los permisos
				foreach ($arrPermisos as $comp) {

					//Busco si el permiso fue dado
					$rowdel = db_select_data (false, 'idPermisos', 'usuarios_permisos', '', 'idUsuario = "'.$id_usuario.'" AND idAdmpm = "'.$comp['idAdmpm'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Borro el permiso si es que lo tiene
					if(isset($rowdel['idPermisos'])&&$rowdel['idPermisos']!=''){
						//se borran los datos
						$resultado = db_delete_data (false, 'usuarios_permisos', 'idPermisos = "'.$rowdel['idPermisos'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					}

				}

				header( 'Location: '.$location );
				die;
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}


		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'perm':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$level      = $_GET['mod'];
			$idPermisos = $_GET['perm'];
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "level='".$level."'";
			$resultado = db_update_data (false, $SIS_data, 'usuarios_permisos', 'idPermisos = "'.$idPermisos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				header( 'Location: '.$location );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if (!empty($_POST['idUsuario']))    $idUsuario       = $_POST['idUsuario'];

			if ($_FILES["imgLogo"]["error"] > 0){
				$error['imgLogo'] = 'error/'.uploadPHPError($_FILES["imgLogo"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'usr_img_'.$idUsuario.'_';

				if (in_array($_FILES['imgLogo']['type'], $permitidos) && $_FILES['imgLogo']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['imgLogo']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["imgLogo"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "Direccion_img='".$sufijo.$_FILES['imgLogo']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'usuarios_listado', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								//Seteo la variable de sesion si existe
								if(isset($_SESSION['usuario']['basic_data']['Direccion_img'])){
									$_SESSION['usuario']['basic_data']['Direccion_img'] = $sufijo.$_FILES['imgLogo']['name'];
								}

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['imgLogo']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['imgLogo']     = 'error/El archivo '.$_FILES['imgLogo']['name'].' ya existe';
					}
				} else {
					$error['imgLogo']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'Direccion_img', 'usuarios_listado', '', 'idUsuario = "'.$_GET['id_usuario'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'usuarios_listado', 'idUsuario = "'.$_GET['id_usuario'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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

				//Seteo la variable de sesion si existe
				if(isset($_SESSION['usuario']['basic_data']['Direccion_img'])){
					$_SESSION['usuario']['basic_data']['Direccion_img']='';
				}

				//Redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}


		break;
/*******************************************************************************************************************/
		case 'login':

			/**********************/
			//Validaciones
			if(!isset($usuario) OR $usuario==''){   return alert_post_data(4,1,1,0,'No ha ingresado el usuario.');}
			if(!isset($password) OR $password==''){ return alert_post_data(4,1,1,0,'No ha ingresado el password.');}

			/**********************/
			//Si todo esta ok
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Elimino cualquier dato de un usuario anterior
			unset($_SESSION['usuario']);

			//Variables
			$fecha          = fecha_actual();
			$hora           = hora_actual();
			$Time           = time();
			$IP_Client      = obtenerIpCliente();
			$Agent_Transp   = obtenerSistOperativo().' - '.obtenerNavegador();
			$email          = '';

			//Saneado de datos ingresados
			$usuario  = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$usuario);
			$password = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$password);

			//Se verifica si se trata de hacer fuerza bruta en el ingreso
			if (checkbrute($usuario, $email, $IP_Client, 'usuarios_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, usuario bloqueado por 2 horas';
			}

			//Si es una maquina la que esta tratando de entrar
			if((isset($fkinput1)&&$fkinput1!='') OR (isset($fkinput2)&&$fkinput2!='')){
				//muestro el error
				$error['checkbrute']  = 'error/Ingreso de maquina';

				//filtros
				if(isset($fecha) && $fecha!=''){               $SIS_data  = "'".$fecha."'";            }else{$SIS_data  = "''";}
				if(isset($hora) && $hora!=''){                 $SIS_data .= ",'".$hora."'";            }else{$SIS_data .= ",''";}
				if(isset($usuario) && $usuario!=''){           $SIS_data .= ",'".$usuario."'";         }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){               $SIS_data .= ",'".$email."'";           }else{$SIS_data .= ",''";}
				if(isset($IP_Client) && $IP_Client!=''){       $SIS_data .= ",'".$IP_Client."'";       }else{$SIS_data .= ",''";}
				if(isset($Agent_Transp) && $Agent_Transp!=''){ $SIS_data .= ",'".$Agent_Transp."'";    }else{$SIS_data .= ",''";}
				if(isset($Time) && $Time!=''){                 $SIS_data .= ",'".$Time."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_checkbrute', $dbConn, 'usuarios_checkbrute', $original, $form_trabajo);

			}

			//si no hay errores
			if(empty($error)){

				//Busco al usuario en el sistema
				$SIS_query = 'usuarios_listado.idUsuario,
				usuarios_listado.idUsuario AS ID,
				usuarios_listado.password,
				usuarios_listado.usuario,
				usuarios_listado.Nombre,
				usuarios_listado.idEstado,
				usuarios_listado.Direccion_img,
				usuarios_listado.idTipoUsuario,
				usuarios_tipos.Nombre AS Usuario_Tipo,
				core_ubicacion_ciudad.Nombre AS nombre_region,
				core_ubicacion_ciudad.Wheater AS nombre_pronostico,
				core_ubicacion_comunas.Nombre AS nombre_comuna,
				(SELECT count(idPermisoSistema) FROM usuarios_sistemas WHERE idUsuario=ID) AS COunt';
				$SIS_join = '
				LEFT JOIN `usuarios_tipos`            ON usuarios_tipos.idTipoUsuario     = usuarios_listado.idTipoUsuario
				LEFT JOIN `core_ubicacion_ciudad`     ON core_ubicacion_ciudad.idCiudad   = usuarios_listado.idCiudad
				LEFT JOIN `core_ubicacion_comunas`    ON core_ubicacion_comunas.idComuna  = usuarios_listado.idComuna';
				$SIS_where = 'usuarios_listado.usuario = "'.$usuario.'" AND usuarios_listado.password = "'.md5($password).'"';
				$rowUser = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, 'rowUser', $original, $form_trabajo);

				//Se verifca si los datos ingresados son de un usuario
				if (isset($rowUser['idUsuario'])&&$rowUser['idUsuario']!='') {

					//Busco el ultimo acceso
					$rowAcceso = db_select_data (false, 'Fecha, Hora', 'usuarios_accesos', '', 'idUsuario = "'.$rowUser['idUsuario'].'" ORDER BY idAcceso DESC', $dbConn, 'rowAcceso', $original, $form_trabajo);

					//Verifico que el usuario identificado este activo
					if($rowUser['idEstado']==1){

						/*******************************************************/
						//se actualizan los datos
						$SIS_data = "Ultimo_acceso='".$fecha."'";
						$SIS_data .= ",IP_Client='".$IP_Client."'";
						$SIS_data .= ",Agent_Transp='".$Agent_Transp."'";
						$resultado = db_update_data (false, $SIS_data, 'usuarios_listado', 'idUsuario = "'.$rowUser['idUsuario'].'"', $dbConn, 'Ultimo_acceso', $original, $form_trabajo);

						//busca si la ip del usuario ya existe
						$n_ip = db_select_nrows (false, 'idIpUsuario', 'usuarios_listado_ip', '', "IP_Client='".$IP_Client."' AND idUsuario='".$rowUser['idUsuario']."'", $dbConn, 'usuarios_listado_ip', $original, $form_trabajo);
						//si la ip no existe la guarda
						if(isset($n_ip)&&$n_ip==0){
							//filtros
							if(isset($rowUser['idUsuario']) && $rowUser['idUsuario']!=''){ $SIS_data  = "'".$rowUser['idUsuario']."'"; }else{$SIS_data  = "''";}
							if(isset($IP_Client) && $IP_Client!=''){                       $SIS_data .= ",'".$IP_Client."'";           }else{$SIS_data .= ",''";}
							if(isset($fecha) && $fecha!=''){                               $SIS_data .= ",'".$fecha."'";               }else{$SIS_data .= ",''";}
							if(isset($hora) && $hora!=''){                                 $SIS_data .= ",'".$hora."'";                }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idUsuario,IP_Client, Fecha, Hora';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_listado_ip', $dbConn, 'usuarios_listado_ip', $original, $form_trabajo);

						}

						/**************************************************************/
						//Se crean las variables con todos los datos
						$_SESSION['usuario']['basic_data']['idUsuario']          = $rowUser['idUsuario'];
						$_SESSION['usuario']['basic_data']['password']           = $rowUser['password'];
						$_SESSION['usuario']['basic_data']['usuario']            = $rowUser['usuario'];
						$_SESSION['usuario']['basic_data']['Nombre']             = DeSanitizar($rowUser['Nombre']);
						$_SESSION['usuario']['basic_data']['Direccion_img']      = $rowUser['Direccion_img'];
						$_SESSION['usuario']['basic_data']['idTipoUsuario']      = $rowUser['idTipoUsuario'];
						$_SESSION['usuario']['basic_data']['Usuario_Tipo']       = DeSanitizar($rowUser['Usuario_Tipo']);
						$_SESSION['usuario']['basic_data']['COunt']              = $rowUser['COunt'];
						$_SESSION['usuario']['basic_data']['Region']             = DeSanitizar($rowUser['nombre_region']);
						$_SESSION['usuario']['basic_data']['Pronostico']         = $rowUser['nombre_pronostico'];
						$_SESSION['usuario']['basic_data']['Comuna']             = DeSanitizar($rowUser['nombre_comuna']);

						//Verifico si existen datos
						if(isset($rowAcceso['Fecha'])&&$rowAcceso['Fecha']!=''){$_SESSION['usuario']['basic_data']['FechaLogin'] = $rowAcceso['Fecha']; }else{$_SESSION['usuario']['basic_data']['FechaLogin'] = fecha_actual();}
						if(isset($rowAcceso['Hora'])&&$rowAcceso['Hora']!=''){  $_SESSION['usuario']['basic_data']['HoraLogin']  = $rowAcceso['Hora'];  }else{$_SESSION['usuario']['basic_data']['HoraLogin']  = hora_actual();}

						//Se buscan los datos para crear el menu
						$arrMenu = array();
						//Si el usuario es un super usuario
						if($rowUser['idTipoUsuario']==1){
							//se traen todos los permisos existentes
							$SIS_query = '
							core_permisos_categorias.Nombre AS CategoriaNombre,
							core_font_awesome.Codigo AS CategoriaIcono,
							core_permisos_categorias.IconColor AS CategoriaIconoColor,
							core_permisos_listado.Direccionbase AS TransaccionURLBase,
							core_permisos_listado.Direccionweb AS TransaccionURL,
							core_permisos_listado.Nombre AS TransaccionNombre,
							core_permisos_listado.visualizacion AS idSistema';
							$SIS_join  = '
							INNER JOIN core_permisos_categorias  ON core_permisos_categorias.id_pmcat  = core_permisos_listado.id_pmcat
							LEFT JOIN `core_font_awesome`        ON core_font_awesome.idFont           = core_permisos_categorias.idFont';
							$SIS_where = '';
							$SIS_order = 'CategoriaNombre ASC, TransaccionNombre ASC';
							$arrMenu = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'core_permisos_listado', $original, $form_trabajo);

						//Si el usuario es un usuario normal
						}else{
							$SIS_query = '
							core_permisos_categorias.Nombre AS CategoriaNombre,
							core_font_awesome.Codigo AS CategoriaIcono,
							core_permisos_categorias.IconColor AS CategoriaIconoColor,
							core_permisos_listado.Direccionbase AS TransaccionURLBase,
							core_permisos_listado.Direccionweb AS TransaccionURL,
							core_permisos_listado.Nombre AS TransaccionNombre,
							usuarios_permisos.level,
							core_permisos_listado.visualizacion AS idSistema';
							$SIS_join  = '
							INNER JOIN core_permisos_listado      ON core_permisos_listado.idAdmpm        = usuarios_permisos.idAdmpm
							INNER JOIN core_permisos_categorias   ON core_permisos_categorias.id_pmcat    = core_permisos_listado.id_pmcat
							LEFT JOIN `core_font_awesome`         ON core_font_awesome.idFont             = core_permisos_categorias.idFont';
							$SIS_where = 'usuarios_permisos.idUsuario = '.$rowUser['idUsuario'];
							$SIS_order = 'CategoriaNombre ASC, TransaccionNombre ASC';
							$arrMenu = db_select_array (false, $SIS_query, 'usuarios_permisos', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'usuarios_permisos', $original, $form_trabajo);

						}

						//Permisos
						foreach($arrMenu as $menu) {
							$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['CategoriaNombre']     = $menu['CategoriaNombre'];
							$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['CategoriaIcono']      = $menu['TransaccionURL'];
							$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['TransaccionNombre']   = $menu['TransaccionNombre'];
							//Si es un superadmin se resetean los permisos al maximo
							if($rowUser['idTipoUsuario']==1){
								$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['level']   = 4;
							//Si no es superadmin, se heredan de la base de datos
							}else{
								$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['level']   = $menu['level'];
							}
						}

						//Construccion de los menus del sistema
						//llamamos a la función para filtrar los datos
						filtrar($arrMenu, 'CategoriaNombre');
						/******************************************************************/
						//recorremos el array para imprimirlo con formato HTML
						foreach($arrMenu as $Categorias=>$Transacciones) {

							$ntranx = 0;
							// recorremos los productos
							foreach($Transacciones as $transaccion) {

								$_SESSION['usuario']['menu'][$Categorias][$ntranx]['CategoriaNombre']         = $Categorias;
								$_SESSION['usuario']['menu'][$Categorias][$ntranx]['CategoriaIcono']          = $transaccion['CategoriaIcono'];
								$_SESSION['usuario']['menu'][$Categorias][$ntranx]['CategoriaIconoColor']     = $transaccion['CategoriaIconoColor'];
								$_SESSION['usuario']['menu'][$Categorias][$ntranx]['TransaccionURL']          = $transaccion['TransaccionURL'];
								$_SESSION['usuario']['menu'][$Categorias][$ntranx]['TransaccionNombre']       = $transaccion['TransaccionNombre'];
								$_SESSION['usuario']['menu'][$Categorias][$ntranx]['idSistema']               = $transaccion['idSistema'];

								$ntranx++;
							}

						}

						//Si el usuario es un super usuario
						if($rowUser['idTipoUsuario']==1){

							//Redirijo a la pagina de seleccion
							header( 'Location: index_select.php' );
							die;

						//Si el usuario es un usuario normal
						}else{

							/******************************************************************/
							//Verifico la cantidad de sistemas a la cual tiene permitido el acceso
							$rowSis = db_select_data (false, 'COUNT(idPermisoSistema) AS Sistemas', 'usuarios_sistemas','LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema  = usuarios_sistemas.idSistema', 'usuarios_sistemas.idUsuario = "'.$rowUser['idUsuario'].'" AND core_sistemas.idEstado=1', $dbConn, 'rowSis', $original, $form_trabajo);

							//Si no tiene sistemas relacionados
							if(isset($rowSis['Sistemas'])&&$rowSis['Sistemas']==0){
								$error['idUsuario']   = 'error/No tiene sistemas asignados, Contactese con el administrador y solicite el acceso';

							//Si tiene solo un sistema asignado
							}elseif(isset($rowSis['Sistemas'])&&$rowSis['Sistemas']==1){

								/******************************************************************/
								//Verifico el sistema que tiene acceso
								$rowAccs = db_select_data (false, 'usuarios_sistemas.idSistema', 'usuarios_sistemas','LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema  = usuarios_sistemas.idSistema', 'usuarios_sistemas.idUsuario = "'.$rowUser['idUsuario'].'" AND core_sistemas.idEstado=1', $dbConn, 'rowAccs', $original, $form_trabajo);

								//filtros
								if(isset($rowUser['idUsuario']) && $rowUser['idUsuario']!=''){  $SIS_data  = "'".$rowUser['idUsuario']."'";   }else{$SIS_data  = "''";}
								if(isset($fecha) && $fecha!=''){                                $SIS_data .= ",'".$fecha."'";                 }else{$SIS_data .= ",''";}
								if(isset($hora) && $hora!=''){                                  $SIS_data .= ",'".$hora."'";                  }else{$SIS_data .= ",''";}
								if(isset($IP_Client) && $IP_Client!=''){                        $SIS_data .= ",'".$IP_Client."'";             }else{$SIS_data .= ",''";}
								if(isset($Agent_Transp) && $Agent_Transp!=''){                  $SIS_data .= ",'".$Agent_Transp."'";          }else{$SIS_data .= ",''";}
								if(isset($rowAccs['idSistema']) && $rowAccs['idSistema']!=''){  $SIS_data .= ",'".$rowAccs['idSistema']."'";  }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idUsuario,Fecha, Hora, IP_Client, Agent_Transp, idSistema';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_accesos', $dbConn, 'usuarios_accesos', $original, $form_trabajo);

								/******************************************************************/
								//Verifico la cantidad de sistemas a la cual tiene permitido el acceso
								$rowSystem = db_select_data (false, 'usuarios_sistemas.idSistema', 'usuarios_sistemas','LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema  = usuarios_sistemas.idSistema', 'usuarios_sistemas.idUsuario = "'.$rowUser['idUsuario'].'" AND core_sistemas.idEstado=1', $dbConn, 'rowSystem', $original, $form_trabajo);

								//resto de los datos
								$SIS_query = 'core_sistemas.Config_idTheme,
								core_sistemas.Config_imgLogo,
								core_sistemas.Config_IDGoogle,
								core_sistemas.idOpcionesGen_8,
								core_sistemas.idOpcionesGen_7,
								core_sistemas.Nombre AS RazonSocial,
								core_config_ram.Nombre AS ConfigRam,
								core_config_time.Nombre AS ConfigTime,
								core_sistemas.Social_idUso,
								core_sistemas.Social_facebook,
								core_sistemas.Social_twitter,
								core_sistemas.Social_instagram,
								core_sistemas.Social_linkedin,
								core_sistemas.Social_rss,
								core_sistemas.Social_youtube,
								core_sistemas.Social_tumblr';
								$SIS_join = '
								LEFT JOIN `core_config_ram`   ON core_config_ram.idConfigRam    = core_sistemas.idConfigRam
								LEFT JOIN `core_config_time`  ON core_config_time.idConfigTime  = core_sistemas.idConfigTime';
								$rowSistema = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, 'core_sistemas.idSistema = "'.$rowSystem['idSistema'].'"', $dbConn, 'rowSistema', $original, $form_trabajo);

								//Se crean las variables con todos los datos
								$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowSistema['Config_idTheme'];
								$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowSistema['Config_imgLogo'];
								$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowSistema['Config_IDGoogle'];
								$_SESSION['usuario']['basic_data']['RazonSocial']        = DeSanitizar($rowSistema['RazonSocial']);
								$_SESSION['usuario']['basic_data']['ConfigRam']          = $rowSistema['ConfigRam'];
								$_SESSION['usuario']['basic_data']['ConfigTime']         = $rowSistema['ConfigTime'];
								$_SESSION['usuario']['basic_data']['CorreoInterno']      = $rowSistema['idOpcionesGen_8'];
								$_SESSION['usuario']['basic_data']['idInterfaz']         = $rowSistema['idOpcionesGen_7'];
								$_SESSION['usuario']['basic_data']['idSistema']          = $rowSystem['idSistema'];
								$_SESSION['usuario']['basic_data']['Social_idUso']       = $rowSistema['Social_idUso'];
								$_SESSION['usuario']['basic_data']['Social_facebook']    = $rowSistema['Social_facebook'];
								$_SESSION['usuario']['basic_data']['Social_twitter']     = $rowSistema['Social_twitter'];
								$_SESSION['usuario']['basic_data']['Social_instagram']   = $rowSistema['Social_instagram'];
								$_SESSION['usuario']['basic_data']['Social_linkedin']    = $rowSistema['Social_linkedin'];
								$_SESSION['usuario']['basic_data']['Social_rss']         = $rowSistema['Social_rss'];
								$_SESSION['usuario']['basic_data']['Social_youtube']     = $rowSistema['Social_youtube'];
								$_SESSION['usuario']['basic_data']['Social_tumblr']      = $rowSistema['Social_tumblr'];

								//Redirijo a la pagina principal
								header( 'Location: principal.php' );
								die;

							//Si tiene mas de uno, se redirije a una pantalla de seleccion
							}elseif(isset($rowSis['Sistemas'])&&$rowSis['Sistemas']>1){
								//Redirijo a la pagina de seleccion
								header( 'Location: index_select.php' );
								die;
							}

						}

					//Si no esta activo envio error
					}else{
						$error['idUsuario']   = 'error/Su usuario esta desactivado, Contactese con el administrador';
					}

				//Si no se encuentra ningun usuario se envia un error
				}else{
					$error['idUsuario']   = 'error/El nombre de usuario o contraseña no coinciden';

					//filtros
					if(isset($fecha) && $fecha!=''){               $SIS_data  = "'".$fecha."'";            }else{$SIS_data  = "''";}
					if(isset($hora) && $hora!=''){                 $SIS_data .= ",'".$hora."'";            }else{$SIS_data .= ",''";}
					if(isset($usuario) && $usuario!=''){           $SIS_data .= ",'".$usuario."'";         }else{$SIS_data .= ",''";}
					if(isset($email) && $email!=''){               $SIS_data .= ",'".$email."'";           }else{$SIS_data .= ",''";}
					if(isset($IP_Client) && $IP_Client!=''){       $SIS_data .= ",'".$IP_Client."'";       }else{$SIS_data .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp!=''){ $SIS_data .= ",'".$Agent_Transp."'";    }else{$SIS_data .= ",''";}
					if(isset($Time) && $Time!=''){                 $SIS_data .= ",'".$Time."'";            }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_checkbrute', $dbConn, 'usuarios_checkbrute', $original, $form_trabajo);

					//Cuento los accesos erroneos
					$NAccesos = db_select_nrows (false, 'idAcceso', 'usuarios_checkbrute', '', "(usuario='".$usuario."' OR email='".$email."' OR IP_Client='".$IP_Client."') AND Fecha='".fecha_actual()."'", $dbConn, 'productores_checkbrute', $original, $form_trabajo);

				}

			}
		break;
/*******************************************************************************************************************/
		case 'select_sistema':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se eliminan todas las sesiones
			unset($_SESSION['receta']);
			unset($_SESSION['receta_productos']);

			unset($_SESSION['arriendos_ing_basicos']);
			unset($_SESSION['arriendos_ing_productos']);
			unset($_SESSION['arriendos_ing_impuestos']);
			unset($_SESSION['arriendos_ing_archivos']);
			unset($_SESSION['arriendos_ing_descuentos']);
			unset($_SESSION['arriendos_ing_guias']);

			unset($_SESSION['insumos_ing_basicos']);
			unset($_SESSION['insumos_ing_productos']);
			unset($_SESSION['insumos_ing_temporal']);
			unset($_SESSION['insumos_ing_guias']);
			unset($_SESSION['insumos_ing_impuestos']);
			unset($_SESSION['insumos_ing_archivos']);
			unset($_SESSION['insumos_ing_descuentos']);

			unset($_SESSION['productos_ing_basicos']);
			unset($_SESSION['productos_ing_productos']);
			unset($_SESSION['productos_ing_temporal']);
			unset($_SESSION['productos_ing_guias']);
			unset($_SESSION['productos_ing_impuestos']);
			unset($_SESSION['productos_ing_archivos']);
			unset($_SESSION['productos_ing_descuentos']);

			unset($_SESSION['servicios_ing_basicos']);
			unset($_SESSION['servicios_ing_productos']);
			unset($_SESSION['servicios_ing_temporal']);
			unset($_SESSION['servicios_ing_impuestos']);
			unset($_SESSION['servicios_ing_archivos']);
			unset($_SESSION['servicios_ing_descuentos']);
			unset($_SESSION['servicios_ing_guias']);

			unset($_SESSION['boleta_ing_basicos']);
			unset($_SESSION['boleta_ing_servicios']);
			unset($_SESSION['boleta_ing_temporal']);
			unset($_SESSION['boleta_ing_archivos']);

			unset($_SESSION['caja_ing_basicos']);
			unset($_SESSION['caja_ing_documentos']);
			unset($_SESSION['caja_ing_temporal']);
			unset($_SESSION['caja_ing_archivos']);

			unset($_SESSION['cotizacion_basicos']);
			unset($_SESSION['cotizacion_arriendos']);
			unset($_SESSION['cotizacion_insumos']);
			unset($_SESSION['cotizacion_productos']);
			unset($_SESSION['cotizacion_servicios']);
			unset($_SESSION['cotizacion_temporal']);
			unset($_SESSION['cotizacion_archivos']);

			unset($_SESSION['cotizacion_prospectos_basicos']);
			unset($_SESSION['cotizacion_prospectos_arriendos']);
			unset($_SESSION['cotizacion_prospectos_insumos']);
			unset($_SESSION['cotizacion_prospectos_productos']);
			unset($_SESSION['cotizacion_prospectos_servicios']);
			unset($_SESSION['cotizacion_prospectos_temporal']);
			unset($_SESSION['cotizacion_prospectos_archivos']);

			unset($_SESSION['cross_quality_ana_cali_basicos']);
			unset($_SESSION['cross_quality_ana_cali_muestras']);
			unset($_SESSION['cross_quality_ana_cali_maquinas']);
			unset($_SESSION['cross_quality_ana_cali_trabajadores']);
			unset($_SESSION['cross_quality_ana_cali_archivos']);
			unset($_SESSION['cross_quality_ana_cali_temporal']);

			unset($_SESSION['cross_quality_reg_insp_basicos']);
			unset($_SESSION['cross_quality_reg_insp_muestras']);
			unset($_SESSION['cross_quality_reg_insp_maquinas']);
			unset($_SESSION['cross_quality_reg_insp_trabajadores']);
			unset($_SESSION['cross_quality_reg_insp_archivos']);
			unset($_SESSION['cross_quality_reg_insp_temporal']);

			unset($_SESSION['cross_shipping_consolidacion_basicos']);
			unset($_SESSION['cross_shipping_consolidacion_estibas']);
			unset($_SESSION['cross_shipping_consolidacion_archivos']);
			unset($_SESSION['cross_shipping_consolidacion_temporal']);

			unset($_SESSION['sol_apli_basicos']);
			unset($_SESSION['sol_apli_cuarteles']);
			unset($_SESSION['sol_apli_tractores']);
			unset($_SESSION['sol_apli_productos']);
			unset($_SESSION['sol_apli_temporal']);

			unset($_SESSION['ocompra_basicos']);
			unset($_SESSION['ocompra_arriendos']);
			unset($_SESSION['ocompra_insumos']);
			unset($_SESSION['ocompra_productos']);
			unset($_SESSION['ocompra_servicios']);
			unset($_SESSION['ocompra_temporal']);
			unset($_SESSION['ocompra_documentos']);
			unset($_SESSION['ocompra_otros']);
			unset($_SESSION['ocompra_sol_rel']);
			unset($_SESSION['ocompra_archivos']);

			unset($_SESSION['ot_basicos']);
			unset($_SESSION['ot_trabajador']);
			unset($_SESSION['ot_trabajos']);
			unset($_SESSION['ot_temporal']);
			unset($_SESSION['ot_insumos']);
			unset($_SESSION['ot_productos']);

			unset($_SESSION['pagos_boletas_clientes']);
			unset($_SESSION['pagos_boletas_trabajadores']);

			unset($_SESSION['pago_clientes_insumos']);
			unset($_SESSION['pago_clientes_productos']);
			unset($_SESSION['pago_clientes_arriendo']);
			unset($_SESSION['pago_clientes_servicio']);

			unset($_SESSION['pago_proveedor_insumos']);
			unset($_SESSION['pago_proveedor_productos']);
			unset($_SESSION['pago_proveedor_arriendo']);
			unset($_SESSION['pago_proveedor_servicio']);

			unset($_SESSION['fact_sueldos_basicos']);
			unset($_SESSION['fact_sueldos_sueldos']);
			unset($_SESSION['fact_sueldos_temporal']);
			unset($_SESSION['fact_sueldos_archivos']);

			unset($_SESSION['solicitud_basicos']);
			unset($_SESSION['solicitud_arriendos']);
			unset($_SESSION['solicitud_insumos']);
			unset($_SESSION['solicitud_otros']);
			unset($_SESSION['solicitud_productos']);
			unset($_SESSION['solicitud_servicios']);
			unset($_SESSION['solicitud_temporal']);

			unset($_SESSION['desc_cuotas_basicos']);
			unset($_SESSION['desc_cuotas_listado']);
			unset($_SESSION['desc_cuotas_temporal']);
			unset($_SESSION['desc_cuotas_archivos']);

			unset($_SESSION['horas_extras_ing_basicos']);
			unset($_SESSION['horas_extras_ing_horas']);
			unset($_SESSION['horas_extras_ing_temporal']);
			unset($_SESSION['horas_extras_ing_archivos']);
			unset($_SESSION['horas_extras_mens_ing_horas']);

			unset($_SESSION['horas_extras_mens_ing_basicos']);
			unset($_SESSION['horas_extras_mens_ing_horas']);
			unset($_SESSION['horas_extras_mens_ing_temporal']);
			unset($_SESSION['horas_extras_mens_ing_archivos']);

			unset($_SESSION['basicos']);
			unset($_SESSION['hijos']);

			//se verifica que el usuario exista
			if (isset($_GET['id'])&&simpleDecode($_GET['id'], fecha_actual())==$_SESSION['usuario']['basic_data']['idUsuario']) {
				//se verifica el envio de datos
				if(isset($_GET['ini'])&&$_GET['ini']!=''){

					$SIS_query = 'core_sistemas.Config_idTheme,
					core_sistemas.Config_imgLogo,
					core_sistemas.Config_IDGoogle,
					core_sistemas.idOpcionesGen_8,
					core_sistemas.idOpcionesGen_7,
					core_sistemas.Nombre AS RazonSocial,
					core_config_ram.Nombre AS ConfigRam,
					core_config_time.Nombre AS ConfigTime,
					core_sistemas.Social_idUso,
					core_sistemas.Social_facebook,
					core_sistemas.Social_twitter,
					core_sistemas.Social_instagram,
					core_sistemas.Social_linkedin,
					core_sistemas.Social_rss,
					core_sistemas.Social_youtube,
					core_sistemas.Social_tumblr';
					$SIS_join = '
					LEFT JOIN `core_config_ram`   ON core_config_ram.idConfigRam    = core_sistemas.idConfigRam
					LEFT JOIN `core_config_time`  ON core_config_time.idConfigTime  = core_sistemas.idConfigTime';
					$rowSistema = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, 'core_sistemas.idSistema = "'.simpleDecode($_GET['ini'], fecha_actual()).'"', $dbConn, 'rowSistema', $original, $form_trabajo);

					//Se crean las variables con todos los datos
					$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowSistema['Config_idTheme'];
					$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowSistema['Config_imgLogo'];
					$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowSistema['Config_IDGoogle'];
					$_SESSION['usuario']['basic_data']['RazonSocial']        = DeSanitizar($rowSistema['RazonSocial']);
					$_SESSION['usuario']['basic_data']['ConfigRam']          = $rowSistema['ConfigRam'];
					$_SESSION['usuario']['basic_data']['ConfigTime']         = $rowSistema['ConfigTime'];
					$_SESSION['usuario']['basic_data']['CorreoInterno']      = $rowSistema['idOpcionesGen_8'];
					$_SESSION['usuario']['basic_data']['idInterfaz']         = $rowSistema['idOpcionesGen_7'];
					$_SESSION['usuario']['basic_data']['idSistema']          = simpleDecode($_GET['ini'], fecha_actual());
					$_SESSION['usuario']['basic_data']['Social_idUso']       = $rowSistema['Social_idUso'];
					$_SESSION['usuario']['basic_data']['Social_facebook']    = $rowSistema['Social_facebook'];
					$_SESSION['usuario']['basic_data']['Social_twitter']     = $rowSistema['Social_twitter'];
					$_SESSION['usuario']['basic_data']['Social_instagram']   = $rowSistema['Social_instagram'];
					$_SESSION['usuario']['basic_data']['Social_linkedin']    = $rowSistema['Social_linkedin'];
					$_SESSION['usuario']['basic_data']['Social_rss']         = $rowSistema['Social_rss'];
					$_SESSION['usuario']['basic_data']['Social_youtube']     = $rowSistema['Social_youtube'];
					$_SESSION['usuario']['basic_data']['Social_tumblr']      = $rowSistema['Social_tumblr'];

					/**************************************************************/
					//variables
					$idUsuario      = $_SESSION['usuario']['basic_data']['idUsuario'];
					$Fecha          = fecha_actual();
					$Hora           = hora_actual();
					$IP_Client      = obtenerIpCliente();
					$Agent_Transp   = obtenerSistOperativo().' - '.obtenerNavegador();
					$idSistema      = simpleDecode($_GET['ini'], fecha_actual());

					//filtros
					if(isset($idUsuario) && $idUsuario!=''){       $SIS_data  = "'".$idUsuario."'";        }else{$SIS_data  = "''";}
					if(isset($Fecha) && $Fecha!=''){               $SIS_data .= ",'".$Fecha."'";           }else{$SIS_data .= ",''";}
					if(isset($Hora) && $Hora!=''){                 $SIS_data .= ",'".$Hora."'";            }else{$SIS_data .= ",''";}
					if(isset($IP_Client) && $IP_Client!=''){       $SIS_data .= ",'".$IP_Client."'";       }else{$SIS_data .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp!=''){ $SIS_data .= ",'".$Agent_Transp."'";    }else{$SIS_data .= ",''";}
					if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",'".$idSistema."'";       }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idUsuario,Fecha, Hora, IP_Client, Agent_Transp, idSistema';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_accesos', $dbConn, 'usuarios_accesos', $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//Redirijo a la pagina principal
						header( 'Location: principal.php' );
						die;
					}

				}
			}

		break;
/*******************************************************************************************************************/
		case 'getpass':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$fecha          = fecha_actual();
			$hora           = hora_actual();
			$Time           = time();
			$IP_Client      = obtenerIpCliente();
			$Agent_Transp   = obtenerSistOperativo().' - '.obtenerNavegador();
			$usuario        = '';
			$password       = '';

			//Saneado de datos ingresados
			$email = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$email);

			//Se verifica si se trata de hacer fuerza bruta en el ingreso
			if (checkbrute($usuario, $email, $IP_Client, 'usuarios_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, correo bloqueado por 2 horas';
			}
			//se verifica que se haya ingresado el correo
			if(!isset($email) OR $email==''){
				$error['email']  = 'error/No ha ingresado un correo';
			}

			//Si es una maquina la que esta tratando de entrar
			if((isset($fkinput1)&&$fkinput1!='') OR (isset($fkinput2)&&$fkinput2!='')){
				//muestro el error
				$error['checkbrute']  = 'error/Ingreso de maquina';

				//filtros
				if(isset($fecha) && $fecha!=''){               $SIS_data  = "'".$fecha."'";            }else{$SIS_data  = "''";}
				if(isset($hora) && $hora!=''){                 $SIS_data .= ",'".$hora."'";            }else{$SIS_data .= ",''";}
				if(isset($usuario) && $usuario!=''){           $SIS_data .= ",'".$usuario."'";         }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){               $SIS_data .= ",'".$email."'";           }else{$SIS_data .= ",''";}
				if(isset($IP_Client) && $IP_Client!=''){       $SIS_data .= ",'".$IP_Client."'";       }else{$SIS_data .= ",''";}
				if(isset($Agent_Transp) && $Agent_Transp!=''){ $SIS_data .= ",'".$Agent_Transp."'";    }else{$SIS_data .= ",''";}
				if(isset($Time) && $Time!=''){                 $SIS_data .= ",'".$Time."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_checkbrute', $dbConn, 'usuarios_checkbrute', $original, $form_trabajo);

			}

			// si no hay errores ejecuto el codigo
			if(empty($error)){

				//traigo los datos almacenados
				$cuenta_registros = db_select_nrows (false, 'email', 'usuarios_listado', '', 'email = "'.$email.'"', $dbConn, 'cuenta_registros', $original, $form_trabajo);

				//verifico si los datos ingresados son iguales a los almacenados
				if(isset($cuenta_registros)&&$cuenta_registros!=''&&$cuenta_registros!=0){

					/*******************************************************/
					//traigo los datos almacenados
					$rowUsr = db_select_data (false, 'idUsuario, Nombre, usuario, email, Fono', 'usuarios_listado', '', 'email = "'.$email.'"', $dbConn, 'rowUsr', $original, $form_trabajo);
					$SIS_query = '
					core_sistemas.Nombre,
					core_sistemas.email_principal,
					core_sistemas.Config_Gmail_Usuario      AS Gmail_Usuario,
					core_sistemas.Config_Gmail_Password     AS Gmail_Password,
					core_sistemas.Config_WhatsappToken      AS SistemaWhatsappToken,
					core_sistemas.Config_WhatsappInstanceId AS SistemaWhatsappInstanceId';
					$SIS_join  = '';
					$SIS_where = 'idSistema=1';
					$rowSistema = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, 'rowSistema', $original, $form_trabajo);

					/*******************************************************/
					//Generacion de nueva clave
					$num_caracteres = "10";                                  //cantidad de caracteres de la clave
					$clave          = substr(md5(rand()),0,$num_caracteres); //generador aleatorio de claves
					$nueva_clave    = md5($clave);                           //se codifica la clave

					/*******************************************************/
					//se actualizan los datos
					$SIS_data  = "password='".$nueva_clave."'";
					$resultado = db_update_data (false, $SIS_data, 'usuarios_listado', 'idUsuario = "'.$rowUsr['idUsuario'].'"', $dbConn, 'usuarios_listado', $original, $form_trabajo);

					/*******************************************************/
					//Cuerpo del correo
					$Body = 'Se ha generado una nueva contraseña para el usuario '.$rowUsr['usuario'].', su nueva contraseña es: '.$clave;

					/*******************************************************/
					//Envio de whatsapp
					if(isset($rowUsr['Fono'])&&$rowUsr['Fono']!=''){
						//Se arma
						$Body['Phone']      = $rowUsr['Fono'];
						$Body['Usuario']    = $rowUsr['usuario'];
						$Body['Password']   = $clave;
						//se intenta enviar la notificacion
						try {
							//envio notificacion
							WhatsappSendTemplate($rowSistema['SistemaWhatsappToken'], $rowSistema['SistemaWhatsappInstanceId'], 1, $Body);
							//se guarda el log
							log_response(1, 'Envio Correcto->'.$rowUsr['Fono'], $Body);
							//se entrega noti
							$error['email'] = 'sucess/La nueva contraseña fue enviada a tu correo';
						} catch (Exception $e) {
							//se guarda el log
							log_response(1, 'Envio Noti Whatsapp Fallido->'.$e->getMessage(), $Body);
							//se entrega noti
							$error['email'] = 'error/Envio Noti Whatsapp Fallido';
						}

					/*******************************************************/
					//Envio de correo
					}else{
						$rmail = tareas_envio_correo($rowSistema['email_principal'], $rowSistema['Nombre'],
													$rowUsr['email'], $rowUsr['Nombre'],
													'', '',
													'Cambio de password',
													'<p>'.$Body.'</p>','',
													'',
													1,
													$rowSistema['Gmail_Usuario'],
													$rowSistema['Gmail_Password']);
						//se guarda el log
						log_response(1, $rmail, $rowUsr['email'].' (Asunto:Cambio de password)');

						//Envio del mensaje
						if ($rmail!=1) {
							$error['email'] = 'error/'.$rmail;
						} else {
							$error['email'] = 'sucess/La nueva contraseña fue enviada a tu correo';
						}
					}

				//Si no se encuentra ningun usuario se envia un error
				}else{
					$error['email'] 	  = 'error/El email ingresado no existe';

					//filtros
					if(isset($fecha) && $fecha!=''){               $SIS_data  = "'".$fecha."'";            }else{$SIS_data  = "''";}
					if(isset($hora) && $hora!=''){                 $SIS_data .= ",'".$hora."'";            }else{$SIS_data .= ",''";}
					if(isset($usuario) && $usuario!=''){           $SIS_data .= ",'".$usuario."'";         }else{$SIS_data .= ",''";}
					if(isset($email) && $email!=''){               $SIS_data .= ",'".$email."'";           }else{$SIS_data .= ",''";}
					if(isset($IP_Client) && $IP_Client!=''){       $SIS_data .= ",'".$IP_Client."'";       }else{$SIS_data .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp!=''){ $SIS_data .= ",'".$Agent_Transp."'";    }else{$SIS_data .= ",''";}
					if(isset($Time) && $Time!=''){                 $SIS_data .= ",'".$Time."'";            }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_checkbrute', $dbConn, 'usuarios_checkbrute', $original, $form_trabajo);

				}

			}

		break;
/*******************************************************************************************************************/
		//se clona al usuario
		case 'clone_Usuario':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($usuario)){
				$ndata_1 = db_select_nrows (false, 'usuario', 'usuarios_listado', '', "usuario='".$usuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			/*if(isset($email, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'email', 'usuarios_listado', '', "email='".$email."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}*/
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de usuario ingresado ya existe';}
			/*if($ndata_2 > 0) {$error['ndata_4'] = 'error/El email ya existe en el sistema';}*/
			/*******************************************************************/

			// si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************************/
				//Consultas
				//Datos
				$rowusr = db_select_data (false, 'idTipoUsuario, Nombre,Rut, fNacimiento, Fono, idCiudad, idComuna, Direccion', 'usuarios_listado', '', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//sistemas asignados
				$SIS_query = 'idSistema';
				$SIS_join  = '';
				$SIS_where = 'idUsuario='.$idUsuario;
				$SIS_order = 0;
				$arrSistemas = array();
				$arrSistemas = db_select_array (false, $SIS_query, 'usuarios_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Permisos asignados
				$SIS_query = 'idAdmpm, level';
				$SIS_join  = '';
				$SIS_where = 'idUsuario='.$idUsuario;
				$SIS_order = 0;
				$arrPermisos = array();
				$arrPermisos = db_select_array (false, $SIS_query, 'usuarios_permisos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				//Variables
				$password        = 1234;
				$idEstado        = 1;

				//si no existen se crean desde el usuario copiado
				if(!isset($idTipoUsuario)){  $idTipoUsuario   = $rowusr['idTipoUsuario'];}
				if(!isset($Nombre)){         $Nombre          = $rowusr['Nombre'];}
				if(!isset($Fono)){           $Fono            = $rowusr['Fono'];}
				if(!isset($Rut)){            $Rut             = $rowusr['Rut'];}
				if(!isset($fNacimiento)){    $fNacimiento     = $rowusr['fNacimiento'];}
				if(!isset($idCiudad)){       $idCiudad        = $rowusr['idCiudad'];}
				if(!isset($idComuna)){       $idComuna        = $rowusr['idComuna'];}
				if(!isset($Direccion)){      $Direccion       = $rowusr['Direccion'];}

				/*******************************************************************/
				/*******************************************************************/
				//filtros
				if(isset($usuario) && $usuario!=''){              $SIS_data  = "'".$usuario."'";         }else{$SIS_data  = "''";}
				if(isset($password) && $password!=''){            $SIS_data .= ",'".md5($password)."'";  }else{$SIS_data .= ",''";}
				if(isset($idTipoUsuario) && $idTipoUsuario!=''){  $SIS_data .= ",'".$idTipoUsuario."'";  }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){            $SIS_data .= ",'".$idEstado."'";       }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                  $SIS_data .= ",'".$email."'";          }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                $SIS_data .= ",'".$Nombre."'";         }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                      $SIS_data .= ",'".$Rut."'";            }else{$SIS_data .= ",''";}
				if(isset($fNacimiento) && $fNacimiento!=''){      $SIS_data .= ",'".$fNacimiento."'";    }else{$SIS_data .= ",''";}
				if(isset($Fono) && $Fono!=''){                    $SIS_data .= ",'".$Fono."'";           }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){            $SIS_data .= ",'".$idCiudad."'";       }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){            $SIS_data .= ",'".$idComuna."'";       }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){          $SIS_data .= ",'".$Direccion."'";      }else{$SIS_data .= ",''";}
				if(isset($Direccion_img) && $Direccion_img!=''){  $SIS_data .= ",'".$Direccion_img."'";  }else{$SIS_data .= ",''";}
				if(isset($Ultimo_acceso) && $Ultimo_acceso!=''){  $SIS_data .= ",'".$Ultimo_acceso."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'usuario, password, idTipoUsuario, idEstado, email,
				Nombre,Rut, fNacimiento, Fono, idCiudad, idComuna, Direccion, Direccion_img, Ultimo_acceso';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					/*******************************************************************/
					/*******************************************************************/
					//Se copian los sistemas
					foreach ($arrSistemas as $sis) {
						//Variables
						$idUsuario  = $ultimo_id;
						$idSistema  = $sis['idSistema'];

						//filtros
						if(isset($idUsuario) && $idUsuario!=''){  $SIS_data  = "'".$idUsuario."'";  }else{$SIS_data  = "''";}
						if(isset($idSistema) && $idSistema!=''){  $SIS_data .= ",'".$idSistema."'"; }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idUsuario, idSistema';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_sistemas',$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
					/*******************************************************************/
					//Se copian los permisos
					foreach ($arrPermisos as $perm) {
						//Variables
						$idUsuario  = $ultimo_id;
						$idAdmpm    = $perm['idAdmpm'];
						$level      = $perm['level'];

						//filtros
						if(isset($idUsuario) && $idUsuario!=''){  $SIS_data  = "'".$idUsuario."'";  }else{$SIS_data  = "''";}
						if(isset($idAdmpm) && $idAdmpm!=''){      $SIS_data .= ",'".$idAdmpm."'";   }else{$SIS_data .= ",''";}
						if(isset($level) && $level!=''){          $SIS_data .= ",'".$level."'";     }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idUsuario, idAdmpm, level';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_permisos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&clone=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'equipo_tel_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['equipo_tel_add']) OR !validaEntero($_GET['equipo_tel_add']))&&$_GET['equipo_tel_add']!=''){
				$indice = simpleDecode($_GET['equipo_tel_add'], fecha_actual());
			}else{
				$indice = $_GET['equipo_tel_add'];
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

			/***************************************************************/
			if($errorn==0){
				//variables
				$id_usuario     = $_GET['id'];
				$idTelemetria   = $indice;

				/*******************************************************************/
				//variables
				$ndata_1 = 0;
				//Se verifica si el dato existe
				if(isset($idTelemetria)&&$idTelemetria!=''&&isset($id_usuario)&&$id_usuario!=''){
					$ndata_1 = db_select_nrows (false, 'idTelemetria', 'usuarios_equipos_telemetria', '', "idTelemetria='".$idTelemetria."' AND idUsuario='".$id_usuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				//generacion de errores
				if($ndata_1 > 0) {$error['ndata_1'] = 'error/El permiso al equipo ya fue otorgado';}
				/*******************************************************************/

				// si no hay errores ejecuto el codigo
				if(empty($error)){
					//filtros
					if(isset($id_usuario) && $id_usuario!=''){     $SIS_data  = "'".$id_usuario."'";     }else{$SIS_data  = "''";}
					if(isset($idTelemetria) && $idTelemetria!=''){ $SIS_data .= ",'".$idTelemetria."'";  }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idUsuario, idTelemetria';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_equipos_telemetria', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&edited=true' );
						die;
					}

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'equipo_tel_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['equipo_tel_del']) OR !validaEntero($_GET['equipo_tel_del']))&&$_GET['equipo_tel_del']!=''){
				$indice = simpleDecode($_GET['equipo_tel_del'], fecha_actual());
			}else{
				$indice = $_GET['equipo_tel_del'];
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

			/***************************************************************/
			if($errorn==0){
				//se borran los datos
				$resultado = db_delete_data (false, 'usuarios_equipos_telemetria', 'idEquipoTelPermiso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//se dan permisos al usuario
		case 'prm_add_all_tel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			/*********************************************************************************/
			//verifico si se envia un entero
			if((!validarNumero($_GET['idUsuario']) OR !validaEntero($_GET['idUsuario']))&&$_GET['idUsuario']!=''){
				$indice_1 = simpleDecode($_GET['idUsuario'], fecha_actual());
			}else{
				$indice_1 = $_GET['idUsuario'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice_1)&&$indice_1!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice_1 ('.$indice_1.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice_1)&&$indice_1!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice_1 ('.$indice_1.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			/*********************************************************************************/
			//verifico si se envia un entero
			if((!validarNumero($_GET['idSistema']) OR !validaEntero($_GET['idSistema']))&&$_GET['idSistema']!=''){
				$indice_2 = simpleDecode($_GET['idSistema'], fecha_actual());
			}else{
				$indice_2 = $_GET['idSistema'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice_2)&&$indice_2!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice_2 ('.$indice_2.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice_2)&&$indice_2!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice_2 ('.$indice_2.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			/*********************************************************************************/
			if($errorn==0){

				//Verifico permisos a las transacciones
				$SIS_query    = 'telemetria_listado.idTelemetria,(SELECT COUNT(idTelemetria) FROM usuarios_equipos_telemetria WHERE idTelemetria = telemetria_listado.idTelemetria AND idUsuario = '.$indice_1.' LIMIT 1) AS contar';
				$SIS_join     = '';
				$SIS_where    = 'telemetria_listado.idSistema = '.$indice_2.' AND telemetria_listado.idEstado=1';
				$SIS_order    = 'telemetria_listado.idSistema ASC, telemetria_listado.Nombre ASC';
				$arrPermisos = array();
				$arrPermisos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************************************************************/
				//Se entregan los permisos relacionados a los equipos
				foreach ($arrPermisos as $perm) {
					//Si no se ha entregado el permiso
					if ( $perm['contar']!='1' ) {
						//filtros
						$SIS_data  = "'".$indice_1."'";//idUsuario
						if(isset($perm['idTelemetria']) && $perm['idTelemetria']!=''){  $SIS_data .= ",'".$perm['idTelemetria']."'";  }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idUsuario, idTelemetria';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_equipos_telemetria', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}

				//redirijo
				header( 'Location: '.$location.'&created=true' );
				die;

			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//se dan permisos al usuario
		case 'prm_del_all_tel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			/*********************************************************************************/
			//verifico si se envia un entero
			if((!validarNumero($_GET['idUsuario']) OR !validaEntero($_GET['idUsuario']))&&$_GET['idUsuario']!=''){
				$indice_1 = simpleDecode($_GET['idUsuario'], fecha_actual());
			}else{
				$indice_1 = $_GET['idUsuario'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice_1)&&$indice_1!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice_1 ('.$indice_1.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice_1)&&$indice_1!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice_1 ('.$indice_1.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			/*********************************************************************************/
			if($errorn==0){
				//se borran los datos
				$resultado = db_delete_data (false, 'usuarios_equipos_telemetria', 'idUsuario = "'.$indice_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'login_alt':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$fecha          = fecha_actual();

			//si no hay errores
			if(empty($error)){

				/******************************************************************/
				//Verifico la cantidad de sistemas a la cual tiene permitido el acceso
				$rowSis = db_select_data (false, 'COUNT(idPermisoSistema) AS Sistemas', 'usuarios_sistemas','', 'idUsuario = "'.$idUsuario.'"', $dbConn, 'rowSis', $original, $form_trabajo);

				//Si no tiene sistemas relacionados
				if(isset($rowSis['Sistemas'])&&$rowSis['Sistemas']==0){
					$error['idUsuario']   = 'error/Este usuario no tiene sistemas asignados';

				//Si tiene solo un sistema asignado
				}elseif(isset($rowSis['Sistemas'])&&$rowSis['Sistemas']!=0){

					//Elimino cualquier dato de un usuario anterior
					unset($_SESSION['usuario']);

					//Busco al usuario en el sistema
					$SIS_query = 'usuarios_listado.idUsuario,
					usuarios_listado.idUsuario AS ID,
					usuarios_listado.password,
					usuarios_listado.usuario,
					usuarios_listado.Nombre,
					usuarios_listado.idEstado,
					usuarios_listado.Direccion_img,
					usuarios_listado.idTipoUsuario,
					usuarios_tipos.Nombre AS Usuario_Tipo,
					core_ubicacion_ciudad.Nombre AS nombre_region,
					core_ubicacion_ciudad.Wheater AS nombre_pronostico,
					core_ubicacion_comunas.Nombre AS nombre_comuna,
					(SELECT count(idPermisoSistema) FROM usuarios_sistemas WHERE idUsuario=ID) AS COunt';
					$SIS_join = '
					LEFT JOIN `usuarios_tipos`            ON usuarios_tipos.idTipoUsuario     = usuarios_listado.idTipoUsuario
					LEFT JOIN `core_ubicacion_ciudad`     ON core_ubicacion_ciudad.idCiudad   = usuarios_listado.idCiudad
					LEFT JOIN `core_ubicacion_comunas`    ON core_ubicacion_comunas.idComuna  = usuarios_listado.idComuna';
					$SIS_where = 'usuarios_listado.idUsuario = "'.$idUsuario.'"';
					$rowUser = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, 'rowUser', $original, $form_trabajo);

					//Busco al usuario en el sistema
					$rowAcceso = db_select_data (false, 'Fecha, Hora', 'usuarios_accesos', '', 'idUsuario = "'.$rowUser['idUsuario'].'" ORDER BY idAcceso DESC', $dbConn, 'rowAcceso', $original, $form_trabajo);

					//Se verifca si los datos ingresados son de un usuario
					if (isset($rowUser['idUsuario'])&&$rowUser['idUsuario']!='') {

						//Verifico que el usuario identificado este activo
						if($rowUser['idEstado']==1){

							//Se crean las variables con todos los datos
							$_SESSION['usuario']['basic_data']['idUsuario']          = $rowUser['idUsuario'];
							$_SESSION['usuario']['basic_data']['password']           = $rowUser['password'];
							$_SESSION['usuario']['basic_data']['usuario']            = $rowUser['usuario'];
							$_SESSION['usuario']['basic_data']['Nombre']             = DeSanitizar($rowUser['Nombre']);
							$_SESSION['usuario']['basic_data']['Direccion_img']      = $rowUser['Direccion_img'];
							$_SESSION['usuario']['basic_data']['idTipoUsuario']      = $rowUser['idTipoUsuario'];
							$_SESSION['usuario']['basic_data']['Usuario_Tipo']       = DeSanitizar($rowUser['Usuario_Tipo']);
							$_SESSION['usuario']['basic_data']['COunt']              = $rowUser['COunt'];
							$_SESSION['usuario']['basic_data']['Region']             = DeSanitizar($rowUser['nombre_region']);
							$_SESSION['usuario']['basic_data']['Pronostico']         = $rowUser['nombre_pronostico'];
							$_SESSION['usuario']['basic_data']['Comuna']             = DeSanitizar($rowUser['nombre_comuna']);

							//Verifico si existen datos
							if(isset($rowAcceso['Fecha'])&&$rowAcceso['Fecha']!=''){$_SESSION['usuario']['basic_data']['FechaLogin'] = $rowAcceso['Fecha']; }else{$_SESSION['usuario']['basic_data']['FechaLogin'] = fecha_actual();}
							if(isset($rowAcceso['Hora'])&&$rowAcceso['Hora']!=''){  $_SESSION['usuario']['basic_data']['HoraLogin']  = $rowAcceso['Hora'];  }else{$_SESSION['usuario']['basic_data']['HoraLogin']  = hora_actual();}

							//Se buscan los datos para crear el menu
							$SIS_query = '
							core_permisos_categorias.Nombre AS CategoriaNombre,
							core_font_awesome.Codigo AS CategoriaIcono,
							core_permisos_categorias.IconColor AS CategoriaIconoColor,
							core_permisos_listado.Direccionbase AS TransaccionURLBase,
							core_permisos_listado.Direccionweb AS TransaccionURL,
							core_permisos_listado.Nombre AS TransaccionNombre,
							usuarios_permisos.level,
							core_permisos_listado.visualizacion AS idSistema';
							$arrMenu = array();
							$arrMenu = db_select_array (false, $SIS_query, 'usuarios_permisos', 'INNER JOIN core_permisos_listado ON core_permisos_listado.idAdmpm = usuarios_permisos.idAdmpm INNER JOIN core_permisos_categorias ON core_permisos_categorias.id_pmcat = core_permisos_listado.id_pmcat LEFT JOIN `core_font_awesome` ON core_font_awesome.idFont = core_permisos_categorias.idFont', 'usuarios_permisos.idUsuario ='.$idUsuario, 'CategoriaNombre ASC, TransaccionNombre ASC', $dbConn, 'arrMenu', $original, $form_trabajo);

							//Permisos
							foreach($arrMenu as $menu) {
								$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['CategoriaNombre']     = $menu['CategoriaNombre'];
								$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['CategoriaIcono']      = $menu['TransaccionURL'];
								$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['TransaccionNombre']   = $menu['TransaccionNombre'];
								$_SESSION['usuario']['Permisos'][$menu['TransaccionURLBase']]['level']               = $menu['level'];

							}

							//Construccion de los menus del sistema
							//llamamos a la función para filtrar los datos
							filtrar($arrMenu, 'CategoriaNombre');
							/******************************************************************/
							//recorremos el array para imprimirlo con formato HTML
							foreach($arrMenu as $Categorias=>$Transacciones) {

								$ntranx = 0;
								// recorremos los productos
								foreach($Transacciones as $transaccion) {

									$_SESSION['usuario']['menu'][$Categorias][$ntranx]['CategoriaNombre']         = $Categorias;
									$_SESSION['usuario']['menu'][$Categorias][$ntranx]['CategoriaIcono']          = $transaccion['CategoriaIcono'];
									$_SESSION['usuario']['menu'][$Categorias][$ntranx]['CategoriaIconoColor']     = $transaccion['CategoriaIconoColor'];
									$_SESSION['usuario']['menu'][$Categorias][$ntranx]['TransaccionURL']          = $transaccion['TransaccionURL'];
									$_SESSION['usuario']['menu'][$Categorias][$ntranx]['TransaccionNombre']       = $transaccion['TransaccionNombre'];
									$_SESSION['usuario']['menu'][$Categorias][$ntranx]['idSistema']               = $transaccion['idSistema'];

									$ntranx++;
								}

							}

							/******************************************************************/
							//Si el usuario es un super usuario
							if($rowUser['idTipoUsuario']==1){

								//Redirijo a la pagina de seleccion
								header( 'Location: index_select.php' );
								die;

							//Si el usuario es un usuario normal
							}else{

								if(isset($rowSis['Sistemas'])&&$rowSis['Sistemas']==1){

									//Verifico la cantidad de sistemas a la cual tiene permitido el acceso
									$rowSystem = db_select_data (false, 'idSistema', 'usuarios_sistemas','', 'idUsuario = "'.$rowUser['idUsuario'].'"', $dbConn, 'rowSystem', $original, $form_trabajo);

									//Consulto
									$SIS_query = 'core_sistemas.Config_idTheme,
									core_sistemas.Config_imgLogo,
									core_sistemas.Config_IDGoogle,
									core_sistemas.idOpcionesGen_8,
									core_sistemas.idOpcionesGen_7,
									core_sistemas.Nombre AS RazonSocial,
									core_config_ram.Nombre AS ConfigRam,
									core_config_time.Nombre AS ConfigTime';
									$SIS_join = 'LEFT JOIN `core_config_ram`   ON core_config_ram.idConfigRam    = core_sistemas.idConfigRam
									LEFT JOIN `core_config_time`  ON core_config_time.idConfigTime  = core_sistemas.idConfigTime';
									$rowSistema = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, 'core_sistemas.idSistema = "'.$rowSystem['idSistema'].'"', $dbConn, 'rowSistema', $original, $form_trabajo);

									//Se crean las variables con todos los datos
									$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowSistema['Config_idTheme'];
									$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowSistema['Config_imgLogo'];
									$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowSistema['Config_IDGoogle'];
									$_SESSION['usuario']['basic_data']['RazonSocial']        = DeSanitizar($rowSistema['RazonSocial']);
									$_SESSION['usuario']['basic_data']['ConfigRam']          = $rowSistema['ConfigRam'];
									$_SESSION['usuario']['basic_data']['ConfigTime']         = $rowSistema['ConfigTime'];
									$_SESSION['usuario']['basic_data']['CorreoInterno']      = $rowSistema['idOpcionesGen_8'];
									$_SESSION['usuario']['basic_data']['idInterfaz']         = $rowSistema['idOpcionesGen_7'];
									$_SESSION['usuario']['basic_data']['idSistema']          = $rowSystem['idSistema'];

									//Redirijo a la pagina principal
									header( 'Location: principal.php' );
									die;

								//Si tiene mas de uno, se redirije a una pantalla de seleccion
								}elseif(isset($rowSis['Sistemas'])&&$rowSis['Sistemas']>1){
									//Redirijo a la pagina de seleccion
									header( 'Location: index_select.php' );
									die;
								}

							}

						//Si no esta activo envio error
						}else{
							$error['idUsuario']   = 'error/Su usuario esta desactivado, Contactese con el administrador';
						}

					//Si no se encuentra ningun usuario se envia un error
					}else{
						$error['idUsuario']   = 'error/El nombre de usuario o contraseña no coinciden';
					}

				}

			}
		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'sistema_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//variables
			$id_usuario  = $_GET['id'];
			$idSistema   = $_GET['sistema_add'];

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idSistema, $id_usuario)&&$idSistema!=''&&$id_usuario!=''){
				$ndata_1 = db_select_nrows (false, 'idSistema', 'usuarios_sistemas','', "idSistema='".$idSistema."' AND idUsuario='".$id_usuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El permiso al sistema ya fue otorgado';}
			/*******************************************************************/

			// si no hay errores ejecuto el codigo
			if(empty($error)){
				//filtros
				if(isset($id_usuario) && $id_usuario!=''){  $SIS_data  = "'".$id_usuario."'";   }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){    $SIS_data .= ",'".$idSistema."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idUsuario, idSistema';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_sistemas',$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'sistema_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['sistema_del']) OR !validaEntero($_GET['sistema_del']))&&$_GET['sistema_del']!=''){
				$indice = simpleDecode($_GET['sistema_del'], fecha_actual());
			}else{
				$indice = $_GET['sistema_del'];
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
				$resultado = db_delete_data (false, 'usuarios_sistemas','idPermisoSistema = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//se dan permisos al usuario
		case 'prm_add_all_sys':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Valido
			if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){

				//Variables
				$idUsuario = simpleDecode($_GET['idUsuario'], fecha_actual());

				//Verifico permisos a las transacciones
				$SIS_query    = '
				core_sistemas.idSistema,
				(SELECT COUNT(idSistema) FROM usuarios_sistemas WHERE idSistema = core_sistemas.idSistema AND idUsuario = '.$idUsuario.' LIMIT 1) AS contar';
				$SIS_join     = '';
				$SIS_where    = '';
				$SIS_order    = 'core_sistemas.idSistema ASC';
				$arrContratos = array();
				$arrContratos = db_select_array (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************************************************************/
				//Se entregan los permisos relacionados a la caja
				foreach ($arrContratos as $cont) {
					//Si no se ha entregado el permiso
					if ( $cont['contar']!='1' ) {
						//filtros
						$SIS_data  = "'".$idUsuario."'";
						if(isset($cont['idSistema']) && $cont['idSistema']!=''){  $SIS_data .= ",'".$cont['idSistema']."'";       }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idUsuario, idSistema';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'usuarios_sistemas',$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}

				//redirijo
				header( 'Location: '.$location.'&created=true' );
				die;

			//Si hay errores
			}else{
				$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';
			}

		break;
/*******************************************************************************************************************/
		//se dan permisos al usuario
		case 'prm_del_all_sys':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['idUsuario']) OR !validaEntero($_GET['idUsuario']))&&$_GET['idUsuario']!=''){
				$indice = simpleDecode($_GET['idUsuario'], fecha_actual());
			}else{
				$indice = $_GET['idUsuario'];
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
				/***************************************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'usuarios_sistemas','idUsuario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		//Agrega un permiso al usuario
		case 'CorreosCat_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$idUsuario    = $_GET['id'];
			$idCorreosCat = $_GET['CorreosCat_add'];
			$idSistema    = $_GET['idSistema'];

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idUsuario, $idCorreosCat, $idSistema)&&$idUsuario!=''&&$idCorreosCat!=''&&$idSistema!=''){
				$ndata_1 = db_select_nrows (false, 'idCorreos', 'telemetria_mnt_correos_list', '', "idUsuario='".$idUsuario."' AND idCorreosCat='".$idCorreosCat."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La notificacion ya fue otorgada';}
			/*******************************************************************/

			// si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idCorreosCat) && $idCorreosCat!=''){   $SIS_data  = "'".$idCorreosCat."'";   }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){         $SIS_data .= ",'".$idSistema."'";     }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",'".$idUsuario."'";     }else{$SIS_data .= ",''";}
				if(isset($TimeStamp) && $TimeStamp!=''){         $SIS_data .= ",'".$TimeStamp."'";     }else{$SIS_data .= ",''";}
				if(isset($Chat_id) && $Chat_id!=''){             $SIS_data .= ",'".$Chat_id."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCorreosCat, idSistema, idUsuario, TimeStamp, Chat_id';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_mnt_correos_list', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'CorreosCat_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['CorreosCat_del']) OR !validaEntero($_GET['CorreosCat_del']))&&$_GET['CorreosCat_del']!=''){
				$indice = simpleDecode($_GET['CorreosCat_del'], fecha_actual());
			}else{
				$indice = $_GET['CorreosCat_del'];
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
				$resultado = db_delete_data (false, 'telemetria_mnt_correos_list', 'idCorreos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
