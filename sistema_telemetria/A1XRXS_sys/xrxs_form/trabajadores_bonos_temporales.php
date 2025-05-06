<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-188).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idAnticipos']))           $idAnticipos            = $_POST['idAnticipos'];
	if (!empty($_POST['idSistema']))             $idSistema              = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))             $idUsuario              = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))            $fecha_auto             = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha']))        $Creacion_fecha         = $_POST['Creacion_fecha'];
	if (!empty($_POST['idTrabajador']))          $idTrabajador           = $_POST['idTrabajador'];
	if (!empty($_POST['idBonoTemporal']))        $idBonoTemporal         = $_POST['idBonoTemporal'];
	if (!empty($_POST['Monto']))                 $Monto                  = $_POST['Monto'];
	if (!empty($_POST['Observacion']))           $Observacion            = $_POST['Observacion'];
	if (!empty($_POST['idUso']))                 $idUso                  = $_POST['idUso'];

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
			case 'idAnticipos':           if(empty($idAnticipos)){           $error['idAnticipos']           = 'error/No ha ingresado el id';}break;
			case 'idSistema':             if(empty($idSistema)){             $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':             if(empty($idUsuario)){             $error['idUsuario']             = 'error/No ha seleccionado el usuario';}break;
			case 'fecha_auto':            if(empty($fecha_auto)){            $error['fecha_auto']            = 'error/No ha ingresado la fecha de ingreso del documento';}break;
			case 'Creacion_fecha':        if(empty($Creacion_fecha)){        $error['Creacion_fecha']        = 'error/No ha ingresado la fecha de creación';}break;
			case 'idTrabajador':          if(empty($idTrabajador)){          $error['idTrabajador']          = 'error/No ha seleccionado el trabajador';}break;
			case 'idBonoTemporal':        if(empty($idBonoTemporal)){        $error['idBonoTemporal']        = 'error/No ha seleccionado el bono';}break;
			case 'Monto':                 if(empty($Monto)){                 $error['Monto']                 = 'error/No ha ingresado el monto';}break;
			case 'Observacion':           if(empty($Observacion)){           $error['Observacion']           = 'error/No ha ingresado la observacion';}break;
			case 'idUso':                 if(empty($idUso)){                 $error['idUso']                 = 'error/No ha seleccionado la utilizacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observacion) && $Observacion!=''){ $Observacion = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){  $error['Observacion'] = 'error/Edita la Observacion, contiene palabras no permitidas';}

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
			if(isset($Creacion_fecha)&&isset($idTrabajador)&&isset($idSistema)&&isset($idBonoTemporal)){
				$ndata_1 = db_select_nrows (false, 'Creacion_fecha', 'trabajadores_bonos_temporales', '', "Creacion_mes='".fecha2NMes($Creacion_fecha)."' AND idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."' AND idBonoTemporal='".$idBonoTemporal."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El bono ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){            $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
				if(isset($idTrabajador) && $idTrabajador!=''){      $SIS_data .= ",'".$idTrabajador."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",'".$idUsuario."'";      }else{$SIS_data .= ",''";}
				if(isset($fecha_auto) && $fecha_auto!=''){          $SIS_data .= ",'".$fecha_auto."'";     }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NSemana($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idBonoTemporal) && $idBonoTemporal!=''){   $SIS_data .= ",'".$idBonoTemporal."'";   }else{$SIS_data .= ",''";}
				if(isset($Monto) && $Monto!=''){                     $SIS_data .= ",'".$Monto."'";            }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){         $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idUso) && $idUso!=''){                     $SIS_data .= ",'".$idUso."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idTrabajador, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idBonoTemporal, Monto, Observacion, idUso';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_bonos_temporales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Creacion_fecha)&&isset($idTrabajador)&&isset($idAnticipos)&&isset($idSistema)&&isset($idBonoTemporal)){
				$ndata_1 = db_select_nrows (false, 'Creacion_fecha', 'trabajadores_bonos_temporales', '', "Creacion_mes='".fecha2NMes($Creacion_fecha)."' AND idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."' AND idBonoTemporal='".$idBonoTemporal."' AND idAnticipos!='".$idAnticipos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El bono ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idAnticipos='".$idAnticipos."'";
				if(isset($idSistema) && $idSistema!=''){            $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idTrabajador) && $idTrabajador!=''){      $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
				if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($fecha_auto) && $fecha_auto!=''){          $SIS_data .= ",fecha_auto='".$fecha_auto."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_Semana='".fecha2NSemana($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($idBonoTemporal) && $idBonoTemporal!=''){   $SIS_data .= ",idBonoTemporal='".$idBonoTemporal."'";}
				if(isset($Monto) && $Monto!=''){                     $SIS_data .= ",Monto='".$Monto."'";}
				if(isset($Observacion) && $Observacion!=''){         $SIS_data .= ",Observacion='".$Observacion."'";}
				if(isset($idUso) && $idUso!=''){                     $SIS_data .= ",idUso='".$idUso."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'trabajadores_bonos_temporales', 'idAnticipos = "'.$idAnticipos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'trabajadores_bonos_temporales', 'idAnticipos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
