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

// consulto los datos
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.Sim_Num_Tel,
telemetria_listado.Sim_Num_Serie,
telemetria_listado.Sim_modelo,
telemetria_listado.Sim_marca,
telemetria_listado.Sim_Compania,
telemetria_listado.IP_Client,
telemetria_listado.IdentificadorEmpresa,
telemetria_listado.cantSensores,
telemetria_listado.id_Sensores,
telemetria_listado.Direccion_img,
telemetria_listado.TiempoFueraLinea,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
telemetria_listado.Direccion,
telemetria_listado.IP_Client,
telemetria_listado.idTelemetria';
$SIS_join  = '
LEFT JOIN `core_ubicacion_ciudad`    ON core_ubicacion_ciudad.idCiudad  = telemetria_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   ON core_ubicacion_comunas.idComuna = telemetria_listado.idComuna';
$SIS_where = 'idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/****************************************************************/
//Se arma la consulta
$cadena = '';
for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
	$cadena .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$cadena .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	$cadena .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
	$cadena .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$cadena .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}
// consulto los datos
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.id_Sensores,
telemetria_listado.cantSensores,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.GeoVelocidad'.$cadena;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`       ON telemetria_listado_sensores_grupo.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$rowMed = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowMed');

/****************************************************************/
//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

$unimed = array();
//unidad de medida
foreach ($arrUnimed as $sen) {
	$unimed[$sen['idUniMed']]['Nombre'] = $sen['Nombre'];
}

/****************************************************************/
//Se consultan datos
$arrGrupo = array();
$arrGrupo = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupo');

$grupo = array();
foreach ($arrGrupos as $sen) {
	$grupo[$sen['idGrupo']]['Nombre'] = $sen['Nombre'];
}

