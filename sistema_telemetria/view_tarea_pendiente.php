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
tareas_pendientes_listado.f_creacion,
tareas_pendientes_listado.Nombre,
tareas_pendientes_listado.f_termino,
tareas_pendientes_listado.Observaciones,
tareas_pendientes_listado.f_cierre,
tareas_pendientes_listado.ObservacionesCierre,

core_sistemas.Nombre AS Sistema,
creador.Nombre AS Creador,
core_tareas_pendientes_estados.Nombre AS Estado,
core_tareas_pendientes_prioridad.Nombre AS Prioridad,
core_tareas_pendientes_tipos.Nombre AS Tipo,
cancel.Nombre AS Cancelador';
$SIS_join  = '
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                      = tareas_pendientes_listado.idSistema
LEFT JOIN `usuarios_listado`        creador  ON creador.idUsuario                            = tareas_pendientes_listado.idUsuario
LEFT JOIN `core_tareas_pendientes_estados`   ON core_tareas_pendientes_estados.idEstado      = tareas_pendientes_listado.idEstado
LEFT JOIN `core_tareas_pendientes_prioridad` ON core_tareas_pendientes_prioridad.idPrioridad = tareas_pendientes_listado.idPrioridad
LEFT JOIN `core_tareas_pendientes_tipos`     ON core_tareas_pendientes_tipos.idTipo          = tareas_pendientes_listado.idTipo
LEFT JOIN `usuarios_listado`         cancel  ON cancel.idUsuario                             = tareas_pendientes_listado.idUsuarioCierre';
$SIS_where = 'tareas_pendientes_listado.idTareas ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
usuarios_listado.Nombre';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = tareas_pendientes_listado_responsable.idUsuario';
$SIS_where = 'tareas_pendientes_listado_responsable.idTareas ='.$X_Puntero;
$SIS_order = 'usuarios_listado.Nombre ASC';
$arrRepresentantes = array();
$arrRepresentantes = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_responsable', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRepresentantes');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
core_tareas_pendientes_estados_tareas.Nombre AS EstadoTarea,
usuarios_listado.Nombre AS Usuario,
tareas_pendientes_listado_tareas.Observacion';
$SIS_join  = '
LEFT JOIN `core_tareas_pendientes_estados_tareas`   ON core_tareas_pendientes_estados_tareas.idEstadoTarea   = tareas_pendientes_listado_tareas.idEstadoTarea
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                            = tareas_pendientes_listado_tareas.idUsuario';
$SIS_where = 'tareas_pendientes_listado_tareas.idTareas ='.$X_Puntero;
$SIS_order = 'core_tareas_pendientes_estados_tareas.Nombre ASC, usuarios_listado.Nombre ASC, tareas_pendientes_listado_tareas.Observacion ASC';
$arrTareas = array();
$arrTareas = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_tareas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTareas');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = 'NombreArchivo';
$SIS_join  = '';
$SIS_where = 'idTareas ='.$X_Puntero;
$SIS_order = 'NombreArchivo ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_tareas_adjuntos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

