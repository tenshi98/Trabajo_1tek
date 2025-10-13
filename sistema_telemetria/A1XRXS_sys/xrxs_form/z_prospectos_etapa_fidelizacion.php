<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-265).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idEtapaFide']))    $idEtapaFide     = $_POST['idEtapaFide'];
	if (!empty($_POST['idProspecto']))    $idProspecto     = $_POST['idProspecto'];
	if (!empty($_POST['idUsuario']))      $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['idEtapa']))        $idEtapa         = $_POST['idEtapa'];
	if (!empty($_POST['Fecha']))          $Fecha           = $_POST['Fecha'];
	if (!empty($_POST['Observacion']))    $Observacion     = $_POST['Observacion'];

	if (!empty($_POST['FModificacion']))  $FModificacion   = $_POST['FModificacion'];
	if (!empty($_POST['HModificacion']))  $HModificacion   = $_POST['HModificacion'];
	if (!empty($_POST['idUsuarioMod']))   $idUsuarioMod    = $_POST['idUsuarioMod'];

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
			case 'idEtapaFide':    if(empty($idEtapaFide)){     $error['idEtapaFide']    = 'error/No ha ingresado el id';}break;
			case 'idProspecto':    if(empty($idProspecto)){     $error['idProspecto']    = 'error/No ha seleccionado el prospecto';}break;
			case 'idUsuario':      if(empty($idUsuario)){       $error['idUsuario']      = 'error/No ha seleccionado un usuario';}break;
			case 'idEtapa':        if(empty($idEtapa)){         $error['idEtapa']        = 'error/No ha seleccionado una etapa';}break;
			case 'Fecha':          if(empty($Fecha)){           $error['Fecha']          = 'error/No ha ingresado la fecha';}break;
			case 'Observacion':    if(empty($Observacion)){     $error['Observacion']    = 'error/No ha ingresado la observacion';}break;

			case 'FModificacion':  if(empty($FModificacion)){   $error['FModificacion']  = 'error/No ha ingresado la fecha de modificacion';}break;
			case 'HModificacion':  if(empty($HModificacion)){   $error['HModificacion']  = 'error/No ha ingresado la hora de modificacion';}break;
			case 'idUsuarioMod':   if(empty($idUsuarioMod)){    $error['idUsuarioMod']   = 'error/No ha ingresado el usuario de la modificacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observacion) && $Observacion!=''){ $Observacion = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){  $error['Observacion'] = 'error/Edita Observacion, contiene palabras no permitidas';}

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

				/***********************************************************************************/
				//se verifica si la imagen existe
				if (!empty($_FILES['Archivo']['name'])){
					if ($_FILES["Archivo"]["error"] > 0){
						$error['Archivo']       = 'error/'.uploadPHPError($_FILES["Archivo"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array(
											"image/jpg",
											"image/png",
											"image/gif",
											"image/jpeg",
											"image/bmp",

											"application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

											"application/mspowerpoint",
											"application/vnd.ms-powerpoint",
											"application/vnd.openxmlformats-officedocument.presentationml.presentation",

											"application/pdf",
											"application/octet-stream",
											"application/x-real",
											"application/vnd.adobe.xfdf",
											"application/vnd.fdf",
											"binary/octet-stream",

											"text/plain",
											"text/richtext",
											"application/rtf",

											"application/x-zip-compressed",
											"application/zip",
											"multipart/x-zip",
											"application/x-7z-compressed",
											"application/x-rar-compressed",
											"application/gzip",
											"application/x-gzip",
											"application/x-gtar",
											"application/x-tgz",
											"application/octet-stream"
										);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'prospecto_'.$idProspecto.'_';

						if (in_array($_FILES['Archivo']['type'], $permitidos) && $_FILES['Archivo']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['Archivo']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["Archivo"]["tmp_name"], $ruta);
								if ($move_result){

									//filtros
									if(isset($idProspecto) && $idProspecto!=''){ $SIS_data  = "'".$idProspecto."'";    }else{$SIS_data  = "''";}
									if(isset($idUsuario) && $idUsuario!=''){     $SIS_data .= ",'".$idUsuario."'";     }else{$SIS_data .= ",''";}
									if(isset($idEtapa) && $idEtapa!=''){         $SIS_data .= ",'".$idEtapa."'";       }else{$SIS_data .= ",''";}
									if(isset($Fecha) && $Fecha!=''){             $SIS_data .= ",'".$Fecha."'";         }else{$SIS_data .= ",''";}
									if(isset($Observacion) && $Observacion!=''){ $SIS_data .= ",'".$Observacion."'";   }else{$SIS_data .= ",''";}
									$SIS_data .= ",'".$sufijo.$_FILES['Archivo']['name']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idProspecto, idUsuario, idEtapa, Fecha, Observacion, Archivo';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'prospectos_etapa_fidelizacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($ultimo_id!=0){
										//Actualizo los datos
										$SIS_data = "idProspecto='".$idProspecto."'";
										if(isset($idEtapa) && $idEtapa!= ''){              $SIS_data .= ",idEtapa='".$idEtapa."'";}
										if(isset($FModificacion) && $FModificacion!= ''){  $SIS_data .= ",FModificacion='".$FModificacion."'";}
										if(isset($HModificacion) && $HModificacion!= ''){  $SIS_data .= ",HModificacion='".$HModificacion."'";}
										if(isset($idUsuarioMod) && $idUsuarioMod!= ''){    $SIS_data .= ",idUsuarioMod='".$idUsuarioMod."'";}

										/*******************************************************/
										//se actualizan los datos
										$resultado2 = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
										//Si ejecuto correctamente la consulta
										if($resultado2==true){
											//redirijo
											header( 'Location: '.$location.'&created=true' );
											die;

										}
									}
								}else {
									$error['Archivo']       = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['Archivo']       = 'error/El archivo '.$_FILES['Archivo']['name'].' ya existe';
							}
						} else {
							$error['Archivo']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				/************************************************************/
				//si no hay archivo
				}else{

					//filtros
					if(isset($idProspecto) && $idProspecto!=''){ $SIS_data  = "'".$idProspecto."'";    }else{$SIS_data  = "''";}
					if(isset($idUsuario) && $idUsuario!=''){     $SIS_data .= ",'".$idUsuario."'";     }else{$SIS_data .= ",''";}
					if(isset($idEtapa) && $idEtapa!=''){         $SIS_data .= ",'".$idEtapa."'";       }else{$SIS_data .= ",''";}
					if(isset($Fecha) && $Fecha!=''){             $SIS_data .= ",'".$Fecha."'";         }else{$SIS_data .= ",''";}
					if(isset($Observacion) && $Observacion!=''){ $SIS_data .= ",'".$Observacion."'";   }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idProspecto, idUsuario, idEtapa, Fecha, Observacion';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'prospectos_etapa_fidelizacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){

						//Actualizo los datos
						$SIS_data = "idProspecto='".$idProspecto."'";
						if(isset($idEtapa) && $idEtapa!= ''){              $SIS_data .= ",idEtapa='".$idEtapa."'";}
						if(isset($FModificacion) && $FModificacion!= ''){  $SIS_data .= ",FModificacion='".$FModificacion."'";}
						if(isset($HModificacion) && $HModificacion!= ''){  $SIS_data .= ",HModificacion='".$HModificacion."'";}
						if(isset($idUsuarioMod) && $idUsuarioMod!= ''){    $SIS_data .= ",idUsuarioMod='".$idUsuarioMod."'";}

						/*******************************************************/
						//se actualizan los datos
						$resultado2 = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//Si ejecuto correctamente la consulta
						if($resultado2==true){
							//redirijo
							header( 'Location: '.$location.'&created=true' );
							die;

						}
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***********************************************************************************/
				//se verifica si la imagen existe
				if (!empty($_FILES['Archivo']['name'])){
					if ($_FILES["Archivo"]["error"] > 0){
						$error['Archivo']       = 'error/'.uploadPHPError($_FILES["Archivo"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array(
											"image/jpg",
											"image/png",
											"image/gif",
											"image/jpeg",
											"image/bmp",

											"application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

											"application/mspowerpoint",
											"application/vnd.ms-powerpoint",
											"application/vnd.openxmlformats-officedocument.presentationml.presentation",

											"application/pdf",
											"application/octet-stream",
											"application/x-real",
											"application/vnd.adobe.xfdf",
											"application/vnd.fdf",
											"binary/octet-stream",

											"text/plain",
											"text/richtext",
											"application/rtf",

											"application/x-zip-compressed",
											"application/zip",
											"multipart/x-zip",
											"application/x-7z-compressed",
											"application/x-rar-compressed",
											"application/gzip",
											"application/x-gzip",
											"application/x-gtar",
											"application/x-tgz",
											"application/octet-stream"
										);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'prospecto_'.$idProspecto.'_';

						if (in_array($_FILES['Archivo']['type'], $permitidos) && $_FILES['Archivo']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['Archivo']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["Archivo"]["tmp_name"], $ruta);
								if ($move_result){

									//Filtros
									$SIS_data = "idEtapaFide='".$idEtapaFide."'";
									if(isset($idProspecto) && $idProspecto!=''){   $SIS_data .= ",idProspecto='".$idProspecto."'";}
									if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
									if(isset($idEtapa) && $idEtapa!=''){           $SIS_data .= ",idEtapa='".$idEtapa."'";}
									if(isset($Fecha) && $Fecha!=''){               $SIS_data .= ",Fecha='".$Fecha."'";}
									if(isset($Observacion) && $Observacion!=''){   $SIS_data .= ",Observacion='".$Observacion."'";}
									$SIS_data .= ",Archivo='".$sufijo.$_FILES['Archivo']['name']."'";

									/*******************************************************/
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'prospectos_etapa_fidelizacion', 'idEtapaFide = "'.$idEtapaFide.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									//Si ejecuto correctamente la consulta
									if($resultado==true){

										//Actualizo los datos
										$SIS_data = "idProspecto='".$idProspecto."'";
										if(isset($idEtapa) && $idEtapa!= ''){              $SIS_data .= ",idEtapa='".$idEtapa."'";}
										if(isset($FModificacion) && $FModificacion!= ''){  $SIS_data .= ",FModificacion='".$FModificacion."'";}
										if(isset($HModificacion) && $HModificacion!= ''){  $SIS_data .= ",HModificacion='".$HModificacion."'";}
										if(isset($idUsuarioMod) && $idUsuarioMod!= ''){    $SIS_data .= ",idUsuarioMod='".$idUsuarioMod."'";}

										/*******************************************************/
										//se actualizan los datos
										$resultado2 = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
										//Si ejecuto correctamente la consulta
										if($resultado2==true){
											//redirijo
											header( 'Location: '.$location.'&edited=true' );
											die;
										}
									}
								}else {
									$error['Archivo']       = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['Archivo']       = 'error/El archivo '.$_FILES['Archivo']['name'].' ya existe';
							}
						} else {
							$error['Archivo']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				/************************************************************/
				//si no hay archivo
				}else{
					//Filtros
					$SIS_data = "idEtapaFide='".$idEtapaFide."'";
					if(isset($idProspecto) && $idProspecto!=''){   $SIS_data .= ",idProspecto='".$idProspecto."'";}
					if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
					if(isset($idEtapa) && $idEtapa!=''){           $SIS_data .= ",idEtapa='".$idEtapa."'";}
					if(isset($Fecha) && $Fecha!=''){               $SIS_data .= ",Fecha='".$Fecha."'";}
					if(isset($Observacion) && $Observacion!=''){   $SIS_data .= ",Observacion='".$Observacion."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'prospectos_etapa_fidelizacion', 'idEtapaFide = "'.$idEtapaFide.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){

						//Actualizo los datos
						$SIS_data = "idProspecto='".$idProspecto."'";
						if(isset($idEtapa) && $idEtapa!= ''){              $SIS_data .= ",idEtapa='".$idEtapa."'";}
						if(isset($FModificacion) && $FModificacion!= ''){  $SIS_data .= ",FModificacion='".$FModificacion."'";}
						if(isset($HModificacion) && $HModificacion!= ''){  $SIS_data .= ",HModificacion='".$HModificacion."'";}
						if(isset($idUsuarioMod) && $idUsuarioMod!= ''){    $SIS_data .= ",idUsuarioMod='".$idUsuarioMod."'";}

						/*******************************************************/
						//se actualizan los datos
						$resultado2 = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//Si ejecuto correctamente la consulta
						if($resultado2==true){
							//redirijo
							header( 'Location: '.$location.'&edited=true' );
							die;
						}
					}
				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_Archivo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//busco los archivos relacionados
			$rowData = db_select_data (false, 'Archivo', 'prospectos_etapa_fidelizacion', '', 'idEtapaFide = "'.$_GET['del_archivo'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$resultado = db_update_data (false, 'Archivo=""', 'prospectos_etapa_fidelizacion', 'idEtapaFide = "'.$_GET['del_archivo'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//se elimina el archivo
				if(isset($rowData['Archivo'])&&$rowData['Archivo']!=''){
					try {
						if(!is_writable('upload/'.$rowData['Archivo'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['Archivo']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&edit='.$_GET['del_archivo'].'&del_arch=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
	}

?>
