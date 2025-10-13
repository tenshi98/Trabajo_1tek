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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Cadena de busqueda
$search = '?bla=bla';
if(isset($_GET['Ano'])&&$_GET['Ano']!=''){      $search .= '&Ano='.$_GET['Ano'];}
if(isset($_GET['mes'])&&$_GET['mes']!=''){      $search .= '&mes='.$_GET['mes'];}
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){ $search .= '&idSistema='.$_GET['idSistema'];}
if(isset($_GET['type'])&&$_GET['type']!=''){    $search .= '&type='.$_GET['type'];}
/***********************************************************/
//Solo compras pagadas totalmente
$z1  = "pagos_facturas_proveedores.idPago!=0";
$z2  = "pagos_facturas_clientes.idPago!=0";
$z3  = "pagos_rrhh_liquidaciones.idPago!=0";
$z4  = "pagos_boletas_trabajadores.idPago!=0";
$z5  = "contab_caja_gastos_existencias.idExistencia!=0";
$z6  = "pagos_leyes_fiscales_formas_pago.idHistorial!=0";
$z7  = "pagos_leyes_sociales_formas_pago.idHistorial!=0";
//filtro el año
if(isset($_GET['Ano'])&&$_GET['Ano']!=''){
	$z1.=" AND pagos_facturas_proveedores.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$z2.=" AND pagos_facturas_clientes.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$z3.=" AND pagos_rrhh_liquidaciones.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$z4.=" AND pagos_boletas_trabajadores.F_Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$z5.=" AND contab_caja_gastos_existencias.Creacion_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$z6.=" AND pagos_leyes_fiscales.Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
	$z7.=" AND pagos_leyes_sociales.Pago_ano=".simpleDecode($_GET['Ano'], fecha_actual());
}
//filtro el mes
if(isset($_GET['mes'])&&$_GET['mes']!=''){
	$z1.=" AND pagos_facturas_proveedores.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$z2.=" AND pagos_facturas_clientes.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$z3.=" AND pagos_rrhh_liquidaciones.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$z4.=" AND pagos_boletas_trabajadores.F_Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$z5.=" AND contab_caja_gastos_existencias.Creacion_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$z6.=" AND pagos_leyes_fiscales.Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
	$z7.=" AND pagos_leyes_sociales.Pago_mes=".simpleDecode($_GET['mes'], fecha_actual());
}
//Si se elije sistema
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){
	$z1.=" AND pagos_facturas_proveedores.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$z2.=" AND pagos_facturas_clientes.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$z3.=" AND pagos_rrhh_liquidaciones.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$z4.=" AND pagos_boletas_trabajadores.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$z5.=" AND contab_caja_gastos.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$z6.=" AND pagos_leyes_fiscales.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
	$z7.=" AND pagos_leyes_sociales.idSistema=".simpleDecode($_GET['idSistema'], fecha_actual());
}
/*************************************************************************************************/
//filtro
$SIS_query_1 = '
pagos_facturas_proveedores.idTipo,
pagos_facturas_proveedores_tipo.Nombre AS Tipo,
sistema_documentos_pago.Nombre AS Documento,
pagos_facturas_proveedores.N_DocPago,
proveedor_listado.Nombre AS Empresa,
pagos_facturas_proveedores.idFacturacion,
pagos_facturas_proveedores.F_Pago,
pagos_facturas_proveedores.MontoPagado';

$SIS_query_2 = '
pagos_facturas_clientes.idTipo,
pagos_facturas_clientes_tipo.Nombre AS Tipo,
sistema_documentos_pago.Nombre AS Documento,
pagos_facturas_clientes.N_DocPago,
clientes_listado.Nombre AS Empresa,
pagos_facturas_clientes.idFacturacion,
pagos_facturas_clientes.F_Pago,
pagos_facturas_clientes.MontoPagado';
		
$SIS_query_3 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_rrhh_liquidaciones.N_DocPago,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
pagos_rrhh_liquidaciones.idFactTrab AS idFacturacion,
pagos_rrhh_liquidaciones.F_Pago,
pagos_rrhh_liquidaciones.MontoPagado';

$SIS_query_4 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_boletas_trabajadores.N_DocPago,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
pagos_boletas_trabajadores.idFacturacion,
pagos_boletas_trabajadores.F_Pago,
pagos_boletas_trabajadores.MontoPagado';

$SIS_query_5 = '
sistema_documentos_pago.Nombre AS Documento,
contab_caja_gastos_existencias.N_Doc AS N_DocPago,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
contab_caja_gastos_existencias.idFacturacion,
contab_caja_gastos_existencias.Creacion_fecha AS F_Pago,
contab_caja_gastos_existencias.Valor AS MontoPagado';

