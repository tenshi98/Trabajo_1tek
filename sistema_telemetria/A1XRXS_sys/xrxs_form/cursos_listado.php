<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-077).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCurso']))       $idCurso        = $_POST['idCurso'];
	if (!empty($_POST['idSistema']))     $idSistema      = $_POST['idSistema'];
	if (!empty($_POST['Nombre']))        $Nombre         = $_POST['Nombre'];
	if (!empty($_POST['Semanas']))       $Semanas        = $_POST['Semanas'];
	if (!empty($_POST['F_inicio']))      $F_inicio       = $_POST['F_inicio'];
	if (!empty($_POST['F_termino']))     $F_termino      = $_POST['F_termino'];
	if (!empty($_POST['idEstado']))      $idEstado       = $_POST['idEstado'];
	if (!empty($_POST['idAsignatura']))  $idAsignatura   = $_POST['idAsignatura'];

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
			case 'idCurso':       if(empty($idCurso)){       $error['idCurso']      = 'error/No ha ingresado el id';}break;
			case 'idSistema':     if(empty($idSistema)){     $error['idSistema']    = 'error/No ha seleccionado el sistema';}break;
			case 'Nombre':        if(empty($Nombre)){        $error['Nombre']       = 'error/No ha ingresado el nombre';}break;
			case 'Semanas':       if(empty($Semanas)){       $error['Semanas']      = 'error/No ha ingresado la semana';}break;
			case 'F_inicio':      if(empty($F_inicio)){      $error['F_inicio']     = 'error/No ha ingresado la fecha de inicio';}break;
			case 'F_termino':     if(empty($F_termino)){     $error['F_termino']    = 'error/No ha ingresado la fecha de termino';}break;
			case 'idEstado':      if(empty($idEstado)){      $error['idEstado']     = 'error/No ha seleccionado el estado';}break;
			case 'idAsignatura':  if(empty($idAsignatura)){  $error['idAsignatura'] = 'error/No ha seleccionado la Asignatura';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){$Nombre = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}

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
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cursos_listado', '', 'Nombre="'.$Nombre.'" AND idSistema="'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){  $SIS_data  = "'".$idSistema."'";   }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){        $SIS_data .= ",'".$Nombre."'";     }else{$SIS_data .= ",''";}
				if(isset($Semanas) && $Semanas!=''){      $SIS_data .= ",'".$Semanas."'";    }else{$SIS_data .= ",''";}
				if(isset($F_inicio) && $F_inicio!=''){    $SIS_data .= ",'".$F_inicio."'";   }else{$SIS_data .= ",''";}
				if(isset($F_termino) && $F_termino!=''){  $SIS_data .= ",'".$F_termino."'";  }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){    $SIS_data .= ",'".$idEstado."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Nombre,Semanas, F_inicio, F_termino, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cursos_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($idSistema)&&isset($idCurso)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cursos_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idCurso!='".$idCurso."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idCurso='".$idCurso."'";
				if(isset($idSistema) && $idSistema!=''){  $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Nombre) && $Nombre!=''){        $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Semanas) && $Semanas!=''){      $SIS_data .= ",Semanas='".$Semanas."'";}
				if(isset($F_inicio) && $F_inicio!=''){    $SIS_data .= ",F_inicio='".$F_inicio."'";}
				if(isset($F_termino) && $F_termino!=''){  $SIS_data .= ",F_termino='".$F_termino."'";}
				if(isset($idEstado) && $idEstado!=''){    $SIS_data .= ",idEstado='".$idEstado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cursos_listado', 'idCurso = "'.$idCurso.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					header( 'Location: '.$location.'&id='.$idCurso.'&edited=true' );
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
				/*************************************************************/
				// Se trae un listado con todos los archivos
				$SIS_query = 'File';
				$SIS_join  = '';
				$SIS_where = 'idCurso = '.$indice;
				$SIS_order = 0;
				$arrArchivos = array();
				$arrArchivos = db_select_array (false, $SIS_query, 'cursos_listado_documentacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************/
				//se borran los datos
				$resultado_1 = db_delete_data (false, 'cursos_listado', 'idCurso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'cursos_listado_asignaturas', 'idCurso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'cursos_listado_documentacion', 'idCurso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

					//se eliminan los archivos
					foreach ($arrArchivos as $arch) {
						//se elimina el archivo
						if(isset($arch['File'])&&$arch['File']!=''){
							try {
								if(!is_writable('upload/'.$arch['File'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$arch['File']);
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
		//Cambio el estado de activo a inactivo
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idCurso    = $_GET['id'];
			$idEstado   = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'cursos_listado', 'idCurso = "'.$idCurso.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'ele_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idAsignatura)&&isset($idCurso)){
				$ndata_1 = db_select_nrows (false, 'idAsignatura', 'cursos_listado_asignaturas', '', 'idAsignatura="'.$idAsignatura.'" AND idCurso="'.$idCurso.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La asignatura ya fue asignada a este curso';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idCurso) && $idCurso!=''){            $SIS_data  = "'".$idCurso."'";        }else{$SIS_data  = "''";}
				if(isset($idAsignatura) && $idAsignatura!=''){  $SIS_data .= ",'".$idAsignatura."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCurso,idAsignatura';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cursos_listado_asignaturas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}
 

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'ele_del':

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
				//se borran los datos
				$resultado = db_delete_data (false, 'cursos_listado_asignaturas', 'idRelacionados = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
