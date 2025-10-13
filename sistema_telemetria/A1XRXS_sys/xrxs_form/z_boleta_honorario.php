<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-228).');
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
	if (!empty($_POST['Creacion_fecha'])) $Creacion_fecha  = $_POST['Creacion_fecha'];
	if (!empty($_POST['N_Doc']))          $N_Doc           = $_POST['N_Doc'];
	if (!empty($_POST['Observaciones']))  $Observaciones   = $_POST['Observaciones'];
	if (!empty($_POST['idTrabajador']))   $idTrabajador    = $_POST['idTrabajador'];
	if (!empty($_POST['idCliente']))      $idCliente       = $_POST['idCliente'];
	if (!empty($_POST['idProveedor']))    $idProveedor     = $_POST['idProveedor'];
	if (!empty($_POST['idEstado']))       $idEstado        = $_POST['idEstado'];
	if (!empty($_POST['fecha_auto']))     $fecha_auto      = $_POST['fecha_auto'];
	if (!empty($_POST['ValorNeto']))      $ValorNeto       = $_POST['ValorNeto'];
	if (!empty($_POST['Impuesto']))       $Impuesto        = $_POST['Impuesto'];
	if (!empty($_POST['ValorTotal']))     $ValorTotal      = $_POST['ValorTotal'];
	if (!empty($_POST['idUsuarioPago']))  $idUsuarioPago   = $_POST['idUsuarioPago'];
	if (!empty($_POST['idDocPago']))      $idDocPago       = $_POST['idDocPago'];
	if (!empty($_POST['N_DocPago']))      $N_DocPago       = $_POST['N_DocPago'];
	if (!empty($_POST['F_Pago']))         $F_Pago          = $_POST['F_Pago'];
	if (!empty($_POST['MontoPagado']))    $MontoPagado     = $_POST['MontoPagado'];
	if (!empty($_POST['idOcompra']))      $idOcompra       = $_POST['idOcompra'];

	if (!empty($_POST['Nombre']))         $Nombre          = $_POST['Nombre'];
	if (!empty($_POST['vTotal']))         $vTotal          = $_POST['vTotal'];
	if (!empty($_POST['oldidProducto']))  $oldidProducto   = $_POST['oldidProducto'];
	if (!empty($_POST['idExistencia']))   $idExistencia    = $_POST['idExistencia'];

	if (!empty($_POST['idCentroCosto']))     $idCentroCosto       = $_POST['idCentroCosto'];
	if (!empty($_POST['idLevel_1']))         $idLevel_1           = $_POST['idLevel_1'];
	if (!empty($_POST['idLevel_2']))         $idLevel_2           = $_POST['idLevel_2'];
	if (!empty($_POST['idLevel_3']))         $idLevel_3           = $_POST['idLevel_3'];
	if (!empty($_POST['idLevel_4']))         $idLevel_4           = $_POST['idLevel_4'];
	if (!empty($_POST['idLevel_5']))         $idLevel_5           = $_POST['idLevel_5'];

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
			case 'idUsuario':       if(empty($idUsuario)){        $error['idUsuario']        = 'error/No ha seleccionado la bodega';}break;
			case 'idTipo':          if(empty($idTipo)){           $error['idTipo']           = 'error/No ha ingresado las obsercaciones';}break;
			case 'Creacion_fecha':  if(empty($Creacion_fecha)){   $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}break;
			case 'N_Doc':           if(empty($N_Doc)){            $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}break;
			case 'Observaciones':   if(empty($Observaciones)){    $error['Observaciones']    = 'error/No ha ingresado la observacion';}break;
			case 'idTrabajador':    if(empty($idTrabajador)){     $error['idTrabajador']     = 'error/No ha seleccionado el trabajador';}break;
			case 'idCliente':       if(empty($idCliente)){        $error['idCliente']        = 'error/No ha seleccionado el cliente';}break;
			case 'idProveedor':     if(empty($idProveedor)){      $error['idProveedor']      = 'error/No ha seleccionado el Proveedor';}break;
			case 'idEstado':        if(empty($idEstado)){         $error['idEstado']         = 'error/No ha seleccionado el estado';}break;
			case 'fecha_auto':      if(empty($fecha_auto)){       $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}break;
			case 'ValorNeto':       if(empty($ValorNeto)){        $error['ValorNeto']        = 'error/No ha ingresado el valor neto';}break;
			case 'Impuesto':        if(empty($Impuesto)){         $error['Impuesto']         = 'error/No ha ingresado la retencion';}break;
			case 'ValorTotal':      if(empty($ValorTotal)){       $error['ValorTotal']       = 'error/No ha ingresado el valor total';}break;
			case 'idUsuarioPago':   if(empty($idUsuarioPago)){    $error['idUsuarioPago']    = 'error/No ha seleccionado el usuario de pago';}break;
			case 'idDocPago':       if(empty($idDocPago)){        $error['idDocPago']        = 'error/No ha seleccionado el documento de pago';}break;
			case 'N_DocPago':       if(empty($N_DocPago)){        $error['N_DocPago']        = 'error/No ha seleccionado el numero documento de pago';}break;
			case 'F_Pago':          if(empty($F_Pago)){           $error['F_Pago']           = 'error/No ha ingresado la fecha de pago';}break;
			case 'MontoPagado':     if(empty($MontoPagado)){      $error['MontoPagado']      = 'error/No ha ingresado el monto de pago';}break;
			case 'idOcompra':       if(empty($idOcompra)){        $error['idOcompra']        = 'error/No ha ingresado la Orden de Compra Relacionada';}break;

			case 'Nombre':          if(empty($Nombre)){           $error['Nombre']           = 'error/No ha ingresado el nombre';}break;
			case 'vTotal':          if(empty($vTotal)){           $error['vTotal']           = 'error/No ha ingresado el valor total';}break;
			case 'oldidProducto':   if(empty($oldidProducto)){    $error['oldidProducto']    = 'error/No ha ingresado el id del producto';}break;
			case 'idExistencia':    if(empty($idExistencia)){     $error['idExistencia']     = 'error/No ha ingresado el id de la existencia';}break;

			case 'idCentroCosto':   if(empty($idCentroCosto)){    $error['idCentroCosto']    = 'error/No ha seleccionado el Centro de Costo';}break;
			case 'idLevel_1':       if(empty($idLevel_1)){        $error['idLevel_1']        = 'error/No ha seleccionado el Nivel 1';}break;
			case 'idLevel_2':       if(empty($idLevel_2)){        $error['idLevel_2']        = 'error/No ha seleccionado el Nivel 2';}break;
			case 'idLevel_3':       if(empty($idLevel_3)){        $error['idLevel_3']        = 'error/No ha seleccionado el Nivel 3';}break;
			case 'idLevel_4':       if(empty($idLevel_4)){        $error['idLevel_4']        = 'error/No ha seleccionado el Nivel 4';}break;
			case 'idLevel_5':       if(empty($idLevel_5)){        $error['idLevel_5']        = 'error/No ha seleccionado el Nivel 5';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Nombre) && $Nombre!=''){              $Nombre        = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}

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

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($idTrabajador)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'boleta_honorarios_facturacion', '', "idTrabajador='".$idTrabajador."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($idOcompra)&&$idOcompra!=''){
				//Se verifica la existencia de la ocompra
				$ndata_2 = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', "idOcompra='".$idOcompra."' AND idEstado='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se verifica si aun hay datos pendientes
				$ndata_3 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_boletas', '', "idUso=1 AND idOcompra = ".$idOcompra." AND idTrabajador = ".$idTrabajador." AND N_Doc = ".$N_Doc."", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			if(isset($idOcompra)&&$idOcompra!=''){
				if($ndata_2==0) {$error['ndata_2'] = 'error/La OC ingresada no esta aprobada o no existe, favor verificar';}
				if($ndata_3==0) {$error['ndata_3'] = 'error/No existen items pendientes dentro de la OC';}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['boleta_ing_basicos']);
				unset($_SESSION['boleta_ing_servicios']);
				unset($_SESSION['boleta_ing_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['boleta_ing_archivos'])){
					foreach ($_SESSION['boleta_ing_archivos'] as $key => $producto){
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
				unset($_SESSION['boleta_ing_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['boleta_ing_basicos']['idTrabajador']     = $idTrabajador;    }else{$_SESSION['boleta_ing_basicos']['idTrabajador']    = '';}
				if(isset($N_Doc)&&$N_Doc!=''){                    $_SESSION['boleta_ing_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['boleta_ing_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['boleta_ing_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['boleta_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['boleta_ing_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['boleta_ing_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['boleta_ing_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['boleta_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['boleta_ing_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['boleta_ing_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['boleta_ing_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['boleta_ing_basicos']['idTipo']          = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['boleta_ing_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['boleta_ing_basicos']['fecha_auto']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['boleta_ing_basicos']['idEstado']         = $idEstado;        }else{$_SESSION['boleta_ing_basicos']['idEstado']        = '';}

				/*******************************************************/
				if(isset($idSistema)&&$idSistema!=''){
					//Obtengo el porcentaje de retencion
					$rowImpuesto = db_select_data (false, 'Porcentaje_Ret_Boletas', 'sistema_leyes_fiscales', '', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_basicos']['Porc_Impuesto'] = $rowImpuesto['Porcentaje_Ret_Boletas'];
				}else{
					//se guarda dato
					$_SESSION['boleta_ing_basicos']['Porc_Impuesto'] = '';
				}
				/*******************************************************/
				//Si existe una Orden de compra relacionada
				if(isset($idOcompra)&&$idOcompra!=''){

					$_SESSION['boleta_ing_basicos']['idOcompra'] = $idOcompra;

					$arrBoletas = array();
					$arrBoletas = db_select_array (false, 'idExistencia, Descripcion, Valor', 'ocompra_listado_existencias_boletas', '', 'idUso=1 AND idOcompra = '.$idOcompra.' AND idTrabajador = '.$idTrabajador.' AND N_Doc = '.$N_Doc, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Se guardan los datos
					$idInterno = 1;
					foreach ($arrBoletas as $motivo){
						//se recorren los datos
						$_SESSION['boleta_ing_servicios'][$idInterno]['idServicio']    = $idInterno;
						$_SESSION['boleta_ing_servicios'][$idInterno]['idExistencia']  = $motivo['idExistencia'];
						$_SESSION['boleta_ing_servicios'][$idInterno]['Nombre']        = $motivo['Descripcion'];
						$_SESSION['boleta_ing_servicios'][$idInterno]['vTotal']        = $motivo['Valor'];

						$idInterno++;
					}

				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'boleta_honorarios_facturacion_tipo', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['boleta_ing_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['boleta_ing_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					//Se traen todos los datos del trabajador
					$SIS_query = '
					trabajadores_listado.Nombre,
					trabajadores_listado.ApellidoPat,
					trabajadores_listado.ApellidoMat,
					trabajadores_listado.idCentroCosto,
					trabajadores_listado.idLevel_1,
					trabajadores_listado.idLevel_2,
					trabajadores_listado.idLevel_3,
					trabajadores_listado.idLevel_4,
					trabajadores_listado.idLevel_5,
					centrocosto_listado.Nombre AS CentroCosto_Nombre,
					centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
					centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
					centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
					centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
					centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5';
					$SIS_join  = '
					LEFT JOIN `centrocosto_listado`              ON centrocosto_listado.idCentroCosto         = trabajadores_listado.idCentroCosto
					LEFT JOIN `centrocosto_listado_level_1`      ON centrocosto_listado_level_1.idLevel_1     = trabajadores_listado.idLevel_1
					LEFT JOIN `centrocosto_listado_level_2`      ON centrocosto_listado_level_2.idLevel_2     = trabajadores_listado.idLevel_2
					LEFT JOIN `centrocosto_listado_level_3`      ON centrocosto_listado_level_3.idLevel_3     = trabajadores_listado.idLevel_3
					LEFT JOIN `centrocosto_listado_level_4`      ON centrocosto_listado_level_4.idLevel_4     = trabajadores_listado.idLevel_4
					LEFT JOIN `centrocosto_listado_level_5`      ON centrocosto_listado_level_5.idLevel_5     = trabajadores_listado.idLevel_5
					';
					$SIS_where = 'trabajadores_listado.idTrabajador = '.$idTrabajador;
					$rowTrabajador = db_select_data (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['boleta_ing_basicos']['Trabajador'] = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];

					$_SESSION['boleta_ing_basicos']['idCentroCosto']        = $rowTrabajador['idCentroCosto'];       //idCentroCosto
					$_SESSION['boleta_ing_basicos']['idLevel_1']            = $rowTrabajador['idLevel_1'];           //idLevel_1
					$_SESSION['boleta_ing_basicos']['idLevel_2']            = $rowTrabajador['idLevel_2'];           //idLevel_2
					$_SESSION['boleta_ing_basicos']['idLevel_3']            = $rowTrabajador['idLevel_3'];           //idLevel_3
					$_SESSION['boleta_ing_basicos']['idLevel_4']            = $rowTrabajador['idLevel_4'];           //idLevel_4
					$_SESSION['boleta_ing_basicos']['idLevel_5']            = $rowTrabajador['idLevel_5'];           //idLevel_5

					$_SESSION['boleta_ing_basicos']['CentroCosto']          = '';  //CentroCosto
					if(isset($rowTrabajador['CentroCosto_Nombre'])&&$rowTrabajador['CentroCosto_Nombre']!=''){   $_SESSION['boleta_ing_basicos']['CentroCosto']  = $rowTrabajador['CentroCosto_Nombre'];}
					if(isset($rowTrabajador['CentroCosto_Level_1'])&&$rowTrabajador['CentroCosto_Level_1']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_1'];}
					if(isset($rowTrabajador['CentroCosto_Level_2'])&&$rowTrabajador['CentroCosto_Level_2']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_2'];}
					if(isset($rowTrabajador['CentroCosto_Level_3'])&&$rowTrabajador['CentroCosto_Level_3']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_3'];}
					if(isset($rowTrabajador['CentroCosto_Level_4'])&&$rowTrabajador['CentroCosto_Level_4']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_4'];}
					if(isset($rowTrabajador['CentroCosto_Level_5'])&&$rowTrabajador['CentroCosto_Level_5']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_5'];}

				}else{
					$_SESSION['boleta_ing_basicos']['Trabajador']     = '';
					$_SESSION['boleta_ing_basicos']['idCentroCosto']  = '';
					$_SESSION['boleta_ing_basicos']['idLevel_1']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_2']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_3']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_4']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_5']      = '';
					$_SESSION['boleta_ing_basicos']['CentroCosto']    = '';

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
			unset($_SESSION['boleta_ing_basicos']);
			unset($_SESSION['boleta_ing_servicios']);
			unset($_SESSION['boleta_ing_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['boleta_ing_archivos'])){
				foreach ($_SESSION['boleta_ing_archivos'] as $key => $producto){
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
			unset($_SESSION['boleta_ing_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($idTrabajador)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'boleta_honorarios_facturacion', '', "idTrabajador='".$idTrabajador."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($idOcompra)&&$idOcompra!=''){
				//Se verifica la existencia de la ocompra
				$ndata_2 = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', "idOcompra='".$idOcompra."' AND idEstado='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se verifica si aun hay datos pendientes
				$ndata_3 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_boletas', '', "idUso=1 AND idOcompra = ".$idOcompra." AND idTrabajador = ".$idTrabajador." AND N_Doc = ".$N_Doc."", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			if(isset($idOcompra)&&$idOcompra!=''){
				if($ndata_2==0) {$error['ndata_2'] = 'error/La OC ingresada no esta aprobada o no existe, favor verificar';}
				if($ndata_3==0) {$error['ndata_3'] = 'error/No existen items pendientes dentro de la OC';}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['boleta_ing_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['boleta_ing_servicios']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idTrabajador)&&$idTrabajador!=''){      $_SESSION['boleta_ing_basicos']['idTrabajador']     = $idTrabajador;    }else{$_SESSION['boleta_ing_basicos']['idTrabajador']    = '';}
				if(isset($N_Doc)&&$N_Doc!=''){                    $_SESSION['boleta_ing_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['boleta_ing_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['boleta_ing_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['boleta_ing_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['boleta_ing_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['boleta_ing_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['boleta_ing_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['boleta_ing_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['boleta_ing_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['boleta_ing_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['boleta_ing_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['boleta_ing_basicos']['idTipo']          = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['boleta_ing_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['boleta_ing_basicos']['fecha_auto']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['boleta_ing_basicos']['idEstado']         = $idEstado;        }else{$_SESSION['boleta_ing_basicos']['idEstado']        = '';}

				/*******************************************************/
				if(isset($idSistema)&&$idSistema!=''){
					//Obtengo el porcentaje de retencion
					$rowImpuesto = db_select_data (false, 'Porcentaje_Ret_Boletas', 'sistema_leyes_fiscales', '', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_basicos']['Porc_Impuesto'] = $rowImpuesto['Porcentaje_Ret_Boletas'];
				}else{
					//se guarda dato
					$_SESSION['boleta_ing_basicos']['Porc_Impuesto'] = '';
				}
				/*******************************************************/
				//Si existe una Orden de compra relacionada
				if(isset($idOcompra)&&$idOcompra!=''){

					$_SESSION['boleta_ing_basicos']['idOcompra'] = $idOcompra;

					$arrBoletas = array();
					$arrBoletas = db_select_array (false, 'idExistencia, Descripcion, Valor', 'ocompra_listado_existencias_boletas', '', 'idUso=1 AND idOcompra = '.$idOcompra.' AND idTrabajador = '.$idTrabajador.' AND N_Doc = '.$N_Doc, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Se guardan los datos
					$idInterno = 1;
					foreach ($arrBoletas as $motivo){
						//se recorren los datos
						$_SESSION['boleta_ing_servicios'][$idInterno]['idServicio']    = $idInterno;
						$_SESSION['boleta_ing_servicios'][$idInterno]['idExistencia']  = $motivo['idExistencia'];
						$_SESSION['boleta_ing_servicios'][$idInterno]['Nombre']        = $motivo['Descripcion'];
						$_SESSION['boleta_ing_servicios'][$idInterno]['vTotal']        = $motivo['Valor'];

						$idInterno++;
					}

				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'boleta_honorarios_facturacion_tipo', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['boleta_ing_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['boleta_ing_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					//Se traen todos los datos del trabajador
					$SIS_query = '
					trabajadores_listado.Nombre,
					trabajadores_listado.ApellidoPat,
					trabajadores_listado.ApellidoMat,
					trabajadores_listado.idCentroCosto,
					trabajadores_listado.idLevel_1,
					trabajadores_listado.idLevel_2,
					trabajadores_listado.idLevel_3,
					trabajadores_listado.idLevel_4,
					trabajadores_listado.idLevel_5,
					centrocosto_listado.Nombre AS CentroCosto_Nombre,
					centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
					centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
					centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
					centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
					centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5';
					$SIS_join  = '
					LEFT JOIN `centrocosto_listado`              ON centrocosto_listado.idCentroCosto         = trabajadores_listado.idCentroCosto
					LEFT JOIN `centrocosto_listado_level_1`      ON centrocosto_listado_level_1.idLevel_1     = trabajadores_listado.idLevel_1
					LEFT JOIN `centrocosto_listado_level_2`      ON centrocosto_listado_level_2.idLevel_2     = trabajadores_listado.idLevel_2
					LEFT JOIN `centrocosto_listado_level_3`      ON centrocosto_listado_level_3.idLevel_3     = trabajadores_listado.idLevel_3
					LEFT JOIN `centrocosto_listado_level_4`      ON centrocosto_listado_level_4.idLevel_4     = trabajadores_listado.idLevel_4
					LEFT JOIN `centrocosto_listado_level_5`      ON centrocosto_listado_level_5.idLevel_5     = trabajadores_listado.idLevel_5
					';
					$SIS_where = 'trabajadores_listado.idTrabajador = '.$idTrabajador;
					$rowTrabajador = db_select_data (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['boleta_ing_basicos']['Trabajador'] = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];

					$_SESSION['boleta_ing_basicos']['idCentroCosto']        = $rowTrabajador['idCentroCosto'];       //idCentroCosto
					$_SESSION['boleta_ing_basicos']['idLevel_1']            = $rowTrabajador['idLevel_1'];           //idLevel_1
					$_SESSION['boleta_ing_basicos']['idLevel_2']            = $rowTrabajador['idLevel_2'];           //idLevel_2
					$_SESSION['boleta_ing_basicos']['idLevel_3']            = $rowTrabajador['idLevel_3'];           //idLevel_3
					$_SESSION['boleta_ing_basicos']['idLevel_4']            = $rowTrabajador['idLevel_4'];           //idLevel_4
					$_SESSION['boleta_ing_basicos']['idLevel_5']            = $rowTrabajador['idLevel_5'];           //idLevel_5

					$_SESSION['boleta_ing_basicos']['CentroCosto']          = '';  //CentroCosto
					if(isset($rowTrabajador['CentroCosto_Nombre'])&&$rowTrabajador['CentroCosto_Nombre']!=''){   $_SESSION['boleta_ing_basicos']['CentroCosto']  = $rowTrabajador['CentroCosto_Nombre'];}
					if(isset($rowTrabajador['CentroCosto_Level_1'])&&$rowTrabajador['CentroCosto_Level_1']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_1'];}
					if(isset($rowTrabajador['CentroCosto_Level_2'])&&$rowTrabajador['CentroCosto_Level_2']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_2'];}
					if(isset($rowTrabajador['CentroCosto_Level_3'])&&$rowTrabajador['CentroCosto_Level_3']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_3'];}
					if(isset($rowTrabajador['CentroCosto_Level_4'])&&$rowTrabajador['CentroCosto_Level_4']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_4'];}
					if(isset($rowTrabajador['CentroCosto_Level_5'])&&$rowTrabajador['CentroCosto_Level_5']!=''){ $_SESSION['boleta_ing_basicos']['CentroCosto'] .= ' - '.$rowTrabajador['CentroCosto_Level_5'];}

				}else{
					$_SESSION['boleta_ing_basicos']['Trabajador']     = '';
					$_SESSION['boleta_ing_basicos']['idCentroCosto']  = '';
					$_SESSION['boleta_ing_basicos']['idLevel_1']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_2']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_3']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_4']      = '';
					$_SESSION['boleta_ing_basicos']['idLevel_5']      = '';
					$_SESSION['boleta_ing_basicos']['CentroCosto']    = '';

				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_servicio_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['boleta_ing_servicios'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['boleta_ing_servicios'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['boleta_ing_servicios'][$idInterno]['idServicio']    = $idInterno;
				$_SESSION['boleta_ing_servicios'][$idInterno]['Nombre']        = $Nombre;
				$_SESSION['boleta_ing_servicios'][$idInterno]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_servicio_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['boleta_ing_servicios'][$oldidProducto]['idServicio']    = $oldidProducto;
				$_SESSION['boleta_ing_servicios'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['boleta_ing_servicios'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_servicio_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['boleta_ing_servicios'][$_GET['del_servicios']]);

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
			if(isset($_SESSION['boleta_ing_archivos'])){
				foreach ($_SESSION['boleta_ing_archivos'] as $key => $trabajos){
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
						$sufijo = 'boletas_honorarios_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['boleta_ing_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['boleta_ing_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['boleta_ing_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['boleta_ing_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['boleta_ing_archivos'][$_GET['del_file']]);
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
			if (isset($_SESSION['boleta_ing_basicos'])){
				if(!isset($_SESSION['boleta_ing_basicos']['idTrabajador']) OR $_SESSION['boleta_ing_basicos']['idTrabajador']=='' ){     $error['idTrabajador']     = 'error/No ha seleccionado el trabajador';}
				if(!isset($_SESSION['boleta_ing_basicos']['N_Doc']) OR $_SESSION['boleta_ing_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['boleta_ing_basicos']['Creacion_fecha']) OR $_SESSION['boleta_ing_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la fecha de creación';}
				if(!isset($_SESSION['boleta_ing_basicos']['Observaciones']) OR $_SESSION['boleta_ing_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['boleta_ing_basicos']['idSistema']) OR $_SESSION['boleta_ing_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['boleta_ing_basicos']['idUsuario']) OR $_SESSION['boleta_ing_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['boleta_ing_basicos']['idTipo']) OR $_SESSION['boleta_ing_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de boleta';}
				if(!isset($_SESSION['boleta_ing_basicos']['fecha_auto']) OR $_SESSION['boleta_ing_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['boleta_ing_basicos']['idEstado']) OR $_SESSION['boleta_ing_basicos']['idEstado']=='' ){             $error['idEstado']         = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['boleta_ing_basicos']['Porc_Impuesto']) OR $_SESSION['boleta_ing_basicos']['Porc_Impuesto']=='' ){   $error['Porc_Impuesto']    = 'error/No hay un porcentaje de retencion configurado';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la boleta de honorarios';
			}
			//productos o guias
			if (!isset($_SESSION['boleta_ing_servicios'])){
				$error['idProducto']   = 'error/No se han asignado servicios';
			}
			//Se verifican productos
			if (isset($_SESSION['boleta_ing_servicios'])){
				foreach ($_SESSION['boleta_ing_servicios'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado servicios';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['boleta_ing_basicos']['idSistema']) && $_SESSION['boleta_ing_basicos']['idSistema']!=''){    $SIS_data  = "'".$_SESSION['boleta_ing_basicos']['idSistema']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['boleta_ing_basicos']['idUsuario']) && $_SESSION['boleta_ing_basicos']['idUsuario']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idTipo']) && $_SESSION['boleta_ing_basicos']['idTipo']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idTipo']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['boleta_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_ing_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['boleta_ing_basicos']['N_Doc']) && $_SESSION['boleta_ing_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['N_Doc']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['Observaciones']) && $_SESSION['boleta_ing_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['Observaciones']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idTrabajador']) && $_SESSION['boleta_ing_basicos']['idTrabajador']!=''){      $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idTrabajador']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idEstado']) && $_SESSION['boleta_ing_basicos']['idEstado']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['fecha_auto']) && $_SESSION['boleta_ing_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['fecha_auto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['valor_neto'])&&$_SESSION['boleta_ing_basicos']['valor_neto']!=''){            $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['valor_neto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['valor_imp'])&&$_SESSION['boleta_ing_basicos']['valor_imp']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['valor_imp']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['valor_total'])&&$_SESSION['boleta_ing_basicos']['valor_total']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['valor_total']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idOcompra'])&&$_SESSION['boleta_ing_basicos']['idOcompra']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idOcompra']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idCentroCosto'])&&$_SESSION['boleta_ing_basicos']['idCentroCosto']!=''){      $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idCentroCosto']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idLevel_1'])&&$_SESSION['boleta_ing_basicos']['idLevel_1']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idLevel_1']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idLevel_2'])&&$_SESSION['boleta_ing_basicos']['idLevel_2']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idLevel_2']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idLevel_3'])&&$_SESSION['boleta_ing_basicos']['idLevel_3']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idLevel_3']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idLevel_4'])&&$_SESSION['boleta_ing_basicos']['idLevel_4']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idLevel_4']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['idLevel_5'])&&$_SESSION['boleta_ing_basicos']['idLevel_5']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idLevel_5']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['CentroCosto'])&&$_SESSION['boleta_ing_basicos']['CentroCosto']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['CentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_basicos']['Porc_Impuesto'])&&$_SESSION['boleta_ing_basicos']['Porc_Impuesto']!=''){      $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['Porc_Impuesto']."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, idTipo, Creacion_fecha,
				Creacion_Semana, Creacion_mes, Creacion_ano, N_Doc, Observaciones, idTrabajador, idEstado, fecha_auto,
				ValorNeto, Impuesto, ValorTotal, idOcompra, idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4,
				idLevel_5, CentroCosto, Porcentaje_Ret_Boletas';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los servicios
					if(isset($_SESSION['boleta_ing_servicios'])){
						foreach ($_SESSION['boleta_ing_servicios'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                        $SIS_data  = "'".$ultimo_id."'";                                     }else{$SIS_data  = "''";}
							if(isset($_SESSION['boleta_ing_basicos']['idSistema']) && $_SESSION['boleta_ing_basicos']['idSistema']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_basicos']['idUsuario']) && $_SESSION['boleta_ing_basicos']['idUsuario']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_basicos']['idTipo']) && $_SESSION['boleta_ing_basicos']['idTipo']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idTipo']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){              $SIS_data .= ",'".$producto['Nombre']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){              $SIS_data .= ",'".$producto['vTotal']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idExistencia']) && $producto['idExistencia']!=''){  $SIS_data .= ",'".$producto['idExistencia']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario,
							idTipo, Creacion_fecha, Creacion_mes, Creacion_ano, Nombre,vTotal, idExistencia';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_servicios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*******************************************************************/
							//Si existe la OC se actualizan los estados de esta
							if(isset($_SESSION['boleta_ing_basicos']['idOcompra']) && $_SESSION['boleta_ing_basicos']['idOcompra']!=''){

								//Actualizo
								$SIS_data = "idUso='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['boleta_ing_archivos'])){
						foreach ($_SESSION['boleta_ing_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                     $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['boleta_ing_basicos']['idSistema']) && $_SESSION['boleta_ing_basicos']['idSistema']!=''){ $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idSistema']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_basicos']['idUsuario']) && $_SESSION['boleta_ing_basicos']['idUsuario']!=''){ $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idUsuario']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_basicos']['idTipo']) && $_SESSION['boleta_ing_basicos']['idTipo']!=''){       $SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['idTipo']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, idTipo, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['boleta_ing_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['boleta_ing_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['boleta_ing_basicos']);
					unset($_SESSION['boleta_ing_servicios']);
					unset($_SESSION['boleta_ing_temporal']);
					unset($_SESSION['boleta_ing_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                          EGRESO                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_egreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'boleta_honorarios_facturacion', '', "idCliente='".$idCliente."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['boleta_eg_basicos']);
				unset($_SESSION['boleta_eg_servicios']);
				unset($_SESSION['boleta_eg_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['boleta_eg_archivos'])){
					foreach ($_SESSION['boleta_eg_archivos'] as $key => $producto){
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
				unset($_SESSION['boleta_eg_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCliente)&&$idCliente!=''){            $_SESSION['boleta_eg_basicos']['idCliente']        = $idCliente;      }else{$_SESSION['boleta_eg_basicos']['idCliente']       = '';}
				if(isset($N_Doc)&&$N_Doc!=''){                    $_SESSION['boleta_eg_basicos']['N_Doc']            = $N_Doc;          }else{$_SESSION['boleta_eg_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['boleta_eg_basicos']['Creacion_fecha']   = $Creacion_fecha; }else{$_SESSION['boleta_eg_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['boleta_eg_basicos']['Observaciones']    = $Observaciones;  }else{$_SESSION['boleta_eg_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['boleta_eg_basicos']['idSistema']        = $idSistema;      }else{$_SESSION['boleta_eg_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['boleta_eg_basicos']['idUsuario']        = $idUsuario;      }else{$_SESSION['boleta_eg_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['boleta_eg_basicos']['idTipo']           = $idTipo;         }else{$_SESSION['boleta_eg_basicos']['idTipo']          = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['boleta_eg_basicos']['fecha_auto']       = $fecha_auto;     }else{$_SESSION['boleta_eg_basicos']['fecha_auto']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['boleta_eg_basicos']['idEstado']         = $idEstado;       }else{$_SESSION['boleta_eg_basicos']['idEstado']        = '';}

				/*******************************************************/
				if(isset($idSistema)&&$idSistema!=''){
					//Obtengo el porcentaje de retencion
					$rowImpuesto = db_select_data (false, 'Porcentaje_Ret_Boletas', 'sistema_leyes_fiscales', '', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['Porc_Impuesto'] = $rowImpuesto['Porcentaje_Ret_Boletas'];
				}else{
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['Porc_Impuesto'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'boleta_honorarios_facturacion_tipo', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['boleta_eg_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = '.$idCliente, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['boleta_eg_basicos']['Cliente'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['boleta_eg_basicos']);
			unset($_SESSION['boleta_eg_servicios']);
			unset($_SESSION['boleta_eg_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['boleta_eg_archivos'])){
				foreach ($_SESSION['boleta_eg_archivos'] as $key => $producto){
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
			unset($_SESSION['boleta_eg_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'boleta_honorarios_facturacion', '', "idCliente='".$idCliente."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['boleta_eg_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['boleta_eg_servicios']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCliente)&&$idCliente!=''){            $_SESSION['boleta_eg_basicos']['idCliente']        = $idCliente;      }else{$_SESSION['boleta_eg_basicos']['idCliente']       = '';}
				if(isset($N_Doc)&&$N_Doc!=''){                    $_SESSION['boleta_eg_basicos']['N_Doc']            = $N_Doc;          }else{$_SESSION['boleta_eg_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['boleta_eg_basicos']['Creacion_fecha']   = $Creacion_fecha; }else{$_SESSION['boleta_eg_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['boleta_eg_basicos']['Observaciones']    = $Observaciones;  }else{$_SESSION['boleta_eg_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['boleta_eg_basicos']['idSistema']        = $idSistema;      }else{$_SESSION['boleta_eg_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['boleta_eg_basicos']['idUsuario']        = $idUsuario;      }else{$_SESSION['boleta_eg_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['boleta_eg_basicos']['idTipo']           = $idTipo;         }else{$_SESSION['boleta_eg_basicos']['idTipo']          = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['boleta_eg_basicos']['fecha_auto']       = $fecha_auto;     }else{$_SESSION['boleta_eg_basicos']['fecha_auto']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['boleta_eg_basicos']['idEstado']         = $idEstado;       }else{$_SESSION['boleta_eg_basicos']['idEstado']        = '';}

				/*******************************************************/
				if(isset($idSistema)&&$idSistema!=''){
					//Obtengo el porcentaje de retencion
					$rowImpuesto = db_select_data (false, 'Porcentaje_Ret_Boletas', 'sistema_leyes_fiscales', '', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['Porc_Impuesto'] = $rowImpuesto['Porcentaje_Ret_Boletas'];
				}else{
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['Porc_Impuesto'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'boleta_honorarios_facturacion_tipo', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['boleta_eg_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = '.$idCliente, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_eg_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['boleta_eg_basicos']['Cliente'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_servicio_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['boleta_eg_servicios'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['boleta_eg_servicios'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['boleta_eg_servicios'][$idInterno]['idServicio']    = $idInterno;
				$_SESSION['boleta_eg_servicios'][$idInterno]['Nombre']        = $Nombre;
				$_SESSION['boleta_eg_servicios'][$idInterno]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_servicio_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['boleta_eg_servicios'][$oldidProducto]['idServicio']    = $oldidProducto;
				$_SESSION['boleta_eg_servicios'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['boleta_eg_servicios'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_servicio_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['boleta_eg_servicios'][$_GET['del_servicios']]);

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
			if(isset($_SESSION['boleta_eg_archivos'])){
				foreach ($_SESSION['boleta_eg_archivos'] as $key => $trabajos){
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
						$sufijo = 'boletas_honorarios_egreso_'.genera_password_unica().'_';

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
									$_SESSION['boleta_eg_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['boleta_eg_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['boleta_eg_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['boleta_eg_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['boleta_eg_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'eg_bodega':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['boleta_eg_basicos'])){
				if(!isset($_SESSION['boleta_eg_basicos']['idCliente']) OR $_SESSION['boleta_eg_basicos']['idCliente']=='' ){           $error['idCliente']        = 'error/No ha seleccionado el Cliente';}
				if(!isset($_SESSION['boleta_eg_basicos']['N_Doc']) OR $_SESSION['boleta_eg_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['boleta_eg_basicos']['Creacion_fecha']) OR $_SESSION['boleta_eg_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la fecha de creación';}
				if(!isset($_SESSION['boleta_eg_basicos']['Observaciones']) OR $_SESSION['boleta_eg_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['boleta_eg_basicos']['idSistema']) OR $_SESSION['boleta_eg_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['boleta_eg_basicos']['idUsuario']) OR $_SESSION['boleta_eg_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['boleta_eg_basicos']['idTipo']) OR $_SESSION['boleta_eg_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de boleta';}
				if(!isset($_SESSION['boleta_eg_basicos']['fecha_auto']) OR $_SESSION['boleta_eg_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['boleta_eg_basicos']['idEstado']) OR $_SESSION['boleta_eg_basicos']['idEstado']=='' ){             $error['idEstado']         = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['boleta_eg_basicos']['Porc_Impuesto']) OR $_SESSION['boleta_eg_basicos']['Porc_Impuesto']=='' ){   $error['Porc_Impuesto']    = 'error/No hay un porcentaje de retencion configurado';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la boleta de honorarios';
			}
			//productos o guias
			if (!isset($_SESSION['boleta_eg_servicios'])){
				$error['idProducto']   = 'error/No se han asignado servicios';
			}
			//Se verifican productos
			if (isset($_SESSION['boleta_eg_servicios'])){
				foreach ($_SESSION['boleta_eg_servicios'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado servicios';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['boleta_eg_basicos']['idSistema']) && $_SESSION['boleta_eg_basicos']['idSistema']!=''){    $SIS_data  = "'".$_SESSION['boleta_eg_basicos']['idSistema']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['boleta_eg_basicos']['idUsuario']) && $_SESSION['boleta_eg_basicos']['idUsuario']!=''){    $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['idTipo']) && $_SESSION['boleta_eg_basicos']['idTipo']!=''){          $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idTipo']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['Creacion_fecha']) && $_SESSION['boleta_eg_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['boleta_eg_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_eg_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_eg_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['boleta_eg_basicos']['N_Doc']) && $_SESSION['boleta_eg_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['N_Doc']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['Observaciones']) && $_SESSION['boleta_eg_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['Observaciones']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['idCliente']) && $_SESSION['boleta_eg_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idCliente']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['idEstado']) && $_SESSION['boleta_eg_basicos']['idEstado']!=''){              $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['fecha_auto']) && $_SESSION['boleta_eg_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['fecha_auto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['valor_neto'])&&$_SESSION['boleta_eg_basicos']['valor_neto']!=''){            $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['valor_neto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['valor_imp'])&&$_SESSION['boleta_eg_basicos']['valor_imp']!=''){              $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['valor_imp']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['valor_total'])&&$_SESSION['boleta_eg_basicos']['valor_total']!=''){          $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['valor_total']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_eg_basicos']['Porc_Impuesto'])&&$_SESSION['boleta_eg_basicos']['Porc_Impuesto']!='')       $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['Porc_Impuesto']."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, idTipo, Creacion_fecha,
				Creacion_Semana, Creacion_mes, Creacion_ano, N_Doc, Observaciones, idCliente, idEstado, fecha_auto,
				ValorNeto, Impuesto, ValorTotal, Porcentaje_Ret_Boletas';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los servicios
					if(isset($_SESSION['boleta_eg_servicios'])){
						foreach ($_SESSION['boleta_eg_servicios'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                      $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['boleta_eg_basicos']['idSistema']) && $_SESSION['boleta_eg_basicos']['idSistema']!=''){    $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_eg_basicos']['idUsuario']) && $_SESSION['boleta_eg_basicos']['idUsuario']!=''){    $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_eg_basicos']['idTipo']) && $_SESSION['boleta_eg_basicos']['idTipo']!=''){          $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idTipo']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_eg_basicos']['Creacion_fecha']) && $_SESSION['boleta_eg_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_eg_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_eg_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario,
							idTipo, Creacion_fecha, Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_servicios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['boleta_eg_archivos'])){
						foreach ($_SESSION['boleta_eg_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                   $SIS_data  = "'".$ultimo_id."'";                                   }else{$SIS_data  = "''";}
							if(isset($_SESSION['boleta_eg_basicos']['idSistema']) && $_SESSION['boleta_eg_basicos']['idSistema']!=''){ $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idSistema']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_eg_basicos']['idUsuario']) && $_SESSION['boleta_eg_basicos']['idUsuario']!=''){ $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idUsuario']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_eg_basicos']['idTipo']) && $_SESSION['boleta_eg_basicos']['idTipo']!=''){       $SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['idTipo']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_eg_basicos']['Creacion_fecha']) && $_SESSION['boleta_eg_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_eg_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_eg_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, idTipo, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['boleta_eg_basicos']['Creacion_fecha']) && $_SESSION['boleta_eg_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['boleta_eg_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['boleta_eg_basicos']);
					unset($_SESSION['boleta_eg_servicios']);
					unset($_SESSION['boleta_eg_temporal']);
					unset($_SESSION['boleta_eg_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                    INGRESOS  EMPRESAS                                           */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_ingreso_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'boleta_honorarios_facturacion', '', "idProveedor='".$idProveedor."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($idOcompra)&&$idOcompra!=''){
				//Se verifica la existencia de la ocompra
				$ndata_2 = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', "idOcompra='".$idOcompra."' AND idEstado='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se verifica si aun hay datos pendientes
				$ndata_3 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_boletas_empresas', '', "Valor>Total_Ingresado AND idOcompra = ".$idOcompra."", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			if(isset($idOcompra)&&$idOcompra!=''){
				if($ndata_2==0) {$error['ndata_2'] = 'error/La OC ingresada no esta aprobada o no existe, favor verificar';}
				if($ndata_3==0) {$error['ndata_3'] = 'error/No existen items pendientes dentro de la OC';}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['boleta_ing_prov_basicos']);
				unset($_SESSION['boleta_ing_prov_servicios']);
				unset($_SESSION['boleta_ing_prov_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['boleta_ing_prov_archivos'])){
					foreach ($_SESSION['boleta_ing_prov_archivos'] as $key => $producto){
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
				unset($_SESSION['boleta_ing_prov_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor)&&$idProveedor!=''){        $_SESSION['boleta_ing_prov_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['boleta_ing_prov_basicos']['idProveedor']     = '';}
				if(isset($N_Doc)&&$N_Doc!=''){                    $_SESSION['boleta_ing_prov_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['boleta_ing_prov_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['boleta_ing_prov_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['boleta_ing_prov_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['boleta_ing_prov_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['boleta_ing_prov_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['boleta_ing_prov_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['boleta_ing_prov_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['boleta_ing_prov_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['boleta_ing_prov_basicos']['idTipo']          = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['boleta_ing_prov_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['boleta_ing_prov_basicos']['fecha_auto']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['boleta_ing_prov_basicos']['idEstado']         = $idEstado;        }else{$_SESSION['boleta_ing_prov_basicos']['idEstado']        = '';}

				/*******************************************************/
				if(isset($idSistema)&&$idSistema!=''){
					//Obtengo el porcentaje de retencion
					$rowImpuesto = db_select_data (false, 'Porcentaje_Ret_Boletas', 'sistema_leyes_fiscales', '', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto'] = $rowImpuesto['Porcentaje_Ret_Boletas'];
				}else{
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto'] = '';
				}
				/*******************************************************/
				//Si existe una Orden de compra relacionada
				if(isset($idOcompra)&&$idOcompra!=''){

					$_SESSION['boleta_ing_prov_basicos']['idOcompra']        = $idOcompra;

					// Se trae un listado con todos las boletas de los trabajadores
					$arrBoletas = array();
					$arrBoletas = db_select_array (false, 'idExistencia, Descripcion, Valor, Total_Ingresado', 'ocompra_listado_existencias_boletas_empresas', '', 'Valor>Total_Ingresado AND idOcompra = '.$idOcompra, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Se guardan los datos
					$idInterno = 1;
					foreach ($arrBoletas as $motivo){
						//se recorren los datos
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['idServicio']    = $idInterno;
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['idExistencia']  = $motivo['idExistencia'];
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['Nombre']        = $motivo['Descripcion'];
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['vTotal']        = $motivo['Valor'] - $motivo['Total_Ingresado'];
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['Total_ing']     = $motivo['Total_Ingresado'];

						$idInterno++;
					}

				}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'boleta_honorarios_facturacion_tipo', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['boleta_ing_prov_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = '.$idProveedor, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['boleta_ing_prov_basicos']['Proveedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['boleta_ing_prov_basicos']);
			unset($_SESSION['boleta_ing_prov_servicios']);
			unset($_SESSION['boleta_ing_prov_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['boleta_ing_prov_archivos'])){
				foreach ($_SESSION['boleta_ing_prov_archivos'] as $key => $producto){
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
			unset($_SESSION['boleta_ing_prov_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'boleta_honorarios_facturacion', '', "idProveedor='".$idProveedor."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($idOcompra)&&$idOcompra!=''){
				//Se verifica la existencia de la ocompra
				$ndata_2 = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', "idOcompra='".$idOcompra."' AND idEstado='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se verifica si aun hay datos pendientes
				$ndata_3 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_boletas_empresas', '', "Valor>Total_Ingresado AND idOcompra = ".$idOcompra."", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			if(isset($idOcompra)&&$idOcompra!=''){
				if($ndata_2==0) {$error['ndata_2'] = 'error/La OC ingresada no esta aprobada o no existe, favor verificar';}
				if($ndata_3==0) {$error['ndata_3'] = 'error/No existen items pendientes dentro de la OC';}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['boleta_ing_prov_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['boleta_ing_prov_servicios']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor)&&$idProveedor!=''){        $_SESSION['boleta_ing_prov_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['boleta_ing_prov_basicos']['idProveedor']     = '';}
				if(isset($N_Doc)&&$N_Doc!=''){                    $_SESSION['boleta_ing_prov_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['boleta_ing_prov_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['boleta_ing_prov_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['boleta_ing_prov_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['boleta_ing_prov_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['boleta_ing_prov_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['boleta_ing_prov_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['boleta_ing_prov_basicos']['idUsuario']       = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['boleta_ing_prov_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['boleta_ing_prov_basicos']['idTipo']          = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['boleta_ing_prov_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['boleta_ing_prov_basicos']['fecha_auto']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['boleta_ing_prov_basicos']['idEstado']         = $idEstado;        }else{$_SESSION['boleta_ing_prov_basicos']['idEstado']        = '';}

				/*******************************************************/
				if(isset($idSistema)&&$idSistema!=''){
					//Obtengo el porcentaje de retencion
					$rowImpuesto = db_select_data (false, 'Porcentaje_Ret_Boletas', 'sistema_leyes_fiscales', '', 'idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto'] = $rowImpuesto['Porcentaje_Ret_Boletas'];
				}else{
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto'] = '';
				}
				/*******************************************************/
				//Si existe una Orden de compra relacionada
				if(isset($idOcompra)&&$idOcompra!=''){

					$_SESSION['boleta_ing_prov_basicos']['idOcompra']        = $idOcompra;

					// Se trae un listado con todos las boletas de los trabajadores
					$arrBoletas = array();
					$arrBoletas = db_select_array (false, 'idExistencia, Descripcion, Valor, Total_Ingresado', 'ocompra_listado_existencias_boletas_empresas', '', 'Valor>Total_Ingresado AND idOcompra = '.$idOcompra, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Se guardan los datos
					$idInterno = 1;
					foreach ($arrBoletas as $motivo){
						//se recorren los datos
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['idServicio']    = $idInterno;
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['idExistencia']  = $motivo['idExistencia'];
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['Nombre']        = $motivo['Descripcion'];
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['vTotal']        = $motivo['Valor'] - $motivo['Total_Ingresado'];
						$_SESSION['boleta_ing_prov_servicios'][$idInterno]['Total_ing']     = $motivo['Total_Ingresado'];

						$idInterno++;
					}

				}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'boleta_honorarios_facturacion_tipo', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['boleta_ing_prov_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = '.$idProveedor, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['boleta_ing_prov_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['boleta_ing_prov_basicos']['Proveedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_servicio_ing_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['boleta_ing_prov_servicios'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['boleta_ing_prov_servicios'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['boleta_ing_prov_servicios'][$idInterno]['idServicio']    = $idInterno;
				$_SESSION['boleta_ing_prov_servicios'][$idInterno]['Nombre']        = $Nombre;
				$_SESSION['boleta_ing_prov_servicios'][$idInterno]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_servicio_ing_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//se verifica la existencia de la OC
			if(isset($_SESSION['boleta_ing_prov_basicos']['idOcompra'])&&$_SESSION['boleta_ing_prov_basicos']['idOcompra']!=''){
				//Se verifica si el dato existe
				if(isset($idExistencia)){
					$rowOrden = db_select_data (false, 'Valor, Total_Ingresado', 'ocompra_listado_existencias_boletas_empresas', '', 'idExistencia='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				//Comprovacion de cantidades
				if($rowOrden['Valor']<($rowOrden['Total_Ingresado']+$vTotal)){
					$error['ndata_1'] = 'error/El Valor que esta ingresando es superior al de la Orden de Compra';
				}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['boleta_ing_prov_servicios'][$oldidProducto]['idServicio']    = $oldidProducto;
				$_SESSION['boleta_ing_prov_servicios'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['boleta_ing_prov_servicios'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_servicio_ing_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['boleta_ing_prov_servicios'][$_GET['del_servicios']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_ing_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['boleta_ing_prov_archivos'])){
				foreach ($_SESSION['boleta_ing_prov_archivos'] as $key => $trabajos){
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
						$sufijo = 'boletas_honorarios_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['boleta_ing_prov_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['boleta_ing_prov_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_ing_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['boleta_ing_prov_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['boleta_ing_prov_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['boleta_ing_prov_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'ing_bodega_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['boleta_ing_prov_basicos'])){
				if(!isset($_SESSION['boleta_ing_prov_basicos']['idProveedor']) OR $_SESSION['boleta_ing_prov_basicos']['idProveedor']=='' ){       $error['idProveedor']      = 'error/No ha seleccionado el proveedor';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['N_Doc']) OR $_SESSION['boleta_ing_prov_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']) OR $_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la fecha de creación';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['Observaciones']) OR $_SESSION['boleta_ing_prov_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['idSistema']) OR $_SESSION['boleta_ing_prov_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['idUsuario']) OR $_SESSION['boleta_ing_prov_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['idTipo']) OR $_SESSION['boleta_ing_prov_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de boleta';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['fecha_auto']) OR $_SESSION['boleta_ing_prov_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['idEstado']) OR $_SESSION['boleta_ing_prov_basicos']['idEstado']=='' ){             $error['idEstado']         = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto']) OR $_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto']=='' ){   $error['Porc_Impuesto']    = 'error/No hay un porcentaje de retencion configurado';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la boleta de honorarios';
			}
			//productos o guias
			if (!isset($_SESSION['boleta_ing_prov_servicios'])){
				$error['idProducto']   = 'error/No se han asignado servicios';
			}
			//Se verifican productos
			if (isset($_SESSION['boleta_ing_prov_servicios'])){
				foreach ($_SESSION['boleta_ing_prov_servicios'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado servicios';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['boleta_ing_prov_basicos']['idSistema']) && $_SESSION['boleta_ing_prov_basicos']['idSistema']!=''){    $SIS_data  = "'".$_SESSION['boleta_ing_prov_basicos']['idSistema']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['idUsuario']) && $_SESSION['boleta_ing_prov_basicos']['idUsuario']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['idTipo']) && $_SESSION['boleta_ing_prov_basicos']['idTipo']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idTipo']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['boleta_ing_prov_basicos']['N_Doc']) && $_SESSION['boleta_ing_prov_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['N_Doc']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['Observaciones']) && $_SESSION['boleta_ing_prov_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['Observaciones']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['idProveedor']) && $_SESSION['boleta_ing_prov_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idProveedor']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['idEstado']) && $_SESSION['boleta_ing_prov_basicos']['idEstado']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['fecha_auto']) && $_SESSION['boleta_ing_prov_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['fecha_auto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['valor_neto'])&&$_SESSION['boleta_ing_prov_basicos']['valor_neto']!=''){            $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['valor_neto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['valor_imp'])&&$_SESSION['boleta_ing_prov_basicos']['valor_imp']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['valor_imp']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['valor_total'])&&$_SESSION['boleta_ing_prov_basicos']['valor_total']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['valor_total']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['idOcompra'])&&$_SESSION['boleta_ing_prov_basicos']['idOcompra']!=''){              $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idOcompra']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto'])&&$_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto']!=''){      $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['Porc_Impuesto']."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, idTipo, Creacion_fecha,
				Creacion_Semana, Creacion_mes, Creacion_ano, N_Doc, Observaciones, idProveedor, idEstado, fecha_auto,
				ValorNeto, Impuesto, ValorTotal, idOcompra, Porcentaje_Ret_Boletas';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los servicios
					if(isset($_SESSION['boleta_ing_prov_servicios'])){
						foreach ($_SESSION['boleta_ing_prov_servicios'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                  $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['idSistema']) && $_SESSION['boleta_ing_prov_basicos']['idSistema']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['idUsuario']) && $_SESSION['boleta_ing_prov_basicos']['idUsuario']!=''){    $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['idTipo']) && $_SESSION['boleta_ing_prov_basicos']['idTipo']!=''){          $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idTipo']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){              $SIS_data .= ",'".$producto['Nombre']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){              $SIS_data .= ",'".$producto['vTotal']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idExistencia']) && $producto['idExistencia']!=''){  $SIS_data .= ",'".$producto['idExistencia']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario,
							idTipo, Creacion_fecha, Creacion_mes, Creacion_ano, Nombre,vTotal, idExistencia';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_servicios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*******************************************************************/
							//Si existe la OC se actualizan los estados de esta
							if(isset($_SESSION['boleta_ing_prov_basicos']['idOcompra']) && $_SESSION['boleta_ing_prov_basicos']['idOcompra']!=''){

								//calculo
								$nuevo_total = $producto['vTotal'] + $producto['Total_ing'];
								//Actualizo
								$SIS_data = "Total_Ingresado='".$nuevo_total."'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas_empresas', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['boleta_ing_prov_archivos'])){
						foreach ($_SESSION['boleta_ing_prov_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['idSistema']) && $_SESSION['boleta_ing_prov_basicos']['idSistema']!=''){ $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idSistema']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['idUsuario']) && $_SESSION['boleta_ing_prov_basicos']['idUsuario']!=''){ $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idUsuario']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['idTipo']) && $_SESSION['boleta_ing_prov_basicos']['idTipo']!=''){       $SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['idTipo']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, idTipo, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']) && $_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['boleta_ing_prov_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'boleta_honorarios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['boleta_ing_prov_basicos']);
					unset($_SESSION['boleta_ing_prov_servicios']);
					unset($_SESSION['boleta_ing_prov_temporal']);
					unset($_SESSION['boleta_ing_prov_archivos']);
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
				/*******************************************************************/
				//variables
				$ndata_1 = 0;
				$ndata_2 = 0;
				$ndata_3 = 0;
				//Se verifica si el dato existe
				if(isset($indice)&&$indice!=''){
					$ndata_1 = db_select_nrows (false, 'idFacturacion', 'boleta_honorarios_facturacion', '', "WHERE idFacturacion='".$indice."' AND idEstado=2", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_2 = db_select_nrows (false, 'idPago', 'pagos_boletas_clientes', '', "idFacturacion='".$indice."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_3 = db_select_nrows (false, 'idPago', 'pagos_boletas_trabajadores', '', "idFacturacion='".$indice."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}else{
					$error['del'] = 'error/No existe OC a eliminar';
				}
				//generacion de errores
				if($ndata_1 > 0) {$error['ndata_1'] = 'error/La boleta ya tiene pagos ingresados, primero reverse los pagos antes de eliminar la boleta';}
				if($ndata_2 > 0) {$error['ndata_2'] = 'error/El documento que trata de eliminar ya posee pagos relacionados';}
				if($ndata_3 > 0) {$error['ndata_3'] = 'error/El documento que trata de eliminar ya posee pagos relacionados';}

				/*******************************************************************/

				//Si no hay errores ejecuto el codigo
				if(empty($error)){

					/********************************************************/
					//Actualizo la OC
					$arrServicios = array();
					$arrServicios = db_select_array (false, 'boleta_honorarios_facturacion_servicios.idTipo, boleta_honorarios_facturacion_servicios.vTotal, boleta_honorarios_facturacion_servicios.idExistencia, ocompra_listado_existencias_boletas_empresas.Total_Ingresado', 'boleta_honorarios_facturacion_servicios', 'LEFT JOIN `ocompra_listado_existencias_boletas_empresas`   ON ocompra_listado_existencias_boletas_empresas.idExistencia   = boleta_honorarios_facturacion_servicios.idExistencia', 'boleta_honorarios_facturacion_servicios.idFacturacion ='.$indice, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					foreach ($arrServicios as $serv) {
						if(isset($serv['idExistencia'])&&$serv['idExistencia']!=0){
							switch ($serv['idTipo']) {
								//Boleta Trabajadores
								case 1:
									//se actualizan los datos
									$SIS_data = "idUso='1'";
									$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas', 'idExistencia = "'.$serv['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									break;
								//Boleta Clientes
								case 2:
									break;
								//Boleta Empresas
								case 3:
									//calculo
									$nuevo_total = $serv['Total_Ingresado'] - $serv['vTotal'];
									//Actualizo
									$SIS_data = "Total_Ingresado='".$nuevo_total."'";
									/*******************************************************/
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas_empresas', 'idExistencia = "'.$serv['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									break;
							}
						}
					}

					/********************************************************/
					// Se trae un listado con todos los archivos relacionados
					$arrArchivos = array();
					$arrArchivos = db_select_array (false, 'Nombre', 'boleta_honorarios_facturacion_archivos', '', 'idFacturacion ='.$indice, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/********************************************************/
					//se borran los datos
					$resultado_1 = db_delete_data (false, 'boleta_honorarios_facturacion', 'idFacturacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_2 = db_delete_data (false, 'boleta_honorarios_facturacion_archivos', 'idFacturacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_3 = db_delete_data (false, 'boleta_honorarios_facturacion_historial', 'idFacturacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_4 = db_delete_data (false, 'boleta_honorarios_facturacion_servicios', 'idFacturacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true){

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
	}

?>
