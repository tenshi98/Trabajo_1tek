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
$original = "rrhh_quiz_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
if(isset($_GET['search']) && $_GET['search']!=''){                $location .= "&search=".$_GET['search']; 	}
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
/***************************************************************************/
//formulario para crear
if (!empty($_POST['submit_quiz'])){
	//Llamamos al formulario
	$form_trabajo= 'insert_quiz';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_quiz_listado.php';
}
//formulario para crear
if (!empty($_POST['edit_quiz'])){
	//Ubicaciones nuevas
	$location .= "&id_quiz=".$_GET['id_quiz'];
	//Llamamos al formulario
	$form_trabajo= 'update_quiz';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_quiz_listado.php';
}
//se borra un dato
if (!empty($_GET['del_quiz'])){
	//Llamamos al formulario
	$form_trabajo= 'del_quiz';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_quiz_listado.php';
}
/***************************************************************************/
//formulario para crear
if (!empty($_POST['submit_pregunta'])){
	//Ubicaciones nuevas
	$location .= "&id_quiz=".$_GET['id_quiz'];
	//Llamamos al formulario
	$form_trabajo= 'insert_pregunta';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_quiz_listado.php';
}
//formulario para crear
if (!empty($_POST['edit_pregunta'])){
	//Ubicaciones nuevas
	$location .= "&id_quiz=".$_GET['id_quiz'];
	//Llamamos al formulario
	$form_trabajo= 'update_pregunta';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_quiz_listado.php';
}
//se borra un dato
if (!empty($_GET['del_pregunta'])){
	//Ubicaciones nuevas
	$location .= "&id_quiz=".$_GET['id_quiz'];
	//Llamamos al formulario
	$form_trabajo= 'del_pregunta';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_quiz_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Evaluacion Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Evaluacion Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Evaluacion Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['modBase'])){
// Se traen todos los datos de la pregunta
$query = "SELECT Nombre,Header_texto, Header_fecha, Footer_texto, Texto_Inicio, idSistema,
idEscala, Porcentaje_apro, idEstado, idTipoEvaluacion, idTipoQuiz
FROM `rrhh_quiz_listado`
WHERE idQuiz = ".$_GET['id_quiz'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Evaluacion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){            $x1  = $Nombre;             }else{$x1  = $rowData['Nombre'];}
				if(isset($idTipoEvaluacion)){  $x2  = $idTipoEvaluacion;   }else{$x2  = $rowData['idTipoEvaluacion'];}
				if(isset($idEscala)){          $x3  = $idEscala;           }else{$x3  = $rowData['idEscala'];}
				if(isset($Porcentaje_apro)){   $x4  = $Porcentaje_apro;    }else{$x4  = $rowData['Porcentaje_apro'];}
				if(isset($idTipoQuiz)){        $x7  = $idTipoQuiz;         }else{$x7  = $rowData['idTipoQuiz'];}
				if(isset($Header_texto)){      $x8  = $Header_texto;       }else{$x8  = $rowData['Header_texto'];}
				if(isset($Header_fecha)){      $x9  = $Header_fecha;       }else{$x9  = $rowData['Header_fecha'];}
				if(isset($Texto_Inicio)){      $x10 = $Texto_Inicio;       }else{$x10 = $rowData['Texto_Inicio'];}
				if(isset($Footer_texto)){      $x11 = $Footer_texto;       }else{$x11 = $rowData['Footer_texto'];}
				if(isset($idEstado)){          $x12 = $idEstado;           }else{$x12 = $rowData['idEstado'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Básicos');
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

				$Form_Inputs->form_select('Tipo Puntuacion','idTipoEvaluacion', $x2, 2, 'idTipoEvaluacion', 'Nombre', 'quiz_tipo_evaluacion', 0, '', $dbConn);
				$Form_Inputs->form_select('Escala','idEscala', $x3, 1, 'idEscala', 'Nombre', 'quiz_escala', 0, '', $dbConn);
				$Form_Inputs->form_select('% Aprobacion','Porcentaje_apro', $x4, 1, 'idEscala', 'Nombre', 'quiz_escala', 0, '', $dbConn);

				$Form_Inputs->form_select('Tipo de Evaluacion','idTipoQuiz', $x7, 2, 'idTipoQuiz', 'Nombre', 'quiz_tipo_quiz', 0, '', $dbConn);

				$Form_Inputs->form_tittle(3, 'Header');
				$Form_Inputs->form_input_text('Texto Cabecera', 'Header_texto', $x8, 1);
				$Form_Inputs->form_date('F Inicio','Header_fecha', $x9, 1);

				$Form_Inputs->form_tittle(3, 'Contenido');
				$Form_Inputs->form_ckeditor('Indicaciones','Texto_Inicio', $x10, 1,2);

				$Form_Inputs->form_tittle(3, 'Footer');
				$Form_Inputs->form_input_text('Texto Pie', 'Footer_texto', $x11, 1);

				$Form_Inputs->form_tittle(3, 'Estado');
				$Form_Inputs->form_select('Estado','idEstado', $x12, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idQuiz', $_GET['id_quiz'], 2);

				?>

				<script>
					document.getElementById('div_idEscala').style.display = 'none';
					document.getElementById('div_Porcentaje_apro').style.display = 'none';

					/************************************************************/
					//Tipo Evaluacion
					let TipoEvaluacion= $("#idTipoEvaluacion").val();	
					//Escala
					if(TipoEvaluacion == 1){ 
						document.getElementById('div_idEscala').style.display = '';
						document.getElementById('div_Porcentaje_apro').style.display = 'none';
								
						document.getElementById('idEscala').required = 'true';
						document.getElementById('Porcentaje_apro').required = 'false';

					//Porcentaje
					} else if(TipoEvaluacion == 2){ 
						document.getElementById('div_idEscala').style.display = 'none';
						document.getElementById('div_Porcentaje_apro').style.display = '';
								
						document.getElementById('idEscala').required = 'false';
						document.getElementById('Porcentaje_apro').required = 'true';

					} else {
						document.getElementById('div_idEscala').style.display = 'none';
						document.getElementById('div_Porcentaje_apro').style.display = 'none';
						document.getElementById('idEscala').required = 'false';
						document.getElementById('Porcentaje_apro').required = 'false';
									
					}

					/************************************************************/	
					$(document).ready(function(){
						//Tipo Evaluacion
						$("#idTipoEvaluacion").on("change", function(){
							TipoEvaluacion= $("#idTipoEvaluacion").val();

							//Escala
							if(TipoEvaluacion == 1){
								document.getElementById('div_idEscala').style.display = '';
								document.getElementById('div_Porcentaje_apro').style.display = 'none';
								
								document.getElementById('idEscala').required = 'true';
								document.getElementById('Porcentaje_apro').required = 'false';

							//Porcentaje
							} else if(TipoEvaluacion == 2){
								document.getElementById('div_idEscala').style.display = 'none';
								document.getElementById('div_Porcentaje_apro').style.display = '';
								
								document.getElementById('idEscala').required = 'false';
								document.getElementById('Porcentaje_apro').required = 'true';

							} else {
								document.getElementById('div_idEscala').style.display = 'none';
								document.getElementById('div_Porcentaje_apro').style.display = 'none';
								document.getElementById('idEscala').required = 'false';
								document.getElementById('Porcentaje_apro').required = 'false';

							}
						});

					});
				</script>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="edit_quiz">
					<a href="<?php echo $location.'&id_quiz='.$_GET['id_quiz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addPreg'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Pregunta</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idCategoria)){       $x1  = $idCategoria;     }else{$x1  = '';}
				if(isset($Nombre)){            $x2  = $Nombre;          }else{$x2  = '';}
				if(isset($idTipo)){            $x3  = $idTipo;          }else{$x3  = '';}
				if(isset($Opcion_1)){          $x4  = $Opcion_1;        }else{$x4  = '';}
				if(isset($Opcion_2)){          $x5  = $Opcion_2;        }else{$x5  = '';}
				if(isset($Opcion_3)){          $x6  = $Opcion_3;        }else{$x6  = '';}
				if(isset($Opcion_4)){          $x7  = $Opcion_4;        }else{$x7  = '';}
				if(isset($Opcion_5)){          $x8  = $Opcion_5;        }else{$x8  = '';}
				if(isset($Opcion_6)){          $x9  = $Opcion_6;        }else{$x9  = '';}
				if(isset($OpcionCorrecta)){    $x10 = $OpcionCorrecta;  }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Categoria','idCategoria', $x1, 2, 'idCategoria', 'Nombre', 'rrhh_quiz_categorias', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Pregunta', 'Nombre', $x2, 2);
				$Form_Inputs->form_select('Tipo de Pregunta','idTipo', $x3, 2, 'idTipo', 'Nombre', 'rrhh_quiz_tipo', 'idTipo!=2', '', $dbConn);

				$Form_Inputs->form_input_text('Opción 1', 'Opcion_1', $x4, 1);
				$Form_Inputs->form_input_text('Opción 2', 'Opcion_2', $x5, 1);
				$Form_Inputs->form_input_text('Opción 3', 'Opcion_3', $x6, 1);
				$Form_Inputs->form_input_text('Opción 4', 'Opcion_4', $x7, 1);
				$Form_Inputs->form_input_text('Opción 5', 'Opcion_5', $x8, 1);
				$Form_Inputs->form_input_text('Opción 6', 'Opcion_6', $x9, 1);
				$Form_Inputs->form_select_n_auto('Opción Correcta','OpcionCorrecta', $x10, 1, 1, 6);
				$Form_Inputs->form_input_hidden('idQuiz', $_GET['id_quiz'], 2);

				?>

				<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/jquery/jquery.min.js"></script>

				<script>
					document.getElementById('div_Opcion_1').style.display = 'none';
					document.getElementById('div_Opcion_2').style.display = 'none';
					document.getElementById('div_Opcion_3').style.display = 'none';
					document.getElementById('div_Opcion_4').style.display = 'none';
					document.getElementById('div_Opcion_5').style.display = 'none';
					document.getElementById('div_Opcion_6').style.display = 'none';
					document.getElementById('div_OpcionCorrecta').style.display = 'none';
	
					$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)
						
						$("#idTipo").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected= $("#idTipo").val();//Asignamos el valor seleccionado
							
							
							//Seleccion Unica
							if(modelSelected == 1){
								document.getElementById('div_Opcion_1').style.display = '';
								document.getElementById('div_Opcion_2').style.display = '';
								document.getElementById('div_Opcion_3').style.display = '';
								document.getElementById('div_Opcion_4').style.display = '';
								document.getElementById('div_Opcion_5').style.display = '';
								document.getElementById('div_Opcion_6').style.display = '';
								document.getElementById('div_OpcionCorrecta').style.display = '';

								//lo vacio
								document.getElementById('OpcionCorrecta').length = 1
								document.getElementById('OpcionCorrecta').options[0].value = ""
								document.getElementById('OpcionCorrecta').options[0].text = "Seleccione una Opción"
								//Le indico la cantidad de opciones a mostrar
								for ( i = 1; i <= 6; i += 1 ) {
									option = document.createElement('option');
									option.value = option.text = i;
									document.getElementById('OpcionCorrecta').add( option );
								}

							//Seleccion Multiple	
							} else if(modelSelected == 2){
								document.getElementById('div_Opcion_1').style.display = '';
								document.getElementById('div_Opcion_2').style.display = '';
								document.getElementById('div_Opcion_3').style.display = '';
								document.getElementById('div_Opcion_4').style.display = '';
								document.getElementById('div_Opcion_5').style.display = '';
								document.getElementById('div_Opcion_6').style.display = '';
								document.getElementById('div_OpcionCorrecta').style.display = 'none';

							//Verdadero o Falso	
							} else if(modelSelected == 3){
								document.getElementById('div_Opcion_1').style.display = '';
								document.getElementById('div_Opcion_2').style.display = '';
								document.getElementById('div_Opcion_3').style.display = 'none';
								document.getElementById('div_Opcion_4').style.display = 'none';
								document.getElementById('div_Opcion_5').style.display = 'none';
								document.getElementById('div_Opcion_6').style.display = 'none';
								document.getElementById('div_OpcionCorrecta').style.display = '';

								//lo vacio
								document.getElementById('OpcionCorrecta').length = 1
								document.getElementById('OpcionCorrecta').options[0].value = ""
								document.getElementById('OpcionCorrecta').options[0].text = "Seleccione una Opción"
								//Le indico la cantidad de opciones a mostrar
								for ( i = 1; i <= 2; i += 1 ) {
									option = document.createElement('option');
									option.value = option.text = i;
									document.getElementById('OpcionCorrecta').add( option );
								}
								
							//Para el resto	
							/*
							Observaciones
							Afirmacion
							Animo (3 caras)
							Animo (4 caras)
							Animo (5 caras)
							Valor (1 a 3)
							Valor (1 a 4)
							Valor (1 a 5)
							Voto
							*/
							} else {
								document.getElementById('div_Opcion_1').style.display = 'none';
								document.getElementById('div_Opcion_2').style.display = 'none';
								document.getElementById('div_Opcion_3').style.display = 'none';
								document.getElementById('div_Opcion_4').style.display = 'none';
								document.getElementById('div_Opcion_5').style.display = 'none';
								document.getElementById('div_Opcion_6').style.display = 'none';
								document.getElementById('div_OpcionCorrecta').style.display = 'none';

							}
						
						});
					});
					
				</script>
					
								
				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_pregunta">
					<a href="<?php echo $location.'&id_quiz='.$_GET['id_quiz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['editPreg'])){ 
