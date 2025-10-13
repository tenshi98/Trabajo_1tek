<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-278).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idMantencion']))      $idMantencion        = $_POST['idMantencion'];
	if (!empty($_POST['idSistema']))         $idSistema           = $_POST['idSistema'];
	if (!empty($_POST['idServicio']))        $idServicio          = $_POST['idServicio'];
	if (!empty($_POST['idOpciones_1']))      $idOpciones_1        = $_POST['idOpciones_1'];
	if (!empty($_POST['idOpciones_2']))      $idOpciones_2        = $_POST['idOpciones_2'];
	if (!empty($_POST['idOpciones_3']))      $idOpciones_3        = $_POST['idOpciones_3'];
	if (!empty($_POST['idUsuario']))         $idUsuario           = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))             $Fecha               = $_POST['Fecha'];
	if (!empty($_POST['Dia']))               $Dia                 = $_POST['Dia'];
	if (!empty($_POST['idMes']))             $idMes               = $_POST['idMes'];
	if (!empty($_POST['Semana']))            $Semana              = $_POST['Semana'];
	if (!empty($_POST['Ano']))               $Ano                 = $_POST['Ano'];
	if (!empty($_POST['h_Inicio']))          $h_Inicio            = $_POST['h_Inicio'];
	if (!empty($_POST['h_Termino']))         $h_Termino           = $_POST['h_Termino'];
	if (!empty($_POST['Duracion']))          $Duracion            = $_POST['Duracion'];
	if (!empty($_POST['Resumen']))           $Resumen             = $_POST['Resumen'];
	if (!empty($_POST['Resolucion']))        $Resolucion          = $_POST['Resolucion'];
	if (!empty($_POST['Recepcion_Nombre']))  $Recepcion_Nombre    = $_POST['Recepcion_Nombre'];
	if (!empty($_POST['Recepcion_Rut']))     $Recepcion_Rut       = $_POST['Recepcion_Rut'];
	if (!empty($_POST['Recepcion_Email']))   $Recepcion_Email     = $_POST['Recepcion_Email'];
	if (!empty($_POST['Path_Firma']))        $Path_Firma          = $_POST['Path_Firma'];

	if (!empty($_POST['idEquipo']))          $idEquipo            = $_POST['idEquipo'];
	if (!empty($_POST['idTelemetria']))      $idTelemetria        = $_POST['idTelemetria'];
	if (!empty($_POST['idArchivo']))         $idArchivo           = $_POST['idArchivo'];

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
			case 'idMantencion':        if(empty($idMantencion)){      $error['idMantencion']      = 'error/No ha ingresado el id';}break;
			case 'idSistema':           if(empty($idSistema)){         $error['idSistema']         = 'error/No ha seleccionado el sistema';}break;
			case 'idServicio':          if(empty($idServicio)){        $error['idServicio']        = 'error/No ha seleccionado el servicio';}break;
			case 'idOpciones_1':        if(empty($idOpciones_1)){      $error['idOpciones_1']      = 'error/No ha seleccionado la opción 1';}break;
			case 'idOpciones_2':        if(empty($idOpciones_2)){      $error['idOpciones_2']      = 'error/No ha seleccionado la opción 2';}break;
			case 'idOpciones_3':        if(empty($idOpciones_3)){      $error['idOpciones_3']      = 'error/No ha seleccionado la opción 3';}break;
			case 'idTelemetria':        if(empty($idTelemetria)){      $error['idTelemetria']      = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'idUsuario':           if(empty($idUsuario)){         $error['idUsuario']         = 'error/No ha seleccionado el usuario';}break;
			case 'Fecha':               if(empty($Fecha)){             $error['Fecha']             = 'error/No ha ingresado la fecha';}break;
			case 'Dia':                 if(empty($Dia)){               $error['Dia']               = 'error/No ha ingresado el dia';}break;
			case 'idMes':               if(empty($idMes)){             $error['idMes']             = 'error/No ha ingresado el mes';}break;
			case 'Semana':              if(empty($Semana)){            $error['Semana']            = 'error/No ha ingresado la semana';}break;
			case 'Ano':                 if(empty($Ano)){               $error['Ano']               = 'error/No ha ingresado el año';}break;
			case 'h_Inicio':            if(empty($h_Inicio)){          $error['h_Inicio']          = 'error/No ha ingresado la hora de inicio';}break;
			case 'h_Termino':           if(empty($h_Termino)){         $error['h_Termino']         = 'error/No ha ingresado la hora de termino';}break;
			case 'Duracion':            if(empty($Duracion)){          $error['Duracion']          = 'error/No ha ingresado la duracion';}break;
			case 'Resumen':             if(empty($Resumen)){           $error['Resumen']           = 'error/No ha ingresado el resumen';}break;
			case 'Resolucion':          if(empty($Resolucion)){        $error['Resolucion']        = 'error/No ha ingresado la resolucion';}break;
			case 'Recepcion_Nombre':    if(empty($Recepcion_Nombre)){  $error['Recepcion_Nombre']  = 'error/No ha ingresado el nombre de la persona de recepcion';}break;
			case 'Recepcion_Rut':       if(empty($Recepcion_Rut)){     $error['Recepcion_Rut']     = 'error/No ha ingresado el rut de la persona de recepcion';}break;
			case 'Recepcion_Email':     if(empty($Recepcion_Email)){   $error['Recepcion_Email']   = 'error/No ha ingresado el email de la persona de recepcion';}break;
			case 'Path_Firma':          if(empty($Path_Firma)){        $error['Path_Firma']        = 'error/No ha ingresado la firma';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Resumen) && $Resumen!=''){       $Resumen    = EstandarizarInput($Resumen);}
	if(isset($Resolucion) && $Resolucion!=''){ $Resolucion = EstandarizarInput($Resolucion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Resumen)&&contar_palabras_censuradas($Resumen)!=0){        $error['Resumen']    = 'error/Edita Resumen, contiene palabras no permitidas';}
	if(isset($Resolucion)&&contar_palabras_censuradas($Resolucion)!=0){  $error['Resolucion'] = 'error/Edita Resolucion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se verifican las horas para obtener la duracion
			if($h_Termino<$h_Inicio){
				$error['duracion'] = 'error/La hora de inicio es superior a la hora de termino';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se calcula la duracion
				$Duracion = restahoras($h_Inicio,$h_Termino);

				//filtros
				if(isset($idSistema) && $idSistema!=''){          $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
				if(isset($idServicio) && $idServicio!=''){        $SIS_data .= ",'".$idServicio."'";    }else{$SIS_data .= ",''";}
				if(isset($idOpciones_1) && $idOpciones_1!=''){    $SIS_data .= ",'".$idOpciones_1."'";  }else{$SIS_data .= ",''";}
				if(isset($idOpciones_2) && $idOpciones_2!=''){    $SIS_data .= ",'".$idOpciones_2."'";  }else{$SIS_data .= ",''";}
				if(isset($idOpciones_3) && $idOpciones_3!=''){    $SIS_data .= ",'".$idOpciones_3."'";  }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){          $SIS_data .= ",'".$idUsuario."'";     }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){
					$SIS_data .= ",'".$Fecha."'";
					$SIS_data .= ",'".fecha2NdiaMes($Fecha)."'";
					$SIS_data .= ",'".fecha2NMes($Fecha)."'";
					$SIS_data .= ",'".fecha2NSemana($Fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($h_Inicio) && $h_Inicio!=''){                  $SIS_data .= ",'".$h_Inicio."'";         }else{$SIS_data .= ",''";}
				if(isset($h_Termino) && $h_Termino!=''){                $SIS_data .= ",'".$h_Termino."'";        }else{$SIS_data .= ",''";}
				if(isset($Duracion) && $Duracion!=''){                  $SIS_data .= ",'".$Duracion."'";         }else{$SIS_data .= ",''";}
				if(isset($Resumen) && $Resumen!=''){                    $SIS_data .= ",'".$Resumen."'";          }else{$SIS_data .= ",''";}
				if(isset($Resolucion) && $Resolucion!=''){              $SIS_data .= ",'".$Resolucion."'";       }else{$SIS_data .= ",''";}
				if(isset($Recepcion_Nombre) && $Recepcion_Nombre!=''){  $SIS_data .= ",'".$Recepcion_Nombre."'"; }else{$SIS_data .= ",''";}
				if(isset($Recepcion_Rut) && $Recepcion_Rut!=''){        $SIS_data .= ",'".$Recepcion_Rut."'";    }else{$SIS_data .= ",''";}
				if(isset($Recepcion_Email) && $Recepcion_Email!=''){    $SIS_data .= ",'".$Recepcion_Email."'";  }else{$SIS_data .= ",''";}
				if(isset($Path_Firma) && $Path_Firma!=''){              $SIS_data .= ",'".$Path_Firma."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idServicio, idOpciones_1, idOpciones_2, idOpciones_3, idUsuario, Fecha, Dia, idMes, Semana, Ano, h_Inicio, h_Termino, 
				Duracion, Resumen, Resolucion, Recepcion_Nombre,Recepcion_Rut, Recepcion_Email, Path_Firma';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_historial_mantencion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			//se verifican las horas para obtener la duracion
			if($h_Termino<$h_Inicio){
				$error['duracion'] = 'error/La hora de inicio es superior a la hora de termino';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se calcula la duracion
				$Duracion = restahoras($h_Inicio,$h_Termino);

				//Filtros
				$SIS_data = "idMantencion='".$idMantencion."'";
				if(isset($idSistema) && $idSistema!=''){         $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idServicio) && $idServicio!=''){       $SIS_data .= ",idServicio='".$idServicio."'";}
				if(isset($idOpciones_1) && $idOpciones_1!=''){   $SIS_data .= ",idOpciones_1='".$idOpciones_1."'";}else{$SIS_data .= ",idOpciones_1='1'";}
				if(isset($idOpciones_2) && $idOpciones_2!=''){   $SIS_data .= ",idOpciones_2='".$idOpciones_2."'";}else{$SIS_data .= ",idOpciones_2='1'";}
				if(isset($idOpciones_3) && $idOpciones_3!=''){   $SIS_data .= ",idOpciones_3='".$idOpciones_3."'";}else{$SIS_data .= ",idOpciones_3='1'";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Fecha) && $Fecha!=''){
					$SIS_data .= ",Fecha='".$Fecha."'";
					$SIS_data .= ",Dia='".fecha2NdiaMes($Fecha)."'";
					$SIS_data .= ",idMes='".fecha2NMes($Fecha)."'";
					$SIS_data .= ",Semana='".fecha2NSemana($Fecha)."'";
					$SIS_data .= ",Ano='".fecha2Ano($Fecha)."'";
				}
				if(isset($h_Inicio) && $h_Inicio!=''){                  $SIS_data .= ",h_Inicio='".$h_Inicio."'";}
				if(isset($h_Termino) && $h_Termino!=''){                $SIS_data .= ",h_Termino='".$h_Termino."'";}
				if(isset($Duracion) && $Duracion!=''){                  $SIS_data .= ",Duracion='".$Duracion."'";}
				if(isset($Resumen) && $Resumen!=''){                    $SIS_data .= ",Resumen='".$Resumen."'";}
				if(isset($Resolucion) && $Resolucion!=''){              $SIS_data .= ",Resolucion='".$Resolucion."'";}
				if(isset($Recepcion_Nombre) && $Recepcion_Nombre!=''){  $SIS_data .= ",Recepcion_Nombre='".$Recepcion_Nombre."'";}
				if(isset($Recepcion_Rut) && $Recepcion_Rut!=''){        $SIS_data .= ",Recepcion_Rut='".$Recepcion_Rut."'";}
				if(isset($Recepcion_Email) && $Recepcion_Email!=''){    $SIS_data .= ",Recepcion_Email='".$Recepcion_Email."'";}
				if(isset($Path_Firma) && $Path_Firma!=''){              $SIS_data .= ",Path_Firma='".$Path_Firma."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_historial_mantencion', 'idMantencion = "'.$idMantencion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&id='.$idMantencion.'&edited=true' );
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
				//Se buscan todos los archivos relacionados
				$arrArchivos = array();
				$arrArchivos = db_select_array (false, 'Nombre', 'telemetria_historial_mantencion_archivos', '', 'idMantencion = '.$indice, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado_1 = db_delete_data (false, 'telemetria_historial_mantencion', 'idMantencion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'telemetria_historial_mantencion_archivos', 'idMantencion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'telemetria_historial_mantencion_equipos', 'idMantencion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

					//Se recorren los archivos
					foreach ($arrArchivos as $archivos) {
						//se elimina el archivo
						if(isset($archivos['Nombre'])&&$archivos['Nombre']!=''){
							try {
								if(!is_writable('upload/'.$archivos['Nombre'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivos['Nombre']);
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
		case 'insert_equipo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($idMantencion)&&isset($idTelemetria)){
				$ndata_1 = db_select_nrows (false, 'idMantencion', 'telemetria_historial_mantencion_equipos', '', "idMantencion='".$idMantencion."' AND idTelemetria='".$idTelemetria."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Equipo ingresado ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idMantencion) && $idMantencion!=''){  $SIS_data  = "'".$idMantencion."'";    }else{$SIS_data  = "''";}
				if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idMantencion, idTelemetria';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_historial_mantencion_equipos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.$idMantencion.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'del_equipo':

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
				$resultado_1 = db_delete_data (false, 'telemetria_historial_mantencion_equipos', 'idEquipo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true){

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
		case 'new_archivo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Verifico que los tipos de archivo correspondan y que tengan el peso necesario
			if($_FILES['files_adj']){
				$images = $_FILES['files_adj'];
				$filenames = $images['name'];
				if(count($filenames)>0){
					for($i=0; $i < count($filenames); $i++){
						if ($images['error'][$i] > 0){
							$error['files_adj'] = 'error/'.uploadPHPError($images['error'][$i]);
						} else {
							//Se verifican las extensiones de los archivos
							$permitidos = array("image/jpg",
												"image/jpeg",
												"image/gif",
												"image/png"
												);
							//Se verifica que el archivo subido no exceda los 100 kb
							$limite_kb = 10000;
							//Se verifica
							if (in_array($images['type'][$i], $permitidos) && $images['size'][$i] <= $limite_kb * 1024){
								//nada mas que validar
							}else{
								$error['files_adj']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
							}
						}
					}
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/************************************************************/
				//Guardo los archivos en el servidor
				if($_FILES['files_adj']){
					$images = $_FILES['files_adj'];
					$filenames = $images['name'];
					if(count($filenames)>0){
						//echo 'true';
						for($i=0; $i < count($filenames); $i++){
							if ($images['error'][$i] > 0){
								$error['files_adj'.$i] = 'error/'.uploadPHPError($images['error'][$i]);
							} else {
								//Se verifican las extensiones de los archivos
								$permitidos = array("image/jpg",
													"image/jpeg",
													"image/gif",
													"image/png"

													);
								//Se verifica que el archivo subido no exceda los 100 kb
								$limite_kb = 10000;
								//Sufijo
								$sufijo = 'tel_mnt_'.$idMantencion.'_';

								if (in_array($images['type'][$i], $permitidos) && $images['size'][$i] <= $limite_kb * 1024){
									//Se especifica carpeta de destino
									$ruta = "upload/".$sufijo.$images['name'][$i];
									//Se verifica que el archivo un archivo con el mismo nombre no existe
									if (!file_exists($ruta)){
										//Se mueve el archivo a la carpeta previamente configurada
										$move_result = @move_uploaded_file($images["tmp_name"][$i], $ruta);
										if ($move_result){

											//Filtro para nombre del archivo
											$nombre_arc = $sufijo.$images['name'][$i] ;

											//filtros
											if(isset($idMantencion) && $idMantencion!=''){    $SIS_data  = "'".$idMantencion."'";  }else{$SIS_data  = "''";}
											if(isset($nombre_arc) && $nombre_arc!=''){        $SIS_data .= ",'".$nombre_arc."'";   }else{$SIS_data .= ",''";}

											// inserto los datos de registro en la db
											$SIS_columns = 'idMantencion,Nombre';
											$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_historial_mantencion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

										}else {
											$error['files_adj'.$i]     = 'error/Ocurrio un error al mover el archivo';
										}
									}else {
										$error['files_adj'.$i]     = 'error/El archivo '.$images['name'][$i].' ya existe';
									}
								}else{
									$error['files_adj'.$i]     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
								}
							}
						}
					}
				}

				//Si no hay errores internos
				if(empty($error)){
					header( 'Location: '.$location.'&id='.$idMantencion.'&created=true' );
					die;
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
				// Se obtiene el nombre del archivo
				$rowData = db_select_data (false, 'Nombre', 'telemetria_historial_mantencion_archivos', '', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'telemetria_historial_mantencion_archivos', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
					header( 'Location: '.$location.'&deleted_img=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_firma':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["Path_Firma"]["error"] > 0){
				$error['Path_Firma'] = 'error/'.uploadPHPError($_FILES["Path_Firma"]["error"]);
			} else {
			  //Se verifican las extensiones de los archivos
			  $permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
			  //Se verifica que el archivo subido no exceda los 100 kb
			  $limite_kb = 10000;
			  //Sufijo
			  $sufijo = 'tel_mnt_firma_'.$idMantencion.'_';

			  if (in_array($_FILES['Path_Firma']['type'], $permitidos) && $_FILES['Path_Firma']['size'] <= $limite_kb * 1024){
				//Se especifica carpeta de destino
				$ruta = "upload/".$sufijo.$_FILES['Path_Firma']['name'];
				//Se verifica que el archivo un archivo con el mismo nombre no existe
				if (!file_exists($ruta)){
					//Se mueve el archivo a la carpeta previamente configurada
					//$move_result = @move_uploaded_file($_FILES["Path_Firma"]["tmp_name"], $ruta);
					//Muevo el archivo
					$move_result = @move_uploaded_file($_FILES["Path_Firma"]["tmp_name"], "upload/xxxsxx_".$_FILES['Path_Firma']['name']);
					if ($move_result){
						//se selecciona la imagen
						switch ($_FILES['Path_Firma']['type']) {
							case 'image/jpg':
								$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Path_Firma']['name']);
								break;
							case 'image/jpeg':
								$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Path_Firma']['name']);
								break;
							case 'image/gif':
								$imgBase = imagecreatefromgif('upload/xxxsxx_'.$_FILES['Path_Firma']['name']);
								break;
							case 'image/png':
								$imgBase = imagecreatefrompng('upload/xxxsxx_'.$_FILES['Path_Firma']['name']);
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
							if(!is_writable('upload/xxxsxx_'.$_FILES['Path_Firma']['name'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/xxxsxx_'.$_FILES['Path_Firma']['name']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
						//se eliminan las imagenes de la memoria
						imagedestroy($imgBase);

						//Filtro para idSistema
						if (!empty($_POST['idMantencion']))    $idMantencion       = $_POST['idMantencion'];

						$SIS_data = "Path_Firma='".$sufijo.$_FILES['Path_Firma']['name']."'";

						/*******************************************************/
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'telemetria_historial_mantencion', 'idMantencion = "'.$idMantencion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//Si ejecuto correctamente la consulta
						if($resultado==true){
							header( 'Location: '.$location.'&id='.$idMantencion );
							die;
						}

					} else {
					$error['Path_Firma']     = 'error/Ocurrio un error al mover el archivo';
				  }
				} else {
				  $error['Path_Firma']     = 'error/El archivo '.$_FILES['Path_Firma']['name'].' ya existe';
				}
			  } else {
				$error['Path_Firma']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
			  }
			}


		break;
/*******************************************************************************************************************/
		case 'del_firma':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'Path_Firma', 'telemetria_historial_mantencion', '', 'idMantencion = "'.$_GET['del_firma'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Path_Firma=''";
			$resultado = db_update_data (false, $SIS_data, 'telemetria_historial_mantencion', 'idMantencion = "'.$_GET['del_firma'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['Path_Firma'])&&$rowData['Path_Firma']!=''){
					try {
						if(!is_writable('upload/'.$rowData['Path_Firma'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['Path_Firma']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id='.$_GET['del_firma'] );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
