<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-233).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFacturacion']))              $idFacturacion             = $_POST['idFacturacion'];
	if (!empty($_POST['idSistema']))                  $idSistema                 = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))                  $idUsuario                 = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))                 $fecha_auto                = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha']))             $Creacion_fecha            = $_POST['Creacion_fecha'];
	if (!empty($_POST['Creacion_Semana']))            $Creacion_Semana           = $_POST['Creacion_Semana'];
	if (!empty($_POST['Creacion_mes']))               $Creacion_mes              = $_POST['Creacion_mes'];
	if (!empty($_POST['Creacion_ano']))               $Creacion_ano              = $_POST['Creacion_ano'];
	if (!empty($_POST['Observaciones']))              $Observaciones             = $_POST['Observaciones'];
	if (!empty($_POST['idTrabajador']))               $idTrabajador              = $_POST['idTrabajador'];

	if (!empty($_POST['idExistencia']))               $idExistencia              = $_POST['idExistencia'];
	if (!empty($_POST['Descripcion']))                $Descripcion               = $_POST['Descripcion'];
	if (!empty($_POST['idDocPago']))                  $idDocPago                 = $_POST['idDocPago'];
	if (!empty($_POST['N_Doc']))                      $N_Doc                     = $_POST['N_Doc'];
	if (!empty($_POST['Valor']))                      $Valor                     = $_POST['Valor'];
	if (!empty($_POST['idCentroCosto']))              $idCentroCosto             = $_POST['idCentroCosto'];
	if (!empty($_POST['idLevel_1']))                  $idLevel_1                 = $_POST['idLevel_1'];
	if (!empty($_POST['idLevel_2']))                  $idLevel_2                 = $_POST['idLevel_2'];
	if (!empty($_POST['idLevel_3']))                  $idLevel_3                 = $_POST['idLevel_3'];
	if (!empty($_POST['idLevel_4']))                  $idLevel_4                 = $_POST['idLevel_4'];
	if (!empty($_POST['idLevel_5']))                  $idLevel_5                 = $_POST['idLevel_5'];
	if (!empty($_POST['oldItemID']))                  $oldItemID                 = $_POST['oldItemID'];
	if (!empty($_POST['Item']))                       $Item                      = $_POST['Item'];

	if (!empty($_POST['idSolicitado']))               $idSolicitado              = $_POST['idSolicitado'];
	if (!empty($_POST['idRevisado']))                 $idRevisado                = $_POST['idRevisado'];
	if (!empty($_POST['idAprobado']))                 $idAprobado                = $_POST['idAprobado'];

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
			case 'idFacturacion':              if(empty($idFacturacion)){              $error['idFacturacion']                = 'error/No ha seleccionado el id';}break;
			case 'idSistema':                  if(empty($idSistema)){                  $error['idSistema']                    = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':                  if(empty($idUsuario)){                  $error['idUsuario']                    = 'error/No ha seleccionado el usuario';}break;
			case 'fecha_auto':                 if(empty($fecha_auto)){                 $error['fecha_auto']                   = 'error/No ha ingresado la fecha';}break;
			case 'Creacion_fecha':             if(empty($Creacion_fecha)){             $error['Creacion_fecha']               = 'error/No ha ingresado la fecha';}break;
			case 'Creacion_Semana':            if(empty($Creacion_Semana)){            $error['Creacion_Semana']              = 'error/No ha ingresado la semana';}break;
			case 'Creacion_mes':               if(empty($Creacion_mes)){               $error['Creacion_mes']                 = 'error/No ha ingresado el mes';}break;
			case 'Creacion_ano':               if(empty($Creacion_ano)){               $error['Creacion_ano']                 = 'error/No ha ingresado el año';}break;
			case 'Observaciones':              if(empty($Observaciones)){              $error['Observaciones']                = 'error/No ha ingresado las observaciones';}break;
			case 'idTrabajador':               if(empty($idTrabajador)){               $error['idTrabajador']                 = 'error/No ha seleccionado el trabajador';}break;

			case 'idExistencia':               if(empty($idExistencia)){               $error['idExistencia']                 = 'error/No ha seleccionado el id';}break;
			case 'Descripcion':                if(empty($Descripcion)){                $error['Descripcion']                  = 'error/No ha ingresado la Descripcion';}break;
			case 'idDocPago':                  if(empty($idDocPago)){                  $error['idDocPago']                    = 'error/No ha seleccionado el documento de pago';}break;
			case 'N_Doc':                      if(empty($N_Doc)){                      $error['N_Doc']                        = 'error/No ha ingresado el numero del documento de pago';}break;
			case 'Valor':                      if(empty($Valor)){                      $error['Valor']                        = 'error/No ha ingresado el valor del documento de pago';}break;
			case 'idCentroCosto':              if(empty($idCentroCosto)){              $error['idCentroCosto']                = 'error/No ha seleccionado el centro de costo';}break;
			case 'idLevel_1':                  if(empty($idLevel_1)){                  $error['idLevel_1']                    = 'error/No ha seleccionado el centro de costo nivel 1';}break;
			case 'idLevel_2':                  if(empty($idLevel_2)){                  $error['idLevel_2']                    = 'error/No ha seleccionado el centro de costo nivel 2';}break;
			case 'idLevel_3':                  if(empty($idLevel_3)){                  $error['idLevel_3']                    = 'error/No ha seleccionado el centro de costo nivel 3';}break;
			case 'idLevel_4':                  if(empty($idLevel_4)){                  $error['idLevel_4']                    = 'error/No ha seleccionado el centro de costo nivel 4';}break;
			case 'idLevel_5':                  if(empty($idLevel_5)){                  $error['idLevel_5']                    = 'error/No ha seleccionado el centro de costo nivel 5';}break;
			case 'oldItemID':                  if(empty($oldItemID)){                  $error['oldItemID']                    = 'error/No ha ingresado el oldItemID';}break;
			case 'Item':                       if(empty($Item)){                       $error['Item']                         = 'error/No ha ingresado el Item';}break;

			case 'idSolicitado':               if(empty($idSolicitado)){               $error['idSolicitado']                 = 'error/No ha seleccionado el solicitante';}break;
			case 'idRevisado':                 if(empty($idRevisado)){                 $error['idRevisado']                   = 'error/No ha seleccionado el revisador';}break;
			case 'idAprobado':                 if(empty($idAprobado)){                 $error['idAprobado']                   = 'error/No ha seleccionado el aprobador';}break;

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

		case 'new_egreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['contab_caja_gastos_basicos']);
				unset($_SESSION['contab_caja_gastos_documentos']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['contab_caja_gastos_archivos'])){
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
				unset($_SESSION['contab_caja_gastos_archivos']);

				/****************************************************/
				//Se guardan los datos basicos del formulario recien llenado
				$_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']  = $Creacion_fecha;
				$_SESSION['contab_caja_gastos_basicos']['idTrabajador']    = $idTrabajador;
				$_SESSION['contab_caja_gastos_basicos']['Observaciones']   = $Observaciones;
				$_SESSION['contab_caja_gastos_basicos']['idSistema']       = $idSistema;
				$_SESSION['contab_caja_gastos_basicos']['idUsuario']       = $idUsuario;
				$_SESSION['contab_caja_gastos_basicos']['fecha_auto']      = $fecha_auto;
				$_SESSION['contab_caja_gastos_basicos']['Valor']           = 0;

				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Cargo, Fono, Rut', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['contab_caja_gastos_basicos']['Trabajador']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['contab_caja_gastos_basicos']['Rut']         = $rowTrabajador['Rut'];
					$_SESSION['contab_caja_gastos_basicos']['Cargo']       = $rowTrabajador['Cargo'];
					$_SESSION['contab_caja_gastos_basicos']['Fono']        = $rowTrabajador['Fono'];
				}else{
					$_SESSION['contab_caja_gastos_basicos']['Trabajador']  = '';
					$_SESSION['contab_caja_gastos_basicos']['Rut']         = '';
					$_SESSION['contab_caja_gastos_basicos']['Cargo']       = '';
					$_SESSION['contab_caja_gastos_basicos']['Fono']        = '';
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
			unset($_SESSION['contab_caja_gastos_basicos']);
			unset($_SESSION['contab_caja_gastos_documentos']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['contab_caja_gastos_archivos'])){
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
			unset($_SESSION['contab_caja_gastos_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['contab_caja_gastos_documentos']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['contab_caja_gastos_archivos'])){
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
				unset($_SESSION['contab_caja_gastos_archivos']);

				/****************************************************/
				//Se guardan los datos basicos del formulario recien llenado
				$_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']  = $Creacion_fecha;
				$_SESSION['contab_caja_gastos_basicos']['idTrabajador']    = $idTrabajador;
				$_SESSION['contab_caja_gastos_basicos']['Observaciones']   = $Observaciones;
				$_SESSION['contab_caja_gastos_basicos']['idSistema']       = $idSistema;
				$_SESSION['contab_caja_gastos_basicos']['idUsuario']       = $idUsuario;
				$_SESSION['contab_caja_gastos_basicos']['fecha_auto']      = $fecha_auto;
				$_SESSION['contab_caja_gastos_basicos']['Valor']           = 0;

				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Cargo, Fono, Rut', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['contab_caja_gastos_basicos']['Trabajador']  = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['contab_caja_gastos_basicos']['Rut']         = $rowTrabajador['Rut'];
					$_SESSION['contab_caja_gastos_basicos']['Cargo']       = $rowTrabajador['Cargo'];
					$_SESSION['contab_caja_gastos_basicos']['Fono']        = $rowTrabajador['Fono'];
				}else{
					$_SESSION['contab_caja_gastos_basicos']['Trabajador']  = '';
					$_SESSION['contab_caja_gastos_basicos']['Rut']         = '';
					$_SESSION['contab_caja_gastos_basicos']['Cargo']       = '';
					$_SESSION['contab_caja_gastos_basicos']['Fono']        = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'new_monto_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['contab_caja_gastos_documentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['contab_caja_gastos_documentos'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae el documento
				if(isset($idDocPago)&&$idDocPago!=''){
					//busco el documento
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago = "'.$idDocPago.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//si existe
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['DocPago']  = $rowDocPago['Nombre'];
				//si no existe
				}else{
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['DocPago']  = '';
				}

				/*****************************************/
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['CentroCosto']  = '';
				//Si hay un centro de costo
				if(isset($idCentroCosto)&&$idCentroCosto!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['CentroCosto'].= $rowCentro['Nombre'];
				}
				if(isset($idLevel_1)&&$idLevel_1!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_2)&&$idLevel_2!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_3)&&$idLevel_3!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_4)&&$idLevel_4!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_5)&&$idLevel_5!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$idInterno]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}

				/*****************************************/
				//Guardo el resto de datos
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['bvar']            = $idInterno;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['Descripcion']     = $Descripcion;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['idDocPago']       = $idDocPago;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['N_Doc']           = $N_Doc;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['Valor']           = $Valor;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['idCentroCosto']   = $idCentroCosto;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['idLevel_1']       = $idLevel_1;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['idLevel_2']       = $idLevel_2;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['idLevel_3']       = $idLevel_3;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['idLevel_4']       = $idLevel_4;
				$_SESSION['contab_caja_gastos_documentos'][$idInterno]['idLevel_5']       = $idLevel_5;

				header( 'Location: '.$location.'&view=true' );
				die;
			}


		break;
