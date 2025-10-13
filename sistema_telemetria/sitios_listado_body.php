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
$new_location = "sitios_listado_body.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado_body.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado_body.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado_body.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Cuerpo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Cuerpo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Cuerpo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
// consulto los datos
$SIS_query = 'idTipo,Icono,IconoStyle,Titulo,TituloStyle,Texto,TextoStyle,LinkNombre,
LinkStyle,LinkURL,idNewTab,idPopup,idEstado,idPosicion,Imagen';
$SIS_join  = '';
$SIS_where = 'idBody ='.$_GET['edit'];
$rowData = db_select_data (false, $SIS_query, 'sitios_listado_body', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Cuerpo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTipo)){        $x0  = $idTipo;        }else{$x0  = $rowData['idTipo'];}
				if(isset($idPosicion)){    $x1  = $idPosicion;    }else{$x1  = $rowData['idPosicion'];}
				if(isset($Icono)){         $x2  = $Icono;         }else{$x2  = $rowData['Icono'];}
				if(isset($IconoStyle)){    $x3  = $IconoStyle;    }else{$x3  = $rowData['IconoStyle'];}
				if(isset($Titulo)){        $x4  = $Titulo;        }else{$x4  = $rowData['Titulo'];}
				if(isset($TituloStyle)){   $x5  = $TituloStyle;   }else{$x5  = $rowData['TituloStyle'];}
				if(isset($Texto)){         $x6  = $Texto;         }else{$x6  = $rowData['Texto'];}
				if(isset($TextoStyle)){    $x7  = $TextoStyle;    }else{$x7  = $rowData['TextoStyle'];}
				if(isset($LinkNombre)){    $x8  = $LinkNombre;    }else{$x8  = $rowData['LinkNombre'];}
				if(isset($LinkStyle)){     $x9  = $LinkStyle;     }else{$x9  = $rowData['LinkStyle'];}
				if(isset($LinkURL)){       $x10 = $LinkURL;       }else{$x10 = $rowData['LinkURL'];}
				if(isset($idNewTab)){      $x11 = $idNewTab;      }else{$x11 = $rowData['idNewTab'];}
				if(isset($idPopup)){       $x12 = $idPopup;       }else{$x12 = $rowData['idPopup'];}
				if(isset($Imagen)){        $x13 = $Imagen;        }else{$x13 = $rowData['Imagen'];}
				if(isset($idEstado)){      $x14 = $idEstado;      }else{$x14 = $rowData['idEstado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo','idTipo', $x0, 2, 'idTipo', 'Nombre', 'core_sitios_tipos_body', 0, '', $dbConn);
				$Form_Inputs->form_select_n_auto('Posicion','idPosicion', $x1, 2, 1, 100 );

				$Form_Inputs->form_post_data(2,1,1, 'Icono del Body (Opcional).' );
				$Form_Inputs->form_input_text('Icono', 'Icono', $x2, 1);
				$Form_Inputs->form_input_icon('Estilo del Icono', 'IconoStyle', $x3, 1,'fa fa-file-image-o');

				$Form_Inputs->form_post_data(2,1,1, 'Titulo del Body (Opcional).' );
				$Form_Inputs->form_input_text('Título', 'Titulo', $x4, 1);
				$Form_Inputs->form_input_icon('Estilo del Titulo', 'TituloStyle', $x5, 1,'fa fa-file-image-o');

				$Form_Inputs->form_post_data(2,1,1, 'Texto del Body (Opcional).' );
				$Form_Inputs->form_textarea('Texto', 'Texto', $x6, 1);
				$Form_Inputs->form_input_icon('Estilo del Texto', 'TextoStyle', $x7, 1,'fa fa-file-image-o');

				$Form_Inputs->form_post_data(2,1,1, 'Enlace del Body (Opcional).' );
				$Form_Inputs->form_input_text('Nombre del enlace', 'LinkNombre', $x8, 1);
				$Form_Inputs->form_input_icon('Estilo del enlace', 'LinkStyle', $x9, 1,'fa fa-file-image-o');
				$Form_Inputs->form_input_text('Enlace (Link o referencia)', 'LinkURL', $x10, 1);
				$Form_Inputs->form_select('Abrir en una nueva pestaña','idNewTab', $x11, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_select('Abrir en ventana emergente','idPopup', $x12, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_post_data(2,1,1, 'Imagen de fondo del Body (Opcional).' );
				$Form_Inputs->form_input_icon('Imagen', 'Imagen', $x13, 1,'fa fa-file-image-o');

				$Form_Inputs->form_post_data(2,1,1, 'Estado del Body (Opcional).' );
				$Form_Inputs->form_select('Estado','idEstado', $x14, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idBody', $_GET['edit'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Cuerpo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTipo)){        $x0  = $idTipo;        }else{$x0  = '';}
				if(isset($idPosicion)){    $x1  = $idPosicion;    }else{$x1  = '';}
				if(isset($Icono)){         $x2  = $Icono;         }else{$x2  = '';}
				if(isset($IconoStyle)){    $x3  = $IconoStyle;    }else{$x3  = '';}
				if(isset($Titulo)){        $x4  = $Titulo;        }else{$x4  = '';}
				if(isset($TituloStyle)){   $x5  = $TituloStyle;   }else{$x5  = '';}
				if(isset($Texto)){         $x6  = $Texto;         }else{$x6  = '';}
				if(isset($TextoStyle)){    $x7  = $TextoStyle;    }else{$x7  = '';}
				if(isset($LinkNombre)){    $x8  = $LinkNombre;    }else{$x8  = '';}
				if(isset($LinkStyle)){     $x9  = $LinkStyle;     }else{$x9  = '';}
				if(isset($LinkURL)){       $x10 = $LinkURL;       }else{$x10 = '';}
				if(isset($idNewTab)){      $x11 = $idNewTab;      }else{$x11 = '';}
				if(isset($idPopup)){       $x12 = $idPopup;       }else{$x12 = '';}
				if(isset($Imagen)){        $x13 = $Imagen;        }else{$x13 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo','idTipo', $x0, 2, 'idTipo', 'Nombre', 'core_sitios_tipos_body', 0, '', $dbConn);
				$Form_Inputs->form_select_n_auto('Posicion','idPosicion', $x1, 2, 1, 100 );

				$Form_Inputs->form_post_data(2,1,1, 'Icono del Body (Opcional).' );
				$Form_Inputs->form_input_text('Icono', 'Icono', $x2, 1);
				$Form_Inputs->form_input_icon('Estilo del Icono', 'IconoStyle', $x3, 1,'fa fa-file-image-o');

				$Form_Inputs->form_post_data(2,1,1, 'Titulo del Body (Opcional).' );
				$Form_Inputs->form_input_text('Título', 'Titulo', $x4, 1);
				$Form_Inputs->form_input_icon('Estilo del Titulo', 'TituloStyle', $x5, 1,'fa fa-file-image-o');

				$Form_Inputs->form_post_data(2,1,1, 'Texto del Body (Opcional).' );
				$Form_Inputs->form_textarea('Texto', 'Texto', $x6, 1);
				$Form_Inputs->form_input_icon('Estilo del Texto', 'TextoStyle', $x7, 1,'fa fa-file-image-o');

				$Form_Inputs->form_post_data(2,1,1, 'Enlace del Body (Opcional).' );
				$Form_Inputs->form_input_text('Nombre del enlace', 'LinkNombre', $x8, 1);
				$Form_Inputs->form_input_icon('Estilo del enlace', 'LinkStyle', $x9, 1,'fa fa-file-image-o');
				$Form_Inputs->form_input_text('Enlace (Link o referencia)', 'LinkURL', $x10, 1);
				$Form_Inputs->form_select('Abrir en una nueva pestaña','idNewTab', $x11, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_select('Abrir en ventana emergente','idPopup', $x12, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_post_data(2,1,1, 'Imagen de fondo del Body (Opcional).' );
				$Form_Inputs->form_input_icon('Imagen', 'Imagen', $x13, 1,'fa fa-file-image-o');

				$Form_Inputs->form_input_hidden('idSitio', simpleDecode($_GET['id'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
// consulto los datos
$SIS_query = 'Nombre,Config_Menu,Config_MenuOtros,Config_Carousel,Config_Links_Rel';
$SIS_join  = '';
$SIS_where = 'idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'sitios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/**********************************/
//listado de bodys
$SIS_query = '
sitios_listado_body.idBody,
sitios_listado_body.idTipo,
sitios_listado_body.idPosicion,
sitios_listado_body.Titulo,
core_sitios_tipos_body.Nombre AS Tipo,
sitios_listado_body.idEstado,
core_estados.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `core_sitios_tipos_body` ON core_sitios_tipos_body.idTipo = sitios_listado_body.idTipo
LEFT JOIN `core_estados`           ON core_estados.idEstado         = sitios_listado_body.idEstado';
$SIS_where = 'sitios_listado_body.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$SIS_order = 'core_sitios_tipos_body.Nombre ASC, sitios_listado_body.idPosicion ASC';
$arrBody = array();
$arrBody = db_select_array (false, $SIS_query, 'sitios_listado_body', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBody');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sitio', $rowData['Nombre'], 'Elementos Cuerpo'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Cuerpo</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'sitios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'sitios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'sitios_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if(isset($rowData['Config_Menu'])&&$rowData['Config_Menu']==1){ ?>            <li class=""><a href="<?php echo 'sitios_listado_menu.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu</a></li><?php } ?>
						<?php if(isset($rowData['Config_MenuOtros'])&&$rowData['Config_MenuOtros']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_menu_otros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu Otros</a></li><?php } ?>
						<?php if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==1){ ?>    <li class=""><a href="<?php echo 'sitios_listado_carousel.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Carousel</a></li><?php } ?>
						<?php if(isset($rowData['Config_Links_Rel'])&&$rowData['Config_Links_Rel']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_body.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-link" aria-hidden="true"></i> Links Relacionados</a></li><?php } ?>

						<li class="active"><a href="<?php echo 'sitios_listado_body.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Body</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="10">Posicion</th>
						<th>Titulo</th>
						<th width="10">Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
					<?php
					filtrar($arrBody, 'idTipo');
					foreach($arrBody as $Tipo=>$TipoBody){
						echo '<tr class="odd" >
							<td style="background-color:#DDD" colspan="4"><strong>'.$TipoBody[0]['Tipo'].'</strong></td>
						</tr>';
						foreach ($TipoBody as $tipos) { ?>
							<tr class="odd">
								<td><?php echo $tipos['idPosicion']; ?></td>
								<td><?php echo $tipos['Titulo']; ?></td>
								<td><label class="label <?php if(isset($tipos['idEstado'])&&$tipos['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $tipos['Estado']; ?></label></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$tipos['idBody']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php
										$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($tipos['idBody'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el body '.$tipos['Titulo'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>
					                  
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
