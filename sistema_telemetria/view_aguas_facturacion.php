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
//Obtengo los datos principales
$SIS_query = '
ClienteNombre,ClienteDireccion,ClienteIdentificador,ClienteNombreComuna,ClienteFechaVencimiento,ClienteEstado,
							
DetalleCargoFijoValor,
DetalleConsumoCantidad,DetalleConsumoValor,
DetalleRecoleccionCantidad,DetalleRecoleccionValor,
DetalleVisitaCorte,
DetalleCorte1Fecha,DetalleCorte1Valor,
DetalleCorte2Fecha,DetalleCorte2Valor,
DetalleReposicion1Fecha,DetalleReposicion1Valor,
DetalleReposicion2Fecha,DetalleReposicion2Valor,
DetalleSubtotalServicio,
DetalleInteresDeuda,
DetalleSaldoFavor,
DetalleTotalVenta,
DetalleSaldoAnterior,
							
DetalleOtrosCargos1Texto,
DetalleOtrosCargos2Texto,
DetalleOtrosCargos3Texto,
DetalleOtrosCargos4Texto,
DetalleOtrosCargos5Texto,
DetalleOtrosCargos1Valor,
DetalleOtrosCargos2Valor,
DetalleOtrosCargos3Valor,
DetalleOtrosCargos4Valor,
DetalleOtrosCargos5Valor,
DetalleOtrosCargos1Fecha,
DetalleOtrosCargos2Fecha,
DetalleOtrosCargos3Fecha,
DetalleOtrosCargos4Fecha,
DetalleOtrosCargos5Fecha,
							
DetalleTotalAPagar,
							
GraficoMes1Valor,GraficoMes2Valor,GraficoMes3Valor,GraficoMes4Valor,GraficoMes5Valor,
GraficoMes6Valor,GraficoMes7Valor,GraficoMes8Valor,GraficoMes9Valor,GraficoMes10Valor,
GraficoMes11Valor,GraficoMes12Valor,
GraficoMes1Fecha,GraficoMes2Fecha,GraficoMes3Fecha,GraficoMes4Fecha,GraficoMes5Fecha,
GraficoMes6Fecha,GraficoMes7Fecha,GraficoMes8Fecha,GraficoMes9Fecha,GraficoMes10Fecha,
GraficoMes11Fecha,GraficoMes12Fecha,
							
DetConsMesAnteriorCantidad,DetConsMesAnteriorFecha,
DetConsMesActualCantidad,DetConsMesActualFecha,
DetConsMesDiferencia,
DetConsProrateo,
DetConsProrateoSigno,
DetConsMesTotalCantidad,
DetConsFechaProxLectura,
DetConsModalidad,
DetConsFonoEmergencias,
DetConsFonoConsultas,
							
AguasInfCargoFijo,
AguasInfMetroAgua,
AguasInfMetroRecolecion,
AguasInfVisitaCorte,
AguasInfCorte1,
AguasInfCorte2,
AguasInfReposicion1,
AguasInfReposicion2,
							
AguasInfFactorCobro,
AguasInfDifMedGeneral,
AguasInfProcProrrateo,
AguasInfTipoMedicion,
AguasInfPuntoDiametro,
AguasInfClaveFacturacion,
AguasInfClaveLectura,
AguasInfNumeroMedidor,
AguasInfFechaEmision,
AguasInfUltimoPagoFecha,AguasInfUltimoPagoMonto,
AguasInfMovimientosHasta,

core_sistemas.Nombre AS SistemaNombre,
core_sistemas.Rubro AS SistemaRubro,
core_sistemas.Rut AS SistemaRut,
core_sistemas.Direccion AS SistemaDireccion,
sis_or_ciudad.Nombre AS SistemaComuna,
sis_or_comuna.Nombre AS SistemaCiudad,
core_sistemas.Contacto_Fono1 AS SistemaFono,
aguas_datos_valores.NdiasPago,

SII_idFacturable,
NombreArchivo,
aguas_clientes_facturable.Nombre AS DocFacturable,
SII_NDoc,
core_sistemas.Rubro AS Rubro,
aguas_clientes_listado.Rut AS ClienteRut,
aguas_clientes_listado.Giro AS ClienteGiro,
aguas_clientes_listado.Fono1 AS ClienteFono1,
aguas_clientes_listado.Fono2 AS ClienteFono2,
core_ubicacion_comunas.Nombre AS ClienteComunaFact,
aguas_clientes_listado.DireccionFact AS ClienteDireccionFact,
aguas_clientes_listado.UnidadHabitacional AS ClienteUH,
aguas_clientes_listado.idRemarcadores AS ClienteRemarcador,

