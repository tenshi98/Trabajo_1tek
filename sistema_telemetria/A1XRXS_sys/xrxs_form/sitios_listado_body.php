<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-161).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idBody']))          $idBody         = $_POST['idBody'];
	if (!empty($_POST['idSitio']))         $idSitio        = $_POST['idSitio'];
	if (!empty($_POST['idTipo']))          $idTipo         = $_POST['idTipo'];
	if ( isset($_POST['Icono']))           $Icono          = $_POST['Icono'];
	if ( isset($_POST['IconoStyle']))      $IconoStyle     = $_POST['IconoStyle'];
	if ( isset($_POST['Titulo']))          $Titulo         = $_POST['Titulo'];
	if ( isset($_POST['TituloStyle']))     $TituloStyle    = $_POST['TituloStyle'];
	if ( isset($_POST['Texto']))           $Texto          = $_POST['Texto'];
	if ( isset($_POST['TextoStyle']))      $TextoStyle     = $_POST['TextoStyle'];
	if ( isset($_POST['LinkNombre']))      $LinkNombre     = $_POST['LinkNombre'];
	if ( isset($_POST['LinkStyle']))       $LinkStyle      = $_POST['LinkStyle'];
	if ( isset($_POST['LinkURL']))         $LinkURL        = $_POST['LinkURL'];
	if (!empty($_POST['idNewTab']))        $idNewTab       = $_POST['idNewTab'];
	if (!empty($_POST['idPopup']))         $idPopup        = $_POST['idPopup'];
	if (!empty($_POST['idEstado']))        $idEstado       = $_POST['idEstado'];
	if (!empty($_POST['idPosicion']))      $idPosicion     = $_POST['idPosicion'];
	if ( isset($_POST['Imagen']))          $Imagen         = $_POST['Imagen'];

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
			case 'idBody':         if(empty($idBody)){        $error['idBody']        = 'error/No ha ingresado el id';}break;
			case 'idSitio':        if(empty($idSitio)){       $error['idSitio']       = 'error/No ha seleccionado el sitio';}break;
			case 'idTipo':         if(empty($idTipo)){        $error['idTipo']        = 'error/No ha seleccionado el tipo';}break;
			case 'Icono':          if(empty($Icono)){         $error['Icono']         = 'error/No ha ingresado el Icono';}break;
			case 'IconoStyle':     if(empty($IconoStyle)){    $error['IconoStyle']    = 'error/No ha ingresado el estilo del Icono';}break;
			case 'Titulo':         if(empty($Titulo)){        $error['Titulo']        = 'error/No ha ingresado el Titulo';}break;
			case 'TituloStyle':    if(empty($TituloStyle)){   $error['TituloStyle']   = 'error/No ha ingresado el estilo del Titulo';}break;
			case 'Texto':          if(empty($Texto)){         $error['Texto']         = 'error/No ha ingresado el Texto';}break;
			case 'TextoStyle':     if(empty($TextoStyle)){    $error['TextoStyle']    = 'error/No ha ingresado el estilo del Texto';}break;
			case 'LinkNombre':     if(empty($LinkNombre)){    $error['LinkNombre']    = 'error/No ha ingresado el nombre del enlace';}break;
			case 'LinkStyle':      if(empty($LinkStyle)){     $error['LinkStyle']     = 'error/No ha ingresado el estilo del enlace';}break;
			case 'LinkURL':        if(empty($LinkURL)){       $error['LinkURL']       = 'error/No ha ingresado la URL del enlace';}break;
			case 'idNewTab':       if(empty($idNewTab)){      $error['idNewTab']      = 'error/No ha seleccionado la opción de nuevo tab';}break;
			case 'idPopup':        if(empty($idPopup)){       $error['idPopup']       = 'error/No ha seleccionado la opción de popup';}break;
			case 'idEstado':       if(empty($idEstado)){      $error['idEstado']      = 'error/No ha seleccionado el estado';}break;
			case 'idPosicion':     if(empty($idPosicion)){    $error['idPosicion']    = 'error/No ha seleccionado la posicion';}break;
			case 'Imagen':         if(empty($Imagen)){        $error['Imagen']        = 'error/No ha ingresado la imagen de fondo';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Icono) && $Icono!=''){             $Icono       = EstandarizarInput($Icono);}
	if(isset($IconoStyle) && $IconoStyle!=''){   $IconoStyle  = EstandarizarInput($IconoStyle);}
	if(isset($Titulo) && $Titulo!=''){           $Titulo      = EstandarizarInput($Titulo);}
	if(isset($TituloStyle) && $TituloStyle!=''){ $TituloStyle = EstandarizarInput($TituloStyle);}
	if(isset($Texto) && $Texto!=''){             $Texto       = EstandarizarInput($Texto);}
	if(isset($TextoStyle) && $TextoStyle!=''){   $TextoStyle  = EstandarizarInput($TextoStyle);}
	if(isset($LinkNombre) && $LinkNombre!=''){   $LinkNombre  = EstandarizarInput($LinkNombre);}
	if(isset($LinkStyle) && $LinkStyle!=''){     $LinkStyle   = EstandarizarInput($LinkStyle);}
	if(isset($LinkURL) && $LinkURL!=''){         $LinkURL     = EstandarizarInput($LinkURL);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Icono)&&contar_palabras_censuradas($Icono)!=0){              $error['Icono']       = 'error/Edita Icono, contiene palabras no permitidas';}
	if(isset($IconoStyle)&&contar_palabras_censuradas($IconoStyle)!=0){    $error['IconoStyle']  = 'error/Edita IconoStyle, contiene palabras no permitidas';}
	if(isset($Titulo)&&contar_palabras_censuradas($Titulo)!=0){            $error['Titulo']      = 'error/Edita Titulo, contiene palabras no permitidas';}
	if(isset($TituloStyle)&&contar_palabras_censuradas($TituloStyle)!=0){  $error['TituloStyle'] = 'error/Edita TituloStyle, contiene palabras no permitidas';}
	if(isset($Texto)&&contar_palabras_censuradas($Texto)!=0){              $error['Texto']       = 'error/Edita Texto, contiene palabras no permitidas';}
	if(isset($TextoStyle)&&contar_palabras_censuradas($TextoStyle)!=0){    $error['TextoStyle']  = 'error/Edita TextoStyle, contiene palabras no permitidas';}
	if(isset($LinkNombre)&&contar_palabras_censuradas($LinkNombre)!=0){    $error['LinkNombre']  = 'error/Edita LinkNombre,contiene palabras no permitidas';}
	if(isset($LinkStyle)&&contar_palabras_censuradas($LinkStyle)!=0){      $error['LinkStyle']   = 'error/Edita LinkStyle, contiene palabras no permitidas';}
	if(isset($LinkURL)&&contar_palabras_censuradas($LinkURL)!=0){          $error['LinkURL']     = 'error/Edita LinkURL, contiene palabras no permitidas';}

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
			if(isset($Titulo)&&isset($idSitio)){
				$ndata_1 = db_select_nrows (false, 'idBody', 'sitios_listado_body', '', "Titulo='".$Titulo."' AND idSitio='".$idSitio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Enlace que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSitio) && $idSitio!=''){          $SIS_data  = "'".$idSitio."'";          }else{$SIS_data  = "''";}
				if(isset($idTipo) && $idTipo!=''){            $SIS_data .= ",'".$idTipo."'";          }else{$SIS_data .= ",''";}
				if(isset($Icono) && $Icono!=''){              $SIS_data .= ",'".$Icono."'";           }else{$SIS_data .= ",''";}
				if(isset($IconoStyle) && $IconoStyle!=''){    $SIS_data .= ",'".$IconoStyle."'";      }else{$SIS_data .= ",''";}
				if(isset($Titulo) && $Titulo!=''){            $SIS_data .= ",'".$Titulo."'";          }else{$SIS_data .= ",''";}
				if(isset($TituloStyle) && $TituloStyle!=''){  $SIS_data .= ",'".$TituloStyle."'";     }else{$SIS_data .= ",''";}
				if(isset($Texto) && $Texto!=''){              $SIS_data .= ",'".$Texto."'";           }else{$SIS_data .= ",''";}
				if(isset($TextoStyle) && $TextoStyle!=''){    $SIS_data .= ",'".$TextoStyle."'";      }else{$SIS_data .= ",''";}
				if(isset($LinkNombre) && $LinkNombre!=''){    $SIS_data .= ",'".$LinkNombre."'";      }else{$SIS_data .= ",''";}
				if(isset($LinkStyle) && $LinkStyle!=''){      $SIS_data .= ",'".$LinkStyle."'";       }else{$SIS_data .= ",''";}
				if(isset($LinkURL) && $LinkURL!=''){          $SIS_data .= ",'".$LinkURL."'";         }else{$SIS_data .= ",''";}
				if(isset($idNewTab) && $idNewTab!=''){        $SIS_data .= ",'".$idNewTab."'";        }else{$SIS_data .= ",''";}
				if(isset($idPopup) && $idPopup!=''){          $SIS_data .= ",'".$idPopup."'";         }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){        $SIS_data .= ",'".$idEstado."'";        }else{$SIS_data .= ",''";}
				if(isset($idPosicion) && $idPosicion!=''){    $SIS_data .= ",'".$idPosicion."'";      }else{$SIS_data .= ",''";}
				if(isset($Imagen) && $Imagen!=''){            $SIS_data .= ",'".$Imagen."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSitio,idTipo,Icono,IconoStyle,Titulo,TituloStyle,Texto,
				TextoStyle,LinkNombre,LinkStyle,LinkURL,idNewTab,idPopup,idEstado,idPosicion,
				Imagen';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sitios_listado_body', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Titulo)&&isset($idSitio)&&isset($idBody)){
				$ndata_1 = db_select_nrows (false, 'idBody', 'sitios_listado_body', '', "Titulo='".$Titulo."' AND idSitio='".$idSitio."' AND idBody!='".$idBody."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Enlace que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idBody='".$idBody."'";
				if(isset($idSitio) && $idSitio!=''){     $SIS_data .= ",idSitio='".$idSitio."'";}
				if(isset($idTipo) && $idTipo!=''){       $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($Icono)){                       $SIS_data .= ",Icono='".$Icono."'";}
				if(isset($IconoStyle)){                  $SIS_data .= ",IconoStyle='".$IconoStyle."'";}
				if(isset($Titulo)){                      $SIS_data .= ",Titulo='".$Titulo."'";}
				if(isset($TituloStyle)){                 $SIS_data .= ",TituloStyle='".$TituloStyle."'";}
				if(isset($Texto)){                       $SIS_data .= ",Texto='".$Texto."'";}
				if(isset($TextoStyle)){                  $SIS_data .= ",TextoStyle='".$TextoStyle."'";}
				if(isset($LinkNombre)){                  $SIS_data .= ",LinkNombre='".$LinkNombre."'";}
				if(isset($LinkStyle)){                   $SIS_data .= ",LinkStyle='".$LinkStyle."'";}
				if(isset($LinkURL)){                     $SIS_data .= ",LinkURL='".$LinkURL."'";}
				if(isset($idNewTab)){                    $SIS_data .= ",idNewTab='".$idNewTab."'";}
				if(isset($idPopup)){                     $SIS_data .= ",idPopup='".$idPopup."'";}
				if(isset($idEstado)){                    $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idPosicion)){                  $SIS_data .= ",idPosicion='".$idPosicion."'";}
				if(isset($Imagen)){                      $SIS_data .= ",Imagen='".$Imagen."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sitios_listado_body', 'idBody = "'.$idBody.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sitios_listado_body', 'idBody = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
