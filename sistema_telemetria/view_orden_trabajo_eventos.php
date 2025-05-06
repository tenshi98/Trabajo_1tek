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
orden_trabajo_eventos_listado.Fecha,
orden_trabajo_eventos_listado.Hora,
orden_trabajo_eventos_listado.Observacion,
core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
trabajadores_listado.ApellidoPat AS TrabApellidoPat,
trabajadores_listado.ApellidoMat AS TrabApellidoMat,
trabajadores_listado.Nombre AS TrabNombre,
maquinas_listado.Nombre AS NombreMaquina,
clientes_listado.Nombre AS NombreCliente';
$SIS_join  = '
LEFT JOIN `usuarios_listado`      ON usuarios_listado.idUsuario         = orden_trabajo_eventos_listado.idUsuario
LEFT JOIN `core_sistemas`         ON core_sistemas.idSistema            = orden_trabajo_eventos_listado.idSistema
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador  = orden_trabajo_eventos_listado.idTrabajador
LEFT JOIN `maquinas_listado`      ON maquinas_listado.idMaquina         = orden_trabajo_eventos_listado.idMaquina
LEFT JOIN `clientes_listado`      ON clientes_listado.idCliente         = orden_trabajo_eventos_listado.idCliente';
$SIS_where = 'orden_trabajo_eventos_listado.idEvento ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_eventos_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************/
//Listado de archivos
$SIS_query = 'idArchivo, Nombre';
$SIS_join  = '';
$SIS_where = 'idEvento ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'orden_trabajo_eventos_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Detalle del evento</h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/mantencion_event.jpg">
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Evento</h2>
						<p class="text-muted">
							<strong>Usuario Ingreso : </strong><?php echo $rowData['Usuario']; ?><br/>
							<strong>Trabajador : </strong><?php echo $rowData['TrabApellidoPat'].' '.$rowData['TrabApellidoMat'].' '.$rowData['TrabNombre']; ?><br/>
							<strong>Maquina : </strong><?php if(isset($rowData['NombreCliente'])&&$rowData['NombreCliente']!=''){echo $rowData['NombreCliente'].' - '.$rowData['NombreMaquina'];}else{echo $rowData['NombreMaquina'];} ?><br/>
							<strong>Fecha : </strong><?php echo $rowData['Fecha']; ?><br/>
							<strong>Hora : </strong><?php echo $rowData['Hora']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowData['Sistema']; ?><br/>

						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Observacion</h2>
						<p class="text-muted word_break">
							<div class="text-muted well well-sm no-shadow">
								<?php if(isset($rowData['Observacion'])&&$rowData['Observacion']!=''){echo $rowData['Observacion'];}else{echo 'Sin Observaciones';} ?>
								<div class="clearfix"></div>
							</div>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos Adjuntos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php foreach ($arrArchivos as $tipo) {
									echo '
										<tr class="item-row">
											<td>'.$tipo['Nombre'].'</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($tipo['Nombre'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($tipo['Nombre'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								?>
							</tbody>
						</table>

					</div>
					<div class="clearfix"></div>

				</div>
			</div>

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
