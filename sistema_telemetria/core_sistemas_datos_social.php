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
$SIS_query = 'Nombre,Social_idUso, Social_facebook, Social_twitter,
Social_instagram, Social_linkedin, Social_rss, Social_youtube, Social_tumblr';
$SIS_join  = '';
$SIS_where = 'idSistema ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Editar Datos Sociales'); ?>
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
						<li class=""><a href="<?php echo 'core_sistemas_datos_opciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-code" aria-hidden="true"></i> APIS</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Logo</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crosstech.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >1Tek</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crossenergy.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Power-Energy</a></li>
						<li class="active"><a href="<?php echo 'core_sistemas_datos_social.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Social</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<?php
			echo '<br/>';
			echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
				//facebook
				$Alert_Text  = 'Obtener el ID de una página de Facebook';
				$Alert_Text .= '<a target="_blank" rel="noopener noreferrer" href="https://www.bufa.es/id-pagina-facebook/" title="Obtener ID" class="btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-facebook" aria-hidden="true"></i> Obtener ID</a>';
				alert_post_data(2,1,2,0, $Alert_Text);
				//Linkedin
				$Alert_Text  = 'Para obtener el <strong>Identificador</strong> de Linkedin, debes iniciar sesion, en el tab donde dice <strong>YO</strong> presionarlo y luego presionar el boton <strong> Ver Perfil</strong>, una vez dentro del perfil ver la barra de direcciones del navegador y copiar lo que viene despues de <strong>https://www.linkedin.com/in/</strong> sin copiar los <strong>/</strong>';
				alert_post_data(2,1,2,0, $Alert_Text);
			
			echo '</div>';
			?>
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Social_idUso)){         $x1 = $Social_idUso;         }else{$x1 = $rowData['Social_idUso'];}
					if(isset($Social_facebook)){      $x2 = $Social_facebook;      }else{$x2 = $rowData['Social_facebook'];}
					if(isset($Social_twitter)){       $x3 = $Social_twitter;       }else{$x3 = $rowData['Social_twitter'];}
					if(isset($Social_instagram)){     $x4 = $Social_instagram;     }else{$x4 = $rowData['Social_instagram'];}
					if(isset($Social_linkedin)){      $x5 = $Social_linkedin;      }else{$x5 = $rowData['Social_linkedin'];}
					if(isset($Social_rss)){           $x6 = $Social_rss;           }else{$x6 = $rowData['Social_rss'];}
					if(isset($Social_youtube)){       $x7 = $Social_youtube;       }else{$x7 = $rowData['Social_youtube'];}
					if(isset($Social_tumblr)){        $x8 = $Social_tumblr;        }else{$x8 = $rowData['Social_tumblr'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Uso de widget Sociales','Social_idUso', $x1, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_input_icon('Facebook - ID de la pagina', 'Social_facebook', $x2, 1,'fa fa-facebook');
					$Form_Inputs->form_input_icon('Twitter - Dirección Web', 'Social_twitter', $x3, 1,'fa fa-twitter');
					//$Form_Inputs->form_input_icon('Instagram', 'Social_instagram', $x4, 1,'fa fa-instagram');
					$Form_Inputs->form_input_icon('Linkedin - Identificador', 'Social_linkedin', $x5, 1,'fa fa-linkedin');
					$Form_Inputs->form_input_icon('Rss - Dirección Feed', 'Social_rss', $x6, 1,'fa fa-rss');
					//$Form_Inputs->form_input_icon('ApiKey (Youtube)', 'Social_youtube', $x7, 1,'fa fa-youtube');
					//$Form_Inputs->form_input_icon('ApiKey (Tumblr)', 'Social_tumblr', $x8, 1,'fa fa-tumblr');

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
