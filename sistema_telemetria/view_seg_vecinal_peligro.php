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
seg_vecinal_peligros_listado.Direccion,
seg_vecinal_peligros_listado.GeoLatitud,
seg_vecinal_peligros_listado.GeoLongitud,
seg_vecinal_peligros_listado.Fecha,
seg_vecinal_peligros_listado.Hora,
seg_vecinal_peligros_listado.Descripcion,
seg_vecinal_peligros_listado.FechaCreacion,

seg_vecinal_peligros_tipos.Nombre AS Tipo,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
seg_vecinal_peligros_listado.idEstado,
core_estados.Nombre AS Estado,
seg_vecinal_clientes_listado.Nombre AS Vecino,
seg_vecinal_peligros_listado.idValidado,
core_seguridad_validacion.Nombre AS Validacion';
$SIS_join  = '
LEFT JOIN `seg_vecinal_peligros_tipos`    ON seg_vecinal_peligros_tipos.idTipo      = seg_vecinal_peligros_listado.idTipo
LEFT JOIN `core_ubicacion_ciudad`         ON core_ubicacion_ciudad.idCiudad         = seg_vecinal_peligros_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`        ON core_ubicacion_comunas.idComuna        = seg_vecinal_peligros_listado.idComuna
LEFT JOIN `core_estados`                  ON core_estados.idEstado                  = seg_vecinal_peligros_listado.idEstado
LEFT JOIN `seg_vecinal_clientes_listado`  ON seg_vecinal_clientes_listado.idCliente = seg_vecinal_peligros_listado.idCliente
LEFT JOIN `core_seguridad_validacion`     ON core_seguridad_validacion.idValidado   = seg_vecinal_peligros_listado.idValidado';
$SIS_where = 'seg_vecinal_peligros_listado.idPeligro ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'seg_vecinal_peligros_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**************************************************************/
//Se traen las rutas
$SIS_query = 'idArchivo, Nombre';
$SIS_join  = '';
$SIS_where = 'idPeligro ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'seg_vecinal_peligros_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');

/**************************************************************/
// Se trae un listado con todos los comentarios
$SIS_query = '
seg_vecinal_peligros_listado_comentarios.idComentario,
seg_vecinal_peligros_listado_comentarios.idCliente,
seg_vecinal_peligros_listado_comentarios.Fecha,
seg_vecinal_peligros_listado_comentarios.Hora,
seg_vecinal_peligros_listado_comentarios.Comentario,

seg_vecinal_clientes_listado.Nombre,
seg_vecinal_clientes_listado.Direccion_img';
$SIS_join  = 'LEFT JOIN `seg_vecinal_clientes_listado` ON seg_vecinal_clientes_listado.idCliente = seg_vecinal_peligros_listado_comentarios.idCliente';
$SIS_where = 'seg_vecinal_peligros_listado_comentarios.idPeligro='.$X_Puntero;
$SIS_order = 'seg_vecinal_peligros_listado_comentarios.Fecha ASC';
$arrComentarios = array();
$arrComentarios = db_select_array (false, $SIS_query, 'seg_vecinal_peligros_listado_comentarios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrComentarios');

/************************************************/
//se cuentan los archivos
$N_Archivos = 0;
foreach ($arrArchivos as $zona) {
	$N_Archivos++;
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos de la Zona de Peligro</h5>
			<div class="toolbar"> </div>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-flag" aria-hidden="true"></i> Datos</a></li>
				<li class=""><a href="#archivos" data-toggle="tab"><span class="label label-danger"><?php echo $N_Archivos; ?></span> <i class="fa fa-file-archive-o" aria-hidden="true"></i> Archivos Adjuntos</a></li>
				<li class=""><a href="#comentarios" data-toggle="tab"><i class="fa fa-comment-o" aria-hidden="true"></i> Comentarios</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de la Zona de Peligro</h2>
							<p class="text-muted word_break">
								<strong>Vecino : </strong><?php echo $rowData['Vecino']; ?><br/>
								<strong>Tipo de Peligro : </strong><?php echo $rowData['Tipo']; ?><br/>
								<strong>Ciudad : </strong><?php echo $rowData['Ciudad']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowData['Comuna']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
								<strong>Descripcion : </strong><?php echo $rowData['Descripcion']; ?><br/>
								<strong>Estado : </strong><label class="label <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $rowData['Estado']; ?></label><br/>

							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Ocultos</h2>
							<p class="text-muted word_break">
								<strong>Fecha : </strong><?php echo fecha_estandar($rowData['Fecha']); ?><br/>
								<strong>Hora : </strong><?php echo $rowData['Hora']; ?><br/>
								<strong>Fecha Creacion: </strong><?php echo fecha_estandar($rowData['Fecha']); ?><br/>
								<strong>Validacion : </strong><label class="label <?php if(isset($rowData['idValidado'])&&$rowData['idValidado']==2){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $rowData['Validacion']; ?></label><br/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row">
						<?php
							//se arma la dirección
							$direccion = "";
							if(isset($rowData["Direccion"])&&$rowData["Direccion"]!=''){   $direccion .= $rowData["Direccion"];}
							if(isset($rowData["Comuna"])&&$rowData["Comuna"]!=''){         $direccion .= ', '.$rowData["Comuna"];}
							if(isset($rowData["Ciudad"])&&$rowData["Ciudad"]!=''){         $direccion .= ', '.$rowData["Ciudad"];}
							//se despliega mensaje en caso de no existir dirección
							if($direccion!=''){
								echo mapa_from_gps($rowData['GeoLatitud'], $rowData['GeoLongitud'], 'Zona de Peligro', 'Calle', $direccion, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 19, 2);
							}else{
								$Alert_Text = 'No tiene una dirección definida';
								alert_post_data(4,2,2,0, $Alert_Text);
							}
						?>
					</div>
				</div>
				<div class="clearfix"></div>

			</div>
			

			
			<div class="tab-pane fade" id="archivos">
				<div class="wmd-panel">

					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrArchivos as $zona) { ?>
									<tr class="odd">
										<td><?php echo $zona['Nombre']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

				</div>
			</div>

			<div class="tab-pane fade" id="comentarios">
				<div class="wmd-panel">

					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrComentarios as $comment) { ?>
									<tr class="odd">
										<td>
											<div class="header">
												<small class="text-muted" style="margin-left: 0px !important;"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $comment['Fecha'].' '.$comment['Hora']; ?></small>
												<strong class="pull-right primary-font" style="color: #337ab7;"><?php echo $comment['Nombre']; ?></strong>
											</div>
											<p style="white-space: initial;"><?php echo $comment['Comentario']; ?></p>
										
										
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

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