$query = "SELECT Nombre,idTipo, Opcion_1, Opcion_2, Opcion_3, Opcion_4, Opcion_5, Opcion_6,
OpcionCorrecta, idCategoria
FROM `rrhh_quiz_listado_preguntas`
WHERE idPregunta = ".$_GET['editPreg'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Pregunta</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idCategoria)){       $x1  = $idCategoria;     }else{$x1  = $rowData['idCategoria'];}
				if(isset($Nombre)){            $x2  = $Nombre;          }else{$x2  = $rowData['Nombre'];}
				if(isset($idTipo)){            $x3  = $idTipo;          }else{$x3  = $rowData['idTipo'];}
				if(isset($Opcion_1)){          $x4  = $Opcion_1;        }else{$x4  = $rowData['Opcion_1'];}
				if(isset($Opcion_2)){          $x5  = $Opcion_2;        }else{$x5  = $rowData['Opcion_2'];}
				if(isset($Opcion_3)){          $x6  = $Opcion_3;        }else{$x6  = $rowData['Opcion_3'];}
				if(isset($Opcion_4)){          $x7  = $Opcion_4;        }else{$x7  = $rowData['Opcion_4'];}
				if(isset($Opcion_5)){          $x8  = $Opcion_5;        }else{$x8  = $rowData['Opcion_5'];}
				if(isset($Opcion_6)){          $x9  = $Opcion_6;        }else{$x9  = $rowData['Opcion_6'];}
				if(isset($OpcionCorrecta)){    $x10 = $OpcionCorrecta;  }else{$x10 = $rowData['OpcionCorrecta'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Categoria','idCategoria', $x1, 2, 'idCategoria', 'Nombre', 'rrhh_quiz_categorias', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Pregunta', 'Nombre', $x2, 2);
				$Form_Inputs->form_select('Tipo de Pregunta','idTipo', $x3, 2, 'idTipo', 'Nombre', 'rrhh_quiz_tipo', 'idTipo!=2', '', $dbConn);

				$Form_Inputs->form_input_text('Opción 1', 'Opcion_1', $x4, 1);
				$Form_Inputs->form_input_text('Opción 2', 'Opcion_2', $x5, 1);
				$Form_Inputs->form_input_text('Opción 3', 'Opcion_3', $x6, 1);
				$Form_Inputs->form_input_text('Opción 4', 'Opcion_4', $x7, 1);
				$Form_Inputs->form_input_text('Opción 5', 'Opcion_5', $x8, 1);
				$Form_Inputs->form_input_text('Opción 6', 'Opcion_6', $x9, 1);
				$Form_Inputs->form_select_n_auto('Opción Correcta','OpcionCorrecta', $x10, 1, 1, 6);
				$Form_Inputs->form_input_hidden('idQuiz', $_GET['id_quiz'], 2);
				$Form_Inputs->form_input_hidden('idPregunta', $_GET['editPreg'], 2);


				?>

				<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/jquery/jquery.min.js"></script>

				<script>
					document.getElementById('div_Opcion_1').style.display = 'none';
					document.getElementById('div_Opcion_2').style.display = 'none';
					document.getElementById('div_Opcion_3').style.display = 'none';
					document.getElementById('div_Opcion_4').style.display = 'none';
					document.getElementById('div_Opcion_5').style.display = 'none';
					document.getElementById('div_Opcion_6').style.display = 'none';
					document.getElementById('div_OpcionCorrecta').style.display = 'none';

					$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)
						
						let tipo_val= $("#idTipo").val();

						//Seleccion Unica
						if(tipo_val == 1){
							document.getElementById('div_Opcion_1').style.display = '';
							document.getElementById('div_Opcion_2').style.display = '';
							document.getElementById('div_Opcion_3').style.display = '';
							document.getElementById('div_Opcion_4').style.display = '';
							document.getElementById('div_Opcion_5').style.display = '';
							document.getElementById('div_Opcion_6').style.display = '';
							document.getElementById('div_OpcionCorrecta').style.display = '';

						//Seleccion Multiple		
						} else if(tipo_val == 2){
							document.getElementById('div_Opcion_1').style.display = '';
							document.getElementById('div_Opcion_2').style.display = '';
							document.getElementById('div_Opcion_3').style.display = '';
							document.getElementById('div_Opcion_4').style.display = '';
							document.getElementById('div_Opcion_5').style.display = '';
							document.getElementById('div_Opcion_6').style.display = '';
							document.getElementById('div_OpcionCorrecta').style.display = 'none';

						//Verdadero o Falso			
						} else if(tipo_val == 3){
							document.getElementById('div_Opcion_1').style.display = '';
							document.getElementById('div_Opcion_2').style.display = '';
							document.getElementById('div_Opcion_3').style.display = 'none';
							document.getElementById('div_Opcion_4').style.display = 'none';
							document.getElementById('div_Opcion_5').style.display = 'none';
							document.getElementById('div_Opcion_6').style.display = 'none';
							document.getElementById('div_OpcionCorrecta').style.display = '';

						//Para el resto	
						/*
						Observaciones
						Afirmacion
						Animo (3 caras)
						Animo (4 caras)
						Animo (5 caras)
						Valor (1 a 3)
						Valor (1 a 4)
						Valor (1 a 5)
						Voto
						*/	
						} else {
							document.getElementById('div_Opcion_1').style.display = 'none';
							document.getElementById('div_Opcion_2').style.display = 'none';
							document.getElementById('div_Opcion_3').style.display = 'none';
							document.getElementById('div_Opcion_4').style.display = 'none';
							document.getElementById('div_Opcion_5').style.display = 'none';
							document.getElementById('div_Opcion_6').style.display = 'none';
							document.getElementById('div_OpcionCorrecta').style.display = 'none';

						}
							
	
						$("#idTipo").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected= $("#idTipo").val();

							//Seleccion Unica
							if(modelSelected == 1){
								document.getElementById('div_Opcion_1').style.display = '';
								document.getElementById('div_Opcion_2').style.display = '';
								document.getElementById('div_Opcion_3').style.display = '';
								document.getElementById('div_Opcion_4').style.display = '';
								document.getElementById('div_Opcion_5').style.display = '';
								document.getElementById('div_Opcion_6').style.display = '';
								document.getElementById('div_OpcionCorrecta').style.display = '';

								//lo vacio
								document.getElementById('OpcionCorrecta').length = 1
								document.getElementById('OpcionCorrecta').options[0].value = ""
								document.getElementById('OpcionCorrecta').options[0].text = "Seleccione una Opción"
								//Le indico la cantidad de opciones a mostrar
								for ( i = 1; i <= 6; i += 1 ) {
									option = document.createElement('option');
									option.value = option.text = i;
									document.getElementById('OpcionCorrecta').add( option );
								}

							//Seleccion Multiple		
							} else if(modelSelected == 2){
								document.getElementById('div_Opcion_1').style.display = '';
								document.getElementById('div_Opcion_2').style.display = '';
								document.getElementById('div_Opcion_3').style.display = '';
								document.getElementById('div_Opcion_4').style.display = '';
								document.getElementById('div_Opcion_5').style.display = '';
								document.getElementById('div_Opcion_6').style.display = '';
								document.getElementById('div_OpcionCorrecta').style.display = 'none';

							//Verdadero o Falso	
							} else if(modelSelected == 3){
								document.getElementById('div_Opcion_1').style.display = '';
								document.getElementById('div_Opcion_2').style.display = '';
								document.getElementById('div_Opcion_3').style.display = 'none';
								document.getElementById('div_Opcion_4').style.display = 'none';
								document.getElementById('div_Opcion_5').style.display = 'none';
								document.getElementById('div_Opcion_6').style.display = 'none';
								document.getElementById('div_OpcionCorrecta').style.display = '';

								//lo vacio
								document.getElementById('OpcionCorrecta').length = 1
								document.getElementById('OpcionCorrecta').options[0].value = ""
								document.getElementById('OpcionCorrecta').options[0].text = "Seleccione una Opción"
								//Le indico la cantidad de opciones a mostrar
								for ( i = 1; i <= 2; i += 1 ) {
									option = document.createElement('option');
									option.value = option.text = i;
									document.getElementById('OpcionCorrecta').add( option );
								}

							//Para el resto	
							/*
							Observaciones
							Afirmacion
							Animo (3 caras)
							Animo (4 caras)
							Animo (5 caras)
							Valor (1 a 3)
							Valor (1 a 4)
							Valor (1 a 5)
							Voto
							*/
							} else {
								document.getElementById('div_Opcion_1').style.display = 'none';
								document.getElementById('div_Opcion_2').style.display = 'none';
								document.getElementById('div_Opcion_3').style.display = 'none';
								document.getElementById('div_Opcion_4').style.display = 'none';
								document.getElementById('div_Opcion_5').style.display = 'none';
								document.getElementById('div_Opcion_6').style.display = 'none';
								document.getElementById('div_OpcionCorrecta').style.display = 'none';

							}
						
						});
					});
					
				</script>
					
								
				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="edit_pregunta">
					<a href="<?php echo $location.'&id_quiz='.$_GET['id_quiz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>

		 
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['id_quiz'])){
// Se traen todos los datos de la pregunta
$query = "SELECT
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
rrhh_quiz_listado.idTipoQuiz

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
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
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
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrPreguntas,$row );
}

