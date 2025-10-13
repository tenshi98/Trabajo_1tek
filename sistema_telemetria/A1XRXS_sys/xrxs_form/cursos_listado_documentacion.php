<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-078).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idDocumentacion'])) $idDocumentacion  = $_POST['idDocumentacion'];
	if (!empty($_POST['idCurso']))         $idCurso          = $_POST['idCurso'];
	if (!empty($_POST['Semana']))          $Semana           = $_POST['Semana'];

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
			case 'idDocumentacion': if(empty($idDocumentacion)){   $error['idDocumentacion']  = 'error/No ha ingresado el id';}break;
			case 'idCurso':         if(empty($idCurso)){           $error['idCurso']          = 'error/No ha seleccionado el cliente';}break;
			case 'Semana':          if(empty($Semana)){            $error['Semana']           = 'error/No ha ingresado la semana';}break;

		}
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
			/*$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($File)){
				$ndata_1 = db_select_nrows (false, 'File', 'cursos_listado_documentacion', '', "File='".$File."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				if ($_FILES["File_Curso"]["error"] > 0){
					$error['File_Curso'] = 'error/'.uploadPHPError($_FILES["File_Curso"]["error"]);
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

										"audio/basic",
										"audio/mid",
										"audio/mpeg",
										"audio/x-wav",

										"application/pdf",
										"application/octet-stream",
										"application/x-real",
										"application/vnd.adobe.xfdf",
										"application/vnd.fdf",
										"binary/octet-stream",

										"text/plain",
										"text/richtext",
										"application/rtf",

										"video/mpeg",
										"video/quicktime",
										"video/x-ms-asf",
										"video/x-msvideo",
										"video/quicktime",

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
					$sufijo = 'curso_'.$idCurso.'_';

					if (in_array($_FILES['File_Curso']['type'], $permitidos) && $_FILES['File_Curso']['size'] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = "upload/".$sufijo.$_FILES['File_Curso']['name'];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$move_result = @move_uploaded_file($_FILES["File_Curso"]["tmp_name"], $ruta);
							if ($move_result){

								//Filtro para idSistema
								$File = $sufijo.$_FILES['File_Curso']['name'];

								//filtros
								if(isset($idCurso) && $idCurso!=''){  $SIS_data  = "'".$idCurso."'";   }else{$SIS_data  = "''";}
								if(isset($File) && $File!=''){        $SIS_data .= ",'".$File."'";     }else{$SIS_data .= ",''";}
								if(isset($Semana) && $Semana!=''){    $SIS_data .= ",'".$Semana."'";   }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idCurso, File, Semana';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cursos_listado_documentacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//Si ejecuto correctamente la consulta
								if($ultimo_id!=0){
									//redirijo
									header( 'Location: '.$location );
									die;
								}
							} else {
								$error['File_Curso']     = 'error/Ocurrio un error al mover el archivo';
							}
						} else {
							$error['File_Curso']     = 'error/El archivo '.$_FILES['File_Curso']['name'].' ya existe';
						}
					} else {
						$error['File_Curso']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
					}
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
			if((!validarNumero($_GET['delFile']) OR !validaEntero($_GET['delFile']))&&$_GET['delFile']!=''){
				$indice = simpleDecode($_GET['delFile'], fecha_actual());
			}else{
				$indice = $_GET['delFile'];
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
				$rowData = db_select_data (false, 'File', 'cursos_listado_documentacion', '', "idDocumentacion = ".$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'cursos_listado_documentacion', 'idDocumentacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowData['File'])&&$rowData['File']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File']);
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
	}

?>
