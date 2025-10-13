
<div class="tab-pane fade active in" id="Menu_tab_1">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 admin-grid">
		<div class="sort-disable">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<div class="row">
							<div class="panel-body mnw700 of-a">
								<div class="row">

									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
										<h5 style="color: #666;font-weight: 600 !important;">Operacional</h5>
										<table class="table mbn covertable">
											<tbody>
												<tr>
													<td class="text-muted">
														<a href="" class=""><i class="fa fa-exclamation-triangle color-yellow" aria-hidden="true"></i> Con Alertas</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;"><span id="AlertNumber_2">0</span></td>
												</tr>
												<tr>
													<td class="text-muted">
														<a href="" class=""><i class="fa fa-chain-broken color-red" aria-hidden="true"></i> Fuera de Linea</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;"><span id="FueraNumber_2">0</span></td>
												</tr>
												<tr>
													<td class="text-muted">
														<a href="" class=""><i class="fa fa-check color-green" aria-hidden="true"></i> En Linea</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;"><span id="OnlineNumber_2">0</span></td>
												</tr>
												<tr>
													<td class="text-muted">
														<a href="" class=""><i class="fa fa-cog color-gray" aria-hidden="true"></i> Total </a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;"><span id="TotalNumber_2">0</span></td>
												</tr>
											</tbody>
										</table>
									</div>

									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
										<h5 style="color: #666;font-weight: 600 !important;">Calendario</h5>
										<table class="table mbn covertable">
											<tbody>
												<tr>
													<td class="text-muted">
														<a href="" class=""><i class="fa fa-calendar color-green" aria-hidden="true"></i> Eventos Comunes</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;"><?php echo $CEvComunes; ?></td>
												</tr>
												<tr>
													<td class="text-muted">
														<a href="" class=""><i class="fa fa-calendar color-gray" aria-hidden="true"></i> Eventos Propios</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;"><?php echo $CEvPropios; ?></td>
												</tr>
											</tbody>
										</table>
									</div>

									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
										<h5 style="color: #666;font-weight: 600 !important;">Tareas Pendientes</h5>
										<table class="table mbn covertable">
											<tbody>
												<?php foreach ($arrTareas as $tarea) {
									//solo si se tiene acceso a la transaccion o es superadministrador
									if($prm_x[1]['Val']=='1' OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1) {
										$Link = $prm_x[1]['Link'].'&idEstado='.$tarea['idEstado'].'&filtro_form=Filtrar';
									}else{
										$Link = '';
									}
									
									?>
									<tr>
										<td class="text-muted"><a target="_blank" rel="noopener noreferrer" href="<?php echo $Link; ?>"><i class="<?php echo $Icon[$tarea['idEstado']].' '.$Color[$tarea['idEstado']]; ?>" aria-hidden="true"></i> <?php echo $tarea['Estado']; ?></a></td>
										<td class="text-right color-red" style="font-weight: 700;"><?php echo $tarea['Cuenta']; ?></td>
									</tr>
								<?php } ?>
								
								
												<tr>
													<td class="text-muted">
														<a href="principal_notificaciones_alt.php?pagina=1" class="iframe cboxElement"><i class="fa fa-commenting-o color-gray" aria-hidden="true"></i> Notificaciones del sistema </a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">0</td>
												</tr>
											</tbody>
										</table>
									</div>
									
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-buttons block">
							<div class="row">
								<a href="principal_ayuda.php?pagina=1" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-blue tooltip tooltipstered">
									<i class="fa fa-question" aria-hidden="true"></i>
									<span>Archivos de ayuda</span>
								</a>
								<a href="principal_procedimientos.php?pagina=1" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-green tooltip tooltipstered">
									<i class="fa fa-file-word-o" aria-hidden="true"></i>
									<span>Procedimientos</span>
								</a>
								<a href="principal_agenda_telefonica.php?pagina=1" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-yellow tooltip tooltipstered">
									<i class="fa fa-phone" aria-hidden="true"></i>
									<span>Contactos</span>
									<strong class="label label-warning"><?php echo $CContactos; ?></strong>
								</a>
								<a href="principal_software.php?pagina=1" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 color-red tooltip tooltipstered">
									<i class="fa fa-desktop" aria-hidden="true"></i>
									<span>Programas Recomendados</span>
									<strong class="label label-info"><?php echo $CProgramas; ?></strong>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
