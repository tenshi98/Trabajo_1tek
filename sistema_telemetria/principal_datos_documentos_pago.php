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
$new_location = "principal_datos_documentos_pago.php";
$location .= '?d=d';
$new_location .= '?d=d';

/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_GET['doc_add'])){
	//nuevas ubicaciones
	$location = $new_location;
	$location.='&id='.$_SESSION['usuario']['basic_data']['idUsuario'];
	//Llamamos al formulario
	$form_trabajo= 'doc_add';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['doc_del'])){
	//nuevas ubicaciones
	$location = $new_location;
	$location.='&id='.$_SESSION['usuario']['basic_data']['idUsuario'];
	//Llamamos al formulario
	$form_trabajo= 'doc_del';
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
//Listo los documentos de pago
$SIS_query = '
sistema_documentos_pago.idDocPago,
sistema_documentos_pago.Nombre,
(SELECT COUNT(idDocPagoPermiso) FROM usuarios_documentos_pago WHERE idDocPago = sistema_documentos_pago.idDocPago AND idUsuario = '.$_SESSION['usuario']['basic_data']['idUsuario'].' LIMIT 1) AS contar,
(SELECT idDocPagoPermiso        FROM usuarios_documentos_pago WHERE idDocPago = sistema_documentos_pago.idDocPago AND idUsuario = '.$_SESSION['usuario']['basic_data']['idUsuario'].' LIMIT 1) AS idpermiso';
$SIS_join  = '';
$SIS_where = '';
$SIS_order = '';
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, $SIS_query, 'sistema_documentos_pago', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDocumentos');

/*************************************************/
//permisos a las transacciones
$trans[1] = "pago_masivo_cliente.php";           //Pagos clientes
$trans[2] = "pago_masivo_proveedor.php";         //Pagos Proveedores
$trans[3] = "pago_masivo_cliente_reversa.php";   //Reversa Pagos clientes
$trans[4] = "pago_masivo_proveedor_reversa.php"; //Reversa Pagos Proveedores

//Genero los permisos
for ($i = 1; $i <= 4; $i++) {
	//Seteo la variable a 0
	$prm_x[$i] = 0;
	//recorro los permisos
	if(isset($_SESSION['usuario']['menu'])){
		foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
			foreach($productos as $producto) {
				//elimino los datos extras
				$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
				//le asigno el valor 1 en caso de que exista
				if($trans[$i]==$str){
					$prm_x[$i] = 1;
				}
			}
		}
	}
}
//verifico permisos
$Count_pagos = $prm_x[1] + $prm_x[2] + $prm_x[3] + $prm_x[4];

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Perfil', $_SESSION['usuario']['basic_data']['Nombre'], 'Editar Documentos de Pago'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Personales</a></li>
				<li class=""><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Cambiar Imagen</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Cambiar Contraseña</a></li>
						<?php if($Count_pagos!=0){ ?>
							<li class="active"><a href="<?php echo 'principal_datos_documentos_pago.php'?>" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Documentos Pago</a></li>
						<?php } ?>
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
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrDocumentos as $permiso) { ?>
						<tr class="odd">
							<td><?php echo '<strong>Documento: </strong>'.$permiso['Nombre']; ?></td>
							<td>
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php if ( $permiso['contar']=='1' ){ ?>
										<a title="Quitar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_SESSION['usuario']['basic_data']['idUsuario'].'&doc_del='.$permiso['idpermiso']; ?>">OFF</a>
										<a title="Dar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">ON</a>
									<?php } else { ?>
										<a title="Quitar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">OFF</a>
										<a title="Dar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_SESSION['usuario']['basic_data']['idUsuario'].'&doc_add='.$permiso['idDocPago']; ?>">ON</a>
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
