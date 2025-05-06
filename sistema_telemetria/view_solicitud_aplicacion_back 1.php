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
cross_solicitud_aplicacion_listado.f_creacion,
cross_solicitud_aplicacion_listado.f_programacion,
cross_solicitud_aplicacion_listado.f_ejecucion,
cross_solicitud_aplicacion_listado.f_termino,
cross_solicitud_aplicacion_listado.horaProg,
cross_solicitud_aplicacion_listado.horaEjecucion,
cross_solicitud_aplicacion_listado.horaTermino,
cross_solicitud_aplicacion_listado.Mojamiento, 
cross_solicitud_aplicacion_listado.VelTractor, 
cross_solicitud_aplicacion_listado.VelViento, 
cross_solicitud_aplicacion_listado.TempMin, 
cross_solicitud_aplicacion_listado.TempMax,

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

core_cross_prioridad.Nombre AS NombrePrioridad

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
cross_solicitud_aplicacion_listado_cuarteles.idCuarteles,
cross_solicitud_aplicacion_listado_cuarteles.Mojamiento,
cross_solicitud_aplicacion_listado_cuarteles.VelTractor,
cross_solicitud_aplicacion_listado_cuarteles.VelViento,
cross_solicitud_aplicacion_listado_cuarteles.TempMin,
cross_solicitud_aplicacion_listado_cuarteles.TempMax,
cross_solicitud_aplicacion_listado_cuarteles.idEstado,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
cross_predios_listado_zonas.Nombre AS Cuartel

FROM `cross_solicitud_aplicacion_listado_cuarteles` 
LEFT JOIN `cross_predios_listado_zonas`    ON cross_predios_listado_zonas.idZona    = cross_solicitud_aplicacion_listado_cuarteles.idZona
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
cross_solicitud_aplicacion_listado_tractores.idTractores,
cross_solicitud_aplicacion_listado_tractores.idCuarteles,
telemetria_listado.Nombre,
vehiculos_listado.Nombre AS VehiculoNombre,
trabajadores_listado.Rut,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat

