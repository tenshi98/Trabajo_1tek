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
$original = "transportes_listado.php";
$location = $original;
$new_location = "transportes_listado_clientes.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_GET['cliente_add'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'cliente_add';
	require_once 'A1XRXS_sys/xrxs_form/transportes_listado_clientes.php';
}
//se borra un dato
if (!empty($_GET['cliente_del'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'cliente_del';
	require_once 'A1XRXS_sys/xrxs_form/transportes_listado_clientes.php';
}
//formulario para crear
if (!empty($_GET['prm_add_all'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'prm_add_all';
	require_once 'A1XRXS_sys/xrxs_form/transportes_listado_clientes.php';
}
//se borra un dato
if (!empty($_GET['prm_del_all'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'prm_del_all';
	require_once 'A1XRXS_sys/xrxs_form/transportes_listado_clientes.php';
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
$query = "SELECT Nombre
FROM `transportes_listado`
WHERE idTransporte = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

/**********************************************************************/
$arrEquipos = array();
$query = "SELECT 
clientes_listado.idCliente,
clientes_listado.Nombre,
(SELECT COUNT(idRelacion) FROM transportes_listado_clientes WHERE idCliente = clientes_listado.idCliente AND idTransporte = ".$_GET['id']." LIMIT 1) AS contar,
(SELECT idRelacion FROM transportes_listado_clientes WHERE idCliente = clientes_listado.idCliente AND idTransporte = ".$_GET['id']." LIMIT 1) AS idpermiso
FROM `clientes_listado`
WHERE idEstado = 1
ORDER BY clientes_listado.Nombre ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrEquipos,$row );
}



?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Transportista', $rowData['Nombre'], 'Editar Datos Básicos'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'transportes_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'transportes_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'transportes_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'transportes_listado_datos_persona_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<li class=""><a href="<?php echo 'transportes_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<li class=""><a href="<?php echo 'transportes_listado_datos_bancarios.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-university" aria-hidden="true"></i> Datos Bancarios</a></li>
						<li class=""><a href="<?php echo 'transportes_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'transportes_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
						<li class=""><a href="<?php echo 'transportes_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
						<li class="active"><a href="<?php echo 'transportes_listado_clientes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-users" aria-hidden="true"></i> Clientes Relacionados</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">

			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th width="10">Acciones</th>
					</tr>
					<?php echo widget_sherlock(1, 2, 'TableFiltered'); ?>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
					<tr class="odd" >
						<td style="background-color:#DDD">
							<strong>Asignar Todos los clientes</strong>
						</td>
						<td style="background-color:#DDD">
							<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
								<a href="<?php echo $new_location.'&id='.$_GET['id'].'&prm_del_all=true'.'&idTransporte='.$_GET['id']; ?>" title="Quitar todos los permisos" class="btn btn-sm btn-default unlocked_inactive tooltip">OFF</a>
								<a href="<?php echo $new_location.'&id='.$_GET['id'].'&prm_add_all=true'.'&idTransporte='.$_GET['id']; ?>" title="Asignar todos los permisos" class="btn btn-sm btn-default unlocked_inactive tooltip">ON</a>
							</div>
						</td>
					</tr>
					<?php 
					foreach ($arrEquipos as $equipos) { ?>
					<tr class="odd">
						<td><?php echo '<strong>Cliente: </strong>'.$equipos['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
								<?php if ( isset($equipos['contar'])&&$equipos['contar']!='0' ){ ?>    
									<a title="Quitar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_GET['id'].'&cliente_del='.$equipos['idpermiso']; ?>">OFF</a>
									<a title="Dar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">ON</a>
								<?php } else { ?>
									<a title="Quitar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">OFF</a>
									<a title="Dar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_GET['id'].'&cliente_add='.$equipos['idCliente']; ?>">ON</a>
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
