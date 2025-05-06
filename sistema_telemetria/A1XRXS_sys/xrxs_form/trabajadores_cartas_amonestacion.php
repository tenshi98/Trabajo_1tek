<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-189).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCartaAmo']))            $idCartaAmo             = $_POST['idCartaAmo'];
	if (!empty($_POST['idSistema']))             $idSistema              = $_POST['idSistema'];
	if (!empty($_POST['idTrabajador']))          $idTrabajador           = $_POST['idTrabajador'];
	if (!empty($_POST['idUsuario']))             $idUsuario              = $_POST['idUsuario'];
	if (!empty($_POST['Fecha_ingreso']))         $Fecha_ingreso          = $_POST['Fecha_ingreso'];
	if (!empty($_POST['Fecha']))                 $Fecha                  = $_POST['Fecha'];
	if (!empty($_POST['idAmonestaciones']))      $idAmonestaciones       = $_POST['idAmonestaciones'];
	if (!empty($_POST['Observacion']))           $Observacion            = $_POST['Observacion'];

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
			case 'idCartaAmo':            if(empty($idCartaAmo)){            $error['idCartaAmo']            = 'error/No ha ingresado el id';}break;
			case 'idSistema':             if(empty($idSistema)){             $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'idTrabajador':          if(empty($idTrabajador)){          $error['idTrabajador']          = 'error/No ha seleccionado el trabajador';}break;
			case 'idUsuario':             if(empty($idUsuario)){             $error['idUsuario']             = 'error/No ha seleccionado el usuario';}break;
			case 'Fecha_ingreso':         if(empty($Fecha_ingreso)){         $error['Fecha_ingreso']         = 'error/No ha ingresado la fecha de ingreso del documento';}break;
			case 'Fecha':                 if(empty($Fecha)){                 $error['Fecha']                 = 'error/No ha ingresado la fecha de inicio';}break;
			case 'idAmonestaciones':      if(empty($idAmonestaciones)){      $error['idAmonestaciones']      = 'error/No ha ingresado el numero de dias';}break;
			case 'Observacion':           if(empty($Observacion)){           $error['Observacion']           = 'error/No ha ingresado la observacion';}break;

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
			if(isset($Fecha)&&isset($idTrabajador)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Fecha', 'trabajadores_cartas_amonestacion', '', "Fecha='".$Fecha."' AND idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Carta de Amonestacion ya existe en el sistema';}
			/*******************************************************************/
			//verifico que no se ingrese una fecha superior a la fecha actual
			if($Fecha>fecha_actual()){
				$error['ndata_1'] = 'error/No puede ingresar una fecha a futuro inexistente';
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se verifica si la imagen existe
				if (!empty($_FILES['File_Amonestacion']['name'])){

					if ($_FILES["File_Amonestacion"]["error"] > 0){
						$error['File_Amonestacion'] = 'error/'.uploadPHPError($_FILES["File_Amonestacion"]["error"]);
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
						$sufijo = 'amonestacion_'.$idTrabajador.'_'.genera_password_unica().'_';

						if (in_array($_FILES['File_Amonestacion']['type'], $permitidos) && $_FILES['File_Amonestacion']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['File_Amonestacion']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["File_Amonestacion"]["tmp_name"], $ruta);
								if ($move_result){

									//filtros
									if(isset($idSistema) && $idSistema!=''){                $SIS_data  = "'".$idSistema."'";         }else{$SIS_data  = "''";}
									if(isset($idTrabajador) && $idTrabajador!=''){          $SIS_data .= ",'".$idTrabajador."'";     }else{$SIS_data .= ",''";}
									if(isset($idUsuario) && $idUsuario!=''){                $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}
									if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){        $SIS_data .= ",'".$Fecha_ingreso."'";    }else{$SIS_data .= ",''";}
									if(isset($Fecha) && $Fecha!=''){                        $SIS_data .= ",'".$Fecha."'";            }else{$SIS_data .= ",''";}
									if(isset($idAmonestaciones) && $idAmonestaciones!=''){  $SIS_data .= ",'".$idAmonestaciones."'"; }else{$SIS_data .= ",''";}
									if(isset($Observacion) && $Observacion!=''){            $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
									$SIS_data .= ",'".$sufijo.$_FILES['File_Amonestacion']['name']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idSistema, idTrabajador, idUsuario, Fecha_ingreso, Fecha, idAmonestaciones, Observacion,File_Amonestacion';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_cartas_amonestacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($ultimo_id!=0){
										//redirijo
										header( 'Location: '.$location.'&created=true' );
										die;
									}

								}else {
									$error['File_Amonestacion']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['File_Amonestacion']     = 'error/El archivo '.$_FILES['File_Amonestacion']['name'].' ya existe';
							}
						} else {
							$error['File_Amonestacion']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{

					//filtros
					if(isset($idSistema) && $idSistema!=''){               $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
					if(isset($idTrabajador) && $idTrabajador!=''){         $SIS_data .= ",'".$idTrabajador."'";      }else{$SIS_data .= ",''";}
					if(isset($idUsuario) && $idUsuario!=''){               $SIS_data .= ",'".$idUsuario."'";         }else{$SIS_data .= ",''";}
					if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){       $SIS_data .= ",'".$Fecha_ingreso."'";     }else{$SIS_data .= ",''";}
					if(isset($Fecha) && $Fecha!=''){                       $SIS_data .= ",'".$Fecha."'";             }else{$SIS_data .= ",''";}
					if(isset($idAmonestaciones) && $idAmonestaciones!=''){ $SIS_data .= ",'".$idAmonestaciones."'";  }else{$SIS_data .= ",''";}
					if(isset($Observacion) && $Observacion!=''){           $SIS_data .= ",'".$Observacion."'";       }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idSistema, idTrabajador, idUsuario, Fecha_ingreso, Fecha, idAmonestaciones, Observacion';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_cartas_amonestacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Fecha)&&isset($idTrabajador)&&isset($idCartaAmo)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Fecha', 'trabajadores_cartas_amonestacion', '', "Fecha='".$Fecha."' AND idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."' AND idCartaAmo!='".$idCartaAmo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Carta de Amonestacion ya existe en el sistema';}
			/*******************************************************************/
			//verifico que no se ingrese una fecha superior a la fecha actual
			if($Fecha>fecha_actual()){
				$error['ndata_1'] = 'error/No puede ingresar una fecha a futuro inexistente';
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se verifica si la imagen existe
				if (!empty($_FILES['File_Amonestacion']['name'])){

					if ($_FILES["File_Amonestacion"]["error"] > 0){
						$error['File_Amonestacion'] = 'error/'.uploadPHPError($_FILES["File_Amonestacion"]["error"]);
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
						$sufijo = 'amonestacion_'.$idTrabajador.'_'.genera_password_unica().'_';

						if (in_array($_FILES['File_Amonestacion']['type'], $permitidos) && $_FILES['File_Amonestacion']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['File_Amonestacion']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["File_Amonestacion"]["tmp_name"], $ruta);
								if ($move_result){

									//Filtros
									$SIS_data = "idCartaAmo='".$idCartaAmo."'";
									if(isset($idSistema) && $idSistema!=''){                $SIS_data .= ",idSistema='".$idSistema."'";}
									if(isset($idTrabajador) && $idTrabajador!=''){          $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
									if(isset($idUsuario) && $idUsuario!=''){                $SIS_data .= ",idUsuario='".$idUsuario."'";}
									if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){        $SIS_data .= ",Fecha_ingreso='".$Fecha_ingreso."'";}
									if(isset($Fecha) && $Fecha!=''){                        $SIS_data .= ",Fecha='".$Fecha."'";}
									if(isset($idAmonestaciones) && $idAmonestaciones!=''){  $SIS_data .= ",idAmonestaciones='".$idAmonestaciones."'";}
									if(isset($Observacion) && $Observacion!=''){            $SIS_data .= ",Observacion='".$Observacion."'";}
									$SIS_data .= ",File_Amonestacion='".$sufijo.$_FILES['File_Amonestacion']['name']."'";

									/*******************************************************/
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'trabajadores_cartas_amonestacion', 'idCartaAmo = "'.$idCartaAmo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									//Si ejecuto correctamente la consulta
									if($resultado==true){

										header( 'Location: '.$location.'&edited=true' );
										die;

									}
								}else {
									$error['File_Amonestacion']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['File_Amonestacion']     = 'error/El archivo '.$_FILES['File_Amonestacion']['name'].' ya existe';
							}
						} else {
							$error['File_Amonestacion']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{

					//Filtros
					$SIS_data = "idCartaAmo='".$idCartaAmo."'";
					if(isset($idSistema) && $idSistema!=''){                $SIS_data .= ",idSistema='".$idSistema."'";}
					if(isset($idTrabajador) && $idTrabajador!=''){          $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
					if(isset($idUsuario) && $idUsuario!=''){                $SIS_data .= ",idUsuario='".$idUsuario."'";}
					if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){        $SIS_data .= ",Fecha_ingreso='".$Fecha_ingreso."'";}
					if(isset($Fecha) && $Fecha!=''){                        $SIS_data .= ",Fecha='".$Fecha."'";}
					if(isset($idAmonestaciones) && $idAmonestaciones!=''){  $SIS_data .= ",idAmonestaciones='".$idAmonestaciones."'";}
					if(isset($Observacion) && $Observacion!=''){            $SIS_data .= ",Observacion='".$Observacion."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'trabajadores_cartas_amonestacion', 'idCartaAmo = "'.$idCartaAmo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$rowData = db_select_data (false, 'File_Amonestacion', 'trabajadores_cartas_amonestacion', '', 'idCartaAmo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'trabajadores_cartas_amonestacion', 'idCartaAmo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina la foto
					if(isset($rowData['File_Amonestacion'])&&$rowData['File_Amonestacion']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Amonestacion'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Amonestacion']);
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
			$rowData = db_select_data (false, 'File_Amonestacion', 'trabajadores_cartas_amonestacion', '', 'idCartaAmo = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Amonestacion=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_cartas_amonestacion', 'idCartaAmo = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Amonestacion'])&&$rowData['File_Amonestacion']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Amonestacion'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Amonestacion']);
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
