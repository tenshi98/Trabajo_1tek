<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-283).');
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
	if (!empty($_POST['Fecha_desde']))       $Fecha_desde        = $_POST['Fecha_desde'];
	if (!empty($_POST['Fecha_hasta']))       $Fecha_hasta        = $_POST['Fecha_hasta'];
	if (!empty($_POST['Observaciones']))     $Observaciones      = $_POST['Observaciones'];

	if (!empty($_POST['idTrabajador']))      $idTrabajador       = $_POST['idTrabajador'];
	if (!empty($_POST['horas_dia_1']))       $horas_dia_1        = $_POST['horas_dia_1'];
	if (!empty($_POST['horas_dia_2']))       $horas_dia_2        = $_POST['horas_dia_2'];
	if (!empty($_POST['horas_dia_3']))       $horas_dia_3        = $_POST['horas_dia_3'];
	if (!empty($_POST['horas_dia_4']))       $horas_dia_4        = $_POST['horas_dia_4'];
	if (!empty($_POST['horas_dia_5']))       $horas_dia_5        = $_POST['horas_dia_5'];
	if (!empty($_POST['horas_dia_6']))       $horas_dia_6        = $_POST['horas_dia_6'];
	if (!empty($_POST['horas_dia_7']))       $horas_dia_7        = $_POST['horas_dia_7'];
	if (!empty($_POST['porcentaje_dia_1']))  $porcentaje_dia_1   = $_POST['porcentaje_dia_1'];
	if (!empty($_POST['porcentaje_dia_2']))  $porcentaje_dia_2   = $_POST['porcentaje_dia_2'];
	if (!empty($_POST['porcentaje_dia_3']))  $porcentaje_dia_3   = $_POST['porcentaje_dia_3'];
	if (!empty($_POST['porcentaje_dia_4']))  $porcentaje_dia_4   = $_POST['porcentaje_dia_4'];
	if (!empty($_POST['porcentaje_dia_5']))  $porcentaje_dia_5   = $_POST['porcentaje_dia_5'];
	if (!empty($_POST['porcentaje_dia_6']))  $porcentaje_dia_6   = $_POST['porcentaje_dia_6'];
	if (!empty($_POST['porcentaje_dia_7']))  $porcentaje_dia_7   = $_POST['porcentaje_dia_7'];
	if (!empty($_POST['idTurnos']))          $idTurnos           = $_POST['idTurnos'];
	if (!empty($_POST['nSem']))              $nSem               = $_POST['nSem'];
	if (!empty($_POST['fecha_dia_1']))       $fecha_dia_1        = $_POST['fecha_dia_1'];
	if (!empty($_POST['fecha_dia_2']))       $fecha_dia_2        = $_POST['fecha_dia_2'];
	if (!empty($_POST['fecha_dia_3']))       $fecha_dia_3        = $_POST['fecha_dia_3'];
	if (!empty($_POST['fecha_dia_4']))       $fecha_dia_4        = $_POST['fecha_dia_4'];
	if (!empty($_POST['fecha_dia_5']))       $fecha_dia_5        = $_POST['fecha_dia_5'];
	if (!empty($_POST['fecha_dia_6']))       $fecha_dia_6        = $_POST['fecha_dia_6'];
	if (!empty($_POST['fecha_dia_7']))       $fecha_dia_7        = $_POST['fecha_dia_7'];

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
			case 'Fecha_desde':     if(empty($Fecha_desde)){      $error['Fecha_desde']      = 'error/No ha ingresado la fecha desde';}break;
			case 'Fecha_hasta':     if(empty($Fecha_hasta)){      $error['Fecha_hasta']      = 'error/No ha ingresado la fecha hasta';}break;
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
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Fecha_desde)&&isset($Fecha_hasta)&&$Fecha_desde>$Fecha_hasta){ $error['Fono']    = 'error/La fecha Periodo Inicio debe ser inferior a la fecha de Periodo Termino';}

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
				unset($_SESSION['horas_extras_ing_basicos']);
				unset($_SESSION['horas_extras_ing_horas']);
				unset($_SESSION['horas_extras_ing_temporal']);
				unset($_SESSION['horas_extras_table']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['horas_extras_ing_archivos'])){
					foreach ($_SESSION['horas_extras_ing_archivos'] as $key => $producto){
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
				unset($_SESSION['horas_extras_ing_archivos']);
				//variable temporal de las horas extras mensuales
				unset($_SESSION['horas_extras_mens_ing_horas']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']   = $Creacion_fecha; }else{$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Fecha_desde)&&$Fecha_desde!=''){        $_SESSION['horas_extras_ing_basicos']['Fecha_desde']      = $Fecha_desde;    }else{$_SESSION['horas_extras_ing_basicos']['Fecha_desde']     = '';}
				if(isset($Fecha_hasta)&&$Fecha_hasta!=''){        $_SESSION['horas_extras_ing_basicos']['Fecha_hasta']      = $Fecha_hasta;    }else{$_SESSION['horas_extras_ing_basicos']['Fecha_hasta']     = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['horas_extras_ing_basicos']['idSistema']        = $idSistema;      }else{$_SESSION['horas_extras_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['horas_extras_ing_basicos']['idUsuario']        = $idUsuario;      }else{$_SESSION['horas_extras_ing_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['horas_extras_ing_basicos']['fecha_auto']       = $fecha_auto;     }else{$_SESSION['horas_extras_ing_basicos']['fecha_auto']      = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['horas_extras_ing_basicos']['Observaciones']    = $Observaciones;  }else{$_SESSION['horas_extras_ing_basicos']['Observaciones']   = '';}

				/****************************/
				//Porcentaje
				$arrPorcentajes = db_select_array (false, 'idPorcentaje, Porcentaje', 'core_horas_extras_porcentajes', '', '', 'idPorcentaje ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************/
				foreach ($arrPorcentajes as $prod) {
					$_SESSION['horas_extras_table'][$prod['idPorcentaje']]['idPorcentaje']   = $prod['idPorcentaje'];
					$_SESSION['horas_extras_table'][$prod['idPorcentaje']]['Nombre']         = $prod['Porcentaje'];
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
			unset($_SESSION['horas_extras_ing_basicos']);
			unset($_SESSION['horas_extras_ing_horas']);
			unset($_SESSION['horas_extras_ing_temporal']);
			unset($_SESSION['horas_extras_table']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['horas_extras_ing_archivos'])){
				foreach ($_SESSION['horas_extras_ing_archivos'] as $key => $producto){
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
			unset($_SESSION['horas_extras_ing_archivos']);
			//variable temporal de las horas extras mensuales
			unset($_SESSION['horas_extras_mens_ing_horas']);

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
				unset($_SESSION['horas_extras_ing_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['horas_extras_ing_horas']);
				unset($_SESSION['horas_extras_table']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']   = $Creacion_fecha; }else{$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Fecha_desde)&&$Fecha_desde!=''){        $_SESSION['horas_extras_ing_basicos']['Fecha_desde']      = $Fecha_desde;    }else{$_SESSION['horas_extras_ing_basicos']['Fecha_desde']     = '';}
				if(isset($Fecha_hasta)&&$Fecha_hasta!=''){        $_SESSION['horas_extras_ing_basicos']['Fecha_hasta']      = $Fecha_hasta;    }else{$_SESSION['horas_extras_ing_basicos']['Fecha_hasta']     = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['horas_extras_ing_basicos']['idSistema']        = $idSistema;      }else{$_SESSION['horas_extras_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['horas_extras_ing_basicos']['idUsuario']        = $idUsuario;      }else{$_SESSION['horas_extras_ing_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['horas_extras_ing_basicos']['fecha_auto']       = $fecha_auto;     }else{$_SESSION['horas_extras_ing_basicos']['fecha_auto']      = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['horas_extras_ing_basicos']['Observaciones']    = $Observaciones;  }else{$_SESSION['horas_extras_ing_basicos']['Observaciones']   = '';}

				/****************************/
				//Porcentaje
				$arrPorcentajes = db_select_array (false, 'idPorcentaje, Porcentaje', 'core_horas_extras_porcentajes', '', '', 'idPorcentaje ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************/
				foreach ($arrPorcentajes as $prod) {
					$_SESSION['horas_extras_table'][$prod['idPorcentaje']]['idPorcentaje']   = $prod['idPorcentaje'];
					$_SESSION['horas_extras_table'][$prod['idPorcentaje']]['Nombre']         = $prod['Porcentaje'];
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_horas_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//Lunes
			if(isset($fecha_dia_1)&&isset($horas_dia_1)){
				$ndata_1 = db_select_nrows (false, 'idHoras', 'trabajadores_horas_extras_facturacion_horas', '', "Fecha='".$fecha_dia_1."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_1 > 0) {$error['ndata_1'] = 'error/La hora ya fue ingresada previamente';}
			}
			//Martes
			if(isset($fecha_dia_2)&&isset($horas_dia_2)){
				$ndata_2 = db_select_nrows (false, 'idHoras', 'trabajadores_horas_extras_facturacion_horas', '', "Fecha='".$fecha_dia_2."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_2 > 0) {$error['ndata_2'] = 'error/La hora ya fue ingresada previamente';}
			}
			//Miercoles
			if(isset($fecha_dia_3)&&isset($horas_dia_3)){
				$ndata_3 = db_select_nrows (false, 'idHoras', 'trabajadores_horas_extras_facturacion_horas', '', "Fecha='".$fecha_dia_3."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_3 > 0) {$error['ndata_3'] = 'error/La hora ya fue ingresada previamente';}
			}
			//Jueves
			if(isset($fecha_dia_4)&&isset($horas_dia_4)){
				$ndata_4 = db_select_nrows (false, 'idHoras', 'trabajadores_horas_extras_facturacion_horas', '', "Fecha='".$fecha_dia_4."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_4 > 0) {$error['ndata_4'] = 'error/La hora ya fue ingresada previamente';}
			}
			//Viernes
			if(isset($fecha_dia_5)&&isset($horas_dia_5)){
				$ndata_5 = db_select_nrows (false, 'idHoras', 'trabajadores_horas_extras_facturacion_horas', '', "Fecha='".$fecha_dia_5."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_5 > 0) {$error['ndata_5'] = 'error/La hora ya fue ingresada previamente';}
			}
			//Sabado
			if(isset($fecha_dia_6)&&isset($horas_dia_6)){
				$ndata_6 = db_select_nrows (false, 'idHoras', 'trabajadores_horas_extras_facturacion_horas', '', "Fecha='".$fecha_dia_6."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_6 > 0) {$error['ndata_6'] = 'error/La hora ya fue ingresada previamente';}
			}
			//Domingo
			if(isset($fecha_dia_7)&&isset($horas_dia_7)){
				$ndata_7 = db_select_nrows (false, 'idHoras', 'trabajadores_horas_extras_facturacion_horas', '', "Fecha='".$fecha_dia_7."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_7 > 0) {$error['ndata_7'] = 'error/La hora ya fue ingresada previamente';}
			}
			/*******************************************************************/

			/****************************/
			//Trabajador
			if(isset($idTrabajador)&&$idTrabajador!=''){
				$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Rut', 'trabajadores_listado', '', 'idTrabajador='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}else{
				$error['idTrabajador'] = 'error/No ha seleccionado trabajador';
			}
			/****************************/
			//Turno
			if(isset($idTurnos)&&$idTurnos!=''){
				$rowTurno = db_select_data (false, 'Nombre', 'core_horas_extras_turnos', '', 'idTurnos='.$idTurnos, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}else{
				$error['idTurnos'] = 'error/No ha seleccionado un turno';
			}
			/****************************/
			//Porcentaje
			$arrPorcentajes = array();
			$arrPorcentajes = db_select_array (false, 'idPorcentaje, Porcentaje', 'core_horas_extras_porcentajes', '', '', 'idPorcentaje ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*****************/
			$arrPorcentaje = array();
			foreach ($arrPorcentajes as $prod) {
				$arrPorcentaje[$prod['idPorcentaje']]['Nombre']   = $prod['Porcentaje'];
			}

			/************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['nSem']              = $nSem;
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['idTrabajador']      = $idTrabajador;
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['TrabajadorNombre']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['TrabajadorRut']     = $rowTrabajador['Rut'];
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['idTurnos']          = $idTurnos;
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['Turno']             = $rowTurno['Nombre'];

				//Lunes
				if(isset($fecha_dia_1)&&isset($horas_dia_1)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['fecha_dia']       = $fecha_dia_1;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['horas_dia']       = $horas_dia_1;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['porcentaje_dia']  = $porcentaje_dia_1;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_1]['Nombre'];
				}
				//Martes
				if(isset($fecha_dia_2)&&isset($horas_dia_2)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['fecha_dia']       = $fecha_dia_2;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['horas_dia']       = $horas_dia_2;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['porcentaje_dia']  = $porcentaje_dia_2;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_2]['Nombre'];
				}
				//Miercoles
				if(isset($fecha_dia_3)&&isset($horas_dia_3)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['fecha_dia']       = $fecha_dia_3;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['horas_dia']       = $horas_dia_3;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['porcentaje_dia']  = $porcentaje_dia_3;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_3]['Nombre'];
				}
				//Jueves
				if(isset($fecha_dia_4)&&isset($horas_dia_4)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['fecha_dia']       = $fecha_dia_4;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['horas_dia']       = $horas_dia_4;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['porcentaje_dia']  = $porcentaje_dia_4;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_4]['Nombre'];
				}
				//Viernes
				if(isset($fecha_dia_5)&&isset($horas_dia_5)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['fecha_dia']       = $fecha_dia_5;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['horas_dia']       = $horas_dia_5;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['porcentaje_dia']  = $porcentaje_dia_5;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_5]['Nombre'];
				}
				//Sabado
				if(isset($fecha_dia_6)&&isset($horas_dia_6)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['fecha_dia']       = $fecha_dia_6;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['horas_dia']       = $horas_dia_6;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['porcentaje_dia']  = $porcentaje_dia_6;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_6]['Nombre'];
				}
				//Domingo
				if(isset($fecha_dia_7)&&isset($horas_dia_7)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['fecha_dia']       = $fecha_dia_7;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['horas_dia']       = $horas_dia_7;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['porcentaje_dia']  = $porcentaje_dia_7;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_7]['Nombre'];
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_horas_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/****************************/
			//Trabajador
			if(isset($idTrabajador)&&$idTrabajador!=''){
				$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Rut', 'trabajadores_listado', '', 'idTrabajador='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}else{
				$error['idTrabajador'] = 'error/No ha seleccionado trabajador';
			}
			/****************************/
			//Turno
			if(isset($idTurnos)&&$idTurnos!=''){
				$rowTurno = db_select_data (false, 'Nombre', 'core_horas_extras_turnos', '', 'idTurnos='.$idTurnos, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}else{
				$error['idTurnos'] = 'error/No ha seleccionado un turno';
			}
			/****************************/
			//Porcentaje
			$arrPorcentajes = array();
			$arrPorcentajes = db_select_array (false, 'idPorcentaje, Porcentaje', 'core_horas_extras_porcentajes', '', '', 'idPorcentaje ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*****************/
			$arrPorcentaje = array();
			foreach ($arrPorcentajes as $prod) {
				$arrPorcentaje[$prod['idPorcentaje']]['Nombre']   = $prod['Porcentaje'];
			}

			/************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['nSem']              = $nSem;
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['idTrabajador']      = $idTrabajador;
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['TrabajadorNombre']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['TrabajadorRut']     = $rowTrabajador['Rut'];
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['idTurnos']          = $idTurnos;
				$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem]['Turno']             = $rowTurno['Nombre'];

				//Lunes
				if(isset($fecha_dia_1)&&isset($horas_dia_1)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['fecha_dia']       = $fecha_dia_1;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['horas_dia']       = $horas_dia_1;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['porcentaje_dia']  = $porcentaje_dia_1;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_1]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_1]['Nombre'];
				}
				//Martes
				if(isset($fecha_dia_2)&&isset($horas_dia_2)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['fecha_dia']       = $fecha_dia_2;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['horas_dia']       = $horas_dia_2;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['porcentaje_dia']  = $porcentaje_dia_2;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_2]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_2]['Nombre'];
				}
				//Miercoles
				if(isset($fecha_dia_3)&&isset($horas_dia_3)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['fecha_dia']       = $fecha_dia_3;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['horas_dia']       = $horas_dia_3;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['porcentaje_dia']  = $porcentaje_dia_3;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_3]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_3]['Nombre'];
				}
				//Jueves
				if(isset($fecha_dia_4)&&isset($horas_dia_4)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['fecha_dia']       = $fecha_dia_4;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['horas_dia']       = $horas_dia_4;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['porcentaje_dia']  = $porcentaje_dia_4;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_4]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_4]['Nombre'];
				}
				//Viernes
				if(isset($fecha_dia_5)&&isset($horas_dia_5)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['fecha_dia']       = $fecha_dia_5;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['horas_dia']       = $horas_dia_5;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['porcentaje_dia']  = $porcentaje_dia_5;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_5]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_5]['Nombre'];
				}
				//Sabado
				if(isset($fecha_dia_6)&&isset($horas_dia_6)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['fecha_dia']       = $fecha_dia_6;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['horas_dia']       = $horas_dia_6;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['porcentaje_dia']  = $porcentaje_dia_6;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_6]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_6]['Nombre'];
				}
				//Domingo
				if(isset($fecha_dia_7)&&isset($horas_dia_7)){
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['fecha_dia']       = $fecha_dia_7;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['horas_dia']       = $horas_dia_7;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['porcentaje_dia']  = $porcentaje_dia_7;
					$_SESSION['horas_extras_ing_horas'][$idTrabajador][$nSem][$fecha_dia_7]['porcentaje']      = $arrPorcentaje[$porcentaje_dia_7]['Nombre'];
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_horas_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['horas_extras_ing_horas'][$_GET['idTrabajador']][$_GET['nSem']]);

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
			if(isset($_SESSION['horas_extras_ing_archivos'])){
				foreach ($_SESSION['horas_extras_ing_archivos'] as $key => $trabajos){
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
						$sufijo = 'hhee_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['horas_extras_ing_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['horas_extras_ing_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['horas_extras_ing_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['horas_extras_ing_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['horas_extras_ing_archivos'][$_GET['del_file']]);
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
			if (isset($_SESSION['horas_extras_ing_basicos'])){
				if(!isset($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']) OR $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la fecha de creación';}
				if(!isset($_SESSION['horas_extras_ing_basicos']['Fecha_desde']) OR $_SESSION['horas_extras_ing_basicos']['Fecha_desde']=='' ){       $error['Fecha_desde']      = 'error/No ha seleccionado la fecha de inicio';}
				if(!isset($_SESSION['horas_extras_ing_basicos']['Fecha_hasta']) OR $_SESSION['horas_extras_ing_basicos']['Fecha_hasta']=='' ){       $error['Fecha_hasta']      = 'error/No ha seleccionado la fecha de termino';}
				if(!isset($_SESSION['horas_extras_ing_basicos']['idSistema']) OR $_SESSION['horas_extras_ing_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['horas_extras_ing_basicos']['idUsuario']) OR $_SESSION['horas_extras_ing_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['horas_extras_ing_basicos']['fecha_auto']) OR $_SESSION['horas_extras_ing_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['horas_extras_ing_basicos']['Observaciones']) OR $_SESSION['horas_extras_ing_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a las horas extras';
			}
			//productos o guias
			if (!isset($_SESSION['horas_extras_ing_horas'])){
				$error['idProducto']   = 'error/No se han asignado horas extras';
			}
			//Se verifican productos
			if (isset($_SESSION['horas_extras_ing_horas'])){
				foreach ($_SESSION['horas_extras_ing_horas'] as $key => $producto){
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

				/******************************************************************************************/
				/******************************************************************************************/
				//Se guardan los datos basicos
				if(isset($_SESSION['horas_extras_ing_basicos']['idSistema']) && $_SESSION['horas_extras_ing_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['horas_extras_ing_basicos']['idSistema']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['horas_extras_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['horas_extras_ing_basicos']['Fecha_desde']) && $_SESSION['horas_extras_ing_basicos']['Fecha_desde']!=''){        $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Fecha_desde']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_ing_basicos']['Fecha_hasta']) && $_SESSION['horas_extras_ing_basicos']['Fecha_hasta']!=''){        $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Fecha_hasta']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['horas_extras_ing_basicos']['Observaciones']) && $_SESSION['horas_extras_ing_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, Fecha_desde, Fecha_hasta, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					if (isset($_SESSION['horas_extras_ing_horas'])){

						$nSemanas      = ceil ((dias_transcurridos($_SESSION['horas_extras_ing_basicos']['Fecha_desde'],$_SESSION['horas_extras_ing_basicos']['Fecha_hasta']))/7);
						$DiaActual     = $_SESSION['horas_extras_ing_basicos']['Fecha_desde'];
						$nDias         = dias_transcurridos($_SESSION['horas_extras_ing_basicos']['Fecha_desde'],$_SESSION['horas_extras_ing_basicos']['Fecha_hasta']);
						$Dia           = 1;
						$DiaActual_ex  = $_SESSION['horas_extras_ing_basicos']['Fecha_desde'];
						$Dia_ex        = 1;
						$TotalHoras    = array();

						//Recorro las semanas seleccionadas
						for($xsi1=1;$xsi1<=$nSemanas;$xsi1++){
							//el numero de semana actual
							if($xsi1==1){
								$nSem = fecha2NSemana($_SESSION['horas_extras_ing_basicos']['Fecha_desde']);
							}elseif($xsi1!=1){
								$nSem = fecha2NSemana($DiaActual_ex);
							}

							//imprimo la primera celda y el numero de semana actual
							foreach ($_SESSION['horas_extras_ing_horas'] as $key => $producto){

								if(isset($producto[$nSem]['nSem'])){
									//Recorro los dias de la semana
									for($i=1;$i<=7;$i++){

										//Inserto en la tabla de horas
										if($i==fecha2NDiaSemana($DiaActual_ex)&&$Dia_ex<=($nDias+1)){
											//verifica si existe el dia
											if(isset($producto[$nSem][$DiaActual_ex]['horas_dia'])){

												if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
												if(isset($_SESSION['horas_extras_ing_basicos']['idSistema']) && $_SESSION['horas_extras_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
												if(isset($_SESSION['horas_extras_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
												if(isset($_SESSION['horas_extras_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
												if(isset($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']!=''){
													$SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']."'";
													$SIS_data .= ",'".fecha2NSemana($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
													$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
													$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
												}else{
													$SIS_data .= ",''";
													$SIS_data .= ",''";
													$SIS_data .= ",''";
													$SIS_data .= ",''";
												}
												$SIS_data .= ",'".$producto[$nSem]['idTrabajador']."'";
												$SIS_data .= ",'".$nSem."'";
												$SIS_data .= ",'".$DiaActual_ex."'";
												$SIS_data .= ",'".$producto[$nSem][$DiaActual_ex]['horas_dia']."'";
												$SIS_data .= ",'".$producto[$nSem][$DiaActual_ex]['porcentaje_dia']."'";
												$SIS_data .= ",'1'";

												// inserto los datos de registro en la db
												$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTrabajador,
												nSem, Fecha, N_Horas, idPorcentaje, idUso';
												$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_facturacion_horas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

											}

											$DiaActual_ex = sumarDias($DiaActual_ex,1);
											$Dia_ex++;
										}
									}

									//Inserto los turnos en la tabla de turnos
									if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
									if(isset($_SESSION['horas_extras_ing_basicos']['idSistema']) && $_SESSION['horas_extras_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['horas_extras_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['horas_extras_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
									if(isset($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']!=''){
										$SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']."'";
										$SIS_data .= ",'".fecha2NSemana($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
										$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
										$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									$SIS_data .= ",'".$producto[$nSem]['idTrabajador']."'";
									$SIS_data .= ",'".$nSem."'";
									$SIS_data .= ",'".$producto[$nSem]['idTurnos']."'";
									$SIS_data .= ",'1'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTrabajador,
									nSem, idTurnos, idUso';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_facturacion_turnos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}
						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['horas_extras_ing_archivos'])){
						foreach ($_SESSION['horas_extras_ing_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                    $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
							if(isset($_SESSION['horas_extras_ing_basicos']['idSistema']) && $_SESSION['horas_extras_ing_basicos']['idSistema']!=''){    $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['horas_extras_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_ing_basicos']['idUsuario']!=''){    $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['horas_extras_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_ing_basicos']['fecha_auto']!=''){  $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/******************************************************************************************/
					/******************************************************************************************/
					//Se hace ingreso en las horas extras por mes
					if(isset($_SESSION['horas_extras_ing_basicos']['idSistema']) && $_SESSION['horas_extras_ing_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['horas_extras_ing_basicos']['idSistema']."'";   }else{$SIS_data  = "''";}
					if(isset($_SESSION['horas_extras_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
					if(isset($_SESSION['horas_extras_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
					if(isset($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']."'";
						$SIS_data .= ",'".fecha2NSemana($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
						$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
						$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
						$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
						$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
					}else{
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
					}
					if(isset($_SESSION['horas_extras_ing_basicos']['Observaciones']) && $_SESSION['horas_extras_ing_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}

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

										if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
										if(isset($_SESSION['horas_extras_ing_basicos']['idSistema']) && $_SESSION['horas_extras_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
										if(isset($_SESSION['horas_extras_ing_basicos']['idUsuario']) && $_SESSION['horas_extras_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
										if(isset($_SESSION['horas_extras_ing_basicos']['fecha_auto']) && $_SESSION['horas_extras_ing_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
										if(isset($_SESSION['horas_extras_ing_basicos']['Creacion_fecha']) && $_SESSION['horas_extras_ing_basicos']['Creacion_fecha']!=''){
											$SIS_data .= ",'".$_SESSION['horas_extras_ing_basicos']['Creacion_fecha']."'";
											$SIS_data .= ",'".fecha2NSemana($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
											$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
											$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
											$SIS_data .= ",'".fecha2Ano($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
											$SIS_data .= ",'".fecha2NMes($_SESSION['horas_extras_ing_basicos']['Creacion_fecha'])."'";
										}else{
											$SIS_data .= ",''";
											$SIS_data .= ",''";
											$SIS_data .= ",''";
											$SIS_data .= ",''";
											$SIS_data .= ",''";
											$SIS_data .= ",''";
										}
										if(isset($prod['idTrabajador']) && $prod['idTrabajador']!=''){      $SIS_data .= ",'".$prod['idTrabajador']."'";    }else{$SIS_data .= ",''";}
										if(isset($prod['horas_dia']) && $prod['horas_dia']!=''){     $SIS_data .= ",'".$prod['horas_dia']."'";       }else{$SIS_data .= ",''";}
										if(isset($prod['porcentaje_dia']) && $prod['porcentaje_dia']!=''){  $SIS_data .= ",'".$prod['porcentaje_dia']."'";  }else{$SIS_data .= ",''";}
										$SIS_data .= ",'1'";

										// inserto los datos de registro en la db
										$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, Ano, idMes, idTrabajador,
										N_Horas, idPorcentaje, idUso';
										$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_horas_extras_mensuales_facturacion_horas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									}
								}
							}
						}

						/******************************************************************************************/
						/******************************************************************************************/
						/*********************************************************************/
						//Borro todas las sesiones una vez grabados los datos
						unset($_SESSION['horas_extras_ing_basicos']);
						unset($_SESSION['horas_extras_ing_horas']);
						unset($_SESSION['horas_extras_ing_temporal']);
						unset($_SESSION['horas_extras_ing_archivos']);
						//variable temporal de las horas extras mensuales
						unset($_SESSION['horas_extras_mens_ing_horas']);
						unset($_SESSION['horas_extras_table']);

						header( 'Location: '.$location.'&created=true' );
						die;
					}

				}

			}

		break;

/*******************************************************************************************************************/
	}

?>
