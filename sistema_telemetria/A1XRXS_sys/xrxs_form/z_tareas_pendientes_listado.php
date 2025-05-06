<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-277).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idTareas']))                 $idTareas                = $_POST['idTareas'];
	if (!empty($_POST['idSistema']))                $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))                $idUsuario               = $_POST['idUsuario'];
	if (!empty($_POST['idEstado']))                 $idEstado                = $_POST['idEstado'];
	if (!empty($_POST['idPrioridad']))              $idPrioridad             = $_POST['idPrioridad'];
	if (!empty($_POST['idTipo']))                   $idTipo                  = $_POST['idTipo'];
	if (!empty($_POST['f_creacion']))               $f_creacion 	         = $_POST['f_creacion'];
	if (!empty($_POST['Nombre']))                   $Nombre                  = $_POST['Nombre'];
	if (!empty($_POST['f_termino']))                $f_termino 	             = $_POST['f_termino'];
	if (!empty($_POST['Observaciones']))            $Observaciones           = $_POST['Observaciones'];
	if (!empty($_POST['idUsuarioCierre']))          $idUsuarioCierre         = $_POST['idUsuarioCierre'];
	if (!empty($_POST['f_cierre']))                 $f_cierre                = $_POST['f_cierre'];
	if (!empty($_POST['ObservacionesCierre']))      $ObservacionesCierre     = $_POST['ObservacionesCierre'];

	//Datos Responsables
	if (!empty($_POST['idResponsable']))      $idResponsable     = $_POST['idResponsable'];
	if (!empty($_POST['Observacion']))        $Observacion       = $_POST['Observacion'];
	if (!empty($_POST['idHistorial']))        $idHistorial       = $_POST['idHistorial'];
	if (!empty($_POST['Creacion_fecha']))     $Creacion_fecha    = $_POST['Creacion_fecha'];
	if (!empty($_POST['idTrabajoTareas']))    $idTrabajoTareas   = $_POST['idTrabajoTareas'];
	if (!empty($_POST['idEstadoTarea']))      $idEstadoTarea     = $_POST['idEstadoTarea'];
	if (!empty($_POST['idAdjunto']))          $idAdjunto         = $_POST['idAdjunto'];

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
			case 'idTareas':                  if(empty($idTareas)){               $error['idTareas']                = 'error/No ha ingresado el id';}break;
			case 'idSistema':                 if(empty($idSistema)){              $error['idSistema']               = 'error/No ha ingresado el idSistema del sistema';}break;
			case 'idUsuario':                 if(empty($idUsuario)){              $error['idUsuario']               = 'error/No ha ingresado el usuario';}break;
			case 'idEstado':                  if(empty($idEstado)){               $error['idEstado']                = 'error/No ha ingresado el estado';}break;
			case 'idPrioridad':               if(empty($idPrioridad)){            $error['idPrioridad']             = 'error/No ha ingresado la prioridad';}break;
			case 'idTipo':                    if(empty($idTipo)){                 $error['idTipo']                  = 'error/No ha ingresado el tipo';}break;
			case 'f_creacion':                if(empty($f_creacion)){             $error['f_creacion']              = 'error/No ha ingresado la fecha de creación';}break;
			case 'Nombre':                    if(empty($Nombre)){                 $error['Nombre']                  = 'error/No ha ingresado el nombre de la tarea';}break;
			case 'f_termino':                 if(empty($f_termino)){              $error['f_termino']               = 'error/No ha ingresado la fecha de termino';}break;
			case 'Observaciones':             if(empty($Observaciones)){          $error['Observaciones']           = 'error/No ha ingresado la observacion';}break;
			case 'idUsuarioCierre':           if(empty($idUsuarioCierre)){        $error['idUsuarioCierre']         = 'error/No ha ingresado el usuario que cancelo la tarea';}break;
			case 'f_cierre':                  if(empty($f_cierre)){               $error['f_cierre']                = 'error/No ha ingresado la fecha de cancelacion de la tarea';}break;
			case 'ObservacionesCierre':       if(empty($ObservacionesCierre)){    $error['ObservacionesCierre']     = 'error/No ha ingresado la observacion de cancelacion de la tarea';}break;

			case 'idResponsable':             if(empty($idResponsable)){          $error['idResponsable']           = 'error/No ha seleccionado un responsable';}break;
			case 'Observacion':               if(empty($Observacion)){            $error['Observacion']             = 'error/No ha ingresado la Observacion';}break;
			case 'idHistorial':               if(empty($idHistorial)){            $error['idHistorial']             = 'error/No ha seleccionado el historial';}break;
			case 'Creacion_fecha':            if(empty($Creacion_fecha)){         $error['Creacion_fecha']          = 'error/No ha ingresado la fecha de creación';}break;
			case 'idTrabajoTareas':           if(empty($idTrabajoTareas)){        $error['idTrabajoTareas']         = 'error/No ha seleccionado la tarea';}break;
			case 'idEstadoTarea':             if(empty($idEstadoTarea)){          $error['idEstadoTarea']           = 'error/No ha seleccionado el estado de la tarea';}break;
			case 'idAdjunto':                 if(empty($idAdjunto)){              $error['idAdjunto']               = 'error/No ha seleccionado el archivo adjunto';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){             $Observaciones       = EstandarizarInput($Observaciones);}
	if(isset($ObservacionesCierre) && $ObservacionesCierre!=''){ $ObservacionesCierre = EstandarizarInput($ObservacionesCierre);}
	if(isset($Observacion) && $Observacion!=''){                 $Observacion         = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){              $error['Observaciones']       = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($ObservacionesCierre)&&contar_palabras_censuradas($ObservacionesCierre)!=0){  $error['ObservacionesCierre'] = 'error/Edita ObservacionesCierre, contiene palabras no permitidas';}
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){                  $error['Observacion']         = 'error/Edita Observacion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'creacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones="Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['tareas_basicos']);
				unset($_SESSION['tareas_responsables']);
				unset($_SESSION['tareas_tareas']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['tareas_archivos'])){
					foreach ($_SESSION['tareas_archivos'] as $key => $archivo){
						if(isset($archivo['idFile'])&&$archivo['idFile']!=0){
							try {
								if(!is_writable('upload/'.$archivo['NombreArchivo'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivo['NombreArchivo']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}
					}
				}
				unset($_SESSION['tareas_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idSistema)&&$idSistema!=''){          $_SESSION['tareas_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['tareas_basicos']['idSistema']      = '';}
				if(isset($idUsuario)&&$idUsuario!=''){          $_SESSION['tareas_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['tareas_basicos']['idUsuario']      = '';}
				if(isset($idEstado)&&$idEstado!=''){            $_SESSION['tareas_basicos']['idEstado']          = $idEstado;          }else{$_SESSION['tareas_basicos']['idEstado']       = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){      $_SESSION['tareas_basicos']['idPrioridad']       = $idPrioridad;       }else{$_SESSION['tareas_basicos']['idPrioridad']    = '';}
				if(isset($idTipo)&&$idTipo!=''){                $_SESSION['tareas_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['tareas_basicos']['idTipo']         = '';}
				if(isset($f_creacion)&&$f_creacion!=''){        $_SESSION['tareas_basicos']['f_creacion']        = $f_creacion;        }else{$_SESSION['tareas_basicos']['f_creacion']     = '';}
				if(isset($Nombre)&&$Nombre!=''){                $_SESSION['tareas_basicos']['Nombre']            = $Nombre;            }else{$_SESSION['tareas_basicos']['Nombre']         = '';}
				if(isset($Observaciones)&&$Observaciones!=''){  $_SESSION['tareas_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['tareas_basicos']['Observaciones']  = '';}

				/****************************************************/
				if(isset($idEstado) && $idEstado!=''){
					// consulto los datos
					$rowEstado = db_select_data (false, 'Nombre', 'core_tareas_pendientes_estados', '', 'idEstado = '.$idEstado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['tareas_basicos']['Estado'] = $rowEstado['Nombre'];
				}else{
					$_SESSION['tareas_basicos']['Estado'] = '';
				}
				/****************************************************/
				if(isset($idPrioridad) && $idPrioridad!=''){
					// consulto los datos
					$rowPrioridad = db_select_data (false, 'Nombre', 'core_tareas_pendientes_prioridad', '', 'idPrioridad = '.$idPrioridad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['tareas_basicos']['Prioridad'] = $rowPrioridad['Nombre'];
				}else{
					$_SESSION['tareas_basicos']['Prioridad'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipo = db_select_data (false, 'Nombre', 'core_tareas_pendientes_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['tareas_basicos']['Tipo'] = $rowTipo['Nombre'];
				}else{
					$_SESSION['tareas_basicos']['Tipo'] = '';
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'clear_all':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['tareas_basicos']);
			unset($_SESSION['tareas_responsables']);
			unset($_SESSION['tareas_tareas']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['tareas_archivos'])){
				foreach ($_SESSION['tareas_archivos'] as $key => $archivo){
					if(isset($archivo['idFile'])&&$archivo['idFile']!=0){
						try {
							if(!is_writable('upload/'.$archivo['NombreArchivo'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$archivo['NombreArchivo']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
				}
			}
			unset($_SESSION['tareas_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'mod_base':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones="Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['tareas_basicos']);
				unset($_SESSION['tareas_responsables']);
				unset($_SESSION['tareas_tareas']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['tareas_archivos'])){
					foreach ($_SESSION['tareas_archivos'] as $key => $archivo){
						if(isset($archivo['idFile'])&&$archivo['idFile']!=0){
							try {
								if(!is_writable('upload/'.$archivo['NombreArchivo'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivo['NombreArchivo']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}
					}
				}
				unset($_SESSION['tareas_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idSistema)&&$idSistema!=''){          $_SESSION['tareas_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['tareas_basicos']['idSistema']      = '';}
				if(isset($idUsuario)&&$idUsuario!=''){          $_SESSION['tareas_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['tareas_basicos']['idUsuario']      = '';}
				if(isset($idEstado)&&$idEstado!=''){            $_SESSION['tareas_basicos']['idEstado']          = $idEstado;          }else{$_SESSION['tareas_basicos']['idEstado']       = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){      $_SESSION['tareas_basicos']['idPrioridad']       = $idPrioridad;       }else{$_SESSION['tareas_basicos']['idPrioridad']    = '';}
				if(isset($idTipo)&&$idTipo!=''){                $_SESSION['tareas_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['tareas_basicos']['idTipo']         = '';}
				if(isset($f_creacion)&&$f_creacion!=''){        $_SESSION['tareas_basicos']['f_creacion']        = $f_creacion;        }else{$_SESSION['tareas_basicos']['f_creacion']     = '';}
				if(isset($Nombre)&&$Nombre!=''){                $_SESSION['tareas_basicos']['Nombre']            = $Nombre;            }else{$_SESSION['tareas_basicos']['Nombre']         = '';}
				if(isset($Observaciones)&&$Observaciones!=''){  $_SESSION['tareas_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['tareas_basicos']['Observaciones']  = '';}

				/****************************************************/
				if(isset($idEstado) && $idEstado!=''){
					// consulto los datos
					$rowEstado = db_select_data (false, 'Nombre', 'core_tareas_pendientes_estados', '', 'idEstado = '.$idEstado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['tareas_basicos']['Estado'] = $rowEstado['Nombre'];
				}else{
					$_SESSION['tareas_basicos']['Estado'] = '';
				}
				/****************************************************/
				if(isset($idPrioridad) && $idPrioridad!=''){
					// consulto los datos
					$rowPrioridad = db_select_data (false, 'Nombre', 'core_tareas_pendientes_prioridad', '', 'idPrioridad = '.$idPrioridad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['tareas_basicos']['Prioridad'] = $rowPrioridad['Nombre'];
				}else{
					$_SESSION['tareas_basicos']['Prioridad'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipo = db_select_data (false, 'Nombre', 'core_tareas_pendientes_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['tareas_basicos']['Tipo'] = $rowTipo['Nombre'];
				}else{
					$_SESSION['tareas_basicos']['Tipo'] = '';
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'addResponsable':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idResponsable)){ $ndata_1 = count($idResponsable);          }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idResponsable))==0) {$error['ndata_1'] = 'error/No hay responsables agregados';}
			/*******************************************************************/
			//Consulto
			/**********************************************/
			//Se trae un listado con los usuarios
			if($ndata_1!=0) {
				$arrUsuarios = array();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$arrUsuarios = db_select_array (false, 'idUsuario, Nombre', 'usuarios_listado', '', 'usuarios_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}else{
					$arrUsuarios = db_select_array (false, 'usuarios_listado.idUsuario, usuarios_listado.Nombre', 'usuarios_listado', 'LEFT JOIN `usuarios_sistemas` ON usuarios_sistemas.idUsuario = usuarios_listado.idUsuario', 'usuarios_sistemas.idSistema = "'.$_SESSION['tareas_basicos']['idSistema'].'" AND usuarios_listado.idEstado=1 GROUP BY usuarios_listado.idUsuario', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**********************************************/
				//se listan los cuarteles
				$arrUsers = array();
				foreach ($arrUsuarios as $prod) {
					$arrUsers[$prod['idUsuario']]['Nombre'] = $prod['Nombre'];
				}

				/**********************************************/
				//se borran todos los cuarteles
				unset($_SESSION['tareas_responsables']);

				/**********************************************/
				//Recorro los cuarteles
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//valido existencia de datos
					if(isset($idResponsable[$j1])&&$idResponsable[$j1]!=''){
						//Para mostrar en la creación
						$_SESSION['tareas_responsables'][$idResponsable[$j1]]['idResponsable'] = $idResponsable[$j1];
						$_SESSION['tareas_responsables'][$idResponsable[$j1]]['Responsables']  = $arrUsers[$idResponsable[$j1]]['Nombre'];
					}
				}

				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_responsable':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro el responsable
			unset($_SESSION['tareas_responsables'][$_GET['del_responsable']]);

			//recorro las tareas
			if (isset($_SESSION['tareas_tareas'])){
				foreach ($_SESSION['tareas_tareas'] as $key => $tarea){
					//si el trabajo es del responsable
					if(isset($tarea['idResponsable'])&&$tarea['idResponsable']==$_GET['del_responsable']){
						//ubico el idInterno
						$idInterno = $tarea['idInterno'];
						//elimino las tareas relacionadas al responsable
						unset($_SESSION['tareas_tareas'][$idInterno]);
					}
				}
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'submit_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idResponsable)){ $ndata_1 = count($idResponsable);   }else{$ndata_1 = 0;}
			if(isset($Observacion)){   $ndata_2 = count($Observacion);     }else{$ndata_2 = 0;}
			//generacion de errores
			if(count(array_filter($idResponsable))==0) { $error['ndata_1'] = 'error/No hay responsables agregados';}
			if(count(array_filter($Observacion))==0) {   $error['ndata_2'] = 'error/No hay tareas asignadas';}
			/*******************************************************************/
			//Consulto
			/**********************************************/
			//Se trae un listado con los usuarios
			if(count(array_filter($idResponsable))!=0) {
				$arrUsuarios = array();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$arrUsuarios = db_select_array (false, 'idUsuario, Nombre', 'usuarios_listado', '', 'usuarios_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}else{
					$arrUsuarios = db_select_array (false, 'usuarios_listado.idUsuario, usuarios_listado.Nombre', 'usuarios_listado', 'LEFT JOIN `usuarios_sistemas` ON usuarios_sistemas.idUsuario = usuarios_listado.idUsuario', 'usuarios_sistemas.idSistema = "'.$_SESSION['tareas_basicos']['idSistema'].'" AND usuarios_listado.idEstado=1 GROUP BY usuarios_listado.idUsuario', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**********************************************/
				//se listan los cuarteles
				$arrUsers = array();
				foreach ($arrUsuarios as $prod) {
					$arrUsers[$prod['idUsuario']]['Nombre'] = $prod['Nombre'];
				}

				/**********************************************/
				//se borran todos los cuarteles
				//unset($_SESSION['tareas_tareas']);

				/**********************************************/
				//se establece variable inicial
				$idInterno = 0;

				//verificar si el subcomponente ya existe
				if (isset($_SESSION['tareas_tareas'])){
					foreach ($_SESSION['tareas_tareas'] as $key => $tarea){
						//se recorre mientras id interno aun existe y sea superior al contador
						if(isset($tarea['idInterno'])&&$tarea['idInterno']!=''&&$idInterno<$tarea['idInterno']){
							$idInterno = $tarea['idInterno'];
						}
					}
				}

				/**********************************************/
				//Recorro los cuarteles
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//valido existencia de datos
					if(isset($idResponsable[$j1])&&$idResponsable[$j1]!=''){
						//sumo 1
						$idInterno = $idInterno+1;
						//Para mostrar en la creación
						$_SESSION['tareas_tareas'][$idInterno]['idInterno']     = $idInterno;
						$_SESSION['tareas_tareas'][$idInterno]['idResponsable'] = $idResponsable[$j1];
						$_SESSION['tareas_tareas'][$idInterno]['Responsables']  = $arrUsers[$idResponsable[$j1]]['Nombre'];
						$_SESSION['tareas_tareas'][$idInterno]['Observacion']   = $Observacion[$j1];
					}
				}

				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['tareas_tareas'][$_GET['del_tarea']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['tareas_archivos'])){
				foreach ($_SESSION['tareas_archivos'] as $key => $trabajos){
					if(isset($trabajos['idFile'])&&$trabajos['idFile']!=''&&$idInterno<$trabajos['idFile']){
						$idInterno = $trabajos['idFile'];
					}
				}
			}

			//Se verifica que el archivo subido no exceda los 100 kb
			$limite_kb = 10000;
			//Sufijo
			$sufijo = 'tareas_'.genera_password_unica().'_';
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

			//Verifico errores en los archivos
			foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
				if ($_FILES["exFile"]["error"][$key] > 0){
					$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
				}
				if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (file_exists($ruta)){
						$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
					}
				} else {
					$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

			if(empty($error)){

				/***************************************************/
				//Verifico errores en los archivos
				foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
					if ($_FILES["exFile"]["error"][$key] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
					}
					if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"][$key], $ruta);
							if ($move_result){
								//se guarda en el indice siguiente
								$idInterno++;
								//Se guarda el trabajo asignado
								$_SESSION['tareas_archivos'][$idInterno]['idFile']         = $idInterno;
								$_SESSION['tareas_archivos'][$idInterno]['NombreArchivo']  = $sufijo.$_FILES['exFile']['name'][$key];

							} else {
								$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
							}
						}else{
							$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
						}
					} else {
						$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;

/*******************************************************************************************************************/
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['tareas_archivos'][$_GET['del_file']]['NombreArchivo'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['tareas_archivos'][$_GET['del_file']]['NombreArchivo']);
					unset($_SESSION['tareas_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'crear_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*********************************************************************/
			//variables
			$n_responsables = 0;
			$n_tareas       = 0;

			//Se verifican los datos basicos
			if (isset($_SESSION['tareas_basicos'])){
				if(!isset($_SESSION['tareas_basicos']['idSistema']) OR $_SESSION['tareas_basicos']['idSistema']=='' ){          $error['idSistema']      = 'error/No ha ingresado el sistema';}
				if(!isset($_SESSION['tareas_basicos']['idUsuario']) OR $_SESSION['tareas_basicos']['idUsuario']=='' ){          $error['idUsuario']      = 'error/No ha ingresado el usuario';}
				if(!isset($_SESSION['tareas_basicos']['idEstado']) OR $_SESSION['tareas_basicos']['idEstado']=='' ){            $error['idEstado']       = 'error/No ha ingresado el estado';}
				if(!isset($_SESSION['tareas_basicos']['idPrioridad']) OR $_SESSION['tareas_basicos']['idPrioridad']=='' ){      $error['idPrioridad']    = 'error/No ha ingresado la prioridad';}
				if(!isset($_SESSION['tareas_basicos']['idTipo']) OR $_SESSION['tareas_basicos']['idTipo']=='' ){                $error['idTipo']         = 'error/No ha ingresado el tipo';}
				if(!isset($_SESSION['tareas_basicos']['f_creacion']) OR $_SESSION['tareas_basicos']['f_creacion']=='' ){        $error['f_creacion']     = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['tareas_basicos']['Nombre']) OR $_SESSION['tareas_basicos']['Nombre']=='' ){                $error['Nombre']         = 'error/No ha ingresado el nombre';}
				if(!isset($_SESSION['tareas_basicos']['Observaciones']) OR $_SESSION['tareas_basicos']['Observaciones']=='' ){  $error['Observaciones']  = 'error/No ha ingresado la observacion';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos';
			}

			//Se verifica que tenga responsable asignados
			if (isset($_SESSION['tareas_responsables'])){
				foreach ($_SESSION['tareas_responsables'] as $key => $resp){
					if(!isset($resp['idResponsable']) OR $resp['idResponsable'] == ''){  $error['idResponsable']   = 'error/No ha ingresado un responsable';}
					$n_responsables++;
				}
			}else{
				$error['responsables'] = 'error/No tiene responsables asignados';
			}

			//Se verifica que tenga tareas asignadas
			if (isset($_SESSION['tareas_tareas'])){
				foreach ($_SESSION['tareas_tareas'] as $key => $tarea){
					$n_tareas++;
				}
			}else{
				$error['tareas'] = 'error/No tiene tareas asignadas';
			}

			//Se verifica el minimo de trabajadores
			if(isset($n_responsables)&&$n_responsables==0){
				$error['responsables'] = 'error/No tiene responsables asignados';
			}

			//Se verifica el minimo de trabajos
			if(isset($n_tareas)&&$n_tareas==0){
				$error['tareas'] = 'error/No tiene tareas asignadas';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['tareas_basicos']['idSistema']) && $_SESSION['tareas_basicos']['idSistema']!=''){         $SIS_data  = "'".$_SESSION['tareas_basicos']['idSistema']."'";         }else{$SIS_data  = "''";}
				if(isset($_SESSION['tareas_basicos']['idUsuario']) && $_SESSION['tareas_basicos']['idUsuario']!=''){         $SIS_data .= ",'".$_SESSION['tareas_basicos']['idUsuario']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['tareas_basicos']['idEstado']) && $_SESSION['tareas_basicos']['idEstado']!=''){           $SIS_data .= ",'".$_SESSION['tareas_basicos']['idEstado']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['tareas_basicos']['idPrioridad']) && $_SESSION['tareas_basicos']['idPrioridad']!=''){     $SIS_data .= ",'".$_SESSION['tareas_basicos']['idPrioridad']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['tareas_basicos']['idTipo']) && $_SESSION['tareas_basicos']['idTipo']!=''){               $SIS_data .= ",'".$_SESSION['tareas_basicos']['idTipo']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['tareas_basicos']['f_creacion']) && $_SESSION['tareas_basicos']['f_creacion']!=''){       $SIS_data .= ",'".$_SESSION['tareas_basicos']['f_creacion']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['tareas_basicos']['Nombre']) && $_SESSION['tareas_basicos']['Nombre']!=''){               $SIS_data .= ",'".$_SESSION['tareas_basicos']['Nombre']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['tareas_basicos']['Observaciones']) && $_SESSION['tareas_basicos']['Observaciones']!=''){ $SIS_data .= ",'".$_SESSION['tareas_basicos']['Observaciones']."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, idEstado, idPrioridad,
				idTipo, f_creacion, Nombre,Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*****************************************************/
					//Se guardan los datos de los responsables
					foreach ($_SESSION['tareas_responsables'] as $key => $resp){
						//filtros
						if(isset($ultimo_id) && $ultimo_id!=''){                          $SIS_data  = "'".$ultimo_id."'";                }else{$SIS_data  = "''";}
						if(isset($resp['idResponsable']) && $resp['idResponsable']!=''){  $SIS_data .= ",'".$resp['idResponsable']."'";   }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idTareas,idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					/*****************************************************/
					//Se guardan los datos de los insumos si es que existen
					if (isset($_SESSION['tareas_tareas'])){
						foreach ($_SESSION['tareas_tareas'] as $key => $tarea){
							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                            $SIS_data  = "'".$ultimo_id."'";                 }else{$SIS_data  = "''";}
							$SIS_data .= ",'1'"; //Estado ejecucion
							if(isset($tarea['idResponsable']) && $tarea['idResponsable']!=''){  $SIS_data .= ",'".$tarea['idResponsable']."'";   }else{$SIS_data .= ",''";}
							if(isset($tarea['Observacion']) && $tarea['Observacion']!=''){      $SIS_data .= ",'".$tarea['Observacion']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idTareas, idEstadoTarea, idUsuario, Observacion';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_tareas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*****************************************************/
					//Se guardan los datos de los insumos si es que existen
					if (isset($_SESSION['tareas_archivos'])){
						foreach ($_SESSION['tareas_archivos'] as $key => $archivo){
							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                $SIS_data  = "'".$ultimo_id."'";                   }else{$SIS_data  = "''";}
							if(isset($archivo['NombreArchivo']) && $archivo['NombreArchivo']!=''){  $SIS_data .= ",'".$archivo['NombreArchivo']."'";   }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idTareas, NombreArchivo';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_tareas_adjuntos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['tareas_basicos']['f_creacion']) && $_SESSION['tareas_basicos']['f_creacion']!=''){
						$SIS_data .= ",'".$_SESSION['tareas_basicos']['f_creacion']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                                //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*****************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['tareas_basicos']);
					unset($_SESSION['tareas_responsables']);
					unset($_SESSION['tareas_tareas']);
					unset($_SESSION['tareas_archivos']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'delete_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['delete_tarea']) OR !validaEntero($_GET['delete_tarea']))&&$_GET['delete_tarea']!=''){
				$indice = simpleDecode($_GET['delete_tarea'], fecha_actual());
			}else{
				$indice = $_GET['delete_tarea'];
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
				// Se obtiene el nombre de los archivos
				$arrArchivos = array();
				$arrArchivos = db_select_array (false, 'NombreArchivo', 'tareas_pendientes_listado_tareas_adjuntos', '', 'idTareas = '.$indice, 'NombreArchivo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'tareas_pendientes_listado', 'idTareas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'tareas_pendientes_listado_historial', 'idTareas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'tareas_pendientes_listado_responsable', 'idTareas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'tareas_pendientes_listado_tareas', 'idTareas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'tareas_pendientes_listado_tareas_adjuntos', 'idTareas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					foreach ($arrArchivos as $archivos) {
						if(isset($archivos['NombreArchivo'])&&$archivos['NombreArchivo']!=''){
							try {
								if(!is_writable('upload/'.$archivos['NombreArchivo'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivos['NombreArchivo']);
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
		case 'cancel_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se actualizala OT dependiendo del caso
			$SIS_data  = "idEstado='5'";//Cancelado
			$SIS_data .= ",idUsuarioCierre='".$idUsuarioCierre."'";
			$SIS_data .= ",f_cierre='".$f_cierre."'";
			$SIS_data .= ",ObservacionesCierre='".$ObservacionesCierre."'";

			//se actualizan los datos
			$resultado = db_update_data (false, $SIS_data, 'tareas_pendientes_listado', 'idTareas = "'.$idTareas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*********************************************************************/
			//Se guarda en historial la accion
			if(isset($idTareas) && $idTareas!=''){    $SIS_data  = "'".$idTareas."'";  }else{$SIS_data  = "''";}
			$SIS_data .= ",'".fecha_actual()."'";
			$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
			$SIS_data .= ",'La tarea fue cancelada'";                                //Observacion
			$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

			// inserto los datos de registro en la db
			$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//redirijo
				header( 'Location: '.$location.'&canceled=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'Edit_mod_base':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				//Se crea la observacion
				$SIS_query = 'idSistema, idUsuario, idEstado, idPrioridad, idTipo, f_creacion,
				Nombre,f_termino, Observaciones, idUsuarioCierre, f_cierre, ObservacionesCierre';
				$SIS_join  = '';
				$SIS_where = 'idTareas ='.$idTareas;
				$rowData = db_select_data (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				//Filtros
				$SIS_data = "idTareas='".$idTareas."'";
				if(isset($idSistema) && $idSistema!=''){                      $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){                      $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){                        $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idPrioridad) && $idPrioridad!=''){                  $SIS_data .= ",idPrioridad='".$idPrioridad."'";}
				if(isset($idTipo) && $idTipo!=''){                            $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($f_creacion) && $f_creacion!=''){                    $SIS_data .= ",f_creacion='".$f_creacion."'";}
				if(isset($Nombre) && $Nombre!=''){                            $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($f_termino) && $f_termino!=''){                      $SIS_data .= ",f_termino='".$f_termino."'";}
				if(isset($Observaciones) && $Observaciones!=''){              $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($idUsuarioCierre) && $idUsuarioCierre!=''){          $SIS_data .= ",idUsuarioCierre='".$idUsuarioCierre."'";}
				if(isset($f_cierre) && $f_cierre!=''){                        $SIS_data .= ",f_cierre='".$f_cierre."'";}
				if(isset($ObservacionesCierre) && $ObservacionesCierre!=''){  $SIS_data .= ",ObservacionesCierre='".$ObservacionesCierre."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'tareas_pendientes_listado', 'idTareas = "'.$idTareas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/*********************************************************************/
					//Se crea la observacion
					$Observacion = 'Se realizan los siguientes cambios en los datos basicos:';
					if(isset($idSistema) && $idSistema != '' && $idSistema != $rowData['idSistema']){                                          $Observacion .= '<br/> - Cambio del sistema';}
					if(isset($idUsuario) && $idUsuario != '' && $idUsuario != $rowData['idUsuario']){                                          $Observacion .= '<br/> - Cambio del usuario';}
					if(isset($idEstado) && $idEstado != '' && $idEstado != $rowData['idEstado']){                                              $Observacion .= '<br/> - Cambio de estado';}
					if(isset($idPrioridad) && $idPrioridad != '' && $idPrioridad != $rowData['idPrioridad']){                                  $Observacion .= '<br/> - Cambio de prioridad';}
					if(isset($idTipo) && $idTipo != '' && $idTipo != $rowData['idTipo']){                                                      $Observacion .= '<br/> - Cambio de tipo';}
					if(isset($f_creacion) && $f_creacion != '' && $f_creacion != $rowData['f_creacion']){                                      $Observacion .= '<br/> - Cambio de la fecha de creación (de '.$rowData['f_creacion'].' a '.$f_creacion.')';}
					if(isset($Nombre) && $Nombre != '' && $Nombre != $rowData['Nombre']){                                                      $Observacion .= '<br/> - Cambio de Tarea (de '.$rowData['Nombre'].' a '.$Nombre.')';}
					if(isset($f_termino) && $f_termino != '' && $f_termino != $rowData['f_termino']){                                          $Observacion .= '<br/> - Cambio de fecha de termino (de '.$rowData['f_termino'].' a '.$f_termino.')';}
					if(isset($Observaciones) && $Observaciones != '' && $Observaciones != $rowData['Observaciones']){                          $Observacion .= '<br/> - Cambio de la observacion (de '.$rowData['Observaciones'].' a '.$Observaciones.')';}
					if(isset($idUsuarioCierre) && $idUsuarioCierre != '' && $idUsuarioCierre != $rowData['idUsuarioCierre']){                  $Observacion .= '<br/> - Cambio del usuario de cancelacion';}
					if(isset($f_cierre) && $f_cierre != '' && $f_cierre != $rowData['f_cierre']){                                              $Observacion .= '<br/> - Cambio de fecha de cancelacion (de '.$rowData['f_cierre'].' a '.$f_cierre.')';}
					if(isset($ObservacionesCierre) && $ObservacionesCierre != '' && $ObservacionesCierre != $rowData['ObservacionesCierre']){  $Observacion .= '<br/> - Cambio de la observacion de cancelacion (de '.$rowData['ObservacionesCierre'].' a '.$ObservacionesCierre.')';}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($idTareas) && $idTareas!=''){    $SIS_data  = "'".$idTareas."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
					$SIS_data .= ",'".$Observacion."'";                                      //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id2!=0){
						//redirijo
						header( 'Location: '.$location.'&edited=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'Edit_addResponsable':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idResponsable)){ $ndata_1 = count($idResponsable);}else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idResponsable))==0) {$error['ndata_1'] = 'error/No hay responsables agregados';}
			/*******************************************************************/
			//Consulto
			if(count(array_filter($idResponsable))!=0) {
				/**********************************************/
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					/*******************************************************************/
					//variables
					$ndata_2 = 0;
					//Se verifica si el dato existe
					if(isset($idTareas)&&isset($idResponsable[$j1])){
						$ndata_2 = db_select_nrows (false, 'idTareas', 'tareas_pendientes_listado_responsable', '', "idTareas='".$idTareas."' AND idUsuario='".$idResponsable[$j1]."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					}
					//generacion de errores
					if($ndata_2 > 0) {$error['ndata_2_'.$j1] = 'error/Uno de los Responsables ya existe en la tarea';}
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**********************************************/
				//Recorro los responsables
				for($j1 = 0; $j1 < $ndata_1; $j1++){

					//filtros
					if(isset($idTareas) && $idTareas!=''){                     $SIS_data  = "'".$idTareas."'";              }else{$SIS_data  = "''";}
					if(isset($idResponsable[$j1]) && $idResponsable[$j1]!=''){ $SIS_data .= ",'".$idResponsable[$j1]."'";   }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idTareas, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				}

				/**************************************************************************/
				//Se trae un listado con los usuarios
				$arrUsuarios = array();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$arrUsuarios = db_select_array (false, 'idUsuario, Nombre', 'usuarios_listado', '', 'usuarios_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}else{
					$arrUsuarios = db_select_array (false, 'usuarios_listado.idUsuario, usuarios_listado.Nombre', 'usuarios_listado', 'LEFT JOIN `usuarios_sistemas` ON usuarios_sistemas.idUsuario = usuarios_listado.idUsuario', 'usuarios_sistemas.idSistema = "'.$_SESSION['tareas_basicos']['idSistema'].'" AND usuarios_listado.idEstado=1 GROUP BY usuarios_listado.idUsuario', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/**********************************************/
				//se listan los cuarteles
				$arrUsers = array();
				foreach ($arrUsuarios as $prod) {
					$arrUsers[$prod['idUsuario']]['Nombre'] = $prod['Nombre'];
				}

				/**********************************************/
				//Variables
				$Observacion = 'Se agregan los siguientes responsables:';
				//Recorro los responsables
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					$Observacion .= '<br/> - '.$arrUsers[$idResponsable[$j1]]['Nombre'];
				}

				/*********************************************************************/
				//Se guarda en historial la accion
				if(isset($idTareas) && $idTareas!=''){    $SIS_data  = "'".$idTareas."'";  }else{$SIS_data  = "''";}
				$SIS_data .= ",'".fecha_actual()."'";
				$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$Observacion."'";                                      //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id2!=0){
					//se redirije
					header( 'Location: '.$location.'&createdResp=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'Edit_submit_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idResponsable)){ $ndata_1 = count($idResponsable);   }else{$ndata_1 = 0;}
			if(isset($Observacion)){   $ndata_2 = count($Observacion);     }else{$ndata_2 = 0;}
			//generacion de errores
			if(count(array_filter($idResponsable))==0) { $error['ndata_1'] = 'error/No hay responsables agregados';}
			if(count(array_filter($Observacion))==0) {   $error['ndata_2'] = 'error/No hay tareas asignadas';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**********************************************/
				//Recorro los cuarteles
				for($j1 = 0; $j1 < $ndata_1; $j1++){

					//filtros
					if(isset($idTareas) && $idTareas!=''){                     $SIS_data  = "'".$idTareas."'";              }else{$SIS_data  = "''";}
					$SIS_data .= ",'1'"; //Estado ejecucion
					if(isset($idResponsable[$j1]) && $idResponsable[$j1]!=''){ $SIS_data .= ",'".$idResponsable[$j1]."'";   }else{$SIS_data .= ",''";}
					if(isset($Observacion[$j1]) && $Observacion[$j1]!=''){     $SIS_data .= ",'".$Observacion[$j1]."'";     }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idTareas, idEstadoTarea, idUsuario, Observacion';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_tareas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				}

				/**************************************************************************/
				//Se trae un listado con los usuarios
				$arrUsuarios = array();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$arrUsuarios = db_select_array (false, 'idUsuario, Nombre', 'usuarios_listado', '', 'usuarios_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}else{
					$arrUsuarios = db_select_array (false, 'usuarios_listado.idUsuario, usuarios_listado.Nombre', 'usuarios_listado', 'LEFT JOIN `usuarios_sistemas` ON usuarios_sistemas.idUsuario = usuarios_listado.idUsuario', 'usuarios_sistemas.idSistema = "'.$_SESSION['tareas_basicos']['idSistema'].'" AND usuarios_listado.idEstado=1 GROUP BY usuarios_listado.idUsuario', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/**********************************************/
				//se listan los cuarteles
				$arrUsers = array();
				foreach ($arrUsuarios as $prod) {
					$arrUsers[$prod['idUsuario']]['Nombre'] = $prod['Nombre'];
				}

				/**********************************************/
				//Variables
				$Observacion = 'Se agregan tareas para los siguientes responsables:';
				//Recorro los responsables
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					$Observacion .= '<br/> - '.$arrUsers[$idResponsable[$j1]]['Nombre'].' ('.cortar($Observacion[$j1], 50).')';
				}

				/*********************************************************************/
				//Se guarda en historial la accion
				if(isset($idTareas) && $idTareas!=''){    $SIS_data  = "'".$idTareas."'";  }else{$SIS_data  = "''";}
				$SIS_data .= ",'".fecha_actual()."'";
				$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$Observacion."'";                                      //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id2!=0){
					//redirijo
					header( 'Location: '.$location.'&createdTarea=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'Edit_submit_edit_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**************************************************************************/
				//La observacion
				$SIS_query = 'idEstadoTarea, Observacion';
				$SIS_join  = '';
				$SIS_where = 'idTrabajoTareas ='.$idTrabajoTareas;
				$rowObservacion = db_select_data (false, $SIS_query, 'tareas_pendientes_listado_tareas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Filtros
				$SIS_data = "idTrabajoTareas='".$idTrabajoTareas."'";
				if(isset($idTareas) && $idTareas!=''){            $SIS_data .= ",idTareas='".$idTareas."'";}
				if(isset($idEstadoTarea) && $idEstadoTarea!=''){  $SIS_data .= ",idEstadoTarea='".$idEstadoTarea."'";}
				if(isset($idUsuario) && $idUsuario!=''){          $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Observacion) && $Observacion!=''){      $SIS_data .= ",Observacion='".$Observacion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'tareas_pendientes_listado_tareas', 'idTrabajoTareas = "'.$idTrabajoTareas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//Consulto los estados
					$arrEstadoTarea     = array();
					$arrEstadoTareaTemp = array();
					$arrEstadoTarea = db_select_array (false, 'idEstadoTarea, Nombre', 'core_tareas_pendientes_estados_tareas', '', '', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Creo las variables temporales
					foreach ($arrEstadoTarea as $tarea){
						$arrEstadoTareaTemp[$tarea['idEstadoTarea']] = $tarea['Nombre'];
					}

					//Variables
					$new_Observacion = '';
					//Se construye mensaje
					if(isset($Observacion) && $Observacion != '' && $Observacion != $rowObservacion['Observacion']){          $new_Observacion .= '<br/> - Se cambia la observacion, de '.$rowObservacion['Observacion'].' a '.$Observacion;}
					if(isset($idEstadoTarea) && $idEstadoTarea != '' && $idEstadoTarea != $rowObservacion['idEstadoTarea']){  $new_Observacion .= '<br/> - Se cambia el estado de '.$arrEstadoTareaTemp[$rowObservacion['idEstadoTarea']].' a '.$arrEstadoTareaTemp[$idEstadoTarea];}
					//Guardo historial
					if($new_Observacion!=''){
						//consulta
						$SIS_query = 'Nombre';
						$SIS_join  = '';
						$SIS_where = 'idUsuario ='.$idUsuario;
						$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//mensaje
						$new_Observacion2 = 'Se modifica la tarea por el responsable '.$rowData['Nombre'].':'.$new_Observacion;

						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($idTareas) && $idTareas!=''){    $SIS_data  = "'".$idTareas."'";  }else{$SIS_data  = "''";}
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
						$SIS_data .= ",'".$new_Observacion2."'";                                 //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					//redirijo
					header( 'Location: '.$location.'&editTarea=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'Edit_new_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se verifica que el archivo subido no exceda los 100 kb
			$limite_kb = 10000;
			//Sufijo
			$sufijo = 'tareas_'.genera_password_unica().'_';
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

			//Verifico errores en los archivos
			foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
				if ($_FILES["exFile"]["error"][$key] > 0){
					$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
				}
				if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (file_exists($ruta)){
						$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
					}
				} else {
					$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

			if(empty($error)){

				/***************************************************/
				//Verifico errores en los archivos
				foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
					if ($_FILES["exFile"]["error"][$key] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
					}
					if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"][$key], $ruta);
							if ($move_result){

								//se guarda en el indice siguiente
								$NombreArchivo = $sufijo.$_FILES['exFile']['name'][$key];

								//filtros
								if(isset($idTareas) && $idTareas!=''){           $SIS_data  = "'".$idTareas."'";        }else{$SIS_data  = "''";}
								if(isset($NombreArchivo) && $NombreArchivo!=''){ $SIS_data .= ",'".$NombreArchivo."'";  }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idTareas, NombreArchivo';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_tareas_adjuntos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//Si ejecuto correctamente la consulta
								if($ultimo_id!=0){
									//consulta
									$SIS_query = 'Nombre';
									$SIS_join  = '';
									$SIS_where = 'idUsuario ='.$idUsuario;
									$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									//mensaje
									$new_Observacion = 'Se sube el archivo <strong>'.$NombreArchivo.'</strong> por el usuario '.$rowData['Nombre'];

									/*********************************************************************/
									//Se guarda en historial la accion
									if(isset($idTareas) && $idTareas!=''){    $SIS_data  = "'".$idTareas."'";  }else{$SIS_data  = "''";}
									$SIS_data .= ",'".fecha_actual()."'";
									$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
									$SIS_data .= ",'".$new_Observacion."'";                                  //Observacion
									$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

									// inserto los datos de registro en la db
									$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}

							} else {
								$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
							}
						}else{
							$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
						}
					} else {
						$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
					}
				}

				header( 'Location: '.$location.'&editFiles=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'Edit_cambio_estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				/*******************************************/
				//Consulto el estado actual
				$SIS_query = 'idEstado';
				$SIS_join  = '';
				$SIS_where = 'idTareas ='.$idTareas;
				$rowTarea  = db_select_data (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************/
				//se actualiza
				$SIS_data  = "idEstado='".$idEstado."'";//Cambio de estado
				//Si el cambio cierra la tarea
				if($idEstado>=3){
					$SIS_data .= ",idUsuarioCierre='".$idUsuario."'";
					$SIS_data .= ",f_cierre='".$f_cierre."'";
					if(isset($Observacion)&&$Observacion!=''){$SIS_data .= ",ObservacionesCierre='".$Observacion."'";}
				}

				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'tareas_pendientes_listado', 'idTareas = "'.$idTareas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/************************************************************/
					//Estados
					$Estado[1] = 'Pendiente';
					$Estado[2] = 'En Ejecucion';
					$Estado[3] = 'Finalizado';
					$Estado[4] = 'Vencido';
					$Estado[5] = 'Cancelado';

					//consulta
					$SIS_query = 'Nombre';
					$SIS_join  = '';
					$SIS_where = 'idUsuario ='.$idUsuario;
					$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//mensaje
					$new_Observacion = 'Se modifica la tarea por el responsable '.$rowData['Nombre'].':';
					$new_Observacion.= '<br/> - Se cambia el estado de la tarea de '.$Estado[$rowTarea['idEstado']].' a '.$Estado[$idEstado];
					if(isset($Observacion)&&$Observacion!=''){$new_Observacion.= '<br/> - Con la Observacion: '.$Observacion;}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($idTareas) && $idTareas!=''){    $SIS_data  = "'".$idTareas."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'".$new_Observacion."'";                                 //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idTareas, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'tareas_pendientes_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//redirijo
					header( 'Location: '.$location.'&editEstado=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
	}

?>
