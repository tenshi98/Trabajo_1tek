<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-163).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idLinks']))         $idLinks         = $_POST['idLinks'];
	if (!empty($_POST['idSitio']))         $idSitio         = $_POST['idSitio'];
	if (!empty($_POST['idEstado']))        $idEstado        = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))          $Nombre          = $_POST['Nombre'];
	if (!empty($_POST['Enlace']))          $Enlace          = $_POST['Enlace'];
	if (!empty($_POST['PalabrasClave']))   $PalabrasClave   = $_POST['PalabrasClave'];

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
			case 'idLinks':         if(empty($idLinks)){        $error['idLinks']        = 'error/No ha ingresado el id';}break;
			case 'idSitio':         if(empty($idSitio)){        $error['idSitio']        = 'error/No ha seleccionado el sitio';}break;
			case 'idEstado':        if(empty($idEstado)){       $error['idEstado']       = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':          if(empty($Nombre)){         $error['Nombre']         = 'error/No ha ingresado el nombre';}break;
			case 'Enlace':          if(empty($Enlace)){         $error['Enlace']         = 'error/No ha ingresado la Enlace';}break;
			case 'PalabrasClave':   if(empty($PalabrasClave)){  $error['PalabrasClave']  = 'error/No ha ingresado las palabras clave';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){               $Nombre        = EstandarizarInput($Nombre);}
	if(isset($Enlace) && $Enlace!=''){               $Enlace        = EstandarizarInput($Enlace);}
	if(isset($PalabrasClave) && $PalabrasClave!=''){ $PalabrasClave = EstandarizarInput($PalabrasClave);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){               $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Enlace)&&contar_palabras_censuradas($Enlace)!=0){               $error['Enlace']        = 'error/Edita Enlace, contiene palabras no permitidas';}
	if(isset($PalabrasClave)&&contar_palabras_censuradas($PalabrasClave)!=0){ $error['PalabrasClave'] = 'error/Edita PalabrasClave, contiene palabras no permitidas';}

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
			if(isset($Nombre)&&isset($idSitio)){
				$ndata_1 = db_select_nrows (false, 'idLinks', 'sitios_listado_links', '', "Nombre='".$Nombre."' AND idSitio='".$idSitio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Enlace que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSitio) && $idSitio!=''){                 $SIS_data  = "'".$idSitio."'";             }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){               $SIS_data .= ",'".$idEstado."'";           }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                   $SIS_data .= ",'".$Nombre."'";             }else{$SIS_data .= ",''";}
				if(isset($Enlace) && $Enlace!=''){                   $SIS_data .= ",'".$Enlace."'";             }else{$SIS_data .= ",''";}
				if(isset($PalabrasClave) && $PalabrasClave!=''){     $SIS_data .= ",'".$PalabrasClave."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSitio,idEstado,Nombre,Enlace,PalabrasClave';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sitios_listado_links', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($idSitio)&&isset($idLinks)){
				$ndata_1 = db_select_nrows (false, 'idLinks', 'sitios_listado_links', '', "Nombre='".$Nombre."' AND idSitio='".$idSitio."' AND idLinks!='".$idLinks."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Enlace que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idLinks='".$idLinks."'";
				if(isset($idSitio) && $idSitio!=''){              $SIS_data .= ",idSitio='".$idSitio."'";}
				if(isset($idEstado) && $idEstado!=''){            $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre) && $Nombre!=''){                $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Enlace) && $Enlace!=''){                $SIS_data .= ",Enlace='".$Enlace."'";}
				if(isset($PalabrasClave) && $PalabrasClave!=''){  $SIS_data .= ",PalabrasClave='".$PalabrasClave."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sitios_listado_links', 'idLinks = "'.$idLinks.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sitios_listado_links', 'idLinks = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
