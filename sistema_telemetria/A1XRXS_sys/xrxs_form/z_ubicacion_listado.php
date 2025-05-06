<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-285).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Formulario para licitaciones
	if (!empty($_POST['idUbicacion']))        $idUbicacion         = $_POST['idUbicacion'];
	if (!empty($_POST['idSistema']))          $idSistema           = $_POST['idSistema'];
	if (!empty($_POST['Nombre']))             $Nombre              = $_POST['Nombre'];
	if (!empty($_POST['idEstado']))           $idEstado            = $_POST['idEstado'];
	if (!empty($_POST['idCliente']))          $idCliente           = $_POST['idCliente'];

	if (!empty($_POST['lvl']))                 $lvl                  = $_POST['lvl'];

	//formulariopara el itemizado
	//Traspaso de valores input a variables
	$idLevel = array();
	if (!empty($_POST['idLevel_1']))      $idLevel[1]      = $_POST['idLevel_1'];
	if (!empty($_POST['idLevel_2']))      $idLevel[2]      = $_POST['idLevel_2'];
	if (!empty($_POST['idLevel_3']))      $idLevel[3]      = $_POST['idLevel_3'];
	if (!empty($_POST['idLevel_4']))      $idLevel[4]      = $_POST['idLevel_4'];
	if (!empty($_POST['idLevel_5']))      $idLevel[5]      = $_POST['idLevel_5'];

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
			case 'idUbicacion':         if(empty($idUbicacion)){          $error['idUbicacion']           = 'error/No ha seleccionado la licitacion';}break;
			case 'idSistema':           if(empty($idSistema)){            $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'Nombre':              if(empty($Nombre)){               $error['Nombre']                = 'error/No ha ingresado el nombre';}break;
			case 'idEstado':            if(empty($idEstado)){             $error['idEstado']              = 'error/No ha seleccionado el estado';}break;
			case 'idCliente':           if(empty($idCliente)){            $error['idCliente']             = 'error/No ha seleccionado el cliente';}break;

			case 'lvl':                 if(empty($lvl)){                  $error['lvl']                   = 'error/No ha ingresado el nivel';}break;

			case 'idLevel_1':           if(empty($idLevel[1])){           $error['idLevel_1']             = 'error/No ha ingresado el idLevel_1';}break;
			case 'idLevel_2':           if(empty($idLevel[2])){           $error['idLevel_2']             = 'error/No ha ingresado el idLevel_2';}break;
			case 'idLevel_3':           if(empty($idLevel[3])){           $error['idLevel_3']             = 'error/No ha ingresado el idLevel_3';}break;
			case 'idLevel_4':           if(empty($idLevel[4])){           $error['idLevel_4']             = 'error/No ha ingresado el idLevel_4';}break;
			case 'idLevel_5':           if(empty($idLevel[5])){           $error['idLevel_5']             = 'error/No ha ingresado el idLevel_5';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){$Nombre = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'createBasicData':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'ubicacion_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la licitacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){     $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){           $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){       $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .= ",''";}
				if(isset($idCliente) && $idCliente!=''){     $SIS_data .= ",'".$idCliente."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Nombre,idEstado, idCliente';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ubicacion_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'createBasicDataClient':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'ubicacion_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la licitacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){     $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){           $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){       $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .= ",''";}
				if(isset($idCliente) && $idCliente!=''){     $SIS_data .= ",'".$idCliente."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Nombre,idEstado, idCliente';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ubicacion_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'updateBasicData':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idUbicacion)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'ubicacion_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idUbicacion!='".$idUbicacion."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la licitacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idUbicacion='".$idUbicacion."'";
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Nombre) && $Nombre!=''){             $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idCliente) && $idCliente!=''){       $SIS_data .= ",idCliente='".$idCliente."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ubicacion_listado', 'idUbicacion = "'.$idUbicacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'delBasicData':

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
				//maximo de registros
				$nmax = 5;

				//se borran los datos
				$resultado = db_delete_data (false, 'ubicacion_listado', 'idUbicacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos relacionados
				for ($i = 1; $i <= $nmax; $i++) {
					$resultado = db_delete_data (false, 'ubicacion_listado_level_'.$i, 'idUbicacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				//redirijo
				header( 'Location: '.$location.'&deleted=true' );
				die;

			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;

/*******************************************************************************************************************/
		case 'insert_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Verifico otros datos
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($lvl)&&isset($Nombre)&&isset($idUbicacion)&&isset($idSistema)&&isset($Codigo)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'ubicacion_listado_level_'.$lvl, '', "Nombre='".$Nombre."' AND idUbicacion='".$idUbicacion."' AND idSistema='".$idSistema."' AND Codigo='".$Codigo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El dato ya existe';}
			/*******************************************************************/

			// si no hay errores ejecuto
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){       $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
				if(isset($idUbicacion) && $idUbicacion!=''){   $SIS_data .= ",'".$idUbicacion."'";    }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){             $SIS_data .= ",'".$Nombre."'";         }else{$SIS_data .= ",''";}
				if(isset($idCliente) && $idCliente!=''){       $SIS_data .= ",'".$idCliente."'";      }else{$SIS_data .= ",''";}

				$xbla = '';
				for ($i = 2; $i <= $lvl; $i++) {
					//Ubico correctamente el puntero
					$point = $i - 1;
					//Valor a insertar
					if(isset($idLevel[$point]) && $idLevel[$point]!=''){   $SIS_data .= ",'".$idLevel[$point]."'";   }else{$SIS_data .=",''";}
					//donde insertar
					$xbla .= ',idLevel_'.$point;
				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idUbicacion, Nombre,idCliente'.$xbla;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ubicacion_listado_level_'.$lvl, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// si no hay errores ejecuto
			if(empty($error)){
				//Filtros
				$SIS_data = "idLevel_".$lvl."='".$idLevel[$lvl]."'";
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUbicacion) && $idUbicacion!=''){   $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
				if(isset($Nombre) && $Nombre!=''){             $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($idCliente) && $idCliente!=''){       $SIS_data .= ",idCliente='".$idCliente."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ubicacion_listado_level_'.$lvl, 'idLevel_'.$lvl.' = "'.$idLevel[$lvl].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_idLevel']) OR !validaEntero($_GET['del_idLevel']))&&$_GET['del_idLevel']!=''){
				$indice = simpleDecode($_GET['del_idLevel'], fecha_actual());
			}else{
				$indice = $_GET['del_idLevel'];
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
				for ($i = $_GET['lvl']; $i <= $_GET['nmax']; $i++) {
					//se borran los datos
					$resultado = db_delete_data (false, 'ubicacion_listado_level_'.$i, 'idLevel_'.$_GET['lvl'].' = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				//redirijo
				header( 'Location: '.$location.'&deleted=true' );
				die;

			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idUbicacion  = $_GET['id'];
			$idEstado     = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'ubicacion_listado', 'idUbicacion = "'.$idUbicacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'estadoClient':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idUbicacion  = $_GET['status'];
			$idEstado     = $_GET['estado'];
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'ubicacion_listado', 'idUbicacion = "'.$idUbicacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
