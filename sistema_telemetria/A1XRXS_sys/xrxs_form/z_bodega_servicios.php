<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-227).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idProveedor']))       $idProveedor         = $_POST['idProveedor'];
	if (!empty($_POST['idDocumentos']))      $idDocumentos        = $_POST['idDocumentos'];
	if (!empty($_POST['N_Doc']))             $N_Doc               = $_POST['N_Doc'];
	if (!empty($_POST['Creacion_fecha']))    $Creacion_fecha      = $_POST['Creacion_fecha'];
	if (!empty($_POST['Observaciones']))     $Observaciones       = $_POST['Observaciones'];
	if (!empty($_POST['idSistema']))         $idSistema           = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))         $idUsuario           = $_POST['idUsuario'];
	if (!empty($_POST['idTipo']))            $idTipo              = $_POST['idTipo'];
	if (!empty($_POST['idServicio']))        $idServicio          = $_POST['idServicio'];
	if (!empty($_POST['ValorTotal']))        $ValorTotal          = $_POST['ValorTotal'];
	if (!empty($_POST['oldItemID']))         $oldItemID           = $_POST['oldItemID'];
	if (!empty($_POST['idImpuesto']))        $idImpuesto          = $_POST['idImpuesto'];
	if (!empty($_POST['idDocPago']))         $idDocPago           = $_POST['idDocPago'];
	if (!empty($_POST['N_DocPago']))         $N_DocPago           = $_POST['N_DocPago'];
	if (!empty($_POST['F_Pago']))            $F_Pago              = $_POST['F_Pago'];
	if (!empty($_POST['MontoPagado']))       $MontoPagado         = $_POST['MontoPagado'];
	if (!empty($_POST['montoPactado']))      $montoPactado        = $_POST['montoPactado'];
	if (!empty($_POST['idFacturacion']))     $idFacturacion       = $_POST['idFacturacion'];
	if (!empty($_POST['idCliente']))         $idCliente           = $_POST['idCliente'];
	if (!empty($_POST['idTrabajador']))      $idTrabajador        = $_POST['idTrabajador'];
	if (!empty($_POST['fecha_auto']))        $fecha_auto          = $_POST['fecha_auto'];
	if (!empty($_POST['Nombre']))            $Nombre              = $_POST['Nombre'];
	if (!empty($_POST['vTotal']))            $vTotal              = $_POST['vTotal'];
	if (!empty($_POST['oldidProducto']))     $oldidProducto       = $_POST['oldidProducto'];
	if (!empty($_POST['idOcompra']))         $idOcompra           = $_POST['idOcompra'];
	if (!empty($_POST['Cantidad_ing']))      $Cantidad_ing        = $_POST['Cantidad_ing'];
	if (!empty($_POST['Cantidad_eg']))       $Cantidad_eg         = $_POST['Cantidad_eg'];
	if (!empty($_POST['idFrecuencia']))      $idFrecuencia        = $_POST['idFrecuencia'];
	if (!empty($_POST['vUnitario']))         $vUnitario           = $_POST['vUnitario'];
	if (!empty($_POST['OC_Ventas']))         $OC_Ventas           = $_POST['OC_Ventas'];
	if (!empty($_POST['idGuia']))            $idGuia              = $_POST['idGuia'];
	if (!empty($_POST['idCentroCosto']))     $idCentroCosto       = $_POST['idCentroCosto'];
	if (!empty($_POST['idLevel_1']))         $idLevel_1           = $_POST['idLevel_1'];
	if (!empty($_POST['idLevel_2']))         $idLevel_2           = $_POST['idLevel_2'];
	if (!empty($_POST['idLevel_3']))         $idLevel_3           = $_POST['idLevel_3'];
	if (!empty($_POST['idLevel_4']))         $idLevel_4           = $_POST['idLevel_4'];
	if (!empty($_POST['idLevel_5']))         $idLevel_5           = $_POST['idLevel_5'];
	if (!empty($_POST['fecha_fact_desde']))  $fecha_fact_desde    = $_POST['fecha_fact_desde'];
	if (!empty($_POST['fecha_fact_hasta']))  $fecha_fact_hasta    = $_POST['fecha_fact_hasta'];
	if (!empty($_POST['idUsoIVA']))          $idUsoIVA            = $_POST['idUsoIVA'];

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
			case 'idProveedor':      if(empty($idProveedor)){      $error['idProveedor']     = 'error/No ha ingresado el id';}break;
			case 'idDocumentos':     if(empty($idDocumentos)){     $error['idDocumentos']    = 'error/No ha seleccionado el tipo de documento';}break;
			case 'N_Doc':            if(empty($N_Doc)){            $error['N_Doc']           = 'error/No ha ingresado el numero de documento';}break;
			case 'Creacion_fecha':   if(empty($Creacion_fecha)){   $error['Creacion_fecha']  = 'error/No ha ingresado la fecha del documento';}break;
			case 'Observaciones':    if(empty($Observaciones)){    $error['Observaciones']   = 'error/No ha ingresado la observacion';}break;
			case 'idSistema':        if(empty($idSistema)){        $error['idSistema']       = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':        if(empty($idUsuario)){        $error['idUsuario']       = 'error/No ha seleccionado el usuario';}break;
			case 'idTipo':           if(empty($idTipo)){           $error['idTipo']          = 'error/No ha seleccionado el tipo';}break;
			case 'idServicio':       if(empty($idServicio)){       $error['idServicio']      = 'error/No ha seleccionado el servicio';}break;
			case 'ValorTotal':       if(empty($ValorTotal)){       $error['ValorTotal']      = 'error/No ha ingresado el valor total';}break;
			case 'oldItemID':        if(empty($oldItemID)){        $error['oldItemID']       = 'error/No ha seleccionado el item antiguo';}break;
			case 'idImpuesto':       if(empty($idImpuesto)){       $error['idImpuesto']      = 'error/No ha seleccionado el impuesto';}break;
			case 'idDocPago':        if(empty($idDocPago)){        $error['idDocPago']       = 'error/No ha seleccionado el documento de pago';}break;
			case 'N_DocPago':        if(empty($N_DocPago)){        $error['N_DocPago']       = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'F_Pago':           if(empty($F_Pago)){           $error['F_Pago']          = 'error/No ha ingresado la fecha de pago';}break;
			case 'MontoPagado':      if(empty($MontoPagado)){      $error['MontoPagado']     = 'error/No ha ingresado el monto pagado';}break;
			case 'montoPactado':     if(empty($montoPactado)){     $error['montoPactado']    = 'error/No ha ingresado el monto pactado';}break;
			case 'idFacturacion':    if(empty($idFacturacion)){    $error['idFacturacion']   = 'error/No ha seleccionado la facturacion';}break;
			case 'idCliente':        if(empty($idCliente)){        $error['idCliente']       = 'error/No ha seleccionado el cliente';}break;
			case 'idTrabajador':     if(empty($idTrabajador)){     $error['idTrabajador']    = 'error/No ha seleccionado el trabajador';}break;
			case 'fecha_auto':       if(empty($fecha_auto)){       $error['fecha_auto']      = 'error/No ha ingresado la fecha de creación';}break;
			case 'Nombre':           if(empty($Nombre)){           $error['Nombre']          = 'error/No ha ingresado el nombre';}break;
			case 'vTotal':           if(empty($vTotal)){           $error['vTotal']          = 'error/No ha ingresado el valor total';}break;
			case 'oldidProducto':    if(empty($oldidProducto)){    $error['oldidProducto']   = 'error/No ha ingresado el id antiguo';}break;
			case 'idOcompra':        if(empty($idOcompra)){        $error['idOcompra']       = 'error/No ha ingresado la OC';}break;
			case 'Cantidad_ing':     if(empty($Cantidad_ing)){     $error['Cantidad_ing']    = 'error/No ha ingresado la cantidad';}break;
			case 'Cantidad_eg':      if(empty($Cantidad_eg)){      $error['Cantidad_eg']     = 'error/No ha ingresado la cantidad';}break;
			case 'idFrecuencia':     if(empty($idFrecuencia)){     $error['idFrecuencia']    = 'error/No ha ingresado la fecuencia';}break;
			case 'vUnitario':        if(empty($vUnitario)){        $error['vUnitario']       = 'error/No ha ingresado el valor unitario';}break;
			case 'OC_Ventas':        if(empty($OC_Ventas)){        $error['OC_Ventas']       = 'error/No ha ingresado la OC Relacionada';}break;
			case 'idGuia':           if(empty($idGuia)){           $error['idGuia']          = 'error/No ha seleccionado la guia relacionada';}break;

			case 'idCentroCosto':    if(empty($idCentroCosto)){    $error['idCentroCosto']   = 'error/No ha seleccionado el Centro de Costo';}break;
			case 'idLevel_1':        if(empty($idLevel_1)){        $error['idLevel_1']       = 'error/No ha seleccionado el Nivel 1';}break;
			case 'idLevel_2':        if(empty($idLevel_2)){        $error['idLevel_2']       = 'error/No ha seleccionado el Nivel 2';}break;
			case 'idLevel_3':        if(empty($idLevel_3)){        $error['idLevel_3']       = 'error/No ha seleccionado el Nivel 3';}break;
			case 'idLevel_4':        if(empty($idLevel_4)){        $error['idLevel_4']       = 'error/No ha seleccionado el Nivel 4';}break;
			case 'idLevel_5':        if(empty($idLevel_5)){        $error['idLevel_5']       = 'error/No ha seleccionado el Nivel 5';}break;

			case 'fecha_fact_desde':  if(empty($fecha_fact_desde)){  $error['fecha_fact_desde'] = 'error/No ha ingresado la fecha desde de facturacion';}break;
			case 'fecha_fact_hasta':  if(empty($fecha_fact_hasta)){  $error['fecha_fact_hasta'] = 'error/No ha ingresado la fecha hasta de facturacion';}break;
			case 'idUsoIVA':          if(empty($idUsoIVA)){          $error['idUsoIVA']         = 'error/No ha seleccionado el uso del IVA';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Nombre) && $Nombre!=''){               $Nombre        = EstandarizarInput($Nombre);}

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
/*                                                       INGRESOS                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_ingreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['servicios_ing_basicos']);
				unset($_SESSION['servicios_ing_productos']);
				unset($_SESSION['servicios_ing_temporal']);
				unset($_SESSION['servicios_ing_impuestos']);
				unset($_SESSION['servicios_ing_descuentos']);
				unset($_SESSION['servicios_ing_guias']);
				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['servicios_ing_archivos'])){
					foreach ($_SESSION['servicios_ing_archivos'] as $key => $producto){
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
				unset($_SESSION['servicios_ing_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor) && $idProveedor!=''){            $_SESSION['servicios_ing_basicos']['idProveedor']       = $idProveedor;       }else{$_SESSION['servicios_ing_basicos']['idProveedor']       = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){          $_SESSION['servicios_ing_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['servicios_ing_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                        $_SESSION['servicios_ing_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['servicios_ing_basicos']['N_Doc']             = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){      $_SESSION['servicios_ing_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['servicios_ing_basicos']['Creacion_fecha']    = '';}
				if(isset($Observaciones) && $Observaciones!=''){        $_SESSION['servicios_ing_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['servicios_ing_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                $_SESSION['servicios_ing_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['servicios_ing_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                $_SESSION['servicios_ing_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['servicios_ing_basicos']['idUsuario']         = '';}
				if(isset($idTipo) && $idTipo!=''){                      $_SESSION['servicios_ing_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['servicios_ing_basicos']['idTipo']            = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){              $_SESSION['servicios_ing_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['servicios_ing_basicos']['fecha_auto']        = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){  $_SESSION['servicios_ing_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['servicios_ing_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){  $_SESSION['servicios_ing_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['servicios_ing_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                  $_SESSION['servicios_ing_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['servicios_ing_basicos']['idUsoIVA']          = '';}
				//datos basicos vacios
				$_SESSION['servicios_ing_basicos']['Pago_fecha']      = '0000-00-00';
				$_SESSION['servicios_ing_basicos']['idOcompra']       = '';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['servicios_ing_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['servicios_ing_basicos']['idCentroCosto'] = 0;
				$_SESSION['servicios_ing_basicos']['idLevel_1']     = 0;
				$_SESSION['servicios_ing_basicos']['idLevel_2']     = 0;
				$_SESSION['servicios_ing_basicos']['idLevel_3']     = 0;
				$_SESSION['servicios_ing_basicos']['idLevel_4']     = 0;
				$_SESSION['servicios_ing_basicos']['idLevel_5']     = 0;

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['servicios_ing_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['servicios_ing_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_ing_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_ing_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['servicios_ing_basicos']['Proveedor'] = '';
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
			unset($_SESSION['servicios_ing_basicos']);
			unset($_SESSION['servicios_ing_productos']);
			unset($_SESSION['servicios_ing_temporal']);
			unset($_SESSION['servicios_ing_impuestos']);
			unset($_SESSION['servicios_ing_descuentos']);
			unset($_SESSION['servicios_ing_guias']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['servicios_ing_archivos'])){
				foreach ($_SESSION['servicios_ing_archivos'] as $key => $producto){
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
			unset($_SESSION['servicios_ing_archivos']);

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
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['servicios_ing_temporal']);
				//se borran datos por seguridad
				unset($_SESSION['servicios_ing_productos']);
				unset($_SESSION['servicios_ing_temporal']);
				unset($_SESSION['servicios_ing_impuestos']);
				unset($_SESSION['servicios_ing_descuentos']);
				unset($_SESSION['servicios_ing_guias']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor) && $idProveedor!=''){            $_SESSION['servicios_ing_basicos']['idProveedor']       = $idProveedor;       }else{$_SESSION['servicios_ing_basicos']['idProveedor']       = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){          $_SESSION['servicios_ing_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['servicios_ing_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                        $_SESSION['servicios_ing_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['servicios_ing_basicos']['N_Doc']             = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){      $_SESSION['servicios_ing_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['servicios_ing_basicos']['Creacion_fecha']    = '';}
				if(isset($Observaciones) && $Observaciones!=''){        $_SESSION['servicios_ing_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['servicios_ing_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                $_SESSION['servicios_ing_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['servicios_ing_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                $_SESSION['servicios_ing_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['servicios_ing_basicos']['idUsuario']         = '';}
				if(isset($idTipo) && $idTipo!=''){                      $_SESSION['servicios_ing_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['servicios_ing_basicos']['idTipo']            = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){              $_SESSION['servicios_ing_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['servicios_ing_basicos']['fecha_auto']        = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){  $_SESSION['servicios_ing_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['servicios_ing_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){  $_SESSION['servicios_ing_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['servicios_ing_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                  $_SESSION['servicios_ing_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['servicios_ing_basicos']['idUsoIVA']          = '';}
				//datos basicos vacios
				$_SESSION['servicios_ing_basicos']['Pago_fecha']      = '0000-00-00';
				$_SESSION['servicios_ing_basicos']['idOcompra']       = '';

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['servicios_ing_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['servicios_ing_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_ing_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_ing_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['servicios_ing_basicos']['Proveedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['servicios_ing_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['servicios_ing_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'addfpago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$valor    = $_GET['val_select'];

			//Se comprueba las fechas
			if($_SESSION['servicios_ing_basicos']['Creacion_fecha']>$valor){
				$error['ndata_1'] = 'error/La fecha de vencimiento es anterior a la fecha de creación';
			}

			//valido que no esten vacios
			if(empty($valor)){  $error['valor']  = 'error/No ha ingresado una fecha de vencimiento';}

			if(empty($error)){

				$_SESSION['servicios_ing_basicos']['Pago_fecha'] = $valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'delfpago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				$_SESSION['servicios_ing_basicos']['Pago_fecha'] = '0000-00-00';

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_prod_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el producto ya existe
			if(isset($_SESSION['servicios_ing_productos'][$idServicio])&&$_SESSION['servicios_ing_productos'][$idServicio]>0){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio = "'.$idServicio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				$_SESSION['servicios_ing_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_ing_productos'][$idServicio]['Cantidad_ing']  = $Cantidad_ing;
				$_SESSION['servicios_ing_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_ing_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_ing_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_ing_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_ing_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_productos'][$idServicio])&&$_SESSION['servicios_ing_productos'][$idServicio]>0&&$_SESSION['servicios_ing_productos'][$idServicio]!=$_SESSION['servicios_ing_productos'][$oldItemID]){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}
			//Si la cantidad es determinada por una OC verificar si la modificacion no supera el maximo permitido
			if(isset($_SESSION['servicios_ing_basicos']['idOcompra'])&&$_SESSION['servicios_ing_basicos']['idOcompra']!=''){
				if($_SESSION['servicios_ing_productos'][$oldItemID]['cant_max']<($Cantidad_ing + $_SESSION['servicios_ing_productos'][$oldItemID]['cant_ingresada'])){
					$error['productos'] = 'error/No puede ingresar una cantidad superior a la solicitada en la OC (Maximo '.Cantidades_decimales_justos($_SESSION['servicios_ing_productos'][$oldItemID]['cant_max']-$_SESSION['servicios_ing_productos'][$oldItemID]['cant_ingresada']).')';
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio = "'.$idServicio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Guardo variables si existe una OC
				$temp_idExistencia     = 0;
				$temp_idFrecuencia     = 0;
				$temp_cant_ingresada   = 0;
				$temp_cant_max         = 0;

				if(isset($_SESSION['servicios_ing_basicos']['idOcompra'])&&$_SESSION['servicios_ing_basicos']['idOcompra']!=''){
					$temp_idExistencia     = $_SESSION['servicios_ing_productos'][$oldItemID]['idExistencia'];
					$temp_idFrecuencia     = $_SESSION['servicios_ing_productos'][$oldItemID]['idFrecuencia'];
					$temp_cant_ingresada   = $_SESSION['servicios_ing_productos'][$oldItemID]['cant_ingresada'];
					$temp_cant_max         = $_SESSION['servicios_ing_productos'][$oldItemID]['cant_max'];
				}

				//Borro el producto
				unset($_SESSION['servicios_ing_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['servicios_ing_productos'][$idServicio]['idServicio']       = $idServicio;
				$_SESSION['servicios_ing_productos'][$idServicio]['Cantidad_ing']     = $Cantidad_ing;
				$_SESSION['servicios_ing_productos'][$idServicio]['ValorIngreso']     = $vUnitario;
				$_SESSION['servicios_ing_productos'][$idServicio]['ValorTotal']       = $ValorTotal;
				$_SESSION['servicios_ing_productos'][$idServicio]['idFrecuencia']     = $idFrecuencia;
				$_SESSION['servicios_ing_productos'][$idServicio]['idExistencia']     = $temp_idExistencia;
				$_SESSION['servicios_ing_productos'][$idServicio]['idFrecuencia']     = $temp_idFrecuencia;
				$_SESSION['servicios_ing_productos'][$idServicio]['cant_ingresada']   = $temp_cant_ingresada;
				$_SESSION['servicios_ing_productos'][$idServicio]['cant_max']         = $temp_cant_max;
				$_SESSION['servicios_ing_productos'][$idServicio]['Servicio']         = $rowServicio['Nombre'];
				$_SESSION['servicios_ing_productos'][$idServicio]['Frecuencia']       = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro el producto
			unset($_SESSION['servicios_ing_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_guia':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_guias'][$idGuia])&&$_SESSION['servicios_ing_guias'][$idGuia]>0){
				$error['productos'] = 'error/La guia que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos de la guia seleccionada
				$rowGuia = db_select_data (false, 'N_Doc, ValorNeto', 'bodegas_servicios_facturacion', '', 'idFacturacion = "'.$idGuia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$_SESSION['servicios_ing_guias'][$idGuia]['idGuia']     = $idGuia;
				$_SESSION['servicios_ing_guias'][$idGuia]['N_Doc']      = $rowGuia['N_Doc'];
				$_SESSION['servicios_ing_guias'][$idGuia]['ValorNeto']  = $rowGuia['ValorNeto'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_guia':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_guias'][$_GET['del_guia']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_impuestos'][$idImpuesto])&&$_SESSION['servicios_ing_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_ing_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_impuestos'][$_GET['del_impuesto']]);

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
			if(isset($_SESSION['servicios_ing_archivos'])){
				foreach ($_SESSION['servicios_ing_archivos'] as $key => $trabajos){
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
						$sufijo = 'servicios_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['servicios_ing_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['servicios_ing_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['servicios_ing_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['servicios_ing_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['servicios_ing_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'new_desc_ing':

			//verificar si existe algun otro dato
			if(!isset($_SESSION['servicios_ing_descuentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['servicios_ing_descuentos'] as $key => $producto){
					$idInterno++;
				}
			}
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_ing_descuentos'][$idInterno]['idDescuento']  = $idInterno;
				$_SESSION['servicios_ing_descuentos'][$idInterno]['Nombre']       = $Nombre;
				$_SESSION['servicios_ing_descuentos'][$idInterno]['vTotal']       = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_desc_ing':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se crea el nuevo producto
				$_SESSION['servicios_ing_descuentos'][$oldidProducto]['idDescuento'] = $oldidProducto;
				$_SESSION['servicios_ing_descuentos'][$oldidProducto]['Nombre'] = $Nombre;
				$_SESSION['servicios_ing_descuentos'][$oldidProducto]['vTotal'] = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_desc_ing':

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_descuentos'][$_GET['del_descuento']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'add_OC':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			//Se verifica si existe la orden de compra
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)){
				$ndata_1 = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', "idOcompra='".$idOcompra."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1==0) {$error['ndata_1'] = 'error/No existen Ordenes de Compra con ese numero';}
			//Si la OC existe se verifica si tiene productos para asignar
			if($ndata_1!=0) {
				$ndata_2 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_servicios', '', "idOcompra='".$idOcompra."' AND Cantidad > cant_ingresada", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_2==0) {$error['ndata_2'] = 'error/No existen Servicios a asignar';}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se borran los productos
				unset($_SESSION['servicios_ing_productos']);

				$SIS_query = '
				ocompra_listado_existencias_servicios.idExistencia,
				ocompra_listado_existencias_servicios.idServicio,
				ocompra_listado_existencias_servicios.Cantidad,
				ocompra_listado_existencias_servicios.vUnitario,
				ocompra_listado_existencias_servicios.vTotal,
				ocompra_listado_existencias_servicios.idFrecuencia,
				ocompra_listado_existencias_servicios.cant_ingresada,
				servicios_listado.Nombre AS Servicio,
				core_tiempo_frecuencia.Nombre AS Frecuencia';
				$SIS_join  = '
				LEFT JOIN `servicios_listado`       ON servicios_listado.idServicio          = ocompra_listado_existencias_insumos.idServicio
				LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia   = ocompra_listado_existencias_insumos.idFrecuencia';
				$SIS_where = 'ocompra_listado_existencias_servicios.idOcompra="'.$idOcompra.'"
				AND ocompra_listado_existencias_servicios.Cantidad > ocompra_listado_existencias_servicios.cant_ingresada';
				$SIS_order = 0;
				$arrProductos = array();
				$arrProductos = db_select_array (false, $SIS_query,
												'ocompra_listado_existencias_servicios',
												$SIS_join,
												$SIS_where,
												$SIS_order,
												$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Guardo la OC
				$_SESSION['servicios_ing_basicos']['idOcompra'] = $idOcompra;

				//Se guardan los datos
				foreach ($arrProductos as $prod) {
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['idExistencia']    = $prod['idExistencia'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['idServicio']      = $prod['idServicio'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['Cantidad_ing']    = $prod['Cantidad'] - $prod['cant_ingresada'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['ValorIngreso']    = $prod['vUnitario'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['ValorTotal']      = $prod['vTotal'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['idFrecuencia']    = $prod['idFrecuencia'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['cant_ingresada']  = $prod['cant_ingresada'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['cant_max']        = $prod['Cantidad'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['Servicio']        = $prod['Servicio'];
					$_SESSION['servicios_ing_productos'][$prod['idServicio']]['Frecuencia']      = $prod['Frecuencia'];
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'ing_bodega':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['servicios_ing_basicos'])){
				if(!isset($_SESSION['servicios_ing_basicos']['idDocumentos']) OR $_SESSION['servicios_ing_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['servicios_ing_basicos']['N_Doc']) OR $_SESSION['servicios_ing_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha seleccionado el area';}
				if(!isset($_SESSION['servicios_ing_basicos']['Observaciones']) OR $_SESSION['servicios_ing_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha seleccionado la maquina';}
				if(!isset($_SESSION['servicios_ing_basicos']['idSistema']) OR $_SESSION['servicios_ing_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha ingresado el id del usuario';}
				if(!isset($_SESSION['servicios_ing_basicos']['idUsuario']) OR $_SESSION['servicios_ing_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha ingresado el id del estado';}
				if(!isset($_SESSION['servicios_ing_basicos']['Creacion_fecha']) OR $_SESSION['servicios_ing_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la prioridad';}
				if(!isset($_SESSION['servicios_ing_basicos']['idTipo']) OR $_SESSION['servicios_ing_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de trabajo';}
				if(!isset($_SESSION['servicios_ing_basicos']['idUsoIVA']) OR $_SESSION['servicios_ing_basicos']['idUsoIVA']=='' ){             $error['idUsoIVA']         = 'error/No ha seleccionado la exencion de IVA';}
				//compruebo que sea una factura y que tenga fecha de pago
				if(isset($_SESSION['servicios_ing_basicos']['idDocumentos']) && $_SESSION['servicios_ing_basicos']['idDocumentos']==2 ){
					if(!isset($_SESSION['servicios_ing_basicos']['Pago_fecha']) OR $_SESSION['servicios_ing_basicos']['Pago_fecha']=='' OR $_SESSION['servicios_ing_basicos']['Pago_fecha']=='0000-00-00' ){
						$error['Pago_fecha']  = 'error/No ha ingresado la fecha de vencimiento de la factura';
					}
				}
				//se verifica el uso del iva
				if(isset($_SESSION['servicios_ing_basicos']['idUsoIVA'])&&$_SESSION['servicios_ing_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['servicios_ing_impuestos'])){
						$error['Pago_fecha']  = 'error/No ha seleccionado un impuesto para la factura';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}
			//productos o guias
			if (!isset($_SESSION['servicios_ing_productos'])&&!isset($_SESSION['servicios_ing_guias'])){
				$error['idProducto']   = 'error/No se han asignado Servicios ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['servicios_ing_productos'])){
				foreach ($_SESSION['servicios_ing_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['servicios_ing_guias'])){
				foreach ($_SESSION['servicios_ing_guias'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['trabajos'] = 'error/No se han asignado Servicios ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

			//Se guardan los datos basicos
				if(isset($_SESSION['servicios_ing_basicos']['idSistema']) && $_SESSION['servicios_ing_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['servicios_ing_basicos']['idSistema']."'";      }else{$SIS_data  = "''";}
				if(isset($_SESSION['servicios_ing_basicos']['idUsuario']) && $_SESSION['servicios_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['servicios_ing_basicos']['idDocumentos']) && $_SESSION['servicios_ing_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idDocumentos']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['N_Doc']) && $_SESSION['servicios_ing_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['N_Doc']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idTipo']) && $_SESSION['servicios_ing_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['Observaciones']) && $_SESSION['servicios_ing_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idProveedor']) && $_SESSION['servicios_ing_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idProveedor']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['Pago_fecha']) && $_SESSION['servicios_ing_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['servicios_ing_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_ing_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['servicios_ing_basicos']['fecha_auto']) && $_SESSION['servicios_ing_basicos']['fecha_auto']!=''){                $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['valor_neto_fact'])&&$_SESSION['servicios_ing_basicos']['valor_neto_fact']!=''){        $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['valor_neto_fact']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['valor_neto_imp'])&&$_SESSION['servicios_ing_basicos']['valor_neto_imp']!=''){          $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['valor_neto_imp']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['valor_total_fact'])&&$_SESSION['servicios_ing_basicos']['valor_total_fact']!=''){      $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['valor_total_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][1]['valor'])&&$_SESSION['servicios_ing_impuestos'][1]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][1]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][2]['valor'])&&$_SESSION['servicios_ing_impuestos'][2]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][2]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][3]['valor'])&&$_SESSION['servicios_ing_impuestos'][3]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][3]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][4]['valor'])&&$_SESSION['servicios_ing_impuestos'][4]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][4]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][5]['valor'])&&$_SESSION['servicios_ing_impuestos'][5]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][5]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][6]['valor'])&&$_SESSION['servicios_ing_impuestos'][6]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][6]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][7]['valor'])&&$_SESSION['servicios_ing_impuestos'][7]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][7]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][8]['valor'])&&$_SESSION['servicios_ing_impuestos'][8]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][8]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][9]['valor'])&&$_SESSION['servicios_ing_impuestos'][9]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][9]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_impuestos'][10]['valor'])&&$_SESSION['servicios_ing_impuestos'][10]['valor']!=''){                $SIS_data .= ",'".$_SESSION['servicios_ing_impuestos'][10]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idOcompra']) && $_SESSION['servicios_ing_basicos']['idOcompra']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idOcompra']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idCentroCosto']) && $_SESSION['servicios_ing_basicos']['idCentroCosto']!=''){          $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idCentroCosto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idLevel_1']) && $_SESSION['servicios_ing_basicos']['idLevel_1']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idLevel_1']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idLevel_2']) && $_SESSION['servicios_ing_basicos']['idLevel_2']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idLevel_2']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idLevel_3']) && $_SESSION['servicios_ing_basicos']['idLevel_3']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idLevel_3']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idLevel_4']) && $_SESSION['servicios_ing_basicos']['idLevel_4']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idLevel_4']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idLevel_5']) && $_SESSION['servicios_ing_basicos']['idLevel_5']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idLevel_5']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['fecha_fact_desde']) && $_SESSION['servicios_ing_basicos']['fecha_fact_desde']!=''){    $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['fecha_fact_desde']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['fecha_fact_hasta']) && $_SESSION['servicios_ing_basicos']['fecha_fact_hasta']!=''){    $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['fecha_fact_hasta']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_basicos']['idUsoIVA']) && $_SESSION['servicios_ing_basicos']['idUsoIVA']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idUsoIVA']."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idDocumentos, N_Doc, idTipo,Observaciones, idProveedor, Pago_fecha,Pago_dia, Pago_Semana, Pago_mes,
				Pago_ano, idEstado, fecha_auto, ValorNeto, ValorNetoImp, ValorTotal, Impuesto_01, Impuesto_02, Impuesto_03,
				Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08, Impuesto_09, Impuesto_10, idOcompra,
				idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5, fecha_fact_desde, fecha_fact_hasta,
				idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['servicios_ing_productos'])){
						foreach ($_SESSION['servicios_ing_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_basicos']['idSistema']) && $_SESSION['servicios_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['idUsuario']) && $_SESSION['servicios_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['servicios_ing_basicos']['idDocumentos']) && $_SESSION['servicios_ing_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idDocumentos']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['N_Doc']) && $_SESSION['servicios_ing_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['idTipo']) && $_SESSION['servicios_ing_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){                                                            $SIS_data .= ",'".$producto['idServicio']."'";                                  }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_ing']) && $producto['Cantidad_ing']!=''){                                                        $SIS_data .= ",'".$producto['Cantidad_ing']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){                                                        $SIS_data .= ",'".$producto['idFrecuencia']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                        $SIS_data .= ",'".$producto['ValorIngreso']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                            $SIS_data .= ",'".$producto['ValorTotal']."'";                                  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['idProveedor']) && $_SESSION['servicios_ing_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idProveedor']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['fecha_auto']) && $_SESSION['servicios_ing_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario,
							Creacion_fecha, Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idServicio, Cantidad_ing, idFrecuencia, Valor,ValorTotal,
							idProveedor, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*******************************************************************/
							//Actualizo el valor de los productos
							$SIS_data = "idServicio='".$producto['idServicio']."'";
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso'] != ''&&isset($_SESSION['servicios_ing_basicos']['idProveedor']) && $_SESSION['servicios_ing_basicos']['idProveedor']!=''){
								$SIS_data .= ",idProveedor='".$_SESSION['servicios_ing_basicos']['idProveedor']."'";
								$SIS_data .= ",ValorIngreso='".$producto['ValorIngreso']."'";
							}
							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'servicios_listado', 'idServicio = "'.$producto['idServicio'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*******************************************************************/
							//Actualizo lo entregado de la solicitud de la OC si esta existe
							if(isset($_SESSION['servicios_ing_basicos']['idOcompra'])&&$_SESSION['servicios_ing_basicos']['idOcompra']){
								$nueva_cant = $producto['cant_ingresada'] + $producto['Cantidad_ing'];
								$SIS_data = "idExistencia='".$producto['idExistencia']."'";
								$SIS_data .= ",cant_ingresada='".$nueva_cant."'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Se actualizan las guias a un estado de pago y con relacion al documento recien generado
					if (isset($_SESSION['servicios_ing_guias'])){
						foreach ($_SESSION['servicios_ing_guias'] as $key => $guias){
							//filtro
							if(isset($ultimo_id) && $ultimo_id!=''){

								$SIS_data  = "DocRel='".$ultimo_id."'";
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_servicios_facturacion', 'idFacturacion = "'.$guias['idGuia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Descuento
					if(isset($_SESSION['servicios_ing_descuentos'])){
						foreach ($_SESSION['servicios_ing_descuentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_basicos']['idSistema']) && $_SESSION['servicios_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['idUsuario']) && $_SESSION['servicios_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_descuentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['servicios_ing_archivos'])){
						foreach ($_SESSION['servicios_ing_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_basicos']['idSistema']) && $_SESSION['servicios_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['idUsuario']) && $_SESSION['servicios_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['servicios_ing_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['servicios_ing_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['servicios_ing_basicos']);
					unset($_SESSION['servicios_ing_productos']);
					unset($_SESSION['servicios_ing_temporal']);
					unset($_SESSION['servicios_ing_impuestos']);
					unset($_SESSION['servicios_ing_archivos']);
					unset($_SESSION['servicios_ing_descuentos']);
					unset($_SESSION['servicios_ing_guias']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                        EGRESOS                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_egreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se verifica si el dato existe
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idDocumentos)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['servicios_egr_basicos']);
				unset($_SESSION['servicios_egr_productos']);
				unset($_SESSION['servicios_egr_temporal']);
				unset($_SESSION['servicios_egr_guias']);
				unset($_SESSION['servicios_egr_impuestos']);
				unset($_SESSION['servicios_egr_descuentos']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['servicios_egr_archivos'])){
					foreach ($_SESSION['servicios_egr_archivos'] as $key => $producto){
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
				unset($_SESSION['servicios_egr_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['servicios_egr_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['servicios_egr_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['servicios_egr_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['servicios_egr_basicos']['N_Doc']             = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['servicios_egr_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['servicios_egr_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['servicios_egr_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['servicios_egr_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['servicios_egr_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['servicios_egr_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['servicios_egr_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['servicios_egr_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['servicios_egr_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['servicios_egr_basicos']['idTipo']            = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['servicios_egr_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['servicios_egr_basicos']['idCliente']         = '';}
				if(isset($idTrabajador) && $idTrabajador!=''){           $_SESSION['servicios_egr_basicos']['idTrabajador']      = $idTrabajador;      }else{$_SESSION['servicios_egr_basicos']['idTrabajador']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['servicios_egr_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['servicios_egr_basicos']['fecha_auto']        = '';}
				if(isset($OC_Ventas) && $OC_Ventas!=''){                 $_SESSION['servicios_egr_basicos']['OC_Ventas']         = $OC_Ventas;         }else{$_SESSION['servicios_egr_basicos']['OC_Ventas']         = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){   $_SESSION['servicios_egr_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['servicios_egr_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){   $_SESSION['servicios_egr_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['servicios_egr_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                   $_SESSION['servicios_egr_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['servicios_egr_basicos']['idUsoIVA']          = '';}
				//Fecha de vencimiento
				$_SESSION['servicios_egr_basicos']['Pago_fecha']      = '0000-00-00';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['servicios_egr_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['servicios_egr_basicos']['idCentroCosto'] = 0;
				$_SESSION['servicios_egr_basicos']['idLevel_1']     = 0;
				$_SESSION['servicios_egr_basicos']['idLevel_2']     = 0;
				$_SESSION['servicios_egr_basicos']['idLevel_3']     = 0;
				$_SESSION['servicios_egr_basicos']['idLevel_4']     = 0;
				$_SESSION['servicios_egr_basicos']['idLevel_5']     = 0;

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['servicios_egr_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['servicios_egr_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_egr_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_egr_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['servicios_egr_basicos']['Cliente'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowVendedor = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['Vendedor'] = $rowVendedor['Nombre'].' '.$rowVendedor['ApellidoPat'].' '.$rowVendedor['ApellidoMat'];
				}else{
					$_SESSION['servicios_egr_basicos']['Vendedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_basicos']);
			unset($_SESSION['servicios_egr_productos']);
			unset($_SESSION['servicios_egr_temporal']);
			unset($_SESSION['servicios_egr_guias']);
			unset($_SESSION['servicios_egr_impuestos']);
			unset($_SESSION['servicios_egr_descuentos']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['servicios_egr_archivos'])){
				foreach ($_SESSION['servicios_egr_archivos'] as $key => $producto){
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
			unset($_SESSION['servicios_egr_archivos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['servicios_egr_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['servicios_egr_productos']);
				unset($_SESSION['servicios_egr_guias']);
				unset($_SESSION['servicios_egr_impuestos']);
				unset($_SESSION['servicios_egr_descuentos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['servicios_egr_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['servicios_egr_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['servicios_egr_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['servicios_egr_basicos']['N_Doc']             = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['servicios_egr_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['servicios_egr_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['servicios_egr_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['servicios_egr_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['servicios_egr_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['servicios_egr_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['servicios_egr_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['servicios_egr_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['servicios_egr_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['servicios_egr_basicos']['idTipo']            = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['servicios_egr_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['servicios_egr_basicos']['idCliente']         = '';}
				if(isset($idTrabajador) && $idTrabajador!=''){           $_SESSION['servicios_egr_basicos']['idTrabajador']      = $idTrabajador;      }else{$_SESSION['servicios_egr_basicos']['idTrabajador']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['servicios_egr_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['servicios_egr_basicos']['fecha_auto']        = '';}
				if(isset($OC_Ventas) && $OC_Ventas!=''){                 $_SESSION['servicios_egr_basicos']['OC_Ventas']         = $OC_Ventas;         }else{$_SESSION['servicios_egr_basicos']['OC_Ventas']         = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){   $_SESSION['servicios_egr_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['servicios_egr_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){   $_SESSION['servicios_egr_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['servicios_egr_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                   $_SESSION['servicios_egr_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['servicios_egr_basicos']['idUsoIVA']          = '';}
				//datos basicos vacios
				$_SESSION['servicios_egr_basicos']['Pago_fecha']      = '0000-00-00';

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['servicios_egr_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['servicios_egr_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_egr_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_egr_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['servicios_egr_basicos']['Cliente'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowVendedor = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['Vendedor'] = $rowVendedor['Nombre'].' '.$rowVendedor['ApellidoPat'].' '.$rowVendedor['ApellidoMat'];
				}else{
					$_SESSION['servicios_egr_basicos']['Vendedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['servicios_egr_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['servicios_egr_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_guia_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_guias'][$idGuia])&&$_SESSION['servicios_egr_guias'][$idGuia]>0){
				$error['productos'] = 'error/La guia que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos de la guia seleccionada
				$rowGuia = db_select_data (false, 'N_Doc, ValorNeto', 'bodegas_servicios_facturacion', '', 'idFacturacion = "'.$idGuia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$_SESSION['servicios_egr_guias'][$idGuia]['idGuia']     = $idGuia;
				$_SESSION['servicios_egr_guias'][$idGuia]['N_Doc']      = $rowGuia['N_Doc'];
				$_SESSION['servicios_egr_guias'][$idGuia]['ValorNeto']  = $rowGuia['ValorNeto'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_guia_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_guias'][$_GET['del_guia']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_impuestos'][$idImpuesto])&&$_SESSION['servicios_egr_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_egr_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_impuestos'][$_GET['del_impuesto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'addfpagoVenta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$valor    = $_GET['val_select'];

			//Se comprueba las fechas
			if($_SESSION['servicios_egr_basicos']['Creacion_fecha']>$valor){
				$error['ndata_1'] = 'error/La fecha de vencimiento es anterior a la fecha de creación';
			}

			//valido que no esten vacios
			if(empty($valor)){  $error['valor']  = 'error/No ha ingresado una fecha de vencimiento';}

			if(empty($error)){

				$_SESSION['servicios_egr_basicos']['Pago_fecha'] = $valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'delfpagoVenta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				$_SESSION['servicios_egr_basicos']['Pago_fecha'] = '0000-00-00';

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_prod_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_productos'][$idServicio])&&$_SESSION['servicios_egr_productos'][$idServicio]>0){
				$error['productos'] = 'error/El Servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				$_SESSION['servicios_egr_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_egr_productos'][$idServicio]['Cantidad_eg']   = $Cantidad_eg;
				$_SESSION['servicios_egr_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_egr_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_egr_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_egr_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_egr_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_productos'][$idServicio])&&$_SESSION['servicios_egr_productos'][$idServicio]>0&&$_SESSION['servicios_egr_productos'][$idServicio]!=$_SESSION['servicios_egr_productos'][$oldItemID]){
				$error['productos'] = 'error/El Servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['servicios_egr_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['servicios_egr_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_egr_productos'][$idServicio]['Cantidad_eg']   = $Cantidad_eg;
				$_SESSION['servicios_egr_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_egr_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_egr_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_egr_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_egr_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['servicios_egr_archivos'])){
				foreach ($_SESSION['servicios_egr_archivos'] as $key => $trabajos){
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
						$sufijo = 'servicios_egreso_'.genera_password_unica().'_';

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
									$_SESSION['servicios_egr_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['servicios_egr_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['servicios_egr_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['servicios_egr_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['servicios_egr_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'new_desc_egr':

			//verificar si existe algun otro dato
			if(!isset($_SESSION['servicios_egr_descuentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['servicios_egr_descuentos'] as $key => $producto){
					$idInterno++;
				}
			}
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_egr_descuentos'][$idInterno]['idDescuento']  = $idInterno;
				$_SESSION['servicios_egr_descuentos'][$idInterno]['Nombre']       = $Nombre;
				$_SESSION['servicios_egr_descuentos'][$idInterno]['vTotal']       = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_desc_egr':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se crea el nuevo producto
				$_SESSION['servicios_egr_descuentos'][$oldidProducto]['idDescuento'] = $oldidProducto;
				$_SESSION['servicios_egr_descuentos'][$oldidProducto]['Nombre'] = $Nombre;
				$_SESSION['servicios_egr_descuentos'][$oldidProducto]['vTotal'] = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_desc_egr':

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_descuentos'][$_GET['del_descuento']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'egr_bodega':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['servicios_egr_basicos'])){
				if(!isset($_SESSION['servicios_egr_basicos']['idDocumentos']) OR $_SESSION['servicios_egr_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha seleccionado el documentoa';}
				if(!isset($_SESSION['servicios_egr_basicos']['N_Doc']) OR $_SESSION['servicios_egr_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['servicios_egr_basicos']['Observaciones']) OR $_SESSION['servicios_egr_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['servicios_egr_basicos']['idSistema']) OR $_SESSION['servicios_egr_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['servicios_egr_basicos']['idUsuario']) OR $_SESSION['servicios_egr_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha sleccionado el usuario';}
				if(!isset($_SESSION['servicios_egr_basicos']['Creacion_fecha']) OR $_SESSION['servicios_egr_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado una fecha de creación';}
				if(!isset($_SESSION['servicios_egr_basicos']['idTipo']) OR $_SESSION['servicios_egr_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['servicios_egr_basicos']['idCliente']) OR $_SESSION['servicios_egr_basicos']['idCliente']=='' ){           $error['idCliente']        = 'error/No ha seleccionado el cliente';}
				if(!isset($_SESSION['servicios_egr_basicos']['idTrabajador']) OR $_SESSION['servicios_egr_basicos']['idTrabajador']=='' ){     $error['idTrabajador']     = 'error/No ha seleccionado el vendedor';}
				if(!isset($_SESSION['servicios_egr_basicos']['idUsoIVA']) OR $_SESSION['servicios_egr_basicos']['idUsoIVA']=='' ){             $error['idUsoIVA']         = 'error/No ha seleccionado la exencion del IVA';}
				//compruebo que sea una factura y que tenga fecha de pago
				if(isset($_SESSION['servicios_egr_basicos']['idDocumentos']) && $_SESSION['servicios_egr_basicos']['idDocumentos']==2 ){
					if(!isset($_SESSION['servicios_egr_basicos']['Pago_fecha']) OR $_SESSION['servicios_egr_basicos']['Pago_fecha']=='' OR $_SESSION['servicios_egr_basicos']['Pago_fecha']=='0000-00-00' ){
						$error['Pago_fecha']  = 'error/No ha ingresado la fecha de vencimiento de la factura';
					}
				}
				//se verifica el uso del iva
				if(isset($_SESSION['servicios_egr_basicos']['idUsoIVA'])&&$_SESSION['servicios_egr_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['servicios_egr_impuestos'])){
						$error['Pago_fecha']  = 'error/No ha seleccionado un impuesto para la factura';
					}
				}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al documento';
			}
			//productos o guias
			if (!isset($_SESSION['servicios_egr_productos'])&&!isset($_SESSION['servicios_egr_guias'])){
				$error['idProducto']   = 'error/No se han asignado ni servicios ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['servicios_egr_productos'])){
				foreach ($_SESSION['servicios_egr_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['servicios_egr_guias'])){
				foreach ($_SESSION['servicios_egr_guias'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['trabajos']   = 'error/No se han asignado ni servicios ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['servicios_egr_basicos']['idDocumentos']) && $_SESSION['servicios_egr_basicos']['idDocumentos']!=''){      $SIS_data  = "'".$_SESSION['servicios_egr_basicos']['idDocumentos']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['servicios_egr_basicos']['N_Doc']) && $_SESSION['servicios_egr_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['Observaciones']) && $_SESSION['servicios_egr_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idSistema']) && $_SESSION['servicios_egr_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idUsuario']) && $_SESSION['servicios_egr_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idTipo']) && $_SESSION['servicios_egr_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['servicios_egr_basicos']['idCliente']) && $_SESSION['servicios_egr_basicos']['idCliente']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idCliente']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idTrabajador']) && $_SESSION['servicios_egr_basicos']['idTrabajador']!=''){       $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idTrabajador']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['fecha_auto']) && $_SESSION['servicios_egr_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['fecha_auto']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['valor_neto_fact'])&&$_SESSION['servicios_egr_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['valor_neto_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['valor_neto_imp'])&&$_SESSION['servicios_egr_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['valor_neto_imp']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['valor_total_fact'])&&$_SESSION['servicios_egr_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['valor_total_fact']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][1]['valor'])&&$_SESSION['servicios_egr_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][1]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][2]['valor'])&&$_SESSION['servicios_egr_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][2]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][3]['valor'])&&$_SESSION['servicios_egr_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][3]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][4]['valor'])&&$_SESSION['servicios_egr_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][4]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][5]['valor'])&&$_SESSION['servicios_egr_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][5]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][6]['valor'])&&$_SESSION['servicios_egr_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][6]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][7]['valor'])&&$_SESSION['servicios_egr_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][7]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][8]['valor'])&&$_SESSION['servicios_egr_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][8]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][9]['valor'])&&$_SESSION['servicios_egr_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][9]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_impuestos'][10]['valor'])&&$_SESSION['servicios_egr_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['servicios_egr_impuestos'][10]['valor']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['Pago_fecha']) && $_SESSION['servicios_egr_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['servicios_egr_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_egr_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['servicios_egr_basicos']['OC_Ventas']) && $_SESSION['servicios_egr_basicos']['OC_Ventas']!=''){                 $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['OC_Ventas']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idCentroCosto']) && $_SESSION['servicios_egr_basicos']['idCentroCosto']!=''){         $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idLevel_1']) && $_SESSION['servicios_egr_basicos']['idLevel_1']!=''){                 $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idLevel_2']) && $_SESSION['servicios_egr_basicos']['idLevel_2']!=''){                 $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idLevel_3']) && $_SESSION['servicios_egr_basicos']['idLevel_3']!=''){                 $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idLevel_4']) && $_SESSION['servicios_egr_basicos']['idLevel_4']!=''){                 $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idLevel_5']) && $_SESSION['servicios_egr_basicos']['idLevel_5']!=''){                 $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['fecha_fact_desde']) && $_SESSION['servicios_egr_basicos']['fecha_fact_desde']!=''){   $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['fecha_fact_desde']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['fecha_fact_hasta']) && $_SESSION['servicios_egr_basicos']['fecha_fact_hasta']!=''){   $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['fecha_fact_hasta']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_basicos']['idUsoIVA']) && $_SESSION['servicios_egr_basicos']['idUsoIVA']!=''){                   $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idUsoIVA']."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, Observaciones, idSistema, idUsuario, idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idCliente, idTrabajador, fecha_auto, ValorNeto, ValorNetoImp, ValorTotal, Impuesto_01, Impuesto_02, Impuesto_03, Impuesto_04, Impuesto_05, Impuesto_06,
				Impuesto_07, Impuesto_08, Impuesto_09, Impuesto_10, Pago_fecha,Pago_dia, Pago_Semana, Pago_mes, Pago_ano, idEstado,OC_Ventas, idCentroCosto, idLevel_1, idLevel_2,
				idLevel_3, idLevel_4, idLevel_5, fecha_fact_desde, fecha_fact_hasta, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['servicios_egr_productos'])){
						foreach ($_SESSION['servicios_egr_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_basicos']['idSistema']) && $_SESSION['servicios_egr_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['idUsuario']) && $_SESSION['servicios_egr_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['servicios_egr_basicos']['idDocumentos']) && $_SESSION['servicios_egr_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['N_Doc']) && $_SESSION['servicios_egr_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['idTipo']) && $_SESSION['servicios_egr_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){                                                            $SIS_data .= ",'".$producto['idServicio']."'";                             }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_eg']) && $producto['Cantidad_eg']!=''){                                                          $SIS_data .= ",'".$producto['Cantidad_eg']."'";                            }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){                                                        $SIS_data .= ",'".$producto['idFrecuencia']."'";                           }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                        $SIS_data .= ",'".$producto['ValorIngreso']."'";                           }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                            $SIS_data .= ",'".$producto['ValorTotal']."'";                             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['idCliente']) && $_SESSION['servicios_egr_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idCliente']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['fecha_auto']) && $_SESSION['servicios_egr_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocumentos, N_Doc, idTipo, idServicio, Cantidad_eg, idFrecuencia, Valor,ValorTotal, idCliente, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/********************************************************************************/
							//Actualizo el valor de los productos
							$SIS_data = "idServicio='".$producto['idServicio']."'";
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){
								$SIS_data .= ",ValorEgreso='".$producto['ValorTotal']."'";
							}
							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'servicios_listado', 'idServicio = "'.$producto['idServicio'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se actualizan las guias a un estado de pago y con relacion al documento recien generado
					if (isset($_SESSION['servicios_egr_guias'])){
						foreach ($_SESSION['servicios_egr_guias'] as $key => $guias){
							//filtro
							if(isset($ultimo_id) && $ultimo_id!=''){

								$SIS_data  = "DocRel='".$ultimo_id."'";
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_servicios_facturacion', 'idFacturacion = "'.$guias['idGuia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Descuento
					if(isset($_SESSION['servicios_egr_descuentos'])){
						foreach ($_SESSION['servicios_egr_descuentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_basicos']['idSistema']) && $_SESSION['servicios_egr_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['idUsuario']) && $_SESSION['servicios_egr_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_descuentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['servicios_egr_archivos'])){
						foreach ($_SESSION['servicios_egr_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                               $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_basicos']['idSistema']) && $_SESSION['servicios_egr_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['idUsuario']) && $_SESSION['servicios_egr_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){           $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['servicios_egr_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['servicios_egr_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['servicios_egr_basicos']);
					unset($_SESSION['servicios_egr_productos']);
					unset($_SESSION['servicios_egr_temporal']);
					unset($_SESSION['servicios_egr_guias']);
					unset($_SESSION['servicios_egr_impuestos']);
					unset($_SESSION['servicios_egr_archivos']);
					unset($_SESSION['servicios_egr_descuentos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       INGRESOS ND                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_ingreso_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['servicios_ing_nd_basicos']);
				unset($_SESSION['servicios_ing_nd_productos']);
				unset($_SESSION['servicios_ing_nd_temporal']);
				unset($_SESSION['servicios_ing_nd_impuestos']);
				unset($_SESSION['servicios_ing_nd_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['servicios_ing_nd_archivos'])){
					foreach ($_SESSION['servicios_ing_nd_archivos'] as $key => $producto){
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
				unset($_SESSION['servicios_ing_nd_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['servicios_ing_nd_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['servicios_ing_nd_basicos']['idProveedor']      = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['servicios_ing_nd_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['servicios_ing_nd_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['servicios_ing_nd_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['servicios_ing_nd_basicos']['N_Doc']            = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']   = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['servicios_ing_nd_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['servicios_ing_nd_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['servicios_ing_nd_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['servicios_ing_nd_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['servicios_ing_nd_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['servicios_ing_nd_basicos']['idUsuario']        = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['servicios_ing_nd_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['servicios_ing_nd_basicos']['idTipo']           = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['servicios_ing_nd_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['servicios_ing_nd_basicos']['fecha_auto']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['servicios_ing_nd_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['servicios_ing_nd_basicos']['idUsoIVA']         = '';}
				//datos basicos vacios
				$_SESSION['servicios_ing_nd_basicos']['Pago_fecha']       = '0000-00-00';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['servicios_ing_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['servicios_ing_nd_basicos']['idCentroCosto'] = 0;
				$_SESSION['servicios_ing_nd_basicos']['idLevel_1']     = 0;
				$_SESSION['servicios_ing_nd_basicos']['idLevel_2']     = 0;
				$_SESSION['servicios_ing_nd_basicos']['idLevel_3']     = 0;
				$_SESSION['servicios_ing_nd_basicos']['idLevel_4']     = 0;
				$_SESSION['servicios_ing_nd_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_ing_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_ing_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nd_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nd_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['servicios_ing_nd_basicos']['Proveedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_nd_basicos']);
			unset($_SESSION['servicios_ing_nd_productos']);
			unset($_SESSION['servicios_ing_nd_temporal']);
			unset($_SESSION['servicios_ing_nd_impuestos']);
			unset($_SESSION['servicios_ing_nd_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['servicios_ing_nd_archivos'])){
				foreach ($_SESSION['servicios_ing_nd_archivos'] as $key => $producto){
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
			unset($_SESSION['servicios_ing_nd_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['servicios_ing_nd_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['servicios_ing_nd_productos']);
				unset($_SESSION['servicios_ing_nd_guias']);
				unset($_SESSION['servicios_ing_nd_impuestos']);
				unset($_SESSION['servicios_ing_nd_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['servicios_ing_nd_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['servicios_ing_nd_basicos']['idProveedor']      = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['servicios_ing_nd_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['servicios_ing_nd_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['servicios_ing_nd_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['servicios_ing_nd_basicos']['N_Doc']            = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']   = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['servicios_ing_nd_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['servicios_ing_nd_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['servicios_ing_nd_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['servicios_ing_nd_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['servicios_ing_nd_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['servicios_ing_nd_basicos']['idUsuario']        = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['servicios_ing_nd_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['servicios_ing_nd_basicos']['idTipo']           = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['servicios_ing_nd_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['servicios_ing_nd_basicos']['fecha_auto']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['servicios_ing_nd_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['servicios_ing_nd_basicos']['idUsoIVA']         = '';}
				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_ing_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_ing_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nd_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nd_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['servicios_ing_nd_basicos']['Proveedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['servicios_ing_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['servicios_ing_nd_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nd_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nd_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nd_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nd_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nd_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el producto ya existe
			if(isset($_SESSION['servicios_ing_nd_productos'][$idServicio])&&$_SESSION['servicios_ing_nd_productos'][$idServicio]>0){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['Cantidad_ing']  = $Cantidad_ing;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_nd_productos'][$idServicio])&&$_SESSION['servicios_ing_nd_productos'][$idServicio]>0&&$_SESSION['servicios_ing_nd_productos'][$idServicio]!=$_SESSION['servicios_ing_nd_productos'][$oldItemID]){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				//Borro el producto
				unset($_SESSION['servicios_ing_nd_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['idServicio']       = $idServicio;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['Cantidad_ing']     = $Cantidad_ing;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['ValorIngreso']     = $vUnitario;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['ValorTotal']       = $ValorTotal;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['idFrecuencia']     = $idFrecuencia;
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['Servicio']         = $rowServicio['Nombre'];
				$_SESSION['servicios_ing_nd_productos'][$idServicio]['Frecuencia']       = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro el producto
			unset($_SESSION['servicios_ing_nd_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['servicios_ing_nd_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['servicios_ing_nd_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_ing_nd_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['servicios_ing_nd_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['servicios_ing_nd_otros'][$idInterno]['vTotal']   = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_otros_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['servicios_ing_nd_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['servicios_ing_nd_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['servicios_ing_nd_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_nd_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_nd_impuestos'][$idImpuesto])&&$_SESSION['servicios_ing_nd_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_ing_nd_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_nd_impuestos'][$_GET['del_impuesto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['servicios_ing_nd_archivos'])){
				foreach ($_SESSION['servicios_ing_nd_archivos'] as $key => $trabajos){
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
						$sufijo = 'servicios_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['servicios_ing_nd_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['servicios_ing_nd_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['servicios_ing_nd_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['servicios_ing_nd_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['servicios_ing_nd_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'ing_bodega_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['servicios_ing_nd_basicos'])){
				if(!isset($_SESSION['servicios_ing_nd_basicos']['idDocumentos']) OR $_SESSION['servicios_ing_nd_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['servicios_ing_nd_basicos']['N_Doc']) OR $_SESSION['servicios_ing_nd_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha seleccionado el area';}
				if(!isset($_SESSION['servicios_ing_nd_basicos']['Observaciones']) OR $_SESSION['servicios_ing_nd_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha seleccionado la maquina';}
				if(!isset($_SESSION['servicios_ing_nd_basicos']['idSistema']) OR $_SESSION['servicios_ing_nd_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha ingresado el id del usuario';}
				if(!isset($_SESSION['servicios_ing_nd_basicos']['idUsuario']) OR $_SESSION['servicios_ing_nd_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha ingresado el id del estado';}
				if(!isset($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']) OR $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la prioridad';}
				if(!isset($_SESSION['servicios_ing_nd_basicos']['idTipo']) OR $_SESSION['servicios_ing_nd_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de trabajo';}
				//se verifica el uso del iva
				if(isset($_SESSION['servicios_ing_nd_basicos']['idUsoIVA'])&&$_SESSION['servicios_ing_nd_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['servicios_ing_nd_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}
			//productos o guias
			if (!isset($_SESSION['servicios_ing_nd_productos'])&&!isset($_SESSION['servicios_ing_nd_otros'])){
				$error['idProducto']   = 'error/No se han asignado servicios ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['servicios_ing_nd_productos'])){
				foreach ($_SESSION['servicios_ing_nd_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['servicios_ing_nd_otros'])){
				foreach ($_SESSION['servicios_ing_nd_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto'] = 'error/No se han asignado servicios ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

			//Se guardan los datos basicos
				if(isset($_SESSION['servicios_ing_nd_basicos']['idSistema']) && $_SESSION['servicios_ing_nd_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['servicios_ing_nd_basicos']['idSistema']."'";      }else{$SIS_data  = "''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idUsuario']) && $_SESSION['servicios_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idDocumentos']) && $_SESSION['servicios_ing_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idDocumentos']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['N_Doc']) && $_SESSION['servicios_ing_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['N_Doc']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idTipo']) && $_SESSION['servicios_ing_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['Observaciones']) && $_SESSION['servicios_ing_nd_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idProveedor']) && $_SESSION['servicios_ing_nd_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idProveedor']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['Pago_fecha']) && $_SESSION['servicios_ing_nd_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['servicios_ing_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_ing_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nd_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['servicios_ing_nd_basicos']['fecha_auto']) && $_SESSION['servicios_ing_nd_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['valor_neto_fact'])&&$_SESSION['servicios_ing_nd_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['valor_neto_fact']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['valor_neto_imp'])&&$_SESSION['servicios_ing_nd_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['valor_neto_imp']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['valor_total_fact'])&&$_SESSION['servicios_ing_nd_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['valor_total_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][1]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][1]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][2]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][2]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][3]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][3]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][4]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][4]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][5]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][5]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][6]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][6]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][7]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][7]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][8]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][8]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][9]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][9]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_impuestos'][10]['valor'])&&$_SESSION['servicios_ing_nd_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['servicios_ing_nd_impuestos'][10]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idCentroCosto']) && $_SESSION['servicios_ing_nd_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idCentroCosto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idLevel_1']) && $_SESSION['servicios_ing_nd_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idLevel_1']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idLevel_2']) && $_SESSION['servicios_ing_nd_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idLevel_2']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idLevel_3']) && $_SESSION['servicios_ing_nd_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idLevel_3']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idLevel_4']) && $_SESSION['servicios_ing_nd_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idLevel_4']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idLevel_5']) && $_SESSION['servicios_ing_nd_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idLevel_5']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nd_basicos']['idUsoIVA']) && $_SESSION['servicios_ing_nd_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idUsoIVA']."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idDocumentos, N_Doc, idTipo,Observaciones, idProveedor, Pago_fecha,Pago_dia, Pago_Semana, Pago_mes,
				Pago_ano, idEstado, fecha_auto, ValorNeto, ValorNetoImp, ValorTotal, Impuesto_01, Impuesto_02, Impuesto_03,
				Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08, Impuesto_09, Impuesto_10, idCentroCosto,
				idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['servicios_ing_nd_productos'])){
						foreach ($_SESSION['servicios_ing_nd_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idSistema']) && $_SESSION['servicios_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idUsuario']) && $_SESSION['servicios_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idDocumentos']) && $_SESSION['servicios_ing_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idDocumentos']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['N_Doc']) && $_SESSION['servicios_ing_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idTipo']) && $_SESSION['servicios_ing_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){                                                                  $SIS_data .= ",'".$producto['idServicio']."'";                                     }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_ing']) && $producto['Cantidad_ing']!=''){                                                              $SIS_data .= ",'".$producto['Cantidad_ing']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){                                                              $SIS_data .= ",'".$producto['idFrecuencia']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                              $SIS_data .= ",'".$producto['ValorIngreso']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                  $SIS_data .= ",'".$producto['ValorTotal']."'";                                     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idProveedor']) && $_SESSION['servicios_ing_nd_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idProveedor']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['fecha_auto']) && $_SESSION['servicios_ing_nd_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario,
							Creacion_fecha, Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idServicio, Cantidad_ing, idFrecuencia, Valor, ValorTotal,
							idProveedor, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['servicios_ing_nd_otros'])){
						foreach ($_SESSION['servicios_ing_nd_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idSistema']) && $_SESSION['servicios_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idUsuario']) && $_SESSION['servicios_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['servicios_ing_nd_archivos'])){
						foreach ($_SESSION['servicios_ing_nd_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idSistema']) && $_SESSION['servicios_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idUsuario']) && $_SESSION['servicios_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['servicios_ing_nd_basicos']);
					unset($_SESSION['servicios_ing_nd_productos']);
					unset($_SESSION['servicios_ing_nd_temporal']);
					unset($_SESSION['servicios_ing_nd_impuestos']);
					unset($_SESSION['servicios_ing_nd_archivos']);
					unset($_SESSION['servicios_ing_nd_otros']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                        INGRESOS NC                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_ingreso_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se verifica si el dato existe
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['servicios_ing_nc_basicos']);
				unset($_SESSION['servicios_ing_nc_productos']);
				unset($_SESSION['servicios_ing_nc_temporal']);
				unset($_SESSION['servicios_ing_nc_impuestos']);
				unset($_SESSION['servicios_ing_nc_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['servicios_ing_nc_archivos'])){
					foreach ($_SESSION['servicios_ing_nc_archivos'] as $key => $producto){
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
				unset($_SESSION['servicios_ing_nc_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){       $_SESSION['servicios_ing_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['servicios_ing_nc_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                     $_SESSION['servicios_ing_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['servicios_ing_nc_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){     $_SESSION['servicios_ing_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['servicios_ing_nc_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){             $_SESSION['servicios_ing_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['servicios_ing_nc_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){             $_SESSION['servicios_ing_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['servicios_ing_nc_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){   $_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                   $_SESSION['servicios_ing_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['servicios_ing_nc_basicos']['idTipo']           = '';}
				if(isset($idProveedor) && $idProveedor!=''){         $_SESSION['servicios_ing_nc_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['servicios_ing_nc_basicos']['idProveedor']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){           $_SESSION['servicios_ing_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['servicios_ing_nc_basicos']['fecha_auto']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){               $_SESSION['servicios_ing_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['servicios_ing_nc_basicos']['idUsoIVA']         = '';}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['servicios_ing_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['servicios_ing_nc_basicos']['idCentroCosto'] = 0;
				$_SESSION['servicios_ing_nc_basicos']['idLevel_1']     = 0;
				$_SESSION['servicios_ing_nc_basicos']['idLevel_2']     = 0;
				$_SESSION['servicios_ing_nc_basicos']['idLevel_3']     = 0;
				$_SESSION['servicios_ing_nc_basicos']['idLevel_4']     = 0;
				$_SESSION['servicios_ing_nc_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_ing_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_ing_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nc_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nc_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['servicios_ing_nc_basicos']['Proveedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_nc_basicos']);
			unset($_SESSION['servicios_ing_nc_productos']);
			unset($_SESSION['servicios_ing_nc_temporal']);
			unset($_SESSION['servicios_ing_nc_impuestos']);
			unset($_SESSION['servicios_ing_nc_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['servicios_ing_nc_archivos'])){
				foreach ($_SESSION['servicios_ing_nc_archivos'] as $key => $producto){
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
			unset($_SESSION['servicios_ing_nc_archivos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['servicios_ing_nc_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['servicios_ing_nc_productos']);
				unset($_SESSION['servicios_ing_nc_impuestos']);
				unset($_SESSION['servicios_ing_nc_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){       $_SESSION['servicios_ing_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['servicios_ing_nc_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                     $_SESSION['servicios_ing_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['servicios_ing_nc_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){     $_SESSION['servicios_ing_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['servicios_ing_nc_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){             $_SESSION['servicios_ing_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['servicios_ing_nc_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){             $_SESSION['servicios_ing_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['servicios_ing_nc_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){   $_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                   $_SESSION['servicios_ing_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['servicios_ing_nc_basicos']['idTipo']           = '';}
				if(isset($idProveedor) && $idProveedor!=''){         $_SESSION['servicios_ing_nc_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['servicios_ing_nc_basicos']['idProveedor']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){           $_SESSION['servicios_ing_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['servicios_ing_nc_basicos']['fecha_auto']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){               $_SESSION['servicios_ing_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['servicios_ing_nc_basicos']['idUsoIVA']         = '';}
				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_ing_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_ing_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nc_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_ing_nc_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['servicios_ing_nc_basicos']['Proveedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['servicios_ing_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['servicios_ing_nc_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nc_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nc_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nc_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nc_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_ing_nc_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_nc_productos'][$idServicio])&&$_SESSION['servicios_ing_nc_productos'][$idServicio]>0){
				$error['productos'] = 'error/El Servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['Cantidad_eg']   = $Cantidad_eg;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_nc_productos'][$idServicio])&&$_SESSION['servicios_ing_nc_productos'][$idServicio]>0&&$_SESSION['servicios_ing_nc_productos'][$idServicio]!=$_SESSION['servicios_ing_nc_productos'][$oldItemID]){
				$error['productos'] = 'error/El Servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['servicios_ing_nc_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['Cantidad_eg']   = $Cantidad_eg;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_ing_nc_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'del_prod_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_nc_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['servicios_ing_nc_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['servicios_ing_nc_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_ing_nc_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['servicios_ing_nc_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['servicios_ing_nc_otros'][$idInterno]['vTotal']   = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_otros_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['servicios_ing_nc_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['servicios_ing_nc_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['servicios_ing_nc_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_nc_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_ing_nc_impuestos'][$idImpuesto])&&$_SESSION['servicios_ing_nc_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_ing_nc_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_ing_nc_impuestos'][$_GET['del_impuesto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['servicios_ing_nc_archivos'])){
				foreach ($_SESSION['servicios_ing_nc_archivos'] as $key => $trabajos){
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
						$sufijo = 'servicios_egreso_'.genera_password_unica().'_';

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
									$_SESSION['servicios_ing_nc_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['servicios_ing_nc_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['servicios_ing_nc_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['servicios_ing_nc_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['servicios_ing_nc_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'ing_bodega_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['servicios_ing_nc_basicos'])){
				if(!isset($_SESSION['servicios_ing_nc_basicos']['idDocumentos']) OR $_SESSION['servicios_ing_nc_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha seleccionado el documentoa';}
				if(!isset($_SESSION['servicios_ing_nc_basicos']['N_Doc']) OR $_SESSION['servicios_ing_nc_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['servicios_ing_nc_basicos']['Observaciones']) OR $_SESSION['servicios_ing_nc_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['servicios_ing_nc_basicos']['idSistema']) OR $_SESSION['servicios_ing_nc_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['servicios_ing_nc_basicos']['idUsuario']) OR $_SESSION['servicios_ing_nc_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha sleccionado el usuario';}
				if(!isset($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']) OR $_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado una fecha de creación';}
				if(!isset($_SESSION['servicios_ing_nc_basicos']['idTipo']) OR $_SESSION['servicios_ing_nc_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['servicios_ing_nc_basicos']['idProveedor']) OR $_SESSION['servicios_ing_nc_basicos']['idProveedor']=='' ){       $error['idProveedor']      = 'error/No ha seleccionado el cliente';}
				//se verifica el uso del iva
				if(isset($_SESSION['servicios_ing_nc_basicos']['idUsoIVA'])&&$_SESSION['servicios_ing_nc_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['servicios_ing_nc_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al documento';
			}
			//productos o guias
			if (!isset($_SESSION['servicios_ing_nc_productos'])&&!isset($_SESSION['servicios_ing_nc_otros'])){
				$error['idProducto']   = 'error/No se han asignado ni servicios ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['servicios_ing_nc_productos'])){
				foreach ($_SESSION['servicios_ing_nc_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['servicios_ing_nc_otros'])){
				foreach ($_SESSION['servicios_ing_nc_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto']   = 'error/No se han asignado ni servicios ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['servicios_ing_nc_basicos']['idDocumentos']) && $_SESSION['servicios_ing_nc_basicos']['idDocumentos']!=''){      $SIS_data  = "'".$_SESSION['servicios_ing_nc_basicos']['idDocumentos']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['N_Doc']) && $_SESSION['servicios_ing_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['Observaciones']) && $_SESSION['servicios_ing_nc_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idSistema']) && $_SESSION['servicios_ing_nc_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idUsuario']) && $_SESSION['servicios_ing_nc_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idTipo']) && $_SESSION['servicios_ing_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idProveedor']) && $_SESSION['servicios_ing_nc_basicos']['idProveedor']!=''){         $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idProveedor']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['fecha_auto']) && $_SESSION['servicios_ing_nc_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['fecha_auto']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['valor_neto_fact'])&&$_SESSION['servicios_ing_nc_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['valor_neto_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['valor_neto_imp'])&&$_SESSION['servicios_ing_nc_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['valor_neto_imp']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['valor_total_fact'])&&$_SESSION['servicios_ing_nc_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['valor_total_fact']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][1]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][1]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][2]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][2]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][3]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][3]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][4]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][4]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][5]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][5]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][6]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][6]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][7]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][7]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][8]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][8]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][9]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][9]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_impuestos'][10]['valor'])&&$_SESSION['servicios_ing_nc_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['servicios_ing_nc_impuestos'][10]['valor']."'";       }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['servicios_ing_nc_basicos']['idCentroCosto']) && $_SESSION['servicios_ing_nc_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idLevel_1']) && $_SESSION['servicios_ing_nc_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idLevel_2']) && $_SESSION['servicios_ing_nc_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idLevel_3']) && $_SESSION['servicios_ing_nc_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idLevel_4']) && $_SESSION['servicios_ing_nc_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idLevel_5']) && $_SESSION['servicios_ing_nc_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_ing_nc_basicos']['idUsoIVA']) && $_SESSION['servicios_ing_nc_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idUsoIVA']."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, Observaciones,
				idSistema, idUsuario, idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idProveedor, fecha_auto, ValorNeto, ValorNetoImp,ValorTotal, Impuesto_01,
				Impuesto_02, Impuesto_03, Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08,
				Impuesto_09, Impuesto_10, idEstado, idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4,
				idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['servicios_ing_nc_productos'])){
						foreach ($_SESSION['servicios_ing_nc_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['idSistema']) && $_SESSION['servicios_ing_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['idUsuario']) && $_SESSION['servicios_ing_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['servicios_ing_nc_basicos']['idDocumentos']) && $_SESSION['servicios_ing_nc_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['N_Doc']) && $_SESSION['servicios_ing_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['idTipo']) && $_SESSION['servicios_ing_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){                                                                  $SIS_data .= ",'".$producto['idServicio']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_eg']) && $producto['Cantidad_eg']!=''){                                                                $SIS_data .= ",'".$producto['Cantidad_eg']."'";                               }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){                                                              $SIS_data .= ",'".$producto['idFrecuencia']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                              $SIS_data .= ",'".$producto['ValorIngreso']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                  $SIS_data .= ",'".$producto['ValorTotal']."'";                                }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['idProveedor']) && $_SESSION['servicios_ing_nc_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idProveedor']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['fecha_auto']) && $_SESSION['servicios_ing_nc_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocumentos, N_Doc, idTipo, idServicio, Cantidad_eg, idFrecuencia, Valor,ValorTotal, idProveedor, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['servicios_ing_nc_otros'])){
						foreach ($_SESSION['servicios_ing_nc_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idSistema']) && $_SESSION['servicios_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['idUsuario']) && $_SESSION['servicios_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['servicios_ing_nc_archivos'])){
						foreach ($_SESSION['servicios_ing_nc_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['idSistema']) && $_SESSION['servicios_ing_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['idUsuario']) && $_SESSION['servicios_ing_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['servicios_ing_nc_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['servicios_ing_nc_basicos']);
					unset($_SESSION['servicios_ing_nc_productos']);
					unset($_SESSION['servicios_ing_nc_temporal']);
					unset($_SESSION['servicios_ing_nc_impuestos']);
					unset($_SESSION['servicios_ing_nc_archivos']);
					unset($_SESSION['servicios_ing_nc_otros']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       INGRESOS ND                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_egreso_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idDocumentos)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['servicios_egr_nd_basicos']);
				unset($_SESSION['servicios_egr_nd_productos']);
				unset($_SESSION['servicios_egr_nd_temporal']);
				unset($_SESSION['servicios_egr_nd_impuestos']);
				unset($_SESSION['servicios_egr_nd_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['servicios_egr_nd_archivos'])){
					foreach ($_SESSION['servicios_egr_nd_archivos'] as $key => $producto){
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
				unset($_SESSION['servicios_egr_nd_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCliente) && $idCliente!=''){             $_SESSION['servicios_egr_nd_basicos']['idCliente']        = $idCliente;        }else{$_SESSION['servicios_egr_nd_basicos']['idCliente']       = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){       $_SESSION['servicios_egr_nd_basicos']['idDocumentos']     = $idDocumentos;     }else{$_SESSION['servicios_egr_nd_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                     $_SESSION['servicios_egr_nd_basicos']['N_Doc']            = $N_Doc;            }else{$_SESSION['servicios_egr_nd_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){   $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;   }else{$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones) && $Observaciones!=''){     $_SESSION['servicios_egr_nd_basicos']['Observaciones']    = $Observaciones;    }else{$_SESSION['servicios_egr_nd_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){             $_SESSION['servicios_egr_nd_basicos']['idSistema']        = $idSistema;        }else{$_SESSION['servicios_egr_nd_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){             $_SESSION['servicios_egr_nd_basicos']['idUsuario']        = $idUsuario;        }else{$_SESSION['servicios_egr_nd_basicos']['idUsuario']       = '';}
				if(isset($idTipo) && $idTipo!=''){                   $_SESSION['servicios_egr_nd_basicos']['idTipo']           = $idTipo;           }else{$_SESSION['servicios_egr_nd_basicos']['idTipo']          = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){           $_SESSION['servicios_egr_nd_basicos']['fecha_auto']       = $fecha_auto;       }else{$_SESSION['servicios_egr_nd_basicos']['fecha_auto']      = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){               $_SESSION['servicios_egr_nd_basicos']['idUsoIVA']         = $idUsoIVA;         }else{$_SESSION['servicios_egr_nd_basicos']['idUsoIVA']        = '';}
				//datos basicos vacios
				$_SESSION['servicios_egr_nd_basicos']['Pago_fecha']       = '0000-00-00';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['servicios_egr_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['servicios_egr_nd_basicos']['idCentroCosto'] = 0;
				$_SESSION['servicios_egr_nd_basicos']['idLevel_1']     = 0;
				$_SESSION['servicios_egr_nd_basicos']['idLevel_2']     = 0;
				$_SESSION['servicios_egr_nd_basicos']['idLevel_3']     = 0;
				$_SESSION['servicios_egr_nd_basicos']['idLevel_4']     = 0;
				$_SESSION['servicios_egr_nd_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_egr_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_egr_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nd_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nd_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['servicios_egr_nd_basicos']['Cliente'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_nd_basicos']);
			unset($_SESSION['servicios_egr_nd_productos']);
			unset($_SESSION['servicios_egr_nd_temporal']);
			unset($_SESSION['servicios_egr_nd_impuestos']);
			unset($_SESSION['servicios_egr_nd_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['servicios_egr_nd_archivos'])){
				foreach ($_SESSION['servicios_egr_nd_archivos'] as $key => $producto){
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
			unset($_SESSION['servicios_egr_nd_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idDocumentos)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['servicios_egr_nd_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['servicios_egr_nd_productos']);
				unset($_SESSION['servicios_egr_nd_guias']);
				unset($_SESSION['servicios_egr_nd_impuestos']);
				unset($_SESSION['servicios_egr_nd_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCliente) && $idCliente!=''){             $_SESSION['servicios_egr_nd_basicos']['idCliente']        = $idCliente;        }else{$_SESSION['servicios_egr_nd_basicos']['idCliente']       = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){       $_SESSION['servicios_egr_nd_basicos']['idDocumentos']     = $idDocumentos;     }else{$_SESSION['servicios_egr_nd_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                     $_SESSION['servicios_egr_nd_basicos']['N_Doc']            = $N_Doc;            }else{$_SESSION['servicios_egr_nd_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){   $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;   }else{$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones) && $Observaciones!=''){     $_SESSION['servicios_egr_nd_basicos']['Observaciones']    = $Observaciones;    }else{$_SESSION['servicios_egr_nd_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){             $_SESSION['servicios_egr_nd_basicos']['idSistema']        = $idSistema;        }else{$_SESSION['servicios_egr_nd_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){             $_SESSION['servicios_egr_nd_basicos']['idUsuario']        = $idUsuario;        }else{$_SESSION['servicios_egr_nd_basicos']['idUsuario']       = '';}
				if(isset($idTipo) && $idTipo!=''){                   $_SESSION['servicios_egr_nd_basicos']['idTipo']           = $idTipo;           }else{$_SESSION['servicios_egr_nd_basicos']['idTipo']          = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){           $_SESSION['servicios_egr_nd_basicos']['fecha_auto']       = $fecha_auto;       }else{$_SESSION['servicios_egr_nd_basicos']['fecha_auto']      = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){               $_SESSION['servicios_egr_nd_basicos']['idUsoIVA']         = $idUsoIVA;         }else{$_SESSION['servicios_egr_nd_basicos']['idUsoIVA']        = '';}
				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_egr_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_egr_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nd_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nd_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['servicios_egr_nd_basicos']['Cliente'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['servicios_egr_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['servicios_egr_nd_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nd_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nd_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nd_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nd_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nd_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el producto ya existe
			if(isset($_SESSION['servicios_egr_nd_productos'][$idServicio])&&$_SESSION['servicios_egr_nd_productos'][$idServicio]>0){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['Cantidad_eg']   = $Cantidad_eg;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_nd_productos'][$idServicio])&&$_SESSION['servicios_egr_nd_productos'][$idServicio]>0&&$_SESSION['servicios_egr_nd_productos'][$idServicio]!=$_SESSION['servicios_egr_nd_productos'][$oldItemID]){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['servicios_egr_nd_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['idServicio']       = $idServicio;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['Cantidad_eg']      = $Cantidad_eg;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['ValorIngreso']     = $vUnitario;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['ValorTotal']       = $ValorTotal;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['idFrecuencia']     = $idFrecuencia;
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['Servicio']         = $rowServicio['Nombre'];
				$_SESSION['servicios_egr_nd_productos'][$idServicio]['Frecuencia']       = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro el producto
			unset($_SESSION['servicios_egr_nd_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['servicios_egr_nd_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['servicios_egr_nd_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_egr_nd_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['servicios_egr_nd_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['servicios_egr_nd_otros'][$idInterno]['vTotal']   = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_otros_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['servicios_egr_nd_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['servicios_egr_nd_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['servicios_egr_nd_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_nd_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_nd_impuestos'][$idImpuesto])&&$_SESSION['servicios_egr_nd_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_egr_nd_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_nd_impuestos'][$_GET['del_impuesto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['servicios_egr_nd_archivos'])){
				foreach ($_SESSION['servicios_egr_nd_archivos'] as $key => $trabajos){
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
						$sufijo = 'servicios_egreso_'.genera_password_unica().'_';

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
									$_SESSION['servicios_egr_nd_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['servicios_egr_nd_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['servicios_egr_nd_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['servicios_egr_nd_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['servicios_egr_nd_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'egr_bodega_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['servicios_egr_nd_basicos'])){
				if(!isset($_SESSION['servicios_egr_nd_basicos']['idDocumentos']) OR $_SESSION['servicios_egr_nd_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['servicios_egr_nd_basicos']['N_Doc']) OR $_SESSION['servicios_egr_nd_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha seleccionado el area';}
				if(!isset($_SESSION['servicios_egr_nd_basicos']['Observaciones']) OR $_SESSION['servicios_egr_nd_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha seleccionado la maquina';}
				if(!isset($_SESSION['servicios_egr_nd_basicos']['idSistema']) OR $_SESSION['servicios_egr_nd_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha ingresado el id del usuario';}
				if(!isset($_SESSION['servicios_egr_nd_basicos']['idUsuario']) OR $_SESSION['servicios_egr_nd_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha ingresado el id del estado';}
				if(!isset($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']) OR $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la prioridad';}
				if(!isset($_SESSION['servicios_egr_nd_basicos']['idTipo']) OR $_SESSION['servicios_egr_nd_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de trabajo';}
				//se verifica el uso del iva
				if(isset($_SESSION['servicios_egr_nd_basicos']['idUsoIVA'])&&$_SESSION['servicios_egr_nd_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['servicios_egr_nd_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}
			//productos o guias
			if (!isset($_SESSION['servicios_egr_nd_productos'])&&!isset($_SESSION['servicios_egr_nd_otros'])){
				$error['idProducto']   = 'error/No se han asignado servicios ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['servicios_egr_nd_productos'])){
				foreach ($_SESSION['servicios_egr_nd_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['servicios_egr_nd_otros'])){
				foreach ($_SESSION['servicios_egr_nd_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto'] = 'error/No se han asignado servicios ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

			//Se guardan los datos basicos
				if(isset($_SESSION['servicios_egr_nd_basicos']['idSistema']) && $_SESSION['servicios_egr_nd_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['servicios_egr_nd_basicos']['idSistema']."'";       }else{$SIS_data  = "''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idUsuario']) && $_SESSION['servicios_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idUsuario']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idDocumentos']) && $_SESSION['servicios_egr_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idDocumentos']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['N_Doc']) && $_SESSION['servicios_egr_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['N_Doc']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idTipo']) && $_SESSION['servicios_egr_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['Observaciones']) && $_SESSION['servicios_egr_nd_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idCliente']) && $_SESSION['servicios_egr_nd_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idCliente']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['Pago_fecha']) && $_SESSION['servicios_egr_nd_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['servicios_egr_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_egr_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nd_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['servicios_egr_nd_basicos']['fecha_auto']) && $_SESSION['servicios_egr_nd_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['valor_neto_fact'])&&$_SESSION['servicios_egr_nd_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['valor_neto_fact']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['valor_neto_imp'])&&$_SESSION['servicios_egr_nd_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['valor_neto_imp']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['valor_total_fact'])&&$_SESSION['servicios_egr_nd_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['valor_total_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][1]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][1]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][2]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][2]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][3]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][3]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][4]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][4]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][5]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][5]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][6]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][6]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][7]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][7]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][8]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][8]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][9]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][9]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_impuestos'][10]['valor'])&&$_SESSION['servicios_egr_nd_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['servicios_egr_nd_impuestos'][10]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idCentroCosto']) && $_SESSION['servicios_egr_nd_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idCentroCosto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idLevel_1']) && $_SESSION['servicios_egr_nd_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idLevel_1']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idLevel_2']) && $_SESSION['servicios_egr_nd_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idLevel_2']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idLevel_3']) && $_SESSION['servicios_egr_nd_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idLevel_3']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idLevel_4']) && $_SESSION['servicios_egr_nd_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idLevel_4']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idLevel_5']) && $_SESSION['servicios_egr_nd_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idLevel_5']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nd_basicos']['idUsoIVA']) && $_SESSION['servicios_egr_nd_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idUsoIVA']."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idDocumentos, N_Doc, idTipo,Observaciones, idCliente, Pago_fecha,Pago_dia, Pago_Semana, Pago_mes,
				Pago_ano, idEstado, fecha_auto, ValorNeto, ValorNetoImp, ValorTotal, Impuesto_01, Impuesto_02, Impuesto_03,
				Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08, Impuesto_09, Impuesto_10, idCentroCosto,
				idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['servicios_egr_nd_productos'])){
						foreach ($_SESSION['servicios_egr_nd_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idSistema']) && $_SESSION['servicios_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idUsuario']) && $_SESSION['servicios_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idDocumentos']) && $_SESSION['servicios_egr_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idDocumentos']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['N_Doc']) && $_SESSION['servicios_egr_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idTipo']) && $_SESSION['servicios_egr_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){                                                                  $SIS_data .= ",'".$producto['idServicio']."'";                                     }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_eg']) && $producto['Cantidad_eg']!=''){                                                                $SIS_data .= ",'".$producto['Cantidad_eg']."'";                                    }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){                                                              $SIS_data .= ",'".$producto['idFrecuencia']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                              $SIS_data .= ",'".$producto['ValorIngreso']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                  $SIS_data .= ",'".$producto['ValorTotal']."'";                                     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idCliente']) && $_SESSION['servicios_egr_nd_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idCliente']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['fecha_auto']) && $_SESSION['servicios_egr_nd_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario,
							Creacion_fecha, Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idServicio, Cantidad_eg, idFrecuencia, Valor, ValorTotal,
							idCliente, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['servicios_egr_nd_otros'])){
						foreach ($_SESSION['servicios_egr_nd_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idSistema']) && $_SESSION['servicios_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idUsuario']) && $_SESSION['servicios_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['servicios_egr_nd_archivos'])){
						foreach ($_SESSION['servicios_egr_nd_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idSistema']) && $_SESSION['servicios_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idUsuario']) && $_SESSION['servicios_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['servicios_egr_nd_basicos']);
					unset($_SESSION['servicios_egr_nd_productos']);
					unset($_SESSION['servicios_egr_nd_temporal']);
					unset($_SESSION['servicios_egr_nd_impuestos']);
					unset($_SESSION['servicios_egr_nd_archivos']);
					unset($_SESSION['servicios_egr_nd_otros']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                        INGRESOS NC                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_egreso_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se verifica si el dato existe
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idDocumentos)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['servicios_egr_nc_basicos']);
				unset($_SESSION['servicios_egr_nc_productos']);
				unset($_SESSION['servicios_egr_nc_temporal']);
				unset($_SESSION['servicios_egr_nc_impuestos']);
				unset($_SESSION['servicios_egr_nc_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['servicios_egr_nc_archivos'])){
					foreach ($_SESSION['servicios_egr_nc_archivos'] as $key => $producto){
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
				unset($_SESSION['servicios_egr_nc_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){       $_SESSION['servicios_egr_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['servicios_egr_nc_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                     $_SESSION['servicios_egr_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['servicios_egr_nc_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){     $_SESSION['servicios_egr_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['servicios_egr_nc_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){             $_SESSION['servicios_egr_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['servicios_egr_nc_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){             $_SESSION['servicios_egr_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['servicios_egr_nc_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){   $_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                   $_SESSION['servicios_egr_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['servicios_egr_nc_basicos']['idTipo']           = '';}
				if(isset($idCliente) && $idCliente!=''){             $_SESSION['servicios_egr_nc_basicos']['idCliente']        = $idCliente;       }else{$_SESSION['servicios_egr_nc_basicos']['idCliente']        = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){           $_SESSION['servicios_egr_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['servicios_egr_nc_basicos']['fecha_auto']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){               $_SESSION['servicios_egr_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['servicios_egr_nc_basicos']['idUsoIVA']         = '';}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['servicios_egr_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['servicios_egr_nc_basicos']['idCentroCosto'] = 0;
				$_SESSION['servicios_egr_nc_basicos']['idLevel_1']     = 0;
				$_SESSION['servicios_egr_nc_basicos']['idLevel_2']     = 0;
				$_SESSION['servicios_egr_nc_basicos']['idLevel_3']     = 0;
				$_SESSION['servicios_egr_nc_basicos']['idLevel_4']     = 0;
				$_SESSION['servicios_egr_nc_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_egr_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_egr_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nc_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nc_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['servicios_egr_nc_basicos']['Cliente'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_nc_basicos']);
			unset($_SESSION['servicios_egr_nc_productos']);
			unset($_SESSION['servicios_egr_nc_temporal']);
			unset($_SESSION['servicios_egr_nc_impuestos']);
			unset($_SESSION['servicios_egr_nc_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['servicios_egr_nc_archivos'])){
				foreach ($_SESSION['servicios_egr_nc_archivos'] as $key => $producto){
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
			unset($_SESSION['servicios_egr_nc_archivos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['servicios_egr_nc_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['servicios_egr_nc_productos']);
				unset($_SESSION['servicios_egr_nc_impuestos']);
				unset($_SESSION['servicios_egr_nc_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){       $_SESSION['servicios_egr_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['servicios_egr_nc_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                     $_SESSION['servicios_egr_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['servicios_egr_nc_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){     $_SESSION['servicios_egr_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['servicios_egr_nc_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){             $_SESSION['servicios_egr_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['servicios_egr_nc_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){             $_SESSION['servicios_egr_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['servicios_egr_nc_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){   $_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                   $_SESSION['servicios_egr_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['servicios_egr_nc_basicos']['idTipo']           = '';}
				if(isset($idCliente) && $idCliente!=''){             $_SESSION['servicios_egr_nc_basicos']['idCliente']        = $idCliente;       }else{$_SESSION['servicios_egr_nc_basicos']['idCliente']        = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){           $_SESSION['servicios_egr_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['servicios_egr_nc_basicos']['fecha_auto']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){               $_SESSION['servicios_egr_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['servicios_egr_nc_basicos']['idUsoIVA']         = '';}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['servicios_egr_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['servicios_egr_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nc_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_servicios_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['servicios_egr_nc_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['servicios_egr_nc_basicos']['Cliente'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['servicios_egr_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['servicios_egr_nc_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nc_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nc_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nc_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nc_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['servicios_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['servicios_egr_nc_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_nc_productos'][$idServicio])&&$_SESSION['servicios_egr_nc_productos'][$idServicio]>0){
				$error['productos'] = 'error/El Servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['Cantidad_ing']  = $Cantidad_ing;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_nc_productos'][$idServicio])&&$_SESSION['servicios_egr_nc_productos'][$idServicio]>0&&$_SESSION['servicios_egr_nc_productos'][$idServicio]!=$_SESSION['servicios_egr_nc_productos'][$oldItemID]){
				$error['productos'] = 'error/El Servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowServicio = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia = "'.$idFrecuencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['servicios_egr_nc_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['Cantidad_ing']  = $Cantidad_ing;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['ValorIngreso']  = $vUnitario;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['ValorTotal']    = $ValorTotal;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['servicios_egr_nc_productos'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'del_prod_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_nc_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['servicios_egr_nc_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['servicios_egr_nc_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_egr_nc_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['servicios_egr_nc_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['servicios_egr_nc_otros'][$idInterno]['vTotal']   = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_otros_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//creo el producto
				$_SESSION['servicios_egr_nc_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['servicios_egr_nc_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['servicios_egr_nc_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_nc_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['servicios_egr_nc_impuestos'][$idImpuesto])&&$_SESSION['servicios_egr_nc_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['servicios_egr_nc_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['servicios_egr_nc_impuestos'][$_GET['del_impuesto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['servicios_egr_nc_archivos'])){
				foreach ($_SESSION['servicios_egr_nc_archivos'] as $key => $trabajos){
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
						$sufijo = 'servicios_egreso_'.genera_password_unica().'_';

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
									$_SESSION['servicios_egr_nc_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['servicios_egr_nc_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['servicios_egr_nc_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['servicios_egr_nc_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['servicios_egr_nc_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'egr_bodega_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['servicios_egr_nc_basicos'])){
				if(!isset($_SESSION['servicios_egr_nc_basicos']['idDocumentos']) OR $_SESSION['servicios_egr_nc_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha seleccionado el documentoa';}
				if(!isset($_SESSION['servicios_egr_nc_basicos']['N_Doc']) OR $_SESSION['servicios_egr_nc_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['servicios_egr_nc_basicos']['Observaciones']) OR $_SESSION['servicios_egr_nc_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['servicios_egr_nc_basicos']['idSistema']) OR $_SESSION['servicios_egr_nc_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['servicios_egr_nc_basicos']['idUsuario']) OR $_SESSION['servicios_egr_nc_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha sleccionado el usuario';}
				if(!isset($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']) OR $_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado una fecha de creación';}
				if(!isset($_SESSION['servicios_egr_nc_basicos']['idTipo']) OR $_SESSION['servicios_egr_nc_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['servicios_egr_nc_basicos']['idCliente']) OR $_SESSION['servicios_egr_nc_basicos']['idCliente']=='' ){           $error['idCliente']        = 'error/No ha seleccionado el cliente';}
				//se verifica el uso del iva
				if(isset($_SESSION['servicios_egr_nc_basicos']['idUsoIVA'])&&$_SESSION['servicios_egr_nc_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['servicios_egr_nc_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al documento';
			}
			//productos o guias
			if (!isset($_SESSION['servicios_egr_nc_productos'])&&!isset($_SESSION['servicios_egr_nc_otros'])){
				$error['idProducto']   = 'error/No se han asignado ni servicios ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['servicios_egr_nc_productos'])){
				foreach ($_SESSION['servicios_egr_nc_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['servicios_egr_nc_otros'])){
				foreach ($_SESSION['servicios_egr_nc_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto']   = 'error/No se han asignado ni servicios ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['servicios_egr_nc_basicos']['idDocumentos']) && $_SESSION['servicios_egr_nc_basicos']['idDocumentos']!=''){      $SIS_data  = "'".$_SESSION['servicios_egr_nc_basicos']['idDocumentos']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['N_Doc']) && $_SESSION['servicios_egr_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['Observaciones']) && $_SESSION['servicios_egr_nc_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idSistema']) && $_SESSION['servicios_egr_nc_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idUsuario']) && $_SESSION['servicios_egr_nc_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idTipo']) && $_SESSION['servicios_egr_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idCliente']) && $_SESSION['servicios_egr_nc_basicos']['idCliente']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idCliente']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['fecha_auto']) && $_SESSION['servicios_egr_nc_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['fecha_auto']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['valor_neto_fact'])&&$_SESSION['servicios_egr_nc_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['valor_neto_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['valor_neto_imp'])&&$_SESSION['servicios_egr_nc_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['valor_neto_imp']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['valor_total_fact'])&&$_SESSION['servicios_egr_nc_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['valor_total_fact']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][1]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][1]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][2]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][2]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][3]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][3]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][4]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][4]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][5]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][5]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][6]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][6]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][7]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][7]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][8]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][8]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][9]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][9]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_impuestos'][10]['valor'])&&$_SESSION['servicios_egr_nc_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['servicios_egr_nc_impuestos'][10]['valor']."'";       }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['servicios_egr_nc_basicos']['idCentroCosto']) && $_SESSION['servicios_egr_nc_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idLevel_1']) && $_SESSION['servicios_egr_nc_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idLevel_2']) && $_SESSION['servicios_egr_nc_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idLevel_3']) && $_SESSION['servicios_egr_nc_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idLevel_4']) && $_SESSION['servicios_egr_nc_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idLevel_5']) && $_SESSION['servicios_egr_nc_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['servicios_egr_nc_basicos']['idUsoIVA']) && $_SESSION['servicios_egr_nc_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idUsoIVA']."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, Observaciones,
				idSistema, idUsuario, idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idCliente, fecha_auto, ValorNeto, ValorNetoImp,ValorTotal, Impuesto_01,
				Impuesto_02, Impuesto_03, Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08,
				Impuesto_09, Impuesto_10, idEstado, idCentroCosto, idLevel_1, idLevel_2, idLevel_3,
				idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['servicios_egr_nc_productos'])){
						foreach ($_SESSION['servicios_egr_nc_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['idSistema']) && $_SESSION['servicios_egr_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['idUsuario']) && $_SESSION['servicios_egr_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['servicios_egr_nc_basicos']['idDocumentos']) && $_SESSION['servicios_egr_nc_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['N_Doc']) && $_SESSION['servicios_egr_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['idTipo']) && $_SESSION['servicios_egr_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){                                                                  $SIS_data .= ",'".$producto['idServicio']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_ing']) && $producto['Cantidad_ing']!=''){                                                              $SIS_data .= ",'".$producto['Cantidad_ing']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){                                                              $SIS_data .= ",'".$producto['idFrecuencia']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                              $SIS_data .= ",'".$producto['ValorIngreso']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                  $SIS_data .= ",'".$producto['ValorTotal']."'";                                }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['idCliente']) && $_SESSION['servicios_egr_nc_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idCliente']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['fecha_auto']) && $_SESSION['servicios_egr_nc_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocumentos, N_Doc, idTipo, idServicio, Cantidad_ing, idFrecuencia, Valor,ValorTotal,	 idCliente, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['servicios_egr_nc_otros'])){
						foreach ($_SESSION['servicios_egr_nc_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idSistema']) && $_SESSION['servicios_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['idUsuario']) && $_SESSION['servicios_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['servicios_egr_nc_archivos'])){
						foreach ($_SESSION['servicios_egr_nc_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                     $SIS_data  = "'".$ultimo_id."'";                                              }else{$SIS_data  = "''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['idSistema']) && $_SESSION['servicios_egr_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['idUsuario']) && $_SESSION['servicios_egr_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['servicios_egr_nc_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['servicios_egr_nc_basicos']);
					unset($_SESSION['servicios_egr_nc_productos']);
					unset($_SESSION['servicios_egr_nc_temporal']);
					unset($_SESSION['servicios_egr_nc_impuestos']);
					unset($_SESSION['servicios_egr_nc_archivos']);
					unset($_SESSION['servicios_egr_nc_otros']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
