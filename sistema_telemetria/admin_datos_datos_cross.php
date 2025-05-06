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
$new_location = "admin_datos_datos_cross.php";
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit_new'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/sistema_aprobador_cross.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/sistema_aprobador_cross.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/sistema_aprobador_cross.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){$error['usuario'] = 'sucess/Aprobador Creado correctamente';}
if (isset($_GET['edited'])){$error['usuario']  = 'sucess/Aprobador Modificado correctamente';}
if (isset($_GET['deleted'])){$error['usuario'] = 'sucess/Aprobador Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['edit'])){
// consulto los datos
$SIS_query = 'idUsuario, idSistema';
$SIS_join  = '';
$SIS_where = 'idAprobador = '.$_GET['edit'];
$rowData   = db_select_data (false, $SIS_query, 'sistema_aprobador_cross', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Aprobador</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idUsuario)){     $x1  = $idUsuario;   }else{$x1  = $rowData['idUsuario'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Usuario','idUsuario', $x1, 2, 'idUsuario', 'Nombre', 'usuarios_listado', $usrfil, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x1, 2, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				}

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idAprobador', $_GET['edit'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Agregar Aprobador</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idUsuario)){     $x1  = $idUsuario;   }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Usuario','idUsuario', $x1, 2, 'idUsuario', 'Nombre', 'usuarios_listado', $usrfil, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x1, 2, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				}

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				?>


				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_new">
					<a href="<?php echo $new_location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
// consulto los datos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'core_sistemas.idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'];
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

// consulto los datos
$SIS_query = '
sistema_aprobador_cross.idAprobador,
usuarios_listado.Nombre AS nombre_usuario';
$SIS_join  = 'LEFT JOIN `usuarios_listado`  ON usuarios_listado.idUsuario = sistema_aprobador_cross.idUsuario';
$SIS_where = 'sistema_aprobador_cross.idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'usuarios_listado.Nombre ASC';
$arrAprobador = array();
$arrAprobador = db_select_array (false, $SIS_query, 'sistema_aprobador_cross', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAprobador');

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

//Accesos al sistema cross
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
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Editar Aprobador Cross Shipping'); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
		<a href="<?php echo $new_location.'?new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Agregar Aprobador</a>
	</div>
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
							<li class=""><a href="<?php echo 'admin_datos_datos_variedades_nombres.php'; ?>" ><i class="fa fa-recycle" aria-hidden="true"></i> Variedades</a></li>
						<?php } ?>
						<?php if(isset($Count_Shipping)&&$Count_Shipping!=0){ ?>
							<li class="active"><a href="<?php echo 'admin_datos_datos_cross.php'; ?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Aprobador CrossShipping</a></li>
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
						<th>Aprobador</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrAprobador as $apro) { ?>
					<tr class="odd">
						<td><?php echo $apro['nombre_usuario']; ?></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo $new_location.'?edit='.$apro['idAprobador']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $new_location.'?del='.simpleEncode($apro['idAprobador'], fecha_actual());
								$dialogo   = '¿Realmente deseas eliminar al aprobador '.$apro['nombre_usuario'].'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
