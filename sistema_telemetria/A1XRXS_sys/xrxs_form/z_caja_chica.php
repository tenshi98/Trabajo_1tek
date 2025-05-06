<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-229).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFacturacion']))              $idFacturacion             = $_POST['idFacturacion'];
	if (!empty($_POST['idCajaChica']))                $idCajaChica               = $_POST['idCajaChica'];
	if (!empty($_POST['idSistema']))                  $idSistema                 = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))                  $idUsuario                 = $_POST['idUsuario'];
	if (!empty($_POST['idTipo']))                     $idTipo                    = $_POST['idTipo'];
	if (!empty($_POST['idEstado']))                   $idEstado                  = $_POST['idEstado'];
	if (!empty($_POST['fecha_auto']))                 $fecha_auto                = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha']))             $Creacion_fecha            = $_POST['Creacion_fecha'];
	if (!empty($_POST['Creacion_Semana']))            $Creacion_Semana           = $_POST['Creacion_Semana'];
	if (!empty($_POST['Creacion_mes']))               $Creacion_mes              = $_POST['Creacion_mes'];
	if (!empty($_POST['Creacion_ano']))               $Creacion_ano              = $_POST['Creacion_ano'];
	if (!empty($_POST['Observaciones']))              $Observaciones             = $_POST['Observaciones'];
	if (!empty($_POST['idTrabajador']))               $idTrabajador              = $_POST['idTrabajador'];
	if (!empty($_POST['Valor']))                      $Valor                     = $_POST['Valor'];
	if (!empty($_POST['ValorDevolucion']))            $ValorDevolucion           = $_POST['ValorDevolucion'];
	if (!empty($_POST['idFacturacionRelacionada']))   $idFacturacionRelacionada  = $_POST['idFacturacionRelacionada'];

	if (!empty($_POST['idExistencia']))               $idExistencia              = $_POST['idExistencia'];
	if (!empty($_POST['idDocPago']))                  $idDocPago                 = $_POST['idDocPago'];
	if (!empty($_POST['N_Doc']))                      $N_Doc                     = $_POST['N_Doc'];
	if (!empty($_POST['Valor']))                      $Valor                     = $_POST['Valor'];
	if (!empty($_POST['oldItemID']))                  $oldItemID                 = $_POST['oldItemID'];
	if (!empty($_POST['Item']))                       $Item                      = $_POST['Item'];

	if (!empty($_POST['idSolicitado']))               $idSolicitado              = $_POST['idSolicitado'];
	if (!empty($_POST['idRevisado']))                 $idRevisado                = $_POST['idRevisado'];
	if (!empty($_POST['idAprobado']))                 $idAprobado                = $_POST['idAprobado'];

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
			case 'idFacturacion':              if(empty($idFacturacion)){              $error['idFacturacion']                = 'error/No ha seleccionado el id';}break;
			case 'idCajaChica':                if(empty($idCajaChica)){                $error['idCajaChica']                  = 'error/No ha seleccionado la caja chica';}break;
			case 'idSistema':                  if(empty($idSistema)){                  $error['idSistema']                    = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':                  if(empty($idUsuario)){                  $error['idUsuario']                    = 'error/No ha seleccionado el usuario';}break;
			case 'idTipo':                     if(empty($idTipo)){                     $error['idTipo']                       = 'error/No ha seleccionado el tipo de movimiento';}break;
			case 'idEstado':                   if(empty($idEstado)){                   $error['idEstado']                     = 'error/No ha seleccionado el estado';}break;
			case 'fecha_auto':                 if(empty($fecha_auto)){                 $error['fecha_auto']                   = 'error/No ha ingresado la fecha';}break;
			case 'Creacion_fecha':             if(empty($Creacion_fecha)){             $error['Creacion_fecha']               = 'error/No ha ingresado la fecha';}break;
			case 'Creacion_Semana':            if(empty($Creacion_Semana)){            $error['Creacion_Semana']              = 'error/No ha ingresado la semana';}break;
			case 'Creacion_mes':               if(empty($Creacion_mes)){               $error['Creacion_mes']                 = 'error/No ha ingresado el mes';}break;
			case 'Creacion_ano':               if(empty($Creacion_ano)){               $error['Creacion_ano']                 = 'error/No ha ingresado el año';}break;
			case 'Observaciones':              if(empty($Observaciones)){              $error['Observaciones']                = 'error/No ha ingresado las observaciones';}break;
			case 'idTrabajador':               if(empty($idTrabajador)){               $error['idTrabajador']                 = 'error/No ha seleccionado el trabajador';}break;
			case 'Valor':                      if(empty($Valor)){                      $error['Valor']                        = 'error/No ha ingresado el monto';}break;
			case 'ValorDevolucion':            if(empty($ValorDevolucion)){            $error['ValorDevolucion']              = 'error/No ha ingresado el monto de devolucion';}break;
			case 'idFacturacionRelacionada':   if(empty($idFacturacionRelacionada)){   $error['idFacturacionRelacionada']     = 'error/No ha ingresado la facturacion relacionada';}break;

			case 'idExistencia':               if(empty($idExistencia)){               $error['idExistencia']                 = 'error/No ha seleccionado el id';}break;
			case 'idDocPago':                  if(empty($idDocPago)){                  $error['idDocPago']                    = 'error/No ha seleccionado el documento de pago';}break;
			case 'N_Doc':                      if(empty($N_Doc)){                      $error['N_Doc']                        = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'Valor':                      if(empty($Valor)){                      $error['Valor']                        = 'error/No ha ingresado el valor del documento de pago';}break;
			case 'Item':                       if(empty($Item)){                       $error['Item']                         = 'error/No ha ingresado el texto de la rendicion';}break;

			case 'idSolicitado':               if(empty($idSolicitado)){               $error['idSolicitado']                         = 'error/No ha ingresado el texto de la rendicion';}break;
			case 'idRevisado':                 if(empty($idRevisado)){                 $error['idRevisado']                         = 'error/No ha ingresado el texto de la rendicion';}break;
			case 'idAprobado':                 if(empty($idAprobado)){                 $error['idAprobado']                         = 'error/No ha ingresado el texto de la rendicion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       INGRESOS                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_ingreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['caja_ing_basicos']);
				unset($_SESSION['caja_ing_documentos']);
				unset($_SESSION['caja_ing_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['caja_ing_archivos'])){
					foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
				unset($_SESSION['caja_ing_archivos']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_ing_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_ing_basicos']['Caja']           = $rowCaja['Nombre'];}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){        $_SESSION['caja_ing_basicos']['idCajaChica']     = $idCajaChica;     }else{$_SESSION['caja_ing_basicos']['idCajaChica']     = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['caja_ing_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['caja_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['caja_ing_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['caja_ing_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['caja_ing_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['caja_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['caja_ing_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['caja_ing_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['caja_ing_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['caja_ing_basicos']['idTipo']          = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['caja_ing_basicos']['idEstado']        = $idEstado;        }else{$_SESSION['caja_ing_basicos']['idEstado']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['caja_ing_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['caja_ing_basicos']['fecha_auto']      = '';}
				$_SESSION['caja_ing_basicos']['Valor']           = 0;

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_ing_basicos']);
			unset($_SESSION['caja_ing_documentos']);
			unset($_SESSION['caja_ing_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['caja_ing_archivos'])){
				foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
			unset($_SESSION['caja_ing_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['caja_ing_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['caja_ing_documentos']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_ing_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_ing_basicos']['Caja']           = $rowCaja['Nombre'];}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){        $_SESSION['caja_ing_basicos']['idCajaChica']     = $idCajaChica;     }else{$_SESSION['caja_ing_basicos']['idCajaChica']     = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['caja_ing_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['caja_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['caja_ing_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['caja_ing_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['caja_ing_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['caja_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['caja_ing_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['caja_ing_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['caja_ing_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['caja_ing_basicos']['idTipo']          = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['caja_ing_basicos']['idEstado']        = $idEstado;        }else{$_SESSION['caja_ing_basicos']['idEstado']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['caja_ing_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['caja_ing_basicos']['fecha_auto']      = '';}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'new_monto_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['caja_ing_documentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['caja_ing_documentos'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_ing_documentos'][$idInterno]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_ing_documentos'][$idInterno]['DocPago']  = '';}

				$_SESSION['caja_ing_documentos'][$idInterno]['bvar']      = $idInterno;
				$_SESSION['caja_ing_documentos'][$idInterno]['idDocPago'] = $idDocPago;
				$_SESSION['caja_ing_documentos'][$idInterno]['N_Doc']     = $N_Doc;
				$_SESSION['caja_ing_documentos'][$idInterno]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_monto_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_ing_documentos'][$oldItemID]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_ing_documentos'][$oldItemID]['DocPago']  = '';}

				$_SESSION['caja_ing_documentos'][$oldItemID]['bvar']      = $oldItemID;
				$_SESSION['caja_ing_documentos'][$oldItemID]['idDocPago'] = $idDocPago;
				$_SESSION['caja_ing_documentos'][$oldItemID]['N_Doc']     = $N_Doc;
				$_SESSION['caja_ing_documentos'][$oldItemID]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_monto_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_ing_documentos'][$_GET['del_monto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['caja_ing_archivos'])){
				foreach ($_SESSION['caja_ing_archivos'] as $key => $trabajos){
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
						$sufijo = 'caja_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['caja_ing_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['caja_ing_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['caja_ing_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['caja_ing_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['caja_ing_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'ing_Caja':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['caja_ing_basicos'])){
				if(!isset($_SESSION['caja_ing_basicos']['idCajaChica']) OR $_SESSION['caja_ing_basicos']['idCajaChica']=='' ){       $error['idCajaChica']      = 'error/No ha seleccionado la caja chica de destino';}
				if(!isset($_SESSION['caja_ing_basicos']['idSistema']) OR $_SESSION['caja_ing_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el id del sistema';}
				if(!isset($_SESSION['caja_ing_basicos']['idUsuario']) OR $_SESSION['caja_ing_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['caja_ing_basicos']['idTipo']) OR $_SESSION['caja_ing_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['caja_ing_basicos']['idEstado']) OR $_SESSION['caja_ing_basicos']['idEstado']=='' ){             $error['idEstado']         = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['caja_ing_basicos']['Creacion_fecha']) OR $_SESSION['caja_ing_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['caja_ing_basicos']['Observaciones']) OR $_SESSION['caja_ing_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['caja_ing_basicos']['Valor']) OR $_SESSION['caja_ing_basicos']['Valor']=='' ){                   $error['Valor']            = 'error/No ha ingresado el valor total del documento';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de caja';
			}
			//productos o guias
			if (!isset($_SESSION['caja_ing_documentos'])){
				$error['idProducto']   = 'error/No se han asignado documentos';
			}
			//Se verifican productos
			if (isset($_SESSION['caja_ing_documentos'])){
				foreach ($_SESSION['caja_ing_documentos'] as $key => $producto){
					$n_data1++;
				}
			}

			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado documentos';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['caja_ing_basicos']['idCajaChica']) && $_SESSION['caja_ing_basicos']['idCajaChica']!=''){ $SIS_data  = "'".$_SESSION['caja_ing_basicos']['idCajaChica']."'";    }else{$SIS_data  = "''";}
				if(isset($_SESSION['caja_ing_basicos']['idSistema']) && $_SESSION['caja_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_ing_basicos']['idUsuario']) && $_SESSION['caja_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_ing_basicos']['idTipo']) && $_SESSION['caja_ing_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_ing_basicos']['idEstado']) && $_SESSION['caja_ing_basicos']['idEstado']!=''){       $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idEstado']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_ing_basicos']['fecha_auto']) && $_SESSION['caja_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_ing_basicos']['Creacion_fecha']) && $_SESSION['caja_ing_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['caja_ing_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['caja_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['caja_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['caja_ing_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['caja_ing_basicos']['Observaciones']) && $_SESSION['caja_ing_basicos']['Observaciones']!=''){  $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_ing_basicos']['Valor']) && $_SESSION['caja_ing_basicos']['Valor']!=''){                  $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['Valor']."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCajaChica,idSistema,
				idUsuario,idTipo,idEstado,fecha_auto,Creacion_fecha,Creacion_Semana,
				Creacion_mes,Creacion_ano,Observaciones,Valor';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if (isset($_SESSION['caja_ing_documentos'])){
						foreach ($_SESSION['caja_ing_documentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                     $SIS_data  = "'".$ultimo_id."'";                                      }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_ing_basicos']['idCajaChica']) && $_SESSION['caja_ing_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['idSistema']) && $_SESSION['caja_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['idUsuario']) && $_SESSION['caja_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['idTipo']) && $_SESSION['caja_ing_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['fecha_auto']) && $_SESSION['caja_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['Creacion_fecha']) && $_SESSION['caja_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idDocPago']) && $producto['idDocPago']!=''){   $SIS_data .= ",'".$producto['idDocPago']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['N_Doc']) && $producto['N_Doc']!=''){           $SIS_data .= ",'".$producto['N_Doc']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Valor']) && $producto['Valor']!=''){           $SIS_data .= ",'".$producto['Valor']."'";      }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica,
							idSistema, idUsuario, idTipo, fecha_auto, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocPago, N_Doc, Valor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['caja_ing_archivos'])){
						foreach ($_SESSION['caja_ing_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                     $SIS_data  = "'".$ultimo_id."'";                                      }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_ing_basicos']['idCajaChica']) && $_SESSION['caja_ing_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['idSistema']) && $_SESSION['caja_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['idUsuario']) && $_SESSION['caja_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_ing_basicos']['Creacion_fecha']) && $_SESSION['caja_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['caja_ing_basicos']['Creacion_fecha']) && $_SESSION['caja_ing_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['caja_ing_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Consulto el saldo para poder sumarlo
					$rowResultado = db_select_data (false, 'MontoActual', 'caja_chica_listado', '', 'idCajaChica ='.$_SESSION['caja_ing_basicos']['idCajaChica'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Actualizo el monto
					$nuevoMonto = $rowResultado['MontoActual'] + $_SESSION['caja_ing_basicos']['Valor'];
					$SIS_data = "MontoActual='".$nuevoMonto."'";

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'caja_chica_listado', 'idCajaChica = "'.$_SESSION['caja_ing_basicos']['idCajaChica'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['caja_ing_basicos']);
					unset($_SESSION['caja_ing_documentos']);
					unset($_SESSION['caja_ing_temporal']);
					unset($_SESSION['caja_ing_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       egresoS                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_egreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['caja_eg_basicos']);
				unset($_SESSION['caja_eg_documentos']);
				unset($_SESSION['caja_eg_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['caja_eg_archivos'])){
					foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
				unset($_SESSION['caja_eg_archivos']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae el trabajador
				if(isset($idTrabajador)&&$idTrabajador!=''){
					$rowTrabajador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat, Cargo, Fono, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_eg_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_eg_basicos']['Caja']           = $rowCaja['Nombre'];}
				if(isset($rowTrabajador['Nombre'])&&$rowTrabajador['idTrabajador']!=''){
					$_SESSION['caja_eg_basicos']['Trabajador']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['caja_eg_basicos']['Rut']         = $rowTrabajador['Rut'];
					$_SESSION['caja_eg_basicos']['Cargo']       = $rowTrabajador['Cargo'];
					$_SESSION['caja_eg_basicos']['Fono']        = $rowTrabajador['Fono'];
				}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){        $_SESSION['caja_eg_basicos']['idCajaChica']     = $idCajaChica;     }else{$_SESSION['caja_eg_basicos']['idCajaChica']     = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['caja_eg_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['caja_eg_basicos']['Creacion_fecha']  = '';}
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['caja_eg_basicos']['idTrabajador']    = $idTrabajador;    }else{$_SESSION['caja_eg_basicos']['idTrabajador']    = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['caja_eg_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['caja_eg_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['caja_eg_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['caja_eg_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['caja_eg_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['caja_eg_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['caja_eg_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['caja_eg_basicos']['idTipo']          = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['caja_eg_basicos']['idEstado']        = $idEstado;        }else{$_SESSION['caja_eg_basicos']['idEstado']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['caja_eg_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['caja_eg_basicos']['fecha_auto']      = '';}
				$_SESSION['caja_eg_basicos']['Valor']           = 0;

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_eg_basicos']);
			unset($_SESSION['caja_eg_documentos']);
			unset($_SESSION['caja_eg_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['caja_eg_archivos'])){
				foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
			unset($_SESSION['caja_eg_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['caja_eg_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['caja_eg_documentos']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae el trabajador
				if(isset($idTrabajador)&&$idTrabajador!=''){
					$rowTrabajador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat, Cargo, Fono, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_eg_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_eg_basicos']['Caja']           = $rowCaja['Nombre'];}
				if(isset($rowTrabajador['Nombre'])&&$rowTrabajador['idTrabajador']!=''){
					$_SESSION['caja_eg_basicos']['Trabajador']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['caja_eg_basicos']['Rut']         = $rowTrabajador['Rut'];
					$_SESSION['caja_eg_basicos']['Cargo']       = $rowTrabajador['Cargo'];
					$_SESSION['caja_eg_basicos']['Fono']        = $rowTrabajador['Fono'];
				}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){        $_SESSION['caja_eg_basicos']['idCajaChica']     = $idCajaChica;     }else{$_SESSION['caja_eg_basicos']['idCajaChica']     = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['caja_eg_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['caja_eg_basicos']['Creacion_fecha']  = '';}
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['caja_eg_basicos']['idTrabajador']    = $idTrabajador;    }else{$_SESSION['caja_eg_basicos']['idTrabajador']    = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['caja_eg_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['caja_eg_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['caja_eg_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['caja_eg_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['caja_eg_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['caja_eg_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['caja_eg_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['caja_eg_basicos']['idTipo']          = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['caja_eg_basicos']['idEstado']        = $idEstado;        }else{$_SESSION['caja_eg_basicos']['idEstado']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['caja_eg_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['caja_eg_basicos']['fecha_auto']      = '';}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'new_monto_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['caja_eg_documentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['caja_eg_documentos'] as $key => $producto){
					$idInterno++;
				}
			}

			// Se traen los totales de los productos
			$rowResultado = db_select_data (false, 'MontoActual', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Verifico si los egresos son inferiores a los ingresos
			if($rowResultado['MontoActual']<$Valor){
				$error['MontoActual'] = 'error/No hay suficientes saldo, solo quedan '.Valores($rowResultado['MontoActual'], 0);
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_eg_documentos'][$idInterno]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_eg_documentos'][$idInterno]['DocPago']  = '';}

				$_SESSION['caja_eg_documentos'][$idInterno]['bvar']      = $idInterno;
				$_SESSION['caja_eg_documentos'][$idInterno]['idDocPago'] = $idDocPago;
				$_SESSION['caja_eg_documentos'][$idInterno]['N_Doc']     = $N_Doc;
				$_SESSION['caja_eg_documentos'][$idInterno]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_monto_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen los totales de los productos
			$rowResultado = db_select_data (false, 'MontoActual', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Verifico si los egresos son inferiores a los ingresos
			if($rowResultado['MontoActual']<$Valor){
				$error['MontoActual'] = 'error/No hay suficientes saldo, solo quedan '.Valores($rowResultado['MontoActual'], 0);
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_eg_documentos'][$oldItemID]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_eg_documentos'][$oldItemID]['DocPago']  = '';}

				$_SESSION['caja_eg_documentos'][$oldItemID]['bvar']      = $oldItemID;
				$_SESSION['caja_eg_documentos'][$oldItemID]['idDocPago'] = $idDocPago;
				$_SESSION['caja_eg_documentos'][$oldItemID]['N_Doc']     = $N_Doc;
				$_SESSION['caja_eg_documentos'][$oldItemID]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_monto_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_eg_documentos'][$_GET['del_monto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['caja_eg_archivos'])){
				foreach ($_SESSION['caja_eg_archivos'] as $key => $trabajos){
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
						$sufijo = 'caja_egreso_'.genera_password_unica().'_';

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
									$_SESSION['caja_eg_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['caja_eg_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['caja_eg_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['caja_eg_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['caja_eg_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'eg_Caja':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['caja_eg_basicos'])){
				if(!isset($_SESSION['caja_eg_basicos']['idCajaChica']) OR $_SESSION['caja_eg_basicos']['idCajaChica']=='' ){       $error['idCajaChica']      = 'error/No ha seleccionado la caja chica de destino';}
				if(!isset($_SESSION['caja_eg_basicos']['idSistema']) OR $_SESSION['caja_eg_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el id del sistema';}
				if(!isset($_SESSION['caja_eg_basicos']['idUsuario']) OR $_SESSION['caja_eg_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['caja_eg_basicos']['idTipo']) OR $_SESSION['caja_eg_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['caja_eg_basicos']['idEstado']) OR $_SESSION['caja_eg_basicos']['idEstado']=='' ){             $error['idEstado']         = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['caja_eg_basicos']['Creacion_fecha']) OR $_SESSION['caja_eg_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['caja_eg_basicos']['idTrabajador']) OR $_SESSION['caja_eg_basicos']['idTrabajador']=='' ){     $error['idTrabajador']     = 'error/No ha seleccionado el trabajador';}
				if(!isset($_SESSION['caja_eg_basicos']['Observaciones']) OR $_SESSION['caja_eg_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['caja_eg_basicos']['Valor']) OR $_SESSION['caja_eg_basicos']['Valor']=='' ){                   $error['Valor']            = 'error/No ha ingresado el valor total del documento';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al egreso de caja';
			}
			//productos o guias
			if (!isset($_SESSION['caja_eg_documentos'])){
				$error['idProducto']   = 'error/No se han asignado documentos';
			}
			//Se verifican productos
			if (isset($_SESSION['caja_eg_documentos'])){
				foreach ($_SESSION['caja_eg_documentos'] as $key => $producto){
					$n_data1++;
				}
			}

			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado documentos';
			}

			/*********************************************************************/
			//Consulto el saldo para poder sumarlo
			$rowResultado = db_select_data (false, 'MontoActual', 'caja_chica_listado', '', 'idCajaChica ='.$_SESSION['caja_eg_basicos']['idCajaChica'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica el minimo de trabajos
			if($rowResultado['MontoActual'] < $_SESSION['caja_eg_basicos']['Valor']){
				$error['trabajos'] = 'error/El valor total del egreso es superior al saldo, solo hay '.valores($rowResultado['MontoActual'], 0);
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['caja_eg_basicos']['idCajaChica']) && $_SESSION['caja_eg_basicos']['idCajaChica']!=''){ $SIS_data  = "'".$_SESSION['caja_eg_basicos']['idCajaChica']."'";    }else{$SIS_data  = "''";}
				if(isset($_SESSION['caja_eg_basicos']['idSistema']) && $_SESSION['caja_eg_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_eg_basicos']['idUsuario']) && $_SESSION['caja_eg_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_eg_basicos']['idTipo']) && $_SESSION['caja_eg_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_eg_basicos']['idEstado']) && $_SESSION['caja_eg_basicos']['idEstado']!=''){       $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idEstado']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_eg_basicos']['fecha_auto']) && $_SESSION['caja_eg_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_eg_basicos']['Creacion_fecha']) && $_SESSION['caja_eg_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['caja_eg_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['caja_eg_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['caja_eg_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['caja_eg_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['caja_eg_basicos']['Observaciones']) && $_SESSION['caja_eg_basicos']['Observaciones']!=''){  $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_eg_basicos']['idTrabajador']) && $_SESSION['caja_eg_basicos']['idTrabajador']!=''){    $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idTrabajador']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_eg_basicos']['Valor']) && $_SESSION['caja_eg_basicos']['Valor']!=''){                  $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['Valor']."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCajaChica,idSistema,
				idUsuario,idTipo,idEstado,fecha_auto,Creacion_fecha,Creacion_Semana,
				Creacion_mes,Creacion_ano,Observaciones,idTrabajador,Valor';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if (isset($_SESSION['caja_eg_documentos'])){
						foreach ($_SESSION['caja_eg_documentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                   $SIS_data  = "'".$ultimo_id."'";                                     }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_eg_basicos']['idCajaChica']) && $_SESSION['caja_eg_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['idSistema']) && $_SESSION['caja_eg_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['idUsuario']) && $_SESSION['caja_eg_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['idTipo']) && $_SESSION['caja_eg_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['fecha_auto']) && $_SESSION['caja_eg_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['Creacion_fecha']) && $_SESSION['caja_eg_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_eg_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_eg_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_eg_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idDocPago']) && $producto['idDocPago']!=''){   $SIS_data .= ",'".$producto['idDocPago']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['N_Doc']) && $producto['N_Doc']!=''){           $SIS_data .= ",'".$producto['N_Doc']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Valor']) && $producto['Valor']!=''){           $SIS_data .= ",'".$producto['Valor']."'";      }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica,
							idSistema, idUsuario, idTipo, fecha_auto, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocPago, N_Doc, Valor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['caja_eg_archivos'])){
						foreach ($_SESSION['caja_eg_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                   $SIS_data  = "'".$ultimo_id."'";                                     }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_eg_basicos']['idCajaChica']) && $_SESSION['caja_eg_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['idSistema']) && $_SESSION['caja_eg_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['idUsuario']) && $_SESSION['caja_eg_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_eg_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_eg_basicos']['Creacion_fecha']) && $_SESSION['caja_eg_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_eg_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_eg_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_eg_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['caja_eg_basicos']['Creacion_fecha']) && $_SESSION['caja_eg_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['caja_eg_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Consulto el saldo para poder sumarlo
					$rowResultado = db_select_data (false, 'MontoActual', 'caja_chica_listado', '', 'idCajaChica ='.$_SESSION['caja_eg_basicos']['idCajaChica'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Actualizo el monto
					$nuevoMonto = $rowResultado['MontoActual'] - $_SESSION['caja_eg_basicos']['Valor'];
					$SIS_data = "MontoActual='".$nuevoMonto."'";

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'caja_chica_listado', 'idCajaChica = "'.$_SESSION['caja_eg_basicos']['idCajaChica'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['caja_eg_basicos']);
					unset($_SESSION['caja_eg_documentos']);
					unset($_SESSION['caja_eg_temporal']);
					unset($_SESSION['caja_eg_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       RENDICION                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_rendicion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['caja_rend_basicos']);
				unset($_SESSION['caja_rend_documentos']);
				unset($_SESSION['caja_rend_items']);
				unset($_SESSION['caja_rend_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['caja_rend_archivos'])){
					foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
				unset($_SESSION['caja_rend_archivos']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la facturacion relacionada
				if(isset($idFacturacionRelacionada)&&$idFacturacionRelacionada!=''){
					$rowFacRel = db_select_data (false, 'caja_chica_facturacion.idFacturacion, caja_chica_facturacion.Valor, caja_chica_facturacion.ValorDevolucion, trabajadores_listado.Nombre AS TrabajadorNombre,trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat, trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat', 'caja_chica_facturacion', 'LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador = caja_chica_facturacion.idTrabajador', 'caja_chica_facturacion.idFacturacion ='.$idFacturacionRelacionada, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_rend_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_rend_basicos']['Caja']           = $rowCaja['Nombre'];}
				if(isset($rowFacRel['idFacturacion'])&&$rowFacRel['idFacturacion']!=''){
					$_SESSION['caja_rend_basicos']['Trabajador']       = $rowFacRel['TrabajadorNombre'].' '.$rowFacRel['TrabajadorApellidoPat'].' '.$rowFacRel['TrabajadorApellidoMat'];
					$_SESSION['caja_rend_basicos']['Caja_Valor']       = $rowFacRel['Valor'];
					$_SESSION['caja_rend_basicos']['Caja_Devolucion']  = $rowFacRel['ValorDevolucion'];
					$_SESSION['caja_rend_basicos']['Caja_Saldo']       = $rowFacRel['Valor']-$rowFacRel['ValorDevolucion'];
				}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){                            $_SESSION['caja_rend_basicos']['idCajaChica']              = $idCajaChica;              }else{$_SESSION['caja_rend_basicos']['idCajaChica']               = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){                      $_SESSION['caja_rend_basicos']['Creacion_fecha']           = $Creacion_fecha;           }else{$_SESSION['caja_rend_basicos']['Creacion_fecha']            = '';}
				if(isset($Observaciones)&&$Observaciones!=''){                        $_SESSION['caja_rend_basicos']['Observaciones']            = $Observaciones;            }else{$_SESSION['caja_rend_basicos']['Observaciones']             = '';}
				if(isset($idSistema)&&$idSistema!=''){                                $_SESSION['caja_rend_basicos']['idSistema']                = $idSistema;                }else{$_SESSION['caja_rend_basicos']['idSistema']                 = '';}
				if(isset($idUsuario)&&$idUsuario!=''){                                $_SESSION['caja_rend_basicos']['idUsuario']                = $idUsuario;                }else{$_SESSION['caja_rend_basicos']['idUsuario']                 = '';}
				if(isset($idTipo)&&$idTipo!=''){                                      $_SESSION['caja_rend_basicos']['idTipo']                   = $idTipo;                   }else{$_SESSION['caja_rend_basicos']['idTipo']                    = '';}
				if(isset($idEstado)&&$idEstado!=''){                                  $_SESSION['caja_rend_basicos']['idEstado']                 = $idEstado;                 }else{$_SESSION['caja_rend_basicos']['idEstado']                  = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){                              $_SESSION['caja_rend_basicos']['fecha_auto']               = $fecha_auto;               }else{$_SESSION['caja_rend_basicos']['fecha_auto']                = '';}
				if(isset($idFacturacionRelacionada)&&$idFacturacionRelacionada!=''){  $_SESSION['caja_rend_basicos']['idFacturacionRelacionada'] = $idFacturacionRelacionada; }else{$_SESSION['caja_rend_basicos']['idFacturacionRelacionada']  = '';}
				$_SESSION['caja_rend_basicos']['Valor']                    = 0;

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_rend_basicos']);
			unset($_SESSION['caja_rend_documentos']);
			unset($_SESSION['caja_rend_items']);
			unset($_SESSION['caja_rend_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['caja_rend_archivos'])){
				foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
			unset($_SESSION['caja_rend_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['caja_rend_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['caja_rend_documentos']);
				unset($_SESSION['caja_rend_items']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la facturacion relacionada
				if(isset($idFacturacionRelacionada)&&$idFacturacionRelacionada!=''){
					$rowFacRel = db_select_data (false, 'caja_chica_facturacion.idFacturacion, caja_chica_facturacion.Valor, caja_chica_facturacion.ValorDevolucion, trabajadores_listado.Nombre AS TrabajadorNombre,trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat, trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat', 'caja_chica_facturacion', 'LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador = caja_chica_facturacion.idTrabajador', 'caja_chica_facturacion.idFacturacion ='.$idFacturacionRelacionada, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_rend_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_rend_basicos']['Caja']           = $rowCaja['Nombre'];}
				if(isset($rowFacRel['idFacturacion'])&&$rowFacRel['idFacturacion']!=''){
					$_SESSION['caja_rend_basicos']['Trabajador']       = $rowFacRel['TrabajadorNombre'].' '.$rowFacRel['TrabajadorApellidoPat'].' '.$rowFacRel['TrabajadorApellidoMat'];
					$_SESSION['caja_rend_basicos']['Caja_Valor']       = $rowFacRel['Valor'];
					$_SESSION['caja_rend_basicos']['Caja_Devolucion']  = $rowFacRel['ValorDevolucion'];
					$_SESSION['caja_rend_basicos']['Caja_Saldo']       = $rowFacRel['Valor']-$rowFacRel['ValorDevolucion'];
				}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){                            $_SESSION['caja_rend_basicos']['idCajaChica']              = $idCajaChica;              }else{$_SESSION['caja_rend_basicos']['idCajaChica']               = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){                      $_SESSION['caja_rend_basicos']['Creacion_fecha']           = $Creacion_fecha;           }else{$_SESSION['caja_rend_basicos']['Creacion_fecha']            = '';}
				if(isset($Observaciones)&&$Observaciones!=''){                        $_SESSION['caja_rend_basicos']['Observaciones']            = $Observaciones;            }else{$_SESSION['caja_rend_basicos']['Observaciones']             = '';}
				if(isset($idSistema)&&$idSistema!=''){                                $_SESSION['caja_rend_basicos']['idSistema']                = $idSistema;                }else{$_SESSION['caja_rend_basicos']['idSistema']                 = '';}
				if(isset($idUsuario)&&$idUsuario!=''){                                $_SESSION['caja_rend_basicos']['idUsuario']                = $idUsuario;                }else{$_SESSION['caja_rend_basicos']['idUsuario']                 = '';}
				if(isset($idTipo)&&$idTipo!=''){                                      $_SESSION['caja_rend_basicos']['idTipo']                   = $idTipo;                   }else{$_SESSION['caja_rend_basicos']['idTipo']                    = '';}
				if(isset($idEstado)&&$idEstado!=''){                                  $_SESSION['caja_rend_basicos']['idEstado']                 = $idEstado;                 }else{$_SESSION['caja_rend_basicos']['idEstado']                  = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){                              $_SESSION['caja_rend_basicos']['fecha_auto']               = $fecha_auto;               }else{$_SESSION['caja_rend_basicos']['fecha_auto']                = '';}
				if(isset($idFacturacionRelacionada)&&$idFacturacionRelacionada!=''){  $_SESSION['caja_rend_basicos']['idFacturacionRelacionada'] = $idFacturacionRelacionada; }else{$_SESSION['caja_rend_basicos']['idFacturacionRelacionada']  = '';}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'new_monto_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['caja_rend_documentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['caja_rend_documentos'] as $key => $producto){
					$idInterno++;
				}
			}

			/*********************************************************************/
			//Consulto el saldo para poder sumarlo
			$rowResultado = db_select_data (false, 'Valor, ValorDevolucion', 'caja_chica_facturacion', '', 'idFacturacion ='.$_SESSION['caja_rend_basicos']['idFacturacionRelacionada'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica el minimo de trabajos
			if(($rowResultado['Valor']-$rowResultado['ValorDevolucion']) < $Valor){
				$error['trabajos'] = 'error/El valor total de la rendicion es superior al del saldo del documento relacionado, solo son '.valores($rowResultado['Valor']-$rowResultado['ValorDevolucion'], 0).' como maximo';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_rend_documentos'][$idInterno]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_rend_documentos'][$idInterno]['DocPago']  = '';}

				$_SESSION['caja_rend_documentos'][$idInterno]['bvar']      = $idInterno;
				$_SESSION['caja_rend_documentos'][$idInterno]['idDocPago'] = $idDocPago;
				$_SESSION['caja_rend_documentos'][$idInterno]['N_Doc']     = $N_Doc;
				$_SESSION['caja_rend_documentos'][$idInterno]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_monto_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*********************************************************************/
			//Consulto el saldo para poder sumarlo
			$rowResultado = db_select_data (false, 'Valor, ValorDevolucion', 'caja_chica_facturacion', '', 'idFacturacion ='.$_SESSION['caja_rend_basicos']['idFacturacionRelacionada'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica el minimo de trabajos
			if(($rowResultado['Valor']-$rowResultado['ValorDevolucion']) < $Valor){
				$error['trabajos'] = 'error/El valor total de la rendicion es superior al del saldo del documento relacionado, solo son '.valores($rowResultado['Valor']-$rowResultado['ValorDevolucion'], 0).' como maximo';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_rend_documentos'][$oldItemID]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_rend_documentos'][$oldItemID]['DocPago']  = '';}

				$_SESSION['caja_rend_documentos'][$oldItemID]['bvar']      = $oldItemID;
				$_SESSION['caja_rend_documentos'][$oldItemID]['idDocPago'] = $idDocPago;
				$_SESSION['caja_rend_documentos'][$oldItemID]['N_Doc']     = $N_Doc;
				$_SESSION['caja_rend_documentos'][$oldItemID]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_monto_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_rend_documentos'][$_GET['del_monto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_item_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['caja_rend_items'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['caja_rend_items'] as $key => $producto){
					$idInterno++;
				}
			}

			/*********************************************************************/
			//Consulto el saldo para poder sumarlo
			$rowResultado = db_select_data (false, 'Valor, ValorDevolucion', 'caja_chica_facturacion', '', 'idFacturacion ='.$_SESSION['caja_rend_basicos']['idFacturacionRelacionada'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica el minimo de trabajos
			if(($rowResultado['Valor']-$rowResultado['ValorDevolucion']) < $Valor){
				$error['trabajos'] = 'error/El valor total de la rendicion es superior al del saldo del documento relacionado, solo son '.valores($rowResultado['Valor']-$rowResultado['ValorDevolucion'], 0).' como maximo';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['caja_rend_items'][$idInterno]['bvar']      = $idInterno;
				$_SESSION['caja_rend_items'][$idInterno]['Item']      = $Item;
				$_SESSION['caja_rend_items'][$idInterno]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_item_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*********************************************************************/
			//Consulto el saldo para poder sumarlo
			$rowResultado = db_select_data (false, 'Valor, ValorDevolucion', 'caja_chica_facturacion', '', 'idFacturacion ='.$_SESSION['caja_rend_basicos']['idFacturacionRelacionada'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica el minimo de trabajos
			if(($rowResultado['Valor']-$rowResultado['ValorDevolucion']) < $Valor){
				$error['trabajos'] = 'error/El valor total de la rendicion es superior al del saldo del documento relacionado, solo son '.valores($rowResultado['Valor']-$rowResultado['ValorDevolucion'], 0).' como maximo';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['caja_rend_items'][$oldItemID]['bvar']      = $oldItemID;
				$_SESSION['caja_rend_items'][$oldItemID]['Item']      = $Item;
				$_SESSION['caja_rend_items'][$oldItemID]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_item_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_rend_items'][$_GET['del_item']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['caja_rend_archivos'])){
				foreach ($_SESSION['caja_rend_archivos'] as $key => $trabajos){
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
						$sufijo = 'caja_rendreso_'.genera_password_unica().'_';

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
									$_SESSION['caja_rend_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['caja_rend_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_rend':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['caja_rend_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['caja_rend_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['caja_rend_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'rend_Caja':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['caja_rend_basicos'])){
				if(!isset($_SESSION['caja_rend_basicos']['idCajaChica']) OR $_SESSION['caja_rend_basicos']['idCajaChica']=='' ){                           $error['idCajaChica']               = 'error/No ha seleccionado la caja chica de destino';}
				if(!isset($_SESSION['caja_rend_basicos']['idSistema']) OR $_SESSION['caja_rend_basicos']['idSistema']=='' ){                               $error['idSistema']                 = 'error/No ha seleccionado el id del sistema';}
				if(!isset($_SESSION['caja_rend_basicos']['idUsuario']) OR $_SESSION['caja_rend_basicos']['idUsuario']=='' ){                               $error['idUsuario']                 = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['caja_rend_basicos']['idTipo']) OR $_SESSION['caja_rend_basicos']['idTipo']=='' ){                                     $error['idTipo']                    = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['caja_rend_basicos']['idEstado']) OR $_SESSION['caja_rend_basicos']['idEstado']=='' ){                                 $error['idEstado']                  = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['caja_rend_basicos']['Creacion_fecha']) OR $_SESSION['caja_rend_basicos']['Creacion_fecha']=='' ){                     $error['Creacion_fecha']            = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['caja_rend_basicos']['Observaciones']) OR $_SESSION['caja_rend_basicos']['Observaciones']=='' ){                       $error['Observaciones']             = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['caja_rend_basicos']['Valor']) OR $_SESSION['caja_rend_basicos']['Valor']=='' ){                                       $error['Valor']                     = 'error/No ha ingresado el valor total del documento';}
				if(!isset($_SESSION['caja_rend_basicos']['idFacturacionRelacionada']) OR $_SESSION['caja_rend_basicos']['idFacturacionRelacionada']=='' ){ $error['idFacturacionRelacionada']  = 'error/No ha ingresado el documento relacionado';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la rendicion de caja';
			}
			//productos o guias
			if (!isset($_SESSION['caja_rend_documentos'])){
				$error['idProducto']   = 'error/No se han asignado documentos';
			}
			//Se verifican productos
			if (isset($_SESSION['caja_rend_documentos'])){
				foreach ($_SESSION['caja_rend_documentos'] as $key => $producto){
					$n_data1++;
				}
			}

			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado documentos';
			}

			/*********************************************************************/
			//Consulto el saldo para poder sumarlo
			$rowResultado = db_select_data (false, 'Valor, ValorDevolucion', 'caja_chica_facturacion', '', 'idFacturacion ='.$_SESSION['caja_rend_basicos']['idFacturacionRelacionada'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica el minimo de trabajos
			if(($rowResultado['Valor']-$rowResultado['ValorDevolucion']) < $_SESSION['caja_rend_basicos']['Valor']){
				$error['trabajos'] = 'error/El valor total de la rendicion es superior al del saldo del documento relacionado, solo son '.valores($rowResultado['Valor']-$rowResultado['ValorDevolucion'], 0).' como maximo';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['caja_rend_basicos']['idCajaChica']) && $_SESSION['caja_rend_basicos']['idCajaChica']!=''){ $SIS_data  = "'".$_SESSION['caja_rend_basicos']['idCajaChica']."'";    }else{$SIS_data  = "''";}
				if(isset($_SESSION['caja_rend_basicos']['idSistema']) && $_SESSION['caja_rend_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rend_basicos']['idUsuario']) && $_SESSION['caja_rend_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rend_basicos']['idTipo']) && $_SESSION['caja_rend_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rend_basicos']['idEstado']) && $_SESSION['caja_rend_basicos']['idEstado']!=''){       $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idEstado']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rend_basicos']['fecha_auto']) && $_SESSION['caja_rend_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rend_basicos']['Creacion_fecha']) && $_SESSION['caja_rend_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['caja_rend_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['caja_rend_basicos']['Observaciones']) && $_SESSION['caja_rend_basicos']['Observaciones']!=''){                        $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['Observaciones']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rend_basicos']['Valor']) && $_SESSION['caja_rend_basicos']['Valor']!=''){                                        $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['Valor']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rend_basicos']['idFacturacionRelacionada']) && $_SESSION['caja_rend_basicos']['idFacturacionRelacionada']!=''){  $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idFacturacionRelacionada']."'"; }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCajaChica,idSistema,
				idUsuario,idTipo,idEstado,fecha_auto,Creacion_fecha,Creacion_Semana,
				Creacion_mes,Creacion_ano,Observaciones,Valor, idFacturacionRelacionada';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if (isset($_SESSION['caja_rend_items'])){
						foreach ($_SESSION['caja_rend_items'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_rend_basicos']['idCajaChica']) && $_SESSION['caja_rend_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idSistema']) && $_SESSION['caja_rend_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idUsuario']) && $_SESSION['caja_rend_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idTipo']) && $_SESSION['caja_rend_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['fecha_auto']) && $_SESSION['caja_rend_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['Creacion_fecha']) && $_SESSION['caja_rend_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_rend_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Item']) && $producto['Item']!=''){    $SIS_data .= ",'".$producto['Item']."'";   }else{$SIS_data .= ",''";}
							if(isset($producto['Valor']) && $producto['Valor']!=''){  $SIS_data .= ",'".$producto['Valor']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica,
							idSistema, idUsuario, idTipo, fecha_auto, Creacion_fecha, Creacion_mes, Creacion_ano,
							Item, Valor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_rendiciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Variable para el total de la devolucion
					$subDevolucion = 0;

					//Se guardan los datos de los documentos utilizados
					if (isset($_SESSION['caja_rend_documentos'])){
						foreach ($_SESSION['caja_rend_documentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_rend_basicos']['idCajaChica']) && $_SESSION['caja_rend_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idSistema']) && $_SESSION['caja_rend_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idUsuario']) && $_SESSION['caja_rend_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idTipo']) && $_SESSION['caja_rend_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['fecha_auto']) && $_SESSION['caja_rend_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['Creacion_fecha']) && $_SESSION['caja_rend_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_rend_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idDocPago']) && $producto['idDocPago']!=''){   $SIS_data .= ",'".$producto['idDocPago']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['N_Doc']) && $producto['N_Doc']!=''){           $SIS_data .= ",'".$producto['N_Doc']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Valor']) && $producto['Valor']!=''){           $SIS_data .= ",'".$producto['Valor']."'";      }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica,
							idSistema, idUsuario, idTipo, fecha_auto, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocPago, N_Doc, Valor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Sumo los valores de la devolucion
							if(isset($producto['Valor']) && $producto['Valor']!=''){
								$subDevolucion = $subDevolucion + $producto['Valor'];
							}
						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['caja_rend_archivos'])){
						foreach ($_SESSION['caja_rend_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_rend_basicos']['idCajaChica']) && $_SESSION['caja_rend_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idSistema']) && $_SESSION['caja_rend_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['idUsuario']) && $_SESSION['caja_rend_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rend_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rend_basicos']['Creacion_fecha']) && $_SESSION['caja_rend_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_rend_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rend_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['caja_rend_basicos']['Creacion_fecha']) && $_SESSION['caja_rend_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['caja_rend_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Consulto el saldo para poder sumarlo
					$rowResultado = db_select_data (false, 'MontoActual', 'caja_chica_listado', '', 'idCajaChica ='.$_SESSION['caja_rend_basicos']['idCajaChica'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Actualizo el monto
					$nuevoMonto = $rowResultado['MontoActual'] + $subDevolucion;
					$SIS_data = "MontoActual='".$nuevoMonto."'";

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'caja_chica_listado', 'idCajaChica = "'.$_SESSION['caja_rend_basicos']['idCajaChica'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Consulto el documento relacionado para poder sumarle el valor de la devolucion
					$rowResultado = db_select_data (false, 'Valor, ValorDevolucion', 'caja_chica_facturacion', '', 'idFacturacion ='.$_SESSION['caja_rend_basicos']['idFacturacionRelacionada'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Actualizo el monto
					$nuevoMonto = $rowResultado['ValorDevolucion'] + $_SESSION['caja_rend_basicos']['Valor'];
					$SIS_data = "ValorDevolucion='".$nuevoMonto."'";
					//Si la devolucion es igual al valor total del documento relacionado
					if($rowResultado['Valor']<=$nuevoMonto){
						$SIS_data .= ",idEstado='2'";
					}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'caja_chica_facturacion', 'idFacturacion = "'.$_SESSION['caja_rend_basicos']['idFacturacionRelacionada'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['caja_rend_basicos']);
					unset($_SESSION['caja_rend_documentos']);
					unset($_SESSION['caja_rend_temporal']);
					unset($_SESSION['caja_rend_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                     CAJAS RENDIDAS                                              */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['caja_rendida_basicos']);
				unset($_SESSION['caja_rendida_documentos']);
				unset($_SESSION['caja_rendida_items']);
				unset($_SESSION['caja_rendida_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['caja_rendida_archivos'])){
					foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
				unset($_SESSION['caja_rendida_archivos']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae el trabajador
				if(isset($idTrabajador)&&$idTrabajador!=''){
					$rowTrabajador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat, Cargo, Fono, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la persona ue los solicito
				if(isset($idSolicitado)&&$idSolicitado!=''){
					$rowSolicitante = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador ='.$idSolicitado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la persona que lo reviso
				if(isset($idRevisado)&&$idRevisado!=''){
					$rowRevisador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador ='.$idRevisado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la persona que lo aprobo
				if(isset($idAprobado)&&$idAprobado!=''){
					$rowAprobador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador ='.$idAprobado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_rendida_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_rendida_basicos']['Caja']           = $rowCaja['Nombre'];}
				if(isset($rowTrabajador['idTrabajador'])&&$rowTrabajador['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Trab_Nombre']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['caja_rendida_basicos']['Trab_Cargo']   = $rowTrabajador['Cargo'];
					$_SESSION['caja_rendida_basicos']['Trab_Fono']    = $rowTrabajador['Fono'];
					$_SESSION['caja_rendida_basicos']['Trab_Rut']     = $rowTrabajador['Rut'];
				}
				if(isset($rowSolicitante['idTrabajador'])&&$rowSolicitante['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Soli_Nombre']  = $rowSolicitante['Nombre'].' '.$rowSolicitante['ApellidoPat'].' '.$rowSolicitante['ApellidoMat'];
				}
				if(isset($rowRevisador['idTrabajador'])&&$rowRevisador['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Rev_Nombre']  = $rowRevisador['Nombre'].' '.$rowRevisador['ApellidoPat'].' '.$rowRevisador['ApellidoMat'];
				}
				if(isset($rowAprobador['idTrabajador'])&&$rowAprobador['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Apro_Nombre']  = $rowAprobador['Nombre'].' '.$rowAprobador['ApellidoPat'].' '.$rowAprobador['ApellidoMat'];
				}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){        $_SESSION['caja_rendida_basicos']['idCajaChica']     = $idCajaChica;    }else{$_SESSION['caja_rendida_basicos']['idCajaChica']     = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['caja_rendida_basicos']['Creacion_fecha']  = $Creacion_fecha; }else{$_SESSION['caja_rendida_basicos']['Creacion_fecha']  = '';}
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['caja_rendida_basicos']['idTrabajador']    = $idTrabajador;   }else{$_SESSION['caja_rendida_basicos']['idTrabajador']    = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['caja_rendida_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['caja_rendida_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['caja_rendida_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['caja_rendida_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['caja_rendida_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['caja_rendida_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['caja_rendida_basicos']['idTipo']          = $idTipo;         }else{$_SESSION['caja_rendida_basicos']['idTipo']          = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['caja_rendida_basicos']['idEstado']        = $idEstado;       }else{$_SESSION['caja_rendida_basicos']['idEstado']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['caja_rendida_basicos']['fecha_auto']      = $fecha_auto;     }else{$_SESSION['caja_rendida_basicos']['fecha_auto']      = '';}
				if(isset($idSolicitado)&&$idSolicitado!=''){      $_SESSION['caja_rendida_basicos']['idSolicitado']    = $idSolicitado;   }else{$_SESSION['caja_rendida_basicos']['idSolicitado']    = '';}
				if(isset($idRevisado)&&$idRevisado!=''){          $_SESSION['caja_rendida_basicos']['idRevisado']      = $idRevisado;     }else{$_SESSION['caja_rendida_basicos']['idRevisado']      = '';}
				if(isset($idAprobado)&&$idAprobado!=''){          $_SESSION['caja_rendida_basicos']['idAprobado']      = $idAprobado;     }else{$_SESSION['caja_rendida_basicos']['idAprobado']      = '';}
				$_SESSION['caja_rendida_basicos']['Valor']           = 0;

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_rendida_basicos']);
			unset($_SESSION['caja_rendida_documentos']);
			unset($_SESSION['caja_rendida_items']);
			unset($_SESSION['caja_rendida_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['caja_rendida_archivos'])){
				foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
			unset($_SESSION['caja_rendida_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['caja_rendida_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['caja_rendida_documentos']);
				unset($_SESSION['caja_rendida_items']);

				/*****************************************/
				// Se trae el tipo de documento
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'caja_chica_facturacion_tipo', '', 'idTipo ='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la Caja
				if(isset($idCajaChica)&&$idCajaChica!=''){
					$rowCaja = db_select_data (false, 'Nombre', 'caja_chica_listado', '', 'idCajaChica ='.$idCajaChica, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae el trabajador
				if(isset($idTrabajador)&&$idTrabajador!=''){
					$rowTrabajador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat, Cargo, Fono, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la persona ue los solicito
				if(isset($idSolicitado)&&$idSolicitado!=''){
					$rowSolicitante = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador ='.$idSolicitado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la persona que lo reviso
				if(isset($idRevisado)&&$idRevisado!=''){
					$rowRevisador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador ='.$idRevisado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*****************************************/
				// Se trae la persona que lo aprobo
				if(isset($idAprobado)&&$idAprobado!=''){
					$rowAprobador = db_select_data (false, 'idTrabajador, Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador ='.$idAprobado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowTipoDocumento['Nombre'])&&$rowTipoDocumento['Nombre']!=''){  $_SESSION['caja_rendida_basicos']['TipoDocumento']  = $rowTipoDocumento['Nombre'];}
				if(isset($rowCaja['Nombre'])&&$rowCaja['Nombre']!=''){                    $_SESSION['caja_rendida_basicos']['Caja']           = $rowCaja['Nombre'];}
				if(isset($rowTrabajador['idTrabajador'])&&$rowTrabajador['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Trab_Nombre']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['caja_rendida_basicos']['Trab_Cargo']   = $rowTrabajador['Cargo'];
					$_SESSION['caja_rendida_basicos']['Trab_Fono']    = $rowTrabajador['Fono'];
					$_SESSION['caja_rendida_basicos']['Trab_Rut']     = $rowTrabajador['Rut'];
				}
				if(isset($rowSolicitante['idTrabajador'])&&$rowSolicitante['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Soli_Nombre']  = $rowSolicitante['Nombre'].' '.$rowSolicitante['ApellidoPat'].' '.$rowSolicitante['ApellidoMat'];
				}
				if(isset($rowRevisador['idTrabajador'])&&$rowRevisador['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Rev_Nombre']  = $rowRevisador['Nombre'].' '.$rowRevisador['ApellidoPat'].' '.$rowRevisador['ApellidoMat'];
				}
				if(isset($rowAprobador['idTrabajador'])&&$rowAprobador['idTrabajador']!=''){
					$_SESSION['caja_rendida_basicos']['Apro_Nombre']  = $rowAprobador['Nombre'].' '.$rowAprobador['ApellidoPat'].' '.$rowAprobador['ApellidoMat'];
				}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCajaChica)&&$idCajaChica!=''){        $_SESSION['caja_rendida_basicos']['idCajaChica']     = $idCajaChica;    }else{$_SESSION['caja_rendida_basicos']['idCajaChica']     = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['caja_rendida_basicos']['Creacion_fecha']  = $Creacion_fecha; }else{$_SESSION['caja_rendida_basicos']['Creacion_fecha']  = '';}
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['caja_rendida_basicos']['idTrabajador']    = $idTrabajador;   }else{$_SESSION['caja_rendida_basicos']['idTrabajador']    = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['caja_rendida_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['caja_rendida_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['caja_rendida_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['caja_rendida_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['caja_rendida_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['caja_rendida_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['caja_rendida_basicos']['idTipo']          = $idTipo;         }else{$_SESSION['caja_rendida_basicos']['idTipo']          = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['caja_rendida_basicos']['idEstado']        = $idEstado;       }else{$_SESSION['caja_rendida_basicos']['idEstado']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['caja_rendida_basicos']['fecha_auto']      = $fecha_auto;     }else{$_SESSION['caja_rendida_basicos']['fecha_auto']      = '';}
				if(isset($idSolicitado)&&$idSolicitado!=''){      $_SESSION['caja_rendida_basicos']['idSolicitado']    = $idSolicitado;   }else{$_SESSION['caja_rendida_basicos']['idSolicitado']    = '';}
				if(isset($idRevisado)&&$idRevisado!=''){          $_SESSION['caja_rendida_basicos']['idRevisado']      = $idRevisado;     }else{$_SESSION['caja_rendida_basicos']['idRevisado']      = '';}
				if(isset($idAprobado)&&$idAprobado!=''){          $_SESSION['caja_rendida_basicos']['idAprobado']      = $idAprobado;     }else{$_SESSION['caja_rendida_basicos']['idAprobado']      = '';}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'new_monto_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['caja_rendida_documentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['caja_rendida_documentos'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_rendida_documentos'][$idInterno]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_rendida_documentos'][$idInterno]['DocPago']  = '';}

				$_SESSION['caja_rendida_documentos'][$idInterno]['bvar']      = $idInterno;
				$_SESSION['caja_rendida_documentos'][$idInterno]['idDocPago'] = $idDocPago;
				$_SESSION['caja_rendida_documentos'][$idInterno]['N_Doc']     = $N_Doc;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_monto_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae la Caja
				if(isset($idDocPago)&&$idDocPago!=''){
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago ='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*****************************************/
				// Se guardan los datos
				if(isset($rowDocPago['Nombre'])&&$rowDocPago['Nombre']!=''){  $_SESSION['caja_rendida_documentos'][$oldItemID]['DocPago']  = $rowDocPago['Nombre'];}else{$_SESSION['caja_rendida_documentos'][$oldItemID]['DocPago']  = '';}

				$_SESSION['caja_rendida_documentos'][$oldItemID]['bvar']      = $oldItemID;
				$_SESSION['caja_rendida_documentos'][$oldItemID]['idDocPago'] = $idDocPago;
				$_SESSION['caja_rendida_documentos'][$oldItemID]['N_Doc']     = $N_Doc;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_monto_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_rendida_documentos'][$_GET['del_monto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_item_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['caja_rendida_items'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['caja_rendida_items'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['caja_rendida_items'][$idInterno]['bvar']      = $idInterno;
				$_SESSION['caja_rendida_items'][$idInterno]['Item']      = $Item;
				$_SESSION['caja_rendida_items'][$idInterno]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_item_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['caja_rendida_items'][$oldItemID]['bvar']      = $oldItemID;
				$_SESSION['caja_rendida_items'][$oldItemID]['Item']      = $Item;
				$_SESSION['caja_rendida_items'][$oldItemID]['Valor']     = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_item_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['caja_rendida_items'][$_GET['del_item']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['caja_rendida_archivos'])){
				foreach ($_SESSION['caja_rendida_archivos'] as $key => $trabajos){
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
						$sufijo = 'caja_rendreso_'.genera_password_unica().'_';

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
									$_SESSION['caja_rendida_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['caja_rendida_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_rendida':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['caja_rendida_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['caja_rendida_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['caja_rendida_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'rendida_Caja':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['caja_rendida_basicos'])){
				if(!isset($_SESSION['caja_rendida_basicos']['idCajaChica']) OR $_SESSION['caja_rendida_basicos']['idCajaChica']=='' ){           $error['idCajaChica']     = 'error/No ha seleccionado la caja chica de destino';}
				if(!isset($_SESSION['caja_rendida_basicos']['idSistema']) OR $_SESSION['caja_rendida_basicos']['idSistema']=='' ){               $error['idSistema']       = 'error/No ha seleccionado el id del sistema';}
				if(!isset($_SESSION['caja_rendida_basicos']['idUsuario']) OR $_SESSION['caja_rendida_basicos']['idUsuario']=='' ){               $error['idUsuario']       = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['caja_rendida_basicos']['idTipo']) OR $_SESSION['caja_rendida_basicos']['idTipo']=='' ){                     $error['idTipo']          = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['caja_rendida_basicos']['idEstado']) OR $_SESSION['caja_rendida_basicos']['idEstado']=='' ){                 $error['idEstado']        = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) OR $_SESSION['caja_rendida_basicos']['Creacion_fecha']=='' ){     $error['Creacion_fecha']  = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['caja_rendida_basicos']['Observaciones']) OR $_SESSION['caja_rendida_basicos']['Observaciones']=='' ){       $error['Observaciones']   = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['caja_rendida_basicos']['Valor']) OR $_SESSION['caja_rendida_basicos']['Valor']=='' ){                       $error['Valor']           = 'error/No ha ingresado el valor total del documento';}
				if(!isset($_SESSION['caja_rendida_basicos']['idTrabajador']) OR $_SESSION['caja_rendida_basicos']['idTrabajador']=='' ){         $error['idTrabajador']    = 'error/No ha seleccionado el trabajador';}
				if(!isset($_SESSION['caja_rendida_basicos']['idSolicitado']) OR $_SESSION['caja_rendida_basicos']['idSolicitado']=='' ){         $error['idSolicitado']    = 'error/No ha seleccionado a la persona solicitante';}
				if(!isset($_SESSION['caja_rendida_basicos']['idRevisado']) OR $_SESSION['caja_rendida_basicos']['idRevisado']=='' ){             $error['idRevisado']      = 'error/No ha seleccionado a la persona encargada de revisar';}
				if(!isset($_SESSION['caja_rendida_basicos']['idAprobado']) OR $_SESSION['caja_rendida_basicos']['idAprobado']=='' ){             $error['idAprobado']      = 'error/No ha seleccionado a la persona que aprobo';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la rendicion de caja';
			}
			//productos o guias
			if (!isset($_SESSION['caja_rendida_documentos'])){
				$error['idProducto']   = 'error/No se han asignado documentos';
			}
			//Se verifican productos
			if (isset($_SESSION['caja_rendida_documentos'])){
				foreach ($_SESSION['caja_rendida_documentos'] as $key => $producto){
					$n_data1++;
				}
			}

			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado documentos';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//////////////////////////////////////////////////////////////////////////
				//Egreso
				//Se guardan los datos basicos
				if(isset($_SESSION['caja_rendida_basicos']['idCajaChica']) && $_SESSION['caja_rendida_basicos']['idCajaChica']!=''){ $SIS_data  = "'".$_SESSION['caja_rendida_basicos']['idCajaChica']."'";    }else{$SIS_data  = "''";}
				if(isset($_SESSION['caja_rendida_basicos']['idSistema']) && $_SESSION['caja_rendida_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['idUsuario']) && $_SESSION['caja_rendida_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				$SIS_data .= ",'2'";
				if(isset($_SESSION['caja_rendida_basicos']['idEstado']) && $_SESSION['caja_rendida_basicos']['idEstado']!=''){       $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idEstado']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['fecha_auto']) && $_SESSION['caja_rendida_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) && $_SESSION['caja_rendida_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['caja_rendida_basicos']['Observaciones']) && $_SESSION['caja_rendida_basicos']['Observaciones']!=''){  $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['idTrabajador']) && $_SESSION['caja_rendida_basicos']['idTrabajador']!=''){    $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idTrabajador']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['Valor']) && $_SESSION['caja_rendida_basicos']['Valor']!=''){                  $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['idSolicitado']) && $_SESSION['caja_rendida_basicos']['idSolicitado']!=''){    $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idSolicitado']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['idRevisado']) && $_SESSION['caja_rendida_basicos']['idRevisado']!=''){        $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idRevisado']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['caja_rendida_basicos']['idAprobado']) && $_SESSION['caja_rendida_basicos']['idAprobado']!=''){        $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idAprobado']."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCajaChica,idSistema,
				idUsuario,idTipo,idEstado,fecha_auto,Creacion_fecha,Creacion_Semana,
				Creacion_mes,Creacion_ano,Observaciones,idTrabajador,Valor,
				idSolicitado, idRevisado, idAprobado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if (isset($_SESSION['caja_rendida_documentos'])){
						foreach ($_SESSION['caja_rendida_documentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                             $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
							if(isset($_SESSION['caja_rendida_basicos']['idCajaChica']) && $_SESSION['caja_rendida_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rendida_basicos']['idSistema']) && $_SESSION['caja_rendida_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rendida_basicos']['idUsuario']) && $_SESSION['caja_rendida_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							$SIS_data .= ",'2'";
							if(isset($_SESSION['caja_rendida_basicos']['fecha_auto']) && $_SESSION['caja_rendida_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) && $_SESSION['caja_rendida_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idDocPago']) && $producto['idDocPago']!=''){                                           $SIS_data .= ",'".$producto['idDocPago']."'";                       }else{$SIS_data .= ",''";}
							if(isset($producto['N_Doc']) && $producto['N_Doc']!=''){                                                   $SIS_data .= ",'".$producto['N_Doc']."'";                           }else{$SIS_data .= ",''";}
							if(isset($_SESSION['caja_rendida_basicos']['Valor']) && $_SESSION['caja_rendida_basicos']['Valor']!=''){   $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Valor']."'";   }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idCajaChica,
							idSistema, idUsuario, idTipo, fecha_auto, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocPago, N_Doc, Valor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) && $_SESSION['caja_rendida_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Consulto el saldo para poder sumarlo
					$rowResultado = db_select_data (false, 'MontoActual', 'caja_chica_listado', '', 'idCajaChica ='.$_SESSION['caja_rendida_basicos']['idCajaChica'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Actualizo el monto
					$nuevoMonto = $rowResultado['MontoActual'] - $_SESSION['caja_rendida_basicos']['Valor'];
					$SIS_data = "MontoActual='".$nuevoMonto."'";

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'caja_chica_listado', 'idCajaChica = "'.$_SESSION['caja_rendida_basicos']['idCajaChica'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//////////////////////////////////////////////////////////////////////////
					//Rendicion
					//Se guardan los datos basicos
					if(isset($_SESSION['caja_rendida_basicos']['idCajaChica']) && $_SESSION['caja_rendida_basicos']['idCajaChica']!=''){ $SIS_data  = "'".$_SESSION['caja_rendida_basicos']['idCajaChica']."'";    }else{$SIS_data  = "''";}
					if(isset($_SESSION['caja_rendida_basicos']['idSistema']) && $_SESSION['caja_rendida_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['idUsuario']) && $_SESSION['caja_rendida_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['idTipo']) && $_SESSION['caja_rendida_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['idEstado']) && $_SESSION['caja_rendida_basicos']['idEstado']!=''){       $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idEstado']."'";      }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['fecha_auto']) && $_SESSION['caja_rendida_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) && $_SESSION['caja_rendida_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Creacion_fecha']."'";
						$SIS_data .= ",'".fecha2NSemana($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
						$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
						$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
					}else{
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
					}
					if(isset($_SESSION['caja_rendida_basicos']['Observaciones']) && $_SESSION['caja_rendida_basicos']['Observaciones']!=''){  $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Observaciones']."'";   }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['Valor']) && $_SESSION['caja_rendida_basicos']['Valor']!=''){                  $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Valor']."'";           }else{$SIS_data .= ",''";}
					if(isset($doc_ini) && $doc_ini!=''){                                                                                      $SIS_data .= ",'".$doc_ini."'";                                             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['idSolicitado']) && $_SESSION['caja_rendida_basicos']['idSolicitado']!=''){    $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idSolicitado']."'";    }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['idRevisado']) && $_SESSION['caja_rendida_basicos']['idRevisado']!=''){        $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idRevisado']."'";      }else{$SIS_data .= ",''";}
					if(isset($_SESSION['caja_rendida_basicos']['idAprobado']) && $_SESSION['caja_rendida_basicos']['idAprobado']!=''){        $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idAprobado']."'";      }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idCajaChica,idSistema,
					idUsuario,idTipo,idEstado,fecha_auto,Creacion_fecha,Creacion_Semana,
					Creacion_mes,Creacion_ano,Observaciones,Valor, idFacturacionRelacionada,
					idSolicitado, idRevisado, idAprobado';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						/*********************************************************************/
						//Se guardan los datos de los trabajadores
						if (isset($_SESSION['caja_rendida_items'])){
							foreach ($_SESSION['caja_rendida_items'] as $key => $producto){

								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                             $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
								if(isset($_SESSION['caja_rendida_basicos']['idCajaChica']) && $_SESSION['caja_rendida_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['idSistema']) && $_SESSION['caja_rendida_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['idUsuario']) && $_SESSION['caja_rendida_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['idTipo']) && $_SESSION['caja_rendida_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['fecha_auto']) && $_SESSION['caja_rendida_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) && $_SESSION['caja_rendida_basicos']['Creacion_fecha']!=''){
									$SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Creacion_fecha']."'";
									$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
									$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								if(isset($producto['Item']) && $producto['Item']!=''){    $SIS_data .= ",'".$producto['Item']."'";   }else{$SIS_data .= ",''";}
								if(isset($producto['Valor']) && $producto['Valor']!=''){  $SIS_data .= ",'".$producto['Valor']."'";  }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idFacturacion, idCajaChica, idSistema, idUsuario, idTipo, fecha_auto,
								Creacion_fecha, Creacion_mes, Creacion_ano, Item, Valor';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_rendiciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}

						/*********************************************************************/
						//Archivos
						if(isset($_SESSION['caja_rendida_archivos'])){
							foreach ($_SESSION['caja_rendida_archivos'] as $key => $producto){

								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                             $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
								if(isset($_SESSION['caja_rendida_basicos']['idCajaChica']) && $_SESSION['caja_rendida_basicos']['idCajaChica']!=''){ $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idCajaChica']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['idSistema']) && $_SESSION['caja_rendida_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['idUsuario']) && $_SESSION['caja_rendida_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
								if(isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) && $_SESSION['caja_rendida_basicos']['Creacion_fecha']!=''){
									$SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Creacion_fecha']."'";
									$SIS_data .= ",'".fecha2NMes($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
									$SIS_data .= ",'".fecha2Ano($_SESSION['caja_rendida_basicos']['Creacion_fecha'])."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idFacturacion, idCajaChica, idSistema, idUsuario, Creacion_fecha,
								Creacion_mes, Creacion_ano, Nombre';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
						if(isset($_SESSION['caja_rendida_basicos']['Creacion_fecha']) && $_SESSION['caja_rendida_basicos']['Creacion_fecha']!=''){
							$SIS_data .= ",'".$_SESSION['caja_rendida_basicos']['Creacion_fecha']."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'Creacion del documento'";                               //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'caja_chica_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Borro todas las sesiones una vez grabados los datos
						unset($_SESSION['caja_rendida_basicos']);
						unset($_SESSION['caja_rendida_documentos']);
						unset($_SESSION['caja_rendida_temporal']);
						unset($_SESSION['caja_rendida_archivos']);

						header( 'Location: '.$location.'&created=true' );
						die;
					}

				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
