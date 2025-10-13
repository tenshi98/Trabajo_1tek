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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
// consulto los datos
$SIS_query = 'Nombre,IdentificadorEmpresa, LimiteVelocidad, cantSensores, id_Geo, id_Sensores, Direccion_img, TiempoFueraLinea, TiempoDetencion';
$SIS_join  = '';
$SIS_where = 'idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
/*****************************************************************/
// Se trae un listado con todas las alertas
$SIS_query = '
telemetria_listado_errores.idErrores,
telemetria_listado_errores.Descripcion,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Hora,
telemetria_listado_errores.Valor,
telemetria_listado_errores.Valor_min,
telemetria_listado_errores.Valor_max,
telemetria_listado_errores.Sensor'.$subquery;
$SIS_join  = 'LEFT JOIN `telemetria_listado_sensores_unimed` ON telemetria_listado_sensores_unimed.idTelemetria = telemetria_listado_errores.idTelemetria';
$SIS_where = 'telemetria_listado_errores.idTelemetria = '.simpleDecode($_GET['view'], fecha_actual()).' AND telemetria_listado_errores.idTipo!=999 AND telemetria_listado_errores.Valor<99900';
$SIS_order = 'telemetria_listado_errores.idErrores DESC LIMIT 20';
$arrAlertas = array();
$arrAlertas = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAlertas');

//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

$arrFinalUnimed = array();
foreach ($arrUnimed as $sen) {
	$arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];
}

/*************************************************************************/
// Se trae un listado con todas las fuera de linea
$SIS_query = 'idFueraLinea, Fecha_inicio, Hora_inicio, Fecha_termino, Hora_termino, Tiempo';
$SIS_join  = '';
$SIS_where = 'idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$SIS_order = 'idFueraLinea DESC LIMIT 20';
$arrFlinea = array();
$arrFlinea = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFlinea');

