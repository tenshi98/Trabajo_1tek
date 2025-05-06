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
orden_trabajo_tareas_listado.idOT,
orden_trabajo_tareas_listado.f_creacion,
orden_trabajo_tareas_listado.f_programacion,
orden_trabajo_tareas_listado.f_termino,
orden_trabajo_tareas_listado.hora_Inicio,
orden_trabajo_tareas_listado.hora_Termino,
orden_trabajo_tareas_listado.Observaciones,
orden_trabajo_tareas_listado.idEstado,

core_estado_ot_motivos.Nombre AS NombreEstado,
core_ot_prioridad.Nombre AS NombrePrioridad,
core_ot_motivos_tipos.Nombre AS NombreTipo,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,

usuarios_listado.Nombre AS CancelUsuario,
orden_trabajo_tareas_listado.f_cancel AS CancelFecha,
orden_trabajo_tareas_listado.ObservacionesCancel AS CancelObservacion';
$SIS_join  = '
LEFT JOIN `core_estado_ot_motivos`     ON core_estado_ot_motivos.idEstado       = orden_trabajo_tareas_listado.idEstado
LEFT JOIN `core_ot_prioridad`          ON core_ot_prioridad.idPrioridad         = orden_trabajo_tareas_listado.idPrioridad
LEFT JOIN `core_ot_motivos_tipos`      ON core_ot_motivos_tipos.idTipo          = orden_trabajo_tareas_listado.idTipo
LEFT JOIN `ubicacion_listado`          ON ubicacion_listado.idUbicacion         = orden_trabajo_tareas_listado.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`  ON ubicacion_listado_level_1.idLevel_1   = orden_trabajo_tareas_listado.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`  ON ubicacion_listado_level_2.idLevel_2   = orden_trabajo_tareas_listado.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`  ON ubicacion_listado_level_3.idLevel_3   = orden_trabajo_tareas_listado.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`  ON ubicacion_listado_level_4.idLevel_4   = orden_trabajo_tareas_listado.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`  ON ubicacion_listado_level_5.idLevel_5   = orden_trabajo_tareas_listado.idUbicacion_lvl_5
LEFT JOIN `usuarios_listado`           ON usuarios_listado.idUsuario            = orden_trabajo_tareas_listado.idUsuarioCancel';
$SIS_where = 'orden_trabajo_tareas_listado.idOT ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Cargo, 
trabajadores_listado.Rut';
$SIS_join  = 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador = orden_trabajo_tareas_listado_responsable.idTrabajador';
$SIS_where = 'orden_trabajo_tareas_listado_responsable.idOT ='.$X_Puntero;
$SIS_order = 'trabajadores_listado.ApellidoPat ASC';
$arrTrabajadores = array();
$arrTrabajadores = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTrabajadores');

/***************************************************/
// Se trae un listado con todos los insumos utilizados
$SIS_query = '
insumos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS UnidadMedida,
orden_trabajo_tareas_listado_insumos.Cantidad';
$SIS_join  = '
LEFT JOIN `insumos_listado`         ON insumos_listado.idProducto    = orden_trabajo_tareas_listado_insumos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = insumos_listado.idUml';
$SIS_where = 'orden_trabajo_tareas_listado_insumos.idOT ='.$X_Puntero;
$SIS_order = 'insumos_listado.Nombre ASC';
$arrInsumos = array();
$arrInsumos = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

/***************************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
productos_listado.Nombre AS NombreProducto,
sistema_productos_uml.Nombre AS UnidadMedida,
orden_trabajo_tareas_listado_productos.Cantidad AS Cantidad';
$SIS_join  = '
LEFT JOIN `productos_listado`       ON productos_listado.idProducto    = orden_trabajo_tareas_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml     = productos_listado.idUml';
$SIS_where = 'orden_trabajo_tareas_listado_productos.idOT ='.$X_Puntero;
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/***************************************************/
// Se trae un listado con todos los trabajos relacionados a la orden
$SIS_query = '
orden_trabajo_tareas_listado_tareas.idTrabajoOT,
orden_trabajo_tareas_listado_tareas.Observacion,
core_estado_ot_motivos_tareas.Nombre AS EstadoTarea,
licitacion_listado.Nombre AS Licitacion,
licitacion_listado_level_1.Nombre AS LicitacionLVL_1,
licitacion_listado_level_2.Nombre AS LicitacionLVL_2,
licitacion_listado_level_3.Nombre AS LicitacionLVL_3,
licitacion_listado_level_4.Nombre AS LicitacionLVL_4,
licitacion_listado_level_5.Nombre AS LicitacionLVL_5,
licitacion_listado_level_6.Nombre AS LicitacionLVL_6,
licitacion_listado_level_7.Nombre AS LicitacionLVL_7,
licitacion_listado_level_8.Nombre AS LicitacionLVL_8,
licitacion_listado_level_9.Nombre AS LicitacionLVL_9,
licitacion_listado_level_10.Nombre AS LicitacionLVL_10,
licitacion_listado_level_11.Nombre AS LicitacionLVL_11,
licitacion_listado_level_12.Nombre AS LicitacionLVL_12,
licitacion_listado_level_13.Nombre AS LicitacionLVL_13,
licitacion_listado_level_14.Nombre AS LicitacionLVL_14,
licitacion_listado_level_15.Nombre AS LicitacionLVL_15,
licitacion_listado_level_16.Nombre AS LicitacionLVL_16,
licitacion_listado_level_17.Nombre AS LicitacionLVL_17,
licitacion_listado_level_18.Nombre AS LicitacionLVL_18,
licitacion_listado_level_19.Nombre AS LicitacionLVL_19,
licitacion_listado_level_20.Nombre AS LicitacionLVL_20,
licitacion_listado_level_21.Nombre AS LicitacionLVL_21,
licitacion_listado_level_22.Nombre AS LicitacionLVL_22,
licitacion_listado_level_23.Nombre AS LicitacionLVL_23,
licitacion_listado_level_24.Nombre AS LicitacionLVL_24,
licitacion_listado_level_25.Nombre AS LicitacionLVL_25';
$SIS_join  = '
LEFT JOIN `core_estado_ot_motivos_tareas`  ON core_estado_ot_motivos_tareas.idEstadoTarea   = orden_trabajo_tareas_listado_tareas.idEstadoTarea
LEFT JOIN `licitacion_listado`             ON licitacion_listado.idLicitacion               = orden_trabajo_tareas_listado_tareas.idLicitacion
LEFT JOIN `licitacion_listado_level_1`     ON licitacion_listado_level_1.idLevel_1          = orden_trabajo_tareas_listado_tareas.idLevel_1
LEFT JOIN `licitacion_listado_level_2`     ON licitacion_listado_level_2.idLevel_2          = orden_trabajo_tareas_listado_tareas.idLevel_2
LEFT JOIN `licitacion_listado_level_3`     ON licitacion_listado_level_3.idLevel_3          = orden_trabajo_tareas_listado_tareas.idLevel_3
LEFT JOIN `licitacion_listado_level_4`     ON licitacion_listado_level_4.idLevel_4          = orden_trabajo_tareas_listado_tareas.idLevel_4
LEFT JOIN `licitacion_listado_level_5`     ON licitacion_listado_level_5.idLevel_5          = orden_trabajo_tareas_listado_tareas.idLevel_5
LEFT JOIN `licitacion_listado_level_6`     ON licitacion_listado_level_6.idLevel_6          = orden_trabajo_tareas_listado_tareas.idLevel_6
LEFT JOIN `licitacion_listado_level_7`     ON licitacion_listado_level_7.idLevel_7          = orden_trabajo_tareas_listado_tareas.idLevel_7
LEFT JOIN `licitacion_listado_level_8`     ON licitacion_listado_level_8.idLevel_8          = orden_trabajo_tareas_listado_tareas.idLevel_8
LEFT JOIN `licitacion_listado_level_9`     ON licitacion_listado_level_9.idLevel_9          = orden_trabajo_tareas_listado_tareas.idLevel_9
LEFT JOIN `licitacion_listado_level_10`    ON licitacion_listado_level_10.idLevel_10        = orden_trabajo_tareas_listado_tareas.idLevel_10
LEFT JOIN `licitacion_listado_level_11`    ON licitacion_listado_level_11.idLevel_11        = orden_trabajo_tareas_listado_tareas.idLevel_11
LEFT JOIN `licitacion_listado_level_12`    ON licitacion_listado_level_12.idLevel_12        = orden_trabajo_tareas_listado_tareas.idLevel_12
LEFT JOIN `licitacion_listado_level_13`    ON licitacion_listado_level_13.idLevel_13        = orden_trabajo_tareas_listado_tareas.idLevel_13
LEFT JOIN `licitacion_listado_level_14`    ON licitacion_listado_level_14.idLevel_14        = orden_trabajo_tareas_listado_tareas.idLevel_14
LEFT JOIN `licitacion_listado_level_15`    ON licitacion_listado_level_15.idLevel_15        = orden_trabajo_tareas_listado_tareas.idLevel_15
LEFT JOIN `licitacion_listado_level_16`    ON licitacion_listado_level_16.idLevel_16        = orden_trabajo_tareas_listado_tareas.idLevel_16
LEFT JOIN `licitacion_listado_level_17`    ON licitacion_listado_level_17.idLevel_17        = orden_trabajo_tareas_listado_tareas.idLevel_17
LEFT JOIN `licitacion_listado_level_18`    ON licitacion_listado_level_18.idLevel_18        = orden_trabajo_tareas_listado_tareas.idLevel_18
LEFT JOIN `licitacion_listado_level_19`    ON licitacion_listado_level_19.idLevel_19        = orden_trabajo_tareas_listado_tareas.idLevel_19
LEFT JOIN `licitacion_listado_level_20`    ON licitacion_listado_level_20.idLevel_20        = orden_trabajo_tareas_listado_tareas.idLevel_20
LEFT JOIN `licitacion_listado_level_21`    ON licitacion_listado_level_21.idLevel_21        = orden_trabajo_tareas_listado_tareas.idLevel_21
LEFT JOIN `licitacion_listado_level_22`    ON licitacion_listado_level_22.idLevel_22        = orden_trabajo_tareas_listado_tareas.idLevel_22
LEFT JOIN `licitacion_listado_level_23`    ON licitacion_listado_level_23.idLevel_23        = orden_trabajo_tareas_listado_tareas.idLevel_23
LEFT JOIN `licitacion_listado_level_24`    ON licitacion_listado_level_24.idLevel_24        = orden_trabajo_tareas_listado_tareas.idLevel_24
LEFT JOIN `licitacion_listado_level_25`    ON licitacion_listado_level_25.idLevel_25        = orden_trabajo_tareas_listado_tareas.idLevel_25';
$SIS_where = 'orden_trabajo_tareas_listado_tareas.idOT ='.$X_Puntero;
$SIS_order = 'licitacion_listado.Nombre ASC';
$arrTarea = array();
$arrTarea = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTarea');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = 'idTrabajoOT, NombreArchivo';
$SIS_join  = '';
$SIS_where = 'idOT ='.$X_Puntero;
$SIS_order = 'NombreArchivo ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas_adjuntos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

/***************************************************/
// Se trae un listado con el historial
$SIS_query = '
orden_trabajo_tareas_listado_historial.Creacion_fecha, 
orden_trabajo_tareas_listado_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = orden_trabajo_tareas_listado_historial.idTipo
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = orden_trabajo_tareas_listado_historial.idUsuario';
$SIS_where = 'orden_trabajo_tareas_listado_historial.idOT ='.$X_Puntero;
$SIS_order = 'orden_trabajo_tareas_listado_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/***************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
usuarios_listado.Nombre AS Usuario,
usuario_queja.Nombre AS UsuarioQueja,
core_tipo_queja.Nombre AS TipoQueja,
orden_trabajo_tareas_quejas.FechaQueja,
orden_trabajo_tareas_quejas.Observaciones';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                ON usuarios_listado.idUsuario      = orden_trabajo_tareas_quejas.idUsuario
LEFT JOIN `usuarios_listado` usuario_queja  ON usuario_queja.idUsuario         = orden_trabajo_tareas_quejas.idUsuarioQueja
LEFT JOIN `core_tipo_queja`                 ON core_tipo_queja.idTipoQueja     = orden_trabajo_tareas_quejas.idTipoQueja';
$SIS_where = 'orden_trabajo_tareas_quejas.idOT ='.$X_Puntero;
$SIS_order = 'orden_trabajo_tareas_quejas.idQueja DESC';
$arrQuejas = array();
$arrQuejas = db_select_array (false, $SIS_query, 'orden_trabajo_tareas_quejas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrQuejas');

if(isset($rowData['CancelUsuario'])&&$rowData['CancelUsuario']!=''){ ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="bs-callout bs-callout-danger" >
			<h4>Orden de Trabajo <?php echo n_doc($X_Puntero, 8); ?> cancelada</h4>
			<p>
				Usuario Cancelacion: <?php echo $rowData['CancelUsuario']; ?><br/>
				Fecha Cancelacion: <?php echo fecha_estandar($rowData['CancelFecha']); ?><br/>
				Motivo Cancelacion: <?php echo $rowData['CancelObservacion']; ?>
			</p>
		</div>
	</div>

<?php } ?>

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
							<td class="meta-head">Ubicación</td>
							<td>
								<?php echo $rowData['Ubicacion'];
								if(isset($rowData['UbicacionLVL_1'])&&$rowData['UbicacionLVL_1']!=''){echo ' - '.$rowData['UbicacionLVL_1'];}
								if(isset($rowData['UbicacionLVL_2'])&&$rowData['UbicacionLVL_2']!=''){echo ' - '.$rowData['UbicacionLVL_2'];}
								if(isset($rowData['UbicacionLVL_3'])&&$rowData['UbicacionLVL_3']!=''){echo ' - '.$rowData['UbicacionLVL_3'];}
								if(isset($rowData['UbicacionLVL_4'])&&$rowData['UbicacionLVL_4']!=''){echo ' - '.$rowData['UbicacionLVL_4'];}
								if(isset($rowData['UbicacionLVL_5'])&&$rowData['UbicacionLVL_5']!=''){echo ' - '.$rowData['UbicacionLVL_5'];}
								?>
							</td>
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
						<?php if($rowData['hora_Inicio']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Hora inicio</td>
								<td><?php if($rowData['hora_Inicio']!='00:00:00'){echo $rowData['hora_Inicio'];} ?></td>
							</tr>
						<?php } ?>
						<?php if($rowData['hora_Termino']!='00:00:00'){ ?>
							<tr>
								<td class="meta-head">Hora termino</td>
								<td><?php if($rowData['hora_Termino']!='00:00:00'){echo $rowData['hora_Termino'];} ?></td>
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
					if($arrTarea!=false && !empty($arrTarea) && $arrTarea!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Trabajos <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'Programados';}else{echo 'Ejecutados';} ?></td></tr>
						<?php foreach ($arrTarea as $tarea) {
							$s_tarea = $tarea['LicitacionLVL_1'];
							if(isset($tarea['LicitacionLVL_2'])&&$tarea['LicitacionLVL_2']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_2'];}
							if(isset($tarea['LicitacionLVL_3'])&&$tarea['LicitacionLVL_3']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_3'];}
							if(isset($tarea['LicitacionLVL_4'])&&$tarea['LicitacionLVL_4']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_4'];}
							if(isset($tarea['LicitacionLVL_5'])&&$tarea['LicitacionLVL_5']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_5'];}
							if(isset($tarea['LicitacionLVL_6'])&&$tarea['LicitacionLVL_6']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_6'];}
							if(isset($tarea['LicitacionLVL_7'])&&$tarea['LicitacionLVL_7']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_7'];}
							if(isset($tarea['LicitacionLVL_8'])&&$tarea['LicitacionLVL_8']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_8'];}
							if(isset($tarea['LicitacionLVL_9'])&&$tarea['LicitacionLVL_9']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_9'];}
							if(isset($tarea['LicitacionLVL_10'])&&$tarea['LicitacionLVL_10']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_10'];}
							if(isset($tarea['LicitacionLVL_11'])&&$tarea['LicitacionLVL_11']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_11'];}
							if(isset($tarea['LicitacionLVL_12'])&&$tarea['LicitacionLVL_12']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_12'];}
							if(isset($tarea['LicitacionLVL_13'])&&$tarea['LicitacionLVL_13']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_13'];}
							if(isset($tarea['LicitacionLVL_14'])&&$tarea['LicitacionLVL_14']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_14'];}
							if(isset($tarea['LicitacionLVL_15'])&&$tarea['LicitacionLVL_15']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_15'];}
							if(isset($tarea['LicitacionLVL_16'])&&$tarea['LicitacionLVL_16']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_16'];}
							if(isset($tarea['LicitacionLVL_17'])&&$tarea['LicitacionLVL_17']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_17'];}
							if(isset($tarea['LicitacionLVL_18'])&&$tarea['LicitacionLVL_18']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_18'];}
							if(isset($tarea['LicitacionLVL_19'])&&$tarea['LicitacionLVL_19']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_19'];}
							if(isset($tarea['LicitacionLVL_20'])&&$tarea['LicitacionLVL_20']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_20'];}
							if(isset($tarea['LicitacionLVL_21'])&&$tarea['LicitacionLVL_21']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_21'];}
							if(isset($tarea['LicitacionLVL_22'])&&$tarea['LicitacionLVL_22']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_22'];}
							if(isset($tarea['LicitacionLVL_23'])&&$tarea['LicitacionLVL_23']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_23'];}
							if(isset($tarea['LicitacionLVL_24'])&&$tarea['LicitacionLVL_24']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_24'];}
							if(isset($tarea['LicitacionLVL_25'])&&$tarea['LicitacionLVL_25']!=''){$s_tarea .= ' - '.$tarea['LicitacionLVL_25'];}
							?>
							<tr class="item-row linea_punteada">
								<td class="item-name">
									<strong>Estado: </strong><?php echo $tarea['EstadoTarea']; ?>
								</td>
								<td class="item-name" colspan="5">
									<strong>Licitacion: </strong><?php echo $tarea['Licitacion']; ?><br/>
									<strong>Tarea: </strong><?php echo $s_tarea; ?><br/>
									<strong>Observacion: </strong><?php echo $tarea['Observacion']; ?>
								</td>
							</tr>

							<?php if($arrArchivos!=false && !empty($arrArchivos) && $arrArchivos!=''){
								$zxcv = 0;
								foreach ($arrArchivos as $key => $arch) {
									if(isset($arch['idTrabajoOT'])&&$arch['idTrabajoOT']==$tarea['idTrabajoOT']){
										$zxcv++;
									}
								}
								if($zxcv!=0){
								?>
									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="6">
											<strong>Archivos Adjuntos Tarea: </strong><?php echo $s_tarea; ?><br/>
											<div class="row">
												<?php foreach ($arrArchivos as $key => $arch) { ?>
													<?php if(isset($arch['idTrabajoOT'])&&$arch['idTrabajoOT']==$tarea['idTrabajoOT']){ ?>
														<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
															<img src="upload/<?php echo $arch['NombreArchivo']; ?>" class="img-responsive">
														</div>
													<?php } ?>
												<?php } ?>
											</div>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>

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

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">
	<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="3">Historial</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th>Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
	<?php if ($arrQuejas!=false && !empty($arrQuejas) && $arrQuejas!=''){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="3">Quejas</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th>Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrQuejas as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['FechaQueja']); ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td>
							<?php 
							echo  '<strong>Tipo Queja:</strong>'.$doc['TipoQueja'].'<br/>';
							echo  '<strong>Usuario Queja:</strong>'.$doc['UsuarioQueja'].'<br/>';
							echo  '<strong>Queja:</strong>'.$doc['Observaciones'].'<br/>';
							?>
						</td>
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
