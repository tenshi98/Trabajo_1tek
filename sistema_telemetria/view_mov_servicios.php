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
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
// consulto los datos
$SIS_query = '
bodegas_servicios_facturacion.idTipo,
bodegas_servicios_facturacion.idFacturacion,
bodegas_servicios_facturacion.Creacion_fecha,
bodegas_servicios_facturacion.N_Doc,
bodegas_servicios_facturacion.Observaciones,
bodegas_servicios_facturacion.idOcompra,
bodegas_servicios_facturacion.OC_Ventas,
bodegas_servicios_facturacion_tipo.Nombre AS TipoDoc,
core_documentos_mercantiles.Nombre AS Documento,
usuarios_listado.Nombre AS NombreUsuario,
bodegas_servicios_facturacion.ValorNeto,
bodegas_servicios_facturacion.ValorNetoImp,
bodegas_servicios_facturacion.Impuesto_01,
bodegas_servicios_facturacion.Impuesto_02,
bodegas_servicios_facturacion.Impuesto_03,
bodegas_servicios_facturacion.Impuesto_04,
bodegas_servicios_facturacion.Impuesto_05,
bodegas_servicios_facturacion.Impuesto_06,
bodegas_servicios_facturacion.Impuesto_07,
bodegas_servicios_facturacion.Impuesto_08,
bodegas_servicios_facturacion.Impuesto_09,
bodegas_servicios_facturacion.Impuesto_10,
bodegas_servicios_facturacion.ValorTotal,
bodegas_servicios_facturacion.fecha_fact_desde,
bodegas_servicios_facturacion.fecha_fact_hasta,
bodegas_servicios_facturacion.idUsoIVA,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

proveedor_listado.Nombre AS NombreProveedor,
proveedor_listado.email AS EmailProveedor,
proveedor_listado.Rut AS RutProveedor,
provciudad.Nombre AS CiudadProveedor,
provcomuna.Nombre AS ComunaProveedor,
proveedor_listado.Direccion AS DireccionProveedor,
proveedor_listado.Fono1 AS Fono1Proveedor,
proveedor_listado.Fono2 AS Fono2Proveedor,
proveedor_listado.Fax AS FaxProveedor,
proveedor_listado.PersonaContacto AS PersonaContactoProveedor,
proveedor_listado.Giro AS GiroProveedor,

bodegas_servicios_facturacion.idEstado,
core_estado_facturacion.Nombre AS Estado,
bodegas_servicios_facturacion.Pago_fecha,
bodegas_servicios_facturacion.idDocPago,
sistema_documentos_pago.Nombre AS DocPago,
bodegas_servicios_facturacion.N_DocPago,
bodegas_servicios_facturacion.F_Pago,
bodegas_servicios_facturacion.MontoPagado,
usuario_pago.Nombre AS UsuarioPago,

clientes_listado.Nombre AS NombreCliente,
clientes_listado.email AS EmailCliente,
clientes_listado.Rut AS RutCliente,
clienciudad.Nombre AS CiudadCliente,
cliencomuna.Nombre AS ComunaCliente,
clientes_listado.Direccion AS DireccionCliente,
clientes_listado.Fono1 AS Fono1Cliente,
clientes_listado.Fono2 AS Fono2Cliente,
clientes_listado.Fax AS FaxCliente,
clientes_listado.PersonaContacto AS PersonaContactoCliente,
clientes_listado.Giro AS GiroCliente,

trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellido,

