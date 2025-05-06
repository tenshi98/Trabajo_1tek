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
$original = "informe_cross_checking_04.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
$location .= "?submit_filter=Filtrar";
if(isset($_GET['idSolicitud']) && $_GET['idSolicitud']!=''){ $location .= "&idSolicitud=".$_GET['idSolicitud'];        $search .= "&idSolicitud=".$_GET['idSolicitud'];}
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $location .= "&NSolicitud=".$_GET['NSolicitud'];          $search .= "&NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $location .= "&idPredio=".$_GET['idPredio'];              $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $location .= "&idZona=".$_GET['idZona'];                  $search .= "&idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $location .= "&idTemporada=".$_GET['idTemporada'];        $search .= "&idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $location .= "&idEstadoFen=".$_GET['idEstadoFen'];        $search .= "&idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $location .= "&idCategoria=".$_GET['idCategoria'];        $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $location .= "&idProducto=".$_GET['idProducto'];          $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $location .= "&idUsuario=".$_GET['idUsuario'];            $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$search .="&f_programacion_desde=".$_GET['f_programacion_desde'];
	$search .="&f_programacion_hasta=".$_GET['f_programacion_hasta'];
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$search .="&f_ejecucion_desde=".$_GET['f_ejecucion_desde'];
	$search .="&f_ejecucion_hasta=".$_GET['f_ejecucion_hasta'];
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$search .="&f_termino_desde=".$_GET['f_termino_desde'];
	$search .="&f_termino_hasta=".$_GET['f_termino_hasta'];
}     
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
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
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idEstado=3";//solo terminadas
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idSolicitud']) && $_GET['idSolicitud']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idSolicitud=".$_GET['idSolicitud'];}
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado_cuarteles.idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_programacion BETWEEN '".$_GET['f_programacion_desde']."' AND '".$_GET['f_programacion_hasta']."'";
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_ejecucion BETWEEN '".$_GET['f_ejecucion_desde']."' AND '".$_GET['f_ejecucion_hasta']."'";
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_termino BETWEEN '".$_GET['f_termino_desde']."' AND '".$_GET['f_termino_hasta']."'";
}
/**********************************************************/
// Se trae un listado con todos los datos separados por tractores
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre,

cross_predios_listado.Nombre AS PredioNombre,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.Plantas AS CuartelCantPlantas,
cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,

telemetria_listado.Nombre AS TractorNombre,
cross_solicitud_aplicacion_listado_tractores.idTractores,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,
cross_solicitud_aplicacion_listado_tractores.GeoDistance,
cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_3_Min,
cross_solicitud_aplicacion_listado_tractores.Sensor_3_Max,
cross_solicitud_aplicacion_listado_tractores.idTelemetria,
cross_solicitud_aplicacion_listado_tractores.Diferencia,

cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin_out,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax_out,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm_out,
cross_solicitud_aplicacion_listado_tractores.GeoDistance_out,
cross_solicitud_aplicacion_listado_tractores.Sensor_out_1_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_out_2_Prom,
cross_solicitud_aplicacion_listado_tractores.Diferencia_out,

cross_solicitud_aplicacion_listado_cuarteles.VelTractor';
$SIS_join  = '
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                            = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto';
$SIS_order = 'cross_solicitud_aplicacion_listado.idSolicitud DESC, cross_predios_listado_zonas.Nombre ASC';
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');



filtrar($arrOTS, 'idTelemetria');

/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre,

cross_predios_listado.Nombre AS PredioNombre,

cross_solicitud_aplicacion_listado.idSolicitud AS IDD,
(SELECT SUM(cross_predios_listado_zonas.Plantas) 
FROM `cross_solicitud_aplicacion_listado_cuarteles` 
LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD ) AS CuartelCantPlantas,

(SELECT AVG(cross_predios_listado_zonas.DistanciaPlant) 
FROM `cross_solicitud_aplicacion_listado_cuarteles` 
LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD ) AS CuartelDistanciaPlant,

AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm!=0,cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,0),0)) AS GeoVelocidadProm,
SUM(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoDistance!=0,cross_solicitud_aplicacion_listado_tractores.GeoDistance,0),0)) AS GeoDistance,
AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom,0),0)) AS Sensor_1_Prom,
AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom,0),0)) AS Sensor_2_Prom';
$SIS_join  = '
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles';
$SIS_where.=' GROUP BY cross_solicitud_aplicacion_listado.idSolicitud';
$SIS_order = 'cross_solicitud_aplicacion_listado.idSolicitud DESC';
$arrSolicitudes = array();
$arrSolicitudes = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSolicitudes');

									
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen de Solicitudes de Aplicacion</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#data_main" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen Solicitudes</a></li>
				<?php
				foreach ($arrOTS as $categoria=>$subcategorias) { ?>
					<li class=""><a href="#data_tab_<?php echo $categoria; ?>" data-toggle="tab"><i class="fa fa-asterisk" aria-hidden="true"></i> <?php echo $subcategorias[0]['TractorNombre']; ?></a></li>
				<?php } ?>
			</ul>

		</header>
		<div class="tab-content">

			<div class="tab-pane fade active in" id="data_main">
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th colspan="3" style="text-align: center;">Identificación</th>
								<th colspan="1" style="text-align: center;">Velocidad Tractor (Km/hr)</th>
								<th colspan="2" style="text-align: center;">Promedio Caudales</th>
								<th colspan="2" style="text-align: center;">Plantas</th>
								<th width="10">Acciones</th>
							</tr>
							<tr role="row">
								<th>N° Solicitud</th>
								<th>Fecha</th>
								<th>Predio</th>

								<th>Promedio</th>

								<th>Derecho</th>
								<th>Izquierdo</th>

								<th>Totales</th>
								<th>Pendientes</th>

								<th width="10">Acciones</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrSolicitudes as $ot) { ?>
								<tr class="odd">
									<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
									<td><?php echo Fecha_estandar($ot['f_cierre']); ?></td>
									<td><?php echo $ot['PredioNombre']; ?></td>

									<td><?php echo Cantidades($ot['GeoVelocidadProm'], 1); ?></td>

									<td><?php echo Cantidades($ot['Sensor_1_Prom'], 2); ?></td>
									<td><?php echo Cantidades($ot['Sensor_2_Prom'], 2); ?></td>

									<td><?php echo Cantidades($ot['CuartelCantPlantas'], 0); ?></td>
									<td>
										<?php 
										//se verifica plantas faltantes
										if(isset($ot['GeoDistance'])&&$ot['GeoDistance']!=0&&isset($ot['CuartelDistanciaPlant'])&&$ot['CuartelDistanciaPlant']!=''&&$ot['CuartelDistanciaPlant']!=0){
											//$aplicadas    = ($ot['GeoDistance']*1000)/$ot['CuartelDistanciaPlant'];
											//$totalPlantas = $ot['CuartelCantPlantas'];
											//$faltante     = ($totalPlantas - $aplicadas)/$ot['CuartelDistanciaPlant'];
											$faltante     = ((($ot['CuartelDistanciaPlant']*$ot['CuartelCantPlantas']) - ($ot['GeoDistance']*1000))/$ot['CuartelDistanciaPlant']);
												
										}else{
											$faltante = 0;
										}
											
										echo Cantidades($faltante, 0); 
										?>
									</td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion_resumen.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()).'&NSolicitud='.simpleEncode($ot['NSolicitud'], fecha_actual()); ?>" title="Ver Resumen Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<?php foreach ($arrOTS as $categoria=>$subcategorias) { ?>
				<div class="tab-pane fade" id="data_tab_<?php echo $categoria; ?>">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th colspan="20" style="text-align: center;"><strong>Monitoreo dentro de cuarteles</strong></th>
								</tr>
								<tr role="row">
									<th colspan="6" style="text-align: center;">Identificación</th>
									<th colspan="4" style="text-align: center;">Velocidad Tractor (Km/hr)</th>
									<th colspan="2" style="text-align: center;">Promedio Caudales</th>
									<th colspan="1" style="text-align: center;">Litros</th>
									<th colspan="2" style="text-align: center;">Nivel Estanque</th>
									<th colspan="2" style="text-align: center;">Plantas</th>
									<th width="10">Acciones</th>
								</tr>
								<tr role="row">
									<th>N° Solicitud</th>
									<th>Fecha</th>
									<th>Predio</th>
									<th>Cuartel</th>
									<th>Especie</th>
									<th>Variedad</th>

									<th>Minima</th>
									<th>Maxima</th>
									<th>Promedio</th>
									<th>Programada</th>

									<th>Derecho</th>
									<th>Izquierdo</th>

									<th>Totales</th>

									<th>Minima</th>
									<th>Maxima</th>

									<th>Totales</th>
									<th>Pendientes</th>

									<th width="10">Acciones</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($subcategorias as $ot) { ?>
									<tr class="odd">
										<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
										<td><?php echo Fecha_estandar($ot['f_cierre']); ?></td>
										<td><?php echo $ot['PredioNombre']; ?></td>
										<td><?php echo $ot['CuartelNombre']; ?></td>
										<td><?php echo $ot['VariedadCat']; ?></td>
										<td><?php echo $ot['VariedadNombre']; ?></td>

										<td><?php echo Cantidades($ot['GeoVelocidadMin'], 1); ?></td>
										<td><?php echo Cantidades($ot['GeoVelocidadMax'], 1); ?></td>
										<td><?php echo Cantidades($ot['GeoVelocidadProm'], 1); ?></td>
										<td><?php echo Cantidades($ot['VelTractor'], 1); ?></td>

										<td><?php echo Cantidades($ot['Sensor_1_Prom'], 2); ?></td>
										<td><?php echo Cantidades($ot['Sensor_2_Prom'], 2); ?></td>

										<td><?php echo Cantidades($ot['Diferencia'], 0); ?></td>

										<td><?php echo Cantidades($ot['Sensor_3_Min'], 0); ?></td>
										<td><?php echo Cantidades($ot['Sensor_3_Max'], 0); ?></td>

										<td><?php echo Cantidades($ot['CuartelCantPlantas'], 0); ?></td>
										<td>
											<?php
											//se verifica plantas faltantes
											if(isset($ot['GeoDistance'])&&$ot['GeoDistance']!=0&&isset($ot['CuartelDistanciaPlant'])&&$ot['CuartelDistanciaPlant']!=''&&$ot['CuartelDistanciaPlant']!=0){
												//$aplicadas    = ($ot['GeoDistance']*1000)/$ot['CuartelDistanciaPlant'];
												//$totalPlantas = $ot['CuartelCantPlantas'];
												//$faltante     = ($totalPlantas - $aplicadas)/$ot['CuartelDistanciaPlant'];
												$faltante     = ((($ot['CuartelDistanciaPlant']*$ot['CuartelCantPlantas']) - ($ot['GeoDistance']*1000))/$ot['CuartelDistanciaPlant']);

											}else{
												$faltante = 0;
											}
											
											echo Cantidades($faltante, 0); 
											?>
											
										</td>

										<td>
											<div class="btn-group" style="width: 70px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion_detalles.php?view='.simpleEncode($ot['idTractores'], fecha_actual()); ?>" title="Ver Detalles Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">

							<thead>
								<tr role="row">
									<th colspan="14" style="text-align: center;"><strong>Monitoreo fuera de cuarteles</strong></th>
								</tr>
								<tr role="row">
									<th colspan="6" style="text-align: center;">Identificación</th>
									<th colspan="4" style="text-align: center;">Velocidad Tractor (Km/hr)</th>
									<th colspan="1" style="text-align: center;">Distancia Recorrida(Metros)</th>
									<th colspan="2" style="text-align: center;">Promedio Caudales</th>
									<th colspan="1" style="text-align: center;">Litros</th>
									<th width="10">Acciones</th>
								</tr>
								<tr role="row">
									<th>N° Solicitud</th>
									<th>Fecha</th>
									<th>Predio</th>
									<th>Cuartel</th>
									<th>Especie</th>
									<th>Variedad</th>

									<th>Minima</th>
									<th>Maxima</th>
									<th>Promedio</th>
									<th>Programada</th>

									<th>Recorrida</th>

									<th>Derecho</th>
									<th>Izquierdo</th>

									<th>Totales</th>

									<th width="10">Acciones</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($subcategorias as $ot) { ?>
									<tr class="odd">
										<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
										<td><?php echo Fecha_estandar($ot['f_cierre']); ?></td>
										<td><?php echo $ot['PredioNombre']; ?></td>
										<td><?php echo $ot['CuartelNombre']; ?></td>
										<td><?php echo $ot['VariedadCat']; ?></td>
										<td><?php echo $ot['VariedadNombre']; ?></td>

										<td><?php echo Cantidades($ot['GeoVelocidadMin_out'], 2); ?></td>
										<td><?php echo Cantidades($ot['GeoVelocidadMax_out'], 2); ?></td>
										<td><?php echo Cantidades($ot['GeoVelocidadProm_out'], 2); ?></td>
										<td><?php echo Cantidades($ot['VelTractor'], 2); ?></td>

										<td><?php echo Cantidades($ot['GeoDistance_out'], 2); ?></td>

										<td><?php echo Cantidades($ot['Sensor_out_1_Prom'], 2); ?></td>
										<td><?php echo Cantidades($ot['Sensor_out_2_Prom'], 2); ?></td>

										<td><?php echo Cantidades($ot['Diferencia_out'], 0); ?></td>

										<td>
											<div class="btn-group" style="width: 70px;" >
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion_trabilidad.php?view='.simpleEncode($ot['idTractores'], fecha_actual()); ?>" title="Ver Trazabilidad" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			<?php } ?>
	
		

	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}
$y = "idEstado=1";
$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

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
				if(isset($NSolicitud)){             $x1  = $NSolicitud;             }else{$x1  = '';}
				if(isset($idPredio)){               $x2  = $idPredio;               }else{$x2  = '';}
				if(isset($idZona)){                 $x3  = $idZona;                 }else{$x3  = '';}
				if(isset($idTemporada)){            $x4  = $idTemporada;            }else{$x4  = '';}
				if(isset($idEstadoFen)){            $x5  = $idEstadoFen;            }else{$x5  = '';}
				if(isset($idCategoria)){            $x6  = $idCategoria;            }else{$x6  = '';}
				if(isset($idProducto)){             $x7  = $idProducto;             }else{$x7  = '';}
				if(isset($idEstado)){               $x8  = $idEstado;               }else{$x8  = '';}
				if(isset($f_programacion_desde)){   $x9  = $f_programacion_desde;   }else{$x9  = '';}
				if(isset($f_programacion_hasta)){   $x10 = $f_programacion_hasta;   }else{$x10 = '';}
				if(isset($f_ejecucion_desde)){      $x11 = $f_ejecucion_desde;      }else{$x11 = '';}
				if(isset($f_ejecucion_hasta)){      $x12 = $f_ejecucion_hasta;      }else{$x12 = '';}
				if(isset($f_termino_desde)){        $x13 = $f_termino_desde;        }else{$x13 = '';}
				if(isset($f_termino_hasta)){        $x14 = $f_termino_hasta;        }else{$x14 = '';}
				if(isset($idUsuario)){              $x15 = $idUsuario;              }else{$x15 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('N° Solicitud','NSolicitud', $x1, 1);
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x2, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $x, 0,
										 'Cuarteles','idZona', $x3, 1, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select_filter('Temporada','idTemporada', $x4, 1, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
				$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x5, 1, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');

				$Form_Inputs->form_select('Estado','idEstado', $x8, 2, 'idEstado', 'Nombre', 'core_estado_solicitud', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programada Desde','f_programacion_desde', $x9, 1);
				$Form_Inputs->form_date('Fecha Programada Hasta','f_programacion_hasta', $x10, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Desde','f_ejecucion_desde', $x11, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Hasta','f_ejecucion_hasta', $x12, 1);
				$Form_Inputs->form_date('Fecha Terminada Desde','f_termino_desde', $x13, 1);
				$Form_Inputs->form_date('Fecha Terminada Hasta','f_termino_hasta', $x14, 1);

				$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x15, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

				?>

				<script>
					/**********************************************************************/
					$(document).ready(function(){
						document.getElementById('div_f_programacion_desde').style.display = 'none';
						document.getElementById('div_f_programacion_hasta').style.display = 'none';
						document.getElementById('div_f_ejecucion_desde').style.display = 'none';
						document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
						document.getElementById('div_f_termino_desde').style.display = 'none';
						document.getElementById('div_f_termino_hasta').style.display = 'none';
					});

					/**********************************************************************/
					document.getElementById("idEstado").onchange = function() {LoadEstado(1)};

					/**********************************************************************/
					function LoadEstado(caseLoad){
						//obtengo los valores
						let idEstado = $("#idEstado").val();
						//selecciono
						switch(idEstado) {
							//Solicitado
							case '1':
								document.getElementById('div_f_programacion_desde').style.display = 'block';
								document.getElementById('div_f_programacion_hasta').style.display = 'block';
								document.getElementById('div_f_ejecucion_desde').style.display = 'none';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
								document.getElementById('div_f_termino_desde').style.display = 'none';
								document.getElementById('div_f_termino_hasta').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_ejecucion_desde"]').value = '';
									document.querySelector('input[name="f_ejecucion_hasta"]').value = '';
									document.querySelector('input[name="f_termino_desde"]').value = '';
									document.querySelector('input[name="f_termino_hasta"]').value = '';
								}
							break;
							//Programado
							case '2':
								document.getElementById('div_f_programacion_desde').style.display = 'none';
								document.getElementById('div_f_programacion_hasta').style.display = 'none';
								document.getElementById('div_f_ejecucion_desde').style.display = 'block';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'block';
								document.getElementById('div_f_termino_desde').style.display = 'none';
								document.getElementById('div_f_termino_hasta').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_programacion_desde"]').value = '';
									document.querySelector('input[name="f_programacion_hasta"]').value = '';
									document.querySelector('input[name="f_termino_desde"]').value = '';
									document.querySelector('input[name="f_termino_hasta"]').value = '';
								}
							break;
							//Ejecutado
							case '3':
								document.getElementById('div_f_programacion_desde').style.display = 'none';
								document.getElementById('div_f_programacion_hasta').style.display = 'none';
								document.getElementById('div_f_ejecucion_desde').style.display = 'none';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
								document.getElementById('div_f_termino_desde').style.display = 'block';
								document.getElementById('div_f_termino_hasta').style.display = 'block';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_programacion_desde"]').value = '';
									document.querySelector('input[name="f_programacion_hasta"]').value = '';
									document.querySelector('input[name="f_ejecucion_desde"]').value = '';
									document.querySelector('input[name="f_ejecucion_hasta"]').value = '';
								}
							break;
							//el resto
							default:
								document.getElementById('div_f_programacion_desde').style.display = 'none';
								document.getElementById('div_f_programacion_hasta').style.display = 'none';
								document.getElementById('div_f_ejecucion_desde').style.display = 'none';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
								document.getElementById('div_f_termino_desde').style.display = 'none';
								document.getElementById('div_f_termino_hasta').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_programacion_desde"]').value = '';
									document.querySelector('input[name="f_programacion_hasta"]').value = '';
									document.querySelector('input[name="f_ejecucion_desde"]').value = '';
									document.querySelector('input[name="f_ejecucion_hasta"]').value = '';
									document.querySelector('input[name="f_termino_desde"]').value = '';
									document.querySelector('input[name="f_termino_hasta"]').value = '';
								}
							break;
						}
					}

				</script>

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
