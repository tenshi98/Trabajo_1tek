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
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "informe_evaluaciones_02.php";
$location = $original;
//Se agregan ubicaciones
$location .='?submit_filter=Filtrar';			
       
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
             
  
//Solo las que correspondan		
$z     = "WHERE quiz_realizadas.idQuizRealizadas!=0";
//Tipo de usuario
$z.= " AND quiz_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
if(isset($_GET['idAlumno'])&&$_GET['idAlumno']!=''){           $z.=" AND alumnos_listado.idAlumno=".$_GET['idAlumno'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){           $z.=" AND quiz_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['idQuiz'])&&$_GET['idQuiz']!=''){               $z.=" AND quiz_realizadas.idQuiz=".$_GET['idQuiz'];}
if(isset($_GET['idTipoEvaluacion'])&&$_GET['idTipoEvaluacion']!=''){  $z.=" AND quiz_listado.idTipoEvaluacion=".$_GET['idTipoEvaluacion'];}
if(isset($_GET['idTipoQuiz'])&&$_GET['idTipoQuiz']!=''){       $z.=" AND quiz_listado.idTipoQuiz=".$_GET['idTipoQuiz'];}
if(isset($_GET['idLimiteTiempo'])&&$_GET['idLimiteTiempo']!=''){      $z.=" AND quiz_listado.idLimiteTiempo=".$_GET['idLimiteTiempo'];}
			
/*************************************************************************************************/
//Evaluaciones
$arrTemporal = array();
$query = "SELECT 
quiz_listado.Nombre AS NombreEvaluacion,
quiz_realizadas.idQuizRealizadas,
quiz_realizadas.idQuiz,
quiz_realizadas.Programada_fecha,
quiz_realizadas.Total_Preguntas,
quiz_realizadas.Duracion_Max,
(SELECT COUNT(idEstadoAprobacion) FROM `quiz_realizadas` 
LEFT JOIN `quiz_listado`       ON quiz_listado.idQuiz        = quiz_realizadas.idQuiz
LEFT JOIN `alumnos_listado`    ON alumnos_listado.idAlumno   = quiz_realizadas.idAlumno
".$z." AND idEstadoAprobacion=1) AS NoAprobado,

(SELECT COUNT(idEstadoAprobacion) FROM `quiz_realizadas` 
LEFT JOIN `quiz_listado`       ON quiz_listado.idQuiz        = quiz_realizadas.idQuiz
LEFT JOIN `alumnos_listado`    ON alumnos_listado.idAlumno   = quiz_realizadas.idAlumno
".$z." AND idEstadoAprobacion=2) AS Aprobado,

(SELECT COUNT(idEstadoAprobacion) FROM `quiz_realizadas` 
LEFT JOIN `quiz_listado`       ON quiz_listado.idQuiz        = quiz_realizadas.idQuiz
LEFT JOIN `alumnos_listado`    ON alumnos_listado.idAlumno   = quiz_realizadas.idAlumno
".$z." AND idEstadoAprobacion=3) AS Reintentado,

AVG(NULLIF(IF(quiz_realizadas.Respondido!=0,quiz_realizadas.Respondido,0),0))   AS PromRespondido,
AVG(NULLIF(IF(quiz_realizadas.Correctas!=0,quiz_realizadas.Correctas,0),0))     AS PromCorrectas,
AVG(NULLIF(IF(quiz_realizadas.Rendimiento!=0,quiz_realizadas.Rendimiento,0),0)) AS PromRendimiento

FROM `quiz_realizadas`
LEFT JOIN `quiz_listado`       ON quiz_listado.idQuiz        = quiz_realizadas.idQuiz
LEFT JOIN `alumnos_listado`    ON alumnos_listado.idAlumno   = quiz_realizadas.idAlumno
".$z."
GROUP BY alumnos_listado.idCurso, quiz_realizadas.idQuiz
ORDER BY alumnos_listado.idCurso ASC, quiz_realizadas.idQuiz ASC 

";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal,$row );
}

/*************************************************************************************************/
//Evaluaciones
$arrAlumnos = array();
$query = "SELECT 
quiz_listado.Nombre AS NombreEvaluacion,
quiz_realizadas.idQuizRealizadas,
quiz_realizadas.idQuiz,
quiz_realizadas.Programada_fecha,
quiz_realizadas.Total_Preguntas,
quiz_realizadas.Duracion_Max,
core_estado_aprobacion_evaluacion.Nombre AS Evaluacion,
quiz_realizadas.Respondido AS PromRespondido,
quiz_realizadas.Correctas AS PromCorrectas,
quiz_realizadas.Rendimiento AS PromRendimiento,
alumnos_listado.Nombre AS AlumnoNombre,
alumnos_listado.ApellidoPat AS AlumnoApellidoPat

FROM `quiz_realizadas`
LEFT JOIN `quiz_listado`                         ON quiz_listado.idQuiz                                    = quiz_realizadas.idQuiz
LEFT JOIN `alumnos_listado`                      ON alumnos_listado.idAlumno                               = quiz_realizadas.idAlumno
LEFT JOIN `core_estado_aprobacion_evaluacion`    ON core_estado_aprobacion_evaluacion.idEstadoAprobacion   = quiz_realizadas.idEstadoAprobacion
".$z." 
ORDER BY alumnos_listado.idCurso ASC, quiz_realizadas.idQuiz ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrAlumnos,$row );
}
/******************************************/
//calculos
$NoAprobado   = 0;
$Aprobado     = 0;
$Reintentado  = 0;

