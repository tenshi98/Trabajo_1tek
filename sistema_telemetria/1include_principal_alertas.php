<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Se definen las variables
if(isset($_GET['Mes'])){      $Mes = $_GET['Mes'];         } else { $Mes  = mes_actual();}
if(isset($_GET['Ano'])){      $Ano = $_GET['Ano'];         } else { $Ano  = ano_actual();}
if(isset($_GET["nivel"])){    $nivel = $_GET["nivel"];     } else { $nivel  = 1; }
$diaActual = dia_actual();

//calculo de los dias del mes, cuando inicia y cuando termina
$diaSemana      = date("w",mktime(0,0,0,$Mes,1,$Ano))+7;
$ultimoDiaMes   = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));

/******************************/
// Se trae un listado con todas las facturas no pagadas del mes
$SIS_query = 'idAnalisis, Nombrepunto, Creacion_dia, valor, medAceptable, medAlerta, medCondenatorio';
$SIS_join  = '';
$SIS_where = 'nivel='.$nivel.' AND Creacion_mes='.$Mes.' AND Creacion_ano='.$Ano;
$SIS_order = 0;
$arrAlertas = array();
$arrAlertas = db_select_array (false, $SIS_query, 'analisis_listado_alertas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAlertas');

?>

<style>
.tooltip {
    position: initial!important;
}
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<h5>Calendario de alertas</h5>
		</header>

		<div id="calendar_content" class="body">
			<div id="calendar" class="fc fc-ltr">

				<table class="fc-header" style="width:100%">
					<tbody>
						<tr>
							<?php
							if(isset($_GET['Ano'])){
								$Ano_a  = $_GET['Ano'];
								$Ano_b  = $_GET['Ano'];
							} else {
								$Ano_a  = date("Y");
								$Ano_b  = date("Y");
							}
							if (($Mes-1)==0){$mes_atras=12;   $Ano_a=$Ano_a-1;}else{$mes_atras=$Mes-1; }
							if (($Mes+1)==13) {$mes_adelante=1; $Ano_b=$Ano_b+1;}else{$mes_adelante=$Mes+1; }
							?>
							<td class="fc-header-left"><a href="<?php echo $original.'?nivel='.$nivel.'&Mes='.$mes_atras.'&Ano='.$Ano_a ?>" class="btn btn-default"><i class="fa fa-angle-left faa-horizontal animated" aria-hidden="true"></i></a></td>
							<td class="fc-header-center"><span class="fc-header-title"><h2><?php echo numero_a_mes($Mes)." ".$Ano?></h2></span></td>
							<td class="fc-header-right"><a href="<?php echo $original.'?nivel='.$nivel.'&Mes='.$mes_adelante.'&Ano='.$Ano_b ?>" class="btn btn-default"><i class="fa fa-angle-right faa-horizontal animated" aria-hidden="true"></i></a></td>
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
														
														/***************************************/
														//Arriendos
														foreach ($arrAlertas as $prod) {
															if ($prod['Creacion_dia']==$Dia) {
																$ver = 'view_analisis.php?view='.simpleEncode($prod['idAnalisis'], fecha_actual());
																$trabajo = $prod['Nombrepunto'].' fuera de parametros';
																switch ($nivel) {
																	case 1:
																		$calcolor = 'evcal_color1';
																		break;
																	case 2:
																		$calcolor = 'evcal_color2';
																		break;
																	case 3:
																		$calcolor = 'evcal_color4';
																		break;
																}

																
																if($original=="principal_alertas_alt.php"){
																	echo '<a title="Ver Información" class="tooltip event_calendar '.$calcolor.'" href="'.$ver.'&return=true">'.$trabajo.'</a>';
																}else{
																	echo '<a title="Ver Información" class="iframe tooltip event_calendar '.$calcolor1.'" href="'.$ver.'">'.$trabajo.'</a>';
																}
																	
															}
														}
														?>
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


