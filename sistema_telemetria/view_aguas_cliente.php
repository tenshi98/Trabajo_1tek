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
aguas_clientes_listado.email, 
aguas_clientes_listado.Nombre,
aguas_clientes_listado.Rut, 
aguas_clientes_listado.RazonSocial, 
aguas_clientes_listado.fNacimiento, 
aguas_clientes_listado.Direccion, 
aguas_clientes_listado.Fono1, 
aguas_clientes_listado.Fono2, 
aguas_clientes_listado.Fax,
aguas_clientes_listado.PersonaContacto,
aguas_clientes_listado.PersonaContacto_Fono,
aguas_clientes_listado.PersonaContacto_email,
aguas_clientes_listado.Web,
aguas_clientes_listado.Giro,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
aguas_clientes_tipos.Nombre AS tipoCliente,
core_rubros.Nombre AS Rubro,
aguas_clientes_listado.UnidadHabitacional,
aguas_clientes_listado.Identificador,
aguas_clientes_listado.Arranque,
aguas_clientes_listado.latitud,
aguas_clientes_listado.longitud,
aguas_marcadores_listado.Nombre AS medidor,
aguas_marcadores_remarcadores.Nombre AS remarcador,
aguas_clientes_estadopago.Nombre AS EstadoPago,
aguas_clientes_facturable.Nombre AS DocFacturable,
ciudad.Nombre AS nombre_region_fact,
comuna.Nombre AS nombre_comuna_fact,
aguas_clientes_listado.DireccionFact,
aguas_clientes_listado.RazonSocial,
aguas_analisis_aguas_tipo_punto_muestreo.Nombre AS TipoPunto,
aguas_analisis_sectores.Nombre AS Sector';
$SIS_join  = '
LEFT JOIN `core_estados`                              ON core_estados.idEstado                                      = aguas_clientes_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`                     ON core_ubicacion_ciudad.idCiudad                             = aguas_clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`                    ON core_ubicacion_comunas.idComuna                            = aguas_clientes_listado.idComuna
LEFT JOIN `core_sistemas`                             ON core_sistemas.idSistema                                    = aguas_clientes_listado.idSistema
LEFT JOIN `aguas_clientes_tipos`                      ON aguas_clientes_tipos.idTipo                                = aguas_clientes_listado.idTipo
LEFT JOIN `core_rubros`                               ON core_rubros.idRubro                                        = aguas_clientes_listado.idRubro
LEFT JOIN `aguas_marcadores_listado`                  ON aguas_marcadores_listado.idMarcadores                      = aguas_clientes_listado.idMarcadores
LEFT JOIN `aguas_marcadores_remarcadores`             ON aguas_marcadores_remarcadores.idRemarcadores               = aguas_clientes_listado.idRemarcadores
LEFT JOIN `aguas_clientes_estadopago`                 ON aguas_clientes_estadopago.idEstadoPago                     = aguas_clientes_listado.idEstadoPago
LEFT JOIN `aguas_clientes_facturable`                 ON aguas_clientes_facturable.idFacturable                     = aguas_clientes_listado.idFacturable
LEFT JOIN `core_ubicacion_ciudad`   ciudad            ON ciudad.idCiudad                                            = aguas_clientes_listado.idCiudadFact
LEFT JOIN `core_ubicacion_comunas`  comuna            ON comuna.idComuna                                            = aguas_clientes_listado.idComunaFact
LEFT JOIN `aguas_analisis_aguas_tipo_punto_muestreo`  ON aguas_analisis_aguas_tipo_punto_muestreo.idPuntoMuestreo   = aguas_clientes_listado.idPuntoMuestreo
LEFT JOIN `aguas_analisis_sectores`                   ON aguas_analisis_sectores.idSector                           = aguas_clientes_listado.idSector';
$SIS_where = 'aguas_clientes_listado.idCliente ='.$X_Puntero;
$rowSistema = db_select_data (false, $SIS_query, 'aguas_clientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'cron');

/**********************************************************/
// consulto los datos
$SIS_query = '
usuarios_listado.Nombre AS nombre_usuario,
aguas_clientes_observaciones.Fecha,
aguas_clientes_observaciones.Observacion';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = aguas_clientes_observaciones.idUsuario';
$SIS_where = 'aguas_clientes_observaciones.idCliente ='.$X_Puntero;
$SIS_order = 'aguas_clientes_observaciones.idObservacion ASC LIMIT 15';
$arrObservaciones = array();
$arrObservaciones = db_select_array (false, $SIS_query, 'aguas_clientes_observaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrObservaciones');

/**********************************************************/
// consulto los datos
$SIS_query = '
aguas_clientes_pago.idPago,
aguas_facturacion_listado_detalle_tipo_pago.Nombre AS TipoPago,
aguas_clientes_pago.nDocPago,
aguas_clientes_pago.fechaPago,
aguas_clientes_pago.montoPago';
$SIS_join  = 'LEFT JOIN `aguas_facturacion_listado_detalle_tipo_pago` ON aguas_facturacion_listado_detalle_tipo_pago.idTipoPago = aguas_clientes_pago.idTipoPago';
$SIS_where = 'aguas_clientes_pago.idCliente ='.$X_Puntero;
$SIS_order = 'aguas_clientes_pago.fechaPago DESC LIMIT 30';
$arrPagos = array();
$arrPagos = db_select_array (false, $SIS_query, 'aguas_clientes_pago', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPagos');

/**********************************************************/
// consulto los datos
$SIS_query = '
aguas_facturacion_listado_detalle.idFacturacionDetalle,
aguas_facturacion_listado_detalle.DetalleTotalAPagar, 
aguas_facturacion_listado_detalle.AguasInfFechaEmision,
aguas_facturacion_listado_detalle.idMes,
aguas_facturacion_listado_detalle.Ano,
aguas_facturacion_listado_detalle.DetalleConsumoCantidad,
aguas_facturacion_listado_detalle.DetalleRecoleccionCantidad,
aguas_facturacion_listado_detalle.fechaPago,
aguas_facturacion_listado_detalle.montoPago,
aguas_facturacion_listado_detalle.SII_NDoc,
aguas_clientes_facturable.Nombre AS Facturable,
aguas_facturacion_listado_detalle_estado.Nombre AS Estado,
aguas_facturacion_listado_detalle.idPago,
aguas_facturacion_listado_detalle.DetalleSaldoAnterior';
$SIS_join  = '
LEFT JOIN `aguas_facturacion_listado_detalle_estado`  ON aguas_facturacion_listado_detalle_estado.idEstado   = aguas_facturacion_listado_detalle.idEstado
LEFT JOIN `aguas_clientes_facturable`                 ON aguas_clientes_facturable.idFacturable              = aguas_facturacion_listado_detalle.SII_idFacturable';
$SIS_where = 'aguas_facturacion_listado_detalle.idCliente ='.$X_Puntero;
$SIS_order = 'aguas_facturacion_listado_detalle.Ano DESC, aguas_facturacion_listado_detalle.idMes DESC LIMIT 30';
$arrFacturaciones = array();
$arrFacturaciones = db_select_array (false, $SIS_query, 'aguas_facturacion_listado_detalle', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFacturaciones');

/**********************************************************/
// consulto los datos
$SIS_query = 'idMes, Ano, DetalleConsumoCantidad, DetalleRecoleccionCantidad';
$SIS_join  = '';
$SIS_where = 'idCliente ='.$X_Puntero;
$SIS_order = 'BY Ano ASC, idMes ASC LIMIT 12';
$arrConsumos = array();
$arrConsumos = db_select_array (false, $SIS_query, 'aguas_facturacion_listado_detalle', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrConsumos');

/**********************************************************/
// consulto los datos
$SIS_query = '
aguas_clientes_tipos.Nombre AS TipoEvento,
aguas_clientes_eventos.FechaEjecucion,
aguas_clientes_eventos.Observacion,
aguas_clientes_eventos.ValorEvento';
$SIS_join  = 'LEFT JOIN `aguas_clientes_tipos` ON aguas_clientes_tipos.idTipo = aguas_clientes_eventos.idTipo';
$SIS_where = 'aguas_clientes_eventos.idCliente ='.$X_Puntero;
$SIS_order = 'aguas_clientes_eventos.Fecha DESC LIMIT 30';
$arrEventos = array();
$arrEventos = db_select_array (false, $SIS_query, 'aguas_clientes_eventos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEventos');

/**********************************************************/
// consulto los datos
$SIS_query = 'FechaEjecucion, Observacion, ValorCargo';
$SIS_join  = '';
$SIS_where = 'idCliente ='.$X_Puntero;
$SIS_order = 'Fecha DESC LIMIT 30';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'aguas_clientes_otros_cargos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOtros');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Cliente</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<?php if($arrObservaciones!=false && !empty($arrObservaciones) && $arrObservaciones!=''){ ?>
					<li class=""><a href="#observaciones" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
				<?php } ?>
				<?php if($arrConsumos!=false && !empty($arrConsumos) && $arrConsumos!=''){ ?>
					<li class=""><a href="#Consumos" data-toggle="tab"><i class="fa fa-share-alt" aria-hidden="true"></i> Consumos</a></li>
				<?php } ?>
				<?php if($arrPagos!=false && !empty($arrPagos) && $arrPagos!=''){ ?>
					<li class=""><a href="#Pagos" data-toggle="tab"><i class="fa fa-usd" aria-hidden="true"></i> Pagos</a></li>
				<?php } ?>
				<?php if($arrFacturaciones!=false && !empty($arrFacturaciones) && $arrFacturaciones!=''){ ?>
					<li class=""><a href="#Facturaciones" data-toggle="tab"><i class="fa fa-folder-open" aria-hidden="true"></i> Facturaciones</a></li>
				<?php } ?>
				<?php if($arrEventos!=false && !empty($arrEventos) && $arrEventos!=''){ ?>
					<li class=""><a href="#Eventos" data-toggle="tab"><i class="fa fa-flag" aria-hidden="true"></i> Eventos</a></li>
				<?php } ?>
				<?php if($arrOtrosCobros!=false && !empty($arrOtrosCobros) && $arrOtrosCobros!=''){ ?>
					<li class=""><a href="#OtrosCobros" data-toggle="tab"><i class="fa fa-usd" aria-hidden="true"></i> Otros Cobros</a></li>
				<?php } ?>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Cliente : </strong><?php echo $rowData['tipoCliente']; ?><br/>
								<strong>Nombre: </strong><?php echo $rowData['Nombre']; ?><br/>
								<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
								<strong>Fecha de Ingreso Sistema : </strong><?php echo Fecha_completa($rowData['fNacimiento']); ?><br/>
								<strong>Región : </strong><?php echo $rowData['nombre_region']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowData['nombre_comuna']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
								<strong>Sistema Relacionado : </strong><?php echo $rowData['sistema']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['estado']; ?>
							</p>
											
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
							<p class="text-muted word_break">
								<strong>Telefono Fijo : </strong><?php echo formatPhone($rowData['Fono1']); ?><br/>
								<strong>Telefono Movil : </strong><?php echo formatPhone($rowData['Fono2']); ?><br/>
								<strong>Fax : </strong><?php echo $rowData['Fax']; ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowData['email']; ?>"><?php echo $rowData['email']; ?></a><br/>
								<strong>Web : </strong><a target="_blank" rel="noopener noreferrer" href="https://<?php echo $rowData['Web']; ?>"><?php echo $rowData['Web']; ?></a>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Persona de Contacto</h2>
							<p class="text-muted word_break">
								<strong>Persona de Contacto : </strong><?php echo $rowData['PersonaContacto']; ?><br/>
								<strong>Telefono : </strong><?php echo formatPhone($rowData['PersonaContacto_Fono']); ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowData['PersonaContacto_email']; ?>"><?php echo $rowData['PersonaContacto_email']; ?></a><br/>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Facturacion</h2>
							<p class="text-muted word_break">
								<strong>Identificador : </strong><?php echo $rowData['Identificador']; ?><br/>
								<strong>ID medidor : </strong><?php echo $rowData['medidor']; ?><br/>
								<strong>ID remarcador : </strong><?php echo $rowData['remarcador']; ?><br/>
								<strong>Unidades Habitacionales : </strong><?php echo $rowData['UnidadHabitacional']; ?><br/>
								<strong>Arranque : </strong><?php echo $rowData['Arranque']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['EstadoPago']; ?><br/>
								<strong>Forma Facturacion : </strong><?php echo $rowData['DocFacturable']; ?><br/>
								<strong>Región Facturacion : </strong><?php echo $rowData['nombre_region_fact']; ?><br/>
								<strong>Ciudad Facturacion : </strong><?php echo $rowData['nombre_comuna_fact']; ?><br/>
								<strong>Dirección Facturacion : </strong><?php echo $rowData['DireccionFact']; ?><br/>
								<strong>Giro de la empresa : </strong><?php echo $rowData['Giro']; ?><br/>
								<strong>Rubro de la empresa : </strong><?php echo $rowData['Rubro']; ?><br/>
								<strong>Razón Social de la empresa : </strong><?php echo $rowData['RazonSocial']; ?><br/>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Medicion</h2>
							<p class="text-muted word_break">
								<strong>Sector : </strong><?php echo $rowData['Sector']; ?><br/>
								<strong>Tipo de Medicion : </strong><?php echo $rowData['TipoPunto']; ?><br/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row">
						<?php
							//se despliega mensaje en caso de no existir dirección
							if($rowData["latitud"]!=0 && $rowData["longitud"]!=0){
								echo mapa_from_gps($rowData["latitud"], $rowData["longitud"], $rowData['Identificador'], $rowData['Nombre'], $rowData['Direccion'], $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1);
							}else{
								$Alert_Text = 'No tiene latitud y longitud definida';
								alert_post_data(4,2,2,0, $Alert_Text);
							}
						?>
					</div>
				</div>
				<div class="clearfix"></div>

			</div>

			<?php if($arrObservaciones!=false && !empty($arrObservaciones) && $arrObservaciones!=''){ ?>
				<div class="tab-pane fade" id="observaciones">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Autor</th>
										<th width="120">Fecha</th>
										<th>Observacion</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrObservaciones as $observaciones){ ?>
										<tr class="odd">
											<td><?php echo $observaciones['nombre_usuario']; ?></td>
											<td><?php echo $observaciones['Fecha']; ?></td>
											<td class="word_break"><?php echo $observaciones['Observacion']; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrConsumos!=false && !empty($arrConsumos) && $arrConsumos!=''){ ?>
				<div class="tab-pane fade" id="Consumos">
					<div class="wmd-panel">

						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<script>
							google.charts.load('current', {packages: ['corechart', 'bar']});
							google.charts.setOnLoadCallback(drawAnnotations);

							function drawAnnotations() {
								var data = new google.visualization.DataTable();
								data.addColumn('string', 'Fecha');
								data.addColumn('number', 'Consumo');
								data.addColumn({type: 'string', role: 'annotation'});
								data.addColumn('number', 'Recoleccion');
								data.addColumn({type: 'string', role: 'annotation'});

								data.addRows([
									<?php foreach ($arrConsumos as $fac) { ?>
										['<?php echo numero_a_mes($fac['idMes']).' '.$fac['Ano']; ?>',   <?php echo $fac['DetalleConsumoCantidad']; ?>, '<?php echo cantidades($fac['DetalleConsumoCantidad'],0); ?>',  <?php echo $fac['DetalleRecoleccionCantidad']; ?>, '<?php echo cantidades($fac['DetalleRecoleccionCantidad'],0); ?>'],
									<?php } ?>
								]);

								var options = {
									title: 'Consumos Ultimos Meses',
									//width: $(window).width()*0.75,
									height: 500,
									annotations: {
										alwaysOutside: true,
										textStyle: {
											fontSize: 14,
											color: '#000',
											auraColor: 'none'
										}
									},
									hAxis: { title: 'Meses', },
									vAxis: { title: 'Comsumos m3', minValue: 0 },
								};

								var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
								chart.draw(data, options);
							}
						</script>
						<div id="chart_div" style="height: 500px;"></div>

					</div>
				</div>
			<?php } ?>

			<?php if($arrPagos!=false && !empty($arrPagos) && $arrPagos!=''){ ?>
				<div class="tab-pane fade" id="Pagos">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th width="120">N° Transaccion</th>
										<th width="120">Fecha</th>
										<th>Forma de Pago</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrPagos as $pagos) { ?>
										<tr class="odd">
											<td><?php echo n_doc($pagos['idPago'], 8); ?></td>
											<td><?php echo fecha_estandar($pagos['fechaPago']); ?></td>
											<td><?php echo $pagos['TipoPago'].' '.$pagos['nDocPago']; ?></td>
											<td align="right"><?php echo valores($pagos['montoPago'], 0); ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrFacturaciones!=false && !empty($arrFacturaciones) && $arrFacturaciones!=''){ ?>
				<div class="tab-pane fade" id="Facturaciones">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Fecha</th>
										<th>Valor</th>
										<th>Saldo Anterior</th>
										<th>Estado</th>
										<th>SII</th>
										<th width="120">N° Transaccion</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrFacturaciones as $fac) { ?>
										<tr class="odd">
											<td>
												<a href="<?php echo 'view_aguas_facturacion.php?view='.simpleEncode($fac['idFacturacionDetalle'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" data-placement="bottom" title="Ver Información" data-toggle="tooltip" class="btn btn-primary btn-sm info-tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												<?php echo numero_a_mes($fac['idMes']).' '.$fac['Ano']; ?>
											</td>
											<td align="right"><?php echo Valores($fac['DetalleTotalAPagar'], 0); ?></td>
											<td align="right"><?php echo Valores($fac['DetalleSaldoAnterior'], 0); ?></td>
											<td><?php echo $fac['Estado'];
											if($fac['fechaPago']!='0000-00-00'){
												echo ' ('.fecha_estandar($fac['fechaPago']).' -> '.Valores($fac['montoPago'], 0).')';
											}
											 ?></td>
											<td><?php echo $fac['Facturable'].' '.$fac['SII_NDoc']; ?></td>
											<td><?php if($fac['idPago']!=0){echo n_doc($fac['idPago'], 8);} ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrEventos!=false && !empty($arrEventos) && $arrEventos!=''){ ?>
				<div class="tab-pane fade" id="Eventos">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Fecha</th>
										<th>Tipo</th>
										<th>Observacion</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrEventos as $eventos) { ?>
										<tr class="odd">
											<td><?php echo  fecha_estandar($eventos['FechaEjecucion']); ?></td>
											<td><?php echo  $eventos['TipoEvento']; ?></td>
											<td><?php echo  $eventos['Observacion']; ?></td>
											<td align="right"><?php echo  Valores($eventos['ValorEvento'], 0); ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrOtrosCobros!=false && !empty($arrOtrosCobros) && $arrOtrosCobros!=''){ ?>
				<div class="tab-pane fade" id="OtrosCobros">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Fecha</th>
										<th>Observacion</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrOtros as $otros) { ?>
										<tr class="odd">
											<td><?php echo  fecha_estandar($otros['FechaEjecucion']); ?></td>
											<td><?php echo  $otros['Observacion']; ?></td>
											<td align="right"><?php echo  Valores($otros['ValorCargo'], 0); ?></td>
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
