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
require_once 'core/Load.Utils.PDF.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
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
//Se buscan la imagen i el tipo de PDF
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
	//Consulta
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema ='.simpleDecode($_GET['idSistema'], fecha_actual()), $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/********************************************************************/
// consulto los datos
$SIS_query = '
bodegas_productos_facturacion.idTipo,
bodegas_productos_facturacion.idFacturacion,
bodegas_productos_facturacion.Creacion_fecha,
bodegas_productos_facturacion.N_Doc,
bodegas_productos_facturacion.Observaciones,
bodegas_productos_facturacion.idOcompra,
bodegas_productos_facturacion.OC_Ventas,
bodegas_productos_facturacion.idOT,
bodega1.Nombre AS BodegaDesde,
bodega2.Nombre AS BodegaHacia,
bodegas_productos_facturacion_tipo.Nombre AS TipoDoc,
core_documentos_mercantiles.Nombre AS Documento,
usuarios_listado.Nombre AS NombreUsuario,
bodegas_productos_facturacion.ValorNeto,
bodegas_productos_facturacion.ValorNetoImp,
bodegas_productos_facturacion.Impuesto_01,
bodegas_productos_facturacion.Impuesto_02,
bodegas_productos_facturacion.Impuesto_03,
bodegas_productos_facturacion.Impuesto_04,
bodegas_productos_facturacion.Impuesto_05,
bodegas_productos_facturacion.Impuesto_06,
bodegas_productos_facturacion.Impuesto_07,
bodegas_productos_facturacion.Impuesto_08,
bodegas_productos_facturacion.Impuesto_09,
bodegas_productos_facturacion.Impuesto_10,
bodegas_productos_facturacion.ValorTotal,
bodegas_productos_facturacion.fecha_fact_desde,
bodegas_productos_facturacion.fecha_fact_hasta,
bodegas_productos_facturacion.idUsoIVA,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

sistema_destino.Nombre AS SistemaDestino,
sistema_destino.Rut AS SistemaDestinoRut,
sis_des_ciudad.Nombre AS SistemaDestinoCiudad,
sis_des_comuna.Nombre AS SistemaDestinoComuna,
sistema_destino.Direccion AS SistemaDestinoDireccion,
sistema_destino.Contacto_Fono1 AS SistemaDestinoFono,
sistema_destino.Contacto_Fax AS SistemaDestinoFax,
sistema_destino.email_principal AS SistemaDestinoEmail,

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

core_estado_facturacion.Nombre AS Estado,
bodegas_productos_facturacion.Pago_fecha,
sistema_documentos_pago.Nombre AS DocPago,
bodegas_productos_facturacion.N_DocPago,
bodegas_productos_facturacion.F_Pago,

