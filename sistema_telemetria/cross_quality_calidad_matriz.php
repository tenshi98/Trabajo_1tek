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
$original = "cross_quality_calidad_matriz.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){      $location .= "&idEstado=".$_GET['idEstado'];      $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['cantPuntos']) && $_GET['cantPuntos']!=''){  $location .= "&cantPuntos=".$_GET['cantPuntos'];  $search .= "&cantPuntos=".$_GET['cantPuntos'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){   $location .= "&Nombre=".$_GET['Nombre'];          $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idNota_1']) && $_GET['idNota_1']!=''){      $location .= "&idNota_1=".$_GET['idNota_1'];      $search .= "&idNota_1=".$_GET['idNota_1'];}
if(isset($_GET['idNota_2']) && $_GET['idNota_2']!=''){      $location .= "&idNota_2=".$_GET['idNota_2'];      $search .= "&idNota_2=".$_GET['idNota_2'];}
if(isset($_GET['idNota_3']) && $_GET['idNota_3']!=''){      $location .= "&idNota_3=".$_GET['idNota_3'];      $search .= "&idNota_3=".$_GET['idNota_3'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){   $location .= "&idTipo=".$_GET['idTipo'];          $search .= "&idTipo=".$_GET['idTipo'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_calidad_matriz.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_1'])){
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_calidad_matriz.php';
}
//formulario para editar
if (!empty($_POST['submit_edit_2'])){
	//Ubicación
	$location .='&idMatriz='.$_GET['idMatriz'];
	//Llamamos al formulario
	$form_trabajo= 'update_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_calidad_matriz.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del_matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_calidad_matriz.php';
}
//se clona la maquina
if (!empty($_POST['clone_Matriz'])){
	//Llamamos al formulario
	$form_trabajo= 'clone_Matriz';
	require_once 'A1XRXS_sys/xrxs_form/z_cross_quality_calidad_matriz.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Tipo Planilla Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Tipo Planilla Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Tipo Planilla Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone_idMatriz'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Clonar Tipo Planilla <?php echo $_GET['nombre_matriz']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idMatriz', $_GET['clone_idMatriz'], 2);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c5; Clonar" name="clone_Matriz">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['mod'])){
	//Armo cadena
	$SIS_query  = 'PuntoNombre_'.$_GET['mod'].' AS Nombre';
	$SIS_query .= ',PuntoMedAceptable_'.$_GET['mod'].' AS Aceptable';
	$SIS_query .= ',PuntoMedAlerta_'.$_GET['mod'].' AS Alerta';
	$SIS_query .= ',PuntoMedCondenatorio_'.$_GET['mod'].' AS Condenatorio';
	$SIS_query .= ',PuntoUniMed_'.$_GET['mod'].' AS UniMed';
	$SIS_query .= ',PuntoidTipo_'.$_GET['mod'].' AS Tipo';
	$SIS_query .= ',PuntoidGrupo_'.$_GET['mod'].' AS Grupo';
	$SIS_query .= ',Validacion_'.$_GET['mod'].' AS Validar';

	// consulto los datos
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idMatriz'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Editar Parametros  del punto</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Parametro','PuntoidGrupo', $rowData['Grupo'], 1, 'idGrupo', 'Nombre', 'cross_quality_calidad_matriz_grupos', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nombre', 'PuntoNombre', $rowData['Nombre'], 1);
					$Form_Inputs->form_select('Tipo','PuntoidTipo', $rowData['Tipo'], 1, 'idTipo', 'Nombre', 'core_cross_analisis_tipos', 0, '', $dbConn);

					$Form_Inputs->form_input_number('Aceptable','PuntoMedAceptable', Cantidades_decimales_justos($rowData['Aceptable']), 1);
					$Form_Inputs->form_input_number('Alerta','PuntoMedAlerta', Cantidades_decimales_justos($rowData['Alerta']), 1);
					$Form_Inputs->form_input_number('Condenatorio','PuntoMedCondenatorio', Cantidades_decimales_justos($rowData['Condenatorio']), 1);
					$Form_Inputs->form_select('Unidad de Medida','PuntoUniMed', $rowData['UniMed'], 1, 'idUml', 'Nombre', 'sistema_cross_analisis_uml', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Datos a Validar', 'Validar', $rowData['Validar'], 1);

					$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz'], 2);
					$Form_Inputs->form_input_hidden('mod', $_GET['mod'], 2);
					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_PuntoMedAceptable').style.display = 'none';
							document.getElementById('div_PuntoMedAlerta').style.display = 'none';
							document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
							document.getElementById('div_PuntoUniMed').style.display = 'none';
							document.getElementById('div_Validar').style.display = 'none';
							//se ejecuta al inicio
							LoadPuntoidTipo(0);
						});

						/**********************************************************************/
						document.getElementById("PuntoidTipo").onchange = function() {LoadPuntoidTipo(1)};

						/**********************************************************************/
						function LoadPuntoidTipo(caseLoad){
							//obtengo los valores
							let Sensores_val= $("#PuntoidTipo").val();
							//selecciono
							switch(Sensores_val) {
								//si es Medicion (Decimal) con parametros limitantes
								case '1':
									document.getElementById('div_PuntoMedAceptable').style.display = '';
									document.getElementById('div_PuntoMedAlerta').style.display = '';
									document.getElementById('div_PuntoMedCondenatorio').style.display = '';
									document.getElementById('div_PuntoUniMed').style.display = '';
								break;
								//si es Medicion (Decimal) sin parametros limitantes
								case '2':
									document.getElementById('div_PuntoMedAceptable').style.display = 'none';
									document.getElementById('div_PuntoMedAlerta').style.display = 'none';
									document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
									document.getElementById('div_PuntoUniMed').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="PuntoMedAceptable"]').value = '0';
										document.querySelector('input[name="PuntoMedAlerta"]').value = '0';
										document.querySelector('input[name="PuntoMedCondenatorio"]').value = '0';
									}
								break;
								//si es Medicion (Enteros) con parametros limitantes
								case '3':
									document.getElementById('div_PuntoMedAceptable').style.display = '';
									document.getElementById('div_PuntoMedAlerta').style.display = '';
									document.getElementById('div_PuntoMedCondenatorio').style.display = '';
									document.getElementById('div_PuntoUniMed').style.display = '';
								break;
								//si es Medicion (Enteros) sin parametros limitantes
								case '4':
									document.getElementById('div_PuntoMedAceptable').style.display = 'none';
									document.getElementById('div_PuntoMedAlerta').style.display = 'none';
									document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
									document.getElementById('div_PuntoUniMed').style.display = '';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="PuntoMedAceptable"]').value = '0';
										document.querySelector('input[name="PuntoMedAlerta"]').value = '0';
										document.querySelector('input[name="PuntoMedCondenatorio"]').value = '0';
									}
								break;
								//si es Texto Libre con Validacion
								case '11':
									document.getElementById('div_Validar').style.display = '';
									document.getElementById('div_PuntoUniMed').style.display = 'none';
								break;
								default:
									document.getElementById('div_PuntoMedAceptable').style.display = 'none';
									document.getElementById('div_PuntoMedAlerta').style.display = 'none';
									document.getElementById('div_PuntoMedCondenatorio').style.display = 'none';
									document.getElementById('div_PuntoUniMed').style.display = 'none';
									document.getElementById('div_Validar').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="PuntoMedAceptable"]').value = '0';
										document.querySelector('input[name="PuntoMedAlerta"]').value = '0';
										document.querySelector('input[name="PuntoMedCondenatorio"]').value = '0';
										document.querySelector('input[name="PuntoUniMed"]').value = '0';
										document.querySelector('input[name="Validar"]').value = '';
									}
								break;
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_2">
						<a href="<?php echo $location.'&idMatriz='.$_GET['idMatriz']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz'])){
	// consulto los datos
	$SIS_query = '
	Nombre,cantPuntos,
	PuntoNombre_1,PuntoNombre_2,PuntoNombre_3,PuntoNombre_4,PuntoNombre_5,
	PuntoNombre_6,PuntoNombre_7,PuntoNombre_8,PuntoNombre_9,PuntoNombre_10,
	PuntoNombre_11,PuntoNombre_12,PuntoNombre_13,PuntoNombre_14,PuntoNombre_15,
	PuntoNombre_16,PuntoNombre_17,PuntoNombre_18,PuntoNombre_19,PuntoNombre_20,
	PuntoNombre_21,PuntoNombre_22,PuntoNombre_23,PuntoNombre_24,PuntoNombre_25,
	PuntoNombre_26,PuntoNombre_27,PuntoNombre_28,PuntoNombre_29,PuntoNombre_30,
	PuntoNombre_31,PuntoNombre_32,PuntoNombre_33,PuntoNombre_34,PuntoNombre_35,
	PuntoNombre_36,PuntoNombre_37,PuntoNombre_38,PuntoNombre_39,PuntoNombre_40,
	PuntoNombre_41,PuntoNombre_42,PuntoNombre_43,PuntoNombre_44,PuntoNombre_45,
	PuntoNombre_46,PuntoNombre_47,PuntoNombre_48,PuntoNombre_49,PuntoNombre_50,

	PuntoMedAceptable_1,PuntoMedAceptable_2,PuntoMedAceptable_3,PuntoMedAceptable_4,PuntoMedAceptable_5,
	PuntoMedAceptable_6,PuntoMedAceptable_7,PuntoMedAceptable_8,PuntoMedAceptable_9,PuntoMedAceptable_10,
	PuntoMedAceptable_11,PuntoMedAceptable_12,PuntoMedAceptable_13,PuntoMedAceptable_14,PuntoMedAceptable_15,
	PuntoMedAceptable_16,PuntoMedAceptable_17,PuntoMedAceptable_18,PuntoMedAceptable_19,PuntoMedAceptable_20,
	PuntoMedAceptable_21,PuntoMedAceptable_22,PuntoMedAceptable_23,PuntoMedAceptable_24,PuntoMedAceptable_25,
	PuntoMedAceptable_26,PuntoMedAceptable_27,PuntoMedAceptable_28,PuntoMedAceptable_29,PuntoMedAceptable_30,
	PuntoMedAceptable_31,PuntoMedAceptable_32,PuntoMedAceptable_33,PuntoMedAceptable_34,PuntoMedAceptable_35,
	PuntoMedAceptable_36,PuntoMedAceptable_37,PuntoMedAceptable_38,PuntoMedAceptable_39,PuntoMedAceptable_40,
	PuntoMedAceptable_41,PuntoMedAceptable_42,PuntoMedAceptable_43,PuntoMedAceptable_44,PuntoMedAceptable_45,
	PuntoMedAceptable_46,PuntoMedAceptable_47,PuntoMedAceptable_48,PuntoMedAceptable_49,PuntoMedAceptable_50,

	PuntoMedAlerta_1,PuntoMedAlerta_2,PuntoMedAlerta_3,PuntoMedAlerta_4,PuntoMedAlerta_5,
	PuntoMedAlerta_6,PuntoMedAlerta_7,PuntoMedAlerta_8,PuntoMedAlerta_9,PuntoMedAlerta_10,
	PuntoMedAlerta_11,PuntoMedAlerta_12,PuntoMedAlerta_13,PuntoMedAlerta_14,PuntoMedAlerta_15,
	PuntoMedAlerta_16,PuntoMedAlerta_17,PuntoMedAlerta_18,PuntoMedAlerta_19,PuntoMedAlerta_20,
	PuntoMedAlerta_21,PuntoMedAlerta_22,PuntoMedAlerta_23,PuntoMedAlerta_24,PuntoMedAlerta_25,
	PuntoMedAlerta_26,PuntoMedAlerta_27,PuntoMedAlerta_28,PuntoMedAlerta_29,PuntoMedAlerta_30,
	PuntoMedAlerta_31,PuntoMedAlerta_32,PuntoMedAlerta_33,PuntoMedAlerta_34,PuntoMedAlerta_35,
	PuntoMedAlerta_36,PuntoMedAlerta_37,PuntoMedAlerta_38,PuntoMedAlerta_39,PuntoMedAlerta_40,
	PuntoMedAlerta_41,PuntoMedAlerta_42,PuntoMedAlerta_43,PuntoMedAlerta_44,PuntoMedAlerta_45,
	PuntoMedAlerta_46,PuntoMedAlerta_47,PuntoMedAlerta_48,PuntoMedAlerta_49,PuntoMedAlerta_50,

	PuntoMedCondenatorio_1,PuntoMedCondenatorio_2,PuntoMedCondenatorio_3,PuntoMedCondenatorio_4,PuntoMedCondenatorio_5,
	PuntoMedCondenatorio_6,PuntoMedCondenatorio_7,PuntoMedCondenatorio_8,PuntoMedCondenatorio_9,PuntoMedCondenatorio_10,
	PuntoMedCondenatorio_11,PuntoMedCondenatorio_12,PuntoMedCondenatorio_13,PuntoMedCondenatorio_14,PuntoMedCondenatorio_15,
	PuntoMedCondenatorio_16,PuntoMedCondenatorio_17,PuntoMedCondenatorio_18,PuntoMedCondenatorio_19,PuntoMedCondenatorio_20,
	PuntoMedCondenatorio_21,PuntoMedCondenatorio_22,PuntoMedCondenatorio_23,PuntoMedCondenatorio_24,PuntoMedCondenatorio_25,
	PuntoMedCondenatorio_26,PuntoMedCondenatorio_27,PuntoMedCondenatorio_28,PuntoMedCondenatorio_29,PuntoMedCondenatorio_30,
	PuntoMedCondenatorio_31,PuntoMedCondenatorio_32,PuntoMedCondenatorio_33,PuntoMedCondenatorio_34,PuntoMedCondenatorio_35,
	PuntoMedCondenatorio_36,PuntoMedCondenatorio_37,PuntoMedCondenatorio_38,PuntoMedCondenatorio_39,PuntoMedCondenatorio_40,
	PuntoMedCondenatorio_41,PuntoMedCondenatorio_42,PuntoMedCondenatorio_43,PuntoMedCondenatorio_44,PuntoMedCondenatorio_45,
	PuntoMedCondenatorio_46,PuntoMedCondenatorio_47,PuntoMedCondenatorio_48,PuntoMedCondenatorio_49,PuntoMedCondenatorio_50,

	PuntoUniMed_1,PuntoUniMed_2,PuntoUniMed_3,PuntoUniMed_4,PuntoUniMed_5,
	PuntoUniMed_6,PuntoUniMed_7,PuntoUniMed_8,PuntoUniMed_9,PuntoUniMed_10,
	PuntoUniMed_11,PuntoUniMed_12,PuntoUniMed_13,PuntoUniMed_14,PuntoUniMed_15,
	PuntoUniMed_16,PuntoUniMed_17,PuntoUniMed_18,PuntoUniMed_19,PuntoUniMed_20,
	PuntoUniMed_21,PuntoUniMed_22,PuntoUniMed_23,PuntoUniMed_24,PuntoUniMed_25,
	PuntoUniMed_26,PuntoUniMed_27,PuntoUniMed_28,PuntoUniMed_29,PuntoUniMed_30,
	PuntoUniMed_31,PuntoUniMed_32,PuntoUniMed_33,PuntoUniMed_34,PuntoUniMed_35,
	PuntoUniMed_36,PuntoUniMed_37,PuntoUniMed_38,PuntoUniMed_39,PuntoUniMed_40,
	PuntoUniMed_41,PuntoUniMed_42,PuntoUniMed_43,PuntoUniMed_44,PuntoUniMed_45,
	PuntoUniMed_46,PuntoUniMed_47,PuntoUniMed_48,PuntoUniMed_49,PuntoUniMed_50,

	PuntoidGrupo_1,PuntoidGrupo_2,PuntoidGrupo_3,PuntoidGrupo_4,PuntoidGrupo_5,
	PuntoidGrupo_6,PuntoidGrupo_7,PuntoidGrupo_8,PuntoidGrupo_9,PuntoidGrupo_10,
	PuntoidGrupo_11,PuntoidGrupo_12,PuntoidGrupo_13,PuntoidGrupo_14,PuntoidGrupo_15,
	PuntoidGrupo_16,PuntoidGrupo_17,PuntoidGrupo_18,PuntoidGrupo_19,PuntoidGrupo_20,
	PuntoidGrupo_21,PuntoidGrupo_22,PuntoidGrupo_23,PuntoidGrupo_24,PuntoidGrupo_25,
	PuntoidGrupo_26,PuntoidGrupo_27,PuntoidGrupo_28,PuntoidGrupo_29,PuntoidGrupo_30,
	PuntoidGrupo_31,PuntoidGrupo_32,PuntoidGrupo_33,PuntoidGrupo_34,PuntoidGrupo_35,
	PuntoidGrupo_36,PuntoidGrupo_37,PuntoidGrupo_38,PuntoidGrupo_39,PuntoidGrupo_40,
	PuntoidGrupo_41,PuntoidGrupo_42,PuntoidGrupo_43,PuntoidGrupo_44,PuntoidGrupo_45,
	PuntoidGrupo_46,PuntoidGrupo_47,PuntoidGrupo_48,PuntoidGrupo_49,PuntoidGrupo_50,

	PuntoidTipo_1,PuntoidTipo_2,PuntoidTipo_3,PuntoidTipo_4,PuntoidTipo_5,
	PuntoidTipo_6,PuntoidTipo_7,PuntoidTipo_8,PuntoidTipo_9,PuntoidTipo_10,
	PuntoidTipo_11,PuntoidTipo_12,PuntoidTipo_13,PuntoidTipo_14,PuntoidTipo_15,
	PuntoidTipo_16,PuntoidTipo_17,PuntoidTipo_18,PuntoidTipo_19,PuntoidTipo_20,
	PuntoidTipo_21,PuntoidTipo_22,PuntoidTipo_23,PuntoidTipo_24,PuntoidTipo_25,
	PuntoidTipo_26,PuntoidTipo_27,PuntoidTipo_28,PuntoidTipo_29,PuntoidTipo_30,
	PuntoidTipo_31,PuntoidTipo_32,PuntoidTipo_33,PuntoidTipo_34,PuntoidTipo_35,
	PuntoidTipo_36,PuntoidTipo_37,PuntoidTipo_38,PuntoidTipo_39,PuntoidTipo_40,
	PuntoidTipo_41,PuntoidTipo_42,PuntoidTipo_43,PuntoidTipo_44,PuntoidTipo_45,
	PuntoidTipo_46,PuntoidTipo_47,PuntoidTipo_48,PuntoidTipo_49,PuntoidTipo_50';
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idMatriz'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/************************************************/
	//consulto
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUml,Nombre', 'sistema_cross_analisis_uml', '', 'idUml!=0', 'idUml ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');
	$arrTipos = array();
	$arrTipos = db_select_array (false, 'idTipo,Nombre', 'core_cross_analisis_tipos', '', 'idTipo!=0', 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'cross_quality_calidad_matriz_grupos', '', 'idGrupo!=0', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

	/************************************************/
	//Ordeno
	$arrFinalUnimed = array();
	$arrFinalTipos = array();
	$arrFinalGrupos = array();
	foreach ($arrUnimed as $data) {  $arrFinalUnimed[$data['idUml']]   = $data['Nombre'];}
	foreach ($arrTipos as $data) {   $arrFinalTipos[$data['idTipo']]   = $data['Nombre'];}
	foreach ($arrGrupos as $data) {  $arrFinalGrupos[$data['idGrupo']] = $data['Nombre'];}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Puntos de Tipo Planilla</h5>
			</header>

			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Parametro</th>
							<th>Nombre</th>
							<th>Tipo</th>
							<th>Aceptable</th>
							<th>Alerta</th>
							<th>Condenatorio</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php for ($i = 1; $i <= $rowData['cantPuntos']; $i++) {
							//compruebo
							if(isset($arrFinalUnimed[$rowData['SensoresUniMed_'.$i]])){ $unimed = $arrFinalUnimed[$rowData['SensoresUniMed_'.$i]];}else{ $unimed = '';}
							if(isset($arrFinalTipos[$rowData['PuntoidTipo_'.$i]])){     $tipo   = $arrFinalTipos[$rowData['PuntoidTipo_'.$i]];     }else{ $tipo   = '';}
							if(isset($arrFinalGrupos[$rowData['PuntoidGrupo_'.$i]])){   $grupo  = $arrFinalGrupos[$rowData['PuntoidGrupo_'.$i]];   }else{ $grupo  = '';}
							?>
							<tr class="odd">
								<td><?php echo 'p'.$i ?></td>
								<td><?php echo $grupo; ?></td>
								<td><?php echo $rowData['PuntoNombre_'.$i]; ?></td>
								<td><?php echo $tipo; ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAceptable_'.$i]).' '.$unimed;     }else{echo 'No Aplica';} ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedAlerta_'.$i]).' '.$unimed;        }else{echo 'No Aplica';} ?></td>
								<td><?php if(isset($rowData['PuntoidTipo_'.$i])&&$rowData['PuntoidTipo_'.$i]==1){echo Cantidades_decimales_justos($rowData['PuntoMedCondenatorio_'.$i]).' '.$unimed;  }else{echo 'No Aplica';} ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&idMatriz='.$_GET['idMatriz'].'&mod='.$i; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['idMatriz_2'])){
	// consulto los datos
	$SIS_query = 'Nombre,cantPuntos, idEstado, idNota_1, idNota_2, idNota_3, idNotaTipo_1, idNotaTipo_2, idNotaTipo_3, idTipo, idSistema, Validar_1, Validar_2, Validar_3';
	$SIS_join  = '';
	$SIS_where = 'idMatriz ='.$_GET['idMatriz_2'];
	$rowData = db_select_data (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Modificación Tipo Planilla</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){       $x1  = $Nombre;       }else{$x1  = $rowData['Nombre'];}
					if(isset($cantPuntos)){   $x2  = $cantPuntos;   }else{$x2  = $rowData['cantPuntos'];}
					if(isset($idTipo)){       $x3  = $idTipo;       }else{$x3  = $rowData['idTipo'];}
					if(isset($idEstado)){     $x4  = $idEstado;     }else{$x4  = $rowData['idEstado'];}
					if(isset($idNota_1)){     $x5  = $idNota_1;     }else{$x5  = $rowData['idNota_1'];}
					if(isset($idNotaTipo_1)){ $x6  = $idNotaTipo_1; }else{$x6  = $rowData['idNotaTipo_1'];}
					if(isset($Validar_1)){    $x7  = $Validar_1;    }else{$x7  = $rowData['Validar_1'];}
					if(isset($idNota_2)){     $x8  = $idNota_2;     }else{$x8  = $rowData['idNota_2'];}
					if(isset($idNotaTipo_2)){ $x9  = $idNotaTipo_2; }else{$x9  = $rowData['idNotaTipo_2'];}
					if(isset($Validar_2)){    $x10 = $Validar_2;    }else{$x10 = $rowData['Validar_2'];}
					if(isset($idNota_3)){     $x11 = $idNota_3;     }else{$x11 = $rowData['idNota_3'];}
					if(isset($idNotaTipo_3)){ $x12 = $idNotaTipo_3; }else{$x12 = $rowData['idNotaTipo_3'];}
					if(isset($Validar_3)){    $x13 = $Validar_3;    }else{$x13 = $rowData['Validar_3'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 2, 1, 100);
					$Form_Inputs->form_select('Tipo Planilla','idTipo', $x3, 2, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);
					$Form_Inputs->form_select('Estado','idEstado', $x4, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);

					$Form_Inputs->form_select('Nota Calidad','idNota_1', $x5, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo Nota Calidad','idNotaTipo_1', $x6, 1, 'idTipo', 'Nombre', 'core_cross_analisis_tipos', 'idTipo=2 OR idTipo=4 OR idTipo=7 OR idTipo=8 OR idTipo=9 OR idTipo=10 OR idTipo=11', '', $dbConn);
					$Form_Inputs->form_input_text('Datos a Validar', 'Validar_1', $x7, 1);

					$Form_Inputs->form_select('Nota Condición','idNota_2', $x8, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo Nota Condición','idNotaTipo_2', $x9, 1, 'idTipo', 'Nombre', 'core_cross_analisis_tipos', 'idTipo=2 OR idTipo=4 OR idTipo=7 OR idTipo=8 OR idTipo=9 OR idTipo=10 OR idTipo=11', '', $dbConn);
					$Form_Inputs->form_input_text('Datos a Validar', 'Validar_2', $x10, 1);

					$Form_Inputs->form_select('Calificacion','idNota_3', $x11, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo Calificacion','idNotaTipo_3', $x12, 1, 'idTipo', 'Nombre', 'core_cross_analisis_tipos', 'idTipo=2 OR idTipo=4 OR idTipo=7 OR idTipo=8 OR idTipo=9 OR idTipo=10 OR idTipo=11', '', $dbConn);
					$Form_Inputs->form_input_text('Datos a Validar', 'Validar_3', $x13, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idMatriz', $_GET['idMatriz_2'], 2);
					?>

					<script>
						/**********************************************************************/
						$(document).ready(function(){
							document.getElementById('div_idNotaTipo_1').style.display = 'none';
							document.getElementById('div_idNotaTipo_2').style.display = 'none';
							document.getElementById('div_idNotaTipo_3').style.display = 'none';
							document.getElementById('div_Validar_1').style.display = 'none';
							document.getElementById('div_Validar_2').style.display = 'none';
							document.getElementById('div_Validar_3').style.display = 'none';
							//se ejecuta al inicio
							LoadNota_1(0);
							LoadNota_2(0);
							LoadNota_3(0);
							LoadNotaTipo_1(0);
							LoadNotaTipo_2(0);
							LoadNotaTipo_3(0);
						});

						/**********************************************************************/
						document.getElementById("idNota_1").onchange = function() {LoadNota_1(1)};
						document.getElementById("idNota_2").onchange = function() {LoadNota_2(1)};
						document.getElementById("idNota_3").onchange = function() {LoadNota_3(1)};
						document.getElementById("idNotaTipo_1").onchange = function() {LoadNotaTipo_1(1)};
						document.getElementById("idNotaTipo_2").onchange = function() {LoadNotaTipo_2(1)};
						document.getElementById("idNotaTipo_3").onchange = function() {LoadNotaTipo_3(1)};

						/**********************************************************************/
						function LoadNota_1(caseLoad){
							//obtengo los valores
							let Sensores_val_1 = $("#idNota_1").val();
							//selecciono
							switch(Sensores_val_1) {
								//si la opción esta activa
								case '1':
									document.getElementById('div_idNotaTipo_1').style.display = '';
								break;
								//si la opción esta inactiva
								case '2':
									document.getElementById('div_idNotaTipo_1').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idNotaTipo_1"]').selectedIndex = 0;
									}
								break;
								//para el resto
								default:
									document.getElementById('div_idNotaTipo_1').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idNotaTipo_1"]').selectedIndex = 0;
									}
								break;
							}
						}

						/**********************************************************************/
						function LoadNota_2(caseLoad){
							//obtengo los valores
							let Sensores_val_2 = $("#idNota_2").val();
							//selecciono
							switch(Sensores_val_2) {
								//si la opción esta activa
								case '1':
									document.getElementById('div_idNotaTipo_2').style.display = '';
								break;
								//si la opción esta inactiva
								case '2':
									document.getElementById('div_idNotaTipo_2').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idNotaTipo_2"]').selectedIndex = 0;
									}
								break;
								//para el resto
								default:
									document.getElementById('div_idNotaTipo_2').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idNotaTipo_2"]').selectedIndex = 0;
									}
								break;
							}
						}

						/**********************************************************************/
						function LoadNota_3(caseLoad){
							//obtengo los valores
							let Sensores_val_3 = $("#idNota_3").val();
							//selecciono
							switch(Sensores_val_3) {
								//si la opción esta activa
								case '1':
									document.getElementById('div_idNotaTipo_3').style.display = '';
								break;
								//si la opción esta inactiva
								case '2':
									document.getElementById('div_idNotaTipo_3').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idNotaTipo_3"]').selectedIndex = 0;
									}
								break;
								//para el resto
								default:
									document.getElementById('div_idNotaTipo_3').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="idNotaTipo_3"]').selectedIndex = 0;
									}
								break;
							}
						}

						/**********************************************************************/
						function LoadNotaTipo_1(caseLoad){
							//obtengo los valores
							let Sensores_tipo_1 = $("#idNotaTipo_1").val();
							//selecciono
							switch(Sensores_tipo_1) {
								//Texto Libre con Validacion
								case '11':
									document.getElementById('div_Validar_1').style.display = '';
								break;
								default:
									document.getElementById('div_Validar_1').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Validar_1"]').value = '';
									}
								break;
							}
						}

						/**********************************************************************/
						function LoadNotaTipo_2(caseLoad){
							//obtengo los valores
							let Sensores_tipo_2 = $("#idNotaTipo_2").val();
							//selecciono
							switch(Sensores_tipo_2) {
								//Texto Libre con Validacion
								case '11':
									document.getElementById('div_Validar_2').style.display = '';
								break;
								default:
									document.getElementById('div_Validar_2').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Validar_2"]').value = '';
									}
								break;
							}
						}

						/**********************************************************************/
						function LoadNotaTipo_3(caseLoad){
							//obtengo los valores
							let Sensores_tipo_3 = $("#idNotaTipo_3").val();
							//selecciono
							switch(Sensores_tipo_3) {
								//Texto Libre con Validacion
								case '11':
									document.getElementById('div_Validar_3').style.display = '';
								break;
								default:
									document.getElementById('div_Validar_3').style.display = 'none';
									//Reseteo los valores a 0
									if(caseLoad==1){
										document.querySelector('input[name="Validar_3"]').value = '';
									}
								break;
							}
						}

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_1">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//se crea filtro
	//verifico que sea un administrador
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Tipo Planilla</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){      $x1  = $Nombre;       }else{$x1  = '';}
					if(isset($cantPuntos)){  $x2  = $cantPuntos;   }else{$x2  = '';}
					if(isset($idTipo)){      $x3  = $idTipo;       }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 2, 1, 100);
					$Form_Inputs->form_select('Tipo Planilla','idTipo', $x3, 2, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idNota_1', 2, 2);
					$Form_Inputs->form_input_hidden('idNota_2', 2, 2);
					$Form_Inputs->form_input_hidden('idNota_3', 2, 2);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>

			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
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
			case 'npuntos_asc':   $order_by = 'cross_quality_calidad_matriz.cantPuntos ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N Puntos Ascendente'; break;
			case 'npuntos_desc':  $order_by = 'cross_quality_calidad_matriz.cantPuntos DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N Puntos Descendente';break;
			case 'nombre_asc':    $order_by = 'cross_quality_calidad_matriz.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
			case 'nombre_desc':   $order_by = 'cross_quality_calidad_matriz.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'estado_asc':    $order_by = 'core_estados.Nombre ASC ';                         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente'; break;
			case 'estado_desc':   $order_by = 'core_estados.Nombre DESC ';                        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
			case 'ops1_asc':      $order_by = 'ops1.Nombre ASC ';                                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Opciones 1 Ascendente'; break;
			case 'ops1_desc':     $order_by = 'ops1.Nombre DESC ';                                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Opciones 1 Descendente';break;
			case 'ops2_asc':      $order_by = 'ops2.Nombre ASC ';                                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Opciones 2 Ascendente'; break;
			case 'ops2_desc':     $order_by = 'ops2.Nombre DESC ';                                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Opciones 2 Descendente';break;
			case 'ops3_asc':      $order_by = 'ops3.Nombre ASC ';                                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Opciones 3 Ascendente'; break;
			case 'ops3_desc':     $order_by = 'ops3.Nombre DESC ';                                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Opciones 3 Descendente';break;
			case 'planilla_asc':  $order_by = 'core_cross_quality_analisis_calidad.Nombre ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Planilla Ascendente'; break;
			case 'planilla_desc': $order_by = 'core_cross_quality_analisis_calidad.Nombre DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Planilla Descendente';break;

			default: $order_by = 'cross_quality_calidad_matriz.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
		}
	}else{
		$order_by = 'cross_quality_calidad_matriz.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "cross_quality_calidad_matriz.idMatriz!=0";
	//verifico que sea un administrador
	$SIS_where.=" AND cross_quality_calidad_matriz.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){      $SIS_where .= " AND cross_quality_calidad_matriz.idEstado=".$_GET['idEstado'];}
	if(isset($_GET['cantPuntos']) && $_GET['cantPuntos']!=''){  $SIS_where .= " AND cross_quality_calidad_matriz.cantPuntos=".$_GET['cantPuntos'];}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){          $SIS_where .= " AND cross_quality_calidad_matriz.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['idNota_1']) && $_GET['idNota_1']!=''){      $SIS_where .= " AND cross_quality_calidad_matriz.idNota_1=".$_GET['idNota_1'];}
	if(isset($_GET['idNota_2']) && $_GET['idNota_2']!=''){      $SIS_where .= " AND cross_quality_calidad_matriz.idNota_2=".$_GET['idNota_2'];}
	if(isset($_GET['idNota_3']) && $_GET['idNota_3']!=''){      $SIS_where .= " AND cross_quality_calidad_matriz.idNota_3=".$_GET['idNota_3'];}
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){          $SIS_where .= " AND cross_quality_calidad_matriz.idTipo=".$_GET['idTipo'];}
	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idMatriz', 'cross_quality_calidad_matriz', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	cross_quality_calidad_matriz.idMatriz,
	cross_quality_calidad_matriz.Nombre,
	cross_quality_calidad_matriz.cantPuntos,
	core_estados.Nombre AS Estado,
	ops1.Nombre AS Opciones_1,
	ops2.Nombre AS Opciones_2,
	ops3.Nombre AS Opciones_3,
	core_cross_quality_analisis_calidad.Nombre AS Planilla,
	core_sistemas.Nombre AS RazonSocial,
	cross_quality_calidad_matriz.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_estados`                         ON core_estados.idEstado                        = cross_quality_calidad_matriz.idEstado
	LEFT JOIN `core_sistemas_opciones` ops1          ON ops1.idOpciones                              = cross_quality_calidad_matriz.idNota_1
	LEFT JOIN `core_sistemas_opciones` ops2          ON ops2.idOpciones                              = cross_quality_calidad_matriz.idNota_2
	LEFT JOIN `core_sistemas_opciones` ops3          ON ops3.idOpciones                              = cross_quality_calidad_matriz.idNota_3
	LEFT JOIN `core_cross_quality_analisis_calidad`  ON core_cross_quality_analisis_calidad.idTipo   = cross_quality_calidad_matriz.idTipo
	LEFT JOIN `core_sistemas`                        ON core_sistemas.idSistema                      = cross_quality_calidad_matriz.idSistema';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrMatriz = array();
	$arrMatriz = db_select_array (false, $SIS_query, 'cross_quality_calidad_matriz', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMatriz');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Tipo Planilla</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){     $x1  = $Nombre;      }else{$x1  = '';}
					if(isset($cantPuntos)){ $x2  = $cantPuntos;  }else{$x2  = '';}
					if(isset($idTipo)){     $x3  = $idTipo;      }else{$x3  = '';}
					if(isset($idNota_1)){   $x4  = $idNota_1;    }else{$x4  = '';}
					if(isset($idNota_2)){   $x5  = $idNota_2;    }else{$x5  = '';}
					if(isset($idNota_3)){   $x6  = $idNota_3;    }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
					$Form_Inputs->form_select_n_auto('Cantidad de Puntos','cantPuntos', $x2, 1, 1, 100);
					$Form_Inputs->form_select('Tipo Planilla','idTipo', $x3, 1, 'idTipo', 'Nombre', 'core_cross_quality_analisis_calidad', 0, '', $dbConn);
					$Form_Inputs->form_select('Nota Calidad','idNota_1', $x4, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Nota Condición','idNota_2', $x5, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Calificacion','idNota_3', $x6, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tipos Planillas</h5>
				<div class="toolbar">
					<?php
					//Se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Planilla</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=planilla_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=planilla_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">N° Puntos</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=npuntos_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=npuntos_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Nota Calidad</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ops1_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ops1_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Nota Condición</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ops2_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ops2_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Calificacion</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ops3_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ops3_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrMatriz as $maq) { ?>
							<tr class="odd">
								<td><?php echo $maq['Nombre']; ?></td>
								<td><?php echo $maq['Planilla']; ?></td>
								<td><label class="label <?php if(isset($maq['idEstado'])&&$maq['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $maq['Estado']; ?></label></td>
								<td><?php echo $maq['cantPuntos']; ?></td>
								<td><?php echo $maq['Opciones_1']; ?></td>
								<td><?php echo $maq['Opciones_2']; ?></td>
								<td><?php echo $maq['Opciones_3']; ?></td>
								<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $maq['RazonSocial']; ?></td><?php } ?>
								<td>
									<div class="btn-group" style="width: 140px;" >
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&idMatriz_2='.$maq['idMatriz']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&nombre_matriz='.$maq['Nombre'].'&clone_idMatriz='.$maq['idMatriz']; ?>" title="Clonar Tipo Planilla" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&idMatriz='.$maq['idMatriz']; ?>" title="Editar Matriz" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=4){
											$ubicacion = $location.'&del='.simpleEncode($maq['idMatriz'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar la matriz '.$maq['Nombre'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
				//se llama al paginador
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
