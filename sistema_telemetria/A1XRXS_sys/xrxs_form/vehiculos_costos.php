<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-206).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCosto']))            $idCosto            = $_POST['idCosto'];
	if (!empty($_POST['idTipo']))             $idTipo             = $_POST['idTipo'];
	if (!empty($_POST['idUsuario']))          $idUsuario          = $_POST['idUsuario'];
	if (!empty($_POST['idVehiculo']))         $idVehiculo         = $_POST['idVehiculo'];
	if (!empty($_POST['Creacion_fecha']))     $Creacion_fecha     = $_POST['Creacion_fecha'];
	if (!empty($_POST['Creacion_mes']))       $Creacion_mes       = $_POST['Creacion_mes'];
	if (!empty($_POST['Creacion_ano']))       $Creacion_ano       = $_POST['Creacion_ano'];
	if (!empty($_POST['Valor']))              $Valor              = $_POST['Valor'];
	if (!empty($_POST['Observaciones']))      $Observaciones      = $_POST['Observaciones'];

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
			case 'idCosto':         if(empty($idCosto)){           $error['idCosto']            = 'error/No ha ingresado el id';}break;
			case 'idTipo':          if(empty($idTipo)){            $error['idTipo']             = 'error/No ha seleccionado el tipo';}break;
			case 'idUsuario':       if(empty($idUsuario)){         $error['idUsuario']          = 'error/No ha seleccionado el usuario';}break;
			case 'idVehiculo':      if(empty($idVehiculo)){        $error['idVehiculo']         = 'error/No ha seleccionado el vehiculo';}break;
			case 'Creacion_fecha':  if(empty($Creacion_fecha)){    $error['Creacion_fecha']     = 'error/No ha ingresado la fecha de creación';}break;
			case 'Creacion_mes':    if(empty($Creacion_mes)){      $error['Creacion_mes']       = 'error/No ha ingresado el mes de creación';}break;
			case 'Creacion_ano':    if(empty($Creacion_ano)){      $error['Creacion_ano']       = 'error/No ha ingresado el año de creación';}break;
			case 'Valor':           if(empty($Valor)){             $error['Valor']              = 'error/No ha ingresado el valor';}break;
			case 'Observaciones':   if(empty($Observaciones)){     $error['Observaciones']      = 'error/No ha ingresado la observacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idTipo) && $idTipo!=''){            $SIS_data  = "'".$idTipo."'";        }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){      $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($idVehiculo) && $idVehiculo!=''){    $SIS_data .= ",'".$idVehiculo."'";   }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($Valor) && $Valor!=''){                    $SIS_data .= ",'".$Valor."'";           }else{$SIS_data .=",''";}
				if(isset($Observaciones) && $Observaciones!=''){    $SIS_data .= ",'".$Observaciones."'";   }else{$SIS_data .=",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTipo, idUsuario, idVehiculo, Creacion_fecha, Creacion_mes, Creacion_ano, Valor, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_costos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idCosto='".$idCosto."'";
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idVehiculo) && $idVehiculo!=''){            $SIS_data .= ",idVehiculo='".$idVehiculo."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";}
				if(isset($Creacion_mes) && $Creacion_mes!=''){        $SIS_data .= ",Creacion_mes='".$Creacion_mes."'";}
				if(isset($Creacion_ano) && $Creacion_ano!=''){        $SIS_data .= ",Creacion_ano='".$Creacion_ano."'";}
				if(isset($Valor) && $Valor!=''){                      $SIS_data .= ",Valor='".$Valor."'";}
				if(isset($Observaciones) && $Observaciones!=''){      $SIS_data .= ",Observaciones='".$Observaciones."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'vehiculos_costos', 'idCosto = "'.$idCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'vehiculos_costos', 'idCosto = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
