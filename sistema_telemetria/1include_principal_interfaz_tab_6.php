<?php
/**************************************************************************/
//Cross
$temp = $prm_x[32] + $prm_x[33] + $prm_x[34] + $prm_x[35] + $prm_x[36] + $prm_x[37];
if($temp!=0) {
	//Variables
	$FechaDesde = restarDias(fecha_actual(),330);

	// Se trae un listado con todos los elementos
	$SIS_query = '
	cross_shipping_consolidacion_estibas.idEstibaListado,
	cross_shipping_consolidacion_estibas.Temperatura,

	cross_shipping_consolidacion.Creacion_mes,
	cross_shipping_consolidacion.idCategoria,
	cross_shipping_consolidacion.idMercado,

	sistema_variedades_categorias.Temp_optima_min,
	sistema_variedades_categorias.Temp_optima_max,
	sistema_variedades_categorias.Temp_optima_margen_critico';
	$SIS_join  = '
	LEFT JOIN cross_shipping_consolidacion    ON cross_shipping_consolidacion.idConsolidacion   = cross_shipping_consolidacion_estibas.idConsolidacion
	LEFT JOIN sistema_variedades_categorias   ON sistema_variedades_categorias.idCategoria      = cross_shipping_consolidacion.idCategoria';
	$SIS_where = "cross_shipping_consolidacion.Creacion_fecha>'".$FechaDesde."'";
	$SIS_where.=" AND cross_shipping_consolidacion.idEstado=2";//solo las aprobadas
	$SIS_where.=" AND cross_shipping_consolidacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_order = 'cross_shipping_consolidacion.Creacion_ano ASC,
	cross_shipping_consolidacion.Creacion_mes ASC,
	cross_shipping_consolidacion.idCategoria ASC';
	$arrCross = array();
	$arrCross = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_estibas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCross');

	/************************************/
	// Se trae un listado con todos los meses
	$SIS_query = 'idMes, Nombre';
	$SIS_join  = '';
	$SIS_where = 'idMes!=0';
	$SIS_order = 'idMes ASC';
	$arrMeses = array();
	$arrMeses = db_select_array (false, $SIS_query, 'core_tiempo_meses', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMeses');

	/************************************/
	// Se trae un listado con todos los meses
	$SIS_query = 'idMercado, Nombre';
	$SIS_join  = '';
	$SIS_where = 'idMercado!=0';
	$SIS_order = 'idMercado ASC';
	$arrMercados = array();
	$arrMercados = db_select_array (false, $SIS_query, 'cross_shipping_mercado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMercados');

	/******************************************************************/
	//Variables
	$arrCrossGeneral    = array();

	//Inicializo variables
	/*$arrCrossGeneral['Normal']          = 0;
	$arrCrossGeneral['Critico']         = 0;
	$arrCrossGeneral['Fuera_de_rango']  = 0;
	for ($i = 1; $i <= 12; $i++) {
		$arrCrossGeneral[$i]['Normal']          = 0;
		$arrCrossGeneral[$i]['Critico']         = 0;
		$arrCrossGeneral[$i]['Fuera_de_rango']  = 0;
	}*/

	/********************************/
	//Se arman los datos
	foreach ($arrCross as $cross) {
		//Verifico que dato este configurado
		if(isset($cross['Temp_optima_min'])&&$cross['Temp_optima_min']!=0&&isset($cross['Temp_optima_max'])&&$cross['Temp_optima_max']!=0&&isset($cross['Temp_optima_margen_critico'])&&$cross['Temp_optima_margen_critico']!=0){

				//Variables temporales
			$temp_act       = $cross['Temperatura'];
			$temp_min       = $cross['Temp_optima_min'];
			$temp_max       = $cross['Temp_optima_max'];
			$temp_crit_min  = $cross['Temp_optima_min'] - $cross['Temp_optima_margen_critico'];
			$temp_crit_max  = $cross['Temp_optima_max'] + $cross['Temp_optima_margen_critico'];

			// Mercado
			$arrCrossGeneral[$cross['idMercado']]['Cantidad']++;

			//Verifico si temperatura esta dentro de lo normal
			if($temp_act>$temp_min&&$temp_act<$temp_max){
				$arrCrossGeneral['Normal']++;
				$arrCrossGeneral[$cross['Creacion_mes']]['Normal']++;

			//Si esta dentro de los margenes criticos superiores
			}elseif($temp_act>$temp_max&&$temp_act<$temp_crit_max){
				$arrCrossGeneral['Critico_sup']++;
				$arrCrossGeneral[$cross['Creacion_mes']]['Critico_sup']++;

			//si esta fuera de rango superior
			}elseif($temp_act>$temp_crit_max){
				$arrCrossGeneral['Fuera_de_rango_sup']++;
				$arrCrossGeneral[$cross['Creacion_mes']]['Fuera_de_rango_sup']++;

			//Si esta dentro de los margenes criticos inferiores
			}elseif($temp_act<$temp_min&&$temp_act>$temp_crit_min){
				$arrCrossGeneral['Critico_inf']++;
				$arrCrossGeneral[$cross['Creacion_mes']]['Critico_inf']++;

			//si esta fuera de rango inferior
			}elseif($temp_act<$temp_crit_min){
				$arrCrossGeneral['Fuera_de_rango_inf']++;
				$arrCrossGeneral[$cross['Creacion_mes']]['Fuera_de_rango_inf']++;

			}
		}
	}

	/********************************/
	//Se arman los datos
	$arrMes = array();
	foreach ($arrMeses as $mes) {
		$arrMes[$mes['idMes']]['Nombre'] = $mes['Nombre'];
	}

	/********************************************************************************/
	echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">google.charts.load(\'current\', {\'packages\':[\'corechart\', \'bar\']});</script>';

	echo '
	<div class="tab-pane fade" id="Menu_tab_6">

		<div class="table-responsive">

			<div class="sort-disable">

				<div class="panel-heading">
					<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;"> Detalle General</span>
				</div>

				<div class="panel-body mnw700 of-a">';

					/**************************************************************/
					echo '
					<div class="row">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<h5 style="color: #666;font-weight: 600 !important;">Estado Temperaturas
								<small class="pull-right fw600 text-primary"></small>
							</h5>

							<table class="table mbn covertable">
								<tbody>';
									/***************************************************************/
									//Verifico existencias
									if(isset($arrCrossGeneral['Normal'])&&$arrCrossGeneral['Normal']!=''){                         $Med_optimo       = $arrCrossGeneral['Normal'];              }else{$Med_optimo       = 0;}
									if(isset($arrCrossGeneral['Critico_inf'])&&$arrCrossGeneral['Critico_inf']!=''){               $Med_critico_inf  = $arrCrossGeneral['Critico_inf'];         }else{$Med_critico_inf  = 0;}
									if(isset($arrCrossGeneral['Critico_sup'])&&$arrCrossGeneral['Critico_sup']!=''){               $Med_critico_sup  = $arrCrossGeneral['Critico_sup'];         }else{$Med_critico_sup  = 0;}
									if(isset($arrCrossGeneral['Fuera_de_rango_inf'])&&$arrCrossGeneral['Fuera_de_rango_inf']!=''){ $Med_fuera_inf    = $arrCrossGeneral['Fuera_de_rango_inf'];  }else{$Med_fuera_inf    = 0;}
									if(isset($arrCrossGeneral['Fuera_de_rango_sup'])&&$arrCrossGeneral['Fuera_de_rango_sup']!=''){ $Med_fuera_sup    = $arrCrossGeneral['Fuera_de_rango_sup'];  }else{$Med_fuera_sup    = 0;}
									$Med_critico  = $Med_critico_inf + $Med_critico_sup;
									$Med_fuera    = $Med_fuera_inf + $Med_fuera_sup;

									/***************************************************************/
									//se imprimen datos
									echo '
									<tr>
										<td class="text-muted">
											<a href="#" class="iframe"><i class="fa fa-database color-blue" aria-hidden="true"></i> Optimo</a>
										</td>
										<td class="text-right color-blue" style="font-weight: 700;">'.$Med_optimo.'</td>
									</tr>

									<tr>
										<td class="text-muted">
											<a href="#" class="iframe"><i class="fa fa-database color-yellow-light" aria-hidden="true"></i> Critico</a>
										</td>
										<td class="text-right color-yellow-light" style="font-weight: 700;"><i class="fa fa-arrow-down" aria-hidden="true"></i> '.$Med_critico_inf.'/<i class="fa fa-arrow-up" aria-hidden="true"></i> '.$Med_critico_sup.'</td>
									</tr>
									<tr>
										<td class="text-muted">
											<a href="#" class="iframe"><i class="fa fa-database color-red" aria-hidden="true"></i> Fuera Rango</a>
										</td>
										<td class="text-right color-red" style="font-weight: 700;"><i class="fa fa-arrow-down" aria-hidden="true"></i> '.$Med_fuera_inf.'/<i class="fa fa-arrow-up" aria-hidden="true"></i> '.$Med_fuera_sup.'</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

							<script>

								google.charts.setOnLoadCallback(drawChart_anual);

								function drawChart_anual() {

									var data = google.visualization.arrayToDataTable([
										[\'Tipo\', \'Cantidad\'],
										[\'Temperaturas Optimas\', '.Cantidades_decimales_justos($Med_optimo).'],
										[\'Temperaturas Criticas\', '.Cantidades_decimales_justos($Med_critico).'],
										[\'Temperaturas Fuera de rango\', '.Cantidades_decimales_justos($Med_fuera).']
									]);

									var options = {
										title: \'Grafico Estado Temperaturas\',
										is3D: true,
										colors:[\'#FF5800\',\'#f0ad4e\',\'#5cb85c\']
									};

									var chart_anual = new google.visualization.PieChart(document.getElementById("chart_anual"));

									chart_anual.draw(data, options);

								}
							</script>
							<div id="chart_anual" style="height: 200px; width: 100%;"></div>

						</div>
					</div>
				</div>';
				/***************************************************************************/
				/***************************************************************************/
				echo '
				<div class="panel-heading">
					<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;"> Detalle Ultimos 12 Meses</span>
				</div>

				<div class="panel-body mnw700 of-a">';

					/**************************************************************/
					echo '
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h5 style="color: #666;font-weight: 600 !important;">Estado Temperaturas
								<small class="pull-right fw600 text-primary"></small>
							</h5>

							<table class="table mbn covertable">
								<tbody>';

									$mes_ini = mes_actual()+1;
									echo '<tr>';
									echo '<td class="text-muted">Dato</td>';
									for ($i = 1; $i <= 12; $i++) {
										if(isset($arrMes[$mes_ini]['Nombre'])&&$arrMes[$mes_ini]['Nombre']!=''){
											echo '<td class="text-muted">'.$arrMes[$mes_ini]['Nombre'].'</td>';
											$mes_ini++;
											if($mes_ini==13){$mes_ini = 1;}
										}
									}
									echo '</tr>';

									/***************************************************************/
									//se imprimen datos
									/**********************************/
									$mes_ini = mes_actual()+1;
									echo '<tr>';
									echo '<td class="text-muted"><a href="#" class="iframe"><i class="fa fa-database color-blue" aria-hidden="true"></i> Optimo</a></td>';
									for ($i = 1; $i <= 12; $i++) {
										if(isset($arrCrossGeneral[$mes_ini]['Normal'])&&$arrCrossGeneral[$mes_ini]['Normal']!=''){$Med_optimo = $arrCrossGeneral[$mes_ini]['Normal'];}else{$Med_optimo = 0;}
										echo '<td class="text-right color-blue" style="font-weight: 700;">'.$Med_optimo.'</td>';
										$mes_ini++;
										if($mes_ini==13){$mes_ini = 1;}
									}
									echo '</tr>';
									/**********************************/
									$mes_ini = mes_actual()+1;
									echo '<tr>';
									echo '<td class="text-muted"><a href="#" class="iframe"><i class="fa fa-database color-yellow-light" aria-hidden="true"></i> Critico</a></td>';
									for ($i = 1; $i <= 12; $i++) {
										if(isset($arrCrossGeneral[$mes_ini]['Critico_inf'])&&$arrCrossGeneral[$mes_ini]['Critico_inf']!=''){        $Med_critico_inf  = $arrCrossGeneral[$mes_ini]['Critico_inf'];         }else{$Med_critico_inf  = 0;}
										if(isset($arrCrossGeneral[$mes_ini]['Critico_sup'])&&$arrCrossGeneral[$mes_ini]['Critico_sup']!=''){        $Med_critico_sup  = $arrCrossGeneral[$mes_ini]['Critico_sup'];         }else{$Med_critico_sup  = 0;}
										echo '<td class="text-right color-yellow-light" style="font-weight: 700;"><i class="fa fa-arrow-down" aria-hidden="true"></i> '.$Med_critico_inf.'/<i class="fa fa-arrow-up" aria-hidden="true"></i> '.$Med_critico_sup.'</td>';
										$mes_ini++;
										if($mes_ini==13){$mes_ini = 1;}
									}
									echo '</tr>';
									/**********************************/
									$mes_ini = mes_actual()+1;
									echo '<tr>';
									echo '<td class="text-muted"><a href="#" class="iframe"><i class="fa fa-database color-red" aria-hidden="true"></i> Fuera Rango</a></td>';
									for ($i = 1; $i <= 12; $i++) {
										if(isset($arrCrossGeneral[$mes_ini]['Fuera_de_rango_inf'])&&$arrCrossGeneral[$mes_ini]['Fuera_de_rango_inf']!=''){ $Med_fuera_inf    = $arrCrossGeneral[$mes_ini]['Fuera_de_rango_inf'];  }else{$Med_fuera_inf    = 0;}
										if(isset($arrCrossGeneral[$mes_ini]['Fuera_de_rango_sup'])&&$arrCrossGeneral[$mes_ini]['Fuera_de_rango_sup']!=''){ $Med_fuera_sup    = $arrCrossGeneral[$mes_ini]['Fuera_de_rango_sup'];  }else{$Med_fuera_sup    = 0;}
										echo '<td class="text-right color-red" style="font-weight: 700;"><i class="fa fa-arrow-down" aria-hidden="true"></i> '.$Med_fuera_inf.'/<i class="fa fa-arrow-up" aria-hidden="true"></i> '.$Med_fuera_sup.'</td>';
										$mes_ini++;
										if($mes_ini==13){$mes_ini = 1;}
									}
									echo '</tr>';

									echo '
								</tbody>
							</table>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<script>

								google.charts.setOnLoadCallback(drawStacked);

								function drawStacked() {
									var data = new google.visualization.DataTable();
									data.addColumn(\'string\', \'Mes\');
									data.addColumn(\'number\', \'Optimo\');
									data.addColumn(\'number\', \'Critico\');
									data.addColumn(\'number\', \'Fuera Rango\');

									data.addRows([';
									/**********************************/
									$mes_ini = mes_actual()+1;
									for ($i = 1; $i <= 12; $i++) {
										if(isset($arrMes[$mes_ini]['Nombre'])&&$arrMes[$mes_ini]['Nombre']!=''){
											if(isset($arrCrossGeneral[$mes_ini]['Normal'])&&$arrCrossGeneral[$mes_ini]['Normal']!=''){                  $Med_optimo       = $arrCrossGeneral[$mes_ini]['Normal'];              }else{$Med_optimo       = 0;}
											if(isset($arrCrossGeneral[$mes_ini]['Critico_inf'])&&$arrCrossGeneral[$mes_ini]['Critico_inf']!=''){        $Med_critico_inf  = $arrCrossGeneral[$mes_ini]['Critico_inf'];         }else{$Med_critico_inf  = 0;}
											if(isset($arrCrossGeneral[$mes_ini]['Critico_sup'])&&$arrCrossGeneral[$mes_ini]['Critico_sup']!=''){        $Med_critico_sup  = $arrCrossGeneral[$mes_ini]['Critico_sup'];         }else{$Med_critico_sup  = 0;}
											if(isset($arrCrossGeneral[$mes_ini]['Fuera_de_rango_inf'])&&$arrCrossGeneral[$mes_ini]['Fuera_de_rango_inf']!=''){ $Med_fuera_inf    = $arrCrossGeneral[$mes_ini]['Fuera_de_rango_inf'];  }else{$Med_fuera_inf    = 0;}
											if(isset($arrCrossGeneral[$mes_ini]['Fuera_de_rango_sup'])&&$arrCrossGeneral[$mes_ini]['Fuera_de_rango_sup']!=''){ $Med_fuera_sup    = $arrCrossGeneral[$mes_ini]['Fuera_de_rango_sup'];  }else{$Med_fuera_sup    = 0;}
											$Med_critico  = $Med_critico_inf + $Med_critico_sup;
											$Med_fuera    = $Med_fuera_inf + $Med_fuera_sup;
											echo '[\''.$arrMes[$mes_ini]['Nombre'].'\', '.$Med_optimo.', '.$Med_critico.', '.$Med_fuera.'],';

											$mes_ini++;
											if($mes_ini==13){$mes_ini = 1;}
										}
									}
									echo '
									]);

									var options = {
										title: \'Grafico Detalle Ultimos 12 Meses\',
										isStacked: true,
										hAxis: {
											title: \'Meses\',
										},
										vAxis: {
											title: \'Cantidad\',
											minValue: 0
										},
										colors:[\'#3399cc\',\'#f5b75f\',\'#ed7a53\']
									};

									var chart = new google.visualization.ColumnChart(document.getElementById(\'chart_div\'));
									chart.draw(data, options);
								}

							</script>
							<div id="chart_div" style="height: 300px; width: 100%;"></div>

						</div>
					</div>
				</div>';

				/***************************************************************************/
				/***************************************************************************/
				echo '
				<div class="panel-heading">
					<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;"> Mercados</span>
				</div>

				<div class="panel-body mnw700 of-a">';

					/**************************************************************/
					echo '
					<div class="row">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<h5 style="color: #666;font-weight: 600 !important;">Mercados destinos
								<small class="pull-right fw600 text-primary"></small>
							</h5>

							<table class="table mbn covertable">
								<tbody>';

									foreach ($arrMercados as $merc) {

										if(isset($arrCrossGeneral[$merc['idMercado']]['Cantidad'])&&$arrCrossGeneral[$merc['idMercado']]['Cantidad']!=''){
											//se imprimen datos
											echo '
											<tr>
												<td class="text-muted">
													<a href="#" class="iframe"><i class="fa fa-database color-blue" aria-hidden="true"></i> '.$merc['Nombre'].'</a>
												</td>
												<td class="text-right color-blue" style="font-weight: 700;">'.$arrCrossGeneral[$merc['idMercado']]['Cantidad'].'</td>
											</tr>';
										}
									}

									echo '
								</tbody>
							</table>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

							<script>

								google.charts.setOnLoadCallback(drawChart_anual);

								function drawChart_anual() {

									var data = google.visualization.arrayToDataTable([
										[\'Tipo\', \'Cantidad\'],';
										foreach ($arrMercados as $merc) {
											if(isset($arrCrossGeneral[$merc['idMercado']]['Cantidad'])&&$arrCrossGeneral[$merc['idMercado']]['Cantidad']!=''){
												echo '[\''.$merc['Nombre'].'\', '.Cantidades_decimales_justos($arrCrossGeneral[$merc['idMercado']]['Cantidad']).'],';
											}
										}

										echo '
									]);

									var options = {
										title: \'Grafico por Mercado\',
										is3D: true
									};

									var chart_anual = new google.visualization.PieChart(document.getElementById("chart_anual"));

									chart_anual.draw(data, options);

								}
							</script>
							<div id="chart_anual" style="height: 200px; width: 100%;"></div>

						</div>
					</div>
				</div>';

		echo '
			</div>
		</div>
	</div>';

} ?>
