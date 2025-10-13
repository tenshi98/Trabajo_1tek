<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-231).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idEmail']))            $idEmail               = $_POST['idEmail'];
	if (!empty($_POST['idSistema']))          $idSistema             = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))          $idUsuario             = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))              $Fecha                 = $_POST['Fecha'];
	if (!empty($_POST['Asunto']))             $Asunto                = $_POST['Asunto'];
	if (!empty($_POST['Cuerpo']))             $Cuerpo                = $_POST['Cuerpo'];

	if (!empty($_POST['idTipoUsuario']))      $idTipoUsuario         = $_POST['idTipoUsuario'];
	if (!empty($_POST['Nombre']))             $Nombre                = $_POST['Nombre'];
	if (!empty($_POST['rango_a']))            $rango_a               = $_POST['rango_a'];
	if (!empty($_POST['rango_b']))            $rango_b               = $_POST['rango_b'];
	if (!empty($_POST['idCiudad']))           $idCiudad              = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))           $idComuna              = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))          $Direccion             = $_POST['Direccion'];

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
			case 'idEmail':          if(empty($idEmail)){           $error['idEmail']           = 'error/No ha ingresado el id';}break;
			case 'idSistema':        if(empty($idSistema)){         $error['idSistema']         = 'error/No ha ingresado el sistema';}break;
			case 'idUsuario':        if(empty($idUsuario)){         $error['idUsuario']         = 'error/No ha ingresado el usuario creador';}break;
			case 'Fecha':            if(empty($Fecha)){             $error['Fecha']             = 'error/No ha ingresado la fecha';}break;
			case 'Asunto':           if(empty($Asunto)){            $error['Asunto']            = 'error/No ha ingresado el Asunto';}break;
			case 'Cuerpo':           if(empty($Cuerpo)){            $error['Cuerpo']            = 'error/No ha ingresado el cuerpo';}break;
			case 'idTipoUsuario':    if(empty($idTipoUsuario)){     $error['idTipoUsuario']     = 'error/No ha seleccionado el tipo de usuario';}break;
			case 'Nombre':           if(empty($Nombre)){            $error['Nombre']            = 'error/No ha ingresado el nombre';}break;
			case 'rango_a':          if(empty($rango_a)){           $error['rango_a']           = 'error/No ha ingresado la fecha de nacimiento inicio';}break;
			case 'rango_b':          if(empty($rango_b)){           $error['rango_b']           = 'error/No ha ingresado la fecha de nacimiento termino';}break;
			case 'idCiudad':         if(empty($idCiudad)){          $error['idCiudad']          = 'error/No ha ingresado la ciudad';}break;
			case 'idComuna':         if(empty($idComuna)){          $error['idComuna']          = 'error/No ha ingresado la comuna';}break;
			case 'Direccion':        if(empty($Direccion)){         $error['Direccion']         = 'error/No ha ingresado la dirección';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Asunto) && $Asunto!=''){       $Asunto    = EstandarizarInput($Asunto);}
	if(isset($Cuerpo) && $Cuerpo!=''){       $Cuerpo    = EstandarizarInput($Cuerpo);}
	if(isset($Nombre) && $Nombre!=''){       $Nombre    = EstandarizarInput($Nombre);}
	if(isset($Direccion) && $Direccion!=''){ $Direccion = EstandarizarInput($Direccion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Asunto)&&contar_palabras_censuradas($Asunto)!=0){              $error['Asunto']       = 'error/Edita Asunto, contiene palabras no permitidas';}
	if(isset($Cuerpo)&&contar_palabras_censuradas($Cuerpo)!=0){              $error['Cuerpo']       = 'error/Edita Cuerpo, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){              $error['Nombre']       = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){        $error['Direccion']    = 'error/Edita Direccion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/

/*******************************************************************************************************************/
		case 'email_masivo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***************************************************************/
				//Selecciono a quienes les envio el correo
				$w = "usuarios_listado.idEstado = 1 AND usuarios_listado.email!= ''";
				if(isset($idTipoUsuario) && $idTipoUsuario!=''){    $w .= " AND usuarios_listado.idTipoUsuario = '".$idTipoUsuario."'";}
				if(isset($Nombre) && $Nombre != ''){              $w .= " AND usuarios_listado.Nombre LIKE '%".$Nombre."%' ";}
				if(isset($idCiudad) && $idCiudad != ''){          $w .= " AND usuarios_listado.idCiudad = '".$idCiudad."'";}
				if(isset($idComuna) && $idComuna != ''){          $w .= " AND usuarios_listado.idComuna = '".$idComuna."'";}
				if(isset($Direccion) && $Direccion != ''){        $w .= " AND usuarios_listado.Direccion LIKE '%".$Direccion."%'";}
				if(isset($idSistema) && $idSistema != ''){        $w .= " AND usuarios_sistemas.idSistema = '".$idSistema."'";}
				if(isset($rango_a) && $rango_a != ''&&isset($rango_b) && $rango_b!=''){
					$w .= " AND usuarios_listado.fNacimiento BETWEEN '".$rango_a."' AND '".$rango_b."'";
				}
				//consulta
				$arrNotificaciones = array();
				$arrNotificaciones = db_select_array (false, 'usuarios_listado.idUsuario, usuarios_listado.email,usuarios_listado.Nombre',  'usuarios_listado', 'LEFT JOIN `usuarios_sistemas` ON usuarios_sistemas.idUsuario = usuarios_listado.idUsuario', $w.' GROUP BY usuarios_listado.idUsuario', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/***************************************************************/
				//guardo registro del correo
				//filtros
				if(isset($idSistema) && $idSistema!=''){   $SIS_data  = "'".$idSistema."'";   }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){   $SIS_data .= ",'".$idUsuario."'";  }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){           $SIS_data .= ",'".$Fecha."'";      }else{$SIS_data .= ",''";}
				if(isset($Asunto) && $Asunto!=''){         $SIS_data .= ",'".$Asunto."'";     }else{$SIS_data .= ",''";}
				if(isset($Cuerpo) && $Cuerpo!=''){         $SIS_data .= ",'".$Cuerpo."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, Fecha, Asunto, Cuerpo';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'comunicaciones_internas_email', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//se consulta el correo de la empresa
					$rowusr = db_select_data (false, 'Nombre,email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//si tiene la interfaz de crosstech
					if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&($_SESSION['usuario']['basic_data']['idInterfaz']==7 OR $_SESSION['usuario']['basic_data']['idInterfaz']==6)){
						//logo de la compañia
						$login_logo  = DB_SITE_MAIN.'/img/login_logo.png';
						$file_logo   = 'img/login_logo.png';

						//solo si existe el logo
						if (file_exists($file_logo)){
							//Se crea el cuerpo del correo
							$BodyMail_1  = '<div style="background-color: #D9D9D9; padding: 10px;">';
							$BodyMail_1 .= '<img src="'.$login_logo.'" style="width: 30%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
							$BodyMail_1 .= '<h3 style="text-align: center;font-size: 30px;">';
							$BodyMail_2  = '</h3>';
							$BodyMail_2 .= '<p style="text-align: center;font-size: 20px;">';
							$BodyMail_2 .= $Cuerpo;
							$BodyMail_2 .= '</p>';
							$BodyMail_2 .= '<a href="'.DB_SITE_MAIN.'/principal.php" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Ver Mas &#8594;</strong></a>';
							$BodyMail_2 .= '</div>';
							//Se crea el cuerpo del correo
							$BodyMail  = $BodyMail_1;
							$BodyMail .= '¡Hola <strong>'.$noti['Nombre'].'</strong>!<br/>';
							$BodyMail .= $BodyMail_2;
						}else{
							//Se crea el cuerpo del correo
							$BodyMail_1  = '<div style="background-color: #D9D9D9; padding: 10px;">';
							$BodyMail_1 .= '<h3 style="text-align: center;font-size: 30px;">';
							$BodyMail_2  = '</h3>';
							$BodyMail_2 .= '<p style="text-align: center;font-size: 20px;">';
							$BodyMail_2 .= $Cuerpo;
							$BodyMail_2 .= '</p>';
							$BodyMail_2 .= '<a href="'.DB_SITE_MAIN.'/principal.php" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Ver Mas &#8594;</strong></a>';
							$BodyMail_2 .= '</div>';
							//Se crea el cuerpo del correo
							$BodyMail  = $BodyMail_1;
							$BodyMail .= '¡Hola <strong>'.$noti['Nombre'].'</strong>!<br/>';
							$BodyMail .= $BodyMail_2;
							//se guarda el error
							php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'logo no existe ('.$login_logo.')', '' );
						}
					//si no la tiene se envia correo normal
					}else{
						$BodyMail  = $Cuerpo;
					}

					/***************************************************************/
					//recorro a los usuarios
					foreach ($arrNotificaciones as $noti) {
						//envio de correo
						try {
							//se envia correo
							$rmail = tareas_envio_correo($rowusr['email_principal'], '1Tek',
														 $noti['email'], $noti['Nombre'],
														 '', '',
														 $Asunto,
														 $BodyMail,'',
														 '',
														 1,
														 $rowusr['Gmail_Usuario'],
														 $rowusr['Gmail_Password']);
							//se guarda el log
							log_response(1, $rmail, $noti['email'].' (Asunto:'.$Asunto.')');

							/******************************************/
							//guardo registro de a quien se lo envie
							if(isset($ultimo_id) && $ultimo_id!=''){                   $SIS_data  = "'".$ultimo_id."'";              }else{$SIS_data  = "''";}
							if(isset($noti['idUsuario']) && $noti['idUsuario']!=''){   $SIS_data .= ",'".$noti['idUsuario']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idEmail,idUsuario';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'comunicaciones_internas_email_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						} catch (Exception $e) {
							php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'En el envio de la notificacion:'.$e->getMessage(), '' );
						}

					}

					//redirijo
					header( 'Location: '.$location.'&created=true' );
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
				$resultado_1 = db_delete_data (false, 'comunicaciones_internas_email', 'idEmail = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'comunicaciones_internas_email_listado', 'idEmail = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
