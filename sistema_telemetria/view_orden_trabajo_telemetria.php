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
// Se trae un listado con todos los elementos
$SIS_query = '
orden_trabajo_listado.idOT,
orden_trabajo_listado.f_creacion,
orden_trabajo_listado.f_programacion,
orden_trabajo_listado.f_termino,
orden_trabajo_listado.horaProg,
orden_trabajo_listado.horaInicio,
orden_trabajo_listado.horaTermino,
orden_trabajo_listado.Observaciones,
orden_trabajo_listado.idEstado,
maquinas_listado.Nombre AS NombreMaquina,
core_estado_ot.Nombre AS NombreEstado,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_tipos.Nombre AS NombreTipo,
orden_trabajo_listado.idSupervisor,
trabajadores_listado.Nombre AS NombreTrab,
trabajadores_listado.ApellidoPat,
telemetria_listado.Nombre AS TelemetriaNombre';
$SIS_join  = '
LEFT JOIN `maquinas_listado`      ON maquinas_listado.idMaquina         = orden_trabajo_listado.idMaquina
LEFT JOIN `core_estado_ot`        ON core_estado_ot.idEstado            = orden_trabajo_listado.idEstado
LEFT JOIN `core_ot_prioridad`     ON core_ot_prioridad.idPrioridad      = orden_trabajo_listado.idPrioridad
LEFT JOIN `core_ot_tipos`         ON core_ot_tipos.idTipo               = orden_trabajo_listado.idTipo
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador  = orden_trabajo_listado.idSupervisor
LEFT JOIN `telemetria_listado`    ON telemetria_listado.idTelemetria    = orden_trabajo_listado.idTelemetria';
$SIS_where = 'orden_trabajo_listado.idOT ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Cargo,
trabajadores_listado.Rut';
$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = orden_trabajo_listado_responsable.idTrabajador';
$SIS_where = 'orden_trabajo_listado_responsable.idOT ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrTrabajadores = array();
$arrTrabajadores = db_select_array (false, $SIS_query, 'orden_trabajo_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajadores');

/***************************************************/
// Se trae un listado con todos los insumos utilizados
$SIS_query = '
insumos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS UnidadMedida,
orden_trabajo_listado_insumos.Cantidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto    = orden_trabajo_listado_insumos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'orden_trabajo_listado_insumos.idOT ='.$X_Puntero;
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'orden_trabajo_listado_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

/***************************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
productos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS UnidadMedida,
orden_trabajo_listado_productos.Cantidad AS Cantidad';
$SIS_join  = '
LEFT JOIN `productos_listado`       ON productos_listado.idProducto    = orden_trabajo_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml     = productos_listado.idUml';
$SIS_where = 'orden_trabajo_listado_productos.idOT ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'orden_trabajo_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/***************************************************/
// Se trae un listado con todos los trabajos relacionados a la orden
$SIS_query = '
orden_trabajo_listado_trabajos.NombreComponente,
orden_trabajo_listado_trabajos.Descripcion,
core_maquinas_tipo.Nombre AS SubTipo';
$SIS_join  = 'LEFT JOIN `core_maquinas_tipo` ON core_maquinas_tipo.idSubTipo = orden_trabajo_listado_trabajos.idSubTipo';
$SIS_where = 'orden_trabajo_listado_trabajos.idOT ='.$X_Puntero;
$SIS_order = 'orden_trabajo_listado_trabajos.NombreComponente ASC, orden_trabajo_listado_trabajos.Descripcion ASC';
$arrTrabajo = array();
$arrTrabajo = db_select_array (false, $SIS_query, 'orden_trabajo_listado_trabajos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajo');

?>

