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
require_once 'core/Load.Utils.Print.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
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
$X_idQuiz = simpleDecode($_GET['idQuiz'], fecha_actual());
/**************************************************************/
$subquery = '';
for ($i = 1; $i <= 100; $i++) {
    $subquery .= ',quiz_realizadas.Pregunta_'.$i;
    $subquery .= ',quiz_realizadas.Respuesta_'.$i;
}
// Se traen todos los datos de la pregunta
$SIS_query = '
quiz_listado.Nombre,
quiz_listado.Header_texto,
quiz_listado.Header_fecha,
quiz_listado.Footer_texto,
quiz_listado.Texto_Inicio,
quiz_listado.Tiempo,
core_sistemas.Nombre AS sistema,
core_estados.Nombre AS Estado,
esc_1.Nombre AS Escala,
esc_2.Nombre AS Aprobado,
quiz_tipo_evaluacion.Nombre AS TipoEvaluacion,
quiz_tipo_quiz.Nombre AS TipoQuiz,
quiz_listado.idTipoEvaluacion,
quiz_listado.idTipoQuiz,
quiz_listado.idLimiteTiempo,
quiz_realizadas.Total_Preguntas'.$subquery;
$SIS_join  = '
LEFT JOIN `quiz_listado`            ON quiz_listado.idQuiz                       = quiz_realizadas.idQuiz
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema                   = quiz_listado.idSistema
LEFT JOIN `core_estados`            ON core_estados.idEstado                     = quiz_listado.idEstado
LEFT JOIN `quiz_escala`  esc_1      ON esc_1.idEscala                            = quiz_listado.idEscala
LEFT JOIN `quiz_escala`  esc_2      ON esc_2.idEscala                            = quiz_listado.Porcentaje_apro
LEFT JOIN `quiz_tipo_evaluacion`    ON quiz_tipo_evaluacion.idTipoEvaluacion     = quiz_listado.idTipoEvaluacion
LEFT JOIN `quiz_tipo_quiz`          ON quiz_tipo_quiz.idTipoQuiz                 = quiz_listado.idTipoQuiz';
$SIS_where = 'quiz_realizadas.idQuizRealizadas ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'quiz_realizadas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/************************************************/
// Se trae un listado con todas las preguntas
$SIS_query = '
quiz_listado_preguntas.idPregunta, 
quiz_listado_preguntas.Nombre AS Pregunta,
quiz_tipo.Nombre AS Tipo,
quiz_listado_preguntas.Opcion_1,
quiz_listado_preguntas.Opcion_2,
quiz_listado_preguntas.Opcion_3,
quiz_listado_preguntas.Opcion_4,
quiz_listado_preguntas.Opcion_5,
quiz_listado_preguntas.Opcion_6,
quiz_listado_preguntas.OpcionCorrecta,
quiz_listado_preguntas.idCategoria,
quiz_categorias.Nombre AS Categoria';
$SIS_join  = '
LEFT JOIN `quiz_tipo`        ON quiz_tipo.idTipo              = quiz_listado_preguntas.idTipo
LEFT JOIN `quiz_categorias`  ON quiz_categorias.idCategoria   = quiz_listado_preguntas.idCategoria';
$SIS_where = 'quiz_listado_preguntas.idQuiz ='.$X_idQuiz;
$SIS_order = 'quiz_listado_preguntas.idCategoria ASC';
$arrPreguntas = array();
$arrPreguntas = db_select_array (false, $SIS_query, 'quiz_listado_preguntas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPreguntas');

