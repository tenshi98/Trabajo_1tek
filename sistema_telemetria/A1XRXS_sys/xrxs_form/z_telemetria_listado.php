<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-279).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Variable de configuracion de la cantidad maxima de sensores
	$N_Maximo_Sensores = 72;

	//Traspaso de valores input a variables
	if (!empty($_POST['idTelemetria']))                      $idTelemetria                       = $_POST['idTelemetria'];
	if (!empty($_POST['idSistema']))                         $idSistema                          = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))                          $idEstado                           = $_POST['idEstado'];
	if (!empty($_POST['Identificador']))                     $Identificador                      = $_POST['Identificador'];
	if (!empty($_POST['Nombre']))                            $Nombre                             = $_POST['Nombre'];
	if (!empty($_POST['NumSerie']))                          $NumSerie                           = $_POST['NumSerie'];
	if (!empty($_POST['idCiudad']))                          $idCiudad                           = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))                          $idComuna                           = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))                         $Direccion                          = $_POST['Direccion'];
	if (!empty($_POST['GeoLatitud']))                        $GeoLatitud                         = $_POST['GeoLatitud'];
	if (!empty($_POST['GeoLongitud']))                       $GeoLongitud                        = $_POST['GeoLongitud'];
	if (!empty($_POST['GeoErrores']))                        $GeoErrores                         = $_POST['GeoErrores'];
	if (!empty($_POST['GeoVelocidad']))                      $GeoVelocidad                       = $_POST['GeoVelocidad'];
	if (!empty($_POST['GeoDireccion']))                      $GeoDireccion                       = $_POST['GeoDireccion'];
	if (!empty($_POST['GeoMovimiento']))                     $GeoMovimiento                      = $_POST['GeoMovimiento'];
	if (!empty($_POST['GeoTiempoDetencion']))                $GeoTiempoDetencion                 = $_POST['GeoTiempoDetencion'];
	if (!empty($_POST['LastUpdateFecha']))                   $LastUpdateFecha                    = $_POST['LastUpdateFecha'];
	if (!empty($_POST['LastUpdateHora']))                    $LastUpdateHora                     = $_POST['LastUpdateHora'];
	if (!empty($_POST['id_Geo']))                            $id_Geo                             = $_POST['id_Geo'];
	if (!empty($_POST['id_Sensores']))                       $id_Sensores                        = $_POST['id_Sensores'];
	if (!empty($_POST['cantSensores']))                      $cantSensores                       = $_POST['cantSensores'];
	if (!empty($_POST['idDispositivo']))                     $idDispositivo                      = $_POST['idDispositivo'];
	if ( isset($_POST['idShield']))                          $idShield                           = $_POST['idShield'];
	if ( isset($_POST['idFormaEnvio']))                      $idFormaEnvio                       = $_POST['idFormaEnvio'];
	if (!empty($_POST['idGenerador']))                       $idGenerador                        = $_POST['idGenerador'];
	if (!empty($_POST['idTelGenerador']))                    $idTelGenerador                     = $_POST['idTelGenerador'];
	if (!empty($_POST['FechaInsGen']))                       $FechaInsGen                        = $_POST['FechaInsGen'];
	if (!empty($_POST['Sim_Num_Tel']))                       $Sim_Num_Tel                        = $_POST['Sim_Num_Tel'];
	if (!empty($_POST['Sim_Num_Serie']))                     $Sim_Num_Serie                      = $_POST['Sim_Num_Serie'];
	if (!empty($_POST['Sim_marca']))                         $Sim_marca                          = $_POST['Sim_marca'];
	if (!empty($_POST['Sim_modelo']))                        $Sim_modelo                         = $_POST['Sim_modelo'];
	if (!empty($_POST['Sim_Compania']))                      $Sim_Compania                       = $_POST['Sim_Compania'];
	if (!empty($_POST['idEstadoEncendido']))                 $idEstadoEncendido                  = $_POST['idEstadoEncendido'];
	if (!empty($_POST['LimiteVelocidad']))                   $LimiteVelocidad                    = $_POST['LimiteVelocidad'];
	if ( isset($_POST['IdentificadorEmpresa']))              $IdentificadorEmpresa               = $_POST['IdentificadorEmpresa'];
	if (!empty($_POST['NDetenciones']))                      $NDetenciones                       = $_POST['NDetenciones'];
	if (!empty($_POST['NErrores']))                          $NErrores                           = $_POST['NErrores'];
	if (!empty($_POST['NAlertas']))                          $NAlertas                           = $_POST['NAlertas'];
	if (!empty($_POST['idAlertaTemprana']))                  $idAlertaTemprana                   = $_POST['idAlertaTemprana'];
	if (!empty($_POST['AlertaTemprCritica']))                $AlertaTemprCritica                 = $_POST['AlertaTemprCritica'];
	if (!empty($_POST['AlertaTemprNormal']))                 $AlertaTemprNormal                  = $_POST['AlertaTemprNormal'];
	if (!empty($_POST['idUsoFTP']))                          $idUsoFTP                           = $_POST['idUsoFTP'];
	if (!empty($_POST['FTP_Carpeta']))                       $FTP_Carpeta                        = $_POST['FTP_Carpeta'];
	if (!empty($_POST['idBackup']))                          $idBackup                           = $_POST['idBackup'];
	if (!empty($_POST['NregBackup']))                        $NregBackup                         = $_POST['NregBackup'];
	if (!empty($_POST['idUbicacion']))                       $idUbicacion                        = $_POST['idUbicacion'];
	if (!empty($_POST['Estado']))                            $Estado                             = $_POST['Estado'];
	if (!empty($_POST['TiempoFueraLinea']))                  $TiempoFueraLinea                   = $_POST['TiempoFueraLinea'];
	if (!empty($_POST['TiempoDetencion']))                   $TiempoDetencion                    = $_POST['TiempoDetencion'];
	if (!empty($_POST['Direccion_img']))                     $Direccion_img                      = $_POST['Direccion_img'];
	if (!empty($_POST['idZona']))                            $idZona                             = $_POST['idZona'];
	if (!empty($_POST['IP_Client']))                         $IP_Client                          = $_POST['IP_Client'];
	if (!empty($_POST['SensorActivacionID']))                $SensorActivacionID                 = $_POST['SensorActivacionID'];
	if ( isset($_POST['SensorActivacionValor']))             $SensorActivacionValor              = $_POST['SensorActivacionValor'];
	if (!empty($_POST['Jornada_inicio']))                    $Jornada_inicio                     = $_POST['Jornada_inicio'];
	if (!empty($_POST['Jornada_termino']))                   $Jornada_termino                    = $_POST['Jornada_termino'];
	if (!empty($_POST['Colacion_inicio']))                   $Colacion_inicio                    = $_POST['Colacion_inicio'];
	if (!empty($_POST['Colacion_termino']))                  $Colacion_termino                   = $_POST['Colacion_termino'];
	if (!empty($_POST['Microparada']))                       $Microparada                        = $_POST['Microparada'];
	if (!empty($_POST['Capacidad']))                         $Capacidad                          = $_POST['Capacidad'];
	if (!empty($_POST['idUsoPredio']))                       $idUsoPredio                        = $_POST['idUsoPredio'];
	if (!empty($_POST['idTipo']))                            $idTipo                             = $_POST['idTipo'];
	if (!empty($_POST['Marca']))                             $Marca                              = $_POST['Marca'];
	if (!empty($_POST['Modelo']))                            $Modelo                             = $_POST['Modelo'];
	if (!empty($_POST['Patente']))                           $Patente                            = $_POST['Patente'];
	if (!empty($_POST['Num_serie']))                         $Num_serie                          = $_POST['Num_serie'];
	if (!empty($_POST['AnoFab']))                            $AnoFab                             = $_POST['AnoFab'];
	if (!empty($_POST['CapacidadPersonas']))                 $CapacidadPersonas                  = $_POST['CapacidadPersonas'];
	if (!empty($_POST['CapacidadKilos']))                    $CapacidadKilos                     = $_POST['CapacidadKilos'];
	if (!empty($_POST['MCubicos']))                          $MCubicos                           = $_POST['MCubicos'];
	if (!empty($_POST['idTab']))                             $idTab                              = $_POST['idTab'];
	if (!empty($_POST['idGrupoDespliegue']))                 $idGrupoDespliegue                  = $_POST['idGrupoDespliegue'];
	if (!empty($_POST['idGrupoVmonofasico']))                $idGrupoVmonofasico                 = $_POST['idGrupoVmonofasico'];
	if (!empty($_POST['idGrupoVTrifasico']))                 $idGrupoVTrifasico                  = $_POST['idGrupoVTrifasico'];
	if (!empty($_POST['idGrupoPotencia']))                   $idGrupoPotencia                    = $_POST['idGrupoPotencia'];
	if (!empty($_POST['idGrupoConsumoMesHabil']))            $idGrupoConsumoMesHabil             = $_POST['idGrupoConsumoMesHabil'];
	if (!empty($_POST['idGrupoConsumoMesCurso']))            $idGrupoConsumoMesCurso             = $_POST['idGrupoConsumoMesCurso'];
	if (!empty($_POST['idGrupoEstanque']))                   $idGrupoEstanque                    = $_POST['idGrupoEstanque'];
	if (!empty($_POST['CrossCrane_tiempo_revision']))        $CrossCrane_tiempo_revision         = $_POST['CrossCrane_tiempo_revision'];
	if (!empty($_POST['CrossCrane_grupo_amperaje']))         $CrossCrane_grupo_amperaje          = $_POST['CrossCrane_grupo_amperaje'];
	if (!empty($_POST['CrossCrane_grupo_elevacion']))        $CrossCrane_grupo_elevacion         = $_POST['CrossCrane_grupo_elevacion'];
	if (!empty($_POST['CrossCrane_grupo_giro']))             $CrossCrane_grupo_giro              = $_POST['CrossCrane_grupo_giro'];
	if (!empty($_POST['CrossCrane_grupo_carro']))            $CrossCrane_grupo_carro             = $_POST['CrossCrane_grupo_carro'];
	if (!empty($_POST['CrossCrane_grupo_voltaje']))          $CrossCrane_grupo_voltaje           = $_POST['CrossCrane_grupo_voltaje'];
	if (!empty($_POST['CrossCrane_grupo_motor_subida']))     $CrossCrane_grupo_motor_subida      = $_POST['CrossCrane_grupo_motor_subida'];
	if (!empty($_POST['CrossCrane_grupo_motor_bajada']))     $CrossCrane_grupo_motor_bajada      = $_POST['CrossCrane_grupo_motor_bajada'];
	if (!empty($_POST['MedicionTiempo']))                    $MedicionTiempo                     = $_POST['MedicionTiempo'];
	if (!empty($_POST['CrossCMinHorno']))                    $CrossCMinHorno                     = $_POST['CrossCMinHorno'];

	//Otros datos
	if (!empty($_POST['SensoresFechaUso_Fake']))             $SensoresFechaUso_Fake              = $_POST['SensoresFechaUso_Fake'];

	//Recorro la configuracion de los sensores
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		if (!empty($_POST['SensoresNombre_'.$i]))            $SensoresNombre[$i]         = $_POST['SensoresNombre_'.$i];
		if (!empty($_POST['SensoresTipo_'.$i]))              $SensoresTipo[$i]           = $_POST['SensoresTipo_'.$i];
		if (!empty($_POST['SensoresGrupo_'.$i]))             $SensoresGrupo[$i]          = $_POST['SensoresGrupo_'.$i];
		if (!empty($_POST['SensoresUniMed_'.$i]))            $SensoresUniMed[$i]         = $_POST['SensoresUniMed_'.$i];
		if (!empty($_POST['SensoresActivo_'.$i]))            $SensoresActivo[$i]         = $_POST['SensoresActivo_'.$i];
		if (!empty($_POST['SensoresUso_'.$i]))               $SensoresUso[$i]            = $_POST['SensoresUso_'.$i];
		if (!empty($_POST['SensoresFechaUso_'.$i]))          $SensoresFechaUso[$i]       = $_POST['SensoresFechaUso_'.$i];
		if (!empty($_POST['SensoresAccionC_'.$i]))           $SensoresAccionC[$i]        = $_POST['SensoresAccionC_'.$i];
		if (!empty($_POST['SensoresAccionT_'.$i]))           $SensoresAccionT[$i]        = $_POST['SensoresAccionT_'.$i];
		if (!empty($_POST['SensoresAccionMedC_'.$i]))        $SensoresAccionMedC_[$i]    = $_POST['SensoresAccionMedC_'.$i];
		if (!empty($_POST['SensoresAccionMedT_'.$i]))        $SensoresAccionMedT[$i]     = $_POST['SensoresAccionMedT_'.$i];
		if (!empty($_POST['SensoresAccionAlerta_'.$i]))      $SensoresAccionAlerta[$i]   = $_POST['SensoresAccionAlerta_'.$i];
		if (!empty($_POST['SensoresRevision_'.$i]))          $SensoresRevision[$i]       = $_POST['SensoresRevision_'.$i];
		if (!empty($_POST['SensoresRevisionGrupo_'.$i]))     $SensoresRevisionGrupo[$i]  = $_POST['SensoresRevisionGrupo_'.$i];
		if (!empty($_POST['SensoresMedActual_'.$i]))         $SensoresMedActual[$i]      = $_POST['SensoresMedActual_'.$i];
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
			case 'idTelemetria':                      if(empty($idTelemetria)){                      $error['idTelemetria']                  = 'error/No ha ingresado el id';}break;
			case 'idSistema':                         if(empty($idSistema)){                         $error['idSistema']                     = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':                          if(empty($idEstado)){                          $error['idEstado']                      = 'error/No ha seleccionado el estado';}break;
			case 'Identificador':                     if(empty($Identificador)){                     $error['Identificador']                 = 'error/No ha ingresado el identificador';}break;
			case 'Nombre':                            if(empty($Nombre)){                            $error['Nombre']                        = 'error/No ha ingresado el nombre';}break;
			case 'NumSerie':                          if(empty($NumSerie)){                          $error['NumSerie']                      = 'error/No ha ingresado el Numero de Serie';}break;
			case 'idCiudad':                          if(empty($idCiudad)){                          $error['idCiudad']                      = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':                          if(empty($idComuna)){                          $error['idComuna']                      = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':                         if(empty($Direccion)){                         $error['Direccion']                     = 'error/No ha ingresado la dirección';}break;
			case 'GeoLatitud':                        if(empty($GeoLatitud)){                        $error['GeoLatitud']                    = 'error/No ha ingresado la latitud';}break;
			case 'GeoLongitud':                       if(empty($GeoLongitud)){                       $error['GeoLongitud']                   = 'error/No ha ingresado la longitud';}break;
			case 'GeoErrores':                        if(empty($GeoErrores)){                        $error['GeoErrores']                    = 'error/No ha ingresado los errores';}break;
			case 'GeoVelocidad':                      if(empty($GeoVelocidad)){                      $error['GeoVelocidad']                  = 'error/No ha ingresado la velocidad';}break;
			case 'GeoDireccion':                      if(empty($GeoDireccion)){                      $error['GeoDireccion']                  = 'error/No ha ingresado la dirección';}break;
			case 'GeoMovimiento':                     if(empty($GeoMovimiento)){                     $error['GeoMovimiento']                 = 'error/No ha ingresado el movimiento';}break;
			case 'GeoTiempoDetencion':                if(empty($GeoTiempoDetencion)){                $error['GeoTiempoDetencion']            = 'error/No ha ingresado el tiempo de detencion';}break;
			case 'LastUpdateFecha':                   if(empty($LastUpdateFecha)){                   $error['LastUpdateFecha']               = 'error/No ha ingresado la fecha de actualizacion';}break;
			case 'LastUpdateHora':                    if(empty($LastUpdateHora)){                    $error['LastUpdateHora']                = 'error/No ha ingresado la hora de actualizacion';}break;
			case 'id_Geo':                            if(empty($id_Geo)){                            $error['id_Geo']                        = 'error/No ha seleccionado la geolocalizacion';}break;
			case 'id_Sensores':                       if(empty($id_Sensores)){                       $error['id_Sensores']                   = 'error/No ha seleccionado los sensores';}break;
			case 'cantSensores':                      if(empty($cantSensores)){                      $error['cantSensores']                  = 'error/No ha ingresado la cantidad de sensores';}break;
			case 'idDispositivo':                     if(empty($idDispositivo)){                     $error['idDispositivo']                 = 'error/No ha seleccionado el dispositivo';}break;
			case 'idShield':                          if(!isset($idShield)){                         $error['idShield']                      = 'error/No ha seleccionado la placa shield';}break;
			case 'idFormaEnvio':                      if(!isset($idFormaEnvio)){                     $error['idFormaEnvio']                  = 'error/No ha seleccionado una forma de envio';}break;
			case 'idGenerador':                       if(!isset($idGenerador)){                      $error['idGenerador']                   = 'error/No ha seleccionado la opción de uso de generador';}break;
			case 'idTelGenerador':                    if(!isset($idTelGenerador)){                   $error['idTelGenerador']                = 'error/No ha seleccionado el generador';}break;
			case 'FechaInsGen':                       if(!isset($FechaInsGen)){                      $error['FechaInsGen']                   = 'error/No ha ingresado la fecha de instalacion del generacion';}break;
			case 'Sim_Num_Tel':                       if(empty($Sim_Num_Tel)){                       $error['Sim_Num_Tel']                   = 'error/No ha ingresado el numero telefonico de la SIM';}break;
			case 'Sim_Num_Serie':                     if(empty($Sim_Num_Serie)){                     $error['Sim_Num_Serie']                 = 'error/No ha ingresado el numero de serie de la SIM';}break;
			case 'Sim_marca':                         if(empty($Sim_marca)){                         $error['Sim_marca']                     = 'error/No ha seleccionado la bodega';}break;
			case 'Sim_modelo':                        if(empty($Sim_modelo)){                        $error['Sim_modelo']                    = 'error/No ha seleccionado la ruta';}break;
			case 'Sim_Compania':                      if(empty($Sim_Compania)){                      $error['Sim_Compania']                  = 'error/No ha seleccionado al trabajador';}break;
			case 'idEstadoEncendido':                 if(empty($idEstadoEncendido)){                 $error['idEstadoEncendido']             = 'error/No ha seleccionado el estado de encendido';}break;
			case 'LimiteVelocidad':                   if(empty($LimiteVelocidad)){                   $error['LimiteVelocidad']               = 'error/No ha ingresado el limite de velocidad';}break;
			case 'IdentificadorEmpresa':              if(!isset($IdentificadorEmpresa)){             $error['IdentificadorEmpresa']          = 'error/No ha ingresado el identificador de la empresa';}break;
			case 'NDetenciones':                      if(empty($NDetenciones)){                      $error['NDetenciones']                  = 'error/No ha ingresado el numero de detenciones';}break;
			case 'NErrores':                          if(empty($NErrores)){                          $error['NErrores']                      = 'error/No ha ingresado el numero de errores';}break;
			case 'NAlertas':                          if(empty($NAlertas)){                          $error['NAlertas']                      = 'error/No ha ingresado el numero de alertas';}break;
			case 'idAlertaTemprana':                  if(empty($idAlertaTemprana)){                  $error['idAlertaTemprana']              = 'error/No ha Seleccionado si se envia la alerta temprana';}break;
			case 'AlertaTemprCritica':                if(empty($AlertaTemprCritica)){                $error['AlertaTemprCritica']            = 'error/No ha ingresado el tiempo de alerta temprana critica';}break;
			case 'AlertaTemprNormal':                 if(empty($AlertaTemprNormal)){                 $error['AlertaTemprNormal']             = 'error/No ha ingresado el tiempo de alerta temprana normal';}break;
			case 'idUsoFTP':                          if(empty($idUsoFTP)){                          $error['idUsoFTP']                      = 'error/No ha Seleccionado si utiliza carpeta';}break;
			case 'FTP_Carpeta':                       if(empty($FTP_Carpeta)){                       $error['FTP_Carpeta']                   = 'error/No ha ingresado el nombre de la carpeta';}break;
			case 'idBackup':                          if(empty($idBackup)){                          $error['idBackup']                      = 'error/No ha Seleccionado si se respalda la tabla relacionada';}break;
			case 'NregBackup':                        if(empty($NregBackup)){                        $error['NregBackup']                    = 'error/No ha ingresado la cantidad de registros a respaldar';}break;
			case 'idUbicacion':                       if(empty($idUbicacion)){                       $error['idUbicacion']                   = 'error/No ha seleccionado la ubicacion';}break;
			case 'Estado':                            if(empty($Estado)){                            $error['Estado']                        = 'error/No ha ingresado el Estado';}break;
			case 'TiempoFueraLinea':                  if(empty($TiempoFueraLinea)){                  $error['TiempoFueraLinea']              = 'error/No ha ingresado el tiempo fuera de linea';}break;
			case 'TiempoDetencion':                   if(empty($TiempoDetencion)){                   $error['TiempoDetencion']               = 'error/No ha ingresado el tiempo de detencion';}break;
			case 'idZona':                            if(empty($idZona)){                            $error['idZona']                        = 'error/No ha seleccionado la zona';}break;
			case 'IP_Client':                         if(empty($IP_Client)){                         $error['IP_Client']                     = 'error/No ha ingresado el IP del cliente';}break;
			case 'SensorActivacionID':                if(empty($SensorActivacionID)){                $error['SensorActivacionID']            = 'error/No ha seleccionado el sensor de activacion';}break;
			case 'SensorActivacionValor':             if(!isset($SensorActivacionValor)){            $error['SensorActivacionValor']         = 'error/No ha ingresado el valor del sensor de activacion';}break;
			case 'Jornada_inicio':                    if(empty($Jornada_inicio)){                    $error['Jornada_inicio']                = 'error/No ha ingresado la hora de inicio de la jornada de trabajo';}break;
			case 'Jornada_termino':                   if(empty($Jornada_termino)){                   $error['Jornada_termino']               = 'error/No ha ingresado la hora de termino de la jornada de trabajo';}break;
			case 'Colacion_inicio':                   if(empty($Colacion_inicio)){                   $error['Colacion_inicio']               = 'error/No ha ingresado la hora de inicio de la colacion';}break;
			case 'Colacion_termino':                  if(empty($Colacion_termino)){                  $error['Colacion_termino']              = 'error/No ha ingresado la hora de termino de la colacion';}break;
			case 'Microparada':                       if(empty($Microparada)){                       $error['Microparada']                   = 'error/No ha ingresado el tiempo de las microparadas';}break;
			case 'Capacidad':                         if(empty($Capacidad)){                         $error['Capacidad']                     = 'error/No ha ingresado la capacidad';}break;
			case 'idUsoPredio':                       if(empty($idUsoPredio)){                       $error['idUsoPredio']                   = 'error/No ha seleccionado el uso del predio';}break;
			case 'idTipo':                            if(empty($idTipo)){                            $error['idTipo']                        = 'error/No ha seleccionado el tipo de vehiculo';}break;
			case 'Marca':                             if(empty($Marca)){                             $error['Marca']                         = 'error/No ha ingresado la marca del vehiculo';}break;
			case 'Modelo':                            if(empty($Modelo)){                            $error['Modelo']                        = 'error/No ha ingresado el modelo del vehiculo';}break;
			case 'Patente':                           if(empty($Patente)){                           $error['Patente']                       = 'error/No ha ingresado la patente del vehiculo';}break;
			case 'Num_serie':                         if(empty($Num_serie)){                         $error['Num_serie']                     = 'error/No ha ingresado el numero de serie del vehiculo';}break;
			case 'AnoFab':                            if(empty($AnoFab)){                            $error['AnoFab']                        = 'error/No ha ingresado el año de fabricacion del vehiculo';}break;
			case 'CapacidadPersonas':                 if(empty($CapacidadPersonas)){                 $error['CapacidadPersonas']             = 'error/No ha ingresado la capacidad de personas del vehiculo';}break;
			case 'CapacidadKilos':                    if(empty($CapacidadKilos)){                    $error['CapacidadKilos']                = 'error/No ha ingresado la capacidad de kilos del vehiculo';}break;
			case 'MCubicos':                          if(empty($MCubicos)){                          $error['MCubicos']                      = 'error/No ha ingresado los metros cubicos del vehiculo';}break;
			case 'idTab':                             if(empty($idTab)){                             $error['idTab']                         = 'error/No ha seleccionado el tab de utilizacion';}break;
			case 'idGrupoDespliegue':                 if(empty($idGrupoDespliegue)){                 $error['idGrupoDespliegue']             = 'error/No ha seleccionado el grupo de despliegue';}break;
			case 'idGrupoVmonofasico':                if(empty($idGrupoVmonofasico)){                $error['idGrupoVmonofasico']            = 'error/No ha seleccionado el grupo de Voltaje monofasico';}break;
			case 'idGrupoVTrifasico':                 if(empty($idGrupoVTrifasico)){                 $error['idGrupoVTrifasico']             = 'error/No ha seleccionado el grupo de Voltaje Trifasico';}break;
			case 'idGrupoPotencia':                   if(empty($idGrupoPotencia)){                   $error['idGrupoPotencia']               = 'error/No ha seleccionado el grupo de Potencia';}break;
			case 'idGrupoConsumoMesHabil':            if(empty($idGrupoConsumoMesHabil)){            $error['idGrupoConsumoMesHabil']        = 'error/No ha seleccionado el grupo de Consumo Mes Habil';}break;
			case 'idGrupoConsumoMesCurso':            if(empty($idGrupoConsumoMesCurso)){            $error['idGrupoConsumoMesCurso']        = 'error/No ha seleccionado el grupo de Consumo Mes Curso';}break;
			case 'idGrupoEstanque':                   if(empty($idGrupoEstanque)){                   $error['idGrupoEstanque']               = 'error/No ha seleccionado el grupo de Estanque combustible';}break;
			case 'CrossCrane_tiempo_revision':        if(empty($CrossCrane_tiempo_revision)){        $error['CrossCrane_tiempo_revision']    = 'error/No ha ingresado el tiempo de revision';}break;
			case 'CrossCrane_grupo_amperaje':         if(empty($CrossCrane_grupo_amperaje)){         $error['CrossCrane_grupo_amperaje']     = 'error/No ha seleccionado el grupo de alimentacion';}break;
			case 'CrossCrane_grupo_elevacion':        if(empty($CrossCrane_grupo_elevacion)){        $error['CrossCrane_grupo_elevacion']    = 'error/No ha seleccionado el grupo de elevacion';}break;
			case 'CrossCrane_grupo_giro':             if(empty($CrossCrane_grupo_giro)){             $error['CrossCrane_grupo_giro']         = 'error/No ha seleccionado el grupo de giro';}break;
			case 'CrossCrane_grupo_carro':            if(empty($CrossCrane_grupo_carro)){            $error['CrossCrane_grupo_carro']        = 'error/No ha seleccionado el grupo de carro';}break;
			case 'CrossCrane_grupo_voltaje':          if(empty($CrossCrane_grupo_voltaje)){          $error['CrossCrane_grupo_voltaje']      = 'error/No ha seleccionado el grupo de voltaje';}break;
			case 'CrossCrane_grupo_motor_subida':     if(empty($CrossCrane_grupo_motor_subida)){     $error['CrossCrane_grupo_motor_subida'] = 'error/No ha seleccionado el grupo de motor de subida';}break;
			case 'CrossCrane_grupo_motor_bajada':     if(empty($CrossCrane_grupo_motor_bajada)){     $error['CrossCrane_grupo_motor_bajada'] = 'error/No ha seleccionado el grupo de motor de bajada';}break;
			case 'MedicionTiempo':                    if(empty($MedicionTiempo)){                    $error['MedicionTiempo']                = 'error/No ha ingresado la medicion de tiempo';}break;
			case 'CrossCMinHorno':                    if(empty($CrossCMinHorno)){                    $error['CrossCMinHorno']                = 'error/No ha ingresado la temperatura minima del horno';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Identificador) && $Identificador!=''){ $Identificador  = EstandarizarInput($Identificador);}
	if(isset($Nombre) && $Nombre!=''){               $Nombre         = EstandarizarInput($Nombre);}
	if(isset($NumSerie) && $NumSerie!=''){           $NumSerie       = EstandarizarInput($NumSerie);}
	if(isset($Direccion) && $Direccion!=''){         $Direccion      = EstandarizarInput($Direccion);}
	if(isset($Marca) && $Marca!=''){                 $Marca          = EstandarizarInput($Marca);}
	if(isset($Modelo) && $Modelo!=''){               $Modelo         = EstandarizarInput($Modelo);}
	if(isset($Patente) && $Patente!=''){             $Patente        = EstandarizarInput($Patente);}
	if(isset($Num_serie) && $Num_serie!=''){         $Num_serie      = EstandarizarInput($Num_serie);}
	if(isset($FTP_Carpeta) && $FTP_Carpeta!=''){     $FTP_Carpeta    = EstandarizarInput($FTP_Carpeta);}

	//Recorro la configuracion de los sensores
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		if (isset($SensoresNombre[$i])){     $SensoresNombre[$i]    = EstandarizarInput($SensoresNombre[$i]);}
	}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
