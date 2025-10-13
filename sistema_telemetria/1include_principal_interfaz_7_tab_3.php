<div class="tab-pane fade" id="Menu_tab_3">

	<div style="margin-top:10px;">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<a target="_blank" rel="noopener noreferrer" href="<?php echo 'principal_calendario.php?Mes='.$Mes.'&Ano='.$Ano.'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Evento</a>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<h5>Calendario General</h5>
				</header>

				<div id="calendar_content" class="body">
					<div id="calendar" class="fc fc-ltr">

						<table class="fc-header" style="width:100%">
							<tbody>
								<tr>
									<td class="fc-header-left"></td>
									<td class="fc-header-center"><span class="fc-header-title"><h2><?php echo numero_a_mes($Mes)." ".$Ano?></h2></span></td>
									<td class="fc-header-right"></td>
								</tr>
							</tbody>
						</table>

						<div class="fc-content" style="position: relative;margin-left: -10px;margin-right: -10px;">
							<div class="fc-view fc-view-Mes fc-grid" style="position:relative" unselectable="on">

								<table class="fc-border-separate correct_border" style="width:100%" cellspacing="0">
									<thead>
										<tr class="fc-first fc-last">
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Lunes</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Martes</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Miercoles</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Jueves</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Viernes</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Sabado</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Domingo</th>
										</tr>
									</thead>
									<tbody>
										<tr class="fc-week">
											<?php
											$last_cell = $diaSemana + $ultimoDiaMes;
											// hacemos un bucle hasta 42, que es el máximo de valores que puede
											// haber... 6 columnas de 7 dias
											for($i=1;$i<=42;$i++){
												// determinamos en que dia empieza
												if($i==$diaSemana){
													$Dia=1;
												}
												// celca vacia
												if($i<$diaSemana || $i>=$last_cell){
													echo "<td class='fc-Dia fc-wed fc-widget-content fc-other-Mes fc-future fc-state-none'> </td>";
												// mostramos el dia
												}else{ ?>
													<td class="fc-Dia fc-sun fc-widget-content fc-past fc-first <?php if($Dia==$diaActual){ echo 'fc-state-highlight';} ?>">
														<div class="calendar_min">
															<div class="fc-Dia-number"><?php echo $Dia; ?></div>
															<div class="fc-Dia-content">
																<?php foreach ($arrEventos as $evento) {
																	if ($evento['Dia']==$Dia) {
																		$ver = 'principal_calendario.php?Mes='.$Mes.'&Ano='.$Ano.'&view='.$evento['idCalendario'];
																		if ($evento['idUsuario']==9999){
																			echo '<a class="event_calendar evcal_color2 word_break" target="_blank" rel="noopener noreferrer" href="'.$ver.'">'.cortar('Administrador : '.$evento['Titulo'], 20).'</a>';
																		}else{
																			echo '<a class="event_calendar evcal_color1 word_break" target="_blank" rel="noopener noreferrer" href="'.$ver.'">'.cortar($evento['Titulo'], 20).'</a>';
																		}
																	}
																} ?>    
															</div>
														</div>
													</td>
													<?php  
													$Dia++;
												}
												// cuando llega al final de la semana, iniciamos una columna nueva
												if($i%7==0){
													echo "</tr><tr class='fc-week'>\n";
												}
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
	</div>
</div>
