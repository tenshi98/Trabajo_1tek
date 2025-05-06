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
require_once 'core/Load.Utils.Error.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Error.php';

?>

<div class="container">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-lg-offset-2 text-center">
		<div class="logo">
			<h1>404</h1>
		</div>
		<p class="lead text-muted">Lo sentimos, pero la pagina que busca no existe.</p>
		<div class="clearfix"></div>
		<br/>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-offset-3">
			<div class="btn-group btn-group-justified">
				<a href="principal.php" class="btn btn-info">Volver a Principal</a>
				<a href="index.php" class="btn btn-warning">Volver a Inicio</a>
			</div>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Error.php';

?>
