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
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
// consulto los datos
$SIS_query = '
vehiculos_listado.Direccion_img,

vehiculos_listado.Nombre,
vehiculos_listado.Marca,
vehiculos_listado.Modelo,
vehiculos_listado.Num_serie,
vehiculos_listado.AnoFab,
vehiculos_listado.Patente,
vehiculos_listado.idOpciones_1,
vehiculos_listado.idOpciones_2,
vehiculos_listado.idOpciones_3,
vehiculos_listado.idOpciones_4,
vehiculos_listado.idOpciones_5,
vehiculos_listado.idOpciones_7,
vehiculos_listado.idOpciones_8,
vehiculos_listado.Capacidad,
vehiculos_listado.MCubicos,
vehiculos_listado.CapacidadPersonas,
vehiculos_listado.LimiteVelocidad,
vehiculos_listado.AlertLimiteVelocidad,

vehiculos_listado.doc_mantencion,
vehiculos_listado.doc_padron,
vehiculos_listado.doc_permiso_circulacion,
vehiculos_listado.doc_resolucion_sanitaria,
vehiculos_listado.doc_revision_tecnica,
vehiculos_listado.doc_seguro_carga,
vehiculos_listado.doc_soap,
vehiculos_listado.doc_cert_trans_personas,
vehiculos_listado.doc_ficha_tecnica,

vehiculos_listado.doc_fecha_mantencion,
vehiculos_listado.doc_fecha_permiso_circulacion,
vehiculos_listado.doc_fecha_resolucion_sanitaria,
vehiculos_listado.doc_fecha_revision_tecnica,
vehiculos_listado.doc_fecha_seguro_carga,
vehiculos_listado.doc_fecha_soap,
vehiculos_listado.doc_fecha_cert_trans_personas,

core_sistemas.Nombre AS Sistema,
core_estados.Nombre AS Estado,
vehiculos_tipo.Nombre AS Tipo,
vehiculos_zonas.Nombre AS Zona,
telemetria_listado.Nombre AS Sensor,
bodegas_productos_listado.Nombre AS Bodega,
vehiculos_rutas.Nombre AS Ruta,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
core_estado_aprobacion_vehiculos.Nombre AS AprobacionEstado,
vehiculos_listado.Motivo AS AprobacionMotivo,
vehiculos_listado.idProceso,
vehiculos_tipo_carga.Nombre AS VehiculoTipoCarga';
$SIS_join  = '
LEFT JOIN `core_sistemas`                      ON core_sistemas.idSistema                     = vehiculos_listado.idSistema
LEFT JOIN `core_estados`                       ON core_estados.idEstado                       = vehiculos_listado.idEstado
LEFT JOIN `vehiculos_tipo`                     ON vehiculos_tipo.idTipo                       = vehiculos_listado.idTipo
LEFT JOIN `vehiculos_zonas`                    ON vehiculos_zonas.idZona                      = vehiculos_listado.idZona
LEFT JOIN `telemetria_listado`                 ON telemetria_listado.idTelemetria             = vehiculos_listado.idTelemetria
LEFT JOIN `bodegas_productos_listado`          ON bodegas_productos_listado.idBodega          = vehiculos_listado.idBodega
LEFT JOIN `vehiculos_rutas`                    ON vehiculos_rutas.idRuta                      = vehiculos_listado.idRuta
LEFT JOIN `trabajadores_listado`               ON trabajadores_listado.idTrabajador           = vehiculos_listado.idTrabajador
LEFT JOIN `core_estado_aprobacion_vehiculos`   ON core_estado_aprobacion_vehiculos.idProceso  = vehiculos_listado.idProceso
LEFT JOIN `vehiculos_tipo_carga`               ON vehiculos_tipo_carga.idTipoCarga            = vehiculos_listado.idTipoCarga';
$SIS_where = 'vehiculos_listado.idVehiculo ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'vehiculos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');


if(isset($rowData['idOpciones_5'])&&$rowData['idOpciones_5']==1){

	// Se trae un listado con todos los pasajeros
	$SIS_query = '
	apoderados_listado_hijos.Nombre,
	apoderados_listado_hijos.ApellidoPat,
	apoderados_listado_hijos.ApellidoMat,
	apoderados_listado_hijos.Direccion_img,
	core_sexo.Nombre AS Sexo,
	sistema_planes.Nombre AS PlanNombre,
	sistema_planes.Valor AS PlanValor';
	$SIS_join  = '
	LEFT JOIN `core_sexo`       ON core_sexo.idSexo       = apoderados_listado_hijos.idSexo
	LEFT JOIN `sistema_planes`  ON sistema_planes.idPlan  = apoderados_listado_hijos.idPlan';
	$SIS_where = 'apoderados_listado_hijos.idVehiculo ='.$X_Puntero;
	$SIS_order = 'apoderados_listado_hijos.idHijos ASC';
	$arrCargas = array();
	$arrCargas = db_select_array (false, $SIS_query, 'apoderados_listado_hijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCargas');

}


