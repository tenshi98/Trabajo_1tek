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
require_once 'core/Load.Utils.Print.php';
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
require_once 'core/Web.Header.Print.php';
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
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                     = cross_solicitud_aplicacion_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema                       = cross_solicitud_aplicacion_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                         = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                         = sistema_origen.idComuna
LEFT JOIN `cross_predios_listado`                   ON cross_predios_listado.idPredio                 = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `core_estado_solicitud`                   ON core_estado_solicitud.idEstado                 = cross_solicitud_aplicacion_listado.idEstado
LEFT JOIN `cross_checking_temporada`                ON cross_checking_temporada.idTemporada           = cross_solicitud_aplicacion_listado.idTemporada
LEFT JOIN `cross_checking_estado_fenologico`        ON cross_checking_estado_fenologico.idEstadoFen   = cross_solicitud_aplicacion_listado.idEstadoFen
LEFT JOIN `sistema_variedades_categorias`           ON sistema_variedades_categorias.idCategoria      = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                      ON variedades_listado.idProducto                  = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `core_cross_prioridad`                    ON core_cross_prioridad.idPrioridad               = cross_solicitud_aplicacion_listado.idPrioridad
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador              = cross_solicitud_aplicacion_listado.idDosificador';
$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
//Cuarteles
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
sistema_variedades_categorias.Nombre AS EspecieNombre,
variedades_listado.Nombre AS VariedadNombre,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_solicitud_aplicacion_listado_cuarteles.idEstado,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
cross_solicitud_aplicacion_listado.Mojamiento, 
cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
cross_solicitud_aplicacion_listado_cuarteles.idEjecucion AS CuartelidEjecucion,
cross_solicitud_aplicacion_listado_cuarteles.LitrosAplicados AS CuartelLitrosAplicados,
cross_solicitud_aplicacion_listado_cuarteles.VelPromedio AS CuartelVelPromedio,

