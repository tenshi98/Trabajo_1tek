<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-264).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idProveedor']))     $idProveedor     = $_POST['idProveedor'];
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
			case 'idProveedor':    if(empty($idProveedor)){     $error['idProveedor']    = 'error/No ha ingresado el id';}break;
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
/*                                               Reversa Pago Masivo                                               */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'del_pagos':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			/************************************************************/
			//verifico si se envia un entero
			if((!validarNumero($_GET['del_idDocPago']) OR !validaEntero($_GET['del_idDocPago']))&&$_GET['del_idDocPago']!=''){
				$indice1 = simpleDecode($_GET['del_idDocPago'], fecha_actual());
			}else{
				$indice1 = $_GET['del_idDocPago'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );
			}
			if((!validarNumero($_GET['del_N_DocPago']) OR !validaEntero($_GET['del_N_DocPago']))&&$_GET['del_N_DocPago']!=''){
				$indice2 = simpleDecode($_GET['del_N_DocPago'], fecha_actual());
			}else{
				$indice2 = $_GET['del_N_DocPago'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );
			}

			/************************************************************/
			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice1)&&$indice1!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice1 ('.$indice1.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice1)&&$indice1!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice1 ('.$indice1.') en la opción DEL  no es un numero entero';
				$errorn++;
			}
			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice2)&&$indice2!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice2 ('.$indice2.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice2)&&$indice2!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice2 ('.$indice2.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			/************************************************************/
			if($errorn==0){

				//validaciones
				if(!isset($indice1) OR $indice1==''){
					$error['idDocPago'] = 'error/No ha seleccionado un documento';
				}
				if(!isset($indice2) OR $indice2==''){
					$error['idDocPago'] = 'error/No ha seleccionado un numero de documento';
				}

				/*******************************************************************/
				//Si no hay errores ejecuto el codigo
				if(empty($error)){

					//variable
					$Valor_Doc = 0;

					//filtro
					$z = 'pagos_rrhh_liquidaciones.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
					$z .= ' AND pagos_rrhh_liquidaciones.idDocPago='.$indice1;
					$z .= ' AND pagos_rrhh_liquidaciones.N_DocPago='.$indice2;

					//consulto los datos
					$arrReversa = array();
					$arrReversa = db_select_array (false, 'idPago, idFactTrab, MontoPagado, montoPactado', 'pagos_rrhh_liquidaciones', '', $z, 'idPago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//actualizo registro de la liquidacion
					if ($arrReversa!=false && !empty($arrReversa) && $arrReversa!='') {
						foreach ($arrReversa as $tipo){
							//sumo al total de la reversa
							$Valor_Doc = $Valor_Doc + $tipo['MontoPagado'];
							//calculo el nuevo saldo
							$nuevoMonto = $tipo['montoPactado'] - $tipo['MontoPagado'];
							//si el saldo es 0
							if($nuevoMonto==0){
								//se actualizala liquidacion
								$SIS_data  = "idFactTrab='".$tipo['idFactTrab']."'";
								$SIS_data .= ",idUsuarioPago=''";
								$SIS_data .= ",idDocPago=''";
								$SIS_data .= ",N_DocPago=''";
								$SIS_data .= ",F_Pago=''";
								$SIS_data .= ",F_Pago_dia=''";
								$SIS_data .= ",F_Pago_mes=''";
								$SIS_data .= ",F_Pago_ano=''";
								$SIS_data .= ",MontoPagado=''";
								$SIS_data .= ",idEstado='1'";//abierto

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores', 'idFactTrab = "'.$tipo['idFactTrab'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//si ya tiene un saldo anterior
							}else{
								//se actualizala liquidacion
								$SIS_data = "idFactTrab='".$tipo['idFactTrab']."'";
								$SIS_data .= ",MontoPagado='".$nuevoMonto."'";
								$SIS_data .= ",idEstado='1'";//abierto

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores', 'idFactTrab = "'.$tipo['idFactTrab'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}

							//elimino el registro del pago en los trabajadores
							$resultado = db_delete_data (false, 'pagos_rrhh_liquidaciones', 'idPago = "'.$tipo['idPago'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

				}

				//inserto la reversa
				$SIS_data  = "'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idSistema']."'"; //idSistema
				$SIS_data .= ",'".fecha_actual()."'";                                  //Fecha
				$SIS_data .= ",'".hora_actual()."'";                                   //Hora
				$SIS_data .= ",'".$indice1."'";                                        //idDocPago
				$SIS_data .= ",'".$indice2."'";                                        //N_DocPago
				$SIS_data .= ",'".$Valor_Doc."'";                                      //Monto

				// inserto los datos de registro en la db
				$SIS_columns = 'idUsuario, idSistema, Fecha, Hora, idDocPago, N_DocPago, Monto';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_rrhh_liquidaciones_reversa', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&pagina=1&reversa=true' );
					die;
				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;

	}

?>
