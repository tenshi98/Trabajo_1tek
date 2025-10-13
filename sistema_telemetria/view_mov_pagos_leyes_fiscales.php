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
pagos_leyes_fiscales.fecha_auto,
pagos_leyes_fiscales.Periodo_Ano,
pagos_leyes_fiscales.Periodo_Mes,
pagos_leyes_fiscales.Pago_fecha,
pagos_leyes_fiscales.Observaciones,
pagos_leyes_fiscales.Porcentaje_PPM,
pagos_leyes_fiscales.Saldos_IVA_Anterior,
pagos_leyes_fiscales.Saldos_IVA_Actual,
pagos_leyes_fiscales.IVA_TotalSaldo,
pagos_leyes_fiscales.IVA_MontoPago,
pagos_leyes_fiscales.IVA_Diferencia,
pagos_leyes_fiscales.PPM_Saldo,
pagos_leyes_fiscales.PPM_Pago,
pagos_leyes_fiscales.PPM_Diferencia,
pagos_leyes_fiscales.Retencion,
pagos_leyes_fiscales.ImpuestoRenta,
pagos_leyes_fiscales.TotalGeneral,
pagos_leyes_fiscales.TotalPagoGeneral,

core_sistemas.Nombre AS SistemaOrigen,
core_ubicacion_ciudad.Nombre AS SistemaOrigenCiudad,
core_ubicacion_comunas.Nombre AS SistemaOrigenComuna,
core_sistemas.Direccion AS SistemaOrigenDireccion,
core_sistemas.Contacto_Fono1 AS SistemaOrigenFono,
core_sistemas.email_principal AS SistemaOrigenEmail,
core_sistemas.Rut AS SistemaOrigenRut,
usuarios_listado.Nombre AS Usuario,
core_estado_facturacion.Nombre AS EstadoPago,