<div class="col-xs-12">

	<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 fcenter table-responsive">
		<div id="page-wrap">
			<div id="header"> ORDEN DE TRABAJO N° <?php echo n_doc($X_Puntero, 8); ?></div>

			<div id="customer">

				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"></td>
						</tr>
						<tr>
							<td class="meta-head">Equipo de Telemetria</td>
							<td><?php echo $rowData['TelemetriaNombre'] ?></td>
						</tr>
						<tr>
							<td class="meta-head">Maquina</td>
							<td><?php echo $rowData['NombreMaquina']?></td>
						</tr>
						<tr>
							<td class="meta-head">Prioridad</td>
							<td><?php echo $rowData['NombrePrioridad']?></td>
						</tr>
						<tr>
							<td class="meta-head">Tipo de Trabajo</td>
							<td><?php echo $rowData['NombreTipo']?></td>
						</tr>
						<tr>
							<td class="meta-head">Estado</td>
							<td><?php echo $rowData['NombreEstado']?></td>
						</tr>

						<?php if(isset($rowData['idSupervisor'])&&$rowData['idSupervisor']!=''&&$rowData['idSupervisor']!=0){ ?>
							<tr>
								<td class="meta-head">Supervisor</td>
								<td><?php echo $rowData['NombreTrab'].' '.$rowData['ApellidoPat']?></td>
							</tr>
						<?php } ?>

					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>

						<?php if($rowData['f_creacion']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha creación</td>
								<td><?php if($rowData['f_creacion']!='0000-00-00'){echo Fecha_estandar($rowData['f_creacion']);} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['f_programacion']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha programada</td>
								<td><?php if($rowData['f_programacion']!='0000-00-00'){echo Fecha_estandar($rowData['f_programacion']);} ?></td>
							</tr>
						<?php } ?>
						<?php if($rowData['f_termino']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha termino</td>
								<td><?php if($rowData['f_termino']!='0000-00-00'){echo Fecha_estandar($rowData['f_termino']);} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['horaInicio']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Hora inicio</td>
								<td><?php if($rowData['horaInicio']!='00:00:00'){echo $rowData['horaInicio'];} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['horaTermino']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Hora termino</td>
								<td><?php if($rowData['horaTermino']!='00:00:00'){echo $rowData['horaTermino'];} ?></td>
							</tr>
						<?php } ?>

						<?php if($rowData['horaProg']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Tiempo Programado</td>
								<td><?php if($rowData['horaProg']!='00:00:00'){echo $rowData['horaProg'];} ?></td>
							</tr>
						<?php } ?>

					</tbody>
				</table>
			</div>
			<table id="items">
				<tbody>

					<tr><th colspan="6">Detalle</th></tr>
					<?php
					/**********************************************************************************/
					if($arrTrabajadores!=false && !empty($arrTrabajadores) && $arrTrabajadores!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Trabajadores</td></tr>
						<?php foreach ($arrTrabajadores as $trab) {  ?>
							<tr class="item-row linea_punteada">
								<td class="item-name"><?php echo $trab['Rut']; ?></td>
								<td class="item-name" colspan="4"><?php echo $trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat']; ?></td>
								<td class="item-name"><?php echo $trab['Cargo']; ?></td>
							</tr>
						<?php } ?>
						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php }
					/**********************************************************************************/
					if($arrInsumos!=false && !empty($arrInsumos) && $arrInsumos!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Insumos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Utilizados';} ?></td></tr>
						<?php foreach ($arrInsumos as $insumos) {
							if(isset($insumos['Cantidad'])&&$insumos['Cantidad']!=0){ ?>
								<tr class="item-row linea_punteada">
									<td class="item-name" colspan="5"><?php echo $insumos['NombreProducto']; if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){echo ' - '.$prod['NombreBodega'];} ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($insumos['Cantidad']).' '.$insumos['UnidadMedida']; ?></td>
								</tr>
							<?php
							}
						} ?>
						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php }
					/**********************************************************************************/
					if($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Productos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Utilizados';} ?></td></tr>
						<?php foreach ($arrProductos as $prod) {
							if(isset($prod['Cantidad'])&&$prod['Cantidad']!=0){ ?>
								<tr class="item-row linea_punteada">
									<td class="item-name" colspan="5"><?php echo $prod['NombreProducto']; if(isset($rowData['NombreBodega'])&&$rowData['NombreBodega']!=''){echo ' - '.$prod['NombreBodega'];} ?></td>
									<td class="item-name"><?php echo Cantidades_decimales_justos($prod['Cantidad']).' '.$prod['UnidadMedida']; ?></td>
								</tr>
							<?php
							}
						} ?>
						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php }
					/**********************************************************************************/
					if($arrTrabajo!=false && !empty($arrTrabajo) && $arrTrabajo!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Trabajos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Ejecutados';} ?></td></tr>
						<?php foreach ($arrTrabajo as $trab) {  ?>
							<tr class="item-row linea_punteada">
								<td class="item-name" colspan="2"><?php echo $trab['NombreComponente']; ?></td>
								<td class="item-name" colspan="1"><?php echo $trab['SubTipo']; ?></td>
								<td class="item-name" colspan="3"><?php echo $trab['Descripcion']; ?></td>
							</tr>
						<?php } ?>
						<tr id="hiderow"><td colspan="6"></td></tr>
					<?php }
					/**********************************************************************************/?>

					<tr><td colspan="6" class="blank"><p><?php echo $rowData['Observaciones']?></p></td></tr>
					<tr><td colspan="6" class="blank"><p>Observacion</p></td></tr>

				</tbody>
			</table>
			<div class="clearfix"></div>
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
