<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "principal_notificaciones.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
if(isset($_GET['filtersender']) && $_GET['filtersender']!=''){   $location .= "&filtersender=".$_GET['filtersender']; 	}
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se borra un dato
if (!empty($_GET['id'])){
	//Llamamos al formulario
	$form_trabajo= 'aprobar_uno';
	require_once 'A1XRXS_sys/xrxs_form/z_notificaciones.php';
}
//se borra un dato
if (!empty($_GET['all'])){
	//Llamamos al formulario
	$form_trabajo= 'aprobar_todos';
	require_once 'A1XRXS_sys/xrxs_form/z_notificaciones.php';
}
//se indica que no hay que molestar
if (!empty($_GET['noMolestar'])){
	//Llamamos al formulario
	$form_trabajo= 'noMolestar';
	require_once 'A1XRXS_sys/xrxs_form/telemetria_mnt_correos_list.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['aprobar_uno'])){   $error['aprobar_uno']   = 'sucess/Se ha marcado como visto un elemento';}
if (isset($_GET['aprobar_todos'])){ $error['aprobar_todos'] = 'sucess/Se han marcado como visto todos los elementos';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//Si esta activo el nomolestar
if(isset($_GET['noMol'])&&$_GET['noMol']!=''){
	//mostrar la alerta
	$Alert_Text  = 'Se han desactivado las alertas por '.$_GET['noMol'].' Horas.';
	alert_post_data(2,1,1,0, $Alert_Text);
}
//Include de la notificacion
include '1include_principal_notificaciones.php';

?>
  							
                            


<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="principal.php" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>
       
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
