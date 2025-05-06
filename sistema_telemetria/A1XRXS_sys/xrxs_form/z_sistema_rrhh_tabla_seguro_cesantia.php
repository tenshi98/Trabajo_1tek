<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-275).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idTablaSeguro']))   $idTablaSeguro     = $_POST['idTablaSeguro'];
	if (!empty($_POST['idTipoContrato']))  $idTipoContrato    = $_POST['idTipoContrato'];
	if ( isset($_POST['Porc_Empleador']))  $Porc_Empleador    = $_POST['Porc_Empleador'];
	if ( isset($_POST['Porc_Trabajador'])) $Porc_Trabajador   = $_POST['Porc_Trabajador'];

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
			case 'idTablaSeguro':     if(empty($idTablaSeguro)){      $error['idTablaSeguro']     = 'error/No ha ingresado el id';}break;
			case 'idTipoContrato':    if(empty($idTipoContrato)){     $error['idTipoContrato']    = 'error/No ha seleccionado el tipo de contrato';}break;
			case 'Porc_Empleador':    if(!isset($Porc_Empleador)){    $error['Porc_Empleador']    = 'error/No ha ingresado el porcentaje del empleador';}break;
			case 'Porc_Trabajador':   if(!isset($Porc_Trabajador)){   $error['Porc_Trabajador']   = 'error/No ha ingresado el porcentaje del trabajador';}break;

		}
	}

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
			if(isset($idTipoContrato)&&isset($idTablaSeguro)){
				$ndata_1 = db_select_nrows (false, 'idTipoContrato', 'sistema_rrhh_tabla_seguro_cesantia', '', "idTipoContrato='".$idTipoContrato."' AND idTablaSeguro!='".$idTablaSeguro."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idTablaSeguro='".$idTablaSeguro."'";
				if(isset($idTipoContrato) && $idTipoContrato!=''){    $SIS_data .= ",idTipoContrato='".$idTipoContrato."'";}
				if(isset($Porc_Empleador) && $Porc_Empleador!=''){    $SIS_data .= ",Porc_Empleador='".$Porc_Empleador."'";}
				if(isset($Porc_Trabajador) && $Porc_Trabajador!=''){  $SIS_data .= ",Porc_Trabajador='".$Porc_Trabajador."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sistema_rrhh_tabla_seguro_cesantia', 'idTablaSeguro = "'.$idTablaSeguro.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
