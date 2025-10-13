<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-274).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idTablaImpuesto']))   $idTablaImpuesto   = $_POST['idTablaImpuesto'];
	if (!empty($_POST['Tramo']))             $Tramo             = $_POST['Tramo'];
	if ( isset($_POST['UTM_Desde']))         $UTM_Desde         = $_POST['UTM_Desde'];
	if ( isset($_POST['UTM_Hasta']))         $UTM_Hasta         = $_POST['UTM_Hasta'];
	if ( isset($_POST['Tasa']))              $Tasa              = $_POST['Tasa'];
	if ( isset($_POST['Rebaja']))            $Rebaja            = $_POST['Rebaja'];

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
			case 'idTablaImpuesto':  if(empty($idTablaImpuesto)){    $error['idTablaImpuesto']  = 'error/No ha ingresado el id';}break;
			case 'Tramo':            if(empty($Tramo)){              $error['Tramo']            = 'error/No ha ingresado el nombre del Tramo';}break;
			case 'UTM_Desde':        if(!isset($UTM_Desde)){         $error['UTM_Desde']        = 'error/No ha ingresado la cantidad desde';}break;
			case 'UTM_Hasta':        if(!isset($UTM_Hasta)){         $error['UTM_Hasta']        = 'error/No ha ingresado la cantidad hasta';}break;
			case 'Tasa':             if(!isset($Tasa)){              $error['Tasa']             = 'error/No ha ingresado la tasa';}break;
			case 'Rebaja':           if(!isset($Rebaja)){            $error['Rebaja']           = 'error/No ha ingresado la rebaja';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Tramo) && $Tramo!=''){ $Tramo = EstandarizarInput($Tramo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Tramo)&&contar_palabras_censuradas($Tramo)!=0){  $error['Tramo'] = 'error/Edita Tramo, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Tramo)&&isset($idTablaImpuesto)){
				$ndata_1 = db_select_nrows (false, 'Tramo', 'sistema_rrhh_tabla_iusc', '', "Tramo='".$Tramo."' AND idTablaImpuesto!='".$idTablaImpuesto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idTablaImpuesto='".$idTablaImpuesto."'";
				if(isset($Tramo) && $Tramo!=''){          $SIS_data .= ",Tramo='".$Tramo."'";}
				if(isset($UTM_Desde) && $UTM_Desde!=''){  $SIS_data .= ",UTM_Desde='".$UTM_Desde."'";}
				if(isset($UTM_Hasta) && $UTM_Hasta!=''){  $SIS_data .= ",UTM_Hasta='".$UTM_Hasta."'";}
				if(isset($Tasa) && $Tasa!=''){            $SIS_data .= ",Tasa='".$Tasa."'";}
				if(isset($Rebaja) && $Rebaja!=''){        $SIS_data .= ",Rebaja='".$Rebaja."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_rrhh_tabla_iusc', 'idTablaImpuesto = "'.$idTablaImpuesto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'?edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
	}

?>
