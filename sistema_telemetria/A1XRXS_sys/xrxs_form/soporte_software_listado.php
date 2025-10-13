<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-166).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idSoftware']))      $idSoftware      = $_POST['idSoftware'];
	if (!empty($_POST['Nombre']))          $Nombre          = $_POST['Nombre'];
	if (!empty($_POST['Descripcion']))     $Descripcion     = $_POST['Descripcion'];
	if (!empty($_POST['idLicencia']))      $idLicencia      = $_POST['idLicencia'];
	if (!empty($_POST['Peso']))            $Peso            = $_POST['Peso'];
	if (!empty($_POST['idMedidaPeso']))    $idMedidaPeso    = $_POST['idMedidaPeso'];
	if (!empty($_POST['SitioWeb']))        $SitioWeb        = $_POST['SitioWeb'];
	if (!empty($_POST['SitioDescarga']))   $SitioDescarga   = $_POST['SitioDescarga'];
	if (!empty($_POST['idCategoria']))     $idCategoria     = $_POST['idCategoria'];

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
			case 'idSoftware':      if(empty($idSoftware)){      $error['idSoftware']       = 'error/No ha ingresado el id';}break;
			case 'Nombre':          if(empty($Nombre)){          $error['Nombre']           = 'error/No ha ingresado el nombre';}break;
			case 'Descripcion':     if(empty($Descripcion)){     $error['Descripcion']      = 'error/No ha ingresado la Descripcion';}break;
			case 'idLicencia':      if(empty($idLicencia)){      $error['idLicencia']       = 'error/No ha seleccionado el tipo de licencia';}break;
			case 'Peso':            if(empty($Peso)){            $error['Peso']             = 'error/No ha ingresado el peso del archivo';}break;
			case 'idMedidaPeso':    if(empty($idMedidaPeso)){    $error['idMedidaPeso']     = 'error/No ha seleccionado la medida del peso';}break;
			case 'SitioWeb':        if(empty($SitioWeb)){        $error['SitioWeb']         = 'error/No ha ingresado el sitio web';}break;
			case 'SitioDescarga':   if(empty($SitioDescarga)){   $error['SitioDescarga']    = 'error/No ha ingresado la dirección de descarga';}break;
			case 'idCategoria':     if(empty($idCategoria)){     $error['idCategoria']      = 'error/No ha seleccionado la categoria de la aplicacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){               $Nombre        = EstandarizarInput($Nombre);}
	if(isset($Descripcion) && $Descripcion!=''){     $Descripcion   = EstandarizarInput($Descripcion);}
	if(isset($SitioWeb) && $SitioWeb!=''){           $SitioWeb      = EstandarizarInput($SitioWeb);}
	if(isset($SitioDescarga) && $SitioDescarga!=''){ $SitioDescarga = EstandarizarInput($SitioDescarga);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){      $error['Descripcion']   = 'error/Edita Descripcion, contiene palabras no permitidas';}
	if(isset($SitioWeb)&&contar_palabras_censuradas($SitioWeb)!=0){            $error['SitioWeb']      = 'error/Edita SitioWeb, contiene palabras no permitidas';}
	if(isset($SitioDescarga)&&contar_palabras_censuradas($SitioDescarga)!=0){  $error['SitioDescarga'] = 'error/Edita SitioDescarga, contiene palabras no permitidas';}

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
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'soporte_software_listado', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la aplicacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){                $SIS_data  = "'".$Nombre."'";          }else{$SIS_data  = "''";}
				if(isset($Descripcion) && $Descripcion!=''){      $SIS_data .= ",'".$Descripcion."'";  }else{$SIS_data .= ",''";}
				if(isset($idLicencia) && $idLicencia!=''){        $SIS_data .= ",'".$idLicencia."'";     }else{$SIS_data .= ",''";}
				if(isset($Peso) && $Peso!=''){                    $SIS_data .= ",'".$Peso."'";           }else{$SIS_data .= ",''";}
				if(isset($idMedidaPeso) && $idMedidaPeso!=''){    $SIS_data .= ",'".$idMedidaPeso."'";   }else{$SIS_data .= ",''";}
				if(isset($SitioWeb) && $SitioWeb!=''){            $SIS_data .= ",'".$SitioWeb."'";       }else{$SIS_data .= ",''";}
				if(isset($SitioDescarga) && $SitioDescarga!=''){  $SIS_data .= ",'".$SitioDescarga."'";  }else{$SIS_data .= ",''";}
				if(isset($idCategoria) && $idCategoria!=''){      $SIS_data .= ",'".$idCategoria."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,Descripcion, idLicencia, Peso, idMedidaPeso, SitioWeb, SitioDescarga, idCategoria';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'soporte_software_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($idSoftware)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'soporte_software_listado', '', "Nombre='".$Nombre."' AND idSoftware!='".$idSoftware."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la aplicacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idSoftware='".$idSoftware."'";
				if(isset($Nombre) && $Nombre!=''){                   $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Descripcion) && $Descripcion!=''){         $SIS_data .= ",Descripcion='".$Descripcion."'";}
				if(isset($idLicencia) && $idLicencia!=''){           $SIS_data .= ",idLicencia='".$idLicencia."'";}
				if(isset($Peso) && $Peso!=''){                       $SIS_data .= ",Peso='".$Peso."'";}
				if(isset($idMedidaPeso) && $idMedidaPeso!=''){       $SIS_data .= ",idMedidaPeso='".$idMedidaPeso."'";}
				if(isset($SitioWeb) && $SitioWeb!=''){               $SIS_data .= ",SitioWeb='".$SitioWeb."'";}
				if(isset($SitioDescarga) && $SitioDescarga!=''){     $SIS_data .= ",SitioDescarga='".$SitioDescarga."'";}
				if(isset($idCategoria) && $idCategoria!=''){         $SIS_data .= ",idCategoria='".$idCategoria."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'soporte_software_listado', 'idSoftware = "'.$idSoftware.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'soporte_software_listado', 'idSoftware = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
