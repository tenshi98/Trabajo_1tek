
<div class="tab-pane fade" id="Menu_tab_2">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
								<i class="fa fa-exclamation-triangle fa-5x" aria-hidden="true"></i>
							</div>
							<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">
								<div class="huge" id="AlertNumber">0</div>
								<div>Con Alertas</div>
							</div>
						</div>
					</div>
					<div class="panel-footer" id="AlertBody">

					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
								<i class="fa fa-chain-broken fa-5x" aria-hidden="true"></i>
							</div>
							<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">
								<div class="huge" id="FueraNumber">0</div>
								<div>Fuera de Linea</div>
							</div>
						</div>
					</div>
					<div class="panel-footer" id="FueraBody">

					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
								<i class="fa fa-check fa-5x" aria-hidden="true"></i>
							</div>
							<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">
								<div class="huge" id="OnlineNumber">0</div>
								<div>En Linea</div>
							</div>
						</div>
					</div>
					<div class="panel-footer" id="OnlineBody">

					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
								<i class="fa fa-cog fa-5x" aria-hidden="true"></i>
							</div>
							<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">
								<div class="huge" id="TotalNumber">0</div>
								<div>Total</div>
							</div>
						</div>
					</div>
					<div class="panel-footer" id="TotalBody">

					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Estado Equipos</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th></th>
							<th>Equipo</th>
							<th>Ultima Conexion</th>
							<th>Acciones</th>
						</tr>
						<?php echo widget_sherlock(1, 7, 'TableFiltered'); ?>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">
						<?php
						//actualizacion de los widgets
						$AlertNumber   = 0;
						$FueraNumber   = 0;
						$OnlineNumber  = 0;
						$TotalNumber   = 0;

						$AlertBody     = '';
						$FueraBody     = '';
						$OnlineBody    = '';
						$TotalBody     = '';
						//filtro
						filtrar($arrEquipo, 'idSistema');
						//recorro
						foreach($arrEquipo as $sistemas=>$equipos){
							echo '<tr class="odd" ><td colspan="4"  style="background-color:#DDD"><strong>'.$equipos[0]['Sistema'].'</strong></td></tr>';
							//variables
							$eq_alertas     = 0;
							$eq_fueralinea  = 0;
							$eq_fueraruta   = 0;
							$eq_detenidos   = 0;
							$eq_gps_fuera   = 0;
							$eq_ok          = 0;

							foreach ($equipos as $data) {
								/**********************************************/
								//Se resetean
								$in_eq_alertas     = 0;
								$in_eq_fueralinea  = 0;
								$in_eq_fueraruta   = 0;
								$in_eq_detenidos   = 0;
								$in_eq_gps_fuera   = 0;
								$in_eq_ok          = 1;

								/**********************************************/
								//Fuera de linea
								$diaInicio   = $data['LastUpdateFecha'];
								$diaTermino  = fecha_actual();
								$tiempo1     = $data['LastUpdateHora'];
								$tiempo2     = hora_actual();
								$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

								//Comparaciones de tiempo
								$Time_Tiempo     = horas2segundos($Tiempo);
								$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
								$Time_Tiempo_Max = horas2segundos('48:00:00');
								$Time_Fake_Ini   = horas2segundos('23:59:50');
								$Time_Fake_Fin   = horas2segundos('24:00:00');
								//comparacion
								if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
									$in_eq_fueralinea++;
								}

								/**********************************************/
								//GPS con problemas solo si lo tiene habilitado
								if(isset($data['id_Geo'])&&$data['id_Geo']==1){
									if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){    $in_eq_gps_fuera++; }
									if(isset($data['GeoLatitud'])&&$data['GeoLatitud']==0){   $in_eq_gps_fuera++; }
									if(isset($data['GeoLongitud'])&&$data['GeoLongitud']==0){ $in_eq_gps_fuera++; }
								}

								/**********************************************/
								//Equipos Errores
								if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

								/**********************************************/
								//Equipos detenidos
								if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

								/*******************************************************/
								//rearmo
								if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
								if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
								if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
								if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
								if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

								/*******************************************************/
								//se guardan estados
								$danger = '';
								if($in_eq_detenidos>0){  $danger = '';    $dataex = '<a href="#" title="Equipo Detenido"           class="btn btn-success btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
								if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
								if($in_eq_fueraruta>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo fuera de ruta"      class="btn btn-warning btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
								if($in_eq_gps_fuera>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo sin cobertura GPS"  class="btn btn-info btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
								if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

								/*******************************************************/
								//Se guardan los valores
								$eq_alertas     = $eq_alertas + $in_eq_alertas;
								$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
								$eq_fueraruta   = $eq_fueraruta + $in_eq_fueraruta;
								$eq_detenidos   = $eq_detenidos + $in_eq_detenidos;
								$eq_gps_fuera   = $eq_gps_fuera + $in_eq_gps_fuera;
								$eq_ok          = $eq_ok + $in_eq_ok;

								/*******************************************************/
								//traspasan los estados
								if($in_eq_ok==1){
									$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
								}else{
									$eq_ok_icon = $dataex;
								}

								?>

								<tr class="odd <?php echo $danger; ?>">
									<td width="10"><div class="btn-group" style="width: 35px;" ><?php echo $eq_ok_icon; ?></div></td>
									<td><?php echo $data['Nombre']; ?></td>
									<td><?php echo fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora']; ?></td>
									<td width="10">
										<?php
										switch ($data['idTab']) {
											/**************************************************/
											//Agro-Checking
											case 1:

												break;
											/**************************************************/
											//1Tek C
											case 2:

												break;
											/**************************************************/
											//CrossTrack
											case 3:

												break;
											/**************************************************/
											//Agro-Weather
											case 4:

												break;
											/**************************************************/
											//CrossWater
											case 5:

												break;
											/**************************************************/
											//Power-Crane
											case 6:

												break;
											/**************************************************/
											//Labores Agricolas
											case 7:

												break;
											/**************************************************/
											//Desarrollos
											case 8:

												break;
											/**************************************************/
											//Power-Energy
											case 9:

												break;
										} ?>
									</td>
								</tr>
							<?php
							}

							//Variables
							$total         = $eq_alertas + $eq_fueralinea + $eq_ok;
							$AlertNumber   = $AlertNumber + $eq_alertas;
							$FueraNumber   = $FueraNumber + $eq_fueralinea;
							$OnlineNumber  = $OnlineNumber + $eq_ok;
							$TotalNumber   = $TotalNumber + $total;

							$AlertBody    .= '<span class="pull-left">'.$equipos[0]['Sistema'].':</span><span class="pull-right">'.$eq_alertas.'</span><div class="clearfix"></div>';
							$FueraBody    .= '<span class="pull-left">'.$equipos[0]['Sistema'].':</span><span class="pull-right">'.$eq_fueralinea.'</span><div class="clearfix"></div>';
							$OnlineBody   .= '<span class="pull-left">'.$equipos[0]['Sistema'].':</span><span class="pull-right">'.$eq_ok.'</span><div class="clearfix"></div>';
							$TotalBody    .= '<span class="pull-left">'.$equipos[0]['Sistema'].':</span><span class="pull-right">'.$total.'</span><div class="clearfix"></div>';

						} ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>

	<script>
		document.getElementById('AlertNumber').innerHTML  = '<?php echo $AlertNumber; ?>';
		document.getElementById('FueraNumber').innerHTML  = '<?php echo $FueraNumber; ?>';
		document.getElementById('OnlineNumber').innerHTML = '<?php echo $OnlineNumber; ?>';
		document.getElementById('TotalNumber').innerHTML  = '<?php echo $TotalNumber; ?>';

		document.getElementById('AlertNumber_2').innerHTML  = '<?php echo $AlertNumber; ?>';
		document.getElementById('FueraNumber_2').innerHTML  = '<?php echo $FueraNumber; ?>';
		document.getElementById('OnlineNumber_2').innerHTML = '<?php echo $OnlineNumber; ?>';
		document.getElementById('TotalNumber_2').innerHTML  = '<?php echo $TotalNumber; ?>';

		document.getElementById('AlertBody').innerHTML  = '<?php echo $AlertBody; ?>';
		document.getElementById('FueraBody').innerHTML  = '<?php echo $FueraBody; ?>';
		document.getElementById('OnlineBody').innerHTML = '<?php echo $OnlineBody; ?>';
		document.getElementById('TotalBody').innerHTML  = '<?php echo $TotalBody; ?>';

	</script>

</div>
