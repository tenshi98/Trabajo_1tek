<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-056).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idSistema']))                         $idSistema                         = $_POST['idSistema'];
	if (!empty($_POST['Nombre']))                            $Nombre                            = $_POST['Nombre'];
	if ( isset($_POST['email_principal']))                   $email_principal                   = $_POST['email_principal'];
	if (!empty($_POST['Rut']))                               $Rut                               = $_POST['Rut'];
	if ( isset($_POST['idCiudad']))                          $idCiudad                          = $_POST['idCiudad'];
	if ( isset($_POST['idComuna']))                          $idComuna                          = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))                         $Direccion                         = $_POST['Direccion'];
	if ( isset($_POST['CajaChica']))                         $CajaChica                         = $_POST['CajaChica'];
	if ( isset($_POST['Contacto_Nombre']))                   $Contacto_Nombre                   = $_POST['Contacto_Nombre'];
	if ( isset($_POST['Contacto_Fono1']))                    $Contacto_Fono1                    = $_POST['Contacto_Fono1'];
	if ( isset($_POST['Contacto_Fono2']))                    $Contacto_Fono2                    = $_POST['Contacto_Fono2'];
	if ( isset($_POST['Contacto_Fax']))                      $Contacto_Fax                      = $_POST['Contacto_Fax'];
	if ( isset($_POST['Contacto_Email']))                    $Contacto_Email                    = $_POST['Contacto_Email'];
	if ( isset($_POST['Contacto_Web']))                      $Contacto_Web                      = $_POST['Contacto_Web'];
	if ( isset($_POST['Contrato_Nombre']))                   $Contrato_Nombre                   = $_POST['Contrato_Nombre'];
	if (!empty($_POST['Contrato_Numero']))                   $Contrato_Numero                   = $_POST['Contrato_Numero'];
	if (!empty($_POST['Contrato_Fecha']))                    $Contrato_Fecha                    = $_POST['Contrato_Fecha'];
	if (!empty($_POST['Contrato_Duracion']))                 $Contrato_Duracion                 = $_POST['Contrato_Duracion'];
	if ( isset($_POST['Config_IDGoogle']))                   $Config_IDGoogle                   = $_POST['Config_IDGoogle'];
	if ( isset($_POST['Config_Google_apiKey']))              $Config_Google_apiKey              = $_POST['Config_Google_apiKey'];
	if ( isset($_POST['Config_FCM_apiKey']))                 $Config_FCM_apiKey                 = $_POST['Config_FCM_apiKey'];
	if ( isset($_POST['Config_FCM_Main_apiKey']))            $Config_FCM_Main_apiKey            = $_POST['Config_FCM_Main_apiKey'];
	if (!empty($_POST['Config_imgLogo']))                    $Config_imgLogo                    = $_POST['Config_imgLogo'];
	if (!empty($_POST['Config_idTheme']))                    $Config_idTheme                    = $_POST['Config_idTheme'];
	if ( isset($_POST['Config_CorreoRespaldo']))             $Config_CorreoRespaldo             = $_POST['Config_CorreoRespaldo'];
	if ( isset($_POST['Config_Gmail_Usuario']))              $Config_Gmail_Usuario              = $_POST['Config_Gmail_Usuario'];
	if ( isset($_POST['Config_Gmail_Password']))             $Config_Gmail_Password             = $_POST['Config_Gmail_Password'];
	if ( isset($_POST['Config_WhatsappToken']))              $Config_WhatsappToken              = $_POST['Config_WhatsappToken'];
	if ( isset($_POST['Config_WhatsappInstanceId']))         $Config_WhatsappInstanceId         = $_POST['Config_WhatsappInstanceId'];
	if (!empty($_POST['idOpcionesGen_1']))                   $idOpcionesGen_1                   = $_POST['idOpcionesGen_1'];
	if (!empty($_POST['idOpcionesGen_2']))                   $idOpcionesGen_2                   = $_POST['idOpcionesGen_2'];
	if (!empty($_POST['idOpcionesGen_3']))                   $idOpcionesGen_3                   = $_POST['idOpcionesGen_3'];
	if (!empty($_POST['idOpcionesGen_4']))                   $idOpcionesGen_4                   = $_POST['idOpcionesGen_4'];
	if (!empty($_POST['idOpcionesGen_5']))                   $idOpcionesGen_5                   = $_POST['idOpcionesGen_5'];
	if ( isset($_POST['idOpcionesGen_6']))                   $idOpcionesGen_6                   = $_POST['idOpcionesGen_6'];
	if (!empty($_POST['idOpcionesGen_7']))                   $idOpcionesGen_7                   = $_POST['idOpcionesGen_7'];
	if (!empty($_POST['idOpcionesGen_8']))                   $idOpcionesGen_8                   = $_POST['idOpcionesGen_8'];
	if (!empty($_POST['idOpcionesGen_9']))                   $idOpcionesGen_9                   = $_POST['idOpcionesGen_9'];
	if (!empty($_POST['idOpcionesGen_10']))                  $idOpcionesGen_10                  = $_POST['idOpcionesGen_10'];
	if (!empty($_POST['idOpcionesGen_11']))                  $idOpcionesGen_11                  = $_POST['idOpcionesGen_11'];
	if (!empty($_POST['idOpcionesGen_12']))                  $idOpcionesGen_12                  = $_POST['idOpcionesGen_12'];
	if (!empty($_POST['idOpcionesGen_13']))                  $idOpcionesGen_13                  = $_POST['idOpcionesGen_13'];
	if (!empty($_POST['idOpcionesGen_14']))                  $idOpcionesGen_14                  = $_POST['idOpcionesGen_14'];
	if (!empty($_POST['idOpcionesGen_15']))                  $idOpcionesGen_15                  = $_POST['idOpcionesGen_15'];
	if (!empty($_POST['idOpcionesGen_16']))                  $idOpcionesGen_16                  = $_POST['idOpcionesGen_16'];
	if (!empty($_POST['idOpcionesGen_17']))                  $idOpcionesGen_17                  = $_POST['idOpcionesGen_17'];
	if (!empty($_POST['idOpcionesGen_18']))                  $idOpcionesGen_18                  = $_POST['idOpcionesGen_18'];
	if (!empty($_POST['idOpcionesGen_19']))                  $idOpcionesGen_19                  = $_POST['idOpcionesGen_19'];
	if (!empty($_POST['idOpcionesGen_20']))                  $idOpcionesGen_20                  = $_POST['idOpcionesGen_20'];
	if (!empty($_POST['OT_idBodegaProd']))                   $OT_idBodegaProd                   = $_POST['OT_idBodegaProd'];
	if (!empty($_POST['OT_idBodegaIns']))                    $OT_idBodegaIns                    = $_POST['OT_idBodegaIns'];
	if (!empty($_POST['Rubro']))                             $Rubro                             = $_POST['Rubro'];
	if (!empty($_POST['idOpcionesTel']))                     $idOpcionesTel                     = $_POST['idOpcionesTel'];
	if (!empty($_POST['idConfigRam']))                       $idConfigRam                       = $_POST['idConfigRam'];
	if (!empty($_POST['idConfigTime']))                      $idConfigTime                      = $_POST['idConfigTime'];
	if (!empty($_POST['idEstado']))                          $idEstado                          = $_POST['idEstado'];
	if (!empty($_POST['CrossTech_DiasTempMin']))             $CrossTech_DiasTempMin             = $_POST['CrossTech_DiasTempMin'];
	if (!empty($_POST['CrossTech_TempMin']))                 $CrossTech_TempMin                 = $_POST['CrossTech_TempMin'];
	if (!empty($_POST['CrossTech_TempMax']))                 $CrossTech_TempMax                 = $_POST['CrossTech_TempMax'];
	if (!empty($_POST['CrossTech_FechaDiasTempMin']))        $CrossTech_FechaDiasTempMin        = $_POST['CrossTech_FechaDiasTempMin'];
	if (!empty($_POST['CrossTech_FechaTempMin']))            $CrossTech_FechaTempMin            = $_POST['CrossTech_FechaTempMin'];
	if (!empty($_POST['CrossTech_FechaTempMax']))            $CrossTech_FechaTempMax            = $_POST['CrossTech_FechaTempMax'];
	if (!empty($_POST['CrossTech_FechaUnidadFrio']))         $CrossTech_FechaUnidadFrio         = $_POST['CrossTech_FechaUnidadFrio'];
	if (!empty($_POST['CrossTech_HoraPrevRev']))             $CrossTech_HoraPrevRev             = $_POST['CrossTech_HoraPrevRev'];
	if (!empty($_POST['CrossTech_HoraPrevision']))           $CrossTech_HoraPrevision           = $_POST['CrossTech_HoraPrevision'];
	if (!empty($_POST['CrossTech_HoraPrevCuenta']))          $CrossTech_HoraPrevCuenta          = $_POST['CrossTech_HoraPrevCuenta'];
	if (!empty($_POST['CrossTech_HeladaTemp']))              $CrossTech_HeladaTemp              = $_POST['CrossTech_HeladaTemp'];
	if (!empty($_POST['CrossTech_HeladaMailHoraIni']))       $CrossTech_HeladaMailHoraIni       = $_POST['CrossTech_HeladaMailHoraIni'];
	if (!empty($_POST['CrossTech_HeladaMailHoraTerm']))      $CrossTech_HeladaMailHoraTerm      = $_POST['CrossTech_HeladaMailHoraTerm'];
	if (!empty($_POST['Social_idUso']))                      $Social_idUso                      = $_POST['Social_idUso'];
	if ( isset($_POST['Social_facebook']))                   $Social_facebook                   = $_POST['Social_facebook'];
	if ( isset($_POST['Social_twitter']))                    $Social_twitter                    = $_POST['Social_twitter'];
	if ( isset($_POST['Social_instagram']))                  $Social_instagram                  = $_POST['Social_instagram'];
	if ( isset($_POST['Social_linkedin']))                   $Social_linkedin                   = $_POST['Social_linkedin'];
	if ( isset($_POST['Social_rss']))                        $Social_rss                        = $_POST['Social_rss'];
	if ( isset($_POST['Social_youtube']))                    $Social_youtube                    = $_POST['Social_youtube'];
	if ( isset($_POST['Social_tumblr']))                     $Social_tumblr                     = $_POST['Social_tumblr'];
	if ( isset($_POST['CrossEnergy_PeriodoInicio']))         $CrossEnergy_PeriodoInicio         = $_POST['CrossEnergy_PeriodoInicio'];
	if ( isset($_POST['CrossEnergy_PeriodoTermino']))        $CrossEnergy_PeriodoTermino        = $_POST['CrossEnergy_PeriodoTermino'];
	if ( isset($_POST['CrossEnergy_HorarioInicio']))         $CrossEnergy_HorarioInicio         = $_POST['CrossEnergy_HorarioInicio'];
	if ( isset($_POST['CrossEnergy_HorarioTermino']))        $CrossEnergy_HorarioTermino        = $_POST['CrossEnergy_HorarioTermino'];
	if ( isset($_POST['RepresentanteNombre']))               $RepresentanteNombre               = $_POST['RepresentanteNombre'];
	if ( isset($_POST['RepresentanteRut']))                  $RepresentanteRut                  = $_POST['RepresentanteRut'];

	if (!empty($_POST['CrossTech_FechaDiasTempMinOld']))     $CrossTech_FechaDiasTempMinOld     = $_POST['CrossTech_FechaDiasTempMinOld'];
	if (!empty($_POST['CrossTech_FechaTempMinOld']))         $CrossTech_FechaTempMinOld         = $_POST['CrossTech_FechaTempMinOld'];
	if (!empty($_POST['CrossTech_FechaTempMaxOld']))         $CrossTech_FechaTempMaxOld         = $_POST['CrossTech_FechaTempMaxOld'];
	if (!empty($_POST['CrossTech_FechaUnidadFrioOld']))      $CrossTech_FechaUnidadFrioOld      = $_POST['CrossTech_FechaUnidadFrioOld'];
	if (!empty($_POST['CrossEnergy_PeriodoInicioOld']))      $CrossEnergy_PeriodoInicioOld      = $_POST['CrossEnergy_PeriodoInicioOld'];
	if (!empty($_POST['CrossEnergy_PeriodoTerminoOld']))     $CrossEnergy_PeriodoTerminoOld     = $_POST['CrossEnergy_PeriodoTerminoOld'];
	if (!empty($_POST['CrossEnergy_HorarioInicioOld']))      $CrossEnergy_HorarioInicioOld      = $_POST['CrossEnergy_HorarioInicioOld'];
	if (!empty($_POST['CrossEnergy_HorarioTerminoOld']))     $CrossEnergy_HorarioTerminoOld     = $_POST['CrossEnergy_HorarioTerminoOld'];

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
			case 'idSistema':                          if(empty($idSistema)){                           $error['idSistema']                           = 'error/No ha ingresado el id';}break;
			case 'Nombre':                             if(empty($Nombre)){                              $error['Nombre']                              = 'error/No ha ingresado el Nombre';}break;
			case 'email_principal':                    if(!isset($email_principal)){                    $error['email_principal']                     = 'error/No ha ingresado el email';}break;
			case 'Rut':                                if(empty($Rut)){                                 $error['Rut']                                 = 'error/No ha ingresado el Rut';}break;
			case 'idCiudad':                           if(!isset($idCiudad)){                           $error['idCiudad']                            = 'error/No ha seleccionado la región';}break;
			case 'idComuna':                           if(!isset($idComuna)){                           $error['idComuna']                            = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':                          if(empty($Direccion)){                           $error['Direccion']                           = 'error/No ha ingresado la dirección';}break;
			case 'CajaChica':                          if(!isset($CajaChica)){                          $error['CajaChica']                           = 'error/No ha ingresado el Nombre monto de la caja chica';}break;
			case 'Contacto_Nombre':                    if(!isset($Contacto_Nombre)){                    $error['Contacto_Nombre']                     = 'error/No ha ingresado el Nombre del contacto';}break;
			case 'Contacto_Fono1':                     if(!isset($Contacto_Fono1)){                     $error['Contacto_Fono1']                      = 'error/No ha ingresado el telefono 1';}break;
			case 'Contacto_Fono2':                     if(!isset($Contacto_Fono2)){                     $error['Contacto_Fono2']                      = 'error/No ha ingresado el telefono 2';}break;
			case 'Contacto_Fax':                       if(!isset($Contacto_Fax)){                       $error['Contacto_Fax']                        = 'error/No ha ingresado el fax';}break;
			case 'Contacto_Email':                     if(!isset($Contacto_Email)){                     $error['Contacto_Email']                      = 'error/No ha ingresado el email del sistema';}break;
			case 'Contacto_Web':                       if(!isset($Contacto_Web)){                       $error['Contacto_Web']                        = 'error/No ha ingresado la pagina web';}break;
			case 'Contrato_Nombre':                    if(!isset($Contrato_Nombre)){                    $error['Contrato_Nombre']                     = 'error/No ha ingresado el Nombre del contrato';}break;
			case 'Contrato_Numero':                    if(empty($Contrato_Numero)){                     $error['Contrato_Numero']                     = 'error/No ha ingresado el numero de contrato';}break;
			case 'Contrato_Fecha':                     if(empty($Contrato_Fecha)){                      $error['Contrato_Fecha']                      = 'error/No ha ingresado la fecha de contrato';}break;
			case 'Contrato_Duracion':                  if(empty($Contrato_Duracion)){                   $error['Contrato_Duracion']                   = 'error/No ha ingresado la duracion del contrato';}break;
			case 'Config_IDGoogle':                    if(empty($Config_IDGoogle)){                     $error['Config_IDGoogle']                     = 'error/No ha ingresado la ID de Google';}break;
			case 'Config_Google_apiKey':               if(empty($Config_Google_apiKey)){                $error['Config_Google_apiKey']                = 'error/No ha ingresado la ID de Android';}break;
			case 'Config_FCM_apiKey':                  if(empty($Config_FCM_apiKey)){                   $error['Config_FCM_apiKey']                   = 'error/No ha ingresado la ID de Firebase';}break;
			case 'Config_FCM_Main_apiKey':             if(empty($Config_FCM_Main_apiKey)){              $error['Config_FCM_Main_apiKey']              = 'error/No ha ingresado la ID Maestra de Firebase';}break;
			case 'Config_imgLogo':                     if(empty($Config_imgLogo)){                      $error['Config_imgLogo']                      = 'error/No ha subido el logo';}break;
			case 'Config_idTheme':                     if(empty($Config_idTheme)){                      $error['Config_idTheme']                      = 'error/No ha seleccionado el tema';}break;
			case 'Config_CorreoRespaldo':              if(empty($Config_CorreoRespaldo)){               $error['Config_CorreoRespaldo']               = 'error/No ha ingresado el correo de respaldo';}break;
			case 'Config_Gmail_Usuario':               if(empty($Config_Gmail_Usuario)){                $error['Config_Gmail_Usuario']                = 'error/No ha ingresado el usuario de gmail';}break;
			case 'Config_Gmail_Password':              if(empty($Config_Gmail_Password)){               $error['Config_Gmail_Password']               = 'error/No ha ingresado la contraseña del usuario de gmail';}break;
			case 'Config_WhatsappToken':               if(empty($Config_WhatsappToken)){                $error['Config_WhatsappToken']                = 'error/No ha ingresado el Whatsapp Token';}break;
			case 'Config_WhatsappInstanceId':          if(empty($Config_WhatsappInstanceId)){           $error['Config_WhatsappInstanceId']           = 'error/No ha ingresado el Whatsapp Instance Id';}break;
			case 'idOpcionesGen_1':                    if(empty($idOpcionesGen_1)){                     $error['idOpcionesGen_1']                     = 'error/No ha seleccionado la opción 1';}break;
			case 'idOpcionesGen_2':                    if(empty($idOpcionesGen_2)){                     $error['idOpcionesGen_2']                     = 'error/No ha seleccionado la opción 2';}break;
			case 'idOpcionesGen_3':                    if(empty($idOpcionesGen_3)){                     $error['idOpcionesGen_3']                     = 'error/No ha seleccionado la opción 3';}break;
			case 'idOpcionesGen_4':                    if(empty($idOpcionesGen_4)){                     $error['idOpcionesGen_4']                     = 'error/No ha seleccionado la opción 4';}break;
			case 'idOpcionesGen_5':                    if(empty($idOpcionesGen_5)){                     $error['idOpcionesGen_5']                     = 'error/No ha seleccionado la opción 5';}break;
			case 'idOpcionesGen_6':                    if(!isset($idOpcionesGen_6)){                    $error['idOpcionesGen_6']                     = 'error/No ha seleccionado la opción 6';}break;
			case 'idOpcionesGen_7':                    if(empty($idOpcionesGen_7)){                     $error['idOpcionesGen_7']                     = 'error/No ha seleccionado la opción 7';}break;
			case 'idOpcionesGen_8':                    if(empty($idOpcionesGen_8)){                     $error['idOpcionesGen_8']                     = 'error/No ha seleccionado la opción 8';}break;
			case 'idOpcionesGen_9':                    if(empty($idOpcionesGen_9)){                     $error['idOpcionesGen_9']                     = 'error/No ha seleccionado la opción 9';}break;
			case 'idOpcionesGen_10':                   if(empty($idOpcionesGen_10)){                    $error['idOpcionesGen_10']                    = 'error/No ha seleccionado la opción 10';}break;
			case 'idOpcionesGen_11':                   if(empty($idOpcionesGen_11)){                    $error['idOpcionesGen_11']                    = 'error/No ha seleccionado la opción 11';}break;
			case 'idOpcionesGen_12':                   if(empty($idOpcionesGen_12)){                    $error['idOpcionesGen_12']                    = 'error/No ha seleccionado la opción 12';}break;
			case 'idOpcionesGen_13':                   if(empty($idOpcionesGen_13)){                    $error['idOpcionesGen_13']                    = 'error/No ha seleccionado la opción 13';}break;
			case 'idOpcionesGen_14':                   if(empty($idOpcionesGen_14)){                    $error['idOpcionesGen_14']                    = 'error/No ha seleccionado la opción 14';}break;
			case 'idOpcionesGen_15':                   if(empty($idOpcionesGen_15)){                    $error['idOpcionesGen_15']                    = 'error/No ha seleccionado la opción 15';}break;
			case 'idOpcionesGen_16':                   if(empty($idOpcionesGen_16)){                    $error['idOpcionesGen_16']                    = 'error/No ha seleccionado la opción 16';}break;
			case 'idOpcionesGen_17':                   if(empty($idOpcionesGen_17)){                    $error['idOpcionesGen_17']                    = 'error/No ha seleccionado la opción 17';}break;
			case 'idOpcionesGen_18':                   if(empty($idOpcionesGen_18)){                    $error['idOpcionesGen_18']                    = 'error/No ha seleccionado la opción 18';}break;
			case 'idOpcionesGen_19':                   if(empty($idOpcionesGen_19)){                    $error['idOpcionesGen_19']                    = 'error/No ha seleccionado la opción 19';}break;
			case 'idOpcionesGen_20':                   if(empty($idOpcionesGen_20)){                    $error['idOpcionesGen_20']                    = 'error/No ha seleccionado la opción 20';}break;
			case 'OT_idBodegaProd':                    if(empty($OT_idBodegaProd)){                     $error['OT_idBodegaProd']                     = 'error/No ha seleccionado la bodega de productos';}break;
			case 'OT_idBodegaIns':                     if(empty($OT_idBodegaIns)){                      $error['OT_idBodegaIns']                      = 'error/No ha seleccionado la bodega de insumos';}break;
			case 'Rubro':                              if(empty($Rubro)){                               $error['Rubro']                               = 'error/No ha ingresado el rubro';}break;
			case 'idOpcionesTel':                      if(empty($idOpcionesTel)){                       $error['idOpcionesTel']                       = 'error/No ha seleccionado el resumen de telemetria a mostrar';}break;
			case 'idConfigRam':                        if(empty($idConfigRam)){                         $error['idConfigRam']                         = 'error/No ha seleccionado la configuracion de la ram';}break;
			case 'idConfigTime':                       if(empty($idConfigTime)){                        $error['idConfigTime']                        = 'error/No ha seleccionado la configuracion del tiempo de espera';}break;
			case 'idEstado':                           if(empty($idEstado)){                            $error['idEstado']                            = 'error/No ha seleccionado el sistema';}break;
			case 'CrossTech_DiasTempMin':              if(empty($CrossTech_DiasTempMin)){               $error['CrossTech_DiasTempMin']               = 'error/No ha ingresado la temperatura minima de los dias';}break;
			case 'CrossTech_TempMin':                  if(empty($CrossTech_TempMin)){                   $error['CrossTech_TempMin']                   = 'error/No ha ingresado la temperatura minima';}break;
			case 'CrossTech_TempMax':                  if(empty($CrossTech_TempMax)){                   $error['CrossTech_TempMax']                   = 'error/No ha ingresado la temperatura maxima';}break;
			case 'CrossTech_FechaDiasTempMin':         if(empty($CrossTech_FechaDiasTempMin)){          $error['CrossTech_FechaDiasTempMin']          = 'error/No ha ingresado la fecha de temperatura minima de los dias';}break;
			case 'CrossTech_FechaTempMin':             if(empty($CrossTech_FechaTempMin)){              $error['CrossTech_FechaTempMin']              = 'error/No ha ingresado la fecha de temperatura minima';}break;
			case 'CrossTech_FechaTempMax':             if(empty($CrossTech_FechaTempMax)){              $error['CrossTech_FechaTempMax']              = 'error/No ha ingresado la fecha de temperatura maxima';}break;
			case 'CrossTech_FechaUnidadFrio':          if(empty($CrossTech_FechaUnidadFrio)){           $error['CrossTech_FechaUnidadFrio']           = 'error/No ha ingresado la fecha de la unidad de frio';}break;
			case 'CrossTech_HoraPrevRev':              if(empty($CrossTech_HoraPrevRev)){               $error['CrossTech_HoraPrevRev']               = 'error/No ha ingresado las horas a revisar para la prevision';}break;
			case 'CrossTech_HoraPrevision':            if(empty($CrossTech_HoraPrevision)){             $error['CrossTech_HoraPrevision']             = 'error/No ha ingresado las horas de prevision';}break;
			case 'CrossTech_HoraPrevCuenta':           if(empty($CrossTech_HoraPrevCuenta)){            $error['CrossTech_HoraPrevCuenta']            = 'error/No ha ingresado la cuenta de las horas de prevision';}break;
			case 'CrossTech_HeladaTemp':               if(empty($CrossTech_HeladaTemp)){                $error['CrossTech_HeladaTemp']                = 'error/No ha ingresado la hora minima de notificacion de helada';}break;
			case 'CrossTech_HeladaMailHoraIni':        if(empty($CrossTech_HeladaMailHoraIni)){         $error['CrossTech_HeladaMailHoraIni']         = 'error/No ha ingresado la hora de inicio de envio de correo';}break;
			case 'CrossTech_HeladaMailHoraTerm':       if(empty($CrossTech_HeladaMailHoraTerm)){        $error['CrossTech_HeladaMailHoraTerm']        = 'error/No ha ingresado la hora de termino de envio de correo';}break;
			case 'Social_idUso':                       if(empty($Social_idUso)){                        $error['Social_idUso']                        = 'error/No ha Seleccionado la opción de mostrar widget sociales';}break;
			case 'Social_facebook':                    if(!isset($Social_facebook)){                    $error['Social_facebook']                     = 'error/No ha ingresado los datos de facebook';}break;
			case 'Social_twitter':                     if(!isset($Social_twitter)){                     $error['Social_twitter']                      = 'error/No ha ingresado los datos de twitter';}break;
			case 'Social_instagram':                   if(!isset($Social_instagram)){                   $error['Social_instagram']                    = 'error/No ha ingresado los datos de instagram';}break;
			case 'Social_linkedin':                    if(!isset($Social_linkedin)){                    $error['Social_linkedin']                     = 'error/No ha ingresado los datos de linkedin';}break;
			case 'Social_rss':                         if(!isset($Social_rss)){                         $error['Social_rss']                          = 'error/No ha ingresado los datos de rss';}break;
			case 'Social_youtube':                     if(!isset($Social_youtube)){                     $error['Social_youtube']                      = 'error/No ha ingresado los datos de youtube';}break;
			case 'Social_tumblr':                      if(!isset($Social_tumblr)){                      $error['Social_tumblr']                       = 'error/No ha ingresado los datos de tumblr';}break;
			case 'CrossEnergy_PeriodoInicio':          if(empty($CrossEnergy_PeriodoInicio)){           $error['CrossEnergy_PeriodoInicio']           = 'error/No ha ingresado el Periodo Inicio';}break;
			case 'CrossEnergy_PeriodoTermino':         if(empty($CrossEnergy_PeriodoTermino)){          $error['CrossEnergy_PeriodoTermino']          = 'error/No ha ingresado el Periodo Termino';}break;
			case 'CrossEnergy_HorarioInicio':          if(empty($CrossEnergy_HorarioInicio)){           $error['CrossEnergy_HorarioInicio']           = 'error/No ha ingresado la Horario Inicio';}break;
			case 'CrossEnergy_HorarioTermino':         if(empty($CrossEnergy_HorarioTermino)){          $error['CrossEnergy_HorarioTermino']          = 'error/No ha ingresado la Horario Termino';}break;
			case 'RepresentanteNombre':                if(empty($RepresentanteNombre)){                 $error['RepresentanteNombre']                 = 'error/No ha ingresado el nombre del representante';}break;
			case 'RepresentanteRut':                   if(empty($RepresentanteRut)){                    $error['RepresentanteRut']                    = 'error/No ha ingresado el rut del representante';}break;

			case 'CrossTech_FechaDiasTempMinOld':      if(empty($CrossTech_FechaDiasTempMinOld)){       $error['CrossTech_FechaDiasTempMinOld']       = 'error/No ha ingresado la fecha de temperatura minima de los dias';}break;
			case 'CrossTech_FechaTempMinOld':          if(empty($CrossTech_FechaTempMinOld)){           $error['CrossTech_FechaTempMinOld']           = 'error/No ha ingresado la fecha de temperatura minima';}break;
			case 'CrossTech_FechaTempMaxOld':          if(empty($CrossTech_FechaTempMaxOld)){           $error['CrossTech_FechaTempMaxOld']           = 'error/No ha ingresado la fecha de temperatura maxima';}break;
			case 'CrossTech_FechaUnidadFrioOld':       if(empty($CrossTech_FechaUnidadFrioOld)){        $error['CrossTech_FechaUnidadFrioOld']        = 'error/No ha ingresado la fecha de la unidad de frio';}break;
			case 'CrossEnergy_PeriodoInicioOld':       if(empty($CrossEnergy_PeriodoInicioOld)){        $error['CrossEnergy_PeriodoInicioOld']        = 'error/No ha ingresado el Periodo Inicio';}break;
			case 'CrossEnergy_PeriodoTerminoOld':      if(empty($CrossEnergy_PeriodoTerminoOld)){       $error['CrossEnergy_PeriodoTerminoOld']       = 'error/No ha ingresado el Periodo Termino';}break;
			case 'CrossEnergy_HorarioInicioOld':       if(empty($CrossEnergy_HorarioInicioOld)){        $error['CrossEnergy_HorarioInicioOld']        = 'error/No ha ingresado la Horario Inicio';}break;
			case 'CrossEnergy_HorarioTerminoOld':      if(empty($CrossEnergy_HorarioTerminoOld)){       $error['CrossEnergy_HorarioTerminoOld']       = 'error/No ha ingresado la Horario Termino';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                                        $Nombre                    = EstandarizarInput($Nombre);}
	//if(isset($email_principal) && $email_principal!=''){                      $email_principal           = EstandarizarInput($email_principal);}
	if(isset($Direccion) && $Direccion!=''){                                  $Direccion                 = EstandarizarInput($Direccion);}
	if(isset($Contacto_Nombre) && $Contacto_Nombre!=''){                      $Contacto_Nombre           = EstandarizarInput($Contacto_Nombre);}
	if(isset($Contacto_Email) && $Contacto_Email!=''){                        $Contacto_Email            = EstandarizarInput($Contacto_Email);}
	if(isset($Contacto_Web) && $Contacto_Web!=''){                            $Contacto_Web              = EstandarizarInput($Contacto_Web);}
	if(isset($Contrato_Nombre) && $Contrato_Nombre!=''){                      $Contrato_Nombre           = EstandarizarInput($Contrato_Nombre);}
	if(isset($Contrato_Numero) && $Contrato_Numero!=''){                      $Contrato_Numero           = EstandarizarInput($Contrato_Numero);}
	if(isset($Contrato_Duracion) && $Contrato_Duracion!=''){                  $Contrato_Duracion         = EstandarizarInput($Contrato_Duracion);}
	if(isset($Config_IDGoogle) && $Config_IDGoogle!=''){                      $Config_IDGoogle           = EstandarizarInput($Config_IDGoogle);}
	if(isset($Config_Google_apiKey) && $Config_Google_apiKey!=''){            $Config_Google_apiKey      = EstandarizarInput($Config_Google_apiKey);}
	if(isset($Config_FCM_apiKey) && $Config_FCM_apiKey!=''){                  $Config_FCM_apiKey         = EstandarizarInput($Config_FCM_apiKey);}
	if(isset($Config_FCM_Main_apiKey) && $Config_FCM_Main_apiKey!=''){        $Config_FCM_Main_apiKey    = EstandarizarInput($Config_FCM_Main_apiKey);}
	if(isset($Config_CorreoRespaldo) && $Config_CorreoRespaldo!=''){          $Config_CorreoRespaldo     = EstandarizarInput($Config_CorreoRespaldo);}
	if(isset($Config_Gmail_Usuario) && $Config_Gmail_Usuario!=''){            $Config_Gmail_Usuario      = EstandarizarInput($Config_Gmail_Usuario);}
	if(isset($Config_Gmail_Password) && $Config_Gmail_Password!=''){          $Config_Gmail_Password     = EstandarizarInput($Config_Gmail_Password);}
	if(isset($Config_WhatsappToken) && $Config_WhatsappToken!=''){            $Config_WhatsappToken      = EstandarizarInput($Config_WhatsappToken);}
	if(isset($Config_WhatsappInstanceId) && $Config_WhatsappInstanceId!=''){  $Config_WhatsappInstanceId = EstandarizarInput($Config_WhatsappInstanceId);}
	if(isset($Rubro) && $Rubro!=''){                                          $Rubro                     = EstandarizarInput($Rubro);}
	if(isset($Social_facebook) && $Social_facebook!=''){                      $Social_facebook           = EstandarizarInput($Social_facebook);}
	if(isset($Social_twitter) && $Social_twitter!=''){                        $Social_twitter            = EstandarizarInput($Social_twitter);}
	if(isset($Social_instagram) && $Social_instagram!=''){                    $Social_instagram          = EstandarizarInput($Social_instagram);}
	if(isset($Social_linkedin) && $Social_linkedin!=''){                      $Social_linkedin           = EstandarizarInput($Social_linkedin);}
	if(isset($Social_rss) && $Social_rss!=''){                                $Social_rss                = EstandarizarInput($Social_rss);}
	if(isset($Social_youtube) && $Social_youtube!=''){                        $Social_youtube            = EstandarizarInput($Social_youtube);}
	if(isset($Social_tumblr) && $Social_tumblr!=''){                          $Social_tumblr             = EstandarizarInput($Social_tumblr);}
	if(isset($RepresentanteNombre) && $RepresentanteNombre!=''){              $RepresentanteNombre       = EstandarizarInput($RepresentanteNombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($email_principal)&&$email_principal!=''&&!validarEmail($email_principal)){ $error['email_principal']   = 'error/El Email de sistema ingresado no es valido';}
	if(isset($Contacto_Fono1)&&$Contacto_Fono1!=''&&!validarNumero($Contacto_Fono1)){   $error['Contacto_Fono1']	= 'error/Ingrese un número telefónico válido';}
	if(isset($Contacto_Fono2)&&$Contacto_Fono2!=''&&!validarNumero($Contacto_Fono2)){   $error['Contacto_Fono2']	= 'error/Ingrese un número telefónico válido';}
	if(isset($Contacto_Fono1)&&palabra_corto($Contacto_Fono1, 9)!=1){                   $error['Contacto_Fono1']    = 'error/'.palabra_corto($Contacto_Fono1, 9);}
	if(isset($Contacto_Fono2)&&palabra_corto($Contacto_Fono2, 9)!=1){                   $error['Contacto_Fono2']    = 'error/'.palabra_corto($Contacto_Fono2, 9);}
	if(isset($Rut)&&$Rut!=''&&!validarRut($Rut)){                                       $error['Rut']               = 'error/El Rut ingresado no es valido';}
	if(isset($Contacto_Email)&&$email_principal!=''&&!validarEmail($Contacto_Email)){   $error['Contacto_Email']    = 'error/El Email de contacto ingresado no es valido';}

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
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'core_sistemas','', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'core_sistemas','', "Rut='".$Rut."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($Nombre) && $Nombre!=''){                                               $SIS_data  = "'".$Nombre."'";                              }else{$SIS_data  = "''";}
				if(isset($email_principal) && $email_principal!=''){                             $SIS_data .= ",'".$email_principal."'";                    }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                                                     $SIS_data .= ",'".$Rut."'";                                }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                                           $SIS_data .= ",'".$idCiudad."'";                           }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                                           $SIS_data .= ",'".$idComuna."'";                           }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){                                         $SIS_data .= ",'".$Direccion."'";                          }else{$SIS_data .= ",''";}
				if(isset($CajaChica) && $CajaChica!=''){                                         $SIS_data .= ",'".$CajaChica."'";                          }else{$SIS_data .= ",''";}
				if(isset($Contacto_Nombre) && $Contacto_Nombre!=''){                             $SIS_data .= ",'".$Contacto_Nombre."'";                    }else{$SIS_data .= ",''";}
				if(isset($Contacto_Fono1) && $Contacto_Fono1!=''){                               $SIS_data .= ",'".$Contacto_Fono1."'";                     }else{$SIS_data .= ",''";}
				if(isset($Contacto_Fono2) && $Contacto_Fono2!=''){                               $SIS_data .= ",'".$Contacto_Fono2."'";                     }else{$SIS_data .= ",''";}
				if(isset($Contacto_Fax) && $Contacto_Fax!=''){                                   $SIS_data .= ",'".$Contacto_Fax."'";                       }else{$SIS_data .= ",''";}
				if(isset($Contacto_Email) && $Contacto_Email!=''){                               $SIS_data .= ",'".$Contacto_Email."'";                     }else{$SIS_data .= ",''";}
				if(isset($Contacto_Web) && $Contacto_Web!=''){                                   $SIS_data .= ",'".$Contacto_Web."'";                       }else{$SIS_data .= ",''";}
				if(isset($Contrato_Nombre) && $Contrato_Nombre!=''){                             $SIS_data .= ",'".$Contrato_Nombre."'";                    }else{$SIS_data .= ",''";}
				if(isset($Contrato_Numero) && $Contrato_Numero!=''){                             $SIS_data .= ",'".$Contrato_Numero."'";                    }else{$SIS_data .= ",''";}
				if(isset($Contrato_Fecha) && $Contrato_Fecha!=''){                               $SIS_data .= ",'".$Contrato_Fecha."'";                     }else{$SIS_data .= ",''";}
				if(isset($Contrato_Duracion) && $Contrato_Duracion!=''){                         $SIS_data .= ",'".$Contrato_Duracion."'";                  }else{$SIS_data .= ",''";}
				if(isset($Config_IDGoogle) && $Config_IDGoogle!=''){                             $SIS_data .= ",'".$Config_IDGoogle."'";                    }else{$SIS_data .= ",''";}
				if(isset($Config_Google_apiKey) && $Config_Google_apiKey!=''){                   $SIS_data .= ",'".$Config_Google_apiKey."'";               }else{$SIS_data .= ",''";}
				if(isset($Config_FCM_apiKey) && $Config_FCM_apiKey!=''){                         $SIS_data .= ",'".$Config_FCM_apiKey."'";                  }else{$SIS_data .= ",''";}
				if(isset($Config_FCM_Main_apiKey) && $Config_FCM_Main_apiKey!=''){               $SIS_data .= ",'".$Config_FCM_Main_apiKey."'";             }else{$SIS_data .= ",''";}
				if(isset($Config_imgLogo) && $Config_imgLogo!=''){                               $SIS_data .= ",'".$Config_imgLogo."'";                     }else{$SIS_data .= ",''";}
				if(isset($Config_idTheme) && $Config_idTheme!=''){                               $SIS_data .= ",'".$Config_idTheme."'";                     }else{$SIS_data .= ",''";}
				if(isset($Config_CorreoRespaldo) && $Config_CorreoRespaldo!=''){                 $SIS_data .= ",'".$Config_CorreoRespaldo."'";              }else{$SIS_data .= ",''";}
				if(isset($Config_Gmail_Usuario) && $Config_Gmail_Usuario!=''){                   $SIS_data .= ",'".$Config_Gmail_Usuario."'";               }else{$SIS_data .= ",''";}
				if(isset($Config_Gmail_Password) && $Config_Gmail_Password!=''){                 $SIS_data .= ",'".$Config_Gmail_Password."'";              }else{$SIS_data .= ",''";}
				if(isset($Config_WhatsappToken) && $Config_WhatsappToken!=''){                   $SIS_data .= ",'".$Config_WhatsappToken."'";               }else{$SIS_data .= ",''";}
				if(isset($Config_WhatsappInstanceId) && $Config_WhatsappInstanceId!=''){         $SIS_data .= ",'".$Config_WhatsappInstanceId."'";          }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_1) && $idOpcionesGen_1!=''){                             $SIS_data .= ",'".$idOpcionesGen_1."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_2) && $idOpcionesGen_2!=''){                             $SIS_data .= ",'".$idOpcionesGen_2."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_3) && $idOpcionesGen_3!=''){                             $SIS_data .= ",'".$idOpcionesGen_3."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_4) && $idOpcionesGen_4!=''){                             $SIS_data .= ",'".$idOpcionesGen_4."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_5) && $idOpcionesGen_5!=''){                             $SIS_data .= ",'".$idOpcionesGen_5."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_6) && $idOpcionesGen_6!=''){                             $SIS_data .= ",'".$idOpcionesGen_6."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_7) && $idOpcionesGen_7!=''){                             $SIS_data .= ",'".$idOpcionesGen_7."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_8) && $idOpcionesGen_8!=''){                             $SIS_data .= ",'".$idOpcionesGen_8."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_9) && $idOpcionesGen_9!=''){                             $SIS_data .= ",'".$idOpcionesGen_9."'";                    }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_10) && $idOpcionesGen_10!=''){                           $SIS_data .= ",'".$idOpcionesGen_10."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_11) && $idOpcionesGen_11!=''){                           $SIS_data .= ",'".$idOpcionesGen_11."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_12) && $idOpcionesGen_12!=''){                           $SIS_data .= ",'".$idOpcionesGen_12."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_13) && $idOpcionesGen_13!=''){                           $SIS_data .= ",'".$idOpcionesGen_13."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_14) && $idOpcionesGen_14!=''){                           $SIS_data .= ",'".$idOpcionesGen_14."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_15) && $idOpcionesGen_15!=''){                           $SIS_data .= ",'".$idOpcionesGen_15."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_16) && $idOpcionesGen_16!=''){                           $SIS_data .= ",'".$idOpcionesGen_16."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_17) && $idOpcionesGen_17!=''){                           $SIS_data .= ",'".$idOpcionesGen_17."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_18) && $idOpcionesGen_18!=''){                           $SIS_data .= ",'".$idOpcionesGen_18."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_19) && $idOpcionesGen_19!=''){                           $SIS_data .= ",'".$idOpcionesGen_19."'";                   }else{$SIS_data .= ",''";}
				if(isset($idOpcionesGen_20) && $idOpcionesGen_20!=''){                           $SIS_data .= ",'".$idOpcionesGen_20."'";                   }else{$SIS_data .= ",''";}
				if(isset($OT_idBodegaProd) && $OT_idBodegaProd!=''){                             $SIS_data .= ",'".$OT_idBodegaProd."'";                    }else{$SIS_data .= ",''";}
				if(isset($OT_idBodegaIns) && $OT_idBodegaIns!=''){                               $SIS_data .= ",'".$OT_idBodegaIns."'";                     }else{$SIS_data .= ",''";}
				if(isset($Rubro) && $Rubro!=''){                                                 $SIS_data .= ",'".$Rubro."'";                              }else{$SIS_data .= ",''";}
				if(isset($idOpcionesTel) && $idOpcionesTel!=''){                                 $SIS_data .= ",'".$idOpcionesTel."'";                      }else{$SIS_data .= ",''";}
				if(isset($idConfigRam) && $idConfigRam!=''){                                     $SIS_data .= ",'".$idConfigRam."'";                        }else{$SIS_data .= ",''";}
				if(isset($idConfigTime) && $idConfigTime!=''){                                   $SIS_data .= ",'".$idConfigTime."'";                       }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                                           $SIS_data .= ",'".$idEstado."'";                           }else{$SIS_data .= ",''";}
				if(isset($CrossTech_DiasTempMin) && $CrossTech_DiasTempMin!=''){                 $SIS_data .= ",'".$CrossTech_DiasTempMin."'";              }else{$SIS_data .= ",''";}
				if(isset($CrossTech_TempMin) && $CrossTech_TempMin!=''){                         $SIS_data .= ",'".$CrossTech_TempMin."'";                  }else{$SIS_data .= ",''";}
				if(isset($CrossTech_TempMax) && $CrossTech_TempMax!=''){                         $SIS_data .= ",'".$CrossTech_TempMax."'";                  }else{$SIS_data .= ",''";}
				if(isset($CrossTech_FechaDiasTempMin) && $CrossTech_FechaDiasTempMin!=''){       $SIS_data .= ",'".$CrossTech_FechaDiasTempMin."'";         }else{$SIS_data .= ",''";}
				if(isset($CrossTech_FechaTempMin) && $CrossTech_FechaTempMin!=''){               $SIS_data .= ",'".$CrossTech_FechaTempMin."'";             }else{$SIS_data .= ",''";}
				if(isset($CrossTech_FechaTempMax) && $CrossTech_FechaTempMax!=''){               $SIS_data .= ",'".$CrossTech_FechaTempMax."'";             }else{$SIS_data .= ",''";}
				if(isset($CrossTech_FechaUnidadFrio) && $CrossTech_FechaUnidadFrio!=''){         $SIS_data .= ",'".$CrossTech_FechaUnidadFrio."'";          }else{$SIS_data .= ",''";}
				if(isset($CrossTech_HoraPrevRev) && $CrossTech_HoraPrevRev!=''){                 $SIS_data .= ",'".$CrossTech_HoraPrevRev."'";              }else{$SIS_data .= ",''";}
				if(isset($CrossTech_HoraPrevision) && $CrossTech_HoraPrevision!=''){             $SIS_data .= ",'".$CrossTech_HoraPrevision."'";            }else{$SIS_data .= ",''";}
				if(isset($CrossTech_HoraPrevCuenta) && $CrossTech_HoraPrevCuenta!=''){           $SIS_data .= ",'".$CrossTech_HoraPrevCuenta."'";           }else{$SIS_data .= ",''";}
				if(isset($CrossTech_HeladaTemp) && $CrossTech_HeladaTemp!=''){                   $SIS_data .= ",'".$CrossTech_HeladaTemp."'";               }else{$SIS_data .= ",''";}
				if(isset($CrossTech_HeladaMailHoraIni) && $CrossTech_HeladaMailHoraIni!=''){     $SIS_data .= ",'".$CrossTech_HeladaMailHoraIni."'";        }else{$SIS_data .= ",''";}
				if(isset($CrossTech_HeladaMailHoraTerm) && $CrossTech_HeladaMailHoraTerm!=''){   $SIS_data .= ",'".$CrossTech_HeladaMailHoraTerm."'";       }else{$SIS_data .= ",''";}
				if(isset($Social_idUso) && $Social_idUso!=''){                                   $SIS_data .= ",'".$Social_idUso."'";                       }else{$SIS_data .= ",''";}
				if(isset($Social_facebook) && $Social_facebook!=''){                             $SIS_data .= ",'".$Social_facebook."'";                    }else{$SIS_data .= ",''";}
				if(isset($Social_twitter) && $Social_twitter!=''){                               $SIS_data .= ",'".$Social_twitter."'";                     }else{$SIS_data .= ",''";}
				if(isset($Social_instagram) && $Social_instagram!=''){                           $SIS_data .= ",'".$Social_instagram."'";                   }else{$SIS_data .= ",''";}
				if(isset($Social_linkedin) && $Social_linkedin!=''){                             $SIS_data .= ",'".$Social_linkedin."'";                    }else{$SIS_data .= ",''";}
				if(isset($Social_rss) && $Social_rss!=''){                                       $SIS_data .= ",'".$Social_rss."'";                         }else{$SIS_data .= ",''";}
				if(isset($Social_youtube) && $Social_youtube!=''){                               $SIS_data .= ",'".$Social_youtube."'";                     }else{$SIS_data .= ",''";}
				if(isset($Social_tumblr) && $Social_tumblr!=''){                                 $SIS_data .= ",'".$Social_tumblr."'";                      }else{$SIS_data .= ",''";}
				if(isset($CrossEnergy_PeriodoInicio) && $CrossEnergy_PeriodoInicio!=''){         $SIS_data .= ",'".$CrossEnergy_PeriodoInicio."'";          }else{$SIS_data .= ",''";}
				if(isset($CrossEnergy_PeriodoTermino) && $CrossEnergy_PeriodoTermino!=''){       $SIS_data .= ",'".$CrossEnergy_PeriodoTermino."'";         }else{$SIS_data .= ",''";}
				if(isset($CrossEnergy_HorarioInicio) && $CrossEnergy_HorarioInicio!=''){         $SIS_data .= ",'".$CrossEnergy_HorarioInicio."'";          }else{$SIS_data .= ",''";}
				if(isset($CrossEnergy_HorarioTermino) && $CrossEnergy_HorarioTermino!=''){       $SIS_data .= ",'".$CrossEnergy_HorarioTermino."'";         }else{$SIS_data .= ",''";}
				if(isset($RepresentanteNombre) && $RepresentanteNombre!=''){                     $SIS_data .= ",'".$RepresentanteNombre."'";                }else{$SIS_data .= ",''";}
				if(isset($RepresentanteRut) && $RepresentanteRut!=''){                           $SIS_data .= ",'".$RepresentanteRut."'";                   }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'Nombre,email_principal, Rut, idCiudad,idComuna, Direccion,
				CajaChica, Contacto_Nombre,Contacto_Fono1, Contacto_Fono2, Contacto_Fax, Contacto_Email, Contacto_Web,
				Contrato_Nombre,Contrato_Numero, Contrato_Fecha, Contrato_Duracion, Config_IDGoogle,Config_Google_apiKey,
				Config_FCM_apiKey, Config_FCM_Main_apiKey, Config_imgLogo, Config_idTheme, Config_CorreoRespaldo,
				Config_Gmail_Usuario, Config_Gmail_Password, Config_WhatsappToken, Config_WhatsappInstanceId,
				idOpcionesGen_1, idOpcionesGen_2, idOpcionesGen_3, idOpcionesGen_4, idOpcionesGen_5, idOpcionesGen_6,
				idOpcionesGen_7, idOpcionesGen_8, idOpcionesGen_9, idOpcionesGen_10, idOpcionesGen_11, idOpcionesGen_12,
				idOpcionesGen_13, idOpcionesGen_14, idOpcionesGen_15, idOpcionesGen_16, idOpcionesGen_17,
				idOpcionesGen_18, idOpcionesGen_19, idOpcionesGen_20, OT_idBodegaProd, OT_idBodegaIns, Rubro, idOpcionesTel,
				idConfigRam, idConfigTime, idEstado, CrossTech_DiasTempMin, CrossTech_TempMin, CrossTech_TempMax,
				CrossTech_FechaDiasTempMin, CrossTech_FechaTempMin, CrossTech_FechaTempMax, CrossTech_FechaUnidadFrio,
				CrossTech_HoraPrevRev, CrossTech_HoraPrevision, CrossTech_HoraPrevCuenta, CrossTech_HeladaTemp,
				CrossTech_HeladaMailHoraIni, CrossTech_HeladaMailHoraTerm, Social_idUso, Social_facebook, Social_twitter,
				Social_instagram, Social_linkedin, Social_rss, Social_youtube, Social_tumblr, CrossEnergy_PeriodoInicio,
				CrossEnergy_PeriodoTermino, CrossEnergy_HorarioInicio, CrossEnergy_HorarioTermino, RepresentanteNombre,
				RepresentanteRut';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_sistemas',$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
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
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'core_sistemas','', "Nombre='".$Nombre."' AND idSistema!='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'core_sistemas','', "Rut='".$Rut."' AND idSistema!='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idSistema='".$idSistema."'";
				if(isset($Nombre) && $Nombre!=''){                                               $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($email_principal) && $email_principal!=''){                             $SIS_data .= ",email_principal='".$email_principal."'";}
				if(isset($Rut) && $Rut!=''){                                                     $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($idCiudad) && $idCiudad!=''){                                           $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){                                           $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){                                         $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($CajaChica) && $CajaChica!=''){                                         $SIS_data .= ",CajaChica='".$CajaChica."'";}
				if(isset($Contacto_Nombre) && $Contacto_Nombre!=''){                             $SIS_data .= ",Contacto_Nombre='".$Contacto_Nombre."'";}
				if(isset($Contacto_Fono1) && $Contacto_Fono1!=''){                               $SIS_data .= ",Contacto_Fono1='".$Contacto_Fono1."'";}
				if(isset($Contacto_Fono2) && $Contacto_Fono2!=''){                               $SIS_data .= ",Contacto_Fono2='".$Contacto_Fono2."'";}
				if(isset($Contacto_Fax) && $Contacto_Fax!=''){                                   $SIS_data .= ",Contacto_Fax='".$Contacto_Fax."'";}
				if(isset($Contacto_Email) && $Contacto_Email!=''){                               $SIS_data .= ",Contacto_Email='".$Contacto_Email."'";}
				if(isset($Contacto_Web) && $Contacto_Web!=''){                                   $SIS_data .= ",Contacto_Web='".$Contacto_Web."'";}
				if(isset($Contrato_Nombre) && $Contrato_Nombre!=''){                             $SIS_data .= ",Contrato_Nombre='".$Contrato_Nombre."'";}
				if(isset($Contrato_Numero) && $Contrato_Numero!=''){                             $SIS_data .= ",Contrato_Numero='".$Contrato_Numero."'";}
				if(isset($Contrato_Fecha) && $Contrato_Fecha!=''){                               $SIS_data .= ",Contrato_Fecha='".$Contrato_Fecha."'";}
				if(isset($Contrato_Duracion) && $Contrato_Duracion!=''){                         $SIS_data .= ",Contrato_Duracion='".$Contrato_Duracion."'";}
				if(isset($Config_IDGoogle) && $Config_IDGoogle!=''){                             $SIS_data .= ",Config_IDGoogle='".$Config_IDGoogle."'";}
				if(isset($Config_Google_apiKey) && $Config_Google_apiKey!=''){                   $SIS_data .= ",Config_Google_apiKey='".$Config_Google_apiKey."'";}
				if(isset($Config_FCM_apiKey) && $Config_FCM_apiKey!=''){                         $SIS_data .= ",Config_FCM_apiKey='".$Config_FCM_apiKey."'";}
				if(isset($Config_FCM_Main_apiKey) && $Config_FCM_Main_apiKey!=''){               $SIS_data .= ",Config_FCM_Main_apiKey='".$Config_FCM_Main_apiKey."'";}
				if(isset($Config_imgLogo) && $Config_imgLogo!=''){                               $SIS_data .= ",Config_imgLogo='".$Config_imgLogo."'";}
				if(isset($Config_idTheme) && $Config_idTheme!=''){                               $SIS_data .= ",Config_idTheme='".$Config_idTheme."'";}
				if(isset($Config_CorreoRespaldo) && $Config_CorreoRespaldo!=''){                 $SIS_data .= ",Config_CorreoRespaldo='".$Config_CorreoRespaldo."'";}
				if(isset($Config_Gmail_Usuario) && $Config_Gmail_Usuario!=''){                   $SIS_data .= ",Config_Gmail_Usuario='".$Config_Gmail_Usuario."'";}
				if(isset($Config_Gmail_Password) && $Config_Gmail_Password!=''){                 $SIS_data .= ",Config_Gmail_Password='".$Config_Gmail_Password."'";}
				if(isset($Config_WhatsappToken) && $Config_WhatsappToken!=''){                   $SIS_data .= ",Config_WhatsappToken='".$Config_WhatsappToken."'";}
				if(isset($Config_WhatsappInstanceId) && $Config_WhatsappInstanceId!=''){         $SIS_data .= ",Config_WhatsappInstanceId='".$Config_WhatsappInstanceId."'";}
				if(isset($idOpcionesGen_1) && $idOpcionesGen_1!=''){                             $SIS_data .= ",idOpcionesGen_1='".$idOpcionesGen_1."'";}
				if(isset($idOpcionesGen_2) && $idOpcionesGen_2!=''){                             $SIS_data .= ",idOpcionesGen_2='".$idOpcionesGen_2."'";}
				if(isset($idOpcionesGen_3) && $idOpcionesGen_3!=''){                             $SIS_data .= ",idOpcionesGen_3='".$idOpcionesGen_3."'";}
				if(isset($idOpcionesGen_4) && $idOpcionesGen_4!=''){                             $SIS_data .= ",idOpcionesGen_4='".$idOpcionesGen_4."'";}
				if(isset($idOpcionesGen_5) && $idOpcionesGen_5!=''){                             $SIS_data .= ",idOpcionesGen_5='".$idOpcionesGen_5."'";}
				if(isset($idOpcionesGen_6) && $idOpcionesGen_6!=''){                             $SIS_data .= ",idOpcionesGen_6='".$idOpcionesGen_6."'";}
				if(isset($idOpcionesGen_7) && $idOpcionesGen_7!=''){                             $SIS_data .= ",idOpcionesGen_7='".$idOpcionesGen_7."'";}
				if(isset($idOpcionesGen_8) && $idOpcionesGen_8!=''){                             $SIS_data .= ",idOpcionesGen_8='".$idOpcionesGen_8."'";}
				if(isset($idOpcionesGen_9) && $idOpcionesGen_9!=''){                             $SIS_data .= ",idOpcionesGen_9='".$idOpcionesGen_9."'";}
				if(isset($idOpcionesGen_10) && $idOpcionesGen_10!=''){                           $SIS_data .= ",idOpcionesGen_10='".$idOpcionesGen_10."'";}
				if(isset($idOpcionesGen_11) && $idOpcionesGen_11!=''){                           $SIS_data .= ",idOpcionesGen_11='".$idOpcionesGen_11."'";}
				if(isset($idOpcionesGen_12) && $idOpcionesGen_12!=''){                           $SIS_data .= ",idOpcionesGen_12='".$idOpcionesGen_12."'";}
				if(isset($idOpcionesGen_13) && $idOpcionesGen_13!=''){                           $SIS_data .= ",idOpcionesGen_13='".$idOpcionesGen_13."'";}
				if(isset($idOpcionesGen_14) && $idOpcionesGen_14!=''){                           $SIS_data .= ",idOpcionesGen_14='".$idOpcionesGen_14."'";}
				if(isset($idOpcionesGen_15) && $idOpcionesGen_15!=''){                           $SIS_data .= ",idOpcionesGen_15='".$idOpcionesGen_15."'";}
				if(isset($idOpcionesGen_16) && $idOpcionesGen_16!=''){                           $SIS_data .= ",idOpcionesGen_16='".$idOpcionesGen_16."'";}
				if(isset($idOpcionesGen_17) && $idOpcionesGen_17!=''){                           $SIS_data .= ",idOpcionesGen_17='".$idOpcionesGen_17."'";}
				if(isset($idOpcionesGen_18) && $idOpcionesGen_18!=''){                           $SIS_data .= ",idOpcionesGen_18='".$idOpcionesGen_18."'";}
				if(isset($idOpcionesGen_19) && $idOpcionesGen_19!=''){                           $SIS_data .= ",idOpcionesGen_19='".$idOpcionesGen_19."'";}
				if(isset($idOpcionesGen_20) && $idOpcionesGen_20!=''){                           $SIS_data .= ",idOpcionesGen_20='".$idOpcionesGen_20."'";}
				if(isset($OT_idBodegaProd) && $OT_idBodegaProd!=''){                             $SIS_data .= ",OT_idBodegaProd='".$OT_idBodegaProd."'";}
				if(isset($OT_idBodegaIns) && $OT_idBodegaIns!=''){                               $SIS_data .= ",OT_idBodegaIns='".$OT_idBodegaIns."'";}
				if(isset($Rubro) && $Rubro!=''){                                                 $SIS_data .= ",Rubro='".$Rubro."'";}
				if(isset($idOpcionesTel) && $idOpcionesTel!=''){                                 $SIS_data .= ",idOpcionesTel='".$idOpcionesTel."'";}
				if(isset($idConfigRam) && $idConfigRam!=''){                                     $SIS_data .= ",idConfigRam='".$idConfigRam."'";}
				if(isset($idConfigTime) && $idConfigTime!=''){                                   $SIS_data .= ",idConfigTime='".$idConfigTime."'";}
				if(isset($idEstado) && $idEstado!=''){                                           $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($CrossTech_DiasTempMin) && $CrossTech_DiasTempMin!=''){                 $SIS_data .= ",CrossTech_DiasTempMin='".$CrossTech_DiasTempMin."'";}
				if(isset($CrossTech_TempMin) && $CrossTech_TempMin!=''){                         $SIS_data .= ",CrossTech_TempMin='".$CrossTech_TempMin."'";}
				if(isset($CrossTech_TempMax) && $CrossTech_TempMax!=''){                         $SIS_data .= ",CrossTech_TempMax='".$CrossTech_TempMax."'";}
				if(isset($CrossTech_FechaDiasTempMin) && $CrossTech_FechaDiasTempMin!=''){       $SIS_data .= ",CrossTech_FechaDiasTempMin='".$CrossTech_FechaDiasTempMin."'";}
				if(isset($CrossTech_FechaTempMin) && $CrossTech_FechaTempMin!=''){               $SIS_data .= ",CrossTech_FechaTempMin='".$CrossTech_FechaTempMin."'";}
				if(isset($CrossTech_FechaTempMax) && $CrossTech_FechaTempMax!=''){               $SIS_data .= ",CrossTech_FechaTempMax='".$CrossTech_FechaTempMax."'";}
				if(isset($CrossTech_FechaUnidadFrio) && $CrossTech_FechaUnidadFrio!=''){         $SIS_data .= ",CrossTech_FechaUnidadFrio='".$CrossTech_FechaUnidadFrio."'";}
				if(isset($CrossTech_HoraPrevRev) && $CrossTech_HoraPrevRev!=''){                 $SIS_data .= ",CrossTech_HoraPrevRev='".$CrossTech_HoraPrevRev."'";}
				if(isset($CrossTech_HoraPrevision) && $CrossTech_HoraPrevision!=''){             $SIS_data .= ",CrossTech_HoraPrevision='".$CrossTech_HoraPrevision."'";}
				if(isset($CrossTech_HoraPrevCuenta) && $CrossTech_HoraPrevCuenta!=''){           $SIS_data .= ",CrossTech_HoraPrevCuenta='".$CrossTech_HoraPrevCuenta."'";}
				if(isset($CrossTech_HeladaTemp) && $CrossTech_HeladaTemp!=''){                   $SIS_data .= ",CrossTech_HeladaTemp='".$CrossTech_HeladaTemp."'";}
				if(isset($CrossTech_HeladaMailHoraIni) && $CrossTech_HeladaMailHoraIni!=''){     $SIS_data .= ",CrossTech_HeladaMailHoraIni='".$CrossTech_HeladaMailHoraIni."'";}
				if(isset($CrossTech_HeladaMailHoraTerm) && $CrossTech_HeladaMailHoraTerm!=''){   $SIS_data .= ",CrossTech_HeladaMailHoraTerm='".$CrossTech_HeladaMailHoraTerm."'";}
				if(isset($Social_idUso) && $Social_idUso!=''){                                   $SIS_data .= ",Social_idUso='".$Social_idUso."'";}
				if(isset($Social_facebook) ){                                                    $SIS_data .= ",Social_facebook='".$Social_facebook."'";}
				if(isset($Social_twitter) ){                                                     $SIS_data .= ",Social_twitter='".$Social_twitter."'";}
				if(isset($Social_instagram) ){                                                   $SIS_data .= ",Social_instagram='".$Social_instagram."'";}
				if(isset($Social_linkedin) ){                                                    $SIS_data .= ",Social_linkedin='".$Social_linkedin."'";}
				if(isset($Social_rss) ){                                                         $SIS_data .= ",Social_rss='".$Social_rss."'";}
				if(isset($Social_youtube) ){                                                     $SIS_data .= ",Social_youtube='".$Social_youtube."'";}
				if(isset($Social_tumblr) ){                                                      $SIS_data .= ",Social_tumblr='".$Social_tumblr."'";}
				if(isset($CrossEnergy_PeriodoInicio) && $CrossEnergy_PeriodoInicio!=''){         $SIS_data .= ",CrossEnergy_PeriodoInicio='".$CrossEnergy_PeriodoInicio."'";}
				if(isset($CrossEnergy_PeriodoTermino) && $CrossEnergy_PeriodoTermino!=''){       $SIS_data .= ",CrossEnergy_PeriodoTermino='".$CrossEnergy_PeriodoTermino."'";}
				if(isset($CrossEnergy_HorarioInicio) && $CrossEnergy_HorarioInicio!=''){         $SIS_data .= ",CrossEnergy_HorarioInicio='".$CrossEnergy_HorarioInicio."'";}
				if(isset($CrossEnergy_HorarioTermino) && $CrossEnergy_HorarioTermino!=''){       $SIS_data .= ",CrossEnergy_HorarioTermino='".$CrossEnergy_HorarioTermino."'";}
				if(isset($RepresentanteNombre) && $RepresentanteNombre!=''){                     $SIS_data .= ",RepresentanteNombre='".$RepresentanteNombre."'";}
				if(isset($RepresentanteRut) && $RepresentanteRut!=''){                           $SIS_data .= ",RepresentanteRut='".$RepresentanteRut."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'core_sistemas','idSistema = "'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//Si se ejecuta correctamente se actualizan los datos
					if(isset($Social_idUso) ){      $_SESSION['usuario']['basic_data']['Social_idUso'] = $Social_idUso;}
					if(isset($Social_facebook) ){   $_SESSION['usuario']['basic_data']['Social_facebook'] = $Social_facebook;}
					if(isset($Social_twitter) ){    $_SESSION['usuario']['basic_data']['Social_twitter'] = $Social_twitter;}
					if(isset($Social_instagram) ){  $_SESSION['usuario']['basic_data']['Social_instagram'] = $Social_instagram;}
					if(isset($Social_linkedin) ){   $_SESSION['usuario']['basic_data']['Social_linkedin'] = $Social_linkedin;}
					if(isset($Social_rss) ){        $_SESSION['usuario']['basic_data']['Social_rss'] = $Social_rss;}
					if(isset($Social_youtube) ){    $_SESSION['usuario']['basic_data']['Social_youtube'] = $Social_youtube;}
					if(isset($Social_tumblr) ){     $_SESSION['usuario']['basic_data']['Social_tumblr'] = $Social_tumblr;}

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
				$rowData = db_select_data (false, 'Config_imgLogo', 'core_sistemas','', 'idSistema = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'core_sistemas','idSistema = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowData['Config_imgLogo'])&&$rowData['Config_imgLogo']!=''){
						try {
							if(!is_writable('upload/'.$rowData['Config_imgLogo'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['Config_imgLogo']);
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

			if ($_FILES["Config_imgLogo"]["error"] > 0){
				$error['Config_imgLogo'] = 'error/'.uploadPHPError($_FILES["Config_imgLogo"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'logos_';

				if (in_array($_FILES['Config_imgLogo']['type'], $permitidos) && $_FILES['Config_imgLogo']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Config_imgLogo']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						//$move_result = @move_uploaded_file($_FILES["Config_imgLogo"]["tmp_name"], $ruta);
						//Muevo el archivo
						$move_result = @move_uploaded_file($_FILES["Config_imgLogo"]["tmp_name"], "upload/xxxsxx_".$_FILES['Config_imgLogo']['name']);

						if ($move_result){
							//se selecciona la imagen
							switch ($_FILES['Config_imgLogo']['type']) {
								case 'image/jpg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Config_imgLogo']['name']);
									break;
								case 'image/jpeg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Config_imgLogo']['name']);
									break;
								case 'image/gif':
									$imgBase = imagecreatefromgif('upload/xxxsxx_'.$_FILES['Config_imgLogo']['name']);
									break;
								case 'image/png':
									$imgBase = imagecreatefrompng('upload/xxxsxx_'.$_FILES['Config_imgLogo']['name']);
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
								if(!is_writable('upload/xxxsxx_'.$_FILES['Config_imgLogo']['name'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/xxxsxx_'.$_FILES['Config_imgLogo']['name']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
							//se eliminan las imagenes de la memoria
							imagedestroy($imgBase);

							//Filtro para idSistema
							if (!empty($_POST['idSistema']))    $idSistema       = $_POST['idSistema'];

							$SIS_data = "Config_imgLogo='".$sufijo.$_FILES['Config_imgLogo']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'core_sistemas','idSistema = "'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								//redirijo
								header( 'Location: '.$location.'&img_id='.$idSistema );
								die;

							}

						} else {
							$error['Config_imgLogo']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Config_imgLogo']       = 'error/El archivo '.$_FILES['Config_imgLogo']['name'].' ya existe';
					}
				} else {
					$error['Config_imgLogo']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre de la imagen
			$rowData = db_select_data (false, 'Config_imgLogo', 'core_sistemas','', 'idSistema = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Config_imgLogo=''";
			$resultado = db_update_data (false, $SIS_data, 'core_sistemas','idSistema = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['Config_imgLogo'])&&$rowData['Config_imgLogo']!=''){
					try {
						if(!is_writable('upload/'.$rowData['Config_imgLogo'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['Config_imgLogo']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&img_id='.$_GET['del_img'] );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'update_theme':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$idSistema       = $_GET['idSistema'];
			$Config_idTheme  = $_GET['idTheme'];

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idSistema='".$idSistema."'";
				if(isset($Config_idTheme) && $Config_idTheme!=''){    $SIS_data .= ",Config_idTheme='".$Config_idTheme."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'core_sistemas','idSistema = "'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Seteo la variable de sesion si existe
					if(isset($_SESSION['usuario']['basic_data']['Config_idTheme'])){
						$_SESSION['usuario']['basic_data']['Config_idTheme'] = $Config_idTheme;
					}
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'sis_prod_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$id_sistema   = $_GET['id'];
			$idProducto   = $_GET['sis_prod_add'];

			//filtros
			if(isset($id_sistema) && $id_sistema!=''){   $SIS_data  = "'".$id_sistema."'";   }else{$SIS_data  = "''";}
			if(isset($idProducto) && $idProducto!=''){   $SIS_data .= ",'".$idProducto."'";  }else{$SIS_data .= ",''";}

			// inserto los datos de registro en la db
			$SIS_columns = 'idSistema, idProducto';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_sistemas_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'sis_prod_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['sis_prod_del']) OR !validaEntero($_GET['sis_prod_del']))&&$_GET['sis_prod_del']!=''){
				$indice = simpleDecode($_GET['sis_prod_del'], fecha_actual());
			}else{
				$indice = $_GET['sis_prod_del'];
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
				$resultado = db_delete_data (false, 'core_sistemas_productos', 'idSisProd = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'sis_ins_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$id_sistema   = $_GET['id'];
			$idProducto   = $_GET['sis_ins_add'];

			//filtros
			if(isset($id_sistema) && $id_sistema!=''){   $SIS_data  = "'".$id_sistema."'";   }else{$SIS_data  = "''";}
			if(isset($idProducto) && $idProducto!=''){   $SIS_data .= ",'".$idProducto."'";  }else{$SIS_data .= ",''";}

			// inserto los datos de registro en la db
			$SIS_columns = 'idSistema, idProducto';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_sistemas_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'sis_ins_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['sis_ins_del']) OR !validaEntero($_GET['sis_ins_del']))&&$_GET['sis_ins_del']!=''){
				$indice = simpleDecode($_GET['sis_ins_del'], fecha_actual());
			}else{
				$indice = $_GET['sis_ins_del'];
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
				$resultado = db_delete_data (false, 'core_sistemas_insumos', 'idSisProd = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'sis_especie_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$id_sistema   = $_GET['id'];
			$idCategoria   = $_GET['sis_especie_add'];

			//filtros
			if(isset($id_sistema) && $id_sistema!=''){   $SIS_data  = "'".$id_sistema."'";   }else{$SIS_data  = "''";}
			if(isset($idCategoria) && $idCategoria!=''){ $SIS_data .= ",'".$idCategoria."'"; }else{$SIS_data .= ",''";}

			// inserto los datos de registro en la db
			$SIS_columns = 'idSistema, idCategoria';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_sistemas_variedades_categorias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'sis_especie_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['sis_especie_del']) OR !validaEntero($_GET['sis_especie_del']))&&$_GET['sis_especie_del']!=''){
				$indice = simpleDecode($_GET['sis_especie_del'], fecha_actual());
			}else{
				$indice = $_GET['sis_especie_del'];
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
				/**************************/
				//Listado de productos
				$SIS_query = '
				variedades_listado.idProducto,
				(SELECT COUNT(idSisProd) FROM core_sistemas_variedades_listado WHERE idProducto = variedades_listado.idProducto AND idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' LIMIT 1) AS contar,
				(SELECT idSisProd FROM core_sistemas_variedades_listado WHERE idProducto = variedades_listado.idProducto AND idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' LIMIT 1) AS idpermiso';
				$SIS_join  = 'LEFT JOIN `variedades_listado` ON variedades_listado.idCategoria = core_sistemas_variedades_categorias.idCategoria';
				$SIS_where = 'core_sistemas_variedades_categorias.idSisProd = '.$indice.' AND variedades_listado.idEstado = 1';
				$SIS_order = 'core_sistemas_variedades_categorias.idSisProd ASC';
				$arrProductos = array();
				$arrProductos = db_select_array (false, $SIS_query, 'core_sistemas_variedades_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**************************/
				//elimino los productos relacionados a la categoria
				foreach ($arrProductos as $productos) {
					if ( isset($productos['contar'])&&$productos['contar']!='0' ) {
						$resultado = db_delete_data (false, 'core_sistemas_variedades_listado', 'idSisProd = "'.$productos['idpermiso'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					}
				}

				/**************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'core_sistemas_variedades_categorias', 'idSisProd = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;

/*******************************************************************************************************************/
		//Agrega un permiso al usuario
		case 'sis_variedad_add':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$id_sistema   = $_GET['id'];
			$idProducto   = $_GET['sis_variedad_add'];

			//filtros
			if(isset($id_sistema) && $id_sistema!=''){   $SIS_data  = "'".$id_sistema."'";   }else{$SIS_data  ="''";}
			if(isset($idProducto) && $idProducto!=''){   $SIS_data .= ",'".$idProducto."'";  }else{$SIS_data .=",''";}

			// inserto los datos de registro en la db
			$SIS_columns = 'idSistema, idProducto';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_sistemas_variedades_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		//borra un permiso del usuario
		case 'sis_variedad_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['sis_variedad_del']) OR !validaEntero($_GET['sis_variedad_del']))&&$_GET['sis_variedad_del']!=''){
				$indice = simpleDecode($_GET['sis_variedad_del'], fecha_actual());
			}else{
				$indice = $_GET['sis_variedad_del'];
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
				$resultado = db_delete_data (false, 'core_sistemas_variedades_listado', 'idSisProd = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
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

			$idSistema  = $_GET['id'];
			$idEstado   = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'core_sistemas','idSistema = "'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'updateCrossTech':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idSistema='".$idSistema."'";
				if(isset($CrossTech_DiasTempMin) && $CrossTech_DiasTempMin!=''){                 $SIS_data .= ",CrossTech_DiasTempMin='".$CrossTech_DiasTempMin."'";}
				if(isset($CrossTech_TempMin) && $CrossTech_TempMin!=''){                         $SIS_data .= ",CrossTech_TempMin='".$CrossTech_TempMin."'";}
				if(isset($CrossTech_TempMax) && $CrossTech_TempMax!=''){                         $SIS_data .= ",CrossTech_TempMax='".$CrossTech_TempMax."'";}
				if(isset($CrossTech_HoraPrevRev) && $CrossTech_HoraPrevRev!=''){                 $SIS_data .= ",CrossTech_HoraPrevRev='".$CrossTech_HoraPrevRev."'";}
				if(isset($CrossTech_HoraPrevision) && $CrossTech_HoraPrevision!=''){             $SIS_data .= ",CrossTech_HoraPrevision='".$CrossTech_HoraPrevision."'";}
				if(isset($CrossTech_HoraPrevCuenta) && $CrossTech_HoraPrevCuenta!=''){           $SIS_data .= ",CrossTech_HoraPrevCuenta='".$CrossTech_HoraPrevCuenta."'";}
				if(isset($CrossTech_HeladaTemp) && $CrossTech_HeladaTemp!=''){                   $SIS_data .= ",CrossTech_HeladaTemp='".$CrossTech_HeladaTemp."'";}
				if(isset($CrossTech_HeladaMailHoraIni) && $CrossTech_HeladaMailHoraIni!=''){     $SIS_data .= ",CrossTech_HeladaMailHoraIni='".$CrossTech_HeladaMailHoraIni."'";}
				if(isset($CrossTech_HeladaMailHoraTerm) && $CrossTech_HeladaMailHoraTerm!=''){   $SIS_data .= ",CrossTech_HeladaMailHoraTerm='".$CrossTech_HeladaMailHoraTerm."'";}

				if(isset($CrossTech_FechaDiasTempMin) && $CrossTech_FechaDiasTempMin != ''&&isset($CrossTech_FechaDiasTempMinOld) && $CrossTech_FechaDiasTempMinOld != ''&&$CrossTech_FechaDiasTempMin != $CrossTech_FechaDiasTempMinOld ){
					$SIS_data .= ",CrossTech_FechaDiasTempMin='".$CrossTech_FechaDiasTempMin."'";
				}
				if(isset($CrossTech_FechaTempMin) && $CrossTech_FechaTempMin != ''&&isset($CrossTech_FechaTempMinOld) && $CrossTech_FechaTempMinOld != ''&&$CrossTech_FechaTempMin != $CrossTech_FechaTempMinOld ){
					$SIS_data .= ",CrossTech_FechaTempMin='".$CrossTech_FechaTempMin."'";
				}
				if(isset($CrossTech_FechaTempMax) && $CrossTech_FechaTempMax != ''&&isset($CrossTech_FechaTempMaxOld) && $CrossTech_FechaTempMaxOld != ''&&$CrossTech_FechaTempMax != $CrossTech_FechaTempMaxOld){
					$SIS_data .= ",CrossTech_FechaTempMax='".$CrossTech_FechaTempMax."'";
				}
				if(isset($CrossTech_FechaUnidadFrio) && $CrossTech_FechaUnidadFrio != ''&&isset($CrossTech_FechaUnidadFrioOld) && $CrossTech_FechaUnidadFrioOld != ''&&$CrossTech_FechaUnidadFrio != $CrossTech_FechaUnidadFrioOld){
					$SIS_data .= ",CrossTech_FechaUnidadFrio='".$CrossTech_FechaUnidadFrio."'";
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'core_sistemas','idSistema = "'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/*************************************************************/
					//se trae el ultimo registro
					$rowAux = db_select_data (false, 'idAuxiliar', 'telemetria_listado_aux', '', 'idSistema = "'.$idSistema.'" ORDER BY idAuxiliar DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*************************************************************/
					//se actualizael dato si existe registro
					if(isset($rowAux['idAuxiliar'])&&$rowAux['idAuxiliar']!=''){
						$SIS_data = "idAuxiliar='".$rowAux['idAuxiliar']."'";
						if(isset($CrossTech_DiasTempMin) && $CrossTech_DiasTempMin!=''){     $SIS_data .= ",CrossTech_DiasTempMin='".$CrossTech_DiasTempMin."'";}
						if(isset($CrossTech_TempMin) && $CrossTech_TempMin!=''){             $SIS_data .= ",CrossTech_TempMin='".$CrossTech_TempMin."'";}
						if(isset($CrossTech_TempMax) && $CrossTech_TempMax!=''){             $SIS_data .= ",CrossTech_TempMax='".$CrossTech_TempMax."'";}
						if(isset($CrossTech_FechaDiasTempMin) && $CrossTech_FechaDiasTempMin != ''&&isset($CrossTech_FechaDiasTempMinOld) && $CrossTech_FechaDiasTempMinOld != ''&&$CrossTech_FechaDiasTempMin != $CrossTech_FechaDiasTempMinOld ){
							$SIS_data .= ",CrossTech_FechaDiasTempMin='".$CrossTech_FechaDiasTempMin."'";
							$SIS_data .= ",Dias_acumulado='0'";
						}
						if(isset($CrossTech_FechaTempMin) && $CrossTech_FechaTempMin != ''&&isset($CrossTech_FechaTempMinOld) && $CrossTech_FechaTempMinOld != ''&&$CrossTech_FechaTempMin != $CrossTech_FechaTempMinOld ){
							$SIS_data .= ",CrossTech_FechaTempMin='".$CrossTech_FechaTempMin."'";
							$SIS_data .= ",HorasBajoGrados='0'";
						}
						if(isset($CrossTech_FechaTempMax) && $CrossTech_FechaTempMax != ''&&isset($CrossTech_FechaTempMaxOld) && $CrossTech_FechaTempMaxOld != ''&&$CrossTech_FechaTempMax != $CrossTech_FechaTempMaxOld){
							$SIS_data .= ",CrossTech_FechaTempMax='".$CrossTech_FechaTempMax."'";
							$SIS_data .= ",HorasSobreGrados='0'";
						}
						if(isset($CrossTech_FechaUnidadFrio) && $CrossTech_FechaUnidadFrio != ''&&isset($CrossTech_FechaUnidadFrioOld) && $CrossTech_FechaUnidadFrioOld != ''&&$CrossTech_FechaUnidadFrio != $CrossTech_FechaUnidadFrioOld){
							$SIS_data .= ",CrossTech_FechaUnidadFrio='".$CrossTech_FechaUnidadFrio."'";
							$SIS_data .= ",UnidadesFrio='0'";
						}

						/*******************************************************/
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_aux', 'idAuxiliar = "'.$rowAux['idAuxiliar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//redirijo
						header( 'Location: '.$location.'&edited=true' );
						die;
					//se crea el dato en caso de no existir
					}else{

						//Variables
						$HoraSistema    = hora_actual();
						$FechaSistema   = fecha_actual();
						$TimeStamp      = fecha_actual().' '.hora_actual();

						//filtros
						$SIS_data  = "'".$idSistema."'";
						$SIS_data .= ",'".$FechaSistema."'";
						$SIS_data .= ",'".$HoraSistema."'";
						$SIS_data .= ",'".$TimeStamp."'";
						if(isset($CrossTech_DiasTempMin) && $CrossTech_DiasTempMin!=''){               $SIS_data .= ",'".$CrossTech_DiasTempMin."'";       }else{$SIS_data .= ",''";}
						if(isset($CrossTech_TempMin) && $CrossTech_TempMin!=''){                       $SIS_data .= ",'".$CrossTech_TempMin."'";           }else{$SIS_data .= ",''";}
						if(isset($CrossTech_TempMax) && $CrossTech_TempMax!=''){                       $SIS_data .= ",'".$CrossTech_TempMax."'";           }else{$SIS_data .= ",''";}
						if(isset($CrossTech_FechaDiasTempMin) && $CrossTech_FechaDiasTempMin!=''){     $SIS_data .= ",'".$CrossTech_FechaDiasTempMin."'";  }else{$SIS_data .= ",''";}
						if(isset($CrossTech_FechaTempMin) && $CrossTech_FechaTempMin!=''){             $SIS_data .= ",'".$CrossTech_FechaTempMin."'";      }else{$SIS_data .= ",''";}
						if(isset($CrossTech_FechaTempMax) && $CrossTech_FechaTempMax!=''){             $SIS_data .= ",'".$CrossTech_FechaTempMax."'";      }else{$SIS_data .= ",''";}
						if(isset($CrossTech_FechaUnidadFrio) && $CrossTech_FechaUnidadFrio!=''){       $SIS_data .= ",'".$CrossTech_FechaUnidadFrio."'";   }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idSistema, Fecha, Hora, TimeStamp,
						CrossTech_DiasTempMin, CrossTech_TempMin, CrossTech_TempMax, CrossTech_FechaDiasTempMin,
						CrossTech_FechaTempMin, CrossTech_FechaTempMax, CrossTech_FechaUnidadFrio';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_aux', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Si ejecuto correctamente la consulta
						if($ultimo_id!=0){
							//redirijo
							header( 'Location: '.$location.'&edited=true' );
							die;
						}

					}
				}
			}

		break;

/*******************************************************************************************************************/
	}

?>
