<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-282).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFacturacion']))  $idFacturacion   = $_POST['idFacturacion'];
	if (!empty($_POST['idSistema']))      $idSistema       = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))      $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['idTipo']))         $idTipo          = $_POST['idTipo'];
	if (!empty($_POST['idTrabajador']))   $idTrabajador    = $_POST['idTrabajador'];
	if (!empty($_POST['fecha_auto']))     $fecha_auto      = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha'])) $Creacion_fecha  = $_POST['Creacion_fecha'];
	if (!empty($_POST['Observaciones']))  $Observaciones   = $_POST['Observaciones'];
	if (!empty($_POST['Monto']))          $Monto           = $_POST['Monto'];
	if (!empty($_POST['N_Cuotas']))       $N_Cuotas        = $_POST['N_Cuotas'];

	if (!empty($_POST['FechaCuota']))     $FechaCuota      = $_POST['FechaCuota'];
	if (!empty($_POST['MontoCuota']))     $MontoCuota      = $_POST['MontoCuota'];
	if (!empty($_POST['oldidProducto']))  $oldidProducto   = $_POST['oldidProducto'];

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
			case 'idFacturacion':   if(empty($idFacturacion)){    $error['idFacturacion']    = 'error/No ha ingresado el id';}break;
			case 'idSistema':       if(empty($idSistema)){        $error['idSistema']        = 'error/No ha ingresado el numero de documento';}break;
			case 'idUsuario':       if(empty($idUsuario)){        $error['idUsuario']        = 'error/No ha seleccionado el usuario';}break;
			case 'idTipo':          if(empty($idTipo)){           $error['idTipo']           = 'error/No ha seleccionado el tipo';}break;
			case 'idTrabajador':    if(empty($idTrabajador)){     $error['idTrabajador']     = 'error/No ha seleccionado el trabajador';}break;
			case 'fecha_auto':      if(empty($fecha_auto)){       $error['fecha_auto']       = 'error/No ha ingresado la fecha auto';}break;
			case 'Creacion_fecha':  if(empty($Creacion_fecha)){   $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}break;
			case 'Observaciones':   if(empty($Observaciones)){    $error['Observaciones']    = 'error/No ha ingresado la observacion';}break;
			case 'Monto':           if(empty($Monto)){            $error['Monto']            = 'error/No ha ingresado el monto';}break;
			case 'N_Cuotas':        if(empty($N_Cuotas)){         $error['N_Cuotas']         = 'error/No ha seleccionado el numero de cuotas';}break;

			case 'FechaCuota':      if(empty($FechaCuota)){       $error['FechaCuota']       = 'error/No ha ingresado la fecha de la cuota';}break;
			case 'MontoCuota':      if(empty($MontoCuota)){       $error['MontoCuota']       = 'error/No ha ingresado el monto de la cuota';}break;
			case 'oldidProducto':   if(empty($oldidProducto)){    $error['oldidProducto']    = 'error/No ha ingresado el id de la cuota';}break;

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
/*                                                        INGRESOS                                                 */
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
				unset($_SESSION['desc_cuotas_basicos']);
				unset($_SESSION['desc_cuotas_listado']);
				unset($_SESSION['desc_cuotas_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['desc_cuotas_archivos'])){
					foreach ($_SESSION['desc_cuotas_archivos'] as $key => $producto){
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
				unset($_SESSION['desc_cuotas_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['desc_cuotas_basicos']['idTrabajador']     = $idTrabajador;    }else{$_SESSION['desc_cuotas_basicos']['idTrabajador']    = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['desc_cuotas_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['desc_cuotas_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['desc_cuotas_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['desc_cuotas_basicos']['idTipo']          = '';}
				if(isset($Monto)&&$Monto!=''){                    $_SESSION['desc_cuotas_basicos']['Monto']            = $Monto;           }else{$_SESSION['desc_cuotas_basicos']['Monto']           = '';}
				if(isset($N_Cuotas)&&$N_Cuotas!=''){              $_SESSION['desc_cuotas_basicos']['N_Cuotas']         = $N_Cuotas;        }else{$_SESSION['desc_cuotas_basicos']['N_Cuotas']        = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['desc_cuotas_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['desc_cuotas_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['desc_cuotas_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['desc_cuotas_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['desc_cuotas_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['desc_cuotas_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['desc_cuotas_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['desc_cuotas_basicos']['fecha_auto']      = '';}

				/*******************************/
				//Calculo aproximado cuotas
				$monto_cuotas= ceil ($Monto/$N_Cuotas);
				$total_temporal = $Monto;
				//cuotas
				for ($i = 1; $i <= $N_Cuotas; $i++) {
					$_SESSION['desc_cuotas_listado'][$i]['fecha'] = '0000-00-00';
					$_SESSION['desc_cuotas_listado'][$i]['cuota'] = $i;
					//verifico el saldo
					if($monto_cuotas<$total_temporal){
						$_SESSION['desc_cuotas_listado'][$i]['monto'] = $monto_cuotas;
					}else{
						$_SESSION['desc_cuotas_listado'][$i]['monto'] = $total_temporal;
					}
					//calculo de saldo
					$total_temporal = $total_temporal - $monto_cuotas;
				}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'trabajadores_descuentos_cuotas_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['desc_cuotas_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['desc_cuotas_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = '.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['desc_cuotas_basicos']['Trabajador'] = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				}else{
					$_SESSION['desc_cuotas_basicos']['Trabajador'] = '';
				}
				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['desc_cuotas_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['desc_cuotas_basicos']['Usuario'] = '';
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
			unset($_SESSION['desc_cuotas_basicos']);
			unset($_SESSION['desc_cuotas_listado']);
			unset($_SESSION['desc_cuotas_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['desc_cuotas_archivos'])){
				foreach ($_SESSION['desc_cuotas_archivos'] as $key => $producto){
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
			unset($_SESSION['desc_cuotas_archivos']);

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
				unset($_SESSION['desc_cuotas_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['desc_cuotas_listado']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['desc_cuotas_basicos']['idTrabajador']     = $idTrabajador;    }else{$_SESSION['desc_cuotas_basicos']['idTrabajador']    = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['desc_cuotas_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['desc_cuotas_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['desc_cuotas_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['desc_cuotas_basicos']['idTipo']          = '';}
				if(isset($Monto)&&$Monto!=''){                    $_SESSION['desc_cuotas_basicos']['Monto']            = $Monto;           }else{$_SESSION['desc_cuotas_basicos']['Monto']           = '';}
				if(isset($N_Cuotas)&&$N_Cuotas!=''){              $_SESSION['desc_cuotas_basicos']['N_Cuotas']         = $N_Cuotas;        }else{$_SESSION['desc_cuotas_basicos']['N_Cuotas']        = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['desc_cuotas_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['desc_cuotas_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['desc_cuotas_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['desc_cuotas_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['desc_cuotas_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['desc_cuotas_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['desc_cuotas_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['desc_cuotas_basicos']['fecha_auto']      = '';}

				/*******************************/
				//Calculo aproximado cuotas
				$monto_cuotas   = ceil ($Monto/$N_Cuotas);
				$total_temporal = $Monto;
				//cuotas
				for ($i = 1; $i <= $N_Cuotas; $i++) {
					$_SESSION['desc_cuotas_listado'][$i]['fecha'] = '0000-00-00';
					$_SESSION['desc_cuotas_listado'][$i]['cuota'] = $i;
					//verifico el saldo
					if($monto_cuotas<$total_temporal){
						$_SESSION['desc_cuotas_listado'][$i]['monto'] = $monto_cuotas;
					}else{
						$_SESSION['desc_cuotas_listado'][$i]['monto'] = $total_temporal;
					}
					//calculo de saldo
					$total_temporal = $total_temporal - $monto_cuotas;
				}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'trabajadores_descuentos_cuotas_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['desc_cuotas_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['desc_cuotas_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = '.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['desc_cuotas_basicos']['Trabajador'] = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				}else{
					$_SESSION['desc_cuotas_basicos']['Trabajador'] = '';
				}
				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['desc_cuotas_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['desc_cuotas_basicos']['Usuario'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'edit_cuota_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//verifico que ninguna cuota se cobre en el mismo mes
			foreach ($_SESSION['desc_cuotas_listado'] as $key => $producto){
				if(isset($FechaCuota)&&isset($producto['fecha'])&&fecha2NMes($FechaCuota)==fecha2NMes($producto['fecha'])&&fecha2Ano($FechaCuota)==fecha2Ano($producto['fecha'])){
					$error['ndata_1'] = 'error/La fecha de cobro esta dentro del mismo mes y año de otra fecha de cobro';
				}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['desc_cuotas_listado'][$oldidProducto]['fecha'] = $FechaCuota;
				$_SESSION['desc_cuotas_listado'][$oldidProducto]['cuota'] = $oldidProducto;
				$_SESSION['desc_cuotas_listado'][$oldidProducto]['monto'] = $MontoCuota;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_file_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['desc_cuotas_archivos'])){
				foreach ($_SESSION['desc_cuotas_archivos'] as $key => $trabajos){
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
						$sufijo = 'descuentos_cuotas_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['desc_cuotas_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['desc_cuotas_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['desc_cuotas_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['desc_cuotas_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['desc_cuotas_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'ing_bodega':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['desc_cuotas_basicos'])){
				if(!isset($_SESSION['desc_cuotas_basicos']['idTrabajador']) OR $_SESSION['desc_cuotas_basicos']['idTrabajador']=='' ){     $error['idTrabajador']     = 'error/No ha seleccionado el trabajador';}
				if(!isset($_SESSION['desc_cuotas_basicos']['Creacion_fecha']) OR $_SESSION['desc_cuotas_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la fecha de creación';}
				if(!isset($_SESSION['desc_cuotas_basicos']['idTipo']) OR $_SESSION['desc_cuotas_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de boleta';}
				if(!isset($_SESSION['desc_cuotas_basicos']['Monto']) OR $_SESSION['desc_cuotas_basicos']['Monto']=='' ){                   $error['Monto']            = 'error/No ha ingresado el Monto total de las cuotas';}
				if(!isset($_SESSION['desc_cuotas_basicos']['N_Cuotas']) OR $_SESSION['desc_cuotas_basicos']['N_Cuotas']=='' ){             $error['N_Cuotas']         = 'error/No ha ingresado el numero total de cuotas';}
				if(!isset($_SESSION['desc_cuotas_basicos']['Observaciones']) OR $_SESSION['desc_cuotas_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['desc_cuotas_basicos']['idSistema']) OR $_SESSION['desc_cuotas_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['desc_cuotas_basicos']['idUsuario']) OR $_SESSION['desc_cuotas_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['desc_cuotas_basicos']['fecha_auto']) OR $_SESSION['desc_cuotas_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al descuento por cuotas';
			}
			//productos o guias
			if (!isset($_SESSION['desc_cuotas_listado'])){
				$error['idProducto']   = 'error/No se han asignado cuotas';
			}
			//Se verifican productos
			if (isset($_SESSION['desc_cuotas_listado'])){
				foreach ($_SESSION['desc_cuotas_listado'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado cuotas';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

			//Se guardan los datos basicos
				if(isset($_SESSION['desc_cuotas_basicos']['idSistema']) && $_SESSION['desc_cuotas_basicos']['idSistema']!=''){       $SIS_data  = "'".$_SESSION['desc_cuotas_basicos']['idSistema']."'";       }else{$SIS_data  = "''";}
				if(isset($_SESSION['desc_cuotas_basicos']['idUsuario']) && $_SESSION['desc_cuotas_basicos']['idUsuario']!=''){       $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idUsuario']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['desc_cuotas_basicos']['idTipo']) && $_SESSION['desc_cuotas_basicos']['idTipo']!=''){             $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['desc_cuotas_basicos']['idTrabajador']) && $_SESSION['desc_cuotas_basicos']['idTrabajador']!=''){ $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idTrabajador']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['desc_cuotas_basicos']['fecha_auto']) && $_SESSION['desc_cuotas_basicos']['fecha_auto']!=''){     $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['fecha_auto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['desc_cuotas_basicos']['Creacion_fecha']) && $_SESSION['desc_cuotas_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['desc_cuotas_basicos']['Observaciones']) && $_SESSION['desc_cuotas_basicos']['Observaciones']!=''){  $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['Observaciones']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['desc_cuotas_basicos']['Monto']) && $_SESSION['desc_cuotas_basicos']['Monto']!=''){                  $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['Monto']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['desc_cuotas_basicos']['N_Cuotas'])&&$_SESSION['desc_cuotas_basicos']['N_Cuotas']!=''){              $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['N_Cuotas']."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, idTipo, idTrabajador, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, Observaciones, Monto, N_Cuotas';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_descuentos_cuotas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los servicios
					if(isset($_SESSION['desc_cuotas_listado'])){
						foreach ($_SESSION['desc_cuotas_listado'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                              $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idSistema']) && $_SESSION['desc_cuotas_basicos']['idSistema']!=''){        $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idSistema']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idUsuario']) && $_SESSION['desc_cuotas_basicos']['idUsuario']!=''){        $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idUsuario']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idTipo']) && $_SESSION['desc_cuotas_basicos']['idTipo']!=''){              $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idTrabajador']) && $_SESSION['desc_cuotas_basicos']['idTrabajador']!=''){  $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idTrabajador']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['fecha_auto']) && $_SESSION['desc_cuotas_basicos']['fecha_auto']!=''){      $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['fecha_auto']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['Creacion_fecha']) && $_SESSION['desc_cuotas_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['fecha']) && $producto['fecha']!=''){                                                      $SIS_data .= ",'".$producto['fecha']."'";                            }else{$SIS_data .= ",''";}
							if(isset($producto['cuota']) && $producto['cuota']!=''){                                                      $SIS_data .= ",'".$producto['cuota']."'";                            }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['N_Cuotas']) && $_SESSION['desc_cuotas_basicos']['N_Cuotas']!=''){  $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['N_Cuotas']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['monto']) && $producto['monto']!=''){                                                      $SIS_data .= ",'".$producto['monto']."'";                            }else{$SIS_data .= ",''";}
							$SIS_data .= ",'1'";

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion,idSistema, idUsuario, idTipo, idTrabajador,
							fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano,Fecha, nCuota, TotalCuotas, monto_cuotas, idUso';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_descuentos_cuotas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['desc_cuotas_archivos'])){
						foreach ($_SESSION['desc_cuotas_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idSistema']) && $_SESSION['desc_cuotas_basicos']['idSistema']!=''){         $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idSistema']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idUsuario']) && $_SESSION['desc_cuotas_basicos']['idUsuario']!=''){         $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idUsuario']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idTipo']) && $_SESSION['desc_cuotas_basicos']['idTipo']!=''){               $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['idTrabajador']) && $_SESSION['desc_cuotas_basicos']['idTrabajador']!=''){   $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['idTrabajador']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['fecha_auto']) && $_SESSION['desc_cuotas_basicos']['fecha_auto']!=''){       $SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['fecha_auto']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['desc_cuotas_basicos']['Creacion_fecha']) && $_SESSION['desc_cuotas_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['desc_cuotas_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['desc_cuotas_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion,idSistema, idUsuario, idTipo, idTrabajador,
							fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano,Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_descuentos_cuotas_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['desc_cuotas_basicos']);
					unset($_SESSION['desc_cuotas_listado']);
					unset($_SESSION['desc_cuotas_temporal']);
					unset($_SESSION['desc_cuotas_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
	}

?>