centrocosto_listado.Nombre AS CentroCosto_Nombre,
centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5';
$SIS_join  = '
LEFT JOIN `bodegas_servicios_facturacion_tipo`      ON bodegas_servicios_facturacion_tipo.idTipo    = bodegas_servicios_facturacion.idTipo
LEFT JOIN `core_documentos_mercantiles`             ON core_documentos_mercantiles.idDocumentos     = bodegas_servicios_facturacion.idDocumentos
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                   = bodegas_servicios_facturacion.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema                     = bodegas_servicios_facturacion.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                       = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                       = sistema_origen.idComuna
LEFT JOIN `proveedor_listado`                       ON proveedor_listado.idProveedor                = bodegas_servicios_facturacion.idProveedor
LEFT JOIN `core_ubicacion_ciudad`    provciudad     ON provciudad.idCiudad                          = proveedor_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   provcomuna     ON provcomuna.idComuna                          = proveedor_listado.idComuna
LEFT JOIN `core_estado_facturacion`                 ON core_estado_facturacion.idEstado             = bodegas_servicios_facturacion.idEstado
LEFT JOIN `sistema_documentos_pago`                 ON sistema_documentos_pago.idDocPago            = bodegas_servicios_facturacion.idDocPago
LEFT JOIN `clientes_listado`                        ON clientes_listado.idCliente                   = bodegas_servicios_facturacion.idCliente
LEFT JOIN `core_ubicacion_ciudad`    clienciudad    ON clienciudad.idCiudad                         = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   cliencomuna    ON cliencomuna.idComuna                         = clientes_listado.idComuna
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador            = bodegas_servicios_facturacion.idTrabajador
LEFT JOIN `usuarios_listado`     usuario_pago       ON usuario_pago.idUsuario                       = bodegas_servicios_facturacion.idUsuarioPago
LEFT JOIN `centrocosto_listado`                     ON centrocosto_listado.idCentroCosto            = bodegas_servicios_facturacion.idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`             ON centrocosto_listado_level_1.idLevel_1        = bodegas_servicios_facturacion.idLevel_1
LEFT JOIN `centrocosto_listado_level_2`             ON centrocosto_listado_level_2.idLevel_2        = bodegas_servicios_facturacion.idLevel_2
LEFT JOIN `centrocosto_listado_level_3`             ON centrocosto_listado_level_3.idLevel_3        = bodegas_servicios_facturacion.idLevel_3
LEFT JOIN `centrocosto_listado_level_4`             ON centrocosto_listado_level_4.idLevel_4        = bodegas_servicios_facturacion.idLevel_4
LEFT JOIN `centrocosto_listado_level_5`             ON centrocosto_listado_level_5.idLevel_5        = bodegas_servicios_facturacion.idLevel_5';
$SIS_where = 'bodegas_servicios_facturacion.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'bodegas_servicios_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
servicios_listado.Nombre,
bodegas_servicios_facturacion_existencias.Cantidad_ing,
bodegas_servicios_facturacion_existencias.Cantidad_eg,
bodegas_servicios_facturacion_existencias.Valor,
bodegas_servicios_facturacion_existencias.ValorTotal,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `servicios_listado`        ON servicios_listado.idServicio           = bodegas_servicios_facturacion_existencias.idServicio
LEFT JOIN `core_tiempo_frecuencia`   ON core_tiempo_frecuencia.idFrecuencia    = bodegas_servicios_facturacion_existencias.idFrecuencia';
$SIS_where = 'bodegas_servicios_facturacion_existencias.idFacturacion ='.$X_Puntero;
$SIS_order = 'servicios_listado.Nombre ASC';
$arrServicios = array();
$arrServicios = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrServicios');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = 'Nombre,vTotal';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOtros');

/*****************************************/
// Se trae un listado con todos los impuestos existentes
$SIS_query = 'Nombre,vTotal';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrDescuentos = array();
$arrDescuentos = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion_descuentos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDescuentos');

/*****************************************/
// Se trae un listado con todos los impuestos existentes
$SIS_query = 'Nombre,Porcentaje';
$SIS_join  = '';
$SIS_where = 'Nombre!=""';
$SIS_order = 'idImpuesto ASC';
$arrImpuestos = array();
$arrImpuestos = db_select_array (false, $SIS_query, 'sistema_impuestos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrImpuestos');

/*****************************************/
// Se trae un listado con todas las guias relacionadas al documento
$SIS_query = 'N_Doc, ValorNeto';
$SIS_join  = '';
$SIS_where = 'idDocumentos = 1 AND DocRel ='.$X_Puntero;
$SIS_order = 'N_Doc ASC';
$arrGuias = array();
$arrGuias = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGuias');

/*****************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
sistema_documentos_pago.Nombre,
pagos_facturas_proveedores.N_DocPago,
pagos_facturas_proveedores.F_Pago,
pagos_facturas_proveedores.MontoPagado,
usuarios_listado.Nombre AS UsuarioPago';
$SIS_join  = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_facturas_proveedores.idDocPago
LEFT JOIN `usuarios_listado`           ON usuarios_listado.idUsuario           = pagos_facturas_proveedores.idUsuario';
$SIS_where = 'pagos_facturas_proveedores.idFacturacion ='.$X_Puntero.' AND pagos_facturas_proveedores.idTipo=3';
$SIS_order = 'sistema_documentos_pago.Nombre ASC';
$arrPagosProv = array();
$arrPagosProv = db_select_array (false, $SIS_query, 'pagos_facturas_proveedores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagosProv');

/*****************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
sistema_documentos_pago.Nombre,
pagos_facturas_clientes.N_DocPago,
pagos_facturas_clientes.F_Pago,
pagos_facturas_clientes.MontoPagado,
usuarios_listado.Nombre AS UsuarioPago';
$SIS_join  = '
LEFT JOIN `sistema_documentos_pago`    ON sistema_documentos_pago.idDocPago    = pagos_facturas_clientes.idDocPago
LEFT JOIN `usuarios_listado`           ON usuarios_listado.idUsuario           = pagos_facturas_clientes.idUsuario';
$SIS_where = 'pagos_facturas_clientes.idFacturacion ='.$X_Puntero.' AND pagos_facturas_clientes.idTipo=3';
$SIS_order = 'sistema_documentos_pago.Nombre ASC';
$arrPagosClien = array();
$arrPagosClien = db_select_array (false, $SIS_query, 'pagos_facturas_clientes', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagosClien');

/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

/*****************************************/
// Se trae un listado con el historial
$SIS_query = '
bodegas_servicios_facturacion_historial.Creacion_fecha, 
bodegas_servicios_facturacion_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = bodegas_servicios_facturacion_historial.idTipo
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = bodegas_servicios_facturacion_historial.idUsuario';
$SIS_where = 'bodegas_servicios_facturacion_historial.idFacturacion ='.$X_Puntero;
$SIS_order = 'bodegas_servicios_facturacion_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/*****************************************/
// Se trae un listado con todos los documentos relacionados a una orden de compra
$SIS_query = '
ocompra_listado_documentos.NDocPago AS Documento_numero,
ocompra_listado_documentos.Fpago AS Documento_fechapago,
ocompra_listado_documentos.vTotal AS Documento_valor,
sistema_documentos_pago.Nombre AS Documento_pago';
$SIS_join  = '
LEFT JOIN `ocompra_listado_documentos`  ON ocompra_listado_documentos.idOcompra   = bodegas_servicios_facturacion.idOcompra
LEFT JOIN `sistema_documentos_pago`     ON sistema_documentos_pago.idDocPago      = ocompra_listado_documentos.idDocPago';
$SIS_where = 'bodegas_servicios_facturacion.idFacturacion ='.$X_Puntero;
$SIS_order = 'sistema_documentos_pago.Nombre ASC, ocompra_listado_documentos.Fpago ASC';
$arrDocRel = array();
$arrDocRel = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDocRel');

/*****************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
core_documentos_mercantiles.Nombre AS Documento,
bodegas_servicios_facturacion.N_Doc,
bodegas_servicios_facturacion.Creacion_fecha,
bodegas_servicios_facturacion.ValorTotal,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_documentos_mercantiles`  ON core_documentos_mercantiles.idDocumentos     = bodegas_servicios_facturacion.idDocumentos
LEFT JOIN `usuarios_listado`             ON usuarios_listado.idUsuario                   = bodegas_servicios_facturacion.idUsuario';
$SIS_where = 'bodegas_servicios_facturacion.idFacturacionRelacionado ='.$X_Puntero;
$SIS_order = 'core_documentos_mercantiles.Nombre ASC';
$arrNotasCredito = array();
$arrNotasCredito = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrNotasCredito');

