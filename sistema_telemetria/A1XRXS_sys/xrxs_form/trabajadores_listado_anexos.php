<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-197).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idBono']))         $idBono        = $_POST['idBono'];
	if (!empty($_POST['idTrabajador']))   $idTrabajador  = $_POST['idTrabajador'];
	if (!empty($_POST['Fecha_ingreso']))  $Fecha_ingreso = $_POST['Fecha_ingreso'];

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
			case 'idBono':         if(empty($idBono)){        $error['idBono']         = 'error/No ha ingresado el id';}break;
			case 'idTrabajador':   if(empty($idTrabajador)){  $error['idTrabajador']   = 'error/No ha seleccionado el trabajador';}break;
			case 'Fecha_ingreso':  if(empty($Fecha_ingreso)){ $error['Fecha_ingreso']  = 'error/No ha ingresado la fecha del anexo';}break;

		}
	}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_Documento':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["Documento"]["error"] > 0){
				$error['Documento'] = 'error/'.uploadPHPError($_FILES["Documento"]["error"]);
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
				$sufijo = 'trabajador_anexo_'.$idTrabajador.'_'.$Fecha_ingreso.'_';

				if (in_array($_FILES['Documento']['type'], $permitidos) && $_FILES['Documento']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Documento']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["Documento"]["tmp_name"], $ruta);
						if ($move_result){

							//Inserto el registro de las mantenciones
							//filtros
							$SIS_data = "'".$sufijo.$_FILES['Documento']['name']."'";
							if(isset($idTrabajador) && $idTrabajador!=''){    $SIS_data .= ",'".$idTrabajador."'";   }else{$SIS_data .= ",''";}
							if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){  $SIS_data .= ",'".$Fecha_ingreso."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'Documento, idTrabajador, Fecha_ingreso';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_listado_anexos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Si ejecuto correctamente la consulta
							if($ultimo_id!=0){
								//redirijo
								header( 'Location: '.$location );
								die;
							}

						} else {
							$error['Documento']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Documento']     = 'error/El archivo '.$_FILES['Documento']['name'].' ya existe';
					}
				} else {
					$error['Documento']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_Documento':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_Documento']) OR !validaEntero($_GET['del_Documento']))&&$_GET['del_Documento']!=''){
				$indice = simpleDecode($_GET['del_Documento'], fecha_actual());
			}else{
				$indice = $_GET['del_Documento'];
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
				$rowData = db_select_data (false, 'Documento', 'trabajadores_listado_anexos', '', 'idAnexo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'trabajadores_listado_anexos', 'idAnexo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowData['Documento'])&&$rowData['Documento']!=''){
						try {
							if(!is_writable('upload/'.$rowData['Documento'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['Documento']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}

					//redirijo
					header( 'Location: '.$location.'&id_img=true' );
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
