<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-225).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idDocumentos']))      $idDocumentos        = $_POST['idDocumentos'];
	if (!empty($_POST['N_Doc']))             $N_Doc               = $_POST['N_Doc'];
	if (!empty($_POST['idBodega']))          $idBodega            = $_POST['idBodega'];
	if (!empty($_POST['Observaciones']))     $Observaciones       = $_POST['Observaciones'];
	if (!empty($_POST['idSistema']))         $idSistema           = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))         $idUsuario           = $_POST['idUsuario'];
	if (!empty($_POST['Creacion_fecha']))    $Creacion_fecha      = $_POST['Creacion_fecha'];
	if (!empty($_POST['idTipo']))            $idTipo              = $_POST['idTipo'];
	if (!empty($_POST['idProducto']))        $idProducto          = $_POST['idProducto'];
	if (!empty($_POST['Number']))            $Number              = $_POST['Number'];
	if (!empty($_POST['idBodegaOrigen']))    $idBodegaOrigen      = $_POST['idBodegaOrigen'];
	if (!empty($_POST['idBodegaDestino']))   $idBodegaDestino     = $_POST['idBodegaDestino'];
	if (!empty($_POST['Cantidad']))          $Cantidad            = $_POST['Cantidad'];
	if (!empty($_POST['maximo']))            $maximo              = $_POST['maximo'];
	if (!empty($_POST['idSistemaDestino']))  $idSistemaDestino    = $_POST['idSistemaDestino'];
	if (!empty($_POST['idTrabajador']))      $idTrabajador        = $_POST['idTrabajador'];
	if (!empty($_POST['idProveedor']))       $idProveedor         = $_POST['idProveedor'];
	if (!empty($_POST['ValorIngreso']))      $ValorIngreso        = $_POST['ValorIngreso'];
	if (!empty($_POST['ValorEgreso']))       $ValorEgreso         = $_POST['ValorEgreso'];
	if (!empty($_POST['idGuia']))            $idGuia              = $_POST['idGuia'];
	if (!empty($_POST['idDocPago']))         $idDocPago           = $_POST['idDocPago'];
	if (!empty($_POST['N_DocPago']))         $N_DocPago           = $_POST['N_DocPago'];
	if (!empty($_POST['F_Pago']))            $F_Pago              = $_POST['F_Pago'];
	if (!empty($_POST['idFacturacion']))     $idFacturacion       = $_POST['idFacturacion'];
	if (!empty($_POST['idImpuesto']))        $idImpuesto          = $_POST['idImpuesto'];
	if (!empty($_POST['MontoPagado']))       $MontoPagado         = $_POST['MontoPagado'];
	if (!empty($_POST['oldItemID']))         $oldItemID           = $_POST['oldItemID'];
	if (!empty($_POST['montoPactado']))      $montoPactado        = $_POST['montoPactado'];
	if (!empty($_POST['fecha_auto']))        $fecha_auto          = $_POST['fecha_auto'];
	if (!empty($_POST['ValorTotal']))        $ValorTotal          = $_POST['ValorTotal'];
	if (!empty($_POST['Nombre']))            $Nombre              = $_POST['Nombre'];
	if (!empty($_POST['vTotal']))            $vTotal              = $_POST['vTotal'];
	if (!empty($_POST['oldidProducto']))     $oldidProducto       = $_POST['oldidProducto'];
	if (!empty($_POST['idCliente']))         $idCliente           = $_POST['idCliente'];
	if (!empty($_POST['idOcompra']))         $idOcompra           = $_POST['idOcompra'];
	if (!empty($_POST['OC_Ventas']))         $OC_Ventas           = $_POST['OC_Ventas'];
	if (!empty($_POST['Cantidad_ing']))      $Cantidad_ing        = $_POST['Cantidad_ing'];
	if (!empty($_POST['Cantidad_eg']))       $Cantidad_eg         = $_POST['Cantidad_eg'];
	if (!empty($_POST['vUnitario']))         $vUnitario           = $_POST['vUnitario'];
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
			case 'idDocumentos':      if(empty($idDocumentos)){      $error['idDocumentos']     = 'error/No ha ingresado el id';}break;
			case 'N_Doc':             if(empty($N_Doc)){             $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}break;
			case 'idBodega':          if(empty($idBodega)){          $error['idBodega']         = 'error/No ha seleccionado la bodega';}break;
			case 'Observaciones':     if(empty($Observaciones)){     $error['Observaciones']    = 'error/No ha ingresado las obsercaciones';}break;
			case 'idSistema':         if(empty($idSistema)){         $error['idSistema']        = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':         if(empty($idUsuario)){         $error['idUsuario']        = 'error/No ha seleccionado a un usuario';}break;
			case 'Creacion_fecha':    if(empty($Creacion_fecha)){    $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}break;
			case 'idTipo':            if(empty($idTipo)){            $error['idTipo']           = 'error/No ha seleccionado un tipo';}break;
			case 'idProducto':        if(empty($idProducto)){        $error['idProducto']       = 'error/No ha seleccionado un insumo';}break;
			case 'Number':            if(empty($Number)){            $error['Number']           = 'error/No ha ingresado un numero';}break;
			case 'idBodegaOrigen':    if(empty($idBodegaOrigen)){    $error['idBodegaOrigen']   = 'error/No ha seleccionado la bodega de origen';}break;
			case 'idBodegaDestino':   if(empty($idBodegaDestino)){   $error['idBodegaDestino']  = 'error/No ha seleccionado la bodega de destino';}break;
			case 'Cantidad':          if(empty($Cantidad)){          $error['Cantidad']         = 'error/No ha ingresado la cantidad';}break;
			case 'maximo':            if(empty($maximo)){            $error['maximo']           = 'error/No ha ingresado el maximo';}break;
			case 'idSistemaDestino':  if(empty($idSistemaDestino)){  $error['idSistemaDestino'] = 'error/No ha seleccionado el sistema de destino';}break;
			case 'idTrabajador':      if(empty($idTrabajador)){      $error['idTrabajador']     = 'error/No ha seleccionado un trabajador';}break;
			case 'idProveedor':       if(empty($idProveedor)){       $error['idProveedor']      = 'error/No ha seleccionado el proveedor';}break;
			case 'ValorIngreso':      if(empty($ValorIngreso)){      $error['ValorIngreso']     = 'error/No ha ingresado el valor de ingreso';}break;
			case 'ValorEgreso':       if(empty($ValorEgreso)){       $error['ValorEgreso']      = 'error/No ha ingresado el valor de egreso';}break;
			case 'idGuia':            if(empty($idGuia)){            $error['idGuia']           = 'error/No ha seleccionado una guia';}break;
			case 'idDocPago':         if(empty($idDocPago)){         $error['idDocPago']        = 'error/No ha seleccionado un documento de pago';}break;
			case 'N_DocPago':         if(empty($N_DocPago)){         $error['N_DocPago']        = 'error/No ha ingresado un numero de documento de pago';}break;
			case 'F_Pago':            if(empty($F_Pago)){            $error['F_Pago']           = 'error/No ha ingresado una fecha de vencimiento';}break;
			case 'idFacturacion':     if(empty($idFacturacion)){     $error['idFacturacion']    = 'error/No ha ingresado la id de la facturacion';}break;
			case 'idImpuesto':        if(empty($idImpuesto)){        $error['idImpuesto']       = 'error/No ha seleccionado el impuesto';}break;
			case 'MontoPagado':       if(empty($MontoPagado)){       $error['MontoPagado']      = 'error/No ha ingresado el monto de pago';}break;
			case 'montoPactado':      if(empty($montoPactado)){      $error['montoPactado']     = 'error/No ha ingresado el monto pactado';}break;
			case 'fecha_auto':        if(empty($fecha_auto)){        $error['fecha_auto']       = 'error/No ha ingresado la fecha de creación';}break;
			case 'Nombre':            if(empty($Nombre)){            $error['Nombre']           = 'error/No ha ingresado el nombre';}break;
			case 'vTotal':            if(empty($vTotal)){            $error['vTotal']           = 'error/No ha ingresado el valor total';}break;
			case 'oldidProducto':     if(empty($oldidProducto)){     $error['oldidProducto']    = 'error/No ha ingresado el id antiguo';}break;
			case 'idCliente':         if(empty($idCliente)){         $error['idCliente']        = 'error/No ha seleccionado el cliente';}break;
			case 'idOcompra':         if(empty($idOcompra)){         $error['idOcompra']        = 'error/No ha ingresado la OC';}break;
			case 'OC_Ventas':         if(empty($OC_Ventas)){         $error['OC_Ventas']        = 'error/No ha ingresado la OC Relacionada';}break;
			case 'Cantidad_ing':      if(empty($Cantidad_ing)){      $error['Cantidad_ing']     = 'error/No ha ingresado la cantidad';}break;
			case 'Cantidad_eg':       if(empty($Cantidad_eg)){       $error['Cantidad_eg']      = 'error/No ha ingresado la cantidad';}break;
			case 'vUnitario':         if(empty($vUnitario)){         $error['vUnitario']        = 'error/No ha ingresado el valor unitario';}break;

			case 'idCentroCosto':     if(empty($idCentroCosto)){     $error['idCentroCosto']    = 'error/No ha seleccionado el Centro de Costo';}break;
			case 'idLevel_1':         if(empty($idLevel_1)){         $error['idLevel_1']        = 'error/No ha seleccionado el Nivel 1';}break;
			case 'idLevel_2':         if(empty($idLevel_2)){         $error['idLevel_2']        = 'error/No ha seleccionado el Nivel 2';}break;
			case 'idLevel_3':         if(empty($idLevel_3)){         $error['idLevel_3']        = 'error/No ha seleccionado el Nivel 3';}break;
			case 'idLevel_4':         if(empty($idLevel_4)){         $error['idLevel_4']        = 'error/No ha seleccionado el Nivel 4';}break;
			case 'idLevel_5':         if(empty($idLevel_5)){         $error['idLevel_5']        = 'error/No ha seleccionado el Nivel 5';}break;

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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_basicos']);
				unset($_SESSION['insumos_ing_productos']);
				unset($_SESSION['insumos_ing_temporal']);
				unset($_SESSION['insumos_ing_guias']);
				unset($_SESSION['insumos_ing_impuestos']);
				unset($_SESSION['insumos_ing_descuentos']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_ing_archivos'])){
					foreach ($_SESSION['insumos_ing_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_ing_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_ing_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_ing_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_ing_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_ing_basicos']['N_Doc']             = '';}
				if(isset($idBodega) && $idBodega!=''){                   $_SESSION['insumos_ing_basicos']['idBodega']          = $idBodega;          }else{$_SESSION['insumos_ing_basicos']['idBodega']          = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_ing_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_ing_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_ing_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_ing_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_ing_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_ing_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_ing_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_ing_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_ing_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_ing_basicos']['idTipo']            = '';}
				if(isset($idProveedor) && $idProveedor!=''){             $_SESSION['insumos_ing_basicos']['idProveedor']       = $idProveedor;       }else{$_SESSION['insumos_ing_basicos']['idProveedor']       = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_ing_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_ing_basicos']['fecha_auto']        = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){   $_SESSION['insumos_ing_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['insumos_ing_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){   $_SESSION['insumos_ing_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['insumos_ing_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                   $_SESSION['insumos_ing_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['insumos_ing_basicos']['idUsoIVA']          = '';}
				//datos basicos vacios
				$_SESSION['insumos_ing_basicos']['Pago_fecha']        = '0000-00-00';
				$_SESSION['insumos_ing_basicos']['idOcompra']         = '';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_ing_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_ing_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_ing_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_ing_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_ing_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_ing_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_ing_basicos']['idLevel_5']     = 0;

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['insumos_ing_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['insumos_ing_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['Proveedor'] = '';
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_basicos']);
			unset($_SESSION['insumos_ing_productos']);
			unset($_SESSION['insumos_ing_temporal']);
			unset($_SESSION['insumos_ing_guias']);
			unset($_SESSION['insumos_ing_impuestos']);
			unset($_SESSION['insumos_ing_descuentos']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['insumos_ing_archivos'])){
				foreach ($_SESSION['insumos_ing_archivos'] as $key => $producto){
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
			unset($_SESSION['insumos_ing_archivos']);

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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['insumos_ing_productos']);
				unset($_SESSION['insumos_ing_guias']);
				unset($_SESSION['insumos_ing_impuestos']);
				unset($_SESSION['insumos_ing_descuentos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_ing_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_ing_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_ing_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_ing_basicos']['N_Doc']             = '';}
				if(isset($idBodega) && $idBodega!=''){                   $_SESSION['insumos_ing_basicos']['idBodega']          = $idBodega;          }else{$_SESSION['insumos_ing_basicos']['idBodega']          = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_ing_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_ing_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_ing_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_ing_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_ing_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_ing_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_ing_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_ing_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_ing_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_ing_basicos']['idTipo']            = '';}
				if(isset($idProveedor) && $idProveedor!=''){             $_SESSION['insumos_ing_basicos']['idProveedor']       = $idProveedor;       }else{$_SESSION['insumos_ing_basicos']['idProveedor']       = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_ing_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_ing_basicos']['fecha_auto']        = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){   $_SESSION['insumos_ing_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['insumos_ing_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){   $_SESSION['insumos_ing_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['insumos_ing_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                   $_SESSION['insumos_ing_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['insumos_ing_basicos']['idUsoIVA']          = '';}
				//datos basicos vacios
				$_SESSION['insumos_ing_basicos']['Pago_fecha']        = '0000-00-00';
				$_SESSION['insumos_ing_basicos']['idOcompra']         = '';

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['insumos_ing_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['insumos_ing_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_basicos']['Proveedor'] = '';
				}

				//Se redirije
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
				$_SESSION['insumos_ing_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_ing_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_basicos']['idLevel_5']    = $idLevel_5;
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
			if($_SESSION['insumos_ing_basicos']['Creacion_fecha']>$valor){
				$error['ndata_1'] = 'error/La fecha de vencimiento es anterior a la fecha de creación';
			}

			//valido que no esten vacios
			if(empty($valor)){  $error['valor']  = 'error/No ha ingresado una fecha de vencimiento';}

			if(empty($error)){

				$_SESSION['insumos_ing_basicos']['Pago_fecha'] = $valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'delfpago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				$_SESSION['insumos_ing_basicos']['Pago_fecha'] = '0000-00-00';

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_prod_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_ing_productos'][$idProducto[$j1]])&&$_SESSION['insumos_ing_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				// Se trae un listado con todos los productos
				$arrProductos = array();
				$arrProductos = db_select_array (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$arrProd = array();
				foreach ($arrProductos as $producto){
					$arrProd['Prod'][$producto['idProducto']]['Nombre'] = $producto['Nombre'];
					$arrProd['Prod'][$producto['idProducto']]['Unimed'] = $producto['Unimed'];
				}
			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_ing_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_ing_productos'][$idProducto[$j1]]['Number']        = $Number[$j1];
						$_SESSION['insumos_ing_productos'][$idProducto[$j1]]['ValorIngreso']  = $ValorTotal[$j1]/$Number[$j1];
						$_SESSION['insumos_ing_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorTotal[$j1];
						$_SESSION['insumos_ing_productos'][$idProducto[$j1]]['Nombre']        = $arrProd['Prod'][$idProducto[$j1]]['Nombre'];
						$_SESSION['insumos_ing_productos'][$idProducto[$j1]]['Unimed']        = $arrProd['Prod'][$idProducto[$j1]]['Unimed'];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_productos'][$idProducto])&&$_SESSION['insumos_ing_productos'][$idProducto]>0&&$_SESSION['insumos_ing_productos'][$idProducto]!=$_SESSION['insumos_ing_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}
			//Si la cantidad es determinada por una OC verificar si la modificacion no supera el maximo permitido
			if(isset($_SESSION['insumos_ing_basicos']['idOcompra'])&&$_SESSION['insumos_ing_basicos']['idOcompra']!=''){
				if($_SESSION['insumos_ing_productos'][$oldItemID]['cant_max']<($Number + $_SESSION['insumos_ing_productos'][$oldItemID]['cant_ingresada'])){
					$error['productos'] = 'error/No puede ingresar una cantidad superior a la solicitada en la OC (Maximo '.Cantidades_decimales_justos($_SESSION['insumos_ing_productos'][$oldItemID]['cant_max']-$_SESSION['insumos_ing_productos'][$oldItemID]['cant_ingresada']).')';
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Guardo variables si existe una OC
				$temp_idExistencia     = 0;
				$temp_idFrecuencia     = 0;
				$temp_cant_ingresada   = 0;
				$temp_cant_max         = 0;

				if(isset($_SESSION['insumos_ing_basicos']['idOcompra'])&&$_SESSION['insumos_ing_basicos']['idOcompra']!=''){
					$temp_idExistencia     = $_SESSION['insumos_ing_productos'][$oldItemID]['idExistencia'];
					$temp_idFrecuencia     = $_SESSION['insumos_ing_productos'][$oldItemID]['idFrecuencia'];
					$temp_cant_ingresada   = $_SESSION['insumos_ing_productos'][$oldItemID]['cant_ingresada'];
					$temp_cant_max         = $_SESSION['insumos_ing_productos'][$oldItemID]['cant_max'];
				}

				//Borro el producto
				unset($_SESSION['insumos_ing_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_ing_productos'][$idProducto]['idProducto']       = $idProducto;
				$_SESSION['insumos_ing_productos'][$idProducto]['Number']           = $Number;
				$_SESSION['insumos_ing_productos'][$idProducto]['ValorIngreso']     = $ValorIngreso;
				$_SESSION['insumos_ing_productos'][$idProducto]['ValorTotal']       = $ValorTotal;
				$_SESSION['insumos_ing_productos'][$idProducto]['idExistencia']     = $temp_idExistencia;
				$_SESSION['insumos_ing_productos'][$idProducto]['idFrecuencia']     = $temp_idFrecuencia;
				$_SESSION['insumos_ing_productos'][$idProducto]['cant_ingresada']   = $temp_cant_ingresada;
				$_SESSION['insumos_ing_productos'][$idProducto]['cant_max']         = $temp_cant_max;
				$_SESSION['insumos_ing_productos'][$idProducto]['Nombre']           = $rowProducto['Nombre'];
				$_SESSION['insumos_ing_productos'][$idProducto]['Unimed']           = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_guia':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_guias'][$idGuia])&&$_SESSION['insumos_ing_guias'][$idGuia]>0){
				$error['productos'] = 'error/La guia que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos de la guia seleccionada
				$rowGuia = db_select_data (false, 'N_Doc, ValorNeto', 'bodegas_insumos_facturacion', '', 'idFacturacion = "'.$idGuia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$_SESSION['insumos_ing_guias'][$idGuia]['idGuia']     = $idGuia;
				$_SESSION['insumos_ing_guias'][$idGuia]['N_Doc']      = $rowGuia['N_Doc'];
				$_SESSION['insumos_ing_guias'][$idGuia]['ValorNeto']  = $rowGuia['ValorNeto'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_guia':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_guias'][$_GET['del_guia']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_impuestos'][$idImpuesto])&&$_SESSION['insumos_ing_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = '.$idImpuesto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se guarda dato
				$_SESSION['insumos_ing_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;
				$_SESSION['insumos_ing_impuestos'][$idImpuesto]['Nombre']     = $rowImpuesto['Nombre'];
				$_SESSION['insumos_ing_impuestos'][$idImpuesto]['Porcentaje'] = $rowImpuesto['Porcentaje'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_impuestos'][$_GET['del_impuesto']]);

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
			if(isset($_SESSION['insumos_ing_archivos'])){
				foreach ($_SESSION['insumos_ing_archivos'] as $key => $trabajos){
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
						$sufijo = 'insumos_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['insumos_ing_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_ing_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['insumos_ing_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_ing_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_ing_archivos'][$_GET['del_file']]);
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
			if(!isset($_SESSION['insumos_ing_descuentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['insumos_ing_descuentos'] as $key => $producto){
					$idInterno++;
				}
			}
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['insumos_ing_descuentos'][$idInterno]['idDescuento']  = $idInterno;
				$_SESSION['insumos_ing_descuentos'][$idInterno]['Nombre']       = $Nombre;
				$_SESSION['insumos_ing_descuentos'][$idInterno]['vTotal']       = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_desc_ing':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se crea el nuevo producto
				$_SESSION['insumos_ing_descuentos'][$oldidProducto]['idDescuento'] = $oldidProducto;
				$_SESSION['insumos_ing_descuentos'][$oldidProducto]['Nombre']      = $Nombre;
				$_SESSION['insumos_ing_descuentos'][$oldidProducto]['vTotal']      = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_desc_ing':

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_descuentos'][$_GET['del_descuento']]);

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
			if(count(array_filter($idProducto))==0) {$error['ndata_1'] = 'error/No existen Ordenes de Compra con ese numero';}
			//Si la OC existe se verifica si tiene productos para asignar
			if($ndata_1!=0) {
				$ndata_2 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_insumos', '', "idOcompra='".$idOcompra."' AND Cantidad > cant_ingresada", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if($ndata_2==0) {$error['ndata_2'] = 'error/No existen Insumos a asignar';}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se borran los productos
				unset($_SESSION['insumos_ing_productos']);

				//Se traen los productos utilizados
				$arrProductos = array();
				$arrProductos = db_select_array (false, 'ocompra_listado_existencias_insumos.idExistencia, ocompra_listado_existencias_insumos.idProducto, ocompra_listado_existencias_insumos.Cantidad, ocompra_listado_existencias_insumos.vUnitario, ocompra_listado_existencias_insumos.vTotal, ocompra_listado_existencias_insumos.cant_ingresada, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'ocompra_listado_existencias_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = ocompra_listado_existencias_insumos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml','ocompra_listado_existencias_insumos.idOcompra='.$idOcompra.' AND ocompra_listado_existencias_insumos.Cantidad > ocompra_listado_existencias_insumos.cant_ingresada', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Guardo la OC
				$_SESSION['insumos_ing_basicos']['idOcompra'] = $idOcompra;

				//Se guardan los datos
				foreach ($arrProductos as $prod) {
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['idExistencia']   = $prod['idExistencia'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['idProducto']     = $prod['idProducto'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['Number']         = $prod['Cantidad'] - $prod['cant_ingresada'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['ValorIngreso']   = $prod['vUnitario'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['ValorTotal']     = $prod['vTotal'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['cant_ingresada'] = $prod['cant_ingresada'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['cant_max']       = $prod['Cantidad'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['Nombre']         = $prod['Nombre'];
					$_SESSION['insumos_ing_productos'][$prod['idProducto']]['Unimed']         = $prod['Unimed'];
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
			if (isset($_SESSION['insumos_ing_basicos'])){
				if(!isset($_SESSION['insumos_ing_basicos']['idDocumentos']) OR $_SESSION['insumos_ing_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha seleccionado el documento';}
				if(!isset($_SESSION['insumos_ing_basicos']['N_Doc']) OR $_SESSION['insumos_ing_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['insumos_ing_basicos']['idBodega']) OR $_SESSION['insumos_ing_basicos']['idBodega']=='' ){             $error['idBodega']         = 'error/No ha seleccionado la bodega';}
				if(!isset($_SESSION['insumos_ing_basicos']['Observaciones']) OR $_SESSION['insumos_ing_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_ing_basicos']['idSistema']) OR $_SESSION['insumos_ing_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_ing_basicos']['idUsuario']) OR $_SESSION['insumos_ing_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['insumos_ing_basicos']['Creacion_fecha']) OR $_SESSION['insumos_ing_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['insumos_ing_basicos']['idTipo']) OR $_SESSION['insumos_ing_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['insumos_ing_basicos']['idUsoIVA']) OR $_SESSION['insumos_ing_basicos']['idUsoIVA']=='' ){             $error['idUsoIVA']         = 'error/No ha seleccionado la exencion de IVA';}
				//compruebo que sea una factura y que tenga fecha de pago
				if(isset($_SESSION['insumos_ing_basicos']['idDocumentos']) && $_SESSION['insumos_ing_basicos']['idDocumentos']==2 ){
					if(!isset($_SESSION['insumos_ing_basicos']['Pago_fecha']) OR $_SESSION['insumos_ing_basicos']['Pago_fecha']=='' OR $_SESSION['insumos_ing_basicos']['Pago_fecha']=='0000-00-00' ){
						$error['Pago_fecha']  = 'error/No ha ingresado la fecha de vencimiento de la factura';
					}
				}
				//se verifica el uso del iva
				if(isset($_SESSION['insumos_ing_basicos']['idUsoIVA'])&&$_SESSION['insumos_ing_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['insumos_ing_impuestos'])){
						$error['impuesto']  = 'error/No ha seleccionado un impuesto';
					}
				}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}
			//productos o guias
			if (!isset($_SESSION['insumos_ing_productos'])&&!isset($_SESSION['insumos_ing_guias'])){
				$error['idProducto']   = 'error/No se han asignado ni insumos ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['insumos_ing_productos'])){
				foreach ($_SESSION['insumos_ing_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['insumos_ing_guias'])){
				foreach ($_SESSION['insumos_ing_guias'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['trabajos'] = 'error/No se han asignado ni insumos ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_ing_basicos']['idDocumentos']) && $_SESSION['insumos_ing_basicos']['idDocumentos']!=''){      $SIS_data  = "'".$_SESSION['insumos_ing_basicos']['idDocumentos']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_ing_basicos']['N_Doc']) && $_SESSION['insumos_ing_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idBodega']) && $_SESSION['insumos_ing_basicos']['idBodega']!=''){              $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['Observaciones']) && $_SESSION['insumos_ing_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idSistema']) && $_SESSION['insumos_ing_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idUsuario']) && $_SESSION['insumos_ing_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idTipo']) && $_SESSION['insumos_ing_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_ing_basicos']['idProveedor']) && $_SESSION['insumos_ing_basicos']['idProveedor']!=''){ $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idProveedor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['Pago_fecha']) && $_SESSION['insumos_ing_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['insumos_ing_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_ing_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				$SIS_data .= ",''";
				if(isset($_SESSION['insumos_ing_basicos']['fecha_auto']) && $_SESSION['insumos_ing_basicos']['fecha_auto']!=''){                $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['fecha_auto']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['valor_neto_fact'])&&$_SESSION['insumos_ing_basicos']['valor_neto_fact']!=''){        $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['valor_neto_fact']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['valor_neto_imp'])&&$_SESSION['insumos_ing_basicos']['valor_neto_imp']!=''){          $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['valor_neto_imp']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['valor_total_fact'])&&$_SESSION['insumos_ing_basicos']['valor_total_fact']!=''){      $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['valor_total_fact']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][1]['valor'])&&$_SESSION['insumos_ing_impuestos'][1]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][1]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][2]['valor'])&&$_SESSION['insumos_ing_impuestos'][2]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][2]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][3]['valor'])&&$_SESSION['insumos_ing_impuestos'][3]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][3]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][4]['valor'])&&$_SESSION['insumos_ing_impuestos'][4]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][4]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][5]['valor'])&&$_SESSION['insumos_ing_impuestos'][5]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][5]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][6]['valor'])&&$_SESSION['insumos_ing_impuestos'][6]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][6]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][7]['valor'])&&$_SESSION['insumos_ing_impuestos'][7]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][7]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][8]['valor'])&&$_SESSION['insumos_ing_impuestos'][8]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][8]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][9]['valor'])&&$_SESSION['insumos_ing_impuestos'][9]['valor']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][9]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_impuestos'][10]['valor'])&&$_SESSION['insumos_ing_impuestos'][10]['valor']!=''){                $SIS_data .= ",'".$_SESSION['insumos_ing_impuestos'][10]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idOcompra']) && $_SESSION['insumos_ing_basicos']['idOcompra']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idOcompra']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idCentroCosto']) && $_SESSION['insumos_ing_basicos']['idCentroCosto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idCentroCosto']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idLevel_1']) && $_SESSION['insumos_ing_basicos']['idLevel_1']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idLevel_1']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idLevel_2']) && $_SESSION['insumos_ing_basicos']['idLevel_2']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idLevel_2']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idLevel_3']) && $_SESSION['insumos_ing_basicos']['idLevel_3']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idLevel_3']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idLevel_4']) && $_SESSION['insumos_ing_basicos']['idLevel_4']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idLevel_4']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idLevel_5']) && $_SESSION['insumos_ing_basicos']['idLevel_5']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idLevel_5']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['fecha_fact_desde']) && $_SESSION['insumos_ing_basicos']['fecha_fact_desde']!=''){    $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['fecha_fact_desde']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['fecha_fact_hasta']) && $_SESSION['insumos_ing_basicos']['fecha_fact_hasta']!=''){    $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['fecha_fact_hasta']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_basicos']['idUsoIVA']) && $_SESSION['insumos_ing_basicos']['idUsoIVA']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idUsoIVA']."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, idBodegaDestino, Observaciones, idSistema, idUsuario, idTipo,
				Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idProveedor, Pago_fecha, Pago_dia,
				Pago_Semana, Pago_mes, Pago_ano, idEstado, DocRel, fecha_auto, ValorNeto, ValorNetoImp,ValorTotal,
				Impuesto_01,Impuesto_02,Impuesto_03,Impuesto_04,Impuesto_05,Impuesto_06,Impuesto_07,Impuesto_08,
				Impuesto_09, Impuesto_10, idOcompra, idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4,
				idLevel_5, fecha_fact_desde, fecha_fact_hasta, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['insumos_ing_productos'])){
						foreach ($_SESSION['insumos_ing_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                           $SIS_data  = "'".$ultimo_id."'";                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_basicos']['idBodega']) && $_SESSION['insumos_ing_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['idSistema']) && $_SESSION['insumos_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['idUsuario']) && $_SESSION['insumos_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_ing_basicos']['idDocumentos']) && $_SESSION['insumos_ing_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idDocumentos']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['N_Doc']) && $_SESSION['insumos_ing_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['idTipo']) && $_SESSION['insumos_ing_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                        $SIS_data .= ",'".$producto['idProducto']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                $SIS_data .= ",'".$producto['Number']."'";                                    }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                    $SIS_data .= ",'".$producto['ValorIngreso']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                        $SIS_data .= ",'".$producto['ValorTotal']."'";                                }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['idProveedor']) && $_SESSION['insumos_ing_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idProveedor']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['fecha_auto']) && $_SESSION['insumos_ing_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto, Cantidad_ing,
							Valor, ValorTotal, idProveedor, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*******************************************************************/
							//Actualizo el valor de los productos
							$SIS_data = "idProducto='".$producto['idProducto']."'";
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso'] != ''&&isset($_SESSION['insumos_ing_basicos']['idProveedor']) && $_SESSION['insumos_ing_basicos']['idProveedor']!=''){
								$SIS_data .= ",idProveedor='".$_SESSION['insumos_ing_basicos']['idProveedor']."'";
								$SIS_data .= ",ValorIngreso='".$producto['ValorIngreso']."'";
							}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'insumos_listado', 'idProducto = "'.$producto['idProducto'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*******************************************************************/
							//Actualizo lo entregado de la solicitud de la OC si esta existe
							if(isset($_SESSION['insumos_ing_basicos']['idOcompra'])&&$_SESSION['insumos_ing_basicos']['idOcompra']){
								$nueva_cant = $producto['cant_ingresada'] + $producto['Number'];
								$SIS_data = "idExistencia='".$producto['idExistencia']."'";
								$SIS_data .= ",cant_ingresada='".$nueva_cant."'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Descuento
					if(isset($_SESSION['insumos_ing_descuentos'])){
						foreach ($_SESSION['insumos_ing_descuentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                           $SIS_data  = "'".$ultimo_id."'";                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_basicos']['idSistema']) && $_SESSION['insumos_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['idUsuario']) && $_SESSION['insumos_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
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
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_descuentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_ing_archivos'])){
						foreach ($_SESSION['insumos_ing_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                           $SIS_data  = "'".$ultimo_id."'";                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_basicos']['idBodega']) && $_SESSION['insumos_ing_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['idSistema']) && $_SESSION['insumos_ing_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['idUsuario']) && $_SESSION['insumos_ing_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se actualizan las guias a un estado de pago y con relacion al documento recien generado
					if (isset($_SESSION['insumos_ing_guias'])){
						foreach ($_SESSION['insumos_ing_guias'] as $key => $guias){
							//filtro
							if(isset($ultimo_id) && $ultimo_id!=''){

								$SIS_data  = "DocRel='".$ultimo_id."'";
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_insumos_facturacion', 'idFacturacion = "'.$guias['idGuia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_ing_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_ing_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                                //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_ing_basicos']);
					unset($_SESSION['insumos_ing_productos']);
					unset($_SESSION['insumos_ing_temporal']);
					unset($_SESSION['insumos_ing_guias']);
					unset($_SESSION['insumos_ing_impuestos']);
					unset($_SESSION['insumos_ing_archivos']);
					unset($_SESSION['insumos_ing_descuentos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       EGRESOS                                                   */
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
				unset($_SESSION['insumos_egr_basicos']);
				unset($_SESSION['insumos_egr_productos']);
				unset($_SESSION['insumos_egr_temporal']);
				unset($_SESSION['insumos_egr_descuentos']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_egr_archivos'])){
					foreach ($_SESSION['insumos_egr_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_egr_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idBodega) && $idBodega!=''){                   $_SESSION['insumos_egr_basicos']['idBodega']        = $idBodega;        }else{$_SESSION['insumos_egr_basicos']['idBodega']       = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_egr_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['insumos_egr_basicos']['Observaciones']  = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_egr_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['insumos_egr_basicos']['idSistema']      = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_egr_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['insumos_egr_basicos']['idUsuario']      = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_egr_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['insumos_egr_basicos']['Creacion_fecha'] = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_egr_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['insumos_egr_basicos']['idTipo']         = '';}
				if(isset($idTrabajador) && $idTrabajador!=''){           $_SESSION['insumos_egr_basicos']['idTrabajador']    = $idTrabajador;    }else{$_SESSION['insumos_egr_basicos']['idTrabajador']   = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_egr_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['insumos_egr_basicos']['fecha_auto']     = '';}

				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_egr_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['Trabajador'] = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				}else{
					$_SESSION['insumos_egr_basicos']['Trabajador'] = '';
				}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_egr_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_egr_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_egr_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_egr_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_egr_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_egr_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_egr_basicos']['idLevel_5']     = 0;

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_basicos']);
			unset($_SESSION['insumos_egr_productos']);
			unset($_SESSION['insumos_egr_temporal']);
			unset($_SESSION['insumos_egr_descuentos']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['insumos_egr_archivos'])){
				foreach ($_SESSION['insumos_egr_archivos'] as $key => $producto){
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
			unset($_SESSION['insumos_egr_archivos']);

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
				unset($_SESSION['insumos_egr_temporal']);
				//Elimino los productos para eliminar brechas de seguridad
				unset($_SESSION['insumos_egr_productos']);
				unset($_SESSION['insumos_egr_guias']);
				unset($_SESSION['insumos_egr_impuestos']);
				unset($_SESSION['insumos_egr_descuentos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idBodega) && $idBodega!=''){                   $_SESSION['insumos_egr_basicos']['idBodega']        = $idBodega;        }else{$_SESSION['insumos_egr_basicos']['idBodega']       = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_egr_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['insumos_egr_basicos']['Observaciones']  = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_egr_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['insumos_egr_basicos']['idSistema']      = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_egr_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['insumos_egr_basicos']['idUsuario']      = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_egr_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['insumos_egr_basicos']['Creacion_fecha'] = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_egr_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['insumos_egr_basicos']['idTipo']         = '';}
				if(isset($idTrabajador) && $idTrabajador!=''){           $_SESSION['insumos_egr_basicos']['idTrabajador']    = $idTrabajador;    }else{$_SESSION['insumos_egr_basicos']['idTrabajador']   = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_egr_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['insumos_egr_basicos']['fecha_auto']     = '';}

				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_egr_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['Trabajador'] = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				}else{
					$_SESSION['insumos_egr_basicos']['Trabajador'] = '';
				}

				//Se redirije
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
				$_SESSION['insumos_egr_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_egr_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos   = 0;
				$n_existencia  = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_egr_productos'][$idProducto[$j1]])&&$_SESSION['insumos_egr_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}

				//Se verifica si la existencia alcanza
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					$SIS_query = '
					insumos_listado.ValorIngreso,
					insumos_listado.Nombre AS InsumoNombre,
					sistema_productos_uml.Nombre AS Unimed,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
					$SIS_join = '
					LEFT JOIN `insumos_listado`        ON insumos_listado.idProducto    = bodegas_insumos_facturacion_existencias.idProducto
					LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml   = insumos_listado.idUml ';
					$SIS_where = 'bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto[$j1];
					$SIS_where.= ' AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_egr_basicos']['idBodega'];
					$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Sumo los egresos
					$Total_egresos = $rowResultado['egreso'] + $Number[$j1];
					//Verifico si los egresos son inferiores a los ingresos
					if($rowResultado['ingreso']<$Total_egresos){
						$n_existencia++;
					}
					//Guardo el valor ingreso
					$ValorIngreso[$j1]  = $rowResultado['ValorIngreso'];
					$Ins_Nombre[$j1]    = $rowResultado['InsumoNombre'];
					$Ins_Unimed[$j1]    = $rowResultado['Unimed'];
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				//si hay repetidos
				if($n_existencia!=0) {
					$error['productos'] = 'error/No hay suficientes existencias para algunos insumos';
				}

			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_egr_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_egr_productos'][$idProducto[$j1]]['Number']        = $Number[$j1];
						$_SESSION['insumos_egr_productos'][$idProducto[$j1]]['ValorEgreso']   = $ValorIngreso[$j1];
						$_SESSION['insumos_egr_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorIngreso[$j1]*$Number[$j1];
						$_SESSION['insumos_egr_productos'][$idProducto[$j1]]['Nombre']        = $Ins_Nombre[$j1];
						$_SESSION['insumos_egr_productos'][$idProducto[$j1]]['Unimed']        = $Ins_Unimed[$j1];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen los totales de los productos
			$SIS_query = '
			SUM(Cantidad_ing) AS ingreso,
			SUM(Cantidad_eg) AS egreso,
			insumos_listado.Nombre AS InsumoNombre,
			sistema_productos_uml.Nombre AS Unimed';
			$SIS_join = '
			LEFT JOIN `insumos_listado`        ON insumos_listado.idProducto    = bodegas_insumos_facturacion_existencias.idProducto
			LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml   = insumos_listado.idUml';
			$SIS_where = 'idProducto = '.$idProducto.' AND idBodega='.$_SESSION['insumos_egr_basicos']['idBodega'];
			$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Sumo los egresos
			$Total_egresos     = $rowResultado['egreso'] + $Number;
			$Total_existencias = $rowResultado['ingreso'] - $rowResultado['egreso'];
			//Se guardan datos
			$Ins_Nombre    = $rowResultado['InsumoNombre'];
			$Ins_Unimed    = $rowResultado['Unimed'];
			//Verifico si los egresos son inferiores a los ingresos
			if($rowResultado['ingreso']<$Total_egresos){
				$error['productos'] = 'error/No hay suficientes existencias, solo quedan '.$Total_existencias;
			}

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_egr_productos'][$idProducto])&&$_SESSION['insumos_egr_productos'][$idProducto]>0&&$_SESSION['insumos_egr_productos'][$idProducto]!=$_SESSION['insumos_egr_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['insumos_egr_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_egr_productos'][$idProducto]['idProducto']   = $idProducto;
				$_SESSION['insumos_egr_productos'][$idProducto]['Number']       = $Number;
				$_SESSION['insumos_egr_productos'][$idProducto]['ValorEgreso']  = $ValorIngreso;
				$_SESSION['insumos_egr_productos'][$idProducto]['ValorTotal']   = $ValorIngreso*$Number;
				$_SESSION['insumos_egr_productos'][$idProducto]['Nombre']       = $Ins_Nombre;
				$_SESSION['insumos_egr_productos'][$idProducto]['Unimed']       = $Ins_Unimed;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_egr':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_productos'][$_GET['del_prod']]);

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
			if(isset($_SESSION['insumos_egr_archivos'])){
				foreach ($_SESSION['insumos_egr_archivos'] as $key => $trabajos){
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
						$sufijo = 'insumo_egreso_'.genera_password_unica().'_';

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
									$_SESSION['insumos_egr_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_egr_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['insumos_egr_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_egr_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_egr_archivos'][$_GET['del_file']]);
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
			if(!isset($_SESSION['insumos_egr_descuentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['insumos_egr_descuentos'] as $key => $producto){
					$idInterno++;
				}
			}
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['insumos_egr_descuentos'][$idInterno]['idDescuento']  = $idInterno;
				$_SESSION['insumos_egr_descuentos'][$idInterno]['Nombre']       = $Nombre;
				$_SESSION['insumos_egr_descuentos'][$idInterno]['vTotal']       = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_desc_egr':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se crea el nuevo producto
				$_SESSION['insumos_egr_descuentos'][$oldidProducto]['idDescuento'] = $oldidProducto;
				$_SESSION['insumos_egr_descuentos'][$oldidProducto]['Nombre']      = $Nombre;
				$_SESSION['insumos_egr_descuentos'][$oldidProducto]['vTotal']      = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_desc_egr':

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_descuentos'][$_GET['del_descuento']]);

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

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['insumos_egr_basicos'])){
				if(!isset($_SESSION['insumos_egr_basicos']['idBodega']) OR $_SESSION['insumos_egr_basicos']['idBodega']=='' ){             $error['idBodega']         = 'error/No ha seleccionado la bodega';}
				if(!isset($_SESSION['insumos_egr_basicos']['Observaciones']) OR $_SESSION['insumos_egr_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_egr_basicos']['idSistema']) OR $_SESSION['insumos_egr_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_egr_basicos']['idUsuario']) OR $_SESSION['insumos_egr_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['insumos_egr_basicos']['Creacion_fecha']) OR $_SESSION['insumos_egr_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['insumos_egr_basicos']['idTipo']) OR $_SESSION['insumos_egr_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['insumos_egr_basicos']['idTrabajador']) OR $_SESSION['insumos_egr_basicos']['idTrabajador']=='' ){     $error['idTrabajador']     = 'error/No ha seleccionado un trabajador';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al egreso de bodega';
			}
			//productos
			if (isset($_SESSION['insumos_egr_productos'])){
				foreach ($_SESSION['insumos_egr_productos'] as $key => $producto){
					if(!isset($producto['idProducto']) OR $producto['idProducto'] == ''){  $error['idProducto']   = 'error/No ha ingresado un insumo para egresar a bodega';}
					$n_data1++;
				}
			}else{
				$error['idProducto'] = 'error/No tiene insumo asignados a este egreso';
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No tiene insumo asignados a este egreso';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_egr_basicos']['idBodega']) && $_SESSION['insumos_egr_basicos']['idBodega']!=''){              $SIS_data  = "'".$_SESSION['insumos_egr_basicos']['idBodega']."'";       }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_egr_basicos']['Observaciones']) && $_SESSION['insumos_egr_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idSistema']) && $_SESSION['insumos_egr_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idUsuario']) && $_SESSION['insumos_egr_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idTipo']) && $_SESSION['insumos_egr_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idTrabajador']) && $_SESSION['insumos_egr_basicos']['idTrabajador']!=''){      $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idTrabajador']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_egr_basicos']['fecha_auto']) && $_SESSION['insumos_egr_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['fecha_auto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idCentroCosto']) && $_SESSION['insumos_egr_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idCentroCosto']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idLevel_1']) && $_SESSION['insumos_egr_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idLevel_1']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idLevel_2']) && $_SESSION['insumos_egr_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idLevel_2']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idLevel_3']) && $_SESSION['insumos_egr_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idLevel_3']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idLevel_4']) && $_SESSION['insumos_egr_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idLevel_4']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_basicos']['idLevel_5']) && $_SESSION['insumos_egr_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idLevel_5']."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idBodegaOrigen, Observaciones, idSistema, idUsuario, idTipo, idTrabajador,
				Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, fecha_auto, idCentroCosto,
				idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['insumos_egr_productos'])){
						foreach ($_SESSION['insumos_egr_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                           $SIS_data  = "'".$ultimo_id."'";                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_basicos']['idBodega']) && $_SESSION['insumos_egr_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idSistema']) && $_SESSION['insumos_egr_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idUsuario']) && $_SESSION['insumos_egr_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_egr_basicos']['idDocumentos']) && $_SESSION['insumos_egr_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['N_Doc']) && $_SESSION['insumos_egr_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idTipo']) && $_SESSION['insumos_egr_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                        $SIS_data .= ",'".$producto['idProducto']."'";                           }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                $SIS_data .= ",'".$producto['Number']."'";                               }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idTrabajador']) && $_SESSION['insumos_egr_basicos']['idTrabajador']!=''){      $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idTrabajador']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){                                                      $SIS_data .= ",'".$producto['ValorEgreso']."'";                          }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                        $SIS_data .= ",'".$producto['ValorTotal']."'";                           }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idCliente']) && $_SESSION['insumos_egr_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idCliente']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['fecha_auto']) && $_SESSION['insumos_egr_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha, Creacion_mes,
							Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto, Cantidad_eg,idTrabajador, Valor,
							ValorTotal, idCliente, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*******************************************************************/
							//Actualizo el valor de los productos
							$SIS_data = "idProducto='".$producto['idProducto']."'";
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso'] != ''&&isset($_SESSION['insumos_egr_basicos']['idCliente']) && $_SESSION['insumos_egr_basicos']['idCliente']!=''){
								$SIS_data .= ",idCliente='".$_SESSION['insumos_egr_basicos']['idCliente']."'";
								$SIS_data .= ",ValorEgreso='".$producto['ValorEgreso']."'";
							}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'insumos_listado', 'idProducto = "'.$producto['idProducto'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Descuento
					if(isset($_SESSION['insumos_egr_descuentos'])){
						foreach ($_SESSION['insumos_egr_descuentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                           $SIS_data  = "'".$ultimo_id."'";                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_basicos']['idSistema']) && $_SESSION['insumos_egr_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idUsuario']) && $_SESSION['insumos_egr_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
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
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_descuentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_egr_archivos'])){
						foreach ($_SESSION['insumos_egr_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                           $SIS_data  = "'".$ultimo_id."'";                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_basicos']['idBodega']) && $_SESSION['insumos_egr_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idSistema']) && $_SESSION['insumos_egr_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['idUsuario']) && $_SESSION['insumos_egr_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_egr_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_egr_basicos']);
					unset($_SESSION['insumos_egr_productos']);
					unset($_SESSION['insumos_egr_temporal']);
					unset($_SESSION['insumos_egr_archivos']);
					unset($_SESSION['insumos_egr_descuentos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       TRASPASO                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_traspaso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($idBodegaOrigen)&&$idBodegaOrigen!=''&&isset($idBodegaDestino)&&$idBodegaDestino!=''){
				if($idBodegaOrigen==$idBodegaDestino){
					$error['productos'] = 'error/La bodega de Origen y destino es la misma';
				}
			}
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idDocumentos)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_traspaso_basicos']);
				unset($_SESSION['insumos_traspaso_productos']);
				unset($_SESSION['insumos_traspaso_temporal']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_traspaso_basicos']['idDocumentos']    = $idDocumentos;     }else{$_SESSION['insumos_traspaso_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_traspaso_basicos']['N_Doc']           = $N_Doc;            }else{$_SESSION['insumos_traspaso_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_traspaso_basicos']['Observaciones']   = $Observaciones;    }else{$_SESSION['insumos_traspaso_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_traspaso_basicos']['idSistema']       = $idSistema;        }else{$_SESSION['insumos_traspaso_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_traspaso_basicos']['idUsuario']       = $idUsuario;        }else{$_SESSION['insumos_traspaso_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_traspaso_basicos']['Creacion_fecha']  = $Creacion_fecha;   }else{$_SESSION['insumos_traspaso_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_traspaso_basicos']['idTipo']          = $idTipo;           }else{$_SESSION['insumos_traspaso_basicos']['idTipo']           = '';}
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){       $_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']  = $idBodegaOrigen;   }else{$_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']   = '';}
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){     $_SESSION['insumos_traspaso_basicos']['idBodegaDestino'] = $idBodegaDestino;  }else{$_SESSION['insumos_traspaso_basicos']['idBodegaDestino']  = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_traspaso_basicos']['idCliente']       = $idCliente;        }else{$_SESSION['insumos_traspaso_basicos']['idCliente']        = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_traspaso_basicos']['fecha_auto']      = $fecha_auto;       }else{$_SESSION['insumos_traspaso_basicos']['fecha_auto']       = '';}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_traspaso_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){
					// consulto los datos
					$rowBodegaOrigen = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaOrigen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['BodegaOrigen'] = $rowBodegaOrigen['Nombre'];
				}else{
					$_SESSION['insumos_traspaso_basicos']['BodegaOrigen'] = '';
				}
				/****************************************************/
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){
					// consulto los datos
					$rowBodegaDestino = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['BodegaDestino'] = $rowBodegaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspaso_basicos']['BodegaDestino'] = '';
				}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_traspaso_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_traspaso_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_traspaso_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_traspaso_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_traspaso_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_traspaso_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_traspaso_basicos']['idLevel_5']     = 0;

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_traspaso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_traspaso_basicos']);
			unset($_SESSION['insumos_traspaso_productos']);
			unset($_SESSION['insumos_traspaso_temporal']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_traspaso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($idBodegaOrigen)&&$idBodegaOrigen!=''&&isset($idBodegaDestino)&&$idBodegaDestino!=''){
				if($idBodegaOrigen==$idBodegaDestino){
					$error['productos'] = 'error/La bodega de Origen y destino es la misma';
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_traspaso_temporal']);
				//Elimino los productos para eliminar brechas de seguridad
				unset($_SESSION['insumos_traspaso_productos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_traspaso_basicos']['idDocumentos']    = $idDocumentos;     }else{$_SESSION['insumos_traspaso_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_traspaso_basicos']['N_Doc']           = $N_Doc;            }else{$_SESSION['insumos_traspaso_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_traspaso_basicos']['Observaciones']   = $Observaciones;    }else{$_SESSION['insumos_traspaso_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_traspaso_basicos']['idSistema']       = $idSistema;        }else{$_SESSION['insumos_traspaso_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_traspaso_basicos']['idUsuario']       = $idUsuario;        }else{$_SESSION['insumos_traspaso_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_traspaso_basicos']['Creacion_fecha']  = $Creacion_fecha;   }else{$_SESSION['insumos_traspaso_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_traspaso_basicos']['idTipo']          = $idTipo;           }else{$_SESSION['insumos_traspaso_basicos']['idTipo']           = '';}
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){       $_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']  = $idBodegaOrigen;   }else{$_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']   = '';}
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){     $_SESSION['insumos_traspaso_basicos']['idBodegaDestino'] = $idBodegaDestino;  }else{$_SESSION['insumos_traspaso_basicos']['idBodegaDestino']  = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_traspaso_basicos']['idCliente']       = $idCliente;        }else{$_SESSION['insumos_traspaso_basicos']['idCliente']        = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_traspaso_basicos']['fecha_auto']      = $fecha_auto;       }else{$_SESSION['insumos_traspaso_basicos']['fecha_auto']       = '';}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_traspaso_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){
					// consulto los datos
					$rowBodegaOrigen = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaOrigen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['BodegaOrigen'] = $rowBodegaOrigen['Nombre'];
				}else{
					$_SESSION['insumos_traspaso_basicos']['BodegaOrigen'] = '';
				}
				/****************************************************/
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){
					// consulto los datos
					$rowBodegaDestino = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['BodegaDestino'] = $rowBodegaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspaso_basicos']['BodegaDestino'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_traspaso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['insumos_traspaso_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_traspaso_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspaso_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspaso_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspaso_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspaso_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspaso_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspaso_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_traspaso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos   = 0;
				$n_existencia  = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_traspaso_productos'][$idProducto[$j1]])&&$_SESSION['insumos_traspaso_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}

				//Se verifica si la existencia alcanza
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					$SIS_query = '
					insumos_listado.Nombre,
					sistema_productos_uml.Nombre AS Unimed,
					insumos_listado.ValorIngreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
					$SIS_join = '
					LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
					LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
					$SIS_where = '
					bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto[$j1].'
					AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_traspaso_basicos']['idBodegaOrigen'];
					$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Sumo los egresos
					$Total_egresos = $rowResultado['egreso'] + $Number[$j1];
					//Verifico si los egresos son inferiores a los ingresos
					if($rowResultado['ingreso']<$Total_egresos){
						$n_existencia++;
					}
					//Guardo el valor ingreso
					$ValorIngreso[$j1]   = $rowResultado['ValorIngreso'];
					$ProductoNombre[$j1] = $rowResultado['Nombre'];
					$ProductoUnimed[$j1] = $rowResultado['Unimed'];
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				//si hay repetidos
				if($n_existencia!=0) {
					$error['productos'] = 'error/No hay suficientes existencias para algunos insumos';
				}

			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_traspaso_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_traspaso_productos'][$idProducto[$j1]]['Number']        = $Number[$j1];
						$_SESSION['insumos_traspaso_productos'][$idProducto[$j1]]['ValorEgreso']   = $ValorIngreso[$j1];
						$_SESSION['insumos_traspaso_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorIngreso[$j1]*$Number[$j1];
						$_SESSION['insumos_traspaso_productos'][$idProducto[$j1]]['Nombre']        = $ProductoNombre[$j1];
						$_SESSION['insumos_traspaso_productos'][$idProducto[$j1]]['Unimed']        = $ProductoUnimed[$j1];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_traspaso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen los totales de los productos
			$SIS_query = '
			insumos_listado.Nombre,
			sistema_productos_uml.Nombre AS Unimed,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
			$SIS_join = '
			LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
			LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
			$SIS_where = '
			bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto.'
			AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_traspaso_basicos']['idBodegaOrigen'];
			$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Sumo los egresos
			$Total_egresos     = $rowResultado['egreso'] + $Number;
			$Total_existencias = $rowResultado['ingreso'] - $rowResultado['egreso'];
			$ProductoNombre    = $rowResultado['Nombre'];
			$ProductoUnimed    = $rowResultado['Unimed'];
			//Verifico si los egresos son inferiores a los ingresos
			if($rowResultado['ingreso']<$Total_egresos){
				$error['productos'] = 'error/No hay suficientes existencias, solo quedan '.$Total_existencias;
			}

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_traspaso_productos'][$idProducto])&&$_SESSION['insumos_traspaso_productos'][$idProducto]>0&&$_SESSION['insumos_traspaso_productos'][$idProducto]!=$_SESSION['insumos_traspaso_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['insumos_traspaso_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_traspaso_productos'][$idProducto]['idProducto']   = $idProducto;
				$_SESSION['insumos_traspaso_productos'][$idProducto]['Number']       = $Number;
				$_SESSION['insumos_traspaso_productos'][$idProducto]['ValorEgreso']  = $ValorIngreso;
				$_SESSION['insumos_traspaso_productos'][$idProducto]['ValorTotal']   = $ValorIngreso*$Number;
				$_SESSION['insumos_traspaso_productos'][$idProducto]['Nombre']       = $ProductoNombre;
				$_SESSION['insumos_traspaso_productos'][$idProducto]['Unimed']       = $ProductoUnimed;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_traspaso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_traspaso_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'traspaso_bodega':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['insumos_traspaso_basicos'])){
				if(!isset($_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']) OR $_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']=='' ){    $error['idBodegaOrigen']   = 'error/No ha seleccionado la bodega de origen';}
				if(!isset($_SESSION['insumos_traspaso_basicos']['idBodegaDestino']) OR $_SESSION['insumos_traspaso_basicos']['idBodegaDestino']=='' ){  $error['idBodegaDestino']  = 'error/No ha seleccionado la bodega de destino';}
				if(!isset($_SESSION['insumos_traspaso_basicos']['Observaciones']) OR $_SESSION['insumos_traspaso_basicos']['Observaciones']=='' ){      $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_traspaso_basicos']['idSistema']) OR $_SESSION['insumos_traspaso_basicos']['idSistema']=='' ){              $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_traspaso_basicos']['idUsuario']) OR $_SESSION['insumos_traspaso_basicos']['idUsuario']=='' ){              $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['insumos_traspaso_basicos']['Creacion_fecha']) OR $_SESSION['insumos_traspaso_basicos']['Creacion_fecha']=='' ){    $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['insumos_traspaso_basicos']['idTipo']) OR $_SESSION['insumos_traspaso_basicos']['idTipo']=='' ){                    $error['idTipo']           = 'error/No ha seleccionado el tipo';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al traspaso de bodega';
			}
			//productos
			if (isset($_SESSION['insumos_traspaso_productos'])){
				foreach ($_SESSION['insumos_traspaso_productos'] as $key => $producto){
					if(!isset($producto['idProducto']) OR $producto['idProducto'] == ''){  $error['idProducto']   = 'error/No ha ingresado un insumo para traspaso a bodega';}
					$n_data1++;
				}
			}else{
				$error['idProducto'] = 'error/No insumo asignados a este traspaso';
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No insumo asignados a este traspaso';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_traspaso_basicos']['idDocumentos']) && $_SESSION['insumos_traspaso_basicos']['idDocumentos']!=''){        $SIS_data  = "'".$_SESSION['insumos_traspaso_basicos']['idDocumentos']."'";       }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['N_Doc']) && $_SESSION['insumos_traspaso_basicos']['N_Doc']!=''){                      $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['N_Doc']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']) && $_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']!=''){    $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idBodegaDestino']) && $_SESSION['insumos_traspaso_basicos']['idBodegaDestino']!=''){  $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idBodegaDestino']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['Observaciones']) && $_SESSION['insumos_traspaso_basicos']['Observaciones']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['Observaciones']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idSistema']) && $_SESSION['insumos_traspaso_basicos']['idSistema']!=''){              $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idSistema']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idUsuario']) && $_SESSION['insumos_traspaso_basicos']['idUsuario']!=''){              $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idUsuario']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idTipo']) && $_SESSION['insumos_traspaso_basicos']['idTipo']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idTipo']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspaso_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_traspaso_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspaso_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspaso_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_traspaso_basicos']['fecha_auto']) && $_SESSION['insumos_traspaso_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['fecha_auto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idCentroCosto']) && $_SESSION['insumos_traspaso_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idCentroCosto']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idLevel_1']) && $_SESSION['insumos_traspaso_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idLevel_1']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idLevel_2']) && $_SESSION['insumos_traspaso_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idLevel_2']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idLevel_3']) && $_SESSION['insumos_traspaso_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idLevel_3']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idLevel_4']) && $_SESSION['insumos_traspaso_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idLevel_4']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspaso_basicos']['idLevel_5']) && $_SESSION['insumos_traspaso_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idLevel_5']."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, idBodegaOrigen, idBodegaDestino, Observaciones, idSistema,
				idUsuario, idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano,
				fecha_auto, idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['insumos_traspaso_productos'])){
						foreach ($_SESSION['insumos_traspaso_productos'] as $key => $producto){

							//Primero se realiza el egreso del producto
							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                            $SIS_data  = "'".$ultimo_id."'";                                               }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']) && $_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']!=''){  $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idBodegaOrigen']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idSistema']) && $_SESSION['insumos_traspaso_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idSistema']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idUsuario']) && $_SESSION['insumos_traspaso_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idUsuario']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspaso_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspaso_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspaso_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_traspaso_basicos']['idDocumentos']) && $_SESSION['insumos_traspaso_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['N_Doc']) && $_SESSION['insumos_traspaso_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idTipo']) && $_SESSION['insumos_traspaso_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                                  $SIS_data .= ",'".$producto['idProducto']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                          $SIS_data .= ",'".$producto['Number']."'";                                    }else{$SIS_data .= ",''";}
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){                                                                $SIS_data .= ",'".$producto['ValorEgreso']."'";                               }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                  $SIS_data .= ",'".$producto['ValorTotal']."'";                                }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['fecha_auto']) && $_SESSION['insumos_traspaso_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto, Cantidad_eg,
							Valor, ValorTotal, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							//luego se realiza el ingreso del producto
							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                              $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idBodegaDestino']) && $_SESSION['insumos_traspaso_basicos']['idBodegaDestino']!=''){  $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idBodegaDestino']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idSistema']) && $_SESSION['insumos_traspaso_basicos']['idSistema']!=''){              $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idSistema']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idUsuario']) && $_SESSION['insumos_traspaso_basicos']['idUsuario']!=''){              $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idUsuario']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspaso_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspaso_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspaso_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_traspaso_basicos']['idDocumentos']) && $_SESSION['insumos_traspaso_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['N_Doc']) && $_SESSION['insumos_traspaso_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['idTipo']) && $_SESSION['insumos_traspaso_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                                  $SIS_data .= ",'".$producto['idProducto']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                          $SIS_data .= ",'".$producto['Number']."'";                                    }else{$SIS_data .= ",''";}
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){                                                                $SIS_data .= ",'".$producto['ValorEgreso']."'";                               }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                  $SIS_data .= ",'".$producto['ValorTotal']."'";                                }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspaso_basicos']['fecha_auto']) && $_SESSION['insumos_traspaso_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto, Cantidad_ing,
							Valor, ValorTotal, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_traspaso_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspaso_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_traspaso_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_traspaso_basicos']);
					unset($_SESSION['insumos_traspaso_productos']);
					unset($_SESSION['insumos_traspaso_temporal']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                              TRASPASO OTRA EMPRESA                                              */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_traspasoempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si la bodega origen y destino es la misma
			if(isset($idBodegaOrigen)&&$idBodegaOrigen!=''&&isset($idBodegaDestino)&&$idBodegaDestino!=''){
				if($idBodegaOrigen==$idBodegaDestino){
					$error['productos'] = 'error/La bodega de Origen y destino es la misma';
				}
			}
			//verificar si el la empresa origen y destino
			if(isset($idSistema)&&$idSistema!=''&&isset($idSistemaDestino)&&$idSistemaDestino!=''){
				if($idSistema==$idSistemaDestino){
					$error['productos'] = 'error/La empresa de Origen y destino es la misma';
				}
			}
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idDocumentos)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_traspasoempresa_basicos']);
				unset($_SESSION['insumos_traspasoempresa_productos']);
				unset($_SESSION['insumos_traspasoempresa_temporal']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_traspasoempresa_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_traspasoempresa_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_traspasoempresa_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_traspasoempresa_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_traspasoempresa_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_traspasoempresa_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_traspasoempresa_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_traspasoempresa_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_traspasoempresa_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_traspasoempresa_basicos']['idTipo']           = '';}
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){       $_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']    = $idBodegaOrigen;    }else{$_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']   = '';}
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){     $_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']   = $idBodegaDestino;   }else{$_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']  = '';}
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){   $_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']  = $idSistemaDestino;  }else{$_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino'] = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_traspasoempresa_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['insumos_traspasoempresa_basicos']['idCliente']        = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']       = '';}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){
					// consulto los datos
					$rowBodegaOrigen = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaOrigen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaOrigen'] = $rowBodegaOrigen['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaOrigen'] = '';
				}
				/****************************************************/
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){
					// consulto los datos
					$rowBodegaDestino = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaDestino'] = $rowBodegaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaDestino'] = '';
				}
				/****************************************************/
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){
					// consulto los datos
					$rowSistemaDestino = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = "'.$idSistemaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['SistemaDestino'] = $rowSistemaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['SistemaDestino'] = '';
				}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_traspasoempresa_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_traspasoempresa_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_traspasoempresa_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_traspasoempresa_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_traspasoempresa_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_traspasoempresa_basicos']['idLevel_5']     = 0;

				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'clear_all_traspasoempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_traspasoempresa_basicos']);
			unset($_SESSION['insumos_traspasoempresa_productos']);
			unset($_SESSION['insumos_traspasoempresa_temporal']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_traspasoempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($idBodegaOrigen)&&$idBodegaOrigen!=''&&isset($idBodegaDestino)&&$idBodegaDestino!=''){
				if($idBodegaOrigen==$idBodegaDestino){
					$error['productos'] = 'error/La bodega de Origen y destino es la misma';
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_traspasoempresa_temporal']);
				//Elimino los productos para eliminar brechas de seguridad
				unset($_SESSION['insumos_traspasoempresa_productos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']     = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_traspasoempresa_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_traspasoempresa_basicos']['N_Doc']            = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_traspasoempresa_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_traspasoempresa_basicos']['Observaciones']    = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_traspasoempresa_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_traspasoempresa_basicos']['idSistema']        = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_traspasoempresa_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_traspasoempresa_basicos']['idUsuario']        = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']   = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_traspasoempresa_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_traspasoempresa_basicos']['idTipo']           = '';}
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){       $_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']    = $idBodegaOrigen;    }else{$_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']   = '';}
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){     $_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']   = $idBodegaDestino;   }else{$_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']  = '';}
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){   $_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']  = $idSistemaDestino;  }else{$_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino'] = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_traspasoempresa_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['insumos_traspasoempresa_basicos']['idCliente']        = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']       = '';}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){
					// consulto los datos
					$rowBodegaOrigen = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaOrigen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaOrigen'] = $rowBodegaOrigen['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaOrigen'] = '';
				}
				/****************************************************/
				if(isset($idBodegaDestino) && $idBodegaDestino!=''){
					// consulto los datos
					$rowBodegaDestino = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaDestino'] = $rowBodegaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['BodegaDestino'] = '';
				}
				/****************************************************/
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){
					// consulto los datos
					$rowSistemaDestino = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = "'.$idSistemaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['SistemaDestino'] = $rowSistemaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspasoempresa_basicos']['SistemaDestino'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_traspasoempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_traspasoempresa_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasoempresa_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasoempresa_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasoempresa_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasoempresa_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasoempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasoempresa_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_traspasoempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos   = 0;
				$n_existencia  = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]])&&$_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}

				//Se verifica si la existencia alcanza
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					$SIS_query = '
					insumos_listado.Nombre,
					sistema_productos_uml.Nombre AS Unimed,
					insumos_listado.ValorIngreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
					$SIS_join = '
					LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
					LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
					$SIS_where = '
					bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto[$j1].'
					AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen'];
					$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Sumo los egresos
					$Total_egresos = $rowResultado['egreso'] + $Number[$j1];
					//Verifico si los egresos son inferiores a los ingresos
					if($rowResultado['ingreso']<$Total_egresos){
						$n_existencia++;
					}
					//Guardo el valor ingreso
					$ValorIngreso[$j1]   = $rowResultado['ValorIngreso'];
					$ProductoNombre[$j1] = $rowResultado['Nombre'];
					$ProductoUnimed[$j1] = $rowResultado['Unimed'];
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				//si hay repetidos
				if($n_existencia!=0) {
					$error['productos'] = 'error/No hay suficientes existencias para algunos insumos';
				}

			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]]['Number']        = $Number[$j1];
						$_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]]['ValorEgreso']   = $ValorIngreso[$j1];
						$_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorIngreso[$j1]*$Number[$j1];
						$_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]]['Nombre']        = $ProductoNombre[$j1];
						$_SESSION['insumos_traspasoempresa_productos'][$idProducto[$j1]]['Unimed']        = $ProductoUnimed[$j1];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_traspasoempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen los totales de los productos
			$SIS_query = '
			insumos_listado.Nombre,
			sistema_productos_uml.Nombre AS Unimed,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
			$SIS_join = '
			LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
			LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
			$SIS_where = '
			bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto.'
			AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen'];
			$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Sumo los egresos
			$Total_egresos     = $rowResultado['egreso'] + $Number;
			$Total_existencias = $rowResultado['ingreso'] - $rowResultado['egreso'];
			$ProductoNombre    = $rowResultado['Nombre'];
			$ProductoUnimed    = $rowResultado['Unimed'];
			//Verifico si los egresos son inferiores a los ingresos
			if($rowResultado['ingreso']<$Total_egresos){
				$error['productos'] = 'error/No hay suficientes existencias, solo quedan '.$Total_existencias;
			}

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_traspasoempresa_productos'][$idProducto])&&$_SESSION['insumos_traspasoempresa_productos'][$idProducto]>0&&$_SESSION['insumos_traspasoempresa_productos'][$idProducto]!=$_SESSION['insumos_traspasoempresa_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['insumos_traspasoempresa_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_traspasoempresa_productos'][$idProducto]['idProducto']   = $idProducto;
				$_SESSION['insumos_traspasoempresa_productos'][$idProducto]['Number']       = $Number;
				$_SESSION['insumos_traspasoempresa_productos'][$idProducto]['ValorEgreso']  = $ValorIngreso;
				$_SESSION['insumos_traspasoempresa_productos'][$idProducto]['ValorTotal']   = $ValorIngreso*$Number;
				$_SESSION['insumos_traspasoempresa_productos'][$idProducto]['Nombre']       = $ProductoNombre;
				$_SESSION['insumos_traspasoempresa_productos'][$idProducto]['Unimed']       = $ProductoUnimed;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_traspasoempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_traspasoempresa_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'traspaso_otra_empresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['insumos_traspasoempresa_basicos'])){
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']) OR $_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']=='' ){      $error['idBodegaOrigen']    = 'error/No ha seleccionado la bodega de origen';}
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']) OR $_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']=='' ){    $error['idBodegaDestino']   = 'error/No ha seleccionado la bodega de destino';}
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']) OR $_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']=='' ){  $error['idSistemaDestino']  = 'error/No ha seleccionado el sistema de destino';}
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['Observaciones']) OR $_SESSION['insumos_traspasoempresa_basicos']['Observaciones']=='' ){        $error['Observaciones']     = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['idSistema']) OR $_SESSION['insumos_traspasoempresa_basicos']['idSistema']=='' ){                $error['idSistema']         = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['idUsuario']) OR $_SESSION['insumos_traspasoempresa_basicos']['idUsuario']=='' ){                $error['idUsuario']         = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']) OR $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']=='' ){      $error['Creacion_fecha']    = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['insumos_traspasoempresa_basicos']['idTipo']) OR $_SESSION['insumos_traspasoempresa_basicos']['idTipo']=='' ){                      $error['idTipo']            = 'error/No ha seleccionado el tipo';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al traspaso de bodega';
			}
			//productos
			if (isset($_SESSION['insumos_traspasoempresa_productos'])){
				foreach ($_SESSION['insumos_traspasoempresa_productos'] as $key => $producto){
					if(!isset($producto['idProducto']) OR $producto['idProducto'] == ''){  $error['idProducto']   = 'error/No ha ingresado un insumo para traspaso a bodega';}
					$n_data1++;
				}
			}else{
				$error['idProducto'] = 'error/No tiene insumo asignados a este traspaso';
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No tiene insumo asignados a este traspaso';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']) && $_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']!=''){          $SIS_data  = "'".$_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']."'";        }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['N_Doc']) && $_SESSION['insumos_traspasoempresa_basicos']['N_Doc']!=''){                        $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']) && $_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']) && $_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']!=''){    $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']) && $_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']!=''){  $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['Observaciones']) && $_SESSION['insumos_traspasoempresa_basicos']['Observaciones']!=''){        $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['Observaciones']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idSistema']) && $_SESSION['insumos_traspasoempresa_basicos']['idSistema']!=''){                $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idSistema']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idUsuario']) && $_SESSION['insumos_traspasoempresa_basicos']['idUsuario']!=''){                $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idUsuario']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idTipo']) && $_SESSION['insumos_traspasoempresa_basicos']['idTipo']!=''){                      $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']) && $_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idCentroCosto']) && $_SESSION['insumos_traspasoempresa_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idCentroCosto']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idLevel_1']) && $_SESSION['insumos_traspasoempresa_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idLevel_1']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idLevel_2']) && $_SESSION['insumos_traspasoempresa_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idLevel_2']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idLevel_3']) && $_SESSION['insumos_traspasoempresa_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idLevel_3']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idLevel_4']) && $_SESSION['insumos_traspasoempresa_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idLevel_4']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasoempresa_basicos']['idLevel_5']) && $_SESSION['insumos_traspasoempresa_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idLevel_5']."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, idBodegaOrigen, idBodegaDestino,
				idSistemaDestino, Observaciones, idSistema, idUsuario, idTipo, Creacion_fecha,
				Creacion_Semana, Creacion_mes, Creacion_ano, fecha_auto, idCentroCosto, idLevel_1,
				idLevel_2, idLevel_3, idLevel_4, idLevel_5';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['insumos_traspasoempresa_productos'])){
						foreach ($_SESSION['insumos_traspasoempresa_productos'] as $key => $producto){

							//Primero se realiza el egreso del producto
							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                          $SIS_data  = "'".$ultimo_id."'";                                                      }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']) && $_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']!=''){  $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idBodegaOrigen']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idSistema']) && $_SESSION['insumos_traspasoempresa_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idSistema']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idUsuario']) && $_SESSION['insumos_traspasoempresa_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idUsuario']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']) && $_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['N_Doc']) && $_SESSION['insumos_traspasoempresa_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idTipo']) && $_SESSION['insumos_traspasoempresa_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                                                $SIS_data .= ",'".$producto['idProducto']."'";                                       }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                                        $SIS_data .= ",'".$producto['Number']."'";                                           }else{$SIS_data .= ",''";}
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){                                                                              $SIS_data .= ",'".$producto['ValorEgreso']."'";                                      }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                                $SIS_data .= ",'".$producto['ValorTotal']."'";                                       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']) && $_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha, Creacion_mes,
							Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto, Cantidad_eg, Valor, ValorTotal, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							//luego se realiza el ingreso del producto
							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                                $SIS_data  = "'".$ultimo_id."'";                                                         }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']) && $_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idBodegaDestino']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']) && $_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']!=''){    $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idUsuario']) && $_SESSION['insumos_traspasoempresa_basicos']['idUsuario']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idUsuario']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']) && $_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['N_Doc']) && $_SESSION['insumos_traspasoempresa_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idTipo']) && $_SESSION['insumos_traspasoempresa_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                                                $SIS_data .= ",'".$producto['idProducto']."'";                                       }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                                        $SIS_data .= ",'".$producto['Number']."'";                                           }else{$SIS_data .= ",''";}
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){                                                                              $SIS_data .= ",'".$producto['ValorEgreso']."'";                                      }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                                $SIS_data .= ",'".$producto['ValorTotal']."'";                                       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']) && $_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto,
							Cantidad_ing, Valor, ValorTotal, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Busco los usuarios que posean el permiso a la bodega
					$Direccionbase = "bodegas_insumos_stock.php";
					$Notificacion  = '<div class="btn-group" ><a href="view_mov_insumos.php?view='.simpleEncode($ultimo_id, fecha_actual()).'" title= "Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class= "fa fa-list"></i></a></div>';
					$Notificacion .= ' Se ha realizado un traspaso de insumos desde otra empresa';
					$Estado = '1';

					$arrPermiso = array();
					$arrPermiso = db_select_array (false, 'usuarios_permisos.idUsuario', 'usuarios_permisos', 'INNER JOIN core_permisos_listado ON core_permisos_listado.idAdmpm = usuarios_permisos.idAdmpm INNER JOIN usuarios_listado ON usuarios_listado.idUsuario = usuarios_permisos.idUsuario INNER JOIN usuarios_sistemas ON usuarios_sistemas.idUsuario = usuarios_permisos.idUsuario ', 'core_permisos_listado.Direccionbase = "'.$Direccionbase.'" AND usuarios_sistemas.idSistema = '.$_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino'], 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Inserto el mensaje de entrega de materiales
					if ($arrPermiso!=false && !empty($arrPermiso) && $arrPermiso!='') {
						foreach($arrPermiso as $permiso) {
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']) && $_SESSION['insumos_traspasoempresa_basicos']['idSistemaDestino']!=''){   $SIS_data  = "'".$_SESSION['insumos_egr_basicos']['idSistemaDestino']."'";   }else{$SIS_data  = "''";}
							if(isset($permiso['idUsuario']) && $permiso['idUsuario']!=''){                                                                                         $SIS_data .= ",'".$permiso['idUsuario']."'";                                 }else{$SIS_data .= ",''";}
							if(isset($Notificacion) && $Notificacion!=''){                                                                                                         $SIS_data .= ",'".$Notificacion."'";                                         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_basicos']['Creacion_fecha']."'";    }else{$SIS_data .= ",''";}
							if(isset($Estado) && $Estado!=''){                                                                                                                     $SIS_data .= ",'".$Estado."'";                                               }else{$SIS_data .= ",''";}
							$SIS_data .= ",'".hora_actual()."'";

							// inserto los datos de registro en la db
							$SIS_columns = 'idSistema,idUsuario,Notificacion, Fecha, idEstado, Hora';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_notificaciones_ver', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_traspasoempresa_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_traspasoempresa_basicos']);
					unset($_SESSION['insumos_traspasoempresa_productos']);
					unset($_SESSION['insumos_traspasoempresa_temporal']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                           TRASPASO MANUAL OTRA EMPRESA                                          */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_traspasomanualempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el la empresa origen y destino
			if(isset($idSistema)&&$idSistema!=''&&isset($idSistemaDestino)&&$idSistemaDestino!=''){
				if($idSistema==$idSistemaDestino){
					$error['productos'] = 'error/La empresa de Origen y destino es la misma';
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_traspasomanualempresa_basicos']);
				unset($_SESSION['insumos_traspasomanualempresa_productos']);
				unset($_SESSION['insumos_traspasomanualempresa_temporal']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']             = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']            = '';}
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){       $_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']    = $idBodegaOrigen;    }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']    = '';}
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){   $_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']  = $idSistemaDestino;  }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']  = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_traspasomanualempresa_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idCliente']         = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']        = '';}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_traspasomanualempresa_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){
					// consulto los datos
					$rowBodegaOrigen = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaOrigen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['BodegaOrigen'] = $rowBodegaOrigen['Nombre'];
				}else{
					$_SESSION['insumos_traspasomanualempresa_basicos']['BodegaOrigen'] = '';
				}
				/****************************************************/
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){
					// consulto los datos
					$rowSistemaDestino = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = "'.$idSistemaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['SistemaDestino'] = $rowSistemaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspasomanualempresa_basicos']['SistemaDestino'] = '';
				}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_traspasomanualempresa_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_5']     = 0;

				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'clear_all_traspasomanualempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_traspasomanualempresa_basicos']);
			unset($_SESSION['insumos_traspasomanualempresa_productos']);
			unset($_SESSION['insumos_traspasomanualempresa_temporal']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_traspasomanualempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_traspasomanualempresa_temporal']);
				//Elimino los productos para eliminar brechas de seguridad
				unset($_SESSION['insumos_traspasomanualempresa_productos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']             = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']            = '';}
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){       $_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']    = $idBodegaOrigen;    }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']    = '';}
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){   $_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']  = $idSistemaDestino;  }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']  = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_traspasomanualempresa_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['insumos_traspasomanualempresa_basicos']['idCliente']         = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']        = '';}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_traspasomanualempresa_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodegaOrigen) && $idBodegaOrigen!=''){
					// consulto los datos
					$rowBodegaOrigen = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodegaOrigen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['BodegaOrigen'] = $rowBodegaOrigen['Nombre'];
				}else{
					$_SESSION['insumos_traspasomanualempresa_basicos']['BodegaOrigen'] = '';
				}
				/****************************************************/
				if(isset($idSistemaDestino) && $idSistemaDestino!=''){
					// consulto los datos
					$rowSistemaDestino = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema = "'.$idSistemaDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['SistemaDestino'] = $rowSistemaDestino['Nombre'];
				}else{
					$_SESSION['insumos_traspasomanualempresa_basicos']['SistemaDestino'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_traspasomanualempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_traspasomanualempresa_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_traspasomanualempresa_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_traspasomanualempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos   = 0;
				$n_existencia  = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]])&&$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}

				//Se verifica si la existencia alcanza
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					$SIS_query = '
					insumos_listado.Nombre,
					sistema_productos_uml.Nombre AS Unimed,
					insumos_listado.ValorIngreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
					$SIS_join = '
					LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
					LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
					$SIS_where = '
					bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto[$j1].'
					AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen'];
					$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Sumo los egresos
					$Total_egresos = $rowResultado['egreso'] + $Number[$j1];
					//Verifico si los egresos son inferiores a los ingresos
					if($rowResultado['ingreso']<$Total_egresos){
						$n_existencia++;
					}
					//Guardo el valor ingreso
					$ValorIngreso[$j1]   = $rowResultado['ValorIngreso'];
					$ProductoNombre[$j1] = $rowResultado['Nombre'];
					$ProductoUnimed[$j1] = $rowResultado['Unimed'];
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				//si hay repetidos
				if($n_existencia!=0) {
					$error['productos'] = 'error/No hay suficientes existencias para algunos insumos';
				}

			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]]['Number']        = $Number[$j1];
						$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]]['ValorEgreso']   = $ValorIngreso[$j1];
						$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorIngreso[$j1]*$Number[$j1];
						$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]]['Nombre']        = $ProductoNombre[$j1];
						$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto[$j1]]['Unimed']        = $ProductoUnimed[$j1];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_traspasomanualempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen los totales de los productos
			$SIS_query = '
			insumos_listado.Nombre,
			sistema_productos_uml.Nombre AS Unimed,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
			$SIS_join = '
			LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
			LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
			$SIS_where = '
			bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto.'
			AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen'];
			$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Sumo los egresos
			$Total_egresos     = $rowResultado['egreso'] + $Number;
			$Total_existencias = $rowResultado['ingreso'] - $rowResultado['egreso'];
			$ProductoNombre    = $rowResultado['Nombre'];
			$ProductoUnimed    = $rowResultado['Unimed'];
			//Verifico si los egresos son inferiores a los ingresos
			if($rowResultado['ingreso']<$Total_egresos){
				$error['productos'] = 'error/No hay suficientes existencias, solo quedan '.$Total_existencias;
			}

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_traspasomanualempresa_productos'][$idProducto])&&$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]>0&&$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]!=$_SESSION['insumos_traspasomanualempresa_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['insumos_traspasomanualempresa_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]['idProducto']   = $idProducto;
				$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]['Number']       = $Number;
				$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]['ValorEgreso']  = $ValorIngreso;
				$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]['ValorTotal']   = $ValorIngreso*$Number;
				$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]['Nombre']       = $ProductoNombre;
				$_SESSION['insumos_traspasomanualempresa_productos'][$idProducto]['Unimed']       = $ProductoUnimed;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_traspasomanualempresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_traspasomanualempresa_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'traspasomanual_otra_empresa':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['insumos_traspasomanualempresa_basicos'])){
				if(!isset($_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']) OR $_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']=='' ){      $error['idBodegaOrigen']    = 'error/No ha seleccionado la bodega de origen';}
				if(!isset($_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']) OR $_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']=='' ){  $error['idSistemaDestino']  = 'error/No ha seleccionado el sistema de destino';}
				if(!isset($_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']) OR $_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']=='' ){        $error['Observaciones']     = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']) OR $_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']=='' ){                $error['idSistema']         = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']) OR $_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']=='' ){                $error['idUsuario']         = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']) OR $_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']=='' ){      $error['Creacion_fecha']    = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']) OR $_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']=='' ){                      $error['idTipo']            = 'error/No ha seleccionado el tipo';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al traspaso de bodega';
			}
			//productos
			if (isset($_SESSION['insumos_traspasomanualempresa_productos'])){
				foreach ($_SESSION['insumos_traspasomanualempresa_productos'] as $key => $producto){
					if(!isset($producto['idProducto']) OR $producto['idProducto'] == ''){  $error['idProducto']   = 'error/No ha ingresado un insumo para traspaso a bodega';}
					$n_data1++;
				}
			}else{
				$error['idProducto'] = 'error/No tiene insumo asignados a este traspaso';
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No tiene insumo asignados a este traspaso';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']!=''){          $SIS_data  = "'".$_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']."'";        }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']) && $_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']!=''){                        $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']!=''){  $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idSistemaDestino']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']) && $_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']!=''){        $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['Observaciones']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']!=''){                $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']!=''){                $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']!=''){                      $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']) && $_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idCentroCosto']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idCentroCosto']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_1']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_1']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_2']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_2']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_3']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_3']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_4']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_4']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_5']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idLevel_5']."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, idBodegaOrigen, idSistemaDestino, Observaciones,
				idSistema, idUsuario, idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano,
				fecha_auto, idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['insumos_traspasomanualempresa_productos'])){
						foreach ($_SESSION['insumos_traspasomanualempresa_productos'] as $key => $producto){

							//Primero se realiza el egreso del producto
							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                                      $SIS_data  = "'".$ultimo_id."'";                                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']!=''){  $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idBodegaOrigen']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idSistema']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idUsuario']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']) && $_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']) && $_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                                                            $SIS_data .= ",'".$producto['idProducto']."'";                                             }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                                                    $SIS_data .= ",'".$producto['Number']."'";                                                 }else{$SIS_data .= ",''";}
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){                                                                                          $SIS_data .= ",'".$producto['ValorEgreso']."'";                                            }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                                                            $SIS_data .= ",'".$producto['ValorTotal']."'";                                             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']) && $_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto, Cantidad_eg,
							Valor, ValorTotal, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']) && $_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_traspasomanualempresa_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_traspasomanualempresa_basicos']);
					unset($_SESSION['insumos_traspasomanualempresa_productos']);
					unset($_SESSION['insumos_traspasomanualempresa_temporal']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                        OTROS                                                    */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'modFecha':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se actualiza el documento
				$SIS_data = "idFacturacion='".$idFacturacion."'";
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'bodegas_insumos_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se actualizael registro de movimiento de materiales
				$SIS_data = "idFacturacion='".$idFacturacion."'";
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'bodegas_insumos_facturacion_existencias', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  INGRESOS MANUALES                                              */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_ingreso_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_manual_basicos']);
				unset($_SESSION['insumos_ing_manual_productos']);
				unset($_SESSION['insumos_ing_manual_temporal']);
				unset($_SESSION['insumos_ing_manual_impuestos']);
				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_ing_manual_archivos'])){
					foreach ($_SESSION['insumos_ing_manual_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_ing_manual_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_ing_manual_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_ing_manual_basicos']['idBodega']        = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_ing_manual_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_ing_manual_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_ing_manual_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_ing_manual_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_ing_manual_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_ing_manual_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_ing_manual_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_ing_manual_basicos']['idTipo']          = '';}
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['insumos_ing_manual_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['insumos_ing_manual_basicos']['idProveedor']     = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_ing_manual_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_ing_manual_basicos']['fecha_auto']      = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_ing_manual_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_ing_manual_basicos']['idUsoIVA']        = '';}
				//datos basicos vacios
				$_SESSION['insumos_ing_manual_basicos']['Pago_fecha']       = '0000-00-00';
				$_SESSION['insumos_ing_manual_basicos']['idOcompra']        = '';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_ing_manual_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_ing_manual_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_ing_manual_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_ing_manual_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_ing_manual_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_ing_manual_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_ing_manual_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_manual_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_manual_impuestos'][1]['idImpuesto'] = 1;
				}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_manual_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_manual_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_manual_basicos']['Proveedor'] = '';
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_manual_basicos']);
			unset($_SESSION['insumos_ing_manual_productos']);
			unset($_SESSION['insumos_ing_manual_temporal']);
			unset($_SESSION['insumos_ing_manual_impuestos']);
			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_ing_manual_archivos'])){
					foreach ($_SESSION['insumos_ing_manual_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_ing_manual_archivos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_ing_manual_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_ing_manual_basicos']['idBodega']        = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_ing_manual_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_ing_manual_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_ing_manual_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_ing_manual_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_ing_manual_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_ing_manual_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_ing_manual_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_ing_manual_basicos']['idTipo']          = '';}
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['insumos_ing_manual_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['insumos_ing_manual_basicos']['idProveedor']     = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_ing_manual_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_ing_manual_basicos']['fecha_auto']      = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_ing_manual_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_ing_manual_basicos']['idUsoIVA']        = '';}
				//datos basicos vacios
				$_SESSION['insumos_ing_manual_basicos']['Pago_fecha']       = '0000-00-00';
				$_SESSION['insumos_ing_manual_basicos']['idOcompra']        = '';

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_manual_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_manual_impuestos'][1]['idImpuesto'] = 1;
				}

				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_manual_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_manual_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_manual_basicos']['Proveedor'] = '';
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['insumos_ing_manual_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_ing_manual_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_manual_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_manual_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_manual_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_manual_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_manual_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_manual_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_prod_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]])&&$_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				// Se trae un listado con todos los productos
				$arrProductos = array();
				$arrProductos = db_select_array (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$arrProd = array();
				foreach ($arrProductos as $producto){
					$arrProd['Prod'][$producto['idProducto']]['Nombre'] = $producto['Nombre'];
					$arrProd['Prod'][$producto['idProducto']]['Unimed'] = $producto['Unimed'];
				}
			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]]['Number']        = $Number[$j1];
						$_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]]['ValorIngreso']  = $ValorTotal[$j1]/$Number[$j1];
						$_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorTotal[$j1];
						$_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]]['Nombre']        = $arrProd['Prod'][$idProducto[$j1]]['Nombre'];
						$_SESSION['insumos_ing_manual_productos'][$idProducto[$j1]]['Unimed']        = $arrProd['Prod'][$idProducto[$j1]]['Unimed'];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_manual_productos'][$idProducto])&&$_SESSION['insumos_ing_manual_productos'][$idProducto]>0&&$_SESSION['insumos_ing_manual_productos'][$idProducto]!=$_SESSION['insumos_ing_manual_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['insumos_ing_manual_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_ing_manual_productos'][$idProducto]['idProducto']    = $idProducto;
				$_SESSION['insumos_ing_manual_productos'][$idProducto]['Number']        = $Number;
				$_SESSION['insumos_ing_manual_productos'][$idProducto]['ValorIngreso']  = $ValorIngreso;
				$_SESSION['insumos_ing_manual_productos'][$idProducto]['ValorTotal']    = $ValorTotal;
				$_SESSION['insumos_ing_manual_productos'][$idProducto]['Nombre']        = $rowProducto['Nombre'];
				$_SESSION['insumos_ing_manual_productos'][$idProducto]['Unimed']        = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_manual_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_manual_impuestos'][$idImpuesto])&&$_SESSION['insumos_ing_manual_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = '.$idImpuesto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se guarda dato
				$_SESSION['insumos_ing_manual_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;
				$_SESSION['insumos_ing_manual_impuestos'][$idImpuesto]['Nombre']     = $rowImpuesto['Nombre'];
				$_SESSION['insumos_ing_manual_impuestos'][$idImpuesto]['Porcentaje'] = $rowImpuesto['Porcentaje'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_manual_impuestos'][$_GET['del_impuesto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'new_file_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['insumos_ing_manual_archivos'])){
				foreach ($_SESSION['insumos_ing_manual_archivos'] as $key => $trabajos){
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
						$sufijo = 'insumos_ingreso_manual_'.genera_password_unica().'_';

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
									$_SESSION['insumos_ing_manual_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_ing_manual_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_ing_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['insumos_ing_manual_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_ing_manual_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_ing_manual_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'ing_bodega_manual':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['insumos_ing_manual_basicos'])){
				if(!isset($_SESSION['insumos_ing_manual_basicos']['idBodega']) OR $_SESSION['insumos_ing_manual_basicos']['idBodega']=='' ){             $error['idBodega']         = 'error/No ha seleccionado la bodega';}
				if(!isset($_SESSION['insumos_ing_manual_basicos']['Observaciones']) OR $_SESSION['insumos_ing_manual_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_ing_manual_basicos']['idSistema']) OR $_SESSION['insumos_ing_manual_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_ing_manual_basicos']['idUsuario']) OR $_SESSION['insumos_ing_manual_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']) OR $_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['insumos_ing_manual_basicos']['idTipo']) OR $_SESSION['insumos_ing_manual_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				//se verifica el uso del iva
				if(isset($_SESSION['insumos_ing_manual_basicos']['idUsoIVA'])&&$_SESSION['insumos_ing_manual_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['insumos_ing_manual_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}

			//productos o guias
			if (!isset($_SESSION['insumos_ing_manual_productos'])){
				$error['idProducto']   = 'error/No se han asignado insumos';
			}
			//Se verifican productos
			if (isset($_SESSION['insumos_ing_manual_productos'])){
				foreach ($_SESSION['insumos_ing_manual_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['idProducto'] = 'error/No se han asignado insumos';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_ing_manual_basicos']['idBodega']) && $_SESSION['insumos_ing_manual_basicos']['idBodega']!=''){              $SIS_data  = "'".$_SESSION['insumos_ing_manual_basicos']['idBodega']."'";       }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['Observaciones']) && $_SESSION['insumos_ing_manual_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idSistema']) && $_SESSION['insumos_ing_manual_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idUsuario']) && $_SESSION['insumos_ing_manual_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idTipo']) && $_SESSION['insumos_ing_manual_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idProveedor']) && $_SESSION['insumos_ing_manual_basicos']['idProveedor']!=''){   $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idProveedor']."'";        }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'";
				$SIS_data .= ",''";
				if(isset($_SESSION['insumos_ing_manual_basicos']['fecha_auto']) && $_SESSION['insumos_ing_manual_basicos']['fecha_auto']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['valor_neto_fact'])&&$_SESSION['insumos_ing_manual_basicos']['valor_neto_fact']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['valor_neto_fact']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['valor_total_fact'])&&$_SESSION['insumos_ing_manual_basicos']['valor_total_fact']!=''){   $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['valor_total_fact']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][1]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][1]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][1]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][2]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][2]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][2]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][3]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][3]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][3]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][4]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][4]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][4]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][5]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][5]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][5]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][6]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][6]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][6]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][7]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][7]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][7]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][8]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][8]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][8]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][9]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][9]['valor']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][9]['valor']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_impuestos'][10]['valor'])&&$_SESSION['insumos_ing_manual_impuestos'][10]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_manual_impuestos'][10]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idCentroCosto']) && $_SESSION['insumos_ing_manual_basicos']['idCentroCosto']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idCentroCosto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idLevel_1']) && $_SESSION['insumos_ing_manual_basicos']['idLevel_1']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idLevel_1']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idLevel_2']) && $_SESSION['insumos_ing_manual_basicos']['idLevel_2']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idLevel_2']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idLevel_3']) && $_SESSION['insumos_ing_manual_basicos']['idLevel_3']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idLevel_3']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idLevel_4']) && $_SESSION['insumos_ing_manual_basicos']['idLevel_4']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idLevel_4']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idLevel_5']) && $_SESSION['insumos_ing_manual_basicos']['idLevel_5']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idLevel_5']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_manual_basicos']['idUsoIVA']) && $_SESSION['insumos_ing_manual_basicos']['idUsoIVA']!=''){                 $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idUsoIVA']."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idBodegaDestino, Observaciones, idSistema, idUsuario, idTipo, Creacion_fecha,
				Creacion_Semana, Creacion_mes, Creacion_ano, idProveedor, idEstado, DocRel, fecha_auto, ValorNeto,ValorTotal,Impuesto_01,Impuesto_02,Impuesto_03,
				Impuesto_04,Impuesto_05,Impuesto_06,Impuesto_07,Impuesto_08,Impuesto_09,Impuesto_10, idCentroCosto, idLevel_1, idLevel_2, idLevel_3,
				idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['insumos_ing_manual_productos'])){
						foreach ($_SESSION['insumos_ing_manual_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                         $SIS_data  = "'".$ultimo_id."'";                                                }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idBodega']) && $_SESSION['insumos_ing_manual_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idSistema']) && $_SESSION['insumos_ing_manual_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idUsuario']) && $_SESSION['insumos_ing_manual_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idTipo']) && $_SESSION['insumos_ing_manual_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                               $SIS_data .= ",'".$producto['idProducto']."'";                                       }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                       $SIS_data .= ",'".$producto['Number']."'";                                           }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                           $SIS_data .= ",'".$producto['ValorIngreso']."'";                                     }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                               $SIS_data .= ",'".$producto['ValorTotal']."'";                                       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idProveedor']) && $_SESSION['insumos_ing_manual_basicos']['idProveedor']!=''){ $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idProveedor']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['fecha_auto']) && $_SESSION['insumos_ing_manual_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idTipo, idProducto, Cantidad_ing, Valor, ValorTotal,
							idProveedor,fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_ing_manual_archivos'])){
						foreach ($_SESSION['insumos_ing_manual_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                         $SIS_data  = "'".$ultimo_id."'";                                                }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idBodega']) && $_SESSION['insumos_ing_manual_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idSistema']) && $_SESSION['insumos_ing_manual_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['idUsuario']) && $_SESSION['insumos_ing_manual_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_ing_manual_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_ing_manual_basicos']);
					unset($_SESSION['insumos_ing_manual_productos']);
					unset($_SESSION['insumos_ing_manual_temporal']);
					unset($_SESSION['insumos_ing_manual_impuestos']);
					unset($_SESSION['insumos_ing_manual_archivos']);

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
		case 'new_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($idBodegaOrigen)&&$idBodegaOrigen!=''&&isset($idBodegaDestino)&&$idBodegaDestino!=''){
				if($idBodegaOrigen==$idBodegaDestino){
					$error['productos'] = 'error/La bodega de Origen y destino es la misma';
				}
			}
			//Se verifica si el dato existe
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idDocumentos)&&isset($N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_vent_basicos']);
				unset($_SESSION['insumos_vent_productos']);
				unset($_SESSION['insumos_vent_temporal']);
				unset($_SESSION['insumos_vent_guias']);
				unset($_SESSION['insumos_vent_impuestos']);
				unset($_SESSION['insumos_vent_descuentos']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_vent_archivos'])){
					foreach ($_SESSION['insumos_vent_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_vent_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_vent_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_vent_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_vent_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_vent_basicos']['N_Doc']             = '';}
				if(isset($idBodega) && $idBodega!=''){                   $_SESSION['insumos_vent_basicos']['idBodega']          = $idBodega;          }else{$_SESSION['insumos_vent_basicos']['idBodega']          = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_vent_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_vent_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_vent_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_vent_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_vent_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_vent_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_vent_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_vent_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_vent_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_vent_basicos']['idTipo']            = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_vent_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['insumos_vent_basicos']['idCliente']         = '';}
				if(isset($idTrabajador) && $idTrabajador!=''){           $_SESSION['insumos_vent_basicos']['idTrabajador']      = $idTrabajador;      }else{$_SESSION['insumos_vent_basicos']['idTrabajador']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_vent_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_vent_basicos']['fecha_auto']        = '';}
				if(isset($OC_Ventas) && $OC_Ventas!=''){                 $_SESSION['insumos_vent_basicos']['OC_Ventas']         = $OC_Ventas;         }else{$_SESSION['insumos_vent_basicos']['OC_Ventas']         = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){   $_SESSION['insumos_vent_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['insumos_vent_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){   $_SESSION['insumos_vent_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['insumos_vent_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                   $_SESSION['insumos_vent_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['insumos_vent_basicos']['idUsoIVA']          = '';}
				//datos basicos vacios
				$_SESSION['insumos_vent_basicos']['Pago_fecha']      = '0000-00-00';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_vent_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_vent_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_vent_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_vent_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_vent_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_vent_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_vent_basicos']['idLevel_5']     = 0;

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['insumos_vent_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['insumos_vent_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_vent_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_vent_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['Documento'] = '';
				}
				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['Bodega'] = '';
				}
				/********************************************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['Cliente'] = '';
				}
				/********************************************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowVendedor = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Vendedor'] = $rowVendedor['Nombre'].' '.$rowVendedor['ApellidoPat'].' '.$rowVendedor['ApellidoMat'];
				}else{
					$_SESSION['insumos_vent_basicos']['Vendedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_vent_basicos']);
			unset($_SESSION['insumos_vent_productos']);
			unset($_SESSION['insumos_vent_temporal']);
			unset($_SESSION['insumos_vent_guias']);
			unset($_SESSION['insumos_vent_impuestos']);
			unset($_SESSION['insumos_vent_descuentos']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['insumos_vent_archivos'])){
				foreach ($_SESSION['insumos_vent_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_vent_archivos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($idBodegaOrigen)&&$idBodegaOrigen!=''&&isset($idBodegaDestino)&&$idBodegaDestino!=''){
				if($idBodegaOrigen==$idBodegaDestino){
					$error['productos'] = 'error/La bodega de Origen y destino es la misma';
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_vent_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['insumos_vent_productos']);
				unset($_SESSION['insumos_vent_guias']);
				unset($_SESSION['insumos_vent_impuestos']);
				unset($_SESSION['insumos_vent_descuentos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){           $_SESSION['insumos_vent_basicos']['idDocumentos']      = $idDocumentos;      }else{$_SESSION['insumos_vent_basicos']['idDocumentos']      = '';}
				if(isset($N_Doc) && $N_Doc!=''){                         $_SESSION['insumos_vent_basicos']['N_Doc']             = $N_Doc;             }else{$_SESSION['insumos_vent_basicos']['N_Doc']             = '';}
				if(isset($idBodega) && $idBodega!=''){                   $_SESSION['insumos_vent_basicos']['idBodega']          = $idBodega;          }else{$_SESSION['insumos_vent_basicos']['idBodega']          = '';}
				if(isset($Observaciones) && $Observaciones!=''){         $_SESSION['insumos_vent_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['insumos_vent_basicos']['Observaciones']     = '';}
				if(isset($idSistema) && $idSistema!=''){                 $_SESSION['insumos_vent_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['insumos_vent_basicos']['idSistema']         = '';}
				if(isset($idUsuario) && $idUsuario!=''){                 $_SESSION['insumos_vent_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['insumos_vent_basicos']['idUsuario']         = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $_SESSION['insumos_vent_basicos']['Creacion_fecha']    = $Creacion_fecha;    }else{$_SESSION['insumos_vent_basicos']['Creacion_fecha']    = '';}
				if(isset($idTipo) && $idTipo!=''){                       $_SESSION['insumos_vent_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['insumos_vent_basicos']['idTipo']            = '';}
				if(isset($idCliente) && $idCliente!=''){                 $_SESSION['insumos_vent_basicos']['idCliente']         = $idCliente;         }else{$_SESSION['insumos_vent_basicos']['idCliente']         = '';}
				if(isset($idTrabajador) && $idTrabajador!=''){           $_SESSION['insumos_vent_basicos']['idTrabajador']      = $idTrabajador;      }else{$_SESSION['insumos_vent_basicos']['idTrabajador']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){               $_SESSION['insumos_vent_basicos']['fecha_auto']        = $fecha_auto;        }else{$_SESSION['insumos_vent_basicos']['fecha_auto']        = '';}
				if(isset($OC_Ventas) && $OC_Ventas!=''){                 $_SESSION['insumos_vent_basicos']['OC_Ventas']         = $OC_Ventas;         }else{$_SESSION['insumos_vent_basicos']['OC_Ventas']         = '';}
				if(isset($fecha_fact_desde) && $fecha_fact_desde!=''){   $_SESSION['insumos_vent_basicos']['fecha_fact_desde']  = $fecha_fact_desde;  }else{$_SESSION['insumos_vent_basicos']['fecha_fact_desde']  = '';}
				if(isset($fecha_fact_hasta) && $fecha_fact_hasta!=''){   $_SESSION['insumos_vent_basicos']['fecha_fact_hasta']  = $fecha_fact_hasta;  }else{$_SESSION['insumos_vent_basicos']['fecha_fact_hasta']  = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){                   $_SESSION['insumos_vent_basicos']['idUsoIVA']          = $idUsoIVA;          }else{$_SESSION['insumos_vent_basicos']['idUsoIVA']          = '';}
				//datos basicos vacios
				$_SESSION['insumos_vent_basicos']['Pago_fecha']      = '0000-00-00';

				//En caso de que no sea una factura, eliminar los datos previamente rellenados
				if(isset($idDocumentos) && $idDocumentos != ''&& $idDocumentos != 2){
					$_SESSION['insumos_vent_basicos']['fecha_fact_desde'] = '0000-00-00';
					$_SESSION['insumos_vent_basicos']['fecha_fact_hasta'] = '0000-00-00';
				}

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_vent_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_vent_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['Documento'] = '';
				}
				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['Bodega'] = '';
				}
				/********************************************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['insumos_vent_basicos']['Cliente'] = '';
				}
				/********************************************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowVendedor = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['Vendedor'] = $rowVendedor['Nombre'].' '.$rowVendedor['ApellidoPat'].' '.$rowVendedor['ApellidoMat'];
				}else{
					$_SESSION['insumos_vent_basicos']['Vendedor'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'modCentroCosto_venta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Centro de Costo vacio
				$_SESSION['insumos_vent_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_vent_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_vent_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_vent_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_vent_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_vent_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_vent_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_vent_basicos']['idLevel_5']    = $idLevel_5;
				}

				//Se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}
		break;
/*******************************************************************************************************************/
		case 'new_guia_ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_vent_guias'][$idGuia])&&$_SESSION['insumos_vent_guias'][$idGuia]>0){
				$error['productos'] = 'error/La guia que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowGuias = db_select_data (false, 'N_Doc, ValorNeto', 'bodegas_insumos_facturacion', '', 'idFacturacion = "'.$idGuia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se guarda dato
				$_SESSION['insumos_vent_guias'][$idGuia]['N_Doc']     = $rowGuias['N_Doc'];
				$_SESSION['insumos_vent_guias'][$idGuia]['ValorNeto'] = $rowGuias['ValorNeto'];
				$_SESSION['insumos_vent_guias'][$idGuia]['idGuia']    = $idGuia;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_guia_ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_vent_guias'][$_GET['del_guia']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_vent_impuestos'][$idImpuesto])&&$_SESSION['insumos_vent_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = '.$idImpuesto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se guarda dato
				$_SESSION['insumos_vent_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;
				$_SESSION['insumos_vent_impuestos'][$idImpuesto]['Nombre']     = $rowImpuesto['Nombre'];
				$_SESSION['insumos_vent_impuestos'][$idImpuesto]['Porcentaje'] = $rowImpuesto['Porcentaje'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_vent_impuestos'][$_GET['del_impuesto']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'addfpagoVentas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$valor    = $_GET['val_select'];

			//Se comprueba las fechas
			if($_SESSION['insumos_vent_basicos']['Creacion_fecha']>$valor){
				$error['ndata_1'] = 'error/La fecha de vencimiento es anterior a la fecha de creación';
			}

			//valido que no esten vacios
			if(empty($valor)){  $error['valor']  = 'error/No ha ingresado una fecha de vencimiento';}

			if(empty($error)){

				$_SESSION['insumos_vent_basicos']['Pago_fecha'] = $valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'delfpagoVentas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				$_SESSION['insumos_vent_basicos']['Pago_fecha'] = '0000-00-00';

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_prod_Ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos   = 0;
				$n_existencia  = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_vent_productos'][$idProducto[$j1]])&&$_SESSION['insumos_vent_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}

				//Se verifica si la existencia alcanza
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					$SIS_query = '
					insumos_listado.Nombre,
					sistema_productos_uml.Nombre AS Unimed,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
					SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
					$SIS_join = '
					LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
					LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
					$SIS_where = '
					bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto[$j1].'
					AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_vent_basicos']['idBodega'];
					$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Sumo los egresos
					$Total_egresos = $rowResultado['egreso'] + $Number[$j1];
					//Verifico si los egresos son inferiores a los ingresos
					if($rowResultado['ingreso']<$Total_egresos){
						$n_existencia++;
					}
					//Guardo el valor ingreso
					$ProductoNombre[$j1] = $rowResultado['Nombre'];
					$ProductoUnimed[$j1] = $rowResultado['Unimed'];
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				//si hay repetidos
				if($n_existencia!=0) {
					$error['productos'] = 'error/No hay suficientes existencias para algunos insumos';
				}

			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_vent_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_vent_productos'][$idProducto[$j1]]['Number']        = $Number[$j1];
						$_SESSION['insumos_vent_productos'][$idProducto[$j1]]['ValorEgreso']   = $ValorTotal[$j1]/$Number[$j1];
						$_SESSION['insumos_vent_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorTotal[$j1];
						$_SESSION['insumos_vent_productos'][$idProducto[$j1]]['Nombre']        = $ProductoNombre[$j1];
						$_SESSION['insumos_vent_productos'][$idProducto[$j1]]['Unimed']        = $ProductoUnimed[$j1];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_prod_Ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen los totales de los productos
			$SIS_query = '
			insumos_listado.Nombre,
			sistema_productos_uml.Nombre AS Unimed,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_ing) AS ingreso,
			SUM(bodegas_insumos_facturacion_existencias.Cantidad_eg) AS egreso';
			$SIS_join = '
			LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto     = bodegas_insumos_facturacion_existencias.idProducto
			LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = insumos_listado.idUml';
			$SIS_where = '
			bodegas_insumos_facturacion_existencias.idProducto = '.$idProducto.'
			AND bodegas_insumos_facturacion_existencias.idBodega='.$_SESSION['insumos_vent_basicos']['idBodega'];
			$rowResultado = db_select_data (false, $SIS_query, 'bodegas_insumos_facturacion_existencias', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Sumo los egresos
			$Total_egresos     = $rowResultado['egreso'] + $Number;
			$Total_existencias = $rowResultado['ingreso'] - $rowResultado['egreso'];
			$ProductoNombre    = $rowResultado['Nombre'];
			$ProductoUnimed    = $rowResultado['Unimed'];
			//Verifico si los egresos son inferiores a los ingresos
			if($rowResultado['ingreso']<$Total_egresos){
				$error['productos'] = 'error/No hay suficientes existencias, solo quedan '.$Total_existencias;
			}

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_vent_productos'][$idProducto])&&$_SESSION['insumos_vent_productos'][$idProducto]>0&&$_SESSION['insumos_vent_productos'][$idProducto]!=$_SESSION['insumos_vent_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['insumos_vent_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_vent_productos'][$idProducto]['idProducto']   = $idProducto;
				$_SESSION['insumos_vent_productos'][$idProducto]['Number']       = $Number;
				$_SESSION['insumos_vent_productos'][$idProducto]['ValorEgreso']  = $ValorEgreso;
				$_SESSION['insumos_vent_productos'][$idProducto]['ValorTotal']   = $ValorTotal;
				$_SESSION['insumos_vent_productos'][$idProducto]['Nombre']       = $ProductoNombre;
				$_SESSION['insumos_vent_productos'][$idProducto]['Unimed']       = $ProductoUnimed;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_Ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_vent_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'new_file_Ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['insumos_vent_archivos'])){
				foreach ($_SESSION['insumos_vent_archivos'] as $key => $trabajos){
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
						$sufijo = 'producto_egreso_'.genera_password_unica().'_';

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
									$_SESSION['insumos_vent_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_vent_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_Ventas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['insumos_vent_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_vent_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_vent_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'new_desc_Ventas':

			//verificar si existe algun otro dato
			if(!isset($_SESSION['insumos_vent_descuentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['insumos_vent_descuentos'] as $key => $producto){
					$idInterno++;
				}
			}
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['insumos_vent_descuentos'][$idInterno]['idDescuento']  = $idInterno;
				$_SESSION['insumos_vent_descuentos'][$idInterno]['Nombre']       = $Nombre;
				$_SESSION['insumos_vent_descuentos'][$idInterno]['vTotal']       = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_desc_Ventas':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se crea el nuevo producto
				$_SESSION['insumos_vent_descuentos'][$oldidProducto]['idDescuento'] = $oldidProducto;
				$_SESSION['insumos_vent_descuentos'][$oldidProducto]['Nombre']      = $Nombre;
				$_SESSION['insumos_vent_descuentos'][$oldidProducto]['vTotal']      = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_desc_Ventas':

			//Borro todas las sesiones
			unset($_SESSION['insumos_vent_descuentos'][$_GET['del_descuento']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'Venta_bodega':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['insumos_vent_basicos'])){
				if(!isset($_SESSION['insumos_vent_basicos']['idDocumentos']) OR $_SESSION['insumos_vent_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha seleccionado el documentoa';}
				if(!isset($_SESSION['insumos_vent_basicos']['N_Doc']) OR $_SESSION['insumos_vent_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['insumos_vent_basicos']['idBodega']) OR $_SESSION['insumos_vent_basicos']['idBodega']=='' ){             $error['idBodega']         = 'error/No ha seleccionado la bodega';}
				if(!isset($_SESSION['insumos_vent_basicos']['Observaciones']) OR $_SESSION['insumos_vent_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_vent_basicos']['idSistema']) OR $_SESSION['insumos_vent_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_vent_basicos']['idUsuario']) OR $_SESSION['insumos_vent_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha sleccionado el usuario';}
				if(!isset($_SESSION['insumos_vent_basicos']['Creacion_fecha']) OR $_SESSION['insumos_vent_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado una fecha de creación';}
				if(!isset($_SESSION['insumos_vent_basicos']['idTipo']) OR $_SESSION['insumos_vent_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['insumos_vent_basicos']['idCliente']) OR $_SESSION['insumos_vent_basicos']['idCliente']=='' ){           $error['idCliente']        = 'error/No ha seleccionado el cliente';}
				if(!isset($_SESSION['insumos_vent_basicos']['idTrabajador']) OR $_SESSION['insumos_vent_basicos']['idTrabajador']=='' ){     $error['idTrabajador']     = 'error/No ha seleccionado el vendedor';}
				if(!isset($_SESSION['insumos_vent_basicos']['idUsoIVA']) OR $_SESSION['insumos_vent_basicos']['idUsoIVA']=='' ){             $error['idUsoIVA']         = 'error/No ha seleccionado la exencion del IVA';}
				//compruebo que sea una factura y que tenga fecha de pago
				if(isset($_SESSION['insumos_vent_basicos']['idDocumentos']) && $_SESSION['insumos_vent_basicos']['idDocumentos']==2 ){
					if(!isset($_SESSION['insumos_vent_basicos']['Pago_fecha']) OR $_SESSION['insumos_vent_basicos']['Pago_fecha']=='' OR $_SESSION['insumos_vent_basicos']['Pago_fecha']=='0000-00-00' ){
						$error['Pago_fecha']  = 'error/No ha ingresado la fecha de vencimiento de la factura';
					}
				}
				//se verifica el uso del iva
				if(isset($_SESSION['insumos_vent_basicos']['idUsoIVA'])&&$_SESSION['insumos_vent_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['insumos_vent_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al egreso de bodega';
			}
			//productos o guias
			if (!isset($_SESSION['insumos_vent_productos'])&&!isset($_SESSION['insumos_vent_guias'])){
				$error['idProducto']   = 'error/No se han asignado ni insumos ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['insumos_vent_productos'])){
				foreach ($_SESSION['insumos_vent_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['insumos_vent_guias'])){
				foreach ($_SESSION['insumos_vent_guias'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['trabajos'] = 'error/No se han asignado ni insumos ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_vent_basicos']['idDocumentos']) && $_SESSION['insumos_vent_basicos']['idDocumentos']!=''){      $SIS_data  = "'".$_SESSION['insumos_vent_basicos']['idDocumentos']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_vent_basicos']['N_Doc']) && $_SESSION['insumos_vent_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idBodega']) && $_SESSION['insumos_vent_basicos']['idBodega']!=''){              $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['Observaciones']) && $_SESSION['insumos_vent_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idSistema']) && $_SESSION['insumos_vent_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idUsuario']) && $_SESSION['insumos_vent_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idTipo']) && $_SESSION['insumos_vent_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['Creacion_fecha']) && $_SESSION['insumos_vent_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_vent_basicos']['idCliente']) && $_SESSION['insumos_vent_basicos']['idCliente']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idCliente']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idTrabajador']) && $_SESSION['insumos_vent_basicos']['idTrabajador']!=''){       $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idTrabajador']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['fecha_auto']) && $_SESSION['insumos_vent_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['fecha_auto']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['valor_neto_fact'])&&$_SESSION['insumos_vent_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['valor_neto_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['valor_neto_imp'])&&$_SESSION['insumos_vent_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['valor_neto_imp']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['valor_total_fact'])&&$_SESSION['insumos_vent_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['valor_total_fact']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][1]['valor'])&&$_SESSION['insumos_vent_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][1]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][2]['valor'])&&$_SESSION['insumos_vent_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][2]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][3]['valor'])&&$_SESSION['insumos_vent_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][3]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][4]['valor'])&&$_SESSION['insumos_vent_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][4]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][5]['valor'])&&$_SESSION['insumos_vent_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][5]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][6]['valor'])&&$_SESSION['insumos_vent_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][6]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][7]['valor'])&&$_SESSION['insumos_vent_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][7]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][8]['valor'])&&$_SESSION['insumos_vent_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][8]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][9]['valor'])&&$_SESSION['insumos_vent_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][9]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_impuestos'][10]['valor'])&&$_SESSION['insumos_vent_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['insumos_vent_impuestos'][10]['valor']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['Pago_fecha']) && $_SESSION['insumos_vent_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['insumos_vent_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_vent_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_vent_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_vent_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['insumos_vent_basicos']['OC_Ventas']) && $_SESSION['insumos_vent_basicos']['OC_Ventas']!=''){                 $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['OC_Ventas']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idCentroCosto']) && $_SESSION['insumos_vent_basicos']['idCentroCosto']!=''){         $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idCentroCosto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idLevel_1']) && $_SESSION['insumos_vent_basicos']['idLevel_1']!=''){                 $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idLevel_1']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idLevel_2']) && $_SESSION['insumos_vent_basicos']['idLevel_2']!=''){                 $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idLevel_2']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idLevel_3']) && $_SESSION['insumos_vent_basicos']['idLevel_3']!=''){                 $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idLevel_3']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idLevel_4']) && $_SESSION['insumos_vent_basicos']['idLevel_4']!=''){                 $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idLevel_4']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idLevel_5']) && $_SESSION['insumos_vent_basicos']['idLevel_5']!=''){                 $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idLevel_5']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['fecha_fact_desde']) && $_SESSION['insumos_vent_basicos']['fecha_fact_desde']!=''){   $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['fecha_fact_desde']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['fecha_fact_hasta']) && $_SESSION['insumos_vent_basicos']['fecha_fact_hasta']!=''){   $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['fecha_fact_hasta']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_vent_basicos']['idUsoIVA']) && $_SESSION['insumos_vent_basicos']['idUsoIVA']!=''){                   $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idUsoIVA']."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, idBodegaOrigen, Observaciones, idSistema, idUsuario,
				idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idCliente, idTrabajador,
				fecha_auto, ValorNeto, ValorNetoImp, ValorTotal, Impuesto_01, Impuesto_02,
				Impuesto_03, Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08, Impuesto_09,
				Impuesto_10, Pago_fecha, Pago_dia, Pago_Semana, Pago_mes, Pago_ano, idEstado,OC_Ventas,
				idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5, fecha_fact_desde,
				fecha_fact_hasta, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if (isset($_SESSION['insumos_vent_productos'])){
						foreach ($_SESSION['insumos_vent_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                             $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_vent_basicos']['idBodega']) && $_SESSION['insumos_vent_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['idSistema']) && $_SESSION['insumos_vent_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['idUsuario']) && $_SESSION['insumos_vent_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['Creacion_fecha']) && $_SESSION['insumos_vent_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_vent_basicos']['idDocumentos']) && $_SESSION['insumos_vent_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['N_Doc']) && $_SESSION['insumos_vent_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['idTipo']) && $_SESSION['insumos_vent_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                          $SIS_data .= ",'".$producto['idProducto']."'";                            }else{$SIS_data .= ",''";}
							if(isset($producto['Number']) && $producto['Number']!=''){                                                                  $SIS_data .= ",'".$producto['Number']."'";                                }else{$SIS_data .= ",''";}
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){                                                        $SIS_data .= ",'".$producto['ValorEgreso']."'";                           }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                          $SIS_data .= ",'".$producto['ValorTotal']."'";                            }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['idCliente']) && $_SESSION['insumos_vent_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idCliente']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['fecha_auto']) && $_SESSION['insumos_vent_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha, Creacion_mes,
							Creacion_ano, idDocumentos, N_Doc, idTipo, idProducto, Cantidad_eg, Valor, ValorTotal,
							idCliente, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/********************************************************************************/
							//Actualizo el valor de los productos
							$SIS_data = "idProducto='".$producto['idProducto']."'";
							if(isset($producto['ValorEgreso']) && $producto['ValorEgreso']!=''){
								$SIS_data .= ",ValorEgreso='".$producto['ValorEgreso']."'";
							}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'insumos_listado', 'idProducto = "'.$producto['idProducto'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se actualizan las guias a un estado de pago y con relacion al documento recien generado
					if (isset($_SESSION['insumos_vent_guias'])){
						foreach ($_SESSION['insumos_vent_guias'] as $key => $guias){
							//filtro
							if(isset($ultimo_id) && $ultimo_id!=''){

								$SIS_data  = "DocRel='".$ultimo_id."'";
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_insumos_facturacion', 'idFacturacion = "'.$guias['idGuia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Descuento
					if(isset($_SESSION['insumos_vent_descuentos'])){
						foreach ($_SESSION['insumos_vent_descuentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                             $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_vent_basicos']['idSistema']) && $_SESSION['insumos_vent_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['idUsuario']) && $_SESSION['insumos_vent_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['Creacion_fecha']) && $_SESSION['insumos_vent_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
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
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_descuentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_vent_archivos'])){
						foreach ($_SESSION['insumos_vent_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                             $SIS_data  = "'".$ultimo_id."'";                                          }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_vent_basicos']['idBodega']) && $_SESSION['insumos_vent_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['idSistema']) && $_SESSION['insumos_vent_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['idUsuario']) && $_SESSION['insumos_vent_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_vent_basicos']['Creacion_fecha']) && $_SESSION['insumos_vent_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_vent_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_vent_basicos']['Creacion_fecha']) && $_SESSION['insumos_vent_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_vent_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_vent_basicos']);
					unset($_SESSION['insumos_vent_productos']);
					unset($_SESSION['insumos_vent_temporal']);
					unset($_SESSION['insumos_vent_guias']);
					unset($_SESSION['insumos_vent_impuestos']);
					unset($_SESSION['insumos_vent_archivos']);
					unset($_SESSION['insumos_vent_descuentos']);
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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_nd_basicos']);
				unset($_SESSION['insumos_ing_nd_productos']);
				unset($_SESSION['insumos_ing_nd_temporal']);
				unset($_SESSION['insumos_ing_nd_impuestos']);
				unset($_SESSION['insumos_ing_nd_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_ing_nd_archivos'])){
					foreach ($_SESSION['insumos_ing_nd_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_ing_nd_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['insumos_ing_nd_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['insumos_ing_nd_basicos']['idProveedor']     = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_ing_nd_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['insumos_ing_nd_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_ing_nd_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['insumos_ing_nd_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_ing_nd_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_ing_nd_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_ing_nd_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_ing_nd_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_ing_nd_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_ing_nd_basicos']['idUsuario']       = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_ing_nd_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_ing_nd_basicos']['idTipo']          = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_ing_nd_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_ing_nd_basicos']['fecha_auto']      = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_ing_nd_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_ing_nd_basicos']['idBodega']        = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_ing_nd_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_ing_nd_basicos']['idUsoIVA']        = '';}
				//datos basicos vacios
				$_SESSION['insumos_ing_nd_basicos']['Pago_fecha']       = '0000-00-00';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_ing_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_ing_nd_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_ing_nd_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_ing_nd_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_ing_nd_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_ing_nd_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_ing_nd_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['Proveedor'] = '';
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
			unset($_SESSION['insumos_ing_nd_basicos']);
			unset($_SESSION['insumos_ing_nd_productos']);
			unset($_SESSION['insumos_ing_nd_temporal']);
			unset($_SESSION['insumos_ing_nd_impuestos']);
			unset($_SESSION['insumos_ing_nd_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['insumos_ing_nd_archivos'])){
				foreach ($_SESSION['insumos_ing_nd_archivos'] as $key => $producto){
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
			unset($_SESSION['insumos_ing_nd_archivos']);

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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_nd_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['insumos_ing_nd_productos']);
				unset($_SESSION['insumos_ing_nd_guias']);
				unset($_SESSION['insumos_ing_nd_impuestos']);
				unset($_SESSION['insumos_ing_nd_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['insumos_ing_nd_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['insumos_ing_nd_basicos']['idProveedor']     = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_ing_nd_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['insumos_ing_nd_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_ing_nd_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['insumos_ing_nd_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_ing_nd_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_ing_nd_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_ing_nd_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_ing_nd_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_ing_nd_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_ing_nd_basicos']['idUsuario']       = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_ing_nd_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_ing_nd_basicos']['idTipo']          = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_ing_nd_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_ing_nd_basicos']['fecha_auto']      = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_ing_nd_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_ing_nd_basicos']['idBodega']        = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_ing_nd_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_ing_nd_basicos']['idUsoIVA']        = '';}
				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_nd_basicos']['Proveedor'] = '';
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
				$_SESSION['insumos_ing_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_ing_nd_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nd_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nd_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nd_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nd_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nd_basicos']['idLevel_5']    = $idLevel_5;
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

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]])&&$_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				// Se trae un listado con todos los productos
				$arrProductos = array();
				$arrProductos = db_select_array (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$arrProd = array();
				foreach ($arrProductos as $producto){
					$arrProd['Prod'][$producto['idProducto']]['Nombre'] = $producto['Nombre'];
					$arrProd['Prod'][$producto['idProducto']]['Unimed'] = $producto['Unimed'];
				}
			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]]['Cantidad_ing']  = $Cantidad_ing[$j1];
						$_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]]['ValorIngreso']  = $ValorTotal[$j1]/$Cantidad_ing[$j1];
						$_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorTotal[$j1];
						$_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]]['Nombre']        = $arrProd['Prod'][$idProducto[$j1]]['Nombre'];
						$_SESSION['insumos_ing_nd_productos'][$idProducto[$j1]]['Unimed']        = $arrProd['Prod'][$idProducto[$j1]]['Unimed'];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_nd_productos'][$idProducto])&&$_SESSION['insumos_ing_nd_productos'][$idProducto]>0&&$_SESSION['insumos_ing_nd_productos'][$idProducto]!=$_SESSION['insumos_ing_nd_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['insumos_ing_nd_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_ing_nd_productos'][$idProducto]['idProducto']       = $idProducto;
				$_SESSION['insumos_ing_nd_productos'][$idProducto]['Cantidad_ing']     = $Cantidad_ing;
				$_SESSION['insumos_ing_nd_productos'][$idProducto]['ValorIngreso']     = $ValorIngreso;
				$_SESSION['insumos_ing_nd_productos'][$idProducto]['ValorTotal']       = $ValorTotal;
				$_SESSION['insumos_ing_nd_productos'][$idProducto]['Nombre']           = $rowProducto['Nombre'];
				$_SESSION['insumos_ing_nd_productos'][$idProducto]['Unimed']           = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro el producto
			unset($_SESSION['insumos_ing_nd_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['insumos_ing_nd_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['insumos_ing_nd_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['insumos_ing_nd_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['insumos_ing_nd_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['insumos_ing_nd_otros'][$idInterno]['vTotal']   = $vTotal;

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
				$_SESSION['insumos_ing_nd_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['insumos_ing_nd_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['insumos_ing_nd_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_nd_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_nd_impuestos'][$idImpuesto])&&$_SESSION['insumos_ing_nd_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = '.$idImpuesto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se guarda dato
				$_SESSION['insumos_ing_nd_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;
				$_SESSION['insumos_ing_nd_impuestos'][$idImpuesto]['Nombre']     = $rowImpuesto['Nombre'];
				$_SESSION['insumos_ing_nd_impuestos'][$idImpuesto]['Porcentaje'] = $rowImpuesto['Porcentaje'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_ing_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_nd_impuestos'][$_GET['del_impuesto']]);

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
			if(isset($_SESSION['insumos_ing_nd_archivos'])){
				foreach ($_SESSION['insumos_ing_nd_archivos'] as $key => $trabajos){
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
						$sufijo = 'insumos_ingreso_'.genera_password_unica().'_';

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
									$_SESSION['insumos_ing_nd_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_ing_nd_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['insumos_ing_nd_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_ing_nd_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_ing_nd_archivos'][$_GET['del_file']]);
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
			if (isset($_SESSION['insumos_ing_nd_basicos'])){
				if(!isset($_SESSION['insumos_ing_nd_basicos']['idDocumentos']) OR $_SESSION['insumos_ing_nd_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['insumos_ing_nd_basicos']['N_Doc']) OR $_SESSION['insumos_ing_nd_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha seleccionado el area';}
				if(!isset($_SESSION['insumos_ing_nd_basicos']['Observaciones']) OR $_SESSION['insumos_ing_nd_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha seleccionado la maquina';}
				if(!isset($_SESSION['insumos_ing_nd_basicos']['idSistema']) OR $_SESSION['insumos_ing_nd_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha ingresado el id del usuario';}
				if(!isset($_SESSION['insumos_ing_nd_basicos']['idUsuario']) OR $_SESSION['insumos_ing_nd_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha ingresado el id del estado';}
				if(!isset($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']) OR $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la prioridad';}
				if(!isset($_SESSION['insumos_ing_nd_basicos']['idTipo']) OR $_SESSION['insumos_ing_nd_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de trabajo';}
				//se verifica el uso del iva
				if(isset($_SESSION['insumos_ing_nd_basicos']['idUsoIVA'])&&$_SESSION['insumos_ing_nd_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['insumos_ing_nd_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}
			//productos o guias
			if (!isset($_SESSION['insumos_ing_nd_productos'])&&!isset($_SESSION['insumos_ing_nd_otros'])){
				$error['idProducto']   = 'error/No se han asignado insumos ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['insumos_ing_nd_productos'])){
				foreach ($_SESSION['insumos_ing_nd_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['insumos_ing_nd_otros'])){
				foreach ($_SESSION['insumos_ing_nd_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto'] = 'error/No se han asignado insumos ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_ing_nd_basicos']['idBodega']) && $_SESSION['insumos_ing_nd_basicos']['idBodega']!=''){       $SIS_data  = "'".$_SESSION['insumos_ing_nd_basicos']['idBodega']."'";       }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idSistema']) && $_SESSION['insumos_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idUsuario']) && $_SESSION['insumos_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idDocumentos']) && $_SESSION['insumos_ing_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idDocumentos']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['N_Doc']) && $_SESSION['insumos_ing_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['N_Doc']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idTipo']) && $_SESSION['insumos_ing_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['Observaciones']) && $_SESSION['insumos_ing_nd_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idProveedor']) && $_SESSION['insumos_ing_nd_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idProveedor']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['Pago_fecha']) && $_SESSION['insumos_ing_nd_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['insumos_ing_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_ing_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nd_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['insumos_ing_nd_basicos']['fecha_auto']) && $_SESSION['insumos_ing_nd_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['valor_neto_fact'])&&$_SESSION['insumos_ing_nd_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['valor_neto_fact']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['valor_neto_imp'])&&$_SESSION['insumos_ing_nd_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['valor_neto_imp']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['valor_total_fact'])&&$_SESSION['insumos_ing_nd_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['valor_total_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][1]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][1]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][2]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][2]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][3]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][3]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][4]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][4]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][5]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][5]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][6]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][6]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][7]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][7]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][8]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][8]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][9]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][9]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_impuestos'][10]['valor'])&&$_SESSION['insumos_ing_nd_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['insumos_ing_nd_impuestos'][10]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idCentroCosto']) && $_SESSION['insumos_ing_nd_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idCentroCosto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idLevel_1']) && $_SESSION['insumos_ing_nd_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idLevel_1']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idLevel_2']) && $_SESSION['insumos_ing_nd_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idLevel_2']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idLevel_3']) && $_SESSION['insumos_ing_nd_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idLevel_3']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idLevel_4']) && $_SESSION['insumos_ing_nd_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idLevel_4']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idLevel_5']) && $_SESSION['insumos_ing_nd_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idLevel_5']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nd_basicos']['idUsoIVA']) && $_SESSION['insumos_ing_nd_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idUsoIVA']."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idBodegaDestino, idSistema, idUsuario, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idDocumentos, N_Doc, idTipo,Observaciones, idProveedor, Pago_fecha,Pago_dia, Pago_Semana, Pago_mes,
				Pago_ano, idEstado, fecha_auto, ValorNeto, ValorNetoImp, ValorTotal, Impuesto_01, Impuesto_02, Impuesto_03,
				Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08, Impuesto_09, Impuesto_10, idCentroCosto,
				idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['insumos_ing_nd_productos'])){
						foreach ($_SESSION['insumos_ing_nd_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idBodega']) && $_SESSION['insumos_ing_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idSistema']) && $_SESSION['insumos_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idUsuario']) && $_SESSION['insumos_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idDocumentos']) && $_SESSION['insumos_ing_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idDocumentos']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['N_Doc']) && $_SESSION['insumos_ing_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idTipo']) && $_SESSION['insumos_ing_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                              $SIS_data .= ",'".$producto['idProducto']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_ing']) && $producto['Cantidad_ing']!=''){                                                          $SIS_data .= ",'".$producto['Cantidad_ing']."'";                                 }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                          $SIS_data .= ",'".$producto['ValorIngreso']."'";                                 }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                              $SIS_data .= ",'".$producto['ValorTotal']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idProveedor']) && $_SESSION['insumos_ing_nd_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idProveedor']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['fecha_auto']) && $_SESSION['insumos_ing_nd_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario,
							Creacion_fecha, Creacion_mes, Creacion_ano, idDocumentos, N_Doc,
							idTipo, idProducto, Cantidad_ing, Valor, ValorTotal, idProveedor,
							fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['insumos_ing_nd_otros'])){
						foreach ($_SESSION['insumos_ing_nd_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idBodega']) && $_SESSION['insumos_ing_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idSistema']) && $_SESSION['insumos_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idUsuario']) && $_SESSION['insumos_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_ing_nd_archivos'])){
						foreach ($_SESSION['insumos_ing_nd_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idBodega']) && $_SESSION['insumos_ing_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idSistema']) && $_SESSION['insumos_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idUsuario']) && $_SESSION['insumos_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_ing_nd_basicos']);
					unset($_SESSION['insumos_ing_nd_productos']);
					unset($_SESSION['insumos_ing_nd_temporal']);
					unset($_SESSION['insumos_ing_nd_impuestos']);
					unset($_SESSION['insumos_ing_nd_archivos']);
					unset($_SESSION['insumos_ing_nd_otros']);
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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_nc_basicos']);
				unset($_SESSION['insumos_ing_nc_productos']);
				unset($_SESSION['insumos_ing_nc_temporal']);
				unset($_SESSION['insumos_ing_nc_impuestos']);
				unset($_SESSION['insumos_ing_nc_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_ing_nc_archivos'])){
					foreach ($_SESSION['insumos_ing_nc_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_ing_nc_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_ing_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['insumos_ing_nc_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_ing_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['insumos_ing_nc_basicos']['N_Doc']           = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_ing_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_ing_nc_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_ing_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_ing_nc_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_ing_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_ing_nc_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_ing_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_ing_nc_basicos']['idTipo']          = '';}
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['insumos_ing_nc_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['insumos_ing_nc_basicos']['idProveedor']     = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_ing_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_ing_nc_basicos']['fecha_auto']      = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_ing_nc_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_ing_nc_basicos']['idBodega']        = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_ing_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_ing_nc_basicos']['idUsoIVA']        = '';}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_ing_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_ing_nc_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_ing_nc_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_ing_nc_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_ing_nc_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_ing_nc_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_ing_nc_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = mysqli_fetch_assoc ($resultado);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['Proveedor'] = '';
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
			unset($_SESSION['insumos_ing_nc_basicos']);
			unset($_SESSION['insumos_ing_nc_productos']);
			unset($_SESSION['insumos_ing_nc_temporal']);
			unset($_SESSION['insumos_ing_nc_impuestos']);
			unset($_SESSION['insumos_ing_nc_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['insumos_ing_nc_archivos'])){
				foreach ($_SESSION['insumos_ing_nc_archivos'] as $key => $producto){
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
			unset($_SESSION['insumos_ing_nc_archivos']);

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
				unset($_SESSION['insumos_ing_nc_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['insumos_ing_nc_productos']);
				unset($_SESSION['insumos_ing_nc_impuestos']);
				unset($_SESSION['insumos_ing_nc_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_ing_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['insumos_ing_nc_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_ing_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['insumos_ing_nc_basicos']['N_Doc']           = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_ing_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_ing_nc_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_ing_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_ing_nc_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_ing_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_ing_nc_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_ing_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_ing_nc_basicos']['idTipo']          = '';}
				if(isset($idProveedor) && $idProveedor!=''){        $_SESSION['insumos_ing_nc_basicos']['idProveedor']      = $idProveedor;     }else{$_SESSION['insumos_ing_nc_basicos']['idProveedor']     = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_ing_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_ing_nc_basicos']['fecha_auto']      = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_ing_nc_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_ing_nc_basicos']['idBodega']        = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_ing_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_ing_nc_basicos']['idUsoIVA']        = '';}
				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_ing_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_ing_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['Documento'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['TipoDocumento'] = '';
				}
				/****************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['Bodega'] = '';
				}
				/****************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['insumos_ing_nc_basicos']['Proveedor'] = '';
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
				$_SESSION['insumos_ing_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_ing_nc_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nc_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nc_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nc_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nc_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_ing_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_ing_nc_basicos']['idLevel_5']    = $idLevel_5;
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

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]])&&$_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				// Se trae un listado con todos los productos
				$arrProductos = array();
				$arrProductos = db_select_array (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$arrProd = array();
				foreach ($arrProductos as $producto){
					$arrProd['Prod'][$producto['idProducto']]['Nombre'] = $producto['Nombre'];
					$arrProd['Prod'][$producto['idProducto']]['Unimed'] = $producto['Unimed'];
				}
			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]]['Cantidad_eg']   = $Cantidad_eg[$j1];
						$_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]]['ValorIngreso']  = $ValorTotal[$j1]/$Cantidad_eg[$j1];
						$_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorTotal[$j1];
						$_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]]['Nombre']        = $arrProd['Prod'][$idProducto[$j1]]['Nombre'];
						$_SESSION['insumos_ing_nc_productos'][$idProducto[$j1]]['Unimed']        = $arrProd['Prod'][$idProducto[$j1]]['Unimed'];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_nc_productos'][$idProducto])&&$_SESSION['insumos_ing_nc_productos'][$idProducto]>0&&$_SESSION['insumos_ing_nc_productos'][$idProducto]!=$_SESSION['insumos_ing_nc_productos'][$oldItemID]){
				$error['productos'] = 'error/El Insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['insumos_ing_nc_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_ing_nc_productos'][$idProducto]['idProducto']    = $idProducto;
				$_SESSION['insumos_ing_nc_productos'][$idProducto]['Cantidad_eg']   = $Cantidad_eg;
				$_SESSION['insumos_ing_nc_productos'][$idProducto]['ValorIngreso']  = $ValorIngreso;
				$_SESSION['insumos_ing_nc_productos'][$idProducto]['ValorTotal']    = $ValorTotal;
				$_SESSION['insumos_ing_nc_productos'][$idProducto]['Nombre']        = $rowProducto['Nombre'];
				$_SESSION['insumos_ing_nc_productos'][$idProducto]['Unimed']        = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'del_prod_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_nc_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['insumos_ing_nc_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['insumos_ing_nc_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['insumos_ing_nc_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['insumos_ing_nc_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['insumos_ing_nc_otros'][$idInterno]['vTotal']   = $vTotal;

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
				$_SESSION['insumos_ing_nc_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['insumos_ing_nc_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['insumos_ing_nc_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_nc_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_ing_nc_impuestos'][$idImpuesto])&&$_SESSION['insumos_ing_nc_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = '.$idImpuesto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se guarda dato
				$_SESSION['insumos_ing_nc_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;
				$_SESSION['insumos_ing_nc_impuestos'][$idImpuesto]['Nombre']     = $rowImpuesto['Nombre'];
				$_SESSION['insumos_ing_nc_impuestos'][$idImpuesto]['Porcentaje'] = $rowImpuesto['Porcentaje'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_ing_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_ing_nc_impuestos'][$_GET['del_impuesto']]);

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
			if(isset($_SESSION['insumos_ing_nc_archivos'])){
				foreach ($_SESSION['insumos_ing_nc_archivos'] as $key => $trabajos){
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
						$sufijo = 'insumos_egreso_'.genera_password_unica().'_';

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
									$_SESSION['insumos_ing_nc_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_ing_nc_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['insumos_ing_nc_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_ing_nc_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_ing_nc_archivos'][$_GET['del_file']]);
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
			if (isset($_SESSION['insumos_ing_nc_basicos'])){
				if(!isset($_SESSION['insumos_ing_nc_basicos']['idDocumentos']) OR $_SESSION['insumos_ing_nc_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha seleccionado el documentoa';}
				if(!isset($_SESSION['insumos_ing_nc_basicos']['N_Doc']) OR $_SESSION['insumos_ing_nc_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['insumos_ing_nc_basicos']['Observaciones']) OR $_SESSION['insumos_ing_nc_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_ing_nc_basicos']['idSistema']) OR $_SESSION['insumos_ing_nc_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_ing_nc_basicos']['idUsuario']) OR $_SESSION['insumos_ing_nc_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha sleccionado el usuario';}
				if(!isset($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']) OR $_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado una fecha de creación';}
				if(!isset($_SESSION['insumos_ing_nc_basicos']['idTipo']) OR $_SESSION['insumos_ing_nc_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['insumos_ing_nc_basicos']['idProveedor']) OR $_SESSION['insumos_ing_nc_basicos']['idProveedor']=='' ){       $error['idProveedor']      = 'error/No ha seleccionado el proveedor';}
				//se verifica el uso del iva
				if(isset($_SESSION['insumos_ing_nc_basicos']['idUsoIVA'])&&$_SESSION['insumos_ing_nc_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['insumos_ing_nc_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al documento';
			}
			//productos o guias
			if (!isset($_SESSION['insumos_ing_nc_productos'])&&!isset($_SESSION['insumos_ing_nc_otros'])){
				$error['idProducto']   = 'error/No se han asignado ni insumos ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['insumos_ing_nc_productos'])){
				foreach ($_SESSION['insumos_ing_nc_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['insumos_ing_nc_otros'])){
				foreach ($_SESSION['insumos_ing_nc_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto']   = 'error/No se han asignado ni insumos ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_ing_nc_basicos']['idDocumentos']) && $_SESSION['insumos_ing_nc_basicos']['idDocumentos']!=''){      $SIS_data  = "'".$_SESSION['insumos_ing_nc_basicos']['idDocumentos']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['N_Doc']) && $_SESSION['insumos_ing_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['Observaciones']) && $_SESSION['insumos_ing_nc_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idBodega']) && $_SESSION['insumos_ing_nc_basicos']['idBodega']!=''){              $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idSistema']) && $_SESSION['insumos_ing_nc_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idUsuario']) && $_SESSION['insumos_ing_nc_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idTipo']) && $_SESSION['insumos_ing_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idProveedor']) && $_SESSION['insumos_ing_nc_basicos']['idProveedor']!=''){         $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idProveedor']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['fecha_auto']) && $_SESSION['insumos_ing_nc_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['fecha_auto']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['valor_neto_fact'])&&$_SESSION['insumos_ing_nc_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['valor_neto_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['valor_neto_imp'])&&$_SESSION['insumos_ing_nc_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['valor_neto_imp']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['valor_total_fact'])&&$_SESSION['insumos_ing_nc_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['valor_total_fact']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][1]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][1]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][2]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][2]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][3]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][3]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][4]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][4]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][5]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][5]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][6]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][6]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][7]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][7]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][8]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][8]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][9]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][9]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_impuestos'][10]['valor'])&&$_SESSION['insumos_ing_nc_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['insumos_ing_nc_impuestos'][10]['valor']."'";       }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['insumos_ing_nc_basicos']['idCentroCosto']) && $_SESSION['insumos_ing_nc_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idLevel_1']) && $_SESSION['insumos_ing_nc_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idLevel_2']) && $_SESSION['insumos_ing_nc_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idLevel_3']) && $_SESSION['insumos_ing_nc_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idLevel_4']) && $_SESSION['insumos_ing_nc_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idLevel_5']) && $_SESSION['insumos_ing_nc_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_ing_nc_basicos']['idUsoIVA']) && $_SESSION['insumos_ing_nc_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idUsoIVA']."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, Observaciones,
				idBodegaOrigen, idSistema, idUsuario, idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idProveedor, fecha_auto, ValorNeto, ValorNetoImp,ValorTotal, Impuesto_01,
				Impuesto_02, Impuesto_03, Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08,
				Impuesto_09, Impuesto_10, idEstado, idCentroCosto, idLevel_1, idLevel_2, idLevel_3,
				idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['insumos_ing_nc_productos'])){
						foreach ($_SESSION['insumos_ing_nc_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idBodega']) && $_SESSION['insumos_ing_nc_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idSistema']) && $_SESSION['insumos_ing_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idUsuario']) && $_SESSION['insumos_ing_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idDocumentos']) && $_SESSION['insumos_ing_nc_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['N_Doc']) && $_SESSION['insumos_ing_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idTipo']) && $_SESSION['insumos_ing_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                              $SIS_data .= ",'".$producto['idProducto']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_eg']) && $producto['Cantidad_eg']!=''){                                                            $SIS_data .= ",'".$producto['Cantidad_eg']."'";                             }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                          $SIS_data .= ",'".$producto['ValorIngreso']."'";                            }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                              $SIS_data .= ",'".$producto['ValorTotal']."'";                              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idProveedor']) && $_SESSION['insumos_ing_nc_basicos']['idProveedor']!=''){        $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idProveedor']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['fecha_auto']) && $_SESSION['insumos_ing_nc_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocumentos, N_Doc, idTipo, idProducto, Cantidad_eg, Valor,ValorTotal,	 idProveedor, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['insumos_ing_nc_otros'])){
						foreach ($_SESSION['insumos_ing_nc_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idBodega']) && $_SESSION['insumos_ing_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idSistema']) && $_SESSION['insumos_ing_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['idUsuario']) && $_SESSION['insumos_ing_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_ing_nc_archivos'])){
						foreach ($_SESSION['insumos_ing_nc_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idBodega']) && $_SESSION['insumos_ing_nc_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idSistema']) && $_SESSION['insumos_ing_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['idUsuario']) && $_SESSION['insumos_ing_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_ing_nc_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_ing_nc_basicos']);
					unset($_SESSION['insumos_ing_nc_productos']);
					unset($_SESSION['insumos_ing_nc_temporal']);
					unset($_SESSION['insumos_ing_nc_impuestos']);
					unset($_SESSION['insumos_ing_nc_archivos']);
					unset($_SESSION['insumos_ing_nc_otros']);

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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_egr_nd_basicos']);
				unset($_SESSION['insumos_egr_nd_productos']);
				unset($_SESSION['insumos_egr_nd_temporal']);
				unset($_SESSION['insumos_egr_nd_impuestos']);
				unset($_SESSION['insumos_egr_nd_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_egr_nd_archivos'])){
					foreach ($_SESSION['insumos_egr_nd_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_egr_nd_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCliente) && $idCliente!=''){            $_SESSION['insumos_egr_nd_basicos']['idCliente']        = $idCliente;        }else{$_SESSION['insumos_egr_nd_basicos']['idCliente']       = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_egr_nd_basicos']['idDocumentos']     = $idDocumentos;     }else{$_SESSION['insumos_egr_nd_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_egr_nd_basicos']['N_Doc']            = $N_Doc;            }else{$_SESSION['insumos_egr_nd_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;   }else{$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_egr_nd_basicos']['Observaciones']    = $Observaciones;    }else{$_SESSION['insumos_egr_nd_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_egr_nd_basicos']['idSistema']        = $idSistema;        }else{$_SESSION['insumos_egr_nd_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_egr_nd_basicos']['idUsuario']        = $idUsuario;        }else{$_SESSION['insumos_egr_nd_basicos']['idUsuario']       = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_egr_nd_basicos']['idTipo']           = $idTipo;           }else{$_SESSION['insumos_egr_nd_basicos']['idTipo']          = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_egr_nd_basicos']['fecha_auto']       = $fecha_auto;       }else{$_SESSION['insumos_egr_nd_basicos']['fecha_auto']      = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_egr_nd_basicos']['idBodega']         = $idBodega;         }else{$_SESSION['insumos_egr_nd_basicos']['idBodega']        = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_egr_nd_basicos']['idUsoIVA']         = $idUsoIVA;         }else{$_SESSION['insumos_egr_nd_basicos']['idUsoIVA']        = '';}
				//datos basicos vacios
				$_SESSION['insumos_egr_nd_basicos']['Pago_fecha']       = '0000-00-00';

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_egr_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_egr_nd_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_egr_nd_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_egr_nd_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_egr_nd_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_egr_nd_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_egr_nd_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_egr_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_egr_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['Documento'] = '';
				}
				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['Bodega'] = '';
				}
				/********************************************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['Cliente'] = '';
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
			unset($_SESSION['insumos_egr_nd_basicos']);
			unset($_SESSION['insumos_egr_nd_productos']);
			unset($_SESSION['insumos_egr_nd_temporal']);
			unset($_SESSION['insumos_egr_nd_impuestos']);
			unset($_SESSION['insumos_egr_nd_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['insumos_egr_nd_archivos'])){
				foreach ($_SESSION['insumos_egr_nd_archivos'] as $key => $producto){
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
			unset($_SESSION['insumos_egr_nd_archivos']);

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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_egr_nd_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['insumos_egr_nd_productos']);
				unset($_SESSION['insumos_egr_nd_guias']);
				unset($_SESSION['insumos_egr_nd_impuestos']);
				unset($_SESSION['insumos_egr_nd_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idCliente) && $idCliente!=''){            $_SESSION['insumos_egr_nd_basicos']['idCliente']        = $idCliente;        }else{$_SESSION['insumos_egr_nd_basicos']['idCliente']       = '';}
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_egr_nd_basicos']['idDocumentos']     = $idDocumentos;     }else{$_SESSION['insumos_egr_nd_basicos']['idDocumentos']    = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_egr_nd_basicos']['N_Doc']            = $N_Doc;            }else{$_SESSION['insumos_egr_nd_basicos']['N_Doc']           = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']   = $Creacion_fecha;   }else{$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_egr_nd_basicos']['Observaciones']    = $Observaciones;    }else{$_SESSION['insumos_egr_nd_basicos']['Observaciones']   = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_egr_nd_basicos']['idSistema']        = $idSistema;        }else{$_SESSION['insumos_egr_nd_basicos']['idSistema']       = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_egr_nd_basicos']['idUsuario']        = $idUsuario;        }else{$_SESSION['insumos_egr_nd_basicos']['idUsuario']       = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_egr_nd_basicos']['idTipo']           = $idTipo;           }else{$_SESSION['insumos_egr_nd_basicos']['idTipo']          = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_egr_nd_basicos']['fecha_auto']       = $fecha_auto;       }else{$_SESSION['insumos_egr_nd_basicos']['fecha_auto']      = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_egr_nd_basicos']['idBodega']         = $idBodega;         }else{$_SESSION['insumos_egr_nd_basicos']['idBodega']        = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_egr_nd_basicos']['idUsoIVA']         = $idUsoIVA;         }else{$_SESSION['insumos_egr_nd_basicos']['idUsoIVA']        = '';}
				//datos basicos vacios
				$_SESSION['insumos_egr_nd_basicos']['Pago_fecha']       = '0000-00-00';

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_egr_nd_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_egr_nd_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['Documento'] = '';
				}
				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['Bodega'] = '';
				}
				/********************************************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['insumos_egr_nd_basicos']['Cliente'] = '';
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
				$_SESSION['insumos_egr_nd_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_egr_nd_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nd_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nd_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nd_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nd_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nd_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nd_basicos']['idLevel_5']    = $idLevel_5;
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

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]])&&$_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				// Se trae un listado con todos los productos
				$arrProductos = array();
				$arrProductos = db_select_array (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$arrProd = array();
				foreach ($arrProductos as $producto){
					$arrProd['Prod'][$producto['idProducto']]['Nombre'] = $producto['Nombre'];
					$arrProd['Prod'][$producto['idProducto']]['Unimed'] = $producto['Unimed'];
				}
			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]]['Cantidad_eg']   = $Cantidad_eg[$j1];
						$_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]]['ValorIngreso']  = $ValorTotal[$j1]/$Cantidad_eg[$j1];
						$_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorTotal[$j1];
						$_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]]['Nombre']        = $arrProd['Prod'][$idProducto[$j1]]['Nombre'];
						$_SESSION['insumos_egr_nd_productos'][$idProducto[$j1]]['Unimed']        = $arrProd['Prod'][$idProducto[$j1]]['Unimed'];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_egr_nd_productos'][$idProducto])&&$_SESSION['insumos_egr_nd_productos'][$idProducto]>0&&$_SESSION['insumos_egr_nd_productos'][$idProducto]!=$_SESSION['insumos_egr_nd_productos'][$oldItemID]){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// consulto los datos
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['insumos_egr_nd_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_egr_nd_productos'][$idProducto]['idProducto']       = $idProducto;
				$_SESSION['insumos_egr_nd_productos'][$idProducto]['Cantidad_eg']      = $Cantidad_eg;
				$_SESSION['insumos_egr_nd_productos'][$idProducto]['ValorIngreso']     = $ValorIngreso;
				$_SESSION['insumos_egr_nd_productos'][$idProducto]['ValorTotal']       = $ValorTotal;
				$_SESSION['insumos_egr_nd_productos'][$idProducto]['Nombre']           = $rowProducto['Nombre'];
				$_SESSION['insumos_egr_nd_productos'][$idProducto]['Porcentaje']       = $rowProducto['Porcentaje'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro el producto
			unset($_SESSION['insumos_egr_nd_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['insumos_egr_nd_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['insumos_egr_nd_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['insumos_egr_nd_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['insumos_egr_nd_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['insumos_egr_nd_otros'][$idInterno]['vTotal']   = $vTotal;

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
				$_SESSION['insumos_egr_nd_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['insumos_egr_nd_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['insumos_egr_nd_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_nd_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_egr_nd_impuestos'][$idImpuesto])&&$_SESSION['insumos_egr_nd_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = '.$idImpuesto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se guarda dato
				$_SESSION['insumos_egr_nd_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;
				$_SESSION['insumos_egr_nd_impuestos'][$idImpuesto]['Nombre']     = $rowImpuesto['Nombre'];
				$_SESSION['insumos_egr_nd_impuestos'][$idImpuesto]['Porcentaje'] = $rowImpuesto['Porcentaje'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_egr_nd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_nd_impuestos'][$_GET['del_impuesto']]);

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
			if(isset($_SESSION['insumos_egr_nd_archivos'])){
				foreach ($_SESSION['insumos_egr_nd_archivos'] as $key => $trabajos){
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
						$sufijo = 'insumos_egreso_'.genera_password_unica().'_';

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
									$_SESSION['insumos_egr_nd_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_egr_nd_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['insumos_egr_nd_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_egr_nd_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_egr_nd_archivos'][$_GET['del_file']]);
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
			if (isset($_SESSION['insumos_egr_nd_basicos'])){
				if(!isset($_SESSION['insumos_egr_nd_basicos']['idDocumentos']) OR $_SESSION['insumos_egr_nd_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['insumos_egr_nd_basicos']['N_Doc']) OR $_SESSION['insumos_egr_nd_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha seleccionado el area';}
				if(!isset($_SESSION['insumos_egr_nd_basicos']['Observaciones']) OR $_SESSION['insumos_egr_nd_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha seleccionado la maquina';}
				if(!isset($_SESSION['insumos_egr_nd_basicos']['idSistema']) OR $_SESSION['insumos_egr_nd_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha ingresado el id del usuario';}
				if(!isset($_SESSION['insumos_egr_nd_basicos']['idUsuario']) OR $_SESSION['insumos_egr_nd_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha ingresado el id del estado';}
				if(!isset($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']) OR $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha seleccionado la prioridad';}
				if(!isset($_SESSION['insumos_egr_nd_basicos']['idTipo']) OR $_SESSION['insumos_egr_nd_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de trabajo';}
				//se verifica el uso del iva
				if(isset($_SESSION['insumos_egr_nd_basicos']['idUsoIVA'])&&$_SESSION['insumos_egr_nd_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['insumos_egr_nd_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}
			//productos o guias
			if (!isset($_SESSION['insumos_egr_nd_productos'])&&!isset($_SESSION['insumos_egr_nd_otros'])){
				$error['idProducto']   = 'error/No se han asignado insumos ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['insumos_egr_nd_productos'])){
				foreach ($_SESSION['insumos_egr_nd_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['insumos_egr_nd_otros'])){
				foreach ($_SESSION['insumos_egr_nd_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto'] = 'error/No se han asignado insumos ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_egr_nd_basicos']['idBodega']) && $_SESSION['insumos_egr_nd_basicos']['idBodega']!=''){       $SIS_data  = "'".$_SESSION['insumos_egr_nd_basicos']['idBodega']."'";       }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idSistema']) && $_SESSION['insumos_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idUsuario']) && $_SESSION['insumos_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idDocumentos']) && $_SESSION['insumos_egr_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idDocumentos']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['N_Doc']) && $_SESSION['insumos_egr_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['N_Doc']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idTipo']) && $_SESSION['insumos_egr_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idTipo']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['Observaciones']) && $_SESSION['insumos_egr_nd_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Observaciones']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idCliente']) && $_SESSION['insumos_egr_nd_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idCliente']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['Pago_fecha']) && $_SESSION['insumos_egr_nd_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['insumos_egr_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_egr_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nd_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nd_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['insumos_egr_nd_basicos']['fecha_auto']) && $_SESSION['insumos_egr_nd_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['valor_neto_fact'])&&$_SESSION['insumos_egr_nd_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['valor_neto_fact']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['valor_neto_imp'])&&$_SESSION['insumos_egr_nd_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['valor_neto_imp']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['valor_total_fact'])&&$_SESSION['insumos_egr_nd_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['valor_total_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][1]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][1]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][2]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][2]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][3]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][3]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][4]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][4]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][5]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][5]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][6]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][6]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][7]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][7]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][8]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][8]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][9]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][9]['valor']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_impuestos'][10]['valor'])&&$_SESSION['insumos_egr_nd_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['insumos_egr_nd_impuestos'][10]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idCentroCosto']) && $_SESSION['insumos_egr_nd_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idCentroCosto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idLevel_1']) && $_SESSION['insumos_egr_nd_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idLevel_1']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idLevel_2']) && $_SESSION['insumos_egr_nd_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idLevel_2']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idLevel_3']) && $_SESSION['insumos_egr_nd_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idLevel_3']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idLevel_4']) && $_SESSION['insumos_egr_nd_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idLevel_4']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idLevel_5']) && $_SESSION['insumos_egr_nd_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idLevel_5']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nd_basicos']['idUsoIVA']) && $_SESSION['insumos_egr_nd_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idUsoIVA']."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idBodegaOrigen, idSistema, idUsuario, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idDocumentos, N_Doc, idTipo,Observaciones, idCliente, Pago_fecha,Pago_dia, Pago_Semana, Pago_mes,
				Pago_ano, idEstado, fecha_auto, ValorNeto, ValorNetoImp, ValorTotal, Impuesto_01, Impuesto_02, Impuesto_03,
				Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08, Impuesto_09, Impuesto_10, idCentroCosto,
				idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['insumos_egr_nd_productos'])){
						foreach ($_SESSION['insumos_egr_nd_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idBodega']) && $_SESSION['insumos_egr_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idSistema']) && $_SESSION['insumos_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idUsuario']) && $_SESSION['insumos_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idDocumentos']) && $_SESSION['insumos_egr_nd_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idDocumentos']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['N_Doc']) && $_SESSION['insumos_egr_nd_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['N_Doc']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idTipo']) && $_SESSION['insumos_egr_nd_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                              $SIS_data .= ",'".$producto['idProducto']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_eg']) && $producto['Cantidad_eg']!=''){                                                            $SIS_data .= ",'".$producto['Cantidad_eg']."'";                                  }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                          $SIS_data .= ",'".$producto['ValorIngreso']."'";                                 }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                              $SIS_data .= ",'".$producto['ValorTotal']."'";                                   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idCliente']) && $_SESSION['insumos_egr_nd_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idCliente']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['fecha_auto']) && $_SESSION['insumos_egr_nd_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['fecha_auto']."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario,
							Creacion_fecha, Creacion_mes, Creacion_ano, idDocumentos, N_Doc,
							idTipo, idProducto, Cantidad_eg, Valor, ValorTotal, idCliente,
							fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['insumos_egr_nd_otros'])){
						foreach ($_SESSION['insumos_egr_nd_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idBodega']) && $_SESSION['insumos_egr_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idSistema']) && $_SESSION['insumos_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idUsuario']) && $_SESSION['insumos_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_egr_nd_archivos'])){
						foreach ($_SESSION['insumos_egr_nd_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idBodega']) && $_SESSION['insumos_egr_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idSistema']) && $_SESSION['insumos_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idUsuario']) && $_SESSION['insumos_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                   //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                              //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'"; //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_egr_nd_basicos']);
					unset($_SESSION['insumos_egr_nd_productos']);
					unset($_SESSION['insumos_egr_nd_temporal']);
					unset($_SESSION['insumos_egr_nd_impuestos']);
					unset($_SESSION['insumos_egr_nd_archivos']);
					unset($_SESSION['insumos_egr_nd_otros']);
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
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idCliente='".$idCliente."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['insumos_egr_nc_basicos']);
				unset($_SESSION['insumos_egr_nc_productos']);
				unset($_SESSION['insumos_egr_nc_temporal']);
				unset($_SESSION['insumos_egr_nc_impuestos']);
				unset($_SESSION['insumos_egr_nc_otros']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['insumos_egr_nc_archivos'])){
					foreach ($_SESSION['insumos_egr_nc_archivos'] as $key => $producto){
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
				unset($_SESSION['insumos_egr_nc_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_egr_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['insumos_egr_nc_basicos']['idDocumentos']   = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_egr_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['insumos_egr_nc_basicos']['N_Doc']          = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_egr_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_egr_nc_basicos']['Observaciones']  = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_egr_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_egr_nc_basicos']['idSistema']      = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_egr_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_egr_nc_basicos']['idUsuario']      = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'] = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_egr_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_egr_nc_basicos']['idTipo']         = '';}
				if(isset($idCliente) && $idCliente!=''){            $_SESSION['insumos_egr_nc_basicos']['idCliente']        = $idCliente;       }else{$_SESSION['insumos_egr_nc_basicos']['idCliente']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_egr_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_egr_nc_basicos']['fecha_auto']     = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_egr_nc_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_egr_nc_basicos']['idBodega']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_egr_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_egr_nc_basicos']['idUsoIVA']       = '';}

				/***********************************/
				//Centro de Costo vacio
				$_SESSION['insumos_egr_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';
				$_SESSION['insumos_egr_nc_basicos']['idCentroCosto'] = 0;
				$_SESSION['insumos_egr_nc_basicos']['idLevel_1']     = 0;
				$_SESSION['insumos_egr_nc_basicos']['idLevel_2']     = 0;
				$_SESSION['insumos_egr_nc_basicos']['idLevel_3']     = 0;
				$_SESSION['insumos_egr_nc_basicos']['idLevel_4']     = 0;
				$_SESSION['insumos_egr_nc_basicos']['idLevel_5']     = 0;

				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_egr_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_egr_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['Documento'] = '';
				}
				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['Cliente'] = '';
				}
				/********************************************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['Bodega'] = '';
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
			unset($_SESSION['insumos_egr_nc_basicos']);
			unset($_SESSION['insumos_egr_nc_productos']);
			unset($_SESSION['insumos_egr_nc_temporal']);
			unset($_SESSION['insumos_egr_nc_impuestos']);
			unset($_SESSION['insumos_egr_nc_otros']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['insumos_egr_nc_archivos'])){
				foreach ($_SESSION['insumos_egr_nc_archivos'] as $key => $producto){
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
			unset($_SESSION['insumos_egr_nc_archivos']);

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
				unset($_SESSION['insumos_egr_nc_temporal']);
				//Elimino los datos por seguridad
				unset($_SESSION['insumos_egr_nc_productos']);
				unset($_SESSION['insumos_egr_nc_impuestos']);
				unset($_SESSION['insumos_egr_nc_otros']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idDocumentos) && $idDocumentos!=''){      $_SESSION['insumos_egr_nc_basicos']['idDocumentos']     = $idDocumentos;    }else{$_SESSION['insumos_egr_nc_basicos']['idDocumentos']   = '';}
				if(isset($N_Doc) && $N_Doc!=''){                    $_SESSION['insumos_egr_nc_basicos']['N_Doc']            = $N_Doc;           }else{$_SESSION['insumos_egr_nc_basicos']['N_Doc']          = '';}
				if(isset($Observaciones) && $Observaciones!=''){    $_SESSION['insumos_egr_nc_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['insumos_egr_nc_basicos']['Observaciones']  = '';}
				if(isset($idSistema) && $idSistema!=''){            $_SESSION['insumos_egr_nc_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['insumos_egr_nc_basicos']['idSistema']      = '';}
				if(isset($idUsuario) && $idUsuario!=''){            $_SESSION['insumos_egr_nc_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['insumos_egr_nc_basicos']['idUsuario']      = '';}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'] = '';}
				if(isset($idTipo) && $idTipo!=''){                  $_SESSION['insumos_egr_nc_basicos']['idTipo']           = $idTipo;          }else{$_SESSION['insumos_egr_nc_basicos']['idTipo']         = '';}
				if(isset($idCliente) && $idCliente!=''){            $_SESSION['insumos_egr_nc_basicos']['idCliente']        = $idCliente;       }else{$_SESSION['insumos_egr_nc_basicos']['idCliente']      = '';}
				if(isset($fecha_auto) && $fecha_auto!=''){          $_SESSION['insumos_egr_nc_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['insumos_egr_nc_basicos']['fecha_auto']     = '';}
				if(isset($idBodega) && $idBodega!=''){              $_SESSION['insumos_egr_nc_basicos']['idBodega']         = $idBodega;        }else{$_SESSION['insumos_egr_nc_basicos']['idBodega']       = '';}
				if(isset($idUsoIVA) && $idUsoIVA!=''){              $_SESSION['insumos_egr_nc_basicos']['idUsoIVA']         = $idUsoIVA;        }else{$_SESSION['insumos_egr_nc_basicos']['idUsoIVA']       = '';}
				//Se agrega el impuesto en caso de ser utilizado
				if(isset($idUsoIVA) && $idUsoIVA != ''&& $idUsoIVA == 2){
					/****************************************************/
					// consulto los datos
					$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = 1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_impuestos'][1]['Nombre']     = $rowImpuesto['Nombre'];
					$_SESSION['insumos_egr_nc_impuestos'][1]['Porcentaje'] = $rowImpuesto['Porcentaje'];
					$_SESSION['insumos_egr_nc_impuestos'][1]['idImpuesto'] = 1;
				}

				/********************************************************************************/
				if(isset($idDocumentos) && $idDocumentos!=''){
					// consulto los datos
					$rowDocumento = db_select_data (false, 'Nombre', 'core_documentos_mercantiles', '', 'idDocumentos = "'.$idDocumentos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['Documento'] = $rowDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['Documento'] = '';
				}
				/********************************************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipoDocumento = db_select_data (false, 'Nombre', 'bodegas_insumos_facturacion_tipo', '', 'idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['TipoDocumento'] = $rowTipoDocumento['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['TipoDocumento'] = '';
				}
				/********************************************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['Cliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['Cliente'] = '';
				}
				/********************************************************************************/
				if(isset($idBodega) && $idBodega!=''){
					// consulto los datos
					$rowBodega = db_select_data (false, 'Nombre', 'bodegas_insumos_listado', '', 'idBodega = "'.$idBodega.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['Bodega'] = $rowBodega['Nombre'];
				}else{
					$_SESSION['insumos_egr_nc_basicos']['Bodega'] = '';
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
				$_SESSION['insumos_egr_nc_basicos']['CentroCosto']   = 'Sin Centro de Costo Asignado';

				/****************************************************/
				if(isset($idCentroCosto) && $idCentroCosto!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['CentroCosto']   = $rowCentro['Nombre'];
					$_SESSION['insumos_egr_nc_basicos']['idCentroCosto'] = $idCentroCosto;
				}
				/****************************************************/
				if(isset($idLevel_1) && $idLevel_1!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nc_basicos']['idLevel_1']    = $idLevel_1;
				}
				/****************************************************/
				if(isset($idLevel_2) && $idLevel_2!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nc_basicos']['idLevel_2']    = $idLevel_2;
				}
				/****************************************************/
				if(isset($idLevel_3) && $idLevel_3!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nc_basicos']['idLevel_3']    = $idLevel_3;
				}
				/****************************************************/
				if(isset($idLevel_4) && $idLevel_4!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nc_basicos']['idLevel_4']    = $idLevel_4;
				}
				/****************************************************/
				if(isset($idLevel_5) && $idLevel_5!=''){
					// consulto los datos
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['insumos_egr_nc_basicos']['CentroCosto'] .= ' - '.$rowCentro['Nombre'];
					$_SESSION['insumos_egr_nc_basicos']['idLevel_5']    = $idLevel_5;
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

			/*******************************************************************/
			//variables
			if(isset($idProducto)){  $ndata_1 = count($idProducto);  }else{$ndata_1 = 0;}
			//generacion de errores
			if(count(array_filter($idProducto))==0) {
				$error['ndata_3'] = 'error/No hay insumos agregados';
			}else{
				$n_repetidos = 0;
				//Recorro los productos verificando repetidos
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					if(isset($_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]])&&$_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]]>0){
						$n_repetidos++;
					}
				}
				//si hay repetidos
				if($n_repetidos!=0) {
					$error['productos'] = 'error/El insumo que intenta agregar ya existe';
				}
				// Se trae un listado con todos los productos
				$arrProductos = array();
				$arrProductos = db_select_array (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idEstado=1', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$arrProd = array();
				foreach ($arrProductos as $producto){
					$arrProd['Prod'][$producto['idProducto']]['Nombre'] = $producto['Nombre'];
					$arrProd['Prod'][$producto['idProducto']]['Unimed'] = $producto['Unimed'];
				}
			}
			/*******************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//verifico si existe dato
					if(isset($idProducto[$j1])&&$idProducto[$j1]!=''){
						$_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]]['idProducto']    = $idProducto[$j1];
						$_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]]['Cantidad_ing']  = $Cantidad_ing[$j1];
						$_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]]['ValorIngreso']  = $ValorTotal[$j1]/$Cantidad_ing[$j1];
						$_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]]['ValorTotal']    = $ValorTotal[$j1];
						$_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]]['Nombre']        = $arrProd['Prod'][$idProducto[$j1]]['Nombre'];
						$_SESSION['insumos_egr_nc_productos'][$idProducto[$j1]]['Unimed']        = $arrProd['Prod'][$idProducto[$j1]]['Unimed'];
					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_egr_nc_productos'][$idProducto])&&$_SESSION['insumos_egr_nc_productos'][$idProducto]>0&&$_SESSION['insumos_egr_nc_productos'][$idProducto]!=$_SESSION['insumos_egr_nc_productos'][$oldItemID]){
				$error['productos'] = 'error/El Insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se trae información
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Borro el producto
				unset($_SESSION['insumos_egr_nc_productos'][$oldItemID]);

				//creo el producto
				$_SESSION['insumos_egr_nc_productos'][$idProducto]['idProducto']    = $idProducto;
				$_SESSION['insumos_egr_nc_productos'][$idProducto]['Cantidad_ing']  = $Cantidad_ing;
				$_SESSION['insumos_egr_nc_productos'][$idProducto]['ValorIngreso']  = $ValorIngreso;
				$_SESSION['insumos_egr_nc_productos'][$idProducto]['ValorTotal']    = $ValorTotal;
				$_SESSION['insumos_egr_nc_productos'][$idProducto]['Nombre']        = $rowProducto['Nombre'];
				$_SESSION['insumos_egr_nc_productos'][$idProducto]['Unimed']        = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'del_prod_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_nc_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['insumos_egr_nc_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['insumos_egr_nc_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$_SESSION['insumos_egr_nc_otros'][$idInterno]['idOtros']  = $idInterno;
				$_SESSION['insumos_egr_nc_otros'][$idInterno]['Nombre']   = $Nombre;
				$_SESSION['insumos_egr_nc_otros'][$idInterno]['vTotal']   = $vTotal;

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
				$_SESSION['insumos_egr_nc_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['insumos_egr_nc_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['insumos_egr_nc_otros'][$oldidProducto]['vTotal']        = $vTotal;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_nc_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_impuesto_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['insumos_egr_nc_impuestos'][$idImpuesto])&&$_SESSION['insumos_egr_nc_impuestos'][$idImpuesto]>0){
				$error['productos'] = 'error/Impuesto que trata de ingresar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/****************************************************/
				// consulto los datos
				$rowImpuesto = db_select_data (false, 'Nombre,Porcentaje', 'sistema_impuestos', '', 'idImpuesto = '.$idImpuesto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se guarda dato
				$_SESSION['insumos_egr_nc_impuestos'][$idImpuesto]['idImpuesto'] = $idImpuesto;
				$_SESSION['insumos_egr_nc_impuestos'][$idImpuesto]['Nombre']     = $rowImpuesto['Nombre'];
				$_SESSION['insumos_egr_nc_impuestos'][$idImpuesto]['Porcentaje'] = $rowImpuesto['Porcentaje'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'del_impuesto_egr_nc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['insumos_egr_nc_impuestos'][$_GET['del_impuesto']]);

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
			if(isset($_SESSION['insumos_egr_nc_archivos'])){
				foreach ($_SESSION['insumos_egr_nc_archivos'] as $key => $trabajos){
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
						$sufijo = 'insumos_egreso_'.genera_password_unica().'_';

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
									$_SESSION['insumos_egr_nc_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['insumos_egr_nc_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['insumos_egr_nc_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['insumos_egr_nc_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['insumos_egr_nc_archivos'][$_GET['del_file']]);
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
			if (isset($_SESSION['insumos_egr_nc_basicos'])){
				if(!isset($_SESSION['insumos_egr_nc_basicos']['idDocumentos']) OR $_SESSION['insumos_egr_nc_basicos']['idDocumentos']=='' ){     $error['idDocumentos']     = 'error/No ha seleccionado el documentoa';}
				if(!isset($_SESSION['insumos_egr_nc_basicos']['N_Doc']) OR $_SESSION['insumos_egr_nc_basicos']['N_Doc']=='' ){                   $error['N_Doc']            = 'error/No ha ingresado el numero de documento';}
				if(!isset($_SESSION['insumos_egr_nc_basicos']['Observaciones']) OR $_SESSION['insumos_egr_nc_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['insumos_egr_nc_basicos']['idSistema']) OR $_SESSION['insumos_egr_nc_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['insumos_egr_nc_basicos']['idUsuario']) OR $_SESSION['insumos_egr_nc_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha sleccionado el usuario';}
				if(!isset($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']) OR $_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado una fecha de creación';}
				if(!isset($_SESSION['insumos_egr_nc_basicos']['idTipo']) OR $_SESSION['insumos_egr_nc_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['insumos_egr_nc_basicos']['idCliente']) OR $_SESSION['insumos_egr_nc_basicos']['idCliente']=='' ){           $error['idCliente']        = 'error/No ha seleccionado el cliente';}
				//se verifica el uso del iva
				if(isset($_SESSION['insumos_egr_nc_basicos']['idUsoIVA'])&&$_SESSION['insumos_egr_nc_basicos']['idUsoIVA']==2){
					if(!isset($_SESSION['insumos_egr_nc_impuestos'])){
						$error['impuestos']  = 'error/No ha seleccionado un impuesto';
					}
				}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al documento';
			}
			//productos o guias
			if (!isset($_SESSION['insumos_egr_nc_productos'])&&!isset($_SESSION['insumos_egr_nc_otros'])){
				$error['idProducto']   = 'error/No se han asignado ni insumos ni guias';
			}
			//Se verifican productos
			if (isset($_SESSION['insumos_egr_nc_productos'])){
				foreach ($_SESSION['insumos_egr_nc_productos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifican guias
			if (isset($_SESSION['insumos_egr_nc_otros'])){
				foreach ($_SESSION['insumos_egr_nc_otros'] as $key => $producto){
					$n_data2++;
				}
			}
			$valor = $n_data1 + $n_data2;
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['idProducto']   = 'error/No se han asignado ni insumos ni guias';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['insumos_egr_nc_basicos']['idDocumentos']) && $_SESSION['insumos_egr_nc_basicos']['idDocumentos']!=''){      $SIS_data  = "'".$_SESSION['insumos_egr_nc_basicos']['idDocumentos']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['N_Doc']) && $_SESSION['insumos_egr_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['Observaciones']) && $_SESSION['insumos_egr_nc_basicos']['Observaciones']!=''){    $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idBodega']) && $_SESSION['insumos_egr_nc_basicos']['idBodega']!=''){              $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idSistema']) && $_SESSION['insumos_egr_nc_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idUsuario']) && $_SESSION['insumos_egr_nc_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idTipo']) && $_SESSION['insumos_egr_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idCliente']) && $_SESSION['insumos_egr_nc_basicos']['idCliente']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idCliente']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['fecha_auto']) && $_SESSION['insumos_egr_nc_basicos']['fecha_auto']!=''){           $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['fecha_auto']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['valor_neto_fact'])&&$_SESSION['insumos_egr_nc_basicos']['valor_neto_fact']!=''){   $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['valor_neto_fact']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['valor_neto_imp'])&&$_SESSION['insumos_egr_nc_basicos']['valor_neto_imp']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['valor_neto_imp']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['valor_total_fact'])&&$_SESSION['insumos_egr_nc_basicos']['valor_total_fact']!=''){ $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['valor_total_fact']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][1]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][1]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][1]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][2]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][2]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][2]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][3]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][3]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][3]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][4]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][4]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][4]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][5]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][5]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][5]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][6]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][6]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][6]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][7]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][7]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][7]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][8]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][8]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][8]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][9]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][9]['valor']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][9]['valor']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_impuestos'][10]['valor'])&&$_SESSION['insumos_egr_nc_impuestos'][10]['valor']!=''){           $SIS_data .= ",'".$_SESSION['insumos_egr_nc_impuestos'][10]['valor']."'";       }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'";
				if(isset($_SESSION['insumos_egr_nc_basicos']['idCentroCosto']) && $_SESSION['insumos_egr_nc_basicos']['idCentroCosto']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idLevel_1']) && $_SESSION['insumos_egr_nc_basicos']['idLevel_1']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idLevel_2']) && $_SESSION['insumos_egr_nc_basicos']['idLevel_2']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idLevel_3']) && $_SESSION['insumos_egr_nc_basicos']['idLevel_3']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idLevel_4']) && $_SESSION['insumos_egr_nc_basicos']['idLevel_4']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idLevel_5']) && $_SESSION['insumos_egr_nc_basicos']['idLevel_5']!=''){             $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['insumos_egr_nc_basicos']['idUsoIVA']) && $_SESSION['insumos_egr_nc_basicos']['idUsoIVA']!=''){               $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idUsoIVA']."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idDocumentos,N_Doc, Observaciones,
				idBodegaDestino, idSistema, idUsuario, idTipo, Creacion_fecha, Creacion_Semana, Creacion_mes,
				Creacion_ano, idCliente, fecha_auto, ValorNeto, ValorNetoImp,ValorTotal, Impuesto_01,
				Impuesto_02, Impuesto_03, Impuesto_04, Impuesto_05, Impuesto_06, Impuesto_07, Impuesto_08,
				Impuesto_09, Impuesto_10, idEstado, idCentroCosto, idLevel_1, idLevel_2, idLevel_3,
				idLevel_4, idLevel_5, idUsoIVA';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['insumos_egr_nc_productos'])){
						foreach ($_SESSION['insumos_egr_nc_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idBodega']) && $_SESSION['insumos_egr_nc_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idSistema']) && $_SESSION['insumos_egr_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idUsuario']) && $_SESSION['insumos_egr_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idDocumentos']) && $_SESSION['insumos_egr_nc_basicos']['idDocumentos']!=''){      $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idDocumentos']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['N_Doc']) && $_SESSION['insumos_egr_nc_basicos']['N_Doc']!=''){                    $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['N_Doc']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idTipo']) && $_SESSION['insumos_egr_nc_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idTipo']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){                                                              $SIS_data .= ",'".$producto['idProducto']."'";                              }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad_ing']) && $producto['Cantidad_ing']!=''){                                                          $SIS_data .= ",'".$producto['Cantidad_ing']."'";                            }else{$SIS_data .= ",''";}
							if(isset($producto['ValorIngreso']) && $producto['ValorIngreso']!=''){                                                          $SIS_data .= ",'".$producto['ValorIngreso']."'";                            }else{$SIS_data .= ",''";}
							if(isset($producto['ValorTotal']) && $producto['ValorTotal']!=''){                                                              $SIS_data .= ",'".$producto['ValorTotal']."'";                              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idCliente']) && $_SESSION['insumos_egr_nc_basicos']['idCliente']!=''){            $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idCliente']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['fecha_auto']) && $_SESSION['insumos_egr_nc_basicos']['fecha_auto']!=''){          $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano,
							idDocumentos, N_Doc, idTipo, idProducto, Cantidad_ing, Valor,ValorTotal, idCliente, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Otros Motivos
					if(isset($_SESSION['insumos_egr_nc_otros'])){
						foreach ($_SESSION['insumos_egr_nc_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idBodega']) && $_SESSION['insumos_egr_nd_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idSistema']) && $_SESSION['insumos_egr_nd_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['idUsuario']) && $_SESSION['insumos_egr_nd_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_nd_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nd_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){    $SIS_data .= ",'".$producto['vTotal']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_egr_nc_archivos'])){
						foreach ($_SESSION['insumos_egr_nc_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                 $SIS_data  = "'".$ultimo_id."'";                                            }else{$SIS_data  = "''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idBodega']) && $_SESSION['insumos_egr_nc_basicos']['idBodega']!=''){       $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idBodega']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idSistema']) && $_SESSION['insumos_egr_nc_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['idUsuario']) && $_SESSION['insumos_egr_nc_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idBodega, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']) && $_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['insumos_egr_nc_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['insumos_egr_nc_basicos']);
					unset($_SESSION['insumos_egr_nc_productos']);
					unset($_SESSION['insumos_egr_nc_temporal']);
					unset($_SESSION['insumos_egr_nc_impuestos']);
					unset($_SESSION['insumos_egr_nc_archivos']);
					unset($_SESSION['insumos_egr_nc_otros']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
