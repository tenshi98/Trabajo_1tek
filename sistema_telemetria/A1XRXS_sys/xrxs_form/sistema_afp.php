<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-129).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idAFP']))                     $idAFP                     = $_POST['idAFP'];
	if (!empty($_POST['Nombre']))                    $Nombre                    = $_POST['Nombre'];
	if ( isset($_POST['PorcentajeDependiente']))     $PorcentajeDependiente     = $_POST['PorcentajeDependiente'];
	if ( isset($_POST['PorcentajeIndependiente']))   $PorcentajeIndependiente   = $_POST['PorcentajeIndependiente'];
	if (!empty($_POST['idEstado']))                  $idEstado                  = $_POST['idEstado'];

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
			case 'idAFP':                    if(empty($idAFP)){                     $error['idAFP']                    = 'error/No ha ingresado el id';}break;
			case 'Nombre':                   if(empty($Nombre)){                    $error['Nombre']                   = 'error/No ha ingresado el nombre de la afp';}break;
			case 'PorcentajeDependiente':    if(!isset($PorcentajeDependiente)){    $error['PorcentajeDependiente']    = 'error/No ha ingresado el porcentaje para trabajadores dependientes';}break;
			case 'PorcentajeIndependiente':  if(!isset($PorcentajeIndependiente)){  $error['PorcentajeIndependiente']  = 'error/No ha ingresado el porcentaje para trabajadores independientes';}break;
			case 'idEstado':                 if(empty($idEstado)){                  $error['idEstado']                 = 'error/No ha seleccionado el estado';}break;

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
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'sistema_afp', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){                                    $SIS_data  = "'".$Nombre."'";                    }else{$SIS_data  = "''";}
				if(isset($PorcentajeDependiente) && $PorcentajeDependiente!=''){      $SIS_data .= ",'".$PorcentajeDependiente."'";    }else{$SIS_data .= ",''";}
				if(isset($PorcentajeIndependiente) && $PorcentajeIndependiente!=''){  $SIS_data .= ",'".$PorcentajeIndependiente."'";  }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                                $SIS_data .= ",'".$idEstado."'";                 }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,PorcentajeDependiente, PorcentajeIndependiente, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_afp', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($idAFP)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'sistema_afp', '', "Nombre='".$Nombre."' AND idAFP!='".$idAFP."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idAFP='".$idAFP."'";
				if(isset($Nombre) && $Nombre!=''){                                    $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($PorcentajeDependiente) && $PorcentajeDependiente!=''){      $SIS_data .= ",PorcentajeDependiente='".$PorcentajeDependiente."'";}
				if(isset($PorcentajeIndependiente) && $PorcentajeIndependiente!=''){  $SIS_data .= ",PorcentajeIndependiente='".$PorcentajeIndependiente."'";}
				if(isset($idEstado) && $idEstado!=''){                                $SIS_data .= ",idEstado='".$idEstado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_afp', 'idAFP = "'.$idAFP.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sistema_afp', 'idAFP = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
