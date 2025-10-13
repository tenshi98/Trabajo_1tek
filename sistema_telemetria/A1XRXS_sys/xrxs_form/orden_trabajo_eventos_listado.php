<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-092).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idEvento']))       $idEvento        = $_POST['idEvento'];
	if (!empty($_POST['idSistema']))      $idSistema       = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))      $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))          $Fecha           = $_POST['Fecha'];
	if (!empty($_POST['Hora']))           $Hora            = $_POST['Hora'];
	if (!empty($_POST['Observacion']))    $Observacion     = $_POST['Observacion'];
	if (!empty($_POST['idCliente']))      $idCliente       = $_POST['idCliente'];
	if (!empty($_POST['idMaquina']))      $idMaquina       = $_POST['idMaquina'];
	if (!empty($_POST['idTrabajador']))   $idTrabajador    = $_POST['idTrabajador'];

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
			case 'idEvento':       if(empty($idEvento)){        $error['idEvento']       = 'error/No ha ingresado el id';}break;
			case 'idSistema':      if(empty($idSistema)){       $error['idSistema']      = 'error/No ha seleccionado un sistema';}break;
			case 'idUsuario':      if(empty($idUsuario)){       $error['idUsuario']      = 'error/No ha seleccionado un usuario';}break;
			case 'Fecha':          if(empty($Fecha)){           $error['Fecha']          = 'error/No ha ingresado la fecha';}break;
			case 'Hora':           if(empty($Hora)){            $error['Hora']           = 'error/No ha ingresado la Hora';}break;
			case 'Observacion':    if(empty($Observacion)){     $error['Observacion']    = 'error/No ha ingresado la observacion';}break;
			case 'idCliente':      if(empty($idCliente)){       $error['idCliente']      = 'error/No ha seleccionado el ciente';}break;
			case 'idMaquina':      if(empty($idMaquina)){       $error['idMaquina']      = 'error/No ha seleccionado la maquina';}break;
			case 'idTrabajador':   if(empty($idTrabajador)){    $error['idTrabajador']   = 'error/No ha seleccionado el trabajador';}break;

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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){        $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){        $SIS_data .= ",'".$idUsuario."'";      }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                $SIS_data .= ",'".$Fecha."'";          }else{$SIS_data .= ",''";}
				if(isset($Hora) && $Hora!=''){                  $SIS_data .= ",'".$Hora."'";           }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){    $SIS_data .= ",'".$Observacion."'";    }else{$SIS_data .= ",''";}
				if(isset($idCliente) && $idCliente!=''){        $SIS_data .= ",'".$idCliente."'";      }else{$SIS_data .= ",''";}
				if(isset($idMaquina) && $idMaquina!=''){        $SIS_data .= ",'".$idMaquina."'";      }else{$SIS_data .= ",''";}
				if(isset($idTrabajador) && $idTrabajador!=''){  $SIS_data .= ",'".$idTrabajador."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, Fecha, Hora, Observacion, idCliente, idMaquina, idTrabajador';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_eventos_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEvento='".$idEvento."'";
				if(isset($idSistema) && $idSistema!=''){         $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Fecha) && $Fecha!=''){                 $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($Hora) && $Hora!=''){                   $SIS_data .= ",Hora='".$Hora."'";}
				if(isset($Observacion) && $Observacion!=''){     $SIS_data .= ",Observacion='".$Observacion."'";}
				if(isset($idCliente) && $idCliente!=''){         $SIS_data .= ",idCliente='".$idCliente."'";}
				if(isset($idMaquina) && $idMaquina!=''){         $SIS_data .= ",idMaquina='".$idMaquina."'";}
				if(isset($idTrabajador) && $idTrabajador!=''){   $SIS_data .= ",idTrabajador='".$idTrabajador."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_eventos_listado', 'idEvento = "'.$idEvento.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				//Listado de archivos
				$SIS_query = 'Nombre';
				$SIS_join  = '';
				$SIS_where = 'idEvento = '.$indice;
				$SIS_order = 0;
				$arrArchivos = array();
				$arrArchivos = db_select_array (false, $SIS_query, 'orden_trabajo_eventos_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado_1 = db_delete_data (false, 'orden_trabajo_eventos_listado', 'idEvento = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'orden_trabajo_eventos_listado_archivos', 'idEvento = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true){

					//se borran los archivos relacionados
					foreach ($arrArchivos as $tipo) {
						//se elimina el archivo
						if(isset($tipo['Nombre'])&&$tipo['Nombre']!=''){
							try {
								if(!is_writable('upload/'.$tipo['Nombre'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$tipo['Nombre']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
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
		//Cambia el nivel del permiso
		case 'submit_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["event_file"]["error"] > 0){
				$error['event_file'] = 'error/'.uploadPHPError($_FILES["event_file"]["error"]);
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
				$sufijo = 'maq_event_'.$idEvento.'_';

				if (in_array($_FILES['event_file']['type'], $permitidos) && $_FILES['event_file']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['event_file']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["event_file"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data  = "'".$idEvento."'";
							$SIS_data .= ",'".$sufijo.$_FILES['event_file']['name']."'";

							// inserto los datos de registro en la db
							$SIS_columns = 'idEvento, Nombre';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_eventos_listado_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Si ejecuto correctamente la consulta
							if($ultimo_id!=0){
								//redirijo
								header( 'Location: '.$location.'&created=true' );
								die;
							}
						} else {
							$error['event_file']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['event_file']     = 'error/El archivo '.$_FILES['event_file']['name'].' ya existe';
					}
				} else {
					$error['event_file']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_file']) OR !validaEntero($_GET['del_file']))&&$_GET['del_file']!=''){
				$indice = simpleDecode($_GET['del_file'], fecha_actual());
			}else{
				$indice = $_GET['del_file'];
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
				$rowData = db_select_data (false, 'Nombre', 'orden_trabajo_eventos_listado_archivos', '', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_eventos_listado_archivos', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
						try {
							if(!is_writable('upload/'.$rowData['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['Nombre']);
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
