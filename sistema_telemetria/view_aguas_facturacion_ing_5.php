
	<div class="">
		<section class="invoice">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="page-header">
						<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $_SESSION['Facturacion_basicos']['SistemaNombre']?>
					</h2>
				</div>
			</div>

			<div class="row invoice-info">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					<address>
						RUT : <?php echo $_SESSION['Facturacion_basicos']['SistemaRut']?><br>
						<?php echo $_SESSION['Facturacion_basicos']['SistemaRubro']?><br>
						<?php echo $_SESSION['Facturacion_basicos']['SistemaDireccion'].' '.$_SESSION['Facturacion_basicos']['SistemaComuna'].' '.$_SESSION['Facturacion_basicos']['SistemaCiudad']; ?><br>
						<?php echo formatPhone($_SESSION['Facturacion_basicos']['SistemaFono1']) ?>
						<?php echo formatPhone($_SESSION['Facturacion_basicos']['SistemaFono2']) ?>
					</address>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					<br><br><br>
					<?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['DocFacturable'].' '.$_SESSION['Facturacion_clientes'][$X_Puntero]['SII_NDoc'] ?>
				</div>

			</div>

			<div class="row invoice-info">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					<p class="well well-sm no-shadow" style="background-color: #fff;text-align: center;" >
						<br>
						<?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteNombre']?><br>
						<?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteDireccion']?><br>
						<?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteNombreComuna']?><br>
						<br>
					</p>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					<p class="well well-sm no-shadow" style="background-color: #fff;text-align: center;" >
						N° Cliente: <?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteIdentificador']?>
					</p>
					<p class="well well-sm no-shadow" style="background-color: #fff;text-align: center;" >
						TOTAL A PAGAR:<?php if($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalAPagar']>0){echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalAPagar'], 0);}else{echo '0';} ?>
						<br>
						<?php
						//Se trae el saldo anterior si es que este existe
						if($_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteEstado']=='Sin Problemas'){
							echo 'VENCIMIENTO: '.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteFechaVencimiento']);
						}else{
							echo $_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteEstado'];
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
							<th width="100px">IVA</th>
							<th width="100px">Cantidad</th>
							<th width="100px">Precio Unitario</th>
							<th width="100px" align="right">Total Item</th>
						</tr>
					</thead>
					<tbody>
						<?php
							//verificacion de remarcador
							if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateo'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateo']!=''&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateo']!=0){
								$ndecim = 2;
							}else{
								$ndecim = 0;	
							}
						?>

						<tr>
							<td>Cargo Fijo Cliente</td>
							<td>Afecto</td>
							<td align="right"><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['ClienteUnidadHabitacional']; ?></td>
							<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfCargoFijo']/1.19), 2); ?></td>
							<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCargoFijoValor']/1.19), 0); ?></td>
						</tr>
						<tr>
							<td>Consumo Agua Potable</td>
							<td>Afecto</td>
							<td align="right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleConsumoCantidad'], $ndecim); ?></td>
							<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfMetroAgua']/1.19), 2); ?></td>
							<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleConsumoValor']/1.19), 0); ?></td>
						</tr>
						<tr>
							<td>Recoleccion de Aguas Servidas</td>
							<td>Afecto</td>
							<td align="right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleRecoleccionCantidad'], $ndecim); ?></td>
							<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfMetroRecolecion']/1.19), 2); ?></td>
							<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleRecoleccionValor']/1.19), 0); ?></td>
						</tr>
						<?php if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleVisitaCorte'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleVisitaCorte']!=0){ ?>
							<tr>
								<td>Visita Corte</td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleVisitaCorte']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleVisitaCorte']/1.19), 0); ?></td>
							</tr>
						<?php } ?>
						<?php if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte1Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte1Valor']!=0){ ?>
							<tr>
								<td>Corte 1° instancia <?php echo ' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte1Fecha']).')'?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte1Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte1Valor']/1.19), 0); ?></td>
							</tr>
						<?php } ?>
						<?php if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte2Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte2Valor']!=0){ ?>
							<tr>
								<td>Corte 2° instancia <?php echo ' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte2Fecha']).')'?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte2Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleCorte2Valor']/1.19), 0); ?></td>
							</tr>
						<?php } ?>
						<?php if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion1Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion1Valor']!=0){ ?>
							<tr>
								<td>Reposicion 1° instancia <?php echo ' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion1Fecha']).')'?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion1Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion1Valor']/1.19), 0); ?></td>
							</tr>
						<?php } ?>
						<?php if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion2Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion2Valor']!=0){ ?>
							<tr>
								<td>Reposicion 2° instancia <?php echo ' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion2Fecha']).')'?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion2Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleReposicion2Valor']/1.19), 0); ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="4"><strong>SUBTOTAL SERVICIO</strong></td>
							<td align="right"><strong><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSubtotalServicio']/1.19), 0); ?></strong></td>
						</tr>
						<?php if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleInteresDeuda'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleInteresDeuda']!=0){ ?>
							<tr>
								<td>Interes Deuda</td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleInteresDeuda']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleInteresDeuda']/1.19), 0); ?></td>
							</tr>
						<?php } ?>

						<?php
						//Otros Cargos 1
						if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos1Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos1Valor']!=0){ ?>
							<tr>
								<td><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos1Texto'].' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos1Fecha']).')'; ?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos1Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos1Valor']/1.19), 0); ?></td>
							</tr>
						<?php } 
						//Otros Cargos 2
						if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos2Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos2Valor']!=0){ ?>
							<tr>
								<td><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos2Texto'].' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos2Fecha']).')'; ?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos2Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos2Valor']/1.19), 0); ?></td>
							</tr>
						<?php } 
						//Otros Cargos 3
						if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos3Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos3Valor']!=0){ ?>
							<tr>
								<td><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos3Texto'].' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos3Fecha']).')'; ?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos3Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos3Valor']/1.19), 0); ?></td>
							</tr>
						<?php } 
						//Otros Cargos 4
						if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos4Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos4Valor']!=0){ ?>
							<tr>
								<td><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos4Texto'].' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos4Fecha']).')'; ?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos4Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos4Valor']/1.19), 0); ?></td>
							</tr>
						<?php } 
						//Otros Cargos 5
						if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos5Valor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos5Valor']!=0){ ?>
							<tr>
								<td><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos5Texto'].' ('.Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos5Fecha']).')'; ?></td>
								<td>Afecto</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos5Valor']/1.19), 2); ?></td>
								<td align="right"><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleOtrosCargos5Valor']/1.19), 0); ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="4"><strong>TOTAL VENTA NETO</strong></td>
							<td align="right"><strong><?php echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalVenta']/1.19), 0); ?></strong></td>
						</tr>
						<?php
						//variable exento
						$Exento = 0;
						if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoFavor'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoFavor']!=0){
							$Exento = $Exento - $_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoFavor']; ?>
							<tr>
								<td>Saldo a Favor</td>
								<td>Exento</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoFavor'], 0); ?></td>
								<td align="right"><?php echo '(-) '.Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoFavor'], 0); ?></td>
							</tr>
						<?php } ?>
						<?php if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoAnterior'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoAnterior']!=0){
							$Exento = $Exento + $_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoAnterior']; ?>
							<tr>
								<td>Saldo Anterior</td>
								<td>Exento</td>
								<td align="right">1</td>
								<td align="right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoAnterior'], 0); ?></td>
								<td align="right"><?php echo '(+) '.Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleSaldoAnterior'], 0); ?></td>
							</tr>
						<?php } ?>

					</tbody>
				</table>
				<div class="row text-right" style="margin-top:20px;">
					<div class="col-xs-2 col-xs-offset-8">
						<p>
							<strong>
								TOTAL VENTA NETO : <br>
								AFECTO IVA (19%) : <br>
								EXENTOS : <br>
								TOTAL : <br>
							</strong>
						</p>
					</div>
					<div class="col-xs-2">
						<strong>
							<?php
							if($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalVenta']>0){
								echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalVenta']/1.19), 0).'<br>';
								echo Valores(($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalVenta']-($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalVenta']/1.19)), 0).'<br>';
								echo Valores($Exento, 0).'<br>'; 
								echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalAPagar'], 0).'<br>';
							}else{
								echo Valores(0, 0).'<br>';
								echo Valores(0, 0).'<br>';
								echo Valores(0, 0).'<br>';
								echo Valores(0, 0).'<br>';
							}
							?>
						</strong>
					</div>
				</div>
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
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes1Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes1Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes2Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes2Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes3Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes3Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes4Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes4Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes5Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes5Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes6Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes6Valor'], 2); ?> m3</small> <br/> 
											<div class="clearfix"></div>
										</div>
										<div class="col-xs-6">
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes7Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes7Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes8Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes8Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes9Fecha']); ?></div>   <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes9Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes10Fecha']); ?></div>  <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes10Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes11Fecha']); ?></div>  <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes11Valor'], 2); ?> m3</small> <br/> 
											<div class="pull-left"><?php echo Devolver_mes($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes12Fecha']); ?></div>  <small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['GraficoMes12Valor'], 2); ?> m3</small> 
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
								if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesAnteriorFecha'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesAnteriorFecha']!='0000-00-00'&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesAnteriorFecha']!=''){
									$mes_anterior = Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesAnteriorFecha']);
								}else{
									$mes_anterior = 'Sin datos';
								} ?>
								<div class="pull-left">Lectura Mes anterior <?php echo '('.$mes_anterior.')'; ?></div>
								<small class="pull-right"><?php echo valores_truncados($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesAnteriorCantidad']) ?> m3</small>

								<br/>
								<?php 
								if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesActualFecha'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesActualFecha']!='0000-00-00'&&$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesActualFecha']!=''){
									$mes_actual = Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesActualFecha']);
								}else{
									$mes_actual = 'Sin datos';
								} ?>
								<div class="pull-left">Lectura Mes actual <?php echo '('.$mes_actual.')'; ?></div>
								<small class="pull-right"><?php echo valores_truncados($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesActualCantidad']) ?> m3</small>

								<br/>
								<div class="pull-left">Diferencia de lecturas</div>
								<small class="pull-right"><?php echo valores_truncados($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesDiferencia']) ?> m3</small>

								<?php
								//verificacion de remarcador
								if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion']!=''&&$_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion']!=0){ ?>
								<br/>
									<div class="pull-left">Adicionales por prorrateo</div>
									<small class="pull-right">
										<?php
										if($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateo']>0){
											$bla = $_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateoSigno'].' '.$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateo'];
										}elseif($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateo']<0){
											$bla = $_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateoSigno'].' '.$_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsProrateo']*-1;
										}else{
											$bla = '(+) 0';
										}
										echo $bla.' m3'; ?>
									</small>	
								<?php } ?>

								<br/>
								<div class="pull-left">Consumo Mes Total</div>
								<small class="pull-right"><?php echo Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsMesTotalCantidad'], $ndecim) ?> m3</small>
							</p>

							<div class="clearfix"></div>

							<p>
								<div class="pull-left">Proxima lectura estimada</div>
								<small class="pull-right"><?php echo Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsFechaProxLectura']); ?></small>
								<?php
								//verificacion de remarcador
								if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion']!=''&&$_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion']!=0){ ?>
								<br/>
								<div class="pull-left">Modalidad de prorrateo: <?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsModalidad']; ?></div>
								<?php } ?>
							</p>

							<div class="clearfix"></div>
						
							<p>
								<div class="pull-left">Emergencias 24 horas </div>
								<small class="pull-right"><?php echo formatPhone($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsFonoEmergencias']) ?></small>

								<br/>
								<div class="pull-left">Consultas Lunes a Viernes </div>
								<small class="pull-right"><?php echo formatPhone($_SESSION['Facturacion_clientes'][$X_Puntero]['DetConsFonoConsultas']) ?></small>
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
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfCargoFijo'], 0); ?></small>

								<br/>
								<div class="pull-left">Metro cubico agua potable</div>
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfMetroAgua'], 2); ?></small>

								<br/>
								<div class="pull-left">Metro cubico recoleccion</div>
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfMetroRecolecion'], 2); ?></small>

								<br/>
								<div class="pull-left">Visita corte</div>
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfVisitaCorte'], 0); ?></small>

								<br/>
								<div class="pull-left">Corte 1° instancia</div>
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfCorte1'], 0); ?></small>

								<br/>
								<div class="pull-left">Corte 2° instancia</div>
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfCorte2'], 0); ?></small>

								<br/>
								<div class="pull-left">Reposicion 1° instancia</div>
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfReposicion1'], 0); ?></small>

								<br/>
								<div class="pull-left">Reposicion 2° instancia</div>
								<small class="pull-right"><?php echo Valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfReposicion2'], 0); ?></small>

							</p>

							<div class="clearfix"></div>

							<p>
								<div class="pull-left">Factor de cobro del periodo</div>
								<small class="pull-right"><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfFactorCobro'] ?></small>

								<?php
								//verificacion de remarcador
								if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion']!=''&&$_SESSION['Facturacion_clientes'][$X_Puntero]['idTipoMedicion']!=0){ ?>
								<br/>
									<div class="pull-left">Diferencia medidor general</div>
									<small class="pull-right">
										<?php
										if($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfDifMedGeneral']>0){
											$bla = '(+)'.Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfDifMedGeneral'], 2);
										}elseif($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfDifMedGeneral']<0){
											$bla = '(-)'.Cantidades($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfDifMedGeneral']*-1, 2);
										}else{
											$bla = '(+)0';
										}
										echo $bla.' m3'; ?>
									</small>

									<br/>
									<div class="pull-left">Porcentaje Prorrateo</div>
									<small class="pull-right"><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfProcProrrateo'] ?> %</small>	
								<?php } ?>

								<br/>
								<div class="pull-left">Punto servicio diametro</div>
								<small class="pull-right"><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfTipoMedicion'].' '.$_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfPuntoDiametro'].'mm' ?></small>

								<br/>
								<div class="pull-left">Clave facturacion</div>
								<small class="pull-right"><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfClaveFacturacion'] ?></small>

								<br/>
								<div class="pull-left">Clave Lectura</div>
								<small class="pull-right"><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfClaveLectura'] ?></small>

								<br/>
								<div class="pull-left">Numero medidor</div>
								<small class="pull-right"><?php echo $_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfNumeroMedidor'] ?></small>
							</p>

							<div class="clearfix"></div>
							
				
							<p>
								<div class="pull-left">Tarifas publicadas la nacion</div>
								<small class="pull-right">26-05-2017</small>

								<br/>	
								<div class="pull-left">Fecha emision</div>
								<small class="pull-right"><?php echo Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfFechaEmision']); ?></small>

								<br/>	
								<div class="pull-left">Ultimo pago</div>
								<small class="pull-right">
									<?php echo '('.valores($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfUltimoPagoMonto'], 0).') ';
									if(isset($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfUltimoPagoFecha'])&&$_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfUltimoPagoFecha']!='0000-00-00'){
										echo Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfUltimoPagoFecha']);
									}else{
										echo 'Sin datos';
									} ?>
								</small>

								<br/>	
								<div class="pull-left">Considera movimientos hasta</div>
								<small class="pull-right"><?php echo Fecha_estandar($_SESSION['Facturacion_clientes'][$X_Puntero]['AguasInfMovimientosHasta']); ?></small>
							</p>

							<div class="clearfix"></div>

					</div>
				</div>
			</div>
		</section>

		<div class="">
			<div class="col-xs-12">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 well well-sm no-shadow" style="background-color: #fff;">
					<p><?php echo 'Son: '.numtoletras($_SESSION['Facturacion_clientes'][$X_Puntero]['DetalleTotalAPagar']); ?></p>
				</div>
			</div>
		</div>

	</div>



