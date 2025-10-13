<?php
/**************************************************************************/
echo '
<div class="tab-pane fade active in" id="Menu_tab_1">

	<div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 admin-grid">';

			//Si existe alguna mantencion se muestra por pantalla
			if(isset($Mantenciones['Fecha'])&&(strtotime($Mantenciones['Fecha'])>=strtotime(fecha_actual()))){
				echo '
				<div class="col-xs-12" style="margin-top:5px;">';
					$Alert_Text = 'Mantencion programada para el '.fecha_estandar($Mantenciones['Fecha']).' desde '.$Mantenciones['Hora_ini'].' hasta las '.$Mantenciones['Hora_fin'].' hrs';
					alert_post_data(2,1,1,0, $Alert_Text);
				echo '
				</div>
				<div class="clearfix" ></div>';
			}

			echo '
			<div class="sort-disable">
				<div class="panel-heading">
					<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;">Resumen</span>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">';
						/**********************************************************************************/
						/**********************************************************************************/
						//Lado izquierdo
						echo '
						<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
							<div class="row">
								<div class="panel-body mnw700 of-a">
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											<h5 style="color: #666;font-weight: 600 !important;">Notificaciones
												<small class="pull-right fw600 text-primary"></small>
											</h5>

											<table class="table mbn covertable">
												<tbody>';
												/****************************************************/
												//Notificaciones
												if($n_permisos['idOpcionesGen_1']=='1' OR $idTipoUsuario==1) {
													$temp = '';
													if(isset($subconsulta['Notificacion'])&&$subconsulta['Notificacion']!=0){$temp = 'faa-horizontal animated';}
													echo '
													<tr>
														<td class="text-muted">
															<a href="principal_notificaciones_alt.php?pagina=1" class="iframe"><i class="fa fa-commenting-o '.$temp.' color-gray" aria-hidden="true"></i> Notificaciones del sistema</a>
														</td>
														<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['Notificacion'].'</td>
													</tr>';
												}
												/****************************************************/
												//Eventos del calendario
												if($n_permisos['idOpcionesGen_1']=='1' OR $idTipoUsuario==1) {
													echo '
													<tr>
														<td class="text-muted">
															<a href="principal_calendario_alt.php?pagina=1" class="iframe"><i class="fa fa-calendar color-blue" aria-hidden="true"></i> Agenda General</a>
														</td>
														<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CuentaEventos'].'</td>
													</tr>';
												}

												//Reviso el tipo de usuario o si estan permitidas las transacciones
												if($n_permisos['idOpcionesGen_2']=='1' OR $idTipoUsuario==1) {
													/****************************************************/
													//Cargas por vencer
													if(isset($prm_x[12])&&$prm_x[12]=='1') {
														echo '
														<tr>
															<td class="text-muted">
																<a href="principal_cargas_alt.php?pagina=1" class="iframe"><i class="fa fa-usd color-green" aria-hidden="true"></i> Cargas por Vencer</a>
															</td>
															<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CuentaRecargas'].'</td>
														</tr>';
													}

													/****************************************************/
													//Solicitudes de materiales sin OC asignada
													if(isset($prm_x[13])&&$prm_x[13]=='1') {
														//Solicitudes
														$totalSol = $subconsulta['CuentaSolProd'] + $subconsulta['CuentaSolIns'] + $subconsulta['CuentaSolArr'] + $subconsulta['CuentaSolServ'] + $subconsulta['CuentaSolOtro'];					

														echo '
														<tr>
															<td class="text-muted">
																<a target="_blank" rel="noopener noreferrer" href="ocompra_generacion.php?idSistema=&submit=Filtrar" ><i class="fa fa-cube color-yellow" aria-hidden="true"></i> Solicitudes sin OC</a>
															</td>
															<td class="text-right color-red" style="font-weight: 700;">'.$totalSol.'</td>
														</tr>';
													}

													/****************************************************/
													//OC sin aprobar
													if(isset($prm_x[14])&&$prm_x[14]=='1') {
														echo '
														<tr>
															<td class="text-muted">
																<a target="_blank" rel="noopener noreferrer" href="ocompra_listado_sin_aprobar.php?pagina=1" ><i class="fa fa-database color-red" aria-hidden="true"></i> OC sin Aprobar</a>
															</td>
															<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CuentaOC'].'</td>
														</tr>';
													}

													/****************************************************/
													//Acceso a las OT Maquinas de la semana
													if(isset($prm_x[10],$prm_x[11])&&$prm_x[10]!=''&&$prm_x[11]!=''){
														$OT_Semana = $prm_x[10] + $prm_x[11];
														if($OT_Semana!=0) {
															echo '
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1&estado=1" class="iframe"><i class="fa fa-database color-blue" aria-hidden="true"></i> OT Maquinas para la Semana</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountOTSemana'].'</td>
															</tr>
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_alt.php?pagina=1&estado=2" class="iframe"><i class="fa fa-database color-red" aria-hidden="true"></i> OT Maquinas no Cumplidas</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountOTRetrasada'].'</td>
															</tr>';
														}
													}

													/****************************************************/
													//Acceso a las OT Tareas de la semana
													if(isset($prm_x[44],$prm_x[45],$prm_x[46],$prm_x[47],$prm_x[48],$prm_x[49])&&$prm_x[44]!=''&&$prm_x[45]!=''&&$prm_x[46]!=''&&$prm_x[47]!=''&&$prm_x[48]!=''&&$prm_x[49]!=''){
														$OT_Semana = $prm_x[44] + $prm_x[45] + $prm_x[46] + $prm_x[47] + $prm_x[48] + $prm_x[49];
														if($OT_Semana!=0) {
															echo '
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_tareas_alt.php?pagina=1&estado=1" class="iframe"><i class="fa fa-database color-blue" aria-hidden="true"></i> OT Tareas para la Semana</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountOTSemanaTarea'].'</td>
															</tr>
															<tr>
																<td class="text-muted">
																	<a href="principal_ot_semana_tareas_alt.php?pagina=1&estado=2" class="iframe"><i class="fa fa-database color-red" aria-hidden="true"></i> OT Tareas no Cumplidas</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountOTRetrasadaTarea'].'</td>
															</tr>';
														}
													}

													/****************************************************/
													//Acceso a las OT Tareas de la semana
													if(isset($prm_x[51],$prm_x[52],$prm_x[53])&&$prm_x[51]!=''&&$prm_x[52]!=''&&$prm_x[53]!=''){
														$Tickets_temp = $prm_x[51] + $prm_x[52] + $prm_x[53];
														if($Tickets_temp!=0) {
															echo '
															<tr>
																<td class="text-muted">
																	<a href="gestion_tickets_cerrar.php?pagina=1"><i class="fa fa-database color-blue" aria-hidden="true"></i> Tickets Pendientes de Cierre</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountTickets'].'</td>
															</tr>';
														}
													}

													/****************************************************/
													//Previred Pendientes
													if(isset($prm_x[54])&&$prm_x[54]!=''){
														$Previred = $prm_x[54];
														if($Previred!=0) {
															echo '
															<tr>
																<td class="text-muted">
																	<a href="clientes_contab_previred.php?pagina=1&idEstado=1"><i class="fa fa-usd color-green" aria-hidden="true"></i> Pagos Previred Pendientes</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountPreviredPendiente'].'</td>
															</tr>';
														}
													}

												}

													echo '
												</tbody>
											</table>
										</div>';

										/**************************************************************/
										if(isset($prm_x[15],$prm_x[16],$prm_x[17],$prm_x[18],$prm_x[19],$prm_x[20],$prm_x[21],$prm_x[22],$prm_x[23],$prm_x[24],$prm_x[25],$prm_x[26])&&$prm_x[15]!=''&&$prm_x[16]!=''&&$prm_x[17]!=''&&$prm_x[18]!=''&&$prm_x[19]!=''&&$prm_x[20]!=''&&$prm_x[21]!=''&&$prm_x[22]!=''&&$prm_x[23]!=''&&$prm_x[24]!=''&&$prm_x[25]!=''&&$prm_x[26]!=''){
											$PermFactCompra    = $prm_x[15] + $prm_x[16] + $prm_x[17] + $prm_x[18];
											$PermFactVenta     = $prm_x[19] + $prm_x[20] + $prm_x[21] + $prm_x[22];
											$PermChequesPagar  = $prm_x[23] + $prm_x[24];
											$PermChequesCobrar = $prm_x[25] + $prm_x[26];
											//Verifico si tiene acceso a compras o ventas
											if(($PermFactCompra+$PermFactVenta+$PermChequesPagar+$PermChequesCobrar)!=0) {
												echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
													/****************************************/
													//Se verifica si tiene acceso en las compras
													if(($PermFactCompra+$PermChequesPagar)!=0) {
														echo '
														<h5 style="color: #666;font-weight: 600 !important;">Compras
															<small class="pull-right fw600 text-primary"></small>
														</h5>
														<table class="table mbn covertable">
															<tbody>';
															if($n_permisos['idOpcionesGen_2']=='1' OR $idTipoUsuario==1) {
																//Facturas por pagar
																if($PermFactCompra!=0 OR $idTipoUsuario==1){
																	$totalFactCompra       = $subconsulta['CountFactArriendo'] + $subconsulta['CountFactInsumo'] + $subconsulta['CountFactProducto'] + $subconsulta['CountFactServicio'];					
																	$totalFactCompra_retr  = $subconsulta['CountFactArriendo_retr'] + $subconsulta['CountFactInsumo_retr'] + $subconsulta['CountFactProducto_retr'] + $subconsulta['CountFactServicio_retr'];					
																}else{
																	$totalFactCompra       = 0;
																	$totalFactCompra_retr  = 0;
																}
																//Verifico permisos
																if($PermFactCompra!=0) {
																	//verifico si tiene atrasadas de antes de la semana actual
																	if($totalFactCompra_retr!=0) {
																		echo '
																		<tr>
																			<td class="text-muted">
																				<a href="principal_facturas_alt.php?pagina=1&idTipo=1" class="iframe color-red"><i class="fa fa-cc-paypal faa-horizontal animated color-red" aria-hidden="true"></i> Facturas atrasadas</a>
																			</td>
																			<td class="text-right color-red" style="font-weight: 700;">'.$totalFactCompra_retr.'</td>
																		</tr>';
																	}else{
																		echo '
																		<tr>
																			<td class="text-muted">
																				<a href="principal_facturas_alt.php?pagina=1&idTipo=1" class="iframe"><i class="fa fa-cc-paypal color-green-dark" aria-hidden="true"></i> Facturas x pagar</a>
																			</td>
																			<td class="text-right color-red" style="font-weight: 700;">'.$totalFactCompra.'</td>
																		</tr>';
																	}
																}

																//Devolucion Arriendos
																if($prm_x[15]=='1') {
																	echo '
																	<tr>
																		<td class="text-muted">
																			<a href="principal_arriendos_alt.php?pagina=1&idTipo=1" class="iframe" ><i class="fa fa-calendar-o color-blue-dark" aria-hidden="true"></i> Devolucion Arriendos</a>
																		</td>
																		<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountArriendoIn'].'</td>
																	</tr>';
																}

																//Documentos x Pagar
																if($PermChequesPagar!=0) {
																	echo '
																	<tr>
																		<td class="text-muted">
																			<a href="principal_cheques_pagar_alt.php?pagina=1" class="iframe" ><i class="fa fa-credit-card color-blue" aria-hidden="true"></i> Documentos x Pagar</a>
																		</td>
																		<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountChequePago'].'</td>
																	</tr>';
																}
															}
															echo '
															</tbody>
														</table>';
													}

													/****************************************/
													//Se verifica si tiene acceso en las ventas
													if(($PermFactVenta+$PermChequesCobrar)!=0) {
														echo '
														<h5 style="color: #666;font-weight: 600 !important;">Ventas
															<small class="pull-right fw600 text-primary"></small>
														</h5>
														<table class="table mbn covertable">
															<tbody>';
																if($n_permisos['idOpcionesGen_2']=='1' OR $idTipoUsuario==1) {
																	if($PermFactVenta!=0) {
																		$totalFactVenta       = $subconsulta['CountFactArriendoVent'] + $subconsulta['CountFactInsumoVent'] + $subconsulta['CountFactProductoVent'] + $subconsulta['CountFactServicioVent'];					
																		echo '
																		<tr>
																			<td class="text-muted">
																				<a href="principal_facturas_alt.php?pagina=1&idTipo=2" class="iframe"><i class="fa fa-cc-paypal color-green-dark" aria-hidden="true"></i> Facturas x Cobrar</a>
																			</td>
																			<td class="text-right color-red" style="font-weight: 700;">'.$totalFactVenta.'</td>
																		</tr>';
																	}

																	if($prm_x[19]=='1') {
																		echo '
																		<tr>
																			<td class="text-muted">
																				<a href="principal_arriendos_alt.php?pagina=1&idTipo=2" class="iframe" ><i class="fa fa-calendar-o color-blue-dark" aria-hidden="true"></i> Devolucion Arriendos</a>
																			</td>
																			<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountArriendoOut'].'</td>
																		</tr>';
																	}

																	if($PermChequesCobrar!=0) {
																		echo '
																		<tr>
																			<td class="text-muted">
																				<a href="principal_cheques_cobrar_alt.php?pagina=1" class="iframe" ><i class="fa fa-credit-card color-blue" aria-hidden="true"></i> Documentos x Cobrar</a>
																			</td>
																			<td class="text-right color-red" style="font-weight: 700;">'.$subconsulta['CountChequeCobro'].'</td>
																		</tr>';
																	}
																}
																echo '
															</tbody>
														</table>';
													}
												echo '</div>';
											}
										}

										/**************************************************************/
										if(isset($prm_x[6])&&$prm_x[6]!=''){
											$PermAlertas    = $prm_x[6];
											//Verifico si tiene acceso a las alertas
											if($PermAlertas!=0) {
												//verifico si existen alertas
												$n_alert = $subconsulta['CountAlertaNivel_1']+$subconsulta['CountAlertaNivel_2']+$subconsulta['CountAlertaNivel_3'];
												if($n_alert!=0){
													echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';

															echo '
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
															</table>';
													echo '</div>';
												}
											}
										}

										/**************************************************************/
										if(isset($prm_x[27],$prm_x[28],$prm_x[29],$prm_x[30],$prm_x[31])&&$prm_x[27]!=''&&$prm_x[28]!=''&&$prm_x[29]!=''&&$prm_x[30]!=''&&$prm_x[31]!=''){
											$Cajas    = $prm_x[27] + $prm_x[28] + $prm_x[29] + $prm_x[30] + $prm_x[31];
											//Verifico si tiene acceso a las alertas
											if($Cajas!=0) {

												//Verifico sistemas
												$SIS_where = "caja_chica_listado.idCajaChica!=0";
												$SIS_where.= " AND caja_chica_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
												//Verifico el tipo de usuario que esta ingresando
												if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
													$SIS_where .= " AND usuarios_cajas_chicas.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
												}

												//Se traen los totales de la caja chica
												$SIS_query = '
												caja_chica_listado.idCajaChica AS ID,
												caja_chica_listado.Nombre,
												caja_chica_listado.MontoActual,
												(SELECT SUM(Valor) FROM `caja_chica_facturacion` WHERE idCajaChica=ID AND idEstado=1 LIMIT 1 )AS Egreso,
												(SELECT SUM(ValorDevolucion) FROM `caja_chica_facturacion` WHERE idCajaChica=ID AND idEstado=1 LIMIT 1 )AS Devolucion';
												$SIS_join  = '
												LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema            = caja_chica_listado.idSistema
												INNER JOIN `usuarios_cajas_chicas`  ON usuarios_cajas_chicas.idCajaChica  = caja_chica_listado.idCajaChica';
												$SIS_order = 0;
												$arrCajas = array();
												$arrCajas = db_select_array (false, $SIS_query, 'caja_chica_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCajas');

												echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';

													echo '
													<h5 style="color: #666;font-weight: 600 !important;">Caja Chica
														<small class="pull-right fw600 text-primary"></small>
													</h5>
													<table class="table mbn covertable">
														<tbody>';

														if($n_permisos['idOpcionesGen_2']=='1' OR $idTipoUsuario==1) {

															foreach ($arrCajas as $caja) {
																//Compruebo si esta cuadrada
																$cuadra = $caja['Egreso'] - $caja['Devolucion'];
																if($cuadra!=0){
																	$f_color = 'color-red';
																	$d_extra = ' (-'.$cuadra.')';
																}else{
																	$f_color = 'color-blue';
																	$d_extra = '';
																}
																echo '
																<tr>
																	<td class="text-muted">
																		<a href="principal_cajas_alt.php?idCajaChica='.$caja['ID'].'" class="iframe" ><i class="fa fa-usd '.$f_color.'" aria-hidden="true"></i> '.$caja['Nombre'].'</a>
																	</td>
																	<td class="text-right '.$f_color.'" style="font-weight: 700;">'.$caja['MontoActual'].$d_extra.'</td>
																</tr>';
															}

														}
														echo '
														</tbody>
													</table>';
												echo '</div>';
											}
										}

									echo '
									</div>
								</div>
							</div>';

							/******************************************************/
							//Recomendados
							echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-buttons block">';
								echo '<div class="row">';
									$CContactos = 0;
									$CProgramas = 0;
									if(isset($subconsulta['CuentaContactos'])&&$subconsulta['CuentaContactos']!=''){$CContactos = $subconsulta['CuentaContactos'];}
									if(isset($subconsulta['CuentaProgramas'])&&$subconsulta['CuentaProgramas']!=''){$CProgramas = $subconsulta['CuentaProgramas'];}
									echo '<a href="principal_ayuda.php?pagina=1"              class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-blue tooltip"    title="Ver Archivos de ayuda">        <i class="fa fa-question" aria-hidden="true"></i>     <span>Archivos de ayuda</span>        </a>';
									echo '<a href="principal_procedimientos.php?pagina=1"     class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-green tooltip"   title="Ver Procedimientos">           <i class="fa fa-file-word-o" aria-hidden="true"></i>  <span>Procedimientos</span>           </a>';
									echo '<a href="principal_agenda_telefonica.php?pagina=1"  class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-yellow tooltip"  title="Ver Contactos">                <i class="fa fa-phone" aria-hidden="true"></i>        <span>Contactos</span>                <strong class="label label-warning">'.$CContactos.'</strong></a>';
									echo '<a href="principal_software.php?pagina=1"           class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-red tooltip"     title="Ver Programas Recomendados">   <i class="fa fa-desktop" aria-hidden="true"></i>      <span>Programas Recomendados</span>   <strong class="label label-info">'.$CProgramas.'</strong></a>';
								echo '</div>';
							echo '</div>';

							/******************************************************/
							//Widget Sociales
							if(isset($_SESSION['usuario']['basic_data']['Social_idUso'])&&$_SESSION['usuario']['basic_data']['Social_idUso']==1){
								echo widget_Social($_SESSION['usuario']['basic_data']['Social_facebook'],
													$_SESSION['usuario']['basic_data']['Social_twitter'],
													$_SESSION['usuario']['basic_data']['Social_instagram'],
													$_SESSION['usuario']['basic_data']['Social_linkedin'],
													$_SESSION['usuario']['basic_data']['Social_rss'],
													$_SESSION['usuario']['basic_data']['Social_youtube'],
													$_SESSION['usuario']['basic_data']['Social_tumblr']
													);

							}

						echo '</div>';
						/**********************************************************************************/
						/**********************************************************************************/
						//Lado Derecho
						echo '
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
							<div class="row">';
								/*************************************************************/
								//meteo
								if(isset($_SESSION['usuario']['basic_data']['Pronostico'])&&$_SESSION['usuario']['basic_data']['Pronostico']!=''){
									echo '
									<a class="weatherwidget-io" href="'.$_SESSION['usuario']['basic_data']['Pronostico'].'" data-label_1="'.$_SESSION['usuario']['basic_data']['Region'].'" data-label_2="Pronostico" data-theme="pure" >'.$_SESSION['usuario']['basic_data']['Region'].'</a>
									<script>
									!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\'https://weatherwidget.io/js/widget.min.js\';fjs.parentNode.insertBefore(js,fjs);}}(document,\'script\',\'weatherwidget-io-js\');
									</script>';
								}

							echo '
							</div>
						</div>';

						/**********************************************************************************/
						/**********************************************************************************/
						//Lado inferior
						echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
							echo '<div class="row">';

								/*************************************************************/
								//Noticias
								//se verifica si el widget social no esta activo
								if($_SESSION['usuario']['basic_data']['Social_rss']==''&&$_SESSION['usuario']['basic_data']['Social_idUso']!=1){
									echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
										echo '<div class="box">';
											echo '<header>';
												echo '<div class="icons"><i class="fa fa-newspaper-o" aria-hidden="true"></i></div><h5>Últimas noticias</h5>';
											echo '</header>';
											echo '<div class="">';
												echo widget_feed('https://www.elmostrador.cl/destacado/feed/', 10, 500, 'true', 'true');
											echo '</div> ';
										echo '</div>';
									echo '</div>';
								}

								/*************************************************************/
								//Widget de la radio
								echo '<style>#main-wrapper {padding: 0!important;}</style>';
								echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
									echo '<div class="box">';
										echo '<header>';
											echo '<div class="icons"><i class="fa fa-soundcloud" aria-hidden="true"></i></div><h5>Radio</h5>';
										echo '</header>';
										echo '<div class="">';
											echo widget_radio_player();
										echo '</div> ';
									echo '</div>';
								echo '</div>';

								/*************************************************************/
								//Sismos
								/*echo '<div class="clearfix" ></div>';
								echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
								echo widget_sismologia();
								echo '</div>';
								/*************************************************************/
								//Feriados
								/*echo '<div class="clearfix" ></div>';
								echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
								echo widget_feriados();
								echo '</div>';*/
								/*************************************************************/
							echo '</div>';
						echo '</div>';

						echo '
					</div>
				</div>

			</div>
		</div>
	</div>';

echo '</div>';


?>