//cuento las preguntas
$count = 0;
foreach ($arrPreguntas as $preg) {
	$count++;
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Print.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/

?>

<?php if(isset($count)&&$count==0){ ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
		<?php
		$Alert_Text  = 'No tiene preguntas asignadas a la Quiz';
		alert_post_data(4,1,1,0, $Alert_Text);
		?>
	</div>

<?php } ?>

<div class="clearfix"></div>


	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Datos Básicos</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr>
							<td class="meta-head">Nombre</td>
							<td colspan="3"><?php echo $rowData['Nombre']?></td>
						</tr>
						<tr>
							<td class="meta-head">Texto Cabecera</td>
							<td colspan="3"><?php echo $rowData['Header_texto']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha Cabecera</td>
							<td colspan="3"><?php echo fecha_estandar($rowData['Header_fecha']); ?></td>
						</tr>
						<tr>
							<td class="meta-head">Texto Contenido</td>
							<td colspan="3"><?php echo $rowData['Texto_Inicio']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Texto Pie Pagina</td>
							<td colspan="3"><?php echo $rowData['Footer_texto']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Sistema</td>
							<td><?php echo $rowData['sistema']; ?></td>
							<td class="meta-head">Estado</td>
							<td><?php echo $rowData['Estado']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Tipo Puntuacion</td>
							<?php
							//Escala
							if(isset($rowData['idTipoEvaluacion'])&&$rowData['idTipoEvaluacion']==1){
								echo '<td colspan="3">'.$rowData['TipoEvaluacion'].' : '.$rowData['Escala'].'</td>';
							//Porcentaje	
							}else{
								echo '<td colspan="3">'.$rowData['TipoEvaluacion'].' : '.$rowData['Aprobado'].'</td>';
							}
							?>
						</tr>
						<tr>
							<td class="meta-head">Tipo Evaluacion</td>
							<?php
							//Cerrada
							if(isset($rowData['idTipoQuiz'])&&$rowData['idTipoQuiz']==1){
								echo '<td colspan="3">'.$rowData['TipoQuiz'].'</td>';
							//Abierta 	
							}else{
								echo '<td colspan="3">'.$rowData['TipoQuiz'].'</td>';
							}
							?>
						</tr>
						<tr>
							<td class="meta-head">Limite de Tiempo</td>
							<?php
							//Si
							if(isset($rowData['idLimiteTiempo'])&&$rowData['idLimiteTiempo']==1){
								echo '<td colspan="3">Limitado a '.$rowData['Tiempo'].' hrs.</td>';
							//no
							}else{
								echo '<td colspan="3">Sin Limite de Tiempo</td>';
							}
							?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Preguntas</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">

						<?php
						//Recorro el total de preguntas
						for ($i = 1; $i <= $rowData['Total_Preguntas']; $i++) {
							/*filtrar($arrPreguntas, 'Categoria');
						foreach($arrPreguntas as $categoria=>$permisos){
							echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
							foreach ($permisos as $preg) { */
							
							foreach ($arrPreguntas as $preg) {
								if($preg['idPregunta']==$rowData['Pregunta_'.$i]){ ?>
					
								<tr class="item-row linea_punteada">
									<td class="item-name">
										<strong><?php echo $preg['Tipo']; ?> : </strong><?php echo $preg['Pregunta']; ?><br/>
										<?php
										$resp_correct = 1;
										if(isset($preg['Opcion_1'])&&$preg['Opcion_1']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowData['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_1'].$r_fin.$tex.'<br/>';$resp_correct++;}
										if(isset($preg['Opcion_2'])&&$preg['Opcion_2']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowData['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_2'].$r_fin.$tex.'<br/>';$resp_correct++;}
										if(isset($preg['Opcion_3'])&&$preg['Opcion_3']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowData['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_3'].$r_fin.$tex.'<br/>';$resp_correct++;}
										if(isset($preg['Opcion_4'])&&$preg['Opcion_4']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowData['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_4'].$r_fin.$tex.'<br/>';$resp_correct++;}
										if(isset($preg['Opcion_5'])&&$preg['Opcion_5']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowData['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_5'].$r_fin.$tex.'<br/>';$resp_correct++;}
										if(isset($preg['Opcion_6'])&&$preg['Opcion_6']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowData['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_6'].$r_fin.$tex.'<br/>';$resp_correct++;}
										?>
						
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

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
