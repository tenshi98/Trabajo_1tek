<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-160).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idSitio']))                    $idSitio                    = $_POST['idSitio'];
	if (!empty($_POST['idSistema']))                  $idSistema                  = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))                   $idEstado                   = $_POST['idEstado'];
	if ( isset($_POST['Nombre']))                     $Nombre                     = $_POST['Nombre'];
	if ( isset($_POST['Domain']))                     $Domain                     = $_POST['Domain'];
	if ( isset($_POST['Whatsapp_number_1']))          $Whatsapp_number_1          = $_POST['Whatsapp_number_1'];
	if ( isset($_POST['Whatsapp_number_2']))          $Whatsapp_number_2          = $_POST['Whatsapp_number_2'];
	if ( isset($_POST['Whatsapp_tittle']))            $Whatsapp_tittle            = $_POST['Whatsapp_tittle'];
	if ( isset($_POST['Header_Titulo']))              $Header_Titulo              = $_POST['Header_Titulo'];
	if ( isset($_POST['Header_TituloStyle']))         $Header_TituloStyle         = $_POST['Header_TituloStyle'];
	if ( isset($_POST['Header_Texto']))               $Header_Texto               = $_POST['Header_Texto'];
	if ( isset($_POST['Header_TextoStyle']))          $Header_TextoStyle          = $_POST['Header_TextoStyle'];
	if ( isset($_POST['Header_LinkNombre']))          $Header_LinkNombre          = $_POST['Header_LinkNombre'];
	if ( isset($_POST['Header_LinkStyle']))           $Header_LinkStyle           = $_POST['Header_LinkStyle'];
	if ( isset($_POST['Header_LinkURL']))             $Header_LinkURL             = $_POST['Header_LinkURL'];
	if ( isset($_POST['Header_idNewTab']))            $Header_idNewTab            = $_POST['Header_idNewTab'];
	if ( isset($_POST['Header_idPopup']))             $Header_idPopup             = $_POST['Header_idPopup'];
	if ( isset($_POST['Contact_Tittle']))             $Contact_Tittle             = $_POST['Contact_Tittle'];
	if ( isset($_POST['Contact_Tittle_body']))        $Contact_Tittle_body        = $_POST['Contact_Tittle_body'];
	if ( isset($_POST['Contact_Address_tittle']))     $Contact_Address_tittle     = $_POST['Contact_Address_tittle'];
	if ( isset($_POST['Contact_Address_body']))       $Contact_Address_body       = $_POST['Contact_Address_body'];
	if ( isset($_POST['Contact_Email_tittle']))       $Contact_Email_tittle       = $_POST['Contact_Email_tittle'];
	if ( isset($_POST['Contact_Email_body']))         $Contact_Email_body         = $_POST['Contact_Email_body'];
	if ( isset($_POST['Contact_Phone_tittle']))       $Contact_Phone_tittle       = $_POST['Contact_Phone_tittle'];
	if ( isset($_POST['Contact_Phone_body']))         $Contact_Phone_body         = $_POST['Contact_Phone_body'];
	if ( isset($_POST['Contact_Recep_asunto']))       $Contact_Recep_asunto       = $_POST['Contact_Recep_asunto'];
	if ( isset($_POST['Contact_Recep_mail']))         $Contact_Recep_mail         = $_POST['Contact_Recep_mail'];
	if ( isset($_POST['Contact_Recep_name']))         $Contact_Recep_name         = $_POST['Contact_Recep_name'];
	if ( isset($_POST['Social_Tittle']))              $Social_Tittle              = $_POST['Social_Tittle'];
	if ( isset($_POST['Social_Twitter']))             $Social_Twitter             = $_POST['Social_Twitter'];
	if ( isset($_POST['Social_Facebook']))            $Social_Facebook            = $_POST['Social_Facebook'];
	if ( isset($_POST['Social_Instagram']))           $Social_Instagram           = $_POST['Social_Instagram'];
	if ( isset($_POST['Social_Googleplus']))          $Social_Googleplus          = $_POST['Social_Googleplus'];
	if ( isset($_POST['Social_Linkedin']))            $Social_Linkedin            = $_POST['Social_Linkedin'];
	if ( isset($_POST['Config_Logo_Nombre']))         $Config_Logo_Nombre         = $_POST['Config_Logo_Nombre'];
	if ( isset($_POST['Config_Logo_Archivo']))        $Config_Logo_Archivo        = $_POST['Config_Logo_Archivo'];
	if ( isset($_POST['Config_Root_Folder']))         $Config_Root_Folder         = $_POST['Config_Root_Folder'];
	if ( isset($_POST['Config_Menu']))                $Config_Menu                = $_POST['Config_Menu'];
	if ( isset($_POST['Config_MenuOtros']))           $Config_MenuOtros           = $_POST['Config_MenuOtros'];
	if ( isset($_POST['Config_Carousel']))            $Config_Carousel            = $_POST['Config_Carousel'];
	if ( isset($_POST['Config_Links_Rel']))           $Config_Links_Rel           = $_POST['Config_Links_Rel'];
	if ( isset($_POST['Config_Top_Bar']))             $Config_Top_Bar             = $_POST['Config_Top_Bar'];
	if ( isset($_POST['Config_Footer_Links']))        $Config_Footer_Links        = $_POST['Config_Footer_Links'];
	if ( isset($_POST['Config_Footer_Services']))     $Config_Footer_Services     = $_POST['Config_Footer_Services'];
	if ( isset($_POST['Config_Footer_Letters']))      $Config_Footer_Letters      = $_POST['Config_Footer_Letters'];
	if ( isset($_POST['Config_SMTP_mailUsername']))   $Config_SMTP_mailUsername   = $_POST['Config_SMTP_mailUsername'];
	if ( isset($_POST['Config_SMTP_mailPassword']))   $Config_SMTP_mailPassword   = $_POST['Config_SMTP_mailPassword'];
	if ( isset($_POST['Config_SMTP_Host']))           $Config_SMTP_Host           = $_POST['Config_SMTP_Host'];
	if ( isset($_POST['Config_SMTP_Port']))           $Config_SMTP_Port           = $_POST['Config_SMTP_Port'];
	if ( isset($_POST['Config_SMTP_Secure']))         $Config_SMTP_Secure         = $_POST['Config_SMTP_Secure'];
	if ( isset($_POST['Nosotros_Titulo']))            $Nosotros_Titulo            = $_POST['Nosotros_Titulo'];
	if ( isset($_POST['Nosotros_Subtitulo']))         $Nosotros_Subtitulo         = $_POST['Nosotros_Subtitulo'];
	if ( isset($_POST['Nosotros_Texto']))             $Nosotros_Texto             = $_POST['Nosotros_Texto'];
	if ( isset($_POST['Nosotros_Link']))              $Nosotros_Link              = $_POST['Nosotros_Link'];

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
			case 'idSitio':                  if(empty($idSitio)){                    $error['idSitio']                    = 'error/No ha ingresado el id';}break;
			case 'idSistema':                if(empty($idSistema)){                  $error['idSistema']                  = 'error/No ha seleccionado el sistema al cual pertenece';}break;
			case 'idEstado':                 if(empty($idEstado)){                   $error['idEstado']                   = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':                   if(empty($Nombre)){                     $error['Nombre']                     = 'error/No ha ingresado el nombre del sitio';}break;
			case 'Domain':                   if(empty($Domain)){                     $error['Domain']                     = 'error/No ha ingresado el dominio del sitio';}break;
			case 'Whatsapp_number_1':        if(empty($Whatsapp_number_1)){          $error['Whatsapp_number_1']          = 'error/No ha ingresado el numero de whatsapp';}break;
			case 'Whatsapp_number_2':        if(empty($Whatsapp_number_2)){          $error['Whatsapp_number_2']          = 'error/No ha ingresado el numero de whatsapp';}break;
			case 'Whatsapp_tittle':          if(empty($Whatsapp_tittle)){            $error['Whatsapp_tittle']            = 'error/No ha ingresado el titulo del mensaje de whatsapp';}break;
			case 'Header_Titulo':            if(empty($Header_Titulo)){              $error['Header_Titulo']              = 'error/No ha ingresado el titulo del header';}break;
			case 'Header_TituloStyle':       if(empty($Header_TituloStyle)){         $error['Header_TituloStyle']         = 'error/No ha ingresado el estilo del titulo del header';}break;
			case 'Header_Texto':             if(empty($Header_Texto)){               $error['Header_Texto']               = 'error/No ha ingresado el texto del header';}break;
			case 'Header_TextoStyle':        if(empty($Header_TextoStyle)){          $error['Header_TextoStyle']          = 'error/No ha ingresado el estilo del texto del header';}break;
			case 'Header_LinkNombre':        if(empty($Header_LinkNombre)){          $error['Header_LinkNombre']          = 'error/No ha ingresado el enlace del header';}break;
			case 'Header_LinkStyle':         if(empty($Header_LinkStyle)){           $error['Header_LinkStyle']           = 'error/No ha ingresado el estilo del enlace del header';}break;
			case 'Header_LinkURL':           if(empty($Header_LinkURL)){             $error['Header_LinkURL']             = 'error/No ha ingresado la URL del enlace del header';}break;
			case 'Header_idNewTab':          if(empty($Header_idNewTab)){            $error['Header_idNewTab']            = 'error/No ha seleccionado si el enlace se abre en una nueva pestaña';}break;
			case 'Header_idPopup':           if(empty($Header_idPopup)){             $error['Header_idPopup']             = 'error/No ha seleccionado si el enlace se abre en un popup';}break;
			case 'Contact_Tittle':           if(empty($Contact_Tittle)){             $error['Contact_Tittle']             = 'error/No ha ingresado el titulo del header';}break;
			case 'Contact_Tittle_body':      if(empty($Contact_Tittle_body)){        $error['Contact_Tittle_body']        = 'error/No ha ingresado el texto del titulo del bloque de contacto';}break;
			case 'Contact_Address_tittle':   if(empty($Contact_Address_tittle)){     $error['Contact_Address_tittle']     = 'error/No ha ingresado el titulo de la dirección';}break;
			case 'Contact_Address_body':     if(empty($Contact_Address_body)){       $error['Contact_Address_body']       = 'error/No ha ingresado el cuerpo de la dirección';}break;
			case 'Contact_Email_tittle':     if(empty($Contact_Email_tittle)){       $error['Contact_Email_tittle']       = 'error/No ha ingresado el titulo del email';}break;
			case 'Contact_Email_body':       if(empty($Contact_Email_body)){         $error['Contact_Email_body']         = 'error/No ha ingresado el cuerpo del email';}break;
			case 'Contact_Phone_tittle':     if(empty($Contact_Phone_tittle)){       $error['Contact_Phone_tittle']       = 'error/No ha ingresado el titulo del telefono';}break;
			case 'Contact_Phone_body':       if(empty($Contact_Phone_body)){         $error['Contact_Phone_body']         = 'error/No ha ingresado el cuerpo del telefono';}break;
			case 'Contact_Recep_asunto':     if(empty($Contact_Recep_asunto)){       $error['Contact_Recep_asunto']       = 'error/No ha ingresado el asunto del receptor';}break;
			case 'Contact_Recep_mail':       if(empty($Contact_Recep_mail)){         $error['Contact_Recep_mail']         = 'error/No ha ingresado el email del receptor';}break;
			case 'Contact_Recep_name':       if(empty($Contact_Recep_name)){         $error['Contact_Recep_name']         = 'error/No ha ingresado el nombre del receptor';}break;
			case 'Social_Tittle':            if(empty($Social_Tittle)){              $error['Social_Tittle']              = 'error/No ha ingresado el titulo del bloque social';}break;
			case 'Social_Twitter':           if(empty($Social_Twitter)){             $error['Social_Twitter']             = 'error/No ha ingresado la dirección de Twitter';}break;
			case 'Social_Facebook':          if(empty($Social_Facebook)){            $error['Social_Facebook']            = 'error/No ha ingresado la dirección de Facebook';}break;
			case 'Social_Instagram':         if(empty($Social_Instagram)){           $error['Social_Instagram']           = 'error/No ha ingresado la dirección de Instagram';}break;
			case 'Social_Googleplus':        if(empty($Social_Googleplus)){          $error['Social_Googleplus']          = 'error/No ha ingresado la dirección de Googleplus';}break;
			case 'Social_Linkedin':          if(empty($Social_Linkedin)){            $error['Social_Linkedin']            = 'error/No ha ingresado la dirección de Linkedin';}break;
			case 'Config_Logo_Nombre':       if(empty($Config_Logo_Nombre)){         $error['Config_Logo_Nombre']         = 'error/No ha ingresado la opción del nombre del logo';}break;
			case 'Config_Logo_Archivo':      if(empty($Config_Logo_Archivo)){        $error['Config_Logo_Archivo']        = 'error/No ha ingresado la opción del nombre del archivo del logo';}break;
			case 'Config_Root_Folder':       if(empty($Config_Root_Folder)){         $error['Config_Root_Folder']         = 'error/No ha ingresado la opción del nombre de la carpeta raiz';}break;
			case 'Config_Menu':              if(empty($Config_Menu)){                $error['Config_Menu']                = 'error/No ha seleccionado la opción del menu';}break;
			case 'Config_MenuOtros':         if(empty($Config_MenuOtros)){           $error['Config_MenuOtros']           = 'error/No ha seleccionado la opción de menu otros';}break;
			case 'Config_Carousel':          if(empty($Config_Carousel)){            $error['Config_Carousel']            = 'error/No ha seleccionado la opción de carousel';}break;
			case 'Config_Links_Rel':         if(empty($Config_Links_Rel)){           $error['Config_Links_Rel']           = 'error/No ha seleccionado la opción de links relacionados';}break;
			case 'Config_Top_Bar':           if(empty($Config_Top_Bar)){             $error['Config_Top_Bar']             = 'error/No ha seleccionado la opción de top bar';}break;
			case 'Config_Footer_Links':      if(empty($Config_Footer_Links)){        $error['Config_Footer_Links']        = 'error/No ha seleccionado la opción de visualizacion de enlaces en el footer';}break;
			case 'Config_Footer_Services':   if(empty($Config_Footer_Services)){     $error['Config_Footer_Services']     = 'error/No ha seleccionado la opción de visualizacion de servicios en el footer';}break;
			case 'Config_Footer_Letters':    if(empty($Config_Footer_Letters)){      $error['Config_Footer_Letters']      = 'error/No ha seleccionado la opción de visualizacion de suscripcion en el footer';}break;
			case 'Config_SMTP_mailUsername': if(empty($Config_SMTP_mailUsername)){   $error['Config_SMTP_mailUsername']   = 'error/No ha ingresado el usuario SMTP';}break;
			case 'Config_SMTP_mailPassword': if(empty($Config_SMTP_mailPassword)){   $error['Config_SMTP_mailPassword']   = 'error/No ha ingresado la contraseña del usuario SMTP';}break;
			case 'Config_SMTP_Host':         if(empty($Config_SMTP_Host)){           $error['Config_SMTP_Host']           = 'error/No ha ingresado el host del correo SMTP';}break;
			case 'Config_SMTP_Port':         if(empty($Config_SMTP_Port)){           $error['Config_SMTP_Port']           = 'error/No ha ingresado el puerto del correo SMTP';}break;
			case 'Config_SMTP_Secure':       if(empty($Config_SMTP_Secure)){         $error['Config_SMTP_Secure']         = 'error/No ha ingresado el protocolo de seguridad del correo SMTP';}break;
			case 'Nosotros_Titulo':          if(empty($Nosotros_Titulo)){            $error['Nosotros_Titulo']            = 'error/No ha ingresado el titulo de nosotros';}break;
			case 'Nosotros_Subtitulo':       if(empty($Nosotros_Subtitulo)){         $error['Nosotros_Subtitulo']         = 'error/No ha ingresado el subtitulo de nosotros';}break;
			case 'Nosotros_Texto':           if(empty($Nosotros_Texto)){             $error['Nosotros_Texto']             = 'error/No ha ingresado el texto de nosotros';}break;
			case 'Nosotros_Link':            if(empty($Nosotros_Link)){              $error['Nosotros_Link']              = 'error/No ha ingresado el enlace de nosotros';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                                  $Nombre                 = EstandarizarInput($Nombre);}
	if(isset($Domain) && $Domain!=''){                                  $Domain                 = EstandarizarInput($Domain);}
	if(isset($Whatsapp_number_1) && $Whatsapp_number_1!=''){            $Whatsapp_number_1      = EstandarizarInput($Whatsapp_number_1);}
	if(isset($Whatsapp_number_2) && $Whatsapp_number_2!=''){            $Whatsapp_number_2      = EstandarizarInput($Whatsapp_number_2);}
	if(isset($Whatsapp_tittle) && $Whatsapp_tittle!=''){                $Whatsapp_tittle        = EstandarizarInput($Whatsapp_tittle);}
	if(isset($Contact_Tittle) && $Contact_Tittle!=''){                  $Contact_Tittle         = EstandarizarInput($Contact_Tittle);}
	if(isset($Contact_Tittle_body) && $Contact_Tittle_body!=''){        $Contact_Tittle_body    = EstandarizarInput($Contact_Tittle_body);}
	if(isset($Contact_Address_tittle) && $Contact_Address_tittle!=''){  $Contact_Address_tittle = EstandarizarInput($Contact_Address_tittle);}
	if(isset($Contact_Address_body) && $Contact_Address_body!=''){      $Contact_Address_body   = EstandarizarInput($Contact_Address_body);}
	if(isset($Contact_Email_tittle) && $Contact_Email_tittle!=''){      $Contact_Email_tittle   = EstandarizarInput($Contact_Email_tittle);}
	if(isset($Contact_Email_body) && $Contact_Email_body!=''){          $Contact_Email_body     = EstandarizarInput($Contact_Email_body);}
	if(isset($Contact_Phone_tittle) && $Contact_Phone_tittle!=''){      $Contact_Phone_tittle   = EstandarizarInput($Contact_Phone_tittle);}
	if(isset($Contact_Phone_body) && $Contact_Phone_body!=''){          $Contact_Phone_body     = EstandarizarInput($Contact_Phone_body);}
	if(isset($Contact_Recep_asunto) && $Contact_Recep_asunto!=''){      $Contact_Recep_asunto   = EstandarizarInput($Contact_Recep_asunto);}
	if(isset($Contact_Recep_mail) && $Contact_Recep_mail!=''){          $Contact_Recep_mail     = EstandarizarInput($Contact_Recep_mail);}
	if(isset($Contact_Recep_name) && $Contact_Recep_name!=''){          $Contact_Recep_name     = EstandarizarInput($Contact_Recep_name);}
	if(isset($Social_Tittle) && $Social_Tittle!=''){                    $Social_Tittle          = EstandarizarInput($Social_Tittle);}
	if(isset($Social_Twitter) && $Social_Twitter!=''){                  $Social_Twitter         = EstandarizarInput($Social_Twitter);}
	if(isset($Social_Facebook) && $Social_Facebook!=''){                $Social_Facebook        = EstandarizarInput($Social_Facebook);}
	if(isset($Social_Instagram) && $Social_Instagram!=''){              $Social_Instagram       = EstandarizarInput($Social_Instagram);}
	if(isset($Social_Googleplus) && $Social_Googleplus!=''){            $Social_Googleplus      = EstandarizarInput($Social_Googleplus);}
	if(isset($Social_Linkedin) && $Social_Linkedin!=''){                $Social_Linkedin        = EstandarizarInput($Social_Linkedin);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                                  $error['Nombre']                  = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Domain)&&contar_palabras_censuradas($Domain)!=0){                                  $error['Domain']                  = 'error/Edita Domain, contiene palabras no permitidas';}
	if(isset($Whatsapp_number_1)&&contar_palabras_censuradas($Whatsapp_number_1)!=0){            $error['Whatsapp_number_1']       = 'error/Edita Whatsapp_number_1, contiene palabras no permitidas';}
	if(isset($Whatsapp_number_2)&&contar_palabras_censuradas($Whatsapp_number_2)!=0){            $error['Whatsapp_number_2']       = 'error/Edita Whatsapp_number_2, contiene palabras no permitidas';}
	if(isset($Whatsapp_tittle)&&contar_palabras_censuradas($Whatsapp_tittle)!=0){                $error['Whatsapp_tittle']         = 'error/Edita Whatsapp_tittle, contiene palabras no permitidas';}
	if(isset($Contact_Tittle)&&contar_palabras_censuradas($Contact_Tittle)!=0){                  $error['Contact_Tittle']          = 'error/Edita Contact_Tittle, contiene palabras no permitidas';}
	if(isset($Contact_Tittle_body)&&contar_palabras_censuradas($Contact_Tittle_body)!=0){        $error['Contact_Tittle_body']     = 'error/Edita Contact_Tittle_body, contiene palabras no permitidas';}
	if(isset($Contact_Address_tittle)&&contar_palabras_censuradas($Contact_Address_tittle)!=0){  $error['Contact_Address_tittle']  = 'error/Edita Contact_Address_tittle, contiene palabras no permitidas';}
	if(isset($Contact_Address_body)&&contar_palabras_censuradas($Contact_Address_body)!=0){      $error['Contact_Address_body']    = 'error/Edita Contact_Address_body, contiene palabras no permitidas';}
	if(isset($Contact_Email_tittle)&&contar_palabras_censuradas($Contact_Email_tittle)!=0){      $error['Contact_Email_tittle']    = 'error/Edita Contact_Email_tittle, contiene palabras no permitidas';}
	if(isset($Contact_Email_body)&&contar_palabras_censuradas($Contact_Email_body)!=0){          $error['Contact_Email_body']      = 'error/Edita Contact_Email_body, contiene palabras no permitidas';}
	if(isset($Contact_Phone_tittle)&&contar_palabras_censuradas($Contact_Phone_tittle)!=0){      $error['Contact_Phone_tittle']    = 'error/Edita Contact_Phone_tittle, contiene palabras no permitidas';}
	if(isset($Contact_Phone_body)&&contar_palabras_censuradas($Contact_Phone_body)!=0){          $error['Contact_Phone_body']      = 'error/Edita Contact_Phone_body, contiene palabras no permitidas';}
	if(isset($Contact_Recep_asunto)&&contar_palabras_censuradas($Contact_Recep_asunto)!=0){      $error['Contact_Recep_asunto']    = 'error/Edita Contact_Recep_asunto, contiene palabras no permitidas';}
	if(isset($Contact_Recep_mail)&&contar_palabras_censuradas($Contact_Recep_mail)!=0){          $error['Contact_Recep_mail']      = 'error/Edita Contact_Recep_mail, contiene palabras no permitidas';}
	if(isset($Contact_Recep_name)&&contar_palabras_censuradas($Contact_Recep_name)!=0){          $error['Contact_Recep_name']      = 'error/Edita Contact_Recep_name, contiene palabras no permitidas';}
	if(isset($Social_Tittle)&&contar_palabras_censuradas($Social_Tittle)!=0){                    $error['Social_Tittle']           = 'error/Edita Social_Tittle, contiene palabras no permitidas';}
	if(isset($Social_Twitter)&&contar_palabras_censuradas($Social_Twitter)!=0){                  $error['Social_Twitter']          = 'error/Edita Social_Twitter, contiene palabras no permitidas';}
	if(isset($Social_Facebook)&&contar_palabras_censuradas($Social_Facebook)!=0){                $error['Social_Facebook']         = 'error/Edita Social_Facebook, contiene palabras no permitidas';}
	if(isset($Social_Instagram)&&contar_palabras_censuradas($Social_Instagram)!=0){              $error['Social_Instagram']        = 'error/Edita Social_Instagram, contiene palabras no permitidas';}
	if(isset($Social_Googleplus)&&contar_palabras_censuradas($Social_Googleplus)!=0){            $error['Social_Googleplus']       = 'error/Edita Social_Googleplus, contiene palabras no permitidas';}
	if(isset($Social_Linkedin)&&contar_palabras_censuradas($Social_Linkedin)!=0){                $error['Social_Linkedin']         = 'error/Edita Social_Linkedin, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($Whatsapp_number_1)&&$Whatsapp_number_1!=''&&!validarNumero($Whatsapp_number_1)){  $error['Whatsapp_number_1']    = 'error/Ingrese un número telefónico válido';}
	if(isset($Whatsapp_number_2)&&$Whatsapp_number_2!=''&&!validarNumero($Whatsapp_number_2)){  $error['Whatsapp_number_2']    = 'error/Ingrese un número telefónico válido';}
	if(isset($Whatsapp_number_1)&&palabra_corto($Whatsapp_number_1, 9)!=1){                     $error['Whatsapp_number_1']    = 'error/'.palabra_corto($Whatsapp_number_1, 9);}
	if(isset($Whatsapp_number_2)&&palabra_corto($Whatsapp_number_2, 9)!=1){                     $error['Whatsapp_number_2']    = 'error/'.palabra_corto($Whatsapp_number_2, 9);}

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
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'sitios_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Sitio que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                                  $SIS_data  = "'".$idSistema."'";                       }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                                    $SIS_data .= ",'".$idEstado."'";                       }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                        $SIS_data .= ",'".$Nombre."'";                         }else{$SIS_data .= ",''";}
				if(isset($Domain) && $Domain!=''){                                        $SIS_data .= ",'".$Domain."'";                         }else{$SIS_data .= ",''";}
				if(isset($Whatsapp_number_1) && $Whatsapp_number_1!=''){                  $SIS_data .= ",'".$Whatsapp_number_1."'";              }else{$SIS_data .= ",''";}
				if(isset($Whatsapp_number_2) && $Whatsapp_number_2!=''){                  $SIS_data .= ",'".$Whatsapp_number_2."'";              }else{$SIS_data .= ",''";}
				if(isset($Whatsapp_tittle) && $Whatsapp_tittle!=''){                      $SIS_data .= ",'".$Whatsapp_tittle."'";                }else{$SIS_data .= ",''";}
				if(isset($Header_Titulo) && $Header_Titulo!=''){                          $SIS_data .= ",'".$Header_Titulo."'";                  }else{$SIS_data .= ",''";}
				if(isset($Header_TituloStyle) && $Header_TituloStyle!=''){                $SIS_data .= ",'".$Header_TituloStyle."'";             }else{$SIS_data .= ",''";}
				if(isset($Header_Texto) && $Header_Texto!=''){                            $SIS_data .= ",'".$Header_Texto."'";                   }else{$SIS_data .= ",''";}
				if(isset($Header_TextoStyle) && $Header_TextoStyle!=''){                  $SIS_data .= ",'".$Header_TextoStyle."'";              }else{$SIS_data .= ",''";}
				if(isset($Header_LinkNombre) && $Header_LinkNombre!=''){                  $SIS_data .= ",'".$Header_LinkNombre."'";              }else{$SIS_data .= ",''";}
				if(isset($Header_LinkStyle) && $Header_LinkStyle!=''){                    $SIS_data .= ",'".$Header_LinkStyle."'";               }else{$SIS_data .= ",''";}
				if(isset($Header_LinkURL) && $Header_LinkURL!=''){                        $SIS_data .= ",'".$Header_LinkURL."'";                 }else{$SIS_data .= ",''";}
				if(isset($Header_idNewTab) && $Header_idNewTab!=''){                      $SIS_data .= ",'".$Header_idNewTab."'";                }else{$SIS_data .= ",''";}
				if(isset($Header_idPopup) && $Header_idPopup!=''){                        $SIS_data .= ",'".$Header_idPopup."'";                 }else{$SIS_data .= ",''";}
				if(isset($Contact_Tittle) && $Contact_Tittle!=''){                        $SIS_data .= ",'".$Contact_Tittle."'";                 }else{$SIS_data .= ",''";}
				if(isset($Contact_Tittle_body) && $Contact_Tittle_body!=''){              $SIS_data .= ",'".$Contact_Tittle_body."'";            }else{$SIS_data .= ",''";}
				if(isset($Contact_Address_tittle) && $Contact_Address_tittle!=''){        $SIS_data .= ",'".$Contact_Address_tittle."'";         }else{$SIS_data .= ",''";}
				if(isset($Contact_Address_body) && $Contact_Address_body!=''){            $SIS_data .= ",'".$Contact_Address_body."'";           }else{$SIS_data .= ",''";}
				if(isset($Contact_Email_tittle) && $Contact_Email_tittle!=''){            $SIS_data .= ",'".$Contact_Email_tittle."'";           }else{$SIS_data .= ",''";}
				if(isset($Contact_Email_body) && $Contact_Email_body!=''){                $SIS_data .= ",'".$Contact_Email_body."'";             }else{$SIS_data .= ",''";}
				if(isset($Contact_Phone_tittle) && $Contact_Phone_tittle!=''){            $SIS_data .= ",'".$Contact_Phone_tittle."'";           }else{$SIS_data .= ",''";}
				if(isset($Contact_Phone_body) && $Contact_Phone_body!=''){                $SIS_data .= ",'".$Contact_Phone_body."'";             }else{$SIS_data .= ",''";}
				if(isset($Contact_Recep_asunto) && $Contact_Recep_asunto!=''){            $SIS_data .= ",'".$Contact_Recep_asunto."'";           }else{$SIS_data .= ",''";}
				if(isset($Contact_Recep_mail) && $Contact_Recep_mail!=''){                $SIS_data .= ",'".$Contact_Recep_mail."'";             }else{$SIS_data .= ",''";}
				if(isset($Contact_Recep_name) && $Contact_Recep_name!=''){                $SIS_data .= ",'".$Contact_Recep_name."'";             }else{$SIS_data .= ",''";}
				if(isset($Social_Tittle) && $Social_Tittle!=''){                          $SIS_data .= ",'".$Social_Tittle."'";                  }else{$SIS_data .= ",''";}
				if(isset($Social_Twitter) && $Social_Twitter!=''){                        $SIS_data .= ",'".$Social_Twitter."'";                 }else{$SIS_data .= ",''";}
				if(isset($Social_Facebook) && $Social_Facebook!=''){                      $SIS_data .= ",'".$Social_Facebook."'";                }else{$SIS_data .= ",''";}
				if(isset($Social_Instagram) && $Social_Instagram!=''){                    $SIS_data .= ",'".$Social_Instagram."'";               }else{$SIS_data .= ",''";}
				if(isset($Social_Googleplus) && $Social_Googleplus!=''){                  $SIS_data .= ",'".$Social_Googleplus."'";              }else{$SIS_data .= ",''";}
				if(isset($Social_Linkedin) && $Social_Linkedin!=''){                      $SIS_data .= ",'".$Social_Linkedin."'";                }else{$SIS_data .= ",''";}
				if(isset($Config_Logo_Nombre) && $Config_Logo_Nombre!=''){                $SIS_data .= ",'".$Config_Logo_Nombre."'";             }else{$SIS_data .= ",''";}
				if(isset($Config_Logo_Archivo) && $Config_Logo_Archivo!=''){              $SIS_data .= ",'".$Config_Logo_Archivo."'";            }else{$SIS_data .= ",''";}
				if(isset($Config_Root_Folder) && $Config_Root_Folder!=''){                $SIS_data .= ",'".$Config_Root_Folder."'";             }else{$SIS_data .= ",''";}
				if(isset($Config_Menu) && $Config_Menu!=''){                              $SIS_data .= ",'".$Config_Menu."'";                    }else{$SIS_data .= ",''";}
				if(isset($Config_MenuOtros) && $Config_MenuOtros!=''){                    $SIS_data .= ",'".$Config_MenuOtros."'";               }else{$SIS_data .= ",''";}
				if(isset($Config_Carousel) && $Config_Carousel!=''){                      $SIS_data .= ",'".$Config_Carousel."'";                }else{$SIS_data .= ",''";}
				if(isset($Config_Links_Rel) && $Config_Links_Rel!=''){                    $SIS_data .= ",'".$Config_Links_Rel."'";               }else{$SIS_data .= ",''";}
				if(isset($Config_Top_Bar) && $Config_Top_Bar!=''){                        $SIS_data .= ",'".$Config_Top_Bar."'";                 }else{$SIS_data .= ",''";}
				if(isset($Config_Footer_Links) && $Config_Footer_Links!=''){              $SIS_data .= ",'".$Config_Footer_Links."'";            }else{$SIS_data .= ",''";}
				if(isset($Config_Footer_Services) && $Config_Footer_Services!=''){        $SIS_data .= ",'".$Config_Footer_Services."'";         }else{$SIS_data .= ",''";}
				if(isset($Config_Footer_Letters) && $Config_Footer_Letters!=''){          $SIS_data .= ",'".$Config_Footer_Letters."'";          }else{$SIS_data .= ",''";}
				if(isset($Config_SMTP_mailUsername) && $Config_SMTP_mailUsername!=''){    $SIS_data .= ",'".$Config_SMTP_mailUsername."'";       }else{$SIS_data .= ",''";}
				if(isset($Config_SMTP_mailPassword) && $Config_SMTP_mailPassword!=''){    $SIS_data .= ",'".$Config_SMTP_mailPassword."'";       }else{$SIS_data .= ",''";}
				if(isset($Config_SMTP_Host) && $Config_SMTP_Host!=''){                    $SIS_data .= ",'".$Config_SMTP_Host."'";               }else{$SIS_data .= ",''";}
				if(isset($Config_SMTP_Port) && $Config_SMTP_Port!=''){                    $SIS_data .= ",'".$Config_SMTP_Port."'";               }else{$SIS_data .= ",''";}
				if(isset($Config_SMTP_Secure) && $Config_SMTP_Secure!=''){                $SIS_data .= ",'".$Config_SMTP_Secure."'";             }else{$SIS_data .= ",''";}
				if(isset($Nosotros_Titulo) && $Nosotros_Titulo!=''){                      $SIS_data .= ",'".$Nosotros_Titulo."'";                }else{$SIS_data .= ",''";}
				if(isset($Nosotros_Subtitulo) && $Nosotros_Subtitulo!=''){                $SIS_data .= ",'".$Nosotros_Subtitulo."'";             }else{$SIS_data .= ",''";}
				if(isset($Nosotros_Texto) && $Nosotros_Texto!=''){                        $SIS_data .= ",'".$Nosotros_Texto."'";                 }else{$SIS_data .= ",''";}
				if(isset($Nosotros_Link) && $Nosotros_Link!=''){                          $SIS_data .= ",'".$Nosotros_Link."'";                  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idEstado,Nombre,Domain,Whatsapp_number_1,Whatsapp_number_2,
				Whatsapp_tittle,Header_Titulo,Header_TituloStyle,Header_Texto,Header_TextoStyle,Header_LinkNombre,
				Header_LinkStyle,Header_LinkURL,Header_idNewTab,Header_idPopup,Contact_Tittle,Contact_Tittle_body,
				Contact_Address_tittle,Contact_Address_body,Contact_Email_tittle,Contact_Email_body,
				Contact_Phone_tittle,Contact_Phone_body,Contact_Recep_asunto,Contact_Recep_mail,Contact_Recep_name,
				Social_Tittle,Social_Twitter,Social_Facebook,Social_Instagram,Social_Googleplus,
				Social_Linkedin,Config_Logo_Nombre,Config_Logo_Archivo,Config_Root_Folder,Config_Menu,Config_MenuOtros,Config_Carousel,Config_Links_Rel,
				Config_Top_Bar,Config_Footer_Links,Config_Footer_Services,Config_Footer_Letters,
				Config_SMTP_mailUsername,Config_SMTP_mailPassword,Config_SMTP_Host,Config_SMTP_Port,Config_SMTP_Secure,
				Nosotros_Titulo,Nosotros_Subtitulo,Nosotros_Texto,Nosotros_Link';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sitios_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.simpleEncode($ultimo_id, fecha_actual()).'&created=true' );
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
			if(isset($Nombre)&&isset($idSistema)&&isset($idSitio)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'sitios_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idSitio!='".$idSitio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Sitio que intenta ingresar ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idSitio='".$idSitio."'";
				if(isset($idSistema) && $idSistema!=''){     $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){       $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre)){                          $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Domain)){                          $SIS_data .= ",Domain='".$Domain."'";}
				if(isset($Whatsapp_number_1)){               $SIS_data .= ",Whatsapp_number_1='".$Whatsapp_number_1."'";}
				if(isset($Whatsapp_number_2)){               $SIS_data .= ",Whatsapp_number_2='".$Whatsapp_number_2."'";}
				if(isset($Whatsapp_tittle)){                 $SIS_data .= ",Whatsapp_tittle='".$Whatsapp_tittle."'";}
				if(isset($Header_Titulo)){                   $SIS_data .= ",Header_Titulo='".$Header_Titulo."'";}
				if(isset($Header_TituloStyle)){              $SIS_data .= ",Header_TituloStyle='".$Header_TituloStyle."'";}
				if(isset($Header_Texto)){                    $SIS_data .= ",Header_Texto='".$Header_Texto."'";}
				if(isset($Header_TextoStyle)){               $SIS_data .= ",Header_TextoStyle='".$Header_TextoStyle."'";}
				if(isset($Header_LinkNombre)){               $SIS_data .= ",Header_LinkNombre='".$Header_LinkNombre."'";}
				if(isset($Header_LinkStyle)){                $SIS_data .= ",Header_LinkStyle='".$Header_LinkStyle."'";}
				if(isset($Header_LinkURL)){                  $SIS_data .= ",Header_LinkURL='".$Header_LinkURL."'";}
				if(isset($Header_idNewTab)){                 $SIS_data .= ",Header_idNewTab='".$Header_idNewTab."'";}
				if(isset($Header_idPopup)){                  $SIS_data .= ",Header_idPopup='".$Header_idPopup."'";}
				if(isset($Contact_Tittle)){                  $SIS_data .= ",Contact_Tittle='".$Contact_Tittle."'";}
				if(isset($Contact_Tittle_body)){             $SIS_data .= ",Contact_Tittle_body='".$Contact_Tittle_body."'";}
				if(isset($Contact_Address_tittle)){          $SIS_data .= ",Contact_Address_tittle='".$Contact_Address_tittle."'";}
				if(isset($Contact_Address_body)){            $SIS_data .= ",Contact_Address_body='".$Contact_Address_body."'";}
				if(isset($Contact_Email_tittle)){            $SIS_data .= ",Contact_Email_tittle='".$Contact_Email_tittle."'";}
				if(isset($Contact_Email_body)){              $SIS_data .= ",Contact_Email_body='".$Contact_Email_body."'";}
				if(isset($Contact_Phone_tittle)){            $SIS_data .= ",Contact_Phone_tittle='".$Contact_Phone_tittle."'";}
				if(isset($Contact_Phone_body)){              $SIS_data .= ",Contact_Phone_body='".$Contact_Phone_body."'";}
				if(isset($Contact_Recep_asunto)){            $SIS_data .= ",Contact_Recep_asunto='".$Contact_Recep_asunto."'";}
				if(isset($Contact_Recep_mail)){              $SIS_data .= ",Contact_Recep_mail='".$Contact_Recep_mail."'";}
				if(isset($Contact_Recep_name)){              $SIS_data .= ",Contact_Recep_name='".$Contact_Recep_name."'";}
				if(isset($Social_Tittle)){                   $SIS_data .= ",Social_Tittle='".$Social_Tittle."'";}
				if(isset($Social_Twitter)){                  $SIS_data .= ",Social_Twitter='".$Social_Twitter."'";}
				if(isset($Social_Facebook)){                 $SIS_data .= ",Social_Facebook='".$Social_Facebook."'";}
				if(isset($Social_Instagram)){                $SIS_data .= ",Social_Instagram='".$Social_Instagram."'";}
				if(isset($Social_Googleplus)){               $SIS_data .= ",Social_Googleplus='".$Social_Googleplus."'";}
				if(isset($Social_Linkedin)){                 $SIS_data .= ",Social_Linkedin='".$Social_Linkedin."'";}
				if(isset($Config_Logo_Nombre)){              $SIS_data .= ",Config_Logo_Nombre='".$Config_Logo_Nombre."'";}
				if(isset($Config_Logo_Archivo)){             $SIS_data .= ",Config_Logo_Archivo='".$Config_Logo_Archivo."'";}
				if(isset($Config_Root_Folder)){              $SIS_data .= ",Config_Root_Folder='".$Config_Root_Folder."'";}
				if(isset($Config_Menu)){                     $SIS_data .= ",Config_Menu='".$Config_Menu."'";}
				if(isset($Config_MenuOtros)){                $SIS_data .= ",Config_MenuOtros='".$Config_MenuOtros."'";}
				if(isset($Config_Carousel)){                 $SIS_data .= ",Config_Carousel='".$Config_Carousel."'";}
				if(isset($Config_Links_Rel)){                $SIS_data .= ",Config_Links_Rel='".$Config_Links_Rel."'";}
				if(isset($Config_Top_Bar)){                  $SIS_data .= ",Config_Top_Bar='".$Config_Top_Bar."'";}
				if(isset($Config_Footer_Links)){             $SIS_data .= ",Config_Footer_Links='".$Config_Footer_Links."'";}
				if(isset($Config_Footer_Services)){          $SIS_data .= ",Config_Footer_Services='".$Config_Footer_Services."'";}
				if(isset($Config_Footer_Letters)){           $SIS_data .= ",Config_Footer_Letters='".$Config_Footer_Letters."'";}
				if(isset($Config_SMTP_mailUsername)){        $SIS_data .= ",Config_SMTP_mailUsername='".$Config_SMTP_mailUsername."'";}
				if(isset($Config_SMTP_mailPassword)){        $SIS_data .= ",Config_SMTP_mailPassword='".$Config_SMTP_mailPassword."'";}
				if(isset($Config_SMTP_Host)){                $SIS_data .= ",Config_SMTP_Host='".$Config_SMTP_Host."'";}
				if(isset($Config_SMTP_Port)){                $SIS_data .= ",Config_SMTP_Port='".$Config_SMTP_Port."'";}
				if(isset($Config_SMTP_Secure)){              $SIS_data .= ",Config_SMTP_Secure='".$Config_SMTP_Secure."'";}
				if(isset($Nosotros_Titulo)){                 $SIS_data .= ",Nosotros_Titulo='".$Nosotros_Titulo."'";}
				if(isset($Nosotros_Subtitulo)){              $SIS_data .= ",Nosotros_Subtitulo='".$Nosotros_Subtitulo."'";}
				if(isset($Nosotros_Texto)){                  $SIS_data .= ",Nosotros_Texto='".$Nosotros_Texto."'";}
				if(isset($Nosotros_Link)){                   $SIS_data .= ",Nosotros_Link='".$Nosotros_Link."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'sitios_listado', 'idSitio = "'.$idSitio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'sitios_listado', 'idSitio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