/***************************************************/
//Se traen a todos los trabajadores relacionados a las ot
$SIS_query = '
tareas_pendientes_listado_historial.Creacion_fecha,
tareas_pendientes_listado_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`  ON core_historial_tipos.idTipo = tareas_pendientes_listado_historial.idTipo
LEFT JOIN `usuarios_listado`      ON usuarios_listado.idUsuario  = tareas_pendientes_listado_historial.idUsuario';
$SIS_where = 'tareas_pendientes_listado_historial.idTareas ='.$X_Puntero;
$SIS_order = 'tareas_pendientes_listado_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'tareas_pendientes_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/*********************************************************/
if(isset($rowData['Cancelador'])&&$rowData['Cancelador']!=''){ ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="bs-callout bs-callout-danger" >
			<h4>Tarea Pendiente cancelada</h4>
			<p>
				Usuario Cancelacion: <?php echo $rowData['Cancelador']; ?><br/>
				Fecha Cancelacion: <?php echo fecha_estandar($rowData['f_cierre']); ?><br/>
				Motivo Cancelacion: <?php echo $rowData['ObservacionesCierre']; ?>
			</p>
		</div>
	</div>

<?php } ?>
<?php
//Agrego el boton crear solo si se tiene acceso a la transaccion o es superadministrador
if((isset($_GET['editForm'])&&$_GET['editForm']='true') OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1) {
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar" style="margin-top:15px;">';
		echo '<a target="_blank" rel="noopener noreferrer" href="tareas_pendientes_listado_editar.php?view='.$_GET['view'].'" class="btn btn-success pull-right margin_width fmrbtn" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Tarea</a>';
	echo '</div>';
	echo '<div class="clearfix"></div>';
} ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="margin-bottom:30px!important;margin-top:30px!important;">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div id="page-wrap">
			<div id="header"> TAREAS PENDIENTES</div>

			<div id="customer">
				<table id="meta" class="pull-left otdata">
					<tbody>
						<tr>
							<td class="meta-head"><strong>DATOS BASICOS</strong></td>
							<td class="meta-head"></td>
						</tr>
						<tr>
							<td class="meta-head">Estado</td>
							<td><?php echo $rowData['Estado']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Prioridad</td>
							<td><?php echo $rowData['Prioridad']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Tipo de Tarea</td>
							<td><?php echo $rowData['Tipo']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Nombre de la Tarea</td>
							<td><?php echo $rowData['Nombre']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Creador</td>
							<td><?php echo $rowData['Creador']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Sistema</td>
							<td><?php echo $rowData['Sistema']; ?></td>
						</tr>
					</tbody>
				</table>
				<table id="meta" class="otdata2">
					<tbody>
						<tr>
							<td class="meta-head">Fecha Creacion</td>
							<td><?php echo Fecha_estandar($rowData['f_creacion']); ?></td>
						</tr>
						<?php if(isset($rowData['f_termino'])&&$rowData['f_termino']!='0000-00-00'){ ?>
							<tr>
								<td class="meta-head">Fecha Termino</td>
								<td><?php echo Fecha_estandar($rowData['f_termino']); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<table id="items">
				<tbody>

					<tr><th colspan="6">Detalle</th></tr>
					<?php 
					/**********************************************************************************/?>
					<tr class="item-row fact_tittle"><td colspan="6">Tarea</td></tr>
					<tr class="item-row linea_punteada" style="white-space: initial;">
						<td colspan="6"><?php echo $rowData['Observaciones']; ?></td>
					</tr>
					<?php 
					/**********************************************************************************/
					if($arrRepresentantes!=false && !empty($arrRepresentantes) && $arrRepresentantes!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Responsables</td></tr>
						<?php foreach ($arrRepresentantes as $trab) {  ?>
							<tr class="item-row linea_punteada">
								<td colspan="6"><?php echo $trab['Nombre']; ?></td>
							</tr>
						<?php } ?>
					<?php } 
					/**********************************************************************************/
					if($arrTareas!=false && !empty($arrTareas) && $arrTareas!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Trabajos a Realizar</td></tr>
						<?php foreach ($arrTareas as $trab) {  ?>
							<tr class="item-row linea_punteada">
								<td colspan="5"><?php echo '<strong>'.$trab['Usuario'].': </strong>'.$trab['Observacion']; ?></td>
								<td width="160"><?php echo $trab['EstadoTarea']; ?></td>
							</tr>
						<?php } ?>
					<?php } 
					/**********************************************************************************/
					if($arrArchivos!=false && !empty($arrArchivos) && $arrArchivos!='') { ?>
						<tr class="item-row fact_tittle"><td colspan="6">Archivos Adjuntos</td></tr>
						<?php foreach ($arrArchivos as $producto){ ?>
							<tr class="item-row linea_punteada">
								<td colspan="5"><?php echo $producto['NombreArchivo']; ?></td>
								<td width="160">
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['NombreArchivo'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
										<a href="1download.php?dir=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['NombreArchivo'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip" ><i class="fa fa-download" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>

				</tbody>
			</table>
			<div class="clearfix"></div>
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
						<th width="120">Fecha</th>
						<th>Usuario</th>
						<th>Observacion</th>
					</tr>
					<?php foreach ($arrHistorial as $doc){ ?>
						<tr class="">
							<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
							<td><?php echo $doc['Usuario']; ?></td>
							<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
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
