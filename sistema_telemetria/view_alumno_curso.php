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
alumnos_cursos.Nombre AS CursoNombre,
alumnos_cursos.Semanas AS CursoSemanas,
alumnos_cursos.F_inicio AS CursoF_inicio,
alumnos_cursos.F_termino AS CursoF_termino,
core_estados.Nombre AS CursoEstado,
core_sistemas.Nombre AS CursoSistema';
$SIS_join  = '
LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema  = alumnos_cursos.idSistema
LEFT JOIN `core_estados`   ON core_estados.idEstado    = alumnos_cursos.idEstado';
$SIS_where = 'alumnos_cursos.idCurso ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'alumnos_cursos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************************************/
// consulto los datos
$SIS_query = 'alumnos_elearning_listado.Nombre AS NombreElearning';
$SIS_join  = 'LEFT JOIN `alumnos_elearning_listado` ON alumnos_elearning_listado.idElearning = alumnos_cursos_elearning.idElearning';
$SIS_where = 'alumnos_cursos_elearning.idCurso ='.$X_Puntero;
$SIS_order = 'alumnos_elearning_listado.Nombre ASC';
$arrElearnng = array();
$arrElearnng = db_select_array (false, $SIS_query, 'alumnos_cursos_elearning', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrElearnng');

/**********************************************************/
// consulto los datos
$SIS_query = 'idDocumentacion, File, Semana';
$SIS_join  = '';
$SIS_where = 'idCurso ='.$X_Puntero;
$SIS_order = 'Semana ASC';
$arrArchivos = array();
$arrArchivos = db_select_array (false, $SIS_query, 'alumnos_cursos_documentacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivos');


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Grupo</h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">
					<div class="table-responsive">

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/training.jpg">
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary">Datos Básicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['CursoNombre']; ?><br/>
							<strong>Semanas : </strong><?php echo $rowData['CursoSemanas'].' semanas de duracion'; ?><br/>
							<strong>Fecha de Inicio : </strong><?php echo Fecha_completa($rowData['CursoF_inicio']); ?><br/>
							<strong>Fecha de Termino : </strong><?php echo Fecha_completa($rowData['CursoF_termino']); ?><br/>
							<strong>Sistema Relacionado : </strong><?php echo $rowData['CursoSistema']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['CursoEstado']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Elearnings  Relacionados</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php foreach ($arrElearnng as $permiso){ ?>
									<tr><td><?php echo $permiso['NombreElearning']; ?></td></tr>
								<?php } ?>
							</tbody>
						</table>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos Relacionados</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php foreach ($arrArchivos as $ciudad) { ?>
									<tr class="odd">
										<?php /*<td><?php echo 'Semana '.$ciudad['Semana']; ?></td>*/ ?>
										<td><?php echo $ciudad['File']; ?></td>
										<td>
											<div class="btn-group" style="width: 70px;" >
												<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($ciudad['File'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						
				
					</div>
					<div class="clearfix"></div>

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