if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){
	//numero sensores equipo
	$N_Maximo_Sensores = 72;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	}

	// consulto los datos
	$SIS_query = '
	telemetria_listado.Nombre,
	telemetria_listado.id_Geo,
	telemetria_listado.id_Sensores,
	telemetria_listado.cantSensores,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.GeoVelocidad'.$subquery;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`       ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`       ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`       ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_med_actual`   ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria';
	$SIS_where = 'idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
	$rowMed = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowMed');

}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Equipo <?php echo $rowData['Nombre']; ?></h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>

				<?php if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){ ?>
					<li class=""><a href="#mediciones" data-toggle="tab"><i class="fa fa-wifi" aria-hidden="true"></i> Ultimas Mediciones</a></li>
				<?php } ?>
				<?php if($arrAlertas!=false && !empty($arrAlertas) && $arrAlertas!=''){ ?>
					<li class=""><a href="#alertas" data-toggle="tab"><i class="fa fa-bullhorn"  aria-hidden="true"></i> Alertas</a></li>
				<?php } ?>
				<?php if($arrFlinea!=false && !empty($arrFlinea) && $arrFlinea!=''){ ?>
					<li class=""><a href="#flinea" data-toggle="tab"><i class="fa fa-power-off" aria-hidden="true"></i> Fuera de Linea</a></li>
				<?php } ?>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/maquina.jpg">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary">Datos del Equipo</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Identificador Empresa : </strong><?php echo $rowData['IdentificadorEmpresa']; ?><br/>
						</p>

						<h2 class="text-primary">Datos de Configuracion</h2>
						<p class="text-muted">
							<?php if($rowData['id_Geo']==1){ ?>
							<strong>Limite Velocidad : </strong><?php echo Cantidades_decimales_justos($rowData['LimiteVelocidad']).' KM/h'; ?><br/>
							<?php } ?>
							<?php if($rowData['id_Sensores']==1){ ?>
							<strong>Cantidad de Sensores : </strong><?php echo $rowData['cantSensores']; ?><br/>
							<?php } ?>
							<strong>Tiempo Fuera Linea Maximo : </strong><?php echo $rowData['TiempoFueraLinea']; ?> Horas<br/>
							<strong>Tiempo Maximo Detencion : </strong><?php echo $rowData['TiempoDetencion']; ?> Horas<br/>
						</p>

					</div>
					<div class="clearfix"></div>

				</div>
			</div>

			<?php if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){ ?>
				<div class="tab-pane fade" id="mediciones">
					<div class="wmd-panel">
						<div class="table-responsive">

							<div class="form-group" style="padding-top:10px;padding-bottom:10px;">
								<?php if(isset($rowMed['id_Geo'])&&$rowMed['id_Geo']!=''&&$rowMed['id_Geo']==1){ ?>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'telemetria_gestion_flota_view_equipo_mediciones.php?view='.simpleDecode($_GET['view'], fecha_actual()).'&cantSensores='.$rowMed['cantSensores']; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Ver Ultima Ubicación</a>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_sensores_1.php?view='.simpleDecode($_GET['view'], fecha_actual()); ?>" class="btn btn-default pull-right margin_width fmrbtn" >Informe Medicion Sensores</a>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_velocidad.php?view='.simpleDecode($_GET['view'], fecha_actual()); ?>" class="btn btn-default pull-right margin_width fmrbtn" >Informe Medicion Velocidades</a>
								<?php }elseif(isset($rowMed['id_Geo'])&&$rowMed['id_Geo']!=''&&$rowMed['id_Geo']==2){ ?>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'telemetria_gestion_sensores_view_equipo_mediciones.php?view='.simpleDecode($_GET['view'], fecha_actual()).'&cantSensores='.$rowMed['cantSensores']; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Ver Ultima Ubicación</a>
									<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_sensores_2.php?view='.simpleDecode($_GET['view'], fecha_actual()); ?>" class="btn btn-default pull-right margin_width fmrbtn" >Informe Medicion Sensores</a>
								<?php } ?>
								<div style="padding-bottom:10px;padding-top:10px;"></div>
							</div>

							<?php if(isset($rowData['LimiteVelocidad'])&&$rowData['LimiteVelocidad']!=0){ ?>
								<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
									<thead>
										<tr role="row">
											<th>Parametro</th>
											<th>Fecha/hora</th>
											<th>Medicion Actual</th>
											<th>Maximo Medicion</th>
										</tr>
									</thead>
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<tr class="odd <?php if($rowMed['GeoVelocidad'] > $rowData['LimiteVelocidad']){echo 'danger';} ?>">
											<td>Velocidad</td>
											<td><?php echo fecha_estandar($rowMed['LastUpdateFecha']).' - '.$rowMed['LastUpdateHora'].' hrs'; ?></td>
											<td><?php echo Cantidades($rowMed['GeoVelocidad'], 0).' KM/h'; ?></td>
											<td><?php echo Cantidades($rowData['LimiteVelocidad'], 0).' KM/h'; ?></td>
										</tr>

									</tbody>
								</table>
							<?php } ?>

								<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
									<thead>
										<tr role="row">
											<th>#</th>
											<th>Nombre</th>
											<th>Fecha/hora</th>
											<th>Medicion Actual</th>
										</tr>
									</thead>
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<?php for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
											//solo sensores activos
											if(isset($rowMed['SensoresActivo_'.$i])&&$rowMed['SensoresActivo_'.$i]==1){
												$unimed = ' '.$arrFinalUnimed[$rowMed['SensoresUniMed_'.$i]]; ?>
												<tr class="odd">
													<td><?php echo 's'.$i ?></td>
													<td><?php echo $rowMed['SensoresNombre_'.$i]; ?></td>
													<td><?php echo fecha_estandar($rowMed['LastUpdateFecha']).' - '.$rowMed['LastUpdateHora'].' hrs'; ?></td>
													<td><?php
													if(isset($rowMed['SensoresMedActual_'.$i])&&$rowMed['SensoresMedActual_'.$i]<99900){
														echo Cantidades_decimales_justos($rowMed['SensoresMedActual_'.$i]).$unimed;
													}else{
														echo 'Sin Datos';
													} ?>
													</td>
												</tr>
											<?php } ?>
										<?php } ?>
									</tbody>
								</table>

						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrAlertas!=false && !empty($arrAlertas) && $arrAlertas!=''){ ?>
				<div class="tab-pane fade" id="alertas">
					<div class="wmd-panel">

						<div class="table-responsive">

							<div class="form-group" style="padding-top:10px;padding-bottom:10px;">
								<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_errores_'.$rowData['id_Geo'].'.php?idTelemetria='.simpleDecode($_GET['view'], fecha_actual()).'&submit_filter=Filtrar'; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Abrir Reporte</a>
								<div style="padding-bottom:10px;padding-top:10px;"></div>
							</div>

							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Descripcion</th>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Valor</th>
										<th>Min</th>
										<th>Max</th>
										<?php if($rowData['id_Geo']==1){ ?>
											<th>Ubicación</th>
										<?php } ?>
									</tr>
								</thead>

								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrAlertas as $error) {
										//Guardo la unidad de medida
										$unimed = ' '.$arrFinalUnimed[$error['SensoresUniMed_'.$error['Sensor']]]; ?>
										<tr>
											<td><?php echo $error['Descripcion']; ?></td>
											<td><?php echo fecha_estandar($error['Fecha']); ?></td>
											<td><?php echo $error['Hora']; ?></td>
											<td><?php echo Cantidades_decimales_justos($error['Valor']).$unimed; ?></td>
											<td><?php echo Cantidades_decimales_justos($error['Valor_min']).$unimed; ?></td>
											<td><?php echo Cantidades_decimales_justos($error['Valor_max']).$unimed; ?></td>
											<?php if($rowData['id_Geo']==1){ ?>
												<td>
													<div class="btn-group" style="width: 35px;" >
														<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_errores_'.$rowData['id_Geo'].'_view.php?view='.$error['idErrores']; ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
													</div>
												</td>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrFlinea!=false && !empty($arrFlinea) && $arrFlinea!=''){ ?>
				<div class="tab-pane fade" id="flinea">
					<div class="wmd-panel">

						<div class="table-responsive">

							<div class="form-group" style="padding-top:10px;padding-bottom:10px;">
								<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_fuera_linea_'.$rowData['id_Geo'].'.php?idTelemetria='.simpleDecode($_GET['view'], fecha_actual()).'&submit_filter=Filtrar'; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Abrir Reporte</a>
								<div style="padding-bottom:10px;padding-top:10px;"></div>
							</div>

							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Fecha Inicio</th>
										<th>Hora Inicio</th>
										<th>Fecha Termino</th>
										<th>Hora Termino</th>
										<th>Tiempo</th>
										<?php if($rowData['id_Geo']==1){ ?>
											<th>Ubicación</th>
										<?php } ?>
									</tr>
								</thead>

								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrFlinea as $error) {  ?>
										<tr>
											<td><?php echo fecha_estandar($error['Fecha_inicio']); ?></td>
											<td><?php echo $error['Hora_inicio'].' hrs'; ?></td>
											<td><?php echo fecha_estandar($error['Fecha_termino']); ?></td>
											<td><?php echo $error['Hora_termino'].' hrs'; ?></td>
											<td><?php echo $error['Tiempo'].' hrs'; ?></td>
											<?php if($rowData['id_Geo']==1){ ?>
												<td>
													<div class="btn-group" style="width: 35px;" >
														<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_fuera_linea_'.$rowData['id_Geo'].'_view.php?view='.$error['idFueraLinea']; ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
													</div>
												</td>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			<?php } ?>

        </div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
