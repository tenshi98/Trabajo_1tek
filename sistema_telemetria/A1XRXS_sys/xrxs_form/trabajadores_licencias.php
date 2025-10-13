<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-195).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idLicencia']))            $idLicencia             = $_POST['idLicencia'];
	if (!empty($_POST['idSistema']))             $idSistema              = $_POST['idSistema'];
	if (!empty($_POST['idTrabajador']))          $idTrabajador           = $_POST['idTrabajador'];
	if (!empty($_POST['idUsuario']))             $idUsuario              = $_POST['idUsuario'];
	if (!empty($_POST['Fecha_ingreso']))         $Fecha_ingreso          = $_POST['Fecha_ingreso'];
	if (!empty($_POST['Fecha_inicio']))          $Fecha_inicio           = $_POST['Fecha_inicio'];
	if (!empty($_POST['Fecha_termino']))         $Fecha_termino          = $_POST['Fecha_termino'];
	if (!empty($_POST['N_Dias']))                $N_Dias                 = $_POST['N_Dias'];
	if (!empty($_POST['Observacion']))           $Observacion            = $_POST['Observacion'];
	if (!empty($_POST['idUso']))                 $idUso                  = $_POST['idUso'];

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
			case 'idLicencia':            if(empty($idLicencia)){            $error['idLicencia']            = 'error/No ha ingresado el id';}break;
			case 'idSistema':             if(empty($idSistema)){             $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'idTrabajador':          if(empty($idTrabajador)){          $error['idTrabajador']          = 'error/No ha seleccionado el trabajador';}break;
			case 'idUsuario':             if(empty($idUsuario)){             $error['idUsuario']             = 'error/No ha seleccionado el usuario';}break;
			case 'Fecha_ingreso':         if(empty($Fecha_ingreso)){         $error['Fecha_ingreso']         = 'error/No ha ingresado la fecha de ingreso del documento';}break;
			case 'Fecha_inicio':          if(empty($Fecha_inicio)){          $error['Fecha_inicio']          = 'error/No ha ingresado la fecha de inicio';}break;
			case 'Fecha_termino':         if(empty($Fecha_termino)){         $error['Fecha_termino']         = 'error/No ha ingresado la fecha de termino';}break;
			case 'N_Dias':                if(empty($N_Dias)){                $error['N_Dias']                = 'error/No ha ingresado el numero de dias';}break;
			case 'Observacion':           if(empty($Observacion)){           $error['Observacion']           = 'error/No ha ingresado la observacion';}break;
			case 'idUso':                 if(empty($idUso)){                 $error['idUso']                 = 'error/No ha seleccionado la utilizacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observacion) && $Observacion!=''){ $Observacion = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){  $error['Observacion'] = 'error/Edita la Observacion, contiene palabras no permitidas';}

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
			//Se verifica si el dato existe
			if(isset($Fecha_inicio)&&isset($idTrabajador)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Fecha_inicio', 'trabajadores_licencias', '', "Fecha_inicio='".$Fecha_inicio."' AND idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La licencia ya existe en el sistema';}
			/*******************************************************************/
			//verifico que no se ingrese una fecha superior a la fecha actual
			if($Fecha_inicio>fecha_actual()){
				$error['ndata_1'] = 'error/No puede ingresar una fecha a futuro inexistente';
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se verifica si la imagen existe
				if (!empty($_FILES['File_Licencia']['name'])){

					if ($_FILES["File_Licencia"]["error"] > 0){
						$error['File_Licencia'] = 'error/'.uploadPHPError($_FILES["File_Licencia"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/pdf",
											"application/octet-stream",
											"application/x-real",
											"application/vnd.adobe.xfdf",
											"application/vnd.fdf",
											"binary/octet-stream",

											"image/jpg",
											"image/jpeg",
											"image/gif",
											"image/png"

													);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'licencia_'.$idTrabajador.'_'.genera_password_unica().'_';

						if (in_array($_FILES['File_Licencia']['type'], $permitidos) && $_FILES['File_Licencia']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['File_Licencia']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["File_Licencia"]["tmp_name"], $ruta);
								if ($move_result){

									//filtros
									if(isset($idSistema) && $idSistema!=''){            $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
									if(isset($idTrabajador) && $idTrabajador!=''){      $SIS_data .= ",'".$idTrabajador."'";   }else{$SIS_data .= ",''";}
									if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",'".$idUsuario."'";      }else{$SIS_data .= ",''";}
									if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){    $SIS_data .= ",'".$Fecha_ingreso."'";  }else{$SIS_data .= ",''";}
									if(isset($Fecha_inicio) && $Fecha_inicio!=''){      $SIS_data .= ",'".$Fecha_inicio."'";   }else{$SIS_data .= ",''";}
									if(isset($Fecha_termino) && $Fecha_termino!=''){    $SIS_data .= ",'".$Fecha_termino."'";  }else{$SIS_data .= ",''";}
									if(isset($N_Dias) && $N_Dias!=''){                  $SIS_data .= ",'".$N_Dias."'";         }else{$SIS_data .= ",''";}
									if(isset($Observacion) && $Observacion!=''){        $SIS_data .= ",'".$Observacion."'";    }else{$SIS_data .= ",''";}
									if(isset($idUso) && $idUso!=''){                    $SIS_data .= ",'".$idUso."'";          }else{$SIS_data .= ",''";}
									$SIS_data .= ",'".$sufijo.$_FILES['File_Licencia']['name']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idSistema, idTrabajador, idUsuario, Fecha_ingreso, Fecha_inicio, Fecha_termino, N_Dias, Observacion, idUso,File_Licencia';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_licencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($ultimo_id!=0){
										//redirijo
										header( 'Location: '.$location.'&created=true' );
										die;
									}

								}else {
									$error['File_Licencia']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['File_Licencia']     = 'error/El archivo '.$_FILES['File_Licencia']['name'].' ya existe';
							}
						} else {
							$error['File_Licencia']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{

					//filtros
					if(isset($idSistema) && $idSistema!=''){            $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
					if(isset($idTrabajador) && $idTrabajador!=''){      $SIS_data .= ",'".$idTrabajador."'";   }else{$SIS_data .= ",''";}
					if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",'".$idUsuario."'";      }else{$SIS_data .= ",''";}
					if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){    $SIS_data .= ",'".$Fecha_ingreso."'";  }else{$SIS_data .= ",''";}
					if(isset($Fecha_inicio) && $Fecha_inicio!=''){      $SIS_data .= ",'".$Fecha_inicio."'";   }else{$SIS_data .= ",''";}
					if(isset($Fecha_termino) && $Fecha_termino!=''){    $SIS_data .= ",'".$Fecha_termino."'";  }else{$SIS_data .= ",''";}
					if(isset($N_Dias) && $N_Dias!=''){                  $SIS_data .= ",'".$N_Dias."'";         }else{$SIS_data .= ",''";}
					if(isset($Observacion) && $Observacion!=''){        $SIS_data .= ",'".$Observacion."'";    }else{$SIS_data .= ",''";}
					if(isset($idUso) && $idUso!=''){                    $SIS_data .= ",'".$idUso."'";          }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idSistema, idTrabajador, idUsuario, Fecha_ingreso, Fecha_inicio, Fecha_termino, N_Dias, Observacion, idUso';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_licencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&created=true' );
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
			//Se verifica si el dato existe
			if(isset($Fecha_inicio)&&isset($idTrabajador)&&isset($idLicencia)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Fecha_inicio', 'trabajadores_licencias', '', "Fecha_inicio='".$Fecha_inicio."' AND idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."' AND idLicencia!='".$idLicencia."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La licencia ya existe en el sistema';}
			/*******************************************************************/
			//verifico que no se ingrese una fecha superior a la fecha actual
			if($Fecha_inicio>fecha_actual()){
				$error['ndata_1'] = 'error/No puede ingresar una fecha a futuro inexistente';
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se verifica si la imagen existe
				if (!empty($_FILES['File_Licencia']['name'])){

					if ($_FILES["File_Licencia"]["error"] > 0){
						$error['File_Licencia'] = 'error/'.uploadPHPError($_FILES["File_Licencia"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/pdf",
											"application/octet-stream",
											"application/x-real",
											"application/vnd.adobe.xfdf",
											"application/vnd.fdf",
											"binary/octet-stream",

											"image/jpg",
											"image/jpeg",
											"image/gif",
											"image/png"

													);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'licencia_'.$idTrabajador.'_'.genera_password_unica().'_';

						if (in_array($_FILES['File_Licencia']['type'], $permitidos) && $_FILES['File_Licencia']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['File_Licencia']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["File_Licencia"]["tmp_name"], $ruta);
								if ($move_result){

									//Filtros
									$SIS_data = "idLicencia='".$idLicencia."'";
									if(isset($idSistema) && $idSistema!=''){            $SIS_data .= ",idSistema='".$idSistema."'";}
									if(isset($idTrabajador) && $idTrabajador!=''){      $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
									if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",idUsuario='".$idUsuario."'";}
									if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){    $SIS_data .= ",Fecha_ingreso='".$Fecha_ingreso."'";}
									if(isset($Fecha_inicio) && $Fecha_inicio!=''){      $SIS_data .= ",Fecha_inicio='".$Fecha_inicio."'";}
									if(isset($Fecha_termino) && $Fecha_termino!=''){    $SIS_data .= ",Fecha_termino='".$Fecha_termino."'";}
									if(isset($N_Dias) && $N_Dias!=''){                  $SIS_data .= ",N_Dias='".$N_Dias."'";}
									if(isset($Observacion) && $Observacion!=''){        $SIS_data .= ",Observacion='".$Observacion."'";}
									if(isset($idUso) && $idUso!=''){                    $SIS_data .= ",idUso='".$idUso."'";}
									$SIS_data .= ",File_Licencia='".$sufijo.$_FILES['File_Licencia']['name']."'";

									/*******************************************************/
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'trabajadores_licencias', 'idLicencia = "'.$idLicencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									//Si ejecuto correctamente la consulta
									if($resultado==true){

										header( 'Location: '.$location.'&edited=true' );
										die;

									}
								}else {
									$error['File_Licencia']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['File_Licencia']     = 'error/El archivo '.$_FILES['File_Licencia']['name'].' ya existe';
							}
						} else {
							$error['File_Licencia']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{

					//Filtros
					$SIS_data = "idLicencia='".$idLicencia."'";
					if(isset($idSistema) && $idSistema!=''){            $SIS_data .= ",idSistema='".$idSistema."'";}
					if(isset($idTrabajador) && $idTrabajador!=''){      $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
					if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",idUsuario='".$idUsuario."'";}
					if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){    $SIS_data .= ",Fecha_ingreso='".$Fecha_ingreso."'";}
					if(isset($Fecha_inicio) && $Fecha_inicio!=''){      $SIS_data .= ",Fecha_inicio='".$Fecha_inicio."'";}
					if(isset($Fecha_termino) && $Fecha_termino!=''){    $SIS_data .= ",Fecha_termino='".$Fecha_termino."'";}
					if(isset($N_Dias) && $N_Dias!=''){                  $SIS_data .= ",N_Dias='".$N_Dias."'";}
					if(isset($Observacion) && $Observacion!=''){        $SIS_data .= ",Observacion='".$Observacion."'";}
					if(isset($idUso) && $idUso!=''){                    $SIS_data .= ",idUso='".$idUso."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'trabajadores_licencias', 'idLicencia = "'.$idLicencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){

						header( 'Location: '.$location.'&edited=true' );
						die;

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
				$rowData = db_select_data (false, 'File_Licencia', 'trabajadores_licencias', '', 'idLicencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'trabajadores_licencias', 'idLicencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina la foto
					if(isset($rowData['File_Licencia'])&&$rowData['File_Licencia']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Licencia'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Licencia']);
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
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_Licencia', 'trabajadores_licencias', '', 'idLicencia = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Licencia=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_licencias', 'idLicencia = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Licencia'])&&$rowData['File_Licencia']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Licencia'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Licencia']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&delfile=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
