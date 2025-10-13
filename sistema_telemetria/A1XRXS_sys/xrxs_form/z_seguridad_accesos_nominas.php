<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-270).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idAcceso']))               $idAcceso                = $_POST['idAcceso'];
	if (!empty($_POST['idSistema']))              $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))              $idUsuario               = $_POST['idUsuario'];
	if (!empty($_POST['FechaProgramada']))        $FechaProgramada         = $_POST['FechaProgramada'];
	if (!empty($_POST['HoraInicioProgramada']))   $HoraInicioProgramada    = $_POST['HoraInicioProgramada'];
	if (!empty($_POST['HoraTerminoProgramada']))  $HoraTerminoProgramada   = $_POST['HoraTerminoProgramada'];
	if (!empty($_POST['idUbicacion']))            $idUbicacion             = $_POST['idUbicacion'];
	if (!empty($_POST['idUbicacion_lvl_1']))      $idUbicacion_lvl_1       = $_POST['idUbicacion_lvl_1'];
	if (!empty($_POST['idUbicacion_lvl_2']))      $idUbicacion_lvl_2       = $_POST['idUbicacion_lvl_2'];
	if (!empty($_POST['idUbicacion_lvl_3']))      $idUbicacion_lvl_3       = $_POST['idUbicacion_lvl_3'];
	if (!empty($_POST['idUbicacion_lvl_4']))      $idUbicacion_lvl_4       = $_POST['idUbicacion_lvl_4'];
	if (!empty($_POST['idUbicacion_lvl_5']))      $idUbicacion_lvl_5       = $_POST['idUbicacion_lvl_5'];
	if (!empty($_POST['PersonaReunion']))         $PersonaReunion          = $_POST['PersonaReunion'];

	if (!empty($_POST['idNomina']))       $idNomina        = $_POST['idNomina'];
	if (!empty($_POST['Fecha']))          $Fecha           = $_POST['Fecha'];
	if (!empty($_POST['HoraEntrada']))    $HoraEntrada     = $_POST['HoraEntrada'];
	if (!empty($_POST['HoraSalida']))     $HoraSalida      = $_POST['HoraSalida'];
	if (!empty($_POST['Nombre']))         $Nombre          = $_POST['Nombre'];
	if (!empty($_POST['Rut']))            $Rut             = $_POST['Rut'];
	if (!empty($_POST['NDocCedula']))     $NDocCedula      = $_POST['NDocCedula'];
	if (!empty($_POST['idEstado']))       $idEstado        = $_POST['idEstado'];

	if (!empty($_POST['old_idPersona']))       $old_idPersona        = $_POST['old_idPersona'];

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
			case 'idAcceso':                if(empty($idAcceso)){                 $error['idAcceso']                 = 'error/No ha ingresado el id';}break;
			case 'idSistema':               if(empty($idSistema)){                $error['idSistema']                = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':               if(empty($idUsuario)){                $error['idUsuario']                = 'error/No ha seleccionado el usuario';}break;
			case 'FechaProgramada':         if(empty($FechaProgramada)){          $error['FechaProgramada']          = 'error/No ha ingresado la fecha programada';}break;
			case 'HoraInicioProgramada':    if(empty($HoraInicioProgramada)){     $error['HoraInicioProgramada']     = 'error/No ha ingresado la hora de inicio programada';}break;
			case 'HoraTerminoProgramada':   if(empty($HoraTerminoProgramada)){    $error['HoraTerminoProgramada']    = 'error/No ha ingresado la hora de termino programada';}break;
			case 'idUbicacion':             if(empty($idUbicacion)){              $error['idUbicacion']              = 'error/No ha seleccionado la ubicacion';}break;
			case 'idUbicacion_lvl_1':       if(empty($idUbicacion_lvl_1)){        $error['idUbicacion_lvl_1']        = 'error/No ha seleccionado el nivel 1';}break;
			case 'idUbicacion_lvl_2':       if(empty($idUbicacion_lvl_2)){        $error['idUbicacion_lvl_2']        = 'error/No ha seleccionado el nivel 2';}break;
			case 'idUbicacion_lvl_3':       if(empty($idUbicacion_lvl_3)){        $error['idUbicacion_lvl_3']        = 'error/No ha seleccionado el nivel 3';}break;
			case 'idUbicacion_lvl_4':       if(empty($idUbicacion_lvl_4)){        $error['idUbicacion_lvl_4']        = 'error/No ha seleccionado el nivel 4';}break;
			case 'idUbicacion_lvl_5':       if(empty($idUbicacion_lvl_5)){        $error['idUbicacion_lvl_5']        = 'error/No ha seleccionado el nivel 5';}break;
			case 'PersonaReunion':          if(empty($PersonaReunion)){           $error['PersonaReunion']           = 'error/No ha ingresado la persona de reunion';}break;

			case 'idNomina':                if(empty($idNomina)){                 $error['idNomina']                 = 'error/No ha seleccionado el id';}break;
			case 'Fecha':                   if(empty($Fecha)){                    $error['Fecha']                    = 'error/No ha ingresado la fecha';}break;
			case 'HoraEntrada':             if(empty($HoraEntrada)){              $error['HoraEntrada']              = 'error/No ha ingresado la hora de entrada';}break;
			case 'HoraSalida':              if(empty($HoraSalida)){               $error['HoraSalida']               = 'error/No ha ingresado la hora de salida';}break;
			case 'Nombre':                  if(empty($Nombre)){                   $error['Nombre']                   = 'error/No ha ingresado el nombre';}break;
			case 'Rut':                     if(empty($Rut)){                      $error['Rut']                      = 'error/No ha ingresado el rut';}break;
			case 'NDocCedula':              if(empty($NDocCedula)){               $error['NDocCedula']               = 'error/No ha ingresado el numero de documento';}break;
			case 'idEstado':                if(empty($idEstado)){                 $error['idEstado']                 = 'error/No ha seleccionado el estado';}break;

			case 'old_idPersona':           if(empty($old_idPersona)){            $error['old_idPersona']            = 'error/No ha seleccionado el id';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($PersonaReunion) && $PersonaReunion!=''){ $PersonaReunion = EstandarizarInput($PersonaReunion);}
	if(isset($Nombre) && $Nombre!=''){                 $Nombre         = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($PersonaReunion)&&contar_palabras_censuradas($PersonaReunion)!=0){  $error['PersonaReunion'] = 'error/Edita Persona Reunion, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                  $error['Nombre']         = 'error/Edita Nombre,contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                        INGRESOS                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['nomina_basicos']);
				unset($_SESSION['nomina_personas']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['nomina_archivos'])){
					foreach ($_SESSION['nomina_archivos'] as $key => $producto){
						try {
							if(!is_writable('upload/'.$producto['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$producto['Nombre']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
				}
				unset($_SESSION['nomina_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				$_SESSION['nomina_basicos']['idSistema']               = $idSistema;
				$_SESSION['nomina_basicos']['idUsuario']               = $idUsuario;
				$_SESSION['nomina_basicos']['FechaProgramada']         = $FechaProgramada;
				$_SESSION['nomina_basicos']['HoraInicioProgramada']    = $HoraInicioProgramada;
				$_SESSION['nomina_basicos']['HoraTerminoProgramada']   = $HoraTerminoProgramada;
				$_SESSION['nomina_basicos']['idUbicacion']             = $idUbicacion;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_1']       = $idUbicacion_lvl_1;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_2']       = $idUbicacion_lvl_2;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_3']       = $idUbicacion_lvl_3;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_4']       = $idUbicacion_lvl_4;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_5']       = $idUbicacion_lvl_5;
				$_SESSION['nomina_basicos']['PersonaReunion']          = $PersonaReunion;
				$_SESSION['nomina_basicos']['idEstado']                = $idEstado;

				//variable vacia
				$_SESSION['nomina_basicos']['Ubicacion'] = '';

				/********************************************************************************/
				if(isset($idUbicacion) && $idUbicacion!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado', '', 'idUbicacion = '.$idUbicacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= $rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_1', '', 'idLevel_1 = '.$idUbicacion_lvl_1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_2', '', 'idLevel_2 = '.$idUbicacion_lvl_2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_3', '', 'idLevel_3 = '.$idUbicacion_lvl_3, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_4', '', 'idLevel_4 = '.$idUbicacion_lvl_4, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_5', '', 'idLevel_5 = '.$idUbicacion_lvl_5, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['nomina_basicos']);
			unset($_SESSION['nomina_personas']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['nomina_archivos'])){
				foreach ($_SESSION['nomina_archivos'] as $key => $producto){
					try {
						if(!is_writable('upload/'.$producto['Nombre'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$producto['Nombre']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}
			}
			unset($_SESSION['nomina_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['nomina_basicos']);
				unset($_SESSION['nomina_personas']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['nomina_archivos'])){
					foreach ($_SESSION['nomina_archivos'] as $key => $producto){
						try {
							if(!is_writable('upload/'.$producto['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$producto['Nombre']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
				}
				unset($_SESSION['nomina_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				$_SESSION['nomina_basicos']['idSistema']               = $idSistema;
				$_SESSION['nomina_basicos']['idUsuario']               = $idUsuario;
				$_SESSION['nomina_basicos']['FechaProgramada']         = $FechaProgramada;
				$_SESSION['nomina_basicos']['HoraInicioProgramada']    = $HoraInicioProgramada;
				$_SESSION['nomina_basicos']['HoraTerminoProgramada']   = $HoraTerminoProgramada;
				$_SESSION['nomina_basicos']['idUbicacion']             = $idUbicacion;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_1']       = $idUbicacion_lvl_1;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_2']       = $idUbicacion_lvl_2;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_3']       = $idUbicacion_lvl_3;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_4']       = $idUbicacion_lvl_4;
				$_SESSION['nomina_basicos']['idUbicacion_lvl_5']       = $idUbicacion_lvl_5;
				$_SESSION['nomina_basicos']['PersonaReunion']          = $PersonaReunion;
				$_SESSION['nomina_basicos']['idEstado']                = $idEstado;

				//variable vacia
				$_SESSION['nomina_basicos']['Ubicacion'] = '';

				/********************************************************************************/
				if(isset($idUbicacion) && $idUbicacion!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado', '', 'idUbicacion = '.$idUbicacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= $rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_1', '', 'idLevel_1 = '.$idUbicacion_lvl_1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_2', '', 'idLevel_2 = '.$idUbicacion_lvl_2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_3', '', 'idLevel_3 = '.$idUbicacion_lvl_3, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_4', '', 'idLevel_4 = '.$idUbicacion_lvl_4, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}
				/********************************************************************************/
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado_level_5', '', 'idLevel_5 = '.$idUbicacion_lvl_5, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['nomina_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['Nombre'];
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_persona_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['nomina_personas'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['nomina_personas'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['nomina_personas'][$idInterno]['idPersona']     = $idInterno;
				$_SESSION['nomina_personas'][$idInterno]['Nombre']        = $Nombre;
				$_SESSION['nomina_personas'][$idInterno]['Rut']           = $Rut;
				$_SESSION['nomina_personas'][$idInterno]['NDocCedula']    = $NDocCedula;
				$_SESSION['nomina_personas'][$idInterno]['idEstado']      = $idEstado;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_persona_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['nomina_personas'][$old_idPersona]['idPersona']     = $oldidProducto;
				$_SESSION['nomina_personas'][$old_idPersona]['Nombre']        = $Nombre;
				$_SESSION['nomina_personas'][$old_idPersona]['Rut']           = $Rut;
				$_SESSION['nomina_personas'][$old_idPersona]['NDocCedula']    = $NDocCedula;
				$_SESSION['nomina_personas'][$old_idPersona]['idEstado']      = $idEstado;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_persona_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['nomina_personas'][$_GET['del_persona']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['nomina_archivos'])){
				foreach ($_SESSION['nomina_archivos'] as $key => $trabajos){
					if($idInterno<$trabajos['idFile']){$idInterno = $trabajos['idFile'];}
				}
			}

			if(empty($error)){

				//Se verifica
				if(isset($_FILES["exFile"])){
					if ($_FILES["exFile"]["error"] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

											"application/mspowerpoint",
											"application/vnd.ms-powerpoint",
											"application/vnd.openxmlformats-officedocument.presentationml.presentation",

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
						$sufijo = 'seguridad_acceso_nomina_'.genera_password_unica().'_';

						if (in_array($_FILES['exFile']['type'], $permitidos) && $_FILES['exFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['exFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"], $ruta);
								if ($move_result){

									//se guarda en el indice siguiente
									$idInterno = $idInterno+1;
									//Se guarda el trabajo asignado
									$_SESSION['nomina_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['nomina_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

									header( 'Location: '.$location.'&view=true' );
									die;

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
		case 'del_file_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['nomina_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['nomina_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['nomina_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'crear_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['nomina_basicos'])){
				if(!isset($_SESSION['nomina_basicos']['idSistema']) OR $_SESSION['nomina_basicos']['idSistema']=='' ){                           $error['idSistema']              = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['nomina_basicos']['idUsuario']) OR $_SESSION['nomina_basicos']['idUsuario']=='' ){                           $error['idUsuario']              = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['nomina_basicos']['FechaProgramada']) OR $_SESSION['nomina_basicos']['FechaProgramada']=='' ){               $error['FechaProgramada']        = 'error/No ha ingresado la fecha programada';}
				if(!isset($_SESSION['nomina_basicos']['HoraInicioProgramada']) OR $_SESSION['nomina_basicos']['HoraInicioProgramada']=='' ){     $error['HoraInicioProgramada']   = 'error/No ha ingresado la hora de inicio';}
				if(!isset($_SESSION['nomina_basicos']['HoraTerminoProgramada']) OR $_SESSION['nomina_basicos']['HoraTerminoProgramada']=='' ){   $error['HoraTerminoProgramada']  = 'error/No ha ingresado la hora de termino';}
				if(!isset($_SESSION['nomina_basicos']['idUbicacion']) OR $_SESSION['nomina_basicos']['idUbicacion']=='' ){                       $error['idUbicacion']            = 'error/No ha seleccionado la ubicacion';}
				if(!isset($_SESSION['nomina_basicos']['PersonaReunion']) OR $_SESSION['nomina_basicos']['PersonaReunion']=='' ){                 $error['PersonaReunion']         = 'error/No ha ingresado la persona de reunion';}
				if(!isset($_SESSION['nomina_basicos']['idEstado']) OR $_SESSION['nomina_basicos']['idEstado']=='' ){                             $error['idEstado']               = 'error/No ha seleccionado el estado';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la Nomina';
			}
			//productos o guias
			if (!isset($_SESSION['nomina_personas'])){
				$error['idProducto']   = 'error/No se han asignado personas';
			}
			//Se verifican productos
			if (isset($_SESSION['nomina_personas'])){
				foreach ($_SESSION['nomina_personas'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado personas';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['nomina_basicos']['idSistema']) && $_SESSION['nomina_basicos']['idSistema']!=''){                            $SIS_data  = "'".$_SESSION['nomina_basicos']['idSistema']."'";               }else{$SIS_data  = "''";}
				if(isset($_SESSION['nomina_basicos']['idUsuario']) && $_SESSION['nomina_basicos']['idUsuario']!=''){                            $SIS_data .= ",'".$_SESSION['nomina_basicos']['idUsuario']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['FechaProgramada']) && $_SESSION['nomina_basicos']['FechaProgramada']!=''){                $SIS_data .= ",'".$_SESSION['nomina_basicos']['FechaProgramada']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['HoraInicioProgramada']) && $_SESSION['nomina_basicos']['HoraInicioProgramada']!=''){      $SIS_data .= ",'".$_SESSION['nomina_basicos']['HoraInicioProgramada']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['HoraTerminoProgramada']) && $_SESSION['nomina_basicos']['HoraTerminoProgramada']!=''){    $SIS_data .= ",'".$_SESSION['nomina_basicos']['HoraTerminoProgramada']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['idUbicacion']) && $_SESSION['nomina_basicos']['idUbicacion']!=''){                        $SIS_data .= ",'".$_SESSION['nomina_basicos']['idUbicacion']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['idUbicacion_lvl_1']) && $_SESSION['nomina_basicos']['idUbicacion_lvl_1']!=''){            $SIS_data .= ",'".$_SESSION['nomina_basicos']['idUbicacion_lvl_1']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['idUbicacion_lvl_2']) && $_SESSION['nomina_basicos']['idUbicacion_lvl_2']!=''){            $SIS_data .= ",'".$_SESSION['nomina_basicos']['idUbicacion_lvl_2']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['idUbicacion_lvl_3']) && $_SESSION['nomina_basicos']['idUbicacion_lvl_3']!=''){            $SIS_data .= ",'".$_SESSION['nomina_basicos']['idUbicacion_lvl_3']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['idUbicacion_lvl_4']) && $_SESSION['nomina_basicos']['idUbicacion_lvl_4']!=''){            $SIS_data .= ",'".$_SESSION['nomina_basicos']['idUbicacion_lvl_4']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['idUbicacion_lvl_5']) && $_SESSION['nomina_basicos']['idUbicacion_lvl_5']!=''){            $SIS_data .= ",'".$_SESSION['nomina_basicos']['idUbicacion_lvl_5']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['PersonaReunion']) && $_SESSION['nomina_basicos']['PersonaReunion']!=''){                  $SIS_data .= ",'".$_SESSION['nomina_basicos']['PersonaReunion']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['nomina_basicos']['idEstado']) && $_SESSION['nomina_basicos']['idEstado']!=''){                              $SIS_data .= ",'".$_SESSION['nomina_basicos']['idEstado']."'";               }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, FechaProgramada,
				HoraInicioProgramada, HoraTerminoProgramada, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
				idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, PersonaReunion, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_accesos_nominas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los servicios
					if(isset($_SESSION['nomina_personas'])){
						foreach ($_SESSION['nomina_personas'] as $key => $personas){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                            $SIS_data  = "'".$ultimo_id."'";                }else{$SIS_data  = "''";}
							if(isset($personas['Nombre']) && $personas['Nombre']!=''){          $SIS_data .= ",'".$personas['Nombre']."'";      }else{$SIS_data .= ",''";}
							if(isset($personas['Rut']) && $personas['Rut']!=''){                $SIS_data .= ",'".$personas['Rut']."'";         }else{$SIS_data .= ",''";}
							if(isset($personas['NDocCedula']) && $personas['NDocCedula']!=''){  $SIS_data .= ",'".$personas['NDocCedula']."'";  }else{$SIS_data .= ",''";}
							if(isset($personas['idEstado']) && $personas['idEstado']!=''){      $SIS_data .= ",'".$personas['idEstado']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAcceso, Nombre,Rut, NDocCedula, idEstado';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_accesos_nominas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['nomina_archivos'])){
						foreach ($_SESSION['nomina_archivos'] as $key => $archivo){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                    $SIS_data  = "'".$ultimo_id."'";              }else{$SIS_data  = "''";}
							if(isset($archivo['Nombre']) && $archivo['Nombre']!=''){    $SIS_data .= ",'".$archivo['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAcceso, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_accesos_nominas_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['nomina_basicos']);
					unset($_SESSION['nomina_personas']);
					unset($_SESSION['nomina_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_boleta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_nomina']) OR !validaEntero($_GET['del_nomina']))&&$_GET['del_nomina']!=''){
				$indice = simpleDecode($_GET['del_nomina'], fecha_actual());
			}else{
				$indice = $_GET['del_nomina'];
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
				/*******************************************************************/
				//variables
				$ndata_1 = 0;
				//Se verifica si el dato existe
				if(isset($indice)&&$indice!=''){
					$ndata_1 = db_select_nrows (false, 'idAcceso', 'seguridad_accesos_nominas', '', "WHERE idAcceso='".$indice."' AND idEstado=2", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}else{
					$error['del'] = 'error/No existe OC a eliminar';
				}
				//generacion de errores
				if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Nomina ya esta cerrada';}

				/*******************************************************************/

				//Si no hay errores ejecuto el codigo
				if(empty($error)){

					/********************************************************/
					// Se trae un listado con todos los archivos relacionados
					$arrArchivos = array();
					$arrArchivos = db_select_array (false, 'Nombre', 'seguridad_accesos_nominas_archivos', '', 'idAcceso = '.$indice, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/********************************************************/
					//se borran los datos
					$resultado_1 = db_delete_data (false, 'seguridad_accesos_nominas', 'idAcceso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_2 = db_delete_data (false, 'seguridad_accesos_nominas_listado', 'idAcceso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_3 = db_delete_data (false, 'seguridad_accesos_nominas_archivos', 'idAcceso = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

						//Se borran los archivos relacionados
						foreach ($arrArchivos as $archivo){
							try {
								if(!is_writable('upload/'.$archivo['Nombre'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivo['Nombre']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}

						//redirijo
						header( 'Location: '.$location.'&deleted=true' );
						die;

					}
				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'Edit_mod_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idAcceso='".$idAcceso."'";
				if(isset($idSistema) && $idSistema!=''){                           $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){                           $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($FechaProgramada) && $FechaProgramada!=''){               $SIS_data .= ",FechaProgramada='".$FechaProgramada."'";}
				if(isset($HoraInicioProgramada) && $HoraInicioProgramada!=''){     $SIS_data .= ",HoraInicioProgramada='".$HoraInicioProgramada."'";}
				if(isset($HoraTerminoProgramada) && $HoraTerminoProgramada!=''){   $SIS_data .= ",HoraTerminoProgramada='".$HoraTerminoProgramada."'";}
				if(isset($idUbicacion) && $idUbicacion!=''){                       $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){           $SIS_data .= ",idUbicacion_lvl_1='".$idUbicacion_lvl_1."'";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){           $SIS_data .= ",idUbicacion_lvl_2='".$idUbicacion_lvl_2."'";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){           $SIS_data .= ",idUbicacion_lvl_3='".$idUbicacion_lvl_3."'";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){           $SIS_data .= ",idUbicacion_lvl_4='".$idUbicacion_lvl_4."'";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){           $SIS_data .= ",idUbicacion_lvl_5='".$idUbicacion_lvl_5."'";}
				if(isset($PersonaReunion) && $PersonaReunion!=''){                 $SIS_data .= ",PersonaReunion='".$PersonaReunion."'";}
				if(isset($idEstado) && $idEstado!=''){                             $SIS_data .= ",idEstado='".$idEstado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seguridad_accesos_nominas', 'idAcceso = "'.$idAcceso.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'Edit_new_persona_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idAcceso) && $idAcceso!=''){        $SIS_data  = "'".$idAcceso."'";       }else{$SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){              $SIS_data .= ",'".$Fecha."'";         }else{$SIS_data .= ",''";}
				if(isset($HoraEntrada) && $HoraEntrada!=''){  $SIS_data .= ",'".$HoraEntrada."'";   }else{$SIS_data .= ",''";}
				if(isset($HoraSalida) && $HoraSalida!=''){    $SIS_data .= ",'".$HoraSalida."'";    }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                  $SIS_data .= ",'".$Rut."'";           }else{$SIS_data .= ",''";}
				if(isset($NDocCedula) && $NDocCedula!=''){    $SIS_data .= ",'".$NDocCedula."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){        $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idAcceso,Fecha,HoraEntrada, HoraSalida, Nombre,Rut, NDocCedula, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_accesos_nominas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'Edit_edit_persona_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idNomina='".$idNomina."'";
				if(isset($idAcceso) && $idAcceso!=''){       $SIS_data .= ",idAcceso='".$idAcceso."'";}
				if(isset($Fecha) && $Fecha!=''){             $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($HoraEntrada) && $HoraEntrada!=''){ $SIS_data .= ",HoraEntrada='".$HoraEntrada."'";}
				if(isset($HoraSalida) && $HoraSalida!=''){   $SIS_data .= ",HoraSalida='".$HoraSalida."'";}
				if(isset($Nombre) && $Nombre!=''){           $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Rut) && $Rut!=''){                 $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($NDocCedula) && $NDocCedula!=''){   $SIS_data .= ",NDocCedula='".$NDocCedula."'";}
				if(isset($idEstado) && $idEstado!=''){       $SIS_data .= ",idEstado='".$idEstado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seguridad_accesos_nominas_listado', 'idNomina = "'.$idNomina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'Edit_del_persona_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_persona']) OR !validaEntero($_GET['del_persona']))&&$_GET['del_persona']!=''){
				$indice = simpleDecode($_GET['del_persona'], fecha_actual());
			}else{
				$indice = $_GET['del_persona'];
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
				$resultado = db_delete_data (false, 'seguridad_accesos_nominas_listado', 'idNomina = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'Edit_new_file_nomina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//Se verifica
				if(isset($_FILES["exFile"])){
					if ($_FILES["exFile"]["error"] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

											"application/mspowerpoint",
											"application/vnd.ms-powerpoint",
											"application/vnd.openxmlformats-officedocument.presentationml.presentation",

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
						$sufijo = 'seguridad_acceso_nomina_'.genera_password_unica().'_';

						if (in_array($_FILES['exFile']['type'], $permitidos) && $_FILES['exFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['exFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"], $ruta);
								if ($move_result){

									if(isset($idAcceso) && $idAcceso!=''){   $SIS_data  = "'".$idAcceso."'";   }else{$SIS_data  ="''";}
									$SIS_data .= ",'".$sufijo.$_FILES['exFile']['name']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAcceso, Nombre';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'seguridad_accesos_nominas_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($ultimo_id!=0){
										//redirijo
										header( 'Location: '.$location );
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
		case 'Edit_del_file_nomina':

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
				$rowData = db_select_data (false, 'Nombre', 'seguridad_accesos_nominas_archivos', '', 'idFile = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'seguridad_accesos_nominas_archivos', 'idFile = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
