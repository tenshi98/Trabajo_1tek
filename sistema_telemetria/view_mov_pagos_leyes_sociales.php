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
pagos_leyes_sociales.fecha_auto,
pagos_leyes_sociales.Periodo_Ano,
pagos_leyes_sociales.Periodo_Mes,
pagos_leyes_sociales.Pago_fecha,
pagos_leyes_sociales.Observaciones,
pagos_leyes_sociales.idEstadoPago,
pagos_leyes_sociales.AFP_Total_CotizacionOblig,
pagos_leyes_sociales.AFP_Total_SeguroInvalidez,
pagos_leyes_sociales.AFP_Total_APV,
pagos_leyes_sociales.AFP_Total_Cuenta_2,
pagos_leyes_sociales.AFP_Total_CotTrabajoPesado,
pagos_leyes_sociales.AFP_Total_AFCTrabajador,
pagos_leyes_sociales.AFP_Total_AFCEmpleador,
pagos_leyes_sociales.AFP_MontoPago,
pagos_leyes_sociales.SALUD_Total_CotizacionLegal,
pagos_leyes_sociales.SALUD_Total_CotizacionAdicional,
pagos_leyes_sociales.SALUD_MontoPago,
pagos_leyes_sociales.SEGURIDAD_Total_CotizacionLegal,
pagos_leyes_sociales.SEGURIDAD_MontoPago,
pagos_leyes_sociales.TotalGeneral,
pagos_leyes_sociales.TotalPagoGeneral,

core_sistemas.Nombre AS SistemaOrigen,
core_ubicacion_ciudad.Nombre AS SistemaOrigenCiudad,
core_ubicacion_comunas.Nombre AS SistemaOrigenComuna,
core_sistemas.Direccion AS SistemaOrigenDireccion,
core_sistemas.Contacto_Fono1 AS SistemaOrigenFono,
core_sistemas.email_principal AS SistemaOrigenEmail,
core_sistemas.Rut AS SistemaOrigenRut,
usuarios_listado.Nombre AS Usuario,
core_estado_facturacion.Nombre AS EstadoPago,

