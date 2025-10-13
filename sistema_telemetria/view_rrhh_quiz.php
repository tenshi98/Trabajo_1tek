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
// Se traen todos los datos de la pregunta
$SIS_query = '
rrhh_quiz_listado.Nombre,
rrhh_quiz_listado.Header_texto,
rrhh_quiz_listado.Header_fecha,
rrhh_quiz_listado.Footer_texto,
rrhh_quiz_listado.Texto_Inicio,
core_sistemas.Nombre AS sistema,
core_estados.Nombre AS Estado,
esc_1.Nombre AS Escala,
esc_2.Nombre AS Aprobado,
rrhh_quiz_tipo_evaluacion.Nombre AS TipoEvaluacion,
rrhh_quiz_tipo_quiz.Nombre AS TipoQuiz,
rrhh_quiz_listado.idTipoEvaluacion,
rrhh_quiz_listado.idTipoQuiz';
$SIS_join  = '
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                        = rrhh_quiz_listado.idSistema
LEFT JOIN `core_estados`                 ON core_estados.idEstado                          = rrhh_quiz_listado.idEstado
LEFT JOIN `rrhh_quiz_escala`  esc_1      ON esc_1.idEscala                                 = rrhh_quiz_listado.idEscala
LEFT JOIN `rrhh_quiz_escala`  esc_2      ON esc_2.idEscala                                 = rrhh_quiz_listado.Porcentaje_apro
LEFT JOIN `rrhh_quiz_tipo_evaluacion`    ON rrhh_quiz_tipo_evaluacion.idTipoEvaluacion     = rrhh_quiz_listado.idTipoEvaluacion
LEFT JOIN `rrhh_quiz_tipo_quiz`          ON rrhh_quiz_tipo_quiz.idTipoQuiz                 = rrhh_quiz_listado.idTipoQuiz';
$SIS_where = 'rrhh_quiz_listado.idQuiz ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'rrhh_quiz_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**************************************************/
// Se trae un listado con todas las preguntas
$SIS_query = '
rrhh_quiz_listado_preguntas.idPregunta, 
rrhh_quiz_listado_preguntas.Nombre AS Pregunta,
rrhh_quiz_tipo.Nombre AS Tipo,
rrhh_quiz_listado_preguntas.Opcion_1,
rrhh_quiz_listado_preguntas.Opcion_2,
rrhh_quiz_listado_preguntas.Opcion_3,
rrhh_quiz_listado_preguntas.Opcion_4,
rrhh_quiz_listado_preguntas.Opcion_5,
rrhh_quiz_listado_preguntas.Opcion_6,
rrhh_quiz_listado_preguntas.OpcionCorrecta,
rrhh_quiz_listado_preguntas.idCategoria,
rrhh_quiz_categorias.Nombre AS Categoria';
$SIS_join  = '
LEFT JOIN `rrhh_quiz_tipo`        ON rrhh_quiz_tipo.idTipo              = rrhh_quiz_listado_preguntas.idTipo
LEFT JOIN `rrhh_quiz_categorias`  ON rrhh_quiz_categorias.idCategoria   = rrhh_quiz_listado_preguntas.idCategoria';
$SIS_where = 'rrhh_quiz_listado_preguntas.idQuiz ='.$X_Puntero;
$SIS_order = 'rrhh_quiz_listado_preguntas.idCategoria ASC';
$arrPreguntas = array();
$arrPreguntas = db_select_array (false, $SIS_query, 'rrhh_quiz_listado_preguntas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPreguntas');

//cuento las preguntas
$count = 0;
foreach ($arrPreguntas as $preg) {
	$count++;
} 

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
			<div>
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
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Preguntas</h5>
			</header>
			<div>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<tbody role="alert" aria-live="polite" aria-relevant="all">

							<?php 
							filtrar($arrPreguntas, 'Categoria');  
							foreach($arrPreguntas as $categoria=>$permisos){
								echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
								foreach ($permisos as $preg) { ?>
						
									<tr class="item-row linea_punteada">
										<td class="item-name">
											<strong><?php echo $preg['Tipo']; ?> : </strong><?php echo $preg['Pregunta']; ?><br/>
											<?php
											$resp_correct = 1;
											if(isset($preg['Opcion_1'])&&$preg['Opcion_1']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_1'].$tex.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_2'])&&$preg['Opcion_2']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_2'].$tex.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_3'])&&$preg['Opcion_3']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_3'].$tex.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_4'])&&$preg['Opcion_4']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_4'].$tex.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_5'])&&$preg['Opcion_5']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_5'].$tex.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_6'])&&$preg['Opcion_6']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_6'].$tex.'<br/>';$resp_correct++;}
											?>
							
										</td>
									</tr>
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
