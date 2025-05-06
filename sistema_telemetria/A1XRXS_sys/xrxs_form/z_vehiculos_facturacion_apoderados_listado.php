<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-286).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFacturacion']))         $idFacturacion          = $_POST['idFacturacion'];
	if (!empty($_POST['idSistema']))             $idSistema              = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))             $idUsuario              = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))                 $Fecha                  = $_POST['Fecha'];
	if (!empty($_POST['Dia']))                   $Dia                    = $_POST['Dia'];
	if (!empty($_POST['idMes']))                 $idMes                  = $_POST['idMes'];
	if (!empty($_POST['Ano']))                   $Ano                    = $_POST['Ano'];
	if (!empty($_POST['Observaciones']))         $Observaciones          = $_POST['Observaciones'];
	if (!empty($_POST['fCreacion']))             $fCreacion              = $_POST['fCreacion'];
	if (!empty($_POST['idFacturacionDetalle']))  $idFacturacionDetalle   = $_POST['idFacturacionDetalle'];
	if (!empty($_POST['idCliente']))             $idCliente              = $_POST['idCliente'];
	if (!empty($_POST['SII_NDoc']))              $SII_NDoc               = $_POST['SII_NDoc'];
	if (!empty($_POST['Pagofecha']))             $Pagofecha              = $_POST['Pagofecha'];
	if (!empty($_POST['idTipoPago']))            $idTipoPago             = $_POST['idTipoPago'];
	if (!empty($_POST['nDocPago']))              $nDocPago               = $_POST['nDocPago'];
	if (!empty($_POST['montoPago']))             $montoPago              = $_POST['montoPago'];
	if (!empty($_POST['idUsuarioPago']))         $idUsuarioPago          = $_POST['idUsuarioPago'];
	if (!empty($_POST['idApoderado']))           $idApoderado            = $_POST['idApoderado'];
	if (!empty($_POST['montoPactado']))          $montoPactado           = $_POST['montoPactado'];

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
			case 'idFacturacion':          if(empty($idFacturacion)){            $error['idFacturacion']          = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){                $error['idSistema']              = 'error/No ha ingresado el sistema';}break;
			case 'idUsuario':              if(empty($idUsuario)){                $error['idUsuario']              = 'error/No ha ingresado el usuario creador';}break;
			case 'Fecha':                  if(empty($Fecha)){                    $error['Fecha']                  = 'error/No ha ingresado el Fecha';}break;
			case 'Dia':                    if(empty($Dia)){                      $error['Dia']                    = 'error/No ha ingresado la Dia';}break;
			case 'idMes':                  if(empty($idMes)){                    $error['idMes']                  = 'error/No ha ingresado el mes';}break;
			case 'Ano':                    if(empty($Ano)){                      $error['Ano']                    = 'error/No ha seleccionado el Ano';}break;
			case 'Observaciones':          if(empty($Observaciones)){            $error['Observaciones']          = 'error/No ha ingresado la observacion';}break;
			case 'fCreacion':              if(empty($fCreacion)){                $error['fCreacion']              = 'error/No ha ingresado la fecha de creación';}break;
			case 'idFacturacionDetalle':   if(empty($idFacturacionDetalle)){     $error['idFacturacionDetalle']   = 'error/No ha ingresado la id del detalle';}break;
			case 'idCliente':              if(empty($idCliente)){                $error['idCliente']              = 'error/No ha ingresado el cliente';}break;
			case 'SII_NDoc':               if(empty($SII_NDoc)){                 $error['SII_NDoc']               = 'error/No ha ingresado el numero de documento';}break;
			case 'Pagofecha':              if(empty($Pagofecha)){                $error['Pagofecha']              = 'error/No ha ingresado la fecha de pago';}break;
			case 'idTipoPago':             if(empty($idTipoPago)){               $error['idTipoPago']             = 'error/No ha seleccionado el tipo de pago';}break;
			case 'nDocPago':               if(empty($nDocPago)){                 $error['nDocPago']               = 'error/No ha ingresado el numero de documento de pago';}break;
			case 'montoPago':              if(empty($montoPago)){                $error['montoPago']              = 'error/No ha ingresado el monto de pago';}break;
			case 'idUsuarioPago':          if(empty($idUsuarioPago)){            $error['idUsuarioPago']          = 'error/No ha seleccionado el usuario de pago';}break;
			case 'idApoderado':            if(empty($idApoderado)){              $error['idApoderado']            = 'error/No ha seleccionado el apoderado';}break;
			case 'montoPactado':           if(empty($montoPactado)){             $error['montoPactado']           = 'error/No ha ingresado el el monto pagado';}break;

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
		case 'create_new':
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idSistema)&&isset($Fecha)){
				$idMes = fecha2NMes($Fecha);
				$Ano   = fecha2Ano($Fecha);
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'vehiculos_facturacion_apoderados_listado', '', "idSistema='".$idSistema."' AND idMes='".$idMes."' AND Ano='".$Ano."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La facturacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['vehiculos_apoderados_basicos']);
				unset($_SESSION['vehiculos_apoderados_detalle']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Fecha)){          $_SESSION['vehiculos_apoderados_basicos']['Fecha']         = $Fecha;           }else{$_SESSION['vehiculos_apoderados_basicos']['Fecha']         = '';}
				if(isset($Observaciones)){  $_SESSION['vehiculos_apoderados_basicos']['Observaciones'] = $Observaciones;   }else{$_SESSION['vehiculos_apoderados_basicos']['Observaciones'] = 'Sin Observaciones';}
				if(isset($idSistema)){      $_SESSION['vehiculos_apoderados_basicos']['idSistema']     = $idSistema;       }else{$_SESSION['vehiculos_apoderados_basicos']['idSistema']     = '';}
				if(isset($idUsuario)){      $_SESSION['vehiculos_apoderados_basicos']['idUsuario']     = $idUsuario;       }else{$_SESSION['vehiculos_apoderados_basicos']['idUsuario']     = '';}
				if(isset($fCreacion)){      $_SESSION['vehiculos_apoderados_basicos']['fCreacion']     = $fCreacion;       }else{$_SESSION['vehiculos_apoderados_basicos']['fCreacion']     = '';}

				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_apoderados_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['vehiculos_apoderados_basicos']['Usuario'] = '';
				}
				/********************************************************************************/
				if(isset($idSistema) && $idSistema!=''){
					// consulto los datos
					$rowSistema = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_apoderados_basicos']['Sistema'] = $rowSistema['Nombre'];
				}else{
					$_SESSION['vehiculos_apoderados_basicos']['Sistema'] = '';
				}

				//redirijo a la vista
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'clear_all':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['vehiculos_apoderados_basicos']);
			unset($_SESSION['vehiculos_apoderados_detalle']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'edit_datos':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idSistema)&&isset($Fecha)){
				$idMes = fecha2NMes($Fecha);
				$Ano   = fecha2Ano($Fecha);
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'vehiculos_facturacion_apoderados_listado', '', "idSistema='".$idSistema."' AND idMes='".$idMes."' AND Ano='".$Ano."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La facturacion ya existe en el sistema';}
			/*******************************************************************/
			//si no hay errores
			if(empty($error)){

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Fecha)){          $_SESSION['vehiculos_apoderados_basicos']['Fecha']         = $Fecha;           }else{$_SESSION['vehiculos_apoderados_basicos']['Fecha']         = '';}
				if(isset($Observaciones)){  $_SESSION['vehiculos_apoderados_basicos']['Observaciones'] = $Observaciones;   }else{$_SESSION['vehiculos_apoderados_basicos']['Observaciones'] = 'Sin Observaciones';}
				if(isset($idSistema)){      $_SESSION['vehiculos_apoderados_basicos']['idSistema']     = $idSistema;       }else{$_SESSION['vehiculos_apoderados_basicos']['idSistema']     = '';}
				if(isset($idUsuario)){      $_SESSION['vehiculos_apoderados_basicos']['idUsuario']     = $idUsuario;       }else{$_SESSION['vehiculos_apoderados_basicos']['idUsuario']     = '';}
				if(isset($fCreacion)){      $_SESSION['vehiculos_apoderados_basicos']['fCreacion']     = $fCreacion;       }else{$_SESSION['vehiculos_apoderados_basicos']['fCreacion']     = '';}

				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_apoderados_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['vehiculos_apoderados_basicos']['Usuario'] = '';
				}
				/********************************************************************************/
				if(isset($idSistema) && $idSistema!=''){
					// consulto los datos
					$rowSistema = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_apoderados_basicos']['Sistema'] = $rowSistema['Nombre'];
				}else{
					$_SESSION['vehiculos_apoderados_basicos']['Sistema'] = '';
				}

				//redirijo a la vista
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'add_all_cliente':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['vehiculos_apoderados_detalle']);

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Variables
				$SIS_idSistema   = $_SESSION['vehiculos_apoderados_basicos']['idSistema'];

				//traigo solo los apoderados con plan y cobro mensual
				$SIS_query = '
				apoderados_listado.idApoderado,
				apoderados_listado.Nombre AS ApoderadoNombre,
				apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
				apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,
				apoderados_listado.idPlan,
				sistema_planes_transporte.Nombre AS PlanNombre,
				sistema_planes_transporte.Valor_Mensual AS PlanValor_Mensual';
				$SIS_join  = 'LEFT JOIN `sistema_planes_transporte`  ON sistema_planes_transporte.idPlan  = apoderados_listado.idPlan';
				$SIS_where = 'apoderados_listado.idSistema = "'.$SIS_idSistema.'" AND apoderados_listado.idEstado = 1 AND apoderados_listado.idPlan != 0 AND apoderados_listado.idCobro = 1';
				$SIS_order = 'apoderados_listado.idApoderado ASC';
				$arrApoderado = array();
				$arrApoderado = db_select_array (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				foreach ($arrApoderado as $apo) {
					$_SESSION['vehiculos_apoderados_detalle'][$apo['idApoderado']]['idApoderado']   = $apo['idApoderado'];
					$_SESSION['vehiculos_apoderados_detalle'][$apo['idApoderado']]['Apoderado']     = $apo['ApoderadoNombre'].' '.$apo['ApoderadoApellidoPat'].' '.$apo['ApoderadoApellidoMat'];
					$_SESSION['vehiculos_apoderados_detalle'][$apo['idApoderado']]['idPlan']        = $apo['idPlan'];
					$_SESSION['vehiculos_apoderados_detalle'][$apo['idApoderado']]['PlanNombre']    = $apo['PlanNombre'];
					$_SESSION['vehiculos_apoderados_detalle'][$apo['idApoderado']]['MontoPactado']  = $apo['PlanValor_Mensual'];
				}

				//redirijo a la vista
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_cliente':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idCliente   = $_GET['del_cliente'];

			//$_SESSION['vehiculos_apoderados_detalle'][$idCliente] = '';
			unset($_SESSION['vehiculos_apoderados_detalle'][$idCliente]);

			//redirijo a la vista
			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'facturar':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//Datos basicos
			if (isset($_SESSION['vehiculos_apoderados_basicos'])){
				if(!isset($_SESSION['vehiculos_apoderados_basicos']['idSistema']) OR $_SESSION['vehiculos_apoderados_basicos']['idSistema']=='' ){           $error['idSistema']    = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['vehiculos_apoderados_basicos']['idUsuario']) OR $_SESSION['vehiculos_apoderados_basicos']['idUsuario']=='' ){           $error['idUsuario']    = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['vehiculos_apoderados_basicos']['Fecha']) OR $_SESSION['vehiculos_apoderados_basicos']['Fecha']=='' ){                   $error['Fecha']        = 'error/No ha ingresado una fecha';}
				if(!isset($_SESSION['vehiculos_apoderados_basicos']['Observaciones']) OR $_SESSION['vehiculos_apoderados_basicos']['Observaciones']=='' ){   $error['idUsuario']    = 'error/No ha ingresado una observacion';}
				if(!isset($_SESSION['vehiculos_apoderados_basicos']['fCreacion']) OR $_SESSION['vehiculos_apoderados_basicos']['fCreacion']=='' ){           $error['fCreacion']    = 'error/No ha ingresado una fecha de creación';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la facturacion';
			}
			//Se verifican productos
			if (isset($_SESSION['vehiculos_apoderados_detalle'])){
				foreach ($_SESSION['vehiculos_apoderados_detalle'] as $key => $apo){
					$n_data1++;
				}
			}

			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado apoderados';
			}

			// se ejecuta codigo en caso de no haber errores
			if(empty($error)){

				//variables
				$SIS_idSistema            = $_SESSION['vehiculos_apoderados_basicos']['idSistema'];
				$SIS_idUsuario            = $_SESSION['vehiculos_apoderados_basicos']['idUsuario'];
				$SIS_Fecha                = $_SESSION['vehiculos_apoderados_basicos']['Fecha'];
				$SIS_Observaciones        = $_SESSION['vehiculos_apoderados_basicos']['Observaciones'];
				$SIS_fCreacion            = $_SESSION['vehiculos_apoderados_basicos']['fCreacion'];

				/************************************************************************************************************************/
				//Se insertan los datos principales
				if(isset($SIS_idSistema) && $SIS_idSistema!=''){    $SIS_data  = "'".$SIS_idSistema."'";    }else{$SIS_data  = "''";}
				if(isset($SIS_idUsuario) && $SIS_idUsuario!=''){    $SIS_data .= ",'".$SIS_idUsuario."'";   }else{$SIS_data .= ",''";}
				if(isset($SIS_Fecha) && $SIS_Fecha!= ''){
					$SIS_data .= ",'".$SIS_Fecha."'";
					$SIS_data .= ",'".fecha2NMes($SIS_Fecha)."'";
					$SIS_data .= ",'".fecha2Ano($SIS_Fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($SIS_Observaciones) && $SIS_Observaciones!=''){    $SIS_data .= ",'".$SIS_Observaciones."'";   }else{$SIS_data .= ",''";}
				if(isset($SIS_fCreacion) && $SIS_fCreacion!=''){            $SIS_data .= ",'".$SIS_fCreacion."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, Fecha, idMes, Ano, Observaciones, fCreacion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_facturacion_apoderados_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['vehiculos_apoderados_detalle'])){
						foreach ($_SESSION['vehiculos_apoderados_detalle'] as $key => $apo){
							//Genero la consulta
							if(isset($ultimo_id) && $ultimo_id!=''){            $SIS_data  = "'".$ultimo_id."'";        }else{$SIS_data  = "''";}
							if(isset($SIS_idSistema) && $SIS_idSistema!=''){    $SIS_data .= ",'".$SIS_idSistema."'";   }else{$SIS_data .= ",''";}
							if(isset($SIS_idUsuario) && $SIS_idUsuario!=''){    $SIS_data .= ",'".$SIS_idUsuario."'";   }else{$SIS_data .= ",''";}
							if(isset($SIS_Fecha) && $SIS_Fecha!= ''){
								$SIS_data .= ",'".$SIS_Fecha."'";
								$SIS_data .= ",'".fecha2NMes($SIS_Fecha)."'";
								$SIS_data .= ",'".fecha2Ano($SIS_Fecha)."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($SIS_fCreacion) && $SIS_fCreacion!=''){              $SIS_data .= ",'".$SIS_fCreacion."'";        }else{$SIS_data .= ",''";}
							if(isset($apo['idApoderado']) && $apo['idApoderado']!=''){    $SIS_data .= ",'".$apo['idApoderado']."'";   }else{$SIS_data .= ",''";}
							if(isset($apo['idPlan']) && $apo['idPlan']!=''){              $SIS_data .= ",'".$apo['idPlan']."'";        }else{$SIS_data .= ",''";}
							if(isset($apo['MontoPactado']) && $apo['MontoPactado']!=''){  $SIS_data .= ",'".$apo['MontoPactado']."'";  }else{$SIS_data .= ",''";}
							$SIS_data .= ",'1'";//Estado No Pagado

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Fecha, idMes, Ano, fCreacion,
							idApoderado, idPlan, MontoPactado, idEstadoPago';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_facturacion_apoderados_listado_detalle', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
				}

				//Borro todas las sesiones
				unset($_SESSION['vehiculos_apoderados_basicos']);
				unset($_SESSION['vehiculos_apoderados_detalle']);

				//redirijo a la vista
				header( 'Location: '.$location.'&created=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************************************************************/
				//Se Guarda el dato con el pago realizado
				if(isset($idTipoPago) && $idTipoPago!=''){                      $SIS_data  = "'".$idTipoPago."'";             }else{$SIS_data  = "''";}
				if(isset($nDocPago) && $nDocPago!=''){                          $SIS_data .= ",'".$nDocPago."'";              }else{$SIS_data .= ",''";}
				if(isset($Pagofecha) && $Pagofecha!=''){
					$SIS_data .= ",'".$Pagofecha."'";
					$SIS_data .= ",'".fecha2NdiaMes($Pagofecha)."'";
					$SIS_data .= ",'".fecha2NMes($Pagofecha)."'";
					$SIS_data .= ",'".fecha2Ano($Pagofecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($montoPago) && $montoPago!=''){                        $SIS_data .= ",'".$montoPago."'";             }else{$SIS_data .= ",''";}
				if(isset($idUsuarioPago) && $idUsuarioPago!=''){                $SIS_data .= ",'".$idUsuarioPago."'";         }else{$SIS_data .= ",''";}
				if(isset($idApoderado) && $idApoderado!=''){                    $SIS_data .= ",'".$idApoderado."'";           }else{$SIS_data .= ",''";}
				if(isset($idFacturacionDetalle) && $idFacturacionDetalle!=''){  $SIS_data .= ",'".$idFacturacionDetalle."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTipoPago, nDocPago, fechaPago, DiaPago, idMesPago, AnoPago, montoPago, idUsuarioPago,
				idApoderado, idFacturacionDetalle';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_facturacion_apoderados_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/****************************************************************************************************/
					//actualizo el pago actual
					$SIS_data = "idEstadoPago='2'";
					if(isset($idTipoPago) && $idTipoPago!=''){        $SIS_data .= ",idDocPago='".$idTipoPago."'";}
					if(isset($nDocPago) && $nDocPago!=''){            $SIS_data .= ",nDocPago='".$nDocPago."'";}
					if(isset($Pagofecha) && $Pagofecha!=''){
						$SIS_data .= ",Pagofecha='".$Pagofecha."'";
						$SIS_data .= ",PagoDia='".fecha2NdiaMes($Pagofecha)."'";
						$SIS_data .= ",PagoidMes='".fecha2NMes($Pagofecha)."'";
						$SIS_data .= ",PagoAno='".fecha2Ano($Pagofecha)."'";
					}
					if(isset($montoPago) && $montoPago!=''){          $SIS_data .= ",montoPago='".$montoPago."'";}
					if(isset($idUsuarioPago) && $idUsuarioPago!=''){  $SIS_data .= ",idUsuarioPago='".$idUsuarioPago."'";}
					if(isset($ultimo_id) && $ultimo_id!=''){          $SIS_data .= ",idPago='".$ultimo_id."'";}

					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'vehiculos_facturacion_apoderados_listado_detalle', 'idFacturacionDetalle = "'.$idFacturacionDetalle.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/****************************************************************************************************/
					//actualizo todos los pagos y los dejo con pagos en 0
					$SIS_data = "idEstadoPago='3'";
					if(isset($idUsuarioPago) && $idUsuarioPago!=''){  $SIS_data .= ",idUsuarioPago='".$idUsuarioPago."'";}
					if(isset($ultimo_id) && $ultimo_id!=''){          $SIS_data .= ",idPago='".$ultimo_id."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'vehiculos_facturacion_listado_detalle', 'idApoderado = "'.$idApoderado.'" AND idEstadoPago="1"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){

						//redirijo a la vista
						header( 'Location: '.$location.'&created=true' );
						die;
					}
				}
			}

		break;

/*******************************************************************************************************************/
	}

?>
