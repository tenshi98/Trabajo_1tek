<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-232).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idContabPrevired']))      $idContabPrevired      = $_POST['idContabPrevired'];
	if (!empty($_POST['idCliente']))             $idCliente             = $_POST['idCliente'];
	if (!empty($_POST['idSistema']))             $idSistema             = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))             $idUsuario             = $_POST['idUsuario'];
	if (!empty($_POST['idTipo']))                $idTipo                = $_POST['idTipo'];
	if (!empty($_POST['fecha_auto']))            $fecha_auto            = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha']))        $Creacion_fecha        = $_POST['Creacion_fecha'];
	if (!empty($_POST['Creacion_mes']))          $Creacion_mes          = $_POST['Creacion_mes'];
	if (!empty($_POST['Creacion_ano']))          $Creacion_ano          = $_POST['Creacion_ano'];
	if (!empty($_POST['idEstado']))              $idEstado              = $_POST['idEstado'];
	if (!empty($_POST['idUsuarioCierre']))       $idUsuarioCierre       = $_POST['idUsuarioCierre'];
	if (!empty($_POST['Cierre_fecha']))          $Cierre_fecha          = $_POST['Cierre_fecha'];
	if (!empty($_POST['Cierre_mes']))            $Cierre_mes            = $_POST['Cierre_mes'];
	if (!empty($_POST['Cierre_ano']))            $Cierre_ano            = $_POST['Cierre_ano'];

	if (!empty($_POST['idEstadoOld']))           $idEstadoOld           = $_POST['idEstadoOld'];
	if (!empty($_POST['idOpciones']))            $idOpciones            = $_POST['idOpciones'];

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
			case 'idContabPrevired':      if(empty($idContabPrevired)){    $error['idContabPrevired']    = 'error/No ha seleccionado el id';}break;
			case 'idCliente':             if(empty($idCliente)){           $error['idCliente']           = 'error/No ha seleccionado el cliente';}break;
			case 'idSistema':             if(empty($idSistema)){           $error['idSistema']           = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':             if(empty($idUsuario)){           $error['idUsuario']           = 'error/No ha seleccionado el usuario';}break;
			case 'idTipo':                if(empty($idTipo)){              $error['idTipo']              = 'error/No ha seleccionado el tipo de facturacion';}break;
			case 'fecha_auto':            if(empty($fecha_auto)){          $error['fecha_auto']          = 'error/No ha ingresado la fecha';}break;
			case 'Creacion_fecha':        if(empty($Creacion_fecha)){      $error['Creacion_fecha']      = 'error/No ha ingresado la fecha';}break;
			case 'Creacion_mes':          if(empty($Creacion_mes)){        $error['Creacion_mes']        = 'error/No ha ingresado el mes';}break;
			case 'Creacion_ano':          if(empty($Creacion_ano)){        $error['Creacion_ano']        = 'error/No ha ingresado el año';}break;
			case 'idEstado':              if(empty($idEstado)){            $error['idEstado']            = 'error/No ha seleccionado el estado';}break;
			case 'idUsuarioCierre':       if(empty($idUsuarioCierre)){     $error['idUsuarioCierre']     = 'error/No ha seleccionado el usuario de cierre';}break;
			case 'Cierre_fecha':          if(empty($Cierre_fecha)){        $error['Cierre_fecha']        = 'error/No ha ingresado la fecha de cierre';}break;
			case 'Cierre_mes':            if(empty($Cierre_mes)){          $error['Cierre_mes']          = 'error/No ha ingresado el mes de cierre';}break;
			case 'Cierre_ano':            if(empty($Cierre_ano)){          $error['Cierre_ano']          = 'error/No ha ingresado el año de cierre';}break;

			case 'idEstadoOld':           if(empty($idEstadoOld)){         $error['idEstadoOld']         = 'error/No ha ingresado el estado antiguo';}break;
			case 'idOpciones':            if(empty($idOpciones)){          $error['idOpciones']          = 'error/No ha seleccionado el envio de correos';}break;

		}
	}

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

		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Obtengo una lista de los clientes que tienen previred
			$arrClientes = array();
			$arrClientes = db_select_array (false, 'clientes_listado.idCliente, clientes_listado.Nombre AS ClienteNombre,clientes_listado.email AS ClienteEmail, core_sistemas.Nombre AS SistemaNombre,core_sistemas.email_principal AS SistemaEmail, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'clientes_listado', 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = clientes_listado.idSistema', 'clientes_listado.idPrevired=1', 'clientes_listado.Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//recorro los clientes
			foreach ($arrClientes as $clientes){
				//se comprueba si existen correos
				if(!isset($clientes['ClienteEmail']) OR $clientes['ClienteEmail']=''){
					$ndata_1++;
					$error[$ndata_1] = 'error/El Cliente '.$clientes['ClienteNombre'].' no tiene su correo configurado';
				}
			}

			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/Uno o mas clientes no tienen el correo configurado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//recorro los clientes
				foreach ($arrClientes as $clientes){
					//Se guardan los datos basicos
					if(isset($clientes['idCliente']) && $clientes['idCliente']!=''){  $SIS_data  = "'".$clientes['idCliente']."'";   }else{$SIS_data  = "''";}
					if(isset($idSistema) && $idSistema!=''){                          $SIS_data .= ",'".$idSistema."'";              }else{$SIS_data .= ",''";}
					if(isset($idUsuario) && $idUsuario!=''){                          $SIS_data .= ",'".$idUsuario."'";              }else{$SIS_data .= ",''";}
					if(isset($idTipo) && $idTipo!=''){                                $SIS_data .= ",'".$idTipo."'";                 }else{$SIS_data .= ",''";}
					if(isset($fecha_auto) && $fecha_auto!=''){                        $SIS_data .= ",'".$fecha_auto."'";             }else{$SIS_data .= ",''";}
					if(isset($idEstado) && $idEstado!=''){                            $SIS_data .= ",'".$idEstado."'";               }else{$SIS_data .= ",''";}
					if(isset($Creacion_fecha) && $Creacion_fecha!=''){
						$SIS_data .= ",'".$Creacion_fecha."'";
						$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
						$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
					}else{
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
					}

					// inserto los datos de registro en la db
					$SIS_columns = 'idCliente, idSistema, idUsuario, idTipo, fecha_auto, idEstado, Creacion_fecha, Creacion_mes,Creacion_ano';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'contabilidad_clientes_previred', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//se verifica que se quiere enviar correos
						if(isset($idOpciones)&&$idOpciones==1){
							//se comprueba si existen correos
							if(isset($clientes['SistemaEmail'])&&$clientes['SistemaEmail']!=''&&isset($clientes['ClienteEmail'])&&$clientes['ClienteEmail']!=''){
								/*******************/
								//Mensaje
								$xbody = '
								<h3>Recordatorio</h3>
								<p>Estimado '.$correo['ClienteNombre'].', se le recuerda que debe pagar previred este me
								, tiene solo hasta el 15 del presente mes para pagar</p>
								';

								//Envio de correo
								$rmail = tareas_envio_correo($clientes['SistemaEmail'], $clientes['SistemaNombre'],
															 $clientes['ClienteEmail'], $clientes['ClienteNombre'],
															 '', '',
															 'Recordatorio Pago Previred',
															 $xbody,'',
															 '',
															 1,
															 $clientes['Gmail_Usuario'],
															 $clientes['Gmail_Password']);
								//se guarda el log
								log_response(1, $rmail, $clientes['ClienteEmail'].' (Asunto:Recordatorio Pago Previred)');
							}
						}
					}
				}

				//redirijo
				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;

