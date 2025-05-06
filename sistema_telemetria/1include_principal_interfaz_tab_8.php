<?php
/**************************************************************************/
//Facturacion Furgones
$temp = $prm_x[42] + $prm_x[43];
if($temp!=0) {

	//Se traen todas las facturaciones impagas
	$SIS_query = '
	apoderados_listado.idApoderado AS IDD,
	apoderados_listado.Nombre AS ApoderadoNombre,
	apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
	apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,
	sistema_planes_transporte.Nombre AS PlanNombre,
	sistema_planes_transporte.Valor_Mensual AS PlanValor_Mensual,
	(SELECT COUNT(idFacturacionDetalle) FROM `vehiculos_facturacion_apoderados_listado_detalle` WHERE idApoderado=IDD AND idEstadoPago=1 AND idMes=".mes_actual()." AND Ano=".ano_actual()." ) AS CuentaActual,
	(SELECT COUNT(idFacturacionDetalle) FROM `vehiculos_facturacion_apoderados_listado_detalle` WHERE idApoderado=IDD AND idEstadoPago=1 AND idMes!=".mes_actual()." AND Ano!=".ano_actual()." ) AS CuentaRetraso';
	$SIS_join  = 'LEFT JOIN `sistema_planes_transporte`  ON sistema_planes_transporte.idPlan   = apoderados_listado.idPlan';
	$SIS_where = 'apoderados_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].' AND apoderados_listado.idEstado=1';
	$SIS_order = 'apoderados_listado.ApellidoPat ASC';
	$arrFacturaciones = array();
	$arrFacturaciones = db_select_array (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFacturaciones');

	?>

	<div class="tab-pane fade" id="Menu_tab_8">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Facturaciones Pendientes Pago</h5>
				</header>
				<div class="table-responsive">

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th colspan="4">Mes Actual</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrFacturaciones as $fact) {
										//Solo los que deben el mes actual
										if(isset($fact['CuentaActual'])&&$fact['CuentaActual']==1){ ?>
											<tr class="odd">
												<td><?php echo $fact['ApoderadoNombre'].' '.$fact['ApoderadoApellidoPat'].' '.$fact['ApoderadoApellidoMat']; ?></td>
												<td><?php echo $fact['PlanNombre']; ?></td>
												<td><?php echo $fact['PlanValor_Mensual']; ?></td>
												<td width="10">
													<div class="btn-group" style="width: 35px;" >
														<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($fact['IDD'], fecha_actual()); ?>" title="Ver Facturacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th colspan="4">1 Mes Retraso</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrFacturaciones as $fact) {
										//Solo los que deben el mes actual
										if(isset($fact['CuentaRetraso'])&&$fact['CuentaRetraso']==1){ ?>
											<tr class="odd">
												<td><?php echo $fact['ApoderadoNombre'].' '.$fact['ApoderadoApellidoPat'].' '.$fact['ApoderadoApellidoMat']; ?></td>
												<td><?php echo $fact['PlanNombre']; ?></td>
												<td><?php echo $fact['PlanValor_Mensual']; ?></td>
												<td width="10">
													<div class="btn-group" style="width: 35px;" >
														<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($fact['IDD'], fecha_actual()); ?>" title="Ver Facturacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th colspan="4">2 Meses Retraso</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrFacturaciones as $fact) {
										//Solo los que deben el mes actual
										if(isset($fact['CuentaRetraso'])&&$fact['CuentaRetraso']==2){ ?>
											<tr class="odd">
												<td><?php echo $fact['ApoderadoNombre'].' '.$fact['ApoderadoApellidoPat'].' '.$fact['ApoderadoApellidoMat']; ?></td>
												<td><?php echo $fact['PlanNombre']; ?></td>
												<td><?php echo $fact['PlanValor_Mensual']; ?></td>
												<td width="10">
													<div class="btn-group" style="width: 35px;" >
														<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($fact['IDD'], fecha_actual()); ?>" title="Ver Facturacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th colspan="4">3 Meses Retraso</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrFacturaciones as $fact) {
										//Solo los que deben el mes actual
										if(isset($fact['CuentaRetraso'])&&$fact['CuentaRetraso']==3){ ?>
											<tr class="odd">
												<td><?php echo $fact['ApoderadoNombre'].' '.$fact['ApoderadoApellidoPat'].' '.$fact['ApoderadoApellidoMat']; ?></td>
												<td><?php echo $fact['PlanNombre']; ?></td>
												<td><?php echo $fact['PlanValor_Mensual']; ?></td>
												<td width="10">
													<div class="btn-group" style="width: 35px;" >
														<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($fact['IDD'], fecha_actual()); ?>" title="Ver Facturacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

<?php } ?>






