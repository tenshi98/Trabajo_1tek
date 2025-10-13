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
solicitud_listado.Creacion_fecha,
solicitud_listado.Observaciones,
usuarios_listado.Nombre AS NombreUsuario,
sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario  = solicitud_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema    = solicitud_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad      = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna      = sistema_origen.idComuna';
$SIS_where = 'solicitud_listado.idSolicitud ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'solicitud_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
//Insumos
$SIS_query = '
insumos_listado.Nombre,
solicitud_listado_existencias_insumos.Cantidad,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`          ON insumos_listado.idProducto    = solicitud_listado_existencias_insumos.idProducto
LEFT JOIN `sistema_productos_uml`    ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'solicitud_listado_existencias_insumos.idSolicitud ='.$X_Puntero;
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

/*****************************************/
//Productos
$SIS_query = '
productos_listado.Nombre,
solicitud_listado_existencias_productos.Cantidad,
sistema_productos_uml.Nombre AS Unidad';
$SIS_join  = '
LEFT JOIN `productos_listado`          ON productos_listado.idProducto    = solicitud_listado_existencias_productos.idProducto
LEFT JOIN `sistema_productos_uml`      ON sistema_productos_uml.idUml     = productos_listado.idUml';
$SIS_where = 'solicitud_listado_existencias_productos.idSolicitud ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
//Arriendos
$SIS_query = '
equipos_arriendo_listado.Nombre,
solicitud_listado_existencias_arriendos.Cantidad,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `equipos_arriendo_listado`    ON equipos_arriendo_listado.idEquipo     = solicitud_listado_existencias_arriendos.idEquipo
LEFT JOIN `core_tiempo_frecuencia`      ON core_tiempo_frecuencia.idFrecuencia   = solicitud_listado_existencias_arriendos.idFrecuencia';
$SIS_where = 'solicitud_listado_existencias_arriendos.idSolicitud ='.$X_Puntero;
$SIS_order = 'equipos_arriendo_listado.Nombre ASC';
$arrArriendos = array();
$arrArriendos = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_arriendos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArriendos');

/*****************************************/
//Servicios
$SIS_query = '
servicios_listado.Nombre,
solicitud_listado_existencias_servicios.Cantidad,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = '
LEFT JOIN `servicios_listado`       ON servicios_listado.idServicio          = solicitud_listado_existencias_servicios.idServicio
LEFT JOIN `core_tiempo_frecuencia`  ON core_tiempo_frecuencia.idFrecuencia   = solicitud_listado_existencias_servicios.idFrecuencia';
$SIS_where = 'solicitud_listado_existencias_servicios.idSolicitud ='.$X_Puntero;
$SIS_order = 'servicios_listado.Nombre ASC';
$arrServicios = array();
$arrServicios = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrServicios');

/*****************************************/
//Otros
$SIS_query = '
solicitud_listado_existencias_otros.Nombre,
solicitud_listado_existencias_otros.Cantidad,
core_tiempo_frecuencia.Nombre AS Frecuencia';
$SIS_join  = 'LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = solicitud_listado_existencias_otros.idFrecuencia';
$SIS_where = 'solicitud_listado_existencias_otros.idSolicitud ='.$X_Puntero;
$SIS_order = 'solicitud_listado_existencias_otros.Nombre ASC';
$arrOtros = array();
$arrOtros = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOtros');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Solicitud de Productos.
				<small class="pull-right">Fecha Creacion: <?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 invoice-col">
			Empresa Origen
			<address>
				<strong><?php echo $rowData['SistemaOrigen']; ?></strong><br/>
				<?php echo $rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna']; ?><br/>
				<?php echo $rowData['SistemaOrigenDireccion']; ?><br/>
				Fono: <?php echo formatPhone($rowData['SistemaOrigenFono']); ?><br/>
				Rut: <?php echo $rowData['SistemaOrigenRut']; ?><br/>
				Email: <?php echo $rowData['SistemaOrigenEmail']; ?>
			</address>
		</div>

	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Detalle</th>
						<th align="right" width="160">Cantidad</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrInsumos!=false && !empty($arrInsumos) && $arrInsumos!='') { ?>
						<tr class="active"><td colspan="2"><strong>Insumos</strong></td></tr>
						<?php foreach ($arrInsumos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') { ?>
						<tr class="active"><td colspan="2"><strong>Productos</strong></td></tr>
						<?php foreach ($arrProductos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Unidad']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrArriendos!=false && !empty($arrArriendos) && $arrArriendos!='') { ?>
						<tr class="active"><td colspan="2"><strong>Arriendos</strong></td></tr>
						<?php foreach ($arrArriendos as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrServicios!=false && !empty($arrServicios) && $arrServicios!='') { ?>
						<tr class="active"><td colspan="2"><strong>Servicios</strong></td></tr>
						<?php foreach ($arrServicios as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if ($arrOtros!=false && !empty($arrOtros) && $arrOtros!='') { ?>
						<tr class="active"><td colspan="2"><strong>Otros</strong></td></tr>
						<?php foreach ($arrOtros as $prod) { ?>
							<tr>
								<td><?php echo $prod['Nombre']; ?></td>
								<td align="right"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['Frecuencia']; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
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
