<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1010-002).');
}
/*******************************************************************************************************************/
/*                                              Bloque de consultas                                                */
/*******************************************************************************************************************/

// consulto los datos
$SIS_query = '
Nombre,Domain,
Whatsapp_number_1,Whatsapp_number_2,Whatsapp_tittle,

Header_Titulo,Header_TituloStyle,Header_Texto,Header_TextoStyle,Header_LinkNombre,
Header_LinkStyle,Header_LinkURL,Header_idNewTab,Header_idPopup,

Contact_Tittle,Contact_Tittle_body,Contact_Address_tittle,Contact_Address_body,
Contact_Email_tittle,Contact_Email_body,Contact_Phone_tittle,Contact_Phone_body,
Contact_Recep_asunto,Contact_Recep_mail,Contact_Recep_name,

Social_Tittle,Social_Twitter,Social_Facebook,Social_Instagram,Social_Googleplus,Social_Linkedin,

Config_Logo_Nombre,Config_Logo_Archivo,Config_Root_Folder,Config_Menu,Config_MenuOtros,
Config_Carousel,Config_Links_Rel,Config_Top_Bar,Config_Footer_Links,Config_Footer_Services,
Config_Footer_Letters,Config_SMTP_mailUsername,Config_SMTP_mailPassword,Config_SMTP_Host,
Config_SMTP_Port,Config_SMTP_Secure,

Nosotros_Titulo,Nosotros_Subtitulo,Nosotros_Texto,Nosotros_Link';
$SIS_join  = '';
$SIS_where = 'idSitio = '.$idSitio;
$rowData = db_select_data (false, $SIS_query, 'sitios_listado', $SIS_join, $SIS_where, $dbConn, 'load_data', basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************/
//Permisos a sistemas
$SIS_query = 'Nombre,Link,idNewTab,idPopup';
$SIS_join  = '';
$SIS_where = 'idSitio = '.$idSitio.' AND idEstado=1';
$SIS_order = 'idPosicion ASC';
$arrMenu = array();
$arrMenu = db_select_array (false, $SIS_query, 'sitios_listado_menu', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'load_data', basename($_SERVER["REQUEST_URI"], ".php"), 'arrMenu');

/**********************************/
//Permisos a sistemas
$SIS_query = 'Nombre,Link,idNewTab,idPopup';
$SIS_join  = '';
$SIS_where = 'idSitio = '.$idSitio.' AND idEstado=1';
$SIS_order = 'idPosicion ASC';
$arrMenuDesplegable = array();
$arrMenuDesplegable = db_select_array (false, $SIS_query, 'sitios_listado_menu_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'load_data', basename($_SERVER["REQUEST_URI"], ".php"), 'arrMenuDesplegable');

/**********************************/
//Permisos a sistemas
$SIS_query = 'Imagen,Titulo,TituloStyle,Subtitulo,SubtituloStyle,Texto,TextoStyle,PosicionBloque';
$SIS_join  = '';
$SIS_where = 'idSitio = '.$idSitio.' AND idEstado=1';
$SIS_order = 'idPosicion ASC';
$arrCarousel = array();
$arrCarousel = db_select_array (false, $SIS_query, 'sitios_listado_carousel', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'load_data', basename($_SERVER["REQUEST_URI"], ".php"), 'arrCarousel');

/**********************************/
//Permisos a sistemas
$SIS_query = 'idTipo,Icono,IconoStyle,Titulo,TituloStyle,Texto,TextoStyle,LinkNombre,
LinkStyle,LinkURL,idNewTab,idPopup,idPosicion,Imagen';
$SIS_join  = '';
$SIS_where = 'idSitio = '.$idSitio.' AND idEstado=1';
$SIS_order = 'idTipo ASC, idPosicion ASC';
$arrBody = array();
$arrBody = db_select_array (false, $SIS_query, 'sitios_listado_body', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'load_data', basename($_SERVER["REQUEST_URI"], ".php"), 'arrBody');

?>


