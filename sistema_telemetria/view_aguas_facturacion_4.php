
	<div class="">
	<section class="invoice">
		<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
			<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowDatos['SistemaNombre']?>
			</h2>
		</div>
		</div>

		<div class="row invoice-info">

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			<address>
			RUT : <?php echo $rowDatos['SistemaRut']?><br>
			<?php echo $rowDatos['Rubro']?><br>
			<?php echo $rowDatos['SistemaDireccion'].' '.$rowDatos['SistemaComuna'].' '.$rowDatos['SistemaCiudad']; ?><br>
			<?php echo formatPhone($rowDatos['SistemaFono']); ?>
			</address>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			<br><br><br>
			<?php echo $rowDatos['DocFacturable'].' '.$rowDatos['SII_NDoc'] ?>
		</div>

		</div>

		<div class="row invoice-info">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			<p class="well well-sm no-shadow" style="background-color: #fff;text-align: center;" >
			<br>
			<?php echo $rowDatos['ClienteNombre']?><br>
			<?php echo $rowDatos['ClienteDireccionFact']?><br>
			<?php echo $rowDatos['ClienteComunaFact']?><br>
			<br>
			</p>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			<p class="well well-sm no-shadow" style="background-color: #fff;text-align: center;" >
			N° Cliente: <?php echo $rowDatos['ClienteIdentificador']?>
			</p>
			<p class="well well-sm no-shadow" style="background-color: #fff;text-align: center;" >
			TOTAL A PAGAR:<?php if($rowDatos['DetalleTotalAPagar']>0){echo Valores($rowDatos['DetalleTotalAPagar'], 0);}else{echo '0';} ?>
			<br>
			<?php
			//Se trae el saldo anterior si es que este existe
			if($rowDatos['ClienteEstado']=='Sin Problemas'){
				echo 'VENCIMIENTO: '.Fecha_estandar($rowDatos['ClienteFechaVencimiento']);
			}else{
				echo $rowDatos['ClienteEstado'];
			}
			?>
			</p>

		</div>

		</div>

		<div class="col-xs-12 well well-sm no-shadow" style="background-color: #fff;">
			<table class="table">
			<thead>
				<tr>
				<th>Detalle Cuenta</th>
				<th width="200px">Metros Cubicos</th>
				<th width="100px" align="right">Valor Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//verificacion de remarcador
				if(isset($rowDatos['ClienteRemarcador'])&&$rowDatos['ClienteRemarcador']!=''&&$rowDatos['ClienteRemarcador']!=0){
					$ndecim = 2;
				}else{
					$ndecim = 0;
				}
				?>
				<tr>
				<td>Cargo Fijo Cliente</td>
				<td></td>
				<td align="right"><?php echo Valores($rowDatos['DetalleCargoFijoValor'], 0); ?></td>
				</tr>
				<tr>
				<td>Consumo Agua Potable</td>
				<td><?php echo Cantidades($rowDatos['DetalleConsumoCantidad'], $ndecim); ?></td>
				<td align="right"><?php echo Valores($rowDatos['DetalleConsumoValor'], 0); ?></td>
				</tr>
				<tr>
				<td>Recoleccion de Aguas Servidas</td>
				<td><?php echo Cantidades($rowDatos['DetalleRecoleccionCantidad'], $ndecim); ?></td>
				<td align="right"><?php echo Valores($rowDatos['DetalleRecoleccionValor'], 0); ?></td>
				</tr>

				<?php if(isset($rowDatos['DetalleVisitaCorte'])&&$rowDatos['DetalleVisitaCorte']!=0){ ?>
				<tr>
					<td colspan="2">Visita Corte</td>
					<td align="right"><?php echo Valores($rowDatos['DetalleVisitaCorte'], 0); ?></td>
				</tr>
				<?php } ?>
				<?php if(isset($rowDatos['DetalleCorte1Valor'])&&$rowDatos['DetalleCorte1Valor']!=0){ ?>
				<tr>
					<td colspan="2">Corte 1° instancia <?php echo ' ('.Fecha_estandar($rowDatos['DetalleCorte1Fecha']).')'?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleCorte1Valor'], 0); ?></td>
				</tr>
				<?php } ?>
				<?php if(isset($rowDatos['DetalleCorte2Valor'])&&$rowDatos['DetalleCorte2Valor']!=0){ ?>
				<tr>
					<td colspan="2">Corte 2° instancia <?php echo ' ('.Fecha_estandar($rowDatos['DetalleCorte2Fecha']).')'?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleCorte2Valor'], 0); ?></td>
				</tr>
				<?php } ?>
				<?php if(isset($rowDatos['DetalleReposicion1Valor'])&&$rowDatos['DetalleReposicion1Valor']!=0){ ?>
				<tr>
					<td colspan="2">Reposicion 1° instancia <?php echo ' ('.Fecha_estandar($rowDatos['DetalleReposicion1Fecha']).')'?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleReposicion1Valor'], 0); ?></td>
				</tr>
				<?php } ?>
				<?php if(isset($rowDatos['DetalleReposicion2Valor'])&&$rowDatos['DetalleReposicion2Valor']!=0){ ?>
				<tr>
					<td colspan="2">Reposicion 2° instancia <?php echo ' ('.Fecha_estandar($rowDatos['DetalleReposicion2Fecha']).')'?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleReposicion2Valor'], 0); ?></td>
				</tr>
				<?php } ?>

				<tr>
				<td colspan="2"><strong>SUBTOTAL SERVICIO</strong></td>
				<td align="right"><strong><?php echo Valores($rowDatos['DetalleSubtotalServicio'], 0); ?></strong></td>
				</tr>

				<?php if(isset($rowDatos['DetalleInteresDeuda'])&&$rowDatos['DetalleInteresDeuda']!=0){ ?>
				<tr>
					<td colspan="2">Interes Deuda</td>
					<td align="right"><?php echo Valores($rowDatos['DetalleInteresDeuda'], 0); ?></td>
				</tr>
				<?php } ?>

				<?php
				//Otros Cargos 1
				if(isset($rowDatos['DetalleOtrosCargos1Valor'])&&$rowDatos['DetalleOtrosCargos1Valor']!=0){ ?>
				<tr>
					<td colspan="2"><?php echo $rowDatos['DetalleOtrosCargos1Texto'].' ('.Fecha_estandar($rowDatos['DetalleOtrosCargos1Fecha']).')'; ?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleOtrosCargos1Valor'], 0); ?></td>
				</tr>
				<?php } 
				//Otros Cargos 2
				if(isset($rowDatos['DetalleOtrosCargos2Valor'])&&$rowDatos['DetalleOtrosCargos2Valor']!=0){ ?>
				<tr>
					<td colspan="2"><?php echo $rowDatos['DetalleOtrosCargos2Texto'].' ('.Fecha_estandar($rowDatos['DetalleOtrosCargos2Fecha']).')'; ?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleOtrosCargos2Valor'], 0); ?></td>
				</tr>
				<?php } 
				//Otros Cargos 3
				if(isset($rowDatos['DetalleOtrosCargos3Valor'])&&$rowDatos['DetalleOtrosCargos3Valor']!=0){ ?>
				<tr>
					<td colspan="2"><?php echo $rowDatos['DetalleOtrosCargos3Texto'].' ('.Fecha_estandar($rowDatos['DetalleOtrosCargos3Fecha']).')'; ?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleOtrosCargos3Valor'], 0); ?></td>
				</tr>
				<?php } 
				//Otros Cargos 4
				if(isset($rowDatos['DetalleOtrosCargos4Valor'])&&$rowDatos['DetalleOtrosCargos4Valor']!=0){ ?>
				<tr>
					<td colspan="2"><?php echo $rowDatos['DetalleOtrosCargos4Texto'].' ('.Fecha_estandar($rowDatos['DetalleOtrosCargos4Fecha']).')'; ?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleOtrosCargos4Valor'], 0); ?></td>
				</tr>
				<?php } 
				//Otros Cargos 5
				if(isset($rowDatos['DetalleOtrosCargos5Valor'])&&$rowDatos['DetalleOtrosCargos5Valor']!=0){ ?>
				<tr>
					<td colspan="2"><?php echo $rowDatos['DetalleOtrosCargos5Texto'].' ('.Fecha_estandar($rowDatos['DetalleOtrosCargos5Fecha']).')'; ?></td>
					<td align="right"><?php echo Valores($rowDatos['DetalleOtrosCargos5Valor'], 0); ?></td>
				</tr>
				<?php } ?>
				<tr>
				<td colspan="2"><strong>TOTAL VENTA</strong></td>
				<td align="right"><strong><?php if($rowDatos['DetalleTotalVenta']>0){echo Valores($rowDatos['DetalleTotalVenta'], 0);}else{echo '0';} ?></strong></td>
				</tr>
				<?php if(isset($rowDatos['DetalleSaldoFavor'])&&$rowDatos['DetalleSaldoFavor']!=0){ ?>
				<tr>
					<td colspan="2">Saldo a Favor</td>
					<td align="right"><?php echo '(-) '.Valores($rowDatos['DetalleSaldoFavor'], 0); ?></td>
				</tr>
				<?php } ?>
				<?php if(isset($rowDatos['DetalleSaldoAnterior'])&&$rowDatos['DetalleSaldoAnterior']!=0){ ?>
				<tr>
					<td colspan="2">Saldo Anterior</td>
					<td align="right"><?php echo Valores($rowDatos['DetalleSaldoAnterior'], 0); ?></td>
				</tr>
				<?php } ?>
				<tr>
				<td colspan="2"><strong>TOTAL A PAGAR</strong></td>
				<td align="right"><strong><?php if($rowDatos['DetalleTotalAPagar']>0){echo Valores($rowDatos['DetalleTotalAPagar'], 0);}else{echo '0';} ?></strong></td>
				</tr>

			</tbody>
			</table>

		</div>

		<div class="row">
		<div class="col-xs-12">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="padding-left: 0px;">
			<div class="well well-sm no-shadow" style="background-color: #fff;">
				<div class="graficos">
				<div>
					<p class="centered">Consumo Ultimos Meses</p>
					<div class="row">
					<div class="col-xs-6">
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes1Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes1Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes2Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes2Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes3Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes3Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes4Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes4Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes5Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes5Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes6Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes6Valor'], 2); ?> m3</small> <br/>
						<div class="clearfix"></div>
					</div>
					<div class="col-xs-6">
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes7Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes7Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes8Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes8Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes9Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes9Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes10Fecha']); ?></div>  <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes10Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes11Fecha']); ?></div>  <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes11Valor'], 2); ?> m3</small> <br/>
						<div class="pull-left"><?php echo Devolver_mes($rowDatos['GraficoMes12Fecha']); ?></div>  <small class="pull-right"><?php echo Cantidades($rowDatos['GraficoMes12Valor'], 2); ?> m3</small>
						<div class="clearfix"></div>
					</div>
					</div>
				</div>
				</div>
			</div>
			<div class="well well-sm no-shadow" style="background-color: #fff;">
				<strong>Detalle de Consumo</strong>
				<p>
				<?php
				if(isset($rowDatos['DetConsMesAnteriorFecha'])&&$rowDatos['DetConsMesAnteriorFecha']!='0000-00-00'&&$rowDatos['DetConsMesAnteriorFecha']!=''){
					$mes_anterior = Fecha_estandar($rowDatos['DetConsMesAnteriorFecha']);
				}else{
					$mes_anterior = 'Sin datos';
				} ?>
				<div class="pull-left">Lectura Mes anterior <?php echo '('.$mes_anterior.')'; ?></div>
				<small class="pull-right"><?php echo valores_truncados($rowDatos['DetConsMesAnteriorCantidad']) ?> m3</small>

				<br/>
				<?php
				if(isset($rowDatos['DetConsMesActualFecha'])&&$rowDatos['DetConsMesActualFecha']!='0000-00-00'&&$rowDatos['DetConsMesActualFecha']!=''){
					$mes_actual = Fecha_estandar($rowDatos['DetConsMesActualFecha']);
				}else{
					$mes_actual = 'Sin datos';
				} ?>
				<div class="pull-left">Lectura Mes actual <?php echo '('.$mes_actual.')'; ?></div>
				<small class="pull-right"><?php echo valores_truncados($rowDatos['DetConsMesActualCantidad']) ?> m3</small>

				<br/>
				<div class="pull-left">Diferencia de lecturas</div>
				<small class="pull-right"><?php echo valores_truncados($rowDatos['DetConsMesDiferencia']) ?> m3</small>

				<?php
				//verificacion de remarcador
				if(isset($rowDatos['ClienteRemarcador'])&&$rowDatos['ClienteRemarcador']!=''&&$rowDatos['ClienteRemarcador']!=0){ ?>
				<br/>
					<div class="pull-left">Adicionales por prorrateo</div>
					<small class="pull-right">
					<?php
					if($rowDatos['DetConsProrateo']>0){
						$bla = $rowDatos['DetConsProrateoSigno'].' '.$rowDatos['DetConsProrateo'];
					}elseif($rowDatos['DetConsProrateo']<0){
						$bla = $rowDatos['DetConsProrateoSigno'].' '.$rowDatos['DetConsProrateo']*-1;
					}else{
						$bla = '(+) 0';
					}
					echo $bla.' m3'; ?>
					</small>
				<?php } ?>

				<br/>
				<div class="pull-left">Consumo Mes Total</div>
				<small class="pull-right"><?php echo Cantidades($rowDatos['DetConsMesTotalCantidad'], $ndecim) ?> m3</small>
				</p>

				<div class="clearfix"></div>

				<p>
				<div class="pull-left">Proxima lectura estimada</div>
				<small class="pull-right"><?php echo Fecha_estandar($rowDatos['DetConsFechaProxLectura']); ?></small>
				<?php
				//verificacion de remarcador
				if(isset($rowDatos['ClienteRemarcador'])&&$rowDatos['ClienteRemarcador']!=''&&$rowDatos['ClienteRemarcador']!=0){ ?>
				<br/>
				<div class="pull-left">Modalidad de prorrateo: <?php echo $rowDatos['DetConsModalidad']; ?></div>
				<?php } ?>
				</p>

				<div class="clearfix"></div>

				<p>
				<div class="pull-left">Emergencias 24 horas </div>
				<small class="pull-right"><?php echo formatPhone($rowDatos['DetConsFonoEmergencias']) ?></small>

				<br/>
				<div class="pull-left">Consultas Lunes a Viernes </div>
				<small class="pull-right"><?php echo formatPhone($rowDatos['DetConsFonoConsultas']) ?></small>
				</p>
			</div>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 well well-sm no-shadow" style="background-color: #fff;">
			<strong>Aguas Informa</strong>
				<p>
				Los Valores proporcionales con IVA para los consumos realizados<br/>
				a partir del 20-01-2016
				
				<br/>
				<div class="pull-left">Cargo fijo</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfCargoFijo'], 0); ?></small>

				<br/>
				<div class="pull-left">Metro cubico agua potable</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfMetroAgua'], 2); ?></small>

				<br/>
				<div class="pull-left">Metro cubico recoleccion</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfMetroRecolecion'], 2); ?></small>

				<br/>
				<div class="pull-left">Visita corte</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfVisitaCorte'], 0); ?></small>

				<br/>
				<div class="pull-left">Corte 1° instancia</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfCorte1'], 0); ?></small>

				<br/>
				<div class="pull-left">Corte 2° instancia</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfCorte2'], 0); ?></small>

				<br/>
				<div class="pull-left">Reposicion 1° instancia</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfReposicion1'], 0); ?></small>

				<br/>
				<div class="pull-left">Reposicion 2° instancia</div>
				<small class="pull-right"><?php echo Valores($rowDatos['AguasInfReposicion2'], 0); ?></small>

				</p>

				<div class="clearfix"></div>

				<p>
				<div class="pull-left">Factor de cobro del periodo</div>
				<small class="pull-right"><?php echo $rowDatos['AguasInfFactorCobro'] ?></small>

				<?php
				//verificacion de remarcador
				if(isset($rowDatos['ClienteRemarcador'])&&$rowDatos['ClienteRemarcador']!=''&&$rowDatos['ClienteRemarcador']!=0){ ?>
				<br/>
					<div class="pull-left">Diferencia medidor general</div>
					<small class="pull-right">
					<?php
					if($rowDatos['AguasInfDifMedGeneral']>0){
						$bla = '(+)'.Cantidades($rowDatos['AguasInfDifMedGeneral'], 2);
					}elseif($rowDatos['AguasInfDifMedGeneral']<0){
						$bla = '(-)'.Cantidades($rowDatos['AguasInfDifMedGeneral']*-1, 2);
					}else{
						$bla = '(+)0';
					}
					echo $bla.' m3'; ?>
					</small>

					<br/>
					<div class="pull-left">Porcentaje Prorrateo</div>
					<small class="pull-right"><?php echo $rowDatos['AguasInfProcProrrateo'] ?> %</small>
				<?php } ?>

				<br/>
				<div class="pull-left">Punto servicio diametro</div>
				<small class="pull-right"><?php echo $rowDatos['AguasInfTipoMedicion'].' '.$rowDatos['AguasInfPuntoDiametro'].'mm' ?></small>

				<br/>
				<div class="pull-left">Clave facturacion</div>
				<small class="pull-right"><?php echo $rowDatos['AguasInfClaveFacturacion'] ?></small>

				<br/>
				<div class="pull-left">Clave Lectura</div>
				<small class="pull-right"><?php echo $rowDatos['AguasInfClaveLectura'] ?></small>

				<br/>
				<div class="pull-left">Numero medidor</div>
				<small class="pull-right"><?php echo $rowDatos['AguasInfNumeroMedidor'] ?></small>
				</p>

				<div class="clearfix"></div>
				
		
				<p>
				<div class="pull-left">Tarifas publicadas la nacion</div>
				<small class="pull-right">26-05-2017</small>

				<br/>
				<div class="pull-left">Fecha emision</div>
				<small class="pull-right"><?php echo Fecha_estandar($rowDatos['AguasInfFechaEmision']); ?></small>

				<br/>
				<div class="pull-left">Ultimo pago</div>
				<small class="pull-right">
					<?php echo '('.valores($rowDatos['AguasInfUltimoPagoMonto'], 0).') ';
					if(isset($rowDatos['AguasInfUltimoPagoFecha'])&&$rowDatos['AguasInfUltimoPagoFecha']!='0000-00-00'){
					echo Fecha_estandar($rowDatos['AguasInfUltimoPagoFecha']);
					}else{
					echo 'Sin datos';
					} ?>
				</small>

				<br/>
				<div class="pull-left">Considera movimientos hasta</div>
				<small class="pull-right"><?php echo Fecha_estandar($rowDatos['AguasInfMovimientosHasta']); ?></small>
				</p>

				<div class="clearfix"></div>

			</div>
		</div>
		</div>
	</section>
	</div>

