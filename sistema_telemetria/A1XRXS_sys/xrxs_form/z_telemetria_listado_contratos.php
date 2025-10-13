<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-280).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idContrato']))    $idContrato    = $_POST['idContrato'];
	if (!empty($_POST['idTelemetria']))  $idTelemetria  = $_POST['idTelemetria'];
	if (!empty($_POST['Codigo']))        $Codigo        = $_POST['Codigo'];
	if (!empty($_POST['F_Inicio']))      $F_Inicio      = $_POST['F_Inicio'];
	if (!empty($_POST['F_Termino']))     $F_Termino     = $_POST['F_Termino'];

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
			case 'idContrato':     if(empty($idContrato)){    $error['idContrato']     = 'error/No ha ingresado el id';}break;
			case 'idTelemetria':   if(empty($idTelemetria)){  $error['idTelemetria']   = 'error/No ha seleccionado el equipo telemetria';}break;
			case 'Codigo':         if(empty($Codigo)){        $error['Codigo']         = 'error/No ha ingresado el Codigo';}break;
			case 'F_Inicio':       if(empty($F_Inicio)){      $error['F_Inicio']       = 'error/No ha ingresado la fecha de inicio';}break;
			case 'F_Termino':      if(empty($F_Termino)){     $error['F_Termino']      = 'error/No ha ingresado la fecha de termino';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Codigo) && $Codigo!=''){ $Codigo = EstandarizarInput($Codigo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Codigo)&&contar_palabras_censuradas($Codigo)!=0){  $error['Codigo'] = 'error/Edita Codigo, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Codigo)){
				$ndata_1 = db_select_nrows (false, 'Codigo', 'telemetria_listado_contratos', '', "Codigo='".$Codigo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Codigo ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***********************************************************/
				//Inserto el nuevo contrato
				if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data  = "'".$idTelemetria."'";   }else{$SIS_data  = "''";}
				if(isset($Codigo) && $Codigo!=''){              $SIS_data .= ",'".$Codigo."'";        }else{$SIS_data .= ",''";}
				if(isset($F_Inicio) && $F_Inicio!=''){          $SIS_data .= ",'".$F_Inicio."'";      }else{$SIS_data .= ",''";}
				if(isset($F_Termino) && $F_Termino!=''){        $SIS_data .= ",'".$F_Termino."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria, Codigo, F_Inicio, F_Termino';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_contratos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/***********************************************************/
					//Actualizo la tabla de telemetria relacionado
					$SIS_data = "idTelemetria='".$idTelemetria."'";
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data .= ",idContrato='".$ultimo_id."'";}
					if(isset($Codigo) && $Codigo!=''){          $SIS_data .= ",Codigo='".$Codigo."'";}
					if(isset($F_Inicio) && $F_Inicio!=''){      $SIS_data .= ",F_Inicio='".$F_Inicio."'";}
					if(isset($F_Termino) && $F_Termino!=''){    $SIS_data .= ",F_Termino='".$F_Termino."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){
						//redirijo
						header( 'Location: '.$location.'&created=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Codigo)&&isset($idContrato)){
				$ndata_1 = db_select_nrows (false, 'Codigo', 'telemetria_listado_contratos', '', "Codigo='".$Codigo."' AND idContrato!='".$idContrato."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Codigo ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***********************************************************/
				//Actualizo el contrato
				$SIS_data = "idContrato='".$idContrato."'";
				if(isset($idTelemetria) && $idTelemetria!=''){    $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($Codigo) && $Codigo!=''){                $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($F_Inicio) && $F_Inicio!=''){            $SIS_data .= ",F_Inicio='".$F_Inicio."'";}
				if(isset($F_Termino) && $F_Termino!=''){          $SIS_data .= ",F_Termino='".$F_Termino."'";}

				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_contratos', 'idContrato = "'.$idContrato.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/***********************************************************/
				//Actualizo la tabla de telemetria relacionado
				$SIS_data = "idTelemetria='".$idTelemetria."'";
				if(isset($idContrato) && $idContrato!=''){  $SIS_data .= ",idContrato='".$idContrato."'";}
				if(isset($Codigo) && $Codigo!=''){          $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($F_Inicio) && $F_Inicio!=''){      $SIS_data .= ",F_Inicio='".$F_Inicio."'";}
				if(isset($F_Termino) && $F_Termino!=''){    $SIS_data .= ",F_Termino='".$F_Termino."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				/***********************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'telemetria_listado_contratos', 'idContrato = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/***********************************************************/
				//Actualizo la tabla de telemetria relacionado
				$SIS_data = "idTelemetria='".$idTelemetria."'";
				$SIS_data .= ",idContrato=''";
				$SIS_data .= ",Codigo=''";
				$SIS_data .= ",F_Inicio=''";
				$SIS_data .= ",F_Termino=''";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idContrato = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
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
