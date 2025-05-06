<?php
//Llamamos a la libreria para importar datos en excel
require '../LIBS_php/PhpOffice/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-094).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idPostulante']))                $idPostulante                 = $_POST['idPostulante'];
	if (!empty($_POST['idSistema']))                   $idSistema                    = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))                    $idEstado                     = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))                      $Nombre                       = $_POST['Nombre'];
	if (!empty($_POST['ApellidoPat']))                 $ApellidoPat                  = $_POST['ApellidoPat'];
	if (!empty($_POST['ApellidoMat']))                 $ApellidoMat                  = $_POST['ApellidoMat'];
	if (!empty($_POST['idSexo']))                      $idSexo                       = $_POST['idSexo'];
	if (!empty($_POST['FNacimiento']))                 $FNacimiento                  = $_POST['FNacimiento'];
	if (!empty($_POST['idEstadoCivil']))               $idEstadoCivil                = $_POST['idEstadoCivil'];
	if (!empty($_POST['Fono1']))                       $Fono1                        = $_POST['Fono1'];
	if (!empty($_POST['Fono2']))                       $Fono2                        = $_POST['Fono2'];
	if (!empty($_POST['Rut']))                         $Rut                          = $_POST['Rut'];
	if (!empty($_POST['idCiudad']))                    $idCiudad                     = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))                    $idComuna                     = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))                   $Direccion                    = $_POST['Direccion'];
	if (!empty($_POST['Observaciones']))               $Observaciones                = $_POST['Observaciones'];
	if (!empty($_POST['SueldoLiquido']))               $SueldoLiquido                = $_POST['SueldoLiquido'];
	if (!empty($_POST['idTipoLicencia']))              $idTipoLicencia               = $_POST['idTipoLicencia'];
	if (!empty($_POST['idEstadoContrato']))            $idEstadoContrato             = $_POST['idEstadoContrato'];
	if (!empty($_POST['email']))                       $email                        = $_POST['email'];

	if (!empty($_POST['idOpciones']))                  $idOpciones                   = $_POST['idOpciones'];

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
			case 'idPostulante':                if(empty($idPostulante)){                 $error['idPostulante']                 = 'error/No ha ingresado el id';}break;
			case 'idSistema':                   if(empty($idSistema)){                    $error['idSistema']                    = 'error/No ha seleccionado el sistema al cual pertenece';}break;
			case 'idEstado':                    if(empty($idEstado)){                     $error['idEstado']                     = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':                      if(empty($Nombre)){                       $error['Nombre']                       = 'error/No ha ingresado el nombre de la persona';}break;
			case 'ApellidoPat':                 if(empty($ApellidoPat)){                  $error['ApellidoPat']                  = 'error/No ha ingresado el apellido paterno de la persona';}break;
			case 'ApellidoMat':                 if(empty($ApellidoMat)){                  $error['ApellidoMat']                  = 'error/No ha ingresado el apellido materno de la persona';}break;
			case 'idSexo':                      if(empty($idSexo)){                       $error['idSexo']                       = 'error/No ha seleccionado el sexo';}break;
			case 'FNacimiento':                 if(empty($FNacimiento)){                  $error['FNacimiento']                  = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'idEstadoCivil':               if(empty($idEstadoCivil)){                $error['idEstadoCivil']                = 'error/No ha seleccionado estado civil';}break;
			case 'Fono1':                       if(empty($Fono1)){                        $error['Fono1']                        = 'error/No ha ingresado el fono';}break;
			case 'Fono2':                       if(empty($Fono2)){                        $error['Fono2']                        = 'error/No ha ingresado el fono';}break;
			case 'Rut':                         if(empty($Rut)){                          $error['Rut']                          = 'error/No ha ingresado el rut';}break;
			case 'idCiudad':                    if(empty($idCiudad)){                     $error['idCiudad']                     = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':                    if(empty($idComuna)){                     $error['idComuna']                     = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':                   if(empty($Direccion)){                    $error['Direccion']                    = 'error/No ha ingresado la dirección';}break;
			case 'Observaciones':               if(empty($Observaciones)){                $error['Observaciones']                = 'error/No ha ingresado la observacion';}break;
			case 'SueldoLiquido':               if(empty($SueldoLiquido)){                $error['SueldoLiquido']                = 'error/No ha ingresado el sueldo liquido a pago';}break;
			case 'idTipoLicencia':              if(empty($idTipoLicencia)){               $error['idTipoLicencia']               = 'error/No ha Seleccionado el tipo de licencia';}break;
			case 'idEstadoContrato':            if(empty($idEstadoContrato)){             $error['idEstadoContrato']             = 'error/No ha Seleccionado el estado del contrato';}break;
			case 'email':                       if(empty($email)){                        $error['email']                        = 'error/No ha ingresado el email';}break;

			case 'idOpciones':                  if(empty($idOpciones)){                   $error['idOpciones']                   = 'error/No ha seleccionado el envio de correos';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                $Nombre        = EstandarizarInput($Nombre);}
	if(isset($ApellidoPat) && $ApellidoPat!=''){      $ApellidoPat   = EstandarizarInput($ApellidoPat);}
	if(isset($ApellidoMat) && $ApellidoMat!=''){      $ApellidoMat   = EstandarizarInput($ApellidoMat);}
	if(isset($Direccion) && $Direccion!=''){          $Direccion     = EstandarizarInput($Direccion);}
	if(isset($Observaciones) && $Observaciones!=''){  $Observaciones = EstandarizarInput($Observaciones);}
	//if(isset($email) && $email!=''){                  $email         = EstandarizarInput($email);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($Fono1)&&!validarNumero($Fono1)){       $error['Fono1']  = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono2)&&!validarNumero($Fono2)){       $error['Fono2']  = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono1)&&palabra_corto($Fono1, 9)!=1){  $error['Fono1']  = 'error/'.palabra_corto($Fono1, 9);}
	if(isset($Fono2)&&palabra_corto($Fono2, 9)!=1){  $error['Fono2']  = 'error/'.palabra_corto($Fono2, 9);}
	//if(isset($Rut)&&!validarRut($Rut)){       $error['Rut']    = 'error/El Rut ingresado no es valido';}

	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($ApellidoPat)&&contar_palabras_censuradas($ApellidoPat)!=0){      $error['ApellidoPat']   = 'error/Edita Apellido Pat, contiene palabras no permitidas';}
	if(isset($ApellidoMat)&&contar_palabras_censuradas($ApellidoMat)!=0){      $error['ApellidoMat']   = 'error/Edita Apellido Mat, contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){          $error['Direccion']     = 'error/Edita la Direccion, contiene palabras no permitidas';}
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($email)&&!validarEmail($email)){                                  $error['email']         = 'error/El Email ingresado no es valido';}

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
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'postulantes_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'postulantes_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Postulante que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data  = "'".$idSistema."'";                }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";                }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",'".$Nombre."'";                  }else{$SIS_data .= ",''";}
				if(isset($ApellidoPat) && $ApellidoPat!=''){              $SIS_data .= ",'".$ApellidoPat."'";             }else{$SIS_data .= ",''";}
				if(isset($ApellidoMat) && $ApellidoMat!=''){              $SIS_data .= ",'".$ApellidoMat."'";             }else{$SIS_data .= ",''";}
				if(isset($idSexo) && $idSexo!=''){                        $SIS_data .= ",'".$idSexo."'";                  }else{$SIS_data .= ",''";}
				if(isset($FNacimiento) && $FNacimiento!=''){              $SIS_data .= ",'".$FNacimiento."'";             }else{$SIS_data .= ",''";}
				if(isset($idEstadoCivil) && $idEstadoCivil!=''){          $SIS_data .= ",'".$idEstadoCivil."'";           }else{$SIS_data .= ",''";}
				if(isset($Fono1) && $Fono1!=''){                          $SIS_data .= ",'".$Fono1."'";                   }else{$SIS_data .= ",''";}
				if(isset($Fono2) && $Fono2!=''){                          $SIS_data .= ",'".$Fono2."'";                   }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                              $SIS_data .= ",'".$Rut."'";                     }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                    $SIS_data .= ",'".$idCiudad."'";                }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                    $SIS_data .= ",'".$idComuna."'";                }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){                  $SIS_data .= ",'".$Direccion."'";               }else{$SIS_data .= ",''";}
				if(isset($Observaciones) && $Observaciones!=''){          $SIS_data .= ",'".$Observaciones."'";           }else{$SIS_data .= ",''";}
				if(isset($SueldoLiquido) && $SueldoLiquido!=''){          $SIS_data .= ",'".$SueldoLiquido."'";           }else{$SIS_data .= ",''";}
				if(isset($idTipoLicencia) && $idTipoLicencia!=''){        $SIS_data .= ",'".$idTipoLicencia."'";          }else{$SIS_data .= ",''";}
				if(isset($idEstadoContrato) && $idEstadoContrato!=''){    $SIS_data .= ",'".$idEstadoContrato."'";        }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                          $SIS_data .= ",'".$email."'";                   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, Nombre,ApellidoPat, ApellidoMat,idSexo,FNacimiento, idEstadoCivil, Fono1, Fono2, Rut, idCiudad, idComuna, Direccion, Observaciones, SueldoLiquido, idTipoLicencia, idEstadoContrato, email';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'postulantes_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)&&isset($idPostulante)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'postulantes_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."' AND idPostulante!='".$idPostulante."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idPostulante)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'postulantes_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idPostulante!='".$idPostulante."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Postulante que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idPostulante='".$idPostulante."'";
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($ApellidoPat) && $ApellidoPat!=''){              $SIS_data .= ",ApellidoPat='".$ApellidoPat."'";}
				if(isset($ApellidoMat) && $ApellidoMat!=''){              $SIS_data .= ",ApellidoMat='".$ApellidoMat."'";}
				if(isset($idSexo) && $idSexo!=''){                        $SIS_data .= ",idSexo='".$idSexo."'";}
				if(isset($FNacimiento) && $FNacimiento!=''){              $SIS_data .= ",FNacimiento='".$FNacimiento."'";}
				if(isset($idEstadoCivil) && $idEstadoCivil!=''){          $SIS_data .= ",idEstadoCivil='".$idEstadoCivil."'";}
				if(isset($Fono1) && $Fono1!=''){                          $SIS_data .= ",Fono1='".$Fono1."'";}
				if(isset($Fono2) && $Fono2!=''){                          $SIS_data .= ",Fono2='".$Fono2."'";}
				if(isset($Rut) && $Rut!=''){                              $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($idCiudad) && $idCiudad!=''){                    $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){                    $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){                  $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Observaciones) && $Observaciones!=''){          $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($SueldoLiquido) && $SueldoLiquido!=''){          $SIS_data .= ",SueldoLiquido='".$SueldoLiquido."'";}
				if(isset($idTipoLicencia) && $idTipoLicencia!=''){        $SIS_data .= ",idTipoLicencia='".$idTipoLicencia."'";}
				if(isset($idEstadoContrato) && $idEstadoContrato!=''){    $SIS_data .= ",idEstadoContrato='".$idEstadoContrato."'";}
				if(isset($email) && $email!=''){                          $SIS_data .= ",email='".$email."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'postulantes_listado', 'idPostulante = "'.$idPostulante.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
				$rowData = db_select_data (false, 'File_Curriculum', 'postulantes_listado', '', 'idPostulante = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'postulantes_listado', 'idPostulante = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el curriculum
					if(isset($rowData['File_Curriculum'])&&$rowData['File_Curriculum']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Curriculum'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Curriculum']);
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

			$idPostulante  = $_GET['id'];
			$idEstado      = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'postulantes_listado', 'idPostulante = "'.$idPostulante.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;

/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_curriculum':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["File_Curriculum"]["error"] > 0){
				$error['File_Curriculum'] = 'error/'.uploadPHPError($_FILES["File_Curriculum"]["error"]);
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
				$sufijo = 'post_curriculum_'.$idPostulante.'_';

				if (in_array($_FILES['File_Curriculum']['type'], $permitidos) && $_FILES['File_Curriculum']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['File_Curriculum']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["File_Curriculum"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "File_Curriculum='".$sufijo.$_FILES['File_Curriculum']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'postulantes_listado', 'idPostulante = "'.$idPostulante.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								header( 'Location: '.$location );
								die;
							}
						} else {
							$error['File_Curriculum']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['File_Curriculum']     = 'error/El archivo '.$_FILES['File_Curriculum']['name'].' ya existe';
					}
				} else {
					$error['File_Curriculum']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_File_Curriculum':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_Curriculum', 'postulantes_listado', '', 'idPostulante = "'.$_GET['del_File_Curriculum'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Curriculum=''";
			$resultado = db_update_data (false, $SIS_data, 'postulantes_listado', 'idPostulante = "'.$_GET['del_File_Curriculum'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Curriculum'])&&$rowData['File_Curriculum']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Curriculum'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Curriculum']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'estadoContrato':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idPostulante  = $_GET['id'];
			$idEstado      = simpleDecode($_GET['estadoContrato'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstadoContrato='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'postulantes_listado', 'idPostulante = "'.$idPostulante.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'insert_plant':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se verifica si la imagen existe
				if (!empty($_FILES['FilePostulante']['name'])){

					if ($_FILES['FilePostulante']["error"] > 0){
						$error['FilePostulante'] = 'error/'.uploadPHPError($_FILES["FilePostulante"]["error"]);
					} else {

						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
										);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;

						if (in_array($_FILES['FilePostulante']['type'], $permitidos) && $_FILES['FilePostulante']['size'] <= $limite_kb * 1024){

							/*******************************************************************/
							//variables
							$ndata_1  = 0;
							$ndata_2  = 0;
							$ndata_3  = 0;
							//Cargo el archivo
							$spreadsheet = IOFactory::load($_FILES['FilePostulante']['tmp_name']);
							//Obtengo los nombres de las hojas
							$loadedSheetNames = $spreadsheet->getSheetNames();
							//recorro las hojas
							foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
								//seteo la hoja
								$spreadsheet->setActiveSheetIndex($sheetIndex);
								//selecciono la hoja
								$worksheet = $spreadsheet->getActiveSheet();
								//obtengo el total de datos
								$highestRow = $worksheet->getHighestRow();
								//si es una hoja en especifico
								if ($loadedSheetName == "Postulantes"){
									//recorro
									for ($row=2; $row<=$highestRow; $row++){
										$Post_Nombre = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
										$Post_Rut    = $worksheet->getCellByColumnAndRow(4,  $row)->getValue();
										$Post_Email  = $worksheet->getCellByColumnAndRow(11,  $row)->getValue();
										//si existe nombre
										if(isset($Post_Nombre)&&$Post_Nombre!=''){
											//si existe el rut
											if(!isset($Post_Rut) OR $Post_Rut==''){
												$ndata_1++;
											}
											//verifico si el rut ingresado en el excel existe
											if(isset($Post_Rut)&&$Post_Rut!=''){
												$SIS_query = 'Rut';
												$SIS_join  = '';
												$SIS_where = 'idSistema='.$idSistema.' AND Rut="'.$Post_Rut.'"';
												$nRows = db_select_nrows (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'nRows');

												//Si existe se marca error
												if(isset($nRows)&&$nRows!=0){
													$ndata_2++;
												}
											}
											//Verifico la existencia de un email
											if(isset($Post_Email)&&$Post_Email!=''&&!validarEmail($Post_Email)){
												$ndata_3++;
											}
										}
									}
								}
							}
							/*******************************************************************/
							//generacion de errores
							if($ndata_1 > 0) {  $error['ndata_1']  = 'error/El postulante ingresado no tiene rut';}
							if($ndata_2 > 0) {  $error['ndata_2']  = 'error/El postulante ingresado ya existe en el sistema';}
							if($ndata_3 > 0) {  $error['ndata_3']  = 'error/El Email ingresado no es valido';}

							/*******************************************************************/
							//Si no hay errores ejecuto el codigo
							if(empty($error)){

								/*******************************************************************/
								//Cargo a todos los clientes del sistema
								$arrSexo   = array();
								$arrCiudad = array();
								$arrComuna = array();

								$arrSexo   = db_select_array (false, 'idSexo,Nombre', 'core_sexo', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrCiudad = db_select_array (false, 'idCiudad,Nombre', 'core_ubicacion_ciudad', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrComuna = db_select_array (false, 'idComuna,Nombre', 'core_ubicacion_comunas', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//recorro los datos
								$arrSexoMod   = array();
								$arrCiudadMod = array();
								$arrComunaMod = array();
								foreach ($arrSexo as $data) {   $arrSexoMod[$data['Nombre']]['ID']   = $data['idSexo'];}
								foreach ($arrCiudad as $data) { $arrCiudadMod[$data['Nombre']]['ID'] = $data['idCiudad'];}
								foreach ($arrComuna as $data) { $arrComunaMod[$data['Nombre']]['ID'] = $data['idComuna'];}

								/*******************************************************************/
								//Cargo el archivo
								$spreadsheet = IOFactory::load($_FILES['FilePostulante']['tmp_name']);
								//Obtengo los nombres de las hojas
								$loadedSheetNames = $spreadsheet->getSheetNames();
								//recorro las hojas
								foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
									//seteo la hoja
									$spreadsheet->setActiveSheetIndex($sheetIndex);
									//selecciono la hoja
									$worksheet = $spreadsheet->getActiveSheet();
									//obtengo el total de datos
									$highestRow = $worksheet->getHighestRow();
									//si es una hoja en especifico
									if ($loadedSheetName == "Postulantes"){
										//recorro
										for ($row=2; $row<=$highestRow; $row++){
											$Post_Nombre     = $worksheet->getCellByColumnAndRow(1,   $row)->getValue();
											$Post_Ape_Pat    = $worksheet->getCellByColumnAndRow(2,   $row)->getValue();
											$Post_Ape_Mat    = $worksheet->getCellByColumnAndRow(3,   $row)->getValue();
											$Post_Rut        = $worksheet->getCellByColumnAndRow(4,   $row)->getValue();
											$Post_Sexo       = $worksheet->getCellByColumnAndRow(5,   $row)->getValue();
											$Post_Fono1      = $worksheet->getCellByColumnAndRow(6,   $row)->getValue();
											$Post_Fono2      = $worksheet->getCellByColumnAndRow(7,   $row)->getValue();
											$Post_Ciudad     = $worksheet->getCellByColumnAndRow(8,   $row)->getValue();
											$Post_Comuna     = $worksheet->getCellByColumnAndRow(9,   $row)->getValue();
											$Post_Direccion  = $worksheet->getCellByColumnAndRow(10,  $row)->getValue();
											$Post_Email      = $worksheet->getCellByColumnAndRow(11,  $row)->getValue();
											//si existe nombre
											if(isset($Post_Nombre)&&$Post_Nombre!=''){
												//verifico si existen los datos
												if(isset($Post_Sexo)&&isset($arrSexoMod[$Post_Sexo]['ID'])){        $ID_Sexo    = $arrSexoMod[$Post_Sexo]['ID'];}
												if(isset($Post_Ciudad)&&isset($arrCiudadMod[$Post_Ciudad]['ID'])){  $ID_Ciudad  = $arrCiudadMod[$Post_Ciudad]['ID'];}
												if(isset($Post_Comuna)&&isset($arrComunaMod[$Post_Comuna]['ID'])){  $ID_Comuna  = $arrComunaMod[$Post_Comuna]['ID'];}

												/****************************************************/
												//filtros
												if(isset($idSistema) && $idSistema!=''){                $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
												if(isset($idEstado) && $idEstado!=''){                  $SIS_data .= ",'".$idEstado."'";          }else{$SIS_data .= ",''";}
												if(isset($Post_Nombre) && $Post_Nombre!=''){            $SIS_data .= ",'".$Post_Nombre."'";       }else{$SIS_data .= ",''";}
												if(isset($Post_Ape_Pat) && $Post_Ape_Pat!=''){          $SIS_data .= ",'".$Post_Ape_Pat."'";      }else{$SIS_data .= ",''";}
												if(isset($Post_Ape_Mat) && $Post_Ape_Mat!=''){          $SIS_data .= ",'".$Post_Ape_Mat."'";      }else{$SIS_data .= ",''";}
												if(isset($Post_Rut) && $Post_Rut!=''){                  $SIS_data .= ",'".$Post_Rut."'";          }else{$SIS_data .= ",''";}
												if(isset($ID_Sexo) && $ID_Sexo!=''){                    $SIS_data .= ",'".$ID_Sexo."'";           }else{$SIS_data .= ",''";}
												if(isset($Post_Fono1) && $Post_Fono1!=''){              $SIS_data .= ",'".$Post_Fono1."'";        }else{$SIS_data .= ",''";}
												if(isset($Post_Fono2) && $Post_Fono2!=''){              $SIS_data .= ",'".$Post_Fono2."'";        }else{$SIS_data .= ",''";}
												if(isset($ID_Ciudad) && $ID_Ciudad!=''){                $SIS_data .= ",'".$ID_Ciudad."'";         }else{$SIS_data .= ",''";}
												if(isset($ID_Comuna) && $ID_Comuna!=''){                $SIS_data .= ",'".$ID_Comuna."'";         }else{$SIS_data .= ",''";}
												if(isset($Post_Direccion) && $Post_Direccion!=''){      $SIS_data .= ",'".$Post_Direccion."'";    }else{$SIS_data .= ",''";}
												if(isset($idEstadoContrato) && $idEstadoContrato!=''){  $SIS_data .= ",'".$idEstadoContrato."'";  }else{$SIS_data .= ",''";}
												if(isset($Post_Email) && $Post_Email!=''){              $SIS_data .= ",'".$Post_Email."'";        }else{$SIS_data .= ",''";}

												// inserto los datos de registro en la db
												$SIS_columns = 'idSistema,idEstado,Nombre,ApellidoPat, ApellidoMat,Rut,idSexo,Fono1,Fono2,idCiudad,idComuna,Direccion, idEstadoContrato,email';
												$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'postulantes_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

												//Si ejecuto correctamente la consulta
												if($ultimo_id!=0){
													/****************************************************/
													//Verifico la existencia de un email y si se desea enviar correos
													if(isset($Post_Email)&&$Post_Email!=''&&isset($idOpciones)&&$idOpciones==1){

														//variables
														$login_logo  = DB_SITE_MAIN.'/img/login_logo.png';
														$Link        = DB_SITE_MAIN;
														$Nombre      = '';
														if(isset($Post_Nombre) && $Post_Nombre!=''){    $Nombre .= $Post_Nombre;}
														if(isset($Post_Ape_Pat) && $Post_Ape_Pat!=''){  $Nombre .= " ".$Post_Ape_Pat;}
														if(isset($Post_Ape_Mat) && $Post_Ape_Mat!=''){  $Nombre .= " ".$Post_Ape_Mat;}

														//envio de correo
														try {

															//se consulta el correo
															$rowusr = db_select_data (false, 'Nombre,email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

															//Se crea el cuerpo
															$BodyMail  = '<div style="background-color: #D9D9D9; padding: 10px;">';
															$BodyMail .= '<img src="'.$login_logo.'" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
															$BodyMail .= '<h3 style="text-align: center;font-size: 30px;">';
															$BodyMail .= '¡Hola <strong>'.$Nombre.'</strong>!<br/>';
															$BodyMail .= 'Bienvenido/a a <strong>'.$rowusr['Nombre'].'</strong>';
															$BodyMail .= '</h3>';
															$BodyMail .= '<p style="text-align: center;font-size: 20px;">';
															$BodyMail .= '';
															$BodyMail .= '</p>';
															$BodyMail .= '<a href="'.$Link.'" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Empezar &#8594;</strong></a>';
															$BodyMail .= '</div>';

															$rmail = tareas_envio_correo($rowusr['email_principal'], '1Tek',
																						 $Post_Email, $Nombre,
																						 '', '',
																						 'Registro de Usuario',
																						 $BodyMail,'',
																						 '',
																						 1,
																						 $rowusr['Gmail_Usuario'],
																						 $rowusr['Gmail_Password']);
															//se guarda el log
															log_response(1, $rmail, $Post_Email.' (Asunto:Registro de Usuario)');

														}catch (Exception $e) {
															php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'error de registro:'.$e->getMessage(), '' );
														}
													}
												}
											}
										}
									}
								}

								//redirijo
								header( 'Location: '.$location.'&created=true' );
								die;

							}

						} else {
							$error['FilePostulante']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{
					//se devuelve error
					$error['FilePostulante'] = 'error/No ha seleccionado un archivo';

				}

			}

		break;

/*******************************************************************************************************************/
	}

?>