cross_solicitud_aplicacion_listado_cuarteles.idCuarteles AS ID_1,
(SELECT AVG(NULLIF(IF(GeoVelocidadProm!=0,GeoVelocidadProm,0),0)) FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS VelPromedio,
(SELECT SUM(Diferencia)                                           FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS LitrosAplicados';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas`        ON cross_predios_listado_zonas.idZona              = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `sistema_variedades_categorias`      ON sistema_variedades_categorias.idCategoria       = cross_solicitud_aplicacion_listado_cuarteles.idCategoria
LEFT JOIN `variedades_listado`                 ON variedades_listado.idProducto                   = cross_solicitud_aplicacion_listado_cuarteles.idProducto
LEFT JOIN `cross_solicitud_aplicacion_listado` ON cross_solicitud_aplicacion_listado.idSolicitud  = cross_solicitud_aplicacion_listado_cuarteles.idSolicitud';
$SIS_where = 'cross_solicitud_aplicacion_listado_cuarteles.idSolicitud ='.$X_Puntero;
$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
$arrCuarteles = array();
$arrCuarteles = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_cuarteles', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCuarteles');

/*****************************************/
//Tractores
$SIS_query = '
telemetria_listado.Nombre AS TelemetriaNombre,
telemetria_listado.Capacidad AS TelemetriaCapacidad,
vehiculos_listado.Nombre AS VehiculoNombre,
trabajadores_listado.Rut,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
contratista_listado.Nombre AS Contratista,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Diferencia,
AVG(cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm) AS GeoVelocidadProm,
SEC_TO_TIME( SUM( TIME_TO_SEC(cross_solicitud_aplicacion_listado_tractores.T_Aplicacion))) AS T_Aplicacion';
$SIS_join  = '
LEFT JOIN `telemetria_listado`    ON telemetria_listado.idTelemetria      = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`     ON vehiculos_listado.idVehiculo         = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador    = cross_solicitud_aplicacion_listado_tractores.idTrabajador
LEFT JOIN `contratista_listado`   ON contratista_listado.idContratista    = trabajadores_listado.idContratista';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud ='.$X_Puntero.' GROUP BY cross_solicitud_aplicacion_listado_tractores.idTelemetria, cross_solicitud_aplicacion_listado_tractores.idVehiculo';
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrTractores = array();
$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTractores');

/*****************************************/
//tractores por cuartel
$SIS_query = '
cross_solicitud_aplicacion_listado_cuarteles.idZona,
telemetria_listado.Nombre AS TelemetriaNombre,
vehiculos_listado.Nombre AS VehiculoNombre,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Diferencia';
$SIS_join  = '
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                           = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                              = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles  = cross_solicitud_aplicacion_listado_tractores.idCuarteles';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud = '.$X_Puntero.' AND Diferencia!=0 GROUP BY cross_solicitud_aplicacion_listado_cuarteles.idZona, cross_solicitud_aplicacion_listado_tractores.idTelemetria, cross_solicitud_aplicacion_listado_tractores.idVehiculo';
$SIS_order = 'cross_solicitud_aplicacion_listado_cuarteles.idZona ASC, telemetria_listado.Nombre ASC';
$arrTracxCuartel = array();
$arrTracxCuartel = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTracxCuartel');

/*****************************************/
//Se trae un listado con los productos	
$SIS_query = '
cross_solicitud_aplicacion_listado_productos.idProdQuim,
cross_solicitud_aplicacion_listado_productos.idCuarteles,
cross_solicitud_aplicacion_listado_productos.DosisRecomendada,
cross_solicitud_aplicacion_listado_productos.DosisAplicar,
cross_solicitud_aplicacion_listado_productos.Objetivo,
productos_listado.Nombre AS ProductoNombre,
productos_listado.IngredienteActivo AS ProductoIngrediente, 
productos_listado.Carencia AS ProductoCarencia, 
productos_listado.EfectoResidual AS ProductoResidual, 
productos_listado.EfectoRetroactivo AS ProductoRetroactivo,
productos_listado.CarenciaExportador AS ProductoExportador,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = '
LEFT JOIN `productos_listado`       ON productos_listado.idProducto   = cross_solicitud_aplicacion_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = cross_solicitud_aplicacion_listado_productos.idUml';
$SIS_where = 'cross_solicitud_aplicacion_listado_productos.idSolicitud = '.$X_Puntero.' GROUP BY cross_solicitud_aplicacion_listado_productos.idProducto';
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
//Se trae un listado con los materiales
$SIS_query = '
cross_checking_materiales_seguridad.Nombre,
cross_checking_materiales_seguridad.Codigo';
$SIS_join  = 'LEFT JOIN `cross_checking_materiales_seguridad`   ON cross_checking_materiales_seguridad.idMatSeguridad   = cross_solicitud_aplicacion_listado_materiales.idMatSeguridad';
$SIS_where = 'cross_solicitud_aplicacion_listado_materiales.idSolicitud = '.$X_Puntero;
$SIS_order = 'cross_checking_materiales_seguridad.Nombre ASC';
$arrMateriales = array();
$arrMateriales = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_materiales', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMateriales');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Solicitud de Aplicacion.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['f_creacion']); ?></small>
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

	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table">
				<tbody>
					<tr class="active">
						<td><strong>Especie - Variedad</strong></td>
						<td><strong>Numero de<br/>solicitud</strong></td>
						<td><strong>Cuarteles</strong></td>
						<td><strong>Veloc.<br/>Promedio</strong></td>
						<td><strong>Mojamiento<br/>solicitado</strong></td>
						<td><strong>lts. Aplicados</strong></td>
						<td><strong>Mojamiento<br/>Real</strong></td>
						<td><strong>% Mojamiento</strong></td>
						<td><strong>Vehiculos<br/>involucrados</strong></td>
					</tr>
					<?php
					//Variables
					$TotalNPlantas          = 0;
					$TotalCuartelHectareas  = 0;
					$TotalCuartelHileras    = 0;
					$TotalPlantasAplicadas  = 0;
                    $TotalLitrosAplicados   = 0;
                    $TotalMojamiento        = 0;
                    $TotLitrosApliXhect     = 0;
                    
					//recorro el lsiatdo entregado por la base de datos
					if ($arrCuarteles!=false && !empty($arrCuarteles) && $arrCuarteles!='') {
						foreach ($arrCuarteles as $cuartel) {
							//Verifico el tipo de cierre
							if(isset($cuartel['CuartelidEjecucion'])&&$cuartel['CuartelidEjecucion']==1){
								$S_LitrosAplicados  = $cuartel['CuartelLitrosAplicados'];
								$S_VelPromedio      = $cuartel['CuartelVelPromedio'];
							}else{
								$S_LitrosAplicados  = $cuartel['LitrosAplicados'];
								$S_VelPromedio      = $cuartel['VelPromedio'];
							}

							//calculo
							if(isset($cuartel['CuartelHectareas'])&&$cuartel['CuartelHectareas']!=0){
								$LitrosApliXhect = $S_LitrosAplicados/$cuartel['CuartelHectareas'];
							}else{
								$LitrosApliXhect = 0;
							}

							//se muestra el estado de cierre
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

							//Sumo Variables
							$TotalMojamiento       = $TotalMojamiento + $cuartel['Mojamiento'];
							$TotalLitrosAplicados  = $TotalLitrosAplicados + $S_LitrosAplicados;
							$TotLitrosApliXhect    = $TotLitrosApliXhect + $LitrosApliXhect;
							?>
							<tr class="item-row linea_punteada">
								<td><?php echo $cuartel['EspecieNombre'].' - '.$cuartel['VariedadNombre']; ?></td>
								<td><?php echo $cuartel['NSolicitud']; ?></td>
								<td><?php echo $s_Icon.' '.$cuartel['CuartelNombre'].$cierre; ?></td>
								<td><?php echo Cantidades($S_VelPromedio,1); ?></td>
								<td><?php echo Cantidades($cuartel['Mojamiento'],0); ?></td>
								<td><?php echo Cantidades($S_LitrosAplicados,1); ?></td>
								<td><?php echo Cantidades($LitrosApliXhect,1); ?></td>
								<td><?php if($LitrosApliXhect!=0){echo porcentaje($LitrosApliXhect/$cuartel['Mojamiento']);}else{ echo '0 %';} ?></td>
								<td>	
									<?php 
									if ($arrTracxCuartel!=false && !empty($arrTracxCuartel) && $arrTracxCuartel!='') {
										$zxc = 0;
										foreach ($arrTracxCuartel as $tract) {
											if($cuartel['idZona']==$tract['idZona']){
												if($zxc!=0){echo ' - ';}
												echo $tract['TelemetriaNombre'];
												$zxc++;
											}
										}
									}
									?>	
								</td>
							</tr>
						<?php } ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><strong>Totales</strong></td>
							<td class="item-name"><strong></strong></td>
							<td class="item-name"><strong></strong></td>
							<td class="item-name"><strong></strong></td>
							<td class="item-name"><strong><?php echo Cantidades($TotalMojamiento, 0); ?></strong></td>
							<td class="item-name"><strong><?php echo Cantidades($TotalLitrosAplicados, 1); ?></strong></td>
							<td class="item-name"><strong><?php echo Cantidades($TotLitrosApliXhect, 1); ?></strong></td>
							<td class="item-name"><strong><?php if($TotLitrosApliXhect!=0){echo porcentaje($TotLitrosApliXhect/$TotalMojamiento);}else{ echo '0 %';} ?></strong></td>
							<td class="item-name"><strong></strong></td>
							<td class="item-name"><strong></strong></td>
						</tr>

						<?php
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="10">No hay cuarteles asignados</td></tr>';
					} ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table">
				<tbody>
					<tr class="active">
						<td><strong>Objetivo</strong></td>
						<td><strong>Producto<br/>Químico</strong></td>
						<td><strong>Ingrediente<br/>Activo</strong></td>
						<td><strong>Dosis<br/>Recomendada</strong></td>
						<td><strong>Dosis a<br/>Aplicar</strong></td>
						<td><strong>Carencia<br/>Etiqueta</strong></td>
						<td><strong>Carencia<br/>ASOEX</strong></td>
						<td><strong>Carencia<br/>ESCO</strong></td>
						<td><strong>Tiempo<br/>Re-Ingreso</strong></td>
					</tr>
					<?php
					//Variable
					$NProd = 0;
					//recorro el lsiatdo entregado por la base de datos
					if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') {
						foreach ($arrProductos as $prod) {
							$NProd++; ?>

							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $prod['Objetivo']; ?></td>
								<td class="item-name"><i class="fa fa-flask" aria-hidden="true"></i> <?php echo $prod['ProductoNombre']; ?></td>
								<td class="item-name"><?php echo $prod['ProductoIngrediente']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($prod['DosisRecomendada']).' '.$prod['Unimed']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($prod['DosisAplicar']).' '.$prod['Unimed']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($prod['ProductoExportador']); ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($prod['ProductoCarencia']); ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($prod['ProductoResidual']); ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($prod['ProductoRetroactivo']); ?></td>
							</tr>
							<?php
						}
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="9">No hay Productos Quimicos Asignados</td></tr>';
					} ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table">
				<tbody>
					<tr class="active">
						<td><strong>Tractor</strong></td>
						<td><strong>Equipo Aplicación</strong></td>
						<td><strong>Trabajador</strong></td>
						<td><strong>Contratista</strong></td>
						<td><strong>Capacidad</strong></td>
						<td><strong>Litros Aplicados</strong></td>
						<td><strong>Velocidad Promedio</strong></td>
						<td><strong>Tiempo Aplicando</strong></td>
					</tr>
					<?php
					//Variables
					$Capacidad  = 0;
					$NTract     = 0;
					//recorro el lsiatdo entregado por la base de datos
					if ($arrTractores!=false && !empty($arrTractores) && $arrTractores!='') {
						foreach ($arrTractores as $tract) {
							//Se suman cantidades
							$Capacidad = $Capacidad + $tract['TelemetriaCapacidad'];
							$NTract++; ?>

							<tr class="item-row linea_punteada">
								<td class="item-name"><i class="fa fa-truck" aria-hidden="true"></i> <?php echo $tract['VehiculoNombre']; ?></td>
								<td class="item-name"><?php echo $tract['TelemetriaNombre']; ?></td>
								<td class="item-name"><?php echo $tract['Rut'].' '.$tract['Nombre'].' '.$tract['ApellidoPat']; ?></td>
								<td class="item-name"><?php echo $tract['Contratista']; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($tract['TelemetriaCapacidad']); ?></td>
								<td class="item-name"><?php echo Cantidades($tract['Diferencia'], 0); ?></td>
								<td class="item-name"><?php echo Cantidades($tract['GeoVelocidadProm'],2); ?></td>
								<td class="item-name"><?php echo $tract['T_Aplicacion']; ?></td>
							</tr>
							<?php
						}
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="5">No hay Tractores Asignados</td></tr>';
					} ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table">
				<tbody>
					<tr class="active">
						<td><strong>Capacidad Total Equipos<br/>de Aplicación</strong></td>
						<td><strong>Promedio de Capacidad<br/>por Equipo</strong></td>
						<td><strong>Maquinadas<br/>estimadas</strong></td>
						<td><strong>Producto<br/>Quimico</strong></td>
						<td><strong>Total Producto<br/>Quimico</strong></td>
					</tr>

					<?php
					//Variable
					$nmb = 0;
					//recorro el lsiatdo entregado por la base de datos
					if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') {
						foreach ($arrProductos as $prod) {
							$PromedioCapacidad = $Capacidad/$NTract;
							
							?>

							<tr class="item-row linea_punteada">
								<?php if($nmb==0){ ?><td class="item-name"  rowspan="<?php echo $NProd; ?>"><?php echo Cantidades_decimales_justos($Capacidad); ?></td><?php } ?>
								<?php if($nmb==0){ ?><td class="item-name"  rowspan="<?php echo $NProd; ?>"><?php echo Cantidades_decimales_justos($PromedioCapacidad); ?></td><?php } ?>
								<?php if($nmb==0){ ?><td class="item-name"  rowspan="<?php echo $NProd; ?>"><?php if($PromedioCapacidad!=0){echo Cantidades(($rowData['Mojamiento']*$TotalCuartelHectareas)/$PromedioCapacidad, 2);}else{echo '0';} ?></td><?php } ?>

								<td class="item-name"><i class="fa fa-flask" aria-hidden="true"></i> <?php echo $prod['ProductoNombre']; ?></td>
								<td class="item-name"><?php echo Cantidades((($rowData['Mojamiento']*$TotalCuartelHectareas)/100)*$prod['DosisAplicar'], 2).' '.$prod['Unimed']; ?></td>

							</tr>

							<?php
							//se suma 1
							$nmb++;
						}
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="5">No hay Productos Quimicos Asignados</td></tr>';
					} ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table">
				<tbody>
					<tr class="active">
						<td><strong>Materiales de Seguridad</strong></td>
					</tr>
					<?php
					//recorro el lsiatdo entregado por la base de datos
					if ($arrMateriales!=false && !empty($arrMateriales) && $arrMateriales!='') {
						foreach ($arrMateriales as $prod){ ?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><i class="fa fa-eyedropper" aria-hidden="true"></i> <?php echo $prod['Codigo'].' - '.$prod['Nombre']; ?></td>
							</tr>
							<?php
						}
					}else{
						echo '<tr class="item-row linea_punteada"><td>No hay Materiales de Seguridad Asignados</td></tr>';
					} ?> 
				</tbody>
			</table>
		</div>
	</div>
	    
</section>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