if(isset($rowData['idOpciones_7'])&&$rowData['idOpciones_7']==1){

	// consulto los datos
	$SIS_query = 'idPeoneta, Nombre,ApellidoPat, ApellidoMat, Rut, Fecha';
	$SIS_join  = '';
	$SIS_where = 'idVehiculo ='.$X_Puntero;
	$SIS_order = 'ApellidoPat ASC, ApellidoMat ASC, Nombre ASC';
	$arrPeonetas = array();
	$arrPeonetas = db_select_array (false, $SIS_query, 'vehiculos_listado_peonetas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPeonetas');

}

if(isset($rowData['idOpciones_8'])&&$rowData['idOpciones_8']==1){

	// Se trae un listado con todos los colegios
	$SIS_query = 'colegios_listado.Nombre';
	$SIS_join  = 'LEFT JOIN `colegios_listado` ON colegios_listado.idColegio = vehiculos_listado_colegios.idColegio';
	$SIS_where = 'vehiculos_listado_colegios.idVehiculo ='.$X_Puntero;
	$SIS_order = 'colegios_listado.Nombre ASC';
	$arrColegios = array();
	$arrColegios = db_select_array (false, $SIS_query, 'vehiculos_listado_colegios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrColegios');

}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del vehiculo</h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/car_siluete.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Tipo : </strong><?php echo $rowData['Tipo']; ?><br/>
							<strong>Marca : </strong><?php echo $rowData['Marca']; ?><br/>
							<strong>Modelo : </strong><?php echo $rowData['Modelo']; ?><br/>
							<strong>Numero de serie : </strong><?php echo $rowData['Num_serie']; ?><br/>
							<strong>Año de Fabricacion : </strong><?php echo $rowData['AnoFab']; ?><br/>
							<strong>Patente : </strong><?php echo $rowData['Patente']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowData['Sistema']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?>
							<?php
							//se verifica si telemetria esta activo y se muestra
							if(isset($rowData['idOpciones_1'])&&$rowData['idOpciones_1']==1){
								echo '<br/><strong>Sensor Telemetrico : </strong>'.$rowData['Sensor'];
							}
							//se verifica si bodega esta activo y se muestra
							if(isset($rowData['idOpciones_2'])&&$rowData['idOpciones_2']==1){
								echo '<br/><strong>Bodega : </strong>'.$rowData['Bodega'];
							}
							//se verifica si ruta esta activo y se muestra
							if(isset($rowData['idOpciones_3'])&&$rowData['idOpciones_3']==1){
								echo '<br/><strong>Ruta : </strong>'.$rowData['Ruta'];
							}
							//se verifica si trabajador esta activo y se muestra
							if(isset($rowData['idOpciones_4'])&&$rowData['idOpciones_4']==1){
								echo '<br/><strong>Trabajador asignado: </strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat'];
							}
							//se verifica el estado de aprobacion
							if(isset($rowData['AprobacionEstado'])&&$rowData['AprobacionEstado']!=''){
								echo '<br/><strong>Proceso Aprobacion: </strong>'.$rowData['AprobacionEstado'];
								if(isset($rowData['idProceso'])&&$rowData['idProceso']==3){echo ' ('.$rowData['AprobacionMotivo'].')';}
							} ?>

						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Caracteristicos</h2>
						<p class="text-muted">
							<strong>Zona de Trabajo : </strong><?php echo $rowData['Zona']; ?><br/>
							<strong>Capacidad Pasajeros : </strong><?php echo $rowData['CapacidadPersonas']; ?><br/>
							<strong>Capacidad (Kilos) : </strong><?php echo Cantidades_decimales_justos($rowData['Capacidad']); ?><br/>
							<strong>Metros Cubicos (M3) : </strong><?php echo Cantidades_decimales_justos($rowData['MCubicos']); ?><br/>
							<strong>Tipo de Carga : </strong><?php echo $rowData['VehiculoTipoCarga']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Movilizacion</h2>
						<p class="text-muted">
							<strong>Velocidad Maxima : </strong><?php echo Cantidades_decimales_justos($rowData['LimiteVelocidad']); ?><br/>
							<strong>N° Maximo Alertas de Velocidad : </strong><?php echo $rowData['AlertLimiteVelocidad']; ?><br/>
						</p>

						<?php if(isset($rowData['idOpciones_6'])&&$rowData['idOpciones_6']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de acceso a la APP</h2>
							<p class="text-muted">
								<strong>Usuario : </strong><?php echo $rowData['Patente']; ?><br/>
								<strong>Password : </strong><?php echo $rowData['Password']; ?><br/>
							</p>
						<?php } ?>

						<?php
						//Se verifica si se transportan personas
						if(isset($rowData['idOpciones_5'])&&$rowData['idOpciones_5']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Personas Transportadas</h2>
							<div class="row">
								<?php
								//Se existen cargas estas se despliegan
								if($arrCargas!=false){
									//variable
									$n_carga = 1;
									//recorro
									foreach ($arrCargas as $carga) { ?>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
											<div class="info-box" style="box-shadow:none; color:#999 !important;">
												<span class="info-box-icon">
													 <img src="upload/<?php echo $carga['Direccion_img']; ?>" alt="hijo" height="100%" width="100%"> 
												</span>
												<div class="info-box-content">
													<span class="info-box-text"><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></span>
													<span class="info-box-text"><?php echo $carga['Sexo']; ?></span>
													<span class="info-box-number"><?php echo $carga['PlanNombre']; ?></span>
												</div>
											</div>
										</div>

									<?php
									}
								//si no existen cargas se muestra mensaje
								}else{
									echo '<p class="text-muted">Sin personas asignadas</p>';
								}
								?>
							</div>
							<div class="clearfix"></div>
						<?php } ?>

						<?php
						//Se verifica si se tiene peonetas
						if(isset($rowData['idOpciones_7'])&&$rowData['idOpciones_7']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Peonetas Asignados</h2>
							<p class="text-muted">
								<?php
								//Verifico el total de peonetas
								$nn     = 0;
								$n_peon = 1;
								foreach ($arrPeonetas as $peoneta) {
									$nn++;
								}
								//Se existen peonetas estas se despliegan
								if($nn!=0){
									foreach ($arrPeonetas as $peoneta) {
										echo '<strong>Peoneta #'.$n_peon.' : </strong>'.$peoneta['Nombre'].' '.$peoneta['ApellidoPat'].' '.$peoneta['ApellidoMat'].'<br/>';
										$n_peon++;
									}
								//si no existen peonetas se muestra mensaje
								}else{
									echo '<p class="text-muted">Sin peonetas asignados</p>';
								}
								?>
							</p>
						<?php } ?>

						<?php //se verifica si se tiene colegios
						if(isset($rowData['idOpciones_8'])&&$rowData['idOpciones_8']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Colegios Asignados</h2>
							<table id="items" style="margin-bottom: 20px;">
								<tbody>
									<?php foreach ($arrColegios as $colegio) { ?>
										<tr class="item-row">
											<td><?php $colegio['NombreColegio']; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php } ?>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php
								//Fecha ultima mantencion
								if(isset($rowData['doc_mantencion'])&&$rowData['doc_mantencion']!=''){
									echo '
										<tr class="item-row">
											<td>Fecha ultima mantencion (vence el '.fecha_estandar($rowData['doc_fecha_mantencion']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_mantencion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_mantencion'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Padron del Vehiculo
								if(isset($rowData['doc_padron'])&&$rowData['doc_padron']!=''){
									echo '
										<tr class="item-row">
											<td>Padron del Vehiculo</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_padron'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_padron'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Permiso de Circulacion
								if(isset($rowData['doc_permiso_circulacion'])&&$rowData['doc_permiso_circulacion']!=''){
									echo '
										<tr class="item-row">
											<td>Permiso de Circulacion (vence el '.fecha_estandar($rowData['doc_fecha_permiso_circulacion']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_permiso_circulacion'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_permiso_circulacion'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Resolucion Sanitaria
								if(isset($rowData['doc_resolucion_sanitaria'])&&$rowData['doc_resolucion_sanitaria']!=''){
									echo '
										<tr class="item-row">
											<td>Resolucion Sanitaria (vence el '.fecha_estandar($rowData['doc_fecha_resolucion_sanitaria']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_resolucion_sanitaria'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_resolucion_sanitaria'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Revision tecnica
								if(isset($rowData['doc_revision_tecnica'])&&$rowData['doc_revision_tecnica']!=''){
									echo '
										<tr class="item-row">
											<td>Revision tecnica (vence el '.fecha_estandar($rowData['doc_fecha_revision_tecnica']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_revision_tecnica'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_revision_tecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Seguro de Carga
								if(isset($rowData['doc_seguro_carga'])&&$rowData['doc_seguro_carga']!=''){
									echo '
										<tr class="item-row">
											<td>Seguro de Carga (vence el '.fecha_estandar($rowData['doc_fecha_seguro_carga']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_seguro_carga'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_seguro_carga'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Seguro SOAP
								if(isset($rowData['doc_soap'])&&$rowData['doc_soap']!=''){
									echo '
										<tr class="item-row">
											<td>Seguro SOAP (vence el '.fecha_estandar($rowData['doc_fecha_soap']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_soap'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_soap'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Certificado Transporte Personas
								if(isset($rowData['doc_cert_trans_personas'])&&$rowData['doc_cert_trans_personas']!=''){
									echo '
										<tr class="item-row">
											<td>Certificado Transporte Personas (vence el '.fecha_estandar($rowData['doc_fecha_cert_trans_personas']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_cert_trans_personas'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_cert_trans_personas'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Ficha Tecnica
								if(isset($rowData['doc_ficha_tecnica'])&&$rowData['doc_ficha_tecnica']!=''){
									echo '
										<tr class="item-row">
											<td>Ficha Tecnica</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_ficha_tecnica'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['doc_ficha_tecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								?>
							</tbody>
						</table>

					</div>
					<div class="clearfix"></div>

				</div>
			</div>

        </div>
	</div>
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
