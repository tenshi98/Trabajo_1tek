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
alumnos_evaluaciones_asignadas.idAsignadas,
alumnos_evaluaciones_asignadas.Programada_fecha,
alumnos_evaluaciones_asignadas.N_preguntas,
alumnos_evaluaciones_asignadas.N_Alumnos,
alumnos_evaluaciones_asignadas.N_Alumnos_Falla,
alumnos_evaluaciones_asignadas.N_Alumnos_Rep,
alumnos_evaluaciones_asignar.Nombre AS Asignar,
cursos_listado.Nombre AS Curso,
quiz_listado.Nombre AS Quiz,
core_sistemas.Nombre AS Sistema';
$SIS_join  = '
LEFT JOIN `alumnos_evaluaciones_asignar`   ON alumnos_evaluaciones_asignar.idAsignar   = alumnos_evaluaciones_asignadas.idAsignar
LEFT JOIN `cursos_listado`                 ON cursos_listado.idCurso                   = alumnos_evaluaciones_asignadas.idCurso
LEFT JOIN `quiz_listado`                   ON quiz_listado.idQuiz                      = alumnos_evaluaciones_asignadas.idQuiz
LEFT JOIN `core_sistemas`                  ON core_sistemas.idSistema                  = alumnos_evaluaciones_asignadas.idSistema';
$SIS_where = 'alumnos_evaluaciones_asignadas.idAsignadas='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'alumnos_evaluaciones_asignadas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************************************/
// consulto los datos
$SIS_query = '
alumnos_listado.Nombre AS AlumnoNombre,
alumnos_listado.ApellidoPat AS AlumnoApellidoPat,
alumnos_listado.ApellidoMat AS AlumnoApellidoMat,
alumnos_evaluaciones_asignadas_alumnos.idTipo,
alumnos_evaluaciones_asignadas_alumnos.Programada_fecha';
$SIS_join  = 'LEFT JOIN `alumnos_listado`   ON alumnos_listado.idAlumno     = alumnos_evaluaciones_asignadas_alumnos.idAlumno';
$SIS_where = 'alumnos_evaluaciones_asignadas_alumnos.idAsignadas ='.$X_Puntero;
$SIS_order = 'alumnos_listado.ApellidoPat AS AlumnoApellidoPat ASC, alumnos_listado.ApellidoMat AS AlumnoApellidoMat ASC, alumnos_listado.Nombre AS AlumnoNombre ASC';
$arrAlumnos = array();
$arrAlumnos = db_select_array (false, $SIS_query, 'alumnos_evaluaciones_asignadas_alumnos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrAlumnos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos de la evaluacion</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="#alumnos" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> Alumnos</a></li>
				<li class=""><a href="#fallas" data-toggle="tab"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Fallas</a></li>
				<li class=""><a href="#reintentos" data-toggle="tab"><i class="fa fa-reply-all" aria-hidden="true"></i> Reintentos</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/evaluation.jpg">
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Tipo Asignacion : </strong><?php echo $rowData['Asignar']; ?><br/>
							<strong>Grupo: </strong><?php echo $rowData['Curso']; ?><br/>
							<strong>Evaluacion : </strong><?php echo $rowData['Quiz']; ?><br/>
							<strong>Fecha Programada : </strong><?php echo fecha_estandar($rowData['Programada_fecha']); ?><br/>
							<strong>N° Preguntas : </strong><?php echo $rowData['N_preguntas']; ?><br/>
							<strong>N° Alumnos : </strong><?php echo $rowData['N_Alumnos']; ?><br/>
							<strong>N° Fallas : </strong><?php echo $rowData['N_Alumnos_Falla']; ?><br/>
							<strong>N° Reintentos : </strong><?php echo $rowData['N_Alumnos_Rep']; ?><br/>
						</p>

					</div>
					<div class="clearfix"></div>

				</div>
			</div>
			
	
			<div class="tab-pane fade" id="alumnos">
				<div class="wmd-panel">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<th width="120">Fecha</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrAlumnos as $alum) {
									if(isset($alum['idTipo'])&&$alum['idTipo']==1){ ?>
										<tr class="odd">
											<td><?php echo $alum['AlumnoNombre'].' '.$alum['AlumnoApellidoPat'].' '.$alum['AlumnoApellidoMat']; ?></td>
											<td><?php echo $alum['Programada_fecha']; ?></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="fallas">
				<div class="wmd-panel">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<th width="120">Fecha</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrAlumnos as $alum) {
									if(isset($alum['idTipo'])&&$alum['idTipo']==3){ ?>
										<tr class="odd">
											<td><?php echo $alum['AlumnoNombre'].' '.$alum['AlumnoApellidoPat'].' '.$alum['AlumnoApellidoMat']; ?></td>
											<td><?php echo $alum['Programada_fecha']; ?></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="reintentos">
				<div class="wmd-panel">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<th width="120">Fecha</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrAlumnos as $alum) {
									if(isset($alum['idTipo'])&&$alum['idTipo']==2){ ?>
										<tr class="odd">
											<td><?php echo $alum['AlumnoNombre'].' '.$alum['AlumnoApellidoPat'].' '.$alum['AlumnoApellidoMat']; ?></td>
											<td><?php echo $alum['Programada_fecha']; ?></td>
										</tr>
									<?php } ?>
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
