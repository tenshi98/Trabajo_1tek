<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-162).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCarousel']))          $idCarousel         = $_POST['idCarousel'];
	if (!empty($_POST['idSitio']))             $idSitio            = $_POST['idSitio'];
	if (!empty($_POST['idEstado']))            $idEstado           = $_POST['idEstado'];
	if (!empty($_POST['idPosicion']))          $idPosicion         = $_POST['idPosicion'];
	if (!empty($_POST['Imagen']))              $Imagen             = $_POST['Imagen'];
	if ( isset($_POST['Titulo']))              $Titulo             = $_POST['Titulo'];
	if ( isset($_POST['TituloStyle']))         $TituloStyle        = $_POST['TituloStyle'];
	if ( isset($_POST['Subtitulo']))           $Subtitulo          = $_POST['Subtitulo'];
	if ( isset($_POST['SubtituloStyle']))      $SubtituloStyle     = $_POST['SubtituloStyle'];
	if ( isset($_POST['Texto']))               $Texto              = $_POST['Texto'];
	if ( isset($_POST['TextoStyle']))          $TextoStyle         = $_POST['TextoStyle'];
	if ( isset($_POST['PosicionBloque']))      $PosicionBloque     = $_POST['PosicionBloque'];

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
			case 'idCarousel':         if(empty($idCarousel)){        $error['idCarousel']        = 'error/No ha ingresado el id';}break;
			case 'idSitio':            if(empty($idSitio)){           $error['idSitio']           = 'error/No ha seleccionado el sitio';}break;
			case 'idEstado':           if(empty($idEstado)){          $error['idEstado']          = 'error/No ha seleccionado el estado';}break;
			case 'idPosicion':         if(empty($idPosicion)){        $error['idPosicion']        = 'error/No ha seleccionado la posicion';}break;
			case 'Imagen':             if(empty($Imagen)){            $error['Imagen']            = 'error/No ha ingresado la Imagen';}break;
			case 'Titulo':             if(empty($Titulo)){            $error['Titulo']            = 'error/No ha ingresado el Titulo';}break;
			case 'TituloStyle':        if(empty($TituloStyle)){       $error['TituloStyle']       = 'error/No ha ingresado el estilo del Titulo';}break;
			case 'Subtitulo':          if(empty($Subtitulo)){         $error['Subtitulo']         = 'error/No ha ingresado el Subtitulo';}break;
			case 'SubtituloStyle':     if(empty($SubtituloStyle)){    $error['SubtituloStyle']    = 'error/No ha ingresado el estilo del Subtitulo';}break;
			case 'Texto':              if(empty($Texto)){             $error['Texto']             = 'error/No ha ingresado el Texto';}break;
			case 'TextoStyle':         if(empty($TextoStyle)){        $error['TextoStyle']        = 'error/No ha ingresado el estilo del Texto';}break;
			case 'PosicionBloque':     if(empty($PosicionBloque)){    $error['PosicionBloque']    = 'error/No ha ingresado la Posicion de Bloque';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Titulo) && $Titulo!=''){                 $Titulo         = EstandarizarInput($Titulo);}
	if(isset($TituloStyle) && $TituloStyle!=''){       $TituloStyle    = EstandarizarInput($TituloStyle);}
	if(isset($Subtitulo) && $Subtitulo!=''){           $Subtitulo      = EstandarizarInput($Subtitulo);}
	if(isset($SubtituloStyle) && $SubtituloStyle!=''){ $SubtituloStyle = EstandarizarInput($SubtituloStyle);}
	if(isset($Texto) && $Texto!=''){                   $Texto          = EstandarizarInput($Texto);}
	if(isset($TextoStyle) && $TextoStyle!=''){         $TextoStyle     = EstandarizarInput($TextoStyle);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Titulo)&&contar_palabras_censuradas($Titulo)!=0){                 $error['Titulo']         = 'error/Edita Titulo, contiene palabras no permitidas';}
	if(isset($TituloStyle)&&contar_palabras_censuradas($TituloStyle)!=0){       $error['TituloStyle']    = 'error/Edita TituloStyle, contiene palabras no permitidas';}
	if(isset($Subtitulo)&&contar_palabras_censuradas($Subtitulo)!=0){           $error['Subtitulo']      = 'error/Edita Subtitulo, contiene palabras no permitidas';}
	if(isset($SubtituloStyle)&&contar_palabras_censuradas($SubtituloStyle)!=0){ $error['SubtituloStyle'] = 'error/Edita SubtituloStyle, contiene palabras no permitidas';}
	if(isset($Texto)&&contar_palabras_censuradas($Texto)!=0){                   $error['Texto']          = 'error/Edita Texto, contiene palabras no permitidas';}
	if(isset($TextoStyle)&&contar_palabras_censuradas($TextoStyle)!=0){         $error['TextoStyle']     = 'error/Edita TextoStyle, contiene palabras no permitidas';}

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
				$ndata_1 = db_select_nrows (false, 'idCarousel', 'sitios_listado_carousel', '', "idPosicion='".$idPosicion."' AND idSitio='".$idSitio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Imagen)&&isset($idSitio)){
				$ndata_2 = db_select_nrows (false, 'idCarousel', 'sitios_listado_carousel', '', "Imagen='".$Imagen."' AND idSitio='".$idSitio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Carousel que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Carousel que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSitio) && $idSitio!=''){                 $SIS_data  = "'".$idSitio."'";             }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){               $SIS_data .= ",'".$idEstado."'";           }else{$SIS_data .= ",''";}
				if(isset($idPosicion) && $idPosicion!=''){           $SIS_data .= ",'".$idPosicion."'";         }else{$SIS_data .= ",''";}
				if(isset($Imagen) && $Imagen!=''){                   $SIS_data .= ",'".$Imagen."'";             }else{$SIS_data .= ",''";}
				if(isset($Titulo) && $Titulo!=''){                   $SIS_data .= ",'".$Titulo."'";             }else{$SIS_data .= ",''";}
				if(isset($TituloStyle) && $TituloStyle!=''){         $SIS_data .= ",'".$TituloStyle."'";        }else{$SIS_data .= ",''";}
				if(isset($Subtitulo) && $Subtitulo!=''){             $SIS_data .= ",'".$Subtitulo."'";          }else{$SIS_data .= ",''";}
				if(isset($SubtituloStyle) && $SubtituloStyle!=''){   $SIS_data .= ",'".$SubtituloStyle."'";     }else{$SIS_data .= ",''";}
				if(isset($Texto) && $Texto!=''){                     $SIS_data .= ",'".$Texto."'";              }else{$SIS_data .= ",''";}
				if(isset($TextoStyle) && $TextoStyle!=''){           $SIS_data .= ",'".$TextoStyle."'";         }else{$SIS_data .= ",''";}
				if(isset($PosicionBloque) && $PosicionBloque!=''){   $SIS_data .= ",'".$PosicionBloque."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSitio,idEstado,idPosicion,Imagen,Titulo,TituloStyle,Subtitulo,
				SubtituloStyle,Texto,TextoStyle,PosicionBloque';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sitios_listado_carousel', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($idPosicion)&&isset($idSitio)&&isset($idCarousel)){
				$ndata_1 = db_select_nrows (false, 'idCarousel', 'sitios_listado_carousel', '', "idPosicion='".$idPosicion."' AND idSitio='".$idSitio."' AND idCarousel!='".$idCarousel."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Imagen)&&isset($idSitio)&&isset($idCarousel)){
				$ndata_2 = db_select_nrows (false, 'idCarousel', 'sitios_listado_carousel', '', "Imagen='".$Imagen."' AND idSitio='".$idSitio."' AND idCarousel!='".$idCarousel."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Carousel que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Carousel que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idCarousel='".$idCarousel."'";
				if(isset($idSitio) && $idSitio!=''){                    $SIS_data .= ",idSitio='".$idSitio."'";}
				if(isset($idEstado) && $idEstado!=''){                  $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idPosicion) && $idPosicion!=''){              $SIS_data .= ",idPosicion='".$idPosicion."'";}
				if(isset($Imagen) && $Imagen!=''){                      $SIS_data .= ",Imagen='".$Imagen."'";}
				if(isset($Titulo)){                                     $SIS_data .= ",Titulo='".$Titulo."'";}
				if(isset($TituloStyle)){                                $SIS_data .= ",TituloStyle='".$TituloStyle."'";}
				if(isset($Subtitulo)){                                  $SIS_data .= ",Subtitulo='".$Subtitulo."'";}
				if(isset($SubtituloStyle)){                             $SIS_data .= ",SubtituloStyle='".$SubtituloStyle."'";}
				if(isset($Texto)){                                      $SIS_data .= ",Texto='".$Texto."'";}
				if(isset($TextoStyle)){                                 $SIS_data .= ",TextoStyle='".$TextoStyle."'";}
				if(isset($PosicionBloque) && $PosicionBloque!=''){      $SIS_data .= ",PosicionBloque='".$PosicionBloque."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sitios_listado_carousel', 'idCarousel = "'.$idCarousel.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sitios_listado_carousel', 'idCarousel = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
