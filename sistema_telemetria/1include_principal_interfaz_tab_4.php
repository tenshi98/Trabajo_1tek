<?php
/**************************************************************************/
$temp = $prm_x[6] + $prm_x[10] + $prm_x[11];
if($temp!=0) {

// Se trae un listado con todos los elementos
$SIS_query = '
clientes_listado.idCliente,
clientes_listado.idSistema,
clientes_listado.Rut,
clientes_listado.Nombre,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema
,(SELECT COUNT(orden_trabajo_listado.idOT)
FROM orden_trabajo_listado
LEFT JOIN maquinas_listado ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
WHERE  orden_trabajo_listado.idSistema=clientes_listado.idSistema
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND orden_trabajo_listado.progSemana='.semana_actual().'
AND orden_trabajo_listado.progAno='.ano_actual().'
LIMIT 1 ) AS CountOTSemanaCliente

,(SELECT COUNT(orden_trabajo_listado.idOT)
FROM orden_trabajo_listado
LEFT JOIN maquinas_listado ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
WHERE  orden_trabajo_listado.idSistema=clientes_listado.idSistema
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND orden_trabajo_listado.progSemana<'.semana_actual().'
AND orden_trabajo_listado.progMes='.mes_actual().'
AND orden_trabajo_listado.progAno='.ano_actual().'
AND orden_trabajo_listado.idEstado=1
LIMIT 1 ) AS CountOTRetrasadaMes

,(SELECT COUNT(orden_trabajo_listado.idOT)
FROM orden_trabajo_listado
LEFT JOIN maquinas_listado ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
WHERE  orden_trabajo_listado.idSistema=clientes_listado.idSistema
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND orden_trabajo_listado.progSemana>'.semana_actual().'
AND orden_trabajo_listado.progMes='.mes_actual().'
AND orden_trabajo_listado.progAno='.ano_actual().'
AND orden_trabajo_listado.idEstado=1
LIMIT 1 ) AS CountOTProgramadaMes

,(SELECT COUNT(orden_trabajo_listado.idOT)
FROM orden_trabajo_listado
LEFT JOIN maquinas_listado ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
WHERE  orden_trabajo_listado.idSistema=clientes_listado.idSistema
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND orden_trabajo_listado.progMes='.mes_actual().'
AND orden_trabajo_listado.progAno='.ano_actual().'
AND orden_trabajo_listado.idEstado=2
LIMIT 1 ) AS CountOTFinalizadaMes

,(SELECT COUNT(orden_trabajo_listado.idOT)
FROM orden_trabajo_listado
LEFT JOIN maquinas_listado ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
WHERE  orden_trabajo_listado.idSistema=clientes_listado.idSistema
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND orden_trabajo_listado.progSemana<'.semana_actual().'
AND orden_trabajo_listado.progAno='.ano_actual().'
AND orden_trabajo_listado.idEstado=1
LIMIT 1 ) AS CountOTRetrasadaTotal

,(SELECT COUNT(orden_trabajo_listado.idOT)
FROM orden_trabajo_listado
LEFT JOIN maquinas_listado ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
WHERE  orden_trabajo_listado.idSistema=clientes_listado.idSistema
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND orden_trabajo_listado.progSemana>'.semana_actual().'
AND orden_trabajo_listado.progAno='.ano_actual().'
AND orden_trabajo_listado.idEstado=1
LIMIT 1 ) AS CountOTProgramadaTotal

,(SELECT COUNT(orden_trabajo_listado.idOT)
FROM orden_trabajo_listado
LEFT JOIN maquinas_listado ON maquinas_listado.idMaquina = orden_trabajo_listado.idMaquina
WHERE  orden_trabajo_listado.idSistema=clientes_listado.idSistema
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND orden_trabajo_listado.progAno='.ano_actual().'
AND orden_trabajo_listado.idEstado=2
LIMIT 1 ) AS CountOTFinalizadaTotal

,(SELECT COUNT(analisis_listado_alertas.idAnalisisAlertas)
FROM analisis_listado_alertas
LEFT JOIN `analisis_listado`   ON analisis_listado.idAnalisis  = analisis_listado_alertas.idAnalisis
LEFT JOIN maquinas_listado     ON maquinas_listado.idMaquina   = analisis_listado.idMaquina
WHERE analisis_listado.idSistema=clientes_listado.idSistema
AND analisis_listado_alertas.nivel=1
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND analisis_listado_alertas.Creacion_mes='.mes_actual().'
AND analisis_listado_alertas.Creacion_ano='.ano_actual().'
LIMIT 1 ) AS CountAlertaNivelCliente_1

,(SELECT COUNT(analisis_listado_alertas.idAnalisisAlertas)
FROM analisis_listado_alertas
LEFT JOIN `analisis_listado`   ON analisis_listado.idAnalisis  = analisis_listado_alertas.idAnalisis
LEFT JOIN maquinas_listado     ON maquinas_listado.idMaquina   = analisis_listado.idMaquina
WHERE analisis_listado.idSistema=clientes_listado.idSistema
AND analisis_listado_alertas.nivel=2
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND analisis_listado_alertas.Creacion_mes='.mes_actual().'
AND analisis_listado_alertas.Creacion_ano='.ano_actual().'
LIMIT 1 ) AS CountAlertaNivelCliente_2

,(SELECT COUNT(analisis_listado_alertas.idAnalisisAlertas)
FROM analisis_listado_alertas
LEFT JOIN `analisis_listado`   ON analisis_listado.idAnalisis  = analisis_listado_alertas.idAnalisis
LEFT JOIN maquinas_listado     ON maquinas_listado.idMaquina   = analisis_listado.idMaquina
WHERE analisis_listado.idSistema=clientes_listado.idSistema
AND analisis_listado_alertas.nivel=3
AND maquinas_listado.idCliente=clientes_listado.idCliente
AND analisis_listado_alertas.Creacion_mes='.mes_actual().'
AND analisis_listado_alertas.Creacion_ano='.ano_actual().'
LIMIT 1 ) AS CountAlertaNivelCliente_3';
$SIS_join  = '
LEFT JOIN `core_estados`   ON core_estados.idEstado       = clientes_listado.idEstado
LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema     = clientes_listado.idSistema';
$SIS_where = 'clientes_listado.idCliente!=0';//Variable de busqueda
$SIS_where.= ' AND clientes_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];//sistema
$SIS_order = 'clientes_listado.idCliente ASC';
$arrClientes = array();
$arrClientes = db_select_array (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrClientes');


echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load(\'current\', {\'packages\':[\'corechart\']});</script>';		

	echo '<div class="tab-pane fade" id="Menu_tab_4">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 admin-grid">
					<div class="sort-disable">

						<div class="panel-heading">
							<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;">Resumen General</span>
						</div>

						<div class="panel-body mnw700 of-a">
							<div class="row">
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
									<h5 style="color: #666;font-weight: 600 !important;">Ordenes de Trabajo
										<small class="pull-right fw600 text-primary"></small>
									</h5>

									<table class="table mbn covertable">
										<tbody>';
											/****************************************************/
											//Acceso a las OT de la semana
											$OT_Semana = $prm_x[10] + $prm_x[11];
											if($OT_Semana!=0) {
												echo '
												<tr>
													<td class="text-muted">
														<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-blue" aria-hidden="true"></i> OT para la Semana</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountOTSemana'].'</td>
												</tr>
												<tr>
													<td class="text-muted">
														<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-red" aria-hidden="true"></i> OT no Cumplidas</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountOTRetrasada'].'</td>
												</tr>';

											}
											echo '
										</tbody>
									</table>
								</div>';

								/**************************************************************/
								echo '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

									<h5 style="color: #666;font-weight: 600 !important;">Analisis Maquinas
										<small class="pull-right fw600 text-primary"></small>
									</h5>
									<table class="table mbn covertable">
										<tbody>';

										if($n_permisos['idOpcionesGen_2']=='1' OR $idTipoUsuario==1) {
											//Alertas Amarillas
											/*if($subconsulta['CountAlertaNivel_1']!=0) {
												echo '
												<tr>
													<td class="text-muted">
														<a href="principal_alertas_alt.php?nivel=1" class="iframe" ><i class="fa fa-exclamation-triangle color-yellow" aria-hidden="true"></i> Alertas Amarillas</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountAlertaNivel_1'].'</td>
												</tr>';
											}*/
											//Alertas naranjas
											if($subconsulta['CountAlertaNivel_2']!=0) {
												echo '
												<tr>
													<td class="text-muted">
														<a href="principal_alertas_alt.php?nivel=2" class="iframe" ><i class="fa fa-exclamation-triangle color-yellow" aria-hidden="true"></i> Alertas Amarillas</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountAlertaNivel_2'].'</td>
												</tr>';
											}
											//Alertas rojas
											if($subconsulta['CountAlertaNivel_3']!=0) {
												echo '
												<tr>
													<td class="text-muted">
														<a href="principal_alertas_alt.php?nivel=3" class="iframe" ><i class="fa fa-exclamation-triangle color-red" aria-hidden="true"></i> Alertas Rojas</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountAlertaNivel_3'].'</td>
												</tr>';
											}

										}
										echo '
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>';

echo '
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Detalle Clientes</h5>
				<ul class="nav nav-tabs pull-right">';
					$xcounter = 1;
					foreach($arrClientes as $cli) {
						if($xcounter==1){$xactive = 'active';}else{$xactive = '';}
						if($xcounter==4){echo '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';}
						echo '<li class="'.$xactive.'"><a href="#xid_'.$cli['idCliente'].'" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> '.$cli['Nombre'].'</a></li>';
						$xcounter++;
					}
					if($xcounter>4){echo '</ul></li>';}
				echo '
				</ul>
			</header>
			<div id="div-4" class="tab-content">';
				$xcounter = 1;
				foreach($arrClientes as $cli) {
					if($xcounter==1){$xactive = 'active in';}else{$xactive = '';}

						echo '
						<div class="tab-pane fade '.$xactive.'" id="xid_'.$cli['idCliente'].'">
							<div class="wmd-panel">
								<div class="table-responsive">

									<div class="sort-disable">

										<div class="panel-heading">
											<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;">'.$cli['Nombre'].'</span>
										</div>

										<div class="panel-body mnw700 of-a">';

											/**************************************************************/
											echo '
											<div class="row">
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
													<h5 style="color: #666;font-weight: 600 !important;">Ordenes de Trabajo (Mes)
														<small class="pull-right fw600 text-primary"></small>
													</h5>

													<table class="table mbn covertable">
														<tbody>

															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-blue" aria-hidden="true"></i> OT para la Semana</a>
																</td>
																<td class="text-right color-blue" style="font-weight: 700;">'.$cli['CountOTSemanaCliente'].'</td>
															</tr>
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-red" aria-hidden="true"></i> OT no Cumplidas</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$cli['CountOTRetrasadaMes'].'</td>
															</tr>
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-yellow-light" aria-hidden="true"></i> OT Programadas</a>
																</td>
																<td class="text-right color-yellow-light" style="font-weight: 700;">'.$cli['CountOTProgramadaMes'].'</td>
															</tr>
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-green-dark" aria-hidden="true"></i> OT Finalizadas</a>
																</td>
																<td class="text-right color-green-dark" style="font-weight: 700;">'.$cli['CountOTFinalizadaMes'].'</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

													<script>

														google.charts.setOnLoadCallback(drawChart_'.$xcounter.');

														function drawChart_'.$xcounter.'() {

															var data = google.visualization.arrayToDataTable([
																[\'Tipo\', \'Cantidad\'],
																[\'OT no Cumplidas\', '.Cantidades_decimales_justos($cli['CountOTRetrasadaMes']).'],
																[\'OT Programadas\', '.Cantidades_decimales_justos($cli['CountOTProgramadaMes']).'],
																[\'OT Finalizadas\', '.Cantidades_decimales_justos($cli['CountOTFinalizadaMes']).']
															]);

															var options = {
																title: \'Grafico Ordenes de Trabajo (Mes)\',
																is3D: true,
																colors:[\'#FF5800\',\'#f0ad4e\',\'#5cb85c\']
															};

															var chart_'.$xcounter.' = new google.visualization.PieChart(document.getElementById("chart_mes_'.$xcounter.'"));

															chart_'.$xcounter.'.draw(data, options);

														}
													</script>
													<div id="chart_mes_'.$xcounter.'" style="height: 200px; width: 100%;"></div>

												</div>
											</div>';

											/**************************************************************/
											echo '
											<div class="row">
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
													<h5 style="color: #666;font-weight: 600 !important;">Ordenes de Trabajo (Año)
														<small class="pull-right fw600 text-primary"></small>
													</h5>

													<table class="table mbn covertable">
														<tbody>

															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-red" aria-hidden="true"></i> OT no Cumplidas</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$cli['CountOTRetrasadaTotal'].'</td>
															</tr>
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-yellow-light" aria-hidden="true"></i> OT Programadas</a>
																</td>
																<td class="text-right color-yellow-light" style="font-weight: 700;">'.$cli['CountOTProgramadaTotal'].'</td>
															</tr>
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1" class="iframe"><i class="fa fa-database color-green-dark" aria-hidden="true"></i> OT Finalizadas</a>
																</td>
																<td class="text-right color-green-dark" style="font-weight: 700;">'.$cli['CountOTFinalizadaTotal'].'</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

													<script>

														google.charts.setOnLoadCallback(drawChart_'.$xcounter.');

														function drawChart_'.$xcounter.'() {

															var data = google.visualization.arrayToDataTable([
																[\'Tipo\', \'Cantidad\'],
																[\'OT no Cumplidas\', '.Cantidades_decimales_justos($cli['CountOTRetrasadaTotal']).'],
																[\'OT Programadas\', '.Cantidades_decimales_justos($cli['CountOTProgramadaTotal']).'],
																[\'OT Finalizadas\', '.Cantidades_decimales_justos($cli['CountOTFinalizadaTotal']).']
															]);

															var options = {
																title: \'Grafico Ordenes de Trabajo (Año)\',
																is3D: true,
																colors:[\'#FF5800\',\'#f0ad4e\',\'#5cb85c\']
															};

															var chart_'.$xcounter.' = new google.visualization.PieChart(document.getElementById("chart_ano_'.$xcounter.'"));

															chart_'.$xcounter.'.draw(data, options);

														}
													</script>
													<div id="chart_ano_'.$xcounter.'" style="height: 200px; width: 100%;"></div>

												</div>
											</div>';

											/**************************************************************/
											echo '
											<div class="row">
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

													<h5 style="color: #666;font-weight: 600 !important;">Analisis Maquinas
														<small class="pull-right fw600 text-primary"></small>
													</h5>
													<table class="table mbn covertable">
														<tbody>';

														if($n_permisos['idOpcionesGen_2']=='1' OR $idTipoUsuario==1) {
															//Alertas Amarillas
															/*echo '
															<tr>
																<td class="text-muted">
																	<a href="principal_alertas_alt.php?nivel=1" class="iframe" ><i class="fa fa-exclamation-triangle color-yellow" aria-hidden="true"></i> Alertas Amarillas</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$cli['CountAlertaNivelCliente_1'].'</td>
															</tr>';*/
															//Alertas naranjas
															echo '
															<tr>
																<td class="text-muted">
																	<a href="principal_alertas_alt.php?nivel=2" class="iframe" ><i class="fa fa-exclamation-triangle color-yellow" aria-hidden="true"></i> Alertas Amarillas</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$cli['CountAlertaNivelCliente_2'].'</td>
															</tr>';

															//Alertas rojas
															echo '
															<tr>
																<td class="text-muted">
																	<a href="principal_alertas_alt.php?nivel=3" class="iframe" ><i class="fa fa-exclamation-triangle color-red" aria-hidden="true"></i> Alertas Rojas</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$cli['CountAlertaNivelCliente_3'].'</td>
															</tr>';

														}
														echo '
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>';

					$xcounter++;
				}
			echo '
			</div>
		</div>
	</div>
</div>

';


		echo '</div>';
	echo '</div>';

}

?>