usuarios_listado.Nombre AS PagoUsuario,
idTipoPago,nDocPago,fechaPago,montoPago,idPago,
aguas_facturacion_listado_detalle.idEstado';
$SIS_join  = '
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                   = aguas_facturacion_listado_detalle.idSistema
LEFT JOIN `aguas_clientes_facturable`               ON aguas_clientes_facturable.idFacturable    = aguas_facturacion_listado_detalle.SII_idFacturable
LEFT JOIN `aguas_clientes_listado`                  ON aguas_clientes_listado.idCliente          = aguas_facturacion_listado_detalle.idCliente
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                = aguas_facturacion_listado_detalle.idUsuarioPago
LEFT JOIN `core_ubicacion_comunas`                  ON core_ubicacion_comunas.idComuna           = aguas_clientes_listado.idComunaFact
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                    = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                    = core_sistemas.idComuna
LEFT JOIN `aguas_datos_valores`                     ON aguas_datos_valores.idSistema             = aguas_facturacion_listado_detalle.idSistema';
$SIS_where = 'aguas_facturacion_listado_detalle.idFacturacionDetalle ='.$X_Puntero;
$rowDatos = db_select_data (false, $SIS_query, 'aguas_facturacion_listado_detalle', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowDatos');

/**********************************************************/
// consulto los datos
$SIS_query = 'idTipoPago, Nombre';
$SIS_join  = '';
$SIS_where = 'idTipoPago!=0';
$SIS_order = 'Nombre ASC';
$arrTipoPagos = array();
$arrTipoPagos = db_select_array (false, $SIS_query, 'aguas_facturacion_listado_detalle_tipo_pago', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTipoPagos');

/**********************************************************/
// consulto los datos
$SIS_query = '
aguas_facturacion_listado_detalle_tipo_pago.Nombre,
aguas_clientes_pagos_relacionados.nDocPago,
aguas_clientes_pagos_relacionados.fechaPago,
aguas_clientes_pagos_relacionados.montoPago';
$SIS_join  = 'LEFT JOIN `aguas_facturacion_listado_detalle_tipo_pago` ON aguas_facturacion_listado_detalle_tipo_pago.idTipoPago = aguas_clientes_pagos_relacionados.idTipoPago';
$SIS_where = 'aguas_clientes_pagos_relacionados.idFacturacionDetalle ='.$X_Puntero;
$SIS_order = 'aguas_facturacion_listado_detalle_tipo_pago.Nombre ASC';
$arrPagosRel = array();
$arrPagosRel = db_select_array (false, $SIS_query, 'aguas_clientes_pagos_relacionados', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagosRel');


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix" style="margin-bottom:5px;">
	<a target="new" href="<?php echo 'view_aguas_facturacion_to_pdf.php?view='.$_GET['view']; ?>"   class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
	<a target="new" href="<?php echo 'view_aguas_facturacion_to_print.php?view='.$_GET['view']; ?>" class="btn btn-sm btn-metis-5 pull-right margin_width"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
</div>
<div class="clearfix"></div>

<?php
//Si el documento esta pagado se muestran los datos relacionados al pago
if($rowDatos['idEstado']==2){ ?>
	<style>
	.radio input[type="radio"] {
		opacity: 1!important;
	}
	</style>
	<div style="margin-top:10px;">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h6 class="panel-title"><i class="fa fa-check" aria-hidden="true"></i> Pago Confirmado</h6>
				</div>
				<div class="panel-body">
					<div class="row invoice-payment">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h6 class="text-success"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo 'Pagado el '.Fecha_estandar($rowDatos['fechaPago']) ?></h6>
							<?php foreach ($arrTipoPagos as $pago) { ?>
								<label class="radio <?php if($pago['idTipoPago']==$rowDatos['idTipoPago']){echo 'disabled';} ?>">
									<div class="choice"><span><input <?php if($pago['idTipoPago']==$rowDatos['idTipoPago']){echo 'checked="checked"';}else{echo 'disabled="disabled"';} ?> name="payment-paid" class="styled" type="radio"></span></div>
									<?php 
									echo $pago['Nombre'];
									if($pago['idTipoPago']==$rowDatos['idTipoPago']&&$rowDatos['nDocPago']!=''){
										echo 'Doc N° '.$rowDatos['nDocPago'];
									}
									?>
								</label>
							<?php } ?>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<h6><?php echo 'Usuario encargado '.$rowDatos['PagoUsuario']?></h6>
							<table class="table">
								<tbody>
									<tr>
										<th>Monto Pagado:</th>
										<td align="right"><?php echo Valores($rowDatos['montoPago'], 0) ?></td>
									</tr>
									<tr>
										<th>Monto Facturado:</th>
										<td align="right"><?php echo Valores($rowDatos['DetalleTotalAPagar'], 0) ?></td>
									</tr>
									<tr>
										<th>Diferencia:</th>
										<?php
										$diferencia = $rowDatos['montoPago'] - $rowDatos['DetalleTotalAPagar'];
										if($diferencia<0){
											echo '<td align="right" class="text-danger"><h6><i class="fa fa-arrow-down" aria-hidden="true"></i> '.Valores($diferencia, 0).'</h6></td>';
										}elseif($diferencia>0){
											echo '<td align="right" class="text-info"><h6><i class="fa fa-arrow-up" aria-hidden="true"></i> '.Valores($diferencia, 0).'</h6></td>';
										}else{
											echo '<td align="right"><h6>Pago OK</h6></td>';
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

	<?php
	//cuento la cantidad de pagos relacionados
	$nn = 0;
	foreach ($arrPagosRel as $pagos) {
		$nn++;
	}
	//si tiene mas de un pago relacionado se muestran los pagos relacionados
	if($nn>1){ ?>
		<div class="row" style="margin-top:10px;">
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
										<th>Documento</th>
										<th>Fecha</th>
										<th>Monto</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrPagosRel as $pagos) { ?>
										<tr class="odd">
											<td><?php echo $pagos['Nombre'].' Doc N° '.$pagos['nDocPago']; ?></td>
											<td><?php echo $pagos['fechaPago']; ?></td>
											<td><?php echo $pagos['montoPago']; ?></td>
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
<?php	
}

//se verifica si existe
if(isset($rowDatos['SII_idFacturable'])&&$rowDatos['SII_idFacturable']!=''){
	switch ($rowDatos['SII_idFacturable']) {
		//Boleta Electronica
		case 1:
			include 'view_aguas_facturacion_1.php';
		break;
		//Factura Electronica
		case 2:
			include 'view_aguas_facturacion_2.php';
		break;
		//No Facturable
		case 3:
			//include 'view_aguas_facturacion_3.php';
		break;
		//Boleta Manual
		case 4:
			include 'view_aguas_facturacion_4.php';
		break;
		//Factura Manual
		case 5:
			include 'view_aguas_facturacion_5.php';
		break;
	}
}

?>

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
