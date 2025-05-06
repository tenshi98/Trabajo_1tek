<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-143).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idMantenedor']))             $idMantenedor             = $_POST['idMantenedor'];
	if (!empty($_POST['idSistema']))                $idSistema                = $_POST['idSistema'];
	if (!empty($_POST['Porcentaje_PPM']))           $Porcentaje_PPM           = $_POST['Porcentaje_PPM'];
	if (!empty($_POST['IVA_idCentroCosto']))        $IVA_idCentroCosto        = $_POST['IVA_idCentroCosto'];
	if (!empty($_POST['IVA_idLevel_1']))            $IVA_idLevel_1            = $_POST['IVA_idLevel_1'];
	if (!empty($_POST['IVA_idLevel_2']))            $IVA_idLevel_2            = $_POST['IVA_idLevel_2'];
	if (!empty($_POST['IVA_idLevel_3']))            $IVA_idLevel_3            = $_POST['IVA_idLevel_3'];
	if (!empty($_POST['IVA_idLevel_4']))            $IVA_idLevel_4            = $_POST['IVA_idLevel_4'];
	if (!empty($_POST['IVA_idLevel_5']))            $IVA_idLevel_5            = $_POST['IVA_idLevel_5'];
	if (!empty($_POST['PPM_idCentroCosto']))        $PPM_idCentroCosto        = $_POST['PPM_idCentroCosto'];
	if (!empty($_POST['PPM_idLevel_1']))            $PPM_idLevel_1            = $_POST['PPM_idLevel_1'];
	if (!empty($_POST['PPM_idLevel_2']))            $PPM_idLevel_2            = $_POST['PPM_idLevel_2'];
	if (!empty($_POST['PPM_idLevel_3']))            $PPM_idLevel_3            = $_POST['PPM_idLevel_3'];
	if (!empty($_POST['PPM_idLevel_4']))            $PPM_idLevel_4            = $_POST['PPM_idLevel_4'];
	if (!empty($_POST['PPM_idLevel_5']))            $PPM_idLevel_5            = $_POST['PPM_idLevel_5'];
	if (!empty($_POST['RET_idCentroCosto']))        $RET_idCentroCosto        = $_POST['RET_idCentroCosto'];
	if (!empty($_POST['RET_idLevel_1']))            $RET_idLevel_1            = $_POST['RET_idLevel_1'];
	if (!empty($_POST['RET_idLevel_2']))            $RET_idLevel_2            = $_POST['RET_idLevel_2'];
	if (!empty($_POST['RET_idLevel_3']))            $RET_idLevel_3            = $_POST['RET_idLevel_3'];
	if (!empty($_POST['RET_idLevel_4']))            $RET_idLevel_4            = $_POST['RET_idLevel_4'];
	if (!empty($_POST['RET_idLevel_5']))            $RET_idLevel_5            = $_POST['RET_idLevel_5'];
	if (!empty($_POST['IMPRENT_idCentroCosto']))    $IMPRENT_idCentroCosto    = $_POST['IMPRENT_idCentroCosto'];
	if (!empty($_POST['IMPRENT_idLevel_1']))        $IMPRENT_idLevel_1        = $_POST['IMPRENT_idLevel_1'];
	if (!empty($_POST['IMPRENT_idLevel_2']))        $IMPRENT_idLevel_2        = $_POST['IMPRENT_idLevel_2'];
	if (!empty($_POST['IMPRENT_idLevel_3']))        $IMPRENT_idLevel_3        = $_POST['IMPRENT_idLevel_3'];
	if (!empty($_POST['IMPRENT_idLevel_4']))        $IMPRENT_idLevel_4        = $_POST['IMPRENT_idLevel_4'];
	if (!empty($_POST['IMPRENT_idLevel_5']))        $IMPRENT_idLevel_5        = $_POST['IMPRENT_idLevel_5'];
	if (!empty($_POST['Porcentaje_Ret_Boletas']))   $Porcentaje_Ret_Boletas   = $_POST['Porcentaje_Ret_Boletas'];

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
			case 'idMantenedor':             if(empty($idMantenedor)){             $error['idMantenedor']              = 'error/No ha ingresado el id';}break;
			case 'idSistema':                if(empty($idSistema)){                $error['idSistema']                 = 'error/No ha ingresado el Sistema';}break;
			case 'Porcentaje_PPM':           if(empty($Porcentaje_PPM)){           $error['Porcentaje_PPM']            = 'error/No ha ingresado el Porcentaje PPM';}break;
			case 'IVA_idCentroCosto':        if(empty($IVA_idCentroCosto)){        $error['IVA_idCentroCosto']         = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'IVA_idLevel_1':            if(empty($IVA_idLevel_1)){            $error['IVA_idLevel_1']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'IVA_idLevel_2':            if(empty($IVA_idLevel_2)){            $error['IVA_idLevel_2']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'IVA_idLevel_3':            if(empty($IVA_idLevel_3)){            $error['IVA_idLevel_3']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'IVA_idLevel_4':            if(empty($IVA_idLevel_4)){            $error['IVA_idLevel_4']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'IVA_idLevel_5':            if(empty($IVA_idLevel_5)){            $error['IVA_idLevel_5']             = 'error/No ha ingresado el Centro de Costo del IVA';}break;
			case 'PPM_idCentroCosto':        if(empty($PPM_idCentroCosto)){        $error['PPM_idCentroCosto']         = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'PPM_idLevel_1':            if(empty($PPM_idLevel_1)){            $error['PPM_idLevel_1']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'PPM_idLevel_2':            if(empty($PPM_idLevel_2)){            $error['PPM_idLevel_2']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'PPM_idLevel_3':            if(empty($PPM_idLevel_3)){            $error['PPM_idLevel_3']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'PPM_idLevel_4':            if(empty($PPM_idLevel_4)){            $error['PPM_idLevel_4']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'PPM_idLevel_5':            if(empty($PPM_idLevel_5)){            $error['PPM_idLevel_5']             = 'error/No ha ingresado el Centro de Costo del PPM';}break;
			case 'RET_idCentroCosto':        if(empty($RET_idCentroCosto)){        $error['RET_idCentroCosto']         = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'RET_idLevel_1':            if(empty($RET_idLevel_1)){            $error['RET_idLevel_1']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'RET_idLevel_2':            if(empty($RET_idLevel_2)){            $error['RET_idLevel_2']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'RET_idLevel_3':            if(empty($RET_idLevel_3)){            $error['RET_idLevel_3']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'RET_idLevel_4':            if(empty($RET_idLevel_4)){            $error['RET_idLevel_4']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'RET_idLevel_5':            if(empty($RET_idLevel_5)){            $error['RET_idLevel_5']             = 'error/No ha ingresado el Centro de Costo de las Retenciones';}break;
			case 'IMPRENT_idCentroCosto':    if(empty($IMPRENT_idCentroCosto)){    $error['IMPRENT_idCentroCosto']     = 'error/No ha ingresado el Centro de Costo del Impuesto a la Renta';}break;
			case 'IMPRENT_idLevel_1':        if(empty($IMPRENT_idLevel_1)){        $error['IMPRENT_idLevel_1']         = 'error/No ha ingresado el Centro de Costo del Impuesto a la Renta';}break;
			case 'IMPRENT_idLevel_2':        if(empty($IMPRENT_idLevel_2)){        $error['IMPRENT_idLevel_2']         = 'error/No ha ingresado el Centro de Costo del Impuesto a la Renta';}break;
			case 'IMPRENT_idLevel_3':        if(empty($IMPRENT_idLevel_3)){        $error['IMPRENT_idLevel_3']         = 'error/No ha ingresado el Centro de Costo del Impuesto a la Renta';}break;
			case 'IMPRENT_idLevel_4':        if(empty($IMPRENT_idLevel_4)){        $error['IMPRENT_idLevel_4']         = 'error/No ha ingresado el Centro de Costo del Impuesto a la Renta';}break;
			case 'IMPRENT_idLevel_5':        if(empty($IMPRENT_idLevel_5)){        $error['IMPRENT_idLevel_5']         = 'error/No ha ingresado el Centro de Costo del Impuesto a la Renta';}break;
			case 'Porcentaje_Ret_Boletas':   if(empty($Porcentaje_Ret_Boletas)){   $error['Porcentaje_Ret_Boletas']    = 'error/No ha ingresado el Porcentaje de la Retencion en las Boletas de Honorarios';}break;

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
				$ndata_1 = db_select_nrows (false, 'idSistema', 'sistema_leyes_fiscales', '', "idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El dato ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                             $SIS_data  = "'".$idSistema."'";                    }else{$SIS_data  = "''";}
				if(isset($Porcentaje_PPM) && $Porcentaje_PPM!=''){                   $SIS_data .= ",'".$Porcentaje_PPM."'";              }else{$SIS_data .= ",''";}
				if(isset($IVA_idCentroCosto) && $IVA_idCentroCosto!=''){             $SIS_data .= ",'".$IVA_idCentroCosto."'";           }else{$SIS_data .= ",''";}
				if(isset($IVA_idLevel_1) && $IVA_idLevel_1!=''){                     $SIS_data .= ",'".$IVA_idLevel_1."'";               }else{$SIS_data .= ",''";}
				if(isset($IVA_idLevel_2) && $IVA_idLevel_2!=''){                     $SIS_data .= ",'".$IVA_idLevel_2."'";               }else{$SIS_data .= ",''";}
				if(isset($IVA_idLevel_3) && $IVA_idLevel_3!=''){                     $SIS_data .= ",'".$IVA_idLevel_3."'";               }else{$SIS_data .= ",''";}
				if(isset($IVA_idLevel_4) && $IVA_idLevel_4!=''){                     $SIS_data .= ",'".$IVA_idLevel_4."'";               }else{$SIS_data .= ",''";}
				if(isset($IVA_idLevel_5) && $IVA_idLevel_5!=''){                     $SIS_data .= ",'".$IVA_idLevel_5."'";               }else{$SIS_data .= ",''";}
				if(isset($PPM_idCentroCosto) && $PPM_idCentroCosto!=''){             $SIS_data .= ",'".$PPM_idCentroCosto."'";           }else{$SIS_data .= ",''";}
				if(isset($PPM_idLevel_1) && $PPM_idLevel_1!=''){                     $SIS_data .= ",'".$PPM_idLevel_1."'";               }else{$SIS_data .= ",''";}
				if(isset($PPM_idLevel_2) && $PPM_idLevel_2!=''){                     $SIS_data .= ",'".$PPM_idLevel_2."'";               }else{$SIS_data .= ",''";}
				if(isset($PPM_idLevel_3) && $PPM_idLevel_3!=''){                     $SIS_data .= ",'".$PPM_idLevel_3."'";               }else{$SIS_data .= ",''";}
				if(isset($PPM_idLevel_4) && $PPM_idLevel_4!=''){                     $SIS_data .= ",'".$PPM_idLevel_4."'";               }else{$SIS_data .= ",''";}
				if(isset($PPM_idLevel_5) && $PPM_idLevel_5!=''){                     $SIS_data .= ",'".$PPM_idLevel_5."'";               }else{$SIS_data .= ",''";}
				if(isset($RET_idCentroCosto) && $RET_idCentroCosto!=''){             $SIS_data .= ",'".$RET_idCentroCosto."'";           }else{$SIS_data .= ",''";}
				if(isset($RET_idLevel_1) && $RET_idLevel_1!=''){                     $SIS_data .= ",'".$RET_idLevel_1."'";               }else{$SIS_data .= ",''";}
				if(isset($RET_idLevel_2) && $RET_idLevel_2!=''){                     $SIS_data .= ",'".$RET_idLevel_2."'";               }else{$SIS_data .= ",''";}
				if(isset($RET_idLevel_3) && $RET_idLevel_3!=''){                     $SIS_data .= ",'".$RET_idLevel_3."'";               }else{$SIS_data .= ",''";}
				if(isset($RET_idLevel_4) && $RET_idLevel_4!=''){                     $SIS_data .= ",'".$RET_idLevel_4."'";               }else{$SIS_data .= ",''";}
				if(isset($RET_idLevel_5) && $RET_idLevel_5!=''){                     $SIS_data .= ",'".$RET_idLevel_5."'";               }else{$SIS_data .= ",''";}
				if(isset($IMPRENT_idCentroCosto) && $IMPRENT_idCentroCosto!=''){     $SIS_data .= ",'".$IMPRENT_idCentroCosto."'";       }else{$SIS_data .= ",''";}
				if(isset($IMPRENT_idLevel_1) && $IMPRENT_idLevel_1!=''){             $SIS_data .= ",'".$IMPRENT_idLevel_1."'";           }else{$SIS_data .= ",''";}
				if(isset($IMPRENT_idLevel_2) && $IMPRENT_idLevel_2!=''){             $SIS_data .= ",'".$IMPRENT_idLevel_2."'";           }else{$SIS_data .= ",''";}
				if(isset($IMPRENT_idLevel_3) && $IMPRENT_idLevel_3!=''){             $SIS_data .= ",'".$IMPRENT_idLevel_3."'";           }else{$SIS_data .= ",''";}
				if(isset($IMPRENT_idLevel_4) && $IMPRENT_idLevel_4!=''){             $SIS_data .= ",'".$IMPRENT_idLevel_4."'";           }else{$SIS_data .= ",''";}
				if(isset($IMPRENT_idLevel_5) && $IMPRENT_idLevel_5!=''){             $SIS_data .= ",'".$IMPRENT_idLevel_5."'";           }else{$SIS_data .= ",''";}
				if(isset($Porcentaje_Ret_Boletas) && $Porcentaje_Ret_Boletas!=''){   $SIS_data .= ",'".$Porcentaje_Ret_Boletas."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Porcentaje_PPM
				IVA_idCentroCosto,IVA_idLevel_1,IVA_idLevel_2,IVA_idLevel_3,IVA_idLevel_4,
				IVA_idLevel_5,PPM_idCentroCosto,PPM_idLevel_1,PPM_idLevel_2,PPM_idLevel_3,
				PPM_idLevel_4,PPM_idLevel_5,RET_idCentroCosto,RET_idLevel_1,RET_idLevel_2,
				RET_idLevel_3,RET_idLevel_4,RET_idLevel_5,IMPRENT_idCentroCosto,
				IMPRENT_idLevel_1,IMPRENT_idLevel_2,IMPRENT_idLevel_3,IMPRENT_idLevel_4,
				IMPRENT_idLevel_5, Porcentaje_Ret_Boletas';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_leyes_fiscales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$ndata_1 = db_select_nrows (false, 'idSistema', 'sistema_leyes_fiscales', '', "idSistema='".$idSistema."' AND idMantenedor!='".$idMantenedor."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El dato ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idMantenedor='".$idMantenedor."'";
				if(isset($idSistema) && $idSistema!=''){                               $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Porcentaje_PPM) && $Porcentaje_PPM!=''){                     $SIS_data .= ",Porcentaje_PPM='".$Porcentaje_PPM."'";}
				if(isset($IVA_idCentroCosto) && $IVA_idCentroCosto!=''){               $SIS_data .= ",IVA_idCentroCosto='".$IVA_idCentroCosto."'";}
				if(isset($IVA_idLevel_1) && $IVA_idLevel_1!=''){                       $SIS_data .= ",IVA_idLevel_1='".$IVA_idLevel_1."'";}
				if(isset($IVA_idLevel_2) && $IVA_idLevel_2!=''){                       $SIS_data .= ",IVA_idLevel_2='".$IVA_idLevel_2."'";}
				if(isset($IVA_idLevel_3) && $IVA_idLevel_3!=''){                       $SIS_data .= ",IVA_idLevel_3='".$IVA_idLevel_3."'";}
				if(isset($IVA_idLevel_4) && $IVA_idLevel_4!=''){                       $SIS_data .= ",IVA_idLevel_4='".$IVA_idLevel_4."'";}
				if(isset($IVA_idLevel_5) && $IVA_idLevel_5!=''){                       $SIS_data .= ",IVA_idLevel_5='".$IVA_idLevel_5."'";}
				if(isset($PPM_idCentroCosto) && $PPM_idCentroCosto!=''){               $SIS_data .= ",PPM_idCentroCosto='".$PPM_idCentroCosto."'";}
				if(isset($PPM_idLevel_1) && $PPM_idLevel_1!=''){                       $SIS_data .= ",PPM_idLevel_1='".$PPM_idLevel_1."'";}
				if(isset($PPM_idLevel_2) && $PPM_idLevel_2!=''){                       $SIS_data .= ",PPM_idLevel_2='".$PPM_idLevel_2."'";}
				if(isset($PPM_idLevel_3) && $PPM_idLevel_3!=''){                       $SIS_data .= ",PPM_idLevel_3='".$PPM_idLevel_3."'";}
				if(isset($PPM_idLevel_4) && $PPM_idLevel_4!=''){                       $SIS_data .= ",PPM_idLevel_4='".$PPM_idLevel_4."'";}
				if(isset($PPM_idLevel_5) && $PPM_idLevel_5!=''){                       $SIS_data .= ",PPM_idLevel_5='".$PPM_idLevel_5."'";}
				if(isset($RET_idCentroCosto) && $RET_idCentroCosto!=''){               $SIS_data .= ",RET_idCentroCosto='".$RET_idCentroCosto."'";}
				if(isset($RET_idLevel_1) && $RET_idLevel_1!=''){                       $SIS_data .= ",RET_idLevel_1='".$RET_idLevel_1."'";}
				if(isset($RET_idLevel_2) && $RET_idLevel_2!=''){                       $SIS_data .= ",RET_idLevel_2='".$RET_idLevel_2."'";}
				if(isset($RET_idLevel_3) && $RET_idLevel_3!=''){                       $SIS_data .= ",RET_idLevel_3='".$RET_idLevel_3."'";}
				if(isset($RET_idLevel_4) && $RET_idLevel_4!=''){                       $SIS_data .= ",RET_idLevel_4='".$RET_idLevel_4."'";}
				if(isset($RET_idLevel_5) && $RET_idLevel_5!=''){                       $SIS_data .= ",RET_idLevel_5='".$RET_idLevel_5."'";}
				if(isset($IMPRENT_idCentroCosto) && $IMPRENT_idCentroCosto!=''){       $SIS_data .= ",IMPRENT_idCentroCosto='".$IMPRENT_idCentroCosto."'";}
				if(isset($IMPRENT_idLevel_1) && $IMPRENT_idLevel_1!=''){               $SIS_data .= ",IMPRENT_idLevel_1='".$IMPRENT_idLevel_1."'";}
				if(isset($IMPRENT_idLevel_2) && $IMPRENT_idLevel_2!=''){               $SIS_data .= ",IMPRENT_idLevel_2='".$IMPRENT_idLevel_2."'";}
				if(isset($IMPRENT_idLevel_3) && $IMPRENT_idLevel_3!=''){               $SIS_data .= ",IMPRENT_idLevel_3='".$IMPRENT_idLevel_3."'";}
				if(isset($IMPRENT_idLevel_4) && $IMPRENT_idLevel_4!=''){               $SIS_data .= ",IMPRENT_idLevel_4='".$IMPRENT_idLevel_4."'";}
				if(isset($IMPRENT_idLevel_5) && $IMPRENT_idLevel_5!=''){               $SIS_data .= ",IMPRENT_idLevel_5='".$IMPRENT_idLevel_5."'";}
				if(isset($Porcentaje_Ret_Boletas) && $Porcentaje_Ret_Boletas!=''){     $SIS_data .= ",Porcentaje_Ret_Boletas='".$Porcentaje_Ret_Boletas."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_leyes_fiscales', 'idMantenedor = "'.$idMantenedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sistema_leyes_fiscales', 'idMantenedor = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
