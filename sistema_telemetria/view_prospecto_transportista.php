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
prospectos_transportistas_listado.Nombre,
prospectos_transportistas_listado.Fono, 
prospectos_transportistas_listado.email, 
prospectos_transportistas_listado.email_noti, 
prospectos_transportistas_listado.F_Ingreso, 

core_sistemas.Nombre AS Sistema,
prospectos_estado_fidelizacion.Nombre AS Fidelizacion,
prospectos_transportistas_etapa.Nombre AS Etapa';
$SIS_join  = '
LEFT JOIN `core_sistemas`                     ON core_sistemas.idSistema                              = prospectos_transportistas_listado.idSistema
LEFT JOIN `prospectos_estado_fidelizacion`    ON prospectos_estado_fidelizacion.idEstadoFidelizacion  = prospectos_transportistas_listado.idEstadoFidelizacion
LEFT JOIN `prospectos_transportistas_etapa`   ON prospectos_transportistas_etapa.idEtapa              = prospectos_transportistas_listado.idEtapa';
$SIS_where = 'prospectos_transportistas_listado.idProspecto ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'prospectos_transportistas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************************************/
// Se trae un listado con todas las observaciones el Prospecto
$SIS_query = '
usuarios_listado.Nombre AS nombre_usuario,
prospectos_transportistas_observaciones.Fecha,
prospectos_transportistas_observaciones.Observacion';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = prospectos_transportistas_observaciones.idUsuario';
$SIS_where = 'prospectos_transportistas_observaciones.idProspecto ='.$X_Puntero;
$SIS_order = 'prospectos_transportistas_observaciones.idObservacion ASC LIMIT 15';
$arrObservaciones = array();
$arrObservaciones = db_select_array (false, $SIS_query, 'prospectos_transportistas_observaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrObservaciones');

/**********************************************************/
// Se trae un listado con todas las etapa el Prospecto
$SIS_query = '
prospectos_transportistas_etapa_fidelizacion.idEtapaFide,
usuarios_listado.Nombre AS nombre_usuario,
prospectos_transportistas_etapa_fidelizacion.Fecha,
prospectos_transportistas_etapa.Nombre AS Etapa';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                ON usuarios_listado.idUsuario               = prospectos_transportistas_etapa_fidelizacion.idUsuario
LEFT JOIN `prospectos_transportistas_etapa` ON prospectos_transportistas_etapa.idEtapa  = prospectos_transportistas_etapa_fidelizacion.idEtapa';
$SIS_where = 'prospectos_transportistas_etapa_fidelizacion.idProspecto ='.$X_Puntero;
$SIS_order = 'prospectos_transportistas_etapa.Nombre DESC';
$arrEtapa = array();
$arrEtapa = db_select_array (false, $SIS_query, 'prospectos_transportistas_etapa_fidelizacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEtapa');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Prospecto</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<?php if($arrObservaciones!=false && !empty($arrObservaciones) && $arrObservaciones!=''){ ?>
					<li class=""><a href="#observaciones" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
				<?php } ?>
				<?php if($arrEtapa!=false && !empty($arrEtapa) && $arrEtapa!=''){ ?>
					<li class=""><a href="#etapas" data-toggle="tab"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Etapas</a></li>
				<?php } ?>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Prospecto</h2>
						<p class="text-muted">
							<strong>Nombre Prospecto: </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Telefono : </strong><?php echo formatPhone($rowData['Fono']); ?><br/>
							<strong>Email Prospecto: </strong><a href="mailto:<?php echo $rowData['email']; ?>"><?php echo $rowData['email']; ?></a><br/>
							<strong>Email Respuesta: </strong><a href="mailto:<?php echo $rowData['email_noti']; ?>"><?php echo $rowData['email_noti']; ?></a><br/>
							<strong>Fecha de Registro : </strong><?php echo Fecha_estandar($rowData['F_Ingreso']); ?><br/>
							<strong>Sistema Relacionado : </strong><?php echo $rowData['Sistema']; ?><br/>
							<strong>Estado Fidelizacion: </strong><?php echo $rowData['Fidelizacion']; ?><br/>
							<strong>Etapa Fidelizacion: </strong><?php echo $rowData['Etapa']; ?>
						</p>
					</div>

				</div>
			</div>

			<?php if($arrObservaciones!=false && !empty($arrObservaciones) && $arrObservaciones!=''){ ?>
				<div class="tab-pane fade" id="observaciones">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th>Autor</th>
										<th width="120">Fecha</th>
										<th>Observacion</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrObservaciones as $observaciones){ ?>
									<tr class="odd">
										<td><?php echo $observaciones['nombre_usuario']; ?></td>
										<td><?php echo $observaciones['Fecha']; ?></td>
										<td class="word_break"><?php echo $observaciones['Observacion']; ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if($arrEtapa!=false && !empty($arrEtapa) && $arrEtapa!=''){ ?>
				<div class="tab-pane fade" id="etapas">
					<div class="wmd-panel">
						<div class="table-responsive">
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th width="120">Fecha</th>
										<th>Autor</th>
										<th>Etapa</th>
										<th width="10">Acciones</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrEtapa as $etapa) { ?>
										<tr class="odd">
											<td><?php echo fecha_estandar($etapa['Fecha']); ?></td>
											<td><?php echo $etapa['nombre_usuario']; ?></td>
											<td><?php echo $etapa['Etapa']; ?></td>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="<?php echo 'view_prospecto_etapa.php?view='.simpleEncode($etapa['idEtapaFide'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>
			
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
