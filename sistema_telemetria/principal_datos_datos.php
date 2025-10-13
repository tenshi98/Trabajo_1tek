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
if (!empty($_POST['edit_datos'])){
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
// consulto los datos
$SIS_query = 'email, Nombre,Rut, fNacimiento, Direccion, Fono, idCiudad, idComuna';
$SIS_join  = '';
$SIS_where = 'idUsuario = '.$_SESSION['usuario']['basic_data']['idUsuario'];
$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Perfil', $_SESSION['usuario']['basic_data']['Nombre'], 'Editar Datos Personales'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Personales</a></li>
				<li class=""><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Cambiar Imagen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Cambiar Contraseña</a></li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){        $x5  = $Nombre;       }else{$x5  = $rowData['Nombre'];}
					if(isset($Fono)){          $x6  = $Fono;         }else{$x6  = $rowData['Fono'];}
					if(isset($email)){         $x7  = $email;        }else{$x7  = $rowData['email'];}
					if(isset($Rut)){           $x8  = $Rut;          }else{$x8  = $rowData['Rut'];}
					if(isset($fNacimiento)){   $x9  = $fNacimiento;  }else{$x9  = $rowData['fNacimiento'];}
					if(isset($Ciudad)){        $x10 = $Ciudad;       }else{$x10 = $rowData['idCiudad'];}
					if(isset($Comuna)){        $x11 = $Comuna;       }else{$x11 = $rowData['idComuna'];}
					if(isset($Direccion)){     $x12 = $Direccion;    }else{$x12 = $rowData['Direccion'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x5, 2);
					$Form_Inputs->form_input_phone('Fono','Fono', $x6, 1);
					$Form_Inputs->form_input_icon('Email', 'email', $x7, 2,'fa fa-envelope-o');
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x8, 2);
					$Form_Inputs->form_date('Fecha de Nacimiento','fNacimiento', $x9, 2);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x10, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											 'Comuna','idComuna', $x11, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											 $dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x12, 1,'fa fa-map');
					$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="edit_datos">
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
