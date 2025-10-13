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
$original = "admin_datos.php";
$location = $original;
$new_location = "admin_datos_datos_variedades_nombres.php";
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_GET['sis_variedad_add'])){
	//Nueva ubicacion
	$location = $new_location;
	$location.='?bla=bla';
	//Llamamos al formulario
	$form_trabajo= 'sis_variedad_add';
	require_once 'A1XRXS_sys/xrxs_form/core_sistemas.php';
}
//se borra un dato
if (!empty($_GET['sis_variedad_del'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='?bla=bla';
	//Llamamos al formulario
	$form_trabajo= 'sis_variedad_del';
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
if (isset($_GET['edited'])){$error['edited'] = 'sucess/Permiso asignado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// consulto los datos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'core_sistemas.idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'];
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

//Listado de productos
$SIS_query = '
variedades_listado.idProducto,
variedades_listado.Nombre,
sistema_variedades_categorias.Nombre AS Categoria,
(SELECT COUNT(idSisProd) FROM core_sistemas_variedades_listado WHERE idProducto = variedades_listado.idProducto AND idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' LIMIT 1) AS contar,
(SELECT idSisProd        FROM core_sistemas_variedades_listado WHERE idProducto = variedades_listado.idProducto AND idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' LIMIT 1) AS idpermiso';
$SIS_join  = '
LEFT JOIN `variedades_listado`             ON variedades_listado.idCategoria             = core_sistemas_variedades_categorias.idCategoria
LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = variedades_listado.idCategoria';
$SIS_where = 'core_sistemas_variedades_categorias.idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' AND variedades_listado.idEstado = 1';
$SIS_order = 'variedades_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'core_sistemas_variedades_categorias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

/******************************************************/
//Accesos a bodegas de productos
$trans_1 = "bodegas_productos_egreso.php";
$trans_2 = "bodegas_productos_ingreso.php";
$trans_3 = "bodegas_productos_simple_stock.php";
$trans_4 = "bodegas_productos_stock.php";
$trans_5 = "productores_listado.php";

//Accesos a bodegas de insumos
$trans_11 = "bodegas_insumos_egreso.php";
$trans_12 = "bodegas_insumos_ingreso.php";
$trans_13 = "bodegas_insumos_simple_stock.php";
$trans_14 = "bodegas_insumos_stock.php";
$trans_15 = "insumos_listado.php";

//Accesos a Ordenes de Trabajo
$trans_21 = "orden_trabajo_crear.php";
$trans_22 = "orden_trabajo_terminar.php";

//Accesos a Ordenes de Compra
$trans_26 = "ocompra_generacion.php";
$trans_27 = "ocompra_listado_sin_aprobar.php";

//Accesos al sistema 1tek
$trans_31 = "sistema_variedades_categorias.php";
$trans_32 = "sistema_variedades_tipo.php";
$trans_33 = "variedades_listado.php";
$trans_34 = "cross_quality_registrar_inspecciones.php";
$trans_35 = "cross_shipping_consolidacion.php";
$trans_36 = "cross_shipping_consolidacion_aprobar.php";
$trans_37 = "cross_shipping_consolidacion_aprobar_auto.php";

/************************************/
//realizo la consulta
$SIS_query = '
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_1.'"  AND visualizacion!=9999 LIMIT 1) AS tran_1,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_2.'"  AND visualizacion!=9999 LIMIT 1) AS tran_2,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_3.'"  AND visualizacion!=9999 LIMIT 1) AS tran_3,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_4.'"  AND visualizacion!=9999 LIMIT 1) AS tran_4,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_5.'"  AND visualizacion!=9999 LIMIT 1) AS tran_5,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_11.'"  AND visualizacion!=9999 LIMIT 1) AS tran_11,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_12.'"  AND visualizacion!=9999 LIMIT 1) AS tran_12,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_13.'"  AND visualizacion!=9999 LIMIT 1) AS tran_13,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_14.'"  AND visualizacion!=9999 LIMIT 1) AS tran_14,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_15.'"  AND visualizacion!=9999 LIMIT 1) AS tran_15,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_21.'"  AND visualizacion!=9999 LIMIT 1) AS tran_21,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_22.'"  AND visualizacion!=9999 LIMIT 1) AS tran_22,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_26.'"  AND visualizacion!=9999 LIMIT 1) AS tran_26,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_27.'"  AND visualizacion!=9999 LIMIT 1) AS tran_27,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_31.'"  AND visualizacion!=9999 LIMIT 1) AS tran_31,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_32.'"  AND visualizacion!=9999 LIMIT 1) AS tran_32,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_33.'"  AND visualizacion!=9999 LIMIT 1) AS tran_33,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_34.'"  AND visualizacion!=9999 LIMIT 1) AS tran_34,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_35.'"  AND visualizacion!=9999 LIMIT 1) AS tran_35,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_36.'"  AND visualizacion!=9999 LIMIT 1) AS tran_36,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ="'.$trans_37.'"  AND visualizacion!=9999 LIMIT 1) AS tran_37,