/****************************************************************/
//numero sensores equipo
$N_Maximo_Sensores = $rowData['cantSensores'];
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}
// Se trae un listado con todas las alertas
$SIS_query = '
telemetria_listado_errores_999.idErrores,
telemetria_listado_errores_999.Descripcion,
telemetria_listado_errores_999.Fecha,
telemetria_listado_errores_999.Hora,
telemetria_listado_errores_999.Valor,
telemetria_listado_errores_999.Sensor'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado_errores_999.idTelemetria';
$SIS_where = 'telemetria_listado_errores_999.idTelemetria = '.simpleDecode($_GET['view'], fecha_actual());
$SIS_order = 'telemetria_listado_errores_999.idErrores DESC LIMIT 20';
$arrAlertas999 = array();
$arrAlertas999 = db_select_array (false, $SIS_query, 'telemetria_listado_errores_999', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAlertas999');

/****************************************************************/
// Se trae un listado con todas las fuera de linea
$SIS_query = 'idFueraLinea, Fecha_inicio, Hora_inicio, Fecha_termino, Hora_termino, Tiempo';
$SIS_join  = '';
$SIS_where = 'idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$SIS_order = 'idFueraLinea DESC LIMIT 20';
$arrFlinea = array();
$arrFlinea = db_select_array (false, $SIS_query, 'telemetria_listado_error_fuera_linea', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFlinea');

/****************************************************************/
// Se trae un listado con todas las fuera de linea
$SIS_query = 'Fecha, Hora, Diferencia';
$SIS_join  = '';
$SIS_where = 'idTelemetria ='.simpleDecode($_GET['view'], fecha_actual());
$SIS_order = 'Fecha DESC, Hora DESC LIMIT 20';
$arrGPS0 = array();
$arrGPS0 = db_select_array (false, $SIS_query, 'telemetria_listado_historial_gps', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGPS0');

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

				<li class=""><a href="#flinea"    data-toggle="tab"><i class="fa fa-power-off" aria-hidden="true"></i> Fuera de Linea</a></li>
				<li class=""><a href="#error999"  data-toggle="tab"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Errores 999***</a></li>
				<li class=""><a href="#gps0"      data-toggle="tab"><i class="fa fa-battery-empty" aria-hidden="true"></i> Equipo sin GPS</a></li>

			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/maquina.jpg">
						<?php }else{  ?>
							<?php if (isset($_GET['data_1'])&&$_GET['data_1']=='si') { ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo 'https://'.$_GET['data_2'].$rowData['Direccion_img']; ?>">
							<?php }else{  ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
							<?php } ?>
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary">Datos del Equipo</h2>
						<p class="text-muted">
							<?php if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){ ?><strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/><?php } ?>
							<?php if(isset($rowData['IdentificadorEmpresa'])&&$rowData['IdentificadorEmpresa']!=''){ ?><strong>Identificador Empresa : </strong><?php echo $rowData['IdentificadorEmpresa']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_Num_Tel'])&&$rowData['Sim_Num_Tel']!=''){ ?><strong>SIM - Numero Telefonico : </strong><?php echo $rowData['Sim_Num_Tel']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_Num_Serie'])&&$rowData['Sim_Num_Serie']!=''){ ?><strong>SIM - Numero Serie : </strong><?php echo $rowData['Sim_Num_Serie']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_Compania'])&&$rowData['Sim_Compania']!=''){ ?><strong>SIM - Compañia : </strong><?php echo $rowData['Sim_Compania']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_marca'])&&$rowData['Sim_marca']!=''){ ?><strong>BAM - Marca : </strong><?php echo $rowData['Sim_marca']; ?><br/><?php } ?>
							<?php if(isset($rowData['Sim_modelo'])&&$rowData['Sim_modelo']!=''){ ?><strong>BAM - Modelo : </strong><?php echo $rowData['Sim_modelo']; ?><br/><?php } ?>
							<?php if(isset($rowData['IP_Client'])&&$rowData['IP_Client']!=''){ ?><strong>IP Cliente : </strong><?php echo $rowData['IP_Client']; ?><br/><?php } ?>
							<?php if(isset($rowData['idTelemetria'])&&$rowData['idTelemetria']!=''){ ?><strong>ID Equipo : </strong><?php echo $rowData['idTelemetria']; ?><br/><?php } ?>
						</p>

						<h2 class="text-primary">Datos de Configuracion</h2>
						<p class="text-muted">
							<?php if($rowData['id_Sensores']==1){ ?>
							<strong>Cantidad de Sensores : </strong><?php echo $rowData['cantSensores']; ?><br/>
							<?php } ?>
							<strong>Tiempo Fuera Linea Maximo : </strong><?php echo $rowData['TiempoFueraLinea']; ?> Horas<br/>
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
								<a target="_blank" rel="noopener noreferrer" href="<?php echo 'telemetria_gestion_sensores_view_equipo_mediciones.php?view='.simpleDecode($_GET['view'], fecha_actual()).'&cantSensores='.$rowMed['cantSensores']; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Ver Ubicación</a>
								<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_registro_sensores_2.php?view='.simpleDecode($_GET['view'], fecha_actual()); ?>" class="btn btn-default pull-right margin_width fmrbtn" >Informe Medicion Sensores</a>
								<div style="padding-bottom:10px;padding-top:10px;"></div>
							</div>

							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>#</th>
										<th>Nombre</th>
										<th>Grupo</th>
										<th>Fecha/hora</th>
										<th>Medicion Actual</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
										//solo sensores activos
										if(isset($rowMed['SensoresActivo_'.$i])&&$rowMed['SensoresActivo_'.$i]==1){ ?>
											<tr class="odd">
												<td><?php echo 's'.$i ?></td>
												<td><?php echo $rowMed['SensoresNombre_'.$i]; ?></td>
												<td><?php echo $grupo[$rowMed['SensoresGrupo_'.$i]]['Nombre']; ?></td>
												<td><?php echo fecha_estandar($rowMed['LastUpdateFecha']).' - '.$rowMed['LastUpdateHora'].' hrs'; ?></td>
												<td><?php
												if(isset($rowMed['SensoresMedActual_'.$i])&&$rowMed['SensoresMedActual_'.$i]<99900){
													echo Cantidades_decimales_justos($rowMed['SensoresMedActual_'.$i]).' '.$unimed[$rowMed['SensoresUniMed_'.$i]]['Nombre'];
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

			<div class="tab-pane fade" id="flinea">
				<div class="wmd-panel">
					<div class="table-responsive">

						<div class="form-group" style="padding-top:10px;padding-bottom:10px;">
							<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_fuera_linea_2.php?idTelemetria='.simpleDecode($_GET['view'], fecha_actual()).'&submit_filter=Filtrar'; ?>" class="btn btn-default pull-right margin_width fmrbtn" >Abrir Reporte</a>
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
									<th>Ubicación</th>
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
										<td>
											<div class="btn-group" style="width: 35px;" >
												<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_fuera_linea_2_view.php?view='.$error['idFueraLinea']; ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="error999">
				<div class="wmd-panel">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Descripcion</th>
									<th>Fecha</th>
									<th>Hora</th>
									<th>Valor</th>
									<th>Ubicación</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrAlertas999 as $error) { ?>
									<tr>
										<td><?php echo $error['Descripcion']; ?></td>
										<td><?php echo fecha_estandar($error['Fecha']); ?></td>
										<td><?php echo $error['Hora']; ?></td>
										<td><?php echo Cantidades_decimales_justos($error['Valor']).' '.$unimed[$error['SensoresUniMed_'.$error['Sensor']]]['Nombre']; ?></td>
										<td>
											<div class="btn-group" style="width: 35px;" >
												<a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_telemetria_errores_2_view.php?view='.$error['idErrores']; ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="gps0">
				<div class="wmd-panel">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Fecha</th>
									<th>Hora</th>
									<th>Horas de diferencia</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrGPS0 as $error) { ?>
									<tr>
										<td><?php echo fecha_estandar($error['Fecha']); ?></td>
										<td><?php echo $error['Hora']; ?></td>
										<td><?php echo $error['Diferencia']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					</div>
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
