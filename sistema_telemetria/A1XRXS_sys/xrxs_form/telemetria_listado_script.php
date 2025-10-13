<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-179).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idScript']))        $idScript         = $_POST['idScript'];
	if (!empty($_POST['idTelemetria']))    $idTelemetria     = $_POST['idTelemetria'];
	if (!empty($_POST['idUsuario']))       $idUsuario        = $_POST['idUsuario'];
	if (!empty($_POST['Fecha']))           $Fecha            = $_POST['Fecha'];
	if (!empty($_POST['Version']))         $Version          = $_POST['Version'];
	if (!empty($_POST['Observacion']))     $Observacion      = $_POST['Observacion'];
	if (!empty($_POST['idDispositivo']))   $idDispositivo    = $_POST['idDispositivo'];
	if (!empty($_POST['idShield']))        $idShield         = $_POST['idShield'];
	if (!empty($_POST['idFormaEnvio']))    $idFormaEnvio     = $_POST['idFormaEnvio'];
	if (!empty($_POST['idTab']))           $idTab            = $_POST['idTab'];
	if (!empty($_POST['id_Geo']))          $id_Geo           = $_POST['id_Geo'];
	if (!empty($_POST['id_Sensores']))     $id_Sensores      = $_POST['id_Sensores'];
	if (!empty($_POST['cantSensores']))    $cantSensores     = $_POST['cantSensores'];
	if (!empty($_POST['idAPNListado']))    $idAPNListado     = $_POST['idAPNListado'];
	if (!empty($_POST['idPuertoSerial']))  $idPuertoSerial   = $_POST['idPuertoSerial'];
	if (!empty($_POST['pinMode']))         $pinMode          = $_POST['pinMode'];
	if (!empty($_POST['idModificado']))    $idModificado     = $_POST['idModificado'];
	if (!empty($_POST['cantSensores'])){
		for ($i = 1; $i <= $_POST['cantSensores']; $i++) {
			$SensoresTipo[$i]     = $_POST['SensoresTipo_'.$i];
		}
	}

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
			case 'idScript':         if(empty($idScript)){          $error['idScript']         = 'error/No ha ingresado el id';}break;
			case 'idTelemetria':     if(empty($idTelemetria)){      $error['idTelemetria']     = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'idUsuario':        if(empty($idUsuario)){         $error['idUsuario']        = 'error/No ha seleccionado un usuario';}break;
			case 'Fecha':            if(empty($Fecha)){             $error['Fecha']            = 'error/No ha ingresado la fecha';}break;
			case 'Version':          if(empty($Version)){           $error['Version']          = 'error/No ha ingresado la version';}break;
			case 'Observacion':      if(empty($Observacion)){       $error['Observacion']      = 'error/No ha ingresado la observacion';}break;
			case 'idDispositivo':    if(empty($idDispositivo)){     $error['idDispositivo']    = 'error/No ha seleccionado la placa base';}break;
			case 'idShield':         if(empty($idShield)){          $error['idShield']         = 'error/No ha seleccionado la placa de comunicacion';}break;
			case 'idFormaEnvio':     if(empty($idFormaEnvio)){      $error['idFormaEnvio']     = 'error/No ha seleccionado la forma de envio de datos';}break;
			case 'idTab':            if(empty($idTab)){             $error['idTab']            = 'error/No ha seleccionado la pestaña de trabajo';}break;
			case 'id_Geo':           if(empty($id_Geo)){            $error['id_Geo']           = 'error/No ha seleccionado la geolocalizacion';}break;
			case 'id_Sensores':      if(empty($id_Sensores)){       $error['id_Sensores']      = 'error/No ha seleccionado el uso de sensores';}break;
			case 'cantSensores':     if(empty($cantSensores)){      $error['cantSensores']     = 'error/No ha ingresado la cantidad de sensores';}break;
			case 'idAPNListado':     if(empty($idAPNListado)){      $error['idAPNListado']     = 'error/No ha ingresado la dirección APN';}break;
			case 'idPuertoSerial':   if(empty($idPuertoSerial)){    $error['idPuertoSerial']   = 'error/No ha seleccionado el puerto serial';}break;
			case 'pinMode':          if(empty($pinMode)){           $error['pinMode']          = 'error/No ha ingresado el pinMode';}break;
			case 'idModificado':     if(empty($idModificado)){      $error['idModificado']     = 'error/No ha seleccionado si el script esta modificado';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observacion) && $Observacion!=''){ $Observacion = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){  $error['Observacion'] = 'error/Edita la Observacion, contiene palabras no permitidas';}

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

				//consulto el numero de registros
				$ndata_1 = db_select_nrows (false, 'idTelemetria', 'telemetria_listado_script', '', 'idTelemetria ='.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//si no hay datos
				if($ndata_1==0){
					$Version = 1;
				//si hay datos, obtener la ultima version
				}elseif($ndata_1>0){
					$rowData = db_select_data (false, 'Version', 'telemetria_listado_script', '', 'idTelemetria ='.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$Version = $rowData['Version'] + 1;
				}

				//subcolumnas en caso de existir sensores
				$subColumn = '';
				//filtros
				if(isset($idTelemetria) && $idTelemetria!=''){       $SIS_data  = "'".$idTelemetria."'";      }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){             $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                     $SIS_data .= ",'".$Fecha."'";            }else{$SIS_data .= ",''";}
				if(isset($Version) && $Version!=''){                 $SIS_data .= ",'".$Version."'";          }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){         $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idDispositivo) && $idDispositivo!=''){     $SIS_data .= ",'".$idDispositivo."'";    }else{$SIS_data .= ",''";}
				if(isset($idShield) && $idShield!=''){               $SIS_data .= ",'".$idShield."'";         }else{$SIS_data .= ",''";}
				if(isset($idFormaEnvio) && $idFormaEnvio!=''){       $SIS_data .= ",'".$idFormaEnvio."'";     }else{$SIS_data .= ",''";}
				if(isset($idTab) && $idTab!=''){                     $SIS_data .= ",'".$idTab."'";            }else{$SIS_data .= ",''";}
				if(isset($id_Geo) && $id_Geo!=''){                   $SIS_data .= ",'".$id_Geo."'";           }else{$SIS_data .= ",''";}
				if(isset($id_Sensores) && $id_Sensores!=''){         $SIS_data .= ",'".$id_Sensores."'";      }else{$SIS_data .= ",''";}
				if(isset($cantSensores) && $cantSensores!=''){       $SIS_data .= ",'".$cantSensores."'";     }else{$SIS_data .= ",''";}
				if(isset($idAPNListado) && $idAPNListado!=''){       $SIS_data .= ",'".$idAPNListado."'";     }else{$SIS_data .= ",''";}
				if(isset($idPuertoSerial) && $idPuertoSerial!=''){   $SIS_data .= ",'".$idPuertoSerial."'";   }else{$SIS_data .= ",''";}
				if(isset($pinMode) && $pinMode!=''){                 $SIS_data .= ",'".$pinMode."'";          }else{$SIS_data .= ",''";}
				if(isset($idModificado) && $idModificado!=''){       $SIS_data .= ",'".$idModificado."'";     }else{$SIS_data .= ",''";}

				//recorro los sensores para guardar los sensores
				if(isset($cantSensores) && $cantSensores!=''){for ($i = 1; $i <= $cantSensores; $i++) {$SIS_data .= ",'".$SensoresTipo[$i]."'";$subColumn .= ',SensoresTipo_'.$i;}}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria, idUsuario, Fecha, Version, Observacion, idDispositivo,
				idShield, idFormaEnvio, idTab, id_Geo, id_Sensores, cantSensores, idAPNListado,
				idPuertoSerial, pinMode, idModificado'.$subColumn;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_script', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***********************************************************************************/
				//se verifica si archivo existe
				if (!empty($_FILES['ScriptFile']['name'])){
					if ($_FILES["ScriptFile"]["error"] > 0){
						$error['ScriptFile'] = 'error/'.uploadPHPError($_FILES["ScriptFile"]["error"]);
					} else {
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'ScriptFile_'.$idScript.'_';

						if ($_FILES['ScriptFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['ScriptFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["ScriptFile"]["tmp_name"], $ruta);
								if ($move_result){
									//Filtros
									$SIS_data = "idScript='".$idScript."'";
									if(isset($idTelemetria) && $idTelemetria!=''){       $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
									if(isset($idUsuario) && $idUsuario!=''){             $SIS_data .= ",idUsuario='".$idUsuario."'";}
									if(isset($Fecha) && $Fecha!=''){                     $SIS_data .= ",Fecha='".$Fecha."'";}
									if(isset($Version) && $Version!=''){                 $SIS_data .= ",Version='".$Version."'";}
									if(isset($Observacion) && $Observacion!=''){         $SIS_data .= ",Observacion='".$Observacion."'";}
									if(isset($idAPNListado) && $idAPNListado!=''){       $SIS_data .= ",idAPNListado='".$idAPNListado."'";}
									if(isset($idPuertoSerial) && $idPuertoSerial!=''){   $SIS_data .= ",idPuertoSerial='".$idPuertoSerial."'";}
									if(isset($pinMode) && $pinMode!=''){                 $SIS_data .= ",pinMode='".$pinMode."'";}
									if(isset($idModificado) && $idModificado!=''){       $SIS_data .= ",idModificado='".$idModificado."'";}
									$SIS_data .= "ScriptFile='".$sufijo.$_FILES['ScriptFile']['name']."'";

									/*******************************************************/
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_script', 'idScript = "'.$idScript.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($resultado==true){

										//redirijo
										header( 'Location: '.$location.'&edited=true' );
										die;

									}

								}else {
									$error['ScriptFile']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['ScriptFile']     = 'error/El archivo '.$_FILES['ScriptFile']['name'].' ya existe';
							}
						} else {
							$error['ScriptFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}

				/************************************************************/
				//si no hay archivo
				}else{
					//Filtros
					$SIS_data = "idScript='".$idScript."'";
					if(isset($idTelemetria) && $idTelemetria!=''){       $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
					if(isset($idUsuario) && $idUsuario!=''){             $SIS_data .= ",idUsuario='".$idUsuario."'";}
					if(isset($Fecha) && $Fecha!=''){                     $SIS_data .= ",Fecha='".$Fecha."'";}
					if(isset($Version) && $Version!=''){                 $SIS_data .= ",Version='".$Version."'";}
					if(isset($Observacion) && $Observacion!=''){         $SIS_data .= ",Observacion='".$Observacion."'";}
					if(isset($idAPNListado) && $idAPNListado!=''){       $SIS_data .= ",idAPNListado='".$idAPNListado."'";}
					if(isset($idPuertoSerial) && $idPuertoSerial!=''){   $SIS_data .= ",idPuertoSerial='".$idPuertoSerial."'";}
					if(isset($pinMode) && $pinMode!=''){                 $SIS_data .= ",pinMode='".$pinMode."'";}
					if(isset($idModificado) && $idModificado!=''){       $SIS_data .= ",idModificado='".$idModificado."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_script', 'idScript = "'.$idScript.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){

						//redirijo
						header( 'Location: '.$location.'&edited=true' );
						die;

					}
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
				$resultado = db_delete_data (false, 'telemetria_listado_script', 'idScript = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'ScriptFile', 'telemetria_listado_script', '', 'idScript = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "ScriptFile=''";
			$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_script', 'idScript = "'.$_GET['del_file'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['ScriptFile'])&&$rowData['ScriptFile']!=''){
					try {
						if(!is_writable('upload/'.$rowData['ScriptFile'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['ScriptFile']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