IVA_Centro.Nombre AS IVA_CC_Nombre,
IVA_Centro_lv_1.Nombre AS IVA_CC_Level_1,
IVA_Centro_lv_2.Nombre AS IVA_CC_Level_2,
IVA_Centro_lv_3.Nombre AS IVA_CC_Level_3,
IVA_Centro_lv_4.Nombre AS IVA_CC_Level_4,
IVA_Centro_lv_5.Nombre AS IVA_CC_Level_5,
PPM_Centro.Nombre AS PPM_CC_Nombre,
PPM_Centro_lv_1.Nombre AS PPM_CC_Level_1,
PPM_Centro_lv_2.Nombre AS PPM_CC_Level_2,
PPM_Centro_lv_3.Nombre AS PPM_CC_Level_3,
PPM_Centro_lv_4.Nombre AS PPM_CC_Level_4,
PPM_Centro_lv_5.Nombre AS PPM_CC_Level_5,
RET_Centro.Nombre AS RET_CC_Nombre,
RET_Centro_lv_1.Nombre AS RET_CC_Level_1,
RET_Centro_lv_2.Nombre AS RET_CC_Level_2,
RET_Centro_lv_3.Nombre AS RET_CC_Level_3,
RET_Centro_lv_4.Nombre AS RET_CC_Level_4,
RET_Centro_lv_5.Nombre AS RET_CC_Level_5,
IMPRENT_Centro.Nombre AS IMPRENT_CC_Nombre,
IMPRENT_Centro_lv_1.Nombre AS IMPRENT_CC_Level_1,
IMPRENT_Centro_lv_2.Nombre AS IMPRENT_CC_Level_2,
IMPRENT_Centro_lv_3.Nombre AS IMPRENT_CC_Level_3,
IMPRENT_Centro_lv_4.Nombre AS IMPRENT_CC_Level_4,
IMPRENT_Centro_lv_5.Nombre AS IMPRENT_CC_Level_5';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                                    ON usuarios_listado.idUsuario        = pagos_leyes_fiscales.idUsuario
LEFT JOIN `core_sistemas`                                       ON core_sistemas.idSistema           = pagos_leyes_fiscales.idSistema
LEFT JOIN `core_ubicacion_ciudad`                               ON core_ubicacion_ciudad.idCiudad    = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`                              ON core_ubicacion_comunas.idComuna   = core_sistemas.idComuna
LEFT JOIN `core_estado_facturacion`                             ON core_estado_facturacion.idEstado  = pagos_leyes_fiscales.idEstadoPago
LEFT JOIN `centrocosto_listado`          IVA_Centro             ON IVA_Centro.idCentroCosto          = pagos_leyes_fiscales.IVA_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  IVA_Centro_lv_1        ON IVA_Centro_lv_1.idLevel_1         = pagos_leyes_fiscales.IVA_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  IVA_Centro_lv_2        ON IVA_Centro_lv_2.idLevel_2         = pagos_leyes_fiscales.IVA_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  IVA_Centro_lv_3        ON IVA_Centro_lv_3.idLevel_3         = pagos_leyes_fiscales.IVA_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  IVA_Centro_lv_4        ON IVA_Centro_lv_4.idLevel_4         = pagos_leyes_fiscales.IVA_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  IVA_Centro_lv_5        ON IVA_Centro_lv_5.idLevel_5         = pagos_leyes_fiscales.IVA_idLevel_5
LEFT JOIN `centrocosto_listado`          PPM_Centro             ON PPM_Centro.idCentroCosto          = pagos_leyes_fiscales.PPM_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  PPM_Centro_lv_1        ON PPM_Centro_lv_1.idLevel_1         = pagos_leyes_fiscales.PPM_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  PPM_Centro_lv_2        ON PPM_Centro_lv_2.idLevel_2         = pagos_leyes_fiscales.PPM_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  PPM_Centro_lv_3        ON PPM_Centro_lv_3.idLevel_3         = pagos_leyes_fiscales.PPM_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  PPM_Centro_lv_4        ON PPM_Centro_lv_4.idLevel_4         = pagos_leyes_fiscales.PPM_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  PPM_Centro_lv_5        ON PPM_Centro_lv_5.idLevel_5         = pagos_leyes_fiscales.PPM_idLevel_5
LEFT JOIN `centrocosto_listado`          RET_Centro             ON RET_Centro.idCentroCosto          = pagos_leyes_fiscales.RET_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  RET_Centro_lv_1        ON RET_Centro_lv_1.idLevel_1         = pagos_leyes_fiscales.RET_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  RET_Centro_lv_2        ON RET_Centro_lv_2.idLevel_2         = pagos_leyes_fiscales.RET_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  RET_Centro_lv_3        ON RET_Centro_lv_3.idLevel_3         = pagos_leyes_fiscales.RET_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  RET_Centro_lv_4        ON RET_Centro_lv_4.idLevel_4         = pagos_leyes_fiscales.RET_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  RET_Centro_lv_5        ON RET_Centro_lv_5.idLevel_5         = pagos_leyes_fiscales.RET_idLevel_5
LEFT JOIN `centrocosto_listado`          IMPRENT_Centro         ON IMPRENT_Centro.idCentroCosto      = pagos_leyes_fiscales.IMPRENT_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  IMPRENT_Centro_lv_1    ON IMPRENT_Centro_lv_1.idLevel_1     = pagos_leyes_fiscales.IMPRENT_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  IMPRENT_Centro_lv_2    ON IMPRENT_Centro_lv_2.idLevel_2     = pagos_leyes_fiscales.IMPRENT_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  IMPRENT_Centro_lv_3    ON IMPRENT_Centro_lv_3.idLevel_3     = pagos_leyes_fiscales.IMPRENT_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  IMPRENT_Centro_lv_4    ON IMPRENT_Centro_lv_4.idLevel_4     = pagos_leyes_fiscales.IMPRENT_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  IMPRENT_Centro_lv_5    ON IMPRENT_Centro_lv_5.idLevel_5     = pagos_leyes_fiscales.IMPRENT_idLevel_5';
$SIS_where = 'pagos_leyes_fiscales.idFactFiscal ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'pagos_leyes_fiscales', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

$rowArriendo      = db_select_data (false, 'IVA_Compra,IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago,PPM_Diferencia', 'pagos_leyes_fiscales_pagos_arriendos', '', 'idFactFiscal='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowArriendo');
$rowInsumo        = db_select_data (false, 'IVA_Compra,IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago,PPM_Diferencia', 'pagos_leyes_fiscales_pagos_insumos', '', 'idFactFiscal='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowInsumo');
$rowProducto      = db_select_data (false, 'IVA_Compra,IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago,PPM_Diferencia', 'pagos_leyes_fiscales_pagos_productos', '', 'idFactFiscal='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowProducto');
$rowServicio      = db_select_data (false, 'IVA_Compra,IVA_Venta,IVA_TotalSaldo,IVA_MontoPago,IVA_Diferencia,PPM_ValorNeto,PPM_Saldo,PPM_Pago,PPM_Diferencia', 'pagos_leyes_fiscales_pagos_servicios', '', 'idFactFiscal='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowServicio');
$rowRetencion     = db_select_data (false, 'Retencion', 'pagos_leyes_fiscales_pagos_retenciones', '', 'idFactFiscal='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowRetencion');
$rowImpuestoRenta = db_select_data (false, 'ImpuestoRenta', 'pagos_leyes_fiscales_pagos_impuesto_renta', '', 'idFactFiscal='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ImpuestoRenta');
																				
$arrFormaPago = array();
$arrFormaPago = db_select_array (false, 'sistema_documentos_pago.Nombre AS DocPago,pagos_leyes_fiscales_formas_pago.Creacion_fecha,pagos_leyes_fiscales_formas_pago.idTipo,pagos_leyes_fiscales_formas_pago.N_DocPago,pagos_leyes_fiscales_formas_pago.F_Pago,pagos_leyes_fiscales_formas_pago.Monto,usuarios_listado.Nombre AS Usuario','pagos_leyes_fiscales_formas_pago', 'LEFT JOIN `sistema_documentos_pago`     ON sistema_documentos_pago.idDocPago   = pagos_leyes_fiscales_formas_pago.idDocPago LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = pagos_leyes_fiscales_formas_pago.idUsuario', 'pagos_leyes_fiscales_formas_pago.idFactFiscal ='.$X_Puntero, 'pagos_leyes_fiscales_formas_pago.idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFormaPago');

$arrHistorial = array();
$arrHistorial = db_select_array (false, 'pagos_leyes_fiscales_historial.Creacion_fecha, pagos_leyes_fiscales_historial.Observacion,core_historial_tipos.Nombre,core_historial_tipos.FonAwesome,usuarios_listado.Nombre AS Usuario', 'pagos_leyes_fiscales_historial', 'LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = pagos_leyes_fiscales_historial.idTipo LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = pagos_leyes_fiscales_historial.idUsuario', 'pagos_leyes_fiscales_historial.idFactFiscal ='.$X_Puntero, 'pagos_leyes_fiscales_historial.idHistorial ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

$arrArchivo = array();
$arrArchivo = db_select_array (false, 'Nombre', 'pagos_leyes_fiscales_archivos', '', 'idFactFiscal='.$X_Puntero, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

if(isset($rowData['IVA_CC_Nombre'])&&$rowData['IVA_CC_Nombre']!=''){
	$IVA_CC = $rowData['IVA_CC_Nombre'];
	if(isset($rowData['IVA_CC_Level_1'])&&$rowData['IVA_CC_Level_1']!=''){$IVA_CC .= ' - '.$rowData['IVA_CC_Level_1'];}
	if(isset($rowData['IVA_CC_Level_2'])&&$rowData['IVA_CC_Level_2']!=''){$IVA_CC .= ' - '.$rowData['IVA_CC_Level_2'];}
	if(isset($rowData['IVA_CC_Level_3'])&&$rowData['IVA_CC_Level_3']!=''){$IVA_CC .= ' - '.$rowData['IVA_CC_Level_3'];}
	if(isset($rowData['IVA_CC_Level_4'])&&$rowData['IVA_CC_Level_4']!=''){$IVA_CC .= ' - '.$rowData['IVA_CC_Level_4'];}
	if(isset($rowData['IVA_CC_Level_5'])&&$rowData['IVA_CC_Level_5']!=''){$IVA_CC .= ' - '.$rowData['IVA_CC_Level_5'];}
}else{
	$IVA_CC = '';
}
if(isset($rowData['PPM_CC_Nombre'])&&$rowData['PPM_CC_Nombre']!=''){
	$PPM_CC = $rowData['PPM_CC_Nombre'];
	if(isset($rowData['PPM_CC_Level_1'])&&$rowData['PPM_CC_Level_1']!=''){$PPM_CC .= ' - '.$rowData['PPM_CC_Level_1'];}
	if(isset($rowData['PPM_CC_Level_2'])&&$rowData['PPM_CC_Level_2']!=''){$PPM_CC .= ' - '.$rowData['PPM_CC_Level_2'];}
	if(isset($rowData['PPM_CC_Level_3'])&&$rowData['PPM_CC_Level_3']!=''){$PPM_CC .= ' - '.$rowData['PPM_CC_Level_3'];}
	if(isset($rowData['PPM_CC_Level_4'])&&$rowData['PPM_CC_Level_4']!=''){$PPM_CC .= ' - '.$rowData['PPM_CC_Level_4'];}
	if(isset($rowData['PPM_CC_Level_5'])&&$rowData['PPM_CC_Level_5']!=''){$PPM_CC .= ' - '.$rowData['PPM_CC_Level_5'];}
}else{
	$PPM_CC = '';
}
if(isset($rowData['RET_CC_Nombre'])&&$rowData['RET_CC_Nombre']!=''){
	$RET_CC = $rowData['RET_CC_Nombre'];
	if(isset($rowData['RET_CC_Level_1'])&&$rowData['RET_CC_Level_1']!=''){$RET_CC .= ' - '.$rowData['RET_CC_Level_1'];}
	if(isset($rowData['RET_CC_Level_2'])&&$rowData['RET_CC_Level_2']!=''){$RET_CC .= ' - '.$rowData['RET_CC_Level_2'];}
	if(isset($rowData['RET_CC_Level_3'])&&$rowData['RET_CC_Level_3']!=''){$RET_CC .= ' - '.$rowData['RET_CC_Level_3'];}
	if(isset($rowData['RET_CC_Level_4'])&&$rowData['RET_CC_Level_4']!=''){$RET_CC .= ' - '.$rowData['RET_CC_Level_4'];}
	if(isset($rowData['RET_CC_Level_5'])&&$rowData['RET_CC_Level_5']!=''){$RET_CC .= ' - '.$rowData['RET_CC_Level_5'];}
}else{
	$RET_CC = '';
}
if(isset($rowData['IMPRENT_CC_Nombre'])&&$rowData['IMPRENT_CC_Nombre']!=''){
	$IMPRENT_CC = $rowData['IMPRENT_CC_Nombre'];
	if(isset($rowData['IMPRENT_CC_Level_1'])&&$rowData['IMPRENT_CC_Level_1']!=''){$IMPRENT_CC .= ' - '.$rowData['IMPRENT_CC_Level_1'];}
	if(isset($rowData['IMPRENT_CC_Level_2'])&&$rowData['IMPRENT_CC_Level_2']!=''){$IMPRENT_CC .= ' - '.$rowData['IMPRENT_CC_Level_2'];}
	if(isset($rowData['IMPRENT_CC_Level_3'])&&$rowData['IMPRENT_CC_Level_3']!=''){$IMPRENT_CC .= ' - '.$rowData['IMPRENT_CC_Level_3'];}
	if(isset($rowData['IMPRENT_CC_Level_4'])&&$rowData['IMPRENT_CC_Level_4']!=''){$IMPRENT_CC .= ' - '.$rowData['IMPRENT_CC_Level_4'];}
	if(isset($rowData['IMPRENT_CC_Level_5'])&&$rowData['IMPRENT_CC_Level_5']!=''){$IMPRENT_CC .= ' - '.$rowData['IMPRENT_CC_Level_5'];}
}else{
	$IMPRENT_CC = '';
}

?>

<section class="invoice">


	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Pago Formulario 29.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['fecha_auto']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Datos Básicos
			<address>
				<strong>Usuario: </strong><?php echo $rowData['Usuario']; ?><br/>
				<strong>Periodo: </strong><?php echo numero_a_mes($rowData['Periodo_Mes']).' de '.$rowData['Periodo_Ano']; ?><br/>
				<strong>Fecha Pago: </strong><?php echo Fecha_estandar($rowData['Pago_fecha']); ?><br/>
				<strong>PPM Utilizado: </strong><?php echo cantidades($rowData['Porcentaje_PPM'],1).' %'; ?><br/>
				<strong>Estado de Pago: </strong><?php echo $rowData['EstadoPago']; ?><br/>
				<strong>Centro de Costo IVA: </strong><?php echo $IVA_CC; ?><br/>
				<strong>Centro de Costo PPM: </strong><?php echo $PPM_CC; ?><br/>
				<strong>Centro de Costo Retenciones: </strong><?php echo $RET_CC; ?><br/>
				<strong>Centro de Costo Impuesto Renta: </strong><?php echo $IMPRENT_CC; ?><br/>

			</address>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Empresa Relacionada
			<address>
				<strong>Nombre: </strong><?php echo $rowData['SistemaOrigen']; ?><br/>
				<strong>Ubicación: </strong><?php echo $rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna']; ?><br/>
				<strong>Dirección: </strong><?php echo $rowData['SistemaOrigenDireccion']; ?><br/>
				<strong>Fono: </strong><?php echo formatPhone($rowData['SistemaOrigenFono']); ?><br/>
				<strong>Rut: </strong><?php echo $rowData['SistemaOrigenRut']; ?><br/>
				<strong>Email: </strong><?php echo $rowData['SistemaOrigenEmail']; ?><br/>
			</address>
		</div>
	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="6">IVA</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td>Item</td>
						<td width="120">Compra</td>
						<td width="120">Venta</td>
						<td width="120">Saldo</td>
						<td width="120">Monto Pago</td>
						<td width="120">Diferencia</td>
					</tr>
					<tr>
						<td>Saldo IVA Mes Anterior</td>
						<td align="right"><?php if($rowData['Saldos_IVA_Anterior']<=0){echo Valores($rowData['Saldos_IVA_Anterior'], 0);}else{echo Valores(0, 0);} ?></td>
						<td align="right"><?php if($rowData['Saldos_IVA_Anterior']>0){echo Valores($rowData['Saldos_IVA_Anterior'], 0);}else{echo Valores(0, 0);} ?></td>
						<td align="right" class="<?php if($rowData['Saldos_IVA_Anterior']>0){echo 'color-red';}else{echo 'color-blue';} ?>"><?php echo Valores($rowData['Saldos_IVA_Anterior'], 0) ?></td>
						<td align="right"><?php echo Valores(0, 0); ?></td>
						<td align="right"><?php echo Valores($rowData['Saldos_IVA_Anterior'], 0) ?></td>
					</tr>
					<tr>
						<td>Arriendos</td>
						<td align="right"><?php echo Valores($rowArriendo['IVA_Compra'], 0); ?></td>
						<td align="right"><?php echo Valores($rowArriendo['IVA_Venta'], 0); ?></td>
						<td align="right" class="<?php if($rowArriendo['IVA_TotalSaldo']>0){echo 'color-red';}else{echo 'color-blue';} ?>"><?php echo Valores($rowArriendo['IVA_TotalSaldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowArriendo['IVA_MontoPago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowArriendo['IVA_Diferencia'], 0); ?></td>
					</tr>
					<tr>
						<td>Insumos</td>
						<td align="right"><?php echo Valores($rowInsumo['IVA_Compra'], 0); ?></td>
						<td align="right"><?php echo Valores($rowInsumo['IVA_Venta'], 0); ?></td>
						<td align="right" class="<?php if($rowInsumo['IVA_TotalSaldo']>0){echo 'color-red';}else{echo 'color-blue';} ?>"><?php echo Valores($rowInsumo['IVA_TotalSaldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowInsumo['IVA_MontoPago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowInsumo['IVA_Diferencia'], 0); ?></td>
					</tr>
					<tr>
						<td>Productos</td>
						<td align="right"><?php echo Valores($rowProducto['IVA_Compra'], 0); ?></td>
						<td align="right"><?php echo Valores($rowProducto['IVA_Venta'], 0); ?></td>
						<td align="right" class="<?php if($rowProducto['IVA_TotalSaldo']>0){echo 'color-red';}else{echo 'color-blue';} ?>"><?php echo Valores($rowProducto['IVA_TotalSaldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowProducto['IVA_MontoPago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowProducto['IVA_Diferencia'], 0); ?></td>
					</tr>
					<tr>
						<td>Servicios</td>
						<td align="right"><?php echo Valores($rowServicio['IVA_Compra'], 0); ?></td>
						<td align="right"><?php echo Valores($rowServicio['IVA_Venta'], 0); ?></td>
						<td align="right" class="<?php if($rowServicio['IVA_TotalSaldo']>0){echo 'color-red';}else{echo 'color-blue';} ?>"><?php echo Valores($rowServicio['IVA_TotalSaldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowServicio['IVA_MontoPago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowServicio['IVA_Diferencia'], 0); ?></td>
					</tr>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="3" align="right"> <strong>Total</strong></td>
						<td align="right" class="<?php if($rowData['IVA_TotalSaldo']>0){echo 'color-red';}else{echo 'color-blue';} ?>"><?php echo Valores($rowData['IVA_TotalSaldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowData['IVA_MontoPago'], 0); ?></td>
						<td align="right" class="<?php if($rowData['IVA_Diferencia']>0){echo 'color-red';}else{echo 'color-blue';} ?>"><?php echo Valores($rowData['IVA_Diferencia'], 0); ?></td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div style="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-top:15px;padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="6">PPM</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td>Item</td>
						<td width="120">Venta Neta</td>
						<td width="120">PPM <?php echo cantidades($rowData['Porcentaje_PPM'],1).' %'; ?></td>
						<td width="120">Monto Pago</td>
						<td width="120">Diferencia</td>
					</tr>
					<tr>
						<td>Arriendos</td>
						<td align="right"><?php echo Valores($rowArriendo['PPM_ValorNeto'], 0); ?></td>
						<td align="right"><?php echo Valores($rowArriendo['PPM_Saldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowArriendo['PPM_Pago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowArriendo['PPM_Diferencia'], 0); ?></td>
					</tr>
					<tr>
						<td>Insumos</td>
						<td align="right"><?php echo Valores($rowInsumo['PPM_ValorNeto'], 0); ?></td>
						<td align="right"><?php echo Valores($rowInsumo['PPM_Saldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowInsumo['PPM_Pago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowInsumo['PPM_Diferencia'], 0); ?></td>
					</tr>
					<tr>
						<td>Productos</td>
						<td align="right"><?php echo Valores($rowProducto['PPM_ValorNeto'], 0); ?></td>
						<td align="right"><?php echo Valores($rowProducto['PPM_Saldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowProducto['PPM_Pago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowProducto['PPM_Diferencia'], 0); ?></td>
					</tr>
					<tr>
						<td>Servicios</td>
						<td align="right"><?php echo Valores($rowServicio['PPM_ValorNeto'], 0); ?></td>
						<td align="right"><?php echo Valores($rowServicio['PPM_Saldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowServicio['PPM_Pago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowServicio['PPM_Diferencia'], 0); ?></td>
					</tr>
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="2" align="right"> <strong>Total</strong></td>
						<td align="right"><?php echo Valores($rowData['PPM_Saldo'], 0); ?></td>
						<td align="right"><?php echo Valores($rowData['PPM_Pago'], 0); ?></td>
						<td align="right"><?php echo Valores($rowData['PPM_Diferencia'], 0); ?></td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div style="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-top:15px;padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="6">Retenciones</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td>Item</td>
						<td width="120">Valor</td>
					</tr>
					<tr>
						<td>Retenciones</td>
						<td align="right"><?php echo Valores($rowRetencion['Retencion'], 0); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div style="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-top:15px;padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="6">Impuesto a la renta</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td>Item</td>
						<td width="120">Valor</td>
					</tr>
					<tr>
						<td>Impuesto</td>
						<td align="right"><?php echo Valores($rowImpuestoRenta['ImpuestoRenta'], 0); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div style="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-top:15px;padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="8">Resumen</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td></td>
						<td><strong>IVA Credito</strong></td>
						<td><strong>Total a Pagar</strong></td>
						<td><strong>Forma de Pago</strong></td>
						<td><strong>Fecha ingreso</strong></td>
						<td><strong>Fecha de Vencimiento</strong></td>
						<td><strong>Usuario</strong></td>
						<td><strong>Monto Pagado</strong></td>
					</tr>
					<tr>
						<td class="meta-head">IVA a Pagar</td>
						<td align="right"></td>
						<td align="right"><?php echo valores($rowData['IVA_MontoPago'], 0); ?></td>
						<td align="left">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==1){
										echo $pago['DocPago'];
										if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
										echo '<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==1){
										echo fecha_estandar($pago['Creacion_fecha']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==1){
										echo fecha_estandar($pago['F_Pago']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==1){
										echo $pago['Usuario'].'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==1){
										echo valores($pago['Monto'], 0).'<br/>';
									}
								}
							} ?>
						</td>
					</tr>
					<tr>
						<td class="meta-head">Saldo IVA Mes siguiente</td>
						<td align="right"><?php echo valores($rowData['IVA_Diferencia'], 0); ?></td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
					</tr>
					<tr>
						<td class="meta-head">PPM a Pagar</td>
						<td align="right"></td>
						<td align="right"><?php echo valores($rowData['PPM_Pago'], 0); ?></td>
						<td align="left">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==2){
										echo $pago['DocPago'];
										if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
										echo '<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==2){
										echo fecha_estandar($pago['Creacion_fecha']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==2){
										echo fecha_estandar($pago['F_Pago']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==2){
										echo $pago['Usuario'].'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==2){
										echo valores($pago['Monto'], 0).'<br/>';
									}
								}
							} ?>
						</td>
					</tr>
					<tr>
						<td class="meta-head">Retencion a Pagar</td>
						<td align="right"></td>
						<td align="right"><?php echo valores($rowData['Retencion'], 0); ?></td>
						<td align="left">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==3){
										echo $pago['DocPago'];
										if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
										echo '<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==3){
										echo fecha_estandar($pago['Creacion_fecha']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==3){
										echo fecha_estandar($pago['F_Pago']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==3){
										echo $pago['Usuario'].'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==3){
										echo valores($pago['Monto'], 0).'<br/>';
									}
								}
							} ?>
						</td>
					</tr>
					<tr>
						<td class="meta-head">Impuesto a la renta a Pagar</td>
						<td align="right"></td>
						<td align="right"><?php echo valores($rowData['ImpuestoRenta'], 0); ?></td>
						<td align="left">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==4){
										echo $pago['DocPago'];
										if(isset($pago['N_DocPago'])&&$pago['N_DocPago']!=''){echo ' N°'.$pago['N_DocPago'];}
										echo '<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==4){
										echo fecha_estandar($pago['Creacion_fecha']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==4){
										echo fecha_estandar($pago['F_Pago']).'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==4){
										echo $pago['Usuario'].'<br/>';
									}
								}
							} ?>
						</td>
						<td align="right">
							<?php if($arrFormaPago!=false && !empty($arrFormaPago) && $arrFormaPago!=''){
								foreach ($arrFormaPago as $pago) {
									if(isset($pago['idTipo'])&&$pago['idTipo']==4){
										echo valores($pago['Monto'], 0).'<br/>';
									}
								}
							} ?>
						</td>
					</tr>
					<tr>
						<td class="meta-head"><strong>Totales</strong></td>
						<td align="right"><strong><?php echo valores($rowData['Saldos_IVA_Actual'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['TotalGeneral'], 0); ?></strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align="right"><strong><?php echo valores($rowData['TotalPagoGeneral'], 0); ?></strong></td>
					</tr>
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
