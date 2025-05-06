<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-062).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idPredio']))    $idPredio    = $_POST['idPredio'];
	if (!empty($_POST['idSistema']))   $idSistema   = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))    $idEstado    = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))      $Nombre      = $_POST['Nombre'];
	if (!empty($_POST['idPais']))      $idPais      = $_POST['idPais'];
	if (!empty($_POST['idCiudad']))    $idCiudad    = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))    $idComuna    = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))   $Direccion   = $_POST['Direccion'];

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
			case 'idPredio':   if(empty($idPredio)){   $error['idPredio']    = 'error/No ha ingresado el id';}break;
			case 'idSistema':  if(empty($idSistema)){  $error['idSistema']   = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':   if(empty($idEstado)){   $error['idEstado']    = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':     if(empty($Nombre)){     $error['Nombre']      = 'error/No ha ingresado el nombre';}break;
			case 'idPais':     if(empty($idPais)){     $error['idPais']      = 'error/No ha seleccionado el Pais';}break;
			case 'idCiudad':   if(empty($idCiudad)){   $error['idCiudad']    = 'error/No ha seleccionado la Ciudad';}break;
			case 'idComuna':   if(empty($idComuna)){   $error['idComuna']    = 'error/No ha seleccionado la Comuna';}break;
			case 'Direccion':  if(empty($Direccion)){  $error['Direccion']   = 'error/No ha seleccionado la Dirección';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){        $Nombre     = EstandarizarInput($Nombre);}
	if(isset($Direccion) && $Direccion!=''){  $Direccion  = EstandarizarInput($Direccion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){        $error['Nombre']    = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){  $error['Direccion'] = 'error/Edita Direccion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Verifico otros datos
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_predios_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){  $SIS_data  = "'".$idSistema."'";   }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){    $SIS_data .= ",'".$idEstado."'";   }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){        $SIS_data .= ",'".$Nombre."'";     }else{$SIS_data .= ",''";}
				if(isset($idPais) && $idPais!=''){        $SIS_data .= ",'".$idPais."'";     }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){    $SIS_data .= ",'".$idCiudad."'";   }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){    $SIS_data .= ",'".$idComuna."'";   }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){  $SIS_data .= ",'".$Direccion."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, Nombre,idPais, idCiudad, idComuna, Direccion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_predios_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
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
			if(isset($Nombre)&&isset($idSistema)&&isset($idPredio)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_predios_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idPredio!='".$idPredio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idPredio='".$idPredio."'";
				if(isset($idSistema) && $idSistema!=''){    $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){      $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre) && $Nombre!=''){          $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($idPais) && $idPais!=''){          $SIS_data .= ",idPais='".$idPais."'";}
				if(isset($idCiudad) && $idCiudad!=''){      $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){      $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){    $SIS_data .= ",Direccion='".$Direccion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_predios_listado', 'idPredio = "'.$idPredio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado_1 = db_delete_data (false, 'cross_predios_listado', 'idPredio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'cross_predios_listado_zonas', 'idPredio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'cross_predios_listado_zonas_ubicaciones', 'idPredio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

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
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idPredio   = $_GET['id'];
			$idEstado   = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'cross_predios_listado', 'idPredio = "'.$idPredio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
