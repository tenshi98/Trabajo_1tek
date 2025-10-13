<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-284).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFacturacion']))     $idFacturacion      = $_POST['idFacturacion'];
	if (!empty($_POST['idSistema']))         $idSistema          = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))         $idUsuario          = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))        $fecha_auto         = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha']))    $Creacion_fecha     = $_POST['Creacion_fecha'];
	if (!empty($_POST['Ano']))               $Ano                = $_POST['Ano'];
	if (!empty($_POST['idMes']))             $idMes              = $_POST['idMes'];
	if (!empty($_POST['Observaciones']))     $Observaciones      = $_POST['Observaciones'];

	if (!empty($_POST['idTrabajador']))      $idTrabajador       = $_POST['idTrabajador'];
	if (!empty($_POST['horas_dia']))         $horas_dia          = $_POST['horas_dia'];
	if (!empty($_POST['porcentaje_dia']))    $porcentaje_dia     = $_POST['porcentaje_dia'];

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
			case 'fecha_auto':      if(empty($fecha_auto)){       $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}break;
			case 'Creacion_fecha':  if(empty($Creacion_fecha)){   $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}break;
			case 'Ano':             if(empty($Ano)){              $error['Ano']              = 'error/No ha seleccionado el año';}break;
			case 'idMes':           if(empty($idMes)){            $error['idMes']            = 'error/No ha seleccionado el mes';}break;
			case 'Observaciones':   if(empty($Observaciones)){    $error['Observaciones']    = 'error/No ha ingresado la observacion';}break;

			case 'idTrabajador':    if(empty($idTrabajador)){     $error['idTrabajador']     = 'error/No ha seleccionado el trabajador';}break;
			case 'idTurnos':        if(empty($idTurnos)){         $error['idTurnos']         = 'error/No ha seleccionado el turno';}break;

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
				unset($_SESSION['horas_extras_mens_ing_basicos']);
				unset($_SESSION['horas_extras_mens_ing_horas']);
				unset($_SESSION['horas_extras_mens_ing_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['horas_extras_mens_ing_archivos'])){
					foreach ($_SESSION['horas_extras_mens_ing_archivos'] as $key => $producto){
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
				unset($_SESSION['horas_extras_mens_ing_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Ano)&&$Ano!=''){                        $_SESSION['horas_extras_mens_ing_basicos']['Ano']              = $Ano;             }else{$_SESSION['horas_extras_mens_ing_basicos']['Ano']             = '';}
				if(isset($idMes)&&$idMes!=''){                    $_SESSION['horas_extras_mens_ing_basicos']['idMes']            = $idMes;           }else{$_SESSION['horas_extras_mens_ing_basicos']['idMes']           = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['horas_extras_mens_ing_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['horas_extras_mens_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['horas_extras_mens_ing_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['horas_extras_mens_ing_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']      = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['horas_extras_mens_ing_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['horas_extras_mens_ing_basicos']['Observaciones']   = '';}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['horas_extras_mens_ing_basicos']);
			unset($_SESSION['horas_extras_mens_ing_horas']);
			unset($_SESSION['horas_extras_mens_ing_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['horas_extras_mens_ing_archivos'])){
				foreach ($_SESSION['horas_extras_mens_ing_archivos'] as $key => $producto){
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
			unset($_SESSION['horas_extras_mens_ing_archivos']);

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
				unset($_SESSION['horas_extras_mens_ing_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['horas_extras_mens_ing_horas']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Ano)&&$Ano!=''){                        $_SESSION['horas_extras_mens_ing_basicos']['Ano']              = $Ano;             }else{$_SESSION['horas_extras_mens_ing_basicos']['Ano']             = '';}
				if(isset($idMes)&&$idMes!=''){                    $_SESSION['horas_extras_mens_ing_basicos']['idMes']            = $idMes;           }else{$_SESSION['horas_extras_mens_ing_basicos']['idMes']           = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['horas_extras_mens_ing_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['horas_extras_mens_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['horas_extras_mens_ing_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['horas_extras_mens_ing_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']      = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['horas_extras_mens_ing_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['horas_extras_mens_ing_basicos']['Observaciones']   = '';}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_horas_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idTrabajador)&&isset($porcentaje_dia)&&isset($idMes)&&isset($Ano)){
				$ndata_1 = db_select_nrows (false, 'idTrabajador', 'trabajadores_horas_extras_mensuales_facturacion_horas', '', "idTrabajador='".$idTrabajador."' AND idPorcentaje='".$porcentaje_dia."' AND idMes='".$idMes."' AND Ano='".$Ano."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/Las horas extras que esta tratando de ingresar ya fueron ingresadas previamente';}
			/*******************************************************************/
			//Trabajador
			if(isset($idTrabajador)&&$idTrabajador!=''){
				$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Rut', 'trabajadores_listado', '', 'idTrabajador='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}else{
				$error['idTrabajador'] = 'error/No ha seleccionado trabajador';
			}

			/************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************/
				//Porcentaje
				$rowPorcentaje = db_select_data (false, 'Porcentaje', 'core_horas_extras_porcentajes', '', 'idPorcentaje='.$porcentaje_dia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Horas trabajadores
				$_SESSION['horas_extras_mens_ing_horas'][$idTrabajador]['TrabajadorNombre']                   = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				$_SESSION['horas_extras_mens_ing_horas'][$idTrabajador]['TrabajadorRut']                      = $rowTrabajador['Rut'];
				$_SESSION['horas_extras_mens_ing_horas'][$idTrabajador]['idTrabajador']                       = $idTrabajador;
				$_SESSION['horas_extras_mens_ing_horas'][$idTrabajador][$porcentaje_dia]['idTrabajador']      = $idTrabajador;
				$_SESSION['horas_extras_mens_ing_horas'][$idTrabajador][$porcentaje_dia]['porcentaje_dia']    = $porcentaje_dia;
				$_SESSION['horas_extras_mens_ing_horas'][$idTrabajador][$porcentaje_dia]['horas_dia']         = $horas_dia;
				$_SESSION['horas_extras_mens_ing_horas'][$idTrabajador][$porcentaje_dia]['porcentaje_nombre'] = $rowPorcentaje['Porcentaje'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'del_horas_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['horas_extras_mens_ing_horas'][$_GET['idTrabajador']]);

			//redirijo
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
			if(isset($_SESSION['horas_extras_mens_ing_archivos'])){
				foreach ($_SESSION['horas_extras_mens_ing_archivos'] as $key => $trabajos){
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
						$sufijo = 'hhee_mens_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['horas_extras_mens_ing_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['horas_extras_mens_ing_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['horas_extras_mens_ing_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['horas_extras_mens_ing_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['horas_extras_mens_ing_archivos'][$_GET['del_file']]);
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
			if (isset($_SESSION['horas_extras_mens_ing_basicos'])){
				if(!isset($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']) OR $_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la fecha de creación';}
				if(!isset($_SESSION['horas_extras_mens_ing_basicos']['Ano']) OR $_SESSION['horas_extras_mens_ing_basicos']['Ano']=='' ){                       $error['Ano']              = 'error/No ha seleccionado el año de creación';}
				if(!isset($_SESSION['horas_extras_mens_ing_basicos']['idMes']) OR $_SESSION['horas_extras_mens_ing_basicos']['idMes']=='' ){                   $error['idMes']            = 'error/No ha seleccionado el mes de creación';}
				if(!isset($_SESSION['horas_extras_mens_ing_basicos']['idSistema']) OR $_SESSION['horas_extras_mens_ing_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['horas_extras_mens_ing_basicos']['idUsuario']) OR $_SESSION['horas_extras_mens_ing_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']) OR $_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['horas_extras_mens_ing_basicos']['Observaciones']) OR $_SESSION['horas_extras_mens_ing_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a las horas extras';
			}
			//Horas
			if (!isset($_SESSION['horas_extras_mens_ing_horas'])){
				$error['idProducto']   = 'error/No se han asignado horas extras';
			}
			//Se verifican productos
			if (isset($_SESSION['horas_extras_mens_ing_horas'])){
				foreach ($_SESSION['horas_extras_mens_ing_horas'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado horas extras';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['horas_extras_mens_ing_basicos']['idSistema']) && $_SESSION['horas_extras_mens_ing_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['horas_extras_mens_ing_basicos']['idSistema']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['horas_extras_mens_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_mens_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['horas_extras_mens_ing_basicos']['Ano']) && $_SESSION['horas_extras_mens_ing_basicos']['Ano']!=''){                        $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['Ano']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_mens_ing_basicos']['idMes']) && $_SESSION['horas_extras_mens_ing_basicos']['idMes']!=''){                    $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idMes']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_mens_ing_basicos']['Observaciones']) && $_SESSION['horas_extras_mens_ing_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, Ano, idMes, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_mensuales_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					if (isset($_SESSION['horas_extras_mens_ing_horas'])){

						foreach ($_SESSION['horas_extras_mens_ing_horas'] as $key => $producto){

							foreach ($producto as $prod) {
								//verifico la existencia de datos
								if(isset($prod['horas_dia']) && $prod['horas_dia']!=''){

									if(isset($ultimo_id) && $ultimo_id!=''){                                                                                               $SIS_data  = "'".$ultimo_id."'";                                                }else{$SIS_data  = "''";}
									if(isset($_SESSION['horas_extras_mens_ing_basicos']['idSistema']) && $_SESSION['horas_extras_mens_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['horas_extras_mens_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_mens_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
									if(isset($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']!=''){
										$SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']."'";
										$SIS_data .= ",'".fecha2NSemana($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
										$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
										$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									if(isset($_SESSION['horas_extras_mens_ing_basicos']['Ano']) && $_SESSION['horas_extras_mens_ing_basicos']['Ano']!=''){       $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['Ano']."'";     }else{$SIS_data .= ",''";}
									if(isset($_SESSION['horas_extras_mens_ing_basicos']['idMes']) && $_SESSION['horas_extras_mens_ing_basicos']['idMes']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idMes']."'";   }else{$SIS_data .= ",''";}
									if(isset($prod['idTrabajador']) && $prod['idTrabajador']!=''){                                                               $SIS_data .= ",'".$prod['idTrabajador']."'";                                 }else{$SIS_data .= ",''";}
									if(isset($prod['horas_dia']) && $prod['horas_dia']!=''){                                                                     $SIS_data .= ",'".$prod['horas_dia']."'";                                    }else{$SIS_data .= ",''";}
									if(isset($prod['porcentaje_dia']) && $prod['porcentaje_dia']!=''){                                                           $SIS_data .= ",'".$prod['porcentaje_dia']."'";                               }else{$SIS_data .= ",''";}
									$SIS_data .= ",'1'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, Ano, idMes, idTrabajador,
									N_Horas, idPorcentaje, idUso';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_mensuales_facturacion_horas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}
						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['horas_extras_mens_ing_archivos'])){
						foreach ($_SESSION['horas_extras_mens_ing_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                               $SIS_data  = "'".$ultimo_id."'";                                                }else{$SIS_data  = "''";}
							if(isset($_SESSION['horas_extras_mens_ing_basicos']['idSistema']) && $_SESSION['horas_extras_mens_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['horas_extras_mens_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_mens_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_mens_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['horas_extras_mens_ing_basicos']['Ano']) && $_SESSION['horas_extras_mens_ing_basicos']['Ano']!=''){      $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['Ano']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['horas_extras_mens_ing_basicos']['idMes']) && $_SESSION['horas_extras_mens_ing_basicos']['idMes']!=''){  $SIS_data .= ",'".$_SESSION['horas_extras_mens_ing_basicos']['idMes']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){                                                                  $SIS_data .= ",'".$producto['Nombre']."'";                                    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_mes, Creacion_ano, Ano, idMes, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_mensuales_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['horas_extras_mens_ing_basicos']);
					unset($_SESSION['horas_extras_mens_ing_horas']);
					unset($_SESSION['horas_extras_mens_ing_temporal']);
					unset($_SESSION['horas_extras_mens_ing_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
	}

?>
