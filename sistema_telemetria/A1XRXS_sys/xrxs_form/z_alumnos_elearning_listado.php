<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-219).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idElearning']))     $idElearning      = $_POST['idElearning'];
	if (!empty($_POST['idSistema']))       $idSistema        = $_POST['idSistema'];
	if (!empty($_POST['Nombre']))          $Nombre           = $_POST['Nombre'];
	if (!empty($_POST['Resumen']))         $Resumen          = $_POST['Resumen'];
	if (!empty($_POST['Unidades']))        $Unidades         = $_POST['Unidades'];
	if (!empty($_POST['Imagen']))          $Imagen           = $_POST['Imagen'];
	if (!empty($_POST['LastUpdate']))      $LastUpdate       = $_POST['LastUpdate'];
	if (!empty($_POST['Objetivos']))       $Objetivos        = $_POST['Objetivos'];
	if (!empty($_POST['Requisitos']))      $Requisitos       = $_POST['Requisitos'];
	if (!empty($_POST['Descripcion']))     $Descripcion      = $_POST['Descripcion'];
	if (!empty($_POST['idEstado']))        $idEstado         = $_POST['idEstado'];

	if (!empty($_POST['idUnidad']))        $idUnidad         = $_POST['idUnidad'];
	if (!empty($_POST['N_Unidad']))        $N_Unidad         = $_POST['N_Unidad'];
	if (!empty($_POST['Duracion']))        $Duracion         = $_POST['Duracion'];

	if (!empty($_POST['idContenido']))     $idContenido      = $_POST['idContenido'];
	if (!empty($_POST['Contenido']))       $Contenido        = $_POST['Contenido'];

	if (!empty($_POST['idCuestionario']))  $idCuestionario   = $_POST['idCuestionario'];
	if (!empty($_POST['idQuiz']))          $idQuiz           = $_POST['idQuiz'];

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
			case 'idElearning':    if(empty($idElearning)){     $error['idElearning']      = 'error/No ha ingresado el id';}break;
			case 'idSistema':      if(empty($idSistema)){       $error['idSistema']        = 'error/No ha seleccionado el sistema';}break;
			case 'Nombre':         if(empty($Nombre)){          $error['Nombre']           = 'error/No ha ingresado el nombre';}break;
			case 'Resumen':        if(empty($Resumen)){         $error['Resumen']          = 'error/No ha ingresado el resumen';}break;
			case 'Unidades':       if(empty($Unidades)){        $error['Unidades']         = 'error/No ha ingresado la unidad';}break;
			case 'Imagen':         if(empty($Imagen)){          $error['Imagen']           = 'error/No ha ingresado la imagen';}break;
			case 'LastUpdate':     if(empty($LastUpdate)){      $error['LastUpdate']       = 'error/No ha ingresado la ultima actualizacion';}break;
			case 'Objetivos':      if(empty($Objetivos)){       $error['Objetivos']        = 'error/No ha ingresado el objetivo';}break;
			case 'Requisitos':     if(empty($Requisitos)){      $error['Requisitos']       = 'error/No ha ingresado los requisitos';}break;
			case 'Descripcion':    if(empty($Descripcion)){     $error['Descripcion']      = 'error/No ha ingresado la descipcion';}break;
			case 'idEstado':       if(empty($idEstado)){        $error['idEstado']         = 'error/No ha seleccionado el estado';}break;

			case 'idUnidad':       if(empty($idUnidad)){        $error['idUnidad']         = 'error/No ha ingresado el id';}break;
			case 'N_Unidad':       if(empty($N_Unidad)){        $error['N_Unidad']         = 'error/No ha seleccionado el numero de unidad';}break;
			case 'Duracion':       if(empty($Duracion)){        $error['Duracion']         = 'error/No ha ingresado la fecha de inicio';}break;

			case 'idContenido':    if(empty($idContenido)){     $error['idContenido']      = 'error/No ha ingresado el id';}break;
			case 'Contenido':      if(empty($Contenido)){       $error['Contenido']        = 'error/No ha ingresado el contenido';}break;

			case 'idCuestionario': if(empty($idCuestionario)){  $error['idCuestionario']   = 'error/No ha seleccionado el Cuestionario';}break;
			case 'idQuiz':         if(empty($idQuiz)){          $error['idQuiz']           = 'error/No ha seleccionado el Quiz';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){           $Nombre      = EstandarizarInput($Nombre);}
	if(isset($Resumen) && $Resumen!=''){         $Resumen     = EstandarizarInput($Resumen);}
	if(isset($Unidades) && $Unidades!=''){       $Unidades    = EstandarizarInput($Unidades);}
	if(isset($Objetivos) && $Objetivos!=''){     $Objetivos   = EstandarizarInput($Objetivos);}
	if(isset($Requisitos) && $Requisitos!=''){   $Requisitos  = EstandarizarInput($Requisitos);}
	if(isset($Descripcion) && $Descripcion!=''){ $Descripcion = EstandarizarInput($Descripcion);}
	if(isset($Duracion) && $Duracion!=''){       $Duracion    = EstandarizarInput($Duracion);}
	if(isset($Contenido) && $Contenido!=''){     $Contenido   = EstandarizarInput($Contenido);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){            $error['Nombre']      = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Resumen)&&contar_palabras_censuradas($Resumen)!=0){          $error['Resumen']     = 'error/Edita Resumen, contiene palabras no permitidas';}
	if(isset($Unidades)&&contar_palabras_censuradas($Unidades)!=0){        $error['Unidades']    = 'error/Edita Unidades, contiene palabras no permitidas';}
	if(isset($Objetivos)&&contar_palabras_censuradas($Objetivos)!=0){      $error['Objetivos']   = 'error/Edita Objetivos, contiene palabras no permitidas';}
	if(isset($Requisitos)&&contar_palabras_censuradas($Requisitos)!=0){    $error['Requisitos']  = 'error/Edita Requisitos, contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){  $error['Descripcion'] = 'error/Edita Descripcion, contiene palabras no permitidas';}
	if(isset($Duracion)&&contar_palabras_censuradas($Duracion)!=0){        $error['Duracion']    = 'error/Edita Duracion, contiene palabras no permitidas';}
	if(isset($Contenido)&&contar_palabras_censuradas($Contenido)!=0){      $error['Contenido']   = 'error/Edita Contenido, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert_curso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_elearning_listado', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){  $SIS_data  = "'".$idSistema."'";    }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){        $SIS_data .= ",'".$Nombre."'";      }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){    $SIS_data .= ",'".$idEstado."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Nombre,idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_elearning_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					//Creo cada unidad dependiente dentro del elearning
					for ($i = 1; $i <= $Unidades; $i++) {

						//Se crean las variables a guardar
						$SIS_data  = "'".$ultimo_id."'";
						$SIS_data .= ",'".$i."'";
						$SIS_data .= ",''";

						// inserto los datos de registro en la db
						$SIS_columns = 'idElearning, N_Unidad, Nombre';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_elearning_listado_unidades', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					//redirijo
					header( 'Location: '.$location.'&created=true&id_curso='.$ultimo_id );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_curso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idElearning)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_elearning_listado', '', "Nombre='".$Nombre."' AND idElearning!='".$idElearning."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//variables
				$LastUpdate = fecha_actual();

				//Filtros
				$SIS_data = "idElearning='".$idElearning."'";
				if(isset($idSistema) && $idSistema!=''){     $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Nombre) && $Nombre!=''){           $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Resumen) && $Resumen!=''){         $SIS_data .= ",Resumen='".$Resumen."'";}
				if(isset($Imagen) && $Imagen!=''){           $SIS_data .= ",Imagen='".$Imagen."'";}
				if(isset($LastUpdate) && $LastUpdate!=''){   $SIS_data .= ",LastUpdate='".$LastUpdate."'";}
				if(isset($Objetivos) && $Objetivos!=''){     $SIS_data .= ",Objetivos='".$Objetivos."'";}
				if(isset($Requisitos) && $Requisitos!=''){   $SIS_data .= ",Requisitos='".$Requisitos."'";}
				if(isset($Descripcion) && $Descripcion!=''){ $SIS_data .= ",Descripcion='".$Descripcion."'";}
				if(isset($idEstado) && $idEstado!=''){       $SIS_data .= ",idEstado='".$idEstado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'alumnos_elearning_listado', 'idElearning = "'.$idElearning.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					header( 'Location: '.$location.'&edited=true&id_curso='.$idElearning );
					die;

				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_curso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_curso']) OR !validaEntero($_GET['del_curso']))&&$_GET['del_curso']!=''){
				$indice = simpleDecode($_GET['del_curso'], fecha_actual());
			}else{
				$indice = $_GET['del_curso'];
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
				// Se obtiene el listado de archivos relacionados
				$arrContenidos = array();
				$arrContenidos = db_select_array (false, 'File', 'alumnos_elearning_listado_unidades_documentacion', '',  'idElearning ='.$indice, '', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado_1 = db_delete_data (false, 'alumnos_elearning_listado', 'idElearning = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'alumnos_elearning_listado_unidades', 'idElearning = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'alumnos_elearning_listado_unidades_contenido', 'idElearning = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_4 = db_delete_data (false, 'alumnos_elearning_listado_unidades_documentacion', 'idElearning = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_5 = db_delete_data (false, 'alumnos_elearning_listado_unidades_cuestionarios', 'idCuestionario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true OR $resultado_5==true){

					//se elimina el archivo
					foreach ($arrContenidos as $cont) {
						if(isset($cont['File'])&&$cont['File']!=''){
							try {
								if(!is_writable('upload/'.$cont['File'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$cont['File']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}
					}

					//redirijo
					header( 'Location: '.$location.'&deleted=true&id_curso='.$_GET['id_curso'] );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}



		break;
/*******************************************************************************************************************/
		case 'insert_unidad':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($N_Unidad)&&isset($idElearning)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_elearning_listado_unidades', '', "N_Unidad='".$N_Unidad."' AND idElearning='".$idElearning."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La unidad ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idElearning) && $idElearning!=''){   $SIS_data  = "'".$idElearning."'";   }else{$SIS_data  = "''";}
				if(isset($N_Unidad) && $N_Unidad!=''){         $SIS_data .= ",'".$N_Unidad."'";     }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){             $SIS_data .= ",'".$Nombre."'";       }else{$SIS_data .= ",''";}
				if(isset($Duracion) && $Duracion!=''){         $SIS_data .= ",'".$Duracion."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idElearning, N_Unidad, Nombre,Duracion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_elearning_listado_unidades', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true&id_curso='.$idElearning );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'update_unidad':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($N_Unidad)&&isset($idElearning)&&isset($idUnidad)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_elearning_listado_unidades', '', "N_Unidad='".$N_Unidad."' AND idElearning='".$idElearning."' AND idUnidad!='".$idUnidad."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La unidad ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Filtros
				$SIS_data = "idUnidad='".$idUnidad."'";
				if(isset($idElearning) && $idElearning!=''){ $SIS_data .= ",idElearning='".$idElearning."'";}
				if(isset($N_Unidad) && $N_Unidad!=''){       $SIS_data .= ",N_Unidad='".$N_Unidad."'";}
				if(isset($Nombre) && $Nombre!=''){           $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Duracion) && $Duracion!=''){       $SIS_data .= ",Duracion='".$Duracion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'alumnos_elearning_listado_unidades', 'idUnidad = "'.$idUnidad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					header( 'Location: '.$location.'&edited=true&id_curso='.$idElearning );
					die;

				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_unidad':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_Unidad']) OR !validaEntero($_GET['del_Unidad']))&&$_GET['del_Unidad']!=''){
				$indice = simpleDecode($_GET['del_Unidad'], fecha_actual());
			}else{
				$indice = $_GET['del_Unidad'];
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
				// Se obtiene el listado de archivos relacionados
				$arrContenidos = array();
				$arrContenidos = db_select_array (false, 'File', 'alumnos_elearning_listado_unidades_documentacion', '',  'idUnidad ='.$indice, '', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado_1 = db_delete_data (false, 'alumnos_elearning_listado_unidades', 'idUnidad = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'alumnos_elearning_listado_unidades_contenido', 'idUnidad = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'alumnos_elearning_listado_unidades_documentacion', 'idUnidad = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_4 = db_delete_data (false, 'alumnos_elearning_listado_unidades_cuestionarios', 'idCuestionario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true){

					//se elimina el archivo
					foreach ($arrContenidos as $cont) {
						if(isset($cont['File'])&&$cont['File']!=''){
							try {
								if(!is_writable('upload/'.$cont['File'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$cont['File']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}
					}

					//redirijo
					header( 'Location: '.$location.'&deleted=true&id_curso='.$_GET['id_curso'] );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'insert_contenido':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idUnidad)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_elearning_listado_unidades_contenido', '', "Nombre='".$Nombre."' AND idUnidad='".$idUnidad."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Contenido ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idUnidad) && $idUnidad!=''){        $SIS_data  = "'".$idUnidad."'";      }else{$SIS_data  = "''";}
				if(isset($idElearning) && $idElearning!=''){  $SIS_data .= ",'".$idElearning."'";  }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",'".$Nombre."'";       }else{$SIS_data .= ",''";}
				if(isset($Contenido) && $Contenido!=''){      $SIS_data .= ",'".$Contenido."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idUnidad, idElearning, Nombre,Contenido';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_elearning_listado_unidades_contenido', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true&id_curso='.$idElearning );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_contenido':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idUnidad)&&isset($idContenido)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_elearning_listado_unidades_contenido', '', "Nombre='".$Nombre."' AND idUnidad='".$idUnidad."' AND idContenido!='".$idContenido."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Contenido ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Filtros
				$SIS_data = "idContenido='".$idContenido."'";
				if(isset($idUnidad) && $idUnidad!=''){        $SIS_data .= ",idUnidad='".$idUnidad."'";}
				if(isset($idElearning) && $idElearning!=''){  $SIS_data .= ",idElearning='".$idElearning."'";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Contenido) && $Contenido!=''){      $SIS_data .= ",Contenido='".$Contenido."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'alumnos_elearning_listado_unidades_contenido', 'idContenido = "'.$idContenido.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idUnidad='".$idUnidad."'";
				$resultado = db_update_data (false, $SIS_data, 'alumnos_elearning_listado_unidades_documentacion', 'idContenido = "'.$idContenido.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					header( 'Location: '.$location.'&edited=true&id_curso='.$idElearning );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_contenido':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_Contenido']) OR !validaEntero($_GET['del_Contenido']))&&$_GET['del_Contenido']!=''){
				$indice = simpleDecode($_GET['del_Contenido'], fecha_actual());
			}else{
				$indice = $_GET['del_Contenido'];
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
				// Se obtiene el listado de archivos relacionados
				$arrContenidos = array();
				$arrContenidos = db_select_array (false, 'File', 'alumnos_elearning_listado_unidades_documentacion', '',  'idContenido ='.$indice, '', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado_1 = db_delete_data (false, 'alumnos_elearning_listado_unidades_contenido', 'idContenido = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'alumnos_elearning_listado_unidades_documentacion', 'idContenido = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'alumnos_elearning_listado_unidades_cuestionarios', 'idContenido = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

					//se elimina el archivo
					foreach ($arrContenidos as $cont) {
						if(isset($cont['File'])&&$cont['File']!=''){
							try {
								if(!is_writable('upload/'.$cont['File'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$cont['File']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}
					}

					//redirijo
					header( 'Location: '.$location.'&deleted=true&id_curso='.$_GET['id_curso'] );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}


		break;
/*******************************************************************************************************************/
		case 'new_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//Se verifica
				if(isset($_FILES["exFile"])){
					if ($_FILES["exFile"]["error"] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"]);
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
						$sufijo = 'elearning_files_'.$idContenido.'_';

						if (in_array($_FILES['exFile']['type'], $permitidos) && $_FILES['exFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['exFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"], $ruta);
								if ($move_result){

									//filtros
									if(isset($idUnidad) && $idUnidad!=''){        $SIS_data  = "'".$idUnidad."'";      }else{$SIS_data  = "''";}
									if(isset($idElearning) && $idElearning!=''){  $SIS_data .= ",'".$idElearning."'";  }else{$SIS_data .= ",''";}
									if(isset($idContenido) && $idContenido!=''){  $SIS_data .= ",'".$idContenido."'";  }else{$SIS_data .= ",''";}
									$SIS_data .= ",'".$sufijo.$_FILES['exFile']['name']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idUnidad, idElearning, idContenido, File';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_elearning_listado_unidades_documentacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($ultimo_id!=0){
										//redirijo
										header( 'Location: '.$location.'&edited=true&id_curso='.$idElearning );
										die;
									}

								}else {
									$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'].' ya existe';
							}
						} else {
							$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
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
				// Se obtiene el listado de archivos relacionados
				$arrContenidos = array();
				$arrContenidos = db_select_array (false, 'File', 'alumnos_elearning_listado_unidades_documentacion', '',  'idDocumentacion ='.$indice, '', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'alumnos_elearning_listado_unidades_documentacion', 'idDocumentacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					foreach ($arrContenidos as $cont) {
						if(isset($cont['File'])&&$cont['File']!=''){
							try {
								if(!is_writable('upload/'.$cont['File'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$cont['File']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}
					}

					//redirijo
					header( 'Location: '.$location.'&deleted=true&id_curso='.$_GET['id_curso'] );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}


		break;
/*******************************************************************************************************************/
		case 'insert_quiz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idUnidad)&&isset($idElearning)&&isset($idContenido)&&isset($idQuiz)){
				$ndata_1 = db_select_nrows (false, 'idCuestionario', 'alumnos_elearning_listado_unidades_cuestionarios', '', "idUnidad='".$idUnidad."' AND idElearning='".$idElearning."' AND idContenido='".$idContenido."' AND idQuiz='".$idQuiz."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Cuestionario ya existe dentro de la unidad';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idUnidad) && $idUnidad!=''){        $SIS_data  = "'".$idUnidad."'";      }else{$SIS_data  = "''";}
				if(isset($idElearning) && $idElearning!=''){  $SIS_data .= ",'".$idElearning."'";  }else{$SIS_data .= ",''";}
				if(isset($idContenido) && $idContenido!=''){  $SIS_data .= ",'".$idContenido."'";  }else{$SIS_data .= ",''";}
				if(isset($idQuiz) && $idQuiz!=''){            $SIS_data .= ",'".$idQuiz."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idUnidad, idElearning, idContenido, idQuiz';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_elearning_listado_unidades_cuestionarios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&edited=true&id_curso='.$idElearning );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_quiz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idUnidad)&&isset($idElearning)&&isset($idContenido)&&isset($idQuiz)&&isset($idCuestionario)){
				$ndata_1 = db_select_nrows (false, 'idCuestionario', 'alumnos_elearning_listado_unidades_cuestionarios', '', "idUnidad='".$idUnidad."' AND idElearning='".$idElearning."' AND idContenido='".$idContenido."' AND idQuiz='".$idQuiz."' AND idCuestionario!='".$idCuestionario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Cuestionario ya existe dentro de la unidad';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Filtros
				$SIS_data = "idCuestionario='".$idCuestionario."'";
				if(isset($idUnidad) && $idUnidad!=''){        $SIS_data .= ",idUnidad='".$idUnidad."'";}
				if(isset($idElearning) && $idElearning!=''){  $SIS_data .= ",idElearning='".$idElearning."'";}
				if(isset($idContenido) && $idContenido!=''){  $SIS_data .= ",idContenido='".$idContenido."'";}
				if(isset($idQuiz) && $idQuiz!=''){            $SIS_data .= ",idQuiz='".$idQuiz."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'alumnos_elearning_listado_unidades_cuestionarios', 'idCuestionario = "'.$idCuestionario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					header( 'Location: '.$location.'&edited=true&id_curso='.$idElearning );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_quiz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_quiz']) OR !validaEntero($_GET['del_quiz']))&&$_GET['del_quiz']!=''){
				$indice = simpleDecode($_GET['del_quiz'], fecha_actual());
			}else{
				$indice = $_GET['del_quiz'];
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
				//se borran los datos
				$resultado = db_delete_data (false, 'alumnos_elearning_listado_unidades_cuestionarios', 'idCuestionario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true&id_curso='.$_GET['id_curso'] );
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