idUsuario';
$SIS_join  = '';
$SIS_where = 'usuarios_listado.idUsuario=1';
$rowData_x = db_select_data (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData_x');

//verifico que sea un administrador
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	//Totales de los permisos que se pueden acceder
	$Count_productos    = 1;
	$Count_insumos      = 1;
	$Count_OT           = 1;
	$Count_OC           = 1;
	$Count_Variedades   = 1;
	$Count_Shipping     = 1;
}else{
	//Totales de los permisos que se pueden acceder
	$Count_productos    = $rowData_x['tran_1'] + $rowData_x['tran_2'] + $rowData_x['tran_3'] + $rowData_x['tran_4'] + $rowData_x['tran_5'];
	$Count_insumos      = $rowData_x['tran_11'] + $rowData_x['tran_12'] + $rowData_x['tran_13'] + $rowData_x['tran_14'] + $rowData_x['tran_15'];
	$Count_OT           = $rowData_x['tran_21'] + $rowData_x['tran_22'];
	$Count_OC           = $rowData_x['tran_26'] + $rowData_x['tran_27'];
	$Count_Variedades   = $rowData_x['tran_31'] + $rowData_x['tran_32'] + $rowData_x['tran_33'] + $rowData_x['tran_34'];
	$Count_Shipping     = $rowData_x['tran_35'] + $rowData_x['tran_36'] + $rowData_x['tran_37'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Editar Variedades Usadas'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'admin_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'admin_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'admin_datos_datos_contacto.php'; ?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'admin_datos_datos_contrato.php'; ?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Datos Contrato</a></li>
						<li class=""><a href="<?php echo 'admin_datos_datos_configuracion.php'; ?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
						<li class=""><a href="<?php echo 'admin_datos_datos_temas.php'; ?>" ><i class="fa fa-tags" aria-hidden="true"></i> Temas</a></li>
						<li class=""><a href="<?php echo 'admin_datos_datos_facturacion.php'; ?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Facturacion</a></li>
						<?php if(isset($Count_OT)&&$Count_OT!=0){ ?>
							<li class=""><a href="<?php echo 'admin_datos_datos_ot.php'; ?>" ><i class="fa fa-cogs" aria-hidden="true"></i> OT</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'admin_datos_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Logo</a></li>
						<?php if(isset($Count_OC)&&$Count_OC!=0){ ?>
							<li class=""><a href="<?php echo 'admin_datos_datos_oc.php'; ?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Aprobador OC</a></li>
						<?php } ?>
						<?php if(isset($Count_productos)&&$Count_productos!=0){ ?>
							<li class=""><a href="<?php echo 'admin_datos_datos_productos.php'; ?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Productos Usados</a></li>
						<?php } ?>
						<?php if(isset($Count_insumos)&&$Count_insumos!=0){ ?>
							<li class=""><a href="<?php echo 'admin_datos_datos_insumos.php'; ?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Insumos Usados</a></li>
						<?php } ?>
						<?php if(isset($Count_Variedades)&&$Count_Variedades!=0){ ?>
							<li class=""><a href="<?php echo 'admin_datos_datos_variedades_especies.php'; ?>" ><i class="fa fa-recycle" aria-hidden="true"></i> Especies</a></li>
							<li class="active"><a href="<?php echo 'admin_datos_datos_variedades_nombres.php'; ?>" ><i class="fa fa-recycle" aria-hidden="true"></i> Variedades</a></li>
						<?php } ?>
						<?php if(isset($Count_Shipping)&&$Count_Shipping!=0){ ?>
							<li class=""><a href="<?php echo 'admin_datos_datos_cross.php'; ?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Aprobador 1tek Shipping</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'admin_datos_datos_social.php'; ?>" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Social</a></li>
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
					<?php
					filtrar($arrProductos, 'Categoria');
					foreach($arrProductos as $Proceso=>$listproc){
						echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>Especie: '.$Proceso.'</strong></td></tr>';
						foreach ($listproc as $productos) { ?>
							<tr class="odd">
								<td><?php echo '<strong>Variedades: </strong>'.$productos['Nombre']; ?></td>
								<td>
									<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
										<?php if ( isset($productos['contar'])&&$productos['contar']!='0' ) { ?>
											<a title="Quitar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'?id='.$_SESSION['usuario']['basic_data']['idSistema'].'&sis_variedad_del='.$productos['idpermiso']; ?>">OFF</a>
											<a title="Dar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">ON</a>
										<?php } else { ?>
											<a title="Quitar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">OFF</a>
											<a title="Dar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'?id='.$_SESSION['usuario']['basic_data']['idSistema'].'&sis_variedad_add='.$productos['idProducto']; ?>">ON</a>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php }
					} ?>
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
