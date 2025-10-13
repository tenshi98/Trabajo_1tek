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
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}

/**********************************************************/
// Se traen todos los datos de la pregunta
$query = "SELECT
rrhh_quiz_listado.Nombre,

core_sistemas.Nombre AS sistema,
core_estados.Nombre AS Estado,
esc_1.Nombre AS Escala,
esc_2.Nombre AS Aprobado,
rrhh_quiz_tipo_evaluacion.Nombre AS TipoEvaluacion,
rrhh_quiz_tipo_quiz.Nombre AS TipoQuiz,
rrhh_quiz_listado.idTipoEvaluacion,
rrhh_quiz_listado.idTipoQuiz,

FROM `rrhh_quiz_listado`
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                        = rrhh_quiz_listado.idSistema
LEFT JOIN `core_estados`                 ON core_estados.idEstado                          = rrhh_quiz_listado.idEstado
LEFT JOIN `rrhh_quiz_escala`  esc_1      ON esc_1.idEscala                                 = rrhh_quiz_listado.idEscala
LEFT JOIN `rrhh_quiz_escala`  esc_2      ON esc_2.idEscala                                 = rrhh_quiz_listado.Porcentaje_apro
LEFT JOIN `rrhh_quiz_tipo_evaluacion`    ON rrhh_quiz_tipo_evaluacion.idTipoEvaluacion     = rrhh_quiz_listado.idTipoEvaluacion
LEFT JOIN `rrhh_quiz_tipo_quiz`          ON rrhh_quiz_tipo_quiz.idTipoQuiz                 = rrhh_quiz_listado.idTipoQuiz

WHERE rrhh_quiz_listado.idQuiz = ".$_GET['id_quiz'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
$rowData = mysqli_fetch_assoc ($resultado);	 

// Se trae un listado con todas las preguntas
$arrPreguntas = array();
$query = "SELECT
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
rrhh_quiz_categorias.Nombre AS Categoria

FROM `rrhh_quiz_listado_preguntas`
LEFT JOIN `rrhh_quiz_tipo`        ON rrhh_quiz_tipo.idTipo              = rrhh_quiz_listado_preguntas.idTipo
LEFT JOIN `rrhh_quiz_categorias`  ON rrhh_quiz_categorias.idCategoria   = rrhh_quiz_listado_preguntas.idCategoria
WHERE rrhh_quiz_listado_preguntas.idQuiz = ".$_GET['id_quiz']."
ORDER BY rrhh_quiz_listado_preguntas.idCategoria ASC
";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPreguntas,$row );
}

/**********************************************************/
//Tipo Puntuacion
$TipoPuntuacion = '';
//Escala
if(isset($rowData['idTipoEvaluacion'])&&$rowData['idTipoEvaluacion']==1){
	$TipoPuntuacion = $rowData['TipoEvaluacion'].' : '.$rowData['Escala'];
//Porcentaje	
}else{
	$TipoPuntuacion = $rowData['TipoEvaluacion'].' : '.$rowData['Aprobado'];
}
//Tipo Evaluacion
$TipoEvaluacion = '';
//Cerrada
if(isset($rowData['idTipoQuiz'])&&$rowData['idTipoQuiz']==1){
	$TipoEvaluacion = $rowData['TipoQuiz'];
//Abierta 	
}else{
	$TipoEvaluacion = $rowData['TipoQuiz'];
}

					
/**********************************************************/
//Contenido de la evaluacion
$Contenido = '';
filtrar($arrPreguntas, 'Categoria');
foreach($arrPreguntas as $categoria=>$permisos){
	$Contenido .= $categoria.'
	';
	foreach ($permisos as $preg) { 
		
		$Contenido .= $preg['Tipo'].' : '.$preg['Pregunta'].'
		';	
			
		$resp_correct = 1;
		if(isset($preg['Opcion_1'])&&$preg['Opcion_1']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};$Contenido .= ' - '.$preg['Opcion_1'].$tex.'<br/>';$resp_correct++;}
		if(isset($preg['Opcion_2'])&&$preg['Opcion_2']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};$Contenido .= ' - '.$preg['Opcion_2'].$tex.'<br/>';$resp_correct++;}
		if(isset($preg['Opcion_3'])&&$preg['Opcion_3']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};$Contenido .= ' - '.$preg['Opcion_3'].$tex.'<br/>';$resp_correct++;}
		if(isset($preg['Opcion_4'])&&$preg['Opcion_4']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};$Contenido .= ' - '.$preg['Opcion_4'].$tex.'<br/>';$resp_correct++;}
		if(isset($preg['Opcion_5'])&&$preg['Opcion_5']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};$Contenido .= ' - '.$preg['Opcion_5'].$tex.'<br/>';$resp_correct++;}
		if(isset($preg['Opcion_6'])&&$preg['Opcion_6']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};$Contenido .= ' - '.$preg['Opcion_6'].$tex.'<br/>';$resp_correct++;}

	} 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>sin título</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="generator" content="Geany 1.25" />
		<script src="../LIBS_js/PHPWord/build/docxtemplater.js"></script>
		<script src="../LIBS_js/PHPWord/vendor/FileSaver.min.js"></script>
		<script src="../LIBS_js/PHPWord/vendor/jszip-utils.js"></script>
		<!--
		Mandatory in IE 6, 7, 8 and 9.
		-->
		<!--[if IE]>
			<script type="text/javascript" src="lib_PHP2Word/examples/vendor/jszip-utils-ie.js"></script>
		<![endif]-->
		<script>
		var loadFile=function(url,callback){
			JSZipUtils.getBinaryContent(url,callback);
		}
		loadFile("../LIBS_js/PHPWord/doc/evaluaciones_1.docx",function(err,content){
			if (err) { throw e};
			doc=new Docxgen(content);
			doc.setData( {"Header_fecha":"<?php echo Fecha_estandar(fecha_actual()); ?>",
							"Header_texto":"<?php echo $rowData['Nombre']; ?>",
							"sistema":"<?php echo $rowData['sistema']; ?>",
							"Estado":"<?php echo $rowData['Estado']; ?>",
							"TipoPuntuacion":"<?php echo $TipoPuntuacion; ?>",
							"TipoEvaluacion":"<?php echo $TipoEvaluacion; ?>",
							"Contenido":"<?php echo $Contenido; ?>"
				}
			) //set the templateVariables
			doc.render() //apply them (replace all occurences of {first_name} by Hipp, ...)
			out=doc.getZip().generate({type:"blob"}) //Output the document using Data-URI
			saveAs(out,"bla.docx")
		})     

		</script>
	</head>

	<body>

	</body>
</html>




