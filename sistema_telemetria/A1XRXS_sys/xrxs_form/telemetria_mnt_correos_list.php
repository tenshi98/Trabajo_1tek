<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-184).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCorreos']))      $idCorreos      = $_POST['idCorreos'];
	if (!empty($_POST['idCorreosCat']))   $idCorreosCat   = $_POST['idCorreosCat'];
	if (!empty($_POST['idSistema']))      $idSistema      = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))      $idUsuario      = $_POST['idUsuario'];
	if (!empty($_POST['TimeStamp']))      $TimeStamp      = $_POST['TimeStamp'];
	if (!empty($_POST['Chat_id']))        $Chat_id        = $_POST['Chat_id'];

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
			case 'idCorreos':     if(empty($idCorreos)){      $error['idCorreos']      = 'error/No ha ingresado el id';}break;
			case 'idCorreosCat':  if(empty($idCorreosCat)){   $error['idCorreosCat']   = 'error/No ha seleccionado la ciudad';}break;
			case 'idSistema':     if(empty($idSistema)){      $error['idSistema']      = 'error/No ha seleccionado el Sistema';}break;
			case 'idUsuario':     if(empty($idUsuario)){      $error['idUsuario']      = 'error/No ha seleccionado el Usuario';}break;
			case 'TimeStamp':     if(empty($TimeStamp)){      $error['TimeStamp']      = 'error/No ha ingresado la fecha y hora';}break;
			case 'Chat_id':       if(empty($Chat_id)){        $error['Chat_id']        = 'error/No ha ingresado el Chat id';}break;

		}
	}

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
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($idUsuario)&&isset($idCorreosCat)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'idUsuario', 'telemetria_mnt_correos_list', '', "idUsuario='".$idUsuario."' AND idCorreosCat='".$idCorreosCat."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Chat_id)&&isset($idCorreosCat)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Chat_id', 'telemetria_mnt_correos_list', '', "Chat_id='".$Chat_id."' AND idCorreosCat='".$idCorreosCat."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(!isset($Chat_id)&&!isset($idUsuario)){
				$ndata_3 = 1;
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Usuario ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Chat id ya existe';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/No ha seleccionado un usuario ni ha ingresado el chat id';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idCorreosCat) && $idCorreosCat!=''){   $SIS_data  = "'".$idCorreosCat."'";   }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){         $SIS_data .= ",'".$idSistema."'";     }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",'".$idUsuario."'";     }else{$SIS_data .= ",''";}
				if(isset($TimeStamp) && $TimeStamp!=''){         $SIS_data .= ",'".$TimeStamp."'";     }else{$SIS_data .= ",''";}
				if(isset($Chat_id) && $Chat_id!=''){             $SIS_data .= ",'".$Chat_id."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idCorreosCat, idSistema, idUsuario, TimeStamp, Chat_id';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_mnt_correos_list', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($idUsuario)&&isset($idCorreosCat)&&isset($idSistema)&&isset($idCorreos)){
				$ndata_1 = db_select_nrows (false, 'idUsuario', 'telemetria_mnt_correos_list', '', "idUsuario='".$idUsuario."' AND idCorreosCat='".$idCorreosCat."' AND idSistema='".$idSistema."' AND idCorreos!='".$idCorreos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Chat_id)&&isset($idCorreosCat)&&isset($idSistema)&&isset($idCorreos)){
				$ndata_2 = db_select_nrows (false, 'Chat_id', 'telemetria_mnt_correos_list', '', "Chat_id='".$Chat_id."' AND idCorreosCat='".$idCorreosCat."' AND idSistema='".$idSistema."' AND idCorreos!='".$idCorreos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(!isset($Chat_id)&&!isset($idUsuario)){
				$ndata_3 = 1;
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Usuario ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Chat id ya existe';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/No ha seleccionado un usuario ni ha ingresado el chat id';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idCorreos='".$idCorreos."'";
				if(isset($idCorreosCat) && $idCorreosCat!=''){    $SIS_data .= ",idCorreosCat='".$idCorreosCat."'";}
				if(isset($idSistema) && $idSistema!=''){          $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){          $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($TimeStamp) && $TimeStamp!=''){          $SIS_data .= ",TimeStamp='".$TimeStamp."'";}
				if(isset($Chat_id) && $Chat_id!=''){              $SIS_data .= ",Chat_id='".$Chat_id."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_mnt_correos_list', 'idCorreos = "'.$idCorreos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'telemetria_mnt_correos_list', 'idCorreos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'noMolestar':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$HoraSistema      = hora_actual();
			$FechaSistema     = fecha_actual();
			$noMolestar       = $_GET['noMolestar'];
			$idUsuario        = $_GET['idUsuario'];
			$idSistema        = $_GET['idSistema'];

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se definen las horas para no molestar
				switch ($noMolestar) {
					case 1:  $h_noMolestar  = '01:00:00'; break;
					case 2:  $h_noMolestar  = '02:00:00'; break;
					case 3:  $h_noMolestar  = '03:00:00'; break;
					case 4:  $h_noMolestar  = '06:00:00'; break;
					case 5:  $h_noMolestar  = '09:00:00'; break;
					case 6:  $h_noMolestar  = '12:00:00'; break;
					case 7:  $h_noMolestar  = '15:00:00'; break;
					case 8:  $h_noMolestar  = '18:00:00'; break;
					case 9:  $h_noMolestar  = '21:00:00'; break;
					case 10: $h_noMolestar  = '24:00:00'; break;
				}

				//Se calcula prediccion de tiempo condicionando dias hacia adelante
				$Hora_noMolestar   = sumahoras($h_noMolestar,$HoraSistema);
				$Fecha_noMolestar  = $FechaSistema;
				if($Hora_noMolestar>'24:00:00'){
					$Hora_noMolestar   = restahoras('24:00:00',$Hora_noMolestar);
					$Fecha_noMolestar  = sumarDias($Fecha_noMolestar,1);
				}

				//Filtros
				if(isset($Fecha_noMolestar) && $Fecha_noMolestar != ''&&isset($Hora_noMolestar) && $Hora_noMolestar!=''){
					$SIS_data = "TimeStamp='".$Fecha_noMolestar." ".$Hora_noMolestar."'";
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_mnt_correos_list', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&noMol='.simpleEncode($h_noMolestar, fecha_actual()) );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
