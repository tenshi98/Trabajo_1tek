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
cross_solicitud_aplicacion_listado.idSolicitud, 
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.idEstado,
cross_solicitud_aplicacion_listado.f_creacion,
cross_solicitud_aplicacion_listado.f_programacion,
cross_solicitud_aplicacion_listado.f_ejecucion,
cross_solicitud_aplicacion_listado.f_termino,
cross_solicitud_aplicacion_listado.f_programacion_fin,
cross_solicitud_aplicacion_listado.f_ejecucion_fin,
cross_solicitud_aplicacion_listado.f_termino_fin,
cross_solicitud_aplicacion_listado.horaProg,
cross_solicitud_aplicacion_listado.horaEjecucion,
cross_solicitud_aplicacion_listado.horaTermino,
cross_solicitud_aplicacion_listado.horaProg_fin,
cross_solicitud_aplicacion_listado.horaEjecucion_fin,
cross_solicitud_aplicacion_listado.horaTermino_fin,
cross_solicitud_aplicacion_listado.Mojamiento, 
cross_solicitud_aplicacion_listado.VelTractor, 
cross_solicitud_aplicacion_listado.VelViento, 
cross_solicitud_aplicacion_listado.TempMin, 
cross_solicitud_aplicacion_listado.TempMax,
cross_solicitud_aplicacion_listado.HumTempMax,

usuarios_listado.Nombre AS NombreUsuario,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

cross_predios_listado.Nombre AS NombrePredio,
core_estado_solicitud.Nombre AS Estado,
cross_checking_temporada.Codigo AS TemporadaCodigo,
cross_checking_temporada.Nombre AS TemporadaNombre,
cross_checking_estado_fenologico.Codigo AS EstadoFenCodigo,
cross_checking_estado_fenologico.Nombre AS EstadoFenNombre,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,

core_cross_prioridad.Nombre AS NombrePrioridad,
cross_solicitud_aplicacion_listado.idDosificador,
trabajadores_listado.Rut AS TrabajadorRut,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,