AFP_Centro.Nombre AS AFP_CC_Nombre,
AFP_Centro_lv_1.Nombre AS AFP_CC_Level_1,
AFP_Centro_lv_2.Nombre AS AFP_CC_Level_2,
AFP_Centro_lv_3.Nombre AS AFP_CC_Level_3,
AFP_Centro_lv_4.Nombre AS AFP_CC_Level_4,
AFP_Centro_lv_5.Nombre AS AFP_CC_Level_5,
SALUD_Centro.Nombre AS SALUD_CC_Nombre,
SALUD_Centro_lv_1.Nombre AS SALUD_CC_Level_1,
SALUD_Centro_lv_2.Nombre AS SALUD_CC_Level_2,
SALUD_Centro_lv_3.Nombre AS SALUD_CC_Level_3,
SALUD_Centro_lv_4.Nombre AS SALUD_CC_Level_4,
SALUD_Centro_lv_5.Nombre AS SALUD_CC_Level_5,
SEGURIDAD_Centro.Nombre AS SEGURIDAD_CC_Nombre,
SEGURIDAD_Centro_lv_1.Nombre AS SEGURIDAD_CC_Level_1,
SEGURIDAD_Centro_lv_2.Nombre AS SEGURIDAD_CC_Level_2,
SEGURIDAD_Centro_lv_3.Nombre AS SEGURIDAD_CC_Level_3,
SEGURIDAD_Centro_lv_4.Nombre AS SEGURIDAD_CC_Level_4,
SEGURIDAD_Centro_lv_5.Nombre AS SEGURIDAD_CC_Level_5';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                                      ON usuarios_listado.idUsuario          = pagos_leyes_sociales.idUsuario
LEFT JOIN `core_sistemas`                                         ON core_sistemas.idSistema             = pagos_leyes_sociales.idSistema
LEFT JOIN `core_ubicacion_ciudad`                                 ON core_ubicacion_ciudad.idCiudad      = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`                                ON core_ubicacion_comunas.idComuna     = core_sistemas.idComuna
LEFT JOIN `core_estado_facturacion`                               ON core_estado_facturacion.idEstado    = pagos_leyes_sociales.idEstadoPago
LEFT JOIN `centrocosto_listado`          AFP_Centro               ON AFP_Centro.idCentroCosto            = pagos_leyes_sociales.AFP_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  AFP_Centro_lv_1          ON AFP_Centro_lv_1.idLevel_1           = pagos_leyes_sociales.AFP_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  AFP_Centro_lv_2          ON AFP_Centro_lv_2.idLevel_2           = pagos_leyes_sociales.AFP_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  AFP_Centro_lv_3          ON AFP_Centro_lv_3.idLevel_3           = pagos_leyes_sociales.AFP_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  AFP_Centro_lv_4          ON AFP_Centro_lv_4.idLevel_4           = pagos_leyes_sociales.AFP_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  AFP_Centro_lv_5          ON AFP_Centro_lv_5.idLevel_5           = pagos_leyes_sociales.AFP_idLevel_5
LEFT JOIN `centrocosto_listado`          SALUD_Centro             ON SALUD_Centro.idCentroCosto          = pagos_leyes_sociales.SALUD_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  SALUD_Centro_lv_1        ON SALUD_Centro_lv_1.idLevel_1         = pagos_leyes_sociales.SALUD_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  SALUD_Centro_lv_2        ON SALUD_Centro_lv_2.idLevel_2         = pagos_leyes_sociales.SALUD_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  SALUD_Centro_lv_3        ON SALUD_Centro_lv_3.idLevel_3         = pagos_leyes_sociales.SALUD_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  SALUD_Centro_lv_4        ON SALUD_Centro_lv_4.idLevel_4         = pagos_leyes_sociales.SALUD_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  SALUD_Centro_lv_5        ON SALUD_Centro_lv_5.idLevel_5         = pagos_leyes_sociales.SALUD_idLevel_5
LEFT JOIN `centrocosto_listado`          SEGURIDAD_Centro         ON SEGURIDAD_Centro.idCentroCosto      = pagos_leyes_sociales.SEGURIDAD_idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`  SEGURIDAD_Centro_lv_1    ON SEGURIDAD_Centro_lv_1.idLevel_1     = pagos_leyes_sociales.SEGURIDAD_idLevel_1
LEFT JOIN `centrocosto_listado_level_2`  SEGURIDAD_Centro_lv_2    ON SEGURIDAD_Centro_lv_2.idLevel_2     = pagos_leyes_sociales.SEGURIDAD_idLevel_2
LEFT JOIN `centrocosto_listado_level_3`  SEGURIDAD_Centro_lv_3    ON SEGURIDAD_Centro_lv_3.idLevel_3     = pagos_leyes_sociales.SEGURIDAD_idLevel_3
LEFT JOIN `centrocosto_listado_level_4`  SEGURIDAD_Centro_lv_4    ON SEGURIDAD_Centro_lv_4.idLevel_4     = pagos_leyes_sociales.SEGURIDAD_idLevel_4
LEFT JOIN `centrocosto_listado_level_5`  SEGURIDAD_Centro_lv_5    ON SEGURIDAD_Centro_lv_5.idLevel_5     = pagos_leyes_sociales.SEGURIDAD_idLevel_5';
$SIS_where = 'pagos_leyes_sociales.idFactSocial ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'pagos_leyes_sociales', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

$arrTrabajo = array();
$arrTrabajo = db_select_array (false, 'idFactTrab,TrabajadorNombre,TrabajadorRut,Sueldo,AFP_Nombre,AFP_Porcentaje,AFP_Cotizacion,AFP_SeguroInvalidez,AFP_APV,AFP_Cuenta2,AFP_TrabajoPesado,AFC_Empleador,AFC_Trabajador,Salud_Nombre,Salud_Porcentaje,Salud_Cotizacion,Salud_Extra_Salud_id,Salud_Extra_Porcentaje,Salud_Extra_Valor,MutualNombre,MutualPorcentaje,MutualValor,Total_AFP,Total_SALUD,Total_SEGURIDAD','pagos_leyes_sociales_trabajadores', '', 'pagos_leyes_sociales_trabajadores.idFactSocial ='.$X_Puntero, 'pagos_leyes_sociales_trabajadores.TrabajadorNombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajo');
																			