centrocosto_listado.Nombre AS CentroCosto_Nombre,
centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5';
$SIS_join  = '
LEFT JOIN `bodegas_productos_listado`    bodega1    ON bodega1.idBodega                             = bodegas_productos_facturacion.idBodegaOrigen
LEFT JOIN `bodegas_productos_listado`    bodega2    ON bodega2.idBodega                             = bodegas_productos_facturacion.idBodegaDestino
LEFT JOIN `bodegas_productos_facturacion_tipo`      ON bodegas_productos_facturacion_tipo.idTipo    = bodegas_productos_facturacion.idTipo
LEFT JOIN `core_documentos_mercantiles`             ON core_documentos_mercantiles.idDocumentos     = bodegas_productos_facturacion.idDocumentos
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                   = bodegas_productos_facturacion.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema                     = bodegas_productos_facturacion.idSistema
LEFT JOIN `core_sistemas`   sistema_destino         ON sistema_destino.idSistema                    = bodegas_productos_facturacion.idSistemaDestino
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                       = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                       = sistema_origen.idComuna
LEFT JOIN `core_ubicacion_ciudad`   sis_des_ciudad  ON sis_des_ciudad.idCiudad                      = sistema_destino.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_des_comuna  ON sis_des_comuna.idComuna                      = sistema_destino.idComuna
LEFT JOIN `proveedor_listado`                       ON proveedor_listado.idProveedor                = bodegas_productos_facturacion.idProveedor
LEFT JOIN `clientes_listado`                        ON clientes_listado.idCliente                   = bodegas_productos_facturacion.idCliente
LEFT JOIN `core_ubicacion_ciudad`    provciudad     ON provciudad.idCiudad                          = proveedor_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   provcomuna     ON provcomuna.idComuna                          = proveedor_listado.idComuna
LEFT JOIN `core_ubicacion_ciudad`    clienciudad    ON clienciudad.idCiudad                         = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   cliencomuna    ON cliencomuna.idComuna                         = clientes_listado.idComuna
LEFT JOIN `core_estado_facturacion`                 ON core_estado_facturacion.idEstado             = bodegas_productos_facturacion.idEstado
LEFT JOIN `sistema_documentos_pago`                 ON sistema_documentos_pago.idDocPago            = bodegas_productos_facturacion.idDocPago
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador            = bodegas_productos_facturacion.idTrabajador
LEFT JOIN `centrocosto_listado`                     ON centrocosto_listado.idCentroCosto            = bodegas_productos_facturacion.idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`             ON centrocosto_listado_level_1.idLevel_1        = bodegas_productos_facturacion.idLevel_1
LEFT JOIN `centrocosto_listado_level_2`             ON centrocosto_listado_level_2.idLevel_2        = bodegas_productos_facturacion.idLevel_2
LEFT JOIN `centrocosto_listado_level_3`             ON centrocosto_listado_level_3.idLevel_3        = bodegas_productos_facturacion.idLevel_3
LEFT JOIN `centrocosto_listado_level_4`             ON centrocosto_listado_level_4.idLevel_4        = bodegas_productos_facturacion.idLevel_4
LEFT JOIN `centrocosto_listado_level_5`             ON centrocosto_listado_level_5.idLevel_5        = bodegas_productos_facturacion.idLevel_5';
$SIS_where = 'bodegas_productos_facturacion.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'bodegas_productos_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
productos_listado.Nombre,
sistema_productos_uml.Nombre AS Unimed,
sistema_productos_uml.Abreviatura AS UnimedAbrev,
bodegas_productos_facturacion_existencias.Cantidad_ing,
bodegas_productos_facturacion_existencias.Cantidad_eg,
bodegas_productos_facturacion_existencias.Valor,
bodegas_productos_facturacion_existencias.ValorTotal,
productos_listado.ValorIngreso AS  ValorTraspaso,
bodegas_productos_listado.Nombre AS NombreBodega';
$SIS_join  = '
LEFT JOIN `productos_listado`            ON productos_listado.idProducto           = bodegas_productos_facturacion_existencias.idProducto
LEFT JOIN `sistema_productos_uml`        ON sistema_productos_uml.idUml            = productos_listado.idUml
LEFT JOIN `bodegas_productos_listado`    ON bodegas_productos_listado.idBodega     = bodegas_productos_facturacion_existencias.idBodega';
$SIS_where = 'bodegas_productos_facturacion_existencias.idFacturacion ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = 'Nombre,vTotal';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOtros');

/*****************************************/
// Se trae un listado con todos los impuestos existentes
$SIS_query = 'Nombre,vTotal';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrDescuentos = array();
$arrDescuentos = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion_descuentos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDescuentos');

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
$arrGuias = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGuias');

/*****************************************/
$nn = 0;
$impuestos = array();
foreach ($arrImpuestos as $impto) {
	$impuestos[$nn]['nimp'] = $impto['Nombre'].' ('.Cantidades_decimales_justos($impto['Porcentaje']).'%)';
	$nn++;
}

/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
	body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;}
	table {border-collapse: collapse;border-spacing: 0;}
	tr.oddrow td{display: line;border-bottom: 1px solid #EEE;}
	.tableline td, .tableline th{border-bottom: 1px solid #EEE;line-height: 1.42857143;}
</style>';

$html .= '
<table style="border: 1px solid #f4f4f4;margin: 1%; width: 98%;"   cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="2" rowspan="1" style="vertical-align: top;">'.$rowData['TipoDoc'].'</td>
							<td style="vertical-align: top;">Fecha Creacion: '.Fecha_estandar($rowData['Creacion_fecha']).'</td>
						</tr>
						<tr>';

							//se verifica el tipo de movimiento
							switch ($rowData['idTipo']) {
								//Ingreso de Productos a bodega
								case 1:
								case 10:
								case 11:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
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
									</td>

									<td style="vertical-align: top;width:33%;">
										Empresa Destino
											<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
											'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
											'.$rowData['SistemaOrigenDireccion'].'<br/>
											Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
											Rut: '.$rowData['SistemaOrigenRut'].'<br/>
											Email: '.$rowData['SistemaOrigenEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
										<strong>'.$rowData['Documento'].' N°'.$rowData['N_Doc'].'</strong><br/>
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega Destino: </strong>'.$rowData['BodegaHacia'].'<br/>';
										if(isset($rowData['Estado'])&&$rowData['Estado']!=''){
											$html .= '<strong>Estado: </strong>'.$rowData['Estado'].'<br/>';
										}
										if(isset($rowData['Pago_fecha'])&&$rowData['Pago_fecha']!=''&&$rowData['Pago_fecha']!='0000-00-00'){
											$html .= '<strong>Vencimiento : </strong>'.Fecha_estandar($rowData['Pago_fecha']).'<br/>';
										}
										/*if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
											$html .= '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
										}
										if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
											$html .= '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
										}*/
										if(isset($rowData['idOcompra'])&&$rowData['idOcompra']!=''&&$rowData['idOcompra']!=0){
											$html .= '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['idOcompra'], 5).'<br/>';
										}
										if(isset($rowData['OC_Ventas'])&&$rowData['OC_Ventas']!=''&&$rowData['OC_Ventas']!=0){
											$html .= '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['OC_Ventas'], 5).'<br/>';
										}
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										if(isset($rowData['fecha_fact_desde'])&&$rowData['fecha_fact_desde']!=''&&$rowData['fecha_fact_desde']!='0000-00-00'){
											$html .= '<strong>Facturacion Desde : </strong>'.Fecha_estandar($rowData['fecha_fact_desde']).'<br/>';
										}
										if(isset($rowData['fecha_fact_hasta'])&&$rowData['fecha_fact_hasta']!=''&&$rowData['fecha_fact_hasta']!='0000-00-00'){
											$html .= '<strong>Facturacion Hasta : </strong>'.Fecha_estandar($rowData['fecha_fact_hasta']).'<br/>';
										}
										if(isset($rowData['idUsoIVA'])&&$rowData['idUsoIVA']!=''&&$rowData['idUsoIVA']==1){
											$html .= '<strong>Exento de IVA : </strong>Factura exenta de IVA<br/>';
										}
										$html .= '</td>';

									break;
								//Egreso de Productos de bodega
								case 2:
								case 12:
								case 13:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
										<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
										'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
										'.$rowData['SistemaOrigenDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
										Rut: '.$rowData['SistemaOrigenRut'].'<br/>
										Email: '.$rowData['SistemaOrigenEmail'].'
									</td>

									<td style="vertical-align: top;width:33%;">
										Empresa Destino
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
									</td>

									<td style="vertical-align: top;width:33%;">
										<strong>'.$rowData['Documento'].' N°'.$rowData['N_Doc'].'</strong><br/>
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega Origen: </strong>'.$rowData['BodegaDesde'].'<br/>
										<strong>Vendedor: </strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellido'].'<br/>';
										if(isset($rowData['Estado'])&&$rowData['Estado']!=''){
											$html .= '<strong>Estado: </strong>'.$rowData['Estado'].'<br/>';
										}
										if(isset($rowData['Pago_fecha'])&&$rowData['Pago_fecha']!=''&&$rowData['Pago_fecha']!='0000-00-00'){
											$html .= '<strong>Vencimiento : </strong>'.Fecha_estandar($rowData['Pago_fecha']).'<br/>';
										}
										if(isset($rowData['DocPago'])&&$rowData['DocPago']!=''){
											$html .= '<strong>Dto de Pago : </strong>'.$rowData['DocPago'].' '.$rowData['N_DocPago'].'<br/>';
										}
										if(isset($rowData['F_Pago'])&&$rowData['F_Pago']!=''&&$rowData['F_Pago']!='0000-00-00'){
											$html .= '<strong>Fecha Pagado: </strong>'.Fecha_estandar($rowData['F_Pago']).'<br/>';
										}
										if(isset($rowData['idOcompra'])&&$rowData['idOcompra']!=''&&$rowData['idOcompra']!=0){
											$html .= '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['idOcompra'], 5).'<br/>';
										}
										if(isset($rowData['OC_Ventas'])&&$rowData['OC_Ventas']!=''&&$rowData['OC_Ventas']!=0){
											$html .= '<strong>OC Relacionada N°: </strong>'.N_doc($rowData['OC_Ventas'], 5).'<br/>';
										}
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										if(isset($rowData['fecha_fact_desde'])&&$rowData['fecha_fact_desde']!=''&&$rowData['fecha_fact_desde']!='0000-00-00'){
											$html .= '<strong>Facturacion Desde : </strong>'.Fecha_estandar($rowData['fecha_fact_desde']).'<br/>';
										}
										if(isset($rowData['fecha_fact_hasta'])&&$rowData['fecha_fact_hasta']!=''&&$rowData['fecha_fact_hasta']!='0000-00-00'){
											$html .= '<strong>Facturacion Hasta : </strong>'.Fecha_estandar($rowData['fecha_fact_hasta']).'<br/>';
										}
										if(isset($rowData['idUsoIVA'])&&$rowData['idUsoIVA']!=''&&$rowData['idUsoIVA']==1){
											$html .= '<strong>Exento de IVA : </strong>Factura exenta de IVA<br/>';
										}
										$html .= '
									</td>';
									break;
								//Gasto de Productos
								case 3:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
										<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
										'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
										'.$rowData['SistemaOrigenDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
										Rut: '.$rowData['SistemaOrigenRut'].'<br/>
										Email: '.$rowData['SistemaOrigenEmail'].'
									</td>

									<td style="vertical-align: top;width:33%;">

									</td>

									<td style="vertical-align: top;width:33%;">
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega Origen: </strong>'.$rowData['BodegaDesde'].'<br/>';
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										$html .= '
									</td>';
									break;
								//Traspaso de Productos entre bodegas
								case 4:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
										<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
										'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
										'.$rowData['SistemaOrigenDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
										Rut: '.$rowData['SistemaOrigenRut'].'<br/>
										Email: '.$rowData['SistemaOrigenEmail'].'
									</td>

									<td style="vertical-align: top;width:33%;">

									</td>

									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega Origen: </strong>'.$rowData['BodegaDesde'].'<br/>
										<strong>Bodega Destino: </strong>'.$rowData['BodegaHacia'].'<br/>';
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										$html .= '
									</td>';
									break;
								//Transformacion de Productos
								case 5:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
										<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
										'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
										'.$rowData['SistemaOrigenDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
										Rut: '.$rowData['SistemaOrigenRut'].'<br/>
										Email: '.$rowData['SistemaOrigenEmail'].'
									</td>

									<td style="vertical-align: top;width:33%;">

									</td>

									<td style="vertical-align: top;width:33%;">
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega Origen: </strong>'.$rowData['BodegaDesde'].'<br/>
										<strong>Bodega Destino: </strong>'.$rowData['BodegaHacia'].'<br/>';
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										$html .= '
									</td>';
									break;
								//traspaso maeriales a otra empresa
								case 6:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
										<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
										'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
										'.$rowData['SistemaOrigenDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
										Rut: '.$rowData['SistemaOrigenRut'].'<br/>
										Email: '.$rowData['SistemaOrigenEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
										Empresa Destino
										<strong>'.$rowData['SistemaDestino'].'</strong><br/>
										'.$rowData['SistemaDestinoCiudad'].' '.$rowData['SistemaDestinoComuna'].'<br/>
										'.$rowData['SistemaDestinoDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaDestinoFono']).'<br/>
										Fax: '.$rowData['SistemaDestinoFax'].'<br/>
										Rut: '.$rowData['SistemaDestinoRut'].'<br/>
										Email: '.$rowData['SistemaDestinoEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega de destino:</strong> '.$rowData['BodegaHacia'].'<br/>';
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										$html .= '
									</td>';
									break;
								//Gasto de Productos en una Orden de Trabajo
								case 7:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
										<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
										'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
										'.$rowData['SistemaOrigenDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
										Rut: '.$rowData['SistemaOrigenRut'].'<br/>
										Email: '.$rowData['SistemaOrigenEmail'].'
									</td>

									<td style="vertical-align: top;width:33%;">

									</td>

									<td style="vertical-align: top;width:33%;">
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega utilizada:</strong> '.$rowData['BodegaDesde'].'<br/>
										<strong>Orden de Trabajo N°:</strong> '.N_doc($rowData['idOT'], 5).'<br/>';
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										$html .= '
									</td>';
									break;
								//Traspaso de Productos Manual a otra Empresa
								case 8:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
										<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
										'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
										'.$rowData['SistemaOrigenDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
										Rut: '.$rowData['SistemaOrigenRut'].'<br/>
										Email: '.$rowData['SistemaOrigenEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
										Empresa Destino
										<strong>'.$rowData['SistemaDestino'].'</strong><br/>
										'.$rowData['SistemaDestinoCiudad'].' '.$rowData['SistemaDestinoComuna'].'<br/>
										'.$rowData['SistemaDestinoDireccion'].'<br/>
										Fono: '.formatPhone($rowData['SistemaDestinoFono']).'<br/>
										Fax: '.$rowData['SistemaDestinoFax'].'<br/>
										Rut: '.$rowData['SistemaDestinoRut'].'<br/>
										Email: '.$rowData['SistemaDestinoEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>';
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										$html .= '
									</td>';
									break;
								//Ingreso manual de productos
								case 9:
									$html .= '
									<td style="vertical-align: top; width:33%;">
										Empresa Origen
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
									</td>

									<td style="vertical-align: top;width:33%;">
										Empresa Destino
											<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
											'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
											'.$rowData['SistemaOrigenDireccion'].'<br/>
											Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
											Rut: '.$rowData['SistemaOrigenRut'].'<br/>
											Email: '.$rowData['SistemaOrigenEmail'].'
									</td>
									<td style="vertical-align: top;width:33%;">
										<strong>Doc N°'.N_doc($rowData['idFacturacion'], 5).'</strong><br/>
										<strong>Bodega Destino: </strong>'.$rowData['BodegaHacia'].'<br/>';
										if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
											$html .= '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
											if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){$html .= ' - '.$rowData['CentroCosto_Level_1'];}
											if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){$html .= ' - '.$rowData['CentroCosto_Level_2'];}
											if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){$html .= ' - '.$rowData['CentroCosto_Level_3'];}
											if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){$html .= ' - '.$rowData['CentroCosto_Level_4'];}
											if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){$html .= ' - '.$rowData['CentroCosto_Level_5'];}
											$html .= '<br/>';
										}
										$html .= '
									</td>';
									break;
							}

						$html .= '</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:56%;"><strong>Detalle</strong></th>
							<th style="vertical-align: top; width:11%;"><strong>Ingreso</strong></th>
							<th style="vertical-align: top; width:11%;"><strong>Egreso</strong></th>
							<th style="vertical-align: top; width:11%;"><strong>Valor</strong></th>
							<th style="vertical-align: top; width:11%;"><strong>Valor Total</strong></th>
						</tr>
					</thead>
					<tbody>';
					//si existen productos
					if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') {
						$html .= '<tr style="background-color: #f9f9f9;"><td colspan="5"><strong>Productos</strong></td></tr>';
						foreach ($arrProductos as $prod) {
							$html .= '<tr>
								<td style="vertical-align: top;"><strong>'.$prod['NombreBodega'].'</strong> - '.$prod['Nombre'].'</td>';

								//Verifico la existencia de la abreviatura de la unidad de medida
								if(isset($prod['UnimedAbrev'])&&$prod['UnimedAbrev']!=''){
									$prodUnimed = $prod['UnimedAbrev'];
								}else{
									$prodUnimed = $prod['Unimed'];
								}
								if(isset($prod['Cantidad_ing'])&&$prod['Cantidad_ing']!=0){
									$html .= '<td style="vertical-align: top;">'.Cantidades_decimales_justos($prod['Cantidad_ing']).' '.$prodUnimed.'</td>';
									$html .= '<td style="vertical-align: top;"></td>';
								}
								if(isset($prod['Cantidad_eg'])&&$prod['Cantidad_eg']!=0){
									$html .= '<td style="vertical-align: top;"></td>';
									$html .= '<td style="vertical-align: top;">'.Cantidades_decimales_justos($prod['Cantidad_eg']).' '.$prodUnimed.'</td>';
								}
								$html .= '<td align="right" style="vertical-align: top;">'.Valores(Cantidades_decimales_justos($prod['ValorTraspaso']), 0).' x '.$prodUnimed.'</td>';
								$html .= '<td align="right">'.Valores(Cantidades_decimales_justos($prod['ValorTotal']), 0).'</td>

							</tr>';
						}
					}

					//si existen guias
					if ($arrGuias!=false && !empty($arrGuias) && $arrGuias!='') {
						$html .= '<tr style="background-color: #f9f9f9;"><td colspan="5"><strong>Guias de Despacho</strong></td></tr>';
						foreach ($arrGuias as $guia) {
							$html .= '<tr>
								<td colspan="4" style="vertical-align: top;">Guia de Despacho N°'.$guia['N_Doc'].'</td>
								<td align="right">'.Valores($guia['ValorNeto'], 0).'</td>
							</tr>';
						}
					}

					//si existen guias
					if ($arrOtros!=false && !empty($arrOtros) && $arrOtros!='') {
						$html .= '<tr style="background-color: #f9f9f9;"><td colspan="5"><strong>Otros</strong></td></tr>';
						foreach ($arrOtros as $otro) {
							$html .= '<tr>
								<td colspan="4" style="vertical-align: top;">'.$otro['Nombre'].'</td>
								<td align="right">'.Valores($otro['vTotal'], 0).'</td>
							</tr>';
						}
					}

					//Recorro y guard el nombre de los impuestos
					if(isset($rowData['ValorNeto'])&&$rowData['ValorNeto']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Subtotal</strong></td>
							<td align="right">'.Valores($rowData['ValorNeto'], 0).'</td>
						</tr>';
					}
					foreach ($arrDescuentos as $descuentos) {
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Descuento: '.$descuentos['Nombre'].'</strong></td>
							<td align="right">'.Valores($descuentos['vTotal'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['ValorNetoImp'])&&$rowData['ValorNetoImp']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4" align="right"><strong>Neto Imponible</strong></td>
							<td align="right">'.Valores($rowData['ValorNetoImp'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_01'])&&$rowData['Impuesto_01']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[0]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_01'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_02'])&&$rowData['Impuesto_02']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[1]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_02'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_03'])&&$rowData['Impuesto_03']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[2]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_03'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_04'])&&$rowData['Impuesto_04']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[3]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_04'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_05'])&&$rowData['Impuesto_05']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[4]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_05'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_06'])&&$rowData['Impuesto_06']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[5]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_06'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_07'])&&$rowData['Impuesto_07']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[6]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_07'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_08'])&&$rowData['Impuesto_08']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[7]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_08'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_09'])&&$rowData['Impuesto_09']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[8]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_09'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['Impuesto_10'])&&$rowData['Impuesto_10']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>'.$impuestos[9]['nimp'].'</strong></td>
							<td align="right">'.Valores($rowData['Impuesto_10'], 0).'</td>
						</tr>';
					}
					if(isset($rowData['ValorTotal'])&&$rowData['ValorTotal']!=0){
						$html .= '<tr class="invoice-total" bgcolor="#f1f1f1">
							<td colspan="4"  align="right"><strong>Total</strong></td>
							<td align="right">'.Valores($rowData['ValorTotal'], 0).'</td>
						</tr>';
					}
				$html .= '
					</tbody>
				</table>
				<br/>
				<br/>

				<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
					<tbody><tr><td style="vertical-align: top;">Observaciones:</td></tr></tbody>
				</table>
				<table style="text-align: left; width: 100%;margin-top:20px;" cellpadding="5" cellspacing="0">
					<tbody>
						<tr>
							<td style="vertical-align: top;text-align: left;background-color: #f9f9f9;border: 1px solid #EEE;">'.$rowData['Observaciones'].'</td>
						</tr>
					</tbody>
				</table>';

				if($rowData['idTipo']==6){
					$html .= '
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>

					<table style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="vertical-align: top;text-align:center;">Firma Transportista</td>
								<td style="vertical-align: top;text-align:center;">Firma Receptor</td>
							</tr>
						</tbody>
					</table>';
				}

			$html .= '</td>
		</tr>
	</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = $rowData['TipoDoc'];
$pdf_subtitulo  = '';
$pdf_file       = $rowData['TipoDoc'].'.pdf';
$OpcDom         = "'A4', 'landscape'";
$OpcTcpOrt      = "P";  //P->PORTRAIT - L->LANDSCAPE
$OpcTcpPg       = "A4"; //Tipo de Hoja
/********************************************************************************/
//Se verifica que este configurado el motor de pdf
if(isset($rowEmpresa['idOpcionesGen_5'])&&$rowEmpresa['idOpcionesGen_5']!=0){
	switch ($rowEmpresa['idOpcionesGen_5']) {
		/************************************************************************/
		//TCPDF
		case 1:

			require_once('../LIBS_php/tcpdf/tcpdf.php');

			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Victor Reyes');
			$pdf->SetTitle('');
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
				if(isset($rowEmpresa['Config_imgLogo'])&&$rowEmpresa['Config_imgLogo']!=''){
					$logo = '../../../../'.DB_SITE_MAIN_PATH.'/upload/'.$rowEmpresa['Config_imgLogo'];
				}else{
					$logo = '../../../../Legacy/1tek_public/img/logo_empresa.jpg';
				}
			}else{
				$logo = '../../../../Legacy/1tek_public/img/logo_empresa.jpg';
			}
			$pdf->SetHeaderData($logo, 40, $pdf_titulo, $pdf_subtitulo);

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')){
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			//Se crea el archivo
			$pdf->SetFont('helvetica', '', 10);
			$pdf->AddPage($OpcTcpOrt, $OpcTcpPg);
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->lastPage();
			$pdf->Output(DeSanitizar($pdf_file), 'I');

			break;
		/************************************************************************/
		//DomPDF (Solo compatible con PHP 5.x)
		case 2:
			require_once '../LIBS_php/dompdf/autoload.inc.php';
			// reference the Dompdf namespace
			//use Dompdf\Dompdf;
			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->setPaper($OpcDom);
			$dompdf->render();
			$dompdf->stream(DeSanitizar($pdf_file));
			break;

	}
}

?>
