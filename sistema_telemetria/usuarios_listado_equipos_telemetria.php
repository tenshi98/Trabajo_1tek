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
$new_location = "usuarios_listado_equipos_telemetria.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_GET['equipo_tel_add'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'equipo_tel_add';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['equipo_tel_del'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'equipo_tel_del';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//formulario para crear
if (!empty($_GET['prm_add_all'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'prm_add_all_tel';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['prm_del_all'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'prm_del_all_tel';
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
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Permiso asignado correctamente';}
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
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
core_estados.Nombre AS Estado,
telemetria_listado.idEstado,
core_sistemas.Nombre AS RazonSocial,
(SELECT COUNT(idEquipoTelPermiso) FROM usuarios_equipos_telemetria WHERE idTelemetria = telemetria_listado.idTelemetria AND idUsuario = '.$_GET['id'].' LIMIT 1) AS contar,
(SELECT idEquipoTelPermiso FROM usuarios_equipos_telemetria WHERE idTelemetria = telemetria_listado.idTelemetria AND idUsuario = '.$_GET['id'].' LIMIT 1) AS idpermiso';
$SIS_join  = '
LEFT JOIN `core_sistemas`   ON core_sistemas.idSistema   = telemetria_listado.idSistema
LEFT JOIN `core_estados`    ON core_estados.idEstado     = telemetria_listado.idEstado';
$SIS_where = 'telemetria_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'telemetria_listado.idEstado ASC, telemetria_listado.idSistema ASC, telemetria_listado.Nombre ASC';
$arrEquipos = array();
$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Usuario', $rowData['Nombre'], 'Editar Permisos de acceso a Equipos Telemetria'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'usuarios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'usuarios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'usuarios_listado_permisos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Permisos</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'usuarios_listado_sistemas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Acceso Sistemas</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_tipo.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-adjust" aria-hidden="true"></i> Tipo</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class="active"><a href="<?php echo 'usuarios_listado_equipos_telemetria.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Equipos telemetria</a></li>
						<li class=""><a href="<?php echo 'usuarios_listado_notificaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-comment-o" aria-hidden="true"></i> Notificaciones Alertas</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th width="100">Estado</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
					<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){$colspan=4;}else{$colspan=3;} ?>
					<?php echo widget_sherlock(1, $colspan, 'TableFiltered'); ?>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
					<tr class="odd" >
						<td style="background-color:#DDD"  <?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo 'colspan="3"';}else{echo 'colspan="2"';} ?>>
							<strong>Asignar Todos los permisos</strong>
						</td>
						<td style="background-color:#DDD">
							<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
								<a href="<?php echo $new_location.'&id='.$_GET['id'].'&prm_del_all=true'.'&idUsuario='.simpleEncode($_GET['id'], fecha_actual()).'&idSistema='.simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()); ?>" title="Quitar todos los permisos" class="btn btn-sm btn-default unlocked_inactive tooltip">OFF</a>
								<a href="<?php echo $new_location.'&id='.$_GET['id'].'&prm_add_all=true'.'&idUsuario='.simpleEncode($_GET['id'], fecha_actual()).'&idSistema='.simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()); ?>" title="Asignar todos los permisos" class="btn btn-sm btn-default unlocked_inactive tooltip">ON</a>
							</div>
						</td>
					</tr>
					<?php foreach ($arrEquipos as $equipos) { ?>
						<tr class="odd">
							<td><?php echo '<strong>Equipo: </strong>'.$equipos['Nombre']; ?></td>
							<td><label class="label <?php if(isset($equipos['idEstado'])&&$equipos['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $equipos['Estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $equipos['RazonSocial']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php if ( isset($equipos['contar'])&&$equipos['contar']!='0' ){ ?>
										<a title="Quitar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_GET['id'].'&equipo_tel_del='.simpleEncode($equipos['idpermiso'], fecha_actual()); ?>">OFF</a>
										<a title="Dar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">ON</a>
									<?php } else { ?>
										<a title="Quitar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">OFF</a>
										<a title="Dar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_GET['id'].'&equipo_tel_add='.simpleEncode($equipos['idTelemetria'], fecha_actual()); ?>">ON</a>
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

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