FROM `cross_solicitud_aplicacion_listado_tractores`
LEFT JOIN `telemetria_listado`    ON telemetria_listado.idTelemetria      = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`     ON vehiculos_listado.idVehiculo         = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador    = cross_solicitud_aplicacion_listado_tractores.idTrabajador
WHERE cross_solicitud_aplicacion_listado_tractores.idSolicitud = ".$X_Puntero." 
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
$arrTrac = array();
foreach ($arrTractores as $prod) {
	$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['idTractores']     = $prod['idTractores'];
	$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['Nombre']          = $prod['Nombre'];
	$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['VehiculoNombre']  = $prod['VehiculoNombre'];
	$arrTrac[$prod['idCuarteles']][$prod['idTractores']]['Trabajador']      = $prod['Rut'].' - '.$prod['Nombre'].' '.$prod['ApellidoPat'];
}

//Se trae un listado con los productos	
$arrProductos = array();
$query = "SELECT 
cross_solicitud_aplicacion_listado_productos.idProdQuim,
cross_solicitud_aplicacion_listado_productos.idCuarteles,
cross_solicitud_aplicacion_listado_productos.DosisRecomendada,
cross_solicitud_aplicacion_listado_productos.DosisAplicar,
cross_solicitud_aplicacion_listado_productos.Objetivo,
productos_listado.Nombre AS Producto,
sistema_productos_uml.Nombre AS Unimed

FROM `cross_solicitud_aplicacion_listado_productos`
LEFT JOIN `productos_listado`       ON productos_listado.idProducto   = cross_solicitud_aplicacion_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = cross_solicitud_aplicacion_listado_productos.idUml
WHERE cross_solicitud_aplicacion_listado_productos.idSolicitud = ".$X_Puntero." 
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
$arrProd = array();
foreach ($arrProductos as $prod) {
	$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['idProdQuim']       = $prod['idProdQuim'];
	$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['DosisRecomendada'] = $prod['DosisRecomendada'];
	$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['DosisAplicar']     = $prod['DosisAplicar'];
	$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['Objetivo']         = $prod['Objetivo'];
	$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['Producto']         = $prod['Producto'];
	$arrProd[$prod['idCuarteles']][$prod['idProdQuim']]['Unimed']           = $prod['Unimed'];
}

/*****************************************/
// Se trae un listado con el historial
$arrHistorial = array();
$query = "SELECT 
cross_solicitud_aplicacion_listado_historial.Creacion_fecha, 
cross_solicitud_aplicacion_listado_historial.Observacion,
usuarios_listado.Nombre AS Usuario

FROM `cross_solicitud_aplicacion_listado_historial` 
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = cross_solicitud_aplicacion_listado_historial.idUsuario
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
					<strong>Empresa Origen</strong>
					<address>
						Empresa: '.$rowData['SistemaOrigen'].'<br/>
						Ciudad-Comuna: '.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
						Dirección: '.$rowData['SistemaOrigenDireccion'].'<br/>
						Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
						Rut: '.$rowData['SistemaOrigenRut'].'<br/>
						Email: '.$rowData['SistemaOrigenEmail'].'
					</address>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Identificación</strong>
					<address>
						Predio: '.$rowData['NombrePredio'].'<br/>
						Estado: '.$rowData['Estado'].'<br/>
						Temporada: '.$rowData['TemporadaCodigo'].' '.$rowData['TemporadaNombre'].'<br/>
						Estado Fenologico: '.$rowData['EstadoFenCodigo'].' '.$rowData['EstadoFenNombre'].'<br/>
						Especie: '.$rowData['VariedadCat'].'<br/>
						Variedad: '.$rowData['VariedadNombre'].'<br/>
					</address>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Datos de Solicitud</strong>
					<address>
						N° Solicitud: '.n_doc($rowData['idSolicitud'], 5).'<br/>
						Programado: '.fecha_estandar($rowData['f_programacion']).' '.$rowData['horaProg'].'<br/>';
						if(isset($rowData['f_ejecucion'])&&$rowData['f_ejecucion']!='0000-00-00'){echo 'Ejecutado: '.fecha_estandar($rowData['f_ejecucion']).' '.$rowData['horaEjecucion'].'<br/>';}
						if(isset($rowData['f_termino'])&&$rowData['f_termino']!='0000-00-00'){echo 'Terminado: '.fecha_estandar($rowData['f_termino']).' '.$rowData['horaTermino'].'<br/>';}
						echo 'Agrónomo: '.$rowData['NombreUsuario'].'
					</address>
				</div>';
		?>

	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table">
				<tbody>

					<?php /**********************************************************************************/?>
					<tr class="active">
						<td><strong>Cuarteles</strong></td>
						<td><strong>Mojamiento</strong></td>
						<td><strong>Vel. Tractor</strong></td>
						<td><strong>Vel. Viento</strong></td>
						<td><strong>Temp Min</strong></td>
						<td><strong>Temp Max</strong></td>
					</tr>
					<?php
					//recorro el lsiatdo entregado por la base de datos
					if ($arrCuarteles) {
						foreach ($arrCuarteles as $cuartel) { ?>

							<tr class="item-row linea_punteada" style="background: #eee;">
								<td class="item-name"><?php echo $cuartel['Cuartel'];if(isset($cuartel['idEstado'])&&$cuartel['idEstado']==2){ echo '(Cerrado el '.fecha_estandar($cuartel['f_cierre']).')';} ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['Mojamiento']).' L/ha'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['VelTractor']).' Km/hr'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['VelViento']).' Km/hr'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['TempMin']).' °'; ?></td>
								<td class="item-name"><?php echo Cantidades_decimales_justos($cuartel['TempMax']).' °'; ?></td>
							</tr>
							<?php
							if($arrTrac[$cuartel['idCuarteles']]){
								//Se recorren los tractores
								foreach ($arrTrac[$cuartel['idCuarteles']] as $tract){ ?>
									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="2"><i class="fa fa-truck" aria-hidden="true"></i> <?php echo '<strong>Tractor: </strong>'.$tract['VehiculoNombre']; ?></td>
										<td class="item-name" colspan="2"><?php echo '<strong>Equipo Aplicación: </strong>'.$tract['Nombre']; ?></td>
										<td class="item-name" colspan="2"><?php echo '<strong>Trabajador: </strong>'.$tract['Trabajador']; ?></td>
									</tr>
								<?php
								}
							}
							if($arrProd[$cuartel['idCuarteles']]){
								//Se recorren los quimicos a utilizar
								foreach ($arrProd[$cuartel['idCuarteles']] as $prod){ ?>

									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="3">
											<i class="fa fa-flask" aria-hidden="true"></i>
											<?php echo '<strong>Producto Químico: </strong>'.$prod['Producto']; ?><br/>
											<?php echo '<strong>Objetivo: </strong>'.$prod['Objetivo']; ?><br/>
										</td>
										<td class="item-name" colspan="3">
											<?php echo '<strong>Dosis Recomendada: </strong>'.Cantidades_decimales_justos($prod['DosisRecomendada']).' '.$prod['Unimed']; ?><br/>
											<?php echo '<strong>Dosis a aplicar: </strong>'.Cantidades_decimales_justos($prod['DosisAplicar']).' '.$prod['Unimed']; ?><br/>
										</td>
									</tr>

								<?php
								}
							}
						}
					}else{
						echo '<tr class="item-row linea_punteada"><td colspan="6">No hay cuarteles asignados</td></tr>';
					} ?>

					
				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
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
