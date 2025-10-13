<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-259).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFactFiscal']))               $idFactFiscal              = $_POST['idFactFiscal'];
	if (!empty($_POST['idSistema']))                  $idSistema                 = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))                  $idUsuario                 = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))                 $fecha_auto                = $_POST['fecha_auto'];
	if (!empty($_POST['Periodo_Ano']))                $Periodo_Ano               = $_POST['Periodo_Ano'];
	if (!empty($_POST['Periodo_Mes']))                $Periodo_Mes               = $_POST['Periodo_Mes'];
	if (!empty($_POST['Pago_fecha']))                 $Pago_fecha                = $_POST['Pago_fecha'];
	if (!empty($_POST['Observaciones']))              $Observaciones             = $_POST['Observaciones'];
	if (!empty($_POST['Porcentaje_PPM']))             $Porcentaje_PPM            = $_POST['Porcentaje_PPM'];
	if (!empty($_POST['Saldos_IVA_Anterior']))        $Saldos_IVA_Anterior       = $_POST['Saldos_IVA_Anterior'];
	if (!empty($_POST['Saldos_IVA_Actual']))          $Saldos_IVA_Actual         = $_POST['Saldos_IVA_Actual'];
	if (!empty($_POST['IVA_TotalSaldo']))             $IVA_TotalSaldo            = $_POST['IVA_TotalSaldo'];
	if (!empty($_POST['IVA_Diferencia']))             $IVA_Diferencia            = $_POST['IVA_Diferencia'];
	if (!empty($_POST['PPM_Saldo']))                  $PPM_Saldo                 = $_POST['PPM_Saldo'];
	if (!empty($_POST['PPM_Pago']))                   $PPM_Pago                  = $_POST['PPM_Pago'];
	if (!empty($_POST['PPM_Diferencia']))             $PPM_Diferencia            = $_POST['PPM_Diferencia'];
	if (!empty($_POST['Retencion']))                  $Retencion                 = $_POST['Retencion'];
	if (!empty($_POST['TotalGeneral']))               $TotalGeneral              = $_POST['TotalGeneral'];

	if (!empty($_POST['IVA_MontoPago']))              $IVA_MontoPago             = $_POST['IVA_MontoPago'];
	if (!empty($_POST['edit_iva']))                   $edit_iva                  = $_POST['edit_iva'];

	if (!empty($_POST['PPM_MontoPago']))              $PPM_MontoPago             = $_POST['PPM_MontoPago'];
	if (!empty($_POST['edit_ppm']))                   $edit_ppm                  = $_POST['edit_ppm'];

	if (!empty($_POST['IVA_idDocPago']))              $IVA_idDocPago             = $_POST['IVA_idDocPago'];
	if (!empty($_POST['IVA_N_DocPago']))              $IVA_N_DocPago             = $_POST['IVA_N_DocPago'];
	if (!empty($_POST['IVA_F_Pago']))                 $IVA_F_Pago                = $_POST['IVA_F_Pago'];
	if (!empty($_POST['IVA_Monto']))                  $IVA_Monto                 = $_POST['IVA_Monto'];

	if (!empty($_POST['PPM_idDocPago']))              $PPM_idDocPago             = $_POST['PPM_idDocPago'];
	if (!empty($_POST['PPM_N_DocPago']))              $PPM_N_DocPago             = $_POST['PPM_N_DocPago'];
	if (!empty($_POST['PPM_F_Pago']))                 $PPM_F_Pago                = $_POST['PPM_F_Pago'];
	if (!empty($_POST['PPM_Monto']))                  $PPM_Monto                 = $_POST['PPM_Monto'];

	if (!empty($_POST['RET_idDocPago']))              $RET_idDocPago             = $_POST['RET_idDocPago'];
	if (!empty($_POST['RET_N_DocPago']))              $RET_N_DocPago             = $_POST['RET_N_DocPago'];
	if (!empty($_POST['RET_F_Pago']))                 $RET_F_Pago                = $_POST['RET_F_Pago'];
	if (!empty($_POST['RET_Monto']))                  $RET_Monto                 = $_POST['RET_Monto'];

	if (!empty($_POST['IMPRENT_idDocPago']))          $IMPRENT_idDocPago         = $_POST['IMPRENT_idDocPago'];
	if (!empty($_POST['IMPRENT_N_DocPago']))          $IMPRENT_N_DocPago         = $_POST['IMPRENT_N_DocPago'];
	if (!empty($_POST['IMPRENT_F_Pago']))             $IMPRENT_F_Pago            = $_POST['IMPRENT_F_Pago'];
	if (!empty($_POST['IMPRENT_Monto']))              $IMPRENT_Monto             = $_POST['IMPRENT_Monto'];

	if (!empty($_POST['IVA_Total_deuda']))            $IVA_Total_deuda           = $_POST['IVA_Total_deuda'];
	if (!empty($_POST['PPM_Total_deuda']))            $PPM_Total_deuda           = $_POST['PPM_Total_deuda'];
	if (!empty($_POST['RET_Total_deuda']))            $RET_Total_deuda           = $_POST['RET_Total_deuda'];
	if (!empty($_POST['IMPRENT_Total_deuda']))        $IMPRENT_Total_deuda       = $_POST['IMPRENT_Total_deuda'];
	if (!empty($_POST['Creacion_fecha']))             $Creacion_fecha            = $_POST['Creacion_fecha'];

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
			case 'idFactFiscal':               if(empty($idFactFiscal)){               $error['idFactFiscal']                 = 'error/No ha seleccionado el id';}break;
			case 'idSistema':                  if(empty($idSistema)){                  $error['idSistema']                    = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':                  if(empty($idUsuario)){                  $error['idUsuario']                    = 'error/No ha seleccionado el usuario';}break;
			case 'fecha_auto':                 if(empty($fecha_auto)){                 $error['fecha_auto']                   = 'error/No ha ingresado la fecha';}break;
			case 'Periodo_Ano':                if(empty($Periodo_Ano)){                $error['Periodo_Ano']                  = 'error/No ha seleccionado el año';}break;
			case 'Periodo_Mes':                if(empty($Periodo_Mes)){                $error['Periodo_Mes']                  = 'error/No ha seleccionado el mes';}break;
			case 'Pago_fecha':                 if(empty($Pago_fecha)){                 $error['Pago_fecha']                   = 'error/No ha ingresado la fecha de pago';}break;
			case 'Observaciones':              if(empty($Observaciones)){              $error['Observaciones']                = 'error/No ha ingresado las observaciones';}break;
			case 'Porcentaje_PPM':             if(empty($Porcentaje_PPM)){             $error['Porcentaje_PPM']               = 'error/No ha ingresado el porcentaje ppm';}break;
			case 'Saldos_IVA_Anterior':        if(empty($Saldos_IVA_Anterior)){        $error['Saldos_IVA_Anterior']          = 'error/No ha ingresado el saldo del IVA anterior';}break;
			case 'Saldos_IVA_Actual':          if(empty($Saldos_IVA_Actual)){          $error['Saldos_IVA_Actual']            = 'error/No ha ingresado el saldo del IVA actual';}break;
			case 'IVA_TotalSaldo':             if(empty($IVA_TotalSaldo)){             $error['IVA_TotalSaldo']               = 'error/No ha ingresado el total saldo IVA';}break;
			case 'IVA_Diferencia':             if(empty($IVA_Diferencia)){             $error['IVA_Diferencia']               = 'error/No ha ingresado el total diferencia IVA';}break;
			case 'PPM_Saldo':                  if(empty($PPM_Saldo)){                  $error['PPM_Saldo']                    = 'error/No ha ingresado el total saldo PPM';}break;
			case 'PPM_Pago':                   if(empty($PPM_Pago)){                   $error['PPM_Pago']                     = 'error/No ha ingresado el total monto pagado PPM';}break;
			case 'PPM_Diferencia':             if(empty($PPM_Diferencia)){             $error['PPM_Diferencia']               = 'error/No ha ingresado el total diferencia PPM';}break;
			case 'Retencion':                  if(empty($Retencion)){                  $error['Retencion']                    = 'error/No ha ingresado la retencion';}break;
			case 'TotalGeneral':               if(empty($TotalGeneral)){               $error['TotalGeneral']                 = 'error/No ha ingresado el total general';}break;

			case 'IVA_MontoPago':              if(empty($IVA_MontoPago)){              $error['IVA_MontoPago']                = 'error/No ha ingresado el monto a pagar';}break;
			case 'edit_iva':                   if(empty($edit_iva)){                   $error['edit_iva']                     = 'error/No ha ingresado el item a editar';}break;

			case 'PPM_MontoPago':              if(empty($PPM_MontoPago)){              $error['PPM_MontoPago']                = 'error/No ha ingresado el monto a pagar';}break;
			case 'edit_ppm':                   if(empty($edit_ppm)){                   $error['edit_ppm']                     = 'error/No ha ingresado el item a editar';}break;

			case 'IVA_idDocPago':              if(empty($IVA_idDocPago)){              $error['IVA_idDocPago']                = 'error/No ha seleccionado el documento de pago';}break;
			case 'IVA_N_DocPago':              if(empty($IVA_N_DocPago)){              $error['IVA_N_DocPago']                = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'IVA_F_Pago':                 if(empty($IVA_F_Pago)){                 $error['IVA_F_Pago']                   = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'IVA_Monto':                  if(empty($IVA_Monto)){                  $error['IVA_Monto']                    = 'error/No ha ingresado el monto pagado';}break;

			case 'PPM_idDocPago':              if(empty($PPM_idDocPago)){              $error['PPM_idDocPago']                = 'error/No ha seleccionado el documento de pago';}break;
			case 'PPM_N_DocPago':              if(empty($PPM_N_DocPago)){              $error['PPM_N_DocPago']                = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'PPM_F_Pago':                 if(empty($PPM_F_Pago)){                 $error['PPM_F_Pago']                   = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'PPM_Monto':                  if(empty($PPM_Monto)){                  $error['PPM_Monto']                    = 'error/No ha ingresado el monto pagado';}break;

			case 'RET_idDocPago':              if(empty($RET_idDocPago)){              $error['RET_idDocPago']                = 'error/No ha seleccionado el documento de pago';}break;
			case 'RET_N_DocPago':              if(empty($RET_N_DocPago)){              $error['RET_N_DocPago']                = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'RET_F_Pago':                 if(empty($RET_F_Pago)){                 $error['RET_F_Pago']                   = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'RET_Monto':                  if(empty($RET_Monto)){                  $error['RET_Monto']                    = 'error/No ha ingresado el monto pagado';}break;

			case 'IMPRENT_idDocPago':          if(empty($IMPRENT_idDocPago)){          $error['IMPRENT_idDocPago']            = 'error/No ha seleccionado el documento de pago';}break;
			case 'IMPRENT_N_DocPago':          if(empty($IMPRENT_N_DocPago)){          $error['IMPRENT_N_DocPago']            = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'IMPRENT_F_Pago':             if(empty($IMPRENT_F_Pago)){             $error['IMPRENT_F_Pago']               = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'IMPRENT_Monto':              if(empty($IMPRENT_Monto)){              $error['IMPRENT_Monto']                = 'error/No ha ingresado el monto pagado';}break;

			//case 'IVA_Total_deuda':            if(empty($IVA_Total_deuda)){            $error['IVA_Total_deuda']              = 'error/No ha ingresado el IVA total';}break;
			//case 'PPM_Total_deuda':            if(empty($PPM_Total_deuda)){            $error['PPM_Total_deuda']              = 'error/No ha ingresado el PPM total';}break;
			//case 'RET_Total_deuda':            if(empty($RET_Total_deuda)){            $error['RET_Total_deuda']              = 'error/No ha ingresado la retencion total';}break;
			//case 'IMPRENT_Total_deuda':        if(empty($IMPRENT_Total_deuda)){        $error['IMPRENT_Total_deuda']          = 'error/No ha ingresado el impuesto a la renta total';}break;
			case 'Creacion_fecha':             if(empty($Creacion_fecha)){             $error['Creacion_fecha']               = 'error/No ha ingresado la fecha de creación';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Descripcion) && $Descripcion!=''){     $Descripcion   = EstandarizarInput($Descripcion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){      $error['Descripcion']   = 'error/Edita Descripcion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       egresoS                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['pagos_leyes_fiscales_basicos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_arriendos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_insumos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_productos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_servicios']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_retenciones']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_trabajadores']);
				unset($_SESSION['pagos_leyes_fiscales_formas_pago']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['pagos_leyes_fiscales_archivos'])){
					foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
				unset($_SESSION['pagos_leyes_fiscales_archivos']);

				/****************************************************/
				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Periodo_Ano)&&$Periodo_Ano!=''){        $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']     = $Periodo_Ano;    }else{$_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']     = '';}
				if(isset($Periodo_Mes)&&$Periodo_Mes!=''){        $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']     = $Periodo_Mes;    }else{$_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']     = '';}
				if(isset($Pago_fecha)&&$Pago_fecha!=''){          $_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']      = $Pago_fecha;     }else{$_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']      = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['pagos_leyes_fiscales_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['pagos_leyes_fiscales_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']      = $fecha_auto;     }else{$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']      = '';}

				$_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']      = 0;
				$_SESSION['pagos_leyes_fiscales_basicos']['TotalPagoGeneral']  = 0;

				//Busco datos en la base de datos
				$rowSaldo = db_select_data (false, 'Saldos_IVA_Actual', 'pagos_leyes_fiscales', '', 'idFactFiscal!=0 ORDER BY idFactFiscal DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if(isset($rowSaldo['Saldos_IVA_Actual'])&&$rowSaldo['Saldos_IVA_Actual']!=''){ $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'] = $rowSaldo['Saldos_IVA_Actual'];   }else{ $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'] = 0;}

				$SIS_query = '
				sistema_leyes_fiscales.Porcentaje_PPM,
				sistema_leyes_fiscales.IVA_idCentroCosto,
				sistema_leyes_fiscales.IVA_idLevel_1,
				sistema_leyes_fiscales.IVA_idLevel_2,
				sistema_leyes_fiscales.IVA_idLevel_3,
				sistema_leyes_fiscales.IVA_idLevel_4,
				sistema_leyes_fiscales.IVA_idLevel_5,
				sistema_leyes_fiscales.PPM_idCentroCosto,
				sistema_leyes_fiscales.PPM_idLevel_1,
				sistema_leyes_fiscales.PPM_idLevel_2,
				sistema_leyes_fiscales.PPM_idLevel_3,
				sistema_leyes_fiscales.PPM_idLevel_4,
				sistema_leyes_fiscales.PPM_idLevel_5,
				sistema_leyes_fiscales.RET_idCentroCosto,
				sistema_leyes_fiscales.RET_idLevel_1,
				sistema_leyes_fiscales.RET_idLevel_2,
				sistema_leyes_fiscales.RET_idLevel_3,
				sistema_leyes_fiscales.RET_idLevel_4,
				sistema_leyes_fiscales.RET_idLevel_5,
				sistema_leyes_fiscales.IMPRENT_idCentroCosto,
				sistema_leyes_fiscales.IMPRENT_idLevel_1,
				sistema_leyes_fiscales.IMPRENT_idLevel_2,
				sistema_leyes_fiscales.IMPRENT_idLevel_3,
				sistema_leyes_fiscales.IMPRENT_idLevel_4,
				sistema_leyes_fiscales.IMPRENT_idLevel_5,
				IVA_Centro.Nombre AS IVA_CC_Nombre,
				IVA_Centro_lv_1.Nombre AS IVA_CC_Level_1,
				IVA_Centro_lv_2.Nombre AS IVA_CC_Level_2,
				IVA_Centro_lv_3.Nombre AS IVA_CC_Level_3,
				IVA_Centro_lv_4.Nombre AS IVA_CC_Level_4,
				IVA_Centro_lv_5.Nombre AS IVA_CC_Level_5,
				PPM_Centro.Nombre AS PPM_CC_Nombre,
				PPM_Centro_lv_1.Nombre AS PPM_CC_Level_1,
				PPM_Centro_lv_2.Nombre AS PPM_CC_Level_2,
				PPM_Centro_lv_3.Nombre AS PPM_CC_Level_3,
				PPM_Centro_lv_4.Nombre AS PPM_CC_Level_4,
				PPM_Centro_lv_5.Nombre AS PPM_CC_Level_5,
				RET_Centro.Nombre AS RET_CC_Nombre,
				RET_Centro_lv_1.Nombre AS RET_CC_Level_1,
				RET_Centro_lv_2.Nombre AS RET_CC_Level_2,
				RET_Centro_lv_3.Nombre AS RET_CC_Level_3,
				RET_Centro_lv_4.Nombre AS RET_CC_Level_4,
				RET_Centro_lv_5.Nombre AS RET_CC_Level_5,
				IMPRENT_Centro.Nombre AS IMPRENT_CC_Nombre,
				IMPRENT_Centro_lv_1.Nombre AS IMPRENT_CC_Level_1,
				IMPRENT_Centro_lv_2.Nombre AS IMPRENT_CC_Level_2,
				IMPRENT_Centro_lv_3.Nombre AS IMPRENT_CC_Level_3,
				IMPRENT_Centro_lv_4.Nombre AS IMPRENT_CC_Level_4,
				IMPRENT_Centro_lv_5.Nombre AS IMPRENT_CC_Level_5
				';
				$SIS_join = '
				LEFT JOIN `centrocosto_listado`          IVA_Centro             ON IVA_Centro.idCentroCosto        = sistema_leyes_fiscales.IVA_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  IVA_Centro_lv_1        ON IVA_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.IVA_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  IVA_Centro_lv_2        ON IVA_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.IVA_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  IVA_Centro_lv_3        ON IVA_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.IVA_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  IVA_Centro_lv_4        ON IVA_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.IVA_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  IVA_Centro_lv_5        ON IVA_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.IVA_idLevel_5
				LEFT JOIN `centrocosto_listado`          PPM_Centro             ON PPM_Centro.idCentroCosto        = sistema_leyes_fiscales.PPM_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  PPM_Centro_lv_1        ON PPM_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.PPM_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  PPM_Centro_lv_2        ON PPM_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.PPM_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  PPM_Centro_lv_3        ON PPM_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.PPM_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  PPM_Centro_lv_4        ON PPM_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.PPM_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  PPM_Centro_lv_5        ON PPM_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.PPM_idLevel_5
				LEFT JOIN `centrocosto_listado`          RET_Centro             ON RET_Centro.idCentroCosto        = sistema_leyes_fiscales.RET_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  RET_Centro_lv_1        ON RET_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.RET_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  RET_Centro_lv_2        ON RET_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.RET_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  RET_Centro_lv_3        ON RET_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.RET_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  RET_Centro_lv_4        ON RET_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.RET_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  RET_Centro_lv_5        ON RET_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.RET_idLevel_5
				LEFT JOIN `centrocosto_listado`          IMPRENT_Centro         ON IMPRENT_Centro.idCentroCosto    = sistema_leyes_fiscales.IMPRENT_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  IMPRENT_Centro_lv_1    ON IMPRENT_Centro_lv_1.idLevel_1   = sistema_leyes_fiscales.IMPRENT_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  IMPRENT_Centro_lv_2    ON IMPRENT_Centro_lv_2.idLevel_2   = sistema_leyes_fiscales.IMPRENT_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  IMPRENT_Centro_lv_3    ON IMPRENT_Centro_lv_3.idLevel_3   = sistema_leyes_fiscales.IMPRENT_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  IMPRENT_Centro_lv_4    ON IMPRENT_Centro_lv_4.idLevel_4   = sistema_leyes_fiscales.IMPRENT_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  IMPRENT_Centro_lv_5    ON IMPRENT_Centro_lv_5.idLevel_5   = sistema_leyes_fiscales.IMPRENT_idLevel_5
				';
				$rowPPM   = db_select_data (false, $SIS_query, 'sistema_leyes_fiscales', $SIS_join, 'sistema_leyes_fiscales.idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if(isset($rowPPM['Porcentaje_PPM'])&&$rowPPM['Porcentaje_PPM']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']      = $rowPPM['Porcentaje_PPM'];
				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']      = 0;
				}

				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idCentroCosto']      = $rowPPM['IVA_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_1']          = $rowPPM['IVA_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_2']          = $rowPPM['IVA_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_3']          = $rowPPM['IVA_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_4']          = $rowPPM['IVA_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_5']          = $rowPPM['IVA_idLevel_5'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idCentroCosto']      = $rowPPM['PPM_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_1']          = $rowPPM['PPM_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_2']          = $rowPPM['PPM_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_3']          = $rowPPM['PPM_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_4']          = $rowPPM['PPM_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_5']          = $rowPPM['PPM_idLevel_5'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idCentroCosto']      = $rowPPM['RET_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_1']          = $rowPPM['RET_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_2']          = $rowPPM['RET_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_3']          = $rowPPM['RET_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_4']          = $rowPPM['RET_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_5']          = $rowPPM['RET_idLevel_5'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idCentroCosto']  = $rowPPM['IMPRENT_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_1']      = $rowPPM['IMPRENT_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_2']      = $rowPPM['IMPRENT_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_3']      = $rowPPM['IMPRENT_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_4']      = $rowPPM['IMPRENT_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_5']      = $rowPPM['IMPRENT_idLevel_5'];

				if(isset($rowPPM['IVA_CC_Nombre'])&&$rowPPM['IVA_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] = $rowPPM['IVA_CC_Nombre'];
					if(isset($rowPPM['IVA_CC_Level_1'])&&$rowPPM['IVA_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_1'];}
					if(isset($rowPPM['IVA_CC_Level_2'])&&$rowPPM['IVA_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_2'];}
					if(isset($rowPPM['IVA_CC_Level_3'])&&$rowPPM['IVA_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_3'];}
					if(isset($rowPPM['IVA_CC_Level_4'])&&$rowPPM['IVA_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_4'];}
					if(isset($rowPPM['IVA_CC_Level_5'])&&$rowPPM['IVA_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] = '';
				}
				if(isset($rowPPM['PPM_CC_Nombre'])&&$rowPPM['PPM_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] = $rowPPM['PPM_CC_Nombre'];
					if(isset($rowPPM['PPM_CC_Level_1'])&&$rowPPM['PPM_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_1'];}
					if(isset($rowPPM['PPM_CC_Level_2'])&&$rowPPM['PPM_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_2'];}
					if(isset($rowPPM['PPM_CC_Level_3'])&&$rowPPM['PPM_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_3'];}
					if(isset($rowPPM['PPM_CC_Level_4'])&&$rowPPM['PPM_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_4'];}
					if(isset($rowPPM['PPM_CC_Level_5'])&&$rowPPM['PPM_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] = '';
				}
				if(isset($rowPPM['RET_CC_Nombre'])&&$rowPPM['RET_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] = $rowPPM['RET_CC_Nombre'];
					if(isset($rowPPM['RET_CC_Level_1'])&&$rowPPM['RET_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_1'];}
					if(isset($rowPPM['RET_CC_Level_2'])&&$rowPPM['RET_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_2'];}
					if(isset($rowPPM['RET_CC_Level_3'])&&$rowPPM['RET_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_3'];}
					if(isset($rowPPM['RET_CC_Level_4'])&&$rowPPM['RET_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_4'];}
					if(isset($rowPPM['RET_CC_Level_5'])&&$rowPPM['RET_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] = '';
				}
				if(isset($rowPPM['IMPRENT_CC_Nombre'])&&$rowPPM['IMPRENT_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] = $rowPPM['IMPRENT_CC_Nombre'];
					if(isset($rowPPM['IMPRENT_CC_Level_1'])&&$rowPPM['IMPRENT_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_1'];}
					if(isset($rowPPM['IMPRENT_CC_Level_2'])&&$rowPPM['IMPRENT_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_2'];}
					if(isset($rowPPM['IMPRENT_CC_Level_3'])&&$rowPPM['IMPRENT_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_3'];}
					if(isset($rowPPM['IMPRENT_CC_Level_4'])&&$rowPPM['IMPRENT_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_4'];}
					if(isset($rowPPM['IMPRENT_CC_Level_5'])&&$rowPPM['IMPRENT_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] = '';
				}

				/****************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['pagos_leyes_fiscales_basicos']['Usuario']  = $rowUsuario['Nombre'];
				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['Usuario']  = '';
				}

				/****************************************************/
				//Solo compras pagadas totalmente
				$z1 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z2 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z3 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z4 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z5 = "idFactFiscal=0";   //solo las emitidas por los empleados
				$z6 = "idFactFiscal=0";   //solo las que no esten asignadas

				//Filtro Fecha
				if(isset($Periodo_Ano)&&$Periodo_Ano!=''){
					$z1.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z2.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z3.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z4.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z5.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z6.=" AND Creacion_ano='".$Periodo_Ano."'";
				}
				if(isset($Periodo_Mes)&&$Periodo_Mes!=''){
					$z1.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z2.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z3.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z4.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z5.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z6.=" AND Creacion_mes='".$Periodo_Mes."'";
				}
				if(isset($idSistema)&&$idSistema!=''){
					$z1.=" AND idSistema='".$idSistema."'";
					$z2.=" AND idSistema='".$idSistema."'";
					$z3.=" AND idSistema='".$idSistema."'";
					$z4.=" AND idSistema='".$idSistema."'";
					$z5.=" AND idSistema='".$idSistema."'";
					$z6.=" AND idSistema='".$idSistema."'";
				}
				//agrupaciones
				$z1.=" GROUP BY idTipo";
				$z2.=" GROUP BY idTipo";
				$z3.=" GROUP BY idTipo";
				$z4.=" GROUP BY idTipo";
				$z5.=" GROUP BY idTipo";
				$z6.=" GROUP BY idSistema";
				/*************************************************************************************************/
				//filtro
				$SIS_query1 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query2 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query3 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query4 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query5 = 'idTipo, SUM(Impuesto) AS Retencion';
				$SIS_query6 = 'idSistema, SUM(ImpuestoRenta) AS ImpuestoRenta';
				//Bodega de Arriendos
				$arrTemporal_1 = array();
				$arrTemporal_1 = db_select_array (false, $SIS_query1, 'bodegas_arriendos_facturacion', '', $z1, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_1');
				//Bodega de Insumos
				$arrTemporal_2 = array();
				$arrTemporal_2 = db_select_array (false, $SIS_query2, 'bodegas_insumos_facturacion', '', $z2, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_2');
				//Bodega de Productos
				$arrTemporal_3 = array();
				$arrTemporal_3 = db_select_array (false, $SIS_query3, 'bodegas_productos_facturacion', '', $z3, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_3');
				//Bodega de Servicios
				$arrTemporal_4 = array();
				$arrTemporal_4 = db_select_array (false, $SIS_query4, 'bodegas_servicios_facturacion', '', $z4, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');
				//Boleta de honorarios
				$arrTemporal_5 = array();
				$arrTemporal_5 = db_select_array (false, $SIS_query5, 'boleta_honorarios_facturacion', '', $z5, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_5');
				//Liquidaciones de sueldo
				$arrTemporal_6 = array();
				$arrTemporal_6 = db_select_array (false, $SIS_query6, 'rrhh_sueldos_facturacion_trabajadores', '', $z6, 'idSistema ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_6');

				/*************************************************************************************************/
				//Creo los datos
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos']    = array();//arriendos
				$_SESSION['pagos_leyes_fiscales_pagos_insumos']      = array();//insumos
				$_SESSION['pagos_leyes_fiscales_pagos_productos']    = array();//productos
				$_SESSION['pagos_leyes_fiscales_pagos_servicios']    = array();//servicios
				$_SESSION['pagos_leyes_fiscales_pagos_retenciones']  = array();//boletas de honorarios
				$_SESSION['pagos_leyes_fiscales_pagos_trabajadores'] = array();//liquidaciones de sueldo
				$_SESSION['pagos_leyes_fiscales_formas_pago']        = array();//Formas de pago

				//reseteo a  0
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago']           = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['IVA']                       = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['IVA']                       = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['ValorNeto']                 = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['ValorNeto']                 = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo']            = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago']             = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia']            = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo']                 = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago']                  = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia']            = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago']           = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago']           = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta']           = 0;

				/********************************************/
				//recorro los arriendos
				if($arrTemporal_1!=false && !empty($arrTemporal_1) && $arrTemporal_1!=''){
					foreach ($arrTemporal_1 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los insumos
				if($arrTemporal_2!=false && !empty($arrTemporal_2) && $arrTemporal_2!=''){
					foreach ($arrTemporal_2 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los productos
				if($arrTemporal_3!=false && !empty($arrTemporal_3) && $arrTemporal_3!=''){
					foreach ($arrTemporal_3 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los servicios
				if($arrTemporal_4!=false && !empty($arrTemporal_4) && $arrTemporal_4!=''){
					foreach ($arrTemporal_4 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los boletas de honorarios
				if($arrTemporal_5!=false && !empty($arrTemporal_5) && $arrTemporal_5!=''){
					foreach ($arrTemporal_5 as $trab) {
						$_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion'] = $_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion'] + $trab['Retencion'];
					}
				}
				//recorro los boletas de honorarios
				if($arrTemporal_6!=false && !empty($arrTemporal_6) && $arrTemporal_6!=''){
					foreach ($arrTemporal_6 as $trab) {
						$_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta'] = $_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta'] + $trab['ImpuestoRenta'];
					}
				}

				/********************************************/
				//Calculos del IVA
				$TotalSaldo_1 = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['IVA'] - $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['IVA'];
				$TotalSaldo_2 = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['IVA']   - $_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['IVA'];
				$TotalSaldo_3 = $_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['IVA'] - $_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['IVA'];
				$TotalSaldo_4 = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['IVA'] - $_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['IVA'];
				//se guardan los datos
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo']    = $TotalSaldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo']      = $TotalSaldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo']    = $TotalSaldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo']    = $TotalSaldo_4;
				//guardo la diferencia
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia']    = $TotalSaldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia']      = $TotalSaldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia']    = $TotalSaldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia']    = $TotalSaldo_4;

				/********************************************/
				//Calculos totales de IVA
				$TotalSaldo = 0;
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo'];

				$MontoPago = 0;
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago'];

				$Diferencia = 0;
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia'];

				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_TotalSaldo'] = $TotalSaldo;
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago']  = $MontoPago;
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia'] = $Diferencia;

				/********************************************/
				//Calculos de PPM
				$PPM_Saldo_1  = ($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				$PPM_Saldo_2  = ($_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				$PPM_Saldo_3  = ($_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				$PPM_Saldo_4  = ($_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				//se guardan los datos
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo']  = $PPM_Saldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo']    = $PPM_Saldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo']  = $PPM_Saldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo']  = $PPM_Saldo_4;
				//guardo la diferencia
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia']  = $PPM_Saldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia']    = $PPM_Saldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia']  = $PPM_Saldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia']  = $PPM_Saldo_4;

				//Calculo totales PPM
				$TotalSaldo = 0;
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo'];

				$MontoPago = 0;
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago'];

				$Diferencia = 0;
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia'];

				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo']      = $TotalSaldo;
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago']       = $MontoPago;
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Diferencia'] = $Diferencia;

				/********************************************/
				//Calculo Retencion
				$_SESSION['pagos_leyes_fiscales_basicos']['Retencion'] = $_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion'];

				/********************************************/
				//Calculo Impuesto a la renta
				$_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'] = $_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta'];

				/********************************************/
				//Calculo de totales generales
				$_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Actual']  = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia'];
				$_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']       = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago'] + $_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago'] + $_SESSION['pagos_leyes_fiscales_basicos']['Retencion'] + $_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'];

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['pagos_leyes_fiscales_basicos']);
			unset($_SESSION['pagos_leyes_fiscales_pagos_arriendos']);
			unset($_SESSION['pagos_leyes_fiscales_pagos_insumos']);
			unset($_SESSION['pagos_leyes_fiscales_pagos_productos']);
			unset($_SESSION['pagos_leyes_fiscales_pagos_servicios']);
			unset($_SESSION['pagos_leyes_fiscales_pagos_retenciones']);
			unset($_SESSION['pagos_leyes_fiscales_pagos_trabajadores']);
			unset($_SESSION['pagos_leyes_fiscales_formas_pago']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['pagos_leyes_fiscales_archivos'])){
				foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
			unset($_SESSION['pagos_leyes_fiscales_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['pagos_leyes_fiscales_basicos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_arriendos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_insumos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_productos']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_servicios']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_retenciones']);
				unset($_SESSION['pagos_leyes_fiscales_pagos_trabajadores']);
				unset($_SESSION['pagos_leyes_fiscales_formas_pago']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['pagos_leyes_fiscales_archivos'])){
					foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
				unset($_SESSION['pagos_leyes_fiscales_archivos']);

				/****************************************************/
				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Periodo_Ano)&&$Periodo_Ano!=''){        $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']     = $Periodo_Ano;    }else{$_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']     = '';}
				if(isset($Periodo_Mes)&&$Periodo_Mes!=''){        $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']     = $Periodo_Mes;    }else{$_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']     = '';}
				if(isset($Pago_fecha)&&$Pago_fecha!=''){          $_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']      = $Pago_fecha;     }else{$_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']      = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['pagos_leyes_fiscales_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['pagos_leyes_fiscales_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']      = $fecha_auto;     }else{$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']      = '';}

				$_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']      = 0;
				$_SESSION['pagos_leyes_fiscales_basicos']['TotalPagoGeneral']  = 0;

				//Busco datos en la base de datos
				$rowSaldo = db_select_data (false, 'Saldos_IVA_Actual', 'pagos_leyes_fiscales', '', 'idFactFiscal!=0 ORDER BY idFactFiscal DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if(isset($rowSaldo['Saldos_IVA_Actual'])&&$rowSaldo['Saldos_IVA_Actual']!=''){ $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'] = $rowSaldo['Saldos_IVA_Actual'];   }else{ $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'] = 0;}

				$SIS_query = '
				sistema_leyes_fiscales.Porcentaje_PPM,
				sistema_leyes_fiscales.IVA_idCentroCosto,
				sistema_leyes_fiscales.IVA_idLevel_1,
				sistema_leyes_fiscales.IVA_idLevel_2,
				sistema_leyes_fiscales.IVA_idLevel_3,
				sistema_leyes_fiscales.IVA_idLevel_4,
				sistema_leyes_fiscales.IVA_idLevel_5,
				sistema_leyes_fiscales.PPM_idCentroCosto,
				sistema_leyes_fiscales.PPM_idLevel_1,
				sistema_leyes_fiscales.PPM_idLevel_2,
				sistema_leyes_fiscales.PPM_idLevel_3,
				sistema_leyes_fiscales.PPM_idLevel_4,
				sistema_leyes_fiscales.PPM_idLevel_5,
				sistema_leyes_fiscales.RET_idCentroCosto,
				sistema_leyes_fiscales.RET_idLevel_1,
				sistema_leyes_fiscales.RET_idLevel_2,
				sistema_leyes_fiscales.RET_idLevel_3,
				sistema_leyes_fiscales.RET_idLevel_4,
				sistema_leyes_fiscales.RET_idLevel_5,
				sistema_leyes_fiscales.IMPRENT_idCentroCosto,
				sistema_leyes_fiscales.IMPRENT_idLevel_1,
				sistema_leyes_fiscales.IMPRENT_idLevel_2,
				sistema_leyes_fiscales.IMPRENT_idLevel_3,
				sistema_leyes_fiscales.IMPRENT_idLevel_4,
				sistema_leyes_fiscales.IMPRENT_idLevel_5,
				IVA_Centro.Nombre AS IVA_CC_Nombre,
				IVA_Centro_lv_1.Nombre AS IVA_CC_Level_1,
				IVA_Centro_lv_2.Nombre AS IVA_CC_Level_2,
				IVA_Centro_lv_3.Nombre AS IVA_CC_Level_3,
				IVA_Centro_lv_4.Nombre AS IVA_CC_Level_4,
				IVA_Centro_lv_5.Nombre AS IVA_CC_Level_5,
				PPM_Centro.Nombre AS PPM_CC_Nombre,
				PPM_Centro_lv_1.Nombre AS PPM_CC_Level_1,
				PPM_Centro_lv_2.Nombre AS PPM_CC_Level_2,
				PPM_Centro_lv_3.Nombre AS PPM_CC_Level_3,
				PPM_Centro_lv_4.Nombre AS PPM_CC_Level_4,
				PPM_Centro_lv_5.Nombre AS PPM_CC_Level_5,
				RET_Centro.Nombre AS RET_CC_Nombre,
				RET_Centro_lv_1.Nombre AS RET_CC_Level_1,
				RET_Centro_lv_2.Nombre AS RET_CC_Level_2,
				RET_Centro_lv_3.Nombre AS RET_CC_Level_3,
				RET_Centro_lv_4.Nombre AS RET_CC_Level_4,
				RET_Centro_lv_5.Nombre AS RET_CC_Level_5,
				IMPRENT_Centro.Nombre AS IMPRENT_CC_Nombre,
				IMPRENT_Centro_lv_1.Nombre AS IMPRENT_CC_Level_1,
				IMPRENT_Centro_lv_2.Nombre AS IMPRENT_CC_Level_2,
				IMPRENT_Centro_lv_3.Nombre AS IMPRENT_CC_Level_3,
				IMPRENT_Centro_lv_4.Nombre AS IMPRENT_CC_Level_4,
				IMPRENT_Centro_lv_5.Nombre AS IMPRENT_CC_Level_5
				';
				$SIS_join = '
				LEFT JOIN `centrocosto_listado`          IVA_Centro             ON IVA_Centro.idCentroCosto        = sistema_leyes_fiscales.IVA_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  IVA_Centro_lv_1        ON IVA_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.IVA_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  IVA_Centro_lv_2        ON IVA_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.IVA_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  IVA_Centro_lv_3        ON IVA_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.IVA_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  IVA_Centro_lv_4        ON IVA_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.IVA_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  IVA_Centro_lv_5        ON IVA_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.IVA_idLevel_5
				LEFT JOIN `centrocosto_listado`          PPM_Centro             ON PPM_Centro.idCentroCosto        = sistema_leyes_fiscales.PPM_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  PPM_Centro_lv_1        ON PPM_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.PPM_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  PPM_Centro_lv_2        ON PPM_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.PPM_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  PPM_Centro_lv_3        ON PPM_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.PPM_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  PPM_Centro_lv_4        ON PPM_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.PPM_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  PPM_Centro_lv_5        ON PPM_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.PPM_idLevel_5
				LEFT JOIN `centrocosto_listado`          RET_Centro             ON RET_Centro.idCentroCosto        = sistema_leyes_fiscales.RET_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  RET_Centro_lv_1        ON RET_Centro_lv_1.idLevel_1       = sistema_leyes_fiscales.RET_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  RET_Centro_lv_2        ON RET_Centro_lv_2.idLevel_2       = sistema_leyes_fiscales.RET_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  RET_Centro_lv_3        ON RET_Centro_lv_3.idLevel_3       = sistema_leyes_fiscales.RET_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  RET_Centro_lv_4        ON RET_Centro_lv_4.idLevel_4       = sistema_leyes_fiscales.RET_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  RET_Centro_lv_5        ON RET_Centro_lv_5.idLevel_5       = sistema_leyes_fiscales.RET_idLevel_5
				LEFT JOIN `centrocosto_listado`          IMPRENT_Centro         ON IMPRENT_Centro.idCentroCosto    = sistema_leyes_fiscales.IMPRENT_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  IMPRENT_Centro_lv_1    ON IMPRENT_Centro_lv_1.idLevel_1   = sistema_leyes_fiscales.IMPRENT_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  IMPRENT_Centro_lv_2    ON IMPRENT_Centro_lv_2.idLevel_2   = sistema_leyes_fiscales.IMPRENT_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  IMPRENT_Centro_lv_3    ON IMPRENT_Centro_lv_3.idLevel_3   = sistema_leyes_fiscales.IMPRENT_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  IMPRENT_Centro_lv_4    ON IMPRENT_Centro_lv_4.idLevel_4   = sistema_leyes_fiscales.IMPRENT_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  IMPRENT_Centro_lv_5    ON IMPRENT_Centro_lv_5.idLevel_5   = sistema_leyes_fiscales.IMPRENT_idLevel_5
				';
				$rowPPM   = db_select_data (false, $SIS_query, 'sistema_leyes_fiscales', $SIS_join, 'sistema_leyes_fiscales.idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				if(isset($rowPPM['Porcentaje_PPM'])&&$rowPPM['Porcentaje_PPM']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']      = $rowPPM['Porcentaje_PPM'];
				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']      = 0;
				}

				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idCentroCosto']      = $rowPPM['IVA_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_1']          = $rowPPM['IVA_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_2']          = $rowPPM['IVA_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_3']          = $rowPPM['IVA_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_4']          = $rowPPM['IVA_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_5']          = $rowPPM['IVA_idLevel_5'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idCentroCosto']      = $rowPPM['PPM_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_1']          = $rowPPM['PPM_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_2']          = $rowPPM['PPM_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_3']          = $rowPPM['PPM_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_4']          = $rowPPM['PPM_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_5']          = $rowPPM['PPM_idLevel_5'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idCentroCosto']      = $rowPPM['RET_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_1']          = $rowPPM['RET_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_2']          = $rowPPM['RET_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_3']          = $rowPPM['RET_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_4']          = $rowPPM['RET_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_5']          = $rowPPM['RET_idLevel_5'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idCentroCosto']  = $rowPPM['IMPRENT_idCentroCosto'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_1']      = $rowPPM['IMPRENT_idLevel_1'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_2']      = $rowPPM['IMPRENT_idLevel_2'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_3']      = $rowPPM['IMPRENT_idLevel_3'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_4']      = $rowPPM['IMPRENT_idLevel_4'];
				$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_5']      = $rowPPM['IMPRENT_idLevel_5'];

				if(isset($rowPPM['IVA_CC_Nombre'])&&$rowPPM['IVA_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] = $rowPPM['IVA_CC_Nombre'];
					if(isset($rowPPM['IVA_CC_Level_1'])&&$rowPPM['IVA_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_1'];}
					if(isset($rowPPM['IVA_CC_Level_2'])&&$rowPPM['IVA_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_2'];}
					if(isset($rowPPM['IVA_CC_Level_3'])&&$rowPPM['IVA_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_3'];}
					if(isset($rowPPM['IVA_CC_Level_4'])&&$rowPPM['IVA_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_4'];}
					if(isset($rowPPM['IVA_CC_Level_5'])&&$rowPPM['IVA_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] .= ' - '.$rowPPM['IVA_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC'] = '';
				}
				if(isset($rowPPM['PPM_CC_Nombre'])&&$rowPPM['PPM_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] = $rowPPM['PPM_CC_Nombre'];
					if(isset($rowPPM['PPM_CC_Level_1'])&&$rowPPM['PPM_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_1'];}
					if(isset($rowPPM['PPM_CC_Level_2'])&&$rowPPM['PPM_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_2'];}
					if(isset($rowPPM['PPM_CC_Level_3'])&&$rowPPM['PPM_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_3'];}
					if(isset($rowPPM['PPM_CC_Level_4'])&&$rowPPM['PPM_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_4'];}
					if(isset($rowPPM['PPM_CC_Level_5'])&&$rowPPM['PPM_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] .= ' - '.$rowPPM['PPM_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC'] = '';
				}
				if(isset($rowPPM['RET_CC_Nombre'])&&$rowPPM['RET_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] = $rowPPM['RET_CC_Nombre'];
					if(isset($rowPPM['RET_CC_Level_1'])&&$rowPPM['RET_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_1'];}
					if(isset($rowPPM['RET_CC_Level_2'])&&$rowPPM['RET_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_2'];}
					if(isset($rowPPM['RET_CC_Level_3'])&&$rowPPM['RET_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_3'];}
					if(isset($rowPPM['RET_CC_Level_4'])&&$rowPPM['RET_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_4'];}
					if(isset($rowPPM['RET_CC_Level_5'])&&$rowPPM['RET_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] .= ' - '.$rowPPM['RET_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['RET_CC'] = '';
				}
				if(isset($rowPPM['IMPRENT_CC_Nombre'])&&$rowPPM['IMPRENT_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] = $rowPPM['IMPRENT_CC_Nombre'];
					if(isset($rowPPM['IMPRENT_CC_Level_1'])&&$rowPPM['IMPRENT_CC_Level_1']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_1'];}
					if(isset($rowPPM['IMPRENT_CC_Level_2'])&&$rowPPM['IMPRENT_CC_Level_2']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_2'];}
					if(isset($rowPPM['IMPRENT_CC_Level_3'])&&$rowPPM['IMPRENT_CC_Level_3']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_3'];}
					if(isset($rowPPM['IMPRENT_CC_Level_4'])&&$rowPPM['IMPRENT_CC_Level_4']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_4'];}
					if(isset($rowPPM['IMPRENT_CC_Level_5'])&&$rowPPM['IMPRENT_CC_Level_5']!=''){$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] .= ' - '.$rowPPM['IMPRENT_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC'] = '';
				}

				/****************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['pagos_leyes_fiscales_basicos']['Usuario']  = $rowUsuario['Nombre'];
				}else{
					$_SESSION['pagos_leyes_fiscales_basicos']['Usuario']  = '';
				}

				/****************************************************/
				//Solo compras pagadas totalmente
				$z1 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z2 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z3 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z4 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
				$z5 = "idFactFiscal=0";   //solo las emitidas por los empleados
				$z6 = "idFactFiscal=0";   //solo las que no esten asignadas

				//Filtro Fecha
				if(isset($Periodo_Ano)&&$Periodo_Ano!=''){
					$z1.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z2.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z3.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z4.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z5.=" AND Creacion_ano='".$Periodo_Ano."'";
					$z6.=" AND Creacion_ano='".$Periodo_Ano."'";
				}
				if(isset($Periodo_Mes)&&$Periodo_Mes!=''){
					$z1.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z2.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z3.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z4.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z5.=" AND Creacion_mes='".$Periodo_Mes."'";
					$z6.=" AND Creacion_mes='".$Periodo_Mes."'";
				}
				if(isset($idSistema)&&$idSistema!=''){
					$z1.=" AND idSistema='".$idSistema."'";
					$z2.=" AND idSistema='".$idSistema."'";
					$z3.=" AND idSistema='".$idSistema."'";
					$z4.=" AND idSistema='".$idSistema."'";
					$z5.=" AND idSistema='".$idSistema."'";
					$z6.=" AND idSistema='".$idSistema."'";
				}
				//agrupaciones
				$z1.=" GROUP BY idTipo";
				$z2.=" GROUP BY idTipo";
				$z3.=" GROUP BY idTipo";
				$z4.=" GROUP BY idTipo";
				$z5.=" GROUP BY idTipo";
				$z6.=" GROUP BY idSistema";
				/*************************************************************************************************/
				//filtro
				$SIS_query1 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query2 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query3 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query4 = 'idTipo, SUM(ValorNetoImp) AS ValorNeto, SUM(Impuesto_01) AS IVA';
				$SIS_query5 = 'idTipo, SUM(Impuesto) AS Retencion';
				$SIS_query6 = 'idSistema, SUM(ImpuestoRenta) AS ImpuestoRenta';
				//Bodega de Arriendos
				$arrTemporal_1 = array();
				$arrTemporal_1 = db_select_array (false, $SIS_query1, 'bodegas_arriendos_facturacion', '', $z1, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_1');
				//Bodega de Insumos
				$arrTemporal_2 = array();
				$arrTemporal_2 = db_select_array (false, $SIS_query2, 'bodegas_insumos_facturacion', '', $z2, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_2');
				//Bodega de Productos
				$arrTemporal_3 = array();
				$arrTemporal_3 = db_select_array (false, $SIS_query3, 'bodegas_productos_facturacion', '', $z3, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_3');
				//Bodega de Servicios
				$arrTemporal_4 = array();
				$arrTemporal_4 = db_select_array (false, $SIS_query4, 'bodegas_servicios_facturacion', '', $z4, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');
				//Boleta de honorarios
				$arrTemporal_5 = array();
				$arrTemporal_5 = db_select_array (false, $SIS_query5, 'boleta_honorarios_facturacion', '', $z5, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_5');
				//Liquidaciones de sueldo
				$arrTemporal_6 = array();
				$arrTemporal_6 = db_select_array (false, $SIS_query6, 'rrhh_sueldos_facturacion_trabajadores', '', $z6, 'idSistema ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_6');

				/*************************************************************************************************/
				//Creo los datos
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos']    = array();//arriendos
				$_SESSION['pagos_leyes_fiscales_pagos_insumos']      = array();//insumos
				$_SESSION['pagos_leyes_fiscales_pagos_productos']    = array();//productos
				$_SESSION['pagos_leyes_fiscales_pagos_servicios']    = array();//servicios
				$_SESSION['pagos_leyes_fiscales_pagos_retenciones']  = array();//boletas de honorarios
				$_SESSION['pagos_leyes_fiscales_pagos_trabajadores'] = array();//liquidaciones de sueldo
				$_SESSION['pagos_leyes_fiscales_formas_pago']        = array();//Formas de pago

				//reseteo a  0
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago']           = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['IVA']                       = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['IVA']                       = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['ValorNeto']                 = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['ValorNeto']                 = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo']            = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago']             = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia']            = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo']                 = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago']                  = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia']            = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago']           = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['IVA']                     = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['ValorNeto']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago']           = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo']               = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia']          = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion']                = 0;
				$_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta']           = 0;

				/********************************************/
				//recorro los arriendos
				if($arrTemporal_1!=false && !empty($arrTemporal_1) && $arrTemporal_1!=''){
					foreach ($arrTemporal_1 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los insumos
				if($arrTemporal_2!=false && !empty($arrTemporal_2) && $arrTemporal_2!=''){
					foreach ($arrTemporal_2 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los productos
				if($arrTemporal_3!=false && !empty($arrTemporal_3) && $arrTemporal_3!=''){
					foreach ($arrTemporal_3 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_productos'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los servicios
				if($arrTemporal_4!=false && !empty($arrTemporal_4) && $arrTemporal_4!=''){
					foreach ($arrTemporal_4 as $trab) {
						//se busca el tipo
						switch ($trab['idTipo']) {
							case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Venta
							case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Cliente
							case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Cliente
							case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Compra
							case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];    $IVA = $trab['IVA'];     break; //Nota Debito Proveedor
							case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1; $IVA = $trab['IVA']*-1;  break; //Nota Credito Proveedor
						}
						//se guarda el neto
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['ValorNeto'] = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['ValorNeto'] + $ValorNeto;
						//se guarda el iva
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['IVA'] = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][$x_idTipo]['IVA'] + $IVA;
					}
				}
				/********************************************/
				//recorro los boletas de honorarios
				if($arrTemporal_5!=false && !empty($arrTemporal_5) && $arrTemporal_5!=''){
					foreach ($arrTemporal_5 as $trab) {
						$_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion'] = $_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion'] + $trab['Retencion'];
					}
				}
				//recorro los boletas de honorarios
				if($arrTemporal_6!=false && !empty($arrTemporal_6) && $arrTemporal_6!=''){
					foreach ($arrTemporal_6 as $trab) {
						$_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta'] = $_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta'] + $trab['ImpuestoRenta'];
					}
				}

				/********************************************/
				//Calculos del IVA
				$TotalSaldo_1 = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['IVA'] - $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['IVA'];
				$TotalSaldo_2 = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['IVA']   - $_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['IVA'];
				$TotalSaldo_3 = $_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['IVA'] - $_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['IVA'];
				$TotalSaldo_4 = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['IVA'] - $_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['IVA'];
				//se guardan los datos
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo']    = $TotalSaldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo']      = $TotalSaldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo']    = $TotalSaldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo']    = $TotalSaldo_4;
				//guardo la diferencia
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia']    = $TotalSaldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia']      = $TotalSaldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia']    = $TotalSaldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia']    = $TotalSaldo_4;

				/********************************************/
				//Calculos totales de IVA
				$TotalSaldo = 0;
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo'];

				$MontoPago = 0;
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago'];

				$Diferencia = 0;
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia'];

				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_TotalSaldo'] = $TotalSaldo;
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago']  = $MontoPago;
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia'] = $Diferencia;

				/********************************************/
				//Calculos de PPM
				$PPM_Saldo_1  = ($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				$PPM_Saldo_2  = ($_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				$PPM_Saldo_3  = ($_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				$PPM_Saldo_4  = ($_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['ValorNeto']/100)*$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM'];
				//se guardan los datos
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo']  = $PPM_Saldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo']    = $PPM_Saldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo']  = $PPM_Saldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo']  = $PPM_Saldo_4;
				//guardo la diferencia
				$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia']  = $PPM_Saldo_1;
				$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia']    = $PPM_Saldo_2;
				$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia']  = $PPM_Saldo_3;
				$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia']  = $PPM_Saldo_4;

				//Calculo totales PPM
				$TotalSaldo = 0;
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo'];

				$MontoPago = 0;
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago'];

				$Diferencia = 0;
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia'];

				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo']      = $TotalSaldo;
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago']       = $MontoPago;
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Diferencia'] = $Diferencia;

				/********************************************/
				//Calculo Retencion
				$_SESSION['pagos_leyes_fiscales_basicos']['Retencion'] = $_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion'];

				/********************************************/
				//Calculo Impuesto a la renta
				$_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'] = $_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta'];

				/********************************************/
				//Calculo de totales generales
				$_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Actual']  = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia'];
				$_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']       = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago'] + $_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago'] + $_SESSION['pagos_leyes_fiscales_basicos']['Retencion'] + $_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'];

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;

/*******************************************************************************************************************/
		case 'edit_monto_pago_iva':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//Defino donde verificar
			switch ($edit_iva) {
				//Arriendo
				case 1:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo'];
					break;
				//Insumo
				case 2:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo'];
					break;
				//Producto
				case 3:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo'];
					break;
				//Servicio
				case 4:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo'];
					break;
				}
			//generacion de errores
			if(valores_comparables($IVA_MontoPago) > valores_comparables($max_m)){$error['ndata_1'] = 'error/Estas tratando de pagar mas de lo permitido (Maximo: '.valores($max_m, 0).')';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Defino donde modificar
				switch ($edit_iva) {
					//Arriendo
					case 1:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago'] = $IVA_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo'] - $IVA_MontoPago;
						break;
					//Insumo
					case 2:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago'] = $IVA_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo'] - $IVA_MontoPago;

						break;
					//Producto
					case 3:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago'] = $IVA_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo'] - $IVA_MontoPago;

						break;
					//Servicio
					case 4:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago'] = $IVA_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo'] - $IVA_MontoPago;
						break;
				}

				/********************************************/
				//Calculos totales de IVA
				$TotalSaldo = 0;
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo'];

				$MontoPago = 0;
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago'];

				$Diferencia = 0;
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia'];

				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_TotalSaldo'] = $TotalSaldo;
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago']  = $MontoPago;
				$_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia'] = $Diferencia;

				/********************************************/
				//Calculo de totales generales
				$_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Actual']  = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia'];
				$_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']       = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago'] + $_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago'] + $_SESSION['pagos_leyes_fiscales_basicos']['Retencion'] + $_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'];

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;

/*******************************************************************************************************************/
		case 'edit_monto_pago_ppm':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//Defino donde verificar
			switch ($edit_ppm) {
				//Arriendo
				case 1:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo'];
					break;
				//Insumo
				case 2:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo'];
					break;
				//Producto
				case 3:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo'];
					break;
				//Servicio
				case 4:
					$max_m = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo'];
					break;
				}
			//generacion de errores
			if(valores_comparables($PPM_MontoPago) > valores_comparables($max_m)){$error['ndata_1'] = 'error/Estas tratando de pagar mas de lo permitido (Maximo: '.valores($max_m, 0).')';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Defino donde modificar
				switch ($edit_ppm) {
					//Arriendo
					case 1:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago'] = $PPM_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo'] - $PPM_MontoPago;
						break;
					//Insumo
					case 2:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago'] = $PPM_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo'] - $PPM_MontoPago;

						break;
					//Producto
					case 3:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago'] = $PPM_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo'] - $PPM_MontoPago;

						break;
					//Servicio
					case 4:
						//guardo el monto a pagar
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago'] = $PPM_MontoPago;
						//guardo la diferencia
						$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia'] = $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo'] - $PPM_MontoPago;
						break;
				}
				/********************************************/
				//Calculo totales PPM
				$TotalSaldo = 0;
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo'];
				$TotalSaldo = $TotalSaldo + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo'];

				$MontoPago = 0;
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago'];
				$MontoPago = $MontoPago + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago'];

				$Diferencia = 0;
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia'];
				$Diferencia = $Diferencia + $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia'];

				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo']      = $TotalSaldo;
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago']       = $MontoPago;
				$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Diferencia'] = $Diferencia;

				/********************************************/
				//Calculo de totales generales
				$_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Actual']  = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia'];
				$_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']       = $_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago'] + $_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago'] + $_SESSION['pagos_leyes_fiscales_basicos']['Retencion'] + $_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'];

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'new_file_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['pagos_leyes_fiscales_archivos'])){
				foreach ($_SESSION['pagos_leyes_fiscales_archivos'] as $key => $trabajos){
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
						$sufijo = 'pagos_leyes_fiscales_'.genera_password_unica().'_';

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
									$_SESSION['pagos_leyes_fiscales_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['pagos_leyes_fiscales_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['pagos_leyes_fiscales_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['pagos_leyes_fiscales_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['pagos_leyes_fiscales_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'pagos_listado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(isset($IVA_idDocPago)){      $ndata_1 = count($IVA_idDocPago);      }else{$ndata_1 = 0;}
			if(isset($PPM_idDocPago)){      $ndata_2 = count($PPM_idDocPago);      }else{$ndata_2 = 0;}
			if(isset($RET_idDocPago)){      $ndata_3 = count($RET_idDocPago);      }else{$ndata_3 = 0;}
			if(isset($IMPRENT_idDocPago)){  $ndata_4 = count($IMPRENT_idDocPago);  }else{$ndata_4 = 0;}

			if(count(array_filter($IVA_idDocPago))!=0 OR count(array_filter($PPM_idDocPago))!=0 OR count(array_filter($RET_idDocPago))!=0 OR count(array_filter($IMPRENT_idDocPago))!=0) {
				//Se trae un listado con los documentos de pago
				$arrDocPago = array();
				$arrDocPago = db_select_array (false, 'idDocPago, Nombre', 'sistema_documentos_pago', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrDoc = array();
				foreach ($arrDocPago as $prod) {
					$arrDoc[$prod['idDocPago']]['Nombre'] = $prod['Nombre'];
				}
			}else{
				$error['nPagos'] = 'error/No hay pagos asignados';
			}

			//Se validan los montos a pagar
			$Mont_tot_1 = 0;
			$Mont_tot_2 = 0;
			$Mont_tot_3 = 0;
			$Mont_tot_4 = 0;
			//sumo los montos
			if(count(array_filter($IVA_idDocPago))!=0){
				for($x = 0; $x < $ndata_1; $x++){
					$Mont_tot_1 = $Mont_tot_1 + $IVA_Monto[$x];
				}
			}
			if(count(array_filter($PPM_idDocPago))!=0){
				for($x = 0; $x < $ndata_2; $x++){
					$Mont_tot_2 = $Mont_tot_2 + $PPM_Monto[$x];
				}
			}
			if(count(array_filter($RET_idDocPago))!=0){
				for($x = 0; $x < $ndata_3; $x++){
					$Mont_tot_3 = $Mont_tot_3 + $RET_Monto[$x];
				}
			}
			if(count(array_filter($IMPRENT_idDocPago))!=0){
				for($x = 0; $x < $ndata_4; $x++){
					$Mont_tot_4 = $Mont_tot_4 + $IMPRENT_Monto[$x];
				}
			}
			//Valido las cantidades
			if(valores_comparables($_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago'])<valores_comparables($Mont_tot_1)){
				$error['nPagos1'] = 'error/El monto ingresado en el pago del IVA es superior al total a pagar ('.valores($_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago'], 0).'<'.valores($Mont_tot_1, 0).')';
			}
			if(valores_comparables($_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago'])<valores_comparables($Mont_tot_2)){
				$error['nPagos2'] = 'error/El monto ingresado en el pago del PPM es superior al total a pagar ('.valores($_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago'], 0).'<'.valores($Mont_tot_2, 0).')';
			}
			if(valores_comparables($_SESSION['pagos_leyes_fiscales_basicos']['Retencion'])<valores_comparables($Mont_tot_3)){
				$error['nPagos3'] = 'error/El monto ingresado en el pago de la Retencion es superior al total a pagar ('.valores($_SESSION['pagos_leyes_fiscales_basicos']['Retencion'], 0).'<'.valores($Mont_tot_3, 0).')';
			}
			if(valores_comparables($_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'])<valores_comparables($Mont_tot_4)){
				$error['nPagos4'] = 'error/El monto ingresado en el pago del Impuesto a la Renta es superior al total a pagar ('.valores($_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta'], 0).'<'.valores($Mont_tot_4, 0).')';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//vacio variable
				unset($_SESSION['pagos_leyes_fiscales_formas_pago']);

				//Declaro arreglo
				$_SESSION['pagos_leyes_fiscales_formas_pago'] = array();

				//se recorren los pagos
				if($ndata_1!=0){
					for($x = 0; $x < $ndata_1; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($IVA_N_DocPago[$x])&&$IVA_N_DocPago[$x]!=''){$N_doc_p = $IVA_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						$_SESSION['pagos_leyes_fiscales_formas_pago'][1][$x]['idDocPago'] = $IVA_idDocPago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][1][$x]['N_DocPago'] = $N_doc_p;
						$_SESSION['pagos_leyes_fiscales_formas_pago'][1][$x]['F_Pago']    = $IVA_F_Pago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][1][$x]['Monto']     = $IVA_Monto[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][1][$x]['DocPago']   = $arrDoc[$IVA_idDocPago[$x]]['Nombre'];
					}
				}
				if($ndata_2!=0){
					for($x = 0; $x < $ndata_2; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($PPM_N_DocPago[$x])&&$PPM_N_DocPago[$x]!=''){$N_doc_p = $PPM_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						$_SESSION['pagos_leyes_fiscales_formas_pago'][2][$x]['idDocPago'] = $PPM_idDocPago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][2][$x]['N_DocPago'] = $N_doc_p;
						$_SESSION['pagos_leyes_fiscales_formas_pago'][2][$x]['F_Pago']    = $PPM_F_Pago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][2][$x]['Monto']     = $PPM_Monto[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][2][$x]['DocPago']   = $arrDoc[$PPM_idDocPago[$x]]['Nombre'];
					}
				}
				if($ndata_3!=0){
					for($x = 0; $x < $ndata_3; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($RET_N_DocPago[$x])&&$RET_N_DocPago[$x]!=''){$N_doc_p = $RET_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						$_SESSION['pagos_leyes_fiscales_formas_pago'][3][$x]['idDocPago'] = $RET_idDocPago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][3][$x]['N_DocPago'] = $N_doc_p;
						$_SESSION['pagos_leyes_fiscales_formas_pago'][3][$x]['F_Pago']    = $RET_F_Pago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][3][$x]['Monto']     = $RET_Monto[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][3][$x]['DocPago']   = $arrDoc[$RET_idDocPago[$x]]['Nombre'];
					}
				}
				if($ndata_4!=0){
					for($x = 0; $x < $ndata_4; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($IMPRENT_N_DocPago[$x])&&$IMPRENT_N_DocPago[$x]!=''){$N_doc_p = $IMPRENT_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						$_SESSION['pagos_leyes_fiscales_formas_pago'][4][$x]['idDocPago'] = $IMPRENT_idDocPago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][4][$x]['N_DocPago'] = $N_doc_p;
						$_SESSION['pagos_leyes_fiscales_formas_pago'][4][$x]['F_Pago']    = $IMPRENT_F_Pago[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][4][$x]['Monto']     = $IMPRENT_Monto[$x];
						$_SESSION['pagos_leyes_fiscales_formas_pago'][4][$x]['DocPago']   = $arrDoc[$IMPRENT_idDocPago[$x]]['Nombre'];
					}
				}

				//Actualizo el monto pagado
				$_SESSION['pagos_leyes_fiscales_basicos']['TotalPagoGeneral']  = $Mont_tot_1 + $Mont_tot_2 + $Mont_tot_3 + $Mont_tot_4;

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'PagoFiscal':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['pagos_leyes_fiscales_basicos'])){
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['idSistema']) OR $_SESSION['pagos_leyes_fiscales_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el id del sistema';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']) OR $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']) OR $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']) OR $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']=='' ){       $error['Periodo_Ano']      = 'error/No ha ingresado el año del periodo de pago';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']) OR $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']=='' ){       $error['Periodo_Mes']      = 'error/No ha ingresado el mes del periodo de pago';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']) OR $_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']=='' ){         $error['Pago_fecha']       = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']) OR $_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']) OR $_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']=='' ){ $error['Porcentaje_PPM']   = 'error/No ha ingresado el porcentaje PPM utilizado';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC']) OR $_SESSION['pagos_leyes_fiscales_basicos']['IVA_CC']=='' ){                 $error['IVA_CC']           = 'error/No ha ingresado el Centro de Costo IVA utilizado';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC']) OR $_SESSION['pagos_leyes_fiscales_basicos']['PPM_CC']=='' ){                 $error['PPM_CC']           = 'error/No ha ingresado el Centro de Costo PPM utilizado';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['RET_CC']) OR $_SESSION['pagos_leyes_fiscales_basicos']['RET_CC']=='' ){                 $error['RET_CC']           = 'error/No ha ingresado el Centro de Costo Retenciones utilizado';}
				if(!isset($_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC']) OR $_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_CC']=='' ){         $error['IMPRENT_CC']       = 'error/No ha ingresado el Centro de Costo Impuesto a la Renta utilizado';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al pago';
			}

			//Se revisa si hay ventas y el PPM esta en 0
			if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo'])&&$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo']!=0){
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago'])&&$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago']==0){
					$error['basicos'] = 'error/No tiene asignado un pago PPM';
				}
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Verifico si queda pagado
				if(valores_comparables($_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral'])==valores_comparables($_SESSION['pagos_leyes_fiscales_basicos']['TotalPagoGeneral'])){
					$idEstadoPago = 2;//Pagado
				}else{
					$idEstadoPago = 1;//No Pagado
				}

				//Se guardan los datos basicos
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['idSistema']) && $_SESSION['pagos_leyes_fiscales_basicos']['idSistema']!=''){                    $SIS_data  = "'".$_SESSION['pagos_leyes_fiscales_basicos']['idSistema']."'";              }else{$SIS_data  = "''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']!=''){                    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']!=''){                  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']) && $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']!=''){                $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']) && $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']!=''){                $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']) && $_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['pagos_leyes_fiscales_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']) && $_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Observaciones']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']) && $_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']!=''){                 $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Porcentaje_PPM']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior']) && $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior']!=''){       $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Anterior']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Actual']) && $_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Actual']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Saldos_IVA_Actual']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_TotalSaldo']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_TotalSaldo']!=''){                 $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_TotalSaldo']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_MontoPago']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia']!=''){                 $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_Diferencia']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo']!=''){                           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Saldo']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago']!=''){                             $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Pago']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_Diferencia']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_Diferencia']!=''){                 $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_Diferencia']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Retencion']) && $_SESSION['pagos_leyes_fiscales_basicos']['Retencion']!=''){                           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['Retencion']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta']) && $_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['ImpuestoRenta']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']) && $_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']!=''){                     $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['TotalGeneral']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['TotalPagoGeneral']) && $_SESSION['pagos_leyes_fiscales_basicos']['TotalPagoGeneral']!=''){             $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['TotalPagoGeneral']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_idCentroCosto']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_idCentroCosto']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_1']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_1']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_2']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_2']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_3']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_3']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_4']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_4']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_5']) && $_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_5']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IVA_idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_idCentroCosto']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_idCentroCosto']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_1']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_1']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_2']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_2']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_3']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_3']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_4']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_4']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_5']) && $_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_5']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['PPM_idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['RET_idCentroCosto']) && $_SESSION['pagos_leyes_fiscales_basicos']['RET_idCentroCosto']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['RET_idCentroCosto']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_1']) && $_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_1']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_1']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_2']) && $_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_2']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_2']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_3']) && $_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_3']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_3']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_4']) && $_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_4']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_4']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_5']) && $_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_5']!=''){                   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['RET_idLevel_5']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idCentroCosto']) && $_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idCentroCosto']!=''){   $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idCentroCosto']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_1']) && $_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_1']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_1']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_2']) && $_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_2']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_2']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_3']) && $_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_3']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_3']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_4']) && $_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_4']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_4']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_5']) && $_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_5']!=''){           $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['IMPRENT_idLevel_5']."'";     }else{$SIS_data .= ",''";}
				$SIS_data .= ",'".$idEstadoPago."'";

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario,fecha_auto,Periodo_Ano,
				Periodo_Mes,Pago_fecha, Pago_Semana, Pago_mes, Pago_ano, Observaciones,Porcentaje_PPM,
				Saldos_IVA_Anterior,Saldos_IVA_Actual, IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,
				PPM_Saldo,PPM_Pago, PPM_Diferencia,Retencion, ImpuestoRenta, TotalGeneral, TotalPagoGeneral,
				IVA_idCentroCosto,IVA_idLevel_1,IVA_idLevel_2, IVA_idLevel_3,IVA_idLevel_4,IVA_idLevel_5,
				PPM_idCentroCosto,PPM_idLevel_1,PPM_idLevel_2, PPM_idLevel_3,PPM_idLevel_4,PPM_idLevel_5,
				RET_idCentroCosto,RET_idLevel_1,RET_idLevel_2, RET_idLevel_3,RET_idLevel_4,RET_idLevel_5,
				IMPRENT_idCentroCosto,IMPRENT_idLevel_1, IMPRENT_idLevel_2,IMPRENT_idLevel_3,
				IMPRENT_idLevel_4,IMPRENT_idLevel_5, idEstadoPago';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//ARRIENDOS
					if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                                          $SIS_data  = "'".$ultimo_id."'";                                                               }else{$SIS_data  = "''";}
					//IVA
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][1]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_TotalSaldo']."'";  }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_MontoPago']."'";   }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['IVA_Diferencia']."'";  }else{$SIS_data .= ",''";}
					//PPM
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['ValorNeto']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['ValorNeto']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][2]['ValorNeto']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Saldo']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago']!=''){              $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Pago']."'";        }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_arriendos'][3]['PPM_Diferencia']."'";  }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactFiscal, IVA_Compra, IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago, PPM_Diferencia';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_pagos_arriendos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//INSUMOS
					if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                                      $SIS_data  = "'".$ultimo_id."'";                                                             }else{$SIS_data  = "''";}
					//IVA
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][1]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_TotalSaldo']."'";  }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_MontoPago']."'";   }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['IVA_Diferencia']."'";  }else{$SIS_data .= ",''";}
					//PPM
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['ValorNeto']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['ValorNeto']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][2]['ValorNeto']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Saldo']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago']!=''){              $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Pago']."'";        }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_insumos'][3]['PPM_Diferencia']."'";  }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactFiscal, IVA_Compra, IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago, PPM_Diferencia';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_pagos_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//PRODUCTOS
					if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                                          $SIS_data  = "'".$ultimo_id."'";                                                               }else{$SIS_data  = "''";}
					//IVA
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][1]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_TotalSaldo']."'";  }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_MontoPago']."'";   }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['IVA_Diferencia']."'";  }else{$SIS_data .= ",''";}
					//PPM
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['ValorNeto']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['ValorNeto']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][2]['ValorNeto']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Saldo']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago']!=''){              $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Pago']."'";        }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_productos'][3]['PPM_Diferencia']."'";  }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactFiscal, IVA_Compra, IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago, PPM_Diferencia';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_pagos_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//SERVICIOS
					if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                                          $SIS_data  = "'".$ultimo_id."'";                                                               }else{$SIS_data  = "''";}
					//IVA
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][1]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['IVA']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['IVA']!=''){                        $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['IVA']."'";             }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_TotalSaldo']."'";  }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_MontoPago']."'";   }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['IVA_Diferencia']."'";  }else{$SIS_data .= ",''";}
					//PPM
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['ValorNeto']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['ValorNeto']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][2]['ValorNeto']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Saldo']."'";       }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago']!=''){              $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Pago']."'";        }else{$SIS_data .= ",''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia']) && $_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_servicios'][3]['PPM_Diferencia']."'";  }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactFiscal, IVA_Compra, IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago, PPM_Diferencia';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_pagos_servicios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//RETENCIONES
					if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                              $SIS_data  = "'".$ultimo_id."'";                                                          }else{$SIS_data  = "''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion']) && $_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_retenciones']['Retencion']."'";   }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactFiscal, Retencion';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_pagos_retenciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//IMPUESTO A LA RENTA
					if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                                        $SIS_data  = "'".$ultimo_id."'";                                                               }else{$SIS_data  = "''";}
					if(isset($_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta']) && $_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_pagos_trabajadores']['ImpuestoRenta']."'";   }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactFiscal, ImpuestoRenta';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_pagos_impuesto_renta', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//PAGOS
					if($_SESSION['pagos_leyes_fiscales_formas_pago']){

						/************************************/
						//IVA
						if(isset($_SESSION['pagos_leyes_fiscales_formas_pago'][1])){
							foreach ($_SESSION['pagos_leyes_fiscales_formas_pago'][1] as $key => $pago){
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                              $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
								if(isset($pago['idDocPago'])&&$pago['idDocPago']!=''){                                                                                $SIS_data .= ",'".$pago['idDocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){                                                                                $SIS_data .= ",'".$pago['N_DocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['F_Pago'])&&$pago['F_Pago']!=''){                                                                                      $SIS_data .= ",'".$pago['F_Pago']."'";                                           }else{$SIS_data .= ",''";}
								if(isset($pago['Monto'])&&$pago['Monto']!=''){                                                                                        $SIS_data .= ",'".$pago['Monto']."'";                                            }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
						/************************************/
						//PPM
						if(isset($_SESSION['pagos_leyes_fiscales_formas_pago'][2])){
							foreach ($_SESSION['pagos_leyes_fiscales_formas_pago'][2] as $key => $pago){
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                              $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
								if(isset($pago['idDocPago'])&&$pago['idDocPago']!=''){                                                                                $SIS_data .= ",'".$pago['idDocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){                                                                                $SIS_data .= ",'".$pago['N_DocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['F_Pago'])&&$pago['F_Pago']!=''){                                                                                      $SIS_data .= ",'".$pago['F_Pago']."'";                                           }else{$SIS_data .= ",''";}
								if(isset($pago['Monto'])&&$pago['Monto']!=''){                                                                                        $SIS_data .= ",'".$pago['Monto']."'";                                            }else{$SIS_data .= ",''";}
								$SIS_data .= ",'2'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
						/************************************/
						//Retenciones
						if(isset($_SESSION['pagos_leyes_fiscales_formas_pago'][3])){
							foreach ($_SESSION['pagos_leyes_fiscales_formas_pago'][3] as $key => $pago){
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                              $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
								if(isset($pago['idDocPago'])&&$pago['idDocPago']!=''){                                                                                $SIS_data .= ",'".$pago['idDocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){                                                                                $SIS_data .= ",'".$pago['N_DocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['F_Pago'])&&$pago['F_Pago']!=''){                                                                                      $SIS_data .= ",'".$pago['F_Pago']."'";                                           }else{$SIS_data .= ",''";}
								if(isset($pago['Monto'])&&$pago['Monto']!=''){                                                                                        $SIS_data .= ",'".$pago['Monto']."'";                                            }else{$SIS_data .= ",''";}
								$SIS_data .= ",'3'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
						/************************************/
						//Impuesto a la renta
						if(isset($_SESSION['pagos_leyes_fiscales_formas_pago'][4])){
							foreach ($_SESSION['pagos_leyes_fiscales_formas_pago'][4] as $key => $pago){
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                              $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
								if(isset($pago['idDocPago'])&&$pago['idDocPago']!=''){                                                                                $SIS_data .= ",'".$pago['idDocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){                                                                                $SIS_data .= ",'".$pago['N_DocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['F_Pago'])&&$pago['F_Pago']!=''){                                                                                      $SIS_data .= ",'".$pago['F_Pago']."'";                                           }else{$SIS_data .= ",''";}
								if(isset($pago['Monto'])&&$pago['Monto']!=''){                                                                                        $SIS_data .= ",'".$pago['Monto']."'";                                            }else{$SIS_data .= ",''";}
								$SIS_data .= ",'4'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['pagos_leyes_fiscales_archivos'])){
						foreach ($_SESSION['pagos_leyes_fiscales_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                      $SIS_data  = "'".$ultimo_id."'";               }else{$SIS_data  = "''";}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFactFiscal, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']!=''){
						$SIS_data .= ",'".$_SESSION['pagos_leyes_fiscales_basicos']['fecha_auto']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactFiscal, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Se actualizan los registros usados para no volver a utilizarlos

					/****************************************************/
					if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']) && $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano']!=''){   $Periodo_Ano = $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Ano'];  }else{$Periodo_Ano = '';}
					if(isset($_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']) && $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes']!=''){   $Periodo_Mes = $_SESSION['pagos_leyes_fiscales_basicos']['Periodo_Mes'];  }else{$Periodo_Mes = '';}

					/*if(isset($Periodo_Ano)&&$Periodo_Ano!=''&&isset($Periodo_Mes)&&$Periodo_Mes!=''){
						//Solo compras pagadas totalmente
						$z1 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
						$z2 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
						$z3 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
						$z4 = "idFactFiscal=0 AND (idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
						$z5 = "idFactFiscal=0";   //solo las emitidas por los empleados
						$z6 = "idFactFiscal=0";   //solo las que no esten asignadas

						$z1.=" AND Creacion_ano='".$Periodo_Ano."'";
						$z2.=" AND Creacion_ano='".$Periodo_Ano."'";
						$z3.=" AND Creacion_ano='".$Periodo_Ano."'";
						$z4.=" AND Creacion_ano='".$Periodo_Ano."'";
						$z5.=" AND Creacion_ano='".$Periodo_Ano."'";
						$z6.=" AND Creacion_ano='".$Periodo_Ano."'";

						$z1.=" AND Creacion_mes='".$Periodo_Mes."'";
						$z2.=" AND Creacion_mes='".$Periodo_Mes."'";
						$z3.=" AND Creacion_mes='".$Periodo_Mes."'";
						$z4.=" AND Creacion_mes='".$Periodo_Mes."'";
						$z5.=" AND Creacion_mes='".$Periodo_Mes."'";
						$z6.=" AND Creacion_mes='".$Periodo_Mes."'";

						//Actualizacion masiva de registros
						$SIS_data = 'idFactFiscal='.$ultimo_id;

						$resultado = db_update_data (false, $SIS_data, 'bodegas_arriendos_facturacion', $z1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$resultado = db_update_data (false, $SIS_data, 'bodegas_insumos_facturacion', $z2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$resultado = db_update_data (false, $SIS_data, 'bodegas_productos_facturacion', $z3, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$resultado = db_update_data (false, $SIS_data, 'bodegas_servicios_facturacion', $z4, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$resultado = db_update_data (false, $SIS_data, 'boleta_honorarios_facturacion', $z5, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$resultado = db_update_data (false, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores', $z6, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}*/

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['pagos_leyes_fiscales_basicos']);
					unset($_SESSION['pagos_leyes_fiscales_pagos_arriendos']);
					unset($_SESSION['pagos_leyes_fiscales_pagos_insumos']);
					unset($_SESSION['pagos_leyes_fiscales_pagos_productos']);
					unset($_SESSION['pagos_leyes_fiscales_pagos_servicios']);
					unset($_SESSION['pagos_leyes_fiscales_pagos_retenciones']);
					unset($_SESSION['pagos_leyes_fiscales_pagos_trabajadores']);
					unset($_SESSION['pagos_leyes_fiscales_formas_pago']);
					unset($_SESSION['pagos_leyes_fiscales_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'add_new_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(isset($IVA_idDocPago)){      $ndata_1 = count($IVA_idDocPago);      }else{$ndata_1 = 0;}
			if(isset($PPM_idDocPago)){      $ndata_2 = count($PPM_idDocPago);      }else{$ndata_2 = 0;}
			if(isset($RET_idDocPago)){      $ndata_3 = count($RET_idDocPago);      }else{$ndata_3 = 0;}
			if(isset($IMPRENT_idDocPago)){  $ndata_4 = count($IMPRENT_idDocPago);  }else{$ndata_4 = 0;}

			if($ndata_1!=0 OR $ndata_2!=0 OR $ndata_3!=0 OR $ndata_4!=0) {
				//Se trae un listado con los documentos de pago
				$arrDocPago = array();
				$arrDocPago = db_select_array (false, 'idDocPago, Nombre', 'sistema_documentos_pago', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrDoc = array();
				foreach ($arrDocPago as $prod) {
					$arrDoc[$prod['idDocPago']]['Nombre'] = $prod['Nombre'];
				}
			}else{
				$error['nPagos'] = 'error/No hay pagos asignados';
			}

			//Montos pagados
			$Mont_tot_1 = 0;
			$Mont_tot_2 = 0;
			$Mont_tot_3 = 0;
			$Mont_tot_4 = 0;
			//sumo los montos
			if($ndata_1!=0){
				for($x = 0; $x < $ndata_1; $x++){
					$Mont_tot_1 = $Mont_tot_1 + $IVA_Monto[$x];
				}
			}
			if($ndata_2!=0){
				for($x = 0; $x < $ndata_2; $x++){
					$Mont_tot_2 = $Mont_tot_2 + $PPM_Monto[$x];
				}
			}
			if($ndata_3!=0){
				for($x = 0; $x < $ndata_3; $x++){
					$Mont_tot_3 = $Mont_tot_3 + $RET_Monto[$x];
				}
			}
			if($ndata_4!=0){
				for($x = 0; $x < $ndata_4; $x++){
					$Mont_tot_4 = $Mont_tot_4 + $IMPRENT_Monto[$x];
				}
			}
			//Valido las cantidades
			if(isset($IVA_Total_deuda)&&valores_comparables($IVA_Total_deuda)<valores_comparables($Mont_tot_1)){
				$error['nPagos1'] = 'error/El monto ingresado en el pago del IVA es superior al total a pagar ('.valores($IVA_Total_deuda, 0).'<'.valores($Mont_tot_1, 0).')';
			}
			if(isset($PPM_Total_deuda)&&valores_comparables($PPM_Total_deuda)<valores_comparables($Mont_tot_2)){
				$error['nPagos2'] = 'error/El monto ingresado en el pago del PPM es superior al total a pagar ('.valores($PPM_Total_deuda, 0).'<'.valores($Mont_tot_2, 0).')';
			}
			if(isset($RET_Total_deuda)&&valores_comparables($RET_Total_deuda)<valores_comparables($Mont_tot_3)){
				$error['nPagos3'] = 'error/El monto ingresado en el pago de la Retencion es superior al total a pagar ('.valores($RET_Total_deuda, 0).'<'.valores($Mont_tot_3, 0).')';
			}
			if(isset($IMPRENT_Total_deuda)&&valores_comparables($IMPRENT_Total_deuda)<valores_comparables($Mont_tot_4)){
				$error['nPagos4'] = 'error/El monto ingresado en el pago del Impuesto a la Renta es superior al total a pagar ('.valores($IMPRENT_Total_deuda, 0).'<'.valores($Mont_tot_4, 0).')';
			}
			if(!isset($idFactFiscal) OR $idFactFiscal == ''){
				$error['idFactFiscal'] = 'error/No ha ingresado el pago a relacionar';
			}
			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se recorren los pagos
				if($ndata_1!=0){
					for($x = 0; $x < $ndata_1; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($IVA_N_DocPago[$x])&&$IVA_N_DocPago[$x]!=''){$N_doc_p = $IVA_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						if(isset($idFactFiscal) && $idFactFiscal!=''){           $SIS_data  = "'".$idFactFiscal."'";         }else{$SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $SIS_data .= ",'".$Creacion_fecha."'";      }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                 $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
						if(isset($IVA_idDocPago[$x])&&$IVA_idDocPago[$x]!=''){   $SIS_data .= ",'".$IVA_idDocPago[$x]."'";   }else{$SIS_data .= ",''";}
						if(isset($N_doc_p)&&$N_doc_p!=''){                       $SIS_data .= ",'".$N_doc_p."'";             }else{$SIS_data .= ",''";}
						if(isset($IVA_F_Pago[$x])&&$IVA_F_Pago[$x]!=''){         $SIS_data .= ",'".$IVA_F_Pago[$x]."'";      }else{$SIS_data .= ",''";}
						if(isset($IVA_Monto[$x])&&$IVA_Monto[$x]!=''){           $SIS_data .= ",'".$IVA_Monto[$x]."'";       }else{$SIS_data .= ",''";}
						$SIS_data .= ",'1'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Mensaje
						$s_men = 'Se ha hecho un pago de '.valores($IVA_Monto[$x], 0).' con '.$arrDoc[$IVA_idDocPago[$x]]['Nombre'].' N°'.$N_doc_p.' con fecha '.fecha_estandar($IVA_F_Pago[$x]);
						//Se guarda en historial la accion
						if(isset($idFactFiscal) && $idFactFiscal!=''){      $SIS_data  = "'".$idFactFiscal."'";     }else{ $SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",'".$Creacion_fecha."'";  }else{ $SIS_data .= ",''"; }
						$SIS_data .= ",'1'";               //Creacion Satisfactoria
						$SIS_data .= ",'".$s_men."'";      //Observacion
						$SIS_data .= ",'".$idUsuario."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}
				if($ndata_2!=0){
					for($x = 0; $x < $ndata_2; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($PPM_N_DocPago[$x])&&$PPM_N_DocPago[$x]!=''){$N_doc_p = $PPM_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						if(isset($idFactFiscal) && $idFactFiscal!=''){           $SIS_data  = "'".$idFactFiscal."'";         }else{$SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $SIS_data .= ",'".$Creacion_fecha."'";      }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                 $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
						if(isset($PPM_idDocPago[$x])&&$PPM_idDocPago[$x]!=''){   $SIS_data .= ",'".$PPM_idDocPago[$x]."'";   }else{$SIS_data .= ",''";}
						if(isset($N_doc_p)&&$N_doc_p!=''){                       $SIS_data .= ",'".$N_doc_p."'";             }else{$SIS_data .= ",''";}
						if(isset($PPM_F_Pago[$x])&&$PPM_F_Pago[$x]!=''){         $SIS_data .= ",'".$PPM_F_Pago[$x]."'";      }else{$SIS_data .= ",''";}
						if(isset($PPM_Monto[$x])&&$PPM_Monto[$x]!=''){           $SIS_data .= ",'".$PPM_Monto[$x]."'";       }else{$SIS_data .= ",''";}
						$SIS_data .= ",'2'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Mensaje
						$s_men = 'Se ha hecho un pago de '.valores($PPM_Monto[$x], 0).' con '.$arrDoc[$PPM_idDocPago[$x]]['Nombre'].' N°'.$N_doc_p.' con fecha '.fecha_estandar($PPM_F_Pago[$x]);
						//Se guarda en historial la accion
						if(isset($idFactFiscal) && $idFactFiscal!=''){      $SIS_data  = "'".$idFactFiscal."'";     }else{ $SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",'".$Creacion_fecha."'";  }else{ $SIS_data .= ",''"; }
						$SIS_data .= ",'1'";               //Creacion Satisfactoria
						$SIS_data .= ",'".$s_men."'";      //Observacion
						$SIS_data .= ",'".$idUsuario."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}
				if($ndata_3!=0){
					for($x = 0; $x < $ndata_3; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($RET_N_DocPago[$x])&&$RET_N_DocPago[$x]!=''){$N_doc_p = $RET_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						if(isset($idFactFiscal) && $idFactFiscal!=''){           $SIS_data  = "'".$idFactFiscal."'";         }else{$SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $SIS_data .= ",'".$Creacion_fecha."'";      }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                 $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
						if(isset($RET_idDocPago[$x])&&$RET_idDocPago[$x]!=''){   $SIS_data .= ",'".$RET_idDocPago[$x]."'";   }else{$SIS_data .= ",''";}
						if(isset($N_doc_p)&&$N_doc_p!=''){                       $SIS_data .= ",'".$N_doc_p."'";             }else{$SIS_data .= ",''";}
						if(isset($RET_F_Pago[$x])&&$RET_F_Pago[$x]!=''){         $SIS_data .= ",'".$RET_F_Pago[$x]."'";      }else{$SIS_data .= ",''";}
						if(isset($RET_Monto[$x])&&$RET_Monto[$x]!=''){           $SIS_data .= ",'".$RET_Monto[$x]."'";       }else{$SIS_data .= ",''";}
						$SIS_data .= ",'3'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Mensaje
						$s_men = 'Se ha hecho un pago de '.valores($RET_Monto[$x], 0).' con '.$arrDoc[$RET_idDocPago[$x]]['Nombre'].' N°'.$N_doc_p.' con fecha '.fecha_estandar($RET_F_Pago[$x]);
						//Se guarda en historial la accion
						if(isset($idFactFiscal) && $idFactFiscal!=''){      $SIS_data  = "'".$idFactFiscal."'";     }else{ $SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",'".$Creacion_fecha."'";  }else{ $SIS_data .= ",''"; }
						$SIS_data .= ",'1'";               //Creacion Satisfactoria
						$SIS_data .= ",'".$s_men."'";      //Observacion
						$SIS_data .= ",'".$idUsuario."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}
				if($ndata_4!=0){
					for($x = 0; $x < $ndata_4; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($IMPRENT_N_DocPago[$x])&&$IMPRENT_N_DocPago[$x]!=''){$N_doc_p = $IMPRENT_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						if(isset($idFactFiscal) && $idFactFiscal!=''){                   $SIS_data  = "'".$idFactFiscal."'";             }else{$SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){               $SIS_data .= ",'".$Creacion_fecha."'";          }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                         $SIS_data .= ",'".$idUsuario."'";               }else{$SIS_data .= ",''";}
						if(isset($IMPRENT_idDocPago[$x])&&$IMPRENT_idDocPago[$x]!=''){   $SIS_data .= ",'".$IMPRENT_idDocPago[$x]."'";   }else{$SIS_data .= ",''";}
						if(isset($N_doc_p)&&$N_doc_p!=''){                               $SIS_data .= ",'".$N_doc_p."'";                 }else{$SIS_data .= ",''";}
						if(isset($IMPRENT_F_Pago[$x])&&$IMPRENT_F_Pago[$x]!=''){         $SIS_data .= ",'".$IMPRENT_F_Pago[$x]."'";      }else{$SIS_data .= ",''";}
						if(isset($IMPRENT_Monto[$x])&&$IMPRENT_Monto[$x]!=''){           $SIS_data .= ",'".$IMPRENT_Monto[$x]."'";       }else{$SIS_data .= ",''";}
						$SIS_data .= ",'4'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Mensaje
						$s_men = 'Se ha hecho un pago de '.valores($IMPRENT_Monto[$x], 0).' con '.$arrDoc[$IMPRENT_idDocPago[$x]]['Nombre'].' N°'.$N_doc_p.' con fecha '.fecha_estandar($IMPRENT_F_Pago[$x]);
						//Se guarda en historial la accion
						if(isset($idFactFiscal) && $idFactFiscal!=''){      $SIS_data  = "'".$idFactFiscal."'";     }else{ $SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",'".$Creacion_fecha."'";  }else{ $SIS_data .= ",''"; }
						$SIS_data .= ",'1'";               //Creacion Satisfactoria
						$SIS_data .= ",'".$s_men."'";      //Observacion
						$SIS_data .= ",'".$idUsuario."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactFiscal, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_fiscales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}

				//Sumo todos los pagos y actualizo el monto
				$rowMonto = db_select_data (false, 'SUM(Monto) AS Pagado', 'pagos_leyes_fiscales_formas_pago', '', 'idFactFiscal = "'.$idFactFiscal.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData  = db_select_data (false, 'TotalGeneral', 'pagos_leyes_fiscales', '', 'idFactFiscal ='.$idFactFiscal, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$SIS_data = "TotalPagoGeneral='".$rowMonto['Pagado']."'";
				//Verifico si queda pagado
				if(valores_comparables($rowData['TotalGeneral'])==valores_comparables($rowMonto['Pagado'])){
					$SIS_data .= ",idEstadoPago='2'";//Pagado
				}else{
					$SIS_data .= ",idEstadoPago='1'";//No Pagado
				}

				$resultado = db_update_data (false, $SIS_data, 'pagos_leyes_fiscales', 'idFactFiscal = "'.$idFactFiscal.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