/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idContabPrevired='".$idContabPrevired."'";
				if(isset($idCliente) && $idCliente!=''){          $SIS_data .= ",idCliente='".$idCliente."'";}
				if(isset($idSistema) && $idSistema!=''){          $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){          $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idTipo) && $idTipo!=''){                $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($fecha_auto) && $fecha_auto!=''){        $SIS_data .= ",fecha_auto='".$fecha_auto."'";}
				if(isset($idEstado) && $idEstado!=''){            $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				/****************************************************************/
				//Verifico el cambio de estado
				if(isset($idEstadoOld)&&$idEstadoOld!=$idEstado&&$idEstado!=1){
					if(isset($idUsuarioCierre) && $idUsuarioCierre!=''){        $SIS_data .= ",idUsuarioCierre='".$idUsuarioCierre."'";}
					if(isset($Cierre_fecha) && $Cierre_fecha!=''){
						$SIS_data .= ",Cierre_fecha='".$Cierre_fecha."'";
						$SIS_data .= ",Cierre_mes='".fecha2NMes($Cierre_fecha)."'";
						$SIS_data .= ",Cierre_ano='".fecha2Ano($Cierre_fecha)."'";
					//si no se ingresa la fecha se crea de forma automatica
					}else{
						$SIS_data .= ",Cierre_fecha='".fecha_actual()."'";
						$SIS_data .= ",Cierre_mes='".mes_actual()."'";
						$SIS_data .= ",Cierre_ano='".ano_actual()."'";
					}
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'contabilidad_clientes_previred', 'idContabPrevired = "'.$idContabPrevired.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del':

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
				//se borran los datos
				$resultado = db_delete_data (false, 'contabilidad_clientes_previred', 'idContabPrevired = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
	}

?>
