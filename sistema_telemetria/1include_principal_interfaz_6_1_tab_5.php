<?php
//Se traen todas las solicitudes
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.idEstado,
cross_solicitud_aplicacion_listado.f_programacion,
cross_solicitud_aplicacion_listado.horaProg,
cross_predios_listado.Nombre AS NombrePredio';
$SIS_join  = '
LEFT JOIN `cross_predios_listado` ON cross_predios_listado.idPredio = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `cross_checking_temporada` ON cross_checking_temporada.idTemporada = cross_solicitud_aplicacion_listado.idTemporada';
$SIS_where = 'cross_solicitud_aplicacion_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].' AND cross_checking_temporada.idEstado=1';
$SIS_order = 'cross_solicitud_aplicacion_listado.idEstado ASC, cross_solicitud_aplicacion_listado.NSolicitud DESC LIMIT 100';
$arrSolicitud = array();
$arrSolicitud = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSolicitud');

//Nuevos arreglos
$arrProgramadas  = array();
$arrEnEjecucion  = array();
$arrTerminadas   = array();
$max_counter     = 0;

$i = 0;
foreach ($arrSolicitud as $sol) {
	if(isset($sol['idEstado'])&&$sol['idEstado']==1){
		$arrProgramadas[$i]['NSolicitud']   = n_doc($sol['NSolicitud'], 5);
		$arrProgramadas[$i]['Fecha']        = Fecha_estandar($sol['f_programacion']).' '.$sol['horaProg'];
		$arrProgramadas[$i]['Predio']       = $sol['NombrePredio'];
		$arrProgramadas[$i]['idSolicitud']  = $sol['idSolicitud'];
		$i++;
		if($max_counter<$i){$max_counter=$i;}
	}
}

$i = 0;
foreach ($arrSolicitud as $sol) {
	if(isset($sol['idEstado'])&&$sol['idEstado']==2){
		$arrEnEjecucion[$i]['NSolicitud']   = n_doc($sol['NSolicitud'], 5);
		$arrEnEjecucion[$i]['Fecha']        = Fecha_estandar($sol['f_programacion']).' '.$sol['horaProg'];
		$arrEnEjecucion[$i]['Predio']       = $sol['NombrePredio'];
		$arrEnEjecucion[$i]['idSolicitud']  = $sol['idSolicitud'];
		$i++;
		if($max_counter<$i){$max_counter=$i;}
	}
}

$i = 0;
foreach ($arrSolicitud as $sol) {
	if(isset($sol['idEstado'])&&$sol['idEstado']==3){
		$arrTerminadas[$i]['NSolicitud']   = n_doc($sol['NSolicitud'], 5);
		$arrTerminadas[$i]['Fecha']        = Fecha_estandar($sol['f_programacion']).' '.$sol['horaProg'];
		$arrTerminadas[$i]['Predio']       = $sol['NombrePredio'];
		$arrTerminadas[$i]['idSolicitud']  = $sol['idSolicitud'];
		$i++;
		if($max_counter<$i){$max_counter=$i;}
	}
}


