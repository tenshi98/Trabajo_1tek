<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "informe_telemetria_activaciones_03.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $location .= "&idTelemetria=".$_GET['idTelemetria'];  $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['F_inicio']) && $_GET['F_inicio']!=''){          $location .= "&F_inicio=".$_GET['F_inicio'];          $search .= "&F_inicio=".$_GET['F_inicio'];}
if(isset($_GET['H_inicio']) && $_GET['H_inicio']!=''){          $location .= "&H_inicio=".$_GET['H_inicio'];          $search .= "&H_inicio=".$_GET['H_inicio'];}
if(isset($_GET['F_termino']) && $_GET['F_termino']!=''){        $location .= "&F_termino=".$_GET['F_termino'];        $search .= "&F_termino=".$_GET['F_termino'];}
if(isset($_GET['H_termino']) && $_GET['H_termino']!=''){        $location .= "&H_termino=".$_GET['H_termino'];        $search .= "&H_termino=".$_GET['H_termino'];}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = 'telemetria_listado_historial_activaciones.idEstado=1';
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){$SIS_where.=" AND telemetria_listado_historial_activaciones.idTelemetria =".$_GET['idTelemetria'];}
	if(isset($_GET['F_inicio'], $_GET['F_termino'], $_GET['h_inicio'], $_GET['h_termino']) && $_GET['F_inicio'] != '' && $_GET['F_termino'] != '' && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
		$SIS_where.=" AND telemetria_listado_historial_activaciones.TimeStamp BETWEEN '".$_GET['F_inicio']." ".$_GET['H_inicio']."' AND '".$_GET['F_termino']." ".$_GET['H_termino']."'";
	}elseif(isset($_GET['F_inicio'], $_GET['F_termino']) && $_GET['F_inicio'] != '' && $_GET['F_termino']!=''){
		$SIS_where.=" AND telemetria_listado_historial_activaciones.Fecha BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
	}

	//verifico el numero de datos antes de hacer la consulta
	$ndata_1 = db_select_nrows (false, 'idTelemetria', 'telemetria_listado_historial_activaciones', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

	//si el dato es superior a 10.000
	if(isset($ndata_1)&&$ndata_1>=10001){
		alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
	}else{

		/**********************************************************/
		//se consulta
		$SIS_query = '
		telemetria_listado_historial_activaciones.idTelemetria,
		telemetria_listado_historial_activaciones.Fecha AS EquipoFecha,
		telemetria_listado_historial_activaciones.Hora AS EquipoHora,
		telemetria_listado_historial_activaciones.SensorActivacionValor AS EquipoActivacionValor,
		telemetria_listado_historial_activaciones.Valor AS EquipoValor,
		telemetria_listado_historial_activaciones.idFueraHorario AS FueraHorario,

		telemetria_listado.Nombre AS EquipoNombre,
		telemetria_listado.cantSensores AS EquipoN_Sensores,
		telemetria_listado.Jornada_inicio AS EquipoJornada_inicio,
		telemetria_listado.Jornada_termino AS EquipoJornada_termino,
		telemetria_listado.Colacion_inicio AS EquipoColacion_inicio,
		telemetria_listado.Colacion_termino AS EquipoColacion_termino,
		telemetria_listado.Microparada AS EquipoMicroparada';
		$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_historial_activaciones.idTelemetria';
		$SIS_order = 'telemetria_listado_historial_activaciones.idTelemetria ASC, telemetria_listado_historial_activaciones.Fecha ASC, telemetria_listado_historial_activaciones.Hora ASC';
		$arrConsulta = array();
		$arrConsulta = db_select_array (false, $SIS_query, 'telemetria_listado_historial_activaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrConsulta');

		/**************************************************************************************/
		//variables
		$unk_temp = 0;
		//mensajes de error en caso de no tener configurados los datos
		if(isset($arrConsulta[0]['EquipoActivacionValor'])&&$arrConsulta[0]['EquipoActivacionValor']==0){
			echo '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >';
				$Alert_Text = 'No tiene configurado el interruptor de encendido';
				alert_post_data(4,2,2,0, $Alert_Text);
			echo '
			</div>';
			$unk_temp++;
		}
		if(isset($arrConsulta[0]['EquipoColacion_termino'])&&$arrConsulta[0]['EquipoColacion_termino']=='00:00:00'){
			echo '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >';
				$Alert_Text = 'No tiene configurada la hora de termino de la colacion';
				alert_post_data(4,2,2,0, $Alert_Text);
			echo '
			</div>';
			$unk_temp++;
		}
		if(isset($arrConsulta[0]['EquipoColacion_inicio'])&&$arrConsulta[0]['EquipoColacion_inicio']=='00:00:00'){
			echo '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >';
				$Alert_Text = 'No tiene configurada la hora de inicio de la colacion';
				alert_post_data(4,2,2,0, $Alert_Text);
			echo '
			</div>';
			$unk_temp++;
		}
		if(isset($arrConsulta[0]['EquipoJornada_inicio'])&&$arrConsulta[0]['EquipoJornada_inicio']=='00:00:00'){
			echo '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >';
				$Alert_Text = 'No tiene configurada la hora de inicio de la jornada';
				alert_post_data(4,2,2,0, $Alert_Text);
			echo '
			</div>';
			$unk_temp++;
		}
		if(isset($arrConsulta[0]['EquipoJornada_termino'])&&$arrConsulta[0]['EquipoJornada_termino']=='00:00:00'){
			echo '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >';
				$Alert_Text = 'No tiene configurada la hora de termino de la jornada';
				alert_post_data(4,2,2,0, $Alert_Text);
			echo '
			</div>';
			$unk_temp++;
		}
		if($unk_temp!=0){
			echo '<div class="clearfix"></div>';
		}

		if(isset($_GET['Amp'])&&$_GET['Amp']!=''&&$_GET['Amp']!=0){
			$Ampx = '&Amp='.$_GET['Amp'];
		}else{
			$Ampx = '';
		}



		?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
			<a target="new" href="<?php echo 'informe_telemetria_activaciones_03_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
		</div>

		<?php filtrar($arrConsulta, 'EquipoNombre');
			foreach($arrConsulta as $categoria=>$permisos){ ?>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="box">
						<header>
							<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Actividad del equipo <?php echo $categoria.' ('.$permisos[0]['EquipoJornada_inicio'].' a '.$permisos[0]['EquipoJornada_termino'].')'; ?></h5>
						</header>
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Equipo</th>
										<th>Fecha</th>
										<th>Hora<br/>Inicio     <a title="Hora de inicio real del equipo (Hora Programada:<?php echo $permisos[0]['EquipoJornada_inicio']; ?> hrs)" class="tooltip" style="display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></th>
										<th>Hora<br/>Termino    <a title="Hora de termino real del equipo (Hora Programada:<?php echo $permisos[0]['EquipoJornada_termino']; ?> hrs)" class="tooltip" style="display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></th>
										<th>Tiempo<br/>Colacion <a title="Detencion para la hora de colacion programada entre las <?php echo $permisos[0]['EquipoColacion_inicio']; ?> y las <?php echo $permisos[0]['EquipoColacion_termino']; ?>" class="tooltip" style="display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></th>
										<th>Tiempo<br/>Muerto   <a title="Todas las detenciones superiores a <?php echo $permisos[0]['EquipoMicroparada']; ?> entre la hora de inicio y termino real del equipo" class="tooltip" style="display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></th>
										<th>Tiempo<br/>Perdido  <a title="Corresponde a la detencion entre la hora de inicio programada y la hora de inicio real, solo en el caso de que la hora de inicio real sea superior a la programada.Tambien corresponde a la detencion entre la hora de termino real y la hora de termino programada, solo en el caso de que la hora de termino real sea inferior a la programada" class="tooltip" style="display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></th>
										<th>Sobre<br/>Tiempo    <a title="Corresponde a la diferencia de tiempo entre la hora de inicio real y la programada, solo en el caso de que la hora de inicio real sea inferior a la programada. Tambien corresponde a la diferencia entre la hora de termino real y la programada, solo en el caso de que la hora de termino real sea superior a la programada " class="tooltip" style="display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i></a></th>
										<th>Detalles</th>
									</tr>
								</thead>

								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php
									//Variables
									$fecha              = '';
									$HoraInicio         = '00:00:00';
									$HoraTermino        = '00:00:00';
									$TiempoColacionIni  = '00:00:00';
									$TiempoColacionTer  = '00:00:00';
									$TiempoColacionTot  = '00:00:00';
									$TiempoMuerto       = '00:00:00';
									$TiempoMuertoTemp   = '00:00:00';
									$TiempoPerdido      = '00:00:00';
									$SobreTiempo_1      = '00:00:00';
									$SobreTiempo_2      = '00:00:00';
									$colacion           = 0;
									$FueraHorario       = 0;
									//Recorrido
									foreach ($permisos as $con) {
										/*****************************************************************/
										//Verifico si esta dentro del mismo dia
										if($fecha!=''&&$fecha==$con['EquipoFecha']){

											/***************************************/
											//Verifico hora inicio
											if($HoraInicio>$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
												$HoraInicio = $con['EquipoHora'];
											}
											//verifico hora termino
											if($HoraTermino<$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
												$HoraTermino = $con['EquipoHora'];
											}
											/***************************************/
											//verifico la hora de inicio de colacion
											if($con['EquipoColacion_inicio']<=$con['EquipoHora']&&$con['EquipoColacion_termino']>=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
												$TiempoColacionIni = $con['EquipoHora'];
												$colacion = 1;
											}
											//se verifica el termino de la colacion
											if($colacion==1&&$TiempoColacionTot=='00:00:00'&&$con['EquipoValor']==$con['EquipoActivacionValor']){
												//reseteo
												$colacion = 0;
												$TiempoColacionTer = $con['EquipoHora'];
												//Calculo colacion
												$Tiempo = restahoras($TiempoColacionIni, $TiempoColacionTer);
												if($Tiempo>'00:30:00'){
													$TiempoColacionTot = $Tiempo;
												}
											}
											/***************************************/
											//Verifico el tiempo muerto
											if($con['EquipoValor']!=$con['EquipoActivacionValor']){
												$TiempoMuertoTemp  = $con['EquipoHora'];
											}
											if($con['EquipoValor']==$con['EquipoActivacionValor']&&$TiempoMuertoTemp!='00:00:00'){
												//calculo los tiempos
												$Tiempo = restahoras($TiempoMuertoTemp ,$con['EquipoHora']);
												//verifico que sea superior a la microparadas
												if($Tiempo>=$con['EquipoMicroparada']){
													$TiempoMuerto1 = sumahoras($TiempoMuerto,$Tiempo);
													//validacion
													if($TiempoMuerto1!='El dato ingresado no es una hora'){
														$TiempoMuerto = $TiempoMuerto1;
													}
													//le resto el tiempo de colacion solo si el tiempo muerto es igual o superior
													if($TiempoMuerto>=$TiempoColacionTot){
														$TiempoMuerto = restahoras($TiempoColacionTot ,$TiempoMuerto);
													}
												}
											}

											/***************************************/
											//Verifico el sobretiempo
											if($SobreTiempo_1=='00:00:00'&&$con['EquipoJornada_inicio']>=$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
												$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($con['EquipoHora'], $con['EquipoJornada_inicio']));
											}
											if($con['EquipoJornada_termino']<=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
												$SobreTiempo_2 = restahoras($con['EquipoJornada_termino'],$con['EquipoHora'] );
											}

											/***************************************/
											//Verifico si tiene algun dato que figure como fuera de horario
											if(isset($con['FueraHorario'])&&$con['FueraHorario']==1){
												$FueraHorario++;
											}

										/*****************************************************************/
										//Si cambia de dia
										}elseif($fecha!=''&&$fecha!=$con['EquipoFecha']){

											//Calculo de la perdida de tiempo
											if($con['EquipoJornada_inicio']<=$HoraInicio){
												$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($con['EquipoJornada_inicio'], $HoraInicio));
											}
											if($con['EquipoJornada_termino']>=$HoraTermino){
												$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($HoraTermino, $con['EquipoJornada_termino'] ));
											}

											?>
											<tr class="odd">
												<td><?php echo $categoria; ?></td>
												<td><?php echo fecha_estandar($fecha); ?></td>
												<td><?php echo $HoraInicio; ?></td>
												<td><?php echo $HoraTermino; ?></td>
												<td><?php echo $TiempoColacionTot; ?></td>
												<td><?php echo $TiempoMuerto; ?></td>
												<td><?php echo $TiempoPerdido; ?></td>
												<td><?php echo sumahoras($SobreTiempo_1,$SobreTiempo_2); ?></td>
												<td>
													<div class="btn-group" style="width: 105px;" >
														<?php if ($rowlevel['level']>=1&&$fecha==''){ ?><a href="<?php echo 'view_telemetria_historial.php?view='.simpleEncode($con['idTelemetria'], fecha_actual()).'&dia='.simpleEncode($fecha, fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
														<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria_historial_activaciones.php?view='.simpleEncode($con['idTelemetria'], fecha_actual()).'&dia='.simpleEncode($fecha, fecha_actual()).'&cantSensores='.simpleEncode($con['EquipoN_Sensores'], fecha_actual()).$Ampx; ?>" title="Ver Amperes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-power-off" aria-hidden="true"></i></a><?php } ?>
														<?php if ($rowlevel['level']>=1&&$FueraHorario!=0&&$fecha==''){ ?><a href="<?php echo 'view_telemetria_historial.php?view='.simpleEncode($con['idTelemetria'], fecha_actual()).'&dia='.simpleEncode($fecha, fecha_actual()).'&fueraHorario=true'; ?>" title="Ver Apagado por Amp." class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-power-off" aria-hidden="true"></i></a><?php } ?>
													</div>
												</td>
											</tr>
										<?php
											//redeclaro variables
											$fecha              = $con['EquipoFecha'];
											$HoraInicio         = $con['EquipoHora'];
											$HoraTermino        = $con['EquipoHora'];
											$TiempoColacionIni  = '00:00:00';
											$TiempoColacionTer  = '00:00:00';
											$TiempoColacionTot  = '00:00:00';
											$TiempoMuerto       = '00:00:00';
											$TiempoMuertoTemp   = '00:00:00';
											$TiempoPerdido      = '00:00:00';
											$SobreTiempo_1      = '00:00:00';
											$SobreTiempo_2      = '00:00:00';
											$colacion           = 0;
											$FueraHorario       = 0;
											/***************************************/
											//Verifico el sobretiempo
											if($SobreTiempo_1=='00:00:00'&&$con['EquipoJornada_inicio']>=$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
												$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($con['EquipoHora'], $con['EquipoJornada_inicio']));
											}
											if($con['EquipoJornada_termino']<=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
												$SobreTiempo_2 = restahoras($con['EquipoJornada_termino'],$con['EquipoHora'] );
											}
											/***************************************/
											//Verifico si tiene algun dato que figure como fuera de horario
											if(isset($con['FueraHorario'])&&$con['FueraHorario']==1){
												$FueraHorario++;
											}
										/*****************************************************************/
										//Primer dato
										}else{
											$fecha              = $con['EquipoFecha'];
											$HoraInicio         = $con['EquipoHora'];
											$HoraTermino        = $con['EquipoHora'];
											$TiempoColacionIni  = '00:00:00';
											$TiempoColacionTer  = '00:00:00';
											$TiempoColacionTot  = '00:00:00';
											$TiempoMuerto       = '00:00:00';
											$TiempoMuertoTemp   = '00:00:00';
											$TiempoPerdido      = '00:00:00';
											$SobreTiempo_1      = '00:00:00';
											$SobreTiempo_2      = '00:00:00';
											$colacion           = 0;
											$FueraHorario       = 0;
											/***************************************/
											//Verifico el sobretiempo
											if($SobreTiempo_1=='00:00:00'&&$con['EquipoJornada_inicio']>=$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
												$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($con['EquipoHora'], $con['EquipoJornada_inicio']));
											}
											if($con['EquipoJornada_termino']<=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
												$SobreTiempo_2 = restahoras($con['EquipoJornada_termino'],$con['EquipoHora'] );
											}
											/***************************************/
											//Verifico si tiene algun dato que figure como fuera de horario
											if(isset($con['FueraHorario'])&&$con['FueraHorario']==1){
												$FueraHorario++;
											}
										}

										$l_ejti = $con['EquipoJornada_inicio'];
										$l_ejtt = $con['EquipoJornada_termino'];
										$l_mp   = $con['EquipoMicroparada'];
										$l_v1   = $con['EquipoValor'];
										$l_v2   = $con['EquipoActivacionValor'];

									}

									/**********************************************************************************/
									//ultimo dato
									//Calculo colacion
									//$TiempoColacionTot = restahoras($TiempoColacionIni, $TiempoColacionTer);
									//Calculo de la perdida de tiempo
									if($l_ejti<=$HoraInicio){
										$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($l_ejti, $HoraInicio));
									}
									if($l_ejtt>=$HoraTermino){
										$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($HoraTermino, $l_ejtt ));
									}
									//Verifico el sobretiempo
									if($l_ejti>=$HoraInicio&&$l_v1==$l_v2){
										$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($HoraInicio,$l_ejti));
									}
									if($l_ejtt<=$HoraInicio&&$l_v1!=$l_v2){
										$SobreTiempo_2 = sumahoras($SobreTiempo_2, restahoras($l_ejtt,$HoraInicio ));
									}

									?>
									<tr class="odd">
										<td><?php echo $categoria; ?></td>
										<td><?php echo fecha_estandar($fecha); ?></td>
										<td><?php echo $HoraInicio; ?></td>
										<td><?php echo $HoraTermino; ?></td>
										<td><?php echo $TiempoColacionTot; ?></td>
										<td><?php echo $TiempoMuerto; ?></td>
										<td><?php echo $TiempoPerdido; ?></td>
										<td><?php echo sumahoras($SobreTiempo_1,$SobreTiempo_2); ?></td>
										<td>
											<div class="btn-group" style="width: 105px;" >
												<?php if ($rowlevel['level']>=1&&$fecha==''){ ?><a href="<?php echo 'view_telemetria_historial.php?view='.simpleEncode($con['idTelemetria'], fecha_actual()).'&dia='.simpleEncode($fecha, fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria_historial_activaciones.php?view='.simpleEncode($con['idTelemetria'], fecha_actual()).'&dia='.simpleEncode($fecha, fecha_actual()).'&cantSensores='.simpleEncode($con['EquipoN_Sensores'], fecha_actual()).$Ampx; ?>" title="Ver Amperes" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-power-off" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=1&&$FueraHorario!=0&&$fecha==''){ ?><a href="<?php echo 'view_telemetria_historial.php?view='.simpleEncode($con['idTelemetria'], fecha_actual()).'&dia='.simpleEncode($fecha, fecha_actual()).'&fueraHorario=true'; ?>" title="Ver Apagado por Amp." class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-power-off" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
		<?php } ?>
	<?php } ?>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//filtros
	$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Filtro de Búsqueda</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTelemetria)){  $x1  = $idTelemetria;  }else{$x1  = '';}
					if(isset($F_inicio)){      $x2  = $F_inicio;      }else{$x2  = '';}
					if(isset($H_inicio)){      $x3  = $H_inicio;      }else{$x3  = '';}
					if(isset($F_termino)){     $x4  = $F_termino;     }else{$x4  = '';}
					if(isset($H_termino)){     $x5  = $H_termino;     }else{$x5  = '';}
					if(isset($Amp)){           $x6  = $Amp;           }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_date('Fecha Inicio','F_inicio', $x2, 2);
					//$Form_Inputs->form_time('Hora Inicio','H_inicio', $x3, 1, 2);
					$Form_Inputs->form_date('Fecha Termino','F_termino', $x4, 2);
					//$Form_Inputs->form_time('Hora Termino','H_termino', $x5, 1, 1);
					$Form_Inputs->form_input_number('Amperes a revisar', 'Amp', $x6, 1);

					$Form_Inputs->form_input_hidden('pagina', 1, 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