//Si se ingresaron la utilizacion de los sensores
	if(isset($id_Sensores)&&$id_Sensores==1&&isset($cantSensores)&&$cantSensores==0){  $error['cantSensores'] = 'error/No ha ingresado la cantidad de sensores a utilizar';}
	if(isset($FTP_Carpeta)&&strpos($FTP_Carpeta, " ")){                                $error['FTP_Carpeta']  = 'error/El nombre de la carpeta FTP contiene espacios';}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Identificador)&&contar_palabras_censuradas($Identificador)!=0){  $error['Identificador'] = 'error/Edita Identificador, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($NumSerie)&&contar_palabras_censuradas($NumSerie)!=0){            $error['NumSerie']      = 'error/Edita Numero de Serie, contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){          $error['Direccion']     = 'error/Edita Direccion, contiene palabras no permitidas';}
	if(isset($Marca)&&contar_palabras_censuradas($Marca)!=0){                  $error['Marca']         = 'error/Edita Marca, contiene palabras no permitidas';}
	if(isset($Modelo)&&contar_palabras_censuradas($Modelo)!=0){                $error['Modelo']        = 'error/Edita Modelo, contiene palabras no permitidas';}
	if(isset($Patente)&&contar_palabras_censuradas($Patente)!=0){              $error['Patente']       = 'error/Edita Patente, contiene palabras no permitidas';}
	if(isset($Num_serie)&&contar_palabras_censuradas($Num_serie)!=0){          $error['Num_serie']     = 'error/Edita Num_serie, contiene palabras no permitidas';}
	if(isset($FTP_Carpeta)&&contar_palabras_censuradas($FTP_Carpeta)!=0){      $error['FTP_Carpeta']   = 'error/Edita FTP Carpeta, contiene palabras no permitidas';}

	//Recorro la configuracion de los sensores
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		if(isset($SensoresNombre[$i])&&contar_palabras_censuradas($SensoresNombre[$i])!=0){      $error['SensoresNombre'.$i]   = 'error/Edita FTP Sensores Nombre '.$i.', contiene palabras no permitidas';}
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

			//Verifico otros datos
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el dato existe
			if(isset($Identificador)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Nombre', 'telemetria_listado', '', "Identificador='".$Identificador."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ingresado ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El identificador ingresado ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                                          $SIS_data  = "'".$idSistema."'";                          }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                                            $SIS_data .= ",'".$idEstado."'";                          }else{$SIS_data .= ",''";}
				if(isset($Identificador) && $Identificador!=''){                                  $SIS_data .= ",'".$Identificador."'";                     }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                                $SIS_data .= ",'".$Nombre."'";                            }else{$SIS_data .= ",''";}
				if(isset($NumSerie) && $NumSerie!=''){                                            $SIS_data .= ",'".$NumSerie."'";                          }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                                            $SIS_data .= ",'".$idCiudad."'";                          }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                                            $SIS_data .= ",'".$idComuna."'";                          }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){                                          $SIS_data .= ",'".$Direccion."'";                         }else{$SIS_data .= ",''";}
				if(isset($GeoLatitud) && $GeoLatitud!=''){                                        $SIS_data .= ",'".$GeoLatitud."'";                        }else{$SIS_data .= ",''";}
				if(isset($GeoLongitud) && $GeoLongitud!=''){                                      $SIS_data .= ",'".$GeoLongitud."'";                       }else{$SIS_data .= ",''";}
				if(isset($GeoErrores) && $GeoErrores!=''){                                        $SIS_data .= ",'".$GeoErrores."'";                        }else{$SIS_data .= ",''";}
				if(isset($GeoVelocidad) && $GeoVelocidad!=''){                                    $SIS_data .= ",'".$GeoVelocidad."'";                      }else{$SIS_data .= ",''";}
				if(isset($GeoDireccion) && $GeoDireccion!=''){                                    $SIS_data .= ",'".$GeoDireccion."'";                      }else{$SIS_data .= ",''";}
				if(isset($GeoMovimiento) && $GeoMovimiento!=''){                                  $SIS_data .= ",'".$GeoMovimiento."'";                     }else{$SIS_data .= ",''";}
				if(isset($GeoTiempoDetencion) && $GeoTiempoDetencion!=''){                        $SIS_data .= ",'".$GeoTiempoDetencion."'";                }else{$SIS_data .= ",''";}
				if(isset($LastUpdateFecha) && $LastUpdateFecha!=''){                              $SIS_data .= ",'".$LastUpdateFecha."'";                   }else{$SIS_data .= ",''";}
				if(isset($LastUpdateHora) && $LastUpdateHora!=''){                                $SIS_data .= ",'".$LastUpdateHora."'";                    }else{$SIS_data .= ",''";}
				if(isset($id_Geo) && $id_Geo!=''){                                                $SIS_data .= ",'".$id_Geo."'";                            }else{$SIS_data .= ",''";}
				if(isset($id_Sensores) && $id_Sensores!=''){                                      $SIS_data .= ",'".$id_Sensores."'";                       }else{$SIS_data .= ",''";}
				if(isset($cantSensores) && $cantSensores!=''){                                    $SIS_data .= ",'".$cantSensores."'";                      }else{$SIS_data .= ",''";}
				if(isset($idDispositivo) && $idDispositivo!=''){                                  $SIS_data .= ",'".$idDispositivo."'";                     }else{$SIS_data .= ",''";}
				if(isset($idShield) && $idShield!=''){                                            $SIS_data .= ",'".$idShield."'";                          }else{$SIS_data .= ",''";}
				if(isset($idFormaEnvio) && $idFormaEnvio!=''){                                    $SIS_data .= ",'".$idFormaEnvio."'";                      }else{$SIS_data .= ",''";}
				if(isset($idGenerador) && $idGenerador!=''){                                      $SIS_data .= ",'".$idGenerador."'";                       }else{$SIS_data .= ",''";}
				if(isset($idTelGenerador) && $idTelGenerador!=''){                                $SIS_data .= ",'".$idTelGenerador."'";                    }else{$SIS_data .= ",''";}
				if(isset($FechaInsGen) && $FechaInsGen!=''){                                      $SIS_data .= ",'".$FechaInsGen."'";                       }else{$SIS_data .= ",''";}
				if(isset($Sim_Num_Tel) && $Sim_Num_Tel!=''){                                      $SIS_data .= ",'".$Sim_Num_Tel."'";                       }else{$SIS_data .= ",''";}
				if(isset($Sim_Num_Serie) && $Sim_Num_Serie!=''){                                  $SIS_data .= ",'".$Sim_Num_Serie."'";                     }else{$SIS_data .= ",''";}
				if(isset($Sim_marca) && $Sim_marca!=''){                                          $SIS_data .= ",'".$Sim_marca."'";                         }else{$SIS_data .= ",''";}
				if(isset($Sim_modelo) && $Sim_modelo!=''){                                        $SIS_data .= ",'".$Sim_modelo."'";                        }else{$SIS_data .= ",''";}
				if(isset($Sim_Compania) && $Sim_Compania!=''){                                    $SIS_data .= ",'".$Sim_Compania."'";                      }else{$SIS_data .= ",''";}
				if(isset($idEstadoEncendido) && $idEstadoEncendido!=''){                          $SIS_data .= ",'".$idEstadoEncendido."'";                 }else{$SIS_data .= ",''";}
				if(isset($LimiteVelocidad) && $LimiteVelocidad!=''){                              $SIS_data .= ",'".$LimiteVelocidad."'";                   }else{$SIS_data .= ",''";}
				if(isset($IdentificadorEmpresa) && $IdentificadorEmpresa!=''){                    $SIS_data .= ",'".$IdentificadorEmpresa."'";              }else{$SIS_data .= ",''";}
				if(isset($NDetenciones) && $NDetenciones!=''){                                    $SIS_data .= ",'".$NDetenciones."'";                      }else{$SIS_data .= ",''";}
				if(isset($NErrores) && $NErrores!=''){                                            $SIS_data .= ",'".$NErrores."'";                          }else{$SIS_data .= ",''";}
				if(isset($NAlertas) && $NAlertas!=''){                                            $SIS_data .= ",'".$NAlertas."'";                          }else{$SIS_data .= ",''";}
				if(isset($idAlertaTemprana) && $idAlertaTemprana!=''){                            $SIS_data .= ",'".$idAlertaTemprana."'";                  }else{$SIS_data .= ",''";}
				if(isset($AlertaTemprCritica) && $AlertaTemprCritica!=''){                        $SIS_data .= ",'".$AlertaTemprCritica."'";                }else{$SIS_data .= ",''";}
				if(isset($AlertaTemprNormal) && $AlertaTemprNormal!=''){                          $SIS_data .= ",'".$AlertaTemprNormal."'";                 }else{$SIS_data .= ",''";}
				if(isset($idUsoFTP) && $idUsoFTP!=''){                                            $SIS_data .= ",'".$idUsoFTP."'";                          }else{$SIS_data .= ",''";}
				if(isset($FTP_Carpeta) && $FTP_Carpeta!=''){                                      $SIS_data .= ",'".$FTP_Carpeta."'";                       }else{$SIS_data .= ",''";}
				if(isset($idBackup) && $idBackup!=''){                                            $SIS_data .= ",'".$idBackup."'";                          }else{$SIS_data .= ",''";}
				if(isset($NregBackup) && $NregBackup!=''){                                        $SIS_data .= ",'".$NregBackup."'";                        }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){                                      $SIS_data .= ",'".$idUbicacion."'";                       }else{$SIS_data .= ",''";}
				if(isset($Estado) && $Estado!=''){                                                $SIS_data .= ",'".$Estado."'";                            }else{$SIS_data .= ",''";}
				if(isset($TiempoFueraLinea) && $TiempoFueraLinea!=''){                            $SIS_data .= ",'".$TiempoFueraLinea."'";                  }else{$SIS_data .= ",''";}
				if(isset($TiempoDetencion) && $TiempoDetencion!=''){                              $SIS_data .= ",'".$TiempoDetencion."'";                   }else{$SIS_data .= ",''";}
				if(isset($Direccion_img) && $Direccion_img!=''){                                  $SIS_data .= ",'".$Direccion_img."'";                     }else{$SIS_data .= ",''";}
				if(isset($idZona) && $idZona!=''){                                                $SIS_data .= ",'".$idZona."'";                            }else{$SIS_data .= ",''";}
				if(isset($IP_Client) && $IP_Client!=''){                                          $SIS_data .= ",'".$IP_Client."'";                         }else{$SIS_data .= ",''";}
				if(isset($SensorActivacionID) && $SensorActivacionID!=''){                        $SIS_data .= ",'".$SensorActivacionID."'";                }else{$SIS_data .= ",''";}
				if(isset($SensorActivacionValor) && $SensorActivacionValor!=''){                  $SIS_data .= ",'".$SensorActivacionValor."'";             }else{$SIS_data .= ",''";}
				if(isset($Jornada_inicio) && $Jornada_inicio!=''){                                $SIS_data .= ",'".$Jornada_inicio."'";                    }else{$SIS_data .= ",''";}
				if(isset($Jornada_termino) && $Jornada_termino!=''){                              $SIS_data .= ",'".$Jornada_termino."'";                   }else{$SIS_data .= ",''";}
				if(isset($Colacion_inicio) && $Colacion_inicio!=''){                              $SIS_data .= ",'".$Colacion_inicio."'";                   }else{$SIS_data .= ",''";}
				if(isset($Colacion_termino) && $Colacion_termino!=''){                            $SIS_data .= ",'".$Colacion_termino."'";                  }else{$SIS_data .= ",''";}
				if(isset($Microparada) && $Microparada!=''){                                      $SIS_data .= ",'".$Microparada."'";                       }else{$SIS_data .= ",''";}
				if(isset($Capacidad) && $Capacidad!=''){                                          $SIS_data .= ",'".$Capacidad."'";                         }else{$SIS_data .= ",''";}
				if(isset($idUsoPredio) && $idUsoPredio!=''){                                      $SIS_data .= ",'".$idUsoPredio."'";                       }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                                                $SIS_data .= ",'".$idTipo."'";                            }else{$SIS_data .= ",''";}
				if(isset($Marca) && $Marca!=''){                                                  $SIS_data .= ",'".$Marca."'";                             }else{$SIS_data .= ",''";}
				if(isset($Modelo) && $Modelo!=''){                                                $SIS_data .= ",'".$Modelo."'";                            }else{$SIS_data .= ",''";}
				if(isset($Patente) && $Patente!=''){                                              $SIS_data .= ",'".$Patente."'";                           }else{$SIS_data .= ",''";}
				if(isset($Num_serie) && $Num_serie!=''){                                          $SIS_data .= ",'".$Num_serie."'";                         }else{$SIS_data .= ",''";}
				if(isset($AnoFab) && $AnoFab!=''){                                                $SIS_data .= ",'".$AnoFab."'";                            }else{$SIS_data .= ",''";}
				if(isset($CapacidadPersonas) && $CapacidadPersonas!=''){                          $SIS_data .= ",'".$CapacidadPersonas."'";                 }else{$SIS_data .= ",''";}
				if(isset($CapacidadKilos) && $CapacidadKilos!=''){                                $SIS_data .= ",'".$CapacidadKilos."'";                    }else{$SIS_data .= ",''";}
				if(isset($MCubicos) && $MCubicos!=''){                                            $SIS_data .= ",'".$MCubicos."'";                          }else{$SIS_data .= ",''";}
				if(isset($idTab) && $idTab!=''){                                                  $SIS_data .= ",'".$idTab."'";                             }else{$SIS_data .= ",''";}
				if(isset($idGrupoDespliegue) && $idGrupoDespliegue!=''){                          $SIS_data .= ",'".$idGrupoDespliegue."'";                 }else{$SIS_data .= ",''";}
				if(isset($idGrupoVmonofasico) && $idGrupoVmonofasico!=''){                        $SIS_data .= ",'".$idGrupoVmonofasico."'";                }else{$SIS_data .= ",''";}
				if(isset($idGrupoVTrifasico) && $idGrupoVTrifasico!=''){                          $SIS_data .= ",'".$idGrupoVTrifasico."'";                 }else{$SIS_data .= ",''";}
				if(isset($idGrupoPotencia) && $idGrupoPotencia!=''){                              $SIS_data .= ",'".$idGrupoPotencia."'";                   }else{$SIS_data .= ",''";}
				if(isset($idGrupoConsumoMesHabil) && $idGrupoConsumoMesHabil!=''){                $SIS_data .= ",'".$idGrupoConsumoMesHabil."'";            }else{$SIS_data .= ",''";}
				if(isset($idGrupoConsumoMesCurso) && $idGrupoConsumoMesCurso!=''){                $SIS_data .= ",'".$idGrupoConsumoMesCurso."'";            }else{$SIS_data .= ",''";}
				if(isset($idGrupoEstanque) && $idGrupoEstanque!=''){                              $SIS_data .= ",'".$idGrupoEstanque."'";                   }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_tiempo_revision) && $CrossCrane_tiempo_revision!=''){        $SIS_data .= ",'".$CrossCrane_tiempo_revision."'";        }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_grupo_amperaje) && $CrossCrane_grupo_amperaje!=''){          $SIS_data .= ",'".$CrossCrane_grupo_amperaje."'";         }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_grupo_elevacion) && $CrossCrane_grupo_elevacion!=''){        $SIS_data .= ",'".$CrossCrane_grupo_elevacion."'";        }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_grupo_giro) && $CrossCrane_grupo_giro!=''){                  $SIS_data .= ",'".$CrossCrane_grupo_giro."'";             }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_grupo_carro) && $CrossCrane_grupo_carro!=''){                $SIS_data .= ",'".$CrossCrane_grupo_carro."'";            }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_grupo_voltaje) && $CrossCrane_grupo_voltaje!=''){            $SIS_data .= ",'".$CrossCrane_grupo_voltaje."'";          }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_grupo_motor_subida) && $CrossCrane_grupo_motor_subida!=''){  $SIS_data .= ",'".$CrossCrane_grupo_motor_subida."'";     }else{$SIS_data .= ",''";}
				if(isset($CrossCrane_grupo_motor_bajada) && $CrossCrane_grupo_motor_bajada!=''){  $SIS_data .= ",'".$CrossCrane_grupo_motor_bajada."'";     }else{$SIS_data .= ",''";}
				if(isset($MedicionTiempo) && $MedicionTiempo!=''){                                $SIS_data .= ",'".$MedicionTiempo."'";                    }else{$SIS_data .= ",''";}
				if(isset($CrossCMinHorno) && $CrossCMinHorno!=''){                                $SIS_data .= ",'".$CrossCMinHorno."'";                    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idEstado,Identificador,Nombre,NumSerie,idCiudad,idComuna,Direccion,GeoLatitud,GeoLongitud,GeoErrores,
				GeoVelocidad,GeoDireccion,GeoMovimiento,GeoTiempoDetencion,LastUpdateFecha,LastUpdateHora,id_Geo,id_Sensores,cantSensores,
				idDispositivo,idShield,idFormaEnvio,idGenerador,idTelGenerador,FechaInsGen,Sim_Num_Tel,Sim_Num_Serie,Sim_marca,Sim_modelo,
				Sim_Compania,idEstadoEncendido,LimiteVelocidad,IdentificadorEmpresa,NDetenciones,NErrores,NAlertas,idAlertaTemprana,
				AlertaTemprCritica,AlertaTemprNormal,idUsoFTP,FTP_Carpeta,idBackup,NregBackup,idUbicacion,Estado,TiempoFueraLinea,
				TiempoDetencion,Direccion_img,idZona,IP_Client,SensorActivacionID,SensorActivacionValor,Jornada_inicio,Jornada_termino,
				Colacion_inicio,Colacion_termino,Microparada,Capacidad,idUsoPredio,idTipo,Marca,Modelo,Patente,Num_serie,AnoFab,
				CapacidadPersonas,CapacidadKilos,MCubicos,idTab,idGrupoDespliegue,idGrupoVmonofasico,idGrupoVTrifasico,idGrupoPotencia,
				idGrupoConsumoMesHabil,idGrupoConsumoMesCurso,idGrupoEstanque,CrossCrane_tiempo_revision,CrossCrane_grupo_amperaje,
				CrossCrane_grupo_elevacion,CrossCrane_grupo_giro,CrossCrane_grupo_carro,CrossCrane_grupo_voltaje,CrossCrane_grupo_motor_subida,
				CrossCrane_grupo_motor_bajada,MedicionTiempo,CrossCMinHorno';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/********************************************************************************/
					//Variables
					$SIS_data  = "'".$ultimo_id."'"; //idTelemetria
					$SIS_columns = 'idTelemetria';   //Columna

					//Creo registro dentro de cada tabla relacionada a los sensores
					$ultimo_id_1  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_accion_alerta', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_2  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_accion_c', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_3  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_accion_med_c', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_4  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_accion_med_t', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_5  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_accion_t', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_6  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_activo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_7  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_grupo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_8  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_med_actual', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_9  = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_nombre', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_10 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_revision', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_11 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_revision_grupo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_12 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_tipo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_13 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_unimed', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_14 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_uso', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_15 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_sensores_uso_fecha', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/********************************************************************************/
					// elimino la tabla si es que existe
					$query  = "DROP TABLE IF EXISTS `telemetria_listado_tablarelacionada_".$ultimo_id."`";
					$result = mysqli_query($dbConn, $query);

					//Variable para columnas
					$tr_column = '';
					//Recorro la configuracion de los sensores
					for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
						$tr_column .= '`Sensor_'.$i.'` decimal(20,6) NOT NULL,';
					}
					// se crea la nueva tabla
					$query  = "CREATE TABLE `telemetria_listado_tablarelacionada_".$ultimo_id."` (
					`idTabla` int(11) unsigned NOT NULL AUTO_INCREMENT,
					`idTelemetria` int(11) unsigned NOT NULL,
					`idSolicitud` int(11) unsigned NOT NULL,
					`idZona` int(11) unsigned NOT NULL,
					`FechaSistema` date NOT NULL,
					`HoraSistema` time NOT NULL,
					`TimeStamp` datetime NOT NULL,
					`GeoLatitud` double NOT NULL,
					`GeoLongitud` double NOT NULL,
					`GeoVelocidad` decimal(20,6) NOT NULL,
					`GeoDireccion` decimal(20,6) NOT NULL,
					`GeoMovimiento` decimal(20,6) NOT NULL,
					`Segundos` int(11) unsigned NOT NULL,
					`Diferencia` decimal(20,6) NOT NULL,
					".$tr_column."
					  PRIMARY KEY (`idTabla`,`FechaSistema`,`HoraSistema`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Dinamica';";
					$result = mysqli_query($dbConn, $query);

					/*******************************************************/
					//se actualizan los datos
					$SIS_data = "Identificador='".$ultimo_id."'";
					$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$ultimo_id.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta (siempre pasa)
					$resultado=true;
					if($resultado==true){
						//redirijo
						header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Verifico otros datos
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idTelemetria!='".$idTelemetria."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el dato existe
			if(isset($Identificador)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Nombre', 'telemetria_listado', '', "Identificador='".$Identificador."' AND idSistema='".$idSistema."' AND idTelemetria!='".$idTelemetria."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el dato existe
			if(isset($idBackup)&&isset($NregBackup)){
				//verifico que la configuracion sea valida
				if($idBackup==1&&$NregBackup!=0){
					//configuracion correcta
				}else{
					$ndata_3++;
				}
			}elseif(isset($idBackup)&&$idBackup==1&&!isset($NregBackup)){
				$ndata_3++;
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ingresado ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El identificador ingresado ya existe';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/La configuracion del Backup es incorrecta, ingrese el numero de registros a mantener';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//Filtros
				$SIS_data = "idTelemetria='".$idTelemetria."'";
				if(isset($idSistema) && $idSistema!=''){                                                $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                                                  $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Identificador) && $Identificador!=''){                                        $SIS_data .= ",Identificador='".$Identificador."'";}
				if(isset($Nombre) && $Nombre!=''){                                                      $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($NumSerie) && $NumSerie!=''){                                                  $SIS_data .= ",NumSerie='".$NumSerie."'";}
				if(isset($idCiudad) && $idCiudad!=''){                                                  $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){                                                  $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){                                                $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($GeoLatitud) && $GeoLatitud!=''){                                              $SIS_data .= ",GeoLatitud='".$GeoLatitud."'";}
				if(isset($GeoLongitud) && $GeoLongitud!=''){                                            $SIS_data .= ",GeoLongitud='".$GeoLongitud."'";}
				if(isset($GeoErrores) && $GeoErrores!=''){                                              $SIS_data .= ",GeoErrores='".$GeoErrores."'";}
				if(isset($GeoVelocidad) && $GeoVelocidad!=''){                                          $SIS_data .= ",GeoVelocidad='".$GeoVelocidad."'";}
				if(isset($GeoDireccion) && $GeoDireccion!=''){                                          $SIS_data .= ",GeoDireccion='".$GeoDireccion."'";}
				if(isset($GeoMovimiento) && $GeoMovimiento!=''){                                        $SIS_data .= ",GeoMovimiento='".$GeoMovimiento."'";}
				if(isset($GeoTiempoDetencion) && $GeoTiempoDetencion!=''){                              $SIS_data .= ",GeoTiempoDetencion='".$GeoTiempoDetencion."'";}
				if(isset($LastUpdateFecha) && $LastUpdateFecha!=''){                                    $SIS_data .= ",LastUpdateFecha='".$LastUpdateFecha."'";}
				if(isset($LastUpdateHora) && $LastUpdateHora!=''){                                      $SIS_data .= ",LastUpdateHora='".$LastUpdateHora."'";}
				if(isset($id_Geo) && $id_Geo!=''){                                                      $SIS_data .= ",id_Geo='".$id_Geo."'";}
				if(isset($id_Sensores) && $id_Sensores!=''){                                            $SIS_data .= ",id_Sensores='".$id_Sensores."'";}
				if(isset($cantSensores) && $cantSensores!=''){                                          $SIS_data .= ",cantSensores='".$cantSensores."'";}
				if(isset($idDispositivo) && $idDispositivo!=''){                                        $SIS_data .= ",idDispositivo='".$idDispositivo."'";}
				if(isset($idShield) ){                                                                  $SIS_data .= ",idShield='".$idShield."'";}
				if(isset($idFormaEnvio) ){                                                              $SIS_data .= ",idFormaEnvio='".$idFormaEnvio."'";}
				if(isset($idGenerador) && $idGenerador!=''){                                            $SIS_data .= ",idGenerador='".$idGenerador."'";}
				if(isset($idTelGenerador) && $idTelGenerador!=''){                                      $SIS_data .= ",idTelGenerador='".$idTelGenerador."'";}
				if(isset($FechaInsGen) && $FechaInsGen!=''){                                            $SIS_data .= ",FechaInsGen='".$FechaInsGen."'";}
				if(isset($Sim_Num_Tel) && $Sim_Num_Tel!=''){                                            $SIS_data .= ",Sim_Num_Tel='".$Sim_Num_Tel."'";}
				if(isset($Sim_Num_Serie) && $Sim_Num_Serie!=''){                                        $SIS_data .= ",Sim_Num_Serie='".$Sim_Num_Serie."'";}
				if(isset($Sim_marca) && $Sim_marca!=''){                                                $SIS_data .= ",Sim_marca='".$Sim_marca."'";}
				if(isset($Sim_modelo) && $Sim_modelo!=''){                                              $SIS_data .= ",Sim_modelo='".$Sim_modelo."'";}
				if(isset($Sim_Compania) && $Sim_Compania!=''){                                          $SIS_data .= ",Sim_Compania='".$Sim_Compania."'";}
				if(isset($idEstadoEncendido) && $idEstadoEncendido!=''){                                $SIS_data .= ",idEstadoEncendido='".$idEstadoEncendido."'";}
				if(isset($LimiteVelocidad) && $LimiteVelocidad!=''){                                    $SIS_data .= ",LimiteVelocidad='".$LimiteVelocidad."'";}
				if(isset($IdentificadorEmpresa) ){                                                      $SIS_data .= ",IdentificadorEmpresa='".$IdentificadorEmpresa."'";}
				if(isset($NDetenciones) && $NDetenciones!=''){                                          $SIS_data .= ",NDetenciones='".$NDetenciones."'";}
				if(isset($NErrores) && $NErrores!=''){                                                  $SIS_data .= ",NErrores='".$NErrores."'";}
				if(isset($NAlertas) && $NAlertas!=''){                                                  $SIS_data .= ",NAlertas='".$NAlertas."'";}
				if(isset($idAlertaTemprana)&& $idAlertaTemprana != '' ){                                $SIS_data .= ",idAlertaTemprana='".$idAlertaTemprana."'";}
				if(isset($AlertaTemprCritica)&& $AlertaTemprCritica != '' ){                            $SIS_data .= ",AlertaTemprCritica='".$AlertaTemprCritica."'";}
				if(isset($AlertaTemprNormal)&& $AlertaTemprNormal != '' ){                              $SIS_data .= ",AlertaTemprNormal='".$AlertaTemprNormal."'";}
				if(isset($idUsoFTP)&& $idUsoFTP != '' ){                                                $SIS_data .= ",idUsoFTP='".$idUsoFTP."'";}
				if(isset($FTP_Carpeta)&& $FTP_Carpeta != '' ){                                          $SIS_data .= ",FTP_Carpeta='".$FTP_Carpeta."'";}
				if(isset($idBackup)&& $idBackup != '' ){                                                $SIS_data .= ",idBackup='".$idBackup."'";}
				if(isset($NregBackup) && $NregBackup!=''){                                              $SIS_data .= ",NregBackup='".$NregBackup."'";}
				if(isset($idUbicacion) && $idUbicacion!=''){                                            $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
				if(isset($Estado) && $Estado!=''){                                                      $SIS_data .= ",Estado='".$Estado."'";}
				if(isset($TiempoFueraLinea) && $TiempoFueraLinea!=''){                                  $SIS_data .= ",TiempoFueraLinea='".$TiempoFueraLinea."'";}
				if(isset($TiempoDetencion) && $TiempoDetencion!=''){                                    $SIS_data .= ",TiempoDetencion='".$TiempoDetencion."'";}
				if(isset($Direccion_img) && $Direccion_img!=''){                                        $SIS_data .= ",Direccion_img='".$Direccion_img."'";}
				if(isset($idZona) && $idZona!=''){                                                      $SIS_data .= ",idZona='".$idZona."'";}
				if(isset($IP_Client)&& $IP_Client != '' ){                                              $SIS_data .= ",IP_Client='".$IP_Client."'";}
				if(isset($SensorActivacionID) && $SensorActivacionID!=''){                              $SIS_data .= ",SensorActivacionID='".$SensorActivacionID."'";}
				if(isset($SensorActivacionValor) ){                                                     $SIS_data .= ",SensorActivacionValor='".$SensorActivacionValor."'";}
				if(isset($Jornada_inicio)&& $Jornada_inicio != '' ){                                    $SIS_data .= ",Jornada_inicio='".$Jornada_inicio."'";}
				if(isset($Jornada_termino)&& $Jornada_termino != '' ){                                  $SIS_data .= ",Jornada_termino='".$Jornada_termino."'";}
				if(isset($Colacion_inicio)&& $Colacion_inicio != '' ){                                  $SIS_data .= ",Colacion_inicio='".$Colacion_inicio."'";}
				if(isset($Colacion_termino)&& $Colacion_termino != '' ){                                $SIS_data .= ",Colacion_termino='".$Colacion_termino."'";}
				if(isset($Microparada)&& $Microparada != '' ){                                          $SIS_data .= ",Microparada='".$Microparada."'";}
				if(isset($Capacidad)&& $Capacidad != '' ){                                              $SIS_data .= ",Capacidad='".$Capacidad."'";}
				if(isset($idUsoPredio)&& $idUsoPredio != '' ){                                          $SIS_data .= ",idUsoPredio='".$idUsoPredio."'";}
				if(isset($idTipo)&& $idTipo != '' ){                                                    $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($Marca)&& $Marca != '' ){                                                      $SIS_data .= ",Marca='".$Marca."'";}
				if(isset($Modelo)&& $Modelo != '' ){                                                    $SIS_data .= ",Modelo='".$Modelo."'";}
				if(isset($Patente)&& $Patente != '' ){                                                  $SIS_data .= ",Patente='".$Patente."'";}
				if(isset($Num_serie)&& $Num_serie != '' ){                                              $SIS_data .= ",Num_serie='".$Num_serie."'";}
				if(isset($AnoFab)&& $AnoFab != '' ){                                                    $SIS_data .= ",AnoFab='".$AnoFab."'";}
				if(isset($CapacidadPersonas)&& $CapacidadPersonas != '' ){                              $SIS_data .= ",CapacidadPersonas='".$CapacidadPersonas."'";}
				if(isset($CapacidadKilos)&& $CapacidadKilos != '' ){                                    $SIS_data .= ",CapacidadKilos='".$CapacidadKilos."'";}
				if(isset($MCubicos)&& $MCubicos != '' ){                                                $SIS_data .= ",MCubicos='".$MCubicos."'";}
				if(isset($idTab)&& $idTab != '' ){                                                      $SIS_data .= ",idTab='".$idTab."'";}
				if(isset($idGrupoDespliegue)&& $idGrupoDespliegue != '' ){                              $SIS_data .= ",idGrupoDespliegue='".$idGrupoDespliegue."'";}
				if(isset($idGrupoVmonofasico)&& $idGrupoVmonofasico != '' ){                            $SIS_data .= ",idGrupoVmonofasico='".$idGrupoVmonofasico."'";}
				if(isset($idGrupoVTrifasico)&& $idGrupoVTrifasico != '' ){                              $SIS_data .= ",idGrupoVTrifasico='".$idGrupoVTrifasico."'";}
				if(isset($idGrupoPotencia)&& $idGrupoPotencia != '' ){                                  $SIS_data .= ",idGrupoPotencia='".$idGrupoPotencia."'";}
				if(isset($idGrupoConsumoMesHabil)&& $idGrupoConsumoMesHabil != '' ){                    $SIS_data .= ",idGrupoConsumoMesHabil='".$idGrupoConsumoMesHabil."'";}
				if(isset($idGrupoConsumoMesCurso)&& $idGrupoConsumoMesCurso != '' ){                    $SIS_data .= ",idGrupoConsumoMesCurso='".$idGrupoConsumoMesCurso."'";}
				if(isset($idGrupoEstanque)&& $idGrupoEstanque != '' ){                                  $SIS_data .= ",idGrupoEstanque='".$idGrupoEstanque."'";}
				if(isset($CrossCrane_tiempo_revision)&& $CrossCrane_tiempo_revision != '' ){            $SIS_data .= ",CrossCrane_tiempo_revision='".$CrossCrane_tiempo_revision."'";}
				if(isset($CrossCrane_grupo_amperaje)&& $CrossCrane_grupo_amperaje != '' ){              $SIS_data .= ",CrossCrane_grupo_amperaje='".$CrossCrane_grupo_amperaje."'";}
				if(isset($CrossCrane_grupo_elevacion)&& $CrossCrane_grupo_elevacion != '' ){            $SIS_data .= ",CrossCrane_grupo_elevacion='".$CrossCrane_grupo_elevacion."'";}
				if(isset($CrossCrane_grupo_giro)&& $CrossCrane_grupo_giro != '' ){                      $SIS_data .= ",CrossCrane_grupo_giro='".$CrossCrane_grupo_giro."'";}
				if(isset($CrossCrane_grupo_carro)&& $CrossCrane_grupo_carro != '' ){                    $SIS_data .= ",CrossCrane_grupo_carro='".$CrossCrane_grupo_carro."'";}
				if(isset($CrossCrane_grupo_voltaje)&& $CrossCrane_grupo_voltaje != '' ){                $SIS_data .= ",CrossCrane_grupo_voltaje='".$CrossCrane_grupo_voltaje."'";}
				if(isset($CrossCrane_grupo_motor_subida)&& $CrossCrane_grupo_motor_subida != '' ){      $SIS_data .= ",CrossCrane_grupo_motor_subida='".$CrossCrane_grupo_motor_subida."'";}
				if(isset($CrossCrane_grupo_motor_bajada)&& $CrossCrane_grupo_motor_bajada != '' ){      $SIS_data .= ",CrossCrane_grupo_motor_bajada='".$CrossCrane_grupo_motor_bajada."'";}
				if(isset($MedicionTiempo)&& $MedicionTiempo != '' ){                                    $SIS_data .= ",MedicionTiempo='".$MedicionTiempo."'";}
				if(isset($CrossCMinHorno)&& $CrossCMinHorno != '' ){                                    $SIS_data .= ",CrossCMinHorno='".$CrossCMinHorno."'";}

				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************/
				//variables
				$SIS_data_1  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_2  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_3  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_4  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_5  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_6  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_7  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_8  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_9  = "idTelemetria='".$idTelemetria."'";
				$SIS_data_10 = "idTelemetria='".$idTelemetria."'";
				$SIS_data_11 = "idTelemetria='".$idTelemetria."'";
				$SIS_data_12 = "idTelemetria='".$idTelemetria."'";
				$SIS_data_13 = "idTelemetria='".$idTelemetria."'";
				$SIS_data_14 = "idTelemetria='".$idTelemetria."'";
				$SIS_data_15 = "idTelemetria='".$idTelemetria."'";

				//Recorro la configuracion de los sensores
				for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
					if(isset($SensoresNombre[$i]) && $SensoresNombre[$i]!=''){                 $SIS_data_1  .= ",SensoresNombre_".$i."='".$SensoresNombre[$i]."'";}
					if(isset($SensoresTipo[$i]) && $SensoresTipo[$i]!=''){                     $SIS_data_2  .= ",SensoresTipo_".$i."='".$SensoresTipo[$i]."'";}
					if(isset($SensoresGrupo[$i]) && $SensoresGrupo[$i]!=''){                   $SIS_data_3  .= ",SensoresGrupo_".$i."='".$SensoresGrupo[$i]."'";}
					if(isset($SensoresUniMed[$i]) && $SensoresUniMed[$i]!=''){                 $SIS_data_4  .= ",SensoresUniMed_".$i."='".$SensoresUniMed[$i]."'";}
					if(isset($SensoresActivo[$i]) && $SensoresActivo[$i]!=''){                 $SIS_data_5  .= ",SensoresActivo_".$i."='".$SensoresActivo[$i]."'";}
					if(isset($SensoresUso[$i]) && $SensoresUso[$i]!=''){                       $SIS_data_6  .= ",SensoresUso_".$i."='".$SensoresUso[$i]."'";}
					if(isset($SensoresFechaUso[$i]) && $SensoresFechaUso[$i]!=''){             $SIS_data_7  .= ",SensoresFechaUso_".$i."='".$SensoresFechaUso[$i]."'";}
					if(isset($SensoresAccionC[$i]) && $SensoresAccionC[$i]!=''){               $SIS_data_8  .= ",SensoresAccionC_".$i."='".$SensoresAccionC[$i]."'";}
					if(isset($SensoresAccionT[$i]) && $SensoresAccionT[$i]!=''){               $SIS_data_9  .= ",SensoresAccionT_".$i."='".($SensoresAccionT[$i]*3600)."'";}
					if(isset($SensoresAccionMedC[$i]) && $SensoresAccionMedC[$i]!=''){         $SIS_data_10 .= ",SensoresAccionMedC_".$i."='".$SensoresAccionMedC[$i]."'";}
					if(isset($SensoresAccionMedT[$i]) && $SensoresAccionMedT[$i]!=''){         $SIS_data_11 .= ",SensoresAccionMedT_".$i."='".$SensoresAccionMedT[$i]."'";}
					if(isset($SensoresAccionAlerta[$i]) && $SensoresAccionAlerta[$i]!=''){     $SIS_data_12 .= ",SensoresAccionAlerta_".$i."='".$SensoresAccionAlerta[$i]."'";}
					if(isset($SensoresRevision[$i]) && $SensoresRevision[$i]!=''){             $SIS_data_13 .= ",SensoresRevision_".$i."='".$SensoresRevision[$i]."'";}
					if(isset($SensoresRevisionGrupo[$i]) && $SensoresRevisionGrupo[$i]!=''){   $SIS_data_14 .= ",SensoresRevisionGrupo_".$i."='".$SensoresRevisionGrupo[$i]."'";}
					if(isset($SensoresMedActual[$i]) && $SensoresMedActual[$i]!=''){           $SIS_data_15 .= ",SensoresMedActual_".$i."='".$SensoresMedActual[$i]."'";}

					if(isset($SensoresFechaUso[$i]) && $SensoresFechaUso[$i] != ''&&$SensoresFechaUso[$i]!=$SensoresFechaUso_Fake){
						$SIS_data_7  .= ",SensoresFechaUso_".$i."='".$SensoresFechaUso[$i]."'";
						$SIS_data_10 .= ",SensoresAccionMedC_".$i."=''";
						$SIS_data_11 .= ",SensoresAccionMedT_".$i."=''";
					}
				}

				//si hay cambios actualizo
				if(isset($SIS_data_1)&&$SIS_data_1!="idTelemetria='".$idTelemetria."'"){   $resultado1  = db_update_data (false, $SIS_data_1, 'telemetria_listado_sensores_nombre', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_2)&&$SIS_data_2!="idTelemetria='".$idTelemetria."'"){   $resultado2  = db_update_data (false, $SIS_data_2, 'telemetria_listado_sensores_tipo', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_3)&&$SIS_data_3!="idTelemetria='".$idTelemetria."'"){   $resultado3  = db_update_data (false, $SIS_data_3, 'telemetria_listado_sensores_grupo', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_4)&&$SIS_data_4!="idTelemetria='".$idTelemetria."'"){   $resultado4  = db_update_data (false, $SIS_data_4, 'telemetria_listado_sensores_unimed', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_5)&&$SIS_data_5!="idTelemetria='".$idTelemetria."'"){   $resultado5  = db_update_data (false, $SIS_data_5, 'telemetria_listado_sensores_activo', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_6)&&$SIS_data_6!="idTelemetria='".$idTelemetria."'"){   $resultado6  = db_update_data (false, $SIS_data_6, 'telemetria_listado_sensores_uso', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_7)&&$SIS_data_7!="idTelemetria='".$idTelemetria."'"){   $resultado7  = db_update_data (false, $SIS_data_7, 'telemetria_listado_sensores_uso_fecha', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_8)&&$SIS_data_8!="idTelemetria='".$idTelemetria."'"){   $resultado8  = db_update_data (false, $SIS_data_8, 'telemetria_listado_sensores_accion_c', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_9)&&$SIS_data_9!="idTelemetria='".$idTelemetria."'"){   $resultado9  = db_update_data (false, $SIS_data_9, 'telemetria_listado_sensores_accion_t', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_10)&&$SIS_data_10!="idTelemetria='".$idTelemetria."'"){ $resultado10 = db_update_data (false, $SIS_data_10, 'telemetria_listado_sensores_accion_med_c', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_11)&&$SIS_data_11!="idTelemetria='".$idTelemetria."'"){ $resultado11 = db_update_data (false, $SIS_data_11, 'telemetria_listado_sensores_accion_med_t', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_12)&&$SIS_data_12!="idTelemetria='".$idTelemetria."'"){ $resultado12 = db_update_data (false, $SIS_data_12, 'telemetria_listado_sensores_accion_alerta', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_13)&&$SIS_data_13!="idTelemetria='".$idTelemetria."'"){ $resultado13 = db_update_data (false, $SIS_data_13, 'telemetria_listado_sensores_revision', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_14)&&$SIS_data_14!="idTelemetria='".$idTelemetria."'"){ $resultado14 = db_update_data (false, $SIS_data_14, 'telemetria_listado_sensores_revision_grupo', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}
				if(isset($SIS_data_15)&&$SIS_data_15!="idTelemetria='".$idTelemetria."'"){ $resultado15 = db_update_data (false, $SIS_data_15, 'telemetria_listado_sensores_med_actual', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}

				//Si ejecuto correctamente la consulta
				if($resultado==true){
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
				$rowData = db_select_data (false, 'Direccion_img', 'telemetria_listado', '', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'telemetria_listado', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Configuraciones
				$resultado1  = db_delete_data (false, 'telemetria_listado_sensores_nombre', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado2  = db_delete_data (false, 'telemetria_listado_sensores_tipo', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado3  = db_delete_data (false, 'telemetria_listado_sensores_grupo', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado4  = db_delete_data (false, 'telemetria_listado_sensores_unimed', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado5  = db_delete_data (false, 'telemetria_listado_sensores_activo', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado6  = db_delete_data (false, 'telemetria_listado_sensores_uso', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado7  = db_delete_data (false, 'telemetria_listado_sensores_uso_fecha', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado8  = db_delete_data (false, 'telemetria_listado_sensores_accion_c', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado9  = db_delete_data (false, 'telemetria_listado_sensores_accion_t', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado10 = db_delete_data (false, 'telemetria_listado_sensores_accion_med_c', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado11 = db_delete_data (false, 'telemetria_listado_sensores_accion_med_t', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado12 = db_delete_data (false, 'telemetria_listado_sensores_accion_alerta', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado13 = db_delete_data (false, 'telemetria_listado_sensores_revision', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado14 = db_delete_data (false, 'telemetria_listado_sensores_revision_grupo', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado15 = db_delete_data (false, 'telemetria_listado_sensores_med_actual', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Relacionados
				$resultado16 = db_delete_data (false, 'telemetria_listado_alarmas_perso', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado17 = db_delete_data (false, 'telemetria_listado_alarmas_perso_historial', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado18 = db_delete_data (false, 'telemetria_listado_alarmas_perso_items', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado19 = db_delete_data (false, 'telemetria_listado_archivos', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado20 = db_delete_data (false, 'telemetria_listado_aux_equipo', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado21 = db_delete_data (false, 'telemetria_listado_contratos', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado22 = db_delete_data (false, 'telemetria_listado_crossenergy_dia', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado23 = db_delete_data (false, 'telemetria_listado_crossenergy_hora', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado24 = db_delete_data (false, 'telemetria_listado_definicion_operacional', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado25 = db_delete_data (false, 'telemetria_listado_error_detenciones', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado26 = db_delete_data (false, 'telemetria_listado_error_fuera_linea', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado27 = db_delete_data (false, 'telemetria_listado_error_geocerca', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado28 = db_delete_data (false, 'telemetria_listado_errores', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado29 = db_delete_data (false, 'telemetria_listado_errores_999', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado30 = db_delete_data (false, 'telemetria_listado_geocercas', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado31 = db_delete_data (false, 'telemetria_listado_historial_activaciones', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado32 = db_delete_data (false, 'telemetria_listado_historial_encendidos', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado33 = db_delete_data (false, 'telemetria_listado_historial_gps', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado34 = db_delete_data (false, 'telemetria_listado_historial_uso', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado35 = db_delete_data (false, 'telemetria_listado_observaciones', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado36 = db_delete_data (false, 'telemetria_listado_script', 'idTelemetria = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($resultado==true){

					// elimino la tabla si es que existe
					$query  = "DROP TABLE IF EXISTS `telemetria_listado_tablarelacionada_".$indice."`";
					$result = mysqli_query($dbConn, $query);

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
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
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
				$sufijo = 'tel_img_';

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
							if (!empty($_POST['idTelemetria']))    $idTelemetria       = $_POST['idTelemetria'];

							$SIS_data = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								header( 'Location: '.$location.'&id='.$idTelemetria );
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

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'Direccion_img', 'telemetria_listado', '', 'idTelemetria = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				header( 'Location: '.$location.'&id='.$_GET['del_img'] );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$idTelemetria  = $_GET['id'];
			$idEstado      = simpleDecode($_GET['estado'], fecha_actual());

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idEstado='".$idEstado."'";
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'clone_Equipo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//obtengo los datos de la maquina previamente seleccionada
			$rowData = db_select_data (false, 'idSistema', 'telemetria_listado', '', 'idTelemetria = '.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($rowData['idSistema'])){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_listado', '', "Nombre='".$Nombre."' AND idSistema='".$rowData['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//Se verifica si el dato existe
			if(isset($Identificador)&&isset($rowData['idSistema'])){
				$ndata_2 = db_select_nrows (false, 'Identificador', 'telemetria_listado', '', "Identificador='".$Identificador."' AND idSistema='".$rowData['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre del equipo ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El identificador del equipo ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//bucle
				$qry = '';
				//Recorro la configuracion de los sensores
				for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
					$qry .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
					$qry .= ',telemetria_listado_sensores_tipo.SensoresTipo_'.$i;
					$qry .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
					$qry .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
					$qry .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
					$qry .= ',telemetria_listado_sensores_uso.SensoresUso_'.$i;
					$qry .= ',telemetria_listado_sensores_uso_fecha.SensoresFechaUso_'.$i;
					$qry .= ',telemetria_listado_sensores_accion_c.SensoresAccionC_'.$i;
					$qry .= ',telemetria_listado_sensores_accion_t.SensoresAccionT_'.$i;
					$qry .= ',telemetria_listado_sensores_accion_alerta.SensoresAccionAlerta_'.$i;
					$qry .= ',telemetria_listado_sensores_revision.SensoresRevision_'.$i;
					$qry .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
				}

				/*******************************************************************/
				// Se traen todos los datos de la maquina
				$SIS_query = '
				telemetria_listado.idSistema,
				telemetria_listado.idCiudad,
				telemetria_listado.idComuna,
				telemetria_listado.Direccion,
				telemetria_listado.GeoLatitud,
				telemetria_listado.GeoLongitud,
				telemetria_listado.GeoVelocidad,
				telemetria_listado.GeoDireccion,
				telemetria_listado.GeoMovimiento,
				telemetria_listado.GeoTiempoDetencion,
				telemetria_listado.id_Geo,
				telemetria_listado.id_Sensores,
				telemetria_listado.cantSensores,
				telemetria_listado.idDispositivo,
				telemetria_listado.idShield,
				telemetria_listado.LimiteVelocidad,
				telemetria_listado.TiempoFueraLinea,
				telemetria_listado.TiempoDetencion,
				telemetria_listado.Direccion_img,
				telemetria_listado.idZona,
				telemetria_listado.SensorActivacionID,
				telemetria_listado.SensorActivacionValor,
				telemetria_listado.Jornada_inicio,
				telemetria_listado.Jornada_termino,
				telemetria_listado.Colacion_inicio,
				telemetria_listado.Colacion_termino,
				telemetria_listado.Microparada,
				telemetria_listado.Capacidad,
				telemetria_listado.idUsoPredio,
				telemetria_listado.idTipo,
				telemetria_listado.Marca,
				telemetria_listado.Modelo,
				telemetria_listado.Patente,
				telemetria_listado.Num_serie,
				telemetria_listado.AnoFab,
				telemetria_listado.CapacidadPersonas,
				telemetria_listado.CapacidadKilos,
				telemetria_listado.MCubicos,
				telemetria_listado.idTab,
				telemetria_listado.idGrupoDespliegue,
				telemetria_listado.idGrupoVmonofasico,
				telemetria_listado.idGrupoVTrifasico,
				telemetria_listado.idGrupoPotencia,
				telemetria_listado.idGrupoConsumoMesHabil,
				telemetria_listado.idGrupoConsumoMesCurso,
				telemetria_listado.idGrupoEstanque,
				telemetria_listado.CrossCrane_tiempo_revision,
				telemetria_listado.CrossCrane_grupo_amperaje,
				telemetria_listado.CrossCrane_grupo_elevacion,
				telemetria_listado.CrossCrane_grupo_giro,
				telemetria_listado.CrossCrane_grupo_carro,
				telemetria_listado.CrossCrane_grupo_voltaje,
				telemetria_listado.CrossCrane_grupo_motor_subida,
				telemetria_listado.CrossCrane_grupo_motor_bajada
				'.$qry;
				$SIS_join  = '
				LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria          = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_tipo`            ON telemetria_listado_sensores_tipo.idTelemetria            = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria           = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria          = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria          = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_uso`             ON telemetria_listado_sensores_uso.idTelemetria             = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_uso_fecha`       ON telemetria_listado_sensores_uso_fecha.idTelemetria       = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_accion_c`        ON telemetria_listado_sensores_accion_c.idTelemetria        = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_accion_t`        ON telemetria_listado_sensores_accion_t.idTelemetria        = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_accion_alerta`   ON telemetria_listado_sensores_accion_alerta.idTelemetria   = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_revision`        ON telemetria_listado_sensores_revision.idTelemetria        = telemetria_listado.idTelemetria
				LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria  = telemetria_listado.idTelemetria';
				$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria = '.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				//Datos ingresados
				if(isset($idEstado) && $idEstado!=''){          $SIS_data  = "'".$idEstado."'";         }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){              $SIS_data .= ",'".$Nombre."'";          }else{$SIS_data .= ",''";}

				//Datos copiados
				if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){                                          $SIS_data .= ",'".$rowData['idSistema']."'";                       }else{$SIS_data .= ",''";}
				if(isset($rowData['idCiudad']) && $rowData['idCiudad']!=''){                                            $SIS_data .= ",'".$rowData['idCiudad']."'";                        }else{$SIS_data .= ",''";}
				if(isset($rowData['idComuna']) && $rowData['idComuna']!=''){                                            $SIS_data .= ",'".$rowData['idComuna']."'";                        }else{$SIS_data .= ",''";}
				if(isset($rowData['Direccion']) && $rowData['Direccion']!=''){                                          $SIS_data .= ",'".$rowData['Direccion']."'";                       }else{$SIS_data .= ",''";}
				if(isset($rowData['GeoLatitud']) && $rowData['GeoLatitud']!=''){                                        $SIS_data .= ",'".$rowData['GeoLatitud']."'";                      }else{$SIS_data .= ",''";}
				if(isset($rowData['GeoLongitud']) && $rowData['GeoLongitud']!=''){                                      $SIS_data .= ",'".$rowData['GeoLongitud']."'";                     }else{$SIS_data .= ",''";}
				if(isset($rowData['GeoVelocidad']) && $rowData['GeoVelocidad']!=''){                                    $SIS_data .= ",'".$rowData['GeoVelocidad']."'";                    }else{$SIS_data .= ",''";}
				if(isset($rowData['GeoDireccion']) && $rowData['GeoDireccion']!=''){                                    $SIS_data .= ",'".$rowData['GeoDireccion']."'";                    }else{$SIS_data .= ",''";}
				if(isset($rowData['GeoMovimiento']) && $rowData['GeoMovimiento']!=''){                                  $SIS_data .= ",'".$rowData['GeoMovimiento']."'";                   }else{$SIS_data .= ",''";}
				if(isset($rowData['GeoTiempoDetencion']) && $rowData['GeoTiempoDetencion']!=''){                        $SIS_data .= ",'".$rowData['GeoTiempoDetencion']."'";              }else{$SIS_data .= ",''";}
				if(isset($rowData['id_Geo']) && $rowData['id_Geo']!=''){                                                $SIS_data .= ",'".$rowData['id_Geo']."'";                          }else{$SIS_data .= ",''";}
				if(isset($rowData['id_Sensores']) && $rowData['id_Sensores']!=''){                                      $SIS_data .= ",'".$rowData['id_Sensores']."'";                     }else{$SIS_data .= ",''";}
				if(isset($rowData['cantSensores']) && $rowData['cantSensores']!=''){                                    $SIS_data .= ",'".$rowData['cantSensores']."'";                    }else{$SIS_data .= ",''";}
				if(isset($rowData['idDispositivo']) && $rowData['idDispositivo']!=''){                                  $SIS_data .= ",'".$rowData['idDispositivo']."'";                   }else{$SIS_data .= ",''";}
				if(isset($rowData['idShield']) && $rowData['idShield']!=''){                                            $SIS_data .= ",'".$rowData['idShield']."'";                        }else{$SIS_data .= ",''";}
				if(isset($rowData['LimiteVelocidad']) && $rowData['LimiteVelocidad']!=''){                              $SIS_data .= ",'".$rowData['LimiteVelocidad']."'";                 }else{$SIS_data .= ",''";}
				if(isset($rowData['TiempoFueraLinea']) && $rowData['TiempoFueraLinea']!=''){                            $SIS_data .= ",'".$rowData['TiempoFueraLinea']."'";                }else{$SIS_data .= ",''";}
				if(isset($rowData['TiempoDetencion']) && $rowData['TiempoDetencion']!=''){                              $SIS_data .= ",'".$rowData['TiempoDetencion']."'";                 }else{$SIS_data .= ",''";}
				if(isset($rowData['Direccion_img']) && $rowData['Direccion_img']!=''){                                  $SIS_data .= ",'".$rowData['Direccion_img']."'";                   }else{$SIS_data .= ",''";}
				if(isset($rowData['idZona']) && $rowData['idZona']!=''){                                                $SIS_data .= ",'".$rowData['idZona']."'";                          }else{$SIS_data .= ",''";}
				if(isset($rowData['SensorActivacionID']) && $rowData['SensorActivacionID']!=''){                        $SIS_data .= ",'".$rowData['SensorActivacionID']."'";              }else{$SIS_data .= ",''";}
				if(isset($rowData['SensorActivacionValor']) && $rowData['SensorActivacionValor']!=''){                  $SIS_data .= ",'".$rowData['SensorActivacionValor']."'";           }else{$SIS_data .= ",''";}
				if(isset($rowData['Jornada_inicio']) && $rowData['Jornada_inicio']!=''){                                $SIS_data .= ",'".$rowData['Jornada_inicio']."'";                  }else{$SIS_data .= ",''";}
				if(isset($rowData['Jornada_termino']) && $rowData['Jornada_termino']!=''){                              $SIS_data .= ",'".$rowData['Jornada_termino']."'";                 }else{$SIS_data .= ",''";}
				if(isset($rowData['Colacion_inicio']) && $rowData['Colacion_inicio']!=''){                              $SIS_data .= ",'".$rowData['Colacion_inicio']."'";                 }else{$SIS_data .= ",''";}
				if(isset($rowData['Colacion_termino']) && $rowData['Colacion_termino']!=''){                            $SIS_data .= ",'".$rowData['Colacion_termino']."'";                }else{$SIS_data .= ",''";}
				if(isset($rowData['Microparada']) && $rowData['Microparada']!=''){                                      $SIS_data .= ",'".$rowData['Microparada']."'";                     }else{$SIS_data .= ",''";}
				if(isset($rowData['Capacidad']) && $rowData['Capacidad']!=''){                                          $SIS_data .= ",'".$rowData['Capacidad']."'";                       }else{$SIS_data .= ",''";}
				if(isset($rowData['idUsoPredio']) && $rowData['idUsoPredio']!=''){                                      $SIS_data .= ",'".$rowData['idUsoPredio']."'";                     }else{$SIS_data .= ",''";}
				if(isset($rowData['idTipo']) && $rowData['idTipo']!=''){                                                $SIS_data .= ",'".$rowData['idTipo']."'";                          }else{$SIS_data .= ",''";}
				if(isset($rowData['Marca']) && $rowData['Marca']!=''){                                                  $SIS_data .= ",'".$rowData['Marca']."'";                           }else{$SIS_data .= ",''";}
				if(isset($rowData['Modelo']) && $rowData['Modelo']!=''){                                                $SIS_data .= ",'".$rowData['Modelo']."'";                          }else{$SIS_data .= ",''";}
				if(isset($rowData['Patente']) && $rowData['Patente']!=''){                                              $SIS_data .= ",'".$rowData['Patente']."'";                         }else{$SIS_data .= ",''";}
				if(isset($rowData['Num_serie']) && $rowData['Num_serie']!=''){                                          $SIS_data .= ",'".$rowData['Num_serie']."'";                       }else{$SIS_data .= ",''";}
				if(isset($rowData['AnoFab']) && $rowData['AnoFab']!=''){                                                $SIS_data .= ",'".$rowData['AnoFab']."'";                          }else{$SIS_data .= ",''";}
				if(isset($rowData['CapacidadPersonas']) && $rowData['CapacidadPersonas']!=''){                          $SIS_data .= ",'".$rowData['CapacidadPersonas']."'";               }else{$SIS_data .= ",''";}
				if(isset($rowData['CapacidadKilos']) && $rowData['CapacidadKilos']!=''){                                $SIS_data .= ",'".$rowData['CapacidadKilos']."'";                  }else{$SIS_data .= ",''";}
				if(isset($rowData['MCubicos']) && $rowData['MCubicos']!=''){                                            $SIS_data .= ",'".$rowData['MCubicos']."'";                        }else{$SIS_data .= ",''";}
				if(isset($rowData['idTab']) && $rowData['idTab']!=''){                                                  $SIS_data .= ",'".$rowData['idTab']."'";                           }else{$SIS_data .= ",''";}
				if(isset($rowData['idGrupoDespliegue']) && $rowData['idGrupoDespliegue']!=''){                          $SIS_data .= ",'".$rowData['idGrupoDespliegue']."'";               }else{$SIS_data .= ",''";}
				if(isset($rowData['idGrupoVmonofasico']) && $rowData['idGrupoVmonofasico']!=''){                        $SIS_data .= ",'".$rowData['idGrupoVmonofasico']."'";              }else{$SIS_data .= ",''";}
				if(isset($rowData['idGrupoVTrifasico']) && $rowData['idGrupoVTrifasico']!=''){                          $SIS_data .= ",'".$rowData['idGrupoVTrifasico']."'";               }else{$SIS_data .= ",''";}
				if(isset($rowData['idGrupoPotencia']) && $rowData['idGrupoPotencia']!=''){                              $SIS_data .= ",'".$rowData['idGrupoPotencia']."'";                 }else{$SIS_data .= ",''";}
				if(isset($rowData['idGrupoConsumoMesHabil']) && $rowData['idGrupoConsumoMesHabil']!=''){                $SIS_data .= ",'".$rowData['idGrupoConsumoMesHabil']."'";          }else{$SIS_data .= ",''";}
				if(isset($rowData['idGrupoConsumoMesCurso']) && $rowData['idGrupoConsumoMesCurso']!=''){                $SIS_data .= ",'".$rowData['idGrupoConsumoMesCurso']."'";          }else{$SIS_data .= ",''";}
				if(isset($rowData['idGrupoEstanque']) && $rowData['idGrupoEstanque']!=''){                              $SIS_data .= ",'".$rowData['idGrupoEstanque']."'";                 }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_tiempo_revision']) && $rowData['CrossCrane_tiempo_revision']!=''){        $SIS_data .= ",'".$rowData['CrossCrane_tiempo_revision']."'";      }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_grupo_amperaje']) && $rowData['CrossCrane_grupo_amperaje']!=''){          $SIS_data .= ",'".$rowData['CrossCrane_grupo_amperaje']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_grupo_elevacion']) && $rowData['CrossCrane_grupo_elevacion']!=''){        $SIS_data .= ",'".$rowData['CrossCrane_grupo_elevacion']."'";      }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_grupo_giro']) && $rowData['CrossCrane_grupo_giro']!=''){                  $SIS_data .= ",'".$rowData['CrossCrane_grupo_giro']."'";           }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_grupo_carro']) && $rowData['CrossCrane_grupo_carro']!=''){                $SIS_data .= ",'".$rowData['CrossCrane_grupo_carro']."'";          }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_grupo_voltaje']) && $rowData['CrossCrane_grupo_voltaje']!=''){            $SIS_data .= ",'".$rowData['CrossCrane_grupo_voltaje']."'";        }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_grupo_motor_subida']) && $rowData['CrossCrane_grupo_motor_subida']!=''){  $SIS_data .= ",'".$rowData['CrossCrane_grupo_motor_subida']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['CrossCrane_grupo_motor_bajada']) && $rowData['CrossCrane_grupo_motor_bajada']!=''){  $SIS_data .= ",'".$rowData['CrossCrane_grupo_motor_bajada']."'";   }else{$SIS_data .= ",''";}

				//datos en bruto
				$SIS_data .= ",'0'";        //GeoErrores
				$SIS_data .= ",'0'";        //LastUpdateFecha
				$SIS_data .= ",'0'";        //LastUpdateHora
				$SIS_data .= ",''";         //Sim_Num_Tel
				$SIS_data .= ",''";         //Sim_Num_Serie
				$SIS_data .= ",''";         //Sim_marca
				$SIS_data .= ",''";         //Sim_modelo
				$SIS_data .= ",''";         //Sim_Compania
				$SIS_data .= ",''";         //IdentificadorEmpresa
				$SIS_data .= ",'0'";        //NErrores
				$SIS_data .= ",'0'";        //NAlertas
				$SIS_data .= ",'2'";        //idUsoFTP
				$SIS_data .= ",''";         //FTP_Carpeta
				$SIS_data .= ",'1'";        //idBackup SI
				$SIS_data .= ",'200000'";   //NregBackup 200000
				$SIS_data .= ",'2'";        //idUbicacion
				$SIS_data .= ",''";         //Estado
				$SIS_data .= ",'2'";        //idAlertaTemprana
				$SIS_data .= ",'00:15:00'"; //AlertaTemprCritica
				$SIS_data .= ",'01:00:00'"; //AlertaTemprNormal
				$SIS_data .= ",'2'";        //idGenerador
				$SIS_data .= ",'0'";        //NDetenciones
				$SIS_data .= ",'1'";        //idEstadoEncendido

				// inserto los datos de registro en la db
				$SIS_columns = 'idEstado,Nombre,idSistema,
				idCiudad,idComuna,Direccion,GeoLatitud,GeoLongitud,GeoVelocidad,GeoDireccion,GeoMovimiento,
				GeoTiempoDetencion,id_Geo,id_Sensores,cantSensores,idDispositivo,idShield,
				LimiteVelocidad,TiempoFueraLinea,TiempoDetencion,Direccion_img,idZona,SensorActivacionID,
				SensorActivacionValor,Jornada_inicio,Jornada_termino,Colacion_inicio,Colacion_termino,
				Microparada,Capacidad,idUsoPredio,idTipo,Marca,Modelo,Patente,Num_serie,AnoFab,CapacidadPersonas,
				CapacidadKilos,MCubicos,idTab,idGrupoDespliegue,idGrupoVmonofasico,idGrupoVTrifasico,idGrupoPotencia,idGrupoConsumoMesHabil,
				idGrupoConsumoMesCurso,idGrupoEstanque,CrossCrane_tiempo_revision,CrossCrane_grupo_amperaje,CrossCrane_grupo_elevacion,
				CrossCrane_grupo_giro,CrossCrane_grupo_carro,CrossCrane_grupo_voltaje,CrossCrane_grupo_motor_subida,
				CrossCrane_grupo_motor_bajada,GeoErrores,LastUpdateFecha,LastUpdateHora,Sim_Num_Tel,
				Sim_Num_Serie,Sim_marca,Sim_modelo,Sim_Compania,IdentificadorEmpresa,NErrores,NAlertas,
				idUsoFTP,FTP_Carpeta,idBackup,NregBackup,idUbicacion,Estado,idAlertaTemprana,AlertaTemprCritica,
				AlertaTemprNormal, idGenerador, NDetenciones,idEstadoEncendido';
				$telemetria_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($telemetria_id!=0){

					/********************************************************************************/
					//Variables
					$SIS_data01  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data02  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data03  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data04  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data05  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data06  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data07  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data08  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data09  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data10  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data11  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data12  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data13  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data14  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_data15  = "'".$telemetria_id."'"; //idTelemetria
					$SIS_columns01 = 'idTelemetria';   //Columna
					$SIS_columns02 = 'idTelemetria';   //Columna
					$SIS_columns03 = 'idTelemetria';   //Columna
					$SIS_columns04 = 'idTelemetria';   //Columna
					$SIS_columns05 = 'idTelemetria';   //Columna
					$SIS_columns06 = 'idTelemetria';   //Columna
					$SIS_columns07 = 'idTelemetria';   //Columna
					$SIS_columns08 = 'idTelemetria';   //Columna
					$SIS_columns09 = 'idTelemetria';   //Columna
					$SIS_columns10 = 'idTelemetria';   //Columna
					$SIS_columns11 = 'idTelemetria';   //Columna
					$SIS_columns12 = 'idTelemetria';   //Columna
					$SIS_columns13 = 'idTelemetria';   //Columna
					$SIS_columns14 = 'idTelemetria';   //Columna
					$SIS_columns15 = 'idTelemetria';   //Columna

					//Recorro la configuracion de los sensores
					for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
						if(isset($rowData['SensoresNombre_'.$i]) && $rowData['SensoresNombre_'.$i]!=''){                $SIS_data01 .= ",'".$rowData['SensoresNombre_'.$i]."'";         $SIS_columns01 .= ',SensoresNombre_'.$i;}
						if(isset($rowData['SensoresTipo_'.$i]) && $rowData['SensoresTipo_'.$i]!=''){                    $SIS_data02 .= ",'".$rowData['SensoresTipo_'.$i]."'";           $SIS_columns02 .= ',SensoresTipo_'.$i;}
						if(isset($rowData['SensoresGrupo_'.$i]) && $rowData['SensoresGrupo_'.$i]!=''){                  $SIS_data03 .= ",'".$rowData['SensoresGrupo_'.$i]."'";          $SIS_columns03 .= ',SensoresGrupo_'.$i;}
						if(isset($rowData['SensoresUniMed_'.$i]) && $rowData['SensoresUniMed_'.$i]!=''){                $SIS_data04 .= ",'".$rowData['SensoresUniMed_'.$i]."'";         $SIS_columns04 .= ',SensoresUniMed_'.$i;}
						if(isset($rowData['SensoresActivo_'.$i]) && $rowData['SensoresActivo_'.$i]!=''){                $SIS_data05 .= ",'".$rowData['SensoresActivo_'.$i]."'";         $SIS_columns05 .= ',SensoresActivo_'.$i;}
						if(isset($rowData['SensoresUso_'.$i]) && $rowData['SensoresUso_'.$i]!=''){                      $SIS_data06 .= ",'".$rowData['SensoresUso_'.$i]."'";            $SIS_columns06 .= ',SensoresUso_'.$i;}
						if(isset($rowData['SensoresFechaUso_'.$i]) && $rowData['SensoresFechaUso_'.$i]!=''){            $SIS_data07 .= ",'".$rowData['SensoresFechaUso_'.$i]."'";       $SIS_columns07 .= ',SensoresFechaUso_'.$i;}
						if(isset($rowData['SensoresAccionC_'.$i]) && $rowData['SensoresAccionC_'.$i]!=''){              $SIS_data08 .= ",'".$rowData['SensoresAccionC_'.$i]."'";        $SIS_columns08 .= ',SensoresAccionC_'.$i;}
						if(isset($rowData['SensoresAccionT_'.$i]) && $rowData['SensoresAccionT_'.$i]!=''){              $SIS_data09 .= ",'".$rowData['SensoresAccionT_'.$i]."'";        $SIS_columns09 .= ',SensoresAccionT_'.$i;}
						if(isset($rowData['SensoresAccionAlerta_'.$i]) && $rowData['SensoresAccionAlerta_'.$i]!=''){    $SIS_data10 .= ",'".$rowData['SensoresAccionAlerta_'.$i]."'";   $SIS_columns10 .= ',SensoresAccionAlerta_'.$i;}
						if(isset($rowData['SensoresRevision_'.$i]) && $rowData['SensoresRevision_'.$i]!=''){            $SIS_data11 .= ",'".$rowData['SensoresRevision_'.$i]."'";       $SIS_columns11 .= ',SensoresRevision_'.$i;}
						if(isset($rowData['SensoresRevisionGrupo_'.$i]) && $rowData['SensoresRevisionGrupo_'.$i]!=''){  $SIS_data12 .= ",'".$rowData['SensoresRevisionGrupo_'.$i]."'";  $SIS_columns12 .= ',SensoresRevisionGrupo_'.$i;}
					}

					//Creo registro dentro de cada tabla relacionada a los sensores
					$ultimo_id_9  = db_insert_data (false, $SIS_columns01, $SIS_data01, 'telemetria_listado_sensores_nombre', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_12 = db_insert_data (false, $SIS_columns02, $SIS_data02, 'telemetria_listado_sensores_tipo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_7  = db_insert_data (false, $SIS_columns03, $SIS_data03, 'telemetria_listado_sensores_grupo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_13 = db_insert_data (false, $SIS_columns04, $SIS_data04, 'telemetria_listado_sensores_unimed', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_6  = db_insert_data (false, $SIS_columns05, $SIS_data05, 'telemetria_listado_sensores_activo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_14 = db_insert_data (false, $SIS_columns06, $SIS_data06, 'telemetria_listado_sensores_uso', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_15 = db_insert_data (false, $SIS_columns07, $SIS_data07, 'telemetria_listado_sensores_uso_fecha', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_2  = db_insert_data (false, $SIS_columns08, $SIS_data08, 'telemetria_listado_sensores_accion_c', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_5  = db_insert_data (false, $SIS_columns09, $SIS_data09, 'telemetria_listado_sensores_accion_t', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_1  = db_insert_data (false, $SIS_columns10, $SIS_data10, 'telemetria_listado_sensores_accion_alerta', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_10 = db_insert_data (false, $SIS_columns11, $SIS_data11, 'telemetria_listado_sensores_revision', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_11 = db_insert_data (false, $SIS_columns12, $SIS_data12, 'telemetria_listado_sensores_revision_grupo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_3  = db_insert_data (false, $SIS_columns13, $SIS_data13, 'telemetria_listado_sensores_accion_med_c', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_4  = db_insert_data (false, $SIS_columns14, $SIS_data14, 'telemetria_listado_sensores_accion_med_t', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ultimo_id_8  = db_insert_data (false, $SIS_columns15, $SIS_data15, 'telemetria_listado_sensores_med_actual', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/********************************************************************************/
					// elimino la tabla si es que existe
					$query  = "DROP TABLE IF EXISTS `telemetria_listado_tablarelacionada_".$telemetria_id."`";
					$result = mysqli_query($dbConn, $query);

					$tr_column = '';
					//Recorro la configuracion de los sensores
					for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
						$tr_column .= '`Sensor_'.$i.'` decimal(20,6) NOT NULL,';
					}
					// se crea la nueva tabla
					$query  = "CREATE TABLE `telemetria_listado_tablarelacionada_".$telemetria_id."` (
					`idTabla` int(11) unsigned NOT NULL AUTO_INCREMENT,
					`idTelemetria` int(11) unsigned NOT NULL,
					`idSolicitud` int(11) unsigned NOT NULL,
					`idZona` int(11) unsigned NOT NULL,
					`FechaSistema` date NOT NULL,
					`HoraSistema` time NOT NULL,
					`TimeStamp` datetime NOT NULL,
					`GeoLatitud` double NOT NULL,
					`GeoLongitud` double NOT NULL,
					`GeoVelocidad` decimal(20,6) NOT NULL,
					`GeoDireccion` decimal(20,6) NOT NULL,
					`GeoMovimiento` decimal(20,6) NOT NULL,
					`Segundos` int(11) unsigned NOT NULL,
					`Diferencia` decimal(20,6) NOT NULL,
					".$tr_column."
					  PRIMARY KEY (`idTabla`,`FechaSistema`,`HoraSistema`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Dinamica';";
					$result = mysqli_query($dbConn, $query);

					/*******************************************************/
					//se actualizan los datos
					$SIS_data = "Identificador='".$telemetria_id."'";
					$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$telemetria_id.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($resultado==true){

						/*******************************************************/
						//Consulto las alertas personalizadas
						/*$arrLVL_1 = array();
						$arrLVL_1 = db_select_array (false, 'idAlarma, Nombre,idTipo, idTipoAlerta, idUniMed, valor_error, valor_diferencia, Rango_ini, Rango_fin, NErroresMax', 'telemetria_listado_alarmas_perso', '', 'idTelemetria = '.$idTelemetria, 'idAlarma ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$arrLVL_2 = array();
						$arrLVL_2 = db_select_array (false, 'idAlarma, Sensor_N, Rango_ini, Rango_fin, valor_especifico', 'telemetria_listado_alarmas_perso_items', '', 'idTelemetria = '.$idTelemetria, 'idAlarma ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						foreach ($arrLVL_1 as $lvl_1) {

							//Se crea la maquina
							$SIS_data  = "'".$telemetria_id."'";
							$SIS_data .= ",'".$lvl_1['Nombre']."'";
							$SIS_data .= ",'".$lvl_1['idTipo']."'";
							$SIS_data .= ",'".$lvl_1['idTipoAlerta']."'";
							$SIS_data .= ",'".$lvl_1['idUniMed']."'";
							$SIS_data .= ",'".$lvl_1['valor_error']."'";
							$SIS_data .= ",'".$lvl_1['valor_diferencia']."'";
							$SIS_data .= ",'".$lvl_1['Rango_ini']."'";
							$SIS_data .= ",'".$lvl_1['Rango_fin']."'";
							$SIS_data .= ",'".$lvl_1['NErroresMax']."'";
							$SIS_data .= ",'0'";

							// inserto los datos de registro en la db
							$SIS_columns = 'idTelemetria,Nombre,idTipo,idTipoAlerta,idUniMed,valor_error,valor_diferencia,Rango_ini,Rango_fin,
							NErroresMax,NErroresActual';
							$id_lvl_1 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_alarmas_perso', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Si ejecuto correctamente la consulta
							if($id_lvl_1!=0){
								//Nivel 2
								foreach ($arrLVL_2 as $lvl_2) {
									//Se verifica que sea el mismo sensor
									if($lvl_1['idAlarma']==$lvl_2['idAlarma']){

										//Se crea la maquina
										$SIS_data  = "'".$telemetria_id."'";
										$SIS_data .= ",'".$id_lvl_1."'";
										$SIS_data .= ",'".$lvl_2['Sensor_N']."'";
										$SIS_data .= ",'".$lvl_2['Rango_ini']."'";
										$SIS_data .= ",'".$lvl_2['Rango_fin']."'";
										$SIS_data .= ",'".$lvl_2['valor_especifico']."'";

										// inserto los datos de registro en la db
										$SIS_columns = 'idTelemetria,idAlarma,Sensor_N,Rango_ini,Rango_fin,valor_especifico';
										$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_alarmas_perso_items', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									}
								}
							}
						}

						/*******************************************************/
						//Consulto las definiciones operacionales
						/*$SIS_query = 'N_Sensor, ValorActivo, RangoMinimo, RangoMaximo, idFuncion';
						$SIS_join  = '';
						$SIS_where = 'idTelemetria ='.$idTelemetria;
						$SIS_order = 'idDefinicion ASC';
						$arrOperaciones = array();
						$arrOperaciones = db_select_array (false, $SIS_query, 'telemetria_listado_definicion_operacional', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOperaciones');

						//recorro las definiciones
						foreach ($arrOperaciones as $oper) {
							//filtros
							if(isset($telemetria_id) && $telemetria_id!=''){             $SIS_data  = "'".$telemetria_id."'";          }else{$SIS_data  = "''";}
							if(isset($oper['N_Sensor']) && $oper['N_Sensor']!=''){       $SIS_data .= ",'".$oper['N_Sensor']."'";      }else{$SIS_data .= ",''";}
							if(isset($oper['ValorActivo']) && $oper['ValorActivo']!=''){ $SIS_data .= ",'".$oper['ValorActivo']."'";   }else{$SIS_data .= ",''";}
							if(isset($oper['RangoMinimo']) && $oper['RangoMinimo']!=''){ $SIS_data .= ",'".$oper['RangoMinimo']."'";   }else{$SIS_data .= ",''";}
							if(isset($oper['RangoMaximo']) && $oper['RangoMaximo']!=''){ $SIS_data .= ",'".$oper['RangoMaximo']."'";   }else{$SIS_data .= ",''";}
							if(isset($oper['idFuncion']) && $oper['idFuncion']!=''){     $SIS_data .= ",'".$oper['idFuncion']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idTelemetria, N_Sensor, ValorActivo, RangoMinimo, RangoMaximo, idFuncion';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_definicion_operacional', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}

						/*******************************************************/
						//Redirijo
						header( 'Location: '.$location.'&id='.$telemetria_id.'&created=true' );
						die;

					}
				}
			}

		break;

/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'EstadoEncendido':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$idTelemetria       = $_GET['idTelemetria'];
			$idEstadoEncendido  = $_GET['idEstadoEncendido'];
			$idUsuario          = $_SESSION['usuario']['basic_data']['idUsuario'];
			$Fecha              = fecha_actual();
			$Hora               = hora_actual();
			$TimeStamp          = fecha_actual().' '.hora_actual();

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica el tipo de usuario
			if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
				//Se verifica si el dato existe
				if(isset($idTelemetria)&&$idTelemetria!=''){
					$ndata_1 = db_select_nrows (false, 'idTelemetria', 'usuarios_equipos_telemetria', '', "idTelemetria='".$idTelemetria."' AND idUsuario='".$idUsuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				//generacion de errores
				if($ndata_1==0) {$error['ndata_1'] = 'error/No tiene permiso para la edicion de este equipo de telemetria';}
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idEstadoEncendido='".$idEstadoEncendido."'";
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//filtros
					if(isset($idTelemetria) && $idTelemetria!=''){            $SIS_data  = "'".$idTelemetria."'";         }else{$SIS_data  = "''";}
					if(isset($Fecha) && $Fecha!=''){                          $SIS_data .= ",'".$Fecha."'";               }else{$SIS_data .= ",''";}
					if(isset($Hora) && $Hora!=''){                            $SIS_data .= ",'".$Hora."'";                }else{$SIS_data .= ",''";}
					if(isset($TimeStamp) && $TimeStamp!=''){                  $SIS_data .= ",'".$TimeStamp."'";           }else{$SIS_data .= ",''";}
					if(isset($idEstadoEncendido) && $idEstadoEncendido!=''){  $SIS_data .= ",'".$idEstadoEncendido."'";   }else{$SIS_data .= ",''";}
					if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idTelemetria, Fecha, Hora, TimeStamp, idEstadoEncendido, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_historial_encendidos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						/*
						try {
							if(!is_writable('upload/equipo_tel_'.$idTelemetria.'.json')){
								//Contenido del archivo
								$content = '{"sensor": "'.$idEstadoEncendido.'"}';
								//creación del archivo
								file_put_contents('upload/equipo_tel_'.$idTelemetria.'.json', $content, FILE_APPEND | LOCK_EX);
							}else{
								//Elimino el archivo
								unlink('upload/equipo_tel_'.$idTelemetria.'.json');
								//Contenido del archivo
								$content = '{"sensor": "'.$idEstadoEncendido.'"}';
								//creación del archivo
								file_put_contents('upload/equipo_tel_'.$idTelemetria.'.json', $content, FILE_APPEND | LOCK_EX);	
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
						//Redirijo
						header( 'Location: '.$location.'&edited=true' );
						die;
						*/
					}
				}
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
			if(isset($idTelemetria)&&isset($idZona)){
				$ndata_1 = db_select_nrows (false, 'idTelemetria', 'telemetria_listado_geocercas', '', "idTelemetria='".$idTelemetria."' AND idZona='".$idZona."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Geocerca ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data  = "'".$idTelemetria."'"; }else{$SIS_data  = "''";}
				if(isset($idZona) && $idZona!=''){              $SIS_data .= ",'".$idZona."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria, idZona';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_geocercas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$resultado = db_delete_data (false, 'telemetria_listado_geocercas', 'idGeocerca = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'update_Sensor_Act':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$idTelemetria = $_GET['id'];
				$SIS_data  = "SensorActivacionID=''";
				$SIS_data .= ",SensorActivacionValor=''";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
