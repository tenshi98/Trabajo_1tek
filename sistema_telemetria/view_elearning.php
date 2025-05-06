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
alumnos_elearning_listado.Nombre,
alumnos_elearning_listado.Resumen, 
alumnos_elearning_listado.Imagen,
alumnos_elearning_listado.LastUpdate,
alumnos_elearning_listado.Objetivos,
alumnos_elearning_listado.Requisitos,
alumnos_elearning_listado.Descripcion,
core_estados.Nombre AS Estado';
$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = alumnos_elearning_listado.idEstado';
$SIS_where = 'alumnos_elearning_listado.idElearning ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'alumnos_elearning_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
alumnos_elearning_listado_unidades.idUnidad AS Unidad_ID, 
alumnos_elearning_listado_unidades.N_Unidad AS Unidad_Numero, 
alumnos_elearning_listado_unidades.Nombre AS Unidad_Nombre,
alumnos_elearning_listado_unidades.Duracion AS Unidad_Duracion,
alumnos_elearning_listado_unidades_contenido.idContenido AS Contenido_ID,
alumnos_elearning_listado_unidades_contenido.Nombre AS Contenido_Nombre';
$SIS_join  = 'LEFT JOIN `alumnos_elearning_listado_unidades_contenido` ON alumnos_elearning_listado_unidades_contenido.idUnidad = alumnos_elearning_listado_unidades.idUnidad';
$SIS_where = 'alumnos_elearning_listado_unidades.idElearning ='.$X_Puntero;
$SIS_order = 'alumnos_elearning_listado_unidades.N_Unidad ASC, alumnos_elearning_listado_unidades_contenido.Nombre ASC';
$arrContenidos = array();
$arrContenidos = db_select_array (false, $SIS_query, 'alumnos_elearning_listado_unidades', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrContenidos');

/*****************************************************/
// Se trae un listado con todos los elementos
$SIS_query = 'idDocumentacion, idUnidad, idElearning, idContenido, File';
$SIS_join  = '';
$SIS_where = 'idElearning ='.$X_Puntero;
$SIS_order = 'File ASC';
$arrFiles = array();
$arrFiles = db_select_array (false, $SIS_query, 'alumnos_elearning_listado_unidades_documentacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFiles');

/*****************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
alumnos_elearning_listado_unidades_cuestionarios.idCuestionario, 
alumnos_elearning_listado_unidades_cuestionarios.idUnidad, 
alumnos_elearning_listado_unidades_cuestionarios.idElearning, 
alumnos_elearning_listado_unidades_cuestionarios.idContenido, 
alumnos_elearning_listado_unidades_cuestionarios.idQuiz,
quiz_listado.Nombre AS Cuestionario';
$SIS_join  = 'LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = alumnos_elearning_listado_unidades_cuestionarios.idQuiz';
$SIS_where = 'alumnos_elearning_listado_unidades_cuestionarios.idElearning ='.$X_Puntero;
$SIS_order = 'quiz_listado.Nombre ASC';
$arrCuestionarios = array();
$arrCuestionarios = db_select_array (false, $SIS_query, 'alumnos_elearning_listado_unidades_cuestionarios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCuestionarios');

/*****************************************************/
//calculo de los dias de duracion
$Dias_Duracion = 0;
filtrar($arrContenidos, 'Unidad_Numero');
foreach($arrContenidos as $categoria=>$permisos){
	$Dias_Duracion = $Dias_Duracion + $permisos[0]['Unidad_Duracion'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Datos Básicos</h5>
		</header>
		<div class="">
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr>
							<td class="meta-head">Nombre Elearning</td>
							<td><?php echo $rowData['Nombre']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Estado</td>
							<td><?php echo $rowData['Estado']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Dias de Duracion</td>
							<td><?php echo $Dias_Duracion.' dias'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Resumen</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowData['Resumen']; ?></span></td>
						</tr>
						<tr>
							<td class="meta-head">Ultima Actualizacion</td>
							<td><?php echo fecha_estandar($rowData['LastUpdate']); ?></td>
						</tr>
						<tr>
							<td class="meta-head">Objetivos</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowData['Objetivos']; ?></span></td>
						</tr>
						<tr>
							<td class="meta-head">Requisitos</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowData['Requisitos']; ?></span></td>
						</tr>
						<tr>
							<td class="meta-head">Descripcion</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowData['Descripcion']; ?></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Contenido</h5>
		</header>
		<div class="">
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">

						<?php foreach($arrContenidos as $categoria=>$permisos){ ?>
							<tr class="odd" >
								<td style="background-color:#DDD"><strong>Unidad <?php echo $categoria; ?></strong> - <?php echo $permisos[0]['Unidad_Nombre'].' ('.$permisos[0]['Unidad_Duracion'].' dias de duracion)'; ?></td>
							</tr>
							<?php foreach ($permisos as $preg) {
								if(isset($preg['Contenido_Nombre'])&&$preg['Contenido_Nombre']!=''){ ?>
									<tr class="item-row linea_punteada">
										<td class="item-name">
											<span style="word-wrap: break-word;white-space: initial;"><?php echo $preg['Contenido_Nombre']; ?></span>	
												
											<?php if($arrFiles!=false && !empty($arrFiles) && $arrFiles!=''){
												//verifico que existan archivos en esta unidad
												$x_n_arch = 0;
												foreach ($arrFiles as $file) {
													if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){
														$x_n_arch++;
													}
												}
												//si hay archivos se imprime
												if($x_n_arch!=0){  ?>
													<div class="clearfix"></div>
													<hr>
													<strong>Archivos adjuntos del contenido <?php echo $preg['Contenido_Nombre']; ?>:</strong><br/>
													<?php foreach ($arrFiles as $file) {
														//verifico que el archivo sea del contenido
														if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){ ?>
															<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:2px;">
																<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
																	<?php
																	$f_file = str_replace('elearning_files_'.$file['idContenido'].'_','',$file['File']);
																	echo $f_file;
																	?>
																</div>
																<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
																	<div class="btn-group" style="width: 35px;" >
																		<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($file['File'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
																	</div>
																</div>
															</div>
														<?php } ?>
													<?php } ?>
												<?php } ?>
											<?php } ?>
												
											<?php if($arrCuestionarios!=false && !empty($arrCuestionarios) && $arrCuestionarios!=''){
												//verifico que existan archivos en esta unidad
												$x_n_Cuest = 0;
												foreach ($arrCuestionarios as $file) {
													if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){
														$x_n_Cuest++;
													}
												}
												//si hay archivos se imprime
												if($x_n_Cuest!=0){  ?>
													<div class="clearfix"></div>
													<hr>
													<strong>Cuestionarios adjuntos del contenido <?php echo $preg['Contenido_Nombre']; ?>:</strong><br/>
													<?php foreach ($arrCuestionarios as $file) {
														//verifico que el archivo sea del contenido
														if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){ ?>
															<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:2px;">
																<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11"><?php echo $file['Cuestionario'];  ?></div>
																<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
																	<div class="btn-group" style="width: 35px;" >
																		<a href="<?php echo 'view_quiz.php?view='.simpleEncode($file['idQuiz'], fecha_actual()); ?>&return=<?php echo basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																	</div>
																</div>
															</div>
														<?php } ?>
													<?php } ?>
												<?php } ?>
											<?php } ?>
											
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
											  
					</tbody>
				</table>
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
