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
?>
<style>
	hr {margin-bottom: 5px !important;margin-top: 5px !important;}
	address {margin-bottom: 5px !important;}
	.panel-body {padding: 0px !important;}
</style>

<div class="invoice">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Indicadores
			<address>
				<strong>UF</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['UF'], 0); ?></span><br/>
				<strong>UTM</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['UTM'], 0); ?></span><br/>
				<strong>Renta Minima</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['IMM'], 0); ?></span><br/>
				<strong>Tope Imponible AFP</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['TopeImpAFP'], 0); ?></span><br/>
				<strong>Tope Imponible IPS</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['TopeImpIPS'], 0); ?></span><br/>
				<strong>Tope Seguro Cesantia</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['TopeSegCesantia'], 0); ?></span><br/>
				<strong>Tope APV Mensual</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['TopeAPVMensual'], 0); ?></span><br/>
				<strong>Tope Deposito Convenido</strong>: <span class="pull-right"><?php echo valores($_SESSION['fact_sueldos_basicos']['TopeDepConv'], 0); ?></span><br/>
			</address>
		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			Pago Empresa
			<address>
				<?php
				if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['AFP_SIS'])){echo '<strong>AFP Seguro de Invalidez y Sobrevivencia</strong>: <span class="pull-right">'.Valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['AFP_SIS'], 0).'</span> <br/>';}
				if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SegCesantia_Empleador'])){echo '<strong>Seg Cesantia Empleador</strong>: <span class="pull-right">'.Valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SegCesantia_Empleador'], 0).'</span> <br/>';}
				if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Mutual_Valor'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Mutual_Valor']!=''){echo '<strong>'.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Mutual_Nombre'].' ('.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Mutual_Porcentaje'].'%)</strong>: <span class="pull-right">'.valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Mutual_Valor'], 0).'</span> <br/>';}
				?>
			</address>
		</div>
	</div>

	<div class="clearfix"></div>
</div>

<div class="invoice">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="invoice-title">
    			<h2>
					Liquidacion de Remuneraciones
					<small class="pull-right">Mes <?php echo fecha2NombreMes($_SESSION['fact_sueldos_basicos']['Creacion_fecha']).' de '.fecha2Ano($_SESSION['fact_sueldos_basicos']['Creacion_fecha']); ?></small>
    			</h2>
    			
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    				<address>
						<strong>Empresa:</strong><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SistemaNombre']; ?><br/>
						<strong>Rut:</strong><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SistemaRut']; ?>
    				</address>
    			</div>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    				<address>
						<strong>Trabajador Sr(a):</strong><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TrabajadorNombre']; ?><br/>
						<strong>R.U.T.:</strong><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TrabajadorRut']; ?><br/>
    					<strong>Fecha Contrato:</strong><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TrabajadorContrato']; ?><br/>
    					<strong>Cargo:</strong><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TrabajadorCargo']; ?><br/>
    					<strong>Centro de Costo:</strong><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['CentroCosto']; ?><br/>
    				</address>
    			</div>
    			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    				<address>
						<?php
							if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DiasPactados'])){echo '<strong>Dias Pactados</strong>: '.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DiasPactados'].' Dias<br/>';}
							if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['diasLicencias'])){echo '<strong>Licencias</strong>: '.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['diasLicencias'].' Dias<br/>';}
							if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['diasInasistencia'])){echo '<strong>Dias Inasistencias</strong>: '.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['diasInasistencia'].' Dias<br/>';}
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
									<td><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TipoContratoTrab'].' '.valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SueldoPactado'], 0); ?></td>
    								<td class="text-center" colspan="2"><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DiasTrabajados']?> Dias Remunerados</td>
    								<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SueldoPagado'], 0); ?></td>
    							</tr>
    							
    							<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Gratificacion'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Gratificacion']!=''){ ?>
									<tr>
										<td colspan="3">Gratificacion</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Gratificacion'], 0); ?></td>
									</tr>
    							<?php } ?>
    							<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalHorasExtras'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalHorasExtras']!=''){ ?>
									<tr>
										<td colspan="3">Horas Extras</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalHorasExtras'], 0); ?></td>
									</tr>
									<?php
									for ($x = 0; $x <= 31; $x++) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['HorasExtras'][$x]['N_Horas'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['HorasExtras'][$x]['N_Horas']!=0){ ?>
											<tr>
												<td></td>
												<td><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['HorasExtras'][$x]['N_Horas'].' HR '.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['HorasExtras'][$x]['Porcentaje'].'% ('.valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['HorasExtras'][$x]['ValorHora'], 0).')'; ?></td>
												<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['HorasExtras'][$x]['TotalHora'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
								<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalCargasFamiliares'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalCargasFamiliares']!=''){ ?>
									<tr>
										<td>Asignación Familiar</td>
										<td colspan="2"><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Cargas_n'].' Cargas (Tramo '.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Cargas_tramo'].')'  ?></td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Cargas_valor'], 0); ?></td>
									</tr>
    							<?php } ?>
								<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTurno'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTurno']!=''){ ?>
									<tr>
										<td colspan="3">Bonos por Turnos Imponibles</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTurno'], 0); ?></td>
									</tr>
									<?php
									for ($x = 0; $x <= 6; $x++) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTurno'][$x]['BonoMonto'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTurno'][$x]['BonoMonto']!=0){ ?>
											<tr>
												<td></td>
												<td><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTurno'][$x]['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTurno'][$x]['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
								<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoFijoAfecto'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoFijoAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Fijos Imponibles</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoFijoAfecto'], 0); ?></td>
									</tr>
									<?php
									for ($x = 0; $x <= 100; $x++) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoTipo']==1){ ?>
											<tr>
												<td></td>
												<td><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
								<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTemporalAfecto'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTemporalAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Temporales Imponibles</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTemporalAfecto'], 0); ?></td>
									</tr>
									<?php
									for ($x = 0; $x <= 100; $x++) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']==1){ ?>
											<tr>
												<td></td>
												<td><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>

								<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoFijoNoAfecto'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoFijoNoAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Fijos No Imponibles</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoFijoNoAfecto'], 0); ?></td>
									</tr>
									<?php
									for ($x = 0; $x <= 100; $x++) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoTipo']==2){ ?>
											<tr>
												<td></td>
												<td><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoFijo'][$x]['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
								<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTemporalNoAfecto'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTemporalNoAfecto']!=''){ ?>
									<tr>
										<td colspan="3">Bonos Temporales No Imponibles</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalBonoTemporalNoAfecto'], 0); ?></td>
									</tr>
									<?php
									for ($x = 0; $x <= 100; $x++) {
										//verifico si existe y si esta afecto a descuentos
										if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']==2){ ?>
											<tr>
												<td></td>
												<td><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoNombre']; ?></td>
												<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['BonoTemporal'][$x]['BonoMonto'], 0); ?></td>
												<td align="right"></td>
											</tr>
										<?php	
										}
									}
								} ?>
    							<tr>
									<td align="right" colspan="3"><strong>Total Imponible</strong></td>
									<td align="right"><strong><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SueldoImponible'], 0); ?></strong></td>
								</tr>
								<tr>
									<td align="right" colspan="3"><strong>Total No Imponible</strong></td>
									<td align="right"><strong><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SueldoNoImponible'], 0); ?></strong></td>
								</tr>
								<tr>
									<td align="right" colspan="3"><strong>Total Haberes</strong></td>
									<td align="right"><strong><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalHaberes'], 0); ?></strong></td>
								</tr>
    							
    							
    							
								<tr class="active"><td class="text-center" colspan="4"><strong>Deberes</strong></td></tr>
								<?php if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['AFP_Total'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['AFP_Total']!=''){ ?>
									<tr>
										<td colspan="3"><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['AFP_Nombre'].' ('.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['AFP_Porcentaje'].'%)'; ?></td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['AFP_Total'], 0); ?></td>
									</tr>
								<?php }
								if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_Total'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_Total']!=''){ ?>
									<tr>
										<td colspan="3"><?php echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_Nombre'].' ('.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_Porcentaje'].'%)'; ?></td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_Total'], 0); ?></td>
									</tr>
								<?php }
								if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_idCotizacion'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_idCotizacion']==1){ ?>
									<tr>
										<td colspan="3"><?php echo 'Cotizacion Adicional Voluntaria ('.$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_CotizacionPorcentaje'].'%)'; ?></td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Salud_CotizacionValor'], 0); ?></td>
									</tr>
								<?php }
								for ($x = 0; $x <= 100; $x++) {
									//verifico si existe y si esta afecto a descuentos
									if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto'])){ ?>
										<tr>
											<td colspan="3">
											<?php
											//Verifico si alguno de los descuentos es superior
											//APV
											if($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DescuentoFijo'][$x]['idDescuentoFijo']==1){
												//Si el monto establecido es superior al tope
												if($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto']>$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']){
													echo '<span style="color: #ce4844;">Pasa Tope</span>';
												}
											//Deposito Convenido	
											}elseif($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DescuentoFijo'][$x]['idDescuentoFijo']==2){
												//Si el monto establecido es superior al tope
												if($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto']>$_SESSION['fact_sueldos_basicos']['TopeDepConv']){
													echo '<span style="color: #ce4844;">Pasa Tope</span>';
												}
											}
											echo $_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DescuentoFijo'][$x]['DescuentoNombre']; ?>
											</td>
											<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto'], 0); ?></td>
										</tr>
									<?php }
								}
								if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SegCesantia_Trabajador'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SegCesantia_Trabajador']!=''){ ?>
									<tr>
										<td colspan="3">Seguro de Cesantia</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['SegCesantia_Trabajador'], 0); ?></td>
									</tr>
								<?php }
								if(isset($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['ImpuestoRenta'])&&$_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['ImpuestoRenta']!=''){ ?>
									<tr>
										<td colspan="3">Impuesto a la Renta (<?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['RentaAfecta'], 0); ?>)</td>
										<td align="right"><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['ImpuestoRenta'], 0); ?></td>
									</tr>
								<?php }
								if(!empty($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Anticipo'])){
									foreach ($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Anticipo'] as $key => $producto){ ?>
										<tr>
											<td colspan="3">Anticipo Fecha <?php echo fecha_estandar($producto['Creacion_fecha']); ?></td>
											<td align="right"><?php echo valores($producto['Monto'], 0); ?></td>
										</tr>
								<?php }}
								if(!empty($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Cuotas'])){
									foreach ($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['Cuotas'] as $key => $producto){ ?>
										<tr>
											<td colspan="3"><?php echo $producto['Tipo'].' fecha '.fecha_estandar($producto['Fecha']).' ('.$producto['nCuota'].' de '.$producto['TotalCuotas'].')'; ?></td>
											<td align="right"><?php echo valores($producto['monto_cuotas'], 0); ?></td>
										</tr>
								<?php }} ?>
								<tr>
									<td align="right" colspan="3"><strong>Total Deberes</strong></td>
									<td align="right"><strong><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalDescuentos'], 0); ?></strong></td>
								</tr>
								
								
								
								
								
								<tr class="active"><td class="text-center" colspan="4"><strong>Alcance Liquido</strong></td></tr>
								<tr>
									<td align="right" colspan="3"><strong>Alcance Liquido</strong></td>
									<td align="right"><strong><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalHaberes'], 0); ?></strong></td>
								</tr>
								<tr>
									<td align="right" colspan="3"><strong>Total Deberes</strong></td>
									<td align="right"><strong><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalDescuentos'], 0); ?></strong></td>
								</tr>
    							<tr>
									<td align="right" colspan="3"><strong>Total a Pagar</strong></td>
									<td align="right"><strong><?php echo valores($_SESSION['fact_sueldos_sueldos'][$_GET['idTrabajador']]['TotalAPagar'], 0); ?></strong></td>
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