$arrFormaPago = array();
$arrFormaPago = db_select_array (false, 'sistema_documentos_pago.Nombre AS DocPago,pagos_leyes_sociales_formas_pago.Creacion_fecha,pagos_leyes_sociales_formas_pago.idTipo,pagos_leyes_sociales_formas_pago.N_DocPago,pagos_leyes_sociales_formas_pago.F_Pago,pagos_leyes_sociales_formas_pago.Monto,usuarios_listado.Nombre AS Usuario','pagos_leyes_sociales_formas_pago', 'LEFT JOIN `sistema_documentos_pago`     ON sistema_documentos_pago.idDocPago   = pagos_leyes_sociales_formas_pago.idDocPago LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = pagos_leyes_sociales_formas_pago.idUsuario', 'pagos_leyes_sociales_formas_pago.idFactSocial ='.$X_Puntero, 'pagos_leyes_sociales_formas_pago.idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFormaPago');

$arrHistorial = array();
$arrHistorial = db_select_array (false, 'pagos_leyes_sociales_historial.Creacion_fecha, pagos_leyes_sociales_historial.Observacion,core_historial_tipos.Nombre,core_historial_tipos.FonAwesome,usuarios_listado.Nombre AS Usuario', 'pagos_leyes_sociales_historial', 'LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = pagos_leyes_sociales_historial.idTipo LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = pagos_leyes_sociales_historial.idUsuario', 'pagos_leyes_sociales_historial.idFactSocial ='.$X_Puntero, 'pagos_leyes_sociales_historial.idHistorial ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

$arrArchivo = array();
$arrArchivo = db_select_array (false, 'Nombre', 'pagos_leyes_sociales_archivos', '', 'idFactSocial='.$X_Puntero, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

if(isset($rowData['AFP_CC_Nombre'])&&$rowData['AFP_CC_Nombre']!=''){
	$AFP_CC = $rowData['AFP_CC_Nombre'];
	if(isset($rowData['AFP_CC_Level_1'])&&$rowData['AFP_CC_Level_1']!=''){$AFP_CC .= ' - '.$rowData['AFP_CC_Level_1'];}
	if(isset($rowData['AFP_CC_Level_2'])&&$rowData['AFP_CC_Level_2']!=''){$AFP_CC .= ' - '.$rowData['AFP_CC_Level_2'];}
	if(isset($rowData['AFP_CC_Level_3'])&&$rowData['AFP_CC_Level_3']!=''){$AFP_CC .= ' - '.$rowData['AFP_CC_Level_3'];}
	if(isset($rowData['AFP_CC_Level_4'])&&$rowData['AFP_CC_Level_4']!=''){$AFP_CC .= ' - '.$rowData['AFP_CC_Level_4'];}
	if(isset($rowData['AFP_CC_Level_5'])&&$rowData['AFP_CC_Level_5']!=''){$AFP_CC .= ' - '.$rowData['AFP_CC_Level_5'];}
}else{
	$AFP_CC = '';
}
if(isset($rowData['SALUD_CC_Nombre'])&&$rowData['SALUD_CC_Nombre']!=''){
	$SALUD_CC = $rowData['SALUD_CC_Nombre'];
	if(isset($rowData['SALUD_CC_Level_1'])&&$rowData['SALUD_CC_Level_1']!=''){$SALUD_CC .= ' - '.$rowData['SALUD_CC_Level_1'];}
	if(isset($rowData['SALUD_CC_Level_2'])&&$rowData['SALUD_CC_Level_2']!=''){$SALUD_CC .= ' - '.$rowData['SALUD_CC_Level_2'];}
	if(isset($rowData['SALUD_CC_Level_3'])&&$rowData['SALUD_CC_Level_3']!=''){$SALUD_CC .= ' - '.$rowData['SALUD_CC_Level_3'];}
	if(isset($rowData['SALUD_CC_Level_4'])&&$rowData['SALUD_CC_Level_4']!=''){$SALUD_CC .= ' - '.$rowData['SALUD_CC_Level_4'];}
	if(isset($rowData['SALUD_CC_Level_5'])&&$rowData['SALUD_CC_Level_5']!=''){$SALUD_CC .= ' - '.$rowData['SALUD_CC_Level_5'];}
}else{
	$SALUD_CC = '';
}
if(isset($rowData['SEGURIDAD_CC_Nombre'])&&$rowData['SEGURIDAD_CC_Nombre']!=''){
	$SEGURIDAD_CC = $rowData['SEGURIDAD_CC_Nombre'];
	if(isset($rowData['SEGURIDAD_CC_Level_1'])&&$rowData['SEGURIDAD_CC_Level_1']!=''){$SEGURIDAD_CC .= ' - '.$rowData['SEGURIDAD_CC_Level_1'];}
	if(isset($rowData['SEGURIDAD_CC_Level_2'])&&$rowData['SEGURIDAD_CC_Level_2']!=''){$SEGURIDAD_CC .= ' - '.$rowData['SEGURIDAD_CC_Level_2'];}
	if(isset($rowData['SEGURIDAD_CC_Level_3'])&&$rowData['SEGURIDAD_CC_Level_3']!=''){$SEGURIDAD_CC .= ' - '.$rowData['SEGURIDAD_CC_Level_3'];}
	if(isset($rowData['SEGURIDAD_CC_Level_4'])&&$rowData['SEGURIDAD_CC_Level_4']!=''){$SEGURIDAD_CC .= ' - '.$rowData['SEGURIDAD_CC_Level_4'];}
	if(isset($rowData['SEGURIDAD_CC_Level_5'])&&$rowData['SEGURIDAD_CC_Level_5']!=''){$SEGURIDAD_CC .= ' - '.$rowData['SEGURIDAD_CC_Level_5'];}
}else{
	$SEGURIDAD_CC = '';
}

?>

<section class="invoice" id="content">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Pago Previred.
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
				<strong>Estado de Pago: </strong><?php echo $rowData['EstadoPago']; ?><br/>
				<strong>Centro de Costo AFP: </strong><?php echo $AFP_CC; ?><br/>
				<strong>Centro de Costo Salud: </strong><?php echo $SALUD_CC; ?><br/>
				<strong>Centro de Costo Seguridad: </strong><?php echo $SEGURIDAD_CC; ?><br/>

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
						<th colspan="12">Administradora Fondos de Pensiones</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td>Trabajador</td>
						<td width="10">RUT</td>
						<td width="10">Ingreso Imponible</td>
						<td width="10">Nombre AFP</td>
						<td width="10">Cotizacion Obligatoria</td>
						<td width="10">Seguro Invalidez</td>
						<td width="10">APV</td>
						<td width="10">Cuenta 2</td>
						<td width="10">Cotizacion Trabajo Pesado</td>
						<td width="10">AFC Trabajador</td>
						<td width="10">AFC Empleador</td>
						<td width="10">Total</td>
					</tr>
					<?php foreach ($arrTrabajo as $trab){  ?>
						<tr>
							<td><?php echo $trab['TrabajadorNombre']; ?></td>
							<td><?php echo $trab['TrabajadorRut']; ?></td>
							<td align="right"><?php echo valores($trab['Sueldo'], 0); ?></td>
							<td><?php echo $trab['AFP_Nombre'].' ('.$trab['AFP_Porcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($trab['AFP_Cotizacion'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_SeguroInvalidez'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_APV'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_Cuenta2'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFP_TrabajoPesado'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFC_Empleador'], 0); ?></td>
							<td align="right"><?php echo valores($trab['AFC_Trabajador'], 0); ?></td>
							<td align="right"><?php echo valores($trab['Total_AFP'], 0); ?></td>
						</tr>
					<?php }  ?>
					 
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="4" align="right"><strong>Total</strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_Total_CotizacionOblig'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_Total_SeguroInvalidez'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_Total_APV'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_Total_Cuenta_2'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_Total_CotTrabajoPesado'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_Total_AFCTrabajador'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_Total_AFCEmpleador'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['AFP_MontoPago'], 0); ?></strong></td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-top:15px;padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="7">Salud</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td>Trabajador</td>
						<td width="10">RUT</td>
						<td width="10">Ingreso Imponible</td>
						<td width="10">Nombre Isapre/Fonasa</td>
						<td width="10">Cotizacion Legal</td>
						<td width="10">Cotizacion Adicional Voluntaria</td>
						<td width="10">Total</td>
					</tr>
					<?php foreach ($arrTrabajo as $trab){  ?>
						<tr>
							<td><?php echo $trab['TrabajadorNombre']; ?></td>
							<td><?php echo $trab['TrabajadorRut']; ?></td>
							<td align="right"><?php echo valores($trab['Sueldo'], 0); ?></td>
							<td><?php echo $trab['Salud_Nombre'].' ('.$trab['Salud_Porcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($trab['Salud_Cotizacion'], 0); ?></td>
							<td align="right"><?php echo valores($trab['Salud_Extra_Valor'], 0).' ('.$trab['Salud_Extra_Porcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($trab['Total_SALUD'], 0); ?></td>
						</tr>
					<?php }  ?>
					 
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="4" align="right"><strong>Total</strong></td>
						<td align="right"><strong><?php echo valores($rowData['SALUD_Total_CotizacionLegal'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['SALUD_Total_CotizacionAdicional'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['SALUD_MontoPago'], 0); ?></strong></td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-top:15px;padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">

			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="6">Mutual Seguridad</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td>Trabajador</td>
						<td width="10">RUT</td>
						<td width="10">Ingreso Imponible</td>
						<td width="10">Nombre Mutual</td>
						<td width="10">Cotizacion Legal</td>
						<td width="10">Total</td>
					</tr>
					<?php foreach ($arrTrabajo as $trab){  ?>
						<tr>
							<td><?php echo $trab['TrabajadorNombre']; ?></td>
							<td><?php echo $trab['TrabajadorRut']; ?></td>
							<td align="right"><?php echo valores($trab['Sueldo'], 0); ?></td>
							<td><?php echo $trab['MutualNombre'].' ('.$trab['MutualPorcentaje'].'%)'; ?></td>
							<td align="right"><?php echo valores($trab['MutualValor'], 0); ?></td>
							<td align="right"><?php echo valores($trab['Total_SEGURIDAD'], 0); ?></td>
						</tr>
					<?php }  ?>
					 
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="4" align="right"><strong>Total</strong></td>
						<td align="right"><strong><?php echo valores($rowData['SEGURIDAD_Total_CotizacionLegal'], 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($rowData['SEGURIDAD_MontoPago'], 0); ?></strong></td>
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
						<th colspan="7">Resumen</th>
					</tr>
				</thead>
				<tbody>
					<tr class="active">
						<td></td>
						<td><strong>Total a Pagar</strong></td>
						<td><strong>Forma de Pago</strong></td>
						<td><strong>Fecha ingreso</strong></td>
						<td><strong>Fecha de Vencimiento</strong></td>
						<td><strong>Usuario</strong></td>
						<td><strong>Monto Pagado</strong></td>
					</tr>
					<tr>
						<td class="meta-head">Administradora Fondos de Pensiones</td>
						<td align="right"><?php echo valores($rowData['AFP_MontoPago'], 0); ?></td>
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
						<td class="meta-head">Salud</td>
						<td align="right"><?php echo valores($rowData['SALUD_MontoPago'], 0); ?></td>
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
						<td class="meta-head">Seguridad</td>
						<td align="right"><?php echo valores($rowData['SEGURIDAD_MontoPago'], 0); ?></td>
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
						<td class="meta-head"><strong>Totales</strong></td>
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
