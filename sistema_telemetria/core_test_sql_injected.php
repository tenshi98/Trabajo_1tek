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
//Verifico si es superusuario
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Type.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_sistemas.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Sistema Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Sistema Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Sistema Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*******************************************************/
// consulto los datos
$SIS_query = '
usuarios_listado.password,
usuarios_listado.usuario,
usuarios_listado.Nombre,
usuarios_tipos.Nombre AS Usuario_Tipo';
$SIS_join  = 'LEFT JOIN `usuarios_tipos` ON usuarios_tipos.idTipoUsuario = usuarios_listado.idTipoUsuario';
$SIS_where = 'usuarios_listado.usuario = "'.$usuario_1.'" AND usuarios_listado.password = "'.md5($password_1).'"';
$rowUser1 = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

/*******************************************************/
// consulto los datos
$SIS_query = '
usuarios_listado.password,
usuarios_listado.usuario,
usuarios_listado.Nombre,
usuarios_tipos.Nombre AS Usuario_Tipo';
$SIS_join  = 'LEFT JOIN `usuarios_tipos` ON usuarios_tipos.idTipoUsuario = usuarios_listado.idTipoUsuario';
$SIS_where = 'usuarios_listado.usuario = "'.$usuario_2.'" AND usuarios_listado.password = "'.md5($password_2).'"';
$rowUser2 = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Inputs Test</h5>
		</header>
		<div class="body">

			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();

				/******************************************************************/
				$Form_Inputs->form_tittle(3, 'SQL Normal');
				if (!empty($_POST['submit_test'])){

					if (!empty($_POST['usuario']))    $usuario_1   = $_POST['usuario'];
					if (!empty($_POST['password']))   $password_1  = $_POST['password'];

					echo '<pre>';
						var_dump($query1);
						echo '<br/>';
						var_dump($rowUser1);
					echo '</pre>';

					echo '<pre>';
						var_dump($_POST);
					echo '</pre>';
				}

				/******************************************************************/
				$Form_Inputs->form_tittle(3, 'SQL Sanitizado');
				//se sanitiza
				$_POST = SanitizarDatos($_POST);

				if (!empty($_POST['submit_test'])){

					if (!empty($_POST['usuario']))    $usuario_2    = $_POST['usuario'];
					if (!empty($_POST['password']))   $password_2   = $_POST['password'];

					echo '<pre>';
						var_dump($query2);
						echo '<br/>';
						var_dump($rowUser2);
					echo '</pre>';

					echo '<pre>';
						var_dump($_POST);
					echo '</pre>';
				}

				/******************************************************************/
				//Se verifican si existen los datos
				$x1  = '';
				$x2  = '';

				$Form_Inputs->form_input_text('Usuario', 'usuario', $x1, 2);
				$Form_Inputs->form_input_text('Password', 'password', $x2, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Ejecutar" name="submit_test">
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
