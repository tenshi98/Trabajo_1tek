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
$query = "SELECT
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
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat

FROM `cross_solicitud_aplicacion_listado`
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
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador              = cross_solicitud_aplicacion_listado.idDosificador

WHERE cross_solicitud_aplicacion_listado.idSolicitud = ".$X_Puntero;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){

	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
			
}
$rowData = mysqli_fetch_assoc ($resultado);

/*****************************************/
//Insumos
$arrCuarteles = array();
$query = "SELECT 
cross_solicitud_aplicacion_listado_cuarteles.idSolicitud,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
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
cross_solicitud_aplicacion_listado_cuarteles.idEjecucion AS CuartelidEjecucion,
cross_solicitud_aplicacion_listado_cuarteles.GeoDistance AS CuartelGeoDistance,
cross_solicitud_aplicacion_listado_cuarteles.VelPromedio AS CuartelVelPromedio,
cross_solicitud_aplicacion_listado_cuarteles.LitrosAplicados AS CuartelLitrosAplicados,

cross_solicitud_aplicacion_listado_cuarteles.idCuarteles AS ID_1,
(SELECT SUM(GeoDistance)                                          FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS GeoDistance,
(SELECT AVG(NULLIF(IF(GeoVelocidadProm!=0,GeoVelocidadProm,0),0)) FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS VelPromedio,
(SELECT SUM(Diferencia)                                           FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS LitrosAplicados

FROM `cross_solicitud_aplicacion_listado_cuarteles` 
LEFT JOIN `cross_predios_listado_zonas`    ON cross_predios_listado_zonas.idZona         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_solicitud_aplicacion_listado_cuarteles.idCategoria
LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_solicitud_aplicacion_listado_cuarteles.idProducto
WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud = ".$X_Puntero;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){

	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCuarteles,$row );
}

//Se trae un listado con los productos	
$arrTractores = array();
$query = "SELECT 
telemetria_listado.Nombre AS TelemetriaNombre,
telemetria_listado.Capacidad AS TelemetriaCapacidad,
vehiculos_listado.Nombre AS VehiculoNombre,
trabajadores_listado.Rut,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
contratista_listado.Nombre AS Contratista,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Diferencia,
AVG(cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm) AS GeoVelocidadProm,
SEC_TO_TIME( SUM( TIME_TO_SEC(cross_solicitud_aplicacion_listado_tractores.T_Aplicacion))) AS T_Aplicacion

FROM `cross_solicitud_aplicacion_listado_tractores`
LEFT JOIN `telemetria_listado`    ON telemetria_listado.idTelemetria      = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`     ON vehiculos_listado.idVehiculo         = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador    = cross_solicitud_aplicacion_listado_tractores.idTrabajador
LEFT JOIN `contratista_listado`   ON contratista_listado.idContratista    = trabajadores_listado.idContratista

WHERE cross_solicitud_aplicacion_listado_tractores.idSolicitud = ".$X_Puntero." 
GROUP BY cross_solicitud_aplicacion_listado_tractores.idTelemetria, cross_solicitud_aplicacion_listado_tractores.idVehiculo
ORDER BY telemetria_listado.Nombre ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTractores,$row );
}

//Se trae un listado con los productos	
$arrTracxCuartel = array();
$query = "SELECT 
cross_solicitud_aplicacion_listado_cuarteles.idZona,
telemetria_listado.Nombre AS TelemetriaNombre,
vehiculos_listado.Nombre AS VehiculoNombre,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Diferencia

FROM `cross_solicitud_aplicacion_listado_tractores`
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                           = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                              = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles  = cross_solicitud_aplicacion_listado_tractores.idCuarteles

WHERE cross_solicitud_aplicacion_listado_tractores.idSolicitud = ".$X_Puntero." 
AND Diferencia!=0
GROUP BY cross_solicitud_aplicacion_listado_cuarteles.idZona, 
cross_solicitud_aplicacion_listado_tractores.idTelemetria, 
cross_solicitud_aplicacion_listado_tractores.idVehiculo
ORDER BY cross_solicitud_aplicacion_listado_cuarteles.idZona ASC, 
telemetria_listado.Nombre ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
			
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTracxCuartel,$row );
}

//Se trae un listado con los productos	
$arrProductos = array();
$query = "SELECT 
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
sistema_productos_uml.Nombre AS Unimed

FROM `cross_solicitud_aplicacion_listado_productos`
LEFT JOIN `productos_listado`       ON productos_listado.idProducto   = cross_solicitud_aplicacion_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = cross_solicitud_aplicacion_listado_productos.idUml
WHERE cross_solicitud_aplicacion_listado_productos.idSolicitud = ".$X_Puntero." 
GROUP BY cross_solicitud_aplicacion_listado_productos.idProducto
ORDER BY productos_listado.Nombre ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
			
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrProductos,$row );
}

//Se trae un listado con los productos	
$arrMateriales = array();
$query = "SELECT 
cross_checking_materiales_seguridad.Nombre,
cross_checking_materiales_seguridad.Codigo
FROM `cross_solicitud_aplicacion_listado_materiales`
LEFT JOIN `cross_checking_materiales_seguridad`   ON cross_checking_materiales_seguridad.idMatSeguridad   = cross_solicitud_aplicacion_listado_materiales.idMatSeguridad
WHERE cross_solicitud_aplicacion_listado_materiales.idSolicitud = ".$X_Puntero." 
ORDER BY cross_checking_materiales_seguridad.Nombre ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
			
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrMateriales,$row );
}

/*****************************************/
// Se trae un listado con el historial
$arrHistorial = array();
$query = "SELECT 
cross_solicitud_aplicacion_listado_historial.Creacion_fecha, 
cross_solicitud_aplicacion_listado_historial.Observacion,
usuarios_listado.Nombre AS Usuario,
core_estado_solicitud.Nombre AS Estado

FROM `cross_solicitud_aplicacion_listado_historial` 
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario      = cross_solicitud_aplicacion_listado_historial.idUsuario
LEFT JOIN `core_estado_solicitud`    ON core_estado_solicitud.idEstado  = cross_solicitud_aplicacion_listado_historial.idEstado
WHERE cross_solicitud_aplicacion_listado_historial.idSolicitud = ".$X_Puntero." 
ORDER BY cross_solicitud_aplicacion_listado_historial.idHistorial ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrHistorial,$row );
}

?>

<div class="row no-print">
	<div class="col-xs-12">
		<a target="new" href="view_solicitud_aplicacion_to_print.php?view=<?php echo $X_Puntero ?>" class="btn btn-default pull-right" style="margin-right: 5px;">
			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
		</a>
		<a target="new" href="view_solicitud_aplicacion_to_pdf.php?view=<?php echo $X_Puntero.'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];  ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
			<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF
		</a>
	</div>
</div>

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

		<?php echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Datos Empresa</strong>
					<address>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Empresa: '.$rowData['SistemaOrigen'].'<br/>
						Ciudad-Comuna: '.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						Dirección: '.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Identificación</strong>
					<address>
						Predio: '.$rowData['NombrePredio'].'<br/>
						Estado: '.$rowData['Estado'].'<br/>
						Temporada: '.$rowData['TemporadaCodigo'].' '.$rowData['TemporadaNombre'].'<br/>
						Estado Fenologico: '.$rowData['EstadoFenCodigo'].' '.$rowData['EstadoFenNombre'].'<br/>';
						if(isset($rowData['VariedadCat'])&&$rowData['VariedadCat']!=''){echo 'Especie: '.$rowData['VariedadCat'].'<br/>';     }else{echo 'Especie: Todas las Especies<br/>';}
						if(isset($rowData['VariedadNombre'])&&$rowData['VariedadNombre']!=''){ echo 'Variedad: '.$rowData['VariedadNombre'].'<br/>';}else{echo 'Variedad: Todas las Variedades<br/>';}
						echo '
					</address>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Datos de Solicitud</strong>
					<address>
						Prioridad: '.$rowData['NombrePrioridad'].'<br/>
						N° Solicitud: '.n_doc($rowData['NSolicitud'], 5).'<br/>
						Fecha inicio requerido: '.fecha_estandar($rowData['f_programacion']).' '.$rowData['horaProg'].'<br/>
						Fecha termino requerido: '.fecha_estandar($rowData['f_programacion_fin']).' '.$rowData['horaProg_fin'].'<br/>';
						if(isset($rowData['f_ejecucion'])&&$rowData['f_ejecucion']!='0000-00-00'){echo 'Fecha inicio programación: '.fecha_estandar($rowData['f_ejecucion']).' '.$rowData['horaEjecucion'].'<br/>';}
						if(isset($rowData['f_ejecucion_fin'])&&$rowData['f_ejecucion_fin']!='0000-00-00'){echo 'Fecha termino programación: '.fecha_estandar($rowData['f_ejecucion_fin']).' '.$rowData['horaEjecucion_fin'].'<br/>';}
						if(isset($rowData['f_termino'])&&$rowData['f_termino']!='0000-00-00'){echo 'Fecha inicio ejecución: '.fecha_estandar($rowData['f_termino']).' '.$rowData['horaTermino'].'<br/>';}
						if(isset($rowData['f_termino_fin'])&&$rowData['f_termino_fin']!='0000-00-00'){echo 'Terminado: '.fecha_estandar($rowData['f_termino_fin']).' '.$rowData['horaTermino_fin'].'<br/>';}
						echo 'Agrónomo: '.$rowData['NombreUsuario'];
						if(isset($rowData['idDosificador'])&&$rowData['idDosificador']!=0){echo 'Dosificador: '.$rowData['TrabajadorRut'].' '.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].'<br/>';}

						echo '
					</address>
				</div>
				<div class="clearfix"></div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Parámetros de Aplicación</strong>
					<address>
						Mojamiento: '.Cantidades_decimales_justos($rowData['Mojamiento']).' L/ha<br/>
						Velocidad Tractor: '.Cantidades_decimales_justos($rowData['VelTractor']).' Km/hr<br/>
						Velocidad Viento: '.Cantidades_decimales_justos($rowData['VelViento']).' Km/hr<br/>
						Temperatura Min: '.Cantidades_decimales_justos($rowData['TempMin']).' °<br/>
						Temperatura Max: '.Cantidades_decimales_justos($rowData['TempMax']).' °<br/>
						Humedad: '.Cantidades_decimales_justos($rowData['HumTempMax']).' %<br/>

					</address>
				</div>';
		?>

	</div>
	
	


	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table">
				<tbody>
					<tr class="active">
						<td><strong>Cuarteles</strong></td>
						<td><strong>Detalles</strong></td>
						<td><strong>Detalles</strong></td>
						<td><strong>Aplicacion</strong></td>
						<td><strong>% Mojamiento</strong></td>
						<td><strong>Vehiculos</strong></td>
						<td width="10"><strong>Acciones</strong></td>
					</tr>

					<?php
					//Variables
					$TotalNPlantas          = 0;
					$TotalCuartelHectareas  = 0;
					$TotalCuartelHileras    = 0;
					$TotalPlantasAplicadas  = 0;
                    $TotalLitrosAplicados   = 0;
                    $TotalMojamiento        = 0;
                         
					//recorro el listado entregado por la base de datos
					if ($arrCuarteles) {
                        //recorro
						foreach ($arrCuarteles as $cuartel) {
							//Verifico el tipo de cierre
							if(isset($cuartel['CuartelidEjecucion'])&&$cuartel['CuartelidEjecucion']==1){
								//se verifica plantas faltantes
								if(isset($cuartel['CuartelGeoDistance'])&&$cuartel['CuartelGeoDistance']!=0&&isset($cuartel['CuartelDistanciaPlant'])&&$cuartel['CuartelDistanciaPlant']!=''&&$cuartel['CuartelDistanciaPlant']!=0){
									$aplicadas = (($cuartel['CuartelGeoDistance']*1000)/$cuartel['CuartelDistanciaPlant']);		
									if($aplicadas<0){
										$aplicadas = 0;
									}
								}else{
									$aplicadas = 0;
								}
								$S_LitrosAplicados  = $cuartel['CuartelLitrosAplicados'];
								$S_VelPromedio      = $cuartel['CuartelVelPromedio'];
							}else{
								//se verifica plantas faltantes
								if(isset($cuartel['GeoDistance'])&&$cuartel['GeoDistance']!=0&&isset($cuartel['CuartelDistanciaPlant'])&&$cuartel['CuartelDistanciaPlant']!=''&&$cuartel['CuartelDistanciaPlant']!=0){
									$aplicadas = (($cuartel['GeoDistance']*1000)/$cuartel['CuartelDistanciaPlant']);		
									if($aplicadas<0){
										$aplicadas = 0;
									}
								}else{
									$aplicadas = 0;
								}
								$S_LitrosAplicados  = $cuartel['LitrosAplicados'];
								$S_VelPromedio      = $cuartel['VelPromedio'];
							}

							//Sumo Variables
							$TotalNPlantas             = $TotalNPlantas + $cuartel['NPlantas'];
							$TotalCuartelHectareas     = $TotalCuartelHectareas + $cuartel['CuartelHectareas'];
							$TotalCuartelHileras       = $TotalCuartelHileras + $cuartel['CuartelHileras'];
							$TotalPlantasAplicadas     = $TotalPlantasAplicadas + $aplicadas;
							$TotalLitrosAplicados      = $TotalLitrosAplicados + $S_LitrosAplicados;
							$TotalMojamiento           = $TotalMojamiento + $rowData['Mojamiento'];

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
							?>

							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $s_Icon.' '.$cuartel['CuartelNombre'].$cierre; ?></td>
								<td class="item-name">
									<strong>Variedad - Especie: </strong><?php echo $cuartel['CuartelEspecie'].' '.$cuartel['CuartelVariedad']; ?><br/>
									<strong>N° Plantas: </strong><?php echo Cantidades($cuartel['NPlantas'], 0); ?><br/>
									<strong>Hectareas: </strong><?php echo Cantidades($cuartel['CuartelHectareas'], 2); ?>
								</td>

								<td class="item-name">
									<strong>Año Plantacion: </strong><?php echo Cantidades($cuartel['CuartelAnoPlantacion'], 0); ?><br/>
									<strong>Hileras: </strong><?php echo Cantidades($cuartel['CuartelHileras'], 0); ?><br/>
									<strong>Distancia Plantas: </strong><?php echo Cantidades($cuartel['CuartelDistanciaPlant'], 1); ?><br/>
									<strong>Distancia Hileras: </strong><?php echo Cantidades($cuartel['CuartelDistanciaHileras'], 1); ?>
								</td>
								<td class="item-name">
									<strong>Veloc. Promedio: </strong><?php echo Cantidades($S_VelPromedio, 1); ?><br/>
									<strong>lts. Aplicados: </strong><?php echo Cantidades($S_LitrosAplicados, 0); ?><br/>
									<strong>lts. Aplicados x Hectareas: </strong><?php echo Cantidades($LitrosApliXhect, 0); ?><br/>
									<strong>Mojamiento: </strong><?php echo Cantidades_decimales_justos($rowData['Mojamiento']).' L/ha'; ?>
								</td>

								<td class="item-name"><?php echo porcentaje($LitrosApliXhect/$rowData['Mojamiento']); ?></td>
								<td class="item-name">
									<?php
										if ($arrTracxCuartel) {
											foreach ($arrTracxCuartel as $tract) {
												if($cuartel['idZona']==$tract['idZona']){
													echo '<i class="fa fa-truck" aria-hidden="true"></i> '.$tract['VehiculoNombre'].' '.$tract['TelemetriaNombre'].'<br/>';
												}
											}
										}
									?>
								</td>
								
								 
								
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a href="<?php echo 'view_solicitud_aplicacion_finalizada.php?view='.simpleEncode($cuartel['idSolicitud'], fecha_actual()).'&idZona='.simpleEncode($cuartel['idZona'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</td>
								<?php //echo '<td class="item-name">'.Cantidades($aplicadas, 0).'</td>'; ?>
                            </tr>
						<?php
						} 
						//calculo
						if(isset($TotalCuartelHectareas)&&$TotalCuartelHectareas!=0){
							$TotLitrosApliXhect = $TotalLitrosAplicados/$TotalCuartelHectareas;
						}else{
							$TotLitrosApliXhect = 0;
						}
						
						?>

						<tr class="item-row linea_punteada">
							<td class="item-name"><strong>Totales</strong></td>

							<td class="item-name">
								<strong>Total N° Plantas: </strong><?php echo Cantidades($TotalNPlantas, 0); ?><br/>
								<strong>Total Hectareas: </strong><?php echo Cantidades($TotalCuartelHectareas, 2); ?>
							</td>

							<td class="item-name">
								<strong>Total Hileras: </strong><?php echo Cantidades($TotalCuartelHileras, 0); ?><br/>
							</td>

							<td class="item-name">
								<strong>Total lts. Aplicados: </strong><?php echo Cantidades($TotalLitrosAplicados, 0); ?><br/>
								<strong>Total lts. Aplicados x Hectareas: </strong><?php echo Cantidades($TotLitrosApliXhect, 0); ?><br/>
							</td>

							<td class="item-name"><?php echo porcentaje($TotLitrosApliXhect/$rowData['Mojamiento']); ?></td>
							<td class="item-name"><strong></strong></td>
							<td class="item-name"><strong></strong></td>

						</tr>
                        <?php    
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="7">No hay cuarteles asignados</td></tr>';
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
					if ($arrProductos) {
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
					if ($arrTractores) {
						foreach ($arrTractores as $tract) {
							//Se suman cantidades
							$Capacidad = $Capacidad + $tract['TelemetriaCapacidad'];
							$NTract++;
							?>

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
					if ($arrProductos) {
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
					if ($arrMateriales) {
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

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">

	<?php if ($arrHistorial){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="4">Detalles</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th width="160">Estado</th>
					<th width="260">Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['Estado']; ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td><?php echo $doc['Observacion']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>

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