$SIS_query_6 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_leyes_fiscales_formas_pago.N_DocPago,
pagos_leyes_fiscales_formas_pago.idFactFiscal AS idFacturacion,
pagos_leyes_fiscales.Pago_fecha AS F_Pago,
pagos_leyes_fiscales_formas_pago.Monto AS MontoPagado';

$SIS_query_7 = '
sistema_documentos_pago.Nombre AS Documento,
pagos_leyes_sociales_formas_pago.N_DocPago,
pagos_leyes_sociales_formas_pago.idFactSocial AS idFacturacion,
pagos_leyes_sociales.Pago_fecha AS F_Pago,
pagos_leyes_sociales_formas_pago.Monto AS MontoPagado';

$SIS_join_1 = '
LEFT JOIN `sistema_documentos_pago`           ON sistema_documentos_pago.idDocPago       = pagos_facturas_proveedores.idDocPago
LEFT JOIN `pagos_facturas_proveedores_tipo`   ON pagos_facturas_proveedores_tipo.idTipo  = pagos_facturas_proveedores.idTipo
LEFT JOIN `proveedor_listado`                 ON proveedor_listado.idProveedor           = pagos_facturas_proveedores.idProveedor
';

$SIS_join_2 = '
LEFT JOIN `sistema_documentos_pago`       ON sistema_documentos_pago.idDocPago    = pagos_facturas_clientes.idDocPago
LEFT JOIN `pagos_facturas_clientes_tipo`  ON pagos_facturas_clientes_tipo.idTipo  = pagos_facturas_clientes.idTipo
LEFT JOIN `clientes_listado`              ON clientes_listado.idCliente           = pagos_facturas_clientes.idCliente
';

$SIS_join_3 = '
LEFT JOIN `sistema_documentos_pago`                 ON sistema_documentos_pago.idDocPago                  = pagos_rrhh_liquidaciones.idDocPago
LEFT JOIN `rrhh_sueldos_facturacion_trabajadores`   ON rrhh_sueldos_facturacion_trabajadores.idFactTrab   = pagos_rrhh_liquidaciones.idFactTrab
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador                  = rrhh_sueldos_facturacion_trabajadores.idTrabajador
';

$SIS_join_4 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_boletas_trabajadores.idDocPago
LEFT JOIN `trabajadores_listado`       ON trabajadores_listado.idTrabajador    = pagos_boletas_trabajadores.idTrabajador
';

$SIS_join_5 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = contab_caja_gastos_existencias.idDocPago
LEFT JOIN `contab_caja_gastos`         ON contab_caja_gastos.idFacturacion     = contab_caja_gastos_existencias.idFacturacion
LEFT JOIN `trabajadores_listado`       ON trabajadores_listado.idTrabajador    = contab_caja_gastos.idTrabajador
';

$SIS_join_6 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_leyes_fiscales_formas_pago.idDocPago
LEFT JOIN pagos_leyes_fiscales         ON pagos_leyes_fiscales.idFactFiscal    = pagos_leyes_fiscales_formas_pago.idFactFiscal
';

$SIS_join_7 = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_leyes_sociales_formas_pago.idDocPago
LEFT JOIN pagos_leyes_sociales         ON pagos_leyes_sociales.idFactSocial    = pagos_leyes_sociales_formas_pago.idFactSocial
';

//variables
$arrTemporal_1 = array();
$arrTemporal_2 = array();
$arrTemporal_3 = array();
$arrTemporal_4 = array();
$arrTemporal_5 = array();
$arrTemporal_6 = array();
$arrTemporal_7 = array();

//Pagos a Proveedores
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_1 = db_select_array (false, $SIS_query_1, 'pagos_facturas_proveedores', $SIS_join_1, $z1, 'pagos_facturas_proveedores.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_1');
}
//Pagos a Clientes
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){
	$arrTemporal_2 = db_select_array (false, $SIS_query_2, 'pagos_facturas_clientes', $SIS_join_2, $z2, 'pagos_facturas_clientes.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_2');
}
//Pagos a trabajadores
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_3 = db_select_array (false, $SIS_query_3, 'pagos_rrhh_liquidaciones', $SIS_join_3, $z3, 'pagos_rrhh_liquidaciones.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_3');
}
//Pagos boletas a trabajadores
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_4 = db_select_array (false, $SIS_query_4, 'pagos_boletas_trabajadores', $SIS_join_4, $z4, 'pagos_boletas_trabajadores.F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_4');
}
//Rendiciones
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_5 = db_select_array (false, $SIS_query_5, 'contab_caja_gastos_existencias', $SIS_join_5 , $z5, 'contab_caja_gastos_existencias.Creacion_fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_5');
}
//Pagos de impuestos
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_6 = db_select_array (false, $SIS_query_6, 'pagos_leyes_fiscales_formas_pago', $SIS_join_6 , $z6, 'pagos_leyes_fiscales.Pago_fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_6');
}
//Pagos de previred
if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){
	$arrTemporal_7 = db_select_array (false, $SIS_query_7, 'pagos_leyes_sociales_formas_pago', $SIS_join_7 , $z7, 'pagos_leyes_sociales.Pago_fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_7');
}

