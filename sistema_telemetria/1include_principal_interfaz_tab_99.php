<?php
/**************************************************************************/
if($idTipoUsuario==1 OR $idTipoUsuario==2) {

	//Se ve el acceso al log de modificaciones
	$SIS_query = 'Fecha, Descripcion';
	$SIS_join  = '';
	$SIS_where = 'idLog!=0';
	$SIS_order = 'Fecha DESC, idLog DESC LIMIT 20';
	$arrLog = array();
	$arrLog = db_select_array (false, $SIS_query, 'core_log_cambios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrLog');

	echo '
	<div class="tab-pane fade" id="Menu_tab_99">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Log de Cambios</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">			  
						<tbody role="alert" aria-live="polite" aria-relevant="all">';
							foreach ($arrLog as $log) {
								echo '
								<tr class="odd">
									<td>'.fecha_estandar($log['Fecha']).' '.$log['Descripcion'].'</td>
								</tr>';
							}
						echo '
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>';
}

?>
