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
$original = "principal_datos.php";
$location = $original;
$location .= '?d=d';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['edit_clave'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Perfil Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Perfil Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Perfil Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Perfil', $_SESSION['usuario']['basic_data']['Nombre'], 'Cambiar Contraseña'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Personales</a></li>
				<li class=""><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Cambiar Imagen</a></li>
				<li class="active"><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Cambiar Contraseña</a></li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($oldpassword)){   $x1  = $oldpassword;  }else{$x1  = '';}
					if(isset($password)){      $x2  = $password;     }else{$x2  = '';}
					if(isset($repassword)){    $x3  = $repassword;   }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_password('Password Antigua', 'oldpassword', $x1, 2);
					$Form_Inputs->form_input_password('Nueva Password', 'password', $x2, 2);
					$Form_Inputs->form_input_password('Repetir Password', 'repassword', $x3, 2);

					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Cambiar Password" name="edit_clave">
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>

			<div id="pswd_info">
				<h4>Requerimientos</h4>
				<ul>
					<li id="letter" class="invalid">Minimo una letra</li>
					<li id="capital" class="invalid">Una letra mayuscula</strong></li>
					<li id="number" class="invalid">Un numero</strong></li>
					<li id="length" class="invalid">8 Caracteres</strong></li>
					<li id="space" class="invalid">Usar Simbolos [@,#,*,-,.,;]</li>
				</ul>
			</div>

			<script>
				$(document).ready(function(){
					$('input[type=password]').keyup(function() {
						let pswd = $(this).val();

						//validate the length
						if ( pswd.length < 8 ) {
							$('#length').removeClass('valid').addClass('invalid');
						} else {
							$('#length').removeClass('invalid').addClass('valid');
						}

						//validate letter
						if ( pswd.match(/[A-z]/)){
							$('#letter').removeClass('invalid').addClass('valid');
						} else {
							$('#letter').removeClass('valid').addClass('invalid');
						}

						//validate capital letter
						if ( pswd.match(/[A-Z]/)){
							$('#capital').removeClass('invalid').addClass('valid');
						} else {
							$('#capital').removeClass('valid').addClass('invalid');
						}

						//validate number
						if ( pswd.match(/\d/)){
							$('#number').removeClass('invalid').addClass('valid');
						} else {
							$('#number').removeClass('valid').addClass('invalid');
						}

						//validate space
						if ( pswd.match(/[^a-zA-Z0-9\-\/]/)){
							$('#space').removeClass('invalid').addClass('valid');
						} else {
							$('#space').removeClass('valid').addClass('invalid');
						}

					}).focus(function() {
						$('#pswd_info').show();
					}).blur(function() {
						$('#pswd_info').hide();
					});

				});
			</script>

		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
