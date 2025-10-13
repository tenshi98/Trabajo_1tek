<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-153).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idBloqueo']))   $idBloqueo   = $_POST['idBloqueo'];
	if (!empty($_POST['Fecha']))       $Fecha       = $_POST['Fecha'];
	if (!empty($_POST['Hora']))        $Hora        = $_POST['Hora'];
	if (!empty($_POST['IP_Client']))   $IP_Client   = $_POST['IP_Client'];
	if (!empty($_POST['Motivo']))      $Motivo      = $_POST['Motivo'];

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
			case 'idBloqueo':  if(empty($idBloqueo)){  $error['idBloqueo']  = 'error/No ha ingresado el id';}break;
			case 'Fecha':      if(empty($Fecha)){      $error['Fecha']      = 'error/No ha ingresado la fecha';}break;
			case 'Hora':       if(empty($Hora)){       $error['Hora']       = 'error/No ha ingresado la hora';}break;
			case 'IP_Client':  if(empty($IP_Client)){  $error['IP_Client']  = 'error/No ha ingresado la dirección IP';}break;
			case 'Motivo':     if(empty($Motivo)){     $error['Motivo']     = 'error/No ha ingresado el Motivo';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Motivo) && $Motivo!=''){ $Motivo = EstandarizarInput($Motivo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Motivo)&&contar_palabras_censuradas($Motivo)!=0){  $error['Motivo'] = 'error/Edita Motivo, contiene palabras no permitidas';}

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
			if(isset($IP_Client)){
				$ndata_1 = db_select_nrows (false, 'idBloqueo', 'sistema_seguridad_bloqueo_ip', '', "IP_Client='".$IP_Client."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Dirección IP ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Fecha) && $Fecha!=''){          $SIS_data  = "'".$Fecha."'";       }else{$SIS_data  = "''";}
				if(isset($Hora) && $Hora!=''){            $SIS_data .= ",'".$Hora."'";       }else{$SIS_data .= ",''";}
				if(isset($IP_Client) && $IP_Client!=''){  $SIS_data .= ",'".$IP_Client."'";  }else{$SIS_data .= ",''";}
				if(isset($Motivo) && $Motivo!=''){        $SIS_data .= ",'".$Motivo."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Fecha, Hora, IP_Client, Motivo';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_seguridad_bloqueo_ip', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($IP_Client, $idBloqueo)){
				$ndata_1 = db_select_nrows (false, 'idBloqueo', 'sistema_seguridad_bloqueo_ip', '', "IP_Client='".$IP_Client."' AND idBloqueo!='".$idBloqueo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Dirección IP ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idBloqueo='".$idBloqueo."'";
				if(isset($Fecha) && $Fecha!=''){          $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($Hora) && $Hora!=''){            $SIS_data .= ",Hora='".$Hora."'";}
				if(isset($IP_Client) && $IP_Client!=''){  $SIS_data .= ",IP_Client='".$IP_Client."'";}
				if(isset($Motivo) && $Motivo!=''){        $SIS_data .= ",Motivo='".$Motivo."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_seguridad_bloqueo_ip', 'idBloqueo = "'.$idBloqueo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sistema_seguridad_bloqueo_ip', 'idBloqueo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'block_ip':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/**************************************************/
			//verifico si se envia un entero
			$indice   = simpleDecode($_GET['block_ip'], fecha_actual());
			$Relacion = simpleDecode($_GET['Relacion'], fecha_actual());

			//Variables
			$Fecha   = fecha_actual();
			$Hora    = hora_actual();
			$Motivo  = 'Bloqueo desde las Ip relacionadas '.$Relacion;

			//busca si la ip del usuario ya existe
			$n_ip = db_select_nrows (false, 'idBloqueo', 'sistema_seguridad_bloqueo_ip', '', "IP_Client='".$indice."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//si la ip no existe la guarda
			if(isset($n_ip)&&$n_ip==0){

				//filtros
				if(isset($Fecha) && $Fecha!=''){    $SIS_data  = "'".$Fecha."'";      }else{$SIS_data  = "''";}
				if(isset($Hora) && $Hora!=''){      $SIS_data .= ",'".$Hora."'";      }else{$SIS_data .= ",''";}
				if(isset($indice) && $indice!=''){  $SIS_data .= ",'".$indice."'";    }else{$SIS_data .= ",''";}
				if(isset($Motivo) && $Motivo!=''){  $SIS_data .= ",'".$Motivo."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Fecha, Hora, IP_Client, Motivo';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_seguridad_bloqueo_ip', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}else{
				//redirijo
				header( 'Location: '.$location.'&not_created=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
	}

?>
