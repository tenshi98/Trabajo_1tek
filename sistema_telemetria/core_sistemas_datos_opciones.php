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
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$location.='&id='.$_GET['id'];
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/core_sistemas.php';
}
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
// consulto los datos
$SIS_query = 'Nombre,Config_IDGoogle, Config_Google_apiKey, Config_FCM_apiKey, Config_FCM_Main_apiKey,
Config_WhatsappToken, Config_WhatsappInstanceId';
$SIS_join  = '';
$SIS_where = 'idSistema ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Editar APIS'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'core_sistemas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'core_sistemas_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'core_sistemas_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'core_sistemas_datos_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
						<li class="active"><a href="<?php echo 'core_sistemas_datos_opciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-code" aria-hidden="true"></i> APIS</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Logo</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crosstech.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >1Tek</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crossenergy.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Power-Energy</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_social.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Social</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Config_IDGoogle)){            $x1 = $Config_IDGoogle;            }else{$x1 = $rowData['Config_IDGoogle'];}
					if(isset($Config_Google_apiKey)){       $x2 = $Config_Google_apiKey;       }else{$x2 = $rowData['Config_Google_apiKey'];}
					if(isset($Config_FCM_apiKey)){          $x3 = $Config_FCM_apiKey;          }else{$x3 = $rowData['Config_FCM_apiKey'];}
					if(isset($Config_FCM_Main_apiKey)){     $x4 = $Config_FCM_Main_apiKey;     }else{$x4 = $rowData['Config_FCM_Main_apiKey'];}
					if(isset($Config_WhatsappToken)){       $x5 = $Config_WhatsappToken;       }else{$x5 = $rowData['Config_WhatsappToken'];}
					if(isset($Config_WhatsappInstanceId)){  $x6 = $Config_WhatsappInstanceId;  }else{$x6 = $rowData['Config_WhatsappInstanceId'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_icon('ID Google (Mapas)', 'Config_IDGoogle', $x1, 1,'fa fa-google-plus-square');
					/*$Form_Inputs->form_input_icon('ApiKey (Android)', 'Config_Google_apiKey', $x2, 1,'fa fa-google-plus-square');
					$Form_Inputs->form_input_icon('ApiKey (Firebase)', 'Config_FCM_apiKey', $x3, 1,'fa fa-google-plus-square');
					$Form_Inputs->form_post_data(2,1,1, '<strong>Main ApiKey (Firebase)</strong> sirve para la notificacion desde varias plataformas a una misma APP.');
					$Form_Inputs->form_input_icon('Main ApiKey (Firebase)', 'Config_FCM_Main_apiKey', $x4, 1,'fa fa-google-plus-square');*/

					$Form_Inputs->form_post_data(2,1,1, 'El Token y el Instance ID de Whatsapp se obtienen con el proveedor del servicio.');
					$Form_Inputs->form_input_icon('Whatsapp Token', 'Config_WhatsappToken', $x5, 1,'fa fa-google-plus-square');
					$Form_Inputs->form_input_icon('Whatsapp Instance Id', 'Config_WhatsappInstanceId', $x6, 1,'fa fa-google-plus-square');

					$Form_Inputs->form_input_hidden('idSistema', $_GET['id'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
