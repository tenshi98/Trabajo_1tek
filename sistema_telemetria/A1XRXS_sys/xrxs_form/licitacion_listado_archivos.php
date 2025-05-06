<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-088).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idArchivos']))     $idArchivos      = $_POST['idArchivos'];
	if (!empty($_POST['idLicitacion']))   $idLicitacion    = $_POST['idLicitacion'];
	if (!empty($_POST['idUsuario']))      $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['Fecha_ingreso']))  $Fecha_ingreso   = $_POST['Fecha_ingreso'];
	if (!empty($_POST['Detalle']))        $Detalle         = $_POST['Detalle'];

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
			case 'idArchivos':     if(empty($idArchivos)){      $error['idArchivos']     = 'error/No ha ingresado el id';}break;
			case 'idLicitacion':   if(empty($idLicitacion)){    $error['idLicitacion']   = 'error/No ha seleccionado el contrato';}break;
			case 'idUsuario':      if(empty($idUsuario)){       $error['idUsuario']      = 'error/No ha seleccionado un usuario';}break;
			case 'Fecha_ingreso':  if(empty($Fecha_ingreso)){   $error['Fecha_ingreso']  = 'error/No ha ingresado la fecha';}break;
			case 'Detalle':        if(empty($Detalle)){         $error['Detalle']        = 'error/No ha ingresado la observacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Detalle) && $Detalle!=''){  $Detalle = EstandarizarInput($Detalle);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Detalle)&&contar_palabras_censuradas($Detalle)!=0){  $error['Detalle'] = 'error/Edita Detalle, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'new_archivo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["NombreArchivo"]["error"] > 0){
				$error['NombreArchivo'] = 'error/'.uploadPHPError($_FILES["NombreArchivo"]["error"]);
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
				$sufijo = 'Licitacion_'.$idLicitacion.'_'.$Fecha_ingreso.'_';

				if (in_array($_FILES['NombreArchivo']['type'], $permitidos) && $_FILES['NombreArchivo']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['NombreArchivo']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["NombreArchivo"]["tmp_name"], $ruta);
						if ($move_result){

							//Inserto el registro de las mantenciones
							//filtros
							$SIS_data = "'".$sufijo.$_FILES['NombreArchivo']['name']."'";
							if(isset($idLicitacion) && $idLicitacion!=''){    $SIS_data .= ",'".$idLicitacion."'";  }else{$SIS_data .= ",''";}
							if(isset($idUsuario) && $idUsuario!=''){          $SIS_data .= ",'".$idUsuario."'";     }else{$SIS_data .= ",''";}
							if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){  $SIS_data .= ",'".$Fecha_ingreso."'"; }else{$SIS_data .= ",''";}
							if(isset($Detalle) && $Detalle!=''){              $SIS_data .= ",'".$Detalle."'";       }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'NombreArchivo, idLicitacion, idUsuario, Fecha_ingreso, Detalle';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Si ejecuto correctamente la consulta
							if($ultimo_id!=0){
								//redirijo
								header( 'Location: '.$location.'&created=true' );
								die;
							}

						} else {
							$error['NombreArchivo']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['NombreArchivo']     = 'error/El archivo '.$_FILES['NombreArchivo']['name'].' ya existe';
					}
				} else {
					$error['NombreArchivo']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_Archivo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_archivo']) OR !validaEntero($_GET['del_archivo']))&&$_GET['del_archivo']!=''){
				$indice = simpleDecode($_GET['del_archivo'], fecha_actual());
			}else{
				$indice = $_GET['del_archivo'];
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
				// Se obtiene el nombre del documento a borrar
				$rowMantencion = db_select_data (false, 'NombreArchivo', 'licitacion_listado_archivos', '', 'idArchivos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'licitacion_listado_archivos', 'idArchivos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowMantencion['NombreArchivo'])&&$rowMantencion['NombreArchivo']!=''){
						try {
							if(!is_writable('upload/'.$rowMantencion['NombreArchivo'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowMantencion['NombreArchivo']);
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
