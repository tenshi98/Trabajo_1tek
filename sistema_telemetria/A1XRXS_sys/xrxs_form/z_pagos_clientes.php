<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-257).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCliente']))       $idCliente       = $_POST['idCliente'];
	if (!empty($_POST['idDocPago']))       $idDocPago       = $_POST['idDocPago'];
	if (!empty($_POST['N_DocPago']))       $N_DocPago       = $_POST['N_DocPago'];
	if (!empty($_POST['F_Pago']))          $F_Pago          = $_POST['F_Pago'];
	if (!empty($_POST['MontoPagado']))     $MontoPagado     = $_POST['MontoPagado'];
	if (!empty($_POST['idSistema']))       $idSistema       = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))       $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['total_pagar']))     $total_pagar     = $_POST['total_pagar'];
	if (!empty($_POST['idFacturacion']))   $idFacturacion   = $_POST['idFacturacion'];
	if (!empty($_POST['montoPactado']))    $montoPactado    = $_POST['montoPactado'];

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
			case 'idCliente':      if(empty($idCliente)){       $error['idCliente']      = 'error/No ha ingresado el id';}break;
			case 'idDocPago':      if(empty($idDocPago)){       $error['idDocPago']      = 'error/No ha seleccionado el documento de pago';}break;
			case 'N_DocPago':      if(empty($N_DocPago)){       $error['N_DocPago']      = 'error/No ha ingresado numero de documento de pago';}break;
			case 'F_Pago':         if(empty($F_Pago)){          $error['F_Pago']         = 'error/No ha ingresado la fecha de pago';}break;
			case 'MontoPagado':    if(empty($MontoPagado)){     $error['MontoPagado']    = 'error/No ha ingresado el monto pagado';}break;
			case 'idSistema':      if(empty($idSistema)){       $error['idSistema']      = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':      if(empty($idUsuario)){       $error['idUsuario']      = 'error/No ha seleccionado el usuario';}break;
			case 'total_pagar':    if(empty($total_pagar)){     $error['total_pagar']    = 'error/No ha ingresado el total a pagar';}break;
			case 'idFacturacion':  if(empty($idFacturacion)){   $error['idFacturacion']  = 'error/No ha seleccionado la facturacion';}break;
			case 'montoPactado':   if(empty($montoPactado)){    $error['montoPactado']   = 'error/No ha ingresado el monto pactado';}break;

		}
	}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Pago Masivo                                                    */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'del_insumo_ex':

			//Borro todas las sesiones
			unset($_SESSION['pago_clientes_insumos'][$_GET['del_insumo_ex']]);

			header( 'Location: '.$location.'&next=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'del_producto_ex':

			//Borro todas las sesiones
			unset($_SESSION['pago_clientes_productos'][$_GET['del_producto_ex']]);

			header( 'Location: '.$location.'&next=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'del_arriendo_ex':

			//Borro todas las sesiones
			unset($_SESSION['pago_clientes_arriendo'][$_GET['del_arriendo_ex']]);

			header( 'Location: '.$location.'&next=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'del_servicio_ex':

			//Borro todas las sesiones
			unset($_SESSION['pago_clientes_servicio'][$_GET['del_servicio_ex']]);

			header( 'Location: '.$location.'&next=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'pago_general':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				if(!isset($N_DocPago) OR $N_DocPago == ''){
					$N_DocPago = time();//clave unica
				}

				//verifico si existe documento de pago
				if(isset($idDocPago)&&$idDocPago!=''){
					//Verifico el documento de pago
					$rowDoc = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				}

				////////////////////////////////////////////////////////////////////////////////////////////////
				//recorro todos los existentes y les doy pago
				if(isset($_SESSION['pago_clientes_insumos'])){
					foreach ($_SESSION['pago_clientes_insumos'] as $key => $tipo){
						if(isset($tipo['idDocumentos'])){
							if($tipo['idDocumentos']==2 OR $tipo['idDocumentos']==4 OR $tipo['idDocumentos']==5){

								$idFacturacion  = $tipo['idFacturacion'];
								$ValorReal      = $tipo['ValorPagado'];
								$ValorNC        = $tipo['MontoNC'];
								$ValorTotal     = $tipo['ValorTotal'];
								$ValorPagado    = $tipo['ValorPagado']+$tipo['MontoNC'];
								$MontoPagado    = $tipo['ValorPagado']+$tipo['MontoNC']+$tipo['MontoPagado'];
								$MontoPactado   = $tipo['ValorTotal']-$tipo['MontoPagado'];
								$idSistema      = $tipo['idSistema'];
								$idCliente      = $tipo['idCliente'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuarioPago='".$idUsuario."'";}
								if(isset($idDocPago) && $idDocPago!=''){       $SIS_data .= ",idDocPago='".$idDocPago."'";}
								if(isset($N_DocPago) && $N_DocPago!=''){       $SIS_data .= ",N_DocPago='".$N_DocPago."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								if(isset($ValorPagado) &&$ValorPagado!= ''){   $SIS_data .= ",MontoPagado='".$MontoPagado."'";}
								if($MontoPactado<=$ValorPagado){
									//Si la NC es igual a la Fac la anula
									if($ValorNC==$ValorTotal){
										$SIS_data .= ",idEstado='3'";
									}else{
										$SIS_data .= ",idEstado='2'";
									}
								}else{
									$SIS_data .= ",idEstado='1'";
								}

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_insumos_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/*********************************************************************/
								//Se crea la observacion
								if(isset($idDocPago)&&$idDocPago!=''){
									$exp_xxs  = 'Pago del documento con el documento '.$rowDoc['Nombre'];
									if(isset($N_DocPago)&&$N_DocPago!=''){$exp_xxs .= ' N° '.$N_DocPago;}
									$exp_xxs .= ', por un valor de '.Valores($ValorReal, 0);
									if(isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){$exp_xxs .= ', utilizando una nota de credito por un valor de'.Valores($ValorNC, 0);}
								}elseif(!isset($idDocPago) OR $idDocPago==''&&isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){
									$exp_xxs  = 'Se utiliza una nota de credito para cerrar la factura por un valor de'.Valores($ValorNC, 0);
								}
								//Se guarda en historial la accion
								if(isset($tipo['idFacturacion']) && $tipo['idFacturacion']!=''){    $SIS_data  = "'".$tipo['idFacturacion']."'";  }else{$SIS_data  = "''";}
								if(isset($F_Pago) && $F_Pago!=''){                                  $SIS_data .= ",'".$F_Pago."'";                }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
								$SIS_data .= ",'".$exp_xxs."'";                                          //Observacion
								$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

								// inserto los datos de registro en la db
								$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/**************************************************************************************/
								//Si la NC es igual a la Fac la anula
								if($ValorNC!=$ValorTotal){
									//Agrego el pago al historial de pagos
									$SIS_data = "'1'"; //se indica que el pago es de productos
									if(isset($idFacturacion) && $idFacturacion!=''){  $SIS_data .= ",'".$idFacturacion."'";  }else{ $SIS_data .= ",''"; }
									if(isset($idDocPago) && $idDocPago!=''){          $SIS_data .= ",'".$idDocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($N_DocPago) && $N_DocPago!=''){          $SIS_data .= ",'".$N_DocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($F_Pago) && $F_Pago!=''){
										$SIS_data .= ",'".$F_Pago."'";
										$SIS_data .= ",'".fecha2NdiaMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2NSemana($F_Pago)."'";
										$SIS_data .= ",'".fecha2NMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2Ano($F_Pago)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									if(isset($ValorReal) && $ValorReal!=''){             $SIS_data .= ",'".$ValorReal."'";       }else{ $SIS_data .= ",''"; }
									if(isset($MontoPactado) && $MontoPactado!=''){       $SIS_data .= ",'".$MontoPactado."'";    }else{ $SIS_data .= ",''"; }
									if(isset($idUsuario) && $idUsuario!=''){             $SIS_data .= ",'".$idUsuario."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idSistema) && $idSistema!=''){             $SIS_data .= ",'".$idSistema."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idCliente) && $idCliente!=''){             $SIS_data .= ",'".$idCliente."'";       }else{ $SIS_data .= ",''"; }

									// inserto los datos de registro en la db
									$SIS_columns = 'idTipo, idFacturacion, idDocPago, N_DocPago, F_Pago, F_Pago_dia, F_Pago_Semana, F_Pago_mes, F_Pago_ano, MontoPagado, montoPactado, idUsuario, idSistema, idCliente';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_facturas_clientes', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}

							}elseif(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){

								$idFacturacion     = $tipo['idFacturacion'];
								$idFacRelacionada  = $tipo['idFacRelacionada'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idFacRelacionada) && $idFacRelacionada!=''){       $SIS_data .= ",idFacturacionRelacionado='".$idFacRelacionada."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_insumos_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}
				}
				////////////////////////////////////////////////////////////////////////////////////////////////
				//recorro todos los existentes y les doy pago
				if(isset($_SESSION['pago_clientes_productos'])){
					foreach ($_SESSION['pago_clientes_productos'] as $key => $tipo){
						if(isset($tipo['idDocumentos'])){
							if($tipo['idDocumentos']==2 OR $tipo['idDocumentos']==4 OR $tipo['idDocumentos']==5){

								$idFacturacion  = $tipo['idFacturacion'];
								$ValorReal      = $tipo['ValorPagado'];
								$ValorNC        = $tipo['MontoNC'];
								$ValorTotal     = $tipo['ValorTotal'];
								$ValorPagado    = $tipo['ValorPagado']+$tipo['MontoNC'];
								$MontoPagado    = $tipo['ValorPagado']+$tipo['MontoNC']+$tipo['MontoPagado'];
								$MontoPactado   = $tipo['ValorTotal']-$tipo['MontoPagado'];
								$idSistema      = $tipo['idSistema'];
								$idCliente      = $tipo['idCliente'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuarioPago='".$idUsuario."'";}
								if(isset($idDocPago) && $idDocPago!=''){       $SIS_data .= ",idDocPago='".$idDocPago."'";}
								if(isset($N_DocPago) && $N_DocPago!=''){       $SIS_data .= ",N_DocPago='".$N_DocPago."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								if(isset($ValorPagado) &&$ValorPagado!= ''){   $SIS_data .= ",MontoPagado='".$MontoPagado."'";}
								if($MontoPactado<=$ValorPagado){
									//Si la NC es igual a la Fac la anula
									if($ValorNC==$ValorTotal){
										$SIS_data .= ",idEstado='3'";
									}else{
										$SIS_data .= ",idEstado='2'";
									}
								}else{
									$SIS_data .= ",idEstado='1'";
								}

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_productos_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/*********************************************************************/
								//Se crea la observacion
								if(isset($idDocPago)&&$idDocPago!=''){
									$exp_xxs  = 'Pago del documento con el documento '.$rowDoc['Nombre'];
									if(isset($N_DocPago)&&$N_DocPago!=''){$exp_xxs .= ' N° '.$N_DocPago;}
									$exp_xxs .= ', por un valor de '.Valores($ValorReal, 0);
									if(isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){$exp_xxs .= ', utilizando una nota de credito por un valor de'.Valores($ValorNC, 0);}
								}elseif(!isset($idDocPago) OR $idDocPago==''&&isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){
									$exp_xxs  = 'Se utiliza una nota de credito para cerrar la factura por un valor de'.Valores($ValorNC, 0);
								}
								//Se guarda en historial la accion
								if(isset($tipo['idFacturacion']) && $tipo['idFacturacion']!=''){    $SIS_data  = "'".$tipo['idFacturacion']."'";  }else{$SIS_data  = "''";}
								if(isset($F_Pago) && $F_Pago!=''){                                  $SIS_data .= ",'".$F_Pago."'";                }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
								$SIS_data .= ",'".$exp_xxs."'";                                          //Observacion
								$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

								// inserto los datos de registro en la db
								$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_productos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/**************************************************************************************/
								//Si la NC es igual a la Fac la anula
								if($ValorNC!=$ValorTotal){
									//Agrego el pago al historial de pagos
									$SIS_data = "'2'"; //se indica que el pago es de productos
									if(isset($idFacturacion) && $idFacturacion!=''){  $SIS_data .= ",'".$idFacturacion."'";  }else{ $SIS_data .= ",''"; }
									if(isset($idDocPago) && $idDocPago!=''){          $SIS_data .= ",'".$idDocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($N_DocPago) && $N_DocPago!=''){          $SIS_data .= ",'".$N_DocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($F_Pago) && $F_Pago!=''){
										$SIS_data .= ",'".$F_Pago."'";
										$SIS_data .= ",'".fecha2NdiaMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2NSemana($F_Pago)."'";
										$SIS_data .= ",'".fecha2NMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2Ano($F_Pago)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									if(isset($ValorReal) && $ValorReal!=''){             $SIS_data .= ",'".$ValorReal."'";       }else{ $SIS_data .= ",''"; }
									if(isset($MontoPactado) && $MontoPactado!=''){       $SIS_data .= ",'".$MontoPactado."'";    }else{ $SIS_data .= ",''"; }
									if(isset($idUsuario) && $idUsuario!=''){             $SIS_data .= ",'".$idUsuario."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idSistema) && $idSistema!=''){             $SIS_data .= ",'".$idSistema."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idCliente) && $idCliente!=''){             $SIS_data .= ",'".$idCliente."'";       }else{ $SIS_data .= ",''"; }

									// inserto los datos de registro en la db
									$SIS_columns = 'idTipo, idFacturacion, idDocPago, N_DocPago, F_Pago, F_Pago_dia, F_Pago_Semana, F_Pago_mes, F_Pago_ano, MontoPagado, montoPactado, idUsuario, idSistema, idCliente';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_facturas_clientes', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}

							}elseif(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){

								$idFacturacion     = $tipo['idFacturacion'];
								$idFacRelacionada  = $tipo['idFacRelacionada'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idFacRelacionada) && $idFacRelacionada!=''){       $SIS_data .= ",idFacturacionRelacionado='".$idFacRelacionada."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_productos_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}
				}
				////////////////////////////////////////////////////////////////////////////////////////////////
				//recorro todos los existentes y les doy pago
				if(isset($_SESSION['pago_clientes_arriendo'])){
					foreach ($_SESSION['pago_clientes_arriendo'] as $key => $tipo){
						if(isset($tipo['idDocumentos'])){
							if($tipo['idDocumentos']==2 OR $tipo['idDocumentos']==4 OR $tipo['idDocumentos']==5){

								$idFacturacion  = $tipo['idFacturacion'];
								$ValorReal      = $tipo['ValorPagado'];
								$ValorNC        = $tipo['MontoNC'];
								$ValorTotal     = $tipo['ValorTotal'];
								$ValorPagado    = $tipo['ValorPagado']+$tipo['MontoNC'];
								$MontoPagado    = $tipo['ValorPagado']+$tipo['MontoNC']+$tipo['MontoPagado'];
								$MontoPactado   = $tipo['ValorTotal']-$tipo['MontoPagado'];
								$idSistema      = $tipo['idSistema'];
								$idCliente      = $tipo['idCliente'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuarioPago='".$idUsuario."'";}
								if(isset($idDocPago) && $idDocPago!=''){       $SIS_data .= ",idDocPago='".$idDocPago."'";}
								if(isset($N_DocPago) && $N_DocPago!=''){       $SIS_data .= ",N_DocPago='".$N_DocPago."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								if(isset($ValorPagado) &&$ValorPagado!= ''){   $SIS_data .= ",MontoPagado='".$MontoPagado."'";}
								if($MontoPactado<=$ValorPagado){
									//Si la NC es igual a la Fac la anula
									if($ValorNC==$ValorTotal){
										$SIS_data .= ",idEstado='3'";
									}else{
										$SIS_data .= ",idEstado='2'";
									}
								}else{
									$SIS_data .= ",idEstado='1'";
								}

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_arriendos_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/*********************************************************************/
								//Se crea la observacion
								if(isset($idDocPago)&&$idDocPago!=''){
									$exp_xxs  = 'Pago del documento con el documento '.$rowDoc['Nombre'];
									if(isset($N_DocPago)&&$N_DocPago!=''){$exp_xxs .= ' N° '.$N_DocPago;}
									$exp_xxs .= ', por un valor de '.Valores($ValorReal, 0);
									if(isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){$exp_xxs .= ', utilizando una nota de credito por un valor de'.Valores($ValorNC, 0);}
								}elseif(!isset($idDocPago) OR $idDocPago==''&&isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){
									$exp_xxs  = 'Se utiliza una nota de credito para cerrar la factura por un valor de'.Valores($ValorNC, 0);
								}
								//Se guarda en historial la accion
								if(isset($tipo['idFacturacion']) && $tipo['idFacturacion']!=''){    $SIS_data  = "'".$tipo['idFacturacion']."'";  }else{$SIS_data  = "''";}
								if(isset($F_Pago) && $F_Pago!=''){                                  $SIS_data .= ",'".$F_Pago."'";                }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
								$SIS_data .= ",'".$exp_xxs."'";                                          //Observacion
								$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

								// inserto los datos de registro en la db
								$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_arriendos_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/**************************************************************************************/
								//Si la NC es igual a la Fac la anula
								if($ValorNC!=$ValorTotal){
									//Agrego el pago al historial de pagos
									$SIS_data = "'4'"; //se indica que el pago es de productos
									if(isset($idFacturacion) && $idFacturacion!=''){  $SIS_data .= ",'".$idFacturacion."'";  }else{ $SIS_data .= ",''"; }
									if(isset($idDocPago) && $idDocPago!=''){          $SIS_data .= ",'".$idDocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($N_DocPago) && $N_DocPago!=''){          $SIS_data .= ",'".$N_DocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($F_Pago) && $F_Pago!=''){
										$SIS_data .= ",'".$F_Pago."'";
										$SIS_data .= ",'".fecha2NdiaMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2NSemana($F_Pago)."'";
										$SIS_data .= ",'".fecha2NMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2Ano($F_Pago)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									if(isset($ValorReal) && $ValorReal!=''){             $SIS_data .= ",'".$ValorPagado."'";     }else{ $SIS_data .= ",''"; }
									if(isset($MontoPactado) && $MontoPactado!=''){       $SIS_data .= ",'".$MontoPactado."'";    }else{ $SIS_data .= ",''"; }
									if(isset($idUsuario) && $idUsuario!=''){             $SIS_data .= ",'".$idUsuario."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idSistema) && $idSistema!=''){             $SIS_data .= ",'".$idSistema."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idCliente) && $idCliente!=''){             $SIS_data .= ",'".$idCliente."'";       }else{ $SIS_data .= ",''"; }

									// inserto los datos de registro en la db
									$SIS_columns = 'idTipo, idFacturacion, idDocPago, N_DocPago, F_Pago, F_Pago_dia, F_Pago_Semana, F_Pago_mes, F_Pago_ano, MontoPagado, montoPactado, idUsuario, idSistema, idCliente';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_facturas_clientes', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}

							}elseif(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){

								$idFacturacion     = $tipo['idFacturacion'];
								$idFacRelacionada  = $tipo['idFacRelacionada'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idFacRelacionada) && $idFacRelacionada!=''){       $SIS_data .= ",idFacturacionRelacionado='".$idFacRelacionada."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_arriendos_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}
				}
				////////////////////////////////////////////////////////////////////////////////////////////////
				//recorro todos los existentes y les doy pago
				if(isset($_SESSION['pago_clientes_servicio'])){
					foreach ($_SESSION['pago_clientes_servicio'] as $key => $tipo){
						if(isset($tipo['idDocumentos'])){
							if($tipo['idDocumentos']==2 OR $tipo['idDocumentos']==4 OR $tipo['idDocumentos']==5){

								$idFacturacion  = $tipo['idFacturacion'];
								$ValorReal      = $tipo['ValorPagado'];
								$ValorNC        = $tipo['MontoNC'];
								$ValorTotal     = $tipo['ValorTotal'];
								$ValorPagado    = $tipo['ValorPagado']+$tipo['MontoNC'];
								$MontoPagado    = $tipo['ValorPagado']+$tipo['MontoNC']+$tipo['MontoPagado'];
								$MontoPactado   = $tipo['ValorTotal']-$tipo['MontoPagado'];
								$idSistema      = $tipo['idSistema'];
								$idCliente      = $tipo['idCliente'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuarioPago='".$idUsuario."'";}
								if(isset($idDocPago) && $idDocPago!=''){       $SIS_data .= ",idDocPago='".$idDocPago."'";}
								if(isset($N_DocPago) && $N_DocPago!=''){       $SIS_data .= ",N_DocPago='".$N_DocPago."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								if(isset($ValorPagado) &&$ValorPagado!= ''){   $SIS_data .= ",MontoPagado='".$MontoPagado."'";}
								if($MontoPactado<=$ValorPagado){
									//Si la NC es igual a la Fac la anula
									if($ValorNC==$ValorTotal){
										$SIS_data .= ",idEstado='3'";
									}else{
										$SIS_data .= ",idEstado='2'";
									}
								}else{
									$SIS_data .= ",idEstado='1'";
								}

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_servicios_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/*********************************************************************/
								//Se crea la observacion
								if(isset($idDocPago)&&$idDocPago!=''){
									$exp_xxs  = 'Pago del documento con el documento '.$rowDoc['Nombre'];
									if(isset($N_DocPago)&&$N_DocPago!=''){$exp_xxs .= ' N° '.$N_DocPago;}
									$exp_xxs .= ', por un valor de '.Valores($ValorReal, 0);
									if(isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){$exp_xxs .= ', utilizando una nota de credito por un valor de'.Valores($ValorNC, 0);}
								}elseif(!isset($idDocPago) OR $idDocPago==''&&isset($ValorNC)&&$ValorNC!=''&&$ValorNC!=0){
									$exp_xxs  = 'Se utiliza una nota de credito para cerrar la factura por un valor de'.Valores($ValorNC, 0);
								}
								//Se guarda en historial la accion
								if(isset($tipo['idFacturacion']) && $tipo['idFacturacion']!=''){    $SIS_data  = "'".$tipo['idFacturacion']."'";  }else{$SIS_data  = "''";}
								if(isset($F_Pago) && $F_Pago!=''){                                  $SIS_data .= ",'".$F_Pago."'";                }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'";                                                       //Creacion Satisfactoria
								$SIS_data .= ",'".$exp_xxs."'";                                            //Observacion
								$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";     //idUsuario

								// inserto los datos de registro en la db
								$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_servicios_facturacion_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/**************************************************************************************/
								//Si la NC es igual a la Fac la anula
								if($ValorNC!=$ValorTotal){
									//Agrego el pago al historial de pagos
									$SIS_data = "'3'"; //se indica que el pago es de productos
									if(isset($idFacturacion) && $idFacturacion!=''){  $SIS_data .= ",'".$idFacturacion."'";  }else{ $SIS_data .= ",''"; }
									if(isset($idDocPago) && $idDocPago!=''){          $SIS_data .= ",'".$idDocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($N_DocPago) && $N_DocPago!=''){          $SIS_data .= ",'".$N_DocPago."'";      }else{ $SIS_data .= ",''"; }
									if(isset($F_Pago) && $F_Pago!=''){
										$SIS_data .= ",'".$F_Pago."'";
										$SIS_data .= ",'".fecha2NdiaMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2NSemana($F_Pago)."'";
										$SIS_data .= ",'".fecha2NMes($F_Pago)."'";
										$SIS_data .= ",'".fecha2Ano($F_Pago)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									if(isset($ValorReal) && $ValorReal!=''){             $SIS_data .= ",'".$ValorReal."'";       }else{ $SIS_data .= ",''"; }
									if(isset($MontoPactado) && $MontoPactado!=''){       $SIS_data .= ",'".$MontoPactado."'";    }else{ $SIS_data .= ",''"; }
									if(isset($idUsuario) && $idUsuario!=''){             $SIS_data .= ",'".$idUsuario."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idSistema) && $idSistema!=''){             $SIS_data .= ",'".$idSistema."'";       }else{ $SIS_data .= ",''"; }
									if(isset($idCliente) && $idCliente!=''){             $SIS_data .= ",'".$idCliente."'";       }else{ $SIS_data .= ",''"; }

									// inserto los datos de registro en la db
									$SIS_columns = 'idTipo, idFacturacion, idDocPago, N_DocPago, F_Pago, F_Pago_dia, F_Pago_Semana, F_Pago_mes, F_Pago_ano, MontoPagado, montoPactado, idUsuario, idSistema, idCliente';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_facturas_clientes', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}

							}elseif(isset($tipo['idDocumentos'])&&$tipo['idDocumentos']==3){

								$idFacturacion     = $tipo['idFacturacion'];
								$idFacRelacionada  = $tipo['idFacRelacionada'];

								//Filtros
								$SIS_data = "idFacturacion='".$idFacturacion."'";
								if(isset($idFacRelacionada) && $idFacRelacionada!=''){       $SIS_data .= ",idFacturacionRelacionado='".$idFacRelacionada."'";}
								if(isset($F_Pago) && $F_Pago!=''){
									$SIS_data .= ",F_Pago='".$F_Pago."'";
									$SIS_data .= ",F_Pago_dia='".fecha2NdiaMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_mes='".fecha2NMes($F_Pago)."'";
									$SIS_data .= ",F_Pago_ano='".fecha2Ano($F_Pago)."'";
								}else{
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
									$SIS_data .= ",''";
								}
								$SIS_data .= ",idEstado='2'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'bodegas_servicios_facturacion', 'idFacturacion = "'.$idFacturacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}
				}

				////////////////////////////////////////////////////////////////////////////////////////////
				//elimino los datos
				unset($_SESSION['pago_clientes_insumos']);
				unset($_SESSION['pago_clientes_productos']);
				unset($_SESSION['pago_clientes_arriendo']);
				unset($_SESSION['pago_clientes_servicio']);

				//redirijo
				header( 'Location: '.$location.'?pay=true' );
				die;
			}

		break;

	}

?>
