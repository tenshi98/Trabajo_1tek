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
//Información basica
$SIS_query = 'fecha_auto, Creacion_fecha, Fecha_desde, Fecha_hasta, Observaciones,UF, UTM, IMM, 
TopeImpAFP, TopeImpIPS, TopeSegCesantia, TopeAPVMensual, TopeDepConv,idTrabajador,idTipoContratoTrab,
TipoContratoTrab,horas_pactadas,Gratificacion,TrabajadorNombre,TrabajadorRut,TrabajadorEmail,
TrabajadorContrato,TrabajadorCargo,SistemaNombre,SistemaRut,SueldoPactado,DiasPactados,DiasTrabajados,
diasInasistencia,diasLicencias,SueldoPagado,TotalBonoFijoAfecto,TotalBonoFijoNoAfecto,TotalBonoTurno,
TotalBonoTemporalAfecto,TotalBonoTemporalNoAfecto,TotalHorasExtras,Cargas_n,Cargas_valor,Cargas_idTramo,
Cargas_tramo,TotalCargasFamiliares,SueldoImponible,SueldoNoImponible,TotalHaberes,AFP_idAFP,AFP_Nombre,
AFP_Porcentaje,AFP_Total,AFP_SIS,Salud_idAFP,Salud_Nombre,Salud_Porcentaje,Salud_Total ,TotalDescuentos,
SegCesantia_Empleador,SegCesantia_Trabajador,ImpuestoRenta,RentaAfecta,TotalAPagar,MontoPagado,CentroCosto,
MutualNombre,MutualPorcentaje,MutualValor,Salud_idCotizacion,Salud_CotizacionPorcentaje,Salud_CotizacionValor';
$rowData = db_select_data (false, $SIS_query, 'rrhh_sueldos_facturacion_trabajadores', '', 'idFactTrab ='.$X_Puntero, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**************************************************************/
//Anticipos
$arrAnticipos = array();
$arrAnticipos = db_select_array (false, 'Creacion_fecha, Monto', 'rrhh_sueldos_facturacion_trabajadores_anticipos', '', 'idFactTrab ='.$X_Puntero, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAnticipos');
											
/**************************************************************/
//Bonos Fijos
$arrBonoFijo = array();
$arrBonoFijo = db_select_array (false, 'BonoNombre,BonoMonto, BonoTipo', 'rrhh_sueldos_facturacion_trabajadores_bonofijo', '', 'idFactTrab ='.$X_Puntero, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBonoFijo');

/**************************************************************/
//Bonos Temporales
$arrBonoTemporal = array();
$arrBonoTemporal = db_select_array (false, 'BonoNombre,BonoMonto, BonoTipo','rrhh_sueldos_facturacion_trabajadores_bonotemporal', '', 'idFactTrab ='.$X_Puntero, 0,$dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBonoTemporal');

/**************************************************************/
//Bonos Turnos
$arrBonoTurno = array();
$arrBonoTurno = db_select_array (false, 'BonoNombre,BonoMonto', 'rrhh_sueldos_facturacion_trabajadores_bonoturno', '', 'idFactTrab ='.$X_Puntero, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrBonoTurno');

/**************************************************************/
//Descuentos Fijos
$arrDescuentoFijo = array();
$arrDescuentoFijo = db_select_array (false, 'idDescuentoFijo , DescuentoNombre,DescuentoMonto', 'rrhh_sueldos_facturacion_trabajadores_descuentofijo', '', 'idFactTrab ='.$X_Puntero, 0,  $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDescuentoFijo');

/**************************************************************/
//Descuentos 
$arrDescuento = array();
$arrDescuento = db_select_array (false, 'Fecha, nCuota, TotalCuotas, monto_cuotas, Tipo', 'rrhh_sueldos_facturacion_trabajadores_descuentos', '', 'idFactTrab ='.$X_Puntero,0,  $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDescuento');

/**************************************************************/
//Horas Extras 
$arrHoraExtra = array();
$arrHoraExtra = db_select_array (false, 'Porcentaje, N_Horas, ValorHora, TotalHora', 'rrhh_sueldos_facturacion_trabajadores_horasextras', '', 'idFactTrab ='.$X_Puntero, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHoraExtra');

/**************************************************************/
//Horas Extras 
$arrPagos = array();
$arrPagos = db_select_array (false, 'sistema_documentos_pago.Nombre AS DocPago,pagos_rrhh_liquidaciones.N_DocPago,pagos_rrhh_liquidaciones.F_Pago,pagos_rrhh_liquidaciones.MontoPagado,usuarios_listado.Nombre AS UsuarioPago', 'pagos_rrhh_liquidaciones', 'LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago = pagos_rrhh_liquidaciones.idDocPago LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = pagos_rrhh_liquidaciones.idUsuario', 'pagos_rrhh_liquidaciones.idFactTrab ='.$X_Puntero, 'F_Pago ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagos');


?>
<style>
	hr {margin-bottom: 5px !important;margin-top: 5px !important;}
	address {margin-bottom: 5px !important;}
	.panel-body {padding: 0px !important;}
</style>

<div class="" style="margin-top:10px;">
	<div class="col-xs-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h6 class="panel-title"><i class="fa fa-usd" aria-hidden="true"></i> Indicadores</h6>
			</div>
			<div class="panel-body">
				<div class="invoice-payment">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<p>
							<strong>Economicos de la facturacion</strong><br/>
							<strong>UF</strong>: <span class="pull-right"><?php echo valores($rowData['UF'], 0); ?></span><br/>
							<strong>UTM</strong>: <span class="pull-right"><?php echo valores($rowData['UTM'], 0); ?></span><br/>
							<strong>Renta Minima</strong>: <span class="pull-right"><?php echo valores($rowData['IMM'], 0); ?></span><br/>
							<strong>Tope Imponible AFP</strong>: <span class="pull-right"><?php echo valores($rowData['TopeImpAFP'], 0); ?></span><br/>
							<strong>Tope Imponible IPS</strong>: <span class="pull-right"><?php echo valores($rowData['TopeImpIPS'], 0); ?></span><br/>
							<strong>Tope Seguro Cesantia</strong>: <span class="pull-right"><?php echo valores($rowData['TopeSegCesantia'], 0); ?></span><br/>
							<strong>Tope APV Mensual</strong>: <span class="pull-right"><?php echo valores($rowData['TopeAPVMensual'], 0); ?></span><br/>
							<strong>Tope Deposito Convenido</strong>: <span class="pull-right"><?php echo valores($rowData['TopeDepConv'], 0); ?></span><br/>
						</p>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<p>
							<strong>Pago Empresa</strong><br/>
							<?php
							if(isset($rowData['AFP_SIS'])){echo '<strong>AFP Seguro de Invalidez y Sobrevivencia</strong>: <span class="pull-right">'.Valores($rowData['AFP_SIS'], 0).'</span> <br/>';}
							if(isset($rowData['SegCesantia_Empleador'])){echo '<strong>Seg Cesantia Empleador</strong>: <span class="pull-right">'.Valores($rowData['SegCesantia_Empleador'], 0).'</span> <br/>';}
							if(isset($rowData['MutualValor'])&&$rowData['MutualValor']!=''){echo '<strong>'.$rowData['MutualNombre'].' ('.$rowData['MutualPorcentaje'].'%)</strong>: <span class="pull-right">'.valores($rowData['MutualValor'], 0).'</span> <br/>';}
							?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<?php
//Si el documento esta pagado se muestran los datos relacionados al pago
if(isset($rowData['MontoPagado'])&&$rowData['MontoPagado']!=0){ ?>
	<div class="" style="margin-top:10px;">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h6 class="panel-title"><i class="fa fa-usd" aria-hidden="true"></i> Pagos Relacionados</h6>
				</div>
				<div class="panel-body">
					<div class="invoice-payment">
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
								<?php foreach ($arrPagos as $pagos) { ?>
									<tr class="odd">
										<td><?php echo $pagos['UsuarioPago']; ?></td>
										<td><?php echo $pagos['DocPago'];if(isset($pagos['N_DocPago'])&&$pagos['N_DocPago']!=''){echo ' Doc N° '.$pagos['N_DocPago'];} ?></td>
										<td><?php echo fecha_estandar($pagos['F_Pago']); ?></td>
										<td align="right"><?php echo Valores($pagos['MontoPagado'], 0); ?></td>
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
										<td align="right"><?php echo Valores($rowData['TotalAPagar'], 0) ?></td>
									</tr>
									<tr>
										<th>Diferencia:</th>
										<?php
										$diferencia = valores_enteros($rowData['MontoPagado'] - $rowData['TotalAPagar']);
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
	<div class="clearfix"></div>
<?php } ?>

<div class="invoice">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="invoice-title">
    			<h2>
					Liquidacion de Remuneraciones
					<small class="pull-right">Mes <?php echo fecha2NombreMes($rowData['Creacion_fecha']).' de '.fecha2Ano($rowData['Creacion_fecha']); ?></small>
    			</h2>
    			
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    				<address>
						<strong>Empresa:</strong><?php echo $rowData['SistemaNombre']; ?><br/>
						<strong>Rut:</strong><?php echo $rowData['SistemaRut']; ?>
    				</address>
    			</div>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    				<address>
						<strong>Trabajador Sr(a):</strong><?php echo $rowData['TrabajadorNombre']; ?><br/>
						<strong>R.U.T.:</strong><?php echo $rowData['TrabajadorRut']; ?><br/>
    					<strong>Fecha Contrato:</strong><?php echo $rowData['TrabajadorContrato']; ?><br/>
    					<strong>Cargo:</strong><?php echo $rowData['TrabajadorCargo']; ?><br/>
    					<strong>Centro de Costo:</strong><?php echo $rowData['CentroCosto']; ?><br/>
    				</address>
    			</div>
    			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    				<address>
						<?php
							if(isset($rowData['DiasPactados'])){echo '<strong>Dias Pactados</strong>: '.$rowData['DiasPactados'].' Dias<br/>';}
							if(isset($rowData['diasLicencias'])){echo '<strong>Licencias</strong>: '.$rowData['diasLicencias'].' Dias<br/>';}
							if(isset($rowData['diasInasistencia'])){echo '<strong>Dias Inasistencias</strong>: '.$rowData['diasInasistencia'].' Dias<br/>';}
						?>
					</address>
    			</div>
    		</div>

    	</div>
    </div>

    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h4 class="panel-title text-center"><strong>Haberes</strong></h4>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<tbody>
    							<tr>
									<td><?php echo $rowData['TipoContratoTrab'].' '.valores($rowData['SueldoPactado'], 0); ?></td>
    								<td class="text-center" colspan="2"><?php echo $rowData['DiasTrabajados']?> Dias Remunerados</td>
    								<td align="right"><?php echo valores($rowData['SueldoPagado'], 0); ?></td>
    							</tr>
    							
    							<?php if(isset($rowData['Gratificacion'])&&$rowData['Gratificacion']!=''){ ?>
									<tr>
										<td colspan="3">Gratificacion</td>
										<td align="right"><?php echo valores($rowData['Gratificacion'], 0); ?></td>
									</tr>
    							<?php } ?>
    							<?php if(isset($rowData['TotalHorasExtras'])&&$rowData['TotalHorasExtras']!=''){ ?>
									<tr>
										<td colspan="3">Horas Extras</td>
										<td align="right"><?php echo valores($rowData['TotalHorasExtras'], 0); ?></td>
									</tr>
									<?php
									foreach ($arrHoraExtra as $prod) { ?>
										<tr>
											<td></td>
											<td><?php echo $prod['N_Horas'].' HR '.$prod['Porcentaje'].'% ('.valores($prod['ValorHora'], 0).')'; ?></td>
											<td align="right"><?php echo valores($prod['TotalHora'], 0); ?></td>
											<td align="right"></td>
										</tr>
									<?php	
									}
								} ?>
								<?php if(isset($rowData['TotalCargasFamiliares'])&&$rowData['TotalCargasFamiliares']!=''){ ?>
									<tr>
										<td>Asignación Familiar</td>
										<td colspan="2"><?php echo $rowData['Cargas_n'].' Cargas (Tramo '.$rowData['Cargas_tramo'].')'  ?></td>
										<td align="right"><?php echo valores($rowData['Cargas_valor'], 0); ?></td>
									</tr>
    							<?php } ?>
								<?php if(isset($rowData['TotalBonoTurno'])&&$rowData['TotalBonoTurno']!=''){ ?>
									<tr>
										<td colspan="3">Bonos por Turnos Imponibles</td>
										<td align="right"><?php echo valores($rowData['TotalBonoTurno'], 0); ?></td>
									</tr>
									<?php
									foreach ($arrBonoTurno as $prod) { ?>
										<tr>
											<td></td>
											<td><?php echo $prod['BonoNombre']; ?></td>
											<td align="right"><?php echo valores($prod['BonoMonto'], 0); ?></td>
											<td align="right"></td>
										</tr>
									<?php	
									}
								} ?>
								<?php if(isset($rowData['TotalBonoFijoAfecto'])&&$rowData['TotalBonoFijoAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Fijos Imponibles</td>
										<td align="right"><?php echo valores($rowData['TotalBonoFijoAfecto'], 0); ?></td>
									</tr>
									<?php
									foreach ($arrBonoFijo as $prod) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($prod['BonoTipo'])&&$prod['BonoTipo']==1){ ?>
											<tr>
												<td></td>
												<td><?php echo $prod['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($prod['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
								<?php if(isset($rowData['TotalBonoTemporalAfecto'])&&$rowData['TotalBonoTemporalAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Temporales Imponibles</td>
										<td align="right"><?php echo valores($rowData['TotalBonoTemporalAfecto'], 0); ?></td>
									</tr>
									<?php
									foreach ($arrBonoTemporal as $prod) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($prod['BonoTipo'])&&$prod['BonoTipo']==1){ ?>
											<tr>
												<td></td>
												<td><?php echo $prod['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($prod['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>

								<?php if(isset($rowData['TotalBonoFijoNoAfecto'])&&$rowData['TotalBonoFijoNoAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Fijos No Imponibles</td>
										<td align="right"><?php echo valores($rowData['TotalBonoFijoNoAfecto'], 0); ?></td>
									</tr>
									<?php
									foreach ($arrBonoFijo as $prod) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($prod['BonoTipo'])&&$prod['BonoTipo']==2){ ?>
											<tr>
												<td></td>
												<td><?php echo $prod['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($prod['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
								<?php if(isset($rowData['TotalBonoTemporalNoAfecto'])&&$rowData['TotalBonoTemporalNoAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Temporales No Imponibles</td>
										<td align="right"><?php echo valores($rowData['TotalBonoTemporalNoAfecto'], 0); ?></td>
									</tr>
									<?php
									foreach ($arrBonoTemporal as $prod) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($prod['BonoTipo'])&&$prod['BonoTipo']==2){ ?>
											<tr>
												<td></td>
												<td><?php echo $prod['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($prod['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
    							<tr>
									<td align="right" colspan="3"><strong>Total Imponible</strong></td>
									<td align="right"><strong><?php echo valores($rowData['SueldoImponible'], 0); ?></strong></td>
								</tr>
								<tr>
									<td align="right" colspan="3"><strong>Total No Imponible</strong></td>
									<td align="right"><strong><?php echo valores($rowData['SueldoNoImponible'], 0); ?></strong></td>
								</tr>
								<tr>
									<td align="right" colspan="3"><strong>Total Haberes</strong></td>
									<td align="right"><strong><?php echo valores($rowData['TotalHaberes'], 0); ?></strong></td>
								</tr>
    							
    							
    							
								<tr class="active"><td class="text-center" colspan="4"><strong>Deberes</strong></td></tr>
								<?php if(isset($rowData['AFP_Total'])&&$rowData['AFP_Total']!=''){ ?>
									<tr>
										<td colspan="3"><?php echo $rowData['AFP_Nombre'].' ('.$rowData['AFP_Porcentaje'].'%)'; ?></td>
										<td align="right"><?php echo valores($rowData['AFP_Total'], 0); ?></td>
									</tr>
								<?php }
								if(isset($rowData['Salud_Total'])&&$rowData['Salud_Total']!=''){ ?>
									<tr>
										<td colspan="3"><?php echo $rowData['Salud_Nombre'].' ('.$rowData['Salud_Porcentaje'].'%)'; ?></td>
										<td align="right"><?php echo valores($rowData['Salud_Total'], 0); ?></td>
									</tr>
								<?php }
								if(isset($rowData['Salud_idCotizacion'])&&$rowData['Salud_idCotizacion']==1){ ?>
									<tr>
										<td colspan="3"><?php echo 'Cotizacion Adicional Voluntaria  ('.$rowData['Salud_CotizacionPorcentaje'].'%)'; ?></td>
										<td align="right"><?php echo valores($rowData['Salud_CotizacionValor'], 0); ?></td>
									</tr>
								<?php }
								foreach ($arrDescuentoFijo as $prod) {
									//verifico si existe y si esta afecto a descuentos
									if(isset($prod['DescuentoMonto'])){ ?>
										<tr>
											<td colspan="3">
											<?php
											//Verifico si alguno de los descuentos es superior
											//APV
											if($prod['idDescuentoFijo']==1){
												//Si el monto establecido es superior al tope
												if($prod['DescuentoMonto']>$rowData['TopeAPVMensual']){
													echo '<span style="color: #ce4844;">Pasa Tope</span>';
												}
											//Deposito Convenido	
											}elseif($prod['idDescuentoFijo']==2){
												//Si el monto establecido es superior al tope
												if($prod['DescuentoMonto']>$rowData['TopeDepConv']){
													echo '<span style="color: #ce4844;">Pasa Tope</span>';
												}
											}
											echo $prod['DescuentoNombre']; ?>
											</td>
											<td align="right"><?php echo valores($prod['DescuentoMonto'], 0); ?></td>
										</tr>
									<?php }
								}
								if(isset($rowData['SegCesantia_Trabajador'])&&$rowData['SegCesantia_Trabajador']!=''){ ?>
									<tr>
										<td colspan="3">Seguro de Cesantia</td>
										<td align="right"><?php echo valores($rowData['SegCesantia_Trabajador'], 0); ?></td>
									</tr>
								<?php }
								if(isset($rowData['ImpuestoRenta'])&&$rowData['ImpuestoRenta']!=''&&$rowData['ImpuestoRenta']!=0){ ?>
									<tr>
										<td colspan="3">Impuesto a la Renta (<?php echo valores($rowData['RentaAfecta'], 0); ?>)</td>
										<td align="right"><?php echo valores($rowData['ImpuestoRenta'], 0); ?></td>
									</tr>
								<?php }
								foreach ($arrAnticipos as $prod) { ?>
										<tr>
											<td colspan="3">Anticipo Fecha <?php echo fecha_estandar($prod['Creacion_fecha']); ?></td>
											<td align="right"><?php echo valores($prod['Monto'], 0); ?></td>
										</tr>
								<?php }
								foreach ($arrDescuento as $prod) { ?>
										<tr>
											<td colspan="3"><?php echo $prod['Tipo'].' fecha '.fecha_estandar($prod['Fecha']).' ('.$prod['nCuota'].' de '.$prod['TotalCuotas'].')'; ?></td>
											<td align="right"><?php echo valores($prod['monto_cuotas'], 0); ?></td>
										</tr>
								<?php } ?>
								<tr>
									<td align="right" colspan="3"><strong>Total Deberes</strong></td>
									<td align="right"><strong><?php echo valores($rowData['TotalDescuentos'], 0); ?></strong></td>
								</tr>
								
								
								
								
								
								<tr class="active"><td class="text-center" colspan="4"><strong>Alcance Liquido</strong></td></tr>
								<tr>
									<td align="right" colspan="3"><strong>Alcance Liquido</strong></td>
									<td align="right"><strong><?php echo valores($rowData['TotalHaberes'], 0); ?></strong></td>
								</tr>
								<tr>
									<td align="right" colspan="3"><strong>Total Deberes</strong></td>
									<td align="right"><strong><?php echo valores($rowData['TotalDescuentos'], 0); ?></strong></td>
								</tr>
    							<tr>
									<td align="right" colspan="3"><strong>Total a Pagar</strong></td>
									<td align="right"><strong><?php echo valores($rowData['TotalAPagar'], 0); ?></strong></td>
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