COUNT(cross_solicitud_aplicacion_listado_cuarteles.idEstado) AS N_Cuarteles,
SUM(if(cross_solicitud_aplicacion_listado_cuarteles.idEstado = 2, 1, 0)) AS N_Cuarteles_Cerrados';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                               ON usuarios_listado.idUsuario                                 = cross_solicitud_aplicacion_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen                 ON sistema_origen.idSistema                                   = cross_solicitud_aplicacion_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad          ON sis_or_ciudad.idCiudad                                     = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna          ON sis_or_comuna.idComuna                                     = sistema_origen.idComuna
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `core_estado_solicitud`                          ON core_estado_solicitud.idEstado                             = cross_solicitud_aplicacion_listado.idEstado
LEFT JOIN `cross_checking_temporada`                       ON cross_checking_temporada.idTemporada                       = cross_solicitud_aplicacion_listado.idTemporada
LEFT JOIN `cross_checking_estado_fenologico`               ON cross_checking_estado_fenologico.idEstadoFen               = cross_solicitud_aplicacion_listado.idEstadoFen
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `core_cross_prioridad`                           ON core_cross_prioridad.idPrioridad                           = cross_solicitud_aplicacion_listado.idPrioridad
LEFT JOIN `trabajadores_listado`                           ON trabajadores_listado.idTrabajador                          = cross_solicitud_aplicacion_listado.idDosificador
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud';
$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud ='.$X_Puntero.' GROUP BY cross_solicitud_aplicacion_listado.idSolicitud';
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
//Insumos
$SIS_query = '
cross_solicitud_aplicacion_listado_cuarteles.idEstado,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
sistema_variedades_categorias.Nombre AS CuartelEspecie,
variedades_listado.Nombre AS CuartelVariedad,
cross_predios_listado_zonas.AnoPlantacion AS CuartelAnoPlantacion,
cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
cross_predios_listado_zonas.Hileras AS CuartelHileras,
cross_predios_listado_zonas.Plantas AS NPlantas,
cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
cross_predios_listado_zonas.DistanciaHileras AS CuartelDistanciaHileras,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Litros,
cross_solicitud_aplicacion_listado_cuarteles.idEjecucion AS CuartelidEjecucion,
AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm!=0,cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,0),0)) AS GeoVelocidadProm,
SUM(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.GeoDistance!=0,cross_solicitud_aplicacion_listado_tractores.GeoDistance,0),0)) AS GeoDistance,
AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom,0),0)) AS Sensor_1_Prom,
AVG(NULLIF(IF(cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom!=0,cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom,0),0)) AS Sensor_2_Prom';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado_cuarteles.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado_cuarteles.idProducto';
$SIS_where = 'cross_solicitud_aplicacion_listado_cuarteles.idSolicitud = '.$X_Puntero.' GROUP BY cross_solicitud_aplicacion_listado_cuarteles.idZona';
$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
$arrCuarteles = array();
$arrCuarteles = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_cuarteles', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCuarteles');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Detalles Solicitud de Aplicacion N°<?php echo n_doc($rowData['NSolicitud'], 5); ?>.
				<small class="pull-right">Fecha Termino: <?php echo Fecha_estandar($rowData['f_termino']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Datos Empresa</strong>
			<address>
				Rut: <?php echo $rowData['SistemaOrigenRut']; ?><br/>
				Empresa: <?php echo $rowData['SistemaOrigen']; ?><br/>
				Ciudad-Comuna: <?php echo $rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna']; ?><br/>
				Dirección: <?php echo $rowData['SistemaOrigenDireccion']; ?><br/>
				Fono: <?php echo formatPhone($rowData['SistemaOrigenFono']); ?><br/>
				Email: <?php echo $rowData['SistemaOrigenEmail']; ?>
			</address>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Identificación</strong>
			<address>
				Predio: <?php echo $rowData['NombrePredio']; ?><br/>
				Estado: <?php echo $rowData['Estado']; ?><br/>
				Temporada: <?php echo $rowData['TemporadaCodigo'].' '.$rowData['TemporadaNombre']; ?><br/>
				Estado Fenologico: <?php echo $rowData['EstadoFenCodigo'].' '.$rowData['EstadoFenNombre']; ?><br/>
				<?php
					if(isset($rowData['VariedadCat'])&&$rowData['VariedadCat']!=''){echo 'Especie: '.$rowData['VariedadCat'].'<br/>';     }else{echo 'Especie: Todas las Especies<br/>';}
					if(isset($rowData['VariedadNombre'])&&$rowData['VariedadNombre']!=''){ echo 'Variedad: '.$rowData['VariedadNombre'].'<br/>';}else{echo 'Variedad: Todas las Variedades<br/>';}
				?>
			</address>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Datos de Solicitud</strong>
			<address>
				Prioridad: <?php echo $rowData['NombrePrioridad']; ?><br/>
				N° Solicitud: <?php echo n_doc($rowData['NSolicitud'], 5); ?><br/>
				Fecha inicio requerido: <?php echo fecha_estandar($rowData['f_programacion']).' '.$rowData['horaProg']; ?><br/>
				Fecha termino requerido: <?php echo fecha_estandar($rowData['f_programacion_fin']).' '.$rowData['horaProg_fin']; ?><br/>
				<?php
					if(isset($rowData['f_ejecucion'])&&$rowData['f_ejecucion']!='0000-00-00'){echo 'Fecha inicio programación: '.fecha_estandar($rowData['f_ejecucion']).' '.$rowData['horaEjecucion'].'<br/>';}
					if(isset($rowData['f_ejecucion_fin'])&&$rowData['f_ejecucion_fin']!='0000-00-00'){echo 'Fecha termino programación: '.fecha_estandar($rowData['f_ejecucion_fin']).' '.$rowData['horaEjecucion_fin'].'<br/>';}
					if(isset($rowData['f_termino'])&&$rowData['f_termino']!='0000-00-00'){echo 'Fecha inicio ejecución: '.fecha_estandar($rowData['f_termino']).' '.$rowData['horaTermino'].'<br/>';}
					if(isset($rowData['f_termino_fin'])&&$rowData['f_termino_fin']!='0000-00-00'){echo 'Terminado: '.fecha_estandar($rowData['f_termino_fin']).' '.$rowData['horaTermino_fin'].'<br/>';}
					echo 'Agrónomo: '.$rowData['NombreUsuario'];
					if(isset($rowData['idDosificador'])&&$rowData['idDosificador']!=0){echo 'Dosificador: '.$rowData['TrabajadorRut'].' '.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].'<br/>';}
				?>	
					
			</address>
		</div>

		<div class="clearfix"></div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Parámetros de Aplicación</strong>
			<address>
				Mojamiento: <?php echo Cantidades_decimales_justos($rowData['Mojamiento']); ?> L/ha<br/>
				Velocidad Tractor: <?php echo Cantidades_decimales_justos($rowData['VelTractor']); ?> Km/hr<br/>
				Velocidad Viento: <?php echo Cantidades_decimales_justos($rowData['VelViento']); ?> Km/hr<br/>
				Temperatura Min: <?php echo Cantidades_decimales_justos($rowData['TempMin']); ?> °<br/>
				Temperatura Max: <?php echo Cantidades_decimales_justos($rowData['TempMax']); ?> °<br/>
				Humedad: <?php echo Cantidades_decimales_justos($rowData['HumTempMax']); ?> %<br/>

			</address>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			<strong>Cumplimiento</strong>
			<address>
				N° Cuarteles Programados: <?php echo $rowData['N_Cuarteles']; ?><br/>
				N° Cuarteles Cerrados: <?php echo $rowData['N_Cuarteles_Cerrados']; ?><br/>
				Avance %: <?php echo porcentaje($rowData['N_Cuarteles_Cerrados']/$rowData['N_Cuarteles']); ?><br/>

			</address>
		</div>
				
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr role="row">
							<th colspan="7" style="text-align: center;">Identificación</th>
							<th colspan="1" style="text-align: center;">Velocidad Tractor (Km/hr)</th>
							<th colspan="1" style="text-align: center;">Distancia Recorrida(Metros)</th>
							<th colspan="2" style="text-align: center;">Promedio Caudales</th>
							<th colspan="2" style="text-align: center;">Uso</th>
							<th colspan="1" style="text-align: center;">Plantas</th>
							<th width="10">Acciones</th>
						</tr>
						<tr class="active">
							<td><strong>Cuarteles</strong></td>
							<td><strong>Variedad - Especie</strong></td>
							<td><strong>N° Plantas</strong></td>
							<td><strong>Hectareas</strong></td>
							<td><strong>Año Plantacion</strong></td>
							<td><strong>Hileras</strong></td>
							<td><strong>Distancia Plant</strong></td>
							<td><strong>Distancia Hileras</strong></td>

							<th><strong>Promedio</strong></th>

							<th><strong>Faltante</strong></th>

							<th><strong>Derecho</strong></th>
							<th><strong>Izquierdo</strong></th>

							<th><strong>Litros Aplicados</strong></th>
							<th><strong>Litros x Hectarea</strong></th>

							<th><strong>Pendientes</strong></th>

							<th></th>

						</tr>

						<?php
						//recorro el lsiatdo entregado por la base de datos
						if ($arrCuarteles!=false && !empty($arrCuarteles) && $arrCuarteles!='') {
							foreach ($arrCuarteles as $cuartel) {
								if(isset($cuartel['idEstado'])&&$cuartel['idEstado']==2){ $cierre = ' (Cerrado el '.fecha_estandar($cuartel['f_cierre']).')';}else{$cierre = '';}

								//defino el icono y su color
								switch ($cuartel['CuartelidEjecucion']) {
									case 0:
										$s_Icon = '';
										break;
									case 1:
										$s_Icon = '<span style="color: #dd4b39;"><i class="fa fa-rss" aria-hidden="true"></i></span>';
										break;
									case 2:
										$s_Icon = '<span style="color: #5cb85c;"><i class="fa fa-rss" aria-hidden="true"></i></span>';
										break;
								}
								?>

								<tr class="item-row linea_punteada">
									<td class="item-name"><?php echo $s_Icon.' '.$cuartel['CuartelNombre'].$cierre ?></td>
									<td class="item-name"><?php echo $cuartel['CuartelEspecie'].' '.$cuartel['CuartelVariedad']; ?></td>
									<td class="item-name"><?php echo Cantidades($cuartel['NPlantas'], 0); ?></td>
									<td class="item-name"><?php echo Cantidades($cuartel['CuartelHectareas'], 2); ?></td>
									<td class="item-name"><?php echo Cantidades($cuartel['CuartelAnoPlantacion'], 0); ?></td>
									<td class="item-name"><?php echo Cantidades($cuartel['CuartelHileras'], 0); ?></td>
									<td class="item-name"><?php echo Cantidades($cuartel['CuartelDistanciaPlant'], 1); ?></td>
									<td class="item-name"><?php echo Cantidades($cuartel['CuartelDistanciaHileras'], 1); ?></td>

									<td class="item-name"><?php echo Cantidades($cuartel['GeoVelocidadProm'], 1); ?></td>
									<td class="item-name">
										<?php  
										$faltante = ($cuartel['CuartelDistanciaPlant']*$cuartel['NPlantas']) - ($cuartel['GeoDistance']*1000);
										if($faltante<0){
											$faltante = 0;
										}
										echo Cantidades($faltante, 0); 
										?>
									</td>
									<td class="item-name"><?php echo Cantidades($cuartel['Sensor_1_Prom'], 2); ?></td>
									<td class="item-name"><?php echo Cantidades($cuartel['Sensor_2_Prom'], 2); ?></td>
									<td class="item-name"><?php echo cantidades($cuartel['Litros'], 0); ?></td>
									<td class="item-name"><?php if(isset($cuartel['CuartelHectareas'])&&$cuartel['CuartelHectareas']!=0){echo cantidades(($cuartel['Litros']/$cuartel['CuartelHectareas']), 0);}else{echo '0';} ?></td>
									<td class="item-name">
										<?php
										$pendiente = ((($cuartel['CuartelDistanciaPlant']*$cuartel['NPlantas']) - ($cuartel['GeoDistance']*1000))/$cuartel['CuartelDistanciaPlant']);
										if($pendiente<0){
											$pendiente = 0;
										}
										echo Cantidades($pendiente, 0); 
										?>
									</td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="<?php echo 'view_solicitud_aplicacion_detalle_tractores.php?idSolicitud='.$_GET['view'].'&idZona='.simpleEncode($cuartel['idZona'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
									
										
								</tr>
								<?php 
							}
						}else{
							echo '<tr class="item-row linea_punteada"><td>No hay cuarteles asignados</td></tr>';
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</section>

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
