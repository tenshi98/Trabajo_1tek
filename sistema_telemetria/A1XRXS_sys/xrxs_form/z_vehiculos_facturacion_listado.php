<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-287).');
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
				$Ano = fecha2Ano($Fecha);
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'vehiculos_facturacion_listado', '', "idSistema='".$idSistema."' AND idMes='".$idMes."' AND Ano='".$Ano."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La facturacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['vehiculos_basicos']);
				unset($_SESSION['vehiculos_hijos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Fecha)){          $_SESSION['vehiculos_basicos']['Fecha']         = $Fecha;           }else{$_SESSION['vehiculos_basicos']['Fecha']         = '';}
				if(isset($Observaciones)){  $_SESSION['vehiculos_basicos']['Observaciones'] = $Observaciones;   }else{$_SESSION['vehiculos_basicos']['Observaciones'] = 'Sin Observaciones';}
				if(isset($idSistema)){      $_SESSION['vehiculos_basicos']['idSistema']     = $idSistema;       }else{$_SESSION['vehiculos_basicos']['idSistema']     = '';}
				if(isset($idUsuario)){      $_SESSION['vehiculos_basicos']['idUsuario']    = $idUsuario;        }else{$_SESSION['vehiculos_basicos']['idUsuario']     = '';}
				if(isset($fCreacion)){      $_SESSION['vehiculos_basicos']['fCreacion']     = $fCreacion;       }else{$_SESSION['vehiculos_basicos']['fCreacion']     = '';}

				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['vehiculos_basicos']['Usuario'] = '';
				}
				/********************************************************************************/
				if(isset($idSistema) && $idSistema!=''){
					// consulto los datos
					$rowSistema = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_basicos']['Sistema'] = $rowSistema['Nombre'];
				}else{
					$_SESSION['vehiculos_basicos']['Sistema'] = '';
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
			unset($_SESSION['vehiculos_basicos']);
			unset($_SESSION['vehiculos_hijos']);

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
				$Ano = fecha2Ano($Fecha);
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'vehiculos_facturacion_listado', '', "idSistema='".$idSistema."' AND idMes='".$idMes."' AND Ano='".$Ano."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La facturacion ya existe en el sistema';}
			/*******************************************************************/
			//si no hay errores
			if(empty($error)){

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Fecha)){          $_SESSION['vehiculos_basicos']['Fecha']         = $Fecha;           }else{$_SESSION['vehiculos_basicos']['Fecha']         = '';}
				if(isset($Observaciones)){  $_SESSION['vehiculos_basicos']['Observaciones'] = $Observaciones;   }else{$_SESSION['vehiculos_basicos']['Observaciones'] = 'Sin Observaciones';}
				if(isset($idSistema)){      $_SESSION['vehiculos_basicos']['idSistema']     = $idSistema;       }else{$_SESSION['vehiculos_basicos']['idSistema']     = '';}
				if(isset($idUsuario)){      $_SESSION['vehiculos_basicos']['idUsuario']     = $idUsuario;       }else{$_SESSION['vehiculos_basicos']['idUsuario']     = '';}
				if(isset($fCreacion)){      $_SESSION['vehiculos_basicos']['fCreacion']     = $fCreacion;       }else{$_SESSION['vehiculos_basicos']['fCreacion']     = '';}

				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['vehiculos_basicos']['Usuario'] = '';
				}
				/********************************************************************************/
				if(isset($idSistema) && $idSistema!=''){
					// consulto los datos
					$rowSistema = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['vehiculos_basicos']['Sistema'] = $rowSistema['Nombre'];
				}else{
					$_SESSION['vehiculos_basicos']['Sistema'] = '';
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
			unset($_SESSION['vehiculos_hijos']);

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Variables
				$SIS_idSistema           = $_SESSION['vehiculos_basicos']['idSistema'];

				//traigo todos los apoderados con hijos
				$SIS_query = '
				apoderados_listado_hijos.idHijos,
				apoderados_listado_hijos.idApoderado,

				apoderados_listado_hijos.Nombre AS HijoNombre,
				apoderados_listado_hijos.ApellidoPat AS HijoApellidoPat,
				apoderados_listado_hijos.ApellidoMat AS HijoApellidoMat,

				apoderados_listado.Nombre AS ApoderadoNombre,
				apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
				apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,

				vehiculos_listado.Nombre AS VehiculoNombre,
				vehiculos_listado.Patente AS VehiculoPatente';
				$SIS_join  = '
				LEFT JOIN `apoderados_listado`  ON apoderados_listado.idApoderado  = apoderados_listado_hijos.idApoderado
				LEFT JOIN `vehiculos_listado`   ON vehiculos_listado.idVehiculo    = apoderados_listado_hijos.idVehiculo';
				$SIS_where = 'apoderados_listado.idSistema = "'.$SIS_idSistema.'" AND apoderados_listado.idEstado = 1 AND apoderados_listado_hijos.idVehiculo!=0 GROUP BY apoderados_listado_hijos.idHijos';
				$SIS_order = 'BY apoderados_listado.idApoderado, apoderados_listado_hijos.Nombre ASC';
				$arrHijos = array();
				$arrHijos = db_select_array (false, $SIS_query, 'apoderados_listado_hijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				foreach ($arrHijos as $hijo) {
					$_SESSION['vehiculos_hijos'][$hijo['idHijos']]['idHijos']           = $hijo['idHijos'];
					$_SESSION['vehiculos_hijos'][$hijo['idHijos']]['idApoderado']       = $hijo['idApoderado'];
					$_SESSION['vehiculos_hijos'][$hijo['idHijos']]['VehiculoNombre']    = $hijo['VehiculoNombre'];
					$_SESSION['vehiculos_hijos'][$hijo['idHijos']]['VehiculoPatente']   = $hijo['VehiculoPatente'];
					$_SESSION['vehiculos_hijos'][$hijo['idHijos']]['Apoderado']         = $hijo['ApoderadoNombre'].' '.$hijo['ApoderadoApellidoPat'].' '.$hijo['ApoderadoApellidoMat'];
					$_SESSION['vehiculos_hijos'][$hijo['idHijos']]['Hijo']              = $hijo['HijoNombre'].' '.$hijo['HijoApellidoPat'].' '.$hijo['HijoApellidoMat'];
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

			//$_SESSION['vehiculos_hijos'][$idCliente] = '';
			unset($_SESSION['vehiculos_hijos'][$idCliente]);

			//redirijo a la vista
			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'facturar':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Datos basicos
			if (isset($_SESSION['vehiculos_basicos'])){
				if(!isset($_SESSION['vehiculos_basicos']['idSistema']) OR $_SESSION['vehiculos_basicos']['idSistema']=='' ){           $error['idSistema']    = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['vehiculos_basicos']['idUsuario']) OR $_SESSION['vehiculos_basicos']['idUsuario']=='' ){           $error['idUsuario']    = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['vehiculos_basicos']['Fecha']) OR $_SESSION['vehiculos_basicos']['Fecha']=='' ){                   $error['Fecha']        = 'error/No ha ingresado una fecha';}
				if(!isset($_SESSION['vehiculos_basicos']['Observaciones']) OR $_SESSION['vehiculos_basicos']['Observaciones']=='' ){   $error['idUsuario']    = 'error/No ha ingresado una observacion';}
				if(!isset($_SESSION['vehiculos_basicos']['fCreacion']) OR $_SESSION['vehiculos_basicos']['fCreacion']=='' ){           $error['fCreacion']    = 'error/No ha ingresado una fecha de creación';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la facturacion';
			}

			// se ejecuta codigo en caso de no haber errores
			if(empty($error)){

				//variables
				$SIS_idSistema            = $_SESSION['vehiculos_basicos']['idSistema'];
				$SIS_idUsuario            = $_SESSION['vehiculos_basicos']['idUsuario'];
				$SIS_Fecha                = $_SESSION['vehiculos_basicos']['Fecha'];
				$SIS_Observaciones        = $_SESSION['vehiculos_basicos']['Observaciones'];
				$SIS_fCreacion            = $_SESSION['vehiculos_basicos']['fCreacion'];
				$SIS_Fecha_Ano            = fecha2Ano($_SESSION['vehiculos_basicos']['Fecha']);
				$SIS_Fecha_Mes_anterior   = (fecha2NMes($_SESSION['vehiculos_basicos']['Fecha'])) - 1;
				//En caso de que el mes sea enero, ponerlo como diciembre del año anterior
				if($SIS_Fecha_Mes_anterior == 0){
					$SIS_Fecha_Mes_anterior  = 12;
					$SIS_Fecha_Ano           = $SIS_Fecha_Ano - 1;
				}

				//traigo todos los apoderados con hijos
				$SIS_query = '
				apoderados_listado_hijos.idHijos,
				apoderados_listado_hijos.idApoderado,
				apoderados_listado_hijos.idVehiculo,
				sistema_planes.Valor,
				(SELECT MontoTotal FROM `vehiculos_facturacion_listado_detalle` WHERE idApoderado = apoderados_listado_hijos.idApoderado AND idMes="'.$SIS_Fecha_Mes_anterior.'" AND Ano="'.$SIS_Fecha_Ano.'" LIMIT 1) AS AnteriorPactado,
				(SELECT montoPago FROM `vehiculos_facturacion_listado_detalle` WHERE idApoderado = apoderados_listado_hijos.idApoderado AND idMes="'.$SIS_Fecha_Mes_anterior.'" AND Ano="'.$SIS_Fecha_Ano.'" LIMIT 1) AS AnteriorPagado';
				$SIS_join  = '
				LEFT JOIN `apoderados_listado`    ON apoderados_listado.idApoderado   = apoderados_listado_hijos.idApoderado
				LEFT JOIN `sistema_planes`        ON sistema_planes.idPlan            = apoderados_listado_hijos.idPlan';
				$SIS_where = 'apoderados_listado.idSistema = "'.$SIS_idSistema.'" AND apoderados_listado.idEstado = 1 AND apoderados_listado_hijos.idVehiculo!=0 GROUP BY apoderados_listado_hijos.idHijos';
				$SIS_order = 'apoderados_listado_hijos.idApoderado ASC, apoderados_listado_hijos.Nombre ASC';
				$arrHijos = array();
				$arrHijos = db_select_array (false, $SIS_query, 'apoderados_listado_hijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_facturacion_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/************************************************************************************************************************/
					//Se insertan los detalles
					filtrar($arrHijos, 'idApoderado');
					foreach($arrHijos as $categoria=>$Hijos){
						//variables vacias
						$arrCargas = array();
						$nnx = 1;
						$Subtotal = 0;
						$Atraso = 0;
						$Adelanto = 0;
						$Total = 0;
						//Recorro los hijos del apoderado
						foreach ($Hijos as $hijo) {
							$arrCargas[$nnx]['idHijos']      = $hijo['idHijos'];
							$arrCargas[$nnx]['idVehiculo']   = $hijo['idVehiculo'];
							$arrCargas[$nnx]['Valor']        = $hijo['Valor'];
							$dataEx                          = $Adelanto + $hijo['AnteriorPagado'] - $hijo['AnteriorPactado'];
							$Subtotal                        = $Subtotal + $hijo['Valor'];
							$nnx++;

							if($dataEx < 0){
								$Atraso = $dataEx*-1;
							}else{
								$Adelanto = $dataEx;
							}

						}

						//Si adelanto es negativo reseteo a 0

						//Se calculan los totales
						$Total = $Subtotal + $Atraso - $Adelanto;

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
						if(isset($SIS_fCreacion) && $SIS_fCreacion!=''){                               $SIS_data .= ",'".$SIS_fCreacion."'";                 }else{$SIS_data .= ",''";}
						if(isset($categoria) && $categoria!=''){                                       $SIS_data .= ",'".$categoria."'";                     }else{$SIS_data .= ",''";}
						if(isset($arrCargas[1]['idHijos']) && $arrCargas[1]['idHijos']!=''){           $SIS_data .= ",'".$arrCargas[1]['idHijos']."'";       }else{$SIS_data .= ",''";}
						if(isset($arrCargas[2]['idHijos']) && $arrCargas[2]['idHijos']!=''){           $SIS_data .= ",'".$arrCargas[2]['idHijos']."'";       }else{$SIS_data .= ",''";}
						if(isset($arrCargas[3]['idHijos']) && $arrCargas[3]['idHijos']!=''){           $SIS_data .= ",'".$arrCargas[3]['idHijos']."'";       }else{$SIS_data .= ",''";}
						if(isset($arrCargas[4]['idHijos']) && $arrCargas[4]['idHijos']!=''){           $SIS_data .= ",'".$arrCargas[4]['idHijos']."'";       }else{$SIS_data .= ",''";}
						if(isset($arrCargas[5]['idHijos']) && $arrCargas[5]['idHijos']!=''){           $SIS_data .= ",'".$arrCargas[5]['idHijos']."'";       }else{$SIS_data .= ",''";}
						if(isset($arrCargas[1]['idVehiculo']) && $arrCargas[1]['idVehiculo']!=''){     $SIS_data .= ",'".$arrCargas[1]['idVehiculo']."'";    }else{$SIS_data .= ",''";}
						if(isset($arrCargas[2]['idVehiculo']) && $arrCargas[2]['idVehiculo']!=''){     $SIS_data .= ",'".$arrCargas[2]['idVehiculo']."'";    }else{$SIS_data .= ",''";}
						if(isset($arrCargas[3]['idVehiculo']) && $arrCargas[3]['idVehiculo']!=''){     $SIS_data .= ",'".$arrCargas[3]['idVehiculo']."'";    }else{$SIS_data .= ",''";}
						if(isset($arrCargas[4]['idVehiculo']) && $arrCargas[4]['idVehiculo']!=''){     $SIS_data .= ",'".$arrCargas[4]['idVehiculo']."'";    }else{$SIS_data .= ",''";}
						if(isset($arrCargas[5]['idVehiculo']) && $arrCargas[5]['idVehiculo']!=''){     $SIS_data .= ",'".$arrCargas[5]['idVehiculo']."'";    }else{$SIS_data .= ",''";}
						if(isset($arrCargas[1]['Valor']) && $arrCargas[1]['Valor']!=''){               $SIS_data .= ",'".$arrCargas[1]['Valor']."'";         }else{$SIS_data .= ",''";}
						if(isset($arrCargas[2]['Valor']) && $arrCargas[2]['Valor']!=''){               $SIS_data .= ",'".$arrCargas[2]['Valor']."'";         }else{$SIS_data .= ",''";}
						if(isset($arrCargas[3]['Valor']) && $arrCargas[3]['Valor']!=''){               $SIS_data .= ",'".$arrCargas[3]['Valor']."'";         }else{$SIS_data .= ",''";}
						if(isset($arrCargas[4]['Valor']) && $arrCargas[4]['Valor']!=''){               $SIS_data .= ",'".$arrCargas[4]['Valor']."'";         }else{$SIS_data .= ",''";}
						if(isset($arrCargas[5]['Valor']) && $arrCargas[5]['Valor']!=''){               $SIS_data .= ",'".$arrCargas[5]['Valor']."'";         }else{$SIS_data .= ",''";}
						if(isset($Subtotal) && $Subtotal!=''){                                         $SIS_data .= ",'".$Subtotal."'";                      }else{$SIS_data .= ",''";}
						if(isset($Atraso) && $Atraso!=''){                                             $SIS_data .= ",'".$Atraso."'";                        }else{$SIS_data .= ",''";}
						if(isset($Adelanto) && $Adelanto!=''){                                         $SIS_data .= ",'".$Adelanto."'";                      }else{$SIS_data .= ",''";}
						if(isset($Total) && $Total!=''){                                               $SIS_data .= ",'".$Total."'";                         }else{$SIS_data .= ",''";}
						$SIS_data .= ",'1'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFacturacion, idSistema, idUsuario, Fecha, idMes, Ano, fCreacion,
						idApoderado, idHijos_1, idHijos_2, idHijos_3, idHijos_4, idHijos_5, idVehiculo_1,
						idVehiculo_2, idVehiculo_3, idVehiculo_4, idVehiculo_5, Monto_1, Monto_2, Monto_3,
						Monto_4, Monto_5, MontoSubTotal, MontoAtraso, MontoAdelanto, MontoTotal, idEstado';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_facturacion_listado_detalle', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					//Borro todas las sesiones
					unset($_SESSION['vehiculos_basicos']);
					unset($_SESSION['vehiculos_hijos']);

					//redirijo a la vista
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************************************************************/
				//Se Guarda el datyo con el pago realizado
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
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_facturacion_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/****************************************************************************************************/
					//Se revisa si ya hay un pago anterior en el mismo id
					$rowDataold = db_select_data (false, 'montoPago', 'vehiculos_facturacion_listado_detalle', '', 'idFacturacionDetalle = '.$idFacturacionDetalle, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//actualizo el estado de la ultima facturacion
					$SIS_data = "idFacturacionDetalle = '".$idFacturacionDetalle."' ";
					//verifico que el saldo haya alcanzado para pagar
					if($montoPactado>$montoPago){
						$SIS_data .= ",idEstado='1'";
					}elseif($ultimo_pago<=$montoPago){
						$SIS_data .= ",idEstado='2'";
						/*******************************************************/
						//se actualizan los datos
						$SIS_data = "idEstado='2'";
						$resultado = db_update_data (false, $SIS_data, 'vehiculos_facturacion_listado_detalle', 'idApoderado = "'.$idApoderado.'" AND idEstado="1"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					if(isset($idTipoPago) && $idTipoPago!=''){        $SIS_data .= ",idTipoPago='".$idTipoPago."'";}
					if(isset($nDocPago) && $nDocPago!=''){            $SIS_data .= ",nDocPago='".$nDocPago."'";}
					if(isset($Pagofecha) && $Pagofecha!=''){
						$SIS_data .= ",Pagofecha='".$Pagofecha."'";
						$SIS_data .= ",PagoDia='".fecha2NdiaMes($Pagofecha)."'";
						$SIS_data .= ",PagoidMes='".fecha2NMes($Pagofecha)."'";
						$SIS_data .= ",PagoAno='".fecha2Ano($Pagofecha)."'";
					}
					//se verifica si se tiene algun pago anterior, si es asi se suman los montos
					if(isset($montoPago) && $montoPago!=''){
						if(isset($rowDataold['montoPago']) && $rowDataold['montoPago']!=''){
							$nuevoMonto = $rowDataold['montoPago'] + $montoPago;
						}else{
							$nuevoMonto = $montoPago;
						}
						$SIS_data .= ",montoPago='".$nuevoMonto."'";
					}
					if(isset($idUsuarioPago) && $idUsuarioPago!=''){  $SIS_data .= ",idUsuarioPago='".$idUsuarioPago."'";}
					if(isset($ultimo_id) && $ultimo_id!=''){          $SIS_data .= ",idPago='".$ultimo_id."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'vehiculos_facturacion_listado_detalle', 'idFacturacionDetalle = "'.$idFacturacionDetalle.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
