<div class="tab-pane fade" id="Menu_tab_4">

	<style>
	.bs-callout {margin: 2px 0;}
	.bs-callout .rounded-circle{border-radius: 50% !important;margin-left:2px;border: 1px solid #7F7F7F;}
	</style>

	<?php
	//Agrego el boton crear solo si se tiene acceso a la transaccion o es superadministrador
	if($prm_x[1]['Val']=='1' OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1) {
		//bloque para crear nuevo
		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-top:15px;">';
			echo '<a href="'.$prm_x[1]['Link'].'&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Tarea Pendiente</a>';
		echo '</div>';
		echo '<div class="clearfix"></div>';
		//variable permiso editar
		$frm_Edit = '&editForm=true';
	}else{
		$frm_Edit = '';
	} ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<h5>Tareas Pendientes</h5>
			</header>
			<div class="body">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">

						<h5 style="color: #666;font-weight: 600 !important;">Tareas
							<small class="pull-right fw600 text-primary"></small>
						</h5>
															
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
							</tbody>
						</table>

					</div>
					<div class="col-xs-12 col-sm-6 col-md-9 col-lg-9">
						<div class="row">
							
							
							<?php for ($j = 1; $j <= 2; $j++) { ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									<h5 style="color: #666;font-weight: 600 !important;"><?php echo $Estado[$j]['Nombre']; ?></h5>
									<?php
									//recorro
									for ($i = 4; $i > 0; $i--) {
										/***********************************************/
										//Separador
										echo '
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<span class="'.$Prioridad[$i]['Label'].'">'.$Prioridad[$i]['Nombre'].'</span>
										</div>';
										/***********************************************/
										//Ficha
										if(isset($arrTareasTemp[$j][$i])){
											foreach ($arrTareasTemp[$j][$i] as $key =>$tarea) {
												//Calculo porcentaje de avance de la tarea
												$PorAvance = porcentaje($tarea['Terminada']/$tarea['Pendiente']);
												
												echo '
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="bs-callout '.$Prioridad[$i]['Color'].'" >
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="row">
																<h5 style="color: #666;font-weight: 600 !important;">'.$tarea['Tipo'].' ('.$PorAvance.')
																	<small class="pull-right fw600 text-primary">
																		<a href="view_tarea_pendiente.php?view='.simpleEncode($tarea['idTareas'], fecha_actual()).$frm_Edit.'" title="Ver Tarea" class="iframe btn btn-primary btn-sm tooltip" style="position: initial;"><i class="fa fa-list" aria-hidden="true"></i></a>
																	</small>
																</h5>
															</div>
															<div class="row">
																<p style="white-space: normal;">'.$tarea['Nombre'].'</p>
															</div>
														</div>
														<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
															<div class="row">
																<i class="fa fa-clock-o"></i> '.fecha_estandar($tarea['f_creacion']).'
															</div>
														</div>
														<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
															<div class="row">
																<div class="profile-image pull-right">';
																	//recorro los responsables
																	if(isset($arrRespTemp[$tarea['idTareas']])){
																		foreach ($arrRespTemp[$tarea['idTareas']] as $key =>$resp) {
																			//verifico si existe imagen
																			if(isset($resp['UsuarioIMG'])&&$resp['UsuarioIMG']!=''){
																				$IMG_Resources = 'upload/'.$resp['UsuarioIMG'];
																				//verifico si existe
																				if (file_exists($IMG_Resources)){
																					//nada
																				//si no existe pongo por defecto
																				}else{
																					$IMG_Resources = DB_SITE_REPO.'/LIB_assets/img/usr.png';
																				}
																			}else{
																				$IMG_Resources = DB_SITE_REPO.'/LIB_assets/img/usr.png';
																			}
																			//imprimo
																			echo '<img class="rounded-circle tooltip pull-right" style="position: initial;" src="'.$IMG_Resources.'" title="'.$resp['UsuarioNombre'].'" width="30">';
																			
																			
																		}
																	}
																echo '
																</div>
															</div>
														</div>
														<div class="clearfix"></div>
													</div>
												</div>';
											}
										}
									}
									?>
								</div>
							<?php } ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
