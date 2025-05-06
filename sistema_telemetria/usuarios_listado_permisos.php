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
$original = "usuarios_listado.php";
$location = $original;
$new_location = "usuarios_listado_permisos.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_GET['prm_add'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	$location.='#'.$_GET['anclaje'];
	//Llamamos al formulario
	$form_trabajo= 'prm_add';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['prm_del'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	$location.='#'.$_GET['anclaje'];
	//Llamamos al formulario
	$form_trabajo= 'prm_del';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//formulario para crear
if (!empty($_GET['prm_cat_add'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	$location.='#subcat_'.$_GET['anclaje'];
	//Llamamos al formulario
	$form_trabajo= 'prm_cat_add';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['prm_cat_del'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	$location.='#subcat_'.$_GET['anclaje'];
	//Llamamos al formulario
	$form_trabajo= 'prm_cat_del';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['perm'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	$location.='#'.$_GET['anclaje'];
	//Llamamos al formulario
	$form_trabajo= 'perm';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idUsuario ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/********************************************************************************/
/********************************************************************************/
//Se verifican los permisos que tiene el usuario seleccionado
$SIS_query = '
core_permisos_listado.idAdmpm,
core_permisos_listado.Nombre AS Nombre_permiso,
core_permisos_listado.Descripcion,
core_permisos_listado.Habilita,
core_permisos_listado.Principal,
core_permisos_listado.Level_Limit,
core_permisos_listado.id_pmcat,
core_permisos_categorias.Nombre AS Categoria,
core_permisos_listado.visualizacion,
core_sistemas.Nombre AS ver,
(SELECT COUNT(idPermisos)  FROM usuarios_permisos WHERE idAdmpm = core_permisos_listado.idAdmpm AND idUsuario = '.$_GET['id'].' LIMIT 1) AS contar,
(SELECT idPermisos         FROM usuarios_permisos WHERE idAdmpm = core_permisos_listado.idAdmpm AND idUsuario = '.$_GET['id'].' LIMIT 1) AS idpermiso,
(SELECT level              FROM usuarios_permisos WHERE idAdmpm = core_permisos_listado.idAdmpm AND idUsuario = '.$_GET['id'].' LIMIT 1) AS level';
$SIS_join  = '
INNER JOIN `core_permisos_categorias` ON core_permisos_categorias.id_pmcat = core_permisos_listado.id_pmcat
LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema           = core_permisos_listado.visualizacion';
$SIS_where = 'core_permisos_listado.idAdmpm>=0';
$SIS_where.= ' AND (core_permisos_listado.visualizacion='.$_SESSION['usuario']['basic_data']['idSistema'].' OR core_permisos_listado.visualizacion=9998)';
$SIS_order = 'core_permisos_categorias.Nombre ASC, core_permisos_listado.Nombre ASC';
$arrPermisos = array();
$arrPermisos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermiso');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Usuario', $rowData['Nombre'], 'Editar Permisos Asignados'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'usuarios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'usuarios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class="active"><a href="<?php echo 'usuarios_listado_permisos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Permisos</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'usuarios_listado_sistemas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Acceso Sistemas</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_tipo.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-adjust" aria-hidden="true"></i> Tipo</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_equipos_telemetria.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Equipos telemetria</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_notificaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-comment-o" aria-hidden="true"></i> Notificaciones Alertas</a></li>
					</ul>
                </li>
			</ul>
		</header>

        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="10">Ayuda</th>
						<th>Permisos</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="10">Visualizacion</th><?php } ?>
						<th width="10">Acciones</th>
						<th width="10">Nivel</th>
					</tr>
					<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){$colspan=5;}else{$colspan=4;} ?>
					<?php echo widget_sherlock(1, $colspan, 'TableFiltered'); ?>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
					<?php
					//Obtengo la ubicacion completa para devolver al punto inicial
					$xxx ='&id='.$_GET['id'];//Ciclo
					filtrar($arrPermisos, 'Categoria');
					foreach ($arrPermisos as $categoria=>$subcategorias) {  ?>
						<tr class="odd" >
							<td colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ echo '4';}else{echo '3';} ?>" style="background-color:#DDD">
								<a name="<?php echo 'subcat_'.$subcategorias[0]['id_pmcat']; ?>"></a>
								<strong><?php echo $categoria; ?></strong>
							</td>
							<td style="background-color:#DDD">
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<a href="<?php echo $new_location.$xxx.'&anclaje='.$subcategorias[0]['id_pmcat'].'&prm_cat_del='.simpleEncode($subcategorias[0]['id_pmcat'], fecha_actual()); ?>" title="Quitar todos los permisos de esta categoria" class="btn btn-sm btn-default unlocked_inactive tooltip">OFF</a>
									<a href="<?php echo $new_location.$xxx.'&anclaje='.$subcategorias[0]['id_pmcat'].'&prm_cat_add='.simpleEncode($subcategorias[0]['id_pmcat'], fecha_actual()); ?>" title="Asignar todos los permisos de esta categoria" class="btn btn-sm btn-default unlocked_inactive tooltip">ON</a>
								</div>
							</td>
						</tr>
						<?php foreach ($subcategorias as $permiso){ ?>
							<tr>
								<td>
									<a name="<?php echo $permiso['idAdmpm'] ?>"></a>
									<?php if(isset($permiso['Descripcion'])&&$permiso['Descripcion']!=''){ ?>
										<a title="<?php echo $permiso['Descripcion']; ?>" class="btn btn-primary btn-sm tooltip"><i class="fa fa-question" aria-hidden="true"></i></a>
									<?php } ?>
								</td>
								<td>
									<?php echo ' '.TituloMenu($permiso['Nombre_permiso']).' '; ?>
									<div class="btn-group" style="width: 140px;" >
										<?php if(isset($permiso['Habilita'])&&$permiso['Habilita']!=''){ ?><a title="<?php echo $permiso['Habilita']; ?>" class="btn btn-success btn-sm tooltip"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a><?php } ?>
										<?php if(isset($permiso['Principal'])&&$permiso['Principal']!=''){ ?><a title="<?php echo $permiso['Principal']; ?>" class="btn btn-info btn-sm tooltip"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a><?php } ?>

									</div>
								</td>
								<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php if($permiso['visualizacion']==9999){echo 'Solo Superadministradores';}elseif($permiso['visualizacion']==9998){echo 'Todos';}else{echo $permiso['ver'];} ?></td><?php } ?>
								<td>
									<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
										<?php $w='&anclaje='.$permiso['idAdmpm']; ?>
										<?php if ( $permiso['contar']=='1' ){ ?>
											<a title="Quitar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.$xxx; ?>&prm_del=<?php echo simpleEncode($permiso['idpermiso'], fecha_actual()).$w; ?>">OFF</a>
											<a title="Dar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">ON</a>
										<?php } else { ?>
											<a title="Quitar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">OFF</a>
											<a title="Dar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.$xxx; ?>&prm_add=<?php echo $permiso['idAdmpm'].$w; ?>">ON</a>
										<?php } ?>
									</div>
								</td>
								<td>
									<div class="btn-group" style="width: 140px;" id="toggle_event_editing">
										<?php if ($permiso['level'] > 0){ ?>
											<?php if ($permiso['Level_Limit'] >= 1){ ?><a href="<?php echo $new_location.$xxx.'&perm='.$permiso['idpermiso'].'&mod=1'.$w ?>" title="Solo ver"                       class="btn btn-sm unlocked_inactive tooltip <?php if ($permiso['level'] == 1) { echo 'btn-info';}else{ echo 'btn-default';} ?>">1</a><?php } ?>
											<?php if ($permiso['Level_Limit'] >= 2){ ?><a href="<?php echo $new_location.$xxx.'&perm='.$permiso['idpermiso'].'&mod=2'.$w ?>" title="Ver - Editar"                   class="btn btn-sm unlocked_inactive tooltip <?php if ($permiso['level'] == 2) { echo 'btn-info';}else{ echo 'btn-default';} ?>">2</a><?php } ?>
											<?php if ($permiso['Level_Limit'] >= 3){ ?><a href="<?php echo $new_location.$xxx.'&perm='.$permiso['idpermiso'].'&mod=3'.$w ?>" title="Ver - Editar - Crear"           class="btn btn-sm unlocked_inactive tooltip <?php if ($permiso['level'] == 3) { echo 'btn-info';}else{ echo 'btn-default';} ?>">3</a><?php } ?>
											<?php if ($permiso['Level_Limit'] >= 4){ ?><a href="<?php echo $new_location.$xxx.'&perm='.$permiso['idpermiso'].'&mod=4'.$w ?>" title="Ver - Editar - Crear - Borrar"  class="btn btn-sm unlocked_inactive tooltip <?php if ($permiso['level'] == 4) { echo 'btn-info';}else{ echo 'btn-default';} ?>">4</a><?php } ?>
										<?php } ?>
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

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