/*******************************************************************************************************************/
		case 'edit_monto_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************/
				// Se trae el documento
				if(isset($idDocPago)&&$idDocPago!=''){
					//busco el documento
					$rowDocPago = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago = "'.$idDocPago.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//si existe
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['DocPago']  = $rowDocPago['Nombre'];
				//si no existe
				}else{
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['DocPago']  = '';
				}

				/*****************************************/
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['CentroCosto']  = '';
				//Si hay un centro de costo
				if(isset($idCentroCosto)&&$idCentroCosto!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$idCentroCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['CentroCosto'].= $rowCentro['Nombre'];
				}
				if(isset($idLevel_1)&&$idLevel_1!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$idLevel_1.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_2)&&$idLevel_2!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$idLevel_2.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_3)&&$idLevel_3!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_3', '', 'idLevel_3 = "'.$idLevel_3.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_4)&&$idLevel_4!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_4', '', 'idLevel_4 = "'.$idLevel_4.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}
				if(isset($idLevel_5)&&$idLevel_5!=''){
					$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_5', '', 'idLevel_5 = "'.$idLevel_5.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['CentroCosto'].= ' - '.$rowCentro['Nombre'];
				}

				/*****************************************/
				//Guardo el resto de datos
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['bvar']            = $oldItemID;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['Descripcion']     = $Descripcion;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['idDocPago']       = $idDocPago;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['N_Doc']           = $N_Doc;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['Valor']           = $Valor;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['idCentroCosto']   = $idCentroCosto;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['idLevel_1']       = $idLevel_1;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['idLevel_2']       = $idLevel_2;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['idLevel_3']       = $idLevel_3;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['idLevel_4']       = $idLevel_4;
				$_SESSION['contab_caja_gastos_documentos'][$oldItemID]['idLevel_5']       = $idLevel_5;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_monto_eg':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['contab_caja_gastos_documentos'][$_GET['del_monto']]);

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
			if(isset($_SESSION['contab_caja_gastos_archivos'])){
				foreach ($_SESSION['contab_caja_gastos_archivos'] as $key => $trabajos){
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
						$sufijo = 'contab_caja_gastos_'.genera_password_unica().'_';

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
									$_SESSION['contab_caja_gastos_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['contab_caja_gastos_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
				if(!is_writable('upload/'.$_SESSION['contab_caja_gastos_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['contab_caja_gastos_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['contab_caja_gastos_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'eg_Caja':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['contab_caja_gastos_basicos'])){
				if(!isset($_SESSION['contab_caja_gastos_basicos']['idSistema']) OR $_SESSION['contab_caja_gastos_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el id del sistema';}
				if(!isset($_SESSION['contab_caja_gastos_basicos']['idUsuario']) OR $_SESSION['contab_caja_gastos_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['contab_caja_gastos_basicos']['fecha_auto']) OR $_SESSION['contab_caja_gastos_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha automatica';}
				if(!isset($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']) OR $_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['contab_caja_gastos_basicos']['Observaciones']) OR $_SESSION['contab_caja_gastos_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['contab_caja_gastos_basicos']['idTrabajador']) OR $_SESSION['contab_caja_gastos_basicos']['idTrabajador']=='' ){     $error['idTrabajador']     = 'error/No ha seleccionado el trabajador';}
				if(!isset($_SESSION['contab_caja_gastos_basicos']['Valor']) OR $_SESSION['contab_caja_gastos_basicos']['Valor']=='' ){                   $error['Valor']            = 'error/No ha ingresado el valor total del documento';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al egreso de caja';
			}
			//productos o guias
			if (!isset($_SESSION['contab_caja_gastos_documentos'])){
				$error['idProducto']   = 'error/No se han asignado documentos';
			}
			//Se verifican productos
			if (isset($_SESSION['contab_caja_gastos_documentos'])){
				foreach ($_SESSION['contab_caja_gastos_documentos'] as $key => $producto){
					$n_data1++;
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos'] = 'error/No se han asignado documentos';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['contab_caja_gastos_basicos']['idSistema']) && $_SESSION['contab_caja_gastos_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['contab_caja_gastos_basicos']['idSistema']."'";      }else{$SIS_data  = "''";}
				if(isset($_SESSION['contab_caja_gastos_basicos']['idUsuario']) && $_SESSION['contab_caja_gastos_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['contab_caja_gastos_basicos']['fecha_auto']) && $_SESSION['contab_caja_gastos_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']) && $_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['contab_caja_gastos_basicos']['Observaciones']) && $_SESSION['contab_caja_gastos_basicos']['Observaciones']!=''){  $SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['Observaciones']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['contab_caja_gastos_basicos']['idTrabajador']) && $_SESSION['contab_caja_gastos_basicos']['idTrabajador']!=''){    $SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['idTrabajador']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['contab_caja_gastos_basicos']['Valor']) && $_SESSION['contab_caja_gastos_basicos']['Valor']!=''){                  $SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['Valor']."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario,fecha_auto,Creacion_fecha,Creacion_Semana,
				Creacion_mes,Creacion_ano,Observaciones,idTrabajador,Valor';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'contab_caja_gastos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if (isset($_SESSION['contab_caja_gastos_documentos'])){
						foreach ($_SESSION['contab_caja_gastos_documentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                         $SIS_data  = "'".$ultimo_id."'";                                                }else{$SIS_data  = "''";}
							if(isset($_SESSION['contab_caja_gastos_basicos']['fecha_auto']) && $_SESSION['contab_caja_gastos_basicos']['fecha_auto']!=''){   $SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['fecha_auto']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']) && $_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Descripcion']) && $producto['Descripcion']!=''){      $SIS_data .= ",'".$producto['Descripcion']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['idDocPago']) && $producto['idDocPago']!=''){          $SIS_data .= ",'".$producto['idDocPago']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['N_Doc']) && $producto['N_Doc']!=''){                  $SIS_data .= ",'".$producto['N_Doc']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['Valor']) && $producto['Valor']!=''){                  $SIS_data .= ",'".$producto['Valor']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['idCentroCosto']) && $producto['idCentroCosto']!=''){  $SIS_data .= ",'".$producto['idCentroCosto']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_1']) && $producto['idLevel_1']!=''){          $SIS_data .= ",'".$producto['idLevel_1']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_2']) && $producto['idLevel_2']!=''){          $SIS_data .= ",'".$producto['idLevel_2']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_3']) && $producto['idLevel_3']!=''){          $SIS_data .= ",'".$producto['idLevel_3']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_4']) && $producto['idLevel_4']!=''){          $SIS_data .= ",'".$producto['idLevel_4']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_5']) && $producto['idLevel_5']!=''){          $SIS_data .= ",'".$producto['idLevel_5']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['CentroCosto']) && $producto['CentroCosto']!=''){      $SIS_data .= ",'".$producto['CentroCosto']."'";      }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes,
							Creacion_ano, Descripcion, idDocPago, N_Doc, Valor, idCentroCosto, idLevel_1, idLevel_2,
							idLevel_3, idLevel_4, idLevel_5, CentroCosto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'contab_caja_gastos_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['contab_caja_gastos_archivos'])){
						foreach ($_SESSION['contab_caja_gastos_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                     $SIS_data  = "'".$ultimo_id."'";            }else{$SIS_data  = "''";}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){   $SIS_data .= ",'".$producto['Nombre']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'contab_caja_gastos_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']) && $_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['contab_caja_gastos_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idFacturacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'contab_caja_gastos_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['contab_caja_gastos_basicos']);
					unset($_SESSION['contab_caja_gastos_documentos']);
					unset($_SESSION['contab_caja_gastos_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