foreach ($arrTemporal as $temp) {
	$NoAprobado   = $NoAprobado  + $temp['NoAprobado'];
	$Aprobado     = $Aprobado  + $temp['Aprobado'];
	$Reintentado  = $Reintentado  + $temp['Reintentado'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#totales" data-toggle="tab"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Información Alumno</a></li>          
				<li class=""><a href="#netos" data-toggle="tab"><i class="fa fa-line-chart" aria-hidden="true"></i> Graficos Generales</a></li>
			</ul>
		</header>
        <div class="tab-content">
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">google.charts.load('current', {'packages':['corechart']});</script>

			
			<div class="tab-pane fade active in" id="totales" style="padding-top:5px;">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Evaluacion</th>
							<th>Alumno</th>
							<th>Fecha</th>
							<th>Total Preguntas</th>
							<th>Duracion</th>
							<th>Promedio <br/>Respondido</th>
							<th>Promedio <br/>Correctas</th>
							<th>Promedio <br/>Rendimiento</th>
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrAlumnos as $eva) { ?>
							<tr class="odd">
								<td><?php echo $eva['NombreEvaluacion']; ?></td>
								<td><?php echo $eva['AlumnoNombre'].' '.$eva['AlumnoApellidoPat']; ?></td>
								<td><?php echo fecha_estandar($eva['Programada_fecha']); ?></td>
								<td><?php echo $eva['Total_Preguntas']; ?></td>
								<td><?php echo $eva['Duracion_Max']; ?></td>
								<td><?php echo Cantidades($eva['PromRespondido'], 1); ?></td>
								<td><?php echo Cantidades($eva['PromCorrectas'], 1); ?></td>
								<td><?php echo Cantidades($eva['PromRendimiento'], 2).'%'; ?></td>
								<td><?php echo $eva['Evaluacion']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_quiz_respondida.php?view='.simpleEncode($eva['idQuizRealizadas'], fecha_actual()).'&idQuiz='.simpleEncode($eva['idQuiz'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="tab-pane fade" id="netos" style="padding-top:5px;">

				<script>
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {

						var data = google.visualization.arrayToDataTable([
						  ['Task', 'Hours per Day'],
						  ['No Aprobado', <?php echo $NoAprobado; ?>],
						  ['Aprobado',<?php echo $Aprobado; ?>],
						  ['Reintentado',<?php echo $Reintentado; ?>]
						]);

						var options = {
							title: 'Estado Aprobacion',
							slices: {
								0: { color: 'yellow' },
								1: { color: 'green' },
								2: { color: 'red' }
							}
						};

						var chart = new google.visualization.PieChart(document.getElementById('piechart'));

						chart.draw(data, options);
					  }


				</script>
				<div id="piechart" style="height: 500px; width: 100%;"></div>		
				
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Evaluacion</th>
								<th>Fecha</th>
								<th>Total Preguntas</th>
								<th>Duracion</th>
								<th>Promedio <br/>Respondido</th>
								<th>Promedio <br/>Correctas</th>
								<th>Promedio <br/>Rendimiento</th>
								<th>No Aprobado</th>
								<th>Aprobado</th>
								<th>Reintentado</th>
								<th width="10">Acciones</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrTemporal as $eva) { ?>
							<tr class="odd">
								<td><?php echo $eva['NombreEvaluacion']; ?></td>
								<td><?php echo fecha_estandar($eva['Programada_fecha']); ?></td>
								<td><?php echo $eva['Total_Preguntas']; ?></td>
								<td><?php echo $eva['Duracion_Max']; ?></td>
								<td><?php echo Cantidades($eva['PromRespondido'], 1); ?></td>
								<td><?php echo Cantidades($eva['PromCorrectas'], 1); ?></td>
								<td><?php echo Cantidades($eva['PromRendimiento'], 2).'%'; ?></td>
								<td><?php echo $eva['NoAprobado']; ?></td>
								<td><?php echo $eva['Aprobado']; ?></td>
								<td><?php echo $eva['Reintentado']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_quiz_respondida.php?view='.simpleEncode($eva['idQuizRealizadas'], fecha_actual()).'&idQuiz='.simpleEncode($eva['idQuiz'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									</div>
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

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
	


<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idAlumno)){         $x1  = $idAlumno;          }else{$x1  = '';}
				if(isset($idEstado)){         $x2  = $idEstado;          }else{$x2  = '';}
				if(isset($idQuiz)){           $x3  = $idQuiz;            }else{$x3  = '';}
				if(isset($idTipoEvaluacion)){ $x4  = $idTipoEvaluacion;  }else{$x4  = '';}
				if(isset($idTipoQuiz)){       $x5  = $idTipoQuiz;        }else{$x5  = '';}
				if(isset($idLimiteTiempo)){   $x6  = $idLimiteTiempo;    }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Alumno','idAlumno', $x1, 2, 'idAlumno', 'Nombre,ApellidoPat', 'alumnos_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_depend1('Estado','idEstado', $x2, 1, 'idEstado', 'Nombre', 'core_estados', 0, 0,
										'Evaluacion','idQuiz', $x3, 1, 'idQuiz', 'Nombre', 'quiz_listado', $z, 0, 
										$dbConn, 'form1');
				$Form_Inputs->form_select('Tipo Puntuacion','idTipoEvaluacion', $x4, 1, 'idTipoEvaluacion', 'Nombre', 'quiz_tipo_evaluacion', 0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Evaluacion','idTipoQuiz', $x5, 1, 'idTipoQuiz', 'Nombre', 'quiz_tipo_quiz', 0, '', $dbConn);
				$Form_Inputs->form_select('Tiempo Limite','idLimiteTiempo', $x6, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
								
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
