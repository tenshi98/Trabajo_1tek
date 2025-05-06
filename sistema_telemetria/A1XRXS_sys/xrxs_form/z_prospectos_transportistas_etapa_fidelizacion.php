<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-266).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idEtapaFide']))    $idEtapaFide     = $_POST['idEtapaFide'];
	if (!empty($_POST['idProspecto']))    $idProspecto     = $_POST['idProspecto'];
	if (!empty($_POST['idUsuario']))      $idUsuario       = $_POST['idUsuario'];
	if (!empty($_POST['idEtapa']))        $idEtapa         = $_POST['idEtapa'];
	if (!empty($_POST['Fecha']))          $Fecha           = $_POST['Fecha'];
	if (!empty($_POST['Observacion']))    $Observacion     = $_POST['Observacion'];

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
			case 'idEtapaFide':    if(empty($idEtapaFide)){     $error['idEtapaFide']    = 'error/No ha ingresado el id';}break;
			case 'idProspecto':    if(empty($idProspecto)){     $error['idProspecto']    = 'error/No ha seleccionado el prospecto';}break;
			case 'idUsuario':      if(empty($idUsuario)){       $error['idUsuario']      = 'error/No ha seleccionado un usuario';}break;
			case 'idEtapa':        if(empty($idEtapa)){         $error['idEtapa']        = 'error/No ha seleccionado una etapa';}break;
			case 'Fecha':          if(empty($Fecha)){           $error['Fecha']          = 'error/No ha ingresado la fecha';}break;
			case 'Observacion':    if(empty($Observacion)){     $error['Observacion']    = 'error/No ha ingresado la observacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observacion) && $Observacion!=''){ $Observacion = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){  $error['Observacion'] = 'error/Edita Observacion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idProspecto) && $idProspecto!=''){ $SIS_data  = "'".$idProspecto."'";    }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){     $SIS_data .= ",'".$idUsuario."'";     }else{$SIS_data .= ",''";}
				if(isset($idEtapa) && $idEtapa!=''){         $SIS_data .= ",'".$idEtapa."'";       }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){             $SIS_data .= ",'".$Fecha."'";         }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){ $SIS_data .= ",'".$Observacion."'";   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idProspecto, idUsuario, idEtapa, Fecha, Observacion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'prospectos_transportistas_etapa_fidelizacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					//Actualizo los datos
					$SIS_data = "idProspecto='".$idProspecto."'";
					if(isset($idEtapa) && $idEtapa!= ''){  $SIS_data .= ",idEtapa='".$idEtapa."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){
						//redirijo
						header( 'Location: '.$location.'&created=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEtapaFide='".$idEtapaFide."'";
				if(isset($idProspecto) && $idProspecto!=''){   $SIS_data .= ",idProspecto='".$idProspecto."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEtapa) && $idEtapa!=''){           $SIS_data .= ",idEtapa='".$idEtapa."'";}
				if(isset($Fecha) && $Fecha!=''){               $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($Observacion) && $Observacion!=''){   $SIS_data .= ",Observacion='".$Observacion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'prospectos_transportistas_etapa_fidelizacion', 'idEtapaFide = "'.$idEtapaFide.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Actualizo los datos
					$SIS_data = "idProspecto='".$idProspecto."'";
					if(isset($idEtapa) && $idEtapa!= ''){  $SIS_data .= ",idEtapa='".$idEtapa."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado2 = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado2==true){
						//redirijo
						header( 'Location: '.$location.'&edited=true' );
						die;
					}
				}
			}

		break;

/*******************************************************************************************************************/
	}

?>
