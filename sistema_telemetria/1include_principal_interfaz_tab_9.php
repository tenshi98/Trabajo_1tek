<?php
/**************************************************************************/
//Facturacion Furgones
$temp = $prm_x[50];
if($temp!=0) {

// Se trae un listado con todos los elementos
$SIS_query = '
gestion_reserva_oficinas.idReserva,
gestion_reserva_oficinas.Fecha,
gestion_reserva_oficinas.Dia,
gestion_reserva_oficinas.Mes,
gestion_reserva_oficinas.Ano,
gestion_reserva_oficinas.Hora_Inicio,
gestion_reserva_oficinas.Hora_Termino,
gestion_reserva_oficinas.idEstado,
gestion_reserva_oficinas.idOficina,
oficinas_listado.Nombre AS Oficina';
$SIS_join  = 'LEFT JOIN `oficinas_listado` ON oficinas_listado.idOficina = gestion_reserva_oficinas.idOficina';
$SIS_where = 'gestion_reserva_oficinas.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].' AND gestion_reserva_oficinas.Mes='.mes_actual().' AND gestion_reserva_oficinas.Ano='.ano_actual();
$SIS_order = 0;
$arrReserva = array();
$arrReserva = db_select_array (false, $SIS_query, 'gestion_reserva_oficinas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrReserva');

//se filtra por oficina
filtrar($arrReserva, 'idOficina');

//Se definen las variables
if(isset($_GET['Mes'])){   $Mes = $_GET['Mes'];   } else { $Mes  = mes_actual();}
if(isset($_GET['Ano'])){   $Ano = $_GET['Ano'];   } else { $Ano  = ano_actual();}

//Otras Variables
$diaActual     = dia_actual();
$semanaActual  = semana_actual();

//calculo de los dias del mes, cuando inicia y cuando termina
$diaSemana      = date("w",mktime(0,0,0,$Mes,1,$Ano))+7;
$ultimoDiaMes   = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));

?>

<style>
#calendar .tooltip {position: initial!important;}
</style>

<div class="tab-pane fade" id="Menu_tab_9">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Detalle Reservas</h5>
				<ul class="nav nav-tabs pull-right">
					<?php
					$xcounter = 1;
					foreach($arrReserva as $idOficina=>$reservas){
						if($xcounter==1){$xactive = 'active';}else{$xactive = '';}
						if($xcounter==4){echo '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';}
						echo '<li class="'.$xactive.'"><a href="#res_id_'.$idOficina.'" data-toggle="tab"><i class="fa fa-tag" aria-hidden="true"></i> '.$reservas[0]['Oficina'].'</a></li>';
						$xcounter++;
					}
					if($xcounter>4){echo '</ul></li>';}
					?>
				</ul>
			</header>
			<div id="div-4" class="tab-content">
				<?php
				$xcounter = 1;
				foreach($arrReserva as $idOficina=>$reservas){
					if($xcounter==1){$xactive = 'active in';}else{$xactive = '';} ?>

						<div class="tab-pane fade <?php echo $xactive; ?>" id="res_id_<?php echo $idOficina; ?>">
							<div class="wmd-panel">

								<br/>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">
									<a href="gestion_reserva_oficinas.php?pagina=1&new=true&idOficina=<?php echo $idOficina; ?>" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Reserva</a>
								</div>
								<div class="clearfix"></div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="box">
										<header>
											<h5>Calendario de Reservas de <?php echo $reservas[0]['Oficina']; ?></h5>
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
																						<?php
																						foreach ($reservas as $res) {
																							if ($res['Dia']==$Dia&&$res['Mes']==$Mes) {
																								$ver = 'view_gestion_reserva_oficinas.php?view='.simpleEncode($res['idReserva'], fecha_actual());
																								switch ($res['idEstado']) {
																									case 1: $calcolor = 'evcal_color4'; break;
																									case 2: $calcolor = 'evcal_color2'; break;
																								}
																								//Indica si esta retrasada
																								if (fecha2NSemana($res['Fecha'])<$semanaActual&&$res['idEstado']==1) {
																									$calcolor  = 'evcal_color6';
																								}
																								echo '<a title="Ver Información" class="tooltip event_calendar '.$calcolor.'" href="'.$ver.'&return=true">Res. N° '.$res['idReserva'].' ('.$res['Hora_Inicio'].' a '.$res['Hora_Termino'].')</a>';

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
					<?php
					$xcounter++;
				} ?>

			</div>
		</div>
	</div>
</div>

<?php } ?>






