<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-263).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idDocPago']))       $idDocPago       = $_POST['idDocPago'];
	if (!empty($_POST['N_DocPago']))       $N_DocPago       = $_POST['N_DocPago'];
	if (!empty($_POST['F_Pago']))          $F_Pago          = $_POST['F_Pago'];
	if (!empty($_POST['idUsuario']))       $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['idSistema']))       $idSistema       = $_POST['idSistema'];

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
			case 'idDocPago':      if(empty($idDocPago)){       $error['idDocPago']      = 'error/No ha seleccionado el documento de pago';}break;
			case 'N_DocPago':      if(empty($N_DocPago)){       $error['N_DocPago']      = 'error/No ha ingresado numero de documento de pago';}break;
			case 'F_Pago':         if(empty($F_Pago)){          $error['F_Pago']         = 'error/No ha ingresado la fecha de pago';}break;
			case 'idUsuario':      if(empty($idUsuario)){       $error['idUsuario']      = 'error/No ha seleccionado el usuario';}break;
			case 'idSistema':      if(empty($idSistema)){       $error['idSistema']      = 'error/No ha seleccionado el sistema';}break;

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
		case 'del_liquidacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['pago_rrhh_liquidaciones'][$_GET['del_liquidacion']]);

			header( 'Location: '.$location.'&next=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'pago_general':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//si no existe un numero de documento, se genera uno automaticamente
				if(!isset($N_DocPago) OR $N_DocPago == ''){
					$N_DocPago = time();//clave unica
				}

				////////////////////////////////////////////////////////////////////////////////////////////////
				//recorro todos los existentes y les doy pago
				if(isset($_SESSION['pago_rrhh_liquidaciones'])){
					foreach ($_SESSION['pago_rrhh_liquidaciones'] as $key => $tipo){
						//se toman datos previamente guardados
						$idFactTrab    = $tipo['idFactTrab'];
						$montoPactado  = valores_enteros($tipo['TotalAPagar']);
						$ValorPagado   = valores_enteros($tipo['ValorPagado']);
						$MontoPagado   = valores_enteros($tipo['ValorPagado']+$tipo['MontoPagado']);

						/*********************************************************************/
						//se actualizala liquidacion
						$SIS_data = "idFactTrab='".$idFactTrab."'";
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
						if(isset($MontoPagado) &&$MontoPagado!= ''){   $SIS_data .= ",MontoPagado='".$MontoPagado."'";}
						//verifico el cierre
						if($montoPactado<=$MontoPagado){
							$SIS_data .= ",idEstado='2'";//cerrado
						}else{
							$SIS_data .= ",idEstado='1'";//abierto
						}
						/*******************************************************/
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores', 'idFactTrab = "'.$idFactTrab.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//se inserta el pago
						if(isset($idDocPago) && $idDocPago!=''){   $SIS_data  = "'".$idDocPago."'";   }else{ $SIS_data  = "''"; }
						if(isset($N_DocPago) && $N_DocPago!=''){   $SIS_data .= ",'".$N_DocPago."'";  }else{ $SIS_data .= ",''"; }
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
						if(isset($ValorPagado) && $ValorPagado!=''){       $SIS_data .= ",'".$ValorPagado."'";    }else{ $SIS_data .= ",''"; }
						if(isset($montoPactado) && $montoPactado!=''){     $SIS_data .= ",'".$montoPactado."'";   }else{ $SIS_data .= ",''"; }
						if(isset($idUsuario) && $idUsuario!=''){           $SIS_data .= ",'".$idUsuario."'";      }else{ $SIS_data .= ",''"; }
						if(isset($idSistema) && $idSistema!=''){           $SIS_data .= ",'".$idSistema."'";      }else{ $SIS_data .= ",''"; }
						if(isset($idFactTrab) && $idFactTrab!=''){         $SIS_data .= ",'".$idFactTrab."'";     }else{ $SIS_data .= ",''"; }

						// inserto los datos de registro en la db
						$SIS_columns = 'idDocPago,N_DocPago,F_Pago, F_Pago_dia,F_Pago_Semana,F_Pago_mes,F_Pago_ano,MontoPagado,montoPactado, idUsuario,idSistema,idFactTrab';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_rrhh_liquidaciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}

				////////////////////////////////////////////////////////////////////////////////////////////
				//elimino los datos
				unset($_SESSION['pago_rrhh_liquidaciones']);

				//redirijo
				header( 'Location: '.$location.'?pay=true' );
				die;
			}

		break;

	}

?>