//cuento las preguntas
$count = 0;
foreach ($arrPreguntas as $preg) {
	$count++;
} 

?>
<?php if(isset($count)&&$count==0){ ?>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
			<?php
			$Alert_Text  = 'No tiene preguntas asignadas a la Evaluacion';
			alert_post_data(4,1,1,0, $Alert_Text);
			?>
		</div>
	</div>
	<div class="clearfix"></div>
<?php } ?>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<a target="new" href="rrhh_quiz_listado_to_word_1.php?id_quiz=<?php echo $_GET['id_quiz'] ?>" class="btn btn-info pull-right" ><i class="fa fa-file-word-o" aria-hidden="true"></i> Exportar a Word</a>
	</div>
</div>
<div class="clearfix"></div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Datos Básicos</h5>
				<div class="toolbar">
					<a href="<?php echo $location.'&id_quiz='.$_GET['id_quiz'].'&modBase=true' ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr>
							<td class="meta-head">Nombre</td>
							<td><?php echo $rowData['Nombre']?></td>
						</tr>
						<tr>
							<td class="meta-head">Texto Cabecera</td>
							<td><?php echo $rowData['Header_texto']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Fecha Cabecera</td>
							<td><?php echo fecha_estandar($rowData['Header_fecha']); ?></td>
						</tr>
						<tr>
							<td class="meta-head">Texto Contenido</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowData['Texto_Inicio']; ?></span></td>
						</tr>
						<tr>
							<td class="meta-head">Texto Pie Pagina</td>
							<td><?php echo $rowData['Footer_texto']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Sistema</td>
							<td><?php echo $rowData['sistema']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Estado</td>
							<td><?php echo $rowData['Estado']; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Tipo Puntuacion</td>
							<?php
							//Escala
							if(isset($rowData['idTipoEvaluacion'])&&$rowData['idTipoEvaluacion']==1){
								echo '<td>'.$rowData['TipoEvaluacion'].' : '.$rowData['Escala'].'</td>';
							//Porcentaje	
							}else{
								echo '<td>'.$rowData['TipoEvaluacion'].' : '.$rowData['Aprobado'].'</td>';
							}
							?>
						</tr>
						<tr>
							<td class="meta-head">Tipo Evaluacion</td>
							<?php
							//Cerrada
							if(isset($rowData['idTipoQuiz'])&&$rowData['idTipoQuiz']==1){
								echo '<td>'.$rowData['TipoQuiz'].'</td>';
							//Abierta 	
							}else{
								echo '<td>'.$rowData['TipoQuiz'].'</td>';
							}
							?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
	
	

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Preguntas</h5>
				<div class="toolbar">
					<?php
					//Mientras el total de preguntas sea igual o inferio a 15 se permite crear mas preguntas
					if(isset($count)&&$count<=100){ ?>
						<a href="<?php echo $location.'&id_quiz='.$_GET['id_quiz'].'&addPreg=true' ?>" class="btn btn-xs btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Pregunta</a>
					<?php } ?>
				</div>
			</header>
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
										<strong><?php echo $preg['Tipo']; ?> : </strong><span style="word-wrap: break-word;white-space: initial;"><?php echo $preg['Pregunta']; ?></span><hr>
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
									<td width="120" >
										<div class="btn-group" style="width: 70px;" >
											<a href="<?php echo $location.'&id_quiz='.$_GET['id_quiz'].'&editPreg='.$preg['idPregunta']; ?>" title="Editar Pregunta" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											<?php
											$ubicacion = $location.'&id_quiz='.$_GET['id_quiz'].'&del_pregunta='.simpleEncode($preg['idPregunta'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar '.str_replace('"','',$preg['Pregunta']).'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Pregunta" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										</div>
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
	







<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px; margin-top:30px">
<a href="<?php echo $location ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Evaluacion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){            $x1  = $Nombre;             }else{$x1  = '';}
				if(isset($idTipoEvaluacion)){  $x2  = $idTipoEvaluacion;   }else{$x2  = '';}
				if(isset($idEscala)){          $x3  = $idEscala;           }else{$x3  = '';}
				if(isset($Porcentaje_apro)){   $x4  = $Porcentaje_apro;    }else{$x4  = '';}
				if(isset($idTipoQuiz)){        $x7  = $idTipoQuiz;         }else{$x7  = '';}
				if(isset($Header_texto)){      $x8  = $Header_texto;       }else{$x8  = '';}
				if(isset($Header_fecha)){      $x9  = $Header_fecha;       }else{$x9  = '';}
				if(isset($Texto_Inicio)){      $x10 = $Texto_Inicio;       }else{$x10 = '';}
				if(isset($Footer_texto)){      $x11 = $Footer_texto;       }else{$x11 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Básicos');
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

				$Form_Inputs->form_select('Tipo Puntuacion','idTipoEvaluacion', $x2, 2, 'idTipoEvaluacion', 'Nombre', 'quiz_tipo_evaluacion', 0, '', $dbConn);
				$Form_Inputs->form_select('Escala','idEscala', $x3, 1, 'idEscala', 'Nombre', 'quiz_escala', 0, '', $dbConn);
				$Form_Inputs->form_select('% Aprobacion','Porcentaje_apro', $x4, 1, 'idEscala', 'Nombre', 'quiz_escala', 0, '', $dbConn);

				$Form_Inputs->form_select('Tipo de Evaluacion','idTipoQuiz', $x7, 2, 'idTipoQuiz', 'Nombre', 'quiz_tipo_quiz', 0, '', $dbConn);

				$Form_Inputs->form_tittle(3, 'Header');
				$Form_Inputs->form_input_text('Texto Cabecera', 'Header_texto', $x8, 1);
				$Form_Inputs->form_date('F Inicio','Header_fecha', $x9, 1);

				$Form_Inputs->form_tittle(3, 'Contenido');
				$Form_Inputs->form_ckeditor('Indicaciones','Texto_Inicio', $x10, 1,2);

				$Form_Inputs->form_tittle(3, 'Footer');
				$Form_Inputs->form_input_text('Texto Pie', 'Footer_texto', $x11, 1); 
				
				
				
				
				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				?>

				<script>
					document.getElementById('div_idEscala').style.display = 'none';
					document.getElementById('div_Porcentaje_apro').style.display = 'none';

					$(document).ready(function(){
						//Tipo Puntuacion
						$("#idTipoEvaluacion").on("change", function(){
							let TipoEvaluacion= $("#idTipoEvaluacion").val();

							//Escala
							if(TipoEvaluacion == 1){
								document.getElementById('div_idEscala').style.display = '';
								document.getElementById('div_Porcentaje_apro').style.display = 'none';
								
								document.getElementById('idEscala').required = 'true';
								document.getElementById('Porcentaje_apro').required = 'false';

							//Porcentaje
							} else if(TipoEvaluacion == 2){
								document.getElementById('div_idEscala').style.display = 'none';
								document.getElementById('div_Porcentaje_apro').style.display = '';
								
								document.getElementById('idEscala').required = 'false';
								document.getElementById('Porcentaje_apro').required = 'true';

							} else {
								document.getElementById('div_idEscala').style.display = 'none';
								document.getElementById('div_Porcentaje_apro').style.display = 'none';
								document.getElementById('idEscala').required = 'false';
								document.getElementById('Porcentaje_apro').required = 'false';

							}
						});
						 
					});
				</script>
					
								
				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_quiz">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//paginador de resultados
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'nombre_asc':    $order_by = 'rrhh_quiz_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':   $order_by = 'rrhh_quiz_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;

		default: $order_by = 'rrhh_quiz_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'rrhh_quiz_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "rrhh_quiz_listado.idQuiz!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){  $SIS_where .= " AND rrhh_quiz_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idQuiz', 'rrhh_quiz_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
rrhh_quiz_listado.idQuiz,
rrhh_quiz_listado.Nombre,
core_estados.Nombre AS Estado,
(SELECT COUNT(idPregunta) FROM `rrhh_quiz_listado_preguntas` WHERE idQuiz = rrhh_quiz_listado.idQuiz) AS N_preg,
rrhh_quiz_listado.idEstado';
$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = rrhh_quiz_listado.idEstado';
$SIS_order = 'rrhh_quiz_listado.idEstado ASC, rrhh_quiz_listado.Nombre ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrUsers = array();
$arrUsers = db_select_array (false, $SIS_query, 'rrhh_quiz_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Evaluacion</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){      $x1  = $Nombre;     }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);

				$Form_Inputs->form_input_hidden('pagina', 1, 1);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>

			</form>
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Evaluaciones</h5>
			<div class="toolbar">
				<?php
				if (isset($_GET['search'])){  $search ='&search='.$_GET['search'];} else { $search='';}
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th width="120">N° Preg</th>
						<th width="120">Estado</th>
						<th width="120">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrUsers as $usuarios){ ?>
					<tr class="odd">
						<td><?php echo $usuarios['Nombre']; ?></td>
						<td><?php echo $usuarios['N_preg']; ?></td>
						<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['Estado']; ?></label></td>
						<td>
							<div class="btn-group widthtd120" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_rrhh_quiz.php?view='.simpleEncode($usuarios['idQuiz'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id_quiz='.$usuarios['idQuiz']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del_quiz='.simpleEncode($usuarios['idQuiz'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el Punto '.$usuarios['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php
			if (isset($_GET['search'])){  $search ='&search='.$_GET['search'];} else { $search='';}
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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