?>
<div role="tabpanel" class="tab-pane fade" id="resumen">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Monitor de aplicaciones</h5>
				<div class="toolbar">
					<a target="new" href="informe_busqueda_solicitud_aplicacion_01.php" class="btn btn-xs btn-primary btn-line">Busqueda Solicitud</a>
				</div>
			</header>
			<div class="table-responsive">

				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th colspan="4">Programadas</th>
							<th colspan="4">En Ejecucion</th>
							<th colspan="4">Terminadas</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php for ($i = 0; $i < $max_counter; $i++) { ?>
							<tr class="odd">

								<td><?php if(isset($arrProgramadas[$i]['idSolicitud'])&&$arrProgramadas[$i]['idSolicitud']!=''){echo $arrProgramadas[$i]['NSolicitud'];} ?></td>
								<td><?php if(isset($arrProgramadas[$i]['idSolicitud'])&&$arrProgramadas[$i]['idSolicitud']!=''){echo $arrProgramadas[$i]['Fecha'];} ?></td>
								<td><?php if(isset($arrProgramadas[$i]['idSolicitud'])&&$arrProgramadas[$i]['idSolicitud']!=''){echo $arrProgramadas[$i]['Predio'];} ?></td>
								<td>
									<?php if(isset($arrProgramadas[$i]['idSolicitud'])&&$arrProgramadas[$i]['idSolicitud']!=''){ ?>
										<div class="btn-group" style="width: 35px;" >
											<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($arrProgramadas[$i]['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											<?php /* ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'cross_solicitud_aplicacion_editar.php?view='.$arrProgramadas[$i]['idSolicitud']; ?>" title="Editar Solicitud" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											<a href="<?php echo 'cross_solicitud_aplicacion_ejecutar.php?pagina=1&submit_filter=Filtrar&ejecution='.$arrProgramadas[$i]['idSolicitud']; ?>" title="Ejecutar Solicitud" class="btn btn-success btn-sm tooltip"><i class="fa fa-arrow-right" aria-hidden="true"></i></a><?php */ ?>				
										</div>
									<?php } ?>
								</td>

								<td><?php if(isset($arrEnEjecucion[$i]['idSolicitud'])&&$arrEnEjecucion[$i]['idSolicitud']!=''){echo $arrEnEjecucion[$i]['NSolicitud'];} ?></td>
								<td><?php if(isset($arrEnEjecucion[$i]['idSolicitud'])&&$arrEnEjecucion[$i]['idSolicitud']!=''){echo $arrEnEjecucion[$i]['Fecha'];} ?></td>
								<td><?php if(isset($arrEnEjecucion[$i]['idSolicitud'])&&$arrEnEjecucion[$i]['idSolicitud']!=''){echo $arrEnEjecucion[$i]['Predio'];} ?></td>
								<td>
									<?php if(isset($arrEnEjecucion[$i]['idSolicitud'])&&$arrEnEjecucion[$i]['idSolicitud']!=''){ ?>
										<div class="btn-group" style="width: 35px;" >
											<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($arrEnEjecucion[$i]['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											<?php /* ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'cross_solicitud_aplicacion_editar.php?view='.$arrEnEjecucion[$i]['idSolicitud']; ?>" title="Editar Solicitud" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											<a href="<?php echo 'cross_solicitud_aplicacion_ejecucion.php?pagina=1&submit_filter=Filtrar&termino='.$arrEnEjecucion[$i]['idSolicitud']; ?>" title="Terminar Solicitud" class="btn btn-success btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a><?php */ ?>				
										</div>
									<?php } ?>
								</td>

								<td><?php if(isset($arrTerminadas[$i]['idSolicitud'])&&$arrTerminadas[$i]['idSolicitud']!=''){echo $arrTerminadas[$i]['NSolicitud'];} ?></td>
								<td><?php if(isset($arrTerminadas[$i]['idSolicitud'])&&$arrTerminadas[$i]['idSolicitud']!=''){echo $arrTerminadas[$i]['Fecha'];} ?></td>
								<td><?php if(isset($arrTerminadas[$i]['idSolicitud'])&&$arrTerminadas[$i]['idSolicitud']!=''){echo $arrTerminadas[$i]['Predio'];} ?></td>
								<td>
									<?php if(isset($arrTerminadas[$i]['idSolicitud'])&&$arrTerminadas[$i]['idSolicitud']!=''){ ?>
										<div class="btn-group" style="width: 35px;" >
											<a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($arrTerminadas[$i]['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											<?php /* ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'cross_solicitud_aplicacion_editar.php?view='.$arrTerminadas[$i]['idSolicitud']; ?>" title="Editar Solicitud" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php */ ?>
										</div>
									<?php } ?>
								</td>

							</tr>
						<?php } ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
