<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-080).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idEquipo']))        $idEquipo        = $_POST['idEquipo'];
	if (!empty($_POST['Nombre']))          $Nombre          = $_POST['Nombre'];
	if (!empty($_POST['Marca']))           $Marca           = $_POST['Marca'];
	if (!empty($_POST['Descripcion']))     $Descripcion     = $_POST['Descripcion'];
	if (!empty($_POST['Codigo']))          $Codigo          = $_POST['Codigo'];
	if (!empty($_POST['idProveedor']))     $idProveedor     = $_POST['idProveedor'];
	if (!empty($_POST['Direccion_img']))   $Direccion_img   = $_POST['Direccion_img'];
	if (!empty($_POST['FichaTecnica']))    $FichaTecnica    = $_POST['FichaTecnica'];
	if (!empty($_POST['HDS']))             $HDS             = $_POST['HDS'];
	if (!empty($_POST['idEstado']))        $idEstado        = $_POST['idEstado'];

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
			case 'idEquipo':        if(empty($idEquipo)){         $error['idEquipo']        = 'error/No ha ingresado el id';}break;
			case 'Nombre':          if(empty($Nombre)){           $error['Nombre']          = 'error/No ha ingresado el nombre del producto';}break;
			case 'Marca':           if(empty($Marca)){            $error['Marca']           = 'error/No ha ingresado la marca del producto';}break;
			case 'Descripcion':     if(empty($Descripcion)){      $error['Descripcion']     = 'error/No ha ingresado una Descripcion';}break;
			case 'Codigo':          if(empty($Codigo)){           $error['Codigo']          = 'error/No ha ingresado un Codigo';}break;
			case 'idProveedor':     if(empty($idProveedor)){      $error['idProveedor']     = 'error/No ha seleccionado un proveedor';}break;
			case 'Direccion_img':   if(empty($Direccion_img)){    $error['Direccion_img']   = 'error/No ha adjuntado una imagen';}break;
			case 'FichaTecnica':    if(empty($FichaTecnica)){     $error['FichaTecnica']    = 'error/No ha adjuntado una ficha tecnica';}break;
			case 'HDS':             if(empty($HDS)){              $error['HDS']             = 'error/No ha adjuntado un archivo de seguridad';}break;
			case 'idEstado':        if(empty($idEstado)){         $error['idEstado']        = 'error/No ha ingresado el estado del producto';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){            $Nombre      = EstandarizarInput($Nombre);}
	if(isset($Marca) && $Marca!=''){              $Marca       = EstandarizarInput($Marca);}
	if(isset($Descripcion) && $Descripcion!=''){  $Descripcion = EstandarizarInput($Descripcion);}
	if(isset($Codigo) && $Codigo!=''){            $Codigo      = EstandarizarInput($Codigo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){            $error['Nombre']      = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Marca)&&contar_palabras_censuradas($Marca)!=0){              $error['Marca']       = 'error/Edita la Marca, contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){  $error['Descripcion'] = 'error/Edita la Descripcion, contiene palabras no permitidas';}
	if(isset($Codigo)&&contar_palabras_censuradas($Codigo)!=0){            $error['Codigo']      = 'error/Edita Codigo, contiene palabras no permitidas';}

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
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'equipos_arriendo_listado', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){                   $SIS_data  = "'".$Nombre."'";           }else{$SIS_data  = "''";}
				if(isset($Marca) && $Marca!=''){                     $SIS_data .= ",'".$Marca."'";           }else{$SIS_data .= ",''";}
				if(isset($Descripcion) && $Descripcion!=''){         $SIS_data .= ",'".$Descripcion."'";     }else{$SIS_data .= ",''";}
				if(isset($Codigo) && $Codigo!=''){                   $SIS_data .= ",'".$Codigo."'";          }else{$SIS_data .= ",''";}
				if(isset($idProveedor) && $idProveedor!=''){         $SIS_data .= ",'".$idProveedor."'";     }else{$SIS_data .= ",''";}
				if(isset($Direccion_img) && $Direccion_img!=''){     $SIS_data .= ",'".$Direccion_img."'";   }else{$SIS_data .= ",''";}
				if(isset($FichaTecnica) && $FichaTecnica!=''){       $SIS_data .= ",'".$FichaTecnica."'";    }else{$SIS_data .= ",''";}
				if(isset($HDS) && $HDS!=''){                         $SIS_data .= ",'".$HDS."'";             }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){               $SIS_data .= ",'".$idEstado."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,Marca,Descripcion,Codigo, idProveedor,Direccion_img,FichaTecnica,HDS, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'equipos_arriendo_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idEquipo)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'equipos_arriendo_listado', '', "Nombre='".$Nombre."' AND idEquipo!='".$idEquipo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idEquipo='".$idEquipo."'";
				if(isset($Nombre) && $Nombre!=''){                   $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Marca) && $Marca!=''){                     $SIS_data .= ",Marca='".$Marca."'";}
				if(isset($Descripcion) && $Descripcion!=''){         $SIS_data .= ",Descripcion='".$Descripcion."'";}
				if(isset($Codigo) && $Codigo!=''){                   $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($idProveedor) && $idProveedor!=''){         $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Direccion_img) && $Direccion_img!=''){     $SIS_data .= ",Direccion_img='".$Direccion_img."'";}
				if(isset($FichaTecnica) && $FichaTecnica!=''){       $SIS_data .= ",FichaTecnica='".$FichaTecnica."'";}
				if(isset($HDS) && $HDS!=''){                         $SIS_data .= ",HDS='".$HDS."'";}
				if(isset($idEstado) && $idEstado!=''){               $SIS_data .= ",idEstado='".$idEstado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$idEquipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'submit_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["Direccion_img"]["error"] > 0){
				$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'equ_arriendo_img_'.$idEquipo.'_';

				if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						//$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
						//Muevo el archivo
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

							//Filtro para idSistema
							$SIS_data = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$idEquipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								//redirijo
								header( 'Location: '.$location.'&img_id='.$idEquipo );
								die;

							}

						} else {
							$error['Direccion_img']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Direccion_img']       = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
					}
				} else {
					$error['Direccion_img']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'submit_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["FichaTecnica"]["error"] > 0){
				$error['FichaTecnica'] = 'error/'.uploadPHPError($_FILES["FichaTecnica"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/pdf", "application/octet-stream", "application/x-real", "application/vnd.adobe.xfdf", "application/vnd.fdf", "binary/octet-stream");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'equ_arriendo_file_'.$idEquipo.'_';

				if (in_array($_FILES['FichaTecnica']['type'], $permitidos) && $_FILES['FichaTecnica']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['FichaTecnica']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["FichaTecnica"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "FichaTecnica='".$sufijo.$_FILES['FichaTecnica']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$idEquipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['FichaTecnica']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['FichaTecnica']       = 'error/El archivo '.$_FILES['FichaTecnica']['name'].' ya existe';
					}
				} else {
					$error['FichaTecnica']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'submit_hds':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["HDS"]["error"] > 0){
				$error['HDS'] = 'error/'.uploadPHPError($_FILES["HDS"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/pdf", "application/octet-stream", "application/x-real", "application/vnd.adobe.xfdf", "application/vnd.fdf", "binary/octet-stream");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'equ_arriendo_hds_'.$idEquipo.'_';

				if (in_array($_FILES['HDS']['type'], $permitidos) && $_FILES['HDS']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['HDS']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["HDS"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "HDS='".$sufijo.$_FILES['HDS']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$idEquipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['HDS']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['HDS']       = 'error/El archivo '.$_FILES['HDS']['name'].' ya existe';
					}
				} else {
					$error['HDS']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre de la imagen
			$rowData = db_select_data (false, 'Direccion_img', 'equipos_arriendo_listado', '', 'idEquipo = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				header( 'Location: '.$location.'&id='.$_GET['del_img'] );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'FichaTecnica', 'equipos_arriendo_listado', '', 'idEquipo = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "FichaTecnica=''";
			$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
					try {
						if(!is_writable('upload/'.$rowData['FichaTecnica'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['FichaTecnica']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id='.$_GET['del_file'] );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_hds':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'HDS', 'equipos_arriendo_listado', '', 'idEquipo = "'.$_GET['del_hds'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "HDS=''";
			$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$_GET['del_hds'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
					try {
						if(!is_writable('upload/'.$rowData['HDS'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['HDS']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id='.$_GET['del_hds'] );
				die;

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
				$rowData = db_select_data (false, 'Direccion_img, FichaTecnica, HDS', 'equipos_arriendo_listado', '', 'idEquipo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'equipos_arriendo_listado', 'idEquipo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Se elimina la imagen
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
					//Se elimina el archivo adjunto
					if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
						try {
							if(!is_writable('upload/'.$rowData['FichaTecnica'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['FichaTecnica']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//Se elimina el archivo adjunto
					if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
						try {
							if(!is_writable('upload/'.$rowData['HDS'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['HDS']);
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
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idEquipo  = $_GET['id'];
			$idEstado  = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'equipos_arriendo_listado', 'idEquipo = "'.$idEquipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
