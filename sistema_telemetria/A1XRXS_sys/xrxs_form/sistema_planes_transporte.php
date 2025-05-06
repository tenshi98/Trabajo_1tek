<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-147).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de Valor_Mensuales input a variables
	if (!empty($_POST['idPlan']))         $idPlan          = $_POST['idPlan'];
	if (!empty($_POST['Nombre']))         $Nombre          = $_POST['Nombre'];
	if (!empty($_POST['Valor_Mensual']))  $Valor_Mensual   = $_POST['Valor_Mensual'];
	if (!empty($_POST['Valor_Anual']))    $Valor_Anual     = $_POST['Valor_Anual'];
	if (!empty($_POST['N_Hijos']))        $N_Hijos         = $_POST['N_Hijos'];

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
			case 'idPlan':         if(empty($idPlan)){         $error['idPlan']         = 'error/No ha ingresado el id';}break;
			case 'Nombre':         if(empty($Nombre)){         $error['Nombre']         = 'error/No ha ingresado el nombre del Plan';}break;
			case 'Valor_Mensual':  if(empty($Valor_Mensual)){  $error['Valor_Mensual']  = 'error/No ha ingresado el Valor Mensual del Plan';}break;
			case 'Valor_Anual':    if(empty($Valor_Anual)){    $error['Valor_Anual']    = 'error/No ha ingresado el Valor Anual del Plan';}break;
			case 'N_Hijos':        if(empty($N_Hijos)){        $error['N_Hijos']        = 'error/No ha ingresado el numero de hijos';}break;

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
			if(isset($Nombre)&&isset($N_Hijos)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'sistema_planes_transporte', '', "Nombre='".$Nombre."' AND N_Hijos='".$N_Hijos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){                $SIS_data  = "'".$Nombre."'";          }else{$SIS_data  = "''";}
				if(isset($Valor_Mensual) && $Valor_Mensual!=''){  $SIS_data .= ",'".$Valor_Mensual."'";  }else{$SIS_data .= ",''";}
				if(isset($Valor_Anual) && $Valor_Anual!=''){      $SIS_data .= ",'".$Valor_Anual."'";    }else{$SIS_data .= ",''";}
				if(isset($N_Hijos) && $N_Hijos!=''){              $SIS_data .= ",'".$N_Hijos."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,Valor_Mensual, Valor_Anual, N_Hijos';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_planes_transporte', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($N_Hijos)&&isset($idPlan)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'sistema_planes_transporte', '', "Nombre='".$Nombre."' AND N_Hijos='".$N_Hijos."' AND idPlan!='".$idPlan."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idPlan='".$idPlan."'";
				if(isset($Nombre) && $Nombre!=''){                $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Valor_Mensual) && $Valor_Mensual!=''){  $SIS_data .= ",Valor_Mensual='".$Valor_Mensual."'";}
				if(isset($Valor_Anual) && $Valor_Anual!=''){      $SIS_data .= ",Valor_Anual='".$Valor_Anual."'";}
				if(isset($N_Hijos) && $N_Hijos!=''){              $SIS_data .= ",N_Hijos='".$N_Hijos."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_planes_transporte', 'idPlan = "'.$idPlan.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sistema_planes_transporte', 'idPlan = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
