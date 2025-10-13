<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-210).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idVehiculo']))                       $idVehiculo                        = $_POST['idVehiculo'];
	if (!empty($_POST['idSistema']))                        $idSistema                         = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))                         $idEstado                          = $_POST['idEstado'];
	if (!empty($_POST['idTipo']))                           $idTipo                            = $_POST['idTipo'];
	if (!empty($_POST['idZona']))                           $idZona                            = $_POST['idZona'];
	if (!empty($_POST['Nombre']))                           $Nombre                            = $_POST['Nombre'];
	if (!empty($_POST['Marca']))                            $Marca                             = $_POST['Marca'];
	if (!empty($_POST['Modelo']))                           $Modelo                            = $_POST['Modelo'];
	if (!empty($_POST['Num_serie']))                        $Num_serie                         = $_POST['Num_serie'];
	if (!empty($_POST['AnoFab']))                           $AnoFab                            = $_POST['AnoFab'];
	if (!empty($_POST['Patente']))                          $Patente                           = $_POST['Patente'];
	if (!empty($_POST['idOpciones_1']))                     $idOpciones_1                      = $_POST['idOpciones_1'];
	if (!empty($_POST['idOpciones_2']))                     $idOpciones_2                      = $_POST['idOpciones_2'];
	if (!empty($_POST['idOpciones_3']))                     $idOpciones_3                      = $_POST['idOpciones_3'];
	if (!empty($_POST['idOpciones_4']))                     $idOpciones_4                      = $_POST['idOpciones_4'];
	if (!empty($_POST['idOpciones_5']))                     $idOpciones_5                      = $_POST['idOpciones_5'];
	if (!empty($_POST['idOpciones_6']))                     $idOpciones_6                      = $_POST['idOpciones_6'];
	if (!empty($_POST['idOpciones_7']))                     $idOpciones_7                      = $_POST['idOpciones_7'];
	if (!empty($_POST['idOpciones_8']))                     $idOpciones_8                      = $_POST['idOpciones_8'];
	if (!empty($_POST['idOpciones_9']))                     $idOpciones_9                      = $_POST['idOpciones_9'];
	if (!empty($_POST['idOpciones_10']))                    $idOpciones_10                     = $_POST['idOpciones_10'];
	if (!empty($_POST['idTelemetria']))                     $idTelemetria                      = $_POST['idTelemetria'];
	if (!empty($_POST['idBodega']))                         $idBodega                          = $_POST['idBodega'];
	if (!empty($_POST['idRuta']))                           $idRuta                            = $_POST['idRuta'];
	if (!empty($_POST['idTrabajador']))                     $idTrabajador                      = $_POST['idTrabajador'];
	if (!empty($_POST['Password']))                         $Password                          = $_POST['Password'];
	if (!empty($_POST['dispositivo']))                      $dispositivo                       = $_POST['dispositivo'];
	if (!empty($_POST['IMEI']))                             $IMEI                              = $_POST['IMEI'];
	if (!empty($_POST['GSM']))                              $GSM                               = $_POST['GSM'];
	if (!empty($_POST['GeoLatitud']))                       $GeoLatitud                        = $_POST['GeoLatitud'];
	if (!empty($_POST['GeoLongitud']))                      $GeoLongitud                       = $_POST['GeoLongitud'];
	if (!empty($_POST['Capacidad']))                        $Capacidad                         = $_POST['Capacidad'];
	if (!empty($_POST['MCubicos']))                         $MCubicos                          = $_POST['MCubicos'];
	if (!empty($_POST['idTipoCarga']))                      $idTipoCarga                       = $_POST['idTipoCarga'];
	if (!empty($_POST['doc_fecha_mantencion']))             $doc_fecha_mantencion              = $_POST['doc_fecha_mantencion'];
	if (!empty($_POST['doc_fecha_padron']))                 $doc_fecha_padron                  = $_POST['doc_fecha_padron'];
	if (!empty($_POST['doc_fecha_permiso_circulacion']))    $doc_fecha_permiso_circulacion     = $_POST['doc_fecha_permiso_circulacion'];
	if (!empty($_POST['doc_fecha_resolucion_sanitaria']))   $doc_fecha_resolucion_sanitaria    = $_POST['doc_fecha_resolucion_sanitaria'];
	if (!empty($_POST['doc_fecha_revision_tecnica']))       $doc_fecha_revision_tecnica        = $_POST['doc_fecha_revision_tecnica'];
	if (!empty($_POST['doc_fecha_seguro_carga']))           $doc_fecha_seguro_carga            = $_POST['doc_fecha_seguro_carga'];
	if (!empty($_POST['doc_fecha_soap']))                   $doc_fecha_soap                    = $_POST['doc_fecha_soap'];
	if (!empty($_POST['doc_fecha_cert_trans_personas']))    $doc_fecha_cert_trans_personas     = $_POST['doc_fecha_cert_trans_personas'];
	if (!empty($_POST['idTransporte']))                     $idTransporte                      = $_POST['idTransporte'];
	if (!empty($_POST['idProceso']))                        $idProceso                         = $_POST['idProceso'];
	if (!empty($_POST['Motivo']))                           $Motivo                            = $_POST['Motivo'];
	if (!empty($_POST['LimiteVelocidad']))                  $LimiteVelocidad                   = $_POST['LimiteVelocidad'];
	if (!empty($_POST['CapacidadPersonas']))                $CapacidadPersonas                 = $_POST['CapacidadPersonas'];
	if (!empty($_POST['AlertLimiteVelocidad']))             $AlertLimiteVelocidad              = $_POST['AlertLimiteVelocidad'];

	if (!empty($_POST['idColegioAsignado']))                $idColegioAsignado                 = $_POST['idColegioAsignado'];
	if (!empty($_POST['idColegio']))                        $idColegio                         = $_POST['idColegio'];
	if (!empty($_POST['idHijos']))                          $idHijos                           = $_POST['idHijos'];
	if (!empty($_POST['idZona']))                           $idZona                            = $_POST['idZona'];
	if (!empty($_POST['idGeocerca']))                       $idGeocerca                        = $_POST['idGeocerca'];

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
			case 'idVehiculo':                      if(empty($idVehiculo)){                        $error['idVehiculo']                         = 'error/No ha ingresado el id';}break;
			case 'idSistema':                       if(empty($idSistema)){                         $error['idSistema']                          = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':                        if(empty($idEstado)){                          $error['idEstado']                           = 'error/No ha seleccionado el estado';}break;
			case 'idTipo':                          if(empty($idTipo)){                            $error['idTipo']                             = 'error/No ha seleccionado el tipo';}break;
			case 'idZona':                          if(empty($idZona)){                            $error['idZona']                             = 'error/No ha seleccionado la zona';}break;
			case 'Nombre':                          if(empty($Nombre)){                            $error['Nombre']                             = 'error/No ha ingresado el nombre';}break;
			case 'Marca':                           if(empty($Marca)){                             $error['Marca']                              = 'error/No ha ingresado la marca';}break;
			case 'Modelo':                          if(empty($Modelo)){                            $error['Modelo']                             = 'error/No ha ingresado el modelo';}break;
			case 'Num_serie':                       if(empty($Num_serie)){                         $error['Num_serie']                          = 'error/No ha ingresado el numero de serie';}break;
			case 'AnoFab':                          if(empty($AnoFab)){                            $error['AnoFab']                             = 'error/No ha ingresado el año de fabricacion';}break;
			case 'Patente':                         if(empty($Patente)){                           $error['Patente']                            = 'error/No ha ingresado la patente';}break;
			case 'idOpciones_1':                    if(empty($idOpciones_1)){                      $error['idOpciones_1']                       = 'error/No ha seleccionado la opción 1';}break;
			case 'idOpciones_2':                    if(empty($idOpciones_2)){                      $error['idOpciones_2']                       = 'error/No ha seleccionado la opción 2';}break;
			case 'idOpciones_3':                    if(empty($idOpciones_3)){                      $error['idOpciones_3']                       = 'error/No ha seleccionado la opción 3';}break;
			case 'idOpciones_4':                    if(empty($idOpciones_4)){                      $error['idOpciones_4']                       = 'error/No ha seleccionado la opción 4';}break;
			case 'idOpciones_5':                    if(empty($idOpciones_5)){                      $error['idOpciones_5']                       = 'error/No ha seleccionado la opción 5';}break;
			case 'idOpciones_6':                    if(empty($idOpciones_6)){                      $error['idOpciones_6']                       = 'error/No ha seleccionado la opción 6';}break;
			case 'idOpciones_7':                    if(empty($idOpciones_7)){                      $error['idOpciones_7']                       = 'error/No ha seleccionado la opción 6';}break;
			case 'idOpciones_8':                    if(empty($idOpciones_8)){                      $error['idOpciones_8']                       = 'error/No ha seleccionado la opción 6';}break;
			case 'idOpciones_9':                    if(empty($idOpciones_9)){                      $error['idOpciones_9']                       = 'error/No ha seleccionado la opción 6';}break;
			case 'idOpciones_10':                   if(empty($idOpciones_10)){                     $error['idOpciones_10']                      = 'error/No ha seleccionado la opción 6';}break;
			case 'idTelemetria':                    if(empty($idTelemetria)){                      $error['idTelemetria']                       = 'error/No ha seleccionado el sensor';}break;
			case 'idBodega':                        if(empty($idBodega)){                          $error['idBodega']                           = 'error/No ha seleccionado la bodega';}break;
			case 'idRuta':                          if(empty($idRuta)){                            $error['idRuta']                             = 'error/No ha seleccionado la ruta';}break;
			case 'idTrabajador':                    if(empty($idTrabajador)){                      $error['idTrabajador']                       = 'error/No ha seleccionado el trabajador';}break;
			case 'Password':                        if(empty($Password)){                          $error['Password']                           = 'error/No ha ingresado una contraseña';}break;
			case 'dispositivo':                     if(empty($dispositivo)){                       $error['dispositivo']                        = 'error/No ha ingresado un dispositivo';}break;
			case 'IMEI':                            if(empty($IMEI)){                              $error['IMEI']                               = 'error/No ha ingresado el Imei';}break;
			case 'GSM':                             if(empty($GSM)){                               $error['GSM']                                = 'error/No ha ingresado el GSM';}break;
			case 'GeoLatitud':                      if(empty($GeoLatitud)){                        $error['GeoLatitud']                         = 'error/No ha ingresado la latitud';}break;
			case 'GeoLongitud':                     if(empty($GeoLongitud)){                       $error['GeoLongitud']                        = 'error/No ha ingresado la longitud';}break;
			case 'Capacidad':                       if(empty($Capacidad)){                         $error['Capacidad']                          = 'error/No ha ingresado la capacidad';}break;
			case 'MCubicos':                        if(empty($MCubicos)){                          $error['MCubicos']                           = 'error/No ha ingresado los metros cubicos';}break;
			case 'idTipoCarga':                     if(empty($idTipoCarga)){                       $error['idTipoCarga']                        = 'error/No ha seleccionado un Tipo de Carga';}break;
			case 'doc_fecha_mantencion':            if(empty($doc_fecha_mantencion)){              $error['doc_fecha_mantencion']               = 'error/No ha ingresado la fecha de mantencion';}break;
			case 'doc_fecha_padron':                if(empty($doc_fecha_padron)){                  $error['doc_fecha_padron']                   = 'error/No ha ingresado la fecha de padron';}break;
			case 'doc_fecha_permiso_circulacion':   if(empty($doc_fecha_permiso_circulacion)){     $error['doc_fecha_permiso_circulacion']      = 'error/No ha ingresado la fecha de permiso de circulacion';}break;
			case 'doc_fecha_resolucion_sanitaria':  if(empty($doc_fecha_resolucion_sanitaria)){    $error['doc_fecha_resolucion_sanitaria']     = 'error/No ha ingresado la fecha de resolucion sanitaria';}break;
			case 'doc_fecha_revision_tecnica':      if(empty($doc_fecha_revision_tecnica)){        $error['doc_fecha_revision_tecnica']         = 'error/No ha ingresado la fecha de revision tecnica';}break;
			case 'doc_fecha_seguro_carga':          if(empty($doc_fecha_seguro_carga)){            $error['doc_fecha_seguro_carga']             = 'error/No ha ingresado la fecha de seguro de carga';}break;
			case 'doc_fecha_soap':                  if(empty($doc_fecha_soap)){                    $error['doc_fecha_soap']                     = 'error/No ha ingresado la fecha de SOAP';}break;
			case 'doc_fecha_cert_trans_personas':   if(empty($doc_fecha_cert_trans_personas)){     $error['doc_fecha_cert_trans_personas']      = 'error/No ha ingresado la fecha de certificado transporte personas';}break;
			case 'idTransporte':                    if(empty($idTransporte)){                      $error['idTransporte']                       = 'error/No ha seleccionado el transporte';}break;
			case 'idProceso':                       if(empty($idProceso)){                         $error['idProceso']                          = 'error/No ha seleccionado el estado del proceso';}break;
			case 'Motivo':                          if(empty($Motivo)){                            $error['Motivo']                             = 'error/No ha ingresado el motivo';}break;
			case 'LimiteVelocidad':                 if(empty($LimiteVelocidad)){                   $error['LimiteVelocidad']                    = 'error/No ha ingresado el limite de velocidad';}break;
			case 'CapacidadPersonas':               if(empty($CapacidadPersonas)){                 $error['CapacidadPersonas']                  = 'error/No ha ingresado la capacidad de pasajeros';}break;
			case 'AlertLimiteVelocidad':            if(empty($AlertLimiteVelocidad)){              $error['AlertLimiteVelocidad']               = 'error/No ha ingresado la el numero de alertas de limite de velocidad';}break;

			case 'idColegioAsignado':               if(empty($idColegioAsignado)){                 $error['idColegioAsignado']                  = 'error/No ha seleccionado el id del colegio';}break;
			case 'idColegio':                       if(empty($idColegio)){                         $error['idColegio']                          = 'error/No ha seleccionado el colegio';}break;
			case 'idHijos':                         if(empty($idHijos)){                           $error['idHijos']                            = 'error/No ha seleccionado un pasajero';}break;
			case 'idGeocerca':                      if(empty($idGeocerca)){                        $error['idGeocerca']                         = 'error/No ha seleccionado la geocerca';}break;
			case 'idZona':                          if(empty($idZona)){                            $error['idZona']                             = 'error/No ha seleccionado la geocerca';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){       $Nombre     = EstandarizarInput($Nombre);}
	if(isset($Marca) && $Marca!=''){         $Marca      = EstandarizarInput($Marca);}
	if(isset($Modelo) && $Modelo!=''){       $Modelo     = EstandarizarInput($Modelo);}
	if(isset($Num_serie) && $Num_serie!=''){ $Num_serie  = EstandarizarInput($Num_serie);}
	if(isset($Patente) && $Patente!=''){     $Patente    = EstandarizarInput($Patente);}
	if(isset($Password) && $Password!=''){   $Password   = EstandarizarInput($Password);}
	if(isset($Motivo) && $Motivo!=''){       $Motivo     = EstandarizarInput($Motivo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){        $error['Nombre']    = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Marca)&&contar_palabras_censuradas($Marca)!=0){          $error['Marca']     = 'error/Edita la Marca, contiene palabras no permitidas';}
	if(isset($Modelo)&&contar_palabras_censuradas($Modelo)!=0){        $error['Modelo']    = 'error/Edita Modelo, contiene palabras no permitidas';}
	if(isset($Num_serie)&&contar_palabras_censuradas($Num_serie)!=0){  $error['Num_serie'] = 'error/Edita Num serie, contiene palabras no permitidas';}
	if(isset($Patente)&&contar_palabras_censuradas($Patente)!=0){      $error['Patente']   = 'error/Edita la Patente, contiene palabras no permitidas';}
	if(isset($Password)&&contar_palabras_censuradas($Password)!=0){    $error['Password']  = 'error/Edita la Password, contiene palabras no permitidas';}
	if(isset($Motivo)&&contar_palabras_censuradas($Motivo)!=0){        $error['Motivo']    = 'error/Edita Motivo, contiene palabras no permitidas';}

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
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'vehiculos_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el dato existe
			if(isset($Patente)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Patente', 'vehiculos_listado', '', "Patente='".$Patente."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el trabajador ya esta asignado a otro furgon
			if(isset($idTrabajador)&&isset($idSistema)){
				$ndata_3 = db_select_nrows (false, 'idTrabajador', 'vehiculos_listado', '', "idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/La Patente ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El trabajador ya esta asignado a otro vehiculo';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se genera una password aleatoria
				$Password = genera_password(6,'alfanumerico');

				//filtros
				if(isset($idSistema) && $idSistema!=''){                                            $SIS_data  = "'".$idSistema."'";                        }else{$SIS_data  ="''";}
				if(isset($idEstado) && $idEstado!=''){                                              $SIS_data .= ",'".$idEstado."'";                        }else{$SIS_data .=",''";}
				if(isset($idTipo) && $idTipo!=''){                                                  $SIS_data .= ",'".$idTipo."'";                          }else{$SIS_data .=",''";}
				if(isset($idZona) && $idZona!=''){                                                  $SIS_data .= ",'".$idZona."'";                          }else{$SIS_data .=",''";}
				if(isset($Nombre) && $Nombre!=''){                                                  $SIS_data .= ",'".$Nombre."'";                          }else{$SIS_data .=",''";}
				if(isset($Marca) && $Marca!=''){                                                    $SIS_data .= ",'".$Marca."'";                           }else{$SIS_data .=",''";}
				if(isset($Modelo) && $Modelo!=''){                                                  $SIS_data .= ",'".$Modelo."'";                          }else{$SIS_data .=",''";}
				if(isset($Num_serie) && $Num_serie!=''){                                            $SIS_data .= ",'".$Num_serie."'";                       }else{$SIS_data .=",''";}
				if(isset($AnoFab) && $AnoFab!=''){                                                  $SIS_data .= ",'".$AnoFab."'";                          }else{$SIS_data .=",''";}
				if(isset($Patente) && $Patente!=''){                                                $SIS_data .= ",'".$Patente."'";                         }else{$SIS_data .=",''";}
				if(isset($idOpciones_1) && $idOpciones_1!=''){                                      $SIS_data .= ",'".$idOpciones_1."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_2) && $idOpciones_2!=''){                                      $SIS_data .= ",'".$idOpciones_2."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_3) && $idOpciones_3!=''){                                      $SIS_data .= ",'".$idOpciones_3."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_4) && $idOpciones_4!=''){                                      $SIS_data .= ",'".$idOpciones_4."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_5) && $idOpciones_5!=''){                                      $SIS_data .= ",'".$idOpciones_5."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_6) && $idOpciones_6!=''){                                      $SIS_data .= ",'".$idOpciones_6."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_7) && $idOpciones_7!=''){                                      $SIS_data .= ",'".$idOpciones_7."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_8) && $idOpciones_8!=''){                                      $SIS_data .= ",'".$idOpciones_8."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_9) && $idOpciones_9!=''){                                      $SIS_data .= ",'".$idOpciones_9."'";                    }else{$SIS_data .=",''";}
				if(isset($idOpciones_10) && $idOpciones_10!=''){                                    $SIS_data .= ",'".$idOpciones_10."'";                   }else{$SIS_data .=",''";}
				if(isset($idTelemetria) && $idTelemetria!=''){                                      $SIS_data .= ",'".$idTelemetria."'";                    }else{$SIS_data .=",''";}
				if(isset($idBodega) && $idBodega!=''){                                              $SIS_data .= ",'".$idBodega."'";                        }else{$SIS_data .=",''";}
				if(isset($idRuta) && $idRuta!=''){                                                  $SIS_data .= ",'".$idRuta."'";                          }else{$SIS_data .=",''";}
				if(isset($idTrabajador) && $idTrabajador!=''){                                      $SIS_data .= ",'".$idTrabajador."'";                    }else{$SIS_data .=",''";}
				if(isset($Password) && $Password!=''){                                              $SIS_data .= ",'".$Password."'";                        }else{$SIS_data .=",''";}
				if(isset($dispositivo) && $dispositivo!=''){                                        $SIS_data .= ",'".$dispositivo."'";                     }else{$SIS_data .=",''";}
				if(isset($IMEI) && $IMEI!=''){                                                      $SIS_data .= ",'".$IMEI."'";                            }else{$SIS_data .=",''";}
				if(isset($GSM) && $GSM!=''){                                                        $SIS_data .= ",'".$GSM."'";                             }else{$SIS_data .=",''";}
				if(isset($GeoLatitud) && $GeoLatitud!=''){                                          $SIS_data .= ",'".$GeoLatitud."'";                      }else{$SIS_data .=",''";}
				if(isset($GeoLongitud) && $GeoLongitud!=''){                                        $SIS_data .= ",'".$GeoLongitud."'";                     }else{$SIS_data .=",''";}
				if(isset($Capacidad) && $Capacidad!=''){                                            $SIS_data .= ",'".$Capacidad."'";                       }else{$SIS_data .=",''";}
				if(isset($MCubicos) && $MCubicos!=''){                                              $SIS_data .= ",'".$MCubicos."'";                        }else{$SIS_data .=",''";}
				if(isset($idTipoCarga) && $idTipoCarga!=''){                                        $SIS_data .= ",'".$idTipoCarga."'";                     }else{$SIS_data .=",''";}
				if(isset($doc_fecha_mantencion) && $doc_fecha_mantencion!=''){                      $SIS_data .= ",'".$doc_fecha_mantencion."'";            }else{$SIS_data .=",''";}
				if(isset($doc_fecha_padron) && $doc_fecha_padron!=''){                              $SIS_data .= ",'".$doc_fecha_padron."'";                }else{$SIS_data .=",''";}
				if(isset($doc_fecha_permiso_circulacion) && $doc_fecha_permiso_circulacion!=''){    $SIS_data .= ",'".$doc_fecha_permiso_circulacion."'";   }else{$SIS_data .=",''";}
				if(isset($doc_fecha_resolucion_sanitaria) && $doc_fecha_resolucion_sanitaria!=''){  $SIS_data .= ",'".$doc_fecha_resolucion_sanitaria."'";  }else{$SIS_data .=",''";}
				if(isset($doc_fecha_revision_tecnica) && $doc_fecha_revision_tecnica!=''){          $SIS_data .= ",'".$doc_fecha_revision_tecnica."'";      }else{$SIS_data .=",''";}
				if(isset($doc_fecha_seguro_carga) && $doc_fecha_seguro_carga!=''){                  $SIS_data .= ",'".$doc_fecha_seguro_carga."'";          }else{$SIS_data .=",''";}
				if(isset($doc_fecha_soap) && $doc_fecha_soap!=''){                                  $SIS_data .= ",'".$doc_fecha_soap."'";                  }else{$SIS_data .=",''";}
				if(isset($doc_fecha_cert_trans_personas) && $doc_fecha_cert_trans_personas!=''){    $SIS_data .= ",'".$doc_fecha_cert_trans_personas."'";   }else{$SIS_data .=",''";}
				if(isset($idTransporte) && $idTransporte!=''){                                      $SIS_data .= ",'".$idTransporte."'";                    }else{$SIS_data .=",''";}
				if(isset($idProceso) && $idProceso!=''){                                            $SIS_data .= ",'".$idProceso."'";                       }else{$SIS_data .=",''";}
				if(isset($Motivo) && $Motivo!=''){                                                  $SIS_data .= ",'".$Motivo."'";                          }else{$SIS_data .=",''";}
				if(isset($LimiteVelocidad) && $LimiteVelocidad!=''){                                $SIS_data .= ",'".$LimiteVelocidad."'";                 }else{$SIS_data .=",''";}
				if(isset($CapacidadPersonas) && $CapacidadPersonas!=''){                            $SIS_data .= ",'".$CapacidadPersonas."'";               }else{$SIS_data .=",''";}
				if(isset($AlertLimiteVelocidad) && $AlertLimiteVelocidad!=''){                      $SIS_data .= ",'".$AlertLimiteVelocidad."'";            }else{$SIS_data .=",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, idTipo, idZona, Nombre,Marca, Modelo, Num_serie,
				AnoFab, Patente, idOpciones_1, idOpciones_2, idOpciones_3, idOpciones_4, idOpciones_5,idOpciones_6, idOpciones_7,
				idOpciones_8, idOpciones_9, idOpciones_10, idTelemetria, idBodega, idRuta, idTrabajador,Password,
				dispositivo, IMEI, GSM, GeoLatitud, GeoLongitud,Capacidad, MCubicos, idTipoCarga, doc_fecha_mantencion,
				doc_fecha_padron, doc_fecha_permiso_circulacion, doc_fecha_resolucion_sanitaria, doc_fecha_revision_tecnica,
				doc_fecha_seguro_carga, doc_fecha_soap,doc_fecha_cert_trans_personas,idTransporte, idProceso, Motivo,
				LimiteVelocidad, CapacidadPersonas, AlertLimiteVelocidad';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					// elimino la tabla si es que existe
					$query  = "DROP TABLE IF EXISTS `vehiculos_listado_tablarelacionada_".$ultimo_id."`";
					$result = mysqli_query($dbConn, $query);

					// se crea la nueva tabla
					$query  = "CREATE TABLE `vehiculos_listado_tablarelacionada_".$ultimo_id."` (
					`idTabla` int(11) unsigned NOT NULL AUTO_INCREMENT,
					`idVehiculo` int(11) unsigned NOT NULL,
					`FechaSistema` date NOT NULL,
					`HoraSistema` time NOT NULL,
					`TimeStamp` datetime NOT NULL,
					`GeoLatitud` double NOT NULL,
					`GeoLongitud` double NOT NULL,
					`GeoVelocidad` decimal(20,6) NOT NULL,
					`GeoDireccion` decimal(20,6) NOT NULL,
					`GeoMovimiento` decimal(20,6) NOT NULL,
					`GeoProveedor` varchar(120) NOT NULL,
					`GeoExactitud` decimal(20,6) NOT NULL,
					`GeoAltitud` decimal(20,6) NOT NULL,
					`N_Pasajeros` int(11) unsigned NOT NULL,
					  PRIMARY KEY (`idTabla`)
					) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Dinamica';";
					$result = mysqli_query($dbConn, $query);

					//Si ejecuto correctamente la consulta
					if($result){
						//redirijo
						header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
						die;

					//si da error, guardar en el log de errores una copia
					}else{
						//Genero numero aleatorio
						$vardata = genera_password(8,'alfanumerico');

						//Guardo el error en una variable temporal
						
						
						

					}
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
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idVehiculo)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'vehiculos_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idVehiculo!='".$idVehiculo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el dato existe
			if(isset($Patente)&&isset($idSistema)&&isset($idVehiculo)){
				$ndata_2 = db_select_nrows (false, 'Patente', 'vehiculos_listado', '', "Patente='".$Patente."' AND idSistema='".$idSistema."' AND idVehiculo!='".$idVehiculo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el trabajador ya esta asignado a otro furgon
			if(isset($idTrabajador)&&isset($idSistema)&&isset($idVehiculo)){
				$ndata_3 = db_select_nrows (false, 'idTrabajador', 'vehiculos_listado', '', "idTrabajador='".$idTrabajador."' AND idSistema='".$idSistema."' AND idVehiculo!='".$idVehiculo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/La Patente ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El trabajador ya esta asignado a otro vehiculo';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Si no existe cambio a 1
				if(!isset($idTipoCarga)){$idTipoCarga=1;}

				//Filtros
				$SIS_data = "idVehiculo='".$idVehiculo."'";
				if(isset($idSistema) && $idSistema!=''){                                            $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                                              $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idTipo) && $idTipo!=''){                                                  $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($idZona) && $idZona!=''){                                                  $SIS_data .= ",idZona='".$idZona."'";}
				if(isset($Nombre) && $Nombre!=''){                                                  $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Marca) && $Marca!=''){                                                    $SIS_data .= ",Marca='".$Marca."'";}
				if(isset($Modelo) && $Modelo!=''){                                                  $SIS_data .= ",Modelo='".$Modelo."'";}
				if(isset($Num_serie) && $Num_serie!=''){                                            $SIS_data .= ",Num_serie='".$Num_serie."'";}
				if(isset($AnoFab) && $AnoFab!=''){                                                  $SIS_data .= ",AnoFab='".$AnoFab."'";}
				if(isset($Patente) && $Patente!=''){                                                $SIS_data .= ",Patente='".$Patente."'";}
				if(isset($idOpciones_1) && $idOpciones_1!=''){                                      $SIS_data .= ",idOpciones_1='".$idOpciones_1."'";}
				if(isset($idOpciones_2) && $idOpciones_2!=''){                                      $SIS_data .= ",idOpciones_2='".$idOpciones_2."'";}
				if(isset($idOpciones_3) && $idOpciones_3!=''){                                      $SIS_data .= ",idOpciones_3='".$idOpciones_3."'";}
				if(isset($idOpciones_4) && $idOpciones_4!=''){                                      $SIS_data .= ",idOpciones_4='".$idOpciones_4."'";}
				if(isset($idOpciones_5) && $idOpciones_5!=''){                                      $SIS_data .= ",idOpciones_5='".$idOpciones_5."'";}
				if(isset($idOpciones_6) && $idOpciones_6!=''){                                      $SIS_data .= ",idOpciones_6='".$idOpciones_6."'";}
				if(isset($idOpciones_7) && $idOpciones_7!=''){                                      $SIS_data .= ",idOpciones_7='".$idOpciones_7."'";}
				if(isset($idOpciones_8) && $idOpciones_8!=''){                                      $SIS_data .= ",idOpciones_8='".$idOpciones_8."'";}
				if(isset($idOpciones_9) && $idOpciones_9!=''){                                      $SIS_data .= ",idOpciones_9='".$idOpciones_9."'";}
				if(isset($idOpciones_10) && $idOpciones_10!=''){                                    $SIS_data .= ",idOpciones_10='".$idOpciones_10."'";}
				if(isset($idTelemetria) && $idTelemetria!=''){                                      $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($idBodega) && $idBodega!=''){                                              $SIS_data .= ",idBodega='".$idBodega."'";}
				if(isset($idRuta) && $idRuta!=''){                                                  $SIS_data .= ",idRuta='".$idRuta."'";}
				if(isset($idTrabajador) && $idTrabajador!=''){                                      $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
				if(isset($Password) && $Password!=''){                                              $SIS_data .= ",Password='".$Password."'";}
				if(isset($dispositivo) && $dispositivo!=''){                                        $SIS_data .= ",dispositivo='".$dispositivo."'";}
				if(isset($IMEI) && $IMEI!=''){                                                      $SIS_data .= ",IMEI='".$IMEI."'";}
				if(isset($GSM) && $GSM!=''){                                                        $SIS_data .= ",GSM='".$GSM."'";}
				if(isset($GeoLatitud) && $GeoLatitud!=''){                                          $SIS_data .= ",GeoLatitud='".$GeoLatitud."'";}
				if(isset($GeoLongitud) && $GeoLongitud!=''){                                        $SIS_data .= ",GeoLongitud='".$GeoLongitud."'";}
				if(isset($Capacidad) && $Capacidad!=''){                                            $SIS_data .= ",Capacidad='".$Capacidad."'";}
				if(isset($MCubicos) && $MCubicos!=''){                                              $SIS_data .= ",MCubicos='".$MCubicos."'";}
				if(isset($idTipoCarga) && $idTipoCarga!=''){                                        $SIS_data .= ",idTipoCarga='".$idTipoCarga."'";}
				if(isset($doc_fecha_mantencion) && $doc_fecha_mantencion!=''){                      $SIS_data .= ",doc_fecha_mantencion='".$doc_fecha_mantencion."'";}
				if(isset($doc_fecha_padron) && $doc_fecha_padron!=''){                              $SIS_data .= ",doc_fecha_padron='".$doc_fecha_padron."'";}
				if(isset($doc_fecha_permiso_circulacion) && $doc_fecha_permiso_circulacion!=''){    $SIS_data .= ",doc_fecha_permiso_circulacion='".$doc_fecha_permiso_circulacion."'";}
				if(isset($doc_fecha_resolucion_sanitaria) && $doc_fecha_resolucion_sanitaria!=''){  $SIS_data .= ",doc_fecha_resolucion_sanitaria='".$doc_fecha_resolucion_sanitaria."'";}
				if(isset($doc_fecha_revision_tecnica) && $doc_fecha_revision_tecnica!=''){          $SIS_data .= ",doc_fecha_revision_tecnica='".$doc_fecha_revision_tecnica."'";}
				if(isset($doc_fecha_seguro_carga) && $doc_fecha_seguro_carga!=''){                  $SIS_data .= ",doc_fecha_seguro_carga='".$doc_fecha_seguro_carga."'";}
				if(isset($doc_fecha_soap) && $doc_fecha_soap!=''){                                  $SIS_data .= ",doc_fecha_soap='".$doc_fecha_soap."'";}
				if(isset($doc_fecha_cert_trans_personas) && $doc_fecha_cert_trans_personas!=''){    $SIS_data .= ",doc_fecha_cert_trans_personas='".$doc_fecha_cert_trans_personas."'";}
				if(isset($idTransporte) && $idTransporte!=''){                                      $SIS_data .= ",idTransporte='".$idTransporte."'";}
				if(isset($idProceso) && $idProceso!=''){                                            $SIS_data .= ",idProceso='".$idProceso."'";}
				if(isset($Motivo) && $Motivo!=''){                                                  $SIS_data .= ",Motivo='".$Motivo."'";}
				if(isset($LimiteVelocidad) && $LimiteVelocidad!=''){                                $SIS_data .= ",LimiteVelocidad='".$LimiteVelocidad."'";}
				if(isset($CapacidadPersonas) && $CapacidadPersonas!=''){                            $SIS_data .= ",CapacidadPersonas='".$CapacidadPersonas."'";}
				if(isset($AlertLimiteVelocidad) && $AlertLimiteVelocidad!=''){                      $SIS_data .= ",AlertLimiteVelocidad='".$AlertLimiteVelocidad."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				// Se obtiene el nombre del archivo
				$rowData = db_select_data (false, 'Direccion_img, doc_mantencion, doc_padron, doc_permiso_circulacion, doc_resolucion_sanitaria, doc_revision_tecnica,doc_seguro_carga, doc_soap, doc_cert_trans_personas', 'vehiculos_listado', '', 'idVehiculo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'vehiculos_listado', 'idVehiculo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina la foto
					if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){
						try {
							if(!is_writable('upload/'.$rowData['Direccion_img'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['Direccion_img']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_mantencion'])&&$rowData['doc_mantencion']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_mantencion'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_mantencion']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_padron'])&&$rowData['doc_padron']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_padron'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_padron']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_permiso_circulacion'])&&$rowData['doc_permiso_circulacion']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_permiso_circulacion'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_permiso_circulacion']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_resolucion_sanitaria'])&&$rowData['doc_resolucion_sanitaria']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_resolucion_sanitaria'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_resolucion_sanitaria']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_revision_tecnica'])&&$rowData['doc_revision_tecnica']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_revision_tecnica'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_revision_tecnica']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_seguro_carga'])&&$rowData['doc_seguro_carga']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_seguro_carga'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_seguro_carga']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_soap'])&&$rowData['doc_soap']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_soap'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_soap']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el archivo
					if(isset($rowData['doc_cert_trans_personas'])&&$rowData['doc_cert_trans_personas']!=''){
						try {
							if(!is_writable('upload/'.$rowData['doc_cert_trans_personas'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['doc_cert_trans_personas']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}

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
		//Cambio el estado de activo a inactivo
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idVehiculo  = $_GET['id'];
			$idEstado    = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["Direccion_img"]["error"] > 0){
				$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'vehiculo_img_'.$idVehiculo.'_';

				if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						//$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
						//Muevo el archivo
						$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], "upload/xxxsxx_".$_FILES['Direccion_img']['name']);
						if ($move_result){
							//se selecciona la imagen
							switch ($_FILES['Direccion_img']['type']) {
								case 'image/jpg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/jpeg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/gif':
									$imgBase = imagecreatefromgif('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/png':
									$imgBase = imagecreatefrompng('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
							}

							//se reescala la imagen en caso de ser necesario
							$imgBase_width = imagesx( $imgBase );
							$imgBase_height = imagesy( $imgBase );

							//Se establece el tamaño maximo
							$max_width  = 640;
							$max_height = 640;

							if ($imgBase_width > $imgBase_height) {
								if($imgBase_width < $max_width){
									$newwidth = $imgBase_width;
								}else{
									$newwidth = $max_width;
								}
								$divisor = $imgBase_width / $newwidth;
								$newheight = floor( $imgBase_height / $divisor);
							}else {
								if($imgBase_height < $max_height){
									$newheight = $imgBase_height;
								}else{
									$newheight =  $max_height;
								}
								$divisor = $imgBase_height / $newheight;
								$newwidth = floor( $imgBase_width / $divisor );
							}

							$imgBase = imagescale($imgBase, $newwidth, $newheight);

							//se establece la calidad del archivo
							$quality = 75;

							//se crea la imagen
							imagejpeg($imgBase, $ruta, $quality);

							//se elimina la imagen base
							try {
								if(!is_writable('upload/xxxsxx_'.$_FILES['Direccion_img']['name'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
							//se eliminan las imagenes de la memoria
							imagedestroy($imgBase);

							//Filtro para idSistema
							$SIS_data = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['Direccion_img']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Direccion_img']     = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
					}
				} else {
					$error['Direccion_img']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre de la imagen
			$rowData = db_select_data (false, 'Direccion_img', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){
					try {
						if(!is_writable('upload/'.$rowData['Direccion_img'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['Direccion_img']);
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
		case 'insert_pasajero':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idVehiculo='".$idVehiculo."'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'apoderados_listado_hijos', 'idHijos = "'.$idHijos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_pasajero':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idVehiculo='0'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'apoderados_listado_hijos', 'idHijos = "'.$_GET['del_pasajero'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}


		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_doc_mantencion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_mantencion"]["error"] > 0){
				$error['doc_mantencion'] = 'error/'.uploadPHPError($_FILES["doc_mantencion"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_mantencion_'.$idVehiculo.'_'.$doc_fecha_mantencion.'_';

				if (in_array($_FILES['doc_mantencion']['type'], $permitidos) && $_FILES['doc_mantencion']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_mantencion']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_mantencion"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_mantencion='".$sufijo.$_FILES['doc_mantencion']['name']."'";
							if(isset($doc_fecha_mantencion) && $doc_fecha_mantencion!=''){   $SIS_data .= ",doc_fecha_mantencion='".$doc_fecha_mantencion."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Inserto el registro de las mantenciones
							//filtros
							$SIS_data = "'".$sufijo.$_FILES['doc_mantencion']['name']."'";
							if(isset($idVehiculo) && $idVehiculo!=''){                       $SIS_data .= ",'".$idVehiculo."'";            }else{$SIS_data .= ",''";}
							if(isset($doc_fecha_mantencion) && $doc_fecha_mantencion!=''){   $SIS_data .= ",'".$doc_fecha_mantencion."'";  }else{$SIS_data .= ",''";}
							if(isset($Fecha_ingreso) && $Fecha_ingreso!=''){                 $SIS_data .= ",'".$Fecha_ingreso."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'doc_mantencion, idVehiculo, doc_fecha_mantencion, Fecha_ingreso';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_mantenciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Si ejecuto correctamente la consulta
							if($ultimo_id!=0){
								//redirijo
								header( 'Location: '.$location );
								die;
							}

						} else {
							$error['doc_mantencion']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_mantencion']     = 'error/El archivo '.$_FILES['doc_mantencion']['name'].' ya existe';
					}
				} else {
					$error['doc_mantencion']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_mantencion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_doc_mantencion']) OR !validaEntero($_GET['del_doc_mantencion']))&&$_GET['del_doc_mantencion']!=''){
				$indice = simpleDecode($_GET['del_doc_mantencion'], fecha_actual());
			}else{
				$indice = $_GET['del_doc_mantencion'];
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
				//Variables
				$idVehiculo      = $_GET['id'];

				// Se obtiene el nombre del documento actual
				$rowVehiculo = db_select_data (false, 'doc_mantencion', 'vehiculos_listado', '', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				// Se obtiene el nombre del documento a borrar
				$rowMantencion = db_select_data (false, 'doc_mantencion', 'vehiculos_mantenciones', '', 'idMantenciones = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************/
				//Si coinciden ambos documentos se actualiza registro de la mantencion
				if(isset($rowVehiculo['doc_mantencion'])&&isset($rowMantencion['doc_mantencion'])&&$rowVehiculo['doc_mantencion']==$rowMantencion['doc_mantencion']){
					/*******************************************************/
					//se actualizan los datos
					$SIS_data = "doc_mantencion='', doc_fecha_mantencion=''";
					$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'vehiculos_mantenciones', 'idMantenciones = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowMantencion['doc_mantencion'])&&$rowMantencion['doc_mantencion']!=''){
						try {
							if(!is_writable('upload/'.$rowMantencion['doc_mantencion'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowMantencion['doc_mantencion']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}

					//redirijo
					header( 'Location: '.$location.'&del_doc_vehi=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_doc_padron':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_padron"]["error"] > 0){
				$error['doc_padron'] = 'error/'.uploadPHPError($_FILES["doc_padron"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_padron_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_padron']['type'], $permitidos) && $_FILES['doc_padron']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_padron']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_padron"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_padron='".$sufijo.$_FILES['doc_padron']['name']."'";
							if(isset($doc_fecha_padron) && $doc_fecha_padron!=''){   $SIS_data .= ",doc_fecha_padron='".$doc_fecha_padron."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_padron']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_padron']     = 'error/El archivo '.$_FILES['doc_padron']['name'].' ya existe';
					}
				} else {
					$error['doc_padron']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_padron':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_padron', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_padron'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_padron='', doc_fecha_padron=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_padron'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_padron'])&&$rowData['doc_padron']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_padron'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_padron']);
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
		//Cambia el nivel del permiso
		case 'submit_doc_permiso_circulacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_permiso_circulacion"]["error"] > 0){
				$error['doc_permiso_circulacion'] = 'error/'.uploadPHPError($_FILES["doc_permiso_circulacion"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_permiso_circulacion_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_permiso_circulacion']['type'], $permitidos) && $_FILES['doc_permiso_circulacion']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_permiso_circulacion']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_permiso_circulacion"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_permiso_circulacion='".$sufijo.$_FILES['doc_permiso_circulacion']['name']."'";
							if(isset($doc_fecha_permiso_circulacion) && $doc_fecha_permiso_circulacion!=''){   $SIS_data .= ",doc_fecha_permiso_circulacion='".$doc_fecha_permiso_circulacion."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_permiso_circulacion']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_permiso_circulacion']     = 'error/El archivo '.$_FILES['doc_permiso_circulacion']['name'].' ya existe';
					}
				} else {
					$error['doc_permiso_circulacion']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_permiso_circulacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_permiso_circulacion', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_permiso_circulacion'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_permiso_circulacion='', doc_fecha_permiso_circulacion=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_permiso_circulacion'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_permiso_circulacion'])&&$rowData['doc_permiso_circulacion']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_permiso_circulacion'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_permiso_circulacion']);
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
		//Cambia el nivel del permiso
		case 'submit_doc_resolucion_sanitaria':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_resolucion_sanitaria"]["error"] > 0){
				$error['doc_resolucion_sanitaria'] = 'error/'.uploadPHPError($_FILES["doc_resolucion_sanitaria"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_resolucion_sanitaria_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_resolucion_sanitaria']['type'], $permitidos) && $_FILES['doc_resolucion_sanitaria']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_resolucion_sanitaria']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_resolucion_sanitaria"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_resolucion_sanitaria='".$sufijo.$_FILES['doc_resolucion_sanitaria']['name']."'";
							if(isset($doc_fecha_resolucion_sanitaria) && $doc_fecha_resolucion_sanitaria!=''){   $SIS_data .= ",doc_fecha_resolucion_sanitaria='".$doc_fecha_resolucion_sanitaria."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_resolucion_sanitaria']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_resolucion_sanitaria']     = 'error/El archivo '.$_FILES['doc_resolucion_sanitaria']['name'].' ya existe';
					}
				} else {
					$error['doc_resolucion_sanitaria']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_resolucion_sanitaria':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_resolucion_sanitaria', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_resolucion_sanitaria'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_resolucion_sanitaria='', doc_fecha_resolucion_sanitaria=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_resolucion_sanitaria'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_resolucion_sanitaria'])&&$rowData['doc_resolucion_sanitaria']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_resolucion_sanitaria'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_resolucion_sanitaria']);
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
		//Cambia el nivel del permiso
		case 'submit_doc_revision_tecnica':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_revision_tecnica"]["error"] > 0){
				$error['doc_revision_tecnica'] = 'error/'.uploadPHPError($_FILES["doc_revision_tecnica"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_revision_tecnica_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_revision_tecnica']['type'], $permitidos) && $_FILES['doc_revision_tecnica']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_revision_tecnica']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_revision_tecnica"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_revision_tecnica='".$sufijo.$_FILES['doc_revision_tecnica']['name']."'";
							if(isset($doc_fecha_revision_tecnica) && $doc_fecha_revision_tecnica!=''){   $SIS_data .= ",doc_fecha_revision_tecnica='".$doc_fecha_revision_tecnica."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_revision_tecnica']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_revision_tecnica']     = 'error/El archivo '.$_FILES['doc_revision_tecnica']['name'].' ya existe';
					}
				} else {
					$error['doc_revision_tecnica']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';

				}
			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'del_doc_revision_tecnica':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_revision_tecnica', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_revision_tecnica'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_revision_tecnica='', doc_fecha_revision_tecnica=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_revision_tecnica'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_revision_tecnica'])&&$rowData['doc_revision_tecnica']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_revision_tecnica'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_revision_tecnica']);
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
		//Cambia el nivel del permiso
		case 'submit_doc_seguro_carga':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_seguro_carga"]["error"] > 0){
				$error['doc_seguro_carga'] = 'error/'.uploadPHPError($_FILES["doc_seguro_carga"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_seguro_carga_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_seguro_carga']['type'], $permitidos) && $_FILES['doc_seguro_carga']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_seguro_carga']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_seguro_carga"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_seguro_carga='".$sufijo.$_FILES['doc_seguro_carga']['name']."'";
							if(isset($doc_fecha_seguro_carga) && $doc_fecha_seguro_carga!=''){   $SIS_data .= ",doc_fecha_seguro_carga='".$doc_fecha_seguro_carga."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_seguro_carga']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_seguro_carga']     = 'error/El archivo '.$_FILES['doc_seguro_carga']['name'].' ya existe';
					}
				} else {
					$error['doc_seguro_carga']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_seguro_carga':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_seguro_carga', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_seguro_carga'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_seguro_carga='', doc_fecha_seguro_carga=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_seguro_carga'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_seguro_carga'])&&$rowData['doc_seguro_carga']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_seguro_carga'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_seguro_carga']);
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
		//Cambia el nivel del permiso
		case 'submit_doc_soap':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_soap"]["error"] > 0){
				$error['doc_soap'] = 'error/'.uploadPHPError($_FILES["doc_soap"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_soap_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_soap']['type'], $permitidos) && $_FILES['doc_soap']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_soap']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_soap"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_soap='".$sufijo.$_FILES['doc_soap']['name']."'";
							if(isset($doc_fecha_soap) && $doc_fecha_soap!=''){   $SIS_data .= ",doc_fecha_soap='".$doc_fecha_soap."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_soap']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_soap']     = 'error/El archivo '.$_FILES['doc_soap']['name'].' ya existe';
					}
				} else {
					$error['doc_soap']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_soap':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_soap', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_soap'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_soap='', doc_fecha_soap=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_soap'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_soap'])&&$rowData['doc_soap']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_soap'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_soap']);
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
		//Cambia el nivel del permiso
		case 'submit_doc_cert_trans_personas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_cert_trans_personas"]["error"] > 0){
				$error['doc_cert_trans_personas'] = 'error/'.uploadPHPError($_FILES["doc_cert_trans_personas"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_cert_trans_personas_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_cert_trans_personas']['type'], $permitidos) && $_FILES['doc_cert_trans_personas']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_cert_trans_personas']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_cert_trans_personas"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_cert_trans_personas='".$sufijo.$_FILES['doc_cert_trans_personas']['name']."'";
							if(isset($doc_fecha_cert_trans_personas) && $doc_fecha_cert_trans_personas!=''){   $SIS_data .= ",doc_fecha_cert_trans_personas='".$doc_fecha_cert_trans_personas."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_cert_trans_personas']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_cert_trans_personas']     = 'error/El archivo '.$_FILES['doc_cert_trans_personas']['name'].' ya existe';
					}
				} else {
					$error['doc_cert_trans_personas']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_cert_trans_personas':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_cert_trans_personas', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_cert_trans_personas'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_cert_trans_personas='', doc_fecha_cert_trans_personas=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_cert_trans_personas'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_cert_trans_personas'])&&$rowData['doc_cert_trans_personas']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_cert_trans_personas'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_cert_trans_personas']);
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
		case 'insert_colegio':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($idVehiculo)&&isset($idColegio)){
				$ndata_1 = db_select_nrows (false, 'idVehiculo', 'vehiculos_listado_colegios', '', "idVehiculo='".$idVehiculo."' AND idColegio='".$idColegio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Colegio ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idVehiculo) && $idVehiculo!=''){  $SIS_data  = "'".$idVehiculo."'";       }else{$SIS_data  = "''";}
				if(isset($idColegio) && $idColegio!=''){    $SIS_data .= ",'".$idColegio."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idVehiculo, idColegio';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_listado_colegios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_colegio':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_colegio']) OR !validaEntero($_GET['del_colegio']))&&$_GET['del_colegio']!=''){
				$indice = simpleDecode($_GET['del_colegio'], fecha_actual());
			}else{
				$indice = $_GET['del_colegio'];
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
				$resultado = db_delete_data (false, 'vehiculos_listado_colegios', 'idColegioAsignado = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'insert_geocerca':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($idVehiculo)&&isset($idZona)){
				$ndata_1 = db_select_nrows (false, 'idVehiculo', 'vehiculos_listado_geocercas', '', "idVehiculo='".$idVehiculo."' AND idZona='".$idZona."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Geocerca ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idVehiculo) && $idVehiculo!=''){  $SIS_data  = "'".$idVehiculo."'"; }else{$SIS_data  = "''";}
				if(isset($idZona) && $idZona!=''){          $SIS_data .= ",'".$idZona."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idVehiculo, idZona';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'vehiculos_listado_geocercas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_geocerca':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_geocerca']) OR !validaEntero($_GET['del_geocerca']))&&$_GET['del_geocerca']!=''){
				$indice = simpleDecode($_GET['del_geocerca'], fecha_actual());
			}else{
				$indice = $_GET['del_geocerca'];
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
				$resultado = db_delete_data (false, 'vehiculos_listado_geocercas', 'idGeocerca = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		//Cambia el nivel del permiso
		case 'submit_doc_ficha':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["doc_ficha_tecnica"]["error"] > 0){
				$error['doc_ficha_tecnica'] = 'error/'.uploadPHPError($_FILES["doc_ficha_tecnica"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",

									"image/jpg",
									"image/jpeg",
									"image/gif",
									"image/png"

											);

				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'vehiculo_doc_ficha_'.$idVehiculo.'_';

				if (in_array($_FILES['doc_ficha_tecnica']['type'], $permitidos) && $_FILES['doc_ficha_tecnica']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['doc_ficha_tecnica']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["doc_ficha_tecnica"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "doc_ficha_tecnica='".$sufijo.$_FILES['doc_ficha_tecnica']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['doc_ficha_tecnica']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['doc_ficha_tecnica']     = 'error/El archivo '.$_FILES['doc_ficha_tecnica']['name'].' ya existe';
					}
				} else {
					$error['doc_ficha_tecnica']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_doc_ficha':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'doc_ficha_tecnica', 'vehiculos_listado', '', 'idVehiculo = "'.$_GET['del_doc_ficha'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "doc_ficha_tecnica=''";
			$resultado = db_update_data (false, $SIS_data, 'vehiculos_listado', 'idVehiculo = "'.$_GET['del_doc_ficha'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['doc_ficha_tecnica'])&&$rowData['doc_ficha_tecnica']!=''){
					try {
						if(!is_writable('upload/'.$rowData['doc_ficha_tecnica'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['doc_ficha_tecnica']);
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
