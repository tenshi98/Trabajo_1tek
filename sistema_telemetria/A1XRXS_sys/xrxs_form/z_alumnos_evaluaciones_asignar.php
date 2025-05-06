<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-220).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idAsignar']))            $idAsignar               = $_POST['idAsignar'];
	if (!empty($_POST['idCurso']))              $idCurso                 = $_POST['idCurso'];
	if (!empty($_POST['Semana']))               $Semana                  = $_POST['Semana'];
	if (!empty($_POST['idQuiz']))               $idQuiz                  = $_POST['idQuiz'];
	if (!empty($_POST['Programada_fecha']))     $Programada_fecha        = $_POST['Programada_fecha'];
	if (!empty($_POST['idSistema']))            $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idAsignadas']))          $idAsignadas             = $_POST['idAsignadas'];

	//Categorias
	$categoria   = array();
	$n_categoria = array();
	for ($i = 1; $i <= 30; $i++) {
		if (!empty($_POST['categoria_'.$i]))    $categoria[$i]     = $_POST['categoria_'.$i];
		if (!empty($_POST['n_categoria_'.$i]))  $n_categoria[$i]   = $_POST['n_categoria_'.$i];
	}

	//Respuestas
	if (!empty($_POST['idQuizRealizadas']))     $idQuizRealizadas     = $_POST['idQuizRealizadas'];
	if (!empty($_POST['PorcentajeMin']))        $PorcentajeMin        = $_POST['PorcentajeMin'];
	$Respuesta   = array();
	$Correcta = array();
	for ($i = 1; $i <= 100; $i++) {
		if (!empty($_POST['Respuesta_'.$i])) $Respuesta[$i]  = $_POST['Respuesta_'.$i];
		if (!empty($_POST['Correcta_'.$i]))  $Correcta[$i]   = $_POST['Correcta_'.$i];
	}

	if (!empty($_POST['idAlumno']))             $idAlumno              = $_POST['idAlumno'];
	if (!empty($_POST['Creacion_fecha']))       $Creacion_fecha        = $_POST['Creacion_fecha'];
	if (!empty($_POST['Creacion_mes']))         $Creacion_mes          = $_POST['Creacion_mes'];
	if (!empty($_POST['Creacion_ano']))         $Creacion_ano          = $_POST['Creacion_ano'];
	if (!empty($_POST['idEstado']))             $idEstado              = $_POST['idEstado'];
	if (!empty($_POST['Total_Preguntas']))      $Total_Preguntas       = $_POST['Total_Preguntas'];
	if (!empty($_POST['Duracion_Max']))         $Duracion_Max          = $_POST['Duracion_Max'];
	if (!empty($_POST['Programada_fecha']))     $Programada_fecha      = $_POST['Programada_fecha'];
	if (!empty($_POST['Programada_dia']))       $Programada_dia        = $_POST['Programada_dia'];
	if (!empty($_POST['Programada_mes']))       $Programada_mes        = $_POST['Programada_mes'];
	if (!empty($_POST['Programada_ano']))       $Programada_ano        = $_POST['Programada_ano'];
	if (!empty($_POST['Ejecucion_fecha']))      $Ejecucion_fecha       = $_POST['Ejecucion_fecha'];
	if (!empty($_POST['Ejecucion_mes']))        $Ejecucion_mes         = $_POST['Ejecucion_mes'];
	if (!empty($_POST['Ejecucion_ano']))        $Ejecucion_ano         = $_POST['Ejecucion_ano'];
	if (!empty($_POST['Ejecucion_hora']))       $Ejecucion_hora        = $_POST['Ejecucion_hora'];
	if (!empty($_POST['idEstadoAprobacion']))   $idEstadoAprobacion    = $_POST['idEstadoAprobacion'];
	if (!empty($_POST['Respondido']))           $Respondido            = $_POST['Respondido'];
	if (!empty($_POST['Correctas']))            $Correctas             = $_POST['Correctas'];
	if (!empty($_POST['Rendimiento']))          $Rendimiento           = $_POST['Rendimiento'];
	if (!empty($_POST['Semana']))               $Semana                = $_POST['Semana'];

/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $_SESSION['form_require']);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'idAsignar':         if(empty($idAsignar)){         $error['idAsignar']         = 'error/No ha seleccionado el tipo de asignacion';}break;
			case 'idCurso':           if(empty($idCurso)){           $error['idCurso']           = 'error/No ha seleccionado el curso';}break;
			case 'Semana':            if(empty($Semana)){            $error['Semana']            = 'error/No ha seleccionado la semana';}break;
			case 'idQuiz':            if(empty($idQuiz)){            $error['idQuiz']            = 'error/No ha seleccionado una evaluacion';}break;
			case 'Programada_fecha':  if(empty($Programada_fecha)){  $error['Programada_fecha']  = 'error/No ha ingresado la fecha de programacion';}break;
			case 'idSistema':         if(empty($idSistema)){         $error['idSistema']         = 'error/No ha seleccionado el sistema';}break;
			case 'idAsignadas':       if(empty($idAsignadas)){       $error['idAsignadas']       = 'error/No ha seleccionado el id';}break;

		}
	}
