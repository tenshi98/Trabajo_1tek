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
$new_location = "usuarios_listado_camaras.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_GET['camara_add'])){
	//nuevas ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'camara_add';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['camara_del'])){
	//nuevas ubicaciones
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'camara_del';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//formulario para crear
if (!empty($_GET['prm_add_all'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'prm_add_all_camaras';
	require_once 'A1XRXS_sys/xrxs_form/usuarios_listado.php';
}
//se borra un dato
if (!empty($_GET['prm_del_all'])){
	//nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'prm_del_all_camaras';
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
$SIS_query = 'core_permisos_listado.Direccionbase';
$SIS_join  = 'INNER JOIN  core_permisos_listado ON core_permisos_listado.idAdmpm = usuarios_permisos.idAdmpm';
$SIS_where = 'usuarios_permisos.idUsuario='.$_GET['id'];
$SIS_order = 'core_permisos_listado.Direccionbase ASC';
$arrPermiso = array();
$arrPermiso = db_select_array (false, $SIS_query, 'usuarios_permisos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermiso');

$arrPer = array();
foreach ($arrPermiso as $ins) {
	$arrPer[$ins['Direccionbase']] = 1;
}

/******************************************************/
//variable de numero de permiso
$x_nperm = 0;

//Accesos a bodegas de arriendos
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_ingreso.php";                        //01 - Compra - Arriendos
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_ingreso_devolucion.php";             //02 - Compra - Devoluciones
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_ingreso_nota_credito.php";           //03 - Compra - Nota de Credito
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_ingreso_nota_debito.php";            //04 - Compra - Nota de Debito
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_egreso.php";                         //05 - Venta - Arriendos
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_egreso_devolucion.php";              //06 - Venta - Devoluciones
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_egreso_nota_credito.php";            //07 - Venta - Nota de Credito
$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_egreso_nota_debito.php";             //08 - Venta - Nota de Debito

//Accesos a bodegas de insumos
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ingreso.php";                          //09 - Compra - Insumos
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ingreso_nota_credito.php";             //10 - Compra - Nota de Credito
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ingreso_nota_debito.php";              //11 - Compra - Nota de Debito
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_egreso.php";                           //12 - Entrega de Insumos
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ingreso_manual.php";                   //13 - Ingreso Manual
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_stock.php";                            //14 - Stock Detallado
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_simple_stock.php";                     //15 - Stock Simple
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_traspaso.php";                         //16 - Traspaso entre Bodegas
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_traspaso_empresa.php";                 //17 - Traspaso entre Empresas
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_traspaso_empresa_manual.php";          //18 - Traspaso Manual entre Empresas
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ventas.php";                           //19 - Venta - Insumos
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ventas_nota_credito.php";              //20 - Venta - Nota de Credito
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ventas_nota_debito.php";               //21 - Venta - Nota de Debito

//Accesos a bodegas de productos
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_ingreso_nota_credito.php";           //22 - Compra - Nota de Credito
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_ingreso_nota_debito.php";            //23 - Compra - Nota de Debito
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_ingreso.php";                        //24 - Compra - Productos
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_gasto.php";                          //25 - Gastos de Productos
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_ingreso_manual.php";                 //26 - Ingreso Manual
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_stock.php";                          //27 - Stock Detallado
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_simple_stock.php";                   //28 - Stock Simple
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_transformacion.php";                 //29 - Transformacion de Productos
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_traspaso.php";                       //30 - Traspaso entre Bodegas
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_traspaso_empresa.php";               //31 - Traspaso entre Empresas
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_traspaso_empresa_manual.php";        //32 - Traspaso Manual entre Empresas
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_egreso_nota_credito.php";            //33 - Venta - Nota de Credito
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_egreso_nota_debito.php";             //34 - Venta - Nota de Debito
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_egreso.php";                         //35 - Venta - Productos

//Accesos a los equipos de telemetria
$x_nperm++; $trans[$x_nperm] = "telemetria_listado.php";                               //36 - Administrar Equipos Telemetria
$x_nperm++; $trans[$x_nperm] = "admin_telemetria_listado.php";                         //37 - Administrar Equipos Telemetria

//Accesos a los los contratos
$x_nperm++; $trans[$x_nperm] = "analisis_listado.php";                                 //38 - Analisis Maquinas
$x_nperm++; $trans[$x_nperm] = "maquinas_listado.php";                                 //39 - Administrar Maquinas
$x_nperm++; $trans[$x_nperm] = "informe_gerencial_03.php";                             //40 - Estado Contrato
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_crear.php";                              //41 - Orden de Trabajo - Crear
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_terminar.php";                           //42 - Orden de Trabajo - Terminar
$x_nperm++; $trans[$x_nperm] = "unidad_negocio_listado.php";                           //43 - Administrar Unidad de Negocio

//Accesos a pagos
$x_nperm++; $trans[$x_nperm] = "pago_masivo_cliente.php";                              //44 - Pago Documentos Clientes
$x_nperm++; $trans[$x_nperm] = "pago_masivo_proveedor.php";                            //45 - Pago Documentos Proveedores
$x_nperm++; $trans[$x_nperm] = "pago_masivo_cliente_reversa.php";                      //46 - Reversar Pago Clientes
$x_nperm++; $trans[$x_nperm] = "pago_masivo_proveedor_reversa.php";                    //47 - Reversar Pago Proveedores
$x_nperm++; $trans[$x_nperm] = "pago_boletas_cliente.php";                             //48 - Pago Boletas Honorarios Clientes
$x_nperm++; $trans[$x_nperm] = "pago_boletas_proveedor.php";                           //49 - Pago Boletas Honorarios Empresas
$x_nperm++; $trans[$x_nperm] = "pago_boletas_trabajador.php";                          //50 - Pago Boletas Honorarios Trabajadores
$x_nperm++; $trans[$x_nperm] = "pago_boletas_cliente_reversa.php";                     //51 - Reversar Pago Clientes
$x_nperm++; $trans[$x_nperm] = "pago_boletas_proveedor_reversa.php";                   //52 - Reversar Pago Proveedores
$x_nperm++; $trans[$x_nperm] = "pago_boletas_trabajador_reversa.php";                  //53 - Reversar Pago Trabajadores BH

//Accesos a caja chica
$x_nperm++; $trans[$x_nperm] = "caja_chica_listado.php";                               //54 - Administrar Caja Chica
$x_nperm++; $trans[$x_nperm] = "caja_chica_ingreso.php";                               //55 - Caja Chica - Ingreso
$x_nperm++; $trans[$x_nperm] = "caja_chica_egreso.php";                                //56 - Caja Chica - Egreso
$x_nperm++; $trans[$x_nperm] = "caja_chica_rendicion.php";                             //57 - Caja Chica - Rendicion
$x_nperm++; $trans[$x_nperm] = "caja_chica_rendida.php";                               //58 - Caja Chica - Rendidas

//Accesos las camaras de seguridad
$x_nperm++; $trans[$x_nperm] = "seguridad_camaras_listado.php";                        //59 - Administrar Camaras Seguridad
$x_nperm++; $trans[$x_nperm] = "seguridad_camaras_vista.php";                          //60 - Ver Camaras Seguridad

//Accesos a los los contratos
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_cambiar_estado.php";              //61 - Orden de Trabajo - Cambiar Estado
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_canceladas.php";                  //62 - Orden de Trabajo - Canceladas
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_crear.php";                       //63 - Orden de Trabajo - Crear
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_ejecutar.php";                    //64 - Orden de Trabajo - Ejecutar
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_finalizadas.php";                 //65 - Orden de Trabajo - Finalizadas
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_terminar.php";                    //66 - Orden de Trabajo - Forzar Cierre

/******************************************************/
//Genero los permisos
for ($i = 1; $i <= $x_nperm; $i++) {
	//Seteo la variable a 0
	$prm_x[$i] = 0;
	//se verifica si variable existe
	if(isset($arrPer[$trans[$i]])&&$arrPer[$trans[$i]]!=''){
		$prm_x[$i] = 1;
	}
}

/******************************************************/
$arriendos    = $prm_x[1] + $prm_x[2] + $prm_x[3] + $prm_x[4] + $prm_x[5] + $prm_x[6] + $prm_x[7] + $prm_x[8];
$insumos      = $prm_x[9] + $prm_x[10] + $prm_x[11] + $prm_x[12] + $prm_x[13] + $prm_x[14] + $prm_x[15] + $prm_x[16] + $prm_x[17] + $prm_x[18] + $prm_x[19] + $prm_x[20] + $prm_x[21];
$productos    = $prm_x[22] + $prm_x[23] + $prm_x[24] + $prm_x[25] + $prm_x[26] + $prm_x[27] + $prm_x[28] + $prm_x[29] + $prm_x[30] + $prm_x[31] + $prm_x[32] + $prm_x[33] + $prm_x[34] + $prm_x[35];

$x_permisos_1 = $insumos + $productos + $arriendos;
$x_permisos_2 = $prm_x[36] + $prm_x[37];
$x_permisos_3 = $prm_x[38] + $prm_x[39] + $prm_x[40] + $prm_x[41] + $prm_x[42] + $prm_x[43] + $prm_x[61] + $prm_x[62] + $prm_x[63] + $prm_x[64] + $prm_x[65] + $prm_x[66];
$x_permisos_4 = $prm_x[54] + $prm_x[55] + $prm_x[56] + $prm_x[57] + $prm_x[58];
$x_permisos_5 = $prm_x[44] + $prm_x[45] + $prm_x[46] + $prm_x[47] + $prm_x[48] + $prm_x[49] + $prm_x[50] + $prm_x[51] + $prm_x[52] + $prm_x[53];
$x_permisos_6 = $prm_x[59] + $prm_x[60];

/********************************************************************************/
/********************************************************************************/
//Se verifican los permisos que tiene el usuario seleccionado
$SIS_query = '
seguridad_camaras_listado.idCamara,
seguridad_camaras_listado.Nombre,
seguridad_camaras_listado.N_Camaras,
core_sistemas.Nombre AS RazonSocial,
(SELECT COUNT(idCamaraPermiso) FROM usuarios_camaras WHERE idCamara = seguridad_camaras_listado.idCamara AND idUsuario = '.$_GET['id'].' LIMIT 1) AS contar,
(SELECT idCamaraPermiso FROM usuarios_camaras WHERE idCamara = seguridad_camaras_listado.idCamara AND idUsuario = '.$_GET['id'].' LIMIT 1) AS idpermiso';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = seguridad_camaras_listado.idSistema';
$SIS_where = 'seguridad_camaras_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'seguridad_camaras_listado.Nombre ASC';
$arrCamaras = array();
$arrCamaras = db_select_array (false, $SIS_query, 'seguridad_camaras_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCamaras');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Usuario', $rowData['Nombre'], 'Editar Permisos de acceso a Camaras'); ?>
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
						<?php if($x_permisos_1 > 0){ ?>
							<li class=""><a href="<?php echo 'usuarios_listado_bodegas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-database" aria-hidden="true"></i> Bodegas</a></li>
						<?php } ?>
						<?php if($x_permisos_2 > 0){ ?>
							<li class=""><a href="<?php echo 'usuarios_listado_equipos_telemetria.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Equipos telemetria</a></li>
						<?php } ?>
						<?php if($x_permisos_3 > 0){ ?>
							<li class=""><a href="<?php echo 'usuarios_listado_contratos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Contratos</a></li>
						<?php } ?>
						<?php if($x_permisos_4 > 0){ ?>
							<li class=""><a href="<?php echo 'usuarios_listado_cajas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Caja Chica</a></li>
						<?php } ?>
						<?php if($x_permisos_5>0){ ?>
							<li class=""><a href="<?php echo 'usuarios_listado_documentos_pago.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Documentos Pago</a></li>
						<?php } ?>
						<?php if($x_permisos_6>0){ ?>
							<li class="active"><a href="<?php echo 'usuarios_listado_camaras.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-video-camera" aria-hidden="true"></i> Camaras de Seguridad</a></li>
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
						<th width="120">N° Camaras</th>
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
								<a href="<?php echo $new_location.'&id='.$_GET['id'].'&prm_del_all=true'.'&idUsuario='.$_GET['id'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema']; ?>" title="Quitar todos los permisos" class="btn btn-sm btn-default unlocked_inactive tooltip">OFF</a>
								<a href="<?php echo $new_location.'&id='.$_GET['id'].'&prm_add_all=true'.'&idUsuario='.$_GET['id'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema']; ?>" title="Asignar todos los permisos" class="btn btn-sm btn-default unlocked_inactive tooltip">ON</a>
							</div>
						</td>
					</tr>
					<?php foreach ($arrCamaras as $cajas) { ?>
						<tr class="odd">
							<td><?php echo $cajas['Nombre']; ?></td>
							<td><?php echo $cajas['N_Camaras']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $cajas['RazonSocial']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 100px;" id="toggle_event_editing">
									<?php if ( $cajas['contar']=='1' ){ ?>    
										<a title="Quitar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_GET['id'].'&camara_del='.$cajas['idpermiso']; ?>">OFF</a>
										<a title="Dar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">ON</a>
									<?php } else { ?>
										<a title="Quitar Permiso" class="btn btn-sm btn-info locked_active tooltip" href="#">OFF</a>
										<a title="Dar Permiso" class="btn btn-sm btn-default unlocked_inactive tooltip" href="<?php echo $new_location.'&id='.$_GET['id'].'&camara_add='.$cajas['idCamara']; ?>">ON</a>
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
