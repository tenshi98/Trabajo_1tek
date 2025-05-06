<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-144).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idMantenedor']))                 $idMantenedor                 = $_POST['idMantenedor'];
	if (!empty($_POST['idSistema']))                    $idSistema                    = $_POST['idSistema'];
	if (!empty($_POST['AFP_idCentroCosto']))            $AFP_idCentroCosto            = $_POST['AFP_idCentroCosto'];
	if (!empty($_POST['AFP_idLevel_1']))                $AFP_idLevel_1                = $_POST['AFP_idLevel_1'];
	if (!empty($_POST['AFP_idLevel_2']))                $AFP_idLevel_2                = $_POST['AFP_idLevel_2'];
	if (!empty($_POST['AFP_idLevel_3']))                $AFP_idLevel_3                = $_POST['AFP_idLevel_3'];
	if (!empty($_POST['AFP_idLevel_4']))                $AFP_idLevel_4                = $_POST['AFP_idLevel_4'];
	if (!empty($_POST['AFP_idLevel_5']))                $AFP_idLevel_5                = $_POST['AFP_idLevel_5'];
	if (!empty($_POST['SALUD_idCentroCosto']))          $SALUD_idCentroCosto          = $_POST['SALUD_idCentroCosto'];
	if (!empty($_POST['SALUD_idLevel_1']))              $SALUD_idLevel_1              = $_POST['SALUD_idLevel_1'];
	if (!empty($_POST['SALUD_idLevel_2']))              $SALUD_idLevel_2              = $_POST['SALUD_idLevel_2'];
	if (!empty($_POST['SALUD_idLevel_3']))              $SALUD_idLevel_3              = $_POST['SALUD_idLevel_3'];
	if (!empty($_POST['SALUD_idLevel_4']))              $SALUD_idLevel_4              = $_POST['SALUD_idLevel_4'];
	if (!empty($_POST['SALUD_idLevel_5']))              $SALUD_idLevel_5              = $_POST['SALUD_idLevel_5'];
	if (!empty($_POST['SEGURIDAD_idCentroCosto']))      $SEGURIDAD_idCentroCosto      = $_POST['SEGURIDAD_idCentroCosto'];
	if (!empty($_POST['SEGURIDAD_idLevel_1']))          $SEGURIDAD_idLevel_1          = $_POST['SEGURIDAD_idLevel_1'];
	if (!empty($_POST['SEGURIDAD_idLevel_2']))          $SEGURIDAD_idLevel_2          = $_POST['SEGURIDAD_idLevel_2'];
	if (!empty($_POST['SEGURIDAD_idLevel_3']))          $SEGURIDAD_idLevel_3          = $_POST['SEGURIDAD_idLevel_3'];
	if (!empty($_POST['SEGURIDAD_idLevel_4']))          $SEGURIDAD_idLevel_4          = $_POST['SEGURIDAD_idLevel_4'];
	if (!empty($_POST['SEGURIDAD_idLevel_5']))          $SEGURIDAD_idLevel_5          = $_POST['SEGURIDAD_idLevel_5'];

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
			case 'idMantenedor':                 if(empty($idMantenedor)){                 $error['idMantenedor']              = 'error/No ha ingresado el id';}break;
			case 'idSistema':                    if(empty($idSistema)){                    $error['idSistema']                 = 'error/No ha ingresado el Sistema';}break;
			case 'AFP_idCentroCosto':            if(empty($AFP_idCentroCosto)){            $error['AFP_idCentroCosto']         = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'AFP_idLevel_1':                if(empty($AFP_idLevel_1)){                $error['AFP_idLevel_1']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'AFP_idLevel_2':                if(empty($AFP_idLevel_2)){                $error['AFP_idLevel_2']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'AFP_idLevel_3':                if(empty($AFP_idLevel_3)){                $error['AFP_idLevel_3']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'AFP_idLevel_4':                if(empty($AFP_idLevel_4)){                $error['AFP_idLevel_4']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'AFP_idLevel_5':                if(empty($AFP_idLevel_5)){                $error['AFP_idLevel_5']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'SALUD_idCentroCosto':          if(empty($SALUD_idCentroCosto)){          $error['SALUD_idCentroCosto']         = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'SALUD_idLevel_1':              if(empty($SALUD_idLevel_1)){              $error['SALUD_idLevel_1']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'SALUD_idLevel_2':              if(empty($SALUD_idLevel_2)){              $error['SALUD_idLevel_2']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'SALUD_idLevel_3':              if(empty($SALUD_idLevel_3)){              $error['SALUD_idLevel_3']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'SALUD_idLevel_4':              if(empty($SALUD_idLevel_4)){              $error['SALUD_idLevel_4']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'SALUD_idLevel_5':              if(empty($SALUD_idLevel_5)){              $error['SALUD_idLevel_5']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'SEGURIDAD_idCentroCosto':      if(empty($SEGURIDAD_idCentroCosto)){      $error['SEGURIDAD_idCentroCosto']         = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'SEGURIDAD_idLevel_1':          if(empty($SEGURIDAD_idLevel_1)){          $error['SEGURIDAD_idLevel_1']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'SEGURIDAD_idLevel_2':          if(empty($SEGURIDAD_idLevel_2)){          $error['SEGURIDAD_idLevel_2']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'SEGURIDAD_idLevel_3':          if(empty($SEGURIDAD_idLevel_3)){          $error['SEGURIDAD_idLevel_3']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'SEGURIDAD_idLevel_4':          if(empty($SEGURIDAD_idLevel_4)){          $error['SEGURIDAD_idLevel_4']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'SEGURIDAD_idLevel_5':          if(empty($SEGURIDAD_idLevel_5)){          $error['SEGURIDAD_idLevel_5']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;

		}
	}

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
			if(isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'idSistema', 'sistema_leyes_sociales', '', "idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El dato ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                                 $SIS_data  = "'".$idSistema."'";                      }else{$SIS_data  = "''";}
				if(isset($AFP_idCentroCosto) && $AFP_idCentroCosto!=''){                 $SIS_data .= ",'".$AFP_idCentroCosto."'";             }else{$SIS_data .= ",''";}
				if(isset($AFP_idLevel_1) && $AFP_idLevel_1!=''){                         $SIS_data .= ",'".$AFP_idLevel_1."'";                 }else{$SIS_data .= ",''";}
				if(isset($AFP_idLevel_2) && $AFP_idLevel_2!=''){                         $SIS_data .= ",'".$AFP_idLevel_2."'";                 }else{$SIS_data .= ",''";}
				if(isset($AFP_idLevel_3) && $AFP_idLevel_3!=''){                         $SIS_data .= ",'".$AFP_idLevel_3."'";                 }else{$SIS_data .= ",''";}
				if(isset($AFP_idLevel_4) && $AFP_idLevel_4!=''){                         $SIS_data .= ",'".$AFP_idLevel_4."'";                 }else{$SIS_data .= ",''";}
				if(isset($AFP_idLevel_5) && $AFP_idLevel_5!=''){                         $SIS_data .= ",'".$AFP_idLevel_5."'";                 }else{$SIS_data .= ",''";}
				if(isset($SALUD_idCentroCosto) && $SALUD_idCentroCosto!=''){             $SIS_data .= ",'".$SALUD_idCentroCosto."'";           }else{$SIS_data .= ",''";}
				if(isset($SALUD_idLevel_1) && $SALUD_idLevel_1!=''){                     $SIS_data .= ",'".$SALUD_idLevel_1."'";               }else{$SIS_data .= ",''";}
				if(isset($SALUD_idLevel_2) && $SALUD_idLevel_2!=''){                     $SIS_data .= ",'".$SALUD_idLevel_2."'";               }else{$SIS_data .= ",''";}
				if(isset($SALUD_idLevel_3) && $SALUD_idLevel_3!=''){                     $SIS_data .= ",'".$SALUD_idLevel_3."'";               }else{$SIS_data .= ",''";}
				if(isset($SALUD_idLevel_4) && $SALUD_idLevel_4!=''){                     $SIS_data .= ",'".$SALUD_idLevel_4."'";               }else{$SIS_data .= ",''";}
				if(isset($SALUD_idLevel_5) && $SALUD_idLevel_5!=''){                     $SIS_data .= ",'".$SALUD_idLevel_5."'";               }else{$SIS_data .= ",''";}
				if(isset($SEGURIDAD_idCentroCosto) && $SEGURIDAD_idCentroCosto!=''){     $SIS_data .= ",'".$SEGURIDAD_idCentroCosto."'";       }else{$SIS_data .= ",''";}
				if(isset($SEGURIDAD_idLevel_1) && $SEGURIDAD_idLevel_1!=''){             $SIS_data .= ",'".$SEGURIDAD_idLevel_1."'";           }else{$SIS_data .= ",''";}
				if(isset($SEGURIDAD_idLevel_2) && $SEGURIDAD_idLevel_2!=''){             $SIS_data .= ",'".$SEGURIDAD_idLevel_2."'";           }else{$SIS_data .= ",''";}
				if(isset($SEGURIDAD_idLevel_3) && $SEGURIDAD_idLevel_3!=''){             $SIS_data .= ",'".$SEGURIDAD_idLevel_3."'";           }else{$SIS_data .= ",''";}
				if(isset($SEGURIDAD_idLevel_4) && $SEGURIDAD_idLevel_4!=''){             $SIS_data .= ",'".$SEGURIDAD_idLevel_4."'";           }else{$SIS_data .= ",''";}
				if(isset($SEGURIDAD_idLevel_5) && $SEGURIDAD_idLevel_5!=''){             $SIS_data .= ",'".$SEGURIDAD_idLevel_5."'";           }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, AFP_idCentroCosto,AFP_idLevel_1,AFP_idLevel_2,AFP_idLevel_3,AFP_idLevel_4,
				AFP_idLevel_5,SALUD_idCentroCosto,SALUD_idLevel_1,SALUD_idLevel_2,SALUD_idLevel_3,
				SALUD_idLevel_4,SALUD_idLevel_5,SEGURIDAD_idCentroCosto,SEGURIDAD_idLevel_1,SEGURIDAD_idLevel_2,
				SEGURIDAD_idLevel_3,SEGURIDAD_idLevel_4,SEGURIDAD_idLevel_5';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_leyes_sociales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'?created=true' );
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
			if(isset($idSistema)&&isset($idMantenedor)){
				$ndata_1 = db_select_nrows (false, 'idSistema', 'sistema_leyes_sociales', '', "idSistema='".$idSistema."' AND idMantenedor!='".$idMantenedor."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El dato ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idMantenedor='".$idMantenedor."'";
				if(isset($idSistema) && $idSistema!=''){                                   $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($AFP_idCentroCosto) && $AFP_idCentroCosto!=''){                   $SIS_data .= ",AFP_idCentroCosto='".$AFP_idCentroCosto."'";}
				if(isset($AFP_idLevel_1) && $AFP_idLevel_1!=''){                           $SIS_data .= ",AFP_idLevel_1='".$AFP_idLevel_1."'";}
				if(isset($AFP_idLevel_2) && $AFP_idLevel_2!=''){                           $SIS_data .= ",AFP_idLevel_2='".$AFP_idLevel_2."'";}
				if(isset($AFP_idLevel_3) && $AFP_idLevel_3!=''){                           $SIS_data .= ",AFP_idLevel_3='".$AFP_idLevel_3."'";}
				if(isset($AFP_idLevel_4) && $AFP_idLevel_4!=''){                           $SIS_data .= ",AFP_idLevel_4='".$AFP_idLevel_4."'";}
				if(isset($AFP_idLevel_5) && $AFP_idLevel_5!=''){                           $SIS_data .= ",AFP_idLevel_5='".$AFP_idLevel_5."'";}
				if(isset($SALUD_idCentroCosto) && $SALUD_idCentroCosto!=''){               $SIS_data .= ",SALUD_idCentroCosto='".$SALUD_idCentroCosto."'";}
				if(isset($SALUD_idLevel_1) && $SALUD_idLevel_1!=''){                       $SIS_data .= ",SALUD_idLevel_1='".$SALUD_idLevel_1."'";}
				if(isset($SALUD_idLevel_2) && $SALUD_idLevel_2!=''){                       $SIS_data .= ",SALUD_idLevel_2='".$SALUD_idLevel_2."'";}
				if(isset($SALUD_idLevel_3) && $SALUD_idLevel_3!=''){                       $SIS_data .= ",SALUD_idLevel_3='".$SALUD_idLevel_3."'";}
				if(isset($SALUD_idLevel_4) && $SALUD_idLevel_4!=''){                       $SIS_data .= ",SALUD_idLevel_4='".$SALUD_idLevel_4."'";}
				if(isset($SALUD_idLevel_5) && $SALUD_idLevel_5!=''){                       $SIS_data .= ",SALUD_idLevel_5='".$SALUD_idLevel_5."'";}
				if(isset($SEGURIDAD_idCentroCosto) && $SEGURIDAD_idCentroCosto!=''){       $SIS_data .= ",SEGURIDAD_idCentroCosto='".$SEGURIDAD_idCentroCosto."'";}
				if(isset($SEGURIDAD_idLevel_1) && $SEGURIDAD_idLevel_1!=''){               $SIS_data .= ",SEGURIDAD_idLevel_1='".$SEGURIDAD_idLevel_1."'";}
				if(isset($SEGURIDAD_idLevel_2) && $SEGURIDAD_idLevel_2!=''){               $SIS_data .= ",SEGURIDAD_idLevel_2='".$SEGURIDAD_idLevel_2."'";}
				if(isset($SEGURIDAD_idLevel_3) && $SEGURIDAD_idLevel_3!=''){               $SIS_data .= ",SEGURIDAD_idLevel_3='".$SEGURIDAD_idLevel_3."'";}
				if(isset($SEGURIDAD_idLevel_4) && $SEGURIDAD_idLevel_4!=''){               $SIS_data .= ",SEGURIDAD_idLevel_4='".$SEGURIDAD_idLevel_4."'";}
				if(isset($SEGURIDAD_idLevel_5) && $SEGURIDAD_idLevel_5!=''){               $SIS_data .= ",SEGURIDAD_idLevel_5='".$SEGURIDAD_idLevel_5."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_leyes_sociales', 'idMantenedor = "'.$idMantenedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'?edited=true' );
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
				$resultado = db_delete_data (false, 'sistema_leyes_sociales', 'idMantenedor = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'?deleted=true' );
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
