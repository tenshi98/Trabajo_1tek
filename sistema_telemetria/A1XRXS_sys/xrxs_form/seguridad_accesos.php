<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-113).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de idUsuarioes input a variables
	if (!empty($_POST['idAcceso']))              $idAcceso               = $_POST['idAcceso'];
	if (!empty($_POST['idSistema']))             $idSistema              = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))             $idUsuario              = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))                 $Fecha                  = $_POST['Fecha'];
	if (!empty($_POST['Hora']))                  $Hora                   = $_POST['Hora'];
	if (!empty($_POST['HoraSalida']))            $HoraSalida             = $_POST['HoraSalida'];
	if (!empty($_POST['Nombre']))                $Nombre                 = $_POST['Nombre'];
	if (!empty($_POST['Rut']))                   $Rut                    = $_POST['Rut'];
	if (!empty($_POST['NDocCedula']))            $NDocCedula             = $_POST['NDocCedula'];
	if (!empty($_POST['Destino']))               $Destino                = $_POST['Destino'];
	if (!empty($_POST['idUbicacion']))           $idUbicacion            = $_POST['idUbicacion'];
	if (!empty($_POST['idUbicacion_lvl_1']))     $idUbicacion_lvl_1      = $_POST['idUbicacion_lvl_1'];
	if (!empty($_POST['idUbicacion_lvl_2']))     $idUbicacion_lvl_2      = $_POST['idUbicacion_lvl_2'];
	if (!empty($_POST['idUbicacion_lvl_3']))     $idUbicacion_lvl_3      = $_POST['idUbicacion_lvl_3'];
	if (!empty($_POST['idUbicacion_lvl_4']))     $idUbicacion_lvl_4      = $_POST['idUbicacion_lvl_4'];
	if (!empty($_POST['idUbicacion_lvl_5']))     $idUbicacion_lvl_5      = $_POST['idUbicacion_lvl_5'];
	if (!empty($_POST['PersonaReunion']))        $PersonaReunion         = $_POST['PersonaReunion'];
	if (!empty($_POST['idEstado']))              $idEstado               = $_POST['idEstado'];

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
			case 'idAcceso':           if(empty($idAcceso)){           $error['idAcceso']           = 'error/No ha ingresado el id';}break;
			case 'idSistema':          if(empty($idSistema)){          $error['idSistema']          = 'error/No ha seleccionado el Sistema';}break;
			case 'idUsuario':          if(empty($idUsuario)){          $error['idUsuario']          = 'error/No ha seleccionado el Usuario';}break;
			case 'Fecha':              if(empty($Fecha)){              $error['Fecha']              = 'error/No ha ingresado la fecha';}break;
			case 'Hora':               if(empty($Hora)){               $error['Hora']               = 'error/No ha ingresado la hora de entrada';}break;
			case 'HoraSalida':         if(empty($HoraSalida)){         $error['HoraSalida']         = 'error/No ha ingresado la hora de salida';}break;
			case 'Nombre':             if(empty($Nombre)){             $error['Nombre']             = 'error/No ha ingresado el nombre';}break;
			case 'Rut':                if(empty($Rut)){                $error['Rut']                = 'error/No ha ingresado el Rut';}break;
			case 'NDocCedula':         if(empty($NDocCedula)){         $error['NDocCedula']         = 'error/No ha ingresado el Numero Documento de la Cedula';}break;
			case 'Destino':            if(empty($Destino)){            $error['Destino']            = 'error/No ha ingresado el Destino';}break;
			case 'idUbicacion':        if(empty($idUbicacion)){        $error['idUbicacion']        = 'error/No ha ingresado la ubicacion';}break;
			case 'idUbicacion_lvl_1':  if(empty($idUbicacion_lvl_1)){  $error['idUbicacion_lvl_1']  = 'error/No ha ingresado el nivel 1 de ubicacion';}break;
			case 'idUbicacion_lvl_2':  if(empty($idUbicacion_lvl_2)){  $error['idUbicacion_lvl_2']  = 'error/No ha ingresado el nivel 2 de ubicacion';}break;
			case 'idUbicacion_lvl_3':  if(empty($idUbicacion_lvl_3)){  $error['idUbicacion_lvl_3']  = 'error/No ha ingresado el nivel 3 de ubicacion';}break;
			case 'idUbicacion_lvl_4':  if(empty($idUbicacion_lvl_4)){  $error['idUbicacion_lvl_4']  = 'error/No ha ingresado el nivel 4 de ubicacion';}break;
			case 'idUbicacion_lvl_5':  if(empty($idUbicacion_lvl_5)){  $error['idUbicacion_lvl_5']  = 'error/No ha ingresado el nivel 5 de ubicacion';}break;
			case 'PersonaReunion':     if(empty($PersonaReunion)){     $error['PersonaReunion']     = 'error/No ha ingresado la persona de la reunion';}break;
			case 'idEstado':           if(empty($idEstado)){           $error['idEstado']           = 'error/No ha seleccionado el estado';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                 $Nombre         = EstandarizarInput($Nombre);}
	if(isset($Destino) && $Destino!=''){               $Destino        = EstandarizarInput($Destino);}
	if(isset($PersonaReunion) && $PersonaReunion!=''){ $PersonaReunion = EstandarizarInput($PersonaReunion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                  $error['Nombre']         = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Destino)&&contar_palabras_censuradas($Destino)!=0){                $error['Destino']        = 'error/Edita Destino, contiene palabras no permitidas';}
	if(isset($PersonaReunion)&&contar_palabras_censuradas($PersonaReunion)!=0){  $error['PersonaReunion'] = 'error/Edita la Persona de Reunion, contiene palabras no permitidas';}

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

				//se verifica si la imagen existe
				if (!empty($_FILES['Direccion_img']['name'])){

					if ($_FILES["Direccion_img"]["error"] > 0){
						$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'acceso_img_'.genera_password_unica().'_';

						if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								//$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
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

									//filtros
									if(isset($idSistema) && $idSistema!=''){                  $SIS_data  = "'".$idSistema."'";           }else{$SIS_data  = "''";}
									if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";          }else{$SIS_data .= ",''";}
									if(isset($Fecha) && $Fecha!=''){                          $SIS_data .= ",'".$Fecha."'";              }else{$SIS_data .= ",''";}
									if(isset($Hora) && $Hora!=''){                            $SIS_data .= ",'".$Hora."'";               }else{$SIS_data .= ",''";}
									if(isset($HoraSalida) && $HoraSalida!=''){                $SIS_data .= ",'".$HoraSalida."'";         }else{$SIS_data .= ",''";}
									if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",'".$Nombre."'";             }else{$SIS_data .= ",''";}
									if(isset($Rut) && $Rut!=''){                              $SIS_data .= ",'".$Rut."'";                }else{$SIS_data .= ",''";}
									if(isset($NDocCedula) && $NDocCedula!=''){                $SIS_data .= ",'".$NDocCedula."'";         }else{$SIS_data .= ",''";}
									if(isset($Destino) && $Destino!=''){                      $SIS_data .= ",'".$Destino."'";            }else{$SIS_data .= ",''";}
									if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",'".$idUbicacion."'";        }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",'".$idUbicacion_lvl_1."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",'".$idUbicacion_lvl_2."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",'".$idUbicacion_lvl_3."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",'".$idUbicacion_lvl_4."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",'".$idUbicacion_lvl_5."'";  }else{$SIS_data .= ",''";}
									if(isset($PersonaReunion) && $PersonaReunion!=''){        $SIS_data .= ",'".$PersonaReunion."'";     }else{$SIS_data .= ",''";}
									if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";           }else{$SIS_data .= ",''";}
									$SIS_data .= ",'".$sufijo.$_FILES['Direccion_img']['name']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idSistema, idUsuario, Fecha, Hora, HoraSalida, Nombre,Rut,
									NDocCedula, Destino, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3,
									idUbicacion_lvl_4, idUbicacion_lvl_5, PersonaReunion, idEstado, Direccion_img';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_accesos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($ultimo_id!=0){
										//redirijo
										header( 'Location: '.$location.'&created=true' );
										die;
									}

								}else {
									$error['Direccion_img']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['Direccion_img']     = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
							}
						} else {
							$error['Direccion_img']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{

					//filtros
					if(isset($idSistema) && $idSistema!=''){                  $SIS_data  = "'".$idSistema."'";           }else{$SIS_data  = "''";}
					if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";          }else{$SIS_data .= ",''";}
					if(isset($Fecha) && $Fecha!=''){                          $SIS_data .= ",'".$Fecha."'";              }else{$SIS_data .= ",''";}
					if(isset($Hora) && $Hora!=''){                            $SIS_data .= ",'".$Hora."'";               }else{$SIS_data .= ",''";}
					if(isset($HoraSalida) && $HoraSalida!=''){                $SIS_data .= ",'".$HoraSalida."'";         }else{$SIS_data .= ",''";}
					if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",'".$Nombre."'";             }else{$SIS_data .= ",''";}
					if(isset($Rut) && $Rut!=''){                              $SIS_data .= ",'".$Rut."'";                }else{$SIS_data .= ",''";}
					if(isset($NDocCedula) && $NDocCedula!=''){                $SIS_data .= ",'".$NDocCedula."'";         }else{$SIS_data .= ",''";}
					if(isset($Destino) && $Destino!=''){                      $SIS_data .= ",'".$Destino."'";            }else{$SIS_data .= ",''";}
					if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",'".$idUbicacion."'";        }else{$SIS_data .= ",''";}
					if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",'".$idUbicacion_lvl_1."'";  }else{$SIS_data .= ",''";}
					if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",'".$idUbicacion_lvl_2."'";  }else{$SIS_data .= ",''";}
					if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",'".$idUbicacion_lvl_3."'";  }else{$SIS_data .= ",''";}
					if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",'".$idUbicacion_lvl_4."'";  }else{$SIS_data .= ",''";}
					if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",'".$idUbicacion_lvl_5."'";  }else{$SIS_data .= ",''";}
					if(isset($PersonaReunion) && $PersonaReunion!=''){        $SIS_data .= ",'".$PersonaReunion."'";     }else{$SIS_data .= ",''";}
					if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";           }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idSistema, idUsuario, Fecha, Hora, HoraSalida, Nombre,Rut,
					NDocCedula, Destino, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3,
					idUbicacion_lvl_4, idUbicacion_lvl_5, PersonaReunion, idEstado';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_accesos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se verifica si la imagen existe
				if (!empty($_FILES['Direccion_img']['name'])){

					if ($_FILES["Direccion_img"]["error"] > 0){
						$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'acceso_img_'.genera_password_unica().'_';

						if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								//$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
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

									//Filtros
									$SIS_data = "idAcceso='".$idAcceso."'";
									if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",idSistema='".$idSistema."'";}
									if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",idUsuario='".$idUsuario."'";}
									if(isset($Fecha) && $Fecha!=''){                          $SIS_data .= ",Fecha='".$Fecha."'";}
									if(isset($Hora) && $Hora!=''){                            $SIS_data .= ",Hora='".$Hora."'";}
									if(isset($HoraSalida) && $HoraSalida!=''){                $SIS_data .= ",HoraSalida='".$HoraSalida."'";}
									if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",Nombre='".$Nombre."'";}
									if(isset($Rut) && $Rut!=''){                              $SIS_data .= ",Rut='".$Rut."'";}
									if(isset($NDocCedula) && $NDocCedula!=''){                $SIS_data .= ",NDocCedula='".$NDocCedula."'";}
									if(isset($Destino) && $Destino!=''){                      $SIS_data .= ",Destino='".$Destino."'";}
									if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
									if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",idUbicacion_lvl_1='".$idUbicacion_lvl_1."'";}
									if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",idUbicacion_lvl_2='".$idUbicacion_lvl_2."'";}
									if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",idUbicacion_lvl_3='".$idUbicacion_lvl_3."'";}
									if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",idUbicacion_lvl_4='".$idUbicacion_lvl_4."'";}
									if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",idUbicacion_lvl_5='".$idUbicacion_lvl_5."'";}
									if(isset($PersonaReunion) && $PersonaReunion!=''){        $SIS_data .= ",PersonaReunion='".$PersonaReunion."'";}
									if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",idEstado='".$idEstado."'";}
									$SIS_data .= ",Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'";

									/*******************************************************/
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'seguridad_accesos', 'idAcceso = "'.$idAcceso.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									//Si ejecuto correctamente la consulta
									if($resultado==true){

										header( 'Location: '.$location.'&edited=true' );
										die;

									}
								}else {
									$error['Direccion_img']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['Direccion_img']     = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
							}
						} else {
							$error['Direccion_img']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{

					//Filtros
					$SIS_data = "idAcceso='".$idAcceso."'";
					if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",idSistema='".$idSistema."'";}
					if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",idUsuario='".$idUsuario."'";}
					if(isset($Fecha) && $Fecha!=''){                          $SIS_data .= ",Fecha='".$Fecha."'";}
					if(isset($Hora) && $Hora!=''){                            $SIS_data .= ",Hora='".$Hora."'";}
					if(isset($HoraSalida) && $HoraSalida!=''){                $SIS_data .= ",HoraSalida='".$HoraSalida."'";}
					if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",Nombre='".$Nombre."'";}
					if(isset($Rut) && $Rut!=''){                              $SIS_data .= ",Rut='".$Rut."'";}
					if(isset($NDocCedula) && $NDocCedula!=''){                $SIS_data .= ",NDocCedula='".$NDocCedula."'";}
					if(isset($Destino) && $Destino!=''){                      $SIS_data .= ",Destino='".$Destino."'";}
					if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
					if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",idUbicacion_lvl_1='".$idUbicacion_lvl_1."'";}
					if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",idUbicacion_lvl_2='".$idUbicacion_lvl_2."'";}
					if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",idUbicacion_lvl_3='".$idUbicacion_lvl_3."'";}
					if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",idUbicacion_lvl_4='".$idUbicacion_lvl_4."'";}
					if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",idUbicacion_lvl_5='".$idUbicacion_lvl_5."'";}
					if(isset($PersonaReunion) && $PersonaReunion!=''){        $SIS_data .= ",PersonaReunion='".$PersonaReunion."'";}
					if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",idEstado='".$idEstado."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'seguridad_accesos', 'idAcceso = "'.$idAcceso.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$rowData = db_select_data (false, 'Direccion_img', 'seguridad_accesos', '', "idAcceso = ".$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'seguridad_accesos', 'idAcceso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina la foto
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
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Usuario
			$idAcceso = $_GET['del_img'];
			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'Direccion_img', 'seguridad_accesos', '', "idAcceso = ".$idAcceso, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'seguridad_accesos', 'idAcceso = "'.$idAcceso.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				header( 'Location: '.$location.'&id='.$idAcceso );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