/*******************************************************************************************************************/
/*                                           Validacion de respuestas                                              */
/*******************************************************************************************************************/
	for ($i = 1; $i <= 30; $i++) {
		if(isset($categoria[$i])&&isset($n_categoria[$i])&&$categoria[$i]>$n_categoria[$i]){
			$error['n_categoria_'.$i]      = 'error/La cantidad es superior a la permitida';
		}
	}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'paso_1':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idQuiz)&&isset($idCurso)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'idAsignadas', 'alumnos_evaluaciones_asignadas', '', "idQuiz='".$idQuiz."' AND idCurso='".$idCurso."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El cuestionario ya fue asignado anteriormente a este curso';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				switch ($idAsignar) {
					/********************************************************/
					//Asignar todo
					case 1:
						//Lista de alumnos
						$arrAlumnos = array();
						$arrAlumnos = db_select_array (false, 'idAlumno', 'alumnos_listado', '', 'idCurso='.$idCurso.' AND idEstado=1', 'idAlumno ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Traigo las preguntas
						$arrPreguntas = array();
						$arrPreguntas = db_select_array (false, 'quiz_listado.Tiempo, quiz_listado_preguntas.idPregunta', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = quiz_listado_preguntas.idQuiz', 'quiz_listado_preguntas.idQuiz='.$idQuiz, 'quiz_listado_preguntas.idCategoria ASC, RAND()', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Consulto por las categorias y el maximo de preguntas por cada una de estas
						$arrCategoria = array();
						$arrCategoria = db_select_array (false, 'quiz_listado_preguntas.idCategoria, COUNT(quiz_listado_preguntas.idPregunta) AS Cuenta', 'quiz_listado_preguntas', '', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' GROUP BY quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas.idCategoria ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Categorias
						$categoria   = array();
						$n_categoria = array();
						$xxn = 0;
						foreach ($arrCategoria as $cat) {
							$xxn++;
							$categoria[$xxn]     = $xxn;
							$n_categoria[$xxn]   = $cat['Cuenta'];
						}

						//se cuentan las preguntas de la campaña y se guardan sus id
						$Total_Preguntas  = 0;
						$Total_Alumnos    = 0;
						$BPreg            = array();
						$MemoLastID       = array();
						$Tiempo           = 0;
						foreach ($arrPreguntas as $pre) {
							$Total_Preguntas++;
							$BPreg[$Total_Preguntas] = $pre['idPregunta'];
							$Tiempo = $pre['Tiempo'];
						}

						//Cadena temporal
						$cadena = '';
						for ($i = 1; $i <= 100; $i++) {
							$cadena .= ',Pregunta_'.$i;
						}

						//Hago los insert dentro de cada alumno activo
						foreach ($arrAlumnos as $pre) {
							//filtros
							if(isset($pre['idAlumno']) && $pre['idAlumno']!=''){ $SIS_data  = "'".$pre['idAlumno']."'"; }else{$SIS_data  = "''";}
							if(isset($idQuiz) && $idQuiz!= '' &&$idQuiz!= 0){      $SIS_data .= ",'".$idQuiz."'";         }else{$SIS_data .= ",''";}
							$SIS_data .= ",'".fecha_actual()."'";
							$SIS_data .= ",'".fecha2NMes(fecha_actual())."'";
							$SIS_data .= ",'".fecha2Ano(fecha_actual())."'";
							$SIS_data .= ",'1'"; //estado:abierta
							if(isset($Total_Preguntas) && $Total_Preguntas!=''){ $SIS_data .= ",'".$Total_Preguntas."'";  }else{$SIS_data .= ",''";}
							if(isset($Tiempo) && $Tiempo!=''){                   $SIS_data .= ",'".$Tiempo."'";           }else{$SIS_data .= ",''";}
							if(isset($Programada_fecha) && $Programada_fecha!=''){
								$SIS_data .= ",'".$Programada_fecha."'";
								$SIS_data .= ",'".fecha2NdiaMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($Semana) && $Semana!=''){ $SIS_data .= ",'".$Semana."'"; }else{$SIS_data .= ",''";}

							//Reviso las preguntas
							for ($i = 1; $i <= 100; $i++) {
								if(isset($BPreg[$i]) && $BPreg[$i]!=''){ $SIS_data .= ",'".$BPreg[$i]."'"; }else{$SIS_data .= ",''";}
							}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAlumno, idQuiz, Creacion_fecha, Creacion_mes, Creacion_ano, idEstado,
							Total_Preguntas, Duracion_Max, Programada_fecha, Programada_dia, Programada_mes,
							Programada_ano, Semana '.$cadena;
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'quiz_realizadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Si ejecuto correctamente la consulta
							if($ultimo_id!=0){
								$MemoLastID[$pre['idAlumno']] = $ultimo_id;
								$Total_Alumnos++;
							}
						}
						/**************************************************************************************/
						//Registro los datos de la prueba
						$N_preguntas    = $Total_Preguntas;
						$N_Alumnos      = $Total_Alumnos;
						$N_Alumnos_Rep  = 0;
						//filtros
						if(isset($idSistema) && $idSistema!=''){               $SIS_data  = "'".$idSistema."'";  }else{$SIS_data  = "''";}
						if(isset($idAsignar) && $idAsignar!=''){               $SIS_data .= ",'".$idAsignar."'"; }else{$SIS_data .= ",''";}
						if(isset($idCurso) && $idCurso!=''){                   $SIS_data .= ",'".$idCurso."'";   }else{$SIS_data .= ",''";}
						if(isset($idQuiz) && $idQuiz!=''){                     $SIS_data .= ",'".$idQuiz."'";    }else{$SIS_data .= ",''";}
						if(isset($Programada_fecha) && $Programada_fecha!=''){
							$SIS_data .= ",'".$Programada_fecha."'";
							$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
							$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
						}else{
							$SIS_data .= ",''";
							$SIS_data .= ",''";
							$SIS_data .= ",''";
						}
						if(isset($N_preguntas) && $N_preguntas!=''){        $SIS_data .= ",'".$N_preguntas."'";     }else{$SIS_data .= ",''";}
						if(isset($N_Alumnos) && $N_Alumnos!=''){            $SIS_data .= ",'".$N_Alumnos."'";       }else{$SIS_data .= ",''";}
						if(isset($N_Alumnos_Rep) && $N_Alumnos_Rep!=''){    $SIS_data .= ",'".$N_Alumnos_Rep."'";   }else{$SIS_data .= ",''";}
						if(isset($Semana) && $Semana!=''){                  $SIS_data .= ",'".$Semana."'";          }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idSistema, idAsignar, idCurso, idQuiz, Programada_fecha, Programada_mes, Programada_ano, N_preguntas, N_Alumnos, N_Alumnos_Rep, Semana';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Si ejecuto correctamente la consulta
						if($ultimo_id!=0){
							/************************************/
							//Categorias y su numero de preguntas
							for ($i = 1; $i <= 30; $i++) {
								//Reviso si existe el dato
								if(isset($categoria[$i]) && $categoria[$i] != ''&&isset($n_categoria[$i]) && $n_categoria[$i]!=''){

									//filtros
									$SIS_data  = "'".$ultimo_id."'";
									$SIS_data .= ",'".$categoria[$i]."'";
									$SIS_data .= ",'".$n_categoria[$i]."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAsignadas, idCategoria, N_preguntas';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas_categorias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}
							/************************************/
							//Alumnos que se les hizo las pruebas
							foreach ($arrAlumnos as $pre) {
								//filtros
								$SIS_data  = "'".$ultimo_id."'";
								$SIS_data .= ",'".$pre['idAlumno']."'";
								$SIS_data .= ",'1'";
								$SIS_data .= ",'".$Programada_fecha."'";

								// inserto los datos de registro en la db
								$SIS_columns = 'idAsignadas, idAlumno, idTipo, Programada_fecha';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas_alumnos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//Si ejecuto correctamente la consulta
								if($ultimo_id2!=0){
									/*******************************************************/
									//se actualizan los datos
									$SIS_data = "idAsignadas='".$ultimo_id."'";
									$resultado = db_update_data (false, $SIS_data, 'quiz_realizadas', 'idQuizRealizadas = "'.$MemoLastID[$pre['idAlumno']].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								}
							}

							header( 'Location: '.$location.'&created=true' );
							die;
						}

						break;
					/********************************************************/
					//Random unico
					case 2:
						header( 'Location: '.$location.'&paso_2a=true&idAsignar='.$idAsignar.'&idCurso='.$idCurso.'&idQuiz='.$idQuiz.'&Programada_fecha='.$Programada_fecha.'&idSistema='.$idSistema.'&Semana='.$Semana );
						die;
						break;
					/********************************************************/
					//Random para todos
					case 3:
						header( 'Location: '.$location.'&paso_2b=true&idAsignar='.$idAsignar.'&idCurso='.$idCurso.'&idQuiz='.$idQuiz.'&Programada_fecha='.$Programada_fecha.'&idSistema='.$idSistema.'&Semana='.$Semana );
						die;
						break;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'paso_2a':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Consulto por las categorias y el maximo de preguntas por cada una de estas
				$arrCategoria = array();
				$arrCategoria = db_select_array (false, 'quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_categorias` ON quiz_categorias.idCategoria = quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' GROUP BY quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas.idCategoria ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Lista de alumnos
				$arrAlumnos = array();
				$arrAlumnos = db_select_array (false, 'idAlumno', 'alumnos_listado', '', 'idCurso='.$idCurso.' AND idEstado=1', 'idAlumno ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Cadena temporal
				$cadena = '';
				for ($i = 1; $i <= 100; $i++) {
					$cadena .= ',Pregunta_'.$i;
				}

				//recorro las categorias
				$xxn = 0;
				$Total_Preguntas  = 0;
				$Total_Alumnos    = 0;
				$BPreg            = array();
				$MemoLastID       = array();
				$Tiempo           = 0;
				foreach ($arrCategoria as $cat) {
					$xxn++;
					//Traigo las preguntas
					$arrPreguntas = array();
					$arrPreguntas = db_select_array (false, 'quiz_listado.Tiempo, quiz_listado_preguntas.idPregunta', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = quiz_listado_preguntas.idQuiz', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' AND quiz_listado_preguntas.idCategoria='.$cat['idCategoria'], 'quiz_listado_preguntas.idCategoria ASC, RAND() LIMIT '.$categoria[$xxn], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se cuentan las preguntas de la campaña y se guardan sus id
					foreach ($arrPreguntas as $pre) {
						$Total_Preguntas++;
						$BPreg[$Total_Preguntas] = $pre['idPregunta'];
						$Tiempo = $pre['Tiempo'];
					}
				}

				//recorro los alumnos
				foreach ($arrAlumnos as $pre) {

					//filtros
					if(isset($pre['idAlumno']) && $pre['idAlumno']!=''){    $SIS_data  = "'".$pre['idAlumno']."'";  }else{$SIS_data  = "''";}
					if(isset($idQuiz) && $idQuiz!= '' &&$idQuiz!= 0){       $SIS_data .= ",'".$idQuiz."'";          }else{$SIS_data .= ",''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'".fecha2NMes(fecha_actual())."'";
					$SIS_data .= ",'".fecha2Ano(fecha_actual())."'";
					$SIS_data .= ",'1'"; //estado:abierta
					if(isset($Total_Preguntas) && $Total_Preguntas!=''){ $SIS_data .= ",'".$Total_Preguntas."'";  }else{$SIS_data .= ",''";}
					if(isset($Tiempo) && $Tiempo!=''){                   $SIS_data .= ",'".$Tiempo."'";           }else{$SIS_data .= ",''";}
					if(isset($Programada_fecha) && $Programada_fecha!=''){
						$SIS_data .= ",'".$Programada_fecha."'";
						$SIS_data .= ",'".fecha2NdiaMes($Programada_fecha)."'";
						$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
						$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
					}else{
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
					}
					if(isset($Semana) && $Semana!=''){ $SIS_data .= ",'".$Semana."'"; }else{$SIS_data .= ",''";}
					//Reviso las preguntas
					for ($i = 1; $i <= 100; $i++) {
							if(isset($BPreg[$i]) && $BPreg[$i]!=''){ $SIS_data .= ",'".$BPreg[$i]."'"; }else{$SIS_data .= ",''";}
					}

					// inserto los datos de registro en la db
					$SIS_columns = 'idAlumno, idQuiz, Creacion_fecha, Creacion_mes, Creacion_ano, idEstado,
					Total_Preguntas, Duracion_Max, Programada_fecha, Programada_dia, Programada_mes, Programada_ano,
					Semana '.$cadena;
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'quiz_realizadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						$MemoLastID[$pre['idAlumno']] = $ultimo_id;
						$Total_Alumnos++;
					}
				}

				/**************************************************************************************/
				//Registro los datos de la prueba
				$N_preguntas    = $Total_Preguntas;
				$N_Alumnos      = $Total_Alumnos;
				$N_Alumnos_Rep  = 0;
				//filtros
				if(isset($idSistema) && $idSistema!=''){               $SIS_data  = "'".$idSistema."'";  }else{$SIS_data  = "''";}
				if(isset($idAsignar) && $idAsignar!=''){               $SIS_data .= ",'".$idAsignar."'"; }else{$SIS_data .= ",''";}
				if(isset($idCurso) && $idCurso!=''){                   $SIS_data .= ",'".$idCurso."'";   }else{$SIS_data .= ",''";}
				if(isset($idQuiz) && $idQuiz!=''){                     $SIS_data .= ",'".$idQuiz."'";    }else{$SIS_data .= ",''";}
				if(isset($Programada_fecha) && $Programada_fecha!=''){
					$SIS_data .= ",'".$Programada_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($N_preguntas) && $N_preguntas!=''){        $SIS_data .= ",'".$N_preguntas."'";     }else{$SIS_data .= ",''";}
				if(isset($N_Alumnos) && $N_Alumnos!=''){            $SIS_data .= ",'".$N_Alumnos."'";       }else{$SIS_data .= ",''";}
				if(isset($N_Alumnos_Rep) && $N_Alumnos_Rep!=''){    $SIS_data .= ",'".$N_Alumnos_Rep."'";   }else{$SIS_data .= ",''";}
				if(isset($Semana) && $Semana!=''){                  $SIS_data .= ",'".$Semana."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idAsignar, idCurso, idQuiz, Programada_fecha, Programada_mes, Programada_ano, N_preguntas, N_Alumnos, N_Alumnos_Rep, Semana';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/************************************/
					//Categorias y su numero de preguntas
					for ($i = 1; $i <= 30; $i++) {
						//Reviso si existe el dato
						if(isset($categoria[$i]) && $categoria[$i]!=''){

							//filtros
							$SIS_data  = "'".$ultimo_id."'";
							$SIS_data .= ",'".$i."'";
							$SIS_data .= ",'".$categoria[$i]."'";

							// inserto los datos de registro en la db
							$SIS_columns = 'idAsignadas, idCategoria, N_preguntas';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas_categorias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/************************************/
					//Alumnos que se les hizo las pruebas
					foreach ($arrAlumnos as $pre) {
						//filtros
						$SIS_data  = "'".$ultimo_id."'";
						$SIS_data .= ",'".$pre['idAlumno']."'";
						$SIS_data .= ",'1'";
						$SIS_data .= ",'".$Programada_fecha."'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idAsignadas, idAlumno, idTipo, Programada_fecha';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas_alumnos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*******************************************************/
						//se actualizan los datos
						$SIS_data = "idAsignadas='".$ultimo_id."'";
						$resultado = db_update_data (false, $SIS_data, 'quiz_realizadas', 'idQuizRealizadas = "'.$MemoLastID[$pre['idAlumno']].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'paso_2b':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Consulto por las categorias y el maximo de preguntas por cada una de estas
				$arrCategoria = array();
				$arrCategoria = db_select_array (false, 'quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_categorias` ON quiz_categorias.idCategoria = quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' GROUP BY quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas.idCategoria ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Lista de alumnos
				$arrAlumnos = array();
				$arrAlumnos = db_select_array (false, 'idAlumno', 'alumnos_listado', '', 'idCurso='.$idCurso.' AND idEstado=1', 'idAlumno ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Cadena temporal
				$cadena = '';
				for ($i = 1; $i <= 100; $i++) {
					$cadena .= ',Pregunta_'.$i;
				}

				//recorro los alumnos
				$Tiempo           = 0;
				$BPreg            = array();
				$MemoLastID       = array();
				$Total_Alumnos    = 0;

				foreach ($arrAlumnos as $pre) {
					//recorro las categorias
					$xxn = 0;
					$Total_Preguntas = 0;
					foreach ($arrCategoria as $cat) {
						$xxn++;
						//Traigo las preguntas
						$arrPreguntas = array();
						$arrPreguntas = db_select_array (false, 'quiz_listado.Tiempo, quiz_listado_preguntas.idPregunta', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = quiz_listado_preguntas.idQuiz', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' AND quiz_listado_preguntas.idCategoria='.$cat['idCategoria'], 'quiz_listado_preguntas.idCategoria ASC, RAND() LIMIT '.$categoria[$xxn], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//se cuentan las preguntas de la campaña y se guardan sus id
						foreach ($arrPreguntas as $bla) {
							$Total_Preguntas++;
							$BPreg[$pre['idAlumno']][$Total_Preguntas] = $bla['idPregunta'];
							$Tiempo = $bla['Tiempo'];
						}

					}
				}

				foreach ($arrAlumnos as $pre) {

					//filtros
					if(isset($pre['idAlumno']) && $pre['idAlumno']!=''){     $SIS_data  = "'".$pre['idAlumno']."'";  }else{$SIS_data  = "''";}
					if(isset($idQuiz) && $idQuiz!= '' &&$idQuiz!= 0){        $SIS_data .= ",'".$idQuiz."'";          }else{$SIS_data .= ",''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'".fecha2NMes(fecha_actual())."'";
					$SIS_data .= ",'".fecha2Ano(fecha_actual())."'";
					$SIS_data .= ",'1'"; //estado:abierta
					if(isset($Total_Preguntas) && $Total_Preguntas!=''){ $SIS_data .= ",'".$Total_Preguntas."'";  }else{$SIS_data .= ",''";}
					if(isset($Tiempo) && $Tiempo!=''){                   $SIS_data .= ",'".$Tiempo."'";           }else{$SIS_data .= ",''";}
					if(isset($Programada_fecha) && $Programada_fecha!=''){
						$SIS_data .= ",'".$Programada_fecha."'";
						$SIS_data .= ",'".fecha2NdiaMes($Programada_fecha)."'";
						$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
						$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
					}else{
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
					}
					if(isset($Semana) && $Semana!=''){ $SIS_data .= ",'".$Semana."'"; }else{$SIS_data .= ",''";}
					//Reviso las preguntas
					for ($i = 1; $i <= 100; $i++) {
						if(isset($BPreg[$pre['idAlumno']][$i]) && $BPreg[$pre['idAlumno']][$i]!=''){ $SIS_data .= ",'".$BPreg[$pre['idAlumno']][$i]."'"; }else{$SIS_data .= ",''";}
					}

					// inserto los datos de registro en la db
					$SIS_columns = 'idAlumno, idQuiz, Creacion_fecha, Creacion_mes, Creacion_ano, idEstado, 
					Total_Preguntas, Duracion_Max, Programada_fecha, Programada_dia, Programada_mes, Programada_ano, 
					Semana '.$cadena;
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'quiz_realizadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						$MemoLastID[$pre['idAlumno']] = $ultimo_id;
						$Total_Alumnos++;
					}

				}

				/**************************************************************************************/
				//Registro los datos de la prueba
				$N_preguntas    = $Total_Preguntas;
				$N_Alumnos      = $Total_Alumnos;
				$N_Alumnos_Rep  = 0;
				//filtros
				if(isset($idSistema) && $idSistema!=''){               $SIS_data  = "'".$idSistema."'";  }else{$SIS_data  = "''";}
				if(isset($idAsignar) && $idAsignar!=''){               $SIS_data .= ",'".$idAsignar."'"; }else{$SIS_data .= ",''";}
				if(isset($idCurso) && $idCurso!=''){                   $SIS_data .= ",'".$idCurso."'";   }else{$SIS_data .= ",''";}
				if(isset($idQuiz) && $idQuiz!=''){                     $SIS_data .= ",'".$idQuiz."'";    }else{$SIS_data .= ",''";}
				if(isset($Programada_fecha) && $Programada_fecha!=''){
					$SIS_data .= ",'".$Programada_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($N_preguntas) && $N_preguntas!=''){        $SIS_data .= ",'".$N_preguntas."'";     }else{$SIS_data .= ",''";}
				if(isset($N_Alumnos) && $N_Alumnos!=''){            $SIS_data .= ",'".$N_Alumnos."'";       }else{$SIS_data .= ",''";}
				if(isset($N_Alumnos_Rep) && $N_Alumnos_Rep!=''){    $SIS_data .= ",'".$N_Alumnos_Rep."'";   }else{$SIS_data .= ",''";}
				if(isset($Semana) && $Semana!=''){                  $SIS_data .= ",'".$Semana."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idAsignar, idCurso, idQuiz, Programada_fecha, Programada_mes,
				Programada_ano, N_preguntas, N_Alumnos, N_Alumnos_Rep, Semana';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/************************************/
					//Categorias y su numero de preguntas
					for ($i = 1; $i <= 30; $i++) {
						//Reviso si existe el dato
						if(isset($categoria[$i]) && $categoria[$i]!=''){

							//filtros
							$SIS_data = "'".$ultimo_id."'";
							$SIS_data .= ",'".$i."'";
							$SIS_data .= ",'".$categoria[$i]."'";

							// inserto los datos de registro en la db
							$SIS_columns = 'idAsignadas, idCategoria, N_preguntas';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas_categorias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/************************************/
					//Alumnos que se les hizo las pruebas
					foreach ($arrAlumnos as $pre) {
						//filtros
						$SIS_data = "'".$ultimo_id."'";
						$SIS_data .= ",'".$pre['idAlumno']."'";
						$SIS_data .= ",'1'";
						$SIS_data .= ",'".$Programada_fecha."'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idAsignadas, idAlumno, idTipo, Programada_fecha';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas_alumnos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*******************************************************/
						//se actualizan los datos
						$SIS_data = "idAsignadas='".$ultimo_id."'";
						$resultado = db_update_data (false, $SIS_data, 'quiz_realizadas', 'idQuizRealizadas = "'.$MemoLastID[$pre['idAlumno']].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'reintento':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*****************************************************/
			//Consulta por los datos de evaluacion
			$rowData = db_select_data (false, 'idSistema, idAsignar, idCurso, idQuiz, N_Alumnos_Rep', 'alumnos_evaluaciones_asignadas', '', 'idAsignadas = "'.$idAsignadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			/*****************************************************/
			//Variables
			$idAsignar      = $rowData['idAsignar'];
			$idCurso        = $rowData['idCurso'];
			$idQuiz         = $rowData['idQuiz'];
			$idSistema      = $rowData['idSistema'];
			$N_Alumnos_Rep  = $rowData['N_Alumnos_Rep'];
			$ndata_1        = 0;

			//Lista de alumnos reprobados
			$arrAlumnos = array();
			$arrAlumnos = db_select_array (false, 'idQuizRealizadas, idAlumno', 'quiz_realizadas', '', 'idQuiz='.$idQuiz.' AND idEstado=2 AND idEstadoAprobacion=1 AND idAsignadas='.$idAsignadas, 'idAlumno ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Consulto por las categorias y el maximo de preguntas por cada una de estas
			$arrCategoria = array();
			$arrCategoria = db_select_array (false, 'quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_categorias` ON quiz_categorias.idCategoria = quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' GROUP BY quiz_listado_preguntas.idCategoria', 'quiz_listado_preguntas.idCategoria ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Lista de categorias utilizadas
			$arrCategoriaMain = array();
			$arrCategoriaMain = db_select_array (false, 'idCategoria, N_preguntas', 'alumnos_evaluaciones_asignadas_categorias', '', 'idAsignadas='.$idAsignadas, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Categorias
			$categoria   = array();
			foreach ($arrCategoriaMain as $cat) {
				$categoria[$cat['idCategoria']] = $cat['N_preguntas'];
			}

			/**********************************************/
			//generacion de errores
			if($ndata_1==0) {$error['ndata_1'] = 'error/No hay Alumnos reprobados';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************************/
				switch ($idAsignar) {

					/********************************************************/
					//Asignar todo
					case 1:

						//Traigo las preguntas
						$arrPreguntas = array();
						$arrPreguntas = db_select_array (false, 'quiz_listado.Tiempo, quiz_listado_preguntas.idPregunta', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = quiz_listado_preguntas.idQuiz', 'quiz_listado_preguntas.idQuiz='.$idQuiz, 'quiz_listado_preguntas.idCategoria ASC, RAND()', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//se cuentan las preguntas de la campaña y se guardan sus id
						$Total_Preguntas = 0;
						$BPreg = array();
						$Tiempo = 0;
						foreach ($arrPreguntas as $pre) {
							$Total_Preguntas++;
							$BPreg[$Total_Preguntas] = $pre['idPregunta'];
							$Tiempo = $pre['Tiempo'];
						}

						//Cadena temporal
						$cadena = '';
						for ($i = 1; $i <= 100; $i++) {
							$cadena .= ',Pregunta_'.$i;
						}

						//Hago los insert dentro de cada alumno activo
						foreach ($arrAlumnos as $pre) {
							//filtros
							if(isset($pre['idAlumno']) && $pre['idAlumno']!=''){    $SIS_data  = "'".$pre['idAlumno']."'";  }else{$SIS_data  = "''";}
							if(isset($idQuiz) && $idQuiz!= '' &&$idQuiz!= 0){       $SIS_data .= ",'".$idQuiz."'";          }else{$SIS_data .= ",''";}
							$SIS_data .= ",'".fecha_actual()."'";
							$SIS_data .= ",'".fecha2NMes(fecha_actual())."'";
							$SIS_data .= ",'".fecha2Ano(fecha_actual())."'";
							$SIS_data .= ",'1'"; //estado:abierta
							if(isset($Total_Preguntas) && $Total_Preguntas!=''){ $SIS_data .= ",'".$Total_Preguntas."'";  }else{$SIS_data .= ",''";}
							if(isset($Tiempo) && $Tiempo!=''){                   $SIS_data .= ",'".$Tiempo."'";           }else{$SIS_data .= ",''";}
							if(isset($Programada_fecha) && $Programada_fecha!=''){
								$SIS_data .= ",'".$Programada_fecha."'";
								$SIS_data .= ",'".fecha2NdiaMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($Semana) && $Semana!=''){  $SIS_data .= ",'".$Semana."'"; }else{$SIS_data .= ",''";}

							//Reviso las preguntas
							for ($i = 1; $i <= 100; $i++) {
								if(isset($BPreg[$i]) && $BPreg[$i]!=''){ $SIS_data .= ",'".$BPreg[$i]."'"; }else{$SIS_data .= ",''";}
							}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAlumno, idQuiz, Creacion_fecha, Creacion_mes, Creacion_ano, idEstado,
							Total_Preguntas, Duracion_Max, Programada_fecha, Programada_dia, Programada_mes,
							Programada_ano, Semana '.$cadena;
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'quiz_realizadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
						break;
					/********************************************************/
					//Random unico
					case 2:

						//Cadena temporal
						$cadena = '';
						for ($i = 1; $i <= 100; $i++) {
							$cadena .= ',Pregunta_'.$i;
						}

						//recorro las categorias
						$xxn = 0;
						$Total_Preguntas  = 0;
						$BPreg            = array();
						$Tiempo           = 0;
						foreach ($arrCategoria as $cat) {
							$xxn++;
							//Traigo las preguntas
							$arrPreguntas = array();
							$arrPreguntas = db_select_array (false, 'quiz_listado.Tiempo, quiz_listado_preguntas.idPregunta', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = quiz_listado_preguntas.idQuiz', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' AND quiz_listado_preguntas.idCategoria='.$cat['idCategoria'], 'quiz_listado_preguntas.idCategoria ASC, RAND() LIMIT '.$categoria[$xxn], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//se cuentan las preguntas de la campaña y se guardan sus id
							foreach ($arrPreguntas as $pre) {
								$Total_Preguntas++;
								$BPreg[$Total_Preguntas] = $pre['idPregunta'];
								$Tiempo = $pre['Tiempo'];
							}

						}

						//recorro los alumnos
						foreach ($arrAlumnos as $pre) {

							//filtros
							if(isset($pre['idAlumno']) && $pre['idAlumno']!=''){   $SIS_data  = "'".$pre['idAlumno']."'"; }else{$SIS_data  = "''";}
							if(isset($idQuiz) && $idQuiz!= '' &&$idQuiz!= 0){      $SIS_data .= ",'".$idQuiz."'";         }else{$SIS_data .= ",''";}
							$SIS_data .= ",'".fecha_actual()."'";
							$SIS_data .= ",'".fecha2NMes(fecha_actual())."'";
							$SIS_data .= ",'".fecha2Ano(fecha_actual())."'";
							$SIS_data .= ",'1'"; //estado:abierta
							if(isset($Total_Preguntas) && $Total_Preguntas!=''){  $SIS_data .= ",'".$Total_Preguntas."'";  }else{$SIS_data .= ",''";}
							if(isset($Tiempo) && $Tiempo!=''){                    $SIS_data .= ",'".$Tiempo."'";           }else{$SIS_data .= ",''";}
							if(isset($Programada_fecha) && $Programada_fecha!=''){
								$SIS_data .= ",'".$Programada_fecha."'";
								$SIS_data .= ",'".fecha2NdiaMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($idAsignadas) && $idAsignadas!=''){  $SIS_data .= ",'".$idAsignadas."'"; }else{$SIS_data .= ",''";}
							if(isset($Semana) && $Semana!=''){            $SIS_data .= ",'".$Semana."'";      }else{$SIS_data .= ",''";}

							//Reviso las preguntas
							for ($i = 1; $i <= 100; $i++) {
									if(isset($BPreg[$i]) && $BPreg[$i]!=''){ $SIS_data .= ",'".$BPreg[$i]."'"; }else{$SIS_data .= ",''";}
							}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAlumno, idQuiz, Creacion_fecha, Creacion_mes, Creacion_ano,
							idEstado, Total_Preguntas, Duracion_Max, Programada_fecha, Programada_dia,
							Programada_mes, Programada_ano, idAsignadas, Semana '.$cadena;
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'quiz_realizadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
						break;
					/********************************************************/
					//Random para todos
					case 3:

						//Cadena temporal
						$cadena = '';
						for ($i = 1; $i <= 100; $i++) {
							$cadena .= ',Pregunta_'.$i;
						}

						//recorro los alumnos
						$Tiempo           = 0;
						$BPreg            = array();

						foreach ($arrAlumnos as $pre) {
							//recorro las categorias
							$xxn = 0;
							$Total_Preguntas = 0;
							foreach ($arrCategoria as $cat) {
								$xxn++;
								//Traigo las preguntas
								$arrPreguntas = array();
								$arrPreguntas = db_select_array (false, 'quiz_listado.Tiempo, quiz_listado_preguntas.idPregunta', 'quiz_listado_preguntas', 'LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = quiz_listado_preguntas.idQuiz', 'quiz_listado_preguntas.idQuiz='.$idQuiz.' AND quiz_listado_preguntas.idCategoria='.$cat['idCategoria'], 'quiz_listado_preguntas.idCategoria ASC, RAND() LIMIT '.$categoria[$xxn], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//se cuentan las preguntas de la campaña y se guardan sus id
								foreach ($arrPreguntas as $bla) {
									$Total_Preguntas++;
									$BPreg[$pre['idAlumno']][$Total_Preguntas] = $bla['idPregunta'];
									$Tiempo = $bla['Tiempo'];
								}

							}
						}

						foreach ($arrAlumnos as $pre) {

							//filtros
							if(isset($pre['idAlumno']) && $pre['idAlumno']!=''){   $SIS_data  = "'".$pre['idAlumno']."'"; }else{$SIS_data  = "''";}
							if(isset($idQuiz) && $idQuiz!= '' &&$idQuiz!= 0){      $SIS_data .= ",'".$idQuiz."'";         }else{$SIS_data .= ",''";}
							$SIS_data .= ",'".fecha_actual()."'";
							$SIS_data .= ",'".fecha2NMes(fecha_actual())."'";
							$SIS_data .= ",'".fecha2Ano(fecha_actual())."'";
							$SIS_data .= ",'1'"; //estado:abierta
							if(isset($Total_Preguntas) && $Total_Preguntas!=''){  $SIS_data .= ",'".$Total_Preguntas."'";  }else{$SIS_data .= ",''";}
							if(isset($Tiempo) && $Tiempo!=''){                    $SIS_data .= ",'".$Tiempo."'";           }else{$SIS_data .= ",''";}
							if(isset($Programada_fecha) && $Programada_fecha!=''){
								$SIS_data .= ",'".$Programada_fecha."'";
								$SIS_data .= ",'".fecha2NdiaMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2NMes($Programada_fecha)."'";
								$SIS_data .= ",'".fecha2Ano($Programada_fecha)."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($idAsignadas) && $idAsignadas!=''){ $SIS_data .= ",'".$idAsignadas."'"; }else{$SIS_data .= ",''";}
							if(isset($Semana) && $Semana!=''){           $SIS_data .= ",'".$Semana."'";      }else{$SIS_data .= ",''";}

							//Reviso las preguntas
							for ($i = 1; $i <= 100; $i++) {
								if(isset($BPreg[$pre['idAlumno']][$i]) && $BPreg[$pre['idAlumno']][$i]!=''){   $SIS_data .= ",'".$BPreg[$pre['idAlumno']][$i]."'";  }else{$SIS_data .= ",''";}
							}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAlumno, idQuiz, Creacion_fecha, Creacion_mes, Creacion_ano, idEstado,
							Total_Preguntas, Duracion_Max, Programada_fecha, Programada_dia, Programada_mes,
							Programada_ano, idAsignadas, Semana '.$cadena;
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'quiz_realizadas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
						break;
				}

				/************************************/
				//Alumnos que se les hizo las pruebas
				foreach ($arrAlumnos as $pre) {
					/*****************/
					//Guardo los datos en los alumnos que realizan la prueba
					$SIS_data = "'".$idAsignadas."'";
					$SIS_data .= ",'".$pre['idAlumno']."'";
					$SIS_data .= ",'2'";
					$SIS_data .= ",'".$Programada_fecha."'";

					// inserto los datos de registro en la db
					$SIS_columns = 'idAsignadas, idAlumno, idTipo, Programada_fecha';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'alumnos_evaluaciones_asignadas_alumnos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*******************************************************/
					//se actualizan los datos
					$SIS_data = "idEstadoAprobacion='3'";
					$resultado = db_update_data (false, $SIS_data, 'quiz_realizadas', 'idQuizRealizadas = "'.$pre['idQuizRealizadas'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*******************************************************/
				//se actualizan los datos
				$nuevo_valor = $N_Alumnos_Rep + $ndata_1;
				$SIS_data = "N_Alumnos_Rep='".$nuevo_valor."'";
				$resultado = db_update_data (false, $SIS_data, 'alumnos_evaluaciones_asignadas', 'idAsignadas = "'.$idAsignadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//redirijo
				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//variables
				$idEstadoAprobacion  = 0;
				$Respondido          = 0;
				$Rendimiento         = 0;

				$R_Correctas         = 0;
				$R_Respuestas        = 0;

				//Filtros
				$SIS_data = "idQuizRealizadas='".$idQuizRealizadas."'";
				//validaciones
				for ($i = 1; $i <= 100; $i++) {
					//guardo la respuesta
					if(isset($Respuesta[$i]) && $Respuesta[$i]!=''){
						$SIS_data .= ",Respuesta_".$i."='".$Respuesta[$i]."'";
						//sumo la cantidad de respuestas dadas
						$Respondido++;
					}else{
						$SIS_data .= ",Respuesta_".$i."=''";
					}
					//Reviso la cantidad de respuestas correctas
					if(isset($Correcta[$i]) && $Correcta[$i] != ''&&$Correcta[$i] != 0&&isset($Respuesta[$i]) && $Respuesta[$i]!=''){
						//si la respuesta es correcta
						if($Correcta[$i]==$Respuesta[$i]){
							$R_Correctas++;
						}
					}
					//Reviso la cantidad de respuestas dadas que pedian respuestas
					if(isset($Correcta[$i]) && $Correcta[$i] != ''&&$Correcta[$i] != 0){
						$R_Respuestas++;
					}
				}
				//se realizan calulos de rendimiento
				$Rendimiento = ($R_Correctas*100)/$R_Respuestas;
				if($Rendimiento<$PorcentajeMin){
					$idEstadoAprobacion = 1;//reprobado
				}else{
					$idEstadoAprobacion = 2;//aprobado
				}
				//resto de datos
				$SIS_data .= ",idEstado=2" ;
				$SIS_data .= ",idEstadoAprobacion='".$idEstadoAprobacion."'";
				$SIS_data .= ",Respondido='".$Respondido."'";
				$SIS_data .= ",Correctas='".$R_Correctas."'";
				$SIS_data .= ",Rendimiento='".$Rendimiento."'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'quiz_realizadas', 'idQuizRealizadas = "'.$idQuizRealizadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'upd_mod':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idQuizRealizadas='".$idQuizRealizadas."'";
				if(isset($idAlumno) && $idAlumno!=''){                      $SIS_data .= ",idAlumno='".$idAlumno."'";}
				if(isset($idQuiz) && $idQuiz!=''){                          $SIS_data .= ",idQuiz='".$idQuiz."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){          $SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";}
				if(isset($Creacion_mes) && $Creacion_mes!=''){              $SIS_data .= ",Creacion_mes='".$Creacion_mes."'";}
				if(isset($Creacion_ano) && $Creacion_ano!=''){              $SIS_data .= ",Creacion_ano='".$Creacion_ano."'";}
				if(isset($idEstado) && $idEstado!=''){                      $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Total_Preguntas) && $Total_Preguntas!=''){        $SIS_data .= ",Total_Preguntas='".$Total_Preguntas."'";}
				if(isset($Duracion_Max) && $Duracion_Max!=''){              $SIS_data .= ",Duracion_Max='".$Duracion_Max."'";}
				if(isset($Programada_fecha) && $Programada_fecha!=''){      $SIS_data .= ",Programada_fecha='".$Programada_fecha."'";}
				if(isset($Programada_dia) && $Programada_dia!=''){          $SIS_data .= ",Programada_dia='".$Programada_dia."'";}
				if(isset($Programada_mes) && $Programada_mes!=''){          $SIS_data .= ",Programada_mes='".$Programada_mes."'";}
				if(isset($Programada_ano) && $Programada_ano!=''){          $SIS_data .= ",Programada_ano='".$Programada_ano."'";}
				if(isset($Ejecucion_fecha) && $Ejecucion_fecha!=''){        $SIS_data .= ",Ejecucion_fecha='".$Ejecucion_fecha."'";}
				if(isset($Ejecucion_mes) && $Ejecucion_mes!=''){            $SIS_data .= ",Ejecucion_mes='".$Ejecucion_mes."'";}
				if(isset($Ejecucion_ano) && $Ejecucion_ano!=''){            $SIS_data .= ",Ejecucion_ano='".$Ejecucion_ano."'";}
				if(isset($Ejecucion_hora) && $Ejecucion_hora!=''){          $SIS_data .= ",Ejecucion_hora='".$Ejecucion_hora."'";}
				if(isset($idEstadoAprobacion) && $idEstadoAprobacion!=''){  $SIS_data .= ",idEstadoAprobacion='".$idEstadoAprobacion."'";}
				if(isset($Respondido) && $Respondido!=''){                  $SIS_data .= ",Respondido='".$Respondido."'";}
				if(isset($Correctas) && $Correctas!=''){                    $SIS_data .= ",Correctas='".$Correctas."'";}
				if(isset($Rendimiento) && $Rendimiento!=''){                $SIS_data .= ",Rendimiento='".$Rendimiento."'";}
				if(isset($idAsignadas) && $idAsignadas!=''){                $SIS_data .= ",idAsignadas='".$idAsignadas."'";}
				if(isset($Semana) && $Semana!=''){                          $SIS_data .= ",Semana='".$Semana."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'quiz_realizadas', 'idQuizRealizadas = "'.$idQuizRealizadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'del_asignacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_asignacion']) OR !validaEntero($_GET['del_asignacion']))&&$_GET['del_asignacion']!=''){
				$indice = simpleDecode($_GET['del_asignacion'], fecha_actual());
			}else{
				$indice = $_GET['del_asignacion'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice)&&$indice!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice)&&$indice!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			if($errorn==0){
				//se borran los datos
				$resultado_1 = db_delete_data (false, 'alumnos_evaluaciones_asignadas', 'idAsignadas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'alumnos_evaluaciones_asignadas_alumnos', 'idAsignadas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'alumnos_evaluaciones_asignadas_categorias', 'idAsignadas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_4 = db_delete_data (false, 'quiz_realizadas', 'idAsignadas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'modfecha':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*************************************************************/
				//tabla principal
				$SIS_data = "idAsignadas='".$idAsignadas."'";
				if(isset($Programada_fecha) && $Programada_fecha!=''){
					$SIS_data .= ",Programada_fecha='".$Programada_fecha."'";
					$SIS_data .= ",Programada_mes='".fecha2NMes($Programada_fecha)."'";
					$SIS_data .= ",Programada_ano='".fecha2Ano($Programada_fecha)."'";
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'alumnos_evaluaciones_asignadas', 'idAsignadas = "'.$idAsignadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************/
				//tabla dependiente
				$SIS_data = "Programada_fecha='".$Programada_fecha."'";
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'alumnos_evaluaciones_asignadas_alumnos', 'idAsignadas = "'.$idAsignadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************/
				//tabla con la prueba
				$SIS_data = "idAsignadas='".$idAsignadas."'";
				if(isset($Programada_fecha) && $Programada_fecha!=''){
					$SIS_data .= ",Programada_fecha='".$Programada_fecha."'";
					$SIS_data .= ",Programada_dia='".fecha2NdiaMes($Programada_fecha)."'";
					$SIS_data .= ",Programada_mes='".fecha2NMes($Programada_fecha)."'";
					$SIS_data .= ",Programada_ano='".fecha2Ano($Programada_fecha)."'";
				}
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'quiz_realizadas', 'idAsignadas = "'.$idAsignadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
