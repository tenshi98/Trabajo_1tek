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
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_test_email.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_email'])){
	//Llamamos al formulario
	$form_trabajo= 'send_mail';
	require_once 'A1XRXS_sys/xrxs_form/z_server_test.php';
}
if (!empty($_POST['submit_email_image'])){
	//Llamamos al formulario
	$form_trabajo= 'send_mail_img';
	require_once 'A1XRXS_sys/xrxs_form/z_server_test.php';
}
//formulario para editar
if (!empty($_POST['submit_email_google'])){
	//Llamamos al formulario
	$form_trabajo= 'send_mail_google';
	require_once 'A1XRXS_sys/xrxs_form/z_server_test.php';
}
if (!empty($_POST['submit_email_format'])){
	//Llamamos al formulario
	$form_trabajo= 'send_mail_format';
	require_once 'A1XRXS_sys/xrxs_form/z_server_test.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['error'])){ $error['error'] = 'error/'.$_GET['error'];}
if (isset($_GET['send'])){  $error['send']  = 'sucess/Email enviado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}

//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){

//si estoy en ambiente de produccion
}else{
	/*    Global Variables    */
	//Tiempo Maximo de la consulta, 40 minutos por defecto
	if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
	//Memora RAM Maxima del servidor, 4GB por defecto
	if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
}

//Consulta de los datos del sistema del equipo
$rowEmpresa = db_select_data (false, 'email_principal, Config_Gmail_Usuario, Config_Gmail_Password', 'core_sistemas','', 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Testeo de correos</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#data1" data-toggle="tab"><i class="fa fa-envelope-o" aria-hidden="true"></i> Correo</a></li>
				<li class=""><a href="#data2" data-toggle="tab"><i class="fa fa-envelope-o" aria-hidden="true"></i> Correo con Imagen</a></li>
				<li class=""><a href="#data3" data-toggle="tab"><i class="fa fa-envelope-o" aria-hidden="true"></i> Correo google</a></li>
				<li class=""><a href="#data4" data-toggle="tab"><i class="fa fa-envelope-o" aria-hidden="true"></i> Correo formato</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="data1">
				<div class="wmd-panel">
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
							<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

								<?php
								//Se verifican si existen los datos
								if(isset($email)){      $x1  = $email;    }else{$x1  = '';}
								if(isset($texto)){      $x2  = $texto;    }else{$x2  = '';}

								//se dibujan los inputs
								$Form_Inputs = new Form_Inputs();
								$Form_Inputs->form_input_icon('Email', 'email', $x1, 2,'fa fa-envelope-o');
								$Form_Inputs->form_textarea('Texto','texto', $x2, 2);

								$Form_Inputs->form_input_hidden('email_principal', $rowEmpresa['email_principal'], 2);

								?>

								<div class="form-group">
									<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf003; Enviar Prueba" name="submit_email">
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="data2">
				<div class="wmd-panel">
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
							<form class="form-horizontal" method="post" id="form2" name="form2" novalidate>

								<?php
								//Se verifican si existen los datos
								if(isset($email)){      $x1  = $email;    }else{$x1  = '';}
								if(isset($texto)){      $x2  = $texto;    }else{$x2  = '';}

								//se dibujan los inputs
								$Form_Inputs = new Form_Inputs();
								$Form_Inputs->form_input_icon('Email', 'email', $x1, 2,'fa fa-envelope-o');
								$Form_Inputs->form_textarea('Texto','texto', $x2, 2);

								$Form_Inputs->form_input_hidden('email_principal', $rowEmpresa['email_principal'], 2);

								?>

								<div class="form-group">
									<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf003; Enviar Prueba" name="submit_email_image">
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="data3">
				<div class="wmd-panel">
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
							<form class="form-horizontal" method="post" id="form3" name="form3" novalidate>

								<?php
								//Se verifican si existen los datos
								if(isset($email)){             $x1 = $email;           }else{$x1 = '';}
								if(isset($texto)){             $x2 = $texto;           }else{$x2 = '';}
								if(isset($GmailUsuario)){      $x3 = $GmailUsuario;    }else{$x3 = '';}
								if(isset($GmailPassword)){     $x4 = $GmailPassword;   }else{$x4 = '';}
								if(isset($email_principal)){   $x5 = $email_principal; }else{$x5 = '';}

								//se dibujan los inputs
								$Form_Inputs = new Form_Inputs();
								$Form_Inputs->form_input_icon('Email', 'email', $x1, 2,'fa fa-envelope-o');
								$Form_Inputs->form_textarea('Texto','texto', $x2, 2);

								$Form_Inputs->form_input_icon('Gmail Usuario', 'GmailUsuario', $x3, 2,'fa fa-envelope-o');
								$Form_Inputs->form_input_icon('Gmail Password', 'GmailPassword', $x4, 2,'fa fa-envelope-o');
								$Form_Inputs->form_input_icon('email principal', 'email_principal', $x5, 2,'fa fa-envelope-o');

								?>

								<div class="form-group">
									<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf003; Enviar Prueba" name="submit_email_google">
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="data4">
				<div class="wmd-panel">
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
							<form class="form-horizontal" method="post" id="form4" name="form4" autocomplete="off" novalidate>

								<?php
								//Se verifican si existen los datos
								if(isset($email)){      $x1  = $email;    }else{$x1  = '';}
								if(isset($texto)){      $x2  = $texto;    }else{$x2  = '';}

								//se dibujan los inputs
								$Form_Inputs = new Form_Inputs();
								$Form_Inputs->form_input_icon('Email', 'email', $x1, 2,'fa fa-envelope-o');
								$Form_Inputs->form_textarea('Texto','texto', $x2, 2);

								$Form_Inputs->form_input_hidden('email_principal', $rowEmpresa['email_principal'], 2);

								?>

								<div class="form-group">
									<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf003; Enviar Prueba" name="submit_email_format">
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>

        </div>
	</div>
</div>

<?php widget_validator(); ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
