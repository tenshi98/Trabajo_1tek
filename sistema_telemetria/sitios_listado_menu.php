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
$new_location = "sitios_listado_menu.php";
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
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado_menu.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado_menu.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//se agregan ubicaciones
	$location = $new_location;
	$location.= '&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado_menu.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Menu Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Menu Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Menu Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
// consulto los datos
$SIS_query = 'idPosicion,Nombre,Link,idNewTab,idPopup,idEstado';
$SIS_join  = '';
$SIS_where = 'idMenu ='.$_GET['edit'];
$rowData = db_select_data (false, $SIS_query, 'sitios_listado_menu', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Menu</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se dibujan los inputs
				if(isset($idPosicion)){  $x1 = $idPosicion;  }else{$x1 = $rowData['idPosicion'];}
				if(isset($Nombre)){      $x2 = $Nombre;      }else{$x2 = $rowData['Nombre'];}
				if(isset($Link)){        $x3 = $Link;        }else{$x3 = $rowData['Link'];}
				if(isset($idNewTab)){    $x4 = $idNewTab;    }else{$x4 = $rowData['idNewTab'];}
				if(isset($idPopup)){     $x5 = $idPopup;     }else{$x5 = $rowData['idPopup'];}
				if(isset($idEstado)){    $x6 = $idEstado;    }else{$x6 = $rowData['idEstado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('Posicion','idPosicion', $x1, 2, 1, 100 );
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);

				$Form_Inputs->form_post_data(2,1,1, 'Puede ser un enlace o una referencia (#id).' );
				$Form_Inputs->form_input_text('Link', 'Link', $x3, 2);

				$Form_Inputs->form_post_data(2,1,1, 'Abrir el enlace en una nueva pestaña.' );
				$Form_Inputs->form_select('Uso de tabs','idNewTab', $x4, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_post_data(2,1,1, 'Abrir ventana en una ventana emergente.' );
				$Form_Inputs->form_select('Uso Popup','idPopup', $x5, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_post_data(2,1,1, 'Usar o no usar este menu.' );
				$Form_Inputs->form_select('Estado','idEstado', $x6, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

				$Form_Inputs->form_input_hidden('idMenu', $_GET['edit'], 2);
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
			<h5>Crear Menu</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se dibujan los inputs
				if(isset($idPosicion)){  $x1 = $idPosicion;  }else{$x1 = '';}
				if(isset($Nombre)){      $x2 = $Nombre;      }else{$x2 = '';}
				if(isset($Link)){        $x3 = $Link;        }else{$x3 = '';}
				if(isset($idNewTab)){    $x4 = $idNewTab;    }else{$x4 = '';}
				if(isset($idPopup)){     $x5 = $idPopup;     }else{$x5 = '';}
				if(isset($idEstado)){    $x6 = $idEstado;    }else{$x6 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('Posicion','idPosicion', $x1, 2, 1, 100 );
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);

				$Form_Inputs->form_post_data(2,1,1, 'Puede ser un enlace o una referencia (#id).' );
				$Form_Inputs->form_input_text('Link', 'Link', $x3, 2);

				$Form_Inputs->form_post_data(2,1,1, 'Abrir el enlace en una nueva pestaña.' );
				$Form_Inputs->form_select('Uso de tabs','idNewTab', $x4, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_post_data(2,1,1, 'Abrir ventana en una ventana emergente.' );
				$Form_Inputs->form_select('Uso Popup','idPopup', $x5, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_post_data(2,1,1, 'Usar o no usar este menu.' );
				$Form_Inputs->form_select('Estado','idEstado', $x6, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

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
//Permisos a sistemas
$SIS_query = '
sitios_listado_menu.idMenu,
sitios_listado_menu.Nombre,
sitios_listado_menu.Link,
sitios_listado_menu.idEstado,
sitios_listado_menu.idPosicion,
core_estados.Nombre AS Estado,
menu_opc1.Nombre AS NewTab,
menu_opc2.Nombre AS Popup';
$SIS_join  = '
LEFT JOIN `core_estados`                       ON core_estados.idEstado   = sitios_listado_menu.idEstado
LEFT JOIN `core_sistemas_opciones` menu_opc1   ON menu_opc1.idOpciones    = sitios_listado_menu.idNewTab
LEFT JOIN `core_sistemas_opciones` menu_opc2   ON menu_opc2.idOpciones    = sitios_listado_menu.idPopup';
$SIS_where = 'sitios_listado_menu.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$SIS_order = 'sitios_listado_menu.idPosicion ASC';
$arrMenu = array();
$arrMenu = db_select_array (false, $SIS_query, 'sitios_listado_menu', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMenu');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sitio', $rowData['Nombre'], 'Elementos Menu'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Menu</a><?php } ?>
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
						<?php if(isset($rowData['Config_Menu'])&&$rowData['Config_Menu']==1){ ?>            <li class="active"><a href="<?php echo 'sitios_listado_menu.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu</a></li><?php } ?>
						<?php if(isset($rowData['Config_MenuOtros'])&&$rowData['Config_MenuOtros']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_menu_otros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu Otros</a></li><?php } ?>
						<?php if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==1){ ?>    <li class=""><a href="<?php echo 'sitios_listado_carousel.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Carousel</a></li><?php } ?>
						<?php if(isset($rowData['Config_Links_Rel'])&&$rowData['Config_Links_Rel']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_links.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-link" aria-hidden="true"></i> Links Relacionados</a></li><?php } ?>

						<li class=""><a href="<?php echo 'sitios_listado_body.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Body</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="10">Posicion</th>
						<th>Nombre</th>
						<th>Enlace</th>
						<th>Estado</th>
						<th>NewTab</th>
						<th>Popup</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
					<?php foreach ($arrMenu as $menu) { ?>
						<tr class="odd">
							<td><?php echo $menu['idPosicion']; ?></td>
							<td><?php echo $menu['Nombre']; ?></td>
							<td><?php echo $menu['Link']; ?></td>
							<td><label class="label <?php if(isset($menu['idEstado'])&&$menu['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $menu['Estado']; ?></label></td>
							<td><?php echo $menu['NewTab']; ?></td>
							<td><?php echo $menu['Popup']; ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$menu['idMenu']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=3){
										$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($menu['idMenu'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el menu '.$menu['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
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
