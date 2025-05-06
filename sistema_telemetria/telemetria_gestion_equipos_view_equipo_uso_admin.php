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
//Verifico la existencia de datos de base de datos
if(isset($_GET['data_3'])&&isset($_GET['data_4'])&&isset($_GET['data_5'])&&isset($_GET['data_6'])){

	//Funcion para conectarse
	function conectarDB ($servidor, $usuario, $password, $base_datos) {
		$db_con = mysqli_connect($servidor, $usuario, $password, $base_datos);
		$db_con->set_charset("utf8");
		return $db_con;
	}
	//ejecuto conexion
	$dbConn = conectarDB($_GET['data_3'], $_GET['data_4'], $_GET['data_5'], $_GET['data_6']);

}

/*************************************************************************/
// consulto los datos// consulto los datos
$SIS_query = 'Nombre,cantSensores, Direccion_img';
$SIS_join  = '';
$SIS_where = 'telemetria_listado.idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*************************************************************************/
//Se arma la consulta
$cadena = '';
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	$cadena .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$cadena .= ',telemetria_listado_sensores_uso.SensoresUso_'.$i;
	$cadena .= ',telemetria_listado_sensores_uso_fecha.SensoresFechaUso_'.$i;
	$cadena .= ',telemetria_listado_sensores_accion_c.SensoresAccionC_'.$i;
	$cadena .= ',telemetria_listado_sensores_accion_t.SensoresAccionT_'.$i;
	$cadena .= ',telemetria_listado_sensores_accion_med_c.SensoresAccionMedC_'.$i;
	$cadena .= ',telemetria_listado_sensores_accion_med_t.SensoresAccionMedT_'.$i;
	$cadena .= ',telemetria_listado_sensores_accion_alerta.SensoresAccionAlerta_'.$i;
}

// consulto los datos
$SIS_query = 'telemetria_listado.Nombre'.$cadena;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_uso`             ON telemetria_listado_sensores_uso.idTelemetria            = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_uso_fecha`       ON telemetria_listado_sensores_uso_fecha.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_c`        ON telemetria_listado_sensores_accion_c.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_t`        ON telemetria_listado_sensores_accion_t.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_med_c`    ON telemetria_listado_sensores_accion_med_c.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_med_t`    ON telemetria_listado_sensores_accion_med_t.idTelemetria   = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_accion_alerta`   ON telemetria_listado_sensores_accion_alerta.idTelemetria  = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$rowMed = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*************************************************************************/
//Cuento si hay sensores activos
$rowcount = 0;
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	if(isset($rowMed['SensoresUso_'.$i])&&$rowMed['SensoresUso_'.$i]==1){
		$rowcount++;
	}
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">
	<a target="_blank" rel="noopener noreferrer" href="<?php echo 'telemetria_listado.php?pagina=1&id='.simpleDecode($_GET['view'], fecha_actual()); ?>" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Editar Equipo</a>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Equipo <?php echo $rowData['Nombre']; ?></h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#uso" data-toggle="tab"><i class="fa fa-sliders" aria-hidden="true"></i> Sensores</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="uso">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/maquina.jpg">
						<?php }else{  ?>
							<?php if (isset($_GET['data_1'])&&$_GET['data_1']=='si') { ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo 'https://'.$_GET['data_2'].$rowData['Direccion_img']; ?>">
							<?php }else{  ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
							<?php } ?>
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<?php
						//verifico los resultados y muestro la tabla
						if(isset($rowcount)&&$rowcount!=0){ ?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="box">
									<header>
										<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Sensores Supervisados</h5>
									</header>
									<div class="table-responsive">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<thead>
												<tr role="row">
													<th>Nombre</th>
													<th>Fecha</th>
													<th>Ciclos Limite</th>
													<th>Ciclos Actuales</th>
													<th>% Cumplimiento</th>
													<th>Horas limite</th>
													<th>Horas Actuales</th>
													<th>% Cumplimiento</th>
													<th>% Alerta</th>
												</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all">
												<?php for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
													//Se verifica si el sensor esta habilitado para la supervision
													if(isset($rowMed['SensoresUso_'.$i])&&$rowMed['SensoresUso_'.$i]==1){ ?>
														<tr class="odd">
															<td><?php echo $rowMed['SensoresNombre_'.$i]; ?></td>
															<td><?php echo fecha_estandar($rowMed['SensoresFechaUso_'.$i]); ?></td>
															<td><?php echo Cantidades_decimales_justos($rowMed['SensoresAccionC_'.$i]); ?></td>
															<td><?php echo Cantidades_decimales_justos($rowMed['SensoresAccionMedC_'.$i]); ?></td>
															<td><?php echo porcentaje($rowMed['SensoresAccionMedC_'.$i]/$rowMed['SensoresAccionC_'.$i]); ?></td>
															<td><?php echo Cantidades_decimales_justos($rowMed['SensoresAccionT_'.$i]/3600); ?></td>
															<td><?php echo Cantidades_decimales_justos($rowMed['SensoresAccionMedT_'.$i]/3600); ?></td>
															<td><?php echo porcentaje($rowMed['SensoresAccionMedT_'.$i]/$rowMed['SensoresAccionT_'.$i]); ?></td>
															<td><?php echo Cantidades_decimales_justos($rowMed['SensoresAccionAlerta_'.$i]); ?></td>
														</tr>
													<?php
													}
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						<?php } else{ ?>
							<div style="margin-top:15px;">
								<?php
								$Alert_Text  = 'No existen sensores configurados para la supervision';
								alert_post_data(2,1,1,0, $Alert_Text);
								?>
							</div>
						<?php } ?>
					</div>
					<div class="clearfix"></div>

				</div>
			</div>

        </div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
