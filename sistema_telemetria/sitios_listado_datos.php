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
$original = "sitios_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Sitio Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Sitio Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Sitio Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = 'Nombre,Config_Menu,Config_MenuOtros,Config_Carousel,Config_Links_Rel,
Domain,Whatsapp_number_1,Whatsapp_number_2,Whatsapp_tittle,
Header_Titulo,Header_TituloStyle,Header_Texto,Header_TextoStyle,Header_LinkNombre,Header_LinkStyle,Header_LinkURL,Header_idNewTab,Header_idPopup,
Contact_Tittle,Contact_Tittle_body,Contact_Address_tittle,Contact_Address_body,Contact_Email_tittle,
Contact_Email_body,Contact_Phone_tittle,Contact_Phone_body,Contact_Recep_asunto,
Contact_Recep_mail,Contact_Recep_name,Social_Tittle,Social_Twitter,Social_Facebook,
Social_Instagram,Social_Googleplus,Social_Linkedin,Nosotros_Titulo,Nosotros_Subtitulo,
Nosotros_Texto,Nosotros_Link';
$SIS_join  = '';
$SIS_where = 'sitios_listado.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'sitios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sitio', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'sitios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'sitios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'sitios_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if(isset($rowData['Config_Menu'])&&$rowData['Config_Menu']==1){ ?>            <li class=""><a href="<?php echo 'sitios_listado_menu.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu</a></li><?php } ?>
						<?php if(isset($rowData['Config_MenuOtros'])&&$rowData['Config_MenuOtros']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_menu_otros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu Otros</a></li><?php } ?>
						<?php if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==1){ ?>    <li class=""><a href="<?php echo 'sitios_listado_carousel.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Carousel</a></li><?php } ?>
						<?php if(isset($rowData['Config_Links_Rel'])&&$rowData['Config_Links_Rel']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_links.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-link" aria-hidden="true"></i> Links Relacionados</a></li><?php } ?>

						<li class=""><a href="<?php echo 'sitios_listado_body.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Body</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){                  $x1  = $Nombre;                  }else{$x1  = $rowData['Nombre'];}
					if(isset($Domain)){                  $x2  = $Domain;                  }else{$x2  = $rowData['Domain'];}
					if(isset($Whatsapp_tittle)){         $x3  = $Whatsapp_tittle;         }else{$x3  = $rowData['Whatsapp_tittle'];}
					if(isset($Whatsapp_number_1)){       $x4  = $Whatsapp_number_1;       }else{$x4  = $rowData['Whatsapp_number_1'];}
					if(isset($Whatsapp_number_2)){       $x5  = $Whatsapp_number_2;       }else{$x5  = $rowData['Whatsapp_number_2'];}
					if(isset($Header_Titulo)){           $x6  = $Header_Titulo;           }else{$x6  = $rowData['Header_Titulo'];}
					if(isset($Header_TituloStyle)){      $x7  = $Header_TituloStyle;      }else{$x7  = $rowData['Header_TituloStyle'];}
					if(isset($Header_Texto)){            $x8  = $Header_Texto;            }else{$x8  = $rowData['Header_Texto'];}
					if(isset($Header_TextoStyle)){       $x9  = $Header_TextoStyle;       }else{$x9  = $rowData['Header_TextoStyle'];}
					if(isset($Header_LinkNombre)){       $x10 = $Header_LinkNombre;       }else{$x10 = $rowData['Header_LinkNombre'];}
					if(isset($Header_LinkStyle)){        $x11 = $Header_LinkStyle;        }else{$x11 = $rowData['Header_LinkStyle'];}
					if(isset($Header_LinkURL)){          $x12 = $Header_LinkURL;          }else{$x12 = $rowData['Header_LinkURL'];}
					if(isset($Header_idNewTab)){         $x13 = $Header_idNewTab;         }else{$x13 = $rowData['Header_idNewTab'];}
					if(isset($Header_idPopup)){          $x14 = $Header_idPopup;          }else{$x14 = $rowData['Header_idPopup'];}
					if(isset($Contact_Tittle)){          $x15 = $Contact_Tittle;          }else{$x15 = $rowData['Contact_Tittle'];}
					if(isset($Contact_Tittle_body)){     $x16 = $Contact_Tittle_body;     }else{$x16 = $rowData['Contact_Tittle_body'];}
					if(isset($Contact_Address_tittle)){  $x17 = $Contact_Address_tittle;  }else{$x17 = $rowData['Contact_Address_tittle'];}
					if(isset($Contact_Address_body)){    $x18 = $Contact_Address_body;    }else{$x18 = $rowData['Contact_Address_body'];}
					if(isset($Contact_Email_tittle)){    $x19 = $Contact_Email_tittle;    }else{$x19 = $rowData['Contact_Email_tittle'];}
					if(isset($Contact_Email_body)){      $x20 = $Contact_Email_body;      }else{$x20 = $rowData['Contact_Email_body'];}
					if(isset($Contact_Phone_tittle)){    $x21 = $Contact_Phone_tittle;    }else{$x21 = $rowData['Contact_Phone_tittle'];}
					if(isset($Contact_Phone_body)){      $x22 = $Contact_Phone_body;      }else{$x22 = $rowData['Contact_Phone_body'];}
					if(isset($Contact_Recep_asunto)){    $x23 = $Contact_Recep_asunto;    }else{$x23 = $rowData['Contact_Recep_asunto'];}
					if(isset($Contact_Recep_mail)){      $x24 = $Contact_Recep_mail;      }else{$x24 = $rowData['Contact_Recep_mail'];}
					if(isset($Contact_Recep_name)){      $x25 = $Contact_Recep_name;      }else{$x25 = $rowData['Contact_Recep_name'];}
					if(isset($Social_Tittle)){           $x26 = $Social_Tittle;           }else{$x26 = $rowData['Social_Tittle'];}
					if(isset($Social_Twitter)){          $x27 = $Social_Twitter;          }else{$x27 = $rowData['Social_Twitter'];}
					if(isset($Social_Facebook)){         $x28 = $Social_Facebook;         }else{$x28 = $rowData['Social_Facebook'];}
					if(isset($Social_Instagram)){        $x29 = $Social_Instagram;        }else{$x29 = $rowData['Social_Instagram'];}
					if(isset($Social_Googleplus)){       $x30 = $Social_Googleplus;       }else{$x30 = $rowData['Social_Googleplus'];}
					if(isset($Social_Linkedin)){         $x31 = $Social_Linkedin;         }else{$x31 = $rowData['Social_Linkedin'];}
					if(isset($Nosotros_Titulo)){         $x32 = $Nosotros_Titulo;         }else{$x32 = $rowData['Nosotros_Titulo'];}
					if(isset($Nosotros_Subtitulo)){      $x33 = $Nosotros_Subtitulo;      }else{$x33 = $rowData['Nosotros_Subtitulo'];}
					if(isset($Nosotros_Texto)){          $x34 = $Nosotros_Texto;          }else{$x34 = $rowData['Nosotros_Texto'];}
					if(isset($Nosotros_Link)){           $x35 = $Nosotros_Link;           }else{$x35 = $rowData['Nosotros_Link'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Dominio', 'Domain', $x2, 1);

					$Form_Inputs->form_tittle(3, 'Whatsapp');
					$Form_Inputs->form_input_text('Título', 'Whatsapp_tittle', $x3, 1);
					$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
					$Form_Inputs->form_input_phone('Numero Whatsapp 1', 'Whatsapp_number_1', $x4, 1);
					$Form_Inputs->form_input_phone('Numero Whatsapp 2', 'Whatsapp_number_2', $x5, 1);

					//Si el carrousel esta desactivado
					if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==2){
						$Form_Inputs->form_tittle(3, 'Header');
						$Form_Inputs->form_input_text('Título', 'Header_Titulo', $x6, 2);
						$Form_Inputs->form_input_icon('Estilo del Titulo', 'Header_TituloStyle', $x7, 1,'fa fa-file-image-o');
						$Form_Inputs->form_textarea('Texto', 'Header_Texto', $x8, 1);
						$Form_Inputs->form_input_icon('Estilo del Texto', 'Header_TextoStyle', $x9, 1,'fa fa-file-image-o');
						$Form_Inputs->form_input_text('Nombre del enlace', 'Header_LinkNombre', $x10, 1);
						$Form_Inputs->form_input_icon('Estilo del enlace', 'Header_LinkStyle', $x11, 1,'fa fa-file-image-o');
						$Form_Inputs->form_input_text('Enlace (Link o referencia)', 'Header_LinkURL', $x12, 1);
						$Form_Inputs->form_select('Abrir en una nueva pestaña','Header_idNewTab', $x13, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
						$Form_Inputs->form_select('Abrir en ventana emergente','Header_idPopup', $x14, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					}

					$Form_Inputs->form_tittle(3, 'Contacto');
					$Form_Inputs->form_input_text('Contacto - Titulo', 'Contact_Tittle', $x15, 1);
					$Form_Inputs->form_textarea('Contacto - Cuerpo', 'Contact_Tittle_body', $x16, 1);
					$Form_Inputs->form_input_icon('Dirección - Titulo', 'Contact_Address_tittle', $x17, 1,'fa fa-map');
					$Form_Inputs->form_textarea('Dirección - Cuerpo', 'Contact_Address_body', $x18, 1);
					$Form_Inputs->form_input_icon('Email - Titulo', 'Contact_Email_tittle', $x19, 1,'fa fa-envelope-o');
					$Form_Inputs->form_textarea('Email - Cuerpo', 'Contact_Email_body', $x20, 1);
					$Form_Inputs->form_input_icon('Fono - Titulo', 'Contact_Phone_tittle', $x21, 1,'fa fa-phone');
					$Form_Inputs->form_textarea('Fono - Cuerpo', 'Contact_Phone_body', $x22, 1);
					$Form_Inputs->form_input_icon('Receptor - Asunto', 'Contact_Recep_asunto', $x23, 1,'fa fa-users');
					$Form_Inputs->form_input_icon('Receptor - Email', 'Contact_Recep_mail', $x24, 1,'fa fa-users');
					$Form_Inputs->form_input_icon('Receptor - Nombre', 'Contact_Recep_name', $x25, 1,'fa fa-users');

					$Form_Inputs->form_tittle(3, 'Social');
					$Form_Inputs->form_input_text('Título', 'Social_Tittle', $x26, 1);
					$Form_Inputs->form_input_icon('Twitter', 'Social_Twitter', $x27, 1,'fa fa-twitter');
					$Form_Inputs->form_input_icon('Facebook', 'Social_Facebook', $x28, 1,'fa fa-facebook');
					$Form_Inputs->form_input_icon('Instagram', 'Social_Instagram', $x29, 1,'fa fa-instagram');
					$Form_Inputs->form_input_icon('Googleplus', 'Social_Googleplus', $x30, 1,'fa fa-google-plus');
					$Form_Inputs->form_input_icon('Linkedin', 'Social_Linkedin', $x31, 1,'fa fa-linkedin');

					$Form_Inputs->form_tittle(3, 'Nosotros');
					$Form_Inputs->form_input_text('Título', 'Nosotros_Titulo', $x32, 1);
					$Form_Inputs->form_input_text('Subtitulo', 'Nosotros_Subtitulo', $x33, 1);
					$Form_Inputs->form_textarea('Texto', 'Nosotros_Texto', $x34, 1);
					$Form_Inputs->form_input_icon('Link Video', 'Nosotros_Link', $x35, 1,'fa fa-link');

					$Form_Inputs->form_input_hidden('idSitio', simpleDecode($_GET['id'], fecha_actual()), 2);
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