/*****************************************/
$nn = 0;
$impuestos = array();
foreach ($arrImpuestos as $impto) {
	$impuestos[$nn]['nimp'] = $impto['Nombre'].' ('.Cantidades_decimales_justos($impto['Porcentaje']).'%)';
	$nn++;
}

//Si el documento esta pagado se muestran los datos relacionados al pago
if($rowData['MontoPagado']!=0){ ?>
	<div class="" style="margin-top:10px;">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h6 class="panel-title"><i class="fa fa-usd" aria-hidden="true"></i> Pagos Relacionados</h6>
				</div>
				<div class="panel-body">
					<div class="row invoice-payment">
						<table class="table">
							<thead>
								<tr role="row">
									<th>Encargado</th>
									<th>Documento</th>
									<th>Fecha Documento</th>
									<th>Monto</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrPagosProv as $pagos) { ?>
									<tr class="odd">
										<td><?php echo $pagos['UsuarioPago']; ?></td>
										<td><?php echo $pagos['Nombre'];if(isset($pagos['N_DocPago'])&&$pagos['N_DocPago']!=''){echo ' Doc N° '.$pagos['N_DocPago'];} ?></td>
										<td><?php echo fecha_estandar($pagos['F_Pago']); ?></td>
										<td align="right" style="padding-right: 22px !important;"><?php echo Valores($pagos['MontoPagado'], 0); ?></td>
									</tr>
								<?php } ?>
								<?php foreach ($arrPagosClien as $pagos) { ?>
									<tr class="odd">
										<td><?php echo $pagos['UsuarioPago']; ?></td>
										<td><?php echo $pagos['Nombre'];if(isset($pagos['N_DocPago'])&&$pagos['N_DocPago']!=''){echo ' Doc N° '.$pagos['N_DocPago'];} ?></td>
										<td><?php echo fecha_estandar($pagos['F_Pago']); ?></td>
										<td align="right" style="padding-right: 22px !important;"><?php echo Valores($pagos['MontoPagado'], 0); ?></td>
									</tr>
								<?php } ?>
								<?php foreach ($arrNotasCredito as $doc) { ?>
									<tr class="odd">
										<td><?php echo $doc['Usuario']; ?></td>
										<td><?php echo $doc['Documento'].' '.$doc['N_Doc']; ?></td>
										<td><?php echo Fecha_estandar($doc['Creacion_fecha']); ?></td>
										<td align="right" style="padding-right: 22px !important;"><?php echo Valores($doc['ValorTotal'], 0); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

					<div class="row invoice-payment">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"></div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tbody>
									<tr>
										<th>Monto Abonado:</th>
										<td align="right"><?php echo Valores($rowData['MontoPagado'], 0) ?></td>
									</tr>
									<tr>
										<th>Monto Facturado:</th>
										<td align="right"><?php echo Valores($rowData['ValorTotal'], 0) ?></td>
									</tr>
									<tr>
										<th>Diferencia:</th>
										<?php
										$diferencia = $rowData['MontoPagado'] - $rowData['ValorTotal'];
										if($diferencia<0){
											echo '<td align="right" class="text-danger"><h6><i class="fa fa-arrow-down" aria-hidden="true"></i> '.Valores($diferencia, 0).'</h6></td>';
										}elseif($diferencia>0){
											echo '<td align="right" class="text-info"><h6><i class="fa fa-arrow-up" aria-hidden="true"></i> '.Valores($diferencia, 0).'</h6></td>';
										}else{
											echo '<td align="right"><h6>Valores OK</h6></td>';
										}
										?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if(isset($rowData['idOcompra'])&&$rowData['idOcompra']!=0){ ?>
	<div class="" style="margin-top:10px;">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h6 class="panel-title"><i class="fa fa-usd" aria-hidden="true"></i> Documentos de Pago relacionados a la OC N° <?php echo N_doc($rowData['idOcompra'], 5); ?></h6>
				</div>
				<div class="panel-body">
					<div class="row invoice-payment">
						<table class="table">
							<thead>
								<tr role="row">
									<th>Documento</th>
									<th width="120">Fecha</th>
									<th width="120">Valor</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrDocRel as $doc) { ?>
									<tr class="odd">
										<td><?php echo $doc['Documento_pago'].' '.$doc['Documento_numero']; ?></td>
										<td><?php echo Fecha_estandar($doc['Documento_fechapago']); ?></td>
										<td><?php echo Valores($doc['Documento_valor'], 0); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="clearfix"></div>

<section class="invoice">


	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['TipoDoc']?>.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php
		//se verifica el tipo de movimiento
		switch ($rowData['idTipo']) {
			//Ingreso de Productos a bodega
			case 1:
			case 10:
			case 11:
				echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Empresa Origen
					<address>
						<strong>'.$rowData['NombreProveedor'].'</strong><br/>
						'.$rowData['CiudadProveedor'].', '.$rowData['ComunaProveedor'].'<br/>
						'.$rowData['DireccionProveedor'].'<br/>
						Fono Fijo: '.formatPhone($rowData['Fono1Proveedor']).'<br/>
						Celular: '.formatPhone($rowData['Fono2Proveedor']).'<br/>
						Fax: '.$rowData['FaxProveedor'].'<br/>
						Rut: '.$rowData['RutProveedor'].'<br/>
						Email: '.$rowData['EmailProveedor'].'<br/>
						Contacto: '.$rowData['PersonaContactoProveedor'].'<br/>
						Giro de la Empresa: '.$rowData['GiroProveedor'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Empresa Destino
					<address>
						<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
						'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						'.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>'.$rowData['Documento'].' N°'.$rowData['N_Doc'].'</strong><br/>
					<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>';

					if(isset($rowData['Estado'])&&$rowData['Estado']!=''){
						echo '<strong>Estado: </strong>'.$rowData['Estado'].'<br/>';
					}
					if(isset($rowData['Pago_fecha'])&&$rowData['Pago_fecha']!=''&&$rowData['Pago_fecha']!='0000-00-00'){
						echo '<strong>Vencimiento : </strong>'.Fecha_estandar($rowData['Pago_fecha']).'<br/>';
					}
					/*if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						echo '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						echo '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}*/
					if(isset($rowData['idOcompra'])&&$rowData['idOcompra']!=''&&$rowData['idOcompra']!=0){
						echo '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['idOcompra'], 5).'<br/>';
					} 
					if(isset($rowData['OC_Ventas'])&&$rowData['OC_Ventas']!=''&&$rowData['OC_Ventas']!=0){
						echo '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['OC_Ventas'], 5).'<br/>';
					}
					if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
						echo '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
						if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){echo ' - '.$rowData['CentroCosto_Level_1'];}
						if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){echo ' - '.$rowData['CentroCosto_Level_2'];}
						if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){echo ' - '.$rowData['CentroCosto_Level_3'];}
						if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){echo ' - '.$rowData['CentroCosto_Level_4'];}
						if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){echo ' - '.$rowData['CentroCosto_Level_5'];}
						echo '<br/>';
					}
					if(isset($rowData['fecha_fact_desde'])&&$rowData['fecha_fact_desde']!=''&&$rowData['fecha_fact_desde']!='0000-00-00'){
						echo '<strong>Facturacion Desde : </strong>'.Fecha_estandar($rowData['fecha_fact_desde']).'<br/>';
					}
					if(isset($rowData['fecha_fact_hasta'])&&$rowData['fecha_fact_hasta']!=''&&$rowData['fecha_fact_hasta']!='0000-00-00'){
						echo '<strong>Facturacion Hasta : </strong>'.Fecha_estandar($rowData['fecha_fact_hasta']).'<br/>';
					}
					if(isset($rowData['idUsoIVA'])&&$rowData['idUsoIVA']!=''&&$rowData['idUsoIVA']==1){
						echo '<strong>Exento de IVA : </strong>Factura exenta de IVA<br/>';
					} 
					
				echo '</div>';

				break;
			//Egreso de Productos de bodega
			case 2:
			case 12:
			case 13:
				echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Empresa Origen
					<address>
						<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
						'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						'.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Empresa Destino
					<address>
						<strong>'.$rowData['NombreCliente'].'</strong><br/>
						'.$rowData['CiudadCliente'].', '.$rowData['ComunaProveedor'].'<br/>
						'.$rowData['DireccionCliente'].'<br/>
						Fono Fijo: '.formatPhone($rowData['Fono1Cliente']).'<br/>
						Celular: '.formatPhone($rowData['Fono2Cliente']).'<br/>
						Fax: '.$rowData['FaxCliente'].'<br/>
						Rut: '.$rowData['RutCliente'].'<br/>
						Email: '.$rowData['EmailCliente'].'<br/>
						Contacto: '.$rowData['PersonaContactoCliente'].'<br/>
						Giro de la Empresa: '.$rowData['GiroCliente'].'
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>'.$rowData['Documento'].' N°'.$rowData['N_Doc'].'</strong><br/>
					<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
					<strong>Vendedor: </strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellido'].'<br/>';

					if(isset($rowData['Estado'])&&$rowData['Estado']!=''){
						echo '<strong>Estado: </strong>'.$rowData['Estado'].'<br/>';
					}
					if(isset($rowData['Pago_fecha'])&&$rowData['Pago_fecha']!=''&&$rowData['Pago_fecha']!='0000-00-00'){
						echo '<strong>Vencimiento : </strong>'.Fecha_estandar($rowData['Pago_fecha']).'<br/>';
					}
					if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
						echo '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
					}
					if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
						echo '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
					}
					if(isset($rowData['idOcompra'])&&$rowData['idOcompra']!=''&&$rowData['idOcompra']!=0){
						echo '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['idOcompra'], 5).'<br/>';
					} 
					if(isset($rowData['OC_Ventas'])&&$rowData['OC_Ventas']!=''&&$rowData['OC_Ventas']!=0){
						echo '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['OC_Ventas'], 5).'<br/>';
					} 
					if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
						echo '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
						if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){echo ' - '.$rowData['CentroCosto_Level_1'];}
						if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){echo ' - '.$rowData['CentroCosto_Level_2'];}
						if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){echo ' - '.$rowData['CentroCosto_Level_3'];}
						if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){echo ' - '.$rowData['CentroCosto_Level_4'];}
						if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){echo ' - '.$rowData['CentroCosto_Level_5'];}
						echo '<br/>';
					}
					if(isset($rowData['fecha_fact_desde'])&&$rowData['fecha_fact_desde']!=''&&$rowData['fecha_fact_desde']!='0000-00-00'){
						echo '<strong>Facturacion Desde : </strong>'.Fecha_estandar($rowData['fecha_fact_desde']).'<br/>';
					}
					if(isset($rowData['fecha_fact_hasta'])&&$rowData['fecha_fact_hasta']!=''&&$rowData['fecha_fact_hasta']!='0000-00-00'){
						echo '<strong>Facturacion Hasta : </strong>'.Fecha_estandar($rowData['fecha_fact_hasta']).'<br/>';
					}
					if(isset($rowData['idUsoIVA'])&&$rowData['idUsoIVA']!=''&&$rowData['idUsoIVA']==1){
						echo '<strong>Exento de IVA : </strong>Factura exenta de IVA<br/>';
					}
					
				echo '
				</div>';
				
				break;
		} ?>

	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="4">Detalle</th>
						<th width="160" align="right">Valor Total</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrServicios!=false && !empty($arrServicios) && $arrServicios!='') { ?>
						<tr class="active"><td colspan="5"><strong>Servicios</strong></td></tr>
						<?php foreach ($arrServicios as $prod) { ?>
							<tr>
								<td colspan="2"><?php echo $prod['Nombre']; ?></td>
								<?php if(isset($prod['Cantidad_ing'])&&$prod['Cantidad_ing']!=0){ ?>
									<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad_ing']).' '.$prod['Frecuencia']; ?></td>
								<?php }elseif(isset($prod['Cantidad_eg'])&&$prod['Cantidad_eg']!=0){ ?>
									<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad_eg']).' '.$prod['Frecuencia']; ?></td>
								<?php } ?>
								<td align="right"><?php echo Valores(Cantidades_decimales_justos($prod['Valor']), 0).' x '.$prod['Frecuencia']; ?></td>
								<td align="right"><?php echo Valores(Cantidades_decimales_justos($prod['ValorTotal']), 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrGuias!=false && !empty($arrGuias) && $arrGuias!='') { ?>
						<tr class="active"><td colspan="5"><strong>Guias de Despacho</strong></td></tr>
						<?php foreach ($arrGuias as $guia) { ?>
							<tr>
								<td colspan="4"><?php echo 'Guia de Despacho N°'.$guia['N_Doc']; ?></td>
								<td align="right"><?php echo Valores($guia['ValorNeto'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrOtros!=false && !empty($arrOtros) && $arrOtros!='') { ?>
						<tr class="active"><td colspan="5"><strong>Otros</strong></td></tr>
						<?php foreach ($arrOtros as $otro) { ?>
							<tr>
								<td colspan="4"><?php echo $otro['Nombre']; ?></td>
								<td align="right"><?php echo Valores($otro['vTotal'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
			<table class="table">
				<tbody>
					<?php if(isset($rowData['ValorNeto'])&&$rowData['ValorNeto']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Subtotal</strong></td>
							<td width="160" align="right"><?php echo Valores($rowData['ValorNeto'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php foreach ($arrDescuentos as $descuentos) { ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo 'Descuento: '.$descuentos['Nombre']?></strong></td>
							<td width="160" align="right"><?php echo Valores($descuentos['vTotal'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['ValorNetoImp'])&&$rowData['ValorNetoImp']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Neto Imponible</strong></td>
							<td width="160" align="right"><?php echo Valores($rowData['ValorNetoImp'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_01'])&&$rowData['Impuesto_01']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[0]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_01'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_02'])&&$rowData['Impuesto_02']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[1]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_02'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_03'])&&$rowData['Impuesto_03']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[2]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_03'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_04'])&&$rowData['Impuesto_04']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[3]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_04'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_05'])&&$rowData['Impuesto_05']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[4]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_05'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_06'])&&$rowData['Impuesto_06']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[5]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_06'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_07'])&&$rowData['Impuesto_07']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[6]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_07'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_08'])&&$rowData['Impuesto_08']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[7]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_08'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_09'])&&$rowData['Impuesto_09']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[8]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_09'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['Impuesto_10'])&&$rowData['Impuesto_10']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong><?php echo $impuestos[9]['nimp']; ?></strong></td>
							<td align="right"><?php echo Valores($rowData['Impuesto_10'], 0); ?></td>
						</tr>
					<?php } ?>
					<?php if(isset($rowData['ValorTotal'])&&$rowData['ValorTotal']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Total</strong></td>
							<td align="right"><?php echo Valores($rowData['ValorTotal'], 0); ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
		</div>
	</div>

	<?php
	//Traspaso de Productos a otra Empresa
	if($rowData['idTipo']==6){ ?>

		<div class="row firma">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont"><p>Firma Transportista</p></div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont" style="left:50%;"><p>Firma Receptor</p></div>
		</div>

	<?php } ?>

	<?php
	$zz  = '?idSistema='.simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual());
	$zz .= '&view='.$_GET['view'];
	?>
	<div class="row no-print">
		<div class="col-xs-12">
			<a target="new" href="view_mov_servicios_to_print.php<?php echo $zz ?>" class="btn btn-default">
				<i class="fa fa-print" aria-hidden="true"></i> Imprimir
			</a>

			<a target="new" href="view_mov_servicios_to_pdf.php<?php echo $zz ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
				<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF
			</a>
		</div>
	</div>
      
</section>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">

	<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="3">Historial</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th>Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>

	<?php if ($arrArchivo!=false && !empty($arrArchivo) && $arrArchivo!=''){ ?>
		<table id="items" style="margin-bottom: 20px;">
			<tbody>
				<tr>
					<th colspan="6">Archivos Adjuntos</th>
				</tr>
				<?php foreach ($arrArchivo as $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $producto['Nombre']; ?></td>
						<td width="160">
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="1download.php?dir=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip" ><i class="fa fa-download" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
    
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
