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
$original = "principal.php";
$location = $original;
header('Access-Control-Allow-Origin: *');
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/

/*****************************************************************************************************************/
/*                                        Se verifica la plataforma                                              */
/*****************************************************************************************************************/
$Navegador = obtenerNavegador();
if(isset($Navegador)&&$Navegador!=''&&$Navegador!='Mozilla Firefox'&&$Navegador!='Google Chrome'){
	echo '<div class="col-xs-12" style="margin-top:15px;">';
		$Alert_Text  = 'Esta utilizando el navegador '.$Navegador;
		$Alert_Text .= ', Se garantiza el funcionamiento en los navegadores Firefox o Chrome en sus ultimas versiones.';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}

$SistOp = obtenerSistOperativo();
if(isset($SistOp)&&$SistOp!=''&&$SistOp!='Debian'&&$SistOp!='Ubuntu'&&$SistOp!='Slackware'&&$SistOp!='Linux Mint'&&$SistOp!='Gentoo'&&$SistOp!='ELementary OS'&&$SistOp!='Fedora'&&$SistOp!='Kubuntu'&&$SistOp!='Linux'&&$SistOp!='Windows 10'&&$SistOp!='Windows 8.1'&&$SistOp!='Windows 8'&&$SistOp!='Windows 7'){
	echo '<div class="col-xs-12" style="margin-top:15px;">';
		$Alert_Text  = 'Esta utilizando el sistema operativo '.$SistOp;
		$Alert_Text .= ', Se garantiza el funcionamiento en los sistemas operativos Windows 10,Windows 8.1,';
		$Alert_Text .= 'Windows 8,Windows 7,Debian,Ubuntu,Slackware,Linux Mint,Gentoo,ELementary OS,Fedora,Kubuntu,Linux.';
		alert_post_data(4,2,2,0, $Alert_Text);
	echo '</div>';
}


/*****************************************************************************************************************/
/*                                Se verifica si se ha cambiado la clave de inicio                               */
/*****************************************************************************************************************/
if($_SESSION['usuario']['basic_data']['password']=='81dc9bdb52d04dc20036dbd8313ed055') {  ?>

	<script type="text/javascript">
		$(window).on('load',function(){
			$('#ModalPass').modal('show');
		});
	</script>

	<!-- Modal -->
	<div class="modal fade" id="ModalPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Cambio de Contraseña</h4>
				</div>
				<div class="modal-body">
					<p>Aun no ha cambiado su contraseña inicial, por seguridad debe cambiarla ahora, recuerde ingresar una contraseña que le sea facil de recordar.</p>
				</div>
				<div class="modal-footer">
					<a href="principal_datos_password.php" class="btn btn-primary">Cambiar</a>
				</div>
			</div>
		</div>
	</div>

<?php }
include '1include_principal.php';
widget_validator();


/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
