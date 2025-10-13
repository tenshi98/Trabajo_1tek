<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-260).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFactSocial']))               $idFactSocial              = $_POST['idFactSocial'];
	if (!empty($_POST['idSistema']))                  $idSistema                 = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))                  $idUsuario                 = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))                 $fecha_auto                = $_POST['fecha_auto'];
	if (!empty($_POST['Periodo_Ano']))                $Periodo_Ano               = $_POST['Periodo_Ano'];
	if (!empty($_POST['Periodo_Mes']))                $Periodo_Mes               = $_POST['Periodo_Mes'];
	if (!empty($_POST['Pago_fecha']))                 $Pago_fecha                = $_POST['Pago_fecha'];
	if (!empty($_POST['Observaciones']))              $Observaciones             = $_POST['Observaciones'];

	if (!empty($_POST['AFP_idDocPago']))              $AFP_idDocPago             = $_POST['AFP_idDocPago'];
	if (!empty($_POST['AFP_N_DocPago']))              $AFP_N_DocPago             = $_POST['AFP_N_DocPago'];
	if (!empty($_POST['AFP_F_Pago']))                 $AFP_F_Pago                = $_POST['AFP_F_Pago'];
	if (!empty($_POST['AFP_Monto']))                  $AFP_Monto                 = $_POST['AFP_Monto'];

	if (!empty($_POST['SALUD_idDocPago']))            $SALUD_idDocPago           = $_POST['SALUD_idDocPago'];
	if (!empty($_POST['SALUD_N_DocPago']))            $SALUD_N_DocPago           = $_POST['SALUD_N_DocPago'];
	if (!empty($_POST['SALUD_F_Pago']))               $SALUD_F_Pago              = $_POST['SALUD_F_Pago'];
	if (!empty($_POST['SALUD_Monto']))                $SALUD_Monto               = $_POST['SALUD_Monto'];

	if (!empty($_POST['SEGURIDAD_idDocPago']))        $SEGURIDAD_idDocPago       = $_POST['SEGURIDAD_idDocPago'];
	if (!empty($_POST['SEGURIDAD_N_DocPago']))        $SEGURIDAD_N_DocPago       = $_POST['SEGURIDAD_N_DocPago'];
	if (!empty($_POST['SEGURIDAD_F_Pago']))           $SEGURIDAD_F_Pago          = $_POST['SEGURIDAD_F_Pago'];
	if (!empty($_POST['SEGURIDAD_Monto']))            $SEGURIDAD_Monto           = $_POST['SEGURIDAD_Monto'];

	if (!empty($_POST['AFP_Total_deuda']))            $AFP_Total_deuda           = $_POST['AFP_Total_deuda'];
	if (!empty($_POST['SALUD_Total_deuda']))          $SALUD_Total_deuda         = $_POST['SALUD_Total_deuda'];
	if (!empty($_POST['SEGURIDAD_Total_deuda']))      $SEGURIDAD_Total_deuda     = $_POST['SEGURIDAD_Total_deuda'];
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
			case 'idFactSocial':               if(empty($idFactSocial)){               $error['idFactSocial']                 = 'error/No ha seleccionado el id';}break;
			case 'idSistema':                  if(empty($idSistema)){                  $error['idSistema']                    = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':                  if(empty($idUsuario)){                  $error['idUsuario']                    = 'error/No ha seleccionado el usuario';}break;
			case 'fecha_auto':                 if(empty($fecha_auto)){                 $error['fecha_auto']                   = 'error/No ha ingresado la fecha';}break;
			case 'Periodo_Ano':                if(empty($Periodo_Ano)){                $error['Periodo_Ano']                  = 'error/No ha seleccionado el año';}break;
			case 'Periodo_Mes':                if(empty($Periodo_Mes)){                $error['Periodo_Mes']                  = 'error/No ha seleccionado el mes';}break;
			case 'Pago_fecha':                 if(empty($Pago_fecha)){                 $error['Pago_fecha']                   = 'error/No ha ingresado la fecha de pago';}break;
			case 'Observaciones':              if(empty($Observaciones)){              $error['Observaciones']                = 'error/No ha ingresado las observaciones';}break;

			case 'AFP_idDocPago':              if(empty($AFP_idDocPago)){              $error['AFP_idDocPago']                = 'error/No ha seleccionado el documento de pago';}break;
			case 'AFP_N_DocPago':              if(empty($AFP_N_DocPago)){              $error['AFP_N_DocPago']                = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'AFP_F_Pago':                 if(empty($AFP_F_Pago)){                 $error['AFP_F_Pago']                   = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'AFP_Monto':                  if(empty($AFP_Monto)){                  $error['AFP_Monto']                    = 'error/No ha ingresado el monto pagado';}break;

			case 'SALUD_idDocPago':            if(empty($SALUD_idDocPago)){            $error['SALUD_idDocPago']                = 'error/No ha seleccionado el documento de pago';}break;
			case 'SALUD_N_DocPago':            if(empty($SALUD_N_DocPago)){            $error['SALUD_N_DocPago']                = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'SALUD_F_Pago':               if(empty($SALUD_F_Pago)){               $error['SALUD_F_Pago']                   = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'SALUD_Monto':                if(empty($SALUD_Monto)){                $error['SALUD_Monto']                    = 'error/No ha ingresado el monto pagado';}break;

			case 'SEGURIDAD_idDocPago':        if(empty($SEGURIDAD_idDocPago)){        $error['SEGURIDAD_idDocPago']                = 'error/No ha seleccionado el documento de pago';}break;
			case 'SEGURIDAD_N_DocPago':        if(empty($SEGURIDAD_N_DocPago)){        $error['SEGURIDAD_N_DocPago']                = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'SEGURIDAD_F_Pago':           if(empty($SEGURIDAD_F_Pago)){           $error['SEGURIDAD_F_Pago']                   = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'SEGURIDAD_Monto':            if(empty($SEGURIDAD_Monto)){            $error['SEGURIDAD_Monto']                    = 'error/No ha ingresado el monto pagado';}break;

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
				unset($_SESSION['pagos_leyes_sociales_basicos']);
				unset($_SESSION['pagos_leyes_sociales_trabajadores']);
				unset($_SESSION['pagos_leyes_sociales_formas_pago']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['pagos_leyes_sociales_archivos'])){
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
				unset($_SESSION['pagos_leyes_sociales_archivos']);

				/****************************************************/
				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Periodo_Ano)&&$Periodo_Ano!=''){        $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']     = $Periodo_Ano;    }else{$_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']     = '';}
				if(isset($Periodo_Mes)&&$Periodo_Mes!=''){        $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']     = $Periodo_Mes;    }else{$_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']     = '';}
				if(isset($Pago_fecha)&&$Pago_fecha!=''){          $_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']      = $Pago_fecha;     }else{$_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']      = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['pagos_leyes_sociales_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['pagos_leyes_sociales_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['pagos_leyes_sociales_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['pagos_leyes_sociales_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['pagos_leyes_sociales_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['pagos_leyes_sociales_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']      = $fecha_auto;     }else{$_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']      = '';}

				$_SESSION['pagos_leyes_sociales_basicos']['TotalGeneral']      = 0;
				$_SESSION['pagos_leyes_sociales_basicos']['TotalPagoGeneral']  = 0;

				//Busco datos en la base de datos
				$SIS_query = '
				sistema_leyes_sociales.AFP_idCentroCosto,
				sistema_leyes_sociales.AFP_idLevel_1,
				sistema_leyes_sociales.AFP_idLevel_2,
				sistema_leyes_sociales.AFP_idLevel_3,
				sistema_leyes_sociales.AFP_idLevel_4,
				sistema_leyes_sociales.AFP_idLevel_5,
				sistema_leyes_sociales.SALUD_idCentroCosto,
				sistema_leyes_sociales.SALUD_idLevel_1,
				sistema_leyes_sociales.SALUD_idLevel_2,
				sistema_leyes_sociales.SALUD_idLevel_3,
				sistema_leyes_sociales.SALUD_idLevel_4,
				sistema_leyes_sociales.SALUD_idLevel_5,
				sistema_leyes_sociales.SEGURIDAD_idCentroCosto,
				sistema_leyes_sociales.SEGURIDAD_idLevel_1,
				sistema_leyes_sociales.SEGURIDAD_idLevel_2,
				sistema_leyes_sociales.SEGURIDAD_idLevel_3,
				sistema_leyes_sociales.SEGURIDAD_idLevel_4,
				sistema_leyes_sociales.SEGURIDAD_idLevel_5,
				AFP_Centro.Nombre AS AFP_CC_Nombre,
				AFP_Centro_lv_1.Nombre AS AFP_CC_Level_1,
				AFP_Centro_lv_2.Nombre AS AFP_CC_Level_2,
				AFP_Centro_lv_3.Nombre AS AFP_CC_Level_3,
				AFP_Centro_lv_4.Nombre AS AFP_CC_Level_4,
				AFP_Centro_lv_5.Nombre AS AFP_CC_Level_5,
				SALUD_Centro.Nombre AS SALUD_CC_Nombre,
				SALUD_Centro_lv_1.Nombre AS SALUD_CC_Level_1,
				SALUD_Centro_lv_2.Nombre AS SALUD_CC_Level_2,
				SALUD_Centro_lv_3.Nombre AS SALUD_CC_Level_3,
				SALUD_Centro_lv_4.Nombre AS SALUD_CC_Level_4,
				SALUD_Centro_lv_5.Nombre AS SALUD_CC_Level_5,
				SEGURIDAD_Centro.Nombre AS SEGURIDAD_CC_Nombre,
				SEGURIDAD_Centro_lv_1.Nombre AS SEGURIDAD_CC_Level_1,
				SEGURIDAD_Centro_lv_2.Nombre AS SEGURIDAD_CC_Level_2,
				SEGURIDAD_Centro_lv_3.Nombre AS SEGURIDAD_CC_Level_3,
				SEGURIDAD_Centro_lv_4.Nombre AS SEGURIDAD_CC_Level_4,
				SEGURIDAD_Centro_lv_5.Nombre AS SEGURIDAD_CC_Level_5
				';
				$SIS_join = '
				LEFT JOIN `centrocosto_listado`          AFP_Centro               ON AFP_Centro.idCentroCosto          = sistema_leyes_sociales.AFP_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  AFP_Centro_lv_1          ON AFP_Centro_lv_1.idLevel_1         = sistema_leyes_sociales.AFP_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  AFP_Centro_lv_2          ON AFP_Centro_lv_2.idLevel_2         = sistema_leyes_sociales.AFP_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  AFP_Centro_lv_3          ON AFP_Centro_lv_3.idLevel_3         = sistema_leyes_sociales.AFP_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  AFP_Centro_lv_4          ON AFP_Centro_lv_4.idLevel_4         = sistema_leyes_sociales.AFP_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  AFP_Centro_lv_5          ON AFP_Centro_lv_5.idLevel_5         = sistema_leyes_sociales.AFP_idLevel_5
				LEFT JOIN `centrocosto_listado`          SALUD_Centro             ON SALUD_Centro.idCentroCosto            = sistema_leyes_sociales.SALUD_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  SALUD_Centro_lv_1        ON SALUD_Centro_lv_1.idLevel_1           = sistema_leyes_sociales.SALUD_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  SALUD_Centro_lv_2        ON SALUD_Centro_lv_2.idLevel_2           = sistema_leyes_sociales.SALUD_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  SALUD_Centro_lv_3        ON SALUD_Centro_lv_3.idLevel_3           = sistema_leyes_sociales.SALUD_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  SALUD_Centro_lv_4        ON SALUD_Centro_lv_4.idLevel_4           = sistema_leyes_sociales.SALUD_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  SALUD_Centro_lv_5        ON SALUD_Centro_lv_5.idLevel_5           = sistema_leyes_sociales.SALUD_idLevel_5
				LEFT JOIN `centrocosto_listado`          SEGURIDAD_Centro         ON SEGURIDAD_Centro.idCentroCosto        = sistema_leyes_sociales.SEGURIDAD_idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`  SEGURIDAD_Centro_lv_1    ON SEGURIDAD_Centro_lv_1.idLevel_1       = sistema_leyes_sociales.SEGURIDAD_idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`  SEGURIDAD_Centro_lv_2    ON SEGURIDAD_Centro_lv_2.idLevel_2       = sistema_leyes_sociales.SEGURIDAD_idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`  SEGURIDAD_Centro_lv_3    ON SEGURIDAD_Centro_lv_3.idLevel_3       = sistema_leyes_sociales.SEGURIDAD_idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`  SEGURIDAD_Centro_lv_4    ON SEGURIDAD_Centro_lv_4.idLevel_4       = sistema_leyes_sociales.SEGURIDAD_idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`  SEGURIDAD_Centro_lv_5    ON SEGURIDAD_Centro_lv_5.idLevel_5       = sistema_leyes_sociales.SEGURIDAD_idLevel_5
				';
				$rowPPM   = db_select_data (false, $SIS_query, 'sistema_leyes_sociales', $SIS_join, 'sistema_leyes_sociales.idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$_SESSION['pagos_leyes_sociales_basicos']['AFP_idCentroCosto']          = $rowPPM['AFP_idCentroCosto'];
				$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_1']              = $rowPPM['AFP_idLevel_1'];
				$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_2']              = $rowPPM['AFP_idLevel_2'];
				$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_3']              = $rowPPM['AFP_idLevel_3'];
				$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_4']              = $rowPPM['AFP_idLevel_4'];
				$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_5']              = $rowPPM['AFP_idLevel_5'];
				$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idCentroCosto']        = $rowPPM['SALUD_idCentroCosto'];
				$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_1']            = $rowPPM['SALUD_idLevel_1'];
				$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_2']            = $rowPPM['SALUD_idLevel_2'];
				$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_3']            = $rowPPM['SALUD_idLevel_3'];
				$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_4']            = $rowPPM['SALUD_idLevel_4'];
				$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_5']            = $rowPPM['SALUD_idLevel_5'];
				$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idCentroCosto']    = $rowPPM['SEGURIDAD_idCentroCosto'];
				$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_1']        = $rowPPM['SEGURIDAD_idLevel_1'];
				$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_2']        = $rowPPM['SEGURIDAD_idLevel_2'];
				$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_3']        = $rowPPM['SEGURIDAD_idLevel_3'];
				$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_4']        = $rowPPM['SEGURIDAD_idLevel_4'];
				$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_5']        = $rowPPM['SEGURIDAD_idLevel_5'];

				if(isset($rowPPM['AFP_CC_Nombre'])&&$rowPPM['AFP_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_CC'] = $rowPPM['AFP_CC_Nombre'];
					if(isset($rowPPM['AFP_CC_Level_1'])&&$rowPPM['AFP_CC_Level_1']!=''){$_SESSION['pagos_leyes_sociales_basicos']['AFP_CC'] .= ' - '.$rowPPM['AFP_CC_Level_1'];}
					if(isset($rowPPM['AFP_CC_Level_2'])&&$rowPPM['AFP_CC_Level_2']!=''){$_SESSION['pagos_leyes_sociales_basicos']['AFP_CC'] .= ' - '.$rowPPM['AFP_CC_Level_2'];}
					if(isset($rowPPM['AFP_CC_Level_3'])&&$rowPPM['AFP_CC_Level_3']!=''){$_SESSION['pagos_leyes_sociales_basicos']['AFP_CC'] .= ' - '.$rowPPM['AFP_CC_Level_3'];}
					if(isset($rowPPM['AFP_CC_Level_4'])&&$rowPPM['AFP_CC_Level_4']!=''){$_SESSION['pagos_leyes_sociales_basicos']['AFP_CC'] .= ' - '.$rowPPM['AFP_CC_Level_4'];}
					if(isset($rowPPM['AFP_CC_Level_5'])&&$rowPPM['AFP_CC_Level_5']!=''){$_SESSION['pagos_leyes_sociales_basicos']['AFP_CC'] .= ' - '.$rowPPM['AFP_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_sociales_basicos']['AFP_CC'] = '';
				}
				if(isset($rowPPM['SALUD_CC_Nombre'])&&$rowPPM['SALUD_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC'] = $rowPPM['SALUD_CC_Nombre'];
					if(isset($rowPPM['SALUD_CC_Level_1'])&&$rowPPM['SALUD_CC_Level_1']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC'] .= ' - '.$rowPPM['SALUD_CC_Level_1'];}
					if(isset($rowPPM['SALUD_CC_Level_2'])&&$rowPPM['SALUD_CC_Level_2']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC'] .= ' - '.$rowPPM['SALUD_CC_Level_2'];}
					if(isset($rowPPM['SALUD_CC_Level_3'])&&$rowPPM['SALUD_CC_Level_3']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC'] .= ' - '.$rowPPM['SALUD_CC_Level_3'];}
					if(isset($rowPPM['SALUD_CC_Level_4'])&&$rowPPM['SALUD_CC_Level_4']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC'] .= ' - '.$rowPPM['SALUD_CC_Level_4'];}
					if(isset($rowPPM['SALUD_CC_Level_5'])&&$rowPPM['SALUD_CC_Level_5']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC'] .= ' - '.$rowPPM['SALUD_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC'] = '';
				}
				if(isset($rowPPM['SEGURIDAD_CC_Nombre'])&&$rowPPM['SEGURIDAD_CC_Nombre']!=''){
					$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC'] = $rowPPM['SEGURIDAD_CC_Nombre'];
					if(isset($rowPPM['SEGURIDAD_CC_Level_1'])&&$rowPPM['SEGURIDAD_CC_Level_1']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC'] .= ' - '.$rowPPM['SEGURIDAD_CC_Level_1'];}
					if(isset($rowPPM['SEGURIDAD_CC_Level_2'])&&$rowPPM['SEGURIDAD_CC_Level_2']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC'] .= ' - '.$rowPPM['SEGURIDAD_CC_Level_2'];}
					if(isset($rowPPM['SEGURIDAD_CC_Level_3'])&&$rowPPM['SEGURIDAD_CC_Level_3']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC'] .= ' - '.$rowPPM['SEGURIDAD_CC_Level_3'];}
					if(isset($rowPPM['SEGURIDAD_CC_Level_4'])&&$rowPPM['SEGURIDAD_CC_Level_4']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC'] .= ' - '.$rowPPM['SEGURIDAD_CC_Level_4'];}
					if(isset($rowPPM['SEGURIDAD_CC_Level_5'])&&$rowPPM['SEGURIDAD_CC_Level_5']!=''){$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC'] .= ' - '.$rowPPM['SEGURIDAD_CC_Level_5'];}

				}else{
					$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC'] = '';
				}

				/****************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['pagos_leyes_sociales_basicos']['Usuario']  = $rowUsuario['Nombre'];
				}else{
					$_SESSION['pagos_leyes_sociales_basicos']['Usuario']  = '';
				}

				/****************************************************/
				//Solo compras pagadas totalmente
				$z = "idFactSocial=0";   //solo las que no esten asignadas

				//Filtro Fecha
				if(isset($Periodo_Ano)&&$Periodo_Ano!=''){ $z.=" AND Creacion_ano='".$Periodo_Ano."'"; }
				if(isset($Periodo_Mes)&&$Periodo_Mes!=''){ $z.=" AND Creacion_mes='".$Periodo_Mes."'"; }
				if(isset($idSistema)&&$idSistema!=''){     $z.=" AND idSistema='".$idSistema."'"; }
				/*************************************************************************************************/
				//filtro
				$SIS_query = '
				idFactTrab,
				idFactTrab AS ID,
				TrabajadorNombre,
				TrabajadorRut,
				SueldoImponible AS Sueldo,

				AFP_Nombre AS AFP_Nombre,
				AFP_Porcentaje AS AFP_Porcentaje,
				AFP_Total AS AFP_Cotizacion,
				AFP_SIS AS AFP_SeguroInvalidez,
				(SELECT SUM(DescuentoMonto) AS Tot FROM `rrhh_sueldos_facturacion_trabajadores_descuentofijo`  WHERE idFactTrab = ID AND idDescuentoFijo = 1) AS AFP_APV,
				(SELECT SUM(DescuentoMonto) AS Tot FROM `rrhh_sueldos_facturacion_trabajadores_descuentofijo`  WHERE idFactTrab = ID AND idDescuentoFijo = 2) AS AFP_Cuenta2,
				TrabajoPesado AS AFP_TrabajoPesado,
				SegCesantia_Empleador AS AFC_Empleador,
				SegCesantia_Trabajador AS AFC_Trabajador,

				Salud_Nombre AS Salud_Nombre,
				Salud_Porcentaje AS Salud_Porcentaje,
				Salud_Total AS Salud_Cotizacion,
				Salud_idCotizacion AS Salud_Extra_Salud_id,
				Salud_CotizacionPorcentaje AS Salud_Extra_Porcentaje,
				Salud_CotizacionValor AS Salud_Extra_Valor,

				MutualNombre AS MutualNombre,
				MutualPorcentaje AS MutualPorcentaje,
				MutualValor AS MutualValor
				';
				$SIS_join = '';
				//Liquidaciones de sueldo
				$arrTemporal = array();
				$arrTemporal = db_select_array (false, $SIS_query, 'rrhh_sueldos_facturacion_trabajadores', $SIS_join, $z, 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_6');

				/*************************************************************************************************/
				//Creo los datos
				$_SESSION['pagos_leyes_sociales_trabajadores'] = array();//liquidaciones de sueldo
				$_SESSION['pagos_leyes_sociales_trabajadores'] = array();//liquidaciones de sueldo
				$_SESSION['pagos_leyes_sociales_formas_pago']  = array();//Formas de pago

				/********************************************/
				//recorro los boletas de honorarios
				if($arrTemporal!=false && !empty($arrTemporal) && $arrTemporal!=''){
					$_SESSION['pagos_leyes_sociales_trabajadores'] = $arrTemporal;
				}

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
			unset($_SESSION['pagos_leyes_sociales_basicos']);
			unset($_SESSION['pagos_leyes_sociales_trabajadores']);
			unset($_SESSION['pagos_leyes_sociales_formas_pago']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['pagos_leyes_sociales_archivos'])){
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
			unset($_SESSION['pagos_leyes_sociales_archivos']);

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
				//nada
			}

		break;

/*******************************************************************************************************************/
		case 'new_file_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['pagos_leyes_sociales_archivos'])){
				foreach ($_SESSION['pagos_leyes_sociales_archivos'] as $key => $trabajos){
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
						$sufijo = 'pagos_leyes_sociales_'.genera_password_unica().'_';

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
									$_SESSION['pagos_leyes_sociales_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['pagos_leyes_sociales_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['pagos_leyes_sociales_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['pagos_leyes_sociales_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['pagos_leyes_sociales_archivos'][$_GET['del_file']]);
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

			if(isset($AFP_idDocPago)){         $ndata_1 = count($AFP_idDocPago);          }else{$ndata_1 = 0;}
			if(isset($SALUD_idDocPago)){       $ndata_2 = count($SALUD_idDocPago);        }else{$ndata_2 = 0;}
			if(isset($SEGURIDAD_idDocPago)){   $ndata_3 = count($SEGURIDAD_idDocPago);    }else{$ndata_3 = 0;}

			if(count(array_filter($AFP_idDocPago))!=0 OR count(array_filter($SALUD_idDocPago))!=0 OR count(array_filter($SEGURIDAD_idDocPago))!=0) {
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
			//sumo los montos
			if(count(array_filter($AFP_idDocPago))!=0){
				for($x = 0; $x < $ndata_1; $x++){
					$Mont_tot_1 = $Mont_tot_1 + $AFP_Monto[$x];
				}
			}
			if(count(array_filter($SALUD_idDocPago))!=0){
				for($x = 0; $x < $ndata_2; $x++){
					$Mont_tot_2 = $Mont_tot_2 + $SALUD_Monto[$x];
				}
			}
			if(count(array_filter($SEGURIDAD_idDocPago))!=0){
				for($x = 0; $x < $ndata_3; $x++){
					$Mont_tot_3 = $Mont_tot_3 + $SEGURIDAD_Monto[$x];
				}
			}

			//Valido las cantidades
			if(valores_comparables($_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago'])<valores_comparables($Mont_tot_1)){
				$error['nPagos1'] = 'error/El monto ingresado en el pago del IVA es superior al total a pagar ('.valores($_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago'], 0).'<'.valores($Mont_tot_1, 0).')';
			}
			if(valores_comparables($_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago'])<valores_comparables($Mont_tot_2)){
				$error['nPagos2'] = 'error/El monto ingresado en el pago del PPM es superior al total a pagar ('.valores($_SESSION['pagos_leyes_sociales_basicos']['SALUD_Pago'], 0).'<'.valores($Mont_tot_2, 0).')';
			}
			if(valores_comparables($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago'])<valores_comparables($Mont_tot_3)){
				$error['nPagos3'] = 'error/El monto ingresado en el pago de la Retencion es superior al total a pagar ('.valores($_SESSION['pagos_leyes_sociales_basicos']['Retencion'], 0).'<'.valores($Mont_tot_3, 0).')';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//vacio variable
				unset($_SESSION['pagos_leyes_sociales_formas_pago']);

				//Declaro arreglo
				$_SESSION['pagos_leyes_sociales_formas_pago'] = array();

				//se recorren los pagos
				if($ndata_1!=0){
					for($x = 0; $x < $ndata_1; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($AFP_N_DocPago[$x])&&$AFP_N_DocPago[$x]!=''){$N_doc_p = $AFP_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						$_SESSION['pagos_leyes_sociales_formas_pago'][1][$x]['idDocPago'] = $AFP_idDocPago[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][1][$x]['N_DocPago'] = $N_doc_p;
						$_SESSION['pagos_leyes_sociales_formas_pago'][1][$x]['F_Pago']    = $AFP_F_Pago[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][1][$x]['Monto']     = $AFP_Monto[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][1][$x]['DocPago']   = $arrDoc[$AFP_idDocPago[$x]]['Nombre'];
					}
				}
				if($ndata_2!=0){
					for($x = 0; $x < $ndata_2; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($SALUD_N_DocPago[$x])&&$SALUD_N_DocPago[$x]!=''){$N_doc_p = $SALUD_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						$_SESSION['pagos_leyes_sociales_formas_pago'][2][$x]['idDocPago'] = $SALUD_idDocPago[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][2][$x]['N_DocPago'] = $N_doc_p;
						$_SESSION['pagos_leyes_sociales_formas_pago'][2][$x]['F_Pago']    = $SALUD_F_Pago[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][2][$x]['Monto']     = $SALUD_Monto[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][2][$x]['DocPago']   = $arrDoc[$SALUD_idDocPago[$x]]['Nombre'];
					}
				}
				if($ndata_3!=0){
					for($x = 0; $x < $ndata_3; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($SEGURIDAD_N_DocPago[$x])&&$SEGURIDAD_N_DocPago[$x]!=''){$N_doc_p = $SEGURIDAD_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						$_SESSION['pagos_leyes_sociales_formas_pago'][3][$x]['idDocPago'] = $SEGURIDAD_idDocPago[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][3][$x]['N_DocPago'] = $N_doc_p;
						$_SESSION['pagos_leyes_sociales_formas_pago'][3][$x]['F_Pago']    = $SEGURIDAD_F_Pago[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][3][$x]['Monto']     = $SEGURIDAD_Monto[$x];
						$_SESSION['pagos_leyes_sociales_formas_pago'][3][$x]['DocPago']   = $arrDoc[$SEGURIDAD_idDocPago[$x]]['Nombre'];
					}
				}

				//Actualizo el monto pagado
				$_SESSION['pagos_leyes_sociales_basicos']['TotalPagoGeneral']  = $Mont_tot_1 + $Mont_tot_2 + $Mont_tot_3;

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'PagoSocial':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['pagos_leyes_sociales_basicos'])){
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['idSistema']) OR $_SESSION['pagos_leyes_sociales_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el id del sistema';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['idUsuario']) OR $_SESSION['pagos_leyes_sociales_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']) OR $_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']) OR $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']=='' ){       $error['Periodo_Ano']      = 'error/No ha ingresado el año del periodo de pago';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']) OR $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']=='' ){       $error['Periodo_Mes']      = 'error/No ha ingresado el mes del periodo de pago';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']) OR $_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']=='' ){         $error['Pago_fecha']       = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['Observaciones']) OR $_SESSION['pagos_leyes_sociales_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_CC']) OR $_SESSION['pagos_leyes_sociales_basicos']['AFP_CC']=='' ){                 $error['AFP_CC']           = 'error/No ha ingresado el Centro de Costo IVA utilizado';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC']) OR $_SESSION['pagos_leyes_sociales_basicos']['SALUD_CC']=='' ){             $error['SALUD_CC']         = 'error/No ha ingresado el Centro de Costo PPM utilizado';}
				if(!isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC']) OR $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_CC']=='' ){     $error['SEGURIDAD_CC']     = 'error/No ha ingresado el Centro de Costo Retenciones utilizado';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al pago';
			}

			//Verifico si hay trabajadores
			$ntrab = 0;
			foreach ($_SESSION['pagos_leyes_sociales_trabajadores'] as $trab){
				$ntrab++;
			}
			if($ntrab==0){$error['ntrab'] = 'error/No hay trabajadores asignados';}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Verifico si queda pagado
				if(valores_comparables($_SESSION['pagos_leyes_sociales_basicos']['TotalGeneral'])==valores_comparables($_SESSION['pagos_leyes_sociales_basicos']['TotalPagoGeneral'])){
					$idEstadoPago = 2;//Pagado
				}else{
					$idEstadoPago = 1;//No Pagado
				}

				//Se guardan los datos basicos
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['idSistema']) && $_SESSION['pagos_leyes_sociales_basicos']['idSistema']!=''){                    $SIS_data  = "'".$_SESSION['pagos_leyes_sociales_basicos']['idSistema']."'";              }else{$SIS_data  = "''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_sociales_basicos']['idUsuario']!=''){                    $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['idUsuario']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']!=''){                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']) && $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']!=''){                $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']) && $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']!=''){                $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']) && $_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['pagos_leyes_sociales_basicos']['Pago_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['Observaciones']) && $_SESSION['pagos_leyes_sociales_basicos']['Observaciones']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['Observaciones']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotizacionOblig']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotizacionOblig']!=''){              $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotizacionOblig']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_SeguroInvalidez']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_SeguroInvalidez']!=''){              $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_SeguroInvalidez']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_APV']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_APV']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_APV']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_Cuenta_2']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_Cuenta_2']!=''){                            $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_Cuenta_2']."'";               }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotTrabajoPesado']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotTrabajoPesado']!=''){            $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_CotTrabajoPesado']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCTrabajador']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCTrabajador']!=''){                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCTrabajador']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCEmpleador']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCEmpleador']!=''){                    $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_Total_AFCEmpleador']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_MontoPago']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionLegal']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionLegal']!=''){          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionLegal']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionAdicional']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionAdicional']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_Total_CotizacionAdicional']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago']!=''){                                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_MontoPago']."'";                  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_Total_CotizacionLegal']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_Total_CotizacionLegal']!=''){  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_Total_CotizacionLegal']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago']!=''){                          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_MontoPago']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_idCentroCosto']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_idCentroCosto']!=''){                              $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_idCentroCosto']."'";                }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_1']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_1']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_1']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_2']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_2']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_2']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_3']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_3']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_3']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_4']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_4']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_4']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_5']) && $_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_5']!=''){                                      $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['AFP_idLevel_5']."'";                    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_idCentroCosto']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_idCentroCosto']!=''){                          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idCentroCosto']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_1']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_1']!=''){                                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_1']."'";                  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_2']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_2']!=''){                                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_2']."'";                  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_3']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_3']!=''){                                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_3']."'";                  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_4']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_4']!=''){                                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_4']."'";                  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_5']) && $_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_5']!=''){                                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SALUD_idLevel_5']."'";                  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idCentroCosto']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idCentroCosto']!=''){                  $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idCentroCosto']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_1']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_1']!=''){                          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_1']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_2']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_2']!=''){                          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_2']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_3']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_3']!=''){                          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_3']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_4']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_4']!=''){                          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_4']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_5']) && $_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_5']!=''){                          $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['SEGURIDAD_idLevel_5']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['TotalGeneral']) && $_SESSION['pagos_leyes_sociales_basicos']['TotalGeneral']!=''){                                        $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['TotalGeneral']."'";                     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['pagos_leyes_sociales_basicos']['TotalPagoGeneral']) && $_SESSION['pagos_leyes_sociales_basicos']['TotalPagoGeneral']!=''){                                $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['TotalPagoGeneral']."'";                 }else{$SIS_data .= ",''";}
				$SIS_data .= ",'".$idEstadoPago."'";

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario,fecha_auto,Periodo_Ano,
				Periodo_Mes,Pago_fecha, Pago_Semana, Pago_mes, Pago_ano, Observaciones,AFP_Total_CotizacionOblig,
				AFP_Total_SeguroInvalidez, AFP_Total_APV, AFP_Total_Cuenta_2, AFP_Total_CotTrabajoPesado,
				AFP_Total_AFCTrabajador, AFP_Total_AFCEmpleador, AFP_MontoPago, SALUD_Total_CotizacionLegal,
				SALUD_Total_CotizacionAdicional, SALUD_MontoPago, SEGURIDAD_Total_CotizacionLegal,
				SEGURIDAD_MontoPago, AFP_idCentroCosto,AFP_idLevel_1,AFP_idLevel_2, AFP_idLevel_3,AFP_idLevel_4,
				AFP_idLevel_5, SALUD_idCentroCosto,SALUD_idLevel_1,SALUD_idLevel_2, SALUD_idLevel_3,SALUD_idLevel_4,
				SALUD_idLevel_5, SEGURIDAD_idCentroCosto,SEGURIDAD_idLevel_1,SEGURIDAD_idLevel_2, SEGURIDAD_idLevel_3,
				SEGURIDAD_idLevel_4,SEGURIDAD_idLevel_5, TotalGeneral, TotalPagoGeneral, idEstadoPago';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Trabajadores
					foreach ($_SESSION['pagos_leyes_sociales_trabajadores'] as $trab){
						//Calculos
						$Total_AFP = 0;
						$Total_AFP = $Total_AFP + $trab['AFP_Cotizacion'];
						$Total_AFP = $Total_AFP + $trab['AFP_SeguroInvalidez'];
						$Total_AFP = $Total_AFP + $trab['AFP_APV'];
						$Total_AFP = $Total_AFP + $trab['AFP_Cuenta2'];
						$Total_AFP = $Total_AFP + $trab['AFP_TrabajoPesado'];
						$Total_AFP = $Total_AFP + $trab['AFC_Empleador'];
						$Total_AFP = $Total_AFP + $trab['AFC_Trabajador'];

						$Total_SALUD = 0;
						$Total_SALUD = $Total_SALUD + $trab['Salud_Cotizacion'];
						$Total_SALUD = $Total_SALUD + $trab['Salud_Extra_Valor'];

						$Total_SEGURIDAD = 0;
						$Total_SEGURIDAD = $Total_SEGURIDAD + $trab['MutualValor'];

						if(isset($ultimo_id) && $ultimo_id!=''){                                           $SIS_data  = "'".$ultimo_id."'";                        }else{$SIS_data  = "''";}
						//Identificacion trabajador
						if(isset($trab['idFactTrab']) && $trab['idFactTrab']!=''){                         $SIS_data .= ",'".$trab['idFactTrab']."'";              }else{$SIS_data .= ",''";}
						if(isset($trab['TrabajadorNombre']) && $trab['TrabajadorNombre']!=''){             $SIS_data .= ",'".$trab['TrabajadorNombre']."'";        }else{$SIS_data .= ",''";}
						if(isset($trab['TrabajadorRut']) && $trab['TrabajadorRut']!=''){                   $SIS_data .= ",'".$trab['TrabajadorRut']."'";           }else{$SIS_data .= ",''";}
						if(isset($trab['Sueldo']) && $trab['Sueldo']!=''){                                 $SIS_data .= ",'".$trab['Sueldo']."'";                  }else{$SIS_data .= ",''";}
						//AFP
						if(isset($trab['AFP_Nombre']) && $trab['AFP_Nombre']!=''){                         $SIS_data .= ",'".$trab['AFP_Nombre']."'";              }else{$SIS_data .= ",''";}
						if(isset($trab['AFP_Porcentaje']) && $trab['AFP_Porcentaje']!=''){                 $SIS_data .= ",'".$trab['AFP_Porcentaje']."'";          }else{$SIS_data .= ",''";}
						if(isset($trab['AFP_Cotizacion']) && $trab['AFP_Cotizacion']!=''){                 $SIS_data .= ",'".$trab['AFP_Cotizacion']."'";          }else{$SIS_data .= ",''";}
						if(isset($trab['AFP_SeguroInvalidez']) && $trab['AFP_SeguroInvalidez']!=''){       $SIS_data .= ",'".$trab['AFP_SeguroInvalidez']."'";     }else{$SIS_data .= ",''";}
						if(isset($trab['AFP_APV']) && $trab['AFP_APV']!=''){                               $SIS_data .= ",'".$trab['AFP_APV']."'";                 }else{$SIS_data .= ",''";}
						if(isset($trab['AFP_Cuenta2']) && $trab['AFP_Cuenta2']!=''){                       $SIS_data .= ",'".$trab['AFP_Cuenta2']."'";             }else{$SIS_data .= ",''";}
						if(isset($trab['AFP_TrabajoPesado']) && $trab['AFP_TrabajoPesado']!=''){           $SIS_data .= ",'".$trab['AFP_TrabajoPesado']."'";       }else{$SIS_data .= ",''";}
						if(isset($trab['AFC_Empleador']) && $trab['AFC_Empleador']!=''){                   $SIS_data .= ",'".$trab['AFC_Empleador']."'";           }else{$SIS_data .= ",''";}
						if(isset($trab['AFC_Trabajador']) && $trab['AFC_Trabajador']!=''){                 $SIS_data .= ",'".$trab['AFC_Trabajador']."'";          }else{$SIS_data .= ",''";}

						//Salud
						if(isset($trab['Salud_Nombre']) && $trab['Salud_Nombre']!=''){                     $SIS_data .= ",'".$trab['Salud_Nombre']."'";            }else{$SIS_data .= ",''";}
						if(isset($trab['Salud_Porcentaje']) && $trab['Salud_Porcentaje']!=''){             $SIS_data .= ",'".$trab['Salud_Porcentaje']."'";        }else{$SIS_data .= ",''";}
						if(isset($trab['Salud_Cotizacion']) && $trab['Salud_Cotizacion']!=''){             $SIS_data .= ",'".$trab['Salud_Cotizacion']."'";        }else{$SIS_data .= ",''";}
						if(isset($trab['Salud_Extra_Salud_id']) && $trab['Salud_Extra_Salud_id']!=''){     $SIS_data .= ",'".$trab['Salud_Extra_Salud_id']."'";    }else{$SIS_data .= ",''";}
						if(isset($trab['Salud_Extra_Porcentaje']) && $trab['Salud_Extra_Porcentaje']!=''){ $SIS_data .= ",'".$trab['Salud_Extra_Porcentaje']."'";  }else{$SIS_data .= ",''";}
						if(isset($trab['Salud_Extra_Valor']) && $trab['Salud_Extra_Valor']!=''){           $SIS_data .= ",'".$trab['Salud_Extra_Valor']."'";       }else{$SIS_data .= ",''";}

						//Seguridad
						if(isset($trab['MutualNombre']) && $trab['MutualNombre']!=''){                     $SIS_data .= ",'".$trab['MutualNombre']."'";            }else{$SIS_data .= ",''";}
						if(isset($trab['MutualPorcentaje']) && $trab['MutualPorcentaje']!=''){             $SIS_data .= ",'".$trab['MutualPorcentaje']."'";        }else{$SIS_data .= ",''";}
						if(isset($trab['MutualValor']) && $trab['MutualValor']!=''){                       $SIS_data .= ",'".$trab['MutualValor']."'";             }else{$SIS_data .= ",''";}

						//Totales
						if(isset($Total_AFP) && $Total_AFP!=''){                                           $SIS_data .= ",'".$Total_AFP."'";                       }else{$SIS_data .= ",''";}
						if(isset($Total_SALUD) && $Total_SALUD!=''){                                       $SIS_data .= ",'".$Total_SALUD."'";                     }else{$SIS_data .= ",''";}
						if(isset($Total_SEGURIDAD) && $Total_SEGURIDAD!=''){                               $SIS_data .= ",'".$Total_SEGURIDAD."'";                 }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactSocial, idFactTrab,TrabajadorNombre,TrabajadorRut,Sueldo,AFP_Nombre,AFP_Porcentaje,
						AFP_Cotizacion,AFP_SeguroInvalidez,AFP_APV,AFP_Cuenta2,AFP_TrabajoPesado,
						AFC_Empleador,AFC_Trabajador,Salud_Nombre,Salud_Porcentaje,Salud_Cotizacion,
						Salud_Extra_Salud_id,Salud_Extra_Porcentaje,Salud_Extra_Valor,MutualNombre,
						MutualPorcentaje,MutualValor, Total_AFP, Total_SALUD, Total_SEGURIDAD';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_trabajadores', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					/*********************************************************************/
					//PAGOS
					if($_SESSION['pagos_leyes_sociales_formas_pago']){

						/************************************/
						//AFP
						if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][1])){
							foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][1] as $key => $pago){
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                             $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
								if(isset($_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['pagos_leyes_sociales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_sociales_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
								if(isset($pago['idDocPago'])&&$pago['idDocPago']!=''){                                                                               $SIS_data .= ",'".$pago['idDocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){                                                                               $SIS_data .= ",'".$pago['N_DocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['F_Pago'])&&$pago['F_Pago']!=''){                                                                                     $SIS_data .= ",'".$pago['F_Pago']."'";                                           }else{$SIS_data .= ",''";}
								if(isset($pago['Monto'])&&$pago['Monto']!=''){                                                                                       $SIS_data .= ",'".$pago['Monto']."'";                                            }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idFactSocial, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
						/************************************/
						//SALUD
						if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][2])){
							foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][2] as $key => $pago){
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                             $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
								if(isset($_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['pagos_leyes_sociales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_sociales_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
								if(isset($pago['idDocPago'])&&$pago['idDocPago']!=''){                                                                               $SIS_data .= ",'".$pago['idDocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){                                                                               $SIS_data .= ",'".$pago['N_DocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['F_Pago'])&&$pago['F_Pago']!=''){                                                                                     $SIS_data .= ",'".$pago['F_Pago']."'";                                           }else{$SIS_data .= ",''";}
								if(isset($pago['Monto'])&&$pago['Monto']!=''){                                                                                       $SIS_data .= ",'".$pago['Monto']."'";                                            }else{$SIS_data .= ",''";}
								$SIS_data .= ",'2'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idFactSocial, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
						/************************************/
						//SEGURIDAD
						if(isset($_SESSION['pagos_leyes_sociales_formas_pago'][3])){
							foreach ($_SESSION['pagos_leyes_sociales_formas_pago'][3] as $key => $pago){
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                             $SIS_data  = "'".$ultimo_id."'";                                                 }else{$SIS_data  = "''";}
								if(isset($_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']."'";   }else{$SIS_data .= ",''";}
								if(isset($_SESSION['pagos_leyes_sociales_basicos']['idUsuario']) && $_SESSION['pagos_leyes_sociales_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
								if(isset($pago['idDocPago'])&&$pago['idDocPago']!=''){                                                                               $SIS_data .= ",'".$pago['idDocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){                                                                               $SIS_data .= ",'".$pago['N_DocPago']."'";                                        }else{$SIS_data .= ",''";}
								if(isset($pago['F_Pago'])&&$pago['F_Pago']!=''){                                                                                     $SIS_data .= ",'".$pago['F_Pago']."'";                                           }else{$SIS_data .= ",''";}
								if(isset($pago['Monto'])&&$pago['Monto']!=''){                                                                                       $SIS_data .= ",'".$pago['Monto']."'";                                            }else{$SIS_data .= ",''";}
								$SIS_data .= ",'3'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idFactSocial, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}

					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['pagos_leyes_sociales_archivos'])){
						foreach ($_SESSION['pagos_leyes_sociales_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                      $SIS_data  = "'".$ultimo_id."'";               }else{$SIS_data  = "''";}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFactSocial, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']) && $_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']!=''){
						$SIS_data .= ",'".$_SESSION['pagos_leyes_sociales_basicos']['fecha_auto']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFactSocial, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Se actualizan los registros usados para no volver a utilizarlos

					/****************************************************/
					if(isset($_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']) && $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano']!=''){   $Periodo_Ano = $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Ano'];  }else{$Periodo_Ano = '';}
					if(isset($_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']) && $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes']!=''){   $Periodo_Mes = $_SESSION['pagos_leyes_sociales_basicos']['Periodo_Mes'];  }else{$Periodo_Mes = '';}
					if(isset($_SESSION['pagos_leyes_sociales_basicos']['idSistema']) && $_SESSION['pagos_leyes_sociales_basicos']['idSistema']!=''){       $idSistema   = $_SESSION['pagos_leyes_sociales_basicos']['idSistema'];    }else{$idSistema   = '';}

					/*if(isset($Periodo_Ano)&&$Periodo_Ano!=''&&isset($Periodo_Mes)&&$Periodo_Mes!=''&&isset($idSistema)&&$idSistema!=''){

						//Solo compras pagadas totalmente
						$z = "idFactSocial=0";   //solo las que no esten asignadas

						//Filtro Fecha
						if(isset($Periodo_Ano)&&$Periodo_Ano!=''){ $z.=" AND Creacion_ano='".$Periodo_Ano."'"; }
						if(isset($Periodo_Mes)&&$Periodo_Mes!=''){ $z.=" AND Creacion_mes='".$Periodo_Mes."'"; }
						if(isset($idSistema)&&$idSistema!=''){     $z.=" AND idSistema='".$idSistema."'"; }

						//Actualizacion masiva de registros
						$SIS_data = 'idFactSocial='.$ultimo_id;

						$resultado = db_update_data (false, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores', $z, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}*/

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					//Borro todas las sesiones
					unset($_SESSION['pagos_leyes_sociales_basicos']);
					unset($_SESSION['pagos_leyes_sociales_trabajadores']);
					unset($_SESSION['pagos_leyes_sociales_formas_pago']);
					unset($_SESSION['pagos_leyes_sociales_archivos']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'add_new_pago':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(isset($AFP_idDocPago)){         $ndata_1 = count($AFP_idDocPago);        }else{$ndata_1 = 0;}
			if(isset($SALUD_idDocPago)){       $ndata_2 = count($SALUD_idDocPago);      }else{$ndata_2 = 0;}
			if(isset($SEGURIDAD_idDocPago)){   $ndata_3 = count($SEGURIDAD_idDocPago);  }else{$ndata_3 = 0;}

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
			//sumo los montos
			if($ndata_1!=0){
				for($x = 0; $x < $ndata_1; $x++){
					$Mont_tot_1 = $Mont_tot_1 + $AFP_Monto[$x];
				}
			}
			if($ndata_2!=0){
				for($x = 0; $x < $ndata_2; $x++){
					$Mont_tot_2 = $Mont_tot_2 + $SALUD_Monto[$x];
				}
			}
			if($ndata_3!=0){
				for($x = 0; $x < $ndata_3; $x++){
					$Mont_tot_3 = $Mont_tot_3 + $SEGURIDAD_Monto[$x];
				}
			}
			//Valido las cantidades
			if(isset($AFP_Total_deuda)&&valores_comparables($AFP_Total_deuda)<valores_comparables($Mont_tot_1)){
				$error['nPagos1'] = 'error/El monto ingresado en el pago del IVA es superior al total a pagar ('.valores($AFP_Total_deuda, 0).'<'.valores($Mont_tot_1, 0).')';
			}
			if(isset($SALUD_Total_deuda)&&valores_comparables($SALUD_Total_deuda)<valores_comparables($Mont_tot_2)){
				$error['nPagos2'] = 'error/El monto ingresado en el pago del PPM es superior al total a pagar ('.valores($SALUD_Total_deuda, 0).'<'.valores($Mont_tot_2, 0).')';
			}
			if(isset($SEGURIDAD_Total_deuda)&&valores_comparables($SEGURIDAD_Total_deuda)<valores_comparables($Mont_tot_3)){
				$error['nPagos3'] = 'error/El monto ingresado en el pago de la Retencion es superior al total a pagar ('.valores($SEGURIDAD_Total_deuda, 0).'<'.valores($Mont_tot_3, 0).')';
			}
			if(!isset($idFactSocial) OR $idFactSocial == ''){
				$error['idFactSocial'] = 'error/No ha ingresado el pago a relacionar';
			}
			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se recorren los pagos
				if($ndata_1!=0){
					for($x = 0; $x < $ndata_1; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($AFP_N_DocPago[$x])&&$AFP_N_DocPago[$x]!=''){$N_doc_p = $AFP_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						if(isset($idFactSocial) && $idFactSocial!=''){           $SIS_data  = "'".$idFactSocial."'";         }else{$SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){       $SIS_data .= ",'".$Creacion_fecha."'";      }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                 $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
						if(isset($AFP_idDocPago[$x])&&$AFP_idDocPago[$x]!=''){   $SIS_data .= ",'".$AFP_idDocPago[$x]."'";   }else{$SIS_data .= ",''";}
						if(isset($N_doc_p)&&$N_doc_p!=''){                       $SIS_data .= ",'".$N_doc_p."'";             }else{$SIS_data .= ",''";}
						if(isset($AFP_F_Pago[$x])&&$AFP_F_Pago[$x]!=''){         $SIS_data .= ",'".$AFP_F_Pago[$x]."'";      }else{$SIS_data .= ",''";}
						if(isset($AFP_Monto[$x])&&$AFP_Monto[$x]!=''){           $SIS_data .= ",'".$AFP_Monto[$x]."'";       }else{$SIS_data .= ",''";}
						$SIS_data .= ",'1'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactSocial, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Mensaje
						$s_men = 'Se ha hecho un pago de '.valores($AFP_Monto[$x], 0).' con '.$arrDoc[$AFP_idDocPago[$x]]['Nombre'].' N°'.$N_doc_p.' con fecha '.fecha_estandar($AFP_F_Pago[$x]);
						//Se guarda en historial la accion
						if(isset($idFactSocial) && $idFactSocial!=''){      $SIS_data  = "'".$idFactSocial."'";     }else{ $SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",'".$Creacion_fecha."'";  }else{ $SIS_data .= ",''"; }
						$SIS_data .= ",'1'";               //Creacion Satisfactoria
						$SIS_data .= ",'".$s_men."'";      //Observacion
						$SIS_data .= ",'".$idUsuario."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactSocial, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}
				if($ndata_2!=0){
					for($x = 0; $x < $ndata_2; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($SALUD_N_DocPago[$x])&&$SALUD_N_DocPago[$x]!=''){$N_doc_p = $SALUD_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						if(isset($idFactSocial) && $idFactSocial!=''){               $SIS_data  = "'".$idFactSocial."'";           }else{$SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){           $SIS_data .= ",'".$Creacion_fecha."'";        }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                     $SIS_data .= ",'".$idUsuario."'";             }else{$SIS_data .= ",''";}
						if(isset($SALUD_idDocPago[$x])&&$SALUD_idDocPago[$x]!=''){   $SIS_data .= ",'".$SALUD_idDocPago[$x]."'";   }else{$SIS_data .= ",''";}
						if(isset($N_doc_p)&&$N_doc_p!=''){                           $SIS_data .= ",'".$N_doc_p."'";               }else{$SIS_data .= ",''";}
						if(isset($SALUD_F_Pago[$x])&&$SALUD_F_Pago[$x]!=''){         $SIS_data .= ",'".$SALUD_F_Pago[$x]."'";      }else{$SIS_data .= ",''";}
						if(isset($SALUD_Monto[$x])&&$SALUD_Monto[$x]!=''){           $SIS_data .= ",'".$SALUD_Monto[$x]."'";       }else{$SIS_data .= ",''";}
						$SIS_data .= ",'2'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactSocial, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Mensaje
						$s_men = 'Se ha hecho un pago de '.valores($SALUD_Monto[$x], 0).' con '.$arrDoc[$SALUD_idDocPago[$x]]['Nombre'].' N°'.$N_doc_p.' con fecha '.fecha_estandar($SALUD_F_Pago[$x]);
						//Se guarda en historial la accion
						if(isset($idFactSocial) && $idFactSocial!=''){      $SIS_data  = "'".$idFactSocial."'";     }else{ $SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",'".$Creacion_fecha."'";  }else{ $SIS_data .= ",''"; }
						$SIS_data .= ",'1'";               //Creacion Satisfactoria
						$SIS_data .= ",'".$s_men."'";      //Observacion
						$SIS_data .= ",'".$idUsuario."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactSocial, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}
				if($ndata_3!=0){
					for($x = 0; $x < $ndata_3; $x++){
						//si no hay numero de pago se genera uno aleatorio
						if(isset($SEGURIDAD_N_DocPago[$x])&&$SEGURIDAD_N_DocPago[$x]!=''){$N_doc_p = $SEGURIDAD_N_DocPago[$x];}else{$N_doc_p = genera_password(16,'numerico');}
						//guardo los datos
						if(isset($idFactSocial) && $idFactSocial!=''){                       $SIS_data  = "'".$idFactSocial."'";               }else{$SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){                   $SIS_data .= ",'".$Creacion_fecha."'";            }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                             $SIS_data .= ",'".$idUsuario."'";                 }else{$SIS_data .= ",''";}
						if(isset($SEGURIDAD_idDocPago[$x])&&$SEGURIDAD_idDocPago[$x]!=''){   $SIS_data .= ",'".$SEGURIDAD_idDocPago[$x]."'";   }else{$SIS_data .= ",''";}
						if(isset($N_doc_p)&&$N_doc_p!=''){                                   $SIS_data .= ",'".$N_doc_p."'";                   }else{$SIS_data .= ",''";}
						if(isset($SEGURIDAD_F_Pago[$x])&&$SEGURIDAD_F_Pago[$x]!=''){         $SIS_data .= ",'".$SEGURIDAD_F_Pago[$x]."'";      }else{$SIS_data .= ",''";}
						if(isset($SEGURIDAD_Monto[$x])&&$SEGURIDAD_Monto[$x]!=''){           $SIS_data .= ",'".$SEGURIDAD_Monto[$x]."'";       }else{$SIS_data .= ",''";}
						$SIS_data .= ",'3'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactSocial, Creacion_fecha, idUsuario,idDocPago,N_DocPago,F_Pago,Monto,idTipo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_formas_pago', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Mensaje
						$s_men = 'Se ha hecho un pago de '.valores($SEGURIDAD_Monto[$x], 0).' con '.$arrDoc[$SEGURIDAD_idDocPago[$x]]['Nombre'].' N°'.$N_doc_p.' con fecha '.fecha_estandar($SEGURIDAD_F_Pago[$x]);
						//Se guarda en historial la accion
						if(isset($idFactSocial) && $idFactSocial!=''){      $SIS_data  = "'".$idFactSocial."'";     }else{ $SIS_data  = "''";}
						if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",'".$Creacion_fecha."'";  }else{ $SIS_data .= ",''"; }
						$SIS_data .= ",'1'";               //Creacion Satisfactoria
						$SIS_data .= ",'".$s_men."'";      //Observacion
						$SIS_data .= ",'".$idUsuario."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idFactSocial, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'pagos_leyes_sociales_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}

				//Sumo todos los pagos y actualizo el monto
				$rowMonto = db_select_data (false, 'SUM(Monto) AS Pagado', 'pagos_leyes_sociales_formas_pago', '', 'idFactSocial = "'.$idFactSocial.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData  = db_select_data (false, 'TotalGeneral', 'pagos_leyes_sociales', '', 'idFactSocial ='.$idFactSocial, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$SIS_data = "TotalPagoGeneral='".$rowMonto['Pagado']."'";
				//Verifico si queda pagado
				if(valores_comparables($rowData['TotalGeneral'])==valores_comparables($rowMonto['Pagado'])){
					$SIS_data .= ",idEstadoPago='2'";//Pagado
				}else{
					$SIS_data .= ",idEstadoPago='1'";//No Pagado
				}

				$resultado = db_update_data (false, $SIS_data, 'pagos_leyes_sociales', 'idFactSocial = "'.$idFactSocial.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
