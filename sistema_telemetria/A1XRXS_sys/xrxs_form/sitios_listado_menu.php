<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-164).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idMenu']))        $idMenu        = $_POST['idMenu'];
	if (!empty($_POST['idSitio']))       $idSitio       = $_POST['idSitio'];
	if (!empty($_POST['idEstado']))      $idEstado      = $_POST['idEstado'];
	if (!empty($_POST['idPosicion']))    $idPosicion    = $_POST['idPosicion'];
	if (!empty($_POST['Nombre']))        $Nombre        = $_POST['Nombre'];
	if (!empty($_POST['Link']))          $Link          = $_POST['Link'];
	if (!empty($_POST['idNewTab']))      $idNewTab      = $_POST['idNewTab'];
	if (!empty($_POST['idPopup']))       $idPopup       = $_POST['idPopup'];

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
			case 'idMenu':        if(empty($idMenu)){       $error['idMenu']       = 'error/No ha ingresado el id';}break;
			case 'idSitio':       if(empty($idSitio)){      $error['idSitio']      = 'error/No ha seleccionado el sitio';}break;
			case 'idEstado':      if(empty($idEstado)){     $error['idEstado']     = 'error/No ha seleccionado el estado';}break;
			case 'idPosicion':    if(empty($idPosicion)){   $error['idPosicion']   = 'error/No ha seleccionado la posicion';}break;
			case 'Nombre':        if(empty($Nombre)){       $error['Nombre']       = 'error/No ha ingresado el nombre';}break;
			case 'Link':          if(empty($Link)){         $error['Link']         = 'error/No ha ingresado el enlace';}break;
			case 'idNewTab':      if(empty($idNewTab)){     $error['idNewTab']     = 'error/No ha seleccionado la opción de nuevo tab';}break;
			case 'idPopup':       if(empty($idPopup)){      $error['idPopup']      = 'error/No ha seleccionado la opción de popup';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){ $Nombre = EstandarizarInput($Nombre);}
	if(isset($Link) && $Link!=''){     $Link   = EstandarizarInput($Link);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre']  = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Link)&&contar_palabras_censuradas($Link)!=0){      $error['Link']    = 'error/Edita Link, contiene palabras no permitidas';}

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
			//Se verifica si el dato existe
			if(isset($idPosicion)&&isset($idSitio)){
				$ndata_1 = db_select_nrows (false, 'idMenu', 'sitios_listado_menu', '', "idPosicion='".$idPosicion."' AND idSitio='".$idSitio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Nombre)&&isset($idSitio)){
				$ndata_2 = db_select_nrows (false, 'idMenu', 'sitios_listado_menu', '', "Nombre='".$Nombre."' AND idSitio='".$idSitio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Menu que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Menu que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSitio) && $idSitio!=''){          $SIS_data  = "'".$idSitio."'";        }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){        $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .= ",''";}
				if(isset($idPosicion) && $idPosicion!=''){    $SIS_data .= ",'".$idPosicion."'";    }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}
				if(isset($Link) && $Link!=''){                $SIS_data .= ",'".$Link."'";          }else{$SIS_data .= ",''";}
				if(isset($idNewTab) && $idNewTab!=''){        $SIS_data .= ",'".$idNewTab."'";      }else{$SIS_data .= ",''";}
				if(isset($idPopup) && $idPopup!=''){          $SIS_data .= ",'".$idPopup."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSitio,idEstado,idPosicion,Nombre,Link,idNewTab,idPopup';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sitios_listado_menu', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			//Se verifica si el dato existe
			if(isset($idPosicion)&&isset($idSitio)&&isset($idMenu)){
				$ndata_1 = db_select_nrows (false, 'idMenu', 'sitios_listado_menu', '', "idPosicion='".$idPosicion."' AND idSitio='".$idSitio."' AND idMenu!='".$idMenu."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Nombre)&&isset($idSitio)&&isset($idMenu)){
				$ndata_2 = db_select_nrows (false, 'idMenu', 'sitios_listado_menu', '', "Nombre='".$Nombre."' AND idSitio='".$idSitio."' AND idMenu!='".$idMenu."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Menu que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Menu que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idMenu='".$idMenu."'";
				if(isset($idSitio) && $idSitio!=''){          $SIS_data .= ",idSitio='".$idSitio."'";}
				if(isset($idEstado) && $idEstado!=''){        $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idPosicion) && $idPosicion!=''){    $SIS_data .= ",idPosicion='".$idPosicion."'";}
				if(isset($Nombre) && $Nombre!=''){            $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Link) && $Link!=''){                $SIS_data .= ",Link='".$Link."'";}
				if(isset($idNewTab) && $idNewTab!=''){        $SIS_data .= ",idNewTab='".$idNewTab."'";}
				if(isset($idPopup) && $idPopup!=''){          $SIS_data .= ",idPopup='".$idPopup."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sitios_listado_menu', 'idMenu = "'.$idMenu.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sitios_listado_menu', 'idMenu = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
