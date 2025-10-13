<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-063).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idZona']))              $idZona              = $_POST['idZona'];
	if (!empty($_POST['idPredio']))            $idPredio            = $_POST['idPredio'];
	if (!empty($_POST['Nombre']))              $Nombre              = $_POST['Nombre'];
	if (!empty($_POST['idEstado']))            $idEstado            = $_POST['idEstado'];
	if (!empty($_POST['Codigo']))              $Codigo              = $_POST['Codigo'];
	if (!empty($_POST['idCategoria']))         $idCategoria         = $_POST['idCategoria'];
	if (!empty($_POST['idProducto']))          $idProducto          = $_POST['idProducto'];
	if (!empty($_POST['AnoPlantacion']))       $AnoPlantacion       = $_POST['AnoPlantacion'];
	if (!empty($_POST['Hectareas']))           $Hectareas           = $_POST['Hectareas'];
	if (!empty($_POST['Hileras']))             $Hileras             = $_POST['Hileras'];
	if (!empty($_POST['Plantas']))             $Plantas             = $_POST['Plantas'];
	if (!empty($_POST['idEstadoProd']))        $idEstadoProd        = $_POST['idEstadoProd'];
	if (!empty($_POST['DistanciaPlant']))      $DistanciaPlant      = $_POST['DistanciaPlant'];
	if (!empty($_POST['DistanciaHileras']))    $DistanciaHileras    = $_POST['DistanciaHileras'];

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
			case 'idZona':             if(empty($idZona)){             $error['idZona']              = 'error/No ha ingresado el id';}break;
			case 'idPredio':           if(empty($idPredio)){           $error['idPredio']            = 'error/No ha seleccionado el predio';}break;
			case 'Nombre':             if(empty($Nombre)){             $error['Nombre']              = 'error/No ha ingresado el nombre';}break;
			case 'idEstado':           if(empty($idEstado)){           $error['idEstado']            = 'error/No ha seleccionado el estado';}break;
			case 'Codigo':             if(empty($Codigo)){             $error['Codigo']              = 'error/No ha ingresado el codigo';}break;
			case 'idCategoria':        if(empty($idCategoria)){        $error['idCategoria']         = 'error/No ha seleccionado la especie';}break;
			case 'idProducto':         if(empty($idProducto)){         $error['idProducto']          = 'error/No ha seleccionado la variedad';}break;
			case 'AnoPlantacion':      if(empty($AnoPlantacion)){      $error['AnoPlantacion']       = 'error/No ha ingresado el año de plantacion';}break;
			case 'Hectareas':          if(empty($Hectareas)){          $error['Hectareas']           = 'error/No ha ingresado las hectareas';}break;
			case 'Hileras':            if(empty($Hileras)){            $error['Hileras']             = 'error/No ha ingresado las hileras';}break;
			case 'Plantas':            if(empty($Plantas)){            $error['Plantas']             = 'error/No ha ingresado las plantas';}break;
			case 'idEstadoProd':       if(empty($idEstadoProd)){       $error['idEstadoProd']        = 'error/No ha seleccionado el estado de produccion';}break;
			case 'DistanciaPlant':     if(empty($DistanciaPlant)){     $error['DistanciaPlant']      = 'error/No ha ingresado la distancia de las plantas';}break;
			case 'DistanciaHileras':   if(empty($DistanciaHileras)){   $error['DistanciaHileras']    = 'error/No ha ingresado la distancia de las hileras';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){ $Nombre = EstandarizarInput($Nombre);}
	if(isset($Codigo) && $Codigo!=''){ $Codigo = EstandarizarInput($Codigo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Codigo)&&contar_palabras_censuradas($Codigo)!=0){  $error['Codigo'] = 'error/Edita Codigo, contiene palabras no permitidas';}

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
			if(isset($Nombre)&&isset($idPredio)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_predios_listado_zonas', '', "Nombre='".$Nombre."' AND idPredio='".$idPredio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idPredio) && $idPredio!=''){                    $SIS_data  = "'".$idPredio."'";            }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",'".$Nombre."'";             }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";           }else{$SIS_data .= ",''";}
				if(isset($Codigo) && $Codigo!=''){                        $SIS_data .= ",'".$Codigo."'";             }else{$SIS_data .= ",''";}
				if(isset($idCategoria) && $idCategoria!=''){              $SIS_data .= ",'".$idCategoria."'";        }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){                $SIS_data .= ",'".$idProducto."'";         }else{$SIS_data .= ",''";}
				if(isset($AnoPlantacion) && $AnoPlantacion!=''){          $SIS_data .= ",'".$AnoPlantacion."'";      }else{$SIS_data .= ",''";}
				if(isset($Hectareas) && $Hectareas!=''){                  $SIS_data .= ",'".$Hectareas."'";          }else{$SIS_data .= ",''";}
				if(isset($Hileras) && $Hileras!=''){                      $SIS_data .= ",'".$Hileras."'";            }else{$SIS_data .= ",''";}
				if(isset($Plantas) && $Plantas!=''){                      $SIS_data .= ",'".$Plantas."'";            }else{$SIS_data .= ",''";}
				if(isset($idEstadoProd) && $idEstadoProd!=''){            $SIS_data .= ",'".$idEstadoProd."'";       }else{$SIS_data .= ",''";}
				if(isset($DistanciaPlant) && $DistanciaPlant!=''){        $SIS_data .= ",'".$DistanciaPlant."'";     }else{$SIS_data .= ",''";}
				if(isset($DistanciaHileras) && $DistanciaHileras!=''){    $SIS_data .= ",'".$DistanciaHileras."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idPredio, Nombre,idEstado, Codigo, idCategoria, idProducto, AnoPlantacion, Hectareas, Hileras, Plantas, idEstadoProd, DistanciaPlant, DistanciaHileras';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_predios_listado_zonas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($idPredio)&&isset($idZona)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_predios_listado_zonas', '', "Nombre='".$Nombre."' AND idPredio='".$idPredio."' AND idZona!='".$idZona."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idZona='".$idZona."'";
				if(isset($idPredio) && $idPredio!=''){                   $SIS_data .= ",idPredio='".$idPredio."'";}
				if(isset($Nombre) && $Nombre!=''){                       $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($idEstado) && $idEstado!=''){                   $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Codigo) && $Codigo!=''){                       $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($idCategoria) && $idCategoria!=''){             $SIS_data .= ",idCategoria='".$idCategoria."'";}
				if(isset($idProducto) && $idProducto!=''){               $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($AnoPlantacion) && $AnoPlantacion!=''){         $SIS_data .= ",AnoPlantacion='".$AnoPlantacion."'";}
				if(isset($Hectareas) && $Hectareas!=''){                 $SIS_data .= ",Hectareas='".$Hectareas."'";}
				if(isset($Hileras) && $Hileras!=''){                     $SIS_data .= ",Hileras='".$Hileras."'";}
				if(isset($Plantas) && $Plantas!=''){                     $SIS_data .= ",Plantas='".$Plantas."'";}
				if(isset($idEstadoProd) && $idEstadoProd!=''){           $SIS_data .= ",idEstadoProd='".$idEstadoProd."'";}
				if(isset($DistanciaPlant) && $DistanciaPlant!=''){       $SIS_data .= ",DistanciaPlant='".$DistanciaPlant."'";}
				if(isset($DistanciaHileras) && $DistanciaHileras!=''){   $SIS_data .= ",DistanciaHileras='".$DistanciaHileras."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_predios_listado_zonas', 'idZona = "'.$idZona.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del_zona':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_zona']) OR !validaEntero($_GET['del_zona']))&&$_GET['del_zona']!=''){
				$indice = simpleDecode($_GET['del_zona'], fecha_actual());
			}else{
				$indice = $_GET['del_zona'];
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
				$resultado_1 = db_delete_data (false, 'cross_predios_listado_zonas', 'idZona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'cross_predios_listado_zonas_ubicaciones', 'idZona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true){

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
