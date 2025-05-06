<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-094).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idVehiculos']))                $idVehiculos                = $_POST['idVehiculos'];
	if (!empty($_POST['idPersona']))                  $idPersona                  = $_POST['idPersona'];
	if (!empty($_POST['Patente']))                    $Patente                    = $_POST['Patente'];
	if (!empty($_POST['Marca']))                      $Marca                      = $_POST['Marca'];
	if (!empty($_POST['Modelo']))                     $Modelo                     = $_POST['Modelo'];
	if (!empty($_POST['Color']))                      $Color                      = $_POST['Color'];
	if (!empty($_POST['Tipo']))                       $Tipo                       = $_POST['Tipo'];
	if (!empty($_POST['AnoFabricacion']))             $AnoFabricacion             = $_POST['AnoFabricacion'];
	if (!empty($_POST['RenovacionPatente']))          $RenovacionPatente          = $_POST['RenovacionPatente'];
	if (!empty($_POST['UltimaTransferencia']))        $UltimaTransferencia        = $_POST['UltimaTransferencia'];
	if (!empty($_POST['NumeroMotor']))                $NumeroMotor                = $_POST['NumeroMotor'];
	if (!empty($_POST['NumeroChasis']))               $NumeroChasis               = $_POST['NumeroChasis'];
	if (!empty($_POST['Tasacion']))                   $Tasacion                   = $_POST['Tasacion'];
	if (!empty($_POST['RevisionTecnica']))            $RevisionTecnica            = $_POST['RevisionTecnica'];
	if (!empty($_POST['PlantaRevisionTecnica']))      $PlantaRevisionTecnica      = $_POST['PlantaRevisionTecnica'];
	if (!empty($_POST['FechaRevision']))              $FechaRevision              = $_POST['FechaRevision'];
	if (!empty($_POST['NumeroCertificado']))          $NumeroCertificado          = $_POST['NumeroCertificado'];

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
			case 'idVehiculos':                if(empty($idVehiculos)){              $error['idVehiculos']              = 'error/No ha ingresado el id';}break;
			case 'idPersona':                  if(empty($idPersona)){                $error['idPersona']                = 'error/No ha seleccionado la persona relacionada';}break;
			case 'Patente':                    if(empty($Patente)){                  $error['Patente']                  = 'error/No ha ingresado la Patente';}break;
			case 'Marca':                      if(empty($Marca)){                    $error['Marca']                    = 'error/No ha ingresado la Marca';}break;
			case 'Modelo':                     if(empty($Modelo)){                   $error['Modelo']                   = 'error/No ha ingresado el Modelo';}break;
			case 'Color':                      if(empty($Color)){                    $error['Color']                    = 'error/No ha ingresado el Color';}break;
			case 'Tipo':                       if(empty($Tipo)){                     $error['Tipo']                     = 'error/No ha ingresado el Tipo Vehiculo';}break;
			case 'AnoFabricacion':             if(empty($AnoFabricacion)){           $error['AnoFabricacion']           = 'error/No ha ingresado el Año de Fabricacion';}break;
			case 'RenovacionPatente':          if(empty($RenovacionPatente)){        $error['RenovacionPatente']        = 'error/No ha ingresado la Renovacion Patente';}break;
			case 'UltimaTransferencia':        if(empty($UltimaTransferencia)){      $error['UltimaTransferencia']      = 'error/No ha ingresado la Ultima Transferencia';}break;
			case 'NumeroMotor':                if(empty($NumeroMotor)){              $error['NumeroMotor']              = 'error/No ha ingresado el Numero de Motor';}break;
			case 'NumeroChasis':               if(empty($NumeroChasis)){             $error['NumeroChasis']             = 'error/No ha ingresado el Numero de Chasis';}break;
			case 'Tasacion':                   if(empty($Tasacion)){                 $error['Tasacion']                 = 'error/No ha ingresado la Tasacion';}break;
			case 'RevisionTecnica':            if(empty($RevisionTecnica)){          $error['RevisionTecnica']          = 'error/No ha ingresado la RevisionTecnica';}break;
			case 'PlantaRevisionTecnica':      if(empty($PlantaRevisionTecnica)){    $error['PlantaRevisionTecnica']    = 'error/No ha ingresado la Planta de Revision Tecnica';}break;
			case 'FechaRevision':              if(empty($FechaRevision)){            $error['FechaRevision']            = 'error/No ha ingresado la Fecha de Revision';}break;
			case 'NumeroCertificado':          if(empty($NumeroCertificado)){        $error['NumeroCertificado']        = 'error/No ha ingresado el Numero de Certificado';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Patente) && $Patente!=''){                              $Patente                = EstandarizarInput($Patente);}
	if(isset($Marca) && $Marca!=''){                                  $Marca                  = EstandarizarInput($Marca);}
	if(isset($Modelo) && $Modelo!=''){                                $Modelo                 = EstandarizarInput($Modelo);}
	if(isset($Color) && $Color!=''){                                  $Color                  = EstandarizarInput($Color);}
	if(isset($Tipo) && $Tipo!=''){                                    $Tipo                   = EstandarizarInput($Tipo);}
	if(isset($NumeroMotor) && $NumeroMotor!=''){                      $NumeroMotor            = EstandarizarInput($NumeroMotor);}
	if(isset($NumeroChasis) && $NumeroChasis!=''){                    $NumeroChasis           = EstandarizarInput($NumeroChasis);}
	if(isset($RevisionTecnica) && $RevisionTecnica!=''){              $RevisionTecnica        = EstandarizarInput($RevisionTecnica);}
	if(isset($PlantaRevisionTecnica) && $PlantaRevisionTecnica!=''){  $PlantaRevisionTecnica  = EstandarizarInput($PlantaRevisionTecnica);}
	if(isset($NumeroCertificado) && $NumeroCertificado!=''){          $NumeroCertificado      = EstandarizarInput($NumeroCertificado);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($Patente)&&contar_palabras_censuradas($Patente)!=0){                               $error['Patente']               = 'error/Edita Patente, contiene palabras no permitidas';}
	if(isset($Marca)&&contar_palabras_censuradas($Marca)!=0){                                   $error['Marca']                 = 'error/Edita Marca, contiene palabras no permitidas';}
	if(isset($Modelo)&&contar_palabras_censuradas($Modelo)!=0){                                 $error['Modelo']                = 'error/Edita Modelo, contiene palabras no permitidas';}
	if(isset($Color)&&contar_palabras_censuradas($Color)!=0){                                   $error['Color']                 = 'error/Edita Color, contiene palabras no permitidas';}
	if(isset($Tipo)&&contar_palabras_censuradas($Tipo)!=0){                                     $error['Tipo']                  = 'error/Edita Tipo, contiene palabras no permitidas';}
	if(isset($NumeroMotor)&&contar_palabras_censuradas($NumeroMotor)!=0){                       $error['NumeroMotor']           = 'error/Edita Numero Motor, contiene palabras no permitidas';}
	if(isset($NumeroChasis)&&contar_palabras_censuradas($NumeroChasis)!=0){                     $error['NumeroChasis']          = 'error/Edita Numero Chasis, contiene palabras no permitidas';}
	if(isset($RevisionTecnica)&&contar_palabras_censuradas($RevisionTecnica)!=0){               $error['RevisionTecnica']       = 'error/Edita Revision Tecnica, contiene palabras no permitidas';}
	if(isset($PlantaRevisionTecnica)&&contar_palabras_censuradas($PlantaRevisionTecnica)!=0){   $error['PlantaRevisionTecnica'] = 'error/Edita Planta Revision Tecnica, contiene palabras no permitidas';}
	if(isset($NumeroCertificado)&&contar_palabras_censuradas($NumeroCertificado)!=0){           $error['NumeroCertificado']     = 'error/Edita Numero Certificado, contiene palabras no permitidas';}

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
			if(isset($Patente)&&isset($idPersona)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'personas_listado_vehiculos', '', "Patente='".$Patente."' AND idPersona='".$idPersona."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Patente que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idPersona) && $idPersona!=''){                          $SIS_data  = "'".$idPersona."'";               }else{$SIS_data  = "''";}
				if(isset($Patente) && $Patente!=''){                              $SIS_data .= ",'".$Patente."'";                }else{$SIS_data .= ",''";}
				if(isset($Marca) && $Marca!=''){                                  $SIS_data .= ",'".$Marca."'";                  }else{$SIS_data .= ",''";}
				if(isset($Modelo) && $Modelo!=''){                                $SIS_data .= ",'".$Modelo."'";                 }else{$SIS_data .= ",''";}
				if(isset($Color) && $Color!=''){                                  $SIS_data .= ",'".$Color."'";                  }else{$SIS_data .= ",''";}
				if(isset($Tipo) && $Tipo!=''){                                    $SIS_data .= ",'".$Tipo."'";                   }else{$SIS_data .= ",''";}
				if(isset($AnoFabricacion) && $AnoFabricacion!=''){                $SIS_data .= ",'".$AnoFabricacion."'";         }else{$SIS_data .= ",''";}
				if(isset($RenovacionPatente) && $RenovacionPatente!=''){          $SIS_data .= ",'".$RenovacionPatente."'";      }else{$SIS_data .= ",''";}
				if(isset($UltimaTransferencia) && $UltimaTransferencia!=''){      $SIS_data .= ",'".$UltimaTransferencia."'";    }else{$SIS_data .= ",''";}
				if(isset($NumeroMotor) && $NumeroMotor!=''){                      $SIS_data .= ",'".$NumeroMotor."'";            }else{$SIS_data .= ",''";}
				if(isset($NumeroChasis) && $NumeroChasis!=''){                    $SIS_data .= ",'".$NumeroChasis."'";           }else{$SIS_data .= ",''";}
				if(isset($Tasacion) && $Tasacion!=''){                            $SIS_data .= ",'".$Tasacion."'";               }else{$SIS_data .= ",''";}
				if(isset($RevisionTecnica) && $RevisionTecnica!=''){              $SIS_data .= ",'".$RevisionTecnica."'";        }else{$SIS_data .= ",''";}
				if(isset($PlantaRevisionTecnica) && $PlantaRevisionTecnica!=''){  $SIS_data .= ",'".$PlantaRevisionTecnica."'";  }else{$SIS_data .= ",''";}
				if(isset($FechaRevision) && $FechaRevision!=''){                  $SIS_data .= ",'".$FechaRevision."'";          }else{$SIS_data .= ",''";}
				if(isset($NumeroCertificado) && $NumeroCertificado!=''){          $SIS_data .= ",'".$NumeroCertificado."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idPersona, Patente,Marca,Modelo,Color,Tipo,AnoFabricacion,RenovacionPatente,
				UltimaTransferencia,NumeroMotor,NumeroChasis,Tasacion,RevisionTecnica,PlantaRevisionTecnica,
				FechaRevision,NumeroCertificado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'personas_listado_vehiculos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Patente)&&isset($idPersona)&&isset($idVehiculos)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'personas_listado_vehiculos', '', "Patente='".$Patente."' AND idPersona='".$idPersona."' AND idVehiculos!='".$idVehiculos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Patente que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idVehiculos='".$idVehiculos."'";
				if(isset($idPersona) && $idPersona!=''){                           $SIS_data .= ",idPersona='".$idPersona."'";}
				if(isset($Patente) && $Patente!=''){                               $SIS_data .= ",Patente='".$Patente."'";}
				if(isset($Marca) && $Marca!=''){                                   $SIS_data .= ",Marca='".$Marca."'";}
				if(isset($Modelo) && $Modelo!=''){                                 $SIS_data .= ",Modelo='".$Modelo."'";}
				if(isset($Color) && $Color!=''){                                   $SIS_data .= ",Color='".$Color."'";}
				if(isset($Tipo) && $Tipo!=''){                                     $SIS_data .= ",Tipo='".$Tipo."'";}
				if(isset($AnoFabricacion) && $AnoFabricacion!=''){                 $SIS_data .= ",AnoFabricacion='".$AnoFabricacion."'";}
				if(isset($RenovacionPatente) && $RenovacionPatente!=''){           $SIS_data .= ",RenovacionPatente='".$RenovacionPatente."'";}
				if(isset($UltimaTransferencia) && $UltimaTransferencia!=''){       $SIS_data .= ",UltimaTransferencia='".$UltimaTransferencia."'";}
				if(isset($NumeroMotor) && $NumeroMotor!=''){                       $SIS_data .= ",NumeroMotor='".$NumeroMotor."'";}
				if(isset($NumeroChasis) && $NumeroChasis!=''){                     $SIS_data .= ",NumeroChasis='".$NumeroChasis."'";}
				if(isset($Tasacion) && $Tasacion!=''){                             $SIS_data .= ",Tasacion='".$Tasacion."'";}
				if(isset($RevisionTecnica) && $RevisionTecnica!=''){               $SIS_data .= ",RevisionTecnica='".$RevisionTecnica."'";}
				if(isset($PlantaRevisionTecnica) && $PlantaRevisionTecnica!=''){   $SIS_data .= ",PlantaRevisionTecnica='".$PlantaRevisionTecnica."'";}
				if(isset($FechaRevision) && $FechaRevision!=''){                   $SIS_data .= ",FechaRevision='".$FechaRevision."'";}
				if(isset($NumeroCertificado) && $NumeroCertificado!=''){           $SIS_data .= ",NumeroCertificado='".$NumeroCertificado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'personas_listado_vehiculos', 'idVehiculos = "'.$idVehiculos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'personas_listado_vehiculos', 'idVehiculos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