//Variables
$total_ingreso = 0;
$total_egreso  = 0;
  	

 		
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_gerencial_09_view_to_excel.php'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Tipo</th>
						<th>Empresa</th>
						<th>Documento</th>
						<th>Fecha Pagada</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><th>Ingreso</th><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><th>Egreso</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr role="row" style="background-color: #d2d2d2;">
						<th colspan="7">Pagos a Proveedores</th>
					</tr>
					<?php
					//Subtotal
					$Subtotal_1 = 0;
					$Subtotal_2 = 0;
					//recorro
					foreach ($arrTemporal_1 as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Tipo']; ?></td>
							<td><?php echo $tipo['Empresa']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
							<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores(0, 0); ?></td><?php } ?>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($tipo['MontoPagado'], 0);  $total_egreso = $total_egreso + $tipo['MontoPagado']; $Subtotal_2 = $Subtotal_2 + $tipo['MontoPagado']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php
									switch ($tipo['idTipo']) {
										case 1://Factura Insumos
											echo '<a href="view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
										case 2://Factura Productos
											echo '<a href="view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
										case 3://Factura Servicios
											echo '<a href="view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
										case 4://Factura Arriendos
											echo '<a href="view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
									}
									?>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr role="row" style="background-color: #E5E5E5;">
						<th colspan="4">Subtotal Pagos a Proveedores</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($Subtotal_1, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($Subtotal_2, 0); ?></td><?php } ?>
						<td></td>
					</tr>
					<?php ////////////////////////////////////////////////////////////////////?>
					<tr role="row" style="background-color: #d2d2d2;">
						<th colspan="7">Pagos de Clientes</th>
					</tr>
					<?php
					//Subtotal
					$Subtotal_1 = 0;
					$Subtotal_2 = 0;
					//recorro
					foreach ($arrTemporal_2 as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Tipo']; ?></td>
							<td><?php echo $tipo['Empresa']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
							<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($tipo['MontoPagado'], 0); $total_ingreso = $total_ingreso + $tipo['MontoPagado']; $Subtotal_1 = $Subtotal_1 + $tipo['MontoPagado']; ?></td><?php } ?>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores(0, 0); ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php
									switch ($tipo['idTipo']) {
										case 1://Factura Insumos
											echo '<a href="view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
										case 2://Factura Productos
											echo '<a href="view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
										case 3://Factura Servicios
											echo '<a href="view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
										case 4://Factura Arriendos
											echo '<a href="view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
											break;
									}
									?>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr role="row" style="background-color: #E5E5E5;">
						<th colspan="4">Subtotal Pagos de Clientes</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($Subtotal_1, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($Subtotal_2, 0); ?></td><?php } ?>
						<td></td>
					</tr>
					<?php ////////////////////////////////////////////////////////////////////?> 
					 <tr role="row" style="background-color: #d2d2d2;">
						<th colspan="7">Pagos a trabajadores</th>
					</tr>
					<?php
					//Subtotal
					$Subtotal_1 = 0;
					$Subtotal_2 = 0;
					//recorro
					foreach ($arrTemporal_3 as $tipo) { ?>
						<tr class="odd">
							<td>Liquidacion Sueldo</td>
							<td><?php echo $tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
							<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores(0, 0); ?></td><?php } ?>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($tipo['MontoPagado'], 0); $total_egreso = $total_egreso + $tipo['MontoPagado'];$Subtotal_2 = $Subtotal_2 + $tipo['MontoPagado']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="view_rrhh_sueldos.php?view=<?php echo simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>&return=<?php echo basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr role="row" style="background-color: #E5E5E5;">
						<th colspan="4">Subtotal Pagos a trabajadores</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($Subtotal_1, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($Subtotal_2, 0); ?></td><?php } ?>
						<td></td>
					</tr>
					<?php ////////////////////////////////////////////////////////////////////?> 
					 <tr role="row" style="background-color: #d2d2d2;">
						<th colspan="7">Pagos boletas a trabajadores</th>
					</tr>
					<?php
					//Subtotal
					$Subtotal_1 = 0;
					$Subtotal_2 = 0;
					//recorro
					foreach ($arrTemporal_4 as $tipo) { ?>
						<tr class="odd">
							<td>Boleta Honorario</td>
							<td><?php echo $tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
							<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores(0, 0); ?></td><?php } ?>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($tipo['MontoPagado'], 0); $total_egreso = $total_egreso + $tipo['MontoPagado'];$Subtotal_2 = $Subtotal_2 + $tipo['MontoPagado']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="view_boleta_honorarios.php?view=<?php echo simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>&return=<?php echo basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr role="row" style="background-color: #E5E5E5;">
						<th colspan="4">Subtotal Pagos boletas a trabajadores</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($Subtotal_1, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($Subtotal_2, 0); ?></td><?php } ?>
						<td></td>
					</tr>
					<?php ////////////////////////////////////////////////////////////////////?>
					<tr role="row" style="background-color: #d2d2d2;">
						<th colspan="7">Rendiciones</th>
					</tr>
					<?php
					//Subtotal
					$Subtotal_1 = 0;
					$Subtotal_2 = 0;
					//recorro
					foreach ($arrTemporal_5 as $tipo) { ?>
						<tr class="odd">
							<td>Rendiciones</td>
							<td><?php echo $tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat']; ?></td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
							<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores(0, 0); ?></td><?php } ?>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($tipo['MontoPagado'], 0); $total_egreso = $total_egreso + $tipo['MontoPagado'];$Subtotal_2 = $Subtotal_2 + $tipo['MontoPagado']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="view_mov_contab_caja_gastos.php?view=<?php echo simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>&return=<?php echo basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr role="row" style="background-color: #E5E5E5;">
						<th colspan="4">Subtotal Rendiciones</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($Subtotal_1, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($Subtotal_2, 0); ?></td><?php } ?>
						<td></td>
					</tr>
					<?php ////////////////////////////////////////////////////////////////////?>
					<tr role="row" style="background-color: #d2d2d2;">
						<th colspan="7">Formulario 29</th>
					</tr>
					<?php
					//Subtotal
					$Subtotal_1 = 0;
					$Subtotal_2 = 0;
					//recorro
					foreach ($arrTemporal_6 as $tipo) { ?>
						<tr class="odd">
							<td>Formulario 29</td>
							<td>SII</td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
							<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores(0, 0); ?></td><?php } ?>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($tipo['MontoPagado'], 0); $total_egreso = $total_egreso + $tipo['MontoPagado'];$Subtotal_2 = $Subtotal_2 + $tipo['MontoPagado']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="view_mov_pagos_leyes_fiscales.php?view=<?php echo simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>&return=<?php echo basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr role="row" style="background-color: #E5E5E5;">
						<th colspan="4">Subtotal Formulario 29</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($Subtotal_1, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($Subtotal_2, 0); ?></td><?php } ?>
						<td></td>
					</tr>
					<?php ////////////////////////////////////////////////////////////////////?>
					<tr role="row" style="background-color: #d2d2d2;">
						<th colspan="7">Pagos de previred</th>
					</tr>
					<?php
					//Subtotal
					$Subtotal_1 = 0;
					$Subtotal_2 = 0;
					//recorro
					foreach ($arrTemporal_7 as $tipo) { ?>
						<tr class="odd">
							<td>Previred</td>
							<td>Previred</td>
							<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
							<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores(0, 0); ?></td><?php } ?>
							<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($tipo['MontoPagado'], 0); $total_egreso = $total_egreso + $tipo['MontoPagado'];$Subtotal_2 = $Subtotal_2 + $tipo['MontoPagado']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="view_mov_pagos_leyes_sociales.php?view=<?php echo simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>&return=<?php echo basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr role="row" style="background-color: #E5E5E5;">
						<th colspan="4">Subtotal Pagos de previred</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($Subtotal_1, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($Subtotal_2, 0); ?></td><?php } ?>
						<td></td>
					</tr>
					<?php ////////////////////////////////////////////////////////////////////?>
					<tr role="row" style="background-color: #d2d2d2;">
						<th colspan="4">Total General</th>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==2)){ ?><td align="right" class="color-blue"><?php echo valores($total_ingreso, 0); ?></td><?php } ?>
						<?php if(isset($_GET['type'])&&($_GET['type']==1 OR $_GET['type']==3)){ ?><td align="right" class="color-red"><?php echo valores($total_egreso, 0); ?></td><?php } ?>
						<td></td>
					</tr>          
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php if(isset($_GET['return'])&&$_GET['return']!=''){ ?>
	<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
		<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
